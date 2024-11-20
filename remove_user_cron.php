<?
	include('dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	include(DIR.'files/arrays_'.$lang.'.php');

	$getCustomersData = getCustomersData();

	// curl --silent https://regodemo.com/remove_user_cron.php
	$res = $dbx->query("SELECT * FROM rego_all_users WHERE (sys_access IS NULL OR sys_access = '') AND (com_access IS NULL OR com_access = '') AND (emp_access IS NULL OR emp_access ='') ");
		if($res->num_rows > 0){
			while($row = $res->fetch_assoc()){

				if($row['sys_access'] && $row['com_access'] && $row['emp_access'] ==''){
					echo 'no value';
				}else{

					$tmpS1 = $row['sys_access'].','.$row['com_access'].','.$row['emp_access'];
					$tmpS2 = explode(',', $tmpS1);
					$tmpS  = array_values(array_filter($tmpS2, 'strlen'));
					$uniqueCid  = array_unique($tmpS);

					// echo "<pre>";
					// print_r($uniqueCid);
					// echo "</pre>";

					$sql = "DELETE FROM `rego_all_users` WHERE `id`= '".$row['id']."'";
					$dbx->query($sql);

					if(isset($uniqueCid[0])){ 
						foreach ($uniqueCid as $key => $value) {
							$my_dbcname = 'admin_'.$value;
							$dbc = new mysqli($my_database,$my_username,$my_password,$my_dbcname);
							if($dbc->connect_error) {
								echo '<p style="width:900px; margin:0 auto; margin-top:20px;" class="box_err">Error: ('.$dbc->connect_errno.') '.$dbc->connect_error.'<br>Please try again later or report this error to <a href="mailto:admin@regohr.com">admin@regohr.com</a></p>';
							}else{
								mysqli_set_charset($dbc,"utf8");
							}

							$csql = $dbc->query("DELETE FROM ".$value."_users WHERE `ref`= '".$row['id']."'");
							if(!$csql){
								echo mysqli_error($dbc);
							}
						}
					}else{


					}
				}
			}

		}else{ // no record found
				echo 'in else<br>';
				//Remove deleted company users
				$res1 = $dbx->query("SELECT * FROM rego_all_users");
				if($res1->num_rows > 0){
					while ($row = $res1->fetch_assoc()) {
					
						//for system user
						$result_sys = array();
						$result_comp = array();
						$result_emp = array();

						$tmpS10 = $row['sys_access'];
						if($tmpS10 !=''){
							$tmpS20 = explode(',', $tmpS10);
							$tmpS0  = array_values(array_filter($tmpS20, 'strlen'));
							$uniqueCid0  = array_unique($tmpS0);
							$result_sys=array_intersect($getCustomersData,$uniqueCid0);
						}

						//for company user
						$tmpS11 = $row['com_access'];
						if($tmpS11 !=''){
							$tmpS21 = explode(',', $tmpS11);
							$tmpS1  = array_values(array_filter($tmpS21, 'strlen'));
							$uniqueCid1  = array_unique($tmpS1);
							$result_comp=array_intersect($getCustomersData,$uniqueCid1);
						}

						//for employee user
						$tmpS112 = $row['emp_access'];
						if($tmpS112 !=''){
							$tmpS212 = explode(',', $tmpS112);
							$tmpS12  = array_values(array_filter($tmpS212, 'strlen'));
							$uniqueCid12  = array_unique($tmpS12);
							$result_emp=array_intersect($getCustomersData,$uniqueCid12);
						}

						$implode_sys = '';
						$last ='';
						$sys_status = '';
						if(isset($result_sys[0])){
							$last = $result_sys[0];
							$sys_status = 1;
							$implode_sys = implode(',', $result_sys);
						}

						$implode_comp = '';
						$com_status = '';
						if(isset($result_comp[0])){
							if($last == ''){$last = $result_comp[0];}
							$com_status = 1;
							$implode_comp = implode(',', $result_comp);
						}

						$implode_emp = '';
						$emp_status = '';
						if(isset($result_emp[0])){
							if($last == ''){$last = $result_emp[0];}
							$emp_status = 1;
							$implode_emp = implode(',', $result_emp);
						}

						/*if($row['id'] == 86){
							echo "<pre>";
							print_r($getCustomersData);
							print_r($uniqueCid);
							print_r($result_sys);
							echo "</pre>";

							echo $implode_sys;
						}*/

						$sqlqq = "UPDATE `rego_all_users` SET `sys_access`='".$implode_sys."', `com_access`='".$implode_comp."', `last`='".$last."', `emp_access`='".$implode_emp."', `sys_status`='".$sys_status."', `com_status`='".$com_status."', `emp_status`='".$emp_status."' WHERE `id`= '".$row['id']."'"; 
						//echo $sqlqq; echo '<br>';
						$dbx->query($sqlqq);
					}
				}
		}
?>