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

class WinebrandModel extends Model {

    // 确定链接表名   酒品牌
    protected $table = 'snake_wine_brand';

    /**
     * 查询酒品牌
     * @param $where
     * @param $offset
     * @param $limit
     */
    public function getWinebrandByWhere($where, $offset, $limit) {
        $info = Db::table('snake_wine_brand')->alias('a')->join('snake_wine_type b', 'a.t_id = b.id', 'left')->field('a.*,b.title')->where($where)->limit($offset, $limit)->order('a.id desc')->select();
        return $info;
    }

    /**
     * 根据搜索条件获取所有的酒品牌数量
     * @param $where
     */
    public function getAllWinebrand($where) {
        return Db::table('snake_wine_brand')->alias('a')->join('snake_wine_type b', 'a.t_id = b.id', 'left')->where($where)->count();
    }

    /**
     * 添加酒品牌
     * @param $param
     */
    public function addWinebrand($param) {
        try {
            $result = $this->save($param);
            if (false === $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            } else {

                return msg(1, url('winetype/winebrand'), '添加酒品牌成功');
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 编辑酒品牌信息
     * @param $param
     */
    public function editWinebrand($param) {
        try {

            $result = $this->save($param, ['id' => $param['id']]);

            if (false === $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            } else {

                return msg(1, url('winetype/winebrand'), '编辑酒品牌成功');
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 根据酒品牌的id 获取酒品牌的信息
     * @param $id
     */
    public function getOneWinebrand($id) {
        return $this->where('id', $id)->find();
    }

    /**
     * 删除酒品牌
     * @param $id
     */
    public function delWinebrand($id) {
        try {

            $this->where('id', $id)->delete();
            return msg(1, '', '删除酒品牌成功');
        } catch (\Exception $e) {
            return msg(-1, '', $e->getMessage());
        }
    }

    /**
     * 查询酒品牌
     */
    public function getWinebrand($id) {
        return $this->where('t_id', $id)->order('id desc')->column('id,name');
    }

}
