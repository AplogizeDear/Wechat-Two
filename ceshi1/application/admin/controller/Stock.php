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

use app\admin\model\StockModel;
use app\admin\model\WinetypeModel;
use app\admin\model\WinebrandModel;
use app\admin\model\MemberModel;

class Stock extends Base {

    // 活动列表
    public function index() {
        $member = new MemberModel;
        if (request()->isAjax()) {

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;
                        $c = json_encode($param);
            file_put_contents("test1.txt",$c);
            $where = [];
            if (!empty($param['searchText'])) {
                $where['b.nickname'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $where['a.use_day'] = ['gt',time()];
            $where['a.c_id'] = $_SESSION['think']['c_id'];
            $stock = new StockModel();
            $winetype = new WinetypeModel();
            $winebrand = new WinebrandModel();
            $selectResult = $stock->getStockByWhere($where, $offset, $limit);

            foreach ($selectResult as $key => $vo) {
                $type = $winetype->getOneWinetype($vo['t_id']);
                $brand = $winebrand->getOneWinebrand($vo['b_id']);
                $selectResult[$key]['type'] = $type['title'];
                $selectResult[$key]['brand'] = $brand['name'];
                $selectResult[$key]['use_day'] = date('Y-m-d H:i:s', $vo['use_day']);
                if($vo['nums']){
                    $selectResult[$key]['nums'] = $vo['nums']."0%";
                }
                
//                $selectResult[$key]['end_time'] = date('Y-m-d H:i:s', $vo['end_time']);
//                $selectResult[$key]['banner'] = '<img src="' . $vo['banner'] . '" width="40px" height="40px">';
//                $selectResult[$key]['operate'] = showOperate($this->makeButton($vo['id']));
            }

            $return['total'] = $stock->getAllKeepout($where);  // 总数据
            $return['rows'] = $selectResult;

            return json($return);
        }
        $a = input('param.');
        if(isset($a['id'])){
            $b = $member->getOneMember($a['id']);
            $this->assign('id', $b['nickname']); 
        }else{
            $this->assign('id', ""); 
        }
        return $this->fetch();
    }

    

}
