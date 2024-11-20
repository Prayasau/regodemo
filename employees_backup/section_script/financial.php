function commonfinancialModal(field,valueCheck){
	var fieldToUpdate =field;
	var allfieldsArray = <?=json_encode($allfieldsArray)?>;
	if(valueCheck == 'text'&& fieldToUpdate!='bank_code')
	{
		
		// open text contact common modal

		$('#financial_text_field_span').html(allfieldsArray[fieldToUpdate]);
		$('#financial_hidden_field_to_update').val(fieldToUpdate);
		$('#financial_hidden_which_modal').val(valueCheck);
		$('#modal_edit_financial_text_value').val('');
		$('#modal_financial_common_text').modal('toggle');
	}	
	else if(valueCheck == 'dropdown')
	{
		$('#financial_dropdown_field_span').html(allfieldsArray[fieldToUpdate]);
		$('#financial_hidden_dropdown_field_to_update').val(fieldToUpdate);
		$('#financial_hidden_dropdown_which_modal').val(valueCheck);

		if(fieldToUpdate=='contract_type'){
			hide_financial_dropdown();
			$('#modal_edit_dropdown_value_contract_type_financial').removeClass('displayNone');
			
		}else if(fieldToUpdate=='calc_base'){
			hide_financial_dropdown();
			$('#modal_edit_dropdown_value_calc_base_financial').removeClass('displayNone');
			
		}else if(fieldToUpdate=='bank_name'){
			hide_financial_dropdown();
			$('#modal_edit_dropdown_value_bank_name_financial').removeClass('displayNone');
			
		}else if(fieldToUpdate=='account_code'){
			hide_financial_dropdown();
			$('#modal_edit_dropdown_value_account_code_financial').removeClass('displayNone');
			
		}else if(fieldToUpdate=='groups'){
			hide_financial_dropdown();
			$('#modal_edit_dropdown_value_groups_financial').removeClass('displayNone');
			
		}else if(fieldToUpdate=='pay_type'){
			hide_financial_dropdown();
			$('#modal_edit_dropdown_value_pay_type_financial').removeClass('displayNone');
			
		}else if(fieldToUpdate=='calc_method'){
			hide_financial_dropdown();
			$('#modal_edit_dropdown_value_calc_method_financial').removeClass('displayNone');
			
		}else if(fieldToUpdate=='calc_tax'){
			hide_financial_dropdown();
			$('#modal_edit_dropdown_value_calc_tax_financial').removeClass('displayNone');
			
		}else if(fieldToUpdate=='tax_residency_status'){
			hide_financial_dropdown();
			$('#modal_edit_dropdown_value_tax_residency_status_financial').removeClass('displayNone');
			
		}else if(fieldToUpdate=='income_section'){
			hide_financial_dropdown();
			$('#modal_edit_dropdown_value_income_section_financial').removeClass('displayNone');
			
		}else if(fieldToUpdate=='calc_sso'){
			hide_financial_dropdown();
			$('#modal_edit_dropdown_value_calc_sso_financial').removeClass('displayNone');
			
		}else if(fieldToUpdate=='sso_by'){
			hide_financial_dropdown();
			$('#modal_edit_dropdown_value_sso_by_financial').removeClass('displayNone');
			
		}
		//console.log('ergqerg');
		$('#modal_financial_common_dropdown').modal('toggle');
		

	}
}
function hide_financial_dropdown(){
			$('#modal_edit_dropdown_value_contract_type_financial').addClass('displayNone');
			$('#modal_edit_dropdown_value_calc_base_financial').addClass('displayNone');
			$('#modal_edit_dropdown_value_bank_name_financial').addClass('displayNone');
			$('#modal_edit_dropdown_value_account_code_financial').addClass('displayNone');
			$('#modal_edit_dropdown_value_groups_financial').addClass('displayNone');
			$('#modal_edit_dropdown_value_pay_type_financial').addClass('displayNone');
			$('#modal_edit_dropdown_value_calc_method_financial').addClass('displayNone');
			$('#modal_edit_dropdown_value_calc_tax_financial').addClass('displayNone');
			$('#modal_edit_dropdown_value_tax_residency_status_financial').addClass('displayNone');
			$('#modal_edit_dropdown_value_income_section_financial').addClass('displayNone');
			$('#modal_edit_dropdown_value_calc_sso_financial').addClass('displayNone');
			$('#modal_edit_dropdown_value_sso_by_financial').addClass('displayNone');
			}


