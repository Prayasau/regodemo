<?php
	if(session_id()==''){session_start();}
	
	$logtime = 7200;
	if(isset($_SESSION['rego']['emp_id']) && !empty($_SESSION['rego']['emp_id'])){
		if(time() - $_SESSION['rego']['timestamp'] > $logtime) {
			$_SESSION['rego']['timestamp'] = 0;
			header('location: login.php');
		}else{
			$_SESSION['rego']['timestamp'] = time();
		}
	}else{
		header('location: login.php');
	}	


	
	// print_r($_SESSION);
	include('../dbconnect/db_connect.php');
	include(DIR.'files/arrays_'.$lang.'.php');
	include(DIR.'files/functions.php');
	include(DIR.'files/payroll_functions.php');
	include(DIR.'leave/functions.php');


	
	if(isset($_GET['y'])){
		$_SESSION['rego']['mob_year'] = $_GET['y'];
	}
	
	$cid = $_SESSION['rego']['cid'];
	$scan = false;
	if($res = $dbc->query("SELECT scan_system FROM ".$cid."_leave_time_settings")){
		$xrow = $res->fetch_assoc();
		if($xrow['scan_system'] == 'REGO'){$scan = true;}
	}

	
	if(!isset($_SESSION['rego']['mob_year'])){$_SESSION['rego']['mob_year'] = date('Y');}
	//$_SESSION['rego']['mob_year'] = date('Y');
	$_SESSION['rego']['year_en'] = $_SESSION['rego']['mob_year'];
	$_SESSION['rego']['year_th'] = ((int)$_SESSION['rego']['mob_year'])+543;
	$_SESSION['rego']['curr_month'] = date('m');
	$_SESSION['rego']['cur_month'] = date('n');
	$data = array();
	if($res = $dbc->query("SELECT * FROM ".$cid."_employees WHERE emp_id = '".$_SESSION['rego']['emp_id']."'")){
		$data = $res->fetch_assoc();
	}
	if(empty($data['image'])){$data['image'] = 'images/profile_image.jpg';}
	$_SESSION['rego']['payroll_dbase'] = $cid.'_payroll_'.$_SESSION['rego']['mob_year'];
	$_SESSION['rego']['emp_dbase'] = $cid.'_employees';
	$years = getYears($cid);


	$request = array();
	$confirmed = array();
	$assigned = array();

	if(!isset($_GET['mn'])){$_GET['mn'] = 2;}



	// GET REGO STANDARD VAUES 

	$my_dbaname = $prefix.'regodemo';


	$dba = new mysqli($my_database,$my_username,$my_password,$my_dbaname);
	mysqli_set_charset($dba,"utf8");
	if($dba->connect_error) {
		echo'<p style="width:900px; margin:0 auto; margin-top:20px;" class="box_err">Error: ('.$dba->connect_errno.') '.$dba->connect_error.'<br>Please try again later or report this error to <a href="mailto:admin@regohr.com">admin@regohr.com</a></p>';
	}

	$sql102 = "SELECT * FROM rego_customers WHERE clientID = '".$_SESSION['rego']['cid']."'";

	if($res102 = $dba->query($sql102)){
		if($res102->num_rows > 0){
			if($row102 = $res102->fetch_assoc())
				{
					$versionValue = $row102['version'];  // SELECTED TEAMS STORED IN SESSION 
						
				}
		}
	}




	$standardArray = $_SESSION['rego']['standard'];

	$leaveCheck = $standardArray[$versionValue]['leave'];
	$timeCheck = $standardArray[$versionValue]['time'];


?>

<!doctype html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport"	content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="white-translucent">
	<meta name="theme-color" content="#ffffff">
	<title><?=$www_title?></title>
	<link rel="icon" type="image/png" href="../assets/images/192x192.png" sizes="32x32">
	<link rel="manifest" href="__manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="assets/img/icon/144x144.png">
	<meta name="theme-color" content="#ffffff">	
	<link rel="stylesheet" href="../assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="../assets/css/line-awesome.min.css">
	<link href="../assets/css/bootstrap-datepicker.css?<?=time()?>" rel="stylesheet">
	<link href="assets/css/jquery-clockpicker.css?<?=time()?>" rel="stylesheet">
	<link href="assets/css/bootstrap-datepicker.css?<?=time()?>" rel="stylesheet">
	<link href="assets/css/animate.min.css?<?=time()?>" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/style.css?<?=time()?>">
    <!-- Jquery -->
    <script src="assets/js/lib/jquery-3.4.1.min.js"></script>

</head>
<style type="text/css">
	.opacitycheck
	{
		opacity: 0.3;
	}
