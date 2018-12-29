<?php
/**
 * Created by PhpStorm.
 * User: LOLO
 * Date: 2018/12/25
 * Time: 13:35
 */

namespace app\wechat_shop\service;


use app\common\enums\ErrorCodeEnum;
use app\common\exception\Error;
use app\common\utils\TokenUtils;
use app\wechat_shop\enums\OrderStatusEnum;
use app\wechat_shop\service\Order as OrderService;
use app\wechat_shop\model\Order as OrderModel;
use think\facade\Log;

use extend\WxPay\WxPayUnifiedOrder;

class Pay {
  private $orderID;
  private $orderNO;

  public function __construct ($orderID) {
    if (!$orderID) {
      throw new Error(['msg' => '订单号不允许为NULL']);
    }
    $this->orderID = $orderID;
  }

  public function pay () {
    //订单号检测(1是否存在。2是否和用户匹配。3是否已经被支付过)
    $this->checkOrderValidate();
    //库存量检测
    $orderServer = new OrderService();
    $status = $orderServer->checkOrderStock($this->orderID);
    if (!$status['pass']) {
      return $status;
    }
    return $this->makeWxPreOrder($status['orderPrice']);
  }

  private function makeWxPreOrder ($totalPrice) {
    $openid = TokenUtils::getValueByToken('openid');
    if (!$openid) {
      throw new Error(ErrorCodeEnum::INVALID_TOKEN);
    }

    $wxOrderData = new WxPayUnifiedOrder();

    $wxOrderData->SetOut_trade_no($this->orderID);
    $wxOrderData->SetTrade_type('JSAPI');
    $wxOrderData->SetTotal_fee($totalPrice*100);
    $wxOrderData->setBody('零食商贩');
    $wxOrderData->SetOpenid($openid);
    $wxOrderData->SetNotify_url('');
    return $this->getPaySignature($wxOrderData);
  }

  private function getPaySignature($wxOrderData) {
    $wxOrder = WxPayApi::unifiedOrder($wxOrderData);
    if ($wxOrder['return_code'] !== 'SUCCESS' || $wxOrder['result_code'] !== 'SUCCESS') {
      Log::record($wxOrder, 'error');
      Log::record('获取订单失败', 'error');
    }
    return null;
  }

  private function checkOrderValidate () {
    $order = OrderModel::getOrderByID($this->orderID);
    if (!TokenUtils::isValidOperate($order->user_id)) {
      throw new Error(['msg' => '订单与用户不匹配']);
    }
    if ($order->status !== OrderStatusEnum::UNPAID) {
      throw new Error(['msg' => '订单已支付']);
    }
    $this->orderNO = $order->order_no;
    return true;
  }
}