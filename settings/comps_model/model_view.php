<!------ Rewards/penalties model -------->
<div class="modal fade" id="RewPenlModel" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 1000px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?=$lng['Compensations Models Overview']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span class="font-weight-bold text-danger">Note: To use any model you need to tick the checkbox first and then click on the add model button!</span>
				<form id="Addmodels">
					<table class="basicTable compact inputs mt-2" style="width:100%; border:1px solid #eee; margin-bottom:10px">
						<thead>
							<tr>
								<th width="10%"><?=$lng['Add Model']?></th>
								<th width="25%"><?=$lng['Name']?></th>
								<th><?=$lng['Description']?></th>
							</tr>
						</thead>
						<tbody>
							<?

							function is_in_array($array, $key, $key_value){
							    $within_array = false;
							    foreach( $array as $k=>$v ){
							        if( is_array($v) ){
							            $within_array = is_in_array($v, $key, $key_value);
							            if( $within_array == true ){
							                break;
							            }
							        } else {
							                if( $v == $key_value && $k == $key ){
							                        $within_array = true;
							                        break;
							                }
							        }
							    }
							    return $within_array;
							}
							
							$activatebutton = 'disabled';
							foreach ($standard_model_array as $key => $value) { 
								if($value['tab_in_view'] == 'Compensations'){
								if(!is_in_array($getBenefitModels['Compensations'], 'code', $value['code'])){ 
									$activatebutton = '';
							?>
						
								<tr>
									<td>
										<input type="checkbox" onclick="setchkbox(this,<?=$value['id'];?>)" class="ml-4 mt-2">
										<input type="hidden" name="apply[]" id="chk_<?=$value['id'];?>" value="0">
									</td>
									<td style="padding-left: 5px!important;" >
										<?=$value['name']?>
										<!-- <textarea rows="3"><?=$value['name']?></textarea> -->
										<input type="hidden" name="mname[]" value="<?=$value['name'];?>" readonly="readonly">
										<input type="hidden" name="mcode[]" value="<?=$value['code'];?>" readonly="readonly">
										<input type="hidden" name="tabName[]" value="Compensations" readonly="readonly">
									</td>
									<td style="padding-left: 5px!important;">
										<?=$value['description']?>
										<!-- <textarea rows="3"><?=$value['description']?></textarea> -->
										<input type="hidden" name="description[]" value="<?=$value['description']?>" readonly="readonly">
									</td>
								</tr>

							<? } } } ?>
						</tbody>
					</table>

					<div style="height:10px"></div>
					<button id="submitBtn" class="btn btn-primary" type="button" <?=$activatebutton;?>><i class="fa fa-save" ></i>&nbsp;&nbsp;<?=$lng['Add Model']?></button>
					<button data-dismiss="modal" style="float:right" class="btn btn-primary" type="button"><i class="fa fa-times"></i>&nbsp;&nbsp;<?=$lng['Cancel']?></button>
				</form>
			</div>
		</div>

	</div>
</div>

<script type="text/javascript">

	function setchkbox(that,rowid){

		if($(that).is(':checked')){
			$('#chk_'+rowid).val('1');
		}else{
			$('#chk_'+rowid).val('0');
		}
	}
	
	$(document).on('click', '#submitBtn', function(){

		var frm = $('#Addmodels');
		var data = frm.serialize();

		$.ajax({
			url: "ajax/save_newbenefit_model_data.php",
			type: 'POST',
			data: data,
			success: function(result){

				if(result == 'success'){

					$("body").overhang({
						type: "success",
						message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Benefit model data saved successfully']?>',
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