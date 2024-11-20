<?

	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");
	include(DIR.'files/functions.php');
	
	$error = 0;
	$new_year = $cur_year+1;
	
	$old_db_name = $cid."_shiftplans_".$cur_year;
	$new_db_name = $cid."_shiftplans_".$new_year;
	if(!$dbc->query("DESCRIBE $new_db_name")) {
		$sql = "CREATE TABLE $new_db_name LIKE $old_db_name";
		if(!$dbc->query($sql)){
			echo '<br>16'.mysqli_error($dbc);
			$error = 1;
		}
	}
	
	$old_db_name = $cid."_payroll_".$cur_year;
	$new_db_name = $cid."_payroll_".$new_year;
	if(!$dbc->query("DESCRIBE $new_db_name")) {
		$sql = "CREATE TABLE $new_db_name LIKE $old_db_name";
		if(!$dbc->query($sql)){
			echo '<br>26'.mysqli_error($dbc);
			$error = 1;
		}
	}
	
	$old_db_name = $cid."_monthly_shiftplans_".$cur_year;
	$new_db_name = $cid."_monthly_shiftplans_".$new_year;
	if(!$dbc->query("DESCRIBE $new_db_name")) {
		$sql = "CREATE TABLE $new_db_name LIKE $old_db_name";
		if(!$dbc->query($sql)){
			echo '<br>36'.mysqli_error($dbc);
			$error = 1;
		}
	}
	
	// UPDATE SCHIFTPLANS ///////////////////////////////////////////////////
	$sql = "SELECT * FROM ".$cid."_shiftplans_".$cur_year;
	if($res = $dbc->query($sql)){
		while($row = $res->fetch_assoc()){
			$xdates[$row['code']] = unserialize($row['dates']);
			$plan[$row['code']] = unserialize($row['plan']);
		}
	}
	$shiftplan = getDefaultShiftplan($cid);
	//var_dump($plan); exit;
	
	end($xdates);
	foreach($xdates as $k=>$v){
		end($v);
		$end = date('Y-m-d', key($v));
		$enddate[$k] = $end;
	}
	
	foreach($plan as $key=>$val){

		if(count($val['week']) == 1){
			$new_start = date('Y-m-d', strtotime($enddate[$key]." -6 days"));
		}
		if(count($val['week']) == 2){
			$new_start = date('Y-m-d', strtotime($enddate[$key]." -13 days"));
		}
		if(count($val['week']) == 3){
			$new_start = date('Y-m-d', strtotime($enddate[$key]." -20 days"));
		}
			
		$current = strtotime($new_start);
		$plan[$key]['startdate'] = date('d-m-Y', $current);
		$last = strtotime("mon jan ".($cur_year+2));
		$dates = array();
		
		if($val['shiftType'] == 'nw' || $val['shiftType'] == '12d' || $val['shiftType'] == '12n'){
			while($current < $last){
				foreach($val['week']['day'] as $k=>$v){
					if($v!='0' && $v!='OFF'){
						$dates[date('d-m-Y',$current)]['from1'] = $shiftplan[$v]['f1'];
						$dates[date('d-m-Y',$current)]['until1'] = $shiftplan[$v]['u1'];
						$dates[date('d-m-Y',$current)]['from2'] = $shiftplan[$v]['f2'];
						$dates[date('d-m-Y',$current)]['until2'] = $shiftplan[$v]['u2'];
						$dates[date('d-m-Y',$current)]['hours'] = $shiftplan[$v]['hours'];
						$dates[date('d-m-Y',$current)]['break'] = $shiftplan[$v]['break'];
						$dates[date('d-m-Y',$current)]['end'] = $shiftplan[$v]['end'];
						$dates[date('d-m-Y',$current)]['plan'] = $v;
					}else{
						$dates[date('d-m-Y',$current)]['from1'] = '';
						$dates[date('d-m-Y',$current)]['until1'] = '';
						$dates[date('d-m-Y',$current)]['from2'] = '';
						$dates[date('d-m-Y',$current)]['until2'] = '';
						$dates[date('d-m-Y',$current)]['hours'] = '';
						$dates[date('d-m-Y',$current)]['break'] = '';
						$dates[date('d-m-Y',$current)]['end'] = '';
						$dates[date('d-m-Y',$current)]['plan'] = 'OFF';
					}
					$current = strtotime('+1 day', $current);
				}
			}
		}
		if($val['shiftType']=='3x8' || $val['shiftType']=='2x8' || $val['shiftType']=='2x12'){
			while($current < $last){
				foreach($val['sequence'] as $seq=>$type){
					for($i=1;$i<=(int)$val['quant'][$seq];$i++){
						foreach($val['week'][$seq] as $k=>$v){
							if($v!='0' && $v!='OFF'){
								$dates[date('d-m-Y',$current)]['from1'] = $shiftplan[$v]['f1'];
								$dates[date('d-m-Y',$current)]['until1'] = $shiftplan[$v]['u1'];
								$dates[date('d-m-Y',$current)]['from2'] = $shiftplan[$v]['f2'];
								$dates[date('d-m-Y',$current)]['until2'] = $shiftplan[$v]['u2'];
								$dates[date('d-m-Y',$current)]['hours'] = $shiftplan[$v]['hours'];
								$dates[date('d-m-Y',$current)]['break'] = $shiftplan[$v]['break'];
								$dates[date('d-m-Y',$current)]['end'] = $shiftplan[$v]['end'];
								$dates[date('d-m-Y',$current)]['plan'] = $v;
							}else{
								$dates[date('d-m-Y',$current)]['from1'] = '';
								$dates[date('d-m-Y',$current)]['until1'] = '';
								$dates[date('d-m-Y',$current)]['from2'] = '';
								$dates[date('d-m-Y',$current)]['until2'] = '';
								$dates[date('d-m-Y',$current)]['hours'] = '';
								$dates[date('d-m-Y',$current)]['break'] = '';
								$dates[date('d-m-Y',$current)]['end'] = '';
								$dates[date('d-m-Y',$current)]['plan'] = 'OFF';
							}
							$current = strtotime('+1 day', $current);
						}
						
					}
				}
			}
		}
		if($val['shiftType']=='rd'){
			while($current < $last){
				foreach($val['day'] as $k=>$v){
					if($v!='0' && $v!='OFF'){
						$dates[date('d-m-Y',$current)]['from1'] = $shiftplan[$v]['f1'];
						$dates[date('d-m-Y',$current)]['until1'] = $shiftplan[$v]['u1'];
						$dates[date('d-m-Y',$current)]['from2'] = $shiftplan[$v]['f2'];
						$dates[date('d-m-Y',$current)]['until2'] = $shiftplan[$v]['u2'];
						$dates[date('d-m-Y',$current)]['hours'] = $shiftplan[$v]['hours'];
						$dates[date('d-m-Y',$current)]['break'] = $shiftplan[$v]['break'];
						$dates[date('d-m-Y',$current)]['end'] = $shiftplan[$v]['end'];
						$dates[date('d-m-Y',$current)]['plan'] = $v;
					}else{
						$dates[date('d-m-Y',$current)]['from1'] = '';
						$dates[date('d-m-Y',$current)]['until1'] = '';
						$dates[date('d-m-Y',$current)]['from2'] = '';
						$dates[date('d-m-Y',$current)]['until2'] = '';
						$dates[date('d-m-Y',$current)]['hours'] = '';
						$dates[date('d-m-Y',$current)]['break'] = '';
						$dates[date('d-m-Y',$current)]['end'] = '';
						$dates[date('d-m-Y',$current)]['plan'] = 'OFF';
					}
					$current = strtotime('+1 day', $current);
				}
				for($i=1;$i<=$val['offdays'];$i++){
					$dates[date('d-m-Y',$current)]['from1'] = '';
					$dates[date('d-m-Y',$current)]['until1'] = '';
					$dates[date('d-m-Y',$current)]['from2'] = '';
					$dates[date('d-m-Y',$current)]['until2'] = '';
					$dates[date('d-m-Y',$current)]['hours'] = '';
					$dates[date('d-m-Y',$current)]['break'] = '';
					$dates[date('d-m-Y',$current)]['end'] = '';
					$dates[date('d-m-Y',$current)]['plan'] = 'OFF';
					$current = strtotime('+1 day', $current);
				}
			}
		}

		$sql = "INSERT INTO ".$cid."_shiftplans_".$new_year." (code, name, description, plan, dates) VALUES(
		'".$dbc->real_escape_string($val['code'])."',
		'".$dbc->real_escape_string($val['name'])."',
		'".$dbc->real_escape_string($val['description'])."',
		'".serialize($plan[$key])."',
		'".serialize($dates)."') 
			ON DUPLICATE KEY UPDATE 
			name = VALUES(name),
			description = VALUES(description),
			plan = VALUES(plan),
			dates = VALUES(dates)";
		//echo $sql;
		//exit;
			
		if(!$dbc->query($sql)){
			echo '<br>187'.mysqli_error($dbc);
			$error = 1;
		}
	}
	//var_dump($plan);
	
	
	// UPDATE PAYROLL MONTHS //////////////////////////////////////////////////
	$res = $dbx->query("SELECT * FROM rego_default_settings");
	if($row = $res->fetch_assoc()){
		$sso_rate = $row['sso_rate'];
		$sso_min = $row['sso_min'];
		$sso_max = $row['sso_max'];
		$sso_rate_com = $row['sso_rate_com'];
		$sso_min_com = $row['sso_min_com'];
		$sso_max_com = $row['sso_max_com'];
	}
	//var_dump($row); //exit;
	
	$time_end = '25-12-'.$cur_year;
	$leave_end = '25-12-'.$cur_year;
	$payroll_end = '25-12-'.$cur_year;
	$sql = "SELECT * FROM ".$cid."_payroll_months WHERE month = '".$cur_year."_12'";
	if($res = $dbc->query($sql)){
		while($row = $res->fetch_assoc()){
			$time_end = date('d-m-Y', strtotime($row['time_end'].'+1 days'));
			$leave_end = date('d-m-Y', strtotime($row['leave_end'].'+1 days'));
			$payroll_end = date('d-m-Y', strtotime($row['payroll_end'].'+1 days'));
			$max = $row['sso_act_max'];
		}
	}
	
	$sql = "INSERT INTO ".$cid."_payroll_months (month, time_start, time_end, leave_start, leave_end, payroll_start, payroll_end, paydate, formdate, sso_eRate, sso_eMax, sso_eMin, sso_cRate, sso_cMax, sso_cMin, wht, sso_act_max) VALUES ";
	for($i=1;$i<=12;$i++){
		$last = date('t', strtotime($new_year.'-'.sprintf('%02d', $i).'-01'));
		$date = $last.'-'.sprintf('%02d', $i).'-'.$new_year;
		$time_start = '26-'.sprintf('%02d', ($i-1)).'-'.$new_year;
		$leave_start = $time_start;
		$payroll_start = $time_start;
		$end = '25-'.sprintf('%02d', $i).'-'.$new_year;
		if($i == 1){
			$time_start = $time_end;
			$leave_start = $leave_end;
			$payroll_start = $payroll_end;
		}
		$sql .= "('".$dbc->real_escape_string($new_year.'_'.$i)."',";
		$sql .= "'".$dbc->real_escape_string($time_start)."',";
		$sql .= "'".$dbc->real_escape_string($end)."',";
		$sql .= "'".$dbc->real_escape_string($leave_start)."',";
		$sql .= "'".$dbc->real_escape_string($end)."',";
		$sql .= "'".$dbc->real_escape_string($payroll_start)."',";
		$sql .= "'".$dbc->real_escape_string($end)."',";
		$sql .= "'".$dbc->real_escape_string($date)."',";
		$sql .= "'".$dbc->real_escape_string($date)."',";
		$sql .= "'".$dbc->real_escape_string($sso_rate)."',";
		$sql .= "'".$dbc->real_escape_string($sso_max)."',";
		$sql .= "'".$dbc->real_escape_string($sso_min)."',";
		$sql .= "'".$dbc->real_escape_string($sso_rate_com)."',";
		$sql .= "'".$dbc->real_escape_string($sso_max_com)."',";
		$sql .= "'".$dbc->real_escape_string($sso_min_com)."',";
		$sql .= "'".$dbc->real_escape_string(3)."',";
		$sql .= "'".$dbc->real_escape_string($max)."'),";
	}
	$sql = substr($sql, 0, -1)." ON DUPLICATE KEY UPDATE 
		time_start = VALUES(time_start), 
		time_end = VALUES(time_end), 
		leave_start = VALUES(leave_start), 
		leave_end = VALUES(leave_end), 
		payroll_start = VALUES(payroll_start), 
		payroll_end = VALUES(payroll_end), 
		paydate = VALUES(paydate), 
		formdate = VALUES(formdate), 
		sso_eRate = VALUES(sso_eRate), 
		sso_eMax = VALUES(sso_eMax), 
		sso_eMin = VALUES(sso_eMin), 
		sso_cRate = VALUES(sso_cRate), 
		sso_cMax = VALUES(sso_cMax), 
		sso_cMin = VALUES(sso_cMin), 
		sso_act_max = VALUES(sso_act_max)";
	//echo $sql; exit;
	//echo $err_msg;	exit;

	if(!$dbc->query($sql)){
		echo '<br>270'.mysqli_error($dbc);
		$error = 1;
	}
	
	if(!$error){
		$sql = "UPDATE ".$cid."_company_settings SET years = CONCAT(years, ',',".$new_year.")";
		if(!$dbc->query($sql)){
			echo '<br>277'.mysqli_error($dbc);
		}else{
			ob_clean(); 
			echo 'success';
		}
	}else{
		ob_clean(); 
		echo 'error';
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
