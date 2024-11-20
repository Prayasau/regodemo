<?php

	if(session_id()==''){session_start();}
	ob_start();
	include('../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	//var_dump($_REQUEST); exit;
	//unset($_SESSION['rego']);
	
	if(empty($_REQUEST['username']) || empty($_REQUEST['password'])){
		ob_clean(); 
		echo 'empty'; 
		exit;
	}

	$username = strtolower(preg_replace('/\s+/', '', $_REQUEST['username']));
	$password = hash('sha256', preg_replace('/\s+/', '', $_REQUEST['password'])); 

	$sql = "SELECT * FROM rego_all_users WHERE LOWER(username) = '".$username."'";
	if($res = $dbx->query($sql)){
		if($all_users = $res->fetch_assoc()){
			if($all_users['password'] != $password){

				ob_clean(); 
				//echo $all_users['password'].' = '.$password;
				echo('wrong');
				exit;
			}

			if($all_users['type'] == 'emp'){
				if($all_users['emp_status'] == 0){
					ob_clean(); 
					echo('status');
					exit;
				}
				$_SESSION['rego']['timestamp'] = time();
				$_SESSION['rego']['cid'] = $all_users['emp_access'];
				$_SESSION['rego']['type'] = $all_users['type'];
				$_SESSION['rego']['emp_id'] = $all_users['emp_id'];
				$_SESSION['rego']['fname'] = $all_users['firstname'];
				$_SESSION['rego']['name'] = $all_users['firstname'].' '.$all_users['lastname'];
				$_SESSION['rego']['username'] = $all_users['username'];
				$_SESSION['rego']['img'] = $all_users['img'].'?'.time();
				//var_dump($_SESSION['rego']); exit;

				
				ob_clean(); 
				echo $all_users['type'];
				exit;
			}
			
			// IF NOT EMPLOYEE USER ////////////////////////////////////////////////////
			//if($all_users['sys_status'] && $all_users['com_status'] != 1){
			if($all_users['sys_status'] != 1){
				if($all_users['com_status'] != 1){
					ob_clean(); 
					echo('status');
					exit;
				}
			}
			$last = $all_users['last'];
			if(empty($last)){
				$tmp = explode(',', $all_users['sys_access']);
				$last = $tmp[0];
			}
			if(empty($last)){
				ob_clean(); 
				echo('nocomp');
				exit;
			}
			//var_dump($all_users); //exit;
			
	
			$sql = "SELECT * FROM rego_customers WHERE clientID = '".$last."'";
			if($res = $dbx->query($sql)){
				if($row = $res->fetch_assoc()){
					if($row['status'] == 0){ 
						ob_clean(); 
						echo 'status'; 
						exit;
					}
				}else{
					ob_clean(); 
					echo 'wrong'; 
					exit;
				}
			}
			
			
			$my_dbcname = $prefix.$last;
			//var_dump($my_dbcname);
			
			$dbc = new mysqli($my_database,$my_username,$my_password,$my_dbcname);
			mysqli_set_charset($dbc,"utf8");

			$sql = "SELECT * FROM ".$last."_users WHERE ref = '".$all_users['id']."' order by CASE WHEN type = 'sys' THEN 1 WHEN type = 'comp' THEN 2 WHEN type = 'emp' THEN 3 else type end, type"; 
			if($res = $dbc->query($sql)){
				if($res->num_rows > 0){
					$com_users = $res->fetch_assoc();
				}else{
					ob_clean();
					echo('wrong');
					exit;
				}
			}else{
				ob_clean();
				echo('wrong');
				exit;
			}
			//var_dump($com_users); exit;
			
			if($com_users['status'] != 1){
				ob_clean(); 
				echo('suspended');
				exit;
			}else{

				/*if(empty($com_users['entities']) || empty($com_users['permissions'])){
					ob_clean(); 
					echo('access');
					exit;
				}*/

				$allcompany = '';
				if($all_users['sys_access'] !=''){
					$allcompany .= $all_users['sys_access'].',';
				}

			
				if($all_users['com_access'] !=''){
					$allcompany .= $all_users['com_access'].',';
				}

				
				if($all_users['emp_access'] !=''){
					$allcompany .= $all_users['emp_access'];
				}

				$allcompanystr = implode(',',array_unique(explode(',', $allcompany)));


				$array['timestamp'] = time();
				$array['id'] = $com_users['id'];
				$array['ref'] = $com_users['ref'];
				$array['cid'] = $last;
				$array['customers'] = $allcompanystr;
				$array['sys_access'] = $all_users['sys_access'];
				$array['com_access'] = $all_users['com_access'];
				$array['emp_access'] = $all_users['emp_access'];
				$array['type'] = $com_users['type'];
				$array['emp_id'] = $com_users['emp_id'];
				$array['fname'] = $com_users['firstname'];
				$array['name'] = $com_users['name'];
				//$array['phone'] = $com_users['phone'];
				$array['username'] = $com_users['username'];
				$array['img'] = $com_users['img'].'?'.time();
				
				$array['mn_entities'] = $com_users['entities'];
				$array['mn_branches'] = $com_users['branches'];
				$array['mn_divisions'] = $com_users['divisions'];
				$array['mn_departments'] = $com_users['departments'];
				$array['mn_teams'] = $com_users['teams'];
				
				$array['sel_entities'] = $com_users['entities'];
				$array['sel_branches'] = $com_users['branches'];
				$array['sel_divisions'] = $com_users['divisions'];
				$array['sel_departments'] = $com_users['departments'];
				$array['sel_teams'] = $com_users['teams'];
				$array['mn_groups'] = $com_users['groups'];
				
				$array['access_group'] = $com_users['emp_group'];
				if($com_users['emp_group'] == 'all'){
					$array['emp_group'] = 's';
				}else{
					$array['emp_group'] = $com_users['emp_group'];
				}
				$tmp = unserialize($com_users['permissions']);
				if(!$tmp){$tmp = array();}

				$_SESSION['rego'] = array_merge($array, $tmp);

				//== Save info into log data ==//
				writeToLogfile('log', 'Log-in');

				//echo 'kfkfkf';
				//die('kkk');
				//var_dump($tmp); exit;
				//var_dump($_SESSION['rego']); exit;
				ob_clean(); 
				echo $com_users['type'];
				exit;
			}
		}else{
			ob_clean(); echo('exist'); exit;
		}
	}else{
		//echo mysqli_error($dbc);
		ob_clean(); echo('error'); exit;
	}
	
	
	
	
	
	
