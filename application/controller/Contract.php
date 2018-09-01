<?php
namespace app\controller;
use think\Controller;

class Contract extends Controller {
	public function index() {
		return $this->fetch();
	}
}
