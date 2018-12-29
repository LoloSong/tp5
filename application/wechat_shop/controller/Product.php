<?php
/**
 * Created by PhpStorm.
 * User: LOLO
 * Date: 2018/12/19
 * Time: 10:51
 */

namespace app\wechat_shop\controller;


use app\common\result\Result;
use app\common\validate\IDMustBePostiveInt;
use app\wechat_shop\model\Product as ProductModel;
use app\wechat_shop\validate\Count;

class Product {
  /**
   * @url api/wechat_shop/product/recent
   * @method GET
   * @param int $count
   * @return \think\response\Json
   * @throws \app\common\exception\Error
   */
  public function getRecent($count = 15) {
    (new Count())->goCheck();
    $result = ProductModel::getRecent($count);
    return Result::success(['data' => $result]);
  }

  /**
   * @url api/wechat_shop/product/by_category
   * @method GET
   * @param $id
   * @return \think\response\Json
   * @throws \app\common\exception\Error
   */
  public function getAllInCategory ($id) {
    (new IDMustBePostiveInt())->goCheck();
    $result = ProductModel::getProductsByCategoryID($id);
    return Result::success(['data' => $result]);
  }

  /**
   * @url api/wechat_shop/product/:id
   * @method GET
   * @param $id
   * @return \think\response\Json
   * @throws \app\common\exception\Error
   */
  public function getOne ($id) {
    (new IDMustBePostiveInt())->goCheck();
    $result = ProductModel::getProductDetail($id);
    return Result::success(['data' => $result]);
  }
}