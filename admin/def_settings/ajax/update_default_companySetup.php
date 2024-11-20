<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");

	/*echo '<pre>';
	print_r($_REQUEST);
	echo '</pre>';
	exit;*/

	$sql = "UPDATE rego_default_settings SET 
		logtime = '".$dba->real_escape_string($_REQUEST['logtime'])."', 
		theme_color = '".$dba->real_escape_string($_REQUEST['theme_color'])."', 
		revenu_code = '".$dba->real_escape_string($_REQUEST['revenu_code'])."', 
		revenu_name_th = '".$dba->real_escape_string($_REQUEST['revenu_name_th'])."', 
		revenu_name_en = '".$dba->real_escape_string($_REQUEST['revenu_name_en'])."', 
		sso_code = '".$dba->real_escape_string($_REQUEST['sso_code'])."', 
		sso_name_th = '".$dba->real_escape_string($_REQUEST['sso_name_th'])."', 
		sso_name_en = '".$dba->real_escape_string($_REQUEST['sso_name_en'])."', 
		emp_grp = '".$dba->real_escape_string(serialize($_REQUEST['emp_grp']))."', 
		parameter = '".$dba->real_escape_string(serialize($_REQUEST['parameter']))."', 
		org = '".$dba->real_escape_string(serialize($_REQUEST['org']))."'"; 
	
	ob_clean();
	if($dba->query($sql)){
			echo 'success';
	}else{
			echo mysqli_error($dba);
	}

?>