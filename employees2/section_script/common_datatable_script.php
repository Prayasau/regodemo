		var eCols = <?=json_encode($emptyCols)?>;
		var eCols2 = <?=json_encode($emptyCols2)?>;
		var parameters = <?=json_encode($parameters)?>;
		var entitiesCount = <?=count($entities)?>;
		var branchesCount = <?=count($branches)?>;
		var divisionsCount = <?=count($divisions)?>;
		var departmentsCount = <?=count($departments)?>;
		var teamsCount = <?=count($teams)?>;
		var positionsCount = <?=count($positions)?>;
		var tableCols = <?=json_encode($eatt_cols)?>;
		var tableCols2 = <?=json_encode($eatt_cols2)?>;
		var tableCols3 = <?=json_encode($eatt_cols3)?>;
		var tableCols4 = <?=json_encode($eatt_cols4)?>;
		var tableCols5 = <?=json_encode($eatt_cols5)?>;
		var tableCols6 = <?=json_encode($eatt_cols6)?>;
		var tableCols7 = <?=json_encode($eatt_cols7)?>;
		var tableCols8 = <?=json_encode($eatt_cols8)?>;
		var tableCols9 = <?=json_encode($eatt_cols9)?>;

		// console.log(tableCols8);

		var datatableEmppp = $('#datatableEmppp').DataTable({

			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: 10,
			filter: true,
			info: true,
			autoWidth: false,
			<?=$dtable_lang?>
			columnDefs: [
				{"targets": eCols, "visible": false, "searchable": false},
				{ "width": "50px", "targets": 0 },
				{ "width": "138px", "targets": 1 },
				{ "width": "50px", "targets": 2 },
				{ "width": "50px", "targets": 3 },
				{ "width": "50px", "targets": 4 },
				{ "width": "50px", "targets": 5 },
				{ "width": "50px", "targets": 6 },
				{ "width": "50px", "targets": 7 },
				{ "width": "50px", "targets": 8 },

			]

		});

		$("#searchFilterd").keyup(function() {
			datatableEmppp.search(this.value).draw();

		});		
		$("#searchFilterd2").keyup(function() {
			dtable.search(this.value).draw();

		});		



		$("#clearSearchboxd").click(function() {
			$("#searchFilterd").val('');
			datatableEmppp.search('').draw();
		});



		$(document).on("change", "#pageLengthd", function(e) {
			if(this.value > 0){
				datatableEmppp.page.len( this.value ).draw();
			}
		})


	    var scrolly = '<?php echo $scrolly?>';
		var pagelength = '<?php echo $pagelength?>';

		if(pagelength)
		{
			var pagelengthval = pagelength ;
		}
		else
		{
			var pagelengthval = '9';

		}

		if(scrolly)
		{
			var scrollyValue = scrolly ;
		}
		else
		{
			var scrollyValue = '250px';
		}

		var dtable = $('#datatables11').DataTable({

			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: pagelengthval,
			filter: true,
			info: false,
			scrollY:        scrollyValue,
	        scrollCollapse: true,
	        scrollX: true,
	        paging:         true,
	           "columnDefs": [
							      { className: "commonEditColumn sid", "targets": [ 2 ] },
							      { className: "commonEditColumn title", "targets": [ 3 ] },
							      { className: "commonEditColumn firstname", "targets": [ 4 ] },
							      { className: "commonEditColumn lastname", "targets": [ 5 ] },
							      { className: "commonEditColumn en_name", "targets": [ 6 ] },
							      { className: "commonEditColumn birthdate", "targets": [ 7 ] },
							      { className: "commonEditColumn nationality", "targets": [ 8 ] },
							      { className: "commonEditColumn gender", "targets": [ 9 ] },
							      { className: "commonEditColumn maritial", "targets": [ 10 ] },
							      { className: "commonEditColumn religion", "targets": [ 11 ] },
							      { className: "commonEditColumn military_status", "targets": [ 12 ] },
							      { className: "commonEditColumn height", "targets": [ 13 ] },
							      { className: "commonEditColumn weight", "targets": [ 14 ] },
							      { className: "commonEditColumn bloodtype", "targets": [ 15 ] },
							      { className: "commonEditColumn drvlicense_nr", "targets": [ 16 ] },
							      { className: "commonEditColumn drvlicense_exp", "targets": [ 17 ] },
							      { className: "commonEditColumn idcard_nr", "targets": [ 18 ] },
							      { className: "commonEditColumn idcard_exp", "targets": [ 19 ] },
							      { className: "commonEditColumn tax_id", "targets": [ 20 ] },
							      { className: "commonEditColumn same_tax", "targets": [ 21 ] },
							      { className: "commonEditColumn sso_id", "targets": [ 22 ] },
							      { className: "commonEditColumn same_sso", "targets": [ 23 ] },

						    ],
			<?=$dtable_lang?>
		});	

		var dtable3 = $('#datatables13').DataTable({

			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: pagelengthval,
			filter: true,
			info: false,
			scrollY:        scrollyValue,
	        scrollCollapse: true,
	        scrollX: true,
	        paging:         true,
	           "columnDefs": [
							      { className: "commonEditColumnContacts reg_address", "targets": [ 2 ] },
							      { className: "commonEditColumnContacts sub_district", "targets": [ 3 ] },
							      { className: "commonEditColumnContacts district", "targets": [ 4 ] },
							      { className: "commonEditColumnContacts province", "targets": [ 5 ] },
							      { className: "commonEditColumnContacts postnr", "targets": [ 6 ] },
							      { className: "commonEditColumnContacts country", "targets": [ 7 ] },
							      { className: "commonEditColumnContacts latitude", "targets": [ 8 ] },
							      { className: "commonEditColumnContacts longitude", "targets": [ 9 ] },
							      { className: "commonEditColumnContacts cur_address", "targets": [ 10 ] },
							      { className: "commonEditColumnContacts personal_phone", "targets": [ 11 ] },
							      { className: "commonEditColumnContacts work_phone", "targets": [ 12 ] },
							      { className: "commonEditColumnContacts personal_email", "targets": [ 13 ] },
							      { className: "commonEditColumnContacts work_email", "targets": [ 14 ] },
							      { className: " commonEditColumnContacts username_option", "targets": [ 15 ] },
							      { className: "commonEditColumnContacts username", "targets": [ 16 ] },
				

						    ],
			<?=$dtable_lang?>

		});		

		var dtable5 = $('#datatables15').DataTable({

			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: pagelengthval,
			filter: true,
			info: false,
			scrollY:        scrollyValue,
	        scrollCollapse: true,
	        scrollX: true,
	        paging:         true,
	           "columnDefs": [
							       { className: "commonEditColumnWork joining_date", "targets": [ 2 ] },
							       { className: "commonEditColumnWork probation_date", "targets": [ 3 ] },
							       { className: "commonEditColumnWork emp_type", "targets": [ 4 ] },
							       { className: "commonEditColumnWork account_code", "targets": [ 5 ] },
							       { className: "commonEditColumnWork groups", "targets": [ 6 ] },
						    ],
			<?=$dtable_lang?>



		});	


		var dtable7 = $('#datatables17').DataTable({

			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: pagelengthval,
			filter: true,
			info: false,
			scrollY:        scrollyValue,
	        scrollCollapse: true,
	        scrollX: true,
	        paging:         true,
	           "columnDefs": [
							       { className: "commonEditColumnTime time_reg", "targets": [ 2 ] },
							       { className: "commonEditColumnTime selfie", "targets": [ 3 ] },
							       { className: "commonEditColumnTime workFromHome", "targets": [ 4 ] },
							    
						    ],
			<?=$dtable_lang?>



		});			

		var dtable9 = $('#datatables19').DataTable({

			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: pagelengthval,
			filter: true,
			info: false,
			scrollY:        scrollyValue,
	        scrollCollapse: true,
	        scrollX: true,
	        paging:         true,
	           "columnDefs": [
							       { className: "commonEditColumnLeave annual_leave", "targets": [ 2 ] },
							    
						    ],
			<?=$dtable_lang?>



		});				

		var dtable11 = $('#datatables21').DataTable({

			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: pagelengthval,
			filter: true,
			info: false,
			scrollY:        scrollyValue,
	        scrollCollapse: true,
	        scrollX: true,
	        paging:         true,
	           "columnDefs": [
							       { className: "commonEditColumnOrganization company", "targets": [ 0 ] },
							       { className: "commonEditColumnOrganization company", "targets": [ 1 ] },
							       { className: "commonEditColumnOrganization company", "targets": [ 2 ] },
							       { className: "commonEditColumnOrganization company", "targets": [ 3 ] },
							       { className: "commonEditColumnOrganization company", "targets": [ 4 ] },
							       { className: "commonEditColumnOrganization company", "targets": [ 5 ] },
							       { className: "commonEditColumnOrganization company", "targets": [ 6 ] },
							    
						    ],
			<?=$dtable_lang?>



		});		
		
		

		var dtable13 = $('#datatables23').DataTable({

			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: pagelengthval,
			filter: true,
			info: false,
			scrollY:        scrollyValue,
	        scrollCollapse: true,
	        scrollX: true,
	        paging:         true,
	           "columnDefs": [
							       { className: "commonEditColumnBenefit start_date", "targets": [ 2 ] },
							       { className: "commonEditColumnBenefit base_salary", "targets": [ 3 ] },
							       { className: "commonEditColumnBenefit base_salary", "targets": [ 4 ] },
							       { className: "commonEditColumnBenefit base_salary", "targets": [ 5 ] },
							       { className: "commonEditColumnBenefit base_salary", "targets": [ 6 ] },
							       { className: "commonEditColumnBenefit base_salary", "targets": [ 7 ] },
							       { className: "commonEditColumnBenefit base_salary", "targets": [ 8 ] },
							       { className: "commonEditColumnBenefit base_salary", "targets": [ 9 ] },
							       { className: "commonEditColumnBenefit base_salary", "targets": [ 10 ] },
							       { className: "commonEditColumnBenefit base_salary", "targets": [ 11 ] },
							       { className: "commonEditColumnBenefit base_salary", "targets": [ 12 ] },
							       { className: "commonEditColumnBenefit base_salary", "targets": [ 13 ] },
							       { className: "commonEditColumnBenefit base_salary", "targets": [ 14 ] },
						    ],
			<?=$dtable_lang?>



		});		
		
		var dtable15 = $('#datatables25').DataTable({

			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: pagelengthval,
			filter: true,
			info: false,
			scrollY:        scrollyValue,
	        scrollCollapse: true,
	        scrollX: true,
	        paging:         true,
	        "columnDefs": [
							       { className: "commonEditColumnFinancial contract_type", "targets": [ 2 ] },
							       { className: "commonEditColumnFinancial calc_base", "targets": [ 3 ] },
							       { className: "commonEditColumnFinancial bank_code", "targets": [ 4 ] },
							       { className: "commonEditColumnFinancial bank_name", "targets": [ 5 ] },
							       { className: "commonEditColumnFinancial bank_branch", "targets": [ 6 ] },
							       { className: "commonEditColumnFinancial bank_account", "targets": [ 7 ] },
							       { className: "commonEditColumnFinancial bank_account_name", "targets": [ 8 ] },
							       { className: "commonEditColumnFinancial pay_type", "targets": [ 9 ] },
							       { className: "commonEditColumnFinancial account_code", "targets": [ 10 ] },
							       { className: "commonEditColumnFinancial groups", "targets": [ 11 ] },
							       { className: "commonEditColumnFinancial calc_method", "targets": [ 12 ] },
							       { className: "commonEditColumnFinancial calc_tax", "targets": [ 13 ] },
							       { className: "commonEditColumnFinancial tax_residency_status", "targets": [ 14 ] },
							       { className: "commonEditColumnFinancial income_section", "targets": [ 15 ] },
							       { className: "commonEditColumnFinancial modify_tax", "targets": [ 16 ] },
							       { className: "commonEditColumnFinancial calc_sso", "targets": [ 17 ] },
							       { className: "commonEditColumnFinancial sso_by", "targets": [ 18 ] },
							       { className: "commonEditColumnFinancial gov_house_banking", "targets": [ 19 ] },
							       { className: "commonEditColumnFinancial savings", "targets": [ 20 ] },
							       { className: "commonEditColumnFinancial legal_execution", "targets": [ 21 ] },
							       { className: "commonEditColumnFinancial kor_yor_sor", "targets": [ 22 ] },
						    ],
			<?=$dtable_lang?>



		});	

		// switch layput case 

		var classnamevaluejq = '<?php echo $classNamePhpValue?>';
		var heightvaluejq = '<?php echo $heightPhpValue?>';
		if(classnamevaluejq == '')
		{
			var pagelengthValue = 9;
		}
		else
		{
			var pagelengthValue = 20;
		}


		var dtable2 = $('#datatables12').DataTable({

			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: pagelengthValue,
			filter: true,
			info: true,
			scrollY:        '250px',
	        scrollCollapse: true,
	        scrollX: true,
	        paging:         true,
	      
			<?=$dtable_lang?>

				 "initComplete": function(settings, json) {

			    	

					// adding switch javscript 
					if(classnamevaluejq == '')
					{
						$("#hidediv2").removeClass(classnamevaluejq);
						$("div#datatables12_wrapper div.row:nth-last-child(2)").removeClass('displayNone');
						$("#datatables11_wrapper").css('height', '');
						$("table#oldatatable").removeClass('displayNone');

					}
					else
					{
						$("#hidediv2").addClass(classnamevaluejq);
						$("div#datatables12_wrapper div.row:nth-last-child(2)").addClass('displayNone');
						$("table#oldatatable").addClass('displayNone');
						// $("#datatables11_wrapper").css('height', heightvaluejq);
					}
					




			  }


		});		

		var dtable4 = $('#datatables14').DataTable({

			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: pagelengthValue,
			filter: true,
			info: true,
			scrollY:        '250px',
	        scrollCollapse: true,
	        scrollX: true,
	        paging:         true,
	      
			<?=$dtable_lang?>

				 "initComplete": function(settings, json) {

					// adding switch javscript 


					if(classnamevaluejq == '')
					{
						$("#hidediv2").removeClass(classnamevaluejq);
						$("div#datatables14_wrapper div.row:nth-last-child(2)").removeClass('displayNone');
						$("#datatables13_wrapper").css('height', '');
						$("table#oldatatable").removeClass('displayNone');

					}
					else
					{
						$("#hidediv2").addClass(classnamevaluejq);
						$("div#datatables14_wrapper div.row:nth-last-child(2)").addClass('displayNone');
						$("table#oldatatable").addClass('displayNone');
					}




			  }


		});		

		var dtable6 = $('#datatables16').DataTable({

			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: pagelengthValue,
			filter: true,
			info: true,
			scrollY:        '250px',
	        scrollCollapse: true,
	        scrollX: true,
	        paging:         true,
	      
			<?=$dtable_lang?>

				 "initComplete": function(settings, json) {

					// adding switch javscript 


					if(classnamevaluejq == '')
					{
						$("#hidediv2").removeClass(classnamevaluejq);
						$("div#datatables16_wrapper div.row:nth-last-child(2)").removeClass('displayNone');
						$("#datatables15_wrapper").css('height', '');
						$("table#oldatatable").removeClass('displayNone');

					}
					else
					{
						$("#hidediv2").addClass(classnamevaluejq);
						$("div#datatables16_wrapper div.row:nth-last-child(2)").addClass('displayNone');
						$("table#oldatatable").addClass('displayNone');
					}




			  }


		});

		var dtable8 = $('#datatables18').DataTable({

			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: pagelengthValue,
			filter: true,
			info: true,
			scrollY:        '250px',
	        scrollCollapse: true,
	        scrollX: true,
	        paging:         true,
	      
			<?=$dtable_lang?>

				 "initComplete": function(settings, json) {

					// adding switch javscript 


					if(classnamevaluejq == '')
					{
						$("#hidediv2").removeClass(classnamevaluejq);
						$("div#datatables18_wrapper div.row:nth-last-child(2)").removeClass('displayNone');
						$("#datatables17_wrapper").css('height', '');
						$("table#oldatatable").removeClass('displayNone');

					}
					else
					{
						$("#hidediv2").addClass(classnamevaluejq);
						$("div#datatables18_wrapper div.row:nth-last-child(2)").addClass('displayNone');
						$("table#oldatatable").addClass('displayNone');
					}




			  }


		});		

		var dtable10 = $('#datatables20').DataTable({

			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: pagelengthValue,
			filter: true,
			info: true,
			scrollY:        '250px',
	        scrollCollapse: true,
	        scrollX: true,
	        paging:         true,
			<?=$dtable_lang?>
			
				 "initComplete": function(settings, json) {

					// adding switch javscript 
					if(classnamevaluejq == '')
					{
						$("#hidediv2").removeClass(classnamevaluejq);
						$("div#datatables20_wrapper div.row:nth-last-child(2)").removeClass('displayNone');
						$("#datatables19_wrapper").css('height', '');
						$("table#oldatatable").removeClass('displayNone');
					}
					else
					{
						$("#hidediv2").addClass(classnamevaluejq);
						$("div#datatables20_wrapper div.row:nth-last-child(2)").addClass('displayNone');
						$("table#oldatatable").addClass('displayNone');
					}
			  }
		});

		var dtable12 = $('#datatables22').DataTable({

			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: pagelengthValue,
			filter: true,
			info: true,
			scrollY:        '250px',
	        scrollCollapse: true,
	        scrollX: true,
	        paging:         true,
			<?=$dtable_lang?>
			
				 "initComplete": function(settings, json) {

					// adding switch javscript 
					if(classnamevaluejq == '')
					{
						$("#hidediv2").removeClass(classnamevaluejq);
						$("div#datatables22_wrapper div.row:nth-last-child(2)").removeClass('displayNone');
						$("#datatables21_wrapper").css('height', '');
						$("table#oldatatable").removeClass('displayNone');
					}
					else
					{
						$("#hidediv2").addClass(classnamevaluejq);
						$("div#datatables22_wrapper div.row:nth-last-child(2)").addClass('displayNone');
						$("table#oldatatable").addClass('displayNone');
					}
			  }
		});		

		var dtable14 = $('#datatables24').DataTable({

			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: pagelengthValue,
			filter: true,
			info: true,
			scrollY:        '250px',
	        scrollCollapse: true,
	        scrollX: true,
	        paging:         true,
			<?=$dtable_lang?>
			
				 "initComplete": function(settings, json) {

					// adding switch javscript 
					if(classnamevaluejq == '')
					{
						$("#hidediv2").removeClass(classnamevaluejq);
						$("div#datatables24_wrapper div.row:nth-last-child(2)").removeClass('displayNone');
						$("#datatables23_wrapper").css('height', '');
						$("table#oldatatable").removeClass('displayNone');
					}
					else
					{
						$("#hidediv2").addClass(classnamevaluejq);
						$("div#datatables24_wrapper div.row:nth-last-child(2)").addClass('displayNone');
						$("table#oldatatable").addClass('displayNone');
					}
			  }
		});

		
		var dtable16 = $('#datatables26').DataTable({

			lengthChange: false,
			searching: true,
			ordering: false,
			pagingType: 'full_numbers',
			pageLength: pagelengthValue,
			filter: true,
			info: true,
			scrollY:        '250px',
	        scrollCollapse: true,
	        scrollX: true,
	        paging:         true,
			<?=$dtable_lang?>
			"initComplete": function(settings, json) {

					// adding switch javscript 
					if(classnamevaluejq == '')
					{
						$("#hidediv2").removeClass(classnamevaluejq);
						$("div#datatables26_wrapper div.row:nth-last-child(2)").removeClass('displayNone');
						$("#datatables25_wrapper").css('height', '');
						$("table#oldatatable").removeClass('displayNone');
					}
					else
					{
						$("#hidediv2").addClass(classnamevaluejq);
						$("div#datatables26_wrapper div.row:nth-last-child(2)").addClass('displayNone');
						$("table#oldatatable").addClass('displayNone');
					}
			  }
		});
		//dtables.columns.adjust();
		//dtables15.columns.adjust();
		//for(i=)
		$("#searchFilter").keyup(function() {
			dtable.search(this.value).draw();
		});


		$("#clearSearchbox").click(function() {
			$("#searchFilterd").val('');
			datatableEmppp.search('').draw();

		});		

		$("#clearSearchbox2").click(function() {

			$("#searchFilterd2").val('');
			dtable.search('').draw();

		});

		$(document).on("change", "#pageLength", function(e) {
			if(this.value > 0){
				dtable.page.len( this.value ).draw();
			}
		})





		$(document).on("change", "#pageLengthsecondtable", function(e) {
			if(this.value > 0){
				dtable2.page.len( this.value ).draw();
				dtable.page.len( this.value ).draw();
			}
		});



