<?
	if(session_id()==''){session_start(); ob_start();}
	include('../../../dbconnect/db_connect.php');
	include(DIR.'employees/ajax/db_array/db_array_emp.php');
	include(DIR.'files/functions.php');





	// get data from temp employee table 


	// user id who is changing the values in employee blank if admin id if user 
	$dir = DIR.$cid.'/career/';
  	if(!file_exists($dir)){
   		mkdir($dir);
	}
	
	if(!empty($_FILES['attachment_curr']['tmp_name'][0])){
		$sql = "SELECT attachments FROM ".$cid."_employee_career WHERE id = '".$_REQUEST['career_id_curr']."'";
		if($res = $dbc->query($sql)){
			$row = $res->fetch_assoc();
			if(!empty($row['attachments'])){
				$_REQUEST['attachments'] = unserialize($row['attachments']);
			}
		}
		foreach($_FILES['attachment_curr']['tmp_name'] as $k=>$v){
			$filename = $_FILES['attachment_curr']['name'][$k];	
			$baseName = pathinfo($filename, PATHINFO_FILENAME );
			$extension = pathinfo($filename, PATHINFO_EXTENSION );
			$counter = 1;				
			while(file_exists($dir.$filename)) {
				 $filename = $baseName.'('.$counter.').'.$extension;
				 $counter++;
			};
			if(move_uploaded_file($v,$dir.$filename)){
				$_REQUEST['attachments'][] = $filename;	
			}
		}

		
		$_REQUEST['attachments_curr'] = serialize($_REQUEST['attachments']);
		
				
	}

	
	if(!empty($_FILES['attachment_new']['tmp_name'][0])){
		
		foreach($_FILES['attachment_curr']['tmp_name'] as $k=>$v){
			$filename = $_FILES['attachment_curr']['name'][$k];	
			$baseName = pathinfo($filename, PATHINFO_FILENAME );
			$extension = pathinfo($filename, PATHINFO_EXTENSION );
			$counter = 1;				
			while(file_exists($dir.$filename)) {
				 $filename = $baseName.'('.$counter.').'.$extension;
				 $counter++;
			};
			if(move_uploaded_file($v,$dir.$filename)){
				$_REQUEST['attachments'][] = $filename;	
			}
		}
		
		$_REQUEST['attachments_new'] = serialize($_REQUEST['attachments']);
	}


	//$start_date_curr_month = date('m', strtotime($_REQUEST['start_date_curr']));
	
	$_REQUEST['start_date_curr'] = date('Y-m-d', strtotime($_REQUEST['start_date_curr']));

	if($_REQUEST['career_id_curr'] !=''){

		$USQl = $dbc->query("UPDATE ".$cid."_employee_career SET start_date='".$_REQUEST['start_date_curr']."', end_date='".$_REQUEST['end_date_curr']."', position='".$_REQUEST['position_curr']."', salary='".$_REQUEST['salary_curr']."', fix_allow='".serialize($_REQUEST['emp_fixa_curr'])."', fix_deduct='".serialize($_REQUEST['emp_fixd_curr'])."', other_benifits='".$_REQUEST['other_benifits_curr']."', remarks='".$_REQUEST['remarks_curr']."', attachments='".$_REQUEST['attachments_curr']."', head_branch='".$_REQUEST['head_branch_cur']."', head_division='".$_REQUEST['head_division_cur']."', head_department='".$_REQUEST['head_department_curr']."', team_supervisor='".$_REQUEST['team_supervisor_curr']."' WHERE id = '".$_REQUEST['career_id_curr']."' ");
	}

	if($_REQUEST['start_date_new'] !=''){



		$_REQUEST['start_date_new'] = date('Y-m-d', strtotime($_REQUEST['start_date_new']));
		$start_date_new_month = date('m', strtotime($_REQUEST['start_date_new']));
		$checkSQl = $dbc->query("SELECT * FROM ".$cid."_employee_career WHERE emp_id = '".$_REQUEST['emp_id']."' AND month = '".$start_date_new_month."' ");
		if($checkSQl->num_rows > 0){
			//nothing to do...
		}else{
			
			$USQl = $dbc->query("INSERT INTO ".$cid."_employee_career (`month`, `emp_id`, `position`, `fix_allow`, `fix_deduct`, `start_date`, `end_date`, `salary`, `other_benifits`, `remarks`, `attachments`, `head_branch`, `head_division`, `head_department`, `team_supervisor`) VALUES ('".$start_date_new_month."', '".$_REQUEST['emp_id']."', '".$_REQUEST['position_new']."', '".serialize($_REQUEST['emp_fixa_new'])."', '".serialize($_REQUEST['emp_fixd_new'])."', '".$_REQUEST['start_date_new']."', '".$_REQUEST['end_date_new']."', '".$_REQUEST['salary_new']."', '".$_REQUEST['other_benifits_new']."', '".$_REQUEST['remarks_new']."', '".$_REQUEST['attachments_new']."', '".$_REQUEST['head_branch_new']."', '".$_REQUEST['head_division_new']."', '".$_REQUEST['head_department_new']."', '".$_REQUEST['team_supervisor_new']."')"); 

			if($_REQUEST['career_id_curr'] !=''){
				$end_date_curr = date('d-m-Y', strtotime($_REQUEST['start_date_new'] . '-1 days'));
				$USQl = $dbc->query("UPDATE ".$cid."_employee_career SET end_date='".$end_date_curr."' WHERE id='".$_REQUEST['career_id_curr']."' ");
			}
		}
	}

	$data['result'] = 'success';
	echo json_encode($data);



	// if($_SESSION['RGadmin']['id'])
	// {
	// 	$sesssionUserId = $_SESSION['RGadmin']['id'];
	// }
	// else
	// {
	// 	$sesssionUserId = $_SESSION['rego']['id'];
	// }

	// if(isset($_SESSION['rego']['id']))
	// {
	// 	$user_id_who_changes = $_SESSION['rego']['id'];
	// }
	// else
	// {
	// 	$user_id_who_changes = '';
	// }


	// // // get name of the user who made the change in case of admin use rego admin session and in case of user use rego session 
	// $changedBy = $_SESSION['rego']['name'];

	// $sqlaLLTeams = "SELECT * FROM ".$cid."_temp_employee_data  WHERE user_id ='".$sesssionUserId."' group by team";
	// if($resaLLTeams = $dbc->query($sqlaLLTeams))
	// {
	// 	while($rowaLLTeams = $resaLLTeams->fetch_assoc())
	// 	{
	// 		$getAllDataTeams[] = $rowaLLTeams['team'];
	// 	}
	// }	

	// // // make the teams array into string to use in query 

	// $teamsArrayString ="'" . implode ( "', '", $getAllDataTeams ) . "'";
	// $batchTeams =implode ( ",", $getAllDataTeams );


	// // // get all teams data from database 
	// $sqlaLLTeam = "SELECT * FROM ".$cid."_teams ";
	// if($resaLLTeam = $dbc->query($sqlaLLTeam))
	// {
	// 	while($rowaLLTeam = $resaLLTeam->fetch_assoc())
	// 	{
	// 		$getAllDataTeam[$rowaLLTeam['id']] = $rowaLLTeam;
	// 	}
	// }


	// foreach ($getAllDataTeams as $key => $value) {
	// 	$explodedValues[$value] = $value; 
	// }

	// foreach ($getAllDataTeam as $key => $value) {
	// 	if (in_array($key, $explodedValues)) {

	// 		$allCodes[]= $value['code'];
	// 	}
	// }

	// $batchCodes = implode(',', $allCodes);




	// $sqlaLL = "SELECT * FROM ".$cid."_temp_employee_data  WHERE team in (".$teamsArrayString.")";
	// if($resaLL = $dbc->query($sqlaLL))
	// {
	// 	while($rowaLL = $resaLL->fetch_assoc())
	// 	{
	// 		$getAllData[$rowaLL['emp_id']] = $rowaLL;
	// 	}
	// }



	// $updateValue = $_REQUEST['fieldToUpdate'];
	// $postValue   = $_REQUEST['dataToUpdate'];



	// $dbc->query("UPDATE ".$_SESSION['rego']['cid']."_temp_employee_data SET  ".$updateValue." = '".$postValue."' ");

	// // make an entry in log table 


	// // $batchCodes = $batchCodes;
	// $batchNumber = 'batch'. time(); 
	// $import_type = 'old';
	// $invalid_value = '0';
	// $dateUpdate = date("Y-m-d H:i:s"); // current date time 

	// foreach ($getAllData as $key => $value) {


	// 	// check if needs to insert or update  

	// 	$sqlaLL1 = "SELECT * FROM ".$cid."_temp_log_history WHERE emp_id = '".$value['emp_id']."' AND field = '".$emp_db[$updateValue]."'";
	// 		if($resaLL1 = $dbc->query($sqlaLL1))
	// 		{
	// 			if($rowaLL1 = $resaLL1->fetch_assoc())
	// 			{
	// 				// update

	// 				$dbc->query("UPDATE  ".$cid."_temp_log_history SET   date = '".$dateUpdate."' ,  prev = '".$dbc->real_escape_string($value[$updateValue])."', new = '".$dbc->real_escape_string($postValue)."' WHERE emp_id = '".$value['emp_id']."' AND field = '".$emp_db[$updateValue]."'");

	// 			}
	// 			else
	// 			{
	// 				// insert 
	// 				$dbc->query("INSERT INTO ".$cid."_temp_log_history (no_change,en_name,batch_team_codes,user,batch_team, field, prev, new, emp_id,batch_no,import_type,invalid_value,user_id) VALUES ('0','".$dbc->real_escape_string($value['en_name'])."','".$dbc->real_escape_string($batchCodes)."','".$dbc->real_escape_string($changedBy)."','".$dbc->real_escape_string($batchTeams)."','".$dbc->real_escape_string($emp_db[$updateValue])."','".$dbc->real_escape_string($value[$updateValue])."','".$dbc->real_escape_string($postValue)."','".$dbc->real_escape_string($value['emp_id'])."','".$dbc->real_escape_string($batchNumber)."','".$dbc->real_escape_string($import_type)."','".$dbc->real_escape_string($invalid_value)."','".$dbc->real_escape_string($sesssionUserId)."' ) ");
	// 			}
	// 		}


		  

	// }
	

	
	// die();
	ob_clean();
	echo 'success';
?>