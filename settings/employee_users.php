<?
	
	//$emp_status['incomplete'] = $lng['in-Complete'];
	//$empStatusCount = getEmployeeStatus($cid);
	//var_dump($empStatusCount);
	//foreach($emp_status as $k=>$v){
		//$emp_status[$k] = $v.' ('.$empStatusCount[$k].')';
	//}
	//var_dump($emp_status); exit;

	//var_dump(generateStrongPassword(8, false));
	/*Your password should contain atleast one upper case, one lower case, one digit[0-9], 
   one special character[#?!@$%^&*-] and the minimum length should be 8 characters.*/

?>
	
	<h2><i class="fa fa-user">
		</i>&nbsp; <?=$lng['Employee users']?>
		<div style="padding:0 40px 0 0; white-space:nowrap; float:right; font-size:15px; color:#333">
			<b>URL : </b><b style="color:#c00; font-size:15px"><?=ROOT.'mob'?></b>
		</div>
	</h2>

	<div class="main">
		<div style="padding:0 0 0 20px" id="dump"></div>

		<form id="import" name="import" enctype="multipart/form-data" style="visibility:hidden; height:0; margin:0; padding:0">
			<input style="visibility:hidden" id="import_employees" type="file" name="file" />
		</form>

		<table style="width:100%; margin-bottom:8px">
			<tr>
				<td>
					<div class="searchFilter" style="margin:0">
						<input placeholder="Filter" id="searchFilter" class="sFilter" type="text" />
						<button id="clearSearchbox" type="button" class="clearFilter btn btn-default btn-sm"><i class="fa fa-times"></i></button>
					</div>
				</td>
			</tr>
		</table>
         
		 <div id="showTable" >
			<table id="datatable" class="dataTable compact nowrap" width="100%">
				<thead>
				<tr>
					<th class="tac par30"><?=$lng['ID']?></th>
					<th data-sortable="false" style="width:1px;" class="tac vam nopad"><i class="fa fa-user fa-lg"></i></th>
					<th class="pad30"><?=$lng['Name']?></th>
					<th data-sortable="false"><?=$lng['Username']?></th>
					<th data-sortable="false"><?=$lng['Status']?></th>
					<th class="tac" data-sortable="false"><?=$lng['Access']?></th>
					<th data-sortable="false"><?=$lng['Change password']?></th>
				</tr>
				</thead>

			</table>
			<input type="hidden" id="incomplete" value="0" />
		</div>
			
	</div>
	
	<script type="text/javascript">
		
		//var headerCount = 1;
		var last_id = null;
		
		$(document).ready(function() {

			var dtable = $('#datatable').DataTable({
				scrollY:        false,
				scrollX:        true,
				scrollCollapse: false,
				fixedColumns:   false,
				lengthChange:  	false,
				searching: 		true,
				ordering: 		true,
				paging: 		false,
				//pageLength: 	rows,
				filter: 		true,
				info: 			false,
				//autoWidth:		false,
				<?=$dtable_lang?>
				processing: 	true,
				serverSide: 	true,
				//order: [0, 'desc'],
				ajax: {url: "ajax/server_get_employee_users.php"},
				columnDefs: [
					  {"targets": [1], "class": 'pad1' },
					  //{"targets": [3,8], "class": 'tac' },
					  {"targets": [5], "class": 'nopad' },
					  {"targets": [6],"width": '60%'},
					  //{"targets": '_all',"searchable": false},
					  //{"targets": eCols,"visible": false}
				],
				initComplete : function( settings, json ) {
					$('#showTable').fadeIn(200);
					dtable.columns.adjust().draw();
				}
			});

			$("#searchFilter").keyup(function() {
				var s = $(this).val();
				dtable.search(s).draw();
			});
			$(document).on("click", "#clearSearchbox", function(e) {
				$('#searchFilter').val('');
				dtable.search('').draw();
			})
			
			$(document).on("change", ".allow_login", function(e) {
				var val = this.value;
				var id = $(this).closest('tr').find('.emp_id').html();
				var username = $(this).closest('tr').find('.username').html();
				if(username == ''){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;Username can not be empty.',
						duration: 2,
					})
					dtable.ajax.reload(null, false);
					return false;
				}
				if(val){
					$.ajax({
						url: "ajax/update_employee_user.php",
						data: {id: id, username: username, val: val},
						success: function(result){
							//$("#dump").html(result); return false;
							dtable.ajax.reload(null, false);
							if(result == 'updated'){
								$("body").overhang({
									type: "success",
									message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;This user exist already. ID and picture updated<? //=$lng['xxx']?>',
									duration: 3,
								})
							}else if(result == 'success'){
								$("body").overhang({
									type: "success",
									message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Employee updated successfuly']?>',
									duration: 2,
								})
							}else{
								$("body").overhang({
									type: "error",
									message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+result,
									duration: 4,
									//closeConfirm: true
								})
							}
						},
						error:function (xhr, ajaxOptions, thrownError){
							$("body").overhang({
								type: "error",
								message: '<i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
								duration: 4,
							})
						}
					})
				}
				/*if(!val){
					alert()
					$.ajax({
						url: "ajax/delete_employee_user.php",
						data: {id: id, username: username, val: val},
						success: function(result){
							//$("#dump").html(result); return false;
							$("body").overhang({
								type: "success",
								message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Employee updated successfuly']?>',
								duration: 2,
							})
							dtable.ajax.reload(null, false);
						}
					})
				}*/
			})
			
		})
	
	</script>























