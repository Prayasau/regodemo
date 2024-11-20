	
	<?php

		// $sql11 = "SELECT * FROM rego_layout_settings WHERE id= '1'";
		// if($res11 = $dbx->query($sql11)){
		// 	if($row11 = $res11->fetch_assoc())
		// 	{
		// 		$scanLoginSystemDataValue = unserialize($row11['system_login_screen']);	
		// 	}
		// }

		// echo '<pre>';
		// print_r($scanLoginSystemDataValue);
		// echo '</pre>';
		// die();


		// $sql22 = "SELECT * FROM rego_color_settings WHERE id= '1'";
		// if($res22 = $dbx->query($sql22)){
		// 	if($row22 = $res22->fetch_assoc())
		// 	{
		// 		$getDefaultFonts  = unserialize($row22['font_settings']);
		// 	}
		// }



		// $sql333 = "SELECT * FROM rego_color_settings WHERE id= '1'";
		// if($res333 = $dbx->query($sql333)){
		// 	if($row333 = $res333->fetch_assoc())
		// 	{
		// 		$array333['color_set'] = $row333['color_set'];
		// 		$array333['typeofcolorset'] = $row333['typeofcolorset'];
		// 	}
		// }



		// $sq444 = "SELECT * FROM rego_color_palette WHERE color_set= '".$array333['color_set']."' AND color_set_type= '".$array333['typeofcolorset']."'";
		// if($res444 = $dbx->query($sq444)){
		// 	if($row444 = $res444->fetch_assoc())
		// 	{
		// 		$savedAdminColors  = unserialize($row444['color_set_values']);
		// 	}
		// }



	?>
	<? if($comp_settings['txt_color'] == 'blue'){ ?>
	<link rel="stylesheet" href="<?=ROOT?>assets/css/pkf.css?<?=time()?>">
	<? } ?>
			<style type="text/css">
		.preloader {
			/*background-color: rgba(0, 0, 0, 0.5);*/
			background-color: rgb(255 255 255 / 100%);
			bottom: 0;
			height: 100%;
			left: 0;
			position: fixed;
			right: 0;
			top: 0;
			width: 100%;
			z-index: 9999;
		}
		.loader_grid {
			height: 60px;
			margin: 0 auto;
			position: relative;
			top: 50%;
			-moz-transform: translateY(-50%);
			-webkit-transform: translateY(-50%);
			transform: translateY(-50%);
			width: 60px;
		}
		.loader_grid .loader_box {
			width: 33%;
			height: 33%;
			background-color: #0E93D8;
			/*background-color: #ffffff;*/
			float: left;
			-webkit-animation: sk-cubeGridScaleDelay 1.3s infinite ease-in-out;
			animation: sk-cubeGridScaleDelay 1.3s infinite ease-in-out; 
		}
		.loader_grid .loader_box1 {
			-webkit-animation-delay: 0.2s;
			animation-delay: 0.2s;
		}
		.loader_grid .loader_box2 {
			-webkit-animation-delay: 0.3s;
			animation-delay: 0.3s; 
		}
		.loader_grid .loader_box3 {
			-webkit-animation-delay: 0.4s;
			animation-delay: 0.4s; 
		}
		.loader_grid .loader_box4 {
			-webkit-animation-delay: 0.1s;
			animation-delay: 0.1s; 
		}
		.loader_grid .loader_box5 {
			-webkit-animation-delay: 0.2s;
			animation-delay: 0.2s;
		}
		.loader_grid .loader_box6 {
			-webkit-animation-delay: 0.3s;
			animation-delay: 0.3s; 
		}
		.loader_grid .loader_box7 {
			-webkit-animation-delay: 0s;
			animation-delay: 0s; 
		}
		.loader_grid .loader_box8 {
			-webkit-animation-delay: 0.1s;
			animation-delay: 0.1s; 
		}
		.loader_grid .loader_box9 {
			-webkit-animation-delay: 0.2s;
			animation-delay: 0.2s; 
		}

		@-webkit-keyframes sk-cubeGridScaleDelay {
			0%, 70%, 100% {
			-webkit-transform: scale3D(1, 1, 1);
			transform: scale3D(1, 1, 1);
		  } 35% {
			-webkit-transform: scale3D(0, 0, 1);
			transform: scale3D(0, 0, 1); 
		  }
		}

		@keyframes sk-cubeGridScaleDelay {
			0%, 70%, 100% {
			-webkit-transform: scale3D(1, 1, 1);
			transform: scale3D(1, 1, 1);
		  } 35% {
			-webkit-transform: scale3D(0, 0, 1);
			transform: scale3D(0, 0, 1);
		  } 
		}


	</style>
	<!-- LOADER -->
	<div class="preloader" >
	    <div class="loader_grid">
	      <div class="loader_box loader_box1"></div>
	      <div class="loader_box loader_box2"></div>
	      <div class="loader_box loader_box3"></div>
	      <div class="loader_box loader_box4"></div>
	      <div class="loader_box loader_box5"></div>
	      <div class="loader_box loader_box6"></div>
	      <div class="loader_box loader_box7"></div>
	      <div class="loader_box loader_box8"></div>
	      <div class="loader_box loader_box9"></div>
	    </div>
	</div>
