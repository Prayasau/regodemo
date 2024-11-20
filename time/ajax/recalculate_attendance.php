<?php

	if(session_id()==''){session_start(); ob_start();}
	include('../../dbconnect/db_connect.php');
	include(DIR.'time/functions.php');
	//var_dump($_REQUEST); //exit;
	
	$time_settings = getTimeSettings();
	//$var_allow = unserialize($time_settings['var_allow']);
	//var_dump($var_allow);
	
	$accept_late = $time_settings['accept_late'];
	$accept_early = $time_settings['accept_early'];
	$ot_start_after = $time_settings['ot_start_after'];
	$ot_period = $time_settings['ot_period'];
	$ot_roundup = $time_settings['ot_roundup'];
	$fbreak = ($time_settings['fixed_break'] == 'Y') ? true : false;
	

	$data = array();
	//$sql = "SELECT * FROM $dbname WHERE (date BETWEEN '$sdate' AND '$edate') AND status = '0'";
	$sql = "SELECT * FROM ".$cid."_attendance WHERE id = '".$_REQUEST['id']."'";
	if($res = $dbc->query($sql)){
		if($row = $res->fetch_assoc()){
			$data = $row;
			$data['scan1'] = $_REQUEST['scan1'];
			$data['scan2'] = $_REQUEST['scan2'];
			$data['scan3'] = $_REQUEST['scan3'];
			$data['scan4'] = $_REQUEST['scan4'];
		}
	}
	var_dump($data); exit;
	
	$date = $data['date'];
	$holiday = getHolidayFromDate($cid, $date);
	$day = date('D', strtotime($date));
	//var_dump($time_settings['otnd']);
	
	if($day == 'Sat'){
		$ot = unserialize($time_settings['otsa']);
	}elseif($day == 'Sun'){
		$ot = unserialize($time_settings['otsu']);
	}else{
		$ot = $time_settings['otnd'];
	}
	if($holiday){
		$ot = unserialize($time_settings['othd']);
	}


	$late = 0;
	$early = 0;
	$actual_hours = 0;
	$paid_hours = 0;
	$ot1 = 0;
	$ot15 = 0;
	$ot2 = 0;
	$ot3 = 0;
	
	$plan_in = $data['f1'];
	$plan_out = $data['u2'];
	$plan_rh = ltrim($data['plan_rh'],'0');
	$plan_break = $data['plan_break'];

	$start_time = new DateTime($plan_in);
	$end_time = new DateTime($plan_out);
	
	if(isValidDate($data['scan1']) && isValidDate($data['scan4'])){		
		$break_in = new DateTime($data['scan2']);
		$break_out = new DateTime($data['scan3']);
		$actual_break = $break_in->diff($break_out);
		
		list($hours, $minutes) = sscanf($plan_break, '%d:%d');
		$fixed_break = new DateInterval(sprintf('PT%dH%dM', $hours, $minutes));
		
		//var_dump($fixed_break);
		//var_dump($actual_break);

		$time_in = new DateTime($data['scan1']);
		$time_out = new DateTime($data['scan4']);
		$diff = $time_in->diff($time_out);
		
		
		
		$actual_hours = $diff->format('%h:%I'); //------------------- actual hours
		//var_dump($actual_hours);
		$actual_date = new DateTime($actual_hours);
		//var_dump($actual_date);
		if($fbreak){
			$actual_date->sub($fixed_break); // substract breaktime
		}else{
			$actual_date->sub($actual_break); // substract breaktime
		}
		$actual_hours = $actual_date->format('G:i'); //------------------- actual hours

		//var_dump($actual_hours);
		
		//var_dump($actual_date);
	}
	
	if(!empty($data['plan_rh'])){
		if(isValidDate($data['scan1']) && isValidDate($data['scan4'])){	
			$time_in = new DateTime($data['scan1']);
			$time_out = new DateTime($data['scan4']);
			
			if($time_in > $start_time){ //----------------------------- to late
				$tmp = $time_in->diff($start_time);
				$dif = ($tmp->h*60) + $tmp->i;
				if($dif < $accept_late){
					$late = 0;
				}else{
					$late = $tmp->format('%h:%I');
				}
				$stime_in = $time_in;
			}else{ //--------------------------------------------- ok
				$late = 0;
				$stime_in = $start_time;
			}
			if($time_out < $end_time){ //------------------------------ to early
				$tmp = $time_out->diff($end_time);
				$dif = ($tmp->h*60) + $tmp->i;
				if($dif < $accept_early){
					$early = 0;
				}else{
					$early = $tmp->format('%h:%I');
				}
				$stime_out = $time_out;
			}else{ //--------------------------------------------- ok
				$early = 0;
				$stime_out = $end_time;
			}
			
			list($hours, $minutes) = sscanf($plan_break, '%d:%d');
			$break = new DateInterval(sprintf('PT%dH%dM', $hours, $minutes));
			//var_dump($break);
			//$a = new DateTime($data['scan1']);
			//var_dump($a);
			//$a->add($break); // substract breaktime
			//$a->sub(new DateInterval('PT30M')); // substract breaktime
			//var_dump($a);
			//$diff = $a->diff($time_out);
			//var_dump($diff);
			
			$paid_hours = $plan_rh; //----------------------------------- paid hours from shiftplan // if not late and not early
			//var_dump($actual_hours);
			//var_dump($paid_hours);
			
			if($late == '0' && $early == '0'){ //------------------------ not late & not early
				//var_dump('in time');
				//$paid_hours = $plan_rh;//.' - in time';
			}elseif($late != '0' && $early == '0'){ //------------------- late but not early
				//var_dump('late');
				$x = new DateTime($data['scan1']);
				$x->add($break); // substract breaktime
				$diff = $x->diff($stime_out);
				$paid_hours = $diff->format('%h:%I');//.' - late';
			}elseif($late == '0' && $early != '0'){ //------------------- not late and not early
				//var_dump('early');
				$x = new DateTime($plan_in);
				$x->add($break); // substract breaktime
				$diff = $x->diff($time_out);
				$paid_hours = $diff->format('%h:%I');//.' - early';
			}elseif($late != '0' && $early != '0'){ //------------------- late & early
				//var_dump('late & early');
				$x = new DateTime($data['scan1']);
				$x->add($break); // substract breaktime
				$diff = $x->diff($time_out);
				$paid_hours = $diff->format('%h:%I');//.' - late & early';
			}
			
			
			if(!empty($plan_rh)){
				$ah = new DateTime($actual_hours);
				$ph = new DateTime($paid_hours);
				$diff = $ah->diff($ph);
				$tot_ot_time = $diff->format('%h:%I'); //------------------- actual overtime
				//var_dump($ah);
				//var_dump($ph);
				//var_dump($diff);
				$check = $diff->i + ($diff->h*60);
				//var_dump($check);
				//var_dump($paid_hours);
				$xot = array('1'=>'-','1.5'=>'-','2'=>'-','3'=>'-');
				if($check > ($ot_start_after + $ot_period)){
					$ot_time = new DateTime($tot_ot_time);
					//var_dump($ot_time);
					//$ot_time->sub(new DateInterval('PT'.$ot_start_after.'M'));
					//var_dump($ot_time);
					$min = $ot_time->format('i') + ($ot_time->format('h')*60);
					//var_dump($min);
					$tmp = $min / $ot_period;
					//var_dump($tmp);
					$dec = $tmp - (int)$tmp;
					//var_dump($dec);
					$lost_ot = round($dec * $ot_period);
					//var_dump($lost_ot);
					$ot_time->sub(new DateInterval('PT'.$lost_ot.'M'));
					//var_dump($ot_time->format('H:i'));
					
					if(isset($ot['hrs'])){
						if($ot[1] != 0){
							if($ot['hrs'] == 0){
								//var_dump($paid_hours);
								$xot[$ot[1]] = $paid_hours;
							}else{
								//var_dump($paid_hours);
								$xot[$ot[1]] = $paid_hours;
							}
						}
						if($ot[2] != 0){
							$xot[$ot[2]] = $ot_time->format('G:i');
						}
					}else{
						//$xot['1'] = '-';
						$xot[$ot] = ($ot_time->format('H:i') != '00:00') ? $ot_time->format('G:i') : '-';
						//$xot['2'] = '-';
						//$xot['3'] = '-';
					}
					
					//$ot1 = $paid_hours;
					//$ot15 = ($ot_time->format('H:i') != '00:00') ? $ot_time->format('G:i') : '-';
					//$ot2 = '-';
					//$ot3 = '-';
				}else{
					if(isset($ot['hrs'])){
						if($ot[1] != 0){
							if($ot['hrs'] == 0){
								$xot[$ot[1]] = $paid_hours;
							}else{
								$xot[$ot[1]] = $paid_hours;
							}
						}
					}else{
						//$xot['1'] = '-';
						//$xot[$ot] = ($ot_time->format('H:i') != '00:00') ? $ot_time->format('G:i') : '-';
						//$xot['2'] = '-';
						//$xot['3'] = '-';
					}
					//$ot1 = $paid_hours;
					//$ot15 = '-';
					//$ot2 = '-';
					//$ot3 = '-';
				}
			}
		}
		//var_dump($xot);
		
		//$xdata['emp_id'] = $data['emp_id'];
		$xdata['actual_hrs'] = $actual_hours;
		$xdata['paid_hrs'] = $paid_hours;
		$xdata['late'] = $late;
		$xdata['early'] = $early;
		$xdata['ot1'] = $xot[1];
		$xdata['ot15'] = $xot['1.5'];
		$xdata['ot2'] = $xot[2];
		$xdata['ot3'] = $xot[3];
	}
	
	var_dump($xdata); 
	
	ob_clean();
	echo json_encode($xdata);
	exit;

	foreach($xdata as $key=>$val){
		$sql = "UPDATE $dbname SET ";
		foreach($val as $k=>$v){
			$sql .= "$k = '".$dbc->real_escape_string($v)."', ";
		}
		$sql = substr($sql, 0, -2);
		$sql .= " WHERE id = '$key'";
		$res = $dbc->query($sql);
	}
	//echo mysqli_error($dbc).'<br>';
	//echo $sql; exit;

















