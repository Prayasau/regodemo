<?
	if(!isset($_GET['mn']) || $_GET['mid'] == ''){
		header('Location: no_access.php'); 
	}

	$dataRP = getActiveRewardPenalties();
	$getPayrollModels = getPayrollModels($_GET['mid']);

	/*$BMall_data = '';
	if($getPayrollModels[0]['all_data'] !=''){
		$BMall_data = unserialize($getPayrollModels[0]['all_data']);
	}*/

	$deductionOption = getDeductionOpt();
	$allowanceOption = getAllowanceOpt();

	//echo '<pre>';
	//print_r($getPayrollModels);
	//print_r($standard_model_array);
	//echo '</pre>';
?>
<style type="text/css">
	
	table.basicTable tbody th{
		border-right: 0px !important;
	}
</style>
<h2><i class="fa fa-cog fa-lg"></i>&nbsp;&nbsp;<?=$lng['Payroll Models']?></h2>

<div class="main">
	
	<div id="showTable" style="display:xnone; margin-bottom:50px">
		<table border="0" style="width:100%; margin-bottom:8px">
			<tr>
				<td style="width:100%"></td>
				<td style="vertical-align:top; padding-left:10px">
					<button class="btn btn-primary" onclick="window.history.go(-1); return false;" type="button"><?=$lng['Go back']?></button>
				</td>
				
			</tr>
		</table>

		<div id="mainDiv">

			<table class="basicTable" id="mainTbl" border="0">
				<thead>
					<tr>
						<td class="tac sorting_disabled" style="width: 18px;" rowspan="1" colspan="1">
							<i class="fa fa-edit fa-lg"></i>
						</td>
						<th class=""><?=$lng['General information']?></th>
						<th class=""><?=$lng['Periods']?></th>
						<th class=""><?=$lng['Manual'].' '.$lng['Model']?></th>
						<th class=""><?=$lng['Calculations'].' '.$lng['Model']?></th>
					</tr>
				</thead>
				<tbody id="tbodyMain">
					
					<tr>
						<th>
							<a title="Edit" data-id="<?=$getPayrollModels[0]['id']?>" class="editItem" >
								<i class="fa fa-edit fa-lg"></i>
							</a>
						</th>
						<td>
							<table class="basicTable inputs">
								<tbody>
									<tr>
										<th><?=$lng['Name']?></th>
										<td><input type="text" name="pname" value="<?=$getPayrollModels[0]['name']?>" readonly></td>
									</tr>
									<tr>
					    				<th><?=$lng['Payroll']?></th>
					    				<td>
					    					<select name="payroll_opt" style="width: 100%">
					    						<?foreach($payrollopt as $k => $v){?>
													<option value="<?=$k?>" <?if($k == $getPayrollModels[0]['payroll_opt']){echo 'selected';}?>><?=$v?></option>
												<? } ?>
					    					</select>
					    				</td>
					    			</tr>
					    			<tr>
					    				<th><?=$lng['Field']?></th>
					    				<td>
					    					<select name="field_opt" style="width: 100%">
					    						<?foreach($fieldopt as $k => $v){?>
													<option value="<?=$k?>" <?if($k == $getPayrollModels[0]['field_opt']){echo 'selected';}?>><?=$v?></option>
												<? } ?>
					    					</select>
					    				</td>
					    			</tr>
					    			<tr>
					    				<th><?=$lng['Salary split']?></th>
					    				<td>
					    					<select name="salary_split" style="width: 100%">
					    						<?foreach($noyes01 as $k => $v){?>
													<option value="<?=$k?>" <?if($k == $getPayrollModels[0]['salary_split']){echo 'selected';}?>><?=$v?></option>
												<? } ?>
					    					</select>
					    				</td>
					    			</tr>
								</tbody>
							</table>
						</td>
						<td style="vertical-align: top;">
							<table class="basicTable inputs">
					    		<tbody>
					    			<tr>
					    				<th>
					    					<input type="hidden" name="periods_def" value="0">
					    					<input type="checkbox" name="periods_def" value="1" <?if($getPayrollModels[0]['periods_def'] == 1){echo 'checked';}?>>
					    				</th>
					    				<th class="tal">Use default payroll settings</th>
					    			</tr>
					    			<tr>
					    				<th>
					    					<input type="hidden" name="periods_set" value="0">
					    					<input type="checkbox" name="periods_set" value="1" <?if($getPayrollModels[0]['periods_set'] == 1){echo 'checked';}?>>
					    				</th>
					    				<th class="tal">Set periods</th>
					    			</tr>
					    		</tbody>
					    	</table>
						</td>
						<td style="vertical-align: top;">
							<table class="basicTable inputs">
					    		<tbody>
					    			<tr>
					    				<th>
					    					<input type="hidden" name="use_sso_pnd_def" value="0">
					    					<input type="checkbox" name="use_sso_pnd_def" value="1" <?if($getPayrollModels[0]['use_sso_pnd_def'] == 1){echo 'checked';}?>>
					    				</th>
					    				<th class="tal">Use SSO PND default settings</th>
					    			</tr>
					    			<tr>
					    				<th>
					    					<input type="hidden" name="use_manual_rate_def" value="0">
					    					<input type="checkbox" name="use_manual_rate_def" value="1" <?if($getPayrollModels[0]['use_manual_rate_def'] == 1){echo 'checked';}?>>
					    				</th>
					    				<th class="tal">Use manual rates default settings</th>
					    			</tr>
					    			<tr>
					    				<th>
					    					<input type="hidden" name="use_othr_setting_def" value="0">
					    					<input type="checkbox" name="use_othr_setting_def" value="1" <?if($getPayrollModels[0]['use_othr_setting_def'] == 1){echo 'checked';}?>>
					    				</th>
					    				<th class="tal">Use other default settings payroll</th>
					    			</tr>
					    		</tbody>
					    	</table>
						</td>
						<td style="vertical-align: top;">
							<p>None</p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

