<?php

namespace app\wechat_shop\model;

use app\common\enums\ErrorCodeEnum;
use app\common\exception\Error;
use app\common\model\BaseModel;

class Banner extends BaseModel {

  protected $hidden = ['id', 'create_time', 'delete_time', 'update_time'];

  public function items () {
    return $this->hasMany('BannerItem', 'banner_id', 'id');
  }

  public static function getBannerByID ($id) {
    $banner = self::with(['items' , 'items.img'])->find($id);

    if (is_null($banner)) {
      throw new Error(ErrorCodeEnum::PARAMETER_ERROR);
    }

    return $banner;
  }

}
