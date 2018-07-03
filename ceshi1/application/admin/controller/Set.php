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

namespace app\admin\controller;

use app\admin\model\SetModel;

class Set extends Base {

    // 支付宝设置
    public function alipay() {
        $set = new SetModel();

        if (request()->isPost()) {
            $param = input('post.');
            $flag = $set->editAlipay($param);
            parent::add_log('修改id为' . $_SESSION['think']['c_id'] . '的支付宝设定');
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
        $info = $set->getAlipay();
        $this->assign([
            'alipay' => $info
        ]);
        return $this->fetch();
    }

    // 微信设置
    public function wx() {
        $set = new SetModel();

        if (request()->isPost()) {
            $param = input('post.');
            $flag = $set->editWx($param);
            parent::add_log('修改id为' . $_SESSION['think']['c_id'] . '的微信设定');
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
        $info = $set->getWx();
        $this->assign([
            'wx' => $info
        ]);
        return $this->fetch();
    }

    // 短信SMS设置
    public function sms() {
        $set = new SetModel();

        if (request()->isPost()) {
            $param = input('post.');
            $flag = $set->editSms($param);
            parent::add_log('修改id为' . $_SESSION['think']['c_id'] . '的短信SMS设定');
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
        $info = $set->getSms();
        $this->assign([
            'sms' => $info
        ]);
        return $this->fetch();
    }

    // 基本设置
    public function base_set() {
        $set = new SetModel();

        if (request()->isPost()) {
            $param = input('post.');
            if ($param['base_logo'] == '') {
                return json(msg(-1, '', 'logo未上传'));
            }
            $flag = $set->editBase($param);
            parent::add_log('修改id为' . $_SESSION['think']['c_id'] . '的基本设定');
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
        $info = $set->getBase();
        $this->assign([
            'base' => $info
        ]);
        return $this->fetch();
    }

    // 积分设置
    public function point_set() {
        $set = new SetModel();

        if (request()->isPost()) {
            $param = input('post.');
            $flag = $set->editPoint($param);
            parent::add_log('修改id为' . $_SESSION['think']['c_id'] . '的积分设定');
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
        $info = $set->getPoint();
        $this->assign([
            'point' => $info
        ]);
        return $this->fetch();
    }

    // 充值设置
    public function recharge() {
        $set = new SetModel();

        if (request()->isPost()) {
            $a = input('post.');
            foreach ($a as $k => $v) {
                $b = explode('_', $k);
                $arr[$b[1]][] = $v;
            }
            $param['recharge'] = json_encode($arr);
            $flag = $set->editRecharge($param);
            parent::add_log('修改id为' . $_SESSION['think']['c_id'] . '的充值设定');
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
        $c = $set->getRecharge();
        $info = json_decode($c['recharge'], true);
        $this->assign([
            'info' => $info
        ]);
        return $this->fetch();
    }

    // 消息提醒设置
    public function remind() {
        $set = new SetModel();

        if (request()->isPost()) {
            $param = input('post.');
            $flag = $set->editRemind($param);
            parent::add_log('修改id为' . $_SESSION['think']['c_id'] . '的消息提醒设定');
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
        $info = $set->getRemind();
        $this->assign([
            'remind' => $info
        ]);
        return $this->fetch();
    }

    // 上传缩略图
    public function uploadImg() {
        if (request()->isAjax()) {

            $file = request()->file('file');
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'upload');
            if ($info) {
                $src = '/upload' . '/' . date('Ymd') . '/' . $info->getFilename();
                return json(msg(0, ['src' => $src], ''));
            } else {
                // 上传失败获取错误信息
                return json(msg(-1, '', $file->getError()));
            }
        }
    }

}
