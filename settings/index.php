<?php

	if(session_id()==''){session_start();} 
	ob_start();
	include('../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	include(DIR.'files/arrays_'.$lang.'.php');
	//include(DIR.'time/functions.php');

	$getParametersName = getParameters(); //Dynamic name for tab
	

	// echo '<pre>';
	// print_r($getParametersName);
	// echo '<pre>';

	// echo $getParametersName[1]['en'];
	// exit;

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
			$years = getYears(); // Get payroll Years
			$checkSetup = checkSetupData($cid);
			
		}
	}
	//var_dump($checkSetup); exit;
	include(DIR.'settings/create_communication_center_tables.php'); //create tables...

	/////////////////////////////// LOAD LAYOUT SETTINGS AND FUNCTIONS ////////////////////////////
	include("../admin/company_layout/common_layout_functions_system.php"); 
	/////////////////////////////// LOAD LAYOUT SETTINGS AND FUNCTIONS ////////////////////////////

		// echo '<pre>';
	// print_r($savedMainDashboardlayout);
	// echo '</pre>';

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
		<link rel="stylesheet" href="../assets/css/bootstrap-datepicker.css?<?=time()?>" />
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/line-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/myStyle.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/navigation.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/basicTable.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/myBootstrap.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/myForm.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/dataTables.bootstrap4.min.css">
		<link rel="stylesheet" href="../assets/css/myDatatables.css">
		<link rel="stylesheet" href="../assets/css/overhang.min.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/responsive.css?<?=time()?>">

		<link rel="stylesheet" href="../assets/css/sumoselect.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/autocomplete.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/main.css?<?=time()?>">

		<? if($_GET['mn'] >= 310 && $_GET['mn'] <= 317){?>
			<link rel="stylesheet" type="text/css" media="screen" href="../assets/css/erpStyle.css?<?=time()?>">
		<? } ?>
	
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
					if($_GET['mn'] == 600){ ?>

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
			<a <? echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['main_dashboard_color2']]['code']."";?> href="../index.php?mn=2" class="home"><i class="fa fa-home"></i></a>
		</div>
		<div class="btn-group <? if($_GET['mn']==600){echo 'active';}?>">

			<?php 
			if($_GET['mn']==7000 || $_GET['mn']==7001){ ?>

				<a <? echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['main_dashboard_color2']]['code']."";?> href="index.php?mn=607" class="home"><i class="fa fa-dashboard"></i></a>

			<?php }elseif($_GET['mn'] >= 310 && $_GET['mn'] <= 317){  ?>

				<a <? echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['main_dashboard_color2']]['code']."";?> href="index.php?mn=300" class="home"><i class="fa fa-dashboard"></i></a>

			<?php }else{ ?>

				<a <? echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['main_dashboard_color2']]['code']."";?> href="index.php?mn=600" class="home"><i class="fa fa-dashboard"></i></a>

			<?php } ?>
		</div>
		
		<? if($_GET['mn'] >= 6010 && $_GET['mn'] <= 6018 || $_GET['mn'] >= 6020 && $_GET['mn'] <= 6022){ ?>
			<div class="btn-group <? if($_GET['mn']==6010){echo 'active';}?>">
				<a href="index.php?mn=6010"><?=$lng['Subscription']?></a>
			</div>
			<div class="btn-group <? if($_GET['mn']==6011){echo 'active';}?>">
				<!-- <a href="index.php?mn=6011"><?=$lng['Entities']?></a> -->
				<a href="index.php?mn=6011"><?=$lng['Company']?></a>
			</div>

			<div class="btn-group <? if($_GET['mn']==6020){echo 'active';}?>">
				<a href="index.php?mn=6020"><?=$lng['Parameters']?></a>
			</div>
			<?if($getParametersName[1]['apply_param'] || $getParametersName[2]['apply_param'] || $getParametersName[3]['apply_param'] || $getParametersName[4]['apply_param'] || $getParametersName[5]['apply_param'] == 1){ ?>
				<div class="btn-group <? if($_GET['mn']==6021){echo 'active';}?>">
					<a href="index.php?mn=6021"><?=$lng['Organization']?></a>
				</div>
			<? } ?>
			
			<?if($getParametersName[1]['apply_param'] == 1){ ?>
				<div class="btn-group <? if($_GET['mn']==6012){echo 'active';}?>">
					<a href="index.php?mn=6012"><?=$getParametersName[1][$lang]?></a>
				</div>
			<? } ?>
			<? if($_SESSION['rego']['standard'][$standard]['set_divisions']){ ?>
				<?if($getParametersName[2]['apply_param'] == 1){?>
					<div class="btn-group <? if($_GET['mn']==6017){echo 'active';}?>">
						<!-- <a href="index.php?mn=6017"><?=$lng['Divisions']?></a> -->
						<a href="index.php?mn=6017"><?=$getParametersName[2][$lang]?></a>
					</div>
				<? } ?>
			<? } if($_SESSION['rego']['standard'][$standard]['set_departments']){ ?>
				<?if($getParametersName[3]['apply_param'] == 1){?>
					<div class="btn-group <? if($_GET['mn']==6013){echo 'active';}?>">
						<!-- <a href="index.php?mn=6013"><?=$lng['Departments']?></a> -->
						<a href="index.php?mn=6013"><?=$getParametersName[3][$lang]?></a>
					</div>
				<? } ?>
			<? } ?>

			<?if($getParametersName[4]['apply_param'] == 1){?>
				<div class="btn-group <? if($_GET['mn']==6014){echo 'active';}?>">
					<a href="index.php?mn=6014"><?=$getParametersName[4][$lang]?></a>
				</div>
			<? } ?>
			
			<?if($getParametersName[5]['apply_param'] == 1){?>
				<div class="btn-group <? if($_GET['mn']==6018){echo 'active';}?>">
					<!-- <a href="index.php?mn=6018"><?=$lng['Groups']?></a> -->
					<a href="index.php?mn=6018"><?=$getParametersName[5][$lang]?></a>
				</div>
			<? } ?>
			<div class="btn-group <? if($_GET['mn']==6015){echo 'active';}?>">
				<a href="index.php?mn=6015"><?=$lng['Positions']?></a>
			</div>

			<!--<div class="btn-group <? if($_GET['mn']==6022){echo 'active';}?>">
				<a href="index.php?mn=6022"><?=$lng['Update Emp. Register']?></a>
			</div>-->
		<? } ?>
		
		<? if($_GET['mn'] == 603 || $_GET['mn'] == 604 || $_GET['mn'] == 611 || $_GET['mn'] == 612){ ?>
			<div class="btn-group <? if($_GET['mn']==603){echo 'active';}?>">
				<a href="index.php?mn=603"><?=$lng['System users']?></a>
			</div>

			<div class="btn-group <? if($_GET['mn']==611){echo 'active';}?>">
				<a href="index.php?mn=611"><?=$lng['Company users']?></a>
			</div>

			<? if($_SESSION['rego']['max'] >= 10){ ?>	
			<div class="btn-group <? if($_GET['mn']==604){echo 'active';}?>">
				<a href="index.php?mn=604"><?=$lng['Employee users']?></a>
			</div>

			<div class="btn-group <? if($_GET['mn']==612){echo 'active';}?>">
				<a href="index.php?mn=612"><?=$lng['Activity']?></a>
			</div>

			<? } ?>

		
		<? } ?>
		
		<? if($_GET['mn'] == 605 || $_GET['mn'] == 606){ ?>
		<div class="btn-group <? if($_GET['mn']==605){echo 'active';}?>">
			<a href="index.php?mn=605"><?=$lng['Accounting Codes']?></a>
		</div>
		<div class="btn-group <? if($_GET['mn']==606){echo 'active';}?>">
			<a href="index.php?mn=606"><?=$lng['Accounting Allocations']?></a>
		</div>
		<? } ?>
		
		<div class="btn-group hide-480" style="float:right;"> 
			<button style="padding:0 8px; background:<?php echo $savedAdminColors[$savedMainDashboardlayout['main_dashboard_color2']]['code'] ;?>;cursor:default">
				 <img style="height:35px; width:35px; display:inline-block; border-radius:0px; margin:-3px 0 0 0; border:0px solid #666" src="<?=ROOT.$_SESSION['rego']['img']?>">
			</button>
		</div>
		
		<? if(count($years) > 1){ ?>	<!-- Change year ---------------------------------------------------------------------->
		<div class="btn-group" style="float:right">
			<button class="dropdown-toggle" data-toggle="dropdown">
				<?=$lng['Year'].' '.$_SESSION['rego']['year_'.$lang]?>
			</button>
			<div class="dropdown-menu">
				<? foreach($years as $k=>$v){ ?>
				<a data-year="<?=$k?>" class="dropdown-item changeYear"><?=$v?></a>
				<? } ?>
			</div>
		</div>
		<? } ?>
		
	</div>
	
	<? if($logger){
			switch($_GET['mn']){
				case 600: 
					include('sys_dashboard.php'); 
					break;
				
				case 6010: 
					$helpfile = getHelpfile(6010);
					include('company/company.php'); 
					break;
				case 6011: 
					//$helpfile = getHelpfile(640);
					include('company/entities.php'); 
					break;
				case 6012: 
					//$helpfile = getHelpfile(640);
					include('company/branches.php'); 
					break;
				case 6013: 
					//$helpfile = getHelpfile(640);
					include('company/departments.php'); 
					break;
				case 6014: 
					//$helpfile = getHelpfile(640);
					include('company/teams.php'); 
					break;
				case 6018: 
					//$helpfile = getHelpfile(640);
					include('company/groups.php'); 
					break;
				case 6015: 
					//$helpfile = getHelpfile(640);
					include('company/positions.php'); 
					break;
				case 6016: 
					//$helpfile = getHelpfile(640);
					//include('company/groups.php'); 
					break;
				case 6017: 
					//$helpfile = getHelpfile(640);
					include('company/divisions.php'); 
					break;
				case 6020: 
					//$helpfile = getHelpfile(640);
					include('company/parameters.php'); 
					break;
				case 6019: 
					//$helpfile = getHelpfile(640);
					include('access_rights.php'); 
					break;
				case 6021: 
					//$helpfile = getHelpfile(640);
					include('company/organization.php'); 
					break;
				case 6022: 
					//$helpfile = getHelpfile(640);
					include('company/update_emp_register.php'); 
					break;


				case 602: 
					$helpfile = getHelpfile(602);
					include('employee_defaults.php'); 
					break;
				case 603: 
					$helpfile = getHelpfile(630);
					include('system_users.php'); 
					break;
				case 604: 
					$helpfile = getHelpfile(632);
					include('employee_users.php'); 
					break;
				case 605: 
					$helpfile = getHelpfile(651);
					include('accounting_codes.php'); 
					break;
				
				case 610: 
					$helpfile = getHelpfile(610);
					include('payroll_settings.php'); 
					break;
				case 613: 
					//$helpfile = getHelpfile(652);
					include('benefits_model.php'); 
					break;
				case 611: 
					//$helpfile = getHelpfile(652);
					include('company_users.php'); 
					break;
				case 612: 
					//$helpfile = getHelpfile(652);
					include('activity.php'); 
					break;
				
				case 6055: 
					include('system_users_extended.php'); 
					break;
					
				case 606: 
					$helpfile = getHelpfile(651);
					include('accounting_allocation.php'); 
					break;
				case 607: 
					$helpfile = getHelpfile(607);
					include('time_settings.php'); 
					break;
				case 608: 
					$helpfile = getHelpfile(608);
					include('leave_settings.php'); 
					break;
				case 609: 
					//$helpfile = getHelpfile(652);
					include('public_holidays.php'); 
					break;
				case 7000: 
					include('edit_shift_schedule.php'); 
					break;	
				case 7001: 
					include('edit_branch_locations.php'); 
					break;

				case 701: 
					include('default_allow_deduct.php'); 
					break;
				case 702: 
					include('default_compensations.php'); 
					break;
				case 703: 
					include('view_benefit_models.php'); 
					break;

				case 704: 
					include('view_payroll_models.php'); 
					break;

				case 300:
					$helpfile = getHelpfile(300); 
					include('document_setup/doc_dashboard.php'); break;
				case 301: 
					include('document_setup/header_list.php'); break;
				case 302: 
					include('document_setup/footer_list.php'); break;
				case 303: 
					include('document_setup/textblocks_list.php'); break;


				
				case 310: 
					include('document_setup/erp_header.php'); break;
				case 311: 
					include('document_setup/erp_footer.php'); break;
				case 312: 
					include('document_setup/erp_textblocks.php'); break;
				

				// case 311: 
				// 	include('document_setup/erp_documents.php'); break;
				// case 312: 
				// 	include('document_setup/erp_header.php'); break;
				// case 313: 
				// 	include('document_setup/erp_header.php'); break;
				case 314: 
					include('document_setup/erp_invoice_template.php'); break;
				// case 315: 
				// 	include('document_setup/erp_header.php'); break;
				
				case 317: 
					include('document_setup/erp_body.php'); break;
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
	<script src="../assets/js/bootstrap-confirmation.js"></script>
	<script src="../assets/js/jquery.numberfield.js"></script>	
	<script src="../assets/js/jquery.mask.js"></script>	
	<script src="../assets/js/overhang.min.js"></script>
	<script src="../assets/js/rego.js?<?=time()?>"></script>
	<script src="../assets/js/moment.min.js"></script>
	<script src="../assets/js/jquery.sumoselect.js"></script>
	<script src="../assets/js/jquery-clockpicker.min.js"></script>
	<script src="../assets/js/moment.min.js"></script>
	<script src='../assets/js/moment-duration-format.min.js'></script>
	<script src='../assets/js/fullcalendar.js'></script>
	<script src='../assets/js/main.js'></script>
	<? if($lang == 'th'){ ?>
	<script src="../assets/js/fullcalendar-th.js?<?=time()?>"></script>
	<? } ?>
	
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBV4OwtunNsg-_t446caGdt1QCBZQQhWUs"></script>

		<script>



		$('.ssdatepick').datepicker({
			format: "dd/mm/yyyy",
			autoclose: true,
			inline: true,
			language: '<?=$lang?>',
			todayHighlight: true,
		});

		// $( document ).ready(function() {
		// 	$('#startdate').val('Select Start Date ');
		// });
	</script>

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








