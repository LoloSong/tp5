<?php
/**
 * Created by PhpStorm.
 * User: LOLO
 * Date: 2018/12/18
 * Time: 16:54
 */

return [
  'img_prefix' => 'http://tp.cn/wechat_shop/images',
  'token_expire_in' => 7200,
  'wx' => [
    'app_id' => 'wx7bd60bd40e8b811e',
    'app_secret' => 'b8a318767f7ed8830391f6e807507a1a',
    'login_url' => 'https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code'
  ]
];