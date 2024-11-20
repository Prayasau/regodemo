<?php
	
	if(!$_SESSION['rego']['employee_finance']['view']){ 
		echo '<div class="msg_nopermit">You have no access to this page</div>'; exit;
	}
	$delDoc = 'delColor';
	if($_SESSION['rego']['employee_finance']['del']){$delDoc = 'delDoc';}

	if(isset($_SESSION['rego']['empID'])){ // EDIT EMPLOYEE ////////////////////////////////////////////////
		$empID = $_SESSION['rego']['empID'];
		$res = $dbc->query("SELECT * FROM ".$cid."_employees WHERE emp_id = '".$empID."'");
		$data = $res->fetch_assoc();
		if(empty($data['image'])){$data['image'] = 'images/profile_image.jpg';}
		$update = 1;

		$emp_allow_dedct_amt = emp_allow_dedct_amt($empID);

		$ecdata = array();
		//$resec = $dbc->query("SELECT * FROM ".$cid."_employee_career WHERE emp_id = '".$empID."' AND month <= '".date('m')."' AND end_date = '' ORDER BY id DESC");
		$resec = $dbc->query("SELECT * FROM ".$cid."_employee_career WHERE emp_id = '".$empID."' ORDER BY id DESC");
		if($resec->num_rows > 0){
			while($ecdatas = $resec->fetch_assoc()){
				$ecdata[] = $ecdatas;
			}
		}
		
	}
	
	$entity_banks = getEntityBanks($data['entity']);
	$getNewFixAllowDeduct = getNewFixAllowDeduct();
	$getPayrollModels = getPayrollModels();
	//var_dump($entity_banks); exit;

	$fixalldedarr = array();
	foreach ($getNewFixAllowDeduct as $key => $value) {
		foreach ($value as $k => $v) {
			$fixalldedarr[$v['id']] = $v[$lang];
		}
	}

	$bank_codes = unserialize($rego_settings['bank_codes']);
	$fix_allow = getFixAllowances($sys_settings);
	$fix_deductions = unserialize($sys_settings['fix_deduct']);
	$fix_deduct = getUsedFixDeduct($lang);
	$tax_settings = unserialize($rego_settings['tax_settings']);
	//var_dump($tax_settings); exit;
	$tax_info = unserialize($rego_settings['tax_info_'.$lang]);
	//var_dump($tax_info);
	$tax_err = unserialize($rego_settings['tax_err_'.$lang]);

	$tax_calc_on = unserialize($rego_settings['tax_calc_on']);
	$tax_thb = unserialize($rego_settings['tax_thb']);
	$tax_unit = unserialize($rego_settings['tax_unit']);
	$tax_number = unserialize($rego_settings['tax_number']);
	$tax_description = unserialize($rego_settings['tax_description']);
	
	//var_dump($data); exit;
	
	if(empty($data['att_bankbook'])){$att_bankbook = '<i style="color:#ccc" class="fa fa-download fa-lg"></i></a>';}else{$att_bankbook = '<a download href="'.ROOT.$cid.'/employees/'.$data['att_bankbook'].'"><i class="fa fa-download fa-lg"></i></a>';}
	if(empty($data['att_contract'])){$att_contract = '<i style="color:#ccc" class="fa fa-download fa-lg"></i></a>';}else{$att_contract = '<a download href="'.ROOT.$cid.'/employees/'.$data['att_contract'].'"><i class="fa fa-download fa-lg"></i></a>';}
	if(empty($data['attach5'])){$attach5 = '<i style="color:#ccc" class="fa fa-download fa-lg"></i></a>';}else{$attach5 = '<a download href="'.ROOT.$cid.'/employees/'.$data['attach5'].'"><i class="fa fa-download fa-lg"></i></a>';}
	if(empty($data['attach6'])){$attach6 = '<i style="color:#ccc" class="fa fa-download fa-lg"></i></a>';}else{$attach6 = '<a download href="'.ROOT.$cid.'/employees/'.$data['attach6'].'"><i class="fa fa-download fa-lg"></i></a>';}
	if(empty($data['attach7'])){$attach7 = '<i style="color:#ccc" class="fa fa-download fa-lg"></i></a>';}else{$attach7 = '<a download href="'.ROOT.$cid.'/employees/'.$data['attach7'].'"><i class="fa fa-download fa-lg"></i></a>';}
	if(empty($data['attach8'])){$attach8 = '<i style="color:#ccc" class="fa fa-download fa-lg"></i></a>';}else{$attach8 = '<a download href="'.ROOT.$cid.'/employees/'.$data['attach8'].'"><i class="fa fa-download fa-lg"></i></a>';}

	$unitArr = array(1=>'Num',2=>'THB');

	//echo '<pre>';
	///print_r($tax_number);
	//print_r($getNewFixAllowDeduct);
	//print_r($getNewFixAllowDeduct['ded_fix']);
	//print_r($emp_allow_dedct_amt);
	//print_r($tax_err);
	//print_r($tax_settings);
	//print_r($ecdata);
	//echo '</pre>';
	//exit;

