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

use app\admin\model\SeatModel;

class Seat extends Base {

    // 台桌列表
    public function index() {
        if (request()->isAjax()) {

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (!empty($param['searchText'])) {
                $where['name'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $where['c_id'] = $_SESSION['think']['c_id'];
            $article = new SeatModel();
            $selectResult = $article->getSeatByWhere($where, $offset, $limit);

            foreach ($selectResult as $key => $vo) {
                $selectResult[$key]['operate'] = showOperate($this->makeButton($vo['id']));
            }

            $return['total'] = $article->getAllSeat($where);  // 总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        return $this->fetch();
    }

    // 添加台桌
    public function seatAdd() {
        if (request()->isPost()) {
            $param = input('post.');

            $article = new SeatModel();
            $param['c_id'] = $_SESSION['think']['c_id'];
            $flag = $article->addSeat($param);
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }

        return $this->fetch();
    }

//修改台桌
    public function seatEdit() {
        $seat = new SeatModel();
        if (request()->isPost()) {

            $param = input('post.');
            $flag = $seat->editSeat($param);

            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }

        $id = input('param.id');
        $info = $seat->getOneSeat($id);
        $this->assign([
            'seat' => $info
        ]);
        return $this->fetch();
    }

//删除台桌
    public function seatDel() {
        $id = input('param.id');

        $seat = new SeatModel();
        $flag = $seat->delSeat($id);
        return json(msg($flag['code'], $flag['data'], $flag['msg']));
    }

    // 上传缩略图
    public function uploadImg() {
        if (request()->isAjax()) {

            $file = request()->file('file');
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'upload');
            if ($info) {
                $src = '/upload' . '/' . date('Ymd') . '/' . $info->getFilename();
                return json(msg(0, ['src' => $src], ''));
            } else {
                // 上传失败获取错误信息
                return json(msg(-1, '', $file->getError()));
            }
        }
    }

    /**
     * 拼装操作按钮
     * @param $id
     * @return array
     */
    private function makeButton($id) {
        return [
            '编辑' => [
                'auth' => 'seat/seatedit',
                'href' => url('seat/seatedit', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '删除' => [
                'auth' => 'seat/seatadd',
                'href' => "javascript:seatDel(" . $id . ")",
                'btnStyle' => 'danger',
                'icon' => 'fa fa-trash-o'
            ]
        ];
    }

}
