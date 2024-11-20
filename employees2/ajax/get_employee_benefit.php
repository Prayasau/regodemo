<?
	if(session_id()==''){session_start();}
	ob_start();

	include("../../dbconnect/db_connect.php");
	//var_dump($_REQUEST); exit;
	
	$data = array();
	$sql = "SELECT * FROM ".$cid."_employee_".$_REQUEST['field']." WHERE id = '".$_REQUEST['id']."'";
	if($res = $dbc->query($sql)){
		$data = $res->fetch_assoc();
		$data['attachment'] = unserialize($data['attachments']);

		if($_REQUEST['field'] == 'career'){
			$data['fix_allows'] = unserialize($data['fix_allow']);
			$data['fix_deducts'] = unserialize($data['fix_deduct']);
		}
	}
	
	ob_clean();
	echo json_encode($data);