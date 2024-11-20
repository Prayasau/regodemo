<?
	if(session_id()==''){session_start(); ob_start();}
	include('../../../dbconnect/db_connect.php');
	include(DIR.'employees/ajax/db_array/db_array_emp.php');



	$_SESSION['rego']['updateAnythingValue'] ='1';

	$updateValue = $_REQUEST['modal'];


	// get data from temp employee table 

	if($_SESSION['RGadmin']['id'])
	{
		$sesssionUserId = $_SESSION['RGadmin']['id'];
	}
	else
	{
		$sesssionUserId = $_SESSION['rego']['id'];
	}


	// user id who is changing the values in employee blank if admin id if user 

	if(isset($_SESSION['rego']['id']))
	{
		$user_id_who_changes = $_SESSION['rego']['id'];
	}
	else
	{
		$user_id_who_changes = '';
	}


	// get name of the user who made the change in case of admin use rego admin session and in case of user use rego session 
	$changedBy = $_SESSION['rego']['name'];
	// echo '<pre>';
	// print_r($_SESSION);
	// echo '</pre>';

	// die();

	$sqlaLLTeams = "SELECT * FROM ".$cid."_temp_employee_data  WHERE user_id ='".$sesssionUserId."' group by team";
	if($resaLLTeams = $dbc->query($sqlaLLTeams))
	{
		while($rowaLLTeams = $resaLLTeams->fetch_assoc())
		{
			$getAllDataTeams[] = $rowaLLTeams['team'];
		}
	}	

	// make the teams array into string to use in query 

	$teamsArrayString ="'" . implode ( "', '", $getAllDataTeams ) . "'";
	$batchTeams =implode ( ",", $getAllDataTeams );


	// get all teams data from database 
	$sqlaLLTeam = "SELECT * FROM ".$cid."_teams ";
	if($resaLLTeam = $dbc->query($sqlaLLTeam))
	{
		while($rowaLLTeam = $resaLLTeam->fetch_assoc())
		{
			$getAllDataTeam[$rowaLLTeam['id']] = $rowaLLTeam;
		}
	}


	foreach ($getAllDataTeams as $key => $value) {
		$explodedValues[$value] = $value; 
	}

	foreach ($getAllDataTeam as $key => $value) {
		if (in_array($key, $explodedValues)) {

			$allCodes[]= $value['code'];
		}
	}

	$batchCodes = implode(',', $allCodes);




	$sqlaLL = "SELECT * FROM ".$cid."_temp_employee_data  WHERE team in (".$teamsArrayString.")";
	if($resaLL = $dbc->query($sqlaLL))
	{
		while($rowaLL = $resaLL->fetch_assoc())
		{
			$getAllData[$rowaLL['emp_id']] = $rowaLL;
		}
	}
    
