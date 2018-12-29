<?php

namespace app\wechat_shop\validate;

use app\common\validate\BaseValidate;

class Address extends BaseValidate {
  /**
   * 定义验证规则
   * 格式：'字段名'  =>  ['规则1','规则2'...]
   *
   * @var array
   */
  protected $rule = [
    'name' => 'require',
    'mobile' => 'require|mobile',
    'province' => 'require',
    'city' => 'require',
    'country' => 'require',
    'detail' => 'require',
  ];

  /**
   * 定义错误信息
   * 格式：'字段名.规则名'  =>  '错误信息'
   *
   * @var array
   */
  protected $message = [];
}
