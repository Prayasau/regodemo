



	$(document).ready(function() {
		
		var update = <?=json_encode($update)?>;
		var emp_id = <?=json_encode($_SESSION['rego']['empID'])?>;
		var fix_allow = <?=json_encode($fix_allow)?>;
		var incdedFix = <?=json_encode($fixalldedarr)?>;
		var ecdata = <?=json_encode($ecdata)?>;


		var dateParmeter;
		if(ecdata.length == 0){
			dateParmeter = '';
		}else{
			dateParmeter = 'new Date()';
		}

		$(document).on("click", "#modifydata_editBenfits_li ,.commonEditColumnBenefit", function(e){
			//alert(dateParmeter);
			$(".sdatepick1").datepicker("destroy");
			$('#modalAddEmpcareer input#sdates').removeClass('sdatepick1').addClass('startPicker');
			$('#modalAddEmpcareer input[name="end_date_new"]').attr('readonly',true).removeClass('sdatepick1');

			$('.startPicker').datepicker({
				format: "dd-mm-yyyy",
				autoclose: true,
				inline: false,
				language: lang,
				todayHighlight: true,
				startDate: dateParmeter,
				orientation: "bottom left",
				
			}).on('changeDate', function(e){

				var dval = $('#modalAddEmpcareer input[name="start_date_new"]').val();
				$.ajax({
					url: "ajax/career_exist.php",
					type: 'POST',
					data: {dval:dval},
					success: function(result){

						if(result == 1){
							$("body").overhang({
								type: "error",
								message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;<?=$lng['Data'].' '.$lng['exist already']?>',
								duration: 2,
							})

							$('#modalAddEmpcareer input[name="start_date_new"]').val('');

						}else{
							
							var changeFormat = e.format();
							var datearray = changeFormat.split("-");
							var newdatemdy = datearray[1] + '-' + datearray[0] + '-' + datearray[2];

							var days = 1;
							var newdate1 = new Date(newdatemdy);
							var deductDate = newdate1.setDate(newdate1.getDate() - days);
							var dd = new Date(deductDate);
							//var end_date = dd.getDate() + '-' + (dd.getMonth()+1) + '-' + dd.getFullYear();
							var end_date = ('0' + dd.getDate()).slice(-2) + '-' + ('0' + (dd.getMonth()+1)).slice(-2) + '-' + dd.getFullYear();

							var start_date_curr = $('#modalAddEmpcareer input[name="start_date_curr"]').val();
							if(start_date_curr != ''){
								$('#modalAddEmpcareer input[name="end_date_curr"]').val(end_date);
							}

						}
					}
				})
			})


			$('#modalAddEmpcareer').modal('toggle');
		})

		$(document).on("click", "#CareerModalhis", function(e){

			$(".startPicker").datepicker("destroy");
			$('#modalAddEmpcareer input#sdates').removeClass('startPicker').addClass('sdatepick1');
			$('#modalAddEmpcareer input[name="end_date_new"]').attr('readonly',false).addClass('sdatepick1');
			
			$('.sdatepick1').datepicker({
				format: "dd-mm-yyyy",
				autoclose: true,
				inline: false,
				language: lang,
				todayHighlight: true,
				endDate: new Date(),
				orientation: "bottom left",
				
			}).on('changeDate', function(e){

				var dval = $('#modalAddEmpcareer input[name="start_date_new"]').val();
				$.ajax({
					url: "ajax/career_exist.php",
					type: 'POST',
					data: {dval:dval},
					success: function(result){

						if(result == 1){
							$("body").overhang({
								type: "error",
								message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;<?=$lng['Data'].' '.$lng['exist already']?>',
								duration: 2,
							})

							$('#modalAddEmpcareer input[name="start_date_new"]').val('');
						}
					}
				})
			})

			$('#modalAddEmpcareer').modal('toggle');
		})

		$('.startPicker').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			inline: false,
			language: lang,
			todayHighlight: true,
			startDate: new Date(),
			orientation: "bottom left",
			
		}).on('changeDate', function(e){

			var dval = $('#modalAddEmpcareer input[name="start_date_new"]').val();
			$.ajax({
				url: "ajax/career_exist.php",
				type: 'POST',
				data: {dval:dval},
				success: function(result){

					if(result == 1){
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;<?=$lng['Data'].' '.$lng['exist already']?>',
							duration: 2,
						})

						$('#modalAddEmpcareer input[name="start_date_new"]').val('');

					}else{
						
						var changeFormat = e.format();
						var datearray = changeFormat.split("-");
						var newdatemdy = datearray[1] + '-' + datearray[0] + '-' + datearray[2];

						var days = 1;
						var newdate1 = new Date(newdatemdy);
						var deductDate = newdate1.setDate(newdate1.getDate() - days);
						var dd = new Date(deductDate);
						//var end_date = dd.getDate() + '-' + (dd.getMonth()+1) + '-' + dd.getFullYear();
						var end_date = ('0' + dd.getDate()).slice(-2) + '-' + ('0' + (dd.getMonth()+1)).slice(-2) + '-' + dd.getFullYear();

						var start_date_curr = $('#modalAddEmpcareer input[name="start_date_curr"]').val();
						if(start_date_curr != ''){
							$('#modalAddEmpcareer input[name="end_date_curr"]').val(end_date);
						}

					}
				}
			})
		})

		$('.datepick1').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			inline: false,
			language: lang,
			todayHighlight: true,
			startDate: new Date(),
			orientation: "bottom left",
			
		})


		$("#financialForm").on('submit', function(e){ // SUBMIT EMPLOYEE FORM ///////////////////////////////////
			e.preventDefault();
			var data = new FormData(this);
			$.ajax({
				url: "ajax/update_employees.php",
				type: 'POST',
				data: data,
				async: false,
				cache: false,
				contentType: false,
				processData: false,
				success: function(result){
					//$('#dump').html(result); return false;
					$("#submitBtn").removeClass('flash');
					$("#sAlert").fadeOut(200);

					if($.trim(result) == 'success'){
						$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
							duration: 2,
							callback: function(v){
								location.reload();
							}
						})
						if(!update){
							setTimeout(function(){location.reload();},1000);
						}
					}else{
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+result,
							duration: 4,
						})
					}
					//setTimeout(function(){$("#submitBtn i").removeClass('fa-refresh fa-spin').addClass('fa-save');},500);
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		})

		var dayhours = 8;
		var workdays = 30;
		$(".calcRate, #base_salary").on('change', function(){
			var wage = parseFloat($('#base_salary').val());
			$.each(fix_allow, function(i, v){
				if(v.rate == 'Y'){
					wage += parseFloat($('input[name="fix_allow_'+i+'"]').val());
				}
			})
			if($('#contract_type').val() == 'day'){
				var day_rate = parseInt(wage);
				var hour_rate = (parseInt(wage) / parseInt(dayhours));
			}else{
				var day_rate = (parseInt(wage) / parseInt(workdays));
				var hour_rate = (parseInt(wage) / parseInt(workdays) / parseInt(dayhours));
			}
			$('input[name="day_rate"]').val(day_rate)
			$('input[name="hour_rate"]').val(hour_rate)
			$('#day_rate').val(parseFloat(day_rate).format(2))
			$('#hour_rate').val(parseFloat(hour_rate).format(2))
		})
		if($('input[name="day_rate"]').val() == 0){
			$(".calcRate").trigger('change');
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		}
	
		// DOCUMENTS ///////////////////////////////////////////////////////////////////////////////
		$("#att_bankbook").change(function(){
			readAttURL(this,'#bankbook_name');
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		});
		$("#att_contract").change(function(){
			readAttURL(this,'#contract_name');
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		});
		$("#attach5").change(function(){
			readAttURL(this,'#attach5_name');
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		});
		$("#attach6").change(function(){
			readAttURL(this,'#attach6_name');
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		});
		$("#attach7").change(function(){
			readAttURL(this,'#attach7_name');
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		});
		$("#attach8").change(function(){
			readAttURL(this,'#attach8_name');
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		});
		
		$('.delDoc').confirmation({
			container: 'body',
			rootSelector: '.delDoc',
			singleton: true,
			animated: 'fade',
			placement: 'left',
			popout: true,
			html: true,
			title: '<?=$lng['Are you sure']?>',
			btnOkClass: 'btn btn-danger',
			btnOkLabel: '<?=$lng['Delete']?>',
			btnCancelClass: 'btn btn-success',
			btnCancelLabel: '<?=$lng['Cancel']?>',
			onConfirm: function() { 
				$.ajax({
					url: "ajax/delete_document.php",
					data:{emp_id: emp_id, doc: $(this).data('id')},
					success: function(result){
						//$('#dump').html(result); return false;
						location.reload();
					}
				});
			}
		});
		
		
		
		
		
		$('input, textarea').on('keyup', function(e){
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		})
		$('input, select').on('change', function(e){
			$('#sAlert').fadeIn(200);
			$("#submitBtn").addClass('flash');
		})



		// CAREER FORM ///////////////////////////////////////////////////////////////////////////////
		var caTable = $('#career_tabless').DataTable({
			scrollY: false,
			scrollX: false,
			lengthChange: false,
			searching: false,
			ordering: false,
			paging: false,
			filter: false,
			info: false,
			<?=$dtable_lang?>
			
		});


		$(document).on('click','#career_table tbody tr', function(){
			//var id = caTable.row(this).data()[4];
			$('select[name="position"] option').attr('selected',false)
			var id = $(this).data('id');
			$.ajax({
				url: "ajax/get_employee_benefit.php",
				type: "POST", 
				data: {id: id, field: 'career'},
				dataType: 'json',
				success: function(data){
					//$("#dump").html(data); //return false;

					//alert(data.salary);

					//$('#careerFormHis #caID').val(data.id);
					$('select[name="position"] option[value="'+data.position+'"]').attr('selected',true)
					$('input[name="month"]').val(data.month)
					$('input[name="department"]').val(data.department)
					$('input[name="start_date"]').val(data.start_date)
					$('input[name="end_date"]').val(data.end_date)
					$('input#salary').val(data.salary)
					$('textarea[name="benefits"]').val(data.benefits)
					$('textarea[name="other_benifits"]').val(data.other_benifits)
					$('textarea[name="classification"]').val(data.classification)
					$('textarea[name="remarks"]').val(data.remarks)
					$('#caAttach').empty();
					$.each(data.attachment, function(i,val){
						$('#caAttach').append(
							'<div class="attachDiv">'+
								'<a target="_blank" href="<?=ROOT.$cid?>/career/'+val+'"class="link">'+val+'</a>'+
								'<a data-key="'+i+'" class="icon delAttach"><i class="fa fa-trash"></i></a>'+
							'</div>'
						)
					})
					$("#caColor").css('background', 'rgba(200,255,200,0.1)');
					$("#careerTable").show();
					$("#caBtn").show();
					$("#caAction").html('- Edit');
					$('button#caBtn').attr('disabled',false);

					$('tr.fixAllclass').remove();
					$('tr.fixdedclass').remove();
					
					$.each(data.fix_allows, function(i,val){
						if(val > 0){
							$('tr#fixallowsec').after(
								'<tr class="fixAllclass" style="background: #ebfbea;"><th>'+incdedFix[i]+'</th><td>'+val+'</td></tr>'
							)
						}
					})

					$.each(data.fix_deducts, function(i,val){
						if(val > 0){
							$('tr#fixdeductsec').after(
								'<tr class="fixdedclass" style="background: #ebfbea;"><th>'+incdedFix[i]+'</th><td>'+val+'</td></tr>'
							)
						}
					})

					autosize.destroy(document.querySelectorAll('textarea'));
					autosize(document.querySelectorAll('textarea'));
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		})

		$("#addCareer").on('click', function(e){
			$("#careerForm").trigger('reset');
			$('#caAttach').empty();
			$("#caID").val(0);
			$("#careerTable").show();
			$("#caBtn").show();
			$("#caAction").html('- New');
			$("#caColor").css('background', 'rgba(255,200,200,0.08)');
			$("table#career_table tr").removeClass("selected");
		})


		$('.sdatepick1').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			inline: false,
			language: lang,
			todayHighlight: true,
			endDate: new Date(),
			orientation: "bottom left",
			
		}).on('changeDate', function(e){

			var dval = $('#modalAddEmpcareer input[name="start_date"]').val();
			$.ajax({
				url: "ajax/career_exist.php",
				type: 'POST',
				data: {dval:dval},
				success: function(result){

					if(result == 1){
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;<?=$lng['Data'].' '.$lng['exist already']?>',
							duration: 2,
						})

						$('#modalAddEmpcareer input[name="start_date"]').val('');
					}
				}
			})
		})

		$('.edatepick1').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			inline: false,
			language: lang,
			todayHighlight: true,
			endDate: new Date(),
			orientation: "bottom left",
			
		})


		$(document).on('change', "#careerForm .attachBtn", function(e){
			readFileURL(this, '#attachCareer');
			$("#caBtn").addClass('flash');
			$('#sAlert').fadeIn(200);
		})
		$(document).on("click", "#careerForm .delAttach", function(e){
			var key = $(this).data('key')
			var app = $(this);
			$.ajax({
				url: "ajax/delete_benefit_attach.php",
				data: {id: $("#caID").val(), key: key, field: 'career'},
				success: function(result){
					//$('#dump').html(result);
					app.parent().remove();
				},
				error:function (xhr, ajaxOptions, thrownError){
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?>&nbsp;&nbsp;<b><?=$lng['Error']?></b> : '+thrownError,
						duration: 4,
					})
				}
			});
		});
		$('#careerForm input, #careerForm textarea').on('keyup', function(e){
			$('#sAlert').fadeIn(200);
			$("#caBtn").addClass('flash');
		})
		$('#careerForm .datepick').datepicker({
			format: "dd-mm-yyyy",
			autoclose: true,
			inline: true,
			language: lang,//lang+'-th',
			todayHighlight: true,
		}).on('changeDate', function(ev){
			$('#sAlert').fadeIn(200);
			$("#caBtn").addClass('flash');
		});	



		


	})

	
	var currentTab = 0;
	showTab(currentTab);

	function showTab(n) {
	  var x = document.getElementsByClassName("tabs"); 

	  console.log(x);
	  console.log(n);
	  x[n].style.display = "block";
	
	  if (n == 0) {
	    document.getElementById("prevBtn1").style.display = "none";
	  } else {
	    document.getElementById("prevBtn1").style.display = "inline";
	  }
	  if (n == (x.length - 1)) {
	    document.getElementById("nextBtn1").innerHTML = "Submit";
	  } else {
	    document.getElementById("nextBtn1").innerHTML = "Next";
	  }
	}

	function nextPrev1(n) {
	  var x = document.getElementsByClassName("tabs");


	  x[currentTab].style.display = "none";
	  currentTab = currentTab + n;
	  if (currentTab >= x.length) {
	    SaveNewUsersssForm();
	    return false;
	  }
	 showTab(currentTab);
	}


	function SaveNewUsersssForm(){

		var formData = new FormData($('#modalAddEmpcareer #careerForm')[0]);

		alert('Working on saving the data to temporary database');
		return false;

		$.ajax({
			url: "ajax/update_batch_data/update_batch_data_benefits_text.php",
			type: "POST", 
			data: formData,
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false,
			success: function(data){
				//$("#dump").html(data); return false;
				if(data.result == 'success'){
					$("body").overhang({
						type: "success",
						message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
						duration: 2,
						callback: function(v){
							// window.location.reload();
						}
					})
					
				}else{
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+data.result,
						duration: 2,
						callback: function(v){
							// window.location.reload();
						}
					})
				}
			},
			error:function (xhr, ajaxOptions, thrownError){
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
					duration: 4,
					callback: function(v){
						// window.location.reload();
					}
				})
			}
		});

	}
