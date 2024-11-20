<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");

	$_SESSION['rego']['cur_year'] = $_REQUEST['newYear'];
	ob_clean();
	echo 1;
?>


