<div style="position:absolute; left:24px; top:57px; right:70%; bottom:0; background:#fff;">
<!--  	<?php 

	echo '<pre>';
	print_r($buttons_tab_array);
	echo '</pre>';

	?>  -->
	<div id="leftTable" style="left:10px; top:45px; right:10px; bottom:15px; background:#fff; overflow-Y:auto; padding:0; display:xnone; overflow-X:hidden">
		<table class="basicTable inputs" border="0">
			<thead >
				<tr>
					<th colspan="2">
						<i class="fa fa-arrow-circle-down"></i>&nbsp; <!-- <?=$lng['Buttons Layout']?> -->Buttons Layout
					</th>
				</tr>
			</thead>
			<tbody class="" id="buttonsetheader1" style="display: none;">
				<tr>
					<th style="vertical-align:top">Button Color</th>
					<td> 
						<select id="buttons_color_select"  style="width:71%" >
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="buttons_color_select_circle" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>					
				<tr>
					<th style="vertical-align:top">Button Hoover Color </th>
					<td> 
						<select id="button_hoover_select"  style="width:71%" >
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option  value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="button_hoover_select_circle" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>					
				<tr class="hidetrforbuttons" style="display: none;">
					<th style="vertical-align:top;">Button On Change Color 1</th>
					<td> 

						<select id="button_onchange_color_select"  style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="button_onchange_color_select_circle" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>					
				<tr class="hidetrforbuttons" style="display: none;">
					<th style="vertical-align:top;">Button On Change Color 2</th>
					<td> 

						<select id="button_onchange_color_select_2"  style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="button_onchange_color_select_circle_2" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>					
				<tr>
					<th style="vertical-align:top">Button Text Color </th>
					<td> 

						<select id="button_text_color"  style="width:71%">
							<?php foreach ($selectedColorsValName as $keyColor => $valueColor){ ?>
								<option  value="<?php echo $keyColor;?>"><?php echo $valueColor?></option><?php } ?>
						</select>	
						<i id="button_text_color_circle" style="width:10%" class="green fa fa-circle" aria-hidden="true"></i>									
					</td>
				</tr>					
				<tr class="hidetrforbuttons" style="display: none;">
					<th style="vertical-align:top;">Test Button Color Change Event  </th>
					<td> 
						<input type="text" id="testcolorchangeevent" value = "" placeholder="Type Here">								
					</td>
				</tr>												
			</tbody>
		</table>
		<div style="height:15px"></div>

	</div>
</div>


