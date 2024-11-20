<?
	if(session_id()==''){session_start();}
	include("../dbconnect/db_connect.php");
	$_SESSION['rego']['cid'] = $_REQUEST['cid'];


	$sql1 = "SELECT * FROM rego_all_users WHERE LOWER(username) = '".$_SESSION['rego']['username']."'";
	if($res1 = $dbx->query($sql1)){
		if($all_users = $res1->fetch_assoc()){
			if($all_users['emp_access'] != $_REQUEST['cid']){

				$sqlcc = "SELECT * FROM ".$_SESSION['rego']['cid']."_users WHERE username = '".$_SESSION['rego']['username']."'";
				if($res = $dbc->query($sqlcc)){
					if($res->num_rows > 0){
						$com_users = $res->fetch_assoc();

						if($com_users['status'] != 0){

							// CHANGE LAST FIELD IN REGO_COMPANY_USERS /////////////////////////////////////
							$res = $dbx->query("UPDATE rego_all_users SET last = '".$_REQUEST['cid']."' WHERE username = '".$_SESSION['rego']['username']."'");
							echo mysqli_error($dbx);
						}
					}
				}
			}
		}
	}

	