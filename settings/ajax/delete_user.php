<?

	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");
	//var_dump($_REQUEST); exit;
	
	/*$res = $dbc->query("SELECT * FROM ".$cid."_users WHERE type = 'sys'");
	if($res->num_rows < 2){
		ob_clean();
		echo 'last'; 
		exit;
	}*/

	//exit;
	if($res = $dbc->query("DELETE FROM ".$cid."_users WHERE id = '".$_REQUEST['id']."'")){
		var_dump('DELETE FROM $cid_users'); //exit;
	}else{
		var_dump(mysqli_error($dbc)); //exit;
	}

	if(!empty($_REQUEST['emp'])){
		if($dbc->query("UPDATE ".$cid."_employees SET allow_login = '0' WHERE emp_id = '".$_REQUEST['emp']."'")){
			var_dump('UPDATE $cid_employees SET allow_login = 0');
		}else{
			var_dump(mysqli_error($dbc)); //exit;
		}
	}

	$a_exist = false;
	if($res = $dbx->query("SELECT * FROM rego_all_users WHERE id = '".$_REQUEST['ref']."'")){
		$a_exist = $res->fetch_assoc();
	}else{
		var_dump(mysqli_error($dbx)); //exit;
	}
	//var_dump($a_exist); //exit;


	// DELETE ONLY FROM rego_all_users IF MORE THAN ONE COMPANY !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	if($a_exist){

		//===== Remove access for company user =====//
		if($_REQUEST['type'] == 'sys' || $_REQUEST['type'] = 'app'){

			$allAccess = $a_exist['sys_access'];
			$access = explode(',', $allAccess);
			if(($key = array_search($cid, $access)) !== false) {
				unset($access[$key]);
			}

			if($access){

				$access  = array_values(array_filter($access, 'strlen'));
				$last = $a_exist['last'];
				if($last == $cid){
					$last = $access[0];
				}
				$access = implode(',', $access);

				$res = $dbx->query("UPDATE rego_all_users SET sys_access = '".$access."', last='".$last."', sys_status = '1' WHERE id = '".$a_exist['id']."'");

			}else{

				$res = $dbx->query("UPDATE rego_all_users SET sys_access = '', sys_status = '' WHERE id = '".$a_exist['id']."'");
			}

		//===== Remove access for company user =====//
		}elseif($_REQUEST['type'] == 'comp'){  

			$allAccess = $a_exist['com_access'];
			$access = explode(',', $allAccess);
			if(($key = array_search($cid, $access)) !== false) {
				unset($access[$key]);
			}

			if($access){

				$access  = array_values(array_filter($access, 'strlen'));
				$last = $a_exist['last'];
				if($last == $cid){
					$last = $access[0];
				}
				$access = implode(',', $access);

				$res = $dbx->query("UPDATE rego_all_users SET com_access = '".$access."', last='".$last."', com_status = '1' WHERE id = '".$a_exist['id']."'");

			}else{

				$res = $dbx->query("UPDATE rego_all_users SET com_access = '', com_status = '' WHERE id = '".$a_exist['id']."'");
			}

		}else{
			//nothing
		}
	

		// remove totally...
		$allAccessalll = $a_exist['sys_access'].','.$a_exist['com_access'].','.$a_exist['emp_access'];
		$accessdd = explode(',', $allAccessalll);
		$access  = array_values(array_filter($accessdd, 'strlen'));

		if(empty($access)){

			if($res = $dbx->query("DELETE FROM rego_all_users WHERE id = '".$a_exist['id']."'")){
				var_dump('DELETE FROM rego_all_users'); //exit;
			}else{
				var_dump(mysqli_error($dbx)); //exit;
			}
		}

	}
	
?>
