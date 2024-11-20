<?

if(count($entities) > 1){ $colmd1 = 1; }else { $colmd1 = 0;}
if($parameters[1]['apply_param'] == 1 && count($branches) > 1){ $colmd2 = 1; }else { $colmd2 = 0;}
if($parameters[2]['apply_param'] == 1 && count($divisions) > 1){ $colmd3 = 1; }else { $colmd3 = 0;}
if($parameters[3]['apply_param'] == 1 && count($departments) > 1){ $colmd4 = 1; }else { $colmd4 = 0;}
if($parameters[4]['apply_param'] == 1 && count($teams) > 1){ $colmd5 = 1; }else { $colmd5 = 0;}
if(count($positions) > 1){ $colmd6 = 1; }else { $colmd6 = 0;}

$totalAllCols = $colmd1 + $colmd2 + $colmd3 + $colmd4 + $colmd5 + $colmd6;
if($totalAllCols == 0){ $left_class = 'col-md-0';$right_class = 'col-md-12';}
elseif($totalAllCols == 1){ $left_class = 'col-md-2';$right_class = 'col-md-10';}
elseif($totalAllCols == 2){ $left_class = 'col-md-3';$right_class = 'col-md-9';}
elseif($totalAllCols == 3){ $left_class = 'col-md-4';$right_class = 'col-md-8';}
elseif($totalAllCols == 4){ $left_class = 'col-md-6';$right_class = 'col-md-6 table-responsive';}
elseif($totalAllCols == 5){ $left_class = 'col-md-6';$right_class = 'col-md-6 table-responsive';}
elseif($totalAllCols == 6){ $left_class = 'col-md-6';$right_class = 'col-md-6 table-responsive';}

?>
<style type="text/css">
	.SumoSelect {
	    padding: 5px 5px 5px 10px !important;
	    border: 1px #ddd solid !important;
	    width: auto !important;
	    display: block !important;
	}

	.SumoSelect > .optWrapper > .options li.opt {
	    width: 100% !important;
	}
