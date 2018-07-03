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

class KeepoutModel extends Model {

    // 确定链接表名   存取酒
    protected $table = 'snake_wine_keepout';

    /**
     * 查询存取酒
     * @param $where
     * @param $offset
     * @param $limit
     */
    public function getKeepoutByWhere($where, $offset, $limit) {
        $info = Db::table('snake_wine_keepout')
                ->alias('a')
                ->join('snake_member b', 'a.m_id = b.id', 'left')
                ->field('a.*,b.nickname')
                ->where($where)
                ->limit($offset, $limit)
                ->order('a.id desc')
                ->select();
        return $info;
    }

    /**
     * 根据搜索条件获取所有的存取酒数量
     * @param $where
     */
    public function getAllKeepout($where) {
        return Db::table('snake_wine_keepout')
                        ->alias('a')
                        ->join('snake_member b', 'a.m_id = b.id', 'left')
                        ->field('a.*,b.nickname')
                        ->where($where)
                        ->order('a.id desc')
                        ->count();
    }

    /**
     * 添加存取酒
     * @param $param
     */
    public function addKeepout($param) {
        $result = $this->insertGetId($param);
        if ($result) {
            return $result;
        }
    }

    /**
     * 根据存取酒表的id 获取存取酒表的信息
     * @param $id
     */
    public function getOneKeepout($id) {
        return $this->where('id', $id)->find();
    }

    /**
     * 删除存取酒表
     * @param $id
     */
    public function delKeepout($id) {
        try {

            $this->where('id', $id)->delete();
            return msg(1, '', '删除存取酒成功');
        } catch (\Exception $e) {
            return msg(-1, '', $e->getMessage());
        }
    }

    /**
     * 编辑存取酒表
     * @param $id
     */
    public function editKeepout($param) {
        try {
            $result = $this->save($param, ['id' => $param['id']]);

            if (false === $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            } else {

                return msg(1, url('keepout/index'), '取酒编辑成功');
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }
    
    public function outList($where) {
        return $this->where($where)->select();
    }

}
