<?php
	
	$leave_types = getLeaveTypes($cid);
	$getLeaveReqBefore = getLeaveReqBefore($cid);
	$pending = array();
	$approved = array();
	$history = array();
	$res = $dbc->query("SELECT * FROM ".$cid."_leaves WHERE emp_id = '".$_SESSION['rego']['emp_id']."' ORDER BY id DESC LIMIT 10"); 
	while($row = $res->fetch_assoc()){
		if($row['status'] == 'RQ'){
			$pending[$row['id']]['leave_type'] = $row['leave_type'];
			$pending[$row['id']]['days'] = $row['days'];
			$pending[$row['id']]['start'] = date('d-m-Y', strtotime($row['start']));
			$pending[$row['id']]['end'] = date('d-m-Y', strtotime($row['end']));
			$pending[$row['id']]['status'] = $row['status'];
			$pending[$row['id']]['created'] = $row['created'];
		}elseif ($row['status'] == 'AP'){	
			$approved[$row['id']]['leave_type'] = $row['leave_type'];
			$approved[$row['id']]['days'] = $row['days'];
			$approved[$row['id']]['start'] = date('d-m-Y', strtotime($row['start']));
			$approved[$row['id']]['end'] = date('d-m-Y', strtotime($row['end']));
			$approved[$row['id']]['status'] = $row['status'];
			$approved[$row['id']]['created'] = $row['created'];
		}else{	
			$history[$row['id']]['leave_type'] = $row['leave_type'];
			$history[$row['id']]['days'] = $row['days'];
			$history[$row['id']]['start'] = date('d-m-Y', strtotime($row['start']));
			$history[$row['id']]['end'] = date('d-m-Y', strtotime($row['end']));
			$history[$row['id']]['status'] = $row['status'];
			$history[$row['id']]['created'] = $row['created'];
		}
	}
	//var_dump($history); exit;
	$status_color = array('RQ'=>'bg-blue-light','CA'=>'bg-yellow-dark','AP'=>'bg-green-dark','RJ'=>'bg-red-light','TA'=>'bg-night-light');
	if($lang == 'en'){
		$leave_status['RQ'] = 'Pending';
	}else{
		$leave_status['RQ'] = 'อยู่ระหว่างดำเนินการ';
	}


	$emp_id_value = $_SESSION['rego']['emp_id'];
	// echo '<pre>';
	// print_r($getLeaveReqBefore);
	// echo '</pre>';
	// exit;
	
