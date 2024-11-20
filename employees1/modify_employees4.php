<?


	$getEmpName = getEmpName();
	$tempdata = '';
	$teamsUni = array();
	$teamsUnidep = array();
	$PositionUnidep = array();
	$empexistlist = array();
	$alltempdata = array();



	if(is_array($_SESSION['RGadmin']['access']) && !isset($_SESSION['rego']['id'])){ 
		$fetch_temp_data = $dbc->query("SELECT * FROM ".$cid."_temp_employee_data");
	}else{
		$fetch_temp_data = $dbc->query("SELECT * FROM ".$cid."_temp_employee_data WHERE user_id='".$_SESSION['rego']['id']."'");
	}

	if($fetch_temp_data->num_rows > 0){ 
		$tempdata = '';
		while ($row = $fetch_temp_data->fetch_assoc()) {
			$alltempdata[] = $row;
			$empexistlist[] = $row['emp_id'];
			$teamsUni[] = $row['team'];
			$teamsUnidep[] = $row['department'];
			$PositionUnidep[] = $row['position'];
		}
	}

	if(!empty($teamsUni)){
		$arrayunique = array_unique($teamsUni);
		$implodeArrs = implode(',', $arrayunique);
	}

	if(!empty($teamsUnidep)){
		$arrayunique = array_unique($teamsUnidep);
		$implodeArrsdep = implode(',', $arrayunique);
	}

	if(!empty($PositionUnidep)){
		$arrayunique = array_unique($PositionUnidep);
		$implodeArrsPos = implode(',', $arrayunique);
	}

	// ===============================  COMMON SECTION ARRAY =============================== //
	include('section/common_array.php'); 
	// ===============================  COMMON SECTION ARRAY =============================== //

	// ===============================  BENEFIT SECTION ARRAY =============================== //
	include('section/benefit.php'); 
	// ===============================  BENEFIT SECTION ARRAY =============================== //
	if(count($entities) > 1){ 

		$value1 = 1;
	 } 
	 else
	 {
		$value1 =0;

	 }

	 if($parameters[1]['apply_param'] == 1 && count($branches) > 1){ 

	 	$value2 = 1;
	 } 
	 else
	 {
	 	$value2 = 0;
	 }

	 if($parameters[2]['apply_param'] == 1 && count($divisions) > 1){ 
	 	$value3 = 1;
	 } 
	 else
	 {
	 	$value3 = 0;
	 }

	 if($parameters[3]['apply_param'] == 1 && count($departments) > 1){ 
	 	$value4 = 1;
	 } 
	 else
	 {
	 	$value4 =0;
	 }

	 if($parameters[4]['apply_param'] == 1 && count($teams) > 1){ 
	 	$value5 = 1;
	 }
	 else
	 {
	 	$value5 = 0;
	 } 
		
	if(count($positions) > 1){ 
		$value6 = 1;
	 } 
	 else
	 {
	 	$value6 = 0;
	 }


	 $combineTHvalue= $value1 + $value2 + $value3 + $value4 + $value5 + $value6 ;

	 if($combineTHvalue == '1')
	 {
	 	$left_value = '10';
	 	$right_value = '90';
	 }	 
	 else if($combineTHvalue == '2')
	 {
	 	$left_value = '20';
	 	$right_value = '80';
	 } 
	 else if($combineTHvalue == '3')
	 {
	 	$left_value = '30';
	 	$right_value = '70';
	 }	 
	 else if($combineTHvalue == '4')
	 {
	 	$left_value = '40';
	 	$right_value = '60';
	 }	 
	 else if($combineTHvalue == '5')
	 {
	 	$left_value = '50';
	 	$right_value = '50';
	 }	 
	 else if($combineTHvalue == '6')
	 {
	 	$left_value = '50';
	 	$right_value = '50';
	 }	 
	 else if($combineTHvalue == '0')
	 {
	 	$left_value = '0';
	 	$right_value = '100';
	 }



	 $classNamePhpValue = $_SESSION['rego']['classname'] ; // display none class
	 $heightPhpValue = $_SESSION['rego']['heightvalue'] ; // div height 
	 $scrolly = $_SESSION['rego']['scrolly'] ;	// scroll length
	 $pagelength = $_SESSION['rego']['pagelength'] ; // page length
	 $selectionSelectValue = $_SESSION['rego']['selectionSelectValue'] ; // selected section 
	 $updateAnythingValue = $_SESSION['rego']['updateAnythingValue'] ; // selected section 

//================= GET NOT SELECTED COLUMNS FROM SUMOSELECT DATABASE ======================//


	foreach ($eatt_cols2 as $key => $value) {

		$allSumoSelect[$key] =$key;
	}
	foreach ($allSumoSelect as $key => $value) {

		if (!in_array($value, $shCols2))
		{
			$notInSumoSelect[] = $value;
		}
	 }
//================ GET NOT SELECTED COLUMNS FROM SUMOSELECT DATABASE =====================//



	 foreach ($empexistlist as $key_01 => $value_01) {
	 	# code...
	 	$fetch_old_data = $dbc->query("SELECT * FROM ".$cid."_employees WHERE emp_id='".$value_01."'");

		if($fetch_old_data->num_rows > 0){ 
			while ($row = $fetch_old_data->fetch_assoc()) {
				$allOlddata[] = $row;
			}
		}
	 }

	 	 		

//================ GET OLD DATA OF ALL EMPLOYEES IN TEMPORARY DATABASE =====================//
//================ GET DATA FROM TEMP LOG HISTORY TO GET SUCCESS ERROR AND WARNING MESSAGE =====================//


	$sqlaLL1 = "SELECT * FROM ".$cid."_temp_log_history WHERE user ='REGO Admin' AND invalid_value = '1'";
	if($resaLL1 = $dbc->query($sqlaLL1))
	{
		while($rowaLL1 = $resaLL1->fetch_assoc())
		{
			$getAllTempLogErrors[]= $rowaLL1; // error array is isset that means there is an error
		}
	}	

	$sqlaLL2 = "SELECT * FROM ".$cid."_temp_log_history WHERE user ='REGO Admin' AND no_change = '0'";
	if($resaLL2 = $dbc->query($sqlaLL2))
	{
		while($rowaLL2 = $resaLL2->fetch_assoc())
		{
			$getAllTempLogWarning[]= $rowaLL2; // no change array if isset means there is a change
		}
	}

	$sqlaLL3 = "SELECT * FROM ".$cid."_temp_log_history WHERE user ='REGO Admin'";
	if($resaLL3 = $dbc->query($sqlaLL3))
	{
		while($rowaLL3 = $resaLL3->fetch_assoc())
		{
			$getAllTempLogData[]= $rowaLL3; // no change array if isset means there is a change
		}
	}

	$sqlaLL4 = "SELECT * FROM ".$cid."_temp_log_history WHERE missing_info ='1'";
	if($resaLL4 = $dbc->query($sqlaLL4))
	{
		while($rowaLL4 = $resaLL4->fetch_assoc())
		{
			$getAllTempLogDataMissing[]= $rowaLL4; // no change array if isset means there is a change
		}
	}


	// if all no change = '1' then its yellow 
	// in invalid value is 1 then its red 
	// if invalid value is not 1 and all no change are not equal to 1 then its green 

//================ GET DATA FROM TEMP LOG HISTORY TO GET SUCCESS ERROR AND WARNING MESSAGE =====================//


//=========== CHECK IF datatableEmppp  HAS VALUES OR NOT IF NOT THEN EMPTY THE COLUMN SELECTION FIELDS=========//

	 if(empty($alltempdata)){ 
	  	
	   $dbc->query("UPDATE ".$_SESSION['rego']['cid']."_sys_settings SET modify_empdata_section_cols = '', modify_empdata_section_showhide_cols = ''");
	   $_SESSION['rego']['selectionSelectValue'] ='Choose Section';

	 }

//=========== CHECK IF datatableEmppp  HAS VALUES OR NOT IF NOT THEN EMPTY THE COLUMN SELECTION FIELDS=========//



// ============== GET ALL GROUPS DATA FROM COMPANY DATABASE ===========================//

	$sqlgetgroups = "SELECT * FROM ".$cid."_groups ";
	if($resgetgroups = $dbc->query($sqlgetgroups))
	{
		while($rowgetgroups = $resgetgroups->fetch_assoc())
		{
			$getAllGroups[$rowgetgroups['id']]= $rowgetgroups['en']; 
		}
	}


// echo '<pre>';
// print_r($_SESSION);
// print_r($_SESSION['RGadmin']['id']);
// echo '</pre>';

// die();


?>
<style type="text/css">

.tabs {
  display: none;
}

#modalAddEmpcareer2 table.basicTable tbody td{
	padding: 0px !important;
}


.SumoSelect {
    padding: 4px !important; 
    border: none;
    width: 100% !important;
}

.SumoSelect > .optWrapper > .options li.opt {
	width: 100% !important;
}

.smallNav {
	background: #fff;
	height:31px; 
	padding:0; 
	/*border-bottom:1px solid #ddd;*/
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

.select2-container--default .select2-selection--single {
    border: 1px #ddd solid !important;
    padding: 3px;
    height: 32px;
    border-radius: 0px;
}
/*#datatables11_wrapper{
	border-left: 16px solid #ddd;
}*/
/*#datatables12_wrapper{
	border-left: 16px solid #ddd;

}*/
#hidediv2{
	/*border-left: 16px solid #ddd;*/
	margin-left: 0px;
	margin-bottom: 0px!important;

}

::-webkit-scrollbar {
    width: 15px;
    height: 15px;
}

#datatables11_paginate{
	visibility: hidden;
}
#datatables13_paginate{
	visibility: hidden;
}
#datatables15_paginate{
	visibility: hidden;
}
#datatables17_paginate{
	visibility: hidden;
}
#datatables19_paginate{
	visibility: hidden;
}
#datatables21_paginate{
	visibility: hidden;
}
#datatables23_paginate{
	visibility: hidden;
}


<?php if($classNamePhpValue == '') {?>

.dataTables_scrollBody::-webkit-scrollbar-thumb:horizontal {
	display: none;
}
.dataTables_scrollBody::-webkit-scrollbar:horizontal {
	display: none;
}


<?php } ?>


.dataTables_scrollBody {

	scrollbar-width: none; 
    overflow-y: scroll; 
}

.displayNone
{
	display: none!important;
}

.staticheight
{
	height: 100%;
}

</style>

<h2 style="padding-right:20px"><i class="fa fa-users fa-mr"></i> <?=$lng['Modify Employee Register']?>

		<span  id="headerRedSpanSave" class="float-right" style="display: none;font-style:italic; color:#b00;font-size: 14px;"><i class="fa fa-info-circle fa-mr"></i>To save the data in employee register please go to Verification Center</span>

		<span  id="headerRedSpan" class="float-right" style="display: none;font-style:italic; color:#b00;font-size: 14px;"><i class="fa fa-info-circle fa-mr"></i><?=$lng['A change in the selection will change the data in the other tabs']?></span>
	
</h2>


