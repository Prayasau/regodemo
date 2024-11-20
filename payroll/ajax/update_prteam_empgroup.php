<?php
	
	if(session_id()==''){session_start();}
	ob_start();
	include('../../dbconnect/db_connect.php');

	// echo '<pre>';
	// print_r($_REQUEST);
	// echo '</pre>';

	$implode_teams = implode(',', $_REQUEST['teams']);

	$upsql = "UPDATE ".$cid."_payroll_months SET pr_teams='".$implode_teams."' WHERE month='".$_SESSION['rego']['cur_year'].'_'.$_SESSION['rego']['cur_month']."' ";
	if($dbc->query($upsql)){

		ob_clean();
		echo $implode_teams;
	}else{
		ob_clean();
		echo mysqli_error($dbc);
	}

?>