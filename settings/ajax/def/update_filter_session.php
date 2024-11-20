<?
	if(session_id()==''){session_start();}
	include('../../../dbconnect/db_connect.php');


	$_SESSION['rego']['filter_group_allowance'] = $_REQUEST['hiddengroupfilter']; 

	$explodecond3 = explode('|', $_REQUEST['hiddengroupfilter']);

	$_SESSION['rego']['filter_group_allowance_array'] = serialize($explodecond3); 

	echo "1";

?>