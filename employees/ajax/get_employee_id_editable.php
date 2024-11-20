<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");
	//var_dump($_REQUEST); exit;
	$exist = 0;
	$sql = "SELECT emp_id_editable FROM ".$cid."_employees WHERE emp_id_editable = '".$_REQUEST['emp_id_editable']."'";
	if($res = $dbc->query($sql)){
		$row = $res->fetch_assoc();
		if($row['emp_id_editable'] == $_REQUEST['emp_id_editable']){
			$exist = 1;
		}			
	}

	ob_clean();
	echo $exist;
	
?>
