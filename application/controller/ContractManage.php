<?php
namespace app\controller;

use app\model\ContractManage as CM;
use think\Controller;
use think\Db;
use think\facade\Request;

class ContractManage extends Controller {
	public function operatorSearch(){
		$keyword = Request::param('keywords');
		$data = CM::where('name', 'like', "%{$keyword}%")->select();		
		
		return json(array('code' => 0, 'content' => $data));
	}
}
