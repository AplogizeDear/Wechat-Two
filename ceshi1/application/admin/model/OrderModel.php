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

class OrderModel extends Model {

    // 确定链接表名  订单表
    protected $table = 'snake_order';

    /**
     * 查询订单
     * @param $where
     * @param $offset
     * @param $limit
     */
    public function getOrderByWhere($where, $offset, $limit) {
        $info = Db::table('snake_order')->alias('a')->join('snake_member b', 'a.m_id = b.id')->field('a.*,b.nickname')->where($where)->limit($offset, $limit)->order('a.id desc')->select();
        return $info;
    }

    /**
     * 根据搜索条件获取所有的订单数量
     * @param $where
     */
    public function getAllOrder($where) {
        return Db::table('snake_order')->alias('a')->join('snake_member b', 'a.m_id = b.id')->where($where)->count();
    }

    /**
     * 手动买单
     * @param $where
     */
    public function addOrder($param) {
        try {
            $result = $this->insertGetId($param);
            if (false === $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            } else {

                return msg($result, url('pay/index'), '手动买单成功');
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 根据订单的id 获取订单的信息
     * @param $id
     */
    public function getOneOrder($id) {
        return $this->where('id', $id)->find();
    }

    /**
     * 编辑订单的信息
     * @param $param
     */
    public function editOrder($param) {
        try {

            $result = $this->save($param, ['id' => $param['id']]);

            if (false === $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            } else {

                return msg(1, url('pay/index'), '编辑订单成功');
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 审核订单的信息
     * @param $param
     */
    public function examineOrder($param) {
        try {

            $result = $this->save($param, ['id' => $param['id']]);

            if (false === $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            } else {

                return msg(1, url('pay/index'), '审核成功');
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 删除订单
     * @param $id
     */
    public function delOrder($id) {
        try {

            $this->where('id', $id)->delete();
            return msg(1, '', '删除订单成功');
        } catch (\Exception $e) {
            return msg(-1, '', $e->getMessage());
        }
    }
    
    public function getMomeyorder($where){
        $arr = Db::table('snake_order')->alias('a')->join('snake_member b', 'a.m_id = b.id')->where($where)->select();
        $all = "0";
        foreach ($arr as $v) {
            $all += $v['pay'];
        }
        return $all;
    }
    
    public function getOrderByid($where){
        $info = $this->where($where)->select();
        return $info;
    }

}
