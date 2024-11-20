<?

	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");
	include(DIR.'files/functions.php');

	if($res = $dbc->query("SELECT * FROM ".$cid."_users WHERE id = '".$_REQUEST['userID']."' ")){
		$c_exist = $res->fetch_assoc();

		$update = $dbc->query("UPDATE ".$cid."_users SET `activities`= '".serialize($_REQUEST['activity'])."' WHERE `id`= '".$_REQUEST['userID']."' ");

		ob_clean();
		echo 'success';

	}else{
		ob_clean();
		echo 'error';
	}

	exit;
?>