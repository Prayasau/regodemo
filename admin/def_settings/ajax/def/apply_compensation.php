<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../../dbconnect/db_connect.php");
	//var_dump($_REQUEST); exit;

	$checked = ($_REQUEST['checked'] == 'true' ? 1 : 0);
	
	$sql = "UPDATE rego_rewards_penalties SET apply = '".$checked."' WHERE id = '".$_REQUEST['id']."'";
	
	ob_clean();	
	if($dba->query($sql)){
		echo 'success';
	}else{
		echo mysqli_error($dba);
	}

?>