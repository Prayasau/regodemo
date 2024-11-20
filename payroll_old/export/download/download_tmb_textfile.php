<?php

	if(session_id()==''){session_start();}
	ob_start();
	mb_internal_encoding('UTF-8');
	
	include('../../../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	include(DIR.'files/arrays_'.$lang.'.php');
	
	$edata = getEntityData($_SESSION['rego']['gov_entity']);
	$banks = array();
	$tmp = unserialize($edata['banks']);
	if($tmp){
		foreach($tmp as $k=>$v){
			$banks[$v['code']]['name'] = $v['name'];
			$banks[$v['code']]['number'] = $v['number'];
		}
	}

	$_account = str_replace('-', '', $banks['011']['number']);
	$compname = substr($banks['011']['name'], 0, 25);
	if(mb_strlen($compname) < 25){
		$compname .= str_repeat(' ', 25 - mb_strlen($compname));
	}
	
	$txt = "H000001011";
	$txt .= sprintf("%010d",str_replace('-', '', $_account));
	$txt .= $compname;
	$txt .= date('dmy', strtotime($_REQUEST['date']));
	$txt .= '000000';
	$txt .= str_repeat(' ', 71);
	$txt .= "\r\n";
	
	$tot_salary = 0;
	$nr = 2; ;
	$sql = "SELECT * FROM ".$_SESSION['rego']['payroll_dbase']." WHERE month = '".$_SESSION['rego']['cur_month']."' AND entity = '".$_SESSION['rego']['gov_entity']."'";
	if($res = $dbc->query($sql)){
		if($res->num_rows > 0){
			while($row = $res->fetch_assoc()){
				$empinfo = getEmployeesByBank($cid, $row['emp_id'], '011', 'all');
				//var_dump($empinfo);
				if($empinfo){
					$salary = round($row['net_income'],2) * 100;
					$tot_salary += $salary;
					$empinfo = getEmployeeInfo($cid, $row['emp_id']);
					$name = trim($empinfo['bank_account_name']);
					if(empty($name)){$name = $title[$empinfo['title']].' '.trim($empinfo['en_name']);}
					$name = preg_replace('!\s+!', ' ', $name);
					$name = mb_substr($name, 0, 35);
					$len = mb_strlen($name);
					$account = str_replace('-', '', $empinfo['bank_account']);
					$txt .= 'D';
					$txt .= sprintf("%06d",$nr);
					$txt .= '011';
					$txt .= sprintf("%010d", $account);
					$txt .= 'C'.sprintf("%010d",$salary);
					$txt .= '089';
					$txt .= str_repeat(' ', 10);
					$txt .= date('ymd', strtotime($_REQUEST['date']));
					$txt .= '0000001';
					$txt .= str_repeat(' ', 36);
					$txt .= $name;
					if(mb_strlen($name) < 35){
						$txt .= str_repeat(' ', 35 - $len);
					}
					$txt .= "\r\n";
					$nr++;
				}
			}
		}
	}
					
	$txt .= 'T';
	$txt .= sprintf("%06d",$nr);
	$txt .= '011';
	$txt .= sprintf("%010d", $_account);
	$txt .= str_repeat('0', 7);
	$txt .= str_repeat('0', 13);
	$txt .= sprintf("%07d",($nr-2));
	$txt .= sprintf("%013d",$tot_salary);
	$txt .= str_repeat('0', 40);
	$txt .= str_repeat(' ', 28);
	$txt .= "\r\n";
	//var_dump($txt); exit;
	$txt = iconv(mb_detect_encoding($txt), "TIS-620", $txt);

	$dir = DIR.$cid.'/documents/';
	$root = ROOT.$cid.'/documents/';
	$filename = strtoupper($cid).' TMB Bank textfile '.$_SESSION['rego']['year_th'].' '.$_SESSION['rego']['curr_month'].'.txt';
	$doc = $filename;
	
	header('Content-type: text/plain');
	header("Content-Disposition: attachment; filename=".$filename);
	
	ob_clean();
	echo $txt;
	file_put_contents($dir.$filename, $txt);
	//include('../print/save_to_documents.php');
	
	exit;


