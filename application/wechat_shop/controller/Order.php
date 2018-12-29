<?php

namespace app\wechat_shop\controller;

use app\common\controller\BaseController;
use app\common\result\Result;
use app\common\utils\TokenUtils;
use app\common\validate\IDMustBePostiveInt;
use app\wechat_shop\validate\OrderPlace;
use app\wechat_shop\service\Order as OrderService;

class Order extends BaseController {

  protected $beforeActionList = [
    'checkExclusiveScope' => ['only' => 'placeOrder']
  ];

  public function placeOrder () {
    (new OrderPlace())->goCheck();

    $products = request()->post('products');

    $uid = TokenUtils::getValueByToken('uid');

    $order = new OrderService();
    $status = $order->place($uid, $products);

    return Result::success(['data' => $status]);
  }
}
