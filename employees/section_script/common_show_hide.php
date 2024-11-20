//for show hide...
		$('#showHideclm').SumoSelect({
			placeholder: '<?=$lng['Show Hide Columns']?>',
			captionFormat: '<?=$lng['Show Hide Columns']?> ({0})',
			captionFormatAllSelected: '<?=$lng['Show Hide Columns']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:true, 
			showTitle : false,
			triggerChangeCombined: true,
		});		

		$('#showHideclm2').SumoSelect({
			placeholder: '<?=$lng['Show Hide Columns']?>',
			captionFormat: '<?=$lng['Show Hide Columns']?> ({0})',
			captionFormatAllSelected: '<?=$lng['Show Hide Columns']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:false, 
			showTitle : false,
			triggerChangeCombined: true,
		});

		$('#showHideclm3').SumoSelect({
			placeholder: '<?=$lng['Show Hide Columns']?>',
			captionFormat: '<?=$lng['Show Hide Columns']?> ({0})',
			captionFormatAllSelected: '<?=$lng['Show Hide Columns']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:false, 
			showTitle : false,
			triggerChangeCombined: true,
		});		

		$('#showHideclm4').SumoSelect({
			placeholder: '<?=$lng['Show Hide Columns']?>',
			captionFormat: '<?=$lng['Show Hide Columns']?> ({0})',
			captionFormatAllSelected: '<?=$lng['Show Hide Columns']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:false, 
			showTitle : false,
			triggerChangeCombined: true,
		});		

		$('#showHideclm5').SumoSelect({
			placeholder: '<?=$lng['Show Hide Columns']?>',
			captionFormat: '<?=$lng['Show Hide Columns']?> ({0})',
			captionFormatAllSelected: '<?=$lng['Show Hide Columns']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:false, 
			showTitle : false,
			triggerChangeCombined: true,
		});		

		$('#showHideclm6').SumoSelect({
			placeholder: '<?=$lng['Show Hide Columns']?>',
			captionFormat: '<?=$lng['Show Hide Columns']?> ({0})',
			captionFormatAllSelected: '<?=$lng['Show Hide Columns']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:false, 
			showTitle : false,
			triggerChangeCombined: true,
		});		
		$('#showHideclm7').SumoSelect({
			placeholder: '<?=$lng['Show Hide Columns']?>',
			captionFormat: '<?=$lng['Show Hide Columns']?> ({0})',
			captionFormatAllSelected: '<?=$lng['Show Hide Columns']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:false, 
			showTitle : false,
			triggerChangeCombined: true,
		});		

		$('#showHideclm8').SumoSelect({
			placeholder: '<?=$lng['Show Hide Columns']?>',
			captionFormat: '<?=$lng['Show Hide Columns']?> ({0})',
			captionFormatAllSelected: '<?=$lng['Show Hide Columns']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:false, 
			showTitle : false,
			triggerChangeCombined: true,
		});
		$('#showHideclm9').SumoSelect({
			placeholder: '<?=$lng['Show Hide Columns']?>',
			captionFormat: '<?=$lng['Show Hide Columns']?> ({0})',
			captionFormatAllSelected: '<?=$lng['Show Hide Columns']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:false, 
			showTitle : false,
			triggerChangeCombined: true,
		});
		$('#showHideclm10').SumoSelect({
			placeholder: '<?=$lng['Show Hide Columns']?>',
			captionFormat: '<?=$lng['Show Hide Columns']?> ({0})',
			captionFormatAllSelected: '<?=$lng['Show Hide Columns']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:false, 
			showTitle : false,
			triggerChangeCombined: true,
		});
		$('#showHideclm11').SumoSelect({
			placeholder: '<?=$lng['Show Hide Columns']?>',
			captionFormat: '<?=$lng['Show Hide Columns']?> ({0})',
			captionFormatAllSelected: '<?=$lng['Show Hide Columns']?> ({0})',
			csvDispCount:1,
			outputAsCSV: true,
			selectAll:true,
			okCancelInMulti:false, 
			showTitle : false,
			triggerChangeCombined: true,
		});

		$("li#showHideClmss .SumoSelect li").bind('click.check', function(event) {
			var nr = $(this).index()+2;
			//alert(nr);
			if($(this).hasClass('selected') == true){
				datatableEmppp.column(nr).visible(true);
			}else{
				datatableEmppp.column(nr).visible(false);
			}
    	})		
    	$("table#showHideClmss2 .SumoSelect:first-child() li").bind('click.check', function(event) {
			var nr = $(this).index()+2;


			if($(this).hasClass('selected') == true){

			
					 dtable.column(nr).visible(true);
					 dtable2.column(nr).visible(true);

				if(nr == '2')
				{
					$('ul li#modifydata_scan_id_li').removeClass('displayNone');		
				}				
				if(nr == '3')
				{
					$('ul li#modifydata_title_li').removeClass('displayNone');		
				}				
				if(nr == '4')
				{
					$('ul li#modifydata_firstname_li').removeClass('displayNone');		
				}				
				if(nr == '5')
				{
					$('ul li#modifydata_lastname_li').removeClass('displayNone');		
				}				
				if(nr == '6')
				{
					$('ul li#modifydata_english_name_li').removeClass('displayNone');		
				}				
				if(nr == '7')
				{
					$('ul li#modifydata_birthdate_li').removeClass('displayNone');		
				}				
				if(nr == '8')
				{
					$('ul li#modifydata_nationality_li').removeClass('displayNone');		
				}				
				if(nr == '9')
				{
					$('ul li#modifydata_gender_li').removeClass('displayNone');		
				}				
				if(nr == '10')
				{
					$('ul li#modifydata_maritial_li').removeClass('displayNone');		
				}				
				if(nr == '11')
				{
					$('ul li#modifydata_religion_li').removeClass('displayNone');		
				}				
				if(nr == '12')
				{
					$('ul li#modifydata_military_li').removeClass('displayNone');		
				}				
				if(nr == '13')
				{
					$('ul li#modifydata_height_li').removeClass('displayNone');		
				}				
				if(nr == '14')
				{
					$('ul li#modifydata_weight_li').removeClass('displayNone');		
				}
				if(nr == '15')
				{
					$('ul li#modifydata_blood_type_li').removeClass('displayNone');		
				}
				if(nr == '16')
				{
					$('ul li#modifydata_driving_license_li').removeClass('displayNone');		
				}				
				if(nr == '17')
				{
					$('ul li#modifydata_license_date_li').removeClass('displayNone');		
				}				
				if(nr == '18')
				{
					$('ul li#modifydata_id_card_li').removeClass('displayNone');		
				}				
				if(nr == '19')
				{
					$('ul li#modifydata_id_card_expiry_date_li').removeClass('displayNone');		
				}				
				if(nr == '20')
				{
					$('ul li#modifydata_tax_id_li').removeClass('displayNone');		
				}

			
			}
			else
			{	

			
					

					dtable.column(nr).visible(false);
					dtable2.column(nr).visible(false);
				

				
				if(nr == '2')
				{
					$('ul li#modifydata_scan_id_li').addClass('displayNone');		
				}				
				if(nr == '3')
				{
					$('ul li#modifydata_title_li').addClass('displayNone');		
				}				
				if(nr == '4')
				{
					$('ul li#modifydata_firstname_li').addClass('displayNone');		
				}				
				if(nr == '5')
				{
					$('ul li#modifydata_lastname_li').addClass('displayNone');		
				}		
				if(nr == '6')
				{
					$('ul li#modifydata_english_name_li').addClass('displayNone');		
				}
				if(nr == '7')
				{
					$('ul li#modifydata_birthdate_li').addClass('displayNone');		
				}				
				if(nr == '8')
				{
					$('ul li#modifydata_nationality_li').addClass('displayNone');		
				}				
				if(nr == '9')
				{
					$('ul li#modifydata_gender_li').addClass('displayNone');		
				}				
				if(nr == '10')
				{
					$('ul li#modifydata_maritial_li').addClass('displayNone');		
				}	
				if(nr == '11')
				{
					$('ul li#modifydata_religion_li').addClass('displayNone');		
				}				
				if(nr == '12')
				{
					$('ul li#modifydata_military_li').addClass('displayNone');		
				}				
				if(nr == '13')
				{
					$('ul li#modifydata_height_li').addClass('displayNone');		
				}				
				if(nr == '14')
				{
					$('ul li#modifydata_weight_li').addClass('displayNone');		
				}				
				if(nr == '15')
				{
					$('ul li#modifydata_blood_type_li').addClass('displayNone');		
				}
				if(nr == '16')
				{
					$('ul li#modifydata_driving_license_li').addClass('displayNone');		
				}			
				if(nr == '17')
				{
					$('ul li#modifydata_license_date_li').addClass('displayNone');		
				}		
				if(nr == '18')
				{
					$('ul li#modifydata_id_card_li').addClass('displayNone');		
				}			
				if(nr == '19')
				{
					$('ul li#modifydata_id_card_expiry_date_li').addClass('displayNone');		
				}				
				if(nr == '20')
				{
					$('ul li#modifydata_tax_id_li').addClass('displayNone');		
				}
			

		

			}
    	})    	



	$("table#showHideClmss2 div.SumoSelect:nth-child(2) li").bind('click.check', function(event) {
			var nr = $(this).index()+2;
			
			if($(this).hasClass('selected') == true){

				if(nr == '2')
				{
					$('ul li#modifydata_registered_address_li').removeClass('displayNone');		
				}				
				if(nr == '3')
				{
					$('ul li#modifydata_sub_district_li').removeClass('displayNone');		
				}	
				if(nr == '4')
				{
					$('ul li#modifydata_district_li').removeClass('displayNone');		
				}				
				if(nr == '5')
				{
					$('ul li#modifydata_province_li').removeClass('displayNone');		
				}					
				if(nr == '6')
				{
					$('ul li#modifydata_postal_code_li').removeClass('displayNone');		
				}			
				if(nr == '7')
				{
					$('ul li#modifydata_country_li').removeClass('displayNone');		
				}				
				if(nr == '8')
				{
					$('ul li#modifydata_latitude_li').removeClass('displayNone');		
				}					
				if(nr == '9')
				{
					$('ul li#modifydata_longitude_li').removeClass('displayNone');		
				}				
				if(nr == '10')
				{
					$('ul li#modifydata_current_address_li').removeClass('displayNone');		
				}				
				if(nr == '11')
				{
					$('ul li#modifydata_personal_phone_li').removeClass('displayNone');		
				}					
				if(nr == '12')
				{
					$('ul li#modifydata_work_phone_li').removeClass('displayNone');		
				}				
				if(nr == '13')
				{
					$('ul li#modifydata_personal_email_li').removeClass('displayNone');		
				}					
				if(nr == '14')
				{
					$('ul li#modifydata_work_email_li').removeClass('displayNone');		
				}					
				if(nr == '15')
				{
					$('ul li#modifydata_username_options_li').removeClass('displayNone');		
				}				
				if(nr == '16')
				{
					$('ul li#modifydata_username_li').removeClass('displayNone');		
				}		

				dtable3.column(nr).visible(true);
				dtable4.column(nr).visible(true);
			}
			else
			{	

				if(nr == '2')
				{
					$('ul li#modifydata_registered_address_li').addClass('displayNone');		
				}				
				if(nr == '3')
				{
					$('ul li#modifydata_sub_district_li').addClass('displayNone');		
				}	
				if(nr == '4')
				{
					$('ul li#modifydata_district_li').addClass('displayNone');		
				}				
				if(nr == '5')
				{
					$('ul li#modifydata_province_li').addClass('displayNone');		
				}					
				if(nr == '6')
				{
					$('ul li#modifydata_postal_code_li').addClass('displayNone');		
				}			
				if(nr == '7')
				{
					$('ul li#modifydata_country_li').addClass('displayNone');		
				}				
				if(nr == '8')
				{
					$('ul li#modifydata_latitude_li').addClass('displayNone');		
				}					
				if(nr == '9')
				{
					$('ul li#modifydata_longitude_li').addClass('displayNone');		
				}				
				if(nr == '10')
				{
					$('ul li#modifydata_current_address_li').addClass('displayNone');		
				}				
				if(nr == '11')
				{
					$('ul li#modifydata_personal_phone_li').addClass('displayNone');		
				}					
				if(nr == '12')
				{
					$('ul li#modifydata_work_phone_li').addClass('displayNone');		
				}				
				if(nr == '13')
				{
					$('ul li#modifydata_personal_email_li').addClass('displayNone');		
				}					
				if(nr == '14')
				{
					$('ul li#modifydata_work_email_li').addClass('displayNone');		
				}					
				if(nr == '15')
				{
					$('ul li#modifydata_username_options_li').addClass('displayNone');		
				}				
				if(nr == '16')
				{
					$('ul li#modifydata_username_li').addClass('displayNone');		
				}

				dtable3.column(nr).visible(false);
				dtable4.column(nr).visible(false);
					
			}
    	})	


	$("table#showHideClmss2 div.SumoSelect:nth-child(3) li").bind('click.check', function(event) {
			var nr = $(this).index()+2;

			console.log(nr);
			
			if($(this).hasClass('selected') == true){

				if(nr == '2')
				{
					$('ul li#modifydata_joining_date_li').removeClass('displayNone');		
				}				
				if(nr == '3')
				{
					$('ul li#modifydata_probation_due_date_li').removeClass('displayNone');		
				}	
				if(nr == '4')
				{
					$('ul li#modifydata_employee_type_li').removeClass('displayNone');		
				}				
				if(nr == '5')
				{
					$('ul li#modifydata_accounting_code_li').removeClass('displayNone');		
				}			
				if(nr == '6')
				{
					$('ul li#modifydata_groups_li').removeClass('displayNone');		
				}					
		

				dtable5.column(nr).visible(true);
				dtable6.column(nr).visible(true);
			}
			else
			{	

				if(nr == '2')
				{
					$('ul li#modifydata_joining_date_li').addClass('displayNone');		
				}				
				if(nr == '3')
				{
					$('ul li#modifydata_probation_due_date_li').addClass('displayNone');		
				}	
				if(nr == '4')
				{
					$('ul li#modifydata_employee_type_li').addClass('displayNone');		
				}				
				if(nr == '5')
				{
					$('ul li#modifydata_accounting_code_li').addClass('displayNone');		
				}			
				if(nr == '6')
				{
					$('ul li#modifydata_groups_li').addClass('displayNone');		
				}		
				

				 dtable5.column(nr).visible(false);
				 dtable6.column(nr).visible(false);
					
			}
    	})	

	$("table#showHideClmss2 div.SumoSelect:nth-child(4) li").bind('click.check', function(event) {
			var nr = $(this).index()+2;

			// console.log(nr);

			
			if($(this).hasClass('selected') == true){

				if(nr == '2')
				{
					$('ul li#modifydata_time_reg_li').removeClass('displayNone');		
				}				
				if(nr == '3')
				{
					$('ul li#modifydata_time_selfie_li').removeClass('displayNone');		
				}	
				if(nr == '4')
				{
					$('ul li#modifydata_work_from_home_li').removeClass('displayNone');		
				}				
					
		

				dtable7.column(nr).visible(true);
				dtable8.column(nr).visible(true);
			}
			else
			{	

				if(nr == '2')
				{
					$('ul li#modifydata_time_reg_li').addClass('displayNone');		
				}				
				if(nr == '3')
				{
					$('ul li#modifydata_time_selfie_li').addClass('displayNone');		
				}	
				if(nr == '4')
				{
					$('ul li#modifydata_work_from_home_li').addClass('displayNone');		
				}				
		

				 dtable7.column(nr).visible(false);
				 dtable8.column(nr).visible(false);
					
			}
    	})	


	$("table#showHideClmss2 div.SumoSelect:nth-child(5) li").bind('click.check', function(event) {
			var nr = $(this).index()+2;

			// console.log(nr);

			
			if($(this).hasClass('selected') == true){

				if(nr == '2')
				{
					$('ul li#modifydata_annual_leaves_li').removeClass('displayNone');		
				}				
			
				dtable9.column(nr).visible(true);
				dtable10.column(nr).visible(true);
			}
			else
			{	

				if(nr == '2')
				{
					$('ul li#modifydata_annual_leaves_li').addClass('displayNone');		
				}				
			
				 dtable9.column(nr).visible(false);
				 dtable10.column(nr).visible(false);
					
			}
    	})	


	$("table#showHideClmss2 div.SumoSelect:nth-child(6) li").bind('click.check', function(event) {
			var nr = $(this).index()+2;

			// console.log(nr);

			
			if($(this).hasClass('selected') == true){

				dtable11.column(nr).visible(true);
				dtable12.column(nr).visible(true);
			}
			else
			{	
				dtable11.column(nr).visible(false);
				dtable12.column(nr).visible(false);
			}
    	})
    	
    	$("table#showHideClmss2 div.SumoSelect:nth-child(7) li").bind('click.check', function(event) {
			var nr = $(this).index()+2;

			// console.log(nr);

			
			if($(this).hasClass('selected') == true){
				if(nr == '2'){	$('ul li#modifycontract_li').removeClass('displayNone');	}	
				if(nr == '3'){	$('ul li#modifycalc_base_li').removeClass('displayNone');	}	
				if(nr == '4'){	$('ul li#modifybank_code_li').removeClass('displayNone');	}	
				if(nr == '5'){	$('ul li#modifybank_name_li').removeClass('displayNone');	}	
				if(nr == '6'){	$('ul li#modifybank_branch_li').removeClass('displayNone');	}	
				if(nr == '7'){	$('ul li#modifybank_account_li').removeClass('displayNone');	}	
				if(nr == '8'){	$('ul li#modifyaccount_name_li').removeClass('displayNone');	}	
				if(nr == '9'){	$('ul li#modifypay_type_li').removeClass('displayNone');	}	
				if(nr == '10'){	$('ul li#modifyaccount_code_li').removeClass('displayNone');	}	
				if(nr == '11'){	$('ul li#modifygroups_li').removeClass('displayNone');	}	
				if(nr == '12'){	$('ul li#modifytax_calc_method_li').removeClass('displayNone');	}	
				if(nr == '13'){	$('ul li#modifycalc_tax_li').removeClass('displayNone');	}	
				if(nr == '14'){	$('ul li#modifytax_residency_li').removeClass('displayNone');	}	
				if(nr == '15'){	$('ul li#modifyincome_section_li').removeClass('displayNone');	}	
				if(nr == '16'){	$('ul li#modifymodify_tax_li').removeClass('displayNone');	}	
				if(nr == '17'){	$('ul li#modifycalc_sso_li').removeClass('displayNone');	}	
				if(nr == '18'){	$('ul li#modifysso_by_li').removeClass('displayNone');	}	
				if(nr == '19'){	$('ul li#modifygov_house_bank_li').removeClass('displayNone');	}	
				if(nr == '20'){	$('ul li#modifysavings_li').removeClass('displayNone');	}	
				if(nr == '21'){	$('ul li#modifylegal_exec_dedc_li').removeClass('displayNone');	}	
				if(nr == '22'){	$('ul li#modifykor_yor_sor_li').removeClass('displayNone');	}	
				dtable15.column(nr).visible(true);
				dtable16.column(nr).visible(true);
			}
			else
			{	
				if(nr == '2'){	$('ul li#modifycontract_li').addClass('displayNone');		}	
				if(nr == '3'){	$('ul li#modifycalc_base_li').addClass('displayNone');		}	
				if(nr == '4'){	$('ul li#modifybank_code_li').addClass('displayNone');		}	
				if(nr == '5'){	$('ul li#modifybank_name_li').addClass('displayNone');		}	
				if(nr == '6'){	$('ul li#modifybank_branch_li').addClass('displayNone');		}	
				if(nr == '7'){	$('ul li#modifybank_account_li').addClass('displayNone');		}	
				if(nr == '8'){	$('ul li#modifyaccount_name_li').addClass('displayNone');		}	
				if(nr == '9'){	$('ul li#modifypay_type_li').addClass('displayNone');		}	
				if(nr == '10'){	$('ul li#modifyaccount_code_li').addClass('displayNone');		}	
				if(nr == '11'){	$('ul li#modifygroups_li').addClass('displayNone');		}	
				if(nr == '12'){	$('ul li#modifytax_calc_method_li').addClass('displayNone');		}	
				if(nr == '13'){	$('ul li#modifycalc_tax_li').addClass('displayNone');		}	
				if(nr == '14'){	$('ul li#modifytax_residency_li').addClass('displayNone');		}	
				if(nr == '15'){	$('ul li#modifyincome_section_li').addClass('displayNone');		}	
				if(nr == '16'){	$('ul li#modifymodify_tax_li').addClass('displayNone');		}	
				if(nr == '17'){	$('ul li#modifycalc_sso_li').addClass('displayNone');		}	
				if(nr == '18'){	$('ul li#modifysso_by_li').addClass('displayNone');		}	
				if(nr == '19'){	$('ul li#modifygov_house_bank_li').addClass('displayNone');		}	
				if(nr == '20'){	$('ul li#modifysavings_li').addClass('displayNone');		}	
				if(nr == '21'){	$('ul li#modifylegal_exec_dedc_li').addClass('displayNone');		}	
				if(nr == '22'){	$('ul li#modifykor_yor_sor_li').addClass('displayNone');		}	
				dtable15.column(nr).visible(false);
				dtable16.column(nr).visible(false);
			}
    	})	

	$("table#showHideClmss2 div.SumoSelect:nth-child(8) li").bind('click.check', function(event) {
			var nr = $(this).index()+2;

			// console.log(nr);

			
			if($(this).hasClass('selected') == true){

				dtable13.column(nr).visible(true);
				dtable14.column(nr).visible(true);
			}
			else
			{	
				dtable13.column(nr).visible(false);
				dtable14.column(nr).visible(false);
			}
    	})

	$("table#showHideClmss2 div.SumoSelect:nth-child(9) li").bind('click.check', function(event) {
			var nr = $(this).index()+2;

			// console.log(nr);

			
			if($(this).hasClass('selected') == true){

				dtable17.column(nr).visible(true);
				dtable18.column(nr).visible(true);
			}
			else
			{	
				dtable17.column(nr).visible(false);
				dtable18.column(nr).visible(false);
			}
    	})
    	
    	$("table#showHideClmss2 div.SumoSelect:nth-child(10) li").bind('click.check', function(event) {
			var nr = $(this).index()+2;

			// console.log(nr);

			
			if($(this).hasClass('selected') == true){

				dtable19.column(nr).visible(true);
				dtable20.column(nr).visible(true);
			}
			else
			{	
				dtable19.column(nr).visible(false);
				dtable20.column(nr).visible(false);
			}
    	})
    
    	
    	
    	

    	$('li#showHideClmss select#showHideclm').on('sumo:closing', function(o) {
			var columns = $(this).val();
			var att_cols = [];
			$.each(columns, function(index, item) {
				att_cols.push({id:item, db:tableCols[item][0], name:tableCols[item][1]})
			})

			$.ajax({
				url: "ajax/update_show_hide_clm.php",
				data: {cols: att_cols},
				success: function(result){
					
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		});     	

		$("table#showHideClmss2 select#showHideclm2").on('sumo:closing', function(o) {

			var columns = $(this).val();
			var att_cols = [];
			$.each(columns, function(index, item) {
				att_cols.push({id:item, db:tableCols2[item][0], name:tableCols2[item][1]})
			})

			$.ajax({
				url: "ajax/update_show_hide_clm2.php",
				data: {cols: att_cols},
				success: function(result){


					
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		}); 		
		$("table#showHideClmss2 select#showHideclm3").on('sumo:closing', function(o) {

			var columns = $(this).val();
			var att_cols = [];
			$.each(columns, function(index, item) {
				att_cols.push({id:item, db:tableCols3[item][0], name:tableCols3[item][1]})
			})

			$.ajax({
				url: "ajax/update_show_hide_clm2.php",
				data: {cols: att_cols},
				success: function(result){

					
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		}); 
		
		$("table#showHideClmss2 select#showHideclm4").on('sumo:closing', function(o) {

			var columns = $(this).val();
			var att_cols = [];
			$.each(columns, function(index, item) {
				att_cols.push({id:item, db:tableCols4[item][0], name:tableCols4[item][1]})
			})




			$.ajax({
				url: "ajax/update_show_hide_clm2.php",
				data: {cols: att_cols},
				success: function(result){

					
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		}); 		

		$("table#showHideClmss2 select#showHideclm5").on('sumo:closing', function(o) {

			var columns = $(this).val();
			var att_cols = [];
			$.each(columns, function(index, item) {
				att_cols.push({id:item, db:tableCols5[item][0], name:tableCols5[item][1]})
			})	

			$.ajax({
				url: "ajax/update_show_hide_clm2.php",
				data: {cols: att_cols},
				success: function(result){

					
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		}); 		

		$("table#showHideClmss2 select#showHideclm6").on('sumo:closing', function(o) {

			var columns = $(this).val();
			var att_cols = [];
			$.each(columns, function(index, item) {
				att_cols.push({id:item, db:tableCols6[item][0], name:tableCols6[item][1]})
			})	

			$.ajax({
				url: "ajax/update_show_hide_clm2.php",
				data: {cols: att_cols},
				success: function(result){

					
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		}); 

		$("table#showHideClmss2 select#showHideclm7").on('sumo:closing', function(o) {

			var columns = $(this).val();
			var att_cols = [];
			$.each(columns, function(index, item) {
				att_cols.push({id:item, db:tableCols7[item][0], name:tableCols7[item][1]})
			})	

			$.ajax({
				url: "ajax/update_show_hide_clm2.php",
				data: {cols: att_cols},
				success: function(result){

					
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		}); 		

		$("table#showHideClmss2 select#showHideclm9").on('sumo:closing', function(o) {

			var columns = $(this).val();
			var att_cols = [];
			$.each(columns, function(index, item) {
				att_cols.push({id:item, db:tableCols9[item][0], name:tableCols9[item][1]})
			})	

			$.ajax({
				url: "ajax/update_show_hide_clm2.php",
				data: {cols: att_cols},
				success: function(result){

					
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		});

		$("table#showHideClmss2 select#showHideclm8").on('sumo:closing', function(o) {

			var columns = $(this).val();
			var att_cols = [];
			$.each(columns, function(index, item) {
				att_cols.push({id:item, db:tableCols8[item][0], name:tableCols8[item][1]})
			})	

			$.ajax({
				url: "ajax/update_show_hide_clm2.php",
				data: {cols: att_cols},
				success: function(result){

					
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		}); 

		$("table#showHideClmss2 select#showHideclm10").on('sumo:closing', function(o) {

			var columns = $(this).val();
			var att_cols = [];
			$.each(columns, function(index, item) {
				att_cols.push({id:item, db:tableCols10[item][0], name:tableCols10[item][1]})
			})	

			$.ajax({
				url: "ajax/update_show_hide_clm2.php",
				data: {cols: att_cols},
				success: function(result){

					
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		});

		$("table#showHideClmss2 select#showHideclm10").on('sumo:closing', function(o) {

			var columns = $(this).val();
			var att_cols = [];
			$.each(columns, function(index, item) {
				att_cols.push({id:item, db:tableCols11[item][0], name:tableCols11[item][1]})
			})	

			$.ajax({
				url: "ajax/update_show_hide_clm2.php",
				data: {cols: att_cols},
				success: function(result){

					
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		});