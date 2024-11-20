<?php
	if(session_id()==''){session_start();}
	ob_start();
	include('../../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	include(DIR.'files/arrays_'.$_SESSION['rego']['lang'].'.php');
	include(DIR.'employees/ajax/db_array/db_array_emp.php');

	// get defaultAdmin Settings 
	$getDefaultAdminSettings = getDefaultValueFromAdmin();

	// array for fields which are needed in log history 
	$arrayNotNeededInLogHistory = array('user_id','calc_tax','calc_method','calc_sso','contract_type','calc_base','calc_psf','calc_pvf');

	if($_SESSION['RGadmin']['id'])
	{
		$sesssionUserId = $_SESSION['RGadmin']['id'];
	}
	else
	{
		$sesssionUserId = $_SESSION['rego']['id'];
	}



	$dir = '../../'.$cid.'/employees/';
	if (!file_exists($dir)) {
		mkdir($dir, 0755, true);
	}

	if(!empty($_FILES)) {
		 $tempFile = $_FILES['file']['tmp_name'];
		 $targetFile =  $dir. $_FILES['file']['name'];
		 move_uploaded_file($tempFile,$targetFile);
	}
	//$targetFile = '../../docs/rego01000_employees.xlsx';
	//$emp_id = $_REQUEST['prefix'].'-'.sprintf('%04d', $nr);
	
	$datearray = array('birthdate','drvlicense_exp','idcard_exp');
	//$datearray = array('birthdate');
	//var_dump($prefix); exit;
	
	$sheetData = array();
	$inputFileName = $targetFile; 
	
	require_once DIR.'PhpSpreadsheet/vendor/autoload.php';
	use PhpOffice\PhpSpreadsheet\IOFactory;
	
	$inputFileType = IOFactory::identify($inputFileName);
	$reader = IOFactory::createReader($inputFileType);
	$reader->setReadDataOnly(true); 
	$reader->setReadEmptyCells(false);
	$spreadsheet = $reader->load($inputFileName);
	
	$sheetData = $spreadsheet->getActiveSheet()->toArray('', false, false, false);
	//$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
	// 1. Value returned in the array entry if a cell doesn't exist
	// 2. Should formulas be calculated ?
	// 3. Should formatting be applied to cell values ?
	// 4. False - Return a simple array of rows and columns indexed by number counting from zero 
	// 4. True - Return rows and columns indexed by their actual row and column IDs
	//var_dump($sheetData[1]); // database field names ///////////////////////////
	//var_dump($sheetData[2]); // excel file real headers ////////////////////////
	//exit;

	$type = $sheetData[0][0]; 

	if($sys_settings['auto_id'] == '1'){

		$prefixArrayDb = unserialize($sys_settings['id_prefix']);
		$counter= 1 ;
		foreach ($prefixArrayDb as $key => $value) {
			$count =$counter++ ;
			$prefixArrVal[$value['idPrefix']] = $value['startCount'];
			$prefixArrValData[] = $value['idPrefix'];
		}


		foreach($prefixArrVal as $key => $v){
			$sql = "SELECT emp_id FROM ".$cid."_temp_employee_data WHERE emp_id LIKE '".$key."%' ORDER BY emp_id DESC LIMIT 1";
			if($res = $dbc->query($sql)){
				while($row = $res->fetch_assoc()){
					$tmp = explode('-',$row['emp_id']);
					$prefixArrVal[$key] = (int)$tmp[1]+1;
				}
			}
		}

	}
	
	$field = $sheetData[1];
	$field = array_filter($field);

	unset($sheetData[0], $sheetData[1], $sheetData[2]);

	$data = array();
	foreach($sheetData as $key=>$val){
		if(!empty($val[0])){

			//======================= AUTO NUMBERING ========================//
			if( $sys_settings['auto_id'] == '1'){
				$pref = $val[0];

				if( in_array( $pref ,$prefixArrValData ) )
				{
					$val[0] .= '-'.sprintf('%04d', $prefixArrVal[$pref]);
					$prefixArrVal[$pref] ++;
				}

			}

			foreach($val as $k=>$v){
				if(isset($field[$k])){
					if($sys_settings['auto_id'] == '1' && $field[$k] == 'emp_id'){
						$data[$key]['emp_id'] = $val[0];
						//======= CHECK IS SCAN ID SETTING IS ON FROM EMPLOYEE DEFAULT AND SET VALUE ACCORDING TO THAT 

					}
					if(in_array($field[$k],$datearray) && !empty($v)){
						$str = str_replace('/','-',$v);



						if(is_numeric($v)){

							// $v = date('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($str));
							$checkvalidBirthdate2 = validateDate($v, $format = 'd-m-Y');

							if($checkvalidBirthdate2 == '1')
							{
								$v = $v;
							}
							else
							{
								$v = 'NULL';
							}
						}
						else
						{

						 	if(preg_match('/^\pL+$/u', $str)){
								$v = 'NULL';
							}
							else
							{
					
								$checkvalidBirthdate3 = validateDate($str, $format = 'd-m-Y');
								if($checkvalidBirthdate3 == '1')
								{

									$date = new DateTime($str);
									$v = date_format($date, "d-m-Y");
								}
								else
								{

									$v = 'NULL';
								}

							}
							
						}

					
							


						$year = date('Y', strtotime($v));
						if($year > (date('Y') + 200)){
							$year -= 543;
							$v =date('d-m-', strtotime($v)).$year;
						}
			
					}

					if($sys_settings['scan_id'] == '1')
					{
						$data[$key]['sid'] = $val[0];
					}

					if($field[$k] == 'idcard_nr' || $field[$k] == 'tax_id'){
						$v = str_replace(' ','', $v);
						$v = str_replace('-','', $v);
						$v = str_replace('/','', $v);
					}	

					if($field[$k] == 'title'){

						if(in_array($v, $title))
						{
							$v= $titleReverse[$v]; 
						} 
						else 
						{
						   $v = 'NULL';
						}
					}				
					if($field[$k] == 'gender'){
						
						if(in_array($v, $gender))
						{
							$v= $genderReverse[$v]; 
						} 
						else 
						{
						   $v = 'NULL';
						}

					}						
					if($field[$k] == 'maritial'){

						if(in_array($v, $maritial))
						{
							$v= $maritialReverse[$v]; 
						} 
						else 
						{
						   $v = 'NULL';
						}

					}	
					if($field[$k] == 'religion'){

						if(in_array($v, $religion))
						{
							$v= $religionReverse[$v]; 
						} 
						else 
						{
						   $v = 'NULL';
						}

					}					
					if($field[$k] == 'military_status'){

						if(in_array($v, $military_status))
						{
							$v= $military_statusReverse[$v]; 
						} 
						else 
						{
						   $v = 'NULL';
						}

					}	
					if($field[$k] == 'height')
					{
						if (preg_match("/^\d+$/", $v)) 
						{
							$v= $v;    
						} 
						else 
						{
						   $v = 'NULL';
						}
					}					

					if($field[$k] == 'nationality')
					{
						if (preg_match('/^\pL+$/u', $v)) 
						{
							$v= $v;    
						} 
						else 
						{
						   $v = 'NULL';
						}
					}						
					if($field[$k] == 'drvlicense_nr')
					{
						if (preg_match("/^\d+$/", $v)) 
						{
							$v= $v;    
						} 
						else 
						{
						   $v = 'NULL';
						}
					}					

					if($field[$k] == 'tax_id')
					{
						if (preg_match("/^\d+$/", $v)) 
						{
							$v= $v;    
						} 
						else if($v == '')
						{
							$v = 'empty';
						}
						else
						{
						   $v = 'NULL';
						}
					}					
					if($field[$k] == 'idcard_nr')
					{
						if (preg_match("/^\d+$/", $v)) 
						{
							$v= $v;    
						} 
						else 
						{
						   $v = 'NULL';
						}
					}						

					if($field[$k] == 'weight')
					{
						if (preg_match("/^\d+$/", $v)) 
						{
							$v= $v;    
						} 
						else 
						{
						   $v = 'NULL';
						}
					}						

					if($field[$k] == 'bloodtype')
					{
						if (preg_match("/^(A|B|AB|O)[+-]$/i", $v)) 
						{
							$v= $v;    
						} 
						else 
						{
						   $v = 'NULL';
						}
					}		

					if($field[$k] == 'birthdate')
					{
						$datOfBirth =  $v;

						$checkvalidBirthdate = validateDate($datOfBirth, $format = 'd-m-Y');

						if($checkvalidBirthdate == '1')
						{
							if($datOfBirth != '')
							{
								$dateFormat = new DateTime($datOfBirth);
							    $formattedDateOfBirth= $dateFormat->format('d-m-Y'); // 31-07-2012
								$v = $formattedDateOfBirth;
							}
							else
							{
								$v = $datOfBirth;
							}
						}
						else
						{
							$v = 'NULL';
						}


					  
					}
				    if($field[$k] == 'drvlicense_exp')
					{
						$driverLicenseExp =  $v;

						$checkvalidBirthdate = validateDate($driverLicenseExp, $format = 'd-m-Y');

						if($checkvalidBirthdate == '1')
						{

							if($driverLicenseExp!='')
							{
							 	$driverLiceExpFormat = new DateTime($driverLicenseExp);
							    $formattedDriverLicenseExp= $driverLiceExpFormat->format('d-m-Y'); // 31-07-2012
								$v = $formattedDriverLicenseExp;
							}
							else
							{
								$v = $driverLicenseExp;
							}
						}
						else
						{
							$v = 'NULL';
						}
					   

					}		
					if($field[$k] == 'idcard_exp')
					{
						$idCardExp =  $v;

						$checkvalidBirthdate = validateDate($idCardExp, $format = 'd-m-Y');

						if($checkvalidBirthdate == '1')
						{

							if($idCardExp != '')
							{
								$idCardExpFormat = new DateTime($idCardExp);
							    $formattedIdCardExp= $idCardExpFormat->format('d-m-Y'); // 31-07-2012
								$v = $formattedIdCardExp;
							}
							else
							{
								$v = $idCardExp;
							}
						}
					    else
						{
							$v = 'NULL';
						}
					}

				
					$data[$key]['user_id'] = $sesssionUserId;

					$data[$key]['calc_tax'] 		= $getDefaultAdminSettings['calc_tax'];
					$data[$key]['calc_method']	= $getDefaultAdminSettings['calc_method'];
					$data[$key]['calc_sso'] 		= $getDefaultAdminSettings['calc_sso'];
					$data[$key]['contract_type']  = $getDefaultAdminSettings['contract_type'];
					$data[$key]['calc_base']		= $getDefaultAdminSettings['calc_base'];
					$data[$key]['calc_psf']	 	= $getDefaultAdminSettings['calc_psf'];
					$data[$key]['calc_pvf'] 	    = $getDefaultAdminSettings['calc_pvf'];
					$data[$key][$field[$k]] = $v;

				}
			}
		}
	}
	//var_dump($data); exit;
	// check here if 
	// echo '<pre>';
	// print_r($data);
	// echo '</pre>';

	// die();

	$searlizedData = serialize($data);
	$searlizedFields = serialize($fields);
	$batchNumber = 'batch'. time(); 

	// 	echo '<pre>';
	// print_r($data);
	// echo '</pre>';

	// die();




	//===============================GET TEMPOARRY DATA BEFORE IMPORT=======================//

	$sqlaLL = "SELECT * FROM ".$cid."_temp_employee_data ";
	if($resaLL = $dbc->query($sqlaLL))
	{
		while($rowaLL = $resaLL->fetch_assoc())
		{
			$getAllData[$rowaLL['emp_id']] = $rowaLL;
		}
	}
	
	$sqlaLLTeam = "SELECT * FROM ".$cid."_teams ";
	if($resaLLTeam = $dbc->query($sqlaLLTeam))
	{
		while($rowaLLTeam = $resaLLTeam->fetch_assoc())
		{
			$getAllDataTeam[$rowaLLTeam['id']] = $rowaLLTeam;
		}
	}


	$batchTeams = $_SESSION['rego']['sel_teams'];

	// convert batch teams into codes

	$explodeValue = explode(',', $batchTeams);

	foreach ($explodeValue as $key => $value) {
		$explodedValues[$value] = $value; 
	}

	foreach ($getAllDataTeam as $key => $value) {
		if (in_array($key, $explodedValues)) {

			$allCodes[]= $value['code'];
		}
	}

	$batchCodes = implode(',', $allCodes);



	//===============================GET TEMPOARRY DATA BEFORE IMPORT=======================//
	reset($data);

	
	if($data){	
		$sql = "INSERT INTO ".$_SESSION['rego']['cid']."_temp_employee_data (";
		foreach($data[key($data)] as $key=>$val){
			$sql .= $key.', ';
		}
		//echo $sql; exit;
		
		$sql = substr($sql,0,-2);
		$sql .= ') VALUES (';

		foreach($data as $key=>$val){

				$CheckIfExists = $getAllData[$val['emp_id']];

				if($CheckIfExists != '')
				{
					$import_type = 'old';
				}
				else
				{
					$import_type = 'new';
				}


				// check herer if the employee id is in database or not then marked it as a new entry 




			//==============================INSERT INTO TEMP LOG HISTORY =======================//

			foreach($val as $kEdit=>$vEdit){

			$changedBy = $_SESSION['rego']['name'] ; // logged in user name 
			$field = $kEdit ; // field name
			$prev = $getAllData[$val['emp_id']][$kEdit]; // previous saved value in temp database
			$user_id = $getAllData[$val['emp_id']]['user_id']; // previous saved value in temp database
			$new = $vEdit; // new value from excel 
			$emp_id = $val['emp_id']; // employee id
			$en_nameValue = $val['en_name']; // employee name 
			$dateUpdate = date("Y-m-d H:i:s"); // current date time 



			// check valid birthdate

			if($kEdit == 'birthdate'){	if($vEdit == 'NULL'){$new =  $prev; $invalid_value = '1';$birthdateCheck = 'error';}else{$new = $vEdit ;$invalid_value = '0';$birthdateCheck = '';}}	

			// check drvlicense-exp
			if($kEdit == 'drvlicense_exp'){	if($vEdit == 'NULL'){$new =  $prev; $invalid_value = '1';$drvlicense_expCheck = 'error';}else{$new = $vEdit ;$invalid_value = '0';$drvlicense_expCheck = '';}}		

			// check idcard_exp
			if($kEdit == 'idcard_exp'){if($vEdit == 'NULL'){$new =  $prev;$invalid_value = '1';$idcard_expCheck = 'error';}else{$new = $vEdit ;$invalid_value = '0';$idcard_expCheck = '';}}		

			// check height
			if($kEdit == 'height'){	if($vEdit == 'NULL'){$new =  $prev; $invalid_value = '1';$heightCheck = 'error';}else{$new = $vEdit ;$invalid_value = '0';$heightCheck = '';}}		

			// check nationality
			if($kEdit == 'nationality'){if($vEdit == 'NULL'){$new =  $prev; $invalid_value = '1';$nationalityCheck = 'error';}else{$new = $vEdit ;$invalid_value = '0';$nationalityCheck = '';}}	

			// check weight 
			if($kEdit == 'weight'){	if($vEdit == 'NULL'){$new =  $prev; $invalid_value = '1';$weightCheck = 'error';}else{$new = $vEdit ;$invalid_value = '0';$weightCheck = '';}}		

			// check bloodtype
			if($kEdit == 'bloodtype'){if($vEdit == 'NULL'){$new =  $prev; $invalid_value = '1';$bloodtypeCheck = 'error';}else{$new = $vEdit ;$invalid_value = '0';$bloodtypeCheck = '';}}			

			// check drvlicense_nr
			if($kEdit == 'drvlicense_nr'){if($vEdit == 'NULL'){$new =  $prev; $invalid_value = '1';$drvlicense_nrCheck = 'error';}else{$new = $vEdit ;$invalid_value = '0';$drvlicense_nrCheck = '';}}			

			// check tax_id
			if($kEdit == 'tax_id'){if($vEdit == 'NULL'){$new =  $prev; $invalid_value = '1';$tax_idCheck = 'error';}else if($vEdit == 'empty'){$new =  $prev;$invalid_value = '1';$tax_idCheck = 'empty';}else{$new = $vEdit ;$invalid_value = '0';$tax_idCheck = '';}}			

			// check idcard_nr
			if($kEdit == 'idcard_nr'){if($vEdit == 'NULL'){$new =  $prev; $invalid_value = '1';$idcard_nrCheck = 'error';}else{$new = $vEdit ;$invalid_value = '0';$idcard_nrCheck = '';}}			

			// check title 
			if($kEdit == 'title'){if($vEdit == 'NULL'){$new =  $prev; $invalid_value = '1';$titleCheck = 'error';}else{$new = $vEdit ;$invalid_value = '0';$titleCheck = '';}}			

			// check gender 
			if($kEdit == 'gender'){if($vEdit == 'NULL'){$new =  $prev; $invalid_value = '1';$genderCheck = 'error';}else{$new = $vEdit ;$invalid_value = '0';$genderCheck = '';}}			


			// check maritial
			if($kEdit == 'maritial')
			{	

				if($vEdit == 'NULL')
				{
					$new =  $prev; // same value 
					$invalid_value = '1';
					$maritialCheck = 'error';
				}
				else
				{
					$new = $vEdit ;
					$invalid_value = '0';
					$maritialCheck = '';
				}
	
			}			

			if($kEdit == 'religion')
			{	

				if($vEdit == 'NULL')
				{
					$new =  $prev; // same value 
					$invalid_value = '1';
					$religionCheck = 'error';
				}
				else
				{
					$new = $vEdit ;
					$invalid_value = '0';
					$religionCheck = '';
				}
	
			}			

			if($kEdit == 'military_status')
			{	

				if($vEdit == 'NULL')
				{
					$new =  $prev; // same value 
					$invalid_value = '1';
					$military_statusCheck = 'error';
				}
				else
				{
					$new = $vEdit ;
					$invalid_value = '0';
					$military_statusCheck = '';
				}
	
			}

			$sqlaLL1 = "SELECT * FROM ".$cid."_temp_log_history WHERE emp_id = '".$val['emp_id']."' AND field = '".$emp_db[$field]."'";
			if($resaLL1 = $dbc->query($sqlaLL1))
			{
				if($rowaLL1 = $resaLL1->fetch_assoc())
				{	

					if($prev != $new)
					{
						$datecondition = ",date = '".$dateUpdate."'" ;
					}

					  $dbc->query("UPDATE  ".$cid."_temp_log_history SET  invalid_value= '".$invalid_value."'  ".$datecondition.", en_name= '".$dbc->real_escape_string($en_nameValue)."' ,batch_team_codes = '".$dbc->real_escape_string($batchCodes)."' , user = '".$dbc->real_escape_string($changedBy)."' , batch_team = '".$dbc->real_escape_string($batchTeams)."', field = '".$dbc->real_escape_string($emp_db[$field])."' ,  prev = '".$dbc->real_escape_string($prev)."', new = '".$dbc->real_escape_string($new)."',emp_id = '".$dbc->real_escape_string($emp_id)."', import_type = '".$import_type."', missing_info = '0' WHERE emp_id = '".$val['emp_id']."' AND field = '".$emp_db[$field]."'");

					if($prev == $new)
					{

						$dbc->query("UPDATE  ".$cid."_temp_log_history SET  no_change= '1'  WHERE emp_id = '".$val['emp_id']."' AND field = '".$emp_db[$field]."'");
					}
					else if($prev != $new)
					{
						$dbc->query("UPDATE  ".$cid."_temp_log_history SET  no_change= '0'  WHERE emp_id = '".$val['emp_id']."' AND field = '".$emp_db[$field]."'");
					}

				}
				else
				{
					if(!in_array($field,$arrayNotNeededInLogHistory))
					{
						if($prev != $new){



							  $dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('0','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
							
						}
						else if(($prev == $new ) && ($invalid_value == '1') )
						{	

							if($birthdateCheck != '')
							{
								if($field == 'birthdate')
								{
									$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
								}
							}						

							if($drvlicense_expCheck != '')
							{
								if($field == 'drvlicense_exp')
								{
									$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
								}
							}						

							if($idcard_expCheck != '')
							{
								if($field == 'idcard_exp')
								{
									$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
								}
							}						

							if($heightCheck != '')
							{
								if($field == 'height')
								{
									$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
								}
							}						

							if($nationalityCheck != '')
							{
								if($field == 'nationality')
								{
									$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
								}
							}						

							if($weightCheck != '')
							{
								if($field == 'weight')
								{
									$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
								}
							}						

							if($bloodtypeCheck != '')
							{
								if($field == 'bloodtype')
								{
									$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value, user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
								}
							}

							if($drvlicense_nrCheck != '')
							{
								if($field == 'drvlicense_nr')
								{
									$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."' ,'".$dbc->real_escape_string($user_id)."' ) ");
								}
							}						
							if($idcard_nrCheck != '')
							{
								if($field == 'idcard_nr')
								{
									$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
								}
							}						

							if($tax_idCheck != '')
							{
								if($tax_idCheck == 'error')
								{
									if($field == 'tax_id')
									{
										$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
									}	
								}							
								else if($tax_idCheck == 'empty')
								{
									if($field == 'tax_id')
									{
										$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id,missing_info) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."','1' ) ");
									}	
								}

							}						
							if($titleCheck != '')
							{
								if($field == 'title')
								{
									$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
								}
							}						

							if($genderCheck != '')
							{
								if($field == 'gender')
								{
									$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
								}
							}						

							if($maritialCheck != '')
							{
								if($field == 'maritial')
								{
									$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
								}
							}						
							if($religionCheck != '')
							{
								if($field == 'religion')
								{
									$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
								}
							}						

							if($military_statusCheck != '')
							{
								if($field == 'military_status')
								{
									$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
								}
							}

						}
					}

				}
			}

			}

			//==============================INSERT INTO TEMP LOG HISTORY =======================//


			foreach($val as $k=>$v){

				if($k == 'birthdate')
				{	
					if($v == 'NULL')
					{
						$v = $getAllData[$val['emp_id']][$k];
					}
					else
					{
						$v = $v;
					}
				}	
				if($k == 'drvlicense_exp')
				{
					if($v == 'NULL')
					{
						$v = $getAllData[$val['emp_id']][$k];
					}
					else
					{
						$v = $v;
					}
				}				
				if($k == 'idcard_exp')
				{
					if($v == 'NULL')
					{
						$v = $getAllData[$val['emp_id']][$k];
					}
					else
					{
						$v = $v;
					}
				}				
				if($k == 'height')
				{
					if($v == 'NULL')
					{
						$v = $getAllData[$val['emp_id']][$k];
					}
					else
					{
						$v = $v;
					}
				}	
				 if($k == 'nationality')
				{
					if($v == 'NULL')
					{
						$v = $getAllData[$val['emp_id']][$k];
					}
					else
					{
						$v = $v;
					}
				}	
				if($k == 'weight')
				{
					if($v == 'NULL')
					{
						$v = $getAllData[$val['emp_id']][$k];
					}
					else
					{
						$v = $v;
					}
				}		
				if($k == 'bloodtype')
				{
					if($v == 'NULL')
					{
						$v = $getAllData[$val['emp_id']][$k];
					}
					else
					{
						$v = $v;
					}
				}				
				if($k == 'drvlicense_nr')
				{
					if($v == 'NULL')
					{
						$v = $getAllData[$val['emp_id']][$k];
					}
					else
					{
						$v = $v;
					}
				}				
				if($k == 'idcard_nr')
				{
					if($v == 'NULL')
					{
						$v = $getAllData[$val['emp_id']][$k];
					}
					else
					{
						$v = $v;
					}
				}				
				if($k == 'title')
				{
					if($v == 'NULL')
					{
						$v = $getAllData[$val['emp_id']][$k];
					}
					else
					{
						$v = $v;
					}
				}				
				if($k == 'tax_id')
				{
					if($v == 'NULL')
					{
						$v = $getAllData[$val['emp_id']][$k];
					}
					else if($v == 'empty')
					{
						$v = $getAllData[$val['emp_id']][$k];
					}
					else
					{
						$v = $v;
					}
				}				
				if($k == 'gender')
				{
					if($v == 'NULL')
					{
						$v = $getAllData[$val['emp_id']][$k];
					}
					else
					{
						$v = $v;
					}
				}				
				if($k == 'maritial')
				{
					if($v == 'NULL')
					{
						$v = $getAllData[$val['emp_id']][$k];
					}
					else
					{
						$v = $v;
					}
				}				
				if($k == 'religion')
				{
					if($v == 'NULL')
					{
						$v = $getAllData[$val['emp_id']][$k];
					}
					else
					{
						$v = $v;
					}
				}				
				if($k == 'military_status')
				{
					if($v == 'NULL')
					{
						$v = $getAllData[$val['emp_id']][$k];
					}
					else
					{
						$v = $v;
					}
				}
		


				$sql .= "'".$dbc->real_escape_string($v)."', ";
			}
			$sql = substr($sql,0,-2);
			$sql .= '),(';
		}

		$sql = substr($sql,0,-2);
		// echo $sql;
		// exit;
		
		reset($data);
		// unset additional values from data array here 


	
		// $data[$key]['calc_tax'] 		= $getDefaultAdminSettings['calc_tax'];
		// $data[$key]['calc_method']	= $getDefaultAdminSettings['calc_method'];
		// $data[$key]['calc_sso'] 		= $getDefaultAdminSettings['calc_sso'];
		// $data[$key]['contract_type']  = $getDefaultAdminSettings['contract_type'];
		// $data[$key]['calc_base']		= $getDefaultAdminSettings['calc_base'];
		// $data[$key]['calc_psf']	 	= $getDefaultAdminSettings['calc_psf'];
		// $data[$key]['calc_pvf'] 	    = $getDefaultAdminSettings['calc_pvf'];



		$sql .= " ON DUPLICATE KEY UPDATE ";
		foreach($data[key($data)] as $key=>$val){



			if(!in_array($key,$arrayNotNeededInLogHistory))
			{
				$sql .= $key." = VALUES(".$key."), ";
			}



		}
		$sql = substr($sql,0,-2);
		// echo $sql; exit;
		// exit;
		
		$res = $dbc->query($sql);
		// $_SESSION['rego']['updateAnythingValue'] ='1';
		
		

		// die();
		// Import into temp log history 



		ob_clean();
		echo 'success';
		exit;
		
	}
?>
















