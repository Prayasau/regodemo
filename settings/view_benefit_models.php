<?
	if(!isset($_GET['mn']) || $_GET['mid'] == ''){
		header('Location: no_access.php'); 
	}

	$dataRP = getActiveRewardPenalties();
	$getBenefitModels = getBenefitModels($_GET['mid']);

	$BMall_data = '';
	if($getBenefitModels[0]['all_data'] !=''){
		$BMall_data = unserialize($getBenefitModels[0]['all_data']);
	}

	$deductionOption = getDeductionOpt();
	$allowanceOption = getAllowanceOpt();

	// echo '<pre>';
	// print_r($deductionOption);
	// print_r($allowanceOption);
	// echo '</pre>';
	// exit;
?>
<style type="text/css">
	
	table.basicTable tbody th{
		border-right: 0px !important;
	}
</style>
<h2><i class="fa fa-cog fa-lg"></i>&nbsp;&nbsp;<?=$lng['Compensations']?></h2>
<div class="main">
	
	<div id="showTable" style="display:xnone; margin-bottom:50px">
		<table border="0" style="width:100%; margin-bottom:8px">
			<tr>
				<td style="width:100%"></td>
				<td style="vertical-align:top; padding-left:10px">
					<button class="btn btn-primary" onclick="window.history.go(-1); return false;" type="button"><?=$lng['Go back']?></button>
				</td>
				<td style="vertical-align:top; padding-left:10px">
					 <button type="button" class="btn btn-primary" onclick="AppendMore();"><i class="fa fa-plus fa-mr"></i> <?=$lng['Add Calculation']?></button> 
				</td>
				
			</tr>
		</table>

		<div id="mainDiv">

			<table class="basicTable" id="mainTbl" border="0">
				<thead>
					<tr>
						<td class="tac sorting_disabled" style="width: 18px;" rowspan="1" colspan="1">
							<i class="fa fa-edit fa-lg"></i>
						</td>
						<th class=""><?=$lng['Name']?></th>
						<th class=""><?=$lng['General information']?></th>
						<th class=""><?=$lng['Data']?></th>
						<th class=""><?=$lng['Condition']?></th>
						<th class=""><?=$lng['Result']?></th>
						<th class=""><?=$lng['Employee group']?></th>
					</tr>
				</thead>
				<tbody id="tbodyMain">
					<tr>
						<th>
							<a title="Edit" data-id="<?=$getBenefitModels[0]['id']?>" class="editItem" >
								<i class="fa fa-edit fa-lg"></i>
							</a>
						</th>
						<td style="vertical-align: top;">
							<input type="text" id="mdlName" name="name[]" value="<?=$getBenefitModels[0]['name']?>" style="border:1px solid #ddd !important;width: 95%;">

							<input disabled type="checkbox" name="apply[]" <?if($getBenefitModels[0]['apply'] == 1){echo 'checked="checked"';}?>>
						</td>
						<td style="vertical-align: top;">
							<table class="basicTable compact inputs" style="width:100%;padding: 0px !important;">
								<tr style="border:0 !important">
									<th class="tal"><?=$lng['Feed']?></th>
									<td>
										<select class="cLevel" name="feed[]" style="width:100%;padding: 0px !important;">
											<option value="Manual" <?if($BMall_data['feed'] == 'Manual'){ echo 'selected="selected"'; }?>><?=$lng['Manual']?></option>
											<option value="Calculated" <?if($BMall_data['feed'] == 'Calculated'){ echo 'selected="selected"'; }?>><?=$lng['Calculated']?></option>
										</select>
									</td>
								</tr>
								<tr style="border:0 !important">
									<th class="tal"><?=$lng['Type']?></th>
									<td>
										<select class="cLevel" name="type[]" style="width:100%;padding: 0px !important;" >
											<option value="Rewards" <?if($BMall_data['type'] == 'Rewards'){ echo 'selected="selected"'; }?>><?=$lng['Rewards']?></option>
											<option value="Penalties" <?if($BMall_data['type'] == 'Penalties'){ echo 'selected="selected"'; }?>><?=$lng['Penalties']?></option>
										</select>
									</td>
								</tr>
								<tr style="border:0 !important">
									<th class="tal"><?=$lng['Linked to']?></th>
									<td>
										<select class="cLevel" name="linked_to[]" style="width:100%;padding: 0px !important;">
											<?
												$allowD = 'disabled'; $dedD = '';
												if($BMall_data['type'] == 'Rewards'){ $allowD = ''; $dedD = 'disabled';}
											?>
											
											<? foreach($allowanceOption as $k => $r){ ?>
												<option value="<?=$k?>" <?=$allowD?> <?if($BMall_data['linked_to'] == $k){ echo 'selected="selected"'; }?>><?=$r?></option>
											<? } ?>
											<? foreach($deductionOption as $k => $r){ ?>
												<option value="<?=$k?>" <?=$dedD?> <?if($BMall_data['linked_to'] == $k){ echo 'selected="selected"'; }?>><?=$r?></option>
											<? } ?>
										</select>
									</td>
								</tr>
							</table>
							
						</td>
						<td style="vertical-align: top;">
							<table class="basicTable compact inputs" style="width:100%;padding: 0px !important;">
								<tr style="border:0 !important">
									<th class="tal"><?=$lng['Early Hours']?></th>
									<td>
										<input type="hidden" name="early_hours[]" value="0">
										<input type="checkbox" name="early_hours[]" value="1" class="mt-2" <?if($BMall_data['early_hours'] == 1){ echo 'checked="checked"'; }?>>
									</td>
								</tr>

								<tr style="border:0 !important">
									<th class="tal"><?=$lng['Late Hours']?></th>
									<td>
										<input type="hidden" name="late_hours[]" value="0">
										<input type="checkbox" name="late_hours[]" value="1" class="mt-2" <?if($BMall_data['late_hours'] == 1){ echo 'checked="checked"'; }?>>
									</td>
								</tr>

								<tr style="border:0 !important">
									<th class="tal"><?=$lng['Early THB']?></th>
									<td>
										<input type="hidden" name="early_thb[]" value="0">
										<input type="checkbox" name="early_thb[]" value="1" class="mt-2" <?if($BMall_data['early_thb'] == 1){ echo 'checked="checked"'; }?>>
									</td>
								</tr>

								<tr style="border:0 !important">
									<th class="tal"><?=$lng['Late THB']?></th>
									<td>
										<input type="hidden" name="late_thb[]" value="0">
										<input type="checkbox" name="late_thb[]" value="1" class="mt-2" <?if($BMall_data['late_thb'] == 1){ echo 'checked="checked"'; }?>>
									</td>
								</tr>

								<tr style="border:0 !important">
									<th class="tal"><?=$lng['Early Event']?></th>
									<td>
										<input type="hidden" name="early_event[]" value="0">
										<input type="checkbox" name="early_event[]" value="1" class="mt-2" <?if($BMall_data['early_event'] == 1){ echo 'checked="checked"'; }?>>
									</td>
								</tr>

								<tr style="border:0 !important">
									<th class="tal"><?=$lng['Late Event']?></th>
									<td>
										<input type="hidden" name="late_event[]" value="0">
										<input type="checkbox" name="late_event[]" value="1" class="mt-2" <?if($BMall_data['late_event'] == 1){ echo 'checked="checked"'; }?>>
									</td>
								</tr>
							</table>
						</td>
						<td style="vertical-align: top;">None</td>
						<td style="vertical-align: top;">
							<table class="basicTable compact inputs" style="width:100%;padding: 0px !important;">
								<tr style="border:0 !important">
									<!-- <th class="tal"><?=$lng['Hour Calculation']?></th> -->
									<td colspan="2">
										<select class="cLevel" name="penalties" style="width:100%;padding:0px !important;">
											<? foreach ($dataRP as $key => $value) { ?>
												<option value="<?=$value['id']?>" <?if($getBenefitModels[0]['penalties'] == $value['id']){ echo 'selected="selected"'; }?>><?=$value['code']?></option>
											<? } ?>
											
										</select>
									</td>
								</tr>
								<!--<tr style="border:0 !important">
									<th class="tal"><?=$lng['THB manual input']?></th>
									<td><input type="text" name="thb_manual[]"></td>
								</tr>
								<tr style="border:0 !important">
									<th class="tal"><?=$lng['Event Calculation']?></th>
									<td>ELFIX1</td>
								</tr>-->
							</table>
						</td>
						<td style="vertical-align: top;">
							<select class="cLevel TeamsSelect" name="teams[]" multiple="multiple" style="width:100%;padding: 0px !important;">
								<? foreach($teams as $k => $v){?>
									<option value="<?=$k?>" <?if(in_array($k, explode(',', $getBenefitModels[0]['teams']))){ echo 'selected="selected"'; }?>><?=$v['code']?></option>
								<? } ?>
							</select>
						</td>
					</tr>

				</tbody>
				<tbody id="NAsction">
					<tr>
						<td class="tal"></td>
						<td class="tal">N/A</td>
						<td colspan="4"></td>
						<td class="tal" style="vertical-align: top;">
							
							<?
								$countT = 0;
								 foreach($teams as $k => $v){?>
									<?if(!in_array($k, explode(',', $getBenefitModels[0]['teams']))){ $countT++; ?>

										<span><?=$v['code']?></span><br>

							<? } } ?>
							<? if($countT == 0){ echo '<span>No Teams</span>'; } ?>
							
						</td>
					</tr>
				</tbody>
			</table>

		</div>



	</div>

