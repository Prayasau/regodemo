<?
	$disabled = '';
	$readonly = 'readonly';
	$nofocus = 'nofocus';
	//if($_SESSION['RGadmin']['access']['settings']['payroll'] == 0){$disabled = 'disabled';}
	//var_dump(unserialize('a:2:{s:2:"en";a:3:{s:2:"NP";s:11:"no Position";s:3:"DES";s:8:"Designer";s:3:"DEV";s:10:"Develloper";}s:2:"th";a:3:{s:2:"NP";s:36:"ไม่มีตำแหน่ง";s:3:"DES";s:9:"-Designer";s:3:"DEV";s:11:"-Develloper";}}'));
	$daysCalc = cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));

	$sql1 = "SELECT * FROM rego_default_shiftplans ";
	if($res1 = $dba->query($sql1)){
			while($row1 = $res1->fetch_assoc()){
				

				$shiftplandata[] = $row1;

		}
	}

	$varAllowDeduct = array();
	$sqlv = "SELECT * FROM rego_allow_deduct WHERE apply = '1' AND man_att='1'";
	if($resv = $dba->query($sqlv)){
		while($rowv = $resv->fetch_assoc()){
			$varAllowDeduct[] = $rowv;
		}
	}

	$data_income = array();
	$sqldi = "SELECT * FROM rego_allow_deduct WHERE apply = '1' AND hour_daily_rate='1'";
	if($resdi = $dba->query($sqldi)){
		while($rowdi = $resdi->fetch_assoc()){
			$data_income[] = $rowdi;
		}
	}

	$settings = array();
	if($res = $dba->query("SELECT * FROM rego_default_settings")){
		$settings = $res->fetch_assoc();
		$prefixValue =  unserialize($settings['id_prefix']);

		$periods_defaults =  unserialize($settings['periods_defaults']);
		$manualrates_default =  unserialize($settings['manualrates_default']);
		$tab_default = unserialize($settings['tab_default']);
	}
	//var_dump($settings); exit;
	$sso_defaults =  unserialize($settings['sso_defaults']);
	
	$fix_allow = unserialize($settings['fix_allow']);
	$var_allow = unserialize($settings['var_allow']);
	if(empty($fix_allow)){$fix_allow = array();}
	if(empty($var_allow)){$var_allow = array();}
	//var_dump($fix_allow);
	//var_dump($var_allow);
	
	$fix_deduct = unserialize($settings['fix_deduct']);
	$var_deduct = unserialize($settings['var_deduct']);

	$taxrules = unserialize($settings['taxrules']);
	//var_dump($taxrules);
	$tax_settings_description = unserialize(str_replace('\"', '"', $settings['tax_settings_description']));

	$tax_settings = unserialize(str_replace('\"', '"', $settings['tax_settings']));
	$tax_info = unserialize(str_replace('\"', '"', $settings['tax_info_'.$lang]));
	$tax_err = unserialize(str_replace('\"', '"', $settings['tax_err_'.$lang]));
	$unitArr = array(1=>'Num',2=>'THB');

	$tax_calc_on = unserialize($settings['tax_calc_on']);
	$tax_thb = unserialize($settings['tax_thb']);
	$tax_unit = unserialize($settings['tax_unit']);
	$tax_number = unserialize($settings['tax_number']);

	//var_dump($tax_settings);
	$tax_info_th = unserialize(str_replace('\"', '"', $settings['tax_info_th']));
	//var_dump($tax_info_th);
	$tax_info_en = unserialize(str_replace('\"', '"', $settings['tax_info_en']));
	//var_dump($tax_info_en);
	$tax_err_th = unserialize(str_replace('\"', '"', $settings['tax_err_th']));
	//var_dump($tax_err_th);
	$tax_err_en = unserialize(str_replace('\"', '"', $settings['tax_err_en']));
	//var_dump($tax_err_en);
	$payslip = unserialize($settings['payslip_field']);
	//var_dump($payslip);
	
	$positions = unserialize($settings['positions']);
	if($positions){
		$pos_count = count($positions['th']);
	}else{
		$pos_count = 0;
	}
	//unset($positions['en'][2]);
	//unset($positions['th'][2]);
	//var_dump($positions); exit;


	$workingdays = 5;
	/*$res = $dba->query("SELECT * FROM rego_default_leave_time_settings");
	if(mysqli_error($dba)){ echo 'Error : '.mysqli_error($dba);}else{
		if($row = $res->fetch_assoc()){
			$workingdays = $row['workingdays'];
		}
	}*/

	$holidays = array();
	$res = $dba->query("SELECT * FROM rego_default_holidays WHERE apply='1' AND year = '".$_SESSION['RGadmin']['cur_year']."'");
	while($row = $res->fetch_assoc()){
		$holidays[] = $row;
	}

	function xdate_range($first, $last, $step = '+1 day', $output_format = 'd-m-Y' ) {
		$dates = array();
		$current = strtotime($first);
		$last = strtotime($last);
		while( $current <= $last ) {
			$dates[$current]['tts'] = $current;
			$dates[$current]['date'] = date($output_format, $current);
			$dates[$current]['m'] = date('m', $current);
			$dates[$current]['d'] = date('w', $current);
			$current = strtotime($step, $current);
		}
		return $dates;
	}
	
	$days = xdate_range('01-01-'.$_SESSION['RGadmin']['cur_year'],'31-12-'.$_SESSION['RGadmin']['cur_year']);
	for($i=1;$i<=12;$i++){
		$nw[$i]=0;
		$wd[$i]=0;
		$hd[$i]=0;
	}

	foreach($holidays as $k=>$v){
		if($workingdays == 6){
			$weekdays = date('N', strtotime($v['cdate']));
			if($weekdays == 7){

			}else{
				$hd[date('n', strtotime($v['cdate']))]++;
			}
		}else{
			$weekdays = date('N', strtotime($v['cdate']));
			if($weekdays >= 6){

			}else{
				$hd[date('n', strtotime($v['cdate']))]++;
			}
		}
	}

	foreach($days as $k=>$v){
		if($workingdays == 6){
			if($v['d']==0){
				$nw[(int)$v['m']]++;
			}else{
				$wd[(int)$v['m']]++;
			}
		}else{
			if($v['d']==6 || $v['d']==0){
				$nw[(int)$v['m']]++;
			}else{
				$wd[(int)$v['m']]++;
			}
		}
	}

	foreach($nw as $k=>$v){
		//$nw[$k] += $hd[$k];
		$wd[$k] -= $hd[$k];
	}

	//echo '<pre>';
	//print_r($settings);
	// print_r($tax_info);
	// print_r($tax_err);
	//echo '</pre>';

	// die();
?>
 
<style>
	*:disabled {
		cursor:default !important;
	}
	table.basicTable td.info {
		color: #006699;
		font-style:italic;
	}

	#tab_taxsettings .descri_info{
		width: 100%;
	    text-align: right;
	    border: none;
	    color: #005588;
	    /* font-weight: bold; */
	    font-weight: 600;
	    padding: 0px;
	}

	#tab_manualrate .inptbkg{
		background: #f9f7dd !important;
	}

	#tab_manualrate .SumoSelect {
	    padding: 5px 5px 5px 10px !important;
	    border: none !important;
	    width: 100% !important;
	}

	#tab_taxsettings table.basicTable.lefttbl tbody td{
		padding: 0px;
	}

	#tab_taxsettings .basicTable tbody td.info span{
		color: #8b8b8d;
	}

	#tab_taxsettings table td input, #tab_taxsettings table td select{
		background: #f9f9d1;
	}
