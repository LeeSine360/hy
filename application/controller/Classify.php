<?php
namespace app\controller;
use app\model\Classify as Clas;
use app\model\Category as Cate;
use think\Controller;
use think\Db;
use think\facade\Request;

class Classify extends Controller {
	public function index() {
		return $this->fetch();
	}
	
	public function classifyAdd() {
		$id = 0;
		$msg = '';

		$com = Clas::create([			
			'name' => Request::param('name')
		]);

		$id = $com->id;
		$msg = $id > 0 ? "添加成功！" : "添加失败！";

		return json(array('code' => $id, 'msg' => $msg));
	}

	public function cateAdd(){
		$id = 0;
		$msg = '';

		$com = Cate::create([
			'classify_id' => Request::param('classId'),	
			'name' => Request::param('name')
		]);

		$id = $com->id;
		$msg = $id > 0 ? "添加成功！" : "添加失败！";

		return json(array('code' => $id, 'msg' => $msg));
	}

	public function classifyList(){
		$data = Clas::field('id,name')->order('id asc')->select();
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}

	public function cateList(){
		$id = Request::param('id');
		$where = isset($id) ? " c.id = $id AND ca.classify_id = c.id" : " ca.classify_id = c.id";
		$data = Db::query(" SELECT
								ca.id as id,
								c.name as className,
								ca.name as cateName
							FROM
								classify c,
								category ca
							WHERE
						".$where);
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}
}