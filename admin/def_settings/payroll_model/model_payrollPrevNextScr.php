<div class="modal fade" id="payrollPrevNextScr" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 700px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><?=$lng['Payroll Models']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
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

				<form id="payrollModels">
				    <!------ 1st tab start ---->
				    <div class="tab"> 
				    	<table class="basicTable inputs">
				    		<thead>
				    			<tr>
				    				<th colspan="2"><?=$lng['General information']?></th>
				    			</tr>
				    		</thead>
				    		<tbody>
				    			<tr>
				    				<th><?=$lng['Name']?></th>
				    				<td>
				    					<input type="hidden" name="row_id" id="rowID">
										<input type="text" name="pname" id="pMname">
										<input type="hidden" name="tab_name" id="myTabname">
				    				</td>
				    			</tr>
				    			<tr>
				    				<th><?=$lng['Payroll']?></th>
				    				<td>
				    					<select name="payroll_opt" style="width: 100%">
				    						<?foreach($payrollopt as $k => $v){?>
												<option value="<?=$k?>"><?=$v?></option>
											<? } ?>
				    					</select>
				    				</td>
				    			</tr>
				    			<tr>
				    				<th><?=$lng['Field']?></th>
				    				<td>
				    					<select name="field_opt" style="width: 100%">
				    						<?foreach($fieldopt as $k => $v){?>
												<option value="<?=$k?>"><?=$v?></option>
											<? } ?>
				    					</select>
				    				</td>
				    			</tr>
				    			<tr>
				    				<th><?=$lng['Salary split']?></th>
				    				<td>
				    					<select name="salary_split" style="width: 100%">
				    						<?foreach($noyes01 as $k => $v){?>
												<option value="<?=$k?>"><?=$v?></option>
											<? } ?>
				    					</select>
				    				</td>
				    			</tr>
				    		</tbody>
				    	</table>

				    </div>

				    <!------ 2nd tab start ---->
				    <div class="tab"  style="display: none;">  
				    	<table class="basicTable inputs">
				    		<thead>
				    			<tr>
				    				<th colspan="2"><?=$lng['Periods']?></th>
				    			</tr>
				    		</thead>
				    		<tbody>
				    			<tr>
				    				<th>
				    					<input type="hidden" name="periods_def" value="0">
				    					<input type="checkbox" id="Cperiods_def" name="periods_def" value="1">
				    				</th>
				    				<th class="tal">Use default payroll settings</th>
				    			</tr>
				    			<tr>
				    				<th>
				    					<input type="hidden" name="periods_set" value="0">
				    					<input type="checkbox" id="Cperiods_set" name="periods_set" value="1">
				    				</th>
				    				<th class="tal">Set periods</th>
				    			</tr>
				    		</tbody>
				    	</table>
				    </div>

				    <!------ 3rd tab start ---->
				    <div class="tab"  style="display: none;">  
				    	<table class="basicTable inputs">
				    		<thead>
				    			<tr>
				    				<th colspan="2"><?=$lng['Manual'].' '.$lng['Model']?></th>
				    			</tr>
				    		</thead>
				    		<tbody>
				    			<tr>
				    				<th>
				    					<input type="hidden" name="use_sso_pnd_def" value="0">
				    					<input type="checkbox" id="Cuse_sso_pnd_def" name="use_sso_pnd_def" value="1">
				    				</th>
				    				<th class="tal">Use SSO PND default settings</th>
				    			</tr>
				    			<tr>
				    				<th>
				    					<input type="hidden" name="use_manual_rate_def" value="0">
				    					<input type="checkbox" id="Cuse_manual_rate_def" name="use_manual_rate_def" value="1">
				    				</th>
				    				<th class="tal">Use manual rates default settings</th>
				    			</tr>
				    			<tr>
				    				<th>
				    					<input type="hidden" name="use_othr_setting_def" value="0">
				    					<input type="checkbox" id="Cuse_othr_setting_def" name="use_othr_setting_def" value="1">
				    				</th>
				    				<th class="tal">Use other default settings payroll</th>
				    			</tr>
				    		</tbody>
				    	</table>
				    </div>

				    <!------ 4th tab start ---->
				    <!-- <div class="tab"  style="display: none;">  

				    </div> -->

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
	    SaveNewPayrollModel();
	    return false;
		}
		//alert(currentTab);
		showTab(currentTab);
	}

	function SaveNewPayrollModel(){

		var frm = $('#payrollModels');
		var data = frm.serialize();

		var err = false;
		var erval;
		if($('#payrollModels input#pMname').val() == ''){err = true; erval = '<?=$lng['Error']?>: Name is blank';};

		if(err == true){

			$("body").overhang({
				type: "error",
				message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;'+erval,
				duration: 3,
				callback: function(v){
					window.location.reload();
				}
			})
			return false;
		}

		$('#payrollPrevNextScr').modal('hide');

		$.ajax({
			url: "def_settings/ajax/update_payrollModel_data.php",
			type: 'POST',
			data: data,
			success: function(result){

				if(result == 'success'){

					$("body").overhang({
						type: "success",
						message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Payroll model data saved successfully']?>',
						duration: 2,
						callback: function (value) {
							location.href = 'index.php?mn=101';
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