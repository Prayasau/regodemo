<?
	$getEmpName = getEmpName();
	$tempdata = '';
	$fetch_temp_data = $dbc->query("SELECT * FROM ".$cid."_temp_employee_data ");
	if($fetch_temp_data->num_rows > 0){
		$tempdata = 'flash';
		while ($row = $fetch_temp_data->fetch_assoc()) {
			$alltempdata[] = $row;
		}
	}

?>
<style type="text/css">
.SumoSelect {
    padding: 4px !important; 
    border: none;
    width: 100% !important;
}

.smallNav {
	background: #ffc;
	height:31px; 
	padding:0; 
	border-bottom:1px solid #ddd;
	font-weight:600;
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


</style>
<!-- <link href="../assets/css/smart_wizard_theme_arrows.css" rel="stylesheet" type="text/css" /> -->
<!-- <link rel="stylesheet" type="text/css" href="../assets/css/erpStyle.css?<?=time()?>"> -->
<h2 style="padding-right:60px"><i class="fa fa-cog fa-mr"></i> <?=$lng['Update Emp. Register']?>
	<span style="display:none; font-style:italic; color:#b00; padding-left:30px" id="sAlert"><i class="fa fa-exclamation-triangle fa-mr"></i><?=$lng['Data is not updated to last changes made']?></span>
</h2>

<div class="main">
	<ul class="nav nav-tabs">
		<li class="nav-item"><a class="nav-link active" href="#emp_group" data-toggle="tab"><?=$lng['Emp. Groups']?></a></li>
		<li class="nav-item"><a class="nav-link" href="#modify_data" data-toggle="tab"><?=$lng['Modify Data']?></a></li>		
	</ul>

	<div class="tab-content" style="height:100%; padding:0px">
		<div class="tab-pane active" id="emp_group">

			<div style="height:100%; border:0px solid red; position:relative">
		
				<div style="position:absolute; left:0; top:0px; right:60%; bottom:0; background:#fff;">
					
					<div class="smallNav">
						<ul>
							<li><a class="font-weight-bold" style="color:#005588;"><?=$lng['Employee'].' '.$lng['Groups'];?></a></li>
							<li class="flr"><a href="#"><i class="fa fa-arrow-left"></i> &nbsp;Back</a></li>
						</ul>
					</div>
					
					<div id="leftTable" style="position:absolute; left:7px; top:35px; right:7px; bottom:15px; background:#fff; overflow-Y:auto; padding:0; overflow-X:scroll">
						
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
							
				<div style="position:absolute; left:40%; top:0px; right:0; bottom:0; background: #f6f6f6; border-left:1px solid #ddd">
					
					<div class="smallNav">
						<ul style="display: flex !important;">
							<li>
								<!-- <div class="searchFilterd ml-4" style="margin:0 0 8px 0;width: 200px;">
									<input placeholder="Search filter..." class="sFilter" id="searchFilterd" type="text" style="margin:0;border: none !important; background: #ffffcc;">
									<button id="clearSearchboxd" type="button" class="clearFilter"><i class="fa fa-times"></i></button>
								</div> -->
							</li>
							
						</ul>
					</div>

					
					
					<div id="rightTable" style="background:#fff; overflow-Y:auto; padding:10px 15px 20px 15px;">

						<table id="datatableEmppp" class="dataTable nowrap hoverable" style="width:100%;">
							<thead>
								<tr>
									<th><?=$lng['Emp. ID']?></th>
									<th><?=$lng['Employee name']?></th>
									<th><?=$lng['Email']?></th>
									
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
											
											<td>
												<a><i title="Remove" id="<?=$v['emp_id']?>" onclick="removeRowemp(this)" class="fa fa-trash fa-lg text-danger"></i></a>
											</td>
										</tr>
								<?  }  } ?>
							</tbody>
						</table>
			
					</div>
					
				</div>

			</div>

		</div> <!-------- Tab 1 end-------->

		<div class="tab-pane" id="modify_data" style="padding: 10px;">

			<div class="row">
				<div class="col-md-2">
					<div class="searchFilter" style="margin:0 0 8px 0;width: 200px;">
						<input style="margin:0" placeholder="Filter" class="sFilter" id="searchFilter" type="text">
						<button id="clearSearchbox" type="button" class="clearFilter"><i class="fa fa-times"></i></button>
					</div>
				</div>

				<div class="col-md-7"></div>
				<div class="col-md-3">
					<button class="btn btn-primary btn-fr <?=$tempdata;?>" id="saveToEmps" type="button"><?=$lng['Save to Employee Register']?></button>
					<button class="btn btn-primary btn-fr modifydata" type="button"><?=$lng['Modify Data']?></button>
				</div>
			</div>

			<table id="datatables11" class="dataTable hoverable selectable nowrap">
				<thead>
					<tr>
						<th class="par30"><?=$lng['Emp. ID']?></th>
						<th class="tal par30"><?=$lng['Employee name']?></th>
						<!-- <th class="tal"><?=$lng['Select']?></th> -->
						<th class="tal"><?=$lng['Position']?></th>
						<th class="tal"><?=$lng['Company']?></th>
						<th class="tal"><?=$lng['Locations']?></th>
						<th class="tal"><?=$lng['Divisions']?></th>
						<th class="tal"><?=$lng['Departments']?></th>
						<th class="tal"><?=$lng['Teams']?></th>
						<th class="tal"><?=$lng['Groups']?></th>
					</tr>
				</thead>
				<tbody id="seldata">

					<? if(isset($alltempdata) && is_array($alltempdata)){ 
						foreach ($alltempdata as $key => $value) { ?>
						 	
							<tr data-id="<?=$value['emp_id']?>">
								<td><?=$value['emp_id']?></td>
								<td><?=$getEmpName[$value['emp_id']];?></td>
								<td><?=$positions[$value['position']][$lang]?></td>
								<td><?=$entities[$value['company']][$lang]?></td>
								<td><?=$branches[$value['location']][$lang]?></td>
								<td><?=$divisions[$value['division']][$lang]?></td>
								<td><?=$departments[$value['department']][$lang]?></td>
								<td><?=$teams[$value['team']][$lang]?></td>
								<td><?=$groups[$value['groups']][$lang]?></td>
							</tr>

					<? } } ?>

				</tbody>
			</table>
			<div class="row">
				<div class="col-md-2" style="margin: -33px 0px 0px 180px;">
					<select id="pageLength" class="button btn-fl">
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

		</div><!-------- Tab 1 end-------->
	</div>
