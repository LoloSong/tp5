<?php
/**
 * Created by PhpStorm.
 * User: LOLO
 * Date: 2018/12/19
 * Time: 10:04
 */

namespace app\common\validate;


class IDMustBePostiveInt extends BaseValidate {
  /**
   * 定义验证规则
   * 格式：'字段名'  =>  ['规则1','规则2'...]
   *
   * @var array
   */
  protected $rule = [
    'id' => 'require|integer|>:0'
  ];

  /**
   * 定义错误信息
   * 格式：'字段名.规则名'  =>  '错误信息'
   *
   * @var array
   */
  protected $message = [];
}