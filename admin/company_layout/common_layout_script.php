<script type="text/javascript">


$( document ).ready(function() {
    var activeTabEntComLay = localStorage.getItem('activeTabEntComLay');
	console.log(activeTabEntComLay);
	// console.log(activeTabEntComLay);
	if(activeTabEntComLay)
	{
		$('.nav-link[data-target="' + activeTabEntComLay + '"]').tab('show');
	}

	$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
		localStorage.setItem('activeTabEntComLay', $(e.target).attr('data-target'));
	});

});



function increaseValue($id) {
  var value = parseInt(document.getElementById('admin_login_screen_logo_size').value, 10);
  value = isNaN(value) ? 0 : value;
  value++;
  document.getElementById('admin_login_screen_logo_size').value = value;

  if($id == 'adminloginscreen')
  {
  		$('#admin_logo_image_preview_logo_and_headers').css({
	        "height": value+'px',
	    });	
  } 
  else if($id == 'adminloginscreentitle')
  {
  		$('#admin_login_screen_logo_title').css({
	        "height": value+'px',
	    });	
  }  
  else if($id == 'admindashboardbannerlogo')
  {
  		$('#admin_dashboard_banner_logo_logoandheaders').css({
	        "height": value+'px',
	    });	
  }  
  else if($id == 'systemloginscreen')
  {
  		$('#system_logo_image_select_logoandheaders_loginscreenlogo').css({
	        "height": value+'px',
	    });	
  }  
  else if($id == 'systemloginscreentitle')
  {
  		$('#system_logo_image_select_logoandheaders_loginscreenlogo_title').css({
	        "height": value+'px',
	    });	
  }
}

function decreaseValue($id) {
  var value = parseInt(document.getElementById('admin_login_screen_logo_size').value, 10);
  value = isNaN(value) ? 0 : value;
  value < 1 ? value = 1 : '';
  value--;
  document.getElementById('admin_login_screen_logo_size').value = value;

  if($id == 'adminloginscreen')
  {
  		$('#admin_logo_image_preview_logo_and_headers').css({
	        "height": value+'px',
	    });	
  }
  else if($id == 'adminloginscreentitle')
  {
  		$('#admin_login_screen_logo_title').css({
	        "height": value+'px',
	    });	
  }
  else if($id == 'admindashboardbannerlogo')
  {
  		$('#admin_dashboard_banner_logo_logoandheaders').css({
	        "height": value+'px',
	    });	
  }
  else if($id == 'systemloginscreen')
  {
  		$('#system_logo_image_select_logoandheaders_loginscreenlogo').css({
	        "height": value+'px',
	    });	
  }  
  else if($id == 'systemloginscreentitle')
  {
  		$('#system_logo_image_select_logoandheaders_loginscreenlogo_title').css({
	        "height": value+'px',
	    });	
  }

}


</script>

	<script>
		
	$(document).ready(function() {
		$('#subButton').on('click', function () { 
			$("#companyForm").submit(function(e){ 
				e.preventDefault();
				var data = new FormData($(this)[0]);
				console.log(data);
				$("#subButton i").removeClass('fa-save').addClass('fa-rotate-right fa-spin');
				
				$.ajax({
					url: AROOT+"ajax/update_layout_settings.php",
					type: 'POST',
					data: data,
					async: false,
					cache: false,
					contentType: false,
					processData: false,
					success: function(result){
						if(result == 'success'){
							$("body").overhang({
								type: "success",
								message: '<i class="fa fa-check"></i>&nbsp;&nbsp;Data updated successfuly',
								duration: 2,
							})

						}else if(result == 'error'){
							$("body").overhang({
								type: "error",
								message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : The selected image must be of 1920 px by 836 px',
								duration: 4,
								closeConfirm: true
							})

						}else{
							$("body").overhang({
								type: "error",
								message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+result,
								duration: 4,
								closeConfirm: true
							})
						}
						setTimeout(function(){
							$("#subButton i").removeClass('fa-refresh fa-spin').addClass('fa-save');
							$("#subButton").removeClass('flash');
							$("#sAlert").fadeOut(200);
							// location.reload();
						},500);
					},
					error:function (xhr, ajaxOptions, thrownError){
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
							duration: 8,
							closeConfirm: "true",
						})
					}
				});
			});
		});
	});

var colorArray = '<?php echo json_encode($selectedColorsVal)?>';
var fontArray = '<?php echo json_encode($font_data[0])?>';
var colorSetArray = '<?php echo json_encode($color_palette_data)?>';
var colorSetArrayManual = '<?php echo json_encode($color_palette_data_manaual)?>';

// 	MOB ARRAY VALUES 
var mobcolorSetArray = '<?php echo json_encode($mob_color_palette_data)?>';
var mobcolorSetArrayManual = '<?php echo json_encode($mob_color_palette_data_manaual)?>';


$( document ).ready(function() {
	var colourName1 = $('#colorSelect1').val();
	var colorJson1 = JSON.parse(colorArray);
	var colorCode1 = colorJson1[colourName1];
	$('#circle1').css('color', colorCode1);
	$('.div1').css('background', colorCode1);


	var colourName2 = $('#colorSelect2').val();
	var colorJson2 = JSON.parse(colorArray);
	var  colorCode2 = colorJson2[colourName2];
	$('#circle2').css('color', colorCode2);
	$('.div2').css('background', colorCode2);

	var colourName3 = $('#colorSelect3').val();
	var colorJson3 = JSON.parse(colorArray);
	var colorCode3 = colorJson3[colourName3];
	$('#circle3').css('color', colorCode3);
	$('.div3').css('background', colorCode3);

	var colourName4 = $('#colorSelect4').val();
	var colorJson4 = JSON.parse(colorArray);
	var colorCode4 = colorJson4[colourName4];
	$('#circle4').css('color', colorCode4);
	$('.div4').css('background', colorCode4);

	var colourName5 = $('#colorSelect5').val();
	var colorJson5 = JSON.parse(colorArray);
	var colorCode5 = colorJson5[colourName5];
	$('#circle5').css('color', colorCode5);
	$('.div5').css('background', colorCode5);

	var colourName6 = $('#colorSelect6').val();
	var colorJson6 = JSON.parse(colorArray);
	var colorCode6 = colorJson6[colourName6];
	$('#circle6').css('color', colorCode6);
	$('.div6').css('background', colorCode6);

	var colourName7 = $('#colorSelect7').val();
	var colorJson7 = JSON.parse(colorArray);
	var colorCode7 = colorJson7[colourName7];
	$('#circle7').css('color', colorCode7);
	$('.div7').css('background', colorCode7);

	var colourName8 = $('#colorSelect8').val();
	var colorJson8 = JSON.parse(colorArray);
	var colorCode8 = colorJson8[colourName8];
	$('#circle8').css('color', colorCode8);
	$('.div8').css('background', colorCode8);

	var colourName9 = $('#colorSelect9').val();
	var colorJson9 = JSON.parse(colorArray);
	var colorCode9 = colorJson9[colourName9];
	$('#circle9').css('color', colorCode9);
	$('.div9').css('background', colorCode9);

	var colourName10 = $('#colorSelect10').val();
	var colorJson10 = JSON.parse(colorArray);
	var colorCode10 = colorJson10[colourName10];
	$('#circle10').css('color', colorCode10);
	$('.div10').css('background', colorCode10);

	var colourName11 = $('#colorSelect11').val();
	var colorJson11 = JSON.parse(colorArray);
	var colorCode11 = colorJson11[colourName11];
	$('#circle11').css('color', colorCode11);
	$('.div11').css('background', colorCode11);

	var colourName12 = $('#colorSelect12').val();
	var colorJson12 = JSON.parse(colorArray);
	var colorCode12 = colorJson12[colourName12];
	$('#circle12').css('color', colorCode12);
	$('.div12').css('background', colorCode12);

	var colourName13 =  $('#colorSelect13').val();
	var colorJson13 = JSON.parse(colorArray);
	var  colorCode13 = colorJson13[colourName13];
	$('#circle13').css('color', colorCode13);
	$('.div13').css('background', colorCode13);


	var colourName14 =$('#colorSelect14').val();
	var colorJson14 = JSON.parse(colorArray);
	var  colorCode14 = colorJson14[colourName14];
	$('#circle14').css('color', colorCode14);
	$('.div14').css('background', colorCode14);

	var colourName15 = $('#colorSelect15').val();
	var colorJson15 = JSON.parse(colorArray);
	var  colorCode15 = colorJson15[colourName15];
	$('#circle15').css('color', colorCode15);
	$('.h2customcalss h2 ').css('background-color', colorCode15);

	var colourName16 = $('#colorSelect16').val();
	var colorJson16 = JSON.parse(colorArray);
	var colorCode16 = colorJson16[colourName16];
	$('#circle16').css('color', colorCode16);
	$('#rightTable').css('background-color', colorCode16);

	var colourName17 = $('#fontColor').val();
	var colorJson17 = JSON.parse(colorArray);
	var  colorCode17 = colorJson17[colourName17];
	$('.dashbox p span').css('color',colorCode17);	

	var colourNamefontColorcircle = $('#fontColor').val();
	var colorJsonfontColorcircle = JSON.parse(colorArray);
	var  colorCodefontColorcircle = colorJsonfontColorcircle[colourNamefontColorcircle];
	$('#fontColorcircle').css('color',colorCodefontColorcircle);


	var FontName1 = $('#font_settings_box').val();
	if(FontName1 == 'default'){
		$('h2.div15 span').removeAttr('style');
	}
	else{
		$('h2.div15 span').attr('style', 'font-family: '+FontName1);
	}

	var FontName2 = $('#font_settings_box_content').val();
	if(FontName2 == 'default'){
		$('.boxcontent').removeAttr('style');
	}
	else{
		$('.boxcontent').attr('style', 'font-family: '+FontName2);
	}

	var FontName3 = $('#font_settings').val();
	if(FontName3 == 'default'){
		$('.dashbox p').removeAttr('style');
	}else{
		$('.dashbox p').attr('style', 'font-family: '+FontName3);
	}	


});


//====================================================== Color picker 1  =======================================


		$('#colorSelect1').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#circle1').css('color', colorCode);
			$('.div1').css('background', colorCode);
		});


//====================================================== Color picker 2  =======================================


		$('#colorSelect2').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#circle2').css('color', colorCode);
			$('.div2').css('background', colorCode);

		});
		

//====================================================== Color picker 3  =======================================


		$('#colorSelect3').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#circle3').css('color', colorCode);
			$('.div3').css('background', colorCode);

		});
		

//====================================================== Color picker 4  =======================================


		$('#colorSelect4').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#circle4').css('color', colorCode);
			$('.div4').css('background', colorCode);

		});
		

//====================================================== Color picker 5  =======================================


		$('#colorSelect5').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#circle5').css('color', colorCode);
			$('.div5').css('background', colorCode);

		});
		

//====================================================== Color picker 6  =======================================


		$('#colorSelect6').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#circle6').css('color', colorCode);
			$('.div6').css('background', colorCode);

		});

//====================================================== Color picker 7  =======================================


		$('#colorSelect7').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#circle7').css('color', colorCode);
			$('.div7').css('background', colorCode);


		});

//====================================================== Color picker 8  =======================================


		$('#colorSelect8').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#circle8').css('color', colorCode);
			$('.div8').css('background', colorCode);

		});
		
//====================================================== Color picker 9  =======================================


		$('#colorSelect9').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#circle9').css('color', colorCode);
			$('.div9').css('background', colorCode);

		});
				
//====================================================== Color picker 10  =======================================


		$('#colorSelect10').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#circle10').css('color', colorCode);
			$('.div10').css('background', colorCode);

		});
						
//====================================================== Color picker 11  =======================================


		$('#colorSelect11').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#circle11').css('color', colorCode);
			$('.div11').css('background', colorCode);

		});
								
//====================================================== Color picker 12  =======================================


		$('#colorSelect12').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#circle12').css('color', colorCode);
			$('.div12').css('background', colorCode);

		});								
//====================================================== Color picker 13  =======================================


		$('#colorSelect13').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#circle13').css('color', colorCode);
			$('.div13').css('background', colorCode);

		});

//====================================================== Color picker 14  =======================================


		$('#colorSelect14').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#circle14').css('color', colorCode);
			$('.div14').css('background', colorCode);

		});
		
//====================================================== Color picker 15  =======================================


		$('#colorSelect15').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#circle15').css('color', colorCode);
			$('.h2customcalss h2 ').css('background-color', colorCode);

		});
//====================================================== Color picker 16  =======================================


		$('#colorSelect16').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#circle16').css('color', colorCode);
			$('#rightTable').css('background-color', colorCode);

		});
//====================================================== FONT COLOR PICKER  =======================================


		$('#fontColor').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#fontColorcircle').css('color', colorCode);
			$('.dashbox p span').attr('style', 'color: '+colorCode);

		});
		
//====================================================== FONT COLOR PICKER  =========================================

// ================================================== Color Settings Picker  =========================================

		$('#first_color_picker').on('input', function() {
			$('#first_code').val(this.value);
		});
		$('#first_code').on('input', function() {
		  $('#first_color_picker').val(this.value);
		});

		$('#second_color_picker').on('input', function() {
			$('#second_code').val(this.value);
		});
		$('#second_code').on('input', function() {
		  $('#second_color_picker').val(this.value);
		});		

		$('#third_color_picker').on('input', function() {
			$('#third_code').val(this.value);
		});
		$('#third_code').on('input', function() {
		  $('#third_color_picker').val(this.value);
		});

		$('#fourth_color_picker').on('input', function() {
			$('#fourth_code').val(this.value);
		});
		$('#fourth_code').on('input', function() {
		  $('#fourth_color_picker').val(this.value);
		});

		$('#fifth_color_picker').on('input', function() {
			$('#fifth_code').val(this.value);
		});
		$('#fifth_code').on('input', function() {
		  $('#fifth_color_picker').val(this.value);
		});		

		$('#sixth_color_picker').on('input', function() {
			$('#sixth_code').val(this.value);
		});
		$('#sixth_code').on('input', function() {
		  $('#sixth_color_picker').val(this.value);
		});		

		$('#seventh_color_picker').on('input', function() {
			$('#seventh_code').val(this.value);
		});
		$('#seventh_code').on('input', function() {
		  $('#seventh_color_picker').val(this.value);
		});		

		$('#eight_color_picker').on('input', function() {
			$('#eight_code').val(this.value);
		});
		$('#eight_code').on('input', function() {
		  $('#eight_color_picker').val(this.value);
		});

		$('#nine_color_picker').on('input', function() {
			$('#nine_code').val(this.value);
		});
		$('#nine_code').on('input', function() {
		  $('#nine_color_picker').val(this.value);
		});		

		$('#tenth_color_picker').on('input', function() {
			$('#tenth_code').val(this.value);
		});
		$('#tenth_code').on('input', function() {
		  $('#tenth_color_picker').val(this.value);
		});
		$('#eleventh_color_picker').on('input', function() {
			$('#eleventh_code').val(this.value);
		});
		$('#eleventh_code').on('input', function() {
		  $('#eleventh_color_picker').val(this.value);
		});		
		$('#twelfth_color_picker').on('input', function() {
			$('#twelfth_code').val(this.value);
		});
		$('#twelfth_code').on('input', function() {
		  $('#twelfth_color_picker').val(this.value);
		});		

		$('#thirteen_color_picker').on('input', function() {
			$('#thirteen_code').val(this.value);
		});
		$('#thirteen_code').on('input', function() {
		  $('#thirteen_color_picker').val(this.value);
		});

		$('#fourteen_color_picker').on('input', function() {
			$('#fourteen_code').val(this.value);
		});
		$('#fourteen_code').on('input', function() {
		  $('#fourteen_color_picker').val(this.value);
		});
		$('#fifteen_color_picker').on('input', function() {
			$('#fifteen_code').val(this.value);
		});
		$('#fifteen_code').on('input', function() {
		  $('#fifteen_color_picker').val(this.value);
		});

//====================================================== FONT SETTINGS   =======================================


		$('#font_settings').on('change', function() {

			var FontName = this.value+'!important';

			// var fontJson = JSON.parse(fontArray);
			if(this.value == 'default')
			{
				$('.dashbox p').removeAttr('style');
			}
			else
			{
				$('.dashbox p').attr('style', 'font-family: '+FontName);
			}

		});
	

//====================================================== FONT SETTINGS   ===========================================

//====================================================== BOX FONT SETTINGS   =======================================


		$('#font_settings_box').on('change', function() {

			var FontName = this.value+'!important';


			// var fontJson = JSON.parse(fontArray);
			if(this.value == 'default')
			{
				$('h2.div15 span').removeAttr('style');
			}
			else
			{
				$('h2.div15 span').attr('style', 'font-family: '+FontName);
			}

		});
	

//====================================================== Box FONT SETTINGS   ===========================================

//====================================================== BOX FONT SETTINGS   =======================================


		$('#font_settings_box_content').on('change', function() {

			var FontName = this.value+'!important';


			// var fontJson = JSON.parse(fontArray);
			if(this.value == 'default')
			{
				$('.boxcontent').removeAttr('style');
			}
			else
			{
				$('.boxcontent').attr('style', 'font-family: '+FontName);
			}

		});
	

//====================================================== FONT SETTINGS   ===========================================

//====================================================== COLOR SET SETTINGS   =======================================


		$('#colorsetdropdown').on('change', function() {

			var colorSetName = this.value;

			var colorSetJson = JSON.parse(colorSetArray);

			var colorSetColorNames = colorSetJson[colorSetName];


			// first color 
			$('#first_color').val(colorSetJson[colorSetName]['first']['color']);
			$('#first_code').val(colorSetJson[colorSetName]['first']['code']);
			$('#first_color_picker').val(colorSetJson[colorSetName]['first']['code']);
			// second color 
			$('#second_color').val(colorSetJson[colorSetName]['second']['color']);
			$('#second_code').val(colorSetJson[colorSetName]['second']['code']);
			$('#second_color_picker').val(colorSetJson[colorSetName]['second']['code']);	
			// third color 
			$('#third_color').val(colorSetJson[colorSetName]['third']['color']);
			$('#third_code').val(colorSetJson[colorSetName]['third']['code']);
			$('#third_color_picker').val(colorSetJson[colorSetName]['third']['code']);
			// fourth color 
			$('#fourth_color').val(colorSetJson[colorSetName]['fourth']['color']);
			$('#fourth_code').val(colorSetJson[colorSetName]['fourth']['code']);
			$('#fourth_color_picker').val(colorSetJson[colorSetName]['fourth']['code']);			
			// fifth color 
			$('#fifth_color').val(colorSetJson[colorSetName]['fifth']['color']);
			$('#fifth_code').val(colorSetJson[colorSetName]['fifth']['code']);
			$('#fifth_color_picker').val(colorSetJson[colorSetName]['fifth']['code']);			
			// sixth color 
			$('#sixth_color').val(colorSetJson[colorSetName]['sixth']['color']);
			$('#sixth_code').val(colorSetJson[colorSetName]['sixth']['code']);
			$('#sixth_color_picker').val(colorSetJson[colorSetName]['sixth']['code']);		
			// seventh color 
			$('#seventh_color').val(colorSetJson[colorSetName]['seventh']['color']);
			$('#seventh_code').val(colorSetJson[colorSetName]['seventh']['code']);
			$('#seventh_color_picker').val(colorSetJson[colorSetName]['seventh']['code']);			
			// eight color 
			$('#eight_color').val(colorSetJson[colorSetName]['eight']['color']);
			$('#eight_code').val(colorSetJson[colorSetName]['eight']['code']);
			$('#eight_color_picker').val(colorSetJson[colorSetName]['eight']['code']);			
			// nine color 
			$('#nine_color').val(colorSetJson[colorSetName]['nine']['color']);
			$('#nine_code').val(colorSetJson[colorSetName]['nine']['code']);
			$('#nine_color_picker').val(colorSetJson[colorSetName]['nine']['code']);
			// tenth color 
			$('#tenth_color').val(colorSetJson[colorSetName]['tenth']['color']);
			$('#tenth_code').val(colorSetJson[colorSetName]['tenth']['code']);
			$('#tenth_color_picker').val(colorSetJson[colorSetName]['tenth']['code']);			
			// eleventh color 
			$('#eleventh_color').val(colorSetJson[colorSetName]['eleventh']['color']);
			$('#eleventh_code').val(colorSetJson[colorSetName]['eleventh']['code']);
			$('#eleventh_color_picker').val(colorSetJson[colorSetName]['eleventh']['code']);	
			// twelfth color 
			$('#twelfth_color').val(colorSetJson[colorSetName]['twelfth']['color']);
			$('#twelfth_code').val(colorSetJson[colorSetName]['twelfth']['code']);
			$('#twelfth_color_picker').val(colorSetJson[colorSetName]['twelfth']['code']);			
			// thirteen color 
			$('#thirteen_color').val(colorSetJson[colorSetName]['thirteen']['color']);
			$('#thirteen_code').val(colorSetJson[colorSetName]['thirteen']['code']);
			$('#thirteen_color_picker').val(colorSetJson[colorSetName]['thirteen']['code']);			
			// fourteen color 
			$('#fourteen_color').val(colorSetJson[colorSetName]['fourteen']['color']);
			$('#fourteen_code').val(colorSetJson[colorSetName]['fourteen']['code']);
			$('#fourteen_color_picker').val(colorSetJson[colorSetName]['fourteen']['code']);			
			// fifteen color 
			$('#fifteen_color').val(colorSetJson[colorSetName]['fifteen']['color']);
			$('#fifteen_code').val(colorSetJson[colorSetName]['fifteen']['code']);
			$('#fifteen_color_picker').val(colorSetJson[colorSetName]['fifteen']['code']);

			// name value  
			$('#setname_value').val(colorSetJson[colorSetName]['setname']);



		});

