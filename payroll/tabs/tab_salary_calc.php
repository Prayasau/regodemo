<style type="text/css">
	
	#tab_SalaryCalc table.salcal tbody th, table.salcal tbody td, table.salcal thead th{
		font-size:12px;
		padding: 3px !important;
	}

	#modalTAXDeduction input[type=text], #modalTAXDeduction input[type=text]:hover {
	    width: 80px!important;
	}

	#modalTAXDeduction table.basicTable tbody td{
	    padding: 4px 4px !important;
	}
	.overhang-close{
		display: none;
	}

	.borderCls{
		background: #ffff004a !important;
	}

	table.dataTable thead .sorting_asc:after {
	    content: "";
	}


</style>

<div style="height:100%; border:0px solid red; position:relative;">
	<div>
		<div class="smallNav">
			<ul>
				<li>
					<div class="searchFilter" style="margin:0">
						<input placeholder="Filter" id="searchFiltersc" class="sFilter" type="text">
						<button id="clearSearchboxsc" type="button" class="clearFilter btn btn-default btn-sm"><i class="fa fa-times"></i></button>
					</div>
				</li>	

			</ul>
		</div>
	</div>
	
	<table id="SalaryCalc" class="dataTable hoverable selectable">
		<thead>
			<tr>
				<th colspan="5" class="tac"><?=$lng['Employee']?></th>
				<th colspan="4" class="tac"><?=$lng['Income']?></th>				
				<th colspan="6" class="tac"><?=$lng['Calculations']?></th>
				<th colspan="4" class="tac"><?=$lng['Income Totals For']?></th>		
				<!-- <th colspan="11" class="tac"><?=$lng['Income groups']?></th>	 -->	
				
			</tr>
			<tr>
				<th class="tal"><?=$lng['Emp. ID']?></th>
				<th class="tal" style="width: 130px;"><?=$lng['Employee name']?></th>
				<th class="tal" style="cursor: pointer;">
					<i data-toggle="tooltip" title="Select all" class="Selallemp fa fa-thumbs-up fa-lg"></i>
					<i data-toggle="tooltip" title="Unselect all" class="unSelallemp fa fa-thumbs-down fa-lg" style="display:none;"></i>
				</th>
				<th class="tal" style="cursor: pointer;">
					<i data-toggle="tooltip" title="Calculator" class="fa fa-calculator fa-lg" ></i>
				</th>
				<th class="tac"><?=$lng['Paid'].'<br>'.$lng['days']?></th>

				<th class="tac"><?=$lng['Earnings']?></th>
				<th class="tac"><?=$lng['Deductions']?></th>
				<th class="tac"><?=$lng['Net Income']?></th>
				<th class="tac"><?=$lng['Net pay']?></th>

				<th class="tac"><?=$lng['SSO Employee']?></th>
				<th class="tac"><?=$lng['Tax']?></th>
				<th class="tac"><?=$lng['PVF']?></th>
				<th class="tac"><?=$lng['PSF']?></th>
				<th class="tac"><?=$lng['SSO by company']?></th>
				<th class="tac"><?=$lng['Tax by company']?></th>

				<th class="tac"><?=$lng['PVF']?></th>
				<th class="tac"><?=$lng['PSF']?></th>
				<th class="tac"><?=$lng['SSO']?></th>
				<th class="tac"><?=$lng['PND']?></th>

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
					<td class="tac">
						<input type="checkbox" class="checkbox-custom-blue empchkbox" name="sel_all[]" value="<?=$row['emp_id']?>" style="left:0px !important;">
					</td>
					<td>
						<!-- <a onclick="Opencalculationpopups(this)" id="<?=$row['emp_id']?>"><i class="fa fa-calculator fa-lg" ></i></a> -->
						<a onclick="OpencalculationpopupsNEW(this)" id="<?=$row['emp_id']?>"><i class="fa fa-calculator fa-lg" ></i></a>
					</td>
					<td><?=$pd?></td>
					<td class="tar"><?=number_format($row['total_earnings'],2);?></td>
					<td class="tar"><?=number_format($row['total_deductions'],2);?></td>
					<td class="tar"><?=number_format($row['total_net_income'],2);?></td>
					<td class="tar"><?=number_format($row['total_net_pay'],2);?></td>

					<td class="tar"><?=number_format($row['sso_employee'],2);?></td>
					<td class="tar"><?=number_format($row['tax_this_month'],2);?></td>
					<td class="tar"><?=number_format($row['pvf_employee'],2);?></td>
					<td class="tar"><?=number_format($row['psf_employee'],2);?></td>
					<td class="tar"><?=number_format($row['sso_by_company'],2);?></td>
					<td class="tar"><?=number_format($row['tax_by_company'],2);?></td>

					<td class="tar"><?=number_format($row['total_pvf'],2);?></td>
					<td class="tar"><?=number_format($row['total_psf'],2);?></td>
					<td class="tar"><?=number_format($row['total_sso'],2);?></td>
					<td class="tar"><?=number_format($row['total_pnd1'],2);?></td>
					
				</tr>

			<? } ?>
		</tbody>
	</table>

	<div class="row">
		<div class="col-md-2" style="margin: -30px 0px 0px 0px;margin-left: auto;margin-right: auto;">
			<select id="pageLengthsc" class="button btn-fl">
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

<div class="modal fade" id="Salarycalculator" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="top: 0px;">
	<div class="modal-dialog modal-xl" role="document" style="min-width: 1375px !important;">
		<div class="modal-content">
			<div class="modal-header" style="padding: 5px 13px">
				<h5 class="modal-title" style="padding: 0px;"><i class="fa fa-calculator"></i>&nbsp; <?=$lng['Calculate Payroll']?></h5>
				<div style=" position:absolute; right:40px; padding:3px 0">
					<a title="Print" href="#" style="margin-right:5px"><i class="fa fa-print fa-lg" style="margin-top: 5px;"></i></a>
				</div>
				<a title="Close" onclick="closeBtn1();" type="button" class="close" aria-label="Close"><i class="fa fa-times text-danger"></i></a>
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
					<div class="col-md-4" style="padding-right: 0px;max-width:41%;">
						<table id="getlinkeddata" class="basicTable salcal" border="0" style="width: 100%;">
							<thead>
								<tr>
									<th class="tac text-danger"><?=strtoupper($lng['Summary'])?></th>
									<th colspan="6" class="tac text-danger"><?=strtoupper($lng['Click amount to see detail'])?></th>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Description']?></th>
									<th class="tal"><?=$lng['Calc']?></th>
									<th class="tal"><?=$lng['Curr'].' '.$lng['Calc']?></th>
									<th class="tal"><?=$lng['Prev'].' '.$lng['Calc']?></th>
									<th class="tal"><?=$lng['Curr'].' '.$lng['Month']?></th>
									<th class="tal"><?=$lng['Prev'].' '.$lng['Month']?></th>
									<th class="tal"><?=$lng['Full year']?></th>
								</tr>
							</thead>
							<thead>
								<tr>
									<th colspan="7" class="tal"><?=strtoupper($lng['Total income'])?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th class="tal"><?=$lng['Earnings']?></th>
									<td></td>
									<td class="tar" id="ear_curr_calc"></td>
									<td class="tar" ></td>
									<td class="tar" id="ear_curr_mnth"></td>
									<td class="tar" id="ear_prev_mnth"></td>
									<td class="tar" id="ear_full_year"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Deductions']?></th>
									<td></td>
									<td class="tar" id="ded_curr_calc"></td>
									<td class="tar" ></td>
									<td class="tar" id="ded_curr_mnth"></td>
									<td class="tar" id="ded_prev_mnth"></td>
									<td class="tar" id="ded_full_year"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Income'].' '.$lng['PND']?></th>
									<td></td>
									<td class="tar" id="pnd_curr_calc"></td>
									<td class="tar" ></td>
									<td class="tar" id="pnd_curr_mnth"></td>
									<td class="tar" id="pnd_prev_mnth"></td>
									<td class="tar" id="pnd_full_year"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Income'].' '.$lng['SSO']?></th>
									<td></td>
									<td class="tar" id="sso_curr_calc"></td>
									<td class="tar" ></td>
									<td class="tar" id="sso_curr_mnth"></td>
									<td class="tar" id="sso_prev_mnth"></td>
									<td class="tar" id="sso_full_year"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Income'].' '.$lng['PVF']?></th>
									<td></td>
									<td class="tar" id="pvf_curr_calc"></td>
									<td class="tar" ></td>
									<td class="tar" id="pvf_curr_mnth"></td>
									<td class="tar" id="pvf_prev_mnth"></td>
									<td class="tar" id="pvf_full_year"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Income'].' '.$lng['PSF']?></th>
									<td></td>
									<td class="tar" id="psf_curr_calc"></td>
									<td class="tar" ></td>
									<td class="tar" id="psf_curr_mnth"></td>
									<td class="tar" id="psf_prev_mnth"></td>
									<td class="tar" id="psf_full_year"></td>
								</tr>
								
							</tbody>
							<thead>
								<tr>
									<th colspan="7" class="tal"><?=strtoupper($lng['Tax Base'])?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th class="tal"><?=$lng['Fixed pro rated']?></th>
									<td></td>
									<td class="tar" id="fixpro_curr_calc"></td>
									<td class="tar" ></td>
									<td class="tar" id="fixpro_curr_mnth"></td>
									<td class="tar" id="fixpro_prev_mnth"></td>
									<td class="tar" id="fixpro_full_year"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Fixed']?></th>
									<td></td>
									<td class="tar" id="fix_curr_calc"></td>
									<td class="tar" ></td>
									<td class="tar" id="fix_curr_mnth"></td>
									<td class="tar" id="fix_prev_mnth"></td>
									<td class="tar" id="fix_full_year"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Variable']?></th>
									<td></td>
									<td class="tar" id="var_curr_calc"></td>
									<td class="tar" ></td>
									<td class="tar" id="var_curr_mnth"></td>
									<td class="tar" id="var_prev_mnth"></td>
									<td class="tar" id="var_full_year"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['SSO by company']?></th>
									<td></td>
									<td class="tar" ></td>
									<td class="tar" ></td>
									<td class="tar" ></td>
									<td class="tar" ></td>
									<td class="tar" ></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Taxable income before tax']?></th>
									<td></td>
									<td class="tar" id="totalffv_curr_calc"></td>
									<td class="tar" ></td>
									<td class="tar" id="totalffv_curr_mnth"></td>
									<td class="tar" id="totalffv_prev_mnth"></td>
									<td class="tar" id="totalffv_full_year"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Tax by company']?></th>
									<td></td>
									<td class="tar" ></td>
									<td class="tar" ></td>
									<td class="tar" ></td>
									<td class="tar" ></td>
									<td class="tar" ></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Non-taxable']?></th>
									<td></td>
									<td class="tar" id="nontax_curr_calc"></td>
									<td class="tar" ></td>
									<td class="tar" id="nontax_curr_mnth"></td>
									<td class="tar" id="nontax_prev_mnth"></td>
									<td class="tar" id="nontax_full_year"></td>
								</tr>
							</tbody>
							<thead>
								<tr>
									<th colspan="7" class="tal"><?=strtoupper($lng['Calculations'])?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th class="tal"><?=$lng['SSO Employee']?></th>
									<td>
										<a id="modalssopopup" style="display: none;" onclick="modal_sso();">
											<i class="fa fa-calculator fa-lg text-primary" ></i>
										</a>
									</td>
									<td class="tar" id="sso_emp_curr_calc"></td>
									<td class="tar" ></td>
									<td class="tar" id="sso_emp_curr_mnth"></td>
									<td class="tar" id="sso_emp_prev_mnth"></td>
									<td class="tar" id="sso_emp_full_year"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['PVF Employee']?></th>
									<td>
										<a id="modalpvfpopup" style="display: none;" onclick="modal_pvf();">
											<i class="fa fa-calculator fa-lg text-primary" ></i>
										</a>
									</td>
									<td class="tar" id="pvf_emp_curr_calc"></td>
									<td class="tar" ></td>
									<td class="tar" id="pvf_emp_curr_mnth"></td>
									<td class="tar" id="pvf_emp_prev_mnth"></td>
									<td class="tar" id="pvf_emp_full_year"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['PSF Employee']?></th>
									<td>
										<a id="modalpsfpopup" style="display: none;" onclick="modal_psf();">
											<i class="fa fa-calculator fa-lg text-primary"></i>
										</a>
									</td>
									<td class="tar" id="psf_emp_curr_calc"></td>
									<td class="tar" ></td>
									<td class="tar" id="psf_emp_curr_mnth"></td>
									<td class="tar" id="psf_emp_prev_mnth"></td>
									<td class="tar" id="psf_emp_full_year"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Tax']?></th>
									<td>
										<a onclick="modal_tax();"><i class="fa fa-calculator fa-lg text-primary" ></i></a>
									</td>
									<td class="tar" id="tax_emp_curr_calc"></td>
									<td class="tar" ></td>
									<td class="tar" id="tax_emp_curr_mnth"></td>
									<td class="tar" id="tax_emp_prev_mnth"></td>
									<td class="tar" id="tax_emp_full_year"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Tax deductions']?></th>
									<td>
										<a onclick="modal_tax_deduction();"><i class="fa fa-calculator fa-lg text-primary" ></i></a>
									</td>
									<td class="tar" id="td_emp_curr_calc"></td>
									<td class="tar" ></td>
									<td class="tar" id="td_emp_curr_mnth"></td>
									<td class="tar" id="td_emp_prev_mnth"></td>
									<td class="tar" id="td_emp_full_year" style="pointer-events: none;"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Tax by company']?></th>
									<td></td>
									<td class="tar" id="taxbycom_curr_calc"></td>
									<td class="tar" ></td>
									<td class="tar" id="taxbycom_curr_mnth"></td>
									<td class="tar" id="taxbycom_prev_mnth"></td>
									<td class="tar" id="taxbycom_full_year"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['SSO by company']?></th>
									<td></td>
									<td class="tar" id="ssobycom_curr_calc"></td>
									<td class="tar" ></td>
									<td class="tar" id="ssobycom_curr_mnth"></td>
									<td class="tar" id="ssobycom_prev_mnth"></td>
									<td class="tar" id="ssobycom_full_year"></td>
								</tr>
								<tr style="pointer-events: none;">
									<th class="tal"><?=$lng['Net Income']?></th>
									<td></td>
									<td class="tar" id="total_net_income_cur_cal"></td>
									<td class="tar" ></td>
									<td class="tar" id="total_net_income_cur_mnth"></td>
									<td class="tar" id="total_net_income_prev_mnth"></td>
									<td class="tar" id="total_net_income_fullyear"></td>
								</tr>
								<tr style="pointer-events: none;">
									<th class="tal"><?=$lng['Net pay']?></th>
									<td></td>
									<td class="tar" id="total_net_pay_cur_cal"></td>
									<td class="tar" ></td>
									<td class="tar" id="total_net_pay_cur_mnth"></td>
									<td class="tar" id="total_net_pay_prev_mnth"></td>
									<td class="tar" id="total_net_pay_fullyear"></td>
								</tr>
							</tbody>

						</table>
					</div>

					<div id="Bothtable" class="col-md-8 table-responsive" style="padding-left: 0px;max-width:58%;border-left: 1px solid #ccc;">
						<table id="linkedcolumnsSC" class="basicTable salcal" border="0" style="width: 100%;">
							
						</table>

						<!-- <div class="row ml-1" id="hidediv2" style="background-color: #fff;margin-bottom: 11px;padding-bottom: 12px;">
							<table class="table-responsive" id="scrolltable">
								<tbody><tr>
									<td style="visibility: hidden;">
										 aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
									</td>
								</tr>
							</tbody></table>
						</div> -->

						<table id="linkedcolumnsSCD" class="basicTable salcal" border="0" style="width: 100%;">
							
						</table>
					</div>

				</div>

			</div>
			<!--<div class="modal-footer">
				<button class="btn btn-primary btn-fr" type="button" data-dismiss="modal"><?=$lng['Cancel']?></button>
				 <button class="btn btn-primary ml-1 " type="button"><i class="fa fa-save mr-1"></i> <?=$lng['Save']?></button>
			</div>-->
		</div>
	</div>
</div>


<!-------------------- modalSSO --------------------->
<div class="modal fade" id="modalSSO" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="top: 0px;">
	<div class="modal-dialog" role="document" style="min-width: 1000px !important;">
		<div class="modal-content">
			<form id="ssoAlldata">
				<div class="modal-header" style="padding: 5px 13px;background: darkgray;">
					<h5 class="modal-title" style="padding: 0px;"><i class="fa fa-calculator"></i>&nbsp; <?=$lng['Calculate SSO']?></h5>
					<a title="Close" type="button" class="close closebtn" data-dismiss="modal" aria-label="Close"><i class="fa fa-times text-danger"></i></a>
				</div>
				<div class="modal-body" style="padding: 5px 20px 5px !important;background: #efe;">
					
					<!-- <div class="row">
						<div class="col-md-7" style="padding-right: 0px;max-width: 54%;"> -->

							<input type="hidden" name="empid" id="ssoEmpid" value="">
							<input type="hidden" name="mid" value="<?=$_GET['mid']?>">
							<input type="hidden" name="cur_month" value="<?=$_SESSION['rego']['cur_month']?>">

							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr>
										<th colspan="10" class="tac text-danger p-1"><?=$lng['SSO CALCULATION']?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th class="tal"><?=$lng['Emp. ID']?></th>
										<td colspan="7" id="sso_empid"></td>
										
										<th class="tal"><?=$lng['Calculate SSO']?></th>
										<td id="sso_calc_sso" style="background:#fdf4bd;padding: 0px !important;">
											<select name="ss_calc_sso" id="sss_calc_sso" style="padding: 0px !important;background:#fdf4bd;" onchange="SSO_calc(this)">
												<? foreach($noyes01 as $k => $v){?>
													<option value="<?=$k?>"><?=$v?></option>
												<? } ?>
											</select>
										</td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Employee name']?></th>
										<td colspan="7" id="sso_empname"></td>
										
										<th class="tal"><?=$lng['SSO paid by']?></th>
										<td id="sso_sso_paidby" style="background:#fdf4bd;padding: 0px !important;">
											<select name="ss_paidby_sso" id="sss_paidby_sso" style="padding: 0px !important;background:#fdf4bd;" onchange="SSO_calc(this)">
												<? foreach($sso_paidby as $k => $v){ ?>
													<option value="<?=$k?>"><?=$v?></option>
												<? } ?>
											</select>
										</td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['SSO'].' '.$lng['Income']?></th>
										<td colspan="7" id="sso_total_sso_emp"></td>
										
										<th class="tal"></th>
										<td id="sso_rate_emp"></td>
									</tr>
								</tbody>

								<thead>
									<tr>
										<th colspan="10" class="tac text-danger p-1"><?=$lng['Calculations Full Year']?>
											<span class="text-primary float-right mr-5 ml-4"><?=$lng['Manual']?></span>
											<input type="checkbox" class="checkbox-custom-blue float-right" name="ssoManual" onclick="manualssoinput(this.checked)"> 
										</th>
									</tr>
									<tr>
										<th colspan="4" class="tac"><?=$lng['SSO']?> <?=$lng['Employee']?></th>
										<th colspan="3" class="tac"><?=$lng['SSO']?> <?=$lng['Company']?></th>
										<th colspan="3" class="tac"></th>
									</tr>
								</thead>
							
								<thead class="mt-4">
									<tr>
										<th class="tac"><?=$lng['Month']?></th>
										<th class="tac"><?=$lng['Rate']?> %</th>
										<th class="tac"><?=$lng['Min']?></th>
										<th class="tac"><?=$lng['Max']?></th>
										<th class="tac"><?=$lng['Rate']?> %</th>
										<th class="tac"><?=$lng['Min']?></th>
										<th class="tac"><?=$lng['Max']?></th>
										<th class="tac"><?=$lng['SSO Employee']?></th>
										<th class="tac"><?=$lng['SSO Employer']?></th>
										<th class="tac"><?=$lng['SSO by company']?></th>
									</tr>
								</thead>
								<tbody id="append_full_table">
									
								</tbody>

								<!--<thead class="mt-3">
									<tr>
										<th colspan="4" class="tal text-danger p-1"><?=$lng['Calculation employee contribution']?></th>
									</tr>
								</thead>
								<tbody>
									
									<tr>
										<th class="tal"><?=$lng['SSO'].' '.$lng['Calculated']?></th>
										<td id="sso_calculate_sso_emp"></td>
										
										<th class="tal"><?=$lng['Minimum rate']?></th>
										<td id="sso_min_emp"><?=$SSOnewcal['min']?></td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Manual correction']?></th>
										<td id="sso_memp" style="background:#fdf4bd;padding: 0px !important;width: 25%;">
											<input type="text" id="sso_manual_emp" class="float72" onchange="SSO_calc(this)" style="background:#fdf4bd;">
										</td>
										
										<th class="tal"><?=$lng['Maximum rate']?></th>
										<td id="sso_max_emp"><?=$SSOnewcal['max']?></td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['SSO Employee']?></th>
										<td id="sso_emp_sso"></td>
										<td colspan="2"></td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['SSO by company']?></th>
										<td id="sso_sso_by_company"></td>
										<td colspan="2"></td>
									</tr>
								</tbody>
								<thead class="mt-3">
									<tr>
										<th colspan="4" class="tal text-danger p-1"><?=$lng['Calculation Employer contribution']?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th class="tal"><?=$lng['SSO'].' '.$lng['Income']?></th>
										<td id="sso_total_sso_comp"></td>
										
										<th class="tal"><?=$lng['SSO rate Employer']?></th>
										<td id="sso_rate_comp"><?=$SSOnewcal['crate']?>%</td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['SSO'].' '.$lng['Calculated']?></th>
										<td id="sso_calculate_sso_comp"></td>
										
										<th class="tal"><?=$lng['Minimum rate']?></th>
										<td id="sso_min_comp"><?=$SSOnewcal['cmin']?></td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Manual correction']?></th>
										<td style="background:#fdf4bd;padding: 0px !important;width: 25%;">
											<input type="text" id="sso_manual_comp" onchange="SSO_calc(this)" name="manual_emplyr" class="float72" style="background:#fdf4bd;">
										</td>
										
										<th class="tal"><?=$lng['Maximum rate']?></th>
										<td id="sso_max_comp"><?=$SSOnewcal['cmax']?></td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['SSO Employer']?></th>
										<td id="sso_sso_employerss"></td>
										<td colspan="2"></td>
									</tr>
									
								</tbody>-->
							</table>
						<!-- </div>
						<div class="col-md-5" style="padding-left: 0px;max-width: 40%;">
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr>
										<th colspan="6" class="tac text-danger p-1"><?=$lng['Calculations Full Year']?></th>
									</tr>
								</thead>
							
								<thead class="mt-4">
									<tr>
										<th class="tac"><?=$lng['Month']?></th>
										<th class="tac"><?=$lng['SSO']?>%</th>
										<th class="tac"><?=$lng['SSO'].' '.$lng['Min']?></th>
										<th class="tac"><?=$lng['SSO'].' '.$lng['Max']?></th>
										<th class="tac"><?=$lng['SSO'].' '.$lng['THB']?></th>
										<th class="tac"><?=$lng['SSO by company']?></th>
									</tr>
								</thead>
								<tbody id="append_full_table">
									
								</tbody>

							</table>
						</div>
					</div> -->
				</div>
				<div class="modal-footer" style="background: darkgray;">
					<button class="btn btn-primary ml-1" id="SaveSSOdata" type="button"><?=$lng['Calculate']?></button>
					<button class="btn btn-danger closebtn" type="button" data-dismiss="modal"><?=$lng['Close popup']?></button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-------------------- modalSSO --------------------->

