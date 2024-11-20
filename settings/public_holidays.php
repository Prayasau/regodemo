<?	
	$getDefaultSysSettings = getDefaultSysSettings();
	
	$checked_days = '';
	$input_hours = '';
	$time = 0;
	if($getDefaultSysSettings['checked_days'] !=''){
		$checked_days = unserialize($getDefaultSysSettings['checked_days']);
		$myArray = array(1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7);

		$arrayDiff = array_diff($myArray,$checked_days);
		$newWeekDays = array();
		foreach ($arrayDiff as $value) {
			if($value == 7){$value = 0;}
			$newWeekDays[$value] = $value;
		}
		sort($newWeekDays);
		//$weekDays = '['.implode(',', $newWeekDays).']';
		$weekDays = $newWeekDays;
	}
	if($getDefaultSysSettings['input_hours'] !=''){
		$input_hours = unserialize($getDefaultSysSettings['input_hours']);
		foreach ($input_hours as $time_val) {
			if($time_val !=''){
				$time +=explode_time($time_val); //this fucntion will convert all hh:mm to seconds
			}
		}
	}

	$totalHrsTime = second_to_hhmm($time);

	
	for($i=(date('Y')-1); $i <= (date('Y')+1); $i++){
		$years[$i] = $i;
	}

	$sql = "SELECT * FROM ".$cid."_holidays WHERE year = '".$_SESSION['rego']['cur_year']."'";
	if($res = $dbc->query($sql))
	{
		if($res->num_rows > 0){
			$import_txt = $lng['Default settings'];
		}else{
			$import_txt = $lng['Fetch default public holidays'];
		}
	}
