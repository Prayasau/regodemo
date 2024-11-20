<style type="text/css">
	#modalPNDPayroll input[type=radio] {
	    -moz-appearance: none;
	    -webkit-appearance: none;
	    -o-appearance: none;
	    outline: none;
	    content: none;
	    border-radius: 2px;
	}

	#modalPNDPayroll input[type=radio]:before {
	    font-family: "FontAwesome";
	    content: "\f00c";
	    padding: 2px;
    	font-size: 9px;
	    color: transparent !important;
	    background: #fff;
	    width: 20px;
	    height: 20px;
	    border: 1px solid #d5d3d3;
	    border-radius: 2px;
	}

	#modalPNDPayroll input[type=radio]:checked:before {
	    color: #fff !important;
	    background: #007bff !important;
	    border: 1px solid #007bff;
	    padding: 2px;
    	font-size: 9px;
    	border-radius: 2px;
	}
</style>
<h2 style="padding-right:60px">
	<i class="fa fa-wpforms"></i>&nbsp; <?=$lng['Revenue Department']?>
	<!-- <span style="display:none; font-style:italic; color:#b00; padding-left:30px" id="sAlert"><i class="fa fa-exclamation-triangle fa-mr"></i><?=$lng['Data is not updated to last changes made']?></span> -->
</h2>
<div class="main">
	<div style="padding:0 0 0 20px" id="dump"></div>

		<div class="row">
			<div class="col-md-3">
				<div class="searchFilter" style="margin:0">
					<input placeholder="Filter" id="searchFilter" class="sFilter" type="text">
					<button id="clearSearchbox" type="button" class="clearFilter btn btn-default btn-sm"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<div class="col-md-7"></div>
			<div class="col-md-2">
				<a type="button" onclick="openPNDmdl()" class="btn btn-primary btn-fr">
					<i class="fa fa-plus"></i> <?=$lng['Add Form']?>
				</a>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8">
				<table id="SS0datatable" class="dataTable nowrap" style="width:100%">
					<thead>
					<tr>
						<th><?=$lng['Revenue Department'].' '.$lng['ID']?></th>
						<th style="width:1px; text-align:center !important"><i class="fa fa-edit fa-lg"></i></th>
						<th><?=$lng['Description']?></th>
						<th><?=$lng['PND form']?></th>
						<th><?=$lng['Month']?></th>
						<th><?=$lng['Date submitted']?></th>
						<th><?=$lng['Status']?></th>
					</tr>
					</thead>
					<tbody>
						<tr>
							<td class="pl-2 font-weight-bold"><?='RD-'.time()?></td>
							<td>
								<a title="Edit" onclick="window.location.href='index.php?mn=432'"><i class="fa fa-edit fa-lg"></i></a>
							</td>
							<td>Revenue Department Test</td>
							<td>PND1</td>
							<td><?=date('M')?></td>
							<td><?=date('d-m-Y')?></td>
							<td>Active</td>
													
						</tr>
					</tbody>
				</table>
				<div class="row">
					<div class="col-md-2" style="margin: -30px 0px 0px 0px;margin-left: auto;margin-right: auto;">
						<select id="pageLength" class="button btn-fl">
							<option selected="" value="">Rows / page</option>
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

			<div class="col-md-4" style=" height:calc(100% - 25px); overflow-x:auto; padding-top:0">

				<div class="notify_box">
					<h2 style="font-family:<?php echo $savedDefaultFonts[$savedMainDashboardlayout['main_font_settings_box']]?>;background:<?php echo $savedAdminColors[$savedMainDashboardlayout['maincolorSelect15']]['code'].'!important' ;?>"><i class="fa fa-bell"></i>&nbsp; <?=$lng['Payroll models no SSO report submitted']?></h2>
					<div class="inner" style="height: calc(100vh - 60vh);overflow-y: auto;">
						<span style="font-family:<?php echo $savedDefaultFonts[$savedMainDashboardlayout['main_font_settings_box_content']]?>;">
							<? /*if(checkEmployeesForPayroll($cid)){
								echo checkEmployeesForPayroll($cid);
							}else{
								echo '<b><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;'.$lng['All employees are set for Payroll'].'</b>';
							}*/?>
						</span>
					</div>
				</div>

				<div class="notify_box">
					<h2 style="font-family:<?php echo $savedDefaultFonts[$savedMainDashboardlayout['main_font_settings_box']]?>;background:<?php echo $savedAdminColors[$savedMainDashboardlayout['maincolorSelect15']]['code'].'!important' ;?>"><i class="fa fa-bell"></i>&nbsp; <?=$lng['Employees no SSO report submitted']?></h2>
					<div class="inner" style="height: calc(100vh - 60vh);overflow-y: auto;">
						<span style="font-family:<?php echo $savedDefaultFonts[$savedMainDashboardlayout['main_font_settings_box_content']]?>;">
							<?/* if(checkEmployeesForPayroll($cid)){
								echo checkEmployeesForPayroll($cid);
							}else{
								echo '<b><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;'.$lng['All employees are set for Payroll'].'</b>';
							}*/?>
						</span>
					</div>
				</div>

			</div>
		</div>

</div>

<!-- Modal RD for PND 1/3 -->
<!--<div class="modal fade" id="modalPNDPayroll" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" >
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-wpforms"></i>&nbsp; <?=ucwords($lng['PND form'])?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="basicTable" border="0" style="width: 100%;">
					<thead>
						<tr>
							<th class="tal pl-4"><?=$lng['PND form']?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<input type="radio" name="choosePND[]" value="pnd1" class="mr-2"> PND1
							</td>
						</tr>											
						<tr>
							<td>
								<input type="radio" name="choosePND[]" value="pnd3" class="mr-2"> PND3
							</td>
						</tr>
					</tbody>			
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$lng['Cancel']?></button>
				<button type="button" onclick="window.location.href='index.php?mn=432'" class="btn btn-primary"><?=$lng['Save']?></button>
			</div>
		</div>
	</div>
</div>-->

<!-- Modal RD for PND 1/3 -->

<script type="text/javascript">

	function openPNDmdl(){

		//$('#modalPNDPayroll').modal('toggle');
		window.location.href='index.php?mn=432';
	}

	$(document).ready(function() {
		var dtablesso = $('#SS0datatable').DataTable({

			scrollX: true,
			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: 10,
			filter: true,
			info: true,
			<?=$dtable_lang?>
			/*columnDefs: [
				{"targets": eCols, "visible": false, "searchable": false}
			]*/

		});

		$("#searchFilter").keyup(function() {
			dtablesso.search(this.value).draw();
		});

		$("#clearSearchbox").click(function() {
			$("#searchFilter").val('');
			dtablesso.search('').draw();
		});	

		$(document).on("change", "#pageLength", function(e) {
			if(this.value > 0){
				dtablesso.page.len( this.value ).draw();
			}
		});

	});
</script>