<?php

namespace app\index\controller;

use app\admin\model\MemberModel;
use app\admin\model\ActivityModel;
use app\admin\model\CardModel;
use app\admin\model\SetModel;
use app\admin\model\RechargeModel;
use app\admin\model\OrderModel;
use app\admin\model\StockModel;
use app\admin\model\WinetypeModel;
use app\admin\model\WinebrandModel;
use app\admin\model\PointModel;
use app\admin\model\SeatModel;
use app\admin\model\KeepoutModel;
use app\admin\model\KeepoutinfoModel;
use app\admin\model\BrandscateModel;
use app\admin\model\OutcursorModel;

use think\Controller;

class Index extends Controller {

    //首页
    public function index() {
        $param = input('post.');
        if ($param) {
            $where['id'] = $param['mid'];
            $where['c_id'] = $param['cid'];   //用户
            $wherea['c_id'] = $param['cid'];  //活动
            $wherea['status'] = 1;  //活动
            $wherec['c_id'] = $param['cid'];  //会员卡
            $wheres['c_id'] = $param['cid'];  //酒卡
            $time = time() + 24 * 60 * 60 * 7;
            $wheres['use_day'] = array('BETWEEN', array(time(), $time));
            $member = new MemberModel();
            $activity = new ActivityModel();
            $card = new CardModel();
            $stock = new StockModel();
            $member_info = $member->getMemberbyopenid($where);
            $member_info['avatar'] = $this->deal_image($member_info['avatar']);
            $wheres['m_id'] = $member_info['id'];
            $stock_info = $stock->getStocktime($wheres);
            $wherec['point'] = ['elt', $member_info['point']];
            $activity_info = $activity->getActivityBycid($wherea);
            $activity_info = json_decode(json_encode($activity_info), true);
            foreach ($activity_info as $key => $value) {
                $activity_info[$key] = $value;
                $activity_info[$key]['banner'] = $this->deal_image($value['banner']);
            }
            $cards = $card->grtCardbycid($wherec);
            $card = json_decode(json_encode($cards), true);
            $card = $this->my_sort($card, 'point', $sort_order = SORT_DESC);
            $card[0]['image'] = $this->deal_image($card[0]['image']);
            $return['code'] = 200;  //成功
            $return['message'] = "ok";
            $return['data']['member'] = $member_info;
            $return['data']['activity'] = $activity_info;
            $return['data']['card'] = $card[0];
            if ($stock_info) {
                $return['data']['stock'] = 1;
            }
            return json($return);
        } else {
            $return['code'] = 401;
            $return['message'] = "未接收到传值";
            return json($return);
        }
    }
    
    public function getItemDetail($id){
        
        $result = Item::get(1);
        if($result->isEmpety()){
                throw new ItemException([
                    'code' => 200,
                    'errorCode' => 1,
                    'msg'
                ]);
        }
        return $result;
    }

//会员卡详情   
    public function card() {
        $param = input('post.');
        if ($param) {
            $card = new CardModel();
            $card_info = $card->getOneCard($param['id']);
            if (!isset($card_info)) {
                $return['code'] = 500;
                $return['message'] = "会员卡数据不存在";
                return json($return);
            }
            $card_info['image'] = $this->deal_image($card_info['image']);
            unset($card_info['point']);
            unset($card_info['c_id']);
            $return['code'] = 200;  //成功
            $return['message'] = "ok";
            $return['data'] = $card_info;
            return json($return);
        } else {
            $return['code'] = 401;
            $return['message'] = "未接收到传值";
            return json($return);
        }
    }

//充值页面
    public function recharge() {
        $param = input('post.');
        if ($param) {
            $where['id'] = $param['cid'];
            $set = new SetModel();
            $set_info = $set->getcofs($where);
            $recharge = json_decode($set_info['recharge'], true);
            foreach ($recharge as $k => $v) {
                $arr[$k]['price_name'] = $v[0];
                $arr[$k]['discount'] = $v[1];
                $arr[$k]['id'] = $k;
            }
            $arr = $this->my_sort($arr, 'price_name', $sort_order = SORT_ASC);
            $return['code'] = 200;  //成功
            $return['message'] = "ok";
            $return['data']['recharge'] = $arr;
            return json($return);
        } else {
            $return['code'] = 401;
            $return['message'] = "未接收到传值";
            return json($return);
        }
    }

