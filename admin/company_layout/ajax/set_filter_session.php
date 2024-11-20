<?
	
	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");
		
	$select_filter_logo_and_headers =  $_REQUEST['select_filter_logo_and_headers'];
	$_SESSION['logo_and_headers_filter_session'] = $select_filter_logo_and_headers;


	echo 'success';

	
