<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../dbconnect/db_connect.php");
	//var_dump($_REQUEST); exit;
	
	$data = array();
	if($res = $dba->query("SELECT * FROM rego_customers WHERE id = '".$_REQUEST["id"]."'")){
		if($row = $res->fetch_assoc()){
			$data = $row;
		}
	}
	//var_dump($data); exit;
	ob_clean();
	echo json_encode($data);
	exit;
	//var_dump($data);
?>
