<?php

namespace app\wechat_shop\controller;

use app\common\controller\BaseController;
use app\common\validate\IDMustBePostiveInt;
use app\wechat_shop\service\Pay as PayService;
use think\Controller;
use think\Request;

class Pay extends BaseController {

//  protected $beforeActionList = [
//    'checkExclusiveScope' => ['only' => 'getPreOrder']
//  ];

  public function getPreOrder ($id = '') {
    (new IDMustBePostiveInt())->goCheck();
    $pay = new PayService($id);

    dump($pay->pay());
  }
}
