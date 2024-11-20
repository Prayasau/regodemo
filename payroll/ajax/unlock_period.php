<?php
	if(session_id()==''){session_start(); ob_start();}
	include("../../dbconnect/db_connect.php");
	$sql = "UPDATE ".$_SESSION['rego']['cid'].'_payroll_'.$_SESSION['rego']['cur_year']." SET `paid` = 'C' WHERE month = '".sprintf('%02d', $_REQUEST['id'])."'";
	//echo $sql; exit;
	ob_clean();
	if($dbc->query($sql)){
		echo 'ok';
	}else{
		echo mysqli_error($dbc);
	}
?>