<!-------------------- modalPVF --------------------->
<div class="modal fade" id="modalPVF" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="top: 0px;">
	<div class="modal-dialog" role="document" style="min-width: 700px !important;">
		<div class="modal-content">
			<form id="formpvfdata">
				<div class="modal-header" style="padding: 5px 13px;background: darkgray;">
					<h5 class="modal-title" style="padding: 0px;"><i class="fa fa-calculator"></i>&nbsp; <?=$lng['Calculate PVF']?></h5>
					<a title="Close" type="button" class="close closebtn" data-dismiss="modal" aria-label="Close"><i class="fa fa-times text-danger"></i></a>
				</div>
				<div class="modal-body" style="padding: 5px 20px 5px !important;background: #efe;">

						<input type="hidden" name="empid" id="pvfEmpid" value="">
						<input type="hidden" name="mid" value="<?=$_GET['mid']?>">
						<input type="hidden" name="cur_month" value="<?=$_SESSION['rego']['cur_month']?>">
						<table class="basicTable" border="0" style="width: 100%;">
							<thead>
								<tr>
									<th colspan="5" class="tac text-danger p-1"><?=$lng['PVF CALCULATION']?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th class="tal"><?=$lng['Emp. ID']?></th>
									<td colspan="2" id="pvf_empid"></td>
									
									<th class="tal"><?=$lng['Calculate PVF']?></th>
									<td id="pvfs_calc_pvf" style="background:#fdf4bd;padding: 0px !important;">
										<select name="pvf_calc_pvf" id="pvfss_calc_pvf" onchange="PVF_calc(this)" style="padding: 0px !important;background:#fdf4bd;">
											<? foreach($noyes01 as $k => $v){?>
												<option value="<?=$k?>"><?=$v?></option>
											<? } ?>
										</select>
									</td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Employee name']?></th>
									<td colspan="2" id="pvf_empname"></td>
									<th class="tal"><?=$lng['% or THB']?></th>
									<td id="pvf_paidby" style="background:#fdf4bd;padding: 0px !important;">
										<select name="pf_paidby_pvf" id="pvf_paidby_pvf" onchange="PVF_calc(this)" style="padding: 0px !important;background:#fdf4bd;">
											<? foreach($per_or_thb as $k => $v){ ?>
												<option value="<?=$k?>"><?=$v?></option>
											<? } ?>
										</select>
									</td>
									
								</tr>
								<tr>
									<th class="tal"><?=$lng['PVF'].' '.$lng['Income']?></th>
									<td colspan="2"id="pvf_income_pvf_emp"></td>
									<td colspan="2"></td>
								</tr>
							</tbody>

							<thead>
								<tr>
									<th colspan="5" class="tac text-danger p-1"><?=$lng['Calculations Full Year']?>
										<span class="text-primary float-right mr-5 ml-4"><?=$lng['Manual']?></span>
										<input type="checkbox" class="checkbox-custom-blue float-right" name="pvfManual" onclick="manualpvfinput(this.checked)"> 
									</th>
								</tr>
								<tr>
									<th class="tac"><?=$lng['Month']?></th>
									<th class="tac"><?=$lng['PVF Employee']?> <?=$lng['Rate']?></th>
									<th class="tac"><?=$lng['PVF Employer']?> <?=$lng['Rate']?></th>
									<th class="tac"><?=$lng['PVF Employee']?></th>
									<th class="tac"><?=$lng['PVF Employer']?></th>
								</tr>
							</thead>
							<tbody id="append_full_table_pvf">
								
							</tbody>

						</table>
					
				</div>
				<div class="modal-footer" style="background: darkgray;">
					<button class="btn btn-primary ml-1" id="SavePVFdata" type="button"><?=$lng['Calculate']?></button>
					<button class="btn btn-danger closebtn" type="button" data-dismiss="modal"><?=$lng['Close popup']?></button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-------------------- modalPVF --------------------->

<!-------------------- modalPSF --------------------->
<div class="modal fade" id="modalPSF" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="top: 0px;">
	<div class="modal-dialog" role="document" style="min-width: 700px !important;">
		<div class="modal-content">
			<form id="formpsfdata">
				<div class="modal-header" style="padding: 5px 13px;background: darkgray;">
					<h5 class="modal-title" style="padding: 0px;"><i class="fa fa-calculator"></i>&nbsp; <?=$lng['Calculate PSF']?></h5>
					<a title="Close" type="button" class="close closebtn" data-dismiss="modal" aria-label="Close"><i class="fa fa-times text-danger"></i></a>
				</div>
				<div class="modal-body" style="padding: 5px 20px 5px !important;background: #efe;">

						<input type="hidden" name="empid" id="psfEmpid" value="">
						<input type="hidden" name="mid" value="<?=$_GET['mid']?>">
						<input type="hidden" name="cur_month" value="<?=$_SESSION['rego']['cur_month']?>">
						<table class="basicTable" border="0" style="width: 100%;">
							<thead>
								<tr>
									<th colspan="5" class="tac text-danger p-1"><?=$lng['PSF CALCULATION']?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th class="tal"><?=$lng['Emp. ID']?></th>
									<td colspan="2" id="psf_empid"></td>
									
									<th class="tal"><?=$lng['Calculate PSF']?></th>
									<td id="psfs_calc_sso" style="background:#fdf4bd;padding: 0px !important;">
										<select name="psf_calc_sso" id="psfss_calc_sso" onchange="PSF_calc(this)" style="padding: 0px !important;background:#fdf4bd;">
											<? foreach($noyes01 as $k => $v){?>
												<option value="<?=$k?>"><?=$v?></option>
											<? } ?>
										</select>
									</td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Employee name']?></th>
									<td colspan="2" id="psf_empname"></td>
									<th class="tal"><?=$lng['% or THB']?></th>
									<td id="psf_paidby" style="background:#fdf4bd;padding: 0px !important;">
										<select name="pf_paidby_psf" id="psf_paidby_psf" onchange="PSF_calc(this)" style="padding: 0px !important;background:#fdf4bd;">
											<? foreach($per_or_thb as $k => $v){ ?>
												<option value="<?=$k?>"><?=$v?></option>
											<? } ?>
										</select>
									</td>
									
								</tr>
								<tr>
									<th class="tal"><?=$lng['PSF'].' '.$lng['Income']?></th>
									<td colspan="2"id="psf_income_emp"></td>
									<td colspan="2"></td>
								</tr>
							</tbody>

							<thead>
								<tr>
									<th colspan="5" class="tac text-danger p-1"><?=$lng['Calculations Full Year']?>
										<span class="text-primary float-right mr-5 ml-4"><?=$lng['Manual']?></span>
										<input type="checkbox" class="checkbox-custom-blue float-right" name="psfManual" onclick="manualpsfinput(this.checked)"> 
									</th>
								</tr>
								
								<tr>
									<th class="tac"><?=$lng['Month']?></th>
									<th class="tac"><?=$lng['PSF Employee']?> <?=$lng['Rate']?></th>
									<th class="tac"><?=$lng['PSF Employer']?> <?=$lng['Rate']?></th>
									<th class="tac"><?=$lng['PSF Employee']?></th>
									<th class="tac"><?=$lng['PSF Employer']?></th>
								</tr>
							</thead>
							<tbody id="append_full_table_psf">
								
							</tbody>

						</table>
					
				</div>
				<div class="modal-footer" style="background: darkgray;">
					<button class="btn btn-primary ml-1" id="SavePSFdata" type="button"><?=$lng['Calculate']?></button>
					<button class="btn btn-danger closebtn" type="button" data-dismiss="modal"><?=$lng['Close popup']?></button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-------------------- modalPSF --------------------->

<!-------------------- modalPSF --------------------->
<!--<div class="modal fade" id="modalPSF" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="top: 0px;">
	<div class="modal-dialog" role="document" style="min-width: 900px !important;">
		<div class="modal-content">
			<div class="modal-header" style="padding: 5px 13px;background: darkgray;">
				<h5 class="modal-title" style="padding: 0px;"><i class="fa fa-calculator"></i>&nbsp; <?=$lng['Calculate PSF']?></h5>
				<a title="Close" type="button" class="close closebtn" data-dismiss="modal" aria-label="Close"><i class="fa fa-times text-danger"></i></a>
			</div>
			<div class="modal-body" style="padding: 5px 20px 5px !important;background: #efe;">
				<div class="row">
					<div class="col-md-7" style="padding-right: 0px;max-width: 58%;">
						<table class="basicTable" border="0" style="width: 100%;">
							<thead>
								<tr>
									<th colspan="4" class="tac text-danger p-1"><?=$lng['PSF CALCULATION']?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th class="tal"><?=$lng['Emp. ID']?></th>
									<td id="psf_empid"></td>
									
									<th class="tal"><?=$lng['Calculate PSF']?></th>
									<td id="psfs_calc_sso" style="background:#fdf4bd;padding: 0px !important;">
										<select name="psf_calc_sso" id="psfss_calc_sso" onchange="PSF_calc(this)" style="padding: 0px !important;background:#fdf4bd;">
											<? foreach($noyes01 as $k => $v){?>
												<option value="<?=$k?>"><?=$v?></option>
											<? } ?>
										</select>
									</td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Employee name']?></th>
									<td id="psf_empname"></td>
									<td colspan="2"></td>
									
								</tr>
							</tbody>
							<thead class="mt-3">
								<tr>
									<th colspan="4" class="tal text-danger p-1"><?=$lng['Calculation employee contribution']?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th class="tal"><?=$lng['PSF'].' '.$lng['Income']?></th>
									<td id="psf_income_emp"></td>
									
									<th class="tal"><?=$lng['PSF rate employee']?></th>
									<td id="psf_rate_psf_emp"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['PSF'].' '.$lng['Calculated']?></th>
									<td id="psf_calculate_emp"></td>
									
									<th class="tal"><?=$lng['PSF amount THB']?></th>
									<td id="psf_amt_thb_emp"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Manual correction']?></th>
									<td style="background:#fdf4bd;padding: 0px !important;width: 25%;">
										<input type="text" id="psf_manual_emp" onchange="PSF_calc(this)" name="manual_emp" class="float72" style="background:#fdf4bd;">
									</td>
									<td colspan="2"></td>
									
								</tr>
								<tr>
									<th class="tal"><?=$lng['PSF Employee']?></th>
									<td id="psf_psf_emp"></td>
									<td colspan="2"></td>
								</tr>
							</tbody>

							<thead class="mt-3">
								<tr>
									<th colspan="4" class="tal text-danger p-1"><?=$lng['Calculation Employer contribution']?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th class="tal"><?=$lng['PSF'].' '.$lng['Income']?></th>
									<td id="psf_income_comp"></td>
									
									<th class="tal"><?=$lng['PSF rate employer']?></th>
									<td id="psf_rate_psf_comp"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['PSF'].' '.$lng['Calculated']?></th>
									<td id="psf_calculate_comp"></td>
									
									<th class="tal"><?=$lng['PSF amount THB']?></th>
									<td id="psf_amt_thb_comp"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Manual correction']?></th>
									<td style="background:#fdf4bd;padding: 0px !important;width: 25%;">
										<input type="text" id="psf_manual_comp" onchange="PSF_calc(this)" name="manual_emplyr" class="float72" style="background:#fdf4bd;">
									</td>
									<td colspan="2"></td>
									
								</tr>
								<tr>
									<th class="tal"><?=$lng['PSF Employer']?></th>
									<td id="psf_psf_comp"></td>
									<td colspan="2"></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-md-5" style="padding-left: 0px;max-width: 40%;">
						<table class="basicTable" border="0" style="width: 100%;">
							<thead>
								<tr>
									<th colspan="3" class="tac text-danger p-1"><?=$lng['Calculations Full Year']?></th>
								</tr>
							</thead>
						
							<thead class="mt-4">
								<tr>
									<th class="tac"><?=$lng['Month']?></th>
									<th class="tac"><?=$lng['PSF']?> %</th>
									<th class="tac"><?=$lng['SSO'].' '.$lng['Min']?></th>
								</tr>
							</thead>
							<tbody id="append_full_table_psf">
								
							</tbody>

						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer" style="background: darkgray;">
				<button class="btn btn-primary ml-1" id="SavePSFdata" type="button"><?=$lng['Calculate']?></button>
				<button class="btn btn-danger closebtn" type="button" data-dismiss="modal"><?=$lng['Close popup']?></button>
			</div>
		</div>
	</div>
</div>-->
<!-------------------- modalPVF --------------------->

