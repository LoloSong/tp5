<?php
/**
 * Created by PhpStorm.
 * User: LOLO
 * Date: 2018/12/24
 * Time: 15:17
 */

namespace app\wechat_shop\service;


use app\common\enums\ErrorCodeEnum;
use app\common\exception\Error;
use app\wechat_shop\model\OrderProduct as OrderProductModel;
use app\wechat_shop\model\Product as ProductModel;
use app\wechat_shop\model\UserAddress as UserAddressModel;
use app\wechat_shop\model\Order as OrderModel;
use think\Db;
use think\Exception;

class Order {
  // 订单的商品列表, 客户端传递过来的product参数
  protected $oProducts;
  // 真实的商品信息(包含库存量)
  protected $products;
  protected $uid;

  public function place ($uid, $oProducts) {
    // 用$oProducts和products对比
    $this->oProducts = $oProducts;
    $this->products = $this->getProductsByOrder($oProducts);
    $this->uid = $uid;

    // 获取订单状态
    $status = $this->getOrderStatus();

    // 商品数量不足
    if (!$status['pass']) {
      $status['order_id'] = -1;
      return $status;
    }

    // 创建订单快照
    $orderSnap = $this->snapOrder($status);

    // 创建订单
    $order = $this->createOrder($orderSnap);
    $order['pass'] = true;
    return $order;
  }

  // 根据订单信息查找真实的订单信息
  private function getProductsByOrder ($oProducts) {
    $oPIDs = [];
    foreach ($oProducts as $item) {
      array_push($oPIDs, $item['product_id']);
    }
    $products = ProductModel::getProductsByIDs($oPIDs);
    return $products;
  }

  public function checkOrderStock ($orderID) {
    $this->oProducts = OrderProductModel::getProductByOrderID($orderID);;
    $this->products = $this->getProductsByOrder($this->oProducts);
    $status = $this->getOrderStatus();
    return $status;
  }

  // 对比用户传入的订单和真实的订单
  private function getOrderStatus () {
    $status = [
      'pass' => true,
      'orderPrice' => 0,
      'totalCount' => 0,
      'pStatusArray' => []
    ];
    foreach ($this->oProducts as $oProduct) {
      $pStatus = $this->getProductStatus($oProduct['product_id'], $oProduct['count'], $this->products);
      if (!$pStatus['haveStock']) {
        $status['pass'] = false;
      }
      $status['orderPrice'] += $pStatus['totalPrice'];
      $status['totalCount'] += $pStatus['count'];
      array_push($status['pStatusArray'], $pStatus);
    }
    return $status;
  }

  // 单个商品的状态
  private function getProductStatus ($oPID, $oCount, $products) {
    $pIndex = -1;
    $pStatus = [
      'id' => null,
      'haveStock' => false,
      'count' => 0,
      'name' => '',
      'totalPrice' => 0
    ];
    for ($i = 0; $i < count($products); $i++) {
      if ($oPID === $products[$i]['id']) {
        $pIndex = $i;
      }
    }
    if ($pIndex === -1) {
      throw new Error(['msg' => "ID为${$oPID}的商品不存在，创建订单失败"]);
    } else {
      $product = $products[$pIndex];
      $pStatus['id'] = $product['id'];
      $pStatus['count'] = $oCount;
      $pStatus['name'] = $product['name'];
      $pStatus['totalPrice'] = $product['price'] * $oCount;
      if ($product['stock'] - $oCount >= 0) {
        $pStatus['haveStock'] = true;
      }
    }
    return $pStatus;
  }

  // 生成订单快照
  private function snapOrder ($status) {
    $snap = [
      'orderPrice' => 0,
      'totalCount' => 0,
      'pStatus' => [],
      'snapAddress' => null,
      'snapName' => '',
      'snapImage' => ''
    ];
    $snap['orderPrice'] = $status['orderPrice'];
    $snap['totalCount'] = $status['totalCount'];
    $snap['pStatus'] = $status['pStatusArray'];
    $snap['snapAddress'] = UserAddressModel::getAddressByUserID($this->uid);
    $snap['snapName'] = $this->products[0]['name'];
    $snap['snapImg'] = $this->products[0]['main_img_url'];

    if (count($this->products) > 1) {
      $snap['snapName'] .= '等';
    }
    return $snap;
  }

  // 创建订单
  private function createOrder ($snap) {
    Db::startTrans();
    try {
      $orderNo = $this->makeOrderNo();
      $order = new OrderModel();
      $order->user_id = $this->uid;
      $order->order_no = $orderNo;
      $order->total_price = $snap['orderPrice'];
      $order->total_count = $snap['totalCount'];
      $order->snap_img = $snap['snapImg'];
      $order->snap_name = $snap['snapName'];
      $order->snap_address = $snap['snapAddress'];
      $order->snap_items = json_encode($snap['pStatus'], JSON_UNESCAPED_UNICODE);

      $order->save();

      $orderID = $order->id;
      foreach ($this->oProducts as &$p) {
        $p['order_id'] = $orderID;
      }
      $orderProduct = new OrderProductModel();
      $orderProduct->saveAll($this->oProducts);
      Db::commit();
      return [
        'order_no' => $orderNo,
        'order_id' => $orderID,
        'create_time' => $order->create_time
      ];
    } catch (Exception $e) {
      Db::rollback();
      throw new Error(ErrorCodeEnum::DATABASE_EXCEPTION);
    }
  }

  // 生成订单号
  private function makeOrderNo () {
    $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
    $orderSn = $yCode[intval(date('Y')) - 2017] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
    return $orderSn;
  }
}