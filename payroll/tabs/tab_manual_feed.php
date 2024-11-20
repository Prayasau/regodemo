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

#ManualFeedDT input[type=text]{
	border:none !important;
}

#ManualFeedDT input[type=text]:hover{
	border:none !important;
}

table#ManualFeedDT tbody tr td{
	padding: 0px;
}

#manualfeedmdlss table.basicTable tbody th input[type=text]:hover {
    width: 80px!important;
}

#manualfeedmdlss table.basicTable tbody th {

	padding: 2px !important;
}

#manualfeedmdlss input[type=text], #manualfeedmdlss input[type=text]:hover {
	border: none;
	width: 80px;
}

</style>
<?php
// echo '<pre>';
// print_r($payrollparametersformonth);
// print_r($getAttendAllowDeduct);
// echo '</pre>';
//die();
?>

<div style="height:100%; border:0px solid red; position:relative;">
	<div>
	
		<div class="smallNav">
			<ul>
				<!-- <li>
					<a class="font-weight-bold" style="color:#005588;border-right: none;"><?=$lng['Monthly attendance']?> 

						<span class="hide-480 ml-2"><i class="fa fa-arrow-circle-right"></i>&nbsp;&nbsp;<?=$months[$_SESSION['rego']['cur_month']].' '.$_SESSION['rego']['year_'.$lang]?>&nbsp;&nbsp;</span>
					</a>
				</li> -->

				<li>
					<div class="searchFilterm ml-3" style="margin: 0 0 8px 0;margin-left: 0px!important;">
						<input placeholder="Search filter..." id="searchFilterm" class="sFilter" type="text" style="margin:0;border: 1px #ddd solid; background: #ffffff;width: auto;" autocomplete="off">
					</div>
				</li>		
				<li style="position: absolute;">
					
					<button style="border: 0;padding: 3px 11px !important;line-height: 26px !important;margin: 0;color: #ccc;border-radius: 0 !important;background: #eee;" id="clearSearchboxm" type="button" class="clearFilter"><i class="fa fa-times"></i></button>
					
				</li>

				<li class="flr" id="mfeedsel" style="position: absolute;left: 230px;">
					<select multiple="multiple" id="showColsMF" style="background: #ffffff;font-weight: 600;padding: 1px !important;">
					<?

					foreach($dropdownArray as $k=>$v1){
						if($v1 == 'Absence (hrs)'){ $defsel="ddefsel";}else{$defsel="";}
						echo '<option class="optCol '.$defsel.'" value="'.$k.'" ';
						if(in_array($k, $shColsmf)){echo 'selected ';}
						echo '>'.$v1.'</option>';
					} 

					?>
					</select>
				</li>

				
			</ul>
		</div>
	</div>
	<?php
	/*echo '<pre>';
	print_r($dropdownArray);
	print_r($dropdownArrayNew);
	echo '</pre>';*/
	?>

	<form id="manualfeedData" method="post">
	<input type="hidden" name="payroll_mdl_id" value="<?=$_GET['mid']?>">
	
		<table id="ManualFeedDT" class="dataTable">
			<thead>
				<tr>
					<th colspan="4" class="tac"><?=$lng['Employee']?></th>
					<th colspan="<?=$countColumn + 2;?>" class="tac"><?=$lng['Attendance & Allowance Data']?></th>				
					
					<th colspan="<?=$countOuter+1;?>" class="tac"><?=$lng['Total allowance in THB']?></th>
					
				</tr>
				<tr>
					<th class="tal"><?=$lng['Emp. ID']?></th>
					<th class="tal" style="width: 130px;"><?=$lng['Employee name']?></th>
					<th class="tac" style="cursor: pointer;">
						<i data-toggle="tooltip" title="Select all" class="SelallManualFeedData fa fa-thumbs-up fa-lg"></i>
						<i data-toggle="tooltip" title="Unselect all" class="unSelallManualFeedData fa fa-thumbs-down fa-lg" style="display:none;"></i>
					</th>
					<th class="tal"><?=$lng['Calc']?></th>
					<th class="tac"><?=$lng['Paid'].'<br>'.$lng['days']?></th>
					<th class="tac"><?=$lng['Paid'].'<br>'.$lng['hours']?></th>
					<? foreach($dropdownArray as $key => $rows){ ?>
						<th class="tal"><?=$rows?></th>
					<? } ?>

					<th class="tac"><?=$lng['Basic salary']?></th>
					<? //if($checkValues > 0){
						 foreach($outerArray as $key => $val){ ?>
							<th class="tac"><?=$val?></th>
					<? } //} ?>
				</tr>
			</thead>
			<tbody>
				<? 

				$contract_type_check = array();
				$checkEmpsalary_check = array();
				$countRow = 0;
				foreach($getSelmonPayrollDatass as $key => $row){ $countRow++; 
						$manual_feed_data = unserialize($row['manual_feed_data']);
						$manual_feed_total = unserialize($row['manual_feed_total']);

						$checkEmpsalary = checkEmpsalaryForCalc($row['emp_id'],$_SESSION['rego']['curr_month']);
						$checkEmpsalary_check[] = $checkEmpsalary;

						if($row['contract_type'] == 'month'){
							$clmroy='readonly'; $adcls='';
							$empSalary = '';
							$empPaid_day = '';
							$hourFormat='';
						}elseif($row['contract_type'] == 'day'){
							$clmroy=''; $adcls='background: #f9f9e2 !important;';
							$empSalary = number_format($row['mf_salary'],2);
							$empPaid_day = $row['paid_days'];
							$hourFormat = 'hourFormat';
							$contract_type_check[] = 1;
						}else{
							$clmroy=''; $adcls=''; $hourFormat='';
							$empSalary = '';
							$empPaid_day = '';
						}
					?>
					<tr data-eid="<?=$row['emp_id']?>" data-sal="<?=$row['salary']?>">
						<td class="pad010 pl-2 font-weight-bold"><?=$row['emp_id']?></td>
						<td class="pad010 pl-2 font-weight-bold"><?=$row['emp_name_'.$lang]?></td>
						<td class="tac">
							<input type="checkbox" name="chkmfget[]" class="checkbox-custom-blue mfchkboxData emp_<?=$row['emp_id']?>" id="<?=$row['emp_id']?>" onclick="CHeckmfChkbox(this)" style="left:0px !important;">
						</td>
						<td class="pad010 tac">
							<? if($checkEmpsalary > 1){ ?>
								<a class="manualfeedmdl" id="<?=$countRow;?>"><i class="fa fa-calculator fa-lg" ></i></a> 
							<? } ?>
						</td>

						<td style="<?=$adcls?>">
							<input style="float: right;width:70px !important;<?=$adcls?>" class="tar float72" type="text" id="paidDays_<?=$countRow?>" name="emp[<?=$row['emp_id']?>][paidDays]" autocomplete="off" value="<?=$empPaid_day?>" <?=$clmroy?>>
						</td>
						<td style="<?=$adcls?>">
							<input style="float: right;width:70px !important;<?=$adcls?>" class="tar <?=$hourFormat?>" type="text" id="paidHours_<?=$countRow?>" name="emp[<?=$row['emp_id']?>][paidHours]" autocomplete="off" value="<?=$row['mf_paid_hour']?>" <?=$clmroy?>>
						</td>

						<?  foreach($dropdownArrayNew as $key => $rows){ 

								if($position = stripos($rows[0],"hrs", 3) == true){
									$ids = 'hrs_'.$rows[1].'_'.$countRow;
									echo '<td style="background: #f9f9e2 !important;"><input style="float: right;width: 100% !important;background: #f9f9e2 !important;" class="tar hourFormat '.$ids.'" type="text"  onchange="Manualfeedcalc('.$rows[1].','.$countRow.')" name="emp['.$row['emp_id'].'][allow_deduct][hrs]['.$rows[1].']" autocomplete="off" value="'.$manual_feed_data['hrs'][$rows[1]].'"></td>';
								}elseif($position = stripos($rows[0],"hours", 5) == true){
									//$newClass = 'float72';
									//if($payrollparametersformonth[$rows[1]]['unitarr'] == 4){ $newClass = 'hourFormat';}
									$ids = 'hours_'.$rows[1].'_'.$countRow;
									echo '<td style="background: #f9f9e2 !important;"><input style="float: right;width: 100% !important;background: #f9f9e2 !important;" class="tar hourFormat '.$ids.'" type="text"  onchange="Manualfeedcalc('.$rows[1].','.$countRow.')" name="emp['.$row['emp_id'].'][allow_deduct][hours]['.$rows[1].']" autocomplete="off" value="'.$manual_feed_data['hours'][$rows[1]].'"></td>';
								}elseif($position = stripos($rows[0],"times", 5) == true){
									//$newClass = 'float72';
									//if($payrollparametersformonth[$rows[1]]['unitarr'] == 4){ $newClass = 'hourFormat';}
									$ids = 'times_'.$rows[1].'_'.$countRow;
									echo '<td style="background: #f9f9e2 !important;"><input style="float: right;width: 100% !important;background: #f9f9e2 !important;" class="tar float72 '.$ids.'" type="text"  onchange="Manualfeedcalc('.$rows[1].','.$countRow.')" name="emp['.$row['emp_id'].'][allow_deduct][times]['.$rows[1].']" autocomplete="off" value="'.$manual_feed_data['times'][$rows[1]].'"></td>';
								}elseif($position = stripos($rows[0],"thb", 3) == true){
									$ids = 'thb_'.$rows[1].'_'.$countRow;
									echo '<td style="background: #f9f9e2 !important;"><input style="float: right;width: 100% !important;background: #f9f9e2 !important;" class="tar float72 '.$ids.'" type="text"  onchange="Manualfeedcalc('.$rows[1].','.$countRow.')" name="emp['.$row['emp_id'].'][allow_deduct][thb]['.$rows[1].']" autocomplete="off" value="'.$manual_feed_data['thb'][$rows[1]].'"></td>';
								}else{
									echo '<td style="background: #f9f9e2 !important;"><input style="float: right;width: 100% !important;background: #f9f9e2 !important;" class="tar float72 '.$ids.'" type="text"  onchange="Manualfeedcalc('.$rows[1].','.$countRow.')" name="emp['.$row['emp_id'].'][allow_deduct][other]['.$rows[1].']" autocomplete="off" value="'.$manual_feed_data['other'][$rows[1]].'"></td>';
								}
							?>
							<? $totalids = 'total_'.$rows[1].'_'.$countRow;?>
							<input style="width: 70px !important;" class="float72" type="hidden" id="<?=$totalids?>" name="emp[<?=$row['emp_id']?>][total][<?=$rows[1]?>]" autocomplete="off" value="<?=$manual_feed_total[$rows[1]]?>">
						<? } ?>

						<td>
							<input style="float: right;width: 100% !important;" class="tar float72" type="text" id="basicSal_<?=$countRow?>" autocomplete="off" value="<?=$empSalary?>" readonly>
						</td>
						<? //if($checkValues > 0){
							 foreach($outerArray as $key => $val){ 
								$totalids = 'total_'.$key.'_'.$countRow;
							?>
							<td>
								<input style="float: right;width: 100% !important;" class="tar float72" type="text" id="<?=$totalids?>" name="emp[<?=$row['emp_id']?>][total][<?=$key?>]" autocomplete="off" value="<?=number_format($manual_feed_total[$key],2)?>">
							</td>
						<? } //} ?>
						
					</tr>
				<? } ?>
			</tbody>
		</table>
	
	</form>

	<?php
	if(in_array(2, $checkEmpsalary_check)){
		$hide2='{"targets": [3], "visible": true, "searchable": true}';
	}else{
		$hide2='{"targets": [3], "visible": false, "searchable": false}';
	}

	$array_slice=false;
	if(in_array(1, $contract_type_check)){
		$eColsMFd11='{"targets": [4,5], "visible": true, "searchable": true},';
		$array_slice=true;
	}else{
		$darr = count($dropdownArray) + 6;
		$eColsMFd11='{"targets": [4,5,'.$darr.'], "visible": false, "searchable": false},';
	}


	if($array_slice){
		array_shift($manualFeedShowhide);
		array_shift($manualFeedShowhide);
	}


	// echo '<pre>';
	// print_r($manualFeedShowhide);
	// echo '</pre>';

	if(count($manualFeedShowhide) > 0){
		foreach($manualFeedShowhide as $v){$eColsMFd .= $v.',';}
		$eColsMFd = '['.substr($eColsMFd,0,-1).']';
		$eColsMFd = '{"targets": '.$eColsMFd.', "visible": false, "searchable": false},';
	}else{
		$eColsMFd = '';
	}

	?>

	<div class="row">
		<div class="col-md-2" style="margin: -30px 0px 0px 0px;margin-left: auto;margin-right: auto;">
			<select id="pageLengthm" class="button btn-fl">
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

