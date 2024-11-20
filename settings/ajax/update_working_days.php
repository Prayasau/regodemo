<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");

	foreach ($_REQUEST['workingdays'] as $key => $value) {
		$sql = "UPDATE ".$cid."_payroll_months SET `workdays`='".$value."' WHERE month='".$_SESSION['rego']['cur_year']."_".$key."'";
		$dbc->query($sql);
	}

	ob_clean();
	echo 1;
	
	
?>