<?
	//changed comment 11-11-2022
	//$getBenefitModels = getBenefitModels();
	$getPayrollModels = getPayrollModels();
	$PayrollModelsNames = PayrollModelsNames();
	$PayrollModelsOverview = PayrollModelsOverview($_SESSION['rego']['cur_month']);

?>
<style type="text/css">
	#modaladdPayroll input[type=radio] {
	    -moz-appearance: none;
	    -webkit-appearance: none;
	    -o-appearance: none;
	    outline: none;
	    content: none;
	    border-radius: 2px;
	}

	#modaladdPayroll input[type=radio]:before {
	    font-family: "FontAwesome";
	    content: "\f00c";
	    padding: 2px;
    	font-size: 9px;
	    color: transparent !important;
	    background: #fff;
	    width: 20px;
	    height: 20px;
	    border: 1px solid #d5d3d3;
	    border-radius: 2px;
	}

	#modaladdPayroll input[type=radio]:checked:before {
	    color: #fff !important;
	    background: #007bff !important;
	    border: 1px solid #007bff;
	    padding: 2px;
    	font-size: 9px;
    	border-radius: 2px;
	}

	.overhang-close{
		display: none;
	}
</style>
<h2 style="padding-right:60px">
	<i class="fa fa-cog"></i>&nbsp; <?=$lng['Payroll overview']?>
	<!-- <span style="display:none; font-style:italic; color:#b00; padding-left:30px" id="sAlert"><i class="fa fa-exclamation-triangle fa-mr"></i><?=$lng['Data is not updated to last changes made']?></span> -->
</h2>

<div class="main">
	<div style="padding:0 0 0 20px" id="dump"></div>

			<div class="row">
				<div class="col-md-3">
					<div class="searchFilter" style="margin:0">
						<input placeholder="Filter" id="searchFilter" class="sFilter" type="text">
						<button id="clearSearchbox" type="button" class="clearFilter btn btn-default btn-sm"><i class="fa fa-times"></i></button>
					</div>
				</div>
				<div class="col-md-7"></div>
				<div class="col-md-2">
					<!-- <a type="button" href="index.php?mn=413" class="btn btn-primary btn-fr"> -->
					<a type="button" onclick="OpenAddpayrollmdl();" class="btn btn-primary btn-fr">
						<i class="fa fa-plus"></i> <?=$lng['Add Payroll']?>
					</a>
				</div>
			</div>
					
			<table id="POdatatable" class="dataTable hoverable selectable">
				<thead>
				<tr>
					<th><?=$lng['Payroll']?>&nbsp;<?=$lng['ID']?></th>
					<th style="width:1px; text-align:center !important"><i class="fa fa-edit fa-lg"></i></th>
					<th style="width:1px; text-align:center !important"><i class="fa fa-trash fa-lg text-danger"></i></th>
					<th><?=$lng['Month']?></th>
					<th><?=$lng['Model Name']?></th>
					<th><?=$lng['Status']?></th>
				</tr>
				</thead>
				<tbody>
					<? if(isset($PayrollModelsOverview[0])){ 
						foreach ($PayrollModelsOverview as $value) { ?>

						<tr>
							<td class="pl-2 font-weight-bold"><?=$value['payroll_id']?></td>
							<td>
								<a title="Edit" onclick="window.location.href='index.php?mn=413&mid=<?=$value['payroll_model_id']?>'"><i class="fa fa-edit fa-lg"></i></a>
							</td>
							<td>
								<a title="Remove" onclick="removeMdl(<?=$value['payroll_model_id']?>, <?=$value['month']?>)"><i class="fa fa-trash fa-lg text-danger"></i></a>
							</td>
							<td><?=$months[$value['month']]?></td>
							<td><?=$PayrollModelsNames[$value['payroll_model_id']]?></td>
							<td><?=isset($value['status']) ? 'Active': '';?></td>				
						</tr>
						 	
					<? } } ?>
				</tbody>
			</table>

			<div class="row">
				<div class="col-md-2" style="margin: -30px 0px 0px 0px;margin-left: auto;margin-right: auto;">
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

</div>

