<?php
namespace app\controller;
use think\Controller;
use app\model\Manager as Man;
use think\facade\Request;

class Manager extends Controller {
	public function index() {
		return $this->fetch();
	}

	public function add(){
		$man = Man::create([
			'name' => Request::param('name'),
			'phone' => Request::param('phone')
		]);
		
		$id = $man->id;
		$msg = $id > 0 ? "添加成功！" : "添加失败！";
		return json(array('code' => $id, 'msg' => $msg));
	}


}
