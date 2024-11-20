<?

	$data_group = array('inc_ot'=>'Overtime', 'inc_fix'=>'Fixed income', 'inc_var'=>'Variable income', 'inc_oth'=>'Other income', 'inc_sal'=>'Salary', 'ded_abs'=>'Absence', 'ded_fix'=>'Fixed deductions', 'ded_var'=>'Variable deductions', 'ded_oth'=>'Other deductions', 'ded_leg'=>'Legal deductions / Loans', 'ded_pay'=>'Advanced payments');
	
	$income_group = array('inc_ot'=>'Overtime', 'inc_fix'=>'Fixed income', 'inc_var'=>'Variable income', 'inc_oth'=>'Other income', 'inc_sal'=>'Salary');
	
	$deduct_group = array('ded_abs'=>'Absence', 'ded_fix'=>'Fixed deductions', 'ded_var'=>'Variable deductions', 'ded_oth'=>'Other deductions', 'ded_leg'=>'Legal deductions / Loans', 'ded_pay'=>'Advanced payments');
	
	$tax_base = array('fixpro'=>'Fixed - Pro rated', 'fix'=>'Fixed', 'var'=>'Variable', 'nontax'=>'Non-taxable', 'ssoby'=>'SSO by company', 'taxby'=>'Tax by company');



	if(isset($_GET['cls'])){
		if($_GET['cls'] == '2')
		{
			$condition = '';
		}
		else
		{
			$condition = " classification = '".$_GET['cls']."'";
		}
	}
	else
	{ 
		$condition = ''; 
	}	

	if(isset($_GET['cri'])){

		if($_GET['cri'] == '1')
		{
			$condition2 = " apply = '1'";
		}
		else
		{
			$condition2 = " apply in ('1','0')";
		}
	}
	else
	{ 
		$condition2 = ''; 
	}
	
	if($condition)
	{
		$andValue = ' AND';
	}

	// echo '<pre>';
	// print_r($_SESSION['RGadmin']['filter_group_allowance']);
	// echo '</pre>';
	// die();

	if(!empty($_SESSION['RGadmin']['filter_group_allowance']))
	{
		$explodecond3 = explode('|', $_SESSION['RGadmin']['filter_group_allowance']);
		$result = "'" . implode ( "', '", $explodecond3 ) . "'";
		$condition3 = " groups in (".$result.")"; 
		$andValue2 = ' AND';

	}
	else
	{
		$condition3 = '';
	}




	
	$data = array();


	if( ($_GET['cls'] == '') && ($_GET['cri'] == '' ) )   
	{
		$sqlvalue = "SELECT * FROM rego_allow_deduct  WHERE classification in ('0','1')  AND  apply in ('0', '1') AND  groups in ('inc_ot','inc_fix','inc_var','inc_oth','inc_sal','ded_abs','ded_fix','ded_var','ded_oth','ded_leg','ded_pay') ORDER BY id ASC";
	}
	else
	{
		$sqlvalue = "SELECT * FROM rego_allow_deduct  WHERE ".$condition."  ".$andValue." ".$condition2." ".$andValue2." ".$condition3." ORDER BY id ASC";
	}


	if($res = $dba->query($sqlvalue)){

		while($row = $res->fetch_assoc()){
			// $data[$row['id']] = $row;


	
			if($_GET['cri'] == '2')
			{
				// remove locked checkbox  

				if(in_array($row['id'], array(27,28,29,30,31,32,33,47,48,49,51,56,57,58,59,60))){
				}
				else
				{
					if($row['apply'] == '1')
					{
						$data[$row['id']] = $row;
					}
				}

				
			}			
			else if($_GET['cri'] == '1')
			{
				// remove locked checkbox  

				if(in_array($row['id'], array(27,28,29,30,31,32,33,47,48,49,51,56,57,58,59,60))){
					$data[$row['id']] = $row;
				}
			}			
			else if($_GET['cri'] == '3')
			{
				// remove locked checkbox  for editable

				if(in_array($row['id'], array(27,28,29,30,31,32,33,47,48,49,51,56,57,58,59,60))){
				}
				else
				{
					if($row['apply'] == '1' || $row['apply'] == '0' )
					{
						$data[$row['id']] = $row;
					}
				}

			}
			else
			{
				$data[$row['id']] = $row;
			}

		}
	}


$arrayset = unserialize($_SESSION['RGadmin']['filter_group_allowance_array']);

// if($arrayset[0] != '')
// {
// 	die('1');
// }
// else
// {
// 	die('2');
// }

// echo '<pre>';
// print_r(unserialize($_SESSION['RGadmin']['filter_group_allowance_array']));
// echo '</pre>';

// die();

?>
<style>
	table.dataTable tbody td {
		padding:0 !important;
	}
	table.dataTable thead th.w1 {
		width:40px;
		min-width:40px
	}

	.removeDownArrow {
	    -webkit-appearance: none;
	    -moz-appearance: none;
	    text-indent: 0.01px;
	    text-overflow: '';
	}
