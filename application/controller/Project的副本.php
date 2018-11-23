<?php
namespace app\controller;

use app\model\Manager as Man;
use app\model\Project as Pro;
use think\Controller;
use think\Db;
use think\facade\Request;

class Project extends Controller {
	public function index() {
		return $this->fetch();
	}
	public function manager() {
		return $this->fetch();
	}
	public function corporation() {
		return $this->fetch();
	}

	public function projectAdd() {
		$pro = Pro::create([
			'number' => Request::param('proNumber'),
			'name' => Request::param('proName'),
			'price' => Request::param('proPrice'),
			'start_time' => Request::param('proStart'),
			'days' => Request::param('proDays'),
			'remark' => Request::param('proRemark'),
		]);

		$id = $pro->id;
		$msg = $id > 0 ? "添加成功！" : "添加失败！";
		return json(array('code' => $id, 'msg' => $msg));
	}
<<<<<<< HEAD
	public function managerAdd() {
=======
	public function managerAdd(){
>>>>>>> 2b822d6467885a6351505e4261ee1191d8df0146
		$data = [
			'project_id' => Request::param('proId'),
			'manager_id' => Request::param('proManManager'),
			'price' => Request::param('proManPrice'),
			'remark' => Request::param('proManRemark'),
		];
		$id = Db::table('project_manager')->insertGetId($data);
		$msg = $id > 0 ? "添加成功！" : "添加失败！";
		return json(array('code' => $id, 'msg' => $msg));
	}

	public function projectTableList() {
		$list = Pro::all();
		$number = count($list);

		$data = array();

		foreach ($list as $key => $value) {
			$data[] = array(
				'proId' => $value['id'],
				'proNumber' => $value['number'],
				'proName' => $value['name'],
				'proPrice' => $value['price'],
				'proStart' => date("Y-m-d", $value['start_time']),
				'proDays' => $value['days'],
				'proContent' => $value['content']);
		}

		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}

<<<<<<< HEAD
	public function managerTableList() {
=======
	public function projectManagerTableList() {
		$page = Request::param('page');
		$limit = Request::param('limit');
		$curr = $page <= 1 ? 1 : ($page - 1) * $limit + 1;
		$list = Db::query("SELECT
								pm.id as id,
								pm.price as proManPrice,
								p.name as projectName,
								(SELECT GROUP_CONCAT(m.name) FROM manager m WHERE FIND_IN_SET(m.id,pm.manager_id)) as managerName,
								pm.remark as proManRemark
						   FROM
						   		project_manager pm,
						   		project p
						   WHERE
						   		pm.project_id = p.id
						  ");
		$number = count($list);

		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $list);
		return json($return);
	}

	public function managerTableList(){
>>>>>>> 2b822d6467885a6351505e4261ee1191d8df0146
		$page = Request::param('page');
		$limit = Request::param('limit');
		$curr = $page <= 1 ? 1 : ($page - 1) * $limit + 1;
		$list = Db::query("SELECT
								pm.id as id,
								pm.price as proManPrice,
								p.name as projectName,
								(SELECT GROUP_CONCAT(m.name) FROM manager m WHERE FIND_IN_SET(m.id,pm.manager_id)) as managerName,
								pm.remark as proManRemark
						   FROM
						   		project_manager pm,
						   		project p
						   WHERE
						   		pm.project_id = p.id
						  ");
		$number = count($list);

		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $list);
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

	public function managerOptionList() {
		$data = Man::field('id,name,phone')->order('id desc')->select();
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}

	public function projectOptionList() {
		$data = Pro::field('id,name')->order('id asc')->select();
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}
}
