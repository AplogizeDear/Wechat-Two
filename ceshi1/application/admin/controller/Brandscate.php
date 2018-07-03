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

use app\admin\model\BrandscateModel;
use app\admin\model\UserModel;
use app\admin\model\SetModel;

class Brandscate extends Base {

    // 集团列表
    public function group() {

        if (request()->isAjax()) {

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (!empty($param['searchText'])) {
                $where['name'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $where['pid'] = 0;
            $where['level'] = 1;
            $brandscate = new BrandscateModel();
            $selectResult = $brandscate->getBrandscateByWhere($where, $offset, $limit);

            foreach ($selectResult as $key => $vo) {
                if ($vo['status'] == 1) {
                    $selectResult[$key]['status'] = "正常";
                } else {
                    $selectResult[$key]['status'] = "禁用";
                }
                $selectResult[$key]['add_time'] = date('Y-m-d H:i:s', $vo['add_time']);
                $selectResult[$key]['img'] = '<img src="' . $vo['img'] . '" width="40px" height="40px">';
                $selectResult[$key]['operate'] = showOperate($this->makeButton($vo['id']));
            }

            $return['total'] = $brandscate->getAllBrandscate($where);  // 总数据
            $return['rows'] = $selectResult;

            return json($return);
        }
        return $this->fetch();
    }

    // 添加集团
    public function groupAdd() {
        if (request()->isPost()) {
            $param = input('post.');
            unset($param['file']);
            $param['add_time'] = time();
            $param['pid'] = 0;
            $param['status'] = 1;
            $param['level'] = 1;
            if ($param['img'] == '') {
                return json(msg(-1, '', '图片未上传'));
            }
            $brandscate = new BrandscateModel();
            $flag = $brandscate->addBrandscate($param, 'group');
            parent::add_log('添加集团');
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
        return $this->fetch();
    }

    //编辑集团
    public function groupEdit() {
        $brandscate = new BrandscateModel();
        if (request()->isPost()) {
            $param = input('post.');
            unset($param['file']);
            if ($param['img'] == '') {
                return json(msg(-1, '', '海报未上传'));
            }
            $flag = $brandscate->editBrandscate($param, 'group');
            parent::add_log('id为' . $param['id'] . '的集团进行了修改');
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
        $id = input('param.id');
        $info = $brandscate->getOneBrandscate($id);
        $this->assign([
            'info' => $info
        ]);

        return $this->fetch();
    }

//删除集团
    public function groupDel() {
        $id = input('param.id');

        $brandscate = new BrandscateModel();
        $flag = $brandscate->delBrandscate($id);
        parent::add_log('id为' . $id . '的集团进行了删除');
        return json(msg($flag['code'], $flag['data'], $flag['msg']));
    }

// 品牌列表
    public function brand() {

        if (request()->isAjax()) {

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (!empty($param['searchText'])) {
                $where['name'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $where['level'] = 2;
            $brandscate = new BrandscateModel();
            $selectResult = $brandscate->getBrandscateByWhere($where, $offset, $limit);

            foreach ($selectResult as $key => $vo) {
                if ($vo['status'] == 1) {
                    $selectResult[$key]['status'] = "正常";
                } else {
                    $selectResult[$key]['status'] = "禁用";
                }
                $selectResult[$key]['add_time'] = date('Y-m-d H:i:s', $vo['add_time']);
                $selectResult[$key]['img'] = '<img src="' . $vo['img'] . '" width="40px" height="40px">';
                $selectResult[$key]['operate'] = showOperate($this->makeButtonb($vo['id']));
                $selectResult[$key]['gname'] = $brandscate->getGroupbyid($vo['pid']);
            }

            $return['total'] = $brandscate->getAllBrandscate($where);  // 总数据
            $return['rows'] = $selectResult;

            return json($return);
        }
        return $this->fetch();
    }

    // 添加品牌
    public function brandAdd() {
        $brandscate = new BrandscateModel();
        if (request()->isPost()) {
            $param = input('post.');
            unset($param['file']);
            $param['add_time'] = time();
            $param['status'] = 1;
            $param['level'] = 2;
            if ($param['img'] == '') {
                return json(msg(-1, '', '图片未上传'));
            }
            parent::add_log('添加品牌');
            $flag = $brandscate->addBrandscate($param, 'brand');

            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
        $info = $brandscate->getGroup();
        $this->assign([
            'info' => $info
        ]);
        return $this->fetch();
    }

    //编辑品牌
    public function brandEdit() {
        $brandscate = new BrandscateModel();
        if (request()->isPost()) {
            $param = input('post.');
            unset($param['file']);
            if ($param['img'] == '') {
                return json(msg(-1, '', '海报未上传'));
            }
            $flag = $brandscate->editBrandscate($param, 'brand');
            parent::add_log('id为' . $param['id'] . '的品牌进行了修改');
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
        $id = input('param.id');
        $info = $brandscate->getOneBrandscate($id);
        $infos = $brandscate->getGroup();
        $this->assign([
            'info' => $info
        ]);
        $this->assign([
            'info' => $info,
            'infos' => $infos
        ]);

        return $this->fetch();
    }

//删除品牌
    public function brandDel() {
        $id = input('param.id');

        $brandscate = new BrandscateModel();
        $flag = $brandscate->delBrandscate($id);
        parent::add_log('id为' . $id . '的品牌进行了删除');
        return json(msg($flag['code'], $flag['data'], $flag['msg']));
    }

    // 门店列表
    public function store() {

        if (request()->isAjax()) {

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (!empty($param['searchText'])) {
                $where['name'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $where['level'] = 3;
            $brandscate = new BrandscateModel();
            $selectResult = $brandscate->getBrandscateByWhere($where, $offset, $limit);

            foreach ($selectResult as $key => $vo) {
                if ($vo['status'] == 1) {
                    $selectResult[$key]['status'] = "正常";
                } else {
                    $selectResult[$key]['status'] = "禁用";
                }
                $selectResult[$key]['add_time'] = date('Y-m-d H:i:s', $vo['add_time']);
                $selectResult[$key]['img'] = '<img src="' . $vo['img'] . '" width="40px" height="40px">';
                $selectResult[$key]['operate'] = showOperate($this->makeButtons($vo['id']));
                $selectResult[$key]['bname'] = $brandscate->getGroupbyid($vo['pid']);
                $a = $brandscate->getOneBrandscate($vo['pid']);
                $selectResult[$key]['gname'] = $brandscate->getGroupbyid($a['pid']);
            }

            $return['total'] = $brandscate->getAllBrandscate($where);  // 总数据
            $return['rows'] = $selectResult;

            return json($return);
        }
        return $this->fetch();
    }

    // 门店品牌
    public function storeAdd() {
        $brandscate = new BrandscateModel();
        if (request()->isPost()) {
            $param = input('post.');
            unset($param['file']);
            $param['add_time'] = time();
            $param['status'] = 1;
            $param['level'] = 3;
            if ($param['img'] == '') {
                return json(msg(-1, '', '图片未上传'));
            }
            parent::add_log('添加门店');
            $flag = $brandscate->addBrandscate($param, 'store');

            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
        $info = $brandscate->getGroup();
        $this->assign([
            'info' => $info
        ]);
        return $this->fetch();
    }

    //编辑门店
    public function storeEdit() {
        $brandscate = new BrandscateModel();
        if (request()->isPost()) {
            $param = input('post.');
            unset($param['file']);
            if ($param['img'] == '') {
                return json(msg(-1, '', '海报未上传'));
            }
            $flag = $brandscate->editBrandscate($param, 'store');
            parent::add_log('id为' . $param['id'] . '的品牌进行了修改');
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
        $id = input('param.id');
        $info = $brandscate->getOneBrandscate($id);
        $infos = $brandscate->getGroup();
        $this->assign([
            'info' => $info,
            'infos' => $infos
        ]);

        return $this->fetch();
    }

//删除门店
    public function storeDel() {
        $id = input('param.id');

        $brandscate = new BrandscateModel();
        $flag = $brandscate->delBrandscate($id);
        parent::add_log('id为' . $id . '的门店进行了删除');
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

    //获取品牌信息
    public function getStore($id) {
        $brandscate = new BrandscateModel();
        $flag = $brandscate->getStorebyid($id);
        return $flag;
    }

    //分配管理员
    public function brandscateuser() {
        $user = new UserModel();
        $set = new SetModel();
        if (request()->isPost()) {
            $param = input('post.');
            $data['c_id'] = $param['id'];
            $c = json_encode($data);
            file_put_contents("test1.txt", $c);
            $where['id'] = $param['id'];
            $a = $set->findSet($where);
            if ($a) {
                $set->saveSet($where);
            } else {
                $set->addSet($where);
            }
            $flag = $user->updateStatus($data, $param['uid']);

            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
        $id = input('param.id');
        $info = $user->getadminuser();
        $this->assign([
            'info' => $info,
            'id' => $id
        ]);

        return $this->fetch();
    }

    /**
     * 拼装操作按钮集团
     * @param $id
     * @return array
     */
    private function makeButton($id) {
        return [
            '编辑' => [
                'auth' => 'brandscate/groupedit',
                'href' => url('brandscate/groupedit', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '删除' => [
                'auth' => 'brandscate/groupdel',
                'href' => "javascript:groupDel(" . $id . ")",
                'btnStyle' => 'danger',
                'icon' => 'fa fa-trash-o'
            ]
        ];
    }

    /**
     * 拼装操作按钮 品牌
     * @param $id
     * @return array
     */
    private function makeButtonb($id) {
        return [
            '编辑' => [
                'auth' => 'brandscate/brandedit',
                'href' => url('brandscate/brandedit', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '删除' => [
                'auth' => 'brandscate/branddel',
                'href' => "javascript:brandDel(" . $id . ")",
                'btnStyle' => 'danger',
                'icon' => 'fa fa-trash-o'
            ]
        ];
    }

    /**
     * 拼装操作按钮 门店
     * @param $id
     * @return array
     */
    private function makeButtons($id) {
        return [
            '编辑' => [
                'auth' => 'brandscate/storeedit',
                'href' => url('brandscate/storeedit', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '分配管理员' => [
                'auth' => 'brandscate/brandscateuser',
                'href' => url('brandscate/brandscateuser', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '删除' => [
                'auth' => 'brandscate/storedel',
                'href' => "javascript:storeDel(" . $id . ")",
                'btnStyle' => 'danger',
                'icon' => 'fa fa-trash-o'
            ]
        ];
    }

}
