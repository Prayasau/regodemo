<?
	$def_positions = unserialize($Def_settings['positions']);
	$positions_arr = $def_positions[$lang];

	$WorkingHours  = unserialize($Def_leaveTime_settings['working_hours']);
	

	$occurence = array('shift'=>'Per shift', 'hour'=>'Per hour', 'month'=>'Per month', 'event'=>'Per event');

	$data = array();
	if($res = $dba->query("SELECT * FROM rego_rewards_penalties")){
		while($row = $res->fetch_assoc()){
			$data[$row['id']] = $row;
		}
	}
	//var_dump($data); exit;
	
	$linkto = array();
	$linktoCom = array();
	$linktoDed = array();
	if($res = $dba->query("SELECT * FROM rego_allow_deduct WHERE apply = 1 ORDER BY classification ASC")){
		while($row = $res->fetch_assoc()){
			if($row['groups'] == 'inc_var'){
				$linkto[$row['id']] = 'Var income - '.$row[$lang];
				$linktoCom[$row['id']] = 'Var income - '.$row[$lang];
			}
			if($row['groups'] == 'ded_var'){
				$linkto[$row['id']] = 'Var deduction - '.$row[$lang];
				$linktoDed[$row['id']] = 'Var deduction - '.$row[$lang];
			}
			
		}
	}
	//var_dump($linkto); exit;
	
	$data_income = array();
	if($res = $dba->query("SELECT * FROM rego_allow_deduct WHERE apply = 1 AND comp_reduct = 1")){
		while($row = $res->fetch_assoc()){
			$data_income[$row['id']] = $row[$lang];
		}
	}


	

	// echo '<pre>';
	// print_r($WorkingHours);
	// echo '</pre>';
	//exit;

