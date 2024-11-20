<?
	if(session_id()==''){session_start();}
	ob_start();
	include('dbconnect/db_connect.php');
	include('files/functions.php');
	// include('admin/files/layout_functions.php');

	//var_dump(hash('sha256', 'Berne123')); exit;
	//var_dump('1de5d3be55f595c1dd4412c5d3264b6b8b71190e69142adb1fda2d2b12c39d82');exit;
	if(isset($_SESSION['rego']['timestamp']) && $_SESSION['rego']['timestamp'] == 0){
		writeToLogfile('log', 'Logtime expired, Log-Out');
		unset($_SESSION['rego']);
	}
	$promo = 0;
	$content = '';
	$slider = array();
	if($res = $dbx->query("SELECT * FROM rego_company_settings")){
		$row = $res->fetch_assoc();
		$promo = $row['promo'];
		$content = $row[$lang.'_promo'];
		$slider = unserialize($row['promo_slider']);
	}
	foreach($slider as $k=>$v){
		if($v == 'uploads/promo.png'){
			unset($slider[$k]);
		}
	}
	//var_dump($promo); exit;



	$sql11 = "SELECT * FROM rego_layout_settings WHERE id= '1'";
	if($res11 = $dbx->query($sql11)){
		if($row11 = $res11->fetch_assoc())
		{
			$scanLoginSystemDataValue = unserialize($row11['system_login_screen']);	

			$data1['admin_dashboard']  = unserialize($row11['admin_dashboard']);
			$data2['admin_login_screen']  = unserialize($row11['admin_login_screen']);
			$data3['system_login_screen']  = unserialize($row11['system_login_screen']);
			$data4['mob_login_screen']  = unserialize($row11['mob_login_screen']);
			$data5['scan_login_screen']  = unserialize($row11['scan_login_screen']);
			$data6['buttons_tab']  = unserialize($row11['buttons_tab']);
			$data7['admin_login_screen_logo']  = unserialize($row11['admin_login_screen_logo']);
			$data8['admin_login_screen_title_logo']  = unserialize($row11['admin_login_screen_title_logo']);
			$data9['system_login_screen_logo']  = unserialize($row11['system_login_screen_logo']);
			$data10['system_login_screen_title_logo']  = unserialize($row11['system_login_screen_title_logo']);
			$data11['admin_dashboard_banner_logo']  = unserialize($row11['admin_dashboard_banner_logo']);
			$data12['main_dashboard']  = unserialize($row11['main_dashboard']);
			$data13['admin_login_screen_banner_array']  = unserialize($row11['admin_login_screen_banner_array']);
			$data14['system_login_screen_banner_array']  = unserialize($row11['system_login_screen_banner_array']);

			$mergeArray = array_merge($data1,$data2,$data3,$data4,$data5,$data6,$data7,$data8,$data9,$data10,$data11,$data12,$data13,$data14);



		}
	}


	$sql22 = "SELECT * FROM rego_color_settings WHERE id= '1'";
	if($res22 = $dbx->query($sql22)){
		if($row22 = $res22->fetch_assoc())
		{
			$getDefaultFonts  = unserialize($row22['font_settings']);
		}
	}



	$sql333 = "SELECT * FROM rego_color_settings WHERE id= '1'";
	if($res333 = $dbx->query($sql333)){
		if($row333 = $res333->fetch_assoc())
		{
			$array333['color_set'] = $row333['color_set'];
			$array333['typeofcolorset'] = $row333['typeofcolorset'];
		}
	}



	$sq444 = "SELECT * FROM rego_color_palette WHERE color_set= '".$array333['color_set']."' AND color_set_type= '".$array333['typeofcolorset']."'";
	if($res444 = $dbx->query($sq444)){
		if($row444 = $res444->fetch_assoc())
		{
			$savedAdminColors  = unserialize($row444['color_set_values']);
		}
	}


	// LOGIN BOX POSITION LOGIC 
	if($scanLoginSystemDataValue['select_system_login_box_main_position'] == 'right')
	{
		$positionValue = 'margin-right:15px' ;
	}	
	else if($scanLoginSystemDataValue['select_system_login_box_main_position'] == 'left')
	{
		$positionValue = 'margin-left:15px' ;
	}
	else
	{ 
		$positionValue = 'margin-left:0px' ;
	}




	// die();
