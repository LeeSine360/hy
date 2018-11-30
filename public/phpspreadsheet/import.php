<?php
require 'vendor/autoload.php';

//include('conn.php');

$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
$reader->setReadDataOnly(true);
$spreadsheet = $reader->load('项目部材料合同台账.xlsx');

$worksheet = $spreadsheet->getActiveSheet();
$highestRow = $worksheet->getHighestRow(); // 总行数
$highestColumn = $worksheet->getHighestColumn(); // 总列数
//$highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5

$lines = $highestRow - 2;
if ($lines <= 0) {
	exit('Excel表格中没有数据');
}

//$sql = "INSERT INTO `t_student` (`name`, `chinese`, `maths`, `english`) VALUES ";

for ($row = 2; $row <= $highestRow; ++$row) {
	$print = '';
	for ($col = 1; $col <= 13; ++$col) {
		$print .= $worksheet->getCellByColumnAndRow($col, $row)->getValue() . ',';
	}
	echo rtrim($print, ",");
	echo "<br />";
}
/*$sql = rtrim($sql, ","); //去掉最后一个,号
try {
$db->query($sql);
echo 'OK';
} catch (Exception $e) {
echo $e->getMessage();
}*/
