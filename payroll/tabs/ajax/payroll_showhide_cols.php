<?php
	if(session_id()==''){session_start(); ob_start();}
	include('../../../dbconnect/db_connect.php');
	$att_cols = array();
	$cols = array();
	if(isset($_REQUEST['cols'])){
		foreach($_REQUEST['cols'] as $k=>$v){
			$att_cols[$v['db']] = $v['name'];
			$cols[] = (int)$v['id'];
		}
		if(!$dbc->query("UPDATE ".$_SESSION['rego']['cid']."_sys_settings SET 
			payroll_empgroup_cols = '".$dbc->real_escape_string(serialize($att_cols))."', 
			payroll_empgroup_showhide_cols = '".$dbc->real_escape_string(serialize($cols))."'")){
				//echo mysqli_error($dbc);
			}
	}else{

		if(!$dbc->query("UPDATE ".$_SESSION['rego']['cid']."_sys_settings SET 
			payroll_empgroup_cols = '".$dbc->real_escape_string('')."', 
			payroll_empgroup_showhide_cols = '".$dbc->real_escape_string('')."'")){
		}
	}
	
?>