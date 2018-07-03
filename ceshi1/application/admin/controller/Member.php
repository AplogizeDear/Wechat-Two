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

use app\admin\model\MemberModel;
use app\admin\model\PointModel;
use app\admin\model\RechargeModel;
use app\admin\model\OrderModel;
use think\Db;

class Member extends Base {

    // 用户列表
    public function index() {
        if (request()->isAjax()) {

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (!empty($param['searchText'])) {
                $where['nickname'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $where['c_id'] = $_SESSION['think']['c_id'];
            $member = new MemberModel();
            $selectResult = $member->getMemberByWhere($where, $offset, $limit);

            foreach ($selectResult as $key => $vo) {
                $selectResult[$key]['avatar'] = '<img src="' . $vo['avatar'] . '" width="40px" height="40px">';
                $selectResult[$key]['operate'] = showOperate($this->makeButton($vo['id']));
            }

            $return['total'] = $member->getAllMember($where);  // 总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        return $this->fetch();
    }

    //用户修改
    public function memberEdit() {
        $member = new MemberModel();
        if (request()->isPost()) {

            $param = input('post.');
            unset($param['file']);
            $flag = $member->editMember($param);
            parent::add_log('修改id为' . $param['id'] . '的用户的积分为' . $param['point'] . '，余额为' . $param['money']);
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }

        $id = input('param.id');
        $this->assign([
            'member' => $member->getOneMember($id)
        ]);
        return $this->fetch();
    }

    //积分详情
    public function point() {

        if (request()->isAjax()) {

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (!empty($param['searchid'])) {
                $where['m_id'] = $param['searchid'];
            }
            $_SESSION['maps'] = $where;
            $point = new PointModel();
            $selectResult = $point->getPointByWhere($where, $offset, $limit);

            foreach ($selectResult as $key => $vo) {
                if ($vo['type'] == 1) {
                    $selectResult[$key]['type'] = '消费';
                } elseif ($vo['type'] == 2) {
                    $selectResult[$key]['type'] = '充值';
                } elseif ($vo['type'] == 3) {
                    $selectResult[$key]['type'] = '注册';
                }
                $selectResult[$key]['operate'] = showOperate($this->makeButton($vo['id']));
            }

            $return['total'] = $point->getAllPoint($where);  // 总数据
            $return['rows'] = $selectResult;

            return json($return);
        }
        $a = input('param.');
        $this->assign('id', $a['id']);
        return $this->fetch();
    }

    //充值详情
    public function recharge() {

        if (request()->isAjax()) {

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (!empty($param['searchid'])) {
                $where['a.m_id'] = $param['searchid'];
            }
            if (!empty($param['searchText'])) {
                $where['b.nickname'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $_SESSION['maps'] = $where;
            $recharge = new RechargeModel();
            $selectResult = $recharge->getRechargeByWhere($where, $offset, $limit);
            foreach ($selectResult as $key => $vo) {
                $selectResult[$key]['time'] = date('Y-m-d H:i:s', $vo['time']);
            }
            $return['total'] = $recharge->getAllRecharge($where);  // 总数据
            $return['rows'] = $selectResult;

            return json($return);
        }
        $a = input('param.');
        $this->assign('id', $a['id']);
        return $this->fetch();
    }

    //消费详情
    public function order() {

        if (request()->isAjax()) {

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];

            if (!empty($param['searchid'])) {
                $where['a.m_id'] = $param['searchid'];
            }
            if (!empty($param['searchText'])) {
                $where['b.nickname'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $_SESSION['maps'] = $where;
            $order = new OrderModel();
            $selectResult = $order->getOrderByWhere($where, $offset, $limit);
            foreach ($selectResult as $key => $vo) {
                if ($vo['status'] == 1) {
                    $selectResult[$key]['status'] = "未完成";
                } elseif ($vo['status'] == 2) {
                    $selectResult[$key]['status'] = "已完成";
                }
                $selectResult[$key]['time'] = date('Y-m-d H:i:s', $vo['time']);
                $selectResult[$key]['operate'] = showOperate($this->makeButton($vo['id']));
            }
            $return['total'] = $order->getAllOrder($where);  // 总数据
            $return['rows'] = $selectResult;

            return json($return);
        }
        $a = input('param.');
        $this->assign('id', $a['id']);
        return $this->fetch();
    }

    // 获取用户
    public function giveMember() {
        $param = input('param.');
        $member = new MemberModel();
        // 获取现在的权限
        if ('get' == $param['type']) {
            $member = $member->getMember();
            return json(msg(1, $member, 'success'));
        }
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
                'auth' => 'member/memberedit',
                'href' => url('member/memberedit', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '积分详情' => [
                'auth' => 'member/point',
                'href' => url('member/point', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '充值详情' => [
                'auth' => 'member/recharge',
                'href' => url('member/recharge', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '消费详情' => [
                'auth' => 'member/order',
                'href' => url('member/order', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '酒卡列表' => [
                'auth' => 'stock/index',
                'href' => url('stock/index', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ]
        ];
    }

    //导出excel表格 linxsl 消费
    public function output_excel_order() {
        if (isset($_SESSION['maps'])) {
            $where = $_SESSION['maps'];
        } else {
            $where = "";
        }
        $xlsName = "order";
        $xlsCell = array(
            array('id', '订单ID'),
            array('m_id', '用户ID'),
            array('nickname', '用户昵称'),
            array('order_id', '订单号'),
            array('pay', '消费金额'),
            array('time', '新增时间'),
            array('content', '消费内容'),
            array('s_id', '台桌id')
        );

        $xlsData = Db::table('snake_order')->alias('a')->join('snake_member b', 'a.m_id = b.id')->field('a.*,b.nickname')->where($where)->order('a.id desc')->select();

        if (count($xlsData) <= 0) {
            $this->error('无数据导出');
        }

        $dataNum = count($xlsData);
        $time = time();
        for ($i = 0; $i < $dataNum; $i++) {
            $xlsData[$i]['id'] = $xlsData[$i]['id'];
            $xlsData[$i]['m_id'] = $xlsData[$i]['m_id'];
            $xlsData[$i]['nickname'] = $xlsData[$i]['nickname'];
            $xlsData[$i]['order_id'] = $xlsData[$i]['order_id'];
            $xlsData[$i]['pay'] = $xlsData[$i]['pay'];
            $xlsData[$i]['time'] = date('Y-m-d H:i:s', $xlsData[$i]['time']);
            $xlsData[$i]['s_id'] = $xlsData[$i]['s_id'];
            $xlsData[$i]['content'] = $xlsData[$i]['content'];
        }
        unset($_SESSION['maps']);
        $top_title = '消费流水表';
        $this->exportExcel($xlsName, $xlsCell, $xlsData, $top_title);
    }

    //导出excel表格 linxsl  充值
    public function output_excel_recharge() {
        if (isset($_SESSION['maps'])) {
            $where = $_SESSION['maps'];
        } else {
            $where = "";
        }
        $xlsName = "order";
        $xlsCell = array(
            array('id', '订单ID'),
            array('m_id', '用户ID'),
            array('nickname', '用户昵称'),
            array('pay_id', '微信订单号'),
            array('order_id', '充值单号'),
            array('recharge', '充值金额'),
            array('present', '赠送金额'),
            array('time', '充值时间')
        );

        $xlsData = Db::table('snake_recharge')->alias('a')->join('snake_member b', 'a.m_id = b.id', 'left')->field('a.*,b.nickname')->where($where)->order('a.id desc')->select();

        if (count($xlsData) <= 0) {
            $this->error('无数据导出');
        }

        $dataNum = count($xlsData);
        $time = time();
        for ($i = 0; $i < $dataNum; $i++) {
            $xlsData[$i]['id'] = $xlsData[$i]['id'];
            $xlsData[$i]['m_id'] = $xlsData[$i]['m_id'];
            $xlsData[$i]['nickname'] = $xlsData[$i]['nickname'];
            $xlsData[$i]['order_id'] = $xlsData[$i]['order_id'];
            $xlsData[$i]['pay_id'] = $xlsData[$i]['pay_id'];
            $xlsData[$i]['time'] = date('Y-m-d H:i:s', $xlsData[$i]['time']);
            $xlsData[$i]['recharge'] = $xlsData[$i]['recharge'];
            $xlsData[$i]['present'] = $xlsData[$i]['present'];
        }
        unset($_SESSION['maps']);
        $top_title = '充值流水表';
        $this->exportExcel($xlsName, $xlsCell, $xlsData, $top_title);
    }

    //导出excel表格 linxsl  积分
    public function output_excel_point() {
        if (isset($_SESSION['maps'])) {
            $where = $_SESSION['maps'];
        } else {
            $where = "";
        }
        $xlsName = "order";
        $xlsCell = array(
            array('id', '订单ID'),
            array('nums', '积分数量'),
            array('type', '类型'),
            array('remark', '备注'),
            array('action_id', '对应动作id'),
        );

        $xlsData = Db::table('snake_point')->where($where)->order('id desc')->select();

        if (count($xlsData) <= 0) {
            $this->error('无数据导出');
        }

        $dataNum = count($xlsData);
        $time = time();
        for ($i = 0; $i < $dataNum; $i++) {
            $xlsData[$i]['id'] = $xlsData[$i]['id'];
            $xlsData[$i]['nums'] = $xlsData[$i]['nums'];
            $xlsData[$i]['remark'] = $xlsData[$i]['remark'];
            $xlsData[$i]['action_id'] = $xlsData[$i]['action_id'];
            if ($xlsData[$i]['type'] == 1) {
                $xlsData[$i]['type'] = '消费';
            } elseif ($xlsData[$i]['type'] == 2) {
                $xlsData[$i]['type'] = '充值';
            } elseif ($xlsData[$i]['type'] == 3) {
                $xlsData[$i]['type'] = '注册';
            }
        }
        unset($_SESSION['maps']);
        $top_title = '积分流水表';
        $this->exportExcel($xlsName, $xlsCell, $xlsData, $top_title);
    }

}