// ============================= VERIFICATION CENTER  TAB  ========================//

		var logTable = $('#logTable').DataTable({

			responsive: true,
			scrollY: false,
			scrollX: false,
			lengthChange: false,
			searching: true,
			ordering: true,
			paging: true,
			pageLength: 12,
			filter: true,
			info: false,
			<?=$dtable_lang?>
			ajax: {
				url: ROOT+"employees/ajax/server_get_temp_log.php",
				type: 'POST',
				
			},
		   "columnDefs": [
						      { className: "fieldColumn", "targets": [ 2 ] },
						      { className: "batchNoColumn displayNone", "targets": [ 3 ] },
					

					    ],

			initComplete : function( settings, json ) {

				// $('#showTable').fadeIn(400);
				logTable.draw();
				// logTable.columns.adjust().draw();

			}
		});		

		var employeeMissFields = $('#employeeMissFields').DataTable({

			responsive: true,
			scrollY: false,
			scrollX: false,
			lengthChange: false,
			searching: true,
			ordering: true,
			paging: true,
			pageLength: 12,
			filter: true,
			info: false,
			<?=$dtable_lang?>

		});


		$("#searchFilterLogHistory").keyup(function() {
			var s = $(this).val();
			logTable.search(s).draw();
		});
		$(document).on("click", "#clearSearchboxLogHistory", function(e) {
			$('#searchFilterLogHistory').val('');
			logTable.search('').draw();
		})


		$("#searchFilterLogHistoryMissFields").keyup(function() {
			var s = $(this).val();
			employeeMissFields.search(s).draw();
		});
		$(document).on("click", "#clearSearchboxLogHistoryMissFields", function(e) {
			$('#searchFilterLogHistoryMissFields').val('');
			employeeMissFields.search('').draw();
		})