//====================================================== COLOR SET MANUAL SETTINGS   =======================================

//====================================================== MOB COLOR SET SETTINGS   =======================================
	

		$('#mobcolorsetdropdown').on('change', function() {

			var mobcolorSetName = this.value;

			console.log(mobcolorSetName);

			var mobcolorSetJson = JSON.parse(mobcolorSetArray);

			var mobcolorSetColorNames = mobcolorSetJson[mobcolorSetName];


			// first color 
			$('#mobfirst_color').val(mobcolorSetJson[mobcolorSetName]['first']['color']);
			$('#mobfirst_code').val(mobcolorSetJson[mobcolorSetName]['first']['code']);
			$('#mobfirst_color_picker').val(mobcolorSetJson[mobcolorSetName]['first']['code']);
			// second color 
			$('#mobsecond_color').val(mobcolorSetJson[mobcolorSetName]['second']['color']);
			$('#mobsecond_code').val(mobcolorSetJson[mobcolorSetName]['second']['code']);
			$('#mobsecond_color_picker').val(mobcolorSetJson[mobcolorSetName]['second']['code']);	
			// third color 
			$('#mobthird_color').val(mobcolorSetJson[mobcolorSetName]['third']['color']);
			$('#mobthird_code').val(mobcolorSetJson[mobcolorSetName]['third']['code']);
			$('#mobthird_color_picker').val(mobcolorSetJson[mobcolorSetName]['third']['code']);
			// fourth color 
			$('#mobfourth_color').val(mobcolorSetJson[mobcolorSetName]['fourth']['color']);
			$('#mobfourth_code').val(mobcolorSetJson[mobcolorSetName]['fourth']['code']);
			$('#mobfourth_color_picker').val(mobcolorSetJson[mobcolorSetName]['fourth']['code']);			
			// fifth color 
			$('#mobfifth_color').val(mobcolorSetJson[mobcolorSetName]['fifth']['color']);
			$('#mobfifth_code').val(mobcolorSetJson[mobcolorSetName]['fifth']['code']);
			$('#mobfifth_color_picker').val(mobcolorSetJson[mobcolorSetName]['fifth']['code']);			
			// sixth color 
			$('#mobsixth_color').val(mobcolorSetJson[mobcolorSetName]['sixth']['color']);
			$('#mobsixth_code').val(mobcolorSetJson[mobcolorSetName]['sixth']['code']);
			$('#mobsixth_color_picker').val(mobcolorSetJson[mobcolorSetName]['sixth']['code']);		
			// seventh color 
			$('#mobseventh_color').val(mobcolorSetJson[mobcolorSetName]['seventh']['color']);
			$('#mobseventh_code').val(mobcolorSetJson[mobcolorSetName]['seventh']['code']);
			$('#mobseventh_color_picker').val(mobcolorSetJson[mobcolorSetName]['seventh']['code']);			
			// eight color 
			$('#mobeight_color').val(mobcolorSetJson[mobcolorSetName]['eight']['color']);
			$('#mobeight_code').val(mobcolorSetJson[mobcolorSetName]['eight']['code']);
			$('#mobeight_color_picker').val(mobcolorSetJson[mobcolorSetName]['eight']['code']);			
			// nine color 
			$('#mobnine_color').val(mobcolorSetJson[mobcolorSetName]['nine']['color']);
			$('#mobnine_code').val(mobcolorSetJson[mobcolorSetName]['nine']['code']);
			$('#mobnine_color_picker').val(mobcolorSetJson[mobcolorSetName]['nine']['code']);
			// tenth color 
			$('#mobtenth_color').val(mobcolorSetJson[mobcolorSetName]['tenth']['color']);
			$('#mobtenth_code').val(mobcolorSetJson[mobcolorSetName]['tenth']['code']);
			$('#mobtenth_color_picker').val(mobcolorSetJson[mobcolorSetName]['tenth']['code']);			
			// eleventh color 
			$('#mobeleventh_color').val(mobcolorSetJson[mobcolorSetName]['eleventh']['color']);
			$('#mobeleventh_code').val(mobcolorSetJson[mobcolorSetName]['eleventh']['code']);
			$('#mobeleventh_color_picker').val(mobcolorSetJson[mobcolorSetName]['eleventh']['code']);	
			// twelfth color 
			$('#mobtwelfth_color').val(mobcolorSetJson[mobcolorSetName]['twelfth']['color']);
			$('#mobtwelfth_code').val(mobcolorSetJson[mobcolorSetName]['twelfth']['code']);
			$('#mobtwelfth_color_picker').val(mobcolorSetJson[mobcolorSetName]['twelfth']['code']);			
			// thirteen color 
			$('#mobthirteen_color').val(mobcolorSetJson[mobcolorSetName]['thirteen']['color']);
			$('#mobthirteen_code').val(mobcolorSetJson[mobcolorSetName]['thirteen']['code']);
			$('#mobthirteen_color_picker').val(mobcolorSetJson[mobcolorSetName]['thirteen']['code']);			
			// fourteen color 
			$('#mobfourteen_color').val(mobcolorSetJson[mobcolorSetName]['fourteen']['color']);
			$('#mobfourteen_code').val(mobcolorSetJson[mobcolorSetName]['fourteen']['code']);
			$('#mobfourteen_color_picker').val(mobcolorSetJson[mobcolorSetName]['fourteen']['code']);			
			// fifteen color 
			$('#mobfifteen_color').val(mobcolorSetJson[mobcolorSetName]['fifteen']['color']);
			$('#mobfifteen_code').val(mobcolorSetJson[mobcolorSetName]['fifteen']['code']);
			$('#mobfifteen_color_picker').val(mobcolorSetJson[mobcolorSetName]['fifteen']['code']);

			// name value  
			$('#mobsetname_value').val(mobcolorSetJson[mobcolorSetName]['setname']);



		});

//====================================================== MOB COLOR SET MANUAL SETTINGS   =======================================


		$('#colorsetdropdownmanual').on('change', function() {

			var colorSetName = this.value;

			var colorSetJson = JSON.parse(colorSetArrayManual);

			console.log(colorSetJson);


			var colorSetColorNames = colorSetJson[colorSetName];


			// first color 
			$('#first_color').val(colorSetJson[colorSetName]['first']['color']);
			$('#first_code').val(colorSetJson[colorSetName]['first']['code']);
			$('#first_color_picker').val(colorSetJson[colorSetName]['first']['code']);
			// second color 
			$('#second_color').val(colorSetJson[colorSetName]['second']['color']);
			$('#second_code').val(colorSetJson[colorSetName]['second']['code']);
			$('#second_color_picker').val(colorSetJson[colorSetName]['second']['code']);	
			// third color 
			$('#third_color').val(colorSetJson[colorSetName]['third']['color']);
			$('#third_code').val(colorSetJson[colorSetName]['third']['code']);
			$('#third_color_picker').val(colorSetJson[colorSetName]['third']['code']);
			// fourth color 
			$('#fourth_color').val(colorSetJson[colorSetName]['fourth']['color']);
			$('#fourth_code').val(colorSetJson[colorSetName]['fourth']['code']);
			$('#fourth_color_picker').val(colorSetJson[colorSetName]['fourth']['code']);			
			// fifth color 
			$('#fifth_color').val(colorSetJson[colorSetName]['fifth']['color']);
			$('#fifth_code').val(colorSetJson[colorSetName]['fifth']['code']);
			$('#fifth_color_picker').val(colorSetJson[colorSetName]['fifth']['code']);			
			// sixth color 
			$('#sixth_color').val(colorSetJson[colorSetName]['sixth']['color']);
			$('#sixth_code').val(colorSetJson[colorSetName]['sixth']['code']);
			$('#sixth_color_picker').val(colorSetJson[colorSetName]['sixth']['code']);		
			// seventh color 
			$('#seventh_color').val(colorSetJson[colorSetName]['seventh']['color']);
			$('#seventh_code').val(colorSetJson[colorSetName]['seventh']['code']);
			$('#seventh_color_picker').val(colorSetJson[colorSetName]['seventh']['code']);			
			// eight color 
			$('#eight_color').val(colorSetJson[colorSetName]['eight']['color']);
			$('#eight_code').val(colorSetJson[colorSetName]['eight']['code']);
			$('#eight_color_picker').val(colorSetJson[colorSetName]['eight']['code']);			
			// nine color 
			$('#nine_color').val(colorSetJson[colorSetName]['nine']['color']);
			$('#nine_code').val(colorSetJson[colorSetName]['nine']['code']);
			$('#nine_color_picker').val(colorSetJson[colorSetName]['nine']['code']);
			// tenth color 
			$('#tenth_color').val(colorSetJson[colorSetName]['tenth']['color']);
			$('#tenth_code').val(colorSetJson[colorSetName]['tenth']['code']);
			$('#tenth_color_picker').val(colorSetJson[colorSetName]['tenth']['code']);			
			// eleventh color 
			$('#eleventh_color').val(colorSetJson[colorSetName]['eleventh']['color']);
			$('#eleventh_code').val(colorSetJson[colorSetName]['eleventh']['code']);
			$('#eleventh_color_picker').val(colorSetJson[colorSetName]['eleventh']['code']);	
			// twelfth color 
			$('#twelfth_color').val(colorSetJson[colorSetName]['twelfth']['color']);
			$('#twelfth_code').val(colorSetJson[colorSetName]['twelfth']['code']);
			$('#twelfth_color_picker').val(colorSetJson[colorSetName]['twelfth']['code']);			
			// thirteen color 
			$('#thirteen_color').val(colorSetJson[colorSetName]['thirteen']['color']);
			$('#thirteen_code').val(colorSetJson[colorSetName]['thirteen']['code']);
			$('#thirteen_color_picker').val(colorSetJson[colorSetName]['thirteen']['code']);			
			// fourteen color 
			$('#fourteen_color').val(colorSetJson[colorSetName]['fourteen']['color']);
			$('#fourteen_code').val(colorSetJson[colorSetName]['fourteen']['code']);
			$('#fourteen_color_picker').val(colorSetJson[colorSetName]['fourteen']['code']);			
			// fifteen color 
			$('#fifteen_color').val(colorSetJson[colorSetName]['fifteen']['color']);
			$('#fifteen_code').val(colorSetJson[colorSetName]['fifteen']['code']);
			$('#fifteen_color_picker').val(colorSetJson[colorSetName]['fifteen']['code']);

			// name value  
			$('#setname_value').val(colorSetJson[colorSetName]['setname']);



		});
//====================================================== COLOR SET MANUAL SETTINGS   =======================================



//====================================================== MOB COLOR SET MANUAL SETTINGS   =======================================


		$('#mobcolorsetdropdownmanual').on('change', function() {

			var mobcolorSetName = this.value;

			var mobcolorSetJson = JSON.parse(mobcolorSetArrayManual);

			var mobcolorSetColorNames = mobcolorSetJson[mobcolorSetName];


			// first color 
			$('#mobfirst_color').val(mobcolorSetJson[mobcolorSetName]['first']['color']);
			$('#mobfirst_code').val(mobcolorSetJson[mobcolorSetName]['first']['code']);
			$('#mobfirst_color_picker').val(mobcolorSetJson[mobcolorSetName]['first']['code']);
			// second color 
			$('#mobsecond_color').val(mobcolorSetJson[mobcolorSetName]['second']['color']);
			$('#mobsecond_code').val(mobcolorSetJson[mobcolorSetName]['second']['code']);
			$('#mobsecond_color_picker').val(mobcolorSetJson[mobcolorSetName]['second']['code']);	
			// third color 
			$('#mobthird_color').val(mobcolorSetJson[mobcolorSetName]['third']['color']);
			$('#mobthird_code').val(mobcolorSetJson[mobcolorSetName]['third']['code']);
			$('#mobthird_color_picker').val(mobcolorSetJson[mobcolorSetName]['third']['code']);
			// fourth color 
			$('#mobfourth_color').val(mobcolorSetJson[mobcolorSetName]['fourth']['color']);
			$('#mobfourth_code').val(mobcolorSetJson[mobcolorSetName]['fourth']['code']);
			$('#mobfourth_color_picker').val(mobcolorSetJson[mobcolorSetName]['fourth']['code']);			
			// fifth color 
			$('#mobfifth_color').val(mobcolorSetJson[mobcolorSetName]['fifth']['color']);
			$('#mobfifth_code').val(mobcolorSetJson[mobcolorSetName]['fifth']['code']);
			$('#mobfifth_color_picker').val(mobcolorSetJson[mobcolorSetName]['fifth']['code']);			
			// sixth color 
			$('#mobsixth_color').val(mobcolorSetJson[mobcolorSetName]['sixth']['color']);
			$('#mobsixth_code').val(mobcolorSetJson[mobcolorSetName]['sixth']['code']);
			$('#mobsixth_color_picker').val(mobcolorSetJson[mobcolorSetName]['sixth']['code']);		
			// seventh color 
			$('#mobseventh_color').val(mobcolorSetJson[mobcolorSetName]['seventh']['color']);
			$('#mobseventh_code').val(mobcolorSetJson[mobcolorSetName]['seventh']['code']);
			$('#mobseventh_color_picker').val(mobcolorSetJson[mobcolorSetName]['seventh']['code']);			
			// eight color 
			$('#mobeight_color').val(mobcolorSetJson[mobcolorSetName]['eight']['color']);
			$('#mobeight_code').val(mobcolorSetJson[mobcolorSetName]['eight']['code']);
			$('#mobeight_color_picker').val(mobcolorSetJson[mobcolorSetName]['eight']['code']);			
			// nine color 
			$('#mobnine_color').val(mobcolorSetJson[mobcolorSetName]['nine']['color']);
			$('#mobnine_code').val(mobcolorSetJson[mobcolorSetName]['nine']['code']);
			$('#mobnine_color_picker').val(mobcolorSetJson[mobcolorSetName]['nine']['code']);
			// tenth color 
			$('#mobtenth_color').val(mobcolorSetJson[mobcolorSetName]['tenth']['color']);
			$('#mobtenth_code').val(mobcolorSetJson[mobcolorSetName]['tenth']['code']);
			$('#mobtenth_color_picker').val(mobcolorSetJson[mobcolorSetName]['tenth']['code']);			
			// eleventh color 
			$('#mobeleventh_color').val(mobcolorSetJson[mobcolorSetName]['eleventh']['color']);
			$('#mobeleventh_code').val(mobcolorSetJson[mobcolorSetName]['eleventh']['code']);
			$('#mobeleventh_color_picker').val(mobcolorSetJson[mobcolorSetName]['eleventh']['code']);	
			// twelfth color 
			$('#mobtwelfth_color').val(mobcolorSetJson[mobcolorSetName]['twelfth']['color']);
			$('#mobtwelfth_code').val(mobcolorSetJson[mobcolorSetName]['twelfth']['code']);
			$('#mobtwelfth_color_picker').val(mobcolorSetJson[mobcolorSetName]['twelfth']['code']);			
			// thirteen color 
			$('#mobthirteen_color').val(mobcolorSetJson[mobcolorSetName]['thirteen']['color']);
			$('#mobthirteen_code').val(mobcolorSetJson[mobcolorSetName]['thirteen']['code']);
			$('#mobthirteen_color_picker').val(mobcolorSetJson[mobcolorSetName]['thirteen']['code']);			
			// fourteen color 
			$('#mobfourteen_color').val(mobcolorSetJson[mobcolorSetName]['fourteen']['color']);
			$('#mobfourteen_code').val(mobcolorSetJson[mobcolorSetName]['fourteen']['code']);
			$('#mobfourteen_color_picker').val(mobcolorSetJson[mobcolorSetName]['fourteen']['code']);			
			// fifteen color 
			$('#mobfifteen_color').val(mobcolorSetJson[mobcolorSetName]['fifteen']['color']);
			$('#mobfifteen_code').val(mobcolorSetJson[mobcolorSetName]['fifteen']['code']);
			$('#mobfifteen_color_picker').val(mobcolorSetJson[mobcolorSetName]['fifteen']['code']);

			// name value  
			$('#mobsetname_value').val(mobcolorSetJson[mobcolorSetName]['setname']);



		});

//====================================================== MOB COLOR SET MANUAL SETTINGS   =======================================

//====================================================== TYPE COLOR SET    =======================================

		$('#typeofcolorset').on('change', function() {

			var typeofcolorsetVal = $('#typeofcolorset').val();

			if(typeofcolorsetVal == 'standard')
			{
				$('#standard_color_set_tr').css('display', '');
				$('#manual_color_set_tr').css('display', 'none');
				$('#colorsetdropdown').val('select');

				// disabled all colors

				$('#first_color').attr('readonly', 'readonly');
				$('#first_code').attr('readonly', 'readonly');
				$('#first_color_picker').attr('disabled', 'disabled');

				$('#second_color').attr('readonly', 'readonly');
				$('#second_code').attr('readonly', 'readonly');
				$('#second_color_picker').attr('disabled', 'disabled');

				$('#third_color').attr('readonly', 'readonly');
				$('#third_code').attr('readonly', 'readonly');
				$('#third_color_picker').attr('disabled', 'disabled');

				$('#fourth_color').attr('readonly', 'readonly');
				$('#fourth_code').attr('readonly', 'readonly');
				$('#fourth_color_picker').attr('disabled', 'disabled');

				$('#fourth_color').attr('readonly', 'readonly');
				$('#fourth_code').attr('readonly', 'readonly');
				$('#fourth_color_picker').attr('disabled', 'disabled');

				$('#fifth_color').attr('readonly', 'readonly');
				$('#fifth_code').attr('readonly', 'readonly');
				$('#fifth_color_picker').attr('disabled', 'disabled');

				$('#sixth_color').attr('readonly', 'readonly');
				$('#sixth_code').attr('readonly', 'readonly');
				$('#sixth_color_picker').attr('disabled', 'disabled');

				$('#seventh_color').attr('readonly', 'readonly');
				$('#seventh_code').attr('readonly', 'readonly');
				$('#seventh_color_picker').attr('disabled', 'disabled');

				$('#eight_color').attr('readonly', 'readonly');
				$('#eight_code').attr('readonly', 'readonly');
				$('#eight_color_picker').attr('disabled', 'disabled');

				$('#nine_color').attr('readonly', 'readonly');
				$('#nine_code').attr('readonly', 'readonly');
				$('#nine_color_picker').attr('disabled', 'disabled');

				$('#tenth_color').attr('readonly', 'readonly');
				$('#tenth_code').attr('readonly', 'readonly');
				$('#tenth_color_picker').attr('disabled', 'disabled');

				$('#eleventh_color').attr('readonly', 'readonly');
				$('#eleventh_code').attr('readonly', 'readonly');
				$('#eleventh_color_picker').attr('disabled', 'disabled');				

				$('#twelfth_color').attr('readonly', 'readonly');
				$('#twelfth_code').attr('readonly', 'readonly');
				$('#twelfth_color_picker').attr('disabled', 'disabled');

				$('#thirteen_color').attr('readonly', 'readonly');
				$('#thirteen_code').attr('readonly', 'readonly');
				$('#thirteen_color_picker').attr('disabled', 'disabled');

				$('#fourteen_color').attr('readonly', 'readonly');
				$('#fourteen_code').attr('readonly', 'readonly');
				$('#fourteen_color_picker').attr('disabled', 'disabled');

				$('#fifteen_color').attr('readonly', 'readonly');
				$('#fifteen_code').attr('readonly', 'readonly');
				$('#fifteen_color_picker').attr('disabled', 'disabled');


			}	
			else if(typeofcolorsetVal == 'manual')
			{
				$('#manual_color_set_tr').css('display', '');
				$('#standard_color_set_tr').css('display', 'none');
				$('#colorsetdropdownmanual').val('select');

				// enable all colors 


				$('#first_color').removeAttr('readonly');
				$('#first_code').removeAttr('readonly');
				$('#first_color_picker').removeAttr('disabled');

				$('#second_color').removeAttr('readonly');
				$('#second_code').removeAttr('readonly');
				$('#second_color_picker').removeAttr('disabled');

				$('#third_color').removeAttr('readonly');
				$('#third_code').removeAttr('readonly');
				$('#third_color_picker').removeAttr('disabled');

				$('#fourth_color').removeAttr('readonly');
				$('#fourth_code').removeAttr('readonly');
				$('#fourth_color_picker').removeAttr('disabled');

				$('#fourth_color').removeAttr('readonly');
				$('#fourth_code').removeAttr('readonly');
				$('#fourth_color_picker').removeAttr('disabled');

				$('#fifth_color').removeAttr('readonly');
				$('#fifth_code').removeAttr('readonly');
				$('#fifth_color_picker').removeAttr('disabled');

				$('#sixth_color').removeAttr('readonly');
				$('#sixth_code').removeAttr('readonly');
				$('#sixth_color_picker').removeAttr('disabled');

				$('#seventh_color').removeAttr('readonly');
				$('#seventh_code').removeAttr('readonly');
				$('#seventh_color_picker').removeAttr('disabled');

				$('#eight_color').removeAttr('readonly');
				$('#eight_code').removeAttr('readonly');
				$('#eight_color_picker').removeAttr('disabled');

				$('#nine_color').removeAttr('readonly');
				$('#nine_code').removeAttr('readonly');
				$('#nine_color_picker').removeAttr('disabled');

				$('#tenth_color').removeAttr('readonly');
				$('#tenth_code').removeAttr('readonly');
				$('#tenth_color_picker').removeAttr('disabled');

				$('#eleventh_color').removeAttr('readonly');
				$('#eleventh_code').removeAttr('readonly');
				$('#eleventh_color_picker').removeAttr('disabled');				

				$('#twelfth_color').removeAttr('readonly');
				$('#twelfth_code').removeAttr('readonly');
				$('#twelfth_color_picker').removeAttr('disabled');

				$('#thirteen_color').removeAttr('readonly');
				$('#thirteen_code').removeAttr('readonly');
				$('#thirteen_color_picker').removeAttr('disabled');

				$('#fourteen_color').removeAttr('readonly');
				$('#fourteen_code').removeAttr('readonly');
				$('#fourteen_color_picker').removeAttr('disabled');

				$('#fifteen_color').removeAttr('readonly');
				$('#fifteen_code').removeAttr('readonly');
				$('#fifteen_color_picker').removeAttr('disabled');

			}
			else if(typeofcolorsetVal == 'select')
			{
				$('#manual_color_set_tr').css('display', 'none');
				$('#standard_color_set_tr').css('display', 'none');
				$('#colorsetdropdown').val('select');
				$('#colorsetdropdownmanual').val('select');
			}

		});
	
