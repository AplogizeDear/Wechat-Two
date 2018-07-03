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

use app\admin\model\WinetypeModel;
use app\admin\model\WinebrandModel;
use think\Db;

class Winetype extends Base {

    // 酒种类列表
    public function index() {
        if (request()->isAjax()) {

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (!empty($param['searchText'])) {
                $where['title'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $where['c_id'] = $_SESSION['think']['c_id'];
            $winetype = new WinetypeModel();
            $selectResult = $winetype->getWinetypeByWhere($where, $offset, $limit);

            foreach ($selectResult as $key => $vo) {
                $selectResult[$key]['image'] = '<img src="' . $vo['image'] . '" width="40px" height="40px">';
                $selectResult[$key]['image1'] = '<img src="' . $vo['image1'] . '" width="40px" height="40px">';
                $selectResult[$key]['operate'] = showOperate($this->makeButton($vo['id']));
            }

            $return['total'] = $winetype->getAllWinetype($where);  // 总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        return $this->fetch();
    }

    // 添加酒种类
    public function winetypeAdd() {
        if (request()->isPost()) {
            $param = input('post.');
            if ($param['image'] == '') {
                return json(msg(-1, '', '图片未上传'));
            }
            $param['c_id'] = $_SESSION['think']['c_id'];
            $winetype = new WinetypeModel();
            $flag = $winetype->addWinetype($param);
            parent::add_log('添加酒种类');
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }

        return $this->fetch();
    }

//修改酒种类
    public function winetypeEdit() {
        $winetype = new WinetypeModel();
        if (request()->isPost()) {

            $param = input('post.');
            unset($param['file']);
            $flag = $winetype->editWinetype($param);
            parent::add_log('修改酒种类');
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }

        $id = input('param.id');
        $this->assign([
            'winetype' => $winetype->getOneWinetype($id)
        ]);
        return $this->fetch();
    }

//删除酒种类
    public function winetypeDel() {
        $id = input('param.id');

        $winetype = new WinetypeModel();
        $flag = $winetype->delWinetype($id);
        parent::add_log('删除酒种类');
        return json(msg($flag['code'], $flag['data'], $flag['msg']));
    }

    //通过酒种类id获取所属酒品牌及酒有效期
    public function winebrandGet($id) {
        $winebrand = new WinebrandModel();
        $winetype = new WinetypeModel();
        $a = $winetype->getOneWinetype($id);
        $flag['info'] = $winebrand->getWinebrand($id);
        $flag['useday'] = $a['use_day'];
        return $flag;
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
     * 拼装操作按钮 酒种类
     * @param $id
     * @return array
     */
    private function makeButton($id) {
        return [
            '编辑' => [
                'auth' => 'winetype/winetypeedit',
                'href' => url('winetype/winetypeedit', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '删除' => [
                'auth' => 'winetype/winetypedel',
                'href' => "javascript:winetypeDel(" . $id . ")",
                'btnStyle' => 'danger',
                'icon' => 'fa fa-trash-o'
            ]
        ];
    }

    // 酒品牌列表
    public function winebrand() {
        if (request()->isAjax()) {

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (!empty($param['searchText'])) {
                $where['a.name'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $where['a.c_id'] = $_SESSION['think']['c_id'];
            $winebrand = new WinebrandModel();
            $selectResult = $winebrand->getWinebrandByWhere($where, $offset, $limit);
            foreach ($selectResult as $key => $vo) {
                $selectResult[$key]['operate'] = showOperate($this->makeButtons($vo['id']));
            }

            $return['total'] = $winebrand->getAllWinebrand($where);  // 总数据
            $return['rows'] = $selectResult;
            return json($return);
        }

        return $this->fetch();
    }

    // 添加酒品牌
    public function winebrandAdd() {
        if (request()->isPost()) {
            $param = input('post.');
            if ($param['t_id'] == 0) {
                return json(msg(-1, '', '请选择酒种类'));
            }
            $param['c_id'] = $_SESSION['think']['c_id'];
            $winebrand = new WinebrandModel();
            $flag = $winebrand->addWinebrand($param);
            parent::add_log('添加酒品牌');
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
        $winetype = new WinetypeModel();
        $type = $winetype->getWinetype();
        $this->assign([
            'type' => $type
        ]);
        return $this->fetch();
    }

//酒品牌编辑
    public function winebrandEdit() {
        $winebrand = new WinebrandModel();
        if (request()->isPost()) {

            $param = input('post.');
            $flag = $winebrand->editWinebrand($param);
            parent::add_log('修改酒品牌');
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }

        $id = input('param.id');
        $this->assign([
            'winebrand' => $winebrand->getOneWinebrand($id)
        ]);
        return $this->fetch();
    }

//酒品牌删除
    public function winebrandDel() {
        $id = input('param.id');

        $winebrand = new WinebrandModel();
        $flag = $winebrand->delWinebrand($id);
        parent::add_log('删除酒品牌');
        return json(msg($flag['code'], $flag['data'], $flag['msg']));
    }

    /**
     * 拼装操作按钮 酒品牌
     * @param $id
     * @return array
     */
    private function makeButtons($id) {
        return [
            '编辑' => [
                'auth' => 'winetype/winebrandedit',
                'href' => url('winetype/winebrandedit', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '删除' => [
                'auth' => 'winetype/winebranddel',
                'href' => "javascript:winebrandDel(" . $id . ")",
                'btnStyle' => 'danger',
                'icon' => 'fa fa-trash-o'
            ]
        ];
    }

}
