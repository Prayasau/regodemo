<?php

	include("../dbconnect/db_connect.php");


	$my_dbcname = $prefix.$_REQUEST['cId'];
	$dbd = new mysqli($my_database,$my_username,$my_password,$my_dbcname);
	if($dbd->connect_error) {
		echo '<p style="width:900px; margin:0 auto; margin-top:20px;" class="box_err">Error 2 : ('.$dbd->connect_errno.') '.$dbd->connect_error.'<br>Please try again later or report this error to the Admin</p>';
	}else{
		mysqli_set_charset($dbd,"utf8");
	}



	$sql = "UPDATE ".$_REQUEST['cId']."_employees SET latitude = '".$_REQUEST['latitude']."' , longitude = '".$_REQUEST['longitude']."'  WHERE emp_id = '".$_REQUEST['employeeID']."'";

	$dbd->query($sql);

	echo 'success';

	


?>