    //消费明细
    public function rechargeinfo() {
        $param = input('post.');
        if ($param) {
            $where['m_id'] = $param['mid'];
            $where['c_id'] = $param['cid'];
            $recharge = new RechargeModel();
            $order = new OrderModel();
            $member = new MemberModel();
            $use_info = $member->getOneMember($param['mid']);
            $recharge_info = $recharge->getRechargeByid($where);
            $order_info = $order->getOrderByid($where);
            $recharge_info = json_decode(json_encode($recharge_info), true);
            $order_info = json_decode(json_encode($order_info), true);
            $arr = array_merge($recharge_info, $order_info);
            $arr = $this->my_sort($arr, 'time', $sort_order = SORT_DESC);
            $num = $use_info['money'];
            foreach ($arr as $k => $v) {
                $info[$k]['time'] = date('Y-m-d H:i:s', $v['time']);
                if (isset($v['content'])) {
                    $info[$k]['content'] = "酒水消费";
                    $info[$k]['pay'] = "-" . $v['pay'];
                    $info[$k]['pay_totle'] = $num;
                    $num = $num + $v['pay'];
                } else {
                    $info[$k]['content'] = "充值信息";
                    $info[$k]['pay'] = "+" . ($v['recharge'] + $v['present']);
                    $info[$k]['pay_totle'] = $num;
                    $num = $num - $v['recharge'] - $v['present'];
                }
            }
            $return['code'] = 200;  //成功
            $return['message'] = "ok";
            $return['data']['recharge_info'] = $info;
            return json($return);
        } else {
            $return['code'] = 401;
            $return['message'] = "未接收到传值";
            return json($return);
        }
    }

    //取酒
    public function out() {
        $param = input('post.');
        if ($param) {
            $where['c_id'] = $param['cid'];  //酒卡
            $where['use_day'] = ['gt', time()];
            $where['m_id'] = $param['mid'];
            $stock = new StockModel();
            $winetype = new WinetypeModel();
            $winebrand = new WinebrandModel();
            $stock_info = $stock->getStocktime($where);
            $stock_infos = json_decode(json_encode($stock_info), true);
            foreach ($stock_infos as $k => $v) {
                $arr[$v['t_id']]['wind_id'] = $v['t_id'];
                $type = $winetype->getOneWinetype($v['t_id']);
                $arr[$v['t_id']]['wind_ty'] = $type['title'];
                $arr[$v['t_id']]['image'] = $this->deal_image($type['image']);
                $arr[$v['t_id']]['checked'] = false;
                $brand = $winebrand->getOneWinebrand($v['b_id']);
                $arr[$v['t_id']]['wintype'][$k]['alcohol_id'] = $v['id'];
                $arr[$v['t_id']]['wintype'][$k]['alcohol_title'] = $brand['name'];
                $arr[$v['t_id']]['wintype'][$k]['alcohol_date'] = $v['use_day'];
                $arr[$v['t_id']]['wintype'][$k]['num'] = $v['num'];
                $arr[$v['t_id']]['wintype'][$k]['first_num'] = 0;
                if ($v['nums']) {
                    $arr[$v['t_id']]['wintype'][$k + 1000]['alcohol_id'] = $v['id'];
                    $arr[$v['t_id']]['wintype'][$k + 1000]['alcohol_title'] = $brand['name'];
                    $arr[$v['t_id']]['wintype'][$k + 1000]['alcohol_date'] = $v['use_day'];
                    $arr[$v['t_id']]['wintype'][$k + 1000]['unum'] = $v['nums'];
                    $arr[$v['t_id']]['wintype'][$k + 1000]['first_num'] = 0;
                }
            }
            foreach ($arr as $k => $v) {
                $info[$k] = $v;
                $a = $this->my_sort($v['wintype'], 'alcohol_date', $sort_order = SORT_ASC);
                foreach ($a as $key => $value) {
                    $a[$key]['alcohol_date'] = date('Y-m-d', $value['alcohol_date']);
                }

                $info[$k]['wintype'] = $a;
            }
            $return['code'] = 200;  //成功
            $return['message'] = "ok";
            $return['data'] = $info;
            return json($return);
        } else {
            $return['code'] = 401;
            $return['message'] = "未接收到传值";
            return json($return);
        }
    }

