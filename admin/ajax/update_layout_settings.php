<?
	if(session_id()==''){session_start(); ob_start();}
	include("../dbconnect/db_connect.php");
	$error_value = '';




	//===================================================== UPLOAD IMAGES SECTION ================================================//

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
			$admin_login_screen_logo = unserialize($row5['admin_login_screen_logo']);
			$admin_login_screen_title_logo = unserialize($row5['admin_login_screen_title_logo']);
			$system_login_screen_logo = unserialize($row5['system_login_screen_logo']);
			$system_login_screen_title_logo = unserialize($row5['system_login_screen_title_logo']);
			$admin_dashboard_banner_logo = unserialize($row5['admin_dashboard_banner_logo']);
			$mobilescreenlogo = unserialize($row5['mob_login_screen_logo_array']);
			$admin_login_screen_banner_array= unserialize($row5['admin_login_screen_banner_array']);
			$mob_login_screen_banner_array= unserialize($row5['mob_login_screen_banner_array']);
			$system_login_screen_banner_array= unserialize($row5['system_login_screen_banner_array']);
			$main_dashboard_array= unserialize($row5['main_dashboard']);


		}
	}


	if($_REQUEST['buttons_layout']['buttonLayout1'] == '')
	{
		$_REQUEST['buttons_layout']['buttonLayout1'] = $buttons_tab_array['buttonLayout1'];
	}	

	if($_REQUEST['buttons_layout']['buttonLayout2'] == '')
	{
		$_REQUEST['buttons_layout']['buttonLayout2'] = $buttons_tab_array['buttonLayout2'];
	}	
	if($_REQUEST['buttons_layout']['buttonLayout3'] == '')
	{
		$_REQUEST['buttons_layout']['buttonLayout3'] = $buttons_tab_array['buttonLayout3'];
	}	
	if($_REQUEST['buttons_layout']['buttonLayout4'] == '')
	{
		$_REQUEST['buttons_layout']['buttonLayout4'] = $buttons_tab_array['buttonLayout4'];
	}
	if($_REQUEST['buttons_layout']['buttonLayout5'] == '')
	{
		$_REQUEST['buttons_layout']['buttonLayout5'] = $buttons_tab_array['buttonLayout5'];
	}	
	if($_REQUEST['buttons_layout']['buttonLayout6'] == '')
	{
		$_REQUEST['buttons_layout']['buttonLayout6'] = $buttons_tab_array['buttonLayout6'];
	}	
	if($_REQUEST['buttons_layout']['buttonLayout7'] == '')
	{
		$_REQUEST['buttons_layout']['buttonLayout7'] = $buttons_tab_array['buttonLayout7'];
	}	
	if($_REQUEST['buttons_layout']['buttonLayout8'] == '')
	{
		$_REQUEST['buttons_layout']['buttonLayout8'] = $buttons_tab_array['buttonLayout8'];
	}


	// echo '<pre>';
	// // print_r($buttons_tab_array['buttonLayout2']);
	// print_r($_REQUEST['buttons_layout']);
	// echo '</pre>';

	// die();



	$uploadmap = DIR.'/images/admin_uploads/';
	if (!file_exists($uploadmap)) {
		mkdir($uploadmap, 0755, true);
	}



	//==================================== UPLOAD MOB LOGO SECTION =============================//

	if(!empty($_FILES['uploadimages_mob_logo']['tmp_name'])){
		$extension_mob_login_logo = pathinfo($_FILES['uploadimages_mob_logo']['name'], PATHINFO_EXTENSION);		
		$filename_mob_login_logo = $_FILES['uploadimages_mob_logo']['name'];
		$file_mob_login_logo = $uploadmap.$filename_mob_login_logo;
		$baseName_mob_login_logo = $_FILES['uploadimages_mob_logo']['name'];
		$counter_mob_login_logo = 1;				
		while(file_exists($file_mob_login_logo)) {
			 $filename_mob_login_logo = $baseName_mob_login_logo.'('.$counter_mob_login_logo.').'.$extension_mob_login_logo;
			 $file_mob_login_logo = $uploadmap.$baseName_mob_login_logo.'('.$counter_mob_login_logo.').'.$extension_mob_login_logo;
			 $counter_mob_login_logo++;
		};

		$string_mob_login_logo = preg_replace('/\s+/', '', $filename_mob_login_logo);
		$string2_mob_login_logo = preg_replace('/\s+/', '', $file_mob_login_logo);

		if(move_uploaded_file($_FILES['uploadimages_mob_logo']['tmp_name'], $string2_mob_login_logo)){
			$data_mob_login_logo['filename'] = $string_mob_login_logo;
			$data_mob_login_logo['date'] = date('d-m-Y');
			$data_mob_login_logo['size'] = number_format(($_FILES['uploadimages_mob_logo']['size']/1012),2).' Kb';
			$data_mob_login_logo['ext'] = $extension_mob_login_logo;
			$_REQUEST['login_screen']['mob']['image_link'] = $string_mob_login_logo;


			// DELETE the previous image if new image is uploaded
			$mob_login_screen_background_logo_filename = "../../images/admin_uploads/".$mob_login_screen_array['image_link'];
			if (file_exists($mob_login_screen_background_logo_filename)) 
			{
				unlink($mob_login_screen_background_logo_filename);
			} 

		}
	}
	else
	{
		$_REQUEST['login_screen']['mob']['image_link'] = $_REQUEST['mob_screen_logo_image_link'];
	}		


	//==================================== UPLOAD SYSTEM LOGO SECTION =============================//

	//==================================== UPLOAD SYSTEM LOGO SECTION =============================//

	if(!empty($_FILES['uploadimages_system_logo']['tmp_name'])){
		$extension_system_login_logo = pathinfo($_FILES['uploadimages_system_logo']['name'], PATHINFO_EXTENSION);		
		$filename_system_login_logo = $_FILES['uploadimages_system_logo']['name'];
		$file_system_login_logo = $uploadmap.$filename_system_login_logo;
		$baseName_system_login_logo = $_FILES['uploadimages_system_logo']['name'];
		$counter_system_login_logo = 1;				
		while(file_exists($file_system_login_logo)) {
			 $filename_system_login_logo = $baseName_system_login_logo.'('.$counter_system_login_logo.').'.$extension_system_login_logo;
			 $file_system_login_logo = $uploadmap.$baseName_system_login_logo.'('.$counter_system_login_logo.').'.$extension_system_login_logo;
			 $counter_system_login_logo++;
		};

		$string_system_login_logo = preg_replace('/\s+/', '', $filename_system_login_logo);
		$string2_system_login_logo = preg_replace('/\s+/', '', $file_system_login_logo);

		if(move_uploaded_file($_FILES['uploadimages_system_logo']['tmp_name'], $string2_system_login_logo)){
			$data_system_login_logo['filename'] = $string_system_login_logo;
			$data_system_login_logo['date'] = date('d-m-Y');
			$data_system_login_logo['size'] = number_format(($_FILES['uploadimages_system_logo']['size']/1012),2).' Kb';
			$data_system_login_logo['ext'] = $extension_system_login_logo;
			$_REQUEST['login_screen']['system']['image_link'] = $string_system_login_logo;

			// DELETE the previous image if new image is uploaded
			$system_login_screen_background_logo_filename = "../../images/admin_uploads/".$system_login_screen_array['image_link'];
			if (file_exists($system_login_screen_background_logo_filename)) 
			{
				unlink($system_login_screen_background_logo_filename);
			} 


		}
	}
	else
	{
		$_REQUEST['login_screen']['system']['image_link'] = $_REQUEST['system_screen_logo_image_link'];
	}		



	// UPDATE SYSTEM LOGIN SCREEN BACKGROUND 
	if(!empty($_FILES['uploadimages_system_background']['tmp_name'])){
		$extension_system_login_background = pathinfo($_FILES['uploadimages_system_background']['name'], PATHINFO_EXTENSION);		
		$filename_system_login_background = $_FILES['uploadimages_system_background']['name'];
		$file_system_login_background = $uploadmap.$filename_system_login_background;
		$baseName_system_login_background = $_FILES['uploadimages_system_background']['name'];
		$counter_system_login_background = 1;				
		while(file_exists($file_system_login_background)) {
			 $filename_system_login_background = $baseName_system_login_background.'('.$counter_system_login_background.').'.$extension_system_login_background;
			 $file_system_login_background = $uploadmap.$baseName_system_login_background.'('.$counter_system_login_background.').'.$extension_system_login_background;
			 $counter_system_login_background++;
		};

		$string_system_login_background = preg_replace('/\s+/', '', $filename_system_login_background);
		$string2_system_login_background = preg_replace('/\s+/', '', $file_system_login_background);


		$uploadimages_system_backgroundimage_info = getimagesize($_FILES["uploadimages_system_background"]["tmp_name"]);
		$uploadimages_system_backgroundimage_width = $uploadimages_system_backgroundimage_info[0];
		$uploadimages_system_backgroundimage_height = $uploadimages_system_backgroundimage_info[1];

		if($uploadimages_system_backgroundimage_width == '1920' &&  $uploadimages_system_backgroundimage_height == '836' && ($extension_system_login_background == 'jpg' || $extension_system_login_background == 'png' || $extension_system_login_background == 'jpeg'))
		{
			if(move_uploaded_file($_FILES['uploadimages_system_background']['tmp_name'], $string2_system_login_background)){
				$data_system_login_background['filename'] = $string_system_login_background;
				$data_system_login_background['date'] = date('d-m-Y');
				$data_system_login_background['size'] = number_format(($_FILES['uploadimages_system_background']['size']/1012),2).' Kb';
				$data_system_login_background['ext'] = $extension_system_login_background;
				$_REQUEST['login_screen']['system']['bg_image_link'] = $string_system_login_background;

				// DELETE the previous image if new image is uploaded
				$system_login_screen_background_filename = "../../images/admin_uploads/".$system_login_screen_array['bg_image_link'];
				if (file_exists($system_login_screen_background_filename)) 
				{
					unlink($system_login_screen_background_filename);
				} 

				}

		}
		else
		{
			$error_value = '1';
			$_REQUEST['login_screen']['system']['bg_image_link'] = $_REQUEST['system_screen_background_image_link'];
		}


	}
	else
	{
		$_REQUEST['login_screen']['system']['bg_image_link'] = $_REQUEST['system_screen_background_image_link'];
	}	






	// UPDATE SYSTEM LOGIN SCREEN BANNER 
	if(!empty($_FILES['uploadimages_system_banner']['tmp_name'])){
		$extension_system_login_banner = pathinfo($_FILES['uploadimages_system_banner']['name'], PATHINFO_EXTENSION);		
		$filename_system_login_banner = $_FILES['uploadimages_system_banner']['name'];
		$file_system_login_banner = $uploadmap.$filename_system_login_banner;
		$baseName_system_login_banner = $_FILES['uploadimages_system_banner']['name'];
		$counter_system_login_banner = 1;				
		while(file_exists($file_system_login_banner)) {
			 $filename_system_login_banner = $baseName_system_login_banner.'('.$counter_system_login_banner.').'.$extension_system_login_banner;
			 $file_system_login_banner = $uploadmap.$baseName_system_login_banner.'('.$counter_system_login_banner.').'.$extension_system_login_banner;
			 $counter_system_login_banner++;
		};

		$string_system_login_banner = preg_replace('/\s+/', '', $filename_system_login_banner);
		$string2_system_login_banner = preg_replace('/\s+/', '', $file_system_login_banner);


		$uploadimages_system_bannerimage_info = getimagesize($_FILES["uploadimages_system_banner"]["tmp_name"]);
		$uploadimages_system_bannerimage_width = $uploadimages_system_bannerimage_info[0];
		$uploadimages_system_bannerimage_height = $uploadimages_system_bannerimage_info[1];

		if($uploadimages_system_bannerimage_width == '2846' &&  $uploadimages_system_bannerimage_height == '200' && ($extension_system_login_banner == 'jpg' || $extension_system_login_banner == 'png' || $extension_system_login_banner == 'jpeg'))
		{
			if(move_uploaded_file($_FILES['uploadimages_system_banner']['tmp_name'], $string2_system_login_banner)){
				$data_system_login_banner['filename'] = $string_system_login_banner;
				$data_system_login_banner['date'] = date('d-m-Y');
				$data_system_login_banner['size'] = number_format(($_FILES['uploadimages_system_banner']['size']/1012),2).' Kb';
				$data_system_login_banner['ext'] = $extension_system_login_banner;
				$_REQUEST['login_screen']['system']['banner_image_link'] = $string_system_login_banner;

				// DELETE the previous image if new image is uploaded
				$system_login_screen_banner_filename = "../../images/admin_uploads/".$system_login_screen_array['banner_image_link'];
				if (file_exists($system_login_screen_banner_filename)) 
				{
					unlink($system_login_screen_banner_filename);
				} 

				}

		}
		else
		{
			$error_value = '1';
			$_REQUEST['login_screen']['system']['banner_image_link'] = $_REQUEST['system_screen_banner_image_link'];
		}


	}
	else
	{
		$_REQUEST['login_screen']['system']['banner_image_link'] = $_REQUEST['system_screen_banner_image_link'];
	}



	//==================================== UPLOAD SYSTEM LOGO SECTION =============================//


	//==================================== UPLOAD ADMIN LOGO SECTION =============================//

	if(!empty($_FILES['uploadimages_admin_logo']['tmp_name'])){
		$extension_admin_login_logo = pathinfo($_FILES['uploadimages_admin_logo']['name'], PATHINFO_EXTENSION);		
		$filename_admin_login_logo = $_FILES['uploadimages_admin_logo']['name'];
		$file_admin_login_logo = $uploadmap.$filename_admin_login_logo;
		$baseName_admin_login_logo = $_FILES['uploadimages_admin_logo']['name'];
		$counter_admin_login_logo = 1;				
		while(file_exists($file_admin_login_logo)) {
			 $filename_admin_login_logo = $baseName_admin_login_logo.'('.$counter_admin_login_logo.').'.$extension_admin_login_logo;
			 $file_admin_login_logo = $uploadmap.$baseName_admin_login_logo.'('.$counter_admin_login_logo.').'.$extension_admin_login_logo;
			 $counter_admin_login_logo++;
		};

		$string_admin_login_logo = preg_replace('/\s+/', '', $filename_admin_login_logo);
		$string2_admin_login_logo = preg_replace('/\s+/', '', $file_admin_login_logo);

		if(move_uploaded_file($_FILES['uploadimages_admin_logo']['tmp_name'], $string2_admin_login_logo)){
			$data_admin_login_logo['filename'] = $string_admin_login_logo;
			$data_admin_login_logo['date'] = date('d-m-Y');
			$data_admin_login_logo['size'] = number_format(($_FILES['uploadimages_admin_logo']['size']/1012),2).' Kb';
			$data_admin_login_logo['ext'] = $extension_admin_login_logo;


			$_REQUEST['logoandheaders']['image_link'] = $string_admin_login_logo;
			$_REQUEST['logoandheaders']['admin_screen_logo_image_link'] = $string_admin_login_logo;
			// DELETE the previous image if new image is uploaded
			$admin_login_screenlogo_background_filename = "../../images/admin_uploads/".$admin_login_screen_array['image_link'];
			// if (file_exists($admin_login_screenlogo_background_filename)) 
			// {
			// 	unlink($admin_login_screenlogo_background_filename);
			// } 
		}
	}
	else
	{
		$_REQUEST['logoandheaders']['image_link'] = $_REQUEST['logoandheaders']['admin_screen_logo_image_link'];
		$_REQUEST['logoandheaders']['admin_screen_logo_image_link'] = $_REQUEST['logoandheaders']['admin_screen_logo_image_link'];
	}	





	// UPDATE ADMIN LOGIN SCREEN BACKGROUND 
	if(!empty($_FILES['uploadimages_admin_login_background']['tmp_name'])){
		$extension_admin_login_background = pathinfo($_FILES['uploadimages_admin_login_background']['name'], PATHINFO_EXTENSION);		
		$filename_admin_login_background = $_FILES['uploadimages_admin_login_background']['name'];
		$file_admin_login_background = $uploadmap.$filename_admin_login_background;
		$baseName_admin_login_background = $_FILES['uploadimages_admin_login_background']['name'];
		$counter_admin_login_background = 1;				
		while(file_exists($file_admin_login_background)) {
			 $filename_admin_login_background = $baseName_admin_login_background.'('.$counter_admin_login_background.').'.$extension_admin_login_background;
			 $file_admin_login_background = $uploadmap.$baseName_admin_login_background.'('.$counter_admin_login_background.').'.$extension_admin_login_background;
			 $counter_admin_login_background++;
		};

		$string_admin_login_background = preg_replace('/\s+/', '', $filename_admin_login_background);
		$string2_admin_login_background = preg_replace('/\s+/', '', $file_admin_login_background);


		$uploadimages_admin_login_backgroundimage_info = getimagesize($_FILES["uploadimages_admin_login_background"]["tmp_name"]);
		$uploadimages_admin_login_backgroundimage_width = $uploadimages_admin_login_backgroundimage_info[0];
		$uploadimages_admin_login_backgroundimage_height = $uploadimages_admin_login_backgroundimage_info[1];

		if($uploadimages_admin_login_backgroundimage_width == '1920' &&  $uploadimages_admin_login_backgroundimage_height == '836' && ($extension_admin_login_background == 'jpg' || $extension_admin_login_background == 'png' || $extension_admin_login_background == 'jpeg'))
		{
			if(move_uploaded_file($_FILES['uploadimages_admin_login_background']['tmp_name'], $string2_admin_login_background)){
				$data_admin_login_background['filename'] = $string_admin_login_background;
				$data_admin_login_background['date'] = date('d-m-Y');
				$data_admin_login_background['size'] = number_format(($_FILES['uploadimages_admin_login_background']['size']/1012),2).' Kb';
				$data_admin_login_background['ext'] = $extension_admin_login_background;


				$_REQUEST['login_screen']['admin']['bg_image_link'] = $string_admin_login_background;

				// DELETE the previous image if new image is uploaded
				$admin_login_screen_background_filename = "../../images/admin_uploads/".$admin_login_screen_array['bg_image_link'];
				if (file_exists($admin_login_screen_background_filename)) 
				{
					unlink($admin_login_screen_background_filename);
				} 


			}

		}
		else
		{

			$error_value = '1';
			$_REQUEST['login_screen']['admin']['bg_image_link'] = $_REQUEST['admin_screen_login_background_image_link'];
		}


	}
	else
	{
		$_REQUEST['login_screen']['admin']['bg_image_link'] = $_REQUEST['admin_screen_login_background_image_link'];
	}		


	if($_REQUEST['logoandheaders']['select_admin_banner_image_selection'] != 'select')
	{
	// UPDATE ADMIN LOGIN SCREEN BANNER 
		if(!empty($_FILES['uploadimages_admin_login_banner']['tmp_name'])){
			$extension_admin_login_banner = pathinfo($_FILES['uploadimages_admin_login_banner']['name'], PATHINFO_EXTENSION);		
			$filename_admin_login_banner = $_FILES['uploadimages_admin_login_banner']['name'];
			$file_admin_login_banner = $uploadmap.$filename_admin_login_banner;
			$baseName_admin_login_banner = $_FILES['uploadimages_admin_login_banner']['name'];
			$counter_admin_login_banner = 1;				
			while(file_exists($file_admin_login_banner)) {
				 $filename_admin_login_banner = $baseName_admin_login_banner.'('.$counter_admin_login_banner.').'.$extension_admin_login_banner;
				 $file_admin_login_banner = $uploadmap.$baseName_admin_login_banner.'('.$counter_admin_login_banner.').'.$extension_admin_login_banner;
				 $counter_admin_login_banner++;
			};

			$string_admin_login_banner = preg_replace('/\s+/', '', $filename_admin_login_banner);
			$string2_admin_login_banner = preg_replace('/\s+/', '', $file_admin_login_banner);


			$uploadimages_admin_login_bannerimage_info = getimagesize($_FILES["uploadimages_admin_login_banner"]["tmp_name"]);
			$uploadimages_admin_login_bannerimage_width = $uploadimages_admin_login_bannerimage_info[0];
			$uploadimages_admin_login_bannerimage_height = $uploadimages_admin_login_bannerimage_info[1];

			if($uploadimages_admin_login_bannerimage_width == '2846' &&  $uploadimages_admin_login_bannerimage_height == '200' && ($extension_admin_login_banner == 'jpg' || $extension_admin_login_banner == 'png' || $extension_admin_login_banner == 'jpeg'))
			{
				if(move_uploaded_file($_FILES['uploadimages_admin_login_banner']['tmp_name'], $string2_admin_login_banner)){
					$data_admin_login_banner['filename'] = $string_admin_login_banner;
					$data_admin_login_banner['date'] = date('d-m-Y');
					$data_admin_login_banner['size'] = number_format(($_FILES['uploadimages_admin_login_banner']['size']/1012),2).' Kb';
					$data_admin_login_banner['ext'] = $extension_admin_login_banner;


					$_REQUEST['logoandheaders']['image_link'] = $string_admin_login_banner;
					$_REQUEST['logoandheaders']['admin_screen_login_banner_image_link'] = $string_admin_login_banner;

					// DELETE the previous image if new image is uploaded
					$admin_login_screen_banner_filename = "../../images/admin_uploads/".$admin_login_screen_array['banner_image_link'];
					if (file_exists($admin_login_screen_banner_filename)) 
					{
						unlink($admin_login_screen_banner_filename);
					} 


				}

			}
			else
			{

				$error_value = '1';
				$_REQUEST['logoandheaders']['image_link'] = $_REQUEST['logoandheaders']['admin_screen_logo_image_link_banner'];
				$_REQUEST['logoandheaders']['admin_screen_login_banner_image_link'] = $_REQUEST['logoandheaders']['admin_screen_logo_image_link_banner'];
			}
		}
		else
		{
			$_REQUEST['logoandheaders']['image_link'] = $_REQUEST['logoandheaders']['admin_screen_logo_image_link_banner'];
			$_REQUEST['logoandheaders']['admin_screen_login_banner_image_link'] = $_REQUEST['logoandheaders']['admin_screen_logo_image_link_banner'];
		}	
	}





	// echo '<pre>';
	// print_r($_REQUEST['logoandheaders']);
	// echo '</pre>';

	// die();



	// UPDATE ADMIN LOGIN SCREEN TITLE LOGO 
	if(!empty($_FILES['uploadimages_admin_logo_title']['tmp_name'])){
		$extension_admin_logo_title= pathinfo($_FILES['uploadimages_admin_logo_title']['name'], PATHINFO_EXTENSION);		
		$filename_admin_logo_title = $_FILES['uploadimages_admin_logo_title']['name'];
		$file_admin_logo_title = $uploadmap.$filename_admin_logo_title;
		$baseName_admin_logo_title = $_FILES['uploadimages_admin_logo_title']['name'];
		$counter_admin_logo_title = 1;				
		while(file_exists($file_admin_logo_title)) {
			 $filename_admin_logo_title = $baseName_admin_logo_title.'('.$counter_admin_logo_title.').'.$extension_admin_logo_title;
			 $file_admin_logo_title = $uploadmap.$baseName_admin_logo_title.'('.$counter_admin_logo_title.').'.$extension_admin_logo_title;
			 $counter_admin_logo_title++;
		};

		$string_admin_logo_title = preg_replace('/\s+/', '', $filename_admin_logo_title);
		$string2_admin_logo_title = preg_replace('/\s+/', '', $file_admin_logo_title);


		$uploadimages_admin_logo_titleimage_info = getimagesize($_FILES["uploadimages_admin_logo_title"]["tmp_name"]);
		$uploadimages_admin_logo_titleimage_width = $uploadimages_admin_logo_titleimage_info[0];
		$uploadimages_admin_logo_titleimage_height = $uploadimages_admin_logo_titleimage_info[1];


		if(move_uploaded_file($_FILES['uploadimages_admin_logo_title']['tmp_name'], $string2_admin_logo_title)){
			$data_admin_logo_title['filename'] = $string_admin_logo_title;
			$data_admin_logo_title['date'] = date('d-m-Y');
			$data_admin_logo_title['size'] = number_format(($_FILES['uploadimages_admin_logo_title']['size']/1012),2).' Kb';
			$data_admin_logo_title['ext'] = $extension_admin_logo_title;


			$_REQUEST['login_screen']['admin']['image_link_title'] = $string_admin_logo_title;

			// DELETE the previous image if new image is uploaded
			$admin_login_screen_background_filenameadmin_logo_title = "../../images/admin_uploads/".$admin_login_screen_array['image_link_title'];
			if (file_exists($admin_login_screen_background_filenameadmin_logo_title)) 
			{
				unlink($admin_login_screen_background_filenameadmin_logo_title);
			} 


		}

	}
	else
	{
		$_REQUEST['login_screen']['admin']['image_link_title'] = $_REQUEST['admin_screen_logo_image_link_title'];
	}

	//==================================== UPLOAD ADMIN LOGO SECTION =============================//

	//==================================== UPLOAD ADMIN DASHBOARD BACKGROUND SECTION =============================//


	if(!empty($_FILES['uploadimages_admin_bg']['tmp_name'])){
		$extension = pathinfo($_FILES['uploadimages_admin_bg']['name'], PATHINFO_EXTENSION);		
		$filename = $_FILES['uploadimages_admin_bg']['name'];
		$file = $uploadmap.$filename;
		$baseName = $_FILES['uploadimages_admin_bg']['name'];
		$counter = 1;				
		while(file_exists($file)) {
			 $filename = $baseName.'('.$counter.').'.$extension;
			 $file = $uploadmap.$baseName.'('.$counter.').'.$extension;
			 $counter++;
		};

		$string = preg_replace('/\s+/', '', $filename);
		$string2 = preg_replace('/\s+/', '', $file);

		$uploadimages_admin_bgimage_info = getimagesize($_FILES["uploadimages_admin_bg"]["tmp_name"]);
		$uploadimages_admin_bgimage_width = $uploadimages_admin_bgimage_info[0];
		$uploadimages_admin_bgimage_height = $uploadimages_admin_bgimage_info[1];

		if($uploadimages_admin_bgimage_width == '1920' &&  $uploadimages_admin_bgimage_height == '836' && ($extension == 'jpg' || $extension == 'png' || $extension == 'jpeg'))
		{
			//  upload
			if(move_uploaded_file($_FILES['uploadimages_admin_bg']['tmp_name'], $string2))
			{
				$data['filename'] = $string;
				$data['date'] = date('d-m-Y');
				$data['size'] = number_format(($_FILES['uploadimages_admin_bg']['size']/1012),2).' Kb';
				$data['ext'] = $extension;

				$_REQUEST['admin_dashboard']['image_link'] = $string;


				// DELETE the previous image if new image is uploaded
				$admin_dashboard_background_filename = "../../images/admin_uploads/".$admin_dashboard_array['image_link'];
				if (file_exists($admin_dashboard_background_filename)) 
				{
					unlink($admin_dashboard_background_filename);
				} 

			}



			// GIVE MESSAGE IF NOT THE EXACT PIXEL 
		}
		else
		{
			// show error message
			$error_value = '1';
			$_REQUEST['admin_dashboard']['image_link'] = $_REQUEST['admin_dashboard_image_link'];
		}

	}
	else
	{
		$_REQUEST['admin_dashboard']['image_link'] = $_REQUEST['admin_dashboard_image_link'];
	}

	//==================================== UPLOAD ADMIN DASHBOARD BACKGROUND SECTION =============================//
	
	//==================================== UPLOAD ADMIN DASHBOARD BACKGROUND SECTION =============================//


	if(!empty($_FILES['uploadimages_main_bg']['tmp_name'])){
		$extension = pathinfo($_FILES['uploadimages_main_bg']['name'], PATHINFO_EXTENSION);		
		$filename = $_FILES['uploadimages_main_bg']['name'];
		$file = $uploadmap.$filename;
		$baseName = $_FILES['uploadimages_main_bg']['name'];
		$counter = 1;				
		while(file_exists($file)) {
			 $filename = $baseName.'('.$counter.').'.$extension;
			 $file = $uploadmap.$baseName.'('.$counter.').'.$extension;
			 $counter++;
		};

		$string = preg_replace('/\s+/', '', $filename);
		$string2 = preg_replace('/\s+/', '', $file);

		$uploadimages_main_bgimage_info = getimagesize($_FILES["uploadimages_main_bg"]["tmp_name"]);
		$uploadimages_main_bgimage_width = $uploadimages_main_bgimage_info[0];
		$uploadimages_main_bgimage_height = $uploadimages_main_bgimage_info[1];

		if($uploadimages_main_bgimage_width == '1920' &&  $uploadimages_main_bgimage_height == '836' && ($extension == 'jpg' || $extension == 'png' || $extension == 'jpeg'))
		{
			//  upload
			if(move_uploaded_file($_FILES['uploadimages_main_bg']['tmp_name'], $string2))
			{
				$data['filename'] = $string;
				$data['date'] = date('d-m-Y');
				$data['size'] = number_format(($_FILES['uploadimages_main_bg']['size']/1012),2).' Kb';
				$data['ext'] = $extension;

				$_REQUEST['main_dashboard']['image_link'] = $string;


				// DELETE the previous image if new image is uploaded
				$main_dashboard_background_filename = "../../images/admin_uploads/".$main_dashboard_array['image_link'];
				if (file_exists($main_dashboard_background_filename)) 
				{
					unlink($main_dashboard_background_filename);
				} 

			}
			// GIVE MESSAGE IF NOT THE EXACT PIXEL 
		}
		else
		{
			// show error message
			$error_value = '1';
			$_REQUEST['main_dashboard']['image_link'] = $_REQUEST['main_dashboard_image_link'];
		}

	}
	else
	{
		$_REQUEST['main_dashboard']['image_link'] = $_REQUEST['main_dashboard_image_link'];
	}

	//==================================== UPLOAD ADMIN DASHBOARD BACKGROUND SECTION =============================//


	// echo '<pre>';
	// print_r($_REQUEST['main_dashboard']);
	// echo '</pre>';

	// die();


	//===================================================== UPLOAD IMAGES SECTION ================================================//


	// SELECT COLOR CHOICE FOR MAIN/ADMIN DASHBOARD  

	if($_REQUEST['typeofcolorset'] == 'standard')
	{
		$colorsetdropdownvalue = $_REQUEST['colorsetdropdown'];
	}
	else if($_REQUEST['typeofcolorset'] == 'manual')
	{
		$colorsetdropdownvalue = $_REQUEST['colorsetdropdownmanual'];
	}

	// SELECT COLOR CHOICE FOR MOBILE DASHBOARD 

	if($_REQUEST['mobtypeofcolorset'] == 'standard')
	{
		$mobcolorsetdropdownvalue = $_REQUEST['mobcolorsetdropdown'];
	}
	else if($_REQUEST['mobtypeofcolorset'] == 'manual')
	{
		$mobcolorsetdropdownvalue = $_REQUEST['mobcolorsetdropdownmanual'];
	}






	// check which login screen is checked 


	// ============================================>LOGO HEADER CHANGES FOR ARRAY<==========================================

	$_REQUEST['logoandheaders'][$_REQUEST['logoandheaders']['select_admin_logo_image_selection']] =$_REQUEST['logoandheaders'];

	$_REQUEST['logoandheaders'][$_REQUEST['logoandheaders']['select_admin_banner_image_selection']] =$_REQUEST['logoandheaders'];


	// ADMIN LOGIN SCREEN LOGO 
	if(isset($_REQUEST['logoandheaders']['adminloginscreen']))
	{
		$adminloginscreen = $_REQUEST['logoandheaders']['adminloginscreen'];
	}
	else
	{
		$adminloginscreen = $admin_login_screen_logo;
	}	

	// ADMIN LOGIN SCREEN TITLE LOGO  
	if(isset($_REQUEST['logoandheaders']['adminloginscreentitle']))
	{
		$adminloginscreentitle = $_REQUEST['logoandheaders']['adminloginscreentitle'];
	}
	else
	{
		$adminloginscreentitle = $admin_login_screen_title_logo;
	}	

	// SYSTEM LOGIN SCREEN LOGO 
	if(isset($_REQUEST['logoandheaders']['systemloginscreen']))
	{
		$systemloginscreen = $_REQUEST['logoandheaders']['systemloginscreen'];
	}
	else
	{
		$systemloginscreen = $system_login_screen_logo;
	}	

	// SYSTEM LOGIN SCREEN TITLE LOGO  
	if(isset($_REQUEST['logoandheaders']['systemloginscreentitle']))
	{
		$systemloginscreentitle = $_REQUEST['logoandheaders']['systemloginscreentitle'];
	}
	else
	{
		$systemloginscreentitle = $system_login_screen_title_logo;
	}	

	// ADMIN DASHBOARD BANNER LOGO  
	if(isset($_REQUEST['logoandheaders']['admindashboardbannerlogo']))
	{
		$admindashboardbannerlogo = $_REQUEST['logoandheaders']['admindashboardbannerlogo'];
	}
	else
	{
		$admindashboardbannerlogo = $admin_dashboard_banner_logo;
	}

	// MOBILE LOGIN SCREEN BANNER LOGO  
	if(isset($_REQUEST['logoandheaders']['mobilescreenlogo']))
	{
		$mobilescreenlogo = $_REQUEST['logoandheaders']['mobilescreenlogo'];
	}
	else
	{
		$mobilescreenlogo = $mobilescreenlogo;
	}

	// ============================================>LOGO HEADER CHANGES FOR ARRAY<==========================================

	// ============================================>BANNER HEADER CHANGES FOR ARRAY<==========================================
	if(isset($_REQUEST['logoandheaders']['adminloginscreenbanner']))
	{
		$adminloginscreenbanner = $_REQUEST['logoandheaders']['adminloginscreenbanner'];
	}
	else
	{
		$adminloginscreenbanner = $admin_login_screen_banner_array;
	}	
	if(isset($_REQUEST['logoandheaders']['systemloginscreenbanner']))
	{
		$systemloginscreenbanner = $_REQUEST['logoandheaders']['systemloginscreenbanner'];
	}
	else
	{
		$systemloginscreenbanner = $system_login_screen_banner_array;
	}	
	if(isset($_REQUEST['logoandheaders']['mobloginscreenbanner']))
	{
		$mobloginscreenbanner = $_REQUEST['logoandheaders']['mobloginscreenbanner'];
	}
	else
	{
		$mobloginscreenbanner = $mob_login_screen_banner_array;
	}

	// ============================================>BANNER HEADER CHANGES FOR ARRAY<==========================================


	// echo '<pre>';
	// print_r($_REQUEST['logoandheaders']);
	// print_r($mobilescreenlogo);
	// echo '</pre>';

	// die();


	// update colors

	$sql = "UPDATE rego_color_settings SET color_set= '".$dba->real_escape_string($colorsetdropdownvalue)."' , mob_color_set= '".$dba->real_escape_string($mobcolorsetdropdownvalue)."' ,typeofcolorset= '".$dba->real_escape_string($_REQUEST['typeofcolorset'])."',typeofcolorsetmob= '".$dba->real_escape_string($_REQUEST['mobtypeofcolorset'])."' , select_login_screen = '".$dba->real_escape_string($_REQUEST['login_screen']['screen_type'])."' WHERE id = '1'";

	// update colors pallete 
	$sql1 = "UPDATE rego_color_palette SET color_set_values = '".$dba->real_escape_string(serialize($_REQUEST['colorsettings']))."' WHERE color_set = '".$colorsetdropdownvalue."'";
	$dba->query($sql1);

	// update colors pallete mob
	$sql1_mob = "UPDATE rego_color_palette SET color_set_values = '".$dba->real_escape_string(serialize($_REQUEST['mobcolorsettings']))."' WHERE color_set = '".$mobcolorsetdropdownvalue."'";
	$dba->query($sql1_mob);


	// update tab layout settings
	$sql2 = "UPDATE rego_layout_settings SET admin_dashboard = '".$dba->real_escape_string(serialize($_REQUEST['admin_dashboard']))."' , admin_login_screen = '".$dba->real_escape_string(serialize($_REQUEST['login_screen']['admin']))."', system_login_screen = '".$dba->real_escape_string(serialize($_REQUEST['login_screen']['system']))."', mob_login_screen = '".$dba->real_escape_string(serialize($_REQUEST['login_screen']['mob']))."', scan_login_screen = '".$dba->real_escape_string(serialize($_REQUEST['login_screen']['scan']))."', admin_login_screen_logo = '".$dba->real_escape_string(serialize($adminloginscreen))."', admin_login_screen_title_logo = '".$dba->real_escape_string(serialize($adminloginscreentitle))."', buttons_tab = '".$dba->real_escape_string(serialize($_REQUEST['buttons_layout']))."' , system_login_screen_logo = '".$dba->real_escape_string(serialize($systemloginscreen))."', system_login_screen_title_logo = '".$dba->real_escape_string(serialize($systemloginscreentitle))."', admin_dashboard_banner_logo = '".$dba->real_escape_string(serialize($admindashboardbannerlogo))."',main_dashboard = '".$dba->real_escape_string(serialize($_REQUEST['main_dashboard']))."',admin_login_screen_banner_array = '".$dba->real_escape_string(serialize($adminloginscreenbanner))."' ,system_login_screen_banner_array = '".$dba->real_escape_string(serialize($systemloginscreenbanner))."',mob_login_screen_logo_array = '".$dba->real_escape_string(serialize($mobilescreenlogo))."',mob_login_screen_banner_array = '".$dba->real_escape_string(serialize($mobloginscreenbanner))."'   WHERE id = '1'";
	$dba->query($sql2);


	
	if($dba->query($sql)){

		if($error_value == '1')
		{
			echo 'error';
		}
		else
		{
			echo 'success';
		}
	}else{
		echo mysqli_error($dba);
	}





