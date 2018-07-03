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

use app\admin\model\RoleModel;
use app\admin\model\UserModel;

class User extends Base {

    //用户列表
    public function index() {
        if (request()->isAjax()) {

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (!empty($param['searchText'])) {
                $where['user_name'] = ['like', '%' . $param['searchText'] . '%'];
            }
            if ($_SESSION['think']['c_id'] !== 0) {
                $where['c_id'] = $_SESSION['think']['c_id'];
            }
            $user = new UserModel();
            $selectResult = $user->getUsersByWhere($where, $offset, $limit);

            $status = config('user_status');

            // 拼装参数
            foreach ($selectResult as $key => $vo) {

                $selectResult[$key]['last_login_time'] = date('Y-m-d H:i:s', $vo['last_login_time']);
                $selectResult[$key]['status'] = $status[$vo['status']];

                if (1 == $vo['id']) {
                    $selectResult[$key]['operate'] = '';
                    continue;
                }
                $selectResult[$key]['operate'] = showOperate($this->makeButton($vo['id']));
            }

            $return['total'] = $user->getAllUsers($where);  //总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        return $this->fetch();
    }

    // 添加用户
    public function userAdd() {
        if (request()->isPost()) {

            $param = input('post.');
            $param['c_id'] = $_SESSION['think']['c_id'];
            $param['password'] = md5($param['password']);
            $user = new UserModel();
            $flag = $user->insertUser($param);
            parent::add_log('新增用户');
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }

        $role = new RoleModel();
        $info = $role->getRole();
        if ($_SESSION['think']['c_id'] !== 0) {
            foreach ($info as $k => $v) {
                if ($v['id'] !== 1) {
                    $infos[$k] = $v;
                }
            }
        } else {
            $infos = $info;
        }
        $this->assign([
            'role' => $infos,
            'status' => config('user_status')
        ]);
        return $this->fetch();
    }

    // 编辑用户
    public function userEdit() {
        $user = new UserModel();

        if (request()->isPost()) {

            $param = input('post.');

            if (empty($param['password'])) {
                unset($param['password']);
            } else {
                $param['password'] = md5($param['password']);
            }
            $flag = $user->editUser($param);
            parent::add_log('编辑用户');
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }

        $id = input('param.id');
        $role = new RoleModel();

        $this->assign([
            'user' => $user->getOneUser($id),
            'status' => config('user_status'),
            'role' => $role->getRole()
        ]);
        return $this->fetch();
    }

    // 删除用户
    public function userDel() {
        $id = input('param.id');

        $role = new UserModel();
        $flag = $role->delUser($id);
        parent::add_log('删除用户');
        return json(msg($flag['code'], $flag['data'], $flag['msg']));
    }

// 修改用户密码
    public function userpasswordEdit() {
        $user = new UserModel();

        if (request()->isPost()) {

            $param = input('post.');

            if (empty($param['password'])) {
                unset($param['password']);
            } else {
                $param['password'] = md5($param['password']);
            }
            $flag = $user->editUser($param);

            return $this->fetch('/index');
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
                'auth' => 'user/useredit',
                'href' => url('user/userEdit', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '删除' => [
                'auth' => 'user/userdel',
                'href' => "javascript:userDel(" . $id . ")",
                'btnStyle' => 'danger',
                'icon' => 'fa fa-trash-o'
            ]
        ];
    }

}
