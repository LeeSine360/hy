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
	public function labelList() {
		$id = Request::param('id');
		$page = Request::param('page');
		$limit = Request::param('limit');
		$curr = $page <= 1 ? 1 : ($page - 1) * $limit + 1;
		if ($id) {
			$data = Db::query(" SELECT
								ca.id as id,
								ca.name as name,
								c.name as classify
							FROM hy_classify c,
								 hy_category ca
							WHERE
								 c.id = $id AND
								 c.id=ca.c_id
						");
			$dataTotal = Db::query(" SELECT
								count(c.id) as value
							FROM hy_classify c,
								 hy_category ca
							WHERE
								 c.id = $id AND
								 c.id=ca.c_id
						");
		} else {
			$data = Db::query(" SELECT
								ca.id as id,
								ca.name as name,
								c.name as classify
							FROM hy_classify c,
								 hy_category ca
							WHERE
								 c.id=ca.c_id
						");
			$dataTotal = Db::query(" SELECT
								count(c.id) as value
							FROM hy_classify c,
								 hy_category ca
							WHERE
								 c.id=ca.c_id
						");
		}
		$return = array('code' => 0, 'msg' => '', 'count' => $dataTotal[0]['value'], 'data' => $data);
		return json($return);
	}
	public function classQuery() {
		$data = Db::table('hy_classify')->field('id,name')->order('id desc')->select();
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}
	public function contractQuery() {
		$page = Request::param('page');
		$limit = Request::param('limit');
		$curr = $page <= 1 ? 1 : ($page - 1) * $limit + 1;
		$data = Db::query("SELECT
								c.id as id,
								p.number as proNumber,
								p.name as proName,
								c.number as conNumber,
								com.name as comName,
								c.price as conPrice,
								ca.name as category,
								(SELECT
									GROUP_CONCAT(b.name)
								 FROM hy_bids b
								 WHERE FIND_IN_SET(b.id,c.b_id)
								) AS bidsName
							FROM
								hy_contract c,
								hy_company com,
								hy_project p,
								hy_category ca
							WHERE
								c.p_id = p.id AND
								c.c_id = com.id AND
								c.category_id = ca.id
							ORDER BY c.id ASC
							LIMIT $curr, $limit"
		);
		$listTotal = Db::query("SELECT
								c.id as id,
								p.number as proNumber,
								p.name as proName,
								c.number as conNumber,
								com.name as comName,
								c.price as conPrice,
								ca.name as category,
								(SELECT
									GROUP_CONCAT(b.name)
								 FROM hy_bids b
								 WHERE FIND_IN_SET(b.id,c.b_id)
								) AS bidsName
							FROM
								hy_contract c,
								hy_company com,
								hy_project p,
								hy_category ca
							WHERE
								c.p_id = p.id AND
								c.c_id = com.id AND
								c.category_id = ca.id");
		$number = count($listTotal);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
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
								 FROM hy_bids b
								 WHERE FIND_IN_SET(b.id,c.b_id)
								) AS bidsName
							FROM
								hy_contract c,
								hy_contract_manager cm,
								hy_company com,
								hy_project p,
								hy_category ca
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
								 FROM hy_bids b
								 WHERE FIND_IN_SET(b.id,c.b_id)
								) AS bidsName
							FROM
								hy_contract c,
								hy_contract_manager cm,
								hy_company com,
								hy_project p
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
								 FROM hy_bids b
								 WHERE FIND_IN_SET(b.id,c.b_id)
								) AS bidsName
							FROM
								hy_contract c,
								hy_contract_manager cm,
								hy_company com,
								hy_project p
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
								hy_company com,
								hy_classify c,
								hy_category ca
							WHERE
								 com.id = $id AND
								 com.c_id=c.id AND
								 c.id = ca.c_id
						");
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}
	public function comList() {
		$id = Request::param('id'); //项目ID
		$bid =  Request::param('bid'); //标段ID
		$query = "";
		if ($id == 0) {
			$query = " SELECT
								com.id as id,
								com.name as name
							FROM
								hy_company com,
								hy_contract con
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
								hy_company com,
								hy_contract con
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
	public function bidsList() {
		$id = Request::param('id'); //项目ID
		$query = "SELECT id,name FROM hy_bids where p_id = $id";
		$data = Db::query($query);
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}
}
