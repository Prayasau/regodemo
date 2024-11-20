<?php
	
	$history_lock = getHistoryLock();
	$hisLink = 'index.php?mn=441&type=all';
	if($history_lock == 1){
		$hisLink = 'index.php?mn=440&type=add';
	}
	//var_dump($history_lock);


	$last = $_SESSION['rego']['cid'];
	$ref  = $_SESSION['rego']['ref'];
	
	$sql = "SELECT * FROM ".$last."_users WHERE ref = '".$ref."'";
	if($res = $dbc->query($sql)){
		if($res->num_rows > 0){
			$com_users = $res->fetch_assoc();
		}
	}

	$nouser = '';
	if(isset($com_users)){

		$tmp = unserialize($com_users['permissions']);
		if(!$tmp){$tmp = array();}

		$PermissionArray['rego'] = $tmp;
	}else{

		$nouser = 'no-user';
	}


	if(!is_array($_SESSION['RGadmin']['access'])){
		$myaccess = $PermissionArray;
	}else{
		$myaccess = $_SESSION;
	}


	// echo '<pre>';
	// print_r($myaccess);
	// echo '</pre>';



?>
	<style type="text/css">::-webkit-scrollbar {width: 15px;height: 15px;}  /* Scroll Bar width*/

	</style>
	<div style="padding:0 0 0 20px" id="dump"></div>
	
	<div class="dash-left">
		
		<div class="dashbox <? if($myaccess['rego']['payroll_result']['view']){}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='index.php?mn=411';" <? if($myaccess['rego']['payroll_result']['view']){echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect1']]['code']."";}else{ echo "style=background:#d2cbcb";}?>>
				<i class="fa fa-list-ul"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Monthly Payroll Summary']?></p>
					</div>
				</div>						
				
			</div>
		</div>		
		
		<div class="dashbox <? if($myaccess['rego']['payroll_attendance']['view']){}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='index.php?mn=410';" <? if($myaccess['rego']['payroll_attendance']['view']){echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect2']]['code']."";}else{ echo "style=background:#d2cbcb";}?>>
				<i class="fa fa-history"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Payroll calculator']?></p>
					</div>
				</div>						
			</div>
		</div>

	

		<div class="dashbox <? if($myaccess['rego']['payroll_benefits']['view'] && $myaccess['rego']['standard'][$standard]['pr_benefits']){}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='index.php?mn=603';" <? if($myaccess['rego']['payroll_benefits']['view'] && $myaccess['rego']['standard'][$standard]['pr_benefits']){echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect3']]['code']."";}else{ echo "style=background:#d2cbcb";}?>>
				<i class="fa fa-cogs"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Benefits calculator']?></p>
					</div>
				</div>						
				
			</div>
		</div>
		<div class="dashbox <? if($myaccess['rego']['payroll_calculations']['view'] && $myaccess['rego']['standard'][$standard]['pr_individual']){}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='index.php?mn=610';"  <? if($myaccess['rego']['payroll_calculations']['view'] && $myaccess['rego']['standard'][$standard]['pr_individual']){echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect4']]['code']."";}else{ echo "style=background:#d2cbcb";}?>>
				<i class="fa fa-calculator"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>>Individual calculations<? //=$lng['Payroll settings']?></p>
					</div>
				</div>						
			</div>
		</div>

		
		<div class="dashbox <? if($myaccess['rego']['payroll_export']['view']){}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='index.php?mn=420';" <? if($myaccess['rego']['payroll_export']['view']){echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect5']]['code']."";}else{ echo "style=background:#d2cbcb";}?>>
				<i class="fa fa-file-excel-o"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Export center']?></p>
					</div>
				</div>						
			</div>
		</div>
				
		<div class="dashbox <? if($myaccess['rego']['payroll']['report']){}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='reports/index.php?mn=456';" <? if($myaccess['rego']['payroll']['report']){echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect6']]['code']."";}else{ echo "style=background:#d2cbcb";}?>>
				<i class="fa fa-file-pdf-o"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Report center']?></p>
					</div>
				</div>						
				
			</div>
		</div>

		<div class="dashbox <? if($myaccess['rego']['payroll']['archive']){}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='../archive/index.php';" <? if($myaccess['rego']['payroll']['archive']){echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect7']]['code']."";}else{ echo "style=background:#d2cbcb";}?>>
				<i class="fa fa-file-archive-o"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Archive center']?></p>
					</div>
				</div>						
			</div>
		</div>
		
		<div class="dashbox <? if($myaccess['rego']['payroll_historical']['view']){}else{echo 'disabled';} ?>" >
			<div class="inner" onclick="window.location.href='<?=$hisLink?>';" <? if($myaccess['rego']['payroll_historical']['view']){echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect8']]['code']."";}else{ echo "style=background:#d2cbcb";}?>>
				<i class="fa fa-history"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Historical data']?></p>
					</div>
				</div>						
			</div>
		</div>

		<div class="dashbox <? if($myaccess['rego']['payroll']['access']){}else{echo 'disabled';} ?>" >
			<div class="inner" onclick="window.location.href='index.php?mn=414';" <? if($myaccess['rego']['payroll_historical']['view']){echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect8']]['code']."";}else{ echo "style=background:#d2cbcb";}?>>
				<i class="fa fa-history"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Payroll log history']?></p>
					</div>
				</div>						
			</div>
		</div>
		
	</div>
	
	<div class="dash-right" style=" height:calc(100% - 25px); overflow-x:auto; margin-top:15px; padding-top:0">
				
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
	</div>

	<script type="text/javascript">

	$(document).ready(function() {
		
		
	});

</script>
						
