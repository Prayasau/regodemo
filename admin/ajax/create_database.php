
<?php

	$dbc = @new mysqli($my_database,$my_username,$my_password);
	$dbname = $prefix.$cid;
	if(empty(mysqli_fetch_array(mysqli_query($dbc,"SHOW DATABASES LIKE '$dbname'")))){
		 echo '<div style="color:#a00; font-size:16px; font-weight:600; border-bottom:1px solid #ccc; margin:0px 10px 2px 0">Database '.strtoupper($cid).' not exist, please contact the site administrator.</div>';
		 exit; 
	}else{
		 $dbc = @new mysqli($my_database,$my_username,$my_password,$prefix.$cid);
		 mysqli_set_charset($dbc,"utf8");
	}	
	
	$err_msg .= '<div style="color:#a00; font-size:16px; font-weight:600; border-bottom:1px solid #ccc; margin:0px 10px 2px 0">Create Databases</div>';
	
	$db_name = $cid."_approvals";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `month` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `year` int(11) DEFAULT NULL,
		  `type` varchar(10) COLLATE utf8_bin DEFAULT NULL,
		  `by_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `by_id` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `on_date` timestamp DEFAULT NULL DEFAULT CURRENT_TIMESTAMP,
		  `action` varchar(5) COLLATE utf8_bin DEFAULT NULL,
		  `comment` text COLLATE utf8_bin DEFAULT NULL,
		  `attachment` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  PRIMARY KEY (`id`) 
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Approvals</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Approvals</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Approvals</b> exists already.<br>';
	}

	
	$db_name = $cid."_attendance";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
			`id` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`month` int(11) DEFAULT NULL,
			`emp_id` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`en_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`th_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`date` date DEFAULT NULL,
			`day` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`dnr` int(11) DEFAULT NULL,
			`plan` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`plan_hrs` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`hd` int(11) DEFAULT NULL,
			`shiftteam` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`f1` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`u1` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`f2` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`u2` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`ot_plan` int(11) DEFAULT NULL,
			`ot_from` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`ot_until` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`ot_hrs` varchar(20) DEFAULT NULL,
			`ot_break` varchar(20) DEFAULT NULL,
			`ot_type` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`ot_compensations` text COLLATE utf8_bin DEFAULT NULL,
			`scan1` varchar(10) COLLATE utf8_bin DEFAULT NULL DEFAULT '-',
			`scan2` varchar(10) COLLATE utf8_bin DEFAULT NULL DEFAULT '-',
			`scan3` varchar(10) COLLATE utf8_bin DEFAULT NULL DEFAULT '-',
			`scan4` varchar(10) COLLATE utf8_bin DEFAULT NULL DEFAULT '-',
			`scan5` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`scan6` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`scan7` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`scan8` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`scan9` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`all_scans` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`img1` varchar(30) COLLATE utf8_bin DEFAULT NULL,
			`img2` varchar(30) COLLATE utf8_bin DEFAULT NULL,
			`img3` varchar(30) COLLATE utf8_bin DEFAULT NULL,
			`img4` varchar(30) COLLATE utf8_bin DEFAULT NULL,
			`img5` varchar(30) COLLATE utf8_bin DEFAULT NULL,
			`img6` varchar(30) COLLATE utf8_bin DEFAULT NULL,
			`img7` varchar(30) COLLATE utf8_bin DEFAULT NULL,
			`img8` varchar(30) COLLATE utf8_bin DEFAULT NULL,
			`img9` varchar(30) COLLATE utf8_bin DEFAULT NULL,
			`loc1` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`loc2` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`loc3` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`loc4` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`loc5` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`loc6` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`loc7` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`loc8` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`loc9` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`planned_days` varchar(20) DEFAULT NULL,
			`planned_hrs` varchar(20) DEFAULT NULL,
			`actual_hrs` varchar(20) DEFAULT NULL,
			`normal_hrs` varchar(20) DEFAULT NULL,
			`paid_hrs` varchar(20) DEFAULT NULL,
			`plan_ot` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`planned_ot` varchar(20) DEFAULT NULL,
			`plan_break` varchar(20) DEFAULT NULL,
			`paid_late` varchar(20) DEFAULT NULL,
			`paid_early` varchar(20) DEFAULT NULL,
			`unpaid_late` varchar(20) DEFAULT NULL,
			`unpaid_early` varchar(20) DEFAULT NULL,
			`public` varchar(20) DEFAULT NULL,
			`personal` varchar(20) DEFAULT NULL,
			`unpaid_leave` varchar(20) DEFAULT NULL,
			`ot1` varchar(20) DEFAULT NULL,
			`ot15` varchar(20) DEFAULT NULL,
			`ot2` varchar(20) DEFAULT NULL,
			`ot3` varchar(20) DEFAULT NULL,
			`leave_type` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`leave_days` varchar(20) DEFAULT NULL,
			`leave_day` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`leave_paid` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`leave_hrs` varchar(20) DEFAULT NULL,
			`comp1` int(11) DEFAULT NULL,
			`comp2` int(11) DEFAULT NULL,
			`comp3` int(11) DEFAULT NULL,
			`comp4` int(11) DEFAULT NULL,
			`comp5` int(11) DEFAULT NULL,
			`comp6` int(11) DEFAULT NULL,
			`comp7` int(11) DEFAULT NULL,
			`comp8` int(11) DEFAULT NULL,
			`comp9` int(11) DEFAULT NULL,
			`comp10` int(11) DEFAULT NULL,
			`var_allow_1` varchar(20) DEFAULT NULL,
			`var_allow_2` varchar(20) DEFAULT NULL,
			`var_allow_3` varchar(20) DEFAULT NULL,
			`var_allow_4` varchar(20) DEFAULT NULL,
			`var_allow_5` varchar(20) DEFAULT NULL,
			`var_allow_6` varchar(20) DEFAULT NULL,
			`var_allow_7` varchar(20) DEFAULT NULL,
			`var_allow_8` varchar(20) DEFAULT NULL,
			`var_allow_9` varchar(20) DEFAULT NULL,
			`var_allow_10` varchar(20) DEFAULT NULL,
			`remarks` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`comment` int(11) DEFAULT NULL,
			`status` int(11) DEFAULT NULL,
			`approved` int(11) DEFAULT NULL,
			`locked` int(11) DEFAULT NULL,
			`normal_days` varchar(20) DEFAULT NULL,
			`paid_days` varchar(20) DEFAULT NULL,
			`actual_days` varchar(20) DEFAULT NULL,
			`filename` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  PRIMARY KEY (`id`) 
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Attendance (Time)</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Attendance (Time)</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Attendance (Time)</b> exists already.<br>';
	}

	
	$db_name = $cid."_benefit_models";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `apply` int(11) COLLATE utf8_bin DEFAULT NULL,
		  `code` varchar(20) DEFAULT NULL,
		  `tab_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `description` text COLLATE utf8_bin DEFAULT NULL,
		  `penalties` int(11) COLLATE utf8_bin DEFAULT NULL,
		  `teams` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `all_data` text COLLATE utf8_bin DEFAULT NULL,
		  PRIMARY KEY (`id`) 
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Benefits Models</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Benefits Models</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Benefits Models</b> exists already.<br>';
	}


	/*$db_name = $cid."_payroll_models";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `apply` int(11) COLLATE utf8_bin DEFAULT NULL,
		  `code` varchar(20) DEFAULT NULL,
		  `tab_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `description` text COLLATE utf8_bin DEFAULT NULL,
		  `payroll_opt` varchar(11) COLLATE utf8_bin DEFAULT NULL,
		  `field_opt` varchar(11) COLLATE utf8_bin DEFAULT NULL,
		  `salary_split` varchar(11) COLLATE utf8_bin DEFAULT NULL,
		  `periods_def` varchar(11) COLLATE utf8_bin DEFAULT NULL,
		  `periods_set` varchar(11) COLLATE utf8_bin DEFAULT NULL,
		  `use_sso_pnd_def` varchar(11) COLLATE utf8_bin DEFAULT NULL,
		  `use_manual_rate_def` varchar(11) COLLATE utf8_bin DEFAULT NULL,
		  `use_othr_setting_def` varchar(11) COLLATE utf8_bin DEFAULT NULL,
		  PRIMARY KEY (`id`) 
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Payroll Models</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Payroll Models</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Payroll Models</b> exists already.<br>';
	}*/
	
	
	$db_name = $cid."_branches_data";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
		  	`ref` int(11) NOT NULL AUTO_INCREMENT,
		  	`apply_loc` varchar(11) COLLATE utf8_bin DEFAULT NULL,
		  	`code` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`th` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			`en` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			`entity` varchar(10) COLLATE utf8_bin DEFAULT NULL,	
			`scan_system` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`loc_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`loc_code` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			`loc_qr` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			`latitude` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`longitude` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`perimeter` int(11) DEFAULT NULL,
			`gps` int(11) DEFAULT NULL,
			`bra_address_th` text COLLATE utf8_bin DEFAULT NULL,
			`bra_address_en` text COLLATE utf8_bin DEFAULT NULL,
			`ent_code` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`ent_name_th` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`ent_name_en` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`ent_sso_account` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`revenu_branch_code` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`sso_code` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`sso_name_th` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`sso_name_en` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`sso_address_th` text COLLATE utf8_bin DEFAULT NULL,
			`sso_address_en` text COLLATE utf8_bin DEFAULT NULL,
			`common_branch_id` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`qrcodedata` text COLLATE utf8_bin DEFAULT NULL,
			`serialno` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`loc1` text COLLATE utf8_bin DEFAULT NULL,
			`loc2` text COLLATE utf8_bin DEFAULT NULL,
			`loc3` text COLLATE utf8_bin DEFAULT NULL,
			`loc4` text COLLATE utf8_bin DEFAULT NULL,
			`loc5` text COLLATE utf8_bin DEFAULT NULL,
			PRIMARY KEY (`ref`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Branches data</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Branches data</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Branches data</b> exists already.<br>';
	}
	
	$db_name = $cid."_company_settings";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
		  `id` int(11) DEFAULT NULL,
			`th_compname` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`en_compname` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`billing_th` text COLLATE utf8_bin DEFAULT NULL,
			`billing_en` text COLLATE utf8_bin DEFAULT NULL,
			`tax_id` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`wht` int(11) DEFAULT NULL,
			`email` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`logofile` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`latitude` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`longitude` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`logtime` int(11) DEFAULT NULL,
			`emp_group` int(11) DEFAULT NULL,
			`txt_color` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Company settings</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Company settings</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Company settings</b> exists already.<br>';
	}
	
	$db_name = $cid."_departments";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`apply_dept` varchar(11) COLLATE utf8_bin DEFAULT NULL,
			`code` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`th` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			`en` varchar(100) COLLATE utf8_bin DEFAULT NULL,			
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Departments</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Departments</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Departments</b> exists already.<br>';
	}


	$db_name = $cid."_organization";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`apply` int(11) DEFAULT NULL,
			`company` int(11) DEFAULT NULL,
			`locations` varchar(11) COLLATE utf8_bin DEFAULT NULL,
			`divisions` varchar(11) COLLATE utf8_bin DEFAULT NULL,
			`departments` varchar(11) COLLATE utf8_bin DEFAULT NULL,
			`teams` varchar(11) COLLATE utf8_bin DEFAULT NULL,	
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Organization</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Organization</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Organization</b> exists already.<br>';
	}


	


	/*$db_name = $cid."_employee_allow_deduct";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`emp_id` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			`type` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			`allow_deduct_id` int(11) COLLATE utf8_bin DEFAULT NULL,
			`amount` varchar(55) COLLATE utf8_bin DEFAULT NULL,			
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Employee Allow Deduct</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Employee Allow Deduct</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Employee Allow Deduct</b> exists already.<br>';
	}*/


	$db_name = $cid."_groups";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`apply_group` varchar(11) COLLATE utf8_bin DEFAULT NULL,
			`code` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`th` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			`en` varchar(100) COLLATE utf8_bin DEFAULT NULL,			
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Groups</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Groups</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Groups</b> exists already.<br>';
	}
	
	$db_name = $cid."_divisions";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`apply_division` varchar(11) COLLATE utf8_bin DEFAULT NULL,
			`code` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`th` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			`en` varchar(100) COLLATE utf8_bin DEFAULT NULL,			
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Divisions</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Divisions</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Divisions</b> exists already.<br>';
	}


	$db_name = $cid."_parameters";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`apply_param` varchar(11) COLLATE utf8_bin DEFAULT NULL,
			`th` varchar(200) COLLATE utf8_bin DEFAULT NULL,
			`en` varchar(200) COLLATE utf8_bin DEFAULT NULL,			
			`note` text COLLATE utf8_bin DEFAULT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Parameters</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Parameters</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Parameters</b> exists already.<br>';
	}

	
	$db_name = $cid."_documents";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `filename` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `name` varchar(100) COLLATE utf8_bin DEFAULT NULL,
		  `month` int(11) DEFAULT NULL,
		  `year` int(11) DEFAULT NULL,
		  `size` varchar(20) DEFAULT NULL,
		  `type` varchar(10) COLLATE utf8_bin DEFAULT NULL,
		  `date` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `user_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `link` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  PRIMARY KEY (`id`) 
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Documents</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Documents</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Documents</b> exists already.<br>';
	}
	
	$db_name = $cid."_employees";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
			  `emp_id` varchar(20) COLLATE utf8_bin NOT NULL,
			  `emp_id_editable` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `sid` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			  `title` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			  `firstname` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			  `lastname` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			  `th_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			  `en_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			  `birthdate` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			  `nationality` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			  `gender` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			  `maritial` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			  `religion` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			  `military_status` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			  `height` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			  `weight` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			  `bloodtype` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			  `drvlicense_nr` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			  `drvlicense_exp` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			  `idcard_nr` varchar(30) COLLATE utf8_bin DEFAULT NULL,
			  `idcard_exp` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			  `tax_id` varchar(30) COLLATE utf8_bin DEFAULT NULL,
			  `tax_id_check` varchar(30) COLLATE utf8_bin DEFAULT NULL,
			  `sso_id` varchar(30) COLLATE utf8_bin DEFAULT NULL,
			  `sso_id_check` varchar(30) COLLATE utf8_bin DEFAULT NULL,
			  `reg_address` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			  `cur_address` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			  `sub_district` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			  `district` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			  `province` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			  `postnr` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			  `country` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			  `personal_phone` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			  `personal_email` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			  `work_phone` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			  `work_email` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			  `username_option` varchar(11) COLLATE utf8_bin DEFAULT NULL,
			  `username` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			  `peComm` varchar(11) COLLATE utf8_bin DEFAULT NULL,
			  `weComm` varchar(11) COLLATE utf8_bin DEFAULT NULL,
			  `emergency_contacts` text COLLATE utf8_bin DEFAULT NULL,
			  `hospitals` text COLLATE utf8_bin DEFAULT NULL,
			  `joining_date` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			  `probation_date` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			  `entity` varchar(5) COLLATE utf8_bin DEFAULT NULL,
			  `branch` varchar(5) COLLATE utf8_bin DEFAULT NULL,
			  `division` varchar(5) COLLATE utf8_bin DEFAULT NULL,
			  `department` varchar(5) COLLATE utf8_bin DEFAULT NULL,
			  `groups` varchar(5) COLLATE utf8_bin DEFAULT NULL,
			  `team` varchar(5) COLLATE utf8_bin DEFAULT NULL,
			  `organization` varchar(5) COLLATE utf8_bin DEFAULT NULL,
			  `emp_type` varchar(1) COLLATE utf8_bin DEFAULT NULL,
			  `resign_date` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			  `resign_reason` text COLLATE utf8_bin DEFAULT NULL,
			  `emp_status` varchar(1) COLLATE utf8_bin DEFAULT NULL,
			  `account_code` int(11) DEFAULT NULL,
			  `position` int(11) DEFAULT NULL,
			  `head_branch` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			  `head_division` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			  `head_department` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			  `line_manager` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			  `team_supervisor` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			  `date_position` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			  `shift_team` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			  `time_reg` varchar(1) COLLATE utf8_bin DEFAULT NULL,
			  `selfie` varchar(1) COLLATE utf8_bin DEFAULT NULL,
			  `annual_leave` int(11) DEFAULT NULL,
			  `leave_approve` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			  `notice_date` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			  `remaining_salary` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `notice_payment` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `paid_leave` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `severance` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `other_income` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `remarks` text COLLATE utf8_bin DEFAULT NULL,
			  `attachments` text COLLATE utf8_bin DEFAULT NULL,
			  `shiftplan` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			  `pay_type` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			  `start_date` date DEFAULT NULL,
			  `unit_base` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			  `payroll_modal_value` varchar(11) COLLATE utf8_bin DEFAULT NULL,
			  `bank_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			  `bank_code` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			  `bank_account` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			  `bank_branch` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			  `bank_account_name` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			  `bank_transfer` int(11) DEFAULT NULL,
			  `base_salary` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `day_rate` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `hour_rate` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `contract_type` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			  `calc_base` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			  `gov_house_banking` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `savings` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `legal_execution` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `kor_yor_sor` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `month_payroll` varchar(11) COLLATE utf8_bin DEFAULT NULL,
			  `calc_on_sd` int(11) DEFAULT NULL,
			  `calc_on_pc` int(11) DEFAULT NULL,
			  `calc_on_pf` int(11) DEFAULT NULL,
			  `calc_on_ssf` int(11) DEFAULT NULL,
			  `unit_parent` int(11) DEFAULT NULL,
			  `unit_parentinLaw` int(11) DEFAULT NULL,
			  `unit_care` int(11) DEFAULT NULL,
			  `unit_Chicare` int(11) DEFAULT NULL,
			  `unit_ChiBiocare` int(11) DEFAULT NULL,
			  `unit_Chiadcare` int(11) DEFAULT NULL,
			  `tax_standard_deduction` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_personal_allowance` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_spouse` varchar(5) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_spouse` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_parents` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_parents` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_parents_inlaw` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_parents_inlaw` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_child_bio_2018` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_child_bio_2018` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_child_adopted` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_child_adopted` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_child_bio` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_child_bio` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_child_birth` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_disabled_person` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_disabled_person` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_home_loan_interest` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_first_home` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_donation_charity` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_donation_education` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_donation_flood` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_own_health` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_health_parents` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_health_parents` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_own_life_insurance` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_life_insurance_spouse` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_pension_fund` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_rmf` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_ltf` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_exemp_disabled_under` varchar(5) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_exemp_disabled_under` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_exemp_payer_older` varchar(5) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_exemp_payer_older` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_domestic_tour` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_year_end_shopping` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_other` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `emp_tax_deductions` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `total_tax_deductions` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_nsf` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_pvf` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_allow_sso` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `former_salary_rate` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `income_current_year` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `tax_paid_current_year` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `pvf_nr` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			  `pvf_reg_date` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			  `calc_pvf` varchar(1) COLLATE utf8_bin DEFAULT NULL,
			  `perc_thb_pvf` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `contri_emple_pvf` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `contri_emplyer_pvf` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `pro_fndNo_pvf` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			  `reg_date_pvf` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `pvf_rate_emp` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `pvf_rate_com` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `pvf_prev_years_emp` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `pvf_prev_years_com` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `calc_psf` varchar(1) COLLATE utf8_bin DEFAULT NULL,
			  `perc_thb_psf` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `contri_emple_psf` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `contri_emplyer_psf` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `psf_rate_emp` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `psf_rate_com` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `psf_prev_years_emp` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `psf_prev_years_com` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `calc_sso` varchar(1) COLLATE utf8_bin DEFAULT NULL,
			  `sso_by` varchar(1) COLLATE utf8_bin DEFAULT NULL,
			  `calc_tax` varchar(1) COLLATE utf8_bin DEFAULT NULL,
			  `tax_residency_status` varchar(11) COLLATE utf8_bin DEFAULT NULL,
			  `income_section` varchar(11) COLLATE utf8_bin DEFAULT NULL,
			  `calc_method` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			  `modify_tax` varchar(55) COLLATE utf8_bin DEFAULT NULL,
			  `image` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			  `att_idcard` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			  `att_housebook` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			  `attach1` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			  `attach2` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			  `attach3` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			  `attach4` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			  `att_bankbook` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			  `att_contract` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			  `attach5` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			  `attach6` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			  `attach7` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			  `attach8` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			  `pr_calculation` varchar(5) COLLATE utf8_bin DEFAULT NULL,
			  `allow_login` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			  `log_status` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			  `pr_status` int(11) DEFAULT NULL,
			  `print_payslip` varchar(5) COLLATE utf8_bin DEFAULT NULL,
			  `issued` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			  `med_contact` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			  `med_phone` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			  `med_smoker` varchar(5) COLLATE utf8_bin DEFAULT NULL,
			  `med_alert` tinytext COLLATE utf8_bin DEFAULT NULL,
			  `med_allergies` tinytext COLLATE utf8_bin DEFAULT NULL,
			  `med_disabilities` tinytext COLLATE utf8_bin DEFAULT NULL,
			  `med_medication` tinytext COLLATE utf8_bin DEFAULT NULL,
			  `med_attachments` text COLLATE utf8_bin DEFAULT NULL,
			  `sso_hospital` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			  `pnd` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			  `teams` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			  `team_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,  
			  `latitude` varchar(255) COLLATE utf8_bin DEFAULT NULL,  
			  `longitude` varchar(255) COLLATE utf8_bin DEFAULT NULL,  
			  `workFromHome` varchar(255) COLLATE utf8_bin DEFAULT NULL,  
			  `ping_expire` varchar(255) COLLATE utf8_bin DEFAULT NULL,  
			  `same_as_id` varchar(55) COLLATE utf8_bin DEFAULT NULL,
              
            PRIMARY KEY (`emp_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Employees</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Employees</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Employees</b> exists already.<br>';
	}
	
	$db_name = $cid."_employee_assets";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`emp_id` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`asset` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`description` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`reference` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`assign_date` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`return_date` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`value` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`cost` varchar(20) DEFAULT NULL,
			`paidby` int(11) DEFAULT NULL,
			`remarks` text COLLATE utf8_bin DEFAULT NULL,
			`attachments` text COLLATE utf8_bin DEFAULT NULL,			
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Employee assets</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Employee assets</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Employee assets</b> exists already.<br>';
	}
	
	$db_name = $cid."_employee_career";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`month` varchar(11) COLLATE utf8_bin DEFAULT NULL,
			`emp_id` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`position` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			`fix_allow` text COLLATE utf8_bin DEFAULT NULL,
			`fix_deduct` text COLLATE utf8_bin DEFAULT NULL,
			`start_date` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`end_date` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`salary` varchar(20) DEFAULT NULL,
			`other_benifits` text COLLATE utf8_bin DEFAULT NULL,
			`remarks` text COLLATE utf8_bin DEFAULT NULL,
			`attachments` text COLLATE utf8_bin DEFAULT NULL,
			`head_branch` varchar(100) DEFAULT NULL,
			`head_division` varchar(100) DEFAULT NULL,
			`head_department` varchar(100) DEFAULT NULL,
			`team_supervisor` varchar(100) DEFAULT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Employee career</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Employee career</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Employee career</b> exists already.<br>';
	}
	
	$db_name = $cid."_employee_discipline";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`emp_id` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`date` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`status` int(11) DEFAULT NULL,
			`warning` int(11) DEFAULT NULL,
			`violation` int(11) DEFAULT NULL,
			`infraction` text COLLATE utf8_bin DEFAULT NULL,
			`damage` varchar(20) DEFAULT NULL,
			`improvement` text COLLATE utf8_bin DEFAULT NULL,
			`consequences` text COLLATE utf8_bin DEFAULT NULL,
			`employee` text COLLATE utf8_bin DEFAULT NULL,
			`employer` text COLLATE utf8_bin DEFAULT NULL,
			`witness` text COLLATE utf8_bin DEFAULT NULL,
			`attachments` text COLLATE utf8_bin DEFAULT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Employee discipline</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Employee discipline</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Employee discipline</b> exists already.<br>';
	}
	
	$db_name = $cid."_employee_equipment";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`emp_id` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`asset` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`description` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`reference` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`assign_date` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`return_date` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`cost` varchar(20) DEFAULT NULL,
			`paidby` int(11) DEFAULT NULL,
			`remarks` text COLLATE utf8_bin DEFAULT NULL,
			`attachments` text COLLATE utf8_bin DEFAULT NULL,		
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Employee equipment</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Employee equipment</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Employee equipment</b> exists already.<br>';
	}
	
	$db_name = $cid."_employee_events";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`emp_id` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`date` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`completed` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`event` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`hours` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			`certification` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`cost` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			`remarks` text COLLATE utf8_bin DEFAULT NULL,
			`attachments` text COLLATE utf8_bin DEFAULT NULL,		
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Employee events</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Employee events</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Employee events</b> exists already.<br>';
	}
	
	$db_name = $cid."_employee_log";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
			`emp_id` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`field` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`prev` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`new` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`user` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`date` timestamp DEFAULT NULL DEFAULT current_timestamp(),
		PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Employee log</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Employee log</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Employee log</b> exists already.<br>';
	}	

	$db_name = $cid."_temp_log_history";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
			`batch_team` text COLLATE utf8_bin DEFAULT NULL,
			`batch_data` text COLLATE utf8_bin DEFAULT NULL,
			`field` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`prev` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`new` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`emp_id` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`en_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`batch_no` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`batch_team_codes` text COLLATE utf8_bin DEFAULT NULL,
			`user` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`user_id` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`date` datetime NOT NULL DEFAULT current_timestamp(),
			`import_type` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`invalid_value` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`no_change` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`updated_to_empreg` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`missing_info` varchar(50) COLLATE utf8_bin DEFAULT NULL,

		PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Employee Temp log</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Employee Temp log</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Employee Temp log</b> exists already.<br>';
	}


	$db_name = $cid."_employee_medical";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
			`emp_id` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`date` date DEFAULT NULL,
			`date_from` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`date_until` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`emp_condition` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`certificate` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			`doctor` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			`remarks` text COLLATE utf8_bin DEFAULT NULL,
			`attachments` text COLLATE utf8_bin DEFAULT NULL,
		PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Employee medical</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Employee medical</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Employee medical</b> exists already.<br>';
	}
	
	$db_name = $cid."_employee_privileges";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
			`emp_id` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`date` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`completed` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`privilege` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`hours` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			`certification` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`cost` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			`remarks` text COLLATE utf8_bin DEFAULT NULL,
			`attachments` text COLLATE utf8_bin DEFAULT NULL,
		PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Employee privileges</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Employee privileges</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Employee privileges</b> exists already.<br>';
	}
	
	$db_name = $cid."_employee_training";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
			`emp_id` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`date` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`completed` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`training` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`hours` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			`certification` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`cost` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			`remarks` text COLLATE utf8_bin DEFAULT NULL,
			`attachments` text COLLATE utf8_bin DEFAULT NULL,
		PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Employee training</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Employee training</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Employee training</b> exists already.<br>';
	}
	
	
	
	$db_name = $cid."_entities_data";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
		  	`ref` int(11) NOT NULL AUTO_INCREMENT,
			`apply_company` varchar(11) COLLATE utf8_bin DEFAULT NULL,
			`code` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`th` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`en` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`en_compname` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`th_compname` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`comp_phone` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`comp_fax` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`comp_email` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`tax_id` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`revenu_branch` text COLLATE utf8_bin DEFAULT NULL,
			`sso_account` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`sso_codes` text COLLATE utf8_bin DEFAULT NULL,
			`banks` text COLLATE utf8_bin DEFAULT NULL,
			`logofile` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`dig_stamp` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			`digi_stamp` int(11) DEFAULT NULL,
			`dig_signature` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			`digi_signature` int(11) DEFAULT NULL,
			`th_address` text COLLATE utf8_bin DEFAULT NULL,
			`en_address` text COLLATE utf8_bin DEFAULT NULL,
			`th_addr_detail` text COLLATE utf8_bin DEFAULT NULL,
			`en_addr_detail` text COLLATE utf8_bin DEFAULT NULL,
			`bus_reg` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			`comp_affi` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			`house_reg` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			`vat_reg` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			`socsec_fund` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			`bankbook` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			`passfs` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			`paw_tax` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`attach1` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`attach2` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`attach3` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			PRIMARY KEY (`ref`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Entities data</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Entities data</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Entities data</b> exists already.<br>';
	}
	
	$db_name = $cid."_historic_data";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
		  `id` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`emp_id` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`month` int(11) DEFAULT NULL,
			`emp_name_en` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`emp_name_th` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`entity` varchar(5) COLLATE utf8_bin DEFAULT NULL,
			`branch` varchar(5) COLLATE utf8_bin DEFAULT NULL,
			`division` varchar(5) COLLATE utf8_bin DEFAULT NULL,
			`department` varchar(5) COLLATE utf8_bin DEFAULT NULL,
			`team` varchar(5) COLLATE utf8_bin DEFAULT NULL,
			`emp_group` varchar(5) COLLATE utf8_bin DEFAULT NULL,
			`position` varchar(5) COLLATE utf8_bin DEFAULT NULL,
			`salary` varchar(20) DEFAULT NULL,
			`ot1b` varchar(20) DEFAULT NULL,
			`ot15b` varchar(20) DEFAULT NULL,
			`ot2b` varchar(20) DEFAULT NULL,
			`ot3b` varchar(20) DEFAULT NULL,
			`ootb` varchar(20) DEFAULT NULL,
			`total_otb` varchar(20) DEFAULT NULL,
			`fix_allow_1` varchar(20) DEFAULT NULL,
			`fix_allow_2` varchar(20) DEFAULT NULL,
			`fix_allow_3` varchar(20) DEFAULT NULL,
			`fix_allow_4` varchar(20) DEFAULT NULL,
			`fix_allow_5` varchar(20) DEFAULT NULL,
			`fix_allow_6` varchar(20) DEFAULT NULL,
			`fix_allow_7` varchar(20) DEFAULT NULL,
			`fix_allow_8` varchar(20) DEFAULT NULL,
			`fix_allow_9` varchar(20) DEFAULT NULL,
			`fix_allow_10` varchar(20) DEFAULT NULL,
			`var_allow_1` varchar(20) DEFAULT NULL,
			`var_allow_2` varchar(20) DEFAULT NULL,
			`var_allow_3` varchar(20) DEFAULT NULL,
			`var_allow_4` varchar(20) DEFAULT NULL,
			`var_allow_5` varchar(20) DEFAULT NULL,
			`var_allow_6` varchar(20) DEFAULT NULL,
			`var_allow_7` varchar(20) DEFAULT NULL,
			`var_allow_8` varchar(20) DEFAULT NULL,
			`var_allow_9` varchar(20) DEFAULT NULL,
			`var_allow_10` varchar(20) DEFAULT NULL,
			`total_fix_allow` varchar(20) DEFAULT NULL,
			`total_var_allow` varchar(20) DEFAULT NULL,
			`total_tax_allow` varchar(20) DEFAULT NULL,
			`tax_by_company` varchar(20) DEFAULT NULL,
			`sso_by_company` varchar(20) DEFAULT NULL,
			`other_income` varchar(20) DEFAULT NULL,
			`social` varchar(20) DEFAULT NULL,
			`social_com` varchar(20) DEFAULT NULL,
			`pvf_employee` varchar(20) DEFAULT NULL,
			`pvf_employer` varchar(20) DEFAULT NULL,
			`psf_employee` varchar(20) DEFAULT NULL,
			`tot_deduct_before` varchar(20) DEFAULT NULL,
			`tot_deduct_after` varchar(20) DEFAULT NULL,
			`tot_deductions` varchar(20) DEFAULT NULL,
			`tax` varchar(20) DEFAULT NULL,
			`tot_fix_income` varchar(20) DEFAULT NULL,
			`tot_var_income` varchar(20) DEFAULT NULL,
			`gross_income` varchar(20) DEFAULT NULL,
			`net_income` varchar(20) DEFAULT NULL,
			`paid` varchar(5) COLLATE utf8_bin DEFAULT NULL DEFAULT 'H',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Historic data</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Historic data</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Historic data</b> exists already.<br>';
	}
	
	$db_name = $cid."_leaves";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`emp_id` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`phone` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`entity` int(11) DEFAULT NULL,
			`branch` int(11) DEFAULT NULL,
			`division` int(11) DEFAULT NULL,
			`department` int(11) DEFAULT NULL,
			`team` int(11) DEFAULT NULL,
			`emp_group` varchar(5) COLLATE utf8_bin DEFAULT NULL,
			`leave_type` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`planned` int(11) DEFAULT NULL,
			`paid` int(11) DEFAULT NULL,
			`start` date DEFAULT NULL,
			`end` date DEFAULT NULL,
			`days` varchar(20) DEFAULT NULL,
			`details` text COLLATE utf8_bin DEFAULT NULL,
			`status` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`comment` text COLLATE utf8_bin DEFAULT NULL,
			`reason` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`certificate` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`attach` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			`created` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`created_by` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`updated` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`updated_by` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`approved` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`approved_by` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`rejected` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`rejected_by` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`canceled` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`canceled_by` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`log` int(11) DEFAULT NULL DEFAULT 1,
		  PRIMARY KEY (`id`) 
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Leaves</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Leaves</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Leaves</b> exists already.<br>';
	}
	
	$db_name = $cid."_leaves_data";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
			`leave_id` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`emp_id` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`phone` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`entity` int(11) DEFAULT NULL,
			`branch` int(11) DEFAULT NULL,
			`division` int(11) DEFAULT NULL,
			`department` int(11) DEFAULT NULL,
			`team` int(11) DEFAULT NULL,
			`emp_group` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`leave_type` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`days` varchar(20) DEFAULT NULL,
			`day` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`half` int(11) DEFAULT NULL,
			`date` date DEFAULT NULL,
			`hours` varchar(20) DEFAULT NULL,
			`reason` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`planned` int(11) DEFAULT NULL,
			`paid` int(11) DEFAULT NULL,
			`status` varchar(5) COLLATE utf8_bin DEFAULT NULL,
			`certificate` int(11) DEFAULT NULL DEFAULT 1,
			`lock` int(11) DEFAULT NULL,
		  PRIMARY KEY (`id`) 
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Leaves data</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Leaves data</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Leaves data</b> exists already.<br>';
	}
	
	$db_name = $cid."_monthly_shiftplans_".$year;
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
		  `id` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `month` varchar(5) COLLATE utf8_bin DEFAULT NULL,
		  `emp_id` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `sid` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `en_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `th_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `shiftteam` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `shiftteam_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `wkd` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `pub` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `off` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `vod` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `off_day_used` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `bal_off` text COLLATE utf8_bin DEFAULT NULL,
		  `D1` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D2` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D3` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D4` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D5` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D6` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D7` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D8` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D9` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D10` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D11` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D12` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D13` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D14` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D15` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D16` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D17` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D18` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D19` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D20` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D21` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D22` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D23` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D24` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D25` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D26` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D27` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D28` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D29` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D30` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `D31` varchar(20) COLLATE utf8_bin DEFAULT NULL, 
		  PRIMARY KEY (`id`) 
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Monthly shiftplans</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Monthly shiftplans</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Monthly shiftplans</b> exists already.<br>';
	}


	$db_name = $cid."_payroll_".$year;
	if(!$dbc->query("DESCRIBE `$db_name`")) { 
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `emp_id` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `month` int(11) DEFAULT NULL,
		  `payroll_modal_id` varchar(11) DEFAULT NULL,
		  `emp_name_en` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `emp_name_th` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `entity` varchar(5) COLLATE utf8_bin DEFAULT NULL,
		  `branch` varchar(5) COLLATE utf8_bin DEFAULT NULL,
		  `division` varchar(5) COLLATE utf8_bin DEFAULT NULL,
		  `department` varchar(5) COLLATE utf8_bin DEFAULT NULL,
		  `team` varchar(5) COLLATE utf8_bin DEFAULT NULL,
		  `position` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `basic_salary` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `salary` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `fix_allow_from_emp` longtext COLLATE utf8_bin DEFAULT NULL,
		  `fix_deduct_from_emp` longtext COLLATE utf8_bin DEFAULT NULL,
		  `incomeCalc_yesno` longtext COLLATE utf8_bin DEFAULT NULL,
		  `incomeCalc_manual` longtext COLLATE utf8_bin DEFAULT NULL,
		  `incomeCalc_total` longtext COLLATE utf8_bin DEFAULT NULL,
		  `hrs_curr_wages` longtext COLLATE utf8_bin DEFAULT NULL,
		  `hrs_prev_wages` longtext COLLATE utf8_bin DEFAULT NULL,
		  `times_curr_wages` longtext COLLATE utf8_bin DEFAULT NULL,
		  `rate_wages` longtext COLLATE utf8_bin DEFAULT NULL,
		  `thb_wages` longtext COLLATE utf8_bin DEFAULT NULL,
		  `paid_days` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `paid_days_manual` varchar(11) COLLATE utf8_bin DEFAULT NULL,
		  `paid_days_curr` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `paid_days_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `paid_hours` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `day_daily_wage` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `rate_hr` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `mf_paid_hour` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `mf_salary` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `manual_feed_data` text COLLATE utf8_bin DEFAULT NULL,
		  `manual_feed_total` text COLLATE utf8_bin DEFAULT NULL,
		  `salary_group_total` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `overtime_group_total` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `fix_income_group_total` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `var_income_group_total` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `other_income_group_total` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `absence_group_total` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `fix_ded_group_total` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `var_ded_group_total` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `other_ded_group_total` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `legal_ded_group_total` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `advance_pay_group_total` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_earnings` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_deductions` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_pnd1` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_sso` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_pvf` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_psf` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_tax_income` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_tax_fixpro` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_tax_fix` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_tax_var` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_tax_nontax` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_of_alltax` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `salary_group_total_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `overtime_group_total_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `fix_income_group_total_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `var_income_group_total_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `other_income_group_total_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `absence_group_total_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `fix_ded_group_total_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `var_ded_group_total_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `other_ded_group_total_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `legal_ded_group_total_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `advance_pay_group_total_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_earnings_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_deductions_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_pnd1_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_sso_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_pvf_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_psf_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_tax_income_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_tax_fixpro_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_tax_fix_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_tax_var_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_tax_nontax_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_of_alltax_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `fixed_prorated_yearly` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `fixed_yearly` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `fixed_actual_prorated_yearly` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `fixed_actual_yearly` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `variable_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `variable_curr` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `income_YTD` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `paid_leave` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `modify_tax` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `paid` varchar(5) COLLATE utf8_bin DEFAULT NULL,
		  `tax_calculation` text COLLATE utf8_bin DEFAULT NULL,
		  `calc_tax` varchar(5) COLLATE utf8_bin DEFAULT NULL,
		  `calc_sso` varchar(5) COLLATE utf8_bin DEFAULT NULL,
		  `sso_by` varchar(11) COLLATE utf8_bin DEFAULT NULL,
		  `calc_pvf` varchar(5) COLLATE utf8_bin DEFAULT NULL,
		  `calc_psf` varchar(11) COLLATE utf8_bin DEFAULT NULL,
		  `calc_method` varchar(5) COLLATE utf8_bin DEFAULT NULL,
		  `sso_emp_calc` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `sso_emp_manual` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `sso_employee` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `sso_comp_calc` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `sso_comp_manual` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `sso_company` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `perc_thb_pvf` varchar(11) COLLATE utf8_bin DEFAULT NULL,
		  `pvf_rate_emp` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `pvf_rate_com` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `pvf_emp_calc` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `pvf_emp_manual` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `pvf_employee` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `pvf_comp_calc` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `pvf_comp_manual` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `pvf_company` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `perc_thb_psf` varchar(11) COLLATE utf8_bin DEFAULT NULL,
		  `psf_rate_emp` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `psf_rate_com` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `psf_emp_calc` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `psf_emp_manual` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `psf_employee` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `psf_comp_calc` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `psf_comp_manual` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `psf_company` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `contract_type` varchar(10) COLLATE utf8_bin DEFAULT NULL,
		  `calc_base` varchar(10) COLLATE utf8_bin DEFAULT NULL,
		  `calc_on_sd` varchar(11) COLLATE utf8_bin DEFAULT NULL,
		  `calc_on_pc` varchar(11) COLLATE utf8_bin DEFAULT NULL,
		  `calc_on_pf` varchar(11) COLLATE utf8_bin DEFAULT NULL,
		  `calc_on_ssf` varchar(11) COLLATE utf8_bin DEFAULT NULL,
		  `tax_standard_deduction` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `standard_deduction_manual` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `standard_deduction_total` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `tax_personal_allowance` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `personal_care_manual` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `personal_care_total` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `tax_allow_pvf` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `allow_pvf_manual` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `allow_pvf_total` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `tax_allow_sso` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `allow_sso_manual` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `allow_sso_total` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `total_other_tax_deductions` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_yearly_tax_deductions` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `other_income` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `severance` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `notice_payment` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `remaining_salary` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `gov_house_banking` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `savings` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `legal_execution` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `kor_yor_sor` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `tax_by_company` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `sso_by_company` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `sso_by_company_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `sso_employee_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `pvf_employee_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `psf_employee_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `full_year_salary_grp` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `full_year_overtime_grp` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `full_year_fixincome_grp` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `full_year_varincome_grp` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `full_year_othincome_grp` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `full_year_absence_grp` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `full_year_fixded_grp` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `full_year_varded_grp` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `full_year_othded_grp` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `full_year_legal_grp` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `full_year_advpay_grp` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `full_year_fixprorated` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `full_year_fixed` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `full_year_var` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `full_year_taxableincome` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `full_year_non_taxable` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `full_year_sso_employee` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `full_year_sso_by_company` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `full_year_pvf_employee` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `full_year_psf_employee` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `full_year_pnd` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `full_year_sso` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `full_year_pvf` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `full_year_psf` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `full_year_earnings` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `full_year_deductions` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `acm_fix` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `acm_fix_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `acm_fix_prev_var` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `cam_fix` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `cam_fix_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `cam_fix_prev_var` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `ytd_income` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `acm_fix_tax_calc` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `acm_fix_prev_tax_calc` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `acm_fix_prev_var_tax_calc` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `cam_fix_tax_calc` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `cam_fix_prev_tax_calc` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `cam_fix_prev_var_tax_calc` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `tax_ytd` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_tax_year` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `tax_previous` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `tax_remaining` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `tax_fix_month` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `tax_var_month` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `tax_this_month` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `tax_next_month` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `tax_tot_next_month` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_net_income` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_net_income_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `fullyear_net_income` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_net_pay` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `total_net_pay_prev` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  `fullyear_net_pay` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Payroll '.$year.'</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Payroll '.$year.'</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Payroll '.$year.'</b> exists already.<br>';
	}


	$db_name = $cid."_payroll_data_".$year;
	if(!$dbc->query("DESCRIBE `$db_name`")) { 
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
		  `ids` int(11) NOT NULL AUTO_INCREMENT,
		  `months` varchar(11) DEFAULT NULL,
		  `payroll_modal_ids` varchar(11) DEFAULT NULL,
		  `emp_ids` varchar(55) DEFAULT NULL,
		  `allow_deduct_ids` varchar(11) DEFAULT NULL,
		  `classifications` varchar(11) DEFAULT NULL,
		  `groups` varchar(55) DEFAULT NULL,
		  `tax_base` varchar(55) DEFAULT NULL,
		  `pnd` varchar(55) DEFAULT NULL,
		  `sso` varchar(55) DEFAULT NULL,
		  `hrs` varchar(55) DEFAULT NULL,
		  `pvf` varchar(55) DEFAULT NULL,
		  `psf` varchar(55) DEFAULT NULL,
		  `curr_calc` varchar(55) DEFAULT NULL,
		  `prev_calc` varchar(55) DEFAULT NULL,
		  `curr_month` varchar(55) DEFAULT NULL,
		  `jan` varchar(55) DEFAULT NULL,
		  `feb` varchar(55) DEFAULT NULL,
		  `mar` varchar(55) DEFAULT NULL,
		  `apr` varchar(55) DEFAULT NULL,
		  `may` varchar(55) DEFAULT NULL,
		  `jun` varchar(55) DEFAULT NULL,
		  `jul` varchar(55) DEFAULT NULL,
		  `aug` varchar(55) DEFAULT NULL,
		  `sep` varchar(55) DEFAULT NULL,
		  `oct` varchar(55) DEFAULT NULL,
		  `nov` varchar(55) DEFAULT NULL,
		  `dec` varchar(55) DEFAULT NULL,
		  `datetime` datetime DEFAULT NULL,
		  PRIMARY KEY (`ids`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Payroll Data '.$year.'</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Payroll Data '.$year.'</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Payroll Data '.$year.'</b> exists already.<br>';
	}

	
	$db_name = $cid."_payroll_months";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
			`month` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`sal_start` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`sal_end` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`time_start` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`time_end` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`leave_start` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`leave_end` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`payroll_start` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`payroll_end` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`paydate` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`formdate` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`sso_eRate` varchar(20) DEFAULT NULL,
			`sso_eMax` varchar(20) DEFAULT NULL,
			`sso_eMin` varchar(20) DEFAULT NULL,
			`sso_cRate` varchar(20) DEFAULT NULL,
			`sso_cMax` varchar(20) DEFAULT NULL,
			`sso_cMin` varchar(20) DEFAULT NULL,
			`wht` varchar(20) DEFAULT NULL,
			`base30` varchar(20) DEFAULT NULL,
			`caldays` varchar(20) DEFAULT NULL,
			`workdays` varchar(20) DEFAULT NULL,
			`form_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`form_position` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`sso_act_max` varchar(10) COLLATE utf8_bin DEFAULT NULL DEFAULT 'max',
			`locked` int(11) DEFAULT NULL,
			`status` int(11) DEFAULT NULL,
			`accounting` text COLLATE utf8_bin DEFAULT NULL,
			`var_allowances` text COLLATE utf8_bin DEFAULT NULL,
			`compensations` text COLLATE utf8_bin DEFAULT NULL, 
			`payroll_opt` varchar(10) COLLATE utf8_bin DEFAULT NULL, 
			`salary_split` varchar(10) COLLATE utf8_bin DEFAULT NULL, 
			`paid` text COLLATE utf8_bin DEFAULT NULL, 
			`allowDeductEmpRegFixed` longtext COLLATE utf8_bin DEFAULT NULL, 
			`allowDeductEmpRegManual` longtext COLLATE utf8_bin DEFAULT NULL, 
			`sso_rates_for_month` longtext COLLATE utf8_bin DEFAULT NULL, 
		  PRIMARY KEY (`month`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Payroll months</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Payroll months</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Payroll months</b> exists already.<br>';
	}

	$db_name = $cid."_payroll_parameters_".$year;
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `pr_modal_id` varchar(11) DEFAULT NULL,
		  `month` varchar(11) DEFAULT NULL,
		  `itemid` int(11) DEFAULT NULL,
		  `groups` varchar(11) DEFAULT NULL,
		  `tax_base` varchar(11) DEFAULT NULL,
		  `pnd` varchar(11) DEFAULT NULL,
		  `sso` varchar(11) DEFAULT NULL,
		  `pvfpsf` varchar(11) DEFAULT NULL,
		  `allowopt` varchar(255) DEFAULT NULL,
		  `calcOpt` varchar(11) DEFAULT NULL,
		  `multiplicator` varchar(11) DEFAULT NULL,
		  `nrdays` varchar(55) DEFAULT NULL,
		  `nrhrs` varchar(55) DEFAULT NULL,
		  `income_base` text DEFAULT NULL,
		  `thbunit` varchar(55) DEFAULT NULL,
		  `unitarr` varchar(11) DEFAULT NULL,
		PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Payroll Parameters</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Payroll Parameters</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Payroll Parameters</b> exists already.<br>';
	}


	$db_name = $cid."_payroll_overview_".$year;
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
	    `id` int(11) NOT NULL AUTO_INCREMENT,
		`payroll_id` varchar(55) DEFAULT NULL,
		`month` varchar(11) DEFAULT NULL,
		`payroll_model_id` varchar(11) DEFAULT NULL,
		`status` varchar(11) DEFAULT NULL,
		`datetime` datetime NOT NULL DEFAULT current_timestamp(),
		PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Payroll Overview</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Payroll Overview</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Payroll Overview</b> exists already.<br>';
	}
	
	
	$db_name = $cid."_positions";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`code` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		`th` varchar(100) COLLATE utf8_bin DEFAULT NULL,
		`en` varchar(100) COLLATE utf8_bin DEFAULT NULL, 
		PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Positions</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Positions</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Positions</b> exists already.<br>';
	}
	
	$db_name = $cid."_scanfiles";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `date` date DEFAULT NULL,
		  `period` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `content` text COLLATE utf8_bin DEFAULT NULL,
		  `filename` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `import` int(11) DEFAULT NULL,
		  `status` int(11) DEFAULT NULL, 
		   `scansystem` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `in_out` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  PRIMARY KEY (`id`) 
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Scan files</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Scan files</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Scan files</b> exists already.<br>';
	}
	
	$db_name = $cid."_sys_settings";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
		  `id` int(11) DEFAULT NULL AUTO_INCREMENT,
			`cur_month` varchar(11) DEFAULT NULL,
			`cur_year` varchar(11) DEFAULT NULL,
			`get_deflt_parm` varchar(11) DEFAULT NULL,
			`years` text COLLATE utf8_bin DEFAULT NULL,
			`pr_startdate` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`sso_idnr` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`sso_act_max` varchar(5) COLLATE utf8_bin DEFAULT NULL,
			`tax_idnr` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`personal_idnr` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`fix_allow` text COLLATE utf8_bin DEFAULT NULL,
			`var_allow` text COLLATE utf8_bin DEFAULT NULL,
			`fix_deduct` text COLLATE utf8_bin DEFAULT NULL,
			`var_deduct` text COLLATE utf8_bin DEFAULT NULL,
			`paydate` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`att_cols` text COLLATE utf8_bin DEFAULT NULL,
			`att_showhide_cols` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`history` varchar(11) DEFAULT NULL,
			`his_cols` text COLLATE utf8_bin DEFAULT NULL,
			`his_showhide_cols` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`emp_export_fields` text COLLATE utf8_bin DEFAULT NULL,
			`payslip_template` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`payslip_field` text COLLATE utf8_bin DEFAULT NULL,
			`tab_default` longtext COLLATE utf8_bin DEFAULT NULL,
			`payslip_rate` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`show_address` int(11) DEFAULT NULL DEFAULT 1,
			`show_bankinfo` int(11) DEFAULT NULL DEFAULT 1,
			`show_position` int(11) DEFAULT NULL DEFAULT 1,
			`show_department` int(11) DEFAULT NULL DEFAULT 1,
			`support_email` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`account_codes` text COLLATE utf8_bin DEFAULT NULL,
			`account_allocations` text COLLATE utf8_bin DEFAULT NULL,
			`demo` varchar(11) DEFAULT NULL,
			`joining_date` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`emp_group` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`team` text COLLATE utf8_bin DEFAULT NULL,
			`shiftplan_schedule` text COLLATE utf8_bin DEFAULT NULL,
			`teams_name` text COLLATE utf8_bin DEFAULT NULL,
			`teams` text COLLATE utf8_bin DEFAULT NULL,
			`position` varchar(11) DEFAULT NULL,
			`date_start` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`shift_team` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`time_reg` varchar(11) DEFAULT NULL,
			`selfie` varchar(11) DEFAULT NULL,
			`leeve` varchar(11) DEFAULT NULL,
			`emp_type` varchar(11) DEFAULT NULL,
			`emp_status` varchar(11) DEFAULT NULL,
			`account_code` varchar(11) DEFAULT NULL,
			`pay_type` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`bank_transfer` varchar(11) DEFAULT NULL,
			`calc_tax` varchar(11) DEFAULT NULL,
			`calc_method` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`pnd` varchar(11) DEFAULT NULL,
			`calc_sso` varchar(11) DEFAULT NULL,
			`contract_type` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`calc_base` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`base_ot_rate` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`ot_rate` varchar(11) DEFAULT NULL,
			`payroll_modal_value` varchar(11) COLLATE utf8_bin DEFAULT NULL,
			`sso_defaults` longtext COLLATE utf8_bin DEFAULT NULL,
			`periods_defaults` longtext COLLATE utf8_bin DEFAULT NULL,
			`manualrates_default` longtext COLLATE utf8_bin DEFAULT NULL,
			`calc_psf` varchar(11) DEFAULT NULL,
			`psf_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`psf_rate_emp` varchar(11) DEFAULT NULL,
			`psf_rate_com` varchar(11) DEFAULT NULL,
			`psf_thb_emp` varchar(11) DEFAULT NULL,
			`psf_thb_com` varchar(11) DEFAULT NULL,
			`calc_pvf` varchar(11) DEFAULT NULL,
			`pvf_idnr` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`pvf_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`pvf_rate_emp` varchar(11) DEFAULT NULL,
			`auto_id` varchar(11) COLLATE utf8_bin DEFAULT NULL,
			`pvf_rate_com` varchar(11) DEFAULT NULL,
			`id_start` varchar(11) COLLATE utf8_bin DEFAULT NULL,
			`id_prefix` text COLLATE utf8_bin DEFAULT NULL,
			`scan_id` varchar(11) COLLATE utf8_bin DEFAULT NULL, 
			`empdata_cols` longtext COLLATE utf8_bin DEFAULT NULL,
			`empdata_showhide_cols` longtext COLLATE utf8_bin DEFAULT NULL,
			`modify_empdata_cols` longtext COLLATE utf8_bin DEFAULT NULL,
			`modify_empdata_showhide_cols` longtext COLLATE utf8_bin DEFAULT NULL,
			`payroll_empgroup_cols` longtext COLLATE utf8_bin DEFAULT NULL,
			`payroll_empgroup_showhide_cols` longtext COLLATE utf8_bin DEFAULT NULL,
			`Pmanualfeed_cols` longtext COLLATE utf8_bin DEFAULT NULL,
			`Pmanualfeed_showhide_cols` longtext COLLATE utf8_bin DEFAULT NULL,
			`employeeDataSectionShowHide` longtext COLLATE utf8_bin DEFAULT NULL,
			`employeeDataSectionShowHideCols` longtext COLLATE utf8_bin DEFAULT NULL,
			`modify_empdata_section_cols` longtext COLLATE utf8_bin DEFAULT NULL,
			`modify_empdata_section_showhide_cols` longtext COLLATE utf8_bin DEFAULT NULL,
			`common_save_check` text COLLATE utf8_bin DEFAULT NULL,
		    `same_as_id` text COLLATE utf8_bin DEFAULT NULL,
	        `idcard_nr` text COLLATE utf8_bin DEFAULT NULL,
	        `sso_id` text COLLATE utf8_bin DEFAULT NULL,
	        `tax_id` text COLLATE utf8_bin DEFAULT NULL,
	        `tax_id_check` text COLLATE utf8_bin DEFAULT NULL,
	        `sso_id_check` text COLLATE utf8_bin DEFAULT NULL,
	        `work_days_per_week` varchar(11) COLLATE utf8_bin DEFAULT NULL,
	        `checked_days` text COLLATE utf8_bin DEFAULT NULL,
	        `input_hours` text COLLATE utf8_bin DEFAULT NULL,
	
            PRIMARY KEY (`id`) 
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>System settings</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>System settings</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>System settings</b> exists already.<br>';
	}
	
	$db_name = $cid."_tax_simulation";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
			`emp_id` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`en_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`th_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`basic_salary` varchar(20) DEFAULT NULL,
			`fix_allow` varchar(20) DEFAULT NULL,
			`year_bonus` varchar(20) DEFAULT NULL,
			`avg_var_allow` varchar(20) DEFAULT NULL,
			`avg_overtime` varchar(20) DEFAULT NULL,
			`pvf_rate_emp` varchar(20) DEFAULT NULL,
			`pvf_rate_com` varchar(20) DEFAULT NULL,
			`pvf_rate_empr` varchar(20) DEFAULT NULL,
			`tax_deductions` varchar(20) DEFAULT NULL,
			`modify_tax` varchar(20) DEFAULT NULL,
			`calc_method` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`calc_sso` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`calc_pvf` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`calc_tax` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`gross_income_year` varchar(20) DEFAULT NULL,
			`taxable_gross` varchar(20) DEFAULT NULL,
			`pers_tax_deduct_gross` varchar(20) DEFAULT NULL,
			`pers_tax_deduct_net` varchar(20) DEFAULT NULL,
			`net_income_year` varchar(20) DEFAULT NULL,
			`taxable_net` varchar(20) DEFAULT NULL,
			`calculate_gross` text COLLATE utf8_bin DEFAULT NULL,
			`net_from_gross` text COLLATE utf8_bin DEFAULT NULL,
			`calculate_net` text COLLATE utf8_bin DEFAULT NULL,
			`gross_from_net` text COLLATE utf8_bin DEFAULT NULL,
			`calculate_current` text COLLATE utf8_bin DEFAULT NULL,
			PRIMARY KEY (`emp_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Tax simulation</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Tax simulation</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Tax simulation</b> exists already.<br>';
	}
	
	$db_name = $cid."_teams";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`apply_team` varchar(11) COLLATE utf8_bin DEFAULT NULL,
		`code` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		`th` varchar(100) COLLATE utf8_bin DEFAULT NULL,
		`en` varchar(100) COLLATE utf8_bin DEFAULT NULL,
		`entity` varchar(10) COLLATE utf8_bin DEFAULT NULL,
		`branch` varchar(10) COLLATE utf8_bin DEFAULT NULL,
		`division` varchar(10) COLLATE utf8_bin DEFAULT NULL,
		`department` varchar(10) COLLATE utf8_bin DEFAULT NULL, 
		`groups` varchar(10) COLLATE utf8_bin DEFAULT NULL, 
		PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Teams</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Teams</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Teams</b> exists already.<br>';
	}

	$db_name = $cid."_temp_employee_data";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`user_id` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		`emp_id` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		`position` varchar(5) COLLATE utf8_bin DEFAULT NULL,
		`company` varchar(5) COLLATE utf8_bin DEFAULT NULL,
		`location` varchar(5) COLLATE utf8_bin DEFAULT NULL,
		`division` varchar(10) COLLATE utf8_bin DEFAULT NULL,
		`department` varchar(10) COLLATE utf8_bin DEFAULT NULL, 
		`team` varchar(10) COLLATE utf8_bin DEFAULT NULL, 
		`organization` varchar(10) COLLATE utf8_bin DEFAULT NULL, 
		`groups` varchar(10) COLLATE utf8_bin DEFAULT NULL, 
		`sid` varchar(20) COLLATE utf8_bin DEFAULT NULL, 
		`title` varchar(10) COLLATE utf8_bin DEFAULT NULL, 
		`firstname` varchar(50) COLLATE utf8_bin DEFAULT NULL, 
		`lastname` varchar(50) COLLATE utf8_bin DEFAULT NULL, 
		`th_name` varchar(50) COLLATE utf8_bin DEFAULT NULL, 
		`en_name` varchar(50) COLLATE utf8_bin DEFAULT NULL, 
		`birthdate` varchar(20) COLLATE utf8_bin DEFAULT NULL, 
		`nationality` varchar(50) COLLATE utf8_bin DEFAULT NULL, 
		`gender` varchar(20) COLLATE utf8_bin DEFAULT NULL, 
		`maritial` varchar(20) COLLATE utf8_bin DEFAULT NULL, 
		`religion` varchar(50) COLLATE utf8_bin DEFAULT NULL, 
		`military_status` varchar(50) COLLATE utf8_bin DEFAULT NULL, 
		`height` varchar(10) COLLATE utf8_bin DEFAULT NULL, 
		`weight` varchar(10) COLLATE utf8_bin DEFAULT NULL, 
		`bloodtype` varchar(20) COLLATE utf8_bin DEFAULT NULL, 
		`drvlicense_nr` varchar(50) COLLATE utf8_bin DEFAULT NULL, 
		`drvlicense_exp` varchar(20) COLLATE utf8_bin DEFAULT NULL, 
		`idcard_nr` varchar(30) COLLATE utf8_bin DEFAULT NULL, 
		`idcard_exp` varchar(20) COLLATE utf8_bin DEFAULT NULL, 
		`tax_id` varchar(30) COLLATE utf8_bin DEFAULT NULL, 
		`reg_address` varchar(50) COLLATE utf8_bin DEFAULT NULL, 
		`sub_district` varchar(50) COLLATE utf8_bin DEFAULT NULL, 
		`district` varchar(50) COLLATE utf8_bin DEFAULT NULL, 
		`province` varchar(50) COLLATE utf8_bin DEFAULT NULL, 
		`postnr` varchar(50) COLLATE utf8_bin DEFAULT NULL, 
		`country` varchar(50) COLLATE utf8_bin DEFAULT NULL, 
		`latitude` varchar(255) COLLATE utf8_bin DEFAULT NULL, 
		`longitude` varchar(255) COLLATE utf8_bin DEFAULT NULL, 
		`cur_address` varchar(50) COLLATE utf8_bin DEFAULT NULL, 
		`personal_phone` varchar(20) COLLATE utf8_bin DEFAULT NULL, 
		`work_phone` varchar(20) COLLATE utf8_bin DEFAULT NULL, 
		`personal_email` varchar(50) COLLATE utf8_bin DEFAULT NULL, 
		`work_email` varchar(50) COLLATE utf8_bin DEFAULT NULL, 
		`username_option` varchar(50) COLLATE utf8_bin DEFAULT NULL, 
		`username` varchar(255) COLLATE utf8_bin DEFAULT NULL, 
		`joining_date` varchar(20) COLLATE utf8_bin DEFAULT NULL, 
		`probation_date` varchar(20) COLLATE utf8_bin DEFAULT NULL, 
		`emp_type` varchar(20) COLLATE utf8_bin DEFAULT NULL, 
		`account_code` varchar(11) COLLATE utf8_bin DEFAULT NULL, 
		`groups_work_data` varchar(20) COLLATE utf8_bin DEFAULT NULL, 
		`time_reg` varchar(20) COLLATE utf8_bin DEFAULT NULL, 
		`selfie` varchar(20) COLLATE utf8_bin DEFAULT NULL, 
		`workFromHome` varchar(20) COLLATE utf8_bin DEFAULT NULL, 
		`annual_leave` varchar(20) COLLATE utf8_bin DEFAULT NULL, 
		`start_date` varchar(100) COLLATE utf8_bin DEFAULT NULL, 
		`base_salary` varchar(100) COLLATE utf8_bin DEFAULT NULL,
        `contract_type` varchar(10) COLLATE utf8_bin DEFAULT NULL,
        `calc_base` varchar(20) COLLATE utf8_bin DEFAULT NULL,
        `bank_code` varchar(20) COLLATE utf8_bin DEFAULT NULL,
        `bank-name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
        `bank_branch` varchar(10) COLLATE utf8_bin DEFAULT NULL,
        `bank_account` varchar(50) COLLATE utf8_bin DEFAULT NULL,
        `bank_account_name` varchar(100) COLLATE utf8_bin DEFAULT NULL,
        `pay_type` varchar(10) COLLATE utf8_bin DEFAULT NULL,
        `calc_method` varchar(10) COLLATE utf8_bin DEFAULT NULL,
        `calc_tax` varchar(1) COLLATE utf8_bin DEFAULT NULL,
        `tax_residency_status` varchar(11) COLLATE utf8_bin DEFAULT NULL,
        `income_section` varchar(11) COLLATE utf8_bin DEFAULT NULL,
        `modify_tax` varchar(55) COLLATE utf8_bin DEFAULT NULL,
        `calc_sso` varchar(1) COLLATE utf8_bin DEFAULT NULL,
        `calc_psf` varchar(55) COLLATE utf8_bin DEFAULT NULL,
        `calc_pvf` varchar(55) COLLATE utf8_bin DEFAULT NULL,
        `sso_by` varchar(1) COLLATE utf8_bin DEFAULT NULL,
        `gov_house_banking` varchar(55) COLLATE utf8_bin DEFAULT NULL,
        `savings` varchar(55) COLLATE utf8_bin DEFAULT NULL,
        `legal_execution` varchar(55) COLLATE utf8_bin DEFAULT NULL,
        `kor_yor_sor` varchar(55) COLLATE utf8_bin DEFAULT NULL,
        `same_as_id` varchar(55) COLLATE utf8_bin DEFAULT NULL,
		PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Temp Employee Data</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Temp Employee Data</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Temp Employee Data</b> exists already.<br>';
	}

	
	$db_name = $cid."_users";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`ref` int(11) DEFAULT NULL,
			`username` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`emp_id` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`firstname` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`phone` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`type` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`access` int(11) DEFAULT NULL,
			`entities` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`branches` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`divisions` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`departments` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`teams` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`groups` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			`access_selection` text COLLATE utf8_bin DEFAULT NULL,
			`permissions` text COLLATE utf8_bin DEFAULT NULL,
			`activities` text COLLATE utf8_bin DEFAULT NULL,
			`emp_group` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`img` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			`status` int(11) DEFAULT NULL,
			`access_start` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`access_end` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`emp_cols` text COLLATE utf8_bin DEFAULT NULL,
			`att_cols` text COLLATE utf8_bin DEFAULT NULL, 	  
			PRIMARY KEY (`id`) 
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>System users</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>System users</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>System users</b> exists already.<br>';
	}
	

	$db_name = $cid."_scandata";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `filename` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `datescan` date DEFAULT NULL,
		  `timescan` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `emp_id` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `emp_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `shift_plan_date` date DEFAULT NULL,
		  `shift_plan_start_time` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `scan_in` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `scan_out` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `status` int(11) DEFAULT NULL,
		  `picture` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `scan_id` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `checkbox` varchar(10) COLLATE utf8_bin DEFAULT NULL,
		  `datescanout` date DEFAULT NULL,
		  `linkedPlan` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `all_scan_values` text COLLATE utf8_bin DEFAULT NULL,



		  PRIMARY KEY (`id`) 
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Scan Data</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Scan Data</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Scan Data</b> exists already.<br>';
	}	

	$db_name = $cid."_metascandata";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `filename` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `datescan` date DEFAULT NULL,
		  `datescanout` date DEFAULT NULL,
		  `timescan` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `emp_id` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `emp_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `shift_plan_date` date DEFAULT NULL,
		  `shift_plan_start_time` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `shift_plan_value` varchar(200) COLLATE utf8_bin DEFAULT NULL,
		  `scan_in` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `scan_out` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `status` int(11) DEFAULT NULL,
		  `picture` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `scan_id` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `scandata_id` varchar(200) COLLATE utf8_bin DEFAULT NULL,
		  `in_or_out` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `linkedPlan` varchar(255) COLLATE utf8_bin DEFAULT NULL,

		  PRIMARY KEY (`id`) 
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Meta Scan Data</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Meta Scan Data</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Meta Scan Data</b> exists already.<br>';
	}

	/*$db_name = $cid."_ot_plans";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
			`id` int(11) DEFAULT NULL AUTO_INCREMENT,
			`date` date DEFAULT NULL,
			`shiftteam` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`plan` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`plan_f1` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`plan_u2` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`ot_from` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`ot_until` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`ot_break` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`hours` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`type` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`compensations` text COLLATE utf8_bin DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>OT Plans</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>OT Plans</b> created successfuly.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>OT Plans</b> exists already.<br>';
	}*/
	
	/*$db_name = $cid."_ot_employees";
	if(!$dbc->query("DESCRIBE `$db_name`")) {
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
			`id` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`ot_plan` int(11) DEFAULT NULL,
			`month` int(11) DEFAULT NULL,
			`date` varchar(20) COLLATE utf8_bin DEFAULT NULL,
			`emp_id` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`en_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`th_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`shiftteam` varchar(50) COLLATE utf8_bin DEFAULT NULL,
			`position` int(11) DEFAULT NULL,
			`ot_from` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`ot_until` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`ot_hours` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`ot_break` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`ot_type` varchar(10) COLLATE utf8_bin DEFAULT NULL,
			`ot_invited` int(11) DEFAULT NULL,
			`ot_confirmed` int(11) DEFAULT NULL,
			`ot_assigned` int(11) DEFAULT NULL,
			`ot_compensations` text COLLATE utf8_bin DEFAULT NULL,		  
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>OT Employees</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>OT Employees</b> created successfuly.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>OT Employees</b> exists already.<br>';
	}*/
	
	$db_name = $cid."_workpermit";
	if(!$dbc->query("DESCRIBE `$db_name`")) { 
		$sql = "CREATE TABLE IF NOT EXISTS `$db_name` (
		  `emp_id` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `title` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `name_en` varchar(100) COLLATE utf8_bin DEFAULT NULL,
		  `name_th` varchar(100) COLLATE utf8_bin DEFAULT NULL,
		  `image` varchar(100) COLLATE utf8_bin DEFAULT NULL,
		  `nationality` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `maritial` varchar(50) COLLATE utf8_bin DEFAULT NULL,
		  `blood_group` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `birthdate` varchar(20) COLLATE utf8_bin DEFAULT NULL,
		  `address` tinytext COLLATE utf8_bin DEFAULT NULL,
		  `position` varchar(100) COLLATE utf8_bin DEFAULT NULL,
		  `job_en` tinytext COLLATE utf8_bin DEFAULT NULL,
		  `job_th` tinytext COLLATE utf8_bin DEFAULT NULL,
		  `family` text COLLATE utf8_bin DEFAULT NULL,
		  `attach_passport` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `attach_medical` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `attach_job_en` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `per_attach1` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `per_attach2` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `per_attach3` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `per_attach4` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `per_attach5` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `attach6` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `attach7` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `attach8` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `attach9` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  `attach10` varchar(255) COLLATE utf8_bin DEFAULT NULL,
		  PRIMARY KEY (`emp_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
		if(!$dbc->query($sql)){
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Workpermit</b> failed. Error : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}else{
			$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Workpermit</b> created successfully.<br>';
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Workpermit</b> exists already.<br>';
	}
	
	//echo $err_msg; exit;
	
	$dbc = @new mysqli($my_database,$my_username,$my_password);
	$dbname = $prefix.$cid;
	if(empty(mysqli_fetch_array(mysqli_query($dbc,"SHOW DATABASES LIKE '$dbname'")))){
		 echo "Database not exist, please contact the site administrator.";
		 exit; 
	}else{
		 $dbc = @new mysqli($my_database,$my_username,$my_password,$prefix.$cid);
		 mysqli_set_charset($dbc,"utf8");
	}	
	
	$oldDir = $prefix.'regodemo.';
	$newDir = $prefix.$cid.'.';
	
	$old_db_name = $oldDir.'rego_default_holidays';
	$new_db_name = $newDir.$cid.'_holidays';
	
	//var_dump($old_db_name);
	//var_dump($new_db_name); exit;

	if(!$dbc->query("DESCRIBE $new_db_name")) {
		if($dbc->query("CREATE TABLE $new_db_name LIKE $old_db_name")){
			$sql = "INSERT IGNORE INTO $new_db_name SELECT * FROM $old_db_name";
			if(!$dbc->query($sql)){
				$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Holidays</b> failed. Error 1 : <b>'.mysqli_error($dbc).'</b></span><br>';
				$error = true;
			}else{
				$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Holidays</b> created successfully.<br>';
			}
		}else{
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Holidays</b> failed. Error 2 : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Holidays</b> exists already.<br>';
	}
	
	$old_db_name = $oldDir.'rego_default_leave_time_settings';
	$new_db_name = $newDir.$cid.'_leave_time_settings';
	if(!$dbc->query("DESCRIBE $new_db_name")) {
		if($dbc->query("CREATE TABLE $new_db_name LIKE $old_db_name")){
			$sql = "INSERT IGNORE INTO $new_db_name SELECT * FROM $old_db_name";
			if(!$dbc->query($sql)){
				$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Leave & Time settings</b> failed. Error 1 : <b>'.mysqli_error($dbc).'</b></span><br>';
				$error = true;
			}else{
				$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Leave & Time settings</b> created successfully.<br>';
			}
		}else{
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Leave & Time settings</b> failed. Error 2 : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Leave & Time settings</b> exists already.<br>';
	}
	
	$old_db_name = $oldDir.'rego_default_shiftplans';
	$new_db_name = $newDir.$cid.'_shiftplans_'.$year;
	if(!$dbc->query("DESCRIBE $new_db_name")) {
		if($dbc->query("CREATE TABLE $new_db_name LIKE $old_db_name")){
			$sql = "INSERT IGNORE INTO $new_db_name SELECT * FROM $old_db_name";
			if(!$dbc->query($sql)){
				$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Shiftplans</b> failed. Error 1 : <b>'.mysqli_error($dbc).'</b></span><br>';
				$error = true;
			}else{
				$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Shiftplans</b> created successfully.<br>';
			}
		}else{
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Shiftplans</b> failed. Error 2 : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Shiftplans</b> exists already.<br>';
	}


	$old_db_name = $oldDir.'rego_rewards_penalties';
	$new_db_name = $newDir.$cid.'_rewards_penalties';
	if(!$dbc->query("DESCRIBE $new_db_name")) {
		if($dbc->query("CREATE TABLE $new_db_name LIKE $old_db_name")){
			$sql = "INSERT IGNORE INTO $new_db_name SELECT * FROM $old_db_name";
			if(!$dbc->query($sql)){
				$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Rewards & Penalties</b> failed. Error 1 : <b>'.mysqli_error($dbc).'</b></span><br>';
				$error = true;
			}else{
				$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Rewards & Penalties</b> created successfully.<br>';
			}
		}else{
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Rewards & Penalties</b> failed. Error 2 : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Rewards & Penalties</b> exists already.<br>';
	}


	$old_db_name = $oldDir.'rego_allow_deduct';
	$new_db_name = $newDir.$cid.'_allow_deduct';
	if(!$dbc->query("DESCRIBE $new_db_name")) {
		if($dbc->query("CREATE TABLE $new_db_name LIKE $old_db_name")){
			$sql = "INSERT IGNORE INTO $new_db_name SELECT * FROM $old_db_name";
			if(!$dbc->query($sql)){
				$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Allowances & Deductions</b> failed. Error 1 : <b>'.mysqli_error($dbc).'</b></span><br>';
				$error = true;
			}else{
				$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Allowances & Deductions</b> created successfully.<br>';
			}
		}else{
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Allowances & Deductions</b> failed. Error 2 : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Allowances & Deductions</b> exists already.<br>';
	}


	$old_db_name = $oldDir.'rego_payroll_models';
	$new_db_name = $newDir.$cid.'_payroll_models';
	if(!$dbc->query("DESCRIBE $new_db_name")) {
		if($dbc->query("CREATE TABLE $new_db_name LIKE $old_db_name")){
			$sql = "INSERT IGNORE INTO $new_db_name SELECT * FROM $old_db_name";
			if(!$dbc->query($sql)){
				$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Payroll Models</b> failed. Error 1 : <b>'.mysqli_error($dbc).'</b></span><br>';
				$error = true;
			}else{
				$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Payroll Models</b> created successfully.<br>';
			}
		}else{
			$err_msg .= '<span style="color:#c00"><i class="fa fa-times-circle"></i>&nbsp; Create database <b>Payroll Models</b> failed. Error 2 : <b>'.mysqli_error($dbc).'</b></span><br>';
			$error = true;
		}
	}else{
		$err_msg .= '<i class="fa fa-check-square-o"></i>&nbsp; Database <b>Payroll Models</b> exists already.<br>';
	}
	
	//var_dump($err_msg); exit;