<!-- Modal addPayroll -->
<div class="modal fade" id="modaladdPayroll" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-money"></i>&nbsp; <?=ucwords($lng['Add Payroll'])?> Model</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="addnewpayroll">
					<input type="hidden" name="payroll_id" value="PR-<?=date('dmy-His')?>">
					<input type="hidden" name="month" value="<?=$_SESSION['rego']['cur_month']?>">
					<input type="hidden" name="status" value="1">
					<table class="basicTable" border="0" style="width: 100%;">
						<thead>
							<tr>
								<th class="tal pl-4"><?=$lng['Payroll Models']?></th>
								<th class="tal pl-4"><?=$lng['New'].' '.$lng['Payroll Models']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td style="vertical-align: top;">
									<table class="basicTable" border="0" style="width: 100%;">
										<tbody>
											<? 
											if(isset($getPayrollModels['PayrollModel'])){
												foreach ($getPayrollModels['PayrollModel'] as $key => $value) { ?>
													<tr>
														<td>
															<input type="radio" name="chooseMdl[]" value="<?=$value['id']?>" class="mr-2"> <?=$value['name'];?>
														</td>
													</tr>
											<? } } ?>
										</tbody>
									</table>
								</td>
								<td style="vertical-align: top;">
									<table class="basicTable" border="0" style="width: 100%;">
										<tbody>
											<tr>
												<td>
													<input type="radio" name="chooseMdl[]" value="1001" class="mr-2"> Payroll Manual feed
												</td>
											</tr>
											<tr>
												<td>
													<input type="radio" name="chooseMdl[]" value="1002" class="mr-2"> Payroll calculated model
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>


					<div class="clear" style="height:15px"></div>

					<button class="btn btn-primary btn-fr mr-2" type="button" id="submitBtnp"><i class="fa fa-save"></i>&nbsp; <?=$lng['Save']?></button>
					
					<button class="btn btn-primary mr-1 btn-fr" type="button" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp; <?=$lng['Cancel']?></button>
					
				</form>

			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	function OpenAddpayrollmdl(){
		$('#modaladdPayroll').modal('toggle');
	}

	function removeMdl(mdlid, month){

		if(mdlid && month !=''){

			$("body").overhang({
				type: "confirm",
				primary: "#228B22",
				//accent: "#27AE60",
				yesColor: "#3498DB",
				message: "Do you want to continue?",
				overlay: true,
				callback: function (value) {
					if(value){
						$.ajax({
							url: "ajax/remove_payroll_mdl.php",
							type: 'POST',
							data: {mdlid:mdlid, month: month},
							success: function(result){

								if($.trim(result) == 'success'){

									$("body").overhang({
										type: "success",
										message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data removed successfully']?>',
										duration: 3,
										callback: function (value) {
											window.location.reload();
										}
									})
										
								}else{

									$("body").overhang({
										type: "error",
										message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: '+result,
										duration: 3,
										callback: function (value) {
											window.location.reload();
										}
									})
								}

							},
							error:function (xhr, ajaxOptions, thrownError){
								$("body").overhang({
									type: "error",
									message: '<i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
									duration: 4,
									callback: function (value) {
										window.location.reload();
									}
								})
							}

						});
					}
				}
			});
		}
	}

	$(document).ready(function() {

		var payrolloverview = $('#POdatatable').DataTable({
			//scrollX: true,
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
			payrolloverview.search(this.value).draw();
		});
		$("#clearSearchbox").click(function() {
			$("#searchFilter").val('');
			payrolloverview.search('').draw();
		});

		$(document).on("change", "#pageLength", function(e) {
			if(this.value > 0){
				payrolloverview.page.len( this.value ).draw();
			}
		});

	});

	$(document).on('click', '#submitBtnp', function(){

		var frm = $('#addnewpayroll');
		var data = frm.serialize();

		$.ajax({
			url: "ajax/add_payroll_overview.php",
			type: 'POST',
			data: data,
			success: function(data){

				var result = JSON.parse(data);
				if(result.res == 'success'){

					$("body").overhang({
						type: "success",
						message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Payroll model data saved successfully']?>',
						duration: 1,
						callback: function (value) {
							window.location.href='index.php?mn=413&mid='+result.mdl;
						}
					})
						
				}else{

					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: '+result,
						duration: 2,
						callback: function (value) {
							window.location.reload();
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
						window.location.reload();
					}
				})
			}

		});
	})
</script>
