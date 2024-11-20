<?php

	if(session_id()==''){session_start();} 
	ob_start();
	include('../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	include(DIR.'files/arrays_'.$_SESSION['rego']['lang'].'.php');
	include(DIR.'files/payroll_functions.php');

	$logger = false;
	$locked = true;
	$checkSetup = '';
	if(isset($_SESSION['rego']['cid']) && !empty($_SESSION['rego']['cid'])){
		if(isset($_SESSION['RGadmin'])){
			$logtime = 86000;
		}else{
			$logtime = (int)$comp_settings['logtime'];
		}
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
			
			$locked = getLockedMonth($_SESSION['rego']['gov_month']);
			//$_SESSION['rego']['locked'] = $locked;
			//$history_lock = getHistoryLock($cid);
			$SSOnewcal = getSSOEmpRate($cid);
			
			
			$history_lock = getHistoryLock();
			$_SESSION['rego']['paydate'] = langDate(getPaydate($cid), $lang);
			//$_SESSION['rego']['paydate'] = getPaydate($cid);
			getFormdate($cid);
			$checkSetup = checkSetupData($cid);
			
			//var_dump(langDate('12-12-2020', $lang));
		}
		if(!isset($_SESSION['rego']['pr_entities'])){
			$tmp = explode(',', $_SESSION['rego']['mn_entities']);
			getPayrollSelections($tmp[0]);
		}
		$entityBranches = getEntityBranches($_SESSION['rego']['gov_entity']);
		$branchCode = getBranchCode($_SESSION['rego']['gov_entity']);
		
	}

	/////////////////////////////// LOAD LAYOUT SETTINGS AND FUNCTIONS ////////////////////////////
	include("../admin/company_layout/common_layout_functions_system.php"); 
	/////////////////////////////// LOAD LAYOUT SETTINGS AND FUNCTIONS ////////////////////////////

	//var_dump($entityBranches);exit;
	//$bank = $compinfo['bank_name'];

?>

