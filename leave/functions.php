<?php

	function checkBalance($balance, $type, $leave, $days){
		if($type != '0'){
			//var_dump($type);
			if($balance[$type] < $days){
				return 'Not enough days left - Balance <b>'.$type.'</b> '.$leave.' = '.$balance[$type].'&nbsp; - &nbsp;Requested : '.$days;
			}
		}
	}

	function getLeaveTypes($cid){
		global $dbc;
		$data = array();
		$sql = "SELECT `leave_types` FROM `".$cid."_leave_time_settings`";
		if($res = $dbc->query($sql)){
			if($row = $res->fetch_object()){
				$data = unserialize($row->leave_types);
			}
		}
		return $data;
	}

	function getLeaveReqBefore($cid){
		global $dbc;
		$data = array();
		$sql = "SELECT `request` FROM `".$cid."_leave_time_settings`";
		if($res = $dbc->query($sql)){
			if($row = $res->fetch_object()){
				$data = $row->request;
			}
		}
		return $data;
	}

	function getSelLeaves($cid){
		global $dbc;
		$data = array();
		$sql = "SELECT `leave_types` FROM `".$cid."_leave_time_settings`";
		if($res = $dbc->query($sql)){
			if($row = $res->fetch_object()){
				$tmp = unserialize($row->leave_types);
			}
		}
		foreach($tmp as $k=>$v){
			if($v['activ'] == 1){
				$data[$k] = $k;
			}
		}
		return $data;
	}

	function getEmpLeaveTypes($cid){
		global $dbc;
		$data = array();
		$sql = "SELECT leave_types FROM ".$cid."_leave_time_settings";
		if($res = $dbc->query($sql)){
			if($row = $res->fetch_object()){
				$tmp = unserialize($row->leave_types);
			}
		}
		foreach($tmp as $k=>$v){
			//if($v['activ'] == 1 && $v['emp_request'] == 1){
			if($v['activ'] == 1){
				$data[$k] = $v;
			}
		}
		return $data;
	}

	function getSelLeaveTypes($cid){
		global $dbc;
		$data = array();
		$sql = "SELECT `leave_types` FROM `".$cid."_leave_time_settings`";
		if($res = $dbc->query($sql)){
			if($row = $res->fetch_object()){
				$tmp = unserialize($row->leave_types);
			}
		}
		foreach($tmp as $k=>$v){
			if($v['activ'] == 1){
				$data[$k] = $v;
			}
		}
		return $data;
	}

	function getYTDworkedDays($cid){
		global $dbc;
		/*$hol = array();
		$hd = getHolidays($cid);
		foreach($hd as $k=>$v){
			$hol[] = strtotime($v['cdate']);
		}*/
		
		$data = array();
		$xdata = array();
		$days = array();
		$today = strtotime(date('Y-m-d'));
		$sql = "SELECT * FROM ".$cid."_monthly_shiftplans_".$_SESSION['rego']['cur_year'];
		if($res = $dbc->query($sql)){
			while($row = $res->fetch_assoc()){
				$data[] = $row;
			}
		}
		foreach($data as $k=>$v){
			$end = cal_days_in_month(CAL_GREGORIAN,$v['month'],$_SESSION['rego']['cur_year']);
			for($i=1; $i<=$end; $i++){
				if($v['D'.$i] != 'OFF'){
					$xdata[$v['month']][$i] = strtotime($i.'-'.$v['month'].'-'.$_SESSION['rego']['cur_year']);
				}
			}
		}
		
		$xdata = array_map('array_values', $xdata);
		//return $xdata;
		foreach($xdata as $key=>$val){
			foreach($val as $k=>$v){
				if($v > $today){
					$days[$key] = $k;
					break;
				}
			}
		}
		//return $days;
		for($i=count($days);$i<=12;$i++){
			$days[$i] = 0;
		}
		return $days;
	}

	function getALemployee($cid, $id){
		global $dbc;
		$data = 0;
		$res = $dbc->query("SELECT annual_leave FROM ".$cid."_employees WHERE emp_id = '".$id."'");
		if($row = $res->fetch_assoc()){
			$data = $row['annual_leave'];
		}
		return $data;
	}

	function getUsedLeaveEmployee($cid, $id, $balance){
		global $dbc;
		$res = $dbc->query("SELECT * FROM ".$cid."_leaves_data WHERE emp_id = '".$id."'"); 
		while($row = $res->fetch_assoc()){
			if($row['status'] == 'RQ' || $row['status'] == 'AP'){
				$balance[$row['leave_type']]['pending'] += $row['days'];
			}elseif($row['status'] == 'TA'){
				$balance[$row['leave_type']]['used'] += $row['days'];
			}
		}
		return $balance;
	}

	function getStrictBalanceEmployee($cid, $dleave, $id){
		global $dbc;
		$data = array();
		foreach($dleave as $k=>$v){
			$data[$k] = $v['maxdays'];
		}
		$res = $dbc->query("SELECT * FROM ".$cid."_leaves WHERE emp_id = '".$id."'"); 
		while($row = $res->fetch_assoc()){
			if($row['status'] == 'RQ' || $row['status'] == 'AP' || $row['status'] == 'TA'){
				if(isset($data[$row['leave_type']])){
					$data[$row['leave_type']] -= $row['days'];
					//$data = $row['type'];
				}
			}
		}
		return $data;
	}

	function getPendingDays($cid, $id, $leave_id){
		global $dbc;
		$data = array();
		$sql = "SELECT date, days, day FROM ".$cid."_leaves_data WHERE emp_id = '".$id."' AND leave_id <> '".$leave_id."'";
		if($res = $dbc->query($sql)){
			while($row = $res->fetch_assoc()){
				//$data[strtotime($row['date'])] = strtotime($row['date']);
				$data['date'][strtotime($row['date'])] = strtotime($row['date']);
				//$data[strtotime($row['date'])]['date'] = $row['date'];
				$data['days'][strtotime($row['date'])] = $row['days'];
				$data['day'][strtotime($row['date'])] = $row['day'];
			}
		}
		return $data;
	}

	function getHolidays($year){
		global $dbc;
		$data = array();
		$sql = "SELECT * FROM ".$_SESSION['rego']['cid']."_holidays WHERE year = '".$year."'";
		if($res = $dbc->query($sql)){
			while($row = $res->fetch_assoc()){
				$data[] = $row;
			}
		}
		return $data;
	}

	function getHoliDates($year){
		global $dbc;
		$data = array();
		$sql = "SELECT * FROM ".$_SESSION['rego']['cid']."_holidays WHERE year = '".$year."'";
		if($res = $dbc->query($sql)){
			while($row = $res->fetch_assoc()){
				$data[] = $row['cdate'];
			}
		}
		return $data;
	}

	function getAllHoliDates($year){
		global $dbc;
		$data = array();
		$sql = "SELECT * FROM ".$_SESSION['rego']['cid']."_holidays WHERE year = '".$year."'";
		if($res = $dbc->query($sql)){
			while($row = $res->fetch_assoc()){
				$data[] = date('d-m-Y', strtotime($row['cdate']));
			}
		}
		return $data;
	}

	function updateLeaveDatabase($cid){
		global $dbc;
		//global $leave_types;
		$leave_types = getSelLeaveTypes($cid);
		//global $leave_periods;
		// apply pending and taken leave
		
		/*$data = array();
		$sql = "SELECT id, type, attach FROM ".$cid."_leaves";
		if($res = $dbc->query($sql)){
			while($row = $res->fetch_assoc()){
				if($leave_types[$row['type']]['certificate'] == 1 && $row['attach'] == ''){
					$data[$row['id']] = 0;
				}else{
					$data[$row['id']] = 1;
				}
			}
		}
		if($data){ 
			foreach($data as $k=>$v){
				$sql = "UPDATE ".$cid."_leaves_data SET certificate = '".$v."' WHERE leave_id = '".$k."'"; 
				$dbc->query($sql);
			} 
		}*/
		//var_dump($data);
	
		$data = array(); // SET PASSED DAYS AS TAKEN IF STATUS = APPROVED
		$sql = "SELECT id, end, status FROM ".$cid."_leaves WHERE end <= CURDATE() AND status = 'AP'";
		if($res = $dbc->query($sql)){
			while($row = $res->fetch_assoc()){
				$data[$row['id']] = $row['end'];
			}
		}
		if($data){ 
			foreach($data as $k=>$v){
				$sql = "UPDATE ".$cid."_leaves SET status = 'TA' WHERE id = '".$k."'"; 
				$dbc->query($sql);
			} 
		}
		
		$data = array();
		$sql = "SELECT id, date, status FROM ".$cid."_leaves_data WHERE date <= CURDATE() AND status = 'AP'";
		if($res = $dbc->query($sql)){
			while($row = $res->fetch_assoc()){
				$data[$row['id']] = $row['date'];
			}
		}
		if($data){ 
			foreach($data as $k=>$v){
				$sql = "UPDATE ".$cid."_leaves_data SET status = 'TA' WHERE id = '".$k."'"; 
				$dbc->query($sql);
			} 
		}
		//var_dump($data); exit;
	}

	function getMonthlyPeriod($period_start){
		$year = $_SESSION['rego']['cur_year'];
		$month = $_SESSION['rego']['curr_month'];
		if($period_start == 0){
			$start = 1;
		}else{
			if($month == 1){
				$month = 12;
				$year -= 1;
			}else{
				$month = sprintf('%02d', ($month -= 1));
			}
		}
		$d = date('t', strtotime($year.'-'.$month.'-01'));
		if($period_start == 31){
			$start = $d;
		}
		if($period_start != 0 && $period_start != 31){
			$start = $d - $period_start;
		}

		$sdate = date('Y-m-d', strtotime($year.'-'.$month.'-'.sprintf('%02d', $start)));
		$data['start'] = $sdate;
		
		if($month == 12){
			$month = 1;
			$year += 1;
		}else{
			$month = sprintf('%02d', ($month += 1));
		}
		$d = date('t', strtotime($year.'-'.$month.'-01'));
		if($period_start == 31){
			$start = $d;
		}
		if($period_start != 0 && $period_start != 31){
			$start = $d - $period_start;
		}
		$edate = date('Y-m-d', strtotime($year.'-'.$month.'-'.sprintf('%02d', $start)));

		$data['end'] = $edate;
		return $data;
	}