<!-------------------- modalTAX --------------------->
<div class="modal fade" id="modalTAX" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 800px !important;">
		<div class="modal-content">
			<div class="modal-header" style="padding: 5px 13px;background: darkgray;">
				<h5 class="modal-title" style="padding: 0px;"><i class="fa fa-calculator"></i>&nbsp; <?=$lng['Calculate Tax']?></h5>
				<a title="Close" type="button" class="close closebtn" data-dismiss="modal" aria-label="Close"><i class="fa fa-times text-danger"></i></a>
			</div>
			<div class="modal-body" style="padding: 5px 20px 5px !important;background: #efe;max-height: calc(100vh - 30vh);overflow-y: auto;">
				
				<table class="basicTable" border="0" style="width: 100%;">
					<thead>
						<tr>
							<th colspan="6" class="tac text-danger p-1"><?=$lng['Tax calculation']?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th class="tal" colspan="2"><?=$lng['Spread variable income']?></th>
							<td id="tx_spread_var_income"></td>
							<th class="tal" colspan="2"><?=$lng['Calculation base']?></th>
							<td id="tx_calc_base"></td>
						</tr>
						<tr>
							<th class="tal" colspan="2"><?=$lng['Calculate Tax']?></th>
							<td id="tx_calc_tax"></td>
							<th class="tal" colspan="2"><?=$lng['Tax calculation method']?></th>
							<td id="tx_tax_calc_method" style="background:#fdf4bd;padding: 0px !important;">
								<select id="tx_calc_method" style="padding: 0px !important;background:#fdf4bd;">
									<option value="cam">CAM</option>
									<option value="acm">ACM</option>
									<option value="ytd">YTD</option>
								</select>
							</td>
						</tr>
					</tbody>
					<thead>
						<tr>
							<th colspan="6" class="tac text-danger p-1">ACM</th>
						</tr>
						<tr>
							<th class="tal p-1 pl-2"><?=$lng['Year income']?></th>
							<td></td>
							<th class="tal p-1"><?=$lng['Tax calculation']?></th>
							<td></td>
							<th class="tal p-1"><?=$lng['Tax summary']?></th>
							<td></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th class="tal"><?=$lng['Tax deductions']?></th>
							<td class="tar" id="tx_tax_deduction"></td>
							<th class="tal"></th>
							<td></td>
							<th class="tal"><?=$lng['Total tax year']?></th>
							<td class="tar" id="tx_tot_tax_year_acm"></td>
						</tr>
						<tr>
							<th class="tal"><?=$lng['Fixed actual']?></th>
							<td class="tar" id="tx_fixed_actual"></td>
							<th class="tal"></th>
							<td></td>
							<th class="tal"><?=$lng['Total Prev Mths']?></th>
							<td class="tar" id="tx_tot_prev_mnth_acm"></td>
						</tr>
						<tr>
							<th class="tal"><?=$lng['Variable Prev']?></th>
							<td class="tar" id="tx_var_prev"></td>
							<th class="tal"></th>
							<td></td>
							<th class="tal"><?=$lng['Tax remaining']?></th>
							<td class="tar" id="tx_tax_remaining_acm"></td>
						</tr>
						<tr>
							<th class="tal"><?=$lng['Variable Cur']?></th>
							<td class="tar" id="tx_var_curr"></td>
							<th class="tal"></th>
							<td></td>
							<th class="tal"><?=$lng['Tax Fix this mth']?></th>
							<td class="tar" id="tx_fix_this_mnth_acm"></td>
						</tr>
						<tr>
							<th class="tal"><?=$lng['ACM fix']?></th>
							<td class="tar" id="tx_acm_fix1"></td>
							<th class="tal"><?=$lng['ACM fix']?></th>
							<td class="tar" id="tx_acm_fix2"></td>
							<th class="tal"><?=$lng['Tax Var this mth']?></th>
							<td class="tar" id="tx_var_this_mnth_acm"></td>
						</tr>
						<tr>
							<th class="tal"><?=$lng['ACM fix prev']?></th>
							<td class="tar" id="tx_acm_fix_prev1"></td>
							<th class="tal"><?=$lng['ACM fix'].' + '.$lng['Prev']?></th>
							<td class="tar" id="tx_acm_fix_prev2"></td>
							<th class="tal"><?=$lng['Tax this month']?></th>
							<td class="tar" id="tx_tax_this_mnth_acm"></td>
						</tr>
						<tr>
							<th class="tal"><?=$lng['ACM fix prev var']?></th>
							<td class="tar" id="tx_acm_fix_prev_var1"></td>
							<th class="tal"><?=$lng['ACM fix'].' + '.$lng['Var']?></th>
							<td class="tar" id="tx_acm_fix_prev_var2"></td>
							<th class="tal"><?=$lng['Total tax next mths']?></th>
							<td class="tar" id="tx_tot_tax_next_mnth_acm"></td>
						</tr>
						<tr>
							<th colspan="4"></th>
							<th class="tal"><?=$lng['Tax next month']?></th>
							<td class="tar" id="tx_tax_next_mnth_acm"></td>
						</tr>
						<tr>
							<th colspan="4"></th>
							<th class="tal"><?=$lng['Tax by company']?></th>
							<td class="tar" id="tx_tax_by_company_acm"></td>
						</tr>
					</tbody>
					<thead>
						<tr>
							<th colspan="6" class="tac text-danger p-1">YTD</th>
						</tr>
						<tr>
							<th class="tal p-1 pl-2"><?=$lng['Year income']?></th>
							<td></td>
							<th class="tal p-1"><?=$lng['Tax calculation']?></th>
							<td></td>
							<th class="tal p-1"><?=$lng['Tax summary']?></th>
							<td></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th class="tal"><?=$lng['Tax deductions']?> YTD</th>
							<td class="tar" id="tx_tax_deduction_ytd"></td>
							<th class="tal"></th>
							<td></td>
							<th class="tal"><?=$lng['Total tax year']?></th>
							<td class="tar" id="tx_tot_tax_year_ytd"></td>
						</tr>
						<tr>
							<th class="tal"><?=$lng['Income']?> YTD</th>
							<td class="tar" id="tx_income_ytd"></td>
							<th class="tal"></th>
							<td></td>
							<th class="tal"><?=$lng['Total Prev Mths']?></th>
							<td class="tar" id="tx_tot_prev_mnth_ytd"></td>
						</tr>
						<tr>
							<th colspan="4"></th>
							<th class="tal"><?=$lng['Tax this month']?></th>
							<td class="tar" id="tx_tax_this_mnth_ytd"></td>
						</tr>
						<tr>
							<th class="tal"><?=$lng['Taxable income']?> YTD</th>
							<td class="tar" id="tx_taxincome_ytd"></td>
							<th class="tal"><?=$lng['YTD. Tax']?></th>
							<td class="tar" id="tx_tax_ytd"></td>
							<th class="tal"><?=$lng['Tax by company']?></th>
							<td class="tar" id="tx_tax_by_company_ytd"></td>
						</tr>
						
					</tbody>
					<thead>
						<tr>
							<th colspan="6" class="tac text-danger p-1">CAM</th>
						</tr>
						<tr>
							<th class="tal p-1 pl-2"><?=$lng['Year income']?></th>
							<td></td>
							<th class="tal p-1"><?=$lng['Tax calculation']?></th>
							<td></td>
							<th class="tal p-1"><?=$lng['Tax summary']?></th>
							<td></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th class="tal"><?=$lng['Tax deductions']?></th>
							<td class="tar" id="tx_tax_deduction_cam"></td>
							<th class="tal"></th>
							<td></td>
							<th class="tal"><?=$lng['Total tax year']?></th>
							<td class="tar" id="tx_tot_tax_year_cam"></td>
						</tr>
						<tr>
							<th class="tal"><?=$lng['Fixed']?> x12</th>
							<td class="tar" id="tx_fixedx12_cam"></td>
							<th class="tal"></th>
							<td></td>
							<th class="tal"><?=$lng['Total Prev Mths']?></th>
							<td class="tar" id="tx_tot_prev_mnth_cam"></td>
						</tr>
						<tr>
							<th class="tal"><?=$lng['Variable Prev']?></th>
							<td class="tar" id="tx_var_prev_cam"></td>
							<th class="tal"></th>
							<td></td>
							<th class="tal"><?=$lng['Tax remaining']?></th>
							<td class="tar" id="tx_tax_remaining_cam"></td>
						</tr>
						<tr>
							<th class="tal"><?=$lng['Variable Cur']?></th>
							<td class="tar" id="tx_var_curr_cam"></td>
							<th class="tal"></th>
							<td></td>
							<th class="tal"><?=$lng['Tax Fix this mth']?></th>
							<td class="tar" id="tx_fix_this_mnth_cam"></td>
						</tr>
						<tr>
							<th class="tal"><?=$lng['CAM'].' '.$lng['Fix']?></th>
							<td class="tar" id="tx_cam_fix1"></td>
							<th class="tal"><?=$lng['CAM'].' '.$lng['Fix']?></th>
							<td class="tar" id="tx_cam_fix2"></td>
							<th class="tal"><?=$lng['Tax Var this mth']?></th>
							<td class="tar" id="tx_var_this_mnth_cam"></td>
						</tr>
						<tr>
							<th class="tal"><?=$lng['CAM'].' '.$lng['Fix'].' '.$lng['Prev']?></th>
							<td class="tar" id="tx_cam_fix_prev1"></td>
							<th class="tal"><?=$lng['CAM'].' '.$lng['Fix'].' + '.$lng['Prev']?></th>
							<td class="tar" id="tx_cam_fix_prev2"></td>
							<th class="tal"><?=$lng['Tax this month']?></th>
							<td class="tar" id="tx_tax_this_mnth_cam"></td>
						</tr>
						<tr>
							<th class="tal"><?=$lng['CAM'].' '.$lng['Fix'].' '.$lng['Prev'].' '.$lng['Var']?></th>
							<td class="tar" id="tx_cam_fix_prev_var1"></td>
							<th class="tal"><?=$lng['CAM'].' '.$lng['Fix'].' + '.$lng['Var']?></th>
							<td class="tar" id="tx_cam_fix_prev_var2"></td>
							<th class="tal"><?=$lng['Total tax next mths']?></th>
							<td class="tar" id="tx_tot_tax_next_mnth_cam"></td>
						</tr>
						<tr>
							<th colspan="4"></th>
							<th class="tal"><?=$lng['Tax next month']?></th>
							<td class="tar" id="tx_tax_next_mnth_cam"></td>
						</tr>
						<tr>
							<th colspan="4"></th>
							<th class="tal"><?=$lng['Tax by company']?></th>
							<td class="tar" id="tx_tax_by_company_cam"></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer" style="background: darkgray;">
				<button class="btn btn-primary ml-1" id="SaveTAXdata" type="button"><?=$lng['Calculate']?></button>
				<button class="btn btn-danger closebtn" type="button" data-dismiss="modal"><?=$lng['Close popup']?></button>
			</div> 
		</div>
	</div>
</div>
<!-------------------- modalTAX --------------------->

<!-------------------- modalTAXDeduction --------------------->
<div class="modal fade" id="modalTAXDeduction" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="top:0px;">
	<div class="modal-dialog" role="document" style="min-width: 700px !important;">
		<div class="modal-content">
			<div class="modal-header" style="padding: 5px 13px;background: darkgray;">
				<h5 class="modal-title" style="padding: 0px;"><i class="fa fa-calculator"></i>&nbsp; <?=$lng['Calculate'].' '.$lng['Tax deductions']?></h5>
				<a title="Close" type="button" class="close closebtn" data-dismiss="modal" aria-label="Close"><i class="fa fa-times text-danger"></i></a>
			</div>
			<div class="modal-body" style="padding: 5px 20px 5px !important;background: #efe;">
				<table class="basicTable" border="0" style="width: 101%;">
					<thead>
						<tr>
							<th colspan="5" class="tac text-danger p-1"><?=$lng['Tax deductions']?></th>
						</tr>
					</thead>
				</table>

				
						<table class="basicTable" border="0" style="width: 100%;">
							<tbody>
								<tr>
									<th class="tal"><?=$lng['Emp. ID']?></th>
									<td id="td_empid"></td>
									<td colspan="3"></td>
								</tr>
								<tr>
									<th class="tal"><?=$lng['Employee name']?></th>
									<td id="td_empname"></td>
									<td colspan="3"></td>
								</tr>
								<tr>
									<td colspan="2"></td>
									<th class="tal"><?=$lng['Standard deduction']?></th>
									<td class="tar" id="td_std_deduction"></td>
									<td class="tar" id="td_std_clcthb"></td>
								</tr>
								<tr>
									<td colspan="2"></td>
									<th class="tal"><?=$lng['Personal care']?></th>
									<td class="tar" id="td_pers_care"></td>
									<td class="tar" id="td_pcare_clcthb"></td>
								</tr>
								<tr>
									<td colspan="2"></td>
									<th class="tal"><?=$lng['PVF Employee']?></th>
									<td class="tar" id="td_pvf_empsss"></td>
									<td class="tar" id="td_pvf_clcthb"></td>
								</tr>
								
								<tr>
									<td colspan="2"></td>
									<th class="tal"><?=$lng['SSO Employee']?></th>
									<td class="tar" id="td_sso_empsss"></td>
									<td class="tar" id="td_sso_clcthb"></td>
								</tr>
								<tr>
									<td colspan="2"></td>
									<th class="tal"><?=$lng['Other deductions']?></th>
									<td class="tar" id="td_other_deduct"></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="2"></td>
									<th class="tal text-danger"><?=$lng['Total tax deductions']?></th>
									<td id="td_total_tax_deduct" class="tar text-danger font-weight-bold"></td>
									<td></td>
								</tr>
							</tbody>

							<tbody>
								<tr>
									<th colspan="2" class="tac text-primary"><?=$lng['Calculation Standard deduction']?></th>
									<th colspan="3" class="tac text-primary"><?=$lng['Calculation Personal Care']?></th>
								</tr>
								<tr>
									<td colspan="2" class="tac small">Assessed income *50% max 100,000</td>
									<td colspan="3" class="tac small">Assessed income *40% max 60,000</td>
								</tr>
								<tr>
									<td class="tal"><?=$lng['Fixed actual income']?></td>
									<td class="tar" id="fixed_actual_income_std"></td>
									<td></td>
									<td class="tal"><?=$lng['Fixed actual income']?></td>
									<td class="tar" id="fixed_actual_income_pcare"></td>
								</tr>
								<tr>
									<td class="tal"><?=$lng['Subtotal']?></td>
									<td class="tar" id="subtotal_std"></td>
									<td></td>
									<td class="tal"><?=$lng['Subtotal']?></td>
									<td class="tar" id="subtotal_pcare"></td>
								</tr>
								<tr>
									<td class="tal"><?=$lng['Manual correction']?></td>
									<td style="background:#fdf4bd;padding: 0px !important;">
										<input type="text" id="td_manual_std" onchange="tax_deduct_calc(this)" class="tar float72" style="background:#fdf4bd;min-width:100%;padding-right: 4px;">
									</td>
									<td></td>
									<td class="tal"><?=$lng['Manual correction']?></td>
									<td style="background:#fdf4bd;padding: 0px !important;">
										<input type="text" id="td_manual_pcare" onchange="tax_deduct_calc(this)" class="tar float72" style="background:#fdf4bd;min-width:100%;padding-right: 4px;">
									</td>
								</tr>
								<tr>
									<td class="tal"><?=$lng['Standard deduction']?></td>
									<td class="tar" id="td_std_deduct"></td>
									<td></td>
									<td class="tal"><?=$lng['Personal care'].' '.$lng['Deduction']?></td>
									<td class="tar" id="td_pcare_deduct"></td>
								</tr>
								

							</tbody>
						</table>

					
			</div>
			<div class="modal-footer" style="background: darkgray;">
				<button class="btn btn-primary ml-1" id="SaveTDdata" type="button"><?=$lng['Calculate']?></button>
				<button class="btn btn-danger closebtn" type="button" data-dismiss="modal"><?=$lng['Close popup']?></button>
			</div>
		</div>
	</div>
</div>

<!-------------------- modalTAXDeduction --------------------->


