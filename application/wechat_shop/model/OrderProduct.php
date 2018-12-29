<?php

namespace app\wechat_shop\model;

use app\common\model\BaseModel;

class OrderProduct extends BaseModel {
  public static function getProductByOrderID ($orderID) {
    $product = self::where('order_id', '=', $orderID)->select();
    if (empty($product)) {
      throw new Error(ErrorCodeEnum::NOT_NETWORK);
    }
    return $product;
  }
}
