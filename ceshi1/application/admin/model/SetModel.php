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

class SetModel extends Model {

    // 确定链接表名  设置表
    protected $table = 'snake_set';

    /**
     * 支付宝设置
     */
    public function getAlipay() {
        $info = $this->getCon();
        return $info;
    }

    /**
     * 编辑支付宝信息
     * @param $param
     */
    public function editAlipay($param) {
        try {
            $where['id'] = $_SESSION['think']['c_id'];
            $result = $this->save($param, $where);
            if (false === $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            } else {

                return msg(1, url('set/alipay'), '编辑支付宝设置成功');
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 微信设置
     */
    public function getWx() {
        $info = $this->getCon();

        return $info;
    }

    /**
     * 编辑微信信息
     * @param $param
     */
    public function editWx($param) {
        try {
            $where['id'] = $_SESSION['think']['c_id'];
            $result = $this->save($param, $where);
            if (false === $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            } else {

                return msg(1, url('set/wx'), '编辑微信设置成功');
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 短信设置
     */
    public function getSms() {
        $info = $this->getCon();

        return $info;
    }

    /**
     * 编辑短信信息
     * @param $param
     */
    public function editSms($param) {
        try {
            $where['id'] = $_SESSION['think']['c_id'];
            $result = $this->save($param, $where);
            if (false === $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            } else {

                return msg(1, url('set/sms'), '编辑短信设置成功');
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 基本设置
     */
    public function getBase() {
        $info = $this->getCon();

        return $info;
    }

    /**
     * 编辑基本设定
     * @param $param
     */
    public function editBase($param) {
        try {
            $where['id'] = $_SESSION['think']['c_id'];
            $result = $this->save($param, $where);
            if (false === $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            } else {

                return msg(1, url('set/base_set'), '编辑基本设置成功');
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 积分设置
     */
    public function getPoint() {
        $info = $this->getCon();

        return $info;
    }

    /**
     * 编辑积分信息
     * @param $param
     */
    public function editPoint($param) {
        try {
            $where['id'] = $_SESSION['think']['c_id'];
            $result = $this->save($param, $where);
            if (false === $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            } else {
                return msg(1, url('set/point_set'), '编辑积分设置成功');
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 短信充值
     */
    public function getRecharge() {
        $info = $this->getCon();

        return $info;
    }

    /**
     * 编辑充值信息
     * @param $param
     */
    public function editRecharge($param) {
        try {
            $where['id'] = $_SESSION['think']['c_id'];
            $result = $this->save($param, $where);
            if (false === $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            } else {
                return msg(1, url('set/recharge'), '编辑积分设置成功');
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 消息提醒设置
     */
    public function getRemind() {
        $info = $this->getCon();

        return $info;
    }

    /**
     * 编辑消息提醒信息
     * @param $param
     */
    public function editRemind($param) {
        try {
            $where['id'] = $_SESSION['think']['c_id'];
            $result = $this->save($param, $where);
            if (false === $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $this->getError());
            } else {
                return msg(1, url('set/remind'), '编辑消息提醒设置成功');
            }
        } catch (\Exception $e) {
            return msg(-2, '', $e->getMessage());
        }
    }

    /**
     * 根据设定的值 获取设定信息
     * @param $name
     */
    public function getCon() {
        $where['id'] = $_SESSION['think']['c_id'];
        $info = $this->where($where)->find();
        return $info;
    }

    /**
     * 添加设定
     * @param $param
     */
    public function addSet($param) {
        $result = $this->insertGetId($param);
        if ($result) {
            return $result;
        }
    }

    /**
     * 查找设定
     * @param $param
     */
    public function findSet($param) {
        $result = $this->where($param)->find();
        if ($result) {
            return $result;
        }
    }

    /**
     * 保存设定
     * @param $param
     */
    public function saveSet($param) {
        $result = $this->save($param, ['id' => $param['id']]);
        if ($result) {
            return $result;
        }
    }
    
    /**
     * 根据设定的值 获取设定信息
     * @param $name
     */
    public function getcofs($where) {
        $info = $this->where($where)->find();
        return $info;
    }
}
