// ============================== MODIFY DATA CONTACTLICK EDIT ========================//

function comomonContactModal(field,valueCheck){

	var fieldToUpdate =field;
	var allfieldsArray = <?=json_encode($allfieldsArray)?>;

	if(valueCheck == 'text')
	{
		// open text contact common modal

		$('#contacts_text_field_span').html(allfieldsArray[fieldToUpdate]);
		$('#contact_hidden_field_to_update').val(fieldToUpdate);
		$('#contact_hidden_which_modal').val(valueCheck);
		$('#modal_edit_contact_text_value').val('');
		$('#modal_contacts_common_text').modal('toggle');


	}	
	else if(valueCheck == 'dropdown')
	{
		$('#contacts_dropdown_field_span').html(allfieldsArray[fieldToUpdate]);
		$('#contact_hidden_dropdown_field_to_update').val(fieldToUpdate);
		$('#contact_hidden_dropdown_which_modal').val(valueCheck);
		$('#modal_contacts_common_dropdown').modal('toggle');


	}



}
function submitPopupModalCommonContact()
{
	var contact_hidden_field_to_update = $('#contact_hidden_field_to_update').val();
	var modal_edit_contact_text_value = $('#modal_edit_contact_text_value').val();
	var contact_hidden_which_modal = $('#contact_hidden_which_modal').val();

	$.ajax({
		url: "ajax/update_batch_data/update_batch_data_contacts.php",
		data:{contact_hidden_which_modal:contact_hidden_which_modal,fieldToUpdate:contact_hidden_field_to_update,dataToUpdate:modal_edit_contact_text_value},
		success: function(result){


				$("body").overhang({
					type: "success",
					message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
					duration: 1,
				})
				setTimeout(function(){location.reload();}, 1000);

				
				$('#modal_contacts_common_text').modal('toggle');
					
			


		},
	});

}

function submitPopupModalCommonContactDropdown()
{
	var contact_hidden_dropdown_field_to_update = $('#contact_hidden_dropdown_field_to_update').val();
	var modal_edit_contact_dropdown_value = $('#modal_edit_contact_dropdown_value').val();
	var contact_hidden_dropdown_which_modal = $('#contact_hidden_dropdown_which_modal').val();

	$.ajax({
		url: "ajax/update_batch_data/update_batch_data_contacts_dropdown.php",
		data:{contact_hidden_which_modal:contact_hidden_dropdown_which_modal,fieldToUpdate:contact_hidden_dropdown_field_to_update,dataToUpdate:modal_edit_contact_dropdown_value},
		success: function(result){


				$("body").overhang({
					type: "success",
					message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
					duration: 1,
				})
				setTimeout(function(){location.reload();}, 1000);

			
				$('#modal_contacts_common_dropdown').modal('toggle');
				

		},
	});

}
// ============================== MODIFY DATA ON CLICK EDIT ========================//


// =============================== EDIT DATATABLE COLUMN CONTACT FIELD VALUES  ===================//

$(document).on("click", ".commonEditColumnContacts", function(e){

	var textFieldArray = <?=json_encode($textFieldContactArray)?>;
	var dropdownFieldArray = <?=json_encode($dropdownFieldContactArray)?>;
	var allfieldsArray = <?=json_encode($allfieldsArray)?>;
	var username_option = <?=json_encode($username_option)?>;


	var classNameString = $(this).closest('td.commonEditColumnContacts').attr('class');
	var avoid = "commonEditColumnContacts";
	var fieldToUpdate = $.trim(classNameString.replace(avoid,''));

	var oldvalue = $(this).closest('td.commonEditColumnContacts').html();
	var rowId = $(this).closest('tr').children('td:first').find('span#rowIdDatatableSpan').html();


	$('#contact_hidden_row_id').val(rowId);
	$('#contact_hidden_field_to_update_edit').val(fieldToUpdate);

	// open modal here

	// check field type if drop down , text field or date and open common modal according to that 
	console.log(textFieldArray);

	if(jQuery.inArray(fieldToUpdate, textFieldArray) !== -1)
	{
		$('#contacts_text_field_span_edit').html(allfieldsArray[fieldToUpdate]);
		$('#modal_edit_contact_text_value_edit').val(oldvalue);
		$('#modal_contacts_common_text_edit').modal('toggle');
	}		
	else if(jQuery.inArray(fieldToUpdate, dropdownFieldArray) !== -1)
	{
		// append option to drop down 
		// first empty the previous values
		$('#modal_contact_edit_dropdown_value').empty();

		// select array to show 
		if(fieldToUpdate == 'username_option')
		{
			var loopArray = username_option;
		}		


		// Common append 
		 var mySelect = $('#modal_contact_edit_dropdown_value');
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


        //open modal 
		$('#contact_dropdown_field_span').html(allfieldsArray[fieldToUpdate]);
		$('#modalEdit_contact_drop_down').modal('toggle');
	}


});


function submitPopupModalCommonContactOnclick(valueCheck){

	var rowId = $('#contact_hidden_row_id').val();
	var fieldToUpdate = $('#contact_hidden_field_to_update_edit').val();

	if(valueCheck == 'text')
	{
		var dataToUpdate = $('#modal_edit_contact_text_value_edit').val();
	}	
	else if(valueCheck == 'dropdown')
	{
		var dataToUpdate = $('#modal_contact_edit_dropdown_value').val();
	}


	$.ajax({
		url: "ajax/update_on_field_edit/update_temp_employee_data_for_contact_on_click.php",
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
					$('#modal_edit_contact_text_value_edit').modal('toggle');
				}	
				else if(valueCheck == 'dropdown')
				{
					$('#modalEdit_contact_drop_down').modal('toggle');
				}


		},
	});

}

// =============================== EDIT DATATABLE COLUMN CONTACT FIELD VALUES  ===================//
