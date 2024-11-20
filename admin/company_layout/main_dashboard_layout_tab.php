<div style="position:absolute; left:24px; top:57px; right:70%; bottom:0; background:#fff;">
	<div id="leftTable" style="left:10px; top:45px; right:10px; bottom:15px; background:#fff; overflow-Y:auto; padding:0; display:xnone; overflow-X:hidden">
		<table class="basicTable inputs" border="0">
			<thead data-toggle="collapse" data-target="#maindashboardheader1">
				<tr>
					<td colspan="2" style="text-align: center;vertical-align: middle; font-size: 12px;padding-top: 8px!important;"> 
						<p>Note: The choices will be applied to all inner tabs.</p>									
					</td>
				</tr>	
				<tr >
					<th colspan="2">
						<i class="fa fa-arrow-circle-down"></i>&nbsp; <?=$lng['Main Dashboard Tab Colors']?>
					</th>
				</tr>
			</thead>
			<tbody class="collapse" id="maindashboardheader1">
				<tr>
					<th style="vertical-align:top">Employee Module </th>
					<td> 

						<select id="maincolorSelect1" name="main_dashboard[maincolorSelect1]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($main_dashboard_array['maincolorSelect1'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="maincircle1" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>
				<tr>
					<th style="vertical-align:top">Leave Module</th>
					<td> 
						<select id="maincolorSelect2" name="main_dashboard[maincolorSelect2]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($main_dashboard_array['maincolorSelect2'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="maincircle2" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>
				<tr>
					<th style="vertical-align:top">Time Module</th>
					<td> 
						<select id="maincolorSelect3" name="main_dashboard[maincolorSelect3]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($main_dashboard_array['maincolorSelect3'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="maincircle3" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>
				<tr>
					<th style="vertical-align:top">Payroll Module</th>
					<td> 
						<select id="maincolorSelect4" name="main_dashboard[maincolorSelect4]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($main_dashboard_array['maincolorSelect4'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="maincircle4" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>
				<tr>
					<th style="vertical-align:top">Benefits & Expences </th>
					<td> 
						<select id="maincolorSelect5" name="main_dashboard[maincolorSelect5]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($main_dashboard_array['maincolorSelect5'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="maincircle5" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>
				<tr>
					<th style="vertical-align:top">Communication Center</th>
					<td> 
						<select id="maincolorSelect6" name="main_dashboard[maincolorSelect6]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($main_dashboard_array['maincolorSelect6'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="maincircle6" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>		
				<tr>
					<th style="vertical-align:top">Support Desk</th>
					<td> 
						<select id="maincolorSelect7" name="main_dashboard[maincolorSelect7]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($main_dashboard_array['maincolorSelect7'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="maincircle7" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>
				<tr>
					<th style="vertical-align:top">Terms & Conditions</th>
					<td> 
						<select id="maincolorSelect8" name="main_dashboard[maincolorSelect8]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($main_dashboard_array['maincolorSelect8'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="maincircle8" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>									
				<tr>
					<th style="vertical-align:top">Privacy Policy</th>
					<td> 
						<select id="maincolorSelect9" name="main_dashboard[maincolorSelect9]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($main_dashboard_array['maincolorSelect9'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="maincircle9" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>				

				<tr>
					<th style="vertical-align:top">Setting</th>
					<td> 
						<select id="maincolorSelect10" name="main_dashboard[maincolorSelect10]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($main_dashboard_array['maincolorSelect10'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="maincircle10" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>						
					
			</tbody>	
			<thead data-toggle="collapse" data-target="#maindashboardheader2">
				<tr>
					<th colspan="2">
						<i class="fa fa-arrow-circle-down"></i>&nbsp; Notification Box Colors
					</th>
				</tr>
			</thead>
			<tbody class="collapse" id="maindashboardheader2">
				<tr>
					<th style="vertical-align:top">Box Heading Background </th>
					<td> 

						<select id="maincolorSelect15" name="main_dashboard[maincolorSelect15]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($main_dashboard_array['maincolorSelect15'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="maincircle15" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>

				<tr>
					<th style="vertical-align:top">Box Heading Font Style </th>
					<td> 

						<select id="main_font_settings_box" name="main_dashboard[main_font_settings_box]" style="width:71%">
								<option value="select">Select</option>
							<?php foreach ($font_data[0] as $keyFont => $valueFont){ ?>
								<option <?php if($main_dashboard_array['main_font_settings_box'] == $keyFont) { echo "selected";}?> value="<?php echo $keyFont;?>"><?php echo $valueFont?></option><?php } ?>
						</select>	
					</td>
				</tr>
				<tr>
					<th style="vertical-align:top">Box Content Font Style </th>
					<td> 

						<select id="main_font_settings_box_content" name="main_dashboard[main_font_settings_box_content]" style="width:71%">
								<option value="select">Select</option>
							<?php foreach ($font_data[0] as $keyFont => $valueFont){ ?>
								<option <?php if($main_dashboard_array['main_font_settings_box_content'] == $keyFont) { echo "selected";}?> value="<?php echo $keyFont;?>"><?php echo $valueFont?></option><?php } ?>
						</select>	
					</td>
				</tr>

			</tbody>	
			<thead data-toggle="collapse" data-target="#maindashboardheader3">
				<tr>
					<th colspan="2">
						<i class="fa fa-arrow-circle-down"></i>&nbsp; Page Settings
					</th>
				</tr>
			</thead>
			<tbody class="collapse" id="maindashboardheader3">
				<tr>
					<th style="vertical-align:top">Page Background Color</th>
					<td> 

						<select id="maincolorSelect16" name="main_dashboard[maincolorSelect16]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($main_dashboard_array['maincolorSelect16'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="maincircle16" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>


					</td>
				</tr>													
				<tr>
					<th style="vertical-align:top">Page Background Image</th>
					<td> 

						<select id="main_background_image_selection" name="main_dashboard[main_background_image_selection]" style="width:71%">
							<?php foreach ($image_select_type as $keyImage => $valueImage){ ?>
								<option  <?php if($main_dashboard_array['main_background_image_selection'] == $keyImage) { echo "selected";} ?> value="<?php echo $keyImage;?>"><?php echo $valueImage?></option><?php } ?>
						</select>	
						<br>
						<input style="visibility:hidden; height:0; float:left" type="file" name="uploadimages_main_bg" id="uploadimages_main_bg" class="uploadimages_admin_bg" />
				
						<button id="mainselectimagebutton"  onclick="$('#uploadimages_main_bg').click()" class="btn btn-outline-secondary btn-xs" style="display: none;margin-top:10px;margin-bottom: 10px;margin-left: 10px!important; padding:0px 8px; display:inline-block;margin-left: 10px;" type="button"><?=$lng['Select file']?></button>
						<input type="hidden" name="main_dashboard_image_link" value="<?php echo $main_dashboard_array['image_link'];?>">
						<br>

						<img id="main_background_image_preview" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $main_dashboard_array['image_link']?>" style="height: 30px;margin-left: 10px;">
						<textarea style= "font-size: 10px!important;" readonly="readonly">Your background graphic must be a PNG, JPEG or JPG and of 1920 px by 836 px</textarea>
						<textarea id="main_background_image_name_preview" readonly="readonly"><?php echo $main_dashboard_array['image_link']; ?></textarea>

					</td>
				</tr>
				<tr>
					<th style="vertical-align:top">Dashboard Font Style </th>
					<td> 

						<select id="main_font_settings" name="main_dashboard[main_font_settings]" style="width:71%">
								<option value="select">Select</option>
							<?php foreach ($font_data[0] as $keyFont => $valueFont){ ?>
								<option <?php if($main_dashboard_array['main_font_settings'] == $keyFont) { echo "selected";}?> value="<?php echo $keyFont;?>"><?php echo $valueFont?></option><?php } ?>
						</select>	
					</td>
				</tr>									

				<tr>
					<th style="vertical-align:top">Font Color </th>
					<td> 

						<select id="mainfontColor" name="main_dashboard[mainfontColor]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($main_dashboard_array['mainfontColor'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="mainfontColorcircle" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>


					</td>
				</tr>
			</tbody>
			<thead data-toggle="collapse" data-target="#maindashboardheader4">
				<tr>
					<th colspan="2">
						<i class="fa fa-arrow-circle-down"></i>&nbsp; <?=$lng['Main Header Settings']?>
					</th>
				</tr>
			</thead>
			<tbody class="collapse" id="maindashboardheader4">
				<tr>
					<th style="vertical-align:top">Header Background Color </th>
					<td> 

						<select id="main_dashboard_color1" name="main_dashboard[main_dashboard_color1]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($main_dashboard_array['main_dashboard_color1'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="main_dashboard_circle1" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>					
				<tr>
					<th style="vertical-align:top">Header Home Button Color </th>
					<td> 

						<select id="main_dashboard_color2" name="main_dashboard[main_dashboard_color2]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($main_dashboard_array['main_dashboard_color2'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="main_dashboard_circle2" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>					
				<tr>
					<th style="vertical-align:top">Main Header Color 1</th>
					<td> 

						<select id="main_dashboard_color3" name="main_dashboard[main_dashboard_color3]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($main_dashboard_array['main_dashboard_color3'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="main_dashboard_circle3" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>					
				<tr>
					<th style="vertical-align:top">Main Header Color 2</th>
					<td> 

						<select id="main_dashboard_color4" name="main_dashboard[main_dashboard_color4]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($main_dashboard_array['main_dashboard_color4'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="main_dashboard_circle4" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>					
				<tr>
					<th style="vertical-align:top">Header Font Style</th>
					<td> 
						<select id="main_dashboard_header_font" name="main_dashboard[main_dashboard_header_font]" style="width:71%">
							<option value="select">Select</option>
						<?php foreach ($font_data[0] as $keyFont => $valueFont){ ?>
							<option <?php if($main_dashboard_array['main_dashboard_header_font'] == $keyFont) { echo "selected";}?> value="<?php echo $keyFont;?>"><?php echo $valueFont?></option><?php } ?>
						</select>	
					</td>
				</tr>	
				<tr>
					<th style="vertical-align:top">Header Font Color</th>
					<td> 

						<select id="main_dashboard_header_font_color" name="main_dashboard[main_dashboard_header_font_color]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($main_dashboard_array['main_dashboard_header_font_color'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="main_dashboard_header_font_color_circle" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>					
				<tr>
					<th style="vertical-align:top">Main Header Font Style</th>
					<td> 
						<select id="main_dashboard_main_header_font" name="main_dashboard[main_dashboard_main_header_font]" style="width:71%">
							<option value="select">Select</option>
						<?php foreach ($font_data[0] as $keyFont => $valueFont){ ?>
							<option <?php if($main_dashboard_array['main_dashboard_main_header_font'] == $keyFont) { echo "selected";}?> value="<?php echo $keyFont;?>"><?php echo $valueFont?></option><?php } ?>
						</select>	
					</td>
				</tr>	
				<tr>
					<th style="vertical-align:top">Main Header Font Color</th>
					<td> 

						<select id="main_dashboard_main_header_font_color" name="main_dashboard[main_dashboard_main_header_font_color]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($main_dashboard_array['main_dashboard_main_header_font_color'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="main_dashboard_main_header_font_color_circle" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>						
			</tbody>	
		</table>
		<div style="height:15px"></div>

	</div>
