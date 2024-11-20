<?php
	
	$history_lock = getHistoryLock();
	$hisLink = 'index.php?mn=441&type=all';
	if($history_lock == 1){
		$hisLink = 'index.php?mn=440&type=add';
	}
	//var_dump($checkSetup); exit;

	// foreach ($teams as $key => $value) {
	// 	$Teamimp[] = $key;
	// }

	// echo $ImplodeTeam = implode(',', $Teamimp);

	// echo '<pre>';
	// print_r($teams);
	// echo '</pre>';
	// echo '===========================';
	// echo '<pre>';
	// print_r($_SESSION);
	// echo '</pre>';
	//die();

	$last = $_SESSION['rego']['cid'];
	$ref  = $_SESSION['rego']['ref'];
	$customers  = $_SESSION['rego']['customers'];

	$sql = "SELECT * FROM ".$last."_users WHERE ref = '".$ref."'";
	if($res = $dbc->query($sql)){
		if($res->num_rows > 0){
			$com_users = $res->fetch_assoc();
		}
	}

	$COMPANYLEVEL = 0;
	$nouser = '';
	if(isset($com_users)){

		$COMPANYLEVEL = $com_users['status'];
		$tmp = unserialize($com_users['permissions']);
		if(!$tmp){
			
			//check again if sys access or not...
			$sqlaa = "SELECT * FROM ".$last."_users WHERE ref = '".$ref."' AND type = 'sys' ";
			if($resaa = $dbc->query($sqlaa)){
				if($resaa->num_rows > 0){
					$com_usersa = $resaa->fetch_assoc();
				}
			}

			if(isset($com_usersa)){
				$tmp = unserialize($com_usersa['permissions']);
				$PermissionArray['rego'] = $tmp;
					
			}else{
				$PermissionArray['rego'] = array();	
			}

		}else{
			$PermissionArray['rego'] = $tmp;
		}

	}else{

		$nouser = 'no-user';
		$COMPANYLEVEL = 0;
	}


	if(!is_array($_SESSION['RGadmin']['access'])){
		$myaccess = $PermissionArray;
	}else{
		$myaccess = $_SESSION;
	}


	if (strpos($_SESSION['rego']['com_access'], $cid) !== false) {
		$showCom = 'orange';
	}else{
		$showCom = 'disabled';
	}

	if (strpos($_SESSION['rego']['emp_access'], $cid) !== false) {
		$showEMP = 'green';
	}else{
		$showEMP = 'disabled';
	}


	// echo '<pre>';
	// print_r($myaccess);
	// echo '</pre>';
