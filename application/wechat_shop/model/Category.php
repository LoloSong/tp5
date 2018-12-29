<?php
/**
 * Created by PhpStorm.
 * User: LOLO
 * Date: 2018/12/19
 * Time: 14:22
 */

namespace app\wechat_shop\model;


use app\common\enums\ErrorCodeEnum;
use app\common\exception\Error;
use app\common\model\BaseModel;

class Category extends BaseModel {

  protected $hidden = ['create_time', 'delete_time', 'update_time', 'topic_img_id'];

  public function img () {
    return $this->belongsTo('Image', 'topic_img_id', 'id');
  }

  public static function getCategories () {
    $categories = self::with(['img'])->select();
    if (empty($categories)) {
      throw new Error(ErrorCodeEnum::NOT_NETWORK);
    }
    return $categories;
  }
}