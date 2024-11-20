<?
	if(!isset($_GET['mid']) || $_GET['mid'] ==''){
		header('Location: no_access.php');
	}

	function remove_comma($number){
		$var = str_replace(',', '', $number);
		return $var;
	}

	//$getonlyapplyAllowDeduct = getonlyapplyAllowDeduct();
	$getonlyapplyAllowDeduct = getonlyapplyAllowDeductForThisMonth();
	$getSelmonPayrollDatass = getSelmonPayrollData($_SESSION['rego']['cur_month']);
	//=== Check max emp for month
	$empinpayrollmonth = count($getSelmonPayrollDatass);

	$daysCalc = cal_days_in_month(CAL_GREGORIAN,$_SESSION['rego']['cur_month'],$_SESSION['rego']['cur_year']);

	//=================== tab_Parameters ================//

	$ParametersPerMonth = getPayrollPerMonthdata($_SESSION['rego']['cur_year'].'_'.$_SESSION['rego']['cur_month']);
	//$data_income['001'] = 'basic salary';  //assign static key to basic salary
	/*if($res = $dbc->query("SELECT * FROM ".$cid."_allow_deduct WHERE apply = 1 AND hour_daily_rate = 1")){
		while($row = $res->fetch_assoc()){
			$data_income[$row['id']] = $row[$lang];
			
		}
	}*/
	// echo '<pre>';
	// print_r($getonlyapplyAllowDeduct);
	// echo '</pre>';

	$getPayrollModels = getPayrollModels($_GET['mid']); //get from url id



	$payrollparametersformonth = payrollparametersformonth();
	$getAllowDeductAllLinkedInfo = getAllowDeductAllLinkedInfo();

	$paid = false;
	$alltabs = '';
	//$alltabs = 'pointer-events:none';
	$EmpDatatabs = false;
	$ManFeedtabs = false;
	$sql = "SELECT * FROM ".$cid."_payroll_".$_SESSION['rego']['cur_year']." WHERE month = ".$_SESSION['rego']['cur_month'];
	if($res = $dbc->query($sql)){
		while($row = $res->fetch_assoc()){
			$alltabs = '';
			if($row['paid'] == 'Y'){$paid = true;}
			//if($row['salary'] <= 0){$EmpDatatabs = true;}
			//if($row['manual_feed_data'] == ''){$ManFeedtabs = true;}
		}
	}

	$pperiods = array();
	$pmdata = array();
	$sso_rates_def = array();
	$sql = "SELECT * FROM ".$cid."_payroll_months WHERE month LIKE '".$_SESSION['rego']['cur_year']."%'";
	if($res = $dbc->query($sql)){
		while($row = $res->fetch_assoc()){
			$nr = explode('_',$row['month']);
			$pperiods[$nr[1]] = $row;

			$pmdata[$nr[1]] = $row;

			$sso_rates_def[$nr[1]] = unserialize($row['sso_rates_for_month']);

		}
	}

	$fixedmanualarray = $pmdata[$_SESSION['rego']['cur_month']];
	$allowDeductEmpRegFixed = unserialize($fixedmanualarray['allowDeductEmpRegFixed']);
	$allowDeductEmpRegManual = unserialize($fixedmanualarray['allowDeductEmpRegManual']);

	$getEmployeeAllowDeduct = getEmployeeAllowDeduct(); //For Emp. Register Man
	$getEmployeeFixedCalc = getEmployeeFixedCalc(); //For Emp. Register Fixed
 
	$getAttendAllowDeduct = getAttendAllowDeduct();

	if(isset($allowDeductEmpRegManual[0]['id'])){
		$allowDeductEmpRegManual = $allowDeductEmpRegManual;
	}else{
		$allowDeductEmpRegManual = $getEmployeeAllowDeduct;
		//$allowDeductEmpRegManual = $allowDeductEmpRegManual;
	}

	if(isset($allowDeductEmpRegFixed[0]['id'])){
		$allowDeductEmpRegFixed = $allowDeductEmpRegFixed;
	}else{
		$allowDeductEmpRegFixed = $getEmployeeFixedCalc;
		//$allowDeductEmpRegFixed = $allowDeductEmpRegFixed;
	}

	$data_income[56] = 'Basic Salary';
	foreach ($allowDeductEmpRegManual as $key => $row) {
		$data_income[$row['id']] = $row[$lang];
	}

	//=================== tab_Parameters ================//

	//========== Employee group tab =============//
	$missing_emps = getMissingEmployeesFromPayroll($cid, $_SESSION['rego']['curr_month']);
	//========== Employee group tab =============//

	//========== Employee data tab =============//

	$eatt_cols = array();
	
	$eatt_cols[5] = array('basic_salary',$lng['Basic salary']);
	foreach($getonlyapplyAllowDeduct as $d){
		$eatt_cols[] = array($d[$lang],$d[$lang]);				
	}
	
	$eatt_cols[] = array('calc_tax',$lng['Calculate Tax']);
	$eatt_cols[] = array('calc_sso',$lng['Calculate SSO']);
	$eatt_cols[] = array('calc_pvf',$lng['Calculate PVF']);
	$eatt_cols[] = array('calc_method',$lng['Tax calculation method']);
	$eatt_cols[] = array('modify_tax',$lng['Modify tax']);
	$eatt_cols[] = array('pvf_pr_thb',$lng['PVF'].' '.$lng['% or THB']);
	$eatt_cols[] = array('psf_pr_thb',$lng['PSF'].' '.$lng['% or THB']);
	$eatt_cols[] = array('pvf_rate_emp',$lng['PVF rate employee']);
	$eatt_cols[] = array('pvf_rate_com',$lng['PVF rate employer']);
	$eatt_cols[] = array('psf_rate_emp',$lng['PSF rate employee']);
	$eatt_cols[] = array('psf_rate_com',$lng['PSF rate employer']);
	$eatt_cols[] = array('contract_type',$lng['Contract type']);
	$eatt_cols[] = array('calc_base',$lng['Calculation base']);
	$eatt_cols[] = array('sso_by',$lng['SSO']);
	
	$eatt_cols[] = array($lng['Standard deduction'],$lng['Standard deduction']);
	$eatt_cols[] = array($lng['Personal care'],$lng['Personal care']);
	$eatt_cols[] = array($lng['Provident fund'],$lng['Provident fund']);
	$eatt_cols[] = array($lng['Social Security Fund'],$lng['Social Security Fund']);
	$eatt_cols[] = array($lng['Other'].' '.$lng['Deduction'],$lng['Other'].' '.$lng['Deduction']);

	$eatt_cols[] = array($lng['Government house banking'],$lng['Government house banking']);
	$eatt_cols[] = array($lng['Savings'],$lng['Savings']);
	$eatt_cols[] = array($lng['Legal execution deduction'],$lng['Legal execution deduction']);
	$eatt_cols[] = array($lng['Kor.Yor.Sor (Student loan)'],$lng['Kor.Yor.Sor (Student loan)']);

	$eatt_cols[] = array('remaining_salary',$lng['Remaining salary']);
	$eatt_cols[] = array('notice_payment',$lng['Notice payment']);
	$eatt_cols[] = array('paid_leave',$lng['Paid leave']);
	$eatt_cols[] = array('severance',$lng['Severance']);
	$eatt_cols[] = array('legal_deductions',$lng['Legal deductions']);
	$eatt_cols[] = array('other_income',$lng['Other income']);

	$eatt_cols[] = array('position',$lng['Position']);
	$eatt_cols[] = array('company',$lng['Company']);
	$eatt_cols[] = array('location',$lng['Location']);
	$eatt_cols[] = array('division',$lng['Division']);
	$eatt_cols[] = array('department',$lng['Department']);
	$eatt_cols[] = array('teams',$lng['Teams']);
	$eatt_cols[] = array('joining_date',$lng['Joining date']);
	$eatt_cols[] = array('resign_date',$lng['Resigned'].' '.$lng['Date']);

	end($eatt_cols);
	$last_col = key($eatt_cols) + 1;


	$resED = $dbc->query("SELECT * FROM ".$_SESSION['rego']['cid']."_sys_settings");
	$rowED = $resED->fetch_assoc();
	$get_deflt_parm = $rowED['get_deflt_parm'];
	$shCols = unserialize($rowED['empdata_showhide_cols']);
	$tab_default = unserialize($rowED['tab_default']);
	$manualrates_default = unserialize($rowED['manualrates_default']);

	if(!$shCols){$shCols = array();}

	$emptyCols = array();
	foreach($eatt_cols as $k=>$v){
		if(!in_array($k, $shCols)){
			$emptyCols[] = $k;
		}
	}

	//===HIDING COLUMN SALARY & PAYROLL RESULT OVERVIEW TABLES===//
	$salaryOverview = getSalaryOverviewEmptyColumns();
	$salView='';
	foreach($salaryOverview as $v){$salView .= $v.',';}
	$salColView = '['.substr($salView,0,-1).']';

	$prOverview = getPayrollResultOverviewEmptyColumns();
	$prView='';
	foreach($prOverview as $v){$prView .= $v.',';}
	$prColView = '['.substr($prView,0,-1).']';
	//===HIDING COLUMN SALARY & PAYROLL RESULT OVERVIEW TABLES===//

	//echo $salColView;
	/*echo '<pre>';
	print_r($sso_rates_def);
	echo '</pre>';*/

	//FOR EMPLOYEE DATA TAB
	$sCols = getEmptyResultColumnsEmployee($getonlyapplyAllowDeduct);	
	$eColsEE = '';
	foreach($sCols as $v){$eColsEE .= $v.',';}
	$eColsEE = '['.substr($eColsEE,0,-1).']';

	//FOR SALARY & PAYROLL RESULT TAB
	$salpopupCols = getEmptyResultColumnsPayroll();
	$eColsMdlA = '';
	array_pop($salpopupCols['allow']);
	foreach($salpopupCols['allow'] as $v){$eColsMdlA .= $v.',';}
	$eColsMdlA = '['.substr($eColsMdlA,0,-1).']';

	$eColsMdlD = '';
	//array_pop($salpopupCols['dedct']); 
	foreach($salpopupCols['dedct'] as $v){$eColsMdlD .= $v.',';}
	$eColsMdlD = '['.substr($eColsMdlD,0,-1).']';



	//echo "<pre>";
	//echo '<br>';
	//print_r($getSSOEmpRateForMonths);
	//echo $eColsMdlD;
	//echo "</pre>";
	//=================== Employee data tab end ================//

	//=================== tab_Manualfeed ================//

	$status = getPayrollStatus($_SESSION['rego']['cur_year'].'_'.$_SESSION['rego']['cur_month']);

	
	/*if(isset($payrollparametersformonth) && is_array($payrollparametersformonth)){
		$getAttendAllowDeduct = $payrollparametersformonth;
	}*/

	
	$allowDdtEmp = array();
	foreach ($getEmployeeAllowDeduct as $key => $value) {
		$allowDdtEmp[$value['id']] = $value[$lang];
	}
	
	$mfarray = array();
	$allowDdt = array();

	$count = 0;
	$ColumnArr = array();
	foreach ($getAttendAllowDeduct as $key => $value) {
		$count++;
		$val = $count + 2;
		$mfarray[$value['groups']][] = $value;
		$ColumnArr[$val] = array($value['en']);

		$allowDdt[$value['id']] = $value[$lang];
	}


	if(isset($payrollparametersformonth) && is_array($payrollparametersformonth)){
		$dropdownArray = array();
		$dropdownArrayNew = array();
		$countColumn = 0;
		$outerArray = array();
		$attendData = array();
		$countOuter = 0;
		foreach($payrollparametersformonth as $key => $rows){ 
			$countOuter++;
			if($rows['allowopt'] !=''){
				$outerArray[$rows['itemid']] = $allowDdt[$rows['itemid']];
			}

			$allowOpt = explode(',', $rows['allowopt']);
			foreach ($allowOpt as $key1 => $value1) {

				if($value1 !=''){

					$valss = $value1;
					//if($value1 == 'times'){ $valss = $unitopt[$rows['unitarr']];}

					$countColumn++;
					//$valColumn = $countColumn + 2;
					$valColumn = $countColumn + 5;
					$dropdownArray[$valColumn] = $allowDdt[$rows['itemid']].' ('.$valss.')';
					$dropdownArrayNew[$valColumn] = array($allowDdt[$rows['itemid']].' ('.$valss.')',$rows['itemid']);

					$namewithitem = $allowDdt[$rows['itemid']].' ('.$valss.')';
					$attendData[$namewithitem] = array($allowDdt[$rows['itemid']],$rows['itemid']);
				}
			}
		}
	}

	//=================== tab_Manualfeed ================//

	//=================== tab_CalcFeed ================//
	$getCalcFeedAllowDeduct = getCalcFeedAllowDeduct();

	
	//=================== tab_CalcFeed ================//

	//=================== tab_Relateddata ================//
	$eatt_colsRD = array();
	$eatt_colsRD[2] = array('position',$lng['Position']);
	$eatt_colsRD[] = array('entity',$lng['Company']);
	$eatt_colsRD[] = array('branch',$lng['Location']);
	$eatt_colsRD[] = array('division',$lng['Division']);
	$eatt_colsRD[] = array('department',$lng['Department']);
	$eatt_colsRD[] = array('team',$lng['Teams']);

	end($eatt_colsRD);
	$last_colRD = key($eatt_colsRD) + 1;

	$shColsR = unserialize($rowED['payroll_empgroup_showhide_cols']);
	if(!$shColsR){$shColsR = array();}

	$emptyColsR = array();
	foreach($eatt_colsRD as $k=>$v){
		if(!in_array($k, $shColsR)){
			$emptyColsR[] = $k;
		}
	}
	//=================== tab_Relateddata ================//
	//=================== tab_mf ================//
	$shColsmf = unserialize($rowED['Pmanualfeed_showhide_cols']);
	$Pmanualfeed_cols = unserialize($rowED['Pmanualfeed_cols']);
	if(!$shColsmf){$shColsmf = array();}

	$emptyColsmf = array();
	$checkColsmf = array();
	foreach($dropdownArray as $k=>$v){
		if(!in_array($k, $shColsmf)){
			$emptyColsmf[] = $k;
		}else{
			$checkColsmf[] = $k;
		}
	}

	//FOR MANUAL FEED TAB
	$manualFeedShowhide = manualFeedShowhide($dropdownArray,$outerArray);
	$getEmployeeAllowDeductionFormonth = getEmployeeAllowDeductionFormonth();
	$eColsMFd = '';

	$checkValues = 0;
	foreach ($getEmployeeAllowDeductionFormonth['manual_feed_total'] as $k1 => $v1) {
		$checkValues += array_sum($v1);
	}

	// echo '<pre>';
	// print_r($emptyColsmf);
	// echo '</pre>';
	
	/*if($checkValues > 0){
		array_shift($manualFeedShowhide);
		foreach($manualFeedShowhide as $v){$eColsMFd .= $v.',';}
		$eColsMFd = '['.substr($eColsMFd,0,-1).']';
		$eColsMFd = '{"targets": '.$eColsMFd.', "visible": false, "searchable": false}';
	}else{
		$eColsMFd = '';
	}*/
	//=================== tab_mf ================//

	/*echo '<pre>';
	print_r($checkValues);
	echo '</pre>';*/

	//===================== tab employee data section code ========== //

	// create array of sections 



	$section_cols[] = array('section0', 'Current Benefits Payroll of this month');
	$section_cols[] = array('section1', 'Wage Condition');
	$section_cols[] = array('section2', 'Tax deductions');
	$section_cols[] = array('section3', 'Monthly Legal deductions');
	$section_cols[] = array('section4', 'End contract');
	$section_cols[] = array('section5', 'Employee Data');



	$shColsEmpdatasection = unserialize($rowED['employeeDataSectionShowHideCols']);

	//===================== tab employee data section code ========== //

	//echo "<pre>";
	//print_r($rules);
	//print_r($getAttendAllowDeduct);
	// print_r($dropdownArrayNew);
	//echo "</pre>";
	//exit;

	//echo $_SESSION['rego']['max'] .' = '.$empinpayrollmonth;

