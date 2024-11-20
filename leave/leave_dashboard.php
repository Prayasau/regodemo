
	<div style="padding:0 0 0 20px" id="dump"></div>
	
	<div class="dash-left">
		
		<div class="dashbox <? if($_SESSION['rego']['leave_application']['view']){}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='index.php?mn=201';" <? if($_SESSION['rego']['leave_application']['view']){echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect1']]['code']."";}else{ echo "style=background:#d2cbcb";}?>>
				<i class="fa fa-plane"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Leave application']?></p>
					</div>
				</div>						
				
			</div>
		</div>		
		
		<div class="dashbox   <? if($_SESSION['rego']['leave_approve']['view']){}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='index.php?mn=203';" <? if($_SESSION['rego']['leave_approve']['view']){echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect2']]['code']."";}else{ echo "style=background:#d2cbcb";}?>>
				<i class="fa fa-thumbs-up"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Approve leave period']?></p>
					</div>
				</div>						
			</div>
		</div>

		<div class="dashbox <? if($_SESSION['rego']['leave_calendar']['view']){}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='index.php?mn=202';" <? if($_SESSION['rego']['leave_calendar']['view']){echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect3']]['code']."";}else{ echo "style=background:#d2cbcb";}?>>
				<i class="fa fa-calendar"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Leave calendar']?></p>
					</div>
				</div>						
				
			</div>
		</div>

		<div class="dashbox  <? if($_SESSION['rego']['leave']['report']){}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='index.php?mn=205';" <? if($_SESSION['rego']['leave']['report']){echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect4']]['code']."";}else{ echo "style=background:#d2cbcb";}?>>
				<i class="fa fa-file-pdf-o"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Report center']?></p>
					</div>
				</div>						
				
			</div>
		</div>

		<div class="dashbox  disabled <? //if($_SESSION['rego']['leave']['archive']){echo 'brown';}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='index.php?mn=205';"  style="background:#d2cbcb;">
				<i class="fa fa-file-archive-o"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Archive center']?></p>
					</div>
				</div>						
			</div>
		</div>
		
		
	</div>
	
	<div class="dash-right">
		<div class="notify_box">
			<h2 style="font-family:<?php echo $savedDefaultFonts[$savedMainDashboardlayout['main_font_settings_box']]?>;background:<?php echo $savedAdminColors[$savedMainDashboardlayout['maincolorSelect15']]['code'].'!important' ;?>"><i class="fa fa-bell"></i>&nbsp; <?=$lng['Complete setup tasks']?></h2>
			<div class="inner">
				<span style="font-family:<?php echo $savedDefaultFonts[$savedMainDashboardlayout['main_font_settings_box_content']]?>;">
				<? //if($checkSetup){
					//echo $checkSetup;
				//}else{
					echo '<b><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;'.$lng['All mandatory System settings are set'].'</b><br>';
				//}?>
				</span>

			</div>
		</div>
	</div>

	<script type="text/javascript">

	$(document).ready(function() {
		
		
	});

</script>
						
