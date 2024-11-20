<?php





	if(session_id()==''){session_start();} 

	// 	echo '<pre>';
	// print_r($_SESSION);
	// echo '</pre>';
	// die();



	ob_start();
	include('../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	include(DIR.'leave/functions.php');
	include(DIR.'time/functions.php');
	include(DIR.'files/arrays_'.$_SESSION['rego']['lang'].'.php');



	// echo '<pre>';
	// print_r($_SESSION);
	// echo '</pre>';
	// die();


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

	// echo '<pre>';
	// print_r($teams);
	// echo '</pre>';
	// die();
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

</head>
<style type="text/css">
	


.mnSumoSelect p {margin: 0;}
.mnSumoSelect{width: auto;}

.SelectBox {
	padding: 5px 8px;
}

.sumoStopScroll{overflow:hidden;}

/* Filtering style */
.mnSumoSelect .hidden { display:none; }
.mnSumoSelect .search-txt{display:none;outline:none;}
.mnSumoSelect .no-match{display:none;padding: 6px;}

.mnSumoSelect.open .search-txt {
display: inline-block;
position: absolute;
top: 0;
left: 0;
width: 100%;
margin: 0;
padding: 0 15px !important;
border: none;
-webkit-box-sizing: border-box;
-moz-box-sizing: border-box;
box-sizing: border-box;
border-radius: 0;
background-color: #080;
color:#fff;
font-size:13px;
}

.mnSumoSelect.open .search-txt::-webkit-input-placeholder {
color: #aca;
}
.mnSumoSelect.open .search-txt:-moz-placeholder {
color:#aca;
}
.mnSumoSelect.open .search-txt::-moz-placeholder {
color:#aca;
}
.mnSumoSelect.open .search-txt:-ms-input-placeholder {
color:#aca;
}			




.mnSumoSelect.open>.search>span, .mnSumoSelect.open>.search>label{visibility:hidden; cursor:pointer}

/*this is applied on that hidden select. DO NOT USE display:none; or visiblity:hidden; and Do not override any of these properties. */
.SelectClass,.SumoUnder { position: absolute; top: 0; left: 0; right: 0; height: 100%; width: 100%; border: none; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; filter: alpha(opacity=0); -moz-opacity: 0; -khtml-opacity: 0; opacity: 0; }
.SelectClass{z-index: 1;}

.mnSumoSelect > .optWrapper > .options  li.opt label, .mnSumoSelect > .CaptionCont,.mnSumoSelect .select-all > label { user-select: none; -o-user-select: none; -moz-user-select: none; -khtml-user-select: none; -webkit-user-select: none; }

.mnSumoSelect { display: inline-block; position: relative;outline:none;}

.mnSumoSelect:focus > .CaptionCont,.mnSumoSelect:hover > .CaptionCont, .mnSumoSelect.open > .CaptionCont {xbox-shadow: 0 0 2px #7799D0;border-color: #7799D0}

.mnSumoSelect > .CaptionCont { 
position: relative; 
border: 0px solid #A4A4A4; 
line-height: 40px; 
background-color: #000;
color:#fff;
border-radius:0px;
margin:0;
padding:0 0 0 15px !important;
font-size:13px;
}
.mnSumoSelect > .CaptionCont:hover { 
background-color: #080;
}

.mnSumoSelect > .CaptionCont > span { 
display: block; 
padding-right: 30px; 
xtext-overflow: ellipsis; 
white-space: nowrap; 
overflow: hidden;
cursor: pointer;
}

/*placeholder style*/
.mnSumoSelect > .CaptionCont > span.placeholder { 
xcolor: #ccc; 
xfont-style: italic; 
}

.mnSumoSelect > .CaptionCont > label { position: absolute; top: 0; right: 0; bottom: 0; width: 30px;}
.mnSumoSelect > .CaptionCont > label > i { 
background-image: url('../../images/caret_down_mn.png');
background-position: center center;
width: 11px; 
height: 7px; 
display: block; 
position: absolute; 
top: 0; 
left: 0; 
right: 0; 
bottom: 0; 
margin: auto;
background-repeat: no-repeat;
opacity: 1;
}

.mnSumoSelect > .optWrapper {
display:none; 
z-index: 1000; 
top: 100%; 
width: 220px; 
position: absolute; 
left: 0; 
-webkit-box-sizing: border-box; 
-moz-box-sizing: border-box; 
box-sizing: border-box; 
background: #fff; 
border: 0px solid #ddd; 
box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
border-radius: 0px;
overflow: hidden;
padding:0px;
font-size:13px;
color:#000;
}

.mnSumoSelect.open > .optWrapper {
top:100%; 
display:block;
overflow-y: hidden;
}

.mnSumoSelect.open > .optWrapper.up {top: auto;bottom: 100%;margin-bottom: 5px;}

.mnSumoSelect > .optWrapper ul {
list-style: none; 
display: block; 
padding: 0; 
margin: 0; 
overflow-y: auto;
background:#fff;
}
.mnSumoSelect > .optWrapper > .options { 
border-radius: 2px;
position:relative;
/*Set the height of pop up here (only for desktop mode)*/
max-height: 200px;
}
*/

.mnSumoSelect > .optWrapper.okCancelInMulti > .options { border-radius: 2px 2px 0 0;}
.mnSumoSelect > .optWrapper.selall > .options { border-radius: 0 0 2px 2px;}
.mnSumoSelect > .optWrapper.selall.okCancelInMulti > .options { border-radius: 0;}

.mnSumoSelect > .optWrapper > .options li.group.disabled > label{opacity:0.5;}
.mnSumoSelect > .optWrapper > .options li ul li.opt{padding-left: 22px;}

.mnSumoSelect > .optWrapper.multiple > .options li ul li.opt{padding-left: 50px;}

.mnSumoSelect > .optWrapper.isFloating > .options {max-height: 100%;box-shadow: 0 0 100px #595959;}

.mnSumoSelect > .optWrapper > .options  li.opt { 
position: relative;
border-bottom: 1px solid #eee;
line-height:24px;
padding:0 0 0 15px;
}

.mnSumoSelect > .optWrapper > .options > li.opt:first-child { border-radius: 2px 2px 0 0; }
.mnSumoSelect > .optWrapper.selall > .options > li.opt:first-child { border-radius:0; }
.mnSumoSelect > .optWrapper > .options > li.opt:last-child {border-radius: 0 0 2px 2px; border-bottom: none;}
.mnSumoSelect > .optWrapper.okCancelInMulti > .options > li.opt:last-child {border-radius: 0;}

.mnSumoSelect > .optWrapper > .options li.opt:hover { 
background-color: #f9f9f9;
}

.mnSumoSelect > .optWrapper > .options li.opt.sel, .mnSumoSelect .select-all.sel{background-color: #a1c0e4;}

.mnSumoSelect > .optWrapper > .options li label { text-overflow: ellipsis; white-space: nowrap; overflow: hidden; display: block;cursor: pointer;}
.mnSumoSelect > .optWrapper > .options li span { display: none; }
.mnSumoSelect > .optWrapper > .options li.group > label {cursor: default;padding: 8px 6px;font-weight: bold;}

/*Floating styles*/
.mnSumoSelect > .optWrapper.isFloating { position: fixed; top: 0; left: 0; right: 0; width: 90%; bottom: 0; margin: auto; max-height: 90%; }

/*disabled state*/
.mnSumoSelect > .optWrapper > .options li.opt.disabled { background-color: inherit;pointer-events: none;}
.mnSumoSelect > .optWrapper > .options li.opt.disabled * { -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)"; /* IE 5-7 */ filter: alpha(opacity=50); /* Netscape */ -moz-opacity: 0.5; /* Safari 1.x */ -khtml-opacity: 0.5; /* Good browsers */ opacity: 0.5; }


/*styling for multiple select*/
.mnSumoSelect > .optWrapper.multiple > .options li.opt { padding-left: 35px;cursor: pointer;}
.mnSumoSelect > .optWrapper.multiple > .options li.opt span,
.mnSumoSelect .select-all > span{position:absolute;display:block;width:30px;top:0;bottom:0;margin-left:-35px;}
.mnSumoSelect > .optWrapper.multiple > .options li.opt span i,
.mnSumoSelect .select-all > span i{position: absolute;margin: auto;left: 0;right: 0;top: 0;bottom: 0;width: 14px;height: 14px;border: 1px solid #AEAEAE;border-radius: 2px;box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.15);background-color: #fff;}
.mnSumoSelect > .optWrapper > .MultiControls { display: none; border-top: 1px solid #ddd; background-color: #fff; box-shadow: 0 0 2px rgba(0, 0, 0, 0.13); border-radius: 0 0 3px 3px; }
.mnSumoSelect > .optWrapper.multiple.isFloating > .MultiControls { display: block; margin-top: 5px; position: absolute; bottom: 0; width: 100%; }

.mnSumoSelect > .optWrapper.multiple.okCancelInMulti > .MultiControls { display: block; }
.mnSumoSelect > .optWrapper.multiple.okCancelInMulti > .MultiControls > p { padding: 6px; }
.mnSumoSelect > .optWrapper.multiple.okCancelInMulti > .MultiControls > p:focus {
box-shadow: 0 0 2px #a1c0e4;
border-color: #a1c0e4;
outline: none;
background-color: #a1c0e4;
}

.mnSumoSelect > .optWrapper.multiple > .MultiControls > p { 
display: inline-block; 
cursor: pointer; 
padding: 4px !important; 
width: 50%; 
box-sizing: border-box; 
text-align: center;
background:#f9f9f9; 
}
.mnSumoSelect > .optWrapper.multiple > .MultiControls > p:hover { 
background-color: #ddd; 
}


.mnSumoSelect > .optWrapper.multiple > .MultiControls > p.btnOk { border-right: 1px solid #DBDBDB; border-radius: 0 0 0 3px; }
.mnSumoSelect > .optWrapper.multiple > .MultiControls > p.btnCancel { border-radius: 0 0 3px 0; }
/*styling for select on popup mode*/
.mnSumoSelect > .optWrapper.isFloating > .options li.opt { padding: 12px 6px; }

/*styling for only multiple select on popup mode*/
.mnSumoSelect > .optWrapper.multiple.isFloating > .options li.opt { padding-left: 35px; }
.mnSumoSelect > .optWrapper.multiple.isFloating { padding-bottom: 43px; }

.mnSumoSelect > .optWrapper.multiple > .options li.opt.selected span i,
.mnSumoSelect .select-all.selected > span i,
.mnSumoSelect .select-all.partial > span i{background-color: rgb(17, 169, 17);box-shadow: none;border-color: transparent;background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAgAAAAGCAYAAAD+Bd/7AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNXG14zYAAABMSURBVAiZfc0xDkAAFIPhd2Kr1WRjcAExuIgzGUTIZ/AkImjSofnbNBAfHvzAHjOKNzhiQ42IDFXCDivaaxAJd0xYshT3QqBxqnxeHvhunpu23xnmAAAAAElFTkSuQmCC');background-repeat: no-repeat;background-position: center center;}
/*disabled state*/
.mnSumoSelect.disabled { opacity: 0.7;cursor: not-allowed;}
.mnSumoSelect.disabled > .CaptionCont{border-color:#ccc;box-shadow:none;}




/**Select all button**/
.mnSumoSelect .select-all {
border-radius: 0;
position: relative;
border-bottom: 1px solid #ddd;
background-color: #f9f9f9;
padding: 0 0 0 35px !important;
line-height: 28px !important;
cursor: pointer;
}
.mnSumoSelect .select-all:hover {
background-color: #ddd;
}
.mnSumoSelect .select-all > label, .mnSumoSelect .select-all > span i{
cursor: pointer;
}
.mnSumoSelect .select-all.partial > span i{
background-color:#ccc;
}


/*styling for optgroups*/
.mnSumoSelect > .optWrapper > .options li.optGroup { padding-left: 5px; text-decoration: underline; }


::-webkit-scrollbar {
width: 6px;
height: 6px;
}
/* Track */
::-webkit-scrollbar-track {
x-webkit-box-shadow: inset 0 0 5px rgba(0,0,0,0.3); 
background:#eee;
}
/* Handle */
::-webkit-scrollbar-thumb {
background:rgba(0,0,0,0.1); 
x-webkit-box-shadow: inset 0 0 3px rgba(0,0,0,0.5); 
}
::-webkit-scrollbar-thumb:window-inactive {
background: rgba(0,0,0,0.05); 
}

</style>

<body>
		
	<? include(DIR.'include/main_header.php');?>
	
	<div class="topnav-custom" <? echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['main_dashboard_color1']]['code']."";?>>
		<div class="btn-group" <? echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['main_dashboard_color2']]['code']."";?>> 
			<a href="../index.php?mn=2" class="home"><i class="fa fa-home"></i></a>
		</div>
		<div class="btn-group " <? echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['main_dashboard_color2']]['code']."";?>>
			<a href="time_dashboard.php?mn=7007" class="home"><i class="fa fa-dashboard"></i></a>
		</div>
			


<style type="text/css">
	.margin_left{
		margin-left: 1px!important;
	}
</style>
<? if($userType == 'appr' ) {
	if($sessionTeams != '')
	{
	?>
		<div class="btn-group permissions margin_left" style="">
		<select multiple="multiple" id="selBox-teams" name="selBoxteams" <? echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['main_dashboard_color2']]['code']."";?>>
			<? 

				$teamDD = array();
				foreach($aprTeam as $key =>$teamD){ 

					if(in_array($teamD, $sesTeamArray)){
						$teamDD[] = $teamD;
					}
				?>
				<option <?php if(in_array($teamD, $teamDD)) { echo "selected";} ?>  value="<?php echo $teamD;?>"><?php echo $teamD ;?></option>
			<?  } ?>
	    </select>
		</div>
<?php }
else { ?>

<div class="btn-group permissions margin_left" style="">
		<select multiple="multiple" id="selBox-teams" name="selBoxteams" <? echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['main_dashboard_color2']]['code']."";?>>
			<? foreach($aprTeam as $key =>$teamD){ 
				?>
				<option selected="selected" value="<?php echo $teamD;?>"><?php echo $teamD ;?></option>
			<?  } ?>
	    </select>
</div>


<? } }?>




<? if(isset($_SESSION['RGadmin'])) {?>
		<div class="btn-group permissions margin_left" style="">
		<select multiple="multiple" id="selBox-teams" <? echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['main_dashboard_color2']]['code']."";?>>
						<? foreach($teams as $key =>$teamD){ 
							foreach($teamD['code_id'] as $key => $teamd){
							?>
							<option selected="selected" value="<?php echo $teamd;?>"><?php echo $teamd ;?></option>
						<? } 
						} ?>
			    </select>
		</div>
<?php }?>




			
		
		<div class="btn-group" style="float:right;background:<?php echo $savedAdminColors[$savedMainDashboardlayout['main_dashboard_color2']]['code'] ;?>;"> 
			<button data-toggle="dropdown" style="padding:0 8px; background:<?php echo $savedAdminColors[$savedMainDashboardlayout['main_dashboard_color2']]['code'] ;?>; cursor:default">
				 <img style="height:35px; width:35px; display:inline-block; border-radius:0px; margin:-3px 0 0 0; border:0px solid #666" src="<?=ROOT.$_SESSION['rego']['img']?>?<?=time()?>">
			</button>
		</div>
		
		<div class="btn-group" style="float:right;background:<?php echo $savedAdminColors[$savedMainDashboardlayout['main_dashboard_color2']]['code'] ;?>;"> 
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
					$helpfile = getHelpfile(33);
					include('time_scan.php'); break;
				case 4: 
					$helpfile = getHelpfile(4);
					include('time_attendance.php'); break;
				case 44:
					$helpfile = getHelpfile(44); 
					include('monthly_attendance.php'); break;
				case 5: 
					$helpfile = getHelpfile(55);
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
				case 7007: 
					include('time_dashboard.php'); 
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


	<script type="text/javascript">

		var teamsL = "<?php echo $lng['Teams']?>";
		var teamsAll = "<?php echo $lng['Teams All']?>";


		$(document).ready(function() {

				window.sb = $('#selBox-teams').mnSumoSelect({ 
				placeholder: teamsL,
				captionFormat: teamsL+' ({0})', 
				csvDispCount: 1, 
				search: true, 
				searchText:'Search ...',
				// locale: locale,  
				selectAll:true,
				okCancelInMulti:true,
				showTitle: false,
				triggerChangeCombined:true,
				captionFormatAllSelected: teamsAll+' ({0})', 
			})
		
		});

		// $('#selBox-teams').on('change',function(e){
		// 	alert('You have selected '+ $(this).val());
		// });


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