?>
<style type="text/css">
	::-webkit-scrollbar {
	    width: 6px;
	    height: 15px !important;
	}

	#tab_Parameters .SumoSelect > .optWrapper.multiple > .options li.opt{
		pointer-events: none;
	}

	#mfeedsel li.opt.selected.optCol.ddefsel {
	    pointer-events: none;
	}

	#tab_Parameters .SumoSelect{
		padding: 2px !important;
    	border: none !important;
	}

	#tab_RelatedTo .SumoSelect > .optWrapper {
		width: auto !important;
	}

	#tab_Parameters .inptbkg{
		/*background: #f9f7dd !important;*/
	}

	#Normalcalculator .inptbkg{
		background: #f9f7dd !important;
	}

	#tab_ManualFeed h2{
	    font-size: 15px;
	    line-height: 30px;
	}

	#tab_Parameters table input {
		width: 100% !important;
	}

	table.basicTable.inputs tbody td {
	    padding: 0 !important;
	    width: 32%;
	}

	#tab_Parameters .SumoSelect {
	    width: 100% !important;
	}

	#tab_Parameters input[type=radio] {
	    -moz-appearance: none;
	    -webkit-appearance: none;
	    -o-appearance: none;
	    outline: none;
	    content: none;
	    border-radius: 2px;
	}

	#tab_Parameters input[type=radio]:before {
	    font-family: "FontAwesome";
	    content: "\f00c";
	    padding: 2px;
    	font-size: 9px;
	    color: transparent !important;
	    background: #fff;
	    width: 20px;
	    height: 20px;
	    border: 1px solid #7d6868;
	    border-radius: 2px;
	}

	#tab_Parameters input[type=radio]:checked:before {
	    color: #fff !important;
	    background: #007bff !important;
	    border: 1px solid #007bff;
	    padding: 2px;
    	font-size: 9px;
    	border-radius: 2px;
	}

	.customfontsize{
		font-size: 11px;
	}

	#fixAllowded tbody td{
		padding: 0px !important;		
	}

	table.basicTable.inputs tbody td.pd_lft {
		padding-left: 4px !important;
	}

	table.basicTable.inputs tbody td.pd_rgt {
		padding-right: 4px !important;
	}

	table.basicTable tbody td input.addbg{
		background: #f8f8d1 !important;
	}

	table.basicTable tbody td.addbg{
		background: #f8f8d1 !important;
	}

	table.basicTable.inputs tbody#basicinfo td {
	    width: 37.2% !important;
	}

	table.basicTable.inputs tbody.forMonth td{
	    width: 41% !important;
	}

	#Normalcalculator .SumoSelect{
		border: 1px solid #fff !important;
	}

	    

	.blink_me {
	  animation: blinker 1s linear infinite;
	}

	@keyframes blinker {  
	  50% { opacity: 0; }
	}


</style>
<h2 style="padding-right:60px">
	<i class="fa fa-cog"></i>&nbsp; <?=$lng['Payroll calculator']?>
	<? if($get_deflt_parm == 1){?>
		<span style="font-style:italic; color:#b00; float: right;" class="blink_me"><i class="fa fa-exclamation-triangle fa-mr"></i><?=$lng['Please recalculate payroll again']?></span>
	<? } ?>
	<span style="display:none; font-style:italic; color:#b00; padding-left:30px" id="sAlert"><i class="fa fa-exclamation-triangle fa-mr"></i><?=$lng['Data is not updated to last changes made']?></span>

	<? if($empinpayrollmonth == $_SESSION['rego']['max']){ ?>
		<span style="font-style:italic; color:#b00; padding-left:30px"><i class="fa fa-exclamation-triangle fa-mr"></i>
			You have exceeded your max limit of (<?=$_SESSION['rego']['max'];?>) employees for this Payroll month
		</span>
	<? } ?>
</h2>