<!------ model manual feed ----------->
<div class="modal fade" id="manualfeedmdlss" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document" style="min-width: 900px">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title p-0"><i class="fa fa-calculator"></i>&nbsp; <?=$lng['Edit'].' '.$lng['Manual Feed']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				
				<table class="basicTable inputs table-responsive" border="0" style="width: 100%;">
					<thead>
						<tr>
							<th class="tac"></th>
							
							<? foreach($Pmanualfeed_cols as $key => $row){ ?>
								<? if($position = stripos($row,"hrs", 3) == true){ ?>
									<th class="tac"><?=$row?></th>
								<? }elseif($position = stripos($row,"hours", 5) == true){ ?>
									<th class="tac"><?=$row?></th>
								<? } ?>
							<? } ?>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th class="tal"><?=$lng['Total'].' '.$lng['Hours']?></th>
							<?
							$countTH = 0;
							foreach($Pmanualfeed_cols as $key => $row){ $countTH++;
								$class1 = str_replace(' ', '', str_replace('(', '', str_replace(')', '', str_replace('.', '', $row))));
								?>
								<? if(stripos($row,"hrs", 3) == true || stripos($row,"hours", 5) == true){ ?>
									<th class="tac">
										<? if($position = stripos($row,"hrs", 3) == true){ ?>
											<input type="text" class="sel hourFormat hrs_<?=$class1?>" id="hrs_<?=$class1.'_'.$countTH?>" readonly>
										<? }elseif($position = stripos($row,"hours", 5) == true){ ?>
											<input type="text" class="sel hourFormat hours_<?=$class1?>" id="hours_<?=$class1.'_'.$countTH?>" readonly>
										<? }elseif($position = stripos($row,"times", 5) == true){ ?>
											<input type="text" class="sel float72 times_<?=$class1?>" id="times_<?=$class1.'_'.$countTH?>" readonly>
										<? }elseif($position = stripos($row,"thb", 3) == true){?>
											<input type="text" class="sel float72 thb_<?=$class1?>" id="thb_<?=$class1.'_'.$countTH?>" readonly>
										<? } ?>
									</th>
								<? } ?>
							<? } ?>
						</tr>
						<tr>
							<th class="tal"><?=$lng['Total'].' '.$lng['THB']?></th>
							<? 
							$countTHB = 0;
							foreach($Pmanualfeed_cols as $key => $row){ $countTHB++;
								$class1 = str_replace(' ', '', str_replace('(', '', str_replace(')', '', str_replace('.', '', $row))));
								?>
								<? if(stripos($row,"hrs", 3) == true || stripos($row,"hours", 5) == true){ ?>
									<th class="tac">
										<? if($position = stripos($row,"hrs", 3) == true){ ?>
											<input type="text" name="" class="sel hourFormat" id="tthb_hrs_<?=$class1.'_'.$countTHB?>" readonly>
										<? }elseif($position = stripos($row,"hours", 5) == true){ ?>
											<input type="text" name="" class="sel hourFormat" id="tthb_hours_<?=$class1.'_'.$countTHB?>" readonly>
										<? }elseif($position = stripos($row,"times", 5) == true){ ?>
											<input type="text" name="" class="sel float72" id="tthb_times_<?=$class1.'_'.$countTHB?>" readonly>
										<? }elseif($position = stripos($row,"thb", 3) == true){?>
											<input type="text" name="" class="sel float72" id="tthb_thb_<?=$class1.'_'.$countTHB?>" readonly>
										<? } ?>
									</th>
								<? } ?>
							<? } ?>
						</tr>
						<tr>
							<th class="tal"><?=$lng['THB'].' '.$lng['Current'].' '.$lng['Salary']?></th>
							<? 
							$countCSal = 0;
							foreach($Pmanualfeed_cols as $key => $row){ $countCSal++;
								$class1 = str_replace(' ', '', str_replace('(', '', str_replace(')', '', str_replace('.', '', $row))));
								?>
								<? if(stripos($row,"hrs", 3) == true || stripos($row,"hours", 5) == true){ ?>
									<th class="tac">
										<? if($position = stripos($row,"hrs", 3) == true){ ?>
											<input type="text" name="" class="sel hourFormat" id="csal_hrs_<?=$class1.'_'.$countCSal?>" readonly>
										<? }elseif($position = stripos($row,"hours", 5) == true){ ?>
											<input type="text" name="" class="sel hourFormat" id="csal_hours_<?=$class1.'_'.$countCSal?>" readonly>
										<? }elseif($position = stripos($row,"times", 5) == true){ ?>
											<input type="text" name="" class="sel float72" id="csal_times_<?=$class1.'_'.$countCSal?>" readonly>
										<? }elseif($position = stripos($row,"thb", 3) == true){?>
											<input type="text" name="" class="sel float72" id="csal_thb_<?=$class1.'_'.$countCSal?>" readonly>
										<? } ?>
									</th>
								<? } ?>
							<? } ?>
						</tr>
						<tr>
							<th class="tal"><?=$lng['THB'].' '.$lng['Previous'].' '.$lng['Salary']?></th>
							
							<? foreach($Pmanualfeed_cols as $key => $row){ ?>
								<? if(stripos($row,"hrs", 3) == true || stripos($row,"hours", 5) == true){ ?>
									<th class="tac">
										<? if($position = stripos($row,"hrs", 3) == true){ ?>
											<input type="text" name="" class="sel hourFormat" readonly>
										<? }elseif($position = stripos($row,"hours", 5) == true){ ?>
											<input type="text" name="" class="sel hourFormat" readonly>
										<? }elseif($position = stripos($row,"times", 5) == true){ ?>
											<input type="text" name="" class="sel float72" readonly>
										<? }elseif($position = stripos($row,"thb", 3) == true){?>
											<input type="text" name="" class="sel float72" readonly>
										<? } ?>
									</th>
								<? } ?>
							<? } ?>
						</tr>
						<tr>
							<th class="tal"><?=$lng['THB/HR'].' '.$lng['Current'].' '.$lng['Salary']?></th>
							<? 
							$countPHCS = 0;
							foreach($Pmanualfeed_cols as $key => $row){ $countPHCS++;
								$class1 = str_replace(' ', '', str_replace('(', '', str_replace(')', '', str_replace('.', '', $row))));
								?>
								<? if(stripos($row,"hrs", 3) == true || stripos($row,"hours", 5) == true){ ?>
									<th class="tac">
										<? if($position = stripos($row,"hrs", 3) == true){ ?>
											<input type="text" name="" class="sel hourFormat" id="phcs_hrs_<?=$class1.'_'.$countPHCS?>" readonly>
										<? }elseif($position = stripos($row,"hours", 5) == true){ ?>
											<input type="text" name="" class="sel hourFormat" id="phcs_hours_<?=$class1.'_'.$countPHCS?>" readonly>
										<? }elseif($position = stripos($row,"times", 5) == true){ ?>
											<input type="text" name="" class="sel float72" id="phcs_times_<?=$class1.'_'.$countPHCS?>" readonly>
										<? }elseif($position = stripos($row,"thb", 3) == true){?>
											<input type="text" name="" class="sel float72" id="phcs_thb_<?=$class1.'_'.$countPHCS?>" readonly>
										<? } ?>
									</th>
								<? } ?>
							<? } ?>
						</tr>
						<tr>
							<th class="tal"><?=$lng['THB/HR'].' '.$lng['Previous'].' '.$lng['Salary']?></th>
							<? 
							foreach($Pmanualfeed_cols as $key => $row){ ?>
								<? if(stripos($row,"hrs", 3) == true || stripos($row,"hours", 5) == true){ ?>
									<th class="tac">
										<? if($position = stripos($row,"hrs", 3) == true){ ?>
											<input type="text" name="" class="sel hourFormat" readonly>
										<? }elseif($position = stripos($row,"hours", 5) == true){ ?>
											<input type="text" name="" class="sel hourFormat" readonly>
										<? }elseif($position = stripos($row,"times", 5) == true){ ?>
											<input type="text" name="" class="sel float72" readonly>
										<? }elseif($position = stripos($row,"thb", 3) == true){?>
											<input type="text" name="" class="sel float72" readonly>
										<? } ?>
									</th>
								<? } ?>
							<? } ?>
						</tr>
						<tr>
							<th class="tal"><?=$lng['Hours'].' '.$lng['Current'].' '.$lng['Salary']?></th>
							<? 
							$countHCS = 0;
							foreach($Pmanualfeed_cols as $key => $row){ $countHCS++;
								$class1 = str_replace(' ', '', str_replace('(', '', str_replace(')', '', str_replace('.', '', $row))));

								?>
								<? if(stripos($row,"hrs", 3) == true || stripos($row,"hours", 5) == true){ ?>
									<th class="tac">
										<? if($position = stripos($row,"hrs", 3) == true){ ?>
											<input type="text" name="" class="sel hourFormat" id="hcs_hrs_<?=$class1.'_'.$countHCS?>" readonly>
										<? }elseif($position = stripos($row,"hours", 5) == true){ ?>
											<input type="text" name="" class="sel hourFormat" id="hcs_hrs_<?=$class1.'_'.$countHCS?>" readonly>
										<? }elseif($position = stripos($row,"times", 5) == true){ ?>
											<input type="text" name="" class="sel float72" id="hcs_hrs_<?=$class1.'_'.$countHCS?>" readonly>
										<? }elseif($position = stripos($row,"thb", 3) == true){?>
											<input type="text" name="" class="sel float72" id="hcs_hrs_<?=$class1.'_'.$countHCS?>" readonly>
										<? } ?>
									</th>
								<? } ?>
							<? } ?>
						</tr>
						<tr style="background-color: #ffffbb !important;">
							<th class="tal"><?=$lng['Hours'].' '.$lng['Previous'].' '.$lng['Salary']?></th>
							<? 
							$countHPS = 0;
							foreach($Pmanualfeed_cols as $key => $row){ $countHPS++;
								$class1 = str_replace(' ', '', str_replace('(', '', str_replace(')', '', str_replace('.', '', $row))));
								?>
								<? if(stripos($row,"hrs", 3) == true || stripos($row,"hours", 5) == true){ ?>
									<th class="tac">
										<? if($position = stripos($row,"hrs", 3) == true){ ?>
											<input type="text" name="" class="sel hourFormat clearall" id="hps_hrs_<?=$class1.'_'.$countHPS?>" onchange="calcSalaryAgain(this,<?=$countHPS?>,'<?=$class1?>')">
										<? }elseif($position = stripos($row,"hours", 5) == true){ ?>
											<input type="text" name="" class="sel hourFormat" id="hps_hours_<?=$class1.'_'.$countHPS?>" onchange="calcSalaryAgain(this,<?=$countHPS?>,'<?=$class1?>')">
										<? }elseif($position = stripos($row,"times", 5) == true){ ?>
											<input type="text" name="" class="sel float72" id="hps_times_<?=$class1.'_'.$countHPS?>">
										<? }elseif($position = stripos($row,"thb", 3) == true){?>
											<input type="text" name="" class="sel float72" id="hps_thb_<?=$class1.'_'.$countHPS?>">
										<? } ?>
									</th>
								<? } ?>
							<? } ?>
						</tr>
					</tbody>
				</table>

			</div>
			<div class="modal-footer">
	        	<button type="button" class="btn btn-primary"><?=$lng['Save']?></button>
	        	<button type="button" class="btn btn-primary" data-dismiss="modal"><?=$lng['Cancel']?></button>
	      	</div>
	    </div>
	</div>
