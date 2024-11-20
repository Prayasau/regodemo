<?
	if(session_id()==''){session_start();}
	ob_start();
	include('../../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	include(DIR.'time/functions.php');
	$shiftteams = getShifTeams();
	//var_dump($shiftteams); exit;
	
	//$_REQUEST['month'] = 9;

	$end = date('t', strtotime($cur_year.'-'.$_REQUEST['month'].'-01'));
	//var_dump($end); exit;
	$fields['A'] = 'ID';
	$fields['B'] = 'Name';
	$fields['C'] = 'Team';
	$plans = array();
	$sql = "SELECT * FROM ".$cid."_monthly_shiftplans_".$cur_year." WHERE month = ".$_REQUEST['month'];
	if($res = $dbc->query($sql)){
		while($row = $res->fetch_assoc()){
			$plans[$row['emp_id']]['id'] = $row['emp_id'];
			$plans[$row['emp_id']]['name'] = $row['en_name'];
			$plans[$row['emp_id']]['team'] = $shiftteams[$row['shiftteam']];
			for($i=1;$i<=$end;$i++){
				if($row['D'.$i] != 'OFF'){
					$plans[$row['emp_id']]['D'.$i] = ''; 
				}else{
					$plans[$row['emp_id']]['D'.$i] = $row['D'.$i]; 
				}
				$fields['D'][$i] = date('D', strtotime($cur_year.'-'.$_REQUEST['month'].'-'.$i));
			}
		}
	}
	
	require_once DIR.'PhpSpreadsheet/vendor/autoload.php';

	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	//$filename = '../'.$cid.'/'.$cid.'_employees.xlsx';
	
	$allBorders = array(
		 'borders' => array(
			  'allBorders' => array(
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => array('argb' => '00000000'),
			  ),
		 ),
	);
	$fontarray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('argb' => 'ffffffff'),
			'size'  => 11,
			'name'  => 'Calibri'
		)
	);
	 
	$spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->getActiveSheet();
		
	$row = 3;
	
	$sheet->mergeCells('A'.$row.':A'.($row+1));
	$sheet->mergeCells('B'.$row.':B'.($row+1));
	$sheet->mergeCells('C'.$row.':C'.($row+1));
	$sheet->getStyle('A'.$row)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('B'.$row)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('C'.$row)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

	$sheet->setCellValue('A'.$row, $fields['A']);
	$sheet->getColumnDimension('A')->setAutoSize(true);
	$sheet->setCellValue('B'.$row, $fields['B']);
	$sheet->getColumnDimension('B')->setAutoSize(true);
	$sheet->setCellValue('C'.$row, $fields['C']);
	$sheet->getColumnDimension('C')->setAutoSize(true);
	
	$col = 3;
	foreach($fields['D'] as $k=>$v){
		$abc = getNameFromNumber($col);
		$sheet->getStyle($abc)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getColumnDimension($abc)->setWidth('5');
		$sheet->setCellValue($abc.$row, $v);
		$sheet->setCellValue($abc.($row+1), $k);
		//$sheet->getStyle($abc.($row+1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		//$sheet->getStyle($abc.$row)->applyFromArray($allBorders);
		//$sheet->getColumnDimension($abc.$row)->setAutoSize(true);
		$col++;
	}
	$sheet->getStyle('A3:'.$abc.'4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFccffcc');
	$sheet->getStyle('A3:'.$abc.'4')->applyFromArray($allBorders);

	
	$row = 5;
	$col = 0;
	foreach($plans as $key=>$val){
		foreach($val as $k=>$v){
			$abc = getNameFromNumber($col);
			$sheet->setCellValue($abc.$row, $v);
			//$sheet->setCellValue($abc.($row+1), $k);
			if($col > 2){
				//$sheet->getStyle($abc.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
				//$sheet->getColumnDimension($abc.$row)->setWidth(10);
			}
			//$sheet->getStyle($abc.($row+1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			//$sheet->getStyle($k.'1')->applyFromArray($allBorders);
			//$sheet->getColumnDimension($k)->setAutoSize(true);
			$col++;
		}
		$col = 0;
		$row++;
	}
	
	
	
	//var_dump($plans); //exit;
	
	
	
	ob_end_clean();
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$cid.'_Shiftplan_'.$cur_month.'.xlsx"');
	header('Cache-Control: max-age=0');
	
	$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
	$writer->save('php://output');
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
