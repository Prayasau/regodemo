<?php 	include("company_layout/common_php_layout_tab.php"); ?>
<!--------------------- LOAD CUSTOM CSS FOR THIS PAGE ------------------->	
<link rel="stylesheet" href="../assets/css/company_layout_custom.css">
<!--------------------- LOAD CUSTOM CSS FOR THIS PAGE ------------------->	




<h2><i class="fa fa-industry"></i>&nbsp; <?=$lng['Layout Settings']?> <span style="float:right; display:none; font-style:italic; color:#b00" id="sAlert"><?=$lng['Data is not updated to last changes made']?></span></h2>	
<div class="main">
	

	<form id="companyForm" style="height:100%" enctype="multipart/form-data">
		<ul style="position:relative" class="nav nav-tabs" id="myTab">
			<li class="nav-item"><a class="nav-link active" data-target="#tab_admin_dashboard_settings" data-toggle="tab">Admin Dashboard</a></li>
			<li class="nav-item"><a class="nav-link" data-target="#tab_main_dashboard_settings" data-toggle="tab">Main Dashboard</a></li>
<!-- 			<li class="nav-item"><a class="nav-link" data-target="#tab_other_settings" data-toggle="tab">Scan Menu</a></li>
			<li class="nav-item"><a class="nav-link" data-target="#tab_mob_menu_settings" data-toggle="tab">Mobile Menu</a></li> -->
			<li class="nav-item"><a class="nav-link" data-target="#tab_login_screen" data-toggle="tab">Login Screen</a></li>
			<li class="nav-item"><a class="nav-link" data-target="#tab_color_settings" data-toggle="tab">Color Settings</a></li>
			<li class="nav-item"><a class="nav-link" data-target="#tab_buttons_settings" data-toggle="tab">Buttons Layout</a></li>
			<li class="nav-item"><a class="nav-link" data-target="#tab_header_settings" data-toggle="tab">Logo and Headers</a></li>
			<button style="position:absolute; bottom:6px; right:1px;border-color:<?php echo $savedAdminColors[$savedHeaderlayout['logo_and_headers_color7']]['code'] ?>;background:<?php echo $savedAdminColors[$savedHeaderlayout['logo_and_headers_color7']]['code'] ?>"  class="btn btn-primary"  id="subButton" type="submit"><i class="fa fa-save"></i>&nbsp;&nbsp;<?=$lng['Update']?></button>
		</ul>
		
		<div class="tab-content" style="height:calc(100% - 40px)">
			
			<div style="display:none" id="message"></div>
			

			<!---------- ADMIN dashboard SCREEN settings tab  --------->
			<div class="tab-pane show active" id="tab_admin_dashboard_settings">

				<?php 	include("company_layout/admin_dashboard_layout_tab.php"); ?>
									
			</div>	

			<!---------- LOGIN SCREEN settings tab  --------->
			<div class="tab-pane " id="tab_login_screen">

				<?php 	include("company_layout/login_screen_layout_tab.php"); ?>

			</div>							

			<!---------- Color settings tab  --------->

			<div class="tab-pane" id="tab_color_settings">

				<?php 	include("company_layout/color_settings_layout_tab.php"); ?>


			</div>			
			<!---------- LOGO HEADERS settings tab  --------->

			<div class="tab-pane" id="tab_header_settings">

				<?php 	include("company_layout/logo_and_header_layout_tab.php"); ?>


			</div>			

			<!---------- Color settings tab  --------->

			<div class="tab-pane" id="tab_buttons_settings">

				<?php 	include("company_layout/buttons_layout_tab.php"); ?>

			</div>

			<!---------- MAIN DASHBOARD settings tab  --------->

			<div class="tab-pane" id="tab_main_dashboard_settings">

				<?php 	include("company_layout/main_dashboard_layout_tab.php"); ?>

			</div>
			


	


		</form>


				
		</div>
			

</div>



<?php 	include("company_layout/common_layout_script.php"); ?>








