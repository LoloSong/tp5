<?php

namespace app\common\model;

use think\Model;

class BaseModel extends Model {
  protected function prefixImgUrl ($value, $data) {
    $imgUrl = $value;
    if ($data['from'] === 1) {
      $imgUrl = config('setting.img_prefix') . $value;
    }
    return $imgUrl;
  }
}
