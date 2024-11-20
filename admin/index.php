<?
	if(session_id()==''){session_start();}
	ob_start();
	include('files/admin_functions.php');
	include('dbconnect/db_connect.php');
	include(DIR.'files/arrays_'.$lang.'.php');
	

	$logtime = 3600;
	$logger = false;
	$comp_count = 0;
	$emp_count = 0;

	$active_emps = 0;
    $inactive_emps = 0;
	$exceeded = 0;

	if(isset($_SESSION['RGadmin']['id']) && !empty($_SESSION['RGadmin']['id'])){
		if(time() - $_SESSION['RGadmin']['timestamp'] > $logtime) {
			$_SESSION['RGadmin']['timestamp'] = 0;
			$logger = false; 
		}else{
			$_SESSION['RGadmin']['timestamp'] = time();
			$logger = true;
		}
		$customers = getCustomers();
		$cid = '';
		//if(isset($_SESSION['SDadmin'])){$cid = strtolower($_SESSION['RGadmin']);}
		if(!isset($_SESSION['RGadmin']['cur_year'])){$_SESSION['RGadmin']['cur_year'] = date('Y');}
		//if(!isset($_SESSION['RGadmin']['cur_month'])){$_SESSION['RGadmin']['cur_month'] = date('m');}
		if(!isset($_SESSION['RGadmin']['year_en'])){$_SESSION['RGadmin']['year_en'] = date('Y');}
		if(!isset($_SESSION['RGadmin']['year_th'])){$_SESSION['RGadmin']['year_th'] = (date('Y')+543);}
		$_SESSION['RGadmin']['cur_date'] = date('l d F ').$_SESSION['RGadmin']['year_'.$lang];

		$all_customers = array();
		$sql = "SELECT * FROM rego_customers";
		if($res = $dba->query($sql)){
			while($row = $res->fetch_assoc()){
				$all_customers[$row['clientID']] = $row[$lang.'_compname'];
			}
		}
		/*$comp_count = count($all_customers);
		foreach($all_customers as $k=>$v){
			$dbc = @new mysqli($my_database,$my_username,$my_password);
			$dbc = @new mysqli($my_database,$my_username,$my_password,$prefix.$k);
			mysqli_set_charset($dbc,"utf8");
			if($res = $dbc->query("SELECT emp_id FROM ".$k."_employees")){
				$emp_count += $res->num_rows;
			}else{
				echo mysqli_error($dbc);
			}
		}*/
		//var_dump($emp_count);
		//var_dump($all_customers);
		//exit;	 

		//new code...
		$sql11 = "SELECT * FROM rego_company_settings";
        if($res11 = $dba->query($sql11)){
            $row11 = $res11->fetch_assoc();
            $max_employees = $row11['max_employees'];
        }

        $comp_count = count($all_customers);
        foreach($all_customers as $k=>$v){

            $dbc = @new mysqli($my_database,$my_username,$my_password);
            $dbc = @new mysqli($my_database,$my_username,$my_password,$prefix.$k);
            mysqli_set_charset($dbc,"utf8");
            if($res = $dbc->query("SELECT emp_status FROM ".$k."_employees")){

            	$emp_count += $res->num_rows;
                while($row = $res->fetch_assoc()){

                    if($row['emp_status'] == 1){
                        $active_emps ++;
                    }else{
                        $inactive_emps ++;
                    }
                }
            }else{
                echo mysqli_error($dbc);
            }
        }

        if($active_emps >= $max_employees){
            $exceeded = 1;
        }
	}
	if(empty($compinfo['complogo'])){
		$compinfo['complogo'] = ROOT.'images/rego_logo.png';
	}
	
	// LOGOUT CUSTOMER ///////////////////////////////////////////////////////////////////
	unset($_SESSION['rego']);

	if(!isset($_GET['mn']) && $logger == true){$_GET['mn'] = 2;}
	if(!isset($_GET['mn'])){$_GET['mn'] = 1;}
	//var_dump($compinfo['complogo']); exit;	



	/////////////////////////////// LOAD LAYOUT SETTINGS AND FUNCTIONS ////////////////////////////
	include("company_layout/common_layout_functions.php"); 
	/////////////////////////////// LOAD LAYOUT SETTINGS AND FUNCTIONS ////////////////////////////


?>