//====================================================== TYPE COLOR SET   =======================================

//====================================================== ON CHANGE SHOW ALERT  ===================================
	$(document).on('change', 'input, textarea, select', function (e) {
		$("#subButton").addClass('flash');
		$("#sAlert").fadeIn(200);
	});	
//====================================================== ON CHANGE SHOW ALERT  ===================================
	

// disable enable fields on load 

$( document ).ready(function() {

	var typeofcolorsetVal = $('#typeofcolorset').val();

	if(typeofcolorsetVal == 'standard')
	{
		$('#standard_color_set_tr').css('display', '');
		$('#manual_color_set_tr').css('display', 'none');

		// disabled all colors

		$('#first_color').attr('readonly', 'readonly');
		$('#first_code').attr('readonly', 'readonly');
		$('#first_color_picker').attr('disabled', 'disabled');

		$('#second_color').attr('readonly', 'readonly');
		$('#second_code').attr('readonly', 'readonly');
		$('#second_color_picker').attr('disabled', 'disabled');

		$('#third_color').attr('readonly', 'readonly');
		$('#third_code').attr('readonly', 'readonly');
		$('#third_color_picker').attr('disabled', 'disabled');

		$('#fourth_color').attr('readonly', 'readonly');
		$('#fourth_code').attr('readonly', 'readonly');
		$('#fourth_color_picker').attr('disabled', 'disabled');

		$('#fourth_color').attr('readonly', 'readonly');
		$('#fourth_code').attr('readonly', 'readonly');
		$('#fourth_color_picker').attr('disabled', 'disabled');

		$('#fifth_color').attr('readonly', 'readonly');
		$('#fifth_code').attr('readonly', 'readonly');
		$('#fifth_color_picker').attr('disabled', 'disabled');

		$('#sixth_color').attr('readonly', 'readonly');
		$('#sixth_code').attr('readonly', 'readonly');
		$('#sixth_color_picker').attr('disabled', 'disabled');

		$('#seventh_color').attr('readonly', 'readonly');
		$('#seventh_code').attr('readonly', 'readonly');
		$('#seventh_color_picker').attr('disabled', 'disabled');

		$('#eight_color').attr('readonly', 'readonly');
		$('#eight_code').attr('readonly', 'readonly');
		$('#eight_color_picker').attr('disabled', 'disabled');

		$('#nine_color').attr('readonly', 'readonly');
		$('#nine_code').attr('readonly', 'readonly');
		$('#nine_color_picker').attr('disabled', 'disabled');

		$('#tenth_color').attr('readonly', 'readonly');
		$('#tenth_code').attr('readonly', 'readonly');
		$('#tenth_color_picker').attr('disabled', 'disabled');

		$('#eleventh_color').attr('readonly', 'readonly');
		$('#eleventh_code').attr('readonly', 'readonly');
		$('#eleventh_color_picker').attr('disabled', 'disabled');				

		$('#twelfth_color').attr('readonly', 'readonly');
		$('#twelfth_code').attr('readonly', 'readonly');
		$('#twelfth_color_picker').attr('disabled', 'disabled');

		$('#thirteen_color').attr('readonly', 'readonly');
		$('#thirteen_code').attr('readonly', 'readonly');
		$('#thirteen_color_picker').attr('disabled', 'disabled');

		$('#fourteen_color').attr('readonly', 'readonly');
		$('#fourteen_code').attr('readonly', 'readonly');
		$('#fourteen_color_picker').attr('disabled', 'disabled');

		$('#fifteen_color').attr('readonly', 'readonly');
		$('#fifteen_code').attr('readonly', 'readonly');
		$('#fifteen_color_picker').attr('disabled', 'disabled');


	}	
	else if(typeofcolorsetVal == 'manual')
	{
		$('#manual_color_set_tr').css('display', '');
		$('#standard_color_set_tr').css('display', 'none');

		// enable all colors 


		$('#first_color').removeAttr('readonly');
		$('#first_code').removeAttr('readonly');
		$('#first_color_picker').removeAttr('disabled');

		$('#second_color').removeAttr('readonly');
		$('#second_code').removeAttr('readonly');
		$('#second_color_picker').removeAttr('disabled');

		$('#third_color').removeAttr('readonly');
		$('#third_code').removeAttr('readonly');
		$('#third_color_picker').removeAttr('disabled');

		$('#fourth_color').removeAttr('readonly');
		$('#fourth_code').removeAttr('readonly');
		$('#fourth_color_picker').removeAttr('disabled');

		$('#fourth_color').removeAttr('readonly');
		$('#fourth_code').removeAttr('readonly');
		$('#fourth_color_picker').removeAttr('disabled');

		$('#fifth_color').removeAttr('readonly');
		$('#fifth_code').removeAttr('readonly');
		$('#fifth_color_picker').removeAttr('disabled');

		$('#sixth_color').removeAttr('readonly');
		$('#sixth_code').removeAttr('readonly');
		$('#sixth_color_picker').removeAttr('disabled');

		$('#seventh_color').removeAttr('readonly');
		$('#seventh_code').removeAttr('readonly');
		$('#seventh_color_picker').removeAttr('disabled');

		$('#eight_color').removeAttr('readonly');
		$('#eight_code').removeAttr('readonly');
		$('#eight_color_picker').removeAttr('disabled');

		$('#nine_color').removeAttr('readonly');
		$('#nine_code').removeAttr('readonly');
		$('#nine_color_picker').removeAttr('disabled');

		$('#tenth_color').removeAttr('readonly');
		$('#tenth_code').removeAttr('readonly');
		$('#tenth_color_picker').removeAttr('disabled');

		$('#eleventh_color').removeAttr('readonly');
		$('#eleventh_code').removeAttr('readonly');
		$('#eleventh_color_picker').removeAttr('disabled');				

		$('#twelfth_color').removeAttr('readonly');
		$('#twelfth_code').removeAttr('readonly');
		$('#twelfth_color_picker').removeAttr('disabled');

		$('#thirteen_color').removeAttr('readonly');
		$('#thirteen_code').removeAttr('readonly');
		$('#thirteen_color_picker').removeAttr('disabled');

		$('#fourteen_color').removeAttr('readonly');
		$('#fourteen_code').removeAttr('readonly');
		$('#fourteen_color_picker').removeAttr('disabled');

		$('#fifteen_color').removeAttr('readonly');
		$('#fifteen_code').removeAttr('readonly');
		$('#fifteen_color_picker').removeAttr('disabled');

	}



	//====================================================== MOB TYPE COLOR SET    =======================================

		$('#mobtypeofcolorset').on('change', function() {

			var mobtypeofcolorsetVal = $('#mobtypeofcolorset').val();

			console.log(mobtypeofcolorsetVal);

			if(mobtypeofcolorsetVal == 'standard')
			{
				$('#mobstandard_color_set_tr').css('display', '');
				$('#mobmanual_color_set_tr').css('display', 'none');
				$('#mobcolorsetdropdown').val('select');

				// disabled all colors

				$('#mobfirst_color').attr('readonly', 'readonly');
				$('#mobfirst_code').attr('readonly', 'readonly');
				$('#mobfirst_color_picker').attr('disabled', 'disabled');

				$('#mobsecond_color').attr('readonly', 'readonly');
				$('#mobsecond_code').attr('readonly', 'readonly');
				$('#mobsecond_color_picker').attr('disabled', 'disabled');

				$('#mobthird_color').attr('readonly', 'readonly');
				$('#mobthird_code').attr('readonly', 'readonly');
				$('#mobthird_color_picker').attr('disabled', 'disabled');

				$('#mobfourth_color').attr('readonly', 'readonly');
				$('#mobfourth_code').attr('readonly', 'readonly');
				$('#mobfourth_color_picker').attr('disabled', 'disabled');

				$('#mobfourth_color').attr('readonly', 'readonly');
				$('#mobfourth_code').attr('readonly', 'readonly');
				$('#mobfourth_color_picker').attr('disabled', 'disabled');

				$('#mobfifth_color').attr('readonly', 'readonly');
				$('#mobfifth_code').attr('readonly', 'readonly');
				$('#mobfifth_color_picker').attr('disabled', 'disabled');

				$('#mobsixth_color').attr('readonly', 'readonly');
				$('#mobsixth_code').attr('readonly', 'readonly');
				$('#mobsixth_color_picker').attr('disabled', 'disabled');

				$('#mobseventh_color').attr('readonly', 'readonly');
				$('#mobseventh_code').attr('readonly', 'readonly');
				$('#mobseventh_color_picker').attr('disabled', 'disabled');

				$('#mobeight_color').attr('readonly', 'readonly');
				$('#mobeight_code').attr('readonly', 'readonly');
				$('#mobeight_color_picker').attr('disabled', 'disabled');

				$('#mobnine_color').attr('readonly', 'readonly');
				$('#mobnine_code').attr('readonly', 'readonly');
				$('#mobnine_color_picker').attr('disabled', 'disabled');

				$('#mobtenth_color').attr('readonly', 'readonly');
				$('#mobtenth_code').attr('readonly', 'readonly');
				$('#mobtenth_color_picker').attr('disabled', 'disabled');

				$('#mobeleventh_color').attr('readonly', 'readonly');
				$('#mobeleventh_code').attr('readonly', 'readonly');
				$('#mobeleventh_color_picker').attr('disabled', 'disabled');				

				$('#mobtwelfth_color').attr('readonly', 'readonly');
				$('#mobtwelfth_code').attr('readonly', 'readonly');
				$('#mobtwelfth_color_picker').attr('disabled', 'disabled');

				$('#mobthirteen_color').attr('readonly', 'readonly');
				$('#mobthirteen_code').attr('readonly', 'readonly');
				$('#mobthirteen_color_picker').attr('disabled', 'disabled');

				$('#mobfourteen_color').attr('readonly', 'readonly');
				$('#mobfourteen_code').attr('readonly', 'readonly');
				$('#mobfourteen_color_picker').attr('disabled', 'disabled');

				$('#mobfifteen_color').attr('readonly', 'readonly');
				$('#mobfifteen_code').attr('readonly', 'readonly');
				$('#mobfifteen_color_picker').attr('disabled', 'disabled');


			}	
			else if(mobtypeofcolorsetVal == 'manual')
			{
				$('#mobmanual_color_set_tr').css('display', '');
				$('#mobstandard_color_set_tr').css('display', 'none');
				$('#mobcolorsetdropdownmanual').val('select');

				// enable all colors 


				$('#mobfirst_color').removeAttr('readonly');
				$('#mobfirst_code').removeAttr('readonly');
				$('#mobfirst_color_picker').removeAttr('disabled');

				$('#mobsecond_color').removeAttr('readonly');
				$('#mobsecond_code').removeAttr('readonly');
				$('#mobsecond_color_picker').removeAttr('disabled');

				$('#mobthird_color').removeAttr('readonly');
				$('#mobthird_code').removeAttr('readonly');
				$('#mobthird_color_picker').removeAttr('disabled');

				$('#mobfourth_color').removeAttr('readonly');
				$('#mobfourth_code').removeAttr('readonly');
				$('#mobfourth_color_picker').removeAttr('disabled');

				$('#mobfourth_color').removeAttr('readonly');
				$('#mobfourth_code').removeAttr('readonly');
				$('#mobfourth_color_picker').removeAttr('disabled');

				$('#mobfifth_color').removeAttr('readonly');
				$('#mobfifth_code').removeAttr('readonly');
				$('#mobfifth_color_picker').removeAttr('disabled');

				$('#mobsixth_color').removeAttr('readonly');
				$('#mobsixth_code').removeAttr('readonly');
				$('#mobsixth_color_picker').removeAttr('disabled');

				$('#mobseventh_color').removeAttr('readonly');
				$('#mobseventh_code').removeAttr('readonly');
				$('#mobseventh_color_picker').removeAttr('disabled');

				$('#mobeight_color').removeAttr('readonly');
				$('#mobeight_code').removeAttr('readonly');
				$('#mobeight_color_picker').removeAttr('disabled');

				$('#mobnine_color').removeAttr('readonly');
				$('#mobnine_code').removeAttr('readonly');
				$('#mobnine_color_picker').removeAttr('disabled');

				$('#mobtenth_color').removeAttr('readonly');
				$('#mobtenth_code').removeAttr('readonly');
				$('#mobtenth_color_picker').removeAttr('disabled');

				$('#mobeleventh_color').removeAttr('readonly');
				$('#mobeleventh_code').removeAttr('readonly');
				$('#mobeleventh_color_picker').removeAttr('disabled');				

				$('#mobtwelfth_color').removeAttr('readonly');
				$('#mobtwelfth_code').removeAttr('readonly');
				$('#mobtwelfth_color_picker').removeAttr('disabled');

				$('#mobthirteen_color').removeAttr('readonly');
				$('#mobthirteen_code').removeAttr('readonly');
				$('#mobthirteen_color_picker').removeAttr('disabled');

				$('#mobfourteen_color').removeAttr('readonly');
				$('#mobfourteen_code').removeAttr('readonly');
				$('#mobfourteen_color_picker').removeAttr('disabled');

				$('#mobfifteen_color').removeAttr('readonly');
				$('#mobfifteen_code').removeAttr('readonly');
				$('#mobfifteen_color_picker').removeAttr('disabled');

			}
			else if(mobtypeofcolorsetVal == 'select')
			{

				$('#mobmanual_color_set_tr').css('display', 'none');
				$('#mobstandard_color_set_tr').css('display', 'none');
				$('#mobcolorsetdropdown').val('select');
				$('#mobcolorsetdropdownmanual').val('select');
			}

		});
		


		// disable enable MOB COLOR SETTINGS fields on load 


			var mobtypeofcolorsetVal = $('#mobtypeofcolorset').val();

			if(mobtypeofcolorsetVal == 'standard')
			{
				$('#mobstandard_color_set_tr').css('display', '');
				$('#mobmanual_color_set_tr').css('display', 'none');

				// disabled all colors

				$('#mobfirst_color').attr('readonly', 'readonly');
				$('#mobfirst_code').attr('readonly', 'readonly');
				$('#mobfirst_color_picker').attr('disabled', 'disabled');

				$('#mobsecond_color').attr('readonly', 'readonly');
				$('#mobsecond_code').attr('readonly', 'readonly');
				$('#mobsecond_color_picker').attr('disabled', 'disabled');

				$('#mobthird_color').attr('readonly', 'readonly');
				$('#mobthird_code').attr('readonly', 'readonly');
				$('#mobthird_color_picker').attr('disabled', 'disabled');

				$('#mobfourth_color').attr('readonly', 'readonly');
				$('#mobfourth_code').attr('readonly', 'readonly');
				$('#mobfourth_color_picker').attr('disabled', 'disabled');

				$('#mobfourth_color').attr('readonly', 'readonly');
				$('#mobfourth_code').attr('readonly', 'readonly');
				$('#mobfourth_color_picker').attr('disabled', 'disabled');

				$('#mobfifth_color').attr('readonly', 'readonly');
				$('#mobfifth_code').attr('readonly', 'readonly');
				$('#mobfifth_color_picker').attr('disabled', 'disabled');

				$('#mobsixth_color').attr('readonly', 'readonly');
				$('#mobsixth_code').attr('readonly', 'readonly');
				$('#mobsixth_color_picker').attr('disabled', 'disabled');

				$('#mobseventh_color').attr('readonly', 'readonly');
				$('#mobseventh_code').attr('readonly', 'readonly');
				$('#mobseventh_color_picker').attr('disabled', 'disabled');

				$('#mobeight_color').attr('readonly', 'readonly');
				$('#mobeight_code').attr('readonly', 'readonly');
				$('#mobeight_color_picker').attr('disabled', 'disabled');

				$('#mobnine_color').attr('readonly', 'readonly');
				$('#mobnine_code').attr('readonly', 'readonly');
				$('#mobnine_color_picker').attr('disabled', 'disabled');

				$('#mobtenth_color').attr('readonly', 'readonly');
				$('#mobtenth_code').attr('readonly', 'readonly');
				$('#mobtenth_color_picker').attr('disabled', 'disabled');

				$('#mobeleventh_color').attr('readonly', 'readonly');
				$('#mobeleventh_code').attr('readonly', 'readonly');
				$('#mobeleventh_color_picker').attr('disabled', 'disabled');				

				$('#mobtwelfth_color').attr('readonly', 'readonly');
				$('#mobtwelfth_code').attr('readonly', 'readonly');
				$('#mobtwelfth_color_picker').attr('disabled', 'disabled');

				$('#mobthirteen_color').attr('readonly', 'readonly');
				$('#mobthirteen_code').attr('readonly', 'readonly');
				$('#mobthirteen_color_picker').attr('disabled', 'disabled');

				$('#mobfourteen_color').attr('readonly', 'readonly');
				$('#mobfourteen_code').attr('readonly', 'readonly');
				$('#mobfourteen_color_picker').attr('disabled', 'disabled');

				$('#mobfifteen_color').attr('readonly', 'readonly');
				$('#mobfifteen_code').attr('readonly', 'readonly');
				$('#mobfifteen_color_picker').attr('disabled', 'disabled');


			}	
			else if(typeofcolorsetVal == 'manual')
			{
				$('#mobmanual_color_set_tr').css('display', '');
				$('#mobstandard_color_set_tr').css('display', 'none');

				// enable all colors 


				$('#mobfirst_color').removeAttr('readonly');
				$('#mobfirst_code').removeAttr('readonly');
				$('#mobfirst_color_picker').removeAttr('disabled');

				$('#mobsecond_color').removeAttr('readonly');
				$('#mobsecond_code').removeAttr('readonly');
				$('#mobsecond_color_picker').removeAttr('disabled');

				$('#mobthird_color').removeAttr('readonly');
				$('#mobthird_code').removeAttr('readonly');
				$('#mobthird_color_picker').removeAttr('disabled');

				$('#mobfourth_color').removeAttr('readonly');
				$('#mobfourth_code').removeAttr('readonly');
				$('#mobfourth_color_picker').removeAttr('disabled');

				$('#mobfourth_color').removeAttr('readonly');
				$('#mobfourth_code').removeAttr('readonly');
				$('#mobfourth_color_picker').removeAttr('disabled');

				$('#mobfifth_color').removeAttr('readonly');
				$('#mobfifth_code').removeAttr('readonly');
				$('#mobfifth_color_picker').removeAttr('disabled');

				$('#mobsixth_color').removeAttr('readonly');
				$('#mobsixth_code').removeAttr('readonly');
				$('#mobsixth_color_picker').removeAttr('disabled');

				$('#mobseventh_color').removeAttr('readonly');
				$('#mobseventh_code').removeAttr('readonly');
				$('#mobseventh_color_picker').removeAttr('disabled');

				$('#mobeight_color').removeAttr('readonly');
				$('#mobeight_code').removeAttr('readonly');
				$('#mobeight_color_picker').removeAttr('disabled');

				$('#mobnine_color').removeAttr('readonly');
				$('#mobnine_code').removeAttr('readonly');
				$('#mobnine_color_picker').removeAttr('disabled');

				$('#mobtenth_color').removeAttr('readonly');
				$('#mobtenth_code').removeAttr('readonly');
				$('#mobtenth_color_picker').removeAttr('disabled');

				$('#mobeleventh_color').removeAttr('readonly');
				$('#mobeleventh_code').removeAttr('readonly');
				$('#mobeleventh_color_picker').removeAttr('disabled');				

				$('#mobtwelfth_color').removeAttr('readonly');
				$('#mobtwelfth_code').removeAttr('readonly');
				$('#mobtwelfth_color_picker').removeAttr('disabled');

				$('#mobthirteen_color').removeAttr('readonly');
				$('#mobthirteen_code').removeAttr('readonly');
				$('#mobthirteen_color_picker').removeAttr('disabled');

				$('#mobfourteen_color').removeAttr('readonly');
				$('#mobfourteen_code').removeAttr('readonly');
				$('#mobfourteen_color_picker').removeAttr('disabled');

				$('#mobfifteen_color').removeAttr('readonly');
				$('#mobfifteen_code').removeAttr('readonly');
				$('#mobfifteen_color_picker').removeAttr('disabled');

			}


//====================================================== MOB TYPE COLOR SET   =======================================





	// LOGIN SCREEN CHANGE DROPDOWN 


	$('#select_login_type').on('change', function() {

			var loginTypeValue = this.value;

			if(loginTypeValue == 'admin_login')
			{
				// show admin login screen
				$('.admin_login_screen_div').css("display","");
				$('.system_login_screen_div').css("display",'none');
				$('.mob_login_screen_div').css("display","none");
				$('.scan_login_screen_div').css("display","none");

				// show admin tabs hide others
				$('#adminscreentbody').css("display","");
				// hide other tabs 
				$('#systemscreentbody').css("display","none");
				$('#mobilescreentbody').css("display","none");
				$('#scanscreentbody').css("display","none");
				
			}
			else if(loginTypeValue == 'system_user')
			{
				// show admin login screen
				$('.system_login_screen_div').css("display","");
				$('.admin_login_screen_div').css("display","none");
				$('.mob_login_screen_div').css("display","none");
				$('.scan_login_screen_div').css("display","none");

				// show system login screen tabs
				$('#systemscreentbody').css("display","");
				// hide other tabs 
				$('#adminscreentbody').css("display","none");
				$('#mobilescreentbody').css("display","none");
				$('#scanscreentbody').css("display","none");


			}			
			else if(loginTypeValue == 'mobile_login')
			{
				// show admin login screen
				$('.mob_login_screen_div').css("display","");
				$('.system_login_screen_div').css("display","none");
				$('.admin_login_screen_div').css("display","none");
				$('.scan_login_screen_div').css("display","none");

				// show mobile login screen tabs
				$('#mobilescreentbody').css("display","");
				// hide other tabs 
				$('#adminscreentbody').css("display","none");
				$('#systemscreentbody').css("display","none");
				$('#scanscreentbody').css("display","none");



			}			
			else if(loginTypeValue == 'scan_login')
			{
				// show admin login screen
				$('.mob_login_screen_div').css("display","none");
				$('.system_login_screen_div').css("display","none");
				$('.admin_login_screen_div').css("display","none");
				$('.scan_login_screen_div').css("display","");

				// show scan login screen tabs 
				$('#scanscreentbody').css("display","");
				// hide other tabs 
				$('#adminscreentbody').css("display","none");
				$('#systemscreentbody').css("display","none");
				$('#mobilescreentbody').css("display","none");


			}			
			else if(loginTypeValue == 'select')
			{
				// show admin login screen
				$('.mob_login_screen_div').css("display","none");
				$('.system_login_screen_div').css("display","none");
				$('.admin_login_screen_div').css("display","none");
				$('.scan_login_screen_div').css("display","none");

				// remove alll the tabs which are not required 
				$('#scanscreentbody').css("display","none");
				$('#adminscreentbody').css("display","none");
				$('#systemscreentbody').css("display","none");
				$('#mobilescreentbody').css("display","none");

			}


	});





/* ======================================  ADMIN DASHBOARD SCREEN SETTINGS ====================================================*/


	$('#background_image_selection').on('change', function() {
			var background_image_selection = this.value;
			if(background_image_selection == 'selectfile'){
				$('#selectimagebutton').css("display","");
			}
			else if(background_image_selection == 'noimage'){
				$('#selectimagebutton').css("display","none");
				$('#uploadimages_admin_bg').val('');
				$('#admin_dashboard_image_link').val('');
				$('#rightTable').css('background','');
				$('#background_image_preview').css("display","none");
				$('#background_image_name_preview').css("display","none");
			}
	});


	$( document ).ready(function() {

		var background_image_selection = $('#background_image_selection').val();
		if(background_image_selection == 'selectfile'){
			$('#selectimagebutton').css("display","");
		}
		else if(background_image_selection == 'noimage'){
			$('#selectimagebutton').css("display","none");
			$('#uploadimages_admin_bg').val('');
			$('#admin_dashboard_image_link').val('');
			$('#rightTable').css('background','');
			$('#background_image_preview').css("display","none");
			$('#background_image_name_preview').css("display","none");

		}


	});





	// HOME BUTTON COLOR 
    $('#admin_dashboard_color2').on('change', function() {
		var admin_dashboard_color2ColourName = this.value;
		var admin_dashboard_color2ColorJson = JSON.parse(colorArray);
		var admin_dashboard_color2ColorCode = admin_dashboard_color2ColorJson[admin_dashboard_color2ColourName]+'!important';

		$('#homeButton').css({"background-color": admin_dashboard_color2ColorCode});
		$('#homeButtonlogoandheader').css({"background-color": admin_dashboard_color2ColorCode});
		$('#admin_dashboard_circle2').css({"color": admin_dashboard_color2ColorCode});
	});


	var admin_dashboard_color2_heading_color = $('#admin_dashboard_color2').val();
	var admin_dashboard_color2_heading_color_json = JSON.parse(colorArray);
	var admin_dashboard_color2_heading_color_Code = admin_dashboard_color2_heading_color_json[admin_dashboard_color2_heading_color]+'!important';

	$('#homeButton').css({"background-color": admin_dashboard_color2_heading_color_Code});
	$('#homeButtonlogoandheader').css({"background-color": admin_dashboard_color2_heading_color_Code});
	$('#admin_dashboard_circle2').css({"color": admin_dashboard_color2_heading_color_Code});


	// // HEADER BACKGROUND COLOR 
    $('#admin_dashboard_color1').on('change', function() {
		var admin_dashboard_color1ColourName = this.value;
		var admin_dashboard_color1ColorJson = JSON.parse(colorArray);
		var admin_dashboard_color1ColorCode = admin_dashboard_color1ColorJson[admin_dashboard_color1ColourName]+'!important';

		$('.navbarbackgroundcolor').css({"background-color": admin_dashboard_color1ColorCode});
		$('.navbarbackgroundcolorlogoandheader').css({"background-color": admin_dashboard_color1ColorCode});
		$('#admin_dashboard_circle1').css({"color": admin_dashboard_color1ColorCode});
	});


	var admin_dashboard_color1_heading_color = $('#admin_dashboard_color1').val();
	var admin_dashboard_color1_heading_color_json = JSON.parse(colorArray);
	var admin_dashboard_color1_heading_color_Code = admin_dashboard_color1_heading_color_json[admin_dashboard_color1_heading_color]+'!important';

	$('.navbarbackgroundcolor').css({"background-color": admin_dashboard_color1_heading_color_Code});
	$('.navbarbackgroundcolorlogoandheader').css({"background-color": admin_dashboard_color1_heading_color_Code});
	$('#admin_dashboard_circle1').css({"color": admin_dashboard_color1_heading_color_Code});


	// // MAIN HEADER 1 BACKGROUND COLOR 
    $('#admin_dashboard_color3').on('change', function() {
		var admin_dashboard_color3ColourName = this.value;
		var admin_dashboard_color3ColorJson = JSON.parse(colorArray);
		var admin_dashboard_color3ColorCode = admin_dashboard_color3ColorJson[admin_dashboard_color3ColourName];

		// console.log(logo_and_headers_color3ColorCode);

		$('.headergradientcolor').css({ 'background-image':'-webkit-linear-gradient('+admin_dashboard_color3ColorCode+','+admin_dashboard_color3ColorCode+')', });
		$('.headergradientcolorlogoandheaders').css({ 'background-image':'-webkit-linear-gradient('+admin_dashboard_color3ColorCode+','+admin_dashboard_color3ColorCode+')', });

		$('#admin_dashboard_circle3').css({"color": admin_dashboard_color3ColorCode});
	});


	var admin_dashboard_color3_heading_color = $('#admin_dashboard_color3').val();
	var admin_dashboard_color3_heading_color_json = JSON.parse(colorArray);
	var admin_dashboard_color3_heading_color_Code = admin_dashboard_color3_heading_color_json[admin_dashboard_color3_heading_color];

	$('.headergradientcolor').css({ 'background-image':'-webkit-linear-gradient('+admin_dashboard_color3_heading_color_Code+','+admin_dashboard_color3_heading_color_Code+')', });
	$('.headergradientcolorlogoandheaders').css({ 'background-image':'-webkit-linear-gradient('+admin_dashboard_color3_heading_color_Code+','+admin_dashboard_color3_heading_color_Code+')', });
	$('#admin_dashboard_circle3').css({"color": admin_dashboard_color3_heading_color_Code});


	// // MAIN HEADER 2 BACKGROUND COLOR 
    $('#admin_dashboard_color4').on('change', function() {
		var admin_dashboard_color4ColourName = this.value;
		var admin_dashboard_color4ColorJson = JSON.parse(colorArray);
		var admin_dashboard_color4ColorCode = admin_dashboard_color4ColorJson[admin_dashboard_color4ColourName];
		var admin_dashboard_color3_heading_color1 = $('#admin_dashboard_color3').val();
		var admin_dashboard_color3_heading_color_json1 = JSON.parse(colorArray);
		var admin_dashboard_color3_heading_color_Code1 = admin_dashboard_color3_heading_color_json1[admin_dashboard_color3_heading_color1];


		$('.headergradientcolor').css({ 'background-image':'-webkit-linear-gradient('+admin_dashboard_color3_heading_color_Code1+','+admin_dashboard_color4ColorCode+')', });

		$('.headergradientcolorlogoandheaders').css({ 'background-image':'-webkit-linear-gradient('+admin_dashboard_color3_heading_color_Code1+','+admin_dashboard_color4ColorCode+')', });

		$('#admin_dashboard_circle4').css({"color": admin_dashboard_color4ColorCode});
	});


	var admin_dashboard_color4_heading_color = $('#admin_dashboard_color4').val();
	var admin_dashboard_color4_heading_color_json = JSON.parse(colorArray);
	var admin_dashboard_color4_heading_color_Code = admin_dashboard_color4_heading_color_json[admin_dashboard_color4_heading_color];
	var admin_dashboard_color3_heading_color11 = $('#admin_dashboard_color3').val();
	var admin_dashboard_color3_heading_color_json11 = JSON.parse(colorArray);
	var admin_dashboard_color3_heading_color_Code11 = admin_dashboard_color3_heading_color_json11[admin_dashboard_color3_heading_color11];

	$('.headergradientcolor').css({ 'background-image':'-webkit-linear-gradient('+admin_dashboard_color3_heading_color_Code11+','+admin_dashboard_color4_heading_color_Code+')', });
	$('.headergradientcolorlogoandheaders').css({ 'background-image':'-webkit-linear-gradient('+admin_dashboard_color3_heading_color_Code11+','+admin_dashboard_color4_heading_color_Code+')', });

	$('#admin_dashboard_circle4').css({"color": admin_dashboard_color4_heading_color_Code});




	// HEADING FONT

	$('#admin_dashboard_header_font').on('change', function() {
		var FontName = this.value+'!important';
		if(this.value == 'default'){
			$('a#admin_dashboard_header_font_style ').removeAttr('font-family');
			$('a#admin_dashboard_header_font_stylelogoandheader ').removeAttr('font-family');
		}else{
			$('a#admin_dashboard_header_font_style').attr('style', 'font-family: '+FontName);
			$('a#admin_dashboard_header_font_stylelogoandheader').attr('style', 'font-family: '+FontName);
		}
	});

	var adminDashboardHeaderFontName = $('#admin_dashboard_header_font').val();
	if(adminDashboardHeaderFontName == 'default'){
		$('a#admin_dashboard_header_font_style').removeAttr('font-family');
		$('a#admin_dashboard_header_font_stylelogoandheader').removeAttr('font-family');
	}
	else{
		$('a#admin_dashboard_header_font_style').attr('style', 'font-family: '+adminDashboardHeaderFontName);
		$('a#admin_dashboard_header_font_stylelogoandheader').attr('style', 'font-family: '+adminDashboardHeaderFontName);
	}


	// HEADER COLOR

    $('#admin_dashboard_header_font_color').on('change', function() {
		var admin_dashboard_header_font_colorName = this.value;
		var admin_dashboard_header_font_colorJson = JSON.parse(colorArray);
		var admin_dashboard_header_font_ColorCode = admin_dashboard_header_font_colorJson[admin_dashboard_header_font_colorName];
		$('#admin_dashboard_header_font_style').css({"color": admin_dashboard_header_font_ColorCode});
		$('#admin_dashboard_header_font_stylelogoandheader').css({"color": admin_dashboard_header_font_ColorCode});
		$('#admin_dashboard_header_font_color_circle').css({"color": admin_dashboard_header_font_ColorCode});
		$('#regoadminheaderbutton').css({"color": admin_dashboard_header_font_ColorCode});
		$('#regoadminheaderbuttonlogoandheader').css({"color": admin_dashboard_header_font_ColorCode});
	});


	var admin_dashboard_header_font_colorvalue = $('#admin_dashboard_header_font_color').val();
	var admin_dashboard_header_font_colorvaluejson = JSON.parse(colorArray);
	var admin_dashboard_header_font_colorvaluecolor_Code = admin_dashboard_header_font_colorvaluejson[admin_dashboard_header_font_colorvalue];
	$('#admin_dashboard_header_font_style').css({"color": admin_dashboard_header_font_colorvaluecolor_Code});
	$('#admin_dashboard_header_font_stylelogoandheader').css({"color": admin_dashboard_header_font_colorvaluecolor_Code});
	$('#admin_dashboard_header_font_color_circle').css({"color": admin_dashboard_header_font_colorvaluecolor_Code});
	$('#regoadminheaderbutton').css({"color": admin_dashboard_header_font_colorvaluecolor_Code});
	$('#regoadminheaderbuttonlogoandheader').css({"color": admin_dashboard_header_font_colorvaluecolor_Code});

	// MAIN HEADING FONT

	$('#admin_dashboard_main_header_font').on('change', function() {
		var FontName = this.value;
		if(this.value == 'default'){
			$('table td#headermaintitle span').css({"font-family": ''});
			$('table td#headermaintitlelogoandheaders span').css({"font-family": ''});
		}else{
			$('table td#headermaintitle span').css({"font-family": FontName});
			$('table td#headermaintitlelogoandheaders span').css({"font-family": FontName});
			$('span#regoadminamespan').css({"font-family": FontName});
			$('span#regoadminamespanlogoandheader').css({"font-family": FontName});
		}
	});

	var adminDashboardMainHeaderFontName = $('#admin_dashboard_main_header_font').val();
	if(adminDashboardMainHeaderFontName == 'default'){
		$('table td#headermaintitle span').css({"font-family": ''});
		$('table td#headermaintitlelogoandheaders span').css({"font-family": ''});
	}
	else{
		$('table td#headermaintitle span').css({"font-family": adminDashboardMainHeaderFontName});
		$('table td#headermaintitlelogoandheaders span').css({"font-family": adminDashboardMainHeaderFontName});

	}


	// MAIN HEADER COLOR

    $('#admin_dashboard_main_header_font_color').on('change', function() {
		var admin_dashboard_main_header_font_colorName = this.value;
		var admin_dashboard_main_header_font_colorJson = JSON.parse(colorArray);
		var admin_dashboard_main_header_font_ColorCode = admin_dashboard_main_header_font_colorJson[admin_dashboard_main_header_font_colorName];
		$('#admin_dashboard_main_header_font_color_circle').css({"color": admin_dashboard_main_header_font_ColorCode});
		$('table td#headermaintitle span').css({"color": admin_dashboard_main_header_font_ColorCode});
		$('table td#headermaintitlelogoandheaders span').css({"color": admin_dashboard_main_header_font_ColorCode});
	});


	var admin_dashboard_main_header_font_colorvalue = $('#admin_dashboard_main_header_font_color').val();
	var admin_dashboard_main_header_font_colorvaluejson = JSON.parse(colorArray);
	var admin_dashboard_main_header_font_colorvaluecolor_Code = admin_dashboard_main_header_font_colorvaluejson[admin_dashboard_main_header_font_colorvalue];
	$('#admin_dashboard_main_header_font_color_circle').css({"color": admin_dashboard_main_header_font_colorvaluecolor_Code});
	$('table td#headermaintitle span').css({"color": admin_dashboard_main_header_font_colorvaluecolor_Code});
	$('table td#headermaintitlelogoandheaders span').css({"color": admin_dashboard_main_header_font_colorvaluecolor_Code});






/* ======================================  ADMIN DASHBOARD SCREEN SETTINGS ====================================================*/

/* ======================================  ADMIN LOGIN SCREEN SETTINGS ====================================================*/
	

	// Box Position 

	var select_admin_login_box_position_top = $('#select_admin_login_box_position_top').val();
	var select_admin_login_box_position_bottom = $('#select_admin_login_box_position_bottom').val();
	var select_admin_login_box_position_left = $('#select_admin_login_box_position_left').val();
	var select_admin_login_box_position_right = $('#select_admin_login_box_position_right').val();
	// $('#loginscreenadmin').attr("style", "position:relative", "float:left");
	$('#loginscreenadmin').css({
        position: "relative",
        top: select_admin_login_box_position_top + "px",
        bottom: select_admin_login_box_position_bottom + "px",
        left: select_admin_login_box_position_left + "px",
        right: select_admin_login_box_position_right + "px"
    });


		// LEFT CHANGE
    	$('#select_admin_login_box_position_left').on('change', function() {

			var pixelValueLeft = this.value;
			$('#loginscreenadmin').css({left: pixelValueLeft + "px",});
		});		

		// RIGHT CHANGE
    	$('#select_admin_login_box_position_right').on('change', function() {

			var pixelValueRight = this.value;
			$('#loginscreenadmin').css({right: pixelValueRight + "px",});
		});    

    	// TOP CHANGE
		$('#select_admin_login_box_position_top').on('change', function() {

			var pixelValueTop = this.value;
			$('#loginscreenadmin').css({top: pixelValueTop + "px",});
		});    	

		// BOTTOM CHANGE
		$('#select_admin_login_box_position_bottom').on('change', function() {

			var pixelValueBottom = this.value;
			$('#loginscreenadmin').css({bottom: pixelValueBottom + "px",});
		});




	// HEADING FONT

		$('#select_admin_login_heading_font').on('change', function() {

			var FontName = this.value+'!important';


			// var fontJson = JSON.parse(fontArray);
			if(this.value == 'default')
			{
				$('h2#admin_login_screen_h2_div span').removeAttr('font-family');
			}
			else
			{
				$('h2#admin_login_screen_h2_div span').attr('style', 'font-family: '+FontName);
			}

		});


	var adminLoginScreenFontName = $('#select_admin_login_heading_font').val();
	if(adminLoginScreenFontName == 'default'){
		$('h2#admin_login_screen_h2_div span').removeAttr('font-family');
	}
	else{
		$('h2#admin_login_screen_h2_div span ').attr('style', 'font-family: '+adminLoginScreenFontName);
	}


	$('#select_admin_login_heading_color').on('change', function() {


		var adminLoginScreenColourName = this.value;

		var adminloginScreenColorJson = JSON.parse(colorArray);

		var  adminLoginScreenColorCode = adminloginScreenColorJson[adminLoginScreenColourName]+'!important';

		$('h2#admin_login_screen_h2_div').attr('style', 'background: '+adminLoginScreenColorCode);

	});


	var select_admin_login_heading_color = $('#select_admin_login_heading_color').val();
	var select_admin_login_heading_color_json = JSON.parse(colorArray);
	var select_admin_login_heading_color_Code = select_admin_login_heading_color_json[select_admin_login_heading_color]+'!important';
	$('h2#admin_login_screen_h2_div').attr('style', 'background: '+select_admin_login_heading_color_Code);




	$('#select_admin_background_image_selection').on('change', function() {
			var select_admin_background_image_selection = this.value;

			if(select_admin_background_image_selection == 'selectfile'){

				$('#selectadminloginbackgroundbutton').css('display','');
			}
			else if(select_admin_background_image_selection == 'noimage'){

				$('#selectadminloginbackgroundbutton').css('display','none');
				$('#uploadimages_admin_login_background').val('');
				$('#admin_screen_login_background_image_link').val('');
				$('#rightTable1').css('background','');
				$('#admin_login_background_image_preview').css('display','none');
				$('#admin_login_background_name_image_preview').css('display','none');
			}
	});


	$( document ).ready(function() {

		var select_admin_background_image_selection = $('#select_admin_background_image_selection').val();
		if(select_admin_background_image_selection == 'selectfile'){
			$('#selectadminloginbackgroundbutton').css('display','');
		}
		else if(select_admin_background_image_selection == 'noimage'){
			$('#selectadminloginbackgroundbutton').css('display','none');
			$('#uploadimages_admin_login_background').val('');
			$('#admin_screen_login_background_image_link').val('');
			$('#rightTable1').css('background','');
			$('#admin_login_background_image_preview').css('display','none');
			$('#admin_login_background_name_image_preview').css('display','none');
		}
	});	


	$('#select_admin_banner_image_selection').on('change', function() {
			var select_admin_banner_image_selection = this.value;

			if(select_admin_banner_image_selection == 'selectfile'){

				$('#selectadminloginbannerbutton').css('display','');
				$('#admin_banner_image_message').css('display','');

			}
			else if(select_admin_banner_image_selection == 'noimage'){

				$('#selectadminloginbannerbutton').css('display','none');
				$('#uploadimages_admin_login_banner').val('');
				$('#admin_screen_login_banner_image_link').val('');
				$('#adminbannerimage').css('display','none');
				$('#admin_login_banner_image_preview').css('display','none');
				$('#admin_login_banner_name_image_preview').css('display','none');
				$('#admin_banner_image_message').css('display','none');
			}
	});


	$( document ).ready(function() {

		var select_admin_banner_image_selection = $('#select_admin_banner_image_selection').val();
		if(select_admin_banner_image_selection == 'selectfile'){
			$('#selectadminloginbannerbutton').css('display','');
		}
		else if(select_admin_banner_image_selection == 'noimage'){
			$('#selectadminloginbannerbutton').css('display','none');
			$('#uploadimages_admin_login_banner').val('');
			$('#admin_screen_login_banner_image_link').val('');
			$('#adminbannerimage').css('display','none');
			$('#admin_login_banner_image_preview').css('display','none');
			$('#admin_login_banner_name_image_preview').css('display','none');
			$('#admin_banner_image_message').css('display','none');
		}
	});






	$('#select_admin_login_button_color').on('change', function() {

		var adminLoginScreenLoginbuttonColourName = this.value;
		var adminloginScreenLoginbuttonColorJson = JSON.parse(colorArray);
		var  adminLoginScreenLoginbuttonColorCode = adminloginScreenLoginbuttonColorJson[adminLoginScreenLoginbuttonColourName]+'!important';
		$('#adminloginbuttoncolor').attr('style', 'background: '+adminLoginScreenLoginbuttonColorCode);
	});


	var select_admin_loginbuttton_heading_color = $('#select_admin_login_button_color').val();
	var select_admin_loginbutton_heading_color_json = JSON.parse(colorArray);
	var select_admin_loginbutton_heading_color_Code = select_admin_loginbutton_heading_color_json[select_admin_loginbuttton_heading_color]+'!important';
	$('#adminloginbuttoncolor').attr("style", "background:"+select_admin_loginbutton_heading_color_Code, "border:"+select_admin_loginbutton_heading_color_Code);


	$('#select_admin_login_forgotbutton_color').on('change', function() {

		var adminfLoginScreenLoginbuttonColourName = this.value;
		var adminloginScreenfLoginbuttonColorJson = JSON.parse(colorArray);
		var  adminLoginScreenfLoginbuttonColorCode = adminloginScreenfLoginbuttonColorJson[adminfLoginScreenLoginbuttonColourName]+'!important';

		$('.forgotpasswordlogin').css({
	        "background-color": adminLoginScreenfLoginbuttonColorCode,
	        "border-color": adminLoginScreenfLoginbuttonColorCode+'!important',
	        "float": "right",
	    });


	
	});


	var select_admin_loginfbuttton_heading_color = $('#select_admin_login_forgotbutton_color').val();
	var select_admin_loginfbutton_heading_color_json = JSON.parse(colorArray);
	var select_admin_loginfbutton_heading_color_Code = select_admin_loginfbutton_heading_color_json[select_admin_loginfbuttton_heading_color]+'!important';

	$('.forgotpasswordlogin').css({
        "background-color": select_admin_loginfbutton_heading_color_Code,
        "float": "right",
        "border-color": select_admin_loginfbutton_heading_color_Code,
    });




	$('#select_admin_login_box_main_position').on('change', function() {

		var adminfLoginScreenPosition = this.value;
		if(adminfLoginScreenPosition == 'center'  || adminfLoginScreenPosition == 'select'){
			$('#adminloginform').css({"float": "" });
		}else {
			var adminfLoginScreenPositionNew = adminfLoginScreenPosition;
			$('#adminloginform').css({"float": adminfLoginScreenPosition });
		}
	});


	var select_admin_login_box_main_position = $('#select_admin_login_box_main_position').val();
	$('#adminloginform').css({"float": select_admin_login_box_main_position });



	// ADMIN LOGIN SCREENT TITLE TEXT SETTINGS 

	$('#select_admin_login_screen_title_text').on('keyup', function() {

		var select_admin_login_screen_title_TEXT = this.value;
		$('span#adminloginscreentitletext').html(select_admin_login_screen_title_TEXT);

		console.log(select_admin_login_screen_title_TEXT);
		
	});	

	$('#select_system_login_screen_title_text').on('keyup', function() {

		var select_system_login_screen_title_TEXT = this.value;
		$('span#systemloginscreentitletext').html(select_system_login_screen_title_TEXT);

		
	});


	// SCREEN TITLE TEXT 

	$('#select_admin_login_titletext_font').on('change', function() {
		var FontName = this.value;
		if(this.value == 'default'){
			$('span#adminloginscreentitletext').css({"font-family": ''});
		}else{
			$('span#adminloginscreentitletext').css({"font-family": FontName});
		}
	});	

	$('#select_system_login_titletext_font').on('change', function() {
		var FontName = this.value;
		if(this.value == 'default'){
			$('span#systemloginscreentitletext').css({"font-family": ''});
		}else{
			$('span#systemloginscreentitletext').css({"font-family": FontName});
		}
	});

	var select_admin_login_titletext_fontValue = $('#select_admin_login_titletext_font').val();
	if(select_admin_login_titletext_fontValue == 'default'){
		$('span#adminloginscreentitletext').css({"font-family": ''});
	}
	else{
		$('span#adminloginscreentitletext').css({"font-family": select_admin_login_titletext_fontValue});

	}	

	var select_system_login_titletext_fontValue = $('#select_system_login_titletext_font').val();
	if(select_system_login_titletext_fontValue == 'default'){
		$('span#systemloginscreentitletext').css({"font-family": ''});
	}
	else{
		$('span#systemloginscreentitletext').css({"font-family": select_system_login_titletext_fontValue});

	}


	// SCREEN TITLE TEXT COLOR 

	$('#select_admin_login_titletext_color').on('change', function() {

		var adminfLoginScreenLoginTitleTextColourName = this.value;
		var adminloginScreenfLoginTitleTexColorJson = JSON.parse(colorArray);
		var  adminLoginScreenfLoginTitleTexColorCode = adminloginScreenfLoginTitleTexColorJson[adminfLoginScreenLoginTitleTextColourName]+'!important';
		$('span#adminloginscreentitletext').css({
	        "color": adminLoginScreenfLoginTitleTexColorCode,
	    });
	});


	var select_admin_logintitletext_heading_color = $('#select_admin_login_titletext_color').val();
	var select_admin_logintitletext_heading_color_json = JSON.parse(colorArray);
	var select_admin_logintitletext_heading_color_Code = select_admin_logintitletext_heading_color_json[select_admin_logintitletext_heading_color]+'!important';
	$('span#adminloginscreentitletext').css({
        "color": select_admin_logintitletext_heading_color_Code,
    });


	$('#select_systen_login_titletext_color').on('change', function() {

		var systemfLoginScreenLoginTitleTextColourName = this.value;
		var systemloginScreenfLoginTitleTexColorJson = JSON.parse(colorArray);
		var  systemLoginScreenfLoginTitleTexColorCode = systemloginScreenfLoginTitleTexColorJson[systemfLoginScreenLoginTitleTextColourName]+'!important';
		$('span#systemloginscreentitletext').css({
	        "color": systemLoginScreenfLoginTitleTexColorCode,
	    });
	});


	var select_system_logintitletext_heading_color = $('#select_systen_login_titletext_color').val();
	var select_system_logintitletext_heading_color_json = JSON.parse(colorArray);
	var select_system_logintitletext_heading_color_Code = select_system_logintitletext_heading_color_json[select_system_logintitletext_heading_color]+'!important';
	$('span#systemloginscreentitletext').css({
        "color": select_system_logintitletext_heading_color_Code,
    });



/* ======================================  ADMIN LOGIN SCREEN SETTINGS ====================================================*/


/* ======================================  SYSTEM LOGIN SCREEN SETTINGS ====================================================*/


	// HEADING FONT

		$('#select_system_login_heading_font').on('change', function() {

			var FontName = this.value+'!important';


			// var fontJson = JSON.parse(fontArray);
			if(this.value == 'default')
			{
				$('h2#system_login_screen_box_div span').removeAttr('font-family');
				$('h2#system_login_screen_box_div_logoandheaders_loginscreenlogo span').removeAttr('font-family');
				$('h2#system_login_screen_box_div_logoandheaders_loginscreenlogo_title span').removeAttr('font-family');
			}
			else
			{
				$('h2#system_login_screen_box_div span').attr('style', 'font-family: '+FontName);
				$('h2#system_login_screen_box_div_logoandheaders_loginscreenlogo span').attr('style', 'font-family: '+FontName);
				$('h2#system_login_screen_box_div_logoandheaders_loginscreenlogo_title span').attr('style', 'font-family: '+FontName);
			}

		});


	var systemLoginScreenFontName = $('#select_system_login_heading_font').val();
	if(systemLoginScreenFontName == 'default'){
		$('h2#system_login_screen_box_div span').removeAttr('font-family');
		$('h2#system_login_screen_box_div_logoandheaders_loginscreenlogo span').removeAttr('font-family');
		$('h2#system_login_screen_box_div_logoandheaders_loginscreenlogo_title span').removeAttr('font-family');
	}
	else{
		$('h2#system_login_screen_box_div span ').attr('style', 'font-family: '+systemLoginScreenFontName);
		$('h2#system_login_screen_box_div_logoandheaders_loginscreenlogo span ').attr('style', 'font-family: '+systemLoginScreenFontName);
		$('h2#system_login_screen_box_div_logoandheaders_loginscreenlogo_title span ').attr('style', 'font-family: '+systemLoginScreenFontName);
	}


	$('#select_system_login_heading_color').on('change', function() {


		var systemLoginScreenColourName = this.value;

		var systemloginScreenColorJson = JSON.parse(colorArray);

		var  systemLoginScreenColorCode = systemloginScreenColorJson[systemLoginScreenColourName]+'!important';

		$('h2#system_login_screen_box_div').attr('style', 'background: '+systemLoginScreenColorCode);
		$('h2#system_login_screen_box_div_logoandheaders_loginscreenlogo').attr('style', 'background: '+systemLoginScreenColorCode);
		$('h2#system_login_screen_box_div_logoandheaders_loginscreenlogo_title').attr('style', 'background: '+systemLoginScreenColorCode);

	});


	var select_system_login_heading_color = $('#select_system_login_heading_color').val();
	var select_system_login_heading_color_json = JSON.parse(colorArray);
	var select_system_login_heading_color_Code = select_system_login_heading_color_json[select_system_login_heading_color]+'!important';
	$('h2#system_login_screen_box_div').attr('style', 'background: '+select_system_login_heading_color_Code);
	$('h2#system_login_screen_box_div_logoandheaders_loginscreenlogo').attr('style', 'background: '+select_system_login_heading_color_Code);
	$('h2#system_login_screen_box_div_logoandheaders_loginscreenlogo_title').attr('style', 'background: '+select_system_login_heading_color_Code);


	$('#select_system_background_image_selection').on('change', function() {
			var select_system_background_image_selection = this.value;

			if(select_system_background_image_selection == 'selectfile'){

				$('#selectsystembackgroundbutton').css('display','');
			}
			else if(select_system_background_image_selection == 'noimage'){

				$('#selectsystembackgroundbutton').css('display','none');
				$('#uploadimages_system_background').val('');
				$('#system_screen_background_image_link').val('');
				$('#rightTable2').css('background','');
				$('#system_background_image_preview').css('display','none');
				$('#system_background_image_preview_name').css('display','none');
			}
	});


	$( document ).ready(function() {

		var select_system_background_image_selection = $('#select_system_background_image_selection').val();
		if(select_system_background_image_selection == 'selectfile'){
			$('#selectsystembackgroundbutton').css('display','');
		}
		else if(select_admin_background_image_selection == 'noimage'){
			$('#selectsystembackgroundbutton').css('display','none');
			$('#uploadimages_system_background').val('');
			$('#system_screen_background_image_link').val('');
			$('#rightTable2').css('background','');
			$('#system_background_image_preview').css('display','none');
			$('#system_background_image_preview_name').css('display','none');
		}
	});


	$('#select_system_banner_image_selection').on('change', function() {
			var select_system_banner_image_selection = this.value;

			if(select_system_banner_image_selection == 'selectfile'){

				$('#selectsystembannerbutton').css('display','');
				$('#system_banner_message').css('display','');
			}
			else if(select_system_banner_image_selection == 'noimage'){

				$('#selectsystembannerbutton').css('display','none');
				$('#uploadimages_system_banner').val('');
				$('#system_screen_banner_image_link').val('');
				$('#system_banner_image_preview').css('display','none');
				$('#system_banner_image_preview_name').css('display','none');
				$('#system_banner_message').css('display','none');
				$('#systembannerimage').css('display','none');
			}
	});


	// $( document ).ready(function() {

	// 	var select_system_background_image_selection = $('#select_system_background_image_selection').val();
	// 	if(select_system_background_image_selection == 'selectfile'){
	// 		$('#selectsystembackgroundbutton').css('display','');
	// 	}
	// 	else if(select_admin_background_image_selection == 'noimage'){
	// 		$('#selectsystembackgroundbutton').css('display','none');
	// 		$('#uploadimages_system_background').val('');
	// 		$('#system_screen_background_image_link').val('');
	// 		$('#rightTable2').css('background','');
	// 		$('#system_background_image_preview').css('display','none');
	// 		$('#system_background_image_preview_name').css('display','none');
	// 	}
	// });



	// FORGOT PASSWORD BUTTON COLOR 
	$('#select_system_login_forgotbutton_color').on('change', function() {
		var systemfLoginScreenLoginbuttonColourName = this.value;
		var systemloginScreenfLoginbuttonColorJson = JSON.parse(colorArray);
		var systemLoginScreenfLoginbuttonColorCode = systemloginScreenfLoginbuttonColorJson[systemfLoginScreenLoginbuttonColourName]+'!important';

		$('.systemforgotpasswordbutton').css({
	        "background-color": systemLoginScreenfLoginbuttonColorCode,
	        "border-color": systemLoginScreenfLoginbuttonColorCode+'!important',
	        "float": "right",
	    });		

	    $('.systemforgotpasswordbutton_logoandheaders_loginscreenlogo').css({
	        "background-color": systemLoginScreenfLoginbuttonColorCode,
	        "border-color": systemLoginScreenfLoginbuttonColorCode+'!important',
	        "float": "right",
	    });	   

	     $('.systemforgotpasswordbutton_logoandheaders_loginscreenlogo_title').css({
	        "background-color": systemLoginScreenfLoginbuttonColorCode,
	        "border-color": systemLoginScreenfLoginbuttonColorCode+'!important',
	        "float": "right",
	    });
	});


	var select_system_loginfbuttton_heading_color = $('#select_admin_login_forgotbutton_color').val();
	var select_system_loginfbutton_heading_color_json = JSON.parse(colorArray);
	var select_system_loginfbutton_heading_color_Code = select_system_loginfbutton_heading_color_json[select_system_loginfbuttton_heading_color]+'!important';

	$('.systemforgotpasswordbutton').css({
        "background-color": select_system_loginfbutton_heading_color_Code,
        "float": "right",
        "border-color": select_system_loginfbutton_heading_color_Code,
    });	

	$('.systemforgotpasswordbutton_logoandheaders_loginscreenlogo').css({
        "background-color": select_system_loginfbutton_heading_color_Code,
        "float": "right",
        "border-color": select_system_loginfbutton_heading_color_Code,
    });		
    $('.systemforgotpasswordbutton_logoandheaders_loginscreenlogo_title').css({
        "background-color": select_system_loginfbutton_heading_color_Code,
        "float": "right",
        "border-color": select_system_loginfbutton_heading_color_Code,
    });	


	// LOGIN BUTTON COLOR 
    $('#select_system_login_button_color').on('change', function() {
		var systemlLoginScreenLoginbuttonColourName = this.value;
		var systemloginScreenlLoginbuttonColorJson = JSON.parse(colorArray);
		var systemLoginScreenlLoginbuttonColorCode = systemloginScreenlLoginbuttonColorJson[systemlLoginScreenLoginbuttonColourName]+'!important';

		$('#systemLoginScreenLoginButton').css({
	        "background-color": systemLoginScreenlLoginbuttonColorCode,
	        "border-color": systemLoginScreenlLoginbuttonColorCode+'!important',
	    });		
	    $('#systemLoginScreenLoginButton_logoandheaders_loginscreenlogo').css({
	        "background-color": systemLoginScreenlLoginbuttonColorCode,
	        "border-color": systemLoginScreenlLoginbuttonColorCode+'!important',
	    });	    
	    $('#systemLoginScreenLoginButton_logoandheaders_loginscreenlogo_title').css({
	        "background-color": systemLoginScreenlLoginbuttonColorCode,
	        "border-color": systemLoginScreenlLoginbuttonColorCode+'!important',
	    });	    
	    $('#systemLoginScreenLoginButton_logoandheaders_loginscreenlogo_title3').css({
	        "background-color": systemLoginScreenlLoginbuttonColorCode,
	        "border-color": systemLoginScreenlLoginbuttonColorCode+'!important',
	    });
	});


	var select_system_loginlbuttton_heading_color = $('#select_system_login_button_color').val();
	var select_system_loginlbutton_heading_color_json = JSON.parse(colorArray);
	var select_system_loginlbutton_heading_color_Code = select_system_loginlbutton_heading_color_json[select_system_loginlbuttton_heading_color]+'!important';

	$('#systemLoginScreenLoginButton').css({
        "background-color": select_system_loginlbutton_heading_color_Code,
        "border-color": select_system_loginlbutton_heading_color_Code,
    });	
    $('#systemLoginScreenLoginButton_logoandheaders_loginscreenlogo').css({
        "background-color": select_system_loginlbutton_heading_color_Code,
        "border-color": select_system_loginlbutton_heading_color_Code,
    });    
    $('#systemLoginScreenLoginButton_logoandheaders_loginscreenlogo_title').css({
        "background-color": select_system_loginlbutton_heading_color_Code,
        "border-color": select_system_loginlbutton_heading_color_Code,
    });    
    $('#systemLoginScreenLoginButton_logoandheaders_loginscreenlogo_title3').css({
        "background-color": select_system_loginlbutton_heading_color_Code,
        "border-color": select_system_loginlbutton_heading_color_Code,
    });


	$('#select_system_login_box_main_position').on('change', function() {

		var systemfLoginScreenPosition = this.value;
		if(systemfLoginScreenPosition == 'center'  || systemfLoginScreenPosition == 'select'){
			$('#systemloginscreenform').css({"float": "" });
			$('#systemloginscreenformlogoandheaderssystemloginscreenlogo').css({"float": "" });
			$('#systemloginscreenformlogoandheaderssystemloginscreenlogotitle').css({"float": "" });
		}else {
			var systemfLoginScreenPositionNew = systemfLoginScreenPosition;
			$('#systemloginscreenform').css({"float": systemfLoginScreenPosition });
			$('#systemloginscreenformlogoandheaderssystemloginscreenlogo').css({"float": systemfLoginScreenPosition });
			$('#systemloginscreenformlogoandheaderssystemloginscreenlogotitle').css({"float": systemfLoginScreenPosition });
		}
	});


	var select_system_login_box_main_position = $('#select_system_login_box_main_position').val();
	$('#systemloginscreenform').css({"float": select_system_login_box_main_position });

	$('#systemloginscreenformlogoandheaderssystemloginscreenlogo').css({"float": select_system_login_box_main_position });
	$('#systemloginscreenformlogoandheaderssystemloginscreenlogotitle').css({"float": select_system_login_box_main_position });



/* ======================================  SYSTEM LOGIN SCREEN SETTINGS ====================================================*/

/* ======================================  MOBILE LOGIN SCREEN SETTINGS ====================================================*/


	$('#select_mob_login_heading_color').on('change', function() {


		var mobLoginScreenColourName = this.value;

		var mobloginScreenColorJson = JSON.parse(colorArray);

		var  mobLoginScreenColorCode = mobloginScreenColorJson[mobLoginScreenColourName]+'!important';

		$('.appHeader1').attr('style', 'background-color: '+mobLoginScreenColorCode);

	});


	var select_mob_login_heading_color = $('#select_mob_login_heading_color').val();
	var select_mob_login_heading_color_json = JSON.parse(colorArray);
	var select_mob_login_heading_color_Code = select_mob_login_heading_color_json[select_mob_login_heading_color]+'!important';
	$('.appHeader1').attr('style', 'background-color: '+select_mob_login_heading_color_Code);


	// HEADING FONT

	$('#select_mob_login_heading_font').on('change', function() {

		var FontName = this.value+'!important';


		// var fontJson = JSON.parse(fontArray);
		if(this.value == 'default')
		{
			$('span#mob_heading_font ').removeAttr('font-family');
		}
		else
		{
			$('span#mob_heading_font ').attr('style', 'font-family: '+FontName);
		}

	});


	var mobLoginScreenHeaderFontName = $('#select_mob_login_heading_font').val();
	if(mobLoginScreenHeaderFontName == 'default'){
		$('span#mob_heading_font ').removeAttr('font-family');
	}
	else{
		$('span#mob_heading_font  ').attr('style', 'font-family: '+mobLoginScreenHeaderFontName);
	}


	$('#select_mob_login_button_color').on('change', function() {


		var mobLoginScreenLoginButtonColourName = this.value;

		var mobloginScreenLoginButtonColorJson = JSON.parse(colorArray);

		var  mobLoginScreenLoginButtonColorCode = mobloginScreenLoginButtonColorJson[mobLoginScreenLoginButtonColourName]+'!important';

		$('#mob_login_button').attr("style", "background-color:"+mobLoginScreenLoginButtonColorCode, "border:"+mobLoginScreenLoginButtonColorCode);

	});

	var select_mob_login_LoginButton_color = $('#select_mob_login_button_color').val();
	var select_mob_login_LoginButton_color_json = JSON.parse(colorArray);
	var select_mob_login_LoginButton_color_Code = select_mob_login_LoginButton_color_json[select_mob_login_LoginButton_color]+'!important';
	$('#mob_login_button').attr("style", "background-color:"+select_mob_login_LoginButton_color_Code, "border:"+select_mob_login_LoginButton_color_Code);



	$('#select_mob_login_forgot_button_color').on('change', function() {


		var mobLoginScreenLoginButtonForgotColourName = this.value;

		var mobloginScreenLoginButtonForgotColorJson = JSON.parse(colorArray);

		var  mobLoginScreenLoginButtonForgotColorCode = mobloginScreenLoginButtonForgotColorJson[mobLoginScreenLoginButtonForgotColourName]+'!important';

		$('#forgot').attr("style", "background-color:"+mobLoginScreenLoginButtonForgotColorCode, "border:"+mobLoginScreenLoginButtonForgotColorCode);

	});

	var select_mob_login_LoginButtonForgot_color = $('#select_mob_login_forgot_button_color').val();
	var select_mob_login_LoginButtonForgot_color_json = JSON.parse(colorArray);
	var select_mob_login_LoginButtonForgot_color_Code = select_mob_login_LoginButtonForgot_color_json[select_mob_login_LoginButtonForgot_color]+'!important';
	$('#forgot').attr("style", "background-color:"+select_mob_login_LoginButtonForgot_color_Code, "border:"+select_mob_login_LoginButtonForgot_color_Code);


	
/* ======================================  MOBILE LOGIN SCREEN SETTINGS ====================================================*/

/* ======================================  SCAN LOGIN SCREEN SETTINGS ====================================================*/


	$('#select_scan_login_heading_color').on('change', function() {


		var scanLoginScreenColourName = this.value;

		var scanloginScreenColorJson = JSON.parse(colorArray);

		var  scanLoginScreenColorCode = scanloginScreenColorJson[scanLoginScreenColourName]+'!important';

		$('.header1').attr('style', 'background-color: '+scanLoginScreenColorCode);

	});


	var select_scan_login_heading_color = $('#select_scan_login_heading_color').val();
	var select_scan_login_heading_color_json = JSON.parse(colorArray);
	var select_scan_login_heading_color_Code = select_scan_login_heading_color_json[select_scan_login_heading_color]+'!important';
	$('.header1').attr('style', 'background-color: '+select_scan_login_heading_color_Code);


	// HEADING FONT

	$('#select_scan_login_heading_font').on('change', function() {
		var FontName = this.value+'!important';
		if(this.value == 'default'){
			$('.header1 span').removeAttr('font-family');
		}
		else{
			$('.header1 span').attr('style', 'font-family: '+FontName);
		}

	});


	var scanLoginScreenHeaderFontName = $('#select_scan_login_heading_font').val();
	if(scanLoginScreenHeaderFontName == 'default'){
		$('.header1 span').removeAttr('font-family');
	}
	else{
		$('.header1 span').attr('style', 'font-family: '+scanLoginScreenHeaderFontName);
	}



	// BOX HEADING COLOR 
	$('#select_scan_login_box_color').on('change', function() {
		var scanLoginScreenLoginButtonColourName = this.value;
		var scanloginScreenLoginButtonColorJson = JSON.parse(colorArray);
		var  scanLoginScreenLoginButtonColorCode = scanloginScreenLoginButtonColorJson[scanLoginScreenLoginButtonColourName]+'!important';
		$('#scan_login_box_header').attr("style", "background-color:"+scanLoginScreenLoginButtonColorCode);
	});

	var select_scan_login_LoginButton_color = $('#select_scan_login_box_color').val();
	var select_scan_login_LoginButton_color_json = JSON.parse(colorArray);
	var select_scan_login_LoginButton_color_Code = select_scan_login_LoginButton_color_json[select_scan_login_LoginButton_color]+'!important';
	$('#scan_login_box_header').attr("style", "background-color:"+select_scan_login_LoginButton_color_Code, "border:"+select_scan_login_LoginButton_color_Code);



	// BOX HEADING FONT

	$('#select_scan_login_box_font').on('change', function() {
		var FontName = this.value+'!important';
		if(this.value == 'default'){
			$('#scan_login_box_header span').removeAttr('font-family');
		}
		else{
			$('#scan_login_box_header span').attr('style', 'font-family: '+FontName);
		}

	});


	var scanLoginScreenHeaderBoxFontName = $('#select_scan_login_box_font').val();
	if(scanLoginScreenHeaderBoxFontName == 'default'){
		$('#scan_login_box_header span').removeAttr('font-family');
	}
	else{
		$('#scan_login_box_header span').attr('style', 'font-family: '+scanLoginScreenHeaderBoxFontName);
	}


	// Login BUTTON COLOR 
	$('#select_scan_login_box_loginbutton_color').on('change', function() {
		var scanLoginScreenLoginButtonbgColourName = this.value;
		var scanloginScreenLoginButtonbgColorJson = JSON.parse(colorArray);
		var  scanLoginScreenLoginButtonbgColorCode = scanloginScreenLoginButtonbgColorJson[scanLoginScreenLoginButtonbgColourName]+'!important';

		$('#logButton').css({
	        "background-color": scanLoginScreenLoginButtonbgColorCode,
	    });



	});

	var select_scan_login_LoginButtonbg_color = $('#select_scan_login_box_loginbutton_color').val();
	var select_scan_login_LoginButtonbg_color_json = JSON.parse(colorArray);
	var select_scan_login_LoginButtonbg_color_Code = select_scan_login_LoginButtonbg_color_json[select_scan_login_LoginButtonbg_color]+'!important';
	$('#logButton').attr("style", "background-color:"+select_scan_login_LoginButtonbg_color_Code, "border:"+select_scan_login_LoginButtonbg_color_Code);


	$('#select_scan_login_box_loginbutton_font').on('change', function() {
		var FontName = this.value+'!important';
		if(this.value == 'default'){
			$('#logButton span').removeAttr('font-family');
		}
		else{
			$('#logButton span').attr('style', 'font-family: '+FontName);
		}

	});


	var scanLoginScreenLoginButtonFontName = $('#select_scan_login_box_loginbutton_font').val();
	if(scanLoginScreenLoginButtonFontName == 'default'){
		$('#logButton span').removeAttr('font-family');
	}
	else{
		$('#logButton span').attr('style', 'font-family: '+scanLoginScreenLoginButtonFontName);
	}



	
/* ======================================  SCAN LOGIN SCREEN SETTINGS ====================================================*/


/* ======================================  BUTTONS TAB SCREEN SETTINGS ====================================================*/





/* ====================================== BUTTONS TAB SCREEN SETTINGS ====================================================*/


	

/* ====================================== LOGO AND HEADERS TAB SCREEN SETTINGS ====================================================*/

	
	var admin_logo_image_preview_logo_and_headersvalue = $('#admin_login_screen_logo_size').val();
	$('#admin_logo_image_preview_logo_and_headers').css({ "height": admin_logo_image_preview_logo_and_headersvalue+'px' });		


	// RUN AJAX FOR GETTING THE SAVED LOGO DETAILS FROM DATABASE  

	$('#select_admin_logo_image_selection').on('change', function() {
		var select_admin_logo_image_selection = this.value;
		var selectedTextselect_admin_logo_image_selection = $(this).find("option:selected").text();
		var rootValue = '<?php echo ROOT ?>'+'images/admin_uploads/';

		// change the banner dropdown to select 
		$('#select_admin_banner_image_selection').val('select');


		if(select_admin_logo_image_selection == 'adminloginscreen')
		{
			$('.rightTable_admin_login_screen_logo').css("display",""); // OFF
			$('.rightTable_admin_login_screen_title_logo').css("display",'none'); //ON
			$('.rightTable_admindashboardbannerlogo').css("display","none"); // ON
			$('.rightTable_system_login_screen_logo_logoandheaders').css("display","none"); // ON
			$('.rightTable_system_login_screen_title_logo_logoandheaders').css("display","none"); // ON
			$('.rightTable_mob_login_screen_logo').css("display","none"); // ON
			

			// hide banner divs 

			$('.rightTable_admin_login_screen_logo_banner').css("display","none"); // ON
			$('.rightTable_system_login_screen_title_logo_logoandheaders_banner').css("display","none"); // ON

			
		}		
		else if(select_admin_logo_image_selection == 'adminloginscreentitle')
		{
			$('.rightTable_admin_login_screen_logo').css("display","none"); // ON
			$('.rightTable_admin_login_screen_title_logo').css("display",''); // OFF
			$('.rightTable_admindashboardbannerlogo').css("display","none"); // ON
			$('.rightTable_system_login_screen_logo_logoandheaders').css("display","none"); // ON
			$('.rightTable_system_login_screen_title_logo_logoandheaders').css("display","none"); // ON
			$('.rightTable_mob_login_screen_logo').css("display","none"); // ON


			// hide banner divs 

			$('.rightTable_admin_login_screen_logo_banner').css("display","none"); // ON
			$('.rightTable_system_login_screen_title_logo_logoandheaders_banner').css("display","none"); // ON

			
		}			
		else if(select_admin_logo_image_selection == 'admindashboardbannerlogo')
		{
			$('.rightTable_admin_login_screen_logo').css("display","none"); // ON
			$('.rightTable_admin_login_screen_title_logo').css("display","none"); // ON
			$('.rightTable_system_login_screen_logo_logoandheaders').css("display","none"); // ON
			$('.rightTable_system_login_screen_title_logo_logoandheaders').css("display","none"); // ON
			$('.rightTable_admindashboardbannerlogo').css("display",''); // OFF
			$('.rightTable_mob_login_screen_logo').css("display","none"); // ON


			// hide banner divs 

			$('.rightTable_admin_login_screen_logo_banner').css("display","none"); // ON
			$('.rightTable_system_login_screen_title_logo_logoandheaders_banner').css("display","none"); // ON
			
		}		
		else if(select_admin_logo_image_selection == 'systemloginscreen')
		{
			$('.rightTable_admin_login_screen_logo').css("display","none"); // ON
			$('.rightTable_admin_login_screen_title_logo').css("display","none"); // ON
			$('.rightTable_admindashboardbannerlogo').css("display","none"); // ON
			$('.rightTable_system_login_screen_title_logo_logoandheaders').css("display","none"); // ON
			$('.rightTable_system_login_screen_logo_logoandheaders').css("display",''); // OFF
			$('.rightTable_mob_login_screen_logo').css("display","none"); // ON


			// hide banner divs 

			$('.rightTable_admin_login_screen_logo_banner').css("display","none"); // ON
			$('.rightTable_system_login_screen_title_logo_logoandheaders_banner').css("display","none"); // ON
			
		}			
		else if(select_admin_logo_image_selection == 'systemloginscreentitle')
		{
			$('.rightTable_admin_login_screen_logo').css("display","none"); // ON
			$('.rightTable_admin_login_screen_title_logo').css("display","none"); // ON
			$('.rightTable_admindashboardbannerlogo').css("display","none"); // ON
			$('.rightTable_system_login_screen_title_logo_logoandheaders').css("display",""); // OFF
			$('.rightTable_system_login_screen_logo_logoandheaders').css("display","none"); // OFF
			$('.rightTable_mob_login_screen_logo').css("display","none"); // ON


			// hide banner divs

			$('.rightTable_admin_login_screen_logo_banner').css("display","none"); // ON
			$('.rightTable_system_login_screen_title_logo_logoandheaders_banner').css("display","none"); // ON
			
		}		
		else if(select_admin_logo_image_selection == 'mobilescreenlogo')
		{
			$('.rightTable_admin_login_screen_logo').css("display","none"); // ON
			$('.rightTable_admin_login_screen_title_logo').css("display","none"); // ON
			$('.rightTable_admindashboardbannerlogo').css("display","none"); // ON
			$('.rightTable_system_login_screen_title_logo_logoandheaders').css("display","none"); // ON
			$('.rightTable_system_login_screen_logo_logoandheaders').css("display","none"); // ON
			$('.rightTable_mob_login_screen_logo').css("display",""); // OFF

			// hide banner divs 

			$('.rightTable_admin_login_screen_logo_banner').css("display","none"); // ON
			$('.rightTable_system_login_screen_title_logo_logoandheaders_banner').css("display","none"); // ON

		}		
		else if(select_admin_logo_image_selection == 'select')
		{
			$('.rightTable_admin_login_screen_logo').css("display","none"); // ON
			$('.rightTable_admin_login_screen_title_logo').css("display","none"); // ON
			$('.rightTable_admindashboardbannerlogo').css("display","none"); // ON
			$('.rightTable_system_login_screen_title_logo_logoandheaders').css("display","none"); // ON
			$('.rightTable_system_login_screen_logo_logoandheaders').css("display","none"); // ON
			$('.rightTable_mob_login_screen_logo').css("display","none"); // ON



			// hide banner divs 

			$('.rightTable_admin_login_screen_logo_banner').css("display","none"); // ON
			$('.rightTable_system_login_screen_title_logo_logoandheaders_banner').css("display","none"); // ON

		}

		$("#decrease").attr("onclick","decreaseValue('"+select_admin_logo_image_selection+"')");
		$("#increase").attr("onclick","increaseValue('"+select_admin_logo_image_selection+"')");


		if(select_admin_logo_image_selection != 'select')
		{
			// display admin page according to selection 

			$.ajax({
				url: "company_layout/ajax/get_saved_logo_details.php",
				data: {select_admin_logo_image_selection: select_admin_logo_image_selection},
				success: function(ajaxresult){
					var data = JSON.parse(ajaxresult);

					if(data['image_link']){
						var imageurlroot= rootValue+data['image_link'];
					}
					else
					{
						var imageurlroot= '';
					}

					$('#admin_logo_image_preview_logo_and_headers').css({"display": ''});
					$('#admin_logo_image_preview').css({"display": ''});
					$('#admin_logo_name_image_preview').css({"display": ''});
					$('#hdieimagesizerowadmin').css({"display": ''});
					$('#hdiecheckboxrowadmin').css({"display": ''});
					$('#uploadlogorowlogoheaders').css({"display": ''});
					$('#admin_logo_image_preview_logo_and_headers').css({"height": data['admin_login_screen_logo_size']});
					$("#admin_logo_image_preview").attr("src",imageurlroot);
					$("#admin_logo_image_preview_logo_and_headers").attr("src",imageurlroot);
					$("#admin_login_screen_logo_size").val(data['admin_login_screen_logo_size']);
					$("#admin_screen_logo_image_link").val(data['image_link']);
					$("#admin_logo_name_image_preview").val(data['image_link']);
					$("#titleoftheselecetedlogo").html(selectedTextselect_admin_logo_image_selection);

					if(data['show_hide_logo_common_field'] == '1')
					{
						$('#show_hide_logo_common_field').prop('checked', true);
					}
					else
					{
						$('#show_hide_logo_common_field').prop('checked', false);
					}


				}
			});

		}
		else
		{
			$('#admin_logo_image_preview').css({"display": 'none'});
			$('#admin_logo_name_image_preview').css({"display": 'none'});
			$('#admin_logo_name_image_preview').val('');
			$('#hdieimagesizerowadmin').css({"display": 'none'});
			$('#hdiecheckboxrowadmin').css({"display": 'none'});
			$('#admin_login_screen_logo_size').val('45');
			$('#uploadlogorowlogoheaders').css({"display": 'none'});
			$("#titleoftheselecetedlogo").html(selectedTextselect_admin_logo_image_selection);
			$('#admin_logo_image_preview_logo_and_headers').css({"display": 'none'});
			$("#admin_screen_logo_image_link").val('');
			$("#admin_logo_name_image_preview").val('');
			$('#show_hide_logo_common_field').prop('checked', false);



		}
	});


	$( document ).ready(function() {

		var select_admin_logo_image_selection = $('#select_admin_logo_image_selection').val();
		$('#admin_logo_image_preview').css({"display": 'none'});
		$('#admin_logo_name_image_preview').css({"display": 'none'});
		$('#hdieimagesizerowadmin').css({"display": 'none'});
		$('#hdiecheckboxrowadmin').css({"display": 'none'});
		$('#admin_logo_name_image_preview').val('');
		$('#admin_login_screen_logo_size').val('45');
		$('#uploadlogorowlogoheaders').css({"display": 'none'});
		$('#admin_logo_image_preview_logo_and_headers').css({"display": 'none'});
		$("#titleoftheselecetedlogo").html('Select Logo');
		$('#show_hide_logo_common_field').prop('checked', false);

	});



		$('#show_hide_logo_common_field').on('change', function() {
			var show_hide_logo_common_field = this.checked;

			var select_admin_logo_image_selection= $('#select_admin_logo_image_selection').val();
			console.log(select_admin_logo_image_selection);

			if(select_admin_logo_image_selection == 'adminloginscreen')
			{	
				if(show_hide_logo_common_field == true)
				{
					// show
					$('#admin_logo_image_preview_logo_and_headers').css({"display": ''});
				}
				else
				{
					// hide 
					$('#admin_logo_image_preview_logo_and_headers').css({"display": 'none'});

				}

			}			
			else if(select_admin_logo_image_selection == 'adminloginscreentitle')
			{	
				if(show_hide_logo_common_field == true)
				{
					// show
					$('#admin_login_screen_logo_title').css({"display": ''});
				}
				else
				{
					// hide 
					$('#admin_login_screen_logo_title').css({"display": 'none'});

				}

			}			
			else if(select_admin_logo_image_selection == 'admindashboardbannerlogo')
			{	
				if(show_hide_logo_common_field == true)
				{
					// show
					$('#admin_dashboard_banner_logo_logoandheaders').css({"display": ''});
				}
				else
				{
					// hide 
					$('#admin_dashboard_banner_logo_logoandheaders').css({"display": 'none'});

				}

			}			
			else if(select_admin_logo_image_selection == 'systemloginscreen')
			{	
				if(show_hide_logo_common_field == true)
				{
					// show
					$('#system_logo_image_select_logoandheaders_loginscreenlogo').css({"display": ''});
				}
				else
				{
					// hide 
					$('#system_logo_image_select_logoandheaders_loginscreenlogo').css({"display": 'none'});

				}

			}			
			else if(select_admin_logo_image_selection == 'systemloginscreentitle')
			{	
				if(show_hide_logo_common_field == true)
				{
					// show
					$('#system_logo_image_select_logoandheaders_loginscreenlogo_title').css({"display": ''});
				}
				else
				{
					// hide 
					$('#system_logo_image_select_logoandheaders_loginscreenlogo_title').css({"display": 'none'});

				}

			}			
			else if(select_admin_logo_image_selection == 'mobilescreenlogo')
			{	
				if(show_hide_logo_common_field == true)
				{
					// show
					$('#mob_logo_selection_logo_and_headers').css({"display": ''});
				}
				else
				{
					// hide 
					$('#mob_logo_selection_logo_and_headers').css({"display": 'none'});

				}

			}			


		});

/* ====================================== LOGO AND HEADERS TAB SCREEN SETTINGS ====================================================*/


/* ============================================== MAIN DASHBOARD TAB  SETTINGS ====================================================*/

$( document ).ready(function() {
	var maincolorSelect1 = $('#maincolorSelect1').val();
	var maincolorJson1 = JSON.parse(colorArray);
	var maincolorCode1 = maincolorJson1[maincolorSelect1	];
	$('#maincircle1').css('color', maincolorCode1);
	$('.maindiv1').css('background', maincolorCode1);


	var maincolorSelect2 = $('#maincolorSelect2').val();
	var maincolorJson2 = JSON.parse(colorArray);
	var  maincolorCode2 = maincolorJson2[maincolorSelect2];
	$('#maincircle2').css('color', maincolorCode2);
	$('.maindiv2').css('background', maincolorCode2);

	var maincolorSelect3 = $('#maincolorSelect3').val();
	var maincolorJson3 = JSON.parse(colorArray);
	var maincolorCode3 = maincolorJson3[maincolorSelect3];
	$('#maincircle3').css('color', maincolorCode3);
	$('.maindiv3').css('background', maincolorCode3);

	var maincolorSelect4 = $('#maincolorSelect4').val();
	var maincolorJson4 = JSON.parse(colorArray);
	var maincolorCode4 = maincolorJson4[maincolorSelect4];
	$('#maincircle4').css('color', maincolorCode4);
	$('.maindiv4').css('background', maincolorCode4);

	var maincolorSelect5 = $('#maincolorSelect5').val();
	var maincolorJson5 = JSON.parse(colorArray);
	var maincolorCode5 = maincolorJson5[maincolorSelect5];
	$('#maincircle5').css('color', maincolorCode5);
	$('.maindiv5').css('background', maincolorCode5);

	var maincolorSelect6 = $('#maincolorSelect6').val();
	var maincolorJson6 = JSON.parse(colorArray);
	var maincolorCode6 = maincolorJson6[maincolorSelect6];
	$('#maincircle6').css('color', maincolorCode6);
	$('.maindiv6').css('background', maincolorCode6);

	var maincolorSelect7 = $('#maincolorSelect7').val();
	var maincolorJson7 = JSON.parse(colorArray);
	var maincolorCode7 = maincolorJson7[maincolorSelect7];
	$('#maincircle7').css('color', maincolorCode7);
	$('.maindiv7').css('background', maincolorCode7);

	var maincolorSelect8 = $('#maincolorSelect8').val();
	var maincolorJson8 = JSON.parse(colorArray);
	var maincolorCode8 = maincolorJson8[maincolorSelect8];
	$('#maincircle8').css('color', maincolorCode8);
	$('.maindiv8').css('background', maincolorCode8);

	var maincolorSelect9 = $('#maincolorSelect9').val();
	var maincolorJson9 = JSON.parse(colorArray);
	var maincolorCode9 = maincolorJson9[maincolorSelect9];
	$('#maincircle9').css('color', maincolorCode9);
	$('.maindiv9').css('background', maincolorCode9);

	var maincolorSelect10 = $('#maincolorSelect10').val();
	var maincolorJson10 = JSON.parse(colorArray);
	var maincolorCode10 = maincolorJson10[maincolorSelect10];
	$('#maincircle10').css('color', maincolorCode10);
	$('.maindiv10').css('background', maincolorCode10);

	var maincolorSelect15 = $('#maincolorSelect15').val();
	var maincolorJson15 = JSON.parse(colorArray);
	var maincolorCode15 = maincolorJson15[maincolorSelect15];
	$('#maincircle15').css('color', maincolorCode15);
	$('.h2customcalssmain h2 ').css('background-color', maincolorCode15);


	var maincolorSelect16 = $('#maincolorSelect16').val();
	var maincolorJson16 = JSON.parse(colorArray);
	var maincolorCode16 = maincolorJson16[maincolorSelect16];
	$('#maincircle16').css('color', maincolorCode16);
	$('#mainrightTable').css('background-color', maincolorCode16);	

	var mainfontColorfontColorcircle = $('#mainfontColor').val();
	var maincolorJsonfontColorcircle = JSON.parse(colorArray);
	var maincolorCodefontColorcircle = maincolorJsonfontColorcircle[mainfontColorfontColorcircle];
	$('#mainfontColorcircle').css('color',maincolorCodefontColorcircle);
	$('.maindashbox p span').css('color',maincolorCodefontColorcircle);	



	var mainFontName1 = $('#main_font_settings_box').val();
	if(mainFontName1 == 'default'){
		$('h2.maindiv15 span').removeAttr('style');
	}
	else{
		$('h2.maindiv15 span').attr('style', 'font-family: '+mainFontName1);
	}

	var mainFontName2 = $('#main_font_settings_box_content').val();
	if(mainFontName2 == 'default'){
		$('.mainboxcontent').removeAttr('style');
	}
	else{
		$('.mainboxcontent').attr('style', 'font-family: '+mainFontName2);
	}

	var mainFontName3 = $('#main_font_settings').val();
	if(mainFontName3 == 'default'){
		$('.maindashbox p').removeAttr('style');
	}else{
		$('.maindashbox p').attr('style', 'font-family: '+mainFontName3);
	}	


});
	



//====================================================== Color picker 1  =======================================


		$('#maincolorSelect1').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#maincircle1').css('color', colorCode);
			$('.maindiv1').css('background', colorCode);
		});


