<?
	$hiddenButtons = '';
	if(isset($_GET['ccid'])){
		$ccid = $_GET['ccid'];
		$attach = array();
		$getAttach = "SELECT * FROM ".$cid."_comm_centers WHERE id='".$ccid."'";
		if($res = $dbc->query($getAttach)){
			if($row = $res->fetch_assoc()){
				$attach = $row;

				if($attach['status'] =='3'){
					$hiddenButtons = 'locked';
				}

				if($attach['sel_emp_ids'] !=''){
					//$getsenttoEmp = getsenttoEmp($attach['sent_to']);
					$getsenttoEmp = getEmployeedatas($attach['sel_emp_ids']);
					$getEmployeeList = getEmployeelistCC($attach['sel_emp_ids']);
				}else{
					$getEmployeeList = getEmployeelistCC($attach['sel_emp_ids']);
				}
			}
		}
	}


?>
<style type="text/css">
.SumoSelect {
    padding: 0px !important; 
    border: none;
    width: 100% !important;
}
</style>
<link href="../assets/css/smart_wizard_theme_arrows.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../assets/css/erpStyle.css?<?=time()?>">
<div style="height:100%; border:0px solid red; position:relative">
		
		<div style="position:absolute; left:0; top:51px; right:60%; bottom:0; background:#fff;">
			
			<div class="smallNav">
				<ul>
					<li><a class="font-weight-bold" style="color:#005588;"><?=$lng['Send to'];?></a>
					<?php if($hiddenButtons == ''){ ?>
						<li onclick="SentToBtn()" class="flr"><a><i class="fa fa-save"></i> &nbsp;Save</a>
					<? } ?>
					<li class="flr"><a href="index.php?mn=802&ccid=<?=$ccid;?>"><i class="fa fa-arrow-left"></i> &nbsp;Back</a>
				</li></ul>
			</div>
			
			<div id="leftTable" style="position:absolute; left:15px; top:45px; right:15px; bottom:15px; background:#fff; overflow-Y:auto; padding:0; overflow-X:scroll">
				
				<table id="usersAccess" class="basicTable" style="margin-top:5px; width:100%; table-layout:auto">
					<thead>
						<tr style="line-height:100%; background:#09c; color:#fff; border-bottom:1px solid #06a">
							
							<th style="color:#fff"><?=$lng['Company']?></th>
							<? if($parameters[1]['apply_param'] == 1){ ?>
								<th style="color:#fff"><?=$parameters[1][$lang]?></th>
							<? } ?>
							<? if($parameters[2]['apply_param'] == 1){ ?>
								<th style="color:#fff"><?=$parameters[2][$lang]?></th>
							<? } ?>
							<? if($parameters[3]['apply_param'] == 1){ ?>
								<th style="color:#fff"><?=$parameters[3][$lang]?></th>
							<? } ?>
							<? if($parameters[4]['apply_param'] == 1){ ?>
								<th style="color:#fff"><?=$parameters[4][$lang]?></th>
							<? } ?>
							
						</tr>
					</thead>
					<tbody>
						<tr style="background:#f9f9f9">
							
							<td style="padding:0">
								<select name="entities" multiple="multiple" id="userEntities">
								<? foreach($entities as $k=>$v){ ?>
									<option value="<?=$k?>"><?=$v[$lang]?></option>
								<? } ?>
								</select>
								<input type="hidden" name="access">	
								<input type="hidden" name="access_selection">	
								
							</td>
							<? if($parameters[1]['apply_param'] == 1){ ?>
								<td style="padding:0">
									<select name="branches" multiple="multiple" id="userBranches">
									<? foreach($branches as $k=>$v){ ?>
										<option value="<?=$k?>"><?=$v[$lang]?></option>
									<? } ?>
									
									</select>	
									
								</td>
							<? } ?>
							<? if($parameters[2]['apply_param'] == 1){ ?>
								<td style="padding:0">
									<select name="divisions" multiple="multiple" id="userDivisions">
									<? foreach($divisions as $k=>$v){ ?>
										<option value="<?=$k?>"><?=$v[$lang]?></option>
									<? } ?>
									
									</select>	
									
								</td>
							<? } ?>
							<? if($parameters[3]['apply_param'] == 1){ ?>
								<td style="padding:0">
									<select name="departments" multiple="multiple" id="userDepartments">
									<? foreach($departments as $k=>$v){ ?>
										<option value="<?=$k?>"><?=$v[$lang]?></option>
									<? } ?>
									
									</select>	
									
								</td>
							<? } ?>
							<? if($parameters[4]['apply_param'] == 1){ ?>
								<td style="padding:0">
									<select name="teams" multiple="multiple" id="userTeams">
									<? foreach($teams as $k=>$v){ ?>
										<option value="<?=$k?>"><?=$v['code']?></option>
									<? } ?>
									
									</select>	
								</td>
							<? } ?>
							
						</tr>
					</tbody>
					<tbody id="accessBody">

					</tbody>
				</table>

			</div>
		</div>
					
		<div style="position:absolute; left:40%; top:51px; right:0; bottom:0; background: #f6f6f6; border-left:1px solid #ddd">
			
			<div class="smallNav">
				<ul style="display: flex !important;">
					<li>
						<div class="searchFilter ml-4" style="margin:0 0 8px 0;width: 200px;">
							<input placeholder="Search filter..." class="sFilter" id="searchFilter" type="text" style="margin:0;border: none !important; background: #ffffcc;">
							<button id="clearSearchbox" type="button" class="clearFilter"><i class="fa fa-times"></i></button>
						</div>
					</li>
					<?
						if($hiddenButtons ==''){ 
							$styleadd = '';
							$titleli = '';
						}else{ 
							$styleadd = 'pointer-events:none';
							$titleli = 'data-toggle="tooltip" title="Can not change! announcement locked!"';
						}
					?>
					<li style="display: flex !important;" <?=$titleli?>>
						
						<select name="addEMp" style="width:100%;background: #ffffcc;<?=$styleadd?>" onchange="addToCommCenter(this.value)" class="form-control ml-1" >
							<option value="">Add more employee</option>
							<? if(!empty($getEmployeeList)){ foreach($getEmployeeList as $k=>$v){
									echo '<option value="'.$v['emp_id'].'" />'.$v['emp_id'].' - '.$v['firstname'].' '.$v['lastname'].'</option>';
								} } ?>
						</select>
					</li>
					<!-- <li class="xhide"><a id="btnEdit"><i class="fa fa-edit"></i> &nbsp;Edit</a>
					</li> -->

					<li class="displayAlertSave" style="display: none;">
						<i><a class="text-danger font-weight-bold">Please save your selection first!</a></i>
					</li>
				</ul>
			</div>

			<!-- <div class="row" style="padding:20px 0px 0px 20px;">
				<div class="col-md-3">
					
				</div>
			</div> -->
			
			<div id="rightTable" style="background:#fff; overflow-Y:auto; padding:20px;">

				<table id="datatableEmppp" class="dataTable nowrap hoverable" style="width:100%;">
					<thead>
						<tr>
							<th><?=$lng['Emp. ID']?></th>
							<th><?=$lng['Employee name']?></th>
							<th><?=$lng['Email']?></th>
							<th><?=$lng['Mobile access']?></th>
							<th><?=$lng['Teams']?></th>
							<th>
								<i data-toggle="tooltip" title="Remove" class="fa fa-trash fa-lg"></i>
							</th>
						</tr>
					</thead>
					<tbody id="relatedata">
						<? if(isset($getsenttoEmp) && is_array($getsenttoEmp)){ 
							foreach($getsenttoEmp as $v){
								if($v['peComm'] == 1){
									$email = $v['personal_email'];
								}elseif($v['weComm'] == 1){
									$email = $v['work_email'];
								}else{
									$email = $v['personal_email'];
								}
							?>
								<tr id="<?=$v['emp_id']?>" data-id="<?=$v['emp_id']?>">
									<td><?=$v['emp_id']?></td>
									<td><?=$v['firstname'].' '.$v['lastname']?></td>
									<td><?=$email?></td>
									<td><?=$noyes01[$v['allow_login']]?></td>
									<td><?=$teams[$v['team']]['code']?></td>
									<td>
										<? if($hiddenButtons ==''){ ?> 
											<a><i title="Remove" id="<?=$v['emp_id']?>" onclick="removeRowemp(this)" class="fa fa-trash fa-lg text-danger"></i></a>
										<? } ?>
									</td>
								</tr>
						<?  }  } ?>
					</tbody>
				</table>
	
			</div>
			
		</div>

	</div>