?>
	<style type="text/css">
		table.basicTable.inputs input.inptbkg{
			background-color: #f9f7dd !important;
		}
	</style>
	<h2><i class="fa fa-calendar"></i>&nbsp;&nbsp;<?=$lng['Working Calendar']?> 
		<span style="display:none; font-style:italic; color:#b00; padding-left:30px" id="sAlert"><i class="fa fa-exclamation-triangle fa-mr"></i><?=$lng['Data is not updated to last changes made']?></span>
	</h2>

	<form id="workingCalendar">	
		<div class="main">
			<div style="padding:0 0 0 20px" id="dump"></div>

			<ul class="nav nav-tabs" id="myTab">
				<li class="nav-item"><a class="nav-link" href="#tab_general" data-toggle="tab"><?=$lng['General']?></a></li>
				<li class="nav-item"><a class="nav-link active" href="#tab_publicHolidays" data-toggle="tab"><?=$lng['Public holidays']?></a></li>
				<li class="nav-item"><a class="nav-link" href="#tab_calendar" data-toggle="tab"><?=$lng['Calendar']?></a></li>
			</ul>

			<div class="tab-content" style="height:calc(100% - 40px)">

				<div class="tab-pane" id="tab_general">

					<div style="position:absolute; top:3px; right:0px">
						<button class="btn btn-primary" id="submitBtn" type="submit"><i class="fa fa-save"></i>&nbsp;&nbsp;<?=$lng['Update']?></button>
					</div>

					<table class="basicTable inputs" border="0">
						<thead>
							<tr>
								<th colspan="2">General defaults</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><?=$lng['Work Days per week']?></th>
								<td>
									<select name="work_days_per_week" style="width: 100%;">
										<? foreach ($work_days_per_week as $key => $value) {
											$wdpw='';
											if($getDefaultSysSettings['work_days_per_week'] == $key){$wdpw='selected';}
											echo '<option value="'.$key.'" '.$wdpw.'>'.$value.'</option>';
										} ?>
									</select>
								</td>
							</tr>
						</tbody>
					</table>
					<table class="basicTable inputs" border="0">
						<thead>
							<tr>
								<th></th>
								<? foreach ($weekdays as $key => $value) {
									echo '<th class="tal">'.$value.'</th>';
								} ?>
							</tr>
						</thead>
						<tbody>
							<tr id="checkboxRow">
								<th><?=$lng['Work Days']?></th>
								<? foreach ($weekdays as $key => $value) {
									$chkdy=''; 
									if(isset($checked_days[$key])){$chkdy='checked';}
									echo '<td class="tal"><input type="checkbox" onclick="chkweekdays(this,'.$key.')" class="checkbox-custom-blue" name="checked_days['.$key.']" value="'.$key.'" '.$chkdy.'></td>';
								} ?>
							</tr>
							<tr id="calchrs">
								<th><?=$lng['Hours per day']?></th>
								<? foreach ($weekdays as $key => $value) {
									$inpthr='';$addclass='';$readonly='readonly';
									if($input_hours[$key] !=''){$inpthr=$input_hours[$key];$addclass='inptbkg';$readonly='';}
									echo '<td><input type="text" onchange="calculateHrs(this);" class="hourFormat2  '.$addclass.'" name="input_hours['.$key.']" id="'.$key.'" value="'.$inpthr.'" '.$readonly.'></td>';
								} ?>
							</tr>
							<tr>
								<th><?=$lng['Total hrs worked']?></th>
								<td><input type="text" id="totalHrsss" name="totalHrs" value="<?=$totalHrsTime?>" readonly></td>
								<td colspan="6"></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="tab-pane active" id="tab_publicHolidays">

					<div id="showTable" class="holidays-list" style="display:none">
				
						<select class="button" id="selYear">
							<? foreach($years as $v){
									echo '<option ';
									if($_SESSION['rego']['cur_year'] == $v){echo 'selected';}
									echo ' value="'.$v.'">'.$lng['Holidays'].' '.$v.'</option>';
								} ?>
						</select>
						<button id="getHolidays" class="btn btn-primary" type="button"><i class="fa fa-download"></i>&nbsp; <?=$import_txt?></button>
						<button id="addHoliday" class="btn btn-primary" type="button"><i class="fa fa-plus"></i>&nbsp; <?=$lng['Add holiday']?></button>
						<div style="clear:both"></div>

						<table id="holidayTable" class="dataTable inputs xnowrap" border="0">
							<thead>
								<tr>
									
									<th data-sortable="false"><?=$lng['Apply']?></th>
									<th style="width:130px;" class="tal"><?=$lng['Date']?></th>
									<th data-sortable="false" style="width:130px"><?=$lng['Company date']?></th>
									<th data-sortable="false"><?=$lng['Thai']?></th>
									<th data-sortable="false"><?=$lng['English']?></th>
									<th data-sortable="false"><i class="fa fa-edit fa-lg"></i></th>
									<th data-sortable="false"><i class="fa fa-trash fa-lg"></i></th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>

				</div>

				<div class="tab-pane" id="tab_calendar">
					<div style="position:absolute; top:16px; right:15px">
						<button class="btn btn-primary" id="addWoorkingDaystoPeriods" type="button"><?=$lng['Add working days to Periods']?></button>
					</div>
					<? include 'company_default_calendar.php'; ?>
				</div>
			</div>
		</div>
	</form>
	
	<!-- Modal ADD HOLIDAY -->
	<div class="modal fade" id="modalHoliday" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fa fa-plus"></i>&nbsp; <?=$lng['Add holiday']?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form class="sform" id="holiForm">
						<input name="id" type="hidden" value="0" />
						<label><?=$lng['Date']?><i class="man"></i></label>
						<input readonly class="holiday_date_month nofocus" style="cursor:pointer" name="date" type="text" />
						<label><?=$lng['Company date']?><i class="man"></i></label>
						<input readonly class="holiday_date_month nofocus" style="cursor:pointer" name="cdate" type="text" />
						<label><?=$lng['Thai']?><i class="man"></i></label>
						<input name="th" type="text" />
						<label><?=$lng['English']?><i class="man"></i></label>
						<input name="en" type="text" />
						<div style="height:10px"></div>
						<button class="btn btn-primary btn-fr" type="button" data-dismiss="modal"><i class="fa fa-times fa-mr"></i><?=$lng['Cancel']?></button>
						<button class="btn btn-primary btn-fr" type="submit"><i class="fa fa-save fa-mr"></i><?=$lng['Update']?></button>
					</form>
				</div>
			</div>
		</div>
	</div>
	
