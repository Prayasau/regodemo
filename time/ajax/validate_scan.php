<?

	if(session_id()==''){session_start();}
	ob_start();
	include('../../dbconnect/db_connect.php');
	include(DIR.'time/functions.php');
	//var_dump($_REQUEST); exit;
	$employees = getEmployeesBySID($cid);
	//var_dump($employees); exit;
	
	$file = array();
	$sql = "SELECT scansystem,filename,period, content FROM ".$cid."_scanfiles WHERE id = '".$_REQUEST['id']."'";
	if($res = $dbc->query($sql)){
		if($row = $res->fetch_assoc()){
			$file = unserialize($row['content']);
			$period = $row['period'];
			$filename = $row['filename'];
			$scansystem = $row['scansystem'];
		}
	}

	//$scansystem contains WELADEE or REGOXLS
	
	if($scansystem == 'WELADEE')
	{
		$data = array();

		foreach($file as $key=>$val){
			$nr = 1;

			
			foreach($val['time'] as $k=>$v){
				//$sid = substr($val['id'], -3);
				$date = date('Y-m-d', strtotime($k));
				$month = date('n', strtotime($date));
				$day = date('D', strtotime($date));
				$dnr = date('w', strtotime($date));

				$sid = $key;
				$emp_id = $val['id'];
				$tmp = getShiftPlan($emp_id, date('n', strtotime($k)),  date('j', strtotime($k)));
				if($tmp != 'not found'){
					$splan = $tmp['plan'];
				}
				$time = explode('|',$v);
				$sc = 1;
				foreach($time as $sk=>$sv){
					$id = $emp_id.'_'.strtotime($k);
					$data[$id]['id'] = $id;
					$data[$id]['emp_id'] = $emp_id;
					$data[$id]['date'] = $date;
					$data[$id]['month'] = $month;
					$data[$id]['day'] = $day;
					$data[$id]['dnr'] = $dnr;
					$data[$id]['shiftteam'] = $employees[$sid]['shiftplan'];
					$data[$id]['scan'.$sc] = $sv;
					$sc++;	
				}
				while($sc <= 9){
					$data[$id]['scan'.$sc] = '-';
					$sc++;
				}
				$data[$id]['all_scans'] = $v;

				$nr++;
			}
		}


		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';

		// die();
		$sql = "INSERT INTO ".$cid."_attendance (id, emp_id, date, month, day, dnr, shiftteam, scan1, scan2, scan3, scan4, scan5, scan6, scan7, scan8, scan9, all_scans) VALUES (";
		foreach($data as $key=>$val){
			foreach($val as $k=>$v){
				$sql .= "'".$dbc->real_escape_string($v)."',";
			}
			$sql = substr($sql,0,-1);
			$sql .= '),(';
		}
		$sql = substr($sql,0,-2);
		$sql .= " ON DUPLICATE KEY UPDATE 
			scan1 = VALUES(scan1),
			scan2 = VALUES(scan2),
			scan3 = VALUES(scan3),
			scan4 = VALUES(scan4),
			scan5 = VALUES(scan5),
			scan6 = VALUES(scan6),
			scan7 = VALUES(scan7),
			scan8 = VALUES(scan8),
			scan9 = VALUES(scan9),
			all_scans = VALUES(all_scans)";

		// Update checkbox value in scan data 

		if($res = $dbc->query($sql)){

			// Insert into metascandata table to display on adding the data 

				// Delete the old entries and insert the overwrite 

				$sql1 = "SELECT * FROM ".$cid."_scandata WHERE filename = '".$filename."' AND checkbox = '1'";
				if($res1 = $dbc->query($sql1))
				{
					while($row1 = $res1->fetch_assoc())
					{

						// check is row already exist with the id - row[id]

						$sql3 = "SELECT * FROM ".$cid."_metascandata WHERE scandata_id = '".$row1['id']."' order by id ASC";
						if($res3 = $dbc->query($sql3))
						{
								
							if($row3 = $res3->fetch_assoc())
							{
								$deleteSql1 =  "DELETE FROM ".$cid."_metascandata WHERE scandata_id = '".$row1['id']."'";
								$res11 = $dbc->query($deleteSql1);

								$currentMonth1 = date('n'); // numberic value 
								$todayDateArr1 = $row1['datescan'];


								$dateArr1= explode('-', $todayDateArr1);
								$todayDate1 = $dateArr1['2'];
								$currentYear1 = $dateArr1['0'];


								$todayDateArr2 = date('Y-m-d');
								$dateArr2= explode('-', $todayDateArr2);
								$currentYear2 = $dateArr2['0'];


								$dayArray = array(

									'1' => '1',
									'2' => '2',
									'3' => '3',
									'4' => '4',
									'5' => '5',
									'6' => '6',
									'7' => '7',
									'8' => '8',
									'9' => '9',
									'10' => '10',
									'11' => '11',
									'12' => '12',
									'13' => '13',
									'14' => '14',
									'15' => '15',
									'16' => '16',
									'17' => '17',
									'18' => '18',
									'19' => '19',
									'20' => '20',
									'21' => '21',
									'22' => '22',
									'23' => '23',
									'24' => '24',
									'25' => '25',
									'26' => '26',
									'27' => '27',
									'28' => '28',
									'29' => '29',
									'30' => '30',
									'31' => '31',


								); 

								$sql7 = "SELECT * from  ".$cid."_monthly_shiftplans_".$currentYear2." WHERE month = '".$currentMonth1."' AND sid= '".$row1['scan_id']."'";

								$res7 = $dbc->query($sql7);

								if ($res7->num_rows > 0) 
								{
									if($res7 = $res7->fetch_assoc())
										{
											if (in_array($todayDate1, $dayArray)) 
											{
												$planValue =  $res7['D'.$todayDate1];

											}

										}
								}


								$sql2 = "INSERT INTO ".$cid."_metascandata (datescan, emp_name,scan_in, scan_out,filename, status,scandata_id,timescan,datescanout,scan_id,emp_id,shift_plan_value,linkedPlan,in_or_out) VALUES ";
								$sql2 .= "('".$dbc->real_escape_string($row1['datescan'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['emp_name'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['scan_in'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['scan_out'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['filename'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['status'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['id'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['scan_in'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['datescanout'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['scan_id'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['emp_id'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($planValue)."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['linkedPlan'])."', ";

								if($row1['scan_in'] == 'No')
								{
									$sql2 .= "'".$dbc->real_escape_string('no')."')";
								}
								else
								{	
									$sql2 .= "'".$dbc->real_escape_string('in')."')";

								}

								$res2 = $dbc->query($sql2);


								$sql4 = "INSERT INTO ".$cid."_metascandata (datescan, emp_name,scan_in, scan_out,filename, status,scandata_id,timescan,scan_id,emp_id,shift_plan_value,linkedPlan,in_or_out) VALUES ";
								$sql4 .= "('".$dbc->real_escape_string($row1['datescanout'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['emp_name'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['scan_in'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['scan_out'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['filename'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['status'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['id'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['scan_out'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['scan_id'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['emp_id'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($planValue)."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['linkedPlan'])."', ";
								
								if($row1['scan_out'] == 'No')
								{
									$sql4 .= "'".$dbc->real_escape_string('no')."')";


								}
								else
								{	
									$sql4 .= "'".$dbc->real_escape_string('out')."')";


								}


								$res4 = $dbc->query($sql4);
						
							}
							else
							{
								$currentMonth1 = date('n'); // numberic value 
								$todayDateArr1 = $row1['datescan'];


								$dateArr1= explode('-', $todayDateArr1);
								$todayDate1 = $dateArr1['2'];
								$currentYear1 = $dateArr1['0'];


								$todayDateArr2 = date('Y-m-d');
								$dateArr2= explode('-', $todayDateArr2);
								$currentYear2 = $dateArr2['0'];


								$dayArray = array(

									'1' => '1',
									'2' => '2',
									'3' => '3',
									'4' => '4',
									'5' => '5',
									'6' => '6',
									'7' => '7',
									'8' => '8',
									'9' => '9',
									'10' => '10',
									'11' => '11',
									'12' => '12',
									'13' => '13',
									'14' => '14',
									'15' => '15',
									'16' => '16',
									'17' => '17',
									'18' => '18',
									'19' => '19',
									'20' => '20',
									'21' => '21',
									'22' => '22',
									'23' => '23',
									'24' => '24',
									'25' => '25',
									'26' => '26',
									'27' => '27',
									'28' => '28',
									'29' => '29',
									'30' => '30',
									'31' => '31',


								); 

								$sql7 = "SELECT * from  ".$cid."_monthly_shiftplans_".$currentYear2." WHERE month = '".$currentMonth1."' AND sid= '".$row1['scan_id']."'";

								$res7 = $dbc->query($sql7);

								if ($res7->num_rows > 0) 
								{
									if($res7 = $res7->fetch_assoc())
										{
											if (in_array($todayDate1, $dayArray)) 
											{
												$planValue =  $res7['D'.$todayDate1];

											}

										}
								}


								$sql2 = "INSERT INTO ".$cid."_metascandata (datescan, emp_name,scan_in, scan_out,filename, status,scandata_id,timescan,datescanout,scan_id,emp_id,shift_plan_value,linkedPlan,in_or_out) VALUES ";
								$sql2 .= "('".$dbc->real_escape_string($row1['datescan'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['emp_name'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['scan_in'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['scan_out'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['filename'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['status'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['id'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['scan_in'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['datescanout'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['scan_id'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['emp_id'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($planValue)."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['linkedPlan'])."', ";
								

								if($row1['scan_in'] == 'No')
								{
									$sql2 .= "'".$dbc->real_escape_string('no')."')";
								}
								else
								{	
									$sql2 .= "'".$dbc->real_escape_string('in')."')";

								}


								$res2 = $dbc->query($sql2);

								$sql4 = "INSERT INTO ".$cid."_metascandata (datescan, emp_name,scan_in, scan_out,filename, status,scandata_id,timescan,scan_id,emp_id,shift_plan_value,linkedPlan,in_or_out) VALUES ";
								$sql4 .= "('".$dbc->real_escape_string($row1['datescanout'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['emp_name'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['scan_in'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['scan_out'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['filename'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['status'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['id'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['scan_out'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['scan_id'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['emp_id'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($planValue)."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['linkedPlan'])."', ";


								if($row1['scan_out'] == 'No')
								{
									$sql4 .= "'".$dbc->real_escape_string('no')."')";


								}
								else
								{	
									$sql4 .= "'".$dbc->real_escape_string('out')."')";


								}

								$res4 = $dbc->query($sql4);
							}
						}

					}
				}


			$dbc->query("UPDATE ".$cid."_scanfiles SET status = 1 WHERE id = '".$_REQUEST['id']."'");
			ob_clean();
			echo 'success';
		}
		else
		{
			echo mysqli_error($dbc);
		}	



	}
	else if($scansystem == 'REGOXLS')
	{

		$data = array();

		// echo '<pre>';
		// print_r($file);
		// echo '<pre>';
		// die();

		foreach($file as $key=>$val){
			$nr = 1;

			if($val['statusVal'] == '1')
			{
				foreach($val['time'] as $k=>$v){
					
					//$sid = substr($val['id'], -3);
					$date = date('Y-m-d', strtotime($k));
					$month = date('n', strtotime($date));
					$day = date('D', strtotime($date));
					$dnr = date('w', strtotime($date));

					$sid = $key;
					$emp_id = $val['id']; // EMPLOYEE ID 
					$shiftplanVal = $val['plan']; // SHIFT PLAN
					$shiftTeamVal = $val['shiftteam']; // SHIFT TEAM
					$en_name 	  = $val['en_name'];
					$th_name 	  = $val['th_name'];
					$planned_hrs 	  = $val['planned_hrs'];
					$filenameVal 	  = $val['filename'];

					$tmp = getShiftPlan($emp_id, date('n', strtotime($k)),  date('j', strtotime($k)));
					if($tmp != 'not found'){
						$splan = $tmp['plan'];
					}
					$time = explode('|',$v);
					$sc = 1;
					foreach($time as $sk=>$sv){

						$id = $emp_id.'_'.strtotime($k);
						$data[$id]['id'] = $id;
						$data[$id]['emp_id'] = $emp_id;
						$data[$id]['date'] = $date;
						$data[$id]['month'] = $month;
						$data[$id]['day'] = $day;
						$data[$id]['dnr'] = $dnr;
						$data[$id]['shiftteam'] = $shiftTeamVal;
						$data[$id]['plan'] = $shiftplanVal;
						$data[$id]['en_name'] = $en_name;
						$data[$id]['th_name'] = $th_name;
						$data[$id]['planned_hrs'] = $planned_hrs;
						$data[$id]['filename'] = $filenameVal;
						// $data[$id]['filename'] = $filenameVal; //scan data id
						// $data[$id]['shiftteam'] = $employees[$sid]['shiftplan'];
						$data[$id]['scan'.$sc] = $sv;
						$sc++;	
					}
					while($sc <= 9){
						$data[$id]['scan'.$sc] = '-';
						$sc++;
					}
					$data[$id]['all_scans'] = $v;

					$data[$id]['plan_hrs'] = $shiftplanVal.'|'.$v;

					$nr++;

				}
			}
		}

	

		// check valid rows 

		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';

		// die();


		$sql = "INSERT INTO ".$cid."_attendance (id, emp_id, date, month, day, dnr, shiftteam, plan, en_name, th_name, planned_hrs,filename,  scan1, scan2, scan3, scan4, scan5, scan6, scan7, scan8, scan9, all_scans, plan_hrs) VALUES (";
		foreach($data as $key=>$val)
		{
			

			foreach($val as $k=>$v)
			{
				$sql .= "'".$dbc->real_escape_string($v)."',";
			}
			$sql = substr($sql,0,-1);
			$sql .= '),(';
		}
		$sql = substr($sql,0,-2);
		$sql .= " ON DUPLICATE KEY UPDATE 
			scan1 = VALUES(scan1),
			scan2 = VALUES(scan2),
			scan3 = VALUES(scan3),
			scan4 = VALUES(scan4),
			scan5 = VALUES(scan5),
			scan6 = VALUES(scan6),
			scan7 = VALUES(scan7),
			scan8 = VALUES(scan8),
			scan9 = VALUES(scan9),
			all_scans = VALUES(all_scans),
			plan_hrs = VALUES(plan_hrs)";

		// Update checkbox value in scan data 

		if($res = $dbc->query($sql)){

			// Insert into metascandata table to display on adding the data 

				// Delete the old entries and insert the overwrite 

				$sql1 = "SELECT * FROM ".$cid."_scandata WHERE filename = '".$filename."' AND checkbox = '1'";
				if($res1 = $dbc->query($sql1))
				{
					while($row1 = $res1->fetch_assoc())
					{
						// check is row already exist with the id - row[id]

						$sql3 = "SELECT * FROM ".$cid."_metascandata WHERE scandata_id = '".$row1['id']."' order by id ASC";
						if($res3 = $dbc->query($sql3))
						{
								
							if($row3 = $res3->fetch_assoc())
							{
								$deleteSql1 =  "DELETE FROM ".$cid."_metascandata WHERE scandata_id = '".$row1['id']."'";
								$res11 = $dbc->query($deleteSql1);

								$currentMonth1 = date('n'); // numberic value 
								$todayDateArr1 = $row1['datescan'];


								$dateArr1= explode('-', $todayDateArr1);
								$todayDate1 = $dateArr1['2'];
								$currentYear1 = $dateArr1['0'];


								$todayDateArr2 = date('Y-m-d');
								$dateArr2= explode('-', $todayDateArr2);
								$currentYear2 = $dateArr2['0'];


								$dayArray = array(

									'1' => '1',
									'2' => '2',
									'3' => '3',
									'4' => '4',
									'5' => '5',
									'6' => '6',
									'7' => '7',
									'8' => '8',
									'9' => '9',
									'10' => '10',
									'11' => '11',
									'12' => '12',
									'13' => '13',
									'14' => '14',
									'15' => '15',
									'16' => '16',
									'17' => '17',
									'18' => '18',
									'19' => '19',
									'20' => '20',
									'21' => '21',
									'22' => '22',
									'23' => '23',
									'24' => '24',
									'25' => '25',
									'26' => '26',
									'27' => '27',
									'28' => '28',
									'29' => '29',
									'30' => '30',
									'31' => '31',


								); 

								$sql7 = "SELECT * from  ".$cid."_monthly_shiftplans_".$currentYear2." WHERE month = '".$currentMonth1."' AND sid= '".$row1['scan_id']."'";

								$res7 = $dbc->query($sql7);

								if ($res7->num_rows > 0) 
								{
									if($res7 = $res7->fetch_assoc())
										{
											if (in_array($todayDate1, $dayArray)) 
											{
												$planValue =  $res7['D'.$todayDate1]; 

											}

										}
								}

								// SHIFT PLAN KEY - EMPLOYEE ID AND PLAN DATE AND TIME	

								$empID = $row1['emp_id'];
								$dateScan = $row1['datescan'];
								$ScanIN = $row1['scan_in'];
								$ScanOut = $row1['scan_out'];
								
								$planValues =  $empID.'/'.$dateScan.'/'.$ScanIN;
								$planValues2 =  $empID.'/'.$dateScan.'/'.$ScanOut;



								// shiftplan key only if shift plan is created 



								$sql2 = "INSERT INTO ".$cid."_metascandata (datescan, emp_name,scan_in, scan_out,filename, status,scandata_id,timescan,datescanout,scan_id,emp_id,shift_plan_value,linkedPlan,in_or_out) VALUES ";
								$sql2 .= "('".$dbc->real_escape_string($row1['datescan'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['emp_name'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['scan_in'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['scan_out'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['filename'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['status'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['id'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['scan_in'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['datescanout'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['scan_id'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['emp_id'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($planValues)."', ";
								$sql2 .= "'".$dbc->real_escape_string($row['linkedPlan'])."', ";

								if($row1['scan_in'] == 'No')
								{
									$sql2 .= "'".$dbc->real_escape_string('no')."')";
								}
								else
								{	
									$sql2 .= "'".$dbc->real_escape_string('in')."')";

								}

								$res2 = $dbc->query($sql2);


								$sql4 = "INSERT INTO ".$cid."_metascandata (datescan, emp_name,scan_in, scan_out,filename, status,scandata_id,timescan,scan_id,emp_id,shift_plan_value,linkedPlan,in_or_out) VALUES ";
								$sql4 .= "('".$dbc->real_escape_string($row1['datescanout'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['emp_name'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['scan_in'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['scan_out'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['filename'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['status'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['id'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['scan_out'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['scan_id'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['emp_id'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($planValues2)."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['linkedPlan'])."', ";
								
								if($row1['scan_out'] == 'No')
								{
									$sql4 .= "'".$dbc->real_escape_string('no')."')";


								}
								else
								{	
									$sql4 .= "'".$dbc->real_escape_string('out')."')";


								}


								$res4 = $dbc->query($sql4);
						
							}
							else
							{
								$currentMonth1 = date('n'); // numberic value 
								$todayDateArr1 = $row1['datescan'];


								$dateArr1= explode('-', $todayDateArr1);
								$todayDate1 = $dateArr1['2'];
								$currentYear1 = $dateArr1['0'];


								$todayDateArr2 = date('Y-m-d');
								$dateArr2= explode('-', $todayDateArr2);
								$currentYear2 = $dateArr2['0'];


								$dayArray = array(

									'1' => '1',
									'2' => '2',
									'3' => '3',
									'4' => '4',
									'5' => '5',
									'6' => '6',
									'7' => '7',
									'8' => '8',
									'9' => '9',
									'10' => '10',
									'11' => '11',
									'12' => '12',
									'13' => '13',
									'14' => '14',
									'15' => '15',
									'16' => '16',
									'17' => '17',
									'18' => '18',
									'19' => '19',
									'20' => '20',
									'21' => '21',
									'22' => '22',
									'23' => '23',
									'24' => '24',
									'25' => '25',
									'26' => '26',
									'27' => '27',
									'28' => '28',
									'29' => '29',
									'30' => '30',
									'31' => '31',


								); 

								$sql7 = "SELECT * from  ".$cid."_monthly_shiftplans_".$currentYear2." WHERE month = '".$currentMonth1."' AND sid= '".$row1['scan_id']."'";

								$res7 = $dbc->query($sql7);

								if ($res7->num_rows > 0) 
								{
									if($res7 = $res7->fetch_assoc())
										{
											if (in_array($todayDate1, $dayArray)) 
											{
												$planValue =  $res7['D'.$todayDate1];

											}

										}
								}

								// SHIFT PLAN KEY - EMPLOYEE ID AND PLAN DATE AND TIME	
								$empID = $row1['emp_id'];
								$dateScan = $row1['datescan'];
								$ScanIN = $row1['scan_in'];
								$ScanOut = $row1['scan_out'];
								
								$planValues =  $empID.'/'.$dateScan.'/'.$ScanIN;
								$planValues2 =  $empID.'/'.$dateScan.'/'.$ScanOut;


								$sql2 = "INSERT INTO ".$cid."_metascandata (datescan, emp_name,scan_in, scan_out,filename, status,scandata_id,timescan,datescanout,scan_id,emp_id,shift_plan_value,linkedPlan,in_or_out) VALUES ";
								$sql2 .= "('".$dbc->real_escape_string($row1['datescan'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['emp_name'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['scan_in'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['scan_out'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['filename'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['status'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['id'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['scan_in'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['datescanout'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['scan_id'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['emp_id'])."', ";
								$sql2 .= "'".$dbc->real_escape_string($planValues)."', ";
								$sql2 .= "'".$dbc->real_escape_string($row1['linkedPlan'])."', ";
								

								if($row1['scan_in'] == 'No')
								{
									$sql2 .= "'".$dbc->real_escape_string('no')."')";
								}
								else
								{	
									$sql2 .= "'".$dbc->real_escape_string('in')."')";

								}


								$res2 = $dbc->query($sql2);

								$sql4 = "INSERT INTO ".$cid."_metascandata (datescan, emp_name,scan_in, scan_out,filename, status,scandata_id,timescan,scan_id,emp_id,shift_plan_value,linkedPlan,in_or_out) VALUES ";
								$sql4 .= "('".$dbc->real_escape_string($row1['datescanout'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['emp_name'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['scan_in'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['scan_out'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['filename'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['status'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['id'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['scan_out'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['scan_id'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['emp_id'])."', ";
								$sql4 .= "'".$dbc->real_escape_string($planValues2)."', ";
								$sql4 .= "'".$dbc->real_escape_string($row1['linkedPlan'])."', ";


								if($row1['scan_out'] == 'No')
								{
									$sql4 .= "'".$dbc->real_escape_string('no')."')";


								}
								else
								{	
									$sql4 .= "'".$dbc->real_escape_string('out')."')";


								}

								$res4 = $dbc->query($sql4);
							}
						}

					}
				}

			$dbc->query("UPDATE ".$cid."_scanfiles SET status = 1 WHERE id = '".$_REQUEST['id']."'");
			ob_clean();
			echo 'success';
		}
		else
		{
			echo mysqli_error($dbc);
		}

	}
	