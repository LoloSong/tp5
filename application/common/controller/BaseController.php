<?php

namespace app\common\controller;

use app\common\enums\ErrorCodeEnum;
use app\common\enums\ScopeEnum;
use app\common\exception\Error;
use app\common\utils\TokenUtils;
use think\Controller;

class BaseController extends Controller {
  // 用户和管理员都可以访问的权限
  protected function checkPrimaryScope () {
    $scope = TokenUtils::getValueByToken('scope');
    if ($scope >= ScopeEnum::USER) {
      return true;
    } else {
      throw new Error(ErrorCodeEnum::PERMISSION_ERROR);
    }
  }

  // 只有用户可以访问的权限
  protected function checkExclusiveScope () {
    $scope = TokenUtils::getValueByToken('scope');
    if ($scope === ScopeEnum::USER) {
      return true;
    } else {
      throw new Error(ErrorCodeEnum::PERMISSION_ERROR);
    }
  }
}
