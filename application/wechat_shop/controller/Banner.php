<?php

namespace app\wechat_shop\controller;

use app\common\result\Result;
use app\common\validate\IDMustBePostiveInt;
use app\wechat_shop\model\Banner as BannerModel;

class Banner {
  /**
   * @url /api/wechat_shop/banner
   * @method GET
   * @param $id
   * @return \think\response\Json
   * @throws \app\common\exception\Error
   */
  public function getBanner ($id) {
    (new IDMustBePostiveInt())->goCheck();
    $result = BannerModel::getBannerByID($id);
    return Result::success(['data' => $result]);
  }
}
