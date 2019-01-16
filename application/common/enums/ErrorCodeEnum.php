<?php
/**
 * Created by PhpStorm.
 * User: LOLO
 * Date: 2018/12/17
 * Time: 11:18
 */

namespace app\common\enums;


class ErrorCodeEnum {
  /**
   * 服务级错误码
   */
  const NOT_NETWORK = ['code' => 1, 'msg' => '系统繁忙, 请稍后再试!'];
  const SERVER_CACHE_EXCEPTION = ['code' => 1, 'msg' => '服务器缓存异常'];
  const INVALID_TOKEN = ['code' => 10006, 'msg' => '令牌无效或已过期'];
  const PERMISSION_ERROR = ['code' => 1, 'msg' => '权限错误'];
  const DATABASE_EXCEPTION = ['code' => 1, 'msg' => '数据库异常'];
  /**
   * 客户级错误码
   */
  const PARAMETER_ERROR = ['code' => 1, 'msg' => '参数错误'];

}