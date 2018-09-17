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
		//待完善
		$data = Db::table('hy_contract con,hy_bids bids，hy_company com')->where('cate.classify_id = class.id')->field('cate.id as id,cate.name as name ,class.name as classify')->order('cate.id desc' )->select();
		$number = count($data);
		$return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
		return json($return);
	}
}
