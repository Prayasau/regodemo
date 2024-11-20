<?php

	if(session_id()==''){session_start(); ob_start();}
	include('../../dbconnect/db_connect.php'); 
	include(DIR.'files/functions.php'); 
	include(DIR.'files/payroll_functions.php');

	$getAllowDeductAllLinkedInfo = getAllowDeductAllLinkedInfo();
	/*$getDefaultSysSettings = getDefaultSysSettings();
	$periods_defaults = unserialize($getDefaultSysSettings['periods_defaults']);

	echo '<pre>';
	print_r($periods_defaults);
	echo '</pre>'; die('dd');*/

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

			//echo '<pre>';
			//print_r($getAllowandDeductInfo);
			//print_r($manual_feed_total);
			//print_r($empinfo);
			//print_r($row);
			//echo '========== end ==========';
			//echo '</pre>';
			//die('ddddsssss');

			$totals_array = array();
			$totals_array_deduction = array();
			$key = $row['emp_id'];
			foreach($manual_feed_total as $k1 => $v1) {

				//=== Salary ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'inc_sal'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['inc_sal'][] = $v1;
					}else{
						$totals_array[$key]['inc_sal'][] = $v1;
					}
				}

				//=== Overtime ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'inc_ot'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['inc_ot'][] = $v1;
					}else{
						$totals_array[$key]['inc_ot'][] = $v1;
					}
				}

				//=== Fixed income ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'inc_fix'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['inc_fix'][] = $v1;
					}else{
						$totals_array[$key]['inc_fix'][] = $v1;
					}
				}

				//=== Variable income ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'inc_var'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['inc_var'][] = $v1;
					}else{
						$totals_array[$key]['inc_var'][] = $v1;
					}
				}

				//=== Other income ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'inc_oth'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['inc_oth'][] = $v1;
					}else{
						$totals_array[$key]['inc_oth'][] = $v1;
					}
				}

				//=== Absence ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'ded_abs'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['ded_abs'][] = $v1;
					}else{
						$totals_array[$key]['ded_abs'][] = $v1;
					}
				}

				//=== Fixed deductions ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'ded_fix'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['ded_fix'][] = $v1;
					}else{
						$totals_array[$key]['ded_fix'][] = $v1;
					}
				}

				//=== Variable deductions ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'ded_var'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['ded_var'][] = $v1;
					}else{
						$totals_array[$key]['ded_var'][] = $v1;
					}
				}

				//=== Other deductions ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'ded_oth'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['ded_oth'][] = $v1;
					}else{
						$totals_array[$key]['ded_oth'][] = $v1;
					}
				}

				//=== Legal deductions / Loans ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'ded_leg'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['ded_leg'][] = $v1;
					}else{
						$totals_array[$key]['ded_leg'][] = $v1;
					}
				}

				//=== Advanced payments ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'ded_pay'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['ded_pay'][] = $v1;
					}else{
						$totals_array[$key]['ded_pay'][] = $v1;
					}
				}

				//=== Total earnings ===//
				if($getAllowandDeductInfo[$k1]['earnings'] == 1){
					$totals_array[$key]['earnings'][] = $v1;
				}

				//=== Total deductions ===//
				if($getAllowandDeductInfo[$k1]['deductions'] == 1){
					$totals_array[$key]['deductions'][] = $v1;
				}

				//=== Total PND1 ===//
				if($getAllowandDeductInfo[$k1]['pnd1'] == 1){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['pnd1'][] = $v1;
					}else{
						$totals_array[$key]['pnd1'][] = $v1;
					}
				}

				//=== Total SSO ===//
				if($getAllowandDeductInfo[$k1]['sso'] == 1){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['sso'][] = $v1;
					}else{
						$totals_array[$key]['sso'][] = $v1;
					}
				}

				//=== Total PVF ===//
				if($getAllowandDeductInfo[$k1]['pvf'] == 1){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['pvf'][] = $v1;
					}else{
						$totals_array[$key]['pvf'][] = $v1;
					}
				}

				//=== Total PSF ===//
				if($getAllowandDeductInfo[$k1]['psf'] == 1){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['psf'][] = $v1;
					}else{
						$totals_array[$key]['psf'][] = $v1;
					}
				}

				//=== Total Tax income ===//
				if($getAllowandDeductInfo[$k1]['tax_income'] == 1){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['tax_income'][] = $v1;
					}else{
						$totals_array[$key]['tax_income'][] = $v1;
					}
				}

				//=== Tax base (fixpro) ===//
				if($getAllowandDeductInfo[$k1]['tax_base'] == 'fixpro'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['fixpro'][] = $v1;
					}else{
						$totals_array[$key]['fixpro'][] = $v1;
					}
				}

				//=== Tax base (fix) ===//
				if($getAllowandDeductInfo[$k1]['tax_base'] == 'fix'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['fix'][] = $v1;
					}else{
						$totals_array[$key]['fix'][] = $v1;
					}
				}

				//=== Tax base (var) ===//
				if($getAllowandDeductInfo[$k1]['tax_base'] == 'var'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['var'][] = $v1;
					}else{
						$totals_array[$key]['var'][] = $v1;
					}
				}

				//=== Tax base (nontax) ===//
				if($getAllowandDeductInfo[$k1]['tax_base'] == 'nontax'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['nontax'][] = $v1;
					}else{
						$totals_array[$key]['nontax'][] = $v1;
					}
				}
			}



			/*$getAllowances = getEmployeeAllowances($key,$_SESSION['rego']['curr_month']);
			$fix_allow = unserialize($getAllowances[0]['fix_allow']);
			$fix_deduct = unserialize($getAllowances[0]['fix_deduct']);*/

			$fix_allow = unserialize($row['fix_allow_from_emp']);
			$fix_deduct = unserialize($row['fix_deduct_from_emp']);


			foreach($fix_allow as $k1 => $v1) {
				
				//=== Salary ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'inc_sal'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['inc_sal'][] = $v1;
					}else{
						$totals_array[$key]['inc_sal'][] = $v1;
					}
				}

				//=== Overtime ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'inc_ot'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['inc_ot'][] = $v1;
					}else{
						$totals_array[$key]['inc_ot'][] = $v1;
					}
				}

				//=== Fixed income ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'inc_fix'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['inc_fix'][] = $v1;
					}else{
						$totals_array[$key]['inc_fix'][] = $v1;
					}
				}

				//=== Variable income ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'inc_var'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['inc_var'][] = $v1;
					}else{
						$totals_array[$key]['inc_var'][] = $v1;
					}
				}

				//=== Other income ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'inc_oth'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['inc_oth'][] = $v1;
					}else{
						$totals_array[$key]['inc_oth'][] = $v1;
					}
				}

				//=== Absence ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'ded_abs'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['ded_abs'][] = $v1;
					}else{
						$totals_array[$key]['ded_abs'][] = $v1;
					}
				}

				//=== Fixed deductions ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'ded_fix'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['ded_fix'][] = $v1;
					}else{
						$totals_array[$key]['ded_fix'][] = $v1;
					}
				}

				//=== Variable deductions ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'ded_var'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['ded_var'][] = $v1;
					}else{
						$totals_array[$key]['ded_var'][] = $v1;
					}
				}

				//=== Other deductions ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'ded_oth'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['ded_oth'][] = $v1;
					}else{
						$totals_array[$key]['ded_oth'][] = $v1;
					}
				}

				//=== Legal deductions / Loans ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'ded_leg'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['ded_leg'][] = $v1;
					}else{
						$totals_array[$key]['ded_leg'][] = $v1;
					}
				}

				//=== Advanced payments ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'ded_pay'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['ded_pay'][] = $v1;
					}else{
						$totals_array[$key]['ded_pay'][] = $v1;
					}
				}

				//=== Total earnings ===//
				if($getAllowandDeductInfo[$k1]['earnings'] == 1){
					$totals_array[$key]['earnings'][] = $v1;
				}

				//=== Total deductions ===//
				if($getAllowandDeductInfo[$k1]['deductions'] == 1){
					$totals_array[$key]['deductions'][] = $v1;
				}

				//=== Total PND1 ===//
				if($getAllowandDeductInfo[$k1]['pnd1'] == 1){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['pnd1'][] = $v1;
					}else{
						$totals_array[$key]['pnd1'][] = $v1;
					}
				}

				//=== Total SSO ===//
				if($getAllowandDeductInfo[$k1]['sso'] == 1){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['sso'][] = $v1;
					}else{
						$totals_array[$key]['sso'][] = $v1;
					}
				}

				//=== Total PVF ===//
				if($getAllowandDeductInfo[$k1]['pvf'] == 1){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['pvf'][] = $v1;
					}else{
						$totals_array[$key]['pvf'][] = $v1;
					}
				}

				//=== Total PSF ===//
				if($getAllowandDeductInfo[$k1]['psf'] == 1){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['psf'][] = $v1;
					}else{
						$totals_array[$key]['psf'][] = $v1;
					}
				}

				//=== Total Tax income ===//
				if($getAllowandDeductInfo[$k1]['tax_income'] == 1){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['tax_income'][] = $v1;
					}else{
						$totals_array[$key]['tax_income'][] = $v1;
					}
				}

				//=== Tax base (fixpro) ===//
				if($getAllowandDeductInfo[$k1]['tax_base'] == 'fixpro'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['fixpro'][] = $v1;
					}else{
						$totals_array[$key]['fixpro'][] = $v1;
					}
				}

				//=== Tax base (fix) ===//
				if($getAllowandDeductInfo[$k1]['tax_base'] == 'fix'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['fix'][] = $v1;
					}else{
						$totals_array[$key]['fix'][] = $v1;
					}
				}

				//=== Tax base (var) ===//
				if($getAllowandDeductInfo[$k1]['tax_base'] == 'var'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['var'][] = $v1;
					}else{
						$totals_array[$key]['var'][] = $v1;
					}
				}

				//=== Tax base (nontax) ===//
				if($getAllowandDeductInfo[$k1]['tax_base'] == 'nontax'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['nontax'][] = $v1;
					}else{
						$totals_array[$key]['nontax'][] = $v1;
					}
				}
			}

			foreach($fix_deduct as $k1 => $v1) {

				//=== Salary ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'inc_sal'){
					$totals_array_deduction[$key]['inc_sal'][] = $v1;
				}

				//=== Overtime ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'inc_ot'){
					$totals_array_deduction[$key]['inc_ot'][] = $v1;
				}

				//=== Fixed income ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'inc_fix'){
					$totals_array_deduction[$key]['inc_fix'][] = $v1;
				}

				//=== Variable income ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'inc_var'){
					$totals_array_deduction[$key]['inc_var'][] = $v1;
				}

				//=== Other income ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'inc_oth'){
					$totals_array_deduction[$key]['inc_oth'][] = $v1;
				}

				//=== Absence ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'ded_abs'){
					$totals_array_deduction[$key]['ded_abs'][] = $v1;
				}

				//=== Fixed deductions ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'ded_fix'){
					$totals_array_deduction[$key]['ded_fix'][] = $v1;
				}

				//=== Variable deductions ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'ded_var'){
					$totals_array_deduction[$key]['ded_var'][] = $v1;
				}

				//=== Other deductions ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'ded_oth'){
					$totals_array_deduction[$key]['ded_oth'][] = $v1;
				}

				//=== Legal deductions / Loans ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'ded_leg'){
					$totals_array_deduction[$key]['ded_leg'][] = $v1;
				}

				//=== Advanced payments ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'ded_pay'){
					$totals_array_deduction[$key]['ded_pay'][] = $v1;
				}

				//=== Total earnings ===//
				if($getAllowandDeductInfo[$k1]['earnings'] == 1){
					$totals_array_deduction[$key]['earnings'][] = $v1;
				}

				//=== Total deductions ===//
				if($getAllowandDeductInfo[$k1]['deductions'] == 1){
					$totals_array_deduction[$key]['deductions'][] = $v1;
				}

				//=== Total PND1 ===//
				if($getAllowandDeductInfo[$k1]['pnd1'] == 1){
					$totals_array_deduction[$key]['pnd1'][] = $v1;
				}

				//=== Total SSO ===//
				if($getAllowandDeductInfo[$k1]['sso'] == 1){
					$totals_array_deduction[$key]['sso'][] = $v1;
				}

				//=== Total PVF ===//
				if($getAllowandDeductInfo[$k1]['pvf'] == 1){
					$totals_array_deduction[$key]['pvf'][] = $v1;
				}

				//=== Total PSF ===//
				if($getAllowandDeductInfo[$k1]['psf'] == 1){
					$totals_array_deduction[$key]['psf'][] = $v1;
				}

				//=== Total Tax income ===//
				if($getAllowandDeductInfo[$k1]['tax_income'] == 1){
					$totals_array_deduction[$key]['tax_income'][] = $v1;
				}

				//=== Tax base (fixpro) ===//
				if($getAllowandDeductInfo[$k1]['tax_base'] == 'fixpro'){
					$totals_array_deduction[$key]['fixpro'][] = $v1;
				}

				//=== Tax base (fix) ===//
				if($getAllowandDeductInfo[$k1]['tax_base'] == 'fix'){
					$totals_array_deduction[$key]['fix'][] = $v1;
				}

				//=== Tax base (var) ===//
				if($getAllowandDeductInfo[$k1]['tax_base'] == 'var'){
					$totals_array_deduction[$key]['var'][] = $v1;
				}

				//=== Tax base (nontax) ===//
				if($getAllowandDeductInfo[$k1]['tax_base'] == 'nontax'){
					$totals_array_deduction[$key]['nontax'][] = $v1;
				}
			}



			if($row['contract_type'] == 'day'){ 
				$employeeAllowadedyctArr = array(27=>$row['tax_by_company'], 28=>$row['sso_by_company'], 29=>$row['severance'], 31=>$row['remaining_salary'], 32=>$row['notice_payment'], 33=>$row['paid_leave'], 47=>$row['savings'], 48=>$row['legal_execution'], 49=>$row['kor_yor_sor'], 56=>$row['mf_salary'], 57=>$row['sso_employee'], 58=>$row['pvf_employee'], 59=>$row['psf_employee'], 60=>$row['tax_this_month']);
			}else{
				$employeeAllowadedyctArr = array(27=>$row['tax_by_company'], 28=>$row['sso_by_company'], 29=>$row['severance'], 31=>$row['remaining_salary'], 32=>$row['notice_payment'], 33=>$row['paid_leave'], 47=>$row['savings'], 48=>$row['legal_execution'], 49=>$row['kor_yor_sor'], 56=>$row['salary'], 57=>$row['sso_employee'], 58=>$row['pvf_employee'], 59=>$row['psf_employee'], 60=>$row['tax_this_month']);
			}

			
			$fixedforMonth = getPayrollfixedAlloDeductMonth($_SESSION['rego']['cur_year'].'_'.$_SESSION['rego']['cur_month']);

			foreach($fixedforMonth as $k1 => $v1) {

				//=== Salary ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'inc_sal'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['inc_sal'][] = $employeeAllowadedyctArr[$k1];
					}else{
						$totals_array[$key]['inc_sal'][] = $employeeAllowadedyctArr[$k1];
					}
				}

				//=== Overtime ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'inc_ot'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['inc_ot'][] = $employeeAllowadedyctArr[$k1];
					}else{
						$totals_array[$key]['inc_ot'][] = $employeeAllowadedyctArr[$k1];
					}
				}

				//=== Fixed income ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'inc_fix'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['inc_fix'][] = $employeeAllowadedyctArr[$k1];
					}else{
						$totals_array[$key]['inc_fix'][] = $employeeAllowadedyctArr[$k1];
					}
				}

				//=== Variable income ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'inc_var'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['inc_var'][] = $employeeAllowadedyctArr[$k1];
					}else{
						$totals_array[$key]['inc_var'][] = $employeeAllowadedyctArr[$k1];
					}
				}

				//=== Other income ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'inc_oth'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['inc_oth'][] = $employeeAllowadedyctArr[$k1];
					}else{
						$totals_array[$key]['inc_oth'][] = $employeeAllowadedyctArr[$k1];
					}
				}

				//=== Absence ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'ded_abs'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['ded_abs'][] = $employeeAllowadedyctArr[$k1];
					}else{
						$totals_array[$key]['ded_abs'][] = $employeeAllowadedyctArr[$k1];
					}
				}

				//=== Fixed deductions ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'ded_fix'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['ded_fix'][] = $employeeAllowadedyctArr[$k1];
					}else{
						$totals_array[$key]['ded_fix'][] = $employeeAllowadedyctArr[$k1];
					}
				}

				//=== Variable deductions ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'ded_var'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['ded_var'][] = $employeeAllowadedyctArr[$k1];
					}else{
						$totals_array[$key]['ded_var'][] = $employeeAllowadedyctArr[$k1];
					}
				}

				//=== Other deductions ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'ded_oth'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['ded_oth'][] = $employeeAllowadedyctArr[$k1];
					}else{
						$totals_array[$key]['ded_oth'][] = $employeeAllowadedyctArr[$k1];
					}
				}

				//=== Legal deductions / Loans ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'ded_leg'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['ded_leg'][] = $employeeAllowadedyctArr[$k1];
					}else{
						$totals_array[$key]['ded_leg'][] = $employeeAllowadedyctArr[$k1];
					}
				}

				//=== Advanced payments ===//
				if($getAllowandDeductInfo[$k1]['group'] == 'ded_pay'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['ded_pay'][] = $employeeAllowadedyctArr[$k1];
					}else{
						$totals_array[$key]['ded_pay'][] = $employeeAllowadedyctArr[$k1];
					}
				}

				//=== Total earnings ===//
				if($getAllowandDeductInfo[$k1]['earnings'] == 1){
					$totals_array[$key]['earnings'][] = $employeeAllowadedyctArr[$k1];
				}

				//=== Total deductions ===//
				if($getAllowandDeductInfo[$k1]['deductions'] == 1){
					$totals_array[$key]['deductions'][] = $employeeAllowadedyctArr[$k1];
				}

				//=== Total PND1 ===//
				if($getAllowandDeductInfo[$k1]['pnd1'] == 1){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['pnd1'][] = $employeeAllowadedyctArr[$k1];
					}else{
						$totals_array[$key]['pnd1'][] = $employeeAllowadedyctArr[$k1];
					}
				}

				//=== Total SSO ===//
				if($getAllowandDeductInfo[$k1]['sso'] == 1){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['sso'][] = $employeeAllowadedyctArr[$k1];
					}else{
						$totals_array[$key]['sso'][] = $employeeAllowadedyctArr[$k1];
					}
				}

				//=== Total PVF ===//
				if($getAllowandDeductInfo[$k1]['pvf'] == 1){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['pvf'][] = $employeeAllowadedyctArr[$k1];
					}else{
						$totals_array[$key]['pvf'][] = $employeeAllowadedyctArr[$k1];
					}
				}

				//=== Total PSF ===//
				if($getAllowandDeductInfo[$k1]['psf'] == 1){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['psf'][] = $employeeAllowadedyctArr[$k1];
					}else{
						$totals_array[$key]['psf'][] = $employeeAllowadedyctArr[$k1];
					}
				}

				//=== Total Tax income ===//
				if($getAllowandDeductInfo[$k1]['tax_income'] == 1){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['tax_income'][] = $employeeAllowadedyctArr[$k1];
					}else{
						$totals_array[$key]['tax_income'][] = $employeeAllowadedyctArr[$k1];
					}
				}

				//=== Tax base (fixpro) ===//
				if($getAllowandDeductInfo[$k1]['tax_base'] == 'fixpro'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['fixpro'][] = $employeeAllowadedyctArr[$k1];
					}else{
						$totals_array[$key]['fixpro'][] = $employeeAllowadedyctArr[$k1];
					}
				}

				//=== Tax base (fix) ===//
				if($getAllowandDeductInfo[$k1]['tax_base'] == 'fix'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['fix'][] = $employeeAllowadedyctArr[$k1];
					}else{
						$totals_array[$key]['fix'][] = $employeeAllowadedyctArr[$k1];
					}
				}

				//=== Tax base (var) ===//
				if($getAllowandDeductInfo[$k1]['tax_base'] == 'var'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['var'][] = $employeeAllowadedyctArr[$k1];
					}else{
						$totals_array[$key]['var'][] = $employeeAllowadedyctArr[$k1];
					}
				}

				//=== Tax base (nontax) ===//
				if($getAllowandDeductInfo[$k1]['tax_base'] == 'nontax'){
					if($getAllowandDeductInfo[$k1]['classification'] == 1){
						$totals_array_deduction[$key]['nontax'][] = $employeeAllowadedyctArr[$k1];
					}else{
						$totals_array[$key]['nontax'][] = $employeeAllowadedyctArr[$k1];
					}
				}
			}


			/*echo '<pre>';
			print_r($totals_array);
			print_r($totals_array_deduction);
			echo '</pre>';

			die('sdsdsdsd');*/


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
			$absence_group_total = $absence_group_total0 - $absence_group_total1;

			//fix_ded_income group
			$fix_ded_group_total0 = isset($totals_array[$key]['ded_fix']) ? array_sum($totals_array[$key]['ded_fix']) : 0;
			$fix_ded_group_total1 = isset($totals_array_deduction[$key]['ded_fix']) ? array_sum($totals_array_deduction[$key]['ded_fix']) : 0;
			$fix_ded_group_total = $fix_ded_group_total0 - $fix_ded_group_total1;

			//var_ded_income group
			$var_ded_group_total0 = isset($totals_array[$key]['ded_var']) ? array_sum($totals_array[$key]['ded_var']) : 0;
			$var_ded_group_total1 = isset($totals_array_deduction[$key]['ded_var']) ? array_sum($totals_array_deduction[$key]['ded_var']) : 0;
			$var_ded_group_total = $var_ded_group_total0 - $var_ded_group_total1;

			//oth_ded_income group
			$other_ded_group_total0 = isset($totals_array[$key]['ded_oth']) ? array_sum($totals_array[$key]['ded_oth']) : 0;
			$other_ded_group_total1 = isset($totals_array_deduction[$key]['ded_oth']) ? array_sum($totals_array_deduction[$key]['ded_oth']) : 0;
			$other_ded_group_total = $other_ded_group_total0 - $other_ded_group_total1;

			//legal_ded_income group
			$legal_ded_group_total0 = isset($totals_array[$key]['ded_leg']) ? array_sum($totals_array[$key]['ded_leg']) : 0;
			$legal_ded_group_total1 = isset($totals_array_deduction[$key]['ded_leg']) ? array_sum($totals_array_deduction[$key]['ded_leg']) : 0;
			$legal_ded_group_total = $legal_ded_group_total0 - $legal_ded_group_total1;

			//advance_ded_income group
			$advance_pay_group_total0 = isset($totals_array[$key]['ded_pay']) ? array_sum($totals_array[$key]['ded_pay']) : 0;
			$advance_pay_group_total1 = isset($totals_array_deduction[$key]['ded_pay']) ? array_sum($totals_array_deduction[$key]['ded_pay']) : 0;
			$advance_pay_group_total = $advance_pay_group_total0 - $advance_pay_group_total1;

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
			$total_tax_nontax = $total_tax_nontax0 - $total_tax_nontax1;

			$total_of_alltax = $total_tax_fixpro + $total_tax_fix + $total_tax_var;

			$total_net_income = ($salary_group_total + $overtime_group_total + $fix_income_group_total + $var_income_group_total + $other_income_group_total) - ($absence_group_total + $fix_ded_group_total + $var_ded_group_total + $other_ded_group_total);
			$total_net_pay = $total_net_income - $advance_pay_group_total - $legal_ded_group_total;

			
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
			$get_months = ((12 - (int)$emp_joining_date) + 1);

			$fixed_prorated_yearly = $total_tax_fixpro * $get_months;
			$fixed_yearly = $fixed_prorated_yearly + $total_tax_fix;

			$fixed_actual_prorated_yearly = ($total_tax_fixpro_prev + $total_tax_fixpro) * $remaining_months;
			$fixed_actual_yearly = $fixed_actual_prorated_yearly + $total_tax_fix_prev + $total_tax_fix;

			$variable_prev = $total_tax_var_prev;
			$variable_curr = $total_tax_var;

			$income_YTD = $total_of_alltax_prev + $total_of_alltax;


			//============ Yearly Tax Deduction ================//
			$total_yearly_standard_deduction = $row['tax_standard_deduction'];
			if($row['calc_on_sd'] == 1){
				$calc_standard_deduction = ($fixed_actual_yearly * (50/100));
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
				$total_yearly_personal_care = ($total_pvf_prev + $total_pvf) * $remaining_months;
			}

			$personal_care_manual = $row['personal_care_manual'];
			$personal_care_total = $total_yearly_personal_care + $personal_care_manual;

			$total_yearly_provident_fund = $row['tax_allow_pvf'];
			if($row['calc_on_pf'] == 1){
				$calc_provident_fund = ($fixed_actual_yearly * (40/100));
				if($calc_provident_fund <= 60000){
					$total_yearly_provident_fund = $calc_provident_fund;
				}else{
					$total_yearly_provident_fund = 60000;
				}
			}

			$allow_pvf_manual = $row['allow_pvf_manual'];
			$allow_pvf_total = $total_yearly_provident_fund + $allow_pvf_manual;


			$total_yearly_social_security_fund = $row['tax_allow_sso'];
			if($row['calc_on_ssf'] == 1){

				$calc_comming_month_sso = 0;
				$monthss = (int)$cur_month + 1;
				for ($i=$monthss; $i <= 12; $i++) { 
					$calc_comming_month_sso += $total_sso * $pperiods[$i]['sso_eRate'];
				}
				
				$total_yearly_social_security_fund = $total_sso_prev + $total_sso + $calc_comming_month_sso;
			}

			$allow_sso_manual = $row['allow_sso_manual'];
			$allow_sso_total = $total_yearly_social_security_fund + $allow_sso_manual;


			$total_other_tax_deductions = $row['total_other_tax_deductions'];
			$total_yearly_tax_deductions = ($standard_deduction_total + $personal_care_total + $allow_pvf_total + $allow_sso_total + $total_other_tax_deductions);
			$total_yearly_tax_deductions = round($total_yearly_tax_deductions,2);

			//=============== Add extra item in Other income/deduction ==================//
			$other_income_group_total = $other_income_group_total + $sso_by_company;
			$other_ded_group_total = $other_ded_group_total + $sso_employee + $pvf_employee + $psf_employee;

			//=============== Total Earnings and deduction ==============================//
			$total_earnings = $salary_group_total + $overtime_group_total + $fix_income_group_total + $var_income_group_total + $other_income_group_total;
			$total_earnings = round($total_earnings,2);
			$total_deductions = $absence_group_total + $fix_ded_group_total + $var_ded_group_total + $other_ded_group_total + $legal_ded_group_total + $advance_pay_group_total;
			$total_deductions = round($total_deductions,2);


			//=============== Full Year totals calculations =============================//
			if($getAllowDeductAllLinkedInfo['inc_sal']['tax_base'] == 'fixpro'){
				$full_year_salary_grp = ($salary_group_total_prev + ($salary_group_total * $remaining_months));
			}else{
				$full_year_salary_grp = ($salary_group_total_prev + $salary_group_total);
			}

			if($getAllowDeductAllLinkedInfo['inc_ot']['tax_base'] == 'fixpro'){
				$full_year_overtime_grp = ($overtime_group_total_prev + ($overtime_group_total * $remaining_months));
			}else{
				$full_year_overtime_grp = ($overtime_group_total_prev + $overtime_group_total);
			}

			if($getAllowDeductAllLinkedInfo['inc_fix']['tax_base'] == 'fixpro'){
				$full_year_fixincome_grp = ($fix_income_group_total_prev + ($fix_income_group_total * $remaining_months));
			}else{
				$full_year_fixincome_grp = ($fix_income_group_total_prev + $fix_income_group_total);
			}

			if($getAllowDeductAllLinkedInfo['inc_var']['tax_base'] == 'fixpro'){
				$full_year_varincome_grp = ($var_income_group_total_prev + ($var_income_group_total * $remaining_months));
			}else{
				$full_year_varincome_grp = ($var_income_group_total_prev + $var_income_group_total);
			}

			if($getAllowDeductAllLinkedInfo['inc_oth']['tax_base'] == 'fixpro'){
				$full_year_othincome_grp = ($other_income_group_total_prev + ($other_income_group_total * $remaining_months));
			}else{
				$full_year_othincome_grp = ($other_income_group_total_prev + $other_income_group_total);
			}

			if($getAllowDeductAllLinkedInfo['ded_abs']['tax_base'] == 'fixpro'){
				$full_year_absence_grp = ($absence_group_total_prev + ($absence_group_total * $remaining_months));
			}else{
				$full_year_absence_grp = ($absence_group_total_prev + $absence_group_total);
			}

			if($getAllowDeductAllLinkedInfo['ded_fix']['tax_base'] == 'fixpro'){
				$full_year_fixded_grp = ($fix_ded_group_total_prev + ($fix_ded_group_total * $remaining_months));
			}else{
				$full_year_fixded_grp = ($fix_ded_group_total_prev + $fix_ded_group_total);
			}

			if($getAllowDeductAllLinkedInfo['ded_var']['tax_base'] == 'fixpro'){
				$full_year_varded_grp = ($var_ded_group_total_prev + ($var_ded_group_total * $remaining_months));
			}else{
				$full_year_varded_grp = ($var_ded_group_total_prev + $var_ded_group_total);
			}

			if($getAllowDeductAllLinkedInfo['ded_oth']['tax_base'] == 'fixpro'){
				$full_year_othded_grp = ($other_ded_group_total_prev + ($other_ded_group_total * $remaining_months));
			}else{
				$full_year_othded_grp = ($other_ded_group_total_prev + $other_ded_group_total);
			}

			if($getAllowDeductAllLinkedInfo['ded_leg']['tax_base'] == 'fixpro'){
				$full_year_legal_grp = ($legal_ded_group_total_prev + ($legal_ded_group_total * $remaining_months));
			}else{
				$full_year_legal_grp = ($legal_ded_group_total_prev + $legal_ded_group_total);
			}

			if($getAllowDeductAllLinkedInfo['ded_pay']['tax_base'] == 'fixpro'){
				$full_year_advpay_grp = ($advance_pay_group_total_prev + ($advance_pay_group_total * $remaining_months));
			}else{
				$full_year_advpay_grp = ($advance_pay_group_total_prev + $advance_pay_group_total);
			}

			//================ Full Year Tax Base calculations ====================//
			$full_year_fixprorated = ($total_tax_fixpro_prev + ($total_tax_fixpro * $remaining_months));
			$full_year_fixed = $total_tax_fix_prev + $total_tax_fix;
			$full_year_var = $total_tax_var_prev + $total_tax_var;
			$full_year_taxableincome = $total_of_alltax_prev + $total_of_alltax;
			$full_year_non_taxable = $total_tax_nontax_prev + $total_tax_nontax;

			//================ Full Year SSO/PVF/PSF calculation ==================//
			$full_year_sso_employee = $sso_employee_prev + $sso_employee;
			$full_year_sso_by_company = $sso_by_company_prev + $sso_by_company;
			$full_year_pvf_employee = $pvf_employee_prev + $pvf_employee;
			$full_year_psf_employee = $psf_employee_prev + $psf_employee;

			$full_year_pnd = $total_pnd1_prev + $total_pnd1;
			$full_year_sso = $total_sso_prev + $total_sso;
			$full_year_pvf = $total_pvf_prev + $total_pvf;
			$full_year_psf = $total_psf_prev + $total_psf;

			//=============== Full Year Earnings and deduction ==============================//
			$full_year_earnings = $full_year_salary_grp + $full_year_overtime_grp + $full_year_fixincome_grp + $full_year_varincome_grp + $full_year_othincome_grp;
			$full_year_deductions = $full_year_absence_grp + $full_year_fixded_grp + $full_year_varded_grp + $full_year_othded_grp + $full_year_legal_grp + $full_year_advpay_grp;

			$full_year_earnings = round($full_year_earnings,2);
			$full_year_deductions = round($full_year_deductions,2);

			$total_net_income_prev = ($salary_group_total_prev + $overtime_group_total_prev + $fix_income_group_total_prev + $var_income_group_total_prev + $other_income_group_total_prev) - ($absence_group_total_prev + $fix_ded_group_total_prev + $var_ded_group_total_prev + $other_ded_group_total_prev);
			$total_net_pay_prev = $total_net_income_prev - $legal_ded_group_total_prev - $advance_pay_group_total_prev;

			$fullyear_net_income = ($full_year_salary_grp + $full_year_overtime_grp + $full_year_fixincome_grp + $full_year_varincome_grp + $full_year_othincome_grp) - ($full_year_absence_grp + $full_year_fixded_grp + $full_year_varded_grp + $full_year_othded_grp);
			$fullyear_net_pay = $fullyear_net_income - $full_year_legal_grp - $full_year_advpay_grp;

			//================ TAX Claculation =============================//
			$sso_year = $allow_sso_total;
			$pvf_year = $allow_pvf_total;
			if($row['sso_by']){$sso = $sso_year;}else{$sso = 0;}

			//============== Year income ===================
			$acm_fix = $fixed_actual_yearly - $total_deductions;
			//if($acm_fix < 0){ $acm_fix = 0; }
			$acm_fix_prev = $acm_fix + $variable_prev;
			//if($acm_fix_prev < 0){ $acm_fix_prev = 0; }
			$acm_fix_prev_var = $acm_fix_prev + $variable_curr;
			//if($acm_fix_prev_var < 0){ $acm_fix_prev_var = 0; }

			$cam_fix = $fixed_yearly - $total_deductions;
			//if($cam_fix < 0){ $cam_fix = 0; }
			$cam_fix_prev = $cam_fix + $variable_prev;
			//if($cam_fix_prev < 0){ $cam_fix_prev = 0; }
			$cam_fix_prev_var = $cam_fix_prev + $variable_curr;
			//if($cam_fix_prev_var < 0){ $cam_fix_prev_var = 0; }

			$ytd_income = $income_YTD - $total_deductions;
			//if($ytd_income < 0){ $ytd_income = 0; }

			//============= Year tax calculation ================
			$acm_fix_tax_calc = calculateAnualTax($acm_fix, $row['calc_base'], $sso, $pvf_year);
			$acm_fix_prev_tax_calc = calculateAnualTax($acm_fix_prev, $row['calc_base'], $sso, $pvf_year);
			$acm_fix_prev_var_tax_calc = calculateAnualTax($acm_fix_prev_var, $row['calc_base'], $sso, $pvf_year);

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
					$tax_fix_month = ($tax_remaining - $tax_var_month) / $remaining_months_without_curr;
					if($tax_fix_month < 0){ $tax_fix_month = 0; }
					$tax_this_month = $tax_fix_month + $tax_var_month;
					if($tax_this_month < 0){ $tax_this_month = 0; }
					$tax_tot_next_month = $total_tax_year - $tax_previous - $tax_this_month;
					if($tax_tot_next_month < 0){ $tax_tot_next_month = 0; }
					$tax_next_month = $tax_tot_next_month / ($remaining_months_without_curr - 1);
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
					$tax_fix_month = ($tax_remaining - $tax_var_month) / $remaining_months_without_curr;
					if($tax_fix_month < 0){ $tax_fix_month = 0; }
					$tax_this_month = $tax_fix_month + $tax_var_month;
					if($tax_this_month < 0){ $tax_this_month = 0; }
					$tax_tot_next_month = $total_tax_year - $tax_previous - $tax_this_month;
					if($tax_tot_next_month < 0){ $tax_tot_next_month = 0; }
					$tax_next_month = $tax_tot_next_month / ($remaining_months_without_curr - 1);
					if($tax_next_month < 0){ $tax_next_month = 0; }
				}
			}

			$total_tax_year = round($total_tax_year,2);
			$tax_previous = round($tax_previous,2);
			$tax_remaining = round($tax_remaining,2);
			$tax_fix_month = round($tax_fix_month,2);
			$tax_var_month = round($tax_var_month,2);
			$tax_this_month = round($tax_this_month,2);
			$tax_next_month = round($tax_next_month,2);
			$tax_tot_next_month = round($tax_tot_next_month,2);

			$tax_by_company = 0;
			$sso_by_company = 0;

			if($row['calc_base'] == 'gross'){
				//$net_month = $gross_income_month - $tot_deductions;
				if($row['sso_by']){
					$sso_by_company = $sso_employee;
					//$net_month += $sso_employee;
				}
			}else{
				//$net_month = $gross_income_month;
				//$gross_income_month += $tax_this_month;
				if($row['sso_by']){
					//$gross_income_month += $sso_employee;
					$sso_by_company = $sso_employee;
				}else{
					//$net_month -= $sso_employee;
				}
				$tax_by_company = $tax_this_month;
			}

			$upsql = "UPDATE ".$sessionpayrollDbase." SET `salary_group_total`='".$salary_group_total."', `overtime_group_total`='".$overtime_group_total."', `fix_income_group_total`='".$fix_income_group_total."', `var_income_group_total`='".$var_income_group_total."', `other_income_group_total`='".$other_income_group_total."', `absence_group_total`= '".$absence_group_total."', `fix_ded_group_total`='".$fix_ded_group_total."', `var_ded_group_total`='".$var_ded_group_total."', `other_ded_group_total`='".$other_ded_group_total."', `legal_ded_group_total`='".$legal_ded_group_total."', `advance_pay_group_total`='".$advance_pay_group_total."', `total_earnings`='".$total_earnings."', `total_deductions`='".$total_deductions."', `total_pnd1`='".$total_pnd1."', `total_sso`='".$total_sso."', `total_pvf`='".$total_pvf."', `total_psf`='".$total_psf."', `total_tax_income` = '".$total_tax_income."', `total_tax_fixpro`='".$total_tax_fixpro."', `total_tax_fix`='".$total_tax_fix."', `total_tax_var`='".$total_tax_var."', `total_tax_nontax`='".$total_tax_nontax."', `total_of_alltax`='".$total_of_alltax."', `sso_emp_calc` = '".$sso_emp."', `sso_comp_calc` = '".$sso_com."', `sso_employee`='".$sso_employee."', `sso_company`='".$sso_company."', `pvf_emp_calc`='".$pvf_emp."', `pvf_comp_calc`='".$pvf_com."', `pvf_employee`='".$pvf_employee."', `pvf_company`='".$pvf_company."', `psf_emp_calc`='".$psf_emp."', `psf_comp_calc`='".$psf_com."', `psf_employee`='".$psf_employee."', `psf_company`='".$psf_company."', `salary_group_total_prev`='".$salary_group_total_prev."', `overtime_group_total_prev`='".$overtime_group_total_prev."', `fix_income_group_total_prev`='".$fix_income_group_total_prev."', `var_income_group_total_prev`='".$var_income_group_total_prev."', `other_income_group_total_prev`='".$other_income_group_total_prev."', `absence_group_total_prev`='".$absence_group_total_prev."', `fix_ded_group_total_prev`='".$fix_ded_group_total_prev."', `var_ded_group_total_prev`='".$var_ded_group_total_prev."', `other_ded_group_total_prev`='".$other_ded_group_total_prev."', `legal_ded_group_total_prev`='".$legal_ded_group_total_prev."', `advance_pay_group_total_prev`='".$advance_pay_group_total_prev."', `total_earnings_prev`='".$total_earnings_prev."', `total_deductions_prev`='".$total_deductions_prev."', `total_pnd1_prev`='".$total_pnd1_prev."', `total_sso_prev`='".$total_sso_prev."', `total_pvf_prev`='".$total_pvf_prev."', `total_psf_prev`='".$total_psf_prev."', `total_tax_income_prev`='".$total_tax_income_prev."', `total_tax_fixpro_prev`='".$total_tax_fixpro_prev."', `total_tax_fix_prev`='".$total_tax_fix_prev."', `total_tax_var_prev`='".$total_tax_var_prev."', `total_tax_nontax_prev`='".$total_tax_nontax_prev."', `total_of_alltax_prev`='".$total_of_alltax_prev."', `fixed_prorated_yearly`='".$fixed_prorated_yearly."', `fixed_yearly`='".$fixed_yearly."', `fixed_actual_prorated_yearly`='".$fixed_actual_prorated_yearly."', `fixed_actual_yearly`='".$fixed_actual_yearly."', `variable_prev`='".$variable_prev."', `variable_curr`='".$variable_curr."', `income_YTD`='".$income_YTD."', `tax_standard_deduction`='".$total_yearly_standard_deduction."', `standard_deduction_manual`='".$standard_deduction_manual."', `standard_deduction_total`='".$standard_deduction_total."', `tax_personal_allowance`='".$total_yearly_personal_care."', `personal_care_manual`='".$personal_care_manual."', `personal_care_total`='".$personal_care_total."', `tax_allow_pvf`='".$total_yearly_provident_fund."', `allow_pvf_manual`='".$allow_pvf_manual."', `allow_pvf_total`='".$allow_pvf_total."', `tax_allow_sso`='".$total_yearly_social_security_fund."', `allow_sso_manual`='".$allow_sso_manual."', `allow_sso_total`='".$allow_sso_total."', `total_other_tax_deductions` ='".$total_other_tax_deductions."', `total_yearly_tax_deductions`='".$total_yearly_tax_deductions."', `tax_by_company`='".$tax_by_company."', `sso_by_company`='".$sso_by_company."', `sso_by_company_prev`='".$sso_by_company_prev."', `sso_employee_prev`='".$sso_employee_prev."', `pvf_employee_prev`='".$pvf_employee_prev."', `psf_employee_prev`='".$psf_employee_prev."', `full_year_salary_grp`='".$full_year_salary_grp."', `full_year_overtime_grp`='".$full_year_overtime_grp."', `full_year_fixincome_grp`='".$full_year_fixincome_grp."', `full_year_varincome_grp`='".$full_year_varincome_grp."', `full_year_othincome_grp`='".$full_year_othincome_grp."', `full_year_absence_grp`='".$full_year_absence_grp."', `full_year_fixded_grp`='".$full_year_fixded_grp."', `full_year_varded_grp`='".$full_year_varded_grp."', `full_year_othded_grp`='".$full_year_othded_grp."', `full_year_legal_grp`='".$full_year_legal_grp."', `full_year_advpay_grp`='".$full_year_advpay_grp."', `full_year_fixprorated`='".$full_year_fixprorated."', `full_year_fixed`='".$full_year_fixed."', `full_year_var`='".$full_year_var."', `full_year_taxableincome`='".$full_year_taxableincome."', `full_year_non_taxable`='".$full_year_non_taxable."', `full_year_sso_employee`='".$full_year_sso_employee."', `full_year_sso_by_company`='".$full_year_sso_by_company."', `full_year_pvf_employee`='".$full_year_pvf_employee."', `full_year_psf_employee`='".$full_year_psf_employee."', `full_year_pnd`='".$full_year_pnd."', `full_year_sso`='".$full_year_sso."', `full_year_pvf`='".$full_year_pvf."', `full_year_psf`='".$full_year_psf."', `full_year_earnings`='".$full_year_earnings."', `full_year_deductions`='".$full_year_deductions."', `acm_fix`='".$acm_fix."', `acm_fix_prev`='".$acm_fix_prev."', `acm_fix_prev_var`='".$acm_fix_prev_var."', `cam_fix`='".$cam_fix."', `cam_fix_prev`='".$cam_fix_prev."', `cam_fix_prev_var`='".$cam_fix_prev_var."', `ytd_income`='".$ytd_income."', `acm_fix_tax_calc`='".$acm_fix_tax_calc."', `acm_fix_prev_tax_calc`='".$acm_fix_prev_tax_calc."', `acm_fix_prev_var_tax_calc`='".$acm_fix_prev_var_tax_calc."', `cam_fix_tax_calc`='".$cam_fix_tax_calc."', `cam_fix_prev_tax_calc`='".$cam_fix_prev_tax_calc."', `cam_fix_prev_var_tax_calc`='".$cam_fix_prev_var_tax_calc."', `tax_ytd`='".$tax_ytd."', `total_tax_year`='".$total_tax_year."', `tax_previous`='".$tax_previous."', `tax_remaining`='".$tax_remaining."', `tax_fix_month`='".$tax_fix_month."', `tax_var_month`='".$tax_var_month."', `tax_this_month`='".$tax_this_month."', `tax_next_month`='".$tax_next_month."', `tax_tot_next_month`='".$tax_tot_next_month."', `total_net_income`= '".$total_net_income."', `total_net_pay`='".$total_net_pay."', `total_net_income_prev`='".$total_net_income_prev."', `total_net_pay_prev`='".$total_net_pay_prev."', `fullyear_net_income`='".$fullyear_net_income."', `fullyear_net_pay`='".$fullyear_net_pay."' WHERE `emp_id` = '".$key."' AND `payroll_modal_id`='".$_REQUEST['mid']."' AND `month` = '".$_SESSION['rego']['cur_month']."' ";
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