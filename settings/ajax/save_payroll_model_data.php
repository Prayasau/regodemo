<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");
	include(DIR.'files/functions.php');

	$sql = "INSERT INTO ".$cid."_payroll_models (`apply`, `code`, `tab_name`, `name`, `description`) VALUES ('1', '".$_REQUEST['code']."', 'PayrollModel', '".$_REQUEST['name']."', '".$_REQUEST['description']."')";
	$dbc->query($sql);
		
	ob_clean();
	echo 'success';

?>