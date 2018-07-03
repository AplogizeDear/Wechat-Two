<?php

namespace app\waiter\controller;

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

class Index extends Base {

    //首页
    public function index() {
        return $this->fetch();
    }
    
    //修改密码
    public function changePassword() {
        return $this->fetch();
    }
    
    //服务员取酒
    // oid 临时表id  cid  公司id
    public function waiterout() {
        $param = input('get.');
        dump($param);
        return $this->fetch();
    }
    
    //服务员取酒确认
    // mid 用户id  cid 公司id oid 临时表id sid 台桌id wid 服务员id
    public function waiterouts() {
        $param = input('post.');
        return json($param);
    }
    
    //服务员存酒
    //mid 用户id  cid 公司id
    public function waiterkeep() {
        $param = input('get.');
        if($param['cid'] != $_SESSION['think']['c_id']){
            dump('不属于同一酒吧');
            die;
        }
        
        
        return $this->fetch();
    }
    
    //服务员存酒确认
    //wid 服务员id mid 用户id sid 台桌id
    public function waiterkeeps() {
        dump(2222);
    }

}