<!---- --->
<div style="position:absolute; left:30%; top:57px; right:0; bottom:0; background: #f6f6f6; border-left:1px solid #ddd">
			
	<div id="rightTable" style="position: absolute; left: 15px; top: 0px; right: 15px; bottom: 15px; background: #fff;overflow-y: auto; padding: 15px 15px 100px; padding-top: 0px!important;">
		<div class="dash-left" style="width:100%!important;">
			<div  style="position: relative!important;top: 25px!important;">

				<input type="hidden" name="hiddenButtonValue" id="hiddenButtonValue" value="">
				<input type="hidden" name="hiddenButtonValueNumeric" id="hiddenButtonValueNumeric" value="">
				<input type="hidden" name="hiddenButtonValueSpan" id="hiddenButtonValueSpan" value="">
				<table class="table">
					<thead  data-toggle="collapse" data-target="#buttonLayoutheader1" >
						<tr>
							<th colspan="8">
								<i class="fa fa-arrow-circle-down"></i>&nbsp; General Buttons
							</th>
						</tr>
					</thead>
					<tr class="collapse" id="buttonLayoutheader1">
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout1]" value="" id="buttonLayout1_hidden">
							<button  style="" onmouseenter="getHooverColor('buttonLayout1');" onmouseleave ="removeHooverColor('buttonLayout1');" onclick="onclickActions('buttonLayout1','1')"; class="btn btn-primary" id="buttonLayout1" type="button"><span id="buttonLayout1span"><i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['OK']?></span></button>
						</td>
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout2]" value="" id="buttonLayout2_hidden">
							<button  name="buttons_layout[buttonLayout2]" onmouseenter="getHooverColor('buttonLayout2');" onmouseleave ="removeHooverColor('buttonLayout2');" onclick="onclickActions('buttonLayout2','2')"; class="btn btn-primary" id="buttonLayout2" type="button"><span id="buttonLayout2span"><i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Cancel']?></span></button>
						</td>
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout3]" value="" id="buttonLayout3_hidden">
							<button name="buttons_layout[buttonLayout3]" onmouseenter="getHooverColor('buttonLayout3');" onmouseleave ="removeHooverColor('buttonLayout3');" onclick="onclickActions('buttonLayout3','3')"; class="btn btn-primary" id="buttonLayout3" type="button"><span id="buttonLayout3span"><i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Update']?></span></button>
						</td>
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout4]" value="" id="buttonLayout4_hidden">
							<button  name="buttons_layout[buttonLayout4]" onmouseenter="getHooverColor('buttonLayout4');" onmouseleave ="removeHooverColor('buttonLayout4');" onclick="onclickActions('buttonLayout4','4')"; class="btn btn-primary" id="buttonLayout4" type="button"><span id="buttonLayout4span"><i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Export']?></span></button>
						</td>
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout5]" value="" id="buttonLayout5_hidden">
							<button  name="buttons_layout[buttonLayout5]" onmouseenter="getHooverColor('buttonLayout5');" onmouseleave ="removeHooverColor('buttonLayout5');" onclick="onclickActions('buttonLayout5','5')"; class="btn btn-primary" id="buttonLayout5" type="button"><span id="buttonLayout5span"><i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Import']?></span></button>
						</td>
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout6]" value="" id="buttonLayout6_hidden">
							<button name="buttons_layout[buttonLayout6]"  onmouseenter="getHooverColor('buttonLayout6');" onmouseleave ="removeHooverColor('buttonLayout6');" onclick="onclickActions('buttonLayout6','6')"; class="btn btn-primary" id="buttonLayout6" type="button"><span id="buttonLayout6span"><i class="fa fa-arrow"></i>&nbsp;&nbsp;Go Back </span></button>
						</td>
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout7]" value="" id="buttonLayout7_hidden">
							<button  name="buttons_layout[buttonLayout7]" onmouseenter="getHooverColor('buttonLayout7');" onmouseleave ="removeHooverColor('buttonLayout7');" onclick="onclickActions('buttonLayout7','7')"; class="btn btn-primary" id="buttonLayout7" type="button"><span id="buttonLayout7span"><i class="fa fa-check"></i>&nbsp;&nbsp;Clear Selection</span></button>
						</td>
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout8]" value="" id="buttonLayout8_hidden">
							<button  name="buttons_layout[buttonLayout8]" onmouseenter="getHooverColor('buttonLayout8');" onmouseleave ="removeHooverColor('buttonLayout8');" onclick="onclickActions('buttonLayout8','8')"; class="btn btn-primary" id="buttonLayout8" type="button"><span id="buttonLayout8span"><i class="fa fa-check"></i>&nbsp;&nbsp;Button 8</span></button>
						</td>
					</tr>	
					<thead  data-toggle="collapse" data-target="#buttonLayoutheader2">
						<tr>
							<th colspan="8">
								<i class="fa fa-arrow-circle-down"></i>&nbsp; Employee Module 
							</th>
						</tr>
					</thead>		
					<tr class="collapse" id="buttonLayoutheader2">
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout9]" value="" id="buttonLayout9_hidden">
							<button  name="buttons_layout[buttonLayout9]" class="btn btn-primary" id="buttonLayout9" type="button"><span id="buttonLayout9span"><i class="fa fa-check"></i>&nbsp;&nbsp;Add Employee</span></button>
						</td>
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout10]" value="" id="buttonLayout10_hidden">
							<button  name="buttons_layout[buttonLayout10]" class="btn btn-primary" id="buttonLayout10" type="button"><span id="buttonLayout10span"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Import Employee</span></button>
						</td>						
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout11]" value="" id="buttonLayout11_hidden">
							<button  name="buttons_layout[buttonLayout11]" class="btn btn-primary" id="buttonLayout11" type="button"><span id="buttonLayout11span"><i class="fa fa-trash"></i>&nbsp;&nbsp;Export Employee</span></button>
						</td>					
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout12]" value="" id="buttonLayout12_hidden">
							<button  name="buttons_layout[buttonLayout12]" class="btn btn-primary" id="buttonLayout12" type="button"><span id="buttonLayout12span"><i class="fa fa-trash"></i>&nbsp;&nbsp;Ping Employee</span></button>
						</td>					
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout13]" value="" id="buttonLayout13_hidden">
							<button  name="buttons_layout[buttonLayout13]" class="btn btn-primary" id="buttonLayout13" type="button"><span id="buttonLayout13span"><i class="fa fa-trash"></i>&nbsp;&nbsp;Add Medical</span></button>
						</td>
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout14]" value="" id="buttonLayout14_hidden">
							<button  name="buttons_layout[buttonLayout14]" class="btn btn-primary" id="buttonLayout14" type="button"><span id="buttonLayout14span"><i class="fa fa-trash"></i>&nbsp;&nbsp;Add  Discipline</span></button>
						</td>
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout15]" value="" id="buttonLayout15_hidden">
							<button  name="buttons_layout[buttonLayout15]" class="btn btn-primary" id="buttonLayout15" type="button"><span id="buttonLayout15span"><i class="fa fa-trash"></i>&nbsp;&nbsp;Add  History</span></button>
						</td>	
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout16]" value="" id="buttonLayout16_hidden">
							<button  name="buttons_layout[buttonLayout16]" class="btn btn-primary" id="buttonLayout16" type="button"><span id="buttonLayout16span"><i class="fa fa-trash"></i>&nbsp;&nbsp;Add Asset</span></button>
						</td>
					</tr>					
					<tr class="collapse" id="buttonLayoutheader2">
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout17]" value="" id="buttonLayout17_hidden">
							<button  name="buttons_layout[buttonLayout17]" class="btn btn-primary" id="buttonLayout17" type="button"><span id="buttonLayout17span"><i class="fa fa-check"></i>&nbsp;&nbsp;Select Picture</span></button>
						</td>						
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout18]" value="" id="buttonLayout18_hidden">
							<button  name="buttons_layout[buttonLayout18]" class="btn btn-primary" id="buttonLayout18" type="button"><span id="buttonLayout18span"><i class="fa fa-check"></i>&nbsp;&nbsp;Modify Data</span></button>
						</td>						
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout19]" value="" id="buttonLayout19_hidden">
							<button  name="buttons_layout[buttonLayout19]" class="btn btn-primary" id="buttonLayout19" type="button"><span id="buttonLayout19span"><i class="fa fa-check"></i>&nbsp;&nbsp;Save to Employee Register</span></button>
						</td>						
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout20]" value="" id="buttonLayout20_hidden">
							<button  name="buttons_layout[buttonLayout20]" class="btn btn-primary" id="buttonLayout20" type="button"><span id="buttonLayout20span"><i class="fa fa-check"></i>&nbsp;&nbsp;Archive Employee</span></button>
						</td>						
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout21]" value="" id="buttonLayout21_hidden">
							<button  name="buttons_layout[buttonLayout21]" class="btn btn-primary" id="buttonLayout21" type="button"><span id="buttonLayout21span"><i class="fa fa-check"></i>&nbsp;&nbsp;Delete Employee</span></button>
						</td>						
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout22]" value="" id="buttonLayout22_hidden">
							<button  name="buttons_layout[buttonLayout22]" class="btn btn-primary" id="buttonLayout22" type="button"><span id="buttonLayout22span"><i class="fa fa-check"></i>&nbsp;&nbsp;Use Employee</span></button>
						</td>
					</tr>					
					<thead  data-toggle="collapse" data-target="#buttonLayoutheader3">
						<tr>
							<th colspan="8">
								<i class="fa fa-arrow-circle-down"></i>&nbsp; Payroll Module 
							</th>
						</tr>
					</thead>		
					<tr class="collapse" id="buttonLayoutheader3">
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout23]" value="" id="buttonLayout23_hidden">
							<button  name="buttons_layout[buttonLayout23]" class="btn btn-primary" id="buttonLayout23" type="button"><span id="buttonLayout23span"><i class="fa fa-check"></i>&nbsp;&nbsp;Add Payroll</span></button>
						</td>					
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout24]" value="" id="buttonLayout24_hidden">
							<button  name="buttons_layout[buttonLayout24]" class="btn btn-primary" id="buttonLayout24" type="button"><span id="buttonLayout24span"><i class="fa fa-trash"></i>&nbsp;&nbsp;Fetch Employee Data</span></button>
						</td>					
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout25]" value="" id="buttonLayout25_hidden">
							<button  name="buttons_layout[buttonLayout25]" class="btn btn-primary" id="buttonLayout25" type="button"><span id="buttonLayout25span"><i class="fa fa-trash"></i>&nbsp;&nbsp;Upload File</span></button>
						</td>
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout26]" value="" id="buttonLayout26_hidden">
							<button  name="buttons_layout[buttonLayout26]" class="btn btn-primary" id="buttonLayout26" type="button"><span id="buttonLayout26span"><i class="fa fa-trash"></i>&nbsp;&nbsp;Export</span></button>
						</td>
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout27]" value="" id="buttonLayout27_hidden">
							<button  name="" class="btn btn-primary" id="buttonLayout27" type="button"><span id="buttonLayout27span"><i class="fa fa-trash"></i>&nbsp;&nbsp;Import</span></button>
						</td>	
	
					</tr>
					<thead  data-toggle="collapse" data-target="#buttonLayoutheader4">
						<tr>
							<th colspan="8">
								<i class="fa fa-arrow-circle-down"></i>&nbsp; Settings Module 
							</th>
						</tr>
					</thead>		
					<tr class="collapse" id="buttonLayoutheader4">
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout28]" value="" id="buttonLayout28_hidden">
							<button  name="buttons_layout[buttonLayout28]" class="btn btn-primary" id="buttonLayout28" type="button"><span id="buttonLayout28span"><i class="fa fa-check"></i>&nbsp;&nbsp;Change Subscription</span></button>
						</td>
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout29]" value="" id="buttonLayout29_hidden">
							<button  name="buttons_layout[buttonLayout29]" class="btn btn-primary" id="buttonLayout29" type="button"><span id="buttonLayout29span"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Add Row</span></button>
						</td>						
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout30]" value="" id="buttonLayout30_hidden">
							<button  name="buttons_layout[buttonLayout30]" class="btn btn-primary" id="buttonLayout30" type="button"><span id="buttonLayout30span"><i class="fa fa-trash"></i>&nbsp;&nbsp;Show Chart</span></button>
						</td>					
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout31]" value="" id="buttonLayout31_hidden">
							<button  name="buttons_layout[buttonLayout31]" class="btn btn-primary" id="buttonLayout31" type="button"><span id="buttonLayout31span"><i class="fa fa-trash"></i>&nbsp;&nbsp;Add new user</span></button>
						</td>					
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout32]" value="" id="buttonLayout32_hidden">
							<button  name="buttons_layout[buttonLayout32]" class="btn btn-primary" id="buttonLayout32" type="button"><span id="buttonLayout32span"><i class="fa fa-trash"></i>&nbsp;&nbsp;Get default SSO PND3</span></button>
						</td>
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout33]" value="" id="buttonLayout33_hidden">
							<button  name="buttons_layout[buttonLayout33]" class="btn btn-primary" id="buttonLayout33_hidden" type="button"><span id="buttonLayout33span"><i class="fa fa-trash"></i>&nbsp;&nbsp;Add Item </span></button>
						</td>
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout34]" value="" id="buttonLayout34_hidden">
							<button  name="buttons_layout[buttonLayout34]" class="btn btn-primary" id="buttonLayout34" type="button"><span id="buttonLayout34span"><i class="fa fa-trash"></i>&nbsp;&nbsp;Add  Model</span></button>
						</td>	
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout35]" value="" id="buttonLayout35_hidden">
							<button  name="buttons_layout[buttonLayout35]" class="btn btn-primary" id="buttonLayout35" type="button"><span id="buttonLayout35span"><i class="fa fa-trash"></i>&nbsp;&nbsp;Add Holiday</span></button>
						</td>					
					</tr>					
					<tr class="collapse" id="buttonLayoutheader4">			
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout36]" value="" id="buttonLayout36_hidden">
							<button  name="buttons_layout[buttonLayout36]" class="btn btn-primary" id="buttonLayout36" type="button"><span id="buttonLayout36span"><i class="fa fa-trash"></i>&nbsp;&nbsp;Import holidays from REGO admin</span></button>
						</td>						
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout37]" value="" id="buttonLayout37_hidden">
							<button  name="buttons_layout[buttonLayout37]" class="btn btn-primary" id="buttonLayout37" type="button"><span id="buttonLayout37span"><i class="fa fa-trash"></i>&nbsp;&nbsp;Get Defaults</span></button>
						</td>
					</tr>
					<thead data-toggle="collapse" data-target="#buttonLayoutheader5">
						<tr>
							<th colspan="8">
								<i class="fa fa-arrow-circle-down"></i>&nbsp; Communication Center
							</th>
						</tr>
					</thead>		
					<tr class="collapse" id="buttonLayoutheader5">
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout38]" value="" id="buttonLayout38_hidden">
							<button  name="buttons_layout[buttonLayout38]" class="btn btn-primary" id="buttonLayout38" type="button"><span id="buttonLayout38span"><i class="fa fa-check"></i>&nbsp;&nbsp;New Header</span></button>
						</td>
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout39]" value="" id="buttonLayout39_hidden">
							<button  name="buttons_layout[buttonLayout39]" class="btn btn-primary" id="buttonLayout39" type="button"><span id="buttonLayout39span"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;New Footer</span></button>
						</td>						
						<td style="text-align: left;">
							<input type="hidden" name="buttons_layout[buttonLayout40]" value="" id="buttonLayout40_hidden">
							<button  name="buttons_layout[buttonLayout40]" class="btn btn-primary" id="buttonLayout40" type="button"><span id="buttonLayout40span"><i class="fa fa-trash"></i>&nbsp;&nbsp;New Text Block </span></button>
						</td>					
						
					</tr>
	
				</table>
			</div>



		</div>

	
	
	</div>
	
</div>