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

use app\admin\model\KeepoutModel;
use app\admin\model\KeepoutinfoModel;
use app\admin\model\MemberModel;
use app\admin\model\SeatModel;
use app\admin\model\UserModel;
use app\admin\model\WinetypeModel;
use app\admin\model\WinebrandModel;
use app\admin\model\StockModel;

class Keepout extends Base {

    // 存取酒列表
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
            $where['a.status'] = 2;
            $keepout = new KeepoutModel();
            $user = new UserModel();
            $seat = new SeatModel();
            $selectResult = $keepout->getKeepoutByWhere($where, $offset, $limit);
            foreach ($selectResult as $key => $vo) {
                $waiter = $user->getOneUser($vo['w_id']);
                $seats = $seat->getOneSeat($vo['s_id']);
                $selectResult[$key]['time'] = date('Y-m-d H:i:s', $vo['time']);
                $selectResult[$key]['waiter'] = $waiter['user_name'];
                $selectResult[$key]['seat'] = $seats['name'];
                if ($vo['type'] == 1) {
                    $selectResult[$key]['operate'] = showOperate($this->makeButton($vo['id']));
                    $selectResult[$key]['type'] = '<button class="button_s">存酒</button>';
                } elseif ($vo['type'] == 2) {
                    $selectResult[$key]['operate'] = showOperate($this->makeButtons($vo['id']));
                    $selectResult[$key]['type'] = '<button class="button_s" style="background-color:red">取酒</button>';
                }
                if ($vo['status'] == 1) {
                    $selectResult[$key]['status'] = '未完成';
                } elseif ($vo['status'] == 2) {
                    $selectResult[$key]['status'] = '已完成';
                }
            }

            $return['total'] = $keepout->getAllKeepout($where);  // 总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        return $this->fetch();
    }
    
    // 服务员发起的存酒列表
    public function waiterindex() {
        if (request()->isAjax()) {

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (!empty($param['searchText'])) {
                $where['b.nickname'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $where['a.c_id'] = $_SESSION['think']['c_id'];
            $where['a.status'] = 1;
            $keepout = new KeepoutModel();
            $user = new UserModel();
            $seat = new SeatModel();
            $selectResult = $keepout->getKeepoutByWhere($where, $offset, $limit);
            foreach ($selectResult as $key => $vo) {
                $waiter = $user->getOneUser($vo['w_id']);
                $seats = $seat->getOneSeat($vo['s_id']);
                $selectResult[$key]['time'] = date('Y-m-d H:i:s', $vo['time']);
                $selectResult[$key]['waiter'] = $waiter['user_name'];
                $selectResult[$key]['seat'] = $seats['name'];
                if ($vo['type'] == 1) {
                    $selectResult[$key]['operate'] = showOperate($this->makeButtonsss($vo['id']));
                    $selectResult[$key]['type'] = '<button class="button_s">存酒</button>';
                }
                if ($vo['status'] == 1) {
                    $selectResult[$key]['status'] = '未完成';
                } elseif ($vo['status'] == 2) {
                    $selectResult[$key]['status'] = '已完成';
                }
            }

            $return['total'] = $keepout->getAllKeepout($where);  // 总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        return $this->fetch();
    }

    // 手动存酒
    public function keepAdd() {
        $stock = new StockModel();
        $winetype = new WinetypeModel();
        $keepoutinfo = new KeepoutinfoModel();
        $keepout = new KeepoutModel();
        if (request()->isPost()) {
            $param = input('post.');
            if ($param['mid'] == '') {
                return json(msg(-1, '', '请选择用户'));
            }
            if ($param['wid'] == 0) {
                return json(msg(-1, '', '请选择服务员'));
            }
            if ($param['sid'] == 0) {
                return json(msg(-1, '', '请选择台桌'));
            }
            $a['s_id'] = $param['sid'];
            $a['w_id'] = $param['wid'];
            $a['m_id'] = $param['mid'];
            $a['time'] = time();
            $a['type'] = 1;
            $a['status'] = 2;
            $a['c_id'] = $_SESSION['think']['c_id'];
            unset($param['sid']);
            unset($param['wid']);
            unset($param['mid']);
            unset($param['mids']);
            foreach ($param as $k => $v) {
                $b = explode('_', $k);
                $arr[$b[1]][$b[0]] = $v;
                $arr[$b[1]]['mid'] = $a['m_id'];
                if ($b[0] == 'useday') {
                    $arr[$b[1]]['use_day'] = strtotime(date("Y-m-d"), time()) + 60 * 60 * 24 + $v * 60 * 60 * 24;
                }
            }
            foreach ($arr as $v) {
                if ($v['tid'] == 0) {
                    return json(msg(-1, '', '请选择酒种类'));
                }
                if ($v['bid'] == 0) {
                    return json(msg(-1, '', '请选择酒品牌'));
                }
            }
            $c = json_encode($arr);
            file_put_contents("test1.txt", $c);
            //查看库存是否存在，传入库存id
            $ids = $stock->checkStock($arr);
            $k_id = $keepout->addKeepout($a);
            $flag = $keepoutinfo->addKeepoutinfo($k_id, $ids, 1);

            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
        $member = new MemberModel();
        $info_m = $member->getMember();
        $seat = new SeatModel();
        $info_s = $seat->getSeat();
        $user = new UserModel();
        $info_w = $user->getWiteruser();
        $winetype = new WinetypeModel();
        $info_t = $winetype->getWinetype();
        $this->assign([
            'info_m' => $info_m,
            'info_s' => $info_s,
            'info_w' => $info_w,
            'info_t' => $info_t,
        ]);
        return $this->fetch();
    }

    // 手动取酒
    public function outAdd() {
        $stock = new StockModel();
        $winetype = new WinetypeModel();
        $keepoutinfo = new KeepoutinfoModel();
        $keepout = new KeepoutModel();
        if (request()->isPost()) {
            $param = input('post.');
            if ($param['mid'] == '') {
                return json(msg(-1, '', '请选择用户'));
            }
            if ($param['wid'] == 0) {
                return json(msg(-1, '', '请选择服务员'));
            }
            if ($param['sid'] == 0) {
                return json(msg(-1, '', '请选择台桌'));
            }

            $a['s_id'] = $param['sid'];
            $a['w_id'] = $param['wid'];
            $a['m_id'] = $param['mid'];
            $a['time'] = time();
            $a['type'] = 2;
            $a['status'] = 2;
            $a['c_id'] = $_SESSION['think']['c_id'];
            unset($param['sid']);
            unset($param['wid']);
            unset($param['mid']);
            unset($param['mids']);
            if ($param == []) {
                return json(msg(-1, '', '无存酒'));
            }
            foreach ($param as $k => $v) {
                $b = explode('_', $k);
                $arr[$b[1]][$b[0]] = $v;
                $arr[$b[1]]['mid'] = $a['m_id'];
            }
            $info = '';
            foreach ($arr as $k => $v) {
                if ($v['num'] != 0 or $v['nums'] != 0) {
                    $info[$k] = $v;
                }
            }
            if ($info == '') {
                return json(msg(-1, '', '请填写酒的数量'));
            }
            $flag = $stock->checkoutStock($arr);
            if ($flag['code'] == -1) {
                return json(msg($flag['code'], $flag['data'], $flag['msg']));
            }
            $k_id = $keepout->addKeepout($a);
            $a = $stock->outStock($info);
            $flag = $keepoutinfo->addKeepoutinfo($k_id, $info, 2);
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
        $member = new MemberModel();
        $info_m = $member->getMember();
        $seat = new SeatModel();
        $info_s = $seat->getSeat();
        $user = new UserModel();
        $info_w = $user->getWiteruser();
        $info_t = $winetype->getWinetype();
        $this->assign([
            'info_m' => $info_m,
            'info_s' => $info_s,
            'info_w' => $info_w,
            'info_t' => $info_t,
        ]);
        return $this->fetch();
    }

    //根据用户id获取存酒信息
    public function stockGet($id) {
        $stock = new StockModel();
        $arr = $stock->getStock($id);
        $winetype = new WinetypeModel();
        $winebrand = new WinebrandModel();
        $info = array();
        foreach ($arr as $k => $v) {
            $type = $winetype->getOneWinetype($v['t_id']);
            $brand = $winebrand->getOneWinebrand($v['b_id']);
            if ($v['num'] > 0 or $v['nums'] > 0) {
                $info[$k]['id'] = $v['id'];
                $info[$k]['b_id'] = $v['b_id'];
                $info[$k]['t_id'] = $v['t_id'];
                $info[$k]['num'] = $v['num'];
                $info[$k]['nums'] = $v['nums'];
                $info[$k]['use_day'] = ($v['use_day'] - strtotime(date("Y-m-d"), time())) / 86400;
                $info[$k]['type'] = $type['title'];
                $info[$k]['brand'] = $brand['name'];
            }
        }
        $infos = $this->my_sort($info, 'use_day', $sort_order = SORT_DESC);
        return $infos;
    }

//取酒编辑
    public function outEdit() {
        $stock = new StockModel();
        $winetype = new WinetypeModel();
        $winebrand = new WinebrandModel();
        $keepoutinfo = new KeepoutinfoModel();
        $keepout = new KeepoutModel();
        $member = new MemberModel();
        $seat = new SeatModel();
        $user = new UserModel();
        if (request()->isPost()) {
            $param = input('post.');
            foreach ($param as $k => $v) {
                $b = explode('_', $k);
                $arr[$b[1]][$b[0]] = $v;
                $arr[$b[1]]['type'] = 2; //取酒
            }
            $a = $keepoutinfo->editKeepoutinfo($arr);
            $flag = $stock->editStock($a);
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
        $id = input('param.id');

        $info = $keepout->getOneKeepout($id);
        $info['nickname'] = $member->getnameMember($info['m_id']);
        $info['seat'] = $seat->getnameSeat($info['s_id']);
        $info['w_name'] = $user->getnameWiteruser($info['w_id']);
        $infos = $keepoutinfo->getKeepoutinfo($info['id']);
        foreach ($infos as $k => $v) {
            $c = $this->stockGetedit($v['st_id']);
            $infos[$k] = $v;
            $infos[$k]['type'] = $c['type'];
            $infos[$k]['brand'] = $c['brand'];
            $infos[$k]['t_id'] = $c['t_id'];
            $infos[$k]['b_id'] = $c['b_id'];
            $infos[$k]['num_max'] = $c['num'] + $v['num'];
            $infos[$k]['nums_max'] = $c['nums'];
            $infos[$k]['time'] = ($v['use_day'] - strtotime(date("Y-m-d"), time())) / 86400 - 1;
        }
        $this->assign([
            'info' => $info,
            'infos' => $infos,
        ]);
        return $this->fetch();
    }

    //根据存取表id获取该id的详细信息
    public function stockGetedit($id) {
        $stock = new StockModel();
        $arr = $stock->getStockbyid($id);
        $winetype = new WinetypeModel();
        $winebrand = new WinebrandModel();
        $type = $winetype->getOneWinetype($arr['t_id']);
        $brand = $winebrand->getOneWinebrand($arr['b_id']);
        $arr['type'] = $type['title'];
        $arr['brand'] = $brand['name'];
        return $arr;
    }

    //删除
    public function keepoutDel() {
        $id = input('param.id');
        $keepout = new KeepoutModel();
        $keepoutinfo = new KeepoutinfoModel();
        $stock = new StockModel();
        $info = $keepoutinfo->getKeepoutinfo($id);
        $a = $stock->delStock($info);
        if ($a['code'] !== -1) {
            $flag = $keepout->delKeepout($id);
            if ($flag['code'] = 1) {
                $flag = $keepoutinfo->delKeepoutinfo($id);
            }
        } else {
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }

        return json(msg($flag['code'], $flag['data'], $flag['msg']));
    }

    //存酒编辑
    public function keepEdit() {
        $stock = new StockModel();
        $winetype = new WinetypeModel();
        $winebrand = new WinebrandModel();
        $keepoutinfo = new KeepoutinfoModel();
        $keepout = new KeepoutModel();
        $member = new MemberModel();
        $seat = new SeatModel();
        $user = new UserModel();
        if (request()->isPost()) {

            $param = input('post.');
            foreach ($param as $k => $v) {
                $b = explode('_', $k);
                $arr[$b[1]][$b[0]] = $v;
                $arr[$b[1]]['type'] = 1; //存酒
            }
            $a = $keepoutinfo->editKeepoutinfo($arr);
            $flag = $stock->editStock($a);
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
        $id = input('param.id');

        $info = $keepout->getOneKeepout($id);
        $info['nickname'] = $member->getnameMember($info['m_id']);
        $info['seat'] = $seat->getnameSeat($info['s_id']);
        $info['w_name'] = $user->getnameWiteruser($info['w_id']);
        $infos = $keepoutinfo->getKeepoutinfo($info['id']);

        foreach ($infos as $k => $v) {
            $c = $this->stockGetedit($v['st_id']);
            $infos[$k] = $v;
            $infos[$k]['type'] = $c['type'];
            $infos[$k]['brand'] = $c['brand'];
            $infos[$k]['t_id'] = $c['t_id'];
            $infos[$k]['b_id'] = $c['b_id'];
            $infos[$k]['nums_max'] = $c['nums'];
            $infos[$k]['time'] = ($v['use_day'] - strtotime(date("Y-m-d"), time())) / 86400 - 1;
        }
        $this->assign([
            'info' => $info,
            'infos' => $infos,
        ]);

        return $this->fetch();
    }

    //过期处理
    public function keepoutExpire() {
        if (request()->isAjax()) {

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            $wheres = [];
            if (!empty($param['searchText'])) {
                $where['b.nickname'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $where['a.c_id'] = $_SESSION['think']['c_id'];
            $where['a.use_day'] = ['lt', time()];
            $stock = new StockModel();
            $winetype = new WinetypeModel();
            $winebrand = new WinebrandModel();
            $selectResult = $stock->getStockByWhere($where, $offset, $limit);
            foreach ($selectResult as $key => $vo) {
                $type = $winetype->getOneWinetype($vo['t_id']);
                $brand = $winebrand->getOneWinebrand($vo['b_id']);
                $selectResult[$key]['type'] = $type['title'];
                $selectResult[$key]['brand'] = $brand['name'];
                $selectResult[$key]['time'] = "已过期";
                $selectResult[$key]['operate'] = showOperate($this->makeButtonss($vo['id']));
            }
            $return['total'] = $stock->getAllKeepout($where);  // 总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        return $this->fetch();
    }

    //过期修改有效期
    public function stocktimeEdit() {
        $stock = new StockModel();
        $winetype = new WinetypeModel();
        $winebrand = new WinebrandModel();
        $keepoutinfo = new KeepoutinfoModel();
        $keepout = new KeepoutModel();
        $member = new MemberModel();
        $seat = new SeatModel();
        $user = new UserModel();
        if (request()->isPost()) {

            $param = input('post.');
            $param['use_day'] = strtotime(date("Y-m-d"), time()) + 60 * 60 * 24 + $param['useday'] * 60 * 60 * 24;
            $flag = $stock->timeStock($param);
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
        $id = input('param.id');

        $this->assign([
            'id' => $id,
        ]);

        return $this->fetch();
    }

    //过期删除
    public function stocktimedel() {
        $id = input('param.id');
        $keepout = new KeepoutModel();
        $keepoutinfo = new KeepoutinfoModel();
        $stock = new StockModel();
        $info = $keepoutinfo->getKeepoutinfos($id);
        foreach ($info as $va) {
            $a = $keepout->getOneKeepout($va['k_id']);
            $b = $keepout->delKeepout($a['id']);
        }
        $c = $keepoutinfo->delKeepoutinfos($id);
        if ($c['code'] !== -1) {
            $flag = $stock->delStocks($id);
        } else {
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }

        return json(msg($flag['code'], $flag['data'], $flag['msg']));
    }
    
    public function waiteroutEdit(){
        $stock = new StockModel();
        $winetype = new WinetypeModel();
        $keepoutinfo = new KeepoutinfoModel();
        $keepout = new KeepoutModel();
        $user = new UserModel();
        $seat = new SeatModel();
        $member = new MemberModel();
        if (request()->isPost()) {
            $param = input('post.');
            if ($param['mid'] == '') {
                return json(msg(-1, '', '请选择用户'));
            }
            if ($param['wid'] == 0) {
                return json(msg(-1, '', '请选择服务员'));
            }
            if ($param['sid'] == 0) {
                return json(msg(-1, '', '请选择台桌'));
            }
            $a['id'] = $param['id'];
            $a['s_id'] = $param['sid'];
            $a['w_id'] = $param['wid'];
            $a['m_id'] = $param['mid'];
            $a['time'] = time();
            $a['type'] = 1;
            $a['status'] = 2;
            $a['c_id'] = $_SESSION['think']['c_id'];
            unset($param['id']);
            unset($param['sid']);
            unset($param['wid']);
            unset($param['mid']);
            unset($param['mids']);
            foreach ($param as $k => $v) {
                $b = explode('_', $k);
                $arr[$b[1]][$b[0]] = $v;
                $arr[$b[1]]['mid'] = $a['m_id'];
                if ($b[0] == 'useday') {
                    $arr[$b[1]]['use_day'] = strtotime(date("Y-m-d"), time()) + 60 * 60 * 24 + $v * 60 * 60 * 24;
                }
            }
            foreach ($arr as $v) {
                if ($v['tid'] == 0) {
                    return json(msg(-1, '', '请选择酒种类'));
                }
                if ($v['bid'] == 0) {
                    return json(msg(-1, '', '请选择酒品牌'));
                }
            }
            //查看库存是否存在，传入库存id
            $ids = $stock->checkStock($arr);
            $k_id = $keepout->editKeepout($a);
            $flag = $keepoutinfo->addKeepoutinfo($a['id'], $ids, 1);

            return json(msg($flag['code'], url('keepout/waiterindex'), $flag['msg']));
        }
        $id = input('param.id');
        
        $info = $keepout->getOneKeepout($id);
        $members = $member->getOneMember($info['m_id']);
        $waiter = $user->getOneUser($info['w_id']);
        $seats = $seat->getOneSeat($info['s_id']);
        $info_t = $winetype->getWinetype();
        $info['nickname'] = $members['nickname'];
        $info['waiter'] = $waiter['user_name'];
        $info['seat'] = $seats['name'];
        $this->assign([
            'info' => $info,
            'info_t' => $info_t
        ]);
        return $this->fetch();
    }
    
    public function waiteroutDel(){
        $id = input('param.id');
        $keepout = new KeepoutModel();
        $flag = $keepout->delKeepout($id);
        return json(msg($flag['code'], $flag['data'], $flag['msg']));
    }

    /**
     * 拼装操作按钮存酒  存酒
     * @param $id
     * @return array
     */
    private function makeButton($id) {
        return [
            '编辑' => [
                'auth' => 'keepout/keepedit',
                'href' => url('keepout/keepedit', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '删除' => [
                'auth' => 'keepout/keepoutdel',
                'href' => "javascript:keepoutDel(" . $id . ")",
                'btnStyle' => 'danger',
                'icon' => 'fa fa-trash-o'
            ]
        ];
    }

    /**
     * 拼装操作按钮取酒  取酒
     * @param $id
     * @return array
     */
    private function makeButtons($id) {
        return [
            '编辑' => [
                'auth' => 'keepout/outedit',
                'href' => url('keepout/outedit', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '删除' => [
                'auth' => 'keepout/keepoutdel',
                'href' => "javascript:keepoutDel(" . $id . ")",
                'btnStyle' => 'danger',
                'icon' => 'fa fa-trash-o'
            ]
        ];
    }

    /**
     * 拼装操作按钮取酒  过期
     * @param $id
     * @return array
     */
    private function makeButtonss($id) {
        return [
            '修改' => [
                'auth' => 'keepout/stocktimeedit',
                'href' => url('keepout/stocktimeedit', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '删除' => [
                'auth' => 'keepout/stocktimedel',
                'href' => "javascript:stocktimeDel(" . $id . ")",
                'btnStyle' => 'danger',
                'icon' => 'fa fa-trash-o'
            ]
        ];
    }
    
        /**
     * 拼装操作按钮取酒  服务员存酒
     * @param $id
     * @return array
     */
    private function makeButtonsss($id) {
        return [
            '修改' => [
                'auth' => 'keepout/waiteroutedit',
                'href' => url('keepout/waiteroutedit', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '删除' => [
                'auth' => 'keepout/waiteroutdel',
                'href' => "javascript:waiteroutDel(" . $id . ")",
                'btnStyle' => 'danger',
                'icon' => 'fa fa-trash-o'
            ]
        ];
    }

    

}
