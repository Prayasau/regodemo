<?

	//=============================================CREATE COLORS ARRAY ====================================//
	$err_msg = "";
	$color_data = array();
	$colorDbArray = array();
	$codeDbArray = array();
	$font_data = array();
	$sql = "SELECT * FROM rego_color_settings"; 
	if($res = $dba->query($sql)){
		if($row = $res->fetch_assoc())
		{
			$color_data[] = unserialize($row['color_settings']);
			$font_data[] = unserialize($row['font_settings']);
			$color_set_data = $row['color_set'];
			$color_type_set_data = $row['typeofcolorset'];
			$mob_color_set_data = $row['mob_color_set'];
			$mob_color_type_set_data = $row['typeofcolorsetmob'];
		}
	}else{
		$err_msg = '<div class="box_err ibox">'.$lng['Error'].' : '.mysqli_error($dba).' <a class="box_close"><i class="fa fa-times fa-lg"></i></a></div>';
	}


	// echo $mob_color_set_data ;

	// die();
	// FETECH COLOR FROM  rego_color_palette


	$sql1 = "SELECT * FROM rego_color_palette WHERE color_set_type = 'standard'"; 
	if($res1 = $dba->query($sql1)){
		while($row1 = $res1->fetch_assoc())
		{
			$color_palette_data[$row1['color_set']] = unserialize($row1['color_set_values']);
		}
	}			

	$sql1_mob = "SELECT * FROM rego_color_palette WHERE color_set_type = 'mobstandard'"; 
	if($res1_mob = $dba->query($sql1_mob)){
		while($row1_mob = $res1_mob->fetch_assoc())
		{
			$mob_color_palette_data[$row1_mob['color_set']] = unserialize($row1_mob['color_set_values']);

		}
	}		

	$sql3 = "SELECT * FROM rego_color_palette WHERE color_set_type = 'manual'"; 
	if($res3 = $dba->query($sql3)){
		while($row3 = $res3->fetch_assoc())
		{
			$color_palette_data_manaual[$row3['color_set']] = unserialize($row3['color_set_values']);
		}
	}		

	$sql3_mob = "SELECT * FROM rego_color_palette WHERE color_set_type = 'mobmanual'"; 
	if($res3_mob = $dba->query($sql3_mob)){
		while($row3_mob = $res3_mob->fetch_assoc())
		{
			$mob_color_palette_data_manaual[$row3_mob['color_set']] = unserialize($row3_mob['color_set_values']);
		}
	}	

	$sql2 = "SELECT * FROM rego_color_palette WHERE color_set = '".$color_set_data."' "; 
	if($res2 = $dba->query($sql2)){
		while($row2 = $res2->fetch_assoc())
		{
			$color_data_value[] = unserialize($row2['color_set_values']);
		}
	}	

	$sql2_mob = "SELECT * FROM rego_color_palette WHERE color_set = '".$mob_color_set_data."' "; 
	if($res2_mob = $dba->query($sql2_mob)){
		while($row2_mob = $res2_mob->fetch_assoc())
		{
			$mob_color_data_value[] = unserialize($row2_mob['color_set_values']);
		}
	}


	$sql4 = "SELECT * FROM rego_images  "; 
	if($res4 = $dba->query($sql4)){
		while($row4 = $res4->fetch_assoc())
		{
			$imagesArray[] = $row4;
		}
	}




	$colorDbArray['select'] = 'Select';
	$codeDbArray['select'] = '#e6f1ec';

	foreach ($color_data_value[0] as $key_2 => $value_2) {
		if($key_2 != 'setname')
		{
			$colorDbArray[$key_2] = $value_2['color'];
			$codeDbArray[$key_2] = $value_2['code'];
		}
	}


	$selectedColorsVal = $codeDbArray; // colors name array for php
	$selectedColorsValName = $colorDbArray; // colors code for jquery array 


	//=============================================CREATE COLORS ARRAY ====================================//


	//=============================================LOAD ADMIN DASHBOARD DATA FROM REGO LAYOUT SETTIGNS TABLE  ====================================//

	$sql5 = "SELECT * FROM rego_layout_settings WHERE id = '1'  "; 
	if($res5 = $dba->query($sql5)){
		if($row5 = $res5->fetch_assoc())
		{
			$admin_dashboard_array = unserialize($row5['admin_dashboard']);
			$admin_login_screen_array = unserialize($row5['admin_login_screen']);
			$system_login_screen_array = unserialize($row5['system_login_screen']);
			$mob_login_screen_array = unserialize($row5['mob_login_screen']);
			$scan_login_screen_array = unserialize($row5['scan_login_screen']);
			$buttons_tab_array = unserialize($row5['buttons_tab']);
			$admin_login_screen_logo['admin_login_screen_logo'] = unserialize($row5['admin_login_screen_logo']);
			$admin_login_screen_title_logo['admin_login_screen_title_logo'] = unserialize($row5['admin_login_screen_title_logo']);
			$admin_dashboard_banner_logo['admin_dashboard_banner_logo'] = unserialize($row5['admin_dashboard_banner_logo']);
			$system_login_screen_logo['system_login_screen_logo'] = unserialize($row5['system_login_screen_logo']);
			$system_login_screen_title_logo['system_login_screen_title_logo'] = unserialize($row5['system_login_screen_title_logo']);
			$mob_login_screen_logo['mob_login_screen_logo_array'] = unserialize($row5['mob_login_screen_logo_array']);
			$main_dashboard_array = unserialize($row5['main_dashboard']);
			$admin_login_screen_banner_array['admin_login_screen_banner_array'] = unserialize($row5['admin_login_screen_banner_array']);
			$system_login_screen_banner_array['system_login_screen_banner_array'] = unserialize($row5['system_login_screen_banner_array']);
			$mob_login_screen_banner_array['mob_login_screen_banner_array'] = unserialize($row5['mob_login_screen_banner_array']);

		}
	}

	//=============================================LOAD ADMIN DASHBOARD DATA FROM REGO LAYOUT SETTIGNS TABLE  ====================================//



$combineLogoHeadersArray =  array_merge($admin_login_screen_logo, $admin_login_screen_title_logo,$admin_dashboard_banner_logo,$system_login_screen_logo,$system_login_screen_title_logo,$admin_login_screen_banner_array,$system_login_screen_banner_array,$mob_login_screen_logo,$mob_login_screen_banner_array);



// UNSEARLIZE BUTTON LAYOUT CODE TO GET DIFFERENT BUTTONS DETAILS  \

// fetch values for all buttons using loops  

$lowEnd = '1';
$highEnd = '40';
for($i = $lowEnd; $i<=$highEnd; $i++) {
	$commonlayout[$i] = json_decode($buttons_tab_array['buttonLayout'.$i]);
}




?>