function submitPopupModalCommonFinancial()
{
	var financial_hidden_field_to_update = $('#financial_hidden_field_to_update').val();
	var modal_edit_financial_text_value = $('#modal_edit_financial_text_value').val();
	var financial_hidden_which_modal = $('#financial_hidden_which_modal').val();

	$.ajax({
		url: "ajax/update_batch_data/update_batch_data_financial.php",
		data:{financial_hidden_which_modal:financial_hidden_which_modal,fieldToUpdate:financial_hidden_field_to_update,dataToUpdate:modal_edit_financial_text_value},
		success: function(result){


				$("body").overhang({
					type: "success",
					message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
					duration: 1,
				})
				setTimeout(function(){location.reload();}, 1000);

				
				$('#modal_financial_common_text').modal('toggle');
					
			


		},
	});

}

function submitPopupModalCommonFinancialDropdown()
{
	var financial_hidden_field_to_update = $('#financial_hidden_dropdown_field_to_update').val();
	var financial_hidden_which_modal = $('#fiancial_hidden_dropdown_which_modal').val();

		let fieldToUpdate=financial_hidden_field_to_update;
		if(fieldToUpdate=='contract_type'){
			var modal_edit_financial_value = $('#modal_edit_dropdown_value_contract_type_financial').val();
	
		}else if(fieldToUpdate=='calc_base'){
			var modal_edit_financial_value = $('#modal_edit_dropdown_value_calc_base_financial').val();
	
		}else if(fieldToUpdate=='bank_name'){
			var modal_edit_financial_value = $('#modal_edit_dropdown_value_bank_name_financial').val();
	
		}else if(fieldToUpdate=='account_code'){
			var modal_edit_financial_value = $('#modal_edit_dropdown_value_account_code_financial').val();
	
		}else if(fieldToUpdate=='groups'){
			var modal_edit_financial_value = $('#modal_edit_dropdown_value_groups_financial').val();
	
		}else if(fieldToUpdate=='pay_type'){
			var modal_edit_financial_value = $('#modal_edit_dropdown_value_pay_type_financial').val();
	
		}else if(fieldToUpdate=='calc_method'){
			var modal_edit_financial_value = $('#modal_edit_dropdown_value_calc_method_financial').val();
	
		}else if(fieldToUpdate=='calc_tax'){
			var modal_edit_financial_value = $('#modal_edit_dropdown_value_calc_tax_financial').val();
	
		}else if(fieldToUpdate=='tax_residency_status'){
			var modal_edit_financial_value = $('#modal_edit_dropdown_value_tax_residency_status_financial').val();
	
		}else if(fieldToUpdate=='income_section'){
			var modal_edit_financial_value = $('#modal_edit_dropdown_value_income_section_financial').val();
	
		}else if(fieldToUpdate=='calc_sso'){
			var modal_edit_financial_value = $('#modal_edit_dropdown_value_calc_sso_financial').val();
	
		}else if(fieldToUpdate=='sso_by'){
			var modal_edit_financial_value = $('#modal_edit_dropdown_value_sso_by_financial').val();
	
		}
		console.log({financial_hidden_which_modal:financial_hidden_which_modal,fieldToUpdate:financial_hidden_field_to_update,dataToUpdate:modal_edit_financial_value});
	$.ajax({
		url: "ajax/update_batch_data/update_batch_data_financial.php",
		data:{financial_hidden_which_modal:financial_hidden_which_modal,fieldToUpdate:financial_hidden_field_to_update,dataToUpdate:modal_edit_financial_value},
		success: function(result){


				$("body").overhang({
					type: "success",
					message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
					duration: 1,
				})
				setTimeout(function(){location.reload();}, 1000);

			
				$('#modal_financial_common_dropdown').modal('toggle');
				

		},
	});

}


// =============================== EDIT DATATABLE COLUMN FINANCIAL FIELD VALUES  ===================//

