<?php
/**
 * Created by PhpStorm.
 * User: LOLO
 * Date: 2018/12/20
 * Time: 10:16
 */

namespace app\wechat_shop\controller;


use app\common\controller\BaseToken;
use app\common\exception\Error;
use app\common\result\Result;
use app\common\utils\TokenUtils;
use app\common\validate\WXCodeValidate;
use app\wechat_shop\service\Token as TokenService;

class Token {
  /**
   * $url api/wechat_shop/token/user
   * @method POST
   * @param $code
   * @return \think\response\Json
   * @throws \app\common\exception\Error
   */
  public function getToken ($code) {
    (new WXCodeValidate())->goCheck();

    $result = (new TokenService($code))->get();

    return Result::success(['data' => $result]);
  }

  public function verifyToken($token = '') {
    if (!$token) {
      throw new Error(['msg' => 'token不能为空']);
    }
    $valid = TokenUtils::verifyToken($token);
    return Result::success(['data' => ['isValid' => $valid]]);
  }
}