<?php
namespace app\controller;
use think\Controller;

class Manager extends Controller {
	public function index() {
		return $this->fetch();
	}
}
