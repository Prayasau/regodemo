<?php

	if(session_id()==''){session_start(); ob_start();}
	include('../../dbconnect/db_connect.php'); 
	include(DIR.'files/functions.php'); 
	include(DIR.'files/payroll_functions.php');

	$getAllowDeductAllLinkedInfo = getAllowDeductAllLinkedInfo();
	$getSSOEmpRateForMonths = getSSOEmpRateForMonths();
	$total_sso_allow=0;
	foreach ($getSSOEmpRateForMonths as $key11 => $value11) {
		$total_sso_allow += $value11['max'];
	}

	function getAllowDeductTotals($mid,$empid){
		global $dbc;
		$data = array();
		$getdata = $dbc->query("SELECT * FROM ".$_SESSION['rego']['cid']."_payroll_data_".$_SESSION['rego']['cur_year']." WHERE months='".$_SESSION['rego']['cur_month']."' AND payroll_modal_ids='".$mid."' AND emp_ids='".$empid."'");
		if($getdata->num_rows > 0){
			while ( $row = $getdata->fetch_assoc()) {
				$data[] = $row;
			}
		}
		return $data;
	}


	function saveAllowDeductdata($mid,$empid,$itemid,$v1,$extraValue){
		global $dbc;
		$getAllowandDeductInfo = getAllowandDeductInfo();
		$months_column = array(1=>"jan", 2=>"feb", 3=>"mar", 4=>"apr", 5=>"may", 6=>"jun", 7=>"jul", 8=>"aug", 9=>"sep", 10=>"oct", 11=>"nov", 12=>"dec");


		//========== This is special condition for SSO, PVF & PSF EMPLOYER =========//
		if($itemid == 'ssoemployer' || $itemid == 'pvfemployer' || $itemid == 'psfemployer'){ 
			$classificationsID = '';
			if($itemid == 'ssoemployer'){ 
				$classificationsID=2;
			}elseif($itemid == 'pvfemployer'){ 
				$classificationsID=3;
			}elseif($itemid == 'psfemployer'){ 
				$classificationsID=4;
			}

			$getPayrollDataee = $dbc->query("SELECT * FROM ".$_SESSION['rego']['cid']."_payroll_data_".$_SESSION['rego']['cur_year']." WHERE months='".$_SESSION['rego']['cur_month']."' AND payroll_modal_ids='".$mid."' AND emp_ids='".$empid."' AND classifications='".$classificationsID."'");
			if($getPayrollDataee->num_rows > 0){

				/*$conditions='';
				for ($i=1; $i <=12 ; $i++) { $condition .= " ".$months_column[$i]."='".$v1."', "; }
				$updsqlee="UPDATE ".$_SESSION['rego']['cid']."_payroll_data_".$_SESSION['rego']['cur_year']." SET `classifications`='2', `groups`='', `tax_base`='', `pnd`='', `sso`='', `hrs`='', `pvf`='', `psf`='', `curr_calc`='".$v1."', `prev_calc`='0.00', `curr_month`='".$v1."', ".$conditions." `datetime`='".date('Y-m-d H:i:s')."' WHERE months='".$_SESSION['rego']['cur_month']."' AND payroll_modal_ids='".$mid."' AND emp_ids='".$empid."' ";
				$dbc->query($updsqlee);*/

			}else{

				$conditions='';
				for ($i=1; $i <=12 ; $i++) { $conditions .= " '".$v1."', "; }
				$ipdsql="INSERT INTO ".$_SESSION['rego']['cid']."_payroll_data_".$_SESSION['rego']['cur_year']." (`months`, `payroll_modal_ids`, `emp_ids`, `allow_deduct_ids`, `classifications`, `groups`, `tax_base`, `pnd`, `sso`, `hrs`, `pvf`, `psf`, `curr_calc`, `prev_calc`, `curr_month`, `jan`, `feb`, `mar`, `apr`, `may`, `jun`, `jul`, `aug`, `sep`, `oct`, `nov`, `dec`, `datetime`) VALUES ('".$_SESSION['rego']['cur_month']."', '".$mid."', '".$empid."', '', '".$classificationsID."', '', '', '', '', '', '', '', '".$v1."', '0.00', '".$v1."', ".$conditions." '".date('Y-m-d H:i:s')."')";
				$dbc->query($ipdsql);
			}

		}else{ //========For allowances and Deductions ==========//

			$k1 = $itemid;
			$getPayrollData = $dbc->query("SELECT * FROM ".$_SESSION['rego']['cid']."_payroll_data_".$_SESSION['rego']['cur_year']." WHERE months='".$_SESSION['rego']['cur_month']."' AND payroll_modal_ids='".$mid."' AND emp_ids='".$empid."' AND allow_deduct_ids='".$itemid."'");
			if($getPayrollData->num_rows > 0){

				//update
				if($k1 != 57 || $k1 != 28){ //skip update for sso employee & sso by company
					$condition='';
					if($getAllowandDeductInfo[$k1]['tax_base'] == 'fixpro' || $k1 == 57 || $k1 == 58 || $k1 == 59 || $k1 == 60 || $k1 == 27 || $k1 == 28){

						if($k1 == 60 || $k1 == 27 || $k1 == 28){ //======== for Tax and Tax/sso by company ========//
							for ($i=1; $i <=12 ; $i++) { 
								if($i == $_SESSION['rego']['cur_month']){
									$condition .= " `".$months_column[$i]."`='".$v1."', ";
								}else{
									
									if($i > $_SESSION['rego']['cur_month']){
										$condition .= " `".$months_column[$i]."`='".$extraValue."', ";
									}
								}
							}
						}else{
							for ($i=1; $i <=12 ; $i++) { 
								$condition .= " `".$months_column[$i]."`='".$v1."', ";
							}
						}
						
					}else{
						for ($i=1; $i <=12 ; $i++) { 
							if($i == $_SESSION['rego']['cur_month']){
								$condition .= " `".$months_column[$i]."`='".$v1."', ";
							}else{
								$condition .= " `".$months_column[$i]."`='0.00', ";
							}
						}
					}

					$updsql="UPDATE ".$_SESSION['rego']['cid']."_payroll_data_".$_SESSION['rego']['cur_year']." SET `classifications`='".$getAllowandDeductInfo[$k1]['classification']."', `groups`='".$getAllowandDeductInfo[$k1]['group']."', `tax_base`='".$getAllowandDeductInfo[$k1]['tax_base']."', `pnd`='".$getAllowandDeductInfo[$k1]['pnd1']."', `sso`='".$getAllowandDeductInfo[$k1]['sso']."', `hrs`='".$getAllowandDeductInfo[$k1]['hour_daily_rate']."', `pvf`='".$getAllowandDeductInfo[$k1]['pvf']."', `psf`='".$getAllowandDeductInfo[$k1]['psf']."', `curr_calc`='".$v1."', `prev_calc`='0.00', `curr_month`='".$v1."', ".$condition." `datetime`='".date('Y-m-d H:i:s')."' WHERE months='".$_SESSION['rego']['cur_month']."' AND payroll_modal_ids='".$mid."' AND emp_ids='".$empid."' AND allow_deduct_ids='".$itemid."'";
					$dbc->query($updsql);
				}
				
			}else{ //====== INSERT DATA ======//

				$condition='';
				if($getAllowandDeductInfo[$k1]['tax_base'] == 'fixpro' || $k1 == 57 || $k1 == 58 || $k1 == 59 || $k1 == 60 || $k1 == 27 || $k1 == 28){
					
					if($k1 == 60 || $k1 == 27 || $k1 == 28){ //======== for Tax and Tax/sso by company ========//
						for ($i=1; $i <=12 ; $i++) { 
							if($i == $_SESSION['rego']['cur_month']){
								$condition .= " '".$v1."', ";
							}else{
								if($i > $_SESSION['rego']['cur_month']){
									$condition .= " '".$extraValue."', ";
								}else{
									$condition .= " '0.00', ";
								}
							}
						}
					}else{
						for ($i=1; $i <=12 ; $i++) { 
							$condition .= " '".$v1."', ";
						}
					}

				}else{ //======== for other tax base ========//
					for ($i=1; $i <=12 ; $i++) { 
						if($i == $_SESSION['rego']['cur_month']){
							$condition .= " '".$v1."',";
						}else{
							$condition .= " '0.00',";
						}
					}
				}

				$pdsql="INSERT INTO ".$_SESSION['rego']['cid']."_payroll_data_".$_SESSION['rego']['cur_year']." (`months`, `payroll_modal_ids`, `emp_ids`, `allow_deduct_ids`, `classifications`, `groups`, `tax_base`, `pnd`, `sso`, `hrs`, `pvf`, `psf`, `curr_calc`, `prev_calc`, `curr_month`, `jan`, `feb`, `mar`, `apr`, `may`, `jun`, `jul`, `aug`, `sep`, `oct`, `nov`, `dec`, `datetime`) VALUES ('".$_SESSION['rego']['cur_month']."', '".$mid."', '".$empid."', '".$itemid."', '".$getAllowandDeductInfo[$k1]['classification']."', '".$getAllowandDeductInfo[$k1]['group']."', '".$getAllowandDeductInfo[$k1]['tax_base']."', '".$getAllowandDeductInfo[$k1]['pnd1']."', '".$getAllowandDeductInfo[$k1]['sso']."', '".$getAllowandDeductInfo[$k1]['hour_daily_rate']."', '".$getAllowandDeductInfo[$k1]['pvf']."', '".$getAllowandDeductInfo[$k1]['psf']."', '".$v1."', '0.00', '".$v1."', ".$condition." '".date('Y-m-d H:i:s')."')"; 
				$dbc->query($pdsql);
			}
		}

		return;
	}

	//echo $total_sso_allow;
	//echo '<br>';
	/*$getDefaultSysSettings = getDefaultSysSettings();
	$periods_defaults = unserialize($getDefaultSysSettings['periods_defaults']);*/

	$SSOnewcal = getSSOEmpRate($cid);
	$sso_rate_emp = $SSOnewcal['rate']/100;
	$max_sso = $SSOnewcal['max'];
	$min_sso = $SSOnewcal['min'];

	$sso_rate_com = $SSOnewcal['crate']/100;
	$max_sso_com = $SSOnewcal['cmax'];
	$min_sso_com = $SSOnewcal['cmin'];

	$getAllowandDeductInfo = getAllowandDeductInfo();
	$cur_month = $_SESSION['rego']['cur_month'];
	$remaining_months = 12 - (int)$_SESSION['rego']['cur_month'] + 1;
	$remaining_months_without_curr = 12 - (int)$_SESSION['rego']['cur_month'];

	$empid = $_REQUEST['empid'];
	$implodeids = implode("','", $empid);

	$sessionpayrollDbase = $_SESSION['rego']['cid'].'_payroll_'.$_SESSION['rego']['cur_year'];
	$getpayroll = $dbc->query("SELECT * FROM ".$sessionpayrollDbase." WHERE emp_id IN ('".$implodeids."') AND month = '".$_SESSION['rego']['cur_month']."' AND payroll_modal_id='".$_REQUEST['mid']."' ");
	if($getpayroll->num_rows > 0){
		while($row = $getpayroll->fetch_assoc()){

			$empinfo = getEmployeeInfo($cid, $row['emp_id']);
			$manual_feed_total = unserialize($row['manual_feed_total']);

			$totals_array = array();
			$totals_array_deduction = array();
			$full_year_total = array();
			$key = $row['emp_id'];

			foreach($manual_feed_total as $k1 => $v1) {

				//===== save data for allowance/deduction
				saveAllowDeductdata($_REQUEST['mid'],$key,$k1,$v1,0);	

				//=== Total earnings ===//
				if($getAllowandDeductInfo[$k1]['earnings'] == 1){
					$totals_array[$key]['earnings'][] = $v1;
				}

				//=== Total deductions ===//
				if($getAllowandDeductInfo[$k1]['deductions'] == 1){
					$totals_array[$key]['deductions'][] = $v1;
				}

				//=== Total Tax income ===//
				if($getAllowandDeductInfo[$k1]['tax_income'] == 1){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['tax_income'][] = $v1;
					}else{
						$totals_array[$key]['tax_income'][] = $v1;
					}
				}
			}


			$fix_allow = unserialize($row['fix_allow_from_emp']);
			$fix_deduct = unserialize($row['fix_deduct_from_emp']);

			foreach($fix_allow as $k1 => $v1) {

				//===== save data for allowance/deduction
				saveAllowDeductdata($_REQUEST['mid'],$key,$k1,$v1,0);	

				//=== Total earnings ===//
				if($getAllowandDeductInfo[$k1]['earnings'] == 1){
					$totals_array[$key]['earnings'][] = $v1;
				}

				//=== Total deductions ===//
				if($getAllowandDeductInfo[$k1]['deductions'] == 1){
					$totals_array[$key]['deductions'][] = $v1;
				}

				//=== Total Tax income ===//
				if($getAllowandDeductInfo[$k1]['tax_income'] == 1){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['tax_income'][] = $v1;
					}else{
						$totals_array[$key]['tax_income'][] = $v1;
					}
				}
			}

			foreach($fix_deduct as $k1 => $v1) {

				//===== save data for allowance/deduction
				saveAllowDeductdata($_REQUEST['mid'],$key,$k1,$v1,0);

				//=== Total earnings ===//
				if($getAllowandDeductInfo[$k1]['earnings'] == 1){
					$totals_array_deduction[$key]['earnings'][] = $v1;
				}

				//=== Total deductions ===//
				if($getAllowandDeductInfo[$k1]['deductions'] == 1){
					$totals_array_deduction[$key]['deductions'][] = $v1;
				}

				//=== Total Tax income ===//
				if($getAllowandDeductInfo[$k1]['tax_income'] == 1){
					$totals_array_deduction[$key]['tax_income'][] = $v1;
				}
			}


			if($row['contract_type'] == 'day'){ 
				$employeeAllowadedyctArr = array(56=>$row['mf_salary']);
			}else{
				$employeeAllowadedyctArr = array(56=>$row['salary']);
			}
			
			$fixedforMonth = getPayrollfixedAlloDeductMonth($_SESSION['rego']['cur_year'].'_'.$_SESSION['rego']['cur_month']);
			foreach($fixedforMonth as $k1 => $v1) {

				if($k1 == 56){ //for basic salary only

					//===== save data for allowance/deduction
					saveAllowDeductdata($_REQUEST['mid'],$key,$k1,$employeeAllowadedyctArr[$k1],0);

					//=== Total earnings ===//
					if($getAllowandDeductInfo[$k1]['earnings'] == 1){
						$totals_array[$key]['earnings'][] = $employeeAllowadedyctArr[$k1];
					}

					//=== Total deductions ===//
					if($getAllowandDeductInfo[$k1]['deductions'] == 1){
						$totals_array[$key]['deductions'][] = $employeeAllowadedyctArr[$k1];
					}

					//=== Total Tax income ===//
					if($getAllowandDeductInfo[$k1]['tax_income'] == 1){
						if($getAllowandDeductInfo[$k1]['classification'] == 1){
							$totals_array_deduction[$key]['tax_income'][] = $employeeAllowadedyctArr[$k1];
						}else{
							$totals_array[$key]['tax_income'][] = $employeeAllowadedyctArr[$k1];
						}
					}
				}
			}

			//========== Total of all PND, SSO and tax base =====//
			$totalsofothers = getAllowDeductTotals($_REQUEST['mid'],$key);
			foreach ($totalsofothers as $koth => $voth) {

				//=== Total PND1 ===//
				if($voth['pnd'] == 1){
					if($voth['classifications'] == 1){
						$totals_array_deduction[$key]['pnd1'][] = $voth['curr_month'];
					}else{
						$totals_array[$key]['pnd1'][] = $voth['curr_month'];
					}
				}

				//=== Total SSO ===//
				if($voth['sso'] == 1){
					if($voth['classifications'] == 1){
						$totals_array_deduction[$key]['sso'][] = $voth['curr_month'];
					}else{
						$totals_array[$key]['sso'][] = $voth['curr_month'];
					}
				}

				//=== Total PVF ===//
				if($voth['pvf'] == 1){
					if($voth['classifications'] == 1){
						$totals_array_deduction[$key]['pvf'][] = $voth['curr_month'];
					}else{
						$totals_array[$key]['pvf'][] = $voth['curr_month'];
					}
				}

				//=== Total PSF ===//
				if($voth['psf'] == 1){
					if($voth['classifications'] == 1){
						$totals_array_deduction[$key]['psf'][] = $voth['curr_month'];
					}else{
						$totals_array[$key]['psf'][] = $voth['curr_month'];
					}
				}

				//=== Tax base (fixpro) ===//
				if($voth['tax_base'] == 'fixpro'){
					if($voth['classifications'] == 1){
						$totals_array_deduction[$key]['fixpro'][] = $voth['curr_month'];
					}else{
						$totals_array[$key]['fixpro'][] = $voth['curr_month'];
					}
				}

				//=== Tax base (fix) ===//
				if($voth['tax_base'] == 'fix'){
					if($voth['classifications'] == 1){
						$totals_array_deduction[$key]['fix'][] = $voth['curr_month'];
					}else{
						$totals_array[$key]['fix'][] = $voth['curr_month'];
					}
				}

				//=== Tax base (var) ===//
				if($voth['tax_base'] == 'var'){
					if($voth['classifications'] == 1){
						$totals_array_deduction[$key]['var'][] = $voth['curr_month'];
					}else{
						$totals_array[$key]['var'][] = $voth['curr_month'];
					}
				}

				//=== Tax base (nontax) ===//
				if($voth['tax_base'] == 'nontax'){
					if($voth['classifications'] == 1){
						$totals_array_deduction[$key]['nontax'][] = $voth['curr_month'];
					}else{
						$totals_array[$key]['nontax'][] = $voth['curr_month'];
					}
				}

				//=== Tax base (taxby) ===//
				if($voth['tax_base'] == 'taxby'){
					if($voth['classifications'] == 1){
						$totals_array_deduction[$key]['taxby'][] = $voth['curr_month'];
					}else{
						$totals_array[$key]['taxby'][] = $voth['curr_month'];
					}
				}

				//=== Tax base (ssoby) ===//
				if($voth['tax_base'] == 'ssoby'){
					if($voth['classifications'] == 1){
						$totals_array_deduction[$key]['ssoby'][] = $voth['curr_month'];
					}else{
						$totals_array[$key]['ssoby'][] = $voth['curr_month'];
					}
				}

			}


			/*echo '<pre>';
			//print_r($fixedforMonth);
			print_r($totals_array);
			print_r($totals_array_deduction);
			echo '</pre>';
			die('sdsdsdsd');*/



			/*$total_earnings = isset($totals_array[$key]['earnings']) ? array_sum($totals_array[$key]['earnings']) : 0;
			$total_deductions0 = isset($totals_array[$key]['deductions']) ? array_sum($totals_array[$key]['deductions']) : 0;
			$total_deductions1 = isset($totals_array_deduction[$key]['deductions']) ? array_sum($totals_array_deduction[$key]['deductions']) : 0;
			$total_deductions = $total_deductions0 + $total_deductions1;*/

			//tot_pnd1
			$total_pnd1a = isset($totals_array[$key]['pnd1']) ? array_sum($totals_array[$key]['pnd1']) : 0;
			$total_pnd1d = isset($totals_array_deduction[$key]['pnd1']) ? array_sum($totals_array_deduction[$key]['pnd1']) : 0;
			$total_pnd1 = $total_pnd1a - $total_pnd1d;

			//tot_sso
			$total_ssoa = isset($totals_array[$key]['sso']) ? array_sum($totals_array[$key]['sso']) : 0;
			$total_ssod = isset($totals_array_deduction[$key]['sso']) ? array_sum($totals_array_deduction[$key]['sso']) : 0;
			$total_sso = $total_ssoa - $total_ssod;

			//tot_pvf
			$total_pvfa = isset($totals_array[$key]['pvf']) ? array_sum($totals_array[$key]['pvf']) : 0;
			$total_pvfd = isset($totals_array_deduction[$key]['pvf']) ? array_sum($totals_array_deduction[$key]['pvf']) : 0;
			$total_pvf = $total_pvfa - $total_pvfd;
			
			//tot_psf
			$total_psfa = isset($totals_array[$key]['psf']) ? array_sum($totals_array[$key]['psf']) : 0;
			$total_psfd = isset($totals_array_deduction[$key]['psf']) ? array_sum($totals_array_deduction[$key]['psf']) : 0;
			$total_psf = $total_psfa - $total_psfd;
			
			//tot_tax_income
			$total_tax_income0 = isset($totals_array[$key]['tax_income']) ? array_sum($totals_array[$key]['tax_income']) : 0;
			$total_tax_income1 = isset($totals_array_deduction[$key]['tax_income']) ? array_sum($totals_array_deduction[$key]['tax_income']) : 0;
			$total_tax_income = $total_tax_income0 - $total_tax_income1;

			//tot_tax_fixpro
			$total_tax_fixpro0 = isset($totals_array[$key]['fixpro']) ? array_sum($totals_array[$key]['fixpro']) : 0;
			$total_tax_fixpro1 = isset($totals_array_deduction[$key]['fixpro']) ? array_sum($totals_array_deduction[$key]['fixpro']) : 0;
			$total_tax_fixpro = $total_tax_fixpro0 - $total_tax_fixpro1;
			
			
			//tot_tax_fix
			$total_tax_fix0 = isset($totals_array[$key]['fix']) ? array_sum($totals_array[$key]['fix']) : 0;
			$total_tax_fix1 = isset($totals_array_deduction[$key]['fix']) ? array_sum($totals_array_deduction[$key]['fix']) : 0;
			$total_tax_fix = $total_tax_fix0 - $total_tax_fix1;

			//tot_tax_var
			$total_tax_var0 = isset($totals_array[$key]['var']) ? array_sum($totals_array[$key]['var']) : 0;
			$total_tax_var1 = isset($totals_array_deduction[$key]['var']) ? array_sum($totals_array_deduction[$key]['var']) : 0;
			$total_tax_var = $total_tax_var0 - $total_tax_var1;

			//tot_tax_nontax
			$total_tax_nontax0 = isset($totals_array[$key]['nontax']) ? array_sum($totals_array[$key]['nontax']) : 0;
			$total_tax_nontax1 = isset($totals_array_deduction[$key]['nontax']) ? array_sum($totals_array_deduction[$key]['nontax']) : 0;
			$total_tax_nontax = $total_tax_nontax0 + $total_tax_nontax1;

			//ssobycom_tax
			$total_tax_ssoby0 = isset($totals_array[$key]['ssoby']) ? array_sum($totals_array[$key]['ssoby']) : 0;
			$total_tax_ssoby1 = isset($totals_array_deduction[$key]['ssoby']) ? array_sum($totals_array_deduction[$key]['ssoby']) : 0;
			$total_tax_ssoby = $total_tax_ssoby0 + $total_tax_ssoby1;

			//taxbycom_tax
			$total_tax_taxby0 = isset($totals_array[$key]['taxby']) ? array_sum($totals_array[$key]['taxby']) : 0;
			$total_tax_taxby1 = isset($totals_array_deduction[$key]['taxby']) ? array_sum($totals_array_deduction[$key]['taxby']) : 0;
			$total_tax_taxby = $total_tax_taxby0 + $total_tax_taxby1;



			$total_of_alltax = $total_tax_fixpro + $total_tax_fix + $total_tax_var;

			

			
			//========== PVF/PSF calculation ================//
			$psf_emp = 0;
			$psf_com = 0;
			if($row['calc_psf'] == 1){
				if($row['perc_thb_psf'] == 2){
					$psf_emp = ($total_psf * $row['psf_rate_emp']);
					$psf_com = ($total_psf * $row['psf_rate_com']);
				}else{
					$psf_emp = ($total_psf * $row['psf_rate_emp'])/100;
					$psf_com = ($total_psf * $row['psf_rate_com'])/100;
				}
			}else{
				$total_psf = 0;
			}

			$psf_employee = $psf_emp + $row['psf_emp_manual'];
			$psf_company = $psf_com + $row['psf_comp_manual'];

			$pvf_emp = 0;
			$pvf_com = 0;
			if($row['calc_pvf'] == 1){
				if($row['perc_thb_pvf'] == 2){
					$pvf_emp = ($total_pvf * $row['pvf_rate_emp']);
					$pvf_com = ($total_pvf * $row['pvf_rate_com']);
				}else{
					$pvf_emp = ($total_pvf * $row['pvf_rate_emp'])/100;
					$pvf_com = ($total_pvf * $row['pvf_rate_com'])/100;
				}
			}else{
				$total_pvf = 0;
			}

			$pvf_employee = $pvf_emp + $row['pvf_emp_manual'];
			$pvf_company = $pvf_com + $row['pvf_comp_manual'];


			$sso_emp = 0;
			$sso_com = 0;
			if($row['calc_sso'] == 1){
				$sso_emp = ($total_sso * $sso_rate_emp);
				$sso_emp = ($sso_emp > $max_sso ? $max_sso : $sso_emp);
				$sso_emp = ($sso_emp < $min_sso ? $min_sso : $sso_emp);
				$sso_emp = $sso_emp;

				$sso_com = ($total_sso * $sso_rate_com);
				$sso_com = ($sso_com > $max_sso_com ? $max_sso_com : $sso_com);
				$sso_com = ($sso_com < $min_sso_com ? $min_sso_com : $sso_com);
				$sso_com = $sso_com;

			}else{
				$total_sso = 0;
			}

			
			$sso_employee = $sso_emp + $row['sso_emp_manual'];
			$sso_company = $sso_com + $row['sso_comp_manual'];
			$sso_employee = round($sso_employee,2);
			$sso_company = round($sso_company,2);

			//for sso employer, pvf employer & psf employer (these are special cases)
			saveAllowDeductdata($_REQUEST['mid'],$key,'ssoemployer',$sso_company,0);
			saveAllowDeductdata($_REQUEST['mid'],$key,'pvfemployer',$pvf_company,0);
			saveAllowDeductdata($_REQUEST['mid'],$key,'psfemployer',$psf_company,0);

			foreach($fixedforMonth as $k1 => $v1) {
				if($k1==57){
					//===== save data for allowance/deduction
					saveAllowDeductdata($_REQUEST['mid'],$key,$k1,$sso_employee,0);
				}
				if($k1==58){
					//===== save data for allowance/deduction
					saveAllowDeductdata($_REQUEST['mid'],$key,$k1,$pvf_employee,0);
				}
				if($k1==59){
					//===== save data for allowance/deduction
					saveAllowDeductdata($_REQUEST['mid'],$key,$k1,$psf_employee,0);
				}
			}


			$sso_by_company = $row['sso_by_company'];
			/*if($row['sso_by'] == 1){
				$sso_by_company = $sso_employee;
			}*/


			//========== Fetch all previous month data ================//
			$salary_group_total_prev = 0;
			$overtime_group_total_prev = 0;
			$fix_income_group_total_prev = 0;
			$var_income_group_total_prev = 0;
			$other_income_group_total_prev = 0;
			$absence_group_total_prev = 0;
			$fix_ded_group_total_prev = 0;
			$var_ded_group_total_prev = 0;
			$other_ded_group_total_prev = 0;
			$legal_ded_group_total_prev = 0;
			$advance_pay_group_total_prev = 0;

			$total_earnings_prev = 0;
			$total_deductions_prev = 0;
			$total_pnd1_prev = 0;
			$total_sso_prev = 0;
			$total_pvf_prev = 0;
			$total_psf_prev = 0;
			$total_tax_income_prev = 0;

			$total_tax_fixpro_prev = 0;
			$total_tax_fix_prev = 0;
			$total_tax_var_prev = 0;
			$total_tax_nontax_prev = 0;
			$total_of_alltax_prev = 0;

			$sso_by_company_prev = 0;
			$sso_employee_prev = 0;
			$pvf_employee_prev = 0;
			$psf_employee_prev = 0;
			$total_tax_prev = 0;

			$total_net_income_prev = 0;
			$total_net_pay_prev = 0;


			if($cur_month > 1){

				if($result = $dbc->query("SELECT basic_salary, salary, salary_group_total, overtime_group_total, fix_income_group_total, var_income_group_total, other_income_group_total, absence_group_total, fix_ded_group_total, var_ded_group_total, other_ded_group_total, legal_ded_group_total, advance_pay_group_total, total_earnings, total_deductions, total_pnd1, total_sso, total_pvf, total_psf, total_tax_income, total_tax_fixpro, total_tax_fix, total_tax_var, total_tax_nontax, total_of_alltax, sso_by_company, sso_employee, pvf_employee, psf_employee, tax_this_month, total_net_income, total_net_pay FROM ".$sessionpayrollDbase." WHERE emp_id = '".$key."' AND payroll_modal_id='".$_REQUEST['mid']."' AND month < '".$cur_month."'")){
					while($prev = $result->fetch_object()){

						$total_earnings_prev += $prev->total_earnings;
						$total_deductions_prev += $prev->total_deductions;
						$total_pnd1_prev += $prev->total_pnd1;
						$total_sso_prev += $prev->total_sso;
						$total_pvf_prev += $prev->total_pvf;	
						$total_psf_prev += $prev->total_psf;	
						$total_tax_income_prev += $prev->total_tax_income;	
						$salary_group_total_prev += $prev->salary_group_total;	
						$overtime_group_total_prev += $prev->overtime_group_total;	
						$fix_income_group_total_prev += $prev->fix_income_group_total;	
						$var_income_group_total_prev += $prev->var_income_group_total;	
						$other_income_group_total_prev += $prev->other_income_group_total;	
						$absence_group_total_prev += $prev->absence_group_total;	
						$fix_ded_group_total_prev += $prev->fix_ded_group_total;	
						$var_ded_group_total_prev += $prev->var_ded_group_total;	
						$other_ded_group_total_prev += $prev->other_ded_group_total;	
						$legal_ded_group_total_prev += $prev->legal_ded_group_total;	
						$advance_pay_group_total_prev += $prev->advance_pay_group_total;	
						$total_tax_fixpro_prev += $prev->total_tax_fixpro;	
						$total_tax_fix_prev += $prev->total_tax_fix;	
						$total_tax_var_prev += $prev->total_tax_var;	
						$total_tax_nontax_prev += $prev->total_tax_nontax;	
						$total_of_alltax_prev += $prev->total_of_alltax;
						$sso_by_company_prev += $prev->sso_by_company;
						$sso_employee_prev += $prev->sso_employee;
						$pvf_employee_prev += $prev->pvf_employee;
						$psf_employee_prev += $prev->psf_employee;
						$psf_employee_prev += $prev->psf_employee;
						$total_tax_prev += $prev->tax_this_month;
						$total_net_income_prev += $prev->total_net_income;
						$total_net_pay_prev += $prev->total_net_pay;
					}
				}else{
					var_dump(mysqli_error($dbc));
				}
			}

			//========== Yearly calculation =================//

			$emp_joining_month = date('m', strtotime($empinfo['joining_date']));
			if($cur_month == 1){
				$get_months = 12;
			}else{
				$get_months = ((12 - (int)$emp_joining_date) + 1);
			}

			/*if($row['tax_by_company'] > 0 || $row['sso_by_company'] > 0){
				$total_tax_fixpro = ($total_tax_fixpro - $row['tax_by_company'] - $row['sso_by_company']);
			}*/

			$fixed_prorated_yearly = $total_tax_fixpro * $get_months; 
			$fixed_yearly = $fixed_prorated_yearly + $total_tax_fix;

			//echo $total_tax_fixpro_prev .'+'. $total_tax_fixpro; die('sd');

			

			$fixed_actual_prorated_yearly = ($total_tax_fixpro_prev + ($total_tax_fixpro * $remaining_months));
			$fixed_actual_yearly = $fixed_actual_prorated_yearly + $total_tax_fix_prev + $total_tax_fix;

			$variable_prev = $total_tax_var_prev;
			$variable_curr = $total_tax_var;

			$income_YTD = $total_of_alltax_prev + $total_of_alltax;


			//============ Yearly Tax Deduction ================//
			$total_yearly_standard_deduction = $row['tax_standard_deduction'];
			if($row['calc_on_sd'] == 1){
				$calc_standard_deduction = ($total_yearly_standard_deduction * 0.5);
				if($calc_standard_deduction <= 100000){
					$total_yearly_standard_deduction = $calc_standard_deduction;
				}else{
					$total_yearly_standard_deduction = 100000;
				}
			}

			$standard_deduction_manual = $row['standard_deduction_manual'];
			$standard_deduction_total = $total_yearly_standard_deduction + $standard_deduction_manual;
			

			$total_yearly_personal_care = $row['tax_personal_allowance'];
			if($row['calc_on_pc'] == 1){
				$calc_personal_care = ($total_yearly_personal_care * 0.4);
				if($calc_personal_care <= 60000){
					$total_yearly_personal_care = $calc_personal_care;
				}else{
					$total_yearly_personal_care = 60000;
				}
			}

			$personal_care_manual = $row['personal_care_manual'];
			$personal_care_total = $total_yearly_personal_care + $personal_care_manual;
			

			$total_yearly_provident_fund = $row['tax_allow_pvf'];
			if($row['calc_on_pf'] == 1){
				$total_yearly_provident_fund = ($total_pvf_prev + $total_pvf) * $remaining_months;
			}

			$allow_pvf_manual = $row['allow_pvf_manual'];
			$allow_pvf_total = $total_yearly_provident_fund + $allow_pvf_manual;


			$total_yearly_social_security_fund = $row['tax_allow_sso'];
			if($row['calc_on_ssf'] == 1){

				$calc_comming_month_sso = $total_sso_allow;
				/*$monthss = (int)$cur_month + 1;
				for ($i=$monthss; $i <= 12; $i++) { 
					$calc_comming_month_sso += $total_sso * $pperiods[$i]['sso_eRate'];
				}*/
				
				//$total_yearly_social_security_fund = $total_sso_prev + $calc_comming_month_sso;
				$total_yearly_social_security_fund = $calc_comming_month_sso;
				
			}

			$allow_sso_manual = $row['allow_sso_manual'];
			$allow_sso_total = $total_yearly_social_security_fund + $allow_sso_manual;


			$total_other_tax_deductions = $row['total_other_tax_deductions'];
			//$total_yearly_tax_deductions = ($standard_deduction_total + $personal_care_total + $allow_pvf_total + $allow_sso_total + $total_other_tax_deductions);
			$total_tax_deductions = ($standard_deduction_total + $personal_care_total + $allow_pvf_total + $allow_sso_total);
			//echo '<br>';
			//$total_yearly_tax_deductions = round($total_yearly_tax_deductions,2);

			
			//=============== Add extra item in Other income/deduction ==================//
			//$other_income_group_total = $other_income_group_total + $sso_by_company;
			//$other_ded_group_total = $other_ded_group_total + $sso_employee + $pvf_employee + $psf_employee;
			//$other_income_group_total = $other_income_group_total;
			//$other_ded_group_total = $other_ded_group_total;

			

			//================ Full Year Tax Base calculations ====================//
			$full_year_fixprorated = ($total_tax_fixpro_prev + ($total_tax_fixpro * $remaining_months));
			$full_year_fixed = ($total_tax_fix_prev + ($total_tax_fix * $remaining_months));
			$full_year_var = ($total_tax_var_prev + ($total_tax_var * $remaining_months));
			$full_year_taxableincome = ($total_of_alltax_prev + ($total_of_alltax * $remaining_months));
			$full_year_non_taxable = ($total_tax_nontax_prev + ($total_tax_nontax * $remaining_months));

			//================ Full Year SSO/PVF/PSF calculation ==================//
			$full_year_sso_employee = ($sso_employee_prev + ($sso_employee * $remaining_months));
			//$full_year_sso_employee = $allow_sso_total;
			$full_year_sso_by_company = ($sso_by_company_prev + ($sso_by_company * $remaining_months));
			$full_year_pvf_employee = ($pvf_employee_prev + ($pvf_employee * $remaining_months));
			$full_year_psf_employee = ($psf_employee_prev + ($psf_employee * $remaining_months));

			$full_year_pnd = ($total_pnd1_prev + ($total_pnd1 * $remaining_months));
			$full_year_sso = ($total_sso_prev + ($total_sso * $remaining_months));
			$full_year_pvf = ($total_pvf_prev + ($total_pvf * $remaining_months));
			$full_year_psf = ($total_psf_prev + ($total_psf * $remaining_months));

			

			//================ TAX Deduction total =============================//
			$total_yearly_tax_deductions = ($standard_deduction_total + $personal_care_total + $full_year_pvf_employee + $full_year_sso_employee + $total_other_tax_deductions);
			//$total_tax_deductions = ($standard_deduction_total + $personal_care_total + $allow_pvf_total + $allow_sso_total);
			//echo '<br>';
			$total_yearly_tax_deductions = round($total_yearly_tax_deductions,2);

			//================ TAX Claculation =============================//
			$sso_year = $full_year_sso_employee;
			$pvf_year = $full_year_pvf_employee;
			if($row['sso_by']){$sso = $sso_year;}else{$sso = 0;}

			//============== Year income ===================
			$acm_fix = $fixed_actual_yearly - $total_tax_deductions;
			//echo $total_tax_deductions;
			//die('<br>sdfsd');
			//if($acm_fix < 0){ $acm_fix = 0; }
			$acm_fix_prev = $acm_fix + $variable_prev;
			//if($acm_fix_prev < 0){ $acm_fix_prev = 0; }
			$acm_fix_prev_var = $acm_fix_prev + $variable_curr;
			//if($acm_fix_prev_var < 0){ $acm_fix_prev_var = 0; }

			$cam_fix = $fixed_yearly - $total_tax_deductions;
			//if($cam_fix < 0){ $cam_fix = 0; }
			$cam_fix_prev = $cam_fix + $variable_prev;
			//if($cam_fix_prev < 0){ $cam_fix_prev = 0; }
			$cam_fix_prev_var = $cam_fix_prev + $variable_curr;
			//if($cam_fix_prev_var < 0){ $cam_fix_prev_var = 0; }

			$ytd_income = $income_YTD - $total_tax_deductions;
			//if($ytd_income < 0){ $ytd_income = 0; }

			//============= Year tax calculation ================
			$acm_fix_tax_calc = calculateAnualTax($acm_fix, $row['calc_base'], $sso, $pvf_year);
			
			$acm_fix_prev_tax_calc = calculateAnualTax($acm_fix_prev, $row['calc_base'], $sso, $pvf_year);
			$acm_fix_prev_var_tax_calc = calculateAnualTax($acm_fix_prev_var, $row['calc_base'], $sso, $pvf_year);

			// echo $sso.'<br>';
			// echo $acm_fix_prev_var_tax_calc.'<br>';
			// die('stop');

			$cam_fix_tax_calc = calculateAnualTax($cam_fix, $row['calc_base'], $sso, $pvf_year);
			$cam_fix_prev_tax_calc = calculateAnualTax($cam_fix_prev, $row['calc_base'], $sso, $pvf_year);
			$cam_fix_prev_var_tax_calc = calculateAnualTax($cam_fix_prev_var, $row['calc_base'], $sso, $pvf_year);

			$tax_ytd = calculateAnualTax($ytd_income, $row['calc_base'], $sso, $pvf_year);

			$total_tax_year = 0.00;
			$tax_previous = 0.00;
			$tax_remaining = 0.00;
			$tax_fix_month = 0.00;
			$tax_var_month = 0.00;
			$tax_this_month = 0.00;
			$tax_next_month = 0.00;
			$tax_tot_next_month = 0.00;
			//$modify_tax = $row['modify_tax'];

			if($row['calc_tax'] == 1){ //PND1

				if($row['calc_method'] == 'acm'){
					//================ Tax Summary acm =================
					$total_tax_year = $acm_fix_prev_var_tax_calc;
					$tax_previous = $total_tax_prev;
					$tax_remaining = $total_tax_year - $tax_previous;
					$tax_var_month = $acm_fix_prev_var_tax_calc - $acm_fix_prev_tax_calc;
					//$tax_fix_month = ($tax_remaining - $tax_var_month) / $remaining_months_without_curr;
					$tax_fix_month = ($tax_remaining - $tax_var_month) / $remaining_months;
					if($tax_fix_month < 0){ $tax_fix_month = 0; }
					$tax_this_month = $tax_fix_month + $tax_var_month;
					if($tax_this_month < 0){ $tax_this_month = 0; }
					$tax_tot_next_month = $total_tax_year - $tax_previous - $tax_this_month;
					if($tax_tot_next_month < 0){ $tax_tot_next_month = 0; }
					//$tax_next_month = $tax_tot_next_month / ($remaining_months_without_curr - 1);
					$tax_next_month = $tax_tot_next_month / ($remaining_months-1);
					if($tax_next_month < 0){ $tax_next_month = 0; }
				}

				if($row['calc_method'] == 'ytd'){
					//================ Tax Summary ytd =================
					$total_tax_year = $tax_ytd;
					$tax_previous = $total_tax_prev;
					$tax_this_month = $total_tax_year - $tax_previous;
				}

				if($row['calc_method'] == 'cam'){
					//================ Tax Summary cam =================
					$total_tax_year = $cam_fix_prev_var_tax_calc;
					$tax_previous = $total_tax_prev;
					$tax_remaining = $total_tax_year - $tax_previous;
					$tax_var_month = $cam_fix_prev_var_tax_calc - $cam_fix_prev_tax_calc;
					// $tax_fix_month = ($tax_remaining - $tax_var_month) / $remaining_months_without_curr;
					$tax_fix_month = ($tax_remaining - $tax_var_month) / $remaining_months;
					if($tax_fix_month < 0){ $tax_fix_month = 0; }
					$tax_this_month = $tax_fix_month + $tax_var_month;
					if($tax_this_month < 0){ $tax_this_month = 0; }
					$tax_tot_next_month = $total_tax_year - $tax_previous - $tax_this_month;
					if($tax_tot_next_month < 0){ $tax_tot_next_month = 0; }
					//$tax_next_month = $tax_tot_next_month / ($remaining_months_without_curr - 1);
					$tax_next_month = $tax_tot_next_month / ($remaining_months-1);
					if($tax_next_month < 0){ $tax_next_month = 0; }
				}
			}

			//echo $key.' - '.$total_tax_fixpro; echo '<br>';

			$total_tax_year = round($total_tax_year,2);
			$tax_previous = round($tax_previous,2);
			$tax_remaining = round($tax_remaining,2);
			$tax_fix_month = round($tax_fix_month,2);
			$tax_var_month = round($tax_var_month,2);
			$tax_this_month = round($tax_this_month,2);
			$tax_next_month = round($tax_next_month,2);
			$tax_tot_next_month = round($tax_tot_next_month,2);

			$tax_by_company = 0.00;
			$sso_by_company = 0.00;

			if($row['calc_base'] == 'gross'){
				//$net_month = $gross_income_month - $tot_deductions;
				if($row['sso_by']){
					$sso_by_company = $sso_employee;
					//$net_month += $sso_employee;
				}
			}else{
				//$net_month = $gross_income_month;
				$total_earnings += $tax_this_month;
				if($row['sso_by']){
					$total_earnings += $sso_employee;
					$sso_by_company = $sso_employee;
				}else{
					//$net_month -= $sso_employee;
				}
				$tax_by_company = $tax_this_month;
			}

			$sso_tax_by_com = array(27=>$tax_by_company, 28=>$sso_by_company, 60=>$tax_this_month);
			foreach($fixedforMonth as $k1 => $v1) {
				if($k1==27 || $k1==28 || $k1==60){
					//===== save data for allowance/deduction
					if($k1 == 60){
						$extravalue = $tax_next_month;
					}elseif($k1 == 27){
						if($tax_by_company > 0){
							$extravalue = $tax_next_month;
						}else{
							$extravalue = 0;
						}
					}else{
						if($sso_by_company > 0){
							$extravalue = $sso_employee;
						}else{
							$extravalue = 0;
						}
					}

					saveAllowDeductdata($_REQUEST['mid'],$key,$k1,$sso_tax_by_com[$k1],$extravalue);
				}
			}

			//die('dsdsd');
			//========== Total of all groups =====//
			$totalsofgroups = getAllowDeductTotals($_REQUEST['mid'],$key);
			foreach ($totalsofgroups as $ktot => $vtot) {
				
				//=== Salary ===//
				if($vtot['groups'] == 'inc_sal'){
					if($vtot['classifications'] == 1){
						$totals_array_deduction[$key]['inc_sal'][] = $vtot['curr_month'];
					}else{
						$totals_array[$key]['inc_sal'][] = $vtot['curr_month'];
					}
				}

				//=== Overtime ===//
				if($vtot['groups'] == 'inc_ot'){
					if($vtot['classifications'] == 1){
						$totals_array_deduction[$key]['inc_ot'][] = $vtot['curr_month'];
					}else{
						$totals_array[$key]['inc_ot'][] = $vtot['curr_month'];
					}
				}

				//=== Fixed income ===//
				if($vtot['groups'] == 'inc_fix'){
					if($vtot['classifications'] == 1){
						$totals_array_deduction[$key]['inc_fix'][] = $vtot['curr_month'];
					}else{
						$totals_array[$key]['inc_fix'][] = $vtot['curr_month'];
					}
				}

				//==== Variable income =====//
				if($vtot['groups'] == 'inc_var'){
					if($vtot['classifications'] == 1){
						$totals_array_deduction[$key]['inc_var'][] = $vtot['curr_month'];
					}else{
						$totals_array[$key]['inc_var'][] = $vtot['curr_month'];
					}
				}

				//==== Other income =====//
				if($vtot['groups'] == 'inc_oth'){
					if($vtot['classifications'] == 1){
						$totals_array_deduction[$key]['inc_oth'][] = $vtot['curr_month'];
					}else{
						$totals_array[$key]['inc_oth'][] = $vtot['curr_month'];
					}
				}

				//==== Absence =====//
				if($vtot['groups'] == 'ded_abs'){
					if($vtot['classifications'] == 1){
						$totals_array_deduction[$key]['ded_abs'][] = $vtot['curr_month'];
					}else{
						$totals_array[$key]['ded_abs'][] = $vtot['curr_month'];
					}
				}

				//==== Fixed deductions =====//
				if($vtot['groups'] == 'ded_fix'){
					if($vtot['classifications'] == 1){
						$totals_array_deduction[$key]['ded_fix'][] = $vtot['curr_month'];
					}else{
						$totals_array[$key]['ded_fix'][] = $vtot['curr_month'];
					}
				}

				//==== Variable deductions =====//
				if($vtot['groups'] == 'ded_var'){
					if($vtot['classifications'] == 1){
						$totals_array_deduction[$key]['ded_var'][] = $vtot['curr_month'];
					}else{
						$totals_array[$key]['ded_var'][] = $vtot['curr_month'];
					}
				}

				//==== Other deductions =====//
				if($vtot['groups'] == 'ded_oth'){
					if($vtot['classifications'] == 1){
						$totals_array_deduction[$key]['ded_oth'][] = $vtot['curr_month'];
					}else{
						$totals_array[$key]['ded_oth'][] = $vtot['curr_month'];
					}
				}

				//==== Legal deductions / Loans =====//
				if($vtot['groups'] == 'ded_leg'){
					if($vtot['classifications'] == 1){
						$totals_array_deduction[$key]['ded_leg'][] = $vtot['curr_month'];
					}else{
						$totals_array[$key]['ded_leg'][] = $vtot['curr_month'];
					}
				}

				//==== Advanced payments =====//
				if($vtot['groups'] == 'ded_pay'){
					if($vtot['classifications'] == 1){
						$totals_array_deduction[$key]['ded_pay'][] = $vtot['curr_month'];
					}else{
						$totals_array[$key]['ded_pay'][] = $vtot['curr_month'];
					}
				}

				//===== Full year total for all groups =====//
				if($vtot['groups'] != ''){
					$allmonthsum = $vtot['jan'] + $vtot['feb'] + $vtot['mar'] + $vtot['apr'] + $vtot['may'] + $vtot['jun'] + $vtot['jul'] + $vtot['aug'] + $vtot['sep'] + $vtot['oct'] + $vtot['nov'] + $vtot['dec'];
					$full_year_total[$key][$vtot['groups']][] = $allmonthsum;
				}
			}

			/*echo '<pre>';
			//print_r($fixedforMonth);
			echo '==============Allowance========';
			print_r($totals_array);
			echo '==============deduction========';
			print_r($totals_array_deduction);
			echo '==============full year========';
			print_r($full_year_total);
			echo '</pre>';
			die('sdsdsdsd');*/
			
			//========== Total of all groups =====//

			//salary group
			$salary_group_total_allow = isset($totals_array[$key]['inc_sal']) ? array_sum($totals_array[$key]['inc_sal']) : 0;
			$salary_group_total_deduct = isset($totals_array_deduction[$key]['inc_sal']) ? array_sum($totals_array_deduction[$key]['inc_sal']) : 0;
			$salary_group_total = $salary_group_total_allow - $salary_group_total_deduct;

			//overtime group
			$overtime_group_total_allow = isset($totals_array[$key]['inc_ot']) ? array_sum($totals_array[$key]['inc_ot']) : 0;
			$overtime_group_total_deduct = isset($totals_array_deduction[$key]['inc_ot']) ? array_sum($totals_array_deduction[$key]['inc_ot']) : 0;
			$overtime_group_total = $overtime_group_total_allow - $overtime_group_total_deduct;

			//fix_income group
			$fix_income_group_total0 = isset($totals_array[$key]['inc_fix']) ? array_sum($totals_array[$key]['inc_fix']) : 0;
			$fix_income_group_total1 = isset($totals_array_deduction[$key]['inc_fix']) ? array_sum($totals_array_deduction[$key]['inc_fix']) : 0;
			$fix_income_group_total = $fix_income_group_total0 - $fix_income_group_total1;
			
			//var_income group
			$var_income_group_total0 = isset($totals_array[$key]['inc_var']) ? array_sum($totals_array[$key]['inc_var']) : 0;
			$var_income_group_total1 = isset($totals_array_deduction[$key]['inc_var']) ? array_sum($totals_array_deduction[$key]['inc_var']) : 0;
			$var_income_group_total = $var_income_group_total0 - $var_income_group_total1;

			//oth_income group
			$other_income_group_total0 = isset($totals_array[$key]['inc_oth']) ? array_sum($totals_array[$key]['inc_oth']) : 0;
			$other_income_group_total1 = isset($totals_array_deduction[$key]['inc_oth']) ? array_sum($totals_array_deduction[$key]['inc_oth']) : 0;
			$other_income_group_total = $other_income_group_total0 - $other_income_group_total1;

			//absence_income group
			$absence_group_total0 = isset($totals_array[$key]['ded_abs']) ? array_sum($totals_array[$key]['ded_abs']) : 0;
			$absence_group_total1 = isset($totals_array_deduction[$key]['ded_abs']) ? array_sum($totals_array_deduction[$key]['ded_abs']) : 0;
			$absence_group_total = $absence_group_total0 + $absence_group_total1;

			//fix_ded_income group
			$fix_ded_group_total0 = isset($totals_array[$key]['ded_fix']) ? array_sum($totals_array[$key]['ded_fix']) : 0;
			$fix_ded_group_total1 = isset($totals_array_deduction[$key]['ded_fix']) ? array_sum($totals_array_deduction[$key]['ded_fix']) : 0;
			$fix_ded_group_total = $fix_ded_group_total0 + $fix_ded_group_total1;

			//var_ded_income group
			$var_ded_group_total0 = isset($totals_array[$key]['ded_var']) ? array_sum($totals_array[$key]['ded_var']) : 0;
			$var_ded_group_total1 = isset($totals_array_deduction[$key]['ded_var']) ? array_sum($totals_array_deduction[$key]['ded_var']) : 0;
			$var_ded_group_total = $var_ded_group_total0 + $var_ded_group_total1;

			//oth_ded_income group
			$other_ded_group_total0 = isset($totals_array[$key]['ded_oth']) ? array_sum($totals_array[$key]['ded_oth']) : 0;
			$other_ded_group_total1 = isset($totals_array_deduction[$key]['ded_oth']) ? array_sum($totals_array_deduction[$key]['ded_oth']) : 0;
			$other_ded_group_total = $other_ded_group_total0 + $other_ded_group_total1;

			//legal_ded_income group
			$legal_ded_group_total0 = isset($totals_array[$key]['ded_leg']) ? array_sum($totals_array[$key]['ded_leg']) : 0;
			$legal_ded_group_total1 = isset($totals_array_deduction[$key]['ded_leg']) ? array_sum($totals_array_deduction[$key]['ded_leg']) : 0;
			$legal_ded_group_total = $legal_ded_group_total0 + $legal_ded_group_total1;

			//advance_ded_income group
			$advance_pay_group_total0 = isset($totals_array[$key]['ded_pay']) ? array_sum($totals_array[$key]['ded_pay']) : 0;
			$advance_pay_group_total1 = isset($totals_array_deduction[$key]['ded_pay']) ? array_sum($totals_array_deduction[$key]['ded_pay']) : 0;
			$advance_pay_group_total = $advance_pay_group_total0 + $advance_pay_group_total1;


			//=============== Total Earnings and deduction ==============================//
			$total_earnings = $salary_group_total + $overtime_group_total + $fix_income_group_total + $var_income_group_total + $other_income_group_total;
			$total_earnings = round($total_earnings,2);
			$total_deductions = $absence_group_total + $fix_ded_group_total + $var_ded_group_total + $other_ded_group_total + $legal_ded_group_total + $advance_pay_group_total;
			$total_deductions = round($total_deductions,2);

			
			//=============== Full Year totals calculations =============================//
			$full_year_salary_grp = isset($full_year_total[$key]['inc_sal']) ? array_sum($full_year_total[$key]['inc_sal']) : 0;
			$full_year_salary_grp += $salary_group_total_prev;

			$full_year_overtime_grp = isset($full_year_total[$key]['inc_ot']) ? array_sum($full_year_total[$key]['inc_ot']) : 0;
			$full_year_overtime_grp += $overtime_group_total_prev;

			$full_year_fixincome_grp = isset($full_year_total[$key]['inc_fix']) ? array_sum($full_year_total[$key]['inc_fix']) : 0;
			$full_year_fixincome_grp += $fix_income_group_total_prev;

			$full_year_varincome_grp = isset($full_year_total[$key]['inc_var']) ? array_sum($full_year_total[$key]['inc_var']) : 0;
			$full_year_varincome_grp += $var_income_group_total_prev;

			$full_year_othincome_grp = isset($full_year_total[$key]['inc_oth']) ? array_sum($full_year_total[$key]['inc_oth']) : 0;
			$full_year_othincome_grp += $other_income_group_total_prev;

			$full_year_absence_grp = isset($full_year_total[$key]['ded_abs']) ? array_sum($full_year_total[$key]['ded_abs']) : 0;
			$full_year_absence_grp += $absence_group_total_prev;

			$full_year_fixded_grp = isset($full_year_total[$key]['ded_fix']) ? array_sum($full_year_total[$key]['ded_fix']) : 0;
			$full_year_fixded_grp += $fix_ded_group_total_prev;

			$full_year_varded_grp = isset($full_year_total[$key]['ded_var']) ? array_sum($full_year_total[$key]['ded_var']) : 0;
			$full_year_varded_grp += $var_ded_group_total_prev;

			$full_year_othded_grp = isset($full_year_total[$key]['ded_oth']) ? array_sum($full_year_total[$key]['ded_oth']) : 0;
			$full_year_othded_grp += $other_ded_group_total_prev;

			$full_year_legal_grp = isset($full_year_total[$key]['ded_leg']) ? array_sum($full_year_total[$key]['ded_leg']) : 0;
			$full_year_legal_grp += $legal_ded_group_total_prev;

			$full_year_advpay_grp = isset($full_year_total[$key]['ded_pay']) ? array_sum($full_year_total[$key]['ded_pay']) : 0;
			$full_year_advpay_grp += $advance_pay_group_total_prev;

			
			//============ Net income or net pay calculation ============//
			$total_net_income = ($salary_group_total + $overtime_group_total + $fix_income_group_total + $var_income_group_total + $other_income_group_total) - ($absence_group_total + $fix_ded_group_total + $var_ded_group_total + $other_ded_group_total);
			$total_net_pay = $total_net_income - $advance_pay_group_total - $legal_ded_group_total;

			//=============== Full Year Earnings and deduction ==============================//
			$full_year_earnings = $full_year_salary_grp + $full_year_overtime_grp + $full_year_fixincome_grp + $full_year_varincome_grp + $full_year_othincome_grp;
			$full_year_deductions = $full_year_absence_grp + $full_year_fixded_grp + $full_year_varded_grp + $full_year_othded_grp + $full_year_legal_grp + $full_year_advpay_grp;

			$full_year_earnings = round($full_year_earnings,2);
			$full_year_deductions = round($full_year_deductions,2);

			$total_net_income_prev = ($salary_group_total_prev + $overtime_group_total_prev + $fix_income_group_total_prev + $var_income_group_total_prev + $other_income_group_total_prev) - ($absence_group_total_prev + $fix_ded_group_total_prev + $var_ded_group_total_prev + $other_ded_group_total_prev);
			$total_net_pay_prev = $total_net_income_prev - $legal_ded_group_total_prev - $advance_pay_group_total_prev;

			$fullyear_net_income = ($full_year_salary_grp + $full_year_overtime_grp + $full_year_fixincome_grp + $full_year_varincome_grp + $full_year_othincome_grp) - ($full_year_absence_grp + $full_year_fixded_grp + $full_year_varded_grp + $full_year_othded_grp);
			$fullyear_net_pay = $fullyear_net_income - $full_year_legal_grp - $full_year_advpay_grp;


			//=========== query for saving data
			$upsql = "UPDATE ".$sessionpayrollDbase." SET `salary_group_total`='".$salary_group_total."', `overtime_group_total`='".$overtime_group_total."', `fix_income_group_total`='".$fix_income_group_total."', `var_income_group_total`='".$var_income_group_total."', `other_income_group_total`='".$other_income_group_total."', `absence_group_total`= '".$absence_group_total."', `fix_ded_group_total`='".$fix_ded_group_total."', `var_ded_group_total`='".$var_ded_group_total."', `other_ded_group_total`='".$other_ded_group_total."', `legal_ded_group_total`='".$legal_ded_group_total."', `advance_pay_group_total`='".$advance_pay_group_total."', `total_earnings`='".$total_earnings."', `total_deductions`='".$total_deductions."', `total_pnd1`='".$total_pnd1."', `total_sso`='".$total_sso."', `total_pvf`='".$total_pvf."', `total_psf`='".$total_psf."', `total_tax_income` = '".$total_tax_income."', `total_tax_fixpro`='".$total_tax_fixpro."', `total_tax_fix`='".$total_tax_fix."', `total_tax_var`='".$total_tax_var."', `total_tax_nontax`='".$total_tax_nontax."', `total_of_alltax`='".$total_of_alltax."', `sso_emp_calc` = '".$sso_emp."', `sso_comp_calc` = '".$sso_com."', `sso_employee`='".$sso_employee."', `sso_company`='".$sso_company."', `pvf_emp_calc`='".$pvf_emp."', `pvf_comp_calc`='".$pvf_com."', `pvf_employee`='".$pvf_employee."', `pvf_company`='".$pvf_company."', `psf_emp_calc`='".$psf_emp."', `psf_comp_calc`='".$psf_com."', `psf_employee`='".$psf_employee."', `psf_company`='".$psf_company."', `salary_group_total_prev`='".$salary_group_total_prev."', `overtime_group_total_prev`='".$overtime_group_total_prev."', `fix_income_group_total_prev`='".$fix_income_group_total_prev."', `var_income_group_total_prev`='".$var_income_group_total_prev."', `other_income_group_total_prev`='".$other_income_group_total_prev."', `absence_group_total_prev`='".$absence_group_total_prev."', `fix_ded_group_total_prev`='".$fix_ded_group_total_prev."', `var_ded_group_total_prev`='".$var_ded_group_total_prev."', `other_ded_group_total_prev`='".$other_ded_group_total_prev."', `legal_ded_group_total_prev`='".$legal_ded_group_total_prev."', `advance_pay_group_total_prev`='".$advance_pay_group_total_prev."', `total_earnings_prev`='".$total_earnings_prev."', `total_deductions_prev`='".$total_deductions_prev."', `total_pnd1_prev`='".$total_pnd1_prev."', `total_sso_prev`='".$total_sso_prev."', `total_pvf_prev`='".$total_pvf_prev."', `total_psf_prev`='".$total_psf_prev."', `total_tax_income_prev`='".$total_tax_income_prev."', `total_tax_fixpro_prev`='".$total_tax_fixpro_prev."', `total_tax_fix_prev`='".$total_tax_fix_prev."', `total_tax_var_prev`='".$total_tax_var_prev."', `total_tax_nontax_prev`='".$total_tax_nontax_prev."', `total_of_alltax_prev`='".$total_of_alltax_prev."', `fixed_prorated_yearly`='".$fixed_prorated_yearly."', `fixed_yearly`='".$fixed_yearly."', `fixed_actual_prorated_yearly`='".$fixed_actual_prorated_yearly."', `fixed_actual_yearly`='".$fixed_actual_yearly."', `variable_prev`='".$variable_prev."', `variable_curr`='".$variable_curr."', `income_YTD`='".$income_YTD."', `standard_deduction_manual`='".$standard_deduction_manual."', `standard_deduction_total`='".$standard_deduction_total."', `personal_care_manual`='".$personal_care_manual."', `personal_care_total`='".$personal_care_total."', `tax_allow_pvf`='".$total_yearly_provident_fund."', `allow_pvf_manual`='".$allow_pvf_manual."', `allow_pvf_total`='".$allow_pvf_total."', `tax_allow_sso`='".$total_yearly_social_security_fund."', `allow_sso_manual`='".$allow_sso_manual."', `allow_sso_total`='".$allow_sso_total."', `total_other_tax_deductions` ='".$total_other_tax_deductions."', `total_yearly_tax_deductions`='".$total_yearly_tax_deductions."', `tax_by_company`='".$tax_by_company."', `sso_by_company`='".$sso_by_company."', `sso_by_company_prev`='".$sso_by_company_prev."', `sso_employee_prev`='".$sso_employee_prev."', `pvf_employee_prev`='".$pvf_employee_prev."', `psf_employee_prev`='".$psf_employee_prev."', `full_year_salary_grp`='".$full_year_salary_grp."', `full_year_overtime_grp`='".$full_year_overtime_grp."', `full_year_fixincome_grp`='".$full_year_fixincome_grp."', `full_year_varincome_grp`='".$full_year_varincome_grp."', `full_year_othincome_grp`='".$full_year_othincome_grp."', `full_year_absence_grp`='".$full_year_absence_grp."', `full_year_fixded_grp`='".$full_year_fixded_grp."', `full_year_varded_grp`='".$full_year_varded_grp."', `full_year_othded_grp`='".$full_year_othded_grp."', `full_year_legal_grp`='".$full_year_legal_grp."', `full_year_advpay_grp`='".$full_year_advpay_grp."', `full_year_fixprorated`='".$full_year_fixprorated."', `full_year_fixed`='".$full_year_fixed."', `full_year_var`='".$full_year_var."', `full_year_taxableincome`='".$full_year_taxableincome."', `full_year_non_taxable`='".$full_year_non_taxable."', `full_year_sso_employee`='".$full_year_sso_employee."', `full_year_sso_by_company`='".$full_year_sso_by_company."', `full_year_pvf_employee`='".$full_year_pvf_employee."', `full_year_psf_employee`='".$full_year_psf_employee."', `full_year_pnd`='".$full_year_pnd."', `full_year_sso`='".$full_year_sso."', `full_year_pvf`='".$full_year_pvf."', `full_year_psf`='".$full_year_psf."', `full_year_earnings`='".$full_year_earnings."', `full_year_deductions`='".$full_year_deductions."', `acm_fix`='".$acm_fix."', `acm_fix_prev`='".$acm_fix_prev."', `acm_fix_prev_var`='".$acm_fix_prev_var."', `cam_fix`='".$cam_fix."', `cam_fix_prev`='".$cam_fix_prev."', `cam_fix_prev_var`='".$cam_fix_prev_var."', `ytd_income`='".$ytd_income."', `acm_fix_tax_calc`='".$acm_fix_tax_calc."', `acm_fix_prev_tax_calc`='".$acm_fix_prev_tax_calc."', `acm_fix_prev_var_tax_calc`='".$acm_fix_prev_var_tax_calc."', `cam_fix_tax_calc`='".$cam_fix_tax_calc."', `cam_fix_prev_tax_calc`='".$cam_fix_prev_tax_calc."', `cam_fix_prev_var_tax_calc`='".$cam_fix_prev_var_tax_calc."', `tax_ytd`='".$tax_ytd."', `total_tax_year`='".$total_tax_year."', `tax_previous`='".$tax_previous."', `tax_remaining`='".$tax_remaining."', `tax_fix_month`='".$tax_fix_month."', `tax_var_month`='".$tax_var_month."', `tax_this_month`='".$tax_this_month."', `tax_next_month`='".$tax_next_month."', `tax_tot_next_month`='".$tax_tot_next_month."', `total_net_income`= '".$total_net_income."', `total_net_pay`='".$total_net_pay."', `total_net_income_prev`='".$total_net_income_prev."', `total_net_pay_prev`='".$total_net_pay_prev."', `fullyear_net_income`='".$fullyear_net_income."', `fullyear_net_pay`='".$fullyear_net_pay."' WHERE `emp_id` = '".$key."' AND `payroll_modal_id`='".$_REQUEST['mid']."' AND `month` = '".$_SESSION['rego']['cur_month']."' ";
			$dbc->query($upsql);
			//echo $upsql;
			//die();

			$dbc->query("UPDATE ".$_SESSION['rego']['cid']."_sys_settings SET `get_deflt_parm`=0");

		}
	}

	//die('sdsdd');
	ob_clean();
	echo 'success';
?>