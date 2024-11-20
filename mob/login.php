<?php
	
	if(session_id()==''){session_start();}
	include('../dbconnect/db_connect.php');
	
	$username = '';
	$password = '';
	$remember = 0;
	if(isset($_COOKIE['log'])){
		$log = unserialize($_COOKIE['log']);
		if($log['remember'] == 1){
			$username = $log['user'];
			$password = $log['pass'];
			$remember = $log['remember'];
		}
	}
	//var_dump($log);
	$brand = 'RegoDemo';
	$default_logo = 'images/Regodemo.png';
	//var_dump( hash('sha256', 'guest')); 


	$sql11 = "SELECT * FROM rego_layout_settings WHERE id= '1'";
	if($res11 = $dbx->query($sql11)){
		if($row11 = $res11->fetch_assoc())
		{
			$scanLoginSystemDataValue = unserialize($row11['mob_login_screen']);	
			$mob_login_screen_logo_array = unserialize($row11['mob_login_screen_logo_array']);	
			$mob_login_screen_banner_array = unserialize($row11['mob_login_screen_banner_array']);	
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




	// echo '<pre>';
	// print_r($scanLoginSystemDataValue);
	// echo '</pre>';

?>

<!Doctype html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<meta name="theme-color" content="#000000">
	<title><?=$www_title?></title>
	<link rel="icon" type="image/png" href="../assets/images/192x192.png" sizes="32x32">
	<link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/192x192.png">
	<link rel="stylesheet" href="../assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="../assets/css/line-awesome.min.css">
	<link rel="stylesheet" href="assets/css/style.css?<?=time()?>">
	<link rel="manifest" href="__manifest.json">
	<? if($brand == 'RegoDemo'){ ?>
	<!-- <style>
		body {
			background: url(../images/login-final-client-small.png) no-repeat top +450px center;
			background-size: contain;
		}
	</style> -->
	<? } ?>
	
	<style type="text/css">
		.fixBottomMenu {
		    top: 71px;
		    right: 31px;
		}
		.fixBottomMenus {
		    position: fixed;
		    z-index: 999;
		    bottom: 0;
		    left: 0;
		    right: 0;
		    background: transparent;
		}
	</style>
</head>

<body>

    <!-- loader -->
    <!--<div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>-->
    <!-- * loader -->

    <!-- App Header -->
    <div style="background:<?php echo $savedAdminColors[$scanLoginSystemDataValue['select_mob_login_heading_color']]['code'].'!important'; ?>; " class="appHeader bg-dark text-light">
        <div class="pageTitle"><span style="font-family:<?php echo $getDefaultFonts[$scanLoginSystemDataValue['select_mob_login_heading_font']].'!important'; ?>;"><?=$lng['Login to our secure server']?></span></div>
    </div>
    <!-- * App Header -->

    <!-- App Content -->
		<div class="container-fluid" style="xborder:1px solid red">
			<div class="row" style="xborder:1px solid green; padding:25px">
				<div class="col-12">

					<?php if($mob_login_screen_logo_array['show_hide_logo_common_field'] == '1') { ?>

						<img style="height:<?php echo $mob_login_screen_logo_array['admin_login_screen_logo_size'].'px'; ?>"   src="../images/admin_uploads/<?php echo $mob_login_screen_logo_array['image_link'];?>">

					<?php } ?>
					
					<div class="divider-icon">
						<div><i class="fa fa-lock fa-lg"></i></div>
					</div>
					
					<div id="logForm">	
						<form id="log_form">
							<div class="form-group">
								<label for="username"><?=$lng['Username']?></label>
								<input class="form-control" type="text" name="username" value="<?=$username?>" id="username"/>
							</div>
							<div class="form-group">
								<label for="password"><?=$lng['Password']?></label>
								<input class="form-control" type="password" name="password" value="<?=$password?>" id="password"/>
							</div>
							<table border="0" style="margin-bottom:10px">
								<tr>
									<td>
										<div class="custom-control custom-switch" style="xbackground:red; padding:0">
												<input <? if($remember == 1){echo 'checked';}?> type="checkbox" class="custom-control-input" name="remember" id="remember" value="1">
												<label class="custom-control-label" for="remember"></label>
										</div>
									</td>
									<td style="padding-left:8px; font-weight:500"><?=$lng['Remember me']?></td>
								</tr>
							</table>
							<button style="margin-bottom:6px;border-color:<?php echo $savedAdminColors[$scanLoginSystemDataValue['select_mob_login_button_color']]['code'].'!important'; ?>;background:<?php echo $savedAdminColors[$scanLoginSystemDataValue['select_mob_login_button_color']]['code'].'!important'; ?>; "  type="submit" class="btn btn-default btn-block"><?=$lng['Log-in']?> &nbsp;<i class="fa fa-sign-in fa-lg"></i></button>
							<button style="border-color:<?php echo $savedAdminColors[$scanLoginSystemDataValue['select_mob_login_forgot_button_color']]['code'].'!important'; ?>;background:<?php echo $savedAdminColors[$scanLoginSystemDataValue['select_mob_login_forgot_button_color']]['code'].'!important'; ?>; "  type="button" class="btn btn-info btn-block" id="forgot"><?=$lng['Forgot password']?></button>
							<div style="color:#a00; font-size:15px; display:none; margin-top:10px" id="logMsg"></div>
						</form>
					</div>
					
					<div id="forgotForm" style="display:none">
						<form id="forgotPassForm">
							<div class="form-group">
								<label for="username"><?=$lng['Username']?></label>
								<input class="form-control"type="text" name="femail" id="femail"/>
							</div>
							<button style="margin-bottom:6px" type="submit" class="btn btn-default btn-block"><?=$lng['Request new password']?></button>
							<button id="backLogin" type="button" class="btn btn-info btn-block"><?=$lng['Back to Login']?></button>
							<div style="color:#a00; line-height:140%; font-size:15px; display:none; margin-top:10px" id="forMsg"></div>
						</form>
					</div>
					
					<!-- <div style="height:250px"></div> -->
					<div ></div>
					
				</div>
			</div>
		</div>	
    <!-- * App Content -->

    <?php 
	if($mob_login_screen_banner_array['show_hide_logo_common_field_banner'] == '1')
	{ ?>
		<!-- App Bottom Menu -->
	    <div class="fixBottomMenus" style="border:0">
	    	<img style="width: 100%;" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $mob_login_screen_banner_array['image_link'];?>">
					
	    </div>
	    <!-- * App Bottom Menu -->
	<?php }?>

	    <div class="fixBottomMenu" style="border:0">
					<? if($lang=='en'){ ?>
						<a href="#" data-lng="th" class="langbutton <? if($lang=='th'){echo 'activ';} ?>"><img src="../images/flag_th.png"></a>
					<? }else{ ?>
						<a href="#" data-lng="en" class="langbutton <? if($lang=='en'){echo 'activ';} ?>"><img src="../images/flag_en.png"></a>
					<? } ?>
	    </div>



    



    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script src="assets/js/lib/jquery-3.4.1.min.js"></script>
    <!-- Bootstrap-->
    <script src="assets/js/lib/popper.min.js"></script>
    <script src="assets/js/lib/bootstrap.min.js"></script>
    <!-- Owl Carousel -->
    <!--<script src="assets/js/plugins/owl-carousel/owl.carousel.min.js"></script>-->
    <!-- jQuery Circle Progress -->
    <!--<script src="assets/js/plugins/jquery-circle-progress/circle-progress.min.js"></script>-->
    <!-- Base Js File -->
    <script src="assets/js/base.js?<?=time()?>"></script>

	<script type="text/javascript">
		
	$(document).ready(function() {
		
		$("#log_form").submit(function (e) {
			e.preventDefault();

			$('#logMsg').hide();
			$('#forMsg').hide();
			if($('input[name="username"]').val() == '' || $('input[name="password"]').val() == ''){
				$('#logMsg').html('<i class="fa fa-exclamation-circle"></i>&nbsp; <?=$lng['Please fill in required fields']?></div>').fadeIn(200);
				return false;
			}
			var formData = $(this).serialize();
			$.ajax({
				url: "ajax/ajax_login.php",
				data: formData,
				success: function(response){
					//$("#dump").html(response); return false;
					//alert(response)
					if($.trim(response) == 'wrong'){
						$('#logMsg').html('<i class="fa fa-exclamation-circle"></i>&nbsp; <?=$lng['Wrong Username or Password']?></div>').fadeIn(200);
					}
					if($.trim(response) == 'suspended'){
						$('#logMsg').html('<i class="fa fa-exclamation-circle"></i>&nbsp; <?=$lng['This user is suspended']?></div>').fadeIn(200);
					}
					if($.trim(response) == 'emp'){
						$('#logMsg').html('<i class="fa fa-exclamation-circle"></i>&nbsp; <?=$lng['You have no access to this platform']?></div>').fadeIn(200);
					}
					if($.trim(response) == 'success'){
						//location.href = 'index.php?mn=18';
						location.href = 'index.php?mn=2';
					}
				},
				error:function (xhr, ajaxOptions, thrownError){
					alert('<?=$lng['Error']?> : '+thrownError);
				}
			});
		});
		
		$("#forgotPassForm").submit(function(e){
			e.preventDefault();
			if($('#femail').val()==''){$("#forMsg").html('<i class="fa fa-exclamation-circle"></i>&nbsp; <?=$lng['Please fill in required fields']?>').fadeIn(200); return false;}
			$("#forMsg").html('<i class="fa fa-refresh fa-spin"></i>&nbsp; One moment please ...').fadeIn(200);
			//return false;

			//alert($('#rpass').val())
			var formData = $(this).serialize();
			
			$.ajax({
				url: "ajax/forgot_password.php",
				dataType: "text",
				data: formData,
				success: function(response){
					//alert(response)
					setTimeout(function(){
						if(response == "suspended"){
							$('#forMsg').html("<i class='fa fa-exclamation-circle'></i>&nbsp; We have not found your email address in our database<? //=$lng['We have not found your email address in our database']?></div>").fadeIn(200);
						}else if(response == 'success'){
							$("#forMsg").html('<i class="fa fa-exclamation-circle"></i>&nbsp; <?=$lng['New password send to your email address']?>').fadeIn(200);
						}else{
							$("#forMsg").html('<i class="fa fa-exclamation-circle"></i>&nbsp; '+response).fadeIn(200);
						}
					},1000);
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("#forMsg").html('<i class="fa fa-exclamation-circle"></i>&nbsp; <?=$lng['Error']?> : '+thrownError).fadeIn(200);
				}
			});
		});

		$('#forgot').click(function(){
			$('#logMsg').hide();
			$('#forMsg').hide();
			$('#logTitle').html('<?=$lng['Request new password']?>');
			$('#logForm').slideUp(200);
			$('#forgotForm').slideDown(200);
		})
		$('#backLogin').click(function(){
			$('#logMsg').hide();
			$('#forMsg').hide();
			$('#forgotForm').slideUp(200);
			$('#logForm').slideDown(200);
			$('#logTitle').html('<?=$lng['Login to our secure server']?>');
		})
		
		$('.langbutton').on('click', function(){
			$.ajax({
				url: "ajax/change_lang.php",
				data: {lng: $(this).data('lng')},
				success: function(ajaxresult){
					location.reload();
				}
			});
		});

	})
		
	</script>	

</body>

</html>