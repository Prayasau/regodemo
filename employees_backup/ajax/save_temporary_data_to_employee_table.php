<?
	if(session_id()==''){session_start(); ob_start();}
	include('../../dbconnect/db_connect.php');



		
	



	$sessionTeams = $_SESSION['rego']['sel_teams'];
	// echo '<pre>';
	// print_r($_SESSION['rego']['sel_teams']);
	// echo '</pre>';
	// die();
	// FIRST CHECK IF THERE IS DATA IN TEMPORARY DATABASE OR NOT 

	$query1 = "SELECT * FROM ".$_SESSION['rego']['cid']."_temp_employee_data ";
	$result1 = $dbc->query($query1);
	while($row1 = $result1->fetch_assoc()){
		$data[$row1['emp_id']] = $row1;
	}

	// if exists data in temporary database then update in employee table other wise give error 

	if(!empty($data))
	{

		$sql1= "UPDATE ".$_SESSION['rego']['cid']."_sys_settings SET  common_save_check = '0' WHERE id = '1'";
		$dbc->query($sql1);
		
		$data2=array();
		$query2 = "SELECT * FROM rego_default_settings";
		$result2 = $dbx->query($query2);
		while($row2 = $result2->fetch_assoc()){
			if(count($row2)>0)
				foreach($row2 as $k=>$v)
				{
					$data2[$k]=$v;
				}
		}
		$queryt = "SELECT id,code FROM ".$_SESSION['rego']['cid']."_teams";
		$resultt = $dbc->query($queryt);
		while($rowt = $resultt->fetch_assoc()){
			if(count($rowt)>0)
				$team2[]=$rowt;
		}
		
		$querye = "SELECT ref,code FROM ".$_SESSION['rego']['cid']."_entities_data";
		$resulte = $dbc->query($querye);
		while($rowe = $resulte->fetch_assoc()){
			if(count($rowe)>0)
				$entity2[]=$rowe;
		}
		
		$querydiv = "SELECT id,code FROM ".$_SESSION['rego']['cid']."_divisions";
		$resultdiv = $dbc->query($querydiv);
		while($rowdiv = $resultdiv->fetch_assoc()){
			if(count($rowdiv)>0)
				$div2[]=$rowdiv;
		}
		
		$queryd = "SELECT id,code FROM ".$_SESSION['rego']['cid']."_departments";
		$resultd = $dbc->query($queryd);
		while($rowd = $resultd->fetch_assoc()){
			if(count($rowd)>0)
				$depart2[]=$rowd;
		}
		
		$queryb = "SELECT ref,code FROM ".$_SESSION['rego']['cid']."_branches_data";
		$resultb = $dbc->query($queryb);
		while($rowb = $resultb->fetch_assoc()){
			if(count($rowb)>0)
				$branch2[]=$rowb;
		}
		

		foreach ($data as $key => $value) {
			# code...

			// sid 
			$sid = $value['sid']; $fieldNamesid = 'sid'; $condition3 = "$fieldNamesid = '$sid',";
			// title
			$title = $value['title']; $fieldNametitle = 'title';  $condition4 = "$fieldNametitle = '$title',";  
			// firstname
			$firstname = $value['firstname']; $fieldNamefirstname = 'firstname'; $condition5 = "$fieldNamefirstname = '$firstname',";
			// lastname 
			$lastname = $value['lastname']; $fieldNamelastname = 'lastname'; $condition6 = "$fieldNamelastname = '$lastname',";
			// en_name  
			$en_name = $value['en_name']; $fieldNameen_name = 'en_name'; $condition7 = "$fieldNameen_name = '$en_name',"; 
			// birthdate
			$birthdate = $value['birthdate']; $fieldNamebirthdate = 'birthdate'; 
			if($birthdate){$condition8 = "$fieldNamebirthdate = '$birthdate',";  }else{$condition8 = ''; }
			// nationality
			$nationality = $value['nationality']; $fieldNamenationality = 'nationality';  $condition9 = "$fieldNamenationality = '$nationality',";  
			// gender 
			$gender = $value['gender']; $fieldNamegender = 'gender'; $condition10 = "$fieldNamegender = '$gender',";
			// maritial
			$maritial = $value['maritial']; $fieldNamemaritial = 'maritial'; $condition11 = "$fieldNamemaritial = '$maritial',"; 
			// religion  
			$religion = $value['religion']; $fieldNamereligion = 'religion'; $condition12 = "$fieldNamereligion = '$religion',"; 
			// military_status 
			$military_status = $value['military_status']; $fieldNamemilitary_status = 'military_status'; $condition13 = "$fieldNamemilitary_status = '$military_status',"; 
			// height
			$height = $value['height']; $fieldNameheight = 'height'; $condition14 = "$fieldNameheight = '$military_status',";  
			// weight
			$weight = $value['weight']; $fieldNameweight = 'weight'; $condition15 = "$fieldNameweight = '$weight',";  
			// bloodtype
			$bloodtype = $value['bloodtype']; $fieldNamebloodtype = 'bloodtype'; $condition16 = "$fieldNamebloodtype = '$bloodtype',";  
			// drvlicense_nr 
			$drvlicense_nr = $value['drvlicense_nr']; $fieldNamedrvlicense_nr = 'drvlicense_nr'; $condition17 = "$fieldNamedrvlicense_nr = '$drvlicense_nr',";
			// drvlicense_exp 
			$drvlicense_exp = $value['drvlicense_exp']; $fieldNamedrvlicense_exp = 'drvlicense_exp'; $condition18 = "$fieldNamedrvlicense_exp = '$drvlicense_exp',"; 		
			// idcard_nr
			$idcard_nr = $value['idcard_nr']; $fieldNameidcard_nr = 'idcard_nr'; $condition19 = "$fieldNameidcard_nr = '$idcard_nr',"; 
			// idcard_exp
			$idcard_exp = $value['idcard_exp']; $fieldNameidcard_exp = 'idcard_exp'; $condition20 = "$fieldNameidcard_exp = '$idcard_exp',"; 
			// tax_id 
			$tax_id = $value['tax_id']; $fieldNametax_id = 'tax_id'; $condition21 = "$fieldNametax_id = '$tax_id',";  
			// reg_address
			$reg_address = $value['reg_address']; $fieldNamereg_address = 'reg_address'; $condition22 = "$fieldNamereg_address = '$reg_address',";  
			// sub district
			$sub_district = $value['sub_district']; $fieldNamesub_district = 'sub_district'; $condition23 = "$fieldNamesub_district = '$sub_district',";  
			// district
			$district = $value['district']; $fieldNamedistrict = 'district'; $condition24 = "$fieldNamedistrict = '$district',";  
			// province
			$province = $value['province']; $fieldNameprovince = 'province'; $condition25 = "$fieldNameprovince = '$province',";  
			// post number
			$postnr = $value['postnr']; $fieldNamepostnr = 'postnr'; $condition26 = "$fieldNamepostnr = '$postnr',";  
			// country
			$country = $value['country']; $fieldNamecountry = 'country'; $condition27 = "$fieldNamecountry = '$country',";  
			// latitude
			$latitude = $value['latitude']; $fieldNamelatitude = 'latitude'; $condition28 = "$fieldNamelatitude = '$latitude',";  
			// longitude
			$longitude = $value['longitude']; $fieldNamelongitude = 'longitude'; $condition29 = "$fieldNamelongitude = '$longitude',";  
			// current address
			$cur_address = $value['cur_address']; $fieldNamecur_address = 'cur_address'; $condition30 = "$fieldNamecur_address = '$cur_address',";  
			// personal phone 
			$personal_phone = $value['personal_phone']; $fieldNamepersonal_phone = 'personal_phone'; $condition31 = "$fieldNamepersonal_phone = '$personal_phone',"; // 
			// work phone
			$work_phone = $value['work_phone']; $fieldNamework_phone = 'work_phone'; $condition32 = "$fieldNamework_phone = '$work_phone',";  
			// personal email
			$personal_email = $value['personal_email']; $fieldNamepersonal_email = 'personal_email'; $condition33 = "$fieldNamepersonal_email = '$personal_email',";  
			// work email
			$work_email = $value['work_email']; $fieldNamework_email = 'work_email'; $condition34 = "$fieldNamepersonal_email = '$personal_email',";  
			// username option
			$username_option = $value['username_option']; $fieldNameusername_option = 'username_option'; $condition35 = "$fieldNameusername_option = '$username_option',";  
			// username
			$username = $value['username']; $fieldNameusername = 'username'; $condition36 = "$fieldNameusername = '$username',";  
			// joining date
			$joining_date = $value['joining_date']; $fieldNamejoining_date = 'joining_date'; $condition37 = "$fieldNamejoining_date = '$joining_date',";  
			// probation date
			$probation_date = $value['probation_date']; $fieldNameprobation_date = 'probation_date'; $condition38 = "$fieldNameprobation_date = '$probation_date',";  
			// emp_type
			$emp_type = $value['emp_type']; $fieldNameemp_type = 'emp_type'; $condition38 = "$fieldNameemp_type = '$emp_type',";  
			// account_code
			$account_code = $value['account_code']; $fieldNameaccount_code = 'account_code'; $condition1 = "$fieldNameaccount_code = '$account_code',";  
			// time_reg
			$time_reg = $value['time_reg']; $fieldNametime_reg = 'time_reg'; $condition2 = "$fieldNametime_reg = '$time_reg',";  
			// selfie
			$selfie = $value['selfie']; $fieldNameselfie = 'selfie'; $condition39 = "$fieldNameselfie = '$selfie',";  
			// workfromhome
			$workFromHome = $value['workFromHome']; $fieldNameworkFromHome = 'workFromHome'; $condition40 = "$fieldNameworkFromHome = '$workFromHome',";  
			// annual_leave
			$annual_leave = $value['annual_leave']; $fieldNameannual_leave = 'annual_leave'; $condition41 = "$fieldNameannual_leave = '$annual_leave',";  
			// company
			$company = $value['company']; $fieldNamecompany = 'entity'; $condition42 = "$fieldNamecompany = '$company',";  
			// location
			$location = $value['location']; $fieldNamelocation = 'branch'; $condition43 = "$fieldNamelocation = '$location',";  
			// division
			$division = $value['division']; $fieldNamedivision = 'division'; $condition44 = "$fieldNamedivision = '$division',"; 
			// department
			$department = $value['department']; $fieldNamedepartment = 'department'; $condition45 = "$fieldNamedepartment = '$department',"; 
			// groups
			$groups = $value['groups']; $fieldNamegroups = 'groups'; $condition47 = "$fieldNamegroups = '$groups',"; 
			// team
			$team = $value['team']; $fieldNameteam = 'team'; $condition46 = "$fieldNameteam = '$team',";  
			// start_date
			$start_date = date("Y-m-d", strtotime($value['start_date'])) ; $fieldNamestart_date = 'start_date';
			if($start_date){$condition48 = "$fieldNamestart_date = '$start_date',"; }else{$condition48 = ''; }
			// base salary
			$base_salary = $value['base_salary']; $fieldNamebase_salary = 'base_salary'; $condition49= "$fieldNamebase_salary = '$base_salary',"; 
			// contract type
			$contract_type = $value['contract_type']; $fieldNamecontract_type = 'contract_type'; $condition50 = "$fieldNamecontract_type = '$contract_type',"; 
			// calc base 
			$calc_base = $value['calc_base']; $fieldNamecalc_base = 'calc_base'; $condition51 = "$fieldNamecalc_base = '$calc_base',"; 
			// bank code 
			$bank_code = $value['bank_code']; $fieldNamebank_code = 'bank_code'; $condition52 = "$fieldNamebank_code = '$bank_code',"; 
			// bank name 
			$bank_name = $value['bank_name']; $fieldNamebank_name = 'bank_name'; $condition53 = "$fieldNamebank_name = '$bank_name',"; 
			// bank branch 
			$bank_branch = $value['bank_branch']; $fieldNamebank_branch = 'bank_branch'; $condition54 = "$fieldNamebank_branch = '$bank_branch',"; 
			// bank account 
			$bank_account = $value['bank_account']; $fieldNamebank_account = 'bank_account'; $condition55 = "$fieldNamebank_account = '$bank_account',"; 
			// bank account name 
			$bank_account_name = $value['bank_account_name']; $fieldNamebank_account_name = 'bank_account_name'; $condition56 = "$fieldNamebank_account_name = '$bank_account_name',"; 
			// pay type
			$pay_type = $value['pay_type']; $fieldNamepay_type = 'pay_type'; $condition57 = "$fieldNamepay_type = '$pay_type',"; 
			// calc method 
			$calc_method = $value['calc_method']; $fieldNamecalc_method = 'calc_method'; $condition58 = "$fieldNamecalc_method = '$calc_method',"; 
			// calculatin tax
			$calc_tax = $value['calc_tax']; $fieldNamecalc_tax = 'calc_tax'; $condition59 = "$fieldNamecalc_tax = '$calc_tax',"; 
			// tax residency status 
			$tax_residency_status = $value['tax_residency_status']; $fieldNametax_residency_status = 'tax_residency_status'; $condition60 = "$fieldNametax_residency_status = '$tax_residency_status',"; 
			// income section 
			$income_section = $value['income_section']; $fieldNameincome_section = 'income_section'; $condition61 = "$fieldNameincome_section = '$income_section',"; 
			// modify tax
			$modify_tax = $value['modify_tax']; $fieldNamemodify_tax = 'modify_tax'; $condition62 = "$fieldNamemodify_tax = '$modify_tax',"; 
			// calc_sso
			$calc_sso = $value['calc_sso']; $fieldNamecalc_sso = 'calc_sso'; $condition63 = "$fieldNamecalc_sso = '$calc_sso',"; 
			// sso by 
			$sso_by = $value['sso_by']; $fieldNamesso_by = 'sso_by'; $condition64 = "$fieldNamesso_by = '$sso_by',"; 
			// gov_house_banking 
			$gov_house_banking = $value['gov_house_banking']; $fieldNamegov_house_banking = 'gov_house_banking'; $condition65 = "$fieldNamegov_house_banking = '$gov_house_banking',"; 
			// savings 
			$savings = $value['savings']; $fieldNamesavings = 'savings'; $condition66 = "$fieldNamesavings = '$savings',"; 
			// leagal execution
			$legal_execution = $value['legal_execution']; $fieldNamelegal_execution = 'legal_execution'; $condition67 = "$fieldNamelegal_execution = '$legal_execution',"; 
			// kor_yor_sor 
			$kor_yor_sor = $value['kor_yor_sor']; $fieldNamekor_yor_sor = 'kor_yor_sor'; $condition68 = "$fieldNamekor_yor_sor = '$kor_yor_sor'"; 
			

			// ===================================== GET DEFAULT VALUES IF VALUES ARE EMPTY ====================================//

			// default value for scan_id
			if(empty($sid))$sid=$data2['scan_id'];

			// default joining date
			if(empty($joining_date)){
				if($data2['joining_date']==0)
				$joining_date=date("Y-m-d");
			}

			// default team id
			if(empty($team))$team=$team2[0]['id'];
			// default entity
			if(empty($company))$company=$entity2[0]['ref'];
			// default branch 
			if(empty($location))$location=$branch2[0]['ref'];
			// default division
			if(empty($division))$division=$div2[0]['id'];
			// default department 
			if(empty($department))$department=$depart2[0]['id'];
			// default emp_type
			if(empty($emp_type))$emp_type=$data2['emp_type'];
			// default account_code 
			if(empty($account_code))$account_code=$data2['account_code'];
			// default position
			if(empty($position))$position=$data2['position'];
			// default start_date
			if(empty($start_date))$start_date=$data2['date_start'];
			// default time_reg
			if(empty($time_reg))$time_reg=$data2['time_reg'];
			// default selfie
			if(empty($selfie))$selfie=$data2['selfie'];
			// default annual leave
			if(empty($annual_leave))$annual_leave=$data2['leeve'];
			// default pay type
			if(empty($pay_type))$pay_type=$data2['pay_type'];

			// ===================================== GET DEFAULT VALUES IF VALUES ARE EMPTY ====================================//



			// check if emp id exists in database if not then insert else update

			$fetch_old_data = $dbc->query("SELECT * FROM ".$cid."_employees WHERE emp_id = '".$value['emp_id']."'");
			if($fetch_old_data->num_rows > 0){ 

				// update here 
				$dbc->query("UPDATE ".$_SESSION['rego']['cid']."_employees SET ".$condition1." ".$condition2." ".$condition3." ".$condition4." ".$condition5." ".$condition6." ".$condition7." ".$condition8." ".$condition9." ".$condition10." ".$condition11." ".$condition12." ".$condition13." ".$condition14." ".$condition15." ".$condition16." ".$condition17." ".$condition18." ".$condition19." ".$condition20." ".$condition21." ".$condition22." ".$condition23." ".$condition24." ".$condition25." ".$condition26." ".$condition27." ".$condition28." ".$condition29." ".$condition30." ".$condition31." ".$condition32." ".$condition33." ".$condition34." ".$condition35." ".$condition36." ".$condition37." ".$condition38." ".$condition39." ".$condition40." ".$condition41." ".$condition42." ".$condition43." ".$condition44." ".$condition45." ".$condition47." ".$condition46." ".$condition48."  ".$condition49." ".$condition50." ".$condition51."  ".$condition52." ".$condition53." ".$condition54." ".$condition55." ".$condition56." ".$condition57." ".$condition58." ".$condition59." ".$condition60." ".$condition61." ".$condition62." ".$condition63." ".$condition64." ".$condition65." ".$condition66." ".$condition67." ".$condition68." WHERE emp_id = '".$value['emp_id']."'");	
			}
			else
			{
				// insert here 
				if(!empty($joining_date)){
				 $dbc->query("INSERT INTO  ".$_SESSION['rego']['cid']."_employees (`emp_id_editable`,`emp_id`,`".$fieldNamesid."`,`".$fieldNametitle."`,`".$fieldNamefirstname."`,`".$fieldNamelastname."`,`".$fieldNameen_name."`,`".$fieldNamebirthdate."`,`".$fieldNamenationality."`,`".$fieldNamegender."`,`".$fieldNamemaritial."`,`".$fieldNamereligion."`,`".$fieldNamemilitary_status."`,`".$fieldNameheight."`,`".$fieldNameweight."`,`".$fieldNamebloodtype."`,`".$fieldNamedrvlicense_nr."`,`".$fieldNamedrvlicense_exp."`,`".$fieldNameidcard_nr."`,`".$fieldNameidcard_exp."`,`".$fieldNametax_id."`,`".$fieldNamereg_address."`,`".$fieldNamesub_district."`,`".$fieldNamedistrict."`,`".$fieldNameprovince."`,`".$fieldNamepostnr."`,`".$fieldNamecountry."`,`".$fieldNamelatitude."`,`".$fieldNamelongitude."`,`".$fieldNamecur_address."`,`".$fieldNamepersonal_phone."`,`".$fieldNamework_phone."`,`".$fieldNamepersonal_email."`,`".$fieldNamework_email."`,`".$fieldNameusername_option."`,`".$fieldNameusername."`,`".$fieldNamejoining_date."`,`".$fieldNameprobation_date."`,`".$fieldNameemp_type."`,`".$fieldNametime_reg."`,`".$fieldNameselfie."`,`".$fieldNameworkFromHome."`,`".$fieldNamecompany."`,`".$fieldNamelocation."`,`".$fieldNamedivision."`,`".$fieldNamedepartment."`,`".$fieldNamegroups."`,`".$fieldNameteam."`,`".$fieldNamestart_date."`,`".$fieldNamebase_salary."`,`".$fieldNamecontract_type."`,`".$fieldNamecalc_base."`,`".$fieldNamebank_code."`,`".$fieldNamebank_name."`,`".$fieldNamebank_branch."`,`".$fieldNamebank_account."`,`".$fieldNamebank_account_name."`,`".$fieldNamepay_type."`,`".$fieldNamecalc_method."`,`".$fieldNamecalc_tax."`,`".$fieldNametax_residency_status."`,`".$fieldNameincome_section."`,`".$fieldNamemodify_tax."`,`".$fieldNamecalc_sso."`,`".$fieldNamesso_by."`,`".$fieldNamegov_house_banking."`,`".$fieldNamesavings."`,`".$fieldNamelegal_execution."`,`".$fieldNamekor_yor_sor."`,`emp_status`) VALUES('".$value['emp_id']."','".$value['emp_id']."', '".$sid."', '".$title."', '".$firstname."', '".$lastname."', '".$en_name."', '".$birthdate."', '".$nationality."', '".$gender."', '".$maritial."', '".$religion."', '".$military_status."', '".$height."', '".$weight."', '".$bloodtype."', '".$drvlicense_nr."', '".$drvlicense_exp."', '".$idcard_nr."', '".$idcard_exp."', '".$tax_id."', '".$reg_address."', '".$sub_district."', '".$district."', '".$province."', '".$postnr."', '".$country."', '".$latitude."', '".$longitude."', '".$cur_address."', '".$personal_phone."', '".$work_phone."', '".$personal_email."', '".$work_email."', '".$username_option."', '".$username."', '".$joining_date."', '".$probation_date."', '".$emp_type."', '".$time_reg."', '".$selfie."', '".$workFromHome."', '".$company."', '".$location."', '".$division."', '".$department."', '".$groups."', '".$team."', '".$start_date."', '".$base_salary."', '".$contract_type."', '".$calc_base."', '".$bank_code."', '".$bank_name."', '".$bank_branch."', '".$bank_account."', '".$bank_account_name."', '".$pay_type."', '".$calc_method."', '".$calc_tax."', '".$tax_residency_status."', '".$income_section."', '".$modify_tax."', '".$calc_sso."', '".$sso_by."', '".$gov_house_banking."', '".$savings."', '".$legal_execution."', '".$kor_yor_sor."','".$data2['emp_status']."')");
				 //die();
				}else{
					 $dbc->query("INSERT INTO  ".$_SESSION['rego']['cid']."_employees (`emp_id_editable`,`emp_id`,`".$fieldNamesid."`,`".$fieldNametitle."`,`".$fieldNamefirstname."`,`".$fieldNamelastname."`,`".$fieldNameen_name."`,`".$fieldNamebirthdate."`,`".$fieldNamenationality."`,`".$fieldNamegender."`,`".$fieldNamemaritial."`,`".$fieldNamereligion."`,`".$fieldNamemilitary_status."`,`".$fieldNameheight."`,`".$fieldNameweight."`,`".$fieldNamebloodtype."`,`".$fieldNamedrvlicense_nr."`,`".$fieldNamedrvlicense_exp."`,`".$fieldNameidcard_nr."`,`".$fieldNameidcard_exp."`,`".$fieldNametax_id."`,`".$fieldNamereg_address."`,`".$fieldNamesub_district."`,`".$fieldNamedistrict."`,`".$fieldNameprovince."`,`".$fieldNamepostnr."`,`".$fieldNamecountry."`,`".$fieldNamelatitude."`,`".$fieldNamelongitude."`,`".$fieldNamecur_address."`,`".$fieldNamepersonal_phone."`,`".$fieldNamework_phone."`,`".$fieldNamepersonal_email."`,`".$fieldNamework_email."`,`".$fieldNameusername_option."`,`".$fieldNameusername."`,`".$fieldNameprobation_date."`,`".$fieldNameemp_type."`,`".$fieldNametime_reg."`,`".$fieldNameselfie."`,`".$fieldNameworkFromHome."`,`".$fieldNamecompany."`,`".$fieldNamelocation."`,`".$fieldNamedivision."`,`".$fieldNamedepartment."`,`".$fieldNamegroups."`,`".$fieldNameteam."`,`".$fieldNamestart_date."`,`".$fieldNamebase_salary."`,`".$fieldNamecontract_type."`,`".$fieldNamecalc_base."`,`".$fieldNamebank_code."`,`".$fieldNamebank_name."`,`".$fieldNamebank_branch."`,`".$fieldNamebank_account."`,`".$fieldNamebank_account_name."`,`".$fieldNamepay_type."`,`".$fieldNamecalc_method."`,`".$fieldNamecalc_tax."`,`".$fieldNametax_residency_status."`,`".$fieldNameincome_section."`,`".$fieldNamemodify_tax."`,`".$fieldNamecalc_sso."`,`".$fieldNamesso_by."`,`".$fieldNamegov_house_banking."`,`".$fieldNamesavings."`,`".$fieldNamelegal_execution."`,`".$fieldNamekor_yor_sor."`) VALUES('".$value['emp_id']."','".$value['emp_id']."', '".$sid."', '".$title."', '".$firstname."', '".$lastname."', '".$en_name."', '".$birthdate."', '".$nationality."', '".$gender."', '".$maritial."', '".$religion."', '".$military_status."', '".$height."', '".$weight."', '".$bloodtype."', '".$drvlicense_nr."', '".$drvlicense_exp."', '".$idcard_nr."', '".$idcard_exp."', '".$tax_id."', '".$reg_address."', '".$sub_district."', '".$district."', '".$province."', '".$postnr."', '".$country."', '".$latitude."', '".$longitude."', '".$cur_address."', '".$personal_phone."', '".$work_phone."', '".$personal_email."', '".$work_email."', '".$username_option."', '".$username."',  '".$probation_date."', '".$emp_type."', '".$time_reg."', '".$selfie."', '".$workFromHome."', '".$company."', '".$location."', '".$division."', '".$department."', '".$groups."', '".$team."', '".$start_date."', '".$base_salary."', '".$contract_type."', '".$calc_base."', '".$bank_code."', '".$bank_name."', '".$bank_branch."', '".$bank_account."', '".$bank_account_name."', '".$pay_type."', '".$calc_method."', '".$calc_tax."', '".$tax_residency_status."', '".$income_section."', '".$modify_tax."', '".$calc_sso."', '".$sso_by."', '".$gov_house_banking."', '".$savings."', '".$legal_execution."', '".$kor_yor_sor."')");
				}


			}

			   $dbc->query("UPDATE ".$_SESSION['rego']['cid']."_temp_log_history SET  updated_to_empreg = '1', no_change = '1' WHERE emp_id = '".$value['emp_id']."' AND batch_team REGEXP CONCAT('(^|,)(', REPLACE('".$sessionTeams."', ',', '|'), ')(,|$)')");

		}
		
		
		// die();
		ob_clean();
		echo 'success';
	}
	else
	{
		ob_clean();
		echo 'error';
	}

?>