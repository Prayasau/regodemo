<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");


	$teams = explode(',', trim($_REQUEST['teams']));
	

	echo '<pre>';
	print_r($teams);

	exit;

	$teams = array();
	if($res = $dbc->query("SELECT * FROM ".$cid."_teams")){
		while($row = $res->fetch_assoc()){
			$teams[$row['id']] = $row;
		}
	}

?>