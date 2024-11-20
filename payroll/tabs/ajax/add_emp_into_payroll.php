<?
	if(session_id()==''){session_start(); ob_start();}
	include('../../../dbconnect/db_connect.php');
	include(DIR.'files/payroll_functions.php');

	$sbranches = str_replace(',', "','", implode(',', $_REQUEST['locations']));
	$sdivisions = str_replace(',', "','", implode(',', $_REQUEST['divisions']));
	$sdepartments = str_replace(',', "','", implode(',', $_REQUEST['departments']));
	$steams = str_replace(',', "','", implode(',', $_REQUEST['teams']));


	$where = "emp_status = '1'";
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

	

	/*echo '<pre>';
	print_r($data);
	echo '</pre>';*/

	foreach ($data as $key => $row) { 
		$chksq = "SELECT * FROM ".$_SESSION['rego']['cid']."_payroll_".$_SESSION['rego']['cur_year']." WHERE emp_id = '".$row['emp_id']."' AND month = '".$_SESSION['rego']['cur_month']."'";
		$checkEmpid = $dbc->query($chksq);

		if($checkEmpid->num_rows > 0){

			$sql = "UPDATE ".$_SESSION['rego']['cid']."_payroll_".$_SESSION['rego']['cur_year']." SET `entity`='".$row['entity']."', `branch`='".$row['branch']."', `division`='".$row['division']."', `department`='".$row['department']."', `team`='".$row['team']."', `position`='".$row['position']."' WHERE emp_id = '".$row['emp_id']."'";
			$dbc->query($sql);
		}else{

			$getSelmonPayrollData = getSelmonPayrollData($_SESSION['rego']['cur_month']);
			$countEmpthismonth = count($getSelmonPayrollData);
			if($countEmpthismonth == $_SESSION['rego']['max']){
				ob_clean();
				echo 'Max limit exceeded';
				exit;
			}

			$sql = "INSERT INTO ".$_SESSION['rego']['cid']."_payroll_".$_SESSION['rego']['cur_year']." (`emp_id`, `month`, `payroll_modal_id`, `emp_name_en`, `emp_name_th`, `entity`, `branch`, `division`, `department`, `team`, `position`) VALUES ('".$row['emp_id']."', '".$_SESSION['rego']['cur_month']."', '".$row['payroll_modal_value']."', '".$row['en_name']."', '".$row['th_name']."', '".$row['entity']."', '".$row['branch']."', '".$row['division']."', '".$row['department']."', '".$row['team']."', '".$row['position']."') ";
			$dbc->query($sql);
		}
	}


	//die();

	ob_clean();
	echo 'success';
	
?>