<?php

namespace app\wechat_shop\validate;

use app\common\validate\BaseValidate;
use think\Validate;

class Count extends BaseValidate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
	  'count' => 'integer|between:1, 15'
  ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [];
}
