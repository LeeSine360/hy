<?php
namespace app\controller;

use app\model\Contract as Con;
use app\model\ContractExamine as CE;
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
	public function vertify(){
		return $this->fetch();
	}
	public function contractAdd() {
		/*$result = Con::order('id', 'asc')->select();

		return json($result);*/

		$conId = Con::create([
			'corporation_id' => Request::param('corpId'),
			'project_id' => Request::param('proId'),
			'project_manager_id' => implode(",", Request::param('bids')),
			'company_id' => Request::param('comId'),
			'price' => Request::param('conPrice'),
			'start_time' => strtotime(Request::param('conStartTime')),
			'end_time' => strtotime(Request::param('conEndTime')),
			'total' => Request::param('conNum'),
			'keep' => Request::param('conSave'),
			'category_id' => implode(",", array_filter(explode(",", Request::param('label')))),
			'name' => Request::param('name'),
			'phone' => Request::param('phone'),
			'remark' => Request::param('conRemark'),
		])->id;
		/*CM::create([
			'contract_id' => $conId,
			'type' => Request::param('type'),
			'name' => Request::param('conOpeName'),
			'phone' => Request::param('conOpePhone'),
		]);*/
		CE::create([
			'contract_id' => $conId,
		]);
		$msg = $conId > 0 ? "添加成功！" : "添加失败！";
		return json(array('code' => $conId, 'msg' => $msg));
	}

	public function contractTableList() {
		$page = Request::param('page');
		$limit = Request::param('limit');
		$curr = $page <= 1 ? 0 : ($page - 1) * $limit + 1;
		$data = Db::query("SELECT
								SQL_CALC_FOUND_ROWS c.id,
								c.id as id,
								p.name as proName,
								cor.name as corName,
								(SELECT GROUP_CONCAT(m.name) FROM manager m  WHERE FIND_IN_SET(m.id,c.project_manager_id)) AS bidsName,
								p.number as proNumber,
								c.number as conNumber,
								com.name as comName,
								c.price as conPrice,
								(SELECT GROUP_CONCAT(cat.name) FROM category cat WHERE FIND_IN_SET(cat.id, c.category_id)) AS categoryName
							FROM
								contract c,
								project p,
								corporation cor,
								company com
							WHERE
								c.project_id = p.id AND
								c.company_id = com.id AND
								c.corporation_id = cor.id
							ORDER BY c.id ASC
							LIMIT $curr, $limit");
		$listTotal = Db::query("SELECT FOUND_ROWS() as rowcount");

		$return = array('code' => 0, 'msg' => '', 'count' => $listTotal[0]['rowcount'], 'data' => $data);
		return json($return);
	}

	public function contractVertify() {
		$page = Request::param('page');
		$limit = Request::param('limit');
		$curr = $page <= 1 ? 0 : ($page - 1) * $limit + 1;
		$data = Db::query("SELECT
								SQL_CALC_FOUND_ROWS c.id,
								c.id as id,
								p.name as proName,
								cor.name as corName,
								(SELECT GROUP_CONCAT(m.name) FROM manager m  WHERE FIND_IN_SET(m.id,c.project_manager_id)) AS bidsName,
								p.number as proNumber,
								c.number as conNumber,
								com.name as comName,
								c.price as conPrice,
								(SELECT GROUP_CONCAT(cat.name) FROM category cat WHERE FIND_IN_SET(cat.id, c.category_id)) AS categoryName
							FROM
								contract c,
								project p,
								corporation cor,
								company com,
								contract_examine ce
							WHERE
								c.project_id = p.id AND
								c.company_id = com.id AND
								c.corporation_id = cor.id AND
								c.id = ce.contract_id AND
								ce.vertify = 0
							ORDER BY c.id ASC
							LIMIT $curr, $limit");
		$listTotal = Db::query("SELECT FOUND_ROWS() as rowcount");

		$return = array('code' => 0, 'msg' => '', 'count' => $listTotal[0]['rowcount'], 'data' => $data);
		return json($return);
	}
	public function contractConfirm() {
		$page = Request::param('page');
		$limit = Request::param('limit');
		$curr = $page <= 1 ? 0 : ($page - 1) * $limit + 1;
		$data = Db::query("SELECT
								SQL_CALC_FOUND_ROWS c.id,
								c.id as id,
								p.name as proName,
								cor.name as corName,
								(SELECT GROUP_CONCAT(m.name) FROM manager m  WHERE FIND_IN_SET(m.id,c.project_manager_id)) AS bidsName,
								p.number as proNumber,
								c.number as conNumber,
								com.name as comName,
								c.price as conPrice,
								(SELECT GROUP_CONCAT(cat.name) FROM category cat WHERE FIND_IN_SET(cat.id, c.category_id)) AS categoryName
							FROM
								contract c,
								project p,
								corporation cor,
								company com,
								contract_examine ce
							WHERE
								c.project_id = p.id AND
								c.company_id = com.id AND
								c.corporation_id = cor.id AND
								c.id = ce.contract_id AND
								ce.confirm = 0
							ORDER BY c.id ASC
							LIMIT $curr, $limit");
		$listTotal = Db::query("SELECT FOUND_ROWS() as rowcount");

		$return = array('code' => 0, 'msg' => '', 'count' => $listTotal[0]['rowcount'], 'data' => $data);
		return json($return);
	}
	public function contractSave() {
		$page = Request::param('page');
		$limit = Request::param('limit');
		$curr = $page <= 1 ? 0 : ($page - 1) * $limit + 1;
		$data = Db::query("SELECT
								SQL_CALC_FOUND_ROWS c.id,
								c.id as id,
								p.name as proName,
								cor.name as corName,
								(SELECT GROUP_CONCAT(m.name) FROM manager m  WHERE FIND_IN_SET(m.id,c.project_manager_id)) AS bidsName,
								p.number as proNumber,
								c.number as conNumber,
								com.name as comName,
								c.price as conPrice,
								(SELECT GROUP_CONCAT(cat.name) FROM category cat WHERE FIND_IN_SET(cat.id, c.category_id)) AS categoryName
							FROM
								contract c,
								project p,
								corporation cor,
								company com,
								contract_examine ce
							WHERE
								c.project_id = p.id AND
								c.company_id = com.id AND
								c.corporation_id = cor.id AND
								c.id = ce.contract_id AND
								ce.save = 0
							ORDER BY c.id ASC
							LIMIT $curr, $limit");
		$listTotal = Db::query("SELECT FOUND_ROWS() as rowcount");

		$return = array('code' => 0, 'msg' => '', 'count' => $listTotal[0]['rowcount'], 'data' => $data);
		return json($return);
	}

	public function operatorSearch() {
		$keyword = Request::param('keywords');
		$data = Con::field('distinct name','phone')->where('name', 'like', "%{$keyword}%")->select();
		return json(array('code' => 0, 'content' => $data));
	}
}
