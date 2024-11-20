<?
	if(session_id()==''){session_start(); ob_start();}
	include('../../dbconnect/db_connect.php');

	$sbranches = $sdivisions = $sdepartments = $steams = '';
	if($_REQUEST['branch'] !=''){
		$sbranches = str_replace(',', "','", implode(',', $_REQUEST['branch']));
	}
	if($_REQUEST['division'] !=''){
		$sdivisions = str_replace(',', "','", implode(',', $_REQUEST['division']));
	}
	if($_REQUEST['department'] !=''){
		$sdepartments = str_replace(',', "','", implode(',', $_REQUEST['department']));
	}
	if($_REQUEST['team'] !=''){
		$steams = str_replace(',', "','", implode(',', $_REQUEST['team']));
	}

	$positionIn = str_replace(',', "','", implode(',', $_REQUEST['position']));

	$where = "position IN ('".$positionIn."')";
	if($sbranches != ''){ $where .= " AND branch IN ('".$sbranches."')"; }
	if($sdivisions != ''){ $where .= " AND division IN ('".$sdivisions."')"; }
	if($sdepartments != ''){ $where .= " AND department IN ('".$sdepartments."')"; }
	if($steams != ''){ $where .= " AND team IN ('".$steams."')"; }


	$data = array();
	$res1 = "SELECT * FROM ".$_SESSION['rego']['cid']."_employees WHERE ".$where." "; 
	$res = $dbc->query($res1);
	while($row = $res->fetch_assoc()){
		$data[] = $row;
	}

	//$dbc->query("TRUNCATE TABLE ".$_SESSION['rego']['cid']."_temp_employee_data");
	$dbc->query("DELETE FROM ".$_SESSION['rego']['cid']."_temp_employee_data WHERE user_id = '".$_SESSION['rego']['id']."'");


	foreach ($data as $key => $row) {

		$checkEmpid = $dbc->query("SELECT * FROM ".$_SESSION['rego']['cid']."_temp_employee_data WHERE emp_id = '".$row['emp_id']."' AND user_id = '".$_SESSION['rego']['id']."'");
		if($checkEmpid->num_rows > 0){

			$dbc->query("UPDATE ".$_SESSION['rego']['cid']."_temp_employee_data SET `position`='".$row['position']."', `company`='".$row['entity']."', `location`='".$row['branch']."', `division`='".$row['division']."', `department`='".$row['department']."', `team`='".$row['team']."', `organization`='".$row['organization']."', `groups`='".$row['groups']."', `sid`='".$row['sid']."', `title`='".$row['title']."', `firstname`='".$row['firstname']."', `lastname`='".$row['lastname']."', `th_name`='".$row['th_name']."', `en_name`='".$row['en_name']."', `birthdate`='".$row['birthdate']."', `nationality`='".$row['nationality']."', `gender`='".$row['gender']."' ,`maritial`='".$row['maritial']."',`religion`='".$row['religion']."',`military_status`='".$row['military_status']."' ,`height`='".$row['height']."' ,`weight`='".$row['weight']."' ,`bloodtype`='".$row['bloodtype']."' ,`drvlicense_nr`='".$row['drvlicense_nr']."' ,`drvlicense_exp`='".$row['drvlicense_exp']."',`idcard_nr`='".$row['idcard_nr']."',`idcard_exp`='".$row['idcard_exp']."',`tax_id`='".$row['tax_id']."'  WHERE emp_id = '".$row['emp_id']."'");
		}else{
			$dbc->query("INSERT INTO ".$_SESSION['rego']['cid']."_temp_employee_data (`user_id`, `emp_id`, `position`, `company`, `location`, `division`, `department`, `team`, `organization`, `groups`, `sid`, `title`, `firstname`, `lastname`, `th_name`, `en_name`, `birthdate`, `nationality`, `gender`, `maritial`, `religion`, `military_status`, `height`, `weight`, `bloodtype`, `drvlicense_nr`, `drvlicense_exp`, `idcard_nr`, `idcard_exp`, `tax_id`) VALUES ('".$_SESSION['rego']['id']."', '".$row['emp_id']."', '".$row['position']."', '".$row['entity']."', '".$row['branch']."', '".$row['division']."', '".$row['department']."', '".$row['team']."', '".$row['organization']."', '".$row['groups']."', '".$row['sid']."', '".$row['title']."', '".$row['firstname']."', '".$row['lastname']."', '".$row['th_name']."', '".$row['en_name']."', '".$row['birthdate']."', '".$row['nationality']."', '".$row['gender']."', '".$row['maritial']."', '".$row['religion']."', '".$row['military_status']."', '".$row['height']."', '".$row['weight']."', '".$row['bloodtype']."', '".$row['drvlicense_nr']."', '".$row['drvlicense_exp']."', '".$row['idcard_nr']."', '".$row['idcard_exp']."', '".$row['tax_id']."') ");
		}
	}

	ob_clean();
	echo 'success';

?>