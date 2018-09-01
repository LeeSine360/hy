<?php
namespace app\controller;
use think\Controller;

class Company extends Controller {
	public function index() {
		return $this->fetch();
	}
}