//====================================================== Color picker 2  =======================================


		$('#maincolorSelect2').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#maincircle2').css('color', colorCode);
			$('.maindiv2').css('background', colorCode);

		});
		

//====================================================== Color picker 3  =======================================


		$('#maincolorSelect3').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#maincircle3').css('color', colorCode);
			$('.maindiv3').css('background', colorCode);

		});
		

//====================================================== Color picker 4  =======================================


		$('#maincolorSelect4').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#maincircle4').css('color', colorCode);
			$('.maindiv4').css('background', colorCode);

		});
		

//====================================================== Color picker 5  =======================================


		$('#maincolorSelect5').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#maincircle5').css('color', colorCode);
			$('.maindiv5').css('background', colorCode);

		});
		

//====================================================== Color picker 6  =======================================


		$('#maincolorSelect6').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#maincircle6').css('color', colorCode);
			$('.maindiv6').css('background', colorCode);

		});

//====================================================== Color picker 7  =======================================


		$('#maincolorSelect7').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#maincircle7').css('color', colorCode);
			$('.maindiv7').css('background', colorCode);


		});

//====================================================== Color picker 8  =======================================


		$('#maincolorSelect8').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#maincircle8').css('color', colorCode);
			$('.maindiv8').css('background', colorCode);

		});
		