<!DOCTYPE html>
<html lang="en-us">
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
		<link rel="stylesheet" href="../assets/css/select2.min.css">
		<link rel="stylesheet" href="../assets/css/font-awesome.min.css">
		<link rel="stylesheet" href="../assets/css/line-awesome.min.css">
		<link rel="stylesheet" href="../assets/css/myStyle.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/navigation.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/bootstrap-datepicker.css?<?=time()?>" />
		<link rel="stylesheet" href="../assets/css/basicTable.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/myBootstrap.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/myForm.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/dataTables.bootstrap4.min.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/myDatatables.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/overhang.min.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/responsive.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/autocomplete.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/sumoselect-menu.css?<?=time()?>">

		<style type="text/css">
			.permissions{
				display: inline-block !important;
			}
		</style>
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
					if($_GET['mn'] == 400 || $_GET['mn'] == 420){ ?>

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
	
	<!--Desktop menu--------------------------------------------------------------------------------> 
	<div class="topnav-custom" <? echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['main_dashboard_color1']]['code']."";?>>
		<div class="btn-group" <? echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['main_dashboard_color2']]['code']."";?>> 
			<a href="../index.php?mn=2" class="home"><i class="fa fa-home"></i></a>
		</div>
		<div class="btn-group <? if($_GET['mn']==400){echo 'active';}?>" <? echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['main_dashboard_color2']]['code']."";?>>
			<a href="index.php?mn=400" class="home"><i class="fa fa-dashboard"></i></a>
		</div>
		
		
		
		<? if($_GET['mn'] != 400){ ?>
		<? if($_GET['mn'] == 420 || $_GET['mn'] == 430 || $_GET['mn'] == 440 || $_GET['mn'] == 441){ ?>
		<div class="btn-group" style="opacity:0">	
			<select id="govBox-entities">
				<? foreach($entities as $k=>$v){if(in_array($k, explode(',', $_SESSION['rego']['pr_entities']))){ ?>
				<option <? if($_SESSION['rego']['gov_entity'] == $k){echo 'selected';} ?> value="<?=$k?>"><?=$v[$lang]?></option>
				<? }} ?>
			</select>
		</div>	
		<? } ?>

		<? if(isset($_GET['sm']) && ($_GET['sm'] == 43 || $_GET['sm'] == 44)){ ?>
		<div class="btn-group" style="opacity:0">
	    <select id="govBox-branches">
				<? foreach($entityBranches as $k=>$v){ ?>
				<option <? if($_SESSION['rego']['gov_branch'] == $k){echo 'selected';} ?> value="<?=$k?>"><?=$v[$lang]?></option>
				<? } ?>
	    </select>
	    </div>
		<? } ?>

		<? if($_GET['mn'] >= 440 && $_GET['mn'] < 445){ ?>
			<? if(!$history_lock){ ?>
			<div class="btn-group <? if($_GET['mn']==441){echo 'active';}?>">
				<a href="index.php?mn=441&type=all"> <?=$lng['Create historic Payroll']?></a>
			</div>
			<? } ?>
			<div class="btn-group <? if($_GET['mn']==440){echo 'active';}?>">
				<a href="index.php?mn=440&type=add"> <?=$lng['Missing data employee']?></a>
			</div>
		<? } ?>
		<? } ?>
		
		<div class="btn-group" style="float:right;"> 
			<button style="padding:0 8px; background:<?php echo $savedAdminColors[$savedMainDashboardlayout['main_dashboard_color2']]['code'] ;?>; cursor:default">
				 <img style="height:35px; width:35px; display:inline-block; border-radius:0px; margin:-3px 0 0 0; border:0px solid #666" src="<?=ROOT.$_SESSION['rego']['img']?>?<?=time()?>">
			</button>
		</div>
		
		<div class="btn-group" style="float:right;background:<?php echo $savedAdminColors[$savedMainDashboardlayout['main_dashboard_color2']]['code'] ;?>"> 
			<button class="dropdown-toggle" data-toggle="dropdown">
				<? if(isset($period[$_SESSION['rego']['cur_month']])){
					echo $period[$_SESSION['rego']['cur_month']];
				}else{
					echo $lng['Select period'];//end($period);
				}?>
			</button>
			<div class="dropdown-menu">
				<? foreach($period as $k=>$v){ ?>
					<li><a class="dropdown-item selectMonth" data-id="<?=$k?>"><?=$v?></a></li>
				<? } ?>
			</div>
		</div>
		<? if($_GET['mn'] == 400 || $_GET['mn'] == 410 || $_GET['mn'] == 411 || $_GET['mn'] == 413){ 
			include('../include/main_menu_selection.php'); 
			 ?>
			
			<div class="btn-group" style="float:right;background:<?php echo $savedAdminColors[$savedMainDashboardlayout['main_dashboard_color2']]['code'] ;?>"> <!-- Lock period ----------------------------->
				<button class="dropdown-toggle" data-toggle="dropdown">
					<?=$lng['Lock period']?> <span class="caret"></span>
				</button>
					<div class="dropdown-menu">
				<? if($to_lock){
						foreach($to_lock as $k=>$v){ 
						echo '<a class="dropdown-item lockperiod" data-id="'.$k.'" href="#">'.$v.'</a>';
						}
					}else{
						echo '<a class="dropdown-item" href="#">'.$lng['All periods are locked'].'</a>';
					} ?>
					</div>
			</div>
			<div class="btn-group" style="float:right;background:<?php echo $savedAdminColors[$savedMainDashboardlayout['main_dashboard_color2']]['code'] ;?>"> <!-- Unlock period ------------------------------------------------->
				<button class="dropdown-toggle" data-toggle="dropdown">
					<?=$lng['Unlock period']?> <span class="caret"></span>
				</button>
					<div class="dropdown-menu">
					<? if(!empty($to_unlock)){ end($to_unlock); 
						echo '<a class="dropdown-item unlockperiod" data-id="'.key($to_unlock).'" href="#"><i class="fa fa-unlock-alt"></i>&nbsp;&nbsp;'.end($to_unlock).'</a>';
						} ?>
						<a class="dropdown-item delLastMonth" onClick="return false;" href="#"><i class="fa fa-trash"></i>&nbsp;&nbsp;<?=$lng['Delete unlocked months']?></a>
					</div>
			</div>
			<? //} ?>
			
			<? if($comp_settings['emp_group']){ ?>
			<? if($_SESSION['rego']['access_group'] == 'all'){ ?>
			<div class="btn-group"> 
				<button class="dropdown-toggle" data-toggle="dropdown">
					<span><?=$emp_group[$_SESSION['rego']['emp_group']]?></span> <span class="caret"></span>
				</button>
					<div class="dropdown-menu">
						<a class="dropdown-item empGroup" data-id="s" href="#"><?=$emp_group['s']?></a>
						<a class="dropdown-item empGroup" data-id="m" href="#"><?=$emp_group['m']?></a>
					</div>
			</div>
			<? }else{ ?>
			<div class="btn-group"> 
				<button>
					<span><?=$emp_group[$_SESSION['rego']['emp_group']]?></span>
				</button>
			</div>
			<? }} ?>
		
			<? if(!$locked){ ?>
			<!--<div class="btn-group">
				<a data-toggle="modal" data-target="#modalSelectPaydate" href="#"><?=$lng['Paydate']?> <span id="paydate"><? //=$_SESSION['rego']['paydate']?></span></a>
			</div>-->
			<? } ?>
		<? } ?>
	
	
	
	</div>
	
	<? if($logger){
			switch($_GET['mn']){
				case 400: 
					//$helpfile = getHelpfile(410);
					include('payroll_dashboard.php'); 
					break;
				case 410: 
					//$helpfile = getHelpfile(410);
					include('payroll_calculator.php'); 
					break;
				case 413: 
					$helpfile = getHelpfile(410);
					include('payroll_calculator_tabs.php'); 
					break;
				case 411: 
					$helpfile = getHelpfile(411);
					include('monthly_payroll_summary.php'); 
					break;
				case 420: 
					$helpfile = getHelpfile(420);
					include('export/export_center.php'); 
					break;
				case 421: 
					$helpfile = getHelpfile(420);
					include('export/sso_overview.php'); 
					break;
				case 422: 
					//$helpfile = getHelpfile(420);
					include('export/edit_sso.php'); 
					break;
				case 431: 
					//$helpfile = getHelpfile(420);
					include('export/revenu_department.php'); 
					break;
				case 432: 
					//$helpfile = getHelpfile(420);
					include('export/revenu_department_edit.php'); 
					break;


				case 412: 
					//$helpfile = getHelpfile(411);
					include('payroll_approval.php'); 
					break;

				case 414: 
					//$helpfile = getHelpfile(411);
					include('payroll_logs.php'); 
					break;
				
				case 430: 
					//$helpfile = getHelpfile(430);
					include('gov_forms/gov_forms.php'); 
					break;
				case 440: 
					$helpfile = getHelpfile(440);
					include('historic/historical_data.php'); 
					break;
				case 441: 
					$helpfile = getHelpfile(440);
					include('historic/historical_data.php'); 
					break;
				case 460: 
					//$helpfile = getHelpfile(430);
					include('../archive/archive_center.php'); 
					break;
			}
		}else{
			header('location: ../login.php');
		} ?>
	
	<!-- Modal SelectPaydate -->
	<div class="modal fade" id="modalSelectPaydate" tabindex="-1" role="dialog">
		<div class="modal-dialog" style="width:250px; margin:0 auto; margin-top:20px">
			<div class="modal-content">
				<div class="modal-body">
					<div style="background:#880000; color:#fff; padding:5px 10px; font-weight:bold; text-align:center"><?=$lng['Select paydate']?></div>
					<div data-date="<?=$_SESSION['rego']['paydate']?>" id="modal_paydate"></div>
				</div>
			</div>
		</div>
	</div>

	<? include('../include/modal_relog.php')?>

	<script src="../assets/js/popper.min.js"></script>
	<script src="../assets/js/bootstrap.min.js"></script>
	<script src="../assets/js/jquery.dataTables.min.js"></script>
	<script src="../assets/js/dataTables.bootstrap4.min.js"></script>
	<script src="../assets/js/bootstrap-datepicker.min.js"></script>
	<? if($lang == 'th'){ ?>
	<script src="../assets/js/bootstrap-datepicker.th.js"></script>
	<? } ?>
	<script src="../assets/js/bootstrap-confirmation.js"></script>
	<script src="../assets/js/jquery.numberfield.js"></script>	
	<script src="../assets/js/jquery.mask.js"></script>	
	<script src="../assets/js/overhang.min.js?<?=time()?>"></script>
	<script src="../assets/js/jquery.sumoselect-menu.js"></script>
	<script src="../assets/js/rego.js?<?=time()?>"></script>
	<script src="../assets/js/jquery.sumoselect.js"></script>
	<script src="../assets/js/select2.min.js"></script>

	<? include('../include/common_script.php')?>
	<? include('../include/main_menu_script.php')?>

