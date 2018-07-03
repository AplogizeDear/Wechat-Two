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

namespace app\admin\model;

use think\Model;
use think\Db;

class RechargeModel extends Model {

    // 确定链接表名  充值
    protected $table = 'snake_recharge';

    /**
     * 查询充值表
     * @param $where
     * @param $offset
     * @param $limit
     */
    public function getRechargeByWhere($where, $offset, $limit) {
        $info = Db::table('snake_recharge')->alias('a')->join('snake_member b', 'a.m_id = b.id', 'left')->field('a.*,b.nickname')->where($where)->limit($offset, $limit)->order('a.id desc')->select();
        return $info;
    }

    /**
     * 根据搜索条件获取所有的充值数量
     * @param $where
     */
    public function getAllRecharge($where) {
        return Db::table('snake_recharge')->alias('a')->join('snake_member b', 'a.m_id = b.id', 'left')->field('a.*,b.nickname')->where($where)->count();
    }
    
    public function getTotlerecharge($where){
        $arr = Db::table('snake_recharge')->alias('a')->join('snake_member b', 'a.m_id = b.id', 'left')->field('a.*,b.nickname')->where($where)->select();
        $all = "0";
        foreach ($arr as $v) {
            $all += $v['recharge'];
        }
        return $all;
    }
    public function getRechargeByid($where){
        $info = $this->where($where)->select();
        return $info;
    }

}
