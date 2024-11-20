<?php
	if(session_id()==''){session_start();}
	ob_start();
	include('../../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	include(DIR.'files/arrays_'.$_SESSION['rego']['lang'].'.php');
	include(DIR.'employees/ajax/db_array/db_array_emp.php');


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
	////////////////////////////////////////////
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
	
	$sqlgetgroups = "SELECT * FROM ".$cid."_groups ";
	if($resgetgroups = $dbc->query($sqlgetgroups))
	{
	    while($rowgetgroups = $resgetgroups->fetch_assoc())
	    {
	        $getAllGroups[$rowgetgroups['id']]= $rowgetgroups['en'];
	    }
	}
	$income_section=array(1=>'PND1 40(1) salaries wages as employees',2=>'PND1 40(1)  salaries wages under 3%',3=>'PND1 40(2) Other compensations',6=>'PND1 40(1) (2) Single payment by reason of termination', 4=>'PND3 40(8) Income from Business',5=>'None');
	
	///////////////////////////////////////////////
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
           //print_r($val[0]);
			foreach($val as $k=>$v){
			    //echo ' '.$k.' '.$v;
				if(isset($field[$k])){
					if($sys_settings['auto_id'] == '1' && $field[$k] == 'emp_id'){
						$data[$key]['emp_id'] = $val[0];
						//======= CHECK IS SCAN ID SETTING IS ON FROM EMPLOYEE DEFAULT AND SET VALUE ACCORDING TO THAT 

					}

					if($field[$k] == 'contract_type'){
					    if(in_array($v, $contract_type)){
						    $v= array_search($v,$contract_type); 
						} 
						else{
						   $v = 'NULL';
						}
					}				
					if($field[$k] == 'calc_base'){
					    
					    if(in_array($v, $calc_base))
					    {
					        $v= array_search($v,$calc_base);
					    }
					    else
					    {
					        $v = 'NULL';
					    }
					}
					if($field[$k] == 'bank_name'){
					    if(in_array($v, $banksarray)){
					        $v= array_search($v,$banksarray);
					        
					    }
					    else{
					        $v = 'NULL';
					    }
					}	
					if($field[$k] == 'bank_code'){
					    //echo sprintf('%03d',$v);
					    if(array_key_exists(sprintf('%03d',$v), $banksarray)){
					        $v= $v;
					    }
					    else{
					        $v = 'NULL';
					    }
					}
					if($field[$k] == 'pay_type'){
					    if(in_array($v, $pay_type)){
					        $v= array_search($v,$pay_type);
					    }
					    else{
					        $v = 'NULL';
					    }
					}
					if($field[$k] == 'account_code'){
					    if(in_array($v, $accountCodeArray)){
					        $v= array_search($v,$accountCodeArray);
					    }
					    else{
					        $v = 'NULL';
					    }
					}
					if($field[$k] == 'calc_method'){
					    if(in_array($v, $calcmethod)){
					        $v= array_search($v,$calcmethod);
					    }
					    else{
					        $v = 'NULL';
					    }
					}
					if($field[$k] == 'calc_tax'){
					    //echo $v;
					    if(in_array($v, $calctax)){
					        $v= array_search($v,$calctax);
					    }
					    else{
					        $v = 'NULL';
					    }
					}
					if($field[$k] == 'tax_residency_status'){
					    if(in_array($v, $tax_residency_status)){
					        $v= array_search($v,$tax_residency_status);
					    }
					    else{
					        $v = 'NULL';
					    }
					}
					if($field[$k] == 'income_section'){
					    if(in_array($v, $income_section)){
					        $v= array_search($v,$income_section);
					    }
					    else{
					        $v = 'NULL';
					    }
					}
					if($field[$k] == 'calc_sso'){
					    //echo ' '.$v;
					    if(in_array($v, $noyes01)){
					        $v= array_search($v,$noyes01);
					    }
					    else{
					        $v = 'NULL';
					    }
					}
					if($field[$k] == 'sso_by'){
					    if(in_array($v, $sso_paidby)){
					        $v= array_search($v,$sso_paidby);
					    }
					    else{
					        $v = 'NULL';
					    }
					}
					if($field[$k] == 'groups'){
					    if(in_array($v, $getAllGroups)){
					        $v= array_search($v,$getAllGroups);
					    }
					    else{
					        $v = 'NULL';
					    }
					}
					
					
					if($field[$k] == 'bank_account')
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

					if($field[$k] == 'modify_tax')
					{
					    //echo $v;exit;
						if (preg_match("/^\d+$/", $v)) 
						{
							$v= $v;    
						} 
						else 
						{
						   $v = 'NULL';
						}
					}						
					if($field[$k] == 'savings')
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

					if($field[$k] == 'legal_execution')
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
					if($field[$k] == 'kor_yor_sor')
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
					$data[$key]['user_id'] = $sesssionUserId;
					$data[$key][$field[$k]] = $v;

				}
			}
		}
	}
	//var_dump($data); exit;
	// check here if 
	/* echo '<pre>';
	print_r($data);
	echo '</pre>';

	die(); */

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
	//print_r($getAllData);exit;
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


    //print_r($data)
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
            //echo $kEdit.' '.$vEdit.' ';
			$changedBy = $_SESSION['rego']['name'] ; // logged in user name 
			$field = $kEdit ; // field name
			$prev = $getAllData[$val['emp_id']][$kEdit]; // previous saved value in temp database
			$user_id = $getAllData[$val['emp_id']]['user_id']; // previous saved value in temp database
			$new = $vEdit; // new value from excel 
			$emp_id = $val['emp_id']; // employee id
			$en_nameValue = $getAllData[$val['emp_id']]['en_name']; // employee name 
			$dateUpdate = date("Y-m-d H:i:s"); // current date time 


			if($kEdit == 'bank_account')
			{	

				if($vEdit == 'NULL')
				{
					$new =  $prev; // same value 
					$invalid_value = '1';
					$bankaccountCheck = 'error';
				}
				else
				{
					$new = $vEdit ;
					$invalid_value = '0';
					$bankaccountCheck = '';

				}
	
			}			

			if($kEdit == 'modify_tax')
			{	
               
				if($vEdit == 'NULL')
				{
					$new =  $prev; // same value 
					$invalid_value = '1';
					$modifytaxCheck = 'error';
				}
				else
				{
					$new = $vEdit ;
					$invalid_value = '0';
					$modifytaxCheck = '';

				}
	
			}			
			if($kEdit == 'savings')
			{	

				if($vEdit == 'NULL')
				{
					$new =  $prev; // same value 
					$invalid_value = '1';
					$savingsCheck = 'error';
				}
				else
				{
					$new = $vEdit ;
					$invalid_value = '0';
					$savingsCheck = '';
				}
	
			}			
			if($kEdit == 'legal_execution')
			{	

				if($vEdit == 'NULL')
				{
					$new =  $prev; // same value 
					$invalid_value = '1';
					$legalexecCheck = 'error';
				}
				else
				{
					$new = $vEdit ;
					$invalid_value = '0';
					$leaglexecCheck = '';
				}
	
			}			

			if($kEdit == 'kor_yor_sor'){	
				if($vEdit == 'NULL'){
					$new =  $prev; // same value 
					$invalid_value = '1';
					$koryorsorCheck = 'error';
				}else{
					$new = $vEdit ;
					$invalid_value = '0';
					$koryorsorCheck = '';
				}
			}	
			if($kEdit == 'contract_type'){
			    if($vEdit == 'NULL'){
			        $new =  $prev; // same value
			        $invalid_value = '1';
			        $contracttypeCheck = 'error';
			    }else{
			        $new = $vEdit ;
			        $invalid_value = '0';
			        $contracttypeCheck = '';
			    }
			}	
			if($kEdit == 'calc_base'){
			    if($vEdit == 'NULL'){
			        $new =  $prev; // same value
			        $invalid_value = '1';
			        $calc_baseCheck = 'error';
			    }else{
			        $new = $vEdit ;
			        $invalid_value = '0';
			        $calc_baseCheck = '';
			    }
			}	
			if($kEdit == 'bank_code'){
			    if($vEdit == 'NULL' || (isset($bankname)&& $bankname!=$bankcode)&& !isset($bank)){
			        $new =  $prev; // same value
			        $invalid_value = '1';
			        $bank_codeCheck = 'error';
			    }else{
			        $new = $vEdit ;
			        $invalid_value = '0';
			        $bank_codeCheck = '';
			    }
			    $bank=1;
			}	
			if($kEdit == 'bank_name'){
			    if($vEdit == 'NULL' || (isset($bankcode)&& $bankname!=$bankcode&& !isset($bank))){
			        $new =  $prev; // same value
			        $invalid_value = '1';
			        $bank_nameCheck = 'error';
			    }else{
			        $new = $vEdit ;
			        $invalid_value = '0';
			        $bank_nameCheck = '';
			    }
			    $bank=1;
			}	
			if($kEdit == 'bank_branch'){
			    if($vEdit == 'NULL'){
			        $new =  $prev; // same value
			        $invalid_value = '1';
			        $bank_branchCheck = 'error';
			    }else{
			        $new = $vEdit ;
			        $invalid_value = '0';
			        $bank_branchCheck = '';
			    }
			}	
			if($kEdit == 'bank_account_name'){
			    if($vEdit == 'NULL'){
			        $new =  $prev; // same value
			        $invalid_value = '1';
			        $bank_account_nameCheck = 'error';
			    }else{
			        $new = $vEdit ;
			        $invalid_value = '0';
			        $bank_account_nameCheck = '';
			    }
			}	
			
			if($kEdit == 'pay_type'){
			    if($vEdit == 'NULL'){
			        $new =  $prev; // same value
			        $invalid_value = '1';
			        $pay_typeCheck = 'error';
			    }else{
			        $new = $vEdit ;
			        $invalid_value = '0';
			        $pay_typeCheck = '';
			    }
			}
			if($kEdit == 'account_code'){
			    if($vEdit == 'NULL'&&$vEdit!=0){
			        //echo 0=='NULL';
			        $new =  $prev; // same value
			        $invalid_value = '1';
			        $account_codeCheck = 'error';
			    }else{
			        //echo 'vbrvrvr';
			        $new = $vEdit ;
			        if($vEdit==0)$new='0';
			        $invalid_value = '0';
			        $account_codeCheck = '';
			    }
			    //exit;
			} 
			if($kEdit == 'groups'){
			    if($vEdit == 'NULL'){
			        $new =  $prev; // same value
			        $invalid_value = '1';
			        $groupsCheck = 'error';
			    }else{
			        $new = $vEdit ;
			        $invalid_value = '0';
			        $koryorsorCheck = '';
			    }
			}	
			if($kEdit == 'calc_method'){
			    if($vEdit == 'NULL'){
			        $new =  $prev; // same value
			        $invalid_value = '1';
			        $calc_methodCheck = 'error';
			    }else{
			        $new = $vEdit ;
			        $invalid_value = '0';
			        $calc_methodCheck = '';
			    }
			}
			if($kEdit == 'tax_residency_status'){
			    if($vEdit == 'NULL'){
			        $new =  $prev; // same value
			        $invalid_value = '1';
			        $tax_residency_statusCheck = 'error';
			    }else{
			        $new = $vEdit ;
			        $invalid_value = '0';
			        $tax_residency_statusCheck = '';
			    }
			}
			if($kEdit == 'income_section'){
			    if($vEdit == 'NULL'){
			        $new =  $prev; // same value
			        $invalid_value = '1';
			        $income_sectionCheck = 'error';
			    }else{
			        $new = $vEdit ;
			        $invalid_value = '0';
			        $income_sectionCheck = '';
			    }
			}
			if($kEdit == 'calc_sso' &&$vEdit!=0){
			    if($vEdit == 'NULL'){
			        $new =  $prev; // same value
			        $invalid_value = '1';
			        $calc_ssoCheck = 'error';
			    }else{
			        $new = $vEdit ;
			        if($vEdit==0)$new='0';
			        $invalid_value = '0';
			        $calc_ssoCheck = '';
			    }
			}
			if($kEdit == 'sso_by'){
			    //echo $vEdit;
			    if($vEdit == 'NULL'&&$vEdit!=0){
			        //echo 'rwtht';
			        $new =  $prev; // same value
			        $invalid_value = '1';
			        $sso_byCheck = 'error';
			    }else{
			        $new = $vEdit ;
			        if($vEdit==0)$new='0';
			        $invalid_value = '0';
			        $sso_byCheck = '';
			    }
			    //exit;
			}
			if($kEdit == 'gov_house_banking'){
			    if($vEdit == 'NULL'){
			        $new =  $prev; // same value
			        $invalid_value = '1';
			        $gov_house_bankingCheck = 'error';
			    }else{
			        $new = $vEdit ;
			        $invalid_value = '0';
			        $gov_house_bankingCheck = '';
			    }
			}
			if($kEdit == 'calc_method'){
			    if($vEdit == 'NULL'){
			        $new =  $prev; // same value
			        $invalid_value = '1';
			        $tax_calc_methodCheck = 'error';
			    }else{
			        $new = $vEdit ;
			        $invalid_value = '0';
			        $tax_calc_methodCheck = '';
			    }
			}
			if($kEdit == 'calc_tax'){
			    if($vEdit == 'NULL' &&$vEdit!=0){
			        $new =  $prev; // same value
			        $invalid_value = '1';
			        $calc_taxCheck = 'error';
			    }else{
			        $new = $vEdit ;
			        if($vEdit==0)$new='0';
			        $invalid_value = '0';
			        $calc_taxCheck = '';
			    }
			}
			
            //echo $new.' ';
			$sqlaLL1 = "SELECT * FROM ".$cid."_temp_log_history WHERE emp_id = '".$val['emp_id']."' AND field = '".$emp_db[$field]."'";
			if($resaLL1 = $dbc->query($sqlaLL1))
			{
				if($rowaLL1 = $resaLL1->fetch_assoc())
				{	

					if($prev != $new)
					{
					    //echo $field.';';
						$datecondition = ",date = '".$dateUpdate."'" ;
					}

					  $dbc->query("UPDATE  ".$cid."_temp_log_history SET  invalid_value= '".$invalid_value."'  ".$datecondition.", en_name= '".$dbc->real_escape_string($en_nameValue)."' ,batch_team_codes = '".$dbc->real_escape_string($batchCodes)."' , user = '".$dbc->real_escape_string($changedBy)."' , batch_team = '".$dbc->real_escape_string($batchTeams)."', field = '".$dbc->real_escape_string($emp_db[$field])."' ,  prev = '".$dbc->real_escape_string($prev)."', new = '".$dbc->real_escape_string($new)."',emp_id = '".$dbc->real_escape_string($emp_id)."', import_type = '".$import_type."', missing_info = '0' WHERE emp_id = '".$val['emp_id']."' AND field = '".$emp_db[$field]."'");

					if($prev == $new)
					{
					    //echo $field.',';

						$dbc->query("UPDATE  ".$cid."_temp_log_history SET  no_change= '1'  WHERE emp_id = '".$val['emp_id']."' AND field = '".$emp_db[$field]."'");
					}
					else if($prev != $new)
					{  
					    //echo $field.'|'.$new.'v '.$prev." ";
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
                        
						if($contracttypeCheck != '')
						{
							if($field == 'contract_type')
							{
								$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
							}
						}						

						if($calc_baseCheck != '')
						{
							if($field == 'calc_base')
							{
								$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
							}
						}						

						if($bank_nameCheck != '')
						{
							if($field == 'bank_name')
							{
								$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
							}
						}						

						if($bank_codeCheck != '')
						{
							if($field == 'bank_code')
							{
								$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
							}
						}						

						if($bank_branchCheck != '')
						{
							if($field == 'bank_branch')
							{
								$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
							}
						}						

						if($bankaccountCheck != '')
						{
							if($field == 'bank_account')
							{
								$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
							}
						}
						
						if($bank_account_nameCheck != '')
						{
						    if($field == 'bank_account_name`')
						    {
						        $dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
						    }
						}

						if($pay_typeCheck != '')
						{
							if($field == 'pay_type')
							{
								$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value, user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
							}
						}

						if($account_codeCheck != '')
						{
							if($field == 'account_code')
							{
								$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."' ,'".$dbc->real_escape_string($user_id)."' ) ");
							}
						}						
						if($groupsCheck != '')
						{
							if($field == 'groups')
							{
								$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
							}
						}						
					
						if($tax_calc_methodCheck != '')
						{
							if($field == 'calc_method')
							{
								$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
							}
						}						

						if($calc_taxCheck != '')
						{
							if($field == 'calc_tax')
							{
								$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
							}
						}						

						if($tax_residency_statusCheck != '')
						{
						    //echo $sql;exit;
							if($field == 'tax_residency_status')
							{
							    //echo $sql;exit;
								$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
							}
						}						
						if($income_sectionCheck != '')
						{
						    //echo $sql;exit;
							if($field == 'income_section')
							{
							    //echo $sql;exit;
								$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
							}
						}						

						if($modifytaxCheck != '')
						{
							if($field == 'modify_tax')
							{
							    //echo $sql;exit;
								$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
							}
						}
						if($calc_ssoCheck != '')
						{
						    if($field == 'calc_sso')
						    {
						        $dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
						    }
						}
						if($sso_byCheck != '')
						{
						    if($field == 'sso_by')
						    {
						        $dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
						    }
						}
						if($gov_house_bankingCheck != '')
						{
						    if($field == 'gov_house_banking')
						    {
						        $dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
						    }
						}
						if($savingsCheck != '')
						{
						    if($field == 'savings')
						    {
						        $dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
						    }
						}
						if($legalexecCheck != '')
						{
						    if($field == 'legal_execution')
						    {
						        $dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('1','".$dbc->real_escape_string($en_nameValue)."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$field])."','".$dbc->real_escape_string($prev)."','".$dbc->real_escape_string($new)."','".$dbc->real_escape_string($emp_id)."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($user_id)."' ) ");
						    }
						}
						if($koryorsorCheck != '')
						{
						    if($field == 'kor_yor_sor')
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

				if($k == 'contract_type')
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
				if($k == 'calc_base')
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
				if($k == 'pay_type')
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
				 if($k == 'bank_name')
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
				if($k == 'bank_code')
				{
					if($v == 'NULL')
					{
						$v = $getAllData[$val['emp_id']][$k];
					}
					else
					{
					    $v = sprintf('%03d',$v);
					}
				}		
				if($k == 'calc_method')
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
				if($k == 'calc_tax')
				{
				    if($v == 'NULL' &&$v!=0)
					{
						$v = $getAllData[$val['emp_id']][$k];
					}
					else
					{
						$v = $v;
					}
				}				
				if($k == 'tax_residency_status')
				{
					if($v == 'NULL')
					{
						$v = $getAllData[$val['emp_id']][$k];
					}
					else
					{
						$v = $v;
					}
					//exit;
					
				}				
				if($k == 'income_section')
				{
				    //exit;
					if($v == 'NULL')
					{
						$v = $getAllData[$val['emp_id']][$k];
					}
					else
					{
						$v = $v;
					}
				}				
				if($k == 'calc_sso')
				{   
				    if($v == 'NULL' &&$v!=0)
					{
						$v = $getAllData[$val['emp_id']][$k];
					}
					else
					{
						$v = $v;
					}
					
				}				
				if($k == 'sso_by')
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
				    //echo ' rrv'.$v;
				    if($v == 'NULL' &&$v!=0)
				    {
				        $v = $getAllData[$val['emp_id']][$k];
				    }
				    else
				    {
				        $v = $v;
				    }
				}	
				if($k == 'groups')
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
				if($k == 'bank_account')
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
				if($k == 'modify_tax')
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
				if($k == 'gov_house_banking')
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
				if($k == 'savings')
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
				if($k == 'legal_execution')
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
				if($k == 'kor_yor_sor')
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
                //echo ' '.$v.' '.$k;
				$sql .= "'".$dbc->real_escape_string($v)."', ";
			}
			$sql = substr($sql,0,-2);
			$sql .= '),(';
		}

		$sql = substr($sql,0,-2);
		 //echo $sql;
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



		//ob_clean();
		echo 'success';
		exit;
		
	}
?>
















