<?
	if(session_id()==''){session_start();}
	ob_start();

	include("../../dbconnect/db_connect.php");

	// create a function here which will get the empoyee status from the employee table on the basis of employee id 
	function getEmployeeStatus($cid,$empId){
		global $dbc;
		$data = array();
		$sql = "SELECT `emp_status` FROM `".$cid."_employees` WHERE emp_id = '".$empId."'";
		if($res = $dbc->query($sql)){
			if($row = $res->fetch_assoc()){
				$tmpStatus = $row['emp_status'];
			}
		}
		return $tmpStatus;
	}


	$data = array();
	$sql = "SELECT * FROM ".$cid."_employee_".$_REQUEST['field']." WHERE id = '".$_REQUEST['id']."'";
	if($res = $dbc->query($sql)){
		$data = $res->fetch_assoc();
		$empId = $data['emp_id'];
		$employeeStatus = getEmployeeStatus($cid,$empId);
		$data['employeeStatus'] = $employeeStatus; // employee status
		$data['employee_career_row_id'] = $_REQUEST['id']; // employee career table row id 
		$data['attachment'] = unserialize($data['attachments']);

		if($_REQUEST['field'] == 'career'){
			$data['fix_allows'] = unserialize($data['fix_allow']);
			$data['fix_deducts'] = unserialize($data['fix_deduct']);
		}
	}
	
	ob_clean();
	echo json_encode($data);