</style>
	
	<h2><i class="fa fa-cog fa-lg"></i>&nbsp;&nbsp;<?=$lng['Allowances & Deductions']?> <span style="float:right; display:none; font-style:italic; color:#b00" id="sAlert"><?=$lng['Data is not updated to last changes made']?></span></h2>
	<div class="main">
		
		<input type="hidden" name="hiddengroupfilter" id="hiddengroupfilter" value="<?php echo $_SESSION['RGadmin']['filter_group_allowance'];?>">
		<div id="showTable" style="display:none; margin-bottom:50px">
			<table border="0" style="width:100%; margin-bottom:8px">
				<tr>
					<td style="vertical-align:top;">
						<select id="lockFilter">
							<option selected value="select" ><?=$lng['Select']?></option>
							<option value="0" <?if($_GET['cri'] == 0){ echo 'selected'; }?>><?=$lng['Show all']?></option>
							<option value="1" <?if($_GET['cri'] == 1){ echo 'selected'; }?>><?=$lng['Locked']?></option>
							<option value="3" <?if($_GET['cri'] == 3){ echo 'selected'; }?>><?=$lng['Editable']?></option>
							<option value="2" <?if($_GET['cri'] == 2){ echo 'selected'; }?>><?=$lng['Selected']?></option>
						</select>
					</td>
					<td style="vertical-align:top; padding-left:10px">


						<?php 
						if( ($_GET['cls'] == '') && ($_GET['cri'] == '' )  )   
						{ ?> 

							<select id="classificationFilter">
								<option value="select" ><?=$lng['Select']?></option>
								<option value="&cls=2" selected><?=$lng['All classifications']?></option>
								<option value="&cls=0" ><?=$lng['Allowances']?></option>
								<option value="&cls=1" ><?=$lng['Deductions']?></option>
							</select>

						<?php } else { ?>
							<select id="classificationFilter">
								<option value="select" ><?=$lng['Select']?></option>
								<option value="&cls=2" <?if($_GET['cls'] == 2){ echo 'selected'; }?>><?=$lng['All classifications']?></option>
								<option value="&cls=0" <?if($_GET['cls'] == 0){ echo 'selected'; }?>><?=$lng['Allowances']?></option>
								<option value="&cls=1" <?if($_GET['cls'] == 1){ echo 'selected'; }?>><?=$lng['Deductions']?></option>
							</select>

						<?php } ?>
						
					</td>
					<td style="vertical-align:top; padding-left:10px; width:100%">