<div class="main">

	<form id="import" name="import" enctype="multipart/form-data" style="visibility:hidden; height:0; margin:0; padding:0">
			<input style="visibility:hidden" id="import_employees" type="file" name="file" />
	</form>


	<ul class="nav nav-tabs">
		<li class="nav-item"><a class="emp_groups nav-link active" href="#emp_group" data-toggle="tab"><?=$lng['Emp. Groups']?></a></li>
		<li class="nav-item scrollli"><a class="modify_data nav-link" href="#modify_data" data-toggle="tab"><?=$lng['Modify Data']?></a></li>		
		<li class="nav-item"><a class="overview nav-link" href="#overview" data-toggle="tab"><?=$lng['Batch Imports']?></a></li>		
		<li class="nav-item"><a class="verification_center nav-link" href="#verify_center" data-toggle="tab"><?=$lng['Verification Center']?></a></li>	


		<li class="hideclearselection flr Clearselection" style="position: absolute;right: 13px;display: none;">
			<button id="addEmployeeModel" type="button" class="btn btn-primary"><i class="fa fa-trash fa-mr"></i> Clear Selection</button>

		</li>
		<li class="hideempgroups" style="display: none;">
			<div style="position: absolute;right: 13px;">
				<button class="commonhidebutton btn btn-primary btn-fr exportExcel" type="button"><i class="fa fa-upload fa-mr"></i><?=$lng['Export']?></button>
				<button onclick="$('#import_employees').click()" class="commonhidebutton btn btn-primary btn-fr" type="button"><i class="fa fa-download fa-mr"></i><?=$lng['Import']?></button>

				<button class="btn btn-primary btn-fr" type="button"><i class="fa fa-arrow-right  fa-mr"></i><?=$lng['Continue selection']?></button>				
				<button class="btn btn-primary btn-fr switchLayout" type="button"><i class="fa fa-retweet fa-mr"></i><?=$lng['Switch Layout']?></button>
				<!-- <button id="redrawDatatable11" type="button"></button> -->
			</div>

		</li>		

	</ul>

	<div class="tab-content" style="height:100%; padding:0px">

		<div class="tab-pane active" id="emp_group">

			<div style="height:100%; border:0px solid red; position:relative;">
		
				<div style="position:absolute; left:0; top:0px; right:<?php echo $right_value.'%';?>; bottom:0; background:#fff;">
					
					<div id="leftTable" style="position:absolute; left:7px; top:5px; right:7px; bottom:15px; background:#fff; overflow-Y:auto; padding:0; overflow-X:scroll">
						
						<table id="usersAccess" class="basicTable" style="margin-top:51px; width:100%; table-layout:auto">
							<thead>
								<tr style="line-height:100%; background:#09c; color:#fff; border-bottom:1px solid #06a">
									
									<?if(count($entities) > 1){ ?>
										<th style="color:#fff"><?=$lng['Company']?></th>
									<? } ?>
									<? if($parameters[1]['apply_param'] == 1 && count($branches) > 1){ ?>
										<th style="color:#fff"><?=$parameters[1][$lang]?></th>
									<? } ?>
									<? if($parameters[2]['apply_param'] == 1 && count($divisions) > 1){ ?>
										<th style="color:#fff"><?=$parameters[2][$lang]?></th>
									<? } ?>
									<? if($parameters[3]['apply_param'] == 1 && count($departments) > 1){ ?>
										<th style="color:#fff"><?=$parameters[3][$lang]?></th>
									<? } ?>
									<? if($parameters[4]['apply_param'] == 1 && count($teams) > 1){ ?>
										<th style="color:#fff"><?=$parameters[4][$lang]?></th>
									<? } ?>
									<? if(count($positions) > 1){ ?>
										<th style="color:#fff"><?=$lng['Position']?></th>
									<? } ?>
									
								</tr>
							</thead>
							<tbody>
								<tr style="background:#f9f9f9">
									<input type="hidden" name="access">	
									<input type="hidden" name="access_selection">	
											
									<?if(count($entities) > 1){ ?>
										<td style="padding:0">
											<select name="entities" multiple="multiple" id="userEntities">
											<? /*foreach($entities as $k=>$v){ ?>
												<option value="<?=$k?>"><?=$v[$lang]?></option>
											<? }*/ ?>
											
											<? foreach($entities as $k=>$v){if(in_array($k, explode(',', $_SESSION['rego']['mn_entities']))){ ?>
											<option <? if(in_array($k, explode(',', $_SESSION['rego']['sel_entities']))){echo 'selected';} ?> value="<?=$k?>"><?=$v[$lang]?></option>
											<? } } ?>
											</select>
											
										</td>
									<? } ?>
									<? if($parameters[1]['apply_param'] == 1 && count($branches) > 1){ ?>
										<td style="padding:0">
											<select name="branches" multiple="multiple" id="userBranches">
											<? /*foreach($branches as $k=>$v){ ?>
												<option value="<?=$k?>"><?=$v[$lang]?></option>
											<? }*/ ?>
											<? foreach($branches as $k=>$v){if(in_array($k, explode(',', $_SESSION['rego']['mn_branches']))){ ?>
											<option <? if(in_array($k, explode(',', $_SESSION['rego']['sel_branches']))){echo 'selected';} ?> value="<?=$k?>"><?=$v[$lang]?></option>
											<? }} ?>
											</select>	
											
										</td>
									<? } ?>
									<? if($parameters[2]['apply_param'] == 1 && count($divisions) > 1){ ?>
										<td style="padding:0">
											<select name="divisions" multiple="multiple" id="userDivisions">
											<? /*foreach($divisions as $k=>$v){ ?>
												<option value="<?=$k?>"><?=$v[$lang]?></option>
											<? }*/ ?>
											<? foreach($divisions as $k=>$v){if(in_array($k, explode(',', $_SESSION['rego']['mn_divisions']))){ ?>
											<option <? if(in_array($k, explode(',', $_SESSION['rego']['sel_divisions']))){echo 'selected';} ?> value="<?=$k?>"><?=$v[$lang]?></option>
											<? }} ?>
											</select>	
											
										</td>
									<? } ?>
									<? if($parameters[3]['apply_param'] == 1 && count($departments) > 1){ ?>
										<td style="padding:0">
											<select name="departments" multiple="multiple" id="userDepartments">
											<? /*foreach($departments as $k=>$v){ ?>
												<option value="<?=$k?>"><?=$v[$lang]?></option>
											<? }*/ ?>
											<? foreach($departments as $k=>$v){if(in_array($k, explode(',',$_SESSION['rego']['mn_departments']))){ ?>
											<option <? if(in_array($k, explode(',',$_SESSION['rego']['sel_departments']))){echo 'selected';} ?> value="<?=$k?>"><?=$v[$lang]?></option>
											<? }} ?>
											</select>	
											
										</td>
									<? } ?>
									<? if($parameters[4]['apply_param'] == 1 && count($teams) > 1){ ?>
										<td style="padding:0">
											<select name="teams" multiple="multiple" id="userTeams">
											<? /*foreach($teams as $k=>$v){ ?>
												<option value="<?=$k?>"><?=$v['code']?></option>
											<? } */?>
											<? foreach($teams as $k=>$v){if(in_array($k, explode(',',$_SESSION['rego']['sel_teams']))){ ?>
											<option <? if(in_array($k, explode(',',$_SESSION['rego']['sel_teams']))){echo 'selected';} ?> value="<?=$k?>"><?=$v[$lang]?></option>
											<? }} ?>
											</select>	
										</td>
									<? } ?>

									<? if(count($positions) > 1){ ?>
										<td style="padding:0">
											<select name="position" multiple="multiple" id="userPosition">
												<!-- <option selected value=""><?=$lng['Select'].' '.$lng['Positions']?></option> -->
												<? foreach($positions as $k=>$v){
														echo '<option';
														//if($k == 1){echo ' selected';}
														echo ' value="'.$k.'">'.$v[$lang].'</option>';
													} ?>
											</select>	
										</td>
									<? } ?>
									
								</tr>
							</tbody>
							<tbody id="accessBody">

							</tbody>
						</table>

					</div>
				</div>
							
				<div style="position:absolute; left:<?php echo $left_value.'%';?>; top:0px; right:0; bottom:0; background: #f6f6f6; border-left:1px solid #ddd"> 

				<div class="smallNav">
					<ul style="display: flex !important;">
						<li >
							<div class="searchFilterd ml-3" style="margin:0 0 8px 0;margin-left: 0px!important;">
								<input placeholder="Search filter..." class="sFilter" id="searchFilterd" type="text" style="margin:0;background: #ffffff;" autocomplete="off">

							</div>
						</li>
						<li>
								<button style="border: 0;padding: 3px 11px !important;line-height: 26px !important;margin: 0;color: #ccc;border-radius: 0 !important;background: #eee;" id="clearSearchbox" type="button" class="clearFilter"><i class="fa fa-times"></i></button>

						</li>
						<li style="padding-right: 5px!important;padding-left: 5px!important;">
							<select class="select2 customSelectcss button" onchange="Addemployeeintemp(this)" name="emp_name" style="background: #ffffff;font-weight: 600;">
								<option selected disabled value=""><?=$lng['Add employee']?></option>
								<option value="all"><?=$lng['Add all employees']?></option>
								<? if(!empty($getEmpName)){ foreach($getEmpName as $k=>$v){
										if(!in_array($k, $empexistlist)){
											echo '<option value="'.$k.'" />'.$k.' - '.$v.'</option>';
									} } } ?>
							</select>
						</li>
						<li id="showHideClmss" style="padding-right: 5px!important;">
							<select class="ml-1 button" multiple="multiple" id="showHideclm" style="background: #ffffff;font-weight: 600;padding: 1px !important;">
								<?	foreach($eatt_cols as $k=>$v){
										echo '<option class="optCol" value="'.$k.'" ';
										if(in_array($k, $shCols)){echo 'selected ';}
										echo '>'.$v[1].'</option>';
								} ?>
							</select>
						</li>
						<li style="padding-right: 5px!important;">
							<select class="select2 button customSelectcss" id="empStatus" style="background: #ffffff;font-weight: 600;">
								<option selected value=""><?=$lng['All employees']?></option>
								<? foreach($emp_status as $k=>$v){
										echo '<option';
										if($k == 1){echo ' selected';}
										echo ' value="'.$k.'">'.$v.'</option>';
									} ?>
							</select>
						</li>						
					</ul>
				</div>
					<div id="rightTable" style="background:#fff; overflow-Y:auto; padding:10px 15px 20px 15px;">

						<table id="datatableEmppp" class="dataTable nowrap hoverable" style="width:100%;">
							<thead>
								<tr>
									<th class="fixwidth"><?=$lng['Emp. ID']?></th>
									<th class="fixwidth"><?=$lng['Employee name']?></th>
									
									<? if($parameters[4]['apply_param'] == 1){ ?>
										<!-- <th><?=$parameters[4][$lang]?></th> -->
									<? } ?>
								
									<th class="tal fixwidth"><?=$lng['Position']?></th>
									<th class="tal fixwidth"><?=$lng['Company']?></th>
									<th class="tal fixwidth"><?=$lng['Location']?></th>
									<th class="tal fixwidth"><?=$lng['Division']?></th>
									<th class="tal fixwidth"><?=$lng['Department']?></th>
									<th class="tal fixwidth"><?=$lng['Teams']?></th>
									
									<th class="fixwidth">
										<i data-toggle="tooltip" title="Remove" class="fa fa-trash fa-lg"></i>
									</th>
								</tr>
							</thead>
							<tbody id="relatedata">
									<? if(isset($alltempdata) && is_array($alltempdata)){ 
										foreach ($alltempdata as $key => $value) { ?>
										 	
											<tr data-id="<?=$value['emp_id']?>" id="<?=$value['emp_id']?>">
												<td class="fixwidth"><?=$value['emp_id']?></td>
												<td class="fixwidth"><?=$getEmpName[$value['emp_id']];?></td>
												<td class="fixwidth"><?=$positions[$value['position']][$lang]?></td>
												<td class="fixwidth"><?=$entities[$value['company']][$lang]?></td>
												<td class="fixwidth"><?=$branches[$value['location']][$lang]?></td>
												<td class="fixwidth"><?=$divisions[$value['division']][$lang]?></td>
												<td class="fixwidth"><?=$departments[$value['department']][$lang]?></td>
												<td class="fixwidth"><?=$teams[$value['team']][$lang]?></td>
												<td class="fixwidth">
													<a id="<?=$value['emp_id']?>" onclick="removeRowempss(this)"><i title="Remove" class="fa fa-trash fa-lg text-danger"></i></a>
												</td>
											</tr>

									<? } } ?>
							</tbody>
						</table>
						<div class="row">
							<div class="col-md-2" style="margin: -30px 0px 0px 0px;margin-left: auto;margin-right: auto;min-width: 38%;">
								<select id="pageLengthd" class="button btn-fl">
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
					
				</div>

			</div>

		</div> <!-------- Tab 1 end-------->

		<div class="tab-pane" id="modify_data" style="">

			<div style="height:100%; border:0px solid red; position:relative;">
		
				<div style="position:absolute; left:0; top:0px; right:84%; bottom:0; background:#fff;">

					<div id="leftTable" style="position:absolute; top:5px;bottom:15px; background:#fff;  padding:0; width: 100%;overflow-y: scroll;overflow-x: hidden;">			

					<table style="width: 100%;">
						<tr>
							<td style="padding: 11px;">

								<select id="section_select" class="customSelectcss getdatadivclass button" onchange="getDataDiv();" name="section_select" style="background: #ffffff;font-weight: 600;width: 100%;">
									<option>Choose Section</option>
									<option <?php if($selectionSelectValue == '1'){echo  "selected"; }?> value="1"><?=$lng['Personal Info']?></option>
									<option <?php if($selectionSelectValue == '2'){echo  "selected"; }?> value="2"><?=$lng['Contact']?></option>
									<option <?php if($selectionSelectValue == '3'){echo  "selected"; }?> value="3"><?=$lng['Work data']?></option>
									<option <?php if($selectionSelectValue == '4'){echo  "selected"; }?> value="4"><?=$lng['Time']?></option>
									<option <?php if($selectionSelectValue == '5'){echo  "selected"; }?> value="5"><?=$lng['Leave']?></option>
									<option <?php if($selectionSelectValue == '6'){echo  "selected"; }?> value="6"><?=$lng['Organization']?></option>
									<option <?php if($selectionSelectValue == '7'){echo  "selected"; }?> value="7"><?=$lng['Financial']?></option>
									<option <?php if($selectionSelectValue == '8'){echo  "selected"; }?> value="8"><?=$lng['Benefits']?></option>
									<option <?php if($selectionSelectValue == '9'){echo  "selected"; }?> value="9"><?=$lng['Payroll Models']?></option>
									<option <?php if($selectionSelectValue == '10'){echo  "selected"; }?> value="10"><?=$lng['Tax deductions']?></option>
								</select>


							</td>
						</tr>
					</table>

						<table style="width: 100%;">
							<tr>
								<td>
									<hr style ="border:8px solid #ddd;background-color: #ddd;width: 97%;" >
								</td>
							</tr>
						</table>



					<table style="width: 100%;" id="showHideClmss2">
						<tr>
							<td style="padding: 11px;">

								<select class="ml-1 button" multiple="multiple" id="showHideclm2" style="background: #ffffff;font-weight: 600;padding: 1px !important;">
									<?	foreach($eatt_cols2 as $k=>$v){
											echo '<option class="optCol" value="'.$k.'" ';
											if(in_array($k, $shCols2)){echo 'selected ';}
											echo '>'.$v[1].'</option>';
									} ?>
								</select>	
								<select class="ml-1 button" multiple="multiple" id="showHideclm3" style="background: #ffffff;font-weight: 600;padding: 1px !important;">
									<?	foreach($eatt_cols3 as $k=>$v){
											echo '<option class="optCol" value="'.$k.'" ';
											if(in_array($k, $shCols2)){echo 'selected ';}
											echo '>'.$v[1].'</option>';
									} ?>
								</select>								

								<select class="ml-1 button" multiple="multiple" id="showHideclm4" style="background: #ffffff;font-weight: 600;padding: 1px !important;">
									<?	foreach($eatt_cols4 as $k=>$v){
											echo '<option class="optCol" value="'.$k.'" ';
											if(in_array($k, $shCols2)){echo 'selected ';}
											echo '>'.$v[1].'</option>';
									} ?>
								</select>								
								<select class="ml-1 button" multiple="multiple" id="showHideclm5" style="background: #ffffff;font-weight: 600;padding: 1px !important;">
									<?	foreach($eatt_cols5 as $k=>$v){
											echo '<option class="optCol" value="'.$k.'" ';
											if(in_array($k, $shCols2)){echo 'selected ';}
											echo '>'.$v[1].'</option>';
									} ?>
								</select>								
								<select class="ml-1 button" multiple="multiple" id="showHideclm6" style="background: #ffffff;font-weight: 600;padding: 1px !important;">
									<?	foreach($eatt_cols6 as $k=>$v){
											echo '<option class="optCol" value="'.$k.'" ';
											if(in_array($k, $shCols2)){echo 'selected ';}
											echo '>'.$v[1].'</option>';
									} ?>
								</select>								
								<select class="ml-1 button" multiple="multiple" id="showHideclm7" style="background: #ffffff;font-weight: 600;padding: 1px !important;">
									<?	foreach($eatt_cols7 as $k=>$v){
											echo '<option class="optCol" value="'.$k.'" ';
											if(in_array($k, $shCols2)){echo 'selected ';}
											echo '>'.$v[1].'</option>';
									} ?>
								</select>
								<select class="ml-1 button" multiple="multiple" id="showHideclm9" style="background: #ffffff;font-weight: 600;padding: 1px !important;">
									<?	foreach($eatt_cols9 as $k=>$v){
											echo '<option class="optCol" value="'.$k.'" ';
											if(in_array($k, $shCols2)){echo 'selected ';}
											echo '>'.$v[1].'</option>';
									} ?>
								</select>
								<select class="ml-1 button" multiple="multiple" id="showHideclm8" style="background: #ffffff;font-weight: 600;padding: 1px !important;">
									<?	foreach($eatt_cols8 as $k=>$v){
											echo '<option class="optCol" value="'.$k.'" ';
											if(in_array($k, $shCols2)){echo 'selected ';}
											echo '>'.$v[1].'</option>';
									} ?>
								</select>
								
							</td>
						</tr>
					</table>

					<div class="smallNav" id= "personal_div_data" style="display: none;height: 100%;">
						<ul style="padding: 0;max-height: 100%">
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_scan_id_li">
								 <a class="modifydata_scan_id" style="border-right: none;" href="#"><span><?=$lng['Scan ID']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>						
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_title_li">
								 <a class="modifydata_title" style="border-right: none;" href="#"><span><?=$lng['Title']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>							
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_firstname_li">
								 <a class="modifydata_firstname" style="border-right: none;" href="#"><span><?=$lng['First name']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>							
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_lastname_li">
								 <a class="modifydata_lastname" style="border-right: none;" href="#"><span><?=$lng['Last name']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>		
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_english_name_li">
								 <a class="modifydata_english_name" style="border-right: none;" href="#"><span><?=$lng['Name in English']?>  <i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>				
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_birthdate_li">
								 <a class="modifydata_birthdate" style="border-right: none;" href="#"><span><?=$lng['Birthdate']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_nationality_li">
								 <a class="modifydata_nationality" style="border-right: none;" href="#"><span><?=$lng['Nationality']?> <i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd;" id="modifydata_gender_li">
								 <a class="modifydata_gender" style="border-right: none;" href="#"><span> <?=$lng['Gender']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd;" id="modifydata_maritial_li">
								 <a class="modifydata_maritial" style="border-right: none;" href="#"><span><?=$lng['Maritial status']?> <i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>	
							<li style="margin-top: 5px;display: block;background: #ddd;" id="modifydata_religion_li">
								 <a class="modifydata_religion" style="border-right: none;" href="#"><span><?=$lng['Religion']?> <i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>			
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_military_li">
								 <a class="modifydata_military" style="border-right: none;" href="#"><span><?=$lng['Military status']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>							
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_height_li">
								 <a class="modifydata_height" style="border-right: none;" href="#"><span><?=$lng['Height']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>							
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_weight_li">
								 <a class="modifydata_weight" style="border-right: none;" href="#"><span><?=$lng['Weight']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>							
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_blood_type_li">
								 <a class="modifydata_blood_type" style="border-right: none;" href="#"><span><?=$lng['Blood type']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>							
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_driving_license_li">
								 <a class="modifydata_driving_license" style="border-right: none;" href="#"><span><?=$lng['Driving license No.']?> <i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>							
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_license_date_li">
								 <a class="modifydata_license_date" style="border-right: none;" href="#"><span><?=$lng['License expiry date']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>							
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_id_card_li">
								 <a class="modifydata_id_card" style="border-right: none;" href="#"><span><?=$lng['ID card']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>							
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_id_card_expiry_date_li">
								 <a class="modifydata_id_card_expiry_date" style="border-right: none;" href="#"><span><?=$lng['ID card expiry date']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>							
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_tax_id_li">
								 <a class="modifydata_tax_id" style="border-right: none;" href="#"><span><?=$lng['Tax ID no.']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
						
						</ul>						
					</div>						

					<div class="smallNav" id= "country_div_data" style="display: none;">
						<ul style="">
							<li style="margin-top: 5px;display: block;background: #ddd;" id="modifydata_registered_address_li">
								 <a class="" style="border-right: none;" onclick="comomonContactModal('reg_address','text');"><span>Registered address<i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>			
							<li style="margin-top: 5px;display: block;background: #ddd;" id="modifydata_sub_district_li">
								 <a class="" style="border-right: none;" onclick="comomonContactModal('sub_district','text');"><span>Sub district<i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>							
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_district_li">
								 <a class="" style="border-right: none;" onclick="comomonContactModal('district','text');"><span>District<i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>							
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_province_li">
								 <a class="" style="border-right: none;" onclick="comomonContactModal('province','text');"><span>Province<i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_postal_code_li">
								 <a class="" style="border-right: none;" onclick="comomonContactModal('postnr','text');"><span>Postal code<i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>							
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_country_li">
								 <a class="" style="border-right: none;" onclick="comomonContactModal('country','text');"><span>Country<i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>							
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_latitude_li">
								 <a class="" style="border-right: none;" onclick="comomonContactModal('latitude','text');"><span>Latitude<i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>							
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_longitude_li">
								 <a class="" style="border-right: none;" onclick="comomonContactModal('longitude','text');" ><span>Longitude<i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>							
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_current_address_li">
								 <a class="" style="border-right: none;" onclick="comomonContactModal('cur_address','text');"><span>Current address<i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>							
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_personal_phone_li">
								 <a class="" style="border-right: none;" onclick="comomonContactModal('personal_phone','text');"><span>Personal phone<i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>							
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_work_phone_li">
								 <a class="" style="border-right: none;" onclick="comomonContactModal('work_phone','text');"><span>Work phone<i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>							
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_work_email_li">
								 <a class="" style="border-right: none;" onclick="comomonContactModal('work_email','text');"><span>Work email<i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>							
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_personal_email_li">
								 <a class="" style="border-right: none;" onclick="comomonContactModal('personal_email','text');"><span>Personal email<i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>							
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_username_options_li">
								 <a class="" style="border-right: none;" onclick="comomonContactModal('username_option','dropdown');" ><span>Username Options<i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>							
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_username_li">
								 <a class="" style="border-right: none;" onclick="comomonContactModal('username','text');"	><span>Username<i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							
						</ul>						
					</div>						

					<div class="smallNav" id= "work_div_data" style="display: none;">
						<ul style="">
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_joining_date_li">
								 <a class="" style="border-right: none;" onclick="comomonWorkDataModal('joining_date','date');"><span> <?=$lng['Joining date']?> <i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_probation_due_date_li">
								 <a class="" style="border-right: none;" onclick="comomonWorkDataModal('probation_date','date');"><span> <?=$lng['Probation due date']?> <i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>	
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_employee_type_li">
								 <a class="" style="border-right: none;" onclick="comomonWorkDataModal('emp_type','dropdown');"><span> <?=$lng['Employee type']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_accounting_code_li">
								 <a class="" style="border-right: none;" onclick="comomonWorkDataModal('account_code','dropdown');"><span> <?=$lng['Accounting code']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_groups_li">
								 <a class="" style="border-right: none;" onclick="comomonWorkDataModal('groups','dropdown');"><span> <?=$lng['Groups']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							
						</ul>						
					</div>						
					<div class="smallNav" id= "time_div_data" style="display: none;">
						<ul style="">
			
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_time_reg_li">
								 <a  style="border-right: none;" onclick="comomonTimeModal('time_reg','dropdown');"><span> Time registration<i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_time_selfie_li">
								 <a  style="border-right: none;" onclick="comomonTimeModal('selfie','dropdown');" ><span> Take selfie<i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>			
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_work_from_home_li">
								 <a  style="border-right: none;" onclick="comomonTimeModal('workFromHome','dropdown');"><span> Work From Home<i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							
						</ul>						
					</div>						
					<div class="smallNav" id= "leave_div_data" style="display: none;">
						<ul style="">
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_annual_leaves_li">
								 <a  style="border-right: none;" ><span onclick="comomonLeaveModal('annual_leave');"> Annual leave (days)<i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
						</ul>						
					</div>						
					<div class="smallNav" id= "organization_div_data" style="display: none;">
						<ul style="">
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_OrgModalsel_li">
								 <a  style="border-right: none;" ><span > Edit Organization<i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
						</ul>						
					</div>		
					<div class="smallNav" id= "financial_div_data" style="display: none;">
						<ul style="">
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifycontract_li">
								 <a  style="border-right: none;" ><span onclick='commonfinancialModal("contract_type","dropdown")' > <?=$lng['Contract type']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifycalc_base_li">
								 <a  style="border-right: none;" ><span onclick='commonfinancialModal("calc_base","dropdown")'> <?=$lng['Calculation base']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifybank_code_li">
								 <a  style="border-right: none;" ><span onclick='commonfinancialModal("bank_code","text")'> <?=$lng['Bank code']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifybank_name_li">
								 <a  style="border-right: none;" ><span onclick='commonfinancialModal("bank_name","dropdown")'> <?=$lng['Bank name']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifybank_branch_li">
								 <a  style="border-right: none;" ><span onclick='commonfinancialModal("bank_branch","text")'> <?=$lng['Bank branch']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifybank_account_li">
								 <a  style="border-right: none;" ><span onclick='commonfinancialModal("bank_account","text")'> <?=$lng['Bank account no.']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifyaccount_name_li">
								 <a  style="border-right: none;" ><span onclick='commonfinancialModal("bank_account_name","text")'> <?=$lng['Bank account name']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifypay_type_li">
								 <a  style="border-right: none;" ><span onclick='commonfinancialModal("pay_type","dropdown")'> <?=$lng['Payment type']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifyaccount_code_li">
								 <a  style="border-right: none;" ><span onclick='commonfinancialModal("account_code","dropdown")'> <?=$lng['Accounting code']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifygroups_li">
								 <a  style="border-right: none;" ><span onclick='commonfinancialModal("groups","dropdown")'> <?=$lng['Groups']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifytax_calc_method_li">
								 <a  style="border-right: none;" ><span onclick='commonfinancialModal("calc_method","dropdown")'> <?=$lng['Tax calculation method']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifycalc_tax_li">
								 <a  style="border-right: none;" ><span onclick='commonfinancialModal("calc_tax","dropdown")'> <?='Calculate tax'?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifytax_residency_li">
								 <a  style="border-right: none;" ><span onclick='commonfinancialModal("tax_residency_status","dropdown")'> <?=$lng['Tax Residency Status']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifyincome_section_li">
								 <a  style="border-right: none;" ><span onclick='commonfinancialModal("income_section","dropdown")'> Income Section<i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifymodify_tax_li">
								 <a  style="border-right: none;" ><span onclick='commonfinancialModal("modify_tax","text")'> <?=$lng['Modify Tax amount']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifycalc_sso_li">
								 <a  style="border-right: none;" ><span onclick='commonfinancialModal("calc_sso","dropdown")'> <?=$lng['Calculate SSO']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifysso_by_li">
								 <a  style="border-right: none;" ><span onclick='commonfinancialModal("sso_by","dropdown")'> <?=$lng['SSO paid by']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifygov_house_bank_li">
								 <a  style="border-right: none;" ><span onclick='commonfinancialModal("gov_house_banking","text")'> <?=$lng['Government house banking']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifysavings_li">
								 <a  style="border-right: none;" ><span onclick='commonfinancialModal("savings","text")'> <?=$lng['Savings']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifylegal_exec_dedc_li">
								 <a  style="border-right: none;" ><span onclick='commonfinancialModal("legal_execution","text")'> <?=$lng['Legal execution deduction']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifykor_yor_sor_li">
								 <a  style="border-right: none;" ><span onclick='commonfinancialModal("kor_yor_sor","text")'><?=$lng['Kor.Yor.Sor (Student loan)']?><i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							
							
						</ul>						
					</div>					
					<div class="smallNav" id= "benefits_div_data" style="display: none;">
						<ul style="">
		<!-- 					<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_Star_Date_li">
								 <a  style="border-right: none;" ><span onclick="comomonBenefitModal('start_date', 'date');"> Start Date<i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>
							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_basic_salary_li">
								 <a  style="border-right: none;" ><span onclick="comomonBenefitModal('base_salary','text');"> Basic salary<i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>	 -->	

							<li style="margin-top: 5px;display: block;background: #ddd; " id="modifydata_editBenfits_li">
								 <a  style="border-right: none;" ><span > Edit Benefits<i style="margin-left: 10px;" class="fa fa-edit"></i></span></a>
							</li>		
						</ul>						
					</div>	

					</div>
				</div>
							
				<div class="scrolldiv" style="position:absolute; left:16%; top:0px; right:0; bottom:0; background: #f6f6f6;"> 
				<!-- <div class="scrolldiv" style="position:absolute; left:16%; top:0px; right:0; bottom:0; background: #f6f6f6; border-left:16px solid #ddd;">  -->
					<div class="dataTables_wrapper scrollclass"  style="background:#fff; padding:10px 15px 20px 15px;height: 100%; padding-left: 0px!important;">
						<table style="margin-left: 19px;margin-bottom: 3px;">
							<thead >
								<tr>
									<th colspan="2">
										<i class="fa fa-arrow-circle-down"></i>&nbsp; New Data
									</th>
								</tr>
							</thead>
						</table>
						<div style= "display: none;" id="div_personal">
							<table id="datatables11" class="dataTable hoverable selectable nowrap" >

								<thead>
									<tr>
										<th class="par30"><?=$lng['Emp. ID']?></th>
										<th class="tal par30"><?=$lng['Employee name']?></th>
										<th class="tal "><?=$lng['Scan ID']?></th>
										<th class="tal "><?=$lng['Title']?></th>
										<th class="tal "><?=$lng['First name']?></th>
										<th class="tal "><?=$lng['Last name']?></th>
										<th class="tal "><?=$lng['Name in English']?></th>
										<th class="tal "><?=$lng['Birthdate']?></th>
										<th class="tal "><?=$lng['Nationality']?></th>
										<th class="tal "><?=$lng['Gender']?></th>
										<th class="tal "><?=$lng['Maritial status']?></th>
										<th class="tal "><?=$lng['Religion']?></th>
										<th class="tal "><?=$lng['Military status']?></th>
										<th class="tal "><?=$lng['Height']?></th>
										<th class="tal "><?=$lng['Weight']?></th>
										<th class="tal "><?=$lng['Blood type']?></th>
										<th class="tal "><?=$lng['Driving license No.']?></th>
										<th class="tal "><?=$lng['License expiry date']?></th>
										<th class="tal "><?=$lng['ID card']?></th>
										<th class="tal "><?=$lng['ID card expiry date']?></th>
										<th class="tal "><?=$lng['Tax ID no.']?></th>
									</tr>
								</thead>
								<tbody id="seldata1">

									<? if(isset($alltempdata) && is_array($alltempdata)){ 
										foreach ($alltempdata as $key => $value) { ?>
										 	
											<tr data-id="<?=$value['emp_id']?>">
												<td><span id="rowIdDatatableSpan" style="display: none;"><?=$value['id']?></span><?=$value['emp_id']?></td>
												<td><?=$value['en_name'];?></td>
												<td><?=$value['sid']?></td>
												<td><?=$title[$value['title']];?></td>
												<td><?=$value['firstname']?></td>
												<td><?=$value['lastname']?></td>
												<td><?=$value['en_name']?></td>
												<td><?=$value['birthdate']?></td>
												<td><?=$value['nationality']?></td>
												<td><?=$gender[$value['gender']];?></td>
												<td><?=$maritial[$value['maritial']];?></td>
												<td><?=$religion[$value['religion']];?></td>
												<td><?=$military_status[$value['military_status']];?></td>
												<td><?=$value['height']?></td>
												<td><?=$value['weight']?></td>
												<td><?=$value['bloodtype']?></td>
												<td><?=$value['drvlicense_nr']?></td>
												<td><?=$value['drvlicense_exp']?></td>
												<td><?=$value['idcard_nr']?></td>
												<td><?=$value['idcard_exp']?></td>
												<td><?=$value['tax_id']?></td>
			
												
											</tr>

									<? } } ?>

								</tbody>
							</table>
						</div>

						<div style= "display: none;" id="div_contacts">
							<table  id="datatables13" class="dataTable hoverable selectable nowrap" >

								<thead>
									<tr>
										<th class="par30"><?=$lng['Emp. ID']?></th>
										<th class="tal par30"><?=$lng['Employee name']?></th>
										<th class="tal "><?=$lng['Registered address']?></th>
										<th class="tal "><?=$lng['Sub district']?></th>
										<th class="tal "><?=$lng['District']?></th>
										<th class="tal "><?=$lng['Province']?></th>
										<th class="tal "><?=$lng['Postal code']?></th>
										<th class="tal "><?=$lng['Country']?></th>
										<th class="tal "><?=$lng['Latitude']?></th>
										<th class="tal "><?=$lng['Longitude']?></th>
										<th class="tal "><?=$lng['Current address']?></th>
										<th class="tal "><?=$lng['Personal phone']?></th>
										<th class="tal "><?=$lng['Work phone']?></th>
										<th class="tal "><?=$lng['Personal email']?></th>
										<th class="tal "><?=$lng['Work email']?></th>
										<th class="tal "><?=$lng['Username Options']?></th>
										<th class="tal "><?=$lng['Username']?></th>
									</tr>
								</thead>
								<tbody id="seldata2">

									<? if(isset($alltempdata) && is_array($alltempdata)){ 
										foreach ($alltempdata as $key => $value) { ?>
										 	
											<tr data-id="<?=$value['emp_id']?>">
												<td><span id="rowIdDatatableSpan" style="display: none;"><?=$value['id']?></span><?=$value['emp_id']?></td>
												<td><?=$value['en_name'];?></td>
												<td><?=$value['reg_address'];?></td>
												<td><?=$value['sub_district'];?></td>
												<td><?=$value['district'];?></td>
												<td><?=$value['province'];?></td>
												<td><?=$value['postnr'];?></td>
												<td><?=$value['country'];?></td>
												<td><?=$value['latitude'];?></td>
												<td><?=$value['longitude'];?></td>
												<td><?=$value['cur_address'];?></td>
												<td><?=$value['personal_phone'];?></td>
												<td><?=$value['work_phone'];?></td>
												<td><?=$value['personal_email'];?></td>
												<td><?=$value['work_email'];?></td>
												<td><?=$username_option[$value['username_option']]?></td>
												<td><?=$value['username'];?></td>
											</tr>

									<? } } ?>

								</tbody>
							</table>
						</div>						

						<div style= "display: none;" id="div_work_data">
							<table  id="datatables15" class="dataTable hoverable selectable nowrap" >

								<thead>
									<tr>
										<th class="par30"><?=$lng['Emp. ID']?></th>
										<th class="tal par30"><?=$lng['Employee name']?></th>
										<th class="tal "><?=$lng['Joining date']?></th>
										<th class="tal "><?=$lng['Probation due date']?></th>
										<th class="tal "><?=$lng['Employee type']?></th>
										<th class="tal "><?=$lng['Accounting code']?></th>
										<th class="tal "><?=$lng['Groups']?></th>
									</tr>
								</thead>
								<tbody id="seldata2">

									<? if(isset($alltempdata) && is_array($alltempdata)){ 
										foreach ($alltempdata as $key => $value) { ?>
										 	
											<tr data-id="<?=$value['emp_id']?>">
												<td><span id="rowIdDatatableSpan" style="display: none;"><?=$value['id']?></span><?=$value['emp_id']?></td>
												<td><?=$value['en_name'];?></td>
												<td><?=$value['joining_date'];?></td>
												<td><?=$value['probation_date'];?></td>
												<td><?=$emp_type[$value['emp_type']];?></td>
												<td><?php

												if($value['account_code'] == '1')
												{
													echo $lng['Indirect'];
												}
												else if($value['account_code'] == '0')
												{
													echo $lng['Direct'];
												}


												?></td>
												<td><?=$getAllGroups[$value['groups']];?></td>
											</tr>

									<? } } ?>

								</tbody>
							</table>
						</div>						

						<div style= "display: none;" id="div_time">
							<table  id="datatables17" class="dataTable hoverable selectable nowrap" >

								<thead>
									<tr>
										<th class="par30"><?=$lng['Emp. ID']?></th>
										<th class="tal par30"><?=$lng['Employee name']?></th>
										<th class="tal "><?=$lng['Time registration']?></th>
										<th class="tal "><?=$lng['Take selfie']?></th>
										<th class="tal "><?=$lng['Work From Home']?></th>
			
									</tr>
								</thead>
								<tbody id="seldata2">

									<? if(isset($alltempdata) && is_array($alltempdata)){ 
										foreach ($alltempdata as $key => $value) { ?>
										 	
											<tr data-id="<?=$value['emp_id']?>">
												<td><span id="rowIdDatatableSpan" style="display: none;"><?=$value['id']?></span><?=$value['emp_id']?></td>
												<td><?=$value['en_name'];?></td>
												<td>
													<?php 
														if($value['time_reg'] == '0')
														{
															echo  $lng['No'] ;
														}
														else if($value['time_reg'] == '1')
														{
															echo  $lng['Yes'] ;
														}
													?>
												</td>												
												<td>
													<?php 
														if($value['selfie'] == '0')
														{
															echo  $lng['No'] ;
														}
														else if($value['selfie'] == '1')
														{
															echo  $lng['Yes'] ;
														}
													?>
												</td>												
												<td>
													<?php 
														if($value['workFromHome'] == '0')
														{
															echo  $lng['No'] ;
														}
														else if($value['workFromHome'] == '1')
														{
															echo  $lng['Yes'] ;
														}
													?>
												</td>
		
							
											</tr>

									<? } } ?>

								</tbody>
							</table>
						</div>						

						<div style= "display: none;" id="div_leave">
							<table  id="datatables19" class="dataTable hoverable selectable nowrap" >

								<thead>
									<tr>
										<th class="par30"><?=$lng['Emp. ID']?></th>
										<th class="tal par30"><?=$lng['Employee name']?></th>
										<th class="tal "><?=$lng['Annual leave (days)']?></th>
									</tr>
								</thead>
								<tbody id="seldata2">

									<? if(isset($alltempdata) && is_array($alltempdata)){ 
										foreach ($alltempdata as $key => $value) { ?>
										 	
											<tr data-id="<?=$value['emp_id']?>">
												<td><span id="rowIdDatatableSpan" style="display: none;"><?=$value['id']?></span><?=$value['emp_id']?></td>
												<td><?=$value['en_name'];?></td>
												<td><?=$value['annual_leave'];?></td>
											</tr>

									<? } } ?>

								</tbody>
							</table>
						</div>					

						<div style= "display: none;" id="div_organization">
							<table  id="datatables21" class="dataTable hoverable selectable nowrap" >

								<thead>
									<tr>
										<th class="par30"><?=$lng['Emp. ID']?></th>
										<th class="tal par30"><?=$lng['Employee name']?></th>
										<th class="tal "><?=$lng['Company']?></th>
										<th class="tal "><?=$lng['Location']?></th>
										<th class="tal "><?=$lng['Division']?></th>
										<th class="tal "><?=$lng['Department']?></th>
										<th class="tal "><?=$lng['Teams']?></th>
									</tr>
								</thead>
								<tbody id="seldata2">

									<? if(isset($alltempdata) && is_array($alltempdata)){ 
										foreach ($alltempdata as $key => $value) { ?>
										 	
											<tr data-id="<?=$value['emp_id']?>">
												<td><span id="rowIdDatatableSpan" style="display: none;"><?=$value['id']?></span><?=$value['emp_id']?></td>
												<td><?=$value['en_name'];?></td>
												<td><?=$company_name_data[$value['company']][$_SESSION['rego']['lang']];?></td>
												<td><?=$branch_name_data[$value['location']][$_SESSION['rego']['lang']];?></td>
												<td><?=$division_name_data[$value['division']][$_SESSION['rego']['lang']];?></td>
												<td><?=$department_name_data[$value['department']][$_SESSION['rego']['lang']];?></td>
												<td><?=$teams_name_data[$value['team']][$_SESSION['rego']['lang']];?></td>
											</tr>

									<? } } ?>

								</tbody>
							</table>
						</div>
						<div style= "display: none;" id="div_financial">
							<table  id="datatables25" class="dataTable hoverable selectable nowrap" >

								<thead>
									<tr>
										<th class="par30"><?=$lng['Emp. ID']?></th>
										<th class="tal par30"><?=$lng['Employee name']?></th>
										<th class="par30"><?=$lng['Contract type']?></th>
										<th class="tal par30"><?=$lng['Calculation base']?></th>
										<th class="tal "><?=$lng['Bank code']?></th>
										<th class="tal "><?=$lng['Bank name']?></th>
										<th class="tal "><?=$lng['Bank branch']?></th>
										<th class="tal "><?=$lng['Bank account no.']?></th>
										<th class="tal "><?=$lng['Bank account name']?></th>
										<th class='tal'><?=$lng['Payment type']?></th>
										<th class='tal'><?=$lng['Accounting code']?></th>
										<th class='tal'><?=$lng['Groups']?></th>
										<th class='tal'><?=$lng['Tax calculation method']?></th>
										<th class='tal'><?='Calculate tax'?></th>
										<th class='tal'><?=$lng['Tax Residency Status']?></th>
										<th class='tal'><?='Income Section'?></th>
										<th class='tal'><?=$lng['Modify Tax amount']?></th>
										<th class='tal'><?=$lng['Calculate SSO']?></th>
										<th class='tal'><?=$lng['SSO paid by']?></th>
										<th class='tal'><?=$lng['Government house banking']?></th>
										<th class='tal'><?=$lng['Savings']?></th>
										<th class='tal'><?=$lng['Legal execution deduction']?></th>
										<th class='tal'><?=$lng['Kor.Yor.Sor (Student loan)']?></th>
										
									</tr>
								</thead>
								<tbody id="seldata2">

								<? if(isset($alltempdata) && is_array($alltempdata)){ 
										foreach ($alltempdata as $key => $value) { ?>
										 	
											<tr data-id="<?=$value['emp_id']?>">
												<td><span id="rowIdDatatableSpan" style="display: none;"><?=$value['id']?></span><?=$value['emp_id']?></td>
												<td><?=$value['en_name'];?></td>
												<td><?=$contract_type[$value['contract_type']];?></td>
												<td><?=$calc_base[$value['calc_base']]?></th>
            									<td><?=$value['bank_code']?></th>
            									<td><?=$banksarray[$value['bank_name']]?></th>
            									<td><?=$value['bank_branch']?></th>
            									<td><?=$value['bank_account']?></th>
            									<td><?=$value['bank_account_name']?></th>
            									<td><?=$pay_type[$value['pay_type']]?></th>
            									<td><?=$accountCodeArray[$value['account_code']]?></th>
            									<td><?=$getAllGroups[$value['groups']]?></th>
            									<td><?=$calcmethod[$value['calc_method']]?></th>
            									<td><?=$calctax[$value['calc_tax']]?></th>
            									<td><?=$tax_residency_status[$value['tax_residency_status']]?></th>
            									<td><?=$income_section[$value['income_section']]?></th>
            									<td><?=$value['modify_tax']?></th>
            									<td><?=$noyes01[$value['calc_sso']]?></th>
            									<td><?=$sso_paidby[$value['sso_by']]?></th>
            									<td><?=$value['gov_house_banking']?></th>
            									<td><?=$value['savings']?></th>
            									<td><?=$value['legal_execution']?></th>
            									<td><?=$value['kor_yor_sor']?></th>
												
											</tr>

									<? } } ?>

								</tbody>
							</table>
						</div>							
						<div style= "display: none;" id="div_benfits">
							<table  id="datatables23" class="dataTable hoverable selectable nowrap" >

								<thead>
									<tr>
										<th class="par30"><?=$lng['Emp. ID']?></th>
										<th class="tal par30"><?=$lng['Employee name']?></th>
										<th class="tal "><?=$lng['Start Date']?></th>
										<th class="tal "><?=$lng['End date']?></th>
										<th class="tal "><?=$lng['Position']?></th>
										<th class="tal "><?=$lng['Basic salary']?></th>
										<th class="tal "><?=$lng['Housing']?></th>
										<th class="tal "><?=$lng['Transport']?></th>
										<th class="tal "><?=$lng['Position']?></th>
										<th class="tal "><?=$lng['Phone']?></th>
										<th class="tal "><?=$lng['Pay back loan']?></th>
										<th class="tal "><?=$lng['Head of Location']?></th>
										<th class="tal "><?=$lng['Head of division']?></th>
										<th class="tal "><?=$lng['Head of department']?></th>
										<th class="tal "><?=$lng['Team supervisor']?></th>
										<th class="tal "><?=$lng['Other benefits']?></th>
										<th class="tal "><?=$lng['Remarks']?></th>
									</tr>
								</thead>
								<tbody id="seldata2">

									<? if(isset($alltempdata) && is_array($alltempdata)){ 
										foreach ($alltempdata as $key => $value) { ?>
										 	
											<tr data-id="<?=$value['emp_id']?>">
												<td><span id="rowIdDatatableSpan" style="display: none;"><?=$value['id']?></span><?=$value['emp_id']?></td>
												<td><?=$value['en_name'];?></td>
												<td><?=$value['start_date'];?></td>
												<td></td>
												<td></td>
												<td><?=$value['base_salary'];?></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
											</tr>

									<? } } ?>

								</tbody>
							</table>
						</div>


						<div class="row " id="hidediv2" style="background-color: #fff;margin-bottom: 11px;padding-bottom: 12px;">

							<table class="table-responsive" id="scrolltable">
								<tr>
									<td style="visibility: hidden;">
										 aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
									</td>
								</tr>
							</table>
							

						</div>						

						<table id= "oldatatable">
							<thead >
								<tr>
									<th colspan="2">
										<i class="fa fa-arrow-circle-down"></i>&nbsp; Old Data
									</th>
								</tr>
							</thead>
						</table>

						<div style="display: none;" id="personal_old_data"> 
							<table id="datatables12" class="dataTable hoverable selectable nowrap " >
								<thead>
									<tr>
										<th class="par30"><?=$lng['Emp. ID']?></th>
										<th class="tal par30"><?=$lng['Employee name']?></th>
										<th class="tal "><?=$lng['Scan ID']?></th>
										<th class="tal "><?=$lng['Title']?></th>
										<th class="tal "><?=$lng['First name']?></th>
										<th class="tal "><?=$lng['Last name']?></th>
										<th class="tal "><?=$lng['Name in English']?></th>
										<th class="tal "><?=$lng['Birthdate']?></th>
										<th class="tal "><?=$lng['Nationality']?></th>
										<th class="tal "><?=$lng['Gender']?></th>
										<th class="tal "><?=$lng['Maritial status']?></th>
										<th class="tal "><?=$lng['Religion']?></th>
										<th class="tal "><?=$lng['Military status']?></th>
										<th class="tal "><?=$lng['Height']?></th>
										<th class="tal "><?=$lng['Weight']?></th>
										<th class="tal "><?=$lng['Blood type']?></th>
										<th class="tal "><?=$lng['Driving license No.']?></th>
										<th class="tal "><?=$lng['License expiry date']?></th>
										<th class="tal "><?=$lng['ID card']?></th>
										<th class="tal "><?=$lng['ID card expiry date']?></th>
										<th class="tal "><?=$lng['Tax ID no.']?></th>

									</tr>
								</thead>
								<tbody id="seldata3">

									<? if(isset($allOlddata) && is_array($allOlddata)){ 
										foreach ($allOlddata as $key => $value) { ?>
										 	
											<tr data-id="<?=$value['emp_id']?>">
												<td><?=$value['emp_id']?></td>
												<td><?=$getEmpName[$value['emp_id']];?></td>
												<td><?=$value['sid']?></td>
												<td><?=$title[$value['title']];?></td>
												<td><?=$value['firstname']?></td>
												<td><?=$value['lastname']?></td>
												<td><?=$value['en_name']?></td>
												<td><?=$value['birthdate']?></td>
												<td><?=$value['nationality']?></td>
												<td><?=$gender[$value['gender']];?></td>
												<td><?=$maritial[$value['maritial']];?></td>
												<td><?=$religion[$value['religion']];?></td>
												<td><?=$military_status[$value['military_status']];?></td>
												<td><?=$value['height']?></td>
												<td><?=$value['weight']?></td>
												<td><?=$value['bloodtype']?></td>
												<td><?=$value['drvlicense_nr']?></td>
												<td><?=$value['drvlicense_exp']?></td>
												<td><?=$value['idcard_nr']?></td>
												<td><?=$value['idcard_exp']?></td>
												<td><?=$value['tax_id']?></td>
											</tr>

									<? } } ?>

								</tbody>
							</table>
						</div>	

						<div style="display: none;" id="contacts_old_data"> 
							<table id="datatables14" class="dataTable hoverable selectable nowrap " >
								<thead>
									<tr>
										<th class="par30"><?=$lng['Emp. ID']?></th>
										<th class="tal par30"><?=$lng['Employee name']?></th>
										<th class="tal "><?=$lng['Registered address']?></th>
										<th class="tal "><?=$lng['Sub district']?></th>
										<th class="tal "><?=$lng['District']?></th>
										<th class="tal "><?=$lng['Province']?></th>
										<th class="tal "><?=$lng['Postal code']?></th>
										<th class="tal "><?=$lng['Country']?></th>
										<th class="tal "><?=$lng['Latitude']?></th>
										<th class="tal "><?=$lng['Longitude']?></th>
										<th class="tal "><?=$lng['Current address']?></th>
										<th class="tal "><?=$lng['Personal phone']?></th>
										<th class="tal "><?=$lng['Work phone']?></th>
										<th class="tal "><?=$lng['Personal email']?></th>
										<th class="tal "><?=$lng['Work email']?></th>
										<th class="tal "><?=$lng['Username Options']?></th>
										<th class="tal "><?=$lng['Username']?></th>
									</tr>
								</thead>
								<tbody id="seldata4">

									<? if(isset($allOlddata) && is_array($allOlddata)){ 
										foreach ($allOlddata as $key => $value) { ?>
										 	
											<tr data-id="<?=$value['emp_id']?>">
												<td><?=$value['emp_id']?></td>
												<td><?=$getEmpName[$value['emp_id']];?></td>
												<td><?=$value['reg_address']?></td>
												<td><?=$value['sub_district']?></td>
												<td><?=$value['district']?></td>
												<td><?=$value['province']?></td>
												<td><?=$value['postnr']?></td>
												<td><?=$value['country']?></td>
												<td><?=$value['latitude']?></td>
												<td><?=$value['longitude']?></td>
												<td><?=$value['cur_address']?></td>
												<td><?=$value['personal_phone']?></td>
												<td><?=$value['work_phone']?></td>
												<td><?=$value['personal_email']?></td>
												<td><?=$value['work_email']?></td>
												<td><?=$username_option[$value['username_option']]?></td>
												<td><?=$value['username']?></td>
											</tr>

									<? } } ?>

								</tbody>
							</table>
						</div>						
						<div style="display: none;" id="work_data_old_data"> 
							<table id="datatables16" class="dataTable hoverable selectable nowrap " >
								<thead>
									<tr>
										<th class="par30"><?=$lng['Emp. ID']?></th>
										<th class="tal par30"><?=$lng['Employee name']?></th>
										<th class="tal "><?=$lng['Joining date']?></th>
										<th class="tal "><?=$lng['Probation due date']?></th>
										<th class="tal "><?=$lng['Employee type']?></th>
										<th class="tal "><?=$lng['Accounting code']?></th>
										<th class="tal "><?=$lng['Groups']?></th>
									</tr>
								</thead>
								<tbody id="seldata4">

									<? if(isset($allOlddata) && is_array($allOlddata)){ 
										foreach ($allOlddata as $key => $value) { ?>
										 	
											<tr data-id="<?=$value['emp_id']?>">
												<td><?=$value['emp_id']?></td>
												<td><?=$getEmpName[$value['emp_id']];?></td>
												<td><?=$value['joining_date'];?></td>
												<td><?=$value['probation_date'];?></td>
												<td><?=$emp_type[$value['emp_type']];?></td>
												<td><?php

												if($value['account_code'] == '1')
												{
													echo $lng['Indirect'];
												}
												else if($value['account_code'] == '0')
												{
													echo $lng['Direct'];
												}?>
												<td><?=$getAllGroups[$value['groups']];?></td>
											</tr>

									<? } } ?>

								</tbody>
							</table>
						</div>						
						<div style="display: none;" id="time_old_data"> 
							<table id="datatables18" class="dataTable hoverable selectable nowrap " >
								<thead>
									<tr>
										<th class="par30"><?=$lng['Emp. ID']?></th>
										<th class="tal par30"><?=$lng['Employee name']?></th>
										<th class="tal "><?=$lng['Time registration']?></th>
										<th class="tal "><?=$lng['Take selfie']?></th>
										<th class="tal "><?=$lng['Work From Home']?></th>
			
					
									</tr>
								</thead>
								<tbody id="seldata4">

									<? if(isset($allOlddata) && is_array($allOlddata)){ 
										foreach ($allOlddata as $key => $value) { ?>
										 	
											<tr data-id="<?=$value['emp_id']?>">
												<td><?=$value['emp_id']?></td>
												<td><?=$getEmpName[$value['emp_id']];?></td>
												<td>
													<?php 
														if($value['time_reg'] == '0')
														{
															echo  $lng['No'] ;
														}
														else if($value['time_reg'] == '1')
														{
															echo  $lng['Yes'] ;
														}
													?>
												</td>												
												<td>
													<?php 
														if($value['selfie'] == '0')
														{
															echo  $lng['No'] ;
														}
														else if($value['selfie'] == '1')
														{
															echo  $lng['Yes'] ;
														}
													?>
												</td>												
												<td>
													<?php 
														if($value['workFromHome'] == '0')
														{
															echo  $lng['No'] ;
														}
														else if($value['workFromHome'] == '1')
														{
															echo  $lng['Yes'] ;
														}
													?>
												</td>
												
											</tr>

									<? } } ?>

								</tbody>
							</table>
						</div>						
						<div style="display: none;" id="leave_old_data"> 
							<table id="datatables20" class="dataTable hoverable selectable nowrap " >
								<thead>
									<tr>
										<th class="par30"><?=$lng['Emp. ID']?></th>
										<th class="tal par30"><?=$lng['Employee name']?></th>
										<th class="tal "><?=$lng['Annual leave (days)']?></th>
					
			
					
									</tr>
								</thead>
								<tbody id="seldata4">

									<? if(isset($allOlddata) && is_array($allOlddata)){ 
										foreach ($allOlddata as $key => $value) { ?>
										 	
											<tr data-id="<?=$value['emp_id']?>">
												<td><?=$value['emp_id']?></td>
												<td><?=$getEmpName[$value['emp_id']];?></td>
												<td><?=$getEmpName[$value['emp_id']];?></td>
											</tr>

									<? } } ?>

								</tbody>
							</table>
						</div>						

						<div style="display: none;" id="organization_old_data"> 
							<table id="datatables22" class="dataTable hoverable selectable nowrap " >
								<thead>
									<tr>
										<th class="par30"><?=$lng['Emp. ID']?></th>
										<th class="tal par30"><?=$lng['Employee name']?></th>
										<th class="tal "><?=$lng['Company']?></th>
										<th class="tal "><?=$lng['Location']?></th>
										<th class="tal "><?=$lng['Division']?></th>
										<th class="tal "><?=$lng['Department']?></th>
										<th class="tal "><?=$lng['Teams']?></th>
					
			
					
									</tr>
								</thead>
								<tbody id="seldata4">

									<? if(isset($allOlddata) && is_array($allOlddata)){ 
										foreach ($allOlddata as $key => $value) { ?>
										 	
											<tr data-id="<?=$value['emp_id']?>">
												<td><?=$value['emp_id']?></td>
												<td><?=$getEmpName[$value['emp_id']];?></td>
												<td><?=$company_name_data[$value['entity']][$_SESSION['rego']['lang']];?></td>
												<td><?=$branch_name_data[$value['branch']][$_SESSION['rego']['lang']];?></td>
												<td><?=$division_name_data[$value['division']][$_SESSION['rego']['lang']];?></td>
												<td><?=$department_name_data[$value['department']][$_SESSION['rego']['lang']];?></td>
												<td><?=$teams_name_data[$value['team']][$_SESSION['rego']['lang']];?></td>
											</tr>

									<? } } ?>

								</tbody>
							</table>
						</div>						
						<div style= "display: none;" id="financial_old_data">
							<table  id="datatables26" class="dataTable hoverable selectable nowrap" >

								<thead>
									<tr>
										<th class="par30"><?=$lng['Emp. ID']?></th>
										<th class="tal par30"><?=$lng['Employee name']?></th>
										<th class="par30"><?=$lng['Contract type']?></th>
										<th class="tal par30"><?=$lng['Calculation base']?></th>
										<th class="tal "><?=$lng['Bank code']?></th>
										<th class="tal "><?=$lng['Bank name']?></th>
										<th class="tal "><?=$lng['Bank branch']?></th>
										<th class="tal "><?=$lng['Bank account no.']?></th>
										<th class="tal "><?=$lng['Bank account name']?></th>
										<th class='tal'><?=$lng['Payment type']?></th>
										<th class='tal'><?=$lng['Accounting code']?></th>
										<th class='tal'><?=$lng['Groups']?></th>
										<th class='tal'><?=$lng['Tax calculation method']?></th>
										<th class='tal'><?='Calculate tax'?></th>
										<th class='tal'><?=$lng['Tax Residency Status']?></th>
										<th class='tal'><?='Income Section'?></th>
										<th class='tal'><?=$lng['Modify Tax amount']?></th>
										<th class='tal'><?=$lng['Calculate SSO']?></th>
										<th class='tal'><?=$lng['SSO paid by']?></th>
										<th class='tal'><?=$lng['Government house banking']?></th>
										<th class='tal'><?=$lng['Savings']?></th>
										<th class='tal'><?=$lng['Legal execution deduction']?></th>
										<th class='tal'><?=$lng['Kor.Yor.Sor (Student loan)']?></th>
										
									</tr>
								</thead>
								<tbody id="seldata2">
									<? if(isset($allOlddata) && is_array($allOlddata)){ 
										  foreach ($allOlddata as $key => $value) { ?>
											<tr data-id="<?=$value['emp_id']?>">
												<td><span id="rowIdDatatableSpan" style="display: none;"><?=$value['id']?></span><?=$value['emp_id']?></td>
												<td><?=$getEmpName[$value['emp_id']];?></td>
												<td><?=$contract_type[$value['contract_type']];?></td>
												<td><?=$calc_base[$value['calc_base']]?></th>
            									<td><?=$value['bank_code']?></th>
            									<td><?=$banksarray[$value['bank_name']]?></th>
            									<td><?=$value['bank_branch']?></th>
            									<td><?=$value['bank_account']?></th>
            									<td><?=$value['bank_account_name']?></th>
            									<td><?=$pay_type[$value['pay_type']]?></th>
            									<td><?=$accountCodeArray[$value['account_code']]?></th>
            									<td><?=$getAllGroups[$value['groups']]?></th>
            									<td><?=$calcmethod[$value['calc_method']]?></th>
            									<td><?=$calctax[$value['calc_tax']]?></th>
            									<td><?=$tax_residency_status[$value['tax_residency_status']]?></th>
            									<td><?=$income_section[$value['income_section']]?></th>
            									<td><?=$value['modify_tax']?></th>
            									<td><?=$noyes01[$value['calc_sso']]?></th>
            									<td><?=$sso_paidby[$value['sso_by']]?></th>
            									<td><?=$value['gov_house_banking']?></th>
            									<td><?=$value['savings']?></th>
            									<td><?=$value['legal_execution']?></th>
            									<td><?=$value['kor_yor_sor']?></th>
												
											</tr>
										<? } } ?>
								</tbody>
							</table>
						</div>	
						<div style="display: none;" id="benefits_old_data"> 
							<table id="datatables24" class="dataTable hoverable selectable nowrap " >
								<thead>
									<tr>
										<th class="par30"><?=$lng['Emp. ID']?></th>
										<th class="tal par30"><?=$lng['Employee name']?></th>
										<th class="tal "><?=$lng['Start Date']?></th>
										<th class="tal "><?=$lng['End date']?></th>
										<th class="tal "><?=$lng['Position']?></th>
										<th class="tal "><?=$lng['Basic salary']?></th>
										<th class="tal "><?=$lng['Housing']?></th>
										<th class="tal "><?=$lng['Transport']?></th>
										<th class="tal "><?=$lng['Position']?></th>
										<th class="tal "><?=$lng['Phone']?></th>
										<th class="tal "><?=$lng['Pay back loan']?></th>
										<th class="tal "><?=$lng['Head of Location']?></th>
										<th class="tal "><?=$lng['Head of division']?></th>
										<th class="tal "><?=$lng['Head of department']?></th>
										<th class="tal "><?=$lng['Team supervisor']?></th>
										<th class="tal "><?=$lng['Other benefits']?></th>
										<th class="tal "><?=$lng['Remarks']?></th>
					
			
					
									</tr>
								</thead>
								<tbody id="seldata4">

									<? if(isset($allOlddata) && is_array($allOlddata)){ 
										foreach ($allOlddata as $key => $value) { ?>
										 	
											<tr data-id="<?=$value['emp_id']?>">
												<td><?=$value['emp_id']?></td>
												<td><?=$getEmpName[$value['emp_id']];?></td>
												<td><?php 


												$newstartdate = date("d-m-Y", strtotime($value['start_date'])) ;

												echo $newstartdate;?></td>
												<td></td>
												<td></td>
												<td><?php echo $value['base_salary'];?></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
											</tr>

									<? } } ?>

								</tbody>
							</table>
						</div>

						<div class="row">
							<div class="col-md-2 <?php if($classNamePhpValue == ''){echo 'displayNone';}else{echo '';}?> " style="margin: -30px 0px 0px 0px;margin-left: auto;margin-right: auto;min-width: 38%;">
								<select id="pageLengthsecondtable" class="button btn-fl">
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
					
				</div>

			</div>

		</div><!-------- Tab 2 end-------->

		<div class="tab-pane" id="export_import">
			
		</div><!-------- Tab 3 end ------->

		<div class="tab-pane" id="overview">
			
		</div><!-------- Tab 4 end ------->

		<div class="tab-pane" id="verify_center">
			<div class="row" style="padding: 30px;padding-top: 15px;"> 
				<div class="col-md-6">

					<!-- RED -->
					
					<div class="row" >
						<img style="width: 6%;height: 0%;opacity:<?php if(isset($getAllTempLogErrors) ){ echo '1'; } else {echo '0.3';  }?> ;" src="<?php echo ROOT;?>assets/images/decision_icons/cancel.png">

						<h5 style="margin-left: 10%;padding-top: 6px;font-size: 15px;color: #d62e2b;font-weight: 600;display: <?php if(isset($getAllTempLogErrors) ){ echo ''; } else {echo 'none';  }?> ">Invalid format used for certain fields ! 
						<a class="getTheErrors" ><i class="fa fa-eye fa-lg"></i></a></h5>
					</div>
		
					
					<!-- YELLOW -->
					
					<div class="row" style="margin-top: 20px;">
						<img style="width: 6%;height: 0%;opacity:<?php if((!isset($getAllTempLogWarning)) && (!isset($getAllTempLogErrors)) ){ echo '1'; } else {echo '0.3';  }?> ;" src="<?php echo ROOT;?>assets/images/decision_icons/warning.png">
						<h5 style="margin-left: 10%;padding-top: 6px;font-size: 15px;color: #DAB423;font-weight: 600;display: <?php if((!isset($getAllTempLogWarning)) && (!isset($getAllTempLogErrors)) ){ echo ''; } else {echo 'none';  }?>">No Changes were noticed! 
						</h5>
					</div>	
			

					<!-- GREEN -->
					

					<div class="row" style="margin-top: 20px;">
						<img id="correctImage" style="width: 6%;height: 0%;opacity:<?php if((isset($getAllTempLogWarning)) && (!isset($getAllTempLogErrors)) ){ echo '1'; } else {echo '0.3';  }?>" src="<?php echo ROOT;?>assets/images/decision_icons/correct.png">
						<h5 style="margin-left: 10%;padding-top: 6px;color: #2faf36;font-weight: 600;display: <?php if((isset($getAllTempLogWarning)) && (!isset($getAllTempLogErrors)) ){ echo ''; } else {echo 'none';  }?>">Data ready to be saved ! 
						</h5>
					</div>

				

					
				</div>
				<div class="col-md-6">
					<table class="basicTable">
						<thead >
							<tr>
								<th colspan="2">
									<i class="fa fa-arrow-circle-down"></i>&nbsp; Review and Approval
								</th>
							</tr>
						</thead>
					</table>					
					<table class="basicTable" style="width:100%; margin-bottom:8px">
						<tr>
							<th class="tal"><?=$lng['Approval'];?></th>
							<td colspan="2">
								<input type="checkbox" name="no_app_req" value="0" class="ml-2 checkbox-blue-custom-white  checkbox-custom-blue-2" style="position: relative;top: 2px;">
								<span class="ml-2 text-italic" style="position: relative;bottom: 1px;">No approval required</span>
							</td>
						</tr>

					</table>
					<button <?php if((isset($getAllTempLogWarning)) && (!isset($getAllTempLogErrors)) ){ echo ""; } else {echo "disabled";  }?> style="margin-top: 94px;opacity: <?php if((isset($getAllTempLogWarning)) && (!isset($getAllTempLogErrors)) ){ echo '1'; } else {echo '0.3';  }?>;" onclick="saveTpEmpsTable();" class="btn btn-primary <?php if((isset($getAllTempLogWarning)) && (!isset($getAllTempLogErrors)) ){ echo 'flash'; } else {echo '';  }?>" id="saveToEmps" type="button"><?=$lng['Save to Employee Register']?></button>
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

					<table class="basicTable" id="logTable" style="width: 50%!important;">
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

					<table class="basicTable" id="employeeMissFields" style="width: 50%!important;">
						<thead >
							<tr>
								<th>Emp <?=$lng['ID']?></th>
								<th>Employee Name</th>
								<th>Missing Fields</th>
							</tr>
						</thead>
						<tbody>

							<? if(isset($getAllTempLogDataMissing) && is_array($getAllTempLogDataMissing)){ 
										foreach ($getAllTempLogDataMissing as $key => $value) { ?>
										 	
											<tr data-id="<?=$value['emp_id']?>">
												<td><?=$value['emp_id'];?></td>
												<td><?=$value['en_name'];?></td>
												<td><?=$value['field'];?></td>
											</tr>

								<? } } ?>

								

						</tbody>
					</table>
				</div>

			</div>

		</div><!-------- Tab 5 end ------->
	</div>
