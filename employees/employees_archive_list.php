<?php
	unset($_SESSION['rego']['empID']);

	$sbranches = str_replace(',', "','", $_SESSION['rego']['sel_branches']);
	$sdivisions = str_replace(',', "','", $_SESSION['rego']['sel_divisions']);
	$sdepartments = str_replace(',', "','", $_SESSION['rego']['sel_departments']);
	$steams = str_replace(',', "','", $_SESSION['rego']['sel_teams']);
	$where = "branch IN ('".$sbranches."')";
	$where .= " AND division IN ('".$sdivisions."')";
	$where .= " AND department IN ('".$sdepartments."')";
	$where .= " AND team IN ('".$steams."')";
	$where .= " AND emp_status != '1'";

	$ArchiveEmp = array();
	$archiveSql = "SELECT * FROM ".$cid."_employees WHERE ".$where." ";
	if($archiveSqlres = $dbc->query($archiveSql)){
		if($archiveSqlres->num_rows > 0){
			while($row = $archiveSqlres->fetch_assoc()){

				//check employee in payroll or not

				$ArchiveEmp[] = $row;
			}
		}
	}


	// echo '<pre>';
	// print_r($ArchiveEmp);
	// echo '</pre>';
	// exit;

	//var_dump($fix_allow);
	$sCols = getEmployeeColumns();
	//var_dump($sCols);
	//$emp_status[7] = $lng['in-Complete'];
	$empStatusCount = getEmployeeStatus($cid);
	//var_dump($empStatusCount); exit;
	foreach($emp_status as $k=>$v){
		$emp_status[$k] = $v.' ('.$empStatusCount[$k].')';
	}

?>

<h2><i class="fa fa-archive fa-mr"></i> <?=$lng['Archive center']?></h2>

<div class="main">
		
		<div style="padding:0 0 0 20px" id="dump"></div>

		<div id="showTable" style="display:none">

			<table style="width:100%; margin-bottom:8px">
				<tr>
					<td>
						<div class="searchFilter" style="margin:0">
							<input placeholder="<?=$lng['Filter']?>" id="searchFilter" class="sFilter" type="text" />
							<button id="clearSearchbox" type="button" class="clearFilter btn btn-default btn-sm"><i class="fa fa-times"></i></button>
						</div>
					</td>
					<td style="padding-left:5px">
						<select id="statFilter" class="button" style="margin:0">
							<option selected value=""><?=$lng['All employees']?></option>
							<? foreach($emp_status as $k=>$v){
									echo '<option';
									//if($k == 1){echo ' selected';}
									echo ' value="'.$k.'">'.$v.'</option>';
								} ?>
						</select>
					</td>
					<td style="padding-left:5px">
						<select id="pageLength" class="button">
							<option selected value=""><?=$lng['Rows / page']?></option>
							<option value="10">10 <?=$lng['Rows / page']?></option>
							<option value="15">15 <?=$lng['Rows / page']?></option>
							<option value="20">20 <?=$lng['Rows / page']?></option>
							<option value="30">30 <?=$lng['Rows / page']?></option>
							<option value="40">40 <?=$lng['Rows / page']?></option>
							<option value="50">50 <?=$lng['Rows / page']?></option>
						</select>
					</td>
					<td style="width:80%"></td>
					
					<td style="padding-left:5px">
						<button onclick="openArchiveModel()" type="button" class="btn btn-primary"><i class="fa fa-archive fa-mr"></i> <?=$lng['Archive']?> <?=$lng['Employee']?></button>
					</td>
					<td style="padding-left:5px">
						<button id="impemp" onclick="OpenDelModal()" type="button" class="btn btn-primary"><i class="fa fa-user"></i>&nbsp; <?=$lng['Delete']?> <?=$lng['Employee']?></button>	
					</td>
					<td style="padding-left:5px">
						<button onclick="OpenuseEmpModal()" type="button" class="btn btn-primary"><i class="fa fa-user"></i>&nbsp; <?=$lng['Use']?> <?=$lng['Employee']?></button>
					</td>
				</tr>
			</table>

			<table id="datatable" class="dataTable nowrap" style="width:100%">
				<thead>
				<tr>
					<th class="tac" style="min-width:50px"><?=$lng['ID']?></th>
					<th class="tac" data-sortable="false"><i class="fa fa-cog fa-lg"></i></th>
					<th data-sortable="false" style="width:1px; text-align:center !important"><i class="fa fa-user fa-lg"></i></th>
					<th style="width:90%"><?=$lng['Name']?></th>
					<th data-sortable="false"><?=$lng['Company']?></th>
					<th data-sortable="false"><?=$parameters[1][$lang]?></th>
					<th data-sortable="false"><?=$parameters[2][$lang]?></th>
					<th data-sortable="false"><?=$parameters[3][$lang]?></th>
					<th data-sortable="false"><?=$parameters[4][$lang]?></th>
					<th data-sortable="false"><?=$lng['Position']?></th>
					<th data-sortable="false"><?=$lng['Joining date']?></th>
					<th data-sortable="false"><?=$lng['Personal phone']?></th>
					<th data-sortable="false"><?=$lng['Personal email']?></th>
					<!--<th data-sortable="false"><?=$lng['Payroll status']?></th>-->
					<th data-sortable="false"><?=$lng['Status']?></th>
				</tr>
				</thead>
				<tbody>
				
				</tbody>
			</table>
		</div>
