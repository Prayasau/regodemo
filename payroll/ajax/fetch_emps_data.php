<?php
	
	if(session_id()==''){session_start();}
	ob_start();
	include('../../dbconnect/db_connect.php');
	include(DIR.'files/payroll_functions.php');

	$empIds = $_REQUEST['empid'];
	$implodeids = implode(',', $empIds);
	$strempids = str_replace(',', "','", $implodeids);
	$sessionpayrollDbase = $_SESSION['rego']['cid'].'_payroll_'.$_SESSION['rego']['cur_year'];

	$getSysSettingsForPayroll = getSysSettingsForPayroll();
	$tab_default = unserialize($getSysSettingsForPayroll['tab_default']);


	$periods = $_SESSION['rego']['cur_year'].'_'.$_SESSION['rego']['cur_month'];
	$getPayrollPerMonthdata = getPayrollPerMonthdata($periods);
	$paid = unserialize($getPayrollPerMonthdata[0]['paid']);

	$paiddays = '';
	if($paid['paid_days'] == 1){
		$paiddays = $getPayrollPerMonthdata[0]['caldays'];
	}elseif($paid['paid_days'] == 2){
		$paiddays = $getPayrollPerMonthdata[0]['base30'];
	}else{
		$paiddays = $getPayrollPerMonthdata[0]['workdays'];
	}
	//echo $paiddays;

	$payrollparametersformonth = payrollparametersformonth();

	/*echo "<pre>";
	print_r($payrollparametersformonth);
	echo "</pre>";	die('sdsdsdsd');*/

	$data = array();
	$res = $dbc->query("SELECT * FROM ".$_SESSION['rego']['cid']."_employees WHERE emp_id IN('".$strempids."')");
	while($row = $res->fetch_assoc()){
		$data[] = $row;
	}

	$startmonthdate = date('Y-'.$_SESSION['rego']['curr_month'].'-01');
	$endmonthdate = date('Y-'.$_SESSION['rego']['curr_month'].'-t', strtotime($startmonthdate));

	if($data){

		$hrs_curr_wages_data = array();
		$hrs_prev_wages_data = array();
		$time_curr_wages = array();
		$rate_wages = array();
		$thb_wages = array();
		foreach($data as $key => $row) {

			$getpayrollinfo = getpayrollinfo($row['emp_id'],$_SESSION['rego']['cur_month']);
			$getAllowances = getEmployeeAllowances($row['emp_id'],$_SESSION['rego']['curr_month']);

			/*echo "<pre>";
			print_r($getAllowances);
			echo "</pre>";	die('sdsdsdsd');*/

			//for previous 
			$this_month1=0;
			$this_month2=0;
			$calendar_days_prev=0;
			$calendar_days_prev1=0;
			if(isset($getAllowances[1]['start_date'])){

				$start_date = $startmonthdate;
				if(date('m', strtotime($row['joining_date'])) == $_SESSION['rego']['curr_month']){
					$start_date = $row['joining_date'];
				}

				$end_date = '';
				if($getAllowances[1]['end_date'] !=''){
					if(date('m', strtotime($getAllowances[1]['end_date'])) == $_SESSION['rego']['curr_month']){
		  				$end_date = $getAllowances[1]['end_date'];
		  			}	
				}

				$workdays = $paiddays;
				$tot_days_prev = getEmployeeWorkedDaysNew($start_date, $end_date, $workdays, $paid['paid_days']);
				if(!$tot_days_prev['started'] && !$tot_days_prev['resigned']){
					$calendar_days_prev = $tot_days_prev['calendar_days'];
				}else{
					$calendar_days_prev = $tot_days_prev['worked_days'];
				}

				$salary = $getAllowances[1]['salary'];
				$this_month1 = ($salary / $paiddays) * $calendar_days_prev;
				$this_month1 = round($this_month1,2);
				$position = $getAllowances[1]['position'];
			}

			//for current 
			$firststart = date($_SESSION['rego']['cur_year'].'-'.$_SESSION['rego']['curr_month'].'-01');
			$start_date1 = isset($getAllowances[0]['start_date']) ? $getAllowances[0]['start_date'] : $firststart;
			$end_date1 = '';
			if($row['resign_date'] !=''){
				if(date('m', strtotime($row['resign_date'])) == $_SESSION['rego']['curr_month']){
	  				$end_date1 = $row['resign_date'];
	  			}	
			}

			$tot_days_prev1 = getEmployeeWorkedDaysNew($start_date1, $end_date1, $paiddays, $paid['paid_days']);
			//echo '<pre>';
			//print_r($tot_days_prev1);
			//echo '</pre>'; //die();
			if(!$tot_days_prev1['started'] && !$tot_days_prev1['resigned']){
				$calendar_days_prev1 = $tot_days_prev1['calendar_days'];
			}else{
				$calendar_days_prev1 = $tot_days_prev1['worked_days'];
			}

			$salary = $getAllowances[0]['salary'];
			$this_month2 = ($getAllowances[0]['salary'] / $paiddays) * $calendar_days_prev1;
			$this_month2 = round($this_month2,2);
			$position = $getAllowances[0]['position'];
			

			$tot_this_months = $this_month1 + $this_month2;
			$tot_work_days = $calendar_days_prev + $calendar_days_prev1;

			$fix_allow_from_emp = $getAllowances[0]['fix_allow'];
			$fix_deduct_from_emp = $getAllowances[0]['fix_deduct'];

			$fix_allow_unserial = unserialize($getAllowances[0]['fix_allow']);
			$fix_deduct_unserial = unserialize($getAllowances[0]['fix_deduct']);

			if($row['calc_on_sd']==1){$tsd='';}else{$tsd=$row['tax_standard_deduction'];}
			if($row['calc_on_pc']==1){$tpa='';}else{$tpa=$row['tax_personal_allowance'];}
			if($row['calc_on_pf']==1){$tpf='';}else{$tpf=$row['tax_allow_pvf'];}
			if($row['calc_on_ssf']==1){$tsf='';}else{$tsf=$row['tax_allow_sso'];}
			$total_other_tax_deductions = $row['emp_tax_deductions'];

			$condition = '';
			if($row['contract_type'] == 'day'){ //FOR DAY CONTRACT TYPE

				$paid_hours = decimalHours($tab_default['nrhrs']);
				$rate_hrs = ($salary / $paid_hours);
				$rate_hr = round($rate_hrs,2);

				foreach ($payrollparametersformonth as $keyss => $valuess) {

					if($valuess['man_att'] == 1 && $valuess['allowopt'] == 'hrs'){
						$ratewage = ($rate_hr * $valuess['multiplicator']); 
						$ratewages = round($ratewage,2);
						$rate_wages[$valuess['itemid']] = $ratewages;
					}

					if($valuess['man_att'] == 1 && $valuess['allowopt'] == 'hrs'){
						$thb_wages[$valuess['itemid']] = '';
					}
				}

				//$condition = "day_daily_wage='".$salary."', paid_days='', paid_hours='', rate_hr='".$rate_hr."', ";
				$condition = "day_daily_wage='".$salary."', rate_hr='".$rate_hr."', rate_wages='".serialize($rate_wages)."', thb_wages='".serialize($thb_wages)."', ";

			}else{ //FOR MONTHLY CONTRACT TYPE

				foreach ($payrollparametersformonth as $keyss => $valuess) {

					if($valuess['man_att'] == 1 && $valuess['allowopt'] == 'hrs'){
						$pp_income_base = $valuess['pp_income_base'];
						$tot_income_base = explode(',', $pp_income_base);
						$TotalIncome = 0;
						$TotalIncomessd = 0;
						foreach ($tot_income_base as $key1 => $value1) {
							$index = $value1;
							if(isset($fix_allow_unserial[$index])){
								$TotalIncome += $fix_allow_unserial[$index];
							}elseif(isset($fix_deduct_unserial[$index])){
								$TotalIncomessd += $fix_deduct_unserial[$index];
							}else{
								if($index == 56){
									$TotalIncome += $tot_this_months;
								}
							}
						}

						$nrhrs = $valuess['nrhrs'];
						$nrhrsval = explode(':',$nrhrs);
						$nrdayss = $valuess['nrdays'];
						if($nrdayss < 1){$nrdayss=1;}


						$currCalc = (($TotalIncome / $nrdayss / $nrhrsval[0]) * $valuess['multiplicator']); 
						$currCalcs = round($currCalc,2);
						$hrs_curr_wages_data[$valuess['itemid']] = $currCalcs;
						$hrs_prev_wages_data[$valuess['itemid']] = '';
					}

					if($valuess['man_att'] == 1 && $valuess['allowopt'] == 'times'){
						$thbunitval = $valuess['thbunit'];
						$time_curr_wages[$valuess['itemid']] = $thbunitval;
					}
				}

				$condition = "paid_days='".$tot_work_days."', hrs_curr_wages='".serialize($hrs_curr_wages_data)."', hrs_prev_wages='".serialize($hrs_prev_wages_data)."', times_curr_wages='".serialize($time_curr_wages)."', ";
				
				//$condition = "paid_days='".$tot_work_days."', ";
			}

			$sql = "UPDATE ".$sessionpayrollDbase." SET ".$condition." position='".$position."', basic_salary='".$salary."', salary='".$tot_this_months."', fix_allow_from_emp='".$fix_allow_from_emp."', fix_deduct_from_emp='".$fix_deduct_from_emp."', calc_tax='".$row['calc_tax']."', calc_sso='".$row['calc_sso']."', sso_by='".$row['sso_by']."', calc_pvf='".$row['calc_pvf']."', calc_psf='".$row['calc_psf']."', calc_method='".$row['calc_method']."', perc_thb_pvf='".$row['perc_thb_pvf']."', pvf_rate_emp='".$row['contri_emple_pvf']."', pvf_rate_com='".$row['contri_emplyer_pvf']."', perc_thb_psf='".$row['perc_thb_psf']."', psf_rate_emp='".$row['contri_emple_psf']."', psf_rate_com='".$row['contri_emplyer_psf']."', contract_type='".$row['contract_type']."', calc_base='".$row['calc_base']."', other_income='".$row['other_income']."', severance='".$row['severance']."', notice_payment='".$row['notice_payment']."', remaining_salary='".$row['remaining_salary']."', gov_house_banking='".$row['gov_house_banking']."', savings='".$row['savings']."', legal_execution='".$row['legal_execution']."', kor_yor_sor='".$row['kor_yor_sor']."', paid_leave='".$row['paid_leave']."', modify_tax='".$row['modify_tax']."', calc_on_sd='".$row['calc_on_sd']."', calc_on_pc='".$row['calc_on_pc']."', calc_on_pf='".$row['calc_on_pf']."', calc_on_ssf='".$row['calc_on_ssf']."', tax_standard_deduction='".$tsd."', tax_personal_allowance='".$tpa."', tax_allow_pvf='".$tpf."', tax_allow_sso='".$tsf."', total_other_tax_deductions='".$total_other_tax_deductions."', paid='C' WHERE emp_id = '".$row['emp_id']."' AND month = '".$_SESSION['rego']['cur_month']."' AND payroll_modal_id = '".$_REQUEST['mid']."' ";
			$upEmpdata = $dbc->query($sql);

		}
		
		ob_clean();
		echo 'success';
	}else{
		ob_clean();
		echo 'error';
	}
?>






























































