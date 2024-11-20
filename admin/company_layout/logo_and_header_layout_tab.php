<?php 

// REMOVE FILTERED VALUES FROM ARRAY 

if($_SESSION['logo_and_headers_filter_session'])
{
	$filter_session = $_SESSION['logo_and_headers_filter_session'];
}
else
{
	$filter_session = 'admin';
}

$filtered_select_logo_location_array['select'] = 'Select';
foreach ($select_logo_location_array as $key_filter1 => $value_filter1) {

	$haystack = $key_filter1;
	$needle   = $filter_session;

	if( strpos( $haystack, $needle ) !== false) {
		$filtered_select_logo_location_array[$key_filter1] = $value_filter1;
	}

}
$filtered_select_banner_location_array['select'] = 'Select';
foreach ($select_banner_location_array as $key_filter2 => $value_filter2) {

	$haystack = $key_filter2;
	$needle   = $filter_session;

	if( strpos( $haystack, $needle ) !== false) {
		$filtered_select_banner_location_array[$key_filter2] = $value_filter2;
	}

}


?>
<div style="position:absolute; left:24px; top:57px; right:70%; bottom:0; background:#fff;">
	<div id="leftTable" style="left:10px; top:45px; right:10px; bottom:15px; background:#fff; overflow-Y:auto; padding:0; display:xnone; overflow-X:hidden">


		<table class="basicTable inputs" border="0">
			<thead  >
				<tr>
					<th colspan="2">
					 	Filter Screen
					</th>
				</tr>
				<tr >
					<td colspan="2"> 
						<select id="select_filter_logo_and_headers" name="logoandheaders[select_filter_logo_and_headers]" style="width:100%;border: none;">
							<option <?php if($_SESSION['logo_and_headers_filter_session'] == 'admin'){ echo "Selected";} ?> value="admin">Admin Screens</option>
							<option <?php if($_SESSION['logo_and_headers_filter_session'] == 'system'){ echo "Selected";} ?> value="system">System Screens</option>
							<option <?php if($_SESSION['logo_and_headers_filter_session'] == 'mob'){ echo "Selected";} ?> value="mob">Mobile Screens</option>
							<option <?php if($_SESSION['logo_and_headers_filter_session'] == 'scan'){ echo "Selected";} ?> value="scan">Scan Screens</option>
						</select>	
					</td>
				</tr>	

			</thead>
			<thead data-toggle="collapse" data-target="#logoandheadersheader1">
				<tr>
					<th colspan="2">
						<i class="fa fa-arrow-circle-down"></i>&nbsp; Select Logo Location 
					</th>
				</tr>
			</thead>
			<tbody class="collapse" id="logoandheadersheader1">
				<tr>
					<th style="vertical-align:top">Select Location </th>
					<td> 
						<select id="select_admin_logo_image_selection" name="logoandheaders[select_admin_logo_image_selection]" style="width:85%">
							<?php foreach ($filtered_select_logo_location_array as $keyImage => $valueImage){ ?>
								<option  value="<?php echo $keyImage;?>"><?php echo $valueImage?></option><?php } ?>
						</select>	
					</td>
				</tr>	
				<tr id="uploadlogorowlogoheaders">
					<th style="vertical-align:top">Upload Logo </th>
					<td> 
						<input style="visibility:hidden; height:0; float:left" type="file" name="uploadimages_admin_logo" id="uploadimages_admin_logo" class="uploadimages_admin_bg" />
				
						<button id="selectadminlogobutton"  onclick="$('#uploadimages_admin_logo').click()" class="btn btn-outline-secondary btn-xs" style="display: none;margin-top:10px;margin-bottom: 10px;margin-left: 10px!important; padding:0px 8px; display:inline-block;margin-left: 10px;" type="button"><?=$lng['Select file']?></button>
						<input type="hidden" id="admin_screen_logo_image_link" name="logoandheaders[admin_screen_logo_image_link]" value="">
						<br>

						<img id="admin_logo_image_preview" src="" style="height: 30px;margin-left: 10px;">
						<textarea id="admin_logo_name_image_preview" readonly="readonly"></textarea>


					</td>
				</tr>

				<tr id="hdieimagesizerowadmin">
					<th style="vertical-align:top">Image Size </th>
					<td>
						  <div class="value-button" id="decrease" onclick="decreaseValue('admin_login_screen_logo_size')" value="Decrease Value">-</div>
						  	<input readonly="readonly" type="text" id="admin_login_screen_logo_size" value="45" name="logoandheaders[admin_login_screen_logo_size]"/>
						  <div class="value-button" id="increase" onclick="increaseValue('admin_login_screen_logo_size')" value="Increase Value">+</div>

					</td>
				</tr>				

				<tr id="hdiecheckboxrowadmin">
					<th style="vertical-align:top">Show/Hide Logo </th>
					<td>
						  <input <?php if( $combineLogoHeadersArray['admin_login_screen_logo']['show_hide_logo_common_field'] == '1'){echo "checked";} ?> style="margin: 7px;height: 15px;width: 15px;" type="checkbox" name="logoandheaders[show_hide_logo_common_field]" id="show_hide_logo_common_field" value="1" />
					</td>
				</tr>	

			</tbody>
			<thead data-toggle="collapse" data-target="#logoandheadersheader2">
				<tr>
					<th colspan="2">
						<i class="fa fa-arrow-circle-down"></i>&nbsp; Select Banner Location 
					</th>
				</tr>
			</thead>
			<tbody class="collapse" id="logoandheadersheader2">
				<tr>
					<th style="vertical-align:top">Select Location </th>
					<td> 
						<select id="select_admin_banner_image_selection" name="logoandheaders[select_admin_banner_image_selection]" style="width:85%">
							<?php foreach ($filtered_select_banner_location_array as $keyImage => $valueImage){ ?>
								<option  value="<?php echo $keyImage;?>"><?php echo $valueImage?></option><?php } ?>
						</select>	
					</td>
				</tr>	
				<tr id="uploadlogorowlogoheadersbanner">
					<th style="vertical-align:top">Upload Logo </th>
					<td> 
						<input style="visibility:hidden; height:0; float:left" type="file" name="uploadimages_admin_login_banner" id="uploadimages_admin_login_banner" class="uploadimages_admin_bg" />
				
						<button id="selectadminlogobuttonbanner"  onclick="$('#uploadimages_admin_login_banner').click()" class="btn btn-outline-secondary btn-xs" style="display: none;margin-top:10px;margin-bottom: 10px;margin-left: 10px!important; padding:0px 8px; display:inline-block;margin-left: 10px;" type="button"><?=$lng['Select file']?></button>
						<input type="hidden" id="admin_screen_logo_image_link_banner" name="logoandheaders[admin_screen_logo_image_link_banner]" value="">
						<br>

						<img id="admin_logo_image_preview_banner" src="" style="height: 14px;margin-left: 10px;">
						<textarea id="admin_logo_image_preview_banner_text" readonly="readonly"></textarea>


					</td>
				</tr>

				<tr id="hdiecheckboxrowadminbanner">
					<th style="vertical-align:top">Show/Hide Logo </th>
					<td>
						  <input <?php if( $combineLogoHeadersArray['admin_login_screen_logo']['show_hide_logo_common_field_banner'] == '1'){echo "checked";} ?> style="margin: 7px;height: 15px;width: 15px;" type="checkbox" name="logoandheaders[show_hide_logo_common_field_banner]" id="show_hide_logo_common_field_banner" value="1" />
					</td>
				</tr>
			</tbody>
		</table>
		<div style="height:15px"></div>

	</div>
