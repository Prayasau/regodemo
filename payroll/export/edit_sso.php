<?
	if(!isset($_GET['sm']) || $_GET['sm'] == ''){
		header('Location: index.php?mn=422&sm=44');
	}

	$getPayrollModels = getPayrollModels();
	$getCompany = getEntities();
	$pperiods = getSSOEmpRate($cid);

	$sso_codes = array();
	$banks = array();
	if(count($getCompany) <= 1){
		$sso_codes = unserialize($getCompany[1]['sso_codes']);
		$banks = unserialize($getCompany[1]['banks']);
	}

	$eatt_cols = array();
	$eatt_cols[2] = array('position',$lng['Position']);
	$eatt_cols[] = array('entity',$lng['Company']);
	$eatt_cols[] = array('branch',$lng['Location']);
	$eatt_cols[] = array('division',$lng['Division']);
	$eatt_cols[] = array('department',$lng['Department']);
	$eatt_cols[] = array('team',$lng['Teams']);

	end($eatt_cols);
	$last_col = key($eatt_cols) + 1;

	$resED = $dbc->query("SELECT modify_empdata_showhide_cols FROM ".$_SESSION['rego']['cid']."_sys_settings");
	$rowED = $resED->fetch_assoc();
	$shCols = unserialize($rowED['modify_empdata_showhide_cols']);

	$emptyCols = array();
	if(!$shCols){$shCols = array();}
	foreach($eatt_cols as $k=>$v){
		if(!in_array($k, $shCols)){
			$emptyCols[] = $k;
		}
	}


	//echo "<pre>";
	//print_r($pperiods);
	//print_r($banks);
	//echo "</pre>";

?>
<style type="text/css">
.smallNav {
	background: #fff;
	height:31px; 
	padding:0; 
	font-weight:600;
	margin: 10px;
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
.customSelectcss {
    padding: 5px 8px !important;

}
table.basicTable.inputs input.inputbkg{
	background: #f9f7dd !important;
}

#ssotab_Parameters .SumoSelect {
    padding: 5px 5px 5px 10px !important;
    border: none !important;
    width: auto !important;
    display: block !important;
}

</style>
<h2 style="padding-right:60px">
	<i class="fa fa-wpforms"></i>&nbsp; <?=$lng['SSO Form']?>
	<!-- <span style="display:none; font-style:italic; color:#b00; padding-left:30px;float: right;" id="sAlert"><i class="fa fa-exclamation-triangle fa-mr"></i><?=$lng['Data is not updated to last changes made']?></span> -->
</h2>

