<?
	if(session_id()==''){session_start(); ob_start();}
	include('../../../dbconnect/db_connect.php');
	include(DIR.'employees/ajax/db_array/db_array_emp.php');




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


	// // get name of the user who made the change in case of admin use rego admin session and in case of user use rego session 
	$changedBy = $_SESSION['rego']['name'];

	$sqlaLLTeams = "SELECT * FROM ".$cid."_temp_employee_data  WHERE user_id ='".$sesssionUserId."' group by team";
	if($resaLLTeams = $dbc->query($sqlaLLTeams))
	{
		while($rowaLLTeams = $resaLLTeams->fetch_assoc())
		{
			$getAllDataTeams[] = $rowaLLTeams['team'];
		}
	}	

	// // make the teams array into string to use in query 

	$teamsArrayString ="'" . implode ( "', '", $getAllDataTeams ) . "'";
	$batchTeams =implode ( ",", $getAllDataTeams );


	// // get all teams data from database 
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



	// echo '<pre>';
	// print_r($getAllData);
	// echo '</pre>';

	// die();

	$updateValue = $_REQUEST['fieldToUpdate'];
	$postValue   = $_REQUEST['dataToUpdate'];

	$fieldsArray = array(

		'company' => $_REQUEST['companyValue'],
		'location' => $_REQUEST['locationValue'],
		'division' => $_REQUEST['divisionValue'],
		'department' => $_REQUEST['departmentsvalue'],
		'team' => $_REQUEST['teamNumericValue'],
	);




	foreach ($fieldsArray as $keyfield1 => $valuefield1) {

		// $sss= "UPDATE ".$_SESSION['rego']['cid']."_temp_employee_data SET  ".$keyfield1." = '".$valuefield1."' ";
		$dbc->query("UPDATE ".$_SESSION['rego']['cid']."_temp_employee_data SET  ".$keyfield1." = '".$valuefield1."' ");

		// echo '<pre>';
		// print_r($sss);
		// echo '</pre>';


	}
	// die();

	// make an entry in log table 

	// $batchCodes = $batchCodes;
	$batchNumber = 'batch'. time(); 
	$import_type = 'old';
	$invalid_value = '0';
	$dateUpdate = date("Y-m-d H:i:s"); // current date time 


	// echo '<pre>';
	// print_r($getAllData);
	// echo '</pre>';

	// die();
	foreach ($getAllData as $key => $value) {


		// check if needs to insert or update  
		foreach ($fieldsArray as $keyfield => $valuefield) {


		$sqlaLL1 = "SELECT * FROM ".$cid."_temp_log_history WHERE emp_id = '".$value['emp_id']."' AND field = '".$emp_db[$keyfield]."'";
			if($resaLL1 = $dbc->query($sqlaLL1))
			{
				if($rowaLL1 = $resaLL1->fetch_assoc())
				{
					// update

					$dbc->query("UPDATE  ".$cid."_temp_log_history SET   date = '".$dateUpdate."' ,  prev = '".$dbc->real_escape_string($value[$keyfield])."', new = '".$dbc->real_escape_string($valuefield)."' WHERE emp_id = '".$value['emp_id']."' AND field = '".$emp_db[$keyfield]."'");

				}
				else
				{
					// insert 
					$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('0','".$dbc->real_escape_string($value['en_name'])."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$keyfield])."','".$dbc->real_escape_string($value[$keyfield])."','".$dbc->real_escape_string($valuefield)."','".$dbc->real_escape_string($value['emp_id'])."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($sesssionUserId)."' ) ");
				}
			}

		}
		  

	}
	

	
	
	// die();
	ob_clean();
	echo 'success';
?>