</div>


<!---- --->
<div style="position:absolute; left:30%; top:57px; right:0; bottom:0; background: #f6f6f6; border-left:1px solid #ddd">
			
<!-- 	<div id="rightTable" style="position: absolute; left: 15px; top: 0px; right: 15px; bottom: 15px; background: #fff;overflow-y: auto; padding: 15px 15px 100px; padding-top: 0px!important;">
		<div class="dash-left" style="width:100%!important;">
	
			<div  style="position: relative!important;">
				<table class="table">
					<tr>
						<th> <span id= "titleoftheselecetedlogo"> Admin Login Screen Logo </span></th>
					</tr>
					<tr>
						<td style="text-align: center;">
							<div class="brand">
								<img id="admin_logo_image_preview_logo_and_headers" style="height: 45px;" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $admin_login_screen_array['image_link']?>">
								<p></p>
							</div>
						</td>
					</tr>				
				</table>
			</div>
		</div>
	</div> -->



	<div class="rightTable_admin_login_screen_logo" id="rightTable_admin_login_screen_logo" style=" background: url('../images/admin_uploads/<?php echo $admin_login_screen_array['bg_image_link']?>')no-repeat;background-position: bottom;background-size: cover;  overflow-y: auto; padding: 15px 15px 100px; padding-top: 0px!important;display: none;">
		<div class="dash-left" style="width: 100%!important;">
			<div id="brand_logo">
				<a style="margin:0px 0 0 0" data-lng="th" class="langbutton "><img src="../images/flag_th.png"></a>
			</div>
			<div id="brand_titles">
				<b style="font-family:'Roboto Condensed'; font-weight:400; font-size:24px; color:#333;"><img style="height:<?php echo $combineLogoHeadersArray['admin_login_screen_title_logo']['admin_login_screen_logo_size'].'px'?>;" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $combineLogoHeadersArray['admin_login_screen_title_logo']['image_link']?>"><span  style="position: absolute;top: 19px;left: 215px;"><?php if($admin_login_screen_array['select_admin_login_screen_title_text'] != '') {echo $admin_login_screen_array['select_admin_login_screen_title_text']; }else{ echo 'Admin Platform';} ?></span></b>
			</div>
			<div style="padding-top:12vh; xborder:1px solid red" >
				<div class="brand">
					<img  id="admin_logo_image_preview_logo_and_headers" style="display:<?php if($combineLogoHeadersArray['admin_login_screen_logo']['show_hide_logo_common_field'] != '1'){echo 'none';}?>;margin-left: 146px;height: <?php echo $combineLogoHeadersArray['admin_login_screen_logo']['admin_login_screen_logo_size'].'px'?>" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $combineLogoHeadersArray['admin_login_screen_logo']['image_link']?>">
					<p></p>
				</div>
				<div class="logform" >
					<h2 id="admin_login_screen_h2_div" style="background:#007700; border-radius:3px 3px 0 0"><i class="fa fa-lock"></i> &nbsp;<span>Login to our secure server</span></h2>
					<div class="logform-inner " id="admin_box_color">
						<div id="logMsg" style="color:#b00; font-weight:600; font-size:14px; display:none"></div>
						<div id="login">
							<form id="logForm">
								<label>Username <i class="man"></i></label>
								<input name="username" type="text" autocomplete="username" value="" />
								<label>Password <i class="man"></i></label>
								<input name="password" type="password" autocomplete="current-password" value="" />
								<div style="height:15px"></div>
								<button  style="background:<?php echo $selectedColorsVal[$admin_login_screen_array['select_admin_login_button_color']]; ?>" type="button" class="btn btn-primary"><i class="fa fa-sign-in"></i>&nbsp; Log-in</button>
								<button style="float:right;background:<?php echo $selectedColorsVal[$admin_login_screen_array['select_admin_login_forgotbutton_color']]; ?>" id="togglediv" type="button" class=" btn btn-primary">Forgot password</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			
		</div> <!-- dash left ends -->
	</div><!-- div right ends -->		

	<div class="rightTable_mob_login_screen_logo" id="rightTable_mob_login_screen_logo" style=" background: rgb(255, 255, 255);  overflow-y: auto; padding: 15px 15px 100px; padding-top: 0px!important;display: none;">
		<div class="dash-left" style="width: 100%!important;">
			<div class="appHeader1 bg-dark text-light">
			    <div class="pageTitle"><span id="mob_heading_font">Login to our secure server</span></div>
			</div>

			<div class="container-fluid" style="xborder:1px solid red">
				<div class="row" style="xborder:1px solid green; padding:25px">
					<div class="col-12">
						<?php if($combineLogoHeadersArray['mob_login_screen_logo_array']['show_hide_logo_common_field'] == '1') { ?>

						<img id="mob_logo_selection_logo_and_headers" style="height:<?php echo $combineLogoHeadersArray['mob_login_screen_logo_array']['admin_login_screen_logo_size'].'px'?>;display:<?php if($combineLogoHeadersArray['mob_login_screen_logo_array']['show_hide_logo_common_field'] != '1'){echo 'none';}?>" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $combineLogoHeadersArray['mob_login_screen_logo_array']['image_link']?> ">

						<?php } ?>
						
						<div class="divider-icon">
							<div><i class="fa fa-lock fa-lg"></i></div>
						</div>
						
						<div id="logForm">	
							<form id="log_form">
								<div class="form-group">
									<label for="username">Username</label>
									<input class="form-control" type="text" name="username" value="" id="username" style="width: 100%;" />
								</div>
								<div class="form-group">
									<label for="password">Password</label>
									<input class="form-control" type="password" name="password" value="" id="password" style="width: 100%;"/>
								</div>
								<table border="0" style="margin-bottom:10px;">
									<tr>
										<td>
											<div class="custom-control custom-switch" style="">
													<input checked type="checkbox" class="custom-control-input" name="remember" id="remember" value="1" >
													<label style="background: #007bff!important" class="custom-control-label" for="remember"></label>
											</div>
										</td>
										<td style="padding-left:8px; font-weight:500">Remember me</td>
									</tr>
								</table>
								<button id="mob_login_button" style="margin-bottom:6px" type="button" class="btn btn-default btn-block" style="background:#239965!important;">Log-in &nbsp;<i class="fa fa-sign-in fa-lg"></i></button>
								<button type="button" class="btn btn-info btn-block" id="forgot" style="background: #007bff!important;">Forgot password</button>
								<div style="color:#a00; font-size:15px; display:none; margin-top:10px" id="logMsg"></div>
							</form>
						</div>
						
						<div style="height:250px"></div>
						
					</div>
				</div>
			</div>	

			<div class="fixBottomMenu" style="border:0">
				<a href="#" data-lng="th" class="langbutton "><img src="../images/flag_th.png"></a>
			</div>
		</div> <!-- dash left ends -->
	</div><!-- div right ends -->	

	<div class="rightTable_admin_login_screen_title_logo" id="rightTable_admin_login_screen_title_logo" style=" background: url('../images/admin_uploads/<?php echo $admin_login_screen_array['bg_image_link']?>')no-repeat;background-position: bottom;background-size: cover;  overflow-y: auto; padding: 15px 15px 100px; padding-top: 0px!important;display: none;">
		<div class="dash-left" style="width: 100%!important;">
			<div id="brand_logo">
				<a style="margin:0px 0 0 0" data-lng="th" class="langbutton "><img src="../images/flag_th.png"></a>
			</div>
			<div id="brand_titles">
				<b style="font-family:'Roboto Condensed'; font-weight:400; font-size:24px; color:#333;"><img id="admin_login_screen_logo_title" style="display:<?php if($combineLogoHeadersArray['admin_login_screen_title_logo']['show_hide_logo_common_field'] != '1'){echo 'none';}?>;height:<?php echo $combineLogoHeadersArray['admin_login_screen_title_logo']['admin_login_screen_logo_size'].'px'?>;" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $combineLogoHeadersArray['admin_login_screen_title_logo']['image_link']?>"><span  style="position: absolute;top: 19px;left: 215px;"><?php if($admin_login_screen_array['select_admin_login_screen_title_text'] != '') {echo $admin_login_screen_array['select_admin_login_screen_title_text']; }else{ echo 'Admin Platform';} ?></span></b>
			</div>
			<div style="padding-top:12vh; xborder:1px solid red" >
				<div class="brand">
					<img   style="margin-left: 146px;height: <?php echo $combineLogoHeadersArray['admin_login_screen_logo']['admin_login_screen_logo_size'].'px'?>" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $combineLogoHeadersArray['admin_login_screen_logo']['image_link']?>">
					<p></p>
				</div>
				<div class="logform" >
					<h2 id="admin_login_screen_h2_div" style="background:#007700; border-radius:3px 3px 0 0"><i class="fa fa-lock"></i> &nbsp;<span>Login to our secure server</span></h2>
					<div class="logform-inner " id="admin_box_color">
						<div id="logMsg" style="color:#b00; font-weight:600; font-size:14px; display:none"></div>
						<div id="login">
							<form id="logForm">
								<label>Username <i class="man"></i></label>
								<input name="username" type="text" autocomplete="username" value="" />
								<label>Password <i class="man"></i></label>
								<input name="password" type="password" autocomplete="current-password" value="" />
								<div style="height:15px"></div>
								<button  style="background:<?php echo $selectedColorsVal[$admin_login_screen_array['select_admin_login_button_color']]; ?>" type="button" class="btn btn-primary"><i class="fa fa-sign-in"></i>&nbsp; Log-in</button>
								<button style="float:right;background:<?php echo $selectedColorsVal[$admin_login_screen_array['select_admin_login_forgotbutton_color']]; ?>" id="togglediv" type="button" class=" btn btn-primary">Forgot password</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			
		</div> <!-- dash left ends -->
	</div><!-- div right ends -->	

	<div class="rightTable_admindashboardbannerlogo" id="rightTable_admindashboardbannerlogo" style="display:none;overflow-y: auto; padding: 15px 15px 100px; padding-top: 0px!important;">

		<div class="header headergradientcolorlogoandheaders" style="position: relative!important;">
			<table width="100%" border="0">
				<tbody>
					<tr>
						<td style="padding-left:15px; width:1px">
							<img id="admin_dashboard_banner_logo_logoandheaders" style="margin:5px 7px 5px 0; height:<?php echo $combineLogoHeadersArray['admin_dashboard_banner_logo']['admin_login_screen_logo_size'].'px';?>;display:<?php if($combineLogoHeadersArray['admin_dashboard_banner_logo']['show_hide_logo_common_field'] != '1'){echo 'none';}?>" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $combineLogoHeadersArray['admin_dashboard_banner_logo']['image_link']?>">
						</td>
						<td id="headermaintitlelogoandheaders" style="white-space:nowrap; vertical-align:middle; padding-left:5px">
							<b style="font-family:'Roboto Condensed'; font-weight:400; font-size:24px; color:#333;"><span>Admin Platform</span></b>
						</td>
						<td style="width:95%"></td>
						<td>
							<a data-lng="th" class="langbutton admin_lang "><img src="../images/flag_th.png"></a>
						</td><td style="padding:0 10px">
							<button type="button" class="alogout btn btn-logout"><i class="fa fa-power-off"></i></button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="topnav-custom navbarbackgroundcolorlogoandheader" style="position: relative!important;top: 0px!important;">
	
			<div class="btn-group ">
				<a id= "homeButtonlogoandheader" style="background-color: #080;" href="#" class="home"><i class="fa fa-home"></i></a>
			</div>
			
			<div class="btn-group navbarbackgroundcolorlogoandheader" style="float:right; background:#000 !important">
				<button data-toggle="dropdown" style="padding:0 10px 0 0" id="regoadminheaderbuttonlogoandheader">
					 <img style="height:36px; width:36px; display:inline-block; border-radius:0px; margin:-4px 10px 0 10px; border:0px solid #666" src="https://regodemo.com/images/xrayadmin.jpg?1643950464?1643958234"><b><span id="regoadminamespanlogoandheader">REGO Admin</span></b>&nbsp; <span class="caret"></span>
				</button>
			</div>
			
			<div class="btn-group navbarbackgroundcolorlogoandheader" style="float:right; background:#000 !important"><a id="admin_dashboard_header_font_stylelogoandheader" style="font-size:16px; color:#fd0"><b>38</b> Employees in <b>3</b> Companies</a>
			</div>
			
		</div>	
	</div><!-- div right ends -->


	<div class="rightTable_system_login_screen_logo_logoandheaders" id="rightTable_system_login_screen_logo_logoandheaders" style=" background: url('../images/admin_uploads/<?php echo $system_login_screen_array['bg_image_link']?>')no-repeat;background-position: bottom;background-size: cover;  overflow-y: auto; padding: 15px 15px 100px; padding-top: 0px!important;display: none;">
			<div class="dash-left" style="width: 100%!important;">
				<div id="brand_logo">
						<a style="margin:0px 0 0 0" data-lng="th" class="langbutton "><img src="../images/flag_th.png"></a>
				</div>

				<div id="brand_title">
					<b style="font-family:'Roboto Condensed'; font-weight:400; font-size:24px; color:#333;"><img id="system_logo_image_select_logoandheaders_loginscreenlogo_title1" style="display:<?php if($combineLogoHeadersArray['system_login_screen_title_logo']['show_hide_logo_common_field'] != '1'){echo 'none';}?>;height:<?php echo $combineLogoHeadersArray['system_login_screen_title_logo']['admin_login_screen_logo_size'].'px'?>;" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $combineLogoHeadersArray['system_login_screen_title_logo']['image_link']?> "><span id="systemloginscreentitletextss" style="position: absolute;top: 19px;left: 215px;"><?php if($system_login_screen_array['select_admin_login_screen_title_text'] != '') {echo $system_login_screen_array['select_admin_login_screen_title_text']; }else{ echo 'Integrated HR Platform';} ?></span></b>
				</div>

				<div id="systemloginscreenformlogoandheaderssystemloginscreenlogo" style="padding-top:10vh; xborder:1px solid red;float: left;margin-left: 70px;">
					<div class="brand">
						<img style="height:<?php echo $combineLogoHeadersArray['system_login_screen_logo']['admin_login_screen_logo_size'].'px';?>;display:<?php if($combineLogoHeadersArray['system_login_screen_logo']['show_hide_logo_common_field'] != '1'){echo 'none';}?>" id="system_logo_image_select_logoandheaders_loginscreenlogo" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $combineLogoHeadersArray['system_login_screen_logo']['image_link']?>">
						<p></p>
					</div>


					<div class="logform" style="xleft:1000px !important">
						<h2 id="system_login_screen_box_div_logoandheaders_loginscreenlogo"><i class="fa fa-lock"></i> &nbsp;<span>Login to our secure server<span></h2>
						<div class="logform-inner">
							<div id="login">
								<form id="logForm">
									<label>Username <i class="man"></i></label>
									<input name="username" type="text" autocomplete="username" value="" />
									<label>Password <i class="man"></i></label>
									<input name="password" type="password" autocomplete="current-password" value="" />
									<div style="height:15px"></div>
									<button id= "systemLoginScreenLoginButton_logoandheaders_loginscreenlogo" type="button" class="btn btn-primary"><i class="fa fa-sign-in"></i>&nbsp; Log-in</button>
									<button id="togglediv" style="float:right;" type="button" class="systemforgotpasswordbutton_logoandheaders_loginscreenlogo btn btn-primary">Forgot password</button>
								</form>
								<div id="dump"></div>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- dash left ends -->
	</div><!-- div right ends -->		

	<div class="rightTable_system_login_screen_title_logo_logoandheaders" id="rightTable_system_login_screen_title_logo_logoandheaders" style=" background: url('../images/admin_uploads/<?php echo $system_login_screen_array['bg_image_link']?>')no-repeat;background-position: bottom;background-size: cover;  overflow-y: auto; padding: 15px 15px 100px; padding-top: 0px!important;display: none;">
			<div class="dash-left" style="width: 100%!important;">
				<div id="brand_logo">
						<a style="margin:0px 0 0 0" data-lng="th" class="langbutton "><img src="../images/flag_th.png"></a>
				</div>

				<div id="brand_title">
					<b style="font-family:'Roboto Condensed'; font-weight:400; font-size:24px; color:#333;"><img id="system_logo_image_select_logoandheaders_loginscreenlogo_title" style="display:<?php if($combineLogoHeadersArray['system_login_screen_title_logo']['show_hide_logo_common_field'] != '1'){echo 'none';}?>;height:<?php echo $combineLogoHeadersArray['system_login_screen_title_logo']['admin_login_screen_logo_size'].'px'?>;" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $combineLogoHeadersArray['system_login_screen_title_logo']['image_link']?> "><span id="systemloginscreentitletexts" style="position: absolute;top: 19px;left: 215px;"><?php if($system_login_screen_array['select_admin_login_screen_title_text'] != '') {echo $system_login_screen_array['select_admin_login_screen_title_text']; }else{ echo 'Integrated HR Platform';} ?></span></b>
				</div>

				<div id="systemloginscreenformlogoandheaderssystemloginscreenlogotitle" style="padding-top:10vh; xborder:1px solid red;float: left;margin-left: 70px;">
					<div class="brand">
						<img style="height:<?php echo $combineLogoHeadersArray['system_login_screen_logo']['admin_login_screen_logo_size'].'px';?>;display:<?php if($combineLogoHeadersArray['system_login_screen_logo']['show_hide_logo_common_field'] != '1'){echo 'none';}?>"  src="<?php echo ROOT;?>images/admin_uploads/<?php echo $combineLogoHeadersArray['system_login_screen_logo']['image_link']?>">
						<p></p>
					</div>


					<div class="logform" style="xleft:1000px !important">
						<h2 id="system_login_screen_box_div_logoandheaders_loginscreenlogo_title"><i class="fa fa-lock"></i> &nbsp;<span>Login to our secure server<span></h2>
						<div class="logform-inner">
							<div id="login">
								<form id="logForm">
									<label>Username <i class="man"></i></label>
									<input name="username" type="text" autocomplete="username" value="" />
									<label>Password <i class="man"></i></label>
									<input name="password" type="password" autocomplete="current-password" value="" />
									<div style="height:15px"></div>
									<button id= "systemLoginScreenLoginButton_logoandheaders_loginscreenlogo_title" type="button" class="btn btn-primary"><i class="fa fa-sign-in"></i>&nbsp; Log-in</button>
									<button id="togglediv" style="float:right;" type="button" class="systemforgotpasswordbutton_logoandheaders_loginscreenlogo_title btn btn-primary">Forgot password</button>
								</form>
								<div id="dump"></div>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- dash left ends -->
	</div><!-- div right ends -->	


	<div class="rightTable_admin_login_screen_logo_banner" id="rightTable_admin_login_screen_logo_banner" style=" background: url('../images/admin_uploads/<?php echo $admin_login_screen_array['bg_image_link']?>')no-repeat;background-position: bottom;background-size: cover;  overflow-y: auto; padding: 15px 15px 100px; padding-top: 0px!important;display: none;">
		<div class="dash-left" style="width: 100%!important;">
			<div id="brand_logo">
				<a style="margin:0px 0 0 0" data-lng="th" class="langbutton "><img src="../images/flag_th.png"></a>
			</div>
			<div id="brand_titles">
				<b style="font-family:'Roboto Condensed'; font-weight:400; font-size:24px; color:#333;"><img style="height:<?php echo $combineLogoHeadersArray['admin_login_screen_title_logo']['admin_login_screen_logo_size'].'px'?>;" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $combineLogoHeadersArray['admin_login_screen_title_logo']['image_link']?>"><span  style="position: absolute;top: 19px;left: 215px;"><?php if($admin_login_screen_array['select_admin_login_screen_title_text'] != '') {echo $admin_login_screen_array['select_admin_login_screen_title_text']; }else{ echo 'Admin Platform';} ?></span></b>
			</div>
			<div style="padding-top:12vh; xborder:1px solid red" >
				<div class="brand">
					<img  id="admin_logo_image_preview_logo_and_headers" style="display:<?php if($combineLogoHeadersArray['admin_login_screen_logo']['show_hide_logo_common_field'] != '1'){echo 'none';}?>;margin-left: 146px;height: <?php echo $combineLogoHeadersArray['admin_login_screen_logo']['admin_login_screen_logo_size'].'px'?>" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $combineLogoHeadersArray['admin_login_screen_logo']['image_link']?>">
					<p></p>
				</div>
				<div class="logform" >
					<h2 id="admin_login_screen_h2_div" style="background:#007700; border-radius:3px 3px 0 0"><i class="fa fa-lock"></i> &nbsp;<span>Login to our secure server</span></h2>
					<div class="logform-inner " id="admin_box_color">
						<div id="logMsg" style="color:#b00; font-weight:600; font-size:14px; display:none"></div>
						<div id="login">
							<form id="logForm">
								<label>Username <i class="man"></i></label>
								<input name="username" type="text" autocomplete="username" value="" />
								<label>Password <i class="man"></i></label>
								<input name="password" type="password" autocomplete="current-password" value="" />
								<div style="height:15px"></div>
								<button  style="background:<?php echo $selectedColorsVal[$admin_login_screen_array['select_admin_login_button_color']]; ?>" type="button" class="btn btn-primary"><i class="fa fa-sign-in"></i>&nbsp; Log-in</button>
								<button style="float:right;background:<?php echo $selectedColorsVal[$admin_login_screen_array['select_admin_login_forgotbutton_color']]; ?>" id="togglediv" type="button" class=" btn btn-primary">Forgot password</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			
		</div> <!-- dash left ends -->

		<div>
			<img id="admin_logo_image_preview_logo_and_headersbanner" style="position: absolute;bottom: 0px;width: 100%;" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $combineLogoHeadersArray['admin_login_screen_banner_array']['image_link']; ?>">
		</div> 
		
	</div><!-- div right ends -->	


	<div class="rightTable_system_login_screen_title_logo_logoandheaders_banner" id="rightTable_system_login_screen_title_logo_logoandheaders_banner" style=" background: url('../images/admin_uploads/<?php echo $system_login_screen_array['bg_image_link']?>')no-repeat;background-position: bottom;background-size: cover;  overflow-y: auto; padding: 15px 15px 100px; padding-top: 0px!important;display: none;">
			<div class="dash-left" style="width: 100%!important;">
				<div id="brand_logo">
						<a style="margin:0px 0 0 0" data-lng="th" class="langbutton "><img src="../images/flag_th.png"></a>
				</div>

				<div id="brand_title">
					<b style="font-family:'Roboto Condensed'; font-weight:400; font-size:24px; color:#333;"><img id="system_logo_image_select_logoandheaders_loginscreenlogo_title3" style="display:<?php if($combineLogoHeadersArray['system_login_screen_title_logo']['show_hide_logo_common_field'] != '1'){echo 'none';}?>;height:<?php echo $combineLogoHeadersArray['system_login_screen_title_logo']['admin_login_screen_logo_size'].'px'?>;" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $combineLogoHeadersArray['system_login_screen_title_logo']['image_link']?> "><span id="systemloginscreentitletexts3" style="position: absolute;top: 19px;left: 215px;"><?php if($system_login_screen_array['select_admin_login_screen_title_text'] != '') {echo $system_login_screen_array['select_admin_login_screen_title_text']; }else{ echo 'Integrated HR Platform';} ?></span></b>
				</div>

				<div id="systemloginscreenformlogoandheaderssystemloginscreenlogotitle3" style="padding-top:10vh; xborder:1px solid red;float: left;margin-left: 70px;">
					<div class="brand">
						<img style="height:<?php echo $combineLogoHeadersArray['system_login_screen_logo']['admin_login_screen_logo_size'].'px';?>;display:<?php if($combineLogoHeadersArray['system_login_screen_logo']['show_hide_logo_common_field'] != '1'){echo 'none';}?>"  src="<?php echo ROOT;?>images/admin_uploads/<?php echo $combineLogoHeadersArray['system_login_screen_logo']['image_link']?>">
						<p></p>
					</div>


					<div class="logform" style="xleft:1000px !important">
						<h2 id="system_login_screen_box_div_logoandheaders_loginscreenlogo_title3"><i class="fa fa-lock"></i> &nbsp;<span>Login to our secure server<span></h2>
						<div class="logform-inner">
							<div id="login">
								<form id="logForm">
									<label>Username <i class="man"></i></label>
									<input name="username" type="text" autocomplete="username" value="" />
									<label>Password <i class="man"></i></label>
									<input name="password" type="password" autocomplete="current-password" value="" />
									<div style="height:15px"></div>
									<button id= "systemLoginScreenLoginButton_logoandheaders_loginscreenlogo_title3" type="button" class="btn btn-primary"><i class="fa fa-sign-in"></i>&nbsp; Log-in</button>
									<button id="togglediv" style="float:right;" type="button" class="systemforgotpasswordbutton_logoandheaders_loginscreenlogo_title btn btn-primary">Forgot password</button>
								</form>
								<div id="dump"></div>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- dash left ends -->

			<div>
				<img id="admin_logo_image_preview_logo_and_headersbannersystem" style="position: absolute;bottom: 0px;width: 100%;" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $combineLogoHeadersArray['admin_login_screen_banner_array']['image_link']; ?>">
			</div> 

	</div><!-- div right ends -->	


	<div class="rightTable_mob_login_screen_banner_logo" id="rightTable_mob_login_screen_banner_logo" style=" background: rgb(255, 255, 255);  overflow-y: auto; padding: 15px 15px 100px; padding-top: 0px!important;display: none;">
		<div class="dash-left" style="width: 100%!important;">
			<div class="appHeader1 bg-dark text-light">
			    <div class="pageTitle"><span id="mob_heading_font">Login to our secure server</span></div>
			</div>

			<div class="container-fluid" style="xborder:1px solid red">
				<div class="row" style="xborder:1px solid green; padding:25px">
					<div class="col-12">
						<?php if($combineLogoHeadersArray['mob_login_screen_logo_array']['show_hide_logo_common_field'] == '1') { ?>

						<img id="mob_banner_selection_logo_and_headerssss" style="height:<?php echo $combineLogoHeadersArray['mob_login_screen_logo_array']['admin_login_screen_logo_size'].'px'?>;display:<?php if($combineLogoHeadersArray['mob_login_screen_logo_array']['show_hide_logo_common_field'] != '1'){echo 'none';}?>" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $combineLogoHeadersArray['mob_login_screen_logo_array']['image_link']?> ">

						<?php } ?>
						
						<div class="divider-icon">
							<div><i class="fa fa-lock fa-lg"></i></div>
						</div>
						
						<div id="logForm">	
							<form id="log_form">
								<div class="form-group">
									<label for="username">Username</label>
									<input class="form-control" type="text" name="username" value="" id="username" style="width: 100%;" />
								</div>
								<div class="form-group">
									<label for="password">Password</label>
									<input class="form-control" type="password" name="password" value="" id="password" style="width: 100%;"/>
								</div>
								<table border="0" style="margin-bottom:10px;">
									<tr>
										<td>
											<div class="custom-control custom-switch" style="">
													<input checked type="checkbox" class="custom-control-input" name="remember" id="remember" value="1" >
													<label style="background: #007bff!important" class="custom-control-label" for="remember"></label>
											</div>
										</td>
										<td style="padding-left:8px; font-weight:500">Remember me</td>
									</tr>
								</table>
								<button id="mob_login_button" style="margin-bottom:6px" type="button" class="btn btn-default btn-block" style="background:#239965!important;">Log-in &nbsp;<i class="fa fa-sign-in fa-lg"></i></button>
								<button type="button" class="btn btn-info btn-block" id="forgot" style="background: #007bff!important;">Forgot password</button>
								<div style="color:#a00; font-size:15px; display:none; margin-top:10px" id="logMsg"></div>
							</form>
						</div>
						
						<div ></div>
						
					</div>
				</div>
			</div>	

			<div class="fixBottomMenu" style="border:0;position: absolute;top: 89px;right: 63px;">
				<a href="#" data-lng="th" class="langbutton "><img src="../images/flag_th.png"></a>
			</div>

			<div class="fixBottomMenu" style="border:0;position: fixed;bottom: 0px;">
				<?php if($combineLogoHeadersArray['mob_login_screen_banner_array']['show_hide_logo_common_field_banner'] == '1') { ?>

				<img id="mob_banner_selection_logo_and_headers" style="width: 100%;height: 71px;" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $combineLogoHeadersArray['mob_login_screen_banner_array']['image_link']	;?>">

				<?php } ?>
			</div>
		</div> <!-- dash left ends -->
	</div><!-- div right ends -->	




</div>