<div class="main">
	<div style="padding:0 0 0 20px" id="dump"></div>

	


	<ul class="nav nav-tabs" id="myTab" style="">

		<li class="paramerterpayroll customfontsize nav-item"><a class="nav-link active" href="#tab_Parameters" data-toggle="tab"><?=$lng['Parameters']?></a></li>
		<li class="empgrouppayroll customfontsize nav-item"><a class="nav-link" href="#tab_RelatedTo" data-toggle="tab"><?=$lng['Emp. Groups']?></a></li>
		<li class="empdatapayroll customfontsize nav-item" style="<?=$alltabs?>"><a class="nav-link" href="#tab_EmployeeData" data-toggle="tab" ><?=$lng['Employee Data']?></a></li>
		<li class="manualfeedpayroll customfontsize nav-item" style="<?=$alltabs?> <?if($EmpDatatabs){echo 'pointer-events:none';}?>"><a class="nav-link" href="#tab_ManualFeed" data-toggle="tab"><?=$lng['Manual Feed']?></a></li>
		<li class="calculatedfeedpayroll customfontsize nav-item" style="display:none;<?=$alltabs?> <?if($EmpDatatabs){echo 'pointer-events:none';}elseif($ManFeedtabs){echo 'pointer-events:none';}?>"><a class="nav-link" href="#tab_CalculatedFeed" data-toggle="tab"><?=$lng['Calculated Feed']?></a></li>
		<li class="attendancepayroll customfontsize nav-item" style="<?=$alltabs?> <?if($EmpDatatabs){echo 'pointer-events:none';}elseif($ManFeedtabs){echo 'pointer-events:none';}?>"><a class="nav-link" href="#tab_Attendance" data-toggle="tab"><?=$lng['Attendance']?></a></li>
		<li class="previouscalcpayroll customfontsize nav-item" style="display:none;<?=$alltabs?> <?if($EmpDatatabs){echo 'pointer-events:none';}elseif($ManFeedtabs){echo 'pointer-events:none';}?>"><a class="nav-link" href="#tab_PreviousCalc" data-toggle="tab"><?=$lng['Previous Calc']?></a></li>
		<li class="salarypayroll customfontsize nav-item" style="<?=$alltabs?> <?if($EmpDatatabs){echo 'pointer-events:none';}elseif($ManFeedtabs){echo 'pointer-events:none';}?>"><a class="nav-link" href="#tab_SalaryCalc" data-toggle="tab" ><?=$lng['Salary Calc']?></a></li>
		<li class="payrollresult customfontsize nav-item" style="<?=$alltabs?> <?if($EmpDatatabs){echo 'pointer-events:none';}elseif($ManFeedtabs){echo 'pointer-events:none';}?>"><a class="nav-link" href="#tab_PayrollResult" data-toggle="tab" ><?=$lng['Payroll result']?></a></li>
		<li class="verificationpayroll customfontsize nav-item" style="<?=$alltabs?> <?if($EmpDatatabs){echo 'pointer-events:none';}elseif($ManFeedtabs){echo 'pointer-events:none';}?>"><a class="nav-link" href="#tab_OtherTabs" data-toggle="tab"><?=$lng['Verification Center']?></a></li>

		<li class="flr hideclearselectionpayroll Clearselection" style="position: absolute;right: 15px;display: none;<? if($paid){echo 'pointer-events:none;opacity: 0.5';}?>">
			<a style="font-size: 11px;padding-bottom: 6px;padding-left: 10px;padding-right: 10px;padding-top: 6px;" class="text-white btn btn-primary"><i class="fa fa-trash"></i> <?=$lng['Clear Selection']?></a>
		</li>
		<li class="flr hidefetchdatapayroll " onclick="getAllChkData(this)" style="position: absolute;right: 29px;display: none;<? if($paid){echo 'pointer-events:none;opacity: 0.5';}?>"><a style="font-size: 11px;padding-bottom: 6px;padding-left: 10px;padding-right: 10px;padding-top: 6px;" class="text-white btn btn-primary"> <?=$lng['Fetch Employee Data']?></a></li>
						

		<li class="hidemanualfeedpayroll" style="position: absolute;right: 188px;" class="flr"><a id="export_manual_excel" class="text-white btn btn-primary" style="font-size: 11px;padding-bottom: 6px;padding-left: 10px;padding-right: 10px;padding-top: 6px;">
			<i class="fa fa-download fa-lg mr-2"></i><?=$lng['Export']?></a>
		</li>
		
		<li class="hidemanualfeedpayroll" style="position: absolute;right: 105px;" class="flr"><a onclick="$('#import_attendance').click()" class="text-white btn btn-primary" style="font-size: 11px;padding-bottom: 6px;padding-left: 10px;padding-right: 10px;padding-top: 6px;">
			<i class="fa fa-upload fa-lg mr-2"></i><?=$lng['Import']?></a>
		</li>

		<li class="hidemanualfeedpayroll" style="position: absolute;right: 13px;<? if($paid){echo 'pointer-events:none;opacity: 0.5';}?>" class="flr" id="saveManualfeedData"><a class="text-white btn btn-primary" style="font-size: 11px;padding-bottom: 6px;padding-left: 10px;padding-right: 10px;padding-top: 6px;">
			<i class="fa fa-save fa-lg mr-2" ></i><?=$lng['Calculate']?></a>
		</li>


		<li class="flr CalculatePayroll" onclick="calculatePayrollData()" style="position: absolute;right: 29px;display: none;<? if($paid){echo 'pointer-events:none;opacity: 0.5';}?>"><a style="font-size: 11px;padding-bottom: 6px;padding-left: 10px;padding-right: 10px;padding-top: 6px;" class="text-white btn btn-primary"> <?=$lng['Calculate Payroll']?></a></li>

	</ul>	



	<div class="tab-content" style="padding: 0px !important;height:calc(100% - 40px)">
		<!-- <button type="button" onclick="window.history.go(-1); return false;" class="btn btn-primary btn-fr" style="position: absolute;top: 15px;right: 16px;"><i class="fa fa-backward fa-mr"></i> <?=$lng['Go back']?></button> -->



		<div class="tab-pane active" id="tab_Parameters">
			<!-- <form id="parametersData"> -->
				<div class="row">
					<div class="col-md-10"></div>
					<div class="col-md-2" style="position: absolute;top: 14px;right: 8px;">
						<!-- <button style="<? if($paid){echo 'pointer-events:none;opacity: 0.5';}?>" class="btn btn-primary btn-fr" type="button" onclick="SaveParametersForm()"><?=$lng['Get default settings']?></button> -->
						<button style="<? if($paid){echo 'pointer-events:none;opacity: 0.5';}?>" class="btn btn-primary btn-fr" type="button" onclick="getDefaultSettings()"><?=$lng['Get default settings']?></button>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<table class="basicTable inputs" border="0">
							<thead>
								<tr>
									<th colspan="3"><?=$lng['Parameters']?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th class="tal"><?=$lng['Payroll']?></th>
									<td colspan="2" class="pd_lft"><?=$payrollopt[$ParametersPerMonth[0]['payroll_opt']]?></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Set Period']?></th>
									<td class="pd_lft"><?=date('d-m-Y', strtotime($ParametersPerMonth[0]['sal_start']))?></td>
									<td class="pd_lft"><?=date('d-m-Y', strtotime($ParametersPerMonth[0]['sal_end']))?></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Salary split']?></th>
									<td colspan="2" class="pd_lft"><?=$noyes01[$ParametersPerMonth[0]['salary_split']]?></td>
								</tr>
								
							</tbody>
							<tbody>
								<?php
								$totalMonth = 12;
								$remainingmonth = ($totalMonth-$_SESSION['rego']['curr_month']) + 1;
								$previousMonth = $totalMonth-$remainingmonth;

								?>
								<tr>
									<th class="tal">Current payroll month</th>
									<td colspan="2" class="pd_lft"><?=$_SESSION['rego']['cur_month'];?></td>
								</tr>
								<tr>
									<th class="tal">Nr previous months</th>
									<td colspan="2" class="pd_lft"><?=$previousMonth;?></td>
								</tr>
								<tr>
									<th class="tal">Nr remaining months</th>
									<td colspan="2" class="pd_lft"><?=$remainingmonth;?> (incl. current mth)</td>
								</tr>
								
							</tbody>
						

						<?php
							$paiddays = array();
							if($ParametersPerMonth[0]['paid'] != ''){
								$paiddays = unserialize($ParametersPerMonth[0]['paid']);
							}

							$noOfPaidDays = '';
							if($paiddays['paid_days'] == 1){
								$noOfPaidDays = $pperiods[$_SESSION['rego']['cur_month']]['caldays'];
							}elseif($paiddays['paid_days'] == 2){
								$noOfPaidDays = $pperiods[$_SESSION['rego']['cur_month']]['base30'];
							}else{
								$noOfPaidDays = $pperiods[$_SESSION['rego']['cur_month']]['workdays'];
							}
						?>
						
							<thead>
								<tr>
									<th colspan="3"><?=$lng['Calculation for Paid days']?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th class="tal"><?=$lng['Nr of days']?></th>
									<td colspan="2" class="pd_lft"><?=$paiddaycalc[$paiddays['paid_days']]?></td>									
								</tr>
								<tr>
									<th class="tal"><?=$lng['Income base']?></th>
									<td colspan="2" class="pd_lft" style="vertical-align: top;">
										<select id="dayRateId" multiple="multiple" name="paid[income_base]" style="width:auto; min-width:100%;">							
											<? 
											$income_basess = $paiddays['income_base'];
											if($income_basess == ''){ $income_basess = $tab_default['income_base'];}
											$income_basess = explode(',', $income_basess);
											$income_basessName = '';
											foreach($data_income as $k=>$v){ 
												if(in_array($k, $income_basess)){
													$sel='selected'; 
													$income_basessName = $v.', '; //for fixincome calculator
												}else{$sel='';}?>
												<option value="<?=$k?>" <?=$sel;?>><?=$v?></option>
												
											<? } ?>
										</select>

										<!-- <p id="appendSelDay" style="display: none;"></p> -->
									</td>
									
								</tr>
								<tr>
									<th class="tal"><?=$lng['Paid days']?></th>
									<td colspan="2" class="pd_lft"><?=$noOfPaidDays?></td>
								</tr>
							</tbody>
							<thead>
								<tr>
									<th colspan="3"><?=$lng['Hours Daily wage']?></th>
								</tr>
							</thead>
							<tbody style="pointer-events: none;">
								<tr>
									<th class="tal"><?=$lng['Nr of hrs']?></th>
									<td colspan="2" class="pd_lft"><?=$paiddays['nrhrs']?></td>
									
								</tr>
								
							</tbody>
						</table>
					</div>

					<div class="col-md-5">
						<table class="basicTable inputs" border="0">
							<thead>
								<tr>
									
									<th colspan="4" class="tac"><?=$lng['SSO']?> <?=$lng['Employee']?></th>
									<th colspan="3" class="tac"><?=$lng['SSO']?> <?=$lng['Company']?></th>
									<th class="tac"><?=$lng['PND']?> 3</th>
									
								</tr>
								<tr>
									<th class="tac"><?=$lng['Month']?></th>
									<th class="tac"><?=$lng['Rate']?> %</th>
									<th class="tac"><?=$lng['Max']?></th>
									<th class="tac"><?=$lng['Min']?>.</th>
									<th class="tac"><?=$lng['Rate']?> %</th>
									<th class="tac"><?=$lng['Max']?>.</th>
									<th class="tac"><?=$lng['Min']?>.</th>
									<th class="tac"><?=$lng['WHT']?> %</th>
									
								</tr>
							</thead>
							<tbody>
							<? foreach($pperiods as $k=>$v){ $id = $cur_year.'_'.$k; ?>
								<tr>
									<td class="pd_lft" style="width: 46%;"><input type="text" class="font-weight-bold" value="<?=$months[$k]?>" readonly></td>
									<td class="tac" style="width: 15%;"><?= isset($sso_rates_def[$_SESSION['rego']['cur_month']][$id]['rate']) ? $sso_rates_def[$_SESSION['rego']['cur_month']][$id]['rate'] : $v['sso_eRate'];?></td>
									<td class="tac" style="width: 15%;"><?=isset($sso_rates_def[$_SESSION['rego']['cur_month']][$id]['max']) ? $sso_rates_def[$_SESSION['rego']['cur_month']][$id]['max'] : $v['sso_eMax']?></td>
									<td class="tac"><?=isset($sso_rates_def[$_SESSION['rego']['cur_month']][$id]['min']) ? $sso_rates_def[$_SESSION['rego']['cur_month']][$id]['min'] : $v['sso_eMin']?></td>
									<td class="tac"><?=isset($sso_rates_def[$_SESSION['rego']['cur_month']][$id]['crate']) ? $sso_rates_def[$_SESSION['rego']['cur_month']][$id]['crate'] : $v['sso_cRate']?></td>
									<td class="tac"><?=isset($sso_rates_def[$_SESSION['rego']['cur_month']][$id]['cmax']) ? $sso_rates_def[$_SESSION['rego']['cur_month']][$id]['cmax'] : $v['sso_cMax']?></td>
									<td class="tac"><?=isset($sso_rates_def[$_SESSION['rego']['cur_month']][$id]['cmin']) ? $sso_rates_def[$_SESSION['rego']['cur_month']][$id]['cmin'] : $v['sso_cMin']?></td>
									<td class="tac"><?=isset($sso_rates_def[$_SESSION['rego']['cur_month']][$id]['wht']) ? $sso_rates_def[$_SESSION['rego']['cur_month']][$id]['wht'] : $v['wht']?></td>
									
								</tr>
							<? } ?>
							
							</tbody>
						</table>
						
					</div>
				</div>

				
				<div class="row mt-4 mb-4">
					<div class="col-md-12 table-responsive">
						<table class="basicTable inputs" border="0">
							<thead>
								<tr>
									<th colspan="12"><?=$lng['Variable Allowances & Deductions Attendance']?></th>
									<th colspan="5" class="tal"><?=$lng['Calculation formula Hourly rate']?></th>
									<th colspan="2" class="tac"><?=$lng['Times']?></th>
								</tr>
							</thead>
							<thead>
								<th><?=$lng['Allowances'];?></th>
								<th><?=$lng['Classification'];?></th>
								<th class="tac"><?=$lng['Groups'];?></th>
								<th class="tac"><?=$lng['Tax Base'];?></th>
								<th class="tac"><?=$lng['PND'];?></th>
								<th class="tac"><?=$lng['SSO'];?></th>
								<th class="tac"><?=$lng['HrR'];?></th>
								<th class="tac"><?=$lng['PVF'];?></th>
								<th class="tac"><?=$lng['PSF'];?></th>
								
								<th class="tac"><?=$lng['Hrs'];?></th>
								<th class="tac"><?=$lng['Times'];?></th>
								<th class="tac"><?=$lng['THB'];?></th>
								<th class="tac"><?=$lng['Multiplicator'];?></th>
								<th class="tac"><?=$lng['Paid days'];?></th>
								<th><?=$lng['Nr of days']?></th>
								<th><?=$lng['Nr of hrs']?></th>
								<th><?=$lng['Income base']?></th>
								<th><?=$lng['THB'].'/'.$lng['Unit']?></th>
								<th><?=$lng['Unit']?></th>
								
							</thead>
							<tbody>

								<? if(isset($getAttendAllowDeduct) && is_array($getAttendAllowDeduct)){ 

									foreach($getAttendAllowDeduct as $row){

									if($row['man_att'] == 1){ ?>

									<? if($payrollparametersformonth[$row['id']]['calcOpt'] !=''){ ?>
										<script type="text/javascript">
										$(document).ready(function(){
											calcoptsel(<?=$payrollparametersformonth[$row['id']]['calcOpt']?>,<?=$row['id']?>);
										})
										</script>
									<? } ?>
										<tr>
											<td><span class="pl-2"><?=$row[$lang]?></span></td>
											<td>
												<span class="pl-2"><?=$classification[$row['classification']]?></span>
											</td>
											<td class="pd_lft">
												<?foreach($income_group as $k => $v){?>
													<?if($k == $row['groups']){echo $v;}?>
												<? } ?>
												<?foreach($deduct_group as $k => $v){?>
													<?if($k == $row['groups']){echo $v;}?>
												<? } ?>
												<!--<select name="groups[<?=$row['id']?>]" id="groups<?=$row['id']?>" style="width: 100%; pointer-events: none;">
													<option value="" selected disabled>Select One</option>
													<?/*foreach($income_group as $k => $v){?>
														<option value="<?=$k?>" <?if($k == $row['groups']){echo 'selected';}?>><?=$v?></option>
													<? }*/ ?>
													<?/*foreach($deduct_group as $k => $v){?>
														<option value="<?=$k?>" <?if($k == $row['groups']){echo 'selected';}?>><?=$v?></option>
													<? }*/ ?>
												</select>-->
											</td>
											<td class="pd_lft">
												<?foreach($tax_base as $k => $v){?>
													<?if($k == $row['tax_base']){echo $v;}?>
												<? } ?>
												<!--<select name="tax_base[<?=$row['id']?>]" id="tax_base<?=$row['id']?>" style="width: 100%;pointer-events: none;">
													<option value="" selected disabled>Select One</option>
													<?/*foreach($tax_base as $k => $v){?>
														<option value="<?=$k?>" <?if($k == $row['tax_base']){echo 'selected';}?>><?=$v?></option>
													<? }*/ ?>
												</select>-->
											</td>
											<td><? if($row['pnd1'] == 1){$pndchk='checked="checked"';}else{$pndchk='';}?>
												<input  class="checkbox-custom-black" type="checkbox" name="pnd[<?=$row['id']?>]" value="1" <?=$pndchk?> style="pointer-events: none;">
											</td>
											<td><? if($row['sso'] == 1){$ssochk='checked="checked"';}else{$ssochk='';}?>
												<input class="checkbox-custom-black" type="checkbox" name="sso[<?=$row['id']?>]" value="1" <?=$ssochk?> style="pointer-events: none;">
											</td>
											<td><? if($row['hour_daily_rate'] == 1){$hour_daily_rate='checked="checked"';}else{$hour_daily_rate='';}?>
												<input class="checkbox-custom-black" type="checkbox" value="1" <?=$hour_daily_rate?> style="pointer-events: none;">
											</td>
											<td><? if($row['pvf'] == 1){$pvfpsfchk='checked="checked"';}else{$pvfpsfchk='';}?>
												<input class="checkbox-custom-black" type="checkbox" name="pvfpsf[<?=$row['id']?>]" value="1" <?=$pvfpsfchk?> style="pointer-events: none;">
											</td>
											<td><? if($row['psf'] == 1){$psfchk='checked="checked"';}else{$psfchk='';}?>
												<input class="checkbox-custom-black" type="checkbox" name="psf[<?=$row['id']?>]" value="1" <?=$psfchk?> style="pointer-events: none;">
											</td>
										
											<td>
												<input type="hidden" name="month" value="<?=$_SESSION['rego']['cur_month']?>">
												<input type="hidden" name="itemid[<?=$row['id']?>]" value="<?=$row['id']?>">

												<?php
												$hrs = $times = $thb = '';
												if(isset($payrollparametersformonth[$row['id']]['allowopt'][0])){
													$exallowopt = explode(',', $payrollparametersformonth[$row['id']]['allowopt']);
												}else{
													$exallowopt = $manualrates_default['allowopt'][$row['id']];
												}
												
												if(in_array('hrs', $exallowopt)){
													$hrs = 'checked="checked"'; ?>
													<script type="text/javascript">
														$(document).ready(function(){
															
															setTimeout( function(){   
																hrsOption(this,<?=$row['id']?>);
															}, 2000);
														})
													</script>
												<? }

												if(in_array('times', $exallowopt)){
													$times = 'checked="checked"'; ?>
													<script type="text/javascript">
														$(document).ready(function(){
															
															setTimeout( function(){   
																timesOption(this,<?=$row['id']?>);
															}, 2000);
														})
													</script>
												<? }

												if(in_array('thb', $exallowopt)){
													$thb = 'checked="checked"'; ?>
													<script type="text/javascript">
														$(document).ready(function(){
															//thbOption(this,<?=$row['id']?>);
															setTimeout( function(){   
																thbOption(this,<?=$row['id']?>);
															}, 2000);
														})
													</script>
												<? } ?>

												<input  class="checkbox-custom-black" type="checkbox" onclick="hrsOption(this,<?=$row['id']?>)" id="hrs<?=$row['id']?>" name="allowopt[<?=$row['id']?>][]" value="hrs" <?=$hrs?> style="text-align: center;pointer-events: none;">
											</td>
											<td>
												<input class="checkbox-custom-black" type="checkbox" onclick="timesOption(this,<?=$row['id']?>)" id="times<?=$row['id']?>" name="allowopt[<?=$row['id']?>][]" value="times" <?=$times?> style="text-align: center;pointer-events: none;">
											</td>
											<td>
												<input class="checkbox-custom-black" type="checkbox" onclick="thbOption(this,<?=$row['id']?>)" id="thb<?=$row['id']?>" name="allowopt[<?=$row['id']?>][]" value="thb" <?=$thb?> style="text-align: center;pointer-events: none;">
											</td>
											<td>
												<input type="text" class="numeric" name="multiplicator[<?=$row['id']?>]" id="multiplicator<?=$row['id']?>" value="<?=isset($payrollparametersformonth[$row['id']]['multiplicator']) ? $payrollparametersformonth[$row['id']]['multiplicator'] : $manualrates_default['multiplicator'][$row['id']]?>" readonly style="pointer-events: none;">
											</td>
											<td class="pd_lft">
												<?foreach($paiddaycalc as $k => $v){?>
														<?if($k == $payrollparametersformonth[$row['id']]['calcOpt']){echo $v;}elseif($k == $manualrates_default['calcOpt'][$row['id']]){echo $v;}?>
													<? } ?>
												<!--<select name="calcOpt[<?=$row['id']?>]" id="calcOpt<?=$row['id']?>" onchange="calcoptsel(this.value,<?=$row['id']?>)" style="pointer-events: none;" >
													<?/*foreach($paiddaycalc as $k => $v){?>
														<option value="<?=$k?>" <?if($k == $payrollparametersformonth[$row['id']]['calcOpt']){echo 'selected';}elseif($k == $manualrates_default['calcOpt'][$row['id']]){echo 'selected';}?>><?=$v?></option>
													<? }*/ ?>
												</select>-->
											</td>
											
											<td>
												<input type="text" class="numeric" name="nrdays[<?=$row['id']?>]" id="nrdays<?=$row['id']?>" value="<?=isset($payrollparametersformonth[$row['id']]['nrdays']) ? $payrollparametersformonth[$row['id']]['nrdays'] : $manualrates_default['nrdays'][$row['id']]?>" readonly style="pointer-events: none;">
											</td>
											<td>
												<input type="text" class="sel hourFormat" name="nrhrs[<?=$row['id']?>]" id="nrhrs<?=$row['id']?>" value="<?=isset($payrollparametersformonth[$row['id']]['nrhrs']) ? $payrollparametersformonth[$row['id']]['nrhrs'] : $manualrates_default['nrhrs'][$row['id']]?>" readonly style="pointer-events: none;">
											</td>
											<td class="pd_lft">
												<?php
												$explodeIncome = explode(',', $payrollparametersformonth[$row['id']]['pp_income_base']);
												$defincome_base = explode(',', $manualrates_default['income_base'][$row['id']]);
												?>
												<?/* foreach($data_income as $k=>$v){ ?>
													<?if(in_array($k, $explodeIncome)){echo $v.', ';}elseif(in_array($k, $defincome_base)){ echo $v.', ';} ?>
												<? } */?>

												<select id="incomeBase<?=$row['id']?>" multiple="multiple" name="income_base[<?=$row['id']?>]" style="width:auto; min-width:100%;" >							
													<? foreach($data_income as $k=>$v){ ?>
														<!-- <option value="<?=$k?>" <?if(in_array($k, $explodeIncome)){echo 'selected';}elseif(in_array($k, $defincome_base)){ echo 'selected';} ?> ><?=$v?></option> -->
														<option value="<?=$k?>" <?if(in_array($k, $explodeIncome)){echo 'selected';} ?> ><?=$v?></option>
													<? } ?>
												</select>
											</td>
											<td>
												<input type="text" class="numeric" name="thbunit[<?=$row['id']?>]" id="thbunit<?=$row['id']?>" value="<?=isset($payrollparametersformonth[$row['id']]['thbunit']) ? $payrollparametersformonth[$row['id']]['thbunit'] : $manualrates_default['thbunit'][$row['id']]?>" readonly style="pointer-events: none;">
											</td>
											<td class="pd_lft">
												<?foreach($unitopt as $k => $v){ ?>
													<?if($k == $payrollparametersformonth[$row['id']]['unitarr']){echo $v;}elseif($k == $manualrates_default['unitarr'][$row['id']]){echo $v;}?>
												<? } ?>
												<!--<select name="unitarr[<?=$row['id']?>]" id="unitarr<?=$row['id']?>" style="pointer-events: none;">
													<?/*foreach($unitopt as $k => $v){ ?>
														<option value="<?=$k?>" <?if($k == $payrollparametersformonth[$row['id']]['unitarr']){echo 'selected';}elseif($k == $manualrates_default['unitarr'][$row['id']]){echo 'selected';}?>><?=$v?></option>
													<? }*/ ?>
												</select>-->
											</td>
											
										</tr>
								<? } } } ?>
								
							</tbody>
						</table>
					</div>

				</div> 

				<div class="row mt-4 mb-4">
					<div class="col-md-6">
						<table class="basicTable inputs" border="0" id="fixAllowded">
							<thead>
								<tr>
									<th colspan="9"><?=$lng['Fixed Allowances & Deductions Emp. Register Man']?></th>
								</tr>
							</thead>
							<thead>
								<th><?=$lng['Allowances'];?></th>
								<th><?=$lng['Classification'];?></th>
								<th class="tac"><?=$lng['Groups'];?></th>
								<th class="tac"><?=$lng['Tax Base'];?></th>
								<th class="tac"><?=$lng['PND'];?></th>
								<th class="tac"><?=$lng['SSO'];?></th>
								<th class="tac"><?=$lng['HrR'];?></th>
								<th class="tac"><?=$lng['PVF'];?></th>
								<th class="tac"><?=$lng['PSF'];?></th>
							</thead>
							<tbody>

								<? if(isset($allowDeductEmpRegManual) && is_array($allowDeductEmpRegManual)){
									foreach($allowDeductEmpRegManual as $row){ ?>

										<tr>
											<td><span class="pl-2"><?=$row[$lang]?></span></td>
											<td>
												<span class="pl-2"><?=$classification[$row['classification']]?></span>
											</td>
											<td class="pd_lft">
												<?foreach($income_group as $k => $v){?>
													<?if($k == $row['groups']){echo $v;}?>
												<? } ?>
												<?foreach($deduct_group as $k => $v){?>
													<?if($k == $row['groups']){echo $v;}?>
												<? } ?>
											</td>
											<td class="pd_lft"><?=$tax_base[$row['tax_base']]?></td>

											<td><? if($row['pnd1'] == 1){$pndchk='checked="checked"';}else{$pndchk='';}?>
												<input  class="checkbox-custom-black" type="checkbox" value="1" <?=$pndchk?> style="pointer-events: none;margin-top: 4px">
											</td>
											<td><? if($row['sso'] == 1){$ssochk='checked="checked"';}else{$ssochk='';}?>
												<input class="checkbox-custom-black" type="checkbox" value="1" <?=$ssochk?> style="pointer-events: none;margin-top: 4px">
											</td>
											<td><? if($row['hour_daily_rate'] == 1){$hour_daily_rate='checked="checked"';}else{$hour_daily_rate='';}?>
												<input class="checkbox-custom-black" type="checkbox" value="1" <?=$hour_daily_rate?> style="pointer-events: none;margin-top: 4px">
											</td>
											<td><? if($row['pvf'] == 1){$pvfpsfchk='checked="checked"';}else{$pvfpsfchk='';}?>
												<input class="checkbox-custom-black" type="checkbox" value="1" <?=$pvfpsfchk?> style="pointer-events: none;margin-top: 4px">
											</td>
											<td><? if($row['psf'] == 1){$psfchk='checked="checked"';}else{$psfchk='';}?>
												<input class="checkbox-custom-black" type="checkbox" value="1" <?=$psfchk?> style="pointer-events: none;margin-top: 4px">
											</td>
										</tr>

									<? } ?>
								<? } ?>

							</tbody>
						</table>
					</div>

					<div class="col-md-6 table-responsive">
						<table class="basicTable inputs" border="0" id="fixCalculation">
							<thead>
								<tr>
									<th colspan="9"><?=$lng['Fixed allowances & Deductions Employee Register Fixed']?></th>
								</tr>
							</thead>
							<thead>
								<th><?=$lng['Allowances'];?></th>
								<th><?=$lng['Classification'];?></th>
								<th class="tac"><?=$lng['Groups'];?></th>
								<th class="tac"><?=$lng['Tax Base'];?></th>
								<th class="tac"><?=$lng['PND'];?></th>
								<th class="tac"><?=$lng['SSO'];?></th>
								<th class="tac"><?=$lng['HrR'];?></th>
								<th class="tac"><?=$lng['PVF'];?></th>
								<th class="tac"><?=$lng['PSF'];?></th>
							</thead>
							<tbody>

								<? if(isset($allowDeductEmpRegFixed) && is_array($allowDeductEmpRegFixed)){ 
									foreach($allowDeductEmpRegFixed as $row){
										if($row['fixed_calc'] == 1){ ?>

										<tr>
											<td><span class="pl-2"><?=$row[$lang]?></span></td>
											<td>
												<span class="pl-2"><?=$classification[$row['classification']]?></span>
											</td>
											<td class="pd_lft">
												<?foreach($income_group as $k => $v){?>
													<?if($k == $row['groups']){echo $v;}?>
												<? } ?>
												<?foreach($deduct_group as $k => $v){?>
													<?if($k == $row['groups']){echo $v;}?>
												<? } ?>
											</td>
											<td class="pd_lft"><?=$tax_base[$row['tax_base']]?></td>
											
											<td><? if($row['pnd1'] == 1){$pndchk='checked="checked"';}else{$pndchk='';}?>
												<input  class="checkbox-custom-black" type="checkbox" name="pnd[<?=$row['id']?>]" value="1" <?=$pndchk?> style="pointer-events: none;margin-top: 4px">
											</td>
											<td><? if($row['sso'] == 1){$ssochk='checked="checked"';}else{$ssochk='';}?>
												<input class="checkbox-custom-black" type="checkbox" name="sso[<?=$row['id']?>]" value="1" <?=$ssochk?> style="pointer-events: none;margin-top: 4px">
											</td>
											<td><? if($row['hour_daily_rate'] == 1){$hour_daily_rate='checked="checked"';}else{$hour_daily_rate='';}?>
												<input class="checkbox-custom-black" type="checkbox" value="1" <?=$hour_daily_rate?> style="pointer-events: none;margin-top: 4px">
											</td>
											<td><? if($row['pvf'] == 1){$pvfpsfchk='checked="checked"';}else{$pvfpsfchk='';}?>
												<input class="checkbox-custom-black" type="checkbox" name="pvfpsf[<?=$row['id']?>]" value="1" <?=$pvfpsfchk?> style="pointer-events: none;margin-top: 4px">
											</td>
											<td><? if($row['psf'] == 1){$psfchk='checked="checked"';}else{$psfchk='';}?>
												<input class="checkbox-custom-black" type="checkbox" name="psf[<?=$row['id']?>]" value="1" <?=$psfchk?> style="pointer-events: none;margin-top: 4px">
											</td>
										</tr>
								<? }  }  } ?>

							</tbody>
						</table>
					</div>
				</div>

			<!-- </form> -->
		</div>

		<div class="tab-pane" id="tab_RelatedTo">
			
			<? include('tabs/tab_employee_groups.php'); ?>
		
		</div>

		<div class="tab-pane" id="tab_EmployeeData" >

			<? include('tabs/tab_employee_data.php'); ?>
			
		</div>

		<div class="tab-pane" id="tab_ManualFeed">

			<? include('tabs/tab_manual_feed.php'); ?>

		</div>

		<div class="tab-pane" id="tab_CalculatedFeed">

			<? include('tabs/tab_calculated_feed.php'); ?>

		</div>

		<div class="tab-pane" id="tab_Attendance">

			<? include('tabs/tab_attendance.php'); ?>

		</div>

		<div class="tab-pane" id="tab_PreviousCalc">
			tab_PreviousCalc
		</div>
		
		<div class="tab-pane" id="tab_SalaryCalc">

			<? include('tabs/tab_salary_calc.php'); ?>

		</div>

		<div class="tab-pane" id="tab_PayrollResult">

			<? include('tabs/tab_payroll_result.php'); ?>

		</div>

		<div class="tab-pane" id="tab_OtherTabs">

			<? include('tabs/tab_verify_center.php'); ?>
		</div>

	</div>

