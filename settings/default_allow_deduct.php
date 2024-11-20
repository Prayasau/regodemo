<?	

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
	// print_r($_SESSION['filter_group_allowance']);
	// echo '</pre>';


	if(!empty($_SESSION['rego']['filter_group_allowance']))
	{
		$explodecond3 = explode('|', $_SESSION['rego']['filter_group_allowance']);
		$result = "'" . implode ( "', '", $explodecond3 ) . "'";
		$condition3 = " groups in (".$result.")"; 
		$andValue2 = ' AND';

	}
	else
	{
		$condition3 = '';
	}




	$data = array();
	if($res = $dbc->query("SELECT * FROM ".$cid."_allow_deduct WHERE ".$condition."  ".$andValue." ".$condition2." ".$andValue2." ".$condition3." ORDER BY id ASC")){
		while($row = $res->fetch_assoc()){

	
			if($_GET['cri'] == '2')
			{
				// remove locked checkbox  

				//if(in_array($row['id'], array(27,28,29,30,31,32,33,34,35,36,47,48,49,50,51,56,57,58,59,60))){
				if(in_array($row['id'], array(27,28,29,30,31,32,33,47,48,49,50,51,56,57,58,59,60))){
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

				//if(in_array($row['id'], array(27,28,29,30,31,32,33,34,35,36,47,48,49,50,51,56,57,58,59,60))){
				if(in_array($row['id'], array(27,28,29,30,31,32,33,47,48,49,50,51,56,57,58,59,60))){
					$data[$row['id']] = $row;
				}
			}
			else
			{
				$data[$row['id']] = $row;
			}


		}
	}

	// echo '<pre>';
	// print_r($data_group);
	// echo '</pre>';

	// die()

?>
<style>
	table.dataTable tbody td {
		padding:0 !important;
	}
	table.dataTable thead th.w1 {
		width:40px;
		min-width:40px
	}

	.font-weight-bold {
	    font-weight: 600!important;
	}

	.removeDownArrow {
	    -webkit-appearance: none;
	    -moz-appearance: none;
	    text-indent: 0.01px;
	    text-overflow: '';
	}

/*	input[type=radio] {
	    -moz-appearance: none;
	    -webkit-appearance: none;
	    -o-appearance: none;
	    outline: none;
	    content: none;
	    border-radius: 2px;
	}

	input[type=radio]:before {
	    content: url("../assets/images/tickblack.png");
	    padding: 2px;
    	font-size: 9px;
	    color: transparent !important;
	    background: #fff;
	    width: 20px;
	    height: 20px;
	    border: 1px solid #d5d3d3;
	    border-radius: 2px;
	}

	input[type=radio]:checked:before {
	    color: #fff !important;
	    content: url("../assets/images/tickblack.png");
	    background: #007bff !important;
	    border: 1px solid #007bff;
	    padding: 2px;
    	font-size: 9px;
    	border-radius: 2px;
	}*/

</style>
	
	<h2><i class="fa fa-cog fa-lg"></i>&nbsp;&nbsp;<?=$lng['Allowances & Deductions']?> <span style="float:right; display:none; font-style:italic; color:#b00" id="sAlert"><?=$lng['Data is not updated to last changes made']?></span></h2>
	<div class="main">

		
		<input type="hidden" name="hiddengroupfilter" id="hiddengroupfilter" value="<?php echo $_SESSION['rego']['filter_group_allowance']; ?>">
		<div id="showTable" style="display:none; margin-bottom:50px">
			<table id= "allowancetable" border="0" style="width:100%; margin-bottom:8px">
				<tr>
					<td style="vertical-align:top;">
						<select id="lockFilter">
							<option selected value="select"><?=$lng['Select']?></option>
							<option value="0" <?if($_GET['cri'] == 0){ echo 'selected'; }?>><?=$lng['Show all']?></option>
							<option value="1" <?if($_GET['cri'] == 1){ echo 'selected'; }?>><?=$lng['Locked']?></option>
							<!-- <option selected value="Edit"><?=$lng['Editable']?></option> -->
							<option value="2" <?if($_GET['cri'] == 2){ echo 'selected'; }?>><?=$lng['Selected']?></option>
						</select>
					</td>
					<td style="vertical-align:top; padding-left:10px">
						<select id="classificationFilter" >
						<!-- <select id="classificationFilter" onchange="classFilter(this.value);"> -->
							<option value="select" ><?=$lng['Select']?></option>
							<option value="&cls=2" <?if($_GET['cls'] == 2){ echo 'selected'; }?> ><?=$lng['All classifications']?></option>
							<option value="&cls=0" <?if($_GET['cls'] == 0){ echo 'selected'; }?> ><?=$lng['Allowances']?></option>
							<option value="&cls=1" <?if($_GET['cls'] == 1){ echo 'selected'; }?> ><?=$lng['Deductions']?></option>
						</select>
					</td>
					<td style="vertical-align:top; padding-left:10px; width:100%">
						<select multiple="multiple" id="groupFilter">
							<? 
								$filtersessionarray = 	unserialize($_SESSION['rego']['filter_group_allowance_array']); 
								foreach($data_group as $k=>$v){  
									if($filtersessionarray[0] == '')
									{ ?>
										<option  selected value="<?=$k?>"><?=$v?></option>

									<?php } else {?>
										<option <?php if(in_array($k, $filtersessionarray)) { echo "selected"; } ?> value="<?=$k?>"><?=$v?></option>
									<? }} ?>
						</select>
					</td>
					<td style="vertical-align:top; padding-left:10px">
						<button class="btn btn-primary" onclick="window.history.go(-1); return false;" type="button"><?=$lng['Go back']?></button>
					</td>
					
				</tr>
			</table>
			
			
			<table id="allowDeductTable" class="dataTable inputs nowrap hoverable selectable" border="0">
				<thead>
					 <tr>
						<th colspan="9"></th>
						<th class="tac" colspan="8"><?=$lng['Add to total for calculations']?></th>
						<th></th>
						<th class="tac" colspan="5"><?=$lng['Calculation base']?></th>
						<th></th>
					</tr> 
					<tr>
						<th class="tac"><?=$lng['Apply']?></th>
						<th data-visible="false"></th>
						<th class="tac" style="width:1%">
							<i class="fa fa-eye fa-lg"></i>
						</th>
						<th class="tac" style="width:1%">
							<i class="fa fa-edit fa-lg"></i>
						</th>
						<th><?=$lng['Thai description']?></th>
						<th><?=$lng['English description']?></th>
						<th><?=$lng['Classification']?></th>
						<th data-visible="false"></th>
						<th style="width: 100px;"><?=$lng['Group']?></th>
						<th data-visible="false"></th>
						<th class="tac w1"><?=$lng['Earnings']?></th>
						<th class="tac w1"><?=$lng['Deductions']?></th>
						<th class="tac w1"><?=$lng['Hour rate/Daily rate']?></th>
						<th class="tac w1"><?=$lng['PND1']?></th>
						<th class="tac w1" style="line-height:110%"><?=$lng['Tax incom']?></th>
						<th class="tac w1"><?=$lng['SSO']?></th>
						<th class="tac w1"><?=$lng['PVF']?></th>
						<th class="tac w1"><?=$lng['PSF']?></th>
						<th class="tac w1"><?=$lng['Tax Base']?></th>
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
							//if(in_array($key, array(27,28,29,30,31,32,33,34,35,36,47,48,49,50,51,56,57,58,59,60))){
							if(in_array($key, array(27,28,29,30,31,32,33,47,48,49,50,51,56,57,58,59,60))){
								$readonly = 'readonly'; $lock = 1;
							}
					?>
					<tr>
						<td class="tac vam" style="vertical-align:middle; width:1px" >
							<input type="hidden" value="<?=$key?>" />
							<? if($lock){ ?>
							<input class="locked" type="hidden" value="1" />
							<label><input disabled checked type="checkbox" value="1" class="checkbox notxt checkbox-custom-black-2" /></label>
							<? }else{ ?>
							<input type="hidden" value="0" />
							<label><input <? if($val['apply'] == 1){echo 'checked';} ?>  type="checkbox" value="1" class="checkbox-blue-custom-white checkbox notxt checkbox-custom-blue-2" /></label>
							<? } ?>
						</td>
						<td><? if($lock){ echo 'Locked';}else{echo 'Edit';} if($val['apply']){echo ' Select';}?></td>
						<td style="padding: 0px 10px !important;">
							<a class="editItem" data-id="<?=$key?>"><i class="fa fa-eye fa-lg"></i></a>
						</td>
						<td style="padding: 0px 10px !important;">
							<?php if($lock){ ?>
							<a style= "pointer-events: none;" class="editItemPopups disabledropdown" data-id="<?=$key?>"><i class="fa fa-edit fa-lg"></i></a>
								
							<?php } else { ?>
							<a  class="editItemPopups " data-id="<?=$key?>"><i class="fa fa-edit fa-lg"></i></a>

							<?php } ?>

						</td>
						<td><input readonly="readonly" <?=$readonly?> placeholder="__"  type="text" value="<?=$val['th']?>" /></td>
						<td><input readonly="readonly" <?=$readonly?> placeholder="__"  type="text" value="<?=$val['en']?>" /></td>
						<td>
							<select  style="min-width:auto; width:100%; background:transparent" class="removeDownArrow disabledropdown">
								<option <? if(!$val['classification']){echo "selected ";} ?> value="0"><?=$lng['Allowances']?></option>
								<option <? if($val['classification']){echo "selected ";} ?> value="1"><?=$lng['Deductions']?></option>
							</select>
						</td>
						<td><? if($val['classification']){ echo 'deduct';}else{echo 'Allowances';}?></td>
						<td>
							<? if(!$val['classification']){$data_group = $income_group;}else{$data_group = $deduct_group;}?>
							<select style="min-width: 190px !important; background:transparent" class="removeDownArrow disabledropdown">
								<? foreach($data_group as $k=>$v){ ?>
								<option <? if($k == $val['groups']){echo "selected ";} ?> value="<?=$k?>"><?=$v?></option>
								<? } ?>
							</select>
						</td>
						<td><?=$val['groups']?></td>
						
								<td class="tac vam">
							<input name="data[<?=$key?>][earnings]" type="hidden" value="0" />
							<label><input  <? if($val['earnings']){echo 'checked';} ?> name="data[<?=$key?>][earnings]" type="checkbox" value="1" class="stopCheckbox checkbox notxt selEarnings checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
						</td>
						
						<td class="tac vam">
							<input name="data[<?=$key?>][deductions]" type="hidden" value="0" />
							<? if(in_array($key, array(27,28))){ ?>
							<label><input type="checkbox" class="checkbox notxt stopCheckbox checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
							<? }else{ ?>
							<label><input <? if($val['deductions']){echo 'checked';} ?> name="data[<?=$key?>][deductions]" type="checkbox" value="1" class="checkbox notxt selDeductions stopCheckbox checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
							<? } ?>
						</td>
						
						<td class="tac vam">
							<input name="data[<?=$key?>][hour_daily_rate]" type="hidden" value="0" />
							<label><input <? if($val['hour_daily_rate']){echo 'checked';} ?> name="data[<?=$key?>][hour_daily_rate]" type="checkbox" value="1" class="checkbox notxt stopCheckbox checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
						</td>

						<td class="tac vam">
							<input name="data[<?=$key?>][pnd1]" type="hidden" value="0" />
							<label><input <? if($val['pnd1']){echo 'checked';} ?> name="data[<?=$key?>][pnd1]" type="checkbox" value="1" class="checkbox notxt stopCheckbox checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
						</td>


						<td class="tac vam">
							<input name="data[<?=$key?>][tax_income]" type="hidden" value="0" />
							<? if(in_array($key, array(27,28))){ ?>
							<label><input type="checkbox" class="stopCheckbox checkbox notxt checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
							<? }else{ ?>
							<label><input <? if($val['tax_income']){echo 'checked';} ?> name="data[<?=$key?>][tax_income]" type="checkbox" value="1" class="stopCheckbox checkbox notxt checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
							<? } ?>
						</td>
						<td class="tac vam">
							<input name="data[<?=$key?>][sso]" type="hidden" value="0" />
							<? if(in_array($key, array(27,28))){ ?>
							<label><input type="checkbox" class="stopCheckbox checkbox notxt checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
							<? }else{ ?>
							<label><input <? if($val['sso']){echo 'checked';} ?> name="data[<?=$key?>][sso]" type="checkbox" value="1" class="checkbox notxt stopCheckbox checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
							<? } ?>
						</td>
						<td class="tac vam">
							<input name="data[<?=$key?>][pvf]" type="hidden" value="0" />
							<? if(in_array($key, array(27,28))){ ?>
							<label><input type="checkbox" class="checkbox notxt stopCheckbox checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
							<? }else{ ?>
							<label><input  <? if($val['pvf']){echo 'checked';} ?> name="data[<?=$key?>][pvf]" type="checkbox" value="1" class="checkbox notxt stopCheckbox checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
							<? } ?>
						</td>
						<td class="tac vam">
							<input name="data[<?=$key?>][psf]" type="hidden" value="0" />
							<? if(in_array($key, array(27,28))){ ?>
							<label><input type="checkbox" class="checkbox notxt stopCheckbox checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
							<? }else{ ?>
							<label><input <? if($val['psf']){echo 'checked';} ?> name="data[<?=$key?>][psf]" type="checkbox" value="1" class="checkbox notxt stopCheckbox checkbox-custom-black-2 checkbox-blue-custom-white" /></label>
							<? } ?>
						</td>
						<td class="tac vam">
							<select name="data[<?=$key?>][tax_base]"  style="width:auto; min-width:100%; background:transparent" class="removeDownArrow disabledropdown">
								<? foreach($tax_base as $k=>$v){ ?>
								<option <? if($k == $val['tax_base']){echo "selected ";} ?> value="<?=$k?>"><?=$v?></option>
								<? } ?>
							</select>
						</td>
						<td class="tac vam">
							<input name="data[<?=$key?>][man_emp]" type="hidden" value="0" />
							<label><input <? if($val['man_emp']){echo 'checked';} ?> name="data[<?=$key?>][man_emp]" type="checkbox" class="checkbox notxt stopCheckbox checkbox-custom-black-2 checkbox-blue-custom-white" value="1" /></label>
						</td>
						<td class="tac vam">
							<input name="data[<?=$key?>][fixed_calc]" type="hidden" value="0" />
							<label><input <? if($val['fixed_calc']){echo 'checked';} ?> name="data[<?=$key?>][fixed_calc]" type="checkbox" class="checkbox notxt stopCheckbox checkbox-custom-black-2 checkbox-blue-custom-white" value="1" /></label>
						</td>
						<td class="tac vam">
							<input name="data[<?=$key?>][man_att]" type="hidden" value="0" />
							<label><input <? if($val['man_att']){echo 'checked';} ?> name="data[<?=$key?>][man_att]" type="checkbox" class="checkbox notxt stopCheckbox checkbox-custom-black-2 checkbox-blue-custom-white" value="1" /></label>
						</td>
						<td class="tac vam">
							<input name="data[<?=$key?>][comp_reduct]" type="hidden" value="0" />
							<label><input  <? if($val['comp_reduct']){echo 'checked';} ?> name="data[<?=$key?>][comp_reduct]" type="checkbox" class="checkbox notxt stopCheckbox checkbox-custom-black-2 checkbox-blue-custom-white" value="1" /></label>
						</td>
						<td>
							<select class="removeDownArrow disabledropdown" style="min-width: 190px !important; background:transparent;pointer-events: none;">
								<? foreach($income_section as $k=>$v){ ?>
								<option <? if($k == $val['income_base']){echo "selected ";} ?> value="<?=$k?>"><?=$v?></option>
								<? } ?>
								<!-- <option <? if($k == 6){echo "selected ";} ?> value="6">PND1 40(1) (2) Single payment by reason of termination</option> -->
							</select>
						</td>
					</tr>
					<? } ?>
				</tbody>
			</table>
			
			<div style="height:10px"></div>
			<!-- <button class="btn btn-primary btn-xs" type="button" id="addDatarow"><i class="fa fa-plus"></i>&nbsp;&nbsp;<?=$lng['Add row']?></button> -->
			
			<div id="dump"></div>
			
		</div>

	</div>

	<!------ Prev-Next Modal -------->
	<div class="modal fade" id="modalItemPopups" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog" role="document" style="min-width: 600px;">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?=$lng['Allowances & Deductions']?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<form id="dataForm">
						<input type="hidden" name="id" value="<?=count($data) +1?>">
						<!------ 1st tab start ---->
					    <div class="tab">
					    	<table class="basicTable compact inputs" style="width:100%;border:1px solid #eee;margin-bottom:10px">
								<thead>
									<tr>
										<th colspan="2"><?=strtoupper($lng['General information'])?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th class="tal"><?=$lng['Apply']?></th>
										<td>
											<input name="apply" type="hidden" value="0" />
											<input name="apply" type="checkbox" value="1" class="ml-2 checkbox-custom-blue-3" />
										</td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Description Thai']?></th>
										<td>
											<input placeholder="__" name="th" type="text" value="" />
										</td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Description English']?></th>
										<td>
											<input placeholder="__" name="en" type="text" value="" />
										</td>
									</tr>

									<tr>
										<th class="tal"><?=$lng['Classification']?></th>
										<td>
											<input type="radio" id="clsfication0" class="selClassification ml-2 mt-2 checkbox-custom-blue-2" name="classification" value="0"> &nbsp;<?=$lng['Allowances']?><br>
											<input type="radio" id="clsfication1" class="selClassification ml-2 mt-1 checkbox-custom-blue-2" name="classification" value="1"> &nbsp;<?=$lng['Deductions']?>
										</td>


									</tr>
								</tbody>
							</table>
					    </div>
					    <!------ 1st tab end ---->
					    <!------ 2nd tab start ---->
					    <div class="tab" style="display: none;">
					    	<table class="basicTable compact inputs" style="width:100%;border:1px solid #eee;margin-bottom:10px">
								<thead>
									<tr>
										<th colspan="2"><?=strtoupper($lng['Choose Group'])?></th>
									</tr>
								</thead>
								<tbody class="income_group" style="display: none;">
									<? foreach($income_group as $k=>$v){ ?>
										<tr>
											<th><?=$v?></th>
											<td>
												<input type="radio" id="groups<?=$k?>" name="groups" class="selGroup ml-2 checkbox-custom-blue-2" value="<?=$k?>">
											</td>
										</tr>
									<? } ?>
								</tbody>
								<tbody class="deduct_group" style="display: none;">
									<? foreach($deduct_group as $k=>$v){ ?>
										<tr>
											<th><?=$v?></th>
											<td>
												<input type="radio" id="groups<?=$k?>" name="groups" class="selGroup ml-2 checkbox-custom-blue-2" value="<?=$k?>">
											</td>
										</tr>
									<? } ?>
								</tbody>
							</table>
					    </div>
					    <!------ 2nd tab end ---->
					    <!------ 7th tab start ---->
					    <div class="tab" style="display: none;">
					    	<table class="basicTable compact inputs" style="width:100%;border:1px solid #eee;margin-bottom:10px">
								<thead>
									<tr>
										<th colspan="2"><?=strtoupper($lng['Calculation base'])?></th>
									</tr>
								</thead>
								<tbody>
									<tr id="man_emp_opt">
										<th class="tal"><?=$lng['Manual Emp. Reg.']?></th>
										<td>
											<input name="man_emp" type="hidden" value="0" />
											<input name="man_emp" type="checkbox" value="1" class="ml-2 checkbox-custom-blue-3" />
										</td>
									</tr>
									<tr id="man_feed_opt">
										<th class="tal"><?=$lng['Manual Feed']?></th>
										<td>
											<input name="man_att" type="hidden" value="0" />
											<input name="man_att" type="checkbox" value="1" class="ml-2 checkbox-custom-blue-3" />
										</td>
									</tr>
									<tr id="rew_and_pen">
										<th class="tal"><?=$lng['Rew. & Pen.']?></th>
										<td>
											<input name="comp_reduct" type="hidden" value="0" />
											<input name="comp_reduct" type="checkbox" value="1" class="ml-2 checkbox-custom-blue-3" />
										</td>
									</tr>
								</tbody>
							</table>
					    </div>
					    <!------ 7th tab end ---->
					    <!------ 3rd tab start ---->
					    <div class="tab" style="display: none;">
					    	<table class="basicTable compact inputs" style="width:100%;border:1px solid #eee;margin-bottom:10px">
								<thead>
									<tr>
										<th colspan="2"><?=strtoupper($lng['Add to total for calculations'])?></th>
									</tr>
								</thead>
								<tbody class="income_group" style="display: none;">
									<tr>
										<th class="tal"><?=$lng['Earnings']?></th>
										<td>
											<input name="earnings" type="hidden" value="0" />
											<input name="earnings" type="checkbox" value="1" class="ml-2 checkbox-custom-blue-3" />
										</td>
									</tr>
								</tbody>
								<tbody class="deduct_group" style="display: none;">
									<tr>
										<th class="tal"><?=$lng['Deductions']?></th>
										<td>
											<input name="deductions" type="hidden" value="0" />
											<input name="deductions" type="checkbox" value="1" class="ml-2 checkbox-custom-blue-3" />
										</td>
									</tr>
								</tbody>
								<tbody>
									<tr>
										<th class="tal"><?=$lng['Hour rate/Daily rate']?></th>
										<td>
											<input name="hour_daily_rate" type="hidden" value="0" />
											<input name="hour_daily_rate" type="checkbox" value="1" class="ml-2 checkbox-custom-blue-3" />
										</td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['PND1']?></th>
										<td>
											<input name="pnd1" type="hidden" value="0" />
											<input name="pnd1" type="checkbox" value="1" class="ml-2 pnd1checkbox checkbox-custom-blue-3" />
										</td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Tax incom']?></th>
										<td>
											<input name="tax_income" type="hidden" value="0" />
											<input name="tax_income" class="taxBasecheckbox ml-2 checkbox-custom-blue-3" type="checkbox" value="1">
										</td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['SSO']?></th>
										<td>
											<input name="sso" type="hidden" value="0" />
											<input name="sso" type="checkbox" value="1" class="ml-2 checkbox-custom-blue-3" />
										</td>
									</tr>
								</tbody>
							</table>
					    </div>
					    <!------ 3rd tab end ---->
					    <!------ 4th tab start ---->
					    <div class="tab" style="display: none;">
					    	<table class="basicTable compact inputs" style="width:100%;border:1px solid #eee;margin-bottom:10px">
								<thead>
									<tr>
										<th colspan="2"><?=strtoupper($lng['Added to totals for PVF or PSF calculation'])?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th class="tal"><?=$lng['PVF']?></th>
										<td>
											<input name="pvf" type="hidden" value="0" />
											<input name="pvf" type="checkbox" value="1" class="ml-2 checkbox-custom-blue-3" />
										</td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['PSF']?></th>
										<td>
											<input name="psf" type="hidden" value="0" />
											<input name="psf" type="checkbox" value="1" class="ml-2 checkbox-custom-blue-3" />
										</td>
									</tr>
								</tbody>
							</table>
					    </div>
					    <!------ 4th tab end ---->
					    <!------ 5th tab start ---->
					    <div class="tab" style="display: none;">
					    	<table class="basicTable compact inputs" style="width:100%;border:1px solid #eee;margin-bottom:10px">
								<thead>
									<tr>
										<th colspan="2"><?=strtoupper($lng['Taxable base'])?></th>
									</tr>
								</thead>
								<tbody>
									<? foreach($tax_base as $k=>$v){ ?>
										<tr id="tbrow<?=$k?>">
											<th><?=$v?></th>
											<td>
												<input type="radio" id="tax_base<?=$k?>" name="tax_base" class="ml-2 checkbox-custom-blue-2" value="<?=$k?>">
											</td>
										</tr>
									<? } ?>
								</tbody>
							</table>
					    </div>
					    <!------ 5th tab end ---->
					    <!------ 6th tab start ---->
					    <div class="tab" style="display: none;">
					    	<table class="basicTable compact inputs" style="width:100%;border:1px solid #eee;margin-bottom:10px">
								<thead>
									<tr>
										<th colspan="2"><?=strtoupper($lng['Income base section PND form'])?></th>
									</tr>
								</thead>
								<tbody>
									<? foreach($income_section as $k=>$v){ ?>
										<tr id="ibrow<?=$k?>">
											<th><?=$v?></th>
											<td>
												<input type="radio" id="income_base<?=$k?>" name="income_base" class="ml-2 checkbox-custom-blue-2" value="<?=$k?>">
											</td>
										</tr>
									<? } ?>
									<!-- <tr id="ibrow6">
										<th>PND1 40(1) (2) Single payment by reason of termination</th>
										<td>
											<input type="radio" id="income_base6" name="income_base" class="ml-2 checkbox-custom-blue-2" value="6">
										</td>
									</tr> -->

								</tbody>
							</table>
					    </div>
					    <!------ 6th tab end ---->
					    

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

	<!---- Modal start---->
	<div class="modal fade" id="modalItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		 	<div class="modal-dialog" style="min-width:800px">
			  	<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel"><?=$lng['Allowances & Deductions']?></h4>
						<button data-dismiss="modal" style="float:right" class="btn btn-default" type="button"><i class="fa fa-times"></i></button>
					</div>
					<div class="modal-body">

						<!-- <form id="dataForm"> -->
							<input type="hidden" name="id" value="<?=count($data) +1?>">
							<table class="basicTable compact inputs" style="width:100%; border:1px solid #eee; margin-bottom:10px">
								<thead>
									<tr>
										<th colspan="2"><?=$lng['ITEM DESCRIPTION']?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th class="tal"><?=$lng['Apply']?></th>
										<td>
											<input name="apply" type="hidden" value="0" />
											<input name="apply" type="checkbox" value="1" class="ml-2 checkbox-custom-black-3 checkbox-blue-custom-white stopCheckbox" />
										</td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Description Thai']?></th>
										<td>
											<input placeholder="__" name="th" type="text" value="" readonly="readonly"/>
										</td>
									</tr>
									<tr>
										<th class="tal"><?=$lng['Description English']?></th>
										<td>
											<input placeholder="__" name="en" type="text" value="" readonly="readonly"/>
										</td>
									</tr>

									<tr>
										<th class="tal"><?=$lng['Classification']?></th>
										<td>
											<select class="selClassification removeDownArrow disabledropdown" name="classification" style="width:auto; min-width:100%">
												<option value="0"><?=$lng['Allowances']?></option>
												<option value="1"><?=$lng['Deductions']?></option>
											</select>
										</td>
									</tr>

									<tr>
										<th class="tal"><?=$lng['Group']?></th>
										<td>
											<select class="selGroup removeDownArrow disabledropdown" name="groups" style="width:auto; min-width:100%">
												<? foreach($data_group as $k=>$v){ ?>
													<option value="<?=$k?>"><?=$v?></option>
												<? } ?>
											</select>
										</td>
									</tr>

									<tr>
										<th class="tal"><?=$lng['Tax Base']?></th>
										<td>
											<select class="removeDownArrow disabledropdown" name="tax_base" style="width:auto; min-width:100%">
												<? foreach($tax_base as $k=>$v){ ?>
													<option value="<?=$k?>"><?=$v?></option>
												<? } ?>
											</select>
										</td>
									</tr>
								</tbody>
							</table>

							<table class="basicTable compact inputs" style="table-layout:fixed; width:100%; border:1px solid #eee; margin-bottom:10px">
								<tbody>
									<tr>
										<td style="padding:0 5px 0 0; width:39%;">
											<table class="basicTable compact inputs" style="table-layout:fixed; width:100%; border:1px solid #eee; margin-bottom:10px">
												<thead>
													<tr>
														<th colspan="2"><?=$lng['Add to total for calculations']?></th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<th class="tal"><?=$lng['Earnings']?></th>
														<td>
															<input name="earnings" type="hidden" value="0" />
															<input name="earnings" type="checkbox" value="1" class="ml-2 checkbox-custom-black-3 checkbox-blue-custom-white stopCheckbox" />
														</td>
													</tr>
													<tr>
														<th class="tal"><?=$lng['Deductions']?></th>
														<td>
															<input name="deductions" type="hidden" value="0" />
															<input name="deductions" type="checkbox" value="1" class="ml-2 checkbox-custom-black-3 checkbox-blue-custom-white stopCheckbox" />
														</td>
													</tr>
													<tr>
														<th class="tal"><?=$lng['Hour rate/Daily rate']?></th>
														<td>
															<input name="hour_daily_rate" type="hidden" value="0" />
															<input name="hour_daily_rate" type="checkbox" value="1" class="ml-2 checkbox-custom-black-3 checkbox-blue-custom-white stopCheckbox" />
														</td>
													</tr>
													<tr>
														<th class="tal"><?=$lng['PND1']?></th>
														<td>
															<input name="pnd1" type="hidden" value="0" />
															<input name="pnd1" type="checkbox" value="1" class="ml-2 checkbox-custom-black-3 checkbox-blue-custom-white stopCheckbox" />
														</td>
													</tr>
													<tr>
														<th class="tal"><?=$lng['Tax incom']?></th>
														<td>
															<input name="tax_income" type="hidden" value="0" />
															<input name="tax_income" type="checkbox" value="1" class="ml-2 checkbox-custom-black-3 checkbox-blue-custom-white stopCheckbox" />
														</td>
													</tr>
													<tr>
														<th class="tal"><?=$lng['SSO']?></th>
														<td>
															<input name="sso" type="hidden" value="0" />
															<input name="sso" type="checkbox" value="1" class="ml-2 checkbox-custom-black-3 checkbox-blue-custom-white stopCheckbox" />
														</td>
													</tr>
													<tr>
														<th class="tal"><?=$lng['PVF']?></th>
														<td>
															<input name="pvf" type="hidden" value="0" />
															<input name="pvf" type="checkbox" value="1" class="ml-2 checkbox-custom-black-3 checkbox-blue-custom-white stopCheckbox" />
														</td>
													</tr>
													<tr>
														<th class="tal"><?=$lng['PSF']?></th>
														<td>
															<input name="psf" type="hidden" value="0" />
															<input name="psf" type="checkbox" value="1" class="ml-2 checkbox-custom-black-3 checkbox-blue-custom-white stopCheckbox" />
														</td>
													</tr>
												</tbody>
											</table>
										</td>

										<td class="vat" style="padding:0 0 0 5px; width: 60%;">
											<table class="basicTable compact inputs" style="table-layout:fixed; width:100%; border:1px solid #eee; margin-bottom:10px">
												<thead>
													<tr>
														<th colspan="2"><?=$lng['Calculation base']?></th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<th class="tal"><?=$lng['Manual Emp. Reg.']?></th>
														<td>
															<input name="man_emp" type="hidden" value="0" />
															<input name="man_emp" type="checkbox" value="1" class="ml-2 checkbox-custom-black-3 checkbox-blue-custom-white stopCheckbox" />
														</td>
													</tr>
													<tr>
														<th class="tal"><?=$lng['Manual Feed']?></th>
														<td>
															<input name="man_att" type="hidden" value="0" />
															<input name="man_att" type="checkbox" value="1" class="ml-2 checkbox-custom-black-3 checkbox-blue-custom-white stopCheckbox" />
														</td>
													</tr>
													<tr>
														<th class="tal"><?=$lng['Rew. & Pen.']?></th>
														<td>
															<input name="comp_reduct" type="hidden" value="0" />
															<input name="comp_reduct" type="checkbox" value="1" class="ml-2 checkbox-custom-black-3 checkbox-blue-custom-white stopCheckbox" />
														</td>
													</tr>
													<tr>
														<th class="tal">Fixed Emp. Reg</th>
														<td>
															<input name="fixed_calc" type="hidden" value="0" />
															<input name="fixed_calc" type="checkbox" value="1" class="ml-2 checkbox-custom-black-3 checkbox-blue-custom-white stopCheckbox" />
														</td>
													</tr>
												</tbody>
											</table> 

											<table class="basicTable compact inputs" style="table-layout:fixed; width:100%; border:1px solid #eee; margin-bottom:10px">
												<thead>
													<tr>
														<th colspan="2"><?=$lng['Income base section PND form']?></th>
													</tr>
												</thead>
												<tbody>
													<? foreach($income_section as $k=>$v){ ?>
														<tr id="ibrow<?=$k?>">
															<th class="tal" style="border-right: 1px solid #fff !important;"><?=$v?></th>
															<td>
																<input type="radio" id="income_base<?=$k?>" name="income_base" class="ml-2 checkbox-custom-black-2 checkbox-blue-custom-white stopCheckbox radioCheckboxCss" value="<?=$k?>" style="float: right;margin-right: 10px;pointer-events: none;">
															</td>
														</tr>
													<? } ?>
													<!-- <tr id="ibrow6">
														<th class="tal">PND1 40(1) (2) Single payment by reason of termination</th>
														<td>
															<input type="radio" id="income_base6" name="income_base" class="ml-2 checkbox-custom-black-2 checkbox-blue-custom-white radioCheckboxCss" value="6" style="float: right;margin-right: 10px;pointer-events: none;">
														</td>
													</tr> -->
												</tbody>
											</table> 

										</td>
									</tr>
								</tbody>

							</table>
							
							
						<!-- </form> -->

					</div>
				</div>
			</div>
	</div>
	<!---- Modal end---->
	