</style>
<div class="row">

	<div class="<?=$left_class?> table-responsive" style="padding-right: 3px;">
		<table id="usersAccess" class="basicTable">
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
							<? /*foreach($entities as $k=>$v){ ?>
								<option value="<?=$k?>"><?=$v[$lang]?></option>
							<? }*/ ?>
							
							<? foreach($entities as $k=>$v){if(in_array($k, explode(',', $_SESSION['rego']['mn_entities']))){ ?>
							<option <? if(in_array($k, explode(',', $_SESSION['rego']['sel_entities']))){echo 'selected';} ?> value="<?=$k?>"><?=$v[$lang]?></option>
							<? } } ?>
							</select>
							
						</td>
					<? } ?>
					<? if($parameters[1]['apply_param'] == 1 && count($branches) > 1){ ?>
						<td style="padding:0">
							<select name="branches" multiple="multiple" id="userBranches">
							<? /*foreach($branches as $k=>$v){ ?>
								<option value="<?=$k?>"><?=$v[$lang]?></option>
							<? }*/ ?>
							<? foreach($branches as $k=>$v){if(in_array($k, explode(',', $_SESSION['rego']['mn_branches']))){ ?>
							<option <? if(in_array($k, explode(',', $_SESSION['rego']['sel_branches']))){echo 'selected';} ?> value="<?=$k?>"><?=$v[$lang]?></option>
							<? }} ?>
							</select>	
							
						</td>
					<? } ?>
					<? if($parameters[2]['apply_param'] == 1 && count($divisions) > 1){ ?>
						<td style="padding:0">
							<select name="divisions" multiple="multiple" id="userDivisions">
							<? /*foreach($divisions as $k=>$v){ ?>
								<option value="<?=$k?>"><?=$v[$lang]?></option>
							<? }*/ ?>
							<? foreach($divisions as $k=>$v){if(in_array($k, explode(',', $_SESSION['rego']['mn_divisions']))){ ?>
							<option <? if(in_array($k, explode(',', $_SESSION['rego']['sel_divisions']))){echo 'selected';} ?> value="<?=$k?>"><?=$v[$lang]?></option>
							<? }} ?>
							</select>	
							
						</td>
					<? } ?>
					<? if($parameters[3]['apply_param'] == 1 && count($departments) > 1){ ?>
						<td style="padding:0">
							<select name="departments" multiple="multiple" id="userDepartments">
							<? /*foreach($departments as $k=>$v){ ?>
								<option value="<?=$k?>"><?=$v[$lang]?></option>
							<? }*/ ?>
							<? foreach($departments as $k=>$v){if(in_array($k, explode(',',$_SESSION['rego']['mn_departments']))){ ?>
							<option <? if(in_array($k, explode(',',$_SESSION['rego']['sel_departments']))){echo 'selected';} ?> value="<?=$k?>"><?=$v[$lang]?></option>
							<? }} ?>
							</select>	
							
						</td>
					<? } ?>
					<? if($parameters[4]['apply_param'] == 1 && count($teams) > 1){ ?>
						<td style="padding:0">
							<select name="teams" multiple="multiple" id="userTeams">
							<? /*foreach($teams as $k=>$v){ ?>
								<option value="<?=$k?>"><?=$v['code']?></option>
							<? } */?>
							<? foreach($teams as $k=>$v){if(in_array($k, explode(',',$_SESSION['rego']['sel_teams']))){ ?>
							<option <? if(in_array($k, explode(',',$_SESSION['rego']['sel_teams']))){echo 'selected';} ?> value="<?=$k?>"><?=$v[$lang]?></option>
							<? }} ?>
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
	
	<div class="<?=$right_class?>" style="border-left: 1px solid #ddd;padding-left: 3px;">
		<div class="smallNav">
			<ul style="display: flex !important;">
				<li >
					<div class="searchFilterd" style="margin:0 0 8px 0;margin-left: 0px!important;">
						<input placeholder="Search filter..." class="sFilter" id="searchFilterd" type="text" style="margin:0;background: #ffffff;width: 134px" autocomplete="off">

					</div>
				</li>
				<li>
					<button style="border: 0;padding: 3px 11px !important;line-height: 26px !important;margin: 0;color: #ccc;border-radius: 0 !important;background: #eee;" id="clearSearchbox" type="button" class="clearFilter"><i class="fa fa-times"></i></button>

				</li>
				<li style="padding-right: 5px!important;padding-left: 5px!important;">
					<select class="select2 customSelectcss button" onchange="Addemployeeintemp(this)" name="emp_name" style="background: #ffffff;font-weight: 600;">
						<option selected disabled value=""><?=$lng['Add employee']?></option>
						<option value="all"><?=$lng['Add all employees']?></option>
						<? if(!empty($getEmpName)){ foreach($getEmpName as $k=>$v){
								if(!in_array($k, $empexistlist)){
									echo '<option value="'.$k.'" />'.$k.' - '.$v.'</option>';
							} } } ?>
					</select>
				</li>
				<li id="showHideClmss" style="padding-right: 5px!important;">
					<select class="ml-1 button" multiple="multiple" id="showHideclm" style="background: #ffffff;font-weight: 600;padding: 1px !important;">
						<?	foreach($eatt_cols as $k=>$v){
								echo '<option class="optCol" value="'.$k.'" ';
								if(in_array($k, $shCols)){echo 'selected ';}
								echo '>'.$v[1].'</option>';
						} ?>
					</select>
				</li>
				<li style="padding-right: 5px!important;">
					<select class="select2 button customSelectcss" id="empStatus" style="background: #ffffff;font-weight: 600;">
						<option selected value=""><?=$lng['All employees']?></option>
						<? foreach($emp_status as $k=>$v){
								echo '<option';
								if($k == 1){echo ' selected';}
								echo ' value="'.$k.'">'.$v.'</option>';
							} ?>
					</select>
				</li>						
			</ul>
		</div>
		

		<table id="datatableEmppp" class="dataTable nowrap hoverable" style="width:100%;">
			<thead>
				<tr>
					<th class="fixwidth"><?=$lng['Emp. ID']?></th>
					<th class="fixwidth"><?=$lng['Employee name']?></th>
					
					<? if($parameters[4]['apply_param'] == 1){ ?>
						<!-- <th><?=$parameters[4][$lang]?></th> -->
					<? } ?>
				
					<th class="tal fixwidth"><?=$lng['Position']?></th>
					<th class="tal fixwidth"><?=$lng['Company']?></th>
					<th class="tal fixwidth"><?=$lng['Location']?></th>
					<th class="tal fixwidth"><?=$lng['Division']?></th>
					<th class="tal fixwidth"><?=$lng['Department']?></th>
					<th class="tal fixwidth"><?=$lng['Teams']?></th>
					
					<th class="fixwidth">
						<i data-toggle="tooltip" title="Remove" class="fa fa-trash fa-lg"></i>
					</th>
				</tr>
			</thead>
			<tbody id="relatedata">
					<? if(isset($alltempdata) && is_array($alltempdata)){ 
						foreach ($alltempdata as $key => $value) { ?>
						 	
							<tr data-id="<?=$value['emp_id']?>" id="<?=$value['emp_id']?>">
								<td class="fixwidth"><?=$value['emp_id']?></td>
								<td class="fixwidth"><?=$getEmpName[$value['emp_id']];?></td>
								<td class="fixwidth"><?=$positions[$value['position']][$lang]?></td>
								<td class="fixwidth"><?=$entities[$value['company']][$lang]?></td>
								<td class="fixwidth"><?=$branches[$value['location']][$lang]?></td>
								<td class="fixwidth"><?=$divisions[$value['division']][$lang]?></td>
								<td class="fixwidth"><?=$departments[$value['department']][$lang]?></td>
								<td class="fixwidth"><?=$teams[$value['team']][$lang]?></td>
								<td class="fixwidth">
									<a id="<?=$value['emp_id']?>" onclick="removeRowempss(this)"><i title="Remove" class="fa fa-trash fa-lg text-danger"></i></a>
								</td>
							</tr>

					<? } } ?>
			</tbody>
		</table>
		<div class="row">
			<div class="col-md-2" style="margin: -30px 0px 0px 0px;margin-left: auto;margin-right: auto;">
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

<script type="text/javascript">
	$(document).ready(function(){

		var eCols = <?=json_encode($emptyCols)?>;
		var tableCols = <?=json_encode($eatt_cols)?>;
		var parameters = <?=json_encode($parameters)?>;
		var entitiesCount = <?=count($entities)?>;
		var branchesCount = <?=count($branches)?>;
		var divisionsCount = <?=count($divisions)?>;
		var departmentsCount = <?=count($departments)?>;
		var teamsCount = <?=count($teams)?>;
		var positionsCount = <?=count($positions)?>;


		//============== Access rights ===============
		function updateAccess(access, values, show){
			//alert(values);

			if(values !=''){

				$.ajax({
					url: ROOT+"settings/ajax/update_user_access.php",
					data: {access: access, values: values},
					dataType: 'json',
					success: function(result){

						if(show == 1){
							//getSelectedTeamEmployee(result.branch,result.division,result.department,result.team);
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
				//{"targets": eCols, "visible": false, "searchable": false},
				{ "width": "50px", "targets": 0 },
				{ "width": "138px", "targets": 1 },
				{ "width": "50px", "targets": 2 },
				{ "width": "50px", "targets": 3 },
				{ "width": "50px", "targets": 4 },
				{ "width": "50px", "targets": 5 },
				{ "width": "50px", "targets": 6 },
				{ "width": "50px", "targets": 7 },
				{ "width": "50px", "targets": 8 },

			]

		});

		$("#searchFilterd").keyup(function() {
			datatableEmppp.search(this.value).draw();

		});			

		$("#clearSearchboxd").click(function() {
			$("#searchFilterd").val('');
			datatableEmppp.search('').draw();
		});

		$(document).on("change", "#pageLengthd", function(e) {
			if(this.value > 0){
				datatableEmppp.page.len( this.value ).draw();
			}
		})

		$('#showHideclm').SumoSelect({
			placeholder: 'Show / Hide Columns',
			captionFormat: 'Show / Hide Columns ({0})',
			captionFormatAllSelected: 'Show / Hide Columns ({0})',
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
				url: ROOT+"employees/ajax/update_show_hide_clm.php",
				data: {cols: att_cols},
				success: function(result){
					
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;Sorry but something went wrong. <b>Error</b> : '+thrownError,
						duration: 4,
					})
				}
			});
		});	

	});
</script>