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

class PointModel extends Model {

    // 确定链接表名  积分表
    protected $table = 'snake_point';

    /**
     * 查询积分
     * @param $where
     * @param $offset
     * @param $limit
     */
    public function getPointByWhere($where, $offset, $limit) {
        return $this->where($where)->limit($offset, $limit)->order('id desc')->select();
    }

    /**
     * 根据搜索条件获取所有的积分数量
     * @param $where
     */
    public function getAllPoint($where) {
        return $this->where($where)->count();
    }

    /**
     * 根据积分的id 获取积分的信息
     * @param $id
     */
    public function getOnePoint($id) {
        return $this->where('id', $id)->find();
    }

    /**
     * 添加积分信息
     * @param $param
     */
    public function addPoint($param) {
        try {
            $param['add_time'] = time();
            $result = $this->save($param);
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 根据积分的id 获取积分的信息
     * @param $id
     */
    public function getPoint($id, $type) {
        $where['action_id'] = $id;
        $where['type'] = $type;

        return $this->where($where)->find();
    }

    /**
     * 编辑订单的信息
     * @param $param
     */
    public function editPoint($param) {
        try {

            $result = $this->save($param, ['id' => $param['id']]);
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 删除订单
     * @param $id
     */
    public function delPoint($id) {
        try {

            $this->where('id', $id)->delete();
            return msg(1, '', '删除订单成功');
        } catch (\Exception $e) {
            return msg(-1, '', $e->getMessage());
        }
    }
    
    public function getPoinrByid($where){
        $info = $this->where($where)->select();
        return $info;
    }

}
