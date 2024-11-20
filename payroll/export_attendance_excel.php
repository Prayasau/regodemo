<?php
	if(session_id()==''){session_start();}
	ob_start();
	include('../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	include(DIR.'files/payroll_functions.php');
	include(DIR.'files/arrays_'.$_SESSION['rego']['lang'].'.php');
	
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

	// echo "<pre>";
	// print_r(array_keys($att_cols));
	// print_r($att_shcols);
	// print_r($mynewArray);
	// echo "</pre>";

	
	$n=0;
	$field = array();
		$field[getNameFromNumber($n)] = array('db'=>'emp_id','name'=>$lng['ID']); $n++;
		$field[getNameFromNumber($n)] = array('db'=>'emp_name_'.$_SESSION['rego']['lang'],'name'=>$lng['Employee name']); $n++;
		//$field[getNameFromNumber($n)] = array('db'=>'actual_days','name'=>$lng['Actual'].' '.$lng['days']); $n++;
		$field[getNameFromNumber($n)] = array('db'=>'paid_days','name'=>$lng['Days paid']); $n++;
		if($mynewArray){
			foreach($mynewArray as $k=>$v){
				$field[getNameFromNumber($n)] = array('db'=>$k,'name'=>$v, 'itemid'=>$dropdownArrayNew[$k][1]); $n++;
			}
		}
	end($field);
	$last_col = key($field);
	$msgCol = $last_col;
	if($msgCol < 'K'){$msgCol = 'K';}
	//var_dump($field); exit;
	
	require_once(DIR.'PhpSpreadsheet/vendor/autoload.php');

	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	
	$spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->getActiveSheet();
	
	$filename = $cid.'_manualfeed_'.$_SESSION['rego']['cur_year'].'_'.sprintf('%02d',$_SESSION['rego']['cur_month']).'.xlsx';

	$allBorders = array(
		 'borders' => array(
			  'allBorders' => array(
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => array('argb' => '00000000'),
			  ),
		 ),
	);
	
	$outBorders = array(
		 'borders' => array(
			  'outline' => array(
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => array('argb' => '00000000'),
			  ),
		 ),
	);
	
	$sheet->mergeCells('A1:B1');
	$sheet->setCellValue('A1', $lng['Manual Feed'].' '.$months[$_SESSION['rego']['cur_month']].' '.$_SESSION['rego']['year_'.$lang]);
	$sheet->getStyle('A1')->getFont()->setSize(11)->setBold(true);
	
	//$sheet->getRowDimension(1)->setCollapsed(true);
	$sheet->getRowDimension(2)->setVisible(false);
	$sheet->getStyle('A2:'.$last_col.'2')->getFont()->setBold(false)->getColor()->setRGB('ffffff');
	
	$commentRichText = $sheet->getComment('A3')->getText()->createTextRun($sheet_txt);
	$sheet->getComment('A3')->setWidth("580px")->setHeight("90px");	

	foreach($field as $k=>$v){
		$sheet->getStyle($k.'3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->setCellValue($k.'2', $v['db']);
		$sheet->setCellValue($k.'3', $v['name']);
		$sheet->getStyle($k.'3')->applyFromArray($allBorders);
		$sheet->getColumnDimension($k)->setAutoSize(true);
		if($v['db'] == 'emp_id'){
			$sheet->getStyle($k)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
			$sheet->getStyle($k)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		}else{
			if(strpos($v['name'], '(hrs)')) { 
				$sheet->getStyle($k)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
				//$sheet->getStyle($k)->getNumberFormat()->setFormatCode('[HH]:MM');
			}else{
				$sheet->getStyle($k)->getNumberFormat()->setFormatCode('[<>0]#,##0.00; [=0]"-  "');
			}
		}
	}
	$sheet->getStyle('B3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	$sheet->getColumnDimension('A')->setAutoSize(true);
	$sheet->getColumnDimension('B')->setAutoSize(true);
	$sheet->getStyle('A3:'.$last_col.'3')->getFill()
		->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
		->getStartColor()->setRGB('dae8f6');
		
	$sheet->getStyle('A3:'.$last_col.'3')->applyFromArray($allBorders);

	$sbranches = str_replace(',', "','", $_SESSION['rego']['sel_branches']);
	$sdivisions = str_replace(',', "','", $_SESSION['rego']['sel_divisions']);
	$sdepartments = str_replace(',', "','", $_SESSION['rego']['sel_departments']);
	$steams = str_replace(',', "','", $_SESSION['rego']['sel_teams']);
	
	$where = "AND branch IN ('".$sbranches."')";
	$where .= " AND division IN ('".$sdivisions."')";
	$where .= " AND department IN ('".$sdepartments."')";
	$where .= " AND team IN ('".$steams."')";

	$sql = "SELECT * FROM ".$sessionpayrollDbase." WHERE month = '".sprintf("%02d", $_SESSION['rego']['cur_month'])."' ".$where." ORDER BY emp_id ASC";
	$res = $dbc->query($sql);
	$r=4;
	$forTimes = array();
	$forThb = array();
	$forHrs = array();
	while($row = $res->fetch_assoc()){
		$manual_feed_data = unserialize($row['manual_feed_data']);
		$forTimes = $manual_feed_data['times'];
		$forThb = $manual_feed_data['thb'];
		$forHrs = $manual_feed_data['hrs'];

		// ksort($forTimes);
		// ksort($forThb);
		// ksort($forHrs);
		// echo "<pre>";
		// print_r($manual_feed_data);
		// print_r($field);
		// echo "</pre>";
		

		foreach($field as $k=>$v){
			if($v['db'] == 'emp_id' || $v['db'] == 'emp_name_'.$lang || $v['db'] == 'paid_days'){
				$sheet->setCellValueExplicit($k.$r, $row[$v['db']], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			}else{

				$dd = $v['itemid'];
				$sheetval = '';
				if(strpos($v['name'], '(times)')) { 
					$sheetval = $forTimes[$dd]; 
				}elseif(strpos($v['name'], '(thb)')) { 
					$sheetval = $forThb[$dd];
				}elseif(strpos($v['name'], '(hrs)')) { 
					$sheetval = $forHrs[$dd];
				}
				
				$sheet->setCellValue($k.$r, $sheetval);	
				$sheet->getStyle($k.$r)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
			}
		}
		$r++;
	}
	
	//die('dvvvf');
	$highestRow = $sheet->getHighestDataRow();
	$sheet->getProtection()->setSheet(true);
   	$sheet->getStyle('C4:'.$last_col.$highestRow)->getProtection()
		->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);	
	//$sheet->getStyle('C4:'.$last_col.$highestRow)->getNumberFormat()->setFormatCode('[<>0]#,##0.00; [=0]"-  "');	
	$sheet->freezePane('C4');
	$sheet->setTitle($months[$_SESSION['rego']['cur_month']].' '.$_SESSION['rego']['year_'.$lang]);
	//$sheet->setActiveSheetIndex(0);
	
	ob_end_clean();
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$filename.'"');
	header('Cache-Control: max-age=0');
	
	$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
	$writer->save('php://output');

?>