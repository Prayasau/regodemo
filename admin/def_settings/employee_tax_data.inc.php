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
					<input name="tax_calc_on[calc_on_sd]" type="hidden" value="0">
					<input type="checkbox" onclick="stDeducChkbox(this)" name="tax_calc_on[calc_on_sd]" value="1" <?if($tax_calc_on['calc_on_sd'] == 1){echo 'checked="checked"';}?>>
				</td>
				<td>
					<?if($tax_calc_on['calc_on_sd'] == 1){ $bgclrst = 'background-color:#fff;pointer-events:none;';}?>
					<input tabindex="-1" style="color:#999;<?=$bgclrst;?>" class="tar nofocus" type="text" name="tax_thb[tax_standard_deduction]" id="standard_deduction" value="<?=$tax_thb['tax_standard_deduction']?>">
				</td>
				<td class="info" style="width:80%;color:#a00" id="info_standard_deduction">
					<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['standard_deduction']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
					<a class="text-primary mr-1" id="mdl_standard_deduction" data-th="<?=$tax_info_th['standard_deduction']?>" data-en="<?=$tax_info_en['standard_deduction']?>" onclick="openpopupMdl('standard_deduction');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
					<span ><?=mb_strimwidth($tax_info['standard_deduction'], 0, 30, "...");?></span>

					<input type="hidden" name="tax_info_th[standard_deduction]" value="<?=$tax_info_th['standard_deduction']?>">
					<input type="hidden" name="tax_info_en[standard_deduction]" value="<?=$tax_info_en['standard_deduction']?>">
				</td>
			</tr>
			<tr>
				<th><?=$lng['Personal care']?></th>
				<td class="tac">
					<input type="hidden" name="tax_calc_on[calc_on_pc]" value="0">
					<input type="checkbox" onclick="PersoCareChkbox(this)" name="tax_calc_on[calc_on_pc]" value="1" <? if($tax_calc_on['calc_on_pc'] == 1){echo 'checked="checked"';}?>>
				</td>
				<td>
					<? if($tax_calc_on['calc_on_pc'] == 1){ $bgclrpc = 'background-color:#fff;pointer-events:none;';}?>
					<input tabindex="-1" style="color:#999;<?=$bgclrpc;?>"  class="tar nofocus" type="text" name="tax_thb[tax_personal_allowance]" id="personal_allowance" value="<?=$tax_thb['tax_personal_allowance']?>">
				</td>
				<td class="info pad410" id="info_personal_allowance">
					<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['personal_allowance']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
					<a class="text-primary mr-1" id="mdl_personal_allowance" data-th="<?=$tax_info_th['personal_allowance']?>" data-en="<?=$tax_info_en['personal_allowance']?>" onclick="openpopupMdl('personal_allowance');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
					<span><?=mb_strimwidth($tax_info['personal_allowance'], 0, 30, "...");?></span>

					<input type="hidden" name="tax_info_th[personal_allowance]" value="<?=$tax_info_th['personal_allowance']?>">
					<input type="hidden" name="tax_info_en[personal_allowance]" value="<?=$tax_info_en['personal_allowance']?>">
				</td>
			</tr>
			<tr>
				<th><?=$lng['Provident fund']?></th>
				<td class="tac">
					<input type="hidden" name="tax_calc_on[calc_on_pf]" value="0">
					<input type="checkbox" onclick="ProFundChkbox(this)" name="tax_calc_on[calc_on_pf]" value="1" <?if($tax_calc_on['calc_on_pf'] == 1){echo 'checked="checked"';}?>>
				</td>
				<td>
					<?if($tax_calc_on['calc_on_pf'] == 1){ $bgclrpf = 'background-color:#fff;pointer-events:none;';}?>
					<input tabindex="-1" style="color:#999;<?=$bgclrpf;?>"  class="tar nofocus" type="text" id="tax_allow_pvf" name="tax_thb[tax_allow_pvf]" value="<?=$tax_thb['tax_allow_pvf']?>">
				</td>
				<td class="info" id="info_provident_fund_allow">
					<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['provident_fund_allowance']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
					<a class="text-primary mr-1" id="mdl_provident_fund_allowance" data-th="<?=$tax_info_th['provident_fund_allowance']?>" data-en="<?=$tax_info_en['provident_fund_allowance']?>" onclick="openpopupMdl('provident_fund_allowance');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
					<span><?=mb_strimwidth($tax_info['provident_fund_allowance'], 0, 20, "...");?></span>

					<input type="hidden" name="tax_info_th[provident_fund_allowance]" value="<?=$tax_info_th['provident_fund_allowance']?>">
					<input type="hidden" name="tax_info_en[provident_fund_allowance]" value="<?=$tax_info_en['provident_fund_allowance']?>">
				</td>
			</tr>
			<tr>
				<th><?=$lng['Social Security Fund']?></th>
				<td class="tac">
					<input type="hidden" name="tax_calc_on[calc_on_ssf]" value="0">
					<input type="checkbox" onclick="SSFChkbox(this)" name="tax_calc_on[calc_on_ssf]" value="1" <?if($tax_calc_on['calc_on_ssf'] == 1){echo 'checked="checked"';}?>>
				</td>
				<td>
					<?if($tax_calc_on['calc_on_ssf'] == 1){ $bgclrssf = 'background-color:#fff;pointer-events:none;';}?>
					<input style="color:#999;<?=$bgclrssf;?>"  class="tar nofocus" name="tax_thb[tax_allow_sso]" id="tax_allow_sso" type="text" value="<?=$tax_calc_on['tax_allow_sso']?>">
				</td>
				<td class="info" id="info_ltf_deductionss">
					<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['social_security_fund']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
					<a class="text-primary mr-1" id="mdl_social_security_fund" data-th="<?=$tax_info_th['social_security_fund']?>" data-en="<?=$tax_info_en['social_security_fund']?>" onclick="openpopupMdl('social_security_fund');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
					<span><?=mb_strimwidth($tax_info['social_security_fund'], 0, 30, "...");?></span>

					<input type="hidden" name="tax_info_th[social_security_fund]" value="<?=$tax_info_th['social_security_fund']?>">
					<input type="hidden" name="tax_info_en[social_security_fund]" value="<?=$tax_info_en['social_security_fund']?>">
				</td>
			</tr>
			
		</tbody>
	</table>
</div>