</style>
	
	
	<h2><i class="fa fa-cogs"></i>&nbsp;&nbsp;<?=$lng['Default payroll settings']?> <span style="float:right; display:none; font-style:italic; color:#b00" id="sAlert"><?=$lng['Data is not updated to last changes made']?></span></h2>
	
	<div class="main">
		<div style="padding:0 0 0 20px" id="dump"></div>
		
		<form id="payrollForm" style="height:100%">
	
			<ul class="nav nav-tabs" id="myTab">
				<li class="nav-item"><a class="nav-link" data-target="#tab_settings" data-toggle="tab"><?=$lng['Settings']?></a></li>
				<!--<li class="nav-item"><a class="nav-link" data-target="#tab_positions" data-toggle="tab"><?=$lng['Positions']?></a></li>-->
				<li class="nav-item"><a class="nav-link" data-target="#tab_periods" data-toggle="tab"><?=$lng['Periods']?></a></li>
				<!-- <li class="nav-item"><a class="nav-link" data-target="#tab_defaults" data-toggle="tab"><?=$lng['Employee defaults']?></a></li> -->
				<!-- <li class="nav-item"><a class="nav-link" data-target="#tab_allowances" data-toggle="tab"><?=$lng['Allowances']?></a></li> -->
				<li class="nav-item"><a class="nav-link" data-target="#tab_sso" data-toggle="tab"><?=$lng['SSO / PND']?></a></li>
				<!-- <li class="nav-item"><a class="nav-link" data-target="#tab_deductions" data-toggle="tab"><?=$lng['Deductions']?></a></li> -->
				<li class="nav-item"><a class="nav-link" data-target="#tab_taxsettings" data-toggle="tab"><?=$lng['Tax Settings']?></a></li>
				<li class="nav-item"><a class="nav-link" data-target="#tab_taxrules" data-toggle="tab"><?=$lng['Tax rules']?></a></li>
				<li class="nav-item"><a class="nav-link" data-target="#tab_manualrate" data-toggle="tab"><?=$lng['Manual Rates']?></a></li>

				<button class="btn btn-default ml-1" type="button" onclick="window.location.href='index.php?mn=701'" style="
				color: #575;font-weight: 600 !important;padding: 8px 12px; border: 1px solid #fff;"><?=$lng['Allowances & Deductions']?></button>

				<button class="btn btn-default ml-1" type="button" onclick="window.location.href='index.php?mn=702'" style="
				color: #575;font-weight: 600 !important;padding: 8px 12px; border: 1px solid #fff;"><?=$lng['Rewards & Penalties']?></button>
			</ul>
		
				<button class="btn btn-primary" style="margin:0; position:absolute; top:15px; right:16px;" id="submitbtn" type="submit"><i class="fa fa-save"></i>&nbsp;&nbsp;<?=$lng['Update']?></button>
	
			<div class="tab-content" style="height:calc(100% - 40px)">
				
				<div class="tab-pane" id="tab_settings">
					<table class="basicTable inputs" border="0">
						<tbody>
							<!--<tr>
								<th><i class="man"></i> <?=$lng['Working days a month']?></th>
								<td><b><input name="days_month" id="days_month" type="text" value="<?=$settings['days_month']?>" /></b></td>
							</tr>
							<tr style="border-bottom:1px solid #ccc">
								<th><i class="man"></i> <?=$lng['Working hours a day']?></th>
								<td><b><input name="hours_day" id="hours_day" type="text" value="<?=$settings['hours_day']?>" /></b></td>
							</tr>
							<tr>
								<th><i class="man"></i><?=$lng['SSO rate employee']?> (%)</th>
								<td><input class="sel numeric" name="sso_rate_emp" type="text" value="<?=$settings['sso_rate_emp']?>" /></td>
							</tr>
							<tr>
								<th><i class="man"></i><?=$lng['Min. SSO employee']?> (<?=$lng['Baht']?>)</th>
								<td><input class="sel numeric" name="sso_min_emp" type="text" value="<?=$settings['sso_min_emp']?>" /></td>
							</tr>
							<tr style="border-bottom:1px solid #ccc">
								<th><i class="man"></i><?=$lng['Max. SSO employee']?> (<?=$lng['Baht']?>)</th>
								<td><input style="width:60px" class="sel numeric" name="sso_max_emp" type="text" value="<?=$settings['sso_max_emp']?>" /></td>
							</tr>
							
							<tr>
								<th><i class="man"></i><?=$lng['SSO rate company']?> (%)</th>
								<td><input class="sel numeric" name="sso_rate_com" type="text" value="<?=$settings['sso_rate_com']?>" /></td>
							</tr>
							<tr>
								<th><i class="man"></i><?=$lng['Min. SSO company']?> (<?=$lng['Baht']?>)</th>
								<td><input class="sel numeric" name="sso_min_com" type="text" value="<?=$settings['sso_min_com']?>" /></td>
							</tr>
							<tr style="border-bottom:1px solid #ccc">
								<th><i class="man"></i><?=$lng['Max. SSO company']?> (<?=$lng['Baht']?>)</th>
								<td><input style="width:60px" class="sel numeric" name="sso_max_com" type="text" value="<?=$settings['sso_max_com']?>" /></td>
							</tr>
							<tr>
								<th><i class="man"></i><?=$lng['Minimum wages']?> (<?=$lng['Baht']?>)</th>
								<td><input class="sel numeric" name="sso_min_wage" type="text" value="<?=$settings['sso_min_wage']?>" /></td>
							</tr>
							<tr>
								<th><i class="man"></i><?=$lng['Maximum wages']?> (<?=$lng['Baht']?>)</th>
								<td><input class="sel numeric" name="sso_max_wage" type="text" value="<?=$settings['sso_max_wage']?>" /></td>
							</tr>
							<tr style="border-bottom:1px solid #ccc">
								<th><i class="man"></i><?=$lng['SSO amount']?></th>
								<td>
									<select name="sso_act_max" style="width:100%">
										<option <? if($settings['sso_act_max'] == 'act'){echo 'selected';}?> value="act"><?=$lng['Actual amount']?></option>
										<option <? if($settings['sso_act_max'] == 'max'){echo 'selected';}?> value="max"><?=$lng['Max']?> <?=number_format(15000)?> <?=$lng['Baht']?></option>
									</select>
								</td>
							</tr>-->
							
							<tr>
								<th><i class="man"></i><?=$lng['Payslip template']?></th>
								<td style="padding-top:2px;padding-right:10px">
									<select name="payslip_template" id="pslip_template" style="width:100%">
										<!--<option disabled selected value=""><?=$lng['Select']?></option>-->
										<option <? if($settings['payslip_template'] == 'la4'){echo "selected ";} ?>value="la4"><?=$lng['Laser A4 template']?></option>
										<option <? if($settings['payslip_template'] == 'tme'){echo "selected ";} ?>value="tme"><?=$lng['Thai matrix template (A5 Empty)']?></option>
										<option <? if($settings['payslip_template'] == 'tmp'){echo "selected ";} ?>value="tmp"><?=$lng['Thai matrix template (A5 Preprinted)']?></option>
									</select>
								</td>
							</tr>
							<tr>
								<th style="width:5px"><?=$lng['Payslip fields']?> :</th>
								<td class="pad410">
									<label><input <? if(isset($payslip['ytd1'])){echo 'checked';} ?> name="payslip_field[ytd1]" type="checkbox" value="1" class="checkbox style-0" /><span><?=$lng['YTD. Income']?></span></label>&nbsp;&nbsp;&nbsp;&nbsp;
									<label><input <? if(isset($payslip['ytd2'])){echo 'checked';} ?> name="payslip_field[ytd2]" type="checkbox" value="1" class="checkbox style-0" /><span><?=$lng['YTD. Tax']?></span></label>&nbsp;&nbsp;&nbsp;&nbsp;
									<label><input <? if(isset($payslip['ytd3'])){echo 'checked';} ?> name="payslip_field[ytd3]" type="checkbox" value="1" class="checkbox style-0" /><span><?=$lng['YTD. Prov. Fund']?></span></label>&nbsp;&nbsp;&nbsp;&nbsp;
									<label><input <? if(isset($payslip['ytd4'])){echo 'checked';} ?> name="payslip_field[ytd4]" type="checkbox" value="1" class="checkbox style-0" /><span><?=$lng['YTD. Social SF']?></span></label>&nbsp;&nbsp;&nbsp;&nbsp;
									<label><input <? if(isset($payslip['ytd5'])){echo 'checked';} ?> name="payslip_field[ytd5]" type="checkbox" value="1" class="checkbox style-0" /><span><?=$lng['YTD. Other allowance']?></span></label>
								</td>
							</tr>
							<tr>
								<th><?=$lng['Payslip rate']?> : </th>
								<td style="padding-top:2px;padding-right:10px;">
									<select name="payslip_rate" id="pslip_rate" style="width:100%">
										<!--<option disabled selected value=""><?=$lng['Select']?></option>-->
										<option <? if($settings['payslip_rate'] == 'em'){echo "selected ";} ?>value="em"><?=$lng['Empty']?></option>
										<option <? if($settings['payslip_rate'] == 'dr'){echo "selected ";} ?>value="dr"><?=$lng['Day rate']?></option>
										<option <? if($settings['payslip_rate'] == 'hr'){echo "selected ";} ?>value="hr"><?=$lng['Hour rate']?></option>
									</select>
								</td>
							</tr>
							<!--<tr>
								<th><i class="man"></i><?=$lng['Support email']?></th>
								<td>
									<input placeholder="__" type="text" name="support_email" id="support_email" value="<?=$settings['support_email']?>" />
								</td>
							</tr>-->
						</tbody>
					</table>
				</div>
			
				<!---<div class="tab-pane" id="tab_positions" style="height:100%">
					<div style="height:100%; overflow-y:auto">
					<table class="basicTable inputs" id="position_table" border="0">
						<thead>
							<tr>
								<th style="width:1px">#</th>
								<th style="width:25%"><?=$lng['Thai description']?></th>
								<th style="width:25%"><?=$lng['English description']?></th>
								<th style="width:50%"></th>
							</tr>
						</thead>
						<tbody>
						<? if($positions){ foreach($positions['th'] as $k=>$v){ ?>
							<tr>
								<td><b><input readonly name="positions[<?=$k?>][code]" type="text" value="<?=$k?>" /></b></td>
								<td><input name="positions[<?=$k?>][th]" type="text" value="<?=$v?>" /></td>
								<td><input name="positions[<?=$k?>][en]" type="text" value="<?=$positions['en'][$k]?>" /></td>
								<td></td>
							</tr>
						<? } } ?>
						</tbody>
					</table>
					<div style="height:10px"></div>
					<button class="btn btn-primary btn-xs" type="button" id="addposition"><i class="fa fa-plus"></i>&nbsp;&nbsp;<?=$lng['Add row']?></button>
					</div>
				</div>--->
		
				<div class="tab-pane" id="tab_manualrate">

					<div class="row">
						<div class="col-md-12">
							<table class="basicTable inputs" border="0">
								<thead>
									<tr>
										<th class="tal" colspan="2"><?=$lng['Payroll'].' '.$lng['Default settings']?></th>
									</tr>
								</thead>
								<tbody>
									<!-- <tr>
										<th class="tal"><?=$lng['Multiplicator']?></th>
										<td>
											<input type="text" name="tab_default[multiplicator]" value="<?= isset($tab_default['multiplicator']) ? $tab_default['multiplicator'] : '';?>">
										</td>
									</tr> -->
									<tr>
										<th class="tal"><?=$lng['Paid days']?></th>
										<td>
											<select name="tab_default[paid_days]" style="width: 100%;">
												<?foreach($paiddaycalc as $k => $v){?>
													<option value="<?=$k?>" <?if($k == $tab_default['paid_days']){echo 'selected';}?>><?=$v?></option>
												<? } ?>
											</select>
										</td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Nr of hrs']?></th>
										<td>
											<input type="text" class="hourFormat" name="tab_default[nrhrs]" value="<?= isset($tab_default['nrhrs']) ? $tab_default['nrhrs'] : '';?>">
										</td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Income base']?></th>
										<td>
											<select id="defincombase" multiple="multiple" name="tab_default[income_base]" style="width:auto; min-width:100%;">
												<? foreach($data_income as $k=>$v){ 
													$k = $v['id']; $v = $v[$lang]; 
													if($k == 56){$sel='selected';}else{$sel='';}?>
														<option value="<?=$k?>" 
														<? if(isset($tab_default['income_base'])){
															$explodeib = explode(',', $tab_default['income_base']);
															if(in_array($k, $explodeib)){
																echo 'selected';
															}
															}else{ echo $sel;}?>><?=$v?>		
														</option>
													<? } ?>
											</select>
										</td>
									</tr>
									<!-- <tr>
										<th class="tal"><?=$lng['THB'].'/'.$lng['Unit']?></th>
										<td>
											<input type="text" name="tab_default[thb]" value="<?= isset($tab_default['thb']) ? $tab_default['thb'] : '';?>">
										</td>
									</tr> -->
									<!-- <tr>
										<th class="tal"><?=$lng['Unit']?></th>
										<td>
											<select name="tab_default[unit]" style="width: 100%;">
												<?foreach($unitopt as $k => $v){
													if($k == 3){$sel='selected';}else{$sel=''; }?>
													<option value="<?=$k?>" <?if($k == $tab_default['unit']){echo 'selected';}else{ echo $sel;}?> ><?=$v?></option>
												<? } ?>
											</select>
										</td>
									</tr> -->
								</tbody>
							</table>
						</div>
					</div>

					<div class="row mt-2">
						<div class="col-md-12 table-responsive">
							<table class="basicTable inputs" border="0">
								<thead>
									<tr>
										<th colspan="4"><?=$lng['Variable Allowances & Deductions Attendance']?></th>
										<th colspan="5" class="tal"><?=$lng['Calculation formula Hourly rate']?></th>
										<th colspan="2" class="tac"><?=$lng['Times']?></th>
										<th style="width:30%">&nbsp;</th>
									</tr>
								</thead>
								<thead>
									<th><?=$lng['Allowances'];?></th>
									<th class="tac"><?=$lng['Hrs'];?></th>
									<th class="tac"><?=$lng['Times'];?></th>
									<th class="tac"><?=$lng['THB'];?></th>
									<th class="tac"><?=$lng['Multiplicator'];?></th>
									<th class="tac"><?=$lng['Paid days'];?></th>
									<th><?=$lng['Nr of days']?></th>
									<th><?=$lng['Nr of hrs']?></th>
									<th><?=$lng['Income base']?></th>
									<th><?=$lng['THB'].'/'.$lng['Unit']?></th>
									<th><?=$lng['Unit']?></th>
									<th></th>
								</thead>
								<tbody>

									<? if(isset($varAllowDeduct) && is_array($varAllowDeduct)){ 
										foreach($varAllowDeduct as $row){ ?>
									
											<tr>
												<td><span class="pl-2"><?=$row[$lang]?></span></td>
												
												<td>
														<input type="hidden" name="manualrate[itemid][<?=$row['id']?>]" value="<?=$row['id']?>">
													<?php
														$hrs = $times = $thb = '';
														$exallowopt = $manualrates_default['allowopt'][$row['id']];
														if(in_array('hrs', $exallowopt)){
															$hrs = 'checked="checked"';
														}
														if(in_array('times', $exallowopt)){
															$times = 'checked="checked"';
														}
														if(in_array('thb', $exallowopt)){
															$thb = 'checked="checked"';
														}
													?>
													<script type="text/javascript">
														$(document).ready(function(){
															setTimeout( function(){ 
																//calcoptsel(<?=$manualrates_default['calcOpt'][$row['id']]?>,<?=$row['id']?>);
																//hrsOption(this,<?=$row['id']?>);
																//timesOption(this,<?=$row['id']?>);
																thbOption(this,<?=$row['id']?>);
															}, 1000);
														})
													</script>
													
													<input  class="checkbox-custom-blue" type="checkbox" onclick="hrsOption(this,<?=$row['id']?>)" id="hrs<?=$row['id']?>" name="manualrate[allowopt][<?=$row['id']?>][]" value="hrs" <?=$hrs?> style="text-align: center;">
												</td>
												<td>
													<input class="checkbox-custom-blue" type="checkbox" onclick="timesOption(this,<?=$row['id']?>)" id="times<?=$row['id']?>" name="manualrate[allowopt][<?=$row['id']?>][]" value="times" <?=$times?> style="text-align: center;">
												</td>
												<td>
													<input class="checkbox-custom-blue" type="checkbox" onclick="thbOption(this,<?=$row['id']?>)" id="thb<?=$row['id']?>" name="manualrate[allowopt][<?=$row['id']?>][]" value="thb" <?=$thb?> style="text-align: center;">
												</td>
												<td>
													<input type="text" class="numeric" name="manualrate[multiplicator][<?=$row['id']?>]" id="multiplicator<?=$row['id']?>" value="<?=isset($manualrates_default['multiplicator'][$row['id']]) ? $manualrates_default['multiplicator'][$row['id']] : '';?>" >
												</td>
												<td>
													<select name="manualrate[calcOpt][<?=$row['id']?>]" id="calcOpt<?=$row['id']?>" onchange="calcoptsel(this.value,<?=$row['id']?>)">
														<?foreach($paiddaycalc as $k => $v){?>
															<option value="<?=$k?>" <?if($k == $manualrates_default['calcOpt'][$row['id']]){echo 'selected';}?>><?=$v?></option>
														<? } ?>
													</select>
												</td>
												
												<td>
													<input type="text" class="numeric" name="manualrate[nrdays][<?=$row['id']?>]" id="nrdays<?=$row['id']?>" value="<?=isset($manualrates_default['nrdays'][$row['id']]) ? $manualrates_default['nrdays'][$row['id']] : '';?>" >
												</td>
												<td>
													<input type="text" class="sel hourFormat" name="manualrate[nrhrs][<?=$row['id']?>]" id="nrhrs<?=$row['id']?>" value="<?=isset($manualrates_default['nrhrs'][$row['id']]) ? $manualrates_default['nrhrs'][$row['id']] : '';?>" >
												</td>
												<td>
											
													<select id="incomeBase<?=$row['id']?>" multiple="multiple" name="manualrate[income_base][<?=$row['id']?>]" style="width:auto; min-width:100%;">	
														<? 
														$defincome_base = explode(',', $manualrates_default['income_base'][$row['id']]);
														foreach($data_income as $k=>$v){ ?>
															<option value="<?=$v['id']?>" <?if(in_array($v['id'], $defincome_base)){echo 'selected';} ?>><?=$v[$lang]?></option>
														<? } ?>
													</select>
												</td>
												<td>
													<input type="text" class="numeric" name="manualrate[thbunit][<?=$row['id']?>]" id="thbunit<?=$row['id']?>" value="<?=isset($manualrates_default['thbunit'][$row['id']]) ? $manualrates_default['thbunit'][$row['id']] : '';?>" >
												</td>
												<td>
													<select name="manualrate[unitarr][<?=$row['id']?>]" id="unitarr<?=$row['id']?>">
														<?foreach($unitopt as $k => $v){ ?>
															<option value="<?=$k?>" <?if($k == $manualrates_default['unitarr'][$row['id']]){echo 'selected';}?>><?=$v?></option>
														<? } ?>
													</select>
												</td>
												<td></td>
											</tr>
									<? } }  ?>
									
								</tbody>
							</table>
						</div>
					</div>

				</div>

				<div class="tab-pane" id="tab_periods">
					<table class="basicTable compact inputs" id="period_table" border="0">
						<thead>
							<tr>
								<th></th>
								<th colspan="2" class="tac"><?=$lng['Salary']?> & <?=$lng['Fixed income']?></th>
								<th colspan="2" class="tac"><?=$lng['Time']?></th>
								<th colspan="2" class="tac"><?=$lng['Leave']?></th>
								<th colspan="2" class="tac"><?=$lng['Payroll']?></th>
								<th colspan="3" class="tac"></th>
								<th style="width:10%">&nbsp;</th>
							</tr>
							<tr>
								<th class="tac"><?=$lng['Month']?></th>
								<th class="tac"><?=$lng['Start']?></th>
								<th class="tac"><?=$lng['Ends']?></th>
								<th class="tac"><?=$lng['Start']?></th>
								<th class="tac"><?=$lng['Ends']?></th>
								<th class="tac"><?=$lng['Start']?></th>
								<th class="tac"><?=$lng['Ends']?></th>
								<th class="tac"><?=$lng['Paydate']?></th>
								<th class="tac"><i class="fa fa-unlock fa-lg"></i></th>
								<th class="tac">Base=30</th>
								<th class="tac">Calender<br>Days</th>
								<th class="tac">Working<br>Days</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<? 
							for($i=1;$i<=12;$i++){
								$year = date('Y');
								$last = date('t', strtotime($year.'-'.sprintf('%02d', $i).'-01'));
								$date = $last.'-'.sprintf('%02d', $i).'-'.$year;
								$start = '26-'.sprintf('%02d', ($i-1)).'-'.$year;
								$end = '25-'.sprintf('%02d', $i).'-'.$year;
								$sstart = '01-'.sprintf('%02d', $i).'-'.$year;
								$send = $date;
								if($i == 1){$start = '26-12-'.($year-1);}

								$k = $i;
								$id = $year.'_'.$k;

								$daysCalc = cal_days_in_month(CAL_GREGORIAN,$k,$year);


								?>

								<tr>
									<td style="padding:4px 10px !important"><b><?=$months[$k]?></b></td>
									<td>
										<input class="tar xdatepick sstart<?=$k?>" name="periods[sal_start][<?=$id?>]" type="text" value="<?=isset($periods_defaults['sal_start'][$id]) ? $periods_defaults['sal_start'][$id] : $sstart?>" />
									</td>
									<td>
										<input data-m="<?=$k?>" class="tar xdatepick send" name="periods[sal_end][<?=$id?>]" type="text" value="<?=isset($periods_defaults['sal_end'][$id]) ? $periods_defaults['sal_end'][$id] : $send?>" />
									</td>
									<td>
										<input class="tar xdatepick tstart<?=$k?>" name="periods[time_start][<?=$id?>]" type="text" value="<?=isset($periods_defaults['time_start'][$id]) ? $periods_defaults['time_start'][$id] : $start?>" />
									</td>
									<td>
										<input data-m="<?=$k?>" class="tar xdatepick tend" name="periods[time_end][<?=$id?>]" type="text" value="<?=isset($periods_defaults['time_end'][$id]) ? $periods_defaults['time_end'][$id] : $end?>" />
									</td>
									<td>
										<input class="tar xdatepick lstart<?=$k?>" name="periods[leave_start][<?=$id?>]" type="text" value="<?=isset($periods_defaults['leave_start'][$id]) ? $periods_defaults['leave_start'][$id] : $start?>" />
									</td>
									<td>
										<input data-m="<?=$k?>" class="tar xdatepick lend" name="periods[leave_end][<?=$id?>]" type="text" value="<?=isset($periods_defaults['leave_end'][$id]) ? $periods_defaults['leave_end'][$id] : $end?>" />
									</td>
									<td>
										<input class="tar xdatepick" name="periods[paydate][<?=$id?>]" type="text" value="<?=isset($periods_defaults['paydate'][$id]) ? $periods_defaults['paydate'][$id] : $date?>" />
									</td>
									<td style="padding:0 10px !important" class="tac">
										<a href="#"><i class="fa fa-unlock fa-lg"></i></a>
									</td>

									<td>
										<input class="sel tar numeric" name="periods[base30][<?=$id?>]" type="text" value="<?=isset($periods_defaults['base30'][$id]) ? $periods_defaults['base30'][$id] : 30;?>" readonly/>
									</td>

									<td>
										<input class="sel numeric tar" type="text" name="periods[caldays][<?=$id?>]" readonly value="<?=isset($periods_defaults['caldays'][$id]) ? $periods_defaults['caldays'][$id] : $daysCalc;?>"/>
									</td>
									<td style="background: #f9f7dd !important;">
										<!-- <input class="numeric tar" type="text" name="periods[workdays][<?=$id?>]" value="<?=isset($periods_defaults['workdays'][$id]) ? $periods_defaults['workdays'][$id] : 22;?>" /> -->
										<input class="numeric tar" type="text" name="periods[workdays][<?=$id?>]" value="<?=$wd[$k];?>" />
									</td>

									<td></td>
								</tr>
						<? } ?>
						
						</tbody>
					</table>
				</div>


				
				<!--<div class="tab-pane" id="tab_allowances">
					<table border="0" style="width:100%; table-layout:fixed">
						<tr>
							<td style="padding-right:15px; vertical-align:top">
							
								<table class="basicTable inputs" border="0" id="fixTable">
									<thead>
										<tr style="border-bottom:1px solid #fff">
											<th colspan="6" class="tac" style="padding:4px; color:#a00; font-size:15px;"><?=$lng['Fixed allowances']?></th>
										</tr>
										<tr>
											<th style="width:1px">&nbsp;&nbsp;#&nbsp;&nbsp;</th>
											<th><?=$lng['Apply']?></th>
											<th style="width:50%;"><?=$lng['Thai description']?></th>
											<th style="width:50%; text-align:left"><?=$lng['English description']?></th>
											<th><?=$lng['Taxable']?></th>
											<th><?=$lng['Rate']?> <i data-toggle="tooltip" title="<?=$lng['Include in Day & Hour rate']?>" class="fa fa-question-circle fa-lg"></i></th>
										</tr>
									</thead>
									<tbody>
									<?	if($fix_allow){ foreach($fix_allow as $k=>$v){ ?>
										<tr>
											<td class="tac" style="border-right:1px #ddd solid"><b><?=$k?></b></td>
											<td class="tac" style="vertical-align:middle">
												<input name="fix_allow[<?=$k?>][apply]" type="hidden" value="0" />
												<label><input <? if($v['apply'] == 1){echo 'checked';} ?> name="fix_allow[<?=$k?>][apply]" type="checkbox" value="1" class="checkbox notxt" /><span></span></label>
											</td>
											<td style="border-right:1px #ddd solid"><input placeholder="__" name="fix_allow[<?=$k?>][th]" type="text" value="<?=$v['th']?>" /></td>
											<td style="border-right:1px #ddd solid"><input placeholder="__" name="fix_allow[<?=$k?>][en]" type="text" value="<?=$v['en']?>" /></td>
											<td>
												<select name="fix_allow[<?=$k?>][tax]" style="width:100%">
													<option <? if($v['tax'] == 'Y'){echo "selected ";} ?>value="Y"><?=$lng['Yes']?></option>
													<option <? if($v['tax'] == 'N'){echo "selected ";} ?>value="N"><?=$lng['No']?></option>
												</select>
											</td>
											<td>
												<select name="fix_allow[<?=$k?>][rate]" style="width:100%">
													<option <? if($v['rate'] == 'N'){echo "selected ";} ?>value="N"><?=$lng['No']?></option>
													<option <? if($v['rate'] == 'Y'){echo "selected ";} ?>value="Y"><?=$lng['Yes']?></option>
												</select>
											</td>
										</tr>
									<? }} ?>
									</tbody>
								</table>

								
							
							</td>
							<td style="padding-left:15px; vertical-align:top">
								
								<table class="basicTable inputs" border="0" id="varTable">
									<thead>
										<tr style="border-bottom:1px solid #fff">
											<th colspan="6" class="tac" style="padding:4px; color:#a00; font-size:15px;"><?=$lng['Variable allowances']?></th>
										</tr>
										<tr>
											<th style="width:1px">&nbsp;&nbsp;#&nbsp;&nbsp;</th>
											<th><?=$lng['Apply']?></th>
											<th style="width:50%;"><?=$lng['Thai description']?></th>
											<th style="width:50%; text-align:left"><?=$lng['English description']?></th>
											<th><?=$lng['Taxable']?></th>
										</tr>
									</thead>
									<tbody>
									<?	if($var_allow){ foreach($var_allow as $k=>$v){ ?>
										<tr>
											<td class="tac" style="border-right:1px #ddd solid"><b><?=$k?></b></td>
											<td class="tac" style="vertical-align:middle">
												<input name="var_allow[<?=$k?>][apply]" type="hidden" value="0" />
												<label><input <? if($v['apply'] == 1){echo 'checked';} ?> name="var_allow[<?=$k?>][apply]" type="checkbox" value="1" class="checkbox notxt" /><span></span></label>
											</td>
											<td style="border-right:1px #ddd solid"><input placeholder="__" name="var_allow[<?=$k?>][th]" type="text" value="<?=$v['th']?>" /></td>
											<td style="border-right:1px #ddd solid"><input placeholder="__" name="var_allow[<?=$k?>][en]" type="text" value="<?=$v['en']?>" /></td>
											<td>
												<select name="var_allow[<?=$k?>][tax]" style="width:100%">
													<option <? if($v['tax'] == 'Y'){echo "selected ";} ?>value="Y"><?=$lng['Yes']?></option>
													<option <? if($v['tax'] == 'N'){echo "selected ";} ?>value="N"><?=$lng['No']?></option>
												</select>
											</td>
										</tr>
									<? }} ?>
									</tbody>
								</table>
								
							
							</td>
						</tr>
					</table>
				</div> -->

				<div class="tab-pane" id="tab_sso">
					<table class="basicTable compact inputs" id="period_table" border="0">
						<thead>
							<tr>
								<th></th>
								<th colspan="3" class="tac"><?=$lng['SSO']?> <?=$lng['Employee']?></th>
								<th colspan="3" class="tac"><?=$lng['SSO']?> <?=$lng['Company']?></th>
								<th><?=$lng['PND']?> 3</th>
								<th style="width:80%">&nbsp;</th>
							</tr>
							<tr>
								<th class="tac" style="min-width:60px"><?=$lng['Month']?></th>
								<th class="tac" style="min-width:60px"><?=$lng['Rate']?> %</th>
								<th class="tac" style="min-width:60px"><?=$lng['Max']?>.</th>
								<th class="tac" style="min-width:60px"><?=$lng['Min']?>.</th>
								<th class="tac" style="min-width:60px"><?=$lng['Rate']?> %</th>
								<th class="tac" style="min-width:60px"><?=$lng['Max']?>.</th>
								<th class="tac" style="min-width:60px"><?=$lng['Min']?>.</th>
								<th class="tac" style="min-width:60px"><?=$lng['WHT']?> %</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
						<? foreach($sso_defaults as $k=>$v){ ?>
							<tr>
								<td style="padding:4px 10px !important"><b><?=$months[$k]?></b></td>
								<td>
									<input class="sel numeric tac" type="text" name="sso_defaults[<?=$k?>][sso_eRate]" value="<?=$v['sso_eRate']?>" />
								</td>
								<td>
									<input class="sel numeric tar" type="text" name="sso_defaults[<?=$k?>][sso_eMax]" value="<?=$v['sso_eMax']?>" />
								</td>
								<td>
									<input class="sel numeric tar" type="text" name="sso_defaults[<?=$k?>][sso_eMin]" value="<?=$v['sso_eMin']?>" />
								</td>
								<td>
									<input class="sel numeric tac" type="text" name="sso_defaults[<?=$k?>][sso_cRate]" value="<?=$v['sso_cRate']?>" />
								</td>
								<td>
									<input class="sel numeric tar" type="text" name="sso_defaults[<?=$k?>][sso_cMax]" value="<?=$v['sso_cMax']?>" />
								</td>
								<td>
									<input class="sel numeric tar" type="text" name="sso_defaults[<?=$k?>][sso_cMin]" value="<?=$v['sso_cMin']?>" />
								</td>
								<td>
									<input class="sel numeric tar" type="text" name="sso_defaults[<?=$k?>][wht]" value="<?=$v['wht']?>" />
								</td>
								<td></td>
							</tr>
						<? } ?>
						
						</tbody>
					</table>
				</div>
	
				<!-- <div class="tab-pane" id="tab_deductions">
					<table border="0" style="width:100%; table-layout:fixed"><tr><td style="padding-right:15px; vertical-align:top">
						<table class="basicTable inputs" border="0" id="fixTable">
							<thead>
								<tr style="border-bottom:1px solid #fff">
									<th colspan="6" class="tac" style="padding:4px; color:#a00; font-size:15px;"><?=$lng['Fixed deductions']?></th>
								</tr>
								<tr>
									<th style="width:1px">&nbsp;&nbsp;#&nbsp;&nbsp;</th>
									<th><?=$lng['Apply']?></th>
									<th style="width:50%;"><?=$lng['Deduction']?> <?=$lng['Thai']?></th>
									<th style="width:50%; text-align:left"><?=$lng['Deduction']?> <?=$lng['English']?></th>
									<th class="tac"><?=$lng['Tax']?></th>
								</tr>
							</thead>
							<tbody>
							<?	if($fix_deduct){ foreach($fix_deduct as $k=>$v){ ?>
								<tr>
									<td class="tac" style="border-right:1px #ddd solid"><b><?=$k?></b></td>
									<td class="tac" style="vertical-align:middle">
										<input name="fix_deduct[<?=$k?>][apply]" type="hidden" value="0" />
										<label><input <? if($v['apply'] == 1){echo 'checked';} ?> name="fix_deduct[<?=$k?>][apply]" type="checkbox" value="1" class="checkbox notxt" /><span></span></label>
									</td>
									<td style="border-right:1px #ddd solid"><input placeholder="__" name="fix_deduct[<?=$k?>][th]" type="text" value="<?=$v['th']?>" /></td>
									<td><input placeholder="__" name="fix_deduct[<?=$k?>][en]" type="text" value="<?=$v['en']?>" /></td>
									<td>
										<select name="fix_deduct[<?=$k?>][tax]" style="width:auto">
											<option <? if($v['tax'] == '0'){echo "selected ";} ?>value="0"><?=$lng['Before']?></option>
											<option <? if($v['tax'] == '1'){echo "selected ";} ?>value="1"><?=$lng['After']?></option>
										</select>
									</td>
								</tr>
							<? }} ?>
							</tbody>
						</table>
					</td><td style="padding-left:15px; vertical-align:top">
						<table class="basicTable inputs" border="0" id="varTable">
							<thead>
								<tr style="border-bottom:1px solid #fff">
									<th colspan="5" class="tac" style="padding:4px; color:#a00; font-size:15px;"><?=$lng['Variable deductions']?></th>
								</tr>
								<tr>
									<th style="width:1px">&nbsp;&nbsp;#&nbsp;&nbsp;</th>
									<th><?=$lng['Apply']?></th>
									<th style="width:50%;"><?=$lng['Deduction']?> <?=$lng['Thai']?></th>
									<th style="width:50%; text-align:left"><?=$lng['Deduction']?> <?=$lng['English']?></th>
									<th class="tac"><?=$lng['Tax']?></th>
								</tr>
							</thead>
							<tbody>
							<?	if($var_deduct){ foreach($var_deduct as $k=>$v){ ?>
								<tr>
									<td class="tac" style="border-right:1px #ddd solid"><b><?=$k?></b></td>
									<td class="tac" style="vertical-align:middle">
										<input name="var_deduct[<?=$k?>][apply]" type="hidden" value="0" />
										<label><input <? if($v['apply'] == 1){echo 'checked';} ?> name="var_deduct[<?=$k?>][apply]" type="checkbox" value="1" class="checkbox notxt" /><span></span></label>
									</td>
									<td style="border-right:1px #ddd solid"><input placeholder="__" name="var_deduct[<?=$k?>][th]" type="text" value="<?=$v['th']?>" /></td>
									<td><input placeholder="__" name="var_deduct[<?=$k?>][en]" type="text" value="<?=$v['en']?>" /></td>
									<td>
										<select name="var_deduct[<?=$k?>][tax]" style="width:auto">
											<option <? if($v['tax'] == '0'){echo "selected ";} ?>value="0"><?=$lng['Before']?></option>
											<option <? if($v['tax'] == '1'){echo "selected ";} ?>value="1"><?=$lng['After']?></option>
										</select>
									</td>
								</tr>
							<? }} ?>
							</tbody>
						</table>
					</td></tr></table>
				</div> -->
	
				<div class="tab-pane" id="tab_taxsettings" style="height:100%">
					<? include('employee_tax_data.inc.php');?>
					<!--<div style="height:100%; overflow-y:auto">
					<table id="deductionTable" class="basicTable inputs taxset vat" border="0">
					  <thead>
						 <tr style="line-height:100%">
							<th style="width:25%"><?=$lng['Description']?></th>
							<th class="tac" style="min-width:80px"><?=$lng['Unit']?></th>
							<th class="tac" style="min-width:60px"><?=$lng['Max']?><br /><?=strtolower($lng['Input'])?></th>
							<th class="tac" style="min-width:80px"><?=$lng['Max']?><br /><?=strtolower($lng['Amount'])?></th>
							<th style="width:70%"><?=$lng['Information condition error messages']?></th>
						 </tr>
					  </thead>
					  <tbody>
					  <tr>
						 <th>
						 	<input class="descri_info" type="text" name="tax_settings_description[stdeduct_per]" value="<?= isset($tax_settings_description['stdeduct_per']) ? $tax_settings_description['stdeduct_per'] : $lng['Standard deduction']?>">
						 </th>
						 <td></td>
						 <td></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[stdeduct_per]" placeholder="__" value="<?=$tax_settings['stdeduct_per']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[stdeduct_per]" placeholder="Thai info" value="<?=$tax_info_th['stdeduct_per']?>">
							<input class="in_info" type="text" name="tax_info_en[stdeduct_per]" placeholder="English info" value="<?=$tax_info_en['stdeduct_per']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	<input class="descri_info" type="text" name="tax_settings_description[standard_deduction]" value="<?= isset($tax_settings_description['standard_deduction']) ? $tax_settings_description['standard_deduction'] : $lng['Standard deduction'].' '.$lng['Max. amount']?>">
						</th>
						 <td></td>
						 <td></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[standard_deduction]" placeholder="__" value="<?=$tax_settings['standard_deduction']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[standard_deduction]" placeholder="Thai info" value="<?=$tax_info_th['standard_deduction']?>">
							<input class="in_info" type="text" name="tax_info_en[standard_deduction]" placeholder="English info" value="<?=$tax_info_en['standard_deduction']?>">
							<input class="in_err" type="text" name="tax_err_th[standard_deduction]" placeholder="Thai error message" value="<?=$tax_err_th['standard_deduction']?>">
							<input class="in_err" type="text" name="tax_err_en[standard_deduction]" placeholder="English error message" value="<?=$tax_err_en['standard_deduction']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	
						 	<input class="descri_info" type="text" name="tax_settings_description[personal_allowance]" value="<?= isset($tax_settings_description['personal_allowance']) ? $tax_settings_description['personal_allowance'] : $lng['Personal care']?>">	
						 	</th>
						 <td></td>
						 <td></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[personal_allowance]" placeholder="__" value="<?=$tax_settings['personal_allowance']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[personal_allowance]" placeholder="Thai info" value="<?=$tax_info_th['personal_allowance']?>">
							<input class="in_info" type="text" name="tax_info_en[personal_allowance]" placeholder="English info" value="<?=$tax_info_en['personal_allowance']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	
						 	<input class="descri_info" type="text" name="tax_settings_description[spouse_allowance]" value="<?= isset($tax_settings_description['spouse_allowance']) ? $tax_settings_description['spouse_allowance'] : $lng['Spouse care']?>">	
						 	</th>
						 <td></td>
						 <td class="tac">Y/N</td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[spouse_allowance]" placeholder="__" value="<?=$tax_settings['spouse_allowance']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[spouse_allowance]" placeholder="Thai info" value="<?=$tax_info_th['spouse_allowance']?>">
							<input class="in_info" type="text" name="tax_info_en[spouse_allowance]" placeholder="English info" value="<?=$tax_info_en['spouse_allowance']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	
						 	<input class="descri_info" type="text" name="tax_settings_description[parents_allow]" value="<?= isset($tax_settings_description['parents_allow']) ? $tax_settings_description['parents_allow'] : $lng['Parents care']?>">	
						 	</th>
						 <td class="tac">NUM/THB</td>
						 <td><input type="text" class="float21 tar sel" name="tax_settings[parents_allow]" placeholder="__" value="<?=$tax_settings['parents_allow']?>"></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[parents_allowance]" placeholder="__" value="<?=$tax_settings['parents_allowance']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[parents_allow]" placeholder="Thai info" value="<?=$tax_info_th['parents_allow']?>">
							<input class="in_info" type="text" name="tax_info_en[parents_allow]" placeholder="English info" value="<?=$tax_info_en['parents_allow']?>">
							<input class="in_err" type="text" name="tax_err_th[parents_allow]" placeholder="Thai error message" value="<?=$tax_err_th['parents_allow']?>">
							<input class="in_err" type="text" name="tax_err_en[parents_allow]" placeholder="English error message" value="<?=$tax_err_en['parents_allow']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	
						 	<input class="descri_info" type="text" name="tax_settings_description[parents_inlaw_allow]" value="<?= isset($tax_settings_description['parents_inlaw_allow']) ? $tax_settings_description['parents_inlaw_allow'] : $lng['Parents in law care']?>">
						 </th>
						 <td class="tac">NUM/THB</td>
						 <td><input type="text" class="float21 tar sel" name="tax_settings[parents_inlaw_allow]" placeholder="__" value="<?=$tax_settings['parents_inlaw_allow']?>"></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[parents_inlaw_allowance]" placeholder="__" value="<?=$tax_settings['parents_inlaw_allowance']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[parents_inlaw_allow]" placeholder="Thai info" value="<?=$tax_info_th['parents_inlaw_allow']?>">
							<input class="in_info" type="text" name="tax_info_en[parents_inlaw_allow]" placeholder="English info" value="<?=$tax_info_en['parents_inlaw_allow']?>">
							<input class="in_err" type="text" name="tax_err_th[parents_inlaw_allow]" placeholder="Thai error message" value="<?=$tax_err_th['parents_inlaw_allow']?>">
							<input class="in_err" type="text" name="tax_err_en[parents_inlaw_allow]" placeholder="English error message" value="<?=$tax_err_en['parents_inlaw_allow']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	
						 	<input class="descri_info" type="text" name="tax_settings_description[disabled_allow]" value="<?= isset($tax_settings_description['disabled_allow']) ? $tax_settings_description['disabled_allow'] : $lng['Care disabled person']?>">	
						 	</th>
						 <td class="tac">NUM/THB</td>
						 <td><input type="text" class="float21 tar sel" name="tax_settings[disabled_allow]" placeholder="__" value="<?=$tax_settings['disabled_allow']?>"></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[disabled_allowance]" placeholder="__" value="<?=$tax_settings['disabled_allowance']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[disabled_allow]" placeholder="Thai info" value="<?=$tax_info_th['disabled_allow']?>">
							<input class="in_info" type="text" name="tax_info_en[disabled_allow]" placeholder="English info" value="<?=$tax_info_en['disabled_allow']?>">
							<input class="in_err" type="text" name="tax_err_th[disabled_allow]" placeholder="Thai error message" value="<?=$tax_err_th['disabled_allow']?>">
							<input class="in_err" type="text" name="tax_err_en[disabled_allow]" placeholder="English error message" value="<?=$tax_err_en['disabled_allow']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	
						 	<input class="descri_info" type="text" name="tax_settings_description[child_allow]" value="<?= isset($tax_settings_description['child_allow']) ? $tax_settings_description['child_allow'] : $lng['Child care - biological']?>">	
						 	</th>
						 <td class="tac">NUM/THB</td>
						 <td><input type="text" class="float21 tar sel" name="tax_settings[child_allow]" placeholder="__" value="<?=$tax_settings['child_allow']?>"></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[child_allowance]" placeholder="__" value="<?=$tax_settings['child_allowance']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[child_allow]" placeholder="Thai info" value="<?=$tax_info_th['child_allow']?>">
							<input class="in_info" type="text" name="tax_info_en[child_allow]" placeholder="English info" value="<?=$tax_info_en['child_allow']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	<input class="descri_info" type="text" name="tax_settings_description[child_allow_2018]" value="<?= isset($tax_settings_description['child_allow_2018']) ? $tax_settings_description['child_allow_2018'] : $lng['Child care - biological 2018/19/20']?>">	
						 </th>
						 <td class="tac">NUM/THB</td>
						 <td><input type="text" class="float21 tar sel" name="tax_settings[child_allow_2018]" placeholder="__" value="<?=$tax_settings['child_allow_2018']?>"></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[child_allowance_2018]" placeholder="__" value="<?=$tax_settings['child_allowance_2018']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[child_allow_2018]" placeholder="Thai info" value="<?=$tax_info_th['child_allow_2018']?>">
							<input class="in_info" type="text" name="tax_info_en[child_allow_2018]" placeholder="English info" value="<?=$tax_info_en['child_allow_2018']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	<input class="descri_info" type="text" name="tax_settings_description[child_adopt_allow]" value="<?= isset($tax_settings_description['child_adopt_allow']) ? $tax_settings_description['child_adopt_allow'] : $lng['Child care - adopted']?>">
						 </th>
						 <td class="tac">NUM/THB</td>
						 <td><input type="text" class="float21 tar sel" name="tax_settings[child_adopt_allow]" placeholder="__" value="<?=$tax_settings['child_adopt_allow']?>"></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[child_adopt_allowance]" placeholder="__" value="<?=$tax_settings['child_adopt_allowance']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[child_adopt_allow]" placeholder="Thai info" value="<?=$tax_info_th['child_adopt_allow']?>">
							<input class="in_info" type="text" name="tax_info_en[child_adopt_allow]" placeholder="English info" value="<?=$tax_info_en['child_adopt_allow']?>">
							<input class="in_err" type="text" name="tax_err_th[child_adopt_allow]" placeholder="Thai error message" value="<?=$tax_err_th['child_adopt_allow']?>">
							<input class="in_err" type="text" name="tax_err_en[child_adopt_allow]" placeholder="English error message" value="<?=$tax_err_en['child_adopt_allow']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	<input class="descri_info" type="text" name="tax_settings_description[child_birth_bonus]" value="<?= isset($tax_settings_description['child_birth_bonus']) ? $tax_settings_description['child_birth_bonus'] : $lng['Child birth (Baby bonus)']?>">
						 </th>
						 <td></td>
						 <td></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[child_birth_bonus]" placeholder="__" value="<?=$tax_settings['child_birth_bonus']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[child_birth_bonus]" placeholder="Thai info" value="<?=$tax_info_th['child_birth_bonus']?>">
							<input class="in_info" type="text" name="tax_info_en[child_birth_bonus]" placeholder="English info" value="<?=$tax_info_en['child_birth_bonus']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	<input class="descri_info" type="text" name="tax_settings_description[own_health_insurance]" value="<?= isset($tax_settings_description['own_health_insurance']) ? $tax_settings_description['own_health_insurance'] : $lng['Own health insurance']?>">
						 </th>
						 <td></td>
						 <td></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[own_health_insurance]" placeholder="__" value="<?=$tax_settings['own_health_insurance']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[own_health_insurance]" placeholder="Thai info" value="<?=$tax_info_th['own_health_insurance']?>">
							<input class="in_info" type="text" name="tax_info_en[own_health_insurance]" placeholder="English info" value="<?=$tax_info_en['own_health_insurance']?>">
							<input class="in_err" type="text" name="tax_err_th[own_health_insurance]" placeholder="Thai error message" value="<?=$tax_err_th['own_health_insurance']?>">
							<input class="in_err" type="text" name="tax_err_en[own_health_insurance]" placeholder="English error message" value="<?=$tax_err_en['own_health_insurance']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	<input class="descri_info" type="text" name="tax_settings_description[own_life_insurance]" value="<?= isset($tax_settings_description['own_life_insurance']) ? $tax_settings_description['own_life_insurance'] : $lng['Own life insurance']?>">
						 </th>
						 <td></td>
						 <td></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[own_life_insurance]" placeholder="__" value="<?=$tax_settings['own_life_insurance']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[own_life_insurance]" placeholder="Thai info" value="<?=$tax_info_th['own_life_insurance']?>">
							<input class="in_info" type="text" name="tax_info_en[own_life_insurance]" placeholder="English info" value="<?=$tax_info_en['own_life_insurance']?>">
							<input class="in_err" type="text" name="tax_err_th[own_life_insurance]" placeholder="Thai error message" value="<?=$tax_err_th['own_life_insurance']?>">
							<input class="in_err" type="text" name="tax_err_en[own_life_insurance]" placeholder="English error message" value="<?=$tax_err_en['own_life_insurance']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	<input class="descri_info" type="text" name="tax_settings_description[max_own_health_life]" value="<?= isset($tax_settings_description['max_own_health_life']) ? $tax_settings_description['max_own_health_life'] : $lng['Max sum above']?>">
						 </th>
						 <td></td>
						 <td></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[max_own_health_life]" placeholder="__" value="<?=$tax_settings['max_own_health_life']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[max_own_health_life]" placeholder="Thai info" value="<?=$tax_info_th['max_own_health_life']?>">
							<input class="in_info" type="text" name="tax_info_en[max_own_health_life]" placeholder="English info" value="<?=$tax_info_en['max_own_health_life']?>">
							<input class="in_err" type="text" name="tax_err_th[max_own_health_life]" placeholder="Thai error message" value="<?=$tax_err_th['max_own_health_life']?>">
							<input class="in_err" type="text" name="tax_err_en[max_own_health_life]" placeholder="English error message" value="<?=$tax_err_en['max_own_health_life']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	<input class="descri_info" type="text" name="tax_settings_description[health_insurance_par]" value="<?= isset($tax_settings_description['health_insurance_par']) ? $tax_settings_description['health_insurance_par'] : $lng['Health insurance parents']?>">
						 </th>
						 <td></td>
						 <td><input type="text" class="float21 tar sel" name="tax_settings[health_insurance_par]" placeholder="__" value="<?=$tax_settings['health_insurance_par']?>"></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[health_insurance_parent]" placeholder="__" value="<?=$tax_settings['health_insurance_parent']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[health_insurance_par]" placeholder="Thai info" value="<?=$tax_info_th['health_insurance_par']?>">
							<input class="in_info" type="text" name="tax_info_en[health_insurance_par]" placeholder="English info" value="<?=$tax_info_en['health_insurance_par']?>">
							<input class="in_err" type="text" name="tax_err_th[health_insurance_par]" placeholder="Thai error message" value="<?=$tax_err_th['health_insurance_par']?>">
							<input class="in_err" type="text" name="tax_err_en[health_insurance_par]" placeholder="English error message" value="<?=$tax_err_en['health_insurance_par']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	<input class="descri_info" type="text" name="tax_settings_description[life_insurance_spouse]" value="<?= isset($tax_settings_description['life_insurance_spouse']) ? $tax_settings_description['life_insurance_spouse'] : $lng['Life insurance spouse']?>">
						 </th>
						 <td></td>
						 <td></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[life_insurance_spouse]" placeholder="__" value="<?=$tax_settings['life_insurance_spouse']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[life_insurance_spouse]" placeholder="Thai info" value="<?=$tax_info_th['life_insurance_spouse']?>">
							<input class="in_info" type="text" name="tax_info_en[life_insurance_spouse]" placeholder="English info" value="<?=$tax_info_en['life_insurance_spouse']?>">
							<input class="in_err" type="text" name="tax_err_th[life_insurance_spouse]" placeholder="Thai error message" value="<?=$tax_err_th['life_insurance_spouse']?>">
							<input class="in_err" type="text" name="tax_err_en[life_insurance_spouse]" placeholder="English error message" value="<?=$tax_err_en['life_insurance_spouse']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	<input class="descri_info" type="text" name="tax_settings_description[pension_fund_allowance]" value="<?= isset($tax_settings_description['pension_fund_allowance']) ? $tax_settings_description['pension_fund_allowance'] : $lng['Pension fund']?>">
						 </th>
						 <td></td>
						 <td></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[pension_fund_allowance]" placeholder="__" value="<?=$tax_settings['pension_fund_allowance']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[pension_fund_allowance]" placeholder="Thai info" value="<?=$tax_info_th['pension_fund_allowance']?>">
							<input class="in_info" type="text" name="tax_info_en[pension_fund_allowance]" placeholder="English info" value="<?=$tax_info_en['pension_fund_allowance']?>">
							<input class="in_err" type="text" name="tax_err_th[pension_fund_allowance]" placeholder="Thai error message" value="<?=$tax_err_th['pension_fund_allowance']?>">
							<input class="in_err" type="text" name="tax_err_en[pension_fund_allowance]" placeholder="English error message" value="<?=$tax_err_en['pension_fund_allowance']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	<input class="descri_info" type="text" name="tax_settings_description[provident_fund_allowance]" value="<?= isset($tax_settings_description['provident_fund_allowance']) ? $tax_settings_description['provident_fund_allowance'] : $lng['Provident fund']?>">
						 </th>
						 <td></td>
						 <td></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[provident_fund_allowance]" placeholder="__" value="<?=$tax_settings['provident_fund_allowance']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[provident_fund_allowance]" placeholder="Thai info" value="<?=$tax_info_th['provident_fund_allowance']?>">
							<input class="in_info" type="text" name="tax_info_en[provident_fund_allowance]" placeholder="English info" value="<?=$tax_info_en['provident_fund_allowance']?>">
							<input class="in_err" type="text" name="tax_err_th[provident_fund_allowance]" placeholder="Thai error message" value="<?=$tax_err_th['provident_fund_allowance']?>">
							<input class="in_err" type="text" name="tax_err_en[provident_fund_allowance]" placeholder="English error message" value="<?=$tax_err_en['provident_fund_allowance']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	<input class="descri_info" type="text" name="tax_settings_description[nsf_allowance]" value="<?= isset($tax_settings_description['nsf_allowance']) ? $tax_settings_description['nsf_allowance'] : $lng['NSF']?>">
						 </th>
						 <td></td>
						 <td></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[nsf_allowance]" placeholder="__" value="<?=$tax_settings['nsf_allowance']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[nsf_allowance]" placeholder="Thai info" value="<?=$tax_info_th['nsf_allowance']?>">
							<input class="in_info" type="text" name="tax_info_en[nsf_allowance]" placeholder="English info" value="<?=$tax_info_en['nsf_allowance']?>">
							<input class="in_err" type="text" name="tax_err_th[nsf_allowance]" placeholder="Thai error message" value="<?=$tax_err_th['nsf_allowance']?>">
							<input class="in_err" type="text" name="tax_err_en[nsf_allowance]" placeholder="English error message" value="<?=$tax_err_en['nsf_allowance']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	<input class="descri_info" type="text" name="tax_settings_description[rmf_allowance]" value="<?= isset($tax_settings_description['rmf_allowance']) ? $tax_settings_description['rmf_allowance'] : $lng['RMF']?>">
						 </th>
						 <td></td>
						 <td></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[rmf_allowance]" placeholder="__" value="<?=$tax_settings['rmf_allowance']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[rmf_allowance]" placeholder="Thai info" value="<?=$tax_info_th['rmf_allowance']?>">
							<input class="in_info" type="text" name="tax_info_en[rmf_allowance]" placeholder="English info" value="<?=$tax_info_en['rmf_allowance']?>">
							<input class="in_err" type="text" name="tax_err_th[rmf_allowance]" placeholder="Thai error message" value="<?=$tax_err_th['rmf_allowance']?>">
							<input class="in_err" type="text" name="tax_err_en[rmf_allowance]" placeholder="English error message" value="<?=$tax_err_en['rmf_allowance']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	<input class="descri_info" type="text" name="tax_settings_description[max_pension_provident_nsf_rmf]" value="<?= isset($tax_settings_description['max_pension_provident_nsf_rmf']) ? $tax_settings_description['max_pension_provident_nsf_rmf'] : $lng['Max sum above']?>">
						 </th>
						 <td></td>
						 <td></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[max_pension_provident_nsf_rmf]" placeholder="__" value="<?=$tax_settings['max_pension_provident_nsf_rmf']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[max_pension_provident_nsf_rmf]" placeholder="Thai info" value="<?=$tax_info_th['max_pension_provident_nsf_rmf']?>">
							<input class="in_info" type="text" name="tax_info_en[max_pension_provident_nsf_rmf]" placeholder="English info" value="<?=$tax_info_en['max_pension_provident_nsf_rmf']?>">
							<input class="in_err" type="text" name="tax_err_th[max_pension_provident_nsf_rmf]" placeholder="Thai error message" value="<?=$tax_err_th['max_pension_provident_nsf_rmf']?>">
							<input class="in_err" type="text" name="tax_err_en[max_pension_provident_nsf_rmf]" placeholder="English error message" value="<?=$tax_err_en['max_pension_provident_nsf_rmf']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	<input class="descri_info" type="text" name="tax_settings_description[ltf_allowance]" value="<?= isset($tax_settings_description['ltf_allowance']) ? $tax_settings_description['ltf_allowance'] : $lng['LTF']?>">
						 </th>
						 <td></td>
						 <td></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[ltf_allowance]" placeholder="__" value="<?=$tax_settings['ltf_allowance']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[ltf_allowance]" placeholder="Thai info" value="<?=$tax_info_th['ltf_allowance']?>">
							<input class="in_info" type="text" name="tax_info_en[ltf_allowance]" placeholder="English info" value="<?=$tax_info_en['ltf_allowance']?>">
							<input class="in_err" type="text" name="tax_err_th[ltf_allowance]" placeholder="Thai error message" value="<?=$tax_err_th['ltf_allowance']?>">
							<input class="in_err" type="text" name="tax_err_en[ltf_allowance]" placeholder="English error message" value="<?=$tax_err_en['ltf_allowance']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	<input class="descri_info" type="text" name="tax_settings_description[home_loan_interest]" value="<?= isset($tax_settings_description['home_loan_interest']) ? $tax_settings_description['home_loan_interest'] : $lng['Home loan interest']?>">
						 </th>
						 <td></td>
						 <td></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[home_loan_interest]" placeholder="__" value="<?=$tax_settings['home_loan_interest']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[home_loan_interest]" placeholder="Thai info" value="<?=$tax_info_th['home_loan_interest']?>">
							<input class="in_info" type="text" name="tax_info_en[home_loan_interest]" placeholder="English info" value="<?=$tax_info_en['home_loan_interest']?>">
							<input class="in_err" type="text" name="tax_err_th[home_loan_interest]" placeholder="Thai error message" value="<?=$tax_err_th['home_loan_interest']?>">
							<input class="in_err" type="text" name="tax_err_en[home_loan_interest]" placeholder="English error message" value="<?=$tax_err_en['home_loan_interest']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	<input class="descri_info" type="text" name="tax_settings_description[social_security_fund]" value="<?= isset($tax_settings_description['social_security_fund']) ? $tax_settings_description['social_security_fund'] : $lng['Social Security Fund']?>">
						 </th>
						 <td></td>
						 <td></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[social_security_fund]" placeholder="__" value="<?=$tax_settings['social_security_fund']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[social_security_fund]" placeholder="Thai info" value="<?=$tax_info_th['social_security_fund']?>">
							<input class="in_info" type="text" name="tax_info_en[social_security_fund]" placeholder="English info" value="<?=$tax_info_en['social_security_fund']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	<input class="descri_info" type="text" name="tax_settings_description[exemp_disabled_under]" value="<?= isset($tax_settings_description['exemp_disabled_under']) ? $tax_settings_description['exemp_disabled_under'] : $lng['Exemption disabled person <65 yrs']?>">
						 </th>
						 <td></td>
						 <td class="tac">Y/N</td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[exemp_disabled_under]" placeholder="__" value="<?=$tax_settings['exemp_disabled_under']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[exemp_disabled_under]" placeholder="Thai info" value="<?=$tax_info_th['exemp_disabled_under']?>">
							<input class="in_info" type="text" name="tax_info_en[exemp_disabled_under]" placeholder="English info" value="<?=$tax_info_en['exemp_disabled_under']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	<input class="descri_info" type="text" name="tax_settings_description[exemp_payer_older]" value="<?= isset($tax_settings_description['exemp_payer_older']) ? $tax_settings_description['exemp_payer_older'] : $lng['Exemption tax payer => 65yrs']?>">
						 </th>
						 <td></td>
						 <td class="tac">Y/N</td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[exemp_payer_older]" placeholder="__" value="<?=$tax_settings['exemp_payer_older']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[exemp_payer_older]" placeholder="Thai info" value="<?=$tax_info_th['exemp_payer_older']?>">
							<input class="in_info" type="text" name="tax_info_en[exemp_payer_older]" placeholder="English info" value="<?=$tax_info_en['exemp_payer_older']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	<input class="descri_info" type="text" name="tax_settings_description[donation_charity]" value="<?= isset($tax_settings_description['donation_charity']) ? $tax_settings_description['donation_charity'] : $lng['Donation charity']?>">
						 </th>
						 <td></td>
						 <td></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[donation_charity]" placeholder="__" value="<?=$tax_settings['donation_charity']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[donation_charity]" placeholder="Thai info" value="<?=$tax_info_th['donation_charity']?>">
							<input class="in_info" type="text" name="tax_info_en[donation_charity]" placeholder="English info" value="<?=$tax_info_en['donation_charity']?>">
							<input class="in_err" type="text" name="tax_err_th[donation_charity]" placeholder="Thai error message" value="<?=$tax_err_th['donation_charity']?>">
							<input class="in_err" type="text" name="tax_err_en[donation_charity]" placeholder="English error message" value="<?=$tax_err_en['donation_charity']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	<input class="descri_info" type="text" name="tax_settings_description[donation_flood]" value="<?= isset($tax_settings_description['donation_flood']) ? $tax_settings_description['donation_flood'] : $lng['Donation flooding']?>">
						 </th>
						 <td></td>
						 <td></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[donation_flood]" placeholder="__" value="<?=$tax_settings['donation_flood']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[donation_flood]" placeholder="Thai info" value="<?=$tax_info_th['donation_flood']?>">
							<input class="in_info" type="text" name="tax_info_en[donation_flood]" placeholder="English info" value="<?=$tax_info_en['donation_flood']?>">
							<input class="in_err" type="text" name="tax_err_th[donation_flood]" placeholder="Thai error message" value="<?=$tax_err_th['donation_flood']?>">
							<input class="in_err" type="text" name="tax_err_en[donation_flood]" placeholder="English error message" value="<?=$tax_err_en['donation_flood']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	<input class="descri_info" type="text" name="tax_settings_description[donation_education]" value="<?= isset($tax_settings_description['donation_education']) ? $tax_settings_description['donation_education'] : $lng['Donation education']?>">
						 </th>
						 <td></td>
						 <td></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[donation_education]" placeholder="__" value="<?=$tax_settings['donation_education']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[donation_education]" placeholder="Thai info" value="<?=$tax_info_th['donation_education']?>">
							<input class="in_info" type="text" name="tax_info_en[donation_education]" placeholder="English info" value="<?=$tax_info_en['donation_education']?>">
							<input class="in_err" type="text" name="tax_err_th[donation_education]" placeholder="Thai error message" value="<?=$tax_err_th['donation_education']?>">
							<input class="in_err" type="text" name="tax_err_en[donation_education]" placeholder="English error message" value="<?=$tax_err_en['donation_education']?>">
						 </td>
					  </tr>
					  
					  <tr>
						 <th>
						 	<input class="descri_info" type="text" name="tax_settings_description[first_home_allowance]" value="<?= isset($tax_settings_description['first_home_allowance']) ? $tax_settings_description['first_home_allowance'] : $lng['First home buyer']?>">
						 </th>
						 <td></td>
						 <td></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[first_home_allowance]" placeholder="__" value="<?=$tax_settings['first_home_allowance']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[first_home_allowance]" placeholder="Thai info" value="<?=$tax_info_th['first_home_allowance']?>">
							<input class="in_info" type="text" name="tax_info_en[first_home_allowance]" placeholder="English info" value="<?=$tax_info_en['first_home_allowance']?>">
							<input class="in_err" type="text" name="tax_err_th[first_home_allowance]" placeholder="Thai error message" value="<?=$tax_err_th['first_home_allowance']?>">
							<input class="in_err" type="text" name="tax_err_en[first_home_allowance]" placeholder="English error message" value="<?=$tax_err_en['first_home_allowance']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	<input class="descri_info" type="text" name="tax_settings_description[year_end_shop_allowance]" value="<?= isset($tax_settings_description['year_end_shop_allowance']) ? $tax_settings_description['year_end_shop_allowance'] : $lng['Year-end shopping']?>">
						 </th>
						 <td></td>
						 <td></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[year_end_shop_allowance]" placeholder="__" value="<?=$tax_settings['year_end_shop_allowance']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[year_end_shop_allowance]" placeholder="Thai info" value="<?=$tax_info_th['year_end_shop_allowance']?>">
							<input class="in_info" type="text" name="tax_info_en[year_end_shop_allowance]" placeholder="English info" value="<?=$tax_info_en['year_end_shop_allowance']?>">
							<input class="in_err" type="text" name="tax_err_th[year_end_shop_allowance]" placeholder="Thai error message" value="<?=$tax_err_th['year_end_shop_allowance']?>">
							<input class="in_err" type="text" name="tax_err_en[year_end_shop_allowance]" placeholder="English error message" value="<?=$tax_err_en['year_end_shop_allowance']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	<input class="descri_info" type="text" name="tax_settings_description[domestic_tour_allowance]" value="<?= isset($tax_settings_description['domestic_tour_allowance']) ? $tax_settings_description['domestic_tour_allowance'] : $lng['Domestic tour']?>">
						 </th>
						 <td></td>
						 <td></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[domestic_tour_allowance]" placeholder="__" value="<?=$tax_settings['domestic_tour_allowance']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[domestic_tour_allowance]" placeholder="Thai info" value="<?=$tax_info_th['domestic_tour_allowance']?>">
							<input class="in_info" type="text" name="tax_info_en[domestic_tour_allowance]" placeholder="English info" value="<?=$tax_info_en['domestic_tour_allowance']?>">
							<input class="in_err" type="text" name="tax_err_th[domestic_tour_allowance]" placeholder="Thai error message" value="<?=$tax_err_th['domestic_tour_allowance']?>">
							<input class="in_err" type="text" name="tax_err_en[domestic_tour_allowance]" placeholder="English error message" value="<?=$tax_err_en['domestic_tour_allowance']?>">
						 </td>
					  </tr>
					  <tr>
						 <th>
						 	<input class="descri_info" type="text" name="tax_settings_description[other_allowance]" value="<?= isset($tax_settings_description['other_allowance']) ? $tax_settings_description['other_allowance'] : $lng['Other allowance']?>">
						 </th>
						 <td></td>
						 <td></td>
						 <td>
							<input type="text" class="numeric tar sel" name="tax_settings[other_allowance]" placeholder="__" value="<?=$tax_settings['other_allowance']?>">
						 </td>
						 <td class="info">
							<input class="in_info" type="text" name="tax_info_th[other_allowance]" placeholder="Thai info" value="<?=$tax_info_th['other_allowance']?>">
							<input class="in_info" type="text" name="tax_info_en[other_allowance]" placeholder="English info" value="<?=$tax_info_en['other_allowance']?>">
						 </td>
					  </tr>
					  </tbody>
					</table>
					</div>-->
				</div>
					
				<div class="tab-pane" id="tab_taxrules">
					<table id="rulesTable" class="basicTable inputs" border="0">
						<thead>
							<tr>
								<th class="tac" colspan="2"><?=$lng['GROSS to NET']?></th>
								<th class="tac"><?=$lng['Tax rate']?></th>
								<th class="tac" colspan="2"><?=$lng['NET to GROSS']?></th>
								<th style="width:50%;"></th>
							</tr>
							<tr>
								<th><?=$lng['From']?></th>
								<th><?=$lng['To']?></th>
								<th><?=$lng['Percent']?></th>
								<th><?=$lng['From']?></th>
								<th><?=$lng['To']?></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<? foreach($taxrules as $k=>$v){ ?>
							<tr>
								<td><input style="background:#f3fff3 !important" class="numeric9 changeRules" type="text" name="from[<?=$k?>]" placeholder="..." value="<?=$v['from']?>"></td>
								<td><input style="background:#f3fff3 !important" class="numeric9 changeRules" type="text" name="to[<?=$k?>]" placeholder="..." value="<?=$v['to']?>"></td>
								<td><input style="background:#f3fff3 !important" type="text" class="numeric2 changeRules" name="percent[<?=$k?>]" placeholder="..." value="<?=$v['percent']?>"></td>
								<td><input style="background:#fffff3 !important" readonly name="net_from[<?=$k?>]" type="text" placeholder="..." value="<?=$v['net_from']?>"></td>
								<td><input style="background:#fffff3 !important" readonly name="net_to[<?=$k?>]" type="text"placeholder="..." value="<?=$v['net_to']?>"></td>
								<td></td>
							</tr>
						<? } ?>
						</tbody>
					</table>
				</div>
			
		</form>
	</div>
	
	



