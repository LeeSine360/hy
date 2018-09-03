<?php
namespace app\controller;

use app\model\Project as Pro;
use think\Controller;

class Project extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    public function add()
    {
        $param = $_POST;
        $pro   = Pro::create([
            'name'       => $param['proName'],
            'price'      => $param['proPrice'],
            'start_time' => $param['proStart'],
            'days'       => $param['proDays'],
            'number'     => $param['proNumber'],
            'remark'     => $param['proRemark'],
        ]);

        $id  = $pro->id;
        $msg = $id > 0 ? "添加成功！" : "添加失败！";

        return json(array('code' => $id, 'msg' => $msg));
    }

    public function query()
    {
        $list   = Pro::all();
        $number = count($list);

        $data = array();

        foreach ($list as $key => $value) {
            $data[] = array(
                'proName'   => $value['name'],
                'proPrice'  => $value['price'],
                'proStart'  => date("Y-m-d", $value['start_time']),
                'proDays'   => $value['days'],
                'proNumber' => $value['number'],
                'proRemark' => $value['remark']);
        }

        $return = array('code' => 0, 'msg' => '', 'count' => $number, 'data' => $data);
        return json($return);
    }
}
