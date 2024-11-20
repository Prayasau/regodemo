<?php

	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");
	include(DIR.'files/functions.php');
	//var_dump($_REQUEST); exit;
	//$field = $_REQUEST['field'];
	if(empty($_REQUEST['emp_id'])){exit;}

	// echo '<pre>';
	// print_r($_REQUEST);
	// print_r($_FILES);
	// echo '</pre>';

	// echo serialize($_REQUEST['emp_fixa_curr']);
	// echo '<br>';
	// echo serialize($_REQUEST['emp_fixd_curr']);
	// exit;

	//var_dump($_FILES); //exit;
	//$getAllowDedctName = getAllowDedctName();


	$dir = DIR.$cid.'/career/';
  	if(!file_exists($dir)){
   		mkdir($dir);
	}
	
	if(!empty($_FILES['attachment']['tmp_name'][0])){
		
		foreach($_FILES['attachment']['tmp_name'] as $k=>$v){
			$filename = $_FILES['attachment']['name'][$k];	
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

		
		$_REQUEST['attachment'] = serialize($_REQUEST['attachments']);
		
				
	}

	//$start_date_curr_month = date('m', strtotime($_REQUEST['start_date_curr']));

	if($_REQUEST['start_date'] !=''){
		$start_date_new_month = date('m', strtotime($_REQUEST['start_date']));
		$checkSQl = $dbc->query("SELECT * FROM ".$cid."_employee_career WHERE emp_id = '".$_REQUEST['emp_id']."' AND month = '".$start_date_new_month."' ");
		if($checkSQl->num_rows > 0){
			//nothing to do...
		}else{
			$USQl = $dbc->query("INSERT INTO ".$cid."_employee_career (`month`, `emp_id`, `position`, `fix_allow`, `fix_deduct`, `start_date`, `end_date`, `salary`, `other_benifits`, `remarks`, `attachments`) VALUES ('".$start_date_new_month."', '".$_REQUEST['emp_id']."', '".$_REQUEST['position']."', '".serialize($_REQUEST['emp_fixa_new'])."', '".serialize($_REQUEST['emp_fixd_new'])."', '".$_REQUEST['start_date']."', '".$_REQUEST['end_date']."', '".$_REQUEST['salary']."', '".$_REQUEST['other_benifits']."', '".$_REQUEST['remarks']."', '".$_REQUEST['attachment']."')"); 
		}
	}

	$data['result'] = 'success';
	echo json_encode($data);
	
?>	
