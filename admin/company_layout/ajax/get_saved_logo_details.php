<?
	
	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");
		
	$logo_columns_array = array(

		'adminloginscreen' => 'admin_login_screen_logo',
		'adminloginscreentitle' => 'admin_login_screen_title_logo',
		'systemloginscreen' => 'system_login_screen_logo',
		'systemloginscreentitle' => 'system_login_screen_title_logo',
		'admindashboardbannerlogo' => 'admin_dashboard_banner_logo',
		'mobilescreenlogo' => 'mob_login_screen_logo_array',

	);

	$defaultArray = array(

		'select_admin_logo_image_selection' => $_REQUEST['select_admin_logo_image_selection'],
	    'admin_screen_logo_image_link' => '',
	    'admin_login_screen_logo_size' => '45',
	    'image_link' =>'',
	);



	$sql5 = "SELECT ".$logo_columns_array[$_REQUEST['select_admin_logo_image_selection']]." FROM rego_layout_settings WHERE id = '1'  ";

	if($res5 = $dba->query($sql5)){

		if($row5 = $res5->fetch_assoc())
		{
			$admin_login_screen_logo = unserialize($row5[$logo_columns_array[$_REQUEST['select_admin_logo_image_selection']]]);
		}
	}
	else
	{
		$admin_login_screen_logo = $defaultArray;

	}


	echo json_encode($admin_login_screen_logo);
	