</div>


<!---- --->
<div style="position:absolute; left:30%; top:57px; right:0; bottom:0; background: #f6f6f6; border-left:1px solid #ddd">
			
	<div id="mainrightTable" style="position: absolute; left: 15px; top: 0px; right: 15px; bottom: 15px; background: url('../images/admin_uploads/<?php echo $main_dashboard_array['image_link']?>'); background-repeat: no-repeat;background-size: 100% 100%;overflow-y: auto; padding: 15px 15px 100px; padding-top: 0px!important;">
<!-- 	<div id="rightTable" style="position: absolute; left: 15px; top: 0px; right: 15px; bottom: 15px; background: rgb(255, 255, 255); overflow-y: auto; padding: 15px 15px 100px; padding-top: 0px!important;"> -->

				<div class="header mainheadergradientcolor" style="position: relative!important;">
				<table width="100%" border="0">
					<tbody>
						<tr>
							<td style="padding-left:15px; width:1px">
								<img style="margin:5px 7px 5px 0; height:40px;" src="../images/pkf_people.png?1643957797">
							</td>
							<td class="header-client">
									<span  class="mainheadermaintitle" style="font-size: 15px!important;">Wartiz technologies&nbsp;-&nbsp;REGODEMO1000 </span>
							</td>
							<td style="width:90%; padding-left:20px"><button style="font-size: 11px;" onmouseover="$('.mnSumoSelect').addClass('open');" onmouseout="$('.mnSumoSelect').removeClass('open');" class="btn btn-outline-success btn-xs"><span class="mainheadermaintitle"> Selections </span></button></td>
							<td class="header-date">
								<span class="mainheadermaintitle" style="font-size: 15px!important;">Wednesday 9 February 2022 </span>				
							</td>				
							<td>
								<a data-lng="th" class="langbutton "><img src="https://regodemo.com/images/flag_th.png"></a>
							</td>
							<td style="padding:0 10px">
							</td>
						</tr>
					</tbody>
				</table>
			</div>


