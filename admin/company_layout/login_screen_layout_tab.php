					<div style="position:absolute; left:24px; top:57px; right:70%; bottom:0; background:#fff;">
						<div id="leftTable" style="left:10px; top:45px; right:10px; bottom:15px; background:#fff; overflow-Y:auto; padding:0; display:xnone; overflow-X:hidden">

							<table class="basicTable inputs" border="0">
								<thead data-toggle="collapse" data-target="#loginscreenheader1">
									<tr>
										<th colspan="2">
											<i class="fa fa-arrow-circle-down"></i>&nbsp; Select Login Screen
										</th>
									</tr>
								</thead>
								<tbody class="collapse" id="loginscreenheader1" >
									<tr>
										<th style="vertical-align:top">Select Type </th>
										<td> 
											<select id="select_login_type" name="login_screen[screen_type]" style="width:71%" >
												<?php foreach ($login_screen_type as $keyScreen => $valueScreen){ ?>
													<option  value="<?php echo $keyScreen;?>"><?php echo $valueScreen?></option><?php } ?>
											</select>										
										</td>
									</tr>
								</tbody>								
								<thead>
									<tr>
										<th colspan="2">
											<i class="fa fa-arrow-circle-down"></i>&nbsp; Select Box Settings 
										</th>
									</tr>
								</thead>
								<tbody id="adminscreentbody" style="display: none;">
									<tr>
										<th style="vertical-align:top">Select Heading Color </th>
										<td> 
											<select id="select_admin_login_heading_color" name="login_screen[admin][select_admin_login_heading_color]" style="width:71%" >
													<option value="select">Select</option>
													<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
													<option <?php if($admin_login_screen_array['select_admin_login_heading_color'] == $keyColor) { echo "selected";}?>  value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
											</select>										
										</td>
									</tr>									
									<tr>
										<th style="vertical-align:top">Login Button Color </th>
										<td> 
											<select id="select_admin_login_button_color" name="login_screen[admin][select_admin_login_button_color]" style="width:71%" >
													<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
													<option <?php if($admin_login_screen_array['select_admin_login_button_color'] == $keyColor) { echo "selected";}?>  value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
											</select>										
										</td>
									</tr>										
									<tr>
										<th style="vertical-align:top">Forgot Button Color </th>
										<td> 
											<select id="select_admin_login_forgotbutton_color" name="login_screen[admin][select_admin_login_forgotbutton_color]" style="width:71%" >
													<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
													<option <?php if($admin_login_screen_array['select_admin_login_forgotbutton_color'] == $keyColor) { echo "selected";}?>  value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
											</select>										
										</td>
									</tr>									
									<tr>
										<th style="vertical-align:top">Select Heading Font </th>
										<td> 
											<select id="select_admin_login_heading_font" name="login_screen[admin][select_admin_login_heading_font]" style="width:71%" >
												<option value="select">Select</option>
												<?php foreach ($font_data[0] as $keyFont => $valueFont){ ?>
												<option   <?php if($admin_login_screen_array['select_admin_login_heading_font'] == $keyFont) { echo "selected";}?>  value="<?php echo $keyFont;?>"><?php echo $valueFont?></option><?php } ?>
											</select>										
										</td>
									</tr>								
									<tr>
										<th style="vertical-align:top">Select Background Image </th>
										<td> 
											<select id="select_admin_background_image_selection" name="login_screen[admin][select_admin_background_image_selection]" style="width:71%">
												<?php foreach ($image_select_type as $keyImage => $valueImage){ ?>
													<option  <?php if($admin_login_screen_array['select_admin_background_image_selection'] == $keyImage) { echo "selected";} ?> value="<?php echo $keyImage;?>"><?php echo $valueImage?></option><?php } ?>
											</select>	
											<br>

											<input style="visibility:hidden; height:0; float:left" type="file" name="uploadimages_admin_login_background" id="uploadimages_admin_login_background" class="uploadimages_admin_bg" />
									
											<button id="selectadminloginbackgroundbutton"  onclick="$('#uploadimages_admin_login_background').click()" class="btn btn-outline-secondary btn-xs" style="display: none;margin-top:10px;margin-bottom: 10px;margin-left: 10px!important; padding:0px 8px; display:inline-block;margin-left: 10px;" type="button"><?=$lng['Select file']?></button>
											<input type="hidden" id="admin_screen_login_background_image_link" name="admin_screen_login_background_image_link" value="<?php echo $admin_login_screen_array['bg_image_link'];?>">
											<br>

											<img id="admin_login_background_image_preview" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $admin_login_screen_array['bg_image_link']?>" style="height: 30px;margin-left: 10px;">
											<textarea style= "font-size: 10px!important;" readonly="readonly">Your background graphic must be a PNG, JPEG or JPG and of 1920 px by 836 px</textarea>
											<textarea id="admin_login_background_name_image_preview" readonly="readonly"><?php echo $admin_login_screen_array['bg_image_link']; ?></textarea>					
										</td>
									</tr>									