</div>


<!------ modify data Modal  -------->
<div class="modal fade" id="modalmodify" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<div class="tab"> 

					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Select Item']?></th>
							</tr>
						</thead>
					</table>

					<div class="sel-field">
						<label>
							<input type="checkbox" name="position" value="" class="per checkbox style-0">
							<span> <?=$lng['Position']?></span>
						</label>
					</div>

					<div class="sel-field">
						<label>
							<input type="checkbox" name="organization" value="" class="per checkbox style-0">
							<span> <?=$lng['Organization']?></span>
						</label>
					</div>

					<!-- <? if($parameters[1]['apply_param'] == 1){ ?>
						<div class="sel-field">
							<label>
								<input type="checkbox" name="field[title]" value="" class="per checkbox style-0">
								<span> <?=$parameters[1][$lang]?></span>
							</label>
						</div>

					<? } ?>

					<? if($parameters[2]['apply_param'] == 1){ ?>
						<div class="sel-field">
							<label>
								<input type="checkbox" name="field[title]" value="" class="per checkbox style-0">
								<span> <?=$parameters[2][$lang]?></span>
							</label>
						</div>

					<? } ?>

					<? if($parameters[3]['apply_param'] == 1){ ?>
						<div class="sel-field">
							<label>
								<input type="checkbox" name="field[title]" value="" class="per checkbox style-0">
								<span> <?=$parameters[3][$lang]?></span>
							</label>
						</div>

					<? } ?>

					<? if($parameters[4]['apply_param'] == 1){ ?>
						<div class="sel-field">
							<label>
								<input type="checkbox" name="field[title]" value="" class="per checkbox style-0">
								<span> <?=$parameters[4][$lang]?></span>
							</label>
						</div>

					<? } ?>-->

					<? if($parameters[5]['apply_param'] == 1){ ?>
						<div class="sel-field">
							<label>
								<input type="checkbox" name="group" value="" class="per checkbox style-0">
								<span> <?=$lng['Groups']?></span>
							</label>
						</div>
					<? } ?>

				</div>

				<div class="tab" style="display: none;">
					<form id="mkchoice">
						<input type="hidden" name="empids" id="empallids">
						<table class="basicTable inputs" id="makeSelection" border="0">
							<thead>
								<tr>
									<th colspan="2"><?=$lng['Make choice']?></th>
								</tr>
							</thead>
							<tbody>
								<tr id="positions">
									<th><?=$lng['Position']?></th>
									<td>
										<select name="positionss" style="width: 100%;">
											<option value="" selected disabled="disabled"><?=$lng['Please select']?></option>
											<? foreach($positions as $k=>$v){ ?>
												<option value="<?=$k?>"><?=$v[$lang]?></option>
											<? } ?>
										</select>
									</td>
								</tr>
								<tr id="organizations">
									<th><?=$lng['Organization']?></th>
									<td>
										<select name="organizationss" style="width: 100%;">
											<option value=""><?=$lng['Please select']?></option>
											<? foreach($organization as $k=>$v){ ?>
												<option value="<?=$k?>">
													<? 
														$branVal = $diviVal = $deptVal = $teamVal = '';
														if($parameters[1]['apply_param'] == 1){ 
															$branVal = ' → '.$branches[$v['locations']][$lang];
														}
														if($parameters[2]['apply_param'] == 1){ 
															$diviVal = ' → '.$divisions[$v['divisions']][$lang];
														}
														if($parameters[3]['apply_param'] == 1){ 
															$deptVal = ' → '.$departments[$v['departments']][$lang];
														}
														if($parameters[4]['apply_param'] == 1){ 
															$teamVal = ' → '.$teams[$v['teams']][$lang];
														}
													?>
													<?=$entities[$v['company']][$lang].$branVal.$diviVal.$deptVal.$teamVal?>
														
													</option>
											<? } ?>
										</select>
									</td>
								</tr>
								<tr id="groups">
									<th><?=$lng['Groups']?></th>
									<td>
										<select name="groupss" style="width: 100%;">
											<option value=""><?=$lng['Please select']?></option>
											<? foreach($groups as $k=>$v){ ?>
												<option value="<?=$k?>"><?=$v[$lang]?></option>
											<? } ?>
										</select>
									</td>
								</tr>
							</tbody>
						</table>
					</form>

				</div>

				
			</div>

			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" class="btn btn-primary btn-fl" id="prevBtn" onclick="nextPrev(-1)"><?=$lng['Prev']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="nextBtn" onclick="nextPrev(1)"><?=$lng['Next']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>

