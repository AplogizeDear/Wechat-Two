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
use app\admin\model\KeepoutModel;
use app\admin\model\NodeModel;
use app\admin\model\MemberModel;
use app\admin\model\RechargeModel;
use think\Db;
class Index extends Base {

    public function index() {
        // 获取权限菜单
        $node = new NodeModel();
        $this->assign([
            'menu' => $node->getMenu(session('rule'))
        ]);

        return $this->fetch('/index');
    }

    /**
     * 后台默认首页
     * @return mixed
     */
    public function indexPage() {
        $start_time = mktime(0,0,0,date('m'),date('d'),date('Y'));   //今天开始时间戳
        $end_time = mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1; //今天结束时间戳
        //时间区间，7天、本月
        $return['day7datetime'] = date("Y-m-d",time()-24*60*60*7)."至".date("Y-m-d",time()-24*60*60*1);
        $return['day30datetime'] = date('Y-m-d',strtotime(date('Y-m-01',time())))."至".date("Y-m-d",time());
        $cid = $_SESSION['think']['c_id'];
        $wherems['c_id'] = $cid;
        $wherems['add_time'] = array('between',"$start_time,$end_time");
        $where['a.c_id'] = $cid;
        $wheres['a.c_id'] = $cid;
        $wherem['c_id'] = $cid;
        $map['a.c_id'] = $cid;
        $mapw['a.c_id'] = $cid;
        $mapm['a.c_id'] = $cid;
        $wherem['last_time'] = array('between',"$start_time,$end_time");
        /*统计昨日下单数*/
        $time_start=date("Y-m-d",time()-24*60*60*1);
        $time_end = date('Y-m-d');
        $map['a.time']=array('between',array(strtotime($time_start),strtotime($time_end)));
        $mapw['a.time']=array('between',array(strtotime(date("Y-m-d",time()-24*60*60*7)),strtotime(date("Y-m-d",time()))));
        $mapm['a.time'] = array('gt',strtotime(date('Y-m-01',time()))); //最近一个月
        $order = new OrderModel();
        $keepout = new KeepoutModel();
        $member = new MemberModel();
        $recharge = new RechargeModel();
        $return['recharge_30_today_total'] = $recharge->getAllRecharge($mapm);  // 充值总数据
        $return['recharge_30_total'] = $recharge->getTotlerecharge($mapm);  // 充值总数据
        $return['recharge_today_total'] = $recharge->getTotlerecharge($map);  // 充值总数据
        $return['today_mem_total'] = $member->getAllMember($wherem);  // 今天登录总数据
        $return['mem_total'] = $member->getAllMember($wherems);  // 今日注册用户总数据
        $return['order_total'] = $order->getAllOrder($where);  // 订单总数据
        $return['order_7_total'] = $order->getAllOrder($mapw);  // 订单7天总数据
        $return['order_7_momey_total'] = $order->getMomeyorder($mapw);  // 订单7天总金额
        $where['a.type'] = 1; //存酒
        $return['keep_total'] = $keepout->getAllKeepout($where);  // 存酒总数据
        $wheres['a.type'] = 2; //取酒
        $return['out_total'] = $keepout->getAllKeepout($wheres);  // 取酒总数据
        $this->assign([
            'return' => $return,
        ]);
        return $this->fetch('index');
    }

    /**
     * 后台人员第一次登陆修改密码
     * @return mixed
     */
    public function changePassword() {
        // 获取权限菜单
        $node = new NodeModel();
        $this->assign([
            'menu' => $node->getMenu(session('rule'))
        ]);
        return $this->fetch('/changepassword');
    }

    public function get_order_list()
	{
			$_order = Db::name('order');
			$time = strtotime(date("Y-m-d",strtotime("-7 day")));
			for ($i=0; $i < 7; $i++) {
				$timeArr[$i] = date('m.d',$time+$i*24*3600);
			}
			
			$yongjin = $_order->sum('pay');
			$yongjin = $yongjin ? $yongjin : 0;
			$yongjin = round($yongjin,2);
			
			$yinshou = $this->Weeken_price($time);
			
			$arr = array('date'=>$timeArr,'total_price'=>$yinshou);
			return json($arr);
	}
        public function Weeken_price($day,$k = 1)
	{
        static $result = array();
        $mod =  Db::name('order');
        
        $data['time'] = array('between',array($day,$day+24*3600));
        $result[$k-1] = $mod->where($data)->sum("pay");
        $result[$k-1] = !empty($result[$k-1]) ? $result[$k-1] : '';
        $result[$k-1]=round($result[$k-1],2); //保留两位小数
		
        if ($k < 7) {
            $this->Weeken_price($day+24*3600,++$k);
        }
		
        return $result;
    }
    /*热门派对*/
	public function get_recharge_list()
	{	
                                   $_recharge = Db::name('recharge');
                                   $map['c_id'] = $_SESSION['think']['c_id'];
		$map['time'] = array('gt',strtotime(date('Y-m-01',time()))); //最近一个月
                                   $day =  (strtotime(date('Y-m-d',time())) - strtotime(date('Y-m-01',time())))/86400;
		$time = strtotime(date("Y-m-d",strtotime("-$day day")));
			for ($i=0; $i < $day; $i++) {
				$timeArr[$i] = date('m.d',$time+$i*24*3600);
                                                                       $arr[$i] = $time+$i*24*3600;
			}
                        foreach ($arr as $k => $va) {
                            $data['time'] = array('between',array($va,$va+24*3600));
                            $result[$k] = $_recharge->where($data)->sum('recharge');
                        }
                        $recharge = $result;
                        rsort($result);
                        $max = $result[0];
                        $arr = array('date'=>$timeArr,'total_price'=>$recharge,'max'=>$max);
		return json($arr);
	}
}
