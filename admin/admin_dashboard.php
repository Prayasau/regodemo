<?php
 	
	$tickets = getSupportTickets();
	$checkHolidays = '';
	if(date('n') == 12){
		if(!checkHolidaysDB((date('Y')+1))){
			$checkHolidays = '<b><a href="index.php?mn=54">Add holidays for the year '.(date('Y')+1).'</a></b>';
		}
	}else{
		if(!checkHolidaysDB((date('Y')))){
			$checkHolidays = '<b><a href="index.php?mn=54">Add holidays for the year '.(date('Y')).'</a></b>';
		}
	}
	//var_dump($checkHolidays);
	$new_tickets = $tickets['new'];
	$open_tickets = $tickets['open'];


	
?>
	<style type="text/css">
		

		body, html {
			/*background: #fff;*/
			 /*background: url('../../images/admin_uploads/<?php echo $savedAdminDashboardlayout['image_link'] ?>'); background-repeat: no-repeat;background-size: 100%!important; */
		}
		
	</style>
			<div class="dash-left">
					
				<div class="dashbox <? if($_SESSION['RGadmin']['access']['customer']['access'] == 1){}else{echo 'disabled';}?>" >
					<div class="inner" onclick="window.location.href='index.php?mn=3008';" <? if($_SESSION['RGadmin']['access']['customer']['access'] == 1){echo "style=background:".$savedAdminColors[$savedAdminDashboardlayout['colorSelect1']]['code']."";}else{ echo "style=background:fff";}?>>
						<i class="fa fa-users"></i>
						<div class="parent">
							<div class="child">
								<p <?php echo "style=font-family:".$savedDefaultFonts[$savedAdminDashboardlayout['font_settings']]."!important;color:".$savedAdminColors[$savedAdminDashboardlayout['fontColor']]['code']."!important"; ?>><?=$lng['Customers']?></p>
							</div>
						</div>
					</div>
				</div>

				<div class="dashbox <? if($_SESSION['RGadmin']['access']['users_tab']['access'] == 1){}else{echo 'disabled';}?>">
					<div class="inner" onclick="window.location.href='index.php?mn=3007';" <? if($_SESSION['RGadmin']['access']['users_tab']['access'] == 1){echo "style=background:".$savedAdminColors[$savedAdminDashboardlayout['colorSelect2']]['code']."";}else{ echo "style=background:fff";}?>>
						<i class="fa fa-user"></i>
						<div class="parent">
							<div class="child">
								<p  <?php echo "style=font-family:".$savedDefaultFonts[$savedAdminDashboardlayout['font_settings']]."!important;color:".$savedAdminColors[$savedAdminDashboardlayout['fontColor']]['code']."!important"; ?>><?=$lng['Users']?></p>
							</div>
						</div>
					</div>
				</div>

				<div class="dashbox <? if($_SESSION['RGadmin']['access']['platform_settings']['access'] == 1){}else{echo 'disabled';}?>">
					<div class="inner" onclick="window.location.href='index.php?mn=3003';" <? if($_SESSION['RGadmin']['access']['platform_settings']['access'] == 1){echo "style=background:".$savedAdminColors[$savedAdminDashboardlayout['colorSelect3']]['code']."";}else{ echo "style=background:fff";}?>>
					<i class="fa fa-cogs"></i>
						<div class="parent">
							<div class="child">
								<p  <?php echo "style=font-family:".$savedDefaultFonts[$savedAdminDashboardlayout['font_settings']]."!important;color:".$savedAdminColors[$savedAdminDashboardlayout['fontColor']]['code']."!important"; ?>><?=$lng['Platform Settings']?></p>
							</div>
						</div>
					</div>
				</div>				

				<div class="dashbox <? if($_SESSION['RGadmin']['access']['comp_settings']['access'] == 1){}else{echo 'disabled';}?> ">
					<div class="inner" onclick="window.location.href='index.php?mn=3002';" <? if($_SESSION['RGadmin']['access']['comp_settings']['access'] == 1){echo "style=background:".$savedAdminColors[$savedAdminDashboardlayout['colorSelect4']]['code']."";}else{ echo "style=background:fff";}?>>
					<i class="fa fa-cog"></i>
						<div class="parent">
							<div class="child">
								<p  <?php echo "style=font-family:".$savedDefaultFonts[$savedAdminDashboardlayout['font_settings']]."!important;color:".$savedAdminColors[$savedAdminDashboardlayout['fontColor']]['code']."!important"; ?>><?=$lng['Company settings']?></p>
							</div>
						</div>
					</div>
				</div>					
				<div class="dashbox <? if($_SESSION['RGadmin']['access']['software_models']['access'] == 1){}else{echo 'disabled';}?>">
					<div class="inner" onclick="window.location.href='index.php?mn=3006';" <? if($_SESSION['RGadmin']['access']['software_models']['access'] == 1){echo "style=background:".$savedAdminColors[$savedAdminDashboardlayout['colorSelect5']]['code']."";}else{ echo "style=background:fff";}?>>
					<i class="fa fa-money"></i>
						<div class="parent">
							<div class="child">
								<p  <?php echo "style=font-family:".$savedDefaultFonts[$savedAdminDashboardlayout['font_settings']]."!important;color:".$savedAdminColors[$savedAdminDashboardlayout['fontColor']]['code']."!important"; ?>><?=$lng['Software Models']?></p>
							</div>
						</div>
					</div>
				</div>				

				<div class="dashbox <? if($_SESSION['RGadmin']['access']['support_help_files']['access'] == 1){}else{echo 'disabled';}?>">
					<div class="inner" onclick="window.location.href='index.php?mn=3001';" <? if($_SESSION['RGadmin']['access']['support_help_files']['access'] == 1){echo "style=background:".$savedAdminColors[$savedAdminDashboardlayout['colorSelect6']]['code']."";}else{ echo "style=background:fff";}?>>
					<i class="fa fa-question-circle-o"></i>
						<div class="parent">
							<div class="child">
								<p  <?php echo "style=font-family:".$savedDefaultFonts[$savedAdminDashboardlayout['font_settings']]."!important;color:".$savedAdminColors[$savedAdminDashboardlayout['fontColor']]['code']."!important"; ?>><?=$lng['Supporting Files']?></p>
							</div>
						</div>
					</div>
				</div>

	
				<div class="dashbox <? if($_SESSION['RGadmin']['access']['support']['access'] == 1){}else{echo 'disabled';}?>">
					<div class="inner" onclick="window.location.href='index.php?mn=90';" <? if($_SESSION['RGadmin']['access']['support']['access'] == 1){echo "style=background:".$savedAdminColors[$savedAdminDashboardlayout['colorSelect7']]['code']."";}else{ echo "style=background:fff";}?>>
					<i class="fa fa-life-ring"></i>
						<div class="parent">
							<div class="child">
								<p  <?php echo "style=font-family:".$savedDefaultFonts[$savedAdminDashboardlayout['font_settings']]."!important;color:".$savedAdminColors[$savedAdminDashboardlayout['fontColor']]['code']."!important"; ?>><?=$lng['Support desk']?></p>
							</div>
						</div>
					</div>
				</div>
				<div class="dashbox <? if($_SESSION['RGadmin']['access']['privacy']['access'] == 1){}else{echo 'disabled';}?>">
					<div class="inner" onclick="window.location.href='index.php?mn=70';" <? if($_SESSION['RGadmin']['access']['privacy']['access'] == 1){echo "style=background:".$savedAdminColors[$savedAdminDashboardlayout['colorSelec8']]['code']."";}else{ echo "style=background:fff";}?>>
					<i class="fa fa-database"></i>
						<div class="parent">
							<div class="child">
								<p  <?php echo "style=font-family:".$savedDefaultFonts[$savedAdminDashboardlayout['font_settings']]."!important;color:".$savedAdminColors[$savedAdminDashboardlayout['fontColor']]['code']."!important"; ?>><?=$lng['Log data']?></p>
							</div>
						</div>
					</div>
				</div>
				<div class="dashbox <? if($_SESSION['RGadmin']['access']['legal_conditions']['access'] == 1){}else{echo 'disabled';}?>">
					<div class="inner" onclick="window.location.href='index.php?mn=3005';" <? if($_SESSION['RGadmin']['access']['legal_conditions']['access'] == 1){echo "style=background:".$savedAdminColors[$savedAdminDashboardlayout['colorSelect9']]['code']."";}else{ echo "style=background:fff";}?>>
						<i class="fa fa-file-text-o"></i>
						<div class="parent">
							<div class="child">
								<p  <?php echo "style=font-family:".$savedDefaultFonts[$savedAdminDashboardlayout['font_settings']]."!important;color:".$savedAdminColors[$savedAdminDashboardlayout['fontColor']]['code']."!important"; ?>><?=$lng['Legal Conditions']?></p>
							</div>
						</div>
					</div>
				</div>				
			</div>
			
			<div class="dash-right">
		
				<div class="notify_box">
					<h2 <?php echo "style=background:".$savedAdminColors[$savedAdminDashboardlayout['colorSelect15']]['code']."!important"; ?>><i class="fa fa-bell"></i>&nbsp; <span <?php echo "style=font-family:".$savedDefaultFonts[$savedAdminDashboardlayout['font_settings_box']]."!important"; ?>><?=$lng['Notification box']?> </span></h2>
					<div class="inner">
						<span <?php echo "style=font-family:".$savedDefaultFonts[$savedAdminDashboardlayout['font_settings_box_content']]."!important"; ?>> <?=$lng['New support tickets']?> : <b><?=$new_tickets?></b><br>
						<?=$lng['Open support tickets']?> : <b><?=$open_tickets?></b><br>
						<?=$checkHolidays?> </span>
	
					</div>
				</div>
		
			</div>
						














