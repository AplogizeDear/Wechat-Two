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

class BrandscateModel extends Model {

    // 确定链接表名  集团，品牌，门店
    protected $table = 'snake_brands_cate';

    /**
     * 查询
     * @param $where
     * @param $offset
     * @param $limit
     */
    public function getBrandscateByWhere($where, $offset, $limit) {
        return $this->where($where)->limit($offset, $limit)->order('id desc')->select();
    }

    /**
     * 根据搜索条件获取所有数量
     * @param $where
     */
    public function getAllBrandscate($where) {
        return $this->where($where)->count();
    }

    /**
     * 添加
     * @param $param
     */
    public function addBrandscate($param, $url) {
        try {
            $result = $this->save($param);
            if (false === $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            } else {
                return msg(1, url('brandscate/' . $url), '添加成功');
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 编辑信息
     * @param $param
     */
    public function editBrandscate($param, $url) {
        try {

            $result = $this->save($param, ['id' => $param['id']]);

            if (false === $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            } else {

                return msg(1, url('brandscate/' . $url), '编辑成功');
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 根据的id 获取的信息
     * @param $id
     */
    public function getOneBrandscate($id) {
        return $this->where('id', $id)->find();
    }

    /**
     *  获取集团的信息
     * @param $id
     */
    public function getGroup() {
        return $this->where('pid', 0)->column('id,name');
    }

    /**
     * 删除
     * @param $id
     */
    public function delBrandscate($id) {
        try {

            $this->where('id', $id)->delete();
            return msg(1, '', '删除成功');
        } catch (\Exception $e) {
            return msg(-1, '', $e->getMessage());
        }
    }

    /**
     *  获取id的信息
     * @param $id
     */
    public function getGroupbyid($id) {
        $a = $this->where('id', $id)->find();
        return $a['name'];
    }

    /**
     *  获取品牌的信息
     * @param $id
     */
    public function getStorebyid($id) {
        return $this->where('pid', $id)->column('id,name');
    }

}
