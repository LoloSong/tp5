<?php

namespace app\wechat_shop\model;

use app\common\model\BaseModel;

class ProductImage extends BaseModel {
  protected $hidden = ['create_time', 'update_time', 'delete_time', 'img_id', 'product_id'];

  public function imgUrl () {
    return $this->belongsTo('Image', 'img_id', 'id');
  }
}
