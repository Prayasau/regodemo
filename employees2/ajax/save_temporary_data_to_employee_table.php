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
	



		foreach ($data as $key => $value) {
			# code...

			$sid = $value['sid']; $fieldNamesid = 'sid'; $condition3 = "$fieldNamesid = '$sid',";// sid 
			$title = $value['title']; $fieldNametitle = 'title';  $condition4 = "$fieldNametitle = '$title',"; // title 
			$firstname = $value['firstname']; $fieldNamefirstname = 'firstname'; $condition5 = "$fieldNamefirstname = '$firstname',";// firstname 
			$lastname = $value['lastname']; $fieldNamelastname = 'lastname'; $condition6 = "$fieldNamelastname = '$lastname',"; // lastname 
			$en_name = $value['en_name']; $fieldNameen_name = 'en_name'; $condition7 = "$fieldNameen_name = '$en_name',";// en_name 
			$birthdate = $value['birthdate']; $fieldNamebirthdate = 'birthdate'; 
			if($birthdate)
			{
				$condition8 = "$fieldNamebirthdate = '$birthdate',"; // birthdate 
			}
			else
			{
				$condition8 = ''; // birthdate 
			}
			$nationality = $value['nationality']; $fieldNamenationality = 'nationality';  $condition9 = "$fieldNamenationality = '$nationality',"; // nationality 
			$gender = $value['gender']; $fieldNamegender = 'gender'; $condition10 = "$fieldNamegender = '$gender',";// gender 
			$maritial = $value['maritial']; $fieldNamemaritial = 'maritial'; $condition11 = "$fieldNamemaritial = '$maritial',"; // maritial 
			$religion = $value['religion']; $fieldNamereligion = 'religion'; $condition12 = "$fieldNamereligion = '$religion',"; // religion 
			$military_status = $value['military_status']; $fieldNamemilitary_status = 'military_status'; $condition13 = "$fieldNamemilitary_status = '$military_status',"; // military_status 
			$height = $value['height']; $fieldNameheight = 'height'; $condition14 = "$fieldNameheight = '$military_status',"; // height 
			$weight = $value['weight']; $fieldNameweight = 'weight'; $condition15 = "$fieldNameweight = '$weight',"; // weight 
			$bloodtype = $value['bloodtype']; $fieldNamebloodtype = 'bloodtype'; $condition16 = "$fieldNamebloodtype = '$bloodtype',"; // bloodtype 
			$drvlicense_nr = $value['drvlicense_nr']; $fieldNamedrvlicense_nr = 'drvlicense_nr'; $condition17 = "$fieldNamedrvlicense_nr = '$drvlicense_nr',"; // drvlicense_nr 
			$drvlicense_exp = $value['drvlicense_exp']; $fieldNamedrvlicense_exp = 'drvlicense_exp'; $condition18 = "$fieldNamedrvlicense_exp = '$drvlicense_exp',"; // drvlicense_exp		
			$idcard_nr = $value['idcard_nr']; $fieldNameidcard_nr = 'idcard_nr'; $condition19 = "$fieldNameidcard_nr = '$idcard_nr',";// idcard_nr 
			$idcard_exp = $value['idcard_exp']; $fieldNameidcard_exp = 'idcard_exp'; $condition20 = "$fieldNameidcard_exp = '$idcard_exp',"; // idcard_exp 
			$tax_id = $value['tax_id']; $fieldNametax_id = 'tax_id'; $condition21 = "$fieldNametax_id = '$tax_id',"; // tax_id 
			$reg_address = $value['reg_address']; $fieldNamereg_address = 'reg_address'; $condition22 = "$fieldNamereg_address = '$reg_address',"; // 
			$sub_district = $value['sub_district']; $fieldNamesub_district = 'sub_district'; $condition23 = "$fieldNamesub_district = '$sub_district',"; // 
			$district = $value['district']; $fieldNamedistrict = 'district'; $condition24 = "$fieldNamedistrict = '$district',"; // 
			$province = $value['province']; $fieldNameprovince = 'province'; $condition25 = "$fieldNameprovince = '$province',"; // 
			$postnr = $value['postnr']; $fieldNamepostnr = 'postnr'; $condition26 = "$fieldNamepostnr = '$postnr',"; // 
			$country = $value['country']; $fieldNamecountry = 'country'; $condition27 = "$fieldNamecountry = '$country',"; // 
			$latitude = $value['latitude']; $fieldNamelatitude = 'latitude'; $condition28 = "$fieldNamelatitude = '$latitude',"; // 
			$longitude = $value['longitude']; $fieldNamelongitude = 'longitude'; $condition29 = "$fieldNamelongitude = '$longitude',"; // 
			$cur_address = $value['cur_address']; $fieldNamecur_address = 'cur_address'; $condition30 = "$fieldNamecur_address = '$cur_address',"; // 
			$personal_phone = $value['personal_phone']; $fieldNamepersonal_phone = 'personal_phone'; $condition31 = "$fieldNamepersonal_phone = '$personal_phone',"; // 
			$work_phone = $value['work_phone']; $fieldNamework_phone = 'work_phone'; $condition32 = "$fieldNamework_phone = '$work_phone',"; // 
			$personal_email = $value['personal_email']; $fieldNamepersonal_email = 'personal_email'; $condition33 = "$fieldNamepersonal_email = '$personal_email',"; // 
			$work_email = $value['work_email']; $fieldNamework_email = 'work_email'; $condition34 = "$fieldNamepersonal_email = '$personal_email',"; // 
			$username_option = $value['username_option']; $fieldNameusername_option = 'username_option'; $condition35 = "$fieldNameusername_option = '$username_option',"; // 
			$username = $value['username']; $fieldNameusername = 'username'; $condition36 = "$fieldNameusername = '$username',"; // 
			$joining_date = $value['joining_date']; $fieldNamejoining_date = 'joining_date'; $condition37 = "$fieldNamejoining_date = '$joining_date',"; // 
			$probation_date = $value['probation_date']; $fieldNameprobation_date = 'probation_date'; $condition38 = "$fieldNameprobation_date = '$probation_date',"; // 
			$emp_type = $value['emp_type']; $fieldNameemp_type = 'emp_type'; $condition38 = "$fieldNameemp_type = '$emp_type',"; // 
			$account_code = $value['account_code']; $fieldNameaccount_code = 'account_code'; $condition1 = "$fieldNameaccount_code = '$account_code',"; // 
			$time_reg = $value['time_reg']; $fieldNametime_reg = 'time_reg'; $condition2 = "$fieldNametime_reg = '$time_reg',"; // 
			$selfie = $value['selfie']; $fieldNameselfie = 'selfie'; $condition39 = "$fieldNameselfie = '$selfie',"; // 
			$workFromHome = $value['workFromHome']; $fieldNameworkFromHome = 'workFromHome'; $condition40 = "$fieldNameworkFromHome = '$workFromHome',"; // 
			$annual_leave = $value['annual_leave']; $fieldNameannual_leave = 'annual_leave'; $condition41 = "$fieldNameannual_leave = '$annual_leave',"; // 
			$company = $value['company']; $fieldNamecompany = 'entity'; $condition42 = "$fieldNamecompany = '$company',"; // 
			$location = $value['location']; $fieldNamelocation = 'branch'; $condition43 = "$fieldNamelocation = '$location',"; // 
			$division = $value['division']; $fieldNamedivision = 'division'; $condition44 = "$fieldNamedivision = '$division',"; // 
			$department = $value['department']; $fieldNamedepartment = 'department'; $condition45 = "$fieldNamedepartment = '$department',"; // 
			$groups = $value['groups']; $fieldNamegroups = 'groups'; $condition47 = "$fieldNamegroups = '$groups',"; // 
			$team = $value['team']; $fieldNameteam = 'team'; $condition46 = "$fieldNameteam = '$team',"; // 
			$start_date = date("Y-m-d", strtotime($value['start_date'])) ; $fieldNamestart_date = 'start_date';
			if($start_date)
			{
				$condition48 = "$fieldNamestart_date = '$start_date',"; // 
			}
			else
			{
				$condition48 = ''; // 
			}
			$base_salary = $value['base_salary']; $fieldNamebase_salary = 'base_salary'; $condition49= "$fieldNamebase_salary = '$base_salary',"; // 
			$contract_type = $value['contract_type']; $fieldNamecontract_type = 'contract_type'; $condition50 = "$fieldNamecontract_type = '$contract_type',"; //
			$calc_base = $value['calc_base']; $fieldNamecalc_base = 'calc_base'; $condition51 = "$fieldNamecalc_base = '$calc_base',"; //
			$bank_code = $value['bank_code']; $fieldNamebank_code = 'bank_code'; $condition52 = "$fieldNamebank_code = '$bank_code',"; //
			$bank_name = $value['bank_name']; $fieldNamebank_name = 'bank_name'; $condition53 = "$fieldNamebank_name = '$bank_name',"; //
			$bank_branch = $value['bank_branch']; $fieldNamebank_branch = 'bank_branch'; $condition54 = "$fieldNamebank_branch = '$bank_branch',"; //
			$bank_account = $value['bank_account']; $fieldNamebank_account = 'bank_account'; $condition55 = "$fieldNamebank_account = '$bank_account',"; //
			$bank_account_name = $value['bank_account_name']; $fieldNamebank_account_name = 'bank_account_name'; $condition56 = "$fieldNamebank_account_name = '$bank_account_name',"; //
			$pay_type = $value['pay_type']; $fieldNamepay_type = 'pay_type'; $condition57 = "$fieldNamepay_type = '$pay_type',"; //
			$calc_method = $value['calc_method']; $fieldNamecalc_method = 'calc_method'; $condition58 = "$fieldNamecalc_method = '$calc_method',"; //
			$calc_tax = $value['calc_tax']; $fieldNamecalc_tax = 'calc_tax'; $condition59 = "$fieldNamecalc_tax = '$calc_tax',"; //
			$tax_residency_status = $value['tax_residency_status']; $fieldNametax_residency_status = 'tax_residency_status'; $condition60 = "$fieldNametax_residency_status = '$tax_residency_status',"; //
			$income_section = $value['income_section']; $fieldNameincome_section = 'income_section'; $condition61 = "$fieldNameincome_section = '$income_section',"; //
			$modify_tax = $value['modify_tax']; $fieldNamemodify_tax = 'modify_tax'; $condition62 = "$fieldNamemodify_tax = '$modify_tax',"; //
			$calc_sso = $value['calc_sso']; $fieldNamecalc_sso = 'calc_sso'; $condition63 = "$fieldNamecalc_sso = '$calc_sso',"; //
			$sso_by = $value['sso_by']; $fieldNamesso_by = 'sso_by'; $condition64 = "$fieldNamesso_by = '$sso_by',"; //
			$gov_house_banking = $value['gov_house_banking']; $fieldNamegov_house_banking = 'gov_house_banking'; $condition65 = "$fieldNamegov_house_banking = '$gov_house_banking',"; //
			$savings = $value['savings']; $fieldNamesavings = 'savings'; $condition66 = "$fieldNamesavings = '$savings',"; //
			$legal_execution = $value['legal_execution']; $fieldNamelegal_execution = 'legal_execution'; $condition67 = "$fieldNamelegal_execution = '$legal_execution',"; //
			$kor_yor_sor = $value['kor_yor_sor']; $fieldNamekor_yor_sor = 'kor_yor_sor'; $condition68 = "$fieldNamekor_yor_sor = '$kor_yor_sor',"; //
			$sso_id = $value['sso_id']; $fieldNamesso_id = 'sso_id'; $condition69 = "$fieldNamesso_id = '$sso_id',";
			$same_as_id = $value['same_as_id']; $fieldNamesame_as_id = 'same_as_id'; $condition70 = "$fieldNamesame_as_id = '$same_as_id'";
			


			    $dbc->query("UPDATE ".$_SESSION['rego']['cid']."_employees SET ".$condition1." ".$condition2." ".$condition3." ".$condition4." ".$condition5." ".$condition6." ".$condition7." ".$condition8." ".$condition9." ".$condition10." ".$condition11." ".$condition12." ".$condition13." ".$condition14." ".$condition15." ".$condition16." ".$condition17." ".$condition18." ".$condition19." ".$condition20." ".$condition21." ".$condition22." ".$condition23." ".$condition24." ".$condition25." ".$condition26." ".$condition27." ".$condition28." ".$condition29." ".$condition30." ".$condition31." ".$condition32." ".$condition33." ".$condition34." ".$condition35." ".$condition36." ".$condition37." ".$condition38." ".$condition39." ".$condition40." ".$condition41." ".$condition42." ".$condition43." ".$condition44." ".$condition45." ".$condition47." ".$condition46." ".$condition48."  ".$condition49." ".$condition50." ".$condition51."  ".$condition52." ".$condition53." ".$condition54." ".$condition55." ".$condition56." ".$condition57." ".$condition58." ".$condition59." ".$condition60." ".$condition61." ".$condition62." ".$condition63." ".$condition64." ".$condition65." ".$condition66." ".$condition67." ".$condition68." ".$condition69." ".$condition70." WHERE emp_id = '".$value['emp_id']."'");	
 


			   $dbc->query("UPDATE ".$_SESSION['rego']['cid']."_temp_log_history SET  updated_to_empreg = '1', no_change = '1' WHERE emp_id = '".$value['emp_id']."' AND batch_team REGEXP CONCAT('(^|,)(', REPLACE('".$sessionTeams."', ',', '|'), ')(,|$)')");

		}
		//echo"UPDATE ".$_SESSION['rego']['cid']."_employees SET ".$condition1." ".$condition2." ".$condition3." ".$condition4." ".$condition5." ".$condition6." ".$condition7." ".$condition8." ".$condition9." ".$condition10." ".$condition11." ".$condition12." ".$condition13." ".$condition14." ".$condition15." ".$condition16." ".$condition17." ".$condition18." ".$condition19." ".$condition20." ".$condition21." ".$condition22." ".$condition23." ".$condition24." ".$condition25." ".$condition26." ".$condition27." ".$condition28." ".$condition29." ".$condition30." ".$condition31." ".$condition32." ".$condition33." ".$condition34." ".$condition35." ".$condition36." ".$condition37." ".$condition38." ".$condition39." ".$condition40." ".$condition41." ".$condition42." ".$condition43." ".$condition44." ".$condition45." ".$condition47." ".$condition46." ".$condition48."  ".$condition49." ".$condition50." ".$condition51."  ".$condition52." ".$condition53." ".$condition54." ".$condition55." ".$condition56." ".$condition57." ".$condition58." ".$condition59." ".$condition60." ".$condition61." ".$condition62." ".$condition63." ".$condition64." ".$condition65." ".$condition66." ".$condition67." ".$condition68." ".$condition68." WHERE emp_id = '".$value['emp_id']."'";
		
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