<?
	$getParameters = getParameters();
	$xdivisions = getDivisions();
	//var_dump($xdivisions); exit;
	$xteams = getTeams();
	$CheckDivision = array();
	foreach ($xteams as $key => $value) {
		$CheckDivision[$value['division']] = $value['division'];
	}
	
?>
	<style>

	</style>
	
	<h2 style="padding-right:60px">
		<i class="fa fa-cog fa-mr"></i> <?=$getParameters[1][$lang]?>
		<span style="display:none; font-style:italic; color:#b00; padding-left:30px" id="sAlert"><i class="fa fa-exclamation-triangle fa-mr"></i><?=$lng['Data is not updated to last changes made']?></span>
	</h2>		
	
	<div class="main">
		<form id="divisionsForm">
			<div style="padding:0 0 0 20px" id="dump"></div>
			<table class="basicTable inputs" id="divisionsTable" border="0">
				<thead>
					<tr>
						<th style="min-width:85px"><?=$lng['Apply']?></th>
						<th style="min-width:85px"><?=$lng['Code']?></th>
						<th style="width:25%"><?=$lng['Thai description']?></th>
						<th style="width:25%"><?=$lng['English description']?></th>
						<th style="width:50%"></th>
					</tr>
				</thead>
				<tbody>
				<? 
				unset($xdivisions[1]);
				foreach($xdivisions as $k=>$v){ ?>
					<tr>
						<td>
							<?if($v['apply_division'] == '1'){

								if($k == $CheckDivision[$k]){
									$dis = 'style="pointer-events: none;opacity: 0.3;"';
								}else{
									$dis = '';
								}
								$selT='checked';
								$valT= $v['apply_division'];
							}else{
								$selT='';
								$dis = '';
								$valT=0;
							}?>
							<input type="checkbox" onclick="DiviChekBox(this,'<?=$k?>');" id="apply_divi_<?=$k?>" name="divisions[<?=$k?>][apply_division]" value="<?=$valT;?>" class="ml-4" <?=$selT;?> <?=$dis;?>>
						</td>
						<td><input maxlength="6" style="font-weight:600" name="divisions[<?=$k?>][code]" type="text" value="<?=$v['code']?>" /></td>
						<td><input name="divisions[<?=$k?>][th]" type="text" value="<?=$v['th']?>" /></td>
						<td><input name="divisions[<?=$k?>][en]" type="text" value="<?=$v['en']?>" /></td>
						<td></td>
					</tr>
				<? } ?>
				</tbody>
			</table>
			<div style="height:10px"></div>
			<button class="btn btn-primary btn-xs" type="button" id="addDivisions"><i class="fa fa-plus fa-mr"></i><?=$lng['Add row']?></button>
			<button class="btn btn-primary btn-fr" id="submitBtn" type="submit"><i class="fa fa-save fa-mr"></i><?=$lng['Update']?></button>
		</form>
	</div>
	
<script>

function DiviChekBox(that,rowID){

	if($(that).is(':checked')){
		$('input#apply_divi_'+rowID).val('1');
	}else{
		$('input#apply_divi_'+rowID).val('0');
	}
}
	
$(document).ready(function() {
			
	$("#addDivisions").click(function(){
		var row = $("#divisionsTable tbody tr").length + 2;
		var addrow = '<tr>'+
			'<td><input type="checkbox" onclick="DiviChekBox(this,'+row+');" id="apply_divi_'+row+'" name="divisions['+row+'][apply_division]" class="ml-4"></td>'+
			'<td><input maxlength="6" style="font-weight:600" name="divisions['+row+'][code]" type="text" /></td>'+
			'<td><input name="divisions['+row+'][th]" type="text" /></td>'+
			'<td><input name="divisions['+row+'][en]" type="text" /></td>'+
			'<td></td>'+
		'</tr>';
		$("#divisionsTable tbody").append(addrow);
		$("#submitBtn").addClass('flash');
		$("#sAlert").fadeIn(200);
	});

	$("#divisionsForm").submit(function(e){ 
		e.preventDefault();
		$("#submitBtn i").removeClass('fa-save').addClass('fa-refresh fa-spin');
		var formData = $(this).serialize();
		$.ajax({
			url: "company/ajax/update_divisions.php",
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
					})
					//setTimeout(function(){location.reload();},2000);
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
			
});

</script>	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
