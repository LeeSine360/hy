<?php
namespace app\controller;
use think\Controller;

class Project extends Controller {
	public function index() {
		return $this->fetch();
	}
}
