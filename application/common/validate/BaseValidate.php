<?php
/**
 * Created by PhpStorm.
 * User: LOLO
 * Date: 2018/12/18
 * Time: 14:02
 */

namespace app\common\validate;


use app\common\exception\Error;
use think\Validate;

class BaseValidate extends Validate {
  /**
   * @return bool
   */
  public function goCheck () {
    $params = request()->param('');
    $result = $this->batch()->check($params);
    if ($result) {
      return true;
    } else {
      throw new Error(['msg' => $this->error]);
    }
  }

  /**
   * @return string
   */
  public function getError () {
    $errArray = parent::getError();
    $errStr = implode(';', $errArray);
    return $errStr;
  }

}