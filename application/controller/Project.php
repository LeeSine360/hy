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
	public function corporation(){
		return $this->fetch();
	}

	public function proAdd() {
		$pro = Pro::create([
			'name' => Request::param('proName'),
			'price' => Request::param('proPrice'),
			'start_time' => Request::param('proStart'),
			'days' => Request::param('proDays'),
			'number' => Request::param('proNumber'),
			'remark' => Request::param('proRemark'),
		]);

		$id = $pro->id;
		$msg = $id > 0 ? "添加成功！" : "添加失败！";
		return json(array('code' => $id, 'msg' => $msg));
	}
	public function managerAdd(){
		$data = [
				'p_id' => Request::param('proId'),				
				'm_id' => Request::param('mId'),
				'price' => Request::param('price'),
				'remark' => Request::param('remark'),
			];
		//$id = Db::table('hy_bids')->insertGetId($data);
		//$msg = $id > 0 ? "添加成功！" : "添加失败！";
		return json(array('code' => 0, 'msg' => $data));
	}

	public function projectQuery() {
		$list = Pro::all();
		$number = count($list);

		$data = array();

		foreach ($list as $key => $value) {
			$data[] = array(
				'proId' => $value['id'],
				'proName' => $value['name'],
				'proPrice' => $value['price'],
				'proStart' => date("Y-m-d", $value['start_time']),
				'proDays' => $value['days'],
				'proNumber' => $value['number'],
				'proRemark' => $value['remark']);
		}

		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}

	public function corpQuery(){
		$list = Db::query("SELECT 
								id as corpId,
								name as corpName,
								remark as corpRemark
						   FROM hy_corporation");
		$number = count($list);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $list);
		return json($return);
	}

	public function bidsQuery() {
		$page = Request::param('page');
		$limit = Request::param('limit');
		$curr = $page <= 1 ? 1 : ($page - 1) * $limit + 1;
		$list = Db::query("SELECT
								b.id as id,
								b.name as bidsName,
								b.price as bidsPrice,
								p.name as projectName,
								(SELECT GROUP_CONCAT(m.name) FROM hy_manager m WHERE FIND_IN_SET(m.id,b.m_id)) as managerName
						   FROM
						   		hy_bids b,
						   		hy_project p
						   WHERE
						   		b.p_id = p.id
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
	public function managerList() {
		$data = Man::field('id,name,phone')->order('id desc')->select();
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}
	public function labelList() {
		$list = Db::query("SELECT
								b.id as id,
								b.name as bidsName,
								b.price as bidsPrice,
								p.name as projectName,
								(SELECT GROUP_CONCAT(m.name) FROM hy_manager m WHERE FIND_IN_SET(m.id,b.m_id)) as managerName
						   FROM
						   		hy_bids b,
						   		hy_project p
						   WHERE
						   		b.p_id = p.id
						  ");
		$number = count($list);

		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $list);
		return json($return);
	}
}