</div>

<div class="modal fade" id="Normalcalculator" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document" style="min-width: 830px !important;">
		<div class="modal-content">
			<form id="FixedIncomecalc">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-calculator"></i>&nbsp; <?=$lng['Income calculator']?></h5>
				<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button> -->
			</div>
			<div class="modal-body modal-tabs" style="padding: 10px 2px 10px 2px">
				<ul class="nav nav-tabs">
					<li class="nav-item"><a class="nav-link active" href="#tab_paidDays" data-toggle="tab"><?=$lng['Paid days']?></a></li>
					<li class="nav-item"><a class="nav-link" href="#tab_fixedIncome" data-toggle="tab"><?=$lng['Fixed income']?></a></li>
					<li class="nav-item"><a class="nav-link" href="#tab_varRates" data-toggle="tab"><?=$lng['Variable Rates']?></a></li>
					<li class="nav-item"><a class="nav-link" href="#tab_Dailywage" data-toggle="tab"><?=$lng['Daily wage']?></a></li>
				</ul>

				<div class="tab-content xtab-flex" style="padding:15px 20px 10px">
					
					<input type="hidden" name="fi_emp_id" id="fiemp_id">		
					<input type="hidden" name="fipaymodel_id" value="<?=$_GET['mid']?>">		
					<div class="tab-pane show active" id="tab_paidDays">
						<table class="basicTable inputs" style="width: 100%;">
							<tbody id="basicinfo">
								<tr>
									<th class="tal"><?=$lng['Joining date']?></th>
									<td id="fijoiningdate" class="pd_lft"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Resign date']?></th>
									<td id="firesigndate" class="pd_lft"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Contract type']?></th>
									<td id="ficontracttype" class="pd_lft"></td>
								</tr>
							</tbody>
						</table>
						<table class="basicTable inputs" style="width: 100%;">
							<tbody id="forNoMonth" style="display: none;">
								<tr >
									<th colspan="3" class="tac text-danger">No calculation available - Paid days are set in attendance data</th>
								</tr>
							</tbody>
							<tbody class="forMonth" style="display: none;">
								<tr>
									<th class="tal"><?=$lng['Employment month']?></th>
									<td colspan="2" id="fiEmploymentmonth" class="pd_lft"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Calculation base']?></th>
									<td colspan="2" id="fiCalculationNrofdays" class="pd_rgt">
										<select name="ficalcBase" style="width: 100%;padding: 4px 0px !important;pointer-events: none;">
											<? foreach($paiddaycalc as $k => $v){ ?>
												<option value="<?=$k?>"><?=$v?></option>
											<? } ?>
										</select>
									</td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Income base']?></th>
									<td colspan="2" id="fiIncomebase" class="pd_lft">
										<!--<select name="fi_incomeBase" id="Sumo_IncomeBase" multiple="multiple" style="width: 100%;padding: 4px 0px !important;">-->
											<? 
											$incomeBasess1 = $paiddays['income_base'];
											$incomeBasess1 = explode(',', $incomeBasess1);
											foreach($data_income as $k=>$v){ 
												if(in_array($k, $incomeBasess1)){ $chkkbox='selected'; echo $v.', ';}else{$chkkbox='';}?>
												<!-- <option value="<?=$k?>" <?=$chkkbox;?>><?=$v?></option> -->
											<? } ?>
										<!--</select>-->
									</td>
								</tr>

								<tr>
									<th class="tal"><?=$lng['Paid days']?></th>
									<td id="fiPaiddays" class="tal">
										<input type="text" name="fipaiddayss" class="numeric tal pd_lft pd_rgt" onchange="addValuesinOthr(this)" readonly>
									</td>
									<th id="paidDays_Manual" class="tal">
										<input type="hidden" name="fipdmanual" value="0">
										<input type="checkbox" class="checkbox-custom-blue mr-4" id="paid_days_manual" name="fipdmanual" value="1" onclick="paiddaysmanual(this)">
										<?=$lng['Manual']?>
									</th>
								</tr>
								
							</tbody>
							
						</table>
						<table class="basicTable inputs mb-4" style="visibility: hidden"></table>
					</div>

					<div class="tab-pane show" id="tab_fixedIncome">
						<table class="basicTable inputs" id="tfiforNoMonth" style="display: none;width: 100%;">
							<tbody>
								<tr>
									<th class="tac text-danger">No calculation available</th>
								</tr>
							</tbody>
						</table>

						<table class="basicTable inputs" id="tfiforMonth" style="display: none;width: 100%;">
							<thead>
								<tr>
									<th class="tal"><?=$lng['Salary']?></th>
									<th class="tal"><?=$lng['Paid days']?></th>
									<th class="tal"><?=$lng['Current']?></th>
									<th class="tal"><?=$lng['Previous']?></th>
									<th colspan="2"></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th class="tal"><?=$lng['Start Date']?></th>
									<td></td>
									<td class="pd_lft pd_rgt" id="fistartDate_curr"></td>
									<td class="pd_lft pd_rgt" id="fistartDate_prev"></td>
									<td colspan="2"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['End date']?></th>
									<td></td>
									<td class="pd_lft pd_rgt" id="fiendDate_curr"></td>
									<td class="pd_lft pd_rgt" id="fiendDate_prev"></td>
									<td colspan="2"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Paid days']?></th>
									<td class="tar pd_lft pd_rgt" id="fiTotalPaidDAys"></td>
									<td>
										<input type="text" class="tar numeric pd_rgt" name="paiddays_curr" style="border: none;">
									</td>
									<td>
										<input type="text" class="tar numeric pd_rgt" name="paiddays_prev" style="border: none;">
									</td>
									<td colspan="2"></td>
								</tr>
							</tbody>
						<!-- </table>

						<table class="basicTable inputs" id="tfiforMonth1" style="display: none;width: 100%;"> -->
							<thead>
								<tr>
									<th class="tal"><?=$lng['Salary']?></th>
									<th class="tal"><?=$lng['Income base']?></th>
									<th class="tal" colspan="2"><?=$lng['Employee register'] .' '.strtolower($lng['Data'])?></th>
									<th class="tal"><?=$lng['Manual correction']?></th>
									<th class="tal"><?=$lng['Benefits this month']?></th>
								</tr>
							</thead>
							<thead>
								<tr>
									<th class="tal"><?=$lng['Allowances']?></th>
									<th class="tal"></th>
									<th class="tal"><?=$lng['Current']?></th>
									<th class="tal"><?=$lng['Previous']?></th>
									<th class="tal"></th>
									<th class="tal"></th>
								</tr>
							</thead>
							<tbody id="appendAllowfi">
								
							</tbody>
						</table>
					</div>

					<div class="tab-pane show" id="tab_varRates">
						<table class="basicTable inputs" id="vrforNoMonth" style="display: none;width: 100%;">
							<tbody>
								<tr>
									<th class="tac text-danger">No calculation available</th>
								</tr>
							</tbody>
						</table>

						<table class="basicTable inputs" id="vrforMonth" style="display: none;width: 100%;">
							<tr>
								<td>
									<table class="basicTable" style="width: 100%;">
										<thead>
											<tr>
												<th class="tal"><?=$lng['HR rate calculation']?></th>
												<th class="tal"><?=$lng['Current']?></th>
												<th class="tal"><?=$lng['Previous']?></th>
												<th class="tal"><?=$lng['Manual correction']?></th>
											</tr>
										</thead>
										<thead>
											<tr>
												<th class="tal"><?=$lng['Allowances']?></th>
												<th class="tal"><?=$lng['THB/HR']?></th>
												<th class="tal"><?=$lng['THB/HR']?></th>
												<th class="tal"></th>
											</tr>
										</thead>
										<tbody id="vrappendAllowfi_left">
								
										</tbody>
									</table>
								</td>
								<td style="vertical-align: top;">
									<table class="basicTable" style="width: 100%;">
										<thead>
											<tr>
												<th class="tal" colspan="3"><?=$lng['Per event calculation']?></th>
												<th class="tal"><?=$lng['Manual correction']?></th>
											</tr>
										</thead>
										<thead>
											<tr>
												<th class="tal"><?=$lng['Allowances']?></th>
												<th class="tal"><?=$lng['THB'].'/'.$lng['Unit']?></th>
												<th class="tal"><?=$lng['Unit']?></th>
												<th class="tal"></th>
											</tr>
										</thead>
										<tbody id="vrappendAllowfi_right">
								
										</tbody>
									</table>
								</td>
							</tr>
						</table>
					</div>

					<div class="tab-pane show" id="tab_Dailywage">
						<table class="basicTable inputs" id="dwforNoMonth" style="display: none;">
							<tbody>
								<tr>
									<th class="tac text-danger">No calculation available</th>
								</tr>
							</tbody>
						</table>

						<table class="basicTable inputs" id="dwforMonth1" style="display: none;">
							<tbody>
								<tr>
									<th class="tal"><?=$lng['Daily wage']?></th>
									<td class="tar pd_lft pd_rgt" id="tdwdailywage">
										<input type="text" class="tar float72" name="day_daily_wage" readonly>
									</td>
									<td>
										<input type="checkbox" onclick="dayDailyChkBox(this)" class="checkbox-custom-blue tac">
									</td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Nr of hrs']?></th>
									<td class="tar pd_lft pd_rgt" id="tdwNrofhrs">
										<input type="text" class="tar hourFormat" name="day_daily_hrs" readonly>
									</td>
									<td>
										<input type="checkbox" onclick="dayHrsChkBox(this)" class="checkbox-custom-blue tac">
									</td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Rate'].'/'.$lng['Hr']?></th>
									<td class="tar pd_lft pd_rgt" id="tdwRateHrs"></td>
								</tr>
							</tbody>
						</table>

						<table class="basicTable inputs" id="dwforMonth2" style="display: none;width: 100%;">
							<tr>
								<td>
									<table class="basicTable">
										<thead>
											<tr>
												<th class="tal" colspan="2"><?=$lng['HR rate calculation']?></th>
												<th class="tal"><?=$lng['Manual correction']?></th>
											</tr>
											<tr>
												<th class="tal"><?=$lng['Allowances']?></th>
												<th class="tal"><?=$lng['Rate']?></th>
												<th class="tal"></th>
											</tr>
										</thead>
										<tbody id="DwAppendData_left">
								
										</tbody>
									</table>
								</td>
								<td style="vertical-align: top;">
									<table class="basicTable">
										<thead>
											<tr>
												<th class="tal" colspan="3"><?=$lng['Per event calculation']?></th>
												<th class="tal"><?=$lng['Manual correction']?></th>
											</tr>
											<tr>
												<th class="tal"><?=$lng['Allowances']?></th>
												<th class="tal"><?=$lng['THB'].'/'.$lng['Unit']?></th>
												<th class="tal"><?=$lng['Unit']?></th>
												<th class="tal"></th>
											</tr>
										</thead>
										<tbody id="DwAppendData_right">
								
										</tbody>
									</table>
								</td>
							</tr>
						</table>
					</div>
				</div>

			</div>
			<div class="modal-footer">
	        	<button type="button" onclick="FixedIncomeCalculation()" class="btn btn-primary"><?=$lng['Calculate']?></button>
	        	<button type="button" onclick="window.location.reload(); "class="btn btn-danger"><?=$lng['Close popup']?></button>
	      	</div>
	      	</form>
		</div>
	</div>
</div>

<!-- <div class="modal fade" id="Normalcalculator" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document" style="min-width: 890px !important;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-calculator"></i>&nbsp; <?=$lng['Edit Calculation']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body modal-tabs">
			<form id="EditEmpCalc">

				<input type="hidden" name="emp_id" id="empids">
				<input type="hidden" id="basicSalaryamt"> 

				<table id="editcalc" class="basicTable inputs" border="0" style="width: 100%;">
					<thead>
						<tr>
							<th class="tac" colspan="4" style="color: #000;"><?=strtoupper($lng['Days based on joining And/Or resign date'])?></th>
							<th><?=strtoupper($lng['Salary items'])?></th>
							<th><?=strtoupper($lng['Current'])?></th>
							<th><?=strtoupper($lng['Previous'])?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th><?=$lng['Joining date']?></th>
							<td>
								<input type="text" name="joining_date" id="jdate">
							</td>
							<th><?=$lng['Calculation basis']?></th>
							<td>
								<select style="width: 100%;pointer-events: none">
									<?foreach($paiddaycalc as $k => $v){?>
										<option value="<?=$k?>" <?if($k == $paiddays['opt']){echo 'selected';}?>><?=$v?></option>
									<? } ?>
								</select>
							</td>
							<th><?=$lng['Start date']?></th>
							<td>
								<input type="text" name="startdatecurr" id="cstartd">
							</td>
							<td>
								<input type="text" name="startdatepre" id="pstartd">
							</td>
						</tr>
						<tr>
							<th><?=$lng['Last working day']?></th>
							<td>
								<input type="text" name="resign_date" id="rdate">
							</td>
							<th><?=$lng['Paid days']?></th>
							<td>
								<?if($paiddays['opt'] == 3){
									$PaidDays = $paiddays['days']; $readonly=''; $bgclass='inptbkg';
								}elseif($paiddays['opt'] == 2){
									$PaidDays = 30; $readonly = 'readonly="readonly"'; $bgclass='';
								}else{
									$PaidDays = cal_days_in_month(CAL_GREGORIAN, $_SESSION['rego']['curr_month'], $_SESSION['rego']['cur_year']); $readonly = 'readonly="readonly"'; $bgclass='';
								}?>
								<input type="text" class="numeric sel <?=$bgclass?>" name="paiddays" value="<?=$PaidDays?>" <?=$readonly?>>
							</td>
							<th><?=$lng['End date']?></th>
							<td>
								<input type="text" name="enddatecurr" id="cendd">
							</td>
							<td>
								<input type="text" name="enddatepre" id="pendd">
							</td>
						</tr>
						<tr>
							<th><?=$lng['Nr of days']?></th>
							<td>
								<input type="text" name="nrof_days" id="nr_of_days">
							</td>
							<th><?=$lng['Total paid days']?></th>
							<td>
								<input type="text" name="ttl_paydays" id="totl_paydays">
							</td>
							<th><?=$lng['Days paid']?></th>
							<td>
								<input type="text" name="dayspaidcurr" class="numeric sel inptbkg" id="dayspaidcurrnt">
							</td>
							<td></td>
						</tr>
					</tbody>
				
					<thead>
						<tr>
							<th colspan="2" class="tal"><?=$lng['Item']?></th>
							<th><?=$lng['Current'].' '.$lng['Benefits']?></th>
							<th><input type="checkbox" name="calc_manual" class="mr-2" onclick="checkmanualchkbox(this)"> <?=$lng['Manual']?></th>
							<th><?=$lng['Emp. Reg.']?></th>
							<th><?=$lng['Current']?></th>
							<th><?=$lng['Previous']?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th colspan="2" class="tal"><?=$lng['Basic salary']?></th>
							<td>
								<input type="text" name="basissal" id="basicsalval">
							</td>
							<td>
								<input type="text" name="manualSlry" class="mninputs" readonly="readonly">
							</td>
							<th class="tal"><?=$lng['Basic salary']?></th>
							<td>
								<input type="text" name="bsalcurr" id="bsalycrnt">
							</td>
							<td></td>
						</tr>
					</tbody>
					<tbody id="appendAllow">
						

					</tbody>
				</table>


				<div class="clear" style="height:15px"></div>

				<button class="btn btn-primary btn-fr" type="button" data-dismiss="modal"><?=$lng['Cancel']?></button>
				<button onclick="Recalculate();" class="btn btn-primary mr-1 btn-fr" type="button"><?=$lng['Recalculate']?></button>
				<button class="btn btn-primary ml-1 " type="button"><i class="fa fa-save mr-1"></i> <?=$lng['Save']?></button>
				<div class="clear"></div>
			</form>
			</div>
		</div>
	</div>
</div> -->


