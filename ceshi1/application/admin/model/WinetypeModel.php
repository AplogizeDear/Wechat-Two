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

class WinetypeModel extends Model {

    // 确定链接表名   酒种类
    protected $table = 'snake_wine_type';

    /**
     * 查询酒种类
     * @param $where
     * @param $offset
     * @param $limit
     */
    public function getWinetypeByWhere($where, $offset, $limit) {
        return $this->where($where)->limit($offset, $limit)->order('id desc')->select();
    }

    /**
     * 根据搜索条件获取所有的文章数量
     * @param $where
     */
    public function getAllWinetype($where) {
        return $this->where($where)->count();
    }

    /**
     * 添加酒种类
     * @param $param
     */
    public function addWinetype($param) {
        try {
            $result = $this->save($param);
            if (false === $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            } else {

                return msg(1, url('winetype/index'), '添加酒种类成功');
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 编辑酒种类信息
     * @param $param
     */
    public function editWinetype($param) {
        try {

            $result = $this->save($param, ['id' => $param['id']]);

            if (false === $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            } else {

                return msg(1, url('winetype/index'), '编辑酒种类成功');
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 根据酒种类的id 获取酒种类的信息
     * @param $id
     */
    public function getOneWinetype($id) {
        return $this->where('id', $id)->find();
    }

    /**
     * 删除酒种类
     * @param $id
     */
    public function delWinetype($id) {
        try {

            $this->where('id', $id)->delete();
            return msg(1, '', '删除酒种类成功');
        } catch (\Exception $e) {
            return msg(-1, '', $e->getMessage());
        }
    }

    /**
     * 查询酒种类
     */
    public function getWinetype() {
        $where['c_id'] = $_SESSION['think']['c_id'];
        return $this->where($where)->order('id desc')->column('id,title');
    }

}
