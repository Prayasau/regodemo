<style type="text/css">
	.borderCls{
		background: #ffff004a !important;
	}
</style>
<div style="height:100%; border:0px solid red; position:relative;">
	<div>
		<div class="smallNav">
			<ul>
				<li>
					<div class="searchFilter" style="margin:0">
						<input placeholder="Filter" id="searchFilterpr" class="sFilter" type="text">
						<button id="clearSearchboxpr" type="button" class="clearFilter btn btn-default btn-sm"><i class="fa fa-times"></i></button>
					</div>
				</li>	

			</ul>
		</div>
	</div>
	
	<table id="payroll_result" class="dataTable hoverable selectable">
		<thead>
			<tr>
				<th colspan="4" class="tac"><?=$lng['Employee']?></th>
				<th colspan="4" class="tac"><?=$lng['Total']?></th>					
				<th colspan="<?= count($income_group) + count($deduct_group);?>" class="tac"><?=$lng['Income groups']?></th>	
				
			</tr>
			<tr>
				<th class="tal"><?=$lng['Emp. ID']?></th>
				<th class="tal" style="width: 130px;"><?=$lng['Employee name']?></th>
				<th class="tal" style="cursor: pointer;">
					<i data-toggle="tooltip" title="Calculator" class="fa fa-calculator fa-lg"></i>
				</th>
				<th class="tac"><?=$lng['Paid'].'<br>'.$lng['days']?></th>

				<th class="tac"><?=$lng['Earnings']?></th>
				<th class="tac"><?=$lng['Deductions']?></th>
				<th class="tac"><?=$lng['Net Income']?></th>
				<th class="tac"><?=$lng['Net pay']?></th>

				<? foreach ($income_group as $key => $value) { ?>
					<th class="tac"><?=$value?></th>
				<? } ?>
				<? foreach ($deduct_group as $key => $value) { ?>
					<th class="tac"><?=$value?></th>
				<? } ?>

			</tr>
		</thead>
		<tbody>
			<? foreach($getSelmonPayrollDatass as $key => $row){ 
					if($row['contract_type'] == 'month'){$pd=$row['paid_days'];}elseif($row['contract_type'] == 'day'){
						$pdHrs = $row['mf_paid_hour'];
						if($pdHrs !=''){
							$pdHrstot = decimalHours($pdHrs);
							$pds = $row['paid_days'] + ($pdHrstot/24);
							$pd = round($pds,2);
						}else{
							$pd=$row['paid_days'];
						}
					}else{$pd='';}
				?>

				<tr data-empid="<?=$row['emp_id']?>">

					<td class="pad010 pl-2 font-weight-bold" style="cursor: pointer;color:#900"><?=$row['emp_id']?></td>
					<td class="pad010 pl-2 font-weight-bold" style="cursor: pointer;color:#900"><?=$row['emp_name_'.$lang]?></td>
					<td>
						<a onclick="payrollResultPopups(this)" id="<?=$row['emp_id']?>"><i class="fa fa-calculator fa-lg" ></i></a>
					</td>
					<td><?=$pd?></td>

					<td class="tar"><?=number_format($row['total_earnings'],2);?></td>
					<td class="tar"><?=number_format($row['total_deductions'],2);?></td>
					<td class="tar"><?=number_format($row['total_net_income'],2);?></td>
					<td class="tar"><?=number_format($row['total_net_pay'],2);?></td>

					<td class="tar"><?=number_format($row['salary_group_total'],2);?></td>
					<td class="tar"><?=number_format($row['fix_income_group_total'],2);?></td>
					<td class="tar"><?=number_format($row['overtime_group_total'],2);?></td>
					<td class="tar"><?=number_format($row['var_income_group_total'],2);?></td>
					<td class="tar"><?=number_format($row['other_income_group_total'],2);?></td>
					<td class="tar"><?=number_format($row['absence_group_total'],2);?></td>
					<td class="tar"><?=number_format($row['fix_ded_group_total'],2);?></td>
					<td class="tar"><?=number_format($row['var_ded_group_total'],2);?></td>
					<td class="tar"><?=number_format($row['other_ded_group_total'],2);?></td>
					<td class="tar"><?=number_format($row['legal_ded_group_total'],2);?></td>
					<td class="tar"><?=number_format($row['advance_pay_group_total'],2);?></td>
					
				</tr>

			<? } ?>
		</tbody>
	</table>

	<div class="row">
		<div class="col-md-2" style="margin: -30px 0px 0px 0px;margin-left: auto;margin-right: auto;">
			<select id="pageLengthpr" class="button btn-fl">
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


