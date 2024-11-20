<style type="text/css">
	#myModal .SumoSelect {
	    width: 140px !important;
	}
</style>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" style="min-width:1000px">
		<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Calculation Model</h4>
				</div>
				<div class="modal-body" style="padding:20px">

					<table border="0" style="margin:0; width:100%">
						<thead>
							<tr>
								<th style="padding:0 0 5px 2px; font-size:18px; white-space:nowrap" class="tal" id="mName"></th>
								<th style="width:80%"></th>
								
								<th style="padding:0 0 5px 5px" class="tar">
									<button type="button" class="btn btn-primary btn-sm" onclick="AppendMore();"><i class="fa fa-plus fa-mr"></i> <?=$lng['Add Calculation']?></button>						
								</th>
								
							</tr>
						</thead>
					</table>

				<div id="mainDiv">

					<table class="basicTable" id="mainTbl" border="0">
						<thead>
							<tr>
								<td class="tac sorting_disabled" style="width: 18px;" rowspan="1" colspan="1">
									<i class="fa fa-edit fa-lg"></i>
								</td>
								<th class=""><?=$lng['Name']?></th>
								<th class=""><?=$lng['General information']?></th>
								<th class=""><?=$lng['Data']?></th>
								<th class=""><?=$lng['Condition']?></th>
								<th class=""><?=$lng['Result']?></th>
								<th class=""><?=$lng['Employee group']?></th>
							</tr>
						</thead>
						<tbody id="tbodyMain">
							<tr>
								<th>
									<a title="Edit" onclick="NextPrevScrpopup()" class="editItem" >
										<i class="fa fa-edit fa-lg"></i>
									</a>
								</th>
								<td style="vertical-align: top;">
									<input type="text" id="mdlName" name="name[]" style="border:1px solid #ddd !important;">
								</td>
								<td style="vertical-align: top;">
									<table class="basicTable compact inputs" style="width:100%;padding: 0px !important;">
										<tr style="border:0 !important">
											<th class="tal"><?=$lng['Feed']?></th>
											<td>
												<select class="cLevel" name="feed[]" style="width:100%;padding: 0px !important;">
													<option value="Manual"><?=$lng['Manual']?></option>
													<option value="Calculated"><?=$lng['Calculated']?></option>
												</select>
											</td>
										</tr>
										<tr style="border:0 !important">
											<th class="tal"><?=$lng['Type']?></th>
											<td>
												<select class="cLevel" name="type[]" style="width:100%;padding: 0px !important;" >
													<option value="Rewards"><?=$lng['Rewards']?></option>
													<option value="Penalties"><?=$lng['Penalties']?></option>
												</select>
											</td>
										</tr>
										<tr style="border:0 !important">
											<th class="tal"><?=$lng['Linked to']?></th>
											<td>
												<select class="cLevel" name="linked_to[]" style="width:100%;padding: 0px !important;">
													<option value="inc_var"><?=$lng['Variable allowances']?></option>
													<option value="ded_var"><?=$lng['Variable deductions']?></option>
												</select>
											</td>
										</tr>
									</table>
									
								</td>
								<td style="vertical-align: top;">
									<table class="basicTable compact inputs" style="width:100%;padding: 0px !important;">
										<tr style="border:0 !important">
											<th class="tal"><?=$lng['Early Hours']?></th>
											<td>
												<input type="hidden" name="early_hours[]" value="0">
												<input type="checkbox" name="early_hours[]" value="1" class="mt-2">
											</td>
										</tr>

										<tr style="border:0 !important">
											<th class="tal"><?=$lng['Late Hours']?></th>
											<td>
												<input type="hidden" name="late_hours[]" value="0">
												<input type="checkbox" name="late_hours[]" value="1" class="mt-2">
											</td>
										</tr>

										<tr style="border:0 !important">
											<th class="tal"><?=$lng['Early THB']?></th>
											<td>
												<input type="hidden" name="early_thb[]" value="0">
												<input type="checkbox" name="early_thb[]" value="1" class="mt-2">
											</td>
										</tr>

										<tr style="border:0 !important">
											<th class="tal"><?=$lng['Late THB']?></th>
											<td>
												<input type="hidden" name="late_thb[]" value="0">
												<input type="checkbox" name="late_thb[]" value="1" class="mt-2">
											</td>
										</tr>

										<tr style="border:0 !important">
											<th class="tal"><?=$lng['Early Event']?></th>
											<td>
												<input type="hidden" name="early_event[]" value="0">
												<input type="checkbox" name="early_event[]" value="1" class="mt-2">
											</td>
										</tr>

										<tr style="border:0 !important">
											<th class="tal"><?=$lng['Late Event']?></th>
											<td>
												<input type="hidden" name="late_event[]" value="0">
												<input type="checkbox" name="late_event[]" value="1" class="mt-2">
											</td>
										</tr>
									</table>
								</td>
								<td style="vertical-align: top;">None</td>
								<td style="vertical-align: top;">
									<table class="basicTable compact inputs" style="width:100%;padding: 0px !important;">
										<tr style="border:0 !important">
											<!-- <th class="tal"><?=$lng['Hour Calculation']?></th> -->
											<td colspan="2">
												<select class="cLevel" name="penalties" style="width:100%;padding:0px !important;">
													<? foreach ($dataRP as $key => $value) { ?>
														<option value="<?=$value['id']?>"><?=$value['code']?></option>
													<? } ?>
													
												</select>
											</td>
										</tr>
										<!--<tr style="border:0 !important">
											<th class="tal"><?=$lng['THB manual input']?></th>
											<td><input type="text" name="thb_manual[]"></td>
										</tr>
										<tr style="border:0 !important">
											<th class="tal"><?=$lng['Event Calculation']?></th>
											<td>ELFIX1</td>
										</tr>-->
									</table>
								</td>
								<td style="vertical-align: top;">
									<select class="cLevel TeamsSelect" name="teams[]" multiple="multiple" style="width:100%;padding: 0px !important;">
										<?foreach($teams as $k => $v){?>
											<option value="<?=$k?>"><?=$v['code']?></option>
										<? } ?>
									</select>
								</td>
							</tr>

						</tbody>
						<tbody id="NAsction">
							<tr>
								<td class="tal"></td>
								<td class="tal">N/A</td>
								<td colspan="4"></td>
								<td class="tal">No Teams</td>
							</tr>
						</tbody>
					</table>

				</div>
				

					<div style="height:10px"></div>
					<!-- <button id="submitBtn" class="btn btn-primary" type="submit"><i class="fa fa-save"></i>&nbsp;&nbsp;<?=$lng['Update']?></button> -->
					<button data-dismiss="modal" style="float:right" class="btn btn-primary" type="button"><i class="fa fa-times"></i>&nbsp;&nbsp;<?=$lng['Cancel']?></button>
				</div>
						
		</div>
	</div>
