<?php
namespace app\controller;

use app\model\Corporation as Cor;
use think\Controller;
use think\Db;
use think\facade\Request;

class Corporation extends Controller {
	public function index() {
		return $this->fetch();
	}
	
	public function CorporationAdd() {
		$data = [
			'name' => Request::param('name')
		];
		$id = Db::table('corporation')->insertGetId($data);
		$msg = $id > 0 ? "添加成功！" : "添加失败！";
		return json(array('code' => $id, 'msg' => $msg));
	}

	public function corporationOptionList(){
		$data = Cor::field('id,name')->order('id asc')->select();
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}

	public function corTableList(){

	}
}