<!------ Prev-Next Modal -------->
	<div class="modal fade" id="PrevNextScr" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog" role="document" style="min-width: 800px;">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; Model Details</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload()">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<table border="0" style="margin:0; width:100%">
						<thead>
							<tr>
								<th style="font-size:16px; white-space:nowrap" class="tal" id="mName"></th>
								<th style="width:80%"></th>
							</tr>
						</thead>
					</table>
				

					<form id="UpdatePopupForm">
					    <!------ 1st tab start ---->

					    <div class="tab">  
					    	
							<table class="basicTable compact inputs mt-2" style="width:100%; border:1px solid #eee; margin-bottom:10px">
								<thead>
									<tr>
										<th colspan="2"><?=$lng['Name']?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th class="tal"><?=$lng['Apply']?></th>
										<td>
											<input type="hidden" name="apply"  value="0">
											<input type="checkbox" name="apply" id="applyid" value="1" class="ml-2">
										</td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Name']?></th>
										<td>
											<input type="hidden" name="row_id" id="rowID">
											<input type="text" name="name" id="edMname">
											<input type="hidden" name="tab_name" id="myTabname">
										</td>
									</tr>
								</tbody>
							</table>
					    </div>
					    <!------ 1st tab start ---->
					    <!------ 2nd tab start ---->
					    <div class="tab" style="display: none;">  
					    	
							<table class="basicTable compact inputs mt-2" style="width:100%; border:1px solid #eee; margin-bottom:10px">
								<thead>
									<tr>
										<th colspan="2"><?=$lng['General information']?></th>
									</tr>
								</thead>
								<tbody>
									<tr style="border:0 !important">
										<th class="tal"><?=$lng['Feed']?></th>
										<td>
											<select class="cLevel" name="feed" style="width:100%;padding: 0px !important;">
												<option value="Manual"><?=$lng['Manual']?></option>
												<option value="Calculated"><?=$lng['Calculated']?></option>
											</select>
										</td>
									</tr>
									<tr style="border:0 !important">
										<th class="tal"><?=$lng['Type']?></th>
										<td>
											<select class="cLevel" name="type" style="width:100%;padding: 0px !important;" onchange="SelectLinkedto(this.value);">
												<option value="Rewards"><?=$lng['Rewards']?></option>
												<option value="Penalties"><?=$lng['Penalties']?></option>
											</select>
										</td>
									</tr>
									<tr style="border:0 !important">
										<th class="tal"><?=$lng['Linked to']?></th>
										<td>
											<select class="cLevel" id="sellink" name="linked_to" style="width:100%;padding: 0px !important;">
											
											</select>
										</td>
									</tr>
								</tbody>
							</table>
					    </div>
					    <!------ 2nd tab start ---->
					    <!------ 3rd tab start ---->
					    <div class="tab" style="display: none;">  
					    	
							<table class="basicTable compact inputs mt-2" style="width:100%; border:1px solid #eee; margin-bottom:10px">
								<thead>
									<tr>
										<th colspan="2"><?=$lng['Data']?></th>
									</tr>
								</thead>
								<tbody>
									<tr style="border:0 !important">
										<th class="tal pr-4"><?=$lng['Early Hours']?></th>
										<td>
											<input type="hidden" name="early_hours" value="0">
											<input type="checkbox" name="early_hours" id="early_hoursid" value="1" class="mt-2">
										</td>
									</tr>

									<tr style="border:0 !important">
										<th class="tal pr-4"><?=$lng['Late Hours']?></th>
										<td>
											<input type="hidden" name="late_hours" value="0">
											<input type="checkbox" name="late_hours" id="late_hoursid" value="1" class="mt-2">
										</td>
									</tr>

									<tr style="border:0 !important">
										<th class="tal pr-4"><?=$lng['Early THB']?></th>
										<td>
											<input type="hidden" name="early_thb" value="0">
											<input type="checkbox" name="early_thb" id="early_thbid" value="1" class="mt-2">
										</td>
									</tr>

									<tr style="border:0 !important">
										<th class="tal pr-4"><?=$lng['Late THB']?></th>
										<td>
											<input type="hidden" name="late_thb" value="0">
											<input type="checkbox" name="late_thb" id="late_thbid" value="1" class="mt-2">
										</td>
									</tr>

									<tr style="border:0 !important">
										<th class="tal pr-4"><?=$lng['Early Event']?></th>
										<td>
											<input type="hidden" name="early_event" value="0">
											<input type="checkbox" name="early_event" id="early_eventid" value="1" class="mt-2">
										</td>
									</tr>

									<tr style="border:0 !important">
										<th class="tal pr-4"><?=$lng['Late Event']?></th>
										<td>
											<input type="hidden" name="late_event" value="0">
											<input type="checkbox" name="late_event" id="late_eventid" value="1" class="mt-2">
										</td>
									</tr>
								</tbody>
							</table>
					    </div>
					    <!------ 3rd tab start ---->
					    <!------ 4th tab start ---->
					    <div class="tab" style="display: none;">  
					    	
							<table id="tab4" class="basicTable compact inputs mt-2" style="width:100%; border:1px solid #eee; margin-bottom:10px">
								<thead>
									<tr>
										<th colspan="2"><?=$lng['Condition']?></th>
									</tr>
								</thead>
								<tbody id="tab4tbody">
									<tr style="border:0 !important">
										<th class="tal"><?=$lng['Acceptable E/L per event']?></th>
										<td>
											<input type="hidden" name="acc_el_per_evt" value="0">
											<input type="checkbox" name="acc_el_per_evt" id="acc_el_per_evtid" value="1" class="ml-2">
										</td>
									</tr>
									<tr style="border:0 !important">
										<th class="tal"><?=$lng['Acceptable early']?></th>
										<td>
											<input type="text" name="acc_early" class="hourFormat" value="" placeholder="000:00">
										</td>
									</tr>
									<tr style="border:0 !important">
										<th class="tal"><?=$lng['Acceptable late']?></th>
										<td>
											<input type="text" name="acc_late" class="hourFormat" value="" placeholder="000:00">
										</td>
									</tr>
								</tbody>
							</table>
					    </div>
					    <!------ 4th tab start ---->
					    <!------ 5th tab start ---->
					    <div class="tab" style="display: none;">  
					    	
							<table class="basicTable compact inputs mt-2" style="width:100%; border:1px solid #eee; margin-bottom:10px">
								<thead>
									<tr>
										<th colspan="2"><?=$lng['Result']?></th>
									</tr>
								</thead>
								<tbody>
									<tr style="border:0 !important">
										<th class="tal"><?=$lng['Penalties']?></th>
										<td>
											<select class="cLevel" name="penalties" style="width:100%;padding: 0px !important;">
												<? foreach ($dataRP as $key => $value) { ?>
													<option value="<?=$value['id']?>"><?=$value['code']?></option>
												<? } ?>
												
											</select>
										</td>
									</tr>
								</tbody>
							</table>
					    </div>
					    <!------ 5th tab start ---->
					    <!------ 6th tab start ---->
					    <div class="tab" style="display: none;">  
					    	
							<table id="usersAccess" class="basicTable compact inputs mt-2" style="width:100%; border:1px solid #eee; margin-bottom:10px">
								<thead>
									<tr>
										<th colspan="5"><?=$lng['Employee group']?></th>
									</tr>
									<tr style="background:#09c; color:#fff;">
										
										<th style="color:#fff"><?=$lng['Entities']?></th>
										<th style="color:#fff"><?=$lng['Branches']?></th>
										<th style="color:#fff"><?=$lng['Divisions']?></th>
										<th style="color:#fff"><?=$lng['Departments']?></th>
										<th style="color:#fff"><?=$lng['Teams']?></th>
										
									</tr>
								</thead>
								<tbody>
									<tr>
										<td style="padding:0">
											<select name="entities" multiple="multiple" id="userEntities">
											<? foreach($entities as $k=>$v){ ?>
												<option value="<?=$k?>"><?=$v[$lang]?></option>
											<? } ?>
											</select>
										</td>
										<td style="padding:0">
											<select name="branches" multiple="multiple" id="userBranches">
											<? foreach($branches as $k=>$v){ ?>
												<option value="<?=$k?>"><?=$v[$lang]?></option>
											<? } ?>
											</select>	
											
										</td>
										<td style="padding:0">
											<select name="divisions" multiple="multiple" id="userDivisions">
											<? foreach($divisions as $k=>$v){ ?>
												<option value="<?=$k?>"><?=$v[$lang]?></option>
											<? } ?>
											</select>	
											
										</td>
										<td style="padding:0">
											<select name="departments" multiple="multiple" id="userDepartments">
											<? foreach($departments as $k=>$v){ ?>
												<option value="<?=$k?>"><?=$v[$lang]?></option>
											<? } ?>
											</select>	
											
										</td>
										<td style="padding:0">
											<select name="teams" multiple="multiple" id="userTeams">
											<? foreach($teams as $k=>$v){ ?>
												<option value="<?=$k?>"><?=$v['code']?></option>
											<? } ?>
											</select>	
										</td>
									</tr>
								</tbody>
								<tbody id="accessBody">
									
								</tbody>
								
							</table>
					    </div>
					    <!------ 6th tab start ---->


					    <div style="overflow:auto;" class="mt-4" id="hideauto">
						    <div>
						      <button type="button" class="btn btn-primary btn-fl" id="prevBtn" onclick="nextPrev(-1)"><?=$lng['Prev']?></button>
						      <button type="button" class="btn btn-primary btn-fr" id="nextBtn" onclick="nextPrev(1)"><?=$lng['Next']?></button>
						    </div>
						</div>
					</form>


					
				</div>

			</div>

		</div>

	</div>