<!DOCTYPE html>
<html lang="en">
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
		<link rel="stylesheet" href="../assets/css/dataTables.bootstrap4.min.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/myDatatables.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/navigation.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/bootstrap-datepicker.css?<?=time()?>" />
		<link rel="stylesheet" href="../assets/css/myBootstrap.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/basicTable.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/myForm.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/overhang.min.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/sumoselect.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/responsive.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/autocomplete.css?<?=time()?>">



		<link rel="stylesheet" href="../assets/css/sumoselect.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/autocomplete.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/main.css?<?=time()?>">




		<script src="../assets/js/jquery-3.2.1.min.js"></script>
		<script src="../assets/js/jquery-ui.min.js"></script>
		<script src="../assets/js/moment.min.js"></script>
		<script src='../assets/js/moment-duration-format.min.js'></script>




		<script>
			//var headerCount = 2;
			var lang = <?=json_encode($lang)?>;
			var dtable_lang = <?=json_encode($dtable_lang)?>;
			var ROOT = <?=json_encode(ROOT)?>;
			var AROOT = <?=json_encode(AROOT)?>;
			var DIR = <?=json_encode(DIR)?>;
		</script>
		
	<style>
		.exelbox {
			width:200px;
			float:left;
			padding:15px;
		}
		.exelbox .inner {
			width:100%;
			border:0px red dotted;
			padding:10px;
			background:#fff;
			box-shadow:0px 0px 5px rgba(0,0,0,0.2);
			cursor:default;
		}
		.exelbox .inner:hover {
			xbox-shadow: 1px 1px 3px rgba(0,0,0,0.2);
		}
		.exelbox .inner p {
			padding:5px 0 0 0;
			font-size:13px;
			font-weight:bold;
			text-align:right;
		}
		.exelbox .inner img {
			width:100%;
		}
		.aTable {  
			width:100%;
			table-layout:auto;
			border-collapse:collapse;
			border:none;
			font-size:13px;
			color:#000;
			white-space:nowrap;
		}
		.aTable thead tr {
			border-bottom: 1px #ccc solid;
			background:#eee;
		}
		.aTable tfoot tr {
			border-bottom: 1px #eee solid;
			background:#fff;
		}
		.aTable thead tr th {
			text-align:left;
			width:5%;
			color:#005588;
			font-weight:600;
			vertical-align:middle;
			padding:4px 10px;
			border-right:1px #fff solid;
		}
		.aTable thead tr th:last-child {
			border-right:0;
		}
		.aTable tfoot tr td:last-child {
			border-right:0;
		}
		.aTable thead tr.tac th {
			text-align:center;
		}
		.aTable thead tr.tar th {
			text-align:right;
		}
		.aTable tbody tr {
			border-bottom: 1px #eee solid;
		}
		.aTable tbody.nopadding td,
		.aTable tfoot.nopadding td {
			padding:0;
		}
		.aTable tbody td, 
		.aTable tfoot td { 
			text-align:left;
			vertical-align: middle;
			padding:4px 10px;
			font-weight:400;
			border-right:1px #eee solid;
		}
		.aTable tfoot td.hl { 
			background: #ffd;
		}
		.aTable tbody td.pad410, 
		.aTable tfoot td.pad410 { 
			padding:4px 10px;
		}
		.aTable tbody.bold td, 
		.aTable tfoot.bold td {
			font-weight:600;
		}
		.aTable tbody td:last-child {
			border-right:0;
		}
		.aTable tbody td input[type=text], 
		.aTable tbody td input[type=password], 
		.aTable tbody td select,
		.aTable tfoot td input[type=text], 
		.aTable tfoot td input[type=password], 
		.aTable tfoot td select {
			width:100%;
			padding:4px 10px;
			border:0;
			border-bottom:0px #fff solid;
			margin:0;
			line-height:normal;
			box-sizing: border-box;
			display:inline-block;
			text-align:right;
			background:transparent;
		}
		.aTable tbody td select {
			padding:3px 6px;
			width:auto;
		}
		.tal {
			text-align:left;
		}
		.tac {
			text-align:center;
		}
		.tar {
			text-align:right;
		}
		.xtopnav .btn-group a.disable {
			pointer-events: none;
			cursor: default;
			xbackground:#333;
			color:#ccc;
		}
		.xtopnav btn-group a.disable:hover {
			cursor: not-allowed !important;
			background: #fff !important;
		}


		
	</style>		
	<?php if($_GET['mn'] == '2' || $_GET['mn'] == '3008' || $_GET['mn'] == '3007' || $_GET['mn'] == '3003' || $_GET['mn'] == '3002' || $_GET['mn'] == '3006' || $_GET['mn'] == '3001' || $_GET['mn'] == '3005'){
			if($_GET['mn'] == '3008' || $_GET['mn'] == '3007' || $_GET['mn'] == '3003' || $_GET['mn'] == '3006' || $_GET['mn'] == '3001' || $_GET['mn'] == '3005'){ ?>

					<style type="text/css">
			
						body, html {

							<?php if($savedAdminDashboardlayout['background_image_selection'] == 'selectfile'){?>
							 background: url('../../images/admin_uploads/<?php echo $savedAdminDashboardlayout['image_link'] ?>'); background-position:center;background-repeat: no-repeat;background-size: cover!important; 
							<?php }else if($savedAdminDashboardlayout['background_image_selection'] == 'noimage') {?>
								background: <?php echo $savedAdminColors[$savedAdminDashboardlayout['colorSelect16']]['code'] ?>!important;
							<?php }?>
						}
					</style>

			<?php }else
			{ ?>

				<style type="text/css">
			
					body, html {

						<?php if($savedAdminDashboardlayout['background_image_selection'] == 'selectfile'){?>
						 background: url('../../images/admin_uploads/<?php echo $savedAdminDashboardlayout['image_link'] ?>'); background-position:center;background-repeat: no-repeat;background-size: cover!important; 
						<?php }else if($savedAdminDashboardlayout['background_image_selection'] == 'noimage') {?>
							background: <?php echo $savedAdminColors[$savedAdminDashboardlayout['colorSelect16']]['code'] ?>!important;
						<?php }?>
					}
				</style>

		<?php } }?>
		

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
	</head>
	<body>
		


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


	<div class="header" style="background-image: linear-gradient(<?php echo $savedAdminColors[$savedAdminDashboardlayout['admin_dashboard_color3']]['code'] ?>, <?php echo $savedAdminColors[$savedAdminDashboardlayout['admin_dashboard_color4']]['code'] ?>); ">
		<table width="100%" border="0">
			<tr>
				<td style="padding-left:15px; width:1px">
					<img style="margin:5px 7px 5px 0; height:40px;" src="../<?=$default_logo?>?<?=time()?>" />
				</td>
				<td style="white-space:nowrap; vertical-align:middle; padding-left:5px">
					<b style="font-family:'Roboto Condensed'; font-weight:400; font-size:24px; color:#333;"><span style="font-family:<?php echo $savedAdminDashboardlayout['admin_dashboard_main_header_font'] ?>;color:<?php echo $savedAdminColors[$savedAdminDashboardlayout['admin_dashboard_main_header_font_color']]['code'] ?>"><?=$lng['Admin Platform']?></span></b> 
				</td>
				<td style="width:95%"></td>
				<td>
				<? if($lang=='en'){ ?>
					<a data-lng="th" class="langbutton admin_lang <? if($lang=='th'){echo 'activ';} ?>"><img src="../images/flag_th.png"></a>
				<? }else{ ?>
					<a data-lng="en" class="langbutton admin_lang <? if($lang=='en'){echo 'activ';} ?>"><img src="../images/flag_en.png"></a>
				</td>
				<? } ?>
				<td style="padding:0 10px">
				<? if($logger){ ?>
					<button type="button" class="alogout btn btn-logout"><i class="fa fa-power-off"></i></button>
				<? } ?>
				</td>
			</tr>
		</table>
	</div>

	<? if($logger){ ?>
		<div class="topnav-custom" style="background:<?php echo $savedAdminColors[$savedAdminDashboardlayout['admin_dashboard_color1']]['code'] ?>">
		
			<div class="btn-group <? if($_GET['mn']==2){echo 'active';}?>">
				<a style="background:<?php echo $savedAdminColors[$savedAdminDashboardlayout['admin_dashboard_color2']]['code'] ?>" href="index.php?mn=2" class="home"><i class="fa fa-home"></i></a>
			</div>
			
			<? if($_GET['mn'] >= 10 && $_GET['mn'] < 20){ ?> <!-- CUSTOMERS SETUP ----------------------------- -->
				<div style="background:<?php echo $savedAdminColors[$savedAdminDashboardlayout['admin_dashboard_color1']]['code'] ?> " class="btn-group <? if($_GET['mn']==11){echo 'active';}?>">
					<a href="index.php?mn=11"><?=$lng['Customers register']?></a>
				</div>
				<? if($_SESSION['RGadmin']['access']['customer']['add'] == 1){ ?>

					<? if($exceeded == 0){ ?>
						<div style="background:<?php echo $savedAdminColors[$savedAdminDashboardlayout['admin_dashboard_color1']]['code'] ?> " class="btn-group <? if($_GET['mn']==12){echo 'active';}?>">
							<a href="index.php?mn=12"><?=$lng['Add new Customer']?></a>
						</div>
					<? } ?>

				<? } ?>
			<? } ?>
			
			<? if($_GET['mn'] >= 50 && $_GET['mn'] < 60 || $_GET['mn']==100 || $_GET['mn']==101){ ?>
				<div class="btn-group <? if($_GET['mn']==50){echo 'active';}?>">
					<a href="index.php?mn=50"><?=$lng['Company Set Up']?></a>
				</div>
				<div class="btn-group <? if($_GET['mn']==100){echo 'active';}?>">
					<a href="index.php?mn=100"><?=$lng['Employee defaults']?></a>
				</div>	
				<div class="btn-group <? if($_GET['mn']==51){echo 'active';}?>">
					<a href="index.php?mn=51"><?=$lng['Payroll settings']?></a>
				</div>
				<div class="btn-group <? if($_GET['mn']==101){echo 'active';}?>">
					<a href="index.php?mn=101"><?=$lng['Payroll Models']?></a>
				</div>
				<div class="btn-group <? if($_GET['mn']==52){echo 'active';}?>">
					<a href="index.php?mn=52"><?=$lng['Leave settings']?></a>
				</div>
				<div class="btn-group <? if($_GET['mn']==53){echo 'active';}?>">
					<a href="index.php?mn=53"><?=$lng['Time settings']?></a>
				</div>
				<div class="btn-group <? if($_GET['mn']==58){echo 'active';}?>">
					<a href="index.php?mn=58"><?=$lng['Other settings']?></a>
				</div>
				<div class="btn-group <? if($_GET['mn']==54){echo 'active';}?>">
					<a href="index.php?mn=54"><?=$lng['Holidays']?></a>
				</div>
				<div class="btn-group <? if($_GET['mn']==55){echo 'active';}?>">
					<a href="index.php?mn=55"><?=$lng['Calendar']?></a>
				</div>
				<div class="btn-group <? if($_GET['mn']==56){echo 'active';}?>">
					<a href="index.php?mn=56"><?=$lng['Demo employees']?></a>
				</div>
				<div class="btn-group <? if($_GET['mn']==57){echo 'active';}?>">
					<a href="index.php?mn=57"><?=$lng['eMail templates']?></a>
				</div>
			<? } ?>
			
			<? if($_GET['mn'] >= 30 && $_GET['mn'] < 35){ ?>

				<? if($_GET['mn'] == 30){ ?>
					<div class="btn-group <? if($_GET['mn']==30){echo 'active';}?>">
						<a href="index.php?mn=30"><?=$lng['Admin users']?></a>
					</div>
				<? } ?>
				<? if($_GET['mn'] == 31){ ?>
					<div class="btn-group <? if($_GET['mn']==31){echo 'active';}?>">
						<a href="index.php?mn=31"><?=$lng['Client users']?></a>
					</div>
				<? } ?>
			<? } ?>
			
			<? if($_GET['mn'] >= 60 && $_GET['mn'] < 65){ ?>
				<div class="btn-group <? if($_GET['mn']==60){echo 'active';}?>">
					<a href="index.php?mn=60"><?=$lng['Help files']?></a>
				</div>
				<div class="btn-group <? if($_GET['mn']==61){echo 'active';}?>">
					<a href="index.php?mn=61"><?=$lng['Welcome files']?></a>
				</div>
				<div class="btn-group <? if($_GET['mn']==62){echo 'active';}?>">
					<a href="index.php?mn=62"><?=$lng['Log-in promo file']?></a>
				</div>
			<? } ?>
			
			<? if($_GET['mn'] >= 90 && $_GET['mn'] < 95){ ?> <!-- SUPPORT DESK ------------------------ -->
				<div class="btn-group <? if($_GET['mn']==90){echo 'active';}?>">
					<a href="index.php?mn=90"><?=$lng['Support desk']?></a>
				</div>
			<? } ?>
			
			<? if($_GET['mn'] >= 20 && $_GET['mn'] < 30){ ?>
				<div class="btn-group <? if($_GET['mn']==20){echo 'active';}?>">
					<a href="index.php?mn=20"><?=$lng['Overview']?></a>
				</div>
				<div class="btn-group <? if($_GET['mn']==21){echo 'active';}?>">
					<a href="index.php?mn=21"><?=$lng['New invoice']?></a>
				</div>
				<!--<div class="btn-group <? if($_GET['mn']==23){echo 'active';}?>">
					<a href="index.php?mn=23">New Receipt<? //=$lng['New invoice']?></a>
				</div>-->
				
				<div class="btn-group <? if($_GET['mn']==22){echo 'active';}?>">
					<button data-toggle="dropdown">
						 <?=$lng['Document setup']?> <span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<li><a href="index.php?mn=22&inv">Invoice</a></li>
						<li><a href="index.php?mn=22&rec">Receipt / Tax invoice</a></li>
					</ul>
				</div>
			<? } ?>
			
			<!-- USER ---------------------------------------------------------------------------------------------------------->
			
			<div style="float:right;background:<?php echo $savedAdminColors[$savedHeaderlayout['logo_and_headers_color1']]['code'] ?> " class="btn-group" >
				<button data-toggle="dropdown" style="padding:0 10px 0 0">
					 <img style="height:36px; width:36px; display:inline-block; border-radius:0px; margin:-4px 10px 0 10px; border:0px solid #666" src="<?=ROOT.$_SESSION['RGadmin']['img']?>?<?=time()?>"><b style="font-family:<?php echo $savedAdminDashboardlayout['admin_dashboard_header_font'] ?>;color: <?php echo $savedAdminColors[$savedAdminDashboardlayout['admin_dashboard_header_font_color']]['code'] ?>"><?=$_SESSION['RGadmin']['name']?></b>&nbsp; <span class="caret"></span>
				</button>
					<? if($_SESSION['RGadmin']['id'] != '5a6effb9c34ab'){ ?>
					<ul class="dropdown-menu pull-right">
						<li><img style="display:block; width:100%; padding-bottom:2px" src="<?=ROOT.$_SESSION['RGadmin']['img']?>?<?=time()?>"></li>
						<li><a style="width:100%" class="alogout"><i class="fa fa-sign-out"></i>&nbsp; Sign out</a></li>
						<li><a style="width:100%" data-toggle="modal" data-target="#passModal"><i class="fa fa-lock"></i>&nbsp; <?=$lng['Change password']?></a></li>
					</ul>
					<? } ?>
			</div>
			
			<div style="float:right;background:<?php echo $savedAdminColors[$savedHeaderlayout['logo_and_headers_color1']]['code'] ?> " class="btn-group" ><a style="font-size:16px; font-family:<?php echo $savedAdminDashboardlayout['admin_dashboard_header_font'] ?>;color:<?php echo $savedAdminColors[$savedAdminDashboardlayout['admin_dashboard_header_font_color']]['code'] ?>"><b><?=$emp_count?></b> <?=$lng['Employees']?> <?=$lng['in']?> <b><?=$comp_count?></b> <?=$lng['Companies']?></a></div>

			<div class="btn-group" style="float:right; display:none">
				<button data-toggle="dropdown">
					<i class="fa fa-user"></i>&nbsp; <?=$lng['Admin']?> <span class="caret"></span>
				</button>
				<ul class="dropdown-menu xpull-right">
					<li><a <? if($_GET['mn']==31){echo 'class="activ"';} ?> href="index.php?mn=31"><?=$lng['Add new Client']?></a></li>
					<li><a <? if($_GET['mn']==32){echo 'class="activ"';} ?> href="index.php?mn=32"><?=$lng['Client list']?></a></li>
				</ul>
			</div>
			
		</div>
	<? } ?>
	<div id="dump"></div>
	
		<? //var_dump($logger);
		if($logger){
			switch($_GET['mn']){
				
				case 2:  
					include('admin_dashboard.php'); 
					break;
					
				case 11:  
					if($_SESSION['RGadmin']['access']['customer']['access'] == 1){
						include('admin_customers_list.php'); 
					}else{
						include('no_access.php'); 
					}
					break;
				case 12:  
					if($_SESSION['RGadmin']['access']['customer']['access'] == 1){
						include('admin_new_customer.php'); 
					}else{
						include('no_access.php'); 
					}
					break;
				
				case 20: 
					if($_SESSION['RGadmin']['access']['billing']['access'] == 1){
						include('billing/billing_list.php'); 
					}else{
						include('no_access.php'); 
					}
					break;
				case 21: 
					if($_SESSION['RGadmin']['access']['billing']['access'] == 1){
						include('billing/new_invoice.php'); 
					}else{
						include('no_access.php'); 
					}
					break;
				case 22: 
					if($_SESSION['RGadmin']['access']['billing']['access'] == 1){
						include('billing/document_setup.php'); 
					}else{
						include('no_access.php'); 
					}
					break;
				case 23: 
					if($_SESSION['RGadmin']['access']['billing']['access'] == 1){
						include('billing/new_receipt.php'); 
					}else{
						include('no_access.php'); 
					}
					break;
				
				case 30: 
					if($_SESSION['RGadmin']['access']['users']['access'] == 1){
						include('admin_system_users.php'); 
					}else{
						include('no_access.php'); 
					}
					break;
				case 31: 
					if($_SESSION['RGadmin']['access']['users']['access'] == 1){
						include('rego_users.php'); 
					}else{
						include('no_access.php'); 
					}
					break;				
				case 32: 
					if($_SESSION['RGadmin']['access']['users']['access'] == 1){
						include('admin_xray_users.php'); 
					}else{
						include('no_access.php'); 
					}
					break;
				
				case 40: 
					if($_SESSION['RGadmin']['access']['price']['access'] == 1){
						include('admin_standards.php'); 
						//include('admin_pricetables.php'); 
					}else{
						include('no_access.php'); 
					}
					break;
				
				case 50:
					if($_SESSION['RGadmin']['access']['def_settings']['access'] == 1){
						include('def_settings/default_company_setup.php'); 
					}else{
						include('no_access.php'); 
					}
					break;
				case 51: 
					if($_SESSION['RGadmin']['access']['def_settings']['access'] == 1){
						include('def_settings/default_payroll_settings.php'); 
					}else{
						include('no_access.php'); 
					}
					break;				
				case 100: 
					if($_SESSION['RGadmin']['access']['def_settings']['access'] == 1){
						include('def_settings/default_empployee_settings.php'); 
					}else{
						include('no_access.php'); 
					}
					break;
				case 101: 
					if($_SESSION['RGadmin']['access']['def_settings']['access'] == 1){
						include('def_settings/default_payroll_models.php'); 
					}else{
						include('no_access.php'); 
					}
					break;
				case 102: 
					if($_SESSION['RGadmin']['access']['def_settings']['access'] == 1){
						include('def_settings/view_payroll_models.php'); 
					}else{
						include('no_access.php'); 
					}
					break;

				case 701: 
					if($_SESSION['RGadmin']['access']['def_settings']['access'] == 1){
						include('def_settings/rego_allow_deduction.php'); 
					}else{
						include('no_access.php'); 
					}
					break;

				case 702: 
					if($_SESSION['RGadmin']['access']['def_settings']['access'] == 1){
						include('def_settings/rego_reward_penalties.php'); 
					}else{
						include('no_access.php'); 
					}
					break;

				case 52: 
					if($_SESSION['RGadmin']['access']['def_settings']['access'] == 1){
						include('def_settings/default_leave_settings.php'); 
					}else{
						include('no_access.php'); 
					}
					break;
				case 53: 
					if($_SESSION['RGadmin']['access']['def_settings']['access'] == 1){
						include('def_settings/default_time_settings.php'); 
					}else{
						include('no_access.php'); 
					}
					break;				
				case 7002: 
					if($_SESSION['RGadmin']['access']['def_settings']['access'] == 1){
						include('def_settings/edit_admin_shift_schedule.php'); 
					}else{
						include('no_access.php'); 
					}
					break;
				case 54: 
					if($_SESSION['RGadmin']['access']['def_settings']['access'] == 1){
						include('def_settings/default_holidays.php'); 
					}else{
						include('no_access.php'); 
					}
					break;
				case 55: 
					if($_SESSION['RGadmin']['access']['def_settings']['access'] == 1){
						include('def_settings/default_calendar.php'); 
					}else{
						include('no_access.php'); 
					}
					break;
				case 56: 
					if($_SESSION['RGadmin']['access']['def_settings']['access'] == 1){
						include('def_settings/demo_employees.php'); 
					}else{
						include('no_access.php'); 
					}
					break;
				case 59: 
					if($_SESSION['RGadmin']['access']['def_settings']['access'] == 1){
						include('def_settings/demo_employees_edit.php'); 
					}else{
						include('no_access.php'); 
					}
					break;
				case 57: 
					if($_SESSION['RGadmin']['access']['email_templates_settings']['access'] == 1){
						include('def_settings/default_email_templates.php'); 
					}else{
						include('no_access.php'); 
					}
					break;
				case 58: 
					if($_SESSION['RGadmin']['access']['def_settings']['access'] == 1){
						include('def_settings/default_other_settings.php'); 
					}else{
						include('no_access.php'); 
					}
					break;
				case 580: 
					include('def_settings/default_settings.php'); 
					break;
				
				case 60: 
					if($_SESSION['RGadmin']['access']['help']['access'] == 1){
						include('help/help_files.php'); 
					}else{
						include('no_access.php'); 
					}
					break;				
				case 61: 
					if($_SESSION['RGadmin']['access']['help']['access'] == 1){
						include('help/welcome_files.php'); 
					}else{
						include('no_access.php'); 
					}
					break;				
				case 62: 
					if($_SESSION['RGadmin']['access']['help']['access'] == 1){
						include('help/promo_file.php'); 
					}else{
						include('no_access.php'); 
					}
					break;				

				case 70: 
					if($_SESSION['RGadmin']['access']['privacy']['access'] == 1){
						include('admin_logdata.php'); 
					}else{
						include('no_access.php'); 
					}
					break;				
				
				case 75: 
					if($_SESSION['RGadmin']['access']['privacy']['access'] == 1){
						include('help/terms_conditions.php'); 
					}else{
						include('no_access.php'); 
					}
					break;				
				
				case 76: 
					if($_SESSION['RGadmin']['access']['privacy']['access'] == 1){
						include('help/privacy_policy.php'); 
					}else{
						include('no_access.php'); 
					}
					break;				
				
				case 80: 
					if($_SESSION['RGadmin']['access']['comp_settings']['access'] == 1){
						include('admin_company_settings.php'); 
					}else{
						include('no_access.php'); 
					}
					break;				
				case 3000: 
					if($_SESSION['RGadmin']['access']['layout_settings']['access'] == 1){
						include('admin_layout_settings.php'); 
					}else{
						include('no_access.php'); 
					}
					break;				
				
				case 90: 
					if($_SESSION['RGadmin']['access']['support']['access'] == 1){
						include('support/support_desk.php'); 
					}else{
						include('no_access.php'); 
					}
					break;
				case 91: 
					if($_SESSION['RGadmin']['access']['support']['access'] == 1){
						include('support/support_ticket.php'); 
					}else{
						include('no_access.php'); 
					}
					break;
				case 92: 
					if($_SESSION['RGadmin']['access']['support']['access'] == 1){
						include('support/new_support_ticket.php'); 
					}else{
						include('no_access.php'); 
					}
					break;
				
				case 95: 
					if($_SESSION['RGadmin']['access']['agents']['access'] == 1){
						include('agents/agents_list.php'); 
					}else{
						include('no_access.php'); 
					}
					break;
				
				case 99: 
					if($_SESSION['RGadmin']['access']['language']['access'] == 1){
						include('language/language_list.php'); 
					}else{
						include('no_access.php'); 
					}
					break;
				case 3001: 
					if($_SESSION['RGadmin']['access']['support_help_files']['access'] == 1){
						include('admin_support_files.php'); 
					}else{
						include('no_access.php'); 
					}
					break;		
				case 3002: 
					if($_SESSION['RGadmin']['access']['company_registration']['access'] == 1){
						include('admin_company_registration.php'); 
					}else{
						include('no_access.php'); 
					}
					break;					
				case 3003: 
					if($_SESSION['RGadmin']['access']['platform_settings']['access'] == 1){
						include('admin_platform_settings.php'); 
					}else{
						include('no_access.php'); 
					}
					break;					
				case 3004: 
					if($_SESSION['RGadmin']['access']['parameters_tab']['access'] == 1){
						include('admin_parameters_tab.php'); 
					}else{
						include('no_access.php'); 
					}
					break;	
				case 3005: 
					if($_SESSION['RGadmin']['access']['legal_conditions']['access'] == 1){
						include('admin_legal_conditions.php'); 
					}else{
						include('no_access.php'); 
					}
					break;					
				case 3006: 
					if($_SESSION['RGadmin']['access']['software_models']['access'] == 1){
						include('admin_software_models.php'); 
					}else{
						include('no_access.php'); 
					}
					break;					
				case 3007: 
					if($_SESSION['RGadmin']['access']['users_tab']['access'] == 1){
						include('admin_users_tab.php'); 
					}else{
						include('no_access.php'); 
					}
					break;	
				case 3008: 
					if($_SESSION['RGadmin']['access']['customer']['access'] == 1){
						include('admin_customer_tab.php'); 
					}else{
						include('no_access.php'); 
					}
					break;	
				
			}
		}else{
			//include('admin_login.php');
			header('location: admin_login.php');
		}
		?>
	
	<!-- Modal Change Password -->
	<div class="modal fade" id="passModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		 <div class="modal-dialog" style="max-widt:450px">
			  <div class="modal-content">
					<div class="modal-header">
						 <h4 class="modal-title" id="myModalLabel"><i class="fa fa-lock"></i>&nbsp; <?=$lng['Change password']?></h4>
					</div>
					<div class="modal-body" style="padding:10px 25px 25px 25px">
					<span style="font-weight:600; color:#cc0000;" id="pass_msg"></span>
					<form id="userPassword" class="sform" style="padding-top:10px;">
						 <label><?=$lng['Old password']?> <i class="man"></i></label>
						 <input name="opass" id="opass" type="password" />
						 <label><?=$lng['New password']?> <i class="man"></i></label>
						 <input name="npass" id="npass" type="password" />
						 <label><?=$lng['Repeat new password']?> <i class="man"></i></label>
						 <input name="rpass" id="rpass" type="password" />
						 <button class="btn btn-primary" style="margin-top:15px" type="submit"><i class="fa fa-save"></i> <?=$lng['Change password']?></button>
						<button style="float:right;margin-top:15px" type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp; <?=$lng['Cancel']?></button>
						<div class="clear"></div>
					</form>
					</div>
					<div class="clear"></div>
			  </div>
		 </div>
	</div>
	
	<script src="../assets/js/popper.min.js"></script>
	<script src="../assets/js/bootstrap.min.js"></script>
	<script src="../assets/js/jquery.dataTables.min.js"></script>
	<script src="../assets/js/dataTables.bootstrap4.min.js"></script>
	<script src="../assets/js/bootstrap-datepicker.min.js"></script>
	<script src="../assets/js/bootstrap-datepicker.th.js"></script>
	<script src="../assets/js/bootstrap-confirmation.js"></script>
	<script src="../assets/js/jquery.numberfield.js"></script>	
	<script src="../assets/js/jquery.mask.js"></script>	
	<script src="../assets/js/overhang.min.js?<?=time()?>"></script>
	<script src="../assets/js/rego.js"></script>
	<script src="../assets/js/jquery.sumoselect.min.js"></script>

	<script src="../assets/js/jquery.flicker.js?<?=time()?>"></script>
	<script src="../assets/js/jquery.autocomplete.js"></script>

			<script src='../assets/js/fullcalendar.js'></script>
		<script src='../assets/js/main.js'></script>
		<? if($lang == 'th'){ ?>
		<script src="../assets/js/fullcalendar-th.js?<?=time()?>"></script>
		<? } ?>
	
	<script type="text/javascript">
		
	$(document).ready(function() {
		
		$(document).on('click', ".dataTable.selectable tbody tr", function(){
			$(".dataTable tbody tr").removeClass('selected');
			$(this).addClass('selected');
		});

		$('.date_year').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			inline: true,
			language: '<?=$lang?>',//lang+'-th',
			//viewMode: 'years',
			startView: 'decade',
			todayHighlight: true,
			//startDate : startYear,
    		//endDate   : endYear
		})
		
		$('.date_month').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			inline: true,
			language: '<?=$lang?>',//lang+'-th',
			//viewMode: 'years',
			startView: 'year',
			todayHighlight: true,
			//startDate : startYear,
    		//endDate   : endYear
		})
		
		$('.datepick').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			inline: true,
			language: '<?=$lang?>',//lang+'-th',
			//viewMode: 'years',
			todayHighlight: true,
			//startDate : startYear,
    		//endDate   : endYear
		})
		
		var innerheight = window.innerHeight;
		$('.widget.autoheight').css('min-height', innerheight-150);
		
		$(document).on('click', '.selectCustomer', function(){
			$.ajax({
				url: "ajax/select_customer.php",
				data: {id: $(this).data('id')},
				success: function(result){
					//alert('1');
					$('#dump').html(result);
					//alert(ROOT+result+'/index.php')
					//window.open(ROOT+result+'/index.php', '_blank');

					location.href = ROOT+'index.php';
				}
			});
		});
		
		$('.admin_lang').on('click', function(){
			//alert()
			$.ajax({
				url: "ajax/change_lang.php",
				data: {lng: $(this).data('lng')},
				success: function(ajaxresult){
					//alert(ajaxresult);
					location.reload();
				}
			});
		});
		
		$(".alogout").click(function(){ 
			$.ajax({
				url: "ajax/logout.php",
				success: function(result){
					//alert(result)
					location.reload();
				},
				error:function (xhr, ajaxOptions, thrownError){
					alert(thrownError);
				}
			});
		});
		
		$(window).on('resize', function(){
			var innerheight = window.innerHeight;
			$('.widget.autoheight').css('min-height', innerheight-150)
		});	
		
		$("#userPassword").submit(function (e) {
			e.preventDefault();
			if($('#opass').val()=='' || $('#npass').val()=='' || $('#rpass').val()==''){
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Please fill in required fields']?>',
					duration: 3,
				})
				return false;
			}
			if($('#npass').val().length < 8){
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['New password to short min 8 characters']?>',
					duration: 3,
				})
				return false;
			}
			if($('#npass').val() !== $('#rpass').val()){
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['New passwords are not the same']?>',
					duration: 3,
				})
				return false;
			}
			var formData = $(this).serialize();
			//alert(formData);
			$.ajax({
				url: "ajax/change_admin_password.php",
				dataType: "text",
				data: formData,
				success: function(response){
					response = $.trim(response);
					//$('#dump').html(response); return false;
					if(response=='success'){
						$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Password changed successfuly']?>',
							duration: 3,
						})
						setTimeout(function(){
							$('#passModal').modal('toggle');
						}, 2000);
					}else if(response=='old'){
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Old Password is wrong']?>',
							duration: 3,
						})
					}else{
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;' + response,
							duration: 3,
						})
					}
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 8,
						closeConfirm: "true",
					})
				}
			});
		});
		$('#passModal').on('hidden.bs.modal', function () {
			$(this).find('form').trigger('reset');
			$("#pass_msg").html('');
		});
			
		<? if($logger == 'x'){ ?>
			setTimeout(function(){
				$.ajax({
					url: "ajax/logtime_expired.php",
					success: function(result){
						window.location.reload();
					}
				});
			}, <?=$logtime*1000?>);
		<? } ?>
		
		
		$('.preloader').fadeOut();

	});

	</script>

	<script>

		$('.ssdatepick').datepicker({
			format: "dd/mm/yyyy",
			autoclose: true,
			inline: true,
			language: '<?=$lang?>',
			todayHighlight: true,
		});

	</script>

	</body>
</html>