//====================================================== Color picker 9  =======================================


		$('#maincolorSelect9').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#maincircle9').css('color', colorCode);
			$('.maindiv9').css('background', colorCode);

		});
				
//====================================================== Color picker 10  =======================================


		$('#maincolorSelect10').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#maincircle10').css('color', colorCode);
			$('.maindiv10').css('background', colorCode);

		});
						

		
//====================================================== Color picker 15  =======================================


		$('#maincolorSelect15').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#maincircle15').css('color', colorCode);
			$('.h2customcalssmain h2 ').css('background-color', colorCode);

		});
//====================================================== Color picker 16  =======================================


		$('#maincolorSelect16').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#maincircle16').css('color', colorCode);
			$('#mainrightTable').css('background-color', colorCode);

		});
//====================================================== FONT COLOR PICKER  =======================================


		$('#mainfontColor').on('change', function() {

			var colourName = this.value;

			var colorJson = JSON.parse(colorArray);

			var  colorCode = colorJson[colourName];

			$('#mainfontColorcircle').css('color', colorCode);
			$('.maindashbox p span').attr('style', 'color: '+colorCode);

		});
		


		$('#main_font_settings').on('change', function() {

			var FontName = this.value+'!important';

			// var fontJson = JSON.parse(fontArray);
			if(this.value == 'default')
			{
				$('.maindashbox p').removeAttr('style');
			}
			else
			{
				$('.maindashbox p').attr('style', 'font-family: '+FontName);
			}

		});
	




		$('#main_font_settings_box').on('change', function() {

			var FontName = this.value+'!important';


			// var fontJson = JSON.parse(fontArray);
			if(this.value == 'default')
			{
				$('h2.maindiv15 span').removeAttr('style');
			}
			else
			{
				$('h2.maindiv15 span').attr('style', 'font-family: '+FontName);
			}

		});
	




		$('#main_font_settings_box_content').on('change', function() {

			var FontName = this.value+'!important';


			// var fontJson = JSON.parse(fontArray);
			if(this.value == 'default')
			{
				$('.mainboxcontent').removeAttr('style');
			}
			else
			{
				$('.mainboxcontent').attr('style', 'font-family: '+FontName);
			}

		});
		


	$('#main_background_image_selection').on('change', function() {
			var background_image_selection = this.value;
			if(background_image_selection == 'selectfile'){
				$('#mainselectimagebutton').css("display","");
			}
			else if(background_image_selection == 'noimage'){
				$('#mainselectimagebutton').css("display","none");
				$('#uploadimages_main_bg').val('');
				$('#main_dashboard_image_link').val('');
				$('#mainrightTable').css('background','');
				$('#main_background_image_preview').css("display","none");
				$('#main_background_image_name_preview').css("display","none");
			}
	});


	$( document ).ready(function() {

		var background_image_selection = $('#main_background_image_selection').val();
		if(background_image_selection == 'selectfile'){
			$('#mainselectimagebutton').css("display","");
		}
		else if(background_image_selection == 'noimage'){
			$('#mainselectimagebutton').css("display","none");
			$('#uploadimages_main_bg').val('');
			$('#main_dashboard_image_link').val('');
			$('#mainrightTable').css('background','');
			$('#main_background_image_preview').css("display","none");
			$('#main_background_image_name_preview').css("display","none");
		}

	});



		// HOME BUTTON COLOR 
	    $('#main_dashboard_color2').on('change', function() {
			var main_dashboard_color2ColourName = this.value;
			var main_dashboard_color2ColorJson = JSON.parse(colorArray);
			var main_dashboard_color2ColorCode = main_dashboard_color2ColorJson[main_dashboard_color2ColourName]+'!important';

			$('#adminsigncustomerdashboard').css({"background-color": main_dashboard_color2ColorCode});
			$('#mainhomebutton').css({"background-color": main_dashboard_color2ColorCode});
			$('#main_dashboard_circle2').css({"color": main_dashboard_color2ColorCode});
		});


		var main_dashboard_color2_heading_color = $('#main_dashboard_color2').val();
		var main_dashboard_color2_heading_color_json = JSON.parse(colorArray);
		var main_dashboard_color2_heading_color_Code = main_dashboard_color2_heading_color_json[main_dashboard_color2_heading_color]+'!important';

		$('#adminsigncustomerdashboard').css({"background-color": main_dashboard_color2_heading_color_Code});
		$('#mainhomebutton').css({"background-color": main_dashboard_color2_heading_color_Code});
		$('#main_dashboard_circle2').css({"color": main_dashboard_color2_heading_color_Code});



	// // HEADER BACKGROUND COLOR 
    $('#main_dashboard_color1').on('change', function() {
		var main_dashboard_color1ColourName = this.value;
		var main_dashboard_color1ColorJson = JSON.parse(colorArray);
		var main_dashboard_color1ColorCode = main_dashboard_color1ColorJson[main_dashboard_color1ColourName]+'!important';

		$('.mainnavbarbackgroundcolor').css({"background-color": main_dashboard_color1ColorCode});
		$('#main_dashboard_circle1').css({"color": main_dashboard_color1ColorCode});
	});


	var main_dashboard_color1_heading_color = $('#main_dashboard_color1').val();
	var main_dashboard_color1_heading_color_json = JSON.parse(colorArray);
	var main_dashboard_color1_heading_color_Code = main_dashboard_color1_heading_color_json[main_dashboard_color1_heading_color]+'!important';

	$('.mainnavbarbackgroundcolor').css({"background-color": main_dashboard_color1_heading_color_Code});
	$('#main_dashboard_circle1').css({"color": main_dashboard_color1_heading_color_Code});





	// // MAIN HEADER 1 BACKGROUND COLOR 
    $('#main_dashboard_color3').on('change', function() {
		var main_dashboard_color3ColourName = this.value;
		var main_dashboard_color3ColorJson = JSON.parse(colorArray);
		var main_dashboard_color3ColorCode = main_dashboard_color3ColorJson[main_dashboard_color3ColourName];

		// console.log(logo_and_headers_color3ColorCode);

		$('.mainheadergradientcolor').css({ 'background-image':'-webkit-linear-gradient('+main_dashboard_color3ColorCode+','+main_dashboard_color3ColorCode+')', });
		$('#main_dashboard_circle3').css({"color": main_dashboard_color3ColorCode});
	});


	var main_dashboard_color3_heading_color = $('#main_dashboard_color3').val();
	var main_dashboard_color3_heading_color_json = JSON.parse(colorArray);
	var main_dashboard_color3_heading_color_Code = main_dashboard_color3_heading_color_json[main_dashboard_color3_heading_color];

	$('.mainheadergradientcolor').css({ 'background-image':'-webkit-linear-gradient('+main_dashboard_color3_heading_color_Code+','+main_dashboard_color3_heading_color_Code+')', });
	$('#main_dashboard_circle3').css({"color": main_dashboard_color3_heading_color_Code});





	// MAIN HEADER 2 BACKGROUND COLOR 
    $('#main_dashboard_color4').on('change', function() {
		var main_dashboard_color4ColourName = this.value;
		var main_dashboard_color4ColorJson = JSON.parse(colorArray);
		var main_dashboard_color4ColorCode = main_dashboard_color4ColorJson[main_dashboard_color4ColourName];
		var main_dashboard_color3_heading_color1 = $('#main_dashboard_color3').val();
		var main_dashboard_color3_heading_color_json1 = JSON.parse(colorArray);
		var main_dashboard_color3_heading_color_Code1 = main_dashboard_color3_heading_color_json1[main_dashboard_color3_heading_color1];


		$('.mainheadergradientcolor').css({ 'background-image':'-webkit-linear-gradient('+main_dashboard_color3_heading_color_Code1+','+main_dashboard_color4ColorCode+')', });

		$('#main_dashboard_circle4').css({"color": main_dashboard_color4ColorCode});
	});


	var main_dashboard_color4_heading_color = $('#main_dashboard_color4').val();
	var main_dashboard_color4_heading_color_json = JSON.parse(colorArray);
	var main_dashboard_color4_heading_color_Code = main_dashboard_color4_heading_color_json[main_dashboard_color4_heading_color];
	var main_dashboard_color3_heading_color11 = $('#main_dashboard_color3').val();
	var main_dashboard_color3_heading_color_json11 = JSON.parse(colorArray);
	var main_dashboard_color3_heading_color_Code11 = main_dashboard_color3_heading_color_json11[main_dashboard_color3_heading_color11];

	$('.mainheadergradientcolor').css({ 'background-image':'-webkit-linear-gradient('+main_dashboard_color3_heading_color_Code11+','+main_dashboard_color4_heading_color_Code+')', });
	$('#main_dashboard_circle4').css({"color": main_dashboard_color4_heading_color_Code});





	// HEADING FONT

	$('#main_dashboard_header_font').on('change', function() {
		var FontName = this.value+'!important';
		if(this.value == 'default'){
			$('.main_dashboard_header_font_style ').removeAttr('font-family');
		}else{
			$('.main_dashboard_header_font_style').attr('style', 'font-family: '+FontName);
		}
	});

	var mainDashboardHeaderFontName = $('#main_dashboard_header_font').val();
	if(mainDashboardHeaderFontName == 'default'){
		$('.main_dashboard_header_font_style').removeAttr('font-family');
	}
	else{
		$('.main_dashboard_header_font_style').attr('style', 'font-family: '+mainDashboardHeaderFontName);
	}



	// HEADER COLOR

    $('#main_dashboard_header_font_color').on('change', function() {
		var main_dashboard_header_font_colorName = this.value;
		var main_dashboard_header_font_colorJson = JSON.parse(colorArray);
		var main_dashboard_header_font_ColorCode = main_dashboard_header_font_colorJson[main_dashboard_header_font_colorName];
		$('.main_dashboard_header_font_style').css({"color": main_dashboard_header_font_ColorCode});
		$('#main_dashboard_header_font_color_circle').css({"color": main_dashboard_header_font_ColorCode});
		$('.regoadminmainheaderbutton').css({"color": main_dashboard_header_font_ColorCode});
	});


	var main_dashboard_header_font_colorvalue = $('#main_dashboard_header_font_color').val();
	var main_dashboard_header_font_colorvaluejson = JSON.parse(colorArray);
	var main_dashboard_header_font_colorvaluecolor_Code = main_dashboard_header_font_colorvaluejson[main_dashboard_header_font_colorvalue];
	$('.main_dashboard_header_font_style').css({"color": main_dashboard_header_font_colorvaluecolor_Code});
	$('#main_dashboard_header_font_color_circle').css({"color": main_dashboard_header_font_colorvaluecolor_Code});
	$('.regoadminmainheaderbutton').css({"color": main_dashboard_header_font_colorvaluecolor_Code});



	// MAIN HEADING FONT

	$('#main_dashboard_main_header_font').on('change', function() {
		var FontName = this.value;
		if(this.value == 'default'){
			$('table td span.mainheadermaintitle').css({"font-family": ''});
			$('.mainheadermaintitle').css({"font-family": ''});
		}else{
			$('table td span.mainheadermaintitle').css({"font-family": FontName});
			$('.mainheadermaintitle').css({"font-family": FontName});
		}
	});

	var mainDashboardMainHeaderFontName = $('#main_dashboard_main_header_font').val();
	if(mainDashboardMainHeaderFontName == 'default'){
		$('table td span.mainheadermaintitle').css({"font-family": ''});
		$('.mainheadermaintitle').css({"font-family": ''});
	}
	else{
		$('table td span.mainheadermaintitle').css({"font-family": mainDashboardMainHeaderFontName});
		$('.mainheadermaintitle').css({"font-family": mainDashboardMainHeaderFontName});

	}

	// MAIN HEADER COLOR

    $('#main_dashboard_main_header_font_color').on('change', function() {
		var main_dashboard_main_header_font_colorName = this.value;
		var main_dashboard_main_header_font_colorJson = JSON.parse(colorArray);
		var main_dashboard_main_header_font_ColorCode = main_dashboard_main_header_font_colorJson[main_dashboard_main_header_font_colorName];
		$('#main_dashboard_main_header_font_color_circle').css({"color": main_dashboard_main_header_font_ColorCode});
		$('table td span.mainheadermaintitle').css({"color": main_dashboard_main_header_font_ColorCode});
		$('.mainheadermaintitle').css({"color": main_dashboard_main_header_font_ColorCode});
	});


	var main_dashboard_main_header_font_colorvalue = $('#main_dashboard_main_header_font_color').val();
	var main_dashboard_main_header_font_colorvaluejson = JSON.parse(colorArray);
	var main_dashboard_main_header_font_colorvaluecolor_Code = main_dashboard_main_header_font_colorvaluejson[main_dashboard_main_header_font_colorvalue];
	$('#main_dashboard_main_header_font_color_circle').css({"color": main_dashboard_main_header_font_colorvaluecolor_Code});
	$('table td span.mainheadermaintitle').css({"color": main_dashboard_main_header_font_colorvaluecolor_Code});
	$('.mainheadermaintitle').css({"color": main_dashboard_main_header_font_colorvaluecolor_Code});




