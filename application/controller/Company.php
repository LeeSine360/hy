<?php
namespace app\controller;

use app\model\Company as Com;
use think\Controller;
use think\Db;

class Company extends Controller {
	public function index() {
		return $this->fetch();
	}
	public function classify() {
		return $this->fetch();
	}
	public function add() {
		$param = $_POST;
		$id = 0;
		$msg = '';

		$com = Com::create([
			'name' => $param['comName'],
			'c_id' => $param['catId'],
			'bank_name' => $param['comAccountName'],
			'account' => $param['comAccount'],
			'phone' => $param['comPhone'],
			'remark' => $param['remark'],
		]);

		$id = $com->id;
		$msg = $id > 0 ? "添加成功！" : "添加失败！";

		return json(array('code' => $id, 'msg' => $msg));
	}

	public function comQuery() {
		$list = Com::all();
		$number = count($list);

		$data = array();

		foreach ($list as $key => $value) {
			$data[] = array(
				'comId' => $value['id'],
				'comName' => $value['name'],
			);
		}

		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}

	public function query() {
		$param = $_GET;
		$curr = $param['page'] <= 1 ? 1 : ($param['page'] - 1) * $param['limit'] + 1;
		$limit = $param['limit'];
		$list = Com::order('id', 'asc')->limit($curr, $limit)->select();
		$listTotal = Com::all();
		$total = count($listTotal);

		$data = array();

		foreach ($list as $key => $value) {
			$data[] = array(
				'comId' => $value['id'],
				'comName' => $value['name'],
				'comBankName' => $value['bank_name'],
				'comAccount' => $value['account'],
				'comPhone' => $value['phone'],
				'comRemark' => $value['remark']);
		}

		$return = array('code' => 0, 'msg' => '', 'count' => $total, 'data' => $data);
		return json($return);
	}

	public function classifyList() {
		$data = Db::query(" SELECT
								c.id as id,
								c.name as cateName
							FROM
								 hy_classify c;
						");
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}
}
