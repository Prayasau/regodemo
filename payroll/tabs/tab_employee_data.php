<style type="text/css">
.SumoSelect {
    padding: 4px !important; 
    border: none;
    width: 100% !important;
}

.SumoSelect > .optWrapper > .options li.opt {
	width: 100% !important;
}

.smallNav {
	background: #ffc;
	height:31px; 
	padding:0; 
	border-bottom:1px solid #ddd;
	font-weight:600;
}
.smallNav ul {
	display:inline-block;
	padding:0;
	margin:0;
	width:100%;
}
.smallNav li {
	display:inline-block;
	margin:0;
	padding:0;
}
.smallNav li.flr {
	float:right;
}
.smallNav li.flr a {
	border-right:0;
	border-left:1px solid #ddd;
}
.smallNav li a {
	display:block;
	line-height:30px;
	padding:0 15px;
	color:#333;
	text-decoration:none;
	border-right:1px solid #ddd;
}
.smallNav li a:hover {
	background: rgba(0,0,0,0.1);
	color:#000;
}
.smallNav li a.activ {
	background: rgba(0,0,0,0.1);
	color:#000;
}

#datatables11 input[type=text]:hover {
    width: 184px!important;
}

</style>

<div style="height:100%; border:0px solid red; position:relative;">
	<div>
		<div class="smallNav">
			<ul>
	
				<li>
					<div class="searchFiltered ml-3" style="margin:0 0 8px 0;margin-left: 0px!important;">
						<input placeholder="Search filter..." class="sFilter" id="searchFiltered" type="text" style="margin:0;border: 1px #ddd solid; background: #ffffff;width: auto;" autocomplete="off">
					</div>
				</li>
				<li style="position: absolute;">
					<button style="border: 0;padding: 3px 11px !important;line-height: 26px !important;margin: 0;color: #ccc;border-radius: 0 !important;background: #eee;" id="clearSearchbox_tab_emp_data" type="button" class="clearFilter"><i class="fa fa-times"></i></button>

				</li>

				<!-- <li>
					<select class="button" id="empStatus" style="background: #ffffcc;font-weight: 600;">
						<option selected value=""><?=$lng['All employees']?></option>
						<? foreach($emp_status as $k=>$v){
								echo '<option';
								if($k == 1){echo ' selected';}
								echo ' value="'.$k.'">'.$v.'</option>';
							} ?>
					</select>
				</li> -->
				<!-- <li class="flr"><a onclick="history.back()"><i class="fa fa-arrow-left"></i> <?=$lng['Go back']?></a></li> -->

				<!--<li  id= "sumoselect1" style="position: absolute;left: 231px;">
					<select multiple="multiple" id="showColsF" style="background: #ffffff;font-weight: 600;padding: 1px !important;">
					<?	/*foreach($eatt_cols as $k=>$v){
							echo '<option class="optCol" value="'.$k.'" ';
							if(in_array($k, $shCols)){echo 'selected ';}
							echo '>'.$v[1].'</option>';
					}*/ ?>
					</select>
				</li>-->

				<li id="sumoselect2" style="position: absolute;left: 231px;width: 18%;">
					<select multiple="multiple" id="showColsFSection" style="background: #ffffff;font-weight: 600;padding: 1px !important;">
					<?  foreach($section_cols as $k=>$v){
							echo '<option class="optCol" value="'.$k.'" ';
							if(in_array($k, $shColsEmpdatasection)){echo 'selected ';}
							echo '>'.$v[1].'</option>';
					} ?>
					</select>
				</li>

				<!-- <li class="flr" onclick="getAllChkData(this)"><a class="text-white bg-success"> <?=$lng['Fetch Employee Data']?></a></li> -->
				
				<!-- <li class="flr Clearselection">
					<a class="text-danger font-weight-bold"><i class="fa fa-trash"></i> <?=$lng['Clear Selection']?></a>
				</li> -->				
			</ul>
		</div>
	</div>


	<table id="datatables11" class="dataTable hoverable selectable nowrap">
		<thead>
			<tr class="firstheader">
				<th colspan="5" class="tac"></th>
				<th colspan="<?=count($getonlyapplyAllowDeduct) +1?>" class="tac"><?=$lng['Current Benefits Payroll of this month']?></th>
				<th colspan="15" class="tac"><?=$lng['Wage']?> <?=$lng['Condition']?></th>
				<th colspan="5" class="tac"><?=$lng['Tax deductions']?></th>
				<th colspan="4" class="tac"><?=$lng['Monthly Legal deductions']?></th>
				<th colspan="6" class="tac"><?=$lng['End contract']?></th>
				<th colspan="8" class="tac"><?=$lng['Employee Data']?></th>
				
			</tr>
			<tr>

				<th class="par30"><?=$lng['Emp. ID']?></th>
				<th class="tal par30"><?=$lng['Employee name']?></th>
				<th class="tac" style="cursor: pointer;">
					<i data-toggle="tooltip" title="Select all" class="SelallempData fa fa-thumbs-up fa-lg"></i>
					<i data-toggle="tooltip" title="Unselect all" class="unSelallempData fa fa-thumbs-down fa-lg" style="display:none;"></i>
				</th>
				
				<th class="tal"><?=$lng['Calc']?></th>
				<th class="tal"><?=str_replace(' ', '<br>', $lng['Days paid'])?></th>
				
				<th class="tal"><?=$lng['Basic salary']?></th>
				<?foreach($getonlyapplyAllowDeduct as $d){ ?>
					<th class="tal"><?=str_replace(' ', '<br>',$d[$lang])?></th>
				<? } ?>

				<th class="tal"><?=str_replace(' ', '<br>', $lng['Calculate Tax'])?></th>
				<th class="tal"><?=str_replace(' ', '<br>', $lng['Calculate SSO'])?></th>
				<th class="tal"><?=str_replace(' ', '<br>', $lng['Calculate PVF'])?></th>
				<th class="tal"><?=str_replace(' ', '<br>', $lng['Calculate PSF'])?></th>
				<th class="tal"><?=str_replace(' ', '<br>', $lng['Tax calculation method'])?></th>

				<th class="tac"><?=str_replace(' ', '<br>', $lng['Modify tax'])?></th>
				<th class="tac"><?=str_replace(' ', '<br>', $lng['PVF'])?><br><?=$lng['% or THB']?></th>
				<th class="tac"><?=str_replace(' ', '<br>', $lng['PSF'])?><br><?=$lng['% or THB']?></th>

				<th class="tal"><?=str_replace(' ', '<br>', $lng['PVF rate employee'])?></th>
				<th class="tal"><?=str_replace(' ', '<br>', $lng['PVF rate employer'])?></th>
				<th class="tal"><?=str_replace(' ', '<br>', $lng['PSF rate employee'])?></th>
				<th class="tal"><?=str_replace(' ', '<br>', $lng['PSF rate employer'])?></th>
				<th class="tal"><?=str_replace(' ', '<br>', $lng['Contract type'])?></th>
				<th class="tal"><?=str_replace(' ', '<br>', $lng['Calculation base'])?></th>
				<th class="tal"><?=str_replace(' ', '<br>', $lng['SSO paid by'])?></th>

				<th class="tal"><?=str_replace(' ', '<br>', $lng['Standard deduction'])?></th>
				<th class="tal"><?=str_replace(' ', '<br>', $lng['Personal care'])?></th>
				<th class="tal"><?=str_replace(' ', '<br>', $lng['Provident fund'])?></th>
				<th class="tal"><?=str_replace(' ', '<br>', $lng['Social Security Fund'])?></th>
				<th class="tal"><?=str_replace(' ', '<br>', $lng['Other'].' '.$lng['Deduction'])?></th>

				<th class="tal"><?=str_replace(' ', '<br>', $lng['Government house banking'])?></th>
				<th class="tal"><?=str_replace(' ', '<br>', $lng['Savings'])?></th>
				<th class="tal"><?=str_replace(' ', '<br>', $lng['Legal execution deduction'])?></th>
				<th class="tal"><?=str_replace(' ', '<br>', $lng['Kor.Yor.Sor (Student loan)'])?></th>

				<th class="tal"><?=str_replace(' ', '<br>', $lng['Remaining salary'])?></th>
				<th class="tal"><?=str_replace(' ', '<br>', $lng['Notice payment'])?></th>
				<th class="tal"><?=str_replace(' ', '<br>', $lng['Paid leave'])?></th>
				<th class="tal"><?=$lng['Severance']?></th>
				<th class="tal"><?=str_replace(' ', '<br>', $lng['Legal deductions'])?></th>
				<th class="tal"><?=str_replace(' ', '<br>', $lng['Other income'])?></th>

				<th class="tal"><?=$lng['Position']?></th>
				<th class="tal"><?=$lng['Company']?></th>
				<th class="tal"><?=$lng['Location']?></th>
				<th class="tal"><?=$lng['Division']?></th>
				<th class="tal"><?=$lng['Department']?></th>
				<th class="tal"><?=$lng['Teams']?></th>
				<th class="tal"><?=str_replace(' ', '<br>',$lng['Joining date'])?></th>
				<th class="tal"><?=$lng['Resigned']?><br><?=$lng['Date']?></th>
				
			</tr>
		</thead>
		<tbody>
			<? foreach($getSelmonPayrollDatass as $key => $row){ 

				//$GetAllowDeductdata = getEmployeeAllowances($row['emp_id'],$_SESSION['rego']['curr_month']);
				$GetAllowDeductfix = unserialize($row['fix_allow_from_emp']);
				$GetAllowDeductded = unserialize($row['fix_deduct_from_emp']);
				$incomeCalc_total = unserialize($row['incomeCalc_total']);

				$ssoBy = '';
				if($row['sso_by'] == '0'){ $ssoBy = 'Employee';}elseif($row['sso_by'] == '1'){ $ssoBy = 'Company';}

				$empinfo = getEmployeeInfo($_SESSION['rego']['cid'], $row['emp_id']);
				$legal_deductions = $row['gov_house_banking'] + $row['savings'] + $row['legal_execution'] + $row['kor_yor_sor'];

				$paiddaysval = '';
				$empSalary = '';
				if($row['contract_type'] == 'month'){
					$paiddaysval = $row['paid_days'];
					$empSalary = isset($incomeCalc_total[56]) ? remove_comma($incomeCalc_total[56]) : $row['salary'];
					$empSalary = number_format($empSalary,2);
				}elseif($row['contract_type'] == 'day'){
					$paiddaysval = 'Day';
					$empSalary = 'Daily wage';
				}

				/*$calclinkIcon='';
				if(date('m', strtotime($empinfo['joining_date'])) < $_SESSION['rego']['curr_month'] && date('m', strtotime($empinfo['resign_date'])) > $_SESSION['rego']['curr_month'] && date('m', strtotime($GetAllowDeductdata[0]['start_date'])) < $_SESSION['rego']['curr_month']){

					$calclinkIcon = '<i class="fa fa-calculator fa-lg" onclick="opencalculator(this,1)" data-id="'.$row['emp_id'].'" style="cursor: pointer;"></i>';

				}elseif(date('m', strtotime($empinfo['joining_date'])) == $_SESSION['rego']['curr_month'] && date('m', strtotime($empinfo['resign_date'])) == $_SESSION['rego']['curr_month'] && date('m', strtotime($GetAllowDeductdata[0]['start_date'])) == $_SESSION['rego']['curr_month']){

					$calclinkIcon = '<a onclick="opencalculator(this,2)" data-id="'.$row['emp_id'].'"><i class="fa fa-calculator fa-lg"></i></a>';
				}else{
					
				}*/

			?>
				<tr>	
					<!-- <td><?=$empinfo['emp_id_editable']?></td> --><td><?=$row['emp_id']?></td>
					<td><?=$row['emp_name_'.$lang]?></td>
					<td class="tac">
						<input type="checkbox" name="chkget[]" class="checkbox-custom-blue empchkboxData emp_<?=$row['emp_id']?>" id="<?=$row['emp_id']?>" onclick="CHeckEmpChkboc(this)" style="left:0px !important;">
					</td>
					<!--<td class="tal">
						<?/* if($row['contract_type'] == 'month'){ ?>
							<?=$calclinkIcon;?>
						<? } */?>
					</td>-->
					<td class="tac">
						<? if($row['salary']){ ?>
							<a onclick="opencalculator(this,1,'<?=$row['emp_id']?>')" data-id="<?=$row['emp_id']?>"><i class="fa fa-calculator fa-lg"></i></a>
						<? } ?>
					</td>

					<td class="tar"><?=$paiddaysval;?></td>
					<td class="tar"><?=$empSalary;?></td>

					<? if(!empty($GetAllowDeductfix)){ ?>

						<? foreach($GetAllowDeductfix as $k => $v){?>
							<td><?=isset($incomeCalc_total[$k]) ? remove_comma($incomeCalc_total[$k]) : $v?></td>
						<? } ?>
						<? foreach($GetAllowDeductded as $k => $v){?>
							<td><?=isset($incomeCalc_total[$k]) ? remove_comma($incomeCalc_total[$k]) : $v?></td>
						<? } ?>

					<?  }else{ ?>

						<?foreach($getonlyapplyAllowDeduct as $d){ ?>
							<td></td>
						<? } ?>

					<? }  ?>
					

				
					<td><?=$noyes01[$row['calc_tax']]?></td>
					<td><?=$noyes01[$row['calc_sso']]?></td>
					<td><?=$noyes01[$row['calc_pvf']]?></td>
					<td><?=$noyes01[$row['calc_psf']]?></td>
					<td><?=$row['calc_method']?></td>

					<td class="tar"><?=number_format($row['modify_tax'],2)?></td>
					<td><?=$per_or_thb[$row['perc_thb_pvf']]?></td>
					<td><?=$per_or_thb[$row['perc_thb_psf']]?></td>

					<td><?=$row['pvf_rate_emp']?></td>
					<td><?=$row['pvf_rate_com']?></td>
					<td><?=$row['psf_rate_emp']?></td>
					<td><?=$row['psf_rate_com']?></td>
					<td><?=$row['contract_type']?></td>
					<td><?=$row['calc_base']?></td>
					<td><?=$ssoBy?></td>

					<?php if($row['calc_on_sd']==1){$tsd='Calc';}else{$tsd=$row['tax_standard_deduction'];}?>
					<?php if($row['calc_on_pc']==1){$tpa='Calc';}else{$tpa=$row['tax_personal_allowance'];}?>
					<?php if($row['calc_on_pf']==1){$tpf='Calc';}else{$tpf=$row['tax_allow_pvf'];}?>
					<?php if($row['calc_on_ssf']==1){$tsf='Calc';}else{$tsf=$row['tax_allow_sso'];}?>

					<td><?=$tsd?></td>
					<td><?=$tpa?></td>
					<td><?=$tpf?></td>
					<td><?=$tsf?></td>
					<td class="tar"><?=number_format($row['total_other_tax_deductions'],2)?></td>

					<td class="tar"><?=number_format($row['gov_house_banking'],2)?></td>
					<td class="tar"><?=number_format($row['savings'],2)?></td>
					<td class="tar"><?=number_format($row['legal_execution'],2)?></td>
					<td class="tar"><?=number_format($row['kor_yor_sor'],2)?></td>

					<td class="tar"><?=number_format($row['remaining_salary'],2)?></td>
					<td class="tar"><?=number_format($row['notice_payment'],2)?></td>
					<td class="tar"><?=number_format($row['paid_leave'],2)?></td>
					<td class="tar"><?=number_format($row['severance'],2)?></td>
					<td class="tar"><?=number_format($legal_deductions,2)?></td>
					<td class="tar"><?=number_format($row['other_income'],2)?></td>

					<td><?=$positions[$row['position']][$lang]?></td>
					<td><?=$entities[$row['entity']][$lang]?></td>
					<td><?=$branches[$row['branch']][$lang]?></td>
					<td><?=$divisions[$row['division']][$lang]?></td>
					<td><?=$departments[$row['department']][$lang]?></td>
					<td><?=$teams[$row['team']][$lang]?></td>
					<td>
						<? if($row['salary']){ ?>
							<?=date('d-m-Y', strtotime($empinfo['joining_date']))?>
						<? } ?>
					</td>
					<td><? if($empinfo['resign_date'] !=''){ ?><?=date('d-m-Y', strtotime($empinfo['resign_date']))?> <? } ?></td>
					
				</tr>
			<? } ?>
		</tbody>
	</table>
	<div class="row">
		<div class="col-md-2" style="margin: -30px 0px 0px 0px;margin-left: auto;margin-right: auto;">
			<select id="pageLengthed" class="button btn-fl">
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

<script type="text/javascript">

$(document).ready(function(){
	$('.SelallempData').click(function(){
		$('.empchkboxData').prop('checked',false);
		$('.empchkboxData').removeClass('selectedChk');

		$('.empchkboxData').prop('checked',true);
		$('.empchkboxData').addClass('selectedChk');

		$('.unSelallempData').css('display','block');
		$('.SelallempData').css('display','none');
	});

	$('.unSelallempData').click(function(){
		$('.empchkboxData').prop('checked',false);
		$('.empchkboxData').removeClass('selectedChk');

		$('.unSelallempData').css('display','none');
		$('.SelallempData').css('display','block');
	});
});


</script>