<div class="topnav-custom mainnavbarbackgroundcolor" style="position: relative!important;top: 0px!important;">
	<div class="btn-group" style="margin-bottom: 43px;"> 
		<a id="adminsigncustomerdashboard" href="admin/index.php?mn=2" class="nav-link">&nbsp;<i class="fa fa-font fa-lg"></i>&nbsp;</a>
	</div>
	<div class="btn-group active" style="margin-bottom: 43px;"> 
		<a id= "mainhomebutton" href="index.php?mn=2" class="home"><i class="fa fa-home"></i></a>
	</div>
	<div class="btn-group hide-xs" style="margin-bottom: 43px;margin-left: 15px;">
		<button class="dropdown-toggle" data-toggle="dropdown" style="padding:0 10px 0 10px">
		<b class="main_dashboard_header_font_style">All Division</b>
		</button>
	</div>	
	<div class="btn-group hide-xs" style="margin-bottom: 43px;">
		<button class="dropdown-toggle" data-toggle="dropdown" style="padding:0 10px 0 10px">
		<b class="main_dashboard_header_font_style">All Department</b>
		</button>
	</div>
	<div class="btn-group hide-xs" style="margin-bottom: 43px;">
		<button class="dropdown-toggle" data-toggle="dropdown" style="padding:0 10px 0 10px">
		<b class="main_dashboard_header_font_style">All Teams</b>
		</button>
	</div>



	<div class="btn-group hide-xs mainnavbarbackgroundcolor" style="float:right; background:#000 !important;margin-bottom: 43px;">
		<button class="dropdown-toggle regoadminmainheaderbutton" data-toggle="dropdown" style="padding:0 10px 0 0">
			<img style="height:35px; width:35px; display:inline-block; border-radius:0px; margin:-3px 10px 0 10px; border:0px solid #666" src="../../images/xrayadmin.jpg?1644392508?1644392519"><b class="main_dashboard_header_font_style">REGO Admin</b>
		</button>
	</div>

	<div class="btn-group" style="float:right;"> 
		<button class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-pencil-square-o"></i>&nbsp; <span class="main_dashboard_header_font_style">January 2022</span>				</button>
		<div class="dropdown-menu">
				<a class="dropdown-item selectMonth" data-id="1"><i class="fa fa-pencil-square-o"></i>&nbsp; January 2022</a>
		</div>
	</div>

	<div class="btn-group hide-xs " style="float:right">
		<a class="main_dashboard_header_font_style" href="index.php?mn=3">Welcome</a>
	</div>