<!------ modify add Modal  -------->
<div class="modal fade" id="addPrefixModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Add Prefix Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><?=$lng['Prefix']?></th>
								<td>
										<input style="width: 79%" maxlength="39" placeholder="EMP" type="text" name="id_prefix" id="id_prefix" value=""> 
								</td>
							</tr>
							<tr>
								<th class="tal"><?=$lng['Start at']?></th>
								<td>
									<input placeholder="1000" maxlength="4" class="sel numeric" type="text" name="id_start" id="id_start" value=""/>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalAdd();"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>

<!------ modify add Modal  -------->
<div class="modal fade" id="editPrefixModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Edit Prefix Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Update Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><?=$lng['Prefix']?></th>
								<td>
										<input class="id_prefix" style="width: 79%" maxlength="39" placeholder="EMP" type="text" name="id_prefix" id="id_prefix" value=""> 
										<input type="hidden" name="keyToUpdate" class="keyToUpdate" value="">
								</td>
							</tr>
							<tr>
								<th class="tal"><?=$lng['Start at']?></th>
								<td>
									<input class="id_start" placeholder="1000" maxlength="4" class="sel numeric" type="text" name="id_start" id="id_start" value=""/>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalEdit();"><?=$lng['Update']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>


<script>
var height = window.innerHeight-265;

