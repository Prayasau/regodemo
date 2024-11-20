<?
	if(session_id()==''){session_start(); ob_start();}
	include('../../../dbconnect/db_connect.php');

	$dbc->query("DELETE FROM ".$_SESSION['rego']['cid']."_payroll_".$_SESSION['rego']['cur_year']." WHERE month = '".$_SESSION['rego']['cur_month']."'");

	ob_clean();
	echo 'success';

?>