<script type="text/javascript">

	function removeRowemp(that){
		$('#datatableEmppp tr#'+that.id).remove();	

		SentToBtn();
	}

	function addToCommCenter(empid){

		var ccid = '<?=$ccid?>';
		if(empid && ccid !='') {
			$.ajax({
				type: 'post',
				url: "ajax/getSelectedEmp.php",
				data: {empid: empid, ccid: ccid},
				success: function(result){

					if(result == 'success'){
						$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
							duration: 2,
							callback: function(value){
								window.location.reload();
							}
						})
					}else{
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: '+result,
							duration: 3,
						})
					}
				}
			});
		}
	}
	
	$(document).ready(function(){

		var parameters = <?=json_encode($parameters)?>;

		var datatableEmppp = $('#datatableEmppp').DataTable({

			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: 50,
			filter: true,
			info: true,
			<?=$dtable_lang?>

		});

		$("#searchFilter").keyup(function() {
			datatableEmppp.search(this.value).draw();
		});
		$("#clearSearchbox").click(function() {
			$("#searchFilter").val('');
			datatableEmppp.search('').draw();
		});

		
		//============== Access rights ===============
		function updateAccess(access, values, show){
			//alert(values);

			$.ajax({
				url: ROOT+"settings/ajax/update_user_access.php",
				data: {access: access, values: values},
				dataType: 'json',
				success: function(result){

					if(show == 1){
						$('.displayAlertSave').css('display','block');
						getSelectedTeamEmployee(result.branch,result.division,result.department,result.team);
					}


					$('#userEntities')[0].sumo.unSelectAll();
					$.each(result.entity, function(v){
						$('#userEntities')[0].sumo.selectItem(v);
					})
					if(parameters[1]['apply_param'] == 1){
						$('#userBranches')[0].sumo.unSelectAll();
						$.each(result.branch, function(i,v){
							$('#userBranches')[0].sumo.selectItem(v);
						})
					}
					if(parameters[2]['apply_param'] == 1){
						$('#userDivisions')[0].sumo.unSelectAll();
						$.each(result.division, function(i,v){
							$('#userDivisions')[0].sumo.selectItem(v);
						})
					}
					if(parameters[3]['apply_param'] == 1){
						$('#userDepartments')[0].sumo.unSelectAll();
						$.each(result.department, function(v){
							$('#userDepartments')[0].sumo.selectItem(v);
						})
					}
					if(parameters[4]['apply_param'] == 1){
						$('#userTeams')[0].sumo.unSelectAll();
						$.each(result.team, function(v){
							$('#userTeams')[0].sumo.selectItem(v);
						})
					}
					
					$('#usersAccess tbody#accessBody').html('');
					$('#usersAccess tbody#accessBody').html(result.tableRow); //return false;
				}
			});
		}
		
		$('#userEntities').SumoSelect({
			placeholder: '<?=$lng['Select'].' '.$lng['Company']?>',
			captionFormat: '<?=$lng['Company']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All'].' '.$lng['Company']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});
		$('#userBranches').SumoSelect({
			placeholder: '<?=$lng['Select location']?>',
			captionFormat: '<?=$lng['Locations']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All'].' '.$lng['Locations']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});
		$('#userDivisions').SumoSelect({
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
		$('#userDepartments').SumoSelect({
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
		$('#userTeams').SumoSelect({
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
		
		// $('#userEntities')[0].sumo.disable();
		// $('#userBranches')[0].sumo.disable();
		// $('#userDivisions')[0].sumo.disable();
		// $('#userDepartments')[0].sumo.disable();
		// $('#userTeams')[0].sumo.disable();
		
		$('#userEntities')[0].sumo.unSelectAll();
		if(parameters[1]['apply_param'] == 1){
			$('#userBranches')[0].sumo.unSelectAll();
		}
		if(parameters[2]['apply_param'] == 1){
			$('#userDivisions')[0].sumo.unSelectAll();
		}
		if(parameters[3]['apply_param'] == 1){
			$('#userDepartments')[0].sumo.unSelectAll();
		}
		if(parameters[4]['apply_param'] == 1){
			$('#userTeams')[0].sumo.unSelectAll();
		}
		
		$("#userEntities ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccess('entities', $('#userEntities').val(),1);
		});
		$("#userBranches ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccess('branches', $('#userBranches').val(),1);
		});
		$("#userDivisions ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccess('divisions', $('#userDivisions').val(),1);
		});
		$("#userDepartments ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccess('departments', $('#userDepartments').val(),1);
		});
		$("#userTeams ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccess('teams', $('#userTeams').val(),1);
		});


		var numbersString = '<?=$attach['sent_to']?>';
		var numbersArray = numbersString.split(',');
		updateAccess('teams', numbersArray,0);


		//============== Access rights ===============
	})

	function SentToBtn(){

		var selTeams = $('#userTeams').val();
		var ccid = <?=$ccid;?>; 
		//alert(ccid);

		if(ccid !=''){

			var emparr = [];
			$('#datatableEmppp tbody#relatedata tr').each(function(k,v){
				emparr.push($(this).data('id'));
			})

			if(emparr.length === 0) {

				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;There is no employee selected',
					duration: 3,
				})

			}else{

				$.ajax({
					type : 'post',
					url: "ajax/save_sent_to.php",
					data: {selTeams: selTeams, ccid: ccid, emparr: emparr},
					success: function(result){	

						if(result == 'success'){
							$("body").overhang({
								type: "success",
								message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
								duration: 2,
								callback: function(value){

									var ccid = <?=$ccid?>;
									if(ccid > 0){
										location.reload();
									}else{
										window.location.href = 'index.php?mn=801';
									}
								}
							})
						}else{
							$("body").overhang({
								type: "error",
								message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: '+result,
								duration: 3,
							})
						}
					}
				})
			}
		}
	}

	function getSelectedTeamEmployee(locations,divisions,departments,teams){

		$('#datatableEmppp').DataTable().destroy();

		$.ajax({
			type: 'POST',
			url: "ajax/get_selected_team_emp.php",
			data: {locations: locations, divisions: divisions, departments: departments, teams: teams},
			success: function(result){
				
				$('#datatableEmppp tbody#relatedata tr').remove();
				$('#datatableEmppp tbody#relatedata').append(result);

				var datatableEmppp = $('#datatableEmppp').DataTable({
						//scrollX: true,
						lengthChange: false,
						searching: true,
						ordering: false,
						pagingType: 'full_numbers',
						pageLength: 50,
						filter: true,
						info: true,
						<?=$dtable_lang?>
				});

			}
		})
	}

</script>