</div>




		<div class="dash-left">
			<div class="dashbox green maindashbox">
				<div style="height: 90px!important;" class="inner maindiv1">
					<i style="font-size: 55px!important;" class="fa fa-users"></i>
					<div class="parent" style="height: 35px;">
						<div class="child">
							<p ><span style="font-size: 11px!important;" ><?=$lng['Employee Module']?></span></p>
						</div>
					</div>
				</div>
			</div>

			<div class="dashbox orange maindashbox">
				<div style="height: 90px!important;" class="inner maindiv2" >
					<i style="font-size: 30px!important;" class="fa fa-plane"></i>
					<div style="height: 55px;" class="parent">
						<div class="child">
							<p ><span style="font-size: 11px"><?=$lng['Leave module']?></span></p>
						</div>
					</div>
				</div>
			</div>
			<div class="dashbox orange maindashbox">
				<div style="height: 90px!important;" class="inner maindiv3" >
					<i style="font-size: 30px!important;" class="fa fa-clock-o"></i>
					<div style="height: 55px;" class="parent">
						<div class="child">
							<p ><span style="font-size: 11px"><?=$lng['Time module']?></span></p>
						</div>
					</div>
				</div>
			</div>

			<div class="dashbox dblue maindashbox">
				<div style="height: 90px!important;" class="inner maindiv4" > 
				<i style="font-size: 30px!important;" class="fa fa-money"></i>
					<div style="height: 55px;" class="parent">
						<div class="child">
							<p ><span style="font-size: 11px"><?=$lng['Payroll module']?></span></p>
						</div>
					</div>
				</div>
			</div>
			<div class="dashbox purple maindashbox">
				<div style="height: 90px!important;" class="inner maindiv5" >
				<i style="font-size: 30px!important;" class="fa fa-balance-scale"></i>
					<div style="height: 55px;" class="parent">
						<div class="child">
							<p ><span style="font-size: 11px"><?=$lng['Benefits & Expences']?></span></p>
						</div>
					</div>
				</div>
			</div>
			<div class="dashbox reds maindashbox">
				<div style="height: 90px!important;"  class="inner maindiv6" >
				<i style="font-size: 30px!important;" class="fa fa-comments"></i>
					<div style="height: 55px;" class="parent">
						<div class="child">
							<p ><span style="font-size: 11px"><?=$lng['Communication center']?></span></p>
						</div>
					</div>
				</div>
			</div>

			<div class="dashbox brown maindashbox">
				<div style="height: 90px!important;" class="inner maindiv7" >
				<i style="font-size: 30px!important;" class="fa fa-question-circle"></i>
					<div style="height: 55px;" class="parent">
						<div class="child">
							<p ><span style="font-size: 11px"><?=$lng['Support desk']?></span></p>
						</div>
					</div>
				</div>
			</div>
			<div class="dashbox brown maindashbox">
				<div style="height: 90px!important;"  class="inner maindiv8" >
				<i style="font-size: 30px!important;" class="fa fa-file-text-o"></i>
					<div style="height: 55px;" class="parent">
						<div class="child">
						<p ><span style="font-size: 11px"><?=$lng['Terms & Conditions']?></span></p>
						</div>
					</div>
				</div>
			</div>

			<div class="dashbox brown maindashbox">
				<div style="height: 90px!important;"  class="inner maindiv9" >
				<i style="font-size: 30px!important;" class="fa fa-file-text-o"></i>
					<div style="height: 55px;" class="parent">
						<div class="child">
							<p ><span style="font-size: 11px"><?=$lng['Privacy policy']?></span></p>
						</div>
					</div>
				</div>
			</div>			
			<div class="dashbox brown maindashbox">
				<div style="height: 90px!important;"  class="inner maindiv10" >
				<i style="font-size: 30px!important;" class="fa fa-cogs"></i>
					<div style="height: 55px;" class="parent">
						<div class="child">
							<p ><span style="font-size: 11px"><?=$lng['Settings']?></span></p>
						</div>
					</div>
				</div>
			</div>

		</div>

		<div class="dash-right">

			<div class="h2customcalssmain">
				<h2 class="maindiv15" ><i class="fa fa-bell"></i>&nbsp; <span><?=$lng['Warnings / Expiry dates']?> </span></h2>
				<div class="inner mainboxcontent">
					<?=$lng['New support tickets']?> : <br>
					<?=$lng['Open support tickets']?> : <br>
							<?=$lng['New support tickets']?> : <br>
					<?=$lng['Open support tickets']?> : <br>
							<?=$lng['New support tickets']?> : <br>
					<?=$lng['Open support tickets']?> : <br>
							<?=$lng['New support tickets']?> : <br>
					<?=$lng['Open support tickets']?> : <br>
					

				</div>
			</div>
	
		</div>
	
	</div>
	
</div>