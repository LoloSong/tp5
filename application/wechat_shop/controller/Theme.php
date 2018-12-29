<?php

namespace app\wechat_shop\controller;

use app\common\result\Result;
use app\common\validate\IDMustBePostiveInt;
use app\wechat_shop\model\Theme as ThemeModel;

class Theme {
  /**
   * $url api/wechat_shop/theme
   * @method GET
   * @return \think\response\Json
   * @throws \app\common\exception\Error
   */
  public function getTheme () {
    $result = ThemeModel::getTheme();
    return Result::success(['data' => $result]);
  }

  /**
   * $url api/wechat_shop/theme/:id
   * @method GET
   * @param $id
   * @return \think\response\Json
   * @throws \app\common\exception\Error
   */
  public function getThemeWithProducts ($id) {
    (new IDMustBePostiveInt())->goCheck();
    $result = ThemeModel::getThemeWithProductsByID($id);
    return Result::success(['data' => $result]);
  }
}
