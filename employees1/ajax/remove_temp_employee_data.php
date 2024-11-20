<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");

	$dbc->query("DELETE FROM ".$cid."_temp_employee_data WHERE emp_id = '".$_REQUEST['empid']."'");
	ob_clean();
	echo 1;
	
?>