</div>


<?php include('popup_models.php'); ?>

<script type="text/javascript">


	$( document ).ready(function() {

		var tempdatas = "<?=$tempdata?>";

 		var updateAnythingValue = '<?php echo $updateAnythingValue?>';

 		if(updateAnythingValue)
 		{

			// $('#saveToEmps').addClass('flash');
 		}




		var activeTabEntComs = localStorage.getItem('activeTabEntCom');

		// console.log(activeTabEntComs);

		if (activeTabEntComs === null)
		{
			$('.hideempgroups').css("display","none");
			$('.hideVerificationCenter').css("display","none");
			$('.hideclearselection').css("display","");
			$('#headerRedSpan').css("display","none");
			$('#headerRedSpanSave').css("display","none");
		}



		if(activeTabEntComs == '#emp_group' || activeTabEntComs == '#tab_RelatedTo')
		{
			$('.hideempgroups').css("display","none");
			$('.hideVerificationCenter').css("display","none");
			$('.hideclearselection').css("display","");
			$('#headerRedSpan').css("display","");
			$('#headerRedSpanSave').css("display","none");
		}
		else if(activeTabEntComs == '#modify_data')
		{
			$('.hideempgroups').css("display","");
			$('.hideclearselection').css("display","none");
			$('.hideVerificationCenter').css("display","none");
			$('#headerRedSpan').css("display","none");
			$('#headerRedSpanSave').css("display","");


		}		
		else if(activeTabEntComs == '#verify_center')
		{
			$('.hideempgroups').css("display","none");
			$('.hideclearselection').css("display","none");
			$('.hideVerificationCenter').css("display","");
			$('#headerRedSpan').css("display","none");
			$('#headerRedSpanSave').css("display","");


		}




		//======================================= GET SELECTED SECTION ON PAGE RELOAD =============================//

 		var selectionSelectSectionData = '<?php echo $selectionSelectValue?>';

		if(selectionSelectSectionData == '1')
		{
			$('#personal_div_data').css('display','');
			$('#country_div_data').css('display','none');
			$('#work_div_data').css('display','none');
			$('#time_div_data').css('display','none');
			$('#leave_div_data').css('display','none');
			$('#organization_div_data').css('display','none');
			$('#financial_div_data').css('display','none');
			$('#benefits_div_data').css('display','none');

		}
		else if(selectionSelectSectionData == '2')
		{
			$('#country_div_data').css('display','');
			$('#personal_div_data').css('display','none');
			$('#work_div_data').css('display','none');
			$('#time_div_data').css('display','none');
			$('#leave_div_data').css('display','none');
			$('#organization_div_data').css('display','none');
			$('#financial_div_data').css('display','none');
			$('#benefits_div_data').css('display','none');

		}	
		else if(selectionSelectSectionData == '3')
		{
			$('#country_div_data').css('display','none');
			$('#personal_div_data').css('display','none');
			$('#work_div_data').css('display','');
			$('#time_div_data').css('display','none');
			$('#leave_div_data').css('display','none');
			$('#organization_div_data').css('display','none');
			$('#financial_div_data').css('display','none');
			$('#benefits_div_data').css('display','none');

		}	
		else if(selectionSelectSectionData == '4')
		{
			$('#country_div_data').css('display','none');
			$('#personal_div_data').css('display','none');
			$('#work_div_data').css('display','none');
			$('#time_div_data').css('display','');
			$('#leave_div_data').css('display','none');
			$('#organization_div_data').css('display','none');
			$('#financial_div_data').css('display','none');
			$('#benefits_div_data').css('display','none');

		}	
		else if(selectionSelectSectionData == '5')
		{
			$('#country_div_data').css('display','none');
			$('#personal_div_data').css('display','none');
			$('#work_div_data').css('display','none');
			$('#time_div_data').css('display','none');
			$('#leave_div_data').css('display','');
			$('#organization_div_data').css('display','none');
			$('#financial_div_data').css('display','none');
			$('#benefits_div_data').css('display','none');
		}		
		else if(selectionSelectSectionData == '6')
		{
			$('#country_div_data').css('display','none');
			$('#personal_div_data').css('display','none');
			$('#work_div_data').css('display','none');
			$('#time_div_data').css('display','none');
			$('#leave_div_data').css('display','none');
			$('#organization_div_data').css('display','');
			$('#financial_div_data').css('display','none');
			$('#benefits_div_data').css('display','none');
		}else if(selectionSelectSectionData == '7')
		{
			$('#country_div_data').css('display','none');
			$('#personal_div_data').css('display','none');
			$('#work_div_data').css('display','none');
			$('#time_div_data').css('display','none');
			$('#leave_div_data').css('display','none');
			$('#organization_div_data').css('display','none');
			$('#financial_div_data').css('display','');
			$('#benefits_div_data').css('display','none');
		}		
		else if(selectionSelectSectionData == '8')
		{
			$('#country_div_data').css('display','none');
			$('#personal_div_data').css('display','none');
			$('#work_div_data').css('display','none');
			$('#time_div_data').css('display','none');
			$('#leave_div_data').css('display','none');
			$('#organization_div_data').css('display','none');
			$('#financial_div_data').css('display','none');
			$('#benefits_div_data').css('display','');
		}
		else
		{
			$('#personal_div_data').css('display','none');
			$('#country_div_data').css('display','none');
			$('#work_div_data').css('display','none');
			$('#time_div_data').css('display','none');
			$('#leave_div_data').css('display','none');
			$('#organization_div_data').css('display','none');
			$('#financial_div_data').css('display','none');
			$('#benefits_div_data').css('display','none');

		}

		//======================================= GET SELECTED SECTION ON PAGE RELOAD =============================//

	});


		$('.emp_groups').on('click', function(){
			$('.hideempgroups').css("display","none");
			$('.hideVerificationCenter').css("display","none");
			$('.hideclearselection').css("display","");
			$('#headerRedSpan').css("display","");
			$('#headerRedSpanSave').css("display","none");
		})
		
		$('.modify_data').on('click', function(){
			$('.hideclearselection').css("display","none");
			$('.hideVerificationCenter').css("display","none");
			$('.hideempgroups').css("display","");
			$('#headerRedSpan').css("display","none");
			$('#headerRedSpanSave').css("display","");

		})		

		$('.overview').on('click', function(){
			$('.hideclearselection').css("display","none");
			$('.hideVerificationCenter').css("display","none");
			$('.hideempgroups').css("display","none");
			$('#headerRedSpan').css("display","none");
			$('#headerRedSpanSave').css("display","none");

		})		
		$('.verification_center').on('click', function(){
			$('.hideclearselection').css("display","none");
			$('.hideVerificationCenter').css("display","");
			$('.hideempgroups').css("display","none");
			$('#headerRedSpan').css("display","none");
			$('#headerRedSpanSave').css("display","");

		})



	function checkAllcheckboxes(){
		//for position
		if($('#modalmodify input[name="position"]').prop('checked') == true){
		   	$('table#makeSelection tr#positions').css('display','table-row');
		}else{
			$('table#makeSelection tr#positions').css('display','none');
		}

		//for organizations
		if($('#modalmodify input[name="organization"]').prop('checked') == true){
		   	$('table#makeSelection tr#organizations').css('display','table-row');
		}else{
			$('table#makeSelection tr#organizations').css('display','none');
		}

		//for groups
		if($('#modalmodify input[name="group"]').prop('checked') == true){
		   	$('table#makeSelection tr#groups').css('display','table-row');
		}else{
			$('table#makeSelection tr#groups').css('display','none');
		}

		//for employee data
		var emparr1 = [];
		$('#datatableEmppp tbody#relatedata tr').each(function(k,v){
			emparr1.push($(this).data('id'));
		})

		$('#modalmodify form input#empallids').val('');
		var selEmps = emparr1.toString();
		$('#modalmodify form input#empallids').val(selEmps);
	}

	function removeRowempss(that){

		$.ajax({
			url: "ajax/remove_temp_employee_data.php",
			type: 'POST',
			data: {empid: that.id},
			success: function(result){
				
				$('#datatableEmppp tr#'+that.id).remove();
				window.location.reload();
			}
		})	
	}


	function Addemployeeintemp(that){
		//alert(that.value);
		$.ajax({
			url: "ajax/add_employee_to_temp_data.php",
			type: 'POST',
			data: {empid: that.value},
			success: function(result){
				
				$("body").overhang({
					type: "success",
					message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
					duration: 2,
					callback: function(value){
						window.location.reload();
					}
				})
			}
		})	
	}


	var currentTab = 0; 
	showTab(currentTab);

	function showTab(n) {
	  // This function will display the specified tab of the form...
	  var x = document.getElementsByClassName("tab"); 
	  x[n].style.display = "block";
	  //... and fix the Previous/Next buttons:
	  if (n == 0) {
	    document.getElementById("prevBtn").style.display = "none";
	  } else {
	    document.getElementById("prevBtn").style.display = "inline";
	    //$('#SaveNewUser').attr('id','nextBtn');
	  }
	  if (n == (x.length - 1)) {
	  	checkAllcheckboxes();
	    document.getElementById("nextBtn").innerHTML = "<?=$lng['Modify Data']?>";
	    
	    //$('#nextBtn').attr('id','SaveNewUser');
	  } else {
	    document.getElementById("nextBtn").innerHTML = "Next";
	    
	    //$('#nextBtn').attr('id','nextBtn'); 
	  }
	  //... and run a function that will display the correct step indicator:
	  //fixStepIndicator(n)
	}

	function nextPrev(n) {
	  // This function will figure out which tab to display
	  var x = document.getElementsByClassName("tab");
	  // Exit the function if any field in the current tab is invalid:
	  //if (n == 1 && !validateForm()) return false;
	  // Hide the current tab:
	  x[currentTab].style.display = "none";
	  // Increase or decrease the current tab by 1:
	  currentTab = currentTab + n;
	  // if you have reached the end of the form...
	  if (currentTab >= x.length) {
	    // ... the form gets submitted:
	    //document.getElementById("regForm").submit();
	    SaveNewEmployeesdata();
	    return false;
	  }
	  // Otherwise, display the correct tab:
	  showTab(currentTab);
	}


	function SaveNewEmployeesdata(){

		var frm = $('#mkchoice');
		var data = frm.serialize();

		var err = true;
		if($('#empallids').val()==''){err = false};
		if(err==false){
			$("body").overhang({
				type: "error",
				message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;There is no employee selected',
				duration: 2,
				callback: function(v){
					window.location.reload();
				}
			})

		}else{

			$.ajax({
				url: ROOT+"settings/company/ajax/temp_employee_data.php",
				type: 'POST',
				data: data,
				success: function(result){
					if(result == 'success'){
						$('#modalmodify').modal('hide');
						$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
							duration: 2,
							callback: function(value){
								window.location.reload();
							}
						})
				
					}else{

						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?>: '+result,
							duration: 4,
						})
					}
				}
			})

			//$("#sAlert").fadeIn(200);
		}
	}

	
	$(document).ready(function(){

// ===============================  COMMON DATATABLE SECTION SCRIPT ===============================//
<?php include('section_script/common_datatable_script.php'); ?>
// ===============================  COMMON DATATABLE SECTION SCRIPT ===============================//



//======================== VIEW TEAMS MODAL OPEN  =========================//

		$(document).on("click", ".modifydata", function(e){
			e.preventDefault();
			$('#modalmodify').modal('toggle');
		});		

		$(document).on("click", ".modifydata_nationality", function(e){
			e.preventDefault();
			$('#modalmodify_nationality').modal('toggle');
		});			

		$(document).on("click", ".modifydata_firstname", function(e){
			e.preventDefault();
			$('#modalmodify_firstname').modal('toggle');
		});		
		$(document).on("click", ".modifydata_lastname", function(e){
			e.preventDefault();
			$('#modalmodify_lastname').modal('toggle');
		});			
		$(document).on("click", ".modifydata_english_name", function(e){
			e.preventDefault();
			$('#modalmodify_englishname').modal('toggle');
		});		

		$(document).on("click", ".modifydata_scan_id", function(e){
			e.preventDefault();
			$('#modalmodify_scanid').modal('toggle');
		});		

		$(document).on("click", ".modifydata_gender", function(e){
			e.preventDefault();
			$('#modalmodify_gender').modal('toggle');
		});		

		$(document).on("click", ".modifydata_maritial", function(e){
			e.preventDefault();
			$('#modalmodify_maritial').modal('toggle');
		});

		$(document).on("click", ".modifydata_religion", function(e){
			e.preventDefault();
			$('#modalmodify_religion').modal('toggle');
		});

		$(document).on("click", "#ModifyOrg", function(e){
			e.preventDefault();

			$('#ModifyOrgmdl').modal('toggle');
		});


		$(document).on("click", ".modifydata_title", function(e){
			e.preventDefault();
			$('#modalmodify_title').modal('toggle');
		});			

		$(document).on("click", ".modifydata_military", function(e){
			e.preventDefault();
			$('#modalmodify_military').modal('toggle');
		});		

		$(document).on("click", ".modifydata_height", function(e){
			e.preventDefault();
			$('#modalmodify_height').modal('toggle');
		});			

		$(document).on("click", ".modifydata_weight", function(e){
			e.preventDefault();
			$('#modalmodify_weight').modal('toggle');
		});		

		$(document).on("click", ".modifydata_blood_type", function(e){
			e.preventDefault();
			$('#modalmodify_bloodtype').modal('toggle');
		});		

		$(document).on("click", ".modifydata_driving_license", function(e){
			e.preventDefault();
			$('#modalmodify_driving_license').modal('toggle');
		});		

		$(document).on("click", ".modifydata_license_date", function(e){
			e.preventDefault();
			$('#modalmodify_driving_license_date').modal('toggle');
		});		

		$(document).on("click", ".modifydata_id_card", function(e){
			e.preventDefault();
			$('#modalmodify_id_card').modal('toggle');
		});	

		$(document).on("click", ".modifydata_id_card_expiry_date", function(e){
			e.preventDefault();
			$('#modalmodify_id_card_expiry_date').modal('toggle');
		});		

		$(document).on("click", ".modifydata_tax_id", function(e){
			e.preventDefault();
			$('#modalmodify_tax_id').modal('toggle');
		});		

		$(document).on("click", ".modifydata_birthdate", function(e){
			e.preventDefault();
			$('#modalmodify_birthdate').modal('toggle');
		});		
		

		/*$(document).on("click", ".removeRowemp", function(e){
			e.preventDefault();

			alert(this.id);

			var teamval = $(this).attr('data-team');
			$('#datatableEmppp tr#'+this.id).remove();	

			var teamarr1 = [];
			$('#datatableEmppp tbody#relatedata tr').each(function(k,v){
				teamarr1.push($(this).data('team'));
			})

			//alert(teamval);
			var count = 0;
			$.each(teamarr1, function(k,v){
				if(v == teamval){
					count++;
				}
			})

			//alert(count);
			var teams = $.unique(teamarr1);
			if(count >= 1){
				//nothing to do
			}else{
				updateAccess('teams', teams,1);
			}
			
		});*/

		$('.Clearselection').confirmation({
			container: 'body',
			rootSelector: '.Clearselection',
			singleton: true,
			animated: 'fade',
			placement: 'left',
			popout: true,
			html: true,
			title: '<?=$lng['Are you sure']?>',
			//btnOkIcon: '',
			//btnCancelIcon: '',
			btnOkLabel: '<?=$lng['Delete']?>',
			btnCancelLabel: '<?=$lng['Cancel']?>',
			onConfirm: function() { 
				$.ajax({
					url: "ajax/clearSelection.php",
					data:{},
					success: function(result){
						if(result == 'success'){
							$("body").overhang({
								type: "success",
								message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data removed successfully']?>',
								duration: 1,
								// callback: function(v){
								// 	window.location.reload();
								// }
							})

							setTimeout(function(){
								window.location.reload();
							}, 500); 

						}
					},
					error:function (xhr, ajaxOptions, thrownError){
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
							duration: 4,
						})
					}
				});
			}
		});

		//======= For position =============
		function updatePotions(position, team, department, division, branch){

			$.ajax({
				url: "ajax/position_selection.php",
				data: {position: position, team: team, department: department, division: division, branch: branch},
				success: function(result){

					window.location.reload();

				}
			})

		}
		//======= For position =============

		
		//============== Access rights ===============
		function updateAccess(access, values, show){
			//alert(values);

			if(values !=''){

				$.ajax({
					url: ROOT+"settings/ajax/update_user_access.php",
					data: {access: access, values: values},
					dataType: 'json',
					success: function(result){

						if(show == 1){
							getSelectedTeamEmployee(result.branch,result.division,result.department,result.team);
						}

						if(entitiesCount > 1){
							$('#userEntities')[0].sumo.unSelectAll();
							$.each(result.entity, function(v){
								$('#userEntities')[0].sumo.selectItem(v);
							})
						}
						
						if(parameters[1]['apply_param'] == 1 && branchesCount > 1){
							$('#userBranches')[0].sumo.unSelectAll();
							$.each(result.branch, function(i,v){
								$('#userBranches')[0].sumo.selectItem(v);
							})
						}
						if(parameters[2]['apply_param'] == 1 && divisionsCount > 1){
							$('#userDivisions')[0].sumo.unSelectAll();
							$.each(result.division, function(i,v){
								$('#userDivisions')[0].sumo.selectItem(v);
							})
						}
						if(parameters[3]['apply_param'] == 1 && departmentsCount > 1){
							$('#userDepartments')[0].sumo.unSelectAll();
							$.each(result.department, function(v){
								$('#userDepartments')[0].sumo.selectItem(v);
							})
						}
						if(parameters[4]['apply_param'] == 1 && teamsCount > 1){
							$('#userTeams')[0].sumo.unSelectAll();
							$.each(result.team, function(v){
								$('#userTeams')[0].sumo.selectItem(v);
							})
						}
						
						$('#usersAccess tbody#accessBody').html('');
						$('#usersAccess tbody#accessBody').html(result.tableRow); //return false;
					}
				});
			}
		}
		
		$('#userEntities').SumoSelect({
			placeholder: '<?=$lng['Select'].' '.$lng['Company']?>',
			captionFormat: '<?=$lng['Company']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All'].' '.$lng['Company']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});
		$('#userBranches').SumoSelect({
			placeholder: '<?=$lng['Select location']?>',
			captionFormat: '<?=$lng['Locations']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All'].' '.$lng['Locations']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});
		$('#userDivisions').SumoSelect({
			placeholder: '<?=$lng['Select divisions']?>',
			captionFormat: '<?=$lng['Divisions']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All Divisions']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});
		$('#userDepartments').SumoSelect({
			placeholder: '<?=$lng['Select departments']?>',
			captionFormat: '<?=$lng['Departments']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All Departments']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});
		$('#userTeams').SumoSelect({
			placeholder: '<?=$lng['Select teams']?>',
			captionFormat: '<?=$lng['Teams']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All Teams']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});

		$('#userPosition').SumoSelect({
			placeholder: '<?=$lng['Select'].' '.$lng['Position']?>',
			captionFormat: '<?=$lng['Positions']?> ({0})',
			captionFormatAllSelected: '<?=$lng['All'].' '.$lng['Positions']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});
		
		
		if(entitiesCount > 1){
			$('#userEntities')[0].sumo.unSelectAll();
		}
		if(parameters[1]['apply_param'] == 1 && branchesCount > 1){
			$('#userBranches')[0].sumo.unSelectAll();
		}
		if(parameters[2]['apply_param'] == 1 && divisionsCount > 1){
			$('#userDivisions')[0].sumo.unSelectAll();
		}
		if(parameters[3]['apply_param'] == 1 && departmentsCount > 1){
			$('#userDepartments')[0].sumo.unSelectAll();
		}
		if(parameters[4]['apply_param'] == 1 && teamsCount > 1){
			$('#userTeams')[0].sumo.unSelectAll();
		}
		
		$("#userEntities ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccess('entities', $('#userEntities').val(),1);
		});
		$("#userBranches ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccess('branches', $('#userBranches').val(),1);
		});
		$("#userDivisions ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccess('divisions', $('#userDivisions').val(),1);
		});
		$("#userDepartments ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccess('departments', $('#userDepartments').val(),1);
		});
		$("#userTeams ~ .optWrapper .MultiControls .btnOk").click( function () {
			updateAccess('teams', $('#userTeams').val(),1);
		});

		if(positionsCount > 1){
			var implodeArrsPos = '<?=$implodeArrsPos?>'; //alert(implodeArrsPos);
			if(implodeArrsPos !=''){
				var numbersArray = implodeArrsPos.split(',');
				$('#userPosition')[0].sumo.unSelectAll();
				$.each(numbersArray, function(k,v){ 
					$('#userPosition')[0].sumo.selectItem(v);
				})
			}

			//employee according to position selection...
			$("#userPosition ~ .optWrapper .MultiControls .btnOk").click( function () {
				updatePotions($('#userPosition').val(), $('#userTeams').val(), $('#userDepartments').val(), $('#userDivisions').val(), $('#userBranches').val() );
			});
		}


		//onload...
		if(parameters[4]['apply_param'] == 1){
			var numbersString = '<?=$implodeArrs?>';
			var numbersArray = numbersString.split(',');
			updateAccess('teams', numbersArray,0);
		}else{

			//onload...
			if(parameters[3]['apply_param'] == 1){
				var numbersString = '<?=$implodeArrsdep?>';
				var numbersArray = numbersString.split(',');
				updateAccess('departments', numbersArray,0);
			}
		}

		var tempdata = "<?=$tempdata?>";
		var activeTabEntCom = localStorage.getItem('activeTabEntCom');
		if(activeTabEntCom){
			if(activeTabEntCom == '#modify_data' ){
				if(tempdata == ''){
				}

			}
			$('.nav-link[href="' + activeTabEntCom + '"]').tab('show');

				dtable.draw();
				dtable2.draw();
				dtable3.draw();
				dtable4.draw();
				dtable5.draw();
				dtable6.draw();
				dtable7.draw();
				dtable8.draw();

		}
		else
		{
			$('.nav-link[href="#emp_group"]').tab('show');
		}

		$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {


			if($(e.target).attr('href') == '#modify_data'){
				if(tempdata == ''){
				}	

				dtable.draw();
				dtable2.draw();
				dtable3.draw();
				dtable4.draw();
				dtable5.draw();
				dtable6.draw();
				dtable7.draw();
				dtable8.draw();

			}			

			if($(e.target).attr('href') == '#verify_center'){

				logTable.draw();
				employeeMissFields.draw();
			}
			localStorage.setItem('activeTabEntCom', $(e.target).attr('href'));
		});


		// ===============================  COMMON HIDE SHOW SECTION SCRIPT ===================//
			<?php include('section_script/common_show_hide.php'); ?>
		// ===============================  COMMON HIDE SHOW SECTION SCRIPT ===================//





		//============== Access rights ===============
		dtable.draw();
		dtable2.draw();
		dtable3.draw();
		dtable4.draw();
		dtable5.draw();
		dtable6.draw();
		dtable7.draw();
		dtable8.draw();
		logTable.draw();
		employeeMissFields.draw();



		$('.switchLayout').on('click', function(){


			if ($("#hidediv2").hasClass("displayNone"))
			{

				var classname = '';
				var heightvalue = '';
				var scrolly = '250px';
				var pagelength = '9';
			}
			else 
			{
				var classname = 'displayNone';
				var heightvalue = '100%';
				var scrolly = '550px';
				var pagelength = '20';
			}


			$.ajax({
					type: 'POST',
					url: ROOT+"settings/ajax/def/updateSwitchCase.php",
					data: {classname: classname, heightvalue: heightvalue,scrolly:scrolly,pagelength:pagelength},
					success: function(result){

						window.location.reload();
					}
				})

		})



		//============================================ SHOW HIDE TABLE COLUMN =============================// 

		var defaultSectionValue  = $('#section_select').val();

		if(defaultSectionValue == 'Choose Section')
		{
			$('#showHideclm2').prop("disabled",true);
			$('#showHideClmss2').addClass('displayNone');

			var hideAllcolumn = [2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20];
			$.each(hideAllcolumn, function(key,val) {    
				dtable.column(val).visible(false);
				dtable2.column(val).visible(false);
			});


			// hide show hide button 

			$("#showHideclm2").closest("div").css('display','none');
			$("#showHideclm3").closest("div").css('display','none');
			$("#showHideclm4").closest("div").css('display','none');
			$("#showHideclm5").closest("div").css('display','none');
			$("#showHideclm6").closest("div").css('display','none');
			$("#showHideclm7").closest("div").css('display','none');
			$("#showHideclm9").closest("div").css('display','none');
			$("#showHideclm8").closest("div").css('display','none');
			$(".commonhidebutton").css('display','');
			

			

		}		
		else if(defaultSectionValue == '1')
		{

			$('#showHideclm2').prop("disabled",false);
			$('#showHideClmss2').removeClass('displayNone');


			// perosnal section
			$('#div_personal').css("display","");
			$('#personal_old_data').css("display","");
			// contact section
			$('#div_contacts').css("display","none");
			$('#contacts_old_data').css("display","none");
			// work data section
			$('#div_work_data').css("display","none");
			$('#work_data_old_data').css("display","none");		
			// time section
			$('#div_time').css("display","none");
			$('#time_old_data').css("display","none");			
			// leave section
			$('#div_leave').css("display","none");
			$('#leave_old_data').css("display","none");			

			// organization section
			$('#div_organization').css("display","none");
			$('#organization_old_data').css("display","none");	

			$('#div_financial').css("display","none");
			$('#financial_old_data').css("display","none");

			$('#div_benfits').css("display","none");
			$('#benefits_old_data').css("display","none");

			var hideAllcolumn = [3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20];
			$.each(hideAllcolumn, function(key,val) {    
				dtable.column(val).visible(true);
				dtable2.column(val).visible(true);
			});




			$("#showHideclm2").closest("div").css('display','');
			$("#showHideclm3").closest("div").css('display','none');
			$("#showHideclm4").closest("div").css('display','none');
			$("#showHideclm5").closest("div").css('display','none');
			$("#showHideclm6").closest("div").css('display','none');
			$("#showHideclm7").closest("div").css('display','none');
			$("#showHideclm9").closest("div").css('display','none');
			$("#showHideclm8").closest("div").css('display','none');
			$(".commonhidebutton").css('display','');

			dtable.columns.adjust();
			dtable2.columns.adjust();
 
		}		
		else if(defaultSectionValue == '2')
		{
			// personal section
			$('#div_personal').css("display","none");
			$('#personal_old_data').css("display","none");
			// contact section
			$('#div_contacts').css("display","");
			$('#contacts_old_data').css("display","");
			// workd data section
			$('#div_work_data').css("display","none");
			$('#work_data_old_data').css("display","none");
			// time section
			$('#div_time').css("display","none");
			$('#time_old_data').css("display","none");
			// leave section
			$('#div_leave').css("display","none");
			$('#leave_old_data').css("display","none")
			// organization section
			$('#div_organization').css("display","none");
			$('#organization_old_data').css("display","none");

			$('#div_financial').css("display","none");
			$('#financial_old_data').css("display","none");

			$('#div_benfits').css("display","none");
			$('#benefits_old_data').css("display","none");


			$('#showHideclm2').prop("disabled",false);
			$('#showHideClmss2').removeClass('displayNone');


			$("#showHideclm2").closest("div").css('display','none');
			$("#showHideclm3").closest("div").css('display','');
			$("#showHideclm4").closest("div").css('display','none');
			$("#showHideclm5").closest("div").css('display','none');
			$("#showHideclm6").closest("div").css('display','none');
			$("#showHideclm7").closest("div").css('display','none');
			$("#showHideclm9").closest("div").css('display','none');
			$("#showHideclm8").closest("div").css('display','none');
			$(".commonhidebutton").css('display','');


			dtable3.columns.adjust();
			dtable4.columns.adjust();

		}		
		else if(defaultSectionValue == '3')
		{	
			// perosnal section
			$('#div_personal').css("display","none");
			$('#personal_old_data').css("display","none");
			// contact section
			$('#div_contacts').css("display","none");
			$('#contacts_old_data').css("display","none");
			// work data section
			$('#div_work_data').css("display","");
			$('#work_data_old_data').css("display","");
			// time section
			$('#div_time').css("display","none");
			$('#time_old_data').css("display","none");
			// leave section
			$('#div_leave').css("display","none");
			$('#leave_old_data').css("display","none")
			// organization section
			$('#div_organization').css("display","none");
			$('#organization_old_data').css("display","none");

			$('#div_financial').css("display","none");
			$('#financial_old_data').css("display","none");

			$('#div_benfits').css("display","none");
			$('#benefits_old_data').css("display","none");


			$("#showHideclm2").closest("div").css('display','none');
			$("#showHideclm3").closest("div").css('display','none');
			$("#showHideclm4").closest("div").css('display','');
			$("#showHideclm5").closest("div").css('display','none');
			$("#showHideclm6").closest("div").css('display','none');
			$("#showHideclm7").closest("div").css('display','none');
			$("#showHideclm9").closest("div").css('display','none');
			$("#showHideclm8").closest("div").css('display','none');
			$(".commonhidebutton").css('display','');
			

			dtable5.columns.adjust();
			dtable6.columns.adjust();


		}		
		else if(defaultSectionValue == '4')
		{	
			// perosnal section
			$('#div_personal').css("display","none");
			$('#personal_old_data').css("display","none");
			// contact section
			$('#div_contacts').css("display","none");
			$('#contacts_old_data').css("display","none");
			// work data section
			$('#div_work_data').css("display","none");
			$('#work_data_old_data').css("display","none");
			// time section
			$('#div_time').css("display","");
			$('#time_old_data').css("display","");
			// leave section
			$('#div_leave').css("display","none");
			$('#leave_old_data').css("display","none")
			// organization section
			$('#div_organization').css("display","none");
			$('#organization_old_data').css("display","none");

			$('#div_financial').css("display","none");
			$('#financial_old_data').css("display","none");

			$('#div_benfits').css("display","none");
			$('#benefits_old_data').css("display","none");


			$("#showHideclm2").closest("div").css('display','none');
			$("#showHideclm3").closest("div").css('display','none');
			$("#showHideclm4").closest("div").css('display','none');
			$("#showHideclm5").closest("div").css('display','');
			$("#showHideclm6").closest("div").css('display','none');
			$("#showHideclm7").closest("div").css('display','none');
			$("#showHideclm9").closest("div").css('display','none');
			$("#showHideclm8").closest("div").css('display','none');
			$(".commonhidebutton").css('display','');

			dtable7.columns.adjust();
			dtable8.columns.adjust();


		}		
		else if(defaultSectionValue == '5')
		{	
			// perosnal section
			$('#div_personal').css("display","none");
			$('#personal_old_data').css("display","none");
			// contact section
			$('#div_contacts').css("display","none");
			$('#contacts_old_data').css("display","none");
			// work data section
			$('#div_work_data').css("display","none");
			$('#work_data_old_data').css("display","none");
			// time section
			$('#div_time').css("display","none");
			$('#time_old_data').css("display","none");
			// leave section
			$('#div_leave').css("display","");
			$('#leave_old_data').css("display","")
			// organization section
			$('#div_organization').css("display","none");
			$('#organization_old_data').css("display","none");

			$('#div_financial').css("display","none");
			$('#financial_old_data').css("display","none");

			$('#div_benfits').css("display","none");
			$('#benefits_old_data').css("display","none");

			$("#showHideclm2").closest("div").css('display','none');
			$("#showHideclm3").closest("div").css('display','none');
			$("#showHideclm4").closest("div").css('display','none');
			$("#showHideclm5").closest("div").css('display','none');
			$("#showHideclm6").closest("div").css('display','');
			$("#showHideclm7").closest("div").css('display','none');
			$("#showHideclm9").closest("div").css('display','none');
			$("#showHideclm8").closest("div").css('display','none');
			$(".commonhidebutton").css('display','');

			dtable10.columns.adjust();
			dtable9.columns.adjust();


		}		
		else if(defaultSectionValue == '6')
		{	
			// perosnal section
			$('#div_personal').css("display","none");
			$('#personal_old_data').css("display","none");
			// contact section
			$('#div_contacts').css("display","none");
			$('#contacts_old_data').css("display","none");
			// work data section
			$('#div_work_data').css("display","none");
			$('#work_data_old_data').css("display","none");
			// time section
			$('#div_time').css("display","none");
			$('#time_old_data').css("display","none");
			// leave section
			$('#div_leave').css("display","none");
			$('#leave_old_data').css("display","none")
			// organization section
			$('#div_organization').css("display","");
			$('#organization_old_data').css("display","");

			$('#div_financial').css("display","none");
			$('#financial_old_data').css("display","none");

			$('#div_benfits').css("display","none");
			$('#benefits_old_data').css("display","none");
			

			$("#showHideclm2").closest("div").css('display','none');
			$("#showHideclm3").closest("div").css('display','none');
			$("#showHideclm4").closest("div").css('display','none');
			$("#showHideclm5").closest("div").css('display','none');
			$("#showHideclm6").closest("div").css('display','none');
			$("#showHideclm7").closest("div").css('display','');
			$("#showHideclm9").closest("div").css('display','none');
			$("#showHideclm8").closest("div").css('display','none');
			$(".commonhidebutton").css('display','none');


			dtable11.columns.adjust();
			dtable12.columns.adjust();

		}else if(defaultSectionValue == '7')	
		{	
			// perosnal section
			$('#div_personal').css("display","none");
			$('#personal_old_data').css("display","none");
			// contact section
			$('#div_contacts').css("display","none");
			$('#contacts_old_data').css("display","none");
			// work data section
			$('#div_work_data').css("display","none");
			$('#work_data_old_data').css("display","none");
			// time section
			$('#div_time').css("display","none");
			$('#time_old_data').css("display","none");
			// leave section
			$('#div_leave').css("display","none");
			$('#leave_old_data').css("display","none")
			// organization section
			$('#div_organization').css("display","none");
			$('#organization_old_data').css("display","none");

			$('#div_financial').css("display","");
			$('#financial_old_data').css("display","");
			dtable15.columns.adjust();
			dtable16.columns.adjust();

			$('#div_benfits').css("display","none");
			$('#benefits_old_data').css("display","none");


			$("#showHideclm2").closest("div").css('display','none');
			$("#showHideclm3").closest("div").css('display','none');
			$("#showHideclm4").closest("div").css('display','none');
			$("#showHideclm5").closest("div").css('display','none');
			$("#showHideclm6").closest("div").css('display','none');
			$("#showHideclm7").closest("div").css('display','none');
			$("#showHideclm9").closest("div").css('display','');
			$("#showHideclm8").closest("div").css('display','none');
			$(".commonhidebutton").css('display','none');



		}		
			
		else if(defaultSectionValue == '8')
		{	
			// perosnal section
			$('#div_personal').css("display","none");
			$('#personal_old_data').css("display","none");
			// contact section
			$('#div_contacts').css("display","none");
			$('#contacts_old_data').css("display","none");
			// work data section
			$('#div_work_data').css("display","none");
			$('#work_data_old_data').css("display","none");
			// time section
			$('#div_time').css("display","none");
			$('#time_old_data').css("display","none");
			// leave section
			$('#div_leave').css("display","none");
			$('#leave_old_data').css("display","none")
			// organization section
			$('#div_organization').css("display","none");
			$('#organization_old_data').css("display","none");

			$('#div_financial').css("display","none");
			$('#financial_old_data').css("display","none");

			$('#div_benfits').css("display","");
			$('#benefits_old_data').css("display","");


			$("#showHideclm2").closest("div").css('display','none');
			$("#showHideclm3").closest("div").css('display','none');
			$("#showHideclm4").closest("div").css('display','none');
			$("#showHideclm5").closest("div").css('display','none');
			$("#showHideclm6").closest("div").css('display','none');
			$("#showHideclm7").closest("div").css('display','none');
			$("#showHideclm9").closest("div").css('display','none');
			$("#showHideclm8").closest("div").css('display','');
			$(".commonhidebutton").css('display','none');

			dtable13.columns.adjust();
			dtable14.columns.adjust();


		}
		else
		{
			$('#showHideclm2').prop("disabled",false);
			$('#showHideClmss2').removeClass('displayNone');

			var hideAllcolumn = [2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20];
			$.each(hideAllcolumn, function(key,val) {    
				dtable.column(val).visible(true);
				dtable2.column(val).visible(true);
			});


			$("#showHideclm2").closest("div").css('display','none');
			$("#showHideclm3").closest("div").css('display','none');
			$("#showHideclm4").closest("div").css('display','none');
			$("#showHideclm5").closest("div").css('display','none');
			$("#showHideclm6").closest("div").css('display','none');
			$("#showHideclm7").closest("div").css('display','none');
			$("#showHideclm9").closest("div").css('display','none');
			$("#showHideclm8").closest("div").css('display','none');
			$(".commonhidebutton").css('display','');



		}

		// show sumo selected selection option only in the list 
		var notInSumoSelect = <?=json_encode($notInSumoSelect)?>;

		$.each(notInSumoSelect, function(key,val) {    


			if(val == '2')
			{
				$('ul li#modifydata_scan_id_li').addClass('displayNone');		
			}				
			if(val == '3')
			{
				$('ul li#modifydata_title_li').addClass('displayNone');		
			}				
			if(val == '4')
			{
				$('ul li#modifydata_firstname_li').addClass('displayNone');		
			}				
			if(val == '5')
			{
				$('ul li#modifydata_lastname_li').addClass('displayNone');		
			}		
			if(val == '6')
			{
				$('ul li#modifydata_english_name_li').addClass('displayNone');		
			}
			if(val == '7')
			{
				$('ul li#modifydata_birthdate_li').addClass('displayNone');		
			}				
			if(val == '8')
			{
				$('ul li#modifydata_nationality_li').addClass('displayNone');		
			}				
			if(val == '9')
			{
				$('ul li#modifydata_gender_li').addClass('displayNone');		
			}				
			if(val == '10')
			{
				$('ul li#modifydata_maritial_li').addClass('displayNone');		
			}	
			if(val == '11')
			{
				$('ul li#modifydata_religion_li').addClass('displayNone');		
			}				
			if(val == '12')
			{
				$('ul li#modifydata_military_li').addClass('displayNone');		
			}				
			if(val == '13')
			{
				$('ul li#modifydata_height_li').addClass('displayNone');		
			}				
			if(val == '14')
			{
				$('ul li#modifydata_weight_li').addClass('displayNone');		
			}				
			if(val == '15')
			{
				$('ul li#modifydata_blood_type_li').addClass('displayNone');		
			}
			if(val == '16')
			{
				$('ul li#modifydata_driving_license_li').addClass('displayNone');		
			}			
			if(val == '17')
			{
				$('ul li#modifydata_license_date_li').addClass('displayNone');		
			}		
			if(val == '18')
			{
				$('ul li#modifydata_id_card_li').addClass('displayNone');		
			}			
			if(val == '19')
			{
				$('ul li#modifydata_id_card_expiry_date_li').addClass('displayNone');		
			}				
			if(val == '20')
			{
				$('ul li#modifydata_tax_id_li').addClass('displayNone');		
			}


			 dtable.column(val).visible(false);
			 dtable2.column(val).visible(false);
	
		
		});


		$(document).on("change", ".getdatadivclass", function(e) {

			 $(".preloader").fadeIn(800);
			 $(".preloader").fadeOut(500);
			


			if(this.value  == 'Choose Section'){
				var hideAllcolumn = [2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20];
					$.each(hideAllcolumn, function(key,val) {    
					 dtable.column(val).visible(false);
					 dtable2.column(val).visible(false);

				});
		

			}
			else if(this.value  == '1')
			{
				// hide other table 
				// show personal info table 
				$('#div_personal').css("display","");
				$('#personal_old_data').css("display","");
				// contact section
				$('#div_contacts').css("display","none");
				$('#contacts_old_data').css("display","none");
				// workd data section
				$('#div_work_data').css("display","none");
				$('#work_data_old_data').css("display","none");
				// time section
				$('#div_time').css("display","none");
				$('#time_old_data').css("display","none");
				// leave section
				$('#div_leave').css("display","none");
				$('#leave_old_data').css("display","none");				
				// organization section
				$('#div_organization').css("display","none");
				$('#organization_old_data').css("display","none");


				$('#div_financial').css("display","none");
				$('#financial_old_data').css("display","none");
				
				$('#div_benfits').css("display","none");
				$('#benefits_old_data').css("display","none");








				var hideAllcolumn = [2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20];
					$.each(hideAllcolumn, function(key,val) {    
					 dtable.column(val).visible(true);
					 dtable2.column(val).visible(true);
	
				});

				$("select#showHideclm2")[0].sumo.selectAll();	


				var columns =[];
				$('#showHideclm2 option:selected').each(function(i) {
			  
			    	 columns.push($(this).val());

			    });

		    	var att_cols = [];
				$.each(columns, function(index, item) {
					att_cols.push({id:item, db:tableCols2[item][0], name:tableCols2[item][1]})
				})

		    	$.ajax({
					url: "ajax/update_show_hide_clm2.php",
					data: {cols: att_cols},
					success: function(result){
					},
					error:function (xhr, ajaxOptions, thrownError){
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
							duration: 4,
						})
					}
				});
				dtable.columns.adjust();
				dtable2.columns.adjust();
				
				
			}			
			else if(this.value  == '2')
			{
				// show contact table 
				$('#div_personal').css("display","none");
				$('#personal_old_data').css("display","none");
				// contact section
				$('#div_contacts').css("display","");
				$('#contacts_old_data').css("display","");
				// work data section
				$('#div_work_data').css("display","none");
				$('#work_data_old_data').css("display","none");
				// time section
				$('#div_time').css("display","none");
				$('#time_old_data').css("display","none");
				// leave section
				$('#div_leave').css("display","none");
				$('#leave_old_data').css("display","none");
				// organization section
				$('#div_organization').css("display","none");
				$('#organization_old_data').css("display","none");


				$('#div_financial').css("display","none");
				$('#financial_old_data').css("display","none");
				
				$('#div_benfits').css("display","none");
				$('#benefits_old_data').css("display","none");


				$("select#showHideclm3")[0].sumo.selectAll();	
				var columns =[];
				$('#showHideclm3 option:selected').each(function(i) {
			  
			    	 columns.push($(this).val());

			    });

		    	var att_cols = [];
				$.each(columns, function(index, item) {
					att_cols.push({id:item, db:tableCols3[item][0], name:tableCols3[item][1]})
				})

		    	$.ajax({
					url: "ajax/update_show_hide_clm2.php",
					data: {cols: att_cols},
					success: function(result){
					},
					error:function (xhr, ajaxOptions, thrownError){
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
							duration: 4,
						})
					}
				});
				dtable3.columns.adjust();
				dtable4.columns.adjust();
			}			
			else if(this.value  == '3')
			{
				// show contact table 
				$('#div_personal').css("display","none");
				$('#personal_old_data').css("display","none");
				// contact section
				$('#div_contacts').css("display","none");
				$('#contacts_old_data').css("display","none");
				// work data section
				$('#div_work_data').css("display","");
				$('#work_data_old_data').css("display","");
				// time section
				$('#div_time').css("display","none");
				$('#time_old_data').css("display","none");
				// leave section
				$('#div_leave').css("display","none");
				$('#leave_old_data').css("display","none");
				// organization section
				$('#div_organization').css("display","none");
				$('#organization_old_data').css("display","none");


				$('#div_financial').css("display","none");
				$('#financial_old_data').css("display","none");
				
				$('#div_benfits').css("display","none");
				$('#benefits_old_data').css("display","none");




				$("select#showHideclm4")[0].sumo.selectAll();	
				var columns =[];
				$('#showHideclm4 option:selected').each(function(i) {
			  
			    	 columns.push($(this).val());

			    });

		    	var att_cols = [];
				$.each(columns, function(index, item) {
					att_cols.push({id:item, db:tableCols4[item][0], name:tableCols4[item][1]})
				})

		    	$.ajax({
					url: "ajax/update_show_hide_clm2.php",
					data: {cols: att_cols},
					success: function(result){
					},
					error:function (xhr, ajaxOptions, thrownError){
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
							duration: 4,
						})
					}
				});
				dtable5.columns.adjust();
				dtable6.columns.adjust();


			}			
			else if(this.value  == '4')
			{
				// show contact table 
				$('#div_personal').css("display","none");
				$('#personal_old_data').css("display","none");
				// contact section
				$('#div_contacts').css("display","none");
				$('#contacts_old_data').css("display","none");
				// work data section
				$('#div_work_data').css("display","none");
				$('#work_data_old_data').css("display","none");
				// time section
				$('#div_time').css("display","");
				$('#time_old_data').css("display","");
				// leave section
				$('#div_leave').css("display","none");
				$('#leave_old_data').css("display","none");
				// organization section
				$('#div_organization').css("display","none");
				$('#organization_old_data').css("display","none");


				$('#div_financial').css("display","none");
				$('#financial_old_data').css("display","none");
				
				
				$('#div_benfits').css("display","none");
				$('#benefits_old_data').css("display","none");



				$("select#showHideclm5")[0].sumo.selectAll();	


				var columns =[];
				$('#showHideclm5 option:selected').each(function(i) {
			  
			    	 columns.push($(this).val());

			    });

		    	var att_cols = [];
				$.each(columns, function(index, item) {
					att_cols.push({id:item, db:tableCols5[item][0], name:tableCols5[item][1]})
				})

		    	$.ajax({
					url: "ajax/update_show_hide_clm2.php",
					data: {cols: att_cols},
					success: function(result){
					},
					error:function (xhr, ajaxOptions, thrownError){
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
							duration: 4,
						})
					}
				});
				dtable7.columns.adjust();
				dtable8.columns.adjust();


			}			
			else if(this.value  == '5')
			{
				// show contact table 
				$('#div_personal').css("display","none");
				$('#personal_old_data').css("display","none");
				// contact section
				$('#div_contacts').css("display","none");
				$('#contacts_old_data').css("display","none");
				// work data section
				$('#div_work_data').css("display","none");
				$('#work_data_old_data').css("display","none");
				// time section
				$('#div_time').css("display","none");
				$('#time_old_data').css("display","none");
				// leave section
				$('#div_leave').css("display","");
				$('#leave_old_data').css("display","");
				// organization section
				$('#div_organization').css("display","none");
				$('#organization_old_data').css("display","none");


				$('#div_financial').css("display","none");
				$('#financial_old_data').css("display","none");
				
				$('#div_benfits').css("display","none");
				$('#benefits_old_data').css("display","none");



				$("select#showHideclm6")[0].sumo.selectAll();	


				var columns =[];
				$('#showHideclm6 option:selected').each(function(i) {
			  
			    	 columns.push($(this).val());

			    });

		    	var att_cols = [];
				$.each(columns, function(index, item) {
					att_cols.push({id:item, db:tableCols6[item][0], name:tableCols6[item][1]})
				})

		    	$.ajax({
					url: "ajax/update_show_hide_clm2.php",
					data: {cols: att_cols},
					success: function(result){
					},
					error:function (xhr, ajaxOptions, thrownError){
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
							duration: 4,
						})
					}
				});
				dtable9.columns.adjust();
				dtable10.columns.adjust();

			}			
			else if(this.value  == '6')
			{
				// show contact table 
				$('#div_personal').css("display","none");
				$('#personal_old_data').css("display","none");
				// contact section
				$('#div_contacts').css("display","none");
				$('#contacts_old_data').css("display","none");
				// work data section
				$('#div_work_data').css("display","none");
				$('#work_data_old_data').css("display","none");
				// time section
				$('#div_time').css("display","none");
				$('#time_old_data').css("display","none");
				// leave section
				$('#div_leave').css("display","none");
				$('#leave_old_data').css("display","none");
				// organization section
				$('#div_organization').css("display","");
				$('#organization_old_data').css("display","");


				$('#div_financial').css("display","none");
				$('#financial_old_data').css("display","none");
				

				$('#div_benfits').css("display","none");
				$('#benefits_old_data').css("display","none");



				$("select#showHideclm7")[0].sumo.selectAll();	

				var columns =[];
				$('#showHideclm7 option:selected').each(function(i) {
			  
			    	 columns.push($(this).val());

			    });

		    	var att_cols = [];
				$.each(columns, function(index, item) {
					att_cols.push({id:item, db:tableCols7[item][0], name:tableCols7[item][1]})
				})

		    	$.ajax({
					url: "ajax/update_show_hide_clm2.php",
					data: {cols: att_cols},
					success: function(result){
					},
					error:function (xhr, ajaxOptions, thrownError){
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
							duration: 4,
						})
					}
				});
				dtable11.columns.adjust();
				dtable12.columns.adjust();
			}			
			else if(this.value  == '7')
			{
				// show contact table 
				$('#div_personal').css("display","none");
				$('#personal_old_data').css("display","none");
				// contact section
				$('#div_contacts').css("display","none");
				$('#contacts_old_data').css("display","none");
				// work data section
				$('#div_work_data').css("display","none");
				$('#work_data_old_data').css("display","none");
				// time section
				$('#div_time').css("display","none");
				$('#time_old_data').css("display","none");
				// leave section
				$('#div_leave').css("display","none");
				$('#leave_old_data').css("display","none");
				// organization section
				$('#div_organization').css("display","none");
				$('#organization_old_data').css("display","none");

				$('#div_financial').css("display","");
				$('#financial_old_data').css("display","");
				
				
				$('#div_benfits').css("display","none");
				$('#benefits_old_data').css("display","none");



				$("select#showHideclm9")[0].sumo.selectAll();	

				var columns =[];
				$('#showHideclm9 option:selected').each(function(i) {
			  
			    	 columns.push($(this).val());

			    });

		    	var att_cols = [];
				$.each(columns, function(index, item) {
					att_cols.push({id:item, db:tableCols9[item][0], name:tableCols9[item][1]})
				})

		    	$.ajax({
					url: "ajax/update_show_hide_clm2.php",
					data: {cols: att_cols},
					success: function(result){
					},
					error:function (xhr, ajaxOptions, thrownError){
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
							duration: 4,
						})
					}
				});
				dtable15.columns.adjust();
				dtable16.columns.adjust();


			}
			else if(this.value  == '8')
			{
				// show contact table 
				$('#div_personal').css("display","none");
				$('#personal_old_data').css("display","none");
				// contact section
				$('#div_contacts').css("display","none");
				$('#contacts_old_data').css("display","none");
				// work data section
				$('#div_work_data').css("display","none");
				$('#work_data_old_data').css("display","none");
				// time section
				$('#div_time').css("display","none");
				$('#time_old_data').css("display","none");
				// leave section
				$('#div_leave').css("display","none");
				$('#leave_old_data').css("display","none");
				// organization section
				$('#div_organization').css("display","none");
				$('#organization_old_data').css("display","none");

				$('#div_financial').css("display","none");
				$('#financial_old_data').css("display","none");
				
				$('#div_benfits').css("display","");
				$('#benefits_old_data').css("display","");



				$("select#showHideclm8")[0].sumo.selectAll();	

				var columns =[];
				$('#showHideclm8 option:selected').each(function(i) {
			  
			    	 columns.push($(this).val());

			    });

		    	var att_cols = [];
				$.each(columns, function(index, item) {
					att_cols.push({id:item, db:tableCols8[item][0], name:tableCols8[item][1]})
				})

		    	$.ajax({
					url: "ajax/update_show_hide_clm2.php",
					data: {cols: att_cols},
					success: function(result){
					},
					error:function (xhr, ajaxOptions, thrownError){
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
							duration: 4,
						})
					}
				});

				dtable13.columns.adjust();
				dtable14.columns.adjust();
			}
			else
			{
				var hideAllcolumn = [2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20];
					$.each(hideAllcolumn, function(key,val) {    
					 dtable.column(val).visible(false);
					 dtable2.column(val).visible(false);

				});

				$("select#showHideclm2")[0].sumo.unSelectAll();
				$("select#showHideclm3")[0].sumo.unSelectAll();
				$("select#showHideclm4")[0].sumo.unSelectAll();
				$("select#showHideclm5")[0].sumo.unSelectAll();
				$("select#showHideclm6")[0].sumo.unSelectAll();
				$("select#showHideclm7")[0].sumo.unSelectAll();
				$("select#showHideclm9")[0].sumo.unSelectAll();
				$("select#showHideclm8")[0].sumo.unSelectAll();


			}
		})


	});


	
	function getSelectedTeamEmployee(locations,divisions,departments,teams){

		//$('#datatableEmppp').DataTable().destroy();

		var empStatus = $('#empStatus').val();
		//alert(empStatus);
		$.ajax({
			type: 'POST',
			url: ROOT+"settings/ajax/up_emp_select.php",
			data: {locations: locations, divisions: divisions, departments: departments, teams: teams, empStatus:empStatus},
			success: function(result){

				window.location.reload();
			}
		})
	}



