<?
	$employees = getJsonUserEmployees($cid, $lang);
	$compusers = getJsonComusersss($cid,'comp');
	$emps = getEmployees($cid, 0);
	$compEmail = checkCompanySUbEmail($cid);
	$password = generateStrongPassword(8, false);//randomPassword();

	if(isset($_GET['userid'])){
		$condition1 = "AND id = '".$_GET['userid']."'";
	}else{
		$condition1 = "";
	}

	$users = array();
	$sql = "SELECT * FROM ".$cid."_users WHERE type NOT IN ('emp','sys','app') ".$condition1." ";
	if($res = $dbc->query($sql)){
		while($row = $res->fetch_assoc()){ 
			$users[] = $row;
			$users11[$row['id']] = $row['username'];
			$copy_from[] = array('data'=>$row['id'], 'value'=>$row['name']);
		}
	}else{
		echo mysqli_error($dbc);
	}
	if(!$users){$users = array();}
	if(!$copy_from){$copy_from = array();}
	//var_dump($users); exit;

	if(isset($_GET['userid'])){
		$userFiltval = $users11[$_GET['userid']];
	}else{ $userFiltval = '';}
	


	

	// echo '<pre>';
	// print_r($teamsAct);
	// echo '</pre>';

	// die();
?>


<style>
	.disabled {
		cursor:not-allowed;
	}
	.disabled i {
		color:#bbb;
	}
	table.basicTable.tac th {
		text-align:center;
		min-width:75px;
	}
	table.basicTable.tac td {
		text-align:center;
	}
	.SumoSelect{
		width: 99% !important;
		/*min-width: 200px !important;*/
		padding: 4px 0 0 10px !important;
		border:0 !important;
	}
	.SumoSelect > .CaptionCont {
		background:transparent !important;
		font-weight:600;
	}

	#AccessRightsForm .optWrapper.okCancelInMulti.selall.multiple {
	    min-width: 150px;
	}


	.SumoSelect p.btnOk, p.btnOk:hover {
	    background: green;
	    color: #fff;
	    border: 1px solid green;
	}

	.SumoSelect > .optWrapper.multiple > .MultiControls > p.btnOk:hover {
	    background: green !important;
	    color: #fff !important;
	    border: 1px solid green !important;
	}

	.SumoSelect p.btnCancel, p.btnCancel:hover {
	    background: red;
	    color: #fff;
	    border: 1px solid red;
	}

	.SumoSelect > .optWrapper.multiple > .MultiControls > p.btnCancel:hover {
	    background: red !important;
	    color: #fff !important;
	    border: 1px solid red !important;
	}


	/* pre-next css*/

	input {
	  padding: 10px;
	  width: 100%;
	  border: 1px solid #aaaaaa;
	}

	/* Hide all steps by default: */
	.tab {
	  display: none;
	}

	/* pre-next css*/

	