</div>
<?php
	
	include('model_prevNext.php');

?>
<script type="text/javascript">

	$(document).ready(function() {

		
		function updateAccess(access, values){

			//alert(values);
			$.ajax({
				url: "ajax/update_user_access.php",
				data: {access: access, values: values},
				dataType: 'json',
				success: function(result){
					//$('#dump').html(result); return false;
					$('#PrevNextScr #userEntities')[0].sumo.unSelectAll();
					$.each(result.entity, function(v){
						$('#PrevNextScr #userEntities')[0].sumo.selectItem(v);
					})
					$('#PrevNextScr #userBranches')[0].sumo.unSelectAll();
					$.each(result.branch, function(i,v){
						$('#PrevNextScr #userBranches')[0].sumo.selectItem(v);
					})
					$('#PrevNextScr #userDivisions')[0].sumo.unSelectAll();
					$.each(result.division, function(i,v){
						$('#PrevNextScr #userDivisions')[0].sumo.selectItem(v);
					})
					$('#PrevNextScr #userDepartments')[0].sumo.unSelectAll();
					$.each(result.department, function(v){
						$('#PrevNextScr #userDepartments')[0].sumo.selectItem(v);
					})
					$('#PrevNextScr #userTeams')[0].sumo.unSelectAll();
					$.each(result.team, function(v){
						$('#PrevNextScr #userTeams')[0].sumo.selectItem(v);
					})
					
					$('#PrevNextScr table#usersAccess tbody#accessBody').html('');
					$('#PrevNextScr table#usersAccess tbody#accessBody').html(result.tableRow); //return false;
				}
			});
		}
		

		$('#PrevNextScr #userEntities').SumoSelect({
			placeholder: '<?=$lng['Select entities']?>',
			captionFormat: '<?=$lng['Entities']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All Entities']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});
		$('#PrevNextScr #userBranches').SumoSelect({
			placeholder: '<?=$lng['Select branches']?>',
			captionFormat: '<?=$lng['Branches']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All Branches']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});
		$('#PrevNextScr #userDivisions').SumoSelect({
			placeholder: '<?=$lng['Select divisions']?>',
			captionFormat: '<?=$lng['Divisions']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All Divisions']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});
		$('#PrevNextScr #userDepartments').SumoSelect({
			placeholder: '<?=$lng['Select departments']?>',
			captionFormat: '<?=$lng['Departments']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All Departments']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});
		$('#PrevNextScr #userTeams').SumoSelect({
			placeholder: '<?=$lng['Select teams']?>',
			captionFormat: '<?=$lng['Teams']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All Teams']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});

		$('#PrevNextScr #userEntities')[0].sumo.unSelectAll();
		$('#PrevNextScr #userBranches')[0].sumo.unSelectAll();
		$('#PrevNextScr #userDivisions')[0].sumo.unSelectAll();
		$('#PrevNextScr #userDepartments')[0].sumo.unSelectAll();
		$('#PrevNextScr #userTeams')[0].sumo.unSelectAll();
		
		$("#PrevNextScr #userEntities ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccess('entities', $('#userEntities').val());
		});
		$("#PrevNextScr #userBranches ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccess('branches', $('#userBranches').val());
		});
		$("#PrevNextScr #userDivisions ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccess('divisions', $('#userDivisions').val());
		});
		$("#PrevNextScr #userDepartments ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccess('departments', $('#userDepartments').val());
		});
		$("#PrevNextScr #userTeams ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccess('teams', $('#userTeams').val());
		});


		

		$('.TeamsSelect').SumoSelect({
			placeholder: '<?=$lng['Select'].' '.$lng['Teams']?>',
			captionFormat: '<?=$lng['Teams']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All'].' '.$lng['Teams']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});

	

		$(document).on('click', '.editItem', function(){
			var mid = $(this).data('id');

				$.ajax({
					type : 'post',
					url  : 'ajax/get_model_data.php',
					data : {id:mid},
					dataType: 'json',
					success : function(data){


						$('#PrevNextScr table th#mName small').remove();
						$('#PrevNextScr table th#mName').html('<small style="font-weight: 700;">Model: '+data.name+'</small>');

						if(data.name == 'Default Manual Feed Early Late'){  //for default model

							var inputView = true;

							$('#PrevNextScr table#tab4 tbody#tab4tbody').css('display','none');
							$('#PrevNextScr table#tab4').append('<tbody id="tabnocondition"><tr><td style="padding: 10px !important;">No Condition</td></tr></tbody>');

							$('#PrevNextScr select[name="feed"] option').attr('disabled',true);
							$('#PrevNextScr select[name="feed"] option[value="'+data.all_data.feed+'"]').attr({'disabled':false, 'selected':true});
							
							$('#PrevNextScr select[name="type"] option').attr('disabled',true);
							$('#PrevNextScr select[name="type"] option[value="'+data.all_data.type+'"]').attr({'disabled':false, 'selected':true});

						}else{

							var inputView = false;

							$('#PrevNextScr table#tab4 tbody#tab4tbody').css('display','block');
							$('#PrevNextScr table#tab4 tbody#tabnocondition').css('display','none');

							$('#PrevNextScr select[name="feed"]').val(data.all_data.feed);
							$('#PrevNextScr select[name="type"]').val(data.all_data.type);
						}

						$('#PrevNextScr input#applyid').attr('checked',data.Napply); //apply checkbox
						
						$('#PrevNextScr input[name="row_id"]').val(data.id);
						$('#PrevNextScr input#edMname').val(data.name).attr('readonly',inputView);
						$('#PrevNextScr input[name="tab_name"]').val(data.tab_name);

						

						SelectLinkedto(data.all_data.type);
						$('#PrevNextScr select[name="linked_to"] option[value="'+data.all_data.linked_to+'"]').attr('selected',true);

						if(data.all_data.early_hours == 1){ var v1 = true; }else{ var v1 = false;}
						$('#PrevNextScr input#early_hoursid').attr('checked', v1);

						if(data.all_data.late_hours == 1){ var v2 = true; }else{ var v2 = false;}
						$('#PrevNextScr input#late_hoursid').attr('checked', v2);

						if(data.all_data.early_thb == 1){ var v3 = true; }else{ var v3 = false;}
						$('#PrevNextScr input#early_thbid').attr('checked', v3);

						if(data.all_data.late_thb == 1){ var v4 = true; }else{ var v4 = false;}
						$('#PrevNextScr input#late_thbid').attr('checked', v4);

						if(data.all_data.early_event == 1){ var v5 = true; }else{ var v5 = false;}
						$('#PrevNextScr input#early_eventid').attr('checked', v5);

						if(data.all_data.late_event == 1){ var v6 = true; }else{ var v6 = false;}
						$('#PrevNextScr input#late_eventid').attr('checked', v6);


						if(data.all_data.acc_el_per_evt == 1){ var v7 = true; }else{ var v7 = false;}
						$('#PrevNextScr input#acc_el_per_evtid').attr('checked', v7);

						$('#PrevNextScr input[name="acc_early"]').val(data.all_data.acc_early);
						$('#PrevNextScr input[name="acc_late"]').val(data.all_data.acc_late);

						$('#PrevNextScr select[name="penalties"]').val(data.penalties);

						if(data.Ateams !=''){
							$('#PrevNextScr #userTeams')[0].sumo.unSelectAll();
							$.each(data.Ateams, function(key, value){
								$('#PrevNextScr #userTeams')[0].sumo.selectItem(value);
							});
						}

						if(data.all_data !=''){
							
							var entityArray = data.all_data.entities.split(',');
							$('#PrevNextScr #userEntities')[0].sumo.unSelectAll();
							$.each(entityArray, function(key, value){
								$('#PrevNextScr #userEntities')[0].sumo.selectItem(value);
							});
						

						
							var branchArray = data.all_data.branches.split(',');
							$('#PrevNextScr #userBranches')[0].sumo.unSelectAll();
							$.each(branchArray, function(key, value){
								$('#PrevNextScr #userBranches')[0].sumo.selectItem(value);
							});
						

						
							var divisionArray = data.all_data.divisions.split(',');
							$('#PrevNextScr #userDivisions')[0].sumo.unSelectAll();
							$.each(divisionArray, function(key, value){
								$('#PrevNextScr #userDivisions')[0].sumo.selectItem(value);
							});
						

						
							var departmentsArray = data.all_data.departments.split(',');
							$('#PrevNextScr #userDepartments')[0].sumo.unSelectAll();
							$.each(departmentsArray, function(key, value){
								$('#PrevNextScr #userDepartments')[0].sumo.selectItem(value);
							});

							updateAccess('teams', data.Ateams);
						}


						$("#PrevNextScr #userTeams ~ .optWrapper .MultiControls .btnOk").click( function () {
							updateAccess('teams', $('#userTeams').val());
						});

						$('#PrevNextScr').modal('toggle');
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

	});

	function getlink(s){

		var income_group = <?=json_encode($allowanceOption)?>;
		var deduct_group = <?=json_encode($deductionOption)?>;

		var group;
		if(s == 'Penalties'){ group = deduct_group }else{ group = income_group };
		var selGroup = $('#PrevNextScr select#sellink');
		selGroup.empty();
		selGroup.append($("<option />").val('').text('Select One'));
		$.each(group, function(i, v) {
			selGroup.append($("<option />").val(i).text(v));
		});	
	}

	function SelectLinkedto(val){

		// $("select#sellink option").remove();
		// if (val == 'Rewards') {
		// 	var opt = '<option value="inc_var"><?=$lng['Variable allowances']?></option>';
		// }else if (val == 'Penalties') {
		// 	var opt = '<option value="ded_var"><?=$lng['Variable deductions']?></option>';
		// }else{
		// 	var opt = '';
		// }

		getlink(val);

		//$("select#sellink").append(opt);
	}
	
	function AppendMore(){

		$('#PrevNextScr input#applyid').attr('checked',false);
		$('#PrevNextScr input[name="row_id"]').val('');
		$('#PrevNextScr input#edMname').val('');
		$('#PrevNextScr input[name="tab_name"]').val('Compensations');


		//SelectLinkedto(that);

		$('#PrevNextScr').modal('toggle');
	}

</script>