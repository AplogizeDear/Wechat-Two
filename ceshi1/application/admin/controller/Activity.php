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

use app\admin\model\ActivityModel;

class Activity extends Base {

    // 活动列表
    public function index() {

        if (request()->isAjax()) {

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (!empty($param['searchText'])) {
                $where['title'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $where['c_id'] = $_SESSION['think']['c_id'];
            $activity = new ActivityModel();
            $selectResult = $activity->getActivityByWhere($where, $offset, $limit);

            foreach ($selectResult as $key => $vo) {
                $selectResult[$key]['add_time'] = date('Y-m-d H:i:s', $vo['add_time']);
                $selectResult[$key]['start_time'] = date('Y-m-d H:i:s', $vo['start_time']);
                $selectResult[$key]['end_time'] = date('Y-m-d H:i:s', $vo['end_time']);
                $selectResult[$key]['banner'] = '<img src="' . $vo['banner'] . '" width="40px" height="40px">';
                $selectResult[$key]['operate'] = showOperate($this->makeButton($vo['id']));
                if($vo['status'] == 1){
                    $selectResult[$key]['status'] = '<button class="button_s">有效</button>';
                }elseif($vo['status'] == 2){
                    $selectResult[$key]['status'] = '<button class="button_s" style="background-color:#A9A9A9">失效</button>';
                }
            }

            $return['total'] = $activity->getAllActivity($where);  // 总数据
            $return['rows'] = $selectResult;

            return json($return);
        }
        return $this->fetch();
    }

    // 添加活动
    public function activityAdd() {
        if (request()->isPost()) {
            $param = input('post.');

            unset($param['file']);
            $param['add_time'] = time();
            $param['start_time'] = strtotime($param['start_time']);
            $param['end_time'] = strtotime($param['end_time']);
            $param['c_id'] = $_SESSION['think']['c_id'];
            if ($param['banner'] == '') {
                return json(msg(-1, '', '海报未上传'));
            }
            $activity = new ActivityModel();
            $flag = $activity->addActivity($param);
            parent::add_log('添加活动');
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }

        return $this->fetch();
    }

    //编辑活动
    public function activityEdit() {
        $activity = new ActivityModel();

        if (request()->isPost()) {
            $param = input('post.');
            unset($param['file']);
            $param['start_time'] = strtotime($param['start_time']);
            $param['end_time'] = strtotime($param['end_time']);
            if ($param['banner'] == '') {
                return json(msg(-1, '', '海报未上传'));
            }
            $flag = $activity->editActivity($param);
            parent::add_log('id为' . $param['id'] . '的活动进行了修改');
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
        $id = input('param.id');
        $info = $activity->getOneActivity($id);
        $info['start_time'] = date("Y-m-d",$info['start_time']);
        $info['end_time'] = date("Y-m-d",$info['end_time']);
        $this->assign([
            'activity' => $info
        ]);

        return $this->fetch();
    }

    //删除活动
    public function activityDel() {
        $id = input('param.id');

        $activity = new ActivityModel();
        $flag = $activity->delActivity($id);
        parent::add_log('id为' . $id . '的活动进行了删除');
        return json(msg($flag['code'], $flag['data'], $flag['msg']));
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

    /**
     * 拼装操作按钮
     * @param $id
     * @return array
     */
    private function makeButton($id) {
        return [
            '编辑' => [
                'auth' => 'activity/activityedit',
                'href' => url('activity/activityedit', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '删除' => [
                'auth' => 'activity/activitydel',
                'href' => "javascript:articleDel(" . $id . ")",
                'btnStyle' => 'danger',
                'icon' => 'fa fa-trash-o'
            ]
        ];
    }

}
