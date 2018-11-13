<?php
namespace app\controller;
use think\Controller;

class Import extends Controller {
	public function index() {
		return $this->fetch();
	}
}
