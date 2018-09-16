<?php
namespace app\controller;

use app\model\Manager as Man;
use app\model\Project as Pro;
use think\Controller;
use think\Db;

class Project extends Controller {
	public function index() {
		return $this->fetch();
	}

	public function add() {
		$param = $_POST;
		$id = 0;
		$msg = '';
		if ($param['proAC'] == 'project') {
			$pro = Pro::create([
				'name' => $param['proName'],
				'price' => $param['proPrice'],
				'start_time' => $param['proStart'],
				'days' => $param['proDays'],
				'number' => $param['proNumber'],
				'remark' => $param['proRemark'],
			]);

			$id = $pro->id;
			$msg = $id > 0 ? "添加成功！" : "添加失败！";
		}
		if ($param['proAC'] == 'bids') {
			//name, p_id, m_id, create_time, update_time, remark
			//{proId: "10", bidsName: "TEST", proManager: "22,21,20,19,18", bidsRemark: "TEST", proAC: "bids"}
			$data = [
				'p_id' => $param['proId'],
				'name' => $param['bidsName'],
				'm_id' => $param['bidsManager'],
				'remark' => $param['bidsRemark'],
			];
			$id = Db::table('hy_bids')->insertGetId($data);
			$msg = $id > 0 ? "添加成功！" : "添加失败！";
		}

		return json(array('code' => $id, 'msg' => $msg));
	}

	public function query() {
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
	public function manager() {
		$param = $_GET;
		$list = Man::where('name', 'like', "%{$param['keyword']}%")->select();
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
