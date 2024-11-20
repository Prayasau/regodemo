<?
	
	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");
	//var_dump($_FILES); //exit;


	$resed = $dbc->query("SELECT ".$_REQUEST['doc']." FROM ".$cid."_entities_data where ref='".$_REQUEST['ref']."'");
	if($resed->num_rows > 0){
		$rowed = $resed->fetch_assoc();
		$fileed = $rowed[$_REQUEST['doc']];

		$dir = '../../'.$cid.'/documents/'.$fileed;
		unlink($dir);
		$res = $dbc->query("UPDATE ".$cid."_entities_data SET ".$_REQUEST['doc']." = '' where ref='".$_REQUEST['ref']."' ");
	}
	
	$res = $dbc->query("UPDATE ".$cid."_company_settings SET ".$_REQUEST['doc']." = ''");
	
	//var_dump($file); //exit;
	//var_dump($_REQUEST); exit;