$(document).on("click", ".commonEditColumnFinancial", function(e){

	var textFieldArray = <?=json_encode($textFieldFinanceArray)?>;
	var dropdownFieldArray = <?=json_encode($dropdownFieldfinanceArray)?>;
	var allfieldsArray = <?=json_encode($allfieldsArray)?>;
	var contract_type = <?=json_encode($contract_type)?>;
	var calc_base = <?=json_encode($calc_base)?>;
	var pay_type = <?=json_encode($pay_type)?>;
	var tax_residency_status = <?=json_encode($tax_residency_status)?>;
	var income_section = <?=json_encode($income_section)?>;
	var sso_by = <?=json_encode($sso_paidby)?>;
	var groups = <?=json_encode($getAllGroups)?>;
	var banks = <?=json_encode($banksarray)?>;
	var accountcode = <?=json_encode($accountCodeArray)?>;
	var calcmethod = <?=json_encode($calcmethod)?>;
	var calctax = <?=json_encode($calctax)?>;
	var noyes = <?=json_encode($noyes01)?> ;

	//console.log($(this));
	var classNameString = $(this).closest('td.commonEditColumnFinancial').attr('class');
	var avoid = "commonEditColumnFinancial";
	var fieldToUpdate = $.trim(classNameString.replace(avoid,''));

	var oldvalue = $(this).closest('td.commonEditColumnFinancial').html();
	var rowId = $(this).closest('tr').children('td:first').find('span#rowIdDatatableSpan').html();

	

	// open modal here

	// check field type if drop down , text field or date and open common modal according to that 
	//console.log(textFieldArray);

	if(jQuery.inArray(fieldToUpdate, textFieldArray) !== -1)
	{
		$('#finance_hidden_row_id').val(rowId);
		$('#finance_hidden_field_to_update_edit').val(fieldToUpdate);
		$('#finance_text_field_span_edit').html(allfieldsArray[fieldToUpdate]);
		$('#modal_edit_finance_text_value_edit').val($.trim(oldvalue));
		$('#modal_finance_common_text_edit').modal('toggle');

	}		
	else if(jQuery.inArray(fieldToUpdate, dropdownFieldArray) !== -1)
	{
		//console.log(dropdownFieldArray);
		// append option to drop down 
		// first empty the previous values
		$('#finance_hidden_row_id_dropdown').val(rowId);
		$('#finance_hidden_field_to_update_dropdown').val(fieldToUpdate);
		$('#modal_finance_edit_dropdown_value').empty();

		// select array to show 
		if(fieldToUpdate == 'contract_type')
		{
			var loopArray = contract_type;
		}if(fieldToUpdate == 'calc_base')
		{
			var loopArray = calc_base;
		}if(fieldToUpdate == 'pay_type')
		{
			var loopArray = pay_type;
		}if(fieldToUpdate == 'tax_residency_status')
		{
			var loopArray = tax_residency_status;
		}if(fieldToUpdate == 'income_section')
		{
			var loopArray = income_section;
		}if(fieldToUpdate == 'sso_by')
		{
			var loopArray = sso_by;
		}if(fieldToUpdate == 'groups')
		{
			var loopArray = groups;
		}if(fieldToUpdate == 'bank_name')
		{
			var loopArray = banks;
		}if(fieldToUpdate == 'account_code')
		{
			var loopArray = accountcode;
		}if(fieldToUpdate == 'calc_method')
		{
			var loopArray = calcmethod;
		}if(fieldToUpdate == 'calc_tax')
		{
			var loopArray = calctax;
		}if(fieldToUpdate == 'calc_sso')
		{
			var loopArray = noyes;
		}




		// Common append 
		 var mySelect = $('#modal_finance_edit_dropdown_value');
         mySelect.append(
                $('<option></option>').val('select').html('Select')
            );
        $.each(loopArray, function(val, text) {

        	if(text == $.trim(oldvalue))
        	{
        		var selected = "selected";
        	}
        	//console.log(val+'|'+oldvalue+'|');
            mySelect.append(
                $('<option  '+selected+'></option>').val(val).html(text)
            );
        });


        //open modal 
		$('#finance_dropdown_field_span').html(allfieldsArray[fieldToUpdate]);
		$('#modalEdit_finance_drop_down').modal('toggle');
	}


});


function submitPopupModalCommonFinancialOnclick(valueCheck){

	var rowId = $('#finance_hidden_row_id').val();
	var fieldToUpdate = $('#finance_hidden_field_to_update_edit').val();

	if(valueCheck == 'text')
	{
		var dataToUpdate = $('#modal_edit_finance_text_value_edit').val();
	}	
	else if(valueCheck == 'dropdown')
	{
		var dataToUpdate = $('#modal_finance_edit_dropdown_value').val();
	}
		console.log({rowId:rowId,fieldToUpdate:fieldToUpdate,dataToUpdate:dataToUpdate});

	$.ajax({
		url: "ajax/update_on_field_edit/update_temp_employee_data_for_finance_on_click.php",
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
					$('#modal_edit_finance_text_value_edit').modal('toggle');
				}	
				else if(valueCheck == 'dropdown')
				{
					$('#modalEdit_finance_drop_down').modal('toggle');
				}


		},
	});

}

function submitPopupModalDropdownFinancialOnclick(valueCheck){

	var rowId = $('#finance_hidden_row_id_dropdown').val();
	var fieldToUpdate = $('#finance_hidden_field_to_update_dropdown').val();

	if(valueCheck == 'text')
	{
		var dataToUpdate = $('#modal_edit_finance_text_value_edit').val();
	}	
	else if(valueCheck == 'dropdown')
	{
		var dataToUpdate = $('#modal_finance_edit_dropdown_value').val();
	}
		console.log({rowId:rowId,fieldToUpdate:fieldToUpdate,dataToUpdate:dataToUpdate});

	$.ajax({
		url: "ajax/update_on_field_edit/update_temp_employee_data_for_finance_on_click.php",
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
					$('#modal_edit_finance_text_value_edit').modal('toggle');
				}	
				else if(valueCheck == 'dropdown')
				{
					$('#modalEdit_finance_drop_down').modal('toggle');
				}


		},
	});

}