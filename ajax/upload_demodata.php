<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../dbconnect/db_connect.php");
	include(DIR.'files/functions.php');
	$err = false;

	$data = array();
	$career_data = array();
	$res = $dbx->query("SELECT * FROM demo_employees"); 
	while($row = $res->fetch_assoc()){
		$data[$row['emp_id']] = $row;
		$data[$row['emp_id']]['emp_id_editable'] = $row['emp_id'];
		$data[$row['emp_id']]['joining_date'] = '01-01-'.date('Y');
		$data[$row['emp_id']]['probation_date'] = date('d-m-Y', strtotime('+90 days', strtotime($start_date)));
		$data[$row['emp_id']]['idcard_exp'] = date('d-m-Y', strtotime('+3 years', strtotime(date('d-m-Y'))));
		$data[$row['emp_id']]['base_salary'] = 0;
		//$data[$row['emp_id']]['personal_email'] = $_SESSION['rego']['username'];
		//$data[$row['emp_id']]['groups'] = '1';

		//Employee career
		$career_data[$row['emp_id']]['month'] = '01';
		$career_data[$row['emp_id']]['emp_id'] = $row['emp_id'];
		$career_data[$row['emp_id']]['position'] = $row['position'];
		$career_data[$row['emp_id']]['start_date'] = date('Y').'-01-01';
		$career_data[$row['emp_id']]['salary'] = $row['base_salary'];
	}
	//var_dump($data); exit;

	$sql = "INSERT IGNORE INTO ".$cid."_employees (";
	foreach($data['DEMO-001'] as $k=>$v){
		$sql .= $k.",";
	}
	$sql = substr($sql,0,-1).") VALUES (";
	foreach($data as $key=>$val){
		foreach($val as $k=>$v){
			$sql .= "'".$dbc->real_escape_string($v)."',";
		}
		$sql = substr($sql,0,-1)."),(";
	}
	$sql = substr($sql,0,-2);
	//echo $sql;
	if($dbc->query($sql)){

		//insert into career table
		$sqlc = "INSERT IGNORE INTO ".$cid."_employee_career (";
		foreach($career_data['DEMO-001'] as $k=>$v){
			$sqlc .= $k.",";
		}
		$sqlc = substr($sqlc,0,-1).") VALUES (";
		foreach($career_data as $key=>$val){
			foreach($val as $k=>$v){
				$sqlc .= "'".$dbc->real_escape_string($v)."',";
			}
			$sqlc = substr($sqlc,0,-1)."),(";
		}
		$sqlc = substr($sqlc,0,-2);
		$dbc->query($sqlc);

		echo 'ok';

	}else{
		$err = true;
		echo mysqli_error($dbc);
	}
	//exit;
	
	$sql = "UPDATE ".$_SESSION['rego']['cid']."_sys_settings SET demo = 1";
	if($dbc->query($sql)){
		echo 'ok';
	}else{
		$err = true;//
		mysqli_error($dbc);
	}
	








