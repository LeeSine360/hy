<?php
namespace app\controller;
use think\Controller;
use think\Db;

class Contract extends Controller {
	public function index() {
		return $this->fetch();
	}
	public function label(){
		return $this->fetch();
	}
	public function labelList(){
		//$data = Db::table('hy_category')->select();
		$data = Db::table('hy_category cate,hy_classify class')->where('cate.classify_id = class.id')->field('cate.id as id,cate.name as name ,class.name as classify')->order('cate.id desc' )->select();
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}
	public function classQuery(){
		$data = Db::table('hy_classify')->field('id,name')->order('id desc')->select();
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}
	public function contractQuery(){
		$param = $_GET;
		$curr = $param['page'] <= 1 ? 1 : ($param['page'] - 1) * $param['limit'] + 1;
		$limit = $param['limit'];
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

	public function contractVerify(){
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
								c.id = cm.c_id AND
								c.c_id = com.id AND
								c.category_id = ca.id AND
								cm.vertify = 0
						");
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}
	public function contractConfirm(){
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
								c.id = cm.c_id AND
								c.c_id = com.id AND
								cm.confirm = 0
						");
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}
	public function contractSave(){
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
								c.id = cm.c_id AND
								c.c_id = com.id AND
								cm.confirm = 1 AND
								cm.vertify = 1
						");
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}
}
