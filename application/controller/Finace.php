<?php
namespace app\controller;

use app\model\Reimbursement as R;
use app\model\TeamInfo as TI;
use app\model\TeamName as TN;
use think\Controller;
use think\facade\Request;

class Finace extends Controller {
	public function index() {
		return $this->fetch();
	}

	public function team() {
		return $this->fetch();
	}

	public function finaceAdd() {
		$id = 0;
		$corpId = Request::param("corpId");
		$proId = Request::param("proId");
		$bids = Request::param("bids");
		$type = Request::param("type");
		$teamNameId = Request::param("teamNameId");
		$name = Request::param("name");
		$phone = Request::param("phone");
		$comId = Request::param("comId");
		$price = Request::param("price");
		$remark = Request::param("remark");

		if ($type == 2) {
			$id = TI::create([
				'team_name_id' => $teamNameId,
				'name' => $name,
				'phone' => $phone,
			])->id;
			$comId = 0;
		}
		if ($type == 3) {
			$comId = 0;
		}

		$id = R::create([
			'project_manager_id' => $bids,
			'company_id' => $comId,
			'team_id' => $id,
			'type' => $type,
			'price' => $price,
			'remark' => $remark,
		])->id;

		$msg = $id > 0 ? "添加成功！" : "添加失败！";
		return json(array('code' => $id, 'msg' => $msg));
	}

	public function teamOptionList() {
		$data = TN::all();
		$number = count($data);

		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}

	public function teamManagerAdd() {
		$data = [
			'name' => Request::param('name'),
			'manager_name' => Request::param('managerName'),
			'manager_phone' => Request::param('managerPhone'),
		];
		$id = TN::create($data)->id;
		$msg = $id > 0 ? "添加成功！" : "添加失败！";
		return json(array('code' => $id, 'msg' => $msg));
	}

	public function teamManagerList() {
		$data = TN::field('id,name,manager_name as managerName,manager_phone as managerPhone')->select();
		$number = count($data);

		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}
}