// GET DATA DIV 
function getDataDiv(){
	var selectionSelect = $('#section_select').val();

	if(selectionSelect == '1')
	{
		$('#personal_div_data').css('display','');
		$('#country_div_data').css('display','none');
		$('#work_div_data').css('display','none');
		$('#time_div_data').css('display','none');
		$('#leave_div_data').css('display','none');
		$('#organization_div_data').css('display','none');
		$('#financial_div_data').css('display','none');
		$('#benefits_div_data').css('display','none');

		// hide show dropdown display  none here 
		// show perosnal div 
		// hide other div
		$("#showHideclm2").closest("div").css('display','');
		$("#showHideclm3").closest("div").css('display','none');
		$("#showHideclm4").closest("div").css('display','none');
		$("#showHideclm5").closest("div").css('display','none');
		$("#showHideclm6").closest("div").css('display','none');
		$("#showHideclm7").closest("div").css('display','none');
		$("#showHideclm9").closest("div").css('display','none');
		$("#showHideclm8").closest("div").css('display','none');
		$(".commonhidebutton").css('display','');

		//dtable.columns.adjust();
		//dtable2.columns.adjust();
	}
	else if(selectionSelect == '2')
	{
		$('#country_div_data').css('display','');
		$('#personal_div_data').css('display','none');
		$('#work_div_data').css('display','none');
		$('#time_div_data').css('display','none');
		$('#leave_div_data').css('display','none');
		$('#organization_div_data').css('display','none');
		$('#financial_div_data').css('display','none');
		$('#benefits_div_data').css('display','none');
		$(".commonhidebutton").css('display','');



		// show contact div 
		// hide other div 

		$("#showHideclm2").closest("div").css('display','none');
		$("#showHideclm3").closest("div").css('display','');
		$("#showHideclm4").closest("div").css('display','none');
		$("#showHideclm5").closest("div").css('display','none');
		$("#showHideclm6").closest("div").css('display','none');
		$("#showHideclm7").closest("div").css('display','none');
		$("#showHideclm9").closest("div").css('display','none');
		$("#showHideclm8").closest("div").css('display','none');
		$(".commonhidebutton").css('display','');


		//dtable3.columns.adjust();
		///dtable4.columns.adjust();



	}	
	else if(selectionSelect == '3')
	{
		$('#country_div_data').css('display','none');
		$('#personal_div_data').css('display','none');
		$('#work_div_data').css('display','');
		$('#time_div_data').css('display','none');
		$('#leave_div_data').css('display','none');
		$('#organization_div_data').css('display','none');
		$('#financial_div_data').css('display','none');
		$('#benefits_div_data').css('display','none');

		$("#showHideclm2").closest("div").css('display','none');
		$("#showHideclm3").closest("div").css('display','none');
		$("#showHideclm4").closest("div").css('display','');
		$("#showHideclm5").closest("div").css('display','none');
		$("#showHideclm6").closest("div").css('display','none');
		$("#showHideclm7").closest("div").css('display','none');
		$("#showHideclm9").closest("div").css('display','none');
		$("#showHideclm8").closest("div").css('display','none');
		$(".commonhidebutton").css('display','');


		//dtable5.columns.adjust();
		//dtable6.columns.adjust();
		// hide other div 

	}	
	else if(selectionSelect == '4')
	{
		$('#country_div_data').css('display','none');
		$('#personal_div_data').css('display','none');
		$('#work_div_data').css('display','none');
		$('#time_div_data').css('display','');
		$('#leave_div_data').css('display','none');
		$('#organization_div_data').css('display','none');
		$('#financial_div_data').css('display','none');
		$('#benefits_div_data').css('display','none');

		// hide other div 

		$("#showHideclm2").closest("div").css('display','none');
		$("#showHideclm3").closest("div").css('display','none');
		$("#showHideclm4").closest("div").css('display','none');
		$("#showHideclm5").closest("div").css('display','');
		$("#showHideclm6").closest("div").css('display','none');
		$("#showHideclm7").closest("div").css('display','none');
		$("#showHideclm9").closest("div").css('display','none');
		$("#showHideclm8").closest("div").css('display','none');
		$(".commonhidebutton").css('display','');


		//dtable7.columns.adjust();
		//dtable8.columns.adjust();


	}	
	else if(selectionSelect == '5')
	{
		$('#country_div_data').css('display','none');
		$('#personal_div_data').css('display','none');
		$('#work_div_data').css('display','none');
		$('#time_div_data').css('display','none');
		$('#leave_div_data').css('display','');
		$('#organization_div_data').css('display','none');
		$('#financial_div_data').css('display','none');
		$('#benefits_div_data').css('display','none');


		// hide all div 
		$("#showHideclm2").closest("div").css('display','none');
		$("#showHideclm3").closest("div").css('display','none');
		$("#showHideclm4").closest("div").css('display','none');
		$("#showHideclm5").closest("div").css('display','none');
		$("#showHideclm6").closest("div").css('display','');
		$("#showHideclm7").closest("div").css('display','none');
		$("#showHideclm9").closest("div").css('display','none');
		$("#showHideclm8").closest("div").css('display','none');
		$(".commonhidebutton").css('display','');


		//dtable9.columns.adjust();
		//dtable10.columns.adjust();



	}	
	else if(selectionSelect == '6')
	{
		$('#country_div_data').css('display','none');
		$('#personal_div_data').css('display','none');
		$('#work_div_data').css('display','none');
		$('#time_div_data').css('display','none');
		$('#leave_div_data').css('display','none');
		$('#organization_div_data').css('display','');
		$('#financial_div_data').css('display','none');
		$('#benefits_div_data').css('display','none');


		// hide all div 
		$("#showHideclm2").closest("div").css('display','none');
		$("#showHideclm3").closest("div").css('display','none');
		$("#showHideclm4").closest("div").css('display','none');
		$("#showHideclm5").closest("div").css('display','none');
		$("#showHideclm6").closest("div").css('display','none');
		$("#showHideclm7").closest("div").css('display','');
		$("#showHideclm9").closest("div").css('display','none');
		$("#showHideclm8").closest("div").css('display','none');
		$(".commonhidebutton").css('display','none');



		//dtable11.columns.adjust();
		///dtable12.columns.adjust();


	}else if(selectionSelect == '7')
	{
		$('#country_div_data').css('display','none');
		$('#personal_div_data').css('display','none');
		$('#work_div_data').css('display','none');
		$('#time_div_data').css('display','none');
		$('#leave_div_data').css('display','none');
		$('#organization_div_data').css('display','none');
		$('#financial_div_data').css('display','');
		$('#benefits_div_data').css('display','none');
		


		// hide all div 
		$("#showHideclm2").closest("div").css('display','none');
		$("#showHideclm3").closest("div").css('display','none');
		$("#showHideclm4").closest("div").css('display','none');
		$("#showHideclm5").closest("div").css('display','none');
		$("#showHideclm6").closest("div").css('display','none');
		$("#showHideclm7").closest("div").css('display','none');
		$("#showHideclm9").closest("div").css('display','');
		$("#showHideclm8").closest("div").css('display','none');
		$(".commonhidebutton").css('display','none');


		///dtable15.columns.adjust();
		//dtable16.columns.adjust();




	}	
	else if(selectionSelect == '8')
	{
		$('#country_div_data').css('display','none');
		$('#personal_div_data').css('display','none');
		$('#work_div_data').css('display','none');
		$('#time_div_data').css('display','none');
		$('#leave_div_data').css('display','none');
		$('#organization_div_data').css('display','none');
		$('#financial_div_data').css('display','none');
		$('#benefits_div_data').css('display','');


		// hide all div 
		$("#showHideclm2").closest("div").css('display','none');
		$("#showHideclm3").closest("div").css('display','none');
		$("#showHideclm4").closest("div").css('display','none');
		$("#showHideclm5").closest("div").css('display','none');
		$("#showHideclm6").closest("div").css('display','none');
		$("#showHideclm7").closest("div").css('display','none');
		$("#showHideclm9").closest("div").css('display','none');
		$("#showHideclm8").closest("div").css('display','');
		$(".commonhidebutton").css('display','none');



		//dtable13.columns.adjust();
		//dtable14.columns.adjust();


	}
	else
	{
		$('#personal_div_data').css('display','none');
		$('#country_div_data').css('display','none');
		$('#work_div_data').css('display','none');
		$('#time_div_data').css('display','none');
		$('#leave_div_data').css('display','none');
		$('#organization_div_data').css('display','none');
		$('#financial_div_data').css('display','none');
		$('#benefits_div_data').css('display','none');
		$(".commonhidebutton").css('display','');



		// hide other div 
		$("#showHideclm2").closest("div").css('display','none');
		$("#showHideclm3").closest("div").css('display','none');
		$("#showHideclm4").closest("div").css('display','none');
		$("#showHideclm5").closest("div").css('display','none');
		$("#showHideclm6").closest("div").css('display','none');
		$("#showHideclm7").closest("div").css('display','none');
		$("#showHideclm9").closest("div").css('display','none');
		$("#showHideclm8").closest("div").css('display','none');



	}


	// set in session 

	$.ajax({
		url: "ajax/update_choosed_section_in_modify_employee.php",
		data: {selectionSelect: selectionSelect},
		success: function(result){},

		});

}


