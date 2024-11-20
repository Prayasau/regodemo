	
		<div class="container-fluid" style="xborder:1px solid red">
			<div class="row" style="xborder:1px solid green; padding:20px 25px">
				<div class="col-12">
					<div class="page-header">
						<h4 class=""><?=$lng['Change password']?></h4>
					</div>
					<div class="divider-icon">
						<div><i class="fa fa-lock fa-lg"></i></div>
					</div>
				
					<div class="content">
						<form class="contactForm" id="changePassForm">
							<fieldset>
								<div class="form-group">
									<label for="opass"><?=$lng['Old password']?></label>
									<input type="password" name="opass" class="form-control" />
								</div>
								<div class="form-group">
									<label for="npass"><?=$lng['New password']?></label>
									<input type="password" name="npass" class="form-control" />
								</div>
								<div class="form-group">
									<label for="rpass"><?=$lng['Repeat new password']?></label>
									<input type="password" name="rpass" class="form-control"  />
								</div>
								
								<div id="passMsg" style="color:#b00; font-size:15px; text-align:center; margin-top:-10px; padding-bottom:5px; display:none"></div>
								<div class="contactFormButton">
									<button id="passBtn" style="font-size:16px" type="submit" class="btn btn-default btn-block"><?=$lng['Change password']?></button>
								</div>
								<div id="dump"></div>
							</fieldset>
						</form>       
						<div class="clear"></div>
					</div>
                
				</div>
			</div>
		</div>

<script type="text/javascript">
	
	$(document).ready(function() {

		$("#changePassForm").submit(function(e){
			e.preventDefault();
			$("#passBtn").prop('disabled', true);
			var formData = $(this).serialize();
			//alert(formData)
			$.ajax({
				url: "ajax/change_password.php",
				data: formData,
				success: function(response){
					//$('#dump').html(response)
					if(response=='success'){
						$('#passMsg').html('<?=$lng['Password changed successfuly']?>').fadeIn(200);
					}else if(response=='empty'){
						$('#passMsg').html('<?=$lng['Please fill in required fields']?>').fadeIn(200);
						$("#passBtn").prop('disabled', false);
					}else if(response=='short'){
						$('#passMsg').html('<?=$lng['New password to short min 8 characters']?>').fadeIn(200);
						$("#passBtn").prop('disabled', false);
					}else if(response=='same'){
						$('#passMsg').html('<?=$lng['New passwords are not the same']?>').fadeIn(200);
						$("#passBtn").prop('disabled', false);
					}else if(response=='old'){
						$('#passMsg').html('<?=$lng['Old Password is wrong']?>').fadeIn(200);
						$("#passBtn").prop('disabled', false);
					}else{
						$('#passMsg').html('<?=$lng['Error']?> : '+response).fadeIn(200);
						$("#passBtn").prop('disabled', false);
					}
				},
				error:function (xhr, ajaxOptions, thrownError){
					$('#passMsg').html('<?=$lng['Error']?> : ' + thrownError).fadeIn(200);
					$("#passBtn").prop('disabled', false);
				}
			});
		});

	})
	
</script>






