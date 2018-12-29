<?php
/**
 * Created by PhpStorm.
 * User: LOLO
 * Date: 2018/12/4
 * Time: 17:33
 */

namespace app\common\exception;


use think\Exception;

class Error extends Exception {
  public $code = 1;
  public $msg = 'error';

  public function __construct ($params = []) {
    if (!is_array($params)) {
      return;
    }
    if (array_key_exists('code', $params)) {
      $this->code = $params['code'];
    }
    if (array_key_exists('msg', $params)) {
      $this->msg = $params['msg'];
    }
  }
}