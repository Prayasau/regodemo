<?php
	if(session_id()==''){session_start(); ob_start();}
	include('../../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	include(DIR.'files/payroll_functions.php');
	$att_cols = array();
	$cols = array();

	$getonlyapplyAllowDeduct = getonlyapplyAllowDeduct();

	// section 0
	$section0[5] =  array('basic_salary');
	$countItem = 6;
	foreach ($getonlyapplyAllowDeduct as $key => $value) {
		$section0[$countItem] =  array($value['en']); $countItem++;
	}
	
	//$section0[7] =  array('Transport');
	//$section0[8] =  array('Position');
	//$section0[9] =  array('Pay back loan');
	//$section0[10] = array('Equipment');
	
	// section 1
	$section1[$countItem] =  array('calc_tax'); $countItem++;
	$section1[$countItem] =  array('calc_sso'); $countItem++;
	$section1[$countItem] =  array('calc_pvf'); $countItem++;
	$section1[$countItem] =  array('calc_psf'); $countItem++;
	$section1[$countItem] =  array('calc_method'); $countItem++;
	$section1[$countItem] =  array('modify_tax'); $countItem++;
	$section1[$countItem] =  array('pvf_pr_thb'); $countItem++;
	$section1[$countItem] =  array('psf_pr_thb'); $countItem++;
	$section1[$countItem] =  array('pvf_rate_emp'); $countItem++;
	$section1[$countItem] =  array('pvf_rate_com'); $countItem++;
	$section1[$countItem] =  array('psf_rate_emp'); $countItem++;
	$section1[$countItem] =  array('psf_rate_com'); $countItem++;
	$section1[$countItem] =  array('contract_type'); $countItem++;
	$section1[$countItem] =  array('calc_base'); $countItem++;
	$section1[$countItem] =  array('sso_by'); $countItem++;


	// section 2
	$section2[$countItem] =  array('Standard deduction'); $countItem++;
	$section2[$countItem] =  array('Personal care'); $countItem++;
	$section2[$countItem] =  array('Provident fund'); $countItem++;
	$section2[$countItem] =  array('Social Security Fund'); $countItem++;
	$section2[$countItem] =  array('Other Deduction'); $countItem++;

	// section 3
	$section3[$countItem] =  array('Government house banking'); $countItem++;
	$section3[$countItem] =  array('Savings'); $countItem++;
	$section3[$countItem] =  array('Legal execution deduction'); $countItem++;
	$section3[$countItem] =  array('Kor.Yor.Sor (Student loan)'); $countItem++;

	// section 4
	$section4[$countItem] =  array('remaining_salary'); $countItem++;
	$section4[$countItem] =  array('notice_payment'); $countItem++;
	$section4[$countItem] =  array('paid_leave'); $countItem++;
	$section4[$countItem] =  array('severance'); $countItem++;
	$section4[$countItem] =  array('legal_deductions'); $countItem++;
	$section4[$countItem] =  array('other_income'); $countItem++;

	// section 5
	$section5[$countItem] =  array('position'); $countItem++;
	$section5[$countItem] =  array('company'); $countItem++;
	$section5[$countItem] =  array('location'); $countItem++;
	$section5[$countItem] =  array('division'); $countItem++;
	$section5[$countItem] =  array('department'); $countItem++;
	$section5[$countItem] =  array('teams'); $countItem++;
	$section5[$countItem] =  array('joining_date'); $countItem++;
	$section5[$countItem] =  array('resign_date'); $countItem++;

	// get data from database 
	// unsearlized the array 
	// removed the section values 
	// searlize again 
	// save in both columns 

	$empdata_cols = 'a:44:{s:12:"basic_salary";s:12:"Basic salary";s:7:"Housing";s:7:"Housing";s:9:"Transport";s:9:"Transport";s:8:"Position";s:8:"Position";s:5:"Phone";s:5:"Phone";s:13:"Pay back loan";s:13:"Pay back loan";s:8:"calc_tax";s:13:"Calculate Tax";s:8:"calc_sso";s:13:"Calculate SSO";s:8:"calc_pvf";s:13:"Calculate PVF";s:8:"calc_psf";s:13:"Calculate PSF";s:11:"calc_method";s:22:"Tax calculation method";s:10:"modify_tax";s:10:"Modify tax";s:10:"pvf_pr_thb";s:12:"PVF % or THB";s:10:"psf_pr_thb";s:12:"PSF % or THB";s:12:"pvf_rate_emp";s:17:"PVF rate employee";s:12:"pvf_rate_com";s:17:"PVF rate employer";s:12:"psf_rate_emp";s:17:"PSF rate employee";s:12:"psf_rate_com";s:17:"PSF rate employer";s:13:"contract_type";s:13:"Contract type";s:9:"calc_base";s:16:"Calculation base";s:6:"sso_by";s:3:"SSO";s:18:"Standard deduction";s:18:"Standard deduction";s:13:"Personal care";s:13:"Personal care";s:14:"Provident fund";s:14:"Provident fund";s:20:"Social Security Fund";s:20:"Social Security Fund";s:15:"Other Deduction";s:15:"Other Deduction";s:24:"Government house banking";s:24:"Government house banking";s:7:"Savings";s:7:"Savings";s:25:"Legal execution deduction";s:25:"Legal execution deduction";s:26:"Kor.Yor.Sor (Student loan)";s:26:"Kor.Yor.Sor (Student loan)";s:16:"remaining_salary";s:12:"Retro salary";s:14:"notice_payment";s:14:"Notice payment";s:10:"paid_leave";s:10:"Paid leave";s:9:"severance";s:9:"Severance";s:16:"legal_deductions";s:16:"Legal deductions";s:12:"other_income";s:12:"Other income";s:8:"position";s:8:"Position";s:7:"company";s:7:"Company";s:8:"location";s:8:"Location";s:8:"division";s:8:"Division";s:10:"department";s:10:"Department";s:5:"teams";s:5:"Teams";s:12:"joining_date";s:12:"Joining date";s:11:"resign_date";s:13:"Resigned Date";}';

	$emp_data_showhide = 'a:44:{i:5;i:5;i:6;i:6;i:7;i:7;i:8;i:8;i:9;i:9;i:10;i:10;i:11;i:11;i:12;i:12;i:13;i:13;i:14;i:14;i:15;i:15;i:16;i:16;i:17;i:17;i:18;i:18;i:19;i:19;i:20;i:20;i:21;i:21;i:22;i:22;i:23;i:23;i:24;i:24;i:25;i:25;i:26;i:26;i:27;i:27;i:28;i:28;i:29;i:29;i:30;i:30;i:31;i:31;i:32;i:32;i:33;i:33;i:34;i:34;i:35;i:35;i:36;i:36;i:37;i:37;i:38;i:38;i:39;i:39;i:40;i:40;i:41;i:41;i:42;i:42;i:43;i:43;i:44;i:44;i:45;i:45;i:46;i:46;i:47;i:47;i:48;i:48;}';

	$empDataCols = unserialize($empdata_cols);
	$empDataColsNum = unserialize($emp_data_showhide);


	foreach ($empDataColsNum as $key => $value) {

		$empDataColsNumNew[$value] = $value;
	}


	if(isset($_REQUEST['cols'][0]['db'] )){$sectionName[$_REQUEST['cols'][0]['db']] = $_REQUEST['cols'][0]['db'];} 
	if(isset($_REQUEST['cols'][1]['db'] )){$sectionName[$_REQUEST['cols'][1]['db']] = $_REQUEST['cols'][1]['db'];} 
	if(isset($_REQUEST['cols'][2]['db'] )){$sectionName[$_REQUEST['cols'][2]['db']] = $_REQUEST['cols'][2]['db'];} 
	if(isset($_REQUEST['cols'][3]['db'] )){$sectionName[$_REQUEST['cols'][3]['db']] = $_REQUEST['cols'][3]['db'];} 
	if(isset($_REQUEST['cols'][4]['db'] )){$sectionName[$_REQUEST['cols'][4]['db']] = $_REQUEST['cols'][4]['db'];} 
	if(isset($_REQUEST['cols'][5]['db'] )){$sectionName[$_REQUEST['cols'][5]['db']] = $_REQUEST['cols'][5]['db'];} 


	/*echo '<pre>';
	print_r($_REQUEST['cols']);
	print_r($sectionName);
	print_r($empDataCols);
	print_r($empDataColsNum);
	print_r($empDataColsNumNew);
	echo '</pre>';*/


	if (!in_array('section0', $sectionName)) {
		foreach ($section0 as $key => $value) {
			unset($empDataCols[$value[0]]);
			unset($empDataColsNumNew[$key]);
		}
	}
	else{
			foreach ($section0 as $key => $value) {
			$empDataCols[] =$value[0] ;
			$empDataColsNumNew[] = $key;
		}

	}	

	if (!in_array('section1', $sectionName)) {

		foreach ($section1 as $key => $value) {
			unset($empDataCols[$value[0]]);
			unset($empDataColsNumNew[$key]);
		}
	}
	else{
			foreach ($section1 as $key => $value) {
				$empDataCols[] =$value[0] ;
				$empDataColsNumNew[] = $key;
			}
	}	

	if (!in_array('section2', $sectionName)) {
		// unset section3 values

		foreach ($section2 as $key => $value) {
			unset($empDataCols[$value[0]]);
			unset($empDataColsNumNew[$key]);
		}

	}
	else{
			foreach ($section2 as $key => $value) {
				$empDataCols[] =$value[0] ;
				$empDataColsNumNew[] = $key;
			}
	}	

	if (!in_array('section3', $sectionName)) {
		// unset section4 values

		foreach ($section3 as $key => $value) {
			unset($empDataCols[$value[0]]);
			unset($empDataColsNumNew[$key]);
		}

	}	
	else{
		foreach ($section3 as $key => $value) {
			$empDataCols[] =$value[0] ;
			$empDataColsNumNew[] = $key;
		}
	}	

	if (!in_array('section4', $sectionName)) {
		// unset section5 values

		foreach ($section4 as $key => $value) {
			unset($empDataCols[$value[0]]);
			unset($empDataColsNumNew[$key]);
		}
	}
	else{
		foreach ($section4 as $key => $value) {
			$empDataCols[] =$value[0] ;
			$empDataColsNumNew[] = $key;
		}
	}


	if (!in_array('section5', $sectionName)) {
		// unset section5 values

		foreach ($section5 as $key => $value) {
			unset($empDataCols[$value[0]]);
			unset($empDataColsNumNew[$key]);
		}
	}
	else{
		foreach ($section5 as $key => $value) {
			$empDataCols[] =$value[0] ;
			$empDataColsNumNew[] = $key;
		}
	}

	// echo '<pre>';
	// print_r($empDataCols);
	// print_r($empDataColsNum);
	// print_r(array_values($empDataColsNumNew));
	// echo '</pre>';


	if(isset($_REQUEST['cols'])){
		foreach($_REQUEST['cols'] as $k=>$v){
			$att_cols[$v['db']] = $v['name'];
			$cols[] = (int)$v['id'];

		}


		if(!$dbc->query("UPDATE ".$_SESSION['rego']['cid']."_sys_settings SET 
			employeeDataSectionShowHide = '".$dbc->real_escape_string(serialize($att_cols))."', 
			employeeDataSectionShowHideCols = '".$dbc->real_escape_string(serialize($cols))."',empdata_cols = '".$dbc->real_escape_string(serialize($empDataCols))."', 
			empdata_showhide_cols = '".$dbc->real_escape_string(serialize($empDataColsNumNew))."'")){
				//echo mysqli_error($dbc);
			}
	}else{

		if(!$dbc->query("UPDATE ".$_SESSION['rego']['cid']."_sys_settings SET 
			employeeDataSectionShowHide = '".$dbc->real_escape_string('')."', 
			employeeDataSectionShowHideCols = '".$dbc->real_escape_string('')."',empdata_cols = '".$dbc->real_escape_string(serialize(''))."', 
			empdata_showhide_cols = '".$dbc->real_escape_string(serialize(''))."'")){
				//echo mysqli_error($dbc);
		}
	}
	//var_dump($att_cols);
?>