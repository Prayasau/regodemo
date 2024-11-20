<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");
	include(DIR.'files/functions.php');

	$sqlR = $dbc->query("SELECT * FROM ".$cid."_benefit_models WHERE id = '".$_REQUEST['row_id']."'");
	if($sqlR->num_rows > 0){
		$sql = "UPDATE ".$cid."_benefit_models SET `apply`='".$_REQUEST['apply']."', `name`='".$_REQUEST['name']."', `penalties`='".$_REQUEST['penalties']."', `teams`='".$_REQUEST['teams']."', `all_data`='".serialize($_REQUEST)."' WHERE id = '".$_REQUEST['row_id']."' ";
	}else{
		$sql = "INSERT INTO ".$cid."_benefit_models (`apply`, `tab_name`, `name`, `penalties`, `teams`, `all_data`) VALUES ('".$_REQUEST['apply']."', '".$_REQUEST['tab_name']."', '".$_REQUEST['name']."', '".$_REQUEST['penalties']."', '".$_REQUEST['teams']."', '".serialize($_REQUEST)."')";
	}
	
	if($dbc->query($sql)){
		ob_clean();
		echo 'success';
	}else{
		ob_clean();
		echo mysqli_error($dbc);
	}

?>