/* ====================================== MAIN DASHBOARD TAB  SCREEN SETTINGS ====================================================*/


/* ====================================================== LOGO AND HEADERS BANNER VALUE GET SECTION================================*/

// RUN AJAX FOR GETTING THE SAVED LOGO DETAILS FROM DATABASE  

	$('#select_admin_banner_image_selection').on('change', function() {
		var select_admin_banner_image_selection = this.value;
		var rootValue = '<?php echo ROOT ?>'+'images/admin_uploads/';

		// change the logo dropdown to select 
		$('#select_admin_logo_image_selection').val('select');

		if(select_admin_banner_image_selection == 'adminloginscreenbanner')
		{
			// show banner divs  
			$('.rightTable_admin_login_screen_logo_banner').css("display",""); // OFF
			$('.rightTable_system_login_screen_title_logo_logoandheaders_banner').css("display","none"); // ON
			$('.rightTable_mob_login_screen_banner_logo').css("display","none"); // ON

			//Hide logo divs 
			$('.rightTable_admin_login_screen_logo').css("display","none"); // ON
			$('.rightTable_admin_login_screen_title_logo').css("display","none"); // ON
			$('.rightTable_admindashboardbannerlogo').css("display","none"); // ON
			$('.rightTable_system_login_screen_title_logo_logoandheaders').css("display","none"); // ON
			$('.rightTable_system_login_screen_logo_logoandheaders').css("display","none"); // ON
			$('.rightTable_mob_login_screen_logo').css("display","none"); // ON
		}		
		else if(select_admin_banner_image_selection == 'systemloginscreenbanner')
		{
			// show banner divs  
			$('.rightTable_admin_login_screen_logo_banner').css("display","none"); // ON
			$('.rightTable_mob_login_screen_banner_logo').css("display","none"); // ON
			$('.rightTable_system_login_screen_title_logo_logoandheaders_banner').css("display",""); // OFF

			//Hide logo divs 
			$('.rightTable_admin_login_screen_logo').css("display","none"); // ON
			$('.rightTable_admin_login_screen_title_logo').css("display","none"); // ON
			$('.rightTable_admindashboardbannerlogo').css("display","none"); // ON
			$('.rightTable_system_login_screen_title_logo_logoandheaders').css("display","none"); // ON
			$('.rightTable_system_login_screen_logo_logoandheaders').css("display","none"); // ON
			$('.rightTable_mob_login_screen_logo').css("display","none"); // ON
		}
		else if(select_admin_banner_image_selection == 'mobloginscreenbanner')
		{
			// show banner divs  
			$('.rightTable_admin_login_screen_logo_banner').css("display","none"); // ON
			$('.rightTable_mob_login_screen_banner_logo').css("display",""); // OFF
			$('.rightTable_system_login_screen_title_logo_logoandheaders_banner').css("display","none"); // ON

			//Hide logo divs 
			$('.rightTable_admin_login_screen_logo').css("display","none"); // ON
			$('.rightTable_admin_login_screen_title_logo').css("display","none"); // ON
			$('.rightTable_admindashboardbannerlogo').css("display","none"); // ON
			$('.rightTable_system_login_screen_title_logo_logoandheaders').css("display","none"); // ON
			$('.rightTable_system_login_screen_logo_logoandheaders').css("display","none"); // ON
			$('.rightTable_mob_login_screen_logo').css("display","none"); // ON
		}	
		else if(select_admin_banner_image_selection == 'select')
		{

			// hide banner divs  
			$('.rightTable_admin_login_screen_logo_banner').css("display","none"); // ON
			$('.rightTable_system_login_screen_title_logo_logoandheaders_banner').css("display","none"); // OFF
			$('.rightTable_mob_login_screen_banner_logo').css("display","none"); // OFF
			// hide logo divs
			$('.rightTable_admin_login_screen_logo').css("display","none"); // ON
			$('.rightTable_admin_login_screen_title_logo').css("display","none"); // ON
			$('.rightTable_admindashboardbannerlogo').css("display","none"); // ON
			$('.rightTable_system_login_screen_title_logo_logoandheaders').css("display","none"); // ON
			$('.rightTable_system_login_screen_logo_logoandheaders').css("display","none"); // ON
			$('.rightTable_mob_login_screen_logo').css("display","none"); // ON
		}

		if(select_admin_banner_image_selection != 'select')
		{
			// display admin page according to selection 

			$.ajax({
				url: "company_layout/ajax/get_saved_banner_details.php",
				data: {select_admin_banner_image_selection: select_admin_banner_image_selection},
				success: function(ajaxresult){
					var data = JSON.parse(ajaxresult);


					if(data['image_link']){
						var imageurlroot= rootValue+data['image_link'];
					}
					else
					{
						var imageurlroot= '';
					}

					$('#admin_logo_image_preview_logo_and_headers_banner').css({"display": ''});
					$('#hdiecheckboxrowadminbanner').css({"display": ''});
					$('#uploadlogorowlogoheadersbanner').css({"display": ''});
					$("#admin_logo_image_preview_banner").attr("src",imageurlroot);
					$("#admin_login_screen_logo_size_banner").val(data['admin_login_screen_logo_size_banner']);
					$("#admin_screen_logo_image_link_banner").val(data['image_link']);
					$("#admin_logo_image_preview_banner_text").val(data['image_link']);

					if(data['show_hide_logo_common_field_banner'] == '1')
					{
						$('#show_hide_logo_common_field_banner').prop('checked', true);
					}
					else
					{
						$('#show_hide_logo_common_field_banner').prop('checked', false);
					}


				}
			});

		}
		else
		{
			$('#admin_logo_image_preview_logo_and_headers_banner').css({"display": 'none'});
			$('#hdiecheckboxrowadminbanner').css({"display": 'none'});
			$('#uploadlogorowlogoheadersbanner').css({"display": 'none'});
			$("#admin_login_screen_logo_size_banner").val();
			$("#admin_screen_logo_image_link_banner").val();
			$("#admin_logo_image_preview_banner_text").val();
			$('#show_hide_logo_common_field_banner').prop('checked', false);
		}
	});

	

	$('#show_hide_logo_common_field_banner').on('change', function() {
		var show_hide_logo_common_field_banner = this.checked;

		var select_admin_banner_image_selection= $('#select_admin_banner_image_selection').val();

		if(select_admin_banner_image_selection == 'adminloginscreenbanner')
		{	
			if(show_hide_logo_common_field_banner == true)
			{
				// show
				$('#admin_logo_image_preview_logo_and_headersbanner').css({"display": ''});
			}
			else
			{
				// hide 
				$('#admin_logo_image_preview_logo_and_headersbanner').css({"display": 'none'});

			}
		}			
		else if(select_admin_banner_image_selection == 'systemloginscreenbanner')
		{	
			if(show_hide_logo_common_field_banner == true)
			{
				// show
				$('#admin_logo_image_preview_logo_and_headersbannersystem').css({"display": ''});
			}
			else
			{
				// hide 
				$('#admin_logo_image_preview_logo_and_headersbannersystem').css({"display": 'none'});

			}
		}			
		else if(select_admin_banner_image_selection == 'mobloginscreenbanner')
		{	
			if(show_hide_logo_common_field_banner == true)
			{
				// show
				$('#mob_banner_selection_logo_and_headers').css({"display": ''});
			}
			else
			{
				// hide 
				$('#mob_banner_selection_logo_and_headers').css({"display": 'none'});

			}
		}			

	});

