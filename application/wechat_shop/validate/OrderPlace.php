<?php

namespace app\wechat_shop\validate;

use app\common\enums\ErrorCodeEnum;
use app\common\exception\Error;
use app\common\validate\BaseValidate;
use think\Validate;

class OrderPlace extends BaseValidate {
  /**
   * 定义验证规则
   * 格式：'字段名'  =>  ['规则1','规则2'...]
   *
   * @var array
   */
//  protected $products = [
//    ['product_id' => 1, 'count' => '3'],
//    ['product_id' => 2, 'count' => '3'],
//    ['product_id' => 3, 'count' => '3'],
//  ];

  protected $rule = [
    'products' => 'require|checkProducts'
  ];

  protected $singleRule = [
    'product_id' => 'require|integer|>:0',
    'count' => 'require|integer|>:0'
  ];

  /**
   * 定义错误信息
   * 格式：'字段名.规则名'  =>  '错误信息'
   *
   * @var array
   */
  protected $message = [];

  protected function checkProducts ($values) {
    if(!is_array($values)) {
      throw new Error(['msg' => '商品参数不正确']);
    }
//    if (empty($values)) {
//      throw new Error(['msg' => '商品列表不能为空']);
//    }
//    foreach ($values as $value) {
//      $this->checkProduct($value);
//    }
    return true;
  }

  protected function checkProduct ($value) {
    $validate = new BaseValidate($this->singleRule);
    $result = $validate->check($value);
    if (!$result) {
      throw new Error(['msg' => '商品列表参数错误']);
    }
  }
}