<div class="tab-content-right" style="height: auto !important;">
	<table class="basicTable inputs">
		<thead>
			<tr>
				<th colspan="4" class="text-danger"><?=strtoupper($lng['Total'].' '. $lng['Tax'].' '.$lng['Deduction'])?><span class="float-right ml-1"> THB</span><span class="float-right" id="total_deductions"><?//=number_format($data['total_deductions'],2)?></span></th>
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
			<th class="tal text-danger" colspan="5"><?=strtoupper($lng['Total'].' '.$lng['Other'].' '. $lng['Tax'].' '.$lng['Deduction'])?>  <span class="float-right ml-1"> THB</span><span class="float-right" id="emp_tax_deductions"><?//=number_format($data['emp_tax_deductions'],2)?></span>
				<input type="hidden" name="emp_tax_deductions" value="" />
			</th>
		</tr>
		<tr>
			<th class="tal" style="width: 250px;"><?=$lng['Description']?></th>
			<th class="tal"><?=$lng['Unit']?></th>
			<th class="tal"><?=$lng['Number']?></th>
			<th class="tal"><?=$lng['THB']?></th>
			<th class="tal"><?=$lng['Info']?></th>

			<th class="tal" style="width: 250px;"><?=$lng['Description']?></th>
			<th class="tal"><?=$lng['Unit']?></th>
			<th class="tal"><?=$lng['Number']?></th>
			<th class="tal"><?=$lng['THB']?></th>
			<th class="tal"><?=$lng['Info']?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th>
				<input class="descri_info" type="text" name="tax_settings_description[spouse_allow]" value="<?= isset($tax_settings_description['spouse_allow']) ? $tax_settings_description['spouse_allow'] : $lng['Spouse care']?>">
			</th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px">
				<select class="calcTax" name="tax_number[tax_spouse]" id="spouse_allow" style="background-color: rgb(249, 249, 209);">
					<?php foreach($yesno as $k=>$v){
							echo '<option ';
							if(strtoupper($tax_number['tax_spouse'])==$k){echo 'selected';}
							echo ' value="'.$k.'">'.$v.'</option>';
					} ?>
				</select>
			</td>
			<td style="width:90px"><input tabindex="-1" readonly class="tar nofocus" type="text" name="tax_thb[tax_allow_spouse]" id="spouse_allowance" placeholder="..." value="<?=$tax_thb['tax_allow_spouse']?>"></td>
			<td class="info pad410">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['spouse_allowance']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
				<a class="text-primary mr-1" id="mdl_spouse_allowance" data-th="<?=$tax_info_th['spouse_allowance']?>" data-en="<?=$tax_info_en['spouse_allowance']?>" onclick="openpopupMdl('spouse_allowance');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
				<span><?=mb_strimwidth($tax_info['spouse_allowance'], 0, 7, "...");?></span>

				<input type="hidden" name="tax_info_th[spouse_allowance]" value="<?=$tax_info_th['spouse_allowance']?>">
				<input type="hidden" name="tax_info_en[spouse_allowance]" value="<?=$tax_info_en['spouse_allowance']?>">
			</td>
		
			<th>
				<input class="descri_info" type="text" name="tax_settings_description[parents_allow]" value="<?=isset($tax_settings_description['parents_allow']) ? $tax_settings_description['parents_allow'] : $lng['Parents care']?>">
			</th>
			<td style="width:90px">
				<select name="tax_unit[unit_parent]" id="unit_parents" onchange="CheckUnitVal(this.value, 'parents_allow', 'parents_allowance');" style="background-color: rgb(249, 249, 209);">
					<?php foreach($unitArr as $k=>$v){
							echo '<option ';
							if(strtoupper($tax_unit['unit_parent'])==$k){echo 'selected';}
							echo ' value="'.$k.'">'.$v.'</option>';
					} ?>
				</select>
			</td>
			<td style="width:40px"><input class="float43 sel tar" type="text" name="tax_number[tax_parents]" id="parents_allow" placeholder="..." value="<?=$tax_number['tax_parents']?>"></td>
			<td style="width:90px"><input tabindex="-1" readonly class="tar nofocus" type="text" name="tax_thb[tax_allow_parents]" id="parents_allowance" placeholder="..." value="<?=$tax_thb['tax_allow_parents']?>"></td>
			<td class="info" id="info_parents_allow">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['parents_allow']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
				<a class="text-primary mr-1" id="mdl_parents_allow" data-th="<?=$tax_info_th['parents_allow']?>" data-en="<?=$tax_info_en['parents_allow']?>" onclick="openpopupMdl('parents_allow');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
				<span><?=mb_strimwidth($tax_info['parents_allow'], 0, 7, "...");?></span>

				<input type="hidden" name="tax_info_th[parents_allow]" value="<?=$tax_info_th['parents_allow']?>">
				<input type="hidden" name="tax_info_en[parents_allow]" value="<?=$tax_info_en['parents_allow']?>">
			</td>
		</tr>
		<tr>
			<th>
				<input class="descri_info" type="text" name="tax_settings_description[parents_inlaw_allow]" value="<?=isset($tax_settings_description['parents_inlaw_allow']) ? $tax_settings_description['parents_inlaw_allow'] : $lng['Parents in law care']?>">
			</th>
			<td style="width:90px">
				<select name="tax_unit[unit_parentinLaw]" id="unit_parentinLaws" onchange="CheckUnitVal(this.value, 'parents_inlaw_allow', 'parents_inlaw_allowance');" style="background-color: rgb(249, 249, 209);">
					<?php foreach($unitArr as $k=>$v){
							echo '<option ';
							if(strtoupper($tax_unit['unit_parentinLaw'])==$k){echo 'selected';}
							echo ' value="'.$k.'">'.$v.'</option>';
					} ?>
				</select>
			</td>
			<td style="width:40px"><input class="float43 sel tar" type="text" name="tax_number[tax_parents_inlaw]" id="parents_inlaw_allow" placeholder="..." value="<?=$tax_number['tax_parents_inlaw']?>" ></td>
			<td style="width:90px"><input tabindex="-1" readonly class="tar nofocus" type="text" name="tax_thb[tax_allow_parents_inlaw]" id="parents_inlaw_allowance" placeholder="..." value="<?=$tax_thb['tax_allow_parents_inlaw']?>"></td>
			<td class="info" id="info_parents_inlaw_allow">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['parents_inlaw_allow']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
				<a class="text-primary mr-1" id="mdl_parents_inlaw_allow" data-th="<?=$tax_info_th['parents_inlaw_allow']?>" data-en="<?=$tax_info_en['parents_inlaw_allow']?>" onclick="openpopupMdl('parents_inlaw_allow');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
				<span><?=mb_strimwidth($tax_info['parents_inlaw_allow'], 0, 7, "...");?></span>

				<input type="hidden" name="tax_info_th[parents_inlaw_allow]" value="<?=$tax_info_th['parents_inlaw_allow']?>">
				<input type="hidden" name="tax_info_en[parents_inlaw_allow]" value="<?=$tax_info_en['parents_inlaw_allow']?>">
			</td>
		
			<th>
				<input class="descri_info" type="text" name="tax_settings_description[disabled_allow]" value="<?=isset($tax_settings_description['disabled_allow']) ? $tax_settings_description['disabled_allow'] : $lng['Care disabled person']?>">
			</th>
			<td style="width:90px">
				<select name="tax_unit[unit_care]" id="unit_cares" onchange="CheckUnitVal(this.value, 'disabled_allow', 'disabled_allowance');" style="background-color: rgb(249, 249, 209);">
					<?php foreach($unitArr as $k=>$v){
							echo '<option ';
							if(strtoupper($tax_unit['unit_care'])==$k){echo 'selected';}
							echo ' value="'.$k.'">'.$v.'</option>';
					} ?>
				</select>
			</td>
			<td style="width:40px"><input class="float43 sel tar" type="text" name="tax_number[tax_disabled_person]" id="disabled_allow" placeholder="..." value="<?=$tax_number['tax_disabled_person']?>"></td>
			<td style="width:90px"><input tabindex="-1" readonly class="tar nofocus" type="text" name="tax_thb[tax_allow_disabled_person]" id="disabled_allowance" placeholder="..." value="<?=$tax_thb['tax_allow_disabled_person']?>"></td>
			<td class="info">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['disabled_allow']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
				<a class="text-primary mr-1" id="mdl_disabled_allow" data-th="<?=$tax_info_th['disabled_allow']?>" data-en="<?=$tax_info_en['disabled_allow']?>" onclick="openpopupMdl('disabled_allow');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
				<span><?=mb_strimwidth($tax_info['disabled_allow'], 0, 7, "...");?></span>

				<input type="hidden" name="tax_info_th[disabled_allow]" value="<?=$tax_info_th['disabled_allow']?>">
				<input type="hidden" name="tax_info_en[disabled_allow]" value="<?=$tax_info_en['disabled_allow']?>">
			</td>
		</tr>

		<tr style="border-bottom:1px #ddd solid"><td colspan="10" style="height:15px"></td></tr>

		<tr>
			<th>
				<input class="descri_info" type="text" name="tax_settings_description[child_allow]" value="<?=isset($tax_settings_description['child_allow']) ? $tax_settings_description['child_allow'] : $lng['Child care - biological']?>">
			</th>
			<td style="width:90px">
				<select name="tax_unit[unit_Chicare]" id="unit_Chicares" onchange="CheckUnitVal(this.value, 'child_allow', 'child_allowance');" style="background-color: rgb(249, 249, 209);">
					<?php foreach($unitArr as $k=>$v){
							echo '<option ';
							if(strtoupper($tax_unit['unit_Chicare'])==$k){echo 'selected';}
							echo ' value="'.$k.'">'.$v.'</option>';
					} ?>
				</select>
			</td>
			<td style="width:40px"><input class="float43 sel tar" type="text" name="tax_number[tax_child_bio]" id="child_allow" placeholder="..." value="<?=$tax_number['tax_child_bio']?>"></td>
			<td style="width:90px"><input tabindex="-1" readonly class="tar nofocus" type="text" name="tax_thb[tax_allow_child_bio]" id="child_allowance" placeholder="..." value="<?=$tax_thb['tax_allow_child_bio']?>"></td>
			<td class="info">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['child_allow']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
				<a class="text-primary mr-1" id="mdl_child_allow" data-th="<?=$tax_info_th['child_allow']?>" data-en="<?=$tax_info_en['child_allow']?>" onclick="openpopupMdl('child_allow');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
				<span><?=mb_strimwidth($tax_info['child_allow'], 0, 7, "...");?></span>

				<input type="hidden" name="tax_info_th[child_allow]" value="<?=$tax_info_th['child_allow']?>">
				<input type="hidden" name="tax_info_en[child_allow]" value="<?=$tax_info_en['child_allow']?>">
			</td>
		
			<th>
				<input class="descri_info" type="text" name="tax_settings_description[child_allow_2018]" value="<?=isset($tax_settings_description['child_allow_2018']) ? $tax_settings_description['child_allow_2018'] : $lng['Child care - biological 2018/19/20']?>">
			</th>
			<td style="width:90px">
				<select name="tax_unit[unit_ChiBiocare]" id="unit_ChiBiocares" onchange="CheckUnitVal(this.value, 'child_allow_2018', 'child_allowance_2018');" style="background-color: rgb(249, 249, 209);">
					<?php foreach($unitArr as $k=>$v){
							echo '<option ';
							if(strtoupper($tax_unit['unit_ChiBiocare'])==$k){echo 'selected';}
							echo ' value="'.$k.'">'.$v.'</option>';
					} ?>
				</select>
			</td>
			<td style="width:40px"><input class="float43 sel tar" type="text" name="tax_number[tax_child_bio_2018]" id="child_allow_2018" placeholder="..." value="<?=$tax_number['tax_child_bio_2018']?>"></td>
			<td style="width:90px"><input tabindex="-1" readonly class="tar nofocus" type="text" name="tax_thb[tax_allow_child_bio_2018]" id="child_allowance_2018" placeholder="..." value="<?=$tax_thb['tax_allow_child_bio_2018']?>"></td>
			<td class="info">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['child_allow_2018']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
				<a class="text-primary mr-1" id="mdl_child_allow_2018" data-th="<?=$tax_info_th['child_allow_2018']?>" data-en="<?=$tax_info_en['child_allow_2018']?>" onclick="openpopupMdl('child_allow_2018');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
				<span><?=mb_strimwidth($tax_info['child_allow_2018'], 0, 7, "...");?></span>

				<input type="hidden" name="tax_info_th[child_allow_2018]" value="<?=$tax_info_th['child_allow_2018']?>">
				<input type="hidden" name="tax_info_en[child_allow_2018]" value="<?=$tax_info_en['child_allow_2018']?>">
			</td>
		</tr>
		
		<tr style="border-bottom:1px #ddd solid">

			<th>
				<input class="descri_info" type="text" name="tax_settings_description[child_adopt_allow]" value="<?=isset($tax_settings_description['child_adopt_allow']) ? $tax_settings_description['child_adopt_allow'] : $lng['Child care - adopted']?>">
			</th>
			<td style="width:90px">
				<select name="tax_unit[unit_Chiadcare]" id="unit_Chiadcares" onchange="CheckUnitVal(this.value, 'child_adopt_allow', 'child_adopt_allowance');" style="background-color: rgb(249, 249, 209);">
					<?php foreach($unitArr as $k=>$v){
							echo '<option ';
							if(strtoupper($tax_unit['unit_Chiadcare'])==$k){echo 'selected';}
							echo ' value="'.$k.'">'.$v.'</option>';
					} ?>
				</select>
			</td>
			<td style="width:40px"><input class="float43 sel tar" type="text" name="tax_number[tax_child_adopted]" id="child_adopt_allow" placeholder="..." value="<?=$tax_number['tax_child_adopted']?>"></td>
			<td style="width:90px"><input tabindex="-1" readonly class="tar nofocus" type="text" name="tax_thb[tax_allow_child_adopted]" id="child_adopt_allowance" placeholder="..." value="<?=$tax_thb['tax_allow_child_adopted']?>"></td>
			<td class="info" id="info_child_adopt_allow">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['child_adopt_allow']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
				<a class="text-primary mr-1" id="mdl_child_adopt_allow" data-th="<?=$tax_info_th['child_adopt_allow']?>" data-en="<?=$tax_info_en['child_adopt_allow']?>" onclick="openpopupMdl('child_adopt_allow');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
				<span><?=mb_strimwidth($tax_info['child_adopt_allow'], 0, 7, "...");?></span>

				<input type="hidden" name="tax_info_th[child_adopt_allow]" value="<?=$tax_info_th['child_adopt_allow']?>">
				<input type="hidden" name="tax_info_en[child_adopt_allow]" value="<?=$tax_info_en['child_adopt_allow']?>">
			</td>
		
			<th>
				<input class="descri_info" type="text" name="tax_settings_description[child_birth_bonus]" value="<?=isset($tax_settings_description['child_birth_bonus']) ? $tax_settings_description['child_birth_bonus'] : $lng['Child birth (Baby bonus)']?>">
			</th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" name="tax_thb[tax_allow_child_birth]" id="child_birth_bonus" placeholder="..." value="<?=$tax_thb['tax_allow_child_birth']?>"></td>
			<td class="info" id="info_child_bonus">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['child_birth_bonus']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
				<a class="text-primary mr-1" id="mdl_child_birth_bonus" data-th="<?=$tax_info_th['child_birth_bonus']?>" data-en="<?=$tax_info_en['child_birth_bonus']?>" onclick="openpopupMdl('child_birth_bonus');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
				<span><?=mb_strimwidth($tax_info['child_birth_bonus'], 0, 7, "...");?></span>

				<input type="hidden" name="tax_info_th[child_birth_bonus]" value="<?=$tax_info_th['child_birth_bonus']?>">
				<input type="hidden" name="tax_info_en[child_birth_bonus]" value="<?=$tax_info_en['child_birth_bonus']?>">
			</td>
		</tr>
			
		<tr style="border-bottom:1px #ddd solid"><td colspan="10" style="height:15px"></td></tr>

		<tr>
			<th>
				<input class="descri_info" type="text" name="tax_settings_description[own_health_insurance]" value="<?=isset($tax_settings_description['own_health_insurance']) ? $tax_settings_description['own_health_insurance'] : $lng['Own health insurance']?>">
			</th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" id="own_health_insurance" type="text" name="tax_thb[tax_allow_own_health]" placeholder="..." value="<?=$tax_thb['tax_allow_own_health']?>"></td>
			<td class="info" id="info_own_health_insurance">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['own_health_insurance']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
				<a class="text-primary mr-1" id="mdl_own_health_insurance" data-th="<?=$tax_info_th['own_health_insurance']?>" data-en="<?=$tax_info_en['own_health_insurance']?>" onclick="openpopupMdl('own_health_insurance');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
				<span><?=mb_strimwidth($tax_info['own_health_insurance'], 0, 7, "...");?></span>

				<input type="hidden" name="tax_info_th[own_health_insurance]" value="<?=$tax_info_th['own_health_insurance']?>">
				<input type="hidden" name="tax_info_en[own_health_insurance]" value="<?=$tax_info_en['own_health_insurance']?>">
			</td>
	
			<th>
				<input class="descri_info" type="text" name="tax_settings_description[own_life_insurance]" value="<?=isset($tax_settings_description['own_life_insurance']) ? $tax_settings_description['own_life_insurance'] : $lng['Own life insurance']?>">
			</th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" id="own_life_insurance" type="text" name="tax_thb[tax_allow_own_life_insurance]" placeholder="..." value="<?=$tax_thb['tax_allow_own_life_insurance']?>"></td>
			<td class="info" id="info_own_life_insurance">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['own_life_insurance']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
				<a class="text-primary mr-1" id="mdl_own_life_insurance" data-th="<?=$tax_info_th['own_life_insurance']?>" data-en="<?=$tax_info_en['own_life_insurance']?>" onclick="openpopupMdl('own_life_insurance');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
				<span><?=mb_strimwidth($tax_info['own_life_insurance'], 0, 7, "...");?></span>

				<input type="hidden" name="tax_info_th[own_life_insurance]" value="<?=$tax_info_th['own_life_insurance']?>">
				<input type="hidden" name="tax_info_en[own_life_insurance]" value="<?=$tax_info_en['own_life_insurance']?>">
			</td>
		</tr>

		<!-- <tr style="border-bottom:1px #ddd solid"><td colspan="10" style="height:15px"></td></tr> -->

		<tr style="border-bottom:1px #ddd solid">
			<th>
				<input class="descri_info" type="text" name="tax_settings_description[health_insurance_par]" value="<?=isset($tax_settings_description['health_insurance_par']) ? $tax_settings_description['health_insurance_par'] : $lng['Health insurance parents']?>">
			</th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="tar sel" type="text" name="tax_thb[tax_allow_health_parents]" id="health_insurance_parent" placeholder="..." value="<?=$tax_thb['tax_allow_health_parents']?>"></td>
			<td class="info" id="info_health_insurance_parent">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['health_insurance_par']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
				<a class="text-primary mr-1" id="mdl_health_insurance_par" data-th="<?=$tax_info_th['health_insurance_par']?>" data-en="<?=$tax_info_en['health_insurance_par']?>" onclick="openpopupMdl('health_insurance_par');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
				<span><?=mb_strimwidth($tax_info['health_insurance_par'], 0, 7, "...");?></span>

				<input type="hidden" name="tax_info_th[health_insurance_par]" value="<?=$tax_info_th['health_insurance_par']?>">
				<input type="hidden" name="tax_info_en[health_insurance_par]" value="<?=$tax_info_en['health_insurance_par']?>">
			</td>
		
			<th>
				<input class="descri_info" type="text" name="tax_settings_description[life_insurance_spouse]" value="<?=isset($tax_settings_description['life_insurance_spouse']) ? $tax_settings_description['life_insurance_spouse'] : $lng['Life insurance spouse']?>">
			</th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" name="tax_thb[tax_allow_life_insurance_spouse]" id="life_allow_insurance_spouse" placeholder="..." value="<?=$tax_thb['tax_allow_life_insurance_spouse']?>"></td>
			<td class="info" id="info_life_insurance_spouse">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['life_insurance_spouse']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
				<a class="text-primary mr-1" id="mdl_life_insurance_spouse" data-th="<?=$tax_info_th['life_insurance_spouse']?>" data-en="<?=$tax_info_en['life_insurance_spouse']?>" onclick="openpopupMdl('life_insurance_spouse');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
				<span><?=mb_strimwidth($tax_info['life_insurance_spouse'], 0, 7, "...");?></span>

				<input type="hidden" name="tax_info_th[life_insurance_spouse]" value="<?=$tax_info_th['life_insurance_spouse']?>">
				<input type="hidden" name="tax_info_en[life_insurance_spouse]" value="<?=$tax_info_en['life_insurance_spouse']?>">
			</td>
		</tr>

		<tr style="border-bottom:1px #ddd solid"><td colspan="10" style="height:15px"></td></tr>

		<tr>
			<th>
				<input class="descri_info" type="text" name="tax_settings_description[pension_fund_allowance]" value="<?=isset($tax_settings_description['pension_fund_allowance']) ? $tax_settings_description['pension_fund_allowance'] : $lng['Pension fund']?>">
			</th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" id="pension_fund_allowance" name="tax_thb[tax_allow_pension_fund]" placeholder="..." value="<?=$tax_thb['tax_allow_pension_fund']?>"></td>
			<td class="info" id="info_pension_fund_allow">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['pension_fund_allowance']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
				<a class="text-primary mr-1" id="mdl_pension_fund_allowance" data-th="<?=$tax_info_th['pension_fund_allowance']?>" data-en="<?=$tax_info_en['pension_fund_allowance']?>" onclick="openpopupMdl('pension_fund_allowance');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
				<span><?=mb_strimwidth($tax_info['pension_fund_allowance'], 0, 7, "...");?></span>

				<input type="hidden" name="tax_info_th[pension_fund_allowance]" value="<?=$tax_info_th['pension_fund_allowance']?>">
				<input type="hidden" name="tax_info_en[pension_fund_allowance]" value="<?=$tax_info_en['pension_fund_allowance']?>">
			</td>
		
			<th>
				<input class="descri_info" type="text" name="tax_settings_description[nsf_allowance]" value="<?=isset($tax_settings_description['nsf_allowance']) ? $tax_settings_description['nsf_allowance'] : $lng['National Savings Fund'].' ('.$lng['NSF'].')'?>">
			</th>

			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" id="nsf_allowance" name="tax_thb[tax_allow_nsf]" placeholder="..." value="<?=$tax_thb['tax_allow_nsf']?>"></td>
			<td class="info" id="info_nsf_allow">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['nsf_allowance']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
				<a class="text-primary mr-1" id="mdl_nsf_allowance" data-th="<?=$tax_info_th['nsf_allowance']?>" data-en="<?=$tax_info_en['nsf_allowance']?>" onclick="openpopupMdl('nsf_allowance');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
				<span><?=mb_strimwidth($tax_info['nsf_allowance'], 0, 7, "...");?></span>

				<input type="hidden" name="tax_info_th[nsf_allowance]" value="<?=$tax_info_th['nsf_allowance']?>">
				<input type="hidden" name="tax_info_en[nsf_allowance]" value="<?=$tax_info_en['nsf_allowance']?>">
			</td>
		</tr>
		
		<tr style="border-bottom:1px #ddd solid">
			<th>
				<input class="descri_info" type="text" name="tax_settings_description[rmf_allowance]" value="<?=isset($tax_settings_description['rmf_allowance']) ? $tax_settings_description['rmf_allowance'] : $lng['Retirement Mutual Fund'].' ('.$lng['RMF'].')'?>">
			</th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" id="rmf_allowance" name="tax_thb[tax_allow_rmf]" placeholder="..." value="<?=$tax_thb['tax_allow_rmf']?>"></td>
			<td class="info" id="info_rmf_allow">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['rmf_allowance']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
				<a class="text-primary mr-1" id="mdl_rmf_allowance" data-th="<?=$tax_info_th['rmf_allowance']?>" data-en="<?=$tax_info_en['rmf_allowance']?>" onclick="openpopupMdl('rmf_allowance');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
				<span><?=mb_strimwidth($tax_info['rmf_allowance'], 0, 7, "...");?></span>

				<input type="hidden" name="tax_info_th[rmf_allowance]" value="<?=$tax_info_th['rmf_allowance']?>">
				<input type="hidden" name="tax_info_en[rmf_allowance]" value="<?=$tax_info_en['rmf_allowance']?>">
			</td>

			<th>
				<input class="descri_info" type="text" name="tax_settings_description[ltf_deduction]" value="<?=isset($tax_settings_description['ltf_deduction']) ? $tax_settings_description['ltf_deduction'] : $lng['Super Savings Fund'].' ('.$lng['LTF'].')'?>">
			</th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" id="ltf_deduction" name="tax_thb[tax_allow_ltf]" placeholder="..." value="<?=$tax_thb['tax_allow_ltf']?>"></td>
			<td class="info" id="info_ltf_deduction">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['ltf_allowance']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
				<a class="text-primary mr-1" id="mdl_ltf_allowance" data-th="<?=$tax_info_th['ltf_allowance']?>" data-en="<?=$tax_info_en['ltf_allowance']?>" onclick="openpopupMdl('ltf_allowance');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
				<span><?=mb_strimwidth($tax_info['ltf_allowance'], 0, 7, "...");?></span>

				<input type="hidden" name="tax_info_th[ltf_allowance]" value="<?=$tax_info_th['ltf_allowance']?>">
				<input type="hidden" name="tax_info_en[ltf_allowance]" value="<?=$tax_info_en['ltf_allowance']?>">
			</td>

		</tr>

		<tr style="border-bottom:1px #ddd solid"><td colspan="10" style="height:15px"></td></tr>

		<tr>
			
		
			<th>
				<input class="descri_info" type="text" name="tax_settings_description[home_loan_interest]" value="<?=isset($tax_settings_description['home_loan_interest']) ? $tax_settings_description['home_loan_interest'] : $lng['Home loan interest']?>">
			</th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" id="home_loan_interest" name="tax_thb[tax_allow_home_loan_interest]" placeholder="..." value="<?=$tax_thb['tax_allow_home_loan_interest']?>"></td>
			<td class="info" id="info_home_loan_interest">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['home_loan_interest']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
				<a class="text-primary mr-1" id="mdl_home_loan_interest" data-th="<?=$tax_info_th['home_loan_interest']?>" data-en="<?=$tax_info_en['home_loan_interest']?>" onclick="openpopupMdl('home_loan_interest');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
				<span><?=mb_strimwidth($tax_info['home_loan_interest'], 0, 7, "...");?></span>

				<input type="hidden" name="tax_info_th[home_loan_interest]" value="<?=$tax_info_th['home_loan_interest']?>">
				<input type="hidden" name="tax_info_en[home_loan_interest]" value="<?=$tax_info_en['home_loan_interest']?>">
			</td>

			<th>
				<input class="descri_info" type="text" name="tax_settings_description[donation_charity]" value="<?=isset($tax_settings_description['donation_charity']) ? $tax_settings_description['donation_charity'] : $lng['Donation charity']?>">
			</th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" id="donation_charity" name="tax_thb[tax_allow_donation_charity]" placeholder="..." value="<?=$tax_thb['tax_allow_donation_charity']?>"></td>
			<td class="info" id="info_donation_charity">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['donation_charity']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
				<a class="text-primary mr-1" id="mdl_donation_charity" data-th="<?=$tax_info_th['donation_charity']?>" data-en="<?=$tax_info_en['donation_charity']?>" onclick="openpopupMdl('donation_charity');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
				<span><?=mb_strimwidth($tax_info['donation_charity'], 0, 7, "...");?></span>

				<input type="hidden" name="tax_info_th[donation_charity]" value="<?=$tax_info_th['donation_charity']?>">
				<input type="hidden" name="tax_info_en[donation_charity]" value="<?=$tax_info_en['donation_charity']?>">
			</td>
		</tr>
		
		<tr>
		
			<th>
				<input class="descri_info" type="text" name="tax_settings_description[donation_flood]" value="<?=isset($tax_settings_description['donation_flood']) ? $tax_settings_description['donation_flood'] : $lng['Donation flooding']?>">
			</th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" id="donation_flood" name="tax_thb[tax_allow_donation_flood]" placeholder="..." value="<?=$tax_thb['tax_allow_donation_flood']?>"></td>
			<td class="info" id="info_donation_flood">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['donation_flood']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
				<a class="text-primary mr-1" id="mdl_donation_flood" data-th="<?=$tax_info_th['donation_flood']?>" data-en="<?=$tax_info_en['donation_flood']?>" onclick="openpopupMdl('donation_flood');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
				<span><?=mb_strimwidth($tax_info['donation_flood'], 0, 7, "...");?></span>

				<input type="hidden" name="tax_info_th[donation_flood]" value="<?=$tax_info_th['donation_flood']?>">
				<input type="hidden" name="tax_info_en[donation_flood]" value="<?=$tax_info_en['donation_flood']?>">
			</td>
			<th>
				<input class="descri_info" type="text" name="tax_settings_description[donation_education]" value="<?=isset($tax_settings_description['donation_education']) ? $tax_settings_description['donation_education'] : $lng['Donation education']?>">
			</th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" id="donation_education" name="tax_thb[tax_allow_donation_education]" placeholder="..." value="<?=$tax_thb['tax_allow_donation_education']?>"></td>
			<td class="info" id="info_donation_education">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['donation_education']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
				<a class="text-primary mr-1" id="mdl_donation_education" data-th="<?=$tax_info_th['donation_education']?>" data-en="<?=$tax_info_en['donation_education']?>" onclick="openpopupMdl('donation_education');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
				<span><?=mb_strimwidth($tax_info['donation_education'], 0, 7, "...");?></span>

				<input type="hidden" name="tax_info_th[donation_education]" value="<?=$tax_info_th['donation_education']?>">
				<input type="hidden" name="tax_info_en[donation_education]" value="<?=$tax_info_en['donation_education']?>">
			</td>

		</tr>
		
		<tr>
					
			<th>
				<input class="descri_info" type="text" name="tax_settings_description[exemp_disabled]" value="<?=isset($tax_settings_description['exemp_disabled']) ? $tax_settings_description['exemp_disabled'] : $lng['Exemption disabled person <65 yrs']?>">
			</th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px">
				<select class="calcTax" name="tax_number[tax_exemp_disabled_under]" id="exemp_disabled" style="background-color: rgb(249, 249, 209);">
					<?php foreach($yesno as $k=>$v){
							echo '<option ';
							if(strtoupper($tax_number['tax_exemp_disabled_under'])==$k){echo 'selected';}
							echo ' value="'.$k.'">'.$v.'</option>';
					} ?>
				</select>
			</td>
			<td style="width:90px"><input tabindex="-1" readonly class="tar nofocus" type="text" name="tax_thb[tax_allow_exemp_disabled_under]" id="exemp_disabled_under" placeholder="..." value="<?=$tax_thb['tax_allow_exemp_disabled_under']?>"></td>
			<td class="info">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['exemp_disabled_under']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
				<a class="text-primary mr-1" id="mdl_exemp_disabled_under" data-th="<?=$tax_info_th['exemp_disabled_under']?>" data-en="<?=$tax_info_en['exemp_disabled_under']?>" onclick="openpopupMdl('exemp_disabled_under');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
				<span><?=mb_strimwidth($tax_info['exemp_disabled_under'], 0, 7, "...");?></span>

				<input type="hidden" name="tax_info_th[exemp_disabled_under]" value="<?=$tax_info_th['exemp_disabled_under']?>">
				<input type="hidden" name="tax_info_en[exemp_disabled_under]" value="<?=$tax_info_en['exemp_disabled_under']?>">
			</td>

			<th>
				<input class="descri_info" type="text" name="tax_settings_description[exemp_payer]" value="<?=isset($tax_settings_description['exemp_payer']) ? $tax_settings_description['exemp_payer'] : $lng['Exemption tax payer => 65yrs']?>">
			</th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px">
				<select class="calcTax" name="tax_number[tax_exemp_payer_older]" id="exemp_payer" style="background-color: rgb(249, 249, 209);">
					<?php foreach($yesno as $k=>$v){
							echo '<option ';
							if(strtoupper($tax_number['tax_exemp_payer_older'])==$k){echo 'selected';}
							echo ' value="'.$k.'">'.$v.'</option>';
					} ?>
				</select>
			</td>
			<td style="width:90px"><input tabindex="-1" readonly class="tar nofocus" type="text" name="tax_thb[tax_allow_exemp_payer_older]" id="exemp_payer_older" placeholder="..." value="<?=$tax_thb['tax_allow_exemp_payer_older']?>"></td>
			<td class="info">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['exemp_payer_older']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
				<a class="text-primary mr-1" id="mdl_exemp_payer_older" data-th="<?=$tax_info_th['exemp_payer_older']?>" data-en="<?=$tax_info_en['exemp_payer_older']?>" onclick="openpopupMdl('exemp_payer_older');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
				<span><?=mb_strimwidth($tax_info['exemp_payer_older'], 0, 7, "...");?></span>

				<input type="hidden" name="tax_info_th[exemp_payer_older]" value="<?=$tax_info_th['exemp_payer_older']?>">
				<input type="hidden" name="tax_info_en[exemp_payer_older]" value="<?=$tax_info_en['exemp_payer_older']?>">
			</td>
		</tr>
		
		<tr>
					
			<th>
				<input class="descri_info" type="text" name="tax_settings_description[first_home_allowance]" value="<?=isset($tax_settings_description['first_home_allowance']) ? $tax_settings_description['first_home_allowance'] : $lng['First home buyer']?>">
			</th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" id="first_home_allowance" name="tax_thb[tax_allow_first_home]" placeholder="..." value="<?=$tax_thb['tax_allow_first_home']?>"></td>
			<td class="info" id="info_first_home_allow">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['first_home_allowance']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
				<a class="text-primary mr-1" id="mdl_first_home_allowance" data-th="<?=$tax_info_th['first_home_allowance']?>" data-en="<?=$tax_info_en['first_home_allowance']?>" onclick="openpopupMdl('first_home_allowance');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
				<span><?=mb_strimwidth($tax_info['first_home_allowance'], 0, 7, "...");?></span>

				<input type="hidden" name="tax_info_th[first_home_allowance]" value="<?=$tax_info_th['first_home_allowance']?>">
				<input type="hidden" name="tax_info_en[first_home_allowance]" value="<?=$tax_info_en['first_home_allowance']?>">
			</td>
			<th>
				<input class="descri_info" type="text" name="tax_settings_description[year_end_shop_allowance]" value="<?=isset($tax_settings_description['year_end_shop_allowance']) ? $tax_settings_description['year_end_shop_allowance'] : $lng['Year-end shopping']?>">
			</th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" id="year_end_shop_allowance" name="tax_thb[tax_allow_year_end_shopping]" placeholder="..." value="<?=$tax_thb['tax_allow_year_end_shopping']?>"></td>
			<td class="info" id="info_year_end_shop_allow">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['year_end_shop_allowance']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
				<a class="text-primary mr-1" id="mdl_year_end_shop_allowance" data-th="<?=$tax_info_th['year_end_shop_allowance']?>" data-en="<?=$tax_info_en['year_end_shop_allowance']?>" onclick="openpopupMdl('year_end_shop_allowance');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
				<span><?=mb_strimwidth($tax_info['year_end_shop_allowance'], 0, 7, "...");?></span>

				<input type="hidden" name="tax_info_th[year_end_shop_allowance]" value="<?=$tax_info_th['year_end_shop_allowance']?>">
				<input type="hidden" name="tax_info_en[year_end_shop_allowance]" value="<?=$tax_info_en['year_end_shop_allowance']?>">
			</td>

		</tr>
		
		<tr style="border-bottom:1px #ddd solid">
					
			<th>
				<input class="descri_info" type="text" name="tax_settings_description[domestic_tour_allowance]" value="<?=isset($tax_settings_description['domestic_tour_allowance']) ? $tax_settings_description['domestic_tour_allowance'] : $lng['Domestic tour']?>">
			</th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" id="domestic_tour_allowance" name="tax_thb[tax_allow_domestic_tour]" placeholder="..." value="<?=$tax_thb['tax_allow_domestic_tour']?>"></td>
			<td class="info" id="info_domestic_tour_allow">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['domestic_tour_allowance']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
				<a class="text-primary mr-1" id="mdl_domestic_tour_allowance" data-th="<?=$tax_info_th['domestic_tour_allowance']?>" data-en="<?=$tax_info_en['domestic_tour_allowance']?>" onclick="openpopupMdl('domestic_tour_allowance');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
				<span><?=mb_strimwidth($tax_info['domestic_tour_allowance'], 0, 7, "...");?></span>

				<input type="hidden" name="tax_info_th[domestic_tour_allowance]" value="<?=$tax_info_th['domestic_tour_allowance']?>">
				<input type="hidden" name="tax_info_en[domestic_tour_allowance]" value="<?=$tax_info_en['domestic_tour_allowance']?>">
			</td>

			<th>
				<input class="descri_info" type="text" name="tax_settings_description[other_allowance]" value="<?=isset($tax_settings_description['other_allowance']) ? $tax_settings_description['other_allowance'] : $lng['Other allowance']?>">
			</th>
			<td style="width:90px">
				
			</td>
			<td style="width:40px"></td>
			<td style="width:90px"><input class="numeric sel tar" type="text" id="other_allowance" name="tax_thb[tax_allow_other]" placeholder="..." value="<?=$tax_thb['tax_allow_other']?>"></td>
			<td class="info" id="info_other_allowance">
				<img src="/images/info-sign.png" data-toggle="tooltip" title="<?=$tax_info['other_allowance']?>" width="20" height="20" class="mr-1" style="display: inline;"> 
				<a class="text-primary mr-1" id="mdl_other_allowance" data-th="<?=$tax_info_th['other_allowance']?>" data-en="<?=$tax_info_en['other_allowance']?>" onclick="openpopupMdl('other_allowance');"><i class="fa fa-edit fa-lg fa-bold"></i></a>
				<span><?=mb_strimwidth($tax_info['other_allowance'], 0, 7, "...");?></span>

				<input type="hidden" name="tax_info_th[other_allowance]" value="<?=$tax_info_th['other_allowance']?>">
				<input type="hidden" name="tax_info_en[other_allowance]" value="<?=$tax_info_en['other_allowance']?>">
			</td>
		</tr>
		
		<input type="hidden" name="tax_err_th[standard_deduction]" value="<?=$tax_err_th['standard_deduction']?>">
		<input type="hidden" name="tax_err_en[standard_deduction]" value="<?=$tax_err_en['standard_deduction']?>">

		<input type="hidden" name="tax_err_th[parents_allow]" value="<?=$tax_err_th['parents_allow']?>">
		<input type="hidden" name="tax_err_en[parents_allow]" value="<?=$tax_err_en['parents_allow']?>">

		<input type="hidden" name="tax_err_th[parents_inlaw_allow]" value="<?=$tax_err_th['parents_inlaw_allow']?>">
		<input type="hidden" name="tax_err_en[parents_inlaw_allow]" value="<?=$tax_err_en['parents_inlaw_allow']?>">

		<input type="hidden" name="tax_err_th[disabled_allow]" value="<?=$tax_err_th['disabled_allow']?>">
		<input type="hidden" name="tax_err_en[disabled_allow]" value="<?=$tax_err_en['disabled_allow']?>">

		<input type="hidden" name="tax_err_th[child_adopt_allow]" value="<?=$tax_err_th['child_adopt_allow']?>">
		<input type="hidden" name="tax_err_en[child_adopt_allow]" value="<?=$tax_err_en['child_adopt_allow']?>">

		<input type="hidden" name="tax_err_th[own_health_insurance]" value="<?=$tax_err_th['own_health_insurance']?>">
		<input type="hidden" name="tax_err_en[own_health_insurance]" value="<?=$tax_err_en['own_health_insurance']?>">

		<input type="hidden" name="tax_err_th[own_life_insurance]" value="<?=$tax_err_th['own_life_insurance']?>">
		<input type="hidden" name="tax_err_en[own_life_insurance]" value="<?=$tax_err_en['own_life_insurance']?>">

		<input type="hidden" name="tax_err_th[max_own_health_life]" value="<?=$tax_err_th['max_own_health_life']?>">
		<input type="hidden" name="tax_err_en[max_own_health_life]" value="<?=$tax_err_en['max_own_health_life']?>">

		<input type="hidden" name="tax_err_th[health_insurance_par]" value="<?=$tax_err_th['health_insurance_par']?>">
		<input type="hidden" name="tax_err_en[health_insurance_par]" value="<?=$tax_err_en['health_insurance_par']?>">

		<input type="hidden" name="tax_err_th[life_insurance_spouse]" value="<?=$tax_err_th['life_insurance_spouse']?>">
		<input type="hidden" name="tax_err_en[life_insurance_spouse]" value="<?=$tax_err_en['life_insurance_spouse']?>">

		<input type="hidden" name="tax_err_th[pension_fund_allowance]" value="<?=$tax_err_th['pension_fund_allowance']?>">
		<input type="hidden" name="tax_err_en[pension_fund_allowance]" value="<?=$tax_err_en['pension_fund_allowance']?>">

		<input type="hidden" name="tax_err_th[provident_fund_allowance]" value="<?=$tax_err_th['provident_fund_allowance']?>">
		<input type="hidden" name="tax_err_en[provident_fund_allowance]" value="<?=$tax_err_en['provident_fund_allowance']?>">

		<input type="hidden" name="tax_err_th[nsf_allowance]" value="<?=$tax_err_th['nsf_allowance']?>">
		<input type="hidden" name="tax_err_en[nsf_allowance]" value="<?=$tax_err_en['nsf_allowance']?>">

		<input type="hidden" name="tax_err_th[rmf_allowance]" value="<?=$tax_err_th['rmf_allowance']?>">
		<input type="hidden" name="tax_err_en[rmf_allowance]" value="<?=$tax_err_en['rmf_allowance']?>">

		<input type="hidden" name="tax_err_th[max_pension_provident_nsf_rmf]" value="<?=$tax_err_th['max_pension_provident_nsf_rmf']?>">
		<input type="hidden" name="tax_err_en[max_pension_provident_nsf_rmf]" value="<?=$tax_err_en['max_pension_provident_nsf_rmf']?>">

		<input type="hidden" name="tax_err_th[ltf_allowance]" value="<?=$tax_err_th['ltf_allowance']?>">
		<input type="hidden" name="tax_err_en[ltf_allowance]" value="<?=$tax_err_en['ltf_allowance']?>">

		<input type="hidden" name="tax_err_th[home_loan_interest]" value="<?=$tax_err_th['home_loan_interest']?>">
		<input type="hidden" name="tax_err_en[home_loan_interest]" value="<?=$tax_err_en['home_loan_interest']?>">

		<input type="hidden" name="tax_err_th[donation_charity]" value="<?=$tax_err_th['donation_charity']?>">
		<input type="hidden" name="tax_err_en[donation_charity]" value="<?=$tax_err_en['donation_charity']?>">

		<input type="hidden" name="tax_err_th[donation_flood]" value="<?=$tax_err_th['donation_flood']?>">
		<input type="hidden" name="tax_err_en[donation_flood]" value="<?=$tax_err_en['donation_flood']?>">

		<input type="hidden" name="tax_err_th[donation_education]" value="<?=$tax_err_th['donation_education']?>">
		<input type="hidden" name="tax_err_en[donation_education]" value="<?=$tax_err_en['donation_education']?>">

		<input type="hidden" name="tax_err_th[first_home_allowance]" value="<?=$tax_err_th['first_home_allowance']?>">
		<input type="hidden" name="tax_err_en[first_home_allowance]" value="<?=$tax_err_en['first_home_allowance']?>">

		<input type="hidden" name="tax_err_th[year_end_shop_allowance]" value="<?=$tax_err_th['year_end_shop_allowance']?>">
		<input type="hidden" name="tax_err_en[year_end_shop_allowance]" value="<?=$tax_err_en['year_end_shop_allowance']?>">

		<input type="hidden" name="tax_err_th[domestic_tour_allowance]" value="<?=$tax_err_th['domestic_tour_allowance']?>">
		<input type="hidden" name="tax_err_en[domestic_tour_allowance]" value="<?=$tax_err_en['domestic_tour_allowance']?>">

			
	</tbody>
