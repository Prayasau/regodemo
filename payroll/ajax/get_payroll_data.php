<?php
	
	if(session_id()==''){session_start();}
	ob_start();
	include('../../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	include(DIR.'files/payroll_functions.php');
	include(DIR.'files/arrays_'.$lang.'.php');

	$getSSOEmpRateForMonths = getSSOEmpRateForMonths();


	$empid = $_REQUEST['empid'];
	$mid = $_REQUEST['mid'];
	$sessionpayrollDbase = $_SESSION['rego']['cid'].'_payroll_'.$_SESSION['rego']['cur_year'];
	$sessionpayrollDataTable = $_SESSION['rego']['cid'].'_payroll_data_'.$_SESSION['rego']['cur_year'];

	$data=array();
	
	$getMonthdata = $dbc->query("SELECT * FROM ".$sessionpayrollDbase." WHERE emp_id = '".$empid."' AND month = '".$_SESSION['rego']['cur_month']."' AND payroll_modal_id='".$mid."' ");
	if($getMonthdata->num_rows > 0){
		while ($row = $getMonthdata->fetch_assoc()) {
			$data[] = $row;
			$data['position'] = $positions[$row['position']][$lang];
			$data['department'] = $departments[$row['department']][$lang];
			$data['team'] = $teams[$row['team']][$lang];
			$data['calc_base'] = $row['calc_base'];
			$data['contract_type'] = $contract_type[$row['contract_type']];
			$data['calc_pvf'] = $row['calc_pvf'] ? 'Yes' : 'No';
			$data['calc_psf'] = $row['calc_psf'] ? 'Yes' : 'No';
			$data['calc_sso'] = $row['calc_sso'] ? 'Yes' : 'No';
			$data['calc_tax'] = $row['calc_tax'] ? 'Yes' : 'No';
			$data['calc_on_sd'] = $row['calc_on_sd'] ? 'Calc' : 'THB';
			$data['calc_on_pc'] = $row['calc_on_pc'] ? 'Calc' : 'THB';
			$data['calc_on_pf'] = $row['calc_on_pf'] ? 'Calc' : 'THB';
			$data['calc_on_ssf'] = $row['calc_on_ssf'] ? 'Calc' : 'THB';

			$data['tot_paid_days'] = $row['paid_days'];
			$data['paid_days_manual'] = $row['paid_days_manual'];
			$data['paid_days_curr'] = $row['paid_days_curr'];
			$data['paid_days_prev'] = $row['paid_days_prev'];
			$data['salary'] = $row['salary'];
			$data['day_daily_wage'] = $row['day_daily_wage'];
			$data['paid_hours'] = $row['paid_hours'];
			$data['rate_hr'] = $row['rate_hr'];


			$data['manual_feed_data'] = unserialize($row['manual_feed_data']);
			$data['manual_feed_total'] = unserialize($row['manual_feed_total']);
			
			$data['fix_allow_from_emp'] = unserialize($row['fix_allow_from_emp']);
			$data['fix_deduct_from_emp'] = unserialize($row['fix_deduct_from_emp']);
			
			$data['hrs_curr_wages'] = unserialize($row['hrs_curr_wages']);
			$data['hrs_prev_wages'] = unserialize($row['hrs_prev_wages']);
			$data['times_curr_wages'] = unserialize($row['times_curr_wages']);
			$data['incomeCalc_manual'] = unserialize($row['incomeCalc_manual']);
			$data['incomeCalc_total'] = unserialize($row['incomeCalc_total']);
			$data['incomeCalc_yesno'] = unserialize($row['incomeCalc_yesno']);
			$data['rate_wages'] = unserialize($row['rate_wages']);
			$data['thb_wages'] = unserialize($row['thb_wages']);

			//===== Get data from Payroll data table for current and upcomming month start ======//
			$pdata = $dbc->query("SELECT * FROM ".$sessionpayrollDataTable." WHERE `emp_ids`='".$row['emp_id']."' AND `months`='".$row['month']."' AND `payroll_modal_ids`='".$row['payroll_modal_id']."' ORDER BY case when allow_deduct_ids in (56) then -1 else allow_deduct_ids end, allow_deduct_ids ");
			if($pdata->num_rows > 0){
				while ($rowcc = $pdata->fetch_assoc()) {

					$sumAll = ($rowcc['jan'] + $rowcc['feb'] + $rowcc['mar'] + $rowcc['apr'] + $rowcc['may'] + $rowcc['jun'] + $rowcc['jul'] + $rowcc['aug'] + $rowcc['sep'] + $rowcc['oct'] + $rowcc['nov'] + $rowcc['dec']);
			
					if($sumAll > 0){
						if($rowcc['allow_deduct_ids'] == ''){
							if($rowcc['classifications'] == 2){
								$allow_deduct_ids='ssoemployer';
							}elseif($rowcc['classifications'] == 3){
								$allow_deduct_ids='pvfemployer';
							}elseif($rowcc['classifications'] == 4){
								$allow_deduct_ids='psfemployer';
							}
						}else{
							$allow_deduct_ids=$rowcc['allow_deduct_ids'];
						}

						$data['payroll_data'][$allow_deduct_ids] = $rowcc;
						$data['payroll_data_coulmn'][] = $rowcc;
					}
				}
			} 
			//===== Get data from Payroll data table for current and upcomming month end ======//

			//===== Get data from Payroll data table for Previous month start ======//
			/*echo "SELECT * FROM ".$sessionpayrollDataTable." WHERE `emp_ids`='".$row['emp_id']."' AND `months` < '".$row['month']."' AND `payroll_modal_ids`='".$row['payroll_modal_id']."' ORDER BY case when allow_deduct_ids in (56) then -1 else allow_deduct_ids end, allow_deduct_ids "; die();*/
			$predata = $dbc->query("SELECT * FROM ".$sessionpayrollDataTable." WHERE `emp_ids`='".$row['emp_id']."' AND `months` < '".$row['month']."' AND `payroll_modal_ids`='".$row['payroll_modal_id']."' ORDER BY case when allow_deduct_ids in (56) then -1 else allow_deduct_ids end, allow_deduct_ids ");
			if($predata->num_rows > 0){
				while ($rowpre = $predata->fetch_assoc()) {

					$sumAllpre = ($rowpre['jan'] + $rowpre['feb'] + $rowpre['mar'] + $rowpre['apr'] + $rowpre['may'] + $rowpre['jun'] + $rowpre['jul'] + $rowpre['aug'] + $rowpre['sep'] + $rowpre['oct'] + $rowpre['nov'] + $rowpre['dec']);
			
					if($sumAllpre > 0){
						if($rowpre['allow_deduct_ids'] == ''){
							if($rowpre['classifications'] == 2){
								$allow_deduct_ids='ssoemployer';
							}elseif($rowpre['classifications'] == 3){
								$allow_deduct_ids='pvfemployer';
							}elseif($rowpre['classifications'] == 4){
								$allow_deduct_ids='psfemployer';
							}
						}else{
							$allow_deduct_ids=$rowpre['allow_deduct_ids'];
						}

						$data['payroll_data_coulmn_prev'][$rowpre['months']][$allow_deduct_ids] = $rowpre;
					}
				}
			} 
			//===== Get data from Payroll data table for Previous month end ======//

		}

		$employee_info = getEmployeeInfo($_SESSION['rego']['cid'], $empid);

		$startmonthdate = date('Y-'.$_SESSION['rego']['curr_month'].'-01');
		$endmonthdate = date('Y-'.$_SESSION['rego']['curr_month'].'-t');

		$employeement_month = 'Full';
		if(strtotime($employee_info['joining_date']) < strtotime($startmonthdate)){
			if($employee_info['resign_date'] !=''){
				if(strtotime($employee_info['resign_date']) < strtotime($endmonthdate)){
					$employeement_month = 'Partial';
				}
			}
		}

		
		$get_employee_career = getEmployeeAllowances($empid,$_SESSION['rego']['curr_month']);
		$data['employee_career'] = $get_employee_career;
		$data['emp_career_allow_curr'] = unserialize($get_employee_career[0]['fix_allow']);
		$data['emp_career_allow_prev'] = isset($get_employee_career[1]['fix_allow']) ? unserialize($get_employee_career[1]['fix_allow']) : '';
		$data['emp_career_dedct_curr'] = unserialize($get_employee_career[0]['fix_deduct']);
		$data['emp_career_dedct_prev'] = isset($get_employee_career[1]['fix_deduct']) ? unserialize($get_employee_career[1]['fix_deduct']) : '';

		$data['salary_curr'] = $get_employee_career[0]['salary'];
		$data['salary_prev'] = isset($get_employee_career[1]['salary']) ? $get_employee_career[1]['salary'] : 0;

		$startDate_curr = date('d-m-Y', strtotime($get_employee_career[0]['start_date']));
		$data['startDate_curr'] = $startDate_curr;
		$startDate_prev = isset($get_employee_career[1]['start_date']) ? date('d-m-Y', strtotime($get_employee_career[1]['start_date'])) : '';
		$data['startDate_prev'] = $startDate_prev;
		$data['endDate_prev'] = isset($get_employee_career[1]['end_date']) ? date('d-m-Y', strtotime($get_employee_career[1]['end_date'])) : '';

		$data['joining_date'] = date('d-m-Y', strtotime($employee_info['joining_date']));
		$data['resign_date'] = '';
		$end_date1 = date('t-m-Y');
		if($employee_info['resign_date'] !=''){
			$data['resign_date'] = date('d-m-Y', strtotime($employee_info['resign_date']));
			$end_date1 = $data['resign_date'];
			//if resign date is this month
			/*$start_date = strtotime($startmonthdate);
			if(date('m', strtotime($data['joining_date'])) == $_SESSION['rego']['curr_month']){
				$start_date = strtotime($data['joining_date']);
			}
			if(date('m', strtotime($employee_info['resign_date'])) == $_SESSION['rego']['curr_month']){
  				$end_date = strtotime($employee_info['resign_date']);
  				$data['tot_paid_days'] = ($end_date - $start_date)/60/60/24;
			}else{
				$end_date = strtotime($endmonthdate);
				$data['tot_paid_days'] = ($end_date - $start_date)/60/60/24;
			}*/
		}else{
			/*$start_date = strtotime($startmonthdate);
			if(date('m', strtotime($data['joining_date'])) == $_SESSION['rego']['curr_month']){
				$start_date = strtotime($data['joining_date']);
			}
			$end_date = strtotime($endmonthdate);
			$data['tot_paid_days'] = ($end_date - $start_date)/60/60/24;*/
		}

		$data['employeement_month'] = $employeement_month;
		$data['employee_info'] = $employee_info;

		$workdays = $_REQUEST['PaidDays'];
		$tot_days_prev1 = getEmployeeWorkedDaysNew($startDate_curr, $end_date1, $workdays, $_REQUEST['nrdaysVal']);
		// echo '<pre>';
		// print_r($tot_days_prev1);
		// echo '</pre>';
		//die();
		if(!$tot_days_prev1['started'] && !$tot_days_prev1['resigned']){
			$data['days_curr'] = $tot_days_prev1['calendar_days'];
		}else{
			$data['days_curr'] = $tot_days_prev1['worked_days'];
		}

		$data['days_prev']='';
		if(isset($get_employee_career[1]['start_date'])){
			$tot_days_prev = getEmployeeWorkedDaysNew($startDate_prev, $data['endDate_prev'], $workdays, $_REQUEST['nrdaysVal']);
			if(!$tot_days_prev['started'] && !$tot_days_prev['resigned']){
				$data['days_prev'] = $tot_days_prev['calendar_days'];
			}else{
				$data['days_prev'] = $tot_days_prev['worked_days'];
			}
		}

		$data['ssoEmpRates'] = $getSSOEmpRateForMonths;


		/*** Payroll column for salary tab popup ****/
		/*$ecol= array();
		$columns= array();

		$sqlpd = "SELECT * FROM ".$sessionpayrollDataTable." WHERE emp_ids = '".$empid."' AND months = '".$_SESSION['rego']['cur_month']."' AND payroll_modal_ids='".$mid."' AND `classifications` IN (0,1)";
			if($respd = $dbc->query($sqlpd)){
				while($rowpd = $respd->fetch_assoc()){

					$columns[] = $rowpd;
				}
			}else{
				echo mysqli_error($dbc);
			}

			echo '<pre>';
			print_r($columns);
			echo '</pre>';
			die('ddd');

			if($columns){
				$nr = 1;
				$nrd = 1;
				foreach ($columns as $key => $rowpd) {
					if($rowpd['classifications'] == 0){

						

					}

					if($rowpd['jan']==0){$ecol['allow'][$nr] = $nr;} $nr++;
					
			
				}
			}

			//if($ecol){

				$eColsMdlA = '';
				foreach($ecol['allow'] as $v){$eColsMdlA .= $v.',';}
				$eColsMdlA = '['.substr($eColsMdlA,0,-1).']';

				$eColsMdlD = '';
				foreach($ecol['dedct'] as $v){$eColsMdlD .= $v.',';}
				$eColsMdlD = '['.substr($eColsMdlD,0,-1).']';

				$data['eColsMdlA'] = $eColsMdlA;
				$data['eColsMdlD'] = $eColsMdlD;

				
			//}*/
			
		/*** Payroll column for salary tab popup ****/

		// echo '<pre>';
		// 	print_r($data);
		// 	echo '</pre>';
		// 	die('ddd');

		ob_clean();
		echo json_encode($data);
	}else{
		ob_clean();
		echo 'error';
	}

?>