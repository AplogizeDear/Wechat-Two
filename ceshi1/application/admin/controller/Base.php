<?php

// +----------------------------------------------------------------------
// | snake
// +----------------------------------------------------------------------
// | Copyright (c) 2016~2022 http://baiyf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: NickBai <1902822973@qq.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\Db;
use think\Controller;

class Base extends Controller {

    public function _initialize() {
        if (empty(session('username'))) {

            $loginUrl = url('login/index');
            if (request()->isAjax()) {
                return msg(111, $loginUrl, '登录超时');
            }

            $this->redirect($loginUrl);
        }

        // 检测权限
        $control = lcfirst(request()->controller());
        $action = lcfirst(request()->action());

        if (empty(authCheck($control . '/' . $action))) {
            if (request()->isAjax()) {
                return msg(403, '', '您没有权限');
            }

            $this->error('403 您没有权限');
        }

        $this->assign([
            'username' => session('username'),
            'rolename' => session('role')
        ]);
    }

    /* 添加后台操作日志 */

    public function add_log($content, $log_detail = '') {
        $data['username'] = session('username');
        $data['c_id'] = session('c_id');
        $data['content'] = $content;
        $data['add_ip'] = $this->request->ip();
        $data['add_time'] = time();
        $data['log_detail'] = $log_detail;
        Db::name('log')->insert($data);
    }

    /* 文件导出 */

    public function exportExcel($expTitle, $expCellName, $expTableData, $top_title) {

        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle); //文件名称

        $fileName = '' . $top_title . '' . date('_YmdHis');

        $cellNum = count($expCellName);

        $dataNum = count($expTableData);

        vendor("phpoffice.phpexcel.Classes.PHPExcel");

        $objPHPExcel = new \PHPExcel();

        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');

        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(22);

        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);

        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);

        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);

        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);

        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);

        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);

        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(25);

        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(22);

        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(12);

        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);

        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:' . $cellName[$cellNum - 1] . '1');

        //合并单元格

        $objPHPExcel->getActiveSheet()->setCellValue('A1', '' . $top_title . '')->getStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        for ($i = 0; $i < $cellNum; $i++) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i] . '2', $expCellName[$i][1]);
        }

        for ($i = 0; $i < $dataNum; $i++) {
            for ($j = 0; $j < $cellNum; $j++) {
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j] . ($i + 3), " " . $expTableData[$i][$expCellName[$j][0]]);
            }
        }

        ob_end_clean(); //清除缓冲区,避免乱码

        header('pragma:public');

        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="' . $xlsTitle . '.csv"');

        header("Content-Disposition:attachment;filename=$fileName.csv");

        //attachment新窗口打印inline本窗口打印

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output');

        exit;
    }
    //排序
    public function my_sort($arrays, $sort_key, $sort_order = SORT_ASC, $sort_type = SORT_NUMERIC) {
        if (is_array($arrays)) {
            foreach ($arrays as $array) {
                if (is_array($array)) {
                    $key_arrays[] = $array[$sort_key];
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
        array_multisort($key_arrays, $sort_order, $sort_type, $arrays);
        return $arrays;
    }
}
