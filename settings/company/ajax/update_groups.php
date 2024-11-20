<?

	if(session_id()==''){session_start();}
	ob_start();
	include("../../../dbconnect/db_connect.php");
	//var_dump($_REQUEST); exit;
	
	$sql = "INSERT INTO ".$cid."_groups (id, apply_group, code, th, en) VALUES ";
	foreach($_REQUEST['groups'] as $k=>$v){
		if(!empty($v['code'])){
			$sql .= "('".$k."',";
			$sql .= "'".$dbc->real_escape_string($v['apply_group'])."',";
			$sql .= "'".$dbc->real_escape_string($v['code'])."',";
			$sql .= "'".$dbc->real_escape_string($v['th'])."',";
			$sql .= "'".$dbc->real_escape_string($v['en'])."'),";
		}
	}
	$sql = substr($sql,0,-1);
	$sql .= " ON DUPLICATE KEY UPDATE apply_group=VALUES(apply_group), th=VALUES(th), en=VALUES(en)";
	//echo($sql); exit;
	
	if($dbc->query($sql)){
		ob_clean();
		echo 'success';
	}else{
		ob_clean();
		echo mysqli_error($dbc);
	}

