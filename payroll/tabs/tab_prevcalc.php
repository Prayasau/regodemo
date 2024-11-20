<div style="height:100%; border:0px solid red; position:relative;">
	<div>
		<div class="smallNav">
			<ul>
				<li>
					<div class="searchFilter" style="margin:0">
						<input placeholder="Filter" id="searchFiltertprvc" class="sFilter" type="text">
						<button id="clearSearchboxtprvc" type="button" class="clearFilter btn btn-default btn-sm"><i class="fa fa-times"></i></button>
					</div>
				</li>	

			</ul>
		</div>
	</div>
	
	<table id="prevcalc_table" class="dataTable hoverable selectable">
		<thead>
			<tr>
				<th colspan="4" class="tac"><?=$lng['Employee']?></th>
				<!-- <th colspan="<?=$countColumn + 2;?>" class="tac"><?=$lng['Attendance & Allowance Data']?></th>	 -->			
				<th colspan="<?=$countOuter + 1;?>" class="tac"><?=$lng['Total allowance in THB']?></th>
			</tr>
			<tr>
				<th class="tal"><?=$lng['Emp. ID']?></th>
				<th class="tal" style="width: 130px;"><?=$lng['Employee name']?></th>
				<th class="tal"><?=$lng['Calc']?></th>

				<th class="tac"><?=$lng['Paid'].'<br>'.$lng['days']?></th>
				<th class="tac"><?=$lng['Paid'].'<br>'.$lng['hours']?></th>
				<?/* foreach($dropdownArray as $key => $rows){ ?>
					<th class="tal"><?=$rows?></th>
				<? }*/ ?>

				<th class="tac"><?=$lng['Basic salary']?></th>
				<? foreach($outerArray as $key => $val){ ?>
					<th class="tac"><?=$val?></th>
				<? } ?>
			</tr>
		</thead>
		<tbody>
			<? 

			$paid_hours = array();
			foreach($getSelmonPayrollDatass as $key => $row){ 
					$manual_feed_data = unserialize($row['manual_feed_data']);
					$manual_feed_total = unserialize($row['manual_feed_total']);
					$paid_hours[] = $row['paid_hours'];
					
				?>
				<tr data-eid="<?=$row['emp_id']?>">
					<td class="pad010 pl-2 font-weight-bold"><?=$row['emp_id']?></td>
					<td class="pad010 pl-2 font-weight-bold"><?=$row['emp_name_'.$lang]?></td>
					<td class="pad010 tac">
						<a class="manualfeedmdl" id="<?=$countRow;?>"><i class="fa fa-calculator fa-lg" ></i></a>
					</td>

					<td><?=$row['paid_days']?></td>
					<td><?=$row['paid_hours']?></td>
					
					<?/*  foreach($dropdownArrayNew as $key => $rows){ 

							if($position = stripos($rows[0],"hrs", 3) == true){
								
								echo '<td>'.$manual_feed_data['hrs'][$rows[1]].'</td>';

							}elseif($position = stripos($rows[0],"hours", 5) == true){
								
								echo '<td>'.$manual_feed_data['hours'][$rows[1]].'</td>';

							}elseif($position = stripos($rows[0],"times", 5) == true){
								
								echo '<td>'.$manual_feed_data['times'][$rows[1]].'</td>';

							}elseif($position = stripos($rows[0],"thb", 3) == true){
								
								echo '<td>'.$manual_feed_data['thb'][$rows[1]].'</td>';

							}else{

								echo '<td>'.$manual_feed_data['other'][$rows[1]].'</td>';
							}
						?>
					<? }*/ ?>

					<td><?=$row['basic_salary']?></td>

					<? foreach($outerArray as $key => $val){?>

						<td><?=$manual_feed_total[$key]?></td>

					<? } ?>
					
				</tr>
			<? } ?>
		</tbody>
	</table>

	<div class="row">
		<div class="col-md-2" style="margin: -30px 0px 0px 0px;margin-left: auto;margin-right: auto;">
			<select id="pageLengthtprvc" class="button btn-fl">
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