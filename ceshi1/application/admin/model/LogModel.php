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

class LogModel extends Model {

    // 确定链接表名  活动表
    protected $table = 'snake_log';

    /**
     * 查询活动
     * @param $where
     * @param $offset
     * @param $limit
     */
    public function getLogByWhere($where, $offset, $limit) {
        return $this->where($where)->limit($offset, $limit)->order('id desc')->select();
    }

    /**
     * 根据搜索条件获取所有的活动数量
     * @param $where
     */
    public function getAllLog($where) {
        return $this->where($where)->count();
    }
}
