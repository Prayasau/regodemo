<?

	if(session_id()==''){session_start();}
	ob_start();
	include("../../../dbconnect/db_connect.php");
	//var_dump($_REQUEST); exit;
	
	$sql = "INSERT INTO ".$cid."_divisions (id, apply_division, code, th, en) VALUES ";
	foreach($_REQUEST['divisions'] as $k=>$v){
		//if(!empty($v['code'])){
			$sql .= "('".$k."',";
			$sql .= "'".$dbc->real_escape_string($v['apply_division'])."',";
			$sql .= "'".$dbc->real_escape_string($v['code'])."',";
			$sql .= "'".$dbc->real_escape_string($v['th'])."',";
			$sql .= "'".$dbc->real_escape_string($v['en'])."'),";
		//}
	}
	$sql = substr($sql,0,-1);
	$sql .= " ON DUPLICATE KEY UPDATE apply_division=VALUES(apply_division), th=VALUES(th), en=VALUES(en)";
	//echo($sql); exit;
	
	if($dbc->query($sql)){
		ob_clean();
		echo 'success';
	}else{
		ob_clean();
		echo mysqli_error($dbc);
	}














