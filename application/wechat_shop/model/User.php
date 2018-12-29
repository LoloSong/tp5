<?php

namespace app\wechat_shop\model;

use app\common\enums\ErrorCodeEnum;
use app\common\exception\Error;
use app\common\model\BaseModel;

class User extends BaseModel {

  public function address () {
    return $this->hasOne('UserAddress', 'user_id', 'id');
  }

  public static function getByOpenID ($openid) {
    $user = self::where('openid', '=', $openid)->find();
    if (is_null($user)) {
      throw new Error(ErrorCodeEnum::PARAMETER_ERROR);
    }
    return $user;
  }

  public static function getByID ($id) {
    $user = self::get($id);
    if (is_null($user)) {
      throw new Error(ErrorCodeEnum::PARAMETER_ERROR);
    }
    return $user;
  }
}
