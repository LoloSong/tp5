<?php
/**
 * Created by PhpStorm.
 * User: LOLO
 * Date: 2018/12/17
 * Time: 11:24
 */

namespace app\common\result;


class Result {
  public $code;
  public $msg;
  public $data;

  /**
   * request successful
   * @param array $params
   * @return $result
   */
  public static function success ($params = []) {
    $code = 0;
    $msg = 'success';
    $data = '';
    if (array_key_exists('code', $params)) {
      $code = $params['code'];
    }
    if (array_key_exists('msg', $params)) {
      $msg = $params['msg'];
    }
    if (array_key_exists('data', $params)) {
      $data = $params['data'];
    }

    $result = [
      'code' => $code,
      'msg' => $msg,
      'data' => $data
    ];
    return json($result);
  }

  /**
   * request error
   * @param array $params
   * $return $result
   */
  public static function error ($params = []) {
    $code = 1;
    $msg = 'error';
    if (array_key_exists('code', $params)) {
      $code = $params['code'];
    }
    if (array_key_exists('msg', $params)) {
      $msg = $params['msg'];
    }
    $result = [
      'code' => $code,
      'msg' => $msg
    ];
    return json($result);
  }
}