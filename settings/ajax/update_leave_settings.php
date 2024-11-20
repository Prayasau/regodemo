<?
	if(session_id()==''){session_start();}
	ob_start();
	
	include("../../dbconnect/db_connect.php");
	//var_dump($_REQUEST);

	// echo '<pre>';
	// print_r($_REQUEST);
	// echo '</pre>';
	// exit;
	
	$sql = "UPDATE ".$cid."_leave_time_settings SET 
		leave_types = '".$dbc->real_escape_string(serialize($_REQUEST['type']))."', 
		request = '".$dbc->real_escape_string($_REQUEST['request'])."', 
		pr_leave_start = '".$dbc->real_escape_string($_REQUEST['pr_leave_start'])."', 
		pr_leave_end = '".$dbc->real_escape_string($_REQUEST['pr_leave_end'])."', 
		leave_start = '".$dbc->real_escape_string($_REQUEST['leave_start'])."', 
		leave_end = '".$dbc->real_escape_string($_REQUEST['leave_end'])."', 
		workingdays = '".$dbc->real_escape_string($_REQUEST['workingdays'])."', 
		dayhours = '".$dbc->real_escape_string($_REQUEST['dayhours'])."', 
		calc_attendance = '".$dbc->real_escape_string($_REQUEST['calc_attendance'])."', 
		attendance_target = '".$dbc->real_escape_string($_REQUEST['attendance_target'])."'"; 
		//echo $sql; //exit;
	if($dbc->query($sql)){
		$err_msg = 'success';
	}else{
		$err_msg = mysqli_error($dbc);
	}
	
	ob_clean();
	echo $err_msg;
	exit;
		
	
?>