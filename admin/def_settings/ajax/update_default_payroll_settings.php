<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");
	//var_dump($_REQUEST); exit;

	// echo '<pre>';
	// print_r($_REQUEST);
	// echo '</pre>';
	// exit;
	
	$_REQUEST['id_prefix'] = preg_replace("/[^a-zA-Z0-9,]+/", "", $_REQUEST['id_prefix']);
	$tmp = explode(',', $_REQUEST['id_prefix']);
	foreach($tmp as $k=>$v){
		if(empty($v)){unset($tmp[$k]);}
		if(strlen($v) > 3){$tmp[$k] = substr($v,0,3);}
	}
	$_REQUEST['id_prefix'] = implode(',', $tmp);
	
	foreach($_REQUEST['from'] as $k=>$v){
		$taxrules[$k]['from'] = $v;
		$taxrules[$k]['to'] = $_REQUEST['to'][$k];
		$taxrules[$k]['percent'] = $_REQUEST['percent'][$k];
		$taxrules[$k]['net_from'] = $_REQUEST['net_from'][$k];
		$taxrules[$k]['net_to'] = $_REQUEST['net_to'][$k];
	}

	if(!isset($_REQUEST['fix_allow'])){$_REQUEST['fix_allow'] = array();}
	if(!isset($_REQUEST['var_allow'])){$_REQUEST['var_allow'] = array();}
	if(!isset($_REQUEST['fix_deduct'])){$_REQUEST['fix_deduct'] = array();}
	if(!isset($_REQUEST['var_deduct'])){$_REQUEST['var_deduct'] = array();}
	if(!isset($_REQUEST['payslip_field'])){$_REQUEST['payslip_field'] = array();}
	if(!isset($_REQUEST['sso_defaults'])){$_REQUEST['sso_defaults'] = array();}

	$positions = array();
	if(isset($_REQUEST['positions'])){
		foreach($_REQUEST['positions'] as $k=>$v){
			$positions['en'][$v['code']] = $v['en'];
			$positions['th'][$v['code']] = $v['th'];
		}
	}
	//var_dump($positions); exit;
	
	$sql = "UPDATE rego_default_settings SET 
		days_month = '".$dba->real_escape_string($_REQUEST['days_month'])."', 
		hours_day = '".$dba->real_escape_string($_REQUEST['hours_day'])."', 
		sso_rate_emp = '".$dba->real_escape_string($_REQUEST['sso_rate_emp'])."', 
		sso_min_emp = '".$dba->real_escape_string($_REQUEST['sso_min_emp'])."', 
		sso_max_emp = '".$dba->real_escape_string($_REQUEST['sso_max_emp'])."', 
		sso_rate_com = '".$dba->real_escape_string($_REQUEST['sso_rate_com'])."', 
		sso_min_com = '".$dba->real_escape_string($_REQUEST['sso_min_com'])."', 
		sso_max_com = '".$dba->real_escape_string($_REQUEST['sso_max_com'])."', 
		sso_min_wage = '".$dba->real_escape_string($_REQUEST['sso_min_wage'])."', 
		sso_max_wage = '".$dba->real_escape_string($_REQUEST['sso_max_wage'])."', 
		sso_act_max = '".$dba->real_escape_string($_REQUEST['sso_act_max'])."', 
		payslip_template = '".$dba->real_escape_string($_REQUEST['payslip_template'])."', 
		payslip_rate = '".$dba->real_escape_string($_REQUEST['payslip_rate'])."', 
		payslip_field = '".$dba->real_escape_string(serialize($_REQUEST['payslip_field']))."', 

		positions = '".$dba->real_escape_string(serialize($positions))."', 
		
		fix_allow = '".$dba->real_escape_string(serialize($_REQUEST['fix_allow']))."', 
		var_allow = '".$dba->real_escape_string(serialize($_REQUEST['var_allow']))."', 
		
		fix_deduct = '".$dba->real_escape_string(serialize($_REQUEST['fix_deduct']))."', 
		var_deduct = '".$dba->real_escape_string(serialize($_REQUEST['var_deduct']))."', 

		tax_settings_description = '".$dba->real_escape_string(serialize($_REQUEST['tax_settings_description']))."', 
		
		tax_info_th = '".$dba->real_escape_string(serialize($_REQUEST['tax_info_th']))."', 
		tax_info_en = '".$dba->real_escape_string(serialize($_REQUEST['tax_info_en']))."', 
		tax_err_th = '".$dba->real_escape_string(serialize($_REQUEST['tax_err_th']))."', 
		tax_err_en = '".$dba->real_escape_string(serialize($_REQUEST['tax_err_en']))."', 

		tax_calc_on = '".$dba->real_escape_string(serialize($_REQUEST['tax_calc_on']))."', 
		tax_thb = '".$dba->real_escape_string(serialize($_REQUEST['tax_thb']))."', 
		tax_unit = '".$dba->real_escape_string(serialize($_REQUEST['tax_unit']))."', 
		tax_number = '".$dba->real_escape_string(serialize($_REQUEST['tax_number']))."', 

		sso_defaults = '".$dba->real_escape_string(serialize($_REQUEST['sso_defaults']))."',
		periods_defaults = '".$dba->real_escape_string(serialize($_REQUEST['periods']))."',
		manualrates_default = '".$dba->real_escape_string(serialize($_REQUEST['manualrate']))."',
		tab_default = '".$dba->real_escape_string(serialize($_REQUEST['tab_default']))."',

		taxrules = '".$dba->real_escape_string(serialize($taxrules))."'"; 

		// tax_settings = '".$dba->real_escape_string(serialize($_REQUEST['tax_settings']))."', 
		
		/*allow_login = '".$dba->real_escape_string($_REQUEST['allow_login'])."', 
		support_email = '".$dba->real_escape_string($_REQUEST['support_email'])."', 
		print_payslip = '".$dba->real_escape_string($_REQUEST['print_payslip'])."', 
		bonus_payinmonth = '".$dba->real_escape_string($_REQUEST['bonus_payinmonth'])."'";*/
		//echo $sql; exit;
	
	ob_clean();
	if($dba->query($sql)){
			echo 'success';
	}else{
			echo mysqli_error($dba);
	}
	//exit;
		
	
?>