<div class="main">
	<div style="padding:0 0 0 20px" id="dump"></div>
	<form style="height: 100%;">
		<ul class="nav nav-tabs" id="myTab" style="">

			<li class="nav-item"><a class="nav-link active" href="#ssotab_Parameters" data-toggle="tab"><?=$lng['Parameters']?></a></li>
			<li class="nav-item"><a class="nav-link" href="#ssotab_Empgrp" data-toggle="tab"><?=$lng['Emp. Groups']?></a></li>
			<li class="nav-item"><a class="nav-link" href="#ssotab_Empdata" data-toggle="tab"><?=$lng['Employee Data']?></a></li>
			<li class="nav-item"><a class="nav-link" href="#ssotab_SSOform" data-toggle="tab"><?=$lng['SSO Form']?></a></li>
			<li class="nav-item"><a class="nav-link" href="#ssotab_Vcenter" data-toggle="tab"><?=$lng['Verification Center']?></a></li>
		</ul>

		<button disabled class="btn btn-primary btn-fr" style="margin:0; position:absolute; right:18px; top:18px" type="button"><i class="fa fa-save fa-mr"></i><?=$lng['Update']?></button>

		<button class="btn btn-primary btn-fr" style="margin:0; position:absolute; right:104px; top:18px" type="button" onclick="window.location.href='index.php?mn=421';"><?=$lng['Go back']?></button>

		<div class="tab-content" style="height:100%;padding-left: 4px;">

			<div class="tab-pane active" id="ssotab_Parameters">
				<table class="basicTable inputs">
					<tbody>
						<tr>
							<th><?=$lng['Payroll Models']?></th>
							<td>
								<select id="defincombase" multiple="multiple" name="payroll_model[]" style="width:auto; min-width:100%;">
									<? foreach ($getPayrollModels['PayrollModel'] as $value) { ?>
										<?// if($key == $_SESSION['rego']['cur_month']){ $sel= 'selected';}else{$sel='disabled';}
										echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';?>
									<? } ?>
								</select>
							</td>
						</tr>
						<tr>
							<th><?=$lng['Month']?></th>
							<td>
								<select name="" style="width: 100%;">
									<? foreach ($months as $key => $value) {
										if($key == $_SESSION['rego']['cur_month']){ $sel= 'selected';}else{$sel='disabled';}
										echo '<option value="'.$key.'" '.$sel.'>'.$value.'</option>';
									} ?>
								</select>


							</td>
						</tr>
						<tr>
							<th><?=$lng['Select Company']?></th>
							<td>
								<select id="selcomp" name="select_company" style="width: 100%;" onchange="getDetails();">
									<!-- <option value=""><?=$lng['Please select']?></option> -->
									<? foreach ($getCompany as $key => $value) {
										echo '<option value="'.$key.'">'.$value[$lang].'</option>';
									} ?>
								</select>
							</td>
						</tr>
						<tr>
							<th><?=$lng['SSO Branches']?></th>
							<td>
								<select id="selssobran" name="select_sso_branches" style="width: 100%;" onchange="getDetails();">
									<? foreach ($sso_codes as $key => $value) {
										echo '<option value="'.$key.'">'.$value[$lang].'</option>';
									} ?>
								</select>
							</td>
						</tr>
					</tbody>
				</table>
				<table class="basicTable inputs">
					<thead>
						<tr>
							<th colspan="2"><?=$lng['Company information']?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th><?=$lng['Company name']?></th>
							<td>
								<input type="text" name="company_name" value="<?=$getCompany[1][$lang]?>" readonly>
							</td>
						</tr>
						<tr>
							<th><?=$lng['Tax ID nr']?></th>
							<td>
								<input type="text" name="tax_id_no" value="<?=$getCompany[1]['tax_id']?>" readonly>
							</td>
						</tr>
						<tr>
							<th><?=$lng['Branch name']?></th>
							<td>
								<input type="text" name="branch_name" value="<?=$sso_codes[1][$lang]?>" readonly>
							</td>
						</tr>
						<tr>
							<th><?=$lng['Head office branch']?></th>
							<td>
								<input type="text" name="head_office_branch" value="<?=$sso_codes[1][$lang]?>" readonly>
							</td>
						</tr>
						<tr>
							<th><?=$lng['Postal code']?></th>
							<td>
								<input type="text" name="postal_code" value="<?=$sso_codes[1]['postal_'.$lang]?>" readonly>
							</td>
						</tr>
						<tr>
							<th><?=$lng['Phone']?></th>
							<td>
								<input type="text" name="phone" value="<?=$getCompany[1]['comp_phone']?>" readonly>
							</td>
						</tr>
						<tr>
							<th><?=$lng['Fax']?></th>
							<td>
								<input type="text" name="fax" value="<?=$getCompany[1]['comp_fax']?>" readonly>
							</td>
						</tr>
						<tr>
							<th><?=$lng['Account no.']?></th>
							<td>
								<input type="text" name="account_no" value="<?=$banks[1]['number']?>" readonly>
							</td>
						</tr>
						<tr>
							<th><?=$lng['Branch']?> no.</th>
							<td>
								<input type="text" name="branch_no" value="<?=$sso_codes[1]['code']?>" readonly>
							</td>
						</tr>						
						
					</tbody>
					<thead>
						<tr>
							<th colspan="2"><?=$lng['Other settings']?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th><?=$lng['Contribution rate']?></th>
							<td>
								<input type="text" class="inputbkg" name="contribution_rate" value="<?=$pperiods['crate']?>">
							</td>
						</tr>
						<tr>
							<th><?=$lng['Personal identification number']?></th>
							<td>
								<input type="text" name="pin" class="inputbkg">
							</td>
						</tr>
					</tbody>
					<thead>
						<tr>
							<th colspan="2"><?=$lng['Responsible filing']?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th><?=$lng['Signature name']?></th>
							<td>
								<input type="text" name="signature_name" class="inputbkg">
							</td>
						</tr>
						<tr>
							<th><?=$lng['Position']?></th>
							<td>
								<input type="text" name="position" class="inputbkg">
							</td>
						</tr>	
						<tr>
							<th><?=$lng['Filing date']?></th>
							<td>
								<input type="text" class="datepick inputbkg" name="filling_date">
							</td>
						</tr>
					</tbody>

				</table>
			</div>

			<div class="tab-pane" id="ssotab_Empgrp">

				<? include('tabs/tab_emp_groups.php');?>
			</div>

			<div class="tab-pane" id="ssotab_Empdata">

				<? include('tabs/tab_emp_data.php');?>
			</div>

			<div class="tab-pane" id="ssotab_SSOform">

				<? include('tabs/tab_sso_form.php');?>
			</div>

			<div class="tab-pane" id="ssotab_Vcenter">

				Verification Center
			</div>

		</div>
	</form>
</div>
<script type="text/javascript">

	function getDetails(){

		var comp_select = $('#selcomp').val();
		var sso_branch = $('#selssobran').val();

		$.ajax({
			url: "ajax/get_company_branch_info.php",
			data: {comp_select: comp_select, sso_branch: sso_branch},
			dataType: 'json',
			success: function(result){

				$('input[name="company_name"]').val(result.companyInfo.en);
				$('input[name="tax_id_no"]').val(result.companyInfo.tax_id);
				$('input[name="branch_name"]').val(result.ssoBranch.en);
				$('input[name="head_office_branch"]').val(result.ssoBranch.en);
				$('input[name="postal_code"]').val(result.companySSO[sso_branch].postal_en);
				$('input[name="phone"]').val(result.companyInfo.comp_phone);
				$('input[name="fax"]').val(result.companyInfo.comp_fax);
				$('input[name="account_no"]').val(result.companyBank[comp_select].number);
				$('input[name="branch_no"]').val(result.ssoBranch.code);

			}
		})
	}
	
	$(document).ready(function() {

		$('#defincombase').SumoSelect({
			placeholder: '<?=$lng['Select'].' '.$lng['Payroll Models']?>',
			captionFormat: '<?=$lng['Payroll Models']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All'].' '.$lng['Payroll Models']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:false, 
			showTitle : false,
			triggerChangeCombined: true,
		});

		var activeTabPay = localStorage.getItem('activeTabPaysso');
		if(activeTabPay){
			$('.nav-link[href="' + activeTabPay + '"]').tab('show');
		}else{
			$('.nav-link[href="#ssotab_Parameters"]').tab('show');
		}

		$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {

			localStorage.setItem('activeTabPaysso', $(e.target).attr('href'));
		});


		$('input, textarea').on('keyup', function (e) {
			$("#submitBtn").addClass('flash');
			$("#sAlert").fadeIn(200);
		});
		$('select, .checkbox').on('change', function (e) {
			$("#submitBtn").addClass('flash');
			$("#sAlert").fadeIn(200);
		});

	});
</script>

