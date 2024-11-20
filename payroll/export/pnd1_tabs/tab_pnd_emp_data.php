<div class="row">
	<div class="col-md-3">
		<div class="searchFilter" style="margin:0">
			<input placeholder="Filter" id="searchFilter" class="sFilter" type="text">
			<button id="clearSearchbox" type="button" class="clearFilter btn btn-default btn-sm"><i class="fa fa-times"></i></button>
		</div>
	</div>
</div>
<div class="row mt-1">

	<div class="col-md-12">
		<table id="datatables11" class="dataTable hoverable selectable nowrap">
			<thead>
				<tr>
					<th><?=$lng['Emp. ID']?></th>
					<th><?=$lng['Employee name']?></th>
					<!-- <th><?=$lng['SSO'].' '.$lng['Income']?></th>
					<th><?=$lng['SSO Employee']?></th> -->
					<th class="tac" style="cursor: pointer;">
						<i data-toggle="tooltip" title="Edit" class="fa fa-edit fa-lg"></i>
					</th>
					
				</tr>
			</thead>
		</table>
	</div>

</div>
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
<script type="text/javascript">
	$(document).ready(function(){

		var datatables11 = $('#datatables11').DataTable({

			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: 10,
			filter: true,
			info: true,
			autoWidth: false,
			<?=$dtable_lang?>

		});

		$("#searchFilter").keyup(function() {
			datatables11.search(this.value).draw();

		});			

		$("#clearSearchbox").click(function() {
			$("#searchFilter").val('');
			datatables11.search('').draw();
		});

		$(document).on("change", "#pageLength", function(e) {
			if(this.value > 0){
				datatables11.page.len( this.value ).draw();
			}
		})

	});
</script>