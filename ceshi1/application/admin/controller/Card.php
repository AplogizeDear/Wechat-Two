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

use app\admin\model\CardModel;

class Card extends Base {

    // 会员卡列表
    public function index() {

        if (request()->isAjax()) {

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (!empty($param['searchText'])) {
                $where['name'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $where['c_id'] = $_SESSION['think']['c_id'];
            $card = new CardModel();
            $selectResult = $card->getCardByWhere($where, $offset, $limit);

            foreach ($selectResult as $key => $vo) {
                $selectResult[$key]['image'] = '<img src="' . $vo['image'] . '" width="40px" height="40px">';
                $selectResult[$key]['operate'] = showOperate($this->makeButton($vo['id']));
            }

            $return['total'] = $card->getAllCard($where);  // 总数据
            $return['rows'] = $selectResult;

            return json($return);
        }
        return $this->fetch();
    }

    // 添加会员卡
    public function cardAdd() {
        if (request()->isPost()) {
            $param = input('post.');
            unset($param['file']);
            $param['c_id'] = $_SESSION['think']['c_id'];
            if ($param['image'] == '') {
                return json(msg(-1, '', '海报未上传'));
            }
            $card = new CardModel();
            $flag = $card->addCard($param);
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }

        return $this->fetch();
    }

    //编辑会员卡
    public function cardEdit() {
        $card = new CardModel();

        if (request()->isPost()) {
            $param = input('post.');
            unset($param['file']);
            if ($param['image'] == '') {
                return json(msg(-1, '', '海报未上传'));
            }
            $flag = $card->editCard($param);
            return json(msg($flag['code'], $flag['data'], $flag['msg']));
        }
        $id = input('param.id');
        $info = $card->getOneCard($id);
        $this->assign([
            'info' => $info
        ]);

        return $this->fetch();
    }

    //删除会员卡
    public function cardDel() {
        $id = input('param.id');

        $card = new CardModel();
        $flag = $card->delCard($id);
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
                'auth' => 'card/cardedit',
                'href' => url('card/cardedit', ['id' => $id]),
                'btnStyle' => 'primary',
                'icon' => 'fa fa-paste'
            ],
            '删除' => [
                'auth' => 'card/carddel',
                'href' => "javascript:cardDel(" . $id . ")",
                'btnStyle' => 'danger',
                'icon' => 'fa fa-trash-o'
            ]
        ];
    }

}
