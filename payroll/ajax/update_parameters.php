<?php
	
	if(session_id()==''){session_start();}
	ob_start();
	include('../../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');

	$getAttendAllowDeduct = getAttendAllowDeduct();
	$getEmployeeFixedCalc = getEmployeeFixedCalc();
	$getEmployeeAllowDeduct = getEmployeeAllowDeduct();

	//=== Fixed allowances & Deductions Employee Register Fixed
	if(isset($getAttendAllowDeduct) && is_array($getAttendAllowDeduct)){ 
		foreach($getAttendAllowDeduct as $row){
			if($row['fixed_calc'] == 1){
				//echo $row['id'];
				$checkrowdf = $dbc->query("SELECT * FROM ".$cid."_payroll_parameters_".$_SESSION['rego']['cur_year']." WHERE month='".$_SESSION['rego']['cur_month']."' AND itemid='".$row['id']."' ");
				if($checkrowdf->num_rows > 0){

				}else{

					$sql11 = "INSERT INTO ".$cid."_payroll_parameters_".$_SESSION['rego']['cur_year']." (`month`, `itemid`, `groups`, `tax_base`, `pnd`, `sso`, `pvfpsf`) VALUES ('".$_SESSION['rego']['cur_month']."', '".$row['id']."', '".$row['groups']."', '".$row['tax_base']."', '".$row['pnd1']."', '".$row['sso']."', '".$row['pvf']."')";
					$dbc->query($sql11);
				}
			}
		}
	}

	//=== Fixed Allowances & Deductions Emp. Register Man
	if(isset($getEmployeeAllowDeduct) && is_array($getEmployeeAllowDeduct)){ 
		foreach($getEmployeeAllowDeduct as $row){
			
			$checkrowdf = $dbc->query("SELECT * FROM ".$cid."_payroll_parameters_".$_SESSION['rego']['cur_year']." WHERE month='".$_REQUEST['month']."' AND itemid='".$row['id']."' ");
			if($checkrowdf->num_rows > 0){
				
			}else{

				$sql11 = "INSERT INTO ".$cid."_payroll_parameters_".$_SESSION['rego']['cur_year']." (`month`, `itemid`, `groups`, `tax_base`, `pnd`, `sso`, `pvfpsf`) VALUES ('".$_REQUEST['month']."', '".$row['id']."', '".$row['groups']."', '".$row['tax_base']."', '".$row['pnd1']."', '".$row['sso']."', '".$row['pvf']."')";
				$dbc->query($sql11);
			}
		}
	}


	//============== Save data in Payroll Month table ======================//
	$checkSqllpm = $dbc->query("SELECT * FROM ".$cid."_payroll_months WHERE month='".$_SESSION['rego']['cur_year'].'_'.$_SESSION['rego']['cur_month']."'");
	if($checkSqllpm->num_rows > 0){
		$pmdata = $checkSqllpm->fetch_assoc();

		$allowDeductEmpRegFixed = $pmdata['allowDeductEmpRegFixed'];
		if($pmdata['allowDeductEmpRegFixed'] == ''){
			$allowDeductEmpRegFixed = serialize($getEmployeeFixedCalc);
		}

		$allowDeductEmpRegManual = $pmdata['allowDeductEmpRegManual'];
		if($pmdata['allowDeductEmpRegManual'] == ''){
			$allowDeductEmpRegManual = serialize($getEmployeeAllowDeduct);
		}

		$upsql = "UPDATE ".$cid."_payroll_months SET allowDeductEmpRegFixed='".$allowDeductEmpRegFixed."', allowDeductEmpRegManual= '".$allowDeductEmpRegManual."' WHERE month='".$_SESSION['rego']['cur_year'].'_'.$_SESSION['rego']['cur_month']."' ";
		$dbc->query($upsql);
	}
	//============== Save data in Payroll Month table ======================//

	
	//============== Save Parameter tab info ======================//
	$upsql = "UPDATE ".$cid."_payroll_months SET payroll_opt='".$_REQUEST['payroll_opt']."', salary_split= '".$_REQUEST['salary_split']."' , paid='".serialize($_REQUEST['paid'])."' WHERE month='".$_SESSION['rego']['cur_year'].'_'.$_SESSION['rego']['cur_month']."' ";
	$dbc->query($upsql);
	//============== Save Parameter tab info ======================//


	foreach($_REQUEST['itemid'] as $key => $value) {

		if(isset($_REQUEST['allowopt'][$value])){ $allowopt = implode(',',$_REQUEST['allowopt'][$value]); }else{ $allowopt = '';}
		if(isset($_REQUEST['calcOpt'][$value])){ $calcOpt = $_REQUEST['calcOpt'][$value]; }else{ $calcOpt = '';}
		if(isset($_REQUEST['nrhrs'][$value])){ $nrhrs = $_REQUEST['nrhrs'][$value]; }else{ $nrhrs = '';}
		if(isset($_REQUEST['income_base'][$value])){ $income_base = $_REQUEST['income_base'][$value]; }else{ $income_base = '';}
		if(isset($_REQUEST['thbunit'][$value])){ $thbunit = $_REQUEST['thbunit'][$value]; }else{ $thbunit = '';}
		if(isset($_REQUEST['unitarr'][$value])){ $unitarr = $_REQUEST['unitarr'][$value]; }else{ $unitarr = '';}
		if(isset($_REQUEST['nrdays'][$value])){ $nrdays = $_REQUEST['nrdays'][$value]; }else{ $nrdays = '';}

		if(isset($_REQUEST['groups'][$value])){ $groups = $_REQUEST['groups'][$value]; }else{ $groups = '';}
		if(isset($_REQUEST['tax_base'][$value])){ $tax_base = $_REQUEST['tax_base'][$value]; }else{ $tax_base = '';}
		if(isset($_REQUEST['pnd'][$value])){ $pnd = $_REQUEST['pnd'][$value]; }else{ $pnd = '';}
		if(isset($_REQUEST['sso'][$value])){ $sso = $_REQUEST['sso'][$value]; }else{ $sso = '';}
		if(isset($_REQUEST['pvfpsf'][$value])){ $pvfpsf = $_REQUEST['pvfpsf'][$value]; }else{ $pvfpsf = '';}
		if(isset($_REQUEST['multiplicator'][$value])){ $multiplicator = $_REQUEST['multiplicator'][$value]; }else{ $multiplicator = '';}
		
		$checkrow = $dbc->query("SELECT * FROM ".$cid."_payroll_parameters_".$_SESSION['rego']['cur_year']." WHERE month='".$_REQUEST['month']."' AND itemid='".$value."' ");
		if($checkrow->num_rows > 0){

			$sql = "UPDATE ".$cid."_payroll_parameters_".$_SESSION['rego']['cur_year']." SET groups='".$groups."', tax_base='".$tax_base."', pnd='".$pnd."', sso='".$sso."', pvfpsf='".$pvfpsf."', `allowopt`='".$allowopt."', `calcOpt`='".$calcOpt."', multiplicator='".$multiplicator."', `nrdays`='".$nrdays."', `nrhrs`='".$nrhrs."', `income_base`='".$income_base."', `thbunit`='".$thbunit."', `unitarr`='".$unitarr."' WHERE month='".$_REQUEST['month']."' AND itemid='".$value."' ";
			$dbc->query($sql);

		}else{

			$sql = "INSERT INTO ".$cid."_payroll_parameters_".$_SESSION['rego']['cur_year']." (`month`, `itemid`, `groups`, `tax_base`, `pnd`, `sso`, `pvfpsf`, `allowopt`, `calcOpt`, `multiplicator`, `nrdays`, `nrhrs`, `income_base`, `thbunit`, `unitarr`) VALUES ('".$_REQUEST['month']."', '".$value."', '".$groups."', '".$tax_base."', '".$pnd."', '".$sso."', '".$pvfpsf."', '".$allowopt."', '".$calcOpt."', '".$multiplicator."', '".$nrdays."', '".$nrhrs."', '".$income_base."', '".$thbunit."', '".$unitarr."')";
			$dbc->query($sql);
		}
	}

	ob_clean();
	echo 'success';
?>