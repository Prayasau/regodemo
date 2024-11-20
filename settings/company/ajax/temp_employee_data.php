<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../../dbconnect/db_connect.php");

	// echo '<pre>';
	// print_r($_REQUEST);
	// print_r($organization);

	$EmployeesId = explode(',', $_REQUEST['empids']);

	$pos = $org = $grp = '';
	$com = $loc = $divi = $dept = $team = '';
	if($_REQUEST['positionss'] != ''){
		$pos = $_REQUEST['positionss'];
	}
	if($_REQUEST['organizationss'] != ''){
		$org = $_REQUEST['organizationss'];
		$allinfo = $organization[$org];
		$com = $allinfo['company'];
		$loc = $allinfo['locations'];
		$divi = $allinfo['divisions'];
		$dept = $allinfo['departments'];
		$team = $allinfo['teams'];
	}
	if($_REQUEST['groupss'] != ''){
		$grp = $_REQUEST['groupss'];
	}

	
	foreach($EmployeesId as $key => $value) {

		$checkEmpid = $dbc->query("SELECT * FROM ".$cid."_temp_employee_data WHERE emp_id = '".$value."' AND user_id = '".$_SESSION['rego']['id']."'");
		if($checkEmpid->num_rows > 0){

			$row = $checkEmpid->fetch_assoc();

			//if($_SESSION['rego']['id'] !=''){ $uid = "`user_id`='".$_SESSION['rego']['id']."',";}else{ $uid = ""; }
			if($pos !=''){ $poscon = "`position`='".$pos."',";}else{ $poscon = "`position`='".$row['position']."',"; }
			if($com !=''){ $comcon = "`company`='".$com."',";}else{ $comcon = ""; }
			if($loc !=''){ $loccon = "`location`='".$loc."',";}else{ $loccon = ""; }
			if($divi !=''){ $divicon = "`division`='".$divi."',";}else{ $divicon = ""; }
			if($dept !=''){ $deptcon = "`department`='".$dept."',";}else{ $deptcon = ""; }
			if($team !=''){ $teamcon = "`team`='".$team."',";}else{ $teamcon = ""; }
			if($org !=''){ $orgcon = "`organization`='".$org."',";}else{ $orgcon = ""; }
			if($grp !=''){ $grpcon = "`groups`='".$grp."'";}else{ $grpcon ="`groups`='".$row['groups']."'"; }

			$sql = "UPDATE ".$cid."_temp_employee_data SET ".$poscon." ".$comcon." ".$loccon." ".$divicon." ".$deptcon." ".$teamcon." ".$orgcon." ".$grpcon." WHERE emp_id = '".$value."'"; 
			$dbc->query($sql);

		}else{

			$sql = "INSERT INTO ".$cid."_temp_employee_data (`user_id`, `emp_id`, `position`, `company`, `location`, `division`, `department`, `team`, `organization`, `groups`) VALUES ('".$_SESSION['rego']['id']."', '".$value."', '".$pos."', '".$com."', '".$loc."', '".$divi."', '".$dept."', '".$team."', '".$org."', '".$grp."')";
			$dbc->query($sql);
		}
	}

		
	ob_clean();
	echo 'success';
	exit;
?>