?>

	<style type="text/css">
		.tab {
		  display: none;
		}		
		.tab2 {
		  display: none;
		}

		#modalAddEmpcareer table.basicTable tbody td{
			padding: 0px !important;
		}		
		#modalAddEmpcareer2 table.basicTable tbody td{
			padding: 0px !important;
		}

		#tab_fin_tax table td.info{
			width: 150px;
		}
		#tab_fin_tax table td.info span{
			color: #8b8b8d;
		}

		#tab_fin_tax table td input, #tab_fin_tax table td select{
			background: #f9f9d1;
		}

		#tab_fin_tax table.basicTable.lefttbl tbody td{
			padding: 0px;
		}

		.removeDownArrow {
		    -webkit-appearance: none;
		    -moz-appearance: none;
		    text-indent: 0.01px;
		    text-overflow: '';
		}
	</style>
	<h2 style="position:relative">
		<span><i class="fa fa-users fa-mr"></i> <?=$lng['Financial info']?>&nbsp; <i class="fa fa-arrow-circle-right"></i> </span>
		<span><?=$data['emp_id']?> : <?=$data[$lang.'_name']?></span>
		<span style="display:none; font-style:italic; color:#b00; padding-left:30px" id="sAlert"><i class="fa fa-exclamation-triangle fa-mr"></i><?=$lng['Data is not updated to last changes made']?></span>
	</h2>
	
	<? include('employee_image_inc.php')?>
	
	<div class="pannel main_pannel employee-profile">
		<div style="padding:0 0 0 20px" id="dump"></div>
		
		<form id="financialForm" style="height:100%">
		<ul class="nav nav-tabs">
			<li class="nav-item"><a class="nav-link active" href="#tab_fin_financial" data-toggle="tab"><?=$lng['Financial']?></a></li>
			<li class="nav-item"><a class="nav-link" href="#tab_fin_benefits" data-toggle="tab"><?=$lng['Benefits']?></a></li>
			<li class="nav-item"><a class="nav-link" href="#tab_PSF_PVF" data-toggle="tab"><?=$lng['PSF']?> / <?=$lng['PVF']?></a></li>
			<li class="nav-item"><a class="nav-link" href="#tab_fin_tax" data-toggle="tab"><?=$lng['Tax']?></a></li>
			<li class="nav-item"><a class="nav-link" href="#tab_his_career" data-toggle="tab"><?=$lng['Career']?></a></li>
			<li class="nav-item"><a class="nav-link" href="#tab_fin_documents" data-toggle="tab"><?=$lng['Documents']?></a></li>
			<li class="nav-item"><a class="nav-link" href="#tab_fin_contract" data-toggle="tab"><?=$lng['End contract']?></a></li>

		</ul>
		
		<fieldset style="height:100%" <? if(!$_SESSION['rego']['employee_finance']['edit']){echo 'disabled';} ?>>
		<div class="tab-content" style="height:calc(100% - 30px)">

			<?if($_SESSION['rego']['empView'] == 'active'){ ?>
				<button id="submitBtn" class="btn btn-primary mr-4" type="submit"><i class="fa fa-save"></i>&nbsp;&nbsp;<?=$lng['Update']?></button>
				<button style="display: none;" id="editBtn" class="btn btn-primary mr-4" type="button"><i class="fa fa-edit"></i>&nbsp;&nbsp;<?=$lng['Edit']?></button>
				<input type="hidden" name="updateEmp" value="1">
			<? } ?>
			<input type="hidden" name="emp_id" value="<?=$data['emp_id']?>">
			
			<div class="tab-pane active" id="tab_fin_financial">
				<div class="tab-content-left">

					<table class="basicTable editTable" border="0">
						<thead>
							<tr style="line-height:100%">
								<th colspan="2"><?=strtoupper($lng['Contract'])?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th style="width:5%"><?=$lng['Contract type']?></th>
								<td>
									<select class="calcRate" name="contract_type" id="contract_type" onchange="SetUnitBaseval();">
										<option <? if($data['contract_type'] == 'month'){echo 'selected';}?> value="month"><?=$lng['Monthly wage']?></option>
										<option <? if($data['contract_type'] == 'day'){echo 'selected';}?> value="day"><?=$lng['Daily wage']?></option>
									</select>
								</td>
							</tr>
							<tr>
								<th style="width:5%"><?=$lng['Calculation base']?></th>
								<td>
									<select name="calc_base" id="calc_baseid" onchange="SetUnitBaseval();">
										<option <? if($data['calc_base'] == 'gross'){echo 'selected';}?> value="gross"><?=$lng['Gross amount']?></option>
										<option <? if($data['calc_base'] == 'net'){echo 'selected';}?> value="net"><?=$lng['Net amount']?></option>
									</select>
								</td>
							</tr>
							<tr>
								<th><?=$lng['Probation due date']?></th>
								<td><input type="text" readonly style="cursor:pointer" class="datepick" name="probation_date" id="probation_date" placeholder="..." value="<? if(!empty($data['probation_date'])){echo date('d-m-Y', strtotime($data['probation_date']));}?>"></td>
							</tr>
							<tr>
								<th><?=$lng['Employee type']?></th>
								<td>
									<select name="emp_type">
										<? foreach($emp_type as $k=>$v){ ?>
											<option <? if($data['emp_type'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v?></option>
										<? } ?>
									</select>
								</td>
							</tr> 
						</tbody>
					</table>

					<table class="basicTable editTable" border="0">
						<thead>
							<tr style="line-height:100%">
								<th colspan="2"><?=$lng['FINANCIAL DATA']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th><?=$lng['Bank code']?></th>
								<td><input readonly class="nofocus" type="text" name="bank_code" id="bank_code" placeholder="..." value="<?=$data['bank_code']?>"></td>
							</tr>
							<tr>
								<th><?=$lng['Bank name']?></th>
								<td>
									<select onChange="$('#bank_code').val(this.value)" name="bank_name" id="bank_name">
										<option selected value=""><?=$lng['Select']?></option>
										<? foreach($bank_codes as $k=>$v){ if($v['apply'] == 1){ ?>
											<option <? if($data['bank_code'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
										<? } } ?>
									</select>
								</td>
							</tr>
							<tr>
								<th><?=$lng['Bank branch']?></th>
								<td><input type="text" name="bank_branch" placeholder="..." value="<?=$data['bank_branch']?>"></td>
							</tr>
							<tr>
								<th><?=$lng['Bank account no.']?></th>
								<td><input type="text" name="bank_account" placeholder="..." value="<?=$data['bank_account']?>"></td>
							</tr>
							<tr>
								<th><?=$lng['Bank account name']?></th>
								<td><input type="text" name="bank_account_name" placeholder="..." value="<?=$data['bank_account_name']?>"></td>
							</tr>
							<tr>
								<th><?=$lng['Payment type']?></th>
								<td>
									<select name="pay_type">
										<!--<option value=""><?=$lng['Select']?></option>-->
										<option value="cash"><?=$lng['Cash']?></option>
										<option value="cheque"><?=$lng['Cheque']?></option>
										<? if($entity_banks){foreach($entity_banks as $k=>$v){ ?>
											<option <? if($data['pay_type'] == $v['code']){echo 'selected';}?> value="<?=$v['code']?>"><?=$bank_codes[$v['code']][$lang]?></option>
										<? }} ?>
									</select>
								</td>
							</tr>
						</tbody>
					</table>					

					<table class="basicTable editTable" border="0">
						<thead>
							<tr style="line-height:100%">
								<th colspan="2"><?=$lng['Accounting & Reporting']?></th>
							</tr>
						</thead>
						<tbody>
								<tr>
									<th><?=$lng['Accounting code']?></th>
									<td>
										<select name="account_code">
											<option <? if($data['account_code'] == 0){echo 'selected';}?> value="0"><?=$lng['Direct']?></option>
											<option <? if($data['account_code'] == 1){echo 'selected';}?> value="1"><?=$lng['Indirect']?></option>
										</select>
									</td>
								</tr>
								<tr>
									<th><?=$parameters[5][$lang]?></th>
									<td style="color:#999; padding:4px 10px">
										<select name="groups">
											<? foreach($groups as $k=>$v){ ?>
												<option <? if($data['groups'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
											<? } ?>
										</select>
									</td>
								</tr>


						</tbody>
					</table>
				</div>

				<div class="tab-content-right">

					<table class="basicTable editTable" border="0">
						<thead>
							<tr style="line-height:100%">
								<th colspan="2"><?=$lng['REVENU DEPARTMENT']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th><?=$lng['Tax calculation method']?></th>
								<td>
									<select name="calc_method">
										<option <? if($data['calc_method'] == 'cam'){echo "selected";} ?> value="cam"><?=$lng['Calculate in Advance Method']?> (CAM)</option>
										<option <? if($data['calc_method'] == 'acm'){echo "selected";} ?> value="acm"><?=$lng['Accumulative Calculation Method']?> (ACM)</option>
										<option <? if($data['calc_method'] == 'ytd'){echo "selected";} ?> value="ytd"><?=$lng['Year To Date']?> (YTD)</option>
									</select>
								</td>
							</tr>
							<tr>
								<th><?=$lng['Calculate Tax']?></th>
								<td>
									<select name="calc_tax" onchange="getcalcTax(this.value, <?=$data['income_section']?>)">
										<option <? if($data['calc_tax'] == '1'){echo 'selected';}?> value="1"><?=$lng['PND']?> 1</option>
										<option <? if($data['calc_tax'] == '3'){echo 'selected';}?> value="3"><?=$lng['PND']?> 3</option>
										<option <? if($data['calc_tax'] == '0'){echo 'selected';}?> value="0"><?=$lng['no Tax']?></option>
									</select>
								</td>
							</tr>

							<tr>
								<th><?=$lng['Tax Residency Status']?></th>
								<td>
									<select name="tax_residency_status">
										<? foreach($tax_residency_status as $key => $val){ ?>
											<option value="<?=$key?>" <? if($data['tax_residency_status'] == $key){echo 'selected';}?>><?=$val?></option>
										<? } ?>
									</select>
								</td>
							</tr>
							<tr>
								<th><?=$lng['Income section']?></th>
								<td>
									<select name="income_section" id="income_section_vals">
										<?/* foreach($income_section as $key => $val){ ?>
											<option value="<?=$key?>"><?=$val?></option>
										<? } */?>
									</select>
								</td>
							</tr>
							<!--<tr>
								<th>PND 1</th>
								<td style="padding:5px 0 0 10px"><input <? if($data['pnd'] == 1){echo "checked";} ?> type="radio" name="pnd" value="1"></td>
							</tr>
							<tr>
								<th>PND 3<? //=$lng['PND 1']?></th>
								<td style="padding:5px 0 0 10px"><input <? if($data['pnd'] == 3){echo "checked";} ?> type="radio" name="pnd" value="1"></td>
							</tr>-->
							<tr>
								<th style="width:5%"><?=$lng['Modify Tax amount']?></th>
								<td><input class="sel neg_numeric" type="text" name="modify_tax" placeholder="..." value="<?=$data['modify_tax']?>"></td>
							</tr>
							<tr>
								<td colspan="2" style="height:10px"></td>
							</tr>
						</tbody>
						<thead>
							<tr style="line-height:100%">
								<th colspan="2"><?=$lng['SOCIAL SECURITY OFFICE']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th><?=$lng['Calculate SSO']?></th>
								<td>
									<select id="calc_sso" name="calc_sso">
										<? foreach($noyes01 as $k=>$v){ ?>
											<option <? if($data['calc_sso'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v?></option>
										<? } ?>
									</select>
								</td>
							</tr>
							<tr>
								<th><?=$lng['SSO paid by']?></th>
								<td>
									<select name="sso_by" style="xwidth:auto">
										<option <? if($data['sso_by'] == '0'){echo 'selected';}?> value="0"><?=$lng['Employee']?></option>
										<option <? if($data['sso_by'] == '1'){echo 'selected';}?> value="1"><?=$lng['Company']?></option>
									</select>
									<!--<b style="color:#c00">Only if Calculation base = Net amount</b>-->
								</td>
							</tr>
							<!--<tr>
								<th>Hospital chosen<? //=$lng['Annual leave (days)']?></th>
								<td><input type="text" name="sso_hospital" placeholder="__" value="<?=$data['sso_hospital']?>"></td>
							</tr>-->
						</tbody>

						<thead>
							<tr style="line-height:100%">
								<th colspan="2"><?=$lng['MONTHLY LEGAL DEDUCTIONS FROM NET SALARY']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th><?=$lng['Government house banking']?></th>
								<td><input class="sel float72" type="text" name="gov_house_banking" placeholder="..." value="<?=$data['gov_house_banking']?>">
								</td>
							</tr>
							<tr>
								<th><?=$lng['Savings']?></th>
								<td><input class="sel float72" type="text" name="savings" placeholder="..." value="<?=$data['savings']?>">
								</td>
							</tr>
							<tr>
								<th><?=$lng['Legal execution deduction']?></th>
								<td><input class="sel float72" type="text" name="legal_execution" placeholder="..." value="<?=$data['legal_execution']?>">
								</td>
							</tr>
							<tr>
								<th><?=$lng['Kor.Yor.Sor (Student loan)']?></th>
								<td><input class="sel float72" type="text" name="kor_yor_sor" placeholder="..." value="<?=$data['kor_yor_sor']?>">
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			
			<div class="tab-pane" id="tab_fin_benefits">

				<div class="tab-content-left">
					<table class="basicTable editTable" border="0">
						<thead>
							<tr style="line-height:100%">
								<th colspan="2"><?=$lng['BASIC SALARY']?>
									<a class="text-success float-right" id="CareerModal"><i class="fa fa-edit font-weight-bold  fa-lg"></i></a>
								</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th><?=$lng['Start Date']?></th>
								<td><input type="text" name="start_date" id="start_date" value="<? if(!empty($ecdata[0]['start_date'])){echo date('d-m-Y', strtotime($ecdata[0]['start_date']));}?>" autocomplete="off"></td>
							</tr>

							<tr>
								<th><?=$lng['Unit Base']?></th>
								<td><input type="text" name="unit_base" id="unit_base" value=""></td>
							</tr>
							
							<tr>
								<th><?=$lng['Basic salary']?></th>
								<td><input readonly="readonly" type="text" id="base_salary" name="base_salary" value="<?=isset($ecdata) ? $ecdata[0]['salary'] : '';?>"></td>
							</tr>
							
							<tr>
								<td colspan="2" style="height:10px"></td>
							</tr>
						</tbody>

						<thead>
							<tr style="line-height:100%">
								<th colspan="2"><?=$lng['FIXED ALLOWANCES']?></th>
							</tr>
						</thead>
						<tbody>
						
						<?
						if($getNewFixAllowDeduct['inc_fix']){ foreach($getNewFixAllowDeduct['inc_fix'] as $k=>$v){
							$fixAllow = unserialize($ecdata[0]['fix_allow']);
						 	if($fixAllow[$v['id']] > 0){
						?>
							<tr>
								<th><?=$v[$lang]?></th>
								<td class="pl-2"><?=$fixAllow[$v['id']]?>
							</tr>
						<? } } }else{ ?>
							<tr>
								<td colspan="2" style="padding:4px 10px"><?=$lng['No allowances selected']?></td>
							</tr>
						<? } ?>
							<tr>
								<td colspan="2" style="height:10px"></td>
							</tr>
						</tbody>
						<thead>
							<tr style="line-height:100%">
								<th colspan="2"><?=$lng['FIXED DEDUCTIONS']?></th>
							</tr>
						</thead>
						<tbody>
							
							<?
							if($getNewFixAllowDeduct['ded_fix']){ foreach($getNewFixAllowDeduct['ded_fix'] as $k=>$v){ 
								$fixDeduct = unserialize($ecdata[0]['fix_deduct']);
								if($fixDeduct[$v['id']] > 0){
							?>
								<tr>
									<th><?=$v[$lang]?></th>
									<td class="pl-2"><?=$fixDeduct[$v['id']]?></td>
								</tr>
							<? } } }else{ ?>
								<tr>
									<td colspan="2" style="padding:4px 10px"><?=$lng['No deductions selected']?></td>
								</tr>
							<? } ?>
								<tr>
									<td colspan="2" style="height:10px"></td>
								</tr>
						</tbody>

					</table>
				</div>

				<div class="tab-content-right">

					<?if($_SESSION['rego']['empView'] == 'active'){ ?>
						<!-- <button class="btn btn-primary btn-fr pl-2 pr-2" type="button" id="CareerModal" style="position: absolute;top: 15px;right: 20px;"><i class="fa fa-edit"></i>&nbsp;<?=$lng['Edit']?></button> -->
					<? } ?>
					
					<table class="basicTable editTable" border="0">
						<thead>
							<tr style="line-height:100%">
								<th colspan="2"><?=strtoupper($lng['Payroll information'])?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th><?=$lng['Payroll calculator model']?></th>
								<td>
									<select name="payroll_modal_value" style="width:100%">
										<? foreach($getPayrollModels['PayrollModel'] as $rowPM){ ?>
											<option value="<?=$rowPM['id']?>"><?=$rowPM['name']?></option>
										<? } ?>
									</select>
								</td>
							</tr>
							<tr>
								<th><?=$lng['Related calculation models']?></th>
								<td style="padding:4px 10px"></td>
							</tr>
							<tr>
								<th><?=$lng['Other calculation models']?></th>
								<td style="padding:4px 10px"></td>
							</tr>

							<tr style="line-height:100%">
								<th colspan="2"></th>
							</tr>
						</tbody>
						<thead>
							<tr style="line-height:100%">
								<th colspan="2"><?=strtoupper($lng['Variable allowances'])?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="2" style="padding:4px 10px"><?=$lng['No allowances selected']?></td>
								
							</tr>
						</tbody>
						
						<thead>
							<tr style="line-height:100%">
								<th colspan="2"><?=strtoupper($lng['Variable deductions'])?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="2" style="padding:4px 10px"><?=$lng['No deductions selected']?></td>
								
							</tr>
						</tbody>
						
					</table>

				</div>
			</div>
			
			<div class="tab-pane" id="tab_PSF_PVF">

				<div class="tab-content-left">
					<table class="basicTable inputs" style="margin-bottom: 63px !important;">
						<thead>
							<tr style="line-height:100%">
								<th colspan="2"><?=$lng['PENSION FUND PSF']?></th>
								
							</tr>
						</thead>
						<tbody>
							<tr>
								<th style="background:#ffe "><?=$lng['Calculate PSF']?></th>
								<td>
									<select name="calc_psf" style="width:100%;background:#ffe">
										<? foreach($noyes01 as $k=>$v){ ?>
											<option <? if($data['calc_psf'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v?></option>
										<? } ?>
									</select>
								</td>
							</tr>
							<tr>
								<th style="background:#ffe"><?=$lng['% or THB']?></th>
								<td style="background:#ffe">
									<!-- <input type="text" name="perc_thb_psf" value="<?=$data['perc_thb_psf']?>" style="width:100%; background:#ffe"> -->
									<select name="perc_thb_psf" style="width:100%;background:#ffe">
										<? foreach($per_or_thb as $k=>$v){ ?>
											<option <? if($data['perc_thb_psf'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v?></option>
										<? } ?>
									</select>
								</td>
							</tr>
							<tr>
								<th style="background:#ffe"><?=$lng['Contribution']?> <?=$lng['Employee']?></th>
								<td style="background:#ffe">
									<input type="text" name="contri_emple_psf" value="<?=$data['contri_emple_psf']?>" style="width:100%; background:#ffe">
								</td>
							</tr>
							<tr>
								<th style="background:#ffe"><?=$lng['Contribution']?> <?=$lng['Employer']?></th>
								<td style="background:#ffe">
									<input type="text" name="contri_emplyer_psf" value="<?=$data['contri_emplyer_psf']?>" style="width:100%; background:#ffe">
								</td>
							</tr>

						</tbody>
					</table>

					<table class="basicTable mb-2">
						<thead>
							<tr style="line-height:100%">
								<th colspan="6"><?=strtoupper($lng['Current'])?> <?=strtoupper($lng['Year'])?></th>
							</tr>
						</thead>
						<tbody style="background:#ffe">
							<tr>
								<th></th>
								<th><?=$lng['Employee']?></th>
								<th><?=$lng['Company']?></th>
								<th></th>
								<th><?=$lng['Employee']?></th>
								<th><?=$lng['Company']?></th>
							</tr>
							<tr>
								<th>Jan</th>
								<td></td>
								<td></td>
								<th>Jul</th>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<th>Feb</th>
								<td></td>
								<td></td>
								<th>Aug</th>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<th>Mar</th>
								<td></td>
								<td></td>
								<th>Sep</th>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<th>Apr</th>
								<td></td>
								<td></td>
								<th>Oct</th>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<th>May</th>
								<td></td>
								<td></td>
								<th>Nov</th>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<th>Jun</th>
								<td></td>
								<td></td>
								<th>Dec</th>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>

					<table class="basicTable">
						<thead>
							<tr style="line-height:100%">
								<th colspan="3"><?=strtoupper($lng['Previous'])?> <?=strtoupper($lng['Year'])?></th>
							</tr>
						</thead>
						<tbody style="background:#ffe">
							<tr>
								<th><?=$lng['Year']?></th>
								<th><?=$lng['Employee']?></th>
								<th><?=$lng['Company']?></th>
							</tr>
							<? for ($i=1; $i<=5; $i++) { ?>
								<tr>
									<td class="tar"><?=$i?></td>
									<td></td>
									<td></td>
								</tr>
							<? } ?>
							<tr>
								<th><?=$lng['Total']?></th>
								<td colspan="2"></td>
							</tr>
							<tr>
								<th><?=$lng['Current']?> <?=$lng['Year']?></th>
								<td colspan="2"></td>
							</tr>
							<tr>
								<th><?=$lng['Total']?> YTD</th>
								<td colspan="2"></td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="tab-content-right">
					<table class="basicTable inputs mb-2">
						<thead>
							<tr style="line-height:100%">
								<th colspan="2"><?=$lng['PROVIDENT FUND PVF']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th style="background: #efe"><?=$lng['Calculate PVF']?></th>
								<td>
									<select name="calc_pvf" style="width:100%; background:#efe">
										<? foreach($noyes01 as $k=>$v){ ?>
											<option <? if($data['calc_pvf'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v?></option>
										<? } ?>
									</select>
								</td>
							</tr>
							<tr>
								<th style="background:#efe"><?=$lng['% or THB']?></th>
								<td style="background:#efe">
									<!-- <input type="text" name="perc_thb_pvf" value="<?=$data['perc_thb_pvf']?>"> -->
									<select name="perc_thb_pvf" style="width:100%;background:#efe">
										<? foreach($per_or_thb as $k=>$v){ ?>
											<option <? if($data['perc_thb_pvf'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v?></option>
										<? } ?>
									</select>
								</td>
							</tr>
							<tr>
								<th style="background:#efe"><?=$lng['Contribution']?> <?=$lng['Employee']?></th>
								<td style="background:#efe">
									<input type="text" name="contri_emple_pvf" value="<?=$data['contri_emple_pvf']?>" style="width:100%; background:#ffe">
								</td>
							</tr>
							<tr>
								<th style="background:#efe"><?=$lng['Contribution']?> <?=$lng['Employer']?></th>
								<td style="background:#efe">
									<input type="text" name="contri_emplyer_pvf" value="<?=$data['contri_emplyer_pvf']?>" style="width:100%; background:#ffe">
								</td>
							</tr>
							<tr>
								<th style="background:#efe"><?=$lng['Provident fund no.']?></th>
								<td style="background:#efe">
									<input type="text" name="pro_fndNo_pvf" value="<?=$data['pro_fndNo_pvf']?>" style="width:100%; background:#ffe">
								</td>
							</tr>
							<tr>
								<th style="background:#efe"><?=$lng['PVF registration date']?></th>
								<td style="background:#efe">
									<input type="text" class="datepick" name="reg_date_pvf" value="<? if(!empty($data['reg_date_pvf'])){echo date('d-m-Y', strtotime($data['reg_date_pvf']));}?>" style="width:100%; background:#ffe">
								</td>
							</tr>
						</tbody>
					</table>
					<table class="basicTable mb-2">
						<thead>
							<tr style="line-height:100%">
								<th colspan="6"><?=strtoupper($lng['Current'])?> <?=strtoupper($lng['Year'])?></th>
							</tr>
						</thead>
						<tbody style="background:#efe">
							<tr>
								<th></th>
								<th><?=$lng['Employee']?></th>
								<th><?=$lng['Company']?></th>
								<th></th>
								<th><?=$lng['Employee']?></th>
								<th><?=$lng['Company']?></th>
							</tr>
							<tr>
								<th>Jan</th>
								<td></td>
								<td></td>
								<th>Jul</th>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<th>Feb</th>
								<td></td>
								<td></td>
								<th>Aug</th>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<th>Mar</th>
								<td></td>
								<td></td>
								<th>Sep</th>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<th>Apr</th>
								<td></td>
								<td></td>
								<th>Oct</th>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<th>May</th>
								<td></td>
								<td></td>
								<th>Nov</th>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<th>Jun</th>
								<td></td>
								<td></td>
								<th>Dec</th>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>

					<table class="basicTable">
						<thead>
							<tr style="line-height:100%">
								<th colspan="3"><?=strtoupper($lng['Previous'])?> <?=strtoupper($lng['Year'])?></th>
							</tr>
						</thead>
						<tbody style="background:#efe">
							<tr>
								<th><?=$lng['Year']?></th>
								<th><?=$lng['Employee']?></th>
								<th><?=$lng['Company']?></th>
							</tr>
							<? for ($i=1; $i<=5; $i++) { ?>
								<tr>
									<td class="tar"><?=$i?></td>
									<td></td>
									<td></td>
								</tr>
							<? } ?>
							<tr>
								<th><?=$lng['Total']?></th>
								<td colspan="2"></td>
							</tr>
							<tr>
								<th><?=$lng['Current']?> <?=$lng['Year']?></th>
								<td colspan="2"></td>
							</tr>
							<tr>
								<th><?=$lng['Total']?> YTD</th>
								<td colspan="2"></td>
							</tr>
						</tbody>
					</table>
				</div>

			</div>

			<div class="tab-pane" id="tab_fin_tax">
				<? include('employee_tax_data.inc.php')?>
			</div>

			<div class="tab-pane" id="tab_his_career">
				<table style="width:100%; height:100%">
					<tr>
						<td style="width:50%; padding-right:15px; vertical-align:top">
							
								<table id="career_table" class="basicTable">
									<thead>
										<tr>
											<th><?=$lng['Start date']?></th>
											<th><?=$lng['End date']?></th>
											<!-- <th><?=$lng['Field Changed']?></th> -->
											<th><?=$lng['Position']?></th>
											<th><?=$lng['Salary']?></th>
										</tr>
								 	</thead>
								 	<tbody>
								 	<?if(isset($ecdata) && is_array($ecdata)){
								 		foreach($ecdata as $row){ ?>
								 		<tr data-id="<?=$row['id']?>">
								 			<td>
								 				<? if(!empty($row['start_date'])){echo date('d-m-Y', strtotime($row['start_date']));}?>
								 			</td>
								 			<td><? if(!empty($row['end_date'])){echo date('d-m-Y', strtotime($row['end_date']));}?></td>
						 		 			<td><?=$positions[$row['position']][$lang]?></td>
								 			<td><?=$row['salary']?></td> 
								 		</tr>
								 	<? } } ?>
								 	</tbody>
								</table>
								<!-- <button id="addCareer" class="btn btn-primary btn-xs" style="margin:8px 0 0 0" type="button"><i class="fa fa-plus fa-mr"></i><?=$lng['Add'].' '.$lng['History']?></button> -->

								<button class="btn btn-primary btn-xs" style="margin:8px 0 0 0" type="button" id="CareerModalhis"><i class="fa fa-plus fa-mr"></i><?=$lng['Add'].' '.$lng['History']?></button>
							

						</td>
						<td id="caColor" style="width:50%; background:rgba(200,255,200,0.1); padding:0px; vertical-align:top">
							<div style="overflow-y:auto; height:100%; border:1px solid #eee; padding:1px 5px 5px; position:relative">
							<form id="careerFormHis">
								
								<input type="hidden" name="emp_id" value="<?=$empID?>">
								<table id="careerTable" class="basicTable nowrap" style="width:100%; display:none">
									<thead>
										<tr style="border-bottom: 1px #ccc solid;background: #eee;">
											<th colspan="4"><?=$lng['Career path']?> <span id="caAction"></span></th>
										</tr>
									</thead>
									<thead>
										<tr style="background: #eee;">
											<th colspan="4">Employment data </th>
										</tr>
									</thead>	
									<tbody>
										<tr>
											<th><i class="man"></i><?=$lng['Position']?></th>
											<td style="padding:0">
												<!-- <input type="text" name="position" placeholder="..."> -->
												<select name="position" class="disabledropdown removeDownArrow">
												<? foreach($positions as $k => $v){ ?>
													<option value="<?=$v['id']?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
											</td>
										</tr>
										
										<tr>
											<th><i class="man"></i> <?=$lng['Start date']?></th>
											<td colspan="3" style="padding:0">
												<input readonly style="cursor:pointer"  type="text" name="start_date" placeholder="...">
											</td>
										</tr>
										<tr>
											<th><?=$lng['End date']?></th>
											<td colspan="3" style="padding:0">
												<input readonly style="cursor:pointer"  type="text" name="end_date" placeholder="...">
											</td>
										</tr>
										<tr style="border-bottom: 1px #ccc solid;">
											<th><?=$lng['Salary']?></th>
											<td style="padding:0">
												<input readonly type="text" id="salary" name="salary" placeholder="...">
											</td>
										</tr>
										
										<thead>
											<tr style="background: #eee;">
												<th colspan="4">Benefits</th>
											</tr>
										</thead>
										<!-- <tr style="background: #ebfbea;" id="fixallowsec"><th class="tal" colspan="2"><?=$lng['Fixed allowances']?></th></tr> -->
										<tr  id="fixallowsec"><th class="tal" colspan="2"><?=$lng['Fixed allowances']?></th></tr>
										<? /*
										if($getNewFixAllowDeduct['inc_fix']){ 
										 	foreach($getNewFixAllowDeduct['inc_fix'] as $k=>$v){
										 		$fixAllow = unserialize($ecdata[0]['fix_allow']);
						 						if($fixAllow[$v['id']] > 0){
										?>
											<tr style="background: #ebfbea;">
												<th><?=$v[$lang]?></th>
												<td><?=$fixAllow[$v['id']];?></td>
											</tr>
										<? } } } */?>

										<!-- <tr style="background: #ebfbea;" id="fixdeductsec"><th class="tal" colspan="2"><?=$lng['Fixed deductions']?></th></tr> -->
										<tr  id="fixdeductsec"><th class="tal" colspan="2"><?=$lng['Fixed deductions']?></th></tr>
										<? /*
										if($getNewFixAllowDeduct['ded_fix']){ 
										 	foreach($getNewFixAllowDeduct['ded_fix'] as $k=>$v){
										 		$fixDeduct = unserialize($ecdata[0]['fix_deduct']);
												if($fixDeduct[$v['id']] > 0){
										?>
											<tr style="background: #ebfbea;">
												<th><?=$v[$lang]?></th>
												<td><?=$fixDeduct[$v['id']];?></td>
											</tr>
										<? } } } */?>
										<!-- <tr style="background: #ebfbea;" ><th class="tal" colspan="2"><?=$lng['Responsibilities']?></th></tr> -->
										<thead>
											<tr style="background: #eee;">
												<th colspan="4" style="border-top: 1px #ccc solid;">Responsibilities</th>
											</tr>
										</thead>
										<tr>
											<th><?=$lng['Head of Location']?></th>
											<td style="padding:0">
												<select name="head_branch"  class="disabledropdown removeDownArrow">
													<option value="">...</option>
													<? foreach($branches as $k=>$v){ ?>
														<option <? if($data['head_branch'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
													<? } ?>
												</select>
											</td>
										</tr>
										<tr>
											<th><?=$lng['Head of division']?></th>
											<td style="padding:0">
												<select name="head_division"  class="disabledropdown removeDownArrow">
													<option value="">...</option>
													<? foreach($divisions as $k=>$v){ ?>
														<option <? if($data['head_division'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
													<? } ?>
												</select>
											</td>
										</tr>							
										<tr>
											<th><?=$lng['Head of department']?></th>
											<td style="padding:0">
												<select name="head_department"  class="disabledropdown removeDownArrow"> 
													<option value="">...</option>
													<? foreach($departments as $k=>$v){ ?>
														<option <? if($data['head_department'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
													<? } ?>
												</select>
											</td>
										</tr>
										<tr>
											<th><?=$lng['Team supervisor']?></th>
											<td style="padding:0">
												<select name="team_supervisor"  class="disabledropdown removeDownArrow">
													<option value="">...</option>
													<? foreach($teams as $k=>$v){ ?>
														<option <? if($data['team_supervisor'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
													<? } ?>
												</select>
											</td>
										</tr>


										<thead>
											<tr style="background: #eee;">
												<th style="border-top: 1px #ccc solid;" colspan="4">Other</th>
											</tr>
										</thead>
										<tr>
											<th><?=$lng['Other benefits']?></th>
											<td style="padding:0">
												<textarea readonly="readonly" data-autoresize style="resize:vertical" rows="2" name="other_benifits" placeholder="..."></textarea>
											</td>
										</tr>
										<tr>
											<th><?=$lng['Remarks']?></th>
											<td colspan="3" style="padding:0">
												<textarea readonly ="readonly" data-autoresize style="resize:vertical" rows="2" name="remarks" placeholder="..."></textarea>
											</td>
										</tr>
										<tr style="border:0">
											<th><?=$lng['Attachments']?></th>
											<td colspan="4">
												<!-- <b style="display:block; margin-bottom:3px"><?=$lng['Attachments']?></b> -->
												<div id="caAttach"></div>
												<div id="attachCareer" style="clear:both">
													<!-- <input style="margin:0 0 5px 0" class="attachBtn" name="attachment[]" type="file" /> -->
												</div>
											</td>
										</tr>
									</tbody>
								</table>
								<!-- <button disabled id="caBtn" class="btn btn-primary" style="position:absolute; top:0px; right:5px; display:none" type="submit"><i class="fa fa-save"></i>&nbsp;&nbsp;<?=$lng['Update']?> <?=$lng['Career']?></button> -->
							</form>
							</div>
						</td>
					</tr>
				</table>
			</div>
			
			<div class="tab-pane" id="tab_fin_documents">
				<div style="width:0; height:0; overflow:hidden" >
				<input name="att_bankbook" id="att_bankbook" type="file" />
				<input name="att_contract" id="att_contract" type="file" />
				<input name="attach5" id="attach5" type="file" />
				<input name="attach6" id="attach6" type="file" />
				<input name="attach7" id="attach7" type="file" />
				<input name="attach8" id="attach8" type="file" />
				</div>
				
				<table class="basicTable" border="0">
					<thead>
						<tr style="line-height:100%">
							<th colspan="2"><?=$lng['DOCUMENTS']?></th>
							<th style="width:1%" data-toggle="tooltip" title="<?=$lng['Upload']?>"><i class="fa fa-upload fa-lg"></i></th>
							<th style="width:1%" data-toggle="tooltip" title="<?=$lng['Download']?>"><i class="fa fa-download fa-lg"></i></th>
							<th style="width:1%" data-toggle="tooltip" title="<?=$lng['Delete']?>"><i class="fa fa-trash fa-lg"></i></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th><?=$lng['Bankbook']?></th>
							<td id="bankbook_name" style="width:95%; color:#999; font-style:italic"><?=$data['att_bankbook']?></td>
							<td><a href="#" onClick="$('#att_bankbook').click();"><i class="fa fa-upload fa-lg"></i></a></td>
							<td class="tac"><?=$att_bankbook?></td>
							<td><a href="#" data-id="att_bankbook" class="<?=$delDoc?>"><i class="fa fa-trash fa-lg"></i></a></td>
						</tr>	
						<tr>
							<th><?=$lng['Contract']?></th>
							<td id="contract_name" style="color:#999; font-style:italic"><?=$data['att_contract']?></td>
							<td><a href="#" onClick="$('#att_contract').click();"><i class="fa fa-upload fa-lg"></i></a></td>
							<td class="tac"><?=$att_contract?></td>
							<td><a href="#" data-id="att_contract" class="<?=$delDoc?>"><i class="fa fa-trash fa-lg"></i></a></td>
						</tr>	
						<tr>
							<th><?=$lng['Additional file']?></th>
							<td id="attach5_name" style="color:#999; font-style:italic"><?=$data['attach5']?></td>
							<td><a href="#" onClick="$('#attach5').click();"><i class="fa fa-upload fa-lg"></i></a></td>
							<td class="tac"><?=$attach5?></td>
							<td><a href="#" data-id="attach5" class="<?=$delDoc?>"><i class="fa fa-trash fa-lg"></i></a></td>
						</tr>	
						<tr>
							<th><?=$lng['Additional file']?></th>
							<td id="attach6_name" style="color:#999; font-style:italic"><?=$data['attach6']?></td>
							<td><a href="#" onClick="$('#attach6').click();"><i class="fa fa-upload fa-lg"></i></a></td>
							<td class="tac"><?=$attach6?></td>
							<td><a href="#" data-id="attach6" class="<?=$delDoc?>"><i class="fa fa-trash fa-lg"></i></a></td>
						</tr>	
						<tr>
							<th><?=$lng['Additional file']?></th>
							<td id="attach7_name" style="color:#999; font-style:italic"><?=$data['attach7']?></td>
							<td><a href="#" onClick="$('#attach7').click();"><i class="fa fa-upload fa-lg"></i></a></td>
							<td class="tac"><?=$attach7?></td>
							<td><a href="#" data-id="attach7" class="<?=$delDoc?>"><i class="fa fa-trash fa-lg"></i></a></td>
						</tr>	
						<tr>
							<th><?=$lng['Additional file']?></th>
							<td id="attach8_name" style="color:#999; font-style:italic"><?=$data['attach8']?></td>
							<td><a href="#" onClick="$('#attach8').click();"><i class="fa fa-upload fa-lg"></i></a></td>
							<td class="tac"><?=$attach8?></td>
							<td><a href="#" data-id="attach8" class="<?=$delDoc?>"><i class="fa fa-trash fa-lg"></i></a></td>
						</tr>	
					</tbody>
				</table>
			</div>
			
			<div class="tab-pane" id="tab_fin_contract">
				<table class="basicTable editTable" border="0">
					<thead>
					</thead>
					<tbody>
						<tr>
							<th><?=$lng['Joining date']?></th>
							<td><input id="startdat" readonly type="text" value="<? if(!empty($data['joining_date'])){echo date('d-m-Y', strtotime($data['joining_date']));}?>"></td>
						</tr>

						<tr>
							<th><?=$lng['Notice date']?></th>
							<td><input type="text" readonly style="cursor:pointer" class="datepick" name="notice_date" placeholder="..." value="<?=$data['notice_date']?>"></td>
						</tr>
						<tr>
							<th><?=$lng['End date']?></th>
							<td><input type="text" style="cursor:pointer; width:109px" class="datepick" name="resign_date" id="resign_dateValue" placeholder="..." value="<? if(!empty($data['resign_date'])){echo date('d-m-Y', strtotime($data['resign_date']));}?>"><b style="color:#b00"><?=$lng['Last working day']?></b></td>
						</tr>
						<tr>
							<th><?=$lng['End reason']?></th>
							<td><input type="text" name="resign_reason" placeholder="..." value="<?=$data['resign_reason']?>"></td>
						</tr>
						<tr>
							<th><?=$lng['Employee status']?></th><td>
								<select name="emp_status" id="emp_status" onChange="$('#empstatus').val(this.value)" style="width:auto">
									<? foreach($emp_status as $k=>$v){ ?>
										<option <? if($data['emp_status'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v?></option>
									<? } ?>
								</select>
								<b style="color:#b00"><?=$lng['When resign date filled in...']?></b></td>
							</td>
						</tr>




						<tr>
							<td colspan="2" style="height:10px"></td>
						</tr>
					</tbody>
					<thead>
						<tr style="line-height:100%">
							<th colspan="2"><?=$lng['ADDITIONAL COMPENSATIONS AT END OF EMPLOYEMENT']?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th><?=$lng['Month Payroll']?></th>
							<td>
								<select name="month_payroll" id="month_payroll">
									<option value="0"><?=$lng['Please select']?></option>
									<?foreach($months as $k => $v){?>
										<option value="<?=$k?>"><?=$v?></option>
									<? } ?>
								</select>
							</td>
						</tr>
						<tr>
							<th><?=$lng['Remaining salary']?></th>
							<td><input class="float72 sel notnull" type="text" id="remaining_salary" name="remaining_salary" placeholder="..." value="<?=$data['remaining_salary']?>"></td>
						</tr>
						<tr>
							<th><?=$lng['Notice payment']?></th>
							<td><input class="float72 sel notnull" type="text" id="notice_payment" name="notice_payment" placeholder="..." value="<?=$data['notice_payment']?>"></td>
						</tr>
						<tr>
							<th><?=$lng['Paid leave']?></th>
							<td><input class="float72 sel notnull" type="text" id="paid_leave" name="paid_leave" placeholder="..." value="<?=$data['paid_leave']?>"></td>
						</tr>
						<tr>
							<th><?=$lng['Severance']?></th>
							<td><input class="float72 sel notnull" type="text" id="severance" name="severance" placeholder="..." value="<?=$data['severance']?>"></td>
						</tr>
						<tr>
							<th><?=$lng['Other income']?></th>
							<td><input class="float72 sel notnull" type="text" id="other_income" name="other_income" placeholder="..." value="<?=$data['other_income']?>"></td>
						</tr>
						<tr>
							<th><?=$lng['Remarks']?></th>
							<td><textarea placeholder="..." rows="4" id="remarks" name="remarks"><?=$data['remarks']?></textarea></td>
						</tr>
					</tbody>
				</table>
			</div>
			
		</div>
		</fieldset></form>
		
	</div>

	<!-- Modal modalAddNew -->
	<div class="modal fade" id="modalAddEmpcareer" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fa fa-user"></i>&nbsp; <?=ucwords($lng['Add Employee Benefits'])?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body modal-tabs">

					<form id="careerForm">

						<input type="hidden" name="emp_id" value="<?=$empID?>">
						<input type="hidden" name="career_id_curr" value="<?=isset($ecdata) ? $ecdata[0]['id'] : '';?>">

					    <div class="tab">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
										<th colspan="3"><?=$lng['BASIC SALARY']?></th>
									</tr>
								</thead>
								<thead>
									<tr style="line-height:100%">
										<th></th>
										<th class="tac"><?=$lng['New']?></th>
										<th class="tac"><?=$lng['Current']?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th><?=$lng['Start Date']?></th>
										<td><input type="text" id="sdates" class="" name="start_date_new" autocomplete="off"></td>
										<td><input type="text" class="datepick1" name="start_date_curr" autocomplete="off" value="<? if(!empty($ecdata[0]['start_date'])){echo date('d-m-Y', strtotime($ecdata[0]['start_date']));}?>"></td>
									</tr>

									<tr>
										<th><?=$lng['End date']?></th>
										<td><input type="text" name="end_date_new" autocomplete="off" readonly></td>
										<td><input type="text" name="end_date_curr" id="end_curr" autocomplete="off" value="<? if(!empty($ecdata[0]['end_date'])){echo date('d-m-Y', strtotime($ecdata[0]['end_date']));}?>" readonly></td>
									</tr>

									<tr>
										<th><?=$lng['Position']?></th>
										<td>
											<select name="position_new">
												<? foreach($positions as $k => $v){ ?>
													<option value="<?=$v['id']?>" ><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
										<td>
											<select name="position_curr">
												<? foreach($positions as $k => $v){ ?>
													<option value="<?=$v['id']?>" <?if($v['id'] == $ecdata[0]['position']){echo 'selected';}?>><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>
									
									<tr>
										<th><?=$lng['Basic salary']?></th>
										<td><input type="text" name="salary_new" autocomplete="off"></td>
										<td><input type="text" name="salary_curr" autocomplete="off" value="<?=isset($ecdata) ? $ecdata[0]['salary'] : '';?>"></td>
									</tr>
								</tbody>
							</table>
						</div>

						<div class="tab">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
										<th colspan="3"><?=$lng['FIXED ALLOWANCES']?></th>
									</tr>
								</thead>
								<thead>
									<tr style="line-height:100%">
										<th></th>
										<th class="tac"><?=$lng['New']?></th>
										<th class="tac"><?=$lng['Current']?></th>
									</tr>
								</thead>
								<tbody>
								
								<? 
								if($getNewFixAllowDeduct['inc_fix']){ foreach($getNewFixAllowDeduct['inc_fix'] as $k=>$v){
								 	$fixAllow = unserialize($ecdata[0]['fix_allow']);
								 ?>
									<tr>
										<th><?=$v[$lang]?></th>
										<td>
											
											<input style="width:70px" class="numeric8 sel notnull" type="text" name="emp_fixa_new[<?=$v['id']?>]" placeholder="..." >
										</td>
										<td>
											
											<input style="width:70px" class="numeric8 sel notnull" type="text" name="emp_fixa_curr[<?=$v['id']?>]" placeholder="..." value="<?=$fixAllow[$v['id']]?>">
										</td>
									</tr>
								<? } }else{ ?>
									<tr>
										<td colspan="3" style="padding:4px 10px"><?=$lng['No allowances selected']?></td>
									</tr>
								<? } ?>
									<tr>
										<td colspan="3" style="height:10px"></td>
									</tr>
								</tbody>
							</table>
						</div>

						<div class="tab">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
										<th colspan="3"><?=$lng['FIXED DEDUCTIONS']?></th>
									</tr>
								</thead>
								<thead>
									<tr style="line-height:100%">
										<th></th>
										<th class="tac"><?=$lng['New']?></th>
										<th class="tac"><?=$lng['Current']?></th>
									</tr>
								</thead>
								<tbody>
									
									<? 
									if($getNewFixAllowDeduct['ded_fix']){ foreach($getNewFixAllowDeduct['ded_fix'] as $k=>$v){ 
										$fixDeduct = unserialize($ecdata[0]['fix_deduct']);
									?>
										<tr>
											<th><?=$v[$lang]?></th>
											<td>
												
												<input style="width:70px" class="numeric8 sel notnull" type="text" name="emp_fixd_new[<?=$v['id']?>]" placeholder="...">
											</td>
											<td>
												
												<input style="width:70px" class="numeric8 sel notnull" type="text" name="emp_fixd_curr[<?=$v['id']?>]" placeholder="..." value="<?=$fixDeduct[$v['id']]?>">
											</td>
										</tr>
									<? } }else{ ?>
										<tr>
											<td colspan="3" style="padding:4px 10px"><?=$lng['No deductions selected']?></td>
										</tr>
									<? } ?>
								</tbody>
							</table>
						</div>						

<!-- 						<div class="tab">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
										<th colspan="3"><?=$lng['RESPONSIBILITIESS']?></th>
									</tr>
								</thead>
								<thead>
									<tr style="line-height:100%">
										<th></th>
										<th class="tac"><?=$lng['New']?></th>
										<th class="tac"><?=$lng['Current']?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th><?=$lng['Head of Location']?></th>
										<td>
											<select name="head_branch_new" >
												<option value="">...</option>
												<? foreach($branches as $k=>$v){ ?>
													<option  value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
										<td>
											<select name="head_branch_cur" >
												<option value="">...</option>
												<? foreach($branches as $k=>$v){ ?>
													<option <? if($ecdata[0]['head_branch'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>									

									<tr>
										<th><?=$lng['Head of division']?></th>
										<td>
											<select name="head_division_new">
												<option value="">...</option>
												<? foreach($divisions as $k=>$v){ ?>
													<option  value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
										<td>
											<select name="head_division_cur">
												<option value="">...</option>
												<? foreach($divisions as $k=>$v){ ?>
													<option <? if($ecdata[0]['head_division'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>									
									<tr>
										<th><?=$lng['Head of department']?></th>
										<td>
											<select name="head_department_new" >
												<option value="">...</option>
												<? foreach($departments as $k=>$v){ ?>
													<option  value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
										<td>
											<select name="head_department_curr" >
												<option value="">...</option>
												<? foreach($departments as $k=>$v){ ?>
													<option <? if($ecdata[0]['head_department'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>									
									<tr>
										<th><?=$lng['Team supervisor']?></th>
										<td>
											<select name="team_supervisor_new" >
												<option value="">...</option>
												<? foreach($teams as $k=>$v){ ?>
													<option  value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
										<td>
											<select name="team_supervisor_curr" >
												<option value="">...</option>
												<? foreach($teams as $k=>$v){ ?>
													<option <? if($ecdata[0]['team_supervisor'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>
									
			
								</tbody>
							</table>
						</div> -->

			<!-- 			<div class="tab">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
										<th colspan="3"><?=$lng['Other']?></th>
									</tr>
								</thead>
								<thead>
									<tr style="line-height:100%">
										<th></th>
										<th class="tac"><?=$lng['New']?></th>
										<th class="tac"><?=$lng['Current']?></th>
									</tr>
								</thead>
								<tbody>
									
									<tr>
										<th><?=$lng['Other benefits']?></th>
										<td>
											<textarea data-autoresize style="resize:vertical" rows="2" name="other_benifits_new" placeholder="..."></textarea>
										</td>
										<td>
											<textarea data-autoresize style="resize:vertical" rows="2" name="other_benifits_curr" placeholder="..."><?=isset($ecdata) ? $ecdata[0]['other_benifits'] : '';?></textarea>
										</td>
									</tr>

									<tr>
										<th><?=$lng['Remarks']?></th>
										<td>
											<textarea data-autoresize style="resize:vertical" rows="2" name="remarks_new" placeholder="..."></textarea>
										</td>
										<td>
											<textarea data-autoresize style="resize:vertical" rows="2" name="remarks_curr" placeholder="..."><?=isset($ecdata) ? $ecdata[0]['remarks'] : '';?></textarea>
										</td>
									</tr>
									
									<tr>
										<th><?=$lng['Attachments']?></th>
										<td>
											<input type="file" name="attachment_new[]">
										</td>
										<td>
											<input type="file" name="attachment_curr[]">
										</td>
									</tr>
								</tbody>
							</table>
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


	<div class="modal fade" id="modalAddEmpcareer2" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fa fa-user"></i>&nbsp; <?=ucwords($lng['Add Employee Benefits'])?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body modal-tabs">

					<form id="careerForm2">

						<input type="hidden" name="emp_id2" value="<?=$empID?>">
						<input type="hidden" name="career_id_curr2" value="<?=isset($ecdata) ? $ecdata[0]['id'] : '';?>">

					    <div class="tab2">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
										<th colspan="3"><?=$lng['BASIC SALARY']?></th>
									</tr>
								</thead>
								<thead>
									<tr style="line-height:100%">
										<th></th>
										<th class="tac"><?=$lng['New']?></th>
										<th class="tac"><?=$lng['Current']?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th><?=$lng['Start Date']?></th>
										<td><input type="text" id="sdates2" class="" name="start_date_new2" autocomplete="off"></td>
										<td><input type="text" class="datepick12" name="start_date_curr2" autocomplete="off" value="<? if(!empty($ecdata[0]['start_date'])){echo date('d-m-Y', strtotime($ecdata[0]['start_date']));}?>"></td>
									</tr>

									<tr>
										<th><?=$lng['End date']?></th>
										<td><input type="text" name="end_date_new2" autocomplete="off" readonly></td>
										<td><input type="text" name="end_date_curr2" id="end_curr2" autocomplete="off" value="<? if(!empty($ecdata[0]['end_date'])){echo date('d-m-Y', strtotime($ecdata[0]['end_date']));}?>" readonly></td>
									</tr>

									<tr>
										<th><?=$lng['Position']?></th>
										<td>
											<select name="position_new2">
												<? foreach($positions as $k => $v){ ?>
													<option value="<?=$v['id']?>" ><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
										<td>
											<select name="position_curr2">
												<? foreach($positions as $k => $v){ ?>
													<option value="<?=$v['id']?>" <?if($v['id'] == $ecdata[0]['position']){echo 'selected';}?>><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>
									
									<tr>
										<th><?=$lng['Basic salary']?></th>
										<td><input type="text" name="salary_new2" autocomplete="off"></td>
										<td><input type="text" name="salary_curr2" autocomplete="off" value="<?=isset($ecdata) ? $ecdata[0]['salary'] : '';?>"></td>
									</tr>
								</tbody>
							</table>
						</div>

						<div class="tab2">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
										<th colspan="3"><?=$lng['FIXED ALLOWANCES']?></th>
									</tr>
								</thead>
								<thead>
									<tr style="line-height:100%">
										<th></th>
										<th class="tac"><?=$lng['New']?></th>
										<th class="tac"><?=$lng['Current']?></th>
									</tr>
								</thead>
								<tbody>
								
								<? 
								if($getNewFixAllowDeduct['inc_fix']){ foreach($getNewFixAllowDeduct['inc_fix'] as $k=>$v){
								 	$fixAllow = unserialize($ecdata[0]['fix_allow']);
								 ?>
									<tr>
										<th><?=$v[$lang]?></th>
										<td>
											
											<input style="width:70px" class="numeric8 sel notnull" type="text" name="emp_fixa_new2[<?=$v['id']?>]" placeholder="..." >
										</td>
										<td>
											
											<input style="width:70px" class="numeric8 sel notnull" type="text" name="emp_fixa_curr2[<?=$v['id']?>]" placeholder="..." value="<?=$fixAllow[$v['id']]?>">
										</td>
									</tr>
								<? } }else{ ?>
									<tr>
										<td colspan="3" style="padding:4px 10px"><?=$lng['No allowances selected']?></td>
									</tr>
								<? } ?>
									<tr>
										<td colspan="3" style="height:10px"></td>
									</tr>
								</tbody>
							</table>
						</div>

						<div class="tab2">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
										<th colspan="3"><?=$lng['FIXED DEDUCTIONS']?></th>
									</tr>
								</thead>
								<thead>
									<tr style="line-height:100%">
										<th></th>
										<th class="tac"><?=$lng['New']?></th>
										<th class="tac"><?=$lng['Current']?></th>
									</tr>
								</thead>
								<tbody>
									
									<? 
									if($getNewFixAllowDeduct['ded_fix']){ foreach($getNewFixAllowDeduct['ded_fix'] as $k=>$v){ 
										$fixDeduct = unserialize($ecdata[0]['fix_deduct']);
									?>
										<tr>
											<th><?=$v[$lang]?></th>
											<td>
												
												<input style="width:70px" class="numeric8 sel notnull" type="text" name="emp_fixd_new2[<?=$v['id']?>]" placeholder="...">
											</td>
											<td>
												
												<input style="width:70px" class="numeric8 sel notnull" type="text" name="emp_fixd_curr2[<?=$v['id']?>]" placeholder="..." value="<?=$fixDeduct[$v['id']]?>">
											</td>
										</tr>
									<? } }else{ ?>
										<tr>
											<td colspan="3" style="padding:4px 10px"><?=$lng['No deductions selected']?></td>
										</tr>
									<? } ?>
								</tbody>
							</table>
						</div>						

						<div class="tab2">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
										<th colspan="3"><?=$lng['RESPONSIBILITIESS']?></th>
									</tr>
								</thead>
								<thead>
									<tr style="line-height:100%">
										<th></th>
										<th class="tac"><?=$lng['New']?></th>
										<th class="tac"><?=$lng['Current']?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th><?=$lng['Head of Location']?></th>
										<td>
											<select name="head_branch_new2" >
												<option value="">...</option>
												<? foreach($branches as $k=>$v){ ?>
													<option  value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
										<td>
											<select name="head_branch_cur2" >
												<option value="">...</option>
												<? foreach($branches as $k=>$v){ ?>
													<option <? if($ecdata[0]['head_branch'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>									

									<tr>
										<th><?=$lng['Head of division']?></th>
										<td>
											<select name="head_division_new2">
												<option value="">...</option>
												<? foreach($divisions as $k=>$v){ ?>
													<option  value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
										<td>
											<select name="head_division_cur2">
												<option value="">...</option>
												<? foreach($divisions as $k=>$v){ ?>
													<option <? if($ecdata[0]['head_division'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>									
									<tr>
										<th><?=$lng['Head of department']?></th>
										<td>
											<select name="head_department_new2" >
												<option value="">...</option>
												<? foreach($departments as $k=>$v){ ?>
													<option  value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
										<td>
											<select name="head_department_curr2" >
												<option value="">...</option>
												<? foreach($departments as $k=>$v){ ?>
													<option <? if($ecdata[0]['head_department'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>									
									<tr>
										<th><?=$lng['Team supervisor']?></th>
										<td>
											<select name="team_supervisor_new2" >
												<option value="">...</option>
												<? foreach($teams as $k=>$v){ ?>
													<option  value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
										<td>
											<select name="team_supervisor_curr2" >
												<option value="">...</option>
												<? foreach($teams as $k=>$v){ ?>
													<option <? if($ecdata[0]['team_supervisor'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>
									
			
								</tbody>
							</table>
						</div>

						<div class="tab2">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
										<th colspan="3"><?=$lng['Other']?></th>
									</tr>
								</thead>
								<thead>
									<tr style="line-height:100%">
										<th></th>
										<th class="tac"><?=$lng['New']?></th>
										<th class="tac"><?=$lng['Current']?></th>
									</tr>
								</thead>
								<tbody>
									
									<tr>
										<th><?=$lng['Other benefits']?></th>
										<td>
											<textarea data-autoresize style="resize:vertical" rows="2" name="other_benifits_new2" placeholder="..."></textarea>
										</td>
										<td>
											<textarea data-autoresize style="resize:vertical" rows="2" name="other_benifits_curr2" placeholder="..."><?=isset($ecdata) ? $ecdata[0]['other_benifits'] : '';?></textarea>
										</td>
									</tr>

									<tr>
										<th><?=$lng['Remarks']?></th>
										<td>
											<textarea data-autoresize style="resize:vertical" rows="2" name="remarks_new2" placeholder="..."></textarea>
										</td>
										<td>
											<textarea data-autoresize style="resize:vertical" rows="2" name="remarks_curr2" placeholder="..."><?=isset($ecdata) ? $ecdata[0]['remarks'] : '';?></textarea>
										</td>
									</tr>
									
									<tr>
										<th><?=$lng['Attachments']?></th>
										<td>
											<input type="file" name="attachment_new2[]">
										</td>
										<td>
											<input type="file" name="attachment_curr2[]">
										</td>
									</tr>
								</tbody>
							</table>
						</div>

						<div style="overflow:auto;" class="mt-4" id="hideauto">
						    <div>
						      <button type="button" class="btn btn-primary btn-fl" id="prevBtn2" onclick="nextPrev2(-1)"><?=$lng['Prev']?></button>
						      <button type="button" class="btn btn-primary btn-fr" id="nextBtn2" onclick="nextPrev2(1)"><?=$lng['Next']?></button>
						    </div>
						</div>

					</form>

				</div>

			</div>
		</div>
	</div>


		<!-- Modal modalAddNew -->
<!-- 	<div class="modal fade" id="modalAddNew" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fa fa-user"></i>&nbsp; <?=strtoupper($lng['Add employee'])?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body modal-tabs" style="padding:10px 0">
					
						<table class="basicTable inputs" border="0" style="width: 100%;">
							<tbody>
								<tr>
									<th><i class="man"></i><?=$lng['Employee ID']?></th>
									<td>
										<input maxlength="10" type="text" name="emp_id_editable" id="emp_id_editable" placeholder="..." autocomplete="off" onchange="checkEmpIdExist(this.value)">
									</td>
								</tr>
							</tbody>
						</table>

						<div class="clear" style="height:15px"></div>

						<button id="saveEmp" class="btn btn-primary btn-fr mr-4" type="button"><i class="fa fa-save"></i>&nbsp; <?=$lng['Yes']?></button>
						
						<button class="btn btn-primary mr-1 btn-fr" type="button" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp; <?=$lng['No']?></button>
						<div class="clear"></div>

	

						
				</div>
			</div>
		</div>
	</div>
 -->
	
	<? include('employee_new_edit_script.php')?>

	<script>

	SetUnitBaseval();
	function SetUnitBaseval(){
		var contract_type = $('#contract_type').val();
		var calc_baseid = $('#calc_baseid').val();

		var unitBase;
		if(contract_type == 'month' && calc_baseid == 'gross'){
			unitBase = 'THB Gross/Month';
		}else if(contract_type == 'month' && calc_baseid == 'net'){
			unitBase = 'THB Net/Month';
		}else if(contract_type == 'day' && calc_baseid == 'gross'){
			unitBase = 'THB Gross/Day';
		}else if(contract_type == 'day' && calc_baseid == 'net'){
			unitBase = 'THB Net/Day';
		}else{
			unitBase = 'THB Gross/Month';
		}

		$('#unit_base').val(unitBase).attr('readonly',true);
	}

	var calc_taxchk = <?=isset($data['calc_tax']) ? $data['calc_tax'] : 1?>;
	var income_sectionchk = <?=isset($data['income_section']) ? $data['income_section'] : 1?>;

	getcalcTax(calc_taxchk,income_sectionchk);
	
	function getcalcTax(calc_tax,dbval){

		var income_section = <?=json_encode($income_section)?>;

		if(calc_tax == 1) {
			var opt = '';
			$.each(income_section, function(k,v){
				if(k == 1 || k == 2 || k == 3){
					if(dbval == k){ var seltd = 'selected';}else{var seltd = '';}
					opt += '<option value="'+k+'" '+seltd+'>'+v+'</option>';
				}	
			});

			$('#income_section_vals option').remove();
			$('#income_section_vals').append(opt);

		}else if(calc_tax == 3) {
			var opt = '';
			$.each(income_section, function(k,v){
				if(k == 4){
					if(dbval == k){ var seltd = 'selected';}else{var seltd = '';}
					opt += '<option value="'+k+'" '+seltd+'>'+v+'</option>';
				}	
			});

			$('#income_section_vals option').remove();
			$('#income_section_vals').append(opt);

		}else{
			var opt = '';
			$.each(income_section, function(k,v){
				if(k == 5){
					if(dbval == k){ var seltd = 'selected';}else{var seltd = '';}
					opt += '<option value="'+k+'" '+seltd+'>'+v+'</option>';
				}	
			});

			$('#income_section_vals option').remove();
			$('#income_section_vals').append(opt);
		}
	}
		
	$(document).ready(function() {
		
		var update = <?=json_encode($update)?>;
		var emp_id = <?=json_encode($_SESSION['rego']['empID'])?>;
		var fix_allow = <?=json_encode($fix_allow)?>;
		var incdedFix = <?=json_encode($fixalldedarr)?>;
		var ecdata = <?=json_encode($ecdata)?>;

		var dateParmeter;
		if(ecdata.length == 0){
			dateParmeter = '';
		}else{
			dateParmeter = 'new Date()';
		}

		$(document).on("click", "#CareerModal", function(e){
			//alert(dateParmeter);
			$(".sdatepick1").datepicker("destroy");
			$('#modalAddEmpcareer input#sdates').removeClass('sdatepick1').addClass('startPicker');
			$('#modalAddEmpcareer input[name="end_date_new"]').attr('readonly',true).removeClass('sdatepick1');

			$('.startPicker').datepicker({
				format: "dd-mm-yyyy",
				autoclose: true,
				inline: false,
				language: lang,
				todayHighlight: true,
				startDate: dateParmeter,
				orientation: "bottom left",
				
			}).on('changeDate', function(e){

				var dval = $('#modalAddEmpcareer input[name="start_date_new"]').val();
				$.ajax({
					url: "ajax/career_exist.php",
					type: 'POST',
					data: {dval:dval},
					success: function(result){

						if(result == 1){
							$("body").overhang({
								type: "error",
								message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;<?=$lng['Data'].' '.$lng['exist already']?>',
								duration: 2,
							})

							$('#modalAddEmpcareer input[name="start_date_new"]').val('');

						}else{
							
							var changeFormat = e.format();
							var datearray = changeFormat.split("-");
							var newdatemdy = datearray[1] + '-' + datearray[0] + '-' + datearray[2];

							var days = 1;
							var newdate1 = new Date(newdatemdy);
							var deductDate = newdate1.setDate(newdate1.getDate() - days);
							var dd = new Date(deductDate);
							//var end_date = dd.getDate() + '-' + (dd.getMonth()+1) + '-' + dd.getFullYear();
							var end_date = ('0' + dd.getDate()).slice(-2) + '-' + ('0' + (dd.getMonth()+1)).slice(-2) + '-' + dd.getFullYear();

							var start_date_curr = $('#modalAddEmpcareer input[name="start_date_curr"]').val();
							if(start_date_curr != ''){
								$('#modalAddEmpcareer input[name="end_date_curr"]').val(end_date);
							}

						}
					}
				})
			})


			$('#modalAddEmpcareer').modal('toggle');
		})

		$(document).on("click", "#CareerModalhis", function(e){

			$(".startPicker").datepicker("destroy");
			$('#modalAddEmpcareer input#sdates').removeClass('startPicker').addClass('sdatepick1');
			$('#modalAddEmpcareer input[name="end_date_new"]').attr('readonly',false).addClass('sdatepick1');
			
			$('.sdatepick1').datepicker({
				format: "dd-mm-yyyy",
				autoclose: true,
				inline: false,
				language: lang,
				todayHighlight: true,
				endDate: new Date(),
				orientation: "bottom left",
				
			}).on('changeDate', function(e){

				var dval = $('#modalAddEmpcareer input[name="start_date_new"]').val();
				$.ajax({
					url: "ajax/career_exist.php",
					type: 'POST',
					data: {dval:dval},
					success: function(result){

						if(result == 1){
							$("body").overhang({
								type: "error",
								message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;<?=$lng['Data'].' '.$lng['exist already']?>',
								duration: 2,
							})

							$('#modalAddEmpcareer input[name="start_date_new"]').val('');
						}
					}
				})
			})

			$('#modalAddEmpcareer').modal('toggle');
		})

		$('.startPicker').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			inline: false,
			language: lang,
			todayHighlight: true,
			startDate: new Date(),
			orientation: "bottom left",
			
		}).on('changeDate', function(e){

			var dval = $('#modalAddEmpcareer input[name="start_date_new"]').val();
			$.ajax({
				url: "ajax/career_exist.php",
				type: 'POST',
				data: {dval:dval},
				success: function(result){

					if(result == 1){
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;<?=$lng['Data'].' '.$lng['exist already']?>',
							duration: 2,
						})

						$('#modalAddEmpcareer input[name="start_date_new"]').val('');

					}else{
						
						var changeFormat = e.format();
						var datearray = changeFormat.split("-");
						var newdatemdy = datearray[1] + '-' + datearray[0] + '-' + datearray[2];

						var days = 1;
						var newdate1 = new Date(newdatemdy);
						var deductDate = newdate1.setDate(newdate1.getDate() - days);
						var dd = new Date(deductDate);
						//var end_date = dd.getDate() + '-' + (dd.getMonth()+1) + '-' + dd.getFullYear();
						var end_date = ('0' + dd.getDate()).slice(-2) + '-' + ('0' + (dd.getMonth()+1)).slice(-2) + '-' + dd.getFullYear();

						var start_date_curr = $('#modalAddEmpcareer input[name="start_date_curr"]').val();
						if(start_date_curr != ''){
							$('#modalAddEmpcareer input[name="end_date_curr"]').val(end_date);
						}

					}
				}
			})
		})

		$('.datepick1').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			inline: false,
			language: lang,
			todayHighlight: true,
			startDate: new Date(),
			orientation: "bottom left",
			
		})


		$("#financialForm").on('submit', function(e){ // SUBMIT EMPLOYEE FORM ///////////////////////////////////
			e.preventDefault();
			var data = new FormData(this);


			// get values of additional compensation fields


			// var remainingGalaryVar = $('#remaining_salary').val();
			// var noticePaymentVar = $('#notice_payment').val();
			// var paidLeaveVar = $('#paid_leave').val();
			// var severanceVar = $('#severance').val();
			// var otherIncomeVar = $('#other_income').val();
			// var remarksVar = $('#remarks').val();


			// console.log(remainingGalaryVar);
			// console.log(noticePaymentVar);
			// console.log(paidLeaveVar);
			// console.log(severanceVar);
			// console.log(otherIncomeVar);
			// console.log(remarksVar);

			// return false;

			// show popup here for yes no and save value in hidden field 

			// when there is a value in additional compensation fields 
			$("body").overhang({
				type: "confirm",
				primary: "#228B22",
				//accent: "#27AE60",
				yesColor: "#3498DB",
				message: "Add additional compensations in career database?",
				overlay: true,
				callback: function (value) {


					if(value == true)
					{
						// set compensation data
						var addComp = 'yes';

					}
					else
					{
						// do not set compensation data 	
						var addComp = 'no';
					}

					data.append('addComp',addComp);
					if(addComp)
					{
						$.ajax({
							url: "ajax/update_employees.php",
							type: 'POST',
							data: data,
							async: false,
							cache: false,
							contentType: false,
							processData: false,
							success: function(result){
								//$('#dump').html(result); return false;
								$("#submitBtn").removeClass('flash');
								$("#sAlert").fadeOut(200);

								if($.trim(result) == 'success'){
									$("body").overhang({
										type: "success",
										message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
										duration: 2,
										callback: function(v){
											location.reload();
										}
									})
									if(!update){
										setTimeout(function(){location.reload();},1000);
									}
								}else{
									$("body").overhang({
										type: "error",
										message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+result,
										duration: 4,
									})
								}
								//setTimeout(function(){$("#submitBtn i").removeClass('fa-refresh fa-spin').addClass('fa-save');},500);
							},
							error:function (xhr, ajaxOptions, thrownError){
								$("body").overhang({
									type: "error",
									message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
									duration: 4,
								})
							}
						});
					}
				}
			});

			// when there is no value in additional compensation field donot show the popup 






			// return false;



		})

		var dayhours = 8;
		var workdays = 30;
		$(".calcRate, #base_salary").on('change', function(){
			var wage = parseFloat($('#base_salary').val());
			$.each(fix_allow, function(i, v){
				if(v.rate == 'Y'){
					wage += parseFloat($('input[name="fix_allow_'+i+'"]').val());
				}
			})
			if($('#contract_type').val() == 'day'){
				var day_rate = parseInt(wage);
				var hour_rate = (parseInt(wage) / parseInt(dayhours));
			}else{
				var day_rate = (parseInt(wage) / parseInt(workdays));
				var hour_rate = (parseInt(wage) / parseInt(workdays) / parseInt(dayhours));
			}
			$('input[name="day_rate"]').val(day_rate)
			$('input[name="hour_rate"]').val(hour_rate)
			$('#day_rate').val(parseFloat(day_rate).format(2))
			$('#hour_rate').val(parseFloat(hour_rate).format(2))
		})
		if($('input[name="day_rate"]').val() == 0){
			$(".calcRate").trigger('change');
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		}
	
		// DOCUMENTS ///////////////////////////////////////////////////////////////////////////////
		$("#att_bankbook").change(function(){
			readAttURL(this,'#bankbook_name');
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		});
		$("#att_contract").change(function(){
			readAttURL(this,'#contract_name');
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		});
		$("#attach5").change(function(){
			readAttURL(this,'#attach5_name');
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		});
		$("#attach6").change(function(){
			readAttURL(this,'#attach6_name');
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		});
		$("#attach7").change(function(){
			readAttURL(this,'#attach7_name');
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		});
		$("#attach8").change(function(){
			readAttURL(this,'#attach8_name');
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		});
		
		$('.delDoc').confirmation({
			container: 'body',
			rootSelector: '.delDoc',
			singleton: true,
			animated: 'fade',
			placement: 'left',
			popout: true,
			html: true,
			title: '<?=$lng['Are you sure']?>',
			btnOkClass: 'btn btn-danger',
			btnOkLabel: '<?=$lng['Delete']?>',
			btnCancelClass: 'btn btn-success',
			btnCancelLabel: '<?=$lng['Cancel']?>',
			onConfirm: function() { 
				$.ajax({
					url: "ajax/delete_document.php",
					data:{emp_id: emp_id, doc: $(this).data('id')},
					success: function(result){
						//$('#dump').html(result); return false;
						location.reload();
					}
				});
			}
		});
		
		
		
		
		
		$('input, textarea').on('keyup', function(e){
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		})
		$('input, select').on('change', function(e){
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		})



		// CAREER FORM ///////////////////////////////////////////////////////////////////////////////
		var caTable = $('#career_tabless').DataTable({
			scrollY: false,
			scrollX: false,
			lengthChange: false,
			searching: false,
			ordering: false,
			paging: false,
			filter: false,
			info: false,
			<?=$dtable_lang?>
			
		});


		$(document).on('click','#career_table tbody tr', function(){
			//var id = caTable.row(this).data()[4];
			$('select[name="position"] option').attr('selected',false)
			var id = $(this).data('id');

			$.ajax({
				url: "ajax/get_employee_benefit.php",
				type: "POST", 
				data: {id: id, field: 'career'},
				dataType: 'json',
				success: function(data){
					//$("#dump").html(data); //return false;

					//alert(data.salary);

					//$('#careerFormHis #caID').val(data.id);
					$('select[name="position"] option[value="'+data.position+'"]').attr('selected',true)
					$('input[name="month"]').val(data.month)
					$('input[name="department"]').val(data.department)
					$('input[name="start_date"]').val(data.start_date)
					$('input[name="end_date"]').val(data.end_date)
					$('input#salary').val(data.salary)
					$('textarea[name="benefits"]').val(data.benefits)
					$('textarea[name="other_benifits"]').val(data.other_benifits)
					$('textarea[name="classification"]').val(data.classification)
					$('textarea[name="remarks"]').val(data.remarks)
					$('#caAttach').empty();
					$.each(data.attachment, function(i,val){
						$('#caAttach').append(
							'<div class="attachDiv">'+
								'<a target="_blank" href="<?=ROOT.$cid?>/career/'+val+'"class="link">'+val+'</a>'+
							'</div>'
						)
					})					

					// $.each(data.attachment, function(i,val){
					// 	$('#caAttach').append(
					// 		'<div class="attachDiv">'+
					// 			'<a target="_blank" href="<?=ROOT.$cid?>/career/'+val+'"class="link">'+val+'</a>'+
					// 			'<a data-key="'+i+'" class="icon delAttach"><i class="fa fa-trash"></i></a>'+
					// 		'</div>'
					// 	)
					// })
					$("#caColor").css('background', 'rgba(200,255,200,0.1)');
					$("#careerTable").show();
					$("#caBtn").show();
					$("#caAction").html('- Edit');
					$('button#caBtn').attr('disabled',false);

					$('tr.fixAllclass').remove();
					$('tr.fixdedclass').remove();
					

					// check here which row is selected if it has end date then show the edit button for that row
					if(data.end_date != '')
					{
						$('button#editBtn').css('display','block');
					}
					else
					{
						$('button#editBtn').css('display','none');
					}




					$.each(data.fix_allows, function(i,val){
						if(val > 0){
							$('tr#fixallowsec').after(
								// '<tr class="fixAllclass" style="background: #ebfbea;"><th>'+incdedFix[i]+'</th><td>'+val+'</td></tr>'
								'<tr class="fixAllclass" ><th>'+incdedFix[i]+'</th><td>'+val+'</td></tr>'
							)
						}
					})

					$.each(data.fix_deducts, function(i,val){
						if(val > 0){
							$('tr#fixdeductsec').after(
								// '<tr class="fixdedclass" style="background: #ebfbea;"><th>'+incdedFix[i]+'</th><td>'+val+'</td></tr>'
								'<tr class="fixdedclass" ><th>'+incdedFix[i]+'</th><td>'+val+'</td></tr>'
							)
						}
					})

					autosize.destroy(document.querySelectorAll('textarea'));
					autosize(document.querySelectorAll('textarea'));
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		})

		$("#addCareer").on('click', function(e){
			$("#careerForm").trigger('reset');
			$('#caAttach').empty();
			$("#caID").val(0);
			$("#careerTable").show();
			$("#caBtn").show();
			$("#caAction").html('- New');
			$("#caColor").css('background', 'rgba(255,200,200,0.08)');
			$("table#career_table tr").removeClass("selected");
		})


		$('.sdatepick1').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			inline: false,
			language: lang,
			todayHighlight: true,
			endDate: new Date(),
			orientation: "bottom left",
			
		}).on('changeDate', function(e){

			var dval = $('#modalAddEmpcareer input[name="start_date"]').val();
			$.ajax({
				url: "ajax/career_exist.php",
				type: 'POST',
				data: {dval:dval},
				success: function(result){

					if(result == 1){
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;<?=$lng['Data'].' '.$lng['exist already']?>',
							duration: 2,
						})

						$('#modalAddEmpcareer input[name="start_date"]').val('');
					}
				}
			})
		})

		$('.edatepick1').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			inline: false,
			language: lang,
			todayHighlight: true,
			endDate: new Date(),
			orientation: "bottom left",
			
		})


		$(document).on('change', "#careerForm .attachBtn", function(e){
			readFileURL(this, '#attachCareer');
			$("#caBtn").addClass('flash');
			$('#sAlert').fadeIn(200);
		})
		$(document).on("click", "#careerForm .delAttach", function(e){
			var key = $(this).data('key')
			var app = $(this);
			$.ajax({
				url: "ajax/delete_benefit_attach.php",
				data: {id: $("#caID").val(), key: key, field: 'career'},
				success: function(result){
					//$('#dump').html(result);
					app.parent().remove();
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?>&nbsp;&nbsp;<b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		});
		$('#careerForm input, #careerForm textarea').on('keyup', function(e){
			$('#sAlert').fadeIn(200);
			$("#caBtn").addClass('flash');
		})
		$('#careerForm .datepick').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			inline: true,
			language: lang,//lang+'-th',
			todayHighlight: true,
		}).on('changeDate', function(ev){
			$('#sAlert').fadeIn(200);
			$("#caBtn").addClass('flash');
		});	



		
		
		var activeTabFin = localStorage.getItem('activeTabFin');
		if(activeTabFin){
		
			if(activeTabFin == '#tab_fin_benefits'){ 
				$('button#submitBtn').css('display','none');
			}else{

				if(activeTabFin == '#tab_his_career'){ 
					$('button#submitBtn').css('display','none');
					$('button#editBtn').css('display','none;');
				}
				else
				{
					$('button#submitBtn').css('display','block');
					$('button#editBtn').css('display','none');
				}

			}





			// for

			$('.nav-link[href="' + activeTabFin + '"]').tab('show');
		}else{
			$('.nav-link[href="#tab_fin_financial"]').tab('show');
		}
		$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
			//alert($(e.target).attr('href'));
			if($(e.target).attr('href') == '#tab_fin_benefits'){ 
				$('button#submitBtn').css('display','none');
			}else{

				if($(e.target).attr('href') == '#tab_his_career'){ 
					$('button#submitBtn').css('display','none');
					$('button#editBtn').css('display','none');

				}else{
					$('button#submitBtn').css('display','block');
					$('button#editBtn').css('display','none');

				}

			}			

			
			localStorage.setItem('activeTabFin', $(e.target).attr('href'));
		});

	})

	var currentTab = 0;
	showTab(currentTab);

	function showTab(n) {
	  var x = document.getElementsByClassName("tab"); 

	  console.log(x);
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
	    SaveNewUsersssForm();
	    return false;
	  }
	 showTab(currentTab);
	}


	function SaveNewUsersssForm(){

		/*var err = 0;		
		if($('#careerForm input[name="start_date_curr"]').val() == ""){err = 1}
		if(err){
			$("body").overhang({
				type: "error",
				message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Please fill in required fields']?>',
				duration: 2,
				callback: function(v){
					location.reload();
				}
			})
			return false;
		}*/

		// var frm = $('#careerForm');
		// var formData = frm.serialize();
		var formData = new FormData($('#modalAddEmpcareer #careerForm')[0]);

		$.ajax({
			url: "ajax/update_career.php",
			type: "POST", 
			data: formData,
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false,
			success: function(data){
				//$("#dump").html(data); return false;
				if(data.result == 'success'){
					$("body").overhang({
						type: "success",
						message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
						duration: 2,
						callback: function(v){
							window.location.reload();
						}
					})
					
				}else{
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+data.result,
						duration: 2,
						callback: function(v){
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
					callback: function(v){
						window.location.reload();
					}
				})
			}
		});

	}
		



// second edit benefit popup in career tab 


	$(document).ready(function() {
		
		var update2 = <?=json_encode($update)?>;
		var emp_id2 = <?=json_encode($_SESSION['rego']['empID'])?>;
		var fix_allow2 = <?=json_encode($fix_allow)?>;
		var incdedFix2 = <?=json_encode($fixalldedarr)?>;
		var ecdata2 = <?=json_encode($ecdata)?>;
		

		var dateParmeter2;
		if(ecdata2.length == 0){
			dateParmeter2 = '';
		}else{
			dateParmeter2 = 'new Date()';
		}

		$(document).on("click", "#editBtn", function(e){
			//alert(dateParmeter);
			$(".sdatepick12").datepicker("destroy");
			$('#modalAddEmpcareer2 input#sdates2').removeClass('sdatepick1').addClass('startPicker2');
			$('#modalAddEmpcareer2 input[name="end_date_new2"]').attr('readonly',true).removeClass('sdatepick12');

			$('.startPicker2').datepicker({
				format: "dd-mm-yyyy",
				autoclose: true,
				inline: false,
				language: lang,
				todayHighlight: true,
				startDate: dateParmeter2,
				orientation: "bottom left",
				
			}).on('changeDate', function(e){

				var dval = $('#modalAddEmpcareer2 input[name="start_date_new2"]').val();
				$.ajax({
					url: "ajax/career_exist.php",
					type: 'POST',
					data: {dval:dval},
					success: function(result){

						if(result == 1){
							$("body").overhang({
								type: "error",
								message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;<?=$lng['Data'].' '.$lng['exist already']?>',
								duration: 2,
							})

							$('#modalAddEmpcareer2 input[name="start_date_new2"]').val('');

						}else{
							
							var changeFormat2 = e.format();
							var datearray2 = changeFormat2.split("-");
							var newdatemdy2 = datearray2[1] + '-' + datearray2[0] + '-' + datearray2[2];

							var days2 = 1;
							var newdate12 = new Date(newdatemdy2);
							var deductDate2 = newdate12.setDate(newdate12.getDate() - days2);
							var dd2 = new Date(deductDate2);
							//var end_date = dd.getDate() + '-' + (dd.getMonth()+1) + '-' + dd.getFullYear();
							var end_date2 = ('0' + dd2.getDate()).slice(-2) + '-' + ('0' + (dd2.getMonth()+1)).slice(-2) + '-' + dd2.getFullYear();

							var start_date_curr2 = $('#modalAddEmpcareer2 input[name="start_date_curr2"]').val();
							if(start_date_curr2 != ''){
								$('#modalAddEmpcareer2 input[name="end_date_curr2"]').val(end_date2);
							}

						}
					}
				})
			})


			$('#modalAddEmpcareer2').modal('toggle');
		})


		$('.startPicker2').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			inline: false,
			language: lang,
			todayHighlight: true,
			startDate: new Date(),
			orientation: "bottom left",
			
		}).on('changeDate', function(e){

			var dval = $('#modalAddEmpcareer2 input[name="start_date_new2"]').val();
			$.ajax({
				url: "ajax/career_exist.php",
				type: 'POST',
				data: {dval:dval},
				success: function(result){

					if(result == 1){
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;<?=$lng['Data'].' '.$lng['exist already']?>',
							duration: 2,
						})

						$('#modalAddEmpcareer2 input[name="start_date_new2"]').val('');

					}else{
						
						var changeFormat2 = e.format();
						var datearray2 = changeFormat2.split("-");
						var newdatemdy2 = datearray2[1] + '-' + datearray2[0] + '-' + datearray2[2];

						var days2 = 1;
						var newdate12 = new Date(newdatemdy2);
						var deductDate2 = newdate12.setDate(newdate12.getDate() - days2);
						var dd2 = new Date(deductDate2);
						//var end_date = dd.getDate() + '-' + (dd.getMonth()+1) + '-' + dd.getFullYear();
						var end_date2 = ('0' + dd2.getDate()).slice(-2) + '-' + ('0' + (dd2.getMonth()+1)).slice(-2) + '-' + dd2.getFullYear();

						var start_date_curr2 = $('#modalAddEmpcareer2 input[name="start_date_curr2"]').val();
						if(start_date_curr2 != ''){
							$('#modalAddEmpcareer2 input[name="end_date_curr2"]').val(end_date2);
						}

					}
				}
			})
		})

		$('.datepick12').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			inline: false,
			language: lang,
			todayHighlight: true,
			startDate: new Date(),
			orientation: "bottom left",
			
		})


		$('.sdatepick12').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			inline: false,
			language: lang,
			todayHighlight: true,
			endDate: new Date(),
			orientation: "bottom left",
			
		}).on('changeDate', function(e){

			var dval = $('#modalAddEmpcareer2 input[name="start_date2"]').val();
			$.ajax({
				url: "ajax/career_exist.php",
				type: 'POST',
				data: {dval:dval},
				success: function(result){

					if(result == 1){
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;<?=$lng['Data'].' '.$lng['exist already']?>',
							duration: 2,
						})

						$('#modalAddEmpcareer2 input[name="start_date2"]').val('');
					}
				}
			})
		})

		$('.edatepick12').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			inline: false,
			language: lang,
			todayHighlight: true,
			endDate: new Date(),
			orientation: "bottom left",
			
		})




		$('#careerForm2 input, #careerForm2 textarea').on('keyup', function(e){
			$('#sAlert').fadeIn(200);
			$("#caBtn").addClass('flash');
		})
		$('#careerForm2 .datepick2').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			inline: true,
			language: lang,//lang+'-th',
			todayHighlight: true,
		}).on('changeDate', function(ev){
			$('#sAlert').fadeIn(200);
			$("#caBtn").addClass('flash');
		});	



		
		
		var activeTabFin2 = localStorage.getItem('activeTabFin2');
		if(activeTabFin2){
		
			if(activeTabFin2 == '#tab_fin_benefits'){ 
				$('button#submitBtn').css('display','none');
			}else{

				if(activeTabFin2 == '#tab_his_career'){ 
					$('button#submitBtn').css('display','none');
					$('button#editBtn').css('display','none');
				}
				else
				{
					$('button#submitBtn').css('display','block');
					$('button#editBtn').css('display','none');

				}

			}			


			$('.nav-link[href="' + activeTabFin2 + '"]').tab('show');
		}else{
			$('.nav-link[href="#tab_fin_financial"]').tab('show');
		}
		$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
			//alert($(e.target).attr('href'));
			if($(e.target).attr('href') == '#tab_fin_benefits'){ 
				$('button#submitBtn').css('display','none');
			}else{

				if($(e.target).attr('href') == '#tab_his_career'){ 
					$('button#submitBtn').css('display','none');
					$('button#editBtn').css('display','none');

				}else{
					$('button#submitBtn').css('display','block');
					$('button#editBtn').css('display','none');

				}

			}			

			
			localStorage.setItem('activeTabFin2', $(e.target).attr('href'));
		});

	})

	var currentTab2 = 0;
	showTab2(currentTab2);

	function showTab2(n) {
	  var x = document.getElementsByClassName("tab2"); 

	  console.log(x);
	  x[n].style.display = "block";
	
	  if (n == 0) {
	    document.getElementById("prevBtn2").style.display = "none";
	  } else {
	    document.getElementById("prevBtn2").style.display = "inline";
	  }
	  if (n == (x.length - 1)) {
	    document.getElementById("nextBtn2").innerHTML = "Submit";
	  } else {
	    document.getElementById("nextBtn2").innerHTML = "Next";
	  }
	}

	function nextPrev2(n) {
	  var x = document.getElementsByClassName("tab2");
	  x[currentTab2].style.display = "none";
	  currentTab2 = currentTab2 + n;
	  if (currentTab2 >= x.length) {
	    SaveNewUsersssForm2();
	    return false;
	  }
	 showTab2(currentTab2);
	}



	function SaveNewUsersssForm2(){

		var formData2 = new FormData($('#modalAddEmpcareer2 #careerForm2')[0]);

		$.ajax({
			url: "ajax/update_career_tab.php",
			type: "POST", 
			data: formData2,
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false,
			success: function(data){
				//$("#dump").html(data); return false;
				if(data.result == 'success'){
					$("body").overhang({
						type: "success",
						message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
						duration: 2,
						callback: function(v){
							window.location.reload();
						}
					})
					
				}else{
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+data.result,
						duration: 2,
						callback: function(v){
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
					callback: function(v){
						window.location.reload();
					}
				})
			}
		});

	}


	// CODE TO DISABLE DROPDOWN DROP MENU 
	$('.disabledropdown').on('mousedown', function(e) {
	   e.preventDefault();
	   this.blur();
	   window.focus();
	});

	// =============================REMOVE MONTHS FROM PAYROLL MONTHS ACCORDING TO END DATE ON CHANGE ==================================//

		$(document).on("change", "#resign_dateValue", function(e){
			var monthsValue = <?=json_encode($months)?>;
			// empty all the months
			$('#month_payroll').empty();
			// add please select option
			$('#month_payroll')
			         .append($("<option></option>")
			                    .attr("value", 0)
			                    .text('Please select')); 

			// add all the options 
			$.each(monthsValue, function(key, value) {   
			     $('#month_payroll')
			         .append($("<option></option>")
			                    .attr("value", key)
			                    .text(value)); 
			});


			// remove the all options from  payroll months dropdown everytime a change is made in the end date of the employee
			var resignDateValue = $('#resign_dateValue').val();
			if(resignDateValue)
			{
				var from = resignDateValue.split("-");
				var withoutLeadingZero  = from[1].replace(/^0+/, '');
				// now we have the last month need to remove the rest of the months  
				var plusOneInMonth =  parseInt(withoutLeadingZero) + 1;
				for (var i = plusOneInMonth; i <= 12; i++) {
					 // remove these from payroll months array
					$("#month_payroll option[value='"+i+"']").remove();
				}
			}
		});	


		$( document ).ready(function() {
			// run the code when page loads and do the same for payroll months which we do on change of resign date 
			var monthsValue = <?=json_encode($months)?>;
			// empty all the months
			$('#month_payroll').empty();
			// add please select option
			$('#month_payroll')
			         .append($("<option></option>")
			                    .attr("value", 0)
			                    .text('Please select')); 

			// add all the options 
			$.each(monthsValue, function(key, value) {   
			     $('#month_payroll')
			         .append($("<option></option>")
			                    .attr("value", key)
			                    .text(value)); 
			});

			// remove the all options from  payroll months dropdown everytime a change is made in the end date of the employee
			var resignDateValue = $('#resign_dateValue').val();
			if(resignDateValue)
			{
				var from = resignDateValue.split("-");
				var withoutLeadingZero  = from[1].replace(/^0+/, '');
				// now we have the last month need to remove the rest of the months  
				var plusOneInMonth =  parseInt(withoutLeadingZero) + 1;
				for (var i = plusOneInMonth; i <= 12; i++) {
					 // remove these from payroll months array
					$("#month_payroll option[value='"+i+"']").remove();
				}
			}

		});



	// =============================REMOVE MONTHS FROM PAYROLL MONTHS ACCORDING TO END DATE  ON CHANGE==================================//
	</script>
	

