<script type="text/javascript">

	function FixedIncomeCalculation(){

		var fiemp_id = $('#Normalcalculator input#fiemp_id').val();
		var payrollMdlid = $('#Normalcalculator input[name="fipaymodel_id"]').val();

		var frm = $('form#FixedIncomecalc');
		var data = frm.serialize();

		$.ajax({
			url: "ajax/update_employee_income_calc.php",
			data: data,
			success: function(result){
				if(result == 'success'){

					opencalculator(this,1,fiemp_id);
					$("body").overhang({
						type: "success",
						message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
						duration: 2,
					})

				}else{
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: '+ result,
						duration: 3,
						callback: function(v){
							location.reload();
						}
					})
				}
			}
		})

		setTimeout( function() { opencalcAgain(); }, 3000);
						
	}


	function hrsOption(that,id){

		if($(that).attr('checked',true)){
			$('#calcOpt'+id).attr('disabled',false).css('visibility','visible').addClass('inptbkg');
			$('#multiplicator'+id).attr('disabled',false).addClass('inptbkg');
			$('#nrhrs'+id).attr('disabled',false).addClass('inptbkg').attr('placeholder','000:00');
			$('#incomeBase'+id).attr('disabled',false);
			$('#incomeBase'+id+' option[value="56"]').attr('selected',true);
			$('input[name="income_base['+id+']"]').val(56);
			$('#incomeBase'+id).closest('div.SumoSelect').removeClass('disabled');
			$('#incomeBase'+id).closest('div.SumoSelect').css('visibility','visible');
			$(".hourFormat").mask("999:99", {placeholder: "000:00"});

			//==== For Times 
			if($('#times'+id).prop('checked')){
				$('#thbunit'+id).attr('disabled',false).addClass('inptbkg');
				$('#unitarr'+id).attr('disabled',false).css('visibility','visible').addClass('inptbkg');
			}else{
				$('#thbunit'+id).attr('disabled',true).removeClass('inptbkg');
				$('#unitarr'+id).attr('disabled',true).val('').css('visibility','hidden').removeClass('inptbkg');
			}
			
		}else{
			$('#multiplicator'+id).attr('disabled',true).removeClass('inptbkg');
			$('#calcOpt'+id).attr('disabled',true).val('').css('visibility','hidden').removeClass('inptbkg');
			$('#nrdays'+id).attr('disabled',true).removeClass('inptbkg');
			$('#nrhrs'+id).attr('disabled',true).removeClass('inptbkg').val('').attr('placeholder','');
			$('#incomeBase'+id).attr('disabled',true).val('');
			$('#incomeBase'+id).attr('selected',false);
			$('#incomeBase'+id).closest('div.SumoSelect').addClass('disabled');
			$('#incomeBase'+id).closest('div.SumoSelect').css('visibility','hidden');
		}

		if($(that).is(':not(:checked)')){
			$('#multiplicator'+id).attr('disabled',true).removeClass('inptbkg').val('');
			$('#calcOpt'+id).attr('disabled',true).css('visibility','hidden').removeClass('inptbkg');
			$('#nrdays'+id).attr('disabled',true).removeClass('inptbkg').val('');
			$('#nrhrs'+id).attr('disabled',true).removeClass('inptbkg').val('').attr('placeholder','');
			$('#incomeBase'+id).attr('disabled',true).val('');
			$('input[name="income_base['+id+']"]').val('');
			$('#incomeBase'+id).attr('selected',false);
			$('#incomeBase'+id).closest('div.SumoSelect').addClass('disabled');
			$('#incomeBase'+id).closest('div.SumoSelect').css('visibility','hidden');
		}
	}

	function timesOption(that,id){

		if($(that).attr('checked',true)){ 
			
			$('#thbunit'+id).attr('disabled',false).addClass('inptbkg');
			$('#unitarr'+id).attr('disabled',false).css('visibility','visible').addClass('inptbkg');

			//==== For Hrs 
			if($('#hrs'+id).prop('checked')){
			
				$('#calcOpt'+id).attr('disabled',false).css('visibility','visible').addClass('inptbkg');
				$('#multiplicator'+id).attr('disabled',false).addClass('inptbkg');
				$('#nrhrs'+id).attr('disabled',false).addClass('inptbkg').attr('placeholder','000:00');
				$('#incomeBase'+id).attr('disabled',false);
				$('#incomeBase'+id+' option[value="56"]').attr('selected',true);
				$('input[name="income_base['+id+']"]').val(56);
				$('#incomeBase'+id).closest('div.SumoSelect').removeClass('disabled');
				$('#incomeBase'+id).closest('div.SumoSelect').css('visibility','visible');
				$(".hourFormat").mask("999:99", {placeholder: "000:00"});
				
			}else{
				
				$('#multiplicator'+id).attr('disabled',true).removeClass('inptbkg');
				$('#calcOpt'+id).attr('disabled',true).val('').css('visibility','hidden').removeClass('inptbkg');
				$('#nrdays'+id).attr('disabled',true).removeClass('inptbkg').val('');
				$('#nrhrs'+id).attr('disabled',true).removeClass('inptbkg').val('').attr('placeholder','');
				$('#incomeBase'+id).attr('disabled',true).val('');
				$('#incomeBase'+id).attr('selected',false);
				$('#incomeBase'+id).closest('div.SumoSelect').addClass('disabled');
				$('#incomeBase'+id).closest('div.SumoSelect').css('visibility','hidden');
			}

			
		}else{
			$('#thbunit'+id).attr('disabled',true).removeClass('inptbkg');
			$('#unitarr'+id).attr('disabled',true).val('').css('visibility','hidden').removeClass('inptbkg');
		}

		if($(that).is(':not(:checked)')){

			$('#thbunit'+id).attr('disabled',true).removeClass('inptbkg').val('');
			$('#unitarr'+id).attr('disabled',true).val('').css('visibility','hidden').removeClass('inptbkg');
		}
	}


	function thbOption(that,id){
		if($(that).attr('checked',true)){
			$('#calcOpt'+id).attr('disabled',true).css('visibility','hidden').removeClass('inptbkg');
			$('#nrdays'+id).attr('disabled',true).removeClass('inptbkg');
			$('#nrhrs'+id).attr('disabled',true).removeClass('inptbkg').attr('placeholder','');
			$('#multiplicator'+id).attr('disabled',true).removeClass('inptbkg');
			$('#incomeBase'+id).attr('disabled',true);
			$('#incomeBase'+id).closest('div.SumoSelect').addClass('disabled');
			$('#incomeBase'+id).closest('div.SumoSelect').css('visibility','hidden');
			$('#incomeBase'+id).closest('input[name="income_base['+id+']"]');
		
			$('#thbunit'+id).attr('disabled',true).removeClass('inptbkg');
			$('#unitarr'+id).attr('disabled',true).css('visibility','hidden').removeClass('inptbkg');

			//==== For Hrs 
			if($('#hrs'+id).prop('checked')){
				$('#calcOpt'+id).attr('disabled',false).css('visibility','visible').addClass('inptbkg');
				$('#multiplicator'+id).attr('disabled',false).addClass('inptbkg');
				$('#nrhrs'+id).attr('disabled',false).addClass('inptbkg').attr('placeholder','000:00');
				$('#incomeBase'+id).attr('disabled',false);
				$('#incomeBase'+id+' option[value="56"]').attr('selected',true);
				$('input[name="income_base['+id+']"]').val(56);
				$('#incomeBase'+id).closest('div.SumoSelect').removeClass('disabled');
				$('#incomeBase'+id).closest('div.SumoSelect').css('visibility','visible');
				$(".hourFormat").mask("999:99", {placeholder: "000:00"});
				
			}else{
				
				$('#multiplicator'+id).attr('disabled',true).removeClass('inptbkg');
				$('#calcOpt'+id).attr('disabled',true).val('').css('visibility','hidden').removeClass('inptbkg');
				$('#nrdays'+id).attr('disabled',true).removeClass('inptbkg');
				$('#nrhrs'+id).attr('disabled',true).removeClass('inptbkg').val('').attr('placeholder','');
				$('#incomeBase'+id).attr('disabled',true).val('');
				$('#incomeBase'+id).attr('selected',false);
				$('#incomeBase'+id).closest('div.SumoSelect').addClass('disabled');
				$('#incomeBase'+id).closest('div.SumoSelect').css('visibility','hidden');
			}

			//==== For Times 
			if($('#times'+id).prop('checked')){
				$('#thbunit'+id).attr('disabled',false).addClass('inptbkg');
				$('#unitarr'+id).attr('disabled',false).css('visibility','visible').addClass('inptbkg');
			}else{
				$('#thbunit'+id).attr('disabled',true).removeClass('inptbkg');
				$('#unitarr'+id).attr('disabled',true).val('').css('visibility','hidden').removeClass('inptbkg');
			}
		}
	}



	function calcoptsel(that,id){
		if(that == 3){
			$('#nrdays'+id).attr('readonly',false).addClass('inptbkg');
			$('#nrhrs'+id).attr('readonly',false).addClass('inptbkg');
		}else{

			if(that == 1){
				var calcdays = <?=$daysCalc;?>;
				$('#nrdays'+id).attr('readonly',true).removeClass('inptbkg');
				$('#nrdays'+id).val(calcdays);
			}else{
				$('#nrdays'+id).attr('readonly',true).removeClass('inptbkg');
				$('#nrdays'+id).val(30);
			}
			
		}
	}


	function Recalculate(){

		var basisSlry = $('#basicSalaryamt').val();
		var dayspaidcurrnt = $('#dayspaidcurrnt').val();
		var paiddays = $('#paiddays').val();
		
		var newslry = (basisSlry * dayspaidcurrnt) / paiddays;
		$('#basicsalval').val(newslry.format(2));
	}

	
	function opencalcAgain(){
		//var empid = $(that).data('id');
		var frm = $('form#FixedIncomecalc');
		var data = frm.serialize();
		$.ajax({
			url: "ajax/update_employee_income_calc.php",
			data: data,
			success: function(result){
					return true;
				}
			})
	}


	function opencalculator(that,type,empid){
		//var empid = $(that).data('id');
		var empid = empid;
		var nrdays = '<?=$paiddaycalc[$paiddays['paid_days']];?>';
		var nrdaysVal = '<?=$paiddays['paid_days'];?>';
		var income_basessName = '<?=$income_basessName;?>';
		var income_basessVal = '<?=$paiddays['income_base'];?>';
		var incomebasessVal = income_basessVal.split(',');

		//console.log(incomebasessVal);
		var PaidDays = '<?=$noOfPaidDays?>';
		var Paidnrhrs = '<?=$paiddays['nrhrs']?>';
		var data_incomefi = <?=json_encode($data_income)?>;
		var payrollparam = <?=json_encode($payrollparametersformonth)?>;
		var varallowdedt = <?=json_encode($getAttendAllowDeduct)?>;
		var unitopt = <?=json_encode($unitopt)?>;
		var mid = '<?=$_GET['mid']?>';
		
		if(empid !=''){
			$.ajax({
				type: "post",
				url: "ajax/get_payroll_data.php",
				data: {empid: empid,nrdaysVal:nrdaysVal,PaidDays:PaidDays,mid:mid},
				success: function(result){

					if(result == 'error'){
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: '+ result,
							duration: 3,
							callback: function(v){
								window.location.reload();
							}
						})
					}else{

						 
						var data = JSON.parse(result);
						console.log(data);

						/*console.log(data['employee_career'][0]['fix_allow']);
						data1 = $.parseJSON(data['employee_career'][0]['fix_allow']);
						console.log(data1);*/

						//============ Tab 1 start =============//
						$('#Normalcalculator input#fiemp_id').val(empid);
						$('#Normalcalculator #fijoiningdate').text(data['joining_date']);
						$('#Normalcalculator #firesigndate').text(data['resign_date']);
						$('#Normalcalculator #ficontracttype').text(data.contract_type);

						$('#Normalcalculator #basicinfo').css('display','table-row');
						
						if(data.contract_type != 'Monthly wage'){
							$('#Normalcalculator #forNoMonth').css('display','table-row');
							$('#Normalcalculator .forMonth').css('display','none');
						}else{
							$('#Normalcalculator #forNoMonth').css('display','none');
							$('#Normalcalculator .forMonth').css('display','table-row');

							$('#Normalcalculator #fiEmploymentmonth').text(data.employeement_month);
							$('#Normalcalculator #fiCalculationNrofdays select[name="ficalcBase"] option[value="'+nrdaysVal+'"]').attr('selected', true);
							
							//$('#Normalcalculator #fiIncomebase').text(income_basessName);
							$('#Normalcalculator #fiPaiddays input[name="fipaiddayss"]').val(data['tot_paid_days']);
						}

						//============ Tab 1 end =============//

						//============ Tab 2 start =============//
						if(data.contract_type != 'Monthly wage'){
							$('#Normalcalculator #tfiforNoMonth').css('display','inline-table');
							$('#Normalcalculator #tfiforMonth').css('display','none');
							$('#Normalcalculator #tfiforMonth1').css('display','none');
						}else{
							$('#Normalcalculator #tfiforNoMonth').css('display','none');
							$('#Normalcalculator #tfiforMonth').css('display','inline-table');
							$('#Normalcalculator #tfiforMonth1').css('display','inline-table');


							$('#Normalcalculator #fistartDate_curr').text(data['startDate_curr']);
							$('#Normalcalculator #fistartDate_prev').text(data['startDate_prev']);
							$('#Normalcalculator #fiendDate_prev').text(data['endDate_prev']);

							if(data['paid_days_manual'] == 1){
								var pdmanual=true; 
								var pdreadval=false;
							}else{
								var pdmanual=false; 
								var pdreadval=true;
							}
							//alert(pdreadval);
							$('#Normalcalculator #paid_days_manual').attr('checked', pdmanual);
							
							var paiddaysval = $('#Normalcalculator #fiPaiddays input[name="fipaiddayss"]').val();
							$('#Normalcalculator #fiTotalPaidDAys').text(paiddaysval);
							if(pdreadval == false){ //alert('jk');
								$('#Normalcalculator #fiPaiddays input[name="fipaiddayss"]').attr('readonly', pdreadval).addClass('addbg');
							}else{
								$('#Normalcalculator #fiPaiddays input[name="fipaiddayss"]').attr('readonly', pdreadval).removeClass('addbg');
							}
							
							if(data['days_prev'] == ''){ var curprev = 'true';}else{ var curprev = 'false';}
							$('#Normalcalculator input[name="paiddays_curr"]').val(data['paid_days_curr']).attr('readonly', curprev);
							$('#Normalcalculator input[name="paiddays_prev"]').val(data['paid_days_prev']).attr('readonly', curprev);
							
							
							/*var allowArr = [];
							$.each(data['emp_career_allow_curr'], function( index, value ) {
								allowArr[index] = value;
							})*/

							var hrs_curr_wages = [];
							$.each(data['hrs_curr_wages'], function( index, value ) {
								hrs_curr_wages[index] = value;
							})

							var times_curr_wages = [];
							$.each(data['times_curr_wages'], function( index, value ) {
								times_curr_wages[index] = value;
							})

							
							var incomeCalc_manual = [];
							$.each(data['incomeCalc_manual'], function( index, value ) {
								incomeCalc_manual[index] = value;
							})

							/*var incomeCalc_total = [];
							$.each(data['incomeCalc_total'], function( index, value ) {
								incomeCalc_total[index] = value;
							})*/

							var incomeCalc_yesno = [];
							$.each(data['incomeCalc_yesno'], function( index, value ) {
								incomeCalc_yesno[index] = value;
							})

							var dedctArr = [];
							$.each(data['fix_deduct_from_emp'], function( index, value ) {
								dedctArr[index] = value;
							})

							var checkArr = [];
							$.each(incomebasessVal, function( index, value ) {
								checkArr[value] = value;
							})

							var tbl; 
							data_incomefi = Object.keys(data_incomefi).map(
					    	function(key) {
					         	return { num : key , char : data_incomefi[key]};
					    	});
							var sorted = data_incomefi.sort(function(a, b) {
						            if(a.char < b.char) return -1; return 1;
					        });

							$.each(sorted, function( key, value ) {

								var index = value['num'];
								var currVal=0;
								var prevVal=0;
								
								if(data['emp_career_allow_curr'][index] != undefined){
									currVal = data['emp_career_allow_curr'][index];
								}else if(data['emp_career_dedct_curr'][index] != undefined){
									currVal = data['emp_career_dedct_curr'][index];
								}else{
									if(index == 56){
										currVal = data['salary_curr'];
									}
								}

								if(data['emp_career_allow_prev'][index] != undefined){
									prevVal = data['emp_career_allow_prev'][index];
								}else if(data['emp_career_dedct_prev'][index] != undefined){
									prevVal = data['emp_career_dedct_prev'][index];
								}else{
									if(index == 56){
										prevVal = data['salary_prev'];
									}
								}

								var incomebasechk = 'N';
								var yesno = 0;
								var yesno_sel = '';
								if(incomeCalc_yesno[index] == 1){
									incomebasechk = 'Y';
									yesno = 1;
									yesno_sel = 'selected';
								}else{
									if(checkArr[index] != undefined){
										incomebasechk = 'Y';
										yesno = 1;
										yesno_sel = 'selected';
									}
								}

								/*selincome = '<select name="incbaseopt" id="IncomBaseopt_'+index+'" style="width:100%;">';
								$.each(sorted, function( key2, value2 ) {
									if(checkArr[value2['num']] == value2['num']){var chked='selected';}else{var chked='';}
									selincome += '<option value="'+value2['num']+'" '+chked+'>'+value2['char']+'</option>';
								})
								selincome += '</select>'; */
								var incomeCalc_manual_val=0;
								if(incomeCalc_manual[index] > 0){
									incomeCalc_manual_val = incomeCalc_manual[index];
								}
								

								var currvalss;
								if(currVal > 0){currVal=currVal;}else{currVal=0;}
								/*var total = parseFloat(currVal) + parseFloat(incomeCalc_manual_val);
								total = total.toFixed(2);
								if(yesno == 1){
									currvalss = parseFloat(currVal / PaidDays * data['tot_paid_days']);
									currvalss = currvalss.toFixed(2);
									total = parseFloat(currvalss) + parseFloat(prevVal) + parseFloat(incomeCalc_manual_val);
								}else{
									currvalss = currVal;
								}*/

								if(yesno == 1){
									var currvalss = parseFloat(currVal / PaidDays) * parseFloat(data['tot_paid_days']);
									currvalss = currvalss.toFixed(2); 
									var total = parseFloat(currvalss) + parseFloat(prevVal) + parseFloat(incomeCalc_manual_val);
								}else{
									var total = parseFloat(currVal) + parseFloat(incomeCalc_manual_val);
								}

								//alert(total);

								/*var incomeCalc_total_val=0;
								if(incomeCalc_total[index] > 0){
									incomeCalc_total_val = incomeCalc_total[index];
								}*/

								

  								tbl += '<tr>';
								tbl += '<td class="tal pd_lft">'+value['char']+'</td>';
								//tbl += '<td class="tal pd_lft pd_rgt">'+selincome+'</td>';
								//tbl += '<td class="tac">'+incomebasechk+'</td>';
								tbl += '<td class="tac" style="background: #f8f8d1 !important;"><select style="width:100%;background: #f8f8d1 !important;" name="yeno_ib['+index+']" onchange="incomeBaseoptions(this, '+index+')"><?foreach($noyes01 as $key => $value){?><option value="<?=$key?>" '+yesno_sel+'><?=$value?></option><?}?></select></td>';
								tbl += '<td class="tar pd_lft pd_rgt" id="currVal_'+index+'">'+number_format(currVal)+'</td>';
								tbl += '<td class="tar pd_lft pd_rgt" id="prevVal_'+index+'">'+number_format(prevVal)+'</td>';
								tbl += '<td style="background: #f8f8d1 !important;">';
								tbl += '<input type="text" name="manualAllow['+index+']" class="tar" style="border: none;background: #f8f8d1 !important;" value="'+incomeCalc_manual_val+'" onchange="incomeBaseoptions(this, '+index+',)">';
								tbl += '</td>';
								tbl += '<td class="tar pd_lft pd_rgt"><input class="tar" type="text" id="totalVal_'+index+'" name="fitotalVal['+index+']" value="'+number_format(total)+'" readonly></td>';
								//tbl += '<td class="tar pd_lft pd_rgt"><input class="tar" type="text" id="totalVal_'+index+'" name="fitotalVal['+index+']" value="'+incomeCalc_total_val+'" readonly></td>';
								tbl += '</tr>';

																							
							});

							$('#Normalcalculator #appendAllowfi tr').remove();
							$('#Normalcalculator #appendAllowfi').append(tbl);
						}
						//============ Tab 2 end =============//

						//============ Tab 3 start =============//
						if(data.contract_type != 'Monthly wage'){
							$('#Normalcalculator #vrforNoMonth').css('display','inline-table');
							$('#Normalcalculator #vrforMonth').css('display','none');
						}else{
							$('#Normalcalculator #vrforNoMonth').css('display','none');
							$('#Normalcalculator #vrforMonth').css('display','inline-table');

							var tbl1;
							var tbl2;
							$.each(payrollparam, function( index, value ) {

								if(value.man_att == 1 && value.allowopt == 'hrs'){

									var pp_income_base = value.pp_income_base;
									var tot_income_base = pp_income_base.split(',');
									var TotalIncome = 0;
									$.each(tot_income_base, function( key, valuedd ) {
										var index = valuedd;
										if(data['emp_career_allow_curr'][index] != undefined){
											if( data['emp_career_allow_curr'][index] > 0){
												var TotalIncomess = parseFloat(data['emp_career_allow_curr'][index]);
											}else{
												var TotalIncomess = parseFloat(0);
											}
											TotalIncome += parseFloat(TotalIncomess);
										}else if(data['emp_career_dedct_curr'][index] != undefined){
											if( data['emp_career_dedct_curr'][index] > 0){
												var TotalIncomessd = parseFloat(data['emp_career_dedct_curr'][index]);
											}else{
												var TotalIncomessd = parseFloat(0);
											}
											TotalIncome += parseFloat(TotalIncomessd);
										}else{
											if(index == 56){
												TotalIncome += parseFloat(data['salary_curr']);
											}
										}
									})


									
									var nrhrs = value.nrhrs;
									var nrhrsval = nrhrs.split(":");
									var nrdayss = value.nrdays;
									if(nrdayss < 1){nrdayss=1;}


									//TotalIncome.replace(",", "");
									var currCalc = parseFloat(TotalIncome / nrdayss / nrhrsval[0]) * parseFloat(value.multiplicator); 
									var currCalcs = currCalc.toFixed(2);

									$('#Normalcalculator .modal-header h5#apph5').remove();
									if(hrs_curr_wages[index] != currCalcs){ 
										$('#Normalcalculator .modal-header').append('<h5 id="apph5" class="text-right font-italic font-weight-bold text-danger">Please calculate income again</h5>');
									}

									tbl1 += '<tr>';
									tbl1 += '<td class="tal pd_lft">'+value.en+'</td>';
									tbl1 += '<td class="tal pd_lft"><input type="text" id="hrs_curr_'+index+'" name="hrs_curr_wages['+index+']" class="tar float72" value="'+currCalcs+'" style="border: none;" readonly></td>';
									tbl1 += '<td class="tal pd_lft"><input type="text" id="hrs_prev_'+index+'" name="hrs_prev_wages['+index+']" class="tar float72" style="border: none;" readonly></td>';
									tbl1 += '<td class="tac pd_lft"><input type="checkbox" onclick="EditHrswages(this,'+index+')" name="VarManualAllow['+index+']" class="checkbox-custom-blue tac" style="border: none;"></td>';
									tbl1 += '</tr>';
								}

								if(value.man_att == 1 && value.allowopt == 'times'){

									var thbunitval = value.thbunit;
									//if(times_curr_wages[index]){ thbunitval = number_format(times_curr_wages[index]); }

									tbl2 += '<tr>';
									tbl2 += '<td class="tal pd_lft">'+value.en+'</td>';
									tbl2 += '<td class="tal pd_lft"><input type="text" id="times_curr_'+index+'" name="times_curr_wages['+index+']" class="tar float72" value="'+thbunitval+'" style="border: none;" readonly></td>';
									tbl2 += '<td class="tal pd_lft">'+unitopt[value.unitarr]+'</td>';
									tbl2 += '<td class="tac pd_lft"><input type="checkbox" onclick="EditTimeswages(this,'+index+')" name="VarManualAllow['+index+']" class="checkbox-custom-blue tac" style="border: none;"></td>';
									tbl2 += '</tr>';
								}
							})

							$('#Normalcalculator #vrappendAllowfi_left tr').remove();
							$('#Normalcalculator #vrappendAllowfi_left').append(tbl1);

							$('#Normalcalculator #vrappendAllowfi_right tr').remove();
							$('#Normalcalculator #vrappendAllowfi_right').append(tbl2);
						}
						//============ Tab 3 end =============//

						//============ Tab 4 start =============//
						var rate_wagess = [];
						$.each(data['rate_wages'], function( index, value ) {
							rate_wagess[index] = value;
						})

						var thb_wages = [];
						$.each(data['thb_wages'], function( index, value ) {
							thb_wages[index] = value;
						})

						if(data.contract_type == 'Monthly wage'){
							$('#Normalcalculator #dwforNoMonth').css('display','inline-table');
							$('#Normalcalculator #dwforMonth1').css('display','none');
							$('#Normalcalculator #dwforMonth2').css('display','none');
						}else{
							$('#Normalcalculator #dwforNoMonth').css('display','none');
							$('#Normalcalculator #dwforMonth1').css('display','table-row');
							$('#Normalcalculator #dwforMonth2').css('display','inline-table');

							$('#Normalcalculator #tdwdailywage input[name="day_daily_wage"]').val(data['day_daily_wage']);
							if(data['paid_hours'] !=''){
								Paidnrhrs = data['paid_hours'];
							}
							$('#Normalcalculator #tdwNrofhrs input[name="day_daily_hrs"]').val(Paidnrhrs);
							var nrhrsdd = Paidnrhrs;
							/*var rhrsval = nrhrsdd.split(":");
							var totHrs = parseFloat(rhrsval[0] + (rhrsval[1]/60));
							var ratehr = parseFloat(data['day_daily_wage'] / totHrs);*/
							var ratehr = data['rate_hr'];
							$('#Normalcalculator #tdwRateHrs').text(ratehr);

							var tbl3;
							var tbl4;
							$.each(payrollparam, function( index, value ) {

								if(value.man_att == 1 && value.allowopt == 'hrs'){

									var pp_income_base4 = value.pp_income_base;
									var tot_income_base4 = pp_income_base4.split(',');
									var TotalIncome4 = 0;
									$.each(tot_income_base4, function( key, valuedd ) {
										var index = valuedd;
										if(data['emp_career_allow_curr'][index] != undefined){
											if( data['emp_career_allow_curr'][index] > 0){
												var TotalIncomess = parseFloat(data['emp_career_allow_curr'][index]);
											}else{
												var TotalIncomess = parseFloat(0);
											}
											TotalIncome4 += parseFloat(TotalIncomess);
										}else if(data['emp_career_dedct_curr'][index] != undefined){
											if( data['emp_career_dedct_curr'][index] > 0){
												var TotalIncomessd = parseFloat(data['emp_career_dedct_curr'][index]);
											}else{
												var TotalIncomessd = parseFloat(0);
											}
											TotalIncome4 += parseFloat(TotalIncomessd);
										}else{
											if(index == 56){
												TotalIncome4 += parseFloat(data['salary_curr']);
											}
										}
									})
									
									var nrhrs = value.nrhrs;
									var nrhrsval = nrhrs.split(":");
									//var currCalc = parseFloat(TotalIncome4 / value.nrdays / nrhrsval[0]) * parseFloat(value.multiplicator);
									//var currCalc = parseFloat(TotalIncome4) * parseFloat(value.multiplicator);
									var currCalc = parseFloat(ratehr) * parseFloat(value.multiplicator);
									var currCalcss = currCalc.toFixed(2);
									//alert()
									//if(rate_wagess[index]){ currCalcss = number_format(rate_wagess[index]); }

									tbl3 += '<tr>';
									tbl3 += '<td class="tal pd_lft">'+value.en+'</td>';
									tbl3 += '<td class="tal pd_lft"><input type="text" id="rate_'+index+'" name="rate_wages['+index+']" class="tar float72" value="'+currCalcss+'" style="border: none;" readonly></td>';
									tbl3 += '<td class="tac pd_lft"><input type="checkbox" onclick="ratewages(this,'+index+')" name="rateAllow['+index+']" class="checkbox-custom-blue tac" style="border: none;"></td>';
									tbl3 += '</tr>';
								}

								if(value.man_att == 1 && value.allowopt == 'times'){
									var timethbUnit = value.thbunit;
									//if(thb_wages[index]){ timethbUnit = number_format(thb_wages[index]); }

									tbl4 += '<tr>';
									tbl4 += '<td class="tal pd_lft">'+value.en+'</td>';
									tbl4 += '<td class="tal pd_lft"><input type="text" id="thb_'+index+'" name="thb_wages['+index+']" class="tar float72" value="'+timethbUnit+'" style="border: none;" readonly></td>';
									tbl4 += '<td class="tal pd_lft">'+unitopt[value.unitarr]+'</td>';
									tbl4 += '<td class="tac pd_lft"><input type="checkbox" onclick="thbwages(this,'+index+')" name="thbAllow['+index+']" class="checkbox-custom-blue tac" style="border: none;"></td>';
									tbl4 += '</tr>';
								}
							})

							$('#Normalcalculator #DwAppendData_left tr').remove();
							$('#Normalcalculator #DwAppendData_left').append(tbl3);

							$('#Normalcalculator #DwAppendData_right tr').remove();
							$('#Normalcalculator #DwAppendData_right').append(tbl4);

						}

						//============ Tab 4 end =============//

						$('#Normalcalculator').modal('show');
						
					}
				}
			})
		}
	}

	function addValuesinOthr(that){
		var paiddaysval = that.value;	
		$('#Normalcalculator #fiTotalPaidDAys').text(paiddaysval);

		var paiddays_prev = $('#Normalcalculator input[name="paiddays_prev"]').val();
		if(paiddays_prev == ''){
			$('#Normalcalculator input[name="paiddays_curr"]').val(paiddaysval);
		}
	}

	function paiddaysmanual(that){

		if($(that).is(':checked')){
			$('input[name="fipaiddayss"]').attr('readonly',false).addClass('addbg');
			$('input[name="fipaiddayss"]').parent('td').addClass('addbg');
		}else{
			$('input[name="fipaiddayss"]').attr('readonly',true).removeClass('addbg');
			$('input[name="fipaiddayss"]').parent('td').removeClass('addbg');
		}
	}

	function dayDailyChkBox(that){

		if($(that).is(':checked')){
			$('input[name="day_daily_wage"]').attr('readonly',false).addClass('addbg');
			$('input[name="day_daily_wage"]').parent('td').addClass('addbg');
		}else{
			$('input[name="day_daily_wage"]').attr('readonly',true).removeClass('addbg');
			$('input[name="day_daily_wage"]').parent('td').removeClass('addbg');
		}
	}

	function dayHrsChkBox(that){

		if($(that).is(':checked')){
			$('input[name="day_daily_hrs"]').attr('readonly',false).addClass('addbg');
			$('input[name="day_daily_hrs"]').parent('td').addClass('addbg');
		}else{
			$('input[name="day_daily_hrs"]').attr('readonly',true).removeClass('addbg');
			$('input[name="day_daily_hrs"]').parent('td').removeClass('addbg');
		}
	}

	/*function calcFixAllow(that,id,yesno){

		var manualval = that.value;
		//if(manualval > 0){ var sign='+';}else{var sign='-';}
		//if(manualval > 0){manualval = manualval;}else{manualval=0;}
		var currInput = $('#currVal_'+id).text();
		var prevInput = $('#prevVal_'+id).text();
		var paidDays = '<?=$noOfPaidDays?>';
		var tot_paydays = $('#Normalcalculator #fiTotalPaidDAys').text();
		
		if(yesno == 1){
			//var totalCalc = parseFloat(currInput) + parseFloat(prevInput) + parseFloat(manualval);
			var currvalss = parseFloat(currInput / paidDays) * parseFloat(tot_paydays);
			currvalss = currvalss.toFixed(2);
			var totalCalc = parseFloat(currvalss) + parseFloat(prevInput) + parseFloat(manualval);
		}else{
			var totalCalc = parseFloat(currInput) + parseFloat(manualval);
		}
		
		$('#totalVal_'+id).text(totalCalc);
	}*/

	function incomeBaseoptions(that,id){

		var currInput = $('#currVal_'+id).text();
		currInput = currInput.replaceAll(",", "");
		var prevInput = $('#prevVal_'+id).text();
		prevInput = prevInput.replaceAll(",", "");
		var manualval = $('input[name="manualAllow['+id+']"]').val();
		manualval = manualval.replaceAll(",", "");
		var yeno_ib   = $('select[name="yeno_ib['+id+']"]').val();

		var paidDays = '<?=$noOfPaidDays?>';
		var tot_paydays = $('#Normalcalculator #fiTotalPaidDAys').text();

		if(yeno_ib == 1){
			var currvalss = parseFloat(currInput / paidDays) * parseFloat(tot_paydays);
			currvalss = currvalss.toFixed(2); //alert(currvalss);
			var totalCalc = parseFloat(currvalss) + parseFloat(prevInput) + parseFloat(manualval);
		}else{
			var totalCalc = parseFloat(currInput) + parseFloat(manualval);
		}
		totalCalc = totalCalc.toFixed(2);
		//alert(totalCalc);
		$('#totalVal_'+id).val(number_format(totalCalc));
	}

	function EditHrswages(that,id){

		if($(that).is(':checked')){
			$('#hrs_curr_'+id).val('').attr('readonly',false).addClass('addbg');
			$('#hrs_curr_'+id).parent('td').addClass('addbg');
			$('#hrs_prev_'+id).val('').attr('readonly',false).addClass('addbg');
			$('#hrs_prev_'+id).parent('td').addClass('addbg');
		}else{
			$('#hrs_curr_'+id).attr('readonly',true).removeClass('addbg');
			$('#hrs_curr_'+id).parent('td').removeClass('addbg');
			$('#hrs_prev_'+id).attr('readonly',true).removeClass('addbg');
			$('#hrs_prev_'+id).parent('td').removeClass('addbg');
		}
	}

	function EditTimeswages(that,id){

		if($(that).is(':checked')){
			$('#times_curr_'+id).val('').attr('readonly',false).addClass('addbg');
			$('#times_curr_'+id).parent('td').addClass('addbg');
		}else{
			$('#times_curr_'+id).attr('readonly',true).removeClass('addbg');
			$('#times_curr_'+id).parent('td').removeClass('addbg');
		}
	}

	function ratewages(that,id){

		if($(that).is(':checked')){
			$('#rate_'+id).val('').attr('readonly',false).addClass('addbg');
			$('#rate_'+id).parent('td').addClass('addbg');
		}else{
			$('#rate_'+id).attr('readonly',true).removeClass('addbg');
			$('#rate_'+id).parent('td').removeClass('addbg');
		}
	}

	function thbwages(that,id){

		if($(that).is(':checked')){
			$('#thb_'+id).val('').attr('readonly',false).addClass('addbg');
			$('#thb_'+id).parent('td').addClass('addbg');
		}else{
			$('#thb_'+id).attr('readonly',true).removeClass('addbg');
			$('#thb_'+id).parent('td').removeClass('addbg');
		}
	}

	function checkmanualchkbox(that){
		if($(that).is(':checked')){
			$('input.mninputs').addClass('inptbkg');
			$('input.mninputs').attr('readonly',false);
		}else{
			$('input.mninputs').removeClass('inptbkg');
			$('input.mninputs').attr('readonly',true);
			$('input.mninputs').val('');
		}
	}


	//const myTimeout = setTimeout(SaveParametersForm, 5000);
	/*function SaveParametersForm(){
		var frm = $('form#parametersData');
		var data = frm.serialize();

		$.ajax({
			url: "ajax/update_parameters.php",
			data: data,
			success: function(result){
				if(result == 'success'){
					$("body").overhang({
						type: "success",
						message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
						duration: 3,
						callback: function(v){
							location.reload();
						}
					})
				}else{
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: '+ result,
						duration: 3,
						callback: function(v){
							location.reload();
						}
					})
				}
			}
		})

		//clearTimeout(myTimeout);
	}*/


	function getDefaultSettings(){

		var mid = '<?=$_GET['mid']?>';

		$.ajax({
			url: "ajax/get_save_default_parm.php",
			type: 'post',
			data: {mid:mid},
			success: function(result){
				if(result == 'success'){
					
					$("body").overhang({
						type: "success",
						message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
						duration: 3,
						callback: function(v){
							window.location.reload();
						}
					})
				}else{
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: '+ result,
						duration: 3,
						callback: function(v){
							window.location.reload();
						}
					})
				}
			}
		})
	}


	function getAlltrids(){

		var emparr = [];
		$('#RelatedToDT tbody#relatedata tr').each(function(k,v){
			emparr.push($(this).data('id'));
		})

		if(emparr.length === 0) {

			$("body").overhang({
				type: "error",
				message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['There is no employee selected for Payroll']?>',
				duration: 3,
			})

		}else{

			$.ajax({
				url: "ajax/save_in_payroll.php",
				data: {empids: emparr},
				success: function(result){

					if(result == 'success'){
						
						$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
							duration: 3,
							callback: function(v){
								window.location.reload();
							}
						})

					}else{

						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: '+ result,
							duration: 3,
							callback: function(v){
								window.location.reload();
							}
						})
					}
				}
			})
		}
	}

	

	function Manualfeedcalc(itemid, rowid){

		var empid = $('#ManualFeedDT #total_'+itemid+'_'+rowid).closest('tr').attr('data-eid');
		var empSalary = $('#ManualFeedDT #total_'+itemid+'_'+rowid).closest('tr').attr('data-sal');

		if(itemid !=''){

			var getpayrolldatass = getpayrolldata(empid);
			var hrs_curr_wages_rates = getpayrolldatass['hrs_curr_wages'];
			var times_curr_wages = getpayrolldatass['times_curr_wages'];

			var hrs = $('.hrs_'+itemid+'_'+rowid).val();
			var times = $('.times_'+itemid+'_'+rowid).val();
			var thb = $('.thb_'+itemid+'_'+rowid).val();

			var hrstot=0;
			if(hrs !== undefined){
				var myHrs = hrs.split(":");
				var darhrss1 = (myHrs[1] / 60); 
				var darhrss = parseFloat(parseInt(myHrs[0]) + darhrss1); 
				var hrsrate = hrs_curr_wages_rates[itemid];
				hrstot = parseFloat(darhrss * hrsrate);
			}

			var myTimes = 0;
			if(times > 0){
				var thbunit=1;
				if(times_curr_wages[itemid] > 0){ thbunit=times_curr_wages[itemid];}
				myTimes = (times * thbunit);
			} 

			var mythb = 0;
			if(thb > 0){
				mythb = thb;
			} 

			var totalCalc1 = parseInt(myTimes) + parseInt(mythb);		
			var totalCalc2 = (hrstot + totalCalc1);
			var totalAmts = totalCalc2.toFixed(2);

			var gTotal;
			if(mythb > 0){
				gTotal = parseFloat(mythb).toFixed(2);
			}else{ 
				gTotal = totalAmts;
			}

			$('#ManualFeedDT #total_'+itemid+'_'+rowid).val(0);
			$('#ManualFeedDT #total_'+itemid+'_'+rowid).val(gTotal);
		}
	}


	/*function ManualfeedcalcOld(itemid, rowid){

		var empid = $('#ManualFeedDT #total_'+itemid+'_'+rowid).closest('tr').attr('data-eid');
		var empSalary = $('#ManualFeedDT #total_'+itemid+'_'+rowid).closest('tr').attr('data-sal');
		//alert(empid);

		if(itemid !=''){

			var getpayrolldatass = getpayrolldata(empid);

			setTimeout(function() { 
				$.ajax({
					url: "ajax/get_allowdeduct_details.php",
					data: {itemid: itemid},
					success: function(result){
						if(result == 'error'){
							$("body").overhang({
								type: "error",
								message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error'].': '.$lng['No data available for this month']?>',
								duration: 3,
								callback: function(v){
									location.reload();
								}
							})
						}else{

							var hrs = $('.hrs_'+itemid+'_'+rowid).val();
							var times = $('.times_'+itemid+'_'+rowid).val();
							var thb = $('.thb_'+itemid+'_'+rowid).val();

							data = JSON.parse(result); //get Calculation basis Variable allowances

							var ptcalc;
							var salary = empSalary;

							var darhrss = 1;
							if(data.nrhrs !=''){

								//alert(data.nrhrs);
								var myHrs = data.nrhrs.split(":");
								var darhrss1 = (myHrs[1] / 60); 
								var darhrss = parseFloat(parseInt(myHrs[0]) + darhrss1); 
							}

							//alert(darhrss1);
							//alert(darhrss);

							var muliplyby = 1;
							if(data.multiplicator > 0){
								muliplyby = data.multiplicator;
							}
							
							//
							if(data.calcOpt == 3){
								ptcalc = (((salary / data.nrdays) / darhrss) * muliplyby);
							}else{
								var defdays = 30;
								ptcalc = (((salary / defdays) / darhrss) * muliplyby);
							}
							//alert(ptcalc);
							var myinputHrs = 1;
							if(hrs !='' && hrs != undefined){
								var inputHrs = hrs.split(":");
								var inpu1 = (inputHrs[1] / 60);
								myinputHrs = parseFloat(parseInt(inputHrs[0]) + inpu1);
							}
							//alert(myinputHrs);

							var myTimes = 0;
							if(times > 0){
								myTimes = (times * data.thbunit);
							} //alert(times);

							var mythb = 0;
							if(thb > 0){
								mythb = thb;
							} //alert(thb);

							var totalCalc = (ptcalc * myinputHrs);
							var totalCalc1 = parseInt(myTimes) + parseInt(mythb);

							//alert(myinputHrs);
							//alert(totalCalc);
							//alert(mythb);
							
							var totalCalc2 = (totalCalc + totalCalc1);
							var totalAmts = totalCalc2.toFixed(2);

							var gTotal;
							//var allowopt = data.allowopt.split(",");
							if(mythb > 0){
								gTotal = parseFloat(mythb).toFixed(2);
							}else{ 
								gTotal = totalAmts;
							}
							
							//alert(totalAmts);
							$('#ManualFeedDT #total_'+itemid+'_'+rowid).val(0);
							$('#ManualFeedDT #total_'+itemid+'_'+rowid).val(gTotal);

							//$('li#saveManualfeedData').css('pointer-events','visible');

						}
					}
				})
			}, 1000);	//run after 1 sec
		}
	}*/

	function getpayrolldata(empid){

		var empid = empid;
		var nrdaysVal = '<?=$paiddays['paid_days'];?>';
		var PaidDays = '<?=$noOfPaidDays?>';
		var mid = '<?=$_GET['mid']?>';
		var data;
		
		if(empid !=''){
			$.ajax({
				type: "post",
				url: "ajax/get_payroll_data.php",
				async: false,
				data: {empid: empid,nrdaysVal:nrdaysVal,PaidDays:PaidDays,mid:mid},
				success: function(result){

					data = JSON.parse(result);;
				}
			})
		}

		return data;
	}

	function calculatePayrollAgain(empid,mid){
		 $.ajax({
			type: 'POST',
			url: "ajax/calculate_payroll.php",
			data: {empid: empid,mid:mid},
			success: function(result){

				if(result == 'success'){
					
					$("body").overhang({
						type: "success",
						message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Payroll calculated successfuly']?>',
						duration: 3,
						callback: function(v){
							window.location.reload();
						}
					})

				}else{

					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: '+ result,
						duration: 3,
						callback: function(v){
							window.location.reload();
						}
					})
				}
			}
		})
	}


	
	function calculatePayrollData(){

		var ids = $(".selEmpChk").map(function () {
	        return this.value;
	    }).get();

	    var mid = '<?=$_GET['mid']?>';

		if(ids.length === 0){
	    	$("body").overhang({
				type: "error",
				message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;Please tick below checkbox to calculate payroll',
				duration: 3,
			})
	    }else{
	    	//console.log(ids);
	    	$.ajax({
				type: 'POST',
				url: "ajax/calculate_payroll.php",
				data: {empid: ids, mid:mid},
				success: function(result){

					if(result == 'success'){
						calculatePayrollAgain(ids,mid);
						/*$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Payroll calculated successfuly']?>',
							duration: 3,
							callback: function(v){
								window.location.reload();
							}
						})*/

					}else{

						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: '+ result,
							duration: 3,
							callback: function(v){
								window.location.reload();
							}
						})
					}

				}
			})
	    }
	}


	$(document).ready(function() {

		var eCols = <?=json_encode($emptyCols)?>;
		var eColsEE = <?=$eColsEE?>;
		var salColView = <?=$salColView?>;
		var prColView = <?=$prColView?>;
		var shCols = <?=json_encode($shCols)?>;
		var tableCols = <?=json_encode($eatt_cols)?>;
		var section_cols = <?=json_encode($section_cols)?>;
		var eColsmf = <?=json_encode($emptyColsmf)?>;

		var tableColsmf = <?=json_encode($dropdownArray)?>;
		var data_income = <?=json_encode($data_income)?>;
		var getAttendAllowDeduct = <?=json_encode($getAttendAllowDeduct)?>;

		/*var income_basess = '<?=$paiddays['income_base']?>';
		if(income_basess == ''){ income_basess = '<?=$tab_default['income_base']?>';}	
		updatedDAY('appendSelDay', income_basess);*/

		function updatedDAY(acc,val){ 
			
			var arrH = val.toString().split(',');
			var Selitems = '';
			var counter = 0;
		    $.each(arrH, function(index, value) { 
		    	if(value !=''){
		    		counter++;
		    		if(counter > 10){ var Hstyle = 'style="display:none"';}else{ var Hstyle = '';}
		      		Selitems += '<span class="p-2 font-weight-bold" '+Hstyle+'>'+data_income[value]+'<br></span>';
		      		if(counter == 11){ Selitems += '<span class="p-2 font-weight-bold" >...</span>'; }
		      	}
		    });

		    $('#tab_Parameters table#calbasis td p#'+acc+' span').remove();
		    $('#tab_Parameters table#calbasis td p#'+acc+'').css('display','block');
		    $('#tab_Parameters table#calbasis td p#'+acc).append(Selitems);
		}

		$('#dayRateId').SumoSelect({
			placeholder: '<?=$lng['Select'].' '.$lng['Income']?>',
			captionFormat: '<?=$lng['Income']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All'].' '.$lng['Income']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:false,
			okCancelInMulti:false, 
			showTitle : false,
			triggerChangeCombined: true,
		});

		/*$('#Sumo_IncomeBase').SumoSelect({
			placeholder: '<?=$lng['Select'].' '.$lng['Income']?>',
			captionFormat: '<?=$lng['Income']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All'].' '.$lng['Income']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:false, 
			showTitle : false,
			triggerChangeCombined: true,
		});*/

		

		/*$('#dayRateIdabs').SumoSelect({
			placeholder: '<?=$lng['Select'].' '.$lng['Income']?>',
			captionFormat: '<?=$lng['Income']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All'].' '.$lng['Income']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});

		$('#dayRateIdel').SumoSelect({
			placeholder: '<?=$lng['Select'].' '.$lng['Income']?>',
			captionFormat: '<?=$lng['Income']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All'].' '.$lng['Income']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});

		$('#dayRateIdot').SumoSelect({
			placeholder: '<?=$lng['Select'].' '.$lng['Income']?>',
			captionFormat: '<?=$lng['Income']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All'].' '.$lng['Income']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});*/

		/*$("#dayRateId ~ .optWrapper .MultiControls .btnOk").click( function () {
			updatedDAY('appendSelDay', $('#dayRateId').val());
		});*/

		/*$("#dayRateIdabs ~ .optWrapper .MultiControls .btnOk").click( function () {
			updatedDAY('appendSelDayabs', $('#dayRateIdabs').val());
		});

		$("#dayRateIdel ~ .optWrapper .MultiControls .btnOk").click( function () {
			updatedDAY('appendSelDayel', $('#dayRateIdel').val());
		});

		$("#dayRateIdot ~ .optWrapper .MultiControls .btnOk").click( function () {
			updatedDAY('appendSelDayot', $('#dayRateIdot').val());
		});*/

		//console.log(data_income);
		/*$(data_income).each(function(k,v){
			alert(k);
			$('#IncomBaseopt_'+v).SumoSelect({
				placeholder: '<?=$lng['Select'].' '.$lng['Income']?>',
				captionFormat: '<?=$lng['Income']?> ({0})',
				captionFormatAllSelected: '<?=$lng['All'].' '.$lng['Income']?> ({0})',
				csvDispCount:1,
				outputAsCSV: true,
				selectAll:true,
				okCancelInMulti:false, 
				showTitle : false,
				triggerChangeCombined: true,
			});
		})*/

		$(getAttendAllowDeduct).each(function(k,v){
			if(v.man_att == 1){
				$('#incomeBase'+v.id).SumoSelect({
					placeholder: '<?=$lng['Select'].' '.$lng['Income']?>',
					captionFormat: '<?=$lng['Income']?> ({0})',
					captionFormatAllSelected: '<?=$lng['All'].' '.$lng['Income']?> ({0})',
					csvDispCount:1,
					outputAsCSV: true,
					selectAll:false,
					okCancelInMulti:false, 
					showTitle : false,
					triggerChangeCombined: true,
				});
			}
		})

		



		// $("#tab_Parameters table#calbasis input").each(function() {
		//    var element = $(this);
		//    if (element.val() == "") {
		//        isValid = false;
		//    }
		// });

		$('.sdatepick1').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			inline: false,
			language: lang,
			todayHighlight: true,
			//endDate: new Date(),
			orientation: "bottom left",
		})

		var dtable = $('#datatables11').DataTable({

			scrollX: true,
			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: 15,
			filter: true,
			info: true,
			responsive: true,
			<?=$dtable_lang?>
			columnDefs: [
				{"targets": eCols, "visible": false, "searchable": false},
				{"targets": eColsEE, "visible": false, "searchable": false},
			],
			
		});


		$("#searchFiltered").keyup(function() {
			dtable.search(this.value).draw();
		});

		// CLEAR SEARCH BUTTON CODE 
		$("#clearSearchbox_tab_emp_data").click(function() {
			$("#searchFiltered").val('');
			dtable.search('').draw();
		});	


		$(document).on("change", "#pageLengthed", function(e) {
			if(this.value > 0){
				dtable.page.len( this.value ).draw();
			}
		});
		

		/*var mySelect = $('#showColsF').SumoSelect({
			csvDispCount:1,
			outputAsCSV : true,
			showTitle : false,
			placeholder: '<?=$lng['Show Hide Columns']?>',
			captionFormat: '<?=$lng['Show Hide Columns']?>',
			captionFormatAllSelected: '<?=$lng['Show Hide Columns']?>',
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});	*/

		var mySelectSection = $('#showColsFSection').SumoSelect({
			csvDispCount:1,
			outputAsCSV : true,
			showTitle : false,
			placeholder: '<?=$lng['Show Hide Section']?>',
			captionFormat: '<?=$lng['Show Hide Section']?>',
			captionFormatAllSelected: '<?=$lng['Show Hide Section']?>',
			selectAll:true,
			okCancelInMulti:false, 
			showTitle : false,
			triggerChangeCombined: false,
		});

		/*$("#sumoselect1 .SumoSelect li").bind('click.check', function(event) {
			var nr = $(this).index()+5;
			
			if($(this).hasClass('selected') == true){
				dtable.column(nr).visible(true);
			}else{
				dtable.column(nr).visible(false);
			}
    	})*/			
		
		/*$("#sumoselect2 .SumoSelect li").bind('click.check', function(event) {
			var nr = $(this).index();

			//console.log(nr);
			
			if($(this).hasClass('selected') == true){
				dtable.column(nr).visible(true);
			}else{
				dtable.column(nr).visible(false);
			}
  		})*/		



		/*$('select#showColsF').on('sumo:closing', function(o) {
			var columns = $(this).val();
			var att_cols = [];
			$.each(columns, function(index, item) {
				
				att_cols.push({id:item, db:tableCols[item][0], name:tableCols[item][1]})
			})
			$.ajax({
				url: "ajax/save_empdata_tab_columns.php",
				data: {cols: att_cols},
				success: function(result){
					
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		}); */		

		
		$('select#showColsFSection').on('sumo:closing', function(o) {

			var columns = $(this).val();
			var att_cols = [];
			$.each(columns, function(index, item) {
				
				att_cols.push({id:item, db:section_cols[item][0], name:section_cols[item][1]})
			})
			$.ajax({
				url: "ajax/save_empdata_tab_section_columns.php",
				data: {cols: att_cols},
				success: function(result){
					window.location.reload();
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		});
		

		//============== Tab ManualFeedDT ===============

		var totalmfcolumns=$('#showColsMF option').length;
		var columns=[];
		for(let i=5;i<totalmfcolumns+6;i++){
			columns.push(i,totalmfcolumns+i+1);
		} 

		var dtmanual = $('#ManualFeedDT').DataTable({
			scrollX: true,
			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: 15,
			filter: true,
			info: true,
			<?=$dtable_lang?>
			columnDefs: [

				{"targets": eColsmf, "visible": false, "searchable": false},
				{ "width": "75px", "targets": columns },
				<?=$eColsMFd?>
				<?=$eColsMFd11?>
				<?=$hide2?>
			]
			
		});

		$("#searchFilterm").keyup(function() {
			dtmanual.search(this.value).draw();
		});
		$("#clearSearchboxm").click(function() {
			$("#searchFilterm").val('');
			dtmanual.search('').draw();
		});

		$(document).on("change", "#pageLengthm", function(e) {
			if(this.value > 0){
				dtmanual.page.len( this.value ).draw();
			}
		});
	
		var mySelectmf = $('#showColsMF').SumoSelect({
			csvDispCount:1,
			outputAsCSV : true,
			showTitle : false,
			placeholder: '<?=$lng['Show Hide Columns']?>',
			captionFormat: '<?=$lng['Show Hide Columns']?>',
			captionFormatAllSelected: '<?=$lng['Show Hide Columns']?>',
			selectAll:false,
			okCancelInMulti:false, 
			showTitle : false,
			triggerChangeCombined: true,
		});

		/*$("#mfeedsel .SumoSelect li").bind('click.check', function(event) {
			//var nr = $(this).index()+3; //alert(nr);
			var nr = $(this).index()+5; //alert(nr);
			
			if($(this).hasClass('selected') == true){
				dtmanual.column(nr).visible(true);

			}else{
				dtmanual.column(nr).visible(false);
			}
			//console.log(dtmanual.column(nr));
			$(".hourFormat").mask("999:99", {placeholder: "000:00"});

			//calculate manual feed data on show hidw column
			CalcManualFeed(); 
  		})*/
  		
  		var totl=$("#mfeedsel .SumoSelect li").length;
		for(let i=6;i<totl+6;i++){
			if($.inArray(i,eColsmf)==-1){  // && dtmanual.column(i+totl)!=-1
				dtmanual.column(i+totl+1).visible(true);
			}else if(dtmanual.column(i+totl+1).visible()!=undefined)
			{
				dtmanual.column(i+totl+1).visible(false);
			}			
		}

		$("#mfeedsel .SumoSelect li").bind('click.check', function(event) {
			var nr = $(this).index()+6; //alert(nr);
			if($(this).hasClass('selected') == true){
				try{dtmanual.column(nr).visible(true);}catch(error){console.log(error);}
				try{dtmanual.column(nr+totl+1).visible(true);}catch(error){console.log(error);}
			}else{
				try{dtmanual.column(nr).visible(false);}catch(error){console.log(error);}
				removedata(nr);
				try{dtmanual.column(nr+totl+1).visible(false);}catch(error){console.log(error);}
				removedata(nr+totl+1);
			}

			$(".hourFormat").mask("999:99", {placeholder: "000:00"});

			//calculate manual feed data on show hidw column
			CalcManualFeed(); 
  		})

  		function removedata(n){
	  		let i1=0;
	  		let data1=dtmanual.cell(0,n).data();
			let nodes=$.parseHTML(data1);

			console.log(dtmanual.cell(0,n).data());
			let classes=nodes[0].className.split(' ');
			//let ph=$('.'+classes[1].);

			nodes[0].removeAttribute('value');
	  		while(i1<dtmanual.rows().count()){
    			//console.log($(ph)); 
    			dtmanual.cell(i1,n).data(nodes[0].outerHTML).draw();
    			console.log(i1);
    			i1++;
	  		}
	  	}


  		$('select#showColsMF').on('sumo:closing', function(o) {
			var columns = $(this).val();
			var att_cols = [];
			//console.log(columns);
			//console.log(tableColsmf);
			$.each(columns, function(index, item) {

				att_cols.push({id:item, db:tableColsmf[item], name:tableColsmf[item]})
			})
			$.ajax({
				url: "tabs/ajax/save_manualfeed_columns.php",
				data: {cols: att_cols},
				success: function(result){
					
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		});

		function CalcManualFeed(){
			var frm = $('form#manualfeedData');
			var datas = frm.serialize();
			$.ajax({
				type : 'post',
				url : 'tabs/ajax/save_manual_feed.php',
				data : datas,
				success : function(result){
					//alert('ddd');
				}
			})
		}

		//============== Tab ManualFeedDT ===============


		//============== Tab CalcFeedDT ===============
		var dtcalcfeed = $('#CalcFeedDT').DataTable({
			scrollX: true,
			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: 10,
			filter: true,
			info: true,
			<?=$dtable_lang?>
			/*columnDefs: [
				{"targets": eColsmf, "visible": false, "searchable": false}
			]*/
			
		});

		$("#searchFiltercf").keyup(function() {
			dtcalcfeed.search(this.value).draw();
		});
		$("#clearSearchboxcf").click(function() {
			$("#searchFiltercf").val('');
			dtcalcfeed.search('').draw();
		});

		$(document).on("change", "#pageLengthcf", function(e) {
			if(this.value > 0){
				dtcalcfeed.page.len( this.value ).draw();
			}
		});
		//============== Tab CalcFeedDT ===============


		//============== Tab attendance_table ===============
		var dtattendance = $('#attendance_table').DataTable({
			scrollX: true,
			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: 10,
			filter: true,
			info: true,
			<?=$dtable_lang?>
			columnDefs: [
				//{"targets": eColsmf, "visible": false, "searchable": false},
				<?=$eColsad11?>
			]
			
		});

		$("#searchFilterta").keyup(function() {
			dtattendance.search(this.value).draw();
		});
		$("#clearSearchboxta").click(function() {
			$("#searchFilterta").val('');
			dtattendance.search('').draw();
		});

		$(document).on("change", "#pageLengthta", function(e) {
			if(this.value > 0){
				dtattendance.page.len( this.value ).draw();
			}
		});
		//============== Tab attendance_table ===============

		//============== Tab SalaryCalc ===============
		var salaryCalcdt = $('#SalaryCalc').DataTable({
			scrollX: true,
			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: 10,
			filter: true,
			info: true,
			<?=$dtable_lang?>
			columnDefs: [
				{"targets": salColView, "visible": false, "searchable": false}
				
			]
			
		});

		$("#searchFiltersc").keyup(function() {
			salaryCalcdt.search(this.value).draw();
		});
		$("#clearSearchboxsc").click(function() {
			$("#searchFiltersc").val('');
			salaryCalcdt.search('').draw();
		});

		$(document).on("change", "#pageLengthsc", function(e) {
			if(this.value > 0){
				salaryCalcdt.page.len( this.value ).draw();
			}
		});
		//============== Tab SalaryCalc ===============

		//============== Tab payroll_result ===============
		var payrollResult = $('#payroll_result').DataTable({
			scrollX: true,
			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: 10,
			filter: true,
			info: true,
			<?=$dtable_lang?>
			columnDefs: [
				{"targets": prColView, "visible": false, "searchable": false}
			]
		});

		$("#searchFilterpr").keyup(function() {
			payrollResult.search(this.value).draw();
		});
		$("#clearSearchboxpr").click(function() {
			$("#searchFilterpr").val('');
			payrollResult.search('').draw();
		});

		$(document).on("change", "#pageLengthpr", function(e) {
			if(this.value > 0){
				payrollResult.page.len( this.value ).draw();
			}
		});

		
		//============== Tab payroll_result ===============
		


		var numbersString = "<?=$_SESSION['rego']['selpr_teams']?>";
		var SelprTeams = numbersString.split(',');
		
		var activeTabPay = localStorage.getItem('activeTabPayroll');
		if(activeTabPay){
			var alltabs = '<?=$alltabs?>';
			if(alltabs == ''){
				$('.nav-link[href="' + activeTabPay + '"]').tab('show');
			}else{
				$('.nav-link[href="#tab_Parameters"]').tab('show');
			}			
		}

		dtable.columns.adjust().draw();
		dtmanual.columns.adjust().draw();
		dtcalcfeed.columns.adjust().draw();
		dtattendance.columns.adjust().draw();
		salaryCalcdt.columns.adjust().draw();
		payrollResult.columns.adjust().draw();


		/*if(activeTabPay == '#tab_RelatedTo'){
			updateAccess('teams', SelprTeams,0);
		}*/

		$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
			localStorage.setItem('activeTabPayroll', $(e.target).attr('href'));

			dtable.columns.adjust().draw();
			dtmanual.columns.adjust().draw();
			dtcalcfeed.columns.adjust().draw();
			dtattendance.columns.adjust().draw();
			salaryCalcdt.columns.adjust().draw();
			payrollResult.columns.adjust().draw();

			/*if($(e.target).attr('href') == '#tab_RelatedTo'){
				updateAccess('teams', SelprTeams,0);
			}*/
		});


		

	});

	function getAllChkData(that){

		var ids = $(".selectedChk").map(function () {
	        return this.id;
	    }).get();

	    var mid = '<?=$_GET['mid']?>';

	    if(ids.length === 0){
	    	$("body").overhang({
				type: "error",
				message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;<?=$lng['Please tick below checkbox to fetch employee data']?>',
				duration: 4,
			})
	    }else{
	    	//console.log(ids);
	    	$.ajax({
				type: 'POST',
				url: "ajax/fetch_emps_data.php",
				data: {empid: ids, mid:mid},
				success: function(result){
					//alert(result);
					if($.trim(result) == 'success'){
						
						$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
							duration: 3,
							callback: function(v){
								window.location.reload();
							}
						})

					}else{

						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: '+ result,
							duration: 3,
							callback: function(v){
								window.location.reload();
							}
						})
					}

				}
			});
	    }

	}

	function CHeckEmpChkboc(that){
		
		var id = that.id;
		if($(that).is(':checked')){
			$(that).addClass('selectedChk').attr('checked',true);
		}else{
			$(that).removeClass('selectedChk').attr('checked',false);
		}
	}

	function CHeckmfChkbox(that){
		
		var id = that.id;
		if($(that).is(':checked')){
			$(that).addClass('selectedChk').attr('checked',true);
		}else{
			$(that).removeClass('selectedChk').attr('checked',false);
		}
	}

	// function getAllselEmp(that){

	// 	if($(that).is(':checked')){
	// 		$('input.chkAll').addClass('selectedChk').attr('checked',true);
	// 	}else{
	// 		$('input.chkAll').removeClass('selectedChk').attr('checked',false);
	// 	}
	// }

	$( document ).ready(function() {

		//localStorage.clear();
		//localStorage.setItem('activeTabPay', '#tab_Parameters');
		

		var activeTabPay1 = localStorage.getItem('activeTabPayroll');

		$('.nav-link[href="'+activeTabPay1+'"]').tab('show');

		//alert(activeTabPay1);

		//console.log(activeTabPay1);

		if (activeTabPay1 == '#tab_RelatedTo')
		{
			$('.hideclearselectionpayroll').css("display","");
			$('.hidefetchdatapayroll').css("display","none");
			$('.hidegobackpayroll').css("display","none");
			$('.hidemanualfeedpayroll').css("display","none");
			$('.CalculatePayroll').css("display","none");
		}
		else if (activeTabPay1 == '#tab_EmployeeData')
		{
			$('.hideclearselectionpayroll').css("display","none");
			$('.hidefetchdatapayroll').css("display","");
			$('.hidegobackpayroll').css("display","");
			$('.hidemanualfeedpayroll').css("display","none");
			$('.CalculatePayroll').css("display","none");


		}		
		else if (activeTabPay1 == '#tab_ManualFeed')
		{
			$('.hideclearselectionpayroll').css("display","none");
			$('.hidefetchdatapayroll').css("display","none");
			$('.hidegobackpayroll').css("display","none");
			$('.hidemanualfeedpayroll').css("display","");
			$('.CalculatePayroll').css("display","none");


		}
		else if (activeTabPay1 == '#tab_SalaryCalc')
		{
			$('.hideclearselectionpayroll').css("display","none");
			$('.hidefetchdatapayroll').css("display","none");
			$('.hidegobackpayroll').css("display","none");
			$('.hidemanualfeedpayroll').css("display","none");
			$('.CalculatePayroll').css("display","");

		}else
		{
			$('.hideclearselectionpayroll').css("display","none");
			$('.hidefetchdatapayroll').css("display","none");
			$('.hidegobackpayroll').css("display","none");
			$('.hidemanualfeedpayroll').css("display","none");
			$('.CalculatePayroll').css("display","none");

		}


		$('.empgrouppayroll').on('click', function(){
			$('.hideclearselectionpayroll').css("display","");
			$('.hidefetchdatapayroll').css("display","none");
			$('.hidegobackpayroll').css("display","none");
			$('.hidemanualfeedpayroll').css("display","none");
			$('.CalculatePayroll').css("display","none");
		})	
		$('.paramerterpayroll').on('click', function(){
			$('.hideclearselectionpayroll').css("display","none");
			$('.hidefetchdatapayroll').css("display","none");
			$('.hidegobackpayroll').css("display","none");
			$('.hidemanualfeedpayroll').css("display","none");
			$('.CalculatePayroll').css("display","none");


		})		
		$('.empdatapayroll').on('click', function(){
			$('.hideclearselectionpayroll').css("display","none");
			$('.hidefetchdatapayroll').css("display","");
			$('.hidegobackpayroll').css("display","");
			$('.hidemanualfeedpayroll').css("display","none");
			$('.CalculatePayroll').css("display","none");


		})		
		$('.manualfeedpayroll').on('click', function(){
			$('.hideclearselectionpayroll').css("display","none");
			$('.hidefetchdatapayroll').css("display","none");
			$('.hidegobackpayroll').css("display","none");
			$('.hidemanualfeedpayroll').css("display","");
			$('.CalculatePayroll').css("display","none");

		})		
		$('.calculatedfeedpayroll').on('click', function(){
			$('.hideclearselectionpayroll').css("display","none");
			$('.hidefetchdatapayroll').css("display","none");
			$('.hidegobackpayroll').css("display","none");
			$('.hidemanualfeedpayroll').css("display","none");
			$('.CalculatePayroll').css("display","none");



		})		
		$('.previouscalcpayroll').on('click', function(){
			$('.hideclearselectionpayroll').css("display","none");
			$('.hidefetchdatapayroll').css("display","none");
			$('.hidegobackpayroll').css("display","none");
			$('.hidemanualfeedpayroll').css("display","none");
			$('.CalculatePayroll').css("display","none");



		})		
		$('.attendancepayroll').on('click', function(){
			$('.hideclearselectionpayroll').css("display","none");
			$('.hidefetchdatapayroll').css("display","none");
			$('.hidegobackpayroll').css("display","none");
			$('.hidemanualfeedpayroll').css("display","none");
			$('.CalculatePayroll').css("display","none");



		})		
		$('.salarypayroll').on('click', function(){
			$('.hideclearselectionpayroll').css("display","none");
			$('.hidefetchdatapayroll').css("display","none");
			$('.hidegobackpayroll').css("display","none");
			$('.hidemanualfeedpayroll').css("display","none");
			$('.CalculatePayroll').css("display","");



		})
		$('.payrollresult').on('click', function(){
			$('.hideclearselectionpayroll').css("display","none");
			$('.hidefetchdatapayroll').css("display","none");
			$('.hidegobackpayroll').css("display","none");
			$('.hidemanualfeedpayroll').css("display","none");
			$('.CalculatePayroll').css("display","none");



		})
		$('.verificationpayroll').on('click', function(){
			$('.hideclearselectionpayroll').css("display","none");
			$('.hidefetchdatapayroll').css("display","none");
			$('.hidegobackpayroll').css("display","none");
			$('.hidemanualfeedpayroll').css("display","none");
			$('.CalculatePayroll').css("display","none");



		})

	});
	
</script>