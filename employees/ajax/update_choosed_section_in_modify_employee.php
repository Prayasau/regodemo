<?php
	if(session_id()==''){session_start(); ob_start();}
	include('../../dbconnect/db_connect.php');



	$modify_empdata_section_cols= 'a:19:{s:3:"sid";s:7:"Scan ID";s:5:"title";s:5:"Title";s:9:"firstname";s:10:"First name";s:8:"lastname";s:9:"Last name";s:7:"en_name";s:15:"Name in English";s:9:"birthdate";s:9:"Birthdate";s:11:"nationality";s:11:"Nationality";s:6:"gender";s:6:"Gender";s:8:"maritial";s:15:"Maritial status";s:8:"religion";s:8:"Religion";s:15:"military_status";s:15:"Military status";s:6:"height";s:6:"Height";s:6:"weight";s:6:"Weight";s:9:"bloodtype";s:10:"Blood type";s:13:"drvlicense_nr";s:19:"Driving license No.";s:14:"drvlicense_exp";s:19:"License expiry date";s:9:"idcard_nr";s:7:"ID card";s:10:"idcard_exp";s:19:"ID card expiry date";s:6:"tax_id";s:10:"Tax ID no.";}';

	$modify_empdata_section_showhide_cols = 'a:19:{i:0;i:2;i:1;i:3;i:2;i:4;i:3;i:5;i:4;i:6;i:5;i:7;i:6;i:8;i:7;i:9;i:8;i:10;i:9;i:11;i:10;i:12;i:11;i:13;i:12;i:14;i:13;i:15;i:14;i:16;i:15;i:17;i:16;i:18;i:17;i:19;i:18;i:20;}'; 



	if($_REQUEST['selectionSelect'] == '1')
	{
		$dbc->query("UPDATE ".$_SESSION['rego']['cid']."_sys_settings SET 
			modify_empdata_section_cols = '".$dbc->real_escape_string($modify_empdata_section_cols)."', 
			modify_empdata_section_showhide_cols = '".$dbc->real_escape_string($modify_empdata_section_showhide_cols)."'");

		echo '1';
	}
	else
	{
		$dbc->query("UPDATE ".$_SESSION['rego']['cid']."_sys_settings SET 
			modify_empdata_section_cols = '', 
			modify_empdata_section_showhide_cols = ''");
		echo '2';


	}

	$_SESSION['rego']['selectionSelectValue']  = $_REQUEST['selectionSelect'];


?>