</table>

<div class="modal fade" id="modalEditinfo" tabindex="-1" role="dialog" aria-labelledby="modalEditinfoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditinfoLabel"><?=$lng['TAX info']?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="appendata">
       	
       	<!----- appended data here ------>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-fr" data-dismiss="modal">Close</button>
        <button id="submitbtn" type="submit" class="btn btn-primary btn-fr">Save</button>
      </div>
    </div>
  </div>
</div>
		
<script>

		function openpopupMdl(arrVal){

			var tax_info_th = <?=json_encode($tax_info_th)?>;
			var tax_info_en = <?=json_encode($tax_info_en)?>;

			var name_th = 'tax_info_th['+arrVal+']';
			var name_en = 'tax_info_en['+arrVal+']';

			var val_th = $('#mdl_'+arrVal).data("th");
			var val_en = $('#mdl_'+arrVal).data("en");

			var data = '<div class="row">';
		       	data +=	'<div class="col-md-12">';
		       		data +='<label style="font-weight: 600;">English</label>';
		       			data +='<textarea rows="4" name="'+name_en+'" type="text" class="form-control">'+val_en+'</textarea>';
		       		data +='</div>';
		       	data +='</div>';

		       	data +='<div class="row mt-3">';
		       		data +='<div class="col-md-12">';
		       			data +='<label style="font-weight: 600;">Thai</label>';
		       			data +='<textarea rows="4" name="'+name_th+'" type="text" class="form-control">'+val_th+'</textarea>';
		       		data +='</div>';
		       	data +='</div>';

			$('#modalEditinfo #appendata div').remove();
			$('#modalEditinfo #appendata').append(data);

			$('#modalEditinfo').modal('toggle');
		} 

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

		//stDeducChkbox();
		function stDeducChkbox(that){
			if($(that).is(':checked')){
				$('#standard_deduction').css({'pointer-events': 'none','background-color':'#ffffff !important'});
				$('#standard_deduction').val('');
			}else{
				$('#standard_deduction').css({'pointer-events': 'auto','background-color':'#f9f9d1'});
			}
		}

		//PersoCareChkbox();
		function PersoCareChkbox(that){
			if($(that).is(':checked')){
				$('#personal_allowance').css({'pointer-events': 'none','background-color':'#ffffff !important'});
				$('#personal_allowance').val('');
			}else{
				$('#personal_allowance').css({'pointer-events': 'auto','background-color':'#f9f9d1'});
			}
		}

		//ProFundChkbox()
		function ProFundChkbox(that){
			if($(that).is(':checked')){
				$('#tax_allow_pvf').css({'pointer-events': 'none','background-color':'#ffffff !important'});
				$('#tax_allow_pvf').val('');
			}else{
				$('#tax_allow_pvf').css({'pointer-events': 'auto','background-color':'#f9f9d1'});
			}
		}

		//SSFChkbox();
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
		//var basic_salary = <?=json_encode($data['base_salary'])?>;
		
		calculateDeductions()
		CheckUnitVal(1,'parents_allow','parents_allowance')
		CheckUnitVal(1, 'parents_inlaw_allow', 'parents_inlaw_allowance')
		CheckUnitVal(1, 'disabled_allow', 'disabled_allowance')
		CheckUnitVal(1, 'child_allow', 'child_allowance')
		CheckUnitVal(1, 'child_allow_2018', 'child_allowance_2018')
		CheckUnitVal(1, 'child_adopt_allow', 'child_adopt_allowance')
		
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
		


		
		
		
		
		
		
		
		
		
		
		
		
		
