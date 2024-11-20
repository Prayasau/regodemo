<?
	if(session_id()==''){session_start(); ob_start();}
	include('../../dbconnect/db_connect.php');


	if($_SESSION['RGadmin']['id'])
	{
		$dbc->query("DELETE FROM ".$_SESSION['rego']['cid']."_temp_employee_data WHERE user_id = '".$_SESSION['RGadmin']['id']."'");
		$dbc->query("DELETE FROM ".$_SESSION['rego']['cid']."_temp_log_history WHERE user_id = '".$_SESSION['RGadmin']['id']."'");
	}
	else
	{
		$dbc->query("DELETE FROM ".$_SESSION['rego']['cid']."_temp_employee_data WHERE user_id = '".$_SESSION['rego']['id']."'");
		$dbc->query("DELETE FROM ".$_SESSION['rego']['cid']."_temp_log_history WHERE user_id = '".$_SESSION['rego']['id']."'");
	}

	$_SESSION['rego']['updateAnythingValue'] ='';
	$_SESSION['rego']['selectionSelectValue'] ='Choose Section';
	$dbc->query("UPDATE ".$_SESSION['rego']['cid']."_sys_settings SET modify_empdata_section_cols = '', modify_empdata_section_showhide_cols = ''");


	ob_clean();
	echo 'success';

?>