<!-- 
									<tr>
										<th style="vertical-align:top">Select Banner Image </th>
										<td> 
											<select id="select_admin_banner_image_selection" name="login_screen[admin][select_admin_banner_image_selection]" style="width:71%">
												<?php foreach ($image_select_type as $keyImage => $valueImage){ ?>
													<option  <?php if($admin_login_screen_array['select_admin_banner_image_selection'] == $keyImage) { echo "selected";} ?> value="<?php echo $keyImage;?>"><?php echo $valueImage?></option><?php } ?>
											</select>	
											<br>

											<input style="visibility:hidden; height:0; float:left" type="file" name="uploadimages_admin_login_banner" id="uploadimages_admin_login_banner" class="uploadimages_admin_bg" />
									
											<button id="selectadminloginbannerbutton"  onclick="$('#uploadimages_admin_login_banner').click()" class="btn btn-outline-secondary btn-xs" style="display: none;margin-top:10px;margin-bottom: 10px;margin-left: 10px!important; padding:0px 8px; display:inline-block;margin-left: 10px;" type="button"><?=$lng['Select file']?></button>
											<input type="hidden" id="admin_screen_login_banner_image_link" name="admin_screen_login_banner_image_link" value="<?php echo $admin_login_screen_array['banner_image_link'];?>">
											<br>

											<img id="admin_login_banner_image_preview" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $admin_login_screen_array['banner_image_link']?>" style="height: 15px;margin-left: 10px;">
											<textarea id="admin_banner_image_message" style= "font-size: 10px!important;" readonly="readonly">Your banner graphic must be a PNG, JPEG or JPG and of 2846 px by 200 px</textarea>
											<textarea id="admin_login_banner_name_image_preview" readonly="readonly"><?php echo $admin_login_screen_array['banner_image_link']; ?></textarea>					
										</td>
									</tr> -->
									<tr>
										<th style="vertical-align:top">Login Box Position </th>
										<td> 
											<select id="select_admin_login_box_main_position" name="login_screen[admin][select_admin_login_box_main_position]" style="width:71%">
												<?php foreach ($select_position_array as $keyPosition => $valuePosition){ ?>
													<option  <?php if($admin_login_screen_array['select_admin_login_box_main_position'] == $keyPosition) { echo "selected";} ?> value="<?php echo $keyPosition;?>"><?php echo $valuePosition?></option><?php } ?>
											</select>								
										</td>
									</tr>
									<tr>
										<th style="vertical-align:top">Screen Title Text Eng </th>
										<td> 
											<input type="text" id="select_admin_login_screen_title_text" name="login_screen[admin][select_admin_login_screen_title_text]"  value="<?php if($admin_login_screen_array['select_admin_login_screen_title_text'] != '') {echo $admin_login_screen_array['select_admin_login_screen_title_text']; }else{ echo 'Admin Platform';} ?>" />			
										</td>
									</tr>			
									<tr>
										<th style="vertical-align:top">Screen Title Text Thai</th>
										<td> 
											<input type="text" id="select_admin_login_screen_title_text_thai" name="login_screen[admin][select_admin_login_screen_title_text_thai]"  value="<?php if($admin_login_screen_array['select_admin_login_screen_title_text_thai'] != '') {echo $admin_login_screen_array['select_admin_login_screen_title_text_thai']; }else{ echo 'Admin Platform';} ?>" />			
										</td>
									</tr>
									<tr>
										<th style="vertical-align:top">Screen Title Text Color </th>
										<td> 
											<select id="select_admin_login_titletext_color" name="login_screen[admin][select_admin_login_titletext_color]" style="width:71%" >
													<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
													<option <?php if($admin_login_screen_array['select_admin_login_titletext_color'] == $keyColor) { echo "selected";}?>  value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
											</select>										
										</td>
									</tr>									
									<tr>
										<th style="vertical-align:top">Screen Title Text Font </th>
										<td> 
											<select id="select_admin_login_titletext_font" name="login_screen[admin][select_admin_login_titletext_font]" style="width:71%" >
												<option value="select">Select</option>
												<?php foreach ($font_data[0] as $keyFont => $valueFont){ ?>
												<option   <?php if($admin_login_screen_array['select_admin_login_titletext_font'] == $keyFont) { echo "selected";}?>  value="<?php echo $keyFont;?>"><?php echo $valueFont?></option><?php } ?>
											</select>										
										</td>
									</tr>	

								</tbody>							
								<tbody id="systemscreentbody" style="display: none;">


									<tr>
										<th style="vertical-align:top">Select Heading Color </th>
										<td> 	
											<select id="select_system_login_heading_color" name="login_screen[system][select_system_login_heading_color]" style="width:71%" >
													<option value="select">Select</option>
													<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
													<option <?php if($system_login_screen_array['select_system_login_heading_color'] == $keyColor) { echo "selected";}?>  value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
											</select>										
										</td>
									</tr>									
									<tr>
										<th style="vertical-align:top">Select Heading Font </th>
										<td> 
											<select id="select_system_login_heading_font" name="login_screen[system][select_system_login_heading_font]" style="width:71%" >
												<option value="select">Select</option>
												<?php foreach ($font_data[0] as $keyFont => $valueFont){ ?>
												<option   <?php if($system_login_screen_array['select_system_login_heading_font'] == $keyFont) { echo "selected";}?>  value="<?php echo $keyFont;?>"><?php echo $valueFont?></option><?php } ?>
											</select>								
										</td>
									</tr>	
									<tr>
										<th style="vertical-align:top">Login Button Color </th>
										<td> 
											<select id="select_system_login_button_color" name="login_screen[system][select_system_login_button_color]" style="width:71%" >
													<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
													<option <?php if($system_login_screen_array['select_system_login_button_color'] == $keyColor) { echo "selected";}?>  value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
											</select>										
										</td>
									</tr>										
									<tr>
										<th style="vertical-align:top">Forgot Button Color </th>
										<td> 
											<select id="select_system_login_forgotbutton_color" name="login_screen[system][select_system_login_forgotbutton_color]" style="width:71%" >
													<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
													<option <?php if($system_login_screen_array['select_system_login_forgotbutton_color'] == $keyColor) { echo "selected";}?>  value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
											</select>										
										</td>
									</tr>
									<tr>
										<th style="vertical-align:top">Select Background Image </th>
										<td> 
											<select id="select_system_background_image_selection" name="login_screen[system][select_system_background_image_selection]" style="width:71%">
												<?php foreach ($image_select_type as $keyImage => $valueImage){ ?>
													<option  <?php if($system_login_screen_array['select_system_background_image_selection'] == $keyImage) { echo "selected";} ?> value="<?php echo $keyImage;?>"><?php echo $valueImage?></option><?php } ?>
											</select>	
											<br>

											<input style="visibility:hidden; height:0; float:left" type="file" name="uploadimages_system_background" id="uploadimages_system_background" class="uploadimages_admin_bg" />
									
											<button id="selectsystembackgroundbutton"  onclick="$('#uploadimages_system_background').click()" class="btn btn-outline-secondary btn-xs" style="display: none;margin-top:10px;margin-bottom: 10px;margin-left: 10px!important; padding:0px 8px; display:inline-block;margin-left: 10px;" type="button"><?=$lng['Select file']?></button>
											<input type="hidden" id="system_screen_background_image_link" name="system_screen_background_image_link" value="<?php echo $system_login_screen_array['bg_image_link'];?>">
											<br>

											<img id="system_background_image_preview" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $system_login_screen_array['bg_image_link']?>" style="height: 30px;margin-left: 10px;">
											<textarea style= "font-size: 10px!important;" readonly="readonly">Your background graphic must be a PNG, JPEG or JPG and of 1920 px by 836 px</textarea>
											<textarea id="system_background_image_preview_name" readonly="readonly"><?php echo $system_login_screen_array['bg_image_link']; ?></textarea>					
										</td>
									</tr>						
			<!-- 						<tr>
										<th style="vertical-align:top">Select Banner Image </th>
										<td> 
											<select id="select_system_banner_image_selection" name="login_screen[system][select_system_banner_image_selection]" style="width:71%">
												<?php foreach ($image_select_type as $keyImage => $valueImage){ ?>
													<option  <?php if($system_login_screen_array['select_system_banner_image_selection'] == $keyImage) { echo "selected";} ?> value="<?php echo $keyImage;?>"><?php echo $valueImage?></option><?php } ?>
											</select>	
											<br>

											<input style="visibility:hidden; height:0; float:left" type="file" name="uploadimages_system_banner" id="uploadimages_system_banner" class="uploadimages_admin_bg" />
									
											<button id="selectsystembannerbutton"  onclick="$('#uploadimages_system_banner').click()" class="btn btn-outline-secondary btn-xs" style="display: none;margin-top:10px;margin-bottom: 10px;margin-left: 10px!important; padding:0px 8px; display:inline-block;margin-left: 10px;" type="button"><?=$lng['Select file']?></button>
											<input type="hidden" id="system_screen_banner_image_link" name="system_screen_banner_image_link" value="<?php echo $system_login_screen_array['banner_image_link'];?>">
											<br>

											<img id="system_banner_image_preview" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $system_login_screen_array['banner_image_link']?>" style="height: 15px;margin-left: 10px;">
											<textarea id="system_banner_message" style= "font-size: 10px!important;" readonly="readonly">Your banner graphic must be a PNG, JPEG or JPG and of 2846 px by 200 px</textarea>
											<textarea id="system_banner_image_preview_name" readonly="readonly"><?php echo $system_login_screen_array['banner_image_link']; ?></textarea>					
										</td>
									</tr> -->
									<tr>
										<th style="vertical-align:top">Login Box Position </th>
										<td> 
											<select id="select_system_login_box_main_position" name="login_screen[system][select_system_login_box_main_position]" style="width:71%">
												<?php foreach ($select_position_array as $keyPosition => $valuePosition){ ?>
													<option  <?php if($system_login_screen_array['select_system_login_box_main_position'] == $keyPosition) { echo "selected";} ?> value="<?php echo $keyPosition;?>"><?php echo $valuePosition?></option><?php } ?>
											</select>								
										</td>
									</tr>
									<tr>
										<th style="vertical-align:top">Screen Title Text Eng</th>
										<td> 
											<input type="text" id="select_system_login_screen_title_text" name="login_screen[system][select_system_login_screen_title_text]"  value="<?php if($system_login_screen_array['select_system_login_screen_title_text'] != '') {echo $system_login_screen_array['select_system_login_screen_title_text']; }else{ echo 'Integrated HR Platform';} ?>" />			
										</td>
									</tr>									
									<tr>
										<th style="vertical-align:top">Screen Title Text Thai</th>
										<td> 
											<input type="text" id="select_system_login_screen_title_text_thai" name="login_screen[system][select_system_login_screen_title_text_thai]"  value="<?php if($system_login_screen_array['select_system_login_screen_title_text_thai'] != '') {echo $system_login_screen_array['select_system_login_screen_title_text_thai']; }else{ echo 'Integrated HR Platform';} ?>" />			
										</td>
									</tr>
									<tr>
										<th style="vertical-align:top">Screen Title Text Color </th>
										<td> 
											<select id="select_system_login_titletext_color" name="login_screen[system][select_system_login_titletext_color]" style="width:71%" >
													<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
													<option <?php if($system_login_screen_array['select_system_login_titletext_color'] == $keyColor) { echo "selected";}?>  value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
											</select>										
										</td>
									</tr>									
									<tr>
										<th style="vertical-align:top">Screen Title Text Font </th>
										<td> 
											<select id="select_system_login_titletext_font" name="login_screen[system][select_system_login_titletext_font]" style="width:71%" >
												<option value="select">Select</option>
												<?php foreach ($font_data[0] as $keyFont => $valueFont){ ?>
												<option   <?php if($system_login_screen_array['select_system_login_titletext_font'] == $keyFont) { echo "selected";}?>  value="<?php echo $keyFont;?>"><?php echo $valueFont?></option><?php } ?>
											</select>										
										</td>
									</tr>	
								</tbody>								
								<tbody id="mobilescreentbody" style="display: none;">
									

									<tr>
										<th style="vertical-align:top">Select Heading Color </th>
										<td> 
											<select id="select_mob_login_heading_color" name="login_screen[mob][select_mob_login_heading_color]" style="width:71%" >
													<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
													<option <?php if($mob_login_screen_array['select_mob_login_heading_color'] == $keyColor) { echo "selected";}?>  value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
											</select>										
										</td>
									</tr>										
		<!-- 							<tr>
										<th style="vertical-align:top">Select Background Color </th>
										<td> 
											<select id="select_mob_login_background_color" name="login_screen[mob][select_mob_login_background_color]" style="width:90%" >
													<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
													<option <?php if($mob_login_screen_array['select_mob_login_background_color'] == $keyColor) { echo "selected";}?>  value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
											</select>										
										</td>
									</tr> -->									
									<tr>
										<th style="vertical-align:top">Select Heading Font </th>
										<td> 
											<select id="select_mob_login_heading_font" name="login_screen[mob][select_mob_login_heading_font]" style="width:71%" >
													<option value="select">Select</option>
													<?php foreach ($font_data[0] as $keyFont => $valueFont){ ?>
													<option   <?php if($mob_login_screen_array['select_mob_login_heading_font'] == $keyFont) { echo "selected";}?>  value="<?php echo $keyFont;?>"><?php echo $valueFont?></option><?php } ?>
											</select>										
										</td>
									</tr>								
									<tr>
										<th style="vertical-align:top">Select Login Button Color </th>
										<td> 
											<select id="select_mob_login_button_color" name="login_screen[mob][select_mob_login_button_color]" style="width:71%" >
													<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
													<option <?php if($mob_login_screen_array['select_mob_login_button_color'] == $keyColor) { echo "selected";}?>  value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
											</select>										
										</td>
									</tr>

									<tr>
										<th style="vertical-align:top">Forgot Button Color </th>
										<td> 
											<select id="select_mob_login_forgot_button_color" name="login_screen[mob][select_mob_login_forgot_button_color]" style="width:71%" >
													<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
													<option <?php if($mob_login_screen_array['select_mob_login_forgot_button_color'] == $keyColor) { echo "selected";}?>  value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
											</select>										
										</td>
									</tr>									

								</tbody>								
								<tbody id="scanscreentbody" style="display: none;">
			

									<tr>
										<th style="vertical-align:top">Main Heading Color </th>
										<td> 
											<select id="select_scan_login_heading_color" name="login_screen[scan][select_scan_login_heading_color]" style="width:71%" >
												<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
													<option <?php if($scan_login_screen_array['select_scan_login_heading_color'] == $keyColor) { echo "selected";}?>  value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
											</select>										
										</td>
									</tr>									
									<tr>
										<th style="vertical-align:top">Main Heading Font </th>
										<td> 
											<select id="select_scan_login_heading_font" name="login_screen[scan][select_scan_login_heading_font]" style="width:71%" >
													<option value="select">Select</option>
													<?php foreach ($font_data[0] as $keyFont => $valueFont){ ?>
													<option   <?php if($scan_login_screen_array['select_scan_login_heading_font'] == $keyFont) { echo "selected";}?>  value="<?php echo $keyFont;?>"><?php echo $valueFont?></option><?php } ?>
											</select>										
										</td>
									</tr>								
									<tr>
										<th style="vertical-align:top">Box Heading Color </th>
										<td> 
											<select id="select_scan_login_box_color" name="login_screen[scan][select_scan_login_box_color]" style="width:71%" >
												<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
													<option <?php if($scan_login_screen_array['select_scan_login_box_color'] == $keyColor) { echo "selected";}?>  value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
											</select>										
										</td>
									</tr>						
									<tr>
										<th style="vertical-align:top">Box Heading Font </th>
										<td> 
											<select id="select_scan_login_box_font" name="login_screen[scan][select_scan_login_box_font]" style="width:71%" >
													<option value="select">Select</option>
													<?php foreach ($font_data[0] as $keyFont => $valueFont){ ?>
													<option   <?php if($scan_login_screen_array['select_scan_login_box_font'] == $keyFont) { echo "selected";}?>  value="<?php echo $keyFont;?>"><?php echo $valueFont?></option><?php } ?>
											</select>										
										</td>
									</tr>									
									<tr>
										<th style="vertical-align:top">Login Button Color</th>
										<td> 
											<select id="select_scan_login_box_loginbutton_color" name="login_screen[scan][select_scan_login_box_loginbutton_color]" style="width:71%" >
												<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
													<option <?php if($scan_login_screen_array['select_scan_login_box_loginbutton_color'] == $keyColor) { echo "selected";}?>  value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
											</select>										
										</td>
									</tr>									
									<tr>
										<th style="vertical-align:top">Login Button Font</th>
										<td> 
											<select id="select_scan_login_box_loginbutton_font" name="login_screen[scan][select_scan_login_box_loginbutton_font]" style="width:71%" >
													<option value="select">Select</option>
													<?php foreach ($font_data[0] as $keyFont => $valueFont){ ?>
													<option   <?php if($scan_login_screen_array['select_scan_login_box_loginbutton_font'] == $keyFont) { echo "selected";}?>  value="<?php echo $keyFont;?>"><?php echo $valueFont?></option><?php } ?>
											</select>										
										</td>
									</tr>									
								</tbody>
							</table>
							
							<div style="height:15px"></div>

						</div>
					</div>

					<div style="position:absolute; left:30%; top:57px; right:0; bottom:0; background: #f6f6f6; border-left:1px solid #ddd">
						<div class="admin_login_screen_div" id="rightTable1" style=" background: url('../images/admin_uploads/<?php echo $admin_login_screen_array['bg_image_link']?>')no-repeat;background-position: bottom;background-size: cover;  overflow-y: auto; padding: 15px 15px 100px; padding-top: 0px!important;display: none;">
							<div class="dash-left" style="width: 100%!important;">
								<div id="brand_logo">
									<a style="margin:0px 0 0 0" data-lng="th" class="langbutton "><img src="../images/flag_th.png"></a>
								</div>
									<div id="brand_title">
										<b style="font-family:'Roboto Condensed'; font-weight:400; font-size:24px; color:#333;"><img style="display:<?php if($combineLogoHeadersArray['admin_login_screen_title_logo']['show_hide_logo_common_field'] != '1'){echo 'none';}?>;height:<?php echo $combineLogoHeadersArray['admin_login_screen_title_logo']['admin_login_screen_logo_size'].'px'?>;" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $combineLogoHeadersArray['admin_login_screen_title_logo']['image_link']?> "><span id="adminloginscreentitletext" style="position: absolute;top: 19px;left: 223px;"><?php if($admin_login_screen_array['select_admin_login_screen_title_text'] != '') {echo $admin_login_screen_array['select_admin_login_screen_title_text']; }else{ echo 'Admin Platform';} ?></span></b>
									</div>

								<div style="padding-top:12vh; xborder:1px solid red" id="adminloginform">
									<div class="brand">
										<img id="admin_logo_image_select" style="margin-left: 146px;height:<?php echo $combineLogoHeadersArray['admin_login_screen_logo']['admin_login_screen_logo_size'].'px'?>;display:<?php if($combineLogoHeadersArray['admin_login_screen_logo']['show_hide_logo_common_field'] != '1'){echo 'none';}?>" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $combineLogoHeadersArray['admin_login_screen_logo']['image_link']?> ">
										<p></p>
									</div>

				
									
									<div class="logform" id="loginscreenadmin">
										<h2 id="admin_login_screen_h2_div" style="background:#007700; border-radius:3px 3px 0 0"><i class="fa fa-lock"></i> &nbsp;<span>Login to our secure server</span></h2>
										<div class="logform-inner " id="admin_box_color">
											<div id="logMsg" style="color:#b00; font-weight:600; font-size:14px; display:none"></div>
											<div id="login">
												<form id="logForm">
													<label>Username <i class="man"></i></label>
													<input name="username" type="text" autocomplete="username" value="" />
													<label>Password <i class="man"></i></label>
													<input name="password" type="password" autocomplete="current-password" value="" />
													<div style="height:15px"></div>
													<button id= "adminloginbuttoncolor" type="button" class="btn btn-primary"><i class="fa fa-sign-in"></i>&nbsp; Log-in</button>
													<button id="togglediv" style="float:right;" type="button" class=" forgotpasswordlogin btn btn-primary">Forgot password</button>
												</form>
											</div>
										</div>
									</div>
								</div>
								
							</div> <!-- dash left ends -->


					<!-- 		<div class="col-md-12">
									<img id="adminbannerimage" style="width: 100%;position: absolute;bottom: 0px;" src="../images/admin_uploads/<?php echo $admin_login_screen_array['banner_image_link']?>">
							</div> -->
						</div><!-- div right ends -->						

						<div class="system_login_screen_div" id="rightTable2" style="background: url('../../images/admin_uploads/<?php echo $system_login_screen_array['bg_image_link']?>') no-repeat;background-position: bottom;background-size: cover; overflow-y: auto; padding: 15px 15px 100px; padding-top: 0px!important;display: none;">

							<div class="dash-left" style="width: 100%!important;">
								<div id="brand_logo">
										<a style="margin:0px 0 0 0" data-lng="th" class="langbutton "><img src="../images/flag_th.png"></a>
								</div>

								<div id="brand_title">
									<b style="font-family:'Roboto Condensed'; font-weight:400; font-size:24px; color:#333;"><img style="display:<?php if($combineLogoHeadersArray['system_login_screen_title_logo']['show_hide_logo_common_field'] != '1'){echo 'none';}?>;height:<?php echo $combineLogoHeadersArray['system_login_screen_title_logo']['admin_login_screen_logo_size'].'px'?>;" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $combineLogoHeadersArray['system_login_screen_title_logo']['image_link']?> "><span id="systemloginscreentitletext" style="position: absolute;top: 19px;left: 223px;"><?php if($admin_login_screen_array['select_admin_login_screen_title_text'] != '') {echo $system_login_screen_array['select_system_login_screen_title_text']; }else{ echo 'Integrated HR Platform';} ?></span></b>
								</div>

								<div id="systemloginscreenform" style="padding-top:10vh; xborder:1px solid red;margin-left: 70px;">
									<div class="brand">
										<img style="display:<?php if($combineLogoHeadersArray['system_login_screen_logo']['show_hide_logo_common_field'] != '1'){echo 'none';}?>;height:<?php echo $combineLogoHeadersArray['system_login_screen_logo']['admin_login_screen_logo_size'].'px'?>;" id="system_logo_image_select" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $combineLogoHeadersArray['system_login_screen_logo']['image_link']?>">
										<p></p>
									</div>


									<div class="logform" style="xleft:1000px !important">
										<h2 id="system_login_screen_box_div"><i class="fa fa-lock"></i> &nbsp;<span>Login to our secure server<span></h2>
										<div class="logform-inner">
											<div id="login">
												<form id="logForm">
													<label>Username <i class="man"></i></label>
													<input name="username" type="text" autocomplete="username" value="" />
													<label>Password <i class="man"></i></label>
													<input name="password" type="password" autocomplete="current-password" value="" />
													<div style="height:15px"></div>
													<button id= "systemLoginScreenLoginButton" type="button" class="btn btn-primary"><i class="fa fa-sign-in"></i>&nbsp; Log-in</button>
													<button id="togglediv" style="float:right;" type="button" class="systemforgotpasswordbutton btn btn-primary">Forgot password</button>
												</form>
												<div id="dump"></div>
											</div>
										</div>
									</div>
								</div>
							</div> <!-- dash left ends -->
