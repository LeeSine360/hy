<?php
$dir = "E:\供应商资料\常德东海防水保温工程有限公司";
$dh  = opendir($dir);
while (false !== ($filename = readdir($dh))) {
    $files[] = $filename;
}

rsort($files);

print_r($files);

?> 
