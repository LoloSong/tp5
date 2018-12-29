<?php

namespace app\wechat_shop\model;

use app\common\model\BaseModel;

class Order extends BaseModel {
  protected $hidden = ['user_id', 'create_time', 'update_time', 'delete_time'];

  public static function getOrderByID ($id) {
    $order = self::where('id', '=', $id)->find();
    if (is_null($order)) {
      throw new Error(ErrorCodeEnum::PARAMETER_ERROR);
    }
    return $order;
  }
}
