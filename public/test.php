<?php
$array1 = array("license"=>"营业执照", "identity"=>"法人身份证", "bank"=>"开户银行许可证", "certificate"=>"其他资质证明");
$array2 = array("license", "bank");

$array = array_keys($array1);
$result = array_intersect($array2, $array);

$return = array();

foreach ($result as $key => $value) {
	$return[] = $array1[$value];
}

echo implode(",", $return);
?> 