?>	

	<div class="container-fluid" style="xborder:1px solid red">
		
		<div class="row" style="xborder:1px solid green; padding:10px 4px">
		<form id="requestForm" style="height:100%; position:relative">
			<input name="emp_id" type="hidden" value="<?=$_SESSION['rego']['emp_id']?>" />
			<!--<input name="name" type="hidden" value="<?=$_SESSION['rego']['name']?>" />
			<input name="phone" type="hidden" value="<?=$_SESSION['rego']['phone']?>" />-->
			<input name="leave_type" type="hidden" />
			<input style="visibility:hidden; height:0; position:absolute" id="certificate" type="file" name="attach" />
		
			<button data-toggle="modal" data-target="#leavetypeModal" type="button" class="btn btn-danger btn-block"><span id="btn_leavetype"><?=$lng['Select Leave type']?></span></button>
			
			<div style="float:left; width:50%; padding:10px 5px 10px 0">
				<button data-toggle="modal" data-target="#startModal" type="button" class="btn btn-info btn-block"><span id="leavestart"><i class="fa fa-calendar"></i><?=$lng['Leave start']?></span></button>
			</div>
			
			<div style="float:right; width:50%; padding:10px 0 10px 5px">
				<button type="button" class="btn btn-info btn-block"><span id="leaveend"><i class="fa fa-calendar"></i><?=$lng['Leave end']?></span></button>
			</div>
			<div class="clear"></div>
		
			<div id="rangeTable" style="xborder:1px red solid">
				<table class="table-bordered text-center" style="background:#fff; table-layout:fixed; margin:0; width:100%">
					<tbody>
						<tr>
							<td style="padding:0">00-00-0000</td>
							<td style="padding:1px">
								<button class="btn btn-info btn-block" type="button"><span class="day1"><?=$lng['Full day']?></span></button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
	
			<div style="border:1px solid #ddd; padding:0px 0 0 10px; margin:10px 0; background:#fff; clear:both">
				<i><?=$lng['Reason']?> / <?=$lng['Note']?></i>
				<textarea style="display:block; border:0; padding:0 10px 5px 0; width:100%; border:0; resize:vertical" rows="3" name="reason"></textarea>
			</div>
	
			<button onclick="$('#certificate').click()" type="button" style="color:#fff; margin-bottom:2px" class="button btn btn-info btn-block"><?=$lng['Attachement']?>&nbsp;:&nbsp;<span style="font-size:13px" id="attachMsg"><?=$lng['No file selected']?></span></button>
			
			<button id="submitBtn" type="submit" class="button btn btn-default btn-block"><i class="fa fa-paper-plane"></i><?=$lng['Submit request']?></button>
			
			<div id="requestMsg" class="bg-yellow-dark" style="font-size:16px; text-align:center; margin:10px 0 0 0; padding:5px 10px; display:none; color:#fff"></div>
			
			<div id="dump"></div>
		
		</form>
		
		
		</div>
		
		<div style="height:10px"></div>
		
		<ul class="nav nav-tabs lined" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" href="#pending" role="tab"><?=$lng['Pending']?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#approved" role="tab"><?=$lng['Approved']?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#history" role="tab"><?=$lng['History']?></a>
			</li>
		</ul>
		<div class="tab-content mt-2">
				<div class="tab-pane fade show active" id="pending" role="tabpanel">
					<? if($pending){ ?>
					<div class="timeline timed">
					<? foreach($pending as $k=>$v){ 
						if($v['days'] == 1){$d = $lng['day'];}else{$d = $lng['days'];}
						?>
							<div class="item">
									<span class="time"><?=substr($v['created'],0,10)?></span>
									<div class="dot <?=$status_color[$v['status']]?>"></div>
									<div class="content">
											<h4 class="title"><?=$leave_types[$v['leave_type']][$lang]?> - <?=$v['days']?> <?=$d?></h4>
											<div class="text"><?=date('D d-m-Y', strtotime($v['start']))?> - <?=date('D d-m-Y', strtotime($v['end']))?></div>
											<div class="text"><?=$lng['Status']?> : <?=$leave_status[$v['status']]?></div>
									</div>
							</div>
					<? } ?>
					</div>
					<? }else{ ?>
							 <div style="padding:0; margin:-10px 0 0; font-size:13px; color:#999"><?=$lng['No data available']?></div>
					<? } ?>
				</div>
				<div class="tab-pane fade" id="approved" role="tabpanel">
					<? if($approved){ ?>
					<div class="timeline timed">
					<? foreach($approved as $k=>$v){ ?>
							<div class="item">
									<span class="time"><?=substr($v['created'],0,10)?></span>
									<div class="dot <?=$status_color[$v['status']]?>"></div>
									<div class="content">
											<h4 class="title"><?=$leave_types[$v['leave_type']][$lang]?> - <?=$v['days']?> days</h4>
											<div class="text"><?=date('D d-m-Y', strtotime($v['start']))?> - <?=date('D d-m-Y', strtotime($v['end']))?></div>
											<div class="text"><?=$lng['Status']?> : <?=$leave_status[$v['status']]?></div>
									</div>
							</div>
					<? } ?>
					</div>
					<? }else{ ?>
							 <div style="padding:0; margin:-10px 0 0; font-size:13px; color:#999; text-align:center"><?=$lng['No data available']?></div>
					<? } ?>
				</div>
				<div class="tab-pane fade" id="history" role="tabpanel">
					<? if($history){ ?>
					<div class="timeline timed">
					<? foreach($history as $k=>$v){ ?>
							<div class="item">
									<span class="time"><?=substr($v['created'],0,10)?></span>
									<div class="dot <?=$status_color[$v['status']]?>"></div>
									<div class="content">
											<h4 class="title"><?=$leave_types[$v['leave_type']][$lang]?> - <?=$v['days']?> days</h4>
											<div class="text"><?=date('D d-m-Y', strtotime($v['start']))?> - <?=date('D d-m-Y', strtotime($v['end']))?></div>
											<div class="text"><?=$lng['Status']?> : <?=$leave_status[$v['status']]?></div>
									</div>
							</div>
					<? } ?>
					</div>
					<? }else{ ?>
							 <div style="padding:0; margin:-10px 0 0; font-size:13px; color:#999; text-align:right"><?=$lng['No data available']?></div>
					<? } ?>
				</div>
		</div>
		
		<div style="height:60px"></div>
								
								
	</div>
	
	
	<!-- Modal -->
	<div class="modal fade" id="leavetypeModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body" style="color:#333">
					<div class="list-group">
						<? foreach($leave_types as $k=>$v){ if($v['emp_request'] == 1){?>
							<a onclick="checkLeaveAvail('<?php echo $k?>');" data-dismiss="modal" class="myList selLeaveType list-group-item" data-id="<?=$k?>"><?=$v[$lang]?></a>
						<? }} ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade my-modal" id="startModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$lng['Leave start']?></h5>
				</div>
				<div class="modal-body" style="color:#333">
					<div class="list-group">
						<div id="startPicker"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Modal -->
	<div class="modal fade my-modal" id="endModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$lng['Leave end']?></h5>
				</div>
				<div class="modal-body" style="color:#333">
					<div class="list-group">
						<div id="endPicker"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Modal -->
	<div class="modal fade" id="dayModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body" style="color:#333">
					<div class="list-group">

						<a data-dismiss="modal" class="myList selDayType list-group-item" data-id="full"><?=$lng['Full day']?></a>
						<a data-dismiss="modal" class="myList selDayType list-group-item" data-id="first"><?=$lng['First half']?></a>
						<a data-dismiss="modal" class="myList selDayType list-group-item" data-id="second"><?=$lng['Second half']?></a>
						<a class="myList list-group-item" style="padding:0 !important; background:#fff !important">
							<table style="width:100%; border-collapse:collapse" border="0">
								<tr>
									<td style="width:50%; padding:5px">
									<input id="time_from" placeholder="<?=$lng['From']?> 00:00" style="font-size:16px; cursor:pointer; background:#fff !important; border:1px solid #ddd; width:100%; padding:5px" class="timePic tac" readonly type="text" />
									</td>
									<td style="width:50%; padding:5px">
									<input id="time_until" disabled placeholder="<?=$lng['Until']?> 00:00" style="font-size:16px; cursor:pointer; background:#fff !important; border:1px solid #ddd; width:100%; padding:5px" class="timePic tac" readonly type="text" />
									</td>
								</tr>
							</table>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	

