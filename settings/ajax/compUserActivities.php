<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");


	echo '<pre>';
	print_r($_REQUEST);
	echo '</pre>';


?>