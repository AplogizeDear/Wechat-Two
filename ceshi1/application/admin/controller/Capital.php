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

use app\admin\model\RechargeModel;
use app\admin\model\OrderModel;
use think\Db;

class Capital extends Base {

    //充值
    public function recharge() {

        if (request()->isAjax()) {

            $param = input('param.');
            $param['add_time'] = strtotime($param['searchaddtime']);
            $param['end_time'] = strtotime($param['searchendtime']);
            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (!empty($param['searchText'])) {
                $where['b.nickname'] = ['like', '%' . $param['searchText'] . '%'];
            }
            if (!empty($param['add_time']) and ! empty($param['end_time'])) {
                $where['a.time'] = array('BETWEEN', array($param['add_time'], $param['end_time']));
            }
            if (!empty($param['add_time']) and empty($param['end_time'])) {
                $where['a.time'] = array('EGT', $param['add_time']);
            }
            if (empty($param['add_time']) and ! empty($param['end_time'])) {
                $where['a.time'] = array('ELT', $param['end_time']);
            }
            $where['a.c_id'] = $_SESSION['think']['c_id'];
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

        return $this->fetch();
    }

    //消费
    public function order() {
        if (request()->isAjax()) {

            $param = input('param.');

            $param['add_time'] = strtotime($param['searchaddtime']);
            $param['end_time'] = strtotime($param['searchendtime']);
            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (!empty($param['searchText'])) {
                $where['b.nickname'] = ['like', '%' . $param['searchText'] . '%'];
            }
            if (!empty($param['add_time']) and ! empty($param['end_time'])) {
                $where['a.time'] = array('BETWEEN', array($param['add_time'], $param['end_time']));
            }
            if (!empty($param['add_time']) and empty($param['end_time'])) {
                $where['a.time'] = array('EGT', $param['add_time']);
            }
            if (empty($param['add_time']) and ! empty($param['end_time'])) {
                $where['a.time'] = array('ELT', $param['end_time']);
            }
            $where['a.c_id'] = $_SESSION['think']['c_id'];
            $_SESSION['maps'] = $where;
            $order = new OrderModel();
            $selectResult = $order->getOrderByWhere($where, $offset, $limit);
            foreach ($selectResult as $key => $vo) {
                $selectResult[$key]['time'] = date('Y-m-d H:i:s', $vo['time']);
            }
            $return['total'] = $order->getAllOrder($where);  // 总数据
            $return['rows'] = $selectResult;

            return json($return);
        }
        return $this->fetch();
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

    //导出excel表格 linxsl 充值
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

}
