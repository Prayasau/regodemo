<?
	if(session_id()==''){session_start();}
	include('../../../dbconnect/db_connect.php');


	$classname = $_REQUEST['classname']; 
	$heightvalue = $_REQUEST['heightvalue']; 
	$scrolly = $_REQUEST['scrolly']; 
	$pagelength = $_REQUEST['pagelength']; 

	$_SESSION['rego']['classname'] = $classname; 
	$_SESSION['rego']['heightvalue'] = $heightvalue; 
	$_SESSION['rego']['scrolly'] = $scrolly; 
	$_SESSION['rego']['pagelength'] = $pagelength; 


?>