<script type="text/javascript">

	function checkAllcheckboxes(){
		//for position
		if($('#modalmodify input[name="position"]').prop('checked') == true){
		   	$('table#makeSelection tr#positions').css('display','table-row');
		}else{
			$('table#makeSelection tr#positions').css('display','none');
		}

		//for organizations
		if($('#modalmodify input[name="organization"]').prop('checked') == true){
		   	$('table#makeSelection tr#organizations').css('display','table-row');
		}else{
			$('table#makeSelection tr#organizations').css('display','none');
		}

		//for groups
		if($('#modalmodify input[name="group"]').prop('checked') == true){
		   	$('table#makeSelection tr#groups').css('display','table-row');
		}else{
			$('table#makeSelection tr#groups').css('display','none');
		}

		//for employee data
		var emparr1 = [];
		$('#datatableEmppp tbody#relatedata tr').each(function(k,v){
			emparr1.push($(this).data('id'));
		})

		$('#modalmodify form input#empallids').val('');
		var selEmps = emparr1.toString();
		$('#modalmodify form input#empallids').val(selEmps);
	}

	function removeRowemp(that){
		$('#datatableEmppp tr#'+that.id).remove();	
	}


	var currentTab = 0; 
	showTab(currentTab);

	function showTab(n) {
	  // This function will display the specified tab of the form...
	  var x = document.getElementsByClassName("tab"); 
	  x[n].style.display = "block";
	  //... and fix the Previous/Next buttons:
	  if (n == 0) {
	    document.getElementById("prevBtn").style.display = "none";
	  } else {
	    document.getElementById("prevBtn").style.display = "inline";
	    //$('#SaveNewUser').attr('id','nextBtn');
	  }
	  if (n == (x.length - 1)) {
	  	checkAllcheckboxes();
	    document.getElementById("nextBtn").innerHTML = "<?=$lng['Modify Data']?>";
	    
	    //$('#nextBtn').attr('id','SaveNewUser');
	  } else {
	    document.getElementById("nextBtn").innerHTML = "Next";
	    
	    //$('#nextBtn').attr('id','nextBtn'); 
	  }
	  //... and run a function that will display the correct step indicator:
	  //fixStepIndicator(n)
	}

	function nextPrev(n) {
	  // This function will figure out which tab to display
	  var x = document.getElementsByClassName("tab");
	  // Exit the function if any field in the current tab is invalid:
	  //if (n == 1 && !validateForm()) return false;
	  // Hide the current tab:
	  x[currentTab].style.display = "none";
	  // Increase or decrease the current tab by 1:
	  currentTab = currentTab + n;
	  // if you have reached the end of the form...
	  if (currentTab >= x.length) {
	    // ... the form gets submitted:
	    //document.getElementById("regForm").submit();
	    SaveNewEmployeesdata();
	    return false;
	  }
	  // Otherwise, display the correct tab:
	  showTab(currentTab);
	}


	function SaveNewEmployeesdata(){

		var frm = $('#mkchoice');
		var data = frm.serialize();

		var err = true;
		if($('#empallids').val()==''){err = false};
		if(err==false){
			$("body").overhang({
				type: "error",
				message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;There is no employee selected',
				duration: 2,
				callback: function(v){
					window.location.reload();
				}
			})

		}else{

			$.ajax({
				url: "company/ajax/temp_employee_data.php",
				type: 'POST',
				data: data,
				success: function(result){
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
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: '+result,
							duration: 4,
						})
					}
				}
			})

			$('#saveToEmps').addClass('flash');
			//$("#sAlert").fadeIn(200);
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

		$("#searchFilterd").keyup(function() {
			datatableEmppp.search(this.value).draw();
		});
		$("#clearSearchboxd").click(function() {
			$("#searchFilterd").val('');
			datatableEmppp.search('').draw();
		});


		var dtable = $('#datatables11').DataTable({

			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: 10,
			filter: true,
			info: true,
			<?=$dtable_lang?>

		});

		$("#searchFilter").keyup(function() {
			dtable.search(this.value).draw();
		});
		$("#clearSearchbox").click(function() {
			$("#searchFilter").val('');
			dtable.search('').draw();
		});


		$(document).on("click", ".modifydata", function(e){
			e.preventDefault();
			$('#modalmodify').modal('toggle');
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


		/*var numbersString = '<?=$attach['sent_to']?>';
		var numbersArray = numbersString.split(',');
		updateAccess('teams', numbersArray,0);*/

		var tempdata = "<?=$tempdata?>";
		var activeTabEntCom = localStorage.getItem('activeTabEntCom');
		if(activeTabEntCom){
			if(activeTabEntCom == '#modify_data' ){
				if(tempdata == ''){
					getAllselectedEmp();
				}
			}
			$('.nav-link[href="' + activeTabEntCom + '"]').tab('show');
		}else{
			$('.nav-link[href="#emp_group"]').tab('show');
		}

		$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
			if($(e.target).attr('href') == '#modify_data'){
				if(tempdata == ''){
					getAllselectedEmp();
				}
			}
			localStorage.setItem('activeTabEntCom', $(e.target).attr('href'));
		});


		//============== Access rights ===============
	})

	function getSelectedTeamEmployee(locations,divisions,departments,teams){

		$('#datatableEmppp').DataTable().destroy();

		$.ajax({
			type: 'POST',
			url: ROOT+"settings/ajax/up_emp_select.php",
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


	function getAllselectedEmp(){

		var emparr = [];
		$('#datatableEmppp tbody#relatedata tr').each(function(k,v){
			emparr.push($(this).data('id'));
		})

		//================ for modify data popup ==========//
		$('#modalmodify form input#empallids').val('');
		var selEmps = emparr.toString();
		$('#modalmodify form input#empallids').val(selEmps);
		//================ for modify data popup ==========//

		if(emparr.length === 0) {
			$("body").overhang({
				type: "error",
				message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;There is no employee selected',
				duration: 3,
			})
		}else{

			$.ajax({
				type: 'POST',
				url: "company/ajax/up_empinfo.php",
				data: {emparr:emparr},
				success: function(result){

					$('#datatables11').DataTable().destroy();

					$('#datatables11 tbody#seldata tr').remove();
					$('#datatables11 tbody#seldata').append(result);

					var dtable = $('#datatables11').DataTable({

						lengthChange: false,
						searching: true,
						ordering: false,
						pagingType: 'full_numbers',
						pageLength: 10,
						filter: true,
						info: true,
						<?=$dtable_lang?>

					});
				}
			})
		}
	}


	
</script>