<script> 


		
	$(document).ready(function() {
		
		function readAttURL(input) {
		  if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					var fileExtension = ['pdf', 'doc', 'docx', 'txt', 'jpg', 'jpeg', 'png'];
					var ext = input.files[0].name.split('.').pop();
					if ($.inArray(ext.toLowerCase(), fileExtension) == -1) {
						alert('Use only '+fileExtension+' files')
						$('#attachMsg').html('<?=$lng['No file selected']?>');
					}else{				
						$('#attachMsg').html(input.files[0].name);
					}
				}
				reader.readAsDataURL(input.files[0]);
		  }
		};
		
		var emp_id = <?=json_encode($_SESSION['rego']['emp_id'])?>;
		var leaveTypes = <?=json_encode($leave_types)?>;
		
		var startDate;
		var endDate;
		
		$('#certificate').on('change', function(){ 
			readAttURL(this);
		});
		$(document).on('submit', '#requestForm', function(e){
			e.preventDefault();
			var err = 0;
			$('#requestMsg').html('').hide();
			if($('input[name="leave_type"]').val() == ''){$('#requestMsg').html('<?=$lng['Select Leave type']?>').fadeIn(400); return false;}
			if($('input[name="date[0]"]').val() == null){$('#requestMsg').html('<?=$lng['Select Start & End date']?>').fadeIn(400); return false;}
			//alert($('input[name="date[0]"]').val())
			$('#submitBtn i').removeClass('fa-paper-plane').addClass('fa-refresh fa-spin');
			//$('#submitBtn').prop('disabled', true);
			var formData = new FormData($(this)[0]);
			//alert(formData);
			$.ajax({
				url: "ajax/save_leave_request.php",
				data: formData,
				type: "POST", 
				cache: false,
				processData:false,
				contentType: false,
				success: function(result){
					//alert(result);

					if(result == 'error'){

						$('#requestMsg').html('<?=$lng['Error']?>: Leave already requested').fadeIn(400);
						setTimeout(function(){
							$('#submitBtn i').removeClass('fa-refresh fa-spin').addClass('fa-paper-plane');
						},500);

					}else{
					//$('#dump').html(result); return false;
						$('#requestMsg').html('<?=$lng['Request send successfully']?>').fadeIn(400);
						setTimeout(function(){
							$('#submitBtn i').removeClass('fa-refresh fa-spin').addClass('fa-paper-plane');
						},500);
					}
					//$('.modalTable').addClass('payslipTable table-bordered table-striped wrapnormal').removeClass('modalTable');
					//$('#showTable').fadeIn(200);

					setTimeout(function(){
						location.reload();
					},2000);
				},
				error:function (xhr, ajaxOptions, thrownError){
					$('#requestMsg').html('<?=$lng['Error']?>: ' + thrownError).fadeIn(400);
					$('#submitBtn').prop('disabled', false);
				}
			});
		})

		$(document).on('click', '.selLeaveType', function(e){
			var id = $(this).data('id');
			//alert(id);
			
			$('#btn_leavetype').html($(this).text());
			$('input[name="leave_type"]').val(id);

			var min_request = leaveTypes[id]['min_request']
			if(min_request == 'half'){

				$('#time_from').attr('disabled',true);
			}else{
				$('#time_from').attr('disabled',false);
			}


		})

		var dayType;
		$(document).on('click', '.dayType', function(e){
			dayType = $(this).data('id');
			$('#dayModal').modal('toggle');
		})
		$(document).on('click', '.selDayType', function(e){
			var id = $(this).data('id');
			$('.day'+dayType).html($(this).text());
			$('#mday'+dayType).val(id);
		})
		$(document).on('change', '#time_until', function(e){
			var hours = $('#time_from').val() + ' - ' + $(this).val();
			$('.day'+dayType).html(hours);
			$('#mday'+dayType).val(hours);
			$('#dayModal').modal('toggle');
		})
		
		
		$('#startPicker').datepicker({
			autoclose: true,
			format: 'D dd-mm-yyyy',
			language: '<?=$lang?>',
			//startDate: new Date(),
			startDate: addDays(),
		}).on('changeDate', function(e){
			startDate = e.format();
			$('#startModal').modal('toggle');
			$('#leavestart').html(e.format());
			$('#enddate').val(e.format());
			$('#endPicker').datepicker('setStartDate', e.format());
			$('#endPicker').datepicker('setDate', e.format());
			//alert(e.format())
		
		});	
		$('#endPicker').datepicker({
			autoclose: true,
			format: 'D dd-mm-yyyy',
			language: '<?=$lang?>',
		}).on('changeDate', function(e){
			endDate = e.format();
			$('#leaveend').html(e.format());
			$('#endModal').modal('toggle');
			$('#enddate').val(e.format());
			$.ajax({
				url: "ajax/get_leave_range.php",
				data: {startDate: startDate, endDate: endDate},
				success: function(result){
					//alert(result);
					$('#rangeTable').html(result); return false;
				},
				error:function (xhr, ajaxOptions, thrownError){
					alert(thrownError);
				}
			});
		
		});
		
		$(document).on('focus',"#time_from", function(){
			$(this).clockpicker({
				autoclose: true,
				placement: 'bottom',
				align: 'left',
				afterDone: function() {
					$('#time_until').prop('disabled', false);
					$('#time_until').focus();
				}
			});
		});			
		$(document).on('focus',"#time_until", function(){
			$(this).clockpicker({
				autoclose: true,
				placement: 'bottom',
				align: 'right',
				afterDone: function() {
					$('#time_until').trigger("change");
				}
			});
		});			

		function addDays() {

		  //var days = '<?php echo $getLeaveReqBefore;?>';
		  var days = 2;
		  //alert(getLeaveReqBefore);
		  var result = new Date();
		  result.setDate(result.getDate() + days);
		  return result;
		}
	})

	function checkLeaveAvail(leave_type)
	{
		// check leave space if avaialble then allow other wise set to select option default 

		var emp_id = '<?php echo $emp_id_value ?>';


		$.ajax({
			url: "ajax/get_leave_balance_mob.php",
			data: {emp_id: emp_id},
			success: function(result){

				var data = JSON.parse(result);

				 $.each(data, function(index, value) {


						if(leave_type == index)
						{

							var balance = value.maxdays -value.used - value.pending ;

							if(balance > 0)
							{
								// accept leave
								$('#submitBtn').prop("disabled", false);
								$('#requestMsg').html('');
								$('#requestMsg').fadeOut();
							}
							else
							{
								$('#submitBtn').prop("disabled", true);
								// give error popup 
								$('#requestMsg').html('Leave balance not sufficient').fadeIn(400);
								setTimeout(function(){
									$('#submitBtn i').removeClass('fa-refresh fa-spin').addClass('fa-paper-plane');
								},500);

							}
							
						}


				 });


			},
			error:function (xhr, ajaxOptions, thrownError){
				alert('<?=$lng['Error']?> ' + thrownError);
			}
		});
	}
			
	</script>







