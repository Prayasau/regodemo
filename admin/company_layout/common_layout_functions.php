<?php

	// SAVED ADMIN DASHBOARD LAYOUT
	$savedAdminDashboardlayout = getSavedAdminDashboardLayout();
	// SAVED HEADER LAYOUT
	//echo'1 <br>';
	//print_r($savedAdminDashboardlayout);
	$savedHeaderlayout = getSavedHeaderScreenLayout();	
	// DEFAULT FONTS SAVED IN DATABASE
	//echo'2 <br>';
	//print_r($savedHeaderlayout);
	$savedDefaultFonts = getDefaultFonts();
	// GET TYPE OF SET
	//echo'3 <br>';
	//print_r($savedDefaultFonts);
	$savedlayoutSetName = getSavedLayout();
	//echo'4 <br>';
	//print_r($savedlayoutSetName);
	// GET COLORS WHERE COLOR SET AND TYPE OF SET 
	//echo'5 <br>';
	$savedAdminColors = getSavedAdminLayoutColors($savedlayoutSetName['color_set'],$savedlayoutSetName['typeofcolorset']);
	//print_r($savedAdminColors);

	
?>