<?php
	
	if(session_id()==''){session_start();}
	ob_start();
	include('../../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	include(DIR.'files/payroll_functions.php');

	$empIds = $_REQUEST['empid'];

	$data = array();
	$res = $dbc->query("SELECT * FROM ".$_SESSION['rego']['cid']."_employees WHERE emp_id='".$empIds."' ");
	$row = $res->fetch_assoc();
	$data[] = $row;
	$data['joining_date'] = date('d-m-Y', strtotime($row['joining_date']));
	$data['resign_date'] = isset($row['resign_date']) ? date('d-m-Y', strtotime($row['resign_date'])) : '';

	if(date('m', strtotime($data['joining_date'])) == $_SESSION['rego']['curr_month']){
		$startDate = date('d-m-Y', strtotime($data['joining_date']));
	}else{
		$startDate = date('d-m-Y', strtotime(date('01-'.$_SESSION['rego']['curr_month'].'-Y')));
	}
	
	$monthEnddate = date('t-m-Y', strtotime($startDate));
	$enddate = isset($row['resign_date']) ? date('d-m-Y', strtotime($row['resign_date'])) : $monthEnddate;

	$date1 = date_create($startDate);
	$date2 = date_create($enddate);
	$diff = date_diff($date1,$date2);
	$getdiffbtdates = $diff->days;
	$nr_of_days = $getdiffbtdates + 1;
	$data['nr_of_days'] = $nr_of_days;

	//Total paid days...
	$calcbasisPaid = $_REQUEST['calcbasisPaid'];
	if($calcbasisPaid == 3){

		if(isset($row['resign_date'])){
			$getWorkingDaysNew = getWorkingDaysNew($startDate,$enddate);
			$noofpaidtotal = $getWorkingDaysNew;
		}else{
			$noofpaidtotal = $_REQUEST['PaidDays'];
		}
		

	}elseif($calcbasisPaid == 2){
		$noofpaidtotal = $nr_of_days;

	}elseif($calcbasisPaid == 1){

		$noofpaidtotal = $nr_of_days;
	}

	$data['total_paid_days'] = $noofpaidtotal;

	$GetAllowDeductdata = getEmployeeAllowances($row['emp_id'],$_SESSION['rego']['curr_month']);
	$GetAllowDeductfix = unserialize($GetAllowDeductdata[0]['fix_allow']);

	$data['curr_start_date'] = $GetAllowDeductdata[0]['start_date'];
	$data['curr_end_date'] = $GetAllowDeductdata[0]['end_date'];

	//this month salary
	$basicSalary = $GetAllowDeductdata[0]['salary'];
	$this_salary = (($basicSalary * $noofpaidtotal) / $_REQUEST['PaidDays']);
	$data['basicsalval'] = number_format($this_salary,2);
	$data['basicSalaryamt'] = $basicSalary;

	$data['emp_allowance'] = $GetAllowDeductfix;
	$getonlyapplyAllowDeduct = getonlyapplyAllowDeduct();
	$allow=array();
	foreach($getonlyapplyAllowDeduct as $d){
		$allow[$d['id']] = $d[$lang];
	}

	if(!empty($GetAllowDeductfix)){
		$myAllow=array();
		foreach ($GetAllowDeductfix as $key => $value) {
			$myAllow[$allow[$key]] = $value;
		}
	}

	$allowContent ='';
	/*$allowContent = '<tr>
						<th colspan="2" class="tal">'.$lng['Basic salary'].'</th>
						<td><span class="pl-2">'.$GetAllowDeductdata[0]['salary'].'</span></td>
						<th></th>
						<td></td>
						<td></td>
					</tr>';*/

	if(!empty($myAllow)){
		foreach ($myAllow as $key => $value) {
			$allowContent .= '<tr>
				<th colspan="2" class="tal">'.$key.'</th>
				<td><input type="text" value="'.$value.'"></td>
				<td><input type="text" name="allo['.$key.']" class="mninputs" readonly="readonly"></td>
				<th class="tal">'.$key.'</th>
				<td><input type="text" value="'.$value.'"></td>
				<td></td>
			</tr>';
		}
	}

	$data['emp_allowance'] = $allowContent;

	//echo '<pre>';
	//print_r($allowContent);
	//print_r($getonlyapplyAllowDeduct);
	//print_r($myAllow);
	//echo '</pre>';

	//die();
	
	ob_clean();
	echo json_encode($data);

?>