/* ====================================================== LOGO AND HEADERS BANNER VALUE GET SECTION================================*/




/*======================================================LOGO AND HEADERS FILTER ====================================================*/

	$('#select_filter_logo_and_headers').on('change', function() {
		var select_filter_logo_and_headers = this.value;

		if(select_filter_logo_and_headers != 'select')
		{
			$.ajax({
				url: "company_layout/ajax/set_filter_session.php",
				data: {select_filter_logo_and_headers: select_filter_logo_and_headers},
				success: function(ajaxresult){
					// var data = JSON.parse(ajaxresult);
					if(ajaxresult)
					{
						location.reload();
					}
				}
			});
		}
		
		
	});
/*======================================================LOGO AND HEADERS FILTER ====================================================*/





});


/*======================================================BUTONS TAB CONFIG AND SETTINGS START====================================================*/

$( document ).ready(function() {


	// BUTTON ON CHANGE COLOR CODE 

    $('#buttons_color_select').on('change', function() {
		var buttons_color_select_colorName = this.value;
		var buttons_color_select_json = JSON.parse(colorArray);
		var buttons_color_select_code = buttons_color_select_json[buttons_color_select_colorName];


		// get font color 

		var buttons_color_select_colorName_font = $('#button_text_color').val();
		var buttons_color_select_json_font = JSON.parse(colorArray);
		var buttons_color_select_code_font = buttons_color_select_json_font[buttons_color_select_colorName_font];


		// WHERE TO CHANGE COLOR
		var whereTochange =$('#hiddenButtonValue').val();
		$('#'+whereTochange).css({"background-color": buttons_color_select_code+'!important',"border-color": buttons_color_select_code+'!important',"color":buttons_color_select_code_font+'!important'});

		$('#buttons_color_select_circle').css({"color": buttons_color_select_code});



	


		// get on change color 1 

		var button_text_color = $('#button_text_color').val();
		var button_text_color1 = JSON.parse(colorArray);
		var button_text_color_code1 = button_text_color1[button_text_color]; // second code



		var button_text_color = $('#button_text_color').val();
		var button_text_color1 = JSON.parse(colorArray);
		var button_text_color_code1 = button_text_color1[button_text_color]; // second code



		var button_onchange_color_select = $('#button_onchange_color_select').val();
		var button_onchange_color_select1 = JSON.parse(colorArray);
		var button_onchange_color_select_code1 = button_onchange_color_select1[button_onchange_color_select]; // fourth code

		var button_onchange_color_select_2 = $('#button_onchange_color_select_2').val();
		var button_onchange_color_select_21 = JSON.parse(colorArray);
		var button_onchange_color_select_code21 = button_onchange_color_select_21[button_onchange_color_select_2]; // fifth code



		var button_hoover_color = $('#button_hoover_select').val();
		var button_hoover_color1 = JSON.parse(colorArray);
		var button_hoover_color_code1 = button_hoover_color1[button_hoover_color]; // third code


		// convert the values to color 
		var hiddenArray = [];
		hiddenArray.push({
            'button_color': buttons_color_select_code, 
            'button_color_raw_value': buttons_color_select_colorName, 
            'button_text_color': button_text_color_code1, 
            'button_text_color_raw_value': button_text_color, 
            'button_hoover_color': button_hoover_color_code1, 
            'button_hoover_color_raw_value': button_hoover_color, 
            'button_onchange_color_select': button_onchange_color_select_code1, 
            'button_onchange_color_select_raw_value': button_onchange_color_select, 
            'button_onchange_color_select_2': button_onchange_color_select_code21, 
            'button_onchange_color_select_2_raw_value': button_onchange_color_select_2, 

        });

		var json_str = JSON.stringify(hiddenArray); 
		$('#'+whereTochange+'_hidden').val(json_str);



		// $('#'+whereTochange+'_hidden').val();
	});	

	// BUTTON ON CHANGE COLOR CODE 

    $('#button_text_color').on('change', function() {

		var buttons_color_select_colorName = this.value;
		var buttons_color_select_json = JSON.parse(colorArray);
		var buttons_color_select_code = buttons_color_select_json[buttons_color_select_colorName];

		// WHERE TO CHANGE COLOR
		var whereTochange =$('#hiddenButtonValueSpan').val();
		var whereTochangeName =$('#hiddenButtonValue').val();
		$('#'+whereTochange).css({"color": buttons_color_select_code+'!important'});



		var buttons_color_select = $('#buttons_color_select').val(); 
		var buttons_color_select1 = JSON.parse(colorArray);
		var buttons_color_select_code1 = buttons_color_select1[buttons_color_select]; // color select code


		var button_text_color = buttons_color_select_code // text color code

		var button_onchange_color_select = $('#button_onchange_color_select').val();
		var button_onchange_color_select1 = JSON.parse(colorArray);
		var button_onchange_color_select_code1 = button_onchange_color_select1[button_onchange_color_select]; // fourth code

		var button_hoover_color = $('#button_hoover_select').val();
		var button_hoover_color1 = JSON.parse(colorArray);
		var button_hoover_color_code1 = button_hoover_color1[button_hoover_color]; // third code

		var button_onchange_color_select_2 = $('#button_onchange_color_select_2').val();
		var button_onchange_color_select_21 = JSON.parse(colorArray);
		var button_onchange_color_select_code21 = button_onchange_color_select_21[button_onchange_color_select_2]; // fifth code



		var hiddenArray = [];
		hiddenArray.push({
            'button_color': buttons_color_select_code1, 
            'button_color_raw_value': buttons_color_select, 
            'button_text_color': button_text_color, 
            'button_text_color_raw_value': buttons_color_select_colorName, 
            'button_hoover_color': button_hoover_color_code1, 
            'button_hoover_color_raw_value': button_hoover_color, 
            'button_onchange_color_select': button_onchange_color_select_code1, 
            'button_onchange_color_select_raw_value': button_onchange_color_select, 
            'button_onchange_color_select_2': button_onchange_color_select_code21, 
            'button_onchange_color_select_2_raw_value': button_onchange_color_select_2, 

        });
		var json_str = JSON.stringify(hiddenArray); 
		$('#'+whereTochangeName+'_hidden').val(json_str);
	});	

	// BUTTON ON CHANGE HOVER COLOR CODE 

    $('#button_hoover_select').on('change', function() {

		var buttons_color_select_colorName = this.value;
		
		// WHERE TO CHANGE COLOR
		var whereTochange =$('#hiddenButtonValueSpan').val();
		var whereTochangeName =$('#hiddenButtonValue').val();

		var buttons_color_select = $('#buttons_color_select').val(); 
		var buttons_color_select1 = JSON.parse(colorArray);
		var buttons_color_select_code1 = buttons_color_select1[buttons_color_select]; // color select code

		var button_text_color = $('#button_text_color').val(); 
		var button_text_color1 = JSON.parse(colorArray);
		var button_text_color_code1 = button_text_color1[button_text_color]; // text color code

		var button_onchange_color_select = $('#button_onchange_color_select').val();
		var button_onchange_color_select1 = JSON.parse(colorArray);
		var button_onchange_color_select_code1 = button_onchange_color_select1[button_onchange_color_select]; // fourth code

		var button_hoover_color = $('#button_hoover_select').val();
		var button_hoover_color1 = JSON.parse(colorArray);
		var button_hoover_color_code1 = button_hoover_color1[button_hoover_color]; // third code

		var button_onchange_color_select_2 = $('#button_onchange_color_select_2').val();
		var button_onchange_color_select_21 = JSON.parse(colorArray);
		var button_onchange_color_select_code21 = button_onchange_color_select_21[button_onchange_color_select_2]; // fifth code

		var hiddenArray = [];
		hiddenArray.push({
            'button_color': buttons_color_select_code1, 
            'button_color_raw_value': buttons_color_select, 
            'button_text_color': button_text_color_code1, 
            'button_text_color_raw_value': button_text_color, 
            'button_hoover_color': button_hoover_color_code1, 
            'button_hoover_color_raw_value': button_hoover_color, 
            'button_onchange_color_select': button_onchange_color_select_code1, 
            'button_onchange_color_select_raw_value': button_onchange_color_select, 
            'button_onchange_color_select_2': button_onchange_color_select_code21, 
            'button_onchange_color_select_2_raw_value': button_onchange_color_select_2, 
        });
		var json_str = JSON.stringify(hiddenArray); 
		$('#'+whereTochangeName+'_hidden').val(json_str);

	});
	

	// COLOR ON CHANGE 1 

    $('#button_onchange_color_select').on('change', function() {

		var buttons_color_select_colorName = this.value;
		
		// WHERE TO CHANGE COLOR
		var whereTochange =$('#hiddenButtonValueSpan').val();
		var whereTochangeName =$('#hiddenButtonValue').val();

		var buttons_color_select = $('#buttons_color_select').val(); 
		var buttons_color_select1 = JSON.parse(colorArray);
		var buttons_color_select_code1 = buttons_color_select1[buttons_color_select]; // color select code

		var button_text_color = $('#button_text_color').val(); 
		var button_text_color1 = JSON.parse(colorArray);
		var button_text_color_code1 = button_text_color1[button_text_color]; // text color code

		var button_onchange_color_select = $('#button_onchange_color_select').val();
		var button_onchange_color_select1 = JSON.parse(colorArray);
		var button_onchange_color_select_code1 = button_onchange_color_select1[button_onchange_color_select]; // fourth code

		var button_hoover_color = $('#button_hoover_select').val();
		var button_hoover_color1 = JSON.parse(colorArray);
		var button_hoover_color_code1 = button_hoover_color1[button_hoover_color]; // third code

		var button_onchange_color_select_2 = $('#button_onchange_color_select_2').val();
		var button_onchange_color_select_21 = JSON.parse(colorArray);
		var button_onchange_color_select_code21 = button_onchange_color_select_21[button_onchange_color_select_2]; // fifth code

		var hiddenArray = [];
		hiddenArray.push({
            'button_color': buttons_color_select_code1, 
            'button_color_raw_value': buttons_color_select, 
            'button_text_color': button_text_color_code1, 
            'button_text_color_raw_value': button_text_color, 
            'button_hoover_color': button_hoover_color_code1, 
            'button_hoover_color_raw_value': button_hoover_color, 
            'button_onchange_color_select': button_onchange_color_select_code1, 
            'button_onchange_color_select_raw_value': button_onchange_color_select, 
            'button_onchange_color_select_2': button_onchange_color_select_code21, 
            'button_onchange_color_select_2_raw_value': button_onchange_color_select_2, 
        });
		var json_str = JSON.stringify(hiddenArray); 
		$('#'+whereTochangeName+'_hidden').val(json_str);

	});

	// COLOR ON CHANGE 2 

    $('#button_onchange_color_select_2').on('change', function() {

		var buttons_color_select_colorName = this.value;
		
		// WHERE TO CHANGE COLOR
		var whereTochange =$('#hiddenButtonValueSpan').val();
		var whereTochangeName =$('#hiddenButtonValue').val();

		var buttons_color_select = $('#buttons_color_select').val(); 
		var buttons_color_select1 = JSON.parse(colorArray);
		var buttons_color_select_code1 = buttons_color_select1[buttons_color_select]; // color select code

		var button_text_color = $('#button_text_color').val(); 
		var button_text_color1 = JSON.parse(colorArray);
		var button_text_color_code1 = button_text_color1[button_text_color]; // text color code

		var button_onchange_color_select = $('#button_onchange_color_select').val();
		var button_onchange_color_select1 = JSON.parse(colorArray);
		var button_onchange_color_select_code1 = button_onchange_color_select1[button_onchange_color_select]; // fourth code

		var button_hoover_color = $('#button_hoover_select').val();
		var button_hoover_color1 = JSON.parse(colorArray);
		var button_hoover_color_code1 = button_hoover_color1[button_hoover_color]; // third code

		var button_onchange_color_select_2 = $('#button_onchange_color_select_2').val();
		var button_onchange_color_select_21 = JSON.parse(colorArray);
		var button_onchange_color_select_code21 = button_onchange_color_select_21[button_onchange_color_select_2]; // fifth code

		var hiddenArray = [];
		hiddenArray.push({
            'button_color': buttons_color_select_code1, 
            'button_color_raw_value': buttons_color_select, 
            'button_text_color': button_text_color_code1, 
            'button_text_color_raw_value': button_text_color, 
            'button_hoover_color': button_hoover_color_code1, 
            'button_hoover_color_raw_value': button_hoover_color, 
            'button_onchange_color_select': button_onchange_color_select_code1, 
            'button_onchange_color_select_raw_value': button_onchange_color_select, 
            'button_onchange_color_select_2': button_onchange_color_select_code21, 
            'button_onchange_color_select_2_raw_value': button_onchange_color_select_2, 
        });
		var json_str = JSON.stringify(hiddenArray); 
		$('#'+whereTochangeName+'_hidden').val(json_str);

	});


    $('#testcolorchangeevent').on('keyup', function() {

   		var color1interval = setInterval(color1setFunction,1000);
   		var color2interval = setInterval(color2setFunction,2000);

	});

});


