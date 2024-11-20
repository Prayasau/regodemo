<style type="text/css">
	
</style>	
	<div class="row" style="padding: 30px;padding-top: 15px;"> 
		<div class="col-md-6">

			<!-- RED -->
			
			<div class="row" >
				<img style="width: 6%;height: 0%;" src="<?php echo ROOT;?>assets/images/decision_icons/cancel.png">

				<h5 style="margin-left: 10%;padding-top: 6px;font-size: 15px;color: #d62e2b;font-weight: 600;">Invalid format used for certain fields! </h5>
			</div>

			<!-- YELLOW -->
			
			<div class="row" style="margin-top: 20px;">
				<img style="width: 6%;height: 0%;" src="<?php echo ROOT;?>assets/images/decision_icons/warning.png">
				<h5 style="margin-left: 10%;padding-top: 6px;font-size: 15px;color: #DAB423;font-weight: 600;">No Changes were noticed! 
				</h5>
			</div>	

			<!-- GREEN -->

			<div class="row" style="margin-top: 20px;">
				<img id="correctImage" style="width: 6%;height: 0%;" src="<?php echo ROOT;?>assets/images/decision_icons/correct.png">
				<h5 style="margin-left: 10%;padding-top: 6px;color: #2faf36;font-weight: 600;">Data ready to be saved! 
				</h5>
			</div>

			
			
		</div>

		<div class="col-md-6">
			<table class="basicTable">
				<thead >
					<tr>
						<th colspan="2">
							<i class="fa fa-arrow-circle-down"></i>&nbsp; <?=$lng['Review and Approval']?>
						</th>
					</tr>
				</thead>
			</table>					
			<table class="basicTable" style="width:100%; margin-bottom:8px">
				<tr>
					<th class="tal"><?=$lng['Approval'];?></th>
					<td colspan="2">
						<input type="checkbox" class="ml-2 checkbox-blue-custom-white  checkbox-custom-blue-2" style="position: relative;top: 2px;">
						<span class="ml-2 text-italic" style="position: relative;bottom: 1px;">No approval required</span>
					</td>
				</tr>
			</table>

			
			<button disabled class="btn btn-primary mt-4" type="button"><?=$lng['Save to Employee Register']?></button>
		</div>
	</div>

	<div class="row" style="padding: 30px;">

		<div id="showTable" style="width: 50%">

			<table class="basicTable" style="width:100%; margin-bottom:8px">
				<thead >
					<tr>
						<th colspan="2">
							<i class="fa fa-arrow-circle-down"></i>&nbsp;<?=$lng['Log History']?>
						</th>
					</tr>
				</thead>
			</table>					
			<table style="width:50%; margin-bottom:8px">
				<tr>
					<td>
						<div class="searchFilter" style="margin:0">
							<input placeholder="<?=$lng['Filter']?>" id="searchFilterLogHistory" class="sFilter" type="text" />
							<button id="clearSearchboxLogHistory" type="button" class="clearFilter btn btn-default btn-sm"><i class="fa fa-times"></i></button>
						</div>
					</td>
				</tr>
			</table>

			<table class="basicTable" style="width: 100%!important;">
				<thead id="theadlogtable">
					<tr>
						<th><?=$lng['ID']?></th>
						<th>Employee Data</th>
						<th>Field</th>
						<th style="display: none;">Employee Data</th>
						<th><?=$lng['Date']?></th>
						<th><?=$lng['Changed by']?></th>
					</tr>
				</thead>
				<tbody>
						

				</tbody>
			</table>
		</div>				

		<div id="showTableEmpMiss" style="width: 50%;position: relative;left: 5px;">

			<table class="basicTable" style="width:100%; margin-bottom:8px">
				<thead >
					<tr>
						<th colspan="2">
							<i class="fa fa-arrow-circle-down"></i>&nbsp;Employee's Missing Information
						</th>
					</tr>
				</thead>
			</table>					
			<table style="width:50%; margin-bottom:8px">
				<tr>
					<td>
						<div class="searchFilter" style="margin:0">
							<input placeholder="<?=$lng['Filter']?>" id="searchFilterLogHistoryMissFields" class="sFilter" type="text" />
							<button id="clearSearchboxLogHistoryMissFields" type="button" class="clearFilter btn btn-default btn-sm"><i class="fa fa-times"></i></button>
						</div>
					</td>
				</tr>
			</table>

			<table class="basicTable" id="employeeMissFields" style="width: 100%!important;">
				<thead >
					<tr>
						<th>Emp <?=$lng['ID']?></th>
						<th>Employee Name</th>
						<th>Missing Fields</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>
			
		</div>
	</div>