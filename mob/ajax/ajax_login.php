<?php

	if(session_id()==''){session_start();}
	ob_start();
	include('../../dbconnect/db_connect.php');  // CONNECT DATABASE
	include(DIR.'files/functions.php');			// GET FUNCTIONS FROM FILES FOLDER 
	
	// CHECK IF USERNAME AND PASSWORD FIELD HAS VALUE
	if(empty($_REQUEST['username']) || empty($_REQUEST['password']))
	{
		ob_clean(); 
		echo 'empty'; 
		exit;
	}


	// APPLY HASH TO PASSWORD TO MATCH THE PASSWORD IN DATABASE 

	$username = strtolower(preg_replace('/\s+/', '', $_REQUEST['username']));
	$password = hash('sha256', preg_replace('/\s+/', '', $_REQUEST['password'])); 


	// CHECK IF USER EXISTS IN THE DATABASE 
	$sql = "SELECT * FROM rego_all_users WHERE LOWER(username) = '".$username."' AND password = '".$password."'";
	if($res = $dbx->query($sql))
	{
		if($row = $res->fetch_assoc())
		{
			$_SESSION['rego']['cid'] = $row['emp_access'];
			$_SESSION['rego']['type'] = $row['type'];
			$_SESSION['rego']['emp_id'] = $row['emp_id'];
			$_SESSION['rego']['name'] = $row['firstname'].' '.$row['lastname'];
			$_SESSION['rego']['phone'] = $com_users['phone'];
			$_SESSION['rego']['username'] = $row['username'];
			$_SESSION['rego']['img'] = $row['img'].'?'.time();
			$_SESSION['rego']['timestamp'] = time();
			$_SESSION['rego']['sys_access'] = $row['sys_access'];
			$_SESSION['rego']['com_access'] = $row['com_access'];
			$_SESSION['rego']['emp_access'] = $row['emp_access'];
			$_SESSION['rego']['sys_status'] = $row['sys_status'];
			$_SESSION['rego']['com_status'] = $row['com_status'];
			$_SESSION['rego']['emp_status'] = $row['emp_status'];

			//writeToLogfile('log', 'Log-in');
			$cookie = array('user'=>$_REQUEST['username'], 'pass'=>$_REQUEST['password'], 'remember'=>$_REQUEST['remember'], 'lang'=>$lang);
			setcookie('log', serialize($cookie), time()+31556926 ,'/');
			
			ob_clean(); 
			echo 'success';
			exit;
		}
		else
		{
			echo('wrong');
		}
	}
	else{
		echo('wrong');
	}








