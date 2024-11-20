<?
	if(session_id()==''){session_start();}
	ob_start();
	include('dbconnect/db_connect.php');
	include('files/layout_functions.php');
	//var_dump(hash('sha256', 'Berne123')); exit;
	//var_dump('1de5d3be55f595c1dd4412c5d3264b6b8b71190e69142adb1fda2d2b12c39d82');exit;
	$err_msg = "";
	if(isset($_SESSION['RGadmin']['timestamp']) && $_SESSION['RGadmin']['timestamp'] == 0){
		$err_msg = '<div class="msg_alert nomargin">'.$lng['Logtime expired'].'</div>';
		unset($_SESSION['RGadmin']);
	}


	// // SAVED ADMIN DASHBOARD LAYOUT
	$savedAdminLoginlayout = getSavedAdminLoginScreenLayout();
	$combinedMergedArray = getSavedAdminLoginScreenCombined();
	// // DEFAULT FONTS SAVED IN DATABASE 
	$savedDefaultFonts = getDefaultFonts();
	// // GET TYPE OF SET 
	$savedlayoutSetName = getSavedLayout();
	// GET COLORS WHERE COLOR SET AND TYPE OF SET 
	$savedAdminColors = getSavedAdminLayoutColors($savedlayoutSetName['color_set'],$savedlayoutSetName['typeofcolorset']);



	// LOGIN BOX POSITION LOGIC 
	if($savedAdminLoginlayout['select_admin_login_box_main_position'] == 'right')
	{
		$positionValue = 'margin-right:15px' ;
	}	
	else if($savedAdminLoginlayout['select_admin_login_box_main_position'] == 'left')
	{
		$positionValue = 'margin-left:15px' ;
	}
	else
	{ 
		$positionValue = 'margin-left:0px' ;
	}


	// echo '<pre>';
	// print_r($combinedMergedArray);
	// echo '</pre>';

	// die();

?>

