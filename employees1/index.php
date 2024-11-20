<?php

	if(session_id()==''){session_start();} 
	ob_start();
	include('../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	//include(DIR.'time/functions.php');
	include(DIR.'files/arrays_'.$_SESSION['rego']['lang'].'.php');
	
	$helpfile = '';
	$logger = false;
	if(isset($_SESSION['rego']['cid']) && !empty($_SESSION['rego']['cid'])){
		if(isset($_SESSION['RGadmin'])){
			$logtime = 86000;
		}else{
			$logtime = (int)$comp_settings['logtime'];
		}
		if($logtime < 60){
			$logtime = 900; // 15 min
		}
		if(time() - $_SESSION['rego']['timestamp'] > $logtime) {
			$_SESSION['rego']['timestamp'] = 0;
			$logger = false; 
		}else{
			$_SESSION['rego']['timestamp'] = time();
			$logger = true;
		}
	}
	
	$getDefaultSysSettings = getDefaultSysSettings();

	/////////////////////////////// LOAD LAYOUT SETTINGS AND FUNCTIONS ////////////////////////////
	include("../admin/company_layout/common_layout_functions_system.php"); 
	/////////////////////////////// LOAD LAYOUT SETTINGS AND FUNCTIONS ////////////////////////////


	$baseUrl = ROOT;
	$updateAnythingValue = $_SESSION['rego']['updateAnythingValue'] ; 



?>





<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, maximum-scale=1">
		<meta name="robots" content="noindex, nofollow">
		<title><?=$www_title?></title>
		<link rel="icon" type="image/png" sizes="192x192" href="../assets/images/192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="../assets/images/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon-16x16.png">
    
		<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/line-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/select2.min.css">
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
		<link rel="stylesheet" href="../assets/css/croppie_emp.css?<?=time()?>" />
		<link rel="stylesheet" href="../assets/css/autocomplete.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/sumoselect-menu.css?<?=time()?>">


		<link rel="stylesheet" href="../assets/css/sumoselect.css?<?=time()?>">
		<script src="../assets/js/jquery-3.2.1.min.js"></script>
		<script src="../assets/js/jquery-ui.min.js"></script>
	
		<script>
			//var headerCount = 2;
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
					if($_GET['mn'] == 100){ ?>

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
		
	<? include('../include/main_header.php');?>
	
	<div class="topnav-custom" <? echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['main_dashboard_color1']]['code']."";?>>
		<div class="btn-group"> 

				<? if($_GET['mn'] == 102){ ?>

					<a onclick="showWarning();" <? echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['main_dashboard_color2']]['code']."";?> class="home"><i class="fa fa-home"></i></a>

				<?php }else{ ?>

					<a <? echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['main_dashboard_color2']]['code']."";?> href="../index.php?mn=2" class="home"><i class="fa fa-home"></i></a>

				<?php } ?>
			
		</div>
		<div class="btn-group <? if($_GET['mn']==100){echo 'active';}?>">

			<? if($_GET['mn'] == 102){ ?>

				<a onclick="showWarningOnBack();" <? echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['main_dashboard_color2']]['code']."";?>  class="home"><i class="fa fa-dashboard"></i></a>

			<?php }else{ ?>

				<a <? echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['main_dashboard_color2']]['code']."";?> href="index.php?mn=100" class="home"><i class="fa fa-dashboard"></i></a>

			<?php } ?>
		</div>
		
		<? if($_GET['mn'] == 100 || $_GET['mn'] == 101 || $_GET['mn'] == 102 || $_GET['mn'] == 1028){ 
			include('../include/main_menu_selection.php');} ?>
		
		
		<? if($_GET['mn'] >= 1020 && $_GET['mn'] <= 1026){?>
			<div class="btn-group <? if($_GET['mn']==101){echo 'active';}?>">
				<a href="index.php?mn=101"><?=$lng['Employee register']?></a>
			</div>
			<div class="btn-group <? if($_GET['mn']==1021){echo 'active';}?>">
				<a href="index.php?mn=1021"><?=$lng['Employee info']?></a>
			</div>

			<div class="btn-group <? if($_GET['mn']==1020){echo 'active';}?>">
				<a href="index.php?mn=1020"><?=$lng['Work info']?></a>
			</div>

			<? if(isset($_SESSION['rego']['empID']) && $_SESSION['rego']['empID'] != '0'){ ?>
				<div class="btn-group <? if($_GET['mn']==1022){echo 'active';}?>">
					<a href="index.php?mn=1022"><?=$lng['Financial info']?></a>
				</div>
				
				<? if($_SESSION['rego']['standard'][$standard]['other_benefits']){ ?>
				<div class="btn-group <? if($_GET['mn']==1023){echo 'active';}?>">
					<a href="index.php?mn=1023"><?=$lng['Other benefits']?></a>
				</div>
				<? } if($_SESSION['rego']['standard'][$standard]['historical']){ ?>
				<div class="btn-group <? if($_GET['mn']==1024){echo 'active';}?>">
					<a href="index.php?mn=1024"><?=$lng['Historical records']?></a>
				</div>
				<? } if($_SESSION['rego']['standard'][$standard]['workpermit']){ ?>
				<div class="btn-group <? if($_GET['mn']==1025){echo 'active';}?>">
					<a href="index.php?mn=1025"><?=$lng['Workpermit']?></a>
				</div>
				<? } if($_SESSION['rego']['standard'][$standard]['tax_simulation']){ ?>
				<div class="btn-group <? if($_GET['mn']==1026){echo 'active';}?>">
					<a href="index.php?mn=1026"><?=$lng['Tax simulation']?></a>
				</div>
				<? } ?>
			<? } ?>
		<? } ?>
		
		<!-- <div class="btn-group">
			<a href="reports/index.php?mn=450"><?=$lng['Reports']?></a>
		</div> -->
		<div class="btn-group" style="float:right;background:<?php echo $savedAdminColors[$savedMainDashboardlayout['main_dashboard_color2']]['code'] ;?>!important;"> 
			<button style="padding:0 8px; background:<?php echo $savedAdminColors[$savedMainDashboardlayout['main_dashboard_color2']]['code'] ;?>; cursor:default">
				 <img class="nav-user-img" src="<?=ROOT.$_SESSION['rego']['img']?>?<?=time()?>">
			</button>
		</div>

	</div>
	
	<? if($logger){
			switch($_GET['mn']){
				case 100: 
					$helpfile = getHelpfile(101);
					include('employee_dashboard.php'); 
					break;
				case 101: 
					$helpfile = getHelpfile(101);
					include('employees_list.php'); 
					break;
				case 102: 
					//$helpfile = getHelpfile(101);
					include('modify_employees.php'); 
					break;
				case 1020: 
					$helpfile = getHelpfile(102);
					include('work_info.php'); 
					break;
				case 1021: 
					$helpfile = getHelpfile(102);
					include('employee_info.php'); 
					break;
				case 1022: 
					//$helpfile = getHelpfile(102);
					include('employee_financial.php'); 
					break;
				case 1023: 
					//$helpfile = getHelpfile(102);
					include('employee_benefits.php'); 
					break;
				case 1024: 
					//$helpfile = getHelpfile(102);
					include('employee_history.php'); 
					break;
				case 1025: 
					//$helpfile = getHelpfile(102);
					include('employee_workpermit.php'); 
					break;
				case 1026: 
					//$helpfile = getHelpfile(102);
					include('employee_tax_simulation.php'); 
					break;
				case 1027: 
					//$helpfile = getHelpfile(102);
					include('employees_all_logs.php'); 
					break;
				case 1028: 
					//$helpfile = getHelpfile(102);
					include('employees_archive_list.php'); 
					break;
				case 1029: 
					//$helpfile = getHelpfile(102);
					include('employee_modify_wages.php'); 
					break;
			}
		}else{
			header('location: ../login.php');
		} ?>
	
	<? include('../include/modal_relog.php')?>

	<script src="../assets/js/popper.min.js"></script>
	<script src="../assets/js/bootstrap.min.js"></script>
	<script src="../assets/js/jquery.dataTables.min.js"></script>
	<script src="../assets/js/dataTables.bootstrap4.min.js"></script>
	<script src="../assets/js/bootstrap-datepicker.min.js"></script>
	<script src="../assets/js/select2.min.js"></script>
	<? if($lang == 'th'){ ?>
	<script src="../assets/js/bootstrap-datepicker.th.js"></script>
	<? } ?>
	<script src="../assets/js/bootstrap-confirmation.js"></script>
	<script src="../assets/js/jquery.numberfield.js"></script>	
	<script src="../assets/js/jquery.mask.js"></script>	
	<script src="../assets/js/overhang.min.js?<?=time()?>"></script>
	<script src="../assets/js/jquery.autocomplete.js"></script>	
	<script src="../assets/js/jquery.sumoselect-menu.js"></script>
	<script src="../assets/js/rego.js?<?=time()?>"></script>

	<script src="../assets/js/jquery.sumoselect.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBV4OwtunNsg-_t446caGdt1QCBZQQhWUs"></script>

	
	<? include('../include/common_script.php')?>
	<? include('../include/main_menu_script.php')?>

