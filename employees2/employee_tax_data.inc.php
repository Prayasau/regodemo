<div class="tab-content-left" style="height: auto !important;">
	<table class="basicTable lefttbl">
		<thead>
			<tr>
				<th colspan="4"><?=strtoupper($lng['Calculated'].' '. $lng['Tax'].' '.$lng['Deduction'])?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th colspan="4" class="text-danger text-left"><?=$lng['Calculated by system from last payroll calculation']?></th>
			</tr>
			<tr style="line-height:100%">
				<th class="tal tax-table"><?=$lng['Description']?></th>
				<th class="tal" style="min-width:60px"><?=$lng['Calc. on']?></th>
				<th class="tal" style="min-width:90px"><?=$lng['THB']?></th>
				<th class="tal hide-tax"><?=$lng['Info']?></th>
			</tr>
			<tr>
				<th><?=$lng['Standard deduction']?></th>
				<td class="tac">
					<? $calc_on_sd = isset($data['calc_on_sd']) ? $data['calc_on_sd'] : $tax_calc_on['calc_on_sd']; ?>
					<input name="calc_on_sd" type="hidden" value="0">
					<input type="checkbox" onclick="stDeducChkbox(this)" name="calc_on_sd" value="1" <? if($calc_on_sd == 1){echo 'checked="checked"';}?>>
				</td>
				<td>
					<?if($calc_on_sd == 1){ $bgclrst = 'background-color:#fff;pointer-events:none;';}?>
					<input tabindex="-1" style="color:#999;<?=$bgclrst;?>" class="tar nofocus" type="text" name="tax_standard_deduction" id="standard_deduction" value="<?=isset($data['tax_standard_deduction']) ? $data['tax_standard_deduction'] : $tax_thb['tax_standard_deduction'] ?>">
				</td>
				<td class="info" style="width:80%;color:#a00" id="info_standard_deduction">
					<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['standard_deduction']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span ><?=mb_strimwidth($tax_info['standard_deduction'], 0, 30, "...");?></span>
				</td>
			</tr>
			<tr>
				<th><?=$lng['Personal care']?></th>
				<td class="tac">
					<? $calc_on_pc = isset($data['calc_on_pc']) ? $data['calc_on_pc'] : $tax_calc_on['calc_on_pc']; ?>
					<input type="hidden" name="calc_on_pc" value="0">
					<input type="checkbox" onclick="PersoCareChkbox(this)" name="calc_on_pc" value="1" <?if($calc_on_pc == 1){echo 'checked="checked"';}?>>
				</td>
				<td>
					<?if($calc_on_pc == 1){ $bgclrpc = 'background-color:#fff;pointer-events:none;';}?>
					<input tabindex="-1" style="color:#999;<?=$bgclrpc;?>"  class="tar nofocus" type="text" name="tax_personal_allowance" id="personal_allowance" value="<?=isset($data['tax_personal_allowance']) ? $data['tax_personal_allowance'] : $tax_thb['tax_personal_allowance'] ?>">
				</td>
				<td class="info pad410" id="info_personal_allowance">
					<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['personal_allowance']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['personal_allowance'], 0, 30, "...");?></span>
				</td>
			</tr>
			<tr>
				<th><?=$lng['Provident fund']?></th>
				<td class="tac">
					<? $calc_on_pf = isset($data['calc_on_pf']) ? $data['calc_on_pf'] : $tax_calc_on['calc_on_pf']; ?>
					<input type="hidden" name="calc_on_pf" value="0">
					<input type="checkbox" onclick="ProFundChkbox(this)" name="calc_on_pf" value="1" <?if($calc_on_pf == 1){echo 'checked="checked"';}?>>
				</td>
				<td>
					<?if($calc_on_pf == 1){ $bgclrpf = 'background-color:#fff;pointer-events:none;';}?>
					<input tabindex="-1" style="color:#999;<?=$bgclrpf;?>"  class="tar nofocus" type="text" id="tax_allow_pvf" name="tax_allow_pvf" value="<?=isset($data['tax_allow_pvf']) ? $data['tax_allow_pvf'] : $tax_thb['tax_allow_pvf'] ?>">
				</td>
				<td class="info" id="info_provident_fund_allow">
					<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['provident_fund_allowance']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['provident_fund_allowance'], 0, 20, "...");?></span>
				</td>
			</tr>
			<tr>
				<th><?=$lng['Social Security Fund']?></th>
				<td class="tac">
					<? $calc_on_ssf = isset($data['calc_on_ssf']) ? $data['calc_on_ssf'] : $tax_calc_on['calc_on_ssf']; ?>
					<input type="hidden" name="calc_on_ssf" value="0">
					<input type="checkbox" onclick="SSFChkbox(this)" name="calc_on_ssf" value="1" <?if($calc_on_ssf == 1){echo 'checked="checked"';}?>>
				</td>
				<td>
					<?if($calc_on_ssf == 1){ $bgclrssf = 'background-color:#fff;pointer-events:none;';}?>
					<input style="color:#999;<?=$bgclrssf;?>"  class="tar nofocus" name="tax_allow_sso" id="tax_allow_sso" type="text" value="<?=isset($data['tax_allow_sso']) ? $data['tax_allow_sso'] : $tax_thb['tax_allow_sso'] ?>">
				</td>
				<td class="info" id="info_ltf_deductionss">
					<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['social_security_fund']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['social_security_fund'], 0, 30, "...");?></span>
				</td>
			</tr>
			
		</tbody>
	</table>
</div>

<div class="tab-content-right" style="height: auto !important;">
	<table class="basicTable inputs">
		<thead>
			<tr>
				<th colspan="4" class="text-danger"><?=strtoupper($lng['Total'].' '. $lng['Tax'].' '.$lng['Deduction'])?><span class="float-right ml-1"> THB</span><span class="float-right" id="total_deductions"><?=number_format($data['total_deductions'],2)?></span></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th colspan="4" class="text-left" style="color:#058"><?=$lng['CHECK TOTALS FOR TAX DEDUCTIONS']?></th>
			</tr>
			<tr>
				<th colspan="4" class="text-danger text-left"><?=$lng['Some tax deductions sum can not exceed a maximum amount']?></th>
			</tr>
			<tr>
				<th colspan="2">Own Health Insurance & Own life Insurance & <br>Life insurance spouse < 100,000 THB</th>
				<td class="tac" style="min-width:90px">
					<input tabindex="-1" readonly class="tar nofocus" type="text" id="total_own_health_life" value="<?php //=$data['total_own_health_life']?>">
				</td>
				<td class="tac" id="info_health_life_insurance" style="min-width:50px">
					<!-- <i style="color:#090" class="fa fa-check fa-lg"></i> -->
				</td>
			</tr>
			<tr>
				<th colspan="2">Sum of Pension Fund, Provident Fund, NSF, RMF < 500,000</th>
				<td class="tac" style="min-width:90px">
					<input tabindex="-1" readonly class="tar nofocus" type="text" id="subtotal2" value="<? //=$data['subtotal2']?>">
				</td>
				<td class="tac" id="info_subtotal2" style="min-width:50px">
					<!-- <i style="color:#090" class="fa fa-check fa-lg"></i> -->
				</td>
			</tr>
		</tbody>
	</table>
</div>