<script type="text/javascript">

	function OpencalculationpopupsNEW(that){

		var empid = that.id;
		var currmnth = <?=$_SESSION['rego']['cur_month']?>;
		var mid = '<?=$_GET['mid']?>';
		$('#getlinkeddata tbody td').removeClass('borderCls');

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

					//console.log(data);

					//===================== Right side table data start (Allowances) ======================//
					var eColsMdlA = <?=$eColsMdlA?>;
					var eColsMdlD = <?=$eColsMdlD?>;
					
					var pperiods = <?=json_encode($pperiods)?>;
					var short_months = <?=json_encode($short_months)?>;
					var payrollparametersformonth = <?=json_encode(array_values($payrollparametersformonth))?>;
					var allowance_deduct_name = <?=json_encode($allowDdt)?>;
					var allowDdtEmp_name = <?=json_encode($allowDdtEmp)?>;
					var curryear = <?=substr($_SESSION['rego']['cur_year'], -2)?>;
					var remaining_mnth = 12 - currmnth + 1;
					var ssoEmpRates = data[0].ssoEmpRates;
					
					//console.log(payrollparametersformonth);
					//console.log(payroll_datas);

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
					//console.log(fix_allow_from_emp);
					$('#Salarycalculator #linkedcolumnsSC thead').remove();
					$('#Salarycalculator #linkedcolumnsSC tbody').remove();

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
								var tax_basefp = '';
								var tax_basef = '';
								var tax_basev = '';
								var tax_basent = '';
								var taxbycom = '';
								var ssobycom = '';

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
											
											if(crmth_manual_feed == ''){crmth_manual_feed=0.00;}
											
											if(v['pnd'] == 1){ pnd1 = 'pnd1';}else{ pnd1 = '';}
											if(data[0].calc_sso == 1 && v['sso'] == 1){ sso = 'sso';}else{ sso = '';}
											if(data[0].calc_pvf == 1 && v['pvf'] == 1){ pvf = 'pvf';}else{ pvf = '';}
											if(data[0].calc_psf == 1 && v['psf'] == 1){ psf = 'psf';}else{ psf = '';}
											if(v['tax_base'] == 'fixpro'){ tax_basefp = 'fixpro';}else{ tax_basefp = '';}
											if(v['tax_base'] == 'fix'){ tax_basef = 'fix';}else{ tax_basef = '';}
											if(v['tax_base'] == 'var'){ tax_basev = 'var';}else{ tax_basev = '';}
											if(v['tax_base'] == 'nontax'){ tax_basent = 'nontax';}else{ tax_basent = '';}
											if(v['allow_deduct_ids'] == 27){taxbycom="taxbycom";}else{ taxbycom="";}
											if(v['allow_deduct_ids'] == 28){ssobycom="ssobycom";}else{ ssobycom="";}

											allow_and_deduct_data +='<td class="tar '+currMnths+' '+pnd1+' '+sso+' '+pvf+' '+psf+' '+tax_basefp+' '+tax_basef+' '+tax_basev+' '+tax_basent+' '+taxbycom+' '+ssobycom+' '+v['groups']+'">'+number_format(crmth_manual_feed)+'</td>';
										}
									}
								})

								allow_and_deduct_data +='</tr>';
							}

						allow_and_deduct_data +='</tbody>';
						$('#Salarycalculator #linkedcolumnsSC').append(allow_and_deduct_data);
					//===================== Right side table data end ======================//

					//===================== Right side table data Start (Deduction) ======================//
					var defclmd = 1;
					var tot_countd = parseFloat(countDeduct) + parseFloat(defclmd);
					$('#Salarycalculator #linkedcolumnsSCD thead').remove();
					$('#Salarycalculator #linkedcolumnsSCD tbody').remove();

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
								var tax_basefp = '';
								var tax_basef = '';
								var tax_basev = '';
								var tax_basent = '';
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
											if(data[0].calc_sso == 1 && v['sso'] == 1){ sso = 'sso';}else{ sso = '';}
											if(data[0].calc_pvf == 1 && v['pvf'] == 1){ pvf = 'pvf';}else{ pvf = '';}
											if(data[0].calc_psf == 1 && v['psf'] == 1){ psf = 'psf';}else{ psf = '';}
											if(v['tax_base'] == 'fixpro'){ tax_basefp = 'fixpro';}else{ tax_basefp = '';}
											if(v['tax_base'] == 'fix'){ tax_basef = 'fix';}else{ tax_basef = '';}
											if(v['tax_base'] == 'var'){ tax_basev = 'var';}else{ tax_basev = '';}
											if(v['tax_base'] == 'nontax'){ tax_basent = 'nontax';}else{ tax_basent = '';}
											if(v['allow_deduct_ids'] == 57){extracls="ssocurr";}else{ extracls="";}
											if(v['allow_deduct_ids'] == 60){extraTax="exTax";}else{ extraTax="";}

											deduct_data +='<td class="tar '+currMnths+' '+pnd1+' '+sso+' '+pvf+' '+psf+' '+tax_basefp+' '+tax_basef+' '+tax_basev+' '+tax_basent+' '+extracls+' '+extraTax+' '+v['groups']+'">'+number_format(crmth_manual_feed)+'</td>';

										}
									}
								})

								deduct_data +='</tr>';
							}

						deduct_data +='</tbody>';
						$('#Salarycalculator #linkedcolumnsSCD').append(deduct_data);
					//===================== Right side table data end ======================//

					$('#Salarycalculator #empids').text(data[0].emp_id);
					$('#Salarycalculator #deptval').text(data.department);
					$('#Salarycalculator #contract_type').text(data.contract_type);
					$('#Salarycalculator #calc_tax').text(data.calc_tax);
					$('#Salarycalculator #calc_sso').text(data.calc_sso);
					
					if(data.calc_sso == 'Yes'){ $('#Salarycalculator #modalssopopup').css('display','table-row'); }else{ $('#Salarycalculator #modalssopopup').css('display','none'); }
					if(data.calc_pvf == 'Yes'){ $('#Salarycalculator #modalpvfpopup').css('display','table-row'); }else{ $('#Salarycalculator #modalpvfpopup').css('display','none'); }
					if(data.calc_psf == 'Yes'){ $('#Salarycalculator #modalpsfpopup').css('display','table-row'); }else{ $('#Salarycalculator #modalpsfpopup').css('display','none'); }


					$('#Salarycalculator #emp_name').text(data[0].emp_name_en);
					$('#Salarycalculator #teamval').text(data.team);
					$('#Salarycalculator #tax_calc_method').text(data[0].calc_method);

					if(data.calc_pvf == 'Yes'){
						$('#Salarycalculator #pvfpsfLbl').text('<?=$lng['Calculate PVF']?>');
						$('#Salarycalculator #calc_pvf').text(data.calc_pvf);
					}else if(data.calc_psf == 'Yes'){
						$('#Salarycalculator #pvfpsfLbl').text('<?=$lng['Calculate PSF']?>');
						$('#Salarycalculator #calc_pvf').text(data.calc_psf);
					}else{
						$('#Salarycalculator #pvfpsfLbl').text('');
						$('#Salarycalculator #calc_pvf').text('');
					}

					//$('#Salarycalculator #calc_pvf').text(data.calc_pvf);
					//$('#Salarycalculator #calc_psf').text(data.calc_psf);

					$('#Salarycalculator #position_val').text(data.position);
					$('#Salarycalculator #calc_base').text(data.calc_base);

					
					$('#Salarycalculator #ear_curr_calc').text(number_format(data[0].total_earnings));
					$('#Salarycalculator #ear_curr_mnth').text(number_format(data[0].total_earnings));
					$('#Salarycalculator #ear_prev_mnth').text(number_format(data[0].total_earnings_prev));
					$('#Salarycalculator #ear_full_year').text(number_format(data[0].full_year_earnings));

					$('#Salarycalculator #ded_curr_calc').text(number_format(data[0].total_deductions));
					$('#Salarycalculator #ded_curr_mnth').text(number_format(data[0].total_deductions));
					$('#Salarycalculator #ded_prev_mnth').text(number_format(data[0].total_deductions_prev));
					$('#Salarycalculator #ded_full_year').text(number_format(data[0].full_year_deductions));

					$('#Salarycalculator #pnd_curr_calc').text(number_format(data[0].total_pnd1));
					$('#Salarycalculator #pnd_curr_mnth').text(number_format(data[0].total_pnd1));
					$('#Salarycalculator #pnd_prev_mnth').text(number_format(data[0].total_pnd1_prev));
					$('#Salarycalculator #pnd_full_year').text(number_format(data[0].full_year_pnd));

					$('#Salarycalculator #sso_curr_calc').text(number_format(data[0].total_sso));
					$('#Salarycalculator #sso_curr_mnth').text(number_format(data[0].total_sso));
					$('#Salarycalculator #sso_prev_mnth').text(number_format(data[0].total_sso_prev));
					$('#Salarycalculator #sso_full_year').text(number_format(data[0].full_year_sso));

					$('#Salarycalculator #pvf_curr_calc').text(number_format(data[0].total_pvf));
					$('#Salarycalculator #pvf_curr_mnth').text(number_format(data[0].total_pvf));
					$('#Salarycalculator #pvf_prev_mnth').text(number_format(data[0].total_pvf_prev));
					$('#Salarycalculator #pvf_full_year').text(number_format(data[0].full_year_pvf));

					$('#Salarycalculator #psf_curr_calc').text(number_format(data[0].total_psf));
					$('#Salarycalculator #psf_curr_mnth').text(number_format(data[0].total_psf));
					$('#Salarycalculator #psf_prev_mnth').text(number_format(data[0].total_psf_prev));
					$('#Salarycalculator #psf_full_year').text(number_format(data[0].full_year_psf));

					$('#Salarycalculator #fixpro_curr_calc').text(number_format(data[0].total_tax_fixpro));
					$('#Salarycalculator #fixpro_curr_mnth').text(number_format(data[0].total_tax_fixpro));
					$('#Salarycalculator #fixpro_prev_mnth').text(number_format(data[0].total_tax_fixpro_prev));
					$('#Salarycalculator #fixpro_full_year').text(number_format(data[0].full_year_fixprorated));

					$('#Salarycalculator #fix_curr_calc').text(number_format(data[0].total_tax_fix));
					$('#Salarycalculator #fix_curr_mnth').text(number_format(data[0].total_tax_fix));
					$('#Salarycalculator #fix_prev_mnth').text(number_format(data[0].total_tax_fix_prev));
					$('#Salarycalculator #fix_full_year').text(number_format(data[0].full_year_fixed));

					$('#Salarycalculator #var_curr_calc').text(number_format(data[0].total_tax_var));
					$('#Salarycalculator #var_curr_mnth').text(number_format(data[0].total_tax_var));
					$('#Salarycalculator #var_prev_mnth').text(number_format(data[0].total_tax_var_prev));
					$('#Salarycalculator #var_full_year').text(number_format(data[0].full_year_var));

					$('#Salarycalculator #totalffv_curr_calc').text(number_format(data[0].total_of_alltax));
					$('#Salarycalculator #totalffv_curr_mnth').text(number_format(data[0].total_of_alltax));
					$('#Salarycalculator #totalffv_prev_mnth').text(number_format(data[0].total_of_alltax_prev));
					$('#Salarycalculator #totalffv_full_year').text(number_format(data[0].full_year_taxableincome));

					$('#Salarycalculator #nontax_curr_calc').text(number_format(data[0].total_tax_nontax));
					$('#Salarycalculator #nontax_curr_mnth').text(number_format(data[0].total_tax_nontax));
					$('#Salarycalculator #nontax_prev_mnth').text(number_format(data[0].total_tax_nontax_prev));
					$('#Salarycalculator #nontax_full_year').text(number_format(data[0].full_year_non_taxable));

					$('#Salarycalculator #sso_emp_curr_calc').text(number_format(data[0].sso_employee));
					$('#Salarycalculator #sso_emp_curr_mnth').text(number_format(data[0].sso_employee));
					$('#Salarycalculator #sso_emp_prev_mnth').text(number_format(data[0].sso_employee_prev));
					$('#Salarycalculator #sso_emp_full_year').text(number_format(data[0].full_year_sso_employee));

					$('#Salarycalculator #pvf_emp_curr_calc').text(number_format(data[0].pvf_employee));
					$('#Salarycalculator #pvf_emp_curr_mnth').text(number_format(data[0].pvf_employee));
					$('#Salarycalculator #pvf_emp_prev_mnth').text(number_format(data[0].pvf_employee_prev));
					$('#Salarycalculator #pvf_emp_full_year').text(number_format(data[0].full_year_pvf_employee));

					$('#Salarycalculator #psf_emp_curr_calc').text(number_format(data[0].psf_employee));
					$('#Salarycalculator #psf_emp_curr_mnth').text(number_format(data[0].psf_employee));
					$('#Salarycalculator #psf_emp_prev_mnth').text(number_format(data[0].psf_employee_prev));
					$('#Salarycalculator #psf_emp_full_year').text(number_format(data[0].full_year_psf_employee));

					$('#Salarycalculator #tax_emp_curr_calc').text(number_format(data[0].tax_this_month));
					$('#Salarycalculator #tax_emp_curr_mnth').text(number_format(data[0].tax_this_month));
					$('#Salarycalculator #tax_emp_prev_mnth').text(number_format(data[0].tax_previous));
					$('#Salarycalculator #tax_emp_full_year').text(number_format(data[0].total_tax_year));

					$('#Salarycalculator #td_emp_curr_calc').text('');
					$('#Salarycalculator #td_emp_curr_mnth').text('');
					$('#Salarycalculator #td_emp_prev_mnth').text('');
					$('#Salarycalculator #td_emp_full_year').text(number_format(data[0].total_yearly_tax_deductions));

					$('#Salarycalculator #ssobycom_curr_calc').text(number_format(data[0].sso_by_company));
					$('#Salarycalculator #ssobycom_curr_mnth').text(number_format(data[0].sso_by_company));
					$('#Salarycalculator #ssobycom_prev_mnth').text(number_format(data[0].sso_by_company_prev));
					$('#Salarycalculator #ssobycom_full_year').text(0);

					$('#Salarycalculator #taxbycom_curr_calc').text(number_format(data[0].tax_by_company));
					$('#Salarycalculator #taxbycom_curr_mnth').text(number_format(data[0].tax_by_company));
					$('#Salarycalculator #taxbycom_prev_mnth').text(number_format(data[0].tax_previous));
					$('#Salarycalculator #taxbycom_full_year').text(0);

					$('#Salarycalculator #total_net_income_cur_cal').text(number_format(data[0].total_net_income));
					$('#Salarycalculator #total_net_income_cur_mnth').text(number_format(data[0].total_net_income));
					$('#Salarycalculator #total_net_income_prev_mnth').text(number_format(data[0].total_net_income_prev));
					$('#Salarycalculator #total_net_income_fullyear').text(number_format(data[0].fullyear_net_income));


					$('#Salarycalculator #total_net_pay_cur_cal').text(number_format(data[0].total_net_pay));
					$('#Salarycalculator #total_net_pay_cur_mnth').text(number_format(data[0].total_net_pay));
					$('#Salarycalculator #total_net_pay_prev_mnth').text(number_format(data[0].total_net_pay_prev));
					$('#Salarycalculator #total_net_pay_fullyear').text(number_format(data[0].fullyear_net_pay));

				
					$('#Salarycalculator').modal('show');

					$('#linkedcolumnsSC').DataTable().destroy();
					$('#linkedcolumnsSCD').DataTable().destroy();


					var dtablesmdl = $('#linkedcolumnsSC').DataTable({
						//scrollX: true,
						lengthChange: false,
						searching: false,
						ordering: false,
						paging: false,
						pageLength: 12,
						filter: false,
						info: false,
						responsive: false,
						<?=$dtable_lang?>
						/*columnDefs: [
							{"targets": eColsMdlA, "visible": false, "searchable": false},
							//{ width: '10%', targets: "tac" }
						],*/
						
					});

					var dtablesmdld = $('#linkedcolumnsSCD').DataTable({
						
						lengthChange: false,
						searching: false,
						ordering: false,
						paging: false,
						pageLength: 12,
						filter: false,
						info: false,
						responsive: false,
						<?=$dtable_lang?>
						/*columnDefs: [
							{"targets": eColsMdlD, "visible": false, "searchable": false},
							//{ width: '10%', targets: "tac" }
						],*/
						
					});

					

				}
			}
		})
	}

	function closeBtn1(){

		$('#linkedcolumnsSC').DataTable().destroy();
		$('#linkedcolumnsSCD').DataTable().destroy();

		$('#Salarycalculator').modal('hide');
	}


	/*function Opencalculationpopups(that){

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
					//console.log(data);

					var payroll_datas = data.payroll_data;

					//===================== Right side table data start (Allowances) ======================//
					var eColsMdlA = <?=$eColsMdlA?>;
					var eColsMdlD = <?=$eColsMdlD?>;
					
					var pperiods = <?=json_encode($pperiods)?>;
					var short_months = <?=json_encode($short_months)?>;
					var payrollparametersformonth = <?=json_encode(array_values($payrollparametersformonth))?>;
					var allowance_deduct_name = <?=json_encode($allowDdt)?>;
					var allowDdtEmp_name = <?=json_encode($allowDdtEmp)?>;
					var curryear = <?=substr($_SESSION['rego']['cur_year'], -2)?>;
					var remaining_mnth = 12 - currmnth + 1;
					//console.log(pperiods);
					var ssoEmpRates = data[0].ssoEmpRates;

					//console.log(payrollparametersformonth);
					//console.log(payroll_datas);

					var countAllown = 0;
					var countDeduct = 0;
					$.each(payrollparametersformonth, function(k,v){

						if(v['classification'] == 0){
							countAllown++;
						}else if(v['classification'] == 1){
							countDeduct++;
						}
					});

					var defclm = 1;
					var tot_count = parseFloat(countAllown) + parseFloat(defclm);

					var manual_feed_total = data.manual_feed_total;
					var fix_allow_from_emp = data.fix_allow_from_emp;
					var fix_deduct_from_emp = data.fix_deduct_from_emp;
					//console.log(fix_allow_from_emp);
					$('#Salarycalculator #linkedcolumnsSC thead').remove();
					$('#Salarycalculator #linkedcolumnsSC tbody').remove();

					var allow_and_deduct_data = '<thead>';
						allow_and_deduct_data +='<tr><th colspan="'+tot_count+'" class="tal text-danger"><?=$lng['DETAILS ALLOWANCES & DEDUCTIONS']?></th></tr>';
						allow_and_deduct_data +='<tr>';
						allow_and_deduct_data +='<th class="tac"><?=$lng['Month']?></th>';

						var countClm = 0;
						var clmnval;
						$.each(payrollparametersformonth, function(k1,v){
							var k = v['id'];
							if(v['classification'] == 0){
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
								var tax_basefp = '';
								var tax_basef = '';
								var tax_basev = '';
								var tax_basent = '';
								var taxbycom = '';
								
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
											
											

											if(k == 27){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].tax_by_company); taxbycom="taxbycom";}else{ taxbycom="";}
											if(k == 28){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].sso_by_company); }
											if(k == 29){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].severance); }
											if(k == 31){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].remaining_salary); }
											if(k == 32){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].notice_payment); }
											if(k == 33){ crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(data[0].paid_leave); }
											
											if(k == 56){ 
												if(data[0].contract_type == 'day'){var dsaly=data[0].mf_salary;}else{var dsaly=data[0].salary;}
												crmth_manual_feed = parseFloat(crmth_manual_feed) + parseFloat(dsaly); 
											}

										
											if(v['pnd'] == 1){ pnd1 = 'pnd1';}else{ pnd1 = '';}
											if(data[0].calc_sso == 1 && v['sso'] == 1){ sso = 'sso';}else{ sso = '';}
											if(data[0].calc_pvf == 1 && v['pvf'] == 1){ pvf = 'pvf';}else{ pvf = '';}
											if(data[0].calc_psf == 1 && v['psf'] == 1){ psf = 'psf';}else{ psf = '';}
											if(v['tax_base'] == 'fixpro'){ tax_basefp = 'fixpro';}else{ tax_basefp = '';}
											if(v['tax_base'] == 'fix'){ tax_basef = 'fix';}else{ tax_basef = '';}
											if(v['tax_base'] == 'var'){ tax_basev = 'var';}else{ tax_basev = '';}
											if(v['tax_base'] == 'nontax'){ tax_basent = 'nontax';}else{ tax_basent = '';}

											allow_and_deduct_data +='<td class="tar '+currMnths+' '+pnd1+' '+sso+' '+pvf+' '+psf+' '+tax_basefp+' '+tax_basef+' '+tax_basev+' '+tax_basent+' '+taxbycom+' '+v['groups']+'">'+number_format(crmth_manual_feed)+'</td>';
											
										}else if(currmnth > i){ 
											
											if(get_prev_months_allowancesdeductss[i] == '[object Object]'){
												prmth_manual_feed = (get_prev_months_allowancesdeductss[i][k] > 0) ? get_prev_months_allowancesdeductss[i][k] : 0;
												if(v['groups'] == 'inc_sal'){
													prmth_manual_feed = parseFloat(prmth_manual_feed) + parseFloat(data[0].salary);
												}
											}


											if(v['pnd'] == 1){ pnd1 = 'pnd1';}else{ pnd1 = '';}
											if(data[0].calc_sso == 1 && v['sso'] == 1){ sso = 'sso';}else{ sso = '';}
											if(data[0].calc_pvf == 1 && v['pvf'] == 1){ pvf = 'pvf';}else{ pvf = '';}
											if(data[0].calc_psf == 1 && v['psf'] == 1){ psf = 'psf';}else{ psf = '';}
											if(v['tax_base'] == 'fixpro'){ tax_basefp = 'fixpro';}else{ tax_basefp = '';}
											if(v['tax_base'] == 'fix'){ tax_basef = 'fix';}else{ tax_basef = '';}
											if(v['tax_base'] == 'var'){ tax_basev = 'var';}else{ tax_basev = '';}
											if(v['tax_base'] == 'nontax'){ tax_basent = 'nontax';}else{ tax_basent = '';}

											allow_and_deduct_data +='<td class="tar prevMnth '+pnd1+' '+sso+' '+pvf+' '+psf+' '+tax_basefp+' '+tax_basef+' '+tax_basev+' '+tax_basent+' '+v['groups']+'">'+number_format(prmth_manual_feed)+'</td>';
										}else{

											if(v['pnd'] == 1){ pnd1 = 'pnd1';}else{ pnd1 = '';}
											if(data[0].calc_sso == 1 && v['sso'] == 1){ sso = 'sso';}else{ sso = '';}
											if(data[0].calc_pvf == 1 && v['pvf'] == 1){ pvf = 'pvf';}else{ pvf = '';}
											if(data[0].calc_psf == 1 && v['psf'] == 1){ psf = 'psf';}else{ psf = '';}
											if(v['tax_base'] == 'fixpro'){ tax_basefp = 'fixpro';}else{ tax_basefp = '';}
											if(v['tax_base'] == 'fix'){ tax_basef = 'fix';}else{ tax_basef = '';}
											if(v['tax_base'] == 'var'){ tax_basev = 'var';}else{ tax_basev = '';}
											if(v['tax_base'] == 'nontax'){ tax_basent = 'nontax';}else{ tax_basent = '';}
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
												//crmth_manual_feed = (manual_feed_total[k] > 0) ? manual_feed_total[k] : 0; 
												
												allow_and_deduct_data +='<td class="tar '+currMnths+' '+pnd1+' '+sso+' '+pvf+' '+psf+' '+tax_basefp+' '+tax_basef+' '+tax_basev+' '+tax_basent+' '+v['groups']+'">'+number_format(crmth_manual_feed)+'</td>';
											}else{
												allow_and_deduct_data +='<td class="tar '+currMnths+' '+pnd1+' '+sso+' '+pvf+' '+psf+' '+tax_basefp+' '+tax_basef+' '+tax_basev+' '+tax_basent+' '+v['groups']+'">0.00</td>';
											}
										}
									}
								})

								allow_and_deduct_data +='</tr>';
							}
						allow_and_deduct_data +='</tbody>';
									
					$('#Salarycalculator #linkedcolumnsSC').append(allow_and_deduct_data);
					//===================== Right side table data end ======================//

					//===================== Right side table data Start (Deduction) ======================//
					var defclmd = 1;
					var tot_countd = parseFloat(countDeduct) + parseFloat(defclmd);
					$('#Salarycalculator #linkedcolumnsSCD thead').remove();
					$('#Salarycalculator #linkedcolumnsSCD tbody').remove();

					var deduct_data = '<thead>';
						//deduct_data +='<tr><th colspan="'+tot_countd+'" class="tac text-danger"><?=$lng['DETAILS ALLOWANCES & DEDUCTIONS']?></th></tr>';
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
								var tax_basefp = '';
								var tax_basef = '';
								var tax_basev = '';
								var tax_basent = '';
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
											
											if(v['pnd'] == 1){ pnd1 = 'pnd1';}else{ pnd1 = '';}
											if(data[0].calc_sso == 1 && v['sso'] == 1){ sso = 'sso';}else{ sso = '';}
											if(data[0].calc_pvf == 1 && v['pvf'] == 1){ pvf = 'pvf';}else{ pvf = '';}
											if(data[0].calc_psf == 1 && v['psf'] == 1){ psf = 'psf';}else{ psf = '';}
											if(v['tax_base'] == 'fixpro'){ tax_basefp = 'fixpro';}else{ tax_basefp = '';}
											if(v['tax_base'] == 'fix'){ tax_basef = 'fix';}else{ tax_basef = '';}
											if(v['tax_base'] == 'var'){ tax_basev = 'var';}else{ tax_basev = '';}
											if(v['tax_base'] == 'nontax'){ tax_basent = 'nontax';}else{ tax_basent = '';}

											deduct_data +='<td class="tar '+currMnths+' '+pnd1+' '+sso+' '+pvf+' '+psf+' '+tax_basefp+' '+tax_basef+' '+tax_basev+' '+tax_basent+' '+extracls+' '+extraTax+' '+v['groups']+'">'+number_format(crmth_manual_feed)+'</td>';
											
										}else if(currmnth > i){ 

											if(get_prev_months_allowancesdeductss[i] == '[object Object]'){
												prmth_manual_feed = (get_prev_months_allowancesdeductss[i][k] > 0) ? get_prev_months_allowancesdeductss[i][k] : 0;
											}

											if(v['pnd'] == 1){ pnd1 = 'pnd1';}else{ pnd1 = '';}
											if(data[0].calc_sso == 1 && v['sso'] == 1){ sso = 'sso';}else{ sso = '';}
											if(data[0].calc_pvf == 1 && v['pvf'] == 1){ pvf = 'pvf';}else{ pvf = '';}
											if(data[0].calc_psf == 1 && v['psf'] == 1){ psf = 'psf';}else{ psf = '';}
											if(v['tax_base'] == 'fixpro'){ tax_basefp = 'fixpro';}else{ tax_basefp = '';}
											if(v['tax_base'] == 'fix'){ tax_basef = 'fix';}else{ tax_basef = '';}
											if(v['tax_base'] == 'var'){ tax_basev = 'var';}else{ tax_basev = '';}
											if(v['tax_base'] == 'nontax'){ tax_basent = 'nontax';}else{ tax_basent = '';}

											deduct_data +='<td class="tar prevMnth '+pnd1+' '+sso+' '+pvf+' '+psf+' '+tax_basefp+' '+tax_basef+' '+tax_basev+' '+tax_basent+' '+v['groups']+'">'+number_format(prmth_manual_feed)+'</td>';
										}else{

											if(v['pnd'] == 1){ pnd1 = 'pnd1';}else{ pnd1 = '';}
											if(data[0].calc_sso == 1 && v['sso'] == 1){ sso = 'sso';}else{ sso = '';}
											if(data[0].calc_pvf == 1 && v['pvf'] == 1){ pvf = 'pvf';}else{ pvf = '';}
											if(data[0].calc_psf == 1 && v['psf'] == 1){ psf = 'psf';}else{ psf = '';}
											if(v['tax_base'] == 'fixpro'){ tax_basefp = 'fixpro';}else{ tax_basefp = '';}
											if(v['tax_base'] == 'fix'){ tax_basef = 'fix';}else{ tax_basef = '';}
											if(v['tax_base'] == 'var'){ tax_basev = 'var';}else{ tax_basev = '';}
											if(v['tax_base'] == 'nontax'){ tax_basent = 'nontax';}else{ tax_basent = '';}
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
												if(k == 60){ crmth_manual_feed = parseFloat(data[0].tax_next_month); }
												
												deduct_data +='<td class="tar '+currMnths+' '+pnd1+' '+sso+' '+pvf+' '+psf+' '+tax_basefp+' '+tax_basef+' '+tax_basev+' '+tax_basent+' '+v['groups']+'">'+number_format(crmth_manual_feed)+'</td>';
											}else{

												if(k == 57){ 
													var sso_thb = data[0].sso_employee;
													crmth_manual_feed = parseFloat(sso_thb); 
												}
												if(k == 60){ crmth_manual_feed = parseFloat(data[0].tax_next_month); }

												deduct_data +='<td class="tar '+currMnths+' '+pnd1+' '+sso+' '+pvf+' '+psf+' '+tax_basefp+' '+tax_basef+' '+tax_basev+' '+tax_basent+' '+v['groups']+'">'+number_format(crmth_manual_feed)+'</td>';
											}
										}
									}
								})

								deduct_data +='</tr>';
							}
						deduct_data +='</tbody>';
									
					$('#Salarycalculator #linkedcolumnsSCD').append(deduct_data);
					//===================== Right side table data end ======================//

					$('#Salarycalculator #empids').text(data[0].emp_id);
					$('#Salarycalculator #deptval').text(data.department);
					$('#Salarycalculator #contract_type').text(data.contract_type);
					$('#Salarycalculator #calc_tax').text(data.calc_tax);
					$('#Salarycalculator #calc_sso').text(data.calc_sso);
					
					if(data.calc_sso == 'Yes'){ $('#Salarycalculator #modalssopopup').css('display','table-row'); }else{ $('#Salarycalculator #modalssopopup').css('display','none'); }
					if(data.calc_pvf == 'Yes'){ $('#Salarycalculator #modalpvfpopup').css('display','table-row'); }else{ $('#Salarycalculator #modalpvfpopup').css('display','none'); }
					if(data.calc_psf == 'Yes'){ $('#Salarycalculator #modalpsfpopup').css('display','table-row'); }else{ $('#Salarycalculator #modalpsfpopup').css('display','none'); }


					$('#Salarycalculator #emp_name').text(data[0].emp_name_en);
					$('#Salarycalculator #teamval').text(data.team);
					$('#Salarycalculator #tax_calc_method').text(data[0].calc_method);

					if(data.calc_pvf == 'Yes'){
						$('#Salarycalculator #pvfpsfLbl').text('<?=$lng['Calculate PVF']?>');
						$('#Salarycalculator #calc_pvf').text(data.calc_pvf);
					}else if(data.calc_psf == 'Yes'){
						$('#Salarycalculator #pvfpsfLbl').text('<?=$lng['Calculate PSF']?>');
						$('#Salarycalculator #calc_pvf').text(data.calc_psf);
					}else{
						$('#Salarycalculator #pvfpsfLbl').text('');
						$('#Salarycalculator #calc_pvf').text('');
					}

					//$('#Salarycalculator #calc_pvf').text(data.calc_pvf);
					//$('#Salarycalculator #calc_psf').text(data.calc_psf);

					$('#Salarycalculator #position_val').text(data.position);
					$('#Salarycalculator #calc_base').text(data.calc_base);

					
					$('#Salarycalculator #ear_curr_calc').text(number_format(data[0].total_earnings));
					$('#Salarycalculator #ear_curr_mnth').text(number_format(data[0].total_earnings));
					$('#Salarycalculator #ear_prev_mnth').text(number_format(data[0].total_earnings_prev));
					$('#Salarycalculator #ear_full_year').text(number_format(data[0].full_year_earnings));

					$('#Salarycalculator #ded_curr_calc').text(number_format(data[0].total_deductions));
					$('#Salarycalculator #ded_curr_mnth').text(number_format(data[0].total_deductions));
					$('#Salarycalculator #ded_prev_mnth').text(number_format(data[0].total_deductions_prev));
					$('#Salarycalculator #ded_full_year').text(number_format(data[0].full_year_deductions));

					$('#Salarycalculator #pnd_curr_calc').text(number_format(data[0].total_pnd1));
					$('#Salarycalculator #pnd_curr_mnth').text(number_format(data[0].total_pnd1));
					$('#Salarycalculator #pnd_prev_mnth').text(number_format(data[0].total_pnd1_prev));
					$('#Salarycalculator #pnd_full_year').text(number_format(data[0].full_year_pnd));

					$('#Salarycalculator #sso_curr_calc').text(number_format(data[0].total_sso));
					$('#Salarycalculator #sso_curr_mnth').text(number_format(data[0].total_sso));
					$('#Salarycalculator #sso_prev_mnth').text(number_format(data[0].total_sso_prev));
					$('#Salarycalculator #sso_full_year').text(number_format(data[0].full_year_sso));

					$('#Salarycalculator #pvf_curr_calc').text(number_format(data[0].total_pvf));
					$('#Salarycalculator #pvf_curr_mnth').text(number_format(data[0].total_pvf));
					$('#Salarycalculator #pvf_prev_mnth').text(number_format(data[0].total_pvf_prev));
					$('#Salarycalculator #pvf_full_year').text(number_format(data[0].full_year_pvf));

					$('#Salarycalculator #psf_curr_calc').text(number_format(data[0].total_psf));
					$('#Salarycalculator #psf_curr_mnth').text(number_format(data[0].total_psf));
					$('#Salarycalculator #psf_prev_mnth').text(number_format(data[0].total_psf_prev));
					$('#Salarycalculator #psf_full_year').text(number_format(data[0].full_year_psf));

					$('#Salarycalculator #fixpro_curr_calc').text(number_format(data[0].total_tax_fixpro));
					$('#Salarycalculator #fixpro_curr_mnth').text(number_format(data[0].total_tax_fixpro));
					$('#Salarycalculator #fixpro_prev_mnth').text(number_format(data[0].total_tax_fixpro_prev));
					$('#Salarycalculator #fixpro_full_year').text(number_format(data[0].full_year_fixprorated));

					$('#Salarycalculator #fix_curr_calc').text(number_format(data[0].total_tax_fix));
					$('#Salarycalculator #fix_curr_mnth').text(number_format(data[0].total_tax_fix));
					$('#Salarycalculator #fix_prev_mnth').text(number_format(data[0].total_tax_fix_prev));
					$('#Salarycalculator #fix_full_year').text(number_format(data[0].full_year_fixed));

					$('#Salarycalculator #var_curr_calc').text(number_format(data[0].total_tax_var));
					$('#Salarycalculator #var_curr_mnth').text(number_format(data[0].total_tax_var));
					$('#Salarycalculator #var_prev_mnth').text(number_format(data[0].total_tax_var_prev));
					$('#Salarycalculator #var_full_year').text(number_format(data[0].full_year_var));

					$('#Salarycalculator #totalffv_curr_calc').text(number_format(data[0].total_of_alltax));
					$('#Salarycalculator #totalffv_curr_mnth').text(number_format(data[0].total_of_alltax));
					$('#Salarycalculator #totalffv_prev_mnth').text(number_format(data[0].total_of_alltax_prev));
					$('#Salarycalculator #totalffv_full_year').text(number_format(data[0].full_year_taxableincome));

					$('#Salarycalculator #nontax_curr_calc').text(number_format(data[0].total_tax_nontax));
					$('#Salarycalculator #nontax_curr_mnth').text(number_format(data[0].total_tax_nontax));
					$('#Salarycalculator #nontax_prev_mnth').text(number_format(data[0].total_tax_nontax_prev));
					$('#Salarycalculator #nontax_full_year').text(number_format(data[0].full_year_non_taxable));

					$('#Salarycalculator #sso_emp_curr_calc').text(number_format(data[0].sso_employee));
					$('#Salarycalculator #sso_emp_curr_mnth').text(number_format(data[0].sso_employee));
					$('#Salarycalculator #sso_emp_prev_mnth').text(number_format(data[0].sso_employee_prev));
					$('#Salarycalculator #sso_emp_full_year').text(number_format(data[0].full_year_sso_employee));

					$('#Salarycalculator #pvf_emp_curr_calc').text(number_format(data[0].pvf_employee));
					$('#Salarycalculator #pvf_emp_curr_mnth').text(number_format(data[0].pvf_employee));
					$('#Salarycalculator #pvf_emp_prev_mnth').text(number_format(data[0].pvf_employee_prev));
					$('#Salarycalculator #pvf_emp_full_year').text(number_format(data[0].full_year_pvf_employee));

					$('#Salarycalculator #psf_emp_curr_calc').text(number_format(data[0].psf_employee));
					$('#Salarycalculator #psf_emp_curr_mnth').text(number_format(data[0].psf_employee));
					$('#Salarycalculator #psf_emp_prev_mnth').text(number_format(data[0].psf_employee_prev));
					$('#Salarycalculator #psf_emp_full_year').text(number_format(data[0].full_year_psf_employee));

					$('#Salarycalculator #tax_emp_curr_calc').text(number_format(data[0].tax_this_month));
					$('#Salarycalculator #tax_emp_curr_mnth').text(number_format(data[0].tax_this_month));
					$('#Salarycalculator #tax_emp_prev_mnth').text(number_format(data[0].tax_previous));
					$('#Salarycalculator #tax_emp_full_year').text(number_format(data[0].total_tax_year));

					$('#Salarycalculator #td_emp_curr_calc').text('');
					$('#Salarycalculator #td_emp_curr_mnth').text('');
					$('#Salarycalculator #td_emp_prev_mnth').text('');
					$('#Salarycalculator #td_emp_full_year').text(number_format(data[0].total_yearly_tax_deductions));

					$('#Salarycalculator #ssobycom_curr_calc').text(number_format(data[0].sso_by_company));
					$('#Salarycalculator #ssobycom_curr_mnth').text(number_format(data[0].sso_by_company));
					$('#Salarycalculator #ssobycom_prev_mnth').text(number_format(data[0].sso_by_company_prev));
					$('#Salarycalculator #ssobycom_full_year').text(0);

					$('#Salarycalculator #taxbycom_curr_calc').text(number_format(data[0].tax_by_company));
					$('#Salarycalculator #taxbycom_curr_mnth').text(number_format(data[0].tax_by_company));
					$('#Salarycalculator #taxbycom_prev_mnth').text(number_format(data[0].tax_previous));
					$('#Salarycalculator #taxbycom_full_year').text(0);

					$('#Salarycalculator #total_net_income_cur_cal').text(number_format(data[0].total_net_income));
					$('#Salarycalculator #total_net_income_cur_mnth').text(number_format(data[0].total_net_income));
					$('#Salarycalculator #total_net_income_prev_mnth').text(number_format(data[0].total_net_income_prev));
					$('#Salarycalculator #total_net_income_fullyear').text(number_format(data[0].fullyear_net_income));


					$('#Salarycalculator #total_net_pay_cur_cal').text(number_format(data[0].total_net_pay));
					$('#Salarycalculator #total_net_pay_cur_mnth').text(number_format(data[0].total_net_pay));
					$('#Salarycalculator #total_net_pay_prev_mnth').text(number_format(data[0].total_net_pay_prev));
					$('#Salarycalculator #total_net_pay_fullyear').text(number_format(data[0].fullyear_net_pay));

				
					$('#Salarycalculator').modal('toggle');

					$('#linkedcolumnsSC').DataTable().destroy();
					$('#linkedcolumnsSCD').DataTable().destroy();


					var dtablesmdl = $('#linkedcolumnsSC').DataTable({
						//scrollX: true,
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
							{"targets": eColsMdlA, "visible": false, "searchable": false},
							//{ width: '10%', targets: "tac" }
						],
						
					});

					var dtablesmdld = $('#linkedcolumnsSCD').DataTable({
						
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
							{"targets": eColsMdlD, "visible": false, "searchable": false},
							//{ width: '10%', targets: "tac" }
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
	
	function modal_tax(){

		var empids = $('#Salarycalculator #empids').text();
		var mid = '<?=$_GET['mid']?>';
		if(empids !=''){

			$.ajax({
				type: 'post',
				url: "ajax/get_payroll_data.php",
				async: false,
				data: {empid: empids,mid:mid},
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

						$('#modalTAX #tx_spread_var_income').text('-');
						$('#modalTAX #tx_calc_base').text(data.calc_base);
						$('#modalTAX #tx_calc_tax').text(data.calc_tax);
						$('#modalTAX select#tx_calc_method option[value="'+data[0].calc_method+'"]').attr('selected',true);

						$('#modalTAX #tx_tax_deduction').text(number_format(data[0].total_yearly_tax_deductions));
						$('#modalTAX #tx_tax_deduction_ytd').text(number_format(data[0].total_yearly_tax_deductions));
						$('#modalTAX #tx_tax_deduction_cam').text(number_format(data[0].total_yearly_tax_deductions));

						$('#modalTAX #tx_fixed_actual').text(number_format(data[0].fixed_actual_yearly));

						$('#modalTAX #tx_var_prev').text(number_format(data[0].variable_prev));
						$('#modalTAX #tx_var_prev_cam').text(number_format(data[0].variable_prev));
						
						$('#modalTAX #tx_var_curr').text(number_format(data[0].variable_curr));
						$('#modalTAX #tx_var_curr_cam').text(number_format(data[0].variable_curr));


						$('#modalTAX #tx_acm_fix1').text(data[0].acm_fix);
						$('#modalTAX #tx_acm_fix_prev1').text(data[0].acm_fix_prev);
						$('#modalTAX #tx_acm_fix_prev_var1').text(data[0].acm_fix_prev_var);

						$('#modalTAX #tx_acm_fix2').text(number_format(data[0].acm_fix_tax_calc));
						$('#modalTAX #tx_acm_fix_prev2').text(number_format(data[0].acm_fix_prev_tax_calc));
						$('#modalTAX #tx_acm_fix_prev_var2').text(number_format(data[0].acm_fix_prev_var_tax_calc));


						$('#modalTAX #tx_income_ytd').text(number_format(data[0].income_YTD));
						$('#modalTAX #tx_taxincome_ytd').text(data[0].ytd_income);
						$('#modalTAX #tx_tax_ytd').text(number_format(data[0].tax_ytd));

						$('#modalTAX #tx_fixedx12_cam').text(number_format(data[0].fixed_yearly));

						$('#modalTAX #tx_cam_fix1').text(data[0].cam_fix);
						$('#modalTAX #tx_cam_fix_prev1').text(data[0].cam_fix_prev);
						$('#modalTAX #tx_cam_fix_prev_var1').text(data[0].cam_fix_prev_var);

						$('#modalTAX #tx_cam_fix2').text(number_format(data[0].cam_fix_tax_calc));
						$('#modalTAX #tx_cam_fix_prev2').text(number_format(data[0].cam_fix_prev_tax_calc));
						$('#modalTAX #tx_cam_fix_prev_var2').text(number_format(data[0].cam_fix_prev_var_tax_calc));


						$('#modalTAX #tx_tot_tax_year_'+data[0].calc_method).text(number_format(data[0].total_tax_year));
						$('#modalTAX #tx_tot_prev_mnth_'+data[0].calc_method).text(number_format(data[0].tax_previous));
						$('#modalTAX #tx_tax_remaining_'+data[0].calc_method).text(number_format(data[0].tax_remaining));
						$('#modalTAX #tx_fix_this_mnth_'+data[0].calc_method).text(number_format(data[0].tax_fix_month));
						$('#modalTAX #tx_var_this_mnth_'+data[0].calc_method).text(number_format(data[0].tax_var_month));
						$('#modalTAX #tx_tax_this_mnth_'+data[0].calc_method).text(number_format(data[0].tax_this_month));
						$('#modalTAX #tx_tot_tax_next_mnth_'+data[0].calc_method).text(number_format(data[0].tax_tot_next_month));
						$('#modalTAX #tx_tax_next_mnth_'+data[0].calc_method).text(number_format(data[0].tax_next_month));
						$('#modalTAX #tx_tax_by_company_'+data[0].calc_method).text(number_format(data[0].tax_by_company));


						$('#modalTAX').modal('toggle');

					}
				}
			})

		}else{
			$("body").overhang({
				type: "error",
				message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: Error in employee id',
				duration: 3,
			})
		}
	}


	function modal_tax_deduction(){

		var empids = $('#Salarycalculator #empids').text();
		var mid = '<?=$_GET['mid']?>';

		if(empids !=''){

			var get_sso_pvf_full_year_thbss = get_sso_pvf_full_year_thb(empids);

			$.ajax({
				type: 'post',
				url: "ajax/get_payroll_data.php",
				async: false,
				data: {empid: empids,mid:mid},
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
						//console.log(data);

						//===================== SSO & PVF full year ================================//
						if(get_sso_pvf_full_year_thbss != 'error'){

							var pperiods = <?=json_encode($pperiods)?>;
							var short_months = <?=json_encode($short_months)?>;
							var curryear = <?=substr($_SESSION['rego']['cur_year'], -2)?>;

							//console.log(get_sso_pvf_full_year_thbss);
							//console.log(pperiods);
							// console.log(short_months);

							//append_full_table
							var tbl = '';
							var total_sso = 0.00;
							var total_pvf = 0.00;
							$.each(pperiods, function(k,v){

								var sso_thb=0.00;
								var pvf_thb=0.00;
								
								if(get_sso_pvf_full_year_thbss[k] == '[object Object]'){ 
									
									if(get_sso_pvf_full_year_thbss[k]['sso_employee'] > 0){
										sso_thb = get_sso_pvf_full_year_thbss[k]['sso_employee'];
									}

									if(get_sso_pvf_full_year_thbss[k]['pvf_employee'] > 0){
										pvf_thb = get_sso_pvf_full_year_thbss[k]['pvf_employee'];
									} 

								}else{
									sso_thb = (data[0].total_sso * v['sso_eRate']);

									if(sso_thb > v['sso_eMax']){ sso_thb = v['sso_eMax'];}
									else if(sso_thb < v['sso_eMin']){ sso_thb = v['sso_eMin'];}

									
									pvf_thb = data[0].pvf_employee;
								}

								sso_thb = parseFloat(sso_thb).toFixed(2);
								pvf_thb = parseFloat(pvf_thb).toFixed(2);

								total_sso = parseFloat(total_sso) + parseFloat(sso_thb);
								total_pvf = parseFloat(total_pvf) + parseFloat(pvf_thb);

								tbl += '<tr>';
								tbl += '<th class="tac">'+short_months[k]+'-'+curryear+'</th>';
								tbl += '<td class="tar" >'+v['sso_eRate']+'</td>';
								tbl += '<td class="tar" >'+v['sso_eMin']+'</td>';
								tbl += '<td class="tar" >'+v['sso_eMax']+'</td>';
								tbl += '<td class="tar" >'+sso_thb+'</td>';
								tbl += '<td class="tar" >'+pvf_thb+'</td>';
								tbl += '</tr>';

							});

							total_sso = parseFloat(total_sso).toFixed(2);
							total_pvf = parseFloat(total_pvf).toFixed(2);

							tbl += '<tr>';
							tbl += '<th class="tac">Total</th>';
							tbl += '<td></td>';
							tbl += '<td></td>';
							tbl += '<td></td>';
							tbl += '<td class="tar font-weight-bold">'+number_format(total_sso)+'</td>';
							tbl += '<td class="tar font-weight-bold">'+number_format(total_pvf)+'</td>';
							tbl += '</tr>';

							$('#append_full_table tr').remove();
							$('#append_full_table').append(tbl);
						}
						//===================== SSO & PVF full year ================================//

						$('#modalTAXDeduction #td_empid').text(data[0].emp_id);
						$('#modalTAXDeduction #td_empname').text(data[0].emp_name_en);

						$('#modalTAXDeduction #td_std_clcthb').text(data.calc_on_sd);
						$('#modalTAXDeduction #td_pcare_clcthb').text(data.calc_on_pc);
						$('#modalTAXDeduction #td_pvf_clcthb').text(data.calc_on_pf);
						$('#modalTAXDeduction #td_sso_clcthb').text(data.calc_on_ssf);

						$('#modalTAXDeduction #fixed_actual_income_std').text(data[0].tax_standard_deduction);
						$('#modalTAXDeduction #fixed_actual_income_pcare').text(data[0].tax_personal_allowance);

						//Calculation Standard deduction
						var std_fixed_actual = $('#fixed_actual_income_std').text();

						var subtotal_std = std_fixed_actual;
						if(data.calc_on_sd != 'THB'){
							var multiply_bys = parseFloat(std_fixed_actual * 0.5);
							subtotal_std = multiply_bys;

							if(multiply_bys > 100000){
								subtotal_std = 100000;
							}
						}

						$('#modalTAXDeduction #subtotal_std').text(subtotal_std);


						$('#modalTAXDeduction #td_manual_std').val(data[0].standard_deduction_manual);

						var td_manual_std = $('#td_manual_std').val();
						var td_std_deduct = subtotal_std;
						if(td_manual_std > 0){
							td_std_deduct = parseFloat(subtotal_std) + parseFloat(td_manual_std);
						}
						$('#modalTAXDeduction #td_std_deduct').text(td_std_deduct);

						//Calculation Personal Care
						var pcare_fixed_actual = $('#fixed_actual_income_pcare').text();
						var subtotal_pcare = pcare_fixed_actual;
						if(data.calc_on_pc != 'THB'){

							var multiply_byp = parseFloat(pcare_fixed_actual * 0.4);
							subtotal_pcare = multiply_byp;
							if(multiply_byp > 60000){
								subtotal_pcare = 60000;
							}
						}
						$('#modalTAXDeduction #subtotal_pcare').text(subtotal_pcare);
						$('#modalTAXDeduction #td_manual_pcare').val(data[0].personal_care_manual);

						var td_manual_pcare = $('#td_manual_pcare').val();
						var td_pcare_deduct = subtotal_pcare;
						if(td_manual_pcare > 0){
							td_pcare_deduct = parseFloat(subtotal_pcare) + parseFloat(td_manual_pcare);
						}
						$('#modalTAXDeduction #td_pcare_deduct').text(td_pcare_deduct);


						$('#modalTAXDeduction #td_std_deduction').text(td_std_deduct);
						$('#modalTAXDeduction #td_pers_care').text(td_pcare_deduct);
						var td_pvf_deduct = data[0].full_year_pvf_employee;
						var td_sso_deduct = data[0].full_year_sso_employee;
						$('#modalTAXDeduction #td_pvf_empsss').text(td_pvf_deduct);
						$('#modalTAXDeduction #td_sso_empsss').text(td_sso_deduct);

						$('#modalTAXDeduction #td_other_deduct').text(data[0].total_other_tax_deductions);

						var sum_all_deduction = parseFloat(td_std_deduct) + parseFloat(td_pcare_deduct) + parseFloat(td_sso_deduct) + parseFloat(td_pvf_deduct) + parseFloat(data[0].total_other_tax_deductions);
						var tb_sum_all = parseFloat(sum_all_deduction).toFixed(2);
						$('#modalTAXDeduction #td_total_tax_deduct').text(number_format(tb_sum_all));

						//$('#modalTAXDeduction #td_pvf_emp').text(data[0].pvf_rate_emp);

						$('#modalTAXDeduction').modal('show');
					}
				}
			})

		}else{
			$("body").overhang({
				type: "error",
				message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: Error in employee id',
				duration: 3,
			})
		}
	}

	function get_sso_pvf_full_year_thb(empid){
		// alert(empid);
		var data;
		if(empid !=''){
			$.ajax({
				type: 'post',
				url: "ajax/get_sso_pvf_data.php",
				async: false,
				data: {empid: empid},
				success: function(result){
					data = JSON.parse(result);
				}
			})
		}
		return data;
	}

	function tax_deduct_calc(that){

		var td_std_clcthb = $('#td_std_clcthb').text();
		var td_pcare_clcthb = $('#td_pcare_clcthb').text();

		//Calculation Standard deduction
		var std_fixed_actual = $('#fixed_actual_income_std').text();
		var subtotal_std = std_fixed_actual;
		if(td_std_clcthb != 'THB'){
			var multiply_bys = parseFloat(std_fixed_actual * 0.5);

			subtotal_std = multiply_bys;
			if(multiply_bys > 100000){
				subtotal_std = 100000;
			}
		}
		$('#modalTAXDeduction #subtotal_std').text(subtotal_std);

		var td_manual_std = $('#td_manual_std').val();
		var td_std_deduct = subtotal_std;
		if(td_manual_std > 0){
			td_std_deduct = parseFloat(subtotal_std) + parseFloat(td_manual_std);
		}
		$('#modalTAXDeduction #td_std_deduct').text(td_std_deduct);

		//Calculation Personal Care
		var pcare_fixed_actual = $('#fixed_actual_income_pcare').text();
		var subtotal_pcare = pcare_fixed_actual;
		if(td_pcare_clcthb != 'THB'){
			var multiply_byp = (pcare_fixed_actual * 0.4);
			subtotal_pcare = multiply_byp;
			if(multiply_byp > 60000){
				subtotal_pcare = 60000;
			}
		}
		$('#modalTAXDeduction #subtotal_pcare').text(subtotal_pcare);

		var td_manual_pcare = $('#td_manual_pcare').val();
		var td_pcare_deduct = subtotal_pcare;
		if(td_manual_pcare > 0){
			td_pcare_deduct = parseFloat(subtotal_pcare) + parseFloat(td_manual_pcare);
		}
		$('#modalTAXDeduction #td_pcare_deduct').text(td_pcare_deduct);


		$('#modalTAXDeduction #td_std_deduction').text(td_std_deduct);
		$('#modalTAXDeduction #td_pers_care').text(td_pcare_deduct);
		
		var td_pvf_deduct = $('#td_pvf_empsss').text();
		var td_sso_deduct = $('#td_sso_empsss').text();
		
		var total_other_tax_deduction = $('#td_other_deduct').text();
		var sum_all_deduction = parseFloat(td_std_deduct) + parseFloat(td_pcare_deduct) + parseFloat(td_sso_deduct) + parseFloat(td_pvf_deduct) + parseFloat(total_other_tax_deduction);
		var tb_sum_all = parseFloat(sum_all_deduction).toFixed(2);
		$('#modalTAXDeduction #td_total_tax_deduct').text(number_format(tb_sum_all));
	}

	function modal_pvf(){

		var empids = $('#Salarycalculator #empids').text();
		var mid = '<?=$_GET['mid']?>';
		if(empids !=''){
			var get_sso_pvf_full_year_thbss = get_sso_pvf_full_year_thb(empids);
			$.ajax({
				type: 'post',
				url: "ajax/get_payroll_data.php",
				data: {empid: empids,mid:mid},
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
						//console.log(data);
						var payroll_datass = data.payroll_data;

						$('#modalPVF #pvf_empid').text(data[0].emp_id);
						$('#modalPVF #pvfEmpid').val(data[0].emp_id);
						$('#modalPVF #pvf_empname').text(data[0].emp_name_en);

						$('#modalPVF select[name="pvf_calc_pvf"] option[value="'+data[0].calc_pvf+'"]').attr('selected',true);
						$('#modalPVF select[name="pf_paidby_pvf"] option[value="'+data[0].perc_thb_pvf+'"]').attr('selected',true);

						$('#modalPVF #pvf_income_pvf_emp').text(number_format(data[0].total_pvf));

						//pvf_calculate_emp
						var pvf_calc_pvf = $('select[name="pvf_calc_pvf"]').val();
						var pvf_paidby_pvf = $('select[name="pf_paidby_pvf"]').val();
						//alert(pvf_paidby_pvf);
						
						//===================== SSO & PVF full year ================================//
						var pperiods = <?=json_encode($pperiods)?>;
						var short_months = <?=json_encode($short_months)?>;
						var curryear = <?=substr($_SESSION['rego']['cur_year'], -2)?>;

						var total_Pvf_emp = 0.00;
						var total_Pvf_com = 0.00;

						if(pvf_paidby_pvf == 2){
							var pvf_emp = parseFloat(data[0].pvf_rate_emp);
							var pvf_com = parseFloat(data[0].pvf_rate_com);
							var rate_emp = '';
							var rate_com = '';
						}else{
							var pvf_emp = parseFloat(data[0].total_pvf * data[0].pvf_rate_emp)/100;
							var pvf_com = parseFloat(data[0].total_pvf * data[0].pvf_rate_com)/100;
							var rate_emp = data[0].pvf_rate_emp;
							var rate_com = data[0].pvf_rate_com;
						}
						
						
						var tbl=''; 
						var i1;
						for (i1=1; i1 <= 12; i1++) { 

							var monthss = short_months[i1];
							var monthssLower = monthss.toLowerCase();
							
							var pvf_emp_val = 0.00;
							var pvf_com_val = 0.00;

							if(pvf_calc_pvf == 1){
							//if(psf_calc_sso == 1 && i1 >= data[0].month){
								//var psf_emp_val = psf_emp;
								//var psf_com_val = psf_com;
								pvf_emp_val = payroll_datass[58][monthssLower];
								pvf_com_val = payroll_datass['pvfemployer'][monthssLower];
							}	

							tbl += '<tr>';
								tbl += '<th class="tac">'+short_months[i1]+'-'+curryear+'</th>';
								tbl += '<td class="tar">'+rate_emp+'</td>';
								tbl += '<td class="tar">'+rate_com+'</td>';
								tbl += '<td class="tar" style="padding:0px;"><input type="text" id="pvfemp_'+i1+'" name="pvfemp['+i1+']" class="float72 text-right" value="'+number_format(pvf_emp_val)+'" style="background: #eeffee;" readonly></td>';
								tbl += '<td class="tar" style="padding:0px;"><input type="text" id="pvfcom_'+i1+'" name="pvfcom['+i1+']" class="float72 text-right" value="'+number_format(pvf_com_val)+'" style="background: #eeffee;" readonly></td>';
							tbl += '</tr>';

							total_Pvf_emp = parseFloat(total_Pvf_emp) + parseFloat(pvf_emp_val);
							total_Pvf_com = parseFloat(total_Pvf_com) + parseFloat(pvf_com_val);
						}

					

						tbl += '<tr>';
						tbl += '<th class="tac">Total</th>';
						tbl += '<td class="tar"></td>';
						tbl += '<td class="tar"></td>';
						tbl += '<td class="tar font-weight-bold">'+number_format(total_Pvf_emp)+'</td>';
						tbl += '<td class="tar font-weight-bold">'+number_format(total_Pvf_com)+'</td>';
						
						tbl += '</tr>';

						$('#append_full_table_pvf tr').remove();
						$('#append_full_table_pvf').append(tbl);
					
						//===================== SSO & PVF full year ================================//

						$('#modalPVF').modal('show');
					}
				}
			})

		}else{
			$("body").overhang({
				type: "error",
				message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: Error in employee id',
				duration: 3,
			})
		}
	}

	function PVF_calc(that){

		var pvf_calc_pvf = $('select[name="pvf_calc_pvf"]').val();
		var pvf_paidby_pvf = $('select[name="pf_paidby_pvf"]').val();

		var pvf_manual_emp = $('#pvf_manual_emp').val();
		var pvf_manual_comp = $('#pvf_manual_comp').val();

		//pvf_calculate_emp	
		var pvf_income_pvf_emp = $('#pvf_income_pvf_emp').text();
		var pvf_rate_pvf_emp = $('#pvf_rate_pvf_emp').text();
		var rate_pvf_emp = pvf_rate_pvf_emp.replace('%','');
		var getvalueEmp = rate_pvf_emp / 100;

		var pvf_calc_emp = 0;
		if(pvf_calc_pvf == 1){
			if(getvalueEmp > 0){
				pvf_calc_emp = parseFloat(pvf_income_pvf_emp) + parseFloat(getvalueEmp);
			}else{
				pvf_calc_emp = $('#pvf_amt_thb_emp').text();
			}
		}

		$('#modalPVF #pvf_calculate_emp').text(pvf_calc_emp);

	
		var pvf_pvfemp_empss = pvf_calc_emp;
		if(pvf_manual_emp > 0){
			pvf_pvfemp_empss = parseFloat(pvf_calc_emp) + parseFloat(pvf_manual_emp);
		}

		$('#modalPVF #pvf_pvfemp_emp').text(pvf_pvfemp_empss);


		//pvf_calculate_comp
		var pvf_income_pvf_comp = $('#pvf_income_pvf_comp').text();
		var pvf_rate_pvf_comp = $('#pvf_rate_pvf_comp').text();
		var rate_pvf_comp = pvf_rate_pvf_comp.replace('%','');
		var getvalueComp = rate_pvf_comp / 100;

		var pvf_calc_comp = 0;
		if(pvf_calc_pvf == 1){
			if(getvalueComp > 0){
				pvf_calc_comp = parseFloat(pvf_income_pvf_comp) + parseFloat(getvalueComp);
			}else{
				pvf_calc_comp = $('#pvf_amt_thb_emp').text();
			}
		}

		$('#modalPVF #pvf_calculate_comp').text(pvf_calc_comp);

		var pvf_pvfcom_comp = pvf_calc_comp;
		if(pvf_manual_comp > 0){
			pvf_pvfcom_comp = parseFloat(pvf_calc_comp) + parseFloat(pvf_manual_comp);
		}

		$('#modalPVF #pvf_pvfcom_comp').text(pvf_pvfcom_comp);

		if($("#modalPVF input[name='pvfManual']").is(':checked')){
			manualpvfinput(true);
		}else{
			manualpvfinput(false);
		}

		//fetch sso again
		modal_pvf();

	}

	function modal_psf(){

		var empids = $('#Salarycalculator #empids').text();
		var mid = '<?=$_GET['mid']?>';
		if(empids !=''){
			var get_sso_pvf_full_year_thbss = get_sso_pvf_full_year_thb(empids);
			$.ajax({
				type: 'post',
				url: "ajax/get_payroll_data.php",
				data: {empid: empids,mid:mid},
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
						//console.log(data);
						var payroll_datass = data.payroll_data;

						$('#modalPSF #psf_empid').text(data[0].emp_id);
						$('#modalPSF #psfEmpid').val(data[0].emp_id);
						$('#modalPSF #psf_empname').text(data[0].emp_name_en);

						$('#modalPSF #psf_income_emp').text(number_format(data[0].total_psf));
						//$('#modalPSF #psf_income_comp').text(data[0].total_psf);

						$('#modalPSF select[name="psf_calc_sso"] option[value="'+data[0].calc_psf+'"]').attr('selected',true);
						$('#modalPSF select[name="pf_paidby_psf"] option[value="'+data[0].perc_thb_psf+'"]').attr('selected',true);

						var psf_calc_sso = $('select[name="psf_calc_sso"]').val();
						var pf_paidby_psf = $('select[name="pf_paidby_psf"]').val();


						//===================== SSO & PVF full year ================================//
						var pperiods = <?=json_encode($pperiods)?>;
						var short_months = <?=json_encode($short_months)?>;
						var curryear = <?=substr($_SESSION['rego']['cur_year'], -2)?>;

						var total_Psf_emp = 0.00;
						var total_Psf_com = 0.00;

						if(pf_paidby_psf == 2){
							var psf_emp = parseFloat(data[0].psf_rate_emp);
							var psf_com = parseFloat(data[0].psf_rate_com);
							var rate_emp = '';
							var rate_com = '';
						}else{
							var psf_emp = parseFloat(data[0].total_psf * data[0].psf_rate_emp)/100;
							var psf_com = parseFloat(data[0].total_psf * data[0].psf_rate_com)/100;
							var rate_emp = data[0].psf_rate_emp;
							var rate_com = data[0].psf_rate_com;
						}
						
						var tbl=''; 
						var i1;
						for (i1=1; i1 <= 12; i1++) { 

							var monthss = short_months[i1];
							var monthssLower = monthss.toLowerCase();
							
							var psf_emp_val = 0.00;
							var psf_com_val = 0.00;

							if(psf_calc_sso == 1 && i1 >= data[0].month){
								//var psf_emp_val = psf_emp;
								//var psf_com_val = psf_com;
								psf_emp_val = payroll_datass[59][monthssLower];
								psf_com_val = payroll_datass['psfemployer'][monthssLower];
							}else{
								psf_emp_val = psf_emp;
								psf_com_val = psf_com;
							}	
							 
							tbl += '<tr>';
								tbl += '<th class="tac">'+short_months[i1]+'-'+curryear+'</th>';
								tbl += '<td class="tar">'+rate_emp+'</td>';
								tbl += '<td class="tar">'+rate_com+'</td>';
								tbl += '<td class="tar" style="padding:0px;"><input type="text" id="psfemp_'+i1+'" name="psfemp['+i1+']" class="float72 text-right" value="'+number_format(psf_emp_val)+'" style="background: #eeffee;" readonly></td>';
								tbl += '<td class="tar" style="padding:0px;"><input type="text" id="psfcom_'+i1+'" name="psfcom['+i1+']" class="float72 text-right" value="'+number_format(psf_com_val)+'" style="background: #eeffee;" readonly></td>';
							tbl += '</tr>';

							total_Psf_emp = parseFloat(total_Psf_emp) + parseFloat(psf_emp_val);
							total_Psf_com = parseFloat(total_Psf_com) + parseFloat(psf_com_val);
						}

					

						tbl += '<tr>';
						tbl += '<th class="tac">Total</th>';
						tbl += '<td class="tar"></td>';
						tbl += '<td class="tar"></td>';
						tbl += '<td class="tar font-weight-bold">'+number_format(total_Psf_emp)+'</td>';
						tbl += '<td class="tar font-weight-bold">'+number_format(total_Psf_com)+'</td>';
						
						tbl += '</tr>';

						$('#append_full_table_psf tr').remove();
						$('#append_full_table_psf').append(tbl);
						//===================== SSO & PVF full year ================================//

						$('#modalPSF').modal('show');
					}
				}
			})

		}else{
			$("body").overhang({
				type: "error",
				message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: Error in employee id',
				duration: 3,
			})
		}
	}

	function PSF_calc(that){

		var psf_calc_sso = $('select[name="psf_calc_sso"]').val();
		var psf_manual_emp = $('#psf_manual_emp').val();
		var psf_manual_comp = $('#psf_manual_comp').val();

		//psf_calculate_emp
		var psf_income_emp = $('#psf_income_emp').text();

		var psf_rate_psf_emp = $('#psf_rate_psf_emp').text();
		var rate_psf_emp = psf_rate_psf_emp.replace('%','');
		var getvaluepsfEmp = rate_psf_emp / 100;

		var psf_calc_emp = 0;
		if(psf_calc_sso == 1){
			if(getvaluepsfEmp > 0){
				psf_calc_emp = parseFloat(psf_income_emp) + parseFloat(getvaluepsfEmp);
			}else{
				psf_calc_emp = $('#psf_amt_thb_emp').text();
			}
		}

		var psf_calc_emp_twodig = parseFloat(psf_calc_emp).toFixed(2);

		$('#modalPSF #psf_calculate_emp').text(psf_calc_emp_twodig);

		
		var psf_psf_emp = psf_calc_emp;
		if(psf_manual_emp > 0){
			psf_psf_emp = parseFloat(psf_calc_emp) + parseFloat(psf_manual_emp);
		}

		var psf_psf_emp_twodig = parseFloat(psf_psf_emp).toFixed(2);
		$('#modalPSF #psf_psf_emp').text(psf_psf_emp_twodig);

		//psf_income_comp
		var psf_income_comp = $('#psf_income_comp').text();
		var psf_rate_psf_comp = $('#psf_rate_psf_comp').text();
		var rate_psf_comp = psf_rate_psf_comp.replace('%','');
		var getvaluepsfCom = rate_psf_comp / 100;

		var psf_calc_comp = 0;
		if(psf_calc_sso == 1){
			if(getvaluepsfCom > 0){
				psf_calc_comp = parseFloat(psf_income_comp) + parseFloat(getvaluepsfCom);
			}else{
				psf_calc_comp = $('#psf_amt_thb_comp').text();
			}
		}

		var psf_calc_comp_twodig = parseFloat(psf_calc_comp).toFixed(2);
		$('#modalPSF #psf_calculate_comp').text(psf_calc_comp_twodig);

		var psf_psf_comp = psf_calc_comp;
		if(psf_manual_comp > 0){
			psf_psf_comp = parseFloat(psf_calc_comp) + parseFloat(psf_manual_comp);
		}

		var psf_psf_comp_twodig = parseFloat(psf_psf_comp).toFixed(2);
		$('#modalPSF #psf_psf_comp').text(psf_psf_comp_twodig);

		if($("#modalPSF input[name='psfManual']").is(':checked')){
			manualpsfinput(true);
		}else{
			manualpsfinput(false);
		}

		//fetch pvf again
		modal_psf();

	}


	function modal_sso(){
		var empids = $('#Salarycalculator #empids').text();
		var mid = '<?=$_GET['mid']?>';
		if(empids !=''){
			var get_sso_pvf_full_year_thbss = get_sso_pvf_full_year_thb(empids);
			$.ajax({
				type: 'post',
				url: "ajax/get_payroll_data.php",
				data: {empid: empids,mid:mid},
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
						//console.log(data);

						var payroll_datas = data.payroll_data;
						var payroll_data_coulmn_prev = data.payroll_data_coulmn_prev;

						$('#modalSSO select[name="ss_calc_sso"] option').attr('selected',false);
						$('#modalSSO select[name="ss_paidby_sso"] option').attr('selected',false);


						$('#modalSSO #ssoEmpid').val(data[0].emp_id);
						$('#modalSSO #sso_empid').text(data[0].emp_id);
						$('#modalSSO #sso_empname').text(data[0].emp_name_en);

						$('#modalSSO select[name="ss_calc_sso"] option[value="'+data[0].calc_sso+'"]').attr('selected',true);
						$('#modalSSO select[name="ss_paidby_sso"] option[value="'+data[0].sso_by+'"]').attr('selected',true);

						$('#modalSSO #sso_total_sso_emp').text(number_format(data[0].total_sso));
						$('#modalSSO #sso_total_sso_comp').text(data[0].total_sso);

						$('#modalSSO #sso_manual_emp').val(data[0].sso_emp_manual);
						$('#modalSSO #sso_manual_comp').val(data[0].sso_comp_manual);

						//sso_calculate_sso_emp
						var ss_calc_sso = $('select[name="ss_calc_sso"]').val();
						
						var sso_rate_emp = $('#sso_rate_emp').text();
						var replace_percent = sso_rate_emp.replace('%','');

						var min_emp = $('#sso_min_emp').text();
						var max_emp = $('#sso_max_emp').text();

						var calculate_sso_emp = 0;
						if(ss_calc_sso == 1){
							var calcforemp = (data[0].total_sso * replace_percent) / 100;
							//calcforemp = (calcforemp > max_emp ? max_emp : calcforemp);
							//calcforemp = (calcforemp < min_emp ? min_emp : calcforemp);

							var calcforempv;
							if(calcforemp > max_emp){
								calcforempv = max_emp;
							}else if(calcforemp < min_emp){
								calcforempv = min_emp;
							}else{
								calcforempv = calcforemp;
							}

							calculate_sso_emp = calcforempv;
							calculate_sso_emp = parseFloat(calculate_sso_emp).toFixed(2);
							//alert(calculate_sso_emp);
						}

						
						$('#modalSSO #sso_calculate_sso_emp').text(calculate_sso_emp);

						var manual_emp = $('#sso_manual_emp').val();
						if(manual_emp > 0){
							var sso_emp_sso = parseFloat(calculate_sso_emp) + parseFloat(manual_emp);
						}else{
							var sso_emp_sso = calculate_sso_emp;
						}
						
						$('#modalSSO #sso_emp_sso').text(sso_emp_sso);

						var ss_paidby_sso = $('select[name="ss_paidby_sso"]').val();
						var sso_by_company = 0;	
						if(ss_paidby_sso == 1){
							sso_by_company = sso_emp_sso;
							sso_by_company = parseFloat(sso_by_company).toFixed(2);
						}
						
						$('#modalSSO #sso_sso_by_company').text(sso_by_company);

						//sso_calculate_sso_employer
						var sso_total_sso_comp = $('#sso_total_sso_comp').text();

						var sso_rate_comp = $('#sso_rate_comp').text();
						var replace_percent_comp = sso_rate_comp.replace('%','');

						var min_comp = $('#sso_min_comp').text();
						var max_comp = $('#sso_max_comp').text();

						var calculate_sso_comp = 0;
						if(ss_calc_sso == 1){
							var calcforcomp = (sso_total_sso_comp * replace_percent_comp) / 100;
							//calcforcomp = (calcforcomp > max_comp ? max_comp : calcforcomp);
							//calcforcomp = (calcforcomp < min_comp ? min_comp : calcforcomp);

							var calcforempc;
							if(calcforcomp > max_comp){
								calcforempc = max_comp;
							}else if(calcforcomp < min_comp){
								calcforempc = min_comp;
							}else{
								calcforempc = calcforcomp;
							}

							calculate_sso_comp = calcforempc;
							calculate_sso_comp = parseFloat(calculate_sso_comp).toFixed(2);
						}
						
						 
						$('#modalSSO #sso_calculate_sso_comp').text(calculate_sso_comp);

						var manual_comp = $('#sso_manual_comp').val(); 
						//alert(manual_comp);
						var sso_sso_employer = calculate_sso_comp;
						if(manual_comp > 0){
							sso_sso_employer = parseFloat(calculate_sso_comp) + parseFloat(manual_comp);
						}
						//alert(sso_sso_employer);
						$('#sso_sso_employerss').text(sso_sso_employer);

						//**************** SSO ****************//
						var pperiods = <?=json_encode($pperiods)?>;
						var short_months = <?=json_encode($short_months)?>;
						var num_months = <?=json_encode($num_months)?>;
						var curryear = <?=substr($_SESSION['rego']['cur_year'], -2)?>;
						var ssoEmpRates = data['ssoEmpRates'];
						var tbl = '';
						var total_sso = 0.00;
						var total_sso_employer = 0.00;
						var total_ssobycompany = 0.00;
						var k=0;

						$.each(ssoEmpRates, function(k1,v){
							k++;
							var sso_thb=0.00;
							var sso_employer=0.00;
							var ssobycompany=0.00;
							
							/*if(get_sso_pvf_full_year_thbss[k] == '[object Object]'){ 
								if(get_sso_pvf_full_year_thbss[k]['sso_employee'] > 0){
									sso_thb = get_sso_pvf_full_year_thbss[k]['sso_employee'];
								}
							}else{*/
								sso_thbs = (data[0].total_sso * v['rate']);

								if(sso_thbs > v['max']){ sso_thbs = v['max'];}
								else if(sso_thbs < v['min']){ sso_thbs = v['min'];}
							/*}*/

							//console.log(short_months);
							var monthss = short_months[k];
							var monthssLower = monthss.toLowerCase();
							
							if(ss_calc_sso == 1 && k >= data[0].month){

								//sso_thb = sso_thbs;
								//sso_employer = sso_thbs;
								sso_thb = payroll_datas[57][monthssLower];
								sso_employer = payroll_datas['ssoemployer'][monthssLower];
								//alert(ssothb);
							}else if(ss_calc_sso == 1 && k < data[0].month){

								//sso_thb = sso_thbs;
								//sso_employer = sso_thbs;
								sso_thb = payroll_datas[57][monthssLower];
								sso_employer = payroll_datas['ssoemployer'][monthssLower];
								//alert(ssothb);
							}

							if(ss_paidby_sso == 1 && k >= data[0].month){
								ssobycompany = sso_thb;
								//ssobycompany = payroll_datas[28][monthssLower];
							}else if(ss_paidby_sso == 1 && k < data[0].month){
								//ssobycompany = sso_thb;
								//ssobycompany = payroll_datas[28][monthssLower];
								ssobycompany = payroll_data_coulmn_prev[k][28][monthssLower];
							}

							sso_thb = parseFloat(sso_thb).toFixed(2);
							sso_employer = parseFloat(sso_employer).toFixed(2);
							ssobycompany = parseFloat(ssobycompany).toFixed(2);

							total_sso = parseFloat(total_sso) + parseFloat(sso_thb);
							total_sso_employer = parseFloat(total_sso_employer) + parseFloat(sso_employer);
							total_ssobycompany = parseFloat(total_ssobycompany) + parseFloat(ssobycompany);

							tbl += '<tr>';
							tbl += '<th class="tac">'+short_months[k]+'-'+curryear+'</th>';
							tbl += '<td class="tar" style="padding:0px;"><input type="text" id="erate_'+k+'" name="erate['+k+']" class="float72 text-right" value="'+v['rate']+'" style="background: #eeffee;" readonly></td>';

							tbl += '<td class="tar" style="padding:0px;"><input type="text" id="emin_'+k+'" name="emin['+k+']" class="float72 text-right" value="'+v['min']+'" style="background: #eeffee;" readonly></td>';

							tbl += '<td class="tar" style="padding:0px;"><input type="text" id="emax_'+k+'" name="emax['+k+']" class="float72 text-right" value="'+v['max']+'" style="background: #eeffee;" readonly></td>';

							tbl += '<td class="tar" style="padding:0px;"><input type="text" id="crate_'+k+'" name="crate['+k+']" class="float72 text-right" value="'+v['crate']+'" style="background: #eeffee;" readonly></td>';

							tbl += '<td class="tar" style="padding:0px;"><input type="text" id="cmin_'+k+'" name="cmin['+k+']" class="float72 text-right" value="'+v['cmin']+'" style="background: #eeffee;" readonly></td>';

							tbl += '<td class="tar" style="padding:0px;"><input type="text" id="cmax_'+k+'" name="cmax['+k+']" class="float72 text-right" value="'+v['cmax']+'" style="background: #eeffee;" readonly></td>';

							tbl += '<td class="tar" style="padding:0px;"><input type="text" id="ssothb_'+k+'" name="ssothb['+k+']" class="float72 text-right" value="'+sso_thb+'" style="background: #eeffee;" readonly></td>';

							tbl += '<td class="tar" style="padding:0px;"><input type="text" id="ssoemployr_'+k+'" name="ssoemployr['+k+']" class="float72 text-right" value="'+sso_employer+'" style="background: #eeffee;" readonly></td>';

							tbl += '<td class="tar" style="padding:0px;"><input type="text" id="ssobycompany_'+k+'" name="ssobycompany['+k+']" class="float72 text-right" value="'+ssobycompany+'" style="background: #eeffee;" readonly></td>';
							tbl += '</tr>';

						});
						/*$.each(pperiods, function(k,v){

							var sso_thb=0.00;
							var ssobycompany=0.00;
							
							if(get_sso_pvf_full_year_thbss[k] == '[object Object]'){ 
								if(get_sso_pvf_full_year_thbss[k]['sso_employee'] > 0){
									sso_thb = get_sso_pvf_full_year_thbss[k]['sso_employee'];
								}
							}else{
								sso_thb = (data[0].total_sso * v['sso_eRate']);

								if(sso_thb > v['sso_eMax']){ sso_thb = v['sso_eMax'];}
								else if(sso_thb < v['sso_eMin']){ sso_thb = v['sso_eMin'];}
							}

							if(data[0].sso_by == 1){
								ssobycompany = sso_thb;
							}

							sso_thb = parseFloat(sso_thb).toFixed(2);
							ssobycompany = parseFloat(ssobycompany).toFixed(2);

							total_sso = parseFloat(total_sso) + parseFloat(sso_thb);
							total_ssobycompany = parseFloat(total_ssobycompany) + parseFloat(ssobycompany);

							tbl += '<tr>';
							tbl += '<th class="tac">'+short_months[k]+'-'+curryear+'</th>';
							tbl += '<td class="tar" style="padding:0px;"><input type="text" id="erate_'+k+'" name="erate['+k+']" class="float72 text-right" value="'+v['sso_eRate']+'" style="background: #eeffee;" readonly></td>';

							tbl += '<td class="tar" style="padding:0px;"><input type="text" id="emin_'+k+'" name="emin['+k+']" class="float72 text-right" value="'+v['sso_eMin']+'" style="background: #eeffee;" readonly></td>';

							tbl += '<td class="tar" style="padding:0px;"><input type="text" id="emax_'+k+'" name="emax['+k+']" class="float72 text-right" value="'+v['sso_eMax']+'" style="background: #eeffee;" readonly></td>';

							tbl += '<td class="tar" style="padding:0px;"><input type="text" id="ssothb_'+k+'" name="ssothb['+k+']" class="float72 text-right" value="'+sso_thb+'" style="background: #eeffee;" readonly></td>';

							tbl += '<td class="tar" style="padding:0px;"><input type="text" id="ssoemployr_'+k+'" name="ssoemployr['+k+']" class="float72 text-right" value="'+sso_thb+'" style="background: #eeffee;" readonly></td>';

							tbl += '<td class="tar" style="padding:0px;"><input type="text" id="ssobycompany_'+k+'" name="ssobycompany['+k+']" class="float72 text-right" value="'+ssobycompany+'" style="background: #eeffee;" readonly></td>';
							tbl += '</tr>';

						});*/

						total_sso = parseFloat(total_sso).toFixed(2);
						total_sso_employer = parseFloat(total_sso_employer).toFixed(2);
						total_ssobycompany = parseFloat(total_ssobycompany).toFixed(2);

						tbl += '<tr>';
						tbl += '<th class="tac">Total</th>';
						tbl += '<td></td>';
						tbl += '<td></td>';
						tbl += '<td></td>';
						tbl += '<td></td>';
						tbl += '<td></td>';
						tbl += '<td></td>';
						tbl += '<td class="tar font-weight-bold">'+number_format(total_sso)+'</td>';
						tbl += '<td class="tar font-weight-bold">'+number_format(total_sso_employer)+'</td>';
						tbl += '<td class="tar font-weight-bold">'+number_format(total_ssobycompany)+'</td>';
						tbl += '</tr>';

						$('#append_full_table tr').remove();
						$('#append_full_table').append(tbl);
						
						$('#modalSSO').modal('show');
					}
				}
			})

		}else{
			$("body").overhang({
				type: "error",
				message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: Error in employee id',
				duration: 3,
			})
		}
	}

	function manualssoinput(that){
		//alert(that);
		var currmnth = '<?=$_SESSION['rego']['cur_month']?>';
		var sss_paidby_sso = $('#modalSSO #sss_paidby_sso').val(); 
		var sss_calc_sso = $('#modalSSO #sss_calc_sso').val(); 
		//if($(that).is(':checked')){
		if(that){

			for(var i=currmnth; i<=12; i++){
				//$('#modalSSO #erate_'+i).attr('readonly',false).addClass('borderCls');
				//$('#modalSSO #emin_'+i).attr('readonly',false).addClass('borderCls');
				//$('#modalSSO #emax_'+i).attr('readonly',false).addClass('borderCls');
				$('#modalSSO #ssothb_'+i).attr('readonly',false).addClass('borderCls');
				$('#modalSSO #ssoemployr_'+i).attr('readonly',false).addClass('borderCls');
				if(sss_paidby_sso == 1){
					$('#modalSSO #ssobycompany_'+i).attr('readonly',false).addClass('borderCls');
				}else{
					$('#modalSSO #ssobycompany_'+i).attr('readonly',true).removeClass('borderCls');
				}
			}

		}else{

			for(var i=currmnth; i<=12; i++){
				$('#modalSSO #erate_'+i).attr('readonly',true).removeClass('borderCls');
				$('#modalSSO #emin_'+i).attr('readonly',true).removeClass('borderCls');
				$('#modalSSO #emax_'+i).attr('readonly',true).removeClass('borderCls');
				$('#modalSSO #ssothb_'+i).attr('readonly',true).removeClass('borderCls');
				$('#modalSSO #ssoemployr_'+i).attr('readonly',true).removeClass('borderCls');
				$('#modalSSO #ssobycompany_'+i).attr('readonly',true).removeClass('borderCls');
			}
		}
	}

	function manualpvfinput(that){
		var currmnth = '<?=$_SESSION['rego']['cur_month']?>';
		if(that){
			for(var i=currmnth; i<=12; i++){
				$('#modalPVF #pvfemp_'+i).attr('readonly',false).addClass('borderCls');
				$('#modalPVF #pvfcom_'+i).attr('readonly',false).addClass('borderCls');
			}
		}else{
			for(var i=currmnth; i<=12; i++){
				$('#modalPVF #pvfemp_'+i).attr('readonly',true).removeClass('borderCls');
				$('#modalPVF #pvfcom_'+i).attr('readonly',true).removeClass('borderCls');
			}
		}
	}

	function manualpsfinput(that){
		var currmnth = '<?=$_SESSION['rego']['cur_month']?>';
		if(that){
			for(var i=currmnth; i<=12; i++){
				$('#modalPSF #psfemp_'+i).attr('readonly',false).addClass('borderCls');
				$('#modalPSF #psfcom_'+i).attr('readonly',false).addClass('borderCls');
			}
		}else{
			for(var i=currmnth; i<=12; i++){
				$('#modalPSF #psfemp_'+i).attr('readonly',true).removeClass('borderCls');
				$('#modalPSF #psfcom_'+i).attr('readonly',true).removeClass('borderCls');
			}
		}
	}

	function SSO_calc(that){

		var ss_calc_ssos = $('#sss_calc_sso').val();
		var ss_paidby_ssos = $('#sss_paidby_sso').val();
		var sso_manual_emp = $('#sso_manual_emp').val();
		var sso_manual_comp = $('#sso_manual_comp').val();

		/*alert(ss_calc_sso);
		alert(ss_paidby_sso);
		alert(sso_manual_emp);
		alert(sso_manual_comp);*/

		//sso_calculate_sso_emp
		var ss_calc_sso = ss_calc_ssos;

		var sso_rate_emp = $('#sso_rate_emp').text();
		var replace_percent = sso_rate_emp.replace('%','');

		var min_emp = $('#sso_min_emp').text();
		var max_emp = $('#sso_max_emp').text();

		var sso_total_sso_emp = $('#sso_total_sso_emp').text();

		var calculate_sso_emp = 0;
		if(ss_calc_sso == 1){
			var calcforemp = (sso_total_sso_emp * replace_percent) / 100;
			//calcforemp = (calcforemp > max_emp ? max_emp : calcforemp);
			//calcforemp = (calcforemp < min_emp ? min_emp : calcforemp);

			var calcforempv;
			if(calcforemp > max_emp){
				calcforempv = max_emp;
			}else if(calcforemp < min_emp){
				calcforempv = min_emp;
			}else{
				calcforempv = calcforemp;
			}

			calculate_sso_emp = calcforempv;
			calculate_sso_emp = parseFloat(calculate_sso_emp).toFixed(2);
		}

		
		$('#modalSSO #sso_calculate_sso_emp').text(calculate_sso_emp);

		var manual_emp = sso_manual_emp;
		if(manual_emp > 0){
			var sso_emp_sso = parseFloat(calculate_sso_emp) + parseFloat(manual_emp);
		}else{
			var sso_emp_sso = calculate_sso_emp;
			sso_emp_sso = parseFloat(sso_emp_sso).toFixed(2);
		}
		
		
		$('#modalSSO #sso_emp_sso').text(sso_emp_sso);

		var ss_paidby_sso = ss_paidby_ssos;
		var sso_by_company = 0;	

		if(ss_paidby_sso == 1){
			sso_by_company = sso_emp_sso;
			sso_by_company = parseFloat(sso_by_company).toFixed(2);
		}

		$('#modalSSO #sso_sso_by_company').text(sso_by_company);

		//sso_calculate_sso_employer
		var sso_total_sso_comp = $('#sso_total_sso_comp').text();

		var sso_rate_comp = $('#sso_rate_comp').text();
		var replace_percent_comp = sso_rate_comp.replace('%','');

		var min_comp = $('#sso_min_comp').text();
		var max_comp = $('#sso_max_comp').text();

		var calculate_sso_comp = 0;
		if(ss_calc_sso == 1){
			var calcforcomp = (sso_total_sso_comp * replace_percent_comp) / 100;
			//calcforcomp = (calcforcomp > max_comp ? max_comp : calcforcomp);
			//calcforcomp = (calcforcomp < min_comp ? min_comp : calcforcomp);

			var calcforempc;
			if(calcforcomp > max_comp){
				calcforempc = max_comp;
			}else if(calcforcomp < min_comp){
				calcforempc = min_comp;
			}else{
				calcforempc = calcforcomp;
			}

			calculate_sso_comp = parseFloat(calcforempc);
		}
		$('#modalSSO #sso_calculate_sso_comp').text(calculate_sso_comp);

		var manual_comp = sso_manual_comp; 
		//alert(manual_comp);
		var sso_sso_employer = calculate_sso_comp;
		if(manual_comp > 0){
			sso_sso_employer = parseFloat(calculate_sso_comp) + parseFloat(manual_comp);
		}
		//alert(sso_sso_employer);
		$('#sso_sso_employerss').text(sso_sso_employer);

		if($("#modalSSO input[name='ssoManual']").is(':checked')){
			manualssoinput(true);
		}else{
			manualssoinput(false);
		}

		//fetch sso again
		modal_sso();
		
	}
	
	$(document).ready(function(){

		//=========== Two table scroll using one scroll bar =======//

		/*var oldRst2 = 0;
		$('table#linkedcolumnsSC').on('scroll', function () {
		  l2 = $('table#linkedcolumnsSC');
		  var lst2 = l2.scrollLeft();
		  var rst2 = $(this).scrollLeft();

		  l2.scrollLeft(lst2+(rst2-oldRst2));
		  
		  oldRst2 = rst2;
		});

		var oldRst13 = 0;
		$('div#Bothtable').on('scroll', function () {
		  l13 = $('div#Bothtable');
		  var lst13 = l13.scrollLeft();
		  var rst13 = $(this).scrollLeft();
		  
		  l13.scrollLeft(lst13+(rst13-oldRst13));
		  
		  oldRst13 = rst13;
		});        

		var oldRst14 = 0;
		$('div#hidediv2 table#scrolltable').on('scroll', function () {

		  l14 = $('div#Bothtable');
		  var lst14 = l14.scrollLeft();
		  var rst14 = $(this).scrollLeft();
		  l14.scrollLeft(lst14+(rst14-oldRst14));
		  
		  oldRst14 = rst14;
		}); */

		// var oldRst15 = 0;
		// $('div#hidediv2 table#scrolltable').on('scroll', function () {

		//   l15 = $('table#linkedcolumnsSCD');
		//   var lst15 = l15.scrollLeft();
		//   var rst15 = $(this).scrollLeft();
		//   l15.scrollLeft(lst15+(rst15-oldRst15));
		  
		//   oldRst15 = rst15;
		// });

		//=========== Two table scroll using one scroll bar =======//

		

		

		//============== Save SSO DATA =============//

		function calculate_payroll_again(empid){
			var mid = '<?=$_GET['mid']?>';
			 $.ajax({
				type: 'POST',
				url: "ajax/calculate_payroll.php",
				data: {empid: empid,mid:mid},
				success: function(result){

					if(result == 'success'){
						
						$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Payroll calculated successfuly']?>',
							duration: 3,
							callback: function(v){
								//window.location.reload();
							}
						})

					}else{

						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: '+ result,
							duration: 3,
							callback: function(v){
								window.location.reload();
							}
						})
					}
				}
			})
		}

		$('#SaveSSOdata').click(function(){
			var empids = $('#sso_empid').text();
			/*var mid = '<?=$_GET['mid']?>';
			var currmnth = '<?=$_SESSION['rego']['cur_month']?>';*/

			var frm = $('form#ssoAlldata');
			var data = frm.serialize();

			if(empids !=''){

				/*var sss_calc_sso = $('#sss_calc_sso').val();
				var sss_paidby_sso = $('#sss_paidby_sso').val();

				//var sso_calculate_sso_emp = $('#sso_calculate_sso_emp').text();
				//var sso_manual_emp = $('#sso_manual_emp').val();
				var sso_emp_sso = $('#ssothb_'+currmnth).val();
				var sso_sso_by_company = $('#ssobycompany_'+currmnth).val();


				//var sso_calculate_sso_comp = $('#sso_calculate_sso_comp').text();
				//var sso_manual_comp = $('#sso_manual_comp').val();
				var sso_sso_employerss = $('#ssoemployr_'+currmnth).val();*/

				$.ajax({
					type: 'post',
					url: "tabs/ajax/save_sso_data.php",
					//data: {empids: empids, mid:mid, sss_calc_sso: sss_calc_sso, sss_paidby_sso: sss_paidby_sso, sso_emp_sso:sso_emp_sso, sso_sso_by_company: sso_sso_by_company, sso_sso_employerss: sso_sso_employerss},
					data: data,
					success: function(result){

						if(result == 'success'){
							calculate_payroll_again(empids);							
						}else{

							$("body").overhang({
								type: "error",
								message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: '+ result,
								duration: 3,
								callback: function(v){
									window.location.reload();
								}
							})
						}
					}
				})
			}
		});


		//============== Save PVF DATA =============//
		$('#SavePVFdata').click(function(){
			var empids = $('#pvf_empid').text();

			var frm = $('form#formpvfdata');
			var data = frm.serialize();

			if(empids !=''){

				/*var pvfss_calc_pvf = $('#pvfss_calc_pvf').val();
				var pvf_calculate_emp = $('#pvf_calculate_emp').text();
				var pvf_manual_emp = $('#pvf_manual_emp').val();
				var pvf_pvfemp_emp = $('#pvf_pvfemp_emp').text();

				var pvf_calculate_comp = $('#pvf_calculate_comp').text();
				var pvf_manual_comp = $('#pvf_manual_comp').val();
				var pvf_pvfcom_comp = $('#pvf_pvfcom_comp').text();*/

				$.ajax({
					type: 'post',
					url: "tabs/ajax/save_pvf_data.php",
					//data: {empids: empids, pvfss_calc_pvf: pvfss_calc_pvf, pvf_calculate_emp: pvf_calculate_emp, pvf_manual_emp: pvf_manual_emp, pvf_pvfemp_emp: pvf_pvfemp_emp, pvf_calculate_comp: pvf_calculate_comp, pvf_manual_comp: pvf_manual_comp, pvf_pvfcom_comp: pvf_pvfcom_comp},
					data: data,
					success: function(result){

						if(result == 'success'){
							calculate_payroll_again(empids);							
						}else{

							$("body").overhang({
								type: "error",
								message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: '+ result,
								duration: 3,
								callback: function(v){
									window.location.reload();
								}
							})
						}
					}
				})
			}
		});

		

		//============== Save PSF DATA =============//
		$('#SavePSFdata').click(function(){
			var empids = $('#psf_empid').text();

			var frm = $('form#formpsfdata');
			var data = frm.serialize();

			if(empids !=''){

				/*var psfss_calc_sso = $('#psfss_calc_sso').val();
				var psf_calculate_emp = $('#psf_calculate_emp').text();
				var psf_manual_emp = $('#psf_manual_emp').val();
				var psf_psf_emp = $('#psf_psf_emp').text();

				var psf_calculate_comp = $('#psf_calculate_comp').text();
				var psf_manual_comp = $('#psf_manual_comp').val();
				var psf_psf_comp = $('#psf_psf_comp').text();*/

				$.ajax({
					type: 'post',
					url: "tabs/ajax/save_psf_data.php",
					//data: {empids: empids, psfss_calc_sso: psfss_calc_sso, psf_calculate_emp: psf_calculate_emp, psf_manual_emp: psf_manual_emp, psf_psf_emp: psf_psf_emp, psf_calculate_comp: psf_calculate_comp, psf_manual_comp: psf_manual_comp, psf_psf_comp: psf_psf_comp},
					data: data,
					success: function(result){

						if(result == 'success'){
							calculate_payroll_again(empids);							
						}else{

							$("body").overhang({
								type: "error",
								message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: '+ result,
								duration: 3,
								callback: function(v){
									window.location.reload();
								}
							})
						}
					}
				})
			}
		});


		//============== Save TAX DATA =============//
		$('#SaveTAXdata').click(function(){
			var empids = $('#Salarycalculator #empids').text(); 
			//alert(empids);
			
			if(empids !=''){

				var tx_calc_method = $('#tx_calc_method').val();

				$.ajax({
					type: 'post',
					url: "tabs/ajax/save_tax_data.php",
					data: {empids: empids, tx_calc_method: tx_calc_method},
					success: function(result){

						if(result == 'success'){
							calculate_payroll_again(empids);							
						}else{

							$("body").overhang({
								type: "error",
								message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: '+ result,
								duration: 3,
								callback: function(v){
									window.location.reload();
								}
							})
						}
					}
				})
			}
		});

		
		//============== Save Tax Deduction DATA =============//
		$('#SaveTDdata').click(function(){
			var empids = $('#td_empid').text();
			var mid = '<?=$_GET['mid']?>';
			if(empids !=''){

				var subtotal_std = $('#subtotal_std').text();
				var td_manual_std = $('#td_manual_std').val();
				var td_std_deduct = $('#td_std_deduct').text();

				var subtotal_pcare = $('#subtotal_pcare').text();
				var td_manual_pcare = $('#td_manual_pcare').val();
				var td_pcare_deduct = $('#td_pcare_deduct').text();

				var td_subtotal_sso = $('#td_subtotal_sso').text();
				var td_manual_ssod = $('#td_manual_ssod').val();
				var td_sso_deduct = $('#td_sso_deduct').text();

				var td_subtotal_pvf = $('#td_subtotal_pvf').text();
				var td_manual_pvfd = $('#td_manual_pvfd').val();
				var td_pvf_deduct = $('#td_pvf_deduct').text();
				var yearly_tax_deductions = $('#td_total_tax_deduct').text();
				var total_yearly_tax_deductions = yearly_tax_deductions.replace(",", "");

				$.ajax({
					type: 'post',
					url: "tabs/ajax/save_tax_deduction_data.php",
					data: {empids: empids, mid:mid, subtotal_std: subtotal_std, td_manual_std: td_manual_std, td_std_deduct: td_std_deduct, subtotal_pcare: subtotal_pcare, td_manual_pcare: td_manual_pcare, td_pcare_deduct: td_pcare_deduct, td_subtotal_sso: td_subtotal_sso, td_manual_ssod: td_manual_ssod, td_sso_deduct: td_sso_deduct, td_subtotal_pvf: td_subtotal_pvf, td_manual_pvfd: td_manual_pvfd, td_pvf_deduct: td_pvf_deduct,total_yearly_tax_deductions:total_yearly_tax_deductions},
					success: function(result){

						if(result == 'success'){
							calculate_payroll_again(empids);							
						}else{

							$("body").overhang({
								type: "error",
								message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: '+ result,
								duration: 3,
								callback: function(v){
									window.location.reload();
								}
							})
						}
					}
				})
			}
		});


		$('#getlinkeddata tbody td').click(function(){

			$('#getlinkeddata tbody td').removeClass('borderCls');
			$('#linkedcolumnsSC tbody td').removeClass('borderCls');
			$('#linkedcolumnsSCD tbody td').removeClass('borderCls');

			if(this.id !=''){

				$('#getlinkeddata tbody td#'+this.id).addClass('borderCls');

				if(this.id == 'ded_curr_calc' || this.id == 'ded_curr_mnth'){
					$('#linkedcolumnsSCD tbody td.currMnths.ded_abs').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.currMnths.ded_fix').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.currMnths.ded_var').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.currMnths.ded_oth').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.currMnths.ded_leg').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.currMnths.ded_pay').addClass('borderCls');
				}
				if(this.id == 'pnd_curr_calc' || this.id == 'pnd_curr_mnth'){
					$('#linkedcolumnsSC tbody td.currMnths.pnd1').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.currMnths.pnd1').addClass('borderCls');
				}
				if(this.id == 'sso_curr_calc' || this.id == 'sso_curr_mnth'){
					$('#linkedcolumnsSC tbody td.currMnths.sso').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.currMnths.sso').addClass('borderCls');
				}
				if(this.id == 'pvf_curr_calc' || this.id == 'pvf_curr_mnth'){
					$('#linkedcolumnsSC tbody td.currMnths.pvf').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.currMnths.pvf').addClass('borderCls');
				}
				if(this.id == 'psf_curr_calc' || this.id == 'psf_curr_mnth'){
					$('#linkedcolumnsSC tbody td.currMnths.psf').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.currMnths.psf').addClass('borderCls');
				}
				if(this.id == 'fixpro_curr_calc' || this.id == 'fixpro_curr_mnth'){
					$('#linkedcolumnsSC tbody td.currMnths.fixpro').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.currMnths.fixpro').addClass('borderCls');
				}
				if(this.id == 'fix_curr_calc' || this.id == 'fix_curr_mnth'){
					$('#linkedcolumnsSC tbody td.currMnths.fix').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.currMnths.fix').addClass('borderCls');
				}
				if(this.id == 'var_curr_calc' || this.id == 'var_curr_mnth'){
					$('#linkedcolumnsSC tbody td.currMnths.var').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.currMnths.var').addClass('borderCls');
				}
				if(this.id == 'nontax_curr_calc' || this.id == 'nontax_curr_mnth'){
					$('#linkedcolumnsSC tbody td.currMnths.nontax').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.currMnths.nontax').addClass('borderCls');
				}
				if(this.id == 'totalffv_curr_calc' || this.id == 'totalffv_curr_mnth'){
					$('#linkedcolumnsSC tbody td.currMnths.fixpro').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.currMnths.fix').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.currMnths.var').addClass('borderCls');

					$('#linkedcolumnsSCD tbody td.currMnths.fixpro').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.currMnths.fix').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.currMnths.var').addClass('borderCls');
				}

				if(this.id == 'ear_curr_calc' || this.id == 'ear_curr_mnth'){
					$('#linkedcolumnsSC tbody td.currMnths.inc_sal').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.currMnths.inc_fix').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.currMnths.inc_ot').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.currMnths.inc_var').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.currMnths.inc_oth').addClass('borderCls');
				}

				if(this.id == 'sso_emp_curr_calc' || this.id == 'sso_emp_curr_mnth'){ 
					$('#linkedcolumnsSCD tbody td.currMnths.ssocurr').addClass('borderCls');
				}

				if(this.id == 'tax_emp_curr_calc' || this.id == 'tax_emp_curr_mnth'){ 
					$('#linkedcolumnsSCD tbody td.currMnths.exTax').addClass('borderCls');
				}

				if(this.id == 'taxbycom_curr_calc' || this.id == 'taxbycom_curr_mnth'){ 
					$('#linkedcolumnsSC tbody td.currMnths.taxbycom').addClass('borderCls');
				}

				if(this.id == 'ssobycom_curr_calc' || this.id == 'ssobycom_curr_mnth'){ 
					$('#linkedcolumnsSC tbody td.currMnths.ssobycom').addClass('borderCls');
				}


				//========= prev month highlight ==========//
				if(this.id == 'ded_prev_mnth'){
					$('#linkedcolumnsSCD tbody td.prevMnth.ded_abs').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.ded_fix').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.ded_var').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.ded_oth').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.ded_leg').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.ded_pay').addClass('borderCls');
				}
				if(this.id == 'pnd_prev_mnth'){
					$('#linkedcolumnsSC tbody td.prevMnth.pnd1').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.pnd1').addClass('borderCls');
				}
				if(this.id == 'sso_prev_mnth'){
					$('#linkedcolumnsSC tbody td.prevMnth.sso').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.sso').addClass('borderCls');
				}
				if(this.id == 'pvf_prev_mnth'){
					$('#linkedcolumnsSC tbody td.prevMnth.pvf').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.pvf').addClass('borderCls');
				}
				if(this.id == 'psf_prev_mnth'){
					$('#linkedcolumnsSC tbody td.prevMnth.psf').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.psf').addClass('borderCls');
				}
				if(this.id == 'fixpro_prev_mnth'){
					$('#linkedcolumnsSC tbody td.prevMnth.fixpro').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.fixpro').addClass('borderCls');
				}
				if(this.id == 'fix_prev_mnth'){
					$('#linkedcolumnsSC tbody td.prevMnth.fix').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.fix').addClass('borderCls');
				}
				if(this.id == 'var_prev_mnth'){
					$('#linkedcolumnsSC tbody td.prevMnth.var').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.var').addClass('borderCls');
				}
				if(this.id == 'nontax_prev_mnth'){
					$('#linkedcolumnsSC tbody td.prevMnth.nontax').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.nontax').addClass('borderCls');
				}
				if(this.id == 'totalffv_prev_mnth'){
					$('#linkedcolumnsSC tbody td.prevMnth.fixpro').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.prevMnth.fix').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.prevMnth.var').addClass('borderCls');

					$('#linkedcolumnsSCD tbody td.prevMnth.fixpro').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.fix').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.var').addClass('borderCls');
				}

				if(this.id == 'ear_prev_mnth'){
					$('#linkedcolumnsSC tbody td.prevMnth.inc_sal').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.prevMnth.inc_fix').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.prevMnth.inc_ot').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.prevMnth.inc_var').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.prevMnth.inc_oth').addClass('borderCls');
				}

				//=============== Full year ================//
				if(this.id == 'ded_full_year'){
					$('#linkedcolumnsSCD tbody td.currMnths.ded_pay').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.currMnths.ded_abs').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.currMnths.ded_fix').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.currMnths.ded_var').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.currMnths.ded_oth').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.currMnths.ded_leg').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.currMnths.ded_pay').addClass('borderCls');

					$('#linkedcolumnsSCD tbody td.prevMnth.ded_pay').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.ded_abs').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.ded_fix').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.ded_var').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.ded_oth').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.ded_leg').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.ded_pay').addClass('borderCls');

					$('#linkedcolumnsSCD tbody td.upcommMnths.ded_pay').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.upcommMnths.ded_abs').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.upcommMnths.ded_fix').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.upcommMnths.ded_var').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.upcommMnths.ded_oth').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.upcommMnths.ded_leg').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.upcommMnths.ded_pay').addClass('borderCls');
				}

				if(this.id == 'ear_full_year'){
					$('#linkedcolumnsSC tbody td.currMnths.inc_sal').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.currMnths.inc_fix').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.currMnths.inc_ot').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.currMnths.inc_var').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.currMnths.inc_oth').addClass('borderCls');

					$('#linkedcolumnsSC tbody td.prevMnth.inc_sal').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.prevMnth.inc_fix').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.prevMnth.inc_ot').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.prevMnth.inc_var').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.prevMnth.inc_oth').addClass('borderCls');

					$('#linkedcolumnsSC tbody td.upcommMnths.inc_sal').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.upcommMnths.inc_fix').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.upcommMnths.inc_ot').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.upcommMnths.inc_var').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.upcommMnths.inc_oth').addClass('borderCls');
				}

				if(this.id == 'pnd_full_year'){
					$('#linkedcolumnsSC tbody td.currMnths.pnd1').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.prevMnth.pnd1').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.upcommMnths.pnd1').addClass('borderCls');

					$('#linkedcolumnsSCD tbody td.currMnths.pnd1').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.pnd1').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.upcommMnths.pnd1').addClass('borderCls');
				}

				if(this.id == 'sso_full_year'){
					$('#linkedcolumnsSC tbody td.currMnths.sso').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.prevMnth.sso').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.upcommMnths.sso').addClass('borderCls');

					$('#linkedcolumnsSCD tbody td.currMnths.sso').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.sso').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.upcommMnths.sso').addClass('borderCls');
				}

				if(this.id == 'pvf_full_year'){
					$('#linkedcolumnsSC tbody td.currMnths.pvf').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.prevMnth.pvf').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.upcommMnths.pvf').addClass('borderCls');

					$('#linkedcolumnsSCD tbody td.currMnths.pvf').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.pvf').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.upcommMnths.pvf').addClass('borderCls');
				}

				if(this.id == 'psf_full_year'){
					$('#linkedcolumnsSC tbody td.currMnths.psf').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.prevMnth.psf').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.upcommMnths.psf').addClass('borderCls');

					$('#linkedcolumnsSCD tbody td.currMnths.psf').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.psf').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.upcommMnths.psf').addClass('borderCls');
				}


				if(this.id == 'fixpro_full_year'){
					$('#linkedcolumnsSC tbody td.currMnths.fixpro').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.prevMnth.fixpro').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.upcommMnths.fixpro').addClass('borderCls');

					$('#linkedcolumnsSCD tbody td.currMnths.fixpro').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.fixpro').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.upcommMnths.fixpro').addClass('borderCls');
				}

				if(this.id == 'fix_full_year'){
					$('#linkedcolumnsSC tbody td.currMnths.fix').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.prevMnth.fix').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.upcommMnths.fix').addClass('borderCls');

					$('#linkedcolumnsSCD tbody td.currMnths.fix').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.fix').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.upcommMnths.fix').addClass('borderCls');
				}

				if(this.id == 'var_full_year'){
					$('#linkedcolumnsSC tbody td.currMnths.var').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.prevMnth.var').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.upcommMnths.var').addClass('borderCls');

					$('#linkedcolumnsSCD tbody td.currMnths.var').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.var').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.upcommMnths.var').addClass('borderCls');
				}

				if(this.id == 'totalffv_full_year'){

					$('#linkedcolumnsSC tbody td.currMnths.fixpro').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.prevMnth.fixpro').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.upcommMnths.fixpro').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.currMnths.fix').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.prevMnth.fix').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.upcommMnths.fix').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.currMnths.var').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.prevMnth.var').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.upcommMnths.var').addClass('borderCls');

					$('#linkedcolumnsSCD tbody td.currMnths.fixpro').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.fixpro').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.upcommMnths.fixpro').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.currMnths.fix').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.fix').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.upcommMnths.fix').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.currMnths.var').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.var').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.upcommMnths.var').addClass('borderCls');
				}

				if(this.id == 'nontax_full_year'){
					$('#linkedcolumnsSC tbody td.currMnths.nontax').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.prevMnth.nontax').addClass('borderCls');
					$('#linkedcolumnsSC tbody td.upcommMnths.nontax').addClass('borderCls');

					$('#linkedcolumnsSCD tbody td.currMnths.nontax').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.nontax').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.upcommMnths.nontax').addClass('borderCls');
				}

				if(this.id == 'sso_emp_full_year'){ 
					$('#linkedcolumnsSCD tbody td.currMnths.ssocurr').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.ssocurr').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.upcommMnths.ssocurr').addClass('borderCls');
				}

				if(this.id == 'tax_emp_full_year'){ 
					$('#linkedcolumnsSCD tbody td.currMnths.exTax').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.prevMnth.exTax').addClass('borderCls');
					$('#linkedcolumnsSCD tbody td.upcommMnths.exTax').addClass('borderCls');
				}


				//========== Check total both side ===========//
				var lhs = $(this).text();
				var lhss = lhs.replace("-", "");
				var lhsss = lhss.replace(",", "");
				//setTimeout(function() { checkTotalsBothSideSC(lhs) }, 1000);
				checkTotalsBothSideSC(lhsss);
				
			}

		});

		function checkTotalsBothSideSC(lhs){

			var currTot = 0.00;
			var currTotD = 0.00;
			$('#linkedcolumnsSC tbody td.borderCls').each(function(){
				var currVal = $(this).text();
				var str2 = currVal.replace(",", "");
				currTot += parseFloat(str2);
			})

			$('#linkedcolumnsSCD tbody td.borderCls').each(function(){
				var currValD = $(this).text(); 
				var str21 = currValD.replace(",", ""); 
				currTotD += parseFloat(str21);
			})

			//alert(lhs);
			// alert(currTotD);
			var rhs = parseFloat(currTot) + parseFloat(currTotD);

			/*if(lhs != rhs){
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: Both side totals are not equal<br> LHS = '+lhs+'<br> RHS = '+rhs+'',
					duration: 1,
				})
			}*/
		}

		$('.closebtn').click(function(){
			
			setTimeout(function(){
				$('body').addClass('modal-open');
			}, 1000);
			
		});

		$('.Selallemp').click(function(){
			$('.empchkbox').prop('checked',false);
			$('.empchkbox').removeClass('selEmpChk');

			$('.empchkbox').prop('checked',true);
			$('.empchkbox').addClass('selEmpChk');

			$('.unSelallemp').css('display','block');
			$('.Selallemp').css('display','none');
		});

		$('.unSelallemp').click(function(){
			$('.empchkbox').prop('checked',false);
			$('.empchkbox').removeClass('selEmpChk');

			$('.unSelallemp').css('display','none');
			$('.Selallemp').css('display','block');

		});

		$('.empchkbox').click(function(){

			if(this.checked){
				$(this).attr('checked',true);
				$(this).addClass('selEmpChk');
			}else{
				$(this).attr('checked',false);
				$(this).removeClass('selEmpChk');
			}
		});


		
	})
</script>