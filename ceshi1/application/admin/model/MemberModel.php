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

class MemberModel extends Model {

    // 确定链接表名   用户表
    protected $table = 'snake_member';

    /**
     * 查询用户
     * @param $where
     * @param $offset
     * @param $limit
     */
    public function getMemberByWhere($where, $offset, $limit) {
        return $this->where($where)->limit($offset, $limit)->order('id desc')->select();
    }

    /**
     * 根据搜索条件获取所有的用户数量
     * @param $where
     */
    public function getAllMember($where) {
        return $this->where($where)->count();
    }
    
    /**
     * 编辑用户信息
     * @param $param
     */
    public function editMember($param) {
        try {

            $result = $this->save($param, ['id' => $param['id']]);

            if (false === $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            } else {

                return msg(1, url('member/index'), '修改成功');
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 根据用户的id 获取用户的信息
     * @param $id
     */
    public function getOneMember($id) {
        return $this->where('id', $id)->find();
    }

    /**
     * 查询所有用户
     */
    public function getMember() {
        $where['c_id'] = $_SESSION['think']['c_id'];
        return $this->where($where)->order('id desc')->field('id,nickname')->select();
    }

    /**
     * 根据用户的id 获取用户名
     * @param $id
     */
    public function getnameMember($id) {
        $user = $this->where('id', $id)->find();
        return $user['nickname'];
    }

    /**
     * 检查余额是否足够支付订单
     */
    public function checkMoney($param) {
        try {
            $result = $this->where('id', $param['m_id'])->find();
            $info['point'] = $result['point'] + $param['point'];
            if ($result['money'] >= $param['pay']) {
                $info['money'] = $result['money'] - $param['pay'];
                return msg(2, '', $info);
            } else {
                // 验证失败
                return msg(1, url('pay/index'), '用户余额小于订单金额，买单失败');
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 余额支付订单
     */
    public function payMoney($param) {
        try {
            $result = $this->save($param, ['id' => $param['id']]);

            if (false === $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            } else {

                return 1;
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }
    //通过openid与公司id获取用户信息
    public function getMemberbyopenid($where){
        return $this->where($where)->find();
    }

}
