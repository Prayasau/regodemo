<?php
	if(session_id()==''){session_start();}
	ob_start();
	include('../../dbconnect/db_connect.php');
	include(DIR.'files/payroll_functions.php');

	$sessionpayrollDbase = $_SESSION['rego']['cid'].'_payroll_'.$_SESSION['rego']['cur_year'];
	$res = $dbc->query("SELECT Pmanualfeed_cols, Pmanualfeed_showhide_cols FROM ".$_SESSION['rego']['cid']."_sys_settings");
	$row = $res->fetch_assoc();
	$att_cols = unserialize($row['Pmanualfeed_cols']);
	$att_shcols = unserialize($row['Pmanualfeed_showhide_cols']);
	
	
	$mynewArray = array();
	$att_clskey = array_keys($att_cols);
	foreach ($att_shcols as $key => $value) {
		$mynewArray[$value] = $att_clskey[$key];
	}

	$payrollparametersformonth = payrollparametersformonth();
	if(isset($payrollparametersformonth) && is_array($payrollparametersformonth)){
		$dropdownArray = array();
		$dropdownArrayNew = array();
		$countColumn = 0;
		$outerArray = array();
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
					$valColumn = $countColumn + 4;
					$dropdownArray[$valColumn] = $allowDdt[$rows['itemid']].' ('.$valss.')';
					$dropdownArrayNew[$valColumn] = array($allowDdt[$rows['itemid']].' ('.$valss.')',$rows['itemid']);
				}
			}
		}
	}

	$n=5;
	$field = array();
	if($mynewArray){
		foreach($mynewArray as $k=>$v){
			$field[$n] = array('db'=>$k,'name'=>$v, 'itemid'=>$dropdownArrayNew[$k][1]); $n++;
		}
	}
	
	$dir = DIR.$cid.'/payroll/';
	if (!file_exists($dir)) {
		mkdir($dir, 0755, true);
	}
	
	
	if (!empty($_FILES)){
		 $tempFile = $_FILES['file']['tmp_name'];
		 $targetFile =  $dir. $_FILES['file']['name'];
		 move_uploaded_file($tempFile,$targetFile);
	}
	$sheetData = array();
	$inputFileName = $targetFile; //'../excel_101/xhr0101_attendance_2016_01.xlsx'; //
	//var_dump($inputFileName);
	
	require_once DIR.'PhpSpreadsheet/vendor/autoload.php';
	use PhpOffice\PhpSpreadsheet\IOFactory;
	
	$inputFileType = IOFactory::identify($inputFileName);
	$reader = IOFactory::createReader($inputFileType);
	$reader->setReadDataOnly(true); 
	$reader->setReadEmptyCells(false);
	$spreadsheet = $reader->load($inputFileName);
	
	$sheetData = $spreadsheet->getActiveSheet()->toArray(null, false, false, true);
	// 1. Value returned in the array entry if a cell doesn't exist
	// 2. Should formulas be calculated ?
	// 3. Should formatting be applied to cell values ?
	// 4. False - Return a simple array of rows and columns indexed by number counting from zero 
	// 4. True - Return rows and columns indexed by their actual row and column IDs
	//var_dump($sheetData[3]);
	//exit;
	$fields = array();
	$fields[] = 'id';
	foreach($sheetData[2] as $k=>$v){
		$fields[$k] = $v;
	}
	unset($sheetData[1],$sheetData[2],$sheetData[3]);
	//var_dump($fields);
	//var_dump($sheetData[4]);
	
	function convertToHoursMins($tim) {
    	if($tim < 0.00069444444444444){return;}
		$time = $tim * 24 * 60;
	    $hours = floor($time / 60);
	    $minutes = round($time,2) % 60;
	    return sprintf('%02d:%02d', $hours, $minutes);
	}


	$manualfeedArray = array();
	foreach ($fields as $key => $value) {
		foreach ($sheetData as $k => $v) {

			if($value == 'id' || $value == 'emp_id' || $value == 'emp_name_'.$lang || $value == 'paid_days'){
				
			}else{

				/*$getpayrollinfo = getpayrollinfo($v['A'], $_SESSION['rego']['cur_month']);
				$getallowdeduct = getallowadeductinfo($field[$value]['itemid'], $_SESSION['rego']['cur_month']);

				$empsalary = $getpayrollinfo[0]['salary'];*/

				if(strpos($field[$value]['name'], '(times)')) {
					$manualfeedArray[$v['A']]['times'][$field[$value]['itemid']] = $v[$key];
				}elseif(strpos($field[$value]['name'], '(thb)')) {
					$manualfeedArray[$v['A']]['thb'][$field[$value]['itemid']] = $v[$key];
				}elseif(strpos($field[$value]['name'], '(hrs)')) {
					$manualfeedArray[$v['A']]['hrs'][$field[$value]['itemid']] = $v[$key];
				}

			}
		}
	}


	if(is_array($manualfeedArray)){
		foreach ($manualfeedArray as $key => $value) {
			$getpayroll = $dbc->query("SELECT * FROM ".$sessionpayrollDbase." WHERE emp_id = '".$key."' AND month = '".sprintf("%02d", $_SESSION['rego']['cur_month'])."'");
			if($getpayroll->num_rows > 0){
				
				$manualfeed = serialize($value);
				$updata = "UPDATE ".$sessionpayrollDbase." SET manual_feed_data = '".$manualfeed."' WHERE emp_id = '".$key."' AND month = '".sprintf("%02d", $_SESSION['rego']['cur_month'])."'";
				$dbc->query($updata);
			}
		}
	}
	
	ob_clean();
	echo 'success';
	
?>