// ===============================  COMMON SCROLLBAR SCRIPT =============================== //
<?php include('section_script/common_scrollbar_script.php'); ?>
// ===============================  COMMON SCROLLBAR SCRIPT =============================== //




$(document).on("change", "#section_select", function(e) {

	if(this.value == 'Choose Section')
	{
		$('#showHideclm2').prop("disabled",true);
		$('#showHideClmss2').addClass('displayNone');
	}
	else
	{
		$('#showHideclm2').prop("disabled",false);
		$('#showHideClmss2').removeClass('displayNone');

	}
})



//========================= SUBMIT POPUP MODAL =================//

function submitPopupModal(modal)
{

	var modal_title_value = $('#modal_title_value').val(); // Title Modal  
	var modal_scanid_value = $('#scan_id_modal').val(); // Scani id  Modal  
	var modal_firstname_value = $('#modal_firstname_value').val(); // Firstname Modal  
	var modal_lastname_value = $('#modal_lastname_value').val(); // Lastname  Modal  
	var modal_englishname_value = $('#modal_englishname_value').val(); // English name  Modal  
	var modal_military_value = $('#modal_military_value').val(); // Military Modal  
	var modal_height_value = $('#modal_height_value').val(); // Height Modal  
	var modal_weight_value = $('#modal_weight_value').val(); // Weight Modal  
	var modal_blood_type_value = $('#modal_blood_type_value').val(); // Blood type  Modal  
	var modal_driving_license_value = $('#modal_driving_license_value').val(); // Driving License Modal  
	var modal_driving_license_date_value = $('#modal_driving_license_date_value').val(); // Driving License expiry Modal  
	var modal_id_card_value = $('#modal_id_card_value').val(); // Id card Modal  
	var modal_id_card_expiry_value = $('#modal_id_card_expiry_value').val(); // ID card expiry  Modal  
	var modal_tax_id_value = $('#modal_tax_id_value').val(); // Tax id Modal  
	var modal_nationality_value = $('#modal_nationality_value').val(); // Nationality Modal  
	var modal_gender_value = $('#modal_gender_value').val(); // Gender Modal  
	var modal_maritial_value = $('#modal_maritial_value').val(); // Maritial Modal  
	var modal_religion_value = $('#modal_religion_value').val(); // Religion Modal  
	var modal_birthdate_value = $('#modal_birthdate_value').val(); // Birthdate Modal  

	var updateAnything= '1' ;

	
	$.ajax({
		url: "ajax/update_batch_data/update_batch_data.php",
		data: {
			modal: modal,
			modal_title_value:modal_title_value,
			modal_scanid_value:modal_scanid_value,
			modal_firstname_value:modal_firstname_value,
			modal_lastname_value:modal_lastname_value,
			modal_englishname_value:modal_englishname_value,
			modal_military_value:modal_military_value,
			modal_height_value:modal_height_value,
			modal_weight_value:modal_weight_value,
			modal_blood_type_value:modal_blood_type_value,
			modal_driving_license_value:modal_driving_license_value,
			modal_driving_license_date_value:modal_driving_license_date_value,
			modal_id_card_value:modal_id_card_value,
			modal_id_card_expiry_value:modal_id_card_expiry_value,
			modal_tax_id_value:modal_tax_id_value,
			modal_nationality_value:modal_nationality_value,
			modal_gender_value:modal_gender_value,
			modal_maritial_value:modal_maritial_value,
			modal_religion_value:modal_religion_value,
			modal_birthdate_value:modal_birthdate_value,
			updateAnything:updateAnything,
		},
		success: function(result){
			window.location.reload();
		},

	});

}

