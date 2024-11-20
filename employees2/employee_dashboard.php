<?php

	$history_lock = getHistoryLock();
	$hisLink = 'index.php?mn=441&type=all';
	if($history_lock == 1){
		$hisLink = 'index.php?mn=440&type=add';
	}
	//var_dump($history_lock);

	// echo '<pre>';
	// print_r($_SESSION['rego']);
	// echo '</pre>';

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



?>

<?php 

if($_GET['mn'] !='100'){ ?>
	<h2 style="position:relative">
		<i class="fa fa-users fa-mr"></i> <?=$lng['Employees']?>
	</h2>
<?php } ?>

	<div style="padding:0 0 0 20px" id="dump"></div>
	
	<div class="dash-left">
		
		<div class="dashbox <? //if($myaccess['rego']['employee']['access']){}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='index.php?mn=101'"  <? echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect1']]['code']."";?>>
				<i class="fa fa-users"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Employees register']?></p>
					</div>
				</div>						
			</div>
		</div>

		<div class="dashbox <? //if($myaccess['rego']['employee']['access']){}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='index.php?mn=102'" <? echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect2']]['code']."";?>>
				<i class="fa fa-users"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Modify Employee Register']?></p>
					</div>
				</div>						
			</div>
		</div>

		<div class="dashbox <? //if($myaccess['rego']['employee']['access']){}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='index.php?mn=1029'" <? echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect3']]['code']."";?>>
				<i class="fa fa-users"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Employee Benefits Calculator']?></p>
					</div>
				</div>						
			</div>
		</div>
	
		
		<div class="dashbox reds<? //if($myaccess['rego']['payroll_attendance']['view']){echo 'green';}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='index.php?mn=1028';" <? echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect4']]['code']."!important";?>>
				<i class="fa fa-archive"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Archive center']?></p>
					</div>
				</div>						
			</div>
		</div>

	

		<div class="dashbox teal<? //if($myaccess['rego']['payroll_benefits']['view'] && $myaccess['rego']['standard'][$standard]['pr_benefits']){echo 'teal';}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='reports/index.php?mn=450';" <? echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect5']]['code']."!important";?>>
				<i class="fa fa-file"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Report center']?></p>
					</div>
				</div>						
				
			</div>
		</div>
		<div class="dashbox green<? //if($myaccess['rego']['payroll_calculations']['view'] && $myaccess['rego']['standard'][$standard]['pr_individual']){echo 'reds';}else{echo 'disabled';} ?>"  >
			<div class="inner" onclick="window.location.href='index.php?mn=1027';" <? echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect6']]['code']."!important";?>>
				<i class="fa fa-history"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Log History']?></p>
					</div>
				</div>						
			</div>
		</div>

		
	</div>
	
	<div class="dash-right">
				
		
	</div>

	<script type="text/javascript">

	$(document).ready(function() {
		
		
	});

	</script>
						
