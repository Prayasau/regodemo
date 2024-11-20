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


	// echo '<pre>';
	// print_r($export_fields);
	// echo '</pre>';

	// die(); 


	foreach($export_fields as $k=>$v){
		$abc = getNameFromNumber($nr);

		// CONTACT /////////////////////////////////////
		if($autoIdField == '1'){
			if($k == 'emp_id'){$prefix_col = $abc;}
		}
		if($k == 'annual_leave'){
			$sheet->getStyle($abc)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
		}		

		$nr++;
	}


	$nr=0;
	$rw = 1;
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
					
					$sheet->setCellValue($abc.$r, $row[$k]); $c++;
					
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
		




	if($autoIdField == '1'){
		$sheet->getProtection()->setSheet(true);
		$sheet->getStyle('B4:'.$hCol.$hRow)->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
		$sheet->getStyle('A'.$hRow.':'.$hCol.($hRow+100))->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED); 
	}  	

	
	$sheet->getColumnDimension('A')->setAutoSize(true);
	$sheet->getColumnDimension('B')->setAutoSize(true);
	$sheet->getColumnDimension('C')->setAutoSize(true);
	$sheet->getColumnDimension('D')->setAutoSize(true);
	$sheet->setTitle($lng['Employees']);
	$sheet->getRowDimension(2)->setVisible(false);
	$sheet->freezePane('B4','B4');
	
//------------------------------------------------------------------------------------------------- NEW SHEET
	
	$spreadsheet->setActiveSheetIndex(0);
	$filename = $_SESSION['rego']['cid'].'_leave.xlsx';
	
	ob_clean();
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$filename.'"');
	header('Cache-Control: max-age=0');
	
	$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
	$writer->save('php://output');

?>