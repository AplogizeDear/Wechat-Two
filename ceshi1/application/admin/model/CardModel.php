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

class CardModel extends Model {

    // 确定链接表名  活动表  会员卡
    protected $table = 'snake_card';

    /**
     * 查询会员卡
     * @param $where
     * @param $offset
     * @param $limit
     */
    public function getCardByWhere($where, $offset, $limit) {
        return $this->where($where)->limit($offset, $limit)->order('id desc')->select();
    }

    /**
     * 根据搜索条件获取所有的会员卡数量
     * @param $where
     */
    public function getAllCard($where) {
        return $this->where($where)->count();
    }

    /**
     * 添加会员卡
     * @param $param
     */
    public function addCard($param) {
        try {
            $result = $this->save($param);
            if (false === $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            } else {

                return msg(1, url('card/index'), '添加活动成功');
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 编辑会员卡信息
     * @param $param
     */
    public function editCard($param) {
        try {

            $result = $this->save($param, ['id' => $param['id']]);

            if (false === $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            } else {

                return msg(1, url('card/index'), '编辑会员卡成功');
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 根据会员卡的id 获取会员卡的信息
     * @param $id
     */
    public function getOneCard($id) {
        return $this->where('id', $id)->find();
    }

    /**
     * 删除会员卡
     * @param $id
     */
    public function delCard($id) {
        try {

            $this->where('id', $id)->delete();
            return msg(1, '', '删除会员卡成功');
        } catch (\Exception $e) {
            return msg(-1, '', $e->getMessage());
        }
    }
    
    public function grtCardbycid($where) {
            return $this->where($where)->select();
    }
}
