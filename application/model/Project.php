<?php
namespace app\model;
use think\Model;

class Project extends Model
{
	//protected $pk = 'uid';	//主键名称ID
    //protected $table = 'think_user';// 设置当前模型对应的完整数据表名称     
    //protected $connection = 'db_config';// 设置当前模型的数据库连接
    
    /*public function add($request) {
    	$effects = Db::execute(
                        'INSERT INTO '
                        . $this->table_name.' '
                        . '(dptmt_name,dptmt_code,dptmt_index,dptmt_description) VALUES (?,?,?,?)',
                        [$datas['name'],$datas['code'],$datas['index'],$datas['description']]
                    );
                if( $effects>0 ){
                    return response_tpl(200, '添加数据成功',Db::getLastInsID());    //新增成功返回最新添加的id
                }

	}*/
}