<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, maximum-scale=1">
		<meta name="robots" content="noindex, nofollow">
		<title><?=$www_title?></title>
	
		<link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
		<link rel="icon" href="../images/favicon.ico" type="image/x-icon">
		
		<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/login_<?=$brand?>.css?<?=time()?>">
		<link rel="stylesheet" href="../assets/css/myBootstrap.css?<?=time()?>">

		<script src="../assets/js/jquery-3.2.1.min.js"></script>
		<script src="../assets/js/popper.min.js"></script>
		<script src="../assets/js/bootstrap.min.js"></script>

	</head>

	<style type="text/css">
		
		body {

			/*background: url('../../images/admin_uploads/<?php echo $savedAdminLoginlayout['bg_image_link'] ?>');*/

		    background: url('../../images/admin_uploads/<?php echo $savedAdminLoginlayout['bg_image_link'] ?>') no-repeat center center!important;
		    background-size: cover!important;
		}


		@font-face {
		    font-family: 'ETHNOCENTRIC';
		    src: url('../../assets/fonts/ethnocentric-rg.ttf');
		}

	</style>
		


	<body class="xbody_logo">

		
		<div id="brand_logo">
			<? if($lang=='en'){ ?>
				<a style="margin:0px 0 0 0" data-lng="th" class="langbutton <? if($lang=='th'){echo 'activ';} ?>"><img src="../images/flag_th.png"></a>
			<? }else{ ?>
				<a style="margin:0px 0 0 0" data-lng="en" class="langbutton <? if($lang=='en'){echo 'activ';} ?>"><img src="../images/flag_en.png"></a>
		
			<? } ?>
		</div>		

		<div id="brand_title">
			<?php if($combinedMergedArray['admin_login_screen_title_logo']['show_hide_logo_common_field'] == '1') { ?>

				<img style="height:<?php echo $combinedMergedArray['admin_login_screen_title_logo']['admin_login_screen_logo_size'].'px';?>;position: relative;top: 20px;left: 20px;" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $combinedMergedArray['admin_login_screen_title_logo']['image_link'];?>">

			<?php }?>
			
			 <b style="font-family:'ETHNOCENTRIC'; font-weight:400; font-size:30px; color:#333;position: absolute;top: 25px;left: 
			 <?php if($combinedMergedArray['admin_login_screen_title_logo']['image_link'] != '') 
			 { echo '221px'; }else{echo '20px';}?>; "> <span style="font-family:ETHNOCENTRIC;color:<?php echo $savedAdminColors[$savedAdminLoginlayout['select_admin_login_titletext_color']]['code'].'!important'; ?>"><?php if($savedAdminLoginlayout['select_admin_login_screen_title_text'] != '') {echo 'A<span style="font-size:22px">dmin</span> P<span style="font-size:22px">latform</span>'; }else{ echo 'Admin Platform';} ?></span></b> 
		</div>
		
		<div class="header">
			<table width="100%" border="0"><tr>
				<td>
					<img style="margin:0 0 3px 15px; height:40px;" src="../<?=$default_logo?>?<?=time()?>">
				</td>
				<td style="width:95%"></td>
				<td style="padding-right:20px">
				<? if($lang=='en'){ ?>
					<a style="margin:0px 0 0 0" data-lng="th" class="langbutton <? if($lang=='th'){echo 'activ';} ?>"><img src="../images/flag_th.png"></a>
				<? }else{ ?>
					<a style="margin:0px 0 0 0" data-lng="en" class="langbutton <? if($lang=='en'){echo 'activ';} ?>"><img src="../images/flag_en.png"></a>
				</td>
				<? } ?>
			</tr></table>
		</div>
		
		<!--<br><br><br><div id="dump"></div>-->
		<div style="padding-top:12vh; xborder:1px solid red;float:<?php echo $savedAdminLoginlayout['select_admin_login_box_main_position'].'!important'; ?>;<?php echo $positionValue; ?>;">

			<?php if($combinedMergedArray['admin_login_screen_logo']['show_hide_logo_common_field'] == '1'){?>

				<div class="brand">
					<img style="height:<?php echo $combinedMergedArray['admin_login_screen_logo']['admin_login_screen_logo_size'].'px'; ?>" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $combinedMergedArray['admin_login_screen_logo']['image_link'];?>">
					<p></p>
				</div>

			<?php } ?>

			
		<div class="logform" style="position: relative;">
			<h2 style="background:<?php echo $savedAdminColors[$savedAdminLoginlayout['select_admin_login_heading_color']]['code'].'!important'; ?>; border-radius:3px 3px 0 0"><i class="fa fa-lock"></i> &nbsp;<span  style="font-family:<?php echo $savedDefaultFonts[$savedAdminLoginlayout['select_admin_login_heading_font']].'!important'; ?>;"><?=$lng['Login to our secure server']?></span></h2>
			<div class="logform-inner">
				<div id="logMsg" style="color:#b00; font-weight:600; font-size:14px; display:none"></div>
				
				<div id="login">
					<form id="logForm">
						<label><?=$lng['Username']?> <i class="man"></i></label>
						<input name="username" type="text" autocomplete="username" value="" />
						<label><?=$lng['Password']?> <i class="man"></i></label>
						<input name="password" type="password" autocomplete="current-password" value="" />
						<div style="height:15px"></div>
						<button style="border-color:<?php echo $savedAdminColors[$savedAdminLoginlayout['select_admin_login_button_color']]['code'].'!important' ?>;background:<?php echo $savedAdminColors[$savedAdminLoginlayout['select_admin_login_button_color']]['code'].'!important'; ?>;" type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i>&nbsp; <?=$lng['Log-in']?></button>
						<? if($brand == 'rego'){ ?>
						<button id="togglediv" style="float:right; margin-top:7px" type="button" class="btn btn-outline-secondary btn-sm"><?=$lng['Forgot password']?></button>
						<? }else{ ?>
						<button style="float:right;border-color:<?php echo $savedAdminColors[$savedAdminLoginlayout['select_admin_login_forgotbutton_color']]['code'].'!important'; ?>;background:<?php echo $savedAdminColors[$savedAdminLoginlayout['select_admin_login_forgotbutton_color']]['code'].'!important'; ?>;" id="togglediv"  type="button" class="btn btn-primary"><?=$lng['Forgot password']?></button>
						<? } ?>
					</form>
				</div>
				
				<div id="forgot" style="display:none">
					<form id="forgotForm">
						 <label><?=$lng['Username']?> <i class="man"></i></label>
						 <input name="forgot_username" type="text" autocomplete="username" value="" />
						 <div style="height:15px"></div>
						 <button style="border-color:<?php echo $savedAdminColors[$savedAdminLoginlayout['select_admin_login_button_color']]['code'].'!important'; ?>;background:<?php echo $savedAdminColors[$savedAdminLoginlayout['select_admin_login_button_color']]['code'].'!important'; ?>;" class="btn btn-primary" type="submit"><i class="fa fa-paper-plane"></i>&nbsp; <?=$lng['Request new password']?></button>
						<? if($brand == 'rego'){ ?>
						 <button style="float:right; margin-top:7px;border-color:<?php echo $savedAdminColors[$savedAdminLoginlayout['select_admin_login_button_color']]['code'].'!important'; ?>;background:<?php echo $savedAdminColors[$savedAdminLoginlayout['select_admin_login_button_color']]['code'].'!important'; ?>;" style="" id="togglediv2" class="btn btn-outline-secondary btn-sm" type="button"><?=$lng['Log-in']?></button>
						<? }else{ ?>
						 <button style="float:right; border-color:<?php echo $savedAdminColors[$savedAdminLoginlayout['select_admin_login_button_color']]['code'].'!important'; ?>;background:<?php echo $savedAdminColors[$savedAdminLoginlayout['select_admin_login_button_color']]['code'].'!important'; ?>;"  id="togglediv2" class="btn btn-primary" type="button"><?=$lng['Log-in']?></button>
						<? } ?>
					</form>
					<div style="clear:both"></div>
				</div>

			</div>
		</div>
		</div>

		<?php if($combinedMergedArray['admin_login_screen_banner_array']['show_hide_logo_common_field_banner'] == '1') { ?>

				<div>
					<img style="position: absolute;bottom: 0px;width: 100%;" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $combinedMergedArray['admin_login_screen_banner_array']['image_link'];?>">
				</div> 



			<?php }?>

		
		
	
