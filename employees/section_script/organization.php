	$(document).ready(function() {

	var teams = <?=json_encode($teams)?>;
	var entities = <?=json_encode($entities)?>;
	var branches = <?=json_encode($branches)?>;
	var divisions = <?=json_encode($divisions)?>;
	var departments = <?=json_encode($departments)?>;
	var groups = <?=json_encode($groups)?>;
	var organization = <?=json_encode($organization)?>;
	var parameters = <?=json_encode($parameters)?>;
	var eCount = <?=count($entities)?>;

	// console.log(parameters);
	// console.log(eCount);
	// console.log(organization);
	// return false;
	
	$(document).on("click", "#modifydata_OrgModalsel_li", function(e){
		$('#modalorganization').modal('toggle');
	})

	$(document).on("change", ".orgSel", function(e){

		var entity = '';
		var branch = '';
		var division = '';
		var department = '';
		var team = '';
		var btnactive = [];

		if(eCount > 1){ 
			entity = $('#modalorganization #userEntities').val();
		}

		if(parameters[1]['apply_param'] == 1){ 
			branch = $('#modalorganization #userBranches').val();
			if(branch >= 1){ btnactive.push(1); }else{ btnactive.push(0); }
		}

		if(parameters[2]['apply_param'] == 1){ 
			division = $('#modalorganization #userDivisions').val();
			if(division >= 1){ btnactive.push(1); }else{ btnactive.push(0); }
		}

		if(parameters[3]['apply_param'] == 1){ 
			department = $('#modalorganization #userDepartments').val();
			if(department >= 1){ btnactive.push(1); }else{ btnactive.push(0); }
		}

		if(parameters[4]['apply_param'] == 1){ 
			team = $('#modalorganization #userTeams').val();
			if(team >= 1){ btnactive.push(1); }else{ btnactive.push(0); }
		} 

		//console.log(btnactive);
		//$('#modalorganization span#spnmsg').addClass('text-danger').text('Selection incomplete');


		if($.inArray(0, btnactive) !== -1) {
			$('#modalorganization #confirmbtn').attr('disabled', true);
		}else{ 
			$('#modalorganization #confirmbtn').attr('disabled', false);
		}

		$.ajax({
			url: "ajax/get_orgnization_selection.php",
			type: "POST", 
			data: {entity:entity, branch:branch, division:division, department:department, team:team},
			success: function(result){

				$('#modalorganization #usersAccess tbody#accessBodyorg tr').remove();
				$('#modalorganization #usersAccess tbody#accessBodyorg').html(result);

				var remainingRows = $('#modalorganization #usersAccess tbody#accessBodyorg tr').length;
				
				if(remainingRows == 1) {
					$('#modalorganization #confirmbtn').attr('disabled', false);
					$('#modalorganization span#spnmsg').removeClass('text-danger').addClass('text-success').text('Selection Complete');
				}else{ 
					$('#modalorganization #confirmbtn').attr('disabled', true);
					$('#modalorganization span#spnmsg').addClass('text-danger').removeClass('text-success').text('Selection incomplete');
				}
			}
		})



	})


		$('.ConfirmSelection').on('click', function(e){

			var orgval = $('#modalorganization #usersAccess tbody#accessBodyorg tr').data('id');
			
			if(orgval == ''){
				$('#empEntity').val('')
				$('#empBranch').val('')
				$('#empDivision').val('')
				$('#empDepartment').val('')
				$('#teams').val('')

				$('#txtEntity').html('...')
				$('#txtBranch').html('...')
				$('#txtDivision').html('...')
				$('#txtDepartment').html('...')
				$('#team_name').val('MAIN')
				$('#teams').val('main')
				//$('#txtGroups').html('...')
			}else{
				

				console.log(organization[orgval]['teams']);

				var companyValue = organization[orgval]['company'] ;
				var locationValue = organization[orgval]['locations'];
				var divisionValue = organization[orgval]['divisions'];
				var departmentsvalue = organization[orgval]['departments'];
				var teamsValue = teams[organization[orgval]['teams']][lang];
				var teamNumericValue =organization[orgval]['teams'];


				$.ajax({
					url: "ajax/update_batch_data/update_batch_data_organization.php",
					type: "POST", 
					data: {companyValue:companyValue,teamsValue:teamsValue, locationValue:locationValue, divisionValue:divisionValue, departmentsvalue:departmentsvalue, teamNumericValue:teamNumericValue},
					success: function(result){

					$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
							duration: 1,
							
					})
					setTimeout(function(){location.reload();}, 1000);
	
					}
				})




			}

			$('#modalorganization').modal('hide');
			//$('#sAlert').fadeIn(200);
			//$("#submitBtn").addClass('flash');
		})





		/////////////////===================================== SECOND POPUP ======================================/////////////

	$(document).on("click", ".commonEditColumnOrganization", function(e){

	var allfieldsArray = <?=json_encode($allfieldsArray)?>;
	var classNameString = $(this).closest('td.commonEditColumnOrganization').attr('class');
	var avoid = "commonEditColumnOrganization";
	var fieldToUpdate = $.trim(classNameString.replace(avoid,''));

	var oldvalue = $(this).closest('td.commonEditColumnOrganization').html();
	var rowId = $(this).closest('tr').children('td:first').find('span#rowIdDatatableSpan').html();

	$('#modalorganization2').modal('toggle');
	$('#hiddenrowidfororg').val(rowId);



});