    //取酒动作结束
    public function outover() {
        $param = input('post.');
        if($param){
            $outcursor = new OutcursorModel();
            $param['m_id'] = $param['mid'];
            $id = $outcursor->addOutcursor($param);
            $url = "https://jbxcx.linxsl.top/waiter/index/waiterout?oid=" . $id."&cid=".$param['cid'];
            $url_img = $this->scerweima2($url);
            $return['code'] = 200;
            $return['message'] = 'ok';
            $return['data']['url'] = $url_img;
            return json($return);
        } else {
            $return['code'] = 401;
            $return['message'] = "未接收到传值";
            return json($return);
        } 
    }

    //积分列表
    public function point_list() {
        $param = input('post.');
        if ($param) {
            $where['m_id'] = $param['mid'];
            $point = new PointModel();
            $member = new MemberModel();
            $use_info = $member->getOneMember($param['mid']);
            $point_info = $point->getPoinrByid($where);
            $point_info = json_decode(json_encode($point_info), true);
            $arr = $this->my_sort($point_info, 'add_time', $sort_order = SORT_DESC);
            foreach ($arr as $k => $v) {
                $info[$k]['add_time'] = date('Y-m-d H:i:s', $v['add_time']);
                if ($v['type'] == 1) {
                    $info[$k]['content'] = "消费获得";
                } elseif ($v['type'] == 2) {
                    $info[$k]['content'] = "充值获得";
                } elseif ($v['type'] == 3) {
                    $info[$k]['content'] = "注册获得";
                }
                $info[$k]['nums'] = $v['nums'];
            }
            $return['code'] = 200;  //成功
            $return['message'] = "ok";
            $return['data']['point'] = $use_info['point'];
            $return['data']['point_info'] = $info;
            return json($return);
        } else {
            $return['code'] = 401;
            $return['message'] = "未接收到传值";
            return json($return);
        }
    }

    //酒卡列表
    public function stock() {
        $param = input('post.');
        if ($param) {
            $where['m_id'] = $param['mid'];  //酒卡
            $where['c_id'] = $param['cid'];  //酒卡
            $where['use_day'] = ['gt', time()];
            $stock = new StockModel();
            $winetype = new WinetypeModel();
            $winebrand = new WinebrandModel();
            $stock_info = $stock->getStocktime($where);
            $stock_infos = json_decode(json_encode($stock_info), true);
            $stock_infos = $this->my_sort($stock_infos, 'use_day', $sort_order = SORT_ASC);
            foreach ($stock_infos as $k => $v) {
                $type = $winetype->getOneWinetype($v['t_id']);
                $brand = $winebrand->getOneWinebrand($v['b_id']);
                $arr[$k]['alcohol_title'] = $brand['name'];
                $arr[$k]['wind_ty'] = $type['title'];
                $arr[$k]['image'] = $this->deal_image($type['image1']);
                $arr[$k]['alcohol_id'] = $v['id'];
                $arr[$k]['alcohol_date'] = date('Y-m-d H:i:s', $v['use_day']);
                if ($v['use_day'] < (time() + 24 * 60 * 60 * 7)) {
                    $arr[$k]['overtime'] = 1;
                }
            }
            $return['code'] = 200;  //成功
            $return['message'] = "ok";
            $return['data'] = $arr;
            return json($return);
        } else {
            $return['code'] = 401;
            $return['message'] = "未接收到传值";
            return json($return);
        }
    }

    //酒卡详情
    public function stock_info() {
        $param = input('post.');
        if ($param) {
            $where['id'] = $param['id'];  //酒卡
            $stock = new StockModel();
            $winetype = new WinetypeModel();
            $winebrand = new WinebrandModel();
            $stock_info = $stock->getStocktime($where);
            $stock_infos = json_decode(json_encode($stock_info), true);
            $brandscate = new BrandscateModel();
            $info = $brandscate->getOneBrandscate($param['cid']);
            foreach ($stock_infos as $k => $v) {
                $type = $winetype->getOneWinetype($v['t_id']);
                $brand = $winebrand->getOneWinebrand($v['b_id']);
                $arr[$k]['alcohol_title'] = $brand['name'];
                $arr[$k]['wind_ty'] = $type['title'];
                $arr[$k]['image'] = $this->deal_image($type['image']);
                $arr[$k]['alcohol_date'] = date('Y-m-d', $v['use_day']);
                $arr[$k]['num'] = $v['num'];
                $arr[$k]['unum'] = $v['nums'];
                $arr[$k]['cname'] = $info['name'];
            }
            $return['code'] = 200;  //成功
            $return['message'] = "ok";
            $return['data'] = $arr;
            return json($return);
        } else {
            $return['code'] = 401;
            $return['message'] = "未接收到传值";
            return json($return);
        }
    }

