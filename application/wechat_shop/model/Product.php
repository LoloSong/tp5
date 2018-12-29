<?php

namespace app\wechat_shop\model;

use app\common\enums\ErrorCodeEnum;
use app\common\exception\Error;
use app\common\model\BaseModel;

class Product extends BaseModel {
  protected $hidden = ['create_time', 'update_time', 'delete_time', 'pivot', 'img_id', 'from', 'category_id', 'summary'];

  public function getMainImgUrlAttr ($value, $data) {
    return $this->prefixImgUrl($value, $data);
  }

  public function imgs () {
    return $this->hasMany('ProductImage', 'product_id', 'id');
  }

  public function properties () {
    return $this->hasMany('ProductProperty', 'product_id', 'id');
  }

  public static function getRecent ($count) {
    $products = self::order('create_time', 'desc')->limit($count)->select();
    if (empty($products)) {
      throw new Error(ErrorCodeEnum::PARAMETER_ERROR);
    }
    return $products;
  }

  public static function getProductsByCategoryID ($categoryID) {
    $products = self::where('category_id', '=', $categoryID)->select();
    if (empty($products)) {
      throw new Error(ErrorCodeEnum::PARAMETER_ERROR);
    }
    return $products;
  }

  public static function getProductDetail ($id) {
    $product = self::with(['imgs' => function ($query) {
      $query->with(['imgUrl'])->order('order', 'asc');
    }, 'properties'])->find($id);
    if (is_null($product)) {
      throw new Error(ErrorCodeEnum::PARAMETER_ERROR);
    }
    return $product;
  }

  public static function getProductsByIDs ($ids) {
    $products = self::all($ids)->visible(['id', 'price', 'stock', 'name', 'main_img_url']);
    if (empty($products)) {
      throw new Error(ErrorCodeEnum::PARAMETER_ERROR);
    }
    return $products;
  }
}
