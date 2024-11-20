<?
	if(session_id()==''){session_start();} 
	ob_start();

	$ref  = $_SESSION['rego']['ref'];
	$sql = "SELECT * FROM ".$cid."_users WHERE ref = '".$ref."'";
	if($res = $dbc->query($sql)){
		if($res->num_rows > 0){
			$com_users = $res->fetch_assoc();
			$tmp = unserialize($com_users['permissions']);

			if(!$tmp){$tmp = array();}
			$PermissionArray['rego'] = $tmp;
		}
	}

	if(!is_array($_SESSION['RGadmin']['access'])){
		$myaccess = $PermissionArray;
	}else{
		$myaccess = $_SESSION;
	}

	// echo '<pre>';
	// print_r($allActivities);
	// echo '</pre>'; exit;
?>

<style>
	.disabled {
		cursor:not-allowed;
	}
	.disabled i {
		color:#bbb;
	}
	table.basicTable.tac th {
		text-align:center;
		min-width:75px;
	}
	table.basicTable.tac td {
		text-align:center;
	}
	.SumoSelect{
		width: 99% !important;
		/*min-width: 200px !important;*/
		padding: 4px 0 0 10px !important;
		border:0 !important;
	}
	.SumoSelect > .CaptionCont {
		background:transparent !important;
		font-weight:600;
	}

	#AccessRightsForm .optWrapper.okCancelInMulti.selall.multiple {
	    min-width: 150px;
	}


	/* pre-next css*/

	input {
	  padding: 10px;
	  width: 100%;
	  border: 1px solid #aaaaaa;
	}

	/* Hide all steps by default: */
	.tab {
	  display: none;
	}
	/* pre-next css*/	
</style>

	<link rel="stylesheet" href="../assets/css/croppie_users.css?<?=time()?>" />

	<h2><i class="fa fa-user"></i>&nbsp; <?=$lng['Activity']?></h2>
	
	<div class="main">
		<div style="padding:0 0 0 20px" id="dump"></div>

		<table class="basicTable" style="width:100%; table-layout:auto">
			<thead>
				<tr style="line-height:100%; background:#09c; border-bottom:1px solid #09c">
					<th style="color:#fff" class="tal"><?=$lng['Module']?></th>
					<th style="color:#fff" class="tal"><?=$lng['Activities']?></th>
					<th style="color:#fff;width: 90%;" colspan="15"><?=$lng['Description']?></th>
				</tr>
			</thead>

			<tbody>
			<? 
			$count = 0;
			foreach($allActivities as $key => $val){
				 foreach($val as $val1){ 
				 	$count++; 
				 	if($count == 1){ $module = $key;}else{ $module = '';}
			?>
				<tr>
					<th><?=$module?></th>
					<th class="tal"><?=$val1->activity_en?></th>
					<th class="tal"><?=$val1->description?></th>
				</tr>

			<? } $count = 0; } ?>
			
			</tbody>
		</table>


		

		<!--<form id="ActivityForm">
			<button class="btn btn-primary btn-fr mb-2" type="button" onclick="FormSubmit();"> <i class="fa fa-save"></i> &nbsp; Update Activity</button>
			<table id="Activitytable" class="basicTable" style="width:100%; table-layout:auto">
				<thead>
					<tr style="line-height:100%; background:#09c; border-bottom:1px solid #09c">
						<th style="color:#fff" class="tal"><?=$lng['Module']?></th>
						<th style="color:#fff" class="tal"><?=$lng['Activities']?></th>
						<th style="color:#fff;width: 25%;" class="tal"><?=$lng['Approval Level']?></th>
						<th style="color:#fff;width: 65%;" colspan="15"><?=$lng['Assigned groups']?></th>
					</tr>
				</thead>

				<? if($myaccess['rego']['time']['access'] == 1){ ?>

					<tbody id="Timemain">
						<tr class="Trow" id="Tcnt1">
							<th><?=$lng['Time module']?></th>
							<th class="tal">
								<input type="text" name="activity[time][activity_name][]" >
							</th>
							<th>
								<select name="activity[time][activity_level][]" style="width:100%; min-width:auto; background:transparent;border: 1px solid #fff;padding: 0px !important;">
									<? foreach($activity_level as $k=>$v){ ?>
										<option value="<?=$k?>"><?=$v?></option>
									<? } ?>
								</select>
							</th>
							<th></th>
						</tr>
					</tbody>	
					<tbody id="TimemainBtn">	
						<tr>
							<th></th>
							<th class="tal">
								<button type="button" class="btn btn-success btn-sm" onclick="appendMoreRow('intime')"><i class="fa fa-plus"></i>&nbsp;&nbsp;<?=$lng['Add activity']?></button>
							</th>
							<th></th>
							<th></th>
						</tr>
					</tbody>
				<? } ?>

			

				
				<? if($myaccess['rego']['payroll']['access'] == 1){ ?>

					<tbody id="PayrollMain">
						<tr class="Prow" id="Pcnt1">
							<th><?=$lng['Payroll module']?></th>
							<th class="tal">
								<input type="text" name="activity[payroll][activity_name][]" >
							</th>
							<th>
								<select name="activity[payroll][activity_level][]" style="width:100%; min-width:auto; background:transparent;border: 1px solid #fff;padding: 0px !important;">
									<? foreach($activity_level as $k=>$v){ ?>
										<option value="<?=$k?>"><?=$v?></option>
									<? } ?>
								</select>
							</th>
							<th></th>
						</tr>
					</tbody>
					<tbody id="PayrollMainBtn">
						<tr>
							<th></th>
							<th class="tal">
								<button type="button" class="btn btn-success btn-sm" onclick="appendMoreRow('inpayroll')"><i class="fa fa-plus"></i>&nbsp;&nbsp;<?=$lng['Add activity']?></button>
							</th>
							<th></th>
							<th></th>
						</tr>
					</tbody>

				<?php } ?>

				
			</table>
		</form>
	</div>
<script type="text/javascript">

	function FormSubmit(RowAddIn){

		var frm = $('#ActivityForm');
		var data = frm.serialize();

		$.ajax({
				url: "ajax/compUserActivities.php",
				type: 'POST',
				data: data,
				success: function(result){



				}

			});
	}

	function appendMoreRow(RowAddIn){
		
		if(RowAddIn == 'intime'){

			var countTimetr = $('.main table#Activitytable tbody#Timemain tr.Trow').length;
			countTimetr++;

			$('.main table#Activitytable tbody#Timemain').append('<tr class="Trow" id="Tcnt'+countTimetr+'"><th></th><th class="tal"><input type="text" name="activity[time][activity_name][]" ></th><th><select name="activity[time][activity_level][]" style="width:100%; min-width:auto; background:transparent;border: 1px solid #fff;padding: 0px !important;"><? foreach($activity_level as $k=>$v){ ?><option value="<?=$k?>"><?=$v?></option><? } ?></select></th><th></th></tr>');

		}else if(RowAddIn == 'inpayroll'){

			var countPaytr = $('.main table#Activitytable tbody#PayrollMain tr.Prow').length;
			countPaytr++;

			$('.main table#Activitytable tbody#PayrollMain').append('<tr class="Prow" id="Pcnt'+countPaytr+'"><th></th><th class="tal"><input type="text" name="activity[payroll][activity_name][]" ></th><th><select name="activity[payroll][activity_level][]" style="width:100%; min-width:auto; background:transparent;border: 1px solid #fff;padding: 0px !important;"><? foreach($activity_level as $k=>$v){ ?><option value="<?=$k?>"><?=$v?></option><? } ?></select></th><th></th></tr>');
		}
	}
	

</script>-->
