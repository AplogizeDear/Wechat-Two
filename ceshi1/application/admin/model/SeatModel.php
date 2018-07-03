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

class SeatModel extends Model {

    // 确定链接表名   台桌表
    protected $table = 'snake_seat';

    /**
     * 查询台桌
     * @param $where
     * @param $offset
     * @param $limit
     */
    public function getSeatByWhere($where, $offset, $limit) {
        return $this->where($where)->limit($offset, $limit)->order('id desc')->select();
    }

    /**
     * 根据搜索条件获取所有的台桌数量
     * @param $where
     */
    public function getAllSeat($where) {
        return $this->where($where)->count();
    }

    /**
     * 添加台桌
     * @param $param
     */
    public function addSeat($param) {
        try {
            $result = $this->save($param);
            if (false === $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            } else {

                return msg(1, url('seat/index'), '添加台桌成功');
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 编辑台桌信息
     * @param $param
     */
    public function editSeat($param) {
        try {

            $result = $this->save($param, ['id' => $param['id']]);

            if (false === $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            } else {

                return msg(1, url('seat/index'), '编辑台桌成功');
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 根据台桌的id 获取台桌的信息
     * @param $id
     */
    public function getOneSeat($id) {
        return $this->where('id', $id)->find();
    }

    /**
     * 删除台桌
     * @param $id
     */
    public function delSeat($id) {
        try {

            $this->where('id', $id)->delete();
            return msg(1, '', '删除台桌成功');
        } catch (\Exception $e) {
            return msg(-1, '', $e->getMessage());
        }
    }

    /**
     * 查询所有台桌
     */
    public function getSeat() {
        $where['c_id'] = $_SESSION['think']['c_id'];
        return $this->where($where)->order('id desc')->column('id,name');
    }

    /**
     * 根据台桌的id 获取台桌名
     * @param $id
     */
    public function getnameSeat($id) {
        $arr = $this->where('id', $id)->find();
        return $arr['name'];
    }
    
    /**
     * 查询所有台桌
     */
    public function getSeatall($where) {
        return $this->where($where)->order('id asc')->select();
    }

}