<script>

	var currentTab = 0;
	showTab(currentTab);

	function showTab(n) {
	  var x = document.getElementsByClassName("tab"); 
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
	    SavethisForm();
	    return false;
	  }
	  showTab(currentTab);
	}

	function SavethisForm(){
		$("#dataForm").submit();
	}

	function classFilter(that){

		// get current url from the url bar 
		// console.log(that);
		// var urlbar      = window.location.href;     // Returns full URL (https://example.com/path/example.html)
		// var spliturl = urlbar.split("701");

		window.location.href = 'index.php?mn=701'+that;
	}


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
		var tax_base = <?=json_encode($tax_base)?>;
		var income_section = <?=json_encode($income_section)?>;
		
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

			$('#hiddengroupfilter').val(output);

			// dtable.columns([7]).search(output,true,false).draw();
    	})		

  //   	$('#groupFilter').on('change',function(e){

  //   		var hiddengroupfilter = $('#hiddengroupfilter').val();
  //   		var getlockfiltervalue = $('#lockFilter').val();
  //   		var classificationFilter = $('#classificationFilter').val();

  //   		// run ajax here 

  //   		$.ajax({
		// 		url: "ajax/def/update_filter_session.php",
		// 		type: 'POST',
		// 		data: {hiddengroupfilter: hiddengroupfilter},
		// 		success: function(result){
		// 			if(result)
		// 			{
		// 				window.location.href = 'index.php?mn=701'+classificationFilter+'&cri='+getlockfiltervalue;
		// 			}
		// 		},
		// 	});


		// });

			$('select#groupFilter').on('sumo:closing', function(o) {

				var hiddengroupfilter = $('#hiddengroupfilter').val();
	    		var getlockfiltervalue = $('#lockFilter').val();
	    		var classificationFilter = $('#classificationFilter').val();

	    		// run ajax here 

	    		$.ajax({
					url: "ajax/def/update_filter_session.php",
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
			<?=$dtable_lang?>
			info: 			false,
			initComplete : function( settings, json ) {
				$('#showTable').fadeIn(500);

				console.log(json);				
				setTimeout(function(){
					dtable.columns.adjust().draw();

					dtable.columns([1]).search('Edit').draw();
					dtable.columns([5]).search('income').draw();
					dtable.columns([7]).search("inc_fix|inc_var",true,false).draw();
				},10);
			}
		});

		$('#lockFilter').on('change', function(){

			var hiddengroupfilter = $('#hiddengroupfilter').val();
    		var getlockfiltervalue = $('#lockFilter').val();
    		var classificationFilter = $('#classificationFilter').val();

    		// run ajax here 

    		$.ajax({
				url: "ajax/def/update_filter_session.php",
				type: 'POST',
				data: {hiddengroupfilter: hiddengroupfilter},
				success: function(result){
					if(result)
					{
						window.location.href = 'index.php?mn=701'+classificationFilter+'&cri='+getlockfiltervalue;
					}
				},
			});

			// dtable.columns([1]).search($(this).val()).draw();
			// var getclassificationvalue = $('#classificationFilter').val();
			// window.location.href = 'index.php?mn=701&cri='+$(this).val()+ getclassificationvalue;
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
				url: "ajax/def/update_filter_session.php",
				type: 'POST',
				data: {hiddengroupfilter: hiddengroupfilter},
				success: function(result){
					if(result)
					{
						window.location.href = 'index.php?mn=701'+classificationFilter+'&cri='+getlockfiltervalue;
					}
				},
			});
			
			// dtable.columns([5]).search($(this).val()).draw();
			// $("#groupFilter option:selected").removeAttr("selected");
			// $("ul.options li").removeClass("selected");

			// var getlockfiltervalue = $('#lockFilter').val();
			// window.location.href = 'index.php?mn=701'+$(this).val()+'&cri='+getlockfiltervalue;
		})

		// $('#groupFilter').on('change', function(){

		// 	console.log('1111111');
		// 	// var getlockfiltervalue = $('#lockFilter').val();
		// 	// window.location.href = 'index.php?mn=701'+$(this).val()+'&cri='+getlockfiltervalue;
		// })


		function texinputChk(val){
			
			if(val == 1){
				$.each(tax_base, function(k,v){
					if(k == 'nontax'){
						$('#tbrow'+k).css('display','none');
					}else{
						$('#tbrow'+k).css('display','table-row');
					}
				})

			}else{

				$.each(tax_base, function(k,v){
					if(k != 'nontax'){
						$('#tbrow'+k).css('display','none');
					}else{
						$('#tbrow'+k).css('display','table-row');
					}
				})
			}
		}

		$(document).on('click', '.taxBasecheckbox', function(){

			if(this.checked){
				$.each(tax_base, function(k,v){
					if(k == 'nontax'){
						$('#tbrow'+k).css('display','none');
					}else{
						$('#tbrow'+k).css('display','table-row');
					}
				})
			}else{
				$.each(tax_base, function(k,v){
					if(k != 'nontax'){
						$('#tbrow'+k).css('display','none');
					}else{
						$('#tbrow'+k).css('display','table-row');
					}
				})
			}
		})

		function pnd1checkboxfn(val){ 
			if(val == 1){
				$.each(income_section, function(k,v){
					if(k == 4 || k == 5){
						$('#ibrow'+k).css('display','none');
					}else{
						$('#ibrow'+k).css('display','table-row');
					}
				})
				//$('#ibrow6').css('display','table-row');
				
			}else{
				$.each(income_section, function(k,v){
					if(k == 1 || k == 2 || k == 3){
						$('#ibrow'+k).css('display','none');
					}else{
						$('#ibrow'+k).css('display','table-row');
					}
				})
				//$('#ibrow6').css('display','none');
			}
		}

		$(document).on('click', '.pnd1checkbox', function(){
			if(this.checked){
				$.each(income_section, function(k,v){
					if(k == 4 || k == 5){
						$('#ibrow'+k).css('display','none');
					}else{
						$('#ibrow'+k).css('display','table-row');
					}
				})
				//$('#ibrow6').css('display','table-row');
			}else{
				$.each(income_section, function(k,v){
					if(k == 1 || k == 2 || k == 3){
						$('#ibrow'+k).css('display','none');
					}else{
						$('#ibrow'+k).css('display','table-row');
					}
				})
				//$('#ibrow6').css('display','none');
			}
		})

		$(document).on('click', '.selGroup', function(){
			var valss = this.value;

			if(valss == 'inc_fix' || valss == 'ded_fix'){
				$('#man_feed_opt').css('display','none');
				$('#rew_and_pen').css('display','none');
				$('#man_emp_opt').css('display','table-row');
			}else if(valss == 'inc_ot' || valss == 'inc_var' || valss == 'inc_oth' || valss == 'ded_abs' || valss == 'ded_var' || valss == 'ded_oth'){
				$('#man_emp_opt').css('display','none');
				$('#man_feed_opt').css('display','table-row');
				$('#rew_and_pen').css('display','table-row');
			}else if(valss == 'inc_sal' || valss == 'ded_leg' || valss == 'ded_pay'){
				$('#man_emp_opt').css('display','table-row');
				$('#man_feed_opt').css('display','table-row');
				$('#rew_and_pen').css('display','table-row');
			}
		});

		function calculationBase(valss){

			if(valss == 'inc_fix' || valss == 'ded_fix'){
				$('#man_feed_opt').css('display','none');
				$('#rew_and_pen').css('display','none');
				$('#man_emp_opt').css('display','table-row');
			}else if(valss == 'inc_ot' || valss == 'inc_var' || valss == 'inc_oth' || valss == 'ded_abs' || valss == 'ded_var' || valss == 'ded_oth'){
				$('#man_emp_opt').css('display','none');
				$('#man_feed_opt').css('display','table-row');
				$('#rew_and_pen').css('display','table-row');
			}else if(valss == 'inc_sal' || valss == 'ded_leg' || valss == 'ded_pay'){
				$('#man_emp_opt').css('display','table-row');
				$('#man_feed_opt').css('display','table-row');
				$('#rew_and_pen').css('display','table-row');
			}
		}

		function getGroups(s){

			var group;
			if(s == 1){ group = deduct_group }else{ group = income_group };
			var selGroup = $('#modalItem select.selGroup');
			selGroup.empty();
			selGroup.append($("<option />").val('').text('Select'));
			$.each(group, function(i, v) {
				selGroup.append($("<option />").val(i).text(v));
			});	
		}

		$(document).on('change', '.selClassification', function(){
			var s = this.value; //alert(s);
			getGroups(s);	

			if(s == 1){
				$('#modalItemPopups table tbody.income_group').css('display','none');
				$('#modalItemPopups table tbody.deduct_group').css('display','table-row-group');
			}else{
				$('#modalItemPopups table tbody.income_group').css('display','table-row-group');
				$('#modalItemPopups table tbody.deduct_group').css('display','none');
			}	
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
					'<label><input name="data['+row+'][apply]" type="checkbox" value="1" class="checkbox notxt" /></label>'+
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
					'<label><input name="data['+row+'][earnings]" type="checkbox" value="1" class="checkbox notxt selEarnings" /></label>'+
				'</td>'+
				'<td class="tac vam">'+
					'<input name="data['+row+'][deductions]" type="hidden" value="0" />'+
					'<label><input name="data['+row+'][deductions]" type="checkbox" value="1" class="checkbox notxt selDeductions" /></label>'+
				'</td>'+
				'<td class="tac vam">'+
					'<input name="data['+row+'][pnd1]" type="hidden" value="0" />'+
					'<label><input name="data['+row+'][pnd1]" type="checkbox" value="1" class="checkbox notxt" /></label>'+
				'</td>'+
				'<td class="tac vam">'+
					'<input name="data['+row+'][tax_income]" type="hidden" value="0" />'+
					'<label><input name="data['+row+'][tax_income]" type="checkbox" value="1" class="checkbox notxt" /></label>'+
				'</td>'+
				'<td class="tac vam">'+
					'<input name="data['+row+'][sso]" type="hidden" value="0" />'+
					'<label><input name="data['+row+'][sso]" type="checkbox" value="1" class="checkbox notxt" /></label>'+
				'</td>'+
				'<td class="tac vam">'+
					'<input name="data['+row+'][pvf]" type="hidden" value="0" />'+
					'<label><input name="data['+row+'][pvf]" type="checkbox" value="1" class="checkbox notxt" /></label>'+
				'</td>'+
				'<td class="tac vam">'+
					'<input name="data['+row+'][psf]" type="hidden" value="0" />'+
					'<label><input name="data['+row+'][psf]" type="checkbox" value="1" class="checkbox notxt" /></label>'+
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
					'<label><input name="data['+row+'][man_emp]" type="checkbox" class="checkbox notxt" value="1" /></label>'+
				'</td>'+
				'<td class="tac vam">'+
					'<input name="data['+row+'][man_att]" type="hidden" value="0" />'+
					'<label><input name="data['+row+'][man_att]" type="checkbox" class="checkbox notxt" value="1" /></label>'+
				'</td>'+
				'<td class="tac vam">'+
					'<input name="data['+row+'][comp_reduct]" type="hidden" value="0" />'+
					'<label><input name="data['+row+'][comp_reduct]" type="checkbox" class="checkbox notxt" value="1" /></label>'+
				'</td>'+
			'</tr>';
			
			$("#allowDeductTable tr:last").after(addrow);
			row ++;
		});
		
		
		//$('#submitBtn').on('click', function(){
			//$("#dataForm").submit();  //dont open this form submit two times
		//})
		
		$("#dataForm").submit(function(e){ 

			e.preventDefault();
			$("#submitBtn i").removeClass('fa-save').addClass('fa-refresh fa-spin');
			var data = $(this).serialize();
			$.ajax({
				url: "ajax/def/update_allow_deduct.php",
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


		$(document).on('click', '.editItemPopups', function(){

			var id = $(this).data('id');
			$.ajax({
				url: "ajax/def/get_allow_deduct.php",
				type: 'POST', 
				data: {id: id},
				dataType: 'json',
				success: function(data){

					$('input[name="id"]').val(data.id);
					$('input[name="apply"]').attr('checked',data.Napply);
					
					$('input[name="th"]').val(data.th);
					$('input[name="en"]').val(data.en);

					//$('select[name="classification"]').val(data.classification);
					$('input#clsfication'+data.classification).attr('checked',true);
					getGroups(data.classification);
					texinputChk(data.tax_income);
					pnd1checkboxfn(data.pnd1);
					calculationBase(data.groups);
					//$('select[name="groups"]').val(data.groups);

					if(data.classification == 1){
						$('tbody.income_group').css('display','none');
						$('tbody.deduct_group').css('display','table-row-group');
					}else{
						$('tbody.income_group').css('display','table-row-group');
						$('tbody.deduct_group').css('display','none');
					}

					$('input#groups'+data.groups).attr('checked',true);

					//$('select[name="tax_base"]').val(data.tax_base);

					$('input#tax_base'+data.tax_base).attr('checked',true);
					$('input#income_base'+data.income_base).attr('checked',true);
					

					$('input[name="earnings"]').attr('checked',data.Nearnings);
					$('input[name="deductions"]').attr('checked',data.Ndeductions);
					$('input[name="hour_daily_rate"]').attr('checked',data.Nhourdailyrate);
					$('input[name="pnd1"]').attr('checked',data.Npnd1);
					$('input[name="tax_income"]').attr('checked',data.Ntax_income);
					$('input[name="sso"]').attr('checked',data.Nsso);
					$('input[name="pvf"]').attr('checked',data.Npvf);
					$('input[name="psf"]').attr('checked',data.Npsf);
					$('input[name="man_emp"]').attr('checked',data.Nman_emp);
					$('input[name="man_att"]').attr('checked',data.Nman_att);
					$('input[name="comp_reduct"]').attr('checked',data.Ncomp_reduct);

					$('#modalItemPopups').modal('toggle');
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			})
		});

		$(document).on('click', '.editItem', function(){
			var id = $(this).data('id');

			$.ajax({
				url: "ajax/def/get_allow_deduct.php",
				type: 'POST', 
				data: {id: id},
				dataType: 'json',
				success: function(data){

					$('input[type="radio"]').attr("checked",false);

					$('input[name="id"]').val(data.id);
					$('input[name="apply"]').attr('checked',data.Napply);
					
					$('input[name="th"]').val(data.th);
					$('input[name="en"]').val(data.en);

					$('select[name="classification"]').val(data.classification);
					getGroups(data.classification);
					$('select[name="groups"]').val(data.groups);
					$('select[name="tax_base"]').val(data.tax_base);
					$('input#income_base'+data.income_base).attr('checked',true);

					$('input[name="earnings"]').attr('checked',data.Nearnings);
					$('input[name="deductions"]').attr('checked',data.Ndeductions);
					$('input[name="hour_daily_rate"]').attr('checked',data.Nhourdailyrate);
					$('input[name="pnd1"]').attr('checked',data.Npnd1);
					$('input[name="tax_income"]').attr('checked',data.Ntax_income);
					$('input[name="sso"]').attr('checked',data.Nsso);
					$('input[name="pvf"]').attr('checked',data.Npvf);
					$('input[name="psf"]').attr('checked',data.Npsf);
					$('input[name="man_emp"]').attr('checked',data.Nman_emp);
					$('input[name="man_att"]').attr('checked',data.Nman_att);
					$('input[name="comp_reduct"]').attr('checked',data.Ncomp_reduct);
					$('input[name="fixed_calc"]').attr('checked',data.Nfixed_calc);

					$('#modalItem').modal('toggle');
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}

			})

			
		})

	});

</script>	





