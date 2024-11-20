<?php
	


	function getSavedLayout(){
		global $dba;

		$sql = "SELECT * FROM rego_color_settings WHERE id= '1'";
		if($res = $dba->query($sql)){
			if($row = $res->fetch_assoc())
			{
				$array['color_set'] = $row['color_set'];
				$array['typeofcolorset'] = $row['typeofcolorset'];
			}
		}
		return $array;
	}	
	function getSavedAdminLayoutColors($color_set,$typeofcolorset){
		global $dba;

		$sql = "SELECT * FROM rego_color_palette WHERE color_set= '".$color_set."' AND color_set_type= '".$typeofcolorset."'";
		if($res = $dba->query($sql)){
			if($row = $res->fetch_assoc())
			{
				$data  = unserialize($row['color_set_values']);
			}
		}
		return $data;
	}	
	function getSavedAdminDashboardLayout(){
		global $dba;

		$sql = "SELECT * FROM rego_layout_settings WHERE id= '1'";
		if($res = $dba->query($sql)){
			if($row = $res->fetch_assoc())
			{
				$data  = unserialize($row['admin_dashboard']);
			}
		}
		return $data;
	}	
	

	function getDefaultFonts(){
		global $dba;

		$sql = "SELECT * FROM rego_color_settings WHERE id= '1'";
		if($res = $dba->query($sql)){
			if($row = $res->fetch_assoc())
			{
				$data  = unserialize($row['font_settings']);
			}
		}
		return $data;
	}


	function getSavedAdminLoginScreenLayout(){
		global $dba;

		$sql = "SELECT * FROM rego_layout_settings WHERE id= '1'";
		if($res = $dba->query($sql)){
			if($row = $res->fetch_assoc())
			{
				$data  = unserialize($row['admin_login_screen']);
			}
		}
		return $data;
	}	
		
	function getSavedAdminLoginScreenCombined(){
		global $dba;

		$sql = "SELECT * FROM rego_layout_settings WHERE id= '1'";
		if($res = $dba->query($sql)){
			if($row = $res->fetch_assoc())
			{
				$data1['admin_dashboard']  = unserialize($row['admin_dashboard']);
				$data2['admin_login_screen']  = unserialize($row['admin_login_screen']);
				$data3['system_login_screen']  = unserialize($row['system_login_screen']);
				$data4['mob_login_screen']  = unserialize($row['mob_login_screen']);
				$data5['scan_login_screen']  = unserialize($row['scan_login_screen']);
				$data6['buttons_tab']  = unserialize($row['buttons_tab']);
				$data7['admin_login_screen_logo']  = unserialize($row['admin_login_screen_logo']);
				$data8['admin_login_screen_title_logo']  = unserialize($row['admin_login_screen_title_logo']);
				$data9['system_login_screen_logo']  = unserialize($row['system_login_screen_logo']);
				$data10['system_login_screen_title_logo']  = unserialize($row['system_login_screen_title_logo']);
				$data11['admin_dashboard_banner_logo']  = unserialize($row['admin_dashboard_banner_logo']);
				$data12['main_dashboard']  = unserialize($row['main_dashboard']);
				$data13['admin_login_screen_banner_array']  = unserialize($row['admin_login_screen_banner_array']);
				$data14['system_login_screen_banner_array']  = unserialize($row['system_login_screen_banner_array']);

				$mergeArray = array_merge($data1,$data2,$data3,$data4,$data5,$data6,$data7,$data8,$data9,$data10,$data11,$data12,$data13,$data14);
			}
		}
		return $mergeArray;
	}	
	



	

?>