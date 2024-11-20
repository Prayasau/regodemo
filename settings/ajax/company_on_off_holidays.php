<?
	if(session_id()==''){session_start();}
	ob_start();
	include('../../dbconnect/db_connect.php');

	$id = $_REQUEST['getid'];
	$apply = $_REQUEST['apply'];

	$res = "UPDATE ".$cid."_holidays SET `apply`='".$apply."' WHERE id='".$id."' ";
	$dbc->query($res);
	ob_clean();
	echo 1;
?>