function hrsOption(that,id){

	if($(that).attr('checked',true)){
		$('#calcOpt'+id).attr('disabled',false).css('visibility','visible').addClass('inptbkg');
		$('#multiplicator'+id).attr('disabled',false).addClass('inptbkg');
		$('#nrhrs'+id).attr('disabled',false).addClass('inptbkg').attr('placeholder','000:00');
		$('#incomeBase'+id).attr('disabled',false);
		$('#incomeBase'+id+' option[value="56"]').attr('selected',true);
		$('input[name="income_base['+id+']"]').val(56);
		$('#incomeBase'+id).closest('div.SumoSelect').removeClass('disabled');
		$('#incomeBase'+id).closest('div.SumoSelect').css('visibility','visible');
		$(".hourFormat").mask("999:99", {placeholder: "000:00"});

		//==== For Times 
		if($('#times'+id).prop('checked')){
			$('#thbunit'+id).attr('disabled',false).addClass('inptbkg');
			$('#unitarr'+id).attr('disabled',false).css('visibility','visible').addClass('inptbkg');
		}else{
			$('#thbunit'+id).attr('disabled',true).removeClass('inptbkg');
			$('#unitarr'+id).attr('disabled',true).val('').css('visibility','hidden').removeClass('inptbkg');
		}
		
	}else{
		$('#multiplicator'+id).attr('disabled',true).removeClass('inptbkg');
		$('#calcOpt'+id).attr('disabled',true).val('').css('visibility','hidden').removeClass('inptbkg');
		$('#nrdays'+id).attr('disabled',true).removeClass('inptbkg');
		$('#nrhrs'+id).attr('disabled',true).removeClass('inptbkg').val('').attr('placeholder','');
		$('#incomeBase'+id).attr('disabled',true).val('');
		$('#incomeBase'+id).attr('selected',false);
		$('#incomeBase'+id).closest('div.SumoSelect').addClass('disabled');
		$('#incomeBase'+id).closest('div.SumoSelect').css('visibility','hidden');
	}

	if($(that).is(':not(:checked)')){
		$('#multiplicator'+id).attr('disabled',true).removeClass('inptbkg').val('');
		$('#calcOpt'+id).attr('disabled',true).css('visibility','hidden').removeClass('inptbkg');
		$('#nrdays'+id).attr('disabled',true).removeClass('inptbkg').val('');
		$('#nrhrs'+id).attr('disabled',true).removeClass('inptbkg').val('').attr('placeholder','');
		$('#incomeBase'+id).attr('disabled',true).val('');
		$('input[name="income_base['+id+']"]').val('');
		$('#incomeBase'+id).attr('selected',false);
		$('#incomeBase'+id).closest('div.SumoSelect').addClass('disabled');
		$('#incomeBase'+id).closest('div.SumoSelect').css('visibility','hidden');
	}
}

