<?php
	
	if(session_id()==''){session_start();}
	ob_start();
	
	include("../../dbconnect/db_connect.php");


	// unset session with old cid 
	// set session with selected cid 


	$sql = "SELECT * FROM rego_all_users WHERE id = '".$_SESSION['rego']['ref']."'";
	if($res = $dbx->query($sql))
	{
		if($row = $res->fetch_assoc())
		{

	
			// $_SESSION['rego']['cid'] = $_REQUEST['selectedCompany'] ;
			// $_SESSION['rego']['type'] = $row['type'];
			// $_SESSION['rego']['emp_id'] = $row['emp_id'];
			// $_SESSION['rego']['name'] = $row['firstname'].' '.$row['lastname'];
			// $_SESSION['rego']['phone'] = $com_users['phone'];
			// $_SESSION['rego']['username'] = $row['username'];
			// $_SESSION['rego']['sys_access'] = $row['sys_access'];
			// $_SESSION['rego']['com_access'] = $row['com_access'];
			// $_SESSION['rego']['emp_access'] = $row['emp_access'];
			// $_SESSION['rego']['sys_status'] = $row['sys_status'];
			// $_SESSION['rego']['com_status'] = $row['com_status'];
			// $_SESSION['rego']['emp_status'] = $row['emp_status'];
			// $_SESSION['rego']['payroll_dbase'] = $_REQUEST['selectedCompany'].'_payroll_2021' ;
			// $_SESSION['rego']['emp_dbase'] = $_REQUEST['selectedCompany'].'_employees' ;

		}
	}




	// echo $_REQUEST['selectedCompany'];



	// echo '<pre>';
	// print_r($_SESSION['rego']); 
	// echo '</pre>'; 
	die();

?>