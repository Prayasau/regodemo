<?
	$getParameters = getParameters();
	$xentities = getEntities();
	$xbranches = getBranches();
	$xdivisions = getDivisions();
	$xdepartments = getDepartments();
	$xteams = getTeams();
	$xgroups = getgroups();
	$getAllEmployeeTeams = getAllEmployeeTeams();
	$getDefaultTeam = getDefaultTeam();
	//var_dump($xteams); exit;

	//echo '<pre>';
	//print_r($getDefaultTeam);
	//print_r($xteams);
	//echo '</pre>';
	//exit;
	
?>
	<style>
		table.basicTable td select {
			padding:3px 8px !important;
		}
	</style>
	
	<h2 style="padding-right:60px">
		<i class="fa fa-cog fa-mr"></i> <?=$lng['Teams']?>
		<span style="display:none; font-style:italic; color:#b00; padding-left:30px" id="sAlert"><i class="fa fa-exclamation-triangle fa-mr"></i><?=$lng['Data is not updated to last changes made']?></span>
	</h2>	
	
	<div class="main">
		<form id="teamsForm">
			<div style="padding:0 0 0 20px" id="dump"></div>
				<table class="basicTable inputs" id="teamsTable" border="0">
					<thead>
						<tr>
							<th style="min-width:85px"><?=$lng['Apply']?><i class="man"></i></th>
							<th style="min-width:85px"><?=$lng['Code']?><i class="man"></i></th>
							<th style="width:20%; min-width:200px"><?=$lng['Thai description']?><i class="man"></i></th>
							<th style="width:20%; min-width:200px"><?=$lng['English description']?><i class="man"></i></th>
							<!-- <th style="min-width:100px"><?=$lng['Company']?><i class="man"></i></th>
							<th style="min-width:100px"><?=$lng['Location']?><i class="man"></i></th>
							<th style="min-width:100px"><?=$getParameters[1][$lang]?><i class="man"></i></th>
							<th style="min-width:80px"><?=$getParameters[2][$lang]?><i class="man"></i></th>
							<th style="min-width:80px"><?=$getParameters[4][$lang]?><i class="man"></i></th> -->
							<th style="width:80%"></th>
						</tr>
					</thead>
					<tbody>
					<? 
					unset($xteams[1]);
					foreach($xteams as $key=>$val){ ?>
						<tr>
							<td>
								<?if($val['apply_team'] == '1'){

									if($key == $getAllEmployeeTeams[$key] || $key == $getDefaultTeam){ 
										$dis = 'style="pointer-events: none;opacity: 0.3;"';
									}else{
										$dis = '';
									}

									$selT='checked';
									$valT= $val['apply_team'];

								}else{
									$selT='';
									$dis = '';
									$valT=0;
								}?>
								<input type="checkbox" onclick="TeamChekBox(this,'<?=$key?>');" id="apply_team_<?=$key?>" name="teams[<?=$key?>][apply_team]" value="<?=$valT;?>" class="ml-4" <?=$selT;?> <?=$dis;?>>
							</td>
							<td><input readonly maxlength="6" style="font-weight:600" name="teams[<?=$key?>][code]" type="text" value="<?=$val['code']?>" /></td>
							<td><input name="teams[<?=$key?>][th]" type="text" value="<?=$val['th']?>" /></td>
							<td><input name="teams[<?=$key?>][en]" type="text" value="<?=$val['en']?>" /></td>

							
							<td></td>
						</tr>
					<? } ?>
					</tbody>
				</table>
				<div style="height:10px"></div>
				<button class="btn btn-primary btn-xs" type="button" id="addTeam"><i class="fa fa-plus fa-mr"></i><?=$lng['Add row']?></button>
				<button class="btn btn-primary btn-fr" id="submitBtn" type="submit"><i class="fa fa-save fa-mr"></i><?=$lng['Update']?></button>
			</div>
		</form>
	</div>
	
<script>

function TeamChekBox(that,rowID){

	if($(that).is(':checked')){
		$('input#apply_team_'+rowID).val('1');
	}else{
		$('input#apply_team_'+rowID).val('0');
	}
}
	
$(document).ready(function() {
	
	$(document).on('change','.selEntity', function() {
		var options = $(this).closest('tr').find('.selBranch');
		$.ajax({
			url: "company/ajax/get_branches.php",
			data: {entity: $(this).val()},
			dataType: 'json',
			success: function(result){
				//$('#dump').html(result); //return false;
				options.empty();
				$.each(result, function(k,v) {
					options.append($("<option />").val(k).text(v));
					//alert(v)
				});				
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
	
	$("#addTeam").click(function(){
		var row = $("#teamsTable tbody tr").length + 2;
		var addrow = '<tr>'+
			'<td><input name="teams['+row+'][apply_team]" type="checkbox" onclick="TeamChekBox(this, '+row+');" id="apply_team_'+row+'" class="ml-4"></td>'+
			'<td><input style="font-weight:600" maxlength="6" name="teams['+row+'][code]" type="text" /></td>'+
			'<td><input name="teams['+row+'][th]" type="text" /></td>'+
			'<td><input name="teams['+row+'][en]" type="text" /></td>'+
			'<td></td>'+
		'</tr>';
		$("#teamsTable tbody").append(addrow);
		$("#submitBtn").addClass('flash');
		$("#sAlert").fadeIn(200);
	});

	$("#teamsForm").submit(function(e){ 
		e.preventDefault();
		$("#submitBtn i").removeClass('fa-save').addClass('fa-refresh fa-spin');
		var formData = $(this).serialize();
		$.ajax({
			url: "company/ajax/update_teams.php",
			type: 'POST',
			data: formData,
			success: function(result){
				//$('#dump').html(result); return false;
				$("#submitBtn i").removeClass('fa-refresh fa-spin').addClass('fa-save');
				$("#submitBtn").removeClass('flash');
				$("#sAlert").fadeOut(200);
				if(result == 'empty'){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Please fill in required fields']?>',
						duration: 2,
					})
					return false;
					//setTimeout(function(){location.reload();},2000);
				}else if(result == 'success'){
					$("body").overhang({
						type: "success",
						message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
						duration: 2,
						callback: function(value){
							location.reload();
						}
					})
					//setTimeout(function(){location.reload();},2000);
				}else{
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+result,
						duration: 4,
					})
					return false;
				}

				//window.location.reload();
				//setTimeout(function(){$("#submitBtn i").removeClass('fa-refresh fa-spin').addClass('fa-save');},500);
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

	$('select').on('change', function (e) {
		$("#submitBtn").addClass('flash');
		$("#sAlert").fadeIn(200);
	});
			
});

</script>	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
