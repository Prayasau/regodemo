<?
	if(session_id()==''){session_start();}
	include('../../../dbconnect/db_connect.php');

	// echo '<pre>';
	// print_r($_SESSION);
	// echo '</pre>';
	// die();
	$_SESSION['RGadmin']['filter_group_allowance'] = $_REQUEST['hiddengroupfilter']; 

	$explodecond3 = explode('|', $_REQUEST['hiddengroupfilter']);

	$_SESSION['RGadmin']['filter_group_allowance_array'] = serialize($explodecond3); 

	echo "1";


?>