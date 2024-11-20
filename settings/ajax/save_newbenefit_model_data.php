<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");
	include(DIR.'files/functions.php');

	foreach ($_REQUEST['apply'] as $key => $value) {
		if($value == 1){	

			$sql = "INSERT INTO ".$cid."_benefit_models (`apply`, `code`, `tab_name`, `name`, `description`) VALUES ('".$value."', '".$_REQUEST['mcode'][$key]."', '".$_REQUEST['tabName'][$key]."', '".$_REQUEST['mname'][$key]."', '".$_REQUEST['description'][$key]."')";
			$dbc->query($sql);
		}
	}	
		
	ob_clean();
	echo 'success';

?>