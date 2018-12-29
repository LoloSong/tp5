<?php
/**
 * Created by PhpStorm.
 * User: LOLO
 * Date: 2018/12/17
 * Time: 12:28
 */

namespace app\test\controller;

use app\common\result\Result;
use app\test\model\User;

class Index {
  public function index () {
    $res = User::find(1);

    return Result::success(['data' => $res]);
  }
}