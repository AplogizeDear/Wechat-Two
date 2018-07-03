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

class KeepoutinfoModel extends Model {

    // 确定链接表名  存取酒明细表
    protected $table = 'snake_wine_info';

    /**
     * 查询存取酒明细
     * @param $where
     * @param $offset
     * @param $limit
     */
    public function getKeepoutinfoByWhere($where, $offset, $limit) {
        return $this->where($where)->limit($offset, $limit)->order('id desc')->select();
    }

    /**
     * 根据搜索条件获取所有的存取酒明细数量
     * @param $where
     */
    public function getAllKeepoutinfo($where) {
        return $this->where($where)->count();
    }

    /**
     * 添加存取明细表
     * @param $param
     */
    public function addKeepoutinfo($k_id, $ids, $type) {
//            $b = json_encode($k_id);
//            file_put_contents("test.txt",$b);
//            $c = json_encode($ids);
//            file_put_contents("test1.txt",$c);
        foreach ($ids as $vo) {
            $param['st_id'] = $vo['id'];
            $param['num'] = $vo['num'];
            $param['nums'] = $vo['nums'];
            $param['k_id'] = $k_id;
            $param['c_id'] = $_SESSION['think']['c_id'];
            if ($type == 1) {
                $param['use_day'] = $vo['useday'];
            } elseif ($type == 2) {
                $param['use_day'] = strtotime(date("Y-m-d"), time()) + ($vo['useday'] + 1) * 86400;
            }
            $result = $this->insertGetId($param);
            if (false === $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            }
        }
        return msg(1, url('keepout/index'), '自主存取酒成功');
    }

    /**
     * 编辑存取明细表
     * @param $param
     */
    public function editKeepoutinfo($ids) {
        foreach ($ids as $k => $vo) {
            $info = $this->where('id', $vo['id'])->find();
            $infos[$k]['type'] = $vo['type'];
            $infos[$k]['st_id'] = $info['st_id'];
            $infos[$k]['num'] = $vo['num'] - $info['num'];
            $infos[$k]['nums'] = $vo['nums'];
            $infos[$k]['nums_max'] = $vo['numsmax'];
            $infos[$k]['nums_maxs'] = $vo['numsmaxs'];
            $infos[$k]['use_day'] = ($vo['useday'] + 1) * 60 * 60 * 24 + strtotime(date("Y-m-d"), time());
            $param['num'] = $vo['num'];
            $param['nums'] = $vo['nums'];
            $param['use_day'] = $infos[$k]['use_day'];
            $this->where(['id' => $vo['id']])->update($param);
        }
        return $infos;
    }

    /**
     * 根据存酒表id 获取明细表的信息
     * @param $id
     */
    public function getKeepoutinfo($id) {
        return $this->where('k_id', $id)->select();
    }

    /**
     * 根据库存id 获取明细表的信息
     * @param $id
     */
    public function getKeepoutinfos($id) {
        return $this->where('st_id', $id)->select();
    }

    /**
     * 删除存取明细表通过k_id
     * @param $id
     */
    public function delKeepoutinfo($id) {
        try {
            $this->where('k_id', $id)->delete();
            return msg(1, '', '删除明细表成功');
        } catch (\Exception $e) {
            return msg(-1, '', $e->getMessage());
        }
    }

    /**
     * 删除存取明细表通过st_id
     * @param $id
     */
    public function delKeepoutinfos($id) {
        try {
            $this->where('st_id', $id)->delete();
            return msg(1, '', '删除明细表成功');
        } catch (\Exception $e) {
            return msg(-1, '', $e->getMessage());
        }
    }

}