function timesOption(that,id){

	if($(that).attr('checked',true)){ 
		
		$('#thbunit'+id).attr('disabled',false).addClass('inptbkg');
		$('#unitarr'+id).attr('disabled',false).css('visibility','visible').addClass('inptbkg');

		//==== For Hrs 
		if($('#hrs'+id).prop('checked')){
		
			$('#calcOpt'+id).attr('disabled',false).css('visibility','visible').addClass('inptbkg');
			$('#multiplicator'+id).attr('disabled',false).addClass('inptbkg');
			$('#nrhrs'+id).attr('disabled',false).addClass('inptbkg').attr('placeholder','000:00');
			$('#incomeBase'+id).attr('disabled',false);
			$('#incomeBase'+id+' option[value="56"]').attr('selected',true);
			$('input[name="income_base['+id+']"]').val(56);
			$('#incomeBase'+id).closest('div.SumoSelect').removeClass('disabled');
			$('#incomeBase'+id).closest('div.SumoSelect').css('visibility','visible');
			$(".hourFormat").mask("999:99", {placeholder: "000:00"});
			
		}else{
			
			$('#multiplicator'+id).attr('disabled',true).removeClass('inptbkg');
			$('#calcOpt'+id).attr('disabled',true).val('').css('visibility','hidden').removeClass('inptbkg');
			$('#nrdays'+id).attr('disabled',true).removeClass('inptbkg').val('');
			$('#nrhrs'+id).attr('disabled',true).removeClass('inptbkg').val('').attr('placeholder','');
			$('#incomeBase'+id).attr('disabled',true).val('');
			$('#incomeBase'+id).attr('selected',false);
			$('#incomeBase'+id).closest('div.SumoSelect').addClass('disabled');
			$('#incomeBase'+id).closest('div.SumoSelect').css('visibility','hidden');
		}

		
	}else{
		$('#thbunit'+id).attr('disabled',true).removeClass('inptbkg');
		$('#unitarr'+id).attr('disabled',true).val('').css('visibility','hidden').removeClass('inptbkg');
	}

	if($(that).is(':not(:checked)')){

		$('#thbunit'+id).attr('disabled',true).removeClass('inptbkg').val('');
		$('#unitarr'+id).attr('disabled',true).val('').css('visibility','hidden').removeClass('inptbkg');
	}
}