<style type="text/css">
	
	#PrevNextScr .SumoSelect {
	   
	    width: 150px !important;
	}

	#PrevNextScr tbody#accessBody tr td {
	    padding: 5px !important;
	}
</style>
<script type="text/javascript">

	
	//======= tabs =====//	
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
	    SaveNewBenifitModel();
	    return false;
		}
		//alert(currentTab);
		showTab(currentTab);
	}

	function SaveNewBenifitModel(){

		var frm = $('#UpdatePopupForm');
		var data = frm.serialize();

		var err = false;
		var erval;
		if($('#UpdatePopupForm input#edMname').val() == ''){err = true; erval = '<?=$lng['Error']?>: Name is blank';};

		if(err == true){

			$("body").overhang({
				type: "error",
				message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;'+erval,
				duration: 3,
				callback: function(v){
					location.reload();
				}
			})
			return false;
		}

		$('#PrevNextScr').modal('hide');

		$.ajax({
			url: "ajax/save_benefitModel_data.php",
			type: 'POST',
			data: data,
			success: function(result){

				if(result == 'success'){

					$("body").overhang({
						type: "success",
						message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Benefit model data saved successfully']?>',
						duration: 2,
						callback: function (value) {
							location.href = 'index.php?mn=613';
						}
					})
						
				}else{

					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: '+result,
						duration: 2,
						callback: function (value) {
							location.reload();
						}
					})
				}

			},
			error:function (xhr, ajaxOptions, thrownError){
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
					duration: 2,
					callback: function (value) {
						location.reload();
					}
				})
			}
		})
	}
</script>