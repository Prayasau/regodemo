<?php
	

	$sql_11 = "SELECT * FROM rego_layout_settings WHERE id= '1'";
	if($res11 = $dbx->query($sql_11)){
		if($row11 = $res11->fetch_assoc())
		{
			$data11  = unserialize($row11['main_dashboard']);
		}
	}

	$sql_12 = "SELECT * FROM rego_color_settings WHERE id= '1'";
	if($res12 = $dbx->query($sql_12)){
		if($row12 = $res12->fetch_assoc())
		{
			$array12['color_set'] = $row12['color_set'];
			$array12['typeofcolorset'] = $row12['typeofcolorset'];
		}
	}

	$sql_13 = "SELECT * FROM rego_color_palette WHERE color_set= '".$array12['color_set']."' AND color_set_type= '".$array12['typeofcolorset']."'";
	if($res13 = $dbx->query($sql_13)){
		if($row13 = $res13->fetch_assoc())
		{
			$data13  = unserialize($row13['color_set_values']);
		}
	}

	$sql_14 = "SELECT * FROM rego_color_settings WHERE id= '1'";
	if($res14 = $dbx->query($sql_14)){
		if($row14 = $res14->fetch_assoc())
		{
			$data14  = unserialize($row14['font_settings']);
		}
	}


	// SAVED ADMIN DASHBOARD LAYOUT
	$savedMainDashboardlayout = $data11;
	// // DEFAULT FONTS SAVED IN DATABASE 
	$savedDefaultFonts = $data14;
	// // GET TYPE OF SET 
	$savedlayoutSetName = $array12;
	// // GET COLORS WHERE COLOR SET AND TYPE OF SET 
	$savedAdminColors = $data13;


	// echo '<pre>';
	// print_r($data13);
	// echo '</pre>';



?>