<script type="text/javascript">
		
	$(document).ready(function() {
		
		$('.lockperiod').confirmation({
			container: 'body',
			rootSelector: '.lockperiod',
			singleton: true,
			animated: 'fade',
			placement: 'bottom',
			popout: true,
			html: true,
			title 			: '<?=$lng['Are you sure']?>',
			btnOkClass 		: 'btn btn-danger',
			btnOkLabel 		: '<?=$lng['Lock']?>',
			btnCancelClass 	: 'btn btn-success',
			btnCancelLabel 	: '<?=$lng['Cancel']?>',
			onConfirm: function() { 
				//alert(id);
				$.ajax({
					url: "ajax/lock_period.php",
					data:{id: $(this).data('id')},
					success: function(result){
						//alert(result)
						location.replace('index.php?mn=410');
					},
					error:function (xhr, ajaxOptions, thrownError){
						alert('3 '+thrownError);
					}
				});
			},
		});
		
		$(".unlockperiod").click(function(){ 
			var id = $(this).data('id');
			$.ajax({
				url: "ajax/unlock_period.php",
				data:{id:id },
				success: function(result){
					//alert(result)
					location.reload();
				},
				error:function (xhr, ajaxOptions, thrownError){
					alert('4 '+thrownError);
				}
			});
		});
		
				
		$('.delLastMonth').confirmation({
			container: 'body',
			rootSelector: '.delLastMonth',
			singleton: true,
			animated: 'fade',
			placement: 'bottom',
			popout: true,
			html: true,
			title 			: '<?=$lng['Are you sure']?>',
			btnOkClass 		: 'btn btn-danger',
			btnOkLabel 		: '<?=$lng['Delete']?>',
			btnCancelClass 	: 'btn btn-success',
			btnCancelLabel 	: '<?=$lng['Cancel']?>',
			onConfirm: function() { 
				//alert(id);
				$.ajax({
					url: "ajax/delete_last_month_from_payroll.php",
					success: function(result){
						//alert(result)
						location.reload();
					},
					error:function (xhr, ajaxOptions, thrownError){
						alert('5 '+thrownError);
					}
				});
			},
		});
		
		/*$('#modal_paydate').datepicker({
			format: "dd-mm-yyyy",
			autoclose: false,
			//inline: true,
			language: lang,
			todayHighlight: true
		}).on('changeDate', function(e){
			var date = e.format('dd-mm-yyyy');
			$.ajax({
				url: "ajax/update_paydate.php",
				data: {date:date},
				success:function(response){
					//$('#dump').html(response)
					$('#paydate').html(date);
					setTimeout(function(){$('#modalSelectPaydate').modal('toggle');},100);
				},
				error:function (xhr, ajaxOptions, thrownError){
					alert('2 '+thrownError);
				}
			});
		})*/


		$(".hourFormat").mask("999:99", {placeholder: "000:00"});

	});

	/*function replace_comma(n)
	{
		var a = n.toString().replace(',', '');
		var b = a.toString().replace(',', '');
		var b = b.toString().replace(',', '');
		var b = b.toString().replace(',', '');
		var b = b.toString().replace(',', '');
		return b;
	}*/

	/*function number_format(n1) { //
		
		if($.isNumeric(n1) && n1 > 0){ 
			n = replace_comma(n1);
			if(n.toString().indexOf('.') == -1){ 
				
				return parseFloat(n).toFixed(2).replace(/./g, function(c, i, a) { 
			        return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
			    });
				
			}else{ 
				return n.toString().replace(/./g, function(c, i, a) {
			        return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
			    });
			}
		}else{ 
			var vv = 0.00;
			return vv;
		}
	}*/

	function number_format(inval){
		let resform=parseInt(inval)/1000,aftdec=(inval + "").split(".");
		if(aftdec[1]==undefined)aftdec[1]='00';
		for(let i2=0;i2<aftdec[1].length-2;i2++)
			if(aftdec[1]%10>4)
				aftdec[1]=parseInt(aftdec[0].slice(0,aftdec[0].length-1))+1;
			else aftdec[1]= aftdec[0].slice(0,aftdec[0].length-1);
		if(aftdec[1]==100){
			aftdec[1]='00';
			aftdec[0]=parseInt(aftdec[0])+1;
		}
		
		let str=padafter(aftdec[1],2);
		if(parseInt(aftdec[0])>0){
			if(parseInt(aftdec[0])<1000){
				str=pad(aftdec[0],3)+'.'+str;
			}else{
				resform=aftdec[0];
				str=pad(aftdec[0]%1000,3)+'.'+str;
			}
		}else str=0+'.'+str;
		for(let i1=0;parseInt(resform)>=1000;i1+=3){
			resform=parseInt(parseInt(resform)/1000);
			str=pad(parseInt(resform),3)+','+str;
		}
		//console.log(str);
		if(str.length>6)
		str=parseInt(str.slice(0,3))+str.slice(3,str.length);
		//console.log(str);
		return str;
	}

	function pad(num, size) {
	    var s = "0000000000000000000000" + num;
	    return s.substr(s.length-size);
	}
	
	function padafter(num,size){
		var s =  num+"0000000000000000000000" ;
	    return s.substr(0,size);
	}
	
</script>
<script type="text/javascript">
	 $('.select3').select2();
</script>
	
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








