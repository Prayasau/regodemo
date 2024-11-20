<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");

	// echo '<pre>';
	// print_r($_REQUEST);
	// echo '</pre>';
	// die();

	$sql = "UPDATE ".$cid."_sys_settings SET `work_days_per_week`='".$_REQUEST['work_days_per_week']."', `checked_days`='".serialize($_REQUEST['checked_days'])."', `input_hours`='".serialize($_REQUEST['input_hours'])."'";
	if($dbc->query($sql)){
		ob_clean();
		echo 'success';
	}else{
		ob_clean();
		echo mysqli_error($dbc);
	}
	
	exit;

?>