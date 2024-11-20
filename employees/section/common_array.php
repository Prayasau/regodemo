<?php 

//===============================MAKE ARRAY ACCORDING TO FIELD TYPES TO BE USED IN JQUERY===================//

	$time_regArray = array('0' => $lng['No'],'1' => $lng['Yes']);
	$selfieArray = array('0' => $lng['No'],'1' => $lng['Yes']);
	$workFromHomeArray = array('0' => $lng['No'],'1' => $lng['Yes']);




	// PERSONAL INFORMATION
	$textFieldArray = array('sid','firstname','lastname','en_name','nationality','height','weight','bloodtype','drvlicense_nr','idcard_nr','tax_id');
	$dateFieldArray = array('birthdate','drvlicense_exp','idcard_exp');
	$dropdownFieldArray = array('title','gender','maritial','religion','military_status');

	// CONTACT ARRAYS
	$textFieldContactArray = array('reg_address','sub_district','district','province','postnr','country','latitude','longitude','cur_address','personal_phone','work_phone','personal_email','work_email','username');
	$dropdownFieldContactArray = array('username_option');

	$textFieldFinanceArray=array('bank_branch','bank_account','bank_account_name','modify_tax','gov_house_banking','savings','legal_execution','kor_yor_sor');
	$dropdownFieldfinanceArray=array('contract_type','calc_base','bank_name','account_code','groups','pay_type','calc_method','calc_tax','tax_residency_status','income_section','calc_sso','sso_by');
	
	// work DATA ARRAYS
	$textFieldWorkData = array('joining_date','probation_date');

	// time DATA ARRAYS
	$dropdownFieldTimeData = array('time_reg','selfie','workFromHome');

	$dropdownFieldWorkDataArray = array('emp_type','groups_work_data','groups','account_code');
	
	/* $banksarray=array('001'=>'Bankok BankPCL','002'=>'Bank of Ayudhya PCL','003'=>'Kasikombank PCL',
	    '004'=>'Krung Thai Bank PCL','005'=>'TMB Bank PCL','006'=>'Siam Commercial Bank PCL',
	    '007'=>'United Overseas Bank(Thai) PCL');
	 */
	$bank_codes = unserialize($rego_settings['bank_codes']);
	$banksarray=array();
	foreach($bank_codes as $v){
	    if($v['apply']=='1')$banksarray[$v['code']]=$v['en'];
	}
	$accountCodeArray = array('0' => 'Direct','1' => 'Indirect');
	
	//print_r($bank_codes);exit;
	// leave D
    $calcmethod=array('cam'=>'Calculate in Advance Method(CAM)','acm'=>'Accumulative Calculation Method(ACM)','ytd'=>'Year To Date(YTD)');
    $calctax=array('1'=>'PND 1','3'=>'PND 3','0'=>'No Tax');
    
    
	$allfieldsArray['sid'] =  $lng['Scan ID'];
	$allfieldsArray['title'] = $lng['Title'];
	$allfieldsArray['firstname'] = $lng['First name'];
	$allfieldsArray['lastname'] = $lng['Last name'];
	$allfieldsArray['en_name'] = $lng['Name in English'];
	$allfieldsArray['birthdate'] = $lng['Birthdate'];
	$allfieldsArray['nationality'] = $lng['Nationality'];
	$allfieldsArray['gender'] = $lng['Gender'];
	$allfieldsArray['maritial'] = $lng['Maritial status'];
	$allfieldsArray['religion'] = $lng['Religion'];
	$allfieldsArray['military_status'] = $lng['Military status'];
	$allfieldsArray['height'] = $lng['Height'];
	$allfieldsArray['weight'] = $lng['Weight'];
	$allfieldsArray['bloodtype'] = $lng['Blood type'];
	$allfieldsArray['drvlicense_nr'] = $lng['Driving license No.'];
	$allfieldsArray['drvlicense_exp'] = $lng['License expiry date'];
	$allfieldsArray['idcard_nr'] = $lng['ID card'];
	$allfieldsArray['idcard_exp'] = $lng['ID card expiry date'];
	$allfieldsArray['tax_id'] = $lng['Tax ID no.'];
	$allfieldsArray['reg_address'] = $lng['Registered address'];
	$allfieldsArray['sub_district'] = $lng['Sub district'];
	$allfieldsArray['district'] = $lng['District'];
	$allfieldsArray['province'] = $lng['Province'];
	$allfieldsArray['postnr'] = $lng['Postal code'];
	$allfieldsArray['country'] = $lng['Country'];
	$allfieldsArray['latitude'] = $lng['Latitude'];
	$allfieldsArray['longitude'] = $lng['Longitude'];
	$allfieldsArray['cur_address'] = $lng['Current address'];
	$allfieldsArray['personal_phone'] = $lng['Personal phone'];
	$allfieldsArray['work_phone'] = $lng['Work phone'];
	$allfieldsArray['personal_email'] = $lng['Personal email'];
	$allfieldsArray['work_email'] = $lng['Work email'];
	$allfieldsArray['username_option'] = $lng['Username Options'];
	$allfieldsArray['username'] = $lng['Username'];
	$allfieldsArray['joining_date'] = $lng['Joining date'];
	$allfieldsArray['probation_date'] = $lng['Probation due date'];
	$allfieldsArray['emp_type'] = $lng['Employee type'];
	$allfieldsArray['account_code'] = $lng['Accounting code'];
	$allfieldsArray['groups_work_data'] = $lng['Groups'];
	$allfieldsArray['groups'] = $lng['Groups'];
	$allfieldsArray['workFromHome'] = $lng['Work From Home'];
	$allfieldsArray['selfie'] = $lng['Selfie'];
	$allfieldsArray['time_reg'] = $lng['Time registration'];
	$allfieldsArray['company'] = $lng['Company'];
	$allfieldsArray['location'] = $lng['Location'];
	$allfieldsArray['division'] = $lng['Division'];
	$allfieldsArray['department'] = $lng['Department'];
	$allfieldsArray['team'] = $lng['Teams'];
	$allfieldsArray['annual_leave'] = $lng['Annual leave (days)'];
	$allfieldsArray['start_date'] = $lng['Start Date'];
	$allfieldsArray['base_salary'] = $lng['Basic salary'];
	
	$allfieldsArray['contract_type'] = $lng['Contract type'];
	$allfieldsArray['calc_base'] = $lng['Calculation base'];
	$allfieldsArray['bank_code'] = $lng['Bank code'];
	$allfieldsArray['bank_name'] = $lng['Bank name'];
	$allfieldsArray['bank_branch'] = $lng['Bank branch'];
	$allfieldsArray['bank_account'] = $lng['Bank account no.'];
	$allfieldsArray['bank_account_name'] = $lng['Bank account name'];
	$allfieldsArray['pay_type'] = $lng['Payment type'];
	$allfieldsArray['account_code'] = $lng['Accounting code'];
	$allfieldsArray['groups'] = $lng['Groups'];
	$allfieldsArray['calc_method'] = 'Tax calculation method';
	$allfieldsArray['calc_tax'] = 'Calculate tax';
	$allfieldsArray['tax_residency_status'] = $lng['Tax Residency Status'];
	$allfieldsArray['income_section'] = 'Income Section';
	$allfieldsArray['modify_tax'] = $lng['Modify Tax amount'];
	$allfieldsArray['calc_sso'] = $lng['Calculate SSO'];
	$allfieldsArray['sso_by'] = $lng['SSO paid by'];
	$allfieldsArray['gov_house_banking'] = $lng['Government house banking'];
	$allfieldsArray['savings'] = $lng['Savings'];
	$allfieldsArray['legal_execution'] = $lng['Legal execution deduction'];
	$allfieldsArray['kor_yor_sor'] = $lng['Kor.Yor.Sor (Student loan)'];
	
	$allfieldsArray['joining_date']=$lng['Joining date'];
	$allfieldsArray['service_years']=$lng['Service years'];
	$allfieldsArray['employment_end_date']=$lng['Employment End Date'];
	$allfieldsArray['employee_status']=$lng['Employee status'];
	
	$allfieldsArray['position']=$lng['Position'];
	$allfieldsArray['date_start_position']=$lng['Date start Position'];
	$allfieldsArray['head_of_location']=$lng['Head of Location'];
	$allfieldsArray['head_of_division']=$lng['Head of division'];
	$allfieldsArray['head_of_department']=$lng['Head of department'];
	$allfieldsArray['team_supervisor']=$lng['Team supervisor'];
	
	
	
	//===============================MAKE ARRAY ACCORDING TO FIELD TYPES TO BE USED IN JQUERY===================//
	//show/hide column

	$eatt_cols = array();
	$eatt_cols[2] = array('position',$lng['Position']);
	$eatt_cols[] = array('entity',$lng['Company']);
	$eatt_cols[] = array('branch',$lng['Location']);
	$eatt_cols[] = array('division',$lng['Division']);
	$eatt_cols[] = array('department',$lng['Department']);
	$eatt_cols[] = array('team',$lng['Teams']);

	end($eatt_cols);
	$last_col = key($eatt_cols) + 1;	
	//=====================PEROSNAL SECTION SHOW HIDE ARRAY =====================//
	$eatt_cols2 = array();
	$eatt_cols2[2] = array('sid',$lng['Scan ID']);
	$eatt_cols2[] = array('title',$lng['Title']);
	$eatt_cols2[] = array('firstname',$lng['First name']);
	$eatt_cols2[] = array('lastname',$lng['Last name']);
	$eatt_cols2[] = array('en_name',$lng['Name in English']);
	$eatt_cols2[] = array('birthdate',$lng['Birthdate']);
	$eatt_cols2[] = array('nationality',$lng['Nationality']);
	$eatt_cols2[] = array('gender',$lng['Gender']);
	$eatt_cols2[] = array('maritial',$lng['Maritial status']);
	$eatt_cols2[] = array('religion',$lng['Religion']);
	$eatt_cols2[] = array('military_status',$lng['Military status']);
	$eatt_cols2[] = array('height',$lng['Height']);
	$eatt_cols2[] = array('weight',$lng['Weight']);
	$eatt_cols2[] = array('bloodtype',$lng['Blood type']);
	$eatt_cols2[] = array('drvlicense_nr',$lng['Driving license No.']);
	$eatt_cols2[] = array('drvlicense_exp',$lng['License expiry date']);
	$eatt_cols2[] = array('idcard_nr',$lng['ID card']);
	$eatt_cols2[] = array('idcard_exp',$lng['ID card expiry date']);
	$eatt_cols2[] = array('tax_id',$lng['Tax ID no.']);

	end($eatt_cols2);
	$last_col2 = key($eatt_cols2) + 1;

	//=====================PEROSNAL SECTION SHOW HIDE ARRAY =====================//


	//=====================CONATCT SECTION SHOW HIDE ARRAY =====================//

	$eatt_cols3 = array();
	$eatt_cols3[2] = array('reg_address',$lng['Registered address']);
	$eatt_cols3[] = array('sub_district',$lng['Sub district']);
	$eatt_cols3[] = array('district',$lng['District']);
	$eatt_cols3[] = array('province',$lng['Province']);
	$eatt_cols3[] = array('postnr',$lng['Postal code']);
	$eatt_cols3[] = array('country',$lng['Country']);
	$eatt_cols3[] = array('latitude',$lng['Latitude']);
	$eatt_cols3[] = array('longitude',$lng['Longitude']);
	$eatt_cols3[] = array('cur_address',$lng['Current address']);
	$eatt_cols3[] = array('personal_phone',$lng['Personal phone']);
	$eatt_cols3[] = array('work_phone',$lng['Work phone']);
	$eatt_cols3[] = array('personal_email',$lng['Personal email']);
	$eatt_cols3[] = array('work_email',$lng['Work email']);
	$eatt_cols3[] = array('username_option',$lng['Username Options']);
	$eatt_cols3[] = array('username',$lng['Username']);
	end($eatt_cols3);
	$last_col3 = key($eatt_cols3) + 1;

	// ==================== CONTACTS SECTION SHOW HIDE ARRAY  ==================== //	

	//=====================WORK DATA SECTION SHOW HIDE ARRAY =====================//

	$eatt_cols4 = array();
	$eatt_cols4[2] = array('joining_date',$lng['Joining date']);
	$eatt_cols4[] = array('probation_date',$lng['Probation due date']);
	$eatt_cols4[] = array('emp_type',$lng['Employee type']);
	$eatt_cols4[] = array('account_code',$lng['Accounting code']);
	$eatt_cols4[] = array('groups',$lng['Groups']);


	end($eatt_cols4);
	$last_col4 = key($eatt_cols4) + 1;

	// ==================== WORK DATA SECTION SHOW HIDE ARRAY  ==================== //	


	//=====================TIME SECTION SHOW HIDE ARRAY =====================//

	$eatt_cols5 = array();
	$eatt_cols5[2] = array('time_reg',$lng['Time registration']);
	$eatt_cols5[] = array('selfie',$lng['Selfie']);
	$eatt_cols5[] = array('workFromHome',$lng['Work From Home']);

	end($eatt_cols5);
	$last_col5 = key($eatt_cols5) + 1;

	// ==================== TIME SECTION SHOW HIDE ARRAY  ==================== //	

	//=====================LEAVE SECTION SHOW HIDE ARRAY =====================//

	$eatt_cols6 = array();
	$eatt_cols6[2] = array('annual_leave',$lng['Annual leave (days)']);
	end($eatt_cols6);
	$last_col6 = key($eatt_cols6) + 1;

	// ==================== TIME SECTION SHOW HIDE ARRAY  ==================== //

	//===================== Organization SECTION SHOW HIDE ARRAY =====================//

	$eatt_cols7 = array();
	$eatt_cols7[2] = array('company',$lng['Company']);
	$eatt_cols7[] = array('location',$lng['Location']);
	$eatt_cols7[] = array('division',$lng['Division']);
	$eatt_cols7[] = array('department',$lng['Department']);
	$eatt_cols7[] = array('team',$lng['Teams']);
	end($eatt_cols7);
	$last_col7 = key($eatt_cols7) + 1;

	// ==================== Organization SECTION SHOW HIDE ARRAY  ==================== //	
	// ==================== BENEFITS SECTION SHOW HIDE ARRAY  ==================== //
	$eatt_cols9 = array();
	//$eatt_cols9[2] = array('emp_id',$lng['Emp. ID']);
	//$eatt_cols9[] = array('en_name',$lng['Employee Name']);
	$eatt_cols9[] = array('contract_type',$lng['Contract type']);
	$eatt_cols9[] = array('calc_base',$lng['Calculation base']);
	$eatt_cols9[] = array('bank_code',$lng['Bank code']);
	$eatt_cols9[] = array('bank_name',$lng['Bank name']);
	$eatt_cols9[] = array('bank_branch',$lng['Bank branch']);
	$eatt_cols9[] = array('bank_account',$lng['Bank account no.']);
	$eatt_cols9[] = array('bank_account_name',$lng['Bank account name']);
	$eatt_cols9[] = array('pay_type',$lng['Payment type']);
	$eatt_cols9[] = array('account_code',$lng['Accounting code']);
	$eatt_cols9[] = array('groups',$lng['Groups']);
	$eatt_cols9[] = array('calc_method','Tax calculation method');
	$eatt_cols9[] = array('calc_tax','Calculate tax');
	$eatt_cols9[] = array('tax_residency_status',$lng['Tax Residency Status']);
	$eatt_cols9[] = array('income_section','Income Section');
	$eatt_cols9[] = array('modify_tax',$lng['Modify Tax amount']);
	$eatt_cols9[] = array('calc_sso',$lng['Calculate SSO']);
	$eatt_cols9[] = array('sso_by',$lng['SSO paid by']);
	$eatt_cols9[] = array('gov_house_banking',$lng['Government house banking']);
	$eatt_cols9[] = array('savings',$lng['Savings']);
	$eatt_cols9[] = array('legal_execution',$lng['Legal execution deduction']);
	$eatt_cols9[] = array('kor_yor_sor',$lng['Kor.Yor.Sor (Student loan)']);
	end($eatt_cols9);
	$last_col9=key($eatt_cols9) +1 ;

	// echo '<pre>';
	// print_r($eatt_cols9);
	// echo '</pre>';

	// die();
	
	// ==================== BENEFITS SECTION SHOW HIDE ARRAY  ==================== //

	//===================== BENEFITS SECTION SHOW HIDE ARRAY =====================//

	$eatt_cols8 = array();
	$eatt_cols8[2] = array('start_date',$lng['Start Date']);
	$eatt_cols8[] = array('base_salary',$lng['Basic salary']);
	end($eatt_cols8);
	$last_col8 = key($eatt_cols8) + 1;

	// ==================== BENEFITS SECTION SHOW HIDE ARRAY  ==================== //
	
	// ==================== EMPLOYMENT DATA SHOW HIDE ARRAY ======================//
	
	$eatt_cols10 = array();
	$eatt_cols10[] = array('joining_date',$lng['Joining date']);
	$eatt_cols10[] = array('service_years',$lng['Service years']);
	$eatt_cols10[] = array('employment_end_date',$lng['Employment End Date']);
	$eatt_cols10[] = array('employee_status',$lng['Employee status']);
	end($eatt_cols10);
	$last_col10 = key($eatt_cols10) + 1;
	// ==================== EMPLOYMENT DATA SHOW HIDE ARRAY ======================//
	// ==================== RESPONSIBILITIES SHOW HIDE ARRAY ======================//
	$eatt_cols11 = array();
	$eatt_cols11[] = array('position',$lng['Position']);
	$eatt_cols11[] = array('date_start_position',$lng['Date start Position']);
	$eatt_cols11[] = array('head_of_location',$lng['Head of Location']);
	$eatt_cols11[] = array('head_of_division',$lng['Head of division']);
	$eatt_cols11[] = array('head_of_department',$lng['Head of department']);
	$eatt_cols11[] = array('team_supervisor',$lng['Team supervisor']);
	end($eatt_cols11);
	$last_col11 = key($eatt_cols11) + 1;
	// ==================== RESPONSIBILITIES SHOW HIDE ARRAY ======================//
	
	$resED = $dbc->query("SELECT common_save_check,modify_empdata_section_showhide_cols,modify_empdata_showhide_cols FROM ".$_SESSION['rego']['cid']."_sys_settings");
	$rowED = $resED->fetch_assoc();
	$common_save_check =$rowED['common_save_check'];
	$shCols = unserialize($rowED['modify_empdata_showhide_cols']);
	$shCols2 = unserialize($rowED['modify_empdata_section_showhide_cols']);


	if(!$shCols){$shCols = array();}


	if(!$shCols2){$shCols2 = array();}

	$emptyCols = array();
	$emptyCols2 = array();
	$emptyCols3 = array();
	$emptyCols4 = array();
	$emptyCols5 = array();
	$emptyCols6 = array();
	$emptyCols7 = array();
	$emptyCols8 = array();
	$emptyCols9 = array();
	$emptyCols10 = array();
	$emptyCols11 = array();
	
 
	foreach($eatt_cols as $k=>$v){
		if(!in_array($k, $shCols)){
			$emptyCols[] = $k;
		}
	}	


	foreach($eatt_cols2 as $k=>$v){
		if(!in_array($k, $shCols2)){
			$emptyCols2[] = $k;
		}
	}	

	foreach($eatt_cols3 as $k=>$v){
		if(!in_array($k, $shCols2)){
			$emptyCols3[] = $k;
		}
	}
	foreach($eatt_cols4 as $k=>$v){
		if(!in_array($k, $shCols2)){
			$emptyCols4[] = $k;
		}
	}	
	foreach($eatt_cols5 as $k=>$v){
		if(!in_array($k, $shCols2)){
			$emptyCols5[] = $k;
		}
	}	
	foreach($eatt_cols6 as $k=>$v){
		if(!in_array($k, $shCols2)){
			$emptyCols6[] = $k;
		}
	}	
	foreach($eatt_cols7 as $k=>$v){
		if(!in_array($k, $shCols2)){
			$emptyCols7[] = $k;
		}
	}	
	foreach($eatt_cols9 as $k=>$v){
	    if(!in_array($k, $shCols2)){
	        $emptyCols9[] = $k;
	    }
	}
	foreach($eatt_cols8 as $k=>$v){
		if(!in_array($k, $shCols2)){
			$emptyCols8[] = $k;
		}
	}
	foreach($eatt_cols10 as $k=>$v){
	    if(!in_array($k, $shCols2)){
	        $emptyCols10[] = $k;
	    }
	}
	foreach($eatt_cols11 as $k=>$v){
	    if(!in_array($k, $shCols2)){
	        $emptyCols11[] = $k;
	    }
	}

	//========================== GET ENTITY/ LOCATION/DIVISION/DEPARTMENT NAME  =============================//

		// COMPANY NAME 

		$fetch_company_data = $dbc->query("SELECT * FROM ".$cid."_entities_data ");

		if($fetch_company_data->num_rows > 0){ 
			while ($row_company_data = $fetch_company_data->fetch_assoc()) {
				$company_name_data[$row_company_data['ref']] = $row_company_data;
			}
		}

		// BRANCH NAME 

		$fetch_branch_data = $dbc->query("SELECT * FROM ".$cid."_branches_data ");

		if($fetch_branch_data->num_rows > 0){ 
			while ($row_branch_data = $fetch_branch_data->fetch_assoc()) {
				$branch_name_data[$row_branch_data['ref']] = $row_branch_data;
			}
		}

		// DIVISION NAME 

		$fetch_division_data = $dbc->query("SELECT * FROM ".$cid."_divisions ");

		if($fetch_division_data->num_rows > 0){ 
			while ($row_division_data = $fetch_division_data->fetch_assoc()) {
				$division_name_data[$row_division_data['id']] = $row_division_data;
			}
		}		

		// DEPARTMENT NAME 

		$fetch_department_data = $dbc->query("SELECT * FROM ".$cid."_departments ");

		if($fetch_department_data->num_rows > 0){ 
			while ($row_department_data = $fetch_department_data->fetch_assoc()) {
				$department_name_data[$row_department_data['id']] = $row_department_data;
			}
		}		
		// TEAM NAME 

		$fetch_teams_data = $dbc->query("SELECT * FROM ".$cid."_teams ");

		if($fetch_teams_data->num_rows > 0){ 
			while ($row_teams_data = $fetch_teams_data->fetch_assoc()) {
				$teams_name_data[$row_teams_data['id']] = $row_teams_data;
			}
		}


	//========================== GET ENTITY/ LOCATION/DIVISION/DEPARTMENT NAME  =============================//

		// echo '<pre>';
		// print_r($company_name_data);
		// print_r($_SESSION['rego']['lang']);
		// echo '</pre>';
		// die();

	?>