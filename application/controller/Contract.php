<?php
namespace app\controller;

use app\model\Contract as Con;
use app\model\ContractManage as CM;
use think\Controller;
use think\Db;
use think\facade\Request;

class Contract extends Controller {
	public function index() {
		return $this->fetch();
	}
	public function label() {
		return $this->fetch();
	}
	public function contractAdd(){
		
		$conId = Con::create([
			'corporation_id' => Request::param('corpId'),
			'project_id' => Request::param('proId'),
			'project_manager_id' => implode(",",Request::param('bids')),
			'company_id' => Request::param('comId'),
			'price' => Request::param('conPrice'),
			'start_time' => strtotime(Request::param('conStartTime')),
			'end_time' => strtotime(Request::param('conEndTime')),
			'total' => Request::param('conNum'),
			'keep' => Request::param('conSave'),	
			'category_id' => Request::param('label'),
			'remark' => Request::param('conRemark'),
		])->id;

		if($conId > 0)$cmId = CM::create([
			'type' => Request::param('type'),
			'name' => Request::param('conOpeName'),
			'phone' => Request::param('conOpePhone'),
		])->id;
		$msg = $id > 0 ? "添加成功！" : "添加失败！";
		return json(array('code' => $id, 'msg' => $msg));
	}
	public function categoryQuery() {
		$id = Request::param('id');
		$page = Request::param('page');
		$limit = Request::param('limit');
		$curr = $page <= 1 ? 1 : ($page - 1) * $limit + 1;
		if ($id) {
			$data = Db::query(" SELECT
								ca.id as id,
								ca.name as name,
								c.name as classify
							FROM classify c,
								 category ca
							WHERE
								 c.id = $id AND
								 c.id=ca.c_id
						");
		} else {
			$data = Db::query(" SELECT
								ca.id as id,
								ca.name as name,
								c.name as classify
							FROM classify c,
								 category ca
							WHERE
								 c.id=ca.c_id
						");
			$dataTotal = Db::query(" SELECT
								count(c.id) as value
							FROM classify c,
								 category ca
							WHERE
								 c.id=ca.c_id
						");
		}
		$return = array('code' => 0, 'msg' => '', 'count' => $dataTotal[0]['value'], 'data' => $data);
		return json($return);
	}
	
	public function contractQuery() {
		$page = Request::param('page');
		$limit = Request::param('limit');
		$curr = $page <= 1 ? 1 : ($page - 1) * $limit + 1;
		$data = Db::query("SELECT
								SQL_CALC_FOUND_ROWS c.id as id,
								p.number as proNumber,
								p.name as proName,
								c.number as conNumber,
								com.name as comName,
								c.price as conPrice,
								ca.name as category,
								(SELECT
									GROUP_CONCAT(m.name)
								 FROM manager m
								 WHERE FIND_IN_SET(m.id,pm.manager_id)
								) AS proManName
							FROM
								project p,
								project_manager pm,
								contract c,
								company com,								
								category ca
							WHERE
								p.id  = pm.project_id AND
								pm.id = c.project_manager_id AND
								c.company_id = com.id 								
							ORDER BY c.id ASC
							LIMIT $curr, $limit"
		);
		$listTotal = Db::query("SELECT FOUND_ROWS() as rowcount");
		
		$return = array('code' => 0, 'msg' => '', 'count' => $listTotal[0]['rowcount'], 'data' => $data);
		return json($return);
	}

	public function contractVerify() {
		$data = Db::query(" SELECT
								SQL_CALC_FOUND_ROWS c.id as id,
								p.number as proNumber,
								p.name as proName,
								c.number as conNumber,
								com.name as comName,
								c.price as conPrice,
								ca.name as category,
								(SELECT
									GROUP_CONCAT(m.name)
								 FROM manager m
								 WHERE FIND_IN_SET(m.id,c.project_manager_id)
								) AS managerName
							FROM
								contract c,
								project_manager pm,								
								project p,
								company com,
								corporation co,
								category ca,
								contract_examine ce
							WHERE
								c.project_manager_id = pm.id AND
								pm.project_id = p.id AND
								c.company_id = com.id AND
								c.corporation_id = co.id AND
								c.category_id = ca.id AND
								c.contract_examine_id = ce.id AND 
								ce.vertify = 0
						");
		$listTotal = Db::query("SELECT FOUND_ROWS() as rowcount");		
		$return = array('code' => 0, 'msg' => '', 'count' => $listTotal, 'data' => $data);
		return json($return);
	}
	public function contractConfirm() {
		$data = Db::query(" SELECT
								SQL_CALC_FOUND_ROWS c.id as id,
								p.number as proNumber,
								p.name as proName,
								c.number as conNumber,
								com.name as comName,
								(SELECT
									GROUP_CONCAT(m.name)
								 FROM manager m
								 WHERE FIND_IN_SET(m.id,pm.manager_id)
								) AS managerName
							FROM
								contract c,
								project_manager pm,
								company com,
								project p,
                                contract_examine ce
							WHERE
								c.project_manager_id = pm.id AND
								c.project_manager_id = p.id AND
								c.company_id = com.id AND
                                c.contract_examine_id = ce.id AND
                                ce.confirm = 0
						");
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}
	public function contractSave() {
		$data = Db::query("SELECT
								SQL_CALC_FOUND_ROWS c.id as id,
								p.number as proNumber,
								p.name as proName,
								c.number as conNumber,
								com.name as comName,
								(SELECT
									GROUP_CONCAT(m.name)
								 FROM manager m
								 WHERE FIND_IN_SET(m.id,pm.manager_id)
								) AS managerName
							FROM
								contract c,
								project_manager pm,
								company com,
								project p,
                                contract_examine ce
							WHERE
								c.project_manager_id = pm.id AND
								pm.project_id = p.id AND
								c.company_id = com.id AND
                                c.contract_examine_id AND ce.id AND
								ce.confirm = 1 AND
								ce.vertify = 1
						");
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}
	
	public function companyQuery() {
		$id = Request::param('id'); //项目ID
		$bid =  Request::param('bid'); //标段ID
		$query = "";
		if ($id == 0) {
			$query = " SELECT
								com.id as id,
								com.name as name
							FROM
								company com,
								contract con
							WHERE
								con.c_id=com.id
							GROUP BY
								com.id
						";
		} else {
			$query = " SELECT
								com.id as id,
								com.name as name
							FROM
								company com,
								contract con
							WHERE
								con.p_id = $id AND
								$bid in (con.b_id) AND
								con.c_id=com.id
							GROUP BY
								com.id
						";
		}
		$data = Db::query($query);
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}
	public function projectManagerList() {
		$id = Request::param('id'); //项目ID
		$query = "SELECT id,name FROM project_manager where project_id = $id";
		$data = Db::query($query);
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}

	public function operatorSearch(){
		$keyword = Request::param('keywords');
		$data = Con::where('name', 'like', "%{$keyword}%")->select();
		return json(array('code' => 0, 'content' => $data));
	}
}
