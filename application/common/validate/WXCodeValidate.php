<?php
/**
 * Created by PhpStorm.
 * User: LOLO
 * Date: 2018/12/20
 * Time: 10:20
 */

namespace app\common\validate;


class WXCodeValidate extends BaseValidate {
  /**
   * 定义验证规则
   * 格式：'字段名'  =>  ['规则1','规则2'...]
   *
   * @var array
   */
  protected $rule = [
    'code' => 'require'
  ];

  /**
   * 定义错误信息
   * 格式：'字段名.规则名'  =>  '错误信息'
   *
   * @var array
   */
  protected $message = [
  ];
}