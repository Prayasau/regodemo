<h2><i class="fa fa-history fa-mr"></i> <?=$lng['Log History']?></h2>

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
				</tr>
			</table>

			<table class="basicTable" id="logTable">
				<thead>
					<tr>
						<th><?=$lng['ID']?></th>
						<th><?=$lng['Employee name']?></th>
						<th><?=$lng['Field']?></th>
						<th><?=$lng['Previous value']?></th>
						<th><?=$lng['Current value']?></th>
						<th><?=$lng['Date']?></th>
						<th><?=$lng['Changed by']?></th>
					</tr>
				</thead>
				<tbody>
						

				</tbody>
			</table>
		</div>

</div>
<script>
		
	$(document).ready(function() {

		//var emp_id = <?=json_encode($_SESSION['rego']['empID'])?>;

		var logTable = $('#logTable').DataTable({
			scrollY: false,
			scrollX: false,
			//scrollCollapse: false,
			//fixedColumns:   true,
			lengthChange: false,
			searching: true,
			ordering: true,
			paging: true,
			pageLength: 12,
			filter: true,
			info: false,
			<?=$dtable_lang?>
			processing: false,
			serverSide: true,
			order: [5, 'desc'],
			ajax: {
				url: ROOT+"employees/ajax/server_get_log.php",
				type: 'POST',
				
			},
			columnDefs: [
				  //{"targets": [1], "class": 'pad1' },
				  //{"targets": [3], "width": '80%' },
				  //{"targets": sCols, "visible": true },
			],
			initComplete : function( settings, json ) {
				$('#showTable').fadeIn(400);
				logTable.columns.adjust().draw();
			}
		});


		$("#searchFilter").keyup(function() {
			var s = $(this).val();
			//alert(s);
			logTable.search(s).draw();
		});
		$(document).on("click", "#clearSearchbox", function(e) {
			$('#searchFilter').val('');
			logTable.search('').draw();
		})

	});
</script>