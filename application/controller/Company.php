<?php
namespace app\controller;

use app\model\Company as Com;
use think\Controller;
use think\Db;
use think\facade\Request;

class Company extends Controller {
	public function index() {
		return $this->fetch();
	}
	public function classify() {
		return $this->fetch();
	}
	public function companyAdd() {
		$id = 0;
		$msg = '';

		$com = Com::create([
			'name' => Request::param('comName'),
			'bank_name' => Request::param('comAccountName'),
			'account' => Request::param('comAccount'),
			'phone' => Request::param('comPhone'),
			'datum' => implode(",", array_values(Request::param('comComplete'))),
			'remark' => Request::param('remark'),
		]);

		$id = $com->id;
		$msg = $id > 0 ? "添加成功！" : "添加失败！";

		return json(array('code' => $id, 'msg' => $msg));
	}

	public function companyOptionList() {
		$corId = Request::param('corid'); //公司ID
		$proId = Request::param('pid'); //项目ID
		$mId = Request::param('mid'); //标段ID

		$data = [];

		if ($corId != 0 && $proId != 0 && $mId != 0) {
			$data = Db::query("SELECT
								c.id as id,
								c.name as name,
								c.bank_name as bankName,
								c.account as account,
								c.phone as phone,
								c.datum as datum,
								c.remark as remark
						   FROM
						   		company c,
						   		contract con
						   WHERE
						   		con.corporation_id = $corId AND
						   		con.project_id = $proId AND						   		
						   		FIND_IN_SET($mId,con.project_manager_id) AND
						   		con.company_id = c.id
						   GROUP BY
						   		c.id
						   ORDER BY c.id ASC
						  ");
		} else {
			$data = Com::all();
		}

		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}

	public function companyList() {
		$page = Request::param('page');
		$limit = Request::param('limit');
		$curr = $page <= 1 ? 0 : ($page - 1) * $limit + 1;
		$list = Db::query("SELECT
								SQL_CALC_FOUND_ROWS id as comId,
								name as comName,
								bank_name as comBankName,
								account as comAccount,
								phone as comPhone,
								datum as comDatum,
								remark as comRemark
						   FROM
						   		company c
						   ORDER BY c.id ASC
						   LIMIT $curr,$limit
						  ");
		$listTotal = Db::query("SELECT FOUND_ROWS() as rowcount");
		$return = array('code' => 0, 'msg' => '', 'count' => $listTotal[0]['rowcount'], 'data' => $list);
		return json($return);
	}

	public function classifySearch() {
		$data = Db::query(" SELECT
								c.id as id,
								c.name as classifyName
							FROM
								 classify c;
						");
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}

}