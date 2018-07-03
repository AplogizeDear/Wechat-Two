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

use app\admin\model\OrderModel;
use app\admin\model\MemberModel;
use app\admin\model\SeatModel;
use app\admin\model\SetModel;
use app\admin\model\PointModel;

class Pay extends Base {

    // 买单列表
    public function index() {
        if (request()->isAjax()) {

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (!empty($param['searchText'])) {
                $where['b.nickname'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $where['a.c_id'] = $_SESSION['think']['c_id'];
            $order = new OrderModel();
            $member = new MemberModel();

            $selectResult = $order->getOrderByWhere($where, $offset, $limit);
            foreach ($selectResult as $key => $vo) {
                $selectResult[$key]['operate'] = showOperate($this->makeButton($vo['id']));
            }
            $return['total'] = $order->getAllOrder($where);  // 总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        return $this->fetch();
    }

    // 手动买单
    public function payAdd() {
        $member = new MemberModel();
        $seat = new SeatModel();
        $set = new SetModel();
        $point = new PointModel();
        if (request()->isPost()) {
            $param = input('post.');
            $param['status'] = 2;
            if ($param['m_id'] == '') {
                return json(msg(-1, '', '请选择用户'));
            }
            if ($param['s_id'] == 0) {
                return json(msg(-1, '', '请选择台桌'));
            }
            //获取的积分设定
            $sets = $set->getCon();
            //计算获得的积分
            $point_s = $sets['point'] * $param['pay'];
            $param['point'] = $point_s;
            //检查用户是否有余额去支付,并获取计算的余额,积分
            $balance = $member->checkMoney($param);

            if ($balance['code'] == 1 or $balance['code'] == -2) {
                return json(msg($balance['code'], $balance['data'], $balance['msg']));
            }
            $a = rand(100000, 1000000);
            $param['time'] = time();
            $param['order_id'] = date('YmdHis') . $a;
            $param['c_id'] = $_SESSION['think']['c_id'];
            $order = new OrderModel();
            $flag = $order->addOrder($param);
            $balance['msg']['id'] = $param['m_id'];

            if ($flag['code'] !== -1 or $flag['code'] !== -2) {
                $a = $member->payMoney($balance['msg']);
                if ($a == 1) {
                    $info['action_id'] = $flag['code'];
                    $info['type'] = 1;
                    $info['nums'] = $point_s;
                    $info['m_id'] = $param['m_id'];
                    $info['remark'] = $param['content'];
                    $point->addPoint($info);
                    parent::add_log('手动买单成功，订单id为：' . $flag['code']);
                    return json(msg(1, $flag['data'], $flag['msg']));
                } else {
                    return json(msg($a['code'], $a['data'], $a['msg']));
                }
            }
        }
        $infos = $seat->getSeat();
        $this->assign([
            'infos' => $infos
        ]);

        return $this->fetch();
    }

//买单修改
    public function payEdit() {
        $order = new OrderModel();
        $point = new PointModel();
        $set = new SetModel();
        $member = new MemberModel();
        if (request()->isPost()) {

            $param = input('post.');
            //获取的积分设定
            $sets = $set->getCon();
            //计算获得的积分
            $point_s = $sets['point'] * $param['pay'];
            $info = $order->getOneOrder($param['id']);
            $pay = $param['pay'] - $info['pay'];
            $points = $point->getPoint($param['id'], 1);
            $c = json_encode($points);
            file_put_contents("test1.txt", $c);
            $pointa = $point_s - $points['nums'];
            $pointss['nums'] = $point_s;
            $pointss['id'] = $points['id'];
            $a = $point->editPoint($pointss);
            $info = $member->getOneMember($param['m_id']);
            $infos['id'] = $param['m_id'];
            $infos['point'] = $info['point'] + $pay;
            $infos['money'] = $info['money'] - $pointa;
            $b = $member->payMoney($infos);
            $flag = $order->editOrder($param);
            parent::add_log('订单修改成功，订单id为：' . $param['id']);
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
        $id = input('param.id');
        $order = $order->getOneOrder($id);
        $info = $member->getnameMember($order['m_id']);
        $seat = new SeatModel();
        $infos = $seat->getnameSeat($order['s_id']);
        $order['nickname'] = $info;
        $order['seat'] = $infos;
        $this->assign([
            'order' => $order,
        ]);
        return $this->fetch();
    }

//买单删除
    public function payDel() {
        $id = input('param.id');
        $order = new OrderModel();
        $point = new PointModel();
        $set = new SetModel();
        $member = new MemberModel();
        $points = $point->getPoint($id, 1);
        $a = $order->getOneOrder($id);
        $b = $member->getOneMember($a['m_id']);
        $infos['id'] = $a['m_id'];
        $infos['point'] = $b['point'] - $points['nums'];
        $infos['money'] = $b['money'] + $a['pay'];
        $b = $member->payMoney($infos);
        $flag = $point->delPoint($points['id']);
        $flag = $order->delOrder($id);
        parent::add_log('订单删除成功，订单id为：' . $id);
        return json(msg($flag['code'], $flag['data'], $flag['msg']));
    }

    /**
     * 拼装操作按钮
     * @param $id
     * @return array
     */
    private function makeButton($id) {
        return [
            '编辑' => [
                'auth' => 'pay/payedit',
                'href' => url('pay/payedit', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '删除' => [
                'auth' => 'pay/paydel',
                'href' => "javascript:payDel(" . $id . ")",
                'btnStyle' => 'danger',
                'icon' => 'fa fa-trash-o'
            ]
        ];
    }

}