function thbOption(that,id){
	if($(that).attr('checked',true)){
		$('#calcOpt'+id).attr('disabled',true).css('visibility','hidden').removeClass('inptbkg');
		$('#nrdays'+id).attr('disabled',true).removeClass('inptbkg');
		$('#nrhrs'+id).attr('disabled',false).removeClass('inptbkg').attr('placeholder','');
		$('#multiplicator'+id).attr('disabled',true).removeClass('inptbkg');
		$('#incomeBase'+id).attr('disabled',true);
		$('#incomeBase'+id).closest('div.SumoSelect').addClass('disabled');
		$('#incomeBase'+id).closest('div.SumoSelect').css('visibility','hidden');
		$('#incomeBase'+id).closest('input[name="income_base['+id+']"]');
	
		$('#thbunit'+id).attr('disabled',true).removeClass('inptbkg');
		$('#unitarr'+id).attr('disabled',true).css('visibility','hidden').removeClass('inptbkg');

		//==== For Hrs 
		if($('#hrs'+id).prop('checked')){
			$('#calcOpt'+id).attr('disabled',false).css('visibility','visible').addClass('inptbkg');
			$('#multiplicator'+id).attr('disabled',false).addClass('inptbkg');
			$('#nrdays'+id).attr('disabled',false).removeClass('inptbkg');
			$('#nrhrs'+id).attr('disabled',false).addClass('inptbkg').attr('placeholder','000:00');
			$('#incomeBase'+id).attr('disabled',false);
			$('#incomeBase'+id+' option[value="56"]').attr('selected',true);
			$('input[name="income_base['+id+']"]').val(56);
			$('#incomeBase'+id).closest('div.SumoSelect').removeClass('disabled');
			$('#incomeBase'+id).closest('div.SumoSelect').css('visibility','visible');
			$(".hourFormat").mask("999:99", {placeholder: "000:00"});
			
		}else{
			
			$('#multiplicator'+id).attr('disabled',true).removeClass('inptbkg');
			$('#calcOpt'+id).attr('disabled',true).val('').css('visibility','hidden').removeClass('inptbkg');
			$('#nrdays'+id).attr('disabled',true).removeClass('inptbkg');
			$('#nrhrs'+id).attr('disabled',true).removeClass('inptbkg').val('').attr('placeholder','');
			$('#incomeBase'+id).attr('disabled',true).val('');
			$('#incomeBase'+id).attr('selected',false);
			$('#incomeBase'+id).closest('div.SumoSelect').addClass('disabled');
			$('#incomeBase'+id).closest('div.SumoSelect').css('visibility','hidden');
		}

		//==== For Times 
		if($('#times'+id).prop('checked')){
			$('#thbunit'+id).attr('disabled',false).addClass('inptbkg');
			$('#unitarr'+id).attr('disabled',false).css('visibility','visible').addClass('inptbkg');
		}else{
			$('#thbunit'+id).attr('disabled',true).removeClass('inptbkg');
			$('#unitarr'+id).attr('disabled',true).val('').css('visibility','hidden').removeClass('inptbkg');
		}
	}
}

