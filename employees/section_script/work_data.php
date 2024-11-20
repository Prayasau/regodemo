// =============================== EDIT DATATABLE COLUMN WORK DATA FIELD VALUES  ===================//

$(document).on("click", ".commonEditColumnWork", function(e){

	var textFieldArray = <?=json_encode($textFieldWorkData)?>;
	var dropdownFieldArray = <?=json_encode($dropdownFieldWorkDataArray)?>;
	var allfieldsArray = <?=json_encode($allfieldsArray)?>;
	var emp_type = <?=json_encode($emp_type)?>;
	var getAllGroups = <?=json_encode($getAllGroups)?>;
	var accountCodeArray = <?=json_encode($accountCodeArray)?>;


	var classNameString = $(this).closest('td.commonEditColumnWork').attr('class');
	var avoid = "commonEditColumnWork";
	var fieldToUpdate = $.trim(classNameString.replace(avoid,''));

	var oldvalue = $(this).closest('td.commonEditColumnWork').html();
	var rowId = $(this).closest('tr').children('td:first').find('span#rowIdDatatableSpan').html();


	$('#workdata_hidden_row_id').val(rowId);
	$('#workdata_hidden_field_to_update_edit').val(fieldToUpdate);

	// open modal here

	// check field type if drop down , text field or date and open common modal according to that 

	if(jQuery.inArray(fieldToUpdate, textFieldArray) !== -1)
	{
		$('#workdata_text_field_span_edit').html(allfieldsArray[fieldToUpdate]);
		$('#modal_edit_workdata_text_value_edit').val(oldvalue);
		$('#modal_workdata_common_text_edit').modal('toggle');
	}		
	else if(jQuery.inArray(fieldToUpdate, dropdownFieldArray) !== -1)
	{
		// append option to drop down 
		// first empty the previous values
		$('#modal_edit_workdata_dropdown_value').empty();

		// // select array to show 
		if(fieldToUpdate == 'emp_type')
		{
			var loopArray = emp_type;
		} 
		else if(fieldToUpdate == 'account_code')
		{
			var loopArray = accountCodeArray;
		}		
		else if(fieldToUpdate == 'groups')
		{
			var loopArray = getAllGroups;
		}



		// Common append 
		 var mySelect = $('#modal_edit_workdata_dropdown_value');
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
		$('#workdata_dropdown_field_span').html(allfieldsArray[fieldToUpdate]);
		$('#modalEdit_workdata_drop_down').modal('toggle');
	}


});


function submitPopupModalCommonWorkDataOnclick(valueCheck){

	var rowId = $('#workdata_hidden_row_id').val();
	var fieldToUpdate = $('#workdata_hidden_field_to_update_edit').val();

	if(valueCheck == 'text')
	{
		var dataToUpdate = $('#modal_edit_workdata_text_value_edit').val();
	}	
	else if(valueCheck == 'dropdown')
	{
		var dataToUpdate = $('#modal_edit_workdata_dropdown_value').val();
	}

	$.ajax({
		url: "ajax/update_on_field_edit/update_temp_employee_data_for_workdata_on_click.php",
		data:{rowId:rowId,fieldToUpdate:fieldToUpdate,dataToUpdate:dataToUpdate},
		success: function(result){


				if(valueCheck == 'text')
				{
					$('#modal_workdata_common_text_edit').modal('toggle');
				}	
				else if(valueCheck == 'dropdown')
				{
					$('#modalEdit_workdata_drop_down').modal('toggle');
				}


				$("body").overhang({
					type: "success",
					message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
					duration: 1,
				})
				 setTimeout(function(){location.reload();}, 1000);




		},
	});

}

// =============================== EDIT DATATABLE COLUMN WORKD DATA FIELD VALUES  ===================//




// ===============================  COMMON WORK DATA FIELDS EDIT MODAL ===================//