<!-- 							<div>
									<img id="systembannerimage" style="width: 100%;position: absolute;bottom: 0px;" src="../images/admin_uploads/<?php echo $system_login_screen_array['banner_image_link']?>">
							</div> -->
							
						</div><!-- div right ends -->						

						<div class="mob_login_screen_div" id="rightTable3" style="background: rgb(255, 255, 255); overflow-y: auto; padding: 15px 15px 100px; padding-top: 0px!important;display: none;">
							<div class="dash-left" style="width: 100%!important;">
								
								<div class="appHeader1 bg-dark text-light">
								    <div class="pageTitle"><span id="mob_heading_font">Login to our secure server</span></div>
								</div>


								<div class="container-fluid" style="xborder:1px solid red">
									<div class="row" style="xborder:1px solid green; padding:25px">
										<div class="col-12">
											<!-- <img id="mob_logo_selection" style="height:40px" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $mob_login_screen_array['image_link']?>"> -->

											<img id="mob_logo_selection" style="height:<?php echo $combineLogoHeadersArray['mob_login_screen_logo_array']['admin_login_screen_logo_size'].'px'?>;display:<?php if($combineLogoHeadersArray['mob_login_screen_logo_array']['show_hide_logo_common_field'] != '1'){echo 'none';}?>" src="<?php echo ROOT;?>images/admin_uploads/<?php echo $combineLogoHeadersArray['mob_login_screen_logo_array']['image_link']?> ">

											
											<div class="divider-icon">
												<div><i class="fa fa-lock fa-lg"></i></div>
											</div>
											
											<div id="logForm">	
												<form id="log_form">
													<div class="form-group">
														<label for="username">Username</label>
														<input class="form-control" type="text" name="username" value="" id="username" style="width: 100%;" />
													</div>
													<div class="form-group">
														<label for="password">Password</label>
														<input class="form-control" type="password" name="password" value="" id="password" style="width: 100%;"/>
													</div>
													<table border="0" style="margin-bottom:10px;">
														<tr>
															<td>
																<div class="custom-control custom-switch" style="">
																		<input checked type="checkbox" class="custom-control-input" name="remember" id="remember" value="1" >
																		<label style="background: #007bff!important" class="custom-control-label" for="remember"></label>
																</div>
															</td>
															<td style="padding-left:8px; font-weight:500">Remember me</td>
														</tr>
													</table>
													<button id="mob_login_button" style="margin-bottom:6px" type="button" class="btn btn-default btn-block" style="background:#239965!important;">Log-in &nbsp;<i class="fa fa-sign-in fa-lg"></i></button>
													<button type="button" class="btn btn-info btn-block" id="forgot" style="background: #007bff!important;">Forgot password</button>
													<div style="color:#a00; font-size:15px; display:none; margin-top:10px" id="logMsg"></div>
												</form>
											</div>
											
											<div style="height:250px"></div>
											
										</div>
									</div>
								</div>	



								<div class="fixBottomMenu" style="border:0">
									<a href="#" data-lng="th" class="langbutton "><img src="../images/flag_th.png"></a>
								</div>
							</div> <!-- dash left ends -->
							
						</div><!-- div right ends -->			

						<div class="scan_login_screen_div" id="rightTable4" style=" background: url('../../images/204503773-huge.jpg')no-repeat;background-position: bottom;background-size: cover; overflow-y: auto; padding: 15px 15px 100px; padding-top: 0px!important;display: none;">
							<div class="dash-left" style="width: 100%!important;">
								
								<div class="header1" style="background: rgba(0,0,0,0.7); text-align:center">
									<span> Rego Demo Time registration </span>
								</div>			

								<div class="log-wrapper">
									<div class="log-body">
										<div id= "scan_login_box_header" class="log-title" style="background: #0055a5 !important;"><span>Login to our secure server</span></div>
										<div id="logForm">	
											<form id="log_form" style="padding:0 0 10px 0">
												<label>Username</label>
												<input id="username" name="username" type="text" value="" style="width: 100%">
												
												<label>Password</label>
												<input id="password" name="password" type="password" value="" style="width: 100%">
												
												<div id="logMsg"></div>
												
												<button id="logButton" type="button" class="btn btn-success btn-lg btn-block tac" style="background: #61bc47;margin-top:10px; font-weight:400; letter-spacing:1px"><span>Log-in</span> &nbsp;<i class="fa fa-sign-in fa-lg"></i></button>
								

											</form>
										</div>
										
										<div id="dump"></div>
									</div>

										<a data-lng="th" class="langbutton1 "><img height="50px" src="../images/flag_th.png"></a>
								</div>
							</div> <!-- dash left ends -->
							
						</div><!-- div right ends -->
					</div>