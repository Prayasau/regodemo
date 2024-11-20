function comomonLeaveModal(field){

	var fieldToUpdate =field;
	var allfieldsArray = <?=json_encode($allfieldsArray)?>;



	$('#date_field_span_leave').html(allfieldsArray[fieldToUpdate]);
	$('#leave_hidden_field_to_update').val(fieldToUpdate);
	$('#modalEdit_date_field_leave').modal('toggle');
	



}



function submitPopupModalEditLeave(valueCheck){


		var leave_hidden_field_to_update = $('#leave_hidden_field_to_update').val();
		var modal_edit_text_value_leave = $('#modal_edit_text_value_leave').val();


		
		$.ajax({
			url: "ajax/update_batch_data/update_batch_text_leave_data.php",
			data:{fieldToUpdate:leave_hidden_field_to_update,dataToUpdate:modal_edit_text_value_leave},
			success: function(result){

					$("body").overhang({
						type: "success",
						message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
						duration: 1,
					})
					setTimeout(function(){location.reload();}, 1000);

				
					$('#modalEdit_date_field_leave').modal('toggle');
					

			},
		});
	
}

// // ===============================  COMMON TIME DATA FIELDS EDIT MODAL ===================//


// // =============================== EDIT DATATABLE COLUMN TIME DATA FIELD VALUES  ===================//

$(document).on("click", ".commonEditColumnLeave", function(e){

	var allfieldsArray = <?=json_encode($allfieldsArray)?>;
	var classNameString = $(this).closest('td.commonEditColumnLeave').attr('class');
	var avoid = "commonEditColumnLeave";
	var fieldToUpdate = $.trim(classNameString.replace(avoid,''));

	var oldvalue = $(this).closest('td.commonEditColumnLeave').html();
	var rowId = $(this).closest('tr').children('td:first').find('span#rowIdDatatableSpan').html();


	$('#leavedata_hidden_row_id').val(rowId);
	$('#leave_data_hidden_field_to_update').val(fieldToUpdate);
	$('#modal_edit_leavedata_text_value').val(oldvalue);
	$('#leavedata_dropdown_field_span').html(allfieldsArray[fieldToUpdate]);
	$('#modalEdit_leavedata_drop_down').modal('toggle');
	


});


function submitPopupModalCommonLeaveDataOnclick(valueCheck){

	var rowId = $('#leavedata_hidden_row_id').val();
	var fieldToUpdate = $('#leave_data_hidden_field_to_update').val();
	var dataToUpdate = $('#modal_edit_leavedata_text_value').val();
	

	$.ajax({
		url: "ajax/update_on_field_edit/update_temp_employee_data_for_leave_on_click.php",
		data:{rowId:rowId,fieldToUpdate:fieldToUpdate,dataToUpdate:dataToUpdate},
		success: function(result){


			
				$('#modalEdit_leavedata_drop_down').modal('toggle');

				$("body").overhang({
					type: "success",
					message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
					duration: 1,
				})
				setTimeout(function(){location.reload();}, 1000);




		},
	});

}