function calcoptsel(that,id){
	if(that == 3){
		$('#nrdays'+id).attr('readonly',false).attr('disabled',false).addClass('inptbkg');
		$('#nrhrs'+id).attr('readonly',false).attr('disabled',false).addClass('inptbkg');
	}else{

		if(that == 1){
			var calcdays = <?=$daysCalc;?>;
			$('#nrdays'+id).attr('readonly',false).removeClass('inptbkg');
			$('#nrdays'+id).val(calcdays);
		}else{
			$('#nrdays'+id).attr('readonly',false).removeClass('inptbkg');
			$('#nrdays'+id).val(30);
		}
		
	}
}

$(document).ready(function() {
	
	var posi = <?=json_encode($pos_count + 1)?>;
	var getAttendAllowDeduct = <?=json_encode($varAllowDeduct)?>;

	$("#addposition").click(function(){
		var addrow = '<tr><td><b><input name="positions['+posi+'][code]" type="text" value="'+posi+'" /></b></td><td><input placeholder="<?=$lng['Thai description']?>" name="positions['+posi+'][th]" type="text" /></td><td><input placeholder="<?=$lng['English description']?>" name="positions['+posi+'][en]" type="text" /></td><td></td></tr>';
		if(posi == 1){
			$("#position_table tbody").html(addrow);
		}else{
			$("#position_table tr:last").after(addrow);
		}
		posi ++;
	});

	$('.xdatepick').datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
		inline: true,
		orientation: 'auto bottom',
		language: lang,
		todayHighlight: true,
		startView: 'year',
		//startDate : startYear,
		//endDate   : endYear
	})

	$('.send').on('change', function(){
		var m = $(this).data('m')+1;
		var parts = this.value.split('-');
		var d = parts[2]+'-'+parts[1]+'-'+parts[0]; 				
		var today = moment(d);
		var tomorrow = moment(today).add(1, 'days').format('DD-MM-YYYY');
		if(m <= 12){
			$('.sstart'+m).val(tomorrow);
		}
	})
	$('.tend').on('change', function(){
		var m = $(this).data('m')+1;
		var parts = this.value.split('-');
		var d = parts[2]+'-'+parts[1]+'-'+parts[0]; 				
		var today = moment(d);
		var tomorrow = moment(today).add(1, 'days').format('DD-MM-YYYY');
		if(m <= 12){
			$('.tstart'+m).val(tomorrow);
		}
	})
	$('.lend').on('change', function(){
		var m = $(this).data('m')+1;
		var parts = this.value.split('-');
		var d = parts[2]+'-'+parts[1]+'-'+parts[0]; 				
		var today = moment(d);
		var tomorrow = moment(today).add(1, 'days').format('DD-MM-YYYY');
		if(m <= 12){
			$('.lstart'+m).val(tomorrow);
		}
	})
	$('.pend').on('change', function(){
		var m = $(this).data('m')+1;
		var parts = this.value.split('-');
		var d = parts[2]+'-'+parts[1]+'-'+parts[0]; 				
		var today = moment(d);
		var tomorrow = moment(today).add(1, 'days').format('DD-MM-YYYY');
		if(m <= 12){
			$('.pstart'+m).val(tomorrow);
		}
	})


	$('#defincombase').SumoSelect({
		placeholder: '<?=$lng['Select'].' '.$lng['Income']?>',
		captionFormat: '<?=$lng['Income']?> ({0})',
		captionFormatAllSelected: '<?=$lng['All'].' '.$lng['Income']?> ({0})',
		csvDispCount:1,
		outputAsCSV: true,
		selectAll:true,
		okCancelInMulti:true, 
		showTitle : false,
		triggerChangeCombined: true,
	});

	$(getAttendAllowDeduct).each(function(k,v){

		if(v.man_att == 1){
			//console.log(v);
			$('#incomeBase'+v.id).SumoSelect({
				placeholder: '<?=$lng['Select'].' '.$lng['Income']?>',
				captionFormat: '<?=$lng['Income']?> ({0})',
				captionFormatAllSelected: '<?=$lng['All'].' '.$lng['Income']?> ({0})',
				csvDispCount:1,
				outputAsCSV: true,
				selectAll:true,
				okCancelInMulti:true, 
				showTitle : false,
				triggerChangeCombined: true,
			});
		}
	})

	function calculateNet(){
		var data = new FormData($('#payrollForm')[0]);
		$.ajax({
			url: AROOT+"def_settings/ajax/calculate_net.php",
			type: 'POST',
			data: data,
			async: false,
			cache: false,
			dataType: 'json',
			contentType: false,
			processData: false,
			success: function(data){
				//alert(data['net_from'][2])
				//$('#dump').html(data['net_from'][2]);
				$.each(data.net_from, function(i,val){
					$('#payrollForm input[name="net_from['+i+']"]').val(val)
				})
				$.each(data.net_to, function(i,val){
					$('#payrollForm input[name="net_to['+i+']"]').val(val)
				})
				
				

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
	}
	//calculateNet()
	$(".changeRules").on('change', function(){
		calculateNet();
	})
	
	var fixa = <?=json_encode(count($fix_allow)+1)?>;
	var vara = <?=json_encode(count($var_allow)+1)?>;
	$("#addfix").on('click', function(){
		if(fixa <= 15){
			var addrow = '<tr><td class="tac" style="border-right:1px #ddd solid"><b>'+fixa+'</b></td>'+
				'<td class="tac" style="vertical-align:middle"><input name="fix_allow['+fixa+'][apply]" type="hidden" value="0" /><label><input name="fix_allow['+fixa+'][apply]" type="checkbox" value="1" class="checkbox notxt" /><span></span></label></td>'+
				'<td style="border-right:1px #ddd solid"><input placeholder="__" name="fix_allow['+fixa+'][th]" type="text" /></td>'+
				'<td style="border-right:1px #ddd solid"><input placeholder="__" name="fix_allow['+fixa+'][en]" type="text" /></td>'+
				'<td><select name="fix_allow['+fixa+'][tax]"><option value="Y"><?=$lng['Yes']?></option><option value="N"><?=$lng['No']?></option></select></td></tr>';
			$("#fixTable tbody").append(addrow);
			fixa ++;
		}
	});

	$("#addvar").on('click', function(){
		if(vara <= 15){
			var addrow = '<tr><td class="tac" style="border-right:1px #ddd solid"><b>'+vara+'</b></td>'+
				'<td class="tac" style="vertical-align:middle"><input name="var_allow['+vara+'][apply]" type="hidden" value="0" /><label><input name="var_allow['+vara+'][apply]" type="checkbox" value="1" class="checkbox notxt" /><span></span></label></td>'+
				'<td style="border-right:1px #ddd solid"><input placeholder="__" name="var_allow['+vara+'][th]" type="text" /></td>'+
				'<td style="border-right:1px #ddd solid"><input placeholder="__" name="var_allow['+vara+'][en]" type="text" /></td>'+
				'<td><select name="var_allow['+vara+'][tax]"><option value="Y"><?=$lng['Yes']?></option><option value="N"><?=$lng['No']?></option></select></td></tr>';

			$("#varTable tbody").append(addrow);
			vara ++;
		}
	});

	$("#payrollForm").submit(function(e){ 
		e.preventDefault();
		$("#submitbtn i").removeClass('fa-save').addClass('fa-refresh fa-spin');
		var data = $(this).serialize();
		$.ajax({
			url: AROOT+"def_settings/ajax/update_default_payroll_settings.php",
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
						type: "warn",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+result,
						duration: 4,
						closeConfirm: true
					})
				}
				setTimeout(function(){
					$("#submitbtn i").removeClass('fa-refresh fa-spin').addClass('fa-save');
					$("#submitbtn").removeClass('flash');
					$("#sAlert").fadeOut(200);

					window.location.reload();
				},2000);
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
	
	var activeTab = localStorage.getItem('activeTab10');
	$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
		localStorage.setItem('activeTab10', $(e.target).data('target'));
	});
	if(activeTab){
		$('#myTab a[data-target="' + activeTab + '"]').tab('show');
	}else{
		$('#myTab a[data-target="#tab_settings"]').tab('show');
	}
	
	/*$('.autoheight').css('min-height', height);
	$(window).on('resize', function(){
		var height = window.innerHeight-265;
		$('.autoheight').css('min-height', height);
	});*/	
	
	setTimeout(function(){
		$('body').on('change', 'input, textarea, select', function (e) {
			$("#submitbtn").addClass('flash');
			$("#sAlert").fadeIn(200);
		});	
	},1000);
	
});