function comomonWorkDataModal(field,valueCheck){

	if(field == 'groups')
	{
		var fieldToUpdate = 'groups';
	}
	else
	{
		var fieldToUpdate =field;
	}

	var allfieldsArray = <?=json_encode($allfieldsArray)?>;

	if(valueCheck == 'date')
	{
		// open date work data common modal

		$('#date_field_span_work_data').html(allfieldsArray[fieldToUpdate]);
		$('#work_data_hidden_field_to_update').val(fieldToUpdate);
		$('#modalEdit_date_field_work_data').modal('toggle');


	}	
	else if(valueCheck == 'dropdown')
	{
		$('#dropdown_field_span_work_data').html(allfieldsArray[fieldToUpdate]);
		$('#work_data_hidden_field_to_update_dropdown').val(fieldToUpdate);


		if(fieldToUpdate == 'emp_type')
		{
			$('#modal_edit_dropdown_value_work_data').removeClass('displayNone');
			$('#modal_edit_dropdown_value_account_work_data').addClass('displayNone');
			$('#modal_edit_dropdown_value_groups_work_data').addClass('displayNone');


		}		
		else if(fieldToUpdate == 'account_code')
		{
			$('#modal_edit_dropdown_value_work_data').addClass('displayNone');
			$('#modal_edit_dropdown_value_account_work_data').removeClass('displayNone');
			$('#modal_edit_dropdown_value_groups_work_data').addClass('displayNone');

		}		
		else if(fieldToUpdate == 'groups')
		{
			$('#modal_edit_dropdown_value_work_data').addClass('displayNone');
			$('#modal_edit_dropdown_value_account_work_data').addClass('displayNone');
			$('#modal_edit_dropdown_value_groups_work_data').removeClass('displayNone');
		}

		$('#modalEdit_dropdown_field_work_data').modal('toggle');


	}


}



function submitPopupModalEditWorkdata(valueCheck){


	if(valueCheck == 'date')
	{

		var work_data_hidden_dropdown_field_to_update = $('#work_data_hidden_field_to_update').val();
		var modal_edit_date_value_work_data = $('#modal_edit_date_value_work_data').val();

		$.ajax({
			url: "ajax/update_batch_data/update_batch_date_data_work_data.php",
			data:{fieldToUpdate:work_data_hidden_dropdown_field_to_update,dataToUpdate:modal_edit_date_value_work_data},
			success: function(result){

					$("body").overhang({
						type: "success",
						message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
						duration: 1,
					})
					setTimeout(function(){location.reload();}, 1000);

				
					$('#modalEdit_date_field_work_data').modal('toggle');
					

			},
		});
	}
	else if(valueCheck == 'dropdown')
	{
		var work_data_hidden_dropdown_field_to_update = $('#work_data_hidden_field_to_update_dropdown').val();

		if(work_data_hidden_dropdown_field_to_update == 'emp_type')
		{
			var modal_edit_date_value_work_data = $('#modal_edit_dropdown_value_work_data').val();
		}
		else if(work_data_hidden_dropdown_field_to_update == 'account_code'){

			var modal_edit_date_value_work_data = $('#modal_edit_dropdown_value_account_work_data').val();
		}		
		else if(work_data_hidden_dropdown_field_to_update == 'groups'){

			var modal_edit_date_value_work_data = $('#modal_edit_dropdown_value_groups_work_data').val();
			var work_data_hidden_dropdown_field_to_update = 'groups';
		}



		$.ajax({
			url: "ajax/update_batch_data/update_batch_date_data_work_data.php",
			data:{fieldToUpdate:work_data_hidden_dropdown_field_to_update,dataToUpdate:modal_edit_date_value_work_data},
			success: function(result){

					$("body").overhang({
						type: "success",
						message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
						duration: 1,
					})
					setTimeout(function(){location.reload();}, 1000);

				
					$('#modalEdit_dropdown_field_work_data').modal('toggle');
					

			},
		});
	}
}
