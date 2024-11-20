<?php
	$teamAll = array();
	$deptAll = array();
	$postAll = array();
	foreach ($getSelmonPayrollDatass as $key => $value) {
		$teamall[] = $value['team'];
		$deptAll[] = $value['department'];
		$postAll[] = $value['position'];
	}

	if(!empty($teamall)){
		$arrayunique = array_unique($teamall);
		$implodeArrs = implode(',', $arrayunique);
	}

	if(!empty($deptAll)){
		$arrayunique = array_unique($deptAll);
		$implodeArrsdep = implode(',', $arrayunique);
	}

	if(!empty($postAll)){
		$arrayunique = array_unique($postAll);
		$implodeArrsPos = implode(',', $arrayunique);
	}

	if(count($entities) > 1){ 

		$value1 = 1;
	 } 
	 else
	 {
		$value1 =0;

	 }

	 if($parameters[1]['apply_param'] == 1 && count($branches) > 1){ 

	 	$value2 = 1;
	 } 
	 else
	 {
	 	$value2 = 0;
	 }

	 if($parameters[2]['apply_param'] == 1 && count($divisions) > 1){ 
	 	$value3 = 1;
	 } 
	 else
	 {
	 	$value3 = 0;
	 }

	 if($parameters[3]['apply_param'] == 1 && count($departments) > 1){ 
	 	$value4 = 1;
	 } 
	 else
	 {
	 	$value4 =0;
	 }

	 if($parameters[4]['apply_param'] == 1 && count($teams) > 1){ 
	 	$value5 = 1;
	 }
	 else
	 {
	 	$value5 = 0;
	 } 
		
	if(count($positions) > 1){ 
		$value6 = 1;
	 } 
	 else
	 {
	 	$value6 = 0;
	 }


	 $combineTHvalue= $value1 + $value2 + $value3 + $value4 + $value5 + $value6 ;


	 if($combineTHvalue == '1')
	 {
	 	$left_value = '10';
	 	$right_value = '90';
	 }	 
	 else if($combineTHvalue == '2')
	 {
	 	$left_value = '20';
	 	$right_value = '80';
	 } 
	 else if($combineTHvalue == '3')
	 {
	 	$left_value = '30';
	 	$right_value = '70';
	 }	 
	 else if($combineTHvalue == '4')
	 {
	 	$left_value = '40';
	 	$right_value = '60';
	 }	 
	 else if($combineTHvalue == '5')
	 {
	 	$left_value = '50';
	 	$right_value = '50';
	 }	 
	 else if($combineTHvalue == '6')
	 {
	 	$left_value = '50';
	 	$right_value = '50';
	 }	 
	 else if($combineTHvalue == '0')
	 {
	 	$left_value = '0';
	 	$right_value = '100';
	 }




?>

<style type="text/css">
.SumoSelect {
    padding: 4px !important; 
    border: none;
    width: 100% !important;
}

.SumoSelect > .optWrapper > .options li.opt {
	width: 100% !important;
}

.smallNav {
	background: #fff!important;
	height:31px; 
	padding:0; 
	/*border-bottom:1px solid #ddd;*/
	font-weight:600;
	margin: 10px;
	border-bottom: none!important;
}
.smallNav ul {
	display:inline-block;
	padding:0;
	margin:0;
	width:100%;
}
.smallNav li {
	display:inline-block;
	margin:0;
	padding:0;
}
.smallNav li.flr {
	float:right;
}
.smallNav li.flr a {
	border-right:0;
	border-left:1px solid #ddd;
}
.smallNav li a {
	display:block;
	line-height:30px;
	padding:0 15px;
	color:#333;
	text-decoration:none;
	border-right:1px solid #ddd;
}
.smallNav li a:hover {
	background: rgba(0,0,0,0.1);
	color:#000;
}
.smallNav li a.activ {
	background: rgba(0,0,0,0.1);
	color:#000;
}
.customSelectcss {
    padding: 5px 8px !important;
}



.select2-container--default .select2-selection--single {
    border: 1px #ddd solid !important;
    padding: 3px;
    height: 32px;
    border-radius: 0px;
}