</div>
<?php
	include('payroll_model/model_payrollPrevNextScr.php');
?>

<script type="text/javascript">

	$(document).ready(function() {
	
		$(document).on('click', '.editItem', function(){
			var mid = $(this).data('id');

			$.ajax({
				type : 'post',
				url  : 'ajax/get_payroll_model_data.php',
				data : {id:mid},
				dataType: 'json',
				success : function(data){


					$('#payrollPrevNextScr table th#mName small').remove();
					$('#payrollPrevNextScr table th#mName').html('<small style="font-weight: 700;">Model: '+data.name+'</small>');

					var inputView = true;
					$('#payrollPrevNextScr input[name="row_id"]').val(data.id);
					$('#payrollPrevNextScr input#pMname').val(data.name).attr('readonly',inputView);
					$('#payrollPrevNextScr input[name="tab_name"]').val(data.tab_name);

					$('#payrollPrevNextScr select[name="payroll_opt"]').val(data.payroll_opt);
					$('#payrollPrevNextScr select[name="field_opt"]').val(data.field_opt);
					$('#payrollPrevNextScr select[name="salary_split"]').val(data.salary_split);

					$('#payrollPrevNextScr input#Cperiods_def').attr('checked',data.Cperiods_def);
					$('#payrollPrevNextScr input#Cperiods_set').attr('checked',data.Cperiods_set);
					$('#payrollPrevNextScr input#Cuse_sso_pnd_def').attr('checked',data.Cuse_sso_pnd_def);
					$('#payrollPrevNextScr input#Cuse_manual_rate_def').attr('checked',data.Cuse_manual_rate_def);
					$('#payrollPrevNextScr input#Cuse_othr_setting_def').attr('checked',data.Cuse_othr_setting_def);

					$('#payrollPrevNextScr').modal('toggle');

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

	});
</script>