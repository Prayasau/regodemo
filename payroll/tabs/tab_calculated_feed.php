<div style="height:100%; border:0px solid red; position:relative;">
	<div>
		<div class="smallNav">
			<ul>
				<li>
					<div class="searchFilter" style="margin:0">
						<input placeholder="Filter" id="searchFiltercf" class="sFilter" type="text">
						<button id="clearSearchboxcf" type="button" class="clearFilter btn btn-default btn-sm"><i class="fa fa-times"></i></button>
					</div>
				</li>	

			</ul>
		</div>
	</div>
	<?php
	/*echo '<pre>';
	print_r($getCalcFeedAllowDeduct);
	echo '</pre>';*/
	?>
	<table id="CalcFeedDT" class="dataTable hoverable selectable">
		<thead>
			<tr>
				<th colspan="3" class="tac"><?=$lng['Employee']?></th>
				<th colspan="<?= count($getCalcFeedAllowDeduct)?>" class="tac"><?=$lng['Attendance & Allowance Data']?></th>
				<th colspan="<?= count($getCalcFeedAllowDeduct)?>" class="tac"><?=$lng['Total allowance in THB']?></th>
			</tr>
			<tr>
				<th class="tal"><?=$lng['Emp. ID']?></th>
				<th class="tal" style="width: 130px;"><?=$lng['Employee name']?></th>
				<th class="tal"><?=$lng['Calc']?></th>
				<?php foreach($getCalcFeedAllowDeduct as $key => $val){ ?>
					<th class="tac"><?=$val['en']?></th>
				<? } ?>
				<?php foreach($getCalcFeedAllowDeduct as $key => $val){ ?>
					<th class="tac"><?=$val['en']?></th>
				<? } ?>
			</tr>
		</thead>
		<tbody>
			<!-- <tr>
				<td>1234</td>
				<td>Test name</td>
				<td></td>

				<?php foreach($getCalcFeedAllowDeduct as $key => $val){ ?>
					<td><?=$val['comp_reduct']?></td>
				<? } ?>
				<?php foreach($getCalcFeedAllowDeduct as $key => $val){ ?>
					<td><?=$val['comp_reduct']?></td>
				<? } ?>
				
			</tr> -->
			


		</tbody>
	</table>

	<div class="row">
		<div class="col-md-2" style="margin: -30px 0px 0px 0px;margin-left: auto;margin-right: auto;">
			<select id="pageLengthcf" class="button btn-fl">
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