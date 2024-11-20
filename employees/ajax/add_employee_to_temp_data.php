<?
	if(session_id()==''){session_start(); ob_start();}
	include('../../dbconnect/db_connect.php');


	if($_SESSION['RGadmin']['id'])
	{
		$sesssionUserId = $_SESSION['RGadmin']['id'];
	}
	else
	{
		$sesssionUserId = $_SESSION['rego']['id'];
	}



	if($_REQUEST['empid'] == 'all'){


		//$dbc->query("TRUNCATE TABLE ".$_SESSION['rego']['cid']."_temp_employee_data");
		$dbc->query("DELETE FROM ".$_SESSION['rego']['cid']."_temp_employee_data WHERE user_id = '".$sesssionUserId."'");

		$data = array();
		$res1 = "SELECT * FROM ".$_SESSION['rego']['cid']."_employees WHERE emp_status = '1' "; 
		$res = $dbc->query($res1);
		while($row = $res->fetch_assoc()){
			$data[] = $row;
		}

		foreach ($data as $key => $row) {
		    
		    $dbc->query("INSERT INTO ".$_SESSION['rego']['cid']."_temp_employee_data (`user_id`, `emp_id`, `position`, `company`, `location`, `division`, `department`, `team`, `organization`, `groups`, `sid`, `title`, `firstname`, `lastname`, `th_name`, `en_name`, `birthdate`, `nationality`, `gender`, `maritial`, `religion`, `military_status`, `height`, `weight`, `bloodtype`, `drvlicense_nr`, `drvlicense_exp`, `idcard_nr`, `idcard_exp`, `tax_id`, `reg_address`, `sub_district`, `district`, `province`, `postnr`, `country`, `latitude`, `longitude`, `cur_address`, `personal_phone`, `work_phone`, `personal_email`, `work_email`, `username_option`, `username` ,`joining_date`, `probation_date`, `emp_type`, `account_code`, `groups_work_data`, `time_reg`, `selfie`, `workFromHome`, `annual_leave`,`resign_date`,`emp_status`,`date_position`) VALUES ('".$sesssionUserId."', '".$row['emp_id']."', '".$row['position']."', '".$row['entity']."', '".$row['branch']."', '".$row['division']."', '".$row['department']."', '".$row['team']."', '".$row['organization']."', '".$row['groups']."', '".$row['sid']."', '".$row['title']."', '".$row['firstname']."', '".$row['lastname']."', '".$row['th_name']."', '".$row['en_name']."', '".$row['birthdate']."', '".$row['nationality']."', '".$row['gender']."', '".$row['maritial']."', '".$row['religion']."', '".$row['military_status']."', '".$row['height']."', '".$row['weight']."', '".$row['bloodtype']."', '".$row['drvlicense_nr']."', '".$row['drvlicense_exp']."', '".$row['idcard_nr']."', '".$row['idcard_exp']."', '".$row['tax_id']."', '".$row['reg_address']."', '".$row['sub_district']."', '".$row['district']."', '".$row['province']."', '".$row['postnr']."', '".$row['country']."', '".$row['latitude']."', '".$row['longitude']."', '".$row['cur_address']."', '".$row['personal_phone']."', '".$row['work_phone']."', '".$row['personal_email']."', '".$row['work_email']."', '".$row['username_option']."', '".$row['username']."', '".$row['joining_date']."', '".$row['probation_date']."', '".$row['emp_type']."', '".$row['account_code']."', '".$row['groups']."', '".$row['time_reg']."', '".$row['selfie']."', '".$row['workFromHome']."', '".$row['annual_leave']."','".$row['resign_date']."','".$row['emp_status']."','".$row['date_position']."' ) ");
		}
	}else{


		$checkEmpid = $dbc->query("SELECT * FROM ".$_SESSION['rego']['cid']."_temp_employee_data WHERE emp_id = '".$_REQUEST['empid']."' AND user_id = '".$sesssionUserId."'");
		if($checkEmpid->num_rows > 0){

			$res1 = "SELECT * FROM ".$_SESSION['rego']['cid']."_employees WHERE emp_id = '".$_REQUEST['empid']."'"; 
			$res = $dbc->query($res1);
			$row = $res->fetch_assoc();
			
			

			$dbc->query("UPDATE ".$_SESSION['rego']['cid']."_temp_employee_data SET `position`='".$row['position']."', `company`='".$row['entity']."', `location`='".$row['branch']."', `division`='".$row['division']."', `department`='".$row['department']."', `team`='".$row['team']."', `organization`='".$row['organization']."', `groups`='".$row['groups']."', `sid`='".$row['sid']."', `title`='".$row['title']."', `firstname`='".$row['firstname']."', `lastname`='".$row['lastname']."', `th_name`='".$row['th_name']."', `en_name`='".$row['en_name']."', `birthdate`='".$row['birthdate']."', `nationality`='".$row['nationality']."', `gender`='".$row['gender']."' ,`maritial`='".$row['maritial']."',`religion`='".$row['religion']."',`military_status`='".$row['military_status']."' ,`height`='".$row['height']."' ,`weight`='".$row['weight']."' ,`bloodtype`='".$row['bloodtype']."' ,`drvlicense_nr`='".$row['drvlicense_nr']."' ,`drvlicense_exp`='".$row['drvlicense_exp']."',`idcard_nr`='".$row['idcard_nr']."',`idcard_exp`='".$row['idcard_exp']."',`tax_id`='".$row['tax_id']."',`reg_address`='".$row['reg_address']."',`sub_district`='".$row['sub_district']."',`district`='".$row['district']."',`province`='".$row['province']."' ,`postnr`='".$row['postnr']."' ,`country`='".$row['country']."',`latitude`='".$row['latitude']."',`longitude`='".$row['longitude']."',`cur_address`='".$row['cur_address']."',`personal_phone`='".$row['personal_phone']."',`work_phone`='".$row['work_phone']."' ,`personal_email`='".$row['personal_email']."',`work_email`='".$row['work_email']."' ,`username_option`='".$row['username_option']."',`username`='".$row['username']."',`joining_date`='".$row['joining_date']."',`probation_date`='".$row['probation_date']."',`emp_type`='".$row['emp_type']."',`account_code`='".$row['account_code']."',`groups_work_data`='".$row['groups']."',`time_reg`='".$row['time_reg']."' ,`selfie`='".$row['selfie']."',`workFromHome`='".$row['workFromHome']."' ,`annual_leave`='".$row['annual_leave']."',`resign_date`='".$row['resign_date']."',`emp_status`='".$row['emp_status']."',`date_position`='".$row['date_position']."'  WHERE emp_id = '".$row['emp_id']."' AND user_id = '".$sesssionUserId."'");
		}else{


			$res1 = "SELECT * FROM ".$_SESSION['rego']['cid']."_employees WHERE emp_id = '".$_REQUEST['empid']."'"; 
			$res = $dbc->query($res1);
			$row = $res->fetch_assoc();
			
			$dbc->query("INSERT INTO ".$_SESSION['rego']['cid']."_temp_employee_data (`user_id`, `emp_id`, `position`, `company`, `location`, `division`, `department`, `team`, `organization`, `groups`, `sid`, `title`, `firstname`, `lastname`, `th_name`, `en_name`, `birthdate`, `nationality`, `gender`, `maritial`, `religion`, `military_status`, `height`, `weight`, `bloodtype`, `drvlicense_nr`, `drvlicense_exp`, `idcard_nr`, `idcard_exp`, `tax_id`,`reg_address`, `sub_district`, `district`, `province`, `postnr`, `country`, `latitude`, `longitude`, `cur_address`, `personal_phone`, `work_phone`, `personal_email`, `work_email`, `username_option`, `username`,`joining_date`, `probation_date`, `emp_type`, `account_code`, `groups_work_data`, `time_reg`, `selfie`, `workFromHome`, `annual_leave`, `resign_date`, `emp_status`,`date_position`) VALUES ('".$sesssionUserId."', '".$row['emp_id']."', '".$row['position']."', '".$row['entity']."', '".$row['branch']."', '".$row['division']."', '".$row['department']."', '".$row['team']."', '".$row['organization']."', '".$row['groups']."', '".$row['sid']."', '".$row['title']."', '".$row['firstname']."', '".$row['lastname']."', '".$row['th_name']."', '".$row['en_name']."', '".$row['birthdate']."', '".$row['nationality']."', '".$row['gender']."', '".$row['maritial']."', '".$row['religion']."', '".$row['military_status']."', '".$row['height']."', '".$row['weight']."', '".$row['bloodtype']."', '".$row['drvlicense_nr']."', '".$row['drvlicense_exp']."', '".$row['idcard_nr']."', '".$row['idcard_exp']."', '".$row['tax_id']."', '".$row['reg_address']."', '".$row['sub_district']."', '".$row['district']."', '".$row['province']."', '".$row['postnr']."', '".$row['country']."', '".$row['latitude']."', '".$row['longitude']."', '".$row['cur_address']."', '".$row['personal_phone']."', '".$row['work_phone']."', '".$row['personal_email']."', '".$row['work_email']."', '".$row['username_option']."', '".$row['username']."', '".$row['joining_date']."', '".$row['probation_date']."', '".$row['emp_type']."', '".$row['account_code']."', '".$row['groups']."', '".$row['time_reg']."', '".$row['selfie']."', '".$row['workFromHome']."', '".$row['annual_leave']."','".$row['resign_date']."','".$row['emp_status']."','".$row['date_position']."') ");
			
		}
	}

	ob_clean();
	echo 'success';
?>