?>

	<div style="padding:0 0 0 20px" id="dump"></div>

		<?php if($COMPANYLEVEL == 0 && (!is_array($_SESSION['RGadmin']['access']))){ 

			echo '<br><br><br><div class="msg_nopermit">You have no permission to view this company<br>User is suspended for this company</div>'; 
		}else{ ?>

			<div class="dash-left">

			<?php if (strpos($_SESSION['rego']['sys_access'], $cid) !== false || is_array($_SESSION['RGadmin']['access'])) { ?>
				
				<div class="dashbox <? if($myaccess['rego']['employee']['access']){}else{echo 'disabled';} ?>">
					<div class="inner" onclick="window.location.href='employees/index.php?mn=100'" <? if($myaccess['rego']['employee']['access']){echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect1']]['code']."";}else{ echo "style=background:#d2cbcb";}?>>
						<i class="fa fa-users"></i>
						<div class="parent">
							<div class="child">
								<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?> ><?=$lng['Employee Module']?></p>
							</div>
						</div>						
					</div>
				</div>

				<?php if(isset($myaccess['RGadmin'])) {?>

						<div class="dashbox <? if($myaccess['rego']['standard'][$standard]['leave']){}else{echo 'disabled';} ?>">

				<?php } else{ ?>

						<div class="dashbox <? if($myaccess['rego']['leave']['access'] ){}else{echo 'disabled';} ?>">

				<?php } ?>


				
					<div class="inner" onclick="window.location.href='leave/index.php?mn=200';" <? if($myaccess['rego']['leave']['access']){echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect2']]['code']."";}else{ echo "style=background:#d2cbcb";}?>>
						<i class="fa fa-plane"></i>
						<div class="parent">
							<div class="child">
								<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Leave module']?></p>
							</div>
						</div>						
					</div>
				</div>
				
				<!--  if admin -->


				<?php if(isset($myaccess['RGadmin'])) {?>

						<div class="dashbox <? if( $myaccess['rego']['standard'][$standard]['time']){}else{echo 'disabled';} ?>">

				<?php } else{ ?>

						<div class="dashbox <? if($myaccess['rego']['time']['access'] ){}else{echo 'disabled';} ?>">

				<?php } ?>


					<div class="inner" onclick="window.location.href='time/time_dashboard.php?mn=7007';" <? if($myaccess['rego']['time']['access']){echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect3']]['code']."";}else{ echo "style=background:#d2cbcb";}?>>
						<i class="fa fa-clock-o"></i>
						<div class="parent">
							<div class="child">
								<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Time module']?></p>
							</div>
						</div>						
					</div>
				</div>
				
				<div class="dashbox <? if($myaccess['rego']['payroll']['access']){}else{echo 'disabled';} ?>">
					<div class="inner" onclick="window.location.href='payroll/index.php?mn=400';" <? if($myaccess['rego']['payroll']['access']){echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect4']]['code']."";}else{ echo "style=background:#d2cbcb";}?>>
						<i class="fa fa-money"></i>
						<div class="parent">
							<div class="child">
								<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Payroll module']?></p>
							</div>
						</div>						
					</div>
				</div>
				<div class="dashbox <? if($myaccess['rego']['expences']['access'] && $myaccess['rego']['standard'][$standard]['expenses']){}else{echo 'disabled';} ?>">
					<div class="inner" onclick="window.location.href='payroll/index.php?mn=411';" <? if($myaccess['rego']['expences']['access']){echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect5']]['code']."";}else{ echo "style=background:#d2cbcb";}?>>
						<i class="fa fa-balance-scale"></i>
						<div class="parent">
							<div class="child">
								<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Benefits & Expences']?></p>
							</div>
						</div>						
						
					</div>
				</div>
				<!-- <div class="dashbox <? if($myaccess['rego']['project']['access'] && $myaccess['rego']['standard'][$standard]['projects']){echo 'brown';}else{echo 'disabled';} ?>">
					<div class="inner" onclick="window.location.href='approve/index.php?mn=20';">
						<i class="fa fa-th-large"></i>
						<div class="parent">
							<div class="child">
								<p><?=$lng['Projects']?></p>
							</div>
						</div>						
					</div>
				</div> -->

				<div class="dashbox <? if($myaccess['rego']['comm_center']['access'] || $_SESSION['RGadmin']['access']['comm_center']['access']){}else{echo 'disabled';} ?>">
					<div class="inner" onclick="window.location.href='commcenter/index.php?mn=801';" <? if($myaccess['rego']['comm_center']['access'] || $_SESSION['RGadmin']['access']['comm_center']['access']){echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect6']]['code']."";}else{ echo "style=background:#d2cbcb";}?>>
						<i class="fa fa-comments"></i>
						<div class="parent">
							<div class="child">
								<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Communication center']?></p>
							</div>
						</div>						
					</div>
				</div>


				<div class="dashbox <? if($myaccess['rego']['support']['access']){}else{echo 'disabled';} ?>">
					<div class="inner" onclick="window.location.href='support/index.php?mn=705';" <? if($myaccess['rego']['support']['access']){echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect7']]['code']."";}else{ echo "style=background:#d2cbcb";}?>>
						<i class="fa fa-question-circle"></i>
						<div class="parent">
							<div class="child">
								<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Support desk']?></p>
							</div>
						</div>						
					</div>
				</div>
				<div class="dashbox">
					<div class="inner" onclick="window.location.href='index.php?mn=4';" <? echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect8']]['code']."";?>>
						<i class="fa fa-file-text-o"></i>
						<div class="parent">
							<div class="child">
								<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Terms & Conditions']?></p>
							</div>
						</div>						
					</div>
				</div>
				<div class="dashbox purple">
					<div class="inner" onclick="window.location.href='index.php?mn=5';" <? echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect9']]['code']."";?>>
						<i class="fa fa-file-text-o"></i>
						<div class="parent">
							<div class="child">
								<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Privacy policy']?></p>
							</div>
						</div>						
					</div>
				</div>
				<div class="dashbox <? if($myaccess['rego']['settings']['access']){}else{echo 'disabled';} ?>">
					<div class="inner" onclick="window.location.href='settings/index.php?mn=600';" <? if($myaccess['rego']['settings']['access']){echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect10']]['code']."";}else{ echo "style=background:#d2cbcb";}?>>
						<i class="fa fa-cogs"></i>
						<div class="parent">
							<div class="child">
								<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Settings']?></p>
							</div>
						</div>						
					</div>
				</div>

			<?php }  ?>

			<?php if (strpos($_SESSION['rego']['com_access'], $cid) !== false) { ?>

				<div class="dashbox orange">
					<div class="inner" onclick="#">
						<i class="fa fa-cogs"></i>
						<div class="parent">
							<div class="child">
								<p><?=$lng['Manage Activities']?></p>
							</div>
						</div>						
					</div>
				</div>

			<?php } ?>

			<?php if (strpos($_SESSION['rego']['emp_access'], $cid) !== false) { ?>

				<div class="dashbox <?php echo $showEMP;?>">
					<div class="inner" onclick="window.location.href='my_account/index.php?mn=2';">
						<i class="fa fa-id-card-o"></i>
						<div class="parent">
							<div class="child">
								<p>Personal data</p>
							</div>
						</div>
					</div>
				</div>
				
			<?php } ?>
			
			</div>

		<?php if($typecchk != 'emp'){ ?>	
			
			<div class="dash-right" style=" height:calc(100% - 25px); overflow-x:auto; margin-top:15px; padding-top:0">
						<div class="notify_box">
							<h2 style="font-family:<?php echo $savedDefaultFonts[$savedMainDashboardlayout['main_font_settings_box']]?>;background:<?php echo $savedAdminColors[$savedMainDashboardlayout['maincolorSelect15']]['code'].'!important' ;?>"><i class="fa fa-bell"></i>&nbsp; <?=$lng['Warnings / Expiry dates']?></h2>

							<div class="inner">
								<span style="font-family:<?php echo $savedDefaultFonts[$savedMainDashboardlayout['main_font_settings_box_content']]?>;">
									<? if(checkExpiryDates()){
										echo checkExpiryDates();
									}else{
										echo '<b><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;'.$lng['No warnings or expiry dates'].'</b>';
									}?>
								</span>
							</div> 
						</div>

						<? if($myaccess['rego']['comm_center']['access'] || $_SESSION['RGadmin']['access']['comm_center']['access']){ ?>
							<div class="notify_box">
								<h2 style="font-family:<?php echo $savedDefaultFonts[$savedMainDashboardlayout['main_font_settings_box']]?>;background:<?php echo $savedAdminColors[$savedMainDashboardlayout['maincolorSelect15']]['code'].'!important' ;?>"><i class="fa fa-bell"></i>&nbsp; <?=$lng['Communication center']?></h2>
								<div class="inner">

									 <span style="font-family:<?php echo $savedDefaultFonts[$savedMainDashboardlayout['main_font_settings_box_content']]?>;">
										<? if(checkAnnouncement()){
											echo checkAnnouncement();
										}else{
											echo '<b><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;'.$lng['No announcement found'].'</b>';
										} ?>
									</span> 
								</div>
							</div>
						<? } ?>
						
						<div class="notify_box">
							<h2 style="font-family:<?php echo $savedDefaultFonts[$savedMainDashboardlayout['main_font_settings_box']]?>;background:<?php echo $savedAdminColors[$savedMainDashboardlayout['maincolorSelect15']]['code'].'!important' ;?>"><i class="fa fa-bell"></i>&nbsp; <?=$lng['Employees to complete for payroll']?></h2>
							<div class="inner">
								 <span style="font-family:<?php echo $savedDefaultFonts[$savedMainDashboardlayout['main_font_settings_box_content']]?>;">
									<? if(checkEmployeesForPayroll($cid)){
										echo checkEmployeesForPayroll($cid);
									}else{
										echo '<b><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;'.$lng['All employees are set for Payroll'].'</b>';
									}?>
								</span> 
							</div>
						</div>
						
						<div class="notify_box">
							<h2 style="font-family:<?php echo $savedDefaultFonts[$savedMainDashboardlayout['main_font_settings_box']]?>;background:<?php echo $savedAdminColors[$savedMainDashboardlayout['maincolorSelect15']]['code'].'!important' ;?>"><i class="fa fa-bell"></i>&nbsp; <?=$lng['Complete setup tasks']?></h2>
							<div class="inner">
								 <span style="font-family:<?php echo $savedDefaultFonts[$savedMainDashboardlayout['main_font_settings_box_content']]?>;">
									<? if($checkSetup){
										echo $checkSetup;
									}else{
										echo '<b><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;'.$lng['All mandatory System settings are set'].'</b><br>';
									}?>
								</span> 
							</div>
						</div>
						
						<? if($history_lock == 0){ ?>	
						<div class="notify_box">
							<h2 style="font-family:<?php echo $savedDefaultFonts[$savedMainDashboardlayout['main_font_settings_box']]?>;background:<?php echo $savedAdminColors[$savedMainDashboardlayout['maincolorSelect15']]['code'].'!important' ;?>"><i class="fa fa-bell"></i>&nbsp; <?=$lng['Historical data employees']?></h2>
							<div class="inner" style="padding:8px 15px">
			 					<span style="font-family:<?php echo $savedDefaultFonts[$savedMainDashboardlayout['main_font_settings_box_content']]?>;">
									<? if($lang == 'en'){?>
										<p style="margin:0 0 3px">We have noticed that you did not import your data of previous months yet. Please be aware that some tax deductions will not be calculated correctly.  Please use the historical data module to upload your data of previous months. Do not hesitate to contact us to help you upload the data.</p>
										<p>If you don't need this feature you can hide this window.</p>
									<? }else{ ?>
										<p style="margin:0 0 3px">เราสังเกตเห็นว่าคุณยังไม่ได้นำเข้าข้อมูลในเดือนก่อนหน้า โปรดทราบว่าการคำนวณภาษีบางส่วนจะไม่ถูกคำนวณอย่างถูกต้อง  โปรดใช้โมดูลข้อมูลประวัติเพื่ออัปโหลดข้อมูลของคุณในเดือนก่อนหน้า อย่าลังเลที่จะติดต่อเราเพื่อช่วยคุณอัปโหลดข้อมูล</p>
										<p>If you don't need this feature you can hide this window.</p>
									<? } ?>
									
									<button id="hideHistoricData" type="button" class="btn btn-primary btn-fl"><i class="fa fa-times"></i>&nbsp; <?=$lng['Hide window']?></button>
									
									<button onClick="$('#modalContactForm').modal('toggle')" type="button" class="btn btn-primary btn-fr"><i class="fa fa-envelope-o"></i>&nbsp; <?=$lng['Contact us']?></button>
									
									<div style="clear:both"></div>
								</span>
							</div>
						</div>
						<? } ?>
	

			</div>
			
		<?php } ?>

	<?php } ?>