//========================= SUBMIT POPUP MODAL =================//



// ==============================SAVE TO EMPLOYEE TABLE ======================//




function saveTpEmpsTable()
{
	// start the loader
	$(".preloader").fadeIn(400);
	// run ajax to save data in employee table 
	$.ajax({
		url: "ajax/save_temporary_data_to_employee_table.php",
		data:{},
		success: function(result){
			if(result == 'success'){
				$("body").overhang({
					type: "success",
					message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfuly']?>',
					duration: 1,
				})
				setTimeout(function(){
					window.location.reload();
				}, 500); 
			}
		},
		error:function (xhr, ajaxOptions, thrownError){
			$("body").overhang({
				type: "error",
				message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
				duration: 4,
			})
		}
	});
}
// ==============================SAVE TO EMPLOYEE TABLE ======================//



// ============================== EXPORT EXCEL FILE ==========================//

	$(document).on("click", ".exportExcel", function(e) {

		// FIRST CHECK WHICH SECTION IS SELECTED 

		var selectedSectionField = $('.getdatadivclass').val();


		// Personal Info
		if(selectedSectionField == '1'){

			// run ajax and get the fields from temp database 

			window.location.href = 'export/export_personal_info.php';
											
		} 		
		else if(selectedSectionField == '2'){

			// run ajax and get the fields from temp database 

			window.location.href = 'export/export_contacts.php';
											
		} 		
		else if(selectedSectionField == '3'){

			// run ajax and get the fields from temp database 

			window.location.href = 'export/export_work_data.php';
											
		} 		
		else if(selectedSectionField == '4'){

			// run ajax and get the fields from temp database 

			window.location.href = 'export/export_time.php';
											
		} 		
		else if(selectedSectionField == '5'){

			// run ajax and get the fields from temp database 

			window.location.href = 'export/export_leave.php';
											
		} 


		// AFTER GETTING THE SECTION GET THE SELECTED FIELDS 

		// RUN AJAX AND EXPORT THAT SECTION EXCEL FILE WITH THOSE FIELDS 
	})

