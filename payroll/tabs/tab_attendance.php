<div style="height:100%; border:0px solid red; position:relative;">
	<div>
		<div class="smallNav">
			<ul>
				<li>
					<div class="searchFilter" style="margin:0">
						<input placeholder="Filter" id="searchFilterta" class="sFilter" type="text">
						<button id="clearSearchboxta" type="button" class="clearFilter btn btn-default btn-sm"><i class="fa fa-times"></i></button>
					</div>
				</li>	

			</ul>
		</div>
	</div>
	
	<table id="attendance_table" class="dataTable hoverable selectable">
	<!-- <table id="attendance_table1111" class="basicTable"> -->
		<thead>
			<tr>
				<th colspan="2" class="tac"><?=$lng['Employee']?></th>
				<th colspan="<?=count($Pmanualfeed_cols) +2;?>" class="tac"><?=$lng['Attendance & Allowance Data']?></th>
				<th colspan="<?=count($Pmanualfeed_cols) +1;?>" class="tac"><?=$lng['Total allowance in THB']?></th>
			</tr>
			<tr>
				<th class="tal"><?=$lng['Emp. ID']?></th>
				<th class="tal" style="width: 130px;"><?=$lng['Employee name']?></th>
				
				<th class="tac"><?=$lng['Paid'].'<br>'.$lng['days']?></th>
				<th class="tac"><?=$lng['Paid'].'<br>'.$lng['hours']?></th>
				<? foreach($Pmanualfeed_cols as $key => $rows){ ?>
					<th class="tal"><?=$rows?></th>
				<? } ?>
				<th class="tac" ><?=$lng['Basic salary']?></th>
				<? foreach($Pmanualfeed_cols as $key => $val){ ?>
					<th class="tac"><?=$attendData[$val][0]?></th>
				<? } ?>
			</tr>
		</thead>
		<tbody>
			<? 

			$contract_type_check = array();
			//$checkEmpsalary_check = array();
			$paid_hours = array();
			foreach($getSelmonPayrollDatass as $key => $row){ 
					$manual_feed_data = unserialize($row['manual_feed_data']);
					$manual_feed_total = unserialize($row['manual_feed_total']);
					$paid_hours[] = $row['paid_hours'];

					//$checkEmpsalary = checkEmpsalaryForCalc($row['emp_id'],$_SESSION['rego']['curr_month']);
					//$checkEmpsalary_check[] = $checkEmpsalary;

					if($row['contract_type'] == 'month'){
						$empSalary = '';
						$empPaid_day = '';
					}elseif($row['contract_type'] == 'day'){
						$empSalary = number_format($row['mf_salary'],2);
						$empPaid_day = $row['paid_days'];
						$contract_type_check[] = 1;
					}else{
						$clmroy=''; $adcls='';
						$empSalary = '';
						$empPaid_day = '';
					}
				?>
				<tr data-eid="<?=$row['emp_id']?>">
					<td class="pad010 pl-2 font-weight-bold"><?=$row['emp_id']?></td>
					<td class="pad010 pl-2 font-weight-bold"><?=$row['emp_name_'.$lang]?></td>
				
					<td class="tar"><?=$empPaid_day?></td>
					<td class="tar"><?=$row['mf_paid_hour']?></td>

					<?  foreach($dropdownArrayNew as $key2 => $rows){ 
							if(in_array($rows[0], $Pmanualfeed_cols)){

								if($position = stripos($rows[0],"hrs", 3) == true){
									
									echo '<td class="tar">'.$manual_feed_data['hrs'][$rows[1]].'</td>';

								}elseif($position = stripos($rows[0],"hours", 5) == true){
									
									echo '<td class="tar">'.$manual_feed_data['hours'][$rows[1]].'</td>';

								}elseif($position = stripos($rows[0],"times", 5) == true){
									
									echo '<td class="tar">'.$manual_feed_data['times'][$rows[1]].'</td>';

								}elseif($position = stripos($rows[0],"thb", 3) == true){
									
									echo '<td class="tar">'.$manual_feed_data['thb'][$rows[1]].'</td>';

								}else{

									echo '<td class="tar">'.$manual_feed_data['other'][$rows[1]].'</td>';
								}
							}
						?>
					<? } ?>

					<td class="tar"><?=$empSalary?></td>
					<? foreach($Pmanualfeed_cols as $key1 => $val){ 
						$key1 = $attendData[$val][1]; ?>
						<td class="tar"><?=number_format($manual_feed_total[$key1],2);?></td>
					<? }  ?>
					
				</tr>
			<? } ?>
		</tbody>
	</table>

	<?php
		/*if(in_array(2, $checkEmpsalary_check)){
			$hide2='{"targets": [2], "visible": true, "searchable": true}';
		}else{
			$hide2='{"targets": [2], "visible": false, "searchable": false}';
		}*/

		$array_slice=false;
		if(in_array(1, $contract_type_check)){
			$eColsad11='{"targets": [2,3], "visible": true, "searchable": true},';
			$array_slice=true;
		}else{
			$darr = count($Pmanualfeed_cols) + 4;
			$eColsad11='{"targets": [2,3,'.$darr.'], "visible": false, "searchable": false},';
		}


		/*if($array_slice){
			array_shift($manualFeedShowhide);
			array_shift($manualFeedShowhide);
		}*/

		// echo '<pre>';
		// print_r($manualFeedShowhide);
		// echo '</pre>';

		/*if(count($manualFeedShowhide) > 0){
			foreach($manualFeedShowhide as $v){$eColsMFd .= $v.',';}
			$eColsMFd = '['.substr($eColsMFd,0,-1).']';
			$eColsMFd = '{"targets": '.$eColsMFd.', "visible": false, "searchable": false},';
		}else{
			$eColsMFd = '';
		}*/

	?>

	<div class="row">
		<div class="col-md-2" style="margin: -30px 0px 0px 0px;margin-left: auto;margin-right: auto;">
			<select id="pageLengthta" class="button btn-fl">
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