<?

	if(session_id()==''){session_start();}
	ob_start();
	include('../../../dbconnect/db_connect.php');
	//var_dump($_REQUEST); exit;



	// $_REQUEST['clock'];


	$th_name = '';
	$en_name = '';
	$team = '';
	$clock_in = '';
	$sql = "SELECT th_name, en_name, shiftplan,teams,sid FROM ".$cid."_employees WHERE emp_id = '".$_REQUEST['emp_id']."'";
	if($res = $dbc->query($sql)){
		if($row = $res->fetch_assoc()){
			$th_name = $row['th_name'];
			$en_name = $row['en_name'];
			$team = $row['shiftplan'];
			$teams = $row['teams'];
			$scan_id = $row['sid'];
		}
	}

	
	//$_REQUEST['date'] = '22-10-2020';	$_REQUEST['time'] = '21:50';
	//$_REQUEST['date'] = '24-10-2020';	$_REQUEST['time'] = '06:15'; //$clock_in = '20-10-2020 21:50';

	$_REQUEST['scan'] = substr($_REQUEST['time'],0,5);//.' '.$_REQUEST['time'];
	
	//var_dump($_REQUEST['clock']); //exit;
	//var_dump($clock_in); //exit;
	//var_dump($_REQUEST); //exit;
	
	if($_REQUEST['clock'] == 'out' && !empty($clock_in)){
		//if(date('d-m-Y', strtotime($_REQUEST['date'])) != date('d-m-Y', strtotime($clock_in))){
		if((strtotime($_REQUEST['date']) - strtotime(date('d-m-Y', strtotime($clock_in)))) <= 86400){
			/*$time1 = date('H:i', strtotime($clock_in));
			$time2 = date('H:i', strtotime($_REQUEST['time']));
			if($time2 < $time1){
				$_REQUEST['date'] = date('d-m-Y', strtotime($clock_in));
			}*/
			$_REQUEST['date'] = date('d-m-Y', strtotime($clock_in));
		}else{
			$d = strtotime($_REQUEST['scan']) - 43200;
			//var_dump(date('d-m-Y', $d));
			$_REQUEST['date'] = date('d-m-Y', $d);
		}
	}
	
	//var_dump($_REQUEST); exit;
	
	$data = array();
	$time = substr($_REQUEST['time'],0,5);
	$all_scans = '';
	$id = $_REQUEST['emp_id'].'_'.strtotime($_REQUEST['date']);
	
	if($res = $dbc->query("SELECT id FROM ".$cid."_attendance WHERE id = '$id'")){
		if($res->num_rows == 0){
			//var_dump($res->num_rows);
			$date = date('Y-m-d', strtotime($_REQUEST['date']));
			$month = date('n', strtotime($date));
			$day = date('D', strtotime($date));
			$dnr = date('w', strtotime($date));
			$dbc->query("INSERT INTO ".$cid."_attendance (id, month, emp_id, th_name, en_name, date, day, dnr, shiftteam) VALUES ('".$id."', '".$month."', '".$_REQUEST['emp_id']."', '".$th_name."', '".$en_name."', '".$date."', '".$day."', '".$dnr."', '".$teams."')");
		}
	}
	
	if($res = $dbc->query("SELECT * FROM ".$cid."_attendance WHERE id = '$id'")){
		if($row = $res->fetch_assoc()){
			$data[1] = $row['scan1'];
			$data[] = $row['scan2'];
			$data[] = $row['scan3'];
			$data[] = $row['scan4'];
			$data[] = $row['scan5'];
			$data[] = $row['scan6'];
			$data[] = $row['scan7'];
			$data[] = $row['scan8'];
			$data[] = $row['scan9'];
			$all_scans = $row['all_scans'];
		}
	}else{
		echo mysqli_error($dbc);
	}
	
	foreach($data as $k=>$v){
		if(strlen($v) < 3){
			$data[$k] = $time;
			if(!empty($all_scans)){$all_scans .= '|';}
			$all_scans .= $time;
			$sql = "UPDATE ".$cid."_attendance SET scan".$k." =  '".$_REQUEST['scan']."', all_scans = '".$all_scans."', loc".$k." = '".$dbc->real_escape_string($_REQUEST['location'].'-'.strtoupper($_REQUEST['clock']))."' WHERE id = '$id'";
			if($dbc->query($sql)){
				$result['date'] = $_REQUEST['date'].' @ '.$_REQUEST['time'];
				$result['success'] = 'success';
				$result['id'] = $id;
				$result['img'] = 'img'.$k;
				if($_REQUEST['clock'] == 'in'){
					$dbc->query("UPDATE ".$cid."_employees SET clock_in = '".$dbc->real_escape_string($_REQUEST['date'].' '.$_REQUEST['time'])."' WHERE emp_id = '".$_REQUEST['emp_id']."'");
				}
				//var_dump($result); exit;
				
				//echo 'img'.$k;
			}else{
				//ob_clean();
				echo mysqli_error($dbc);
			}
			break;
		}
	}



	// INSERT CLOCK IN DATA INTO SCANDATA 
	

	// if($_REQUEST['clock'] == 'in')
	// {
	// 	// insert into scan data and metascandata for scan in 

	// 	$dateScanVal = date('Y-m-d', strtotime($_REQUEST['date']));

	// 	$sid = $scan_id;
	// 	$statusVal = '1';	


	// 	$sql6 = "SELECT * FROM ".$cid."_scandata WHERE emp_id = '".$_REQUEST['emp_id']."' AND datescan = '".$dateScanVal."' ";
	// 	if($res6 = $dbc->query($sql6)){
	// 		if($row6 = $res6->fetch_assoc()){
	// 			// update in scandata
	// 			$time = $_REQUEST['time'] ;
	// 			$all_scans_val = $row6['all_scan_values'].'-'.$time;

	// 			$sql7 = "UPDATE ".$cid."_scandata SET all_scan_values = '".$all_scans_val ."'  WHERE id = '".$row6['id']."'";
	// 			$res7 = $dbc->query($sql7);


	// 		}
	// 		else
	// 		{
	// 			// insert in scandata

	// 			$sql1 = "INSERT INTO ".$cid."_scandata (datescan, emp_name,scan_in,status,scan_id,emp_id,all_scan_values) VALUES ";
	// 			$sql1 .= "('".$dbc->real_escape_string($dateScanVal)."', ";
	// 			$sql1 .= "'".$dbc->real_escape_string($en_name)."', ";
	// 			$sql1 .= "'".$dbc->real_escape_string($_REQUEST['time'])."', ";
	// 			$sql1 .= "'".$dbc->real_escape_string($statusVal)."', ";
	// 			$sql1 .= "'".$dbc->real_escape_string($sid)."', ";
	// 			$sql1 .= "'".$dbc->real_escape_string($_REQUEST['emp_id'])."', ";
	// 			$sql1 .= "'".$dbc->real_escape_string($_REQUEST['time'])."') ";

	// 			$res1 = $dbc->query($sql1);


	// 			$sql5 = "SELECT * FROM ".$cid."_scandata WHERE emp_id = '".$_REQUEST['emp_id']."' AND datescan = '".$dateScanVal."' ";
	// 			if($res5 = $dbc->query($sql5)){
	// 				if($row5 = $res5->fetch_assoc()){

	// 					$shift_plan_values  =  $row5['emp_id'].'/'.$row5['datescan'].'/'.$row5['scan_in'];
	// 					$status_value = '1';
	// 					$in_or_out_status  = 'in';

	// 					$sql4 = "INSERT INTO ".$cid."_metascandata (datescan,datescanout,timescan,emp_id,emp_name,shift_plan_value,scan_in,status,scan_id,scandata_id,in_or_out) VALUES ";
	// 					$sql4 .= "('".$dbc->real_escape_string($row5['datescan'])."', ";
	// 					$sql4 .= "'".$dbc->real_escape_string($row5['datescanout'])."', ";
	// 					$sql4 .= "'".$dbc->real_escape_string($row5['scan_in'])."', ";
	// 					$sql4 .= "'".$dbc->real_escape_string($row5['emp_id'])."', ";
	// 					$sql4 .= "'".$dbc->real_escape_string($row5['emp_name'])."', ";
	// 					$sql4 .= "'".$dbc->real_escape_string($shift_plan_values)."', ";
	// 					$sql4 .= "'".$dbc->real_escape_string($row5['scan_in'])."', ";
	// 					$sql4 .= "'".$dbc->real_escape_string($status_value)."', ";
	// 					$sql4 .= "'".$dbc->real_escape_string($row5['scan_id'])."', ";
	// 					$sql4 .= "'".$dbc->real_escape_string($row5['id'])."', ";
	// 					$sql4 .= "'".$dbc->real_escape_string($in_or_out_status)."') ";

	// 					$res4 = $dbc->query($sql4);
	// 				}
	// 			}

	// 		}

	// 	}

	// }	


	// if($_REQUEST['clock'] == 'out')
	// {
	// 	// update scan data and insert into metascandata for scan out 

	// 	$dateScanVal = date('Y-m-d', strtotime($_REQUEST['date']));

	// 	$sql2 = "SELECT * FROM ".$cid."_scandata WHERE emp_id = '".$_REQUEST['emp_id']."' AND datescan = '".$dateScanVal."' ";
	// 	if($res2 = $dbc->query($sql2))
	// 	{
	// 		if($row2 = $res2->fetch_assoc())
	// 		{
	// 			$time = $_REQUEST['time'] ;
	// 			$all_scans_val1 = $row2['all_scan_values'].'-'.$time;


	// 			// if scan out is present dont update again 

	// 			if($row2['scan_out'] == '')
	// 			{
	// 				$sql3 = "UPDATE ".$cid."_scandata SET scan_out= '".$_REQUEST['time']."' , datescanout = '".$dateScanVal."' , all_scan_values = '".$all_scans_val1."' WHERE id = '".$row2['id']."'";
	// 				$res3 = $dbc->query($sql3);
	// 			}
				


	// 			// if($row2['scan_out'] != '')
	// 			// {
	// 				$shift_plan_values  =  $row2['emp_id'].'/'.$dateScanVal.'/'.$_REQUEST['time'];
	// 				$status_value = '1';
	// 				$in_or_out_status  = 'out';


	// 				// check if scan out already exists in metascandata 

	// 				$sql9 = "SELECT * FROM ".$cid."_metascandata WHERE emp_id = '".$_REQUEST['emp_id']."' AND datescan = '".$dateScanVal."' AND in_or_out = 'out' ";

	// 				if($res9 = $dbc->query($sql9))
	// 				{
	// 					if($row9 = $res9->fetch_assoc())
	// 					{
	// 					}
	// 					else
	// 					{

	// 						$sql8 = "INSERT INTO ".$cid."_metascandata (datescan,datescanout,timescan,emp_id,emp_name,shift_plan_value,scan_in,scan_out,status,scan_id,scandata_id,in_or_out) VALUES ";
	// 						$sql8 .= "('".$dbc->real_escape_string($row2['datescan'])."', ";
	// 						$sql8 .= "'".$dbc->real_escape_string($dateScanVal)."', ";
	// 						$sql8 .= "'".$dbc->real_escape_string($_REQUEST['time'])."', ";
	// 						$sql8 .= "'".$dbc->real_escape_string($row2['emp_id'])."', ";
	// 						$sql8 .= "'".$dbc->real_escape_string($row2['emp_name'])."', ";
	// 						$sql8 .= "'".$dbc->real_escape_string($shift_plan_values)."', ";
	// 						$sql8 .= "'".$dbc->real_escape_string($row2['scan_in'])."', ";
	// 						$sql8 .= "'".$dbc->real_escape_string($_REQUEST['time'])."', ";
	// 						$sql8 .= "'".$dbc->real_escape_string($status_value)."', ";
	// 						$sql8 .= "'".$dbc->real_escape_string($row2['scan_id'])."', ";
	// 						$sql8 .= "'".$dbc->real_escape_string($row2['id'])."', ";
	// 						$sql8 .= "'".$dbc->real_escape_string($in_or_out_status)."') ";

	// 						// update the scan in for the same id 


	// 						$res8 = $dbc->query($sql8);


	// 						$sql10 = "UPDATE ".$cid."_metascandata SET scan_out= '".$_REQUEST['time']."' , datescanout = '".$dateScanVal."'  WHERE  emp_id = '".$_REQUEST['emp_id']."' AND datescan = '".$dateScanVal."' AND in_or_out = 'in'";
	// 						$res10 = $dbc->query($sql10);
	// 					}
	// 				}

	// 			// }
	// 		}
	// 	}
	// }


	if($_REQUEST['clock'] == 'in')
	{
		$dateScanVal = date('Y-m-d', strtotime($_REQUEST['date']));

		$sid = $scan_id;
		$statusVal = '1';	

		$sql1 = "INSERT INTO ".$cid."_scandata (datescan, emp_name,scan_in,status,scan_id,emp_id,all_scan_values) VALUES ";
		$sql1 .= "('".$dbc->real_escape_string($dateScanVal)."', ";
		$sql1 .= "'".$dbc->real_escape_string($en_name)."', ";
		$sql1 .= "'".$dbc->real_escape_string($_REQUEST['time'])."', ";
		$sql1 .= "'".$dbc->real_escape_string($statusVal)."', ";
		$sql1 .= "'".$dbc->real_escape_string($sid)."', ";
		$sql1 .= "'".$dbc->real_escape_string($_REQUEST['emp_id'])."', ";
		$sql1 .= "'".$dbc->real_escape_string($_REQUEST['time'])."') ";

		$res1 = $dbc->query($sql1);


		$lastinsertidin = $dbc->insert_id;

		$sql5 = "SELECT * FROM ".$cid."_scandata WHERE id= '".$lastinsertidin."' ";
		if($res5 = $dbc->query($sql5)){
			if($row5 = $res5->fetch_assoc()){

				$shift_plan_values  =  $row5['emp_id'].'/'.$row5['datescan'].'/'.$row5['scan_in'];
				$status_value = '1';
				$in_or_out_status  = 'in';

				$sql4 = "INSERT INTO ".$cid."_metascandata (datescan,datescanout,timescan,emp_id,emp_name,shift_plan_value,scan_in,status,scan_id,scandata_id,in_or_out) VALUES ";
				$sql4 .= "('".$dbc->real_escape_string($row5['datescan'])."', ";
				$sql4 .= "'".$dbc->real_escape_string($row5['datescanout'])."', ";
				$sql4 .= "'".$dbc->real_escape_string($row5['scan_in'])."', ";
				$sql4 .= "'".$dbc->real_escape_string($row5['emp_id'])."', ";
				$sql4 .= "'".$dbc->real_escape_string($row5['emp_name'])."', ";
				$sql4 .= "'".$dbc->real_escape_string($shift_plan_values)."', ";
				$sql4 .= "'".$dbc->real_escape_string($row5['scan_in'])."', ";
				$sql4 .= "'".$dbc->real_escape_string($status_value)."', ";
				$sql4 .= "'".$dbc->real_escape_string($row5['scan_id'])."', ";
				$sql4 .= "'".$dbc->real_escape_string($row5['id'])."', ";
				$sql4 .= "'".$dbc->real_escape_string($in_or_out_status)."') ";

				$res4 = $dbc->query($sql4);

				$lastinsertMetascan = $dbc->insert_id;
				$result['metascandata'] = $lastinsertMetascan;
			}
		}

	}



	if($_REQUEST['clock'] == 'out')
	{
		$dateScanVal = date('Y-m-d', strtotime($_REQUEST['date']));

		$sid = $scan_id;
		$statusVal = '1';	

		$sql13 = "INSERT INTO ".$cid."_scandata (datescan, emp_name,scan_out,status,scan_id,emp_id,all_scan_values) VALUES ";
		$sql13 .= "('".$dbc->real_escape_string($dateScanVal)."', ";
		$sql13 .= "'".$dbc->real_escape_string($en_name)."', ";
		$sql13 .= "'".$dbc->real_escape_string($_REQUEST['time'])."', ";
		$sql13 .= "'".$dbc->real_escape_string($statusVal)."', ";
		$sql13 .= "'".$dbc->real_escape_string($sid)."', ";
		$sql13 .= "'".$dbc->real_escape_string($_REQUEST['emp_id'])."', ";
		$sql13 .= "'".$dbc->real_escape_string($_REQUEST['time'])."') ";

		$res13 = $dbc->query($sql13);


		$lastinsertidout = $dbc->insert_id;

		$sql14 = "SELECT * FROM ".$cid."_scandata WHERE id= '".$lastinsertidout."' ";
		if($res14 = $dbc->query($sql14)){
			if($row14 = $res14->fetch_assoc()){

				$shift_plan_values  =  $row14['emp_id'].'/'.$row14['datescan'].'/'.$_REQUEST['time'];
				$status_value = '1';
				$in_or_out_status  = 'out';

				$sql15 = "INSERT INTO ".$cid."_metascandata (datescan,datescanout,timescan,emp_id,emp_name,shift_plan_value,scan_out,status,scan_id,scandata_id,in_or_out) VALUES ";
				$sql15 .= "('".$dbc->real_escape_string($row14['datescan'])."', ";
				$sql15 .= "'".$dbc->real_escape_string($row14['datescanout'])."', ";
				$sql15 .= "'".$dbc->real_escape_string($row14['scan_out'])."', ";
				$sql15 .= "'".$dbc->real_escape_string($row14['emp_id'])."', ";
				$sql15 .= "'".$dbc->real_escape_string($row14['emp_name'])."', ";
				$sql15 .= "'".$dbc->real_escape_string($shift_plan_values)."', ";
				$sql15 .= "'".$dbc->real_escape_string($row14['scan_out'])."', ";
				$sql15 .= "'".$dbc->real_escape_string($status_value)."', ";
				$sql15 .= "'".$dbc->real_escape_string($row14['scan_id'])."', ";
				$sql15 .= "'".$dbc->real_escape_string($row14['id'])."', ";
				$sql15 .= "'".$dbc->real_escape_string($in_or_out_status)."') ";

				$res15 = $dbc->query($sql15);
				$lastinsertMetascanout = $dbc->insert_id;
				$result['metascandata'] = $lastinsertMetascanout;


			}
		}

	}



ob_clean();
echo json_encode($result);



