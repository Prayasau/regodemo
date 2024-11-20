<?php
	if(session_id()==''){session_start();}; ob_start();
	include('../../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	include(DIR.'files/arrays_'.$_SESSION['rego']['lang'].'.php');


	$time_regArray = array('0' => $lng['No'],'1' => $lng['Yes']);
	$selfieArray = array('0' => $lng['No'],'1' => $lng['Yes']);
	$workFromHomeArray = array('0' => $lng['No'],'1' => $lng['Yes']);


	
	if($sys_settings['modify_empdata_section_cols'] != '')
	{
		// Add emp_id in the array 
		$export_fields = unserialize($sys_settings['modify_empdata_section_cols']); // PERSONAL INFO SELECTED FIELDS FROM TEMPORARY DATABASE 
		$export_fields=array("emp_id"=>"Employee ID") + $export_fields; 
	}
	else
	{
		$export_fields=array("emp_id"=>"Employee ID");
	}


	// Get default Sytem settings for prefix, auto id 

	$autoIdField = $sys_settings['auto_id'];

	$prefixArrayDb = unserialize($sys_settings['id_prefix']);
	$counter= 1 ;
	foreach ($prefixArrayDb as $key => $value) {
		$count =$counter++ ;
		$prefixArrVal[$count] = $value['idPrefix'];
	}


	$prefix = $prefixArrVal;

	$pref = '';
	foreach($prefix as $v){$pref .= $v.',';}
	$pref = substr($pref,0,-1);

	// time Reg String ARRAY
	$timeRegString = '';
	foreach($time_regArray as $v){$timeRegString .= $v.',';}
	$timeRegString = substr($timeRegString,0,-1);

	// account code ARRAY
	$selfieArrayString = '';
	foreach($selfieArray as $v){$selfieArrayString .= $v.',';}
	$selfieArrayString = substr($selfieArrayString,0,-1);

	// account code ARRAY
	$workFromHomeString = '';
	foreach($workFromHomeArray as $v){$workFromHomeString .= $v.',';}
	$workFromHomeString = substr($workFromHomeString,0,-1);

	require_once(DIR.'PhpSpreadsheet/vendor/autoload.php');

	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	
	$spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->getActiveSheet();
	
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
	
	$sheet->mergeCells('B1:G1');
	$sheet->setCellValue('B1', $sheet_txt);
	$sheet->getRowDimension(1)->setRowHeight(60); 
	$sheet->getStyle('B1')->getAlignment()->setWrapText(true);	
	$sheet->getStyle('B1')->getFont()->setSize(11);
	$sheet->getStyle('A1:G1')->getFill()
		->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
		->getStartColor()->setARGB('FFccffcc');
	$sheet->getStyle('A1:G1')->applyFromArray($allBorders);

	$rows = 500;
	$nr=0;
	foreach($export_fields as $k=>$v){
		$abc = getNameFromNumber($nr);



		// PERSONAL /////////////////////////////////////
		if($autoIdField == '1'){
			if($k == 'emp_id'){$prefix_col = $abc;}
		}
		if($k == 'time_reg'){$time_reg_col = $abc;}
		if($k == 'selfie'){$selfie_col = $abc;}
		if($k == 'workFromHome'){$workFromHome_col = $abc;}
		$nr++;
	}
	
		
	// DROPDOWN //////////////////////////////////////////////
	if(isset($prefix_col)){
		$xprefix = $sheet->getCell($prefix_col.'4')->getDataValidation();
		$xprefix->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
		$xprefix->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP );
		$xprefix->setAllowBlank(false);
		$xprefix->setShowInputMessage(true);
		$xprefix->setShowErrorMessage(true);
		$xprefix->setShowDropDown(true);
		$xprefix->setErrorTitle($lng['Input error']);
		$xprefix->setError($lng['Value is not in list']);
		$xprefix->setFormula1('"'.$pref.'"');	
		//$xprefix->setMinLength(3);	
		$sheet->setDataValidation($prefix_col.'4:'.$prefix_col.$rows, $xprefix);	
	}
	if(isset($time_reg_col)){
		$xtitle = $sheet->getCell($time_reg_col.'4')->getDataValidation();
		$xtitle->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
		$xtitle->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP );
		$xtitle->setAllowBlank(false);
		$xtitle->setShowInputMessage(true);
		$xtitle->setShowErrorMessage(true);
		$xtitle->setShowDropDown(true);
		$xtitle->setErrorTitle($lng['Input error']);
		$xtitle->setError($lng['Value is not in list']);
		$xtitle->setFormula1('"'.$timeRegString.'"');	
		$sheet->setDataValidation($time_reg_col.'4:'.$time_reg_col.$rows, $xtitle);	
	}
	if(isset($selfie_col)){
		$xgender = $sheet->getCell($selfie_col.'4')->getDataValidation();
		$xgender->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
		$xgender->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP );
		$xgender->setAllowBlank(false);
		$xgender->setShowInputMessage(true);
		$xgender->setShowErrorMessage(true);
		$xgender->setShowDropDown(true);
		$xgender->setErrorTitle($lng['Input error']);
		$xgender->setError($lng['Value is not in list']);
		$xgender->setFormula1('"'.$selfieArrayString.'"');	
		$sheet->setDataValidation($selfie_col.'4:'.$selfie_col.$rows, $xgender);	
	}	

	if(isset($workFromHome_col)){
		$xgender = $sheet->getCell($workFromHome_col.'4')->getDataValidation();
		$xgender->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
		$xgender->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP );
		$xgender->setAllowBlank(false);
		$xgender->setShowInputMessage(true);
		$xgender->setShowErrorMessage(true);
		$xgender->setShowDropDown(true);
		$xgender->setErrorTitle($lng['Input error']);
		$xgender->setError($lng['Value is not in list']);
		$xgender->setFormula1('"'.$workFromHomeString.'"');	
		$sheet->setDataValidation($workFromHome_col.'4:'.$workFromHome_col.$rows, $xgender);	
	}

	$nr=0;
	$rw = 3;
	foreach($export_fields as $k=>$v){
		$abc = getNameFromNumber($nr);
		$sheet->setCellValue($abc.'2', $k);
		$sheet->setCellValue($abc.'3', $v);
		$nr++;
	}
	
	// MESSAGE BOX ///////////////////////////////////////////////////////////////



	if($autoIdField != '1'){


			$prefix_cols = 'A';
			$commentRichText = $sheet->getComment($prefix_cols.$rw)->getText()->createTextRun('Create New Employee'.':')->getFont()->setBold(true);
			$sheet->getComment($prefix_cols.$rw)->getText()->createTextRun("\r\nPlease make sure your\nEmployee ID is unique");
			$sheet->getComment($prefix_cols.$rw)->setWidth("300px")->setHeight("60px");		
		

	}
	else
	{
		if(isset($prefix_col)){
			$commentRichText = $sheet->getComment($prefix_col.$rw)->getText()->createTextRun('ID Prefix'.':')->getFont()->setBold(true);
			$sheet->getComment($prefix_col.$rw)->getText()->createTextRun("\r\nPlease select only Prefix\nAuto numbering on Import");
			$sheet->getComment($prefix_col.$rw)->setWidth("300px")->setHeight("60px");		
		}
	}
	
	if(isset($time_reg_col)){
		$commentRichText = $sheet->getComment($time_reg_col.$rw)->getText()->createTextRun($lng['Title'].':')->getFont()->setBold(true);
		$h = 25;
		foreach($time_regArray as $k=>$v){
			$sheet->getComment($time_reg_col.$rw)->getText()->createTextRun("\r\n".$v);
			$h += 20;
		}
		$sheet->getComment($time_reg_col.$rw)->setWidth("100px")->setHeight($h."px");		
	}	
	if(isset($selfie_col)){
		$commentRichText = $sheet->getComment($selfie_col.$rw)->getText()->createTextRun($lng['Title'].':')->getFont()->setBold(true);
		$h = 25;
		foreach($selfieArray as $k=>$v){
			$sheet->getComment($selfie_col.$rw)->getText()->createTextRun("\r\n".$v);
			$h += 20;
		}
		$sheet->getComment($selfie_col.$rw)->setWidth("100px")->setHeight($h."px");		
	}

	
	if(isset($workFromHome_col)){
		$commentRichText = $sheet->getComment($workFromHome_col.$rw)->getText()->createTextRun($lng['Title'].':')->getFont()->setBold(true);
		$h = 25;
		foreach($workFromHomeArray as $k=>$v){
			$sheet->getComment($workFromHome_col.$rw)->getText()->createTextRun("\r\n".$v);
			$h += 20;
		}
		$sheet->getComment($workFromHome_col.$rw)->setWidth("100px")->setHeight($h."px");		
	}


	
	$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);


		$sql1 = "SELECT * FROM ".$cid."_temp_employee_data ORDER BY emp_id ASC";
		if($res1 = $dbc->query($sql1)){
			if($row1 = $res1->fetch_assoc())
			{
				$sheet->setCellValue('A1', 'UPDATE');
			}
			else
			{
				$sheet->setCellValue('A1', 'NEW');
			}


		}

		$sql = "SELECT * FROM ".$cid."_temp_employee_data ORDER BY emp_id ASC";
		if($res = $dbc->query($sql)){
			$r=4; $c=0;
			while($row = $res->fetch_assoc()){
				foreach($export_fields as $k => $v){

					$abc = getNameFromNumber($c);
					if($k == 'en_name'){
						$sheet->setCellValue($abc.$r, $row['firstname'].' '.$row['lastname']); $c++;
					}else if($k == 'time_reg'){
						$sheet->setCellValue($abc.$r, $time_regArray[$row[$k]]); $c++;
					}else if($k == 'selfie'){
						$sheet->setCellValue($abc.$r, $selfieArray[$row[$k]]); $c++;
					}else if($k == 'workFromHome'){
						$sheet->setCellValue($abc.$r, $workFromHomeArray[$row[$k]]); $c++;
					}else{
						$sheet->setCellValue($abc.$r, $row[$k]); $c++;
					}
					$sheet->getColumnDimension($abc)->setAutoSize(true);
					$data[$r][$k] = $row[$k];
				}
				$r++; $c=0;
			}
		}
	


	// if less than 3 columns then hide this otherwise show
	$hCol = $sheet->getHighestColumn();
	$hRow = $r;
	$sheet->getStyle('A3:'.$hCol.$rw)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFccffcc');
	$sheet->getStyle('A3:'.$hCol.$rw)->applyFromArray($allBorders);
		


	// echo '<pre>';
	// print_r($data);
	// echo '</pre>';

	// die();



	if($autoIdField == '1'){
		$sheet->getProtection()->setSheet(true);
		$sheet->getStyle('B4:'.$hCol.$hRow)->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
		$sheet->getStyle('A'.$hRow.':'.$hCol.($hRow+100))->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED); 
	}  	
	
	/*foreach($hor_center as $v){
		$sheet->getStyle($v.'3:'.$v.$hRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	}*/
	
	$sheet->getColumnDimension('A')->setAutoSize(true);
	$sheet->getColumnDimension('B')->setAutoSize(true);
	$sheet->getColumnDimension('C')->setAutoSize(true);
	$sheet->getColumnDimension('D')->setAutoSize(true);
	$sheet->setTitle($lng['Employees']);
	$sheet->getRowDimension(2)->setVisible(false);
	$sheet->freezePane('B4','B4');
	
//------------------------------------------------------------------------------------------------- NEW SHEET
	
	$spreadsheet->setActiveSheetIndex(0);
	$filename = $_SESSION['rego']['cid'].'_time.xlsx';
	
	ob_clean();
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$filename.'"');
	header('Cache-Control: max-age=0');
	
	$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
	$writer->save('php://output');

?>