</style>
<body>

    <!-- loader -->
    <!--<div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>-->
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader text-light">
			<? if($_GET['mn'] > 2){?>
				<div class="left">
					<a href="#" class="headerButton goBack">
						<i class="fa fa-angle-double-left fa-lg"></i>
					</a>
        		</div>
			<? }else{ ?>

				<? $count_request = 0;?>
				<div class="left">
					<a href="index.php?mn=201" class="spanClass headerButton ">
						<i class="fa fa-bell fa-lg"></i>
						<!-- <span class='badge badge-warning' id='lblCartCount'> <?php echo $count_request; ?> </span> -->
					</a>
       			</div>

			<? } ?>
        <div class="pageTitle"><?=$compinfo[$lang.'_compname']?></div>
        <div class="right">
					<a href="#" class="headerButton" data-toggle="modal" data-target="#sidebarPanel">
						 <i class="fa fa-bars fa-lg"></i>
					</a>
				</div>
    </div>
    <!-- * App Header -->

	<? switch($_GET['mn']){
			case 1: 
				//header('location: login.php'); break;
			case 2: 
				include('dashboard.php');	break;
			case 10: 
				include('personal.php'); break;
			case 11: 
				include('payslips.php'); break;
			case 12: 
				include('year_overview.php'); break;
			case 13: 
				include('calendar.php'); break;
			case 14: 
				include('contact.php'); break;
			case 15: 
				include('password.php'); break;
			case 16: 
				include('time.php'); break;
			case 17: 
				include('leave.php'); break;


			case 21: 
				include('select.php'); break;
			case 19: 
				include('company_dashboard.php'); break;
			case 20: 
				include('system_dashboard.php'); break;

			case 201: 
				include('notification.php'); break;
			
		}	?>

    <!-- App Bottom Menu -->
    <div class="appBottomMenu text-light">
        <a href="#" class="item logout">
            <div class="col"><i class="fa fa-sign-out fa-lg"></i></div>
        </a>
				<a href="#" class="item" data-toggle="modal" data-target="#selectyear" style="border-left:1px solid #666">
            <div class="col"><?=$_SESSION['rego']['year_'.$lang]?></div>
        </a>
				<? if($lang=='en'){ ?>
					<a href="#" style="border-left:1px solid #666" data-lng="th" class="item langbutton <? if($lang=='th'){echo 'activ';} ?>"><div class="col"><img src="../images/flag_th.png"></div></a>
				<? }else{ ?>
					<a href="#" style="border-left:1px solid #666" data-lng="en" class="item langbutton <? if($lang=='en'){echo 'activ';} ?>"><div class="col"><img src="../images/flag_en.png"></div></a>
				<? } ?>
        <a href="index.php?mn=2" class="item" style="border-left:1px solid #666">
            <div class="col"><i class="fa fa-home fa-lg"></i></div>
        </a>
    </div>
    <!-- * App Bottom Menu -->

    <!-- App Sidebar -->
    <div class="modal fade panelbox panelbox-right" id="sidebarPanel" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">

                    <!-- profile box -->
                    <div class="profileBox">
                        <div class="image-wrapper">
                            <img src="../<?=$default_logo?>">
                        </div>
                        <a href="#" class="close-sidebar-button" data-dismiss="modal">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                    <!-- * profile box -->

                    <ul class="custom-list" style=" border-bottom:1px solid #333; padding-bottom:10px;">
											<li>
												<a href="index.php?mn=2" class="item">
													<div class="icon-box" style="background: #eee; color:#333"><i class="fa fa-home fa-lg"></i></div>
													<em><?=$lng['Dashboard']?></em>
												</a>
											</li>
											<li>
												<a href="index.php?mn=10" class="item">
													<div class="icon-box bg-red-dark"><i class="fa fa-user"></i></div>
													<em><?=$lng['Personal data']?></em>
												</a>
											</li>
											<li>
												<a href="index.php?mn=11" class="item">
													<div class="icon-box bg-green-dark"><i class="fa fa-files-o"></i></div>
													<em><?=$lng['Payslips']?></em>
												</a>
											</li>
											<li>
												<a href="index.php?mn=12" class="item">
													<div class="icon-box bg-blue-dark"><i class="fa fa-list-ul"></i></div>
													<em><?=$lng['Year overview']?></em>
												</a>
											</li>
											<li>
												<a href="index.php?mn=13" class="item">
													<div class="icon-box bg-magenta-dark"><i class="fa fa-calendar"></i></div>
													<em><?=$lng['Calendar']?></em>
												</a>
											</li>

											<li>
												<a <?php if($leaveCheck == '1'){ 
														echo 'href="index.php?mn=17"';

													}else {

														echo 'href="#"';
													} ?> class="item">
													<div class="icon-box bg-yellow-dark"><i class="fa fa-plane"></i></div>
													<em><?=$lng['Leave']?></em>
												</a>
											</li>
											<li>
												<a href="index.php?mn=14" class="item">
													<div class="icon-box bg-night-dark"><i class="fa fa-comments-o"></i></div>
													<em><?=$lng['Contact']?></em>
												</a>
											</li>
											<li>
												<a href="index.php?mn=15" class="item">
													<div class="icon-box bg-blue-light"><i class="fa fa-lock"></i></div>
													<em><?=$lng['Password']?></em>
												</a>
											</li>
											<li>
												<a href="#" class="item logout">
													<div class="icon-box bg-red-dark"><i class="fa fa-sign-out"></i></div>
													<em><?=$lng['Log out']?></em>
												</a>
											</li>
										</ul>

                    <ul class="custom-list" style="margin-top:10px !important">
											<li>
												<a href="tel:+926522446" class="item">
													<div class="icon-box bg-green-dark"><i class="fa fa-phone"></i></div>
													<em><?=$lng['Call us']?></em>
												</a>
											</li>
											<li>
												<a href="sms:+926522446" class="item">
													<div class="icon-box bg-red-dark"><i class="fa fa-comment-o"></i></div>
													<em><?=$lng['Text us']?></em>
												</a>
											</li>
											<li>
												<a href="mailto:pascal@xray.co.th?subject=Message from PKF Mobile" class="item">
													<div class="icon-box bg-blue-dark"><i class="fa fa-envelope-o"></i></div>
													<em><?=$lng['Mail us']?></em>
												</a>
											</li>
										</ul>
                </div>

            </div>
        </div>
    </div>
    <!-- * App Sidebar -->
    
		<!-- iOS Add to Home Action Sheet -->
    <div class="modal inset fade action-sheet ios-add-to-home" id="ios-add-to-home-screen" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add to Home Screen</h5>
                    <a href="javascript:;" class="close-button" data-dismiss="modal">
                        <ion-icon name="close"></ion-icon>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="action-sheet-content text-center">
                        <div class="mb-1"><img style="height:30px" src="../<?=$default_logo?>"></div>
                        <h4><?=$www_title?></h4>
                        <div>
                            Install <?=$www_title?> on your iPhone's home screen.
                        </div>
                        <div>
                            Tap <ion-icon name="share-outline"></ion-icon> and Add to homescreen.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * iOS Add to Home Action Sheet -->
    
		<!-- Android Add to Home Action Sheet -->
    <div class="modal inset fade action-sheet android-add-to-home" id="android-add-to-home-screen" tabindex="-1"
        role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add to Home Screen</h5>
                    <a href="javascript:;" class="close-button" data-dismiss="modal">
                        <ion-icon name="close"></ion-icon>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="action-sheet-content text-center">
                        <div class="mb-1"><img style="height:30px" src="../<?=$default_logo?>"></div>
                        <h4><?=$www_title?></h4>
                        <div>
                            Install <?=$www_title?> on your Android's home screen.
                        </div>
                        <div>
                            Tap <ion-icon name="ellipsis-vertical"></ion-icon> and Add to homescreen.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * Android Add to Home Action Sheet -->
        
		<!-- Select year -->
		<div class="modal fade action-sheet" id="selectyear" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header" style="background:#f6f6f6">
							<h5 class="modal-title" style="font-size:18px; font-weight:500">Select year</h5>
					</div>
					<div class="modal-body">
						<div style="padding:15px">
						 <? foreach($years as $k=>$v){
									$yr = $k;
									if($lang == 'th'){$yr = $k + 543;} ?>
									<button class="btn btn-info selYear mr-1 mb-1" data-year="<?=$k?>"><?=$yr?></button>
								<? } ?>
								<div class="clear"></div>
								<!--<button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Close</button>-->
						</div>
					</div>
				</div>
			</div>
		</div>

    <script src="assets/js/lib/popper.min.js"></script>
    <script src="assets/js/lib/bootstrap.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.js"></script>
    <script src="assets/js/plugins/owl-carousel/owl.carousel.min.js"></script>
    <script src="assets/js/plugins/jquery-circle-progress/circle-progress.min.js"></script>
		<script src="../assets/js/bootstrap-datepicker.min.js"></script>
		<script src="assets/js/jquery-clockpicker.js?<?=time()?>"></script>
    <script src="assets/js/base.js"></script>

<script type="text/javascript">
	
	// Toggle Add to Home Button with 3 seconds delay.
	// Toggle only once
	AddtoHome('3000', 'once');
	
	$(document).ready(function() {
		
		$(document).on("click", ".selYear", function(e){
			$.ajax({
				url: "ajax/change_year.php",
				data: {year: $(this).data('year')},
				success:function(result){
					//alert(result);
					window.location.reload();
				},
				error:function (xhr, ajaxOptions, thrownError){
					alert('<?=$lng['Error']?> ' + thrownError);
				}
			});
		});
		
		$('.langbutton').on('click', function(){
			$.ajax({
				url: "ajax/change_lang.php",
				data: {lng: $(this).data('lng')},
				success: function(ajaxresult){
					location.reload();
				}
			});
		});
		
		$(".logout").on('click', function(){ 
			$.ajax({
				url: "../ajax/logout.php",
				success: function(result){
					//alert(ROOT+SUBDIR+'/index.php')
					window.location.href = 'login.php';
				},
				error:function (xhr, ajaxOptions, thrownError){
					//alert(thrownError);
				}
			});
		});


	})
	
</script>	
</body>

</html>