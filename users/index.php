<?php
function __autoload($classname){
    $s=substr($classname,0,1);
	$s=($s=='C')?'c/':'m/';
	$path=$s.$classname.".php";
	include_once($path);
}
$action='action_';
$action.=(isset($_GET['act']))?$_GET['act']:'index';
$cName=isset($_GET['c'])?('C_'.$_GET['c']):('C_User');
$controller=new $cName();
$controller->Request($action);
?>
