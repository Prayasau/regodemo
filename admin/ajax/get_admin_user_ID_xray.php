<?
	if(session_id()==''){session_start(); ob_start();}
	include("../dbconnect/db_connect.php");
	//var_dump($_REQUEST); exit;
	//$_REQUEST['id'] = '100';
	// $id = '5a6effb9c35ab';


	$left = '5a6effb9c' ;
	// $id= '35';
	$right = 'ab';



	$data = array();
	$res = $dba->query("SELECT * FROM rego_users WHERE super_admin = 'admin' ORDER by user_id DESC"); 
	if($row = $res->fetch_assoc()){
		if(!empty($row['user_id']))
			{
				$testttt= explode('5a6effb9c', $row['user_id']);
				$testss= explode('ab',$testttt[1]);
				$id = $testss[0] +1;

			}
	}
	ob_clean();
	echo $left.$id.$right;
	exit;


?>


















