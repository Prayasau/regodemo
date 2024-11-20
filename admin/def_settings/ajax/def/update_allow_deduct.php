<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../../dbconnect/db_connect.php");
	//var_dump($_REQUEST); //exit;
	
	$sql = "INSERT INTO rego_allow_deduct (`id`,`apply`, `th`, `en`, `classification`, `groups`, `earnings`, `deductions`, `hour_daily_rate`, `pnd1`, `tax_income`, `sso`, `pvf`, `psf`, `tax_base`, `man_emp`, `man_att`,`income_base`, `comp_reduct`) VALUES ";
	foreach($_REQUEST['data'] as $k=>$v){
		$sql .= "('".$dba->real_escape_string($v['id'])."',";
		$sql .= "'".$dba->real_escape_string($v['apply'])."',";
		$sql .= "'".$dba->real_escape_string($v['th'])."',";
		$sql .= "'".$dba->real_escape_string($v['en'])."',";
		$sql .= "'".$dba->real_escape_string($v['classification'])."',";
		$sql .= "'".$dba->real_escape_string($v['groups'])."',";
		$sql .= "'".$dba->real_escape_string($v['earnings'])."',";
		$sql .= "'".$dba->real_escape_string($v['deductions'])."',";
		$sql .= "'".$dba->real_escape_string($v['hour_daily_rate'])."',";
		$sql .= "'".$dba->real_escape_string($v['pnd1'])."',";
		$sql .= "'".$dba->real_escape_string($v['tax_income'])."',";
		$sql .= "'".$dba->real_escape_string($v['sso'])."',";
		$sql .= "'".$dba->real_escape_string($v['pvf'])."',";
		$sql .= "'".$dba->real_escape_string($v['psf'])."',";
		$sql .= "'".$dba->real_escape_string($v['tax_base'])."',";
		$sql .= "'".$dba->real_escape_string($v['man_emp'])."',";
		$sql .= "'".$dba->real_escape_string($v['man_att'])."',";
		$sql .= "'".$dba->real_escape_string($v['income_base'])."',";
		$sql .= "'".$dba->real_escape_string($v['comp_reduct'])."'),";
	}
	$sql = substr($sql,0,-1);
	//echo $sql; //exit;
	
	$sql .= " ON DUPLICATE KEY UPDATE 
		apply = VALUES(apply),
		th = VALUES(th),
		en = VALUES(en),
		classification = VALUES(classification),
		groups = VALUES(groups),
		earnings = VALUES(earnings),
		deductions = VALUES(deductions),
		hour_daily_rate = VALUES(hour_daily_rate),
		pnd1 = VALUES(pnd1),
		tax_income = VALUES(tax_income),
		sso = VALUES(sso),
		pvf = VALUES(pvf),
		psf = VALUES(psf),
		tax_base = VALUES(tax_base),
		man_emp = VALUES(man_emp),
		man_att = VALUES(man_att),
		income_base = VALUES(income_base),
		comp_reduct = VALUES(comp_reduct)";
		
	//echo $sql;
	//exit;
	
	ob_clean();	
	if($dba->query($sql)){
		echo 'success';
	}else{
		echo mysqli_error($dba);
	}

?>