<table class="basicTable editTable mt-2" id="taxTable" border="0">
	<thead>
		<tr>
			<th class="tal" colspan="5"><?=strtoupper($lng['Other'].' '. $lng['Tax'].' '.$lng['Deduction'])?></th>
			<th class="tal text-danger" colspan="5"><?=strtoupper($lng['Total'].' '.$lng['Other'].' '. $lng['Tax'].' '.$lng['Deduction'])?>  <span class="float-right ml-1"> THB</span><span class="float-right" id="emp_tax_deductions"><?=number_format($data['emp_tax_deductions'],2)?></span>
				<input type="hidden" name="emp_tax_deductions" value="" />
			</th>
		</tr>
		<tr>
			<th class="tal"><?=$lng['Description']?></th>
			<th class="tal"><?=$lng['Unit']?></th>
			<th class="tal"><?=$lng['Number']?></th>
			<th class="tal"><?=$lng['THB']?></th>
			<th class="tal"><?=$lng['Info']?></th>

			<th class="tal"><?=$lng['Description']?></th>
			<th class="tal"><?=$lng['Unit']?></th>
			<th class="tal"><?=$lng['Number']?></th>
			<th class="tal"><?=$lng['THB']?></th>
			<th class="tal"><?=$lng['Info']?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th><?=$tax_description['spouse_allow']?></th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px">
				<select class="calcTax" name="tax_spouse" id="spouse_allow">
					<?php foreach($yesno as $k=>$v){
							echo '<option ';
							if(isset($data['tax_spouse'])){ if(strtoupper($data['tax_spouse'])==$k){echo 'selected';} }else{ if($tax_number['tax_spouse'] == $k){echo 'selected';} }
							//if(strtoupper($data['tax_spouse'])==$k){echo 'selected';}
							echo ' value="'.$k.'">'.$v.'</option>';
					} ?>
				</select>
			</td>
			<td style="width:90px"><input tabindex="-1" readonly class="tar nofocus" type="text" name="tax_allow_spouse" id="spouse_allowance" placeholder="..." value="<?=isset($data['tax_allow_spouse']) ? $data['tax_allow_spouse'] : $tax_thb['tax_allow_spouse'] ?>"></td>
			<td class="info pad410">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['spouse_allowance']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['spouse_allowance'], 0, 7, "...");?></span>
			</td>
		
			<th><?=$tax_description['parents_allow']?></th>
			<td style="width:90px">
				<select name="unit_parent" id="unit_parents" onchange="CheckUnitVal(this.value, 'parents_allow', 'parents_allowance');">
					<?php foreach($unitArr as $k=>$v){
							echo '<option ';
							if(isset($data['unit_parent'])){ if(strtoupper($data['unit_parent'])==$k){echo 'selected';} }else{ if($tax_unit['unit_parent'] == $k){echo 'selected';} }
							echo ' value="'.$k.'">'.$v.'</option>';
					} ?>
				</select>
			</td>
			<td style="width:40px"><input class="float43 sel tar" type="text" name="tax_parents" id="parents_allow" placeholder="..." value="<?=isset($data['tax_parents']) ? $data['tax_parents'] : $tax_number['tax_parents'] ?>"></td>
			<td style="width:90px"><input tabindex="-1" readonly class="tar nofocus" type="text" name="tax_allow_parents" id="parents_allowance" placeholder="..." value="<?=isset($data['tax_allow_parents']) ? $data['tax_allow_parents'] : $tax_thb['tax_allow_parents'] ?>"></td>
			<td class="info" id="info_parents_allow">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['parents_allow']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['parents_allow'], 0, 7, "...");?></span>
			</td>
		</tr>
		<tr>
			<th><?=$tax_description['parents_inlaw_allow']?></th>
			<td style="width:90px">
				<select name="unit_parentinLaw" id="unit_parentinLaws" onchange="CheckUnitVal(this.value, 'parents_inlaw_allow', 'parents_inlaw_allowance');">
					<?php foreach($unitArr as $k=>$v){
							echo '<option ';
							if(isset($data['unit_parentinLaw'])){ if(strtoupper($data['unit_parentinLaw'])==$k){echo 'selected';} }else{ if($tax_unit['unit_parentinLaw'] == $k){echo 'selected';} }
							//if(strtoupper($data['unit_parentinLaw'])==$k){echo 'selected';}
							echo ' value="'.$k.'">'.$v.'</option>';
					} ?>
				</select>
			</td>
			<td style="width:40px"><input class="float43 sel tar" type="text" name="tax_parents_inlaw" id="parents_inlaw_allow" placeholder="..." value="<?=isset($data['tax_parents_inlaw']) ? $data['tax_parents_inlaw'] : $tax_number['tax_parents_inlaw'] ?>" ></td>
			<td style="width:90px"><input tabindex="-1" readonly class="tar nofocus" type="text" name="tax_allow_parents_inlaw" id="parents_inlaw_allowance" placeholder="..." value="<?=isset($data['tax_allow_parents_inlaw']) ? $data['tax_allow_parents_inlaw'] : $tax_thb['tax_allow_parents_inlaw'] ?>"></td>
			<td class="info" id="info_parents_inlaw_allow">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['parents_allow']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['parents_allow'], 0, 7, "...");?></span>
			</td>
		
			<th><?=$tax_description['disabled_allow']?></th>
			<td style="width:90px">
				<select name="unit_care" id="unit_cares" onchange="CheckUnitVal(this.value, 'disabled_allow', 'disabled_allowance');">
					<?php foreach($unitArr as $k=>$v){
							echo '<option ';
							if(isset($data['unit_care'])){ if(strtoupper($data['unit_care'])==$k){echo 'selected';} }else{ if($tax_unit['unit_care'] == $k){echo 'selected';} }
							//if(strtoupper($data['unit_care'])==$k){echo 'selected';}
							echo ' value="'.$k.'">'.$v.'</option>';
					} ?>
				</select>
			</td>
			<td style="width:40px"><input class="float43 sel tar" type="text" name="tax_disabled_person" id="disabled_allow" placeholder="..." value="<?=isset($data['tax_disabled_person']) ? $data['tax_disabled_person'] : $tax_number['tax_disabled_person'] ?>"></td>
			<td style="width:90px"><input tabindex="-1" readonly class="tar nofocus" type="text" name="tax_allow_disabled_person" id="disabled_allowance" placeholder="..." value="<?=isset($data['tax_allow_disabled_person']) ? $data['tax_allow_disabled_person'] : $tax_thb['tax_allow_disabled_person'] ?>"></td>
			<td class="info">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['disabled_allow']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['disabled_allow'], 0, 7, "...");?></span>
			</td>
		</tr>

		<tr style="border-bottom:1px #ddd solid"><td colspan="10" style="height:15px"></td></tr>

		<tr>
			<th><?=$tax_description['child_allow']?></th>
			<td style="width:90px">
				<select name="unit_Chicare" id="unit_Chicares" onchange="CheckUnitVal(this.value, 'child_allow', 'child_allowance');">
					<?php foreach($unitArr as $k=>$v){
							echo '<option ';
							if(isset($data['unit_Chicare'])){ if(strtoupper($data['unit_Chicare'])==$k){echo 'selected';} }else{ if($tax_unit['unit_Chicare'] == $k){echo 'selected';} }
							//if(strtoupper($data['unit_Chicare'])==$k){echo 'selected';}
							echo ' value="'.$k.'">'.$v.'</option>';
					} ?>
				</select>
			</td>
			<td style="width:40px"><input class="float43 sel tar" type="text" name="tax_child_bio" id="child_allow" placeholder="..." value="<?=isset($data['tax_child_bio']) ? $data['tax_child_bio'] : $tax_number['tax_child_bio'] ?>"></td>
			<td style="width:90px"><input tabindex="-1" readonly class="tar nofocus" type="text" name="tax_allow_child_bio" id="child_allowance" placeholder="..." value="<?=isset($data['tax_allow_child_bio']) ? $data['tax_allow_child_bio'] : $tax_thb['tax_allow_child_bio'] ?>"></td>
			<td class="info">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['child_allow']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['child_allow'], 0, 7, "...");?></span>
			</td>
		
			<th><?=$tax_description['child_allow_2018']?></th>
			<td style="width:90px">
				<select name="unit_ChiBiocare" id="unit_ChiBiocares" onchange="CheckUnitVal(this.value, 'child_allow_2018', 'child_allowance_2018');">
					<?php foreach($unitArr as $k=>$v){
							echo '<option ';
							if(isset($data['unit_ChiBiocare'])){ if(strtoupper($data['unit_ChiBiocare'])==$k){echo 'selected';} }else{ if($tax_unit['unit_ChiBiocare'] == $k){echo 'selected';} }
							//if(strtoupper($data['unit_ChiBiocare'])==$k){echo 'selected';}
							echo ' value="'.$k.'">'.$v.'</option>';
					} ?>
				</select>
			</td>
			<td style="width:40px"><input class="float43 sel tar" type="text" name="tax_child_bio_2018" id="child_allow_2018" placeholder="..." value="<?=isset($data['tax_child_bio_2018']) ? $data['tax_child_bio_2018'] : $tax_number['tax_child_bio_2018'] ?>"></td>
			<td style="width:90px"><input tabindex="-1" readonly class="tar nofocus" type="text" name="tax_allow_child_bio_2018" id="child_allowance_2018" placeholder="..." value="<?=isset($data['tax_allow_child_bio_2018']) ? $data['tax_allow_child_bio_2018'] : $tax_thb['tax_allow_child_bio_2018'] ?>"></td>
			<td class="info">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['child_allow_2018']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['child_allow_2018'], 0, 7, "...");?></span>
			</td>
		</tr>
		
		<tr style="border-bottom:1px #ddd solid">

			<th><?=$tax_description['child_adopt_allow']?></th>
			<td style="width:90px">
				<select name="unit_Chiadcare" id="unit_Chiadcares" onchange="CheckUnitVal(this.value, 'child_adopt_allow', 'child_adopt_allowance');">
					<?php foreach($unitArr as $k=>$v){
							echo '<option ';
							if(isset($data['unit_Chiadcare'])){ if(strtoupper($data['unit_Chiadcare'])==$k){echo 'selected';} }else{ if($tax_unit['unit_Chiadcare'] == $k){echo 'selected';} }
							//if(strtoupper($data['unit_Chiadcare'])==$k){echo 'selected';}
							echo ' value="'.$k.'">'.$v.'</option>';
					} ?>
				</select>
			</td>
			<td style="width:40px"><input class="float43 sel tar" type="text" name="tax_child_adopted" id="child_adopt_allow" placeholder="..." value="<?=isset($data['tax_child_adopted']) ? $data['tax_child_adopted'] : $tax_number['tax_child_adopted'] ?>"></td>
			<td style="width:90px"><input tabindex="-1" readonly class="tar nofocus" type="text" name="tax_allow_child_adopted" id="child_adopt_allowance" placeholder="..." value="<?=isset($data['tax_allow_child_adopted']) ? $data['tax_allow_child_adopted'] : $tax_thb['tax_allow_child_adopted'] ?>"></td>
			<td class="info" id="info_child_adopt_allow">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['child_adopt_allow']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['child_adopt_allow'], 0, 7, "...");?></span>
			</td>
		
			<th><?=$tax_description['child_birth_bonus']?></th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" name="tax_allow_child_birth" id="child_birth_bonus" placeholder="..." value="<?=isset($data['tax_allow_child_birth']) ? $data['tax_allow_child_birth'] : $tax_thb['tax_allow_child_birth'] ?>"></td>
			<td class="info" id="info_child_bonus">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['child_birth_bonus']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['child_birth_bonus'], 0, 7, "...");?></span>
			</td>
		</tr>
			
		<tr style="border-bottom:1px #ddd solid"><td colspan="10" style="height:15px"></td></tr>

		<tr>
			<th><?=$tax_description['own_health_insurance']?></th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" id="own_health_insurance" type="text" name="tax_allow_own_health" placeholder="..." value="<?=isset($data['tax_allow_own_health']) ? $data['tax_allow_own_health'] : $tax_thb['tax_allow_own_health'] ?>"></td>
			<td class="info" id="info_own_health_insurance">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['own_health_insurance']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['own_health_insurance'], 0, 7, "...");?></span>
			</td>
	
			<th><?=$tax_description['own_life_insurance']?></th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" id="own_life_insurance" type="text" name="tax_allow_own_life_insurance" placeholder="..." value="<?=isset($data['tax_allow_own_life_insurance']) ? $data['tax_allow_own_life_insurance'] : $tax_thb['tax_allow_own_life_insurance'] ?>"></td>
			<td class="info" id="info_own_life_insurance">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['own_life_insurance']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['own_life_insurance'], 0, 7, "...");?></span>
			</td>
		</tr>

		<!-- <tr style="border-bottom:1px #ddd solid"><td colspan="10" style="height:15px"></td></tr> -->

		<tr style="border-bottom:1px #ddd solid">
			<th><?=$tax_description['health_insurance_par']?></th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="tar sel" type="text" name="tax_allow_health_parents" id="health_insurance_parent" placeholder="..." value="<?=isset($data['tax_allow_health_parents']) ? $data['tax_allow_health_parents'] : $tax_thb['tax_allow_health_parents'] ?>"></td>
			<td class="info" id="info_health_insurance_parent">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['health_insurance_par']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['health_insurance_par'], 0, 7, "...");?></span>
			</td>
		
			<th><?=$tax_description['life_insurance_spouse']?></th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" name="tax_allow_life_insurance_spouse" id="life_allow_insurance_spouse" placeholder="..." value="<?=isset($data['tax_allow_life_insurance_spouse']) ? $data['tax_allow_life_insurance_spouse'] : $tax_thb['tax_allow_life_insurance_spouse'] ?>"></td>
			<td class="info" id="info_life_insurance_spouse">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['life_insurance_spouse']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['life_insurance_spouse'], 0, 7, "...");?></span>
			</td>
		</tr>

		<tr style="border-bottom:1px #ddd solid"><td colspan="10" style="height:15px"></td></tr>

		<tr>
			<th><?=$tax_description['pension_fund_allowance']?></th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" id="pension_fund_allowance" name="tax_allow_pension_fund" placeholder="..." value="<?=isset($data['tax_allow_pension_fund']) ? $data['tax_allow_pension_fund'] : $tax_thb['tax_allow_pension_fund'] ?>"></td>
			<td class="info" id="info_pension_fund_allow">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['pension_fund_allowance']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['pension_fund_allowance'], 0, 7, "...");?></span>
			</td>
		
			<th><?=$tax_description['nsf_allowance']?></th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" id="nsf_allowance" name="tax_allow_nsf" placeholder="..." value="<?=isset($data['tax_allow_nsf']) ? $data['tax_allow_nsf'] : $tax_thb['tax_allow_nsf'] ?>"></td>
			<td class="info" id="info_nsf_allow">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['nsf_allowance']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['nsf_allowance'], 0, 7, "...");?></span>
			</td>
		</tr>
		
		<tr style="border-bottom:1px #ddd solid">
			<th><?=$tax_description['rmf_allowance']?></th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" id="rmf_allowance" name="tax_allow_rmf" placeholder="..." value="<?=isset($data['tax_allow_rmf']) ? $data['tax_allow_rmf'] : $tax_thb['tax_allow_rmf'] ?>"></td>
			<td class="info" id="info_rmf_allow">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['rmf_allowance']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['rmf_allowance'], 0, 7, "...");?></span>
			</td>

			<th><?=$tax_description['ltf_deduction']?></th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" id="ltf_deduction" name="tax_allow_ltf" placeholder="..." value="<?=isset($data['tax_allow_ltf']) ? $data['tax_allow_ltf'] : $tax_thb['tax_allow_ltf'] ?>"></td>
			<td class="info" id="info_ltf_deduction">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['ltf_allowance']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['ltf_allowance'], 0, 7, "...");?></span>
			</td>

		</tr>

		<tr style="border-bottom:1px #ddd solid"><td colspan="10" style="height:15px"></td></tr>

		<tr>
			
		
			<th><?=$tax_description['home_loan_interest']?></th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" id="home_loan_interest" name="tax_allow_home_loan_interest" placeholder="..." value="<?=isset($data['tax_allow_home_loan_interest']) ? $data['tax_allow_home_loan_interest'] : $tax_thb['tax_allow_home_loan_interest'] ?>"></td>
			<td class="info" id="info_home_loan_interest">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['home_loan_interest']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['home_loan_interest'], 0, 7, "...");?></span>
			</td>

			<th><?=$tax_description['donation_charity']?></th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" id="donation_charity" name="tax_allow_donation_charity" placeholder="..." value="<?=isset($data['tax_allow_donation_charity']) ? $data['tax_allow_donation_charity'] : $tax_thb['tax_allow_donation_charity'] ?>"></td>
			<td class="info" id="info_donation_charity">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['donation_charity']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['donation_charity'], 0, 7, "...");?></span>
			</td>
		</tr>
		
		<tr>
		
			<th><?=$tax_description['donation_flood']?></th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" id="donation_flood" name="tax_allow_donation_flood" placeholder="..." value="<?=isset($data['tax_allow_donation_flood']) ? $data['tax_allow_donation_flood'] : $tax_thb['tax_allow_donation_flood'] ?>"></td>
			<td class="info" id="info_donation_flood">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['donation_flood']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['donation_flood'], 0, 7, "...");?></span>
			</td>
			<th><?=$tax_description['donation_education']?></th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" id="donation_education" name="tax_allow_donation_education" placeholder="..." value="<?=isset($data['tax_allow_donation_education']) ? $data['tax_allow_donation_education'] : $tax_thb['tax_allow_donation_education'] ?>"></td>
			<td class="info" id="info_donation_education">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['donation_education']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['donation_education'], 0, 7, "...");?></span>
			</td>

		</tr>
		
		<tr>
					
			<th><?=$tax_description['exemp_disabled']?></th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px">
				<select class="calcTax" name="tax_exemp_disabled_under" id="exemp_disabled">
					<?php foreach($yesno as $k=>$v){
							echo '<option ';
							if(isset($data['tax_exemp_disabled_under'])){ if(strtoupper($data['tax_exemp_disabled_under'])==$k){echo 'selected';} }else{ if($tax_number['tax_exemp_disabled_under'] == $k){echo 'selected';} }
							//if(strtoupper($data['tax_exemp_disabled_under'])==$k){echo 'selected';}
							echo ' value="'.$k.'">'.$v.'</option>';
					} ?>
				</select>
			</td>
			<td style="width:90px"><input tabindex="-1" readonly class="tar nofocus" type="text" name="tax_allow_exemp_disabled_under" id="exemp_disabled_under" placeholder="..." value="<?=isset($data['tax_allow_exemp_disabled_under']) ? $data['tax_allow_exemp_disabled_under'] : $tax_thb['tax_allow_exemp_disabled_under'] ?>"></td>
			<td class="info">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['exemp_disabled_under']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['exemp_disabled_under'], 0, 7, "...");?></span>
			</td>

			<th><?=$tax_description['exemp_payer']?></th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px">
				<select class="calcTax" name="tax_exemp_payer_older" id="exemp_payer">
					<?php foreach($yesno as $k=>$v){
							echo '<option ';
							if(isset($data['tax_exemp_payer_older'])){ if(strtoupper($data['tax_exemp_payer_older'])==$k){echo 'selected';} }else{ if($tax_number['tax_exemp_payer_older'] == $k){echo 'selected';} }
							//if(strtoupper($data['tax_exemp_payer_older'])==$k){echo 'selected';}
							echo ' value="'.$k.'">'.$v.'</option>';
					} ?>
				</select>
			</td>
			<td style="width:90px"><input tabindex="-1" readonly class="tar nofocus" type="text" name="tax_allow_exemp_payer_older" id="exemp_payer_older" placeholder="..." value="<?=isset($data['tax_allow_exemp_payer_older']) ? $data['tax_allow_exemp_payer_older'] : $tax_thb['tax_allow_exemp_payer_older'] ?>"></td>
			<td class="info">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['exemp_payer_older']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['exemp_payer_older'], 0, 7, "...");?></span>
			</td>
		</tr>
		
		<tr>
					
			<th><?=$tax_description['first_home_allowance']?></th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" id="first_home_allowance" name="tax_allow_first_home" placeholder="..." value="<?=isset($data['tax_allow_first_home']) ? $data['tax_allow_first_home'] : $tax_thb['tax_allow_first_home'] ?>"></td>
			<td class="info" id="info_first_home_allow">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['first_home_allowance']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['first_home_allowance'], 0, 7, "...");?></span>
			</td>
			<th><?=$tax_description['year_end_shop_allowance']?></th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" id="year_end_shop_allowance" name="tax_allow_year_end_shopping" placeholder="..." value="<?=isset($data['tax_allow_year_end_shopping']) ? $data['tax_allow_year_end_shopping'] : $tax_thb['tax_allow_year_end_shopping'] ?>"></td>
			<td class="info" id="info_year_end_shop_allow">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['year_end_shop_allowance']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['year_end_shop_allowance'], 0, 7, "...");?></span>
			</td>

		</tr>
		
		<tr style="border-bottom:1px #ddd solid">
					
			<th><?=$tax_description['domestic_tour_allowance']?></th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" id="domestic_tour_allowance" name="tax_allow_domestic_tour" placeholder="..." value="<?=isset($data['tax_allow_domestic_tour']) ? $data['tax_allow_domestic_tour'] : $tax_thb['tax_allow_domestic_tour'] ?>"></td>
			<td class="info" id="info_domestic_tour_allow">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['domestic_tour_allowance']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['domestic_tour_allowance'], 0, 7, "...");?></span>
			</td>

			<th><?=$tax_description['other_allowance']?></th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" id="other_allowance" name="tax_allow_other" placeholder="..." value="<?=isset($data['tax_allow_other']) ? $data['tax_allow_other'] : $tax_thb['tax_allow_other'] ?>"></td>
			<td class="info" id="info_other_allowance">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['other_allowance']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['other_allowance'], 0, 7, "...");?></span>
			</td>
		</tr>
		
		
			
	</tbody>
