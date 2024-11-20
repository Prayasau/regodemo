<!------ Prev-Next Modal -------->
	<div class="modal fade" id="PrevNextScr" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog" role="document" style="min-width: 800px;">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; OT Requests </h5>
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
				

					<form id="updateOTForm">
					    <!------ 1st tab start ---->

					    <div class="tab">  
					    	
							<table class="basicTable compact inputs mt-2" style="width:100%; border:1px solid #eee; margin-bottom:10px">
								<thead>
									<tr>
										<th colspan="2">Select Period</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th class="tal">Select</th>
										<td>
											<input  placeholder="Date" class="datepick" id="dateperiod" name="dateperiod" style="width:100px; cursor:pointer" type="text" value="" />
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
										<th colspan="2">Select ShiftPlan</th>
									</tr>
								</thead>
								<tbody>
									<tr style="border:0 !important">
										<th class="tal">ShiftPlan</th>
										<td>
											<select name="selectShiftplan" id="selectShiftplan" style="float:left" onchange="showAdditionalShift();">
												<option selected ="selected" value="">Select Shiftplan</option>

												<?php foreach ($shiftPlanArray as $key_plan => $value_plan) { ?>
													
													<option  value="<?php echo $key_plan; ?>"><?php echo $key_plan; ?> </option>

												<?php } ?>
											
											</select>
										</td>
									</tr>

									<thead  style="display: none" class="additional_time_tr">
										<tr>
											<th colspan="2">Additional Time</th>
										</tr>
									</thead>

						
										
									<tr style="border:0 !important;display: none" class="additional_time_tr">
										<th class="tal">Plan From </th>
										<td>
											<input type="text" name="plan_from" id="plan_from" class="mt-2" disabled="disabled">
										</td>
									</tr>						
									<tr style="border:0 !important;display: none" class="additional_time_tr">
										<th class="tal">Plan Until </th>
										<td>
											<input type="text" name="plan_until" id="plan_until" class="mt-2" disabled="disabled">
										</td>
									</tr>					

									<tr style="border:0 !important;display: none" class="additional_time_tr">
										<th class="tal">From </th>
										<td>
											<div class="clockpicker">
												<button type="button"><i class="fa fa-clock-o"></i></button>
												<input id="from2" placeholder="00:00" class="timePic from" type="text" name="from2" value="" />
											</div>
										</td>
									</tr>		
									<tr style="border:0 !important;display: none" class="additional_time_tr">
										<th class="tal">Until </th>
										<td>
											<div class="clockpicker">
												<button type="button"><i class="fa fa-clock-o"></i></button>
												<input  id="until2" placeholder="00:00" class="timePic from" type="text" name="until2" value="" />
											</div>
										</td>
									</tr>								
									<tr style="border:0 !important;display: none" class="additional_time_tr">
										<th class="tal">Break </th>
										<td>
											<div class="clockpicker">
												<button type="button"><i class="fa fa-clock-o"></i></button>
												<input  id="break" placeholder="00:00" class="timePic from" type="text" name="break" value="" />
											</div>
										</td>
									</tr>						
									<tr style="border:0 !important;display: none" class="additional_time_tr">
										<th class="tal">Hours </th>
										<td>
											<div class="clockpicker">
												<button type="button"><i class="fa fa-clock-o"></i></button>
												<input  id="hours_field" placeholder="00:00" class="timePic from" type="text" name="hours_field" value="" />
											</div>
										</td>
									</tr>	

									<thead  style="display: none" class="additional_time_tr">
										<tr>
											<th colspan="2">Compensations</th>
										</tr>
									</thead>

									<tr style="border:0 !important;display: none" class="additional_time_tr">
										<th class="tal">Select Compensation Model </th>
										<td>
											<select id="selectComModel" style="float:left" onchange="showCompPlans();">
												<option selected ="selected" value="select">Select Model</option>

												<?php foreach ($compArray as $key_comp => $value_comp) { ?>
													
													<option  value="<?php echo $value_comp['id']; ?>"><?php echo $value_comp['name']; ?> </option>

												<?php } ?>
											
											</select>
										</td>
									</tr>

									<tr style="border:0 !important;display: none" class="showCompensation">
										<th class="tal">Select Compensation </th>
										<td>
											<select id="selectedComp" name="selectedComp" style="float:left">
											
											</select>
										</td>
									</tr>
									
								</tbody>
							</table>
					    </div>
					    <!------ 2nd tab start ---->
		
					    <!------ 5th tab start ---->
					    <div class="tab" style="display: none;">  
					    	
							<table class="basicTable compact inputs mt-2" style="width:100%; border:1px solid #eee; margin-bottom:10px">
								<thead>
									<tr>
										<th colspan="2">Select Team</th>
									</tr>
								</thead>
								<tbody>
									<tr style="border:0 !important">
										<th class="tal">Select</th>
										<td>
											<select onchange="get_employees();" class="cLevel" id="availableTeams" name="availableTeams" style="width:100%;padding: 0px !important;text-transform: uppercase;">
											
												
											</select>
										</td>
									</tr>
								</tbody>
							</table>
					    </div>
					    <!------ 5th tab start ---->
					    <!------ 6th tab start ---->
					    <div class="tab" style="display: none;">  
					    	
							<table id="showEmployee" class="basicTable compact inputs mt-2" style="width:100%; border:1px solid #eee; margin-bottom:10px">
								<thead>
									<tr>
										<th colspan="8">Select Employee</th>
									</tr>
									<tr style="background:#09c; color:#fff;">
										
										<th style="color:#fff">Select</th>
										<th style="color:#fff">ID</th>
										<th style="color:#fff">Employee</th>
										<th style="color:#fff">Position</th>
										<th style="color:#fff">Shiftteam</th>
										<th style="color:#fff">Invite</th>
										<th style="color:#fff">Confirm</th>
										<th style="color:#fff">Assign</th>
										
									</tr>
								</thead>
								<tbody id="tbody_emp">
				
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
	    SaveOtShift();
	    return false;
		}
		//alert(currentTab);
		showTab(currentTab);
	}

	function SaveOtShift(){

		$('#plan_from').prop("disabled", false);
		$('#plan_until').prop("disabled", false);

		var data = $('#updateOTForm').serialize();

		console.log(data);
		// location.reload();
		
$('#PrevNextScr').modal('hide');

	

		$.ajax({
			url: "ajax/save_ot_shift_request.php",
			type: 'POST',
			data: data,
			success: function(result){

				if(result == 'success'){

					$("body").overhang({
						type: "success",
						message: '<i class="fa fa-check"></i>&nbsp;&nbsp;OT Request Submitted Successfully',
						duration: 2,
						callback: function (value) {
							location.href = 'index.php?mn=7';
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
		})
	}
</script>

<script type="text/javascript">


	function showAdditionalShift()
	{


		var selectShiftplan = $('#selectShiftplan').val();

		// run ajax and get the data of the selected shift plan for example DWD 
		$.ajax({
			url: "ajax/get_selected_shiftplan_data.php",
			type: 'POST',
			data: {selectShiftplan:selectShiftplan},
			success: function(result){


				var data = JSON.parse(result);
				if(data){

					$('#plan_from').val(data.hours);
					$('#plan_until').val(data.u2);
					$('.additional_time_tr').css('display','');						
				}

			},

		})



		// select shiftplan from the second popup

		// select date from the first popup 
		var dateperiod = $('#dateperiod').val();



		// clear the old teams before selecting again 
		$('#availableTeams').empty();
		 $('#availableTeams').append($("<option></option>").attr("value", '').text('Select')); 


		// run ajax and search for teams with same shiftplan on the selected date 
		$.ajax({
			url: "ajax/get_teams_have_same_plan.php",
			type: 'POST',
			data: {dateperiod:dateperiod,selectShiftplan:selectShiftplan},
			success: function(result){


				var data = JSON.parse(result);
				if(data){

					$.each(data, function(key, value) {   
    				 $('#availableTeams').append($("<option></option>").attr("value", value).text(value)); 
 					});
						
				}

			},

		})





	}


	function showCompPlans()
	{
		var selectComModel = $('#selectComModel').val();

		if($.trim(selectComModel)== 'select')
		{
			$('.showCompensation').css('display','none');
			return false;
		}


		$('#selectedComp').empty();
		$.ajax({
			url: "ajax/get_compensation_from_model.php",
			type: 'POST',
			data: {selectComModel:selectComModel},
			success: function(data){
				var result= JSON.parse(data);
				if($.trim(result) != '"Error"'){

					// show selected compdata
					var earlyHours = result.early_hours;
					var lateHours = result.late_hours;
					var earlyTHB = result.early_thb;
					var earlyEvent = result.early_event;
					var lateEvent = result.late_event;

					$('.showCompensation').css('display','');

					if(earlyHours =='1')
					{
						$('#selectedComp').append($('<option>', {value: 'early_hours',text: 'Early Hours'}));
					}
					if(lateHours =='1')
					{
						$('#selectedComp').append($('<option>', {value: 'late_hours',text: 'Late Hours'}));
					}
					if(earlyTHB =='1')
					{
						$('#selectedComp').append($('<option>', {value: 'early_thb',text: 'Early THB'}));
					}
					if(earlyEvent =='1')
					{
						$('#selectedComp').append($('<option>', {value: 'early_event',text: 'Early Event'}));
					}
					if(lateEvent =='1')
					{
						$('#selectedComp').append($('<option>', {value: 'late_event',text: 'Late Event'}));
					}
					
						
				}

			},

		})
	}


function get_employees()
{
	// get the team name from popup screen3 

	var availableTeams = $('#availableTeams').val();

	// run ajax and get the employees of that team 

	$("#showEmployee > tbody").html("");


	$.ajax({
			url: "ajax/get_employees_from_team.php",
			type: 'POST',
			data: {availableTeams:availableTeams,},
			success: function(result){


				var data = JSON.parse(result);
				if(data){
					var count =1;
					$.each(data, function(key, value) {   
						var counter= count++;
						console.log(counter);
						var tr = '<tr><td><input type="checkbox" name="apply_'+counter+'" id="applyid_'+counter+'" value="1" class="ml-2"></td><td style="text-align:center;">'+value.emp_id_editable+'</td><td style="text-align:center;">'+value.en_name+'</td><td style="text-align:center;">'+value.position+'</td><td style="text-align:center;text-transform:uppercase;">'+value.teams+'</td><td><input type="checkbox" name="invite_'+counter+'" id="invite_'+counter+'" value="1" class="ml-2"></td><td><input type="checkbox" name="confirm_'+counter+'" id="confirm_'+counter+'" value="1" class="ml-2"></td><td><input type="checkbox" name="assign_'+counter+'" id="assign_'+counter+'" value="1" class="ml-2"></td></tr>';
    				 $('table#showEmployee tbody#tbody_emp').append(tr); 
 					});
						
				}

			},

		})





}
</script>