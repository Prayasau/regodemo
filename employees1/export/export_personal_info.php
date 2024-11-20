<?php
	if(session_id()==''){session_start();}; ob_start();
	include('../../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	include(DIR.'files/arrays_'.$_SESSION['rego']['lang'].'.php');


	
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

	// TITLE ARRAY
	$titelString = '';
	foreach($title as $v){$titelString .= $v.',';}
	$titelString = substr($titelString,0,-1);

	// GENDER ARRAY
	$genderString = '';
	foreach($gender as $v){$genderString .= $v.',';}
	$genderString = substr($genderString,0,-1);
	// MARITIAL ARRAY
	$maritialString = '';
	foreach($maritial as $v){$maritialString .= $v.',';}
	$maritialString = substr($maritialString,0,-1);
	// MARITIAL ARRAY
	$militaryString = '';
	foreach($military_status as $v){$militaryString .= $v.',';}
	$militaryString = substr($militaryString,0,-1);
	// RELIGION ARRAY
	$religionString = '';
	foreach($religion as $v){$religionString .= $v.',';}
	$religionString = substr($religionString,0,-1);
	$yesnoString ='';
	foreach($yesno as $v){$yesnoString .= $v.',';}
	$yesnoString = substr($yesnoString,0,-1);
	
	
	
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
		if($k == 'title'){$title_col = $abc;}
		if($k == 'birthdate'){$birth_col = $abc;}
		if($k == 'gender'){$gender_col = $abc;}
		if($k == 'maritial'){$maritial_col = $abc;}
		if($k == 'religion'){$religion_col = $abc;}
		if($k == 'military_status'){$military_col = $abc;}
		if($k == 'drvlicense_exp'){$drvlicense_exp_col = $abc;}
		if($k == 'idcard_nr'){
			$idcard_col = $abc; 
			$sheet->getStyle($abc)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
		}
		if($k == 'idcard_exp'){$idcard_exp_col = $abc;}
		if($k == 'tax_id'){
			$tax_id_col = $abc; 
			$sheet->getStyle($abc)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
		}
		if($k == 'sso_id'){
		    $sso_id_col = $abc;
		    $sheet->getStyle($abc)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
		}
		if($k == 'same_sso'){$same_sso_col = $abc;}
		if($k == 'same_tax'){$same_tax_col = $abc;}
		

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
	if(isset($title_col)){
		$xtitle = $sheet->getCell($title_col.'4')->getDataValidation();
		$xtitle->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
		$xtitle->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP );
		$xtitle->setAllowBlank(false);
		$xtitle->setShowInputMessage(true);
		$xtitle->setShowErrorMessage(true);
		$xtitle->setShowDropDown(true);
		$xtitle->setErrorTitle($lng['Input error']);
		$xtitle->setError($lng['Value is not in list']);
		$xtitle->setFormula1('"'.$titelString.'"');	
		$sheet->setDataValidation($title_col.'4:'.$title_col.$rows, $xtitle);	
	}
	if(isset($gender_col)){
		$xgender = $sheet->getCell($gender_col.'4')->getDataValidation();
		$xgender->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
		$xgender->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP );
		$xgender->setAllowBlank(false);
		$xgender->setShowInputMessage(true);
		$xgender->setShowErrorMessage(true);
		$xgender->setShowDropDown(true);
		$xgender->setErrorTitle($lng['Input error']);
		$xgender->setError($lng['Value is not in list']);
		$xgender->setFormula1('"'.$genderString.'"');	
		$sheet->setDataValidation($gender_col.'4:'.$gender_col.$rows, $xgender);	
	}
	if(isset($maritial_col)){
		$xmaritial = $sheet->getCell($maritial_col.'4')->getDataValidation();
		$xmaritial->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
		$xmaritial->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP );
		$xmaritial->setAllowBlank(false);
		$xmaritial->setShowInputMessage(true);
		$xmaritial->setShowErrorMessage(true);
		$xmaritial->setShowDropDown(true);
		$xmaritial->setErrorTitle($lng['Input error']);
		$xmaritial->setError($lng['Value is not in list']);
		$xmaritial->setFormula1('"'.$maritialString.'"');	
		$sheet->setDataValidation($maritial_col.'4:'.$maritial_col.$rows, $xmaritial);	
	}
	if(isset($religion_col)){
		$xreligion = $sheet->getCell($religion_col.'4')->getDataValidation();
		$xreligion->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
		$xreligion->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP );
		$xreligion->setAllowBlank(false);
		$xreligion->setShowInputMessage(true);
		$xreligion->setShowErrorMessage(true);
		$xreligion->setShowDropDown(true);
		$xreligion->setErrorTitle($lng['Input error']);
		$xreligion->setError($lng['Value is not in list']);
		$xreligion->setFormula1('"'.$religionString.'"');	
		$sheet->setDataValidation($religion_col.'4:'.$religion_col.$rows, $xreligion);	
	}
	if(isset($military_col)){
		$xmilitary = $sheet->getCell($military_col.'4')->getDataValidation();
		$xmilitary->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
		$xmilitary->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP );
		$xmilitary->setAllowBlank(false);
		$xmilitary->setShowInputMessage(true);
		$xmilitary->setShowErrorMessage(true);
		$xmilitary->setShowDropDown(true);
		$xmilitary->setErrorTitle($lng['Input error']);
		$xmilitary->setError($lng['Value is not in list']);
		$xmilitary->setFormula1('"'.$militaryString.'"');	
		$sheet->setDataValidation($military_col.'4:'.$military_col.$rows, $xmilitary);	
	}
	if(isset($same_sso_col)){
	    $xmilitary = $sheet->getCell($same_sso_col.'4')->getDataValidation();
	    $xmilitary->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
	    $xmilitary->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP );
	    $xmilitary->setAllowBlank(false);
	    $xmilitary->setShowInputMessage(true);
	    $xmilitary->setShowErrorMessage(true);
	    $xmilitary->setShowDropDown(true);
	    $xmilitary->setErrorTitle($lng['Input error']);
	    $xmilitary->setError($lng['Value is not in list']);
	    $xmilitary->setFormula1('"'.$yesnoString.'"');
	    $sheet->setDataValidation($same_sso_col.'4:'.$same_sso_col.$rows, $xmilitary);
	}
	if(isset($same_tax_col)){
	    $xmilitary = $sheet->getCell($same_tax_col.'4')->getDataValidation();
	    $xmilitary->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
	    $xmilitary->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP );
	    $xmilitary->setAllowBlank(false);
	    $xmilitary->setShowInputMessage(true);
	    $xmilitary->setShowErrorMessage(true);
	    $xmilitary->setShowDropDown(true);
	    $xmilitary->setErrorTitle($lng['Input error']);
	    $xmilitary->setError($lng['Value is not in list']);
	    $xmilitary->setFormula1('"'.$yesnoString.'"');
	    $sheet->setDataValidation($same_tax_col.'4:'.$same_tax_col.$rows, $xmilitary);
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
	
	if(isset($title_col)){
		$commentRichText = $sheet->getComment($title_col.$rw)->getText()->createTextRun($lng['Title'].':')->getFont()->setBold(true);
		$h = 25;
		foreach($title as $k=>$v){
			$sheet->getComment($title_col.$rw)->getText()->createTextRun("\r\n".$v);
			$h += 20;
		}
		$sheet->getComment($title_col.$rw)->setWidth("100px")->setHeight($h."px");		
	}
	if(isset($birth_col)){
		$commentRichText = $sheet->getComment($birth_col.$rw)->getText()->createTextRun($lng['Date format'].':')->getFont()->setBold(true);	
		$sheet->getComment($birth_col.$rw)->getText()->createTextRun("\r\n".$lng['dd-mm-yyyy']."");	
		$sheet->getComment($birth_col.$rw)->getText()->createTextRun("\r\n".$lng['Example'].": ".date('d-m-Y'));	
		$sheet->getComment($birth_col.$rw)->setWidth("160px")->setHeight("65px");
	}
	if(isset($gender_col)){
		$commentRichText = $sheet->getComment($gender_col.$rw)->getText()->createTextRun($lng['Gender'].':')->getFont()->setBold(true);
		$h = 25;
		foreach($gender as $k=>$v){
			$sheet->getComment($gender_col.$rw)->getText()->createTextRun("\r\n".$v);
			$h += 20;
		}
		$sheet->getComment($gender_col.$rw)->setWidth("150px")->setHeight($h."px");		
	}
	if(isset($maritial_col)){
		$commentRichText = $sheet->getComment($maritial_col.$rw)->getText()->createTextRun($lng['Maritial'].':')->getFont()->setBold(true);
		$h = 25;
		foreach($maritial as $k=>$v){
			$sheet->getComment($maritial_col.$rw)->getText()->createTextRun("\r\n".$v);
			$h += 20;
		}
		$sheet->getComment($maritial_col.$rw)->setWidth("200px")->setHeight($h."px");		
	}
	if(isset($religion_col)){
		$commentRichText = $sheet->getComment($religion_col.$rw)->getText()->createTextRun($lng['Religion'].':')->getFont()->setBold(true);
		$h = 25;
		foreach($religion as $k=>$v){
			$sheet->getComment($religion_col.$rw)->getText()->createTextRun("\r\n".$v);
			$h += 20;
		}
		$sheet->getComment($religion_col.$rw)->setWidth("150px")->setHeight($h."px");		
	}
	if(isset($military_col)){
		$commentRichText = $sheet->getComment($military_col.$rw)->getText()->createTextRun($lng['Military status'].':')->getFont()->setBold(true);
		$h = 25;
		foreach($military_status as $k=>$v){
			$sheet->getComment($military_col.$rw)->getText()->createTextRun("\r\n".$v);
			$h += 20;
		}
		$sheet->getComment($military_col.$rw)->setWidth("200px")->setHeight($h."px");		
	}
	if(isset($same_sso_col)){
	    $commentRichText = $sheet->getComment($same_sso_col.$rw)->getText()->createTextRun($lng['Military status'].':')->getFont()->setBold(true);
	    $h = 25;
	    foreach($yesno as $k=>$v){
	        $sheet->getComment($same_sso_col.$rw)->getText()->createTextRun("\r\n".$v);
	        $h += 20;
	    }
	    $sheet->getComment($same_sso_col.$rw)->setWidth("200px")->setHeight($h."px");
	}
	if(isset($same_tax_col)){
	    $commentRichText = $sheet->getComment($same_tax_col.$rw)->getText()->createTextRun($lng['Military status'].':')->getFont()->setBold(true);
	    $h = 25;
	    foreach($yesno as $k=>$v){
	        $sheet->getComment($same_tax_col.$rw)->getText()->createTextRun("\r\n".$v);
	        $h += 20;
	    }
	    $sheet->getComment($same_tax_col.$rw)->setWidth("200px")->setHeight($h."px");
	}
	if(isset($drvlicense_exp_col)){
		$commentRichText = $sheet->getComment($drvlicense_exp_col.$rw)->getText()->createTextRun($lng['Date format'].':')->getFont()->setBold(true);	
		$sheet->getComment($drvlicense_exp_col.$rw)->getText()->createTextRun("\r\n".$lng['dd-mm-yyyy']."");	
		$sheet->getComment($drvlicense_exp_col.$rw)->getText()->createTextRun("\r\n".$lng['Example'].": ".date('d-m-Y'));	
		$sheet->getComment($drvlicense_exp_col.$rw)->setWidth("160px")->setHeight("65px");
	}
	if(isset($idcard_col)){
		$commentRichText = $sheet->getComment($idcard_col.$rw)->getText()->createTextRun($lng['ID card'].':')->getFont()->setBold(true);	
		$sheet->getComment($idcard_col.$rw)->getText()->createTextRun("\r\n".$lng['Fill numbers only']);	
		$sheet->getComment($idcard_col.$rw)->getText()->createTextRun("\r\n".$lng['Example'].": 0123456789");	
		$sheet->getComment($idcard_col.$rw)->setWidth("180px")->setHeight("65px");
	}
	if(isset($idcard_exp_col)){
		$commentRichText = $sheet->getComment($idcard_exp_col.$rw)->getText()->createTextRun($lng['Date format'].':')->getFont()->setBold(true);	
		$sheet->getComment($idcard_exp_col.$rw)->getText()->createTextRun("\r\n".$lng['dd-mm-yyyy']."");	
		$sheet->getComment($idcard_exp_col.$rw)->getText()->createTextRun("\r\n".$lng['Example'].": ".date('d-m-Y'));	
		$sheet->getComment($idcard_exp_col.$rw)->setWidth("160px")->setHeight("65px");
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
					if($k == 'idcard_nr' || $k == 'tax_id' || $k=='sso_id'){
						$sheet->setCellValueExplicit($abc.$r, $row[$k], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING); $c++;
					}elseif($k == 'joining_date'){
						$sheet->setCellValue($abc.$r, date('d-m-Y', strtotime($row[$k]))); $c++;
					}else if($k == 'title'){
						$sheet->setCellValue($abc.$r, $title[$row[$k]]); $c++;
					}else if($k == 'gender'){
						$sheet->setCellValue($abc.$r, $gender[$row[$k]]); $c++;
					}else if($k == 'religion'){
						$sheet->setCellValue($abc.$r, $religion[$row[$k]]); $c++;
					}else if($k == 'maritial'){
						$sheet->setCellValue($abc.$r, $maritial[$row[$k]]); $c++;
					}else if($k == 'military_status'){
						$sheet->setCellValue($abc.$r, $military_status[$row[$k]]); $c++;
					}else if($k == 'same_sso'){
					    $sameasid=unserialize($row[$k]);
					    if($sameasid['same_sso']=='on')
					    $sheet->setCellValue($abc.$r, 'Yes');
					    else $sheet->setCellValue($abc.$r, 'Yes'); $c++;
					}else if($k == 'same_tax'){
					    $sameasid=unserialize($row[$k]);
					    if($sameasid['same_tax']=='on')
					        $sheet->setCellValue($abc.$r, 'Yes');
					        else $sheet->setCellValue($abc.$r, 'Yes'); $c++;
					}else if($k == 'en_name'){
						$sheet->setCellValue($abc.$r, $row['firstname'].' '.$row['lastname']); $c++;
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
	$filename = $_SESSION['rego']['cid'].'_personal_info.xlsx';
	
	ob_clean();
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$filename.'"');
	header('Cache-Control: max-age=0');
	
	$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
	$writer->save('php://output');

?>