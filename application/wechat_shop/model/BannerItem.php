<?php

namespace app\wechat_shop\model;

use app\common\model\BaseModel;

class BannerItem extends BaseModel {

  protected $hidden = ['id', 'create_time', 'delete_time', 'update_time', 'img_id', 'banner_id'];

  public function img () {
    return $this->belongsTo('Image', 'img_id', 'id');
  }
}
