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

class OutcursorModel extends Model {

    // 确定链接表名  活动表
    protected $table = 'snake_out_cursor';

    /**
     * 添加取酒临时数据
     * @param $param
     */
    public function addOutcursor($param) {
            $result = $this->insertGetId($param);
        if ($result) {
            return $result;
        }
    }

    /**
     * 根据id 获取取酒临时数据
     * @param $id
     */
    public function getOneOutcursor($id) {
        return $this->where('id', $id)->find();
    }

    

}
