<?php

namespace app\index\controller;

use think\Request;

class Index 
{
	public function index(Request $request)
    {
    	// 获取name请求变量
    	return $request->name;
    }
    public function hello(Request $request)
    {
        return $request->name;
    }
    public function json()
    {
    	$data = array('a' => 12, 'b'=>100);
    	// 输出JSON
        return json($data);
    }
}