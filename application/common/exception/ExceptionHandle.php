<?php
/**
 * Created by PhpStorm.
 * User: LOLO
 * Date: 2018/12/20
 * Time: 15:06
 */

namespace app\common\exception;


use app\common\result\Result;
use think\exception\Handle;

class ExceptionHandle extends Handle {
  private $code;
  private $msg;

  public function render ($e) {

    if ($e instanceof Error) {
      $this->code = $e->code;
      $this->msg = $e->msg;
    } else {
      return parent::render($e);
    }

    return Result::error([
      'code' => $this->code,
      'msg' => $this->msg
    ]);
  }
}