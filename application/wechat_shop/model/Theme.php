<?php

namespace app\wechat_shop\model;

use app\common\enums\ErrorCodeEnum;
use app\common\exception\Error;
use app\common\model\BaseModel;

class Theme extends BaseModel {

  protected $hidden = ['create_time', 'update_time', 'delete_time', 'topic_img_id', 'head_img_id'];

  public static function getTheme () {
    $theme = self::with(['topicImg'])->select();
    if (empty($theme)) {
      throw new Error(ErrorCodeEnum::NOT_NETWORK);
    }
    return $theme;
  }

  public static function getThemeWithProductsByID ($id) {
    $theme = self::with(['products', 'headImg']) -> find($id);
    if (is_null($theme)) {
      throw new Error(ErrorCodeEnum::PARAMETER_ERROR);
    }
    return $theme;
  }

  public function topicImg () {
    return $this->belongsTo('Image', 'topic_img_id', 'id');
  }

  public function headImg () {
    return $this->belongsTo('Image', 'head_img_id', 'id');
  }

  public function products () {
    return $this->belongsToMany('Product', 'theme_product', 'product_id', 'theme_id');
  }

 }