</table>






		<!--<i class="man">*</i><b style="color:#b00"><?=$lng['Calculated by system from last payroll calculation']?></b>
		<table class="basicTable editTable" id="taxTable" border="0" style="margin-top:3px">
			<thead>
				<tr style="line-height:100%">
					<th class="tac tax-table"><?=$lng['Description']?></th>
					<th style="min-width:60px" class="tac"><?=$lng['Number']?></th>
					<th style="min-width:90px" class="tac"><?=$lng['Baht']?></th>
					<th class="hide-tax"><?=$lng['Information conditions']?></th>
				</tr>
			</thead>
			<tbody>
			<tr>
				<th><i class="man">*</i><?=$lng['Standard deduction']?></th>
				<td></td>
				<td><i><input tabindex="-1" style="color:#999;" readonly class="tar nofocus" type="text" name="tax_standard_deduction" id="standard_deduction" value="<?=$data['tax_standard_deduction']?>"></i></td>
				<td class="info" style="width:80%;color:#a00" id="info_standard_deduction"><?=$tax_info['standard_deduction']?></td>
			</tr>
			<tr>
				<th><i class="man">*</i><?=$lng['Personal care']?></th>
				<td></td>
				<td><i><input tabindex="-1" style="color:#999;" readonly class="tar nofocus" type="text" name="tax_personal_allowance" id="personal_allowance" placeholder="..." value="<?=$data['tax_personal_allowance']?>"><i></td>
				<td class="info pad410"></td>
			</tr>
			<tr>
				<th style="width:5%"><?=$lng['Spouse care']?></th>
				<td>
					<select class="calcTax" name="tax_spouse" id="spouse_allow">
						<?php foreach($yesno as $k=>$v){
								echo '<option ';
								if(strtoupper($data['tax_spouse'])==$k){echo 'selected';}
								echo ' value="'.$k.'">'.$v.'</option>';
						} ?>
					</select>
				</td>
				<td><input tabindex="-1" readonly class="tar nofocus" type="text" name="tax_allow_spouse" id="spouse_allowance" placeholder="..." value="<?=$data['tax_allow_spouse']?>"></td>
				<td class="info pad410"><?=$tax_info['spouse_allowance']?></td>
			</tr>
			<tr>
				<th><?=$lng['Parents care']?></th>
				<td><input class="float21 sel tar" type="text" name="tax_parents" id="parents_allow" placeholder="..." value="<?=$data['tax_parents']?>"></td>
				<td><input tabindex="-1" readonly class="tar nofocus" type="text" name="tax_allow_parents" id="parents_allowance" placeholder="..." value="<?=$data['tax_allow_parents']?>"></td>
				<td class="info" id="info_parents_allow"><?=$tax_info['parents_allow']?></td>
			</tr>
			<tr>
				<th><?=$lng['Parents in law care']?></th>
				<td><input class="numeric sel tar" maxlength="1" type="text" name="tax_parents_inlaw" id="parents_inlaw_allow" placeholder="..." value="<?=$data['tax_parents_inlaw']?>"></td>
				<td><input tabindex="-1" readonly class="tar nofocus" type="text" name="tax_allow_parents_inlaw" id="parents_inlaw_allowance" placeholder="..." value="<?=$data['tax_allow_parents_inlaw']?>"></td>
				<td class="info" id="info_parents_inlaw_allow"><?=$tax_info['parents_allow']?></td>
			</tr>
			<tr>
				<th><?=$lng['Care disabled person']?></th>
				<td><input class="float21 sel tar" type="text" name="tax_disabled_person" id="disabled_allow" placeholder="..." value="<?=$data['tax_disabled_person']?>"></td>
				<td><input tabindex="-1" readonly class="tar nofocus" type="text" name="tax_allow_disabled_person" id="disabled_allowance" placeholder="..." value="<?=$data['tax_allow_disabled_person']?>"></td>
				<td class="info"><?=$tax_info['disabled_allow']?></td>
			</tr>
			
			<tr style="border-bottom:1px #ddd solid"><td colspan="4" style="height:15px"></td></tr>
			</tbody>
			<tbody style="border:1px #ddd solid">
			
			<tr>
				<th><?=$lng['Child care - biological']?></th>
				<td><input class="float21 sel tar" type="text" name="tax_child_bio" id="child_allow" placeholder="..." value="<?=$data['tax_child_bio']?>"></td>
				<td><input tabindex="-1" readonly class="tar nofocus" type="text" name="tax_allow_child_bio" id="child_allowance" placeholder="..." value="<?=$data['tax_allow_child_bio']?>"></td>
				<td class="info"><?=$tax_info['child_allow']?></td>
			</tr>
			
			<tr>
				<th><?=$lng['Child care - biological 2018/19/20']?></th>
				<td><input class="float21 sel tar" type="text" name="tax_child_bio_2018" id="child_allow_2018" placeholder="..." value="<?=$data['tax_child_bio_2018']?>"></td>
				<td><input tabindex="-1" readonly class="tar nofocus" type="text" name="tax_allow_child_bio_2018" id="child_allowance_2018" placeholder="..." value="<?=$data['tax_allow_child_bio_2018']?>"></td>
				<td class="info"><?=$tax_info['child_allow_2018']?></td>
			</tr>
			
			<tr>
				<th><?=$lng['Child care - adopted']?></th>
				<td><input class="float21 sel tar" type="text" name="tax_child_adopted" id="child_adopt_allow" placeholder="..." value="<?=$data['tax_child_adopted']?>"></td>
				<td><input tabindex="-1" readonly class="tar nofocus" type="text" name="tax_allow_child_adopted" id="child_adopt_allowance" placeholder="..." value="<?=$data['tax_allow_child_adopted']?>"></td>
				<td class="info" id="info_child_adopt_allow"><?=$tax_info['child_adopt_allow']?></td>
			</tr>
			
			<tr style="border-bottom:1px #ddd solid">
				<th><?=$lng['Child birth (Baby bonus)']?></th>
				<td></td>
				<td><input class="numeric sel tar" type="text" name="tax_allow_child_birth" id="child_birth_bonus" placeholder="..." value="<?=$data['tax_allow_child_birth']?>"></td>
				<td class="info" id="info_child_bonus"><?=$tax_info['child_birth_bonus']?></td>
			</tr>
			
			</tbody>
			
			<tr style="border-bottom:1px #ddd solid"><td colspan="4" style="height:15px"></td></tr>
			</tbody>
			<tbody style="border:1px #ddd solid">
			<tr>
				<th><?=$lng['Own health insurance']?></th>
				<td></td>
				<td><input class="numeric sel tar" id="own_health_insurance" type="text" name="tax_allow_own_health" placeholder="..." value="<?=$data['tax_allow_own_health']?>"></td>
				<td class="info" id="info_own_health_insurance"><?=$tax_info['own_health_insurance']?></td>
			</tr>
			<tr style="border-bottom:1px #ddd solid">
				<th><?=$lng['Own life insurance']?></th>
				<td></td>
				<td><input class="numeric sel tar" id="own_life_insurance" type="text" name="tax_allow_own_life_insurance" placeholder="..." value="<?=$data['tax_allow_own_life_insurance']?>"></td>
				<td class="info" id="info_own_life_insurance"><?=$tax_info['own_life_insurance']?></td>
			</tr>
			<tr style="border-bottom:1px #ddd solid">
				<th style="color:#900; font-weight:400"><?=$lng['Subtotal']?></th>
				<td></td>
				<td><input tabindex="-1" readonly class="tar nofocus" type="text" id="total_own_health_life" value="<?php //=$data['total_own_health_life']?>"></td>
				<td class="info" id="info_health_life_insurance"></td>
			</tr>
			</tbody>
			<tbody>
			<tr><td colspan="4" style="height:15px"></td></tr>
			
			<tr>
				<th><?=$lng['Health insurance parents']?></th>
				<td></td>
				<td><input class="tar sel" type="text" name="tax_allow_health_parents" id="health_insurance_parent" placeholder="..." value="<?=$data['tax_allow_health_parents']?>"></td>
				<td class="info" id="info_health_insurance_parent"><?=$tax_info['health_insurance_par']?></td>
			</tr>
			<tr>
				<th><?=$lng['Life insurance spouse']?></th>
				<td></td>
				<td><input class="numeric sel tar" type="text" name="tax_allow_life_insurance_spouse" id="life_allow_insurance_spouse" placeholder="..." value="<?=$data['tax_allow_life_insurance_spouse']?>"></td>
				<td class="info" id="info_life_insurance_spouse"><?=$tax_info['life_insurance_spouse']?></td>
			</tr>
			
			<tr style="border-bottom:1px #ddd solid"><td colspan="4" style="height:15px"></td></tr>
			</tbody>
			<tbody style="border:1px #ddd solid">
			<tr>
				
				<th><?=$lng['Pension fund']?></th>
				<td></td>
				<td><input class="numeric sel tar" type="text" id="pension_fund_allowance" name="tax_allow_pension_fund" placeholder="..." value="<?=$data['tax_allow_pension_fund']?>"></td>
				<td class="info" id="info_pension_fund_allow"><?=$tax_info['pension_fund_allowance']?></td>
			</tr>
			
			<tr>
				<th><i class="man">*</i><?=$lng['Provident fund']?></th>
				<td></td>
				<td><i><input tabindex="-1" style="color:#999;" readonly class="tar nofocus" type="text" id="tax_allow_pvf" name="tax_allow_pvf" placeholder="..." value="<?=$data['tax_allow_pvf']?>"></i></td>
				<td class="info" id="info_provident_fund_allow"><?=$tax_info['provident_fund_allowance']?></td>
			</tr>
			
			<tr>
				<th><?=$lng['NSF']?></th>
				<td></td>
				<td><input class="numeric sel tar" type="text" id="nsf_allowance" name="tax_allow_nsf" placeholder="..." value="<?=$data['tax_allow_nsf']?>"></td>
				<td class="info" id="info_nsf_allow"><?=$tax_info['nsf_allowance']?></td>
			</tr>
			
			<tr style="border-bottom:1px #ddd solid">
				<th><?=$lng['RMF']?></th>
				<td></td>
				<td><input class="numeric sel tar" type="text" id="rmf_allowance" name="tax_allow_rmf" placeholder="..." value="<?=$data['tax_allow_rmf']?>"></td>
				<td class="info" id="info_rmf_allow"><?=$tax_info['rmf_allowance']?></td>
			</tr>
			
			<tr style="border-bottom:1px #ddd solid">
				<th style="color:#900; font-weight:400"><?=$lng['Subtotal']?></th>
				<td></td>
				<td><input tabindex="-1" readonly class="tar nofocus" type="text" id="subtotal2" value="<? //=$data['subtotal2']?>"></td>
				<td class="info" id="info_subtotal2"></td>
			</tr>
			</tbody>
			<tbody>
			
			<tr><td colspan="4" style="height:15px"></td></tr>
			
			<tr>
				<th><i class="man">*</i><?=$lng['Social Security Fund']?></th>
				<td></td>
				<td><i><input style="color:#999;" readonly class="tar nofocus" name="tax_allow_sso" id="tax_allow_sso" type="text" value="<?=$data['tax_allow_sso']?>"></i></td>
				<td class="info" id="info_ltf_deduction"><?=$tax_info['social_security_fund']?></td>
			</tr>
			
			<tr>
				<th><?=$lng['LTF']?></th>
				<td></td>
				<td><input class="numeric sel tar" type="text" id="ltf_deduction" name="tax_allow_ltf" placeholder="..." value="<?=$data['tax_allow_ltf']?>"></td>
				<td class="info" id="info_ltf_deduction"><?=$tax_info['ltf_allowance']?></td>
			</tr>
			
			<tr>
				<th><?=$lng['Home loan interest']?></th>
				<td></td>
				<td><input class="numeric sel tar" type="text" id="home_loan_interest" name="tax_allow_home_loan_interest" placeholder="..." value="<?=$data['tax_allow_home_loan_interest']?>"></td>
				<td class="info" id="info_home_loan_interest"><?=$tax_info['home_loan_interest']?></td>
			</tr>
			
			<tr>
				<th><?=$lng['Donation charity']?></th>
				<td></td>
				<td><input class="numeric sel tar" type="text" id="donation_charity" name="tax_allow_donation_charity" placeholder="..." value="<?=$data['tax_allow_donation_charity']?>"></td>
				<td class="info" id="info_donation_charity"><?=$tax_info['donation_charity']?></td>
			</tr>
			
			<tr>
				<th><?=$lng['Donation flooding']?></th>
				<td></td>
				<td><input class="numeric sel tar" type="text" id="donation_flood" name="tax_allow_donation_flood" placeholder="..." value="<?=$data['tax_allow_donation_flood']?>"></td>
				<td class="info" id="info_donation_flood"><?=$tax_info['donation_flood']?></td>
			</tr>
			
			<tr>
				<th><?=$lng['Donation education']?></th>
				<td></td>
				<td><input class="numeric sel tar" type="text" id="donation_education" name="tax_allow_donation_education" placeholder="..." value="<?=$data['tax_allow_donation_education']?>"></td>
				<td class="info" id="info_donation_education"><?=$tax_info['donation_education']?></td>
			</tr>
			
			<tr>
				<th><?=$lng['Exemption disabled person <65 yrs']?></th>
				<td>
					<select class="calcTax" name="tax_exemp_disabled_under" id="exemp_disabled">
						<?php foreach($yesno as $k=>$v){
								echo '<option ';
								if(strtoupper($data['tax_exemp_disabled_under'])==$k){echo 'selected';}
								echo ' value="'.$k.'">'.$v.'</option>';
						} ?>
					</select>
				</td>
				<td><input tabindex="-1" readonly class="tar nofocus" type="text" name="tax_allow_exemp_disabled_under" id="exemp_disabled_under" placeholder="..." value="<?=$data['tax_allow_exemp_disabled_under']?>"></td>
				<td class="info"><?=$tax_info['exemp_disabled_under']?></td>
			</tr>
			
			<tr>
				<th><?=$lng['Exemption tax payer => 65yrs']?></th>
				<td>
					<select class="calcTax" name="tax_exemp_payer_older" id="exemp_payer">
						<?php foreach($yesno as $k=>$v){
								echo '<option ';
								if(strtoupper($data['tax_exemp_payer_older'])==$k){echo 'selected';}
								echo ' value="'.$k.'">'.$v.'</option>';
						} ?>
					</select>
				</td>
				<td><input tabindex="-1" readonly class="tar nofocus" type="text" name="tax_allow_exemp_payer_older" id="exemp_payer_older" placeholder="..." value="<?=$data['tax_allow_exemp_payer_older']?>"></td>
				<td class="info"><?=$tax_info['exemp_payer_older']?></td>
			</tr>
			
			<tr>
				<th><?=$lng['First home buyer']?></th>
				<td></td>
				<td><input class="numeric sel tar" type="text" id="first_home_allowance" name="tax_allow_first_home" placeholder="..." value="<?=$data['tax_allow_first_home']?>"></td>
				<td class="info" id="info_first_home_allow"><?=$tax_info['first_home_allowance']?></td>
			</tr>
			
			<tr>
				<th><?=$lng['Year-end shopping']?></th>
				<td></td>
				<td><input class="numeric sel tar" type="text" id="year_end_shop_allowance" name="tax_allow_year_end_shopping" placeholder="..." value="<?=$data['tax_allow_year_end_shopping']?>"></td>
				<td class="info" id="info_year_end_shop_allow"><?=$tax_info['year_end_shop_allowance']?></td>
			</tr>
			
			<tr>
				<th><?=$lng['Domestic tour']?></th>
				<td></td>
				<td><input class="numeric sel tar" type="text" id="domestic_tour_allowance" name="tax_allow_domestic_tour" placeholder="..." value="<?=$data['tax_allow_domestic_tour']?>"></td>
				<td class="info" id="info_domestic_tour_allow"><?=$tax_info['domestic_tour_allowance']?></td>
			</tr>
			
			<tr>
				<th><?=$lng['Other allowance']?></th>
				<td></td>
				<td><input class="numeric sel tar" type="text" id="other_allowance" name="tax_allow_other" placeholder="..." value="<?=$data['tax_allow_other']?>"></td>
				<td class="info" id="info_other_allowance"><?=$tax_info['other_allowance']?></td>
			</tr>
			
			</tbody>

		</table>-->
		
		<!--<div class="totals_scroll"><?=$lng['Total deductions']?> 
			<span id="total_deductions"><?=number_format($data['emp_tax_deductions'],2)?></span> THB
			<input type="hidden" id="total_tax_deductions" name="total_tax_deductions" value="" />
			<input type="hidden" id="tax_deductions" value="" />--
			<input type="hidden" id="emp_tax_deductions" name="emp_tax_deductions" value="<?=$data['emp_tax_deductions']?>" />
		</div>-->

		