<!-- 						<select multiple="multiple" id="groupFilter">
							<? foreach($data_group as $k=>$v){ ?>
							<option <? if($k=='inc_fix' || $k=='inc_var'){echo 'selected';}?> value="<?=$k?>"><?=$v?></option>
							<? } ?>
						</select> -->
						<?php 
						if( ($_GET['cls'] == '') && ($_GET['cri'] == '' ) && ($arrayset[0] == ''))   
						{ ?> 
							<select multiple="multiple" id="groupFilter">
								<? 
									$filtersessionarray = 	unserialize($_SESSION['RGadmin']['filter_group_allowance_array']); 
									foreach($data_group as $k=>$v){  
								 ?>
									<option selected value="<?=$k?>"><?=$v?></option>

								<? } ?>
							</select>


						<?php } else {?>
							<select multiple="multiple" id="groupFilter">
								<? 
									$filtersessionarray = 	unserialize($_SESSION['RGadmin']['filter_group_allowance_array']); 


									foreach($data_group as $k=>$v){  

										if($filtersessionarray[0] == '')
										{ ?>
											<option selected value="<?=$k?>"><?=$v?></option>

									<?  }else {?>

										<option <?php if(in_array($k, $filtersessionarray)) { echo "selected"; } ?> value="<?=$k?>"><?=$v?></option>

								<?php   } } ?>
							</select>
						<?php }?>

					</td>
					<td style="vertical-align:top; padding-left:10px">
						<button class="btn btn-primary" onclick="window.history.go(-1); return false;" type="button"><?=$lng['Go back']?></button>
					</td>
					<? //if($_SESSION['RGadmin']['access']['def_settings']['add'] == 1){ ?>
					<td style="vertical-align:top; padding-left:10px">
						<button id="submitBtn" class="btn btn-primary" type="button"><i class="fa fa-save"></i>&nbsp; <?=$lng['Update']?></button>

					</td>
					<? //} ?>
				</tr>
			</table>
			
			<form id="dataForm">
			<table id="allowDeductTable" class="dataTable inputs nowrap hoverable selectable" border="0">
				<thead>
					<tr>
						<th colspan="8"></th>
						<th class="tac" colspan="8"><?=$lng['Add to total for calculations']?></th>
						<th></th>
						<th class="tac" colspan="4"><?=$lng['Calculation base']?></th>
						<th class="tac"><?=$lng['PND form']?></th>
					</tr>
					<tr>
						<th class="tac"><?=$lng['Apply']?></th>
						<th data-visible="false"></th>
						<th><?=$lng['Thai description']?></th>
						<th><?=$lng['English description']?></th>
						<th><?=$lng['Classification']?></th>
						<th data-visible="false"></th>
						<th style="width: 100px;"><?=$lng['Group']?></th>
						<th data-visible="false"></th>
						<th class="tac w1"><?=$lng['Earnings']?></th>
						<th class="tac w1"><?=$lng['Deductions']?></th>
						<th class="tac w1"><?=str_replace('/', '/<br>', $lng['Hour rate/Daily rate']) ?></th>
						<th class="tac w1"><?=$lng['PND1']?></th>
						<th class="tac w1" style="line-height:110%"><?=str_replace(' ', '<br>', $lng['Tax incom'])?></th>
						<th class="tac w1"><?=$lng['SSO']?></th>
						<th class="tac w1"><?=$lng['PVF']?></th>
						<th class="tac w1"><?=$lng['PSF']?></th>
						<th><?=$lng['Tax Base']?></th>
						<th class="tac w1" style="line-height:110%">Manual<br>Emp. Reg.</th>
						<th class="tac w1" style="line-height:110%">Fixed <br>Emp. Reg.</th>
						<th class="tac w1" style="line-height:110%">Manual<br>Attendance</th>
						<th class="tac w1" style="line-height:110%">Rates</th>
						<th class="tac w1" style="line-height:110%"><?=$lng['Income base']?></th>
					</tr>
				</thead>
				<tbody>
					<? foreach($data as $key=>$val){ 
							$readonly = ''; $lock = 0;
							if(in_array($key, array(27,28,29,30,31,32,33,47,48,49,51,56,57,58,59,60))){
								$readonly = 'readonly'; $lock = 1;
							}
					?>
					<tr>
						<td class="tac vam" style="vertical-align:middle; width:1px">
							<input name="data[<?=$key?>][id]" type="hidden" value="<?=$key?>" />
							<? if($lock){ ?>
							<input class="locked" name="data[<?=$key?>][apply]" type="hidden" value="1" />
							<label><input disabled checked name="data[<?=$key?>][apply]" type="checkbox" value="1" class="checkbox-custom-black-2 checkbox notxt" /></label>
							<? }else{ ?>
							<input name="data[<?=$key?>][apply]" type="hidden" value="0" />
							<label><input <? if($val['apply'] == 1){echo 'checked';} ?> name="data[<?=$key?>][apply]" type="checkbox" value="1" class="checkbox notxt checkbox-custom-blue-2 checkbox-blue-custom-white" /></label>
							<? } ?>
						</td>
						<td><? if($lock){ echo 'Locked';}else{echo 'Edit';} if($val['apply']){echo ' Select';}?></td>
						<td><input <?=$readonly?> placeholder="__" name="data[<?=$key?>][th]" type="text" value="<?=$val['th']?>" /></td>
						<td><input <?=$readonly?> placeholder="__" name="data[<?=$key?>][en]" type="text" value="<?=$val['en']?>" /></td>
						<td>
							<? if($lock){ ?>

								<select class="removeDownArrow disabledropdown selClassification" name="data[<?=$key?>][classification]" style="min-width:auto; width:100%; background:transparent">
									<option <? if(!$val['classification']){echo "selected ";} ?> value="0"><?=$lng['Allowances']?></option>
									<option <? if($val['classification']){echo "selected ";} ?> value="1"><?=$lng['Deductions']?></option>
								</select>

							<?php } else { ?>

								<select class="selClassification" name="data[<?=$key?>][classification]" style="min-width:auto; width:100%; background:transparent">
									<option <? if(!$val['classification']){echo "selected ";} ?> value="0"><?=$lng['Allowances']?></option>
									<option <? if($val['classification']){echo "selected ";} ?> value="1"><?=$lng['Deductions']?></option>
								</select>


							<?php } ?>
							
						</td>
						<td><? if($val['classification']){ echo 'deduct';}else{echo 'income';}?></td>
						<td>
							<? if(!$val['classification']){
								$data_group = $income_group;
							}else
							{
								$data_group = $deduct_group;
							}
							?>

							<?php if($lock){ ?>

									<select class="removeDownArrow disabledropdown  selGroup" name="data[<?=$key?>][groups]" style="min-width: 190px !important; background:transparent">
										<? foreach($data_group as $k=>$v){ ?>
										<option <? if($k == $val['groups']){echo "selected ";} ?> value="<?=$k?>"><?=$v?></option>
										<? } ?>
									</select>


							<?php } else {?> 

								<select class="selGroup" name="data[<?=$key?>][groups]" style="min-width: 190px !important; background:transparent">
									<? foreach($data_group as $k=>$v){ ?>
									<option <? if($k == $val['groups']){echo "selected ";} ?> value="<?=$k?>"><?=$v?></option>
									<? } ?>
								</select>


							<?php  }?>
						
						</td>
						<td><?=$val['groups']?></td>
						
						<td class="tac vam">

							<?php if($lock){ ?>

								<input name="data[<?=$key?>][earnings]" type="hidden" value="0" />
								<label><input <? if($val['earnings']){echo 'checked';} ?> name="data[<?=$key?>][earnings]" type="checkbox" value="1" class="stopCheckbox checkbox notxt selEarnings checkbox-custom-black-2 checkbox-blue-custom-white" /></label>

							<?php } else { ?>

								<input name="data[<?=$key?>][earnings]" type="hidden" value="0" />
								<label><input <? if($val['earnings']){echo 'checked';} ?> name="data[<?=$key?>][earnings]" type="checkbox" value="1" class="checkbox notxt selEarnings checkbox-custom-blue-2 checkbox-blue-custom-white" /></label>

							<?php }?>
							
						</td>
						
						<td class="tac vam">


							<?php if($lock){ ?>

							<input name="data[<?=$key?>][deductions]" type="hidden" value="0" />
							<? if(in_array($key, array(27,28))){ ?>
							<label><input disabled type="checkbox" class="checkbox notxt checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
							<? }else{ ?>
							<label><input <? if($val['deductions']){echo 'checked';} ?> name="data[<?=$key?>][deductions]" type="checkbox" value="1" class="stopCheckbox checkbox notxt selDeductions checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
							<? } ?>

						<?php } else {?>

							<input name="data[<?=$key?>][deductions]" type="hidden" value="0" />
							<? if(in_array($key, array(27,28))){ ?>
							<label><input disabled type="checkbox" class="checkbox notxt checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
							<? }else{ ?>
							<label><input <? if($val['deductions']){echo 'checked';} ?> name="data[<?=$key?>][deductions]" type="checkbox" value="1" class="checkbox notxt selDeductions checkbox-custom-blue-2 checkbox-blue-custom-white" /></label>
							<? } ?>


						<?php } ?>
						</td>
						
						<td class="tac vam">

							<?php if($lock){ ?>

							<input name="data[<?=$key?>][hour_daily_rate]" type="hidden" value="0" />
							<label><input <? if($val['hour_daily_rate']){echo 'checked';} ?> name="data[<?=$key?>][hour_daily_rate]" type="checkbox" value="1" class="stopCheckbox checkbox notxt checkbox-custom-black-2 checkbox-blue-custom-white" /></label>

						<?php }else{ ?>

							<input name="data[<?=$key?>][hour_daily_rate]" type="hidden" value="0" />
							<label><input <? if($val['hour_daily_rate']){echo 'checked';} ?> name="data[<?=$key?>][hour_daily_rate]" type="checkbox" value="1" class="checkbox notxt checkbox-custom-blue-2 checkbox-blue-custom-white" /></label>

						</td><?php } ?>
						</td>

						<td class="tac vam">

							<?php if($lock){ ?>

								<input name="data[<?=$key?>][pnd1]" type="hidden" value="0" />
								<label><input <? if($val['pnd1']){echo 'checked';} ?> name="data[<?=$key?>][pnd1]" type="checkbox" value="1" class="stopCheckbox checkbox notxt checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
							<?php } else {?>

								<input name="data[<?=$key?>][pnd1]" type="hidden" value="0" />
								<label><input <? if($val['pnd1']){echo 'checked';} ?> name="data[<?=$key?>][pnd1]" type="checkbox" value="1" class="checkbox notxt checkbox-custom-blue-2 checkbox-blue-custom-white" /></label>

							<?php } ?>
						</td>


						<td class="tac vam">

							<?php if($lock){ ?>

								<input name="data[<?=$key?>][tax_income]" type="hidden" value="0" />
								<? if(in_array($key, array(27,28))){ ?>
								<label><input disabled type="checkbox" class="checkbox notxt checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
								<? }else{ ?>
								<label><input <? if($val['tax_income']){echo 'checked';} ?> name="data[<?=$key?>][tax_income]" type="checkbox" value="1" class="stopCheckbox checkbox notxt checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
								<? } ?>

							<?php }else{ ?>

								<input name="data[<?=$key?>][tax_income]" type="hidden" value="0" />
								<? if(in_array($key, array(27,28))){ ?>
								<label><input disabled type="checkbox" class="checkbox notxt checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
								<? }else{ ?>
								<label><input <? if($val['tax_income']){echo 'checked';} ?> name="data[<?=$key?>][tax_income]" type="checkbox" value="1" class="checkbox notxt checkbox-custom-blue-2 checkbox-blue-custom-white" /></label>
								<? } ?>

							<?php } ?>

						
						</td>
						<td class="tac vam">

							<?php if($lock){ ?>

								<input name="data[<?=$key?>][sso]" type="hidden" value="0" />
								<? if(in_array($key, array(27,28))){ ?>
								<label><input disabled type="checkbox" class="checkbox notxt checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
								<? }else{ ?>
								<label><input <? if($val['sso']){echo 'checked';} ?> name="data[<?=$key?>][sso]" type="checkbox" value="1" class="stopCheckbox checkbox notxt checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
								<? } ?>

							<?php } else {?>

								<input name="data[<?=$key?>][sso]" type="hidden" value="0" />
								<? if(in_array($key, array(27,28))){ ?>
								<label><input disabled type="checkbox" class="checkbox notxt checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
								<? }else{ ?>
								<label><input <? if($val['sso']){echo 'checked';} ?> name="data[<?=$key?>][sso]" type="checkbox" value="1" class="checkbox notxt checkbox-custom-blue-2 checkbox-blue-custom-white" /></label>
								<? } ?>

							<?php } ?>
							
						</td>
						<td class="tac vam">
							<?php if($lock){ ?>

							<input name="data[<?=$key?>][pvf]" type="hidden" value="0" />
							<? if(in_array($key, array(27,28))){ ?>
							<label><input disabled type="checkbox" class="checkbox notxt checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
							<? }else{ ?>
							<label><input <? if($val['pvf']){echo 'checked';} ?> name="data[<?=$key?>][pvf]" type="checkbox" value="1" class="stopCheckbox checkbox notxt checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
							<? } ?>

						<?php } else {?>
								<input name="data[<?=$key?>][pvf]" type="hidden" value="0" />
								<? if(in_array($key, array(27,28))){ ?>
								<label><input disabled type="checkbox" class="checkbox notxt checkbox-custom-blue-2 checkbox-blue-custom-white" /></label>
								<? }else{ ?>
								<label><input <? if($val['pvf']){echo 'checked';} ?> name="data[<?=$key?>][pvf]" type="checkbox" value="1" class="checkbox notxt checkbox-custom-blue-2 checkbox-blue-custom-white" /></label>
								<? } ?>
						<?php } ?>
						</td>
						<td class="tac vam">

							<?php if($lock){ ?>

							<input name="data[<?=$key?>][psf]" type="hidden" value="0" />
							<? if(in_array($key, array(27,28))){ ?>
							<label><input disabled type="checkbox" class="checkbox notxt checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
							<? }else{ ?>
							<label><input <? if($val['psf']){echo 'checked';} ?> name="data[<?=$key?>][psf]" type="checkbox" value="1" class="stopCheckbox checkbox notxt checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
							<? } ?>

						<?php } else {?>

							<input name="data[<?=$key?>][psf]" type="hidden" value="0" />
							<? if(in_array($key, array(27,28))){ ?>
							<label><input disabled type="checkbox" class="checkbox notxt checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
							<? }else{ ?>
							<label><input <? if($val['psf']){echo 'checked';} ?> name="data[<?=$key?>][psf]" type="checkbox" value="1" class="checkbox notxt checkbox-custom-blue-2 checkbox-blue-custom-white" /></label>
							<? } ?>


						<?php } ?>
						</td>
						<td class="tac vam">

							<?php if($lock){ ?>

							<select name="data[<?=$key?>][tax_base]"  style="width:auto; min-width:100%; background:transparent" class="removeDownArrow disabledropdown">
								<? foreach($tax_base as $k=>$v){ ?>
								<option <? if($k == $val['tax_base']){echo "selected ";} ?> value="<?=$k?>"><?=$v?></option>
								<? } ?>
							</select>

						<?php } else{?>

							<select name="data[<?=$key?>][tax_base]"  style="width:auto; min-width:100%; background:transparent">
								<? foreach($tax_base as $k=>$v){ ?>
								<option <? if($k == $val['tax_base']){echo "selected ";} ?> value="<?=$k?>"><?=$v?></option>
								<? } ?>
							</select>


						<?php } ?>
						</td>
						<td class="tac vam">

							<?php if($lock){ ?>

								<input name="data[<?=$key?>][man_emp]" type="hidden" value="0" />
								<label><input <? if($val['man_emp']){echo 'checked';} ?> name="data[<?=$key?>][man_emp]" type="checkbox" class="stopCheckbox checkbox notxt checkbox-custom-black-2 checkbox-blue-custom-white" value="1" /></label>

							<?php } else{?>

								<input name="data[<?=$key?>][man_emp]" type="hidden" value="0" />
								<label><input <? if($val['man_emp']){echo 'checked';} ?> name="data[<?=$key?>][man_emp]" type="checkbox" class="checkbox notxt checkbox-custom-blue-2 checkbox-blue-custom-white" value="1" /></label>

							<?php } ?>
						
						</td>
						<td class="tac vam">
							<?php if($lock){ ?>

								<input name="data[<?=$key?>][fixed_calc]" type="hidden" value="0" />
								<label><input <? if($val['fixed_calc']){echo 'checked';} ?> name="data[<?=$key?>][fixed_calc]" type="checkbox" class=" stopCheckbox checkbox notxt checkbox-custom-black-2 checkbox-blue-custom-white" value="1" /></label>


							<?php } else {?>

								<input name="data[<?=$key?>][fixed_calc]" type="hidden" value="0" />
								<label><input <? if($val['fixed_calc']){echo 'checked';} ?> name="data[<?=$key?>][fixed_calc]" type="checkbox" class="stopCheckbox checkbox notxt checkbox-custom-black-2 checkbox-blue-custom-white" value="1" /></label>

							<?php } ?>
							
						</td>
						<td class="tac vam">
							<?php if($lock){ ?>

								<input name="data[<?=$key?>][man_att]" type="hidden" value="0" />
								<label><input <? if($val['man_att']){echo 'checked';} ?> name="data[<?=$key?>][man_att]" type="checkbox" class=" stopCheckbox checkbox notxt checkbox-custom-black-2 checkbox-blue-custom-white" value="1" /></label>


							<?php } else {?>

								<input name="data[<?=$key?>][man_att]" type="hidden" value="0" />
								<label><input <? if($val['man_att']){echo 'checked';} ?> name="data[<?=$key?>][man_att]" type="checkbox" class="checkbox notxt checkbox-custom-blue-2 checkbox-blue-custom-white" value="1" /></label>

							<?php } ?>
							
						</td>
						<td class="tac vam">

							<?php if($lock){ ?>

								<input name="data[<?=$key?>][comp_reduct]" type="hidden" value="0" />
								<label><input <? if($val['comp_reduct']){echo 'checked';} ?> name="data[<?=$key?>][comp_reduct]" type="checkbox" class="stopCheckbox checkbox notxt checkbox-custom-black-2 checkbox-blue-custom-white" value="1" /></label>

							<?php } else {?>

								<input name="data[<?=$key?>][comp_reduct]" type="hidden" value="0" />
								<label><input <? if($val['comp_reduct']){echo 'checked';} ?> name="data[<?=$key?>][comp_reduct]" type="checkbox" class="checkbox notxt checkbox-custom-blue-2 checkbox-blue-custom-white" value="1" /></label>

							<?php } ?>
							
						</td>
						<td>
							<?php if($lock){ ?>

								<select  name="data[<?=$key?>][income_base]" style="min-width: 190px !important; background:transparent;" class="removeDownArrow disabledropdown">
									<? foreach($income_section as $k=>$v){ ?>
									<option <? if($k == $val['income_base']){echo "selected ";} ?> value="<?=$k?>"><?=$v?></option>
									<? } ?>
								</select>

							<?php } else {?>

								<select  name="data[<?=$key?>][income_base]" style="min-width: 190px !important; background:transparent;">
									<? foreach($income_section as $k=>$v){ ?>
									<option <? if($k == $val['income_base']){echo "selected ";} ?> value="<?=$k?>"><?=$v?></option>
									<? } ?>
								</select>

							<?php } ?>
						
						</td>

					</tr>
					<? } ?>
				</tbody>
			</table>
			</form>
			<div style="height:10px"></div>
			<button class="btn btn-primary btn-xs" type="button" id="addDatarow"><i class="fa fa-plus"></i>&nbsp;&nbsp;<?=$lng['Add row']?></button>
			
			<div id="dump"></div>
			
		</div>

	</div>
	
