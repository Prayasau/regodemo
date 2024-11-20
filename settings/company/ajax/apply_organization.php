<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../../dbconnect/db_connect.php");

	
	$sql = "UPDATE ".$cid."_organization SET apply='".$_REQUEST['valchk']."' WHERE id='".$_REQUEST['rowid']."' ";
	
	if($dbc->query($sql)){
		ob_clean();
		echo 'success';
	}else{
		ob_clean();
		echo mysqli_error($dbc);
	}

?>