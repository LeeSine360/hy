<?php
namespace app\controller;

use app\model\Corporation as Cor;
use think\Controller;
use think\Db;
use think\facade\Request;

class Classify extends Controller {
	public function index() {
		return $this->fetch();
	}
	
	public function CorporationAdd() {

	}

	public function corporationOptionList(){
		$data = Cor::field('id,name')->order('id asc')->select();
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}
}