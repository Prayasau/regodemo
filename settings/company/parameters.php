<?
	$getParameters = getParameters();

?>

<h2 style="padding-right:60px">
	<i class="fa fa-cog fa-mr"></i> <?=$lng['Parameters']?>
	<span style="display:none; font-style:italic; color:#b00; padding-left:30px" id="sAlert"><i class="fa fa-exclamation-triangle fa-mr"></i><?=$lng['Data is not updated to last changes made']?></span>
</h2>

<div class="main">
	<form id="parameterForm">
		<div style="padding:0 0 0 20px" id="dump"></div>
		<table class="basicTable inputs" id="parameterTable" border="0">
			<thead>
				<tr>
					<th style="min-width:5%"><?=$lng['Apply']?></th>
					<th style="width:20%"><?=$lng['Thai description']?></th>
					<th style="width:25%"><?=$lng['English description']?></th>
					<th style="width:50%"><?=$lng['Note']?></th>
				</tr>
			</thead>
			<tbody>
			<? foreach($getParameters as $k=>$v){ ?>
				<tr>
					<td>
						<?if($v['apply_param'] == '1'){
							$selT='checked';
							$valT= $v['apply_param'];
						}else{
							$selT='';
							$valT=0;
						} ?>

						<input type="checkbox" onclick="PrmChekBox(this,'<?=$k?>');" id="apply_prm_<?=$k?>" name="parameter[<?=$k?>][apply_param]" value="<?=$valT;?>" class="ml-4" <?=$selT;?>>
						
					</td>
					<td><input name="parameter[<?=$k?>][th]" type="text" value="<?=$v['th']?>" <?=$readonly?>></td>
					<td><input name="parameter[<?=$k?>][en]" type="text" value="<?=$v['en']?>" <?=$readonly?>></td>
					<td><span class="pl-2"><?=$v['note']?></span></td>
				</tr>
			<? } ?>
			</tbody>
		</table>
		<div style="height:10px"></div>
		<!-- <button class="btn btn-primary btn-xs" type="button" id="addparameter"><i class="fa fa-plus fa-mr"></i><?=$lng['Add row']?></button> -->
		<button class="btn btn-primary btn-fr" id="submitBtn" type="submit"><i class="fa fa-save fa-mr"></i><?=$lng['Update']?></button>
	</form>
</div>

<script type="text/javascript">

function PrmChekBox(that,rowID){

	if($(that).is(':checked')){
		$('input#apply_prm_'+rowID).val('1');
	}else{
		$('input#apply_prm_'+rowID).val('0');
	}
}
	
$("#parameterForm").submit(function(e){ 
		e.preventDefault();
		$("#submitBtn i").removeClass('fa-save').addClass('fa-refresh fa-spin');
		var formData = $(this).serialize();
		$.ajax({
			url: "company/ajax/update_parameter.php",
			type: 'POST',
			data: formData,
			success: function(result){
				//$('#dump').html(result); return false;
				$("#submitBtn").removeClass('flash');
				$("#sAlert").fadeOut(200);
				if(result == 'success'){
					$("body").overhang({
						type: "success",
						message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
						duration: 2,
						callback: function(value){
							location.reload();
						}
					})

				}else{
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+result,
						duration: 4,
					})
				}
				setTimeout(function(){$("#submitBtn i").removeClass('fa-refresh fa-spin').addClass('fa-save');},500);
			},
			error:function (xhr, ajaxOptions, thrownError){
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
					duration: 4,
				})
			}
		});
	});
	
	$('input').on('keyup', function (e) {
		$("#submitBtn").addClass('flash');
		$("#sAlert").fadeIn(200);
	});

	$('input[type="checkbox"]').on('click', function (e) {
		$("#submitBtn").addClass('flash');
		$("#sAlert").fadeIn(200);
	});
</script>