<!-- END LOADER --> 
	<div class="header" style="background-image: linear-gradient(<?php echo $savedAdminColors[$savedMainDashboardlayout['main_dashboard_color3']]['code'] ?>, <?php echo $savedAdminColors[$savedMainDashboardlayout['main_dashboard_color4']]['code'] ?>); " >
		<table border="0">
			<tr>
				<td class="header-logo" style="padding-right:15px">
					<img src="<?=ROOT.$compinfo['logofile'].'?'.time()?>" />
				</td>
				<td class="header-client">
					<? if(isset($_SESSION['rego']['cid'])){ ?>
							<span  style="font-family:<?php echo $savedMainDashboardlayout['main_dashboard_main_header_font'] ?>;color:<?php echo $savedAdminColors[$savedMainDashboardlayout['main_dashboard_main_header_font_color']]['code'] ?>"> <?=$compinfo[$lang.'_compname']?>&nbsp;-&nbsp;<?=strtoupper($rego)?> </span>
					<? } ?>
				</td>
				<td style="width:90%; padding-left:20px;"><button style="border-color:<?php echo $savedAdminColors[$savedMainDashboardlayout['main_dashboard_main_header_font_color']]['code'].'!important' ?>" onmouseover="$('.mnSumoSelect').addClass('open');"onmouseout="$('.mnSumoSelect').removeClass('open');" class="btn btn-outline-success btn-xs"><span style="font-family:<?php echo $savedMainDashboardlayout['main_dashboard_main_header_font'] ?>;color:<?php echo $savedAdminColors[$savedMainDashboardlayout['main_dashboard_main_header_font_color']]['code'] ?>"> Selections</span></button></td>
				<td class="header-date">
					<span style="font-family:<?php echo $savedMainDashboardlayout['main_dashboard_main_header_font'] ?>;color:<?php echo $savedAdminColors[$savedMainDashboardlayout['main_dashboard_main_header_font_color']]['code'] ?>"><?=$_SESSION['rego']['cur_date']?></span>
				</td>
				<? if($lang=='en'){ ?>
				<td>
					<a data-lng="th" class="langbutton <? if($lang=='th'){echo 'activ';} ?>"><img src="<?=ROOT?>images/flag_th.png"></a>
				</td>
				<? }else{ ?>
				<td>
					<a data-lng="en" class="langbutton <? if($lang=='en'){echo 'activ';} ?>"><img src="<?=ROOT?>images/flag_en.png"></a>
				</td>
				<? } ?>
				<td style="padding:0 10px">
					<? if(!isset($_SESSION['RGadmin']['id'])){ ?>
						<button class="btn btn-logout logout"><i class="fa fa-power-off"></i></button>
					<? } ?>
				</td>
			</tr>
		</table>
	</div>
<style type="text/css">
::-webkit-scrollbar {
    width: 6px;
    height: 15px;
}
</style>