?>
<style>
	.basicTable tbody th {
		xwidth:1%;
		white-space:nowrap;
	}
	.basicTable tbody td input.level {
		border-bottom:1px solid #eee !important;
		width:100% !important;
		display:block !important;
		padding:4px 10px !important;
	}
	.basicTable tbody td.disrate input,
	.basicTable tbody td.disrate select {
		color:#ccc;
		xvisibility:hidden;
	}
	table.dataTable tbody td input:read-only {
		color:#aaa;
	}
	.basicTable tbody td input.readonly {
		color:#aaa;
	}
	table.dataTable tbody td {
		padding:4px 10px !important;
	}
	table.dataTable tbody td select {
		background:transparent !important;
		width:auto !important; 
		min-width:100% !important;
	}
	table.dataTable thead th.w40 {
		width:40px;
		min-width:40px
	}
	table.dataTable tbody td.w60 {
		width:60px;
		min-width:60px
	}

	.SumoSelect {
	    width: 100% !important;
	    border: 1px solid #fff !important;
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
</style>
	
	<h2><i class="fa fa-cog fa-lg"></i>&nbsp;&nbsp;<?=$lng['Rewards & Penalties']?> <span style="float:right; display:none; font-style:italic; color:#b00" id="sAlert"><?=$lng['Data is not updated to last changes made']?></span></h2>
	<div class="main">
		
		<div id="showTable" style="display:xnone; margin-bottom:50px">
			<table border="0" style="width:100%; margin-bottom:8px">
				<tr>
					<td style="width:100%"></td>
					<td style="vertical-align:top; padding-left:10px">
						<button class="btn btn-primary" onclick="window.history.go(-1); return false;" type="button"><?=$lng['Go back']?></button>
					</td>
					<? //if($_SESSION['RGadmin']['access']['def_settings']['add'] == 1){ ?>
					<td style="vertical-align:top; padding-left:10px">
						<button id="addItem" class="btn btn-primary" type="button"><i class="fa fa-plus"></i>&nbsp; <?=$lng['Add Item']?></button>
					</td>
					<? //} ?>
				</tr>
			</table>
			
			<table id="compensationTable" class="dataTable nowrap hoverable selectable" border="0">
				<thead>
					<tr>
						<th class="tac"><?=$lng['Apply']?></th>
						<th class="w40"><?=$lng['Code']?></th>
						<th class="tac" style="width:1%"><i class="fa fa-edit fa-lg"></i></th>
						<th style="width:10%"><?=$lng['Thai description']?></th>
						<th style="width:10%"><?=$lng['English description']?></th>
						<th><?=$lng['Type']?></th>
						<th><?=$lng['Occurence']?></th>
						<th><?=$lng['Link to']?></th>
						<th><?=$lng['Levels']?></th>
						<th colspan="5" class="tac"><?=$lng['Amount THB per level (1- 5)']?></th>
					</tr>
				</thead>
				<tbody>
					<? foreach($data as $key=>$val){ ?>
					<tr>
						<td class="tac vam" style="vertical-align:middle; width:1px">
							<!--<input name="apply" type="hidden" value="0" />-->
							<label><input <? if($val['apply'] == 1){echo 'checked';} ?> data-id="<?=$val['id']?>" type="checkbox" class="checkbox notxt applyItem" /></label>
						</td>
						<td><?=$val['code']?></td>
						<td><a class="editItem" data-id="<?=$val['id']?>"><i class="fa fa-edit fa-lg"></i></a></td>
						<td><?=$val['th']?></td>
						<td><?=$val['en']?></td>
						<td><?=$val['type']?></td>
						<td><? if(!empty($val['occurence'])){echo $occurence[$val['occurence']];}?></td>
						<td><? if(!empty($val['link'])){echo $linkto[$val['link']];}?></td>
						<td><?=$val['levels']?> <? if($val['levels'] > 1){echo ' levels';}else{echo ' level';} ?></td>
						<td class="w60 tac"><?=$val['level1']?></td>
						<td class="w60 tac"><?=$val['level2']?></td>
						<td class="w60 tac"><?=$val['level3']?></td>
						<td class="w60 tac"><?=$val['level4']?></td>
						<td class="w60 tac"><?=$val['level5']?></td>
					</tr>
					<? } ?>
				</tbody>
			</table>
			
			<div id="dump"></div>
			
		</div>

	</div>
	
	
	
	
	<!-- Modal ADD ITEM -->
	<div class="modal fade" id="modalItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		 <div class="modal-dialog" style="min-width:1000px">
			  <div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel"><?=$lng['Rewards & Penalties']?><? //=$lng['xxx']?></h4>
					</div>
					<div class="modal-body" style="padding:20px">
						
						<form id="dataForm">
						<table style="table-layout:fixed; width:100%" border="0">
							<tr>
								<td style="padding:0 5px 0 0">
								
									<table class="basicTable compact inputs" style="width:100%; border:1px solid #eee; margin-bottom:10px">
										<thead>
											<tr>
												<th colspan="2"><?=$lng['ITEM DESCRIPTION']?></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th class="tal"><?=$lng['Item Code']?></th>
												<td>
													<input name="id" type="hidden" value="" />
													<input placeholder="__" maxlength="4" name="code" type="text" value="" />
												</td>
											</tr>
											<tr>
												<th class="tal"><?=$lng['Description Thai']?></th>
												<td>
													<input placeholder="__" name="th" type="text" value="" />
												</td>
											</tr>
											<tr>
												<th class="tal"><?=$lng['Description English']?></th>
												<td>
													<input placeholder="__" name="en" type="text" value="" />
												</td>
											</tr>
										</tbody>
									</table>
								
									<table class="basicTable compact inputs" style="width:100%; border:1px solid #eee; margin-bottom:4px">
										<thead>
											<tr>
												<th colspan="2"><?=$lng['RATE CONDITIONS']?></th>
											</tr>
										</thead>
										<tbody>
											<tr style="border-bottom:0 !important">
												<th class="tal" style="width:35%; height:135px">
													<label><input name="rate" type="radio" value="fixed" class="checkbox" /> <?=$lng['Fixed rate']?></label>
												</th>
												<td>
													<table id="fixedRate" style="display:none; width:100%">
														<tr style="border-bottom:0 !important">
															<td class="vat">
																<select class="cLevel" name="levels" style="width:auto; min-width:100%">
																	<option class="clevel" value="1">1 <?=$lng['Level']?></option>
																	<option class="clevel" value="2">2 <?=$lng['Levels']?></option>
																	<option class="clevel" value="3">3 <?=$lng['Levels']?></option>
																	<option class="clevel" value="4">4 <?=$lng['Levels']?></option>
																	<option class="clevel" value="5">5 <?=$lng['Levels']?></option>
																</select>
															</td>
															<td class="vat">
																<input readonly class="level tac" type="text" value="Level 1" />
																<input readonly class="readonly level tac lev2" type="text" value="Level 2" />
																<input readonly class="readonly level tac lev3" type="text" value="Level 3" />
																<input readonly class="readonly level tac lev4" type="text" value="Level 4" />
																<input readonly class="readonly level tac lev5" type="text" value="Level 5" style="border-bottom:0 ! important" />
															</td>
															<td>
																<input class="sel numeric tac level" name="level1" type="text" value="0" />
																<input readonly class="readonly numeric tac level level2" name="level2" type="text" value="0" />
																<input readonly class="readonly numeric tac level level3" name="level3" type="text" value="0" />
																<input readonly class="readonly numeric tac level level4" name="level4" type="text" value="0" />
																<input readonly class="readonly numeric tac level level5" name="level5" type="text" value="0" style="border-bottom:0 ! important" />
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
										
									<table class="basicTable compact inputs" style="width:100%; border:1px solid #eee; margin-bottom:4px">
										<tbody>
											<tr style="border-bottom:0 !important">
												<th class="tal" style="height:82px">
													<label><input name="rate" type="radio" value="day" class="checkbox" /> <?=$lng['Day rate']?></label>
												</th>
												<td>
													<table id="dayRate" style="display:none; width:100%">
														<tr style="border-bottom:0 !important">
															<td class="vat">
																<input readonly style="padding-top:4px ! important" class="level tar" type="text" value="Sum income" />
																<input readonly class="level tar" type="text" value="Divided by Days" />
																<input readonly style="border-bottom:0 ! important" class="level tar" type="text" value="Multiplied by" />
															</td>
															<td class="vat" style="width:60px !important" >
																<input readonly class="level" type="text" style="padding-top:4px ! important" />
																<input name="day_rate_days" class="sel numeric level tac" type="text" value="0" />
																<input name="day_rate_multiplier" style="border-bottom:0 ! important" class="sel numeric level tac" type="text" value="0" />
															</td>
															<td class="vat">
																<select name="day_rate_income" style="width:auto; min-width:100%">
																	<option value=""><?=$lng['Select'].' '.$lng['Income']?> </option>
																	<? foreach($data_income as $k=>$v){ ?>
																	<option value="<?=$k?>"><?=$v?></option>
																	<? } ?>
																</select>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
										
									<table class="basicTable compact inputs" style="width:100%; border:1px solid #eee; border-bottom:0">
										<tbody>
											<tr>
												<th class="tal" style="xwidth:35%; height:108px">
													<label><input name="rate" type="radio" value="hour" class="checkbox" /> <?=$lng['Hour rate']?></label>
												</th>
												<td>
													<table id="hourRate" style="display:none; width:100%">
														<tr style="border-bottom:0 !important">
															<td class="vat" style="border-bottom:0 !important">
																<input readonly class="level tar" type="text" value="Sum income" />
																<input readonly class="level tar" type="text" value="Divided by Days" />
																<input readonly class="level tar" type="text" value="Divided by Hours" />
																<input readonly class="level tar" type="text" style="border-bottom:0 ! important" value="Multiplied by" />
															</td>
															<td class="vat" style="width:60px !important" >
																<input readonly class="level" type="text" />
																<input name="hour_rate_days" class="sel numeric level tac" type="text" value="0" />
																<input name="hour_rate_hours" class="sel numeric level tac" type="text" value="0" />
																<input name="hour_rate_multiplier" style="border-bottom:0 ! important" class="sel numeric level tac" type="text" value="0" />
															</td>
															<td class="vat">
																<select name="hour_rate_income" style="width:auto; min-width:100%">
																	<option value=""><?=$lng['Select'].' '.$lng['Income']?></option>
																	<? foreach($data_income as $k=>$v){ ?>
																	<option value="<?=$k?>"><?=$v?></option>
																	<? } ?>
																</select>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</tbody>
									</table>

								</td>
								<td class="vat" style="padding:0 0 0 5px">

									<table class="basicTable compact inputs" style="table-layout:fixed; width:100%; border:1px solid #eee; margin-bottom:10px">
										<thead>
											<tr>
												<th colspan="2"><?=$lng['ITEM TYPE']?></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th class="tal"><?=$lng['Type']?></th>
												<td>
													<select name="type" style="width:100%" onchange="GetTheLinkval(this.value);">
														<option value=""><?=$lng['Select']?></option>
														<option value="compensation"><?=$lng['Compensations']?></option>
														<option value="deduction"><?=$lng['Deduction']?></option>
													</select>
												</td>
											</tr>
											<tr id="linkValues">
												<th class="tal"><?=$lng['Link to']?></th>
												
											</tr>
											<tr>
												<th class="tal"><?=$lng['Occurence']?></th>
												<td>
													<select name="occurence" style="min-width:auto; width:100%; background:transparent">
														<option value=""><?=$lng['Select']?></option>
														<? foreach($occurence as $k=>$v){ ?>
														<option value="<?=$k?>"><?=$v?></option>
														<? } ?>
													</select>
												</td>
											</tr>
										</tbody>
									</table>
								
									<table class="basicTable compact inputs" style="table-layout:fixed; width:100%; border:1px solid #eee;">
										<thead>
											<tr>
												<th colspan="2"><?=$lng['EMPLOYEE ALLOCATION']?></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th colspan="2" class="tal vat">
													<input name="allocation_employee" type="hidden" value="0" />
													<label><input name="allocation_employee" type="checkbox" value="1" class="checkbox" /> <?=$lng['Per employee']?></label>
												</th>
											</tr>
											<tr>
												<th class="tal">
													<input name="allocation_position" type="hidden" value="0" />
													<label><input name="allocation_position" type="checkbox" value="1" class="checkbox" /> <?=$lng['Per position']?></label>
												</th>
												<td>
													<select id="positionSelect" multiple="multiple" name="all_position" style="min-width:auto; width:100%; background:transparent">
														<? foreach($positions_arr as $k => $v){ ?>
															<option value="<?=$k;?>"><?=$v;?></option>
														<? } ?>
													</select>
												</td>
											</tr>

											<tr>
												<th class="tal">
													<input name="allocation_shedule" type="hidden" value="0" />
													<label><input name="allocation_shedule" type="checkbox" value="1" class="checkbox" /> <?=$lng['Per HR schedule']?></label>
												</th>
												<td>
													<select id="sheduleSelect" multiple="multiple" name="all_shedule" style="min-width:auto; width:100%; background:transparent">
														<? foreach($WorkingHours as $k => $v){ ?>
															<option value="<?=$k?>"><?=$v['name']?></option>
														<? } ?>
													</select>
												</td>
											</tr>
										</tbody>
									</table>
								
								</td>
							</tr>
						</table>
						
						<div style="height:10px"></div>
						<button id="submitBtn" class="btn btn-primary" type="submit"><i class="fa fa-save"></i>&nbsp;&nbsp;<?=$lng['Update']?></button>
						<button data-dismiss="modal" style="float:right" class="btn btn-primary" type="button"><i class="fa fa-times"></i>&nbsp;&nbsp;<?=$lng['Cancel']?></button>
						</form>
					
					</div>
			  </div>
		 </div>
	</div>


<script>

	

	function GetTheLinkval(that){

		if(that !=''){
			$('#modalItem tr#linkValues td').remove();
			if(that == 'compensation'){

				var row = '<td><select name="link" style="min-width:auto; width:100%; background:transparent"><option value="">Select</option><? foreach($linktoCom as $k=>$v){ ?><option value="<?=$k?>"><?=$v?></option><? } ?></select></td>';

			}else if(that == 'deduction'){

				var row = '<td><select name="link" style="min-width:auto; width:100%; background:transparent"><option value="">Select</option><? foreach($linktoDed as $k=>$v){ ?><option value="<?=$k?>"><?=$v?></option><? } ?></select></td>';
			}	

			$('#modalItem tr#linkValues').append(row);	
		}else{
			$('#modalItem tr#linkValues td').remove();
		}
	}

	$(document).ready(function() {


		$('#positionSelect').SumoSelect({
			placeholder: '<?=$lng['Select'].' '.$lng['Positions']?>',
			captionFormat: '<?=$lng['Positions']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All'].' '.$lng['Positions']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});

		$('#sheduleSelect').SumoSelect({
			placeholder: '<?=$lng['Select'].' '.$lng['Schedules']?>',
			captionFormat: '<?=$lng['Schedules']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All'].' '.$lng['Schedules']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});
	
		function setLevels(s){
			for(i=2;i<=s;i++){
				$('.level'+i).prop('readonly', false).addClass('sel').removeClass('readonly');
				$('.lev'+i).removeClass('readonly');
			}
			for(i=s+1;i<=5;i++){
				$('.level'+i).prop('readonly', true).val(0).removeClass('sel').addClass('readonly');
				$('.lev'+i).addClass('readonly');
			}
		}
		
		$(document).on('change', 'input[name="rate"]', function () {
			$('#fixedRate').hide();
			$('#dayRate').hide();
			$('#hourRate').hide();
			$('#'+this.value+'Rate').show();
		});
		
		$(document).on('change', '.cLevel', function () {
			var s = parseInt(this.value);
			setLevels(s);
		});
		
		$(".applyItem").click(function(){
			var id = $(this).data('id');
			var checked = $(this).prop('checked');
			$.ajax({
				url: "def_settings/ajax/def/apply_compensation.php",
				type: 'POST', 
				data: {id: id, checked: checked},
				success: function(result){
					//$('#dump').html(result); return false;
					if(result == 'success'){
						$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp;Data updated successfuly',
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
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		})
		
		$("#addItem").click(function(){

			$('#positionSelect')[0].sumo.unSelectAll();
			$('#sheduleSelect')[0].sumo.unSelectAll();
			$('#positionSelect')[0].sumo.reload();
			$('#sheduleSelect')[0].sumo.reload();

			$('#modalItem tr#linkValues td').remove();
			$('#modalItem').modal('toggle')
			$('input[name="allocation_employee"]').attr('checked', true);
			$('input[name="allocation_position"]').attr('checked', false);
			$('input[name="allocation_shedule"]').attr('checked', false);
			$('input[name="rate"][value="fixed"]').attr('checked',true);
			$('#fixedRate').show();
			$('#dayRate').hide();
			$('#hourRate').hide();
		})
		
		$(document).on('click', '.editItem', function(){
			var id = $(this).data('id');
			$.ajax({
				url: "def_settings/ajax/def/get_compensation.php",
				type: 'POST', 
				data: {id: id},
				dataType: 'json',
				success: function(data){
					//$('#dump').html(data); return false;
					$('input[name="id"]').val(data.id);
					$('input[name="code"]').val(data.code);
					$('input[name="th"]').val(data.th);
					$('input[name="en"]').val(data.en);
					
					$('select[name="type"]').val(data.type);
					GetTheLinkval(data.type);
					$('select[name="link"] option[value="'+data.link+'"]').attr('selected',true);
					$('select[name="occurence"]').val(data.occurence);
					
					$('input[name="allocation_employee"]').attr('checked',data.allocation_employee);
					$('input[name="allocation_position"]').attr('checked',data.allocation_position);
					$('input[name="allocation_shedule"]').attr('checked',data.allocation_shedule);


					$('#positionSelect')[0].sumo.unSelectAll();
					$.each(data.Allposition, function(v){
						$('#positionSelect')[0].sumo.selectItem(v);
					})

					$('#sheduleSelect')[0].sumo.unSelectAll();
					$.each(data.Allshedule, function(v){
						$('#sheduleSelect')[0].sumo.selectItem(v);
					})

					$('#positionSelect')[0].sumo.reload();
					$('#sheduleSelect')[0].sumo.reload();

					$('select[name="levels"]').val(data.levels);
					setLevels(parseInt(data.levels));
					$('input[name="level1"]').val(data.level1);
					$('input[name="level2"]').val(data.level2);
					$('input[name="level3"]').val(data.level3);
					$('input[name="level4"]').val(data.level4);
					$('input[name="level5"]').val(data.level5);

					if(data.rate == 'fixed'){$('#fixedRate').show();}
					if(data.rate == 'day'){$('#dayRate').show();}
					if(data.rate == 'hour'){$('#hourRate').show();}
					$('input[name="rate"][value="' + data.rate + '"]').attr('checked',true);
					$('input[name="day_rate_days"]').val(data.day_rate_days);
					$('input[name="day_rate_multiplier"]').val(data.day_rate_multiplier);
					$('select[name="day_rate_income"]').val(data.day_rate_income);
				
					$('input[name="hour_rate_days"]').val(data.hour_rate_days);
					$('input[name="hour_rate_hours"]').val(data.hour_rate_hours);
					$('input[name="hour_rate_multiplier"]').val(data.hour_rate_multiplier);
					$('select[name="hour_rate_income"]').val(data.hour_rate_income);
					
					$('#modalItem').modal('toggle');
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		})
		
		$(document).on('hide.bs.modal','#modalItem', function () {
    	$('#dataForm')[0].reset();
		});				
		
		/*var dtable = $('#xxx').DataTable({
			scrollY:       false,//600,
			scrollX:       false,
			fixedColumns:  false,
			lengthChange:  false,
			searching: 		true,
			ordering: 		false,
			paging: 			false,
			filter: 			true,
			info: 			false,
			<?=$dtable_lang?>
			initComplete : function( settings, json ) {
				$('#showTable').fadeIn(500)
				setTimeout(function(){
					dtable.columns.adjust().draw()
					dtable.columns([1]).search('Edit').draw();
					dtable.columns([5]).search('income').draw();
					dtable.columns([7]).search("2|3",true,false).draw();
				},10);
			}
		});*/
		
		$("#dataForm").submit(function(e){ 
			e.preventDefault();
			$("#submitBtn i").removeClass('fa-save').addClass('fa-refresh fa-spin');
			var data = $(this).serialize();
			$.ajax({
				url: "def_settings/ajax/def/update_compensations.php",
				type: 'POST', 
				data: data,
				success: function(result){
					//$('#dump').html(result); return false;
					if(result == 'success'){
						$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp;Data updated successfuly',
							duration: 2,
						})
					}else{
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+result,
							duration: 4,
						})
					}
					setTimeout(function(){
						$("#submitBtn i").removeClass('fa-refresh fa-spin').addClass('fa-save');
						$("#submitBtn").removeClass('flash');
						$("#sAlert").fadeOut(200);
						$('#modalItem').modal('toggle')	
					},500);
					setTimeout(function(){
						location.reload();				
					},600);
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
		
		setTimeout(function(){
			$('#dataForm').on('change', 'input, select', function (e) {
				$("#submitBtn").addClass('flash');
				$("#sAlert").fadeIn(200);
			});	
		},1000);

	});

</script>	













