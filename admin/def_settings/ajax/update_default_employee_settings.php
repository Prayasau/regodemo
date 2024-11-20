<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");
	
	$_REQUEST['id_prefix'] = preg_replace("/[^a-zA-Z0-9,]+/", "", $_REQUEST['id_prefix']);
	$tmp = explode(',', $_REQUEST['id_prefix']);
	foreach($tmp as $k=>$v){
		if(empty($v)){unset($tmp[$k]);}
		if(strlen($v) > 3){$tmp[$k] = substr($v,0,3);}
	}
	$_REQUEST['id_prefix'] = implode(',', $tmp);
	


	$sql = "UPDATE rego_default_settings SET 
		auto_id = '".$dba->real_escape_string($_REQUEST['auto_id'])."', 
		id_start = '".$dba->real_escape_string($_REQUEST['id_start'])."', 
		id_prefix = '".$dba->real_escape_string($_REQUEST['id_prefix'])."', 
		scan_id = '".$dba->real_escape_string($_REQUEST['scan_id'])."', 
		joining_date = '".$dba->real_escape_string($_REQUEST['joining_date'])."', 
		team = '".$dba->real_escape_string($_REQUEST['team'])."', 
		shiftplan_schedule = '".$dba->real_escape_string($_REQUEST['shiftplan_schedule'])."', 
		teams_name = '".$dba->real_escape_string($_REQUEST['teams_name'])."', 
		emp_group = '".$dba->real_escape_string($_REQUEST['emp_group'])."', 
		entity = '".$dba->real_escape_string($_REQUEST['entity'])."', 
		default_team = '".$dba->real_escape_string($_REQUEST['default_team'])."', 
		location = '".$dba->real_escape_string($_REQUEST['location'])."', 
		division = '".$dba->real_escape_string($_REQUEST['division'])."', 
		department = '".$dba->real_escape_string($_REQUEST['department'])."', 
		emp_type = '".$dba->real_escape_string($_REQUEST['emp_type'])."', 
		emp_status = '".$dba->real_escape_string($_REQUEST['emp_status'])."', 
		account_code = '".$dba->real_escape_string($_REQUEST['account_code'])."', 
		position = '".$dba->real_escape_string($_REQUEST['position'])."', 
		date_start = '".$dba->real_escape_string($_REQUEST['date_start'])."', 
		time_reg = '".$dba->real_escape_string($_REQUEST['time_reg'])."', 
		selfie = '".$dba->real_escape_string($_REQUEST['selfie'])."', 
		leeve = '".$dba->real_escape_string($_REQUEST['leeve'])."', 
		pay_type = '".$dba->real_escape_string($_REQUEST['pay_type'])."', 
		calc_psf = '".$dba->real_escape_string($_REQUEST['calc_psf'])."', 
		psf_rate_emp = '".$dba->real_escape_string($_REQUEST['psf_rate_emp'])."', 
		psf_rate_com = '".$dba->real_escape_string($_REQUEST['psf_rate_com'])."', 
		calc_pvf = '".$dba->real_escape_string($_REQUEST['calc_pvf'])."', 
		pvf_rate_emp = '".$dba->real_escape_string($_REQUEST['pvf_rate_emp'])."', 
		pvf_rate_com = '".$dba->real_escape_string($_REQUEST['pvf_rate_com'])."', 
		calc_method = '".$dba->real_escape_string($_REQUEST['calc_method'])."', 
		calc_tax = '".$dba->real_escape_string($_REQUEST['calc_tax'])."', 
		calc_sso = '".$dba->real_escape_string($_REQUEST['calc_sso'])."', 
		contract_type = '".$dba->real_escape_string($_REQUEST['contract_type'])."', 
		calc_base = '".$dba->real_escape_string($_REQUEST['calc_base'])."', 
		base_ot_rate = '".$dba->real_escape_string($_REQUEST['base_ot_rate'])."', 
		ot_rate = '".$dba->real_escape_string($_REQUEST['ot_rate'])."', 
		payroll_modal_value = '".$dba->real_escape_string($_REQUEST['payroll_modal_value'])."',
		headoflocation = '".$dba->real_escape_string($_REQUEST['headoflocation'])."',
		headofdivision = '".$dba->real_escape_string($_REQUEST['headofdivision'])."',
		headofdepartment = '".$dba->real_escape_string($_REQUEST['headofdepartment']). "',
		tax_id_check = '".$dba->real_escape_string($_REQUEST['tax_id_check']). "',
		sso_id_check = '".$dba->real_escape_string($_REQUEST['sso_id_check'])."'"; 

	
	ob_clean();
	if($dba->query($sql)){
			echo 'success';
	}else{
			echo mysqli_error($dba);
	}
	//exit;
		
	
?>