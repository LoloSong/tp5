<?php

namespace app\wechat_shop\model;

use app\common\model\BaseModel;

class UserAddress extends BaseModel {
  protected $hidden = ['create_time', 'update_time', 'delete_time', 'id', 'user_id'];

  public static function getAddressByUserID ($id) {
    $userAddress = self::where('user_id', '=', $id)->find();
    if (is_null($userAddress)) {
      throw new Error(ErrorCodeEnum::PARAMETER_ERROR);
    }
    return $userAddress;
  }
}