</div>

<div class="modal fade" id="modalarchive" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-user"></i>&nbsp; <?=ucwords($lng['Archive'])?> <?=$lng['Employee']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body modal-tabs">
				<table class="basicTable" border="0" style="width: 100%;">
					<thead>
						<tr>
							<th class="tal"><?=$lng['ID']?></th>
							<th class="tal"><?=$lng['Name']?></th>
							<th class="tal"><?=$lng['Position']?></th>
							<th class="tal"><?=$parameters[2][$lang]?></th>
							<th class="tal"><?=$lng['Team']?></th>
						</tr>
					</thead>
					<tbody>
						<? if(isset($ArchiveEmp) && is_array($ArchiveEmp)){ 
							foreach($ArchiveEmp as $row){ ?>
								<tr>
									<td><?=$row['emp_id']?></td>
									<td><?=$row[$lang.'_name']?></td>
									<td><?=$positions[$row['position']][$lang]?></td>
									<td><?=$departments[$row['department']][$lang]?></td>
									<td><?=$teams[$row['team']][$lang]?></td>
								</tr>
						<? } } ?>
					</tbody>
				</table>

				<div class="clear mt-3"></div>	
				<button class="btn btn-primary mr-1 btn-fr" type="button" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp; <?=$lng['Cancel']?></button>
				
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalDelarchive" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-user"></i>&nbsp; <?=ucwords($lng['Delete'])?> <?=$lng['Employee']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body modal-tabs p-4">

				<form id="DelEmpForm" method="post">

					<input type="hidden" id="EmpdeluserIds" name="EmpdelIds" value="">
					<h5 class="text-danger text-center"><?=$lng['Archive Remove Text']?></h5>


					<div class="clear" style="height:15px"></div>

					<button id="DelEmpf" class="btn btn-danger btn-fr ml-1" type="button"><i class="fa fa-times"></i>&nbsp; <?=$lng['OK']?></button>
					
					<button class="btn btn-primary mr-1 btn-fr" type="button" data-dismiss="modal"><?=$lng['Cancel']?></button>
					<div class="clear"></div>

				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalUseEmp" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-user"></i>&nbsp; <?=ucwords($lng['Use'])?> <?=$lng['Employee']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body modal-tabs p-4">

				<form id="UseempForm" method="post">

					<input type="hidden" name="EmpIds" id="useEmpIds">
					<h5 class="text-danger text-center"><?=$lng['Archive Use emp Text']?></h5>


					<div class="clear" style="height:15px"></div>

					<button id="btnUseempForm" class="btn btn-primary btn-fr ml-1" type="button"><i class="fa fa-save"></i>&nbsp; <?=$lng['OK']?></button>
					
					<button class="btn btn-primary mr-1 btn-fr" type="button" data-dismiss="modal"><?=$lng['Cancel']?></button>
					<div class="clear"></div>

				</form>
			</div>
		</div>
	</div>
</div>


