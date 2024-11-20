<?php 
		$empID = '0100000001';
		$res = $dbc->query("SELECT * FROM ".$cid."_employees WHERE emp_id = '".$empID."'");
		$data = $res->fetch_assoc();
		if(empty($data['image'])){$data['image'] = 'images/profile_image.jpg';}
		$update = 1;

		$emp_allow_dedct_amt = emp_allow_dedct_amt($empID);




		$ecdata = array();
		//$resec = $dbc->query("SELECT * FROM ".$cid."_employee_career WHERE emp_id = '".$empID."' AND month <= '".date('m')."' AND end_date = '' ORDER BY id DESC");
		$resec = $dbc->query("SELECT * FROM ".$cid."_employee_career WHERE emp_id = '".$empID."' ORDER BY id DESC");
		if($resec->num_rows > 0){
			while($ecdatas = $resec->fetch_assoc()){
				$ecdata[] = $ecdatas;
			}
		}

		
	
	// die();
	$entity_banks = getEntityBanks($data['entity']);
	$getNewFixAllowDeduct = getNewFixAllowDeduct();
	$getPayrollModels = getPayrollModels();
	//var_dump($entity_banks); exit;

	$fixalldedarr = array();
	foreach ($getNewFixAllowDeduct as $key => $value) {
		foreach ($value as $k => $v) {
			$fixalldedarr[$v['id']] = $v[$lang];
		}
	}

	$bank_codes = unserialize($rego_settings['bank_codes']);
	$fix_allow = getFixAllowances($sys_settings);
	$fix_deductions = unserialize($sys_settings['fix_deduct']);
	$fix_deduct = getUsedFixDeduct($lang);
	$tax_settings = unserialize($rego_settings['tax_settings']);
	//var_dump($tax_settings); exit;
	$tax_info = unserialize($rego_settings['tax_info_'.$lang]);
	//var_dump($tax_info);
	$tax_err = unserialize($rego_settings['tax_err_'.$lang]);

	?>