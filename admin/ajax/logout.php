<?
	if(session_id()==''){session_start(); ob_start();}
	unset($_SESSION['RGadmin']);
	echo '../admin/index.php?mn=1';
   exit;
?>