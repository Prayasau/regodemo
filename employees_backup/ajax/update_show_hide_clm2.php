<?php
	if(session_id()==''){session_start(); ob_start();}
	include('../../dbconnect/db_connect.php');
	$att_cols = array();
	$cols = array();
	if(isset($_REQUEST['cols'])){
		foreach($_REQUEST['cols'] as $k=>$v){
			$att_cols[$v['db']] = $v['name'];
			$cols[] = (int)$v['id'];
		}
		if(!$dbc->query("UPDATE ".$_SESSION['rego']['cid']."_sys_settings SET 
			modify_empdata_section_cols = '".$dbc->real_escape_string(serialize($att_cols))."', 
			modify_empdata_section_showhide_cols = '".$dbc->real_escape_string(serialize($cols))."'")){
			}
	}else{

		if(!$dbc->query("UPDATE ".$_SESSION['rego']['cid']."_sys_settings SET 
			modify_empdata_section_cols = '".$dbc->real_escape_string('')."', 
			modify_empdata_section_showhide_cols = '".$dbc->real_escape_string('')."'")){
		}
	}
	
?>