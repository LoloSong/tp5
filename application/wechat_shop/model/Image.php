<?php

namespace app\wechat_shop\model;

use app\common\model\BaseModel;

class Image extends BaseModel {
  protected $hidden = ['id', 'create_time', 'update_time', 'delete_time', 'from'];

  public function getUrlAttr($value, $data) {
    return $this->prefixImgUrl($value, $data);
  }
}
