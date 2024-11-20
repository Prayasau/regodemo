<?php
	
	if(session_id()==''){session_start();}
	ob_start();
	include('../../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	include(DIR.'files/payroll_functions.php');

	$getSSOEmpRateForMonths = getSSOEmpRateForMonths();

	// echo "<pre>";
	// print_r($_REQUEST);
	// echo "</pre>";
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

	$d = $_SESSION['rego']['cur_year'].'-'.$_SESSION['rego']['curr_month'].'-01';
	$som = date('Y-m-d', strtotime($d));
	$eom = date('Y-m-t', strtotime($d));

	$sessionpayrollDbase = $_SESSION['rego']['cid'].'_payroll_'.$_SESSION['rego']['cur_year'];

	if(isset($_REQUEST['chooseMdl'][0])){

		$selectMdl = $dbc->query("SELECT * FROM ".$cid."_payroll_overview_".$_SESSION['rego']['cur_year']." WHERE month = '".$_REQUEST['month']."' AND payroll_model_id ='".$_REQUEST['chooseMdl'][0]."'");
		if($selectMdl->num_rows > 0){
			ob_clean();
			echo 'Model already exist for this month';

		}else{

			$sql = "INSERT INTO ".$cid."_payroll_overview_".$_SESSION['rego']['cur_year']." (`payroll_id`, `month`, `payroll_model_id`, `status`) VALUES ('".$_REQUEST['payroll_id']."', '".$_REQUEST['month']."', '".$_REQUEST['chooseMdl'][0]."','".$_REQUEST['status']."')";
			$res = $dbc->query($sql);


			//====== save payroll parameters for month =======//
			$resED = $dbc->query("SELECT * FROM ".$_SESSION['rego']['cid']."_sys_settings");
			$rowED = $resED->fetch_assoc();
			$tab_default = unserialize($rowED['tab_default']);
			$manualrates_default = unserialize($rowED['manualrates_default']);

			$mid = $_REQUEST['chooseMdl'][0];

			$mdl_data = array();
			$pay_mdl = $dbc->query("SELECT * FROM ".$_SESSION['rego']['cid']."_payroll_models WHERE id = '".$mid."'");
			if($pay_mdl->num_rows > 0){
				$mdl_data = $pay_mdl->fetch_assoc();
			}
			
			
			$getAttendAllowDeduct = getAttendAllowDeduct();
			$getEmployeeFixedCalc = getEmployeeFixedCalc();
			$getEmployeeAllowDeduct = getEmployeeAllowDeduct();


			//=== Fixed allowances & Deductions Employee Register Fixed
			if(isset($getAttendAllowDeduct) && is_array($getAttendAllowDeduct)){ 
				foreach($getAttendAllowDeduct as $row){

						$value = $row['id'];

						if(isset($manualrates_default['allowopt'][$value])){ $allowopt = implode(',',$manualrates_default['allowopt'][$value]); }else{ $allowopt = '';}
						if(isset($manualrates_default['calcOpt'][$value])){ $calcOpt = $manualrates_default['calcOpt'][$value]; }else{ $calcOpt = '';}
						if(isset($manualrates_default['nrhrs'][$value])){ $nrhrs = $manualrates_default['nrhrs'][$value]; }else{ $nrhrs = '';}
						if(isset($manualrates_default['income_base'][$value])){ $income_base = $manualrates_default['income_base'][$value]; }else{ $income_base = '';}
						if(isset($manualrates_default['thbunit'][$value])){ $thbunit = $manualrates_default['thbunit'][$value]; }else{ $thbunit = '';}
						if(isset($manualrates_default['unitarr'][$value])){ $unitarr = $manualrates_default['unitarr'][$value]; }else{ $unitarr = '';}
						if(isset($manualrates_default['nrdays'][$value])){ $nrdays = $manualrates_default['nrdays'][$value]; }else{ $nrdays = '';}
						if(isset($manualrates_default['multiplicator'][$value])){ $multiplicator = $manualrates_default['multiplicator'][$value]; }else{ $multiplicator = '';}
						
						$checkrowdf = $dbc->query("SELECT * FROM ".$cid."_payroll_parameters_".$_SESSION['rego']['cur_year']." WHERE month='".$_SESSION['rego']['cur_month']."' AND itemid='".$row['id']."' AND pr_modal_id='".$mid."' ");
						if($checkrowdf->num_rows > 0){

							$sql112 = "UPDATE ".$cid."_payroll_parameters_".$_SESSION['rego']['cur_year']." SET `pr_modal_id`='".$mid."', `month`='".$_SESSION['rego']['cur_month']."', `itemid`='".$row['id']."', `groups`='".$row['groups']."', `tax_base`='".$row['tax_base']."', `pnd`='".$row['pnd1']."', `sso`='".$row['sso']."', `pvfpsf`='".$row['pvf']."', `allowopt`='".$allowopt."', `calcOpt`='".$calcOpt."', multiplicator='".$multiplicator."', `nrdays`='".$nrdays."', `nrhrs`='".$nrhrs."', `income_base`='".$income_base."', `thbunit`='".$thbunit."', `unitarr`='".$unitarr."' WHERE month='".$_SESSION['rego']['cur_month']."' AND itemid='".$row['id']."' AND pr_modal_id='".$mid."'";
							$dbc->query($sql112);

						}else{

							$sql11 = "INSERT INTO ".$cid."_payroll_parameters_".$_SESSION['rego']['cur_year']." (`pr_modal_id`, `month`, `itemid`, `groups`, `tax_base`, `pnd`, `sso`, `pvfpsf`, `allowopt`, `calcOpt`, `multiplicator`, `nrdays`, `nrhrs`, `income_base`, `thbunit`, `unitarr`) VALUES ('".$mid."', '".$_SESSION['rego']['cur_month']."', '".$row['id']."', '".$row['groups']."', '".$row['tax_base']."', '".$row['pnd1']."', '".$row['sso']."', '".$row['pvf']."', '".$allowopt."', '".$calcOpt."', '".$multiplicator."', '".$nrdays."', '".$nrhrs."', '".$income_base."', '".$thbunit."', '".$unitarr."')";
							$dbc->query($sql11);
						}
				}
			}

			//=== Fixed Allowances & Deductions Emp. Register Man
			if(isset($getEmployeeAllowDeduct) && is_array($getEmployeeAllowDeduct)){ 
				foreach($getEmployeeAllowDeduct as $row){
					
					$checkrowdf = $dbc->query("SELECT * FROM ".$cid."_payroll_parameters_".$_SESSION['rego']['cur_year']." WHERE month='".$_SESSION['rego']['cur_month']."' AND itemid='".$row['id']."' AND pr_modal_id='".$mid."' ");
					if($checkrowdf->num_rows > 0){

						$sql112 = "UPDATE ".$cid."_payroll_parameters_".$_SESSION['rego']['cur_year']." SET `pr_modal_id`='".$mid."', `month`='".$_SESSION['rego']['cur_month']."', `itemid`='".$row['id']."', `groups`='".$row['groups']."', `tax_base`='".$row['tax_base']."', `pnd`='".$row['pnd1']."', `sso`='".$row['sso']."', `pvfpsf`='".$row['pvf']."' WHERE month='".$_SESSION['rego']['cur_month']."' AND itemid='".$row['id']."' AND pr_modal_id='".$mid."'";
						$dbc->query($sql112);
						
					}else{

						$sql11 = "INSERT INTO ".$cid."_payroll_parameters_".$_SESSION['rego']['cur_year']." (`pr_modal_id`, `month`, `itemid`, `groups`, `tax_base`, `pnd`, `sso`, `pvfpsf`) VALUES ('".$mid."', '".$_SESSION['rego']['cur_month']."', '".$row['id']."', '".$row['groups']."', '".$row['tax_base']."', '".$row['pnd1']."', '".$row['sso']."', '".$row['pvf']."')";
						$dbc->query($sql11);
					}
				}
			}


			//============== Save data in Payroll Month table ======================//
			$checkSqllpm = $dbc->query("SELECT * FROM ".$cid."_payroll_months WHERE month='".$_SESSION['rego']['cur_year'].'_'.$_SESSION['rego']['cur_month']."'");
			if($checkSqllpm->num_rows > 0){
				$pmdata = $checkSqllpm->fetch_assoc();

				$allowDeductEmpRegFixed = serialize($getEmployeeFixedCalc);		
				$allowDeductEmpRegManual = serialize($getEmployeeAllowDeduct);
				$sso_rates_for_month = serialize($getSSOEmpRateForMonths);
				
				$upsql = "UPDATE ".$cid."_payroll_months SET payroll_opt='".$mdl_data['payroll_opt']."', salary_split= '".$mdl_data['salary_split']."', paid='".$rowED['tab_default']."', allowDeductEmpRegFixed='".$allowDeductEmpRegFixed."', allowDeductEmpRegManual= '".$allowDeductEmpRegManual."', sso_rates_for_month='".$sso_rates_for_month."' WHERE month='".$_SESSION['rego']['cur_year'].'_'.$_SESSION['rego']['cur_month']."' ";
				$dbc->query($upsql);
			}
			//====== save payroll parameters for month =======//

			//====== Add emplyee in payroll =======//
			$sqlEmployee = $dbc->query("SELECT * FROM ".$cid."_employees WHERE payroll_modal_value='".$_REQUEST['chooseMdl'][0]."' AND joining_date <= '".$eom."' AND (resign_date >= '".$som."' AND resign_date <= '".$eom."' OR emp_status = '1') ORDER by resign_date DESC, emp_id ASC ");
			if($sqlEmployee->num_rows > 0){
				while ($empdata = $sqlEmployee->fetch_assoc()) {
					$dataEmp[] = $empdata;
				}
			}


			if($dataEmp){

				foreach($dataEmp as $k=>$v){

					$workdays = $paiddays;
					$tmp = getEmployeeWorkedDaysNew($v['joining_date'], $v['resign_date'], $workdays, $paid['paid_days']);
					if(!$tmp['started'] && !$tmp['resigned']){
						$calendar_days = $tmp['calendar_days'];
					}else{
						$calendar_days = $tmp['worked_days'];
					}

					$getMonthdata = $dbc->query("SELECT * FROM ".$sessionpayrollDbase." WHERE emp_id = '".$v['emp_id']."' AND month = '".$_SESSION['rego']['cur_month']."' ");
					if($getMonthdata->num_rows > 0){

						//nothing to do

					}else{

						$getSelmonPayrollData = getSelmonPayrollData($_SESSION['rego']['cur_month']);
						$countEmpthismonth = count($getSelmonPayrollData);
						if($countEmpthismonth == $_SESSION['rego']['max']){
							ob_clean();
							echo 'Max limit exceeded';
							exit;
						}

						$addEmpdata = "INSERT INTO ".$sessionpayrollDbase." (emp_id, month, payroll_modal_id, entity, branch, division, department, team, position, emp_name_th, emp_name_en, paid_days, paid) VALUES ('".$v['emp_id']."', '".$_SESSION['rego']['cur_month']."', '".$v['payroll_modal_value']."', '".$v['entity']."', '".$v['branch']."', '".$v['division']."', '".$v['department']."', '".$v['team']."', '".$v['position']."', '".$v['th_name']."', '".$v['en_name']."', '', 'C')";
						 $dbc->query($addEmpdata);
					}
				}				
			}


			//====== Add emplyee in payroll =======//


			ob_clean();
			$datares['res'] = 'success';
			$datares['mdl'] = $_REQUEST['chooseMdl'][0];
			echo json_encode($datares);
		}

	}else{
		ob_clean();
		echo 'Please choose model';
	}
?>