<script>

	function openArchiveModel(){

		$('#modalarchive').modal('toggle');
	}

	function OpenDelModal(){

		var checkedVals = $('.getSelChk:checkbox:checked').map(function() {
		    return this.value;
		}).get();
		
		var itemList = checkedVals.join(",");
		if(itemList !=''){
			$('#modalDelarchive #EmpdeluserIds').val(itemList);
			$('#modalDelarchive').modal('toggle');
		}
	}

	function OpenuseEmpModal(){

		var checkedVals = $('.getSelChk:checkbox:checked').map(function() {
		    return this.value;
		}).get();
		
		var itemList = checkedVals.join(",");
		if(itemList !=''){

			$('#modalUseEmp #useEmpIds').val(itemList);
			$('#modalUseEmp').modal('toggle');
		}
	}

	
	$("#DelEmpf").on('click', function(e){
		var err = 0;
		if($('#DelEmpForm input[name="EmpdelIds"]').val() == ''){err = 1;}
		if(err){
			$("body").overhang({
				type: "error",
				message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Please select'].' '.$lng['Employee']?>: ',
				duration: 4,
			})
			return false;
		}

		var empid = $('#DelEmpForm input[name="EmpdelIds"]').val();
		$.ajax({
			url: "ajax/update_archive_del.php",
			type: "POST", 
			data: {empid:empid},
			success: function(data){
				$("body").overhang({
					type: "success",
					message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data removed successfully']?>',
					duration: 2,
					callback: function(v){
						location.reload();
					}
				})
			},
			error:function (xhr, ajaxOptions, thrownError){
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
					duration: 4,
				})
			}

		})

	});

	$("#btnUseempForm").on('click', function(e){
		var err = 0;
		if($('#UseempForm input[name="EmpIds"]').val() == ''){err = 1;}
		if(err){
			$("body").overhang({
				type: "error",
				message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Please select'].' '.$lng['Employee']?>: ',
				duration: 4,
			})
			return false;
		}

		var empid = $('#UseempForm input[name="EmpIds"]').val();
		$.ajax({
			url: "ajax/use_archive_emp.php",
			type: "POST", 
			data: {empid:empid},
			success: function(data){
				$("body").overhang({
					type: "success",
					message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
					duration: 2,
					callback: function(v){
						location.reload();
					}
				})
			},
			error:function (xhr, ajaxOptions, thrownError){
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
					duration: 4,
				})
			}

		})

	});

	
	var height = window.innerHeight-303;
	var headerCount = 1;
	$(document).ready(function() {

		var cid = <?=json_encode($_SESSION['rego']['cid'])?>;
		var year = <?=json_encode($_SESSION['rego']['cur_year'])?>;
		var month = <?=json_encode(sprintf('%02d', $_SESSION['rego']['cur_month']))?>;
		var dbname = <?=json_encode($_SESSION['rego']['cid'].'_employees')?>;
		var sCols = <?=json_encode($sCols)?>;
		var rows = Math.floor(height/29.64);


			$(document).on('click', '.hover-bold', function(e) {
				var id = $(this).closest('tr').find('td:eq(0)').text();
				var view = 'archive';
				$.ajax({
					url: "ajax/session_employee_id.php",
					data: {id: id, view:view},
					success: function(result){
						//$('#dump').html(result); return false;
						window.location.href="index.php?mn=1021";
					}
				});
			})

			var dtable = $('#datatable').DataTable({
				scrollY:        false,
				scrollX:        true,
				scrollCollapse: false,
				fixedColumns:   false,
				lengthChange:  false,
				searching: true,
				ordering: true,
				order: [0, 'asc'],
				paging: true,
				pagingType: 'full_numbers',
				pageLength: rows,
				filter: true,
				info: true,
				<?=$dtable_lang?>
				processing: false,
				serverSide: true,
				//autoWidth: true,
				ajax: {
					url: "ajax/server_get_archive_employees.php",
					type: 'POST',
					"data": function(d){
						d.status = $('#statFilter').val();
						
					}
				},
				columnDefs: [
					{"targets": [2], "class": 'pad1' },
					//{"targets": [0,2], "class": 'hover-bold' },
					//{"targets": [3], "width": '80%' },
					//{"targets": sCols, "visible": true },
				],
				createdRow: function (row, data, dataIndex) {
			         row.children[0].classList.add("hover-bold");
			         row.children[3].classList.add("hover-bold");
	     		},
				initComplete : function( settings, json ) {
					$('#showTable').fadeIn(200);
					dtable.columns.adjust().draw();
				}
			});
			// setTimeout(function(){
			// 	$("#statFilter").trigger('change');
			// },50);

			$("#searchFilter").keyup(function() {
				var s = $(this).val();
				//alert(s);
				dtable.search(s).draw();
			});
			$(document).on("click", "#clearSearchbox", function(e) {
				$('#searchFilter').val('');
				dtable.search('').draw();
			})
			$(document).on("change", "#statFilter", function(e) {
				dtable.ajax.reload(null, false);
			})
			$(document).on("change", "#pageLength", function(e) {
				if(this.value > 0){
					dtable.page.len( this.value ).draw();
				}
			})


	});
</script>