</div>

<?php
	
	include('model_prevNext.php')

?>
<script type="text/javascript">

	$(document).ready(function() {

		$('.TeamsSelect').SumoSelect({
			placeholder: '<?=$lng['Select'].' '.$lng['Teams']?>',
			captionFormat: '<?=$lng['Teams']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All'].' '.$lng['Teams']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});

	});

	function NextPrevScrpopup(){

		var mName = $('#myModal table input#mdlName').val();
		var Tabname = $('ul#myTab li a.active').text();
		$('#myModal').modal('hide');
		
		$('#PrevNextScr').modal('toggle');
		
		$('#PrevNextScr table input#edMname').val(mName);
		$('#PrevNextScr table input#myTabname').val(Tabname);
	}

	function SelectLinkedto(val){

		$("select#sellink option").remove();
		if (val == 'Rewards') {
			var opt = '<option value="inc_var"><?=$lng['Variable allowances']?></option>';
		}else if (val == 'Penalties') {
			var opt = '<option value="ded_var"><?=$lng['Variable deductions']?></option>';
		}else{
			var opt = '';
		}

		$("select#sellink").append(opt);
	}
	
	function AppendMore(){



		$('#myModal #mainDiv table#mainTbl tbody#tbodyMain').append('<tr><th style="vertical-align: top;padding: 0px 10px !important;"><a title="Edit" title="Edit" onclick="NextPrevScrpopup()" class="editItem" ><i class="fa fa-edit fa-lg"></i></a></th><td style="vertical-align: top;"><input type="text" name="name[]" style="border:1px solid #ddd !important;"></td><td style="vertical-align: top;"><table class="basicTable compact inputs" style="width:100%;padding: 0px !important;"><tr style="border:0 !important"><th class="tal"><?=$lng['Feed']?></th><td><select class="cLevel" name="feed[]" style="width:100%;padding: 0px !important;"><option value="Manual">Manual</option><option value="Calculated">Calculated</option></select></td></tr><tr style="border:0 !important"><th class="tal"><?=$lng['Type']?></th><td><select class="cLevel" name="type[]" style="width:100%;padding: 0px !important;"><option value="Rewards">Rewards</option><option value="Penalties">Penalties</option></select></td></tr><tr style="border:0 !important"><th class="tal"><?=$lng['Linked to']?></th><td><select class="cLevel" name="linked_to[]" style="width:100%;padding: 0px !important;"><option value="ded_var"><?=$lng['Variable deductions']?></option><option value="inc_var"><?=$lng['Variable allowances']?></option></select></td></tr></table></td><td style="vertical-align: top;"><table class="basicTable compact inputs" style="width:100%;padding: 0px !important;"><tr style="border:0 !important"><th class="tal"><?=$lng['Early Hours']?></th><td><input type="hidden" name="early_hours[]" value="0"><input type="checkbox" name="early_hours[]" value="1" class="mt-2"></td></tr><tr style="border:0 !important"><th class="tal"><?=$lng['Late Hours']?></th><td><input type="hidden" name="late_hours[]" value="0"><input type="checkbox" name="late_hours[]" value="1" class="mt-2"></td></tr><tr style="border:0 !important"><th class="tal"><?=$lng['Early THB']?></th><td><input type="hidden" name="early_thb[]" value="0"><input type="checkbox" name="early_thb[]" value="1" class="mt-2"></td></tr><tr style="border:0 !important"><th class="tal"><?=$lng['Late THB']?></th><td><input type="hidden" name="late_thb[]" value="0"><input type="checkbox" name="late_thb[]" value="1" class="mt-2"></td></tr><tr style="border:0 !important"><th class="tal"><?=$lng['Early Event']?></th><td><input type="hidden" name="early_event[]" value="0"><input type="checkbox" name="early_event[]" value="1" class="mt-2"></td></tr><tr style="border:0 !important"><th class="tal"><?=$lng['Late Event']?></th><td><input type="hidden" name="late_event[]" value="0"><input type="checkbox" name="late_event[]" value="1" class="mt-2"></td></tr></table></td><td style="vertical-align: top;">None</td><td style="vertical-align: top;"><table class="basicTable compact inputs" style="width:100%;padding: 0px !important;"><tr style="border:0 !important"><td colspan="2"><select class="cLevel" name="penalties" style="width:100%;padding:0px !important;"><? foreach ($dataRP as $key => $value) { ?><option value="<?=$value['id']?>"><?=$value['code']?></option><? } ?></select> </td> </tr> </table> </td> <td style="vertical-align: top;"><select class="cLevel TeamsSelect" name="teams[]" multiple="multiple" style="width:100%;padding: 0px !important;"><?foreach($teams as $k => $v){?><option value="<?=$k?>"><?=$v['code']?></option><? } ?></select></td></tr>');

		$('.TeamsSelect').SumoSelect({
			placeholder: '<?=$lng['Select'].' '.$lng['Teams']?>',
			captionFormat: '<?=$lng['Teams']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All'].' '.$lng['Teams']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});
	}

</script>