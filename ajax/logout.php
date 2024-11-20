<?php
	if(session_id()==''){session_start();}
	ob_start();
	include('../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');

	//== Save info into log data ==//
	writeToLogfile('log', 'Log-Out');

	unset($_SESSION['rego']);
?>