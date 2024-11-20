<div style="position:absolute; left:24px; top:57px; right:70%; bottom:0; background:#fff;">
	<div id="leftTable" style="left:10px; top:45px; right:10px; bottom:15px; background:#fff; overflow-Y:auto; padding:0; display:xnone; overflow-X:hidden">
		<table class="basicTable inputs" border="0">
			<thead data-toggle="collapse" data-target="#admindashboardheader1">
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
			<tbody class="collapse" id="admindashboardheader1">
				<tr>
					<th style="vertical-align:top">Customer </th>
					<td> 

						<select id="colorSelect1" name="admin_dashboard[colorSelect1]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($admin_dashboard_array['colorSelect1'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="circle1" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>
				<tr>
					<th style="vertical-align:top">Users</th>
					<td> 
						<select id="colorSelect2" name="admin_dashboard[colorSelect2]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($admin_dashboard_array['colorSelect2'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="circle2" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>
				<tr>
					<th style="vertical-align:top">Platform Settings</th>
					<td> 
						<select id="colorSelect3" name="admin_dashboard[colorSelect3]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($admin_dashboard_array['colorSelect3'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="circle3" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>
				<tr>
					<th style="vertical-align:top">Company Settings</th>
					<td> 
						<select id="colorSelect4" name="admin_dashboard[colorSelect4]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($admin_dashboard_array['colorSelect4'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="circle4" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>
				<tr>
					<th style="vertical-align:top">Software Models</th>
					<td> 
						<select id="colorSelect5" name="admin_dashboard[colorSelect5]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($admin_dashboard_array['colorSelect5'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="circle5" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>
				<tr>
					<th style="vertical-align:top">Supporting Files</th>
					<td> 
						<select id="colorSelect6" name="admin_dashboard[colorSelect6]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($admin_dashboard_array['colorSelect6'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="circle6" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>		
				<tr>
					<th style="vertical-align:top">Support Desk</th>
					<td> 
						<select id="colorSelect7" name="admin_dashboard[colorSelect7]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($admin_dashboard_array['colorSelect7'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="circle7" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>
				<tr>
					<th style="vertical-align:top">Log Data</th>
					<td> 
						<select id="colorSelect8" name="admin_dashboard[colorSelec8]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($admin_dashboard_array['colorSelec8'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="circle8" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>									
				<tr>
					<th style="vertical-align:top">Legal Conditions</th>
					<td> 
						<select id="colorSelect9" name="admin_dashboard[colorSelect9]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($admin_dashboard_array['colorSelect9'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="circle9" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>						
					
			</tbody>	
			<!-- <thead>
				<tr>
					<th colspan="2">
						<i class="fa fa-arrow-circle-down"></i>&nbsp; Correspond Layout From Parent Tabs 
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th style="vertical-align:top">Inner Tabs </th>
					<td> 

						<select id="admin_dashboard_inner_tab_choice" name="admin_dashboard[admin_dashboard_inner_tab_choice]" style="width:71%">
							<?php foreach ($select_yesno_array as $keyChoice => $valueChoice){ ?>
								<option <?php if($admin_dashboard_array['admin_dashboard_inner_tab_choice'] == $keyChoice) { echo "selected";}?> value="<?php echo $keyChoice;?>"><?php echo $valueChoice?></option><?php } ?>
						</select>	
					</td>
				</tr>	
			</tbody> -->
			<thead data-toggle="collapse" data-target="#admindashboardheader2">
				<tr>
					<th colspan="2">
						<i class="fa fa-arrow-circle-down"></i>&nbsp; Notification Box Colors
					</th>
				</tr>
			</thead>
			<tbody class="collapse" id="admindashboardheader2">
				<tr>
					<th style="vertical-align:top">Box Heading Background </th>
					<td> 

						<select id="colorSelect15" name="admin_dashboard[colorSelect15]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($admin_dashboard_array['colorSelect15'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="circle15" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>

				<tr>
					<th style="vertical-align:top">Box Heading Font Style </th>
					<td> 

						<select id="font_settings_box" name="admin_dashboard[font_settings_box]" style="width:71%">
								<option value="select">Select</option>
							<?php foreach ($font_data[0] as $keyFont => $valueFont){ ?>
								<option <?php if($admin_dashboard_array['font_settings_box'] == $keyFont) { echo "selected";}?> value="<?php echo $keyFont;?>"><?php echo $valueFont?></option><?php } ?>
						</select>	
					</td>
				</tr>
				<tr>
					<th style="vertical-align:top">Box Content Font Style </th>
					<td> 

						<select id="font_settings_box_content" name="admin_dashboard[font_settings_box_content]" style="width:71%">
								<option value="select">Select</option>
							<?php foreach ($font_data[0] as $keyFont => $valueFont){ ?>
								<option <?php if($admin_dashboard_array['font_settings_box_content'] == $keyFont) { echo "selected";}?> value="<?php echo $keyFont;?>"><?php echo $valueFont?></option><?php } ?>
						</select>	
					</td>
				</tr>

			</tbody>	
			<thead data-toggle="collapse" data-target="#admindashboardheader3">
				<tr>
					<th colspan="2">
						<i class="fa fa-arrow-circle-down"></i>&nbsp; Page Settings
					</th>
				</tr>
			</thead>
			<tbody class="collapse" id="admindashboardheader3">
				<tr>
					<th style="vertical-align:top">Page Background Color</th>
					<td> 

						<select id="colorSelect16" name="admin_dashboard[colorSelect16]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($admin_dashboard_array['colorSelect16'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="circle16" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>


					</td>
				</tr>													
				<tr>
					<th style="vertical-align:top">Page Background Image</th>
					<td> 

						<select id="background_image_selection" name="admin_dashboard[background_image_selection]" style="width:71%">
							<?php foreach ($image_select_type as $keyImage => $valueImage){ ?>
								<option  <?php if($admin_dashboard_array['background_image_selection'] == $keyImage) { echo "selected";} ?> value="<?php echo $keyImage;?>"><?php echo $valueImage?></option><?php } ?>
						</select>	
						<br>
						<input style="visibility:hidden; height:0; float:left" type="file" name="uploadimages_admin_bg" id="uploadimages_admin_bg" class="uploadimages_admin_bg" />
				
						<button id="selectimagebutton"  onclick="$('#uploadimages_admin_bg').click()" class="btn btn-outline-secondary btn-xs" style="display: none;margin-top:10px;margin-bottom: 10px;margin-left: 10px!important; padding:0px 8px; display:inline-block;margin-left: 10px;" type="button"><?=$lng['Select file']?></button>
						<input type="hidden" name="admin_dashboard_image_link" value="<?php echo $admin_dashboard_array['image_link'];?>">
						<br>

						<img id="background_image_preview" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $admin_dashboard_array['image_link']?>" style="height: 30px;margin-left: 10px;">
						<textarea style= "font-size: 10px!important;" readonly="readonly">Your background graphic must be a PNG, JPEG or JPG and of 1920 px by 836 px</textarea>
						<textarea id="background_image_name_preview" readonly="readonly"><?php echo $admin_dashboard_array['image_link']; ?></textarea>

					</td>
				</tr>
				<tr>
					<th style="vertical-align:top">Dashboard Font Style </th>
					<td> 

						<select id="font_settings" name="admin_dashboard[font_settings]" style="width:71%">
								<option value="select">Select</option>
							<?php foreach ($font_data[0] as $keyFont => $valueFont){ ?>
								<option <?php if($admin_dashboard_array['font_settings'] == $keyFont) { echo "selected";}?> value="<?php echo $keyFont;?>"><?php echo $valueFont?></option><?php } ?>
						</select>	
					</td>
				</tr>									

				<tr>
					<th style="vertical-align:top">Font Color </th>
					<td> 

						<select id="fontColor" name="admin_dashboard[fontColor]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($admin_dashboard_array['fontColor'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="fontColorcircle" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>


					</td>
				</tr>
			</tbody>
			<thead data-toggle="collapse" data-target="#admindashboardheader4">
				<tr>
					<th colspan="2">
						<i class="fa fa-arrow-circle-down"></i>&nbsp; <?=$lng['Main Header Settings']?>
					</th>
				</tr>
			</thead>
			<tbody class="collapse" id="admindashboardheader4">
				<tr>
					<th style="vertical-align:top">Header Background Color </th>
					<td> 

						<select id="admin_dashboard_color1" name="admin_dashboard[admin_dashboard_color1]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($admin_dashboard_array['admin_dashboard_color1'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="admin_dashboard_circle1" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>					
				<tr>
					<th style="vertical-align:top">Header Home Button Color </th>
					<td> 

						<select id="admin_dashboard_color2" name="admin_dashboard[admin_dashboard_color2]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($admin_dashboard_array['admin_dashboard_color2'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="admin_dashboard_circle2" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>					
				<tr>
					<th style="vertical-align:top">Main Header Color 1</th>
					<td> 

						<select id="admin_dashboard_color3" name="admin_dashboard[admin_dashboard_color3]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($admin_dashboard_array['admin_dashboard_color3'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="admin_dashboard_circle3" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>					
				<tr>
					<th style="vertical-align:top">Main Header Color 2</th>
					<td> 

						<select id="admin_dashboard_color4" name="admin_dashboard[admin_dashboard_color4]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($admin_dashboard_array['admin_dashboard_color4'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="admin_dashboard_circle4" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>					
				<tr>
					<th style="vertical-align:top">Header Font Style</th>
					<td> 
						<select id="admin_dashboard_header_font" name="admin_dashboard[admin_dashboard_header_font]" style="width:71%">
							<option value="select">Select</option>
						<?php foreach ($font_data[0] as $keyFont => $valueFont){ ?>
							<option <?php if($admin_dashboard_array['admin_dashboard_header_font'] == $keyFont) { echo "selected";}?> value="<?php echo $keyFont;?>"><?php echo $valueFont?></option><?php } ?>
						</select>	
					</td>
				</tr>	
				<tr>
					<th style="vertical-align:top">Header Font Color</th>
					<td> 

						<select id="admin_dashboard_header_font_color" name="admin_dashboard[admin_dashboard_header_font_color]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($admin_dashboard_array['admin_dashboard_header_font_color'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="admin_dashboard_header_font_color_circle" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>					
				<tr>
					<th style="vertical-align:top">Main Header Font Style</th>
					<td> 
						<select id="admin_dashboard_main_header_font" name="admin_dashboard[admin_dashboard_main_header_font]" style="width:71%">
							<option value="select">Select</option>
						<?php foreach ($font_data[0] as $keyFont => $valueFont){ ?>
							<option <?php if($admin_dashboard_array['admin_dashboard_main_header_font'] == $keyFont) { echo "selected";}?> value="<?php echo $keyFont;?>"><?php echo $valueFont?></option><?php } ?>
						</select>	
					</td>
				</tr>	
				<tr>
					<th style="vertical-align:top">Main Header Font Color</th>
					<td> 

						<select id="admin_dashboard_main_header_font_color" name="admin_dashboard[admin_dashboard_main_header_font_color]" style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option <?php if($admin_dashboard_array['admin_dashboard_main_header_font_color'] == $keyColor) { echo "selected";}?> value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="admin_dashboard_main_header_font_color_circle" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>						
			</tbody>	
		</table>
		<div style="height:15px"></div>

	</div>
