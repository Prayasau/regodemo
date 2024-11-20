<?php
	if(session_id()==''){session_start();}
	ob_start();
	include('../../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	include(DIR.'files/arrays_'.$_SESSION['rego']['lang'].'.php');
	include(DIR.'employees/ajax/db_array/db_array_emp.php');
		
	$accountCodeArray = array('0' => 'Direct','1' => 'Indirect');
	$accountCodeArrayReverse = array('Direct' => '0','Indirect' => '1');


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
	
	$datearray = array('joining_date','probation_date');

	
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


					if($field[$k] == 'emp_type'){

						echo $v ;
						if($v != '')
						{
							if(in_array($v, $emp_type))
							{
								$v= $emp_typeReverse[$v]; 
							} 
							else 
							{
							   $v = 'NULL';
							}
						}
						else
						{
							$v = $v;
						}
					}				
					if($field[$k] == 'account_code'){
						

						if($v != '')
						{
							if(in_array($v, $accountCodeArray))
							{
								$v= $accountCodeArrayReverse[$v]; 
							} 
							else 
							{
							   $v = 'NULL';
							}
						}
						else
						{
							$v = $v;
						}

					}						
					

					if($field[$k] == 'joining_date')
					{
						$joiningDate =  $v;

						$checkvalidjoiningDate = validateDate($joiningDate, $format = 'd-m-Y');

						if($joiningDate != '')
							{
								if($checkvalidjoiningDate == '1')
								{
									if($joiningDate != '')
									{
										$dateFormat = new DateTime($joiningDate);
									    $formattedjoiningDate= $dateFormat->format('d-m-Y'); // 31-07-2012
										$v = $formattedjoiningDate;
									}
									else
									{
										$v = $joiningDate;
									}
								}
								else
								{
									$v = 'NULL';
								}
							}
							else if($joiningDate == '')
							{
								$v= 'empty';
							}
							else
							{
								$v= $joiningDate;
							}


					  
					}
				    if($field[$k] == 'probation_date')
					{
						$probationDateVal =  $v;

						$checkvalidProbationDate = validateDate($probationDateVal, $format = 'd-m-Y');
						if($probationDateVal!='')
							{
								if($checkvalidProbationDate == '1')
								{

									if($probationDateVal!='')
									{
									 	$probationDateValFormat = new DateTime($probationDateVal);
									    $formattedprobationDateVal= $probationDateValFormat->format('d-m-Y'); // 31-07-2012
										$v = $formattedprobationDateVal;
									}
									else
									{
										$v = $probationDateVal;
									}
								}
								else
								{
									$v = 'NULL';
								}
							}
							else
							{
								$v = $probationDateVal;
							}
					   

					}		
					

				
					$data[$key]['user_id'] = $sesssionUserId;
					$data[$key][$field[$k]] = $v;

				}
			}
		}
	}
	//var_dump($data); exit;
	// check here if 


	$searlizedData = serialize($data);
	$searlizedFields = serialize($fields);
	$batchNumber = 'batch'. time(); 




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
				// echo '<pre>';
				// print_r($testttttt);
				// echo '</pre>';

				// check herer if the employee id is in database or not then marked it as a new entry 




			//==============================INSERT INTO TEMP LOG HISTORY =======================//

			foreach($val as $kEdit=>$vEdit){

			$changedBy = $_SESSION['rego']['name'] ; // logged in user name 
			$field = $kEdit ; // field name
			$prev = $getAllData[$val['emp_id']][$kEdit]; // previous saved value in temp database
			$user_id = $getAllData[$val['emp_id']]['user_id']; // previous saved value in temp database
			$new = $vEdit; // new value from excel 
			$emp_id = $val['emp_id']; // employee id
			$en_nameValue =  $getAllData[$val['emp_id']]['en_name']; // employee name 
			$dateUpdate = date("Y-m-d H:i:s"); // current date time 

			// check valid birthdate

			if($kEdit == 'joining_date')
			{	

				if($vEdit == 'NULL')
				{
					$new =  $prev; // same value 
					$invalid_value = '1';
					$joining_dateCheck = 'error';
				}				
				else if($vEdit == 'empty')
				{
					$new =  $prev; // same value 
					$invalid_value = '1';
					$joining_dateCheck = 'empty';
				}
				else
				{
					$new = $vEdit ;
					$invalid_value = '0';
					$joining_dateCheck = '';
				}


	
			}			

			if($kEdit == 'probation_date')
			{	

				if($vEdit == 'NULL')
				{
					$new =  $prev; // same value 
					$invalid_value = '1';
					$probation_dateCheck = 'error';
				}
				else
				{
					$new = $vEdit ;
					$invalid_value = '0';
					$probation_dateCheck = '';

				}
	
			}			


			if($kEdit == 'emp_type')
			{	

				if($vEdit == 'NULL')
				{
					$new =  $prev; // same value 
					$invalid_value = '1';
					$emp_typeCheck = 'error';
				}
				else
				{
					$new = $vEdit ;
					$invalid_value = '0';
					$emp_typeCheck = '';
				}
	
			}			

			if($kEdit == 'account_code')
			{	

				if($vEdit == 'NULL')
				{
					$new =  $prev; // same value 
					$invalid_value = '1';
					$account_codeCheck = 'error';
				}
				else
				{
					$new = $vEdit ;
					$invalid_value = '0';
					$account_codeCheck = '';
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

					   $dbc->query("UPDATE  ".$cid."_temp_log_history SET  invalid_value= '".$invalid_value."'  ".$datecondition.", en_name= '".$dbc->real_escape_string($en_nameValue)."' ,batch_team_codes = '".$dbc->real_escape_string($batchCodes)."' , user = '".$dbc->real_escape_string($changedBy)."' , batch_team = '".$dbc->real_escape_string($batchTeams)."', field = '".$dbc->real_escape_string($emp_db[$field])."' ,  prev = '".$dbc->real_escape_string($prev)."', new = '".$dbc->real_escape_string($new)."',emp_id = '".$dbc->real_escape_string($emp_id)."', import_type = '".$import_type."' , missing_info = '0' WHERE emp_id = '".$val['emp_id']."' AND field = '".$emp_db[$field]."'");

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


					if($prev != $new){

						   $dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('0','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
						
					}
					else if(($prev == $new ) && ($invalid_value == '1') )
					{	

						if($joining_dateCheck != '')
						{
							if($joining_dateCheck == 'empty')
							{
								if($field == 'joining_date')
								{
									$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id,missing_info) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."','1' ) ");
								}
							}
							else
							{
								if($field == 'joining_date')
								{
									$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
								}
							}

						}						

						if($probation_dateCheck != '')
						{
							if($field == 'probation_date')
							{
								$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
								
							}
						}						
					
											
						
						if($emp_typeCheck != '')
						{
							if($field == 'emp_type')
							{
								$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
								
							}
						}						

						if($account_codeCheck != '')
						{
							if($field == 'account_code')
							{
								$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
								
							}
						}						
					}

				}
			}

			}

			//==============================INSERT INTO TEMP LOG HISTORY =======================//


			foreach($val as $k=>$v){

				if($k == 'joining_date')
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
				if($k == 'probation_date')
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
				
				if($k == 'emp_type')
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
				if($k == 'account_code')
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
		$sql .= " ON DUPLICATE KEY UPDATE ";
		foreach($data[key($data)] as $key=>$val){

			$sql .= $key." = VALUES(".$key."), ";
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
