function onclickActions(id, number)
{
	var commonlayout = <?= json_encode($commonlayout)?>;
	var button1JsonData = commonlayout[number];
   	removeButtonColor(number);
	$('#hiddenButtonValue').val(id);
	$('#hiddenButtonValueNumeric').val(number);
	$('#hiddenButtonValueSpan').val(id+'span');
	$('#buttonsetheader1').css({"display": ''});


	// show flash color dropdown when button is update 

	if(number == '3')
	{

		$('.hidetrforbuttons').css('display','');
	}
	else
	{
		$('.hidetrforbuttons').css('display','none');

	}

	getdefault();
	if(button1JsonData[0].button_color)
	{
		$('#'+id).css({"background-color": button1JsonData[0].button_color});
		$('#'+id+'span').css({"color": button1JsonData[0].button_text_color});
		$('#buttons_color_select').val(button1JsonData[0].button_color_raw_value);
		$('#buttons_color_select_circle').css({"color": button1JsonData[0].button_color});
		$('#button_hoover_select_circle').css({"color": button1JsonData[0].button_hoover_color});
		$('#button_text_color_circle').css({"color": button1JsonData[0].button_text_color});
		$('#button_onchange_color_select_circle').css({"color": button1JsonData[0].button_onchange_color_select});
		$('#button_onchange_color_select_circle_2').css({"color": button1JsonData[0].button_onchange_color_select_2});
		$('#button_hoover_select').val(button1JsonData[0].button_hoover_color_raw_value);
		$('#button_onchange_color_select').val(button1JsonData[0].button_onchange_color_select_raw_value);
		$('#button_onchange_color_select_2').val(button1JsonData[0].button_onchange_color_select_2_raw_value);
		$('#button_text_color').val(button1JsonData[0].button_text_color_raw_value);
	}

}

function color1setFunction()
{
	var whereTochangeName = $('#hiddenButtonValue').val();
	var whereTochangeNumeric = $('#hiddenButtonValueNumeric').val();
	var commonlayout = <?= json_encode($commonlayout)?>;
	var button1JsonData = commonlayout[whereTochangeNumeric];

	$('#'+whereTochangeName).css({"background-color": button1JsonData[0].button_onchange_color_select});
}
function color2setFunction()
{

	var whereTochangeName = $('#hiddenButtonValue').val();
	var whereTochangeNumeric = $('#hiddenButtonValueNumeric').val();
	var commonlayout = <?= json_encode($commonlayout)?>;
	var button1JsonData = commonlayout[whereTochangeNumeric];
	$('#'+whereTochangeName).css({"background-color": button1JsonData[0].button_onchange_color_select_2});
}

function getdefault()
{
   	$('#buttons_color_select').val('select');
	$('#button_hoover_select').val('select');
	$('#button_onchange_color_select').val('select');
	$('#button_text_color').val('select');
	$('#button_onchange_color_select_2').val('select');


}
function getButtonConfig(val)
{
	// set value to input field for further operations
	$('#hiddenButtonValue').val(val);
	// show config for button
}

function getHooverColor(value)
{
	var whereTochangeName = $('#hiddenButtonValue').val();
	var whereTochangeNumeric = $('#hiddenButtonValueNumeric').val();

	if(value == whereTochangeName )
	{
		var buttons_color_select_colorName = $('#button_hoover_select').val();
		var buttons_color_select_json = JSON.parse(colorArray);
		var buttons_color_select_code = buttons_color_select_json[buttons_color_select_colorName];

		var commonlayout = <?= json_encode($commonlayout)?>;
		var button1JsonData = commonlayout[whereTochangeNumeric];

   		if(button1JsonData[0].button_color)
   		{
			$('#'+whereTochangeName).css({"background-color": button1JsonData[0].button_hoover_color,"border-color": button1JsonData[0].button_hoover_color});
   		}
   		else
   		{
			$('#'+whereTochangeName).css({"background-color": buttons_color_select_code,"border-color": buttons_color_select_code});
   		}
	}
}


function removeHooverColor(value)
{
	var whereTochangeName = $('#hiddenButtonValue').val();
	var whereTochangeNumeric = $('#hiddenButtonValueNumeric').val();

	if(value == whereTochangeName )
	{
		var buttons_color_select_colorName = $('#buttons_color_select').val();
		var buttons_color_select_json = JSON.parse(colorArray);
		var buttons_color_select_code = buttons_color_select_json[buttons_color_select_colorName];


		var commonlayout = <?= json_encode($commonlayout)?>;
		var button1JsonData = commonlayout[whereTochangeNumeric];

   		if(button1JsonData[0].button_color)
   		{
			$('#'+whereTochangeName).css({"background-color": button1JsonData[0].button_color,"border-color": button1JsonData[0].button_color});
   		}
   		else
   		{
			$('#'+whereTochangeName).css({"background-color": buttons_color_select_code,"border-color": buttons_color_select_code});	
   		}
	}

}

/*======================================================BUTONS TAB CONFIG AND SETTINGS END ====================================================*/


function removeButtonColor(value1)
{
	var numberVal = value1;
	var lowEnd = '1';
	var highEnd = '40';
	var list = [];
	for (var i = lowEnd; i <= highEnd; i++) {

		if(i != numberVal)
		{
			var idValue = '#buttonLayout'+i ;
			var idValueSpan = '#buttonLayout'+i+'span';
			$(idValue).removeAttr("style");
		   	$(idValueSpan).removeAttr("style");
		}
	}
}

	</script>