<div class="modal fade" id="PayrollRresultmdl" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="top: 0px;">
	<div class="modal-dialog modal-xl" role="document" style="min-width: 1350px !important;">
		<div class="modal-content">
			<div class="modal-header" style="padding: 5px 13px">
				<h5 class="modal-title" style="padding: 0px;"><i class="fa fa-calculator"></i>&nbsp; <?=$lng['Payroll result'].' <i class="fa fa-arrow-circle-right"></i> '.$months[$_SESSION['rego']['cur_month']].' '.$_SESSION['rego']['cur_year']?></h5>
				<div style=" position:absolute; right:40px; padding:3px 0">
					<a title="Print" href="#" style="margin-right:5px"><i class="fa fa-print fa-lg" style="margin-top: 5px;"></i></a>
				</div>
				<a title="Close" onclick="closeBtn2();" type="button" class="close" aria-label="Close"><i class="fa fa-times text-danger"></i></a>
			</div>
			<div class="modal-body mb-4" style="padding: 5px 20px 5px !important;overflow: hidden;overflow-y: scroll;">

				<table class="basicTable salcal" border="0" style="width: 100%;">
					<tbody>
						<tr>
							<th class="pl-2"><?=$lng['Emp. ID']?></th>
							<td class="pl-2" id="empids"></td>
							<th class="pl-2"><?=$lng['Department']?></th>
							<td class="pl-2" id="deptval"></td>
							<th class="pl-2"><?=$lng['Contract type']?></th>
							<td class="pl-2" id="contract_type"></td>
							<th class="pl-2"><?=$lng['Calculate Tax']?></th>
							<td class="pl-2" id="calc_tax"></td>
							
						</tr>
						<tr>
							<th class="pl-2"><?=$lng['Employee name']?></th>
							<td class="pl-2" id="emp_name"></td>
							<th class="pl-2"><?=$lng['Teams']?></th>
							<td class="pl-2" id="teamval"></td>
							<th class="pl-2"><?=$lng['Tax calculation method']?></th>
							<td class="pl-2" id="tax_calc_method"></td>
							<th class="pl-2"><?=$lng['Calculate SSO']?></th>
							<td class="pl-2" id="calc_sso"></td>
							
														
						</tr>
						<tr>
							<th class="pl-2"><?=$lng['Position']?></th>
							<td class="pl-2" id="position_val"></td>
							<th class="pl-2"></th>
							<td class="pl-2"></td>
							<th class="pl-2"><?=$lng['Calculation base']?></th>
							<td class="pl-2" id="calc_base"></td>

							<th class="pl-2" id="pvfpsfLbl"></th>
							<td class="pl-2" id="calc_pvf"></td>

							<!-- <th class="pl-2"><?=$lng['Calculate PSF']?></th>
							<td class="pl-2" id="calc_psf"></td> -->
						</tr>
					</tbody>
				</table>

				<div class="row">
					<div class="col-md-4" style="padding-right: 0px;max-width:43%;">
						<table id="getlinkeddataPR" class="basicTable salcal" border="0" style="width: 100%;border-right: 1px solid #ccc;">
							<thead>
								<tr>
									<th class="tac text-danger"><?=strtoupper($lng['Summary'])?></th>
									<th colspan="5" class="tac text-danger"><?=strtoupper($lng['Click amount to see detail'])?></th>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Description']?></th>
									<th class="tal"><?=$lng['Curr'].' '.$lng['Calc']?></th>
									<th class="tal"><?=$lng['Prev'].' '.$lng['Calc']?></th>
									<th class="tal"><?=$lng['Curr'].' '.$lng['Month']?></th>
									<th class="tal"><?=$lng['Prev'].' '.$lng['Month']?></th>
									<th class="tal"><?=$lng['Full year']?></th>
								</tr>
							</thead>
							<thead>
								<tr>
									<th colspan="6" class="tal"><?=strtoupper($lng['Total income'])?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th class="tal"><?=$lng['Earnings']?></th>
									<td class="tar" id="ear_curr_calc"></td>
									<td class="tar"></td>
									<td class="tar" id="ear_curr_mnth"></td>
									<td class="tar" id="ear_prev_mnth"></td>
									<td class="tar" id="ear_full_year"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Deductions']?></th>
									<td class="tar" id="ded_curr_calc"></td>
									<td class="tar"></td>
									<td class="tar" id="ded_curr_mnth"></td>
									<td class="tar" id="ded_prev_mnth"></td>
									<td class="tar" id="ded_full_year"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Income'].' '.$lng['PND']?></th>
									<td class="tar" id="pnd_curr_calc"></td>
									<td class="tar"></td>
									<td class="tar" id="pnd_curr_mnth"></td>
									<td class="tar" id="pnd_prev_mnth"></td>
									<td class="tar" id="pnd_full_year"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Income'].' '.$lng['SSO']?></th>
									<td class="tar" id="sso_curr_calc"></td>
									<td class="tar"></td>
									<td class="tar" id="sso_curr_mnth"></td>
									<td class="tar" id="sso_prev_mnth"></td>
									<td class="tar" id="sso_full_year"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Income'].' '.$lng['PVF']?></th>
									<td class="tar" id="pvf_curr_calc"></td>
									<td class="tar"></td>
									<td class="tar" id="pvf_curr_mnth"></td>
									<td class="tar" id="pvf_prev_mnth"></td>
									<td class="tar" id="pvf_full_year"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Income'].' '.$lng['PSF']?></th>
									<td class="tar" id="psf_curr_calc"></td>
									<td class="tar"></td>
									<td class="tar" id="psf_curr_mnth"></td>
									<td class="tar" id="psf_prev_mnth"></td>
									<td class="tar" id="psf_full_year"></td>
								</tr>
							</tbody>
							<thead>
								<tr>
									<th colspan="6" class="tal"><?=strtoupper($lng['Total']).' '.strtoupper($lng['Groups'])?></th>
								</tr>
							</thead>
							<tbody>
								<?
								// echo "<pre>";
								// print_r($payrollparametersformonth);
								// echo "</pre>";
								?>
								<? foreach ($income_group as $key => $value) { ?>
									<tr>
										<th class="tal"><?=$value?></th>
										<td class="tar" id="<?=$key?>_calc"></td>
										<td class="tar"></td>
										<td class="tar" id="<?=$key?>"></td>
										<td class="tar" id="<?=$key?>_prev"></td>
										<td class="tar" id="<?=$key?>_fullY"></td>
									</tr>
								<? } ?>

								<? foreach ($deduct_group as $key => $value) { ?>
									<tr>
										<th class="tal"><?=$value?></th>
										<td class="tar" id="<?=$key?>_calc"></td>
										<td class="tar"></td>
										<td class="tar" id="<?=$key?>"></td>
										<td class="tar" id="<?=$key?>_prev"></td>
										<td class="tar" id="<?=$key?>_fullY"></td>
									</tr>
								<? } ?>
								
							</tbody>
							<thead>
								<tr>
									<th colspan="6" class="tal"><?=strtoupper($lng['Totals']).' '.strtoupper($lng['Result'])?></th>
								</tr>
							</thead>
							<tbody>
								<tr style="pointer-events: none;">
									<th class="tal"><?=$lng['Net Income']?></th>
									<td class="tar" id="total_net_income_cur_cal"></td>
									<td class="tar" ></td>
									<td class="tar" id="total_net_income_cur_mnth"></td>
									<td class="tar" id="total_net_income_prev_mnth"></td>
									<td class="tar" id="total_net_income_fullyear"></td>
								</tr>
								<tr style="pointer-events: none;">
									<th class="tal"><?=$lng['Net pay']?></th>
									<td class="tar" id="total_net_pay_cur_cal"></td>
									<td class="tar" ></td>
									<td class="tar" id="total_net_pay_cur_mnth"></td>
									<td class="tar" id="total_net_pay_prev_mnth"></td>
									<td class="tar" id="total_net_pay_fullyear"></td>
								</tr>
							</tbody>
							<thead>
								<tr>
									<th colspan="6" class="tal"><?=strtoupper($lng['Costs to Employer'])?></th>
								</tr>
							</thead>
							<tbody>
								<tr style="pointer-events: none;">
									<th class="tal"><?=$lng['SSO Employer']?></th>
									<td class="tar" id="pr_sso_emplyr_calc"></td>
									<td class="tar"></td>
									<td class="tar" id="pr_sso_emplyr"></td>
									<td class="tar" id="pr_sso_emplyr_prev"></td>
									<td class="tar" id="pr_sso_emplyr_full"></td>
								</tr>
								<tr style="pointer-events: none;">
									<th class="tal"><?=$lng['PVF Employer']?></th>
									<td class="tar" id="pr_pvf_emplyr_calc"></td>
									<td class="tar"></td>
									<td class="tar" id="pr_pvf_emplyr"></td>
									<td class="tar" id="pr_pvf_emplyr_prev"></td>
									<td class="tar" id="pr_pvf_emplyr_full"></td>
								</tr>
								<tr style="pointer-events: none;">
									<th class="tal"><?=$lng['PSF Employer']?></th>
									<td class="tar" id="pr_psf_emplyr_calc"></td>
									<td class="tar"></td>
									<td class="tar" id="pr_psf_emplyr"></td>
									<td class="tar" id="pr_psf_emplyr_prev"></td>
									<td class="tar" id="pr_psf_emplyr_full"></td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="col-md-8 table-responsive" style="padding-left: 0px;max-width:57%;">
						<table id="linkedcolumns" class="basicTable salcal" border="0" style="width: 100%;">
							
						</table>

						<table id="linkedcolumnsD" class="basicTable salcal" border="0" style="width: 100%;">
							
						</table>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<script type="text/javascript">


	function payrollResultPopups(that){

		var empid = that.id;
		var currmnth = <?=$_SESSION['rego']['cur_month']?>;
		var mid = '<?=$_GET['mid']?>';
		$('#getlinkeddataPR tbody td').removeClass('borderCls');

		$.ajax({
			type: 'post',
			url: "ajax/get_payroll_data.php",
			data: {empid: empid,mid:mid},
			success: function(result){

				if(result == 'error'){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: '+ result,
						duration: 3,
						callback: function(v){
							window.location.reload();
						}
					})
				}else{

					var data = JSON.parse(result);
					var payroll_datas = data.payroll_data_coulmn;
					var payroll_datas_prev = data.payroll_data_coulmn_prev;

					//===================== Right side table data start (Allowances) ======================//
					var eColsMdlA = <?=$eColsMdlA?>;
					var eColsMdlD = <?=$eColsMdlD?>;
					
					var short_months = <?=json_encode($short_months)?>;
					var payrollparametersformonth =<?=json_encode(array_values($payrollparametersformonth))?>;
					var allowance_deduct_name = <?=json_encode($allowDdt)?>;
					var allowDdtEmp_name = <?=json_encode($allowDdtEmp)?>;
					var curryear = <?=substr($_SESSION['rego']['cur_year'], -2)?>;
					var remaining_mnth = 12 - currmnth + 1;
					var ssoEmpRates = data[0].ssoEmpRates;

					var countAllown = 0;
					var countDeduct = 0;
					$.each(payroll_datas, function(k,v){

						if(v['allow_deduct_ids'] !=''){
							if(v['classifications'] == 0){
								countAllown++;
							}else if(v['classifications'] == 1){
								countDeduct++;
							}
						}
					});

					var defclm = 1;
					var tot_count = parseFloat(countAllown) + parseFloat(defclm);

					var manual_feed_total = data.manual_feed_total;
					var fix_allow_from_emp = data.fix_allow_from_emp;
					var fix_deduct_from_emp = data.fix_deduct_from_emp;

					$('#PayrollRresultmdl #linkedcolumns thead').remove();
					$('#PayrollRresultmdl #linkedcolumns tbody').remove();

					var allow_and_deduct_data = '<thead>';
						allow_and_deduct_data +='<tr><th colspan="'+tot_count+'" class="tal text-danger"><?=$lng['DETAILS ALLOWANCES & DEDUCTIONS']?></th></tr>';
						allow_and_deduct_data +='<tr>';
						allow_and_deduct_data +='<th class="tac"><?=$lng['Month']?></th>';

						var countClm = 0;
						var clmnval;
						$.each(payroll_datas, function(k1,v){

							if(v['allow_deduct_ids'] !=''){
								var k1=v['allow_deduct_ids'];
								if(v['classifications'] == 0){
									countClm++;

									if(allowance_deduct_name[k1] == undefined){ clmnval = allowDdtEmp_name[k1];}else{ clmnval = allowance_deduct_name[k1];}
									allow_and_deduct_data +='<th class="tac '+v['groups']+'">'+clmnval+'</th>';
								}
							}
						})
						
						allow_and_deduct_data +='</tr>';
						allow_and_deduct_data +='</thead>';

						allow_and_deduct_data +='<tbody>';
							var i;
							for(i=1; i <=12 ; i++){

								allow_and_deduct_data +='<tr><td class="tac font-weight-bold">'+short_months[i]+'-'+curryear+'</td>';
								
								var currMnths = '';
								if(i == currmnth){
									currMnths='currMnths';
								}else if(i > currmnth){
									currMnths='upcommMnths';
								}else{
									currMnths='prevMnth';
								}

								var crmth_manual_feed = 0.00;
								var prmth_manual_feed = 0.00;
								var pnd1 = '';
								var sso = '';
								var pvf = '';
								var psf = '';

								$.each(payroll_datas, function(k1,v){

									if(v['allow_deduct_ids'] !=''){
										var k = v['allow_deduct_ids'];
										if(v['classifications'] == 0){

											var monthss = short_months[i];
											var monthssLower = monthss.toLowerCase();
											
											if(currMnths == 'prevMnth'){
												if(payroll_datas_prev[i].hasOwnProperty(k)){
													crmth_manual_feed = payroll_datas_prev[i][k][monthssLower]; 
												}else{
													crmth_manual_feed = 0.00;
												}
											}else{
												crmth_manual_feed = v[monthssLower];
											}

											if(crmth_manual_feed == ''){crmth_manual_feed=0.00;};
											
											if(v['pnd'] == 1){ pnd1 = 'pnd1';}else{ pnd1 = '';}
											if(v['sso'] == 1){ sso = 'sso';}else{ sso = '';}
											if(v['pvf'] == 1){ pvf = 'pvf';}else{ pvf = '';}
											if(v['psf'] == 1){ psf = 'psf';}else{ psf = '';}

											allow_and_deduct_data +='<td class="tar '+currMnths+' '+pnd1+' '+sso+' '+pvf+' '+psf+' '+v['groups']+'">'+number_format(crmth_manual_feed)+'</td>';
										}
									}
								})

								allow_and_deduct_data +='</tr>';
							}

						allow_and_deduct_data +='</tbody>';
						$('#PayrollRresultmdl #linkedcolumns').append(allow_and_deduct_data);
					//===================== Right side table data end ======================//

					//===================== Right side table data Start (Deduction) ======================//
					var defclmd = 1;
					var tot_count = parseFloat(countDeduct) + parseFloat(defclmd);

					//console.log(manual_feed_total);
					$('#PayrollRresultmdl #linkedcolumnsD thead').remove();
					$('#PayrollRresultmdl #linkedcolumnsD tbody').remove();

					var deduct_data = '<thead>';
						deduct_data +='<tr>';
						deduct_data +='<th class="tac"><?=$lng['Month']?></th>';

						var countClm = 0;
						$.each(payroll_datas, function(k1,v){
							if(v['allow_deduct_ids'] !=''){
								var k = v['allow_deduct_ids'];
								if(v['classifications'] == 1){
									countClm++;
									if(allowance_deduct_name[k] == undefined){ clmnval = allowDdtEmp_name[k];}else{ clmnval = allowance_deduct_name[k];}
									deduct_data +='<th class="tac '+v['groups']+'">'+clmnval+'</th>';
								}
							}
						})
						
						deduct_data +='</tr>';
						deduct_data +='</thead>';

						deduct_data +='<tbody>';
							var i;
							for(i=1; i <=12 ; i++){
								deduct_data +='<tr><td class="tac font-weight-bold">'+short_months[i]+'-'+curryear+'</td>';
								
								var currMnths = '';
								if(i == currmnth){
									currMnths='currMnths';
								}else if(i > currmnth){
									currMnths='upcommMnths';
								}else{
									currMnths='prevMnth';
								}

								var crmth_manual_feed = 0.00;
								var prmth_manual_feed = 0.00;
								var pnd1 = '';
								var sso = '';
								var pvf = '';
								var psf = '';
								var extracls = '';
								var extraTax = '';
								
								$.each(payroll_datas, function(k1,v){

									if(v['allow_deduct_ids'] !=''){
										var k = v['allow_deduct_ids'];
										if(v['classifications'] == 1){

											var monthss = short_months[i];
											var monthssLower = monthss.toLowerCase();
											
											if(currMnths == 'prevMnth'){
												if(payroll_datas_prev[i].hasOwnProperty(k)){
													crmth_manual_feed = payroll_datas_prev[i][k][monthssLower]; 
												}else{
													crmth_manual_feed = 0.00;
												}
											}else{
												crmth_manual_feed = v[monthssLower];
											}

											if(v['pnd'] == 1){ pnd1 = 'pnd1';}else{ pnd1 = '';}
											if(v['sso'] == 1){ sso = 'sso';}else{ sso = '';}
											if(v['pvf'] == 1){ pvf = 'pvf';}else{ pvf = '';}
											if(v['psf'] == 1){ psf = 'psf';}else{ psf = '';}

											deduct_data +='<td class="tar '+currMnths+' '+pnd1+' '+sso+' '+pvf+' '+psf+' '+extracls+' '+extraTax+' '+v['groups']+'">'+number_format(crmth_manual_feed)+'</td>';

										}
									}
								})

								deduct_data +='</tr>';
							}

						deduct_data +='</tbody>';
						$('#PayrollRresultmdl #linkedcolumnsD').append(deduct_data);
					//===================== Right side table data end ======================//


					$('#PayrollRresultmdl #empids').text(data[0].emp_id);
					$('#PayrollRresultmdl #deptval').text(data.department);
					$('#PayrollRresultmdl #contract_type').text(data.contract_type);
					$('#PayrollRresultmdl #calc_tax').text(data.calc_tax);
					$('#PayrollRresultmdl #calc_sso').text(data.calc_sso);


					$('#PayrollRresultmdl #emp_name').text(data[0].emp_name_en);
					$('#PayrollRresultmdl #teamval').text(data.team);
					$('#PayrollRresultmdl #tax_calc_method').text(data[0].calc_method);

				
					if(data.calc_pvf == 'Yes'){
						$('#PayrollRresultmdl #pvfpsfLbl').text('<?=$lng['Calculate PVF']?>');
						$('#PayrollRresultmdl #calc_pvf').text(data.calc_pvf);
					}else if(data.calc_psf == 'Yes'){
						$('#PayrollRresultmdl #pvfpsfLbl').text('<?=$lng['Calculate PSF']?>');
						$('#PayrollRresultmdl #calc_pvf').text(data.calc_psf);
					}else{
						$('#PayrollRresultmdl #pvfpsfLbl').text('');
						$('#PayrollRresultmdl #calc_pvf').text('');
					}
					
					//$('#PayrollRresultmdl #calc_psf').text(data.calc_psf);

					$('#PayrollRresultmdl #position_val').text(data.position);
					$('#PayrollRresultmdl #calc_base').text(data.calc_base);

					$('#PayrollRresultmdl #ear_curr_calc').text(number_format(data[0].total_earnings));
					$('#PayrollRresultmdl #ear_curr_mnth').text(number_format(data[0].total_earnings));
					$('#PayrollRresultmdl #ear_prev_mnth').text(number_format(data[0].total_earnings_prev));
					$('#PayrollRresultmdl #ear_full_year').text(number_format(data[0].full_year_earnings));

					$('#PayrollRresultmdl #ded_curr_calc').text(number_format(data[0].total_deductions));
					$('#PayrollRresultmdl #ded_curr_mnth').text(number_format(data[0].total_deductions));
					$('#PayrollRresultmdl #ded_prev_mnth').text(number_format(data[0].total_deductions_prev));
					$('#PayrollRresultmdl #ded_full_year').text(number_format(data[0].full_year_deductions));

					$('#PayrollRresultmdl #pnd_curr_calc').text(number_format(data[0].total_pnd1));
					$('#PayrollRresultmdl #pnd_curr_mnth').text(number_format(data[0].total_pnd1));
					$('#PayrollRresultmdl #pnd_prev_mnth').text(number_format(data[0].total_pnd1_prev));
					$('#PayrollRresultmdl #pnd_full_year').text(number_format(data[0].full_year_pnd));

					$('#PayrollRresultmdl #sso_curr_calc').text(number_format(data[0].total_sso));
					$('#PayrollRresultmdl #sso_curr_mnth').text(number_format(data[0].total_sso));
					$('#PayrollRresultmdl #sso_prev_mnth').text(number_format(data[0].total_sso_prev));
					$('#PayrollRresultmdl #sso_full_year').text(number_format(data[0].full_year_sso));

					$('#PayrollRresultmdl #pvf_curr_calc').text(number_format(data[0].total_pvf));
					$('#PayrollRresultmdl #pvf_curr_mnth').text(number_format(data[0].total_pvf));
					$('#PayrollRresultmdl #pvf_prev_mnth').text(number_format(data[0].total_pvf_prev));
					$('#PayrollRresultmdl #pvf_full_year').text(number_format(data[0].full_year_pvf));

					$('#PayrollRresultmdl #psf_curr_calc').text(number_format(data[0].total_psf));
					$('#PayrollRresultmdl #psf_curr_mnth').text(number_format(data[0].total_psf));
					$('#PayrollRresultmdl #psf_prev_mnth').text(number_format(data[0].total_psf_prev));
					$('#PayrollRresultmdl #psf_full_year').text(number_format(data[0].full_year_psf));


					$('#PayrollRresultmdl #inc_sal_calc').text(number_format(data[0].salary_group_total));
					$('#PayrollRresultmdl #inc_fix_calc').text(number_format(data[0].fix_income_group_total));
					$('#PayrollRresultmdl #inc_ot_calc').text(number_format(data[0].overtime_group_total));
					$('#PayrollRresultmdl #inc_var_calc').text(number_format(data[0].var_income_group_total));
					$('#PayrollRresultmdl #inc_oth_calc').text(number_format(data[0].other_income_group_total));
					$('#PayrollRresultmdl #ded_abs_calc').text(number_format(data[0].absence_group_total));
					$('#PayrollRresultmdl #ded_fix_calc').text(number_format(data[0].fix_ded_group_total));
					$('#PayrollRresultmdl #ded_var_calc').text(number_format(data[0].var_ded_group_total));
					$('#PayrollRresultmdl #ded_oth_calc').text(number_format(data[0].other_ded_group_total));
					$('#PayrollRresultmdl #ded_leg_calc').text(number_format(data[0].legal_ded_group_total));
					$('#PayrollRresultmdl #ded_pay_calc').text(number_format(data[0].advance_pay_group_total));

					$('#PayrollRresultmdl #inc_sal').text(number_format(data[0].salary_group_total));
					$('#PayrollRresultmdl #inc_fix').text(number_format(data[0].fix_income_group_total));
					$('#PayrollRresultmdl #inc_ot').text(number_format(data[0].overtime_group_total));
					$('#PayrollRresultmdl #inc_var').text(number_format(data[0].var_income_group_total));
					$('#PayrollRresultmdl #inc_oth').text(number_format(data[0].other_income_group_total));
					$('#PayrollRresultmdl #ded_abs').text(number_format(data[0].absence_group_total));
					$('#PayrollRresultmdl #ded_fix').text(number_format(data[0].fix_ded_group_total));
					$('#PayrollRresultmdl #ded_var').text(number_format(data[0].var_ded_group_total));
					$('#PayrollRresultmdl #ded_oth').text(number_format(data[0].other_ded_group_total));
					$('#PayrollRresultmdl #ded_leg').text(number_format(data[0].legal_ded_group_total));
					$('#PayrollRresultmdl #ded_pay').text(number_format(data[0].advance_pay_group_total));

					$('#PayrollRresultmdl #inc_sal_prev').text(number_format(data[0].salary_group_total_prev));
					$('#PayrollRresultmdl #inc_fix_prev').text(number_format(data[0].fix_income_group_total_prev));
					$('#PayrollRresultmdl #inc_ot_prev').text(number_format(data[0].overtime_group_total_prev));
					$('#PayrollRresultmdl #inc_var_prev').text(number_format(data[0].var_income_group_total_prev));
					$('#PayrollRresultmdl #inc_oth_prev').text(number_format(data[0].other_income_group_total_prev));
					$('#PayrollRresultmdl #ded_abs_prev').text(number_format(data[0].absence_group_total_prev));
					$('#PayrollRresultmdl #ded_fix_prev').text(number_format(data[0].fix_ded_group_total_prev));
					$('#PayrollRresultmdl #ded_var_prev').text(number_format(data[0].var_ded_group_total_prev));
					$('#PayrollRresultmdl #ded_oth_prev').text(number_format(data[0].other_ded_group_total_prev));
					$('#PayrollRresultmdl #ded_leg_prev').text(number_format(data[0].legal_ded_group_total_prev));
					$('#PayrollRresultmdl #ded_pay_prev').text(number_format(data[0].advance_pay_group_total_prev));

					$('#PayrollRresultmdl #inc_sal_fullY').text(number_format(data[0].full_year_salary_grp));
					$('#PayrollRresultmdl #inc_fix_fullY').text(number_format(data[0].full_year_fixincome_grp));
					$('#PayrollRresultmdl #inc_ot_fullY').text(number_format(data[0].full_year_overtime_grp));
					$('#PayrollRresultmdl #inc_var_fullY').text(number_format(data[0].full_year_varincome_grp));
					$('#PayrollRresultmdl #inc_oth_fullY').text(number_format(data[0].full_year_othincome_grp));
					$('#PayrollRresultmdl #ded_abs_fullY').text(number_format(data[0].full_year_absence_grp));
					$('#PayrollRresultmdl #ded_fix_fullY').text(number_format(data[0].full_year_fixded_grp));
					$('#PayrollRresultmdl #ded_var_fullY').text(number_format(data[0].full_year_varded_grp));
					$('#PayrollRresultmdl #ded_oth_fullY').text(number_format(data[0].full_year_othded_grp));
					$('#PayrollRresultmdl #ded_leg_fullY').text(number_format(data[0].full_year_legal_grp));
					$('#PayrollRresultmdl #ded_pay_fullY').text(number_format(data[0].full_year_advpay_grp));

					
					$('#PayrollRresultmdl #pr_sso_emplyr_calc').text(number_format(data[0].sso_company));
					$('#PayrollRresultmdl #pr_pvf_emplyr_calc').text(number_format(data[0].pvf_company));
					$('#PayrollRresultmdl #pr_psf_emplyr_calc').text(number_format(data[0].psf_company));

					$('#PayrollRresultmdl #pr_sso_emplyr').text(number_format(data[0].sso_company));
					$('#PayrollRresultmdl #pr_pvf_emplyr').text(number_format(data[0].pvf_company));
					$('#PayrollRresultmdl #pr_psf_emplyr').text(number_format(data[0].psf_company));

					$('#PayrollRresultmdl #total_net_income_cur_cal').text(number_format(data[0].total_net_income));
					$('#PayrollRresultmdl #total_net_income_cur_mnth').text(number_format(data[0].total_net_income));
					$('#PayrollRresultmdl #total_net_income_prev_mnth').text(number_format(data[0].total_net_income_prev));
					$('#PayrollRresultmdl #total_net_income_fullyear').text(number_format(data[0].fullyear_net_income));


					$('#PayrollRresultmdl #total_net_pay_cur_cal').text(number_format(data[0].total_net_pay));
					$('#PayrollRresultmdl #total_net_pay_cur_mnth').text(number_format(data[0].total_net_pay));
					$('#PayrollRresultmdl #total_net_pay_prev_mnth').text(number_format(data[0].total_net_pay_prev));
					$('#PayrollRresultmdl #total_net_pay_fullyear').text(number_format(data[0].fullyear_net_pay));

					$('#PayrollRresultmdl').modal('show');

					$('#linkedcolumns').DataTable().destroy();
					$('#linkedcolumnsD').DataTable().destroy();


					var dtablesmdl = $('#linkedcolumns').DataTable({
						
						lengthChange: false,
						searching: false,
						ordering: false,
						paging: false,
						pageLength: 12,
						filter: false,
						info: false,
						responsive: false,
						<?=$dtable_lang?>
						// columnDefs: [
						// 	{"targets": eColsMdlA, "visible": false, "searchable": false}
						// ],
					});

					var dtablesmdld = $('#linkedcolumnsD').DataTable({
						
						lengthChange: false,
						searching: false,
						ordering: false,
						paging: false,
						pageLength: 12,
						filter: false,
						info: false,
						responsive: false,
						<?=$dtable_lang?>
						// columnDefs: [
						// 	{"targets": eColsMdlD, "visible": false, "searchable": false}
						// ],
					});


				}
			}
		})
	}

	function closeBtn2(){

		$('#linkedcolumns').DataTable().destroy();
		$('#linkedcolumnsD').DataTable().destroy();

		$('#PayrollRresultmdl').modal('hide');
	}

	/*function payrollResultPopups(that){

		var empid = that.id;
		var currmnth = <?=$_SESSION['rego']['cur_month']?>;
		var mid = '<?=$_GET['mid']?>';

		var get_prev_months_allowancesdeductss = '';
		if(currmnth > 1){
			get_prev_months_allowancesdeductss = get_prev_months_allowancesdeduct(empid);
		}
		
		$.ajax({
			type: 'post',
			url: "ajax/get_payroll_data.php",
			data: {empid: empid,mid:mid},
			success: function(result){

				if(result == 'error'){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: '+ result,
						duration: 3,
						callback: function(v){
							window.location.reload();
						}
					})
				}else{

					var data = JSON.parse(result);
					console.log(data);

					//===================== Right side table data start (Allowances) ======================//
					var eColsMdlA = <?=$eColsMdlA?>;
					var eColsMdlD = <?=$eColsMdlD?>;
					
					var short_months = <?=json_encode($short_months)?>;
					var payrollparametersformonth =<?=json_encode(array_values($payrollparametersformonth))?>;
					var allowance_deduct_name = <?=json_encode($allowDdt)?>;
					var allowDdtEmp_name = <?=json_encode($allowDdtEmp)?>;
					var curryear = <?=substr($_SESSION['rego']['cur_year'], -2)?>;
					var remaining_mnth = 12 - currmnth + 1;

					//console.log(payrollparametersformonth);
					var ssoEmpRates = data[0].ssoEmpRates;

					var countAllown = 0;
					var countDeduct = 0;
					$.each(payrollparametersformonth, function(k,v){

						if(v['classification'] == 0){
							countAllown++;
						}else if(v['classification'] == 1){
							countDeduct++;
						}
					});

					var manual_feed_total = data.manual_feed_total;
					var fix_allow_from_emp = data.fix_allow_from_emp;
					var fix_deduct_from_emp = data.fix_deduct_from_emp;
					

					var defclm = 1;
					var tot_count = parseFloat(countAllown) + parseFloat(defclm);

					//console.log(manual_feed_total);
					$('#PayrollRresultmdl #linkedcolumns thead').remove();
					$('#PayrollRresultmdl #linkedcolumns tbody').remove();

					var allow_and_deduct_data = '<thead>';
						allow_and_deduct_data +='<tr><th colspan="'+tot_count+'" class="tal text-danger"><?=$lng['DETAILS ALLOWANCES & DEDUCTIONS']?></th></tr>';
						allow_and_deduct_data +='<tr>';
						allow_and_deduct_data +='<th class="tac"><?=$lng['Month']?></th>';

						var countClm = 0;
						var clmnval;
						$.each(payrollparametersformonth, function(k1,v){
							if(v['classification'] == 0){
								var k = v['id'];
								countClm++;
								if(allowance_deduct_name[k] == undefined){ clmnval = allowDdtEmp_name[k];}else{ clmnval = allowance_deduct_name[k];}
								allow_and_deduct_data +='<th class="tac '+v['groups']+'">'+clmnval+'</th>';
							}
						})
						
						allow_and_deduct_data +='</tr>';
						allow_and_deduct_data +='</thead>';

						allow_and_deduct_data +='<tbody>';
							var i;
							for(i=1; i <=12 ; i++){
								allow_and_deduct_data +='<tr><td class="tac font-weight-bold">'+short_months[i]+'-'+curryear+'</td>';
								
								var currMnths = '';
								var crmth_manual_feed = 0.00;
								var prmth_manual_feed = 0.00;
								var pnd1 = '';
								var sso = '';
								var pvf = '';
								var psf = '';
								
								$.each(payrollparametersformonth, function(k1,v){
									var k = v['id'];
									if(v['classification'] == 0){
										if(currmnth == i){ 
											currMnths = 'currMnths'; 

											if(fix_allow_from_emp.hasOwnProperty(k)){
												crmth_manual_feed = (fix_allow_from_emp[k] > 0) ? fix_allow_from_emp[k] : 0.00; 
											}else{
												crmth_manual_feed = (manual_feed_total[k] > 0) ? manual_feed_total[k] : 0.00; 
											}
											//alert(crmth_manual_feed);

											//crmth_manual_feed = (manual_feed_total[k] > 0) ? manual_feed_total[k] : 0.00; 
											

											if(k == 27){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].tax_by_company); }
											if(k == 28){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].sso_by_company); }
											if(k == 29){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].severance); }
											if(k == 31){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].remaining_salary); }
											if(k == 32){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].notice_payment); }
											if(k == 33){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].paid_leave); }
											
											if(k == 56){ 
												if(data[0].contract_type == 'day'){var dsaly=data[0].mf_salary;}else{var dsaly=data[0].salary;}
												crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(dsaly); 
											}

											//crmth_manual_feed = crmth_manual_feed.toFixed(2);
										
											if(v['pnd'] == 1){ pnd1 = 'pnd1';}else{ pnd1 = '';}
											if(v['sso'] == 1){ sso = 'sso';}else{ sso = '';}
											if(v['pvf'] == 1){ pvf = 'pvf';}else{ pvf = '';}
											if(v['psf'] == 1){ psf = 'psf';}else{ psf = '';}

											allow_and_deduct_data +='<td class="tar '+currMnths+' '+pnd1+' '+sso+' '+pvf+' '+psf+' '+v['groups']+'">'+number_format(crmth_manual_feed)+'</td>';
											
										}else if(currmnth > i){ 

											if(get_prev_months_allowancesdeductss[i] == '[object Object]'){
												prmth_manual_feed = (get_prev_months_allowancesdeductss[i][k] > 0) ? get_prev_months_allowancesdeductss[i][k] : 0.00;
												if(v['groups'] == 'inc_sal'){
													prmth_manual_feed = parseFloat(prmth_manual_feed) + parseFloat(data[0].salary);
												}
											}

											if(v['pnd'] == 1){ pnd1 = 'pnd1';}else{ pnd1 = '';}
											if(v['sso'] == 1){ sso = 'sso';}else{ sso = '';}
											if(v['pvf'] == 1){ pvf = 'pvf';}else{ pvf = '';}
											if(v['psf'] == 1){ psf = 'psf';}else{ psf = '';}

											allow_and_deduct_data +='<td class="tar prevMnth '+pnd1+' '+sso+' '+pvf+' '+psf+' '+v['groups']+'">'+number_format(prmth_manual_feed)+'</td>';
										}else{

											if(v['pnd'] == 1){ pnd1 = 'pnd1';}else{ pnd1 = '';}
											if(v['sso'] == 1){ sso = 'sso';}else{ sso = '';}
											if(v['pvf'] == 1){ pvf = 'pvf';}else{ pvf = '';}
											if(v['psf'] == 1){ psf = 'psf';}else{ psf = '';}
											currMnths = 'upcommMnths'; 

											if(v['tax_base'] == 'fixpro'){

												if(fix_allow_from_emp.hasOwnProperty(k)){
													crmth_manual_feed = (fix_allow_from_emp[k] > 0) ? fix_allow_from_emp[k] : 0.00; 
												}else{
													crmth_manual_feed = (manual_feed_total[k] > 0) ? manual_feed_total[k] : 0.00; 
												}

												if(k == 27){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].tax_by_company); }
												if(k == 28){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].sso_by_company); }
												if(k == 29){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].severance); }
												if(k == 31){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].remaining_salary); }
												if(k == 32){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].notice_payment); }
												if(k == 33){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].paid_leave); }
												if(k == 56){ 
													if(data[0].contract_type == 'day'){var dsaly=data[0].mf_salary;}else{var dsaly=data[0].salary;}
													crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(dsaly); 
												}


												
												//crmth_manual_feed = crmth_manual_feed.toFixed(2);
												allow_and_deduct_data +='<td class="tar '+currMnths+' '+pnd1+' '+sso+' '+pvf+' '+psf+' '+v['groups']+'">'+number_format(crmth_manual_feed)+'</td>';
											}else{
												allow_and_deduct_data +='<td class="tar '+currMnths+' '+pnd1+' '+sso+' '+pvf+' '+psf+' '+v['groups']+'">0.00</td>';
											}
										}
									}
								})

								allow_and_deduct_data +='</tr>';
							}
						allow_and_deduct_data +='</tbody>';
									
					$('#PayrollRresultmdl #linkedcolumns').append(allow_and_deduct_data);
					//===================== Right side table data end ======================//

					//===================== Right side table data Start (Deduction) ======================//
					var defclmd = 1;
					var tot_count = parseFloat(countDeduct) + parseFloat(defclmd);

					//console.log(manual_feed_total);
					$('#PayrollRresultmdl #linkedcolumnsD thead').remove();
					$('#PayrollRresultmdl #linkedcolumnsD tbody').remove();

					var deduct_data = '<thead>';
						//allow_and_deduct_data +='<tr><th colspan="'+tot_count+'" class="tac text-danger"><?=$lng['DETAILS ALLOWANCES & DEDUCTIONS']?></th></tr>';
						deduct_data +='<tr>';
						deduct_data +='<th class="tac"><?=$lng['Month']?></th>';

						var countClm = 0;
						$.each(payrollparametersformonth, function(k1,v){
							var k = v['id'];
							if(v['classification'] == 1){
								countClm++;
								if(allowance_deduct_name[k] == undefined){ clmnval = allowDdtEmp_name[k];}else{ clmnval = allowance_deduct_name[k];}
								deduct_data +='<th class="tac '+v['groups']+'">'+clmnval+'</th>';
							}
						})
						
						deduct_data +='</tr>';
						deduct_data +='</thead>';

						deduct_data +='<tbody>';
							var i;
							for(i=1; i <=12 ; i++){
								deduct_data +='<tr><td class="tac font-weight-bold">'+short_months[i]+'-'+curryear+'</td>';
								
								var currMnths = '';
								var crmth_manual_feed = '';
								var prmth_manual_feed = '';
								var pnd1 = '';
								var sso = '';
								var pvf = '';
								var psf = '';
								var extracls = '';
								var extraTax = '';
								
								$.each(payrollparametersformonth, function(k1,v){

									var k = v['id'];
									if(v['classification'] == 1){
										if(currmnth == i){ 
											currMnths = 'currMnths'; 

											if(fix_deduct_from_emp.hasOwnProperty(k)){
												crmth_manual_feed = (fix_deduct_from_emp[k] > 0) ? fix_deduct_from_emp[k] : 0; 
											}else{
												crmth_manual_feed = (manual_feed_total[k] > 0) ? manual_feed_total[k] : 0; 
											}

											if(k == 47){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].savings); }
											if(k == 48){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].legal_execution); }
											if(k == 49){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].kor_yor_sor); }
											if(k == 57){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].sso_employee); extracls="ssocurr";}else{ extracls="";}
											if(k == 58){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].pvf_employee); }
											if(k == 59){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].psf_employee); }
											if(k == 60){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].tax_this_month); extraTax="exTax";}else{ extraTax="";}

											//crmth_manual_feed = (manual_feed_total[k] > 0) ? manual_feed_total[k] : 0; 
										
											if(v['pnd'] == 1){ pnd1 = 'pnd1';}else{ pnd1 = '';}
											if(v['sso'] == 1){ sso = 'sso';}else{ sso = '';}
											if(v['pvf'] == 1){ pvf = 'pvf';}else{ pvf = '';}
											if(v['psf'] == 1){ psf = 'psf';}else{ psf = '';}

											deduct_data +='<td class="tar '+currMnths+' '+pnd1+' '+sso+' '+pvf+' '+psf+' '+extracls+' '+extraTax+' '+v['groups']+'">'+number_format(crmth_manual_feed)+'</td>';
											
										}else if(currmnth > i){ 

											if(get_prev_months_allowancesdeductss[i] == '[object Object]'){
												prmth_manual_feed = (get_prev_months_allowancesdeductss[i][k] > 0) ? get_prev_months_allowancesdeductss[i][k] : 0;
											}

											if(v['pnd'] == 1){ pnd1 = 'pnd1';}else{ pnd1 = '';}
											if(v['sso'] == 1){ sso = 'sso';}else{ sso = '';}
											if(v['pvf'] == 1){ pvf = 'pvf';}else{ pvf = '';}
											if(v['psf'] == 1){ psf = 'psf';}else{ psf = '';}

											deduct_data +='<td class="tar prevMnth '+pnd1+' '+sso+' '+pvf+' '+psf+' '+v['groups']+'">'+number_format(prmth_manual_feed)+'</td>';
										}else{
											
											if(v['pnd'] == 1){ pnd1 = 'pnd1';}else{ pnd1 = '';}
											if(v['sso'] == 1){ sso = 'sso';}else{ sso = '';}
											if(v['pvf'] == 1){ pvf = 'pvf';}else{ pvf = '';}
											if(v['psf'] == 1){ psf = 'psf';}else{ psf = '';}
											currMnths = 'upcommMnths'; 

											if(v['tax_base'] == 'fixpro'){

												if(fix_deduct_from_emp.hasOwnProperty(k)){
													crmth_manual_feed = (fix_deduct_from_emp[k] > 0) ? fix_deduct_from_emp[k] : 0; 
												}else{
													crmth_manual_feed = (manual_feed_total[k] > 0) ? manual_feed_total[k] : 0; 
												}

												if(k == 47){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].savings); }
												if(k == 48){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].legal_execution); }
												if(k == 49){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].kor_yor_sor); }
												if(k == 57){ 
													var sso_thb = data[0].sso_employee;
													crmth_manual_feed = parseFloat(sso_thb); 
												}
												if(k == 58){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].pvf_employee); }
												if(k == 59){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].psf_employee); }
												if(k == 60){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].tax_next_month); }

												//crmth_manual_feed = (manual_feed_total[k] > 0) ? manual_feed_total[k] : 0;

												deduct_data +='<td class="tar '+currMnths+' '+pnd1+' '+sso+' '+pvf+' '+psf+' '+v['groups']+'">'+number_format(crmth_manual_feed)+'</td>';
											}else{

												if(k == 57){ 
													var sso_thb = data[0].sso_employee;
													crmth_manual_feed = parseFloat(sso_thb); 
												}
												if(k == 60){ crmth_manual_feed = parseFloat(data[0].tax_next_month); }
												
												deduct_data +='<td class="tar '+currMnths+' '+pnd1+' '+sso+' '+pvf+' '+psf+' '+v['groups']+'">'+number_format(crmth_manual_feed)+'</td>';
											}
										}
									}
								})

								deduct_data +='</tr>';
							}
						deduct_data +='</tbody>';
									
					$('#PayrollRresultmdl #linkedcolumnsD').append(deduct_data);
					//===================== Right side table data end ======================//


					$('#PayrollRresultmdl #empids').text(data[0].emp_id);
					$('#PayrollRresultmdl #deptval').text(data.department);
					$('#PayrollRresultmdl #contract_type').text(data.contract_type);
					$('#PayrollRresultmdl #calc_tax').text(data.calc_tax);
					$('#PayrollRresultmdl #calc_sso').text(data.calc_sso);


					$('#PayrollRresultmdl #emp_name').text(data[0].emp_name_en);
					$('#PayrollRresultmdl #teamval').text(data.team);
					$('#PayrollRresultmdl #tax_calc_method').text(data[0].calc_method);

				
					if(data.calc_pvf == 'Yes'){
						$('#PayrollRresultmdl #pvfpsfLbl').text('<?=$lng['Calculate PVF']?>');
						$('#PayrollRresultmdl #calc_pvf').text(data.calc_pvf);
					}else if(data.calc_psf == 'Yes'){
						$('#PayrollRresultmdl #pvfpsfLbl').text('<?=$lng['Calculate PSF']?>');
						$('#PayrollRresultmdl #calc_pvf').text(data.calc_psf);
					}else{
						$('#PayrollRresultmdl #pvfpsfLbl').text('');
						$('#PayrollRresultmdl #calc_pvf').text('');
					}
					
					//$('#PayrollRresultmdl #calc_psf').text(data.calc_psf);

					$('#PayrollRresultmdl #position_val').text(data.position);
					$('#PayrollRresultmdl #calc_base').text(data.calc_base);

					$('#PayrollRresultmdl #ear_curr_calc').text(number_format(data[0].total_earnings));
					$('#PayrollRresultmdl #ear_curr_mnth').text(number_format(data[0].total_earnings));
					$('#PayrollRresultmdl #ear_prev_mnth').text(number_format(data[0].total_earnings_prev));
					$('#PayrollRresultmdl #ear_full_year').text(number_format(data[0].full_year_earnings));

					$('#PayrollRresultmdl #ded_curr_calc').text(number_format(data[0].total_deductions));
					$('#PayrollRresultmdl #ded_curr_mnth').text(number_format(data[0].total_deductions));
					$('#PayrollRresultmdl #ded_prev_mnth').text(number_format(data[0].total_deductions_prev));
					$('#PayrollRresultmdl #ded_full_year').text(number_format(data[0].full_year_deductions));

					$('#PayrollRresultmdl #pnd_curr_calc').text(number_format(data[0].total_pnd1));
					$('#PayrollRresultmdl #pnd_curr_mnth').text(number_format(data[0].total_pnd1));
					$('#PayrollRresultmdl #pnd_prev_mnth').text(number_format(data[0].total_pnd1_prev));
					$('#PayrollRresultmdl #pnd_full_year').text(number_format(data[0].full_year_pnd));

					$('#PayrollRresultmdl #sso_curr_calc').text(number_format(data[0].total_sso));
					$('#PayrollRresultmdl #sso_curr_mnth').text(number_format(data[0].total_sso));
					$('#PayrollRresultmdl #sso_prev_mnth').text(number_format(data[0].total_sso_prev));
					$('#PayrollRresultmdl #sso_full_year').text(number_format(data[0].full_year_sso));

					$('#PayrollRresultmdl #pvf_curr_calc').text(number_format(data[0].total_pvf));
					$('#PayrollRresultmdl #pvf_curr_mnth').text(number_format(data[0].total_pvf));
					$('#PayrollRresultmdl #pvf_prev_mnth').text(number_format(data[0].total_pvf_prev));
					$('#PayrollRresultmdl #pvf_full_year').text(number_format(data[0].full_year_pvf));

					$('#PayrollRresultmdl #psf_curr_calc').text(number_format(data[0].total_psf));
					$('#PayrollRresultmdl #psf_curr_mnth').text(number_format(data[0].total_psf));
					$('#PayrollRresultmdl #psf_prev_mnth').text(number_format(data[0].total_psf_prev));
					$('#PayrollRresultmdl #psf_full_year').text(number_format(data[0].full_year_psf));


					$('#PayrollRresultmdl #inc_sal_calc').text(number_format(data[0].salary_group_total));
					$('#PayrollRresultmdl #inc_fix_calc').text(number_format(data[0].fix_income_group_total));
					$('#PayrollRresultmdl #inc_ot_calc').text(number_format(data[0].overtime_group_total));
					$('#PayrollRresultmdl #inc_var_calc').text(number_format(data[0].var_income_group_total));
					$('#PayrollRresultmdl #inc_oth_calc').text(number_format(data[0].other_income_group_total));
					$('#PayrollRresultmdl #ded_abs_calc').text(number_format(data[0].absence_group_total));
					$('#PayrollRresultmdl #ded_fix_calc').text(number_format(data[0].fix_ded_group_total));
					$('#PayrollRresultmdl #ded_var_calc').text(number_format(data[0].var_ded_group_total));
					$('#PayrollRresultmdl #ded_oth_calc').text(number_format(data[0].other_ded_group_total));
					$('#PayrollRresultmdl #ded_leg_calc').text(number_format(data[0].legal_ded_group_total));
					$('#PayrollRresultmdl #ded_pay_calc').text(number_format(data[0].advance_pay_group_total));

					$('#PayrollRresultmdl #inc_sal').text(number_format(data[0].salary_group_total));
					$('#PayrollRresultmdl #inc_fix').text(number_format(data[0].fix_income_group_total));
					$('#PayrollRresultmdl #inc_ot').text(number_format(data[0].overtime_group_total));
					$('#PayrollRresultmdl #inc_var').text(number_format(data[0].var_income_group_total));
					$('#PayrollRresultmdl #inc_oth').text(number_format(data[0].other_income_group_total));
					$('#PayrollRresultmdl #ded_abs').text(number_format(data[0].absence_group_total));
					$('#PayrollRresultmdl #ded_fix').text(number_format(data[0].fix_ded_group_total));
					$('#PayrollRresultmdl #ded_var').text(number_format(data[0].var_ded_group_total));
					$('#PayrollRresultmdl #ded_oth').text(number_format(data[0].other_ded_group_total));
					$('#PayrollRresultmdl #ded_leg').text(number_format(data[0].legal_ded_group_total));
					$('#PayrollRresultmdl #ded_pay').text(number_format(data[0].advance_pay_group_total));

					$('#PayrollRresultmdl #inc_sal_prev').text(number_format(data[0].salary_group_total_prev));
					$('#PayrollRresultmdl #inc_fix_prev').text(number_format(data[0].fix_income_group_total_prev));
					$('#PayrollRresultmdl #inc_ot_prev').text(number_format(data[0].overtime_group_total_prev));
					$('#PayrollRresultmdl #inc_var_prev').text(number_format(data[0].var_income_group_total_prev));
					$('#PayrollRresultmdl #inc_oth_prev').text(number_format(data[0].other_income_group_total_prev));
					$('#PayrollRresultmdl #ded_abs_prev').text(number_format(data[0].absence_group_total_prev));
					$('#PayrollRresultmdl #ded_fix_prev').text(number_format(data[0].fix_ded_group_total_prev));
					$('#PayrollRresultmdl #ded_var_prev').text(number_format(data[0].var_ded_group_total_prev));
					$('#PayrollRresultmdl #ded_oth_prev').text(number_format(data[0].other_ded_group_total_prev));
					$('#PayrollRresultmdl #ded_leg_prev').text(number_format(data[0].legal_ded_group_total_prev));
					$('#PayrollRresultmdl #ded_pay_prev').text(number_format(data[0].advance_pay_group_total_prev));

					$('#PayrollRresultmdl #inc_sal_fullY').text(number_format(data[0].full_year_salary_grp));
					$('#PayrollRresultmdl #inc_fix_fullY').text(number_format(data[0].full_year_fixincome_grp));
					$('#PayrollRresultmdl #inc_ot_fullY').text(number_format(data[0].full_year_overtime_grp));
					$('#PayrollRresultmdl #inc_var_fullY').text(number_format(data[0].full_year_varincome_grp));
					$('#PayrollRresultmdl #inc_oth_fullY').text(number_format(data[0].full_year_othincome_grp));
					$('#PayrollRresultmdl #ded_abs_fullY').text(number_format(data[0].full_year_absence_grp));
					$('#PayrollRresultmdl #ded_fix_fullY').text(number_format(data[0].full_year_fixded_grp));
					$('#PayrollRresultmdl #ded_var_fullY').text(number_format(data[0].full_year_varded_grp));
					$('#PayrollRresultmdl #ded_oth_fullY').text(number_format(data[0].full_year_othded_grp));
					$('#PayrollRresultmdl #ded_leg_fullY').text(number_format(data[0].full_year_legal_grp));
					$('#PayrollRresultmdl #ded_pay_fullY').text(number_format(data[0].full_year_advpay_grp));

					
					$('#PayrollRresultmdl #pr_sso_emplyr_calc').text(number_format(data[0].sso_company));
					$('#PayrollRresultmdl #pr_pvf_emplyr_calc').text(number_format(data[0].pvf_company));
					$('#PayrollRresultmdl #pr_psf_emplyr_calc').text(number_format(data[0].psf_company));

					$('#PayrollRresultmdl #pr_sso_emplyr').text(number_format(data[0].sso_company));
					$('#PayrollRresultmdl #pr_pvf_emplyr').text(number_format(data[0].pvf_company));
					$('#PayrollRresultmdl #pr_psf_emplyr').text(number_format(data[0].psf_company));

					$('#PayrollRresultmdl #total_net_income_cur_cal').text(number_format(data[0].total_net_income));
					$('#PayrollRresultmdl #total_net_income_cur_mnth').text(number_format(data[0].total_net_income));
					$('#PayrollRresultmdl #total_net_income_prev_mnth').text(number_format(data[0].total_net_income_prev));
					$('#PayrollRresultmdl #total_net_income_fullyear').text(number_format(data[0].fullyear_net_income));


					$('#PayrollRresultmdl #total_net_pay_cur_cal').text(number_format(data[0].total_net_pay));
					$('#PayrollRresultmdl #total_net_pay_cur_mnth').text(number_format(data[0].total_net_pay));
					$('#PayrollRresultmdl #total_net_pay_prev_mnth').text(number_format(data[0].total_net_pay_prev));
					$('#PayrollRresultmdl #total_net_pay_fullyear').text(number_format(data[0].fullyear_net_pay));

					$('#PayrollRresultmdl').modal('toggle');

					$('#linkedcolumns').DataTable().destroy();
					$('#linkedcolumnsD').DataTable().destroy();


					var dtablesmdl = $('#linkedcolumns').DataTable({
						
						lengthChange: false,
						searching: false,
						ordering: false,
						paging: false,
						pageLength: 12,
						filter: false,
						info: false,
						responsive: false,
						<?=$dtable_lang?>
						columnDefs: [
							{"targets": eColsMdlA, "visible": false, "searchable": false}
						],
					});

					var dtablesmdld = $('#linkedcolumnsD').DataTable({
						
						lengthChange: false,
						searching: false,
						ordering: false,
						paging: false,
						pageLength: 12,
						filter: false,
						info: false,
						responsive: false,
						<?=$dtable_lang?>
						columnDefs: [
							{"targets": eColsMdlD, "visible": false, "searchable": false}
						],
					});
				}
			}
		})		
	}*/

	function get_prev_months_allowancesdeduct(empid){
		// alert(empid);
		var data;
		if(empid !=''){
			$.ajax({
				type: 'post',
				url: "ajax/get_prev_allow_deduct.php",
				async: false,
				data: {empid: empid},
				success: function(result){
					data = JSON.parse(result);
				}
			})
		}
		return data;
	}

	$(document).ready(function(){
		$('#getlinkeddataPR tbody td').click(function(){

			if($(this).text() != 0.00){

				//alert($(this).text()); //currMnths 
				$('#getlinkeddataPR tbody td').removeClass('borderCls');

				$('#linkedcolumns tbody td').removeClass('borderCls');
				$('#linkedcolumnsD tbody td').removeClass('borderCls');

				$('#getlinkeddataPR tbody td#'+this.id).addClass('borderCls');

				//========= curr month highlight ==========//
				if(this.id == 'pnd_curr_mnth' || this.id == 'pnd_curr_calc'){
					$('#linkedcolumns tbody td.currMnths.pnd1').addClass('borderCls');
					$('#linkedcolumnsD tbody td.currMnths.pnd1').addClass('borderCls');
				}
				if(this.id == 'sso_curr_mnth' || this.id == 'sso_curr_calc'){
					$('#linkedcolumns tbody td.currMnths.sso').addClass('borderCls');
					$('#linkedcolumnsD tbody td.currMnths.sso').addClass('borderCls');
				}
				if(this.id == 'pvf_curr_mnth' || this.id == 'pvf_curr_calc'){
					$('#linkedcolumns tbody td.currMnths.pvf').addClass('borderCls');
					$('#linkedcolumnsD tbody td.currMnths.pvf').addClass('borderCls');
				}
				if(this.id == 'psf_curr_mnth' || this.id == 'psf_curr_calc'){
					$('#linkedcolumns tbody td.currMnths.psf').addClass('borderCls');
					$('#linkedcolumnsD tbody td.currMnths.psf').addClass('borderCls');
				}
				if(this.id == 'inc_sal' || this.id == 'inc_sal_calc' || this.id == 'ear_curr_mnth' || this.id == 'ear_curr_calc'){
					$('#linkedcolumns tbody td.currMnths.inc_sal').addClass('borderCls');
					$('#linkedcolumnsD tbody td.currMnths.inc_sal').addClass('borderCls');
				}
				if(this.id == 'inc_fix' || this.id == 'inc_fix_calc' || this.id == 'ear_curr_mnth' || this.id == 'ear_curr_calc'){
					$('#linkedcolumns tbody td.currMnths.inc_fix').addClass('borderCls');
					$('#linkedcolumnsD tbody td.currMnths.inc_fix').addClass('borderCls');
				}
				if(this.id == 'inc_ot' || this.id == 'inc_ot_calc' || this.id == 'ear_curr_mnth' || this.id == 'ear_curr_calc'){
					$('#linkedcolumns tbody td.currMnths.inc_ot').addClass('borderCls');
					$('#linkedcolumnsD tbody td.currMnths.inc_ot').addClass('borderCls');
				}
				if(this.id == 'inc_var' || this.id == 'inc_var_calc' || this.id == 'ear_curr_mnth' || this.id == 'ear_curr_calc'){
					$('#linkedcolumns tbody td.currMnths.inc_var').addClass('borderCls');
					$('#linkedcolumnsD tbody td.currMnths.inc_var').addClass('borderCls');
				}
				if(this.id == 'inc_oth' || this.id == 'inc_oth_calc' || this.id == 'ear_curr_mnth' || this.id == 'ear_curr_calc'){
					$('#linkedcolumns tbody td.currMnths.inc_oth').addClass('borderCls');
					$('#linkedcolumnsD tbody td.currMnths.inc_oth').addClass('borderCls');
				}
				if(this.id == 'ded_abs' || this.id == 'ded_abs_calc' || this.id == 'ded_curr_mnth' || this.id == 'ded_curr_calc'){
					$('#linkedcolumns tbody td.currMnths.ded_abs').addClass('borderCls');
					$('#linkedcolumnsD tbody td.currMnths.ded_abs').addClass('borderCls');
				}
				if(this.id == 'ded_fix' || this.id == 'ded_fix_calc' || this.id == 'ded_curr_mnth' || this.id == 'ded_curr_calc'){
					$('#linkedcolumns tbody td.currMnths.ded_fix').addClass('borderCls');
					$('#linkedcolumnsD tbody td.currMnths.ded_fix').addClass('borderCls');
				}
				if(this.id == 'ded_var' || this.id == 'ded_var_calc' || this.id == 'ded_curr_mnth' || this.id == 'ded_curr_calc'){
					$('#linkedcolumns tbody td.currMnths.ded_var').addClass('borderCls');
					$('#linkedcolumnsD tbody td.currMnths.ded_var').addClass('borderCls');
				}
				if(this.id == 'ded_oth' || this.id == 'ded_oth_calc' || this.id == 'ded_curr_mnth' || this.id == 'ded_curr_calc'){
					$('#linkedcolumns tbody td.currMnths.ded_oth').addClass('borderCls');
					$('#linkedcolumnsD tbody td.currMnths.ded_oth').addClass('borderCls');
				}
				if(this.id == 'ded_leg' || this.id == 'ded_leg_calc' || this.id == 'ded_curr_mnth' || this.id == 'ded_curr_calc'){
					$('#linkedcolumns tbody td.currMnths.ded_leg').addClass('borderCls');
					$('#linkedcolumnsD tbody td.currMnths.ded_leg').addClass('borderCls');
				}
				if(this.id == 'ded_pay' || this.id == 'ded_pay_calc' || this.id == 'ded_curr_mnth' || this.id == 'ded_curr_calc'){
					$('#linkedcolumns tbody td.currMnths.ded_pay').addClass('borderCls');
					$('#linkedcolumnsD tbody td.currMnths.ded_pay').addClass('borderCls');
				}

				//========= prev month highlight ==========//
				if(this.id == 'pnd_prev_mnth'){
					$('#linkedcolumns tbody td.prevMnth.pnd1').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.pnd1').addClass('borderCls');
				}
				if(this.id == 'sso_prev_mnth'){
					$('#linkedcolumns tbody td.prevMnth.sso').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.sso').addClass('borderCls');
				}
				if(this.id == 'pvf_prev_mnth'){
					$('#linkedcolumns tbody td.prevMnth.pvf').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.pvf').addClass('borderCls');
				}
				if(this.id == 'psf_prev_mnth'){
					$('#linkedcolumns tbody td.prevMnth.psf').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.psf').addClass('borderCls');
				}
				if(this.id == 'inc_sal_prev' || this.id == 'ear_prev_mnth'){
					$('#linkedcolumns tbody td.prevMnth.inc_sal').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.inc_sal').addClass('borderCls');
				}
				if(this.id == 'inc_fix_prev' || this.id == 'ear_prev_mnth'){
					$('#linkedcolumns tbody td.prevMnth.inc_fix').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.inc_fix').addClass('borderCls');
				}
				if(this.id == 'inc_ot_prev' || this.id == 'ear_prev_mnth'){
					$('#linkedcolumns tbody td.prevMnth.inc_ot').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.inc_ot').addClass('borderCls');
				}
				if(this.id == 'inc_var_prev' || this.id == 'ear_prev_mnth'){
					$('#linkedcolumns tbody td.prevMnth.inc_var').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.inc_var').addClass('borderCls');
				}
				if(this.id == 'inc_oth_prev' || this.id == 'ear_prev_mnth'){
					$('#linkedcolumns tbody td.prevMnth.inc_oth').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.inc_oth').addClass('borderCls');
				}
				if(this.id == 'ded_abs_prev' || this.id == 'ded_prev_mnth'){
					$('#linkedcolumns tbody td.prevMnth.ded_abs').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.ded_abs').addClass('borderCls');
				}
				if(this.id == 'ded_fix_prev' || this.id == 'ded_prev_mnth'){
					$('#linkedcolumns tbody td.prevMnth.ded_fix').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.ded_fix').addClass('borderCls');
				}
				if(this.id == 'ded_var_prev' || this.id == 'ded_prev_mnth'){
					$('#linkedcolumns tbody td.prevMnth.ded_var').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.ded_var').addClass('borderCls');
				}
				if(this.id == 'ded_oth_prev' || this.id == 'ded_prev_mnth'){
					$('#linkedcolumns tbody td.prevMnth.ded_oth').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.ded_oth').addClass('borderCls');
				}
				if(this.id == 'ded_leg_prev' || this.id == 'ded_prev_mnth'){
					$('#linkedcolumns tbody td.prevMnth.ded_leg').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.ded_leg').addClass('borderCls');
				}
				if(this.id == 'ded_pay_prev' || this.id == 'ded_prev_mnth'){
					$('#linkedcolumns tbody td.prevMnth.ded_pay').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.ded_pay').addClass('borderCls');
				}

				//================ Full Year highlight ======================//
				if(this.id == 'ded_full_year'){
					$('#linkedcolumnsD tbody td.currMnths.ded_pay').addClass('borderCls');
					$('#linkedcolumnsD tbody td.currMnths.ded_abs').addClass('borderCls');
					$('#linkedcolumnsD tbody td.currMnths.ded_fix').addClass('borderCls');
					$('#linkedcolumnsD tbody td.currMnths.ded_var').addClass('borderCls');
					$('#linkedcolumnsD tbody td.currMnths.ded_oth').addClass('borderCls');
					$('#linkedcolumnsD tbody td.currMnths.ded_leg').addClass('borderCls');
					$('#linkedcolumnsD tbody td.currMnths.ded_pay').addClass('borderCls');

					$('#linkedcolumnsD tbody td.prevMnth.ded_pay').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.ded_abs').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.ded_fix').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.ded_var').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.ded_oth').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.ded_leg').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.ded_pay').addClass('borderCls');

					$('#linkedcolumnsD tbody td.upcommMnths.ded_pay').addClass('borderCls');
					$('#linkedcolumnsD tbody td.upcommMnths.ded_abs').addClass('borderCls');
					$('#linkedcolumnsD tbody td.upcommMnths.ded_fix').addClass('borderCls');
					$('#linkedcolumnsD tbody td.upcommMnths.ded_var').addClass('borderCls');
					$('#linkedcolumnsD tbody td.upcommMnths.ded_oth').addClass('borderCls');
					$('#linkedcolumnsD tbody td.upcommMnths.ded_leg').addClass('borderCls');
					$('#linkedcolumnsD tbody td.upcommMnths.ded_pay').addClass('borderCls');
				}

				if(this.id == 'ear_full_year'){
					$('#linkedcolumns tbody td.currMnths.inc_sal').addClass('borderCls');
					$('#linkedcolumns tbody td.currMnths.inc_fix').addClass('borderCls');
					$('#linkedcolumns tbody td.currMnths.inc_ot').addClass('borderCls');
					$('#linkedcolumns tbody td.currMnths.inc_var').addClass('borderCls');
					$('#linkedcolumns tbody td.currMnths.inc_oth').addClass('borderCls');

					$('#linkedcolumns tbody td.prevMnth.inc_sal').addClass('borderCls');
					$('#linkedcolumns tbody td.prevMnth.inc_fix').addClass('borderCls');
					$('#linkedcolumns tbody td.prevMnth.inc_ot').addClass('borderCls');
					$('#linkedcolumns tbody td.prevMnth.inc_var').addClass('borderCls');
					$('#linkedcolumns tbody td.prevMnth.inc_oth').addClass('borderCls');

					$('#linkedcolumns tbody td.upcommMnths.inc_sal').addClass('borderCls');
					$('#linkedcolumns tbody td.upcommMnths.inc_fix').addClass('borderCls');
					$('#linkedcolumns tbody td.upcommMnths.inc_ot').addClass('borderCls');
					$('#linkedcolumns tbody td.upcommMnths.inc_var').addClass('borderCls');
					$('#linkedcolumns tbody td.upcommMnths.inc_oth').addClass('borderCls');
				}

				if(this.id == 'pnd_full_year'){
					$('#linkedcolumns tbody td.currMnths.pnd1').addClass('borderCls');
					$('#linkedcolumns tbody td.prevMnth.pnd1').addClass('borderCls');
					$('#linkedcolumns tbody td.upcommMnths.pnd1').addClass('borderCls');

					$('#linkedcolumnsD tbody td.currMnths.pnd1').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.pnd1').addClass('borderCls');
					$('#linkedcolumnsD tbody td.upcommMnths.pnd1').addClass('borderCls');
				}

				if(this.id == 'sso_full_year'){
					$('#linkedcolumns tbody td.currMnths.sso').addClass('borderCls');
					$('#linkedcolumns tbody td.prevMnth.sso').addClass('borderCls');
					$('#linkedcolumns tbody td.upcommMnths.sso').addClass('borderCls');

					$('#linkedcolumnsD tbody td.currMnths.sso').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.sso').addClass('borderCls');
					$('#linkedcolumnsD tbody td.upcommMnths.sso').addClass('borderCls');
				}

				if(this.id == 'pvf_full_year'){
					$('#linkedcolumns tbody td.currMnths.pvf').addClass('borderCls');
					$('#linkedcolumns tbody td.prevMnth.pvf').addClass('borderCls');
					$('#linkedcolumns tbody td.upcommMnths.pvf').addClass('borderCls');

					$('#linkedcolumnsD tbody td.currMnths.pvf').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.pvf').addClass('borderCls');
					$('#linkedcolumnsD tbody td.upcommMnths.pvf').addClass('borderCls');
				}

				if(this.id == 'psf_full_year'){
					$('#linkedcolumns tbody td.currMnths.psf').addClass('borderCls');
					$('#linkedcolumns tbody td.prevMnth.psf').addClass('borderCls');
					$('#linkedcolumns tbody td.upcommMnths.psf').addClass('borderCls');

					$('#linkedcolumnsD tbody td.currMnths.psf').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.psf').addClass('borderCls');
					$('#linkedcolumnsD tbody td.upcommMnths.psf').addClass('borderCls');
				}

				if(this.id == 'inc_sal_fullY'){
					$('#linkedcolumns tbody td.currMnths.inc_sal').addClass('borderCls');
					$('#linkedcolumns tbody td.prevMnth.inc_sal').addClass('borderCls');
					$('#linkedcolumns tbody td.upcommMnths.inc_sal').addClass('borderCls');
				}
				if(this.id == 'inc_fix_fullY'){
					$('#linkedcolumns tbody td.currMnths.inc_fix').addClass('borderCls');
					$('#linkedcolumns tbody td.prevMnth.inc_fix').addClass('borderCls');
					$('#linkedcolumns tbody td.upcommMnths.inc_fix').addClass('borderCls');
				}
				if(this.id == 'inc_ot_fullY'){
					$('#linkedcolumns tbody td.currMnths.inc_ot').addClass('borderCls');
					$('#linkedcolumns tbody td.prevMnth.inc_ot').addClass('borderCls');
					$('#linkedcolumns tbody td.upcommMnths.inc_ot').addClass('borderCls');
				}
				if(this.id == 'inc_var_fullY'){
					$('#linkedcolumns tbody td.currMnths.inc_var').addClass('borderCls');
					$('#linkedcolumns tbody td.prevMnth.inc_var').addClass('borderCls');
					$('#linkedcolumns tbody td.upcommMnths.inc_var').addClass('borderCls');
				}
				if(this.id == 'inc_oth_fullY'){
					$('#linkedcolumns tbody td.currMnths.inc_oth').addClass('borderCls');
					$('#linkedcolumns tbody td.prevMnth.inc_oth').addClass('borderCls');
					$('#linkedcolumns tbody td.upcommMnths.inc_oth').addClass('borderCls');
				}

				if(this.id == 'ded_abs_fullY'){
					$('#linkedcolumnsD tbody td.currMnths.ded_abs').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.ded_abs').addClass('borderCls');
					$('#linkedcolumnsD tbody td.upcommMnths.ded_abs').addClass('borderCls');
				}
				if(this.id == 'ded_fix_fullY'){
					$('#linkedcolumnsD tbody td.currMnths.ded_fix').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.ded_fix').addClass('borderCls');
					$('#linkedcolumnsD tbody td.upcommMnths.ded_fix').addClass('borderCls');
				}
				if(this.id == 'ded_var_fullY'){
					$('#linkedcolumnsD tbody td.currMnths.ded_var').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.ded_var').addClass('borderCls');
					$('#linkedcolumnsD tbody td.upcommMnths.ded_var').addClass('borderCls');
				}
				if(this.id == 'ded_oth_fullY'){
					$('#linkedcolumnsD tbody td.currMnths.ded_oth').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.ded_oth').addClass('borderCls');
					$('#linkedcolumnsD tbody td.upcommMnths.ded_oth').addClass('borderCls');
				}
				if(this.id == 'ded_leg_fullY'){
					$('#linkedcolumnsD tbody td.currMnths.ded_leg').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.ded_leg').addClass('borderCls');
					$('#linkedcolumnsD tbody td.upcommMnths.ded_leg').addClass('borderCls');
				}
				if(this.id == 'ded_pay_fullY'){
					$('#linkedcolumnsD tbody td.currMnths.ded_pay').addClass('borderCls');
					$('#linkedcolumnsD tbody td.prevMnth.ded_pay').addClass('borderCls');
					$('#linkedcolumnsD tbody td.upcommMnths.ded_pay').addClass('borderCls');
				}
			}

			//========== Check total both side ===========//
			var lhs = $(this).text();
			var lhss = lhs.replace("-", "");
			var lhsss = lhss.replace(",", "");
			checkTotalsBothSide(lhsss);

		});

		function checkTotalsBothSide(lhs){

			var currTot = 0.00;
			var currTotD = 0.00;
			$('#linkedcolumns tbody td.borderCls').each(function(){
				var currVal = $(this).text();
				currVal = currVal.replace(/,/g, "");
				currTot += parseFloat(currVal);
			})

			$('#linkedcolumnsD tbody td.borderCls').each(function(){
				var currValD = $(this).text();
				currValD = currValD.replace(/,/g, "");
				currTotD += parseFloat(currValD);
			})

			var rhs = parseFloat(currTot) + parseFloat(currTotD);

			// alert(lhs);
			// alert(rhs);

			/*if(lhs != rhs){
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: Both side totals are not equal<br> LHS = '+lhs+'<br> RHS = '+rhs+'',
					duration: 1,
				})
			}*/
		}
	});

</script>

