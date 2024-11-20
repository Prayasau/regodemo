function comomonTimeModal(field,valueCheck){


	var fieldToUpdate =field;
	var allfieldsArray = <?=json_encode($allfieldsArray)?>;

 	if(valueCheck == 'dropdown')
	{
		$('#dropdown_field_span_time_data').html(allfieldsArray[fieldToUpdate]);
		$('#time_data_hidden_field_to_update_dropdown').val(fieldToUpdate);


		if(fieldToUpdate == 'time_reg')
		{
			$('#modal_edit_dropdown_time_reg_value').removeClass('displayNone');
			$('#modal_edit_dropdown_selfie_time').addClass('displayNone');
			$('#modal_edit_dropdown_workFromhome_time').addClass('displayNone');


		}		
		else if(fieldToUpdate == 'selfie')
		{
			$('#modal_edit_dropdown_time_reg_value').addClass('displayNone');
			$('#modal_edit_dropdown_selfie_time').removeClass('displayNone');
			$('#modal_edit_dropdown_workFromhome_time').addClass('displayNone');

		}			
		else if(fieldToUpdate == 'workFromHome')
		{
			$('#modal_edit_dropdown_time_reg_value').addClass('displayNone');
			$('#modal_edit_dropdown_selfie_time').addClass('displayNone');
			$('#modal_edit_dropdown_workFromhome_time').removeClass('displayNone');

		}		


		$('#modalEdit_dropdown_field_time_data').modal('toggle');


	}


}



function submitPopupModalEditTimedata(valueCheck){

 if(valueCheck == 'dropdown')
	{
		var time_data_hidden_field_to_update_dropdown = $('#time_data_hidden_field_to_update_dropdown').val();

		if(time_data_hidden_field_to_update_dropdown == 'time_reg')
		{
			var modal_edit_date_value_work_data = $('#modal_edit_dropdown_time_reg_value').val();
		}
		else if(time_data_hidden_field_to_update_dropdown == 'selfie'){

			var modal_edit_date_value_work_data = $('#modal_edit_dropdown_selfie_time').val();
		}		
		else if(time_data_hidden_field_to_update_dropdown == 'workFromHome'){

			var modal_edit_date_value_work_data = $('#modal_edit_dropdown_workFromhome_time').val();
		}


		$.ajax({
			url: "ajax/update_batch_data/update_batch_dropdown_time_data.php",
			data:{fieldToUpdate:time_data_hidden_field_to_update_dropdown,dataToUpdate:modal_edit_date_value_work_data},
			success: function(result){

					$("body").overhang({
						type: "success",
						message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
						duration: 1,
					})
					setTimeout(function(){location.reload();}, 1000);

				
					$('#modalEdit_dropdown_field_time_data').modal('toggle');
					

			},
		});
	}
}

// ===============================  COMMON TIME DATA FIELDS EDIT MODAL ===================//


// =============================== EDIT DATATABLE COLUMN TIME DATA FIELD VALUES  ===================//

$(document).on("click", ".commonEditColumnTime", function(e){

	var dropdownFieldArray = <?=json_encode($dropdownFieldTimeData)?>;
	var allfieldsArray = <?=json_encode($allfieldsArray)?>;
	var time_regArray = <?=json_encode($time_regArray)?>;
	var selfieArray = <?=json_encode($selfieArray)?>;
	var workFromHomeArray = <?=json_encode($workFromHomeArray)?>;


	var classNameString = $(this).closest('td.commonEditColumnTime').attr('class');
	var avoid = "commonEditColumnTime";
	var fieldToUpdate = $.trim(classNameString.replace(avoid,''));

	var oldvalue = $(this).closest('td.commonEditColumnTime').html();
	var rowId = $(this).closest('tr').children('td:first').find('span#rowIdDatatableSpan').html();


	$('#timedata_hidden_row_id').val(rowId);
	$('#time_data_hidden_field_to_update_dropdown').val(fieldToUpdate);

	// open modal here

	// check field type if drop down , text field or date and open common modal according to that 

	if(jQuery.inArray(fieldToUpdate, dropdownFieldArray) !== -1)
	{
		// append option to drop down 
		// first empty the previous values
		$('#modal_edit_timedata_dropdown_value').empty();

		// // select array to show 
		if(fieldToUpdate == 'time_reg')
		{
			var loopArray = time_regArray;
		} 
		else if(fieldToUpdate == 'selfie')
		{
			var loopArray = selfieArray;
		}		
		else if(fieldToUpdate == 'workFromHome')
		{
			var loopArray = workFromHomeArray;
		}



		// Common append 
		 var mySelect = $('#modal_edit_timedata_dropdown_value');
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
		$('#timedata_dropdown_field_span').html(allfieldsArray[fieldToUpdate]);
		$('#modalEdit_timedata_drop_down').modal('toggle');
	}


});


function submitPopupModalCommonTimeDataOnclick(valueCheck){

	var rowId = $('#timedata_hidden_row_id').val();
	var fieldToUpdate = $('#time_data_hidden_field_to_update_dropdown').val();

 	if(valueCheck == 'dropdown')
	{
		var dataToUpdate = $('#modal_edit_timedata_dropdown_value').val();
	}

	$.ajax({
		url: "ajax/update_on_field_edit/update_temp_employee_data_for_time_on_click.php",
		data:{rowId:rowId,fieldToUpdate:fieldToUpdate,dataToUpdate:dataToUpdate},
		success: function(result){


				if(valueCheck == 'dropdown')
				{
					$('#modalEdit_timedata_drop_down').modal('toggle');
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