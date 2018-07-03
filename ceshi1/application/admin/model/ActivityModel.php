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

class ActivityModel extends Model {

    // 确定链接表名  活动表
    protected $table = 'snake_activity';

    /**
     * 查询活动
     * @param $where
     * @param $offset
     * @param $limit
     */
    public function getActivityByWhere($where, $offset, $limit) {
        return $this->where($where)->limit($offset, $limit)->order('id desc')->select();
    }

    /**
     * 根据搜索条件获取所有的活动数量
     * @param $where
     */
    public function getAllActivity($where) {
        return $this->where($where)->count();
    }

    /**
     * 添加活动
     * @param $param
     */
    public function addActivity($param) {
        try {
            $result = $this->save($param);
            if (false === $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            } else {

                return msg(1, url('activity/index'), '添加活动成功');
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 编辑活动信息
     * @param $param
     */
    public function editActivity($param) {
        try {

            $result = $this->save($param, ['id' => $param['id']]);

            if (false === $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            } else {

                return msg(1, url('activity/index'), '编辑活动成功');
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 根据活动的id 获取活动的信息
     * @param $id
     */
    public function getOneActivity($id) {
        return $this->where('id', $id)->find();
    }

    /**
     * 删除活动
     * @param $id
     */
    public function delActivity($id) {
        try {

            $this->where('id', $id)->delete();
            return msg(1, '', '删除活动成功');
        } catch (\Exception $e) {
            return msg(-1, '', $e->getMessage());
        }
    }
    
    public function getActivityBycid($where){
        return $this->where($where)->order('id desc')->select();
    }

}
