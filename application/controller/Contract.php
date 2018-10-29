<?php
namespace app\controller;
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
	public function classQuery() {
		$data = Db::table('classify')->field('id,name')->order('id desc')->select();
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
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
								c.project_id = p.id AND
								c.company_id = com.id AND
								c.category_id = ca.id
							ORDER BY c.id ASC
							LIMIT $curr, $limit"
		);
		$listTotal = Db::query("SELECT FOUND_ROWS() as rowcount");
		
		$return = array('code' => 0, 'msg' => '', 'count' => $listTotal[0]['rowcount'], 'data' => $data);
		return json($return);
	}

	public function contractVerify() {
		$data = Db::query(" SELECT
								c.id as id,
								p.number as proNumber,
								p.name as proName,
								c.number as conNumber,
								com.name as comName,
								c.price as conPrice,
								ca.name as category,
								(SELECT
									GROUP_CONCAT(b.name)
								 FROM bids b
								 WHERE FIND_IN_SET(b.id,c.b_id)
								) AS bidsName
							FROM
								contract c,
								contract_manager cm,
								company com,
								project p,
								category ca
							WHERE
								c.p_id = p.id AND
								c.m_id = cm.id AND
								c.c_id = com.id AND
								c.category_id = ca.id AND
								cm.vertify = 0
						");
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}
	public function contractConfirm() {
		$data = Db::query(" SELECT
								c.id as id,
								p.number as proNumber,
								p.name as proName,
								c.number as conNumber,
								com.name as comName,
								(SELECT
									GROUP_CONCAT(b.name)
								 FROM bids b
								 WHERE FIND_IN_SET(b.id,c.b_id)
								) AS bidsName
							FROM
								contract c,
								contract_manager cm,
								company com,
								project p
							WHERE
								c.p_id = p.id AND
								c.m_id = cm.id AND
								c.c_id = com.id AND
								cm.confirm = 0
						");
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}
	public function contractSave() {
		$data = Db::query(" SELECT
								c.id as id,
								p.number as proNumber,
								p.name as proName,
								c.number as conNumber,
								com.name as comName,
								(SELECT
									GROUP_CONCAT(b.name)
								 FROM bids b
								 WHERE FIND_IN_SET(b.id,c.b_id)
								) AS bidsName
							FROM
								contract c,
								contract_manager cm,
								company com,
								project p
							WHERE
								c.p_id = p.id AND
								c.m_id = cm.id AND
								c.c_id = com.id AND
								cm.confirm = 1 AND
								cm.vertify = 1
						");
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}
	public function categoryList() {
		$id = Request::param('id');
		$data = Db::query(" SELECT
								ca.id as id,
								c.name as className,
								ca.name as cateName
							FROM
								company com,
								classify c,
								category ca
							WHERE
								 com.id = $id AND
								 com.category_id=ca.id AND
								 ca.classify_id = c.id
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
}
