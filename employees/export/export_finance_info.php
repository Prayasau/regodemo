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
	
	
	$bank_codes = unserialize($rego_settings['bank_codes']);
	$banksarray=array();
	foreach($bank_codes as $v){
	    if($v['apply']=='1')$banksarray[$v['code']]=$v['en'];
	}
	$accountCodeArray = array('0' => 'Direct','1' => 'Indirect');
	
	//print_r($bank_codes);exit;
	// leave D
	$calcmethod=array('cam'=>'Calculate in Advance Method(CAM)','acm'=>'Accumulative Calculation Method(ACM)','ytd'=>'Year To Date(YTD)');
	$calctax=array('1'=>'PND 1','3'=>'PND 3','0'=>'No Tax');
	
	$sqlgetgroups = "SELECT * FROM ".$cid."_groups ";
	if($resgetgroups = $dbc->query($sqlgetgroups))
	{
	    while($rowgetgroups = $resgetgroups->fetch_assoc())
	    {
	        $getAllGroups[$rowgetgroups['id']]= $rowgetgroups['en'];
	    }
	}
	$income_section=array(1=>'PND1 40(1) salaries wages as employees',2=>'PND1 40(1)  salaries wages under 3%',3=>'PND1 40(2) Other compensations',6=>'PND1 40(1) (2) Single payment by reason of termination', 4=>'PND3 40(8) Income from Business',5=>'None');
	
	
	// TITLE ARRAY
	$contract_typeString = '';
	foreach($contract_type as $v){$contract_typeString .= $v.',';}
	$contract_typeString = substr($contract_typeString,0,-1);

	// GENDER ARRAY
	$calc_baseString = '';
	foreach($calc_base as $v){$calc_baseString .= $v.',';}
	$calc_baseString = substr($calc_baseString,0,-1);
	// MARITIAL ARRAY
	$bankNameString = '';$bankCodeString='';////
	foreach($banksarray as $k=>$v){$bankNameString .= $v.',';$bankCodeString.=$k.',';}
	$bankNameString = substr($bankNameString,0,-1);
	$bankCodeString = substr($bankCodeString,0,-1);
	// MARITIAL ARRAY
	$pay_typeString = '';
	foreach($pay_type as $v){$pay_typeString .= $v.',';}
	$pay_typeString = substr($pay_typeString,0,-1);
	// RELIGION ARRAY
	$accountCodeString = '';
	foreach($accountCodeArray as $v){$accountCodeString .= $v.',';}
	$accountCodeString = substr($accountCodeString,0,-1);
	$calcMethodString = '';
	foreach($calcmethod as $v){$calcMethodString .= $v.',';}
	$calcMethodString = substr($calcMethodString,0,-1);
	$calcTaxString = '';
	foreach($calctax as $v){$calcTaxString .= $v.',';}
	$calcTaxString = substr($calcTaxString,0,-1);	
	$tax_residency_statusString = '';
	foreach($tax_residency_status as $v){$tax_residency_statusString .= $v.',';}
	$tax_residency_statusString = substr($tax_residency_statusString,0,-1);
	$income_sectionString = '';
	foreach($income_section as $v){$income_sectionString .= $v.',';}
	$income_sectionString = substr($income_sectionString,0,-1);
	$calcssoString = '';
	foreach($noyes01 as $v){$calcssoString .= $v.',';}
	$calcssoString = substr($calcssoString,0,-1);
	$ssoByString = '';
	foreach($sso_paidby as $v){$ssoByString .= $v.',';}
	$ssoByString = substr($ssoByString,0,-1);
	$groupString ='';
	foreach($getAllGroups as $v){$groupString .= $v.',';}
	$groupString = substr($groupString,0,-1);
	
	
	
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
		if($k == 'contract_type')$contract_type_col= $abc;
		if($k == 'calc_base')$calc_base_col = $abc;
		if($k == 'pay_type')$pay_type_col = $abc;
		if($k == 'account_code')$accountCode_col = $abc;
		if($k == 'bank_name')$bankName_col = $abc;
		if($k == 'bank_code')$bankCode_col = $abc;
		if($k == 'calc_method')$calcMethod_col = $abc;
		if($k == 'calc_tax')$calcTax_col= $abc;
		if($k == 'tax_residency_status')$tax_residency_status_col = $abc;
		if($k == 'income_section')$income_section_col = $abc;
		if($k == 'calc_sso')$calc_sso_col = $abc;
		if($k == 'sso_by')$ssoBy_col = $abc;
		if($k == 'groups')$group_col = $abc;
		if($k == 'bank_account'){
			$bankaccount_col = $abc; 
			$sheet->getStyle($abc)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
		}
		if($k == 'modify_tax'){
		    $modifyTax_col = $abc;
		    $sheet->getStyle($abc)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
		}if($k == 'savings'){
		    $savings_col = $abc;
		    $sheet->getStyle($abc)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
		}if($k == 'leagal_execution'){
		    $legalExec_col = $abc;
		    $sheet->getStyle($abc)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
		}if($k == 'kor_yor_sor'){
		    $koryorsor_col = $abc;
		    $sheet->getStyle($abc)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
		}

		$nr++;
	}
	
		//print_r($tax_residency_statusString);die();


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
	if(isset($contract_type_col)){
	    $xtitle = $sheet->getCell($contract_type_col.'4')->getDataValidation();
		$xtitle->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
		$xtitle->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP );
		$xtitle->setAllowBlank(false);
		$xtitle->setShowInputMessage(true);
		$xtitle->setShowErrorMessage(true);
		$xtitle->setShowDropDown(true);
		$xtitle->setErrorTitle($lng['Input error']);
		$xtitle->setError($lng['Value is not in list']);
		$xtitle->setFormula1('"'.$contract_typeString.'"');	
		$sheet->setDataValidation($contract_type_col.'4:'.$contract_type_col.$rows, $xtitle);	
	}
	if(isset($calc_base_col)){
	    $xgender = $sheet->getCell($calc_base_col.'4')->getDataValidation();
		$xgender->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
		$xgender->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP );
		$xgender->setAllowBlank(false);
		$xgender->setShowInputMessage(true);
		$xgender->setShowErrorMessage(true);
		$xgender->setShowDropDown(true);
		$xgender->setErrorTitle($lng['Input error']);
		$xgender->setError($lng['Value is not in list']);
		$xgender->setFormula1('"'.$calc_baseString.'"');	
		$sheet->setDataValidation($calc_base_col.'4:'.$calc_base_col.$rows, $xgender);	
	}
	if(isset($pay_type_col)){
	    $xmaritial = $sheet->getCell($pay_type_col.'4')->getDataValidation();
		$xmaritial->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
		$xmaritial->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP );
		$xmaritial->setAllowBlank(false);
		$xmaritial->setShowInputMessage(true);
		$xmaritial->setShowErrorMessage(true);
		$xmaritial->setShowDropDown(true);
		$xmaritial->setErrorTitle($lng['Input error']);
		$xmaritial->setError($lng['Value is not in list']);
		$xmaritial->setFormula1('"'.$pay_typeString.'"');	
		$sheet->setDataValidation($pay_type_col.'4:'.$pay_type_col.$rows, $xmaritial);	
	}
	if(isset($accountCode_col)){
	    $xreligion = $sheet->getCell($accountCode_col.'4')->getDataValidation();
		$xreligion->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
		$xreligion->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP );
		$xreligion->setAllowBlank(false);
		$xreligion->setShowInputMessage(true);
		$xreligion->setShowErrorMessage(true);
		$xreligion->setShowDropDown(true);
		$xreligion->setErrorTitle($lng['Input error']);
		$xreligion->setError($lng['Value is not in list']);
		$xreligion->setFormula1('"'.$accountCodeString.'"');	
		$sheet->setDataValidation($accountCode_col.'4:'.$accountCode_col.$rows, $xreligion);	
	}
	if(isset($bankName_col)){
	    $xreligion = $sheet->getCell($bankName_col.'4')->getDataValidation();
	    $xreligion->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
	    $xreligion->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP );
	    $xreligion->setAllowBlank(false);
	    $xreligion->setShowInputMessage(true);
	    $xreligion->setShowErrorMessage(true);
	    $xreligion->setShowDropDown(true);
	    $xreligion->setErrorTitle($lng['Input error']);
	    $xreligion->setError($lng['Value is not in list']);
	    $xreligion->setFormula1('"'.$bankNameString.'"');
	    $sheet->setDataValidation($bankName_col.'4:'.$bankName_col.$rows, $xreligion);
	}
	if(isset($bankCode_col)){
	    $xreligion = $sheet->getCell($bankCode_col.'4')->getDataValidation();
	    $xreligion->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
	    $xreligion->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP );
	    $xreligion->setAllowBlank(false);
	    $xreligion->setShowInputMessage(true);
	    $xreligion->setShowErrorMessage(true);
	    $xreligion->setShowDropDown(true);
	    $xreligion->setErrorTitle($lng['Input error']);
	    $xreligion->setError($lng['Value is not in list']);
	    $xreligion->setFormula1('"'.$bankCodeString.'"');
	    $sheet->setDataValidation($bankCode_col.'4:'.$bankCode_col.$rows, $xreligion);
	}
	if(isset($calcMethod_col)){
	    $xmilitary = $sheet->getCell($calcMethod_col.'4')->getDataValidation();
		$xmilitary->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
		$xmilitary->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP );
		$xmilitary->setAllowBlank(false);
		$xmilitary->setShowInputMessage(true);
		$xmilitary->setShowErrorMessage(true);
		$xmilitary->setShowDropDown(true);
		$xmilitary->setErrorTitle($lng['Input error']);
		$xmilitary->setError($lng['Value is not in list']);
		$xmilitary->setFormula1('"'.$calcMethodString.'"');	
		$sheet->setDataValidation($calcMethod_col.'4:'.$calcMethod_col.$rows, $xmilitary);	
	}
	if(isset($calcTax_col)){
	    $xmilitary = $sheet->getCell($calcTax_col.'4')->getDataValidation();
	    $xmilitary->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
	    $xmilitary->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP );
	    $xmilitary->setAllowBlank(false);
	    $xmilitary->setShowInputMessage(true);
	    $xmilitary->setShowErrorMessage(true);
	    $xmilitary->setShowDropDown(true);
	    $xmilitary->setErrorTitle($lng['Input error']);
	    $xmilitary->setError($lng['Value is not in list']);
	    $xmilitary->setFormula1('"'.$calcTaxString.'"');
	    $sheet->setDataValidation($calcTax_col.'4:'.$calcTax_col.$rows, $xmilitary);
	}
	if(isset($tax_residency_status_col)){
	    $xmilitary = $sheet->getCell($tax_residency_status_col.'4')->getDataValidation();
	    $xmilitary->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
	    $xmilitary->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP );
	    $xmilitary->setAllowBlank(false);
	    $xmilitary->setShowInputMessage(true);
	    $xmilitary->setShowErrorMessage(true);
	    $xmilitary->setShowDropDown(true);
	    $xmilitary->setErrorTitle($lng['Input error']);
	    $xmilitary->setError($lng['Value is not in list']);
	    $xmilitary->setFormula1('"'.$tax_residency_statusString.'"');
	    $sheet->setDataValidation($tax_residency_status_col.'4:'.$tax_residency_status_col.$rows, $xmilitary);
	}
	if(isset($income_section_col)){
	    $xmilitary = $sheet->getCell($income_section_col.'4')->getDataValidation();
	    $xmilitary->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
	    $xmilitary->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP );
	    $xmilitary->setAllowBlank(false);
	    $xmilitary->setShowInputMessage(true);
	    $xmilitary->setShowErrorMessage(true);
	    $xmilitary->setShowDropDown(true);
	    $xmilitary->setErrorTitle($lng['Input error']);
	    $xmilitary->setError($lng['Value is not in list']);
	    $xmilitary->setFormula1('"'.$income_sectionString.'"');
	    $sheet->setDataValidation($income_section_col.'4:'.$income_section_col.$rows, $xmilitary);
	}
	if(isset($calc_sso_col)){
	    $xmilitary = $sheet->getCell($calc_sso_col.'4')->getDataValidation();
	    $xmilitary->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
	    $xmilitary->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP );
	    $xmilitary->setAllowBlank(false);
	    $xmilitary->setShowInputMessage(true);
	    $xmilitary->setShowErrorMessage(true);
	    $xmilitary->setShowDropDown(true);
	    $xmilitary->setErrorTitle($lng['Input error']);
	    $xmilitary->setError($lng['Value is not in list']);
	    $xmilitary->setFormula1('"'.$calcssoString.'"');
	    $sheet->setDataValidation($calc_sso_col.'4:'.$calc_sso_col.$rows, $xmilitary);
	}
	if(isset($ssoBy_col)){
	    $xmilitary = $sheet->getCell($ssoBy_col.'4')->getDataValidation();
	    $xmilitary->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
	    $xmilitary->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP );
	    $xmilitary->setAllowBlank(false);
	    $xmilitary->setShowInputMessage(true);
	    $xmilitary->setShowErrorMessage(true);
	    $xmilitary->setShowDropDown(true);
	    $xmilitary->setErrorTitle($lng['Input error']);
	    $xmilitary->setError($lng['Value is not in list']);
	    $xmilitary->setFormula1('"'.$ssoByString.'"');
	    $sheet->setDataValidation($ssoBy_col.'4:'.$ssoBy_col.$rows, $xmilitary);
	}
	if(isset($group_col)){
	    $xmilitary = $sheet->getCell($group_col.'4')->getDataValidation();
	    $xmilitary->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
	    $xmilitary->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP );
	    $xmilitary->setAllowBlank(false);
	    $xmilitary->setShowInputMessage(true);
	    $xmilitary->setShowErrorMessage(true);
	    $xmilitary->setShowDropDown(true);
	    $xmilitary->setErrorTitle($lng['Input error']);
	    $xmilitary->setError($lng['Value is not in list']);
	    $xmilitary->setFormula1('"'.$groupString.'"');
	    $sheet->setDataValidation($group_col.'4:'.$group_col.$rows, $xmilitary);
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
	
	if(isset($contract_type_col)){
	    $commentRichText = $sheet->getComment($contract_type_col.$rw)->getText()->createTextRun('Contract Type'.':')->getFont()->setBold(true);
		$h = 25;
		foreach($contract_type as $k=>$v){
		    $sheet->getComment($contract_type_col.$rw)->getText()->createTextRun("\r\n".$v);
			$h += 20;
		}
		$sheet->getComment($contract_type_col.$rw)->setWidth("100px")->setHeight($h."px");		
	}
	if(isset($calc_base_col)){
	    $commentRichText = $sheet->getComment($calc_base_col.$rw)->getText()->createTextRun('Calculation Base'.':')->getFont()->setBold(true);
	    $h = 25;
	    foreach($ccalc_base as $k=>$v){
	        $sheet->getComment($calc_base_col.$rw)->getText()->createTextRun("\r\n".$v);
	        $h += 20;
	    }
	    $sheet->getComment($calc_base_col.$rw)->setWidth("100px")->setHeight($h."px");		
	}
	if(isset($pay_type_col)){
	    $commentRichText = $sheet->getComment($pay_type_col.$rw)->getText()->createTextRun('Payment Type'.':')->getFont()->setBold(true);
		$h = 25;
		foreach($pay_type as $k=>$v){
		    $sheet->getComment($pay_type_col.$rw)->getText()->createTextRun("\r\n".$v);
			$h += 20;
		}
		$sheet->getComment($pay_type_col.$rw)->setWidth("150px")->setHeight($h."px");		
	}
	if(isset($accountCode_col)){
	    $commentRichText = $sheet->getComment($accountCode_col.$rw)->getText()->createTextRun('Accounting Code'.':')->getFont()->setBold(true);
		$h = 25;
		foreach($accountCodeArray as $k=>$v){
		    $sheet->getComment($accountCode_col.$rw)->getText()->createTextRun("\r\n".$v);
			$h += 20;
		}
		$sheet->getComment($accountCode_col.$rw)->setWidth("200px")->setHeight($h."px");		
	}
	if(isset($bankName_col)){
	    $commentRichText = $sheet->getComment($bankName_col.$rw)->getText()->createTextRun('Bank Name'.':')->getFont()->setBold(true);
	    $h = 25;
	    foreach($banksarray as $k=>$v){
	        $sheet->getComment($bankName_col.$rw)->getText()->createTextRun("\r\n".$v.' - '.$k);
	        $h += 20;
	    }
	    $sheet->getComment($bankName_col.$rw)->setWidth("150px")->setHeight($h."px");
	}
	if(isset($bankCode_col)){
	    $commentRichText = $sheet->getComment($bankCode_col.$rw)->getText()->createTextRun('Bank Code'.':')->getFont()->setBold(true);
	    $h = 25;
	    foreach($banksarray as $k=>$v){
	        $sheet->getComment($bankCode_col.$rw)->getText()->createTextRun("\r\n".$k);
	        $h += 20;
	    }
	    $sheet->getComment($bankCode_col.$rw)->setWidth("150px")->setHeight($h."px");
	}
	if(isset($calcMethod_col)){
	    $commentRichText = $sheet->getComment($calcMethod_col.$rw)->getText()->createTextRun('Tax Calculation Method'.':')->getFont()->setBold(true);
		$h = 25;
		foreach($calcmethod as $k=>$v){
		    $sheet->getComment($calcMethod_col.$rw)->getText()->createTextRun("\r\n".$v);
			$h += 20;
		}
		$sheet->getComment($calcMethod_col.$rw)->setWidth("150px")->setHeight($h."px");		
	}
	if(isset($calcTax_col)){
	    $commentRichText = $sheet->getComment($calcTax_col.$rw)->getText()->createTextRun('Calculate Tax'.':')->getFont()->setBold(true);
		$h = 25;
		foreach($calctax as $k=>$v){
		    $sheet->getComment($calcTax_col.$rw)->getText()->createTextRun("\r\n".$v);
			$h += 20;
		}
		$sheet->getComment($calcTax_col.$rw)->setWidth("200px")->setHeight($h."px");		
	}
	if(isset($tax_residency_status_col)){
	    $commentRichText = $sheet->getComment($tax_residency_status_col.$rw)->getText()->createTextRun('Tax Residency Status'.':')->getFont()->setBold(true);
	    $h = 25;
	    foreach($tax_residency_status as $k=>$v){
	        $sheet->getComment($tax_residency_status_col.$rw)->getText()->createTextRun("\r\n".$v);
	        $h += 20;
	    }
	    $sheet->getComment($tax_residency_status_col.$rw)->setWidth("200px")->setHeight($h."px");	
	}
	if(isset($income_section_col)){
	    $commentRichText = $sheet->getComment($income_section_col.$rw)->getText()->createTextRun('Calculate Tax'.':')->getFont()->setBold(true);
	    $h = 25;
	    foreach($income_section as $k=>$v){
	        $sheet->getComment($income_section_col.$rw)->getText()->createTextRun("\r\n".$v);
	        $h += 20;
	    }
	    $sheet->getComment($income_section_col.$rw)->setWidth("200px")->setHeight($h."px");	
	}
	if(isset($calc_sso_col)){
	    $commentRichText = $sheet->getComment($calc_sso_col.$rw)->getText()->createTextRun('Calculate Tax'.':')->getFont()->setBold(true);
	    $h = 25;
	    foreach($noyes01 as $k=>$v){
	        $sheet->getComment($calc_sso_col.$rw)->getText()->createTextRun("\r\n".$v);
	        $h += 20;
	    }
	    $sheet->getComment($calc_sso_col.$rw)->setWidth("200px")->setHeight($h."px");	
	}if(isset($ssoBy_col)){
	    $commentRichText = $sheet->getComment($ssoBy_col.$rw)->getText()->createTextRun('Calculate Tax'.':')->getFont()->setBold(true);
	    $h = 25;
	    foreach($sso_paidby as $k=>$v){
	        $sheet->getComment($ssoBy_col.$rw)->getText()->createTextRun("\r\n".$v);
	        $h += 20;
	    }
	    $sheet->getComment($ssoBy_col.$rw)->setWidth("200px")->setHeight($h."px");	
	}if(isset($group_col)){
	    $commentRichText = $sheet->getComment($group_col.$rw)->getText()->createTextRun('Calculate Tax'.':')->getFont()->setBold(true);
	    $h = 25;
	    foreach($getAllGroups as $k=>$v){
	        $sheet->getComment($group_col.$rw)->getText()->createTextRun("\r\n".$v);
	        $h += 20;
	    }
	    $sheet->getComment($group_col.$rw)->setWidth("200px")->setHeight($h."px");	
	}
	//print_r($getAllGroups);print_r($groupString);print_r($group_col);exit;
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
					if($k == 'contract_type'){
					    $sheet->setCellValue($abc.$r, $contract_type[$row[$k]]); $c++;
					}else if($k == 'calc_base'){
					    $sheet->setCellValue($abc.$r, $calc_base[$row[$k]]); $c++;
					}else if($k == 'bank_name'){
						$sheet->setCellValue($abc.$r, $banksarray[$row[$k]]); $c++;
					}else if($k == 'pay_type'){
						$sheet->setCellValue($abc.$r, $pay_type[$row[$k]]); $c++;
					}else if($k == 'account_code'){
						$sheet->setCellValue($abc.$r, $accountCodeArray[$row[$k]]); $c++;
					}else if($k == 'calc_method'){
					    $sheet->setCellValue($abc.$r, $calcmethod[$row[$k]] ); $c++;
					}else if($k == 'calc_tax'){
					    $sheet->setCellValue($abc.$r, $calctax[$row[$k]]); $c++;
					}else if($k == 'tax_residency_status'){
					    $sheet->setCellValue($abc.$r, $tax_residency_status[$row[$k]]); $c++;
					}else if($k == 'income_section'){
					    $sheet->setCellValue($abc.$r, $income_section[$row[$k]]); $c++;
					}else if($k == 'calc_sso'){
					    $sheet->setCellValue($abc.$r, $noyes01[$row[$k]]); $c++;
					}else if($k == 'sso_by'){
					    $sheet->setCellValue($abc.$r, $sso_paidby[$row[$k]]); $c++;
					}else if($k == 'groups'){
					    $sheet->setCellValue($abc.$r, $getAllGroups[$row[$k]]); $c++;
					}else{
						$sheet->setCellValue($abc.$r, $row[$k]); $c++;
					}
					$sheet->getColumnDimension($abc)->setAutoSize(true);
					$data[$r][$k] = $row[$k];
					//print_r($row);
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
	$filename = $_SESSION['rego']['cid'].'_finance_info.xlsx';
	
	ob_clean();
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$filename.'"');
	header('Cache-Control: max-age=0');
	
	$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
	$writer->save('php://output');

?>