$(document).on("change", ".orgSel2", function(e){

		var entity2 = '';
		var branch2 = '';
		var division2 = '';
		var department2 = '';
		var team2 = '';
		var btnactive2 = [];

		if(eCount > 1){ 
			entity2 = $('#modalorganization2 #userEntities2').val();
		}

		if(parameters[1]['apply_param'] == 1){ 
			branch2 = $('#modalorganization2 #userBranches2').val();
			if(branch2 >= 1){ btnactive2.push(1); }else{ btnactive2.push(0); }
		}

		if(parameters[2]['apply_param'] == 1){ 
			division2 = $('#modalorganization2 #userDivisions2').val();
			if(division2 >= 1){ btnactive2.push(1); }else{ btnactive2.push(0); }
		}

		if(parameters[3]['apply_param'] == 1){ 
			department2 = $('#modalorganization2 #userDepartments2').val();
			if(department2 >= 1){ btnactive2.push(1); }else{ btnactive2.push(0); }
		}

		if(parameters[4]['apply_param'] == 1){ 
			team2 = $('#modalorganization2 #userTeams2').val();
			if(team2 >= 1){ btnactive2.push(1); }else{ btnactive2.push(0); }
		} 

		if($.inArray(0, btnactive2) !== -1) {
			$('#modalorganization2 #confirmbtn2').attr('disabled', true);
		}else{ 
			$('#modalorganization2 #confirmbtn2').attr('disabled', false);
		}

		$.ajax({
			url: "ajax/get_orgnization_selection.php",
			type: "POST", 
			data: {entity:entity2, branch:branch2, division:division2, department:department2, team:team2},
			success: function(result){

				$('#modalorganization2 #usersAccess2 tbody#accessBodyorg2 tr').remove();
				$('#modalorganization2 #usersAccess2 tbody#accessBodyorg2').html(result);

				var remainingRows = $('#modalorganization2 #usersAccess2 tbody#accessBodyorg2 tr').length;
				
				if(remainingRows == 1) {
					$('#modalorganization2 #confirmbtn2').attr('disabled', false);
					$('#modalorganization2 span#spnmsg2').removeClass('text-danger').addClass('text-success').text('Selection Complete');
				}else{ 
					$('#modalorganization2 #confirmbtn2').attr('disabled', true);
					$('#modalorganization2 span#spnmsg2').addClass('text-danger').removeClass('text-success').text('Selection incomplete');
				}
			}
		})



	})


	$('.ConfirmSelection2').on('click', function(e){

			var orgval = $('#modalorganization2 #usersAccess2 tbody#accessBodyorg2 tr').data('id');
			var hiddenrowidfororg = $('#hiddenrowidfororg').val();
			if(orgval == ''){
				$('#empEntity').val('')
				$('#empBranch').val('')
				$('#empDivision').val('')
				$('#empDepartment').val('')
				$('#teams').val('')

				$('#txtEntity').html('...')
				$('#txtBranch').html('...')
				$('#txtDivision').html('...')
				$('#txtDepartment').html('...')
				$('#team_name').val('MAIN')
				$('#teams').val('main')
				//$('#txtGroups').html('...')
			}else{
				

				console.log(organization[orgval]['teams']);

				var companyValue = organization[orgval]['company'] ;
				var locationValue = organization[orgval]['locations'];
				var divisionValue = organization[orgval]['divisions'];
				var departmentsvalue = organization[orgval]['departments'];
				var teamsValue = teams[organization[orgval]['teams']][lang];
				var teamNumericValue =organization[orgval]['teams'];


				$.ajax({
					url: "ajax/update_batch_data/update_batch_data_organization2.php",
					type: "POST", 
					data: {companyValue:companyValue,teamsValue:teamsValue, locationValue:locationValue, divisionValue:divisionValue, departmentsvalue:departmentsvalue, teamNumericValue:teamNumericValue,hiddenrowidfororg:hiddenrowidfororg},
					success: function(result){

					$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
							duration: 1,
							
					})
					setTimeout(function(){location.reload();}, 1000);
	
					}
				})




			}

			$('#modalorganization2').modal('hide');
			//$('#sAlert').fadeIn(200);
			//$("#submitBtn").addClass('flash');
		})



});