<script type="text/javascript">
		
	$(document).ready(function() {
		
		$("#forgotForm").submit(function (e) {
			e.preventDefault();
			$('#logMsg').hide();
			if($('input[name="forgot_username"]').val() == ''){
				$('#logMsg').html('Please fill in required fields').fadeIn(200);
				return false;
			}
			var formData = $(this).serialize();
			$.ajax({
				url: "ajax/admin_forgot_password.php",
				data: formData,
				success: function(response){
					//$("#dump").html(response); return false;
					if($.trim(response) == 'success'){
						$('#logMsg').html('Please check your email for new password').fadeIn(200);
						$('input[name="password"]').val('')
						setTimeout(function(){
							$('#logMsg').hide();
							$("#forgot").slideUp(200);
							$("#login").slideDown(200);
						}, 5000);
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
				$('#logMsg').html('Please fill in required fields').fadeIn(200);
				return false;
			}
			var formData = $(this).serialize();
			$.ajax({
				url: "ajax/ajax_admin_login.php",
				data: formData,
				success: function(response){
					//$("#dump").html(response); //return false;
					//alert(response)
					if($.trim(response) == 'wrong'){
						$('#logMsg').html('Wrong username or password').fadeIn(200);
					}else if($.trim(response) == 'suspended'){
						$('#logMsg').html('This user is suspended').fadeIn(200);
					}else{
						window.location.href = response;
					}
				},
				error:function (xhr, ajaxOptions, thrownError){
					$('#logMsg').html('Error : ' + thrownError).fadeIn(200);
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