<script>
		function calculateDeductions(){
			//alert('calculateDeductions')
			var total = 0;
			//total += (isNaN(parseInt($('#standard_deduction').val())) ? 0 : parseInt($('#standard_deduction').val()));
			//total += (isNaN(parseInt($('#personal_allowance').val())) ? 0 : parseInt($('#personal_allowance').val()));
			total += (isNaN(parseInt($('#spouse_allowance').val())) ? 0 : parseInt($('#spouse_allowance').val()));
			//alert(total)
			total += (isNaN(parseInt($('#parents_allowance').val())) ? 0 : parseInt($('#parents_allowance').val()));
			//alert(total)
			total += (isNaN(parseInt($('#parents_inlaw_allowance').val())) ? 0 : parseInt($('#parents_inlaw_allowance').val()));
			total += (isNaN(parseInt($('#disabled_allowance').val())) ? 0 : parseInt($('#disabled_allowance').val()));
			total += (isNaN(parseInt($('#child_allowance').val())) ? 0 : parseInt($('#child_allowance').val()));
			total += (isNaN(parseInt($('#child_allowance_2018').val())) ? 0 : parseInt($('#child_allowance_2018').val()));
			total += (isNaN(parseInt($('#child_adopt_allowance').val())) ? 0 : parseInt($('#child_adopt_allowance').val()));
			total += (isNaN(parseInt($('#child_birth_bonus').val())) ? 0 : parseInt($('#child_birth_bonus').val()));
			total += (isNaN(parseInt($('#total_own_health_life').val())) ? 0 : parseInt($('#total_own_health_life').val()));
			//alert(total)
			total += (isNaN(parseInt($('#health_insurance_parent').val())) ? 0 : parseInt($('#health_insurance_parent').val()));
			//total += (isNaN(parseInt($('#life_allow_insurance_spouse').val())) ? 0 : parseInt($('#life_allow_insurance_spouse').val()));
			total += (isNaN(parseInt($('#donation_charity').val())) ? 0 : parseInt($('#donation_charity').val()));
			total += (isNaN(parseInt($('#donation_flood').val())) ? 0 : parseInt($('#donation_flood').val()));
			total += (isNaN(parseInt($('#donation_education').val())) ? 0 : parseInt($('#donation_education').val()));
			
			total += (isNaN(parseInt($('#first_home_allowance').val())) ? 0 : parseInt($('#first_home_allowance').val()));
			total += (isNaN(parseInt($('#year_end_shop_allowance').val())) ? 0 : parseInt($('#year_end_shop_allowance').val()));
			total += (isNaN(parseInt($('#domestic_tour_allowance').val())) ? 0 : parseInt($('#domestic_tour_allowance').val()));
			
			total += (isNaN(parseInt($('#exemp_disabled_under').val())) ? 0 : parseInt($('#exemp_disabled_under').val()));
			total += (isNaN(parseInt($('#exemp_payer_older').val())) ? 0 : parseInt($('#exemp_payer_older').val()));
			
			total += (isNaN(parseInt($('#ltf_deduction').val())) ? 0 : parseInt($('#ltf_deduction').val()));
			total += (isNaN(parseInt($('#home_loan_interest').val())) ? 0 : parseInt($('#home_loan_interest').val()));
			
			total += (isNaN(parseInt($('#pension_fund_allowance').val())) ? 0 : parseInt($('#pension_fund_allowance').val()));
			total += (isNaN(parseInt($('#nsf_allowance').val())) ? 0 : parseInt($('#nsf_allowance').val()));
			total += (isNaN(parseInt($('#rmf_allowance').val())) ? 0 : parseInt($('#rmf_allowance').val()));

			var sub2 = 0;
			sub2 += parseInt($('#pension_fund_allowance').val());
			sub2 += parseInt($('#tax_allow_pvf').val());
			sub2 += parseInt($('#nsf_allowance').val());
			sub2 += parseInt($('#rmf_allowance').val());
			sub2 += parseInt($('#ltf_deduction').val());
			$('#subtotal2').val(sub2)
			
			total += (isNaN(parseInt($('#other_allowance').val())) ? 0 : parseInt($('#other_allowance').val()));

			//alert(total)
			//$('#emp_tax_deductions').val(total)
			$('input[name="emp_tax_deductions"]').val(total);
			$('#emp_tax_deductions').html(total.format(2));
			total += (isNaN(parseInt($('#standard_deduction').val())) ? 0 : parseInt($('#standard_deduction').val()));
			total += (isNaN(parseInt($('#personal_allowance').val())) ? 0 : parseInt($('#personal_allowance').val()));
			total += (isNaN(parseInt($('#tax_allow_pvf').val())) ? 0 : parseInt($('#tax_allow_pvf').val()));
			total += (isNaN(parseInt($('#tax_allow_sso').val())) ? 0 : parseInt($('#tax_allow_sso').val()));
			$('#total_deductions').html(total.format(2));
			//$('#tax_deductions').val(total)
			//alert(total)
		}

		function stDeducChkbox(that){
			if($(that).is(':checked')){
				$('#standard_deduction').css({'pointer-events': 'none','background-color':'#ffffff !important'});
				$('#standard_deduction').val('');
			}else{
				$('#standard_deduction').css({'pointer-events': 'auto','background-color':'#f9f9d1'});
			}
		}

		function PersoCareChkbox(that){
			if($(that).is(':checked')){
				$('#personal_allowance').css({'pointer-events': 'none','background-color':'#ffffff !important'});
				$('#personal_allowance').val('');
			}else{
				$('#personal_allowance').css({'pointer-events': 'auto','background-color':'#f9f9d1'});
			}
		}

		function ProFundChkbox(that){
			if($(that).is(':checked')){
				$('#tax_allow_pvf').css({'pointer-events': 'none','background-color':'#ffffff !important'});
				$('#tax_allow_pvf').val('');
			}else{
				$('#tax_allow_pvf').css({'pointer-events': 'auto','background-color':'#f9f9d1'});
			}
		}

		function SSFChkbox(that){
			if($(that).is(':checked')){
				$('#tax_allow_sso').css({'pointer-events': 'none','background-color':'#ffffff !important'});
				$('#tax_allow_sso').val('');
			}else{
				$('#tax_allow_sso').css({'pointer-events': 'auto','background-color':'#f9f9d1'});
			}
		}

		
	$(document).on("focus", "input:text.float43", function(){
		$(this).numberField(
			{ ints: 4, floats: 3, separator: "."}			
		);
	});
	
	$(document).ready(function() {
		//alert('isNaN')	
		
		var tax_settings = <?=json_encode($tax_settings)?>;
		var tax_info = <?=json_encode($tax_info)?>;
		var tax_err = <?=json_encode($tax_err)?>;
		var timeout = 5000;
		var basic_salary = <?=json_encode($data['base_salary'])?>;
		
		calculateDeductions()
		CheckUnitVal(<?=isset($data['unit_parent']) ? $data['unit_parent'] : $tax_unit['unit_parent']; ?>,'parents_allow','parents_allowance')
		CheckUnitVal(<?=isset($data['unit_parentinLaw']) ? $data['unit_parentinLaw'] : $tax_unit['unit_parentinLaw']; ?>, 'parents_inlaw_allow', 'parents_inlaw_allowance')
		CheckUnitVal(<?=isset($data['unit_care']) ? $data['unit_care'] : $tax_unit['unit_care'];?>, 'disabled_allow', 'disabled_allowance')
		CheckUnitVal(<?=isset($data['unit_Chicare']) ? $data['unit_Chicare'] : $tax_unit['unit_Chicare'];?>, 'child_allow', 'child_allowance')
		CheckUnitVal(<?=isset($data['unit_ChiBiocare']) ? $data['unit_ChiBiocare'] : $tax_unit['unit_ChiBiocare'];?>, 'child_allow_2018', 'child_allowance_2018')
		CheckUnitVal(<?=isset($data['unit_Chiadcare']) ? $data['unit_Chiadcare'] : $tax_unit['unit_Chiadcare']; ?>, 'child_adopt_allow', 'child_adopt_allowance')
		
		$('#spouse_allow').on('change', function(){
			if($(this).val()=='Y'){
				$('#spouse_allowance').val(60000)
			}else{
				$('#spouse_allowance').val(0)
			}
			calculateDeductions()
		})

		$('#parents_allow').on('change', function(){
			var val = this.value
			if(val > tax_settings.parents_allow){
				val = tax_settings.parents_allow
				$('#parents_allow').val(val)
				$('#info_parents_allow').html('<span class="text-danger">'+tax_err.parents_allow+'</span>')
				//setTimeout(function(){$('#info_parents_allow').html(tax_info.parents_allow)},timeout);
				setTimeout(function(){$('#info_parents_allow').html('<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['parents_allow']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['parents_allow'], 0, 7, "...");?></span>')},timeout);
			}
			$('#parents_allowance').val(val * tax_settings.parents_allowance)
			calculateDeductions()

		})

		$('#parents_allowance').on('change', function(){
			var val = this.value
			var limit = tax_settings.parents_allow * tax_settings.parents_allowance;

			if(val > limit){
				val = limit
				$('#parents_allowance').val(val)
				$('#info_parents_allow').html('<span class="text-danger">Max. '+limit+'</span>')
				//setTimeout(function(){$('#info_parents_allow').html(tax_info.parents_allow)},timeout);
				setTimeout(function(){$('#info_parents_allow').html('<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['parents_allow']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['parents_allow'], 0, 7, "...");?></span>')},timeout);
			}
			$('#parents_allow').val(tax_settings.parents_allow)
			calculateDeductions()
		})

		$('#parents_inlaw_allow').on('change', function(){
			var val = this.value
			if(val > tax_settings.parents_inlaw_allow){
				val = tax_settings.parents_inlaw_allow
				$('#parents_inlaw_allow').val(val)
				$('#info_parents_inlaw_allow').html('<span class="text-danger">'+tax_err.parents_allow+'</span>')
				//setTimeout(function(){$('#info_parents_inlaw_allow').html(tax_info.parents_allow)},timeout);
				setTimeout(function(){$('#info_parents_inlaw_allow').html('<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['parents_allow']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['parents_allow'], 0, 7, "...");?></span>')},timeout);
			}
			$('#parents_inlaw_allowance').val(val * tax_settings.parents_inlaw_allowance)
			calculateDeductions()
		})


		$('#parents_inlaw_allowance').on('change', function(){
			var val = this.value
			var limit = tax_settings.parents_inlaw_allow * tax_settings.parents_inlaw_allowance;

			if(val > limit){
				val = limit;
				$('#parents_inlaw_allowance').val(val);
				$('#info_parents_inlaw_allow').html('<span class="text-danger">Max. '+limit+'</span>');

				setTimeout(function(){$('#info_parents_inlaw_allow').html('<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['parents_allow']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['parents_allow'], 0, 7, "...");?></span>')},timeout);
			}

			$('#parents_inlaw_allow').val(tax_settings.parents_inlaw_allow)
			calculateDeductions()
		})


		$('#disabled_allow').on('change', function(){
			var val = this.value
			if(val > tax_settings.disabled_allow){
				val = tax_settings.disabled_allow
				$('#disabled_allow').val(val)
				$('#info_disabled_allow').html('<span class="text-danger">'+tax_err.disabled_allow+'</span>')
				setTimeout(function(){$('#info_disabled_allow').html(tax_info.disabled_allow)},timeout);
			}
			$('#disabled_allowance').val(val * tax_settings.disabled_allowance)
			calculateDeductions()
		})
		$('#child_allow, #child_allow_2018').on('change', function(){
			var ch1 = $('#child_allow').val()
			var ch2 = $('#child_allow_2018').val()
			$('#child_allowance').val(ch1 * tax_settings.child_allowance)
			$('#child_allowance_2018').val(ch2 * tax_settings.child_allowance_2018)
			if((ch1+ch2) >= tax_settings.child_adopt_allow){
				$('#child_adopt_allow').val(0).prop('disabled', true)
				$('#child_adopt_allowance').val(0)
			}else{
				$('#child_adopt_allow').prop('disabled', false)
			}
			calculateDeductions()
		})
		
		$('#child_adopt_allow').on('change', function(){
			var adopt = parseFloat(this.value)
			var child = parseFloat($('#child_allow').val()) +  parseFloat($('#child_allow_2018').val())
			var maxx = parseInt(tax_settings.child_adopt_allow) - child
			if(adopt > maxx){
				adopt = maxx; $(this).val(adopt)
				$('#info_child_adopt_allow').html('<span class="text-danger">'+tax_err.child_adopt_allow+'</span>')
				//setTimeout(function(){$('#info_child_adopt_allow').html(tax_info.child_adopt_allow)},timeout);
				setTimeout(function(){$('#info_child_adopt_allow').html('<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['child_adopt_allow']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['child_adopt_allow'], 0, 7, "...");?></span>')},timeout);
			}
			$('#child_adopt_allowance').val(adopt * tax_settings.child_adopt_allowance)
			calculateDeductions()
		})
		
		$('#child_birth_bonus').on('change', function(){
			if(this.value > parseInt(tax_settings.child_birth_bonus)){$('#child_birth_bonus').val(tax_settings.child_birth_bonus)}
			calculateDeductions()
		})
		$('#own_health_insurance, #own_life_insurance, #life_allow_insurance_spouse').on('change', function(){
			var health = parseInt($('#own_health_insurance').val())
			var life = parseInt($('#own_life_insurance').val())
			var lifeSpouse = parseInt($('#life_allow_insurance_spouse').val())

			if(health > parseInt(tax_settings.own_health_insurance)){
				health = parseInt(tax_settings.own_health_insurance)
				$('#info_own_health_insurance').html('<span class="text-danger">'+tax_err.own_health_insurance+'</span>')
				//setTimeout(function(){$('#info_own_health_insurance').html(tax_info.own_health_insurance)},timeout);
				setTimeout(function(){$('#info_own_health_insurance').html('<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['own_health_insurance']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['own_health_insurance'], 0, 7, "...");?></span>')},timeout);
			}
			if(life > tax_settings.own_life_insurance){
				life = parseInt(tax_settings.own_life_insurance)
				$('#info_own_life_insurance').html('<span class="text-danger">'+tax_err.own_life_insurance+'</span>')
				//setTimeout(function(){$('#info_own_life_insurance').html(tax_info.own_life_insurance)},timeout);
				setTimeout(function(){$('#info_own_life_insurance').html('<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['own_life_insurance']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['own_life_insurance'], 0, 7, "...");?></span>')},timeout);
			}

			if(lifeSpouse > parseInt(tax_settings.life_insurance_spouse)){

				lifeSpouse = parseInt(tax_settings.life_insurance_spouse)
				$('#life_allow_insurance_spouse').val(tax_settings.life_insurance_spouse)
				$('#info_life_insurance_spouse').html('<span class="text-danger">'+tax_err.life_insurance_spouse+'</span>')
				//setTimeout(function(){$('#info_life_insurance_spouse').html(tax_info.life_insurance_spouse)},timeout);
				setTimeout(function(){$('#info_life_insurance_spouse').html('<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['life_insurance_spouse']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['life_insurance_spouse'], 0, 7, "...");?></span>')},timeout);
			}
			if(isNaN(health)){health = 0}
			if(isNaN(life)){life = 0}
			if(isNaN(lifeSpouse)){lifeSpouse = 0}
			$('#own_health_insurance').val(health)
			$('#own_life_insurance').val(life)
			$('#life_allow_insurance_spouse').val(lifeSpouse)
			$('#total_own_health_life').val(health + life + lifeSpouse)
			$('#total_own_health_life').trigger('change')
			calculateDeductions()
		})
		$('#own_health_insurance').trigger('change')
		
		$('#total_own_health_life').on('change', function(){
			if(parseInt(this.value) > parseInt(tax_settings.max_own_health_life)){
				//$('#info_health_life_insurance').html('<span class="text-danger">'+tax_err.max_own_health_life+'</span>')
				$('#info_health_life_insurance').html('<i class="fa fa-times fa-lg text-danger"></i>')
				$('#total_own_health_life').addClass('error')
			}else{
				$('#info_health_life_insurance').html('<i style="color:#090" class="fa fa-check fa-lg"></i>')
				$('#total_own_health_life').removeClass('error')
			}
			calculateDeductions()
		})
		$('#total_own_health_life').trigger('change')
		
		$('#health_insurance_parent').on('change', function(){
			var val = parseFloat(this.value)
			/*if(val > parseInt(tax_settings.health_insurance_par)){
				val = tax_settings.health_insurance_par
				$('#health_insurance_parent').val(val)
				$('#info_health_insurance_parent').html('<span>'+tax_err.health_insurance_par+'</span>')
				setTimeout(function(){$('#info_health_insurance_parent').html(tax_info.health_insurance_par)},timeout);
			}*/
			$('#health_insurance_parent').val(val)
			//alert()
			calculateDeductions()
		})
		$('#life_allow_insurance_spouse').on('change', function(){
			if(this.value > parseInt(tax_settings.life_insurance_spouse)){
				$('#life_allow_insurance_spouse').val(tax_settings.life_insurance_spouse)
				$('#info_life_insurance_spouse').html('<span class="text-danger">'+tax_err.life_insurance_spouse+'</span>')
				//setTimeout(function(){$('#info_life_insurance_spouse').html(tax_info.life_insurance_spouse)},timeout);
				setTimeout(function(){$('#info_life_insurance_spouse').html('<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['life_insurance_spouse']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['life_insurance_spouse'], 0, 7, "...");?></span>')},timeout);
			}
			calculateDeductions()
		})
		$('#pension_fund_allowance, #tax_allow_pvf, #nsf_allowance, #rmf_allowance, #ltf_deduction').on('change', function(){
			var pension = parseInt($('#pension_fund_allowance').val())
			var provident = parseInt($('#tax_allow_pvf').val())
			var nsf = parseInt($('#nsf_allowance').val())
			var rmf = parseInt($('#rmf_allowance').val())
			var ssf = parseInt($('#ltf_deduction').val())

			if(pension > parseInt(tax_settings.pension_fund_allowance)){
				pension = parseInt(tax_settings.pension_fund_allowance)
				$('#info_pension_fund_allow').html('<span class="text-danger">'+tax_err.pension_fund_allowance+'</span>')
				//setTimeout(function(){$('#info_pension_fund_allow').html(tax_info.pension_fund_allowance)},timeout);
				setTimeout(function(){$('#info_pension_fund_allow').html('<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['pension_fund_allowance']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['pension_fund_allowance'], 0, 7, "...");?></span>')},timeout);
			}
			if(parseInt(provident) > parseInt(tax_settings.provident_fund_allowance)){
				//alert(provident +' - '+parseInt(tax_settings.provident_fund_allowance))
				provident = parseInt(tax_settings.provident_fund_allowance)
				$('#info_provident_fund_allow').html('<span class="text-danger">'+tax_err.provident_fund_allowance+'</span>')
				//setTimeout(function(){$('#info_provident_fund_allow').html(tax_info.tax_allow_pvf)},timeout);
				setTimeout(function(){$('#info_provident_fund_allow').html('<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['provident_fund_allowance']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['provident_fund_allowance'], 0, 30, "...");?></span>')},timeout);
			}
			if(nsf > parseInt(tax_settings.nsf_allowance)){
				nsf = parseInt(tax_settings.nsf_allowance)
				$('#info_nsf_allow').html('<span class="text-danger">'+tax_err.nsf_allowance+'</span>')
				//setTimeout(function(){$('#info_nsf_allow').html(tax_info.nsf_allowance)},timeout);
				setTimeout(function(){$('#info_nsf_allow').html('<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['nsf_allowance']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['nsf_allowance'], 0, 7, "...");?></span>')},timeout);
			}
			if(rmf > parseInt(tax_settings.rmf_allowance)){
				rmf = parseInt(tax_settings.rmf_allowance)
				$('#info_rmf_allow').html('<span class="text-danger">'+tax_err.rmf_allowance+'</span>')
				//setTimeout(function(){$('#info_rmf_allow').html(tax_info.rmf_allowance)},timeout);
				setTimeout(function(){$('#info_rmf_allow').html('<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['rmf_allowance']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['rmf_allowance'], 0, 7, "...");?></span>')},timeout);
			}
			if(ssf > parseInt(tax_settings.ltf_allowance)){
				$('#ltf_deduction').val(tax_settings.ltf_allowance)
				$('#info_ltf_deduction').html('<span class="text-danger">'+tax_err.ltf_allowance+'</span>')
				//setTimeout(function(){$('#info_ltf_deduction').html(tax_info.ltf_allowance)},timeout);
				setTimeout(function(){$('#info_ltf_deduction').html('<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['ltf_allowance']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['ltf_allowance'], 0, 7, "...");?></span>')},timeout);
			}


			if(isNaN(pension)){pension = 0}
			if(isNaN(provident)){provident = 0}
			if(isNaN(nsf)){nsf = 0}
			if(isNaN(rmf)){rmf = 0}
			if(isNaN(ssf)){ssf = 0}
			$('#pension_fund_allowance').val(pension)
			$('#tax_allow_pvf').val(provident)
			$('#nsf_allowance').val(nsf)
			$('#rmf_allowance').val(rmf)
			$('#ltf_deduction').val(ssf)
			
			$('#subtotal2').val(pension + provident + nsf + rmf + ssf)
			$('#subtotal2').trigger('change')
			calculateDeductions()
		})
		$('#pension_fund_allowance').trigger('change')
		
		$('#subtotal2').on('change', function(){
			if(parseInt(this.value) > parseInt(tax_settings.max_pension_provident_nsf_rmf)){
				//$('#info_subtotal2').html('<span class="text-danger">'+tax_err.ltf_allowance+'</span>')
				$('#info_subtotal2').html('<i class="fa fa-times fa-lg text-danger"></i>')
				$('#subtotal2').addClass('error')
			}else{
				$('#info_subtotal2').html('<i style="color:#090" class="fa fa-check fa-lg"></i>')
				$('#subtotal2').removeClass('error')
			}
			calculateDeductions()
		})
		$('#subtotal2').trigger('change')

		$('#ltf_deduction').on('change', function(){
			if(this.value > parseInt(tax_settings.ltf_allowance)){
				$('#ltf_deduction').val(tax_settings.ltf_allowance)
				$('#info_ltf_deduction').html('<span class="text-danger">'+tax_err.ltf_allowance+'</span>')
				//setTimeout(function(){$('#info_ltf_deduction').html(tax_info.ltf_allowance)},timeout);
				setTimeout(function(){$('#info_ltf_deduction').html('<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['ltf_allowance']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['ltf_allowance'], 0, 7, "...");?></span>')},timeout);
			}
			calculateDeductions()
		})
		$('#home_loan_interest').on('change', function(){
			if(this.value > parseInt(tax_settings.home_loan_interest)){
				$('#home_loan_interest').val(tax_settings.home_loan_interest)
				$('#info_home_loan_interest').html('<span class="text-danger">'+tax_err.home_loan_interest+'</span>')
				//setTimeout(function(){$('#info_home_loan_interest').html(tax_info.home_loan_interest)},timeout);
				setTimeout(function(){$('#info_home_loan_interest').html('<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['home_loan_interest']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['home_loan_interest'], 0, 7, "...");?></span>')},timeout);
			}
			calculateDeductions()
		})
		$('#donation_charity').on('change', function(){
			calculateDeductions()
		})
		$('#donation_education').on('change', function(){
			calculateDeductions()
		})
		$('#donation_flood').on('change', function(){
			calculateDeductions()
		})
		$('#exemp_disabled').on('change', function(){
			if($(this).val()=='Y'){
				$('#exemp_disabled_under').val(tax_settings.exemp_disabled_under)
			}else{
				$('#exemp_disabled_under').val(0)
			}
			calculateDeductions()
		})
		$('#exemp_payer').on('change', function(){
			if($(this).val()=='Y'){
				$('#exemp_payer_older').val(tax_settings.exemp_payer_older)
			}else{
				$('#exemp_payer_older').val(0)
			}
			calculateDeductions()
		})
		$('#first_home_allowance').on('change', function(){
			if(this.value > parseInt(tax_settings.first_home_allowance)){
				$('#first_home_allowance').val(tax_settings.first_home_allowance)
				$('#info_first_home_allow').html('<span class="text-danger">'+tax_err.first_home_allow+'</span>')
				//setTimeout(function(){$('#info_first_home_allow').html(tax_info.first_home_allow)},timeout);
				setTimeout(function(){$('#info_first_home_allow').html('<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['first_home_allowance']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['first_home_allowance'], 0, 7, "...");?></span>')},timeout);
			}
			calculateDeductions()
		})
		$('#year_end_shop_allowance').on('change', function(){
			if(this.value > parseInt(tax_settings.year_end_shop_allowance)){
				$('#year_end_shop_allowance').val(tax_settings.year_end_shop_allowance)
				$('#info_year_end_shop_allow').html('<span class="text-danger">'+tax_err.year_end_shop_allow+'</span>')
				//setTimeout(function(){$('#info_year_end_shop_allow').html(tax_info.year_end_shop_allow)},timeout);
				setTimeout(function(){$('#info_year_end_shop_allow').html('<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['year_end_shop_allowance']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['year_end_shop_allowance'], 0, 7, "...");?></span>')},timeout);
			}
			calculateDeductions()
		})
		$('#domestic_tour_allowance').on('change', function(){
			if(this.value > parseInt(tax_settings.domestic_tour_allowance)){
				$('#domestic_tour_allowance').val(tax_settings.domestic_tour_allowance)
				$('#info_domestic_tour_allow').html('<span class="text-danger">'+tax_err.domestic_tour_allow+'</span>')
				//setTimeout(function(){$('#info_domestic_tour_allow').html(tax_info.domestic_tour_allow)},timeout);
				setTimeout(function(){$('#info_domestic_tour_allow').html('<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['domestic_tour_allowance']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['domestic_tour_allowance'], 0, 7, "...");?></span>')},timeout);
			}
			calculateDeductions()
		})
		$('#other_allowance').on('change', function(){
			calculateDeductions()
		})


		$('#standard_deduction').on('change', function(){
			if(this.value > parseInt(tax_settings.standard_deduction)){
				$('#standard_deduction').val(tax_settings.standard_deduction)
				$('#info_standard_deduction').html('<span class="text-danger">'+tax_err.standard_deduction+'</span>')
				//setTimeout(function(){$('#info_domestic_tour_allow').html(tax_info.domestic_tour_allow)},timeout);
				setTimeout(function(){$('#info_standard_deduction').html('<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['standard_deduction']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span ><?=mb_strimwidth($tax_info['standard_deduction'], 0, 30, "...");?></span>')},timeout);
			}
			calculateDeductions()
		})

		$('#personal_allowance').on('change', function(){
			if(this.value > parseInt(tax_settings.personal_allowance)){
				$('#personal_allowance').val(tax_settings.personal_allowance)
				$('#info_personal_allowance').html('<span class="text-danger">Max amount is '+tax_settings.personal_allowance+' THB</span>')
				//setTimeout(function(){$('#info_domestic_tour_allow').html(tax_info.domestic_tour_allow)},timeout);
				setTimeout(function(){$('#info_personal_allowance').html('<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['personal_allowance']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['personal_allowance'], 0, 30, "...");?></span>')},timeout);
			}
			calculateDeductions()
		})

		$('#tax_allow_sso').on('change', function(){
			if(this.value > parseInt(tax_settings.social_security_fund)){
				$('#tax_allow_sso').val(tax_settings.social_security_fund)
				$('#info_ltf_deductionss').html('<span class="text-danger">Max amount is '+tax_settings.social_security_fund+' THB</span>')
				//setTimeout(function(){$('#info_domestic_tour_allow').html(tax_info.domestic_tour_allow)},timeout);
				setTimeout(function(){$('#info_ltf_deductionss').html('<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['social_security_fund']?>" width="20" height="20" class="mr-2" style="display: inline;"> <span><?=mb_strimwidth($tax_info['social_security_fund'], 0, 30, "...");?></span>')},timeout);
			}
			calculateDeductions()
		})
		
  	});

	function CheckUnitVal(val,numid,thbid){
		if(val == 1){
			$('#'+numid).css({'pointer-events': 'auto','background-color':'#f9f9d1'});
			$('#'+thbid).val('').attr('readonly',true);
			$('#'+thbid).val('').css('background-color','#fff');
		}else if(val == 2){
			$('#'+numid).val('').css({'pointer-events': 'none','background-color':'#ffffff'});
			$('#'+thbid).val('').attr('readonly',false);
			$('#'+thbid).val('').css('background-color','#f9f9d1');
		}else{
			$('#'+numid).val('').css('pointer-events', 'auto');
			$('#'+thbid).val('').attr('readonly',true);
		}
	}


</script>		
		


		
		
		
		
		
		
		
		
		
		
		
		
		