<script>

	$(document).ready(function() {

		// CODE TO DISABLE DROPDOWN DROP MENU 
		$('.disabledropdown').on('mousedown', function(e) {
		   e.preventDefault();
		   this.blur();
		   window.focus();
		});

		// CODE TO STOP SELECTING CHECKBOX

		$('.stopCheckbox').on('click', function(event) {
		    event.preventDefault();
		    event.stopPropagation();
		    return false;
		});


		
		var income_group = <?=json_encode($income_group)?>;
		var deduct_group = <?=json_encode($deduct_group)?>;
		
		var mySelect = $('#groupFilter').SumoSelect({
			csvDispCount:1,
			outputAsCSV : true,
			showTitle : false,
			selectAll: true,
			okCancelInMulti:false,
			placeholder: 'Select Groups<? //=$lng['Show Hide Columns']?>',
			captionFormat: 'Select Groups',
			captionFormatAllSelected: 'Select Groups',
			triggerChangeCombined: true,

		});
		$(".SumoSelect li").bind('click.check', function(event) {
			var output = "'"+$('#groupFilter').val()+"'";
			output = output.replace(/,/g, "|");
			output = output.replace(/'/g, "");
			if(output == ''){output = 'xxx'}
			//alert(output); return false;
			$('#hiddengroupfilter').val(output);
    })		




  //   	$('#groupFilter').on('change',function(e){

    	


		// });

		    $('select#groupFilter').on('sumo:closing', function(o) {

				var hiddengroupfilter = $('#hiddengroupfilter').val();
				var getlockfiltervalue = $('#lockFilter').val();
				var classificationFilter = $('#classificationFilter').val();

				// run ajax here 

				$.ajax({
					url: "def_settings/ajax/def/update_filter_session.php",
					type: 'POST',
					data: {hiddengroupfilter: hiddengroupfilter},
					success: function(result){
						if(result)
						{
							window.location.href = 'index.php?mn=701'+classificationFilter+'&cri='+getlockfiltervalue;
						}
					},
				});
			});  



		
		var dtable = $('#allowDeductTable').DataTable({
			scrollY:       true,//600,
			scrollX:       true,
			fixedColumns:  false,
			lengthChange:  false,
			searching: 		false,
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
					dtable.columns([7]).search("inc_fix|inc_var",true,false).draw();
				},10);
			}
		});

		// $('#lockFilter').on('change', function(){
		// 	dtable.columns([1]).search($(this).val()).draw();
		// })
		// $('#classificationFilter').on('change', function(){
		// 	dtable.columns([5]).search($(this).val()).draw();
		// })

		$('#lockFilter').on('change', function(){


    		
    		var hiddengroupfilter = $('#hiddengroupfilter').val();
    		var getlockfiltervalue = $('#lockFilter').val();
    		var classificationFilter = $('#classificationFilter').val();

    		// run ajax here 

    		$.ajax({
				url: "def_settings/ajax/def/update_filter_session.php",
				type: 'POST',
				data: {hiddengroupfilter: hiddengroupfilter},
				success: function(result){
					if(result)
					{
						window.location.href = 'index.php?mn=701'+classificationFilter+'&cri='+getlockfiltervalue;
					}
				},
			});


			// $('#classificationFilter').val('select');
			// $("#groupFilter option:selected").removeAttr("selected");
			// $("ul.options li").removeClass("selected");
		})
		$('#classificationFilter').on('change', function(){


    		var hiddengroupfilter = $('#hiddengroupfilter').val();
    		var getlockfiltervalue = $('#lockFilter').val();
    		var classificationFilter = $('#classificationFilter').val();

    		// run ajax here 

    		$.ajax({
				url: "def_settings/ajax/def/update_filter_session.php",
				type: 'POST',
				data: {hiddengroupfilter: hiddengroupfilter},
				success: function(result){
					if(result)
					{
						window.location.href = 'index.php?mn=701'+classificationFilter+'&cri='+getlockfiltervalue;
					}
				},
			});

			
			// $("#groupFilter option:selected").removeAttr("selected");
			// $("ul.options li").removeClass("selected");
		})

		
		$(document).on('change', '.selClassification', function(){
			var group;
			if(this.value == 1){ group = deduct_group }else{ group = income_group };
			var selGroup = $(this).closest('tr').find(".selGroup");
			selGroup.empty();
			selGroup.append($("<option />").val('').text('Select'));
			$.each(group, function(i, v) {
					selGroup.append($("<option />").val(i).text(v));
			});			
		})
		
		$(document).on('change', '.selEarnings', function(){
			if($(this).is(':checked')){ 
				$(this).closest('tr').find(".selDeductions").prop('checked', false); 
			}else{
				//$(this).closest('tr').find(".selDeductions").prop('checked', true); 
			};
		})
		$(document).on('change', '.selDeductions', function(){
			if($(this).is(':checked')){ 
				$(this).closest('tr').find(".selEarnings").prop('checked', false); 
			}else{
				//$(this).closest('tr').find(".selEarnings").prop('checked', true); 
			};
		})
		
		var row = <?=json_encode(count($data)+1)?>;
		$("#addDatarow").click(function(){
			var addrow = '<tr>'+
				'<td class="tac" style="vertical-align:middle; width:1px">'+
					'<input name="data['+row+'][id]" type="hidden" value="'+row+'" />'+
					'<input name="data['+row+'][apply]" type="hidden" value="0" />'+
					'<label><input name="data['+row+'][apply]" type="checkbox" value="1" class="checkbox notxt checkbox-custom-blue-2 checkbox-blue-custom-white" /></label>'+
				'</td>'+
				'<td><input placeholder="__" name="data['+row+'][th]" type="text" /></td>'+
				'<td><input placeholder="__" name="data['+row+'][en]" type="text" /></td>'+
				'<td>'+
					'<select class="selClassification" name="data['+row+'][classification]" style="min-width:auto; width:100%; background:transparent">'+
						'<option disabled value=""><?=$lng['Select']?></option>'+
						'<option value="0"><?=$lng['Income']?></option>'+
						'<option value="1"><?=$lng['Deductions']?></option>'+
					'</select>'+
				'<td>'+
					'<select class="selGroup" name="data['+row+'][groups]" style="min-width:auto; width:100%; background:transparent">'+
							'<? foreach($data_group as $k=>$v){ ?>'+
							'<option value="<?=$k?>"><?=$v?></option>'+
							'<? } ?>'+
					'</select>'+
				'<input placeholder="__" name="data['+row+'][section]" type="hidden" value="0">'+
				'<td class="tac vam">'+
					'<input name="data['+row+'][earnings]" type="hidden" value="0" />'+
					'<label><input name="data['+row+'][earnings]" type="checkbox" value="1" class="checkbox notxt selEarnings checkbox-custom-blue-2 checkbox-blue-custom-white" /></label>'+
				'</td>'+
				'<td class="tac vam">'+
					'<input name="data['+row+'][deductions]" type="hidden" value="0" />'+
					'<label><input name="data['+row+'][deductions]" type="checkbox" value="1" class="checkbox notxt selDeductions checkbox-custom-blue-2 checkbox-blue-custom-white" /></label>'+
				'</td>'+
				'<td class="tac vam">'+
					'<input name="data['+row+'][hour_daily_rate]" type="hidden" value="0" />'+
					'<label><input name="data['+row+'][hour_daily_rate]" type="checkbox" value="1" class="checkbox notxt checkbox-custom-blue-2 checkbox-blue-custom-white" /></label>'+
				'</td>'+
				'<td class="tac vam">'+
					'<input name="data['+row+'][pnd1]" type="hidden" value="0" />'+
					'<label><input name="data['+row+'][pnd1]" type="checkbox" value="1" class="checkbox notxt checkbox-custom-blue-2 checkbox-blue-custom-white" /></label>'+
				'</td>'+
				'<td class="tac vam">'+
					'<input name="data['+row+'][tax_income]" type="hidden" value="0" />'+
					'<label><input name="data['+row+'][tax_income]" type="checkbox" value="1" class="checkbox notxt checkbox-custom-blue-2 checkbox-blue-custom-white" /></label>'+
				'</td>'+
				'<td class="tac vam">'+
					'<input name="data['+row+'][sso]" type="hidden" value="0" />'+
					'<label><input name="data['+row+'][sso]" type="checkbox" value="1" class="checkbox notxt checkbox-custom-blue-2 checkbox-blue-custom-white" /></label>'+
				'</td>'+
				'<td class="tac vam">'+
					'<input name="data['+row+'][pvf]" type="hidden" value="0" />'+
					'<label><input name="data['+row+'][pvf]" type="checkbox" value="1" class="checkbox notxt checkbox-custom-blue-2 checkbox-blue-custom-white" /></label>'+
				'</td>'+
				'<td class="tac vam">'+
					'<input name="data['+row+'][psf]" type="hidden" value="0" />'+
					'<label><input name="data['+row+'][psf]" type="checkbox" value="1" class="checkbox notxt checkbox-custom-blue-2 checkbox-blue-custom-white" /></label>'+
				'</td>'+
				'<td class="tac vam">'+
					'<select name="data['+row+'][tax_base]"  style="width:auto; min-width:100%; background:transparent">'+
						'<? foreach($tax_base as $k=>$v){ ?>'+
						'<option value="<?=$k?>"><?=$v?></option>'+
						'<? } ?>'+
					'</select>'+
				'</td>'+
				'<td class="tac vam">'+
					'<input name="data['+row+'][man_emp]" type="hidden" value="0" />'+
					'<label><input name="data['+row+'][man_emp]" type="checkbox" class="checkbox notxt checkbox-custom-blue-2 checkbox-blue-custom-white" value="1" /></label>'+
				'</td>'+
				'<td class="tac vam">'+
					'<input name="data['+row+'][man_att]" type="hidden" value="0" />'+
					'<label><input name="data['+row+'][man_att]" type="checkbox" class="checkbox notxt checkbox-custom-blue-2 checkbox-blue-custom-white" value="1" /></label>'+
				'</td>'+
				'<td class="tac vam">'+
					'<input name="data['+row+'][comp_reduct]" type="hidden" value="0" />'+
					'<label><input name="data['+row+'][comp_reduct]" type="checkbox" class="checkbox notxt checkbox-custom-blue-2 checkbox-blue-custom-white" value="1" /></label>'+
				'</td>'+
				'<td class="tac vam">'+
					'<select name="data['+row+'][income_base]"  style="width:auto; min-width:100%; background:transparent">'+
						'<? foreach($income_section as $k=>$v){ ?>'+
						'<option value="<?=$k?>"><?=$v?></option>'+
						'<? } ?>'+
					'</select>'+
				'</td>'+
			'</tr>';
			
			$("#allowDeductTable tr:last").after(addrow);
			row ++;
		});
		
		
		$('#submitBtn').on('click', function(){
			$("#dataForm").submit();
		})
		
		$("#dataForm").submit(function(e){ 
			e.preventDefault();
			$("#submitBtn i").removeClass('fa-save').addClass('fa-refresh fa-spin');
			var data = $(this).serialize();
			$.ajax({
				url: "def_settings/ajax/def/update_allow_deduct.php",
				type: 'POST',
				data: data,
				success: function(result){
					//$('#dump').html(result); return false;
					if(result == 'success'){
						$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp;Data updated successfully',
							duration: 2,
							callback: function(value){
								location.reload();
							}
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
					},500);
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