<script>

	function setCheckboxvalueNew(that){
		var apply;
		if($(that).is(':checked')){
			$(that).val(1);
			apply = 1;
		}else{
			$(that).val(0);
			apply = 0;
		}

		var getid = $(that).closest("tr").children("td").children("a").attr("data-id");

		$.ajax({
				url: "ajax/company_on_off_holidays.php",
				data: {getid: getid, apply: apply},
				success: function(data){
					location.reload();
				}
		})
	}

	function chkweekdays(that,id){

		var work_days_per_week = $('select[name="work_days_per_week"]').val();

		$('tr#checkboxRow input[type=checkbox]').change(function(e){
		    if ($('tr#checkboxRow input[type=checkbox]:checked').length > work_days_per_week) {
		        $(this).prop('checked', false);
		        $("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: allowed only '+work_days_per_week+' days',
					duration: 1,
					callback: function(v){
						window.location.reload();
					}
				})
		        return false;
		    }else{

		    	if($(that).is(':checked')){
					$('#'+id).attr('readonly',false).addClass('inptbkg');
				}else{
					$('#'+id).val('').attr('readonly',true).removeClass('inptbkg');
				}
		    }
		})

		
	}

	/*function time_convert(num)
	{ 
		var hours = Math.floor(num / 60);  alert(hours);
		var minutes = num % 60;

		if (hours < 10) {hours = "00"+hours;}
    	if (minutes < 10) {minutes = "0"+minutes;}
	  	return hours + ":" + minutes;         
	}

	let getDifference = (time1, time2) => {
	  	let [h1, m1] = time1.split(':')
	  	let [h2, m2] = time2.split(':')
	  	var aa = ((+h1 + (+m1 / 60)) + (+h2 + (+m2 / 60)));
	  	alert(aa);
	  	return time_convert(aa);
	}*/

	/*function calculateHrs(that){
		var totalHrs = $('input[name="totalHrs"]').val();
		var totalVal = getTimeInterval(totalHrs, that.value);
		$('input[name="totalHrs"]').val(totalVal);
	}

	function getTimeInterval(f1, u1){

		var a1 = moment.utc(f1, "HH:mm");
		var b1 = moment.utc(u1, "HH:mm");

		var t1 = moment.utc(+a1).format('HH:mm');
		var t2 = moment.utc(+b1).format('HH:mm');

		var hrs = moment.utc(t1, "HH:mm").add(moment.duration(t2));
		var hrs = moment.utc(+hrs).format('HH:mm');

		return hrs;
	}*/


	/*Number.prototype.padDigit = function () {
        return (this < 10) ? '0' + this : this;
    }

 	$("#calchrs input").on('changes', function () {
      var t1 = $('#totalHrsss').val();
      var mins = 0;
      var hrs = 0;
        $('#calchrs input').each(function () {
            t1 = t1.split(':');
            var t2 = $(this).val().split(':');
            //console.log(Number(t1[1]) + Number(t2[1]))
            mins = Number(t1[1]) + Number(t2[1]);
            minhrs = Math.floor(parseInt(mins / 60));
            hrs = Number(t1[0]) + Number(t2[0]) + minhrs;
            mins = mins % 60;
            t1 = hrs.padDigit() + ':' + mins.padDigit()
            //console.log(t1)
        });
        $('#totalHrsss').val(t1);
    });*/


	var headerCount = 1;
	$(document).ready(function() {
		
		var dtable = $('#holidayTable').DataTable({
			//scrollX:       'auto',
			scrollY:       false,
			scrollCollapse:false,
			fixedColumns:  false,
			lengthChange:  false,
			searching: 		false,
			ordering: 		true,
			paging: 			true,
			pageLength: 	16,
			filter: 			false,
			info: 			false,
			//autoWidth:		true,
			<?=$dtable_lang?>
			processing: 	false,
			serverSide: 	true,
			order: [[1, 'asc']],
			ajax: {
				url: "ajax/server_get_holidays.php",
				data: function(d){
					d.year = $('#selYear').val();
				}
			},
			columnDefs: [
				{ targets: [5,6], class: 'tac',},
				{ targets: [0,5,6], "width": '1px',},
			],	
			initComplete : function( settings, json ) {
				$('#showTable').fadeIn(400)
				dtable.columns.adjust().draw()
			}
		});
		
		$('#selYear').on('change', function(){
			dtable.ajax.reload(null, false);
		})
		
		$('#addHoliday').on('click', function(){
			$('input[name="id"]').val(0)
			$('#modal-title').html('<?=$lng['Add holiday']?>')
			$('#modalHoliday').modal('toggle')
		})
		
		$(document).on('click', '.editHoliday', function(){
			var id = $(this).data('id');
			$.ajax({
				url: "ajax/get_holiday.php",
				data: {id: id},
				dataType: 'json',
				success: function(data){
					//$("#dump").html(data);
					$('#modal-title').html('<?=$lng['Edit holiday']?>')
					$('input[name="id"]').val(data.id)
					$('input[name="date"]').val(data.date)
					$('input[name="cdate"]').val(data.cdate)
					$('input[name="th"]').val(data.th)
					$('input[name="en"]').val(data.en)
					
					$('#modalHoliday').modal('toggle')
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("#message").html('<div class="msg_error nomargin"><?=$lng['Sorry but someting went wrong']?> Error : ' + thrownError + '</div>').fadeIn(200);
					setTimeout(function(){$("#message").fadeOut(200);},4000);
				}
			});
		})
		
		$('#modalHoliday').on('hidden.bs.modal', function () {
			$("#holiForm").trigger('reset');
			$("#modMessage").hide()
		});

		$("#holiForm").submit(function(e){ 
			e.preventDefault();
			$("#modMessage").hide()
			if($('input[name="date"]').val()=='' || $('input[name="cdate"]').val()=='' || $('input[name="th"]').val()=='' || $('input[name="en"]').val()==''){
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Please fill in all the fields']?>',
					duration: 2,
				})
				return false;
			}
			var data = $(this).serialize();
			$.ajax({
				url: "ajax/update_holidays.php",
				data: data,
				success: function(result){
					if(result == 'success'){
						$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfuly']?>',
							duration: 2,
						})
						dtable.ajax.reload(null, false);
						setTimeout(function(){$('#modalHoliday').modal('toggle');},300);
					}else{
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+result,
							duration: 4,
							//closeConfirm: true
						})
					}
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 8,
						closeConfirm: "true",
					})
				}
			});
		});
		
		$(document).ajaxComplete(function( event,request, settings ) {
			$('.delHoliday').confirmation({
				container: 'body',
				rootSelector: '.delHoliday',
				singleton: true,
				animated: 'fade',
				placement: 'left',
				popout: true,
				html: true,
				title: '<?=$lng['Are you sure']?>',
				btnOkClass: 'btn btn-danger',
				btnOkLabel: '<?=$lng['Delete']?>',
				btnOkIconContent: '',
				btnCancelClass: 'btn btn-success',
				btnCancelLabel: '<?=$lng['Cancel']?>',
				onConfirm: function() {
					$.ajax({
						url: "ajax/delete_holiday.php",
						data: {id: $(this).data('id')},
						success: function(result){
							//$('#dump').html(result);
							dtable.ajax.reload(null, false);
						},
						error:function (xhr, ajaxOptions, thrownError){
							$("body").overhang({
								type: "error",
								message: '<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
								duration: 4,
								//closeConfirm: "true",
							})
						}
					});
				}
			});
		});
		
		$('.holiday_date_month').datepicker({
			format: "D dd-mm-yyyy",
			autoclose: true,
			inline: true,
			language: '<?=$lang?>-en',//lang+'-th',
			//viewMode: 'years',
			startView: 'year',
			todayHighlight: true,
			//startDate : startYear,
			//endDate   : endYear
		})


		$("#workingCalendar").submit(function(e){ 
			e.preventDefault();
			$("#submitBtn i").removeClass('fa-save').addClass('fa-refresh fa-spin');
			var formData = $(this).serialize();

			$.ajax({
				url: "ajax/update_working_calendar.php",
				type: 'POST',
				data: formData,
				success: function(result){

					if(result == 'success'){
						$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
							duration: 2,
							callback: function(v){
								window.location.reload();
							}
						})
						//$('#addWoorkingDaystoPeriods')..addClass('flash');
					}else{
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+result,
							duration: 4,
							callback: function(v){
								window.location.reload();
							}
						})
					}
				}
			})
		})


		$('#getHolidays').on('click', function(){

			var selYear = $('#selYear').val();
			// RUN AJAX AND FETCH HOLIDAYS FROM ADMIN

			$("body").overhang({
				type: "warn",
				message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp; One moment please importing holidays &nbsp;&nbsp;<i class="fa fa-refresh fa-spin"></i>',
				closeConfirm: "true",
				//duration: 10,
			})
			$('#impemp i').removeClass('fa-download').addClass('fa-refresh fa-spin');
			//return false;

			setTimeout(function(){
				$.ajax({
					url: "ajax/import_public_holidays_from_admin.php",
					type: 'POST',
					selYear:selYear,
					async: false,
					cache: false,
					contentType: false,
					processData: false,
					success: function(result){

													//$("#dump").html(result); return false;
						//alert(result)
						setTimeout(function(){
							$(".overhang").slideUp(200); 
							$('#impemp i').removeClass('fa-refresh fa-spin').addClass('fa-download');
						}, 800);
						setTimeout(function(){
							if($.trim(result) == 'success'){
								$("body").overhang({
									type: "success",
									message: '<i class="fa fa-check"></i>&nbsp;&nbsp;Data imported successfuly. Please wait for page reload . . .',
									duration: 1,
								})
								setTimeout(function(){location.reload();}, 1000);
							}else{
								$("body").overhang({
									type: "warn",
									message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;'+result,
									closeConfirm: "true",
									duration: 5,
								})
							}
						}, 1000);
	


					},
	
				});
			},300);
		})

		dtable.columns.adjust().draw();
		var activeTabPay = localStorage.getItem('activeTabPaywc');
		if(activeTabPay){
			$('.nav-link[href="' + activeTabPay + '"]').tab('show');
		}else{
			$('.nav-link[href="#tab_publicHolidays"]').tab('show');
		}
		$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
			dtable.columns.adjust().draw();
			localStorage.setItem('activeTabPaywc', $(e.target).attr('href'));
		});


	});

</script>	