// 	    print_r($getAllData);exit;
	// echo '<pre>';
	// print_r($batchCodes);
	// echo '</pre>';

	// die();


	if($updateValue == 'title')
	{
		$postValue = $_REQUEST['modal_title_value'];
	}
	else if ($updateValue == 'sid')
	{
		$postValue= $_REQUEST['modal_scanid_value'];
	}	
	else if ($updateValue == 'firstname')
	{
		$postValue= $_REQUEST['modal_firstname_value'];
	}
	else if ($updateValue == 'lastname')
	{
		$postValue= $_REQUEST['modal_lastname_value'];
	}	
	else if ($updateValue == 'en_name')
	{
		$postValue= $_REQUEST['modal_englishname_value'];
	}
	else if ($updateValue == 'military_status')
	{
		$postValue= $_REQUEST['modal_military_value'];
	}	
	else if ($updateValue == 'height')
	{
		$postValue= $_REQUEST['modal_height_value'];
	}	
	else if ($updateValue == 'weight')
	{
		$postValue= $_REQUEST['modal_weight_value'];
	}	
	else if ($updateValue == 'bloodtype')
	{
		$postValue= $_REQUEST['modal_blood_type_value'];
	}
	else if ($updateValue == 'drvlicense_nr')
	{
		$postValue= $_REQUEST['modal_driving_license_value'];
	}	
	else if ($updateValue == 'drvlicense_exp')
	{
		$postValue= $_REQUEST['modal_driving_license_date_value'];
	}
	else if ($updateValue == 'idcard_nr')
	{
		$postValue= $_REQUEST['modal_id_card_value'];
	}	
	else if ($updateValue == 'idcard_exp')
	{
		$postValue= $_REQUEST['modal_id_card_expiry_value'];
	}	
	else if ($updateValue == 'tax_id')
	{
		$postValue= $_REQUEST['modal_tax_id_value'];
	}	
	else if ($updateValue == 'nationality')
	{
		$postValue= $_REQUEST['modal_nationality_value'];
	}	
	else if ($updateValue == 'gender')
	{
		$postValue= $_REQUEST['modal_gender_value'];
	}	
	else if ($updateValue == 'maritial')
	{
		$postValue= $_REQUEST['modal_maritial_value'];
	}	
	else if ($updateValue == 'religion')
	{
		$postValue= $_REQUEST['modal_religion_value'];
	}
	else if ($updateValue == 'birthdate')
	{
		$postValue= $_REQUEST['modal_birthdate_value'];
	}else if ($updateValue == 'sso_id')
	{
	    $postValue= $_REQUEST['modal_sso_id_value'];
	}else if ($updateValue == 'same_tax')
	{
	    $postValue= $_REQUEST['modal_same_tax_value'];
	}else if ($updateValue == 'same_sso')
	{
	    $postValue= $_REQUEST['modal_same_sso_value'];
	}
    //echo $postValue.$updateValue;die();
	if($updateValue=='tax_id'||$updateValue=='sso_id'){
	    foreach ($getAllData as $key => $value){
	        $same_as_id=unserialize($value['same_as_id']);
	        if ($updateValue == 'tax_id')
	        {
	            //$postValue= $_REQUEST['modal_same_tax_value'];
	            $postValue1=serialize(array('same_tax'=>$_REQUEST['check_same_tax'],'same_sso'=>$same_as_id['same_sso']));
	            $updateValue1='same_as_id';
	            if($_REQUEST['check_same_tax']=='on'){
	                $updatesame='tax_id';
	                $postsame=$value['idcard_nr'];
	            }else $postsame=$postValue;
	        }else if ($updateValue == 'sso_id')
	        {
	            //$postValue= $_REQUEST['modal_same_sso_value'];
	            $postValue1=serialize(array('same_sso'=>$_REQUEST['check_same_sso'],'same_tax'=>$same_as_id['same_tax']));
	            $updateValue1='same_as_id';
	            if($_REQUEST['check_same_sso']=='on'){
	                $updatesame='sso_id';
	                $postsame=$value['idcard_nr'];
	            }else $postsame=$postValue;
	        }
	        //echo $updatesame.$postsame;
	        $dbc->query("UPDATE ".$_SESSION['rego']['cid']."_temp_employee_data SET  ".$updateValue1." = '".$postValue1."',".$updatesame." = '".$postsame."' WHERE id='{$value['id']}'");
	    }
	}
	else if($updateValue != 'same_tax' && $updateValue != 'same_sso')
	$dbc->query("UPDATE ".$_SESSION['rego']['cid']."_temp_employee_data SET  ".$updateValue." = '".$postValue."' ");
	else{
	    $updateValue1=$updateValue;
	    $postValue1=$postValue;
	    foreach ($getAllData as $key => $value) {
	    $same_as_id=unserialize($value['same_as_id']);
	    //print_r($same_as_id);
	    if ($updateValue == 'same_tax')
	    {
	        //$postValue= $_REQUEST['modal_same_tax_value'];
	        $postValue1=serialize(array($updateValue=>$postValue,'same_sso'=>$same_as_id['same_sso']));
	        $updateValue1='same_as_id';
	        if($postValue=='on'){
	            $updatesame='tax_id';
	            $postsame=$value['idcard_nr'];
	        }
	    }else if ($updateValue == 'same_sso')
	    {
	        //$postValue= $_REQUEST['modal_same_sso_value'];
	        $postValue1=serialize(array($updateValue=>$postValue,'same_tax'=>$same_as_id['same_tax']));
	        $updateValue1='same_as_id';
	        if($postValue=='on'){
	            $updatesame='sso_id';
	            $postsame=$value['idcard_nr'];
	        }
	        
	    }
	    if(!empty($postsame))$dbc->query("UPDATE ".$_SESSION['rego']['cid']."_temp_employee_data SET  ".$updateValue1." = '".$postValue1."',".$updatesame." = '".$postsame."' WHERE id='{$value['id']}'");
	    else $dbc->query("UPDATE ".$_SESSION['rego']['cid']."_temp_employee_data SET  ".$updateValue1." = '".$postValue1."' WHERE id='{$value['id']}'");
	    
	    echo "UPDATE ".$_SESSION['rego']['cid']."_temp_employee_data SET  ".$updateValue1." = '".$postValue1."',".$updatesame." = '".$postsame."' WHERE id='{$value['id']}'";
	    }}
	// make an entry in log table 


	// $batchCodes = $batchCodes;
	$batchNumber = 'batch'. time(); 
	$import_type = 'old';
	$invalid_value = '0';
	$dateUpdate = date("Y-m-d H:i:s"); // current date time 

	foreach ($getAllData as $key => $value) {

	  
		// check if needs to insert or update  

		$sqlaLL1 = "SELECT * FROM ".$cid."_temp_log_history WHERE emp_id = '".$value['emp_id']."' AND field = '".$emp_db[$updateValue]."'";
			if($resaLL1 = $dbc->query($sqlaLL1))
			{
				if($rowaLL1 = $resaLL1->fetch_assoc())
				{
					// update

					$dbc->query("UPDATE  ".$cid."_temp_log_history SET   date = '".$dateUpdate."' ,  prev = '".$dbc->real_escape_string($value[$updateValue])."', new = '".$dbc->real_escape_string($postValue)."' WHERE emp_id = '".$value['emp_id']."' AND field = '".$emp_db[$updateValue]."'");

				}
				else
				{
					// insert 
					$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('0','".$dbc->real_escape_string($value['en_name'])."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$updateValue])."','".$dbc->real_escape_string($value[$updateValue])."','".$dbc->real_escape_string($postValue)."','".$dbc->real_escape_string($value['emp_id'])."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($sesssionUserId)."' ) ");
				}
			}


		  

	}
	

	
	 //die();
	ob_clean();
	echo 'success';
?>