function get_shift_schedule()
{
	var getid = $('#getteam').val();
	// run ajax to get the description 

			$.ajax({
			url: AROOT+"def_settings/ajax/get_shift_schedule_desc.php",
			type: 'POST',
			data: {'getid':getid},
			success: function(result){
				// response 
				var obj = JSON.parse(result);

				$('#shiftplan_schedule').val(obj.desc);
				$('#teams_name').val(obj.th_name);

			},

		});

}


$(document).on("click", "#addPrefix", function(e){
		e.preventDefault();
		$('#addPrefixModal').modal('toggle');
	});	

$(document).on("click", "#editPrefix", function(e){
	e.preventDefault();


	var selectedPrefix = $('#id_prefix_select').val();
	$.ajax({
		url: AROOT+"def_settings/ajax/get_prefix_data.php",
		type: 'POST',
		data: {selectedPrefix:selectedPrefix},
		success: function(result){

			var data = JSON.parse(result);

			$('.id_prefix').val(data.idPrefix);
			$('.id_start').val(data.startCount);
			$('.keyToUpdate').val(data.idPrefix);

			$('#editPrefixModal').modal('toggle');

		},

	});



});			


function submitPopupModalAdd()
{
	var idPrefix = $('#id_prefix').val();
	var startCount = $('#id_start').val();

	if( (idPrefix == '') && (startCount == '') )
	{
		$("body").overhang({
			type: "error",
			message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : Please fill the valid values',
			duration: 4,
		})
		return false;
	}


	$.ajax({
		url: AROOT+"def_settings/ajax/update_employee_default_prefix.php",
		type: 'POST',
		data: {idPrefix:idPrefix,startCount:startCount},
		success: function(result){
			$("#submitBtn").removeClass('flash');
			$("#sAlert").fadeOut(200);
			if(result == 'success'){
				$("body").overhang({
					type: "success",
					message: '<i class="fa fa-check"></i>&nbsp;&nbsp;Data updated successfuly',
					duration: 2,
				})
				setTimeout(function(){location.reload();},500);
			}else{
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+result,
					duration: 4,
				})
			}
			setTimeout(function(){$("#submitBtn i").removeClass('fa-refresh fa-spin').addClass('fa-save');},500);
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

function submitPopupModalEdit()
{
	var idPrefix = $('.id_prefix').val();
	var keyToUpdate = $('.keyToUpdate').val();
	var startCount = $('.id_start').val();

	$.ajax({
		url: AROOT+"def_settings/ajax/edit_employee_default_prefix.php",
		type: 'POST',
		data: {idPrefix:idPrefix,startCount:startCount,keyToUpdate:keyToUpdate},
		success: function(result){
			$("#submitBtn").removeClass('flash');
			$("#sAlert").fadeOut(200);
			if(result == 'success'){
				$("body").overhang({
					type: "success",
					message: '<i class="fa fa-check"></i>&nbsp;&nbsp;Data updated successfuly',
					duration: 2,
				})
				setTimeout(function(){location.reload();},500);
			}else{
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+result,
					duration: 4,
				})
			}
			setTimeout(function(){$("#submitBtn i").removeClass('fa-refresh fa-spin').addClass('fa-save');},500);
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

</script>	















