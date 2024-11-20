<?
	if(session_id()==''){session_start(); ob_start();}
	//$cid = $_SESSION['rego']['cid'];
	include("../../dbconnect/db_connect.php");
	//var_dump($_REQUEST);// exit;
	
	$sql = "UPDATE ".$cid."_monthly_shiftplans_".$cur_year." SET ".$_REQUEST['col']." = '".$dbc->real_escape_string($_REQUEST['val'])."' WHERE id = '".$_REQUEST['id']."'";

	// $sql2 = "UPDATE ".$cid."_attendance SET plan = '".$dbc->real_escape_string($_REQUEST['val'])."' WHERE id = '".$_REQUEST['id']."'";
	// echo $sql; exit;
		
	if($dbc->query($sql)){
		ob_clean();	echo 'success'; exit;
	}else{
		ob_clean();	echo 'Error : '.mysqli_error($dbc);
	}
	
?>