    //消费榜单
    public function consume_list() {
        $param = input('post.');
        if ($param) {
            $param['m_id'] = $param['mid'];
            $where['c_id'] = $param['cid'];  //酒卡
            $order = new OrderModel();
            $member = new MemberModel();
            $order_info = $order->getOrderByid($where);
            $order_infos = json_decode(json_encode($order_info), true);
            if ($order_infos) {
                foreach ($order_infos as $k => $v) {
                    $arr[$v['m_id']][] = $v['pay'];
                }
                foreach ($arr as $k => $v) {
                    $use_info = $member->getOneMember($k);
                    if ($k == $param['m_id']) {
                        $infos['mid'] = $k;
                        $infos['memoy'] = array_sum($v);
                        $infos['nickname'] = $use_info['nickname'];
                        $infos['avatar'] = $this->deal_image($use_info['avatar']);
                    }
                    $info[$k]['mid'] = $k;
                    $info[$k]['memoy'] = array_sum($v);
                    $info[$k]['nickname'] = $use_info['nickname'];
                    $info[$k]['avatar'] = $this->deal_image($use_info['avatar']);
                }
                $info = $this->my_sort($info, 'memoy', $sort_order = SORT_DESC);
                $a = 0;
                foreach ($info as $k => $va) {
                    $a = $a + 1;
                    if ($a <= 3) {
                        $infot[$k] = $va;
                        $infot[$k]['ranking'] = $a;
                    }
                    if ($va['mid'] == $infos['mid']) {
                        $infos['ranking'] = $a;
                    }
                    $infoa[$k] = $va;
                    $infoa[$k]['ranking'] = $a;
                }
                $return['code'] = 200;  //成功
                $return['message'] = "ok";
                $return['data']['info'] = $infoa; //总数据
                $return['data']['infos'] = $infos; //个人信息
                $return['data']['infot'] = $infot; //前三名信息
                $return['data']['status'] = 1;
                return json($return);
            } else {
                $return['code'] = 500;
                $return['message'] = "暂时没有数据";
                $return['data']['status'] = 0;
                $return['data']['info'] = []; //总数据
                $return['data']['infos'] = []; //个人信息
                $return['data']['infot'] = []; //前三名信息
                return json($return);
            }
        } else {
            $return['code'] = 401;
            $return['message'] = "未接收到传值";
            return json($return);
        }
    }