?>

<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, maximum-scale=1">
		<meta name="robots" content="noindex, nofollow">
		<title><?=$www_title?></title>
	
		<link rel="icon" type="image/png" sizes="192x192" href="assets/images/192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="assets/images/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
		
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/login_customer_<?=$brand?>.css?<?=time()?>">
		<link rel="stylesheet" href="assets/css/myBootstrap.css?<?=time()?>">

		<script src="assets/js/jquery-3.2.1.min.js"></script>
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>

	</head>
	<style type="text/css">

		body {

			/*background: url('../../images/admin_uploads/<?php echo $savedAdminLoginlayout['bg_image_link'] ?>');*/

		    background: url('../../images/admin_uploads/<?php echo $scanLoginSystemDataValue['bg_image_link'] ?>') no-repeat center center!important;
		    background-size: cover!important;
		}

		@font-face {
		    font-family: 'ETHNOCENTRIC';
		    src: url('../../assets/fonts/ethnocentric-rg.ttf');
		}
	</style>
	<body>

		<?php 
				if($mergeArray['system_login_screen_banner_array']['show_hide_logo_common_field_banner'] == '1')
				{ ?>

				<img style="position: absolute;bottom: 0px;width: 100%;" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $mergeArray['system_login_screen_banner_array']['image_link'];?>">


			<?php }?>



		
		<div id="brand_logo">
			<? if($lang=='en'){ ?>
				<a style="margin:0px 0 0 0" data-lng="th" class="langbutton <? if($lang=='th'){echo 'activ';} ?>"><img src="../images/flag_th.png"></a>
			<? }else{ ?>
				<a style="margin:0px 0 0 0" data-lng="en" class="langbutton <? if($lang=='en'){echo 'activ';} ?>"><img src="../images/flag_en.png"></a>
			</td>
			<? } ?>
		</div>

		<div id="brand_title">

			<?php if($mergeArray['system_login_screen_title_logo']['show_hide_logo_common_field'] == '1') { ?>

				<img style="height:<?php echo $mergeArray['system_login_screen_title_logo']['admin_login_screen_logo_size'].'px';?>;position:relative; left:20px;top: 20px;" src="../images/admin_uploads/<?php echo $mergeArray['system_login_screen_title_logo']['image_link'];?>"><b style="font-family:ETHNOCENTRIC; font-weight:400; font-size:30px; color:#333;position: absolute;top: 25px;left:221px"> <span>HR</span><span> I</span><span style="font-size: 22px;">ntegrated</span> <span>S</span><span style="font-size: 22px;">ystem</span></b> 

			<?php }else {?>
			
			 <b style="font-weight:400; font-size:30px; color:#333;position: absolute;top: 25px;left: 
			 <?php if($mergeArray['system_login_screen_title_logo']['show_hide_logo_common_field'] == '1') 
			 { echo '221px'; }else{echo '20px';}?>; "> <span style="font-family:ETHNOCENTRIC;color:<?php echo $savedAdminColors[$savedAdminLoginlayout['select_admin_login_titletext_color']]['code'].'!important'; ?>"><?php if($savedAdminLoginlayout['select_admin_login_screen_title_text'] != '') {echo $savedAdminLoginlayout['select_admin_login_screen_title_text']; }else{ echo 'HR Integrated System';} ?></span></b> 

			<?php } ?>

			 	
		</div>
		

		<div class="header">
			<table width="100%" border="0"><tr>
				<td>
					<img style="margin:0 0 3px 15px; height:40px;" src="<?=$default_logo.'?'.time()?>">
				</td>
				<td style="width:95%"></td>
				<td style="padding-right:20px">
				<? if($lang=='en'){ ?>
					<a style="margin:0px 0 0 0" data-lng="th" class="langbutton <? if($lang=='th'){echo 'activ';} ?>"><img src="images/flag_th.png"></a>
				<? }else{ ?>
					<a style="margin:0px 0 0 0" data-lng="en" class="langbutton <? if($lang=='en'){echo 'activ';} ?>"><img src="images/flag_en.png"></a>
				</td>
				<? } ?>
			</tr></table>
		</div>
		
		<div style="padding-top:10vh; xborder:1px solid red;float:<?php echo $scanLoginSystemDataValue['select_system_login_box_main_position'].'!important'; ?>;<?php echo $positionValue; ?>;">

			<?php 
				if($mergeArray['system_login_screen_logo']['show_hide_logo_common_field'] == '1')
				{ ?>

					<div class="brand">
						<img style="height:<?php echo $mergeArray['system_login_screen_logo']['admin_login_screen_logo_size'].'px';?>" src="images/admin_uploads/<?php echo $mergeArray['system_login_screen_logo']['image_link'];?>">
						<p></p>
					</div>

			<?php }?>



		<div class="logform" style="xleft:1000px !important">
			<h2  style="background:<?php echo $savedAdminColors[$scanLoginSystemDataValue['select_system_login_heading_color']]['code'].'!important'; ?> "><i class="fa fa-lock"></i> &nbsp;<?=$lng['Login to our secure server']?></h2>
			<div class="logform-inner">
				<div id="logMsg" style="color:#b00; font-weight:600; font-size:14px; display:none"></div>
				
				<div id="login">
					<form id="logForm">
						<label><?=$lng['Username']?> <i class="man"></i></label>
						<input name="username" type="text" autocomplete="username" value="" />
						<label><?=$lng['Password']?> <i class="man"></i></label>
						<input name="password" type="password" autocomplete="current-password" value="" />
						<div style="height:15px"></div>
						<button style="border-color:<?php echo $savedAdminColors[$scanLoginSystemDataValue['select_system_login_button_color']]['code'].'!important'; ?>;background:<?php echo $savedAdminColors[$scanLoginSystemDataValue['select_system_login_button_color']]['code'].'!important'; ?>;" type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i>&nbsp; <?=$lng['Log-in']?></button>
						<? if($brand == 'rego'){ ?>
						<button style="float:right; margin-top:7px;border-color:<?php echo $savedAdminColors[$scanLoginSystemDataValue['select_system_login_forgotbutton_color']]['code'].'!important'; ?>;background:<?php echo $savedAdminColors[$scanLoginSystemDataValue['select_system_login_forgotbutton_color']]['code'].'!important'; ?>;" id="togglediv"  type="button" class="btn btn-outline-secondary btn-sm"><?=$lng['Forgot password']?></button>
						<? }else{ ?>
						<button id="togglediv" style="float:right;border-color:<?php echo $savedAdminColors[$scanLoginSystemDataValue['select_system_login_forgotbutton_color']]['code'].'!important'; ?>;background:<?php echo $savedAdminColors[$scanLoginSystemDataValue['select_system_login_forgotbutton_color']]['code'].'!important'; ?>;"  type="button" class="btn btn-primary"><?=$lng['Forgot password']?></button>
						<? } ?>
					</form>
					<div id="dump"></div>
				</div>
				
				<div id="first" style="display:none">
					<form id="firstForm">
						 <label><?=$lng['Password']?> <i class="man"></i></label>
						 <input name="npassword" type="password" autocomplete="new-password" value="" />
						 <label>Repeat <?=$lng['Password']?> <i class="man"></i></label>
						 <input name="rpassword" type="password" autocomplete="new-password" value="" />
						 <div style="height:15px"></div>
						 <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp; <?=$lng['Save']?> Password</button>
					</form>
				</div>
				
				<div id="forgot" style="display:none">
					<form id="forgotForm">
						 <label><?=$lng['Username']?> <i class="man"></i></label>
						 <input name="forgot_username" type="text" autocomplete="username" value="" />
						 <div style="height:15px"></div>
						 <button style="border-color:<?php echo $savedAdminColors[$scanLoginSystemDataValue['select_system_login_forgotbutton_color']]['code'].'!important'; ?>;background:<?php echo $savedAdminColors[$scanLoginSystemDataValue['select_system_login_forgotbutton_color']]['code'].'!important'; ?>;"  class="btn btn-primary" type="submit"><i class="fa fa-paper-plane"></i>&nbsp; <?=$lng['Request new password']?></button>
						<? if($brand == 'rego'){ ?>
						 <button style="float:right; margin-top:7px;border-color:<?php echo $savedAdminColors[$scanLoginSystemDataValue['select_system_login_forgotbutton_color']]['code'].'!important'; ?>;background:<?php echo $savedAdminColors[$scanLoginSystemDataValue['select_system_login_forgotbutton_color']]['code'].'!important'; ?>;"  id="togglediv2" class="btn btn-outline-secondary btn-sm" type="button"><?=$lng['Log-in']?></button>
						<? }else{ ?>
						 <button style="float:right;border-color:<?php echo $savedAdminColors[$scanLoginSystemDataValue['select_system_login_forgotbutton_color']]['code'].'!important'; ?>;background:<?php echo $savedAdminColors[$scanLoginSystemDataValue['select_system_login_forgotbutton_color']]['code'].'!important'; ?>;"  id="togglediv2" class="btn btn-primary" type="button"><?=$lng['Log-in']?></button>
						<? } ?>
					</form>
					<div style="clear:both"></div>
				</div>

			</div>
		</div>
		</div>
		
		<? if($brand == 'rego'){ ?>
		<div id="logPromotion" style="background: rgba(250,250,250,0.8); color:#000; position:fixed; top:50px; bottom:0; right:0; margin-right:-40%; width:40%; box-shadow:-5px -5px 20px #000; border-left:5px solid #fff; padding:30px; font-size:14px">
			
			<? if(count($slider)> 1){ ?>
				<div id="promoCarousel" class="carousel slide" data-ride="carousel">
					<div class="carousel-inner">
						<? foreach($slider as $k=>$v){ ?>
							<div class="carousel-item <? if($k == '0'){echo 'active';}?>">
								<img src="admin/<?=$v?>?<?=time()?>" class="d-block w-100">							 
							</div>
						<? } ?>
					</div>
					<a class="carousel-control-prev" href="#promoCarousel" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>					</a>
					<a class="carousel-control-next" href="#promoCarousel" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>					</a>				</div>
			<? }else if($slider){ ?>
				<img width="100%" src="../admin/<?=$slider[1]?>?<?=time()?>">
			<? } ?>
			<div style="height:20px"></div>		
			
			<div class="innerHelp" style="height: calc(100% - 350px); overflow-y:auto; padding-right:5px">
				<?=$content?>
			</div>
			
			<div style="position:absolute; bottom:20px; left:20px; right:20px">
				
				<span style="background:#333; border-radius:3px; color:#fff; padding:5px 12px; font-weight:600; margin-right:8px; float:left; cursor:default">+66 (0)6 139 184 77</span>
				<span style="background:#333; border-radius:3px; color:#fff; padding:5px 12px; font-weight:600; float:left"><a style="color:#fff" href="mailto:info@regohr.com">info@regohr.com</a></span>

				<a style="display:inline-block; margin:0; float:right" href="https://www.instagram.com/regohrthailand/" target="_blank"><img height="30px" src="images/instagram.png" /></a>
				<a style="display:inline-block; margin:0 8px 0 0; float:right" href="https://www.facebook.com/RegoHRThailand/" target="_blank"><img height="30px" src="images/facebook.png" /></a>
				<a style="display:inline-block; margin:0 8px 0 0; float:right" href="https://bit.ly/2uLK0L2" target="_blank"><img height="30px" src="images/line.png" /></a>

			</div>
		</div>
		<? } ?>
	
