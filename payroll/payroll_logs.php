<h2 style="padding-right:60px">
	<i class="fa fa-history"></i>&nbsp; <?=$lng['Payroll log history']?>
</h2>

<div class="main">
	<div style="padding:0 0 0 20px" id="dump"></div>

	<div class="row mb-2">
		<div class="col-md-3">
			<div class="searchFilter" style="margin:0">
				<input placeholder="Filter" id="searchFilter" class="sFilter" type="text">
				<button id="clearSearchbox" type="button" class="clearFilter btn btn-default btn-sm"><i class="fa fa-times"></i></button>
			</div>
		</div>
		<div class="col-md-7"></div>
		<div class="col-md-2"></div>
	</div>

	<table id="payroll_log" class="dataTable hoverable selectable">
		<thead>
			<tr>
				<th class="tal"><?=$lng['Payroll']?>&nbsp;<?=$lng['ID']?></th>
				<th class="tal"><?=$lng['Payroll model ID']?></th>
				<th class="tal"><?=$lng['Employee name']?></th>
				<th class="tal"><?=$lng['Field']?></th>
				<th class="tal"><?=$lng['Previous value']?></th>
				<th class="tal"><?=$lng['Current value']?></th>
				<th class="tal"><?=$lng['Date']?></th>
				<th class="tal"><?=$lng['Changed by']?></th>
			</tr>
		</thead>
		<tbody>

		</tbody>
	</table>

	<div class="row">
		<div class="col-md-2" style="margin: -30px 0px 0px 0px;margin-left: auto;margin-right: auto;">
			<select id="pageLength" class="button btn-fl">
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
<script type="text/javascript">
	
	$(document).ready(function() {

		var payrollog = $('#payroll_log').DataTable({
			//scrollX: true,
			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: 15,
			filter: true,
			info: true,
			<?=$dtable_lang?>
			
		});

		$("#searchFilter").keyup(function() {
			payrollog.search(this.value).draw();
		});
		$("#clearSearchbox").click(function() {
			$("#searchFilter").val('');
			payrollog.search('').draw();
		});

		$(document).on("change", "#pageLength", function(e) {
			if(this.value > 0){
				payrollog.page.len( this.value ).draw();
			}
		});

	});
</script>
