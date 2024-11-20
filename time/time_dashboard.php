<?php

	if(session_id()==''){session_start();} 


	ob_start();
	include('../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	include(DIR.'leave/functions.php');
	include(DIR.'time/functions.php');
	include(DIR.'files/arrays_'.$_SESSION['rego']['lang'].'.php');

	$logger = false;
	if(isset($_SESSION['rego']['cid']) && !empty($_SESSION['rego']['cid'])){
		if(isset($_SESSION['RGadmin'])){
			$logtime = 86000;
		}else{
			$logtime = (int)$sys_settings['logtime'];
		}
		//$logtime = 3;
		if(time() - $_SESSION['rego']['timestamp'] > $logtime) {
			$_SESSION['rego']['timestamp'] = 0;
			$logger = false; 
		}else{
			$_SESSION['rego']['timestamp'] = time();
			$logger = true;
			
			$periods = getPayrollPeriods($lang);
			$to_lock = $periods['to_lock'];
			$to_unlock = $periods['unlock'];
			$period = $periods['period'];
			//var_dump($periods);
			//$_SESSION['rego']['locked'] = $locked;
			
			$time_period = getTimePeriod();
		
		}
	}
		
		// echo $logtime ;

		// die();
	$time_settings = getTimeSettings();
	$scan_app = $time_settings['scan_system'];

	// echo $_GET['mn'];
	// die();
	
	if(!isset($_GET['mn']) && $scan_app != 'REGO'){
		$_GET['mn'] = 3;
	}
	if(!isset($_GET['mn']) && $scan_app == 'REGO'){
		$_GET['mn'] = 3;
	}
	
	// User type session 

	$userType = $_SESSION['rego']['type'];
	$teams = getAllTeams();

	// echo '<pre>';
	// print_r($teams);
	// echo '</pre>';
	// die();
	$apprTeams= $_SESSION['rego']['teams'];

	$aprTeam = explode(',', $apprTeams);


	$cid =$_SESSION['rego']['cid'];
	$username =$_SESSION['rego']['username'];

	$id=$cid.'_'.$username;
	$sql = "SELECT session_team FROM ".$cid."_user_permissions WHERE id = '".$id."'";

	if($res = $dbc->query($sql)){
		if($res->num_rows > 0){
			if($row = $res->fetch_assoc())
				{
					$sessionTeams = $row['session_team'];  // SELECTED TEAMS STORED IN SESSION 
						
				}
		}
	}

	$sesTeamArray = explode(',', $sessionTeams);

	/////////////////////////////// LOAD LAYOUT SETTINGS AND FUNCTIONS ////////////////////////////
	include("../admin/company_layout/common_layout_functions_system.php"); 
	/////////////////////////////// LOAD LAYOUT SETTINGS AND FUNCTIONS ////////////////////////////

	
?>

<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
		<meta name="robots" content="noindex, nofollow">
		<title><?=$www_title?></title>
		<link rel="icon" type="image/png" sizes="192x192" href="../assets/images/192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="../assets/images/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon-16x16.png">

		
		<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
	    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
	    <link rel="stylesheet" href="../assets/css/line-awesome.min.css">
	    <link rel="stylesheet" href="../assets/css/myStyle.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/navigation.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/bootstrap-datepicker.css?<?=time()?>" />
		<link rel="stylesheet" href="../assets/css/myBootstrap.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/basicTable.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/myForm.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/dataTables.bootstrap4.min.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/myDatatables.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/overhang.min.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/responsive.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/autocomplete.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/bootstrap-year-calendar.css?<?=time()?>">
		 <link rel="stylesheet" href="../assets/css/sumoselect.css?<?=time()?>">
		<!-- <link rel="stylesheet" href="../assets/css/sumoselect-menu.css<?=time()?>"> -->
		
		<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">-->
		
		<script src="../assets/js/jquery-3.2.1.min.js"></script>
		<script src="../assets/js/jquery-ui.min.js"></script>
	
	<script>
		var lang = <?=json_encode($lang)?>;
		var dtable_lang = <?=json_encode($dtable_lang)?>;
		var ROOT = <?=json_encode(ROOT)?>;
		var logtime = <?=json_encode($logtime)*1000?>;
	</script>

	<style type="text/css">
		.mnSumoSelect > .CaptionCont
		{
			background-color :<?php echo $savedAdminColors[$savedMainDashboardlayout['main_dashboard_color2']]['code']?>!important;
		}
	</style>

	<style type="text/css">
		<?php if($savedMainDashboardlayout['image_link'] != ''){ 
				if($_GET['mn'] == 7007){ ?>

					body ,html{

						 background: url('../images/admin_uploads/<?php echo $savedMainDashboardlayout['image_link'] ?>'); background-position:center;background-repeat: no-repeat;background-size: cover!important; 
					}

				<?php }else{ ?>

					body ,html{

						 background: #fff!important; 
					}
				<?php } ?>


	  <?php }else{ ?>

	  		body ,html{

				 background: #fff!important; 
			}


	  <?php } ?>


	</style>

</head>


<body>
		
	<? include(DIR.'include/main_header.php');?>
	
	<div class="topnav-custom">
		<div class="btn-group" <? echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['main_dashboard_color2']]['code']."";?>> 
			<a href="../index.php?mn=2" class="home"><i class="fa fa-home"></i></a>
		</div>
			
			
		
		<div class="btn-group" style="float:right;"> 
			<button data-toggle="dropdown" style="padding:0 8px; background:#000; cursor:default">
				 <img style="height:35px; width:35px; display:inline-block; border-radius:0px; margin:-3px 0 0 0; border:0px solid #666" src="<?=ROOT.$_SESSION['rego']['img']?>?<?=time()?>">
			</button>
		</div>
		
		<div class="btn-group" style="float:right;"> 
			<button class="dropdown-toggle" data-toggle="dropdown">
				<? if(isset($period[$_SESSION['rego']['cur_month']])){
					echo $period[$_SESSION['rego']['cur_month']];
				}else{
					echo $lng['Select period'];//end($period);
				}?>
			</button>
			<div class="dropdown-menu dropdown-menu-right">
				<? foreach($period as $k=>$v){ ?>
					<a class="dropdown-item selectMonth" data-id="<?=$k?>"><?=$v?></a>
				<? } ?>
			</div>
		</div>
	</div>
	
	<? if($logger){
			switch($_GET['mn']){
				case 3: 
					include('time_scan.php'); break;
				case 4: 
					include('time_attendance.php'); break;
				case 44: 
					include('monthly_attendance.php'); break;
				case 5: 
					include('monthly_planning.php');	break;
				case 6: 
					include('work_calendar.php'); break;
				case 7: 
					include('ot_requests.php'); 
					break;
				case 8: 
					include('employee_performance.php'); 
					break;
				case 9: 
					include('shiftplan_calendar.php'); 
					break;			
				case 10: 
					include('ping_location.php'); 
					break;			
		
			}
		}else{
			header('location: ../login.php');
		} ?>

	<? include('../include/modal_relog.php')?>


	<div style="padding:0 0 0 20px" id="dump"></div>
	
	<div class="dash-left">
		
		<!-- <div class="dashbox purple"> -->
		 <div class="dashbox <? if($_SESSION['rego']['time_import']['view']){}else{echo 'disabled';} ?>"> 
			<div class="inner" onclick="window.location.href='index.php?mn=3';" <? if($_SESSION['rego']['time_import']['view']){echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect1']]['code']."";}else{ echo "style=background:#d2cbcb";}?>>
				<i class="fa fa-list-ul"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Import timesheet']?></p>
					</div>
				</div>						
				
			</div>
		</div>		
		
		<!-- <div class="dashbox green"> -->
		<div class="dashbox <? if($_SESSION['rego']['time_attendance']['view']){}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='index.php?mn=4';" <? if($_SESSION['rego']['time_attendance']['view']){echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect2']]['code']."";}else{ echo "style=background:#d2cbcb";}?>>
				<i class="fa fa-history"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Time attendance']?></p>
					</div>
				</div>						
			</div>
		</div>

		<!-- <div class="dashbox orange"> -->
		<div class="dashbox <? if($_SESSION['rego']['time_monthly']['view']){}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='index.php?mn=44';" <? if($_SESSION['rego']['time_monthly']['view']){echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect3']]['code']."";}else{ echo "style=background:#d2cbcb";}?>>
				<i class="fa fa-file-text-o"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Monthly attendance']?></p>
					</div>
				</div>						
			</div>
		</div>

		<!-- <div class="dashbox teal"> -->
		<div class="dashbox <? if($_SESSION['rego']['time_planning']['view'] ){}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='index.php?mn=5';" <? if($_SESSION['rego']['time_planning']['view']){echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect4']]['code']."";}else{ echo "style=background:#d2cbcb";}?>>
				<i class="fa fa-cogs"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Monthly planning']?></p>
					</div>
				</div>						
				
			</div>
		</div>
		<!-- <div class="dashbox reds"> -->
		<div class="dashbox <? if($_SESSION['rego']['time_shift']['view']){}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='index.php?mn=7';" <? if($_SESSION['rego']['time_shift']['view']){echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect5']]['code']."";}else{ echo "style=background:#d2cbcb";}?>>
				<i class="fa fa-thumbs-up"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>>Additional Requests</p>
					</div>
				</div>						
			</div>
		</div>			

		<div class="dashbox <? if($_SESSION['rego']['time_shift']['view']){}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='index.php?mn=10';" <? if($_SESSION['rego']['time_shift']['view']){echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect6']]['code']."";}else{ echo "style=background:#d2cbcb";}?>>
				<i class="fa fa-map-marker"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>>Ping Location</p>
					</div>
				</div>						
			</div>
		</div>		
	</div>

	<div class="dash-right">
				
		<div class="notify_box">
			<h2 style="font-family:<?php echo $savedDefaultFonts[$savedMainDashboardlayout['main_font_settings_box']]?>;background:<?php echo $savedAdminColors[$savedMainDashboardlayout['maincolorSelect15']]['code'].'!important' ;?>"><i class="fa fa-bell"></i>&nbsp; <?=$lng['Non-approved incomplete scan']?></h2>
			<div class="inner">
				<span style="font-family:<?php echo $savedDefaultFonts[$savedMainDashboardlayout['main_font_settings_box_content']]?>;">
					<? 
						echo '<b></i>&nbsp;&nbsp;'.$lng['All mandatory System settings are set'].'</b><br>';
					?>
				</span>
			</div>
		</div>
				
		<div class="notify_box">
			<h2 style="font-family:<?php echo $savedDefaultFonts[$savedMainDashboardlayout['main_font_settings_box']]?>;background:<?php echo $savedAdminColors[$savedMainDashboardlayout['maincolorSelect15']]['code'].'!important' ;?>"><i class="fa fa-bell"></i>&nbsp; <?=$lng['Absent without notice']?></h2>
			<div class="inner">
				<span style="font-family:<?php echo $savedDefaultFonts[$savedMainDashboardlayout['main_font_settings_box_content']]?>;">
					<? 
						echo '<b></i>&nbsp;&nbsp;'.$lng['All mandatory System settings are set'].'</b><br>';
					?>
				</span>
			</div>
		</div>		
		<div class="notify_box">
			<h2 style="font-family:<?php echo $savedDefaultFonts[$savedMainDashboardlayout['main_font_settings_box']]?>;background:<?php echo $savedAdminColors[$savedMainDashboardlayout['maincolorSelect15']]['code'].'!important' ;?>"><i class="fa fa-bell"></i>&nbsp; <?=$lng['Pending leave requests']?></h2>
			<div class="inner">
				<span style="font-family:<?php echo $savedDefaultFonts[$savedMainDashboardlayout['main_font_settings_box_content']]?>;">
					<? 
						echo '<b></i>&nbsp;&nbsp;'.$lng['All mandatory System settings are set'].'</b><br>';
					?>
				</span>
			</div>
		</div>		
		<div class="notify_box">
			<h2 style="font-family:<?php echo $savedDefaultFonts[$savedMainDashboardlayout['main_font_settings_box']]?>;background:<?php echo $savedAdminColors[$savedMainDashboardlayout['maincolorSelect15']]['code'].'!important' ;?>"><i class="fa fa-bell"></i>&nbsp; <?=$lng['Total number of pending registrations']?></h2>
			<div class="inner">
				<span style="font-family:<?php echo $savedDefaultFonts[$savedMainDashboardlayout['main_font_settings_box_content']]?>;">
					<? 
						echo '<b></i>&nbsp;&nbsp;'.$lng['All mandatory System settings are set'].'</b><br>';
					?>
				</span>
			</div>
		</div>		
		<div class="notify_box">
			<h2 style="font-family:<?php echo $savedDefaultFonts[$savedMainDashboardlayout['main_font_settings_box']]?>;background:<?php echo $savedAdminColors[$savedMainDashboardlayout['maincolorSelect15']]['code'].'!important' ;?>"><i class="fa fa-bell"></i>&nbsp; <?=$lng['Total number of unlocked registrations']?></h2>
			<div class="inner">
				<span style="font-family:<?php echo $savedDefaultFonts[$savedMainDashboardlayout['main_font_settings_box_content']]?>;">
					<? 
						echo '<b></i>&nbsp;&nbsp;'.$lng['All mandatory System settings are set'].'</b><br>';
					?>
				</span>
			</div>
		</div>
	</div>
	
	<script src="../assets/js/popper.min.js"></script>
	<script src="../assets/js/bootstrap.min.js"></script>
	<script src="../assets/js/jquery.dataTables.min.js"></script>
	<script src="../assets/js/dataTables.bootstrap4.min.js"></script>
	<script src="../assets/js/bootstrap-datepicker.min.js"></script>
	<script src="../assets/js/bootstrap-confirmation.js"></script>
	<script src="../assets/js/jquery.numberfield.js"></script>	
	<script src="../assets/js/jquery.mask.js"></script>	
	<script src="../assets/js/overhang.min.js?<?=time()?>"></script>
	<script src="../assets/js/rego.js?<?=time()?>"></script>
	<script src="../assets/js/jquery.sumoselect.js"></script>
	<script src="../assets/js/jquery.sumoselect-menu.js"></script>
	<script src="../assets/js/moment.min.js"></script>
	<script src="../assets/js/moment-duration-format.min.js"></script>

	<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
	<!--<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>-->	
	
	<? include('../include/common_script.php')?>

	<? if(!empty($helpfile) && $_GET['mn'] != 2 && $_GET['mn'] != 600){ ?>		
		<div class="openHelp"><i class="fa fa-question-circle fa-lg"></i></div>
		<div id="help">
			<div class="closeHelp"><i class="fa fa-arrow-circle-right"></i></div>
			<div class="innerHelp">
				<?=$helpfile?>
			</div>
		</div>
	<? } ?>


	
</body>
</html>


	