<script type="text/javascript">
		
	$(document).ready(function() {
		
		var promo = <?=json_encode($promo)?>;
		
		$('.carousel').carousel({
			interval: 5000,
			pause: 'hover'
		})
		
		if(promo == 1){
			setTimeout(function(){
				$("#logPromotion").animate({"margin-right": '0'});
			},1000);
		}

		$("#forgotForm").submit(function (e) {
			e.preventDefault();
			$('#logMsg').hide();
			if($('input[name="forgot_username"]').val() == ''){
				$('#logMsg').html('<?=$lng['Please fill in required fields']?>').fadeIn(200);
				return false;
			}
			var formData = $(this).serialize();
			$.ajax({
				url: "ajax/forgot_password.php",
				data: formData,
				success: function(response){
					//$("#dump").html(response); return false;
					if($.trim(response) == 'success'){
						$('#logMsg').html('<?=$lng['Please check your email for new password']?>').fadeIn(200);
						$('input[name="password"]').val('')
						setTimeout(function(){
							$('#logMsg').hide();
							$("#forgot").slideUp(200);
							$("#login").slideDown(200);
						}, 3000);
					}
				},
				error:function (xhr, ajaxOptions, thrownError){
					alert('Error : '+thrownError);
				}
			});
		});
		
		$("#firstForm").submit(function (e) {
			e.preventDefault();
			$('#logMsg').hide();
			if($('input[name="npassword"]').val() == '' || $('input[name="rpassword"]').val() == ''){
				$('#logMsg').html('<?=$lng['Please fill in required fields']?>').fadeIn(200);
				return false;
			}
			var formData = $(this).serialize();
			formData +='&username=' + $('input[name="username"]').val();
			$.ajax({
				url: "ajax/change_first_password.php",
				data: formData,
				success: function(response){
					//$("#dump").html(response); return false;
					if($.trim(response) == 'success'){
						$("#first").slideUp(200);
						$("#login").slideDown(200);
						$('input[name="password"]').val('');
					}else{
						$("#logMsg").html(response).fadeIn(200);
					}
				},
				error:function (xhr, ajaxOptions, thrownError){
					alert('Error : '+thrownError);
				}
			});
		});
		
		$("#logForm").submit(function (e) {
			e.preventDefault();
			$('#logMsg').hide();
			if($('input[name="username"]').val() == '' || $('input[name="password"]').val() == ''){
				$('#logMsg').html('<?=$lng['Please fill in required fields']?>').fadeIn(200);
				return false;
			}
			var formData = $(this).serialize();
			$.ajax({
				url: "ajax/ajax_login.php",
				data: formData,
				success: function(response){
					//$("#dump").html(response); return false;

					//alert(response);
					//return false;
					
					if($.trim(response) == 'status'){
						$('#logMsg').html("<?=$lng['This user is suspended']?>").fadeIn(200);
					}
					if($.trim(response) == 'nocomp'){
						$('#logMsg').html("No company assigned to this user<? //=$lng['This user is suspended']?>").fadeIn(200);
					}
					if($.trim(response) == 'exist'){
						$('#logMsg').html("<?=$lng["This user don't exist in our database"]?>").fadeIn(200);
					}
					if($.trim(response) == 'wrong'){
						$('#logMsg').html('<?=$lng['Wrong Username or Password']?>').fadeIn(200);
					}
					if($.trim(response) == 'suspended'){
						$('#logMsg').html('This company is suspended<? //=$lng['This user is suspended']?>').fadeIn(200);
					}
					if($.trim(response) == 'access'){
						$('#logMsg').html('<?=$lng['You have no User access or permissions']?><br><?=$lng['Please contact your supervisor']?>').fadeIn(200);
					}
					if($.trim(response) == 'sys' || $.trim(response) == 'appr' || $.trim(response) == 'app' || $.trim(response) == 'comp'){
						//alert(response)
						location.href = 'index.php';
					}
					if($.trim(response) == 'emp'){
						location.href = 'e/index.php';
					}
				},
				error:function (xhr, ajaxOptions, thrownError){
					$('#logMsg').html('<?=$lng['Error']?> : ' + thrownError).fadeIn(200);
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
		
		$('#togglediv').click(function(){
			$('#logMsg').hide();
			$('#login').slideUp(200);
			$('#forgot').slideDown(200);
		})
		$('#togglediv2').click(function(){
			$('#logMsg').hide();
			$('#forgot').slideUp(200);
			$('#login').slideDown(200);
		})
		
	})
	
</script>

	</body>
</html>










