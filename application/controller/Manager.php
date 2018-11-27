<?php
namespace app\controller;
use think\Controller;
use app\model\Manager as Man;
use think\Db;
use think\facade\Request;

class Manager extends Controller {
	public function index() {
		return $this->fetch();
	}

	public function managerAdd() {
		$data = [
			'name' => Request::param('managerName'),
			'phone' => Request::param('managerPhone')
		];
		$id = Db::table('manager')->insertGetId($data);
		$msg = $id > 0 ? "添加成功！" : "添加失败！";
		return json(array('code' => $id, 'msg' => $msg));
	}

	public function managerTableList() {
		$data = Man::field('id,name,phone')->order('id desc')->select();
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}

	public function managerOptionList() {
		$data = Man::field('id,name,phone')->order('id desc')->select();
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}

	public function managerSearch() {
		$keyword = Request::param('keyword');
		$list = Man::where('name', 'like', "%{$keyword}%")->select();
		$number = count($list);

		$data = array();

		foreach ($list as $key => $value) {
			$data[] = array(
				'value' => $value['id'],
				'name' => $value['name'],
				'selected' => "",
				'disabled' => "",
			);
		}

		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}
}