// ============================== EXPORT EXCEL FILE ==========================//



//=============================== IMPORT EXCEL FILE ==========================//


	$(document).on("change", "#import_employees", function(e){

		e.preventDefault();
 		var cid = <?=json_encode($_SESSION['rego']['cid'])?>;
 		var selectedSectionFieldForImportCheck = $('.getdatadivclass').val();

 		if(selectedSectionFieldForImportCheck == '1')
 		{
 			var importFileErrorName = '_personal_info.xls';
 			var namestring = 3;
 		}	
 		else if(selectedSectionFieldForImportCheck == '2')
 		{
 			var importFileErrorName = '_contact.xls';
 			var namestring = 2;

 		} 		
 		else if(selectedSectionFieldForImportCheck == '3')
 		{
 			var importFileErrorName = '_work_data.xls';
 			var namestring = 3;

 		} 		
 		else if(selectedSectionFieldForImportCheck == '4')
 		{
 			var importFileErrorName = '_time.xls';
 			var namestring = 2;

 		} 		
 		else if(selectedSectionFieldForImportCheck == '5')
 		{
 			var importFileErrorName = '_leave.xls';
 			var namestring = 2;

 		}
		var id = cid;//.replace('x',acc);
		var ff = $(this).val().toLowerCase();

		ff = ff.replace(/.*[\/\\]/, '');
		var ext =  ff.split('.').pop();
		f = ff.substr(0, ff.lastIndexOf('.'));

		var r = f.split('_');
		console.log(r);


		//alert(ff+'-'+r+'-'+ext)
		if(!(ext == 'xls' || ext == 'xlsx')){
			$("body").overhang({
				type: "warn",
				message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Please use Excel files only .xls or .xlsx']?>',
				duration: 8,
				closeConfirm: true
			})
			return false;
		}
		if(r.length !== namestring){
			$("body").overhang({
				type: "warn",
				message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Wrong file format ! Please use']?> [ '+id+importFileErrorName+' ]',
				duration: 8,
				closeConfirm: true
			})
			return false;
		}else{
			var s1 = r[0]; // cid
			var s2 = r[1]; // Filename
			if(s1 !== id){
				$("body").overhang({
					type: "warn",
					message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['File ID does not match selected client']?> ('+s1+') ! <?=$lng['Please use']?> [ '+id+'_personal_info.xls ]',
					duration: 8,
					closeConfirm: true
				})
				return false;
			}
		}
		$("form#import").submit();
	});
			
			$(document).on("submit", "form#import", function(e){
				e.preventDefault();
				$("body").overhang({
					type: "warn",
					message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['One moment please importing employees']?>&nbsp;&nbsp;<i class="fa fa-refresh fa-spin"></i>',
					closeConfirm: "true",
					//duration: 10,
				})
				$('#impemp i').removeClass('fa-download').addClass('fa-refresh fa-spin');
				//return false;
				var dbname = <?=json_encode($_SESSION['rego']['cid'].'_temp_employee_data')?>;
 				var cid = <?=json_encode($_SESSION['rego']['cid'])?>;
				var file = $("#import_employees")[0].files[0];
				var data = new FormData($(this)[0]);

				var selectedSectionFieldForImport = $('.getdatadivclass').val();
				if(selectedSectionFieldForImport == '1')
				{
					var urlimport = 'import/import_personal_info.php';
				}				
				else if(selectedSectionFieldForImport == '2')
				{
					var urlimport = 'import/import_contacts.php';
				}				
				else if(selectedSectionFieldForImport == '3')
				{
					var urlimport = 'import/import_work_data.php';
				}				
				else if(selectedSectionFieldForImport == '4')
				{
					var urlimport = 'import/import_time.php';
				}			
				else if(selectedSectionFieldForImport == '5')
				{
					var urlimport = 'import/import_leave.php';
				}


				data.append('dbname', dbname);
				data.append('cid', cid);

				setTimeout(function(){
					$.ajax({
						url: urlimport,
						type: 'POST',
						data: data,
						async: false,
						cache: false,
						contentType: false,
						processData: false,
						success: function(result){
							//$("#dump").html(result); return false;
							//alert(result)
							$('#import_employees').val('');
							setTimeout(function(){
								$(".overhang").slideUp(200); 
								$('#impemp i').removeClass('fa-refresh fa-spin').addClass('fa-download');
							}, 800);
							setTimeout(function(){
								if($.trim(result) == 'success'){
									$("body").overhang({
										type: "success",
										message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data imported successfuly. Please wait for page reload']?> . . .',
										duration: 1,
									})

									setTimeout(function(){location.reload();}, 1000);
								}else{
									$("body").overhang({
										type: "warn",
										message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;'+result,
										closeConfirm: "true",
										duration: 5,
									})
								}
							}, 1000);
						},
						error:function (xhr, ajaxOptions, thrownError){
							$("body").overhang({
								type: "error",
								message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
								duration: 8,
								closeConfirm: "true",
							})
							$('#impemp i').removeClass('fa-refresh fa-spin').addClass('fa-download');
						}
					});
				},300);
			});



