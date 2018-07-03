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

class StockModel extends Model {

    // 确定链接表名   库存表
    protected $table = 'snake_wine_stock';

    /**
     * 查询库存
     * @param $where
     * @param $offset
     * @param $limit
     */
    public function getStockByWhere($where, $offset, $limit) {
        $info = Db::table('snake_wine_stock')
                ->alias('a')
                ->join('snake_member b', 'a.m_id = b.id', 'left')
                ->field('a.*,b.nickname')
                ->where($where)
                ->where(function ($query) {
                    $query->where('a.num', 'gt', 0)->whereor('a.nums', 'gt', 0);
                })
                ->limit($offset, $limit)
                ->order('a.id desc')
                ->select();
        return $info;
    }

    /**
     * 根据搜索条件获取所有的库存数量
     * @param $where
     */
    public function getAllKeepout($where) {
        return Db::table('snake_wine_stock')
                        ->alias('a')
                        ->join('snake_member b', 'a.m_id = b.id', 'left')
                        ->field('a.*,b.nickname')
                        ->where($where)
                        ->where(function ($query) {
                            $query->where('a.num', 'gt', 0)->whereor('a.nums', 'gt', 0);
                        })
                        ->order('a.id desc')
                        ->count();
    }

    /**
     * 根据存客户的id 获取库存表的信息
     * @param $id
     */
    public function getStock($id) {
        return $this->where('m_id', $id)->select();
    }

    /**
     * 根据明细表id 获取库存表的信息
     * @param $id
     */
    public function getStockbyid($id) {
        return $this->where('id', $id)->find();
    }

    /**
     * 根据存取酒表的id 获取存取酒表的信息如果不存在则增加
     * @param $id
     */
    public function checkStock($arr) {
        foreach ($arr as $k => $v) {
            $where['m_id'] = $v['mid'];
            $where['t_id'] = $v['tid'];
            $where['b_id'] = $v['bid'];
            $where['use_day'] = $v['use_day'];
            $id = $this->where($where)->find();
            if ($id) {
                $data['num'] = $id['num'] + $v['num'];
                $data['nums'] = $id['nums'] + $v['nums'];
                $result = $this->save($data, ['id' => $id['id']]);
                $ids[$k]['id'] = $id['id'];
            } else {
                $where['num'] = $v['num'];
                $where['nums'] = $v['nums'];
                $where['c_id'] = $_SESSION['think']['c_id'];
                $result = $this->insertGetId($where);
                $ids[$k]['id'] = $result;
            }
            $ids[$k]['num'] = $v['num'];
            $ids[$k]['nums'] = $v['nums'];
            $ids[$k]['useday'] = $v['use_day'];
        }
        return $ids;
    }

    /**
     * 根据存取酒表的id 获取存取酒表数量，如果不符合则报错
     * @param $id
     */
    public function checkoutStock($arr) { {
            try {
                foreach ($arr as $k => $v) {
                    $where['id'] = $v['id'];
                    $id = $this->where($where)->find();
                    if ($id) {
                        if ($id['num'] < $v['num']) {
                            return msg(-1, '', "超出最大值");
                        }
                    }
                }
            } catch (\Exception $e) {
                return msg(-1, '', $e->getMessage());
            }
        }
    }

    /**
     * 修改存酒  更新数量
     * @param $id
     */
    public function editStock($arr) {
        foreach ($arr as $k => $v) {
            $where['id'] = $v['st_id'];
            $info = $this->where($where)->find();
            if ($v['type'] == 1) {
                $data['num'] = $info['num'] + $v['num'];
                $data['nums'] = $v['nums'];
            } elseif ($v['type'] == 2) {
                $data['num'] = $info['num'] - $v['num'];
                if ($v['nums'] == $v['nums_max']) {
                    $data['nums'] = $v['nums_maxs'];
                } else {
                    $data['nums'] = $v['nums_max'];
                }
            }
            $data['use_day'] = $v['use_day'];
            $this->where(['id' => $v['st_id']])->update($data);
        }
        return msg(1, url('keepout/index'), '编辑存酒成功');
    }

    /**
     * 删除后，更新数量
     * @param $id
     */
    public function delStock($arr) {
        foreach ($arr as $k => $v) {
            $where['id'] = $v['st_id'];
            $wheres['id'] = $v['k_id'];
            $infos = Db::table('snake_wine_keepout')->where($wheres)->find();
            $info = $this->where($where)->find();
            if ($infos['type'] == 1) {
                $data['num'] = $info['num'] - $v['num'];
                if ($info['nums'] == $v['nums']) {
                    $data['nums'] = 0;
                }
            } elseif ($infos['type'] == 2) {
                $data['num'] = $info['num'] + $v['num'];
                if ($info['nums'] == 0) {
                    $data['nums'] = $v['nums'];
                }
            }
            if ($data['num'] < 0 or $data['nums'] < 0) {
                return msg(-1, '', "不能删除");
            }
            $this->where(['id' => $v['st_id']])->update($data);
        }
    }

    /**
     * 取酒后，更新数量
     * @param $id
     */
    public function outStock($arr) {
        foreach ($arr as $k => $v) {
            $where['id'] = $v['id'];
            $data = array();
            $info = $this->where($where)->find();
            $data['num'] = $info['num'] - $v['num'];
            if ($info['nums'] == $v['nums']) {
                $data['nums'] = 0;
            }
            $this->where(['id' => $v['id']])->update($data);
        }
        return msg(1, url('keepout/index'), '存酒成功');
    }

    /**
     * 修改有效期
     * @param $id
     */
    public function timeStock($param) {
        try {

            $result = $this->save($param, ['id' => $param['id']]);

            if (false === $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            } else {

                return msg(1, url('keepout/keepoutExpire'), '有效期修改成功');
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 删除存取明细表通过st_id
     * @param $id
     */
    public function delStocks($id) {
        try {
            $this->where('id', $id)->delete();
            return msg(1, '', '删除成功');
        } catch (\Exception $e) {
            return msg(-1, '', $e->getMessage());
        }
    }
    
    /**
     * 查询库存
     * @param $where
     * @param $offset
     * @param $limit
     */
    public function getStocktime($where) {
        $info = Db::table('snake_wine_stock')
                ->where($where)
                ->where(function ($query) {
                    $query->where('num', 'gt', 0)->whereor('nums', 'gt', 0);
                })
                ->select();
        return $info;
    }

}
