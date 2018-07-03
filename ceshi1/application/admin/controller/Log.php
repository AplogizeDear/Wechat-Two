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

use app\admin\model\LogModel;
use think\Db;

class Log extends Base {

    // 活动列表
    public function index() {

        if (request()->isAjax()) {

            $param = input('param.');
            $param['add_time'] = strtotime($param['searchaddtime']);
            $param['end_time'] = strtotime($param['searchendtime']);
            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (!empty($param['searchText'])) {
                $where['username'] = ['like', '%' . $param['searchText'] . '%'];
            }
            if (!empty($param['add_time']) and ! empty($param['end_time'])) {
                $where['add_time'] = array('BETWEEN', array($param['add_time'], $param['end_time']));
            }
            if (!empty($param['add_time']) and empty($param['end_time'])) {
                $where['add_time'] = array('EGT', $param['add_time']);
            }
            if (empty($param['add_time']) and ! empty($param['end_time'])) {
                $where['add_time'] = array('ELT', $param['end_time']);
            }
            if($_SESSION['think']['c_id'] !== 0){
               $where['c_id'] = $_SESSION['think']['c_id']; 
            }
            $_SESSION['maps'] = $where;
            $log = new LogModel();
            $selectResult = $log->getLogByWhere($where, $offset, $limit);

            foreach ($selectResult as $key => $vo) {
                $selectResult[$key]['add_time'] = date('Y-m-d H:i:s', $vo['add_time']);
            }

            $return['total'] = $log->getAllLog($where);  // 总数据
            $return['rows'] = $selectResult;

            return json($return);
        }
        return $this->fetch();
    }
    //导出excel表格 linxsl 日志
    public function output_excel_log() {
        if (isset($_SESSION['maps'])) {
            $where = $_SESSION['maps'];
        } else {
            $where = "";
        }
        $xlsName = "order";
        $xlsCell = array(
            array('id', '日志ID'),
            array('username', '操作者'),
            array('content', '操作内容'),
            array('add_ip', '操作IP'),
            array('add_time', '新增时间'),
        );
        $xlsData = Db::table('snake_log')->where($where)->order('id desc')->select();

        if (count($xlsData) <= 0) {
            $this->error('无数据导出');
        }

        $dataNum = count($xlsData);
        $time = time();
        for ($i = 0; $i < $dataNum; $i++) {
            $xlsData[$i]['id'] = $xlsData[$i]['id'];
            $xlsData[$i]['username'] = $xlsData[$i]['username'];
            $xlsData[$i]['content'] = $xlsData[$i]['content'];
            $xlsData[$i]['add_ip'] = $xlsData[$i]['add_ip'];
            $xlsData[$i]['add_time'] = date('Y-m-d H:i:s', $xlsData[$i]['add_time']);
        }
        unset($_SESSION['maps']);
        $top_title = '日志';
        $this->exportExcel($xlsName, $xlsCell, $xlsData, $top_title);
    }

}