<script type="text/javascript">


	var baseURl = '<?php echo $baseUrl ?>';
	var updateAnythingValue = '<?php echo $updateAnythingValue?>';


	 $('.select2').select2();

	 // show warning message when click on home 
	 function showWarning()
	 {	

	 	console.log(updateAnythingValue);
		if(updateAnythingValue)
		{

			$('#modalWarning').modal('show');
		}
		else
		{


 			$.ajax({
				url: "ajax/clearSelection.php",
				data:{},
				success: function(result){
					if(result == 'success'){
		 				window.location.href = baseURl+"index.php?mn=2";
					}
					else
					{
		 				window.location.href = baseURl+"index.php?mn=2";
					}
				},
			});

		}

	 }
	 // show warning message when click on back 
	 function showWarningOnBack()
	 {
	 	if(updateAnythingValue)
 		{
	 		$('#modalWarningOnBack').modal('show');
	 	}
		else
		{
			$.ajax({
				url: "ajax/clearSelection.php",
				data:{},
				success: function(result){
					if(result == 'success'){
		 				window.location.href = "index.php?mn=100";
					}
					else
					{
		 				window.location.href = "index.php?mn=100";
					}
				},
			});
		}
	 }

	 // run ajax to clear the selected data 
	 function changeThePage()
	 {


 	
 			$.ajax({
				url: "ajax/clearSelection.php",
				data:{},
				success: function(result){
					if(result == 'success'){
		 				window.location.href = baseURl+"index.php?mn=2";
					}
					else
					{
		 				window.location.href = baseURl+"index.php?mn=2";
					}
				},
			});
 		
 		




	 }	
	 // run ajax to clear the selected data 
	 function changeThePageBack()
	 {

 		

			$.ajax({
				url: "ajax/clearSelection.php",
				data:{},
				success: function(result){
					if(result == 'success'){
		 				window.location.href = "index.php?mn=100";
					}
					else
					{
		 				window.location.href = "index.php?mn=100";
					}
				},
			});
		

	 }
</script>
</body>
</html>








