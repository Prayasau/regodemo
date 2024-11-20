<?
	
	$xgroups = getgroups();
	//var_dump($xdepartments); exit;
	$xteams = getTeams();
	$Checkgrp = array();
	foreach ($xteams as $key => $value) {
		$Checkgrp[$value['groups']] = $value['groups'];
	}
	
?>
	<style>

	</style>
	
	<h2 style="padding-right:60px">
		<i class="fa fa-cog fa-mr"></i> <?=$lng['Groups']?>
		<span style="display:none; font-style:italic; color:#b00; padding-left:30px" id="sAlert"><i class="fa fa-exclamation-triangle fa-mr"></i><?=$lng['Data is not updated to last changes made']?></span>
	</h2>		
	
	<div class="main">
		<form id="groupForm">
			<div style="padding:0 0 0 20px" id="dump"></div>
					<table class="basicTable inputs" id="groupTable" border="0">
						<thead>
							<tr>
								<th style="min-width:85px"><?=$lng['Apply']?></th>
								<th style="min-width:85px"><?=$lng['Code']?></th>
								<th style="width:25%; min-width:280px"><?=$lng['Thai description']?></th>
								<th style="width:25%; min-width:280px"><?=$lng['English description']?></th>
								<th style="width:50%"></th>
							</tr>
						</thead>
						<tbody>
						<? 
						unset($xgroups[1]);
						foreach($xgroups as $k=>$v){ ?>
							<tr>
								<td>
									<?if($v['apply_group'] == '1'){

										if($k == $Checkgrp[$k]){
											$dis = 'style="pointer-events: none;opacity: 0.3;"';
										}else{
											$dis = '';
										}
										$selT='checked';
										$valT= $v['apply_group'];
									}else{
										$selT='';
										$dis = '';
										$valT=0;
									}?>
									<input type="checkbox" onclick="groupChekBox(this,'<?=$k?>');" id="apply_divi_<?=$k?>" name="groups[<?=$k?>][apply_group]" value="<?=$valT;?>" class="ml-4" <?=$selT;?> <?=$dis;?>>
								</td>
								<td><input maxlength="6" style="font-weight:600" name="groups[<?=$k?>][code]" type="text" value="<?=$v['code']?>" /></td>
								<td><input name="groups[<?=$k?>][th]" type="text" value="<?=$v['th']?>" /></td>
								<td><input name="groups[<?=$k?>][en]" type="text" value="<?=$v['en']?>" /></td>
								<td></td>
							</tr>
						<? } ?>
						</tbody>
					</table>
					<div style="height:10px"></div>
					<button class="btn btn-primary btn-xs" type="button" id="addGroups"><i class="fa fa-plus fa-mr"></i><?=$lng['Add row']?></button>
				<button class="btn btn-primary btn-fr" id="submitBtn" type="submit"><i class="fa fa-save fa-mr"></i><?=$lng['Update']?></button>
			</div>
		</form>
	</div>
	
<script>

function groupChekBox(that,rowID){

	if($(that).is(':checked')){
		$('input#apply_divi_'+rowID).val('1');
	}else{
		$('input#apply_divi_'+rowID).val('0');
	}
}
	
$(document).ready(function() {
			
	$("#addGroups").click(function(){
		var row = $("#groupTable tbody tr").length + 2;
		var addrow = '<tr>'+
			'<td><input type="checkbox" class="ml-4" name="groups['+row+'][apply_group]" onclick="groupChekBox(this,'+row+');" id="apply_divi_'+row+'"/></td>'+
			'<td><input style="font-weight:600" maxlength="6" name="groups['+row+'][code]" type="text" /></td>'+
			'<td><input name="groups['+row+'][th]" type="text" /></td>'+
			'<td><input name="groups['+row+'][en]" type="text" /></td>'+
			'<td></td>'+
		'</tr>';
		$("#groupTable tbody").append(addrow);
		$("#submitBtn").addClass('flash');
		$("#sAlert").fadeIn(200);
	});

	$("#groupForm").submit(function(e){ 
		e.preventDefault();
		$("#submitBtn i").removeClass('fa-save').addClass('fa-refresh fa-spin');
		var formData = $(this).serialize();
		$.ajax({
			url: "company/ajax/update_groups.php",
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
			
});

</script>	
