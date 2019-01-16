<?php

namespace app\wechat_shop\controller;

use app\common\controller\BaseController;
use app\common\result\Result;
use app\common\utils\TokenUtils;
use app\wechat_shop\model\User as UserModel;
use app\wechat_shop\model\UserAddress;
use app\wechat_shop\validate\Address as AddressValidate;

class Address extends BaseController {

  protected $beforeActionList = [
    'checkPrimaryScope' => ['only' => 'createOrUpdateAddress, getUserAddress']
  ];

  public function getUserAddress () {
    $uid = TokenUtils::getValueByToken('uid');
    $userAddress = UserAddress::getAddressByUserID($uid);
    return Result::success(['data' => $userAddress]);
  }

  /**
   * @url /api/wechat_shop/address
   * @method POST
   * @param [$name, $mobile, $province, $city, $country, $detail]
   * @return \think\response\Json
   * @throws \app\common\exception\Error
   */
  public function createOrUpdateAddress () {
    (new AddressValidate())->goCheck();

    // 根据Token来获取uid
    $uid = TokenUtils::getValueByToken('uid');

    // 根据uid来查找用户数据
    $user = UserModel::getByID($uid);

    // 获取用户从客户端提交来的地址信息
    $dataArray['name'] = request()->post('name');
    $dataArray['mobile'] = request()->post('mobile');
    $dataArray['province'] = request()->post('province');
    $dataArray['city'] = request()->post('city');
    $dataArray['country'] = request()->post('country');
    $dataArray['detail'] = request()->post('detail');

    // 根据用户地址信息是否存在, 从而判断是添加地址还是更新地址
    $userAddress = $user->address;
    if (!$userAddress) {
      $user->address()->save($dataArray);
      return Result::success(['data' => '地址添加成功']);
    } else {
      $user->address->save($dataArray);
      return Result::success(['data' => '地址更新成功']);
    }
  }
}