//=============================== IMPORT EXCEL FILE ==========================//


// =============================== EDIT DATATABLE COLUMN FIELD VALUES  ===================//

$(document).on("click", ".commonEditColumn", function(e){

	var textFieldArray = <?=json_encode($textFieldArray)?>;
	var dateFieldArray = <?=json_encode($dateFieldArray)?>;
	var dropdownFieldArray = <?=json_encode($dropdownFieldArray)?>;
	var allfieldsArray = <?=json_encode($allfieldsArray)?>;

	var title = <?=json_encode($title)?>;
	var gender = <?=json_encode($gender)?>;
	var maritial = <?=json_encode($maritial)?>;
	var religion = <?=json_encode($religion)?>;
	var military_status = <?=json_encode($military_status)?>;



	var classNameString = $(this).closest('td.commonEditColumn').attr('class');
	var avoid = "commonEditColumn";
	var fieldToUpdate = $.trim(classNameString.replace(avoid,''));

	var oldvalue = $(this).closest('td.commonEditColumn').html();
	var rowId = $(this).closest('tr').children('td:first').find('span#rowIdDatatableSpan').html();

	$('#hidden_row_id').val(rowId);
	$('#hidden_field_to_update').val(fieldToUpdate);

	// open modal here

	// check field type if drop down , text field or date and open common modal according to that 
	console.log(textFieldArray);

	if(jQuery.inArray(fieldToUpdate, textFieldArray) !== -1)
	{
		$('#text_field_span').html(allfieldsArray[fieldToUpdate]);
		$('#modal_edit_text_value').val(oldvalue);
		$('#modalEdit_text_field').modal('toggle');
	}	
	else if(jQuery.inArray(fieldToUpdate, dateFieldArray) !== -1)
	{
		$('#date_field_span').html(allfieldsArray[fieldToUpdate]);
		$('#modal_edit_date_value').val(oldvalue);
		$('#modalEdit_date_field').modal('toggle');
	}	
	else if(jQuery.inArray(fieldToUpdate, dropdownFieldArray) !== -1)
	{
		// append option to drop down 
		// first empty the previous values
		$('#modal_edit_dropdown_value').empty();

		// select array to show 
		if(fieldToUpdate == 'title')
		{
			var loopArray = title;
		}		
		else if(fieldToUpdate == 'gender')
		{
			var loopArray = gender;
		}		
		else if(fieldToUpdate == 'maritial')
		{
			var loopArray = maritial;
		}		
		else if(fieldToUpdate == 'religion')
		{
			var loopArray = religion;
		}		
		else if(fieldToUpdate == 'military_status')
		{
			var loopArray = military_status;
		}


		// Common append 
		 var mySelect = $('#modal_edit_dropdown_value');
         mySelect.append(
                $('<option></option>').val('select').html('Select')
            );
        $.each(loopArray, function(val, text) {

        	if(text == oldvalue)
        	{
        		var selected = "selected";
        	}

            mySelect.append(
                $('<option  '+selected+'></option>').val(val).html(text)
            );
        });


        // open modal 
		$('#dropdown_field_span').html(allfieldsArray[fieldToUpdate]);
		$('#modalEdit_drop_down').modal('toggle');
	}


});

// =============================== EDIT DATATABLE COLUMN FIELD VALUES  ===================//




$(document).on("click", ".viewTeams", function(e){
	var dataID =  $(this).closest('td').next('td.fieldColumn').next('td.batchNoColumn').find('a.viewTeamsHidden').attr("data-id");	
	var fieldValue = $(this).closest('td').next('td.fieldColumn').html();


	console.log(dataID);
	console.log(fieldValue);

	// return false;
	var title = <?=json_encode($title)?>;
	var gender = <?=json_encode($gender)?>;
	var maritial = <?=json_encode($maritial)?>;
	var religion = <?=json_encode($religion)?>;
	var military_status = <?=json_encode($military_status)?>;


	$("#viewTeamsTable > tbody").html("");

	$.ajax({
		url: "ajax/get_modal_data_to_view_teams.php",
		data:{dataID:dataID,fieldValue:fieldValue},
		success: function(result){

				var dataJson = JSON.parse(result);


				$.each(dataJson, function (key, value) 
				{
					$('#viewTeamsTable').append('<tr><td class="text-center">'+value.emp_id+'</td><td class="text-center">'+value.en_name+'</td></tr>');
				})

				$('#modalViewTeams').modal('toggle');

		},
	});

});
//======================== VIEW TEAMS MODAL OPEN  =========================//

//======================== VIEW FIELDS MODAL OPEN  =========================//

$(document).on("click", ".viewFields", function(e){

	var dataID = $(this).attr("data-id");

	$("#viewFieldsTable > tbody").html("");

	$.ajax({
		url: "ajax/get_modal_data_to_view_fields.php",
		data:{dataID:dataID},
		success: function(result){

				var dataJson = JSON.parse(result);
				var counter = '1';
				$.each(dataJson, function (key, value) 
				{
					var count= counter++ ;
					$('#viewFieldsTable').append('<tr><td class="text-center">'+value.emp_id+'</td><td class="text-center">'+value.en_name+'</td></tr>');
				})

				$('#modalViewFields').modal('toggle');

		},
	});

});

//======================== VIEW FIELDS MODAL OPEN  =========================//

//======================== VIEW ERROR DATA IN MODAL  =======================//

$(document).on("click", ".getTheErrors", function(e){

	$('#modalViewErrors').modal('toggle');
});




//======================== VIEW ERROR DATA IN MODAL  =======================//


// ============================= VERIFICATION CENTER  TAB  ========================//


// ============================== MODIFY DATA ON CLICK EDIT ========================//

function submitPopupModalEdit(valueCheck){

	var rowId = $('#hidden_row_id').val();
	var fieldToUpdate = $('#hidden_field_to_update').val();

	if(valueCheck == 'text')
	{
		var dataToUpdate = $('#modal_edit_text_value').val();
	}	
	else if(valueCheck == 'date')
	{
		var dataToUpdate = $('#modal_edit_date_value').val();
	}	
	else if(valueCheck == 'dropdown')
	{
		var dataToUpdate = $('#modal_edit_dropdown_value').val();
	}

	$.ajax({
		url: "ajax/update_on_field_edit/update_temp_employee_data_on_click.php",
		data:{rowId:rowId,fieldToUpdate:fieldToUpdate,dataToUpdate:dataToUpdate},
		success: function(result){


				$("body").overhang({
					type: "success",
					message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
					duration: 1,
				})
				setTimeout(function(){location.reload();}, 1000);

				if(valueCheck == 'text')
				{
					$('#modalEdit_text_field').modal('toggle');
				}	
				else if(valueCheck == 'date')
				{
					$('#modalEdit_date_field').modal('toggle');
				}	
				else if(valueCheck == 'dropdown')
				{
					$('#modalEdit_drop_down').modal('toggle');
				}


		},
	});

}
// ============================== MODIFY DATA ON CLICK EDIT ========================//




// ===============================  CONTACT SECTION SCRIPT  ===================//
<?php include('section_script/contact.php'); ?>
// ===============================  LEAVE SECTION SCRIPT  ===================//
<?php include('section_script/leave.php'); ?>
// ===============================  WORK DATA SECTION SCRIPT ===================//
<?php include('section_script/work_data.php'); ?>
// ===============================  TIME SECTION SCRIPT ===================//
<?php include('section_script/time.php'); ?>
// ===============================  ORGANIZATION SECTION SCRIPT ===================//
<?php include('section_script/organization.php'); ?>
//===============================  Benefit SECTION SCRIPT ===================//
<?php include('section_script/financial.php'); ?>
// ===============================  Benefit SECTION SCRIPT ===================//
<?php include('section_script/benefit.php'); ?>




</script