<div class="modal fade" id="Payroll_modellist" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 700px;">
		<div class="modal-content">
			<form id="AddmodelsPM">
				<div class="modal-header">
					<h5 class="modal-title"><?=$lng['Payroll Models']?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<table class="basicTable inputs">
						<thead>
							<tr>
								<th colspan="2"><?=strtoupper($lng['Add new']).' '.strtoupper($lng['Model'])?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th><?=$lng['ID']?></th>
								<td>
									<input type="text" name="code">
								</td>
							</tr>
							<tr>
								<th><?=$lng['Name']?></th>
								<td>
									<input type="text" name="name">
								</td>
							</tr>
							<tr>
								<th><?=$lng['Description']?></th>
								<td>
									<input type="text" name="description">
								</td>
							</tr>
						</tbody>

					</table>

				</div>

				<div class="modal-footer">
					<button id="submitBtnp" type="button" class="btn btn-primary"><i class="fa fa-save mr-2"></i><?=$lng['Save']?></button>
	        		<button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$lng['Close']?></button>
				</div>
			</form>
		</div>

	</div>
</div>

<script type="text/javascript">

	
	$(document).on('click', '#submitBtnp', function(){

		var frm = $('#AddmodelsPM');
		var data = frm.serialize();

		$.ajax({
			url: "ajax/save_payroll_model_data.php",
			type: 'POST',
			data: data,
			success: function(result){

				if(result == 'success'){

					$("body").overhang({
						type: "success",
						message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Payroll model data saved successfully']?>',
						duration: 3,
						callback: function (value) {
							location.reload();
						}
					})
						
				}else{

					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: '+result,
						duration: 3,
						callback: function (value) {
							location.reload();
						}
					})
				}

			},
			error:function (xhr, ajaxOptions, thrownError){
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
					duration: 4,
					callback: function (value) {
						location.reload();
					}
				})
			}

		});
	})
</script>