    //单桌榜单
    public function consume_seat_list() {
        $param = input('post.');
        if ($param) {
            $param['m_id'] = $param['mid'];
            $where['c_id'] = $param['cid'];  //酒卡
            $order = new OrderModel();
            $member = new MemberModel();
            $seat = new SeatModel();
            $seat_list = $seat->getSeatall($where);
            $seat_lists = json_decode(json_encode($seat_list), true);
            unset($seat_lists['c_id']);
            unset($seat_lists['remark']);
            if (isset($param['sid'])) {
                $where['s_id'] = $param['sid'];  //酒卡 
            } else {
                $where['s_id'] = $seat_lists[0]['id'];  //酒卡 
            }
            $order_info = $order->getOrderByid($where);
            $order_infos = json_decode(json_encode($order_info), true);
            if ($order_infos) {
                foreach ($order_infos as $k => $v) {
                    $arr[$v['m_id']][] = $v['pay'];
                }
                foreach ($arr as $k => $v) {
                    $use_info = $member->getOneMember($k);
                    if ($k == $param['m_id']) {
                        $infos['mid'] = $k;
                        $infos['memoy'] = array_sum($v);
                        $infos['nickname'] = $use_info['nickname'];
                        $infos['avatar'] = $this->deal_image($use_info['avatar']);
                    }
                    $info[$k]['mid'] = $k;
                    $info[$k]['memoy'] = array_sum($v);
                    $info[$k]['nickname'] = $use_info['nickname'];
                    $info[$k]['avatar'] = $this->deal_image($use_info['avatar']);
                }
                $info = $this->my_sort($info, 'memoy', $sort_order = SORT_DESC);
                $a = 0;
                foreach ($info as $k => $va) {
                    $a = $a + 1;
                    if ($a <= 3) {
                        $infot[$k] = $va;
                        $infot[$k]['ranking'] = $a;
                    }
                    if (isset($infos)) {
                        if ($va['mid'] == $infos['mid']) {
                            $infos['ranking'] = $a;
                        }
                    }
                    $infoa[$k] = $va;
                    $infoa[$k]['ranking'] = $a;
                }
                $return['code'] = 200;  //成功
                $return['message'] = "ok";
                $return['data']['info'] = $infoa; //总数据
                if (isset($infos)) {
                    $return['data']['infos'] = $infos; //个人信息
                } else {
                    $return['data']['infos'] = [];
                }
                $return['data']['infot'] = $infot; //前三名信息
                $return['data']['status'] = 1;
            } else {
                $return['code'] = 200;
                $return['message'] = "ok";
                $return['data']['status'] = 0;
                $return['data']['info'] = []; //总数据
                $return['data']['infos'] = []; //个人信息
                $return['data']['infot'] = []; //前三名信息 
            }
            $return['data']['seat_list'] = $seat_lists;
            return json($return);
        } else {
            $return['code'] = 401;
            $return['message'] = "未接收到传值";
            return json($return);
        }
    }

    //取酒列表
    public function out_list() {
        $param = input('post.');
        if ($param) {
//        $param['cid'] = 0;
            $where['c_id'] = $param['cid'];
            $where['m_id'] = $param['mid'];
            $where['type'] = 2;
            $stock = new StockModel();
            $keepout = new KeepoutModel();
            $keepoutinfo = new KeepoutinfoModel();
            $winebrand = new WinebrandModel();
            $out_list = $keepout->outList($where);
            $out_list = json_decode(json_encode($out_list), true);
            if ($out_list) {
                foreach ($out_list as $v) {
                    $arr = $keepoutinfo->getKeepoutinfo($v['id']);
                    $arr = json_decode(json_encode($arr), true);
                    foreach ($arr as $key => $value) {
                        $arr[$key] = $value;
                        $arr[$key]['add_time'] = $v['time'];
                    }
                    $info[] = $arr;
                }
                foreach ($info as $k => $v) {
                    foreach ($v as $key => $value) {
                        $arrs[$value['st_id']][] = $value;
                    }
                }
                $arrs = $this->sort3wei($arrs);
                $c = 0;
                foreach ($arrs as $key => $value) {
                    $wheres['id'] = $key;
                    $a = $stock->getStocktime($wheres);
                    $brand = $winebrand->getOneWinebrand($a[0]['b_id']);
                    if ($a[0]['num']) {
                        $num = $a[0]['num'];
                    } else {
                        $num = 0;
                    }
                    if ($a[0]['nums']) {
                        $nums = $a[0]['nums'];
                    } else {
                        $nums = 0;
                    }
                    $d = $num + $nums * 0.1;
                    foreach ($value as $k => $v) {
                        $d = $d + $v['num'] + $v['nums'];
                        $c = $c + 1;
                        $b[$c]['stock'] = $d;
                        $b[$c]['brand'] = $brand['name'];
                        $b[$c]['all_num'] = $v['num'] + $v['nums'] * 0.1;
                        $b[$c]['add_time'] = date('Y-m-d H:i:s', $v['add_time']);
                    }
                }
                $return['code'] = 200;  //成功
                $return['message'] = "ok";
                $return['data']['info'] = $b; //总数据
                $return['data']['status'] = 1; //总数据
            } else {
                $return['code'] = 200;  //成功
                $return['message'] = "数据不存在";
                $return['data']['info'] = []; //总数据
                $return['data']['status'] = 0; //总数据
            }
            return json($return);
        } else {
            $return['code'] = 401;
            $return['message'] = "未接收到传值";
            return json($return);
        }
    }

