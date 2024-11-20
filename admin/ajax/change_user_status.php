<?php
	if(session_id()==''){session_start();}
	ob_start();
	include("../dbconnect/db_connect.php");

	$userStatus = $_REQUEST['userstatus'];
	$UserName 	= $_REQUEST['Username'];

	$res = $dba->query("SELECT id, sys_access, com_access, emp_access FROM rego_all_users WHERE LOWER(username) = '".strtolower($UserName)."'");
	if($res->num_rows > 0){

		$row = $res->fetch_assoc();
		$allCid = $row['sys_access'].','.$row['com_access'].','.$row['emp_access'];
		$explodeCid = explode(',', $allCid);
		$FilterCid  = array_values(array_filter($explodeCid, 'strlen'));
		$uniqueCid  = array_unique($FilterCid);


		if(is_array($uniqueCid)){
			foreach ($uniqueCid as $key => $value) {
				$my_dbcname = 'admin_'.$value;
				$dbc = new mysqli($my_database,$my_username,$my_password,$my_dbcname);
				if($dbc->connect_error) {
					echo '<p style="width:900px; margin:0 auto; margin-top:20px;" class="box_err">Error: ('.$dbc->connect_errno.') '.$dbc->connect_error.'<br>Please try again later or report this error to <a href="mailto:admin@regohr.com">admin@regohr.com</a></p>';
				}else{
					mysqli_set_charset($dbc,"utf8");
				}

				$csql = $dbc->query("UPDATE ".$value."_users SET status='".$userStatus."' WHERE `username`= '".$UserName."'");
				if(!$csql){
					echo mysqli_error($dbc);
				}
			}
		}

		$sql = "UPDATE rego_all_users SET sys_status = '".$userStatus."', com_status = '".$userStatus."', emp_status = '".$userStatus."'  WHERE LOWER(username) = '".strtolower($UserName)."'";
		if($dba->query($sql)){
			ob_clean();	
			echo 'success';
		}else{
			ob_clean();	
			echo mysqli_error($dba);
		}
	}else{
		ob_clean();	
		echo 'old';
	}

?>