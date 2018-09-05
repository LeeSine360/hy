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
        if($param['proAC'] == 'project'){
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
        }
        if($param['proAC'] == 'bids'){
            //{"proId":"10","bidsName":"234","bidsStart":"234","bidsDays":"234","bidsRemark":"234","proAC":"bids"}
            //id, name, p_id, m_id, create_time, update_time
        }

        //return json(array('code' => $id, 'msg' => $msg));
    }

    public function query()
    {
        $list   = Pro::all();
        $number = count($list);

        $data = array();

        foreach ($list as $key => $value) {
            $data[] = array(
                'proId'   => $value['id'],
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