</div>


<!---- --->
<div style="position:absolute; left:30%; top:57px; right:0; bottom:0; background: #f6f6f6; border-left:1px solid #ddd">
			
	<div id="rightTable" style="position: absolute; left: 15px; top: 0px; right: 15px; bottom: 15px; background: url('../images/admin_uploads/<?php echo $admin_dashboard_array['image_link']?>'); background-repeat: no-repeat;background-size: 100% 100%;overflow-y: auto; padding: 15px 15px 100px; padding-top: 0px!important;">
<!-- 	<div id="rightTable" style="position: absolute; left: 15px; top: 0px; right: 15px; bottom: 15px; background: rgb(255, 255, 255); overflow-y: auto; padding: 15px 15px 100px; padding-top: 0px!important;"> -->

				<div class="header headergradientcolor" style="position: relative!important;">
				<table width="100%" border="0">
					<tbody>
						<tr>
							<td style="padding-left:15px; width:1px">
								<img style="margin:5px 7px 5px 0; height:40px;" src="../images/pkf_people.png?1643957797">
							</td>
							<td id="headermaintitle" style="white-space:nowrap; vertical-align:middle; padding-left:5px">
								<b style="font-family:'Roboto Condensed'; font-weight:400; font-size:24px; color:#333;"><span>Admin Platform</span></b>
							</td>
							<td style="width:95%"></td>
							<td>
								<a data-lng="th" class="langbutton admin_lang "><img src="../images/flag_th.png"></a>
							</td><td style="padding:0 10px">
								<button type="button" class="alogout btn btn-logout"><i class="fa fa-power-off"></i></button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="topnav-custom navbarbackgroundcolor" style="position: relative!important;top: 0px!important;">
		
				<div class="btn-group ">
					<a id= "homeButton" style="background-color: #080;" href="#" class="home"><i class="fa fa-home"></i></a>
				</div>
				
				<div class="btn-group navbarbackgroundcolor" style="float:right; background:#000 !important">
					<button data-toggle="dropdown" style="padding:0 10px 0 0" id="regoadminheaderbutton">
						 <img style="height:36px; width:36px; display:inline-block; border-radius:0px; margin:-4px 10px 0 10px; border:0px solid #666" src="https://regodemo.com/images/xrayadmin.jpg?1643950464?1643958234"><b><span id="regoadminamespan">REGO Admin</span></b>&nbsp; <span class="caret"></span>
					</button>
				</div>
				
				<div class="btn-group navbarbackgroundcolor" style="float:right; background:#000 !important"><a id="admin_dashboard_header_font_style" style="font-size:16px; color:#fd0"><b>38</b> Employees in <b>3</b> Companies</a>
				</div>

				<div class="btn-group" style="float:right; display:none">
					<button data-toggle="dropdown" >
						<i class="fa fa-user"></i>&nbsp; Admin <span class="caret"></span>
					</button>
					<ul class="dropdown-menu xpull-right">
						<li><a href="#">Add new Client</a></li>
						<li><a href="#">Client list</a></li>
					</ul>
				</div>
				
			</div>	


		<div class="dash-left">
			<div class="dashbox green">
				<div style="height: 90px!important;" class="inner div1">
					<i style="font-size: 55px!important;" class="fa fa-users"></i>
					<div class="parent" style="height: 35px;">
						<div class="child">
							<p style="font-size: 16px"><span><?=$lng['Customers']?></span></p>
						</div>
					</div>
				</div>
			</div>

			<div class="dashbox orange">
				<div style="height: 90px!important;" class="inner div2" >
					<i style="font-size: 30px!important;" class="fa fa-user"></i>
					<div style="height: 55px;" class="parent">
						<div class="child">
							<p style="font-size: 16px"><span><?=$lng['Users']?></span></p>
						</div>
					</div>
				</div>
			</div>
			<div class="dashbox orange">
				<div style="height: 90px!important;" class="inner div3" >
					<i style="font-size: 30px!important;" class="fa fa-cogs"></i>
					<div style="height: 55px;" class="parent">
						<div class="child">
							<p style="font-size: 16px"><span><?=$lng['Platform Settings']?></span></p>
						</div>
					</div>
				</div>
			</div>

			<div class="dashbox dblue">
				<div style="height: 90px!important;" class="inner div4" > 
				<i style="font-size: 30px!important;" class="fa fa-cogs"></i>
					<div style="height: 55px;" class="parent">
						<div class="child">
							<p style="font-size: 16px"><span><?=$lng['Company settings']?></span></p>
						</div>
					</div>
				</div>
			</div>
			<div class="dashbox purple">
				<div style="height: 90px!important;" class="inner div5" >
				<i style="font-size: 30px!important;" class="fa fa-money"></i>
					<div style="height: 55px;" class="parent">
						<div class="child">
							<p style="font-size: 16px"><span><?=$lng['Software Models']?></span></p>
						</div>
					</div>
				</div>
			</div>
			<div class="dashbox reds">
				<div style="height: 90px!important;"  class="inner div6" >
				<i style="font-size: 30px!important;" class="fa fa-question-circle-o"></i>
					<div style="height: 55px;" class="parent">
						<div class="child">
							<p style="font-size: 16px"><span><?=$lng['Supporting Files']?></span></p>
						</div>
					</div>
				</div>
			</div>

			<div class="dashbox brown">
				<div style="height: 90px!important;" class="inner div7" >
				<i style="font-size: 30px!important;" class="fa fa-life-ring"></i>
					<div style="height: 55px;" class="parent">
						<div class="child">
							<p style="font-size: 16px"><span><?=$lng['Support desk']?></span></p>
						</div>
					</div>
				</div>
			</div>
			<div class="dashbox brown">
				<div style="height: 90px!important;"  class="inner div8" >
				<i style="font-size: 30px!important;" class="fa fa-database"></i>
					<div style="height: 55px;" class="parent">
						<div class="child">
						<p style="font-size: 16px"><span><?=$lng['Log data']?></span></p>
						</div>
					</div>
				</div>
			</div>

			<div class="dashbox brown">
				<div style="height: 90px!important;"  class="inner div9" >
				<i style="font-size: 30px!important;" class="fa fa-file-text-o"></i>
					<div style="height: 55px;" class="parent">
						<div class="child">
							<p style="font-size: 16px"><span><?=$lng['Legal Conditions']?></span></p>
						</div>
					</div>
				</div>
			</div>

		</div>

		<div class="dash-right">

			<div class="h2customcalss">
				<h2 class="div15" ><i class="fa fa-bell"></i>&nbsp; <span><?=$lng['Notification box']?> </span></h2>
				<div class="inner boxcontent">
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