<?php

namespace app\wechat_shop\model;

use app\common\model\BaseModel;

class ProductProperty extends BaseModel {
  protected $hidden = ['create_time', 'update_time', 'delete_time', 'product_id', 'id'];
}
