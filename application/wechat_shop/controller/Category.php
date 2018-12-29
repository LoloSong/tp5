<?php
/**
 * Created by PhpStorm.
 * User: LOLO
 * Date: 2018/12/19
 * Time: 14:18
 */

namespace app\wechat_shop\controller;


use app\common\result\Result;
use app\wechat_shop\model\Category as CategoryModel;

class Category {
  /**
   * @url api/wechat_shop/category/all
   * @method GET
   * @return \think\response\Json
   */
  public function getCategories () {
    $result = CategoryModel::getCategories();
    return Result::success(['data' => $result]);
  }
}