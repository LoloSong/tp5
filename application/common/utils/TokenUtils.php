<?php
/**
 * Created by PhpStorm.
 * User: LOLO
 * Date: 2018/12/20
 * Time: 14:42
 */

namespace app\common\utils;

use app\common\enums\ErrorCodeEnum;
use app\common\exception\Error;
use think\facade\Cache;

class TokenUtils {
  // 生成token
  public static function generateToken () {
    // 32个字符组成一组随机字符串
    $randChars = self::getRandChar(32);
    // 用三组字符串，进行md5加密
    $timestamp = $_SERVER['REQUEST_TIME'];
    $salt = config('secure.token_salt');
    return md5($randChars . $timestamp . $salt);
  }

  // 通过token获取参数
  public static function getValueByToken ($key) {
    $token = request()->header('token');
    $values = Cache::get($token);
    if (!$values) {
      throw new Error(ErrorCodeEnum::INVALID_TOKEN);
    }
    $values = json_decode($values, true);
    if (!array_key_exists($key, $values)) {
      throw new Error(['msg' => '尝试获取的token变量不存在']);
    }
    return $values[$key];
  }

  public static function isValidOperate ($checkedUID) {
    if (!$checkedUID) {
      throw new Error(['msg' => '检测UID时必须传入一个被检测的UID']);
    }
    $operateUID = self::getValueByToken('uid');
    if ($operateUID === $checkedUID) {
      return true;
    }
    return false;
  }

  // 生成随机字符串
  public static function getRandChar ($length) {
    $str = null;
    $strPol = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
    $max = strlen($strPol) - 1;

    for ($i = 0; $i < $length; $i++) {
      $str .= $strPol[rand(0, $max)];
    }

    return $str;
  }
}