</style>

	<link rel="stylesheet" href="../assets/css/croppie_users.css?<?=time()?>" />

	<h2><i class="fa fa-user"></i>&nbsp; <?=$lng['Company users']?></h2>
	
	<div class="main">
		<div style="padding:0 0 0 20px" id="dump"></div>

		<div class="row mb-2">
			<div class="col-md-2">
				<label style="font-weight: 600;">Search Users:</label>
				<input type="text" name="nameFilter" value="<?=$userFiltval?>" id="UserNameFilter" placeholder="Enter username here...">

			</div>
			
			<div class="col-md-8" style="visibility: hidden;"></div>
			<div class="col-md-2">
				<button type="button" class="btn btn-primary btn-fr mt-2" id="add_Newuser"><i class="fa fa-plus"></i>&nbsp; <?=$lng['Add new user']?></button>
			</div>
			
		</div>
			 
		<table border="0" class="basicTable pad010">
			<thead>
				<tr>
					<th class="tac" style="width:1px; padding:0 5px"><i class="fa fa-image fa-lg"></i></th>
					<th><?=$lng['Type']?></th> 
					<th><?=$lng['Name']?></th> 
					<th><?=$lng['Username']?></th> 
					<th><?=$lng['Phone']?></th> 
					<th><?=$lng['System users']?></th>
					<th><?=$lng['Company users']?></th>
					<!-- <th><?=$lng['Access Rights']?></th> -->
					<th><?=$lng['Access start']?></th>
					<th><?=$lng['Access end']?></th>
					<th><?=$lng['Status']?></th>
					<th><i class="fa fa-trash fa-lg"></i></th>
				</tr>
			</thead>
			<tbody>
			<? if($users){ 
				foreach($users as $k=>$v){ $pid = $cid.'_'.$v['username'];?>
				<tr>
					<td class="tac" style="padding:0 !important;">
						<center><img style="height:28px; width:28px; margin:2px; cursor:default" class="img-tooltip" data-id="<?=$v['id']?>" title="<img src=../<?=$v['img'].'?'.time()?> />" data-toggle="tooltip" data-placement="right" src="../<?=$v['img'].'?'.time()?>" /></center>
					</td>
					
					<td><?=$v['type']?></td>
					<td><?=$v['name']?></td>
					<td><?=$v['username']?></td>
					<td><?=$v['phone']?></td>
					
					<? if($_SESSION['rego']['standard'][$standard]['set_permissions']){ ?>
						<?if(strpos($AllUsers[$v['username']][0]->sys_access, $cid) !== false && $AllUsers[$v['username']][0]->sys_status == 1){ ?>
							<td class="tac"><a title="<?=$lng['Set permissions']?>" class="" data-id="<?=$v['id']?>"><i class="fa fa-check fa-lg"></i></a></td>
						<?}else{ ?>
							<td class="tac"></td>
						<?}?>
						
						<td class="tac"><a title="<?=$lng['Company users']?>" class="CompanyUsers" data-id="<?=$v['id']?>" data-name="<?=$v['name']?>" data-img="../<?=$v['img'].'?'.time()?>"><i class="fa fa-cog fa-lg"></i></a></td>
					
						<!-- <td class="tac"><a title="<?=$lng['Access Rights']?>" class="AccessRights" data-id="<?=$v['id']?>"><i class="fa fa-cog fa-lg"></i></a></td> -->
					<? } ?>
					
					<td><?=$v['access_start']?></td>
					<td><?=$v['access_end']?></td>
					<td><?=$def_status[$v['status']]?></td>
					
					<td>
						<? if($compEmail[$v['username']] == $v['username']){ }else{ ?>
							<a class="delUser" data-emp="<?=$v['emp_id']?>" data-id="<?=$v['id']?>" data-type="<?=$v['type']?>" data-ref="<?=$v['ref']?>"><i class="fa fa-trash fa-lg"></i></a>
						<? } ?>
					</td>
					
				</tr>
			<? } }else{ ?>
				<tr>
					<td colspan="13" style="font-size:14px;color:#000;text-align:center;padding:6px 10px !important; background:#ff6; font-weight:600">
						<?=$lng['No data available in Database']?>
					</td>
				</tr>
			<? } ?>  
			</tbody>
		</table>
    
    	<div style="height:50px"></div> 
	</div>

	<!------ Company Users Modal  -------->
	<div class="modal fade" id="modalCompanyUsers" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg" role="document" style="min-width: 1000px;">
			<div class="modal-content">
			<form id="UserActivity">
				<input type="hidden" name="userID" id="userIDs" value="">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Company users']?> <?=strtolower($lng['Activity'])?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>     
				<div class="modal-body">
					<table class="basicTable" style="margin-top:0px; width:100%; table-layout:auto">
						<thead>
							<tr>
								<th class="tal" colspan="11" style="padding:4px; vertical-align: bottom !important; font-size:18px">
									<table border="0" style="width:100%;">
										<tr>
											<td style="padding:1px 0 0 1px">
												<img id="permImg" style="height:60px; display:block;" src="../images/profile_image.jpg" />
											</td>
											<td style="vertical-align:bottom; padding-bottom:5px;">
												<span style="color:#a00" id="sysUser"></span>
											</td>
											<td style="vertical-align:bottom">
												<?=$lng['Copy activity from']?> : <input style="background:transparent; width:250px; border-bottom:1px solid #ccc; font-size:16px; padding:0; margin-left:5px" placeholder="<?=$lng['Type for hints']?> ..." id="copy_from" type="text" />
											</td>
											<td style="width:90%; padding:0 5px 7px 20px; vertical-align:bottom;">
												<span id="accessMsg"></span>
											</td>
											<td style="padding-bottom:8px; vertical-align:bottom">
												<button class="btn btn-primary btn-fr mt-3 mr-2" type="button" onclick="SaveUserActicity();"><i class="fa fa-save"></i>&nbsp; <?=$lng['Update activity']?></button>
											</td>
										</tr>
									</table>
								</th> 
							</tr>
						</thead>
					</table>
					<div class="row m-2">
						<table id="Activitytablesss" class="basicTable" style="width:100%; table-layout:auto">
							<thead>
								<tr style="line-height:100%; background:#09c; border-bottom:1px solid #09c">
									<th style="color:#fff" class="tal"><?=$lng['Module']?></th>
									<th style="color:#fff;width: 40%;" class="tal"><?=$lng['Activities']?></th>
									<th style="color:#fff;width: 30%;" class="tal"><?=$lng['Approval Level']?></th>
									<th style="color:#fff;width: 20%;" colspan="15"><?=$lng['Assigned groups']?></th>
								</tr>
							</thead>

							<tbody id="appendActivity">
								
							</tbody>
						</table>
					</div>

					<div class="clear"></div>
					<button class="btn btn-primary btn-fr mt-3 mr-3" type="button" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp; <?=$lng['Cancel']?></button>
					
					<div class="clear"></div>
				</div>
			</form>
			</div>
		</div>
	</div>
	<!------ Company Users Modal  -------->

	<!------ Prev-Next Modal -------->
	<div class="modal fade" id="modalPrevnext" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog" role="document" style="min-width: 1000px;">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fa fa-user"></i>&nbsp; <?=$lng['Add new user']?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<form id="regForm">
					    <!------ 1st tab user info start ---->
					    <div class="tab">  
						  	<input type="hidden" name="name" id="name" />
							<input type="hidden" name="emp_id" id="emp_id" />
							<input type="hidden" name="img" id="img" value="images/profile_image.jpg" />
							<input type="hidden" name="img_data" id="img_data" value="" />
							<table border="0" style="width:100%">
	            				<tr>
	              					<td class="vat" style="padding:0 15px 0 0; border-right:1px #eee solid; width:80%">
										<table class="basicTable inputs" border="0">
											<tbody>
											<tr>
												<th><i class="man"></i><?=$lng['Name']?></th>
												<td><input placeholder="<?=$lng['Type for hints']?> ..." id="system_user_name" type="text" /></td>
											</tr>
											<tr>
												<th><i class="man"></i><?=$lng['email']?></th>
												<!-- <td><input onKeyUp="$('#username').val(this.value);" onChange="$('#username').val(this.value);" id="email" type="text" value="" /></td> -->
												<td><input onKeyUp="$('#username').val(this.value);" onChange="checkEmail(this.value);" id="email" type="text" value="" /></td>
											</tr>
											<tr>
												<th><i class="man"></i><?=$lng['Username']?></th>
												<td><input readonly class="nofocus" name="username" id="username" type="text" value="" /></td>
											</tr>
											<tr>
												<th><i class="man"></i><?=$lng['Password']?></th>
												<td><input autocomplete="off" name="password" id="password" type="text" value="<?=$password?>" />
													<input type="hidden" id="hiddpassword" value="">
												</td>
											</tr>
											<tr>
												<th><?=$lng['Phone']?></th>
												<td><input name="personal_phone" type="text" value="" /></td>
											</tr>
											<tr>
												<th><i class="man"></i><?=$lng['Type']?></th>
												<td>
													<select name="type" id="type" style="width:100%">
														<option value="comp"><?=$user_type['comp']?></option>
													</select>
												</td>
											</tr>
											<tr>
												<th><i class="man"></i><?=$lng['Status']?></th>
												<td colspan="2">
													<select name="status" id="status" style="width:100%">
														<? foreach($def_status as $k=>$v){ ?>
															<option value="<?=$k?>"><?=$v?></option>
														<? } ?>
													</select>
												</td>
											</tr>
											</tbody>
										</table>
									</td>
	                				<td class="vat" style="width:1%; padding:5px 0 0 15px;">
										<div id="upload-demo" style="margin:0 0 5px;"></div>
										<input style="height:0; visibility:hidden" id="selectUserImg" type="file" name="user_img" />
										<? //if($admin){ ?>
										<button onclick="$('#selectUserImg').click();" type="button" id="userBut" style="width:100%; margin:0" class="btn btn-primary btn-xs"><i class="fa fa-user"></i>&nbsp;&nbsp;<?=$lng['Select picture']?></button>
										<? //} ?>
									</td>
	         					</tr>
							</table>
						</div>
						<!------ 1st tab user info end ---->

						<!------ 2nd tab user access rights start ---->
					  	<div class="tab">
					  		<fieldset>
							<h2><i class="fa fa-cog"></i>  <?=$lng['Access Rights']?></h2>
							<table id="usersAccess" class="basicTable" style="margin-top:5px; width:100%; table-layout:auto">
								<thead>
									<tr style="line-height:100%; background:#09c; color:#fff;">
										<!-- <th style="color:#fff;"><?=$lng['Employee group']?></th> 
										<th style="color:#fff"><?=$lng['Entities']?></th>
										<th style="color:#fff"><?=$lng['Branches']?></th>
										<th style="color:#fff"><?=$lng['Divisions']?></th>
										<th style="color:#fff"><?=$lng['Departments']?></th>
										<th style="color:#fff"><?=$lng['Teams']?></th>
										<th style="width:60%"></th> -->

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
												</select>
												
											</td>
										<? } ?>
										
										<? if($parameters[1]['apply_param'] == 1 && count($branches) > 1){ ?>
											<td style="padding:0">
												<select name="branches" multiple="multiple" id="userBranches">
												<? unset($branches[1]);
												foreach($branches as $k=>$v){ ?>
													<option value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
												</select>	
												
											</td>
										<? } ?>

										<? if($parameters[2]['apply_param'] == 1 && count($divisions) > 1){ ?>
											<td style="padding:0">
												<select name="divisions" multiple="multiple" id="userDivisions">
												<? unset($divisions[1]);
												foreach($divisions as $k=>$v){ ?>
													<option value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
												</select>	
												
											</td>
										<? } ?>

										<? if($parameters[3]['apply_param'] == 1 && count($departments) > 1){ ?>
											<td style="padding:0">
												<select name="departments" multiple="multiple" id="userDepartments">
												<? unset($departments[1]);
												foreach($departments as $k=>$v){ ?>
													<option value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
												</select>	
												
											</td>
										<? } ?>

										<? if($parameters[4]['apply_param'] == 1 && count($teams) > 1){ ?>
											<td style="padding:0">
												<select name="teams" multiple="multiple" id="userTeams">
												<? unset($teams[1]);
												foreach($teams as $k=>$v){ ?>
													<option value="<?=$k?>"><?=$v['code'].' - '.$v[$lang]?></option>
												<? } ?>
												</select>		
											</td>
										<? } ?>
										
									</tr>
								</tbody>
								<tbody id="accessBody">

								</tbody>
							</table>
							</fieldset>
					    </div>
					    <!------ 2nd tab user access rights end ---->

					    <!------ 3rd tab user info end ------>
					    <div class="tab">
					  		<fieldset>
							<!-- <h2><i class="fa fa-cog"></i>  <?=$lng['Activity']?></h2> -->
								<table class="basicTable" style="margin-top:0px; width:100%; table-layout:auto">
									<thead>
										<tr>
											<th class="tal" colspan="11" style="padding:4px; vertical-align: bottom !important; font-size:18px">
												<table border="0" style="width:100%;">
													<tr>
														<td style="padding:1px 0 0 1px">
															<img id="permImg" style="height:60px; display:block;" src="../images/profile_image.jpg" />
														</td>
														<td style="vertical-align:bottom; padding-bottom:5px;">
															<span style="color:#a00" id="sysUser"></span>
														</td>
														<td style="vertical-align:bottom">
															<?=$lng['Copy activity from']?> : <input style="background:transparent; width:250px; border-bottom:1px solid #ccc; font-size:16px; padding:0; margin-left:5px" placeholder="<?=$lng['Type for hints']?> ..." id="copy_from" type="text" />
														</td>
														<td style="width:90%; padding:0 5px 7px 20px; vertical-align:bottom;">
															<span id="accessMsg"></span>
														</td>
														<td style="padding-bottom:8px; vertical-align:bottom">
															
														</td>
													</tr>
												</table>
											</th> 
										</tr>
									</thead>
								</table>

								<table id="Activitytable" class="basicTable mt-2" style="width:100%; table-layout:auto">
									<thead>
										<tr style="line-height:100%; background:#09c; border-bottom:1px solid #09c">
											<th style="color:#fff;width: 10%;" class="tal"><?=$lng['Module']?></th>
											<th style="color:#fff;width: 40%;" class="tal"><?=$lng['Activities']?></th>
											<th style="color:#fff;width: 30%;" class="tal"><?=$lng['Approval Level']?></th>
											<th style="color:#fff;width: 20%;" colspan="15"><?=$lng['Assigned groups']?></th>
										</tr>
									</thead>

									<tbody id="appendActivity">
										<? 
										$count = 0;
										
										foreach($allActivities as $key => $val){
											
											foreach($val as $val1){ 
											 	$count++; 
											 	if($count == 1){ $module = $key;}else{ $module = '';}

											 	$dataOpt[str_replace(' ', '_', $key)][] = $val1->activity_en;
										?>
										<!---this section not in use --->
											<tr id="<?=str_replace(' ', '_', $key).'_'.$count?>" style="display:none;">
												<th><?=$module?></th>
												<th class="tal">
													<input type="text" name="" value="<?=$val1->activity_en?>" readonly style="min-width: 100%;border:1px solid #fff;padding:0px;">
												</th>
												<th>
													<select name="" style="min-width:100%; background:transparent;border: 1px solid #fff;padding: 0px !important;">
														<option value=""><?=$lng['Please select']?></option>
														<? foreach($activity_level as $k=>$v){ ?>
															<option value="<?=$k?>"><?=$v?></option>
														<? } ?>
													</select>
												</th>
												<th class="tal">
													<select name="" style="min-width:100%; background:transparent;border: 1px solid #fff;padding: 0px !important;">
														<option value=""><?=$lng['Please select']?></option>
														<? foreach($teamsAct as $k=>$v){ ?>
															<option value="<?=$v['id']?>"><?=$v[$lang]?></option>
														<? } ?>
													</select>
												</th>
											</tr>
										<!---this section not in use --->

										<? } ?>

											<tr>
												<th><?=$key;?></th>
												<th colspan="3">
													<button class="btn btn-primary btn-fl btn-sm" type="button" onclick="AddmoreActivity('<?=str_replace(' ', '_', $key)?>', <?=$count?>, '002')"><?=$lng['Add activity']?></button>
												</th>
											</tr>

										<? $count = 0; } ?>
										
										</tbody>

								</table>
								
							</fieldset>
						</div>
						<!------ 3rd tab user info end ------>
					  
						<div style="overflow:auto;" class="mt-4" id="hideauto">
						    <div>
						      <button type="button" class="btn btn-primary btn-fl" id="prevBtn" onclick="nextPrev(-1)"><?=$lng['Prev']?></button>
						      <button type="button" class="btn btn-primary btn-fr" id="nextBtn" onclick="nextPrev(1)"><?=$lng['Next']?></button>
						    </div>
						</div>
					  	<!-- Circles which indicates the steps of the form: -->
					</form>
				</div>
			</div>
		</div>
	</div>
	<!------ Prev-Next Modal -------->

	<script src="../assets/js/croppie.js?<?=time()?>"></script>
	<script src="../assets/js/jquery.autocomplete.js"></script>
	<script type="text/javascript">

		function RemoveRow(length){

			$('#modalCompanyUsers table tbody#appendActivity tr.row_'+length).remove();
			$('#modalPrevnext table tbody#appendActivity tr.row_'+length).remove();
		}

		function AddmoreActivity(trID, count, modalNameval){

			// get the selected teams from the first tab 
	  		
	  		var getSelectedTeams = $('[name=teams]').val();

	  		// get teams php array 
	  		var getSelectedTeamsArray = getSelectedTeams.split(',');

	  		// convert PHP array to access in jquery 
	  		var arrayFromPHP = <?php echo json_encode($teamsAct) ?>;

	  		$.each(arrayFromPHP, function (key, value) 
	  		{
		        if(jQuery.inArray(value.id, getSelectedTeamsArray) == -1) 
		        {
		        	delete arrayFromPHP[key];
					
				} 

		    });	


		    var filteredPHPArr = arrayFromPHP.filter(function (el) {
			  return el != undefined;
			});











			if(modalNameval == '001'){
				var modalName = 'modalCompanyUsers';
			}else if(modalNameval == '002'){
				var modalName = 'modalPrevnext';
			}

			if(trID == 1){
				trID = 'Time_module';
			}else if(trID == 2){
				trID = 'Payroll_module';
			}

			// var ss = $('#modalPrevnext table tbody#accessBody tr td.teamsAct').text();
			
			// $.ajax({
			// 	url: "ajax/get_teams.php",
			// 	data: {'teams':ss},
			// 	success: function(response){


			// 	}
			// });

			
			// console.log(ss);

			// return false;



			if(trID == 'Time_module'){

				var counts = count + 1;
				var trIDrepl = trID.replace('_',' ');

				var length = $('#'+modalName+' table tbody#appendActivity tr').length;
				length++;

				var trRow = '<tr id="'+trID+'_'+counts+'" class="row_'+length+'">';
					trRow += '<th><a title="Remove" class="text-danger del_'+length+' delrow" onclick="RemoveRow('+length+')"><i class="fa fa-remove"></i></a> '+trIDrepl+'</th>';
					trRow += '<th>';
					trRow +=	'<select name="activity['+trID+'][activity_name][]" style="min-width:100%; background:transparent;border: 1px solid #fff;padding: 0px !important;">';
									<? foreach ($dataOpt['Time_module'] as $key => $value) { ?>
											trRow += '<option value="<?=$value?>"><?=$value?></option>';
									<? } ?>
						trRow += '</select>';
					trRow +='</th>';

					trRow += '<th>';
					trRow +=	'<select name="activity['+trID+'][activity_level][]" style="min-width:100%; background:transparent;border: 1px solid #fff;padding: 0px !important;">';
					trRow +=	'<option value=""><?=$lng['Please select']?></option>';
									<? foreach($activity_level as $k=>$v){ ?>
									trRow +=	'<option value="<?=$k?>"><?=$v?></option>';
									<? } ?>
					trRow +=	'</select>';
					trRow +='</th>';
					trRow +='<th class="tal">';
					trRow +='<select name="activity['+trID+'][activity_group][]" style="min-width:100%; background:transparent;border: 1px solid #fff;padding: 0px !important;">';
								trRow +='<option value=""><?=$lng['Please select']?></option>';
						

									$.each(filteredPHPArr, function (key, value) 
							  		{
										trRow +='<option value="'+value.id+'">'+value.en+'</option>';
								    });	



						trRow +='</select>';
					trRow +='</th></tr>';

				$('#'+modalName+' table tbody#appendActivity tr#'+trID+'_'+count).after(trRow);

			}else if(trID == 'Payroll_module'){

				var counts = count + 1;
				var trIDrepl = trID.replace('_',' ');

				var length = $('#'+modalName+' table tbody#appendActivity tr').length;
				length++;

				var trRow = '<tr id="'+trID+'_'+counts+'" class="row_'+length+'">';
					trRow += '<th><a title="Remove" class="text-danger del_'+length+' delrow" onclick="RemoveRow('+length+')"><i class="fa fa-remove"></i></a> '+trIDrepl+'</th>';
					trRow += '<th>';
					trRow +=	'<select name="activity['+trID+'][activity_name][]" style="min-width:100%; background:transparent;border: 1px solid #fff;padding: 0px !important;">';
									<? foreach ($dataOpt['Payroll_module'] as $key => $value) { ?>
											trRow += '<option value="<?=$value?>"><?=$value?></option>';
									<? } ?>
						trRow += '</select>';
					trRow +='</th>';

					trRow += '<th>';
					trRow +=	'<select name="activity['+trID+'][activity_level][]" style="min-width:100%; background:transparent;border: 1px solid #fff;padding: 0px !important;">';
					trRow +=	'<option value=""><?=$lng['Please select']?></option>';
									<? foreach($activity_level as $k=>$v){ ?>
									trRow +=	'<option value="<?=$k?>"><?=$v?></option>';
									<? } ?>
					trRow +=	'</select>';
					trRow +='</th>';
					trRow +='<th class="tal">';
					trRow +='<select name="activity['+trID+'][activity_group][]" style="min-width:100%; background:transparent;border: 1px solid #fff;padding: 0px !important;">';
								trRow +='<option value=""><?=$lng['Please select']?></option>';
									<? foreach($teamsAct as $k=>$v){ ?>
									trRow +='<option value="<?=$v['id']?>"><?=$v[$lang]?></option>';
									<? } ?>
						trRow +='</select>';
					trRow +='</th></tr>';

				$('#'+modalName+' table tbody#appendActivity tr#'+trID+'_'+count).after(trRow);
			}
		}

		function SaveUserActicity(){
			var frm = $('#UserActivity');
			var data = frm.serialize();
			$.ajax({
				url: "ajax/update_user_activity.php",
				data: data,
				success: function(response){

					if(response == 'error'){

						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>',
							duration: 4,
							callback: function (value) {
								location.reload();
							}
						})

					}else{

						$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp; Activity updated successfully!',
							duration: 4,
							callback: function (value) {
								location.reload();
							}
						})
					}
				}
			});
		}

		function checkEmail(email){
		//alert(email);
		if(email !=''){

			$.ajax({
				url: "ajax/check_email_exist.php",
				data: {email: email},
				success: function(response){

					if(response != 'success'){
						//$('#password').val(email).attr('readonly',true);
						$('#hiddpassword').val('removepassreq');
						$('#password').val('').attr("placeholder", "User exist already – Use existing password");
					}else{
						$('#password').val('<?=$password?>');
						$('#hiddpassword').val('');
					}
				},
				error:function (xhr, ajaxOptions, thrownError){
					alert(thrownError);
					return false;
				}
			});
		}

		$('#username').val(email);
	}


	$(document).ready(function() {

		var employees = <?=json_encode($employees)?>;
		var compusers = <?=json_encode($compusers)?>;
		var copy_from = <?=json_encode($copy_from)?>;
		var emps = <?=json_encode($emps)?>;

		var parameters = <?=json_encode($parameters)?>;
		var entitiesCount = <?=count($entities)?>;
		var branchesCount = <?=count($branches)?>;
		var divisionsCount = <?=count($divisions)?>;
		var departmentsCount = <?=count($departments)?>;
		var teamsCount = <?=count($teams)?>;

		//============== Access rights ===============

		function updateAccess(access, values){

			$.ajax({
				url: "ajax/update_user_access.php",
				data: {access: access, values: values},
				dataType: 'json',
				success: function(result){

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

					$('input[name="access"]').val(0);
					$('input[name="access_selection"]').val(result.tableRow);
					$('#usersAccess tbody#accessBody').html('');
					$('#usersAccess tbody#accessBody').html(result.tableRow); //return false;
				}
			});
		}
		
		$('#userEntities').SumoSelect({
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
		$('#userBranches').SumoSelect({
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
			updateAccess('entities', $('#userEntities').val());
		});
		$("#userBranches ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccess('branches', $('#userBranches').val());
		});
		$("#userDivisions ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccess('divisions', $('#userDivisions').val());
		});
		$("#userDepartments ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccess('departments', $('#userDepartments').val());
		});
		$("#userTeams ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccess('teams', $('#userTeams').val());
		});

		//============== Access rights ===============


		// devbridgeAutocomplete -------------------------------------------
		$('#system_user_name').on('change', function(){
			//alert($(this).val())
			$("#name").val($(this).val());
		})
		
		$('#system_user_name').devbridgeAutocomplete({
			 lookup: employees,
			 minChars: 0,
			 onSelect: function (suggestion) {
				$("#emp_id").val(emps[suggestion.data]['emp_id']);
				$("#phone").val(emps[suggestion.data]['phone']);
				$("#email").val(emps[suggestion.data]['email']);
				$("#username").val(emps[suggestion.data]['email']);
				//$("#firstname").val(emps[suggestion.data]['firstname']);
				$("#name").val(emps[suggestion.data]['<?=$lang?>_name']);
				$("#img").val(emps[suggestion.data]['image']);
				$('#upload-demo').css('background-image', 'url(../'+emps[suggestion.data]['image']+')');

				checkEmail(emps[suggestion.data]['email']);
			 }
		});

		$('#UserNameFilter').devbridgeAutocomplete({
			lookup: compusers,
			minChars: 0,
			showNoSuggestionNotice: true,
			onSelect: function (suggestion) {
				//alert(suggestions);
				//alert(suggestion.data);
				window.location.href= '?mn=611&userid='+suggestion.data;
			}
		});


		$('#modalCompanyUsers #copy_from').devbridgeAutocomplete({
			lookup: compusers,
			minChars: 0,
			onSelect: function (suggestion) {
				//alert(suggestion.data);
				getPermissionData(suggestion.data, false, 'modalCompanyUsers')
			}
		})

		$('#modalPrevnext #copy_from').devbridgeAutocomplete({
			lookup: compusers,
			minChars: 0,
			onSelect: function (suggestion) {
				//alert(suggestion.data);
				getPermissionData(suggestion.data, false, 'modalPrevnext')
			}
		})

		
		var $uploadCrop;
		var maxSize = 2000;
		//var minHeight = 150;
		//var minWidth = 150;
		$uploadCrop = $('#upload-demo').croppie({
			viewport: {
				width: 150,
				height: 150,
				type: 'square'
			},
			boundary: {
				width: 180,
				height: 180
			},
			mouseWheelZoom: true,
			showZoom: true
		});
		
		$('#selectUserImg').on('change', function () { 
			$("#userBut i").removeClass('fa-user').addClass('fa-repeat fa-spin');
			readFile(this);
		});
		
		function readFile(input) {
			if(input.files && input.files[0]) {
				var file = input.files[0];
				var reader = new FileReader();
				reader.onload = function (e) {
					var img = new Image;
					var t = file.type.split('/')[1];
					var n = file.name;
					var s = ~~(file.size/1024);
					var msg = "";
					if(s > maxSize){msg = '<?=$lng['Filesize is to bigg']?> ('+(s/1024).format(2)+' Mb) - Max. '+(maxSize/1000)+' Mb';}
					if(t != 'jpeg' && t != 'png' && t != 'jpg'){msg = "<?=$lng['Please use only ... files']?>";}
					if(msg!=''){
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+msg,
							duration: 4,
						})
						$("p#selpic i").removeClass('fa-repeat fa-spin').addClass('fa-user');
						$("#upload").val('');
						return false;
					}
					img.src = e.target.result;
					img.onload = function() {
						$("#userBut i").removeClass('fa-repeat fa-spin').addClass('fa-user');
					};
					//$('#klik').html('');
					//alert(e.target.result)
					$('#orig').attr('src', e.target.result);
					$('#img_data').val(e.target.result);
					$uploadCrop.croppie('bind', {
						url: e.target.result
					});
					$('.upload-demo').addClass('ready');
					$("#message").fadeOut();
				}
				reader.readAsDataURL(input.files[0]);
			}else{
				swal("Sorry - you're browser doesn't support the FileReader API");
			}
		}


		function getPermissionData(id, copy, modal){
			//alert(modal);
			$.ajax({
				url: "ajax/get_activity_data.php",
				data: {id: id},
				//dataType: 'json',
				success:function(data){

					$('#'+modal+' table tbody#appendActivity tr').remove();
					if(copy){
						$('#'+modal+' #UserActivity input#userIDs').val('');
					}
					

					if(data == 'Error'){

						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+data,
							duration: 4,
						})

					}else{
						if(copy){
							$('#'+modal+' #UserActivity input#userIDs').val(id);
						}
						$('#'+modal+' table tbody#appendActivity').append(data);
					}
				}
			});
		}

		


		// DELETE USER------------------------------------- DELETE USER
		$('.delUser').confirmation({
			container: 'body',
			rootSelector: '.delUser',
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
					url: "ajax/delete_user.php",
					data:{id: $(this).data('id'), ref: $(this).data('ref'), type: $(this).data('type'), emp: $(this).data('emp')},
					success: function(result){
						//$('#dump').html(result);
						if(result == 'last'){
							$("body").overhang({
								type: "error",
								message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;You can not delete the last company user',
								duration: 4,
							})
							return false;
						}
						location.reload();
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

		$(document).on("click", "#selAllAccess", function(e){
			$.ajax({
				url: "ajax/update_user_all_access.php",
				dataType: 'json',
				success: function(result){
					//$('#dump').html(result); return false;
					$('.allAccess').prop('disabled', false);
					$('input[name="access"]').val(1);
					$('input[name="access_selection"]').val(result.tableRow);
					$('#usersAccess tbody#accessBody').html('');
					$('#usersAccess tbody#accessBody').html(result.tableRow);
				}
			});
		});

		$(document).on("click", ".CompanyUsers", function(e){
			e.preventDefault();
			
			getPermissionData($(this).data('id'), true, 'modalCompanyUsers');
			$('#modalCompanyUsers span#sysUser').html($(this).data('name'));
			$("#modalCompanyUsers img#permImg").prop('src', $(this).data('img'));
			$('#modalCompanyUsers').modal('show');
		});

		$(document).on("click", "#add_Newuser", function(){

			$('#modalPrevnext #userEntities').SumoSelect({
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
			$('#modalPrevnext #userBranches').SumoSelect({
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
			$('#modalPrevnext #userDivisions').SumoSelect({
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
			$('#modalPrevnext #userDepartments').SumoSelect({
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
			$('#modalPrevnext #userTeams').SumoSelect({
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

			if(entitiesCount > 1){
				$('#modalPrevnext #userEntities')[0].sumo.unSelectAll();
			}
			if(parameters[1]['apply_param'] == 1 && branchesCount > 1){
				$('#modalPrevnext #userBranches')[0].sumo.unSelectAll();
			}
			if(parameters[2]['apply_param'] == 1 && divisionsCount > 1){
				$('#modalPrevnext #userDivisions')[0].sumo.unSelectAll();
			}
			if(parameters[3]['apply_param'] == 1 && departmentsCount > 1){
				$('#modalPrevnext #userDepartments')[0].sumo.unSelectAll();
			}
			if(parameters[4]['apply_param'] == 1 && teamsCount > 1){
				$('#modalPrevnext #userTeams')[0].sumo.unSelectAll();
			}


			if(entitiesCount > 1){
				$("#modalPrevnext  #userEntities ~ .optWrapper .MultiControls .btnOk").click( function () {
					updateAccess('entities', $('#modalPrevnext #userEntities').val());
				});
			}

			if(parameters[1]['apply_param'] == 1){
				$("#modalPrevnext #userBranches ~ .optWrapper .MultiControls .btnOk").click( function () {
					updateAccess('branches', $('#modalPrevnext #userBranches').val());
				});
			}
			if(parameters[2]['apply_param'] == 1){
				$("#modalPrevnext #userDivisions ~ .optWrapper .MultiControls .btnOk").click( function () {
					updateAccess('divisions', $('#modalPrevnext #userDivisions').val());
				});
			}
			if(parameters[3]['apply_param'] == 1){
				$("#modalPrevnext #userDepartments ~ .optWrapper .MultiControls .btnOk").click( function () {
					updateAccess('departments', $('#modalPrevnext #userDepartments').val());
				});
			}
			if(parameters[4]['apply_param'] == 1){
				$("#modalPrevnext #userTeams ~ .optWrapper .MultiControls .btnOk").click( function () {
					updateAccess('teams', $('#modalPrevnext #userTeams').val());
				});
			}
			
			
			$("#modalPrevnext").modal('toggle');
		});

		$('#modalPrevnext').on('hidden.bs.modal', function () {
			$(this).find('form#regForm').trigger('reset');
			$('#modalPrevnext #upload-demo').css('background-image', 'url(../images/profile_image.jpg');
		});

		$('.main').fadeIn(200);
	});

	
	var currentTab = 0;
	showTab(currentTab);

	function showTab(n) {
	  var x = document.getElementsByClassName("tab"); 
	  x[n].style.display = "block";
	
	  if (n == 0) {
	    document.getElementById("prevBtn").style.display = "none";
	  } else {
	    document.getElementById("prevBtn").style.display = "inline";
	  }
	  if (n == (x.length - 1)) {
	    document.getElementById("nextBtn").innerHTML = "Submit";
	  } else {
	    document.getElementById("nextBtn").innerHTML = "Next";
	  }
	}

	function nextPrev(n) {
	  var x = document.getElementsByClassName("tab");
	  x[currentTab].style.display = "none";
	  currentTab = currentTab + n;
	  if (currentTab >= x.length) {
	    SaveNewUsersssForm();
	    return false;
	  }
	  showTab(currentTab);

  	//   if ($('table#Activitytable').find('.row_13').length > 0) 
  	//   {
		 //  alert('row exists');
		 //  // if row 13 exists then get all the rows after that and remove them 

		 //  $("#Activitytable tr").each(function(index,value){

		 //  		var checkClass = $(value.firstChild.innerHTML).hasClass("delrow");

		 //  		if(checkClass == true)
		 //  		{
		 //  			// $("#Activitytable tr .delrow").remove();

		 //  		}
		 //  		console.log(checkClass);
			// 	// var delrow = $(this).find(".delrow");

			//  });



	  // }

	}


	function SaveNewUsersssForm(){

		var frm = $('#regForm');
		var data = frm.serialize();
		var file = $('#selectUserImg')[0].files[0];
		
		var err = true;
		if($('user_id').val()==''){err = false};
		if($('#username').val()==''){err = false};
		if($('#hiddpassword').val() == ''){
			if($('#password').val()==''){err = false};
		}
		
		if($('#email').val()==''){err = false};
		if(err==false){
			$('#modalPrevnext').modal('hide');
			$("body").overhang({
				type: "error",
				message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Please fill in required fields']?>',
				duration: 4,
			})
			location.reload();
			return false;
		}
		
		if($('#hiddpassword').val() == ''){
			if($('#password').val().length < 8){
				$('#modalPrevnext').modal('hide');
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Password to short min 8 characters']?>',
					duration: 4,
				})
				location.reload();
				return false;
			};
		}


			$('#modalPrevnext').modal('hide');

			$.ajax({
				url: "ajax/save_user_data.php",
				type: 'POST',
				data: data,
				success: function(result){
					if(result == 'success'){

						$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['New user saved successfully']?>',
							duration: 4,
							callback: function (value) {
								location.reload();
							}
						})
						
					}else{

						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: '+result,
							duration: 4,
							callback: function (value) {
								//location.reload();
							}
						})
					}
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		
	}
	
		

	

</script>