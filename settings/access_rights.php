<?

	$employees = getJsonUserEmployees($cid, $lang);
	$emps = getEmployees($cid, 0);
	$password = generateStrongPassword(8, false);//randomPassword();


	$users = array();
	$sql = "SELECT * FROM ".$cid."_users WHERE type != 'emp'";
	if($res = $dbc->query($sql)){
		while($row = $res->fetch_assoc()){ 
			$users[] = $row;
			$copy_from[] = array('data'=>$row['id'], 'value'=>$row['name']);
		}
	}else{
		echo mysqli_error($dbc);
	}
	if(!$users){$users = array();}
	if(!$copy_from){$copy_from = array();}
	//var_dump($users); exit;
	
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
		min-width: 200px !important;
		padding: 4px 0 0 10px !important;
		border:0 !important;
	}
	.SumoSelect > .CaptionCont {
		background:transparent !important;
		font-weight:600;
	}
</style>

	<link rel="stylesheet" href="../assets/css/croppie_users.css?<?=time()?>" />

	<h2><i class="fa fa-cog"></i>&nbsp; <?=$lng['Access Rights']?> (<?=$lng['System User']?> & <?=$lng['Company User']?>)</h2>
	
	<div class="main" style="display:none">
		<div style="padding:0 0 0 20px" id="dump"></div>
			 
		<table border="0" class="basicTable pad010">
			<thead>
				<tr>
					<th class="tac" style="width:1px; padding:0 5px"><i class="fa fa-image fa-lg"></i></th>
					<? if($_SESSION['rego']['standard'][$standard]['set_permissions']){ ?>
					<th class="tac" style="width:1px"><i data-toggle="tooltip" data-placement="right" title="Set permissions" class="fa fa-cog fa-lg"></i></th>
					<? } ?>
					<th style="min-width:100px"><?=$lng['Type']?></th> 
					<th><?=$lng['Name']?></th> 
					<th><?=$lng['Username']?></th> 
					<th style="min-width:100px"><?=$lng['Phone']?></th>
					<th><?=$lng['Status']?></th>
					<th style="width:80%"></th>
					
				</tr>
			</thead>
			<tbody>
			<? if($users){ 
				foreach($users as $k=>$v){ $pid = $cid.'_'.$v['username'];?>
				<tr>
					<td class="tac" style="padding:0 !important;">
						<center><img style="height:28px; width:28px; margin:2px; cursor:default" class="img-tooltip" data-id="<?=$v['id']?>" title="<img src=../<?=$v['img'].'?'.time()?> />" data-toggle="tooltip" data-placement="right" src="../<?=$v['img'].'?'.time()?>" /></center>
					</td>
					<? if($_SESSION['rego']['standard'][$standard]['set_permissions']){ ?>
					<td class="tac"><a class="permissions" data-id="<?=$v['id']?>"><i class="fa fa-cog fa-lg"></i></a></td>
					<? } ?>
					<td><?=$v['type']?></td>
					<td><?=$v['name']?></td>
					<td><?=$v['username']?></td>
					<td><?=$v['phone']?></td>
					<td><?=$def_status[$v['status']]?></td>
					<td></td>
					
				</tr>
			<? }
			}else{ ?>
				<tr>
					<td colspan="12" style="font-size:14px;color:#000;text-align:center;padding:6px 10px !important; background:#ff6; font-weight:600">
						<?=$lng['No data available in Database']?>
					</td>
				</tr>
			<? } ?>  
			</tbody>
		</table><br>
		

    <form id="permissionForm" style="position:relative; <? if(!$_SESSION['rego']['standard'][$standard]['set_permissions']){echo 'display:none';}?>">
    	<fieldset disabled>
			<input id="user_id" name="id" type="hidden" value=""  />
			<table class="basicTable" style="margin-top:0px; width:100%; table-layout:auto">
				<thead>
					<tr>
						<th class="tal" colspan="11" style="padding:4px; vertical-align: bottom !important; font-size:18px">
							<table border="0" style="width:100%;">
								<tr>
									<td style="padding:1px 0 0 1px">
										<img id="permImg" style="height:60px; display:block;" src="../images/profile_image.jpg" />
									</td>
									<td style="vertical-align:bottom; padding-bottom:5px; min-width:280px">
										<span style="color:#a00" id="sysUser"></span>
									</td>
									<td style="vertical-align:bottom">
										<?=$lng['Copy access from']?> : <input style="background:transparent; width:250px; border-bottom:1px solid #ccc; font-size:16px; padding:0; margin-left:5px" placeholder="<?=$lng['Type for hints']?> ..." id="copy_from" type="text" />
									</td>
									<td style="width:90%; padding:0 5px 7px 20px; vertical-align:bottom;">
										<span id="accessMsg"></span>
									</td>
									<td style="padding-bottom:8px; vertical-align:bottom">
										<button type="submit" class="btn btn-primary" id="save_settings"><i class="fa fa-save"></i>&nbsp; <?=$lng['Update Access']?></button>
									</td>
								</tr>
							</table>
						</th> 
					</tr>
				</thead>
			</table>
			
			<table id="usersAccess" class="basicTable" style="margin-top:5px; width:100%; table-layout:auto">
				<thead>
					<tr style="line-height:100%; background:#09c; color:#fff; border-bottom:1px solid #06a">
						<th style="color:#fff;"><?=$lng['Employee group']?></th>
						<th style="color:#fff"><?=$lng['Entities']?></th>
						<th style="color:#fff"><?=$lng['Branches']?></th>
						<th style="color:#fff"><?=$lng['Divisions']?></th>
						<th style="color:#fff"><?=$lng['Departments']?></th>
						<th style="color:#fff"><?=$lng['Teams']?></th>
						<th style="width:60%"></th>
					</tr>
				</thead>
				<tbody>
					<tr style="background:#f9f9f9">
						<td style="padding:0">
							<select name="emp_group" style="width:100%; min-width:auto; background:transparent">
							<? foreach($emp_group as $k=>$v){ ?>
								<option value="<?=$k?>"><?=$v?></option>
							<? } ?>
							</select>
						</td>
						<td style="padding:0">
							<select name="entities" multiple="multiple" id="userEntities">
							<? foreach($entities as $k=>$v){ ?>
								<option value="<?=$k?>"><?=$v[$lang]?></option>
							<? } ?>
							</select>
							<input type="hidden" name="access">	
							<input type="hidden" name="access_selection">	
							<input disabled class="allAccess" name="entities" type="hidden" value="1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20" />
						</td>
						<td style="padding:0">
							<select name="branches" multiple="multiple" id="userBranches">
							<? foreach($branches as $k=>$v){ ?>
								<option value="<?=$k?>"><?=$v[$lang]?></option>
							<? } ?>
							</select>	
							<input disabled class="allAccess" name="branches" type="hidden" value="1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20" />
						</td>
						<td style="padding:0">
							<select name="divisions" multiple="multiple" id="userDivisions">
							<? foreach($divisions as $k=>$v){ ?>
								<option value="<?=$k?>"><?=$v[$lang]?></option>
							<? } ?>
							</select>	
							<input disabled class="allAccess" name="divisions" type="hidden" value="1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20" />
						</td>
						<td style="padding:0">
							<select name="departments" multiple="multiple" id="userDepartments">
							<? foreach($departments as $k=>$v){ ?>
								<option value="<?=$k?>"><?=$v[$lang]?></option>
							<? } ?>
							</select>	
							<input disabled class="allAccess" name="departments" type="hidden" value="1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20" />
						</td>
						<td style="padding:0">
							<select name="teams" multiple="multiple" id="userTeams">
							<? foreach($teams as $k=>$v){ ?>
								<option value="<?=$k?>"><?=$v[$lang]?></option>
							<? } ?>
							</select>	
							<input disabled class="allAccess" name="teams" type="hidden" value="1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50" />
						</td>
						<td style="padding:0 5px">
							<button id="selAllAccess" style="padding:1px 10px !important; height:22px !important" type="button" class="btn btn-outline-dark btn-xs"><?=$lng['Select all']?></button>			
						</td>
					</tr>
				</tbody>
				<tbody id="accessBody">

				</tbody>
			</table>
	
      </fieldset>
		</form>
    <div style="height:50px"></div> 
	</div>
	
	

	<!-- PAGE RELATED PLUGIN(S) -->
	<script src="../assets/js/croppie.js?<?=time()?>"></script>
	<script src="../assets/js/jquery.autocomplete.js"></script>

	<script>


	$(document).ready(function() {
		
		var employees = <?=json_encode($employees)?>;
		var copy_from = <?=json_encode($copy_from)?>;
		var emps = <?=json_encode($emps)?>;
		
		function updateAccess(access, values){
			$.ajax({
				url: "ajax/update_user_access.php",
				data: {access: access, values: values},
				dataType: 'json',
				success: function(result){
					//alert(result.tableRow);
					//$('#dump').html(result); return false;
					$('#userEntities')[0].sumo.unSelectAll();
					$.each(result.entity, function(v){
						$('#userEntities')[0].sumo.selectItem(v);
					})
					$('#userBranches')[0].sumo.unSelectAll();
					$.each(result.branch, function(i,v){
						$('#userBranches')[0].sumo.selectItem(v);
					})
					$('#userDivisions')[0].sumo.unSelectAll();
					$.each(result.division, function(i,v){
						$('#userDivisions')[0].sumo.selectItem(v);
					})
					$('#userDepartments')[0].sumo.unSelectAll();
					$.each(result.department, function(v){
						$('#userDepartments')[0].sumo.selectItem(v);
					})
					
					$('#userTeams')[0].sumo.unSelectAll();
					$.each(result.team, function(v){
						$('#userTeams')[0].sumo.selectItem(v);
					})
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
		
		$('#userEntities')[0].sumo.disable();
		$('#userBranches')[0].sumo.disable();
		$('#userDivisions')[0].sumo.disable();
		$('#userDepartments')[0].sumo.disable();
		$('#userTeams')[0].sumo.disable();
		
		$('#userEntities')[0].sumo.unSelectAll();
		$('#userBranches')[0].sumo.unSelectAll();
		$('#userDivisions')[0].sumo.unSelectAll();
		$('#userDepartments')[0].sumo.unSelectAll();
		$('#userTeams')[0].sumo.unSelectAll();
		
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

		
		
		$('#copy_from').devbridgeAutocomplete({
			lookup: copy_from,
			minChars: 0,
			onSelect: function (suggestion) {
				getPermissionData(suggestion.data, false)
			}
		})/*.focus(function () {
        $(this).devbridgeAutocomplete('search', $(this).val())
    });*/	
		
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
		};
	
		
		

		// SHOW PERMISSION FORM -------------------------------------------------------------------------------------------
		function getPermissionData(id, copy){
			if(copy){
				$("#user_id").val(id);
				$('#copy_from').val('');
			}
			$('input[type="checkbox"]').prop('checked',false);
			//$('input[type="checkbox"]').prop('disabled',true);
			//return false;
			$.ajax({
				url: "ajax/get_permission_data.php",
				data: {id: id},
				dataType: 'json',
				success:function(data){
					if(copy){
						$("#sysUser").html(data.name);
						$("#permImg").prop('src', '../'+data.img);
					}
					//$('#dump').html(data); //return false;
					
					$('#save_settings').css('display','block')
					$('#save_settings').prop('disabled',false)
					$('#permissionForm fieldset').prop('disabled',false)
					$('input[type="checkbox"]').prop('disabled',false);
					$('input[type="checkbox"]').prop('checked',false);
					//return false
					
					$.each(data.permissions, function (key, val) {
						$.each(val, function (k, v) {
							if(v == 1){
								$('input[name="'+key+'['+k+']"]').prop('checked',true)
							}
						});
					});
					//changeSumo = 0;
					$('#userEntities')[0].sumo.enable();
					$('#userBranches')[0].sumo.enable();
					$('#userDivisions')[0].sumo.enable();
					$('#userDepartments')[0].sumo.enable();
					$('#userTeams')[0].sumo.enable();

					//alert(data.entities);
					
					$.each((data.entities).split(','), function(i,v){
						$('#userEntities')[0].sumo.selectItem(v);
					})
					$.each((data.branches).split(','), function(i,v){
						$('#userBranches')[0].sumo.selectItem(v);
					})
					$.each((data.divisions).split(','), function(i,v){
						$('#userDivisions')[0].sumo.selectItem(v);
					})
					$.each((data.departments).split(','), function(i,v){
						$('#userDepartments')[0].sumo.selectItem(v);
					})
					
					$.each((data.teams).split(','), function(i,v){
						$('#userTeams')[0].sumo.selectItem(v);
						//alert(v)
					})

					$('input[name="access"]').val(data.access);
					$('input[name="access_selection"]').val(data.access_selection);
					$('#usersAccess tbody#accessBody').html(data.access_selection);
					$('select[name="emp_group"]').val(data.emp_group);
					if(data.access == 1){
						$('.allAccess').prop('disabled', false);
					}

					$('input.cMod').each(function(){
						if(!$(this).is(':checked')){
							$(this).trigger('change')
						}
					});
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
		
		$(document).on("click", ".permissions", function(e){
			e.preventDefault();
			getPermissionData($(this).data('id'), true);
		});
			
		$(document).on("click", "#selAll", function(e){
			$('input[type="checkbox"]').prop('checked', this.checked);
			if(this.checked){
				$('.cBox').prop('disabled', false);
			}else{
				$('.cBox').prop('disabled', true);
			}
		})

		
			
		// SUBMIT PERMISSION FORM ---------------------------------------------------------------------------------------
		$(document).on('submit','#permissionForm', function(e){
			e.preventDefault();
			var data = $(this).serialize();
			$.ajax({
				url: "ajax/save_user_access_rights.php",
				type: 'POST',
				data: data,
				//dataType: 'json',
				success: function(result){
					//$('#dump').html(result); return false;
					if(result == 'success'){
						$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Access rights updated successfuly']?>',
							duration: 2,
						})
					}else{
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+result,
							duration: 4,
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
		});


		
		
		$('.main').fadeIn(200);
	
	})
		
	</script>






















