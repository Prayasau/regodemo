<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../../dbconnect/db_connect.php");
	//var_dump($_REQUEST); //exit;
	
	$sql = "INSERT INTO ".$cid."_rewards_penalties (";
	foreach($_REQUEST as $k=>$v){
		$sql .= $k.", ";
	}
	$sql = substr($sql,0,-2);
	$sql .= ") VALUES (";
	//echo $sql; exit;
	
	foreach($_REQUEST as $k=>$v){
		$sql .= "'".$dba->real_escape_string($v)."', ";
	}
	$sql = substr($sql,0,-2).")";
	//echo $sql; exit;
	
	$sql .= " ON DUPLICATE KEY UPDATE ";
	foreach($_REQUEST as $k=>$v){
		$sql .= $k." = VALUES(".$k."), ";
	}
	$sql = substr($sql,0,-2);
	//echo $sql; //exit;
	
	ob_clean();	
	if($dba->query($sql)){
		echo 'success';
	}else{
		echo mysqli_error($dba);
	}

?>