</style>
<div style="height:100%; border:0px solid red; position:relative;">

	<div style="position:absolute; left:0; top:0px; right:<?php echo $right_value.'%';?>; bottom:0; background:#fff;">
	

		
		<div id="leftTable" style="position:absolute; left:7px; top:35px; right:7px; bottom:15px; background:#fff; overflow-Y:auto; padding:0; overflow-X:scroll">
			
			<table id="usersAccess" class="basicTable" style="margin-top:28px; width:100%; table-layout:auto">
				<thead>
					<tr style="line-height:100%; background:#09c; color:#fff; border-bottom:1px solid #06a">
						
						<?if(count($entities) > 1){ ?>
							<th style="color:#fff"><?=$lng['Company']?></th>
						<? } ?>
						<? if($parameters[1]['apply_param'] == 1 && count($branches) > 1){ ?>
							<th style="color:#fff"><?=$parameters[1][$lang]?></th>
						<? } ?>
						<? if($parameters[2]['apply_param'] == 1 && count($divisions) > 1){ ?>
							<th style="color:#fff"><?=$parameters[2][$lang]?></th>
						<? } ?>
						<? if($parameters[3]['apply_param'] == 1 && count($departments) > 1){ ?>
							<th style="color:#fff"><?=$parameters[3][$lang]?></th>
						<? } ?>
						<? if($parameters[4]['apply_param'] == 1 && count($teams) > 1){ ?>
							<th style="color:#fff"><?=$parameters[4][$lang]?></th>
						<? } ?>
						<? if(count($positions) > 1){ ?>
							<th style="color:#fff"><?=$lng['Position']?></th>
						<? } ?>
						
					</tr>
				</thead>
				<tbody>
					<tr style="background:#f9f9f9">
						<input type="hidden" name="access">	
						<input type="hidden" name="access_selection">	
								
						<?if(count($entities) > 1){ ?>
							<td style="padding:0">
								<select name="entities" multiple="multiple" id="userEntities">
								<? foreach($entities as $k=>$v){ ?>
									<option value="<?=$k?>"><?=$v[$lang]?></option>
								<? } ?>
								
								<? /*foreach($entities as $k=>$v){if(in_array($k, explode(',', $_SESSION['rego']['sel_entities']))){ ?>
								<option value="<?=$k?>"><?=$v[$lang]?></option>
								<? } }*/ ?>
								</select>
								
							</td>
						<? } ?>
						<? if($parameters[1]['apply_param'] == 1 && count($branches) > 1){ ?>
							<td style="padding:0">
								<select name="branches" multiple="multiple" id="userBranches">
								<? foreach($branches as $k=>$v){ ?>
									<option value="<?=$k?>"><?=$v[$lang]?></option>
								<? } ?>
								<? /*foreach($branches as $k=>$v){if(in_array($k, explode(',', $_SESSION['rego']['sel_branches']))){ ?>
								<option value="<?=$k?>"><?=$v[$lang]?></option>
								<? }}*/ ?>
								</select>	
								
							</td>
						<? } ?>
						<? if($parameters[2]['apply_param'] == 1 && count($divisions) > 1){ ?>
							<td style="padding:0">
								<select name="divisions" multiple="multiple" id="userDivisions">
								<? foreach($divisions as $k=>$v){ ?>
									<option value="<?=$k?>"><?=$v[$lang]?></option>
								<? } ?>
								<? /*foreach($divisions as $k=>$v){if(in_array($k, explode(',', $_SESSION['rego']['sel_divisions']))){ ?>
								<option value="<?=$k?>"><?=$v[$lang]?></option>
								<? }}*/ ?>
								</select>	
								
							</td>
						<? } ?>
						<? if($parameters[3]['apply_param'] == 1 && count($departments) > 1){ ?>
							<td style="padding:0">
								<select name="departments" multiple="multiple" id="userDepartments">
								<? foreach($departments as $k=>$v){ ?>
									<option value="<?=$k?>"><?=$v[$lang]?></option>
								<? } ?>
								<? /*foreach($departments as $k=>$v){if(in_array($k, explode(',',$_SESSION['rego']['sel_departments']))){ ?>
								<option value="<?=$k?>"><?=$v[$lang]?></option>
								<? }}*/ ?>
								</select>	
								
							</td>
						<? } ?>
						<? if($parameters[4]['apply_param'] == 1 && count($teams) > 1){ ?>
							<td style="padding:0">
								<select name="teams" multiple="multiple" id="userTeams">
								<? foreach($teams as $k=>$v){ ?>
									<option value="<?=$k?>"><?=$v['code']?></option>
								<? } ?>
								<? /*foreach($teams as $k=>$v){if(in_array($k, explode(',',$_SESSION['rego']['sel_teams']))){ ?>
								<option value="<?=$k?>"><?=$v[$lang]?></option>
								<? }}*/ ?>
								</select>	
							</td>
						<? } ?>

						<? if(count($positions) > 1){ ?>
							<td style="padding:0">
								<select name="position" multiple="multiple" id="userPosition">
									<!-- <option selected value=""><?=$lng['Select'].' '.$lng['Positions']?></option> -->
									<? foreach($positions as $k=>$v){
											echo '<option';
											//if($k == 1){echo ' selected';}
											echo ' value="'.$k.'">'.$v[$lang].'</option>';
										} ?>
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
				
	<div style="position:absolute; left:<?php echo $left_value.'%';?>; top:0px; right:0; bottom:0; background: #f6f6f6; border-left:1px solid #ddd"> 
	
		
		<div class="smallNav">
			<ul style="display: flex !important;">
				<li>
					<div class="searchFilterd ml-3" style="margin: 0 0 8px 0;margin-left: 0px!important;">
						<input placeholder="Search filter..." class="sFilter" id="searchFilterd" type="text" style="margin:0;border: 1px #ddd solid; background: #ffffff;width: auto;" autocomplete="off">
						<!-- <button id="clearSearchboxd" type="button" class="clearFilter"><i class="fa fa-times"></i></button> -->
					</div>
					
				</li>
				<li>
					<button style="border: 0;padding: 3px 11px !important;line-height: 26px !important;margin: 0;color: #ccc;border-radius: 0 !important;background: #eee;" id="clearSearchbox" type="button" class="clearFilter"><i class="fa fa-times"></i></button>

				</li>
				<li style="padding-right:5px!important;padding-left: 2px!important;">
					<select class="select2 customSelectcss ml-1 button" onchange="addTopayrollemp(this.value)" name="emp_name" style="background: #ffffff;font-weight: 600;">
						<option selected disabled value=""><?=$lng['Select employees']?></option>
						<option value="all"><?=$lng['Add all employees']?></option>
						<? if(!empty($missing_emps)){ foreach($missing_emps as $k=>$v){
									echo '<option value="'.$k.'" />'.$k.' - '.$v.'</option>';
						 		} } ?>
					</select>
				</li>
				<li id="showHideClmss" style="padding-right: 5px!important;">
					<select class="customSelectcss ml-1 button" multiple="multiple" id="showHideclm" style="background: #ffffff;font-weight: 600;padding: 1px !important;">
						<?	foreach($eatt_colsRD as $k=>$v){
								echo '<option class="optCol" value="'.$k.'" ';
								if(in_array($k, $shColsR)){echo 'selected ';}
								echo '>'.$v[1].'</option>';
						} ?>
					</select>
				</li>
				<li>
					<select class="select2 customSelectcss button" id="empStatus" style="background: #ffffff;font-weight: 600;">
						<option selected value=""><?=$lng['All employees']?></option>
						<? foreach($emp_status as $k=>$v){
								echo '<option';
								if($k == 1){echo ' selected';}
								echo ' value="'.$k.'">'.$v.'</option>';
							} ?>
					</select>
				</li>
				
				<!-- <li class="flr Clearselection">
					<a class="text-white bg-danger"><i class="fa fa-trash"></i> <?=$lng['Clear Selection']?></a>
				</li> -->

			</ul>
		</div>

		
		
		<div id="rightTable" style="background:#fff; overflow-Y:auto; padding:10px 15px 20px 15px;">

			<table id="datatableEmppp" class="dataTable nowrap hoverable" style="width:100%;">
				<thead>
					<tr>
						<th><?=$lng['Emp. ID']?></th>
						<th><?=$lng['Employee name']?></th>
						
						<? if($parameters[4]['apply_param'] == 1){ ?>
							<!-- <th><?=$parameters[4][$lang]?></th> -->
						<? } ?>
					
						<th class="tal"><?=$lng['Position']?></th>
						<th class="tal"><?=$lng['Company']?></th>
						<th class="tal"><?=$lng['Location']?></th>
						<th class="tal"><?=$lng['Division']?></th>
						<th class="tal"><?=$lng['Department']?></th>
						<th class="tal"><?=$lng['Teams']?></th>
						
						<th>
							<i data-toggle="tooltip" title="Remove" class="fa fa-trash fa-lg"></i>
						</th>
					</tr>
				</thead>
				<tbody id="relatedata<?=$row['id']?>">
						<? foreach($getSelmonPayrollDatass as $key => $row){ ?>
							<tr id="<?=$row['emp_id']?>" data-id="<?=$row['emp_id']?>">
								<td><?=$row['emp_id']?></td>
								<td><?=$row['emp_name_'.$lang]?></td>
								<td><?=$positions[$row['position']][$lang]?></td>
								<td><?=$entities[$row['entity']][$lang]?></td>
								<td><?=$branches[$row['branch']][$lang]?></td>
								<td><?=$divisions[$row['division']][$lang]?></td>
								<td><?=$departments[$row['department']][$lang]?></td>
								<td><?=$teams[$row['team']][$lang]?></td>
								<td>
									<a title="Remove" id="<?=$row['emp_id']?>" onclick="removeRowemp(this)">
										<i class="fa fa-trash text-danger fa-lg"></i>
									</a>
								</td>
							</tr>
						<? } ?>
				</tbody>
			</table>
			<div class="row">
				<div class="col-md-2" style="margin: -30px 0px 0px 0px;margin-left: auto;margin-right: auto;min-width: 38%;">
					<select id="pageLengthd" class="button btn-fl">
						<option selected value="">Rows / page</option>
						<option value="10">10 Rows / page</option>
						<option value="15">15 Rows / page</option>
						<option value="20">20 Rows / page</option>
						<option value="30">30 Rows / page</option>
						<option value="40">40 Rows / page</option>
						<option value="50">50 Rows / page</option>
					</select>
				</div>
			</div>

		</div>
		
	</div>

</div>
<script type="text/javascript">

	function addTopayrollemp(empid){

		if(empid !=''){
			
			$.ajax({
				url: "ajax/add_emptopayroll.php",
				data: {empid: empid},
				success: function(result){
					
					if($.trim(result) != 'success'){
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp; <b><?=$lng['Error']?></b>: '+result,
							duration: 3,
							callback: function(v){
								window.location.reload();
							}
						})
					}else{
						window.location.reload();
					}
				}
			})
		}
	}

	function removeRowemp(that){

		var mid = '<?=$_GET['mid']?>';

		$("body").overhang({
			type: "confirm",
			primary: "#228B22",
			//accent: "#27AE60",
			yesColor: "#3498DB",
			message: "Do you want to continue?",
			overlay: true,
			callback: function (value) {
				if(value){
					$.ajax({
						url: "ajax/remove_emp_from_payroll.php",
						data: {emp_id: that.id, mid:mid},
						success: function(result){

							$('#datatableEmppp tr#relatedata'+that.id).remove();
							window.location.reload();
						}
					});
				}
			}
		});
	}
	
	$(document).ready(function(){

		var eCols = <?=json_encode($emptyColsR)?>;
		var parameters = <?=json_encode($parameters)?>;
		var entitiesCount = <?=count($entities)?>;
		var branchesCount = <?=count($branches)?>;
		var divisionsCount = <?=count($divisions)?>;
		var departmentsCount = <?=count($departments)?>;
		var teamsCount = <?=count($teams)?>;
		var positionsCount = <?=count($positions)?>;
		var tableCols = <?=json_encode($eatt_colsRD)?>;

		var datatableEmppp = $('#datatableEmppp').DataTable({

			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: 10,
			filter: true,
			info: true,
			autoWidth: false,
			<?=$dtable_lang?>
			columnDefs: [
				{"targets": eCols, "visible": false, "searchable": false},
				{ "width": "50px", "targets": 0 },
				{ "width": "138px", "targets": 1 },
				{ "width": "50px", "targets": 2 },
				{ "width": "50px", "targets": 3 },
				{ "width": "50px", "targets": 4 },
				{ "width": "50px", "targets": 5 },
				{ "width": "50px", "targets": 6 },
				{ "width": "50px", "targets": 7 },
			]

		});

		$("#searchFilterd").keyup(function() {
			datatableEmppp.search(this.value).draw();
		});
		$("#clearSearchboxd").click(function() {
			$("#searchFilterd").val('');
			datatableEmppp.search('').draw();
		});		

		$("#clearSearchbox").click(function() {
			$("#searchFilterd").val('');
			datatableEmppp.search('').draw();
		});
		$(document).on("change", "#pageLengthd", function(e) {
			if(this.value > 0){
				datatableEmppp.page.len( this.value ).draw();
			}
		})


		$('.Clearselection').confirmation({
			container: 'body',
			rootSelector: '.Clearselection',
			singleton: true,
			animated: 'fade',
			placement: 'left',
			popout: true,
			html: true,
			title: '<?=$lng['Are you sure']?>',
			//btnOkIcon: '',
			//btnCancelIcon: '',
			btnOkLabel: '<?=$lng['Delete']?>',
			btnCancelLabel: '<?=$lng['Cancel']?>',
			onConfirm: function() { 
				$.ajax({
					url: "tabs/ajax/clearSelection.php",
					data:{},
					success: function(result){
						if(result == 'success'){
							$("body").overhang({
								type: "success",
								message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data removed successfully']?>',
								duration: 2,
								callback: function(v){
									window.location.reload();
								}
							})
						}
					},
					error:function (xhr, ajaxOptions, thrownError){
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
							duration: 4,
						})
					}
				});
			}
		});

		//======= For position =============
		/*function updatePotions(position, team, department, division, branch){

			$.ajax({
				url: "tabs/ajax/position_selection.php",
				data: {position: position, team: team, department: department, division: division, branch: branch},
				success: function(result){

					window.location.reload();

				}
			})

		}*/
		//======= For position =============

		
		//============== Access rights ===============
		function updateAccessEPG(access, values, show){
			//alert(values);

			if(values !=''){

				$.ajax({
					url: ROOT+"settings/ajax/update_user_access.php",
					data: {access: access, values: values},
					dataType: 'json',
					success: function(result){

						if(show == 1){
							getSelectedTeamEmployee(result.branch,result.division,result.department,result.team);
						}

						if(entitiesCount > 1){
							$('#userEntities')[0].sumo.unSelectAll();
							$.each(result.entity, function(v){
								$('#userEntities')[0].sumo.selectItem(v);
							})
						}
						
						if(parameters[1]['apply_param'] == 1 && branchesCount > 1){
							$('#userBranches')[0].sumo.unSelectAll();
							$.each(result.branch, function(i,v){
								$('#userBranches')[0].sumo.selectItem(v);
							})
						}
						if(parameters[2]['apply_param'] == 1 && divisionsCount > 1){
							$('#userDivisions')[0].sumo.unSelectAll();
							$.each(result.division, function(i,v){
								$('#userDivisions')[0].sumo.selectItem(v);
							})
						}
						if(parameters[3]['apply_param'] == 1 && departmentsCount > 1){
							$('#userDepartments')[0].sumo.unSelectAll();
							$.each(result.department, function(v){
								$('#userDepartments')[0].sumo.selectItem(v);
							})
						}
						if(parameters[4]['apply_param'] == 1 && teamsCount > 1){
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

		$('#userPosition').SumoSelect({
			placeholder: '<?=$lng['Select'].' '.$lng['Position']?>',
			captionFormat: '<?=$lng['Positions']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All'].' '.$lng['Positions']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});
		
		
		if(entitiesCount > 1){
			$('#userEntities')[0].sumo.unSelectAll();
		}
		if(parameters[1]['apply_param'] == 1 && branchesCount > 1){
			$('#userBranches')[0].sumo.unSelectAll();
		}
		if(parameters[2]['apply_param'] == 1 && divisionsCount > 1){
			$('#userDivisions')[0].sumo.unSelectAll();
		}
		if(parameters[3]['apply_param'] == 1 && departmentsCount > 1){
			$('#userDepartments')[0].sumo.unSelectAll();
		}
		if(parameters[4]['apply_param'] == 1 && teamsCount > 1){
			$('#userTeams')[0].sumo.unSelectAll();
		}
		
		$("#userEntities ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccessEPG('entities', $('#userEntities').val(),1);
		});
		$("#userBranches ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccessEPG('branches', $('#userBranches').val(),1);
		});
		$("#userDivisions ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccessEPG('divisions', $('#userDivisions').val(),1);
		});
		$("#userDepartments ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccessEPG('departments', $('#userDepartments').val(),1);
		});
		$("#userTeams ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccessEPG('teams', $('#userTeams').val(),1);
		});

		if(positionsCount > 1){
			var implodeArrsPos = '<?=$implodeArrsPos?>'; //alert(implodeArrsPos);
			if(implodeArrsPos !=''){
				var numbersArray = implodeArrsPos.split(',');
				$('#userPosition')[0].sumo.unSelectAll();
				$.each(numbersArray, function(k,v){ 
					$('#userPosition')[0].sumo.selectItem(v);
				})
			}

			//employee according to position selection...
			$("#userPosition ~ .optWrapper .MultiControls .btnOk").click( function () {
				//updatePotions($('#userPosition').val(), $('#userTeams').val(), $('#userDepartments').val(), $('#userDivisions').val(), $('#userBranches').val() );
			});
		}


		

		//onload...
		if(parameters[4]['apply_param'] == 1){
			var numbersString = '<?=$implodeArrs?>';
			var numbersArray = numbersString.split(',');
			updateAccessEPG('teams', numbersArray,0);
		}else{

			//onload...
			if(parameters[3]['apply_param'] == 1){
				var numbersString = '<?=$implodeArrsdep?>';
				var numbersArray = numbersString.split(',');
				updateAccess('departments', numbersArray,0);
			}
		}

		var tempdata = "<?=$tempdata?>";
		var activeTabEntCom = localStorage.getItem('activeTabEntCom');
		if(activeTabEntCom){
			if(activeTabEntCom == '#modify_data' ){
				if(tempdata == ''){
					//getAllselectedEmp();
				}
			}
			$('.nav-link[href="' + activeTabEntCom + '"]').tab('show');
		}else{
			$('.nav-link[href="#emp_group"]').tab('show');
		}

		$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
			if($(e.target).attr('href') == '#modify_data'){
				if(tempdata == ''){
					//getAllselectedEmp();
				}
			}
			localStorage.setItem('activeTabEntCom', $(e.target).attr('href'));
		});


		//for show hide...
		$('#showHideclm').SumoSelect({
			placeholder: '<?=$lng['Show Hide Columns']?>',
			captionFormat: '<?=$lng['Show Hide Columns']?> ({0})',
			captionFormatAllSelected: '<?=$lng['Show Hide Columns']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});

		$("li#showHideClmss .SumoSelect li").bind('click.check', function(event) {
			var nr = $(this).index()+2;
			//alert(nr);
			if($(this).hasClass('selected') == true){
				datatableEmppp.column(nr).visible(true);
			}else{
				datatableEmppp.column(nr).visible(false);
			}
    	})

    	$('li#showHideClmss select#showHideclm').on('sumo:closing', function(o) {
			var columns = $(this).val();
			var att_cols = [];
			$.each(columns, function(index, item) {
				att_cols.push({id:item, db:tableCols[item][0], name:tableCols[item][1]})
			})

			$.ajax({
				url: "tabs/ajax/payroll_showhide_cols.php",
				data: {cols: att_cols},
				success: function(result){
					
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


		//============== Access rights ===============
	})

	function getSelectedTeamEmployee(locations,divisions,departments,teams){

		var empStatus = $('#empStatus').val();
		//alert(empStatus);
		$.ajax({
			type: 'POST',
			url: "tabs/ajax/add_emp_into_payroll.php",
			data: {locations: locations, divisions: divisions, departments: departments, teams: teams, empStatus:empStatus},
			success: function(result){

				if($.trim(result) != 'success'){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp; <b><?=$lng['Error']?></b>: '+result,
						duration: 3,
						callback: function(v){
							window.location.reload();
						}
					})
				}else{
					window.location.reload();
				}
			}
		})
	}
</script>