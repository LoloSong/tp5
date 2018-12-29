<?php
/**
 * Created by PhpStorm.
 * User: LOLO
 * Date: 2018/12/21
 * Time: 14:03
 */

namespace app\wechat_shop\service;

use app\common\enums\ErrorCodeEnum;
use app\common\enums\ScopeEnum;
use app\common\exception\Error;
use app\common\utils\TokenUtils;
use app\wechat_shop\model\User as UserModel;

class Token {
  protected $code;
  protected $wxAppID;
  protected $wxAppSecret;
  protected $wxLoginUrl;

  public function __construct ($code) {
    $this->code = $code;
    $this->wxAppID = config('setting.wx.app_id');
    $this->wxAppSecret = config('setting.wx.app_secret');
    $this->wxLoginUrl = sprintf(config('setting.wx.login_url'), $this->wxAppID, $this->wxAppSecret, $this->code);
  }

  public function get () {
    $wxRequest = curl_get($this->wxLoginUrl);
    $wxRequest = json_decode($wxRequest, true);

    if (empty($wxRequest)) {
      throw new Error(['msg' => '获取session_key及openID时异常，微信内部错误']);
    }

    if (array_key_exists('errcode', $wxRequest)) {
      return $wxRequest;
    } else {
      return $this->grantToken($wxRequest);
    }
  }

  private function grantToken ($wxRequest) {
    $openid = $wxRequest['openid'];

    $user = UserModel::getByOpenID($openid);
    if ($user) {
      $uid = $user->id;
    } else {
      $uid = $this->newUser($openid);
    }

    $cacheValue = $wxRequest;
    $cacheValue['uid'] = $uid;
    $cacheValue['scope'] = ScopeEnum::USER;

    $token = $this->saveToCache($cacheValue);

    return $token;
  }

  private function saveToCache ($cacheValue) {
    $key = TokenUtils::generateToken();
    $value = json_encode($cacheValue);
    $expire_in = config('setting.token_expire_in');

    $request = cache($key, $value, $expire_in);
    if (!$request) {
      throw new Error(ErrorCodeEnum::SERVER_CACHE_EXCEPTION);
    }
    return $key;
  }

  private function newUser ($openid) {
    $user = UserModel::create([
      'openid' => $openid
    ]);
    return $user->id;
  }
}