</div>

 <form id="import" name="import" enctype="multipart/form-data" style="visibility:hidden; height:0; margin:0; padding:0">
	<input style="visibility:hidden" id="import_attendance" type="file" name="file" />
</form>
			
<!------ model manual feed ----------->

<script type="text/javascript">


	$(document).ready(function(){
		$('.SelallManualFeedData').click(function(){
			$('.mfchkboxData').prop('checked',false);
			$('.mfchkboxData').removeClass('selectedChk');

			$('.mfchkboxData').prop('checked',true);
			$('.mfchkboxData').addClass('selectedChk');

			$('.unSelallManualFeedData').css('display','block');
			$('.SelallManualFeedData').css('display','none');
		});

		$('.unSelallManualFeedData').click(function(){
			$('.mfchkboxData').prop('checked',false);
			$('.mfchkboxData').removeClass('selectedChk');

			$('.unSelallManualFeedData').css('display','none');
			$('.SelallManualFeedData').css('display','block');
		});
	});

	$(document).ready(function() {

		var cid = <?=json_encode($cid)?>;
		var year = <?=json_encode($_SESSION['rego']['cur_year'])?>;
		var month = <?=json_encode($_SESSION['rego']['curr_month'])?>;

		function calcAgainmanualFeed(){
			var frm = $('form#manualfeedData');
			var datas = frm.serialize();
			$.ajax({
				type : 'post',
				url : 'tabs/ajax/save_manual_feed.php',
				data : datas,
				success : function(result){
					if(result == 'success'){
						$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
							duration: 1,
							callback: function(v){
								window.location.reload();
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

		$("#saveManualfeedData").click(function() {
			var frm = $('form#manualfeedData');
			var datas = frm.serialize();
			$.ajax({
				type : 'post',
				url : 'tabs/ajax/save_manual_feed.php',
				data : datas,
				success : function(result){
					
					setTimeout(function() { 
				        calcAgainmanualFeed();
				    }, 1000);		
				} 
			})
		})

		$("#export_manual_excel").click(function() {
			//first calculate manual feed then export
			var frm = $('form#manualfeedData');
			var datas = frm.serialize();
			$.ajax({
				type : 'post',
				url : 'tabs/ajax/save_manual_feed.php',
				data : datas,
				success : function(result){
					setTimeout(function(){
					 	window.location.reload();
					}, 2000);
					window.location.href='<?=ROOT?>payroll/export_attendance_excel.php';
					
				}
			});
		})

		$(".manualfeedmdl").click(function() {

			var rowid = $(this).attr('id');
			var allowarr = <?=json_encode($dropdownArrayNew)?>;
			$('#manualfeedmdlss .clearall').val('');
			
			var countIteam = 0;
			$.each(allowarr, function(index, value){

				countIteam++;

				var hRSstr1 = value[0];
				var hRSstr2 = "hrs";
				if(hRSstr1.indexOf(hRSstr2) != -1){
					var hrsvals = $(".hrs_"+value[1]+"_"+rowid).val();
				}

				var hoRSstr1 = value[0];
				var hoRSstr2 = "hours";
				if(hoRSstr1.indexOf(hoRSstr2) != -1){
					var hoursvals = $(".hours_"+value[1]+"_"+rowid).val();
				}

				/*var timesstr1 = value[0];
				var timesstr2 = "times";
				if(timesstr1.indexOf(timesstr2) != -1){
					var timesvals = $(".times_"+value[1]+"_"+rowid).val();
				}

				var thbstr1 = value[0];
				var thbstr2 = "thb";
				if(thbstr1.indexOf(thbstr2) != -1){
					var thbvals = $(".thb_"+value[1]+"_"+rowid).val();
				}*/

				var str = value[0];
				var res = str.replaceAll(" ", "");  
				var res01 = res.replaceAll("(+/-)", "");  
				var res0 = res01.replaceAll(".", "");  
				var res1 = res0.replaceAll("(", "");  
				var res2 = res1.replaceAll(")", "");  

				// $("#manualfeedmdlss .hrs_"+res2).val(hrsvals);
				// $("#manualfeedmdlss .times_"+res2).val(timesvals);
				// $("#manualfeedmdlss .thb_"+res2).val(thbvals);
				//alert(hrsvals);

				//var aa = "#hours_"+res2+"_"+countIteam+"";
				//alert(aa);

				$("#manualfeedmdlss .hrs_"+res2).val(hrsvals);
				$("#manualfeedmdlss .hours_"+res2).val(hoursvals);

				//$("#manualfeedmdlss #hrs_"+res2+"_"+countIteam).val(hrsvals);
				//$("#manualfeedmdlss #hours_"+res2+"_"+countIteam).val(hoursvals);

				//$("#manualfeedmdlss #times_"+res2+"_"+countIteam).val(timesvals);
				//$("#manualfeedmdlss #thb_"+res2+"_"+countIteam).val(thbvals);

				//----------for row 2 Total THB--------//
				var hourRate = 100;
				var myinputHrs = 0;
				if(hrsvals !='' && hrsvals != undefined){
					var inputHrs = hrsvals.split(":");
					myinputHrs = inputHrs[0];
				}
				var hoursTot = (myinputHrs * hourRate);
				$("#manualfeedmdlss #tthb_hrs_"+res2+"_"+countIteam).val(hoursTot);
				//$("#manualfeedmdlss #tthb_times_"+res2+"_"+countIteam).val(timesvals);
				//$("#manualfeedmdlss #tthb_thb_"+res2+"_"+countIteam).val(thbvals);


				//----------for row 3 THB Current Salary--------//
				$("#manualfeedmdlss #csal_hrs_"+res2+"_"+countIteam).val(hoursTot);
				//$("#manualfeedmdlss #csal_times_"+res2+"_"+countIteam).val(timesvals);
				//$("#manualfeedmdlss #csal_thb_"+res2+"_"+countIteam).val(thbvals);


				//----------for row 5 THB/HR Current Salary--------//
				$("#manualfeedmdlss #phcs_hrs_"+res2+"_"+countIteam).val(hourRate);
				//$("#manualfeedmdlss #phcs_times_"+res2+"_"+countIteam).val(timesvals);
				//$("#manualfeedmdlss #phcs_thb_"+res2+"_"+countIteam).val(thbvals);

				//----------for row 6 Hours Current Salary--------//
				$("#manualfeedmdlss #hcs_hrs_"+res2+"_"+countIteam).val(hrsvals);
				//$("#manualfeedmdlss #hcs_times_"+res2+"_"+countIteam).val(timesvals);
				//$("#manualfeedmdlss #hcs_thb_"+res2+"_"+countIteam).val(thbvals);			

			});

			$("#manualfeedmdlss").modal('toggle');
		});


		$(document).on("change", "#import_attendance", function(e){
			e.preventDefault();
			var id = cid;
			//alert(cid);
			var ff = $(this).val().toLowerCase();
			ff = ff.replace(/.*[\/\\]/, '');
			var ext =  ff.split('.').pop();
			f = ff.substr(0, ff.lastIndexOf('.'));
			var r = f.split('_');
			//alert(r)
			if(!(ext == 'xls' || ext == 'xlsx')){
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Please use Excel files only']?> (.xls, .xlsx)',
					duration: 3,
				})
				return false;
			}
			if(r.length != 4){
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Wrong file format ! Please use']?> [ '+id+'_manualfeed_'+year+'_'+month+'.xls ]',
					duration: 4,
				})
				return false;
			}else{
				var s1 = r[0];
				var s2 = r[1]; // Filename
				var s3 = r[2]; // Year
				var s4 = r[3].substring(0,2); // Month
				//alert(id+'-'+s1+'-'+s2+'-'+s3+'-'+s4);
				if(s1 != id){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['File ID does not match selected client']?> ('+s1+') ! <?=$lng['Please use']?> [ '+id+'_employees_'+year+'_'+month+'.xls ]',
						duration: 3,
					})
					return false;
				}else if(s2 !== 'manualfeed'){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Wrong file name']?> ('+s2+') ! <?=$lng['Please use']?> [ '+id+'_manualfeed_'+year+'_'+month+'.xls ]',
						duration: 4,
					})
					return false;
				}else if(s3 !== year){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Wrong year']?> ('+s3+') ! <?=$lng['Please use']?> [ '+id+'_manualfeed_'+year+'_'+month+'.xls ]',
						duration: 4,
					})
					return false;
				}else if(s4 !== month){ // (s3.indexOf(month) == -1)
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Wrong month']?> ('+s4+') ! <?=$lng['Please use']?> [ '+id+'_manualfeed_'+year+'_'+month+'.xls ]',
						duration: 4,
					})
					return false;
				}
			}
			$("form#import").submit();
		});

		$(document).on("submit", "form#import", function(e){
			e.preventDefault();
			$("#calculate").removeClass('flash');
			$("body").overhang({
				type: "warn",
				message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['One moment please, importing data']?>&nbsp;&nbsp;<i class="fa fa-refresh fa-spin"></i>',
				closeConfirm: "true",
				//duration: 10,
			})
			$('#impemp i').removeClass('fa-download').addClass('fa-refresh fa-spin');
			var data = new FormData($(this)[0]);

			setTimeout(function(){
			$.ajax({
				url: "ajax/upload_payroll_data.php",
				type: 'POST',
				data: data,
				//async: false,
				cache: false,
				contentType: false,
				processData: false,
				success: function(result){
					
					$("#calculate").removeClass('flash');
					$("#import_attendance").val('');
					//$('#dump').html(result); return false;
					//alert('jhk')
					setTimeout(function(){
						$(".overhang").slideUp(200); 
						$('#impemp i').removeClass('fa-refresh fa-spin').addClass('fa-download');
					}, 800);
					setTimeout(function(){
						if($.trim(result) == 'success'){
							
							//after import calculate manual feed again
							/*var frm = $('form#manualfeedData');
							var datas = frm.serialize();
							$.ajax({
								type : 'post',
								url : 'tabs/ajax/save_manual_feed.php',
								data : datas,
								success : function(result){*/
									$("body").overhang({
										type: "success",
										message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data imported successfully. Calculating payroll, please wait']?> . . .',
										duration: 2,
										callback: function(v){
											window.location.reload();
										}
									})
								/*}
							})*/
							
							$("#import_attendance").val('');
							$("#saveManualfeedData a").addClass('flash');
							$("#sAlert").fadeIn(200);
							
						}else{
							$("body").overhang({
								type: "error",
								message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;'+result,
								duration: 4,
							})
						}	
					}, 1000);	
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});}, 300);
		});


		$('#tab_ManualFeed input').on('keyup', function (e) {
			$("#saveManualfeedData a").addClass('flash');
			$("#sAlert").fadeIn(200);
		});

	});


	function calcSalaryAgain(that, rowID, idd){

		// alert(that.value);
		// alert(rowID);
		// alert(idd);

		if(that.value != '' && that.value != undefined){

			var rowid = rowID;
			var res2 = idd;
			
			//var countIteam = 0;
			//$.each(allowarr, function(index, value){

				//countIteam++;

				var hRSstr1 = idd;
				var hRSstr2 = "hrs";
				if(hRSstr1.indexOf(hRSstr2) != -1){
					var tch = $("#hrs_"+idd+"_"+rowid).val();
					var tch1 =  tch.split(":");

					var tph = that.value;
					var tph1 =  tph.split(":");

					var tothrs = (tch1[0] - tph1[0]);
					var hrsvals = tothrs+':00';
					//$(".hrs_"+value[1]+"_"+rowid).val(hrsvals);
				}

				var timesstr1 = idd;
				var timesstr2 = "times";
				if(timesstr1.indexOf(timesstr2) != -1){
					var timesvals = $("#times_"+idd+"_"+rowid).val();
				}

				var thbstr1 = idd;
				var thbstr2 = "thb";
				if(thbstr1.indexOf(thbstr2) != -1){
					var thbvals = $("#thb_"+idd+"_"+rowid).val();
				}

				var str = idd;
				var res = str.replaceAll(" ", "");  
				var res01 = res.replaceAll("(+/-)", "");  
				var res0 = res01.replaceAll(".", "");  
				var res1 = res0.replaceAll("(", "");  
				var res2 = res1.replaceAll(")", "");  

				/*$("#manualfeedmdlss #hrs_"+res2+"_"+rowid).val(hrsvals);
				$("#manualfeedmdlss #times_"+res2+"_"+rowid).val(timesvals);
				$("#manualfeedmdlss #thb_"+res2+"_"+rowid).val(thbvals);*/

				//----------for row 2 Total THB--------//
				var hourRate = 100;
				var myinputHrs = 0;
				if(hrsvals !='' && hrsvals != undefined){
					var inputHrs = hrsvals.split(":");
					myinputHrs = inputHrs[0];
				}
				var hoursTot = (myinputHrs * hourRate);
				$("#manualfeedmdlss #tthb_hrs_"+res2+"_"+rowid).val(hoursTot);
				$("#manualfeedmdlss #tthb_times_"+res2+"_"+rowid).val(timesvals);
				$("#manualfeedmdlss #tthb_thb_"+res2+"_"+rowid).val(thbvals);


				//----------for row 3 THB Current Salary--------//
				$("#manualfeedmdlss #csal_hrs_"+res2+"_"+rowid).val(hoursTot);
				$("#manualfeedmdlss #csal_times_"+res2+"_"+rowid).val(timesvals);
				$("#manualfeedmdlss #csal_thb_"+res2+"_"+rowid).val(thbvals);


				//----------for row 5 THB/HR Current Salary--------//
				$("#manualfeedmdlss #phcs_hrs_"+res2+"_"+rowid).val(hourRate);
				//$("#manualfeedmdlss #phcs_times_"+res2+"_"+countIteam).val(timesvals);
				//$("#manualfeedmdlss #phcs_thb_"+res2+"_"+countIteam).val(thbvals);

				//----------for row 6 Hours Current Salary--------//
				$("#manualfeedmdlss #hcs_hrs_"+res2+"_"+rowid).val(hrsvals);
				//$("#manualfeedmdlss #hcs_times_"+res2+"_"+countIteam).val(timesvals);
				//$("#manualfeedmdlss #hcs_thb_"+res2+"_"+countIteam).val(thbvals);			

			//});
		}else{
			alert('dffdf');
		}
	}

	

</script>