    //存酒接口
    public function keep() {
        $param = input('post.');
        if ($param) {
            $url = "https://jbxcx.linxsl.top/waiter/index/waiterkeep?mid=" . $param['mid'] . "&cid=" . $param['cid'];
            $url_img = $this->scerweima2($url);
            $brandscate = new BrandscateModel();
            $info = $brandscate->getOneBrandscate($param['cid']);
            $cname = $info['name'];
            $logo = $this->deal_image($info['img']);
            $return['code'] = 200;  //成功
            $return['message'] = "ok";
            $return['data']['url'] = $url_img;
            $return['data']['cname'] = $cname;
            $return['data']['logo'] = $logo;
            return json($return);
        } else {
            $return['code'] = 401;
            $return['message'] = "未接收到传值";
            return json($return);
        }
    }

    function sort3wei($array) {
        foreach ($array as $key => $val) {
            $new_array = array();
            $sort_array = array();
            foreach ($val as $k => $v) {
                $sort_array[$k] = $v['add_time'];
            }
            asort($sort_array); //降序使用 arsort();
            reset($sort_array);

            foreach ($sort_array as $k => $v) {
                $new_array[$k] = $array[$key][$k];
            }
            $array[$key] = $new_array;
        }
        return $array;
    }

    function scerweima2($url = '') {
        vendor("phpqrcode.phpqrcode");
        $objPHPExcel = new \QRcode();
        $value = $url;     //二维码内容

        $errorCorrectionLevel = 'L'; //容错级别 
        $matrixPointSize = 5;   //生成图片大小  
        //生成二维码图片
        $filename = 'qrcode/' . time() . '.png';
        $objPHPExcel->png($value, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

        $QR1 = $filename;    //已经生成的原始二维码图片文件  


        $QR = imagecreatefromstring(file_get_contents($QR1));

        return 'https://' . $_SERVER['HTTP_HOST'] . '/' . $QR1;
    }

    function deal_image($param) {
        return 'https://' . $_SERVER['HTTP_HOST'] . $param;
    }

//    const TOKEN = 'API';
//
//    //响应前台的请求
//    public function respond(){
//        //验证身份
//        $param = input('param.');
//        $timeStamp = $param['t'];
//        $randomStr = $param['r'];
//        $signature = $param['s'];
//        $str = $this -> arithmetic($timeStamp,$randomStr);
//        if($str != $signature){
//            echo "-1";
//            exit;
//        }
//        //模拟数据
//        $arr['name'] = 'api';
//        $arr['age'] = 15;
//        $arr['address'] = 'zz';
//        $arr['ip'] = "192.168.0.1";
//        echo json_encode($arr);
//    }
//
//    /**
//     * @param $timeStamp 时间戳
//     * @param $randomStr 随机字符串
//     * @return string 返回签名
//     */
//    public function arithmetic($timeStamp,$randomStr){
//        $arr['timeStamp'] = $timeStamp;
//        $arr['randomStr'] = $randomStr;
//        $arr['token'] = self::TOKEN;
//        //按照首字母大小写顺序排序
//        sort($arr,SORT_STRING);
//        //拼接成字符串
//        $str = implode($arr);
//        //进行加密
//        $signature = sha1($str);
//        $signature = md5($signature);
//        //转换成大写
//        $signature = strtoupper($signature);
//        return $signature;
//    }
//    public function getDataFromServer(){
//        //时间戳
//        $timeStamp = time();
//        //随机数
//        $randomStr = $this -> createNonceStr();
//        //生成签名
//        $signature = $this -> arithmetic($timeStamp,$randomStr);
//        //url地址
//        $url = "http://ceshi1.net/index/index/respond/t/{$timeStamp}/r/{$randomStr}/s/{$signature}";
//        dump($url);
//        $result = $this -> httpGet($url);
//        dump($result);
//    }
//
//    //curl模拟get请求。
//    private function httpGet($url){
//        $curl = curl_init();
//
//        //需要请求的是哪个地址
//        curl_setopt($curl,CURLOPT_URL,$url);
//        //表示把请求的数据已文件流的方式输出到变量中
//        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
//
//        $result = curl_exec($curl);
//        curl_close($curl);
//        return $result;
//    }
//
//    //随机生成字符串
//    private function createNonceStr($length = 8) {
//        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
//        $str = "";
//        for ($i = 0; $i < $length; $i++) {
//            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
//        }
//        return "z".$str;
//    }
}
