	<table class="basicTable inputs" border="0">
		<thead data-toggle="collapse">
			<tr>
				<th colspan="4">
					&nbsp; Admin/Main Dashboard Color Settings
				</th>
			</tr>
		</thead>
		<thead data-toggle="collapse" data-target="#colorsetheader1">
			<tr>
				<th colspan="4">
					<i class="fa fa-arrow-circle-down"></i>&nbsp; Dashboard Color Set
				</th>
			</tr>
		</thead>
		<tbody class="collapse" id="colorsetheader1">
			<tr >
				<th  style="vertical-align:top">Select Type Of Color Set </th>
				<td > 

					<select id="typeofcolorset" name="typeofcolorset" style="width:100%;">
						<option <?php if($color_type_set_data == 'select') echo 'selected';?> value="select">Select</option>
						<option <?php if($color_type_set_data == 'standard') echo 'selected';?> value="standard">Standard Color Set</option>
						<option <?php if($color_type_set_data == 'manual') echo 'selected';?> value="manual">Manual Color Set</option>
					</select>	
				</td>
			</tr>			
			<tr id="standard_color_set_tr" style="display: <?php if($color_type_set_data == 'manual' || $color_type_set_data == 'select') echo 'none';?>">
				<th  style="vertical-align:top">Standard Color Set </th>
				<td > 
					<select id="colorsetdropdown" name="colorsetdropdown" style="width:100%;">
						<option value="select">Select</option>
						<?php foreach ($color_palette_data as $keyColorSet => $valueColorSet){ ?>
							<option  <?php if($color_set_data == $keyColorSet) echo 'selected';?> value="<?php echo $keyColorSet;?>"><?php echo $valueColorSet['setname'];?></option><?php } ?>
					</select>	
				</td>
			</tr>				
 			<tr id="manual_color_set_tr" style="display: <?php if($color_type_set_data == 'standard' || $color_type_set_data == 'select') echo 'none';?>">
				<th  style="vertical-align:top">Manual Color Set </th>
				<td > 

					<select id="colorsetdropdownmanual" name="colorsetdropdownmanual" style="width:100%;">
						<option value="select">Select</option>
						<?php foreach ($color_palette_data_manaual as $keyColorSet => $valueColorSet){ ?>
							<option  <?php if($color_set_data == $keyColorSet) echo 'selected';?> value="<?php echo $keyColorSet;?>"><?php echo $valueColorSet['setname'];?></option><?php } ?>
					</select>	
				</td>
			</tr> 
		</tbody>	
		<thead data-toggle="collapse" data-target="#colorsetheader2">
			<tr>
				<th colspan="4">
					<i class="fa fa-arrow-circle-down"></i>&nbsp; Dashboard Color Information
				</th>
			</tr>
		</thead>
		<tbody class="collapse" id="colorsetheader2">

			<tr>
				<th class="common_width">
					<label># Color 1 </label>
				</th>
				<td class="common_width">
					<input name="colorsettings[first][color]" id="first_color" type="text" value="<?php echo $color_data_value[0]['first']['color']?>" />
				</td>
				<td class="common_width">
					<input  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="colorsettings[first][code]" id="first_code" type="text" value="<?php echo $color_data_value[0]['first']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="first_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $color_data_value[0]['first']['code']?>"> 
				</td>
			</tr>
			<tr>
				<th class="common_width">
					<label># Color 2 </label>
				</th>
				<td class="common_width">
					<input name="colorsettings[second][color]" id="second_color" type="text" value="<?php echo $color_data_value[0]['second']['color']?>" />
				</td>
				<td class="common_width">
					<input  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="colorsettings[second][code]" id="second_code" type="text" value="<?php echo $color_data_value[0]['second']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="second_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $color_data_value[0]['second']['code']?>"> 
				</td>
				
			</tr>
			<tr>
				<th class="common_width">
					<label># Color 3 </label>
				</th>
				<td class="common_width">
					<input name="colorsettings[third][color]" id="third_color" type="text" value="<?php echo $color_data_value[0]['third']['color']?>" />
				</td>
				<td class="common_width">
					<input  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="colorsettings[third][code]" id="third_code" type="text" value="<?php echo $color_data_value[0]['third']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="third_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $color_data_value[0]['third']['code']?>"> 
				</td>
			</tr>		
			<tr>
				<th class="common_width">
					<label># Color 4 </label>
				</th>
				<td class="common_width">
					<input name="colorsettings[fourth][color]" id="fourth_color" type="text" value="<?php echo $color_data_value[0]['fourth']['color']?>" />
				</td>
				<td class="common_width">
					<input pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="colorsettings[fourth][code]" id="fourth_code" type="text" value="<?php echo $color_data_value[0]['fourth']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="fourth_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $color_data_value[0]['fourth']['code']?>"> 
				</td>
			</tr>	
			<tr>
				<th class="common_width">
					<label># Color 5 </label>
				</th>
				<td class="common_width">
					<input name="colorsettings[fifth][color]" id="fifth_color" type="text" value="<?php echo $color_data_value[0]['fifth']['color']?>" />
				</td>
				<td class="common_width">
					<input pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="colorsettings[fifth][code]" id="fifth_code" type="text" value="<?php echo $color_data_value[0]['fifth']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="fifth_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $color_data_value[0]['fifth']['code']?>"> 
				</td>
			</tr>	
			<tr>
				<th class="common_width">
					<label># Color 6 </label>
				</th>
				<td class="common_width">
					<input name="colorsettings[sixth][color]" id="sixth_color" type="text" value="<?php echo $color_data_value[0]['sixth']['color']?>" />
				</td>
				<td class="common_width">
					<input pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="colorsettings[sixth][code]" id="sixth_code" type="text" value="<?php echo $color_data_value[0]['sixth']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="sixth_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $color_data_value[0]['sixth']['code']?>"> 
				</td>
			</tr>	
			<tr>
				<th class="common_width">
					<label># Color 7 </label>
				</th>
				<td class="common_width">
					<input name="colorsettings[seventh][color]" id="seventh_color" type="text" value="<?php echo $color_data_value[0]['seventh']['color']?>" />
				</td>
				<td class="common_width">
					<input pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="colorsettings[seventh][code]" id="seventh_code" type="text" value="<?php echo $color_data_value[0]['seventh']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="seventh_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $color_data_value[0]['seventh']['code']?>"> 
				</td>
			</tr>	
			<tr>
				<th class="common_width">
					<label># Color 8 </label>
				</th>
				<td class="common_width">
					<input name="colorsettings[eight][color]" id="eight_color" type="text" value="<?php echo $color_data_value[0]['eight']['color']?>" />
				</td>
				<td class="common_width">
					<input pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="colorsettings[eight][code]" id="eight_code" type="text" value="<?php echo $color_data_value[0]['eight']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="eight_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $color_data_value[0]['eight']['code']?>"> 
				</td>
			</tr>
			<tr>
				<th class="common_width">
					<label># Color 9 </label>
				</th>
				<td class="common_width">
					<input name="colorsettings[nine][color]" id="nine_color" type="text" value="<?php echo $color_data_value[0]['nine']['color']?>" />
				</td>
				<td class="common_width">
					<input pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="colorsettings[nine][code]" id="nine_code" type="text" value="<?php echo $color_data_value[0]['nine']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="nine_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $color_data_value[0]['nine']['code']?>"> 
				</td>
			</tr>
			<tr>
				<th class="common_width">
					<label># Color 10 </label>
				</th>
				<td class="common_width">
					<input name="colorsettings[tenth][color]" id="tenth_color" type="text" value="<?php echo $color_data_value[0]['tenth']['color']?>" />
				</td>
				<td class="common_width">
					<input pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="colorsettings[tenth][code]" id="tenth_code" type="text" value="<?php echo $color_data_value[0]['tenth']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="tenth_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $color_data_value[0]['tenth']['code']?>"> 
				</td>
			</tr>							
			<tr>
				<th class="common_width">
					<label># Color 11 </label>
				</th>
				<td class="common_width">
					<input name="colorsettings[eleventh][color]" id="eleventh_color" type="text" value="<?php echo $color_data_value[0]['eleventh']['color']?>" />
				</td>
				<td class="common_width">
					<input pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="colorsettings[eleventh][code]" id="eleventh_code" type="text" value="<?php echo $color_data_value[0]['eleventh']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="eleventh_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $color_data_value[0]['eleventh']['code']?>"> 
				</td>
			</tr>							
			<tr>
				<th class="common_width">
					<label># Color 12 </label>
				</th>
				<td class="common_width">
					<input name="colorsettings[twelfth][color]" id="twelfth_color" type="text" value="<?php echo $color_data_value[0]['twelfth']['color']?>" />
				</td>
				<td class="common_width">
					<input pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="colorsettings[twelfth][code]" id="twelfth_code" type="text" value="<?php echo $color_data_value[0]['twelfth']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="twelfth_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $color_data_value[0]['twelfth']['code']?>"> 
				</td>
			</tr>							
			<tr>
				<th class="common_width">
					<label># Color 13 </label>
				</th>
				<td class="common_width">
					<input name="colorsettings[thirteen][color]" id="thirteen_color" type="text" value="<?php echo $color_data_value[0]['thirteen']['color']?>" />
				</td>
				<td class="common_width">
					<input pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="colorsettings[thirteen][code]" id="thirteen_code" type="text" value="<?php echo $color_data_value[0]['thirteen']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="thirteen_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $color_data_value[0]['thirteen']['code']?>"> 
				</td>
			</tr>							
			<tr>
				<th class="common_width">
					<label># Color 14 </label>
				</th>
				<td class="common_width">
					<input name="colorsettings[fourteen][color]" id="fourteen_color" type="text" value="<?php echo $color_data_value[0]['fourteen']['color']?>" />
				</td>
				<td class="common_width">
					<input pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="colorsettings[fourteen][code]" id="fourteen_code" type="text" value="<?php echo $color_data_value[0]['fourteen']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="fourteen_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $color_data_value[0]['fourteen']['code']?>"> 
				</td>
			</tr>							
			<tr>
				<th class="common_width">
					<label># Color 15 </label>
				</th>
				<td class="common_width">
					<input name="colorsettings[fifteen][color]" id="fifteen_color" type="text" value="<?php echo $color_data_value[0]['fifteen']['color']?>" />
					<input type="hidden" id="setname_value" name="colorsettings[setname]" value="<?php echo $color_data_value[0]['setname']?>" />
				</td>
				<td class="common_width">
					<input pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="colorsettings[fifteen][code]" id="fifteen_code" type="text" value="<?php echo $color_data_value[0]['fifteen']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="fifteen_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $color_data_value[0]['fifteen']['code']?>"> 
				</td>
			</tr>

		</tbody>
	</table>	


	<table class="basicTable inputs" border="0" style="margin-top: 27px;">
		<thead data-toggle="collapse">
			<tr>
				<th colspan="4">
					 &nbsp; Mobile/Dashboard Color Settings
				</th>
			</tr>
		</thead>
		<thead data-toggle="collapse" data-target="#mobcolorsetheader1">
			<tr>
				<th colspan="4">
					<i class="fa fa-arrow-circle-down"></i>&nbsp; Mobile/Scan Color Set
				</th>
			</tr>
		</thead>
		<tbody class="collapse" id="mobcolorsetheader1">
			<tr >
				<th  style="vertical-align:top">Select Type Of Color Set </th>
				<td > 

					<select id="mobtypeofcolorset" name="mobtypeofcolorset" style="width:100%;">
						<option <?php if($mob_color_type_set_data == 'select') echo 'selected';?> value="select">Select</option>
						<option <?php if($mob_color_type_set_data == 'standard') echo 'selected';?> value="standard">Standard Color Set</option>
						<option <?php if($mob_color_type_set_data == 'manual') echo 'selected';?> value="manual">Manual Color Set</option>
					</select>	
				</td>
			</tr>			
			<tr id="mobstandard_color_set_tr" style="display: <?php if($mob_color_type_set_data == 'manual' || $mob_color_type_set_data == 'select') echo 'none';?>">
				<th  style="vertical-align:top">Standard Color Set </th>
				<td > 
					<select id="mobcolorsetdropdown" name="mobcolorsetdropdown" style="width:100%;">
						<option value="select">Select</option>
						<?php foreach ($mob_color_palette_data as $keyColorSet => $valueColorSet){ ?>
							<option  <?php if($mob_color_set_data == $keyColorSet) echo 'selected';?> value="<?php echo $keyColorSet;?>"><?php echo $valueColorSet['setname'];?></option><?php } ?>
					</select>	
				</td>
			</tr>				
 			<tr id="mobmanual_color_set_tr" style="display: <?php if($mob_color_type_set_data == 'standard' || $mob_color_type_set_data == 'select') echo 'none';?>">
				<th  style="vertical-align:top">Manual Color Set </th>
				<td > 

					<select id="mobcolorsetdropdownmanual" name="mobcolorsetdropdownmanual" style="width:100%;">
						<option value="select">Select</option>
						<?php foreach ($mob_color_palette_data_manaual as $keyColorSet => $valueColorSet){ ?>
							<option  <?php if($mob_color_set_data == $keyColorSet) echo 'selected';?> value="<?php echo $keyColorSet;?>"><?php echo $valueColorSet['setname'];?></option><?php } ?>
					</select>	
				</td>
			</tr> 
		</tbody>	
		<thead data-toggle="collapse" data-target="#mobcolorsetheader2">
			<tr>
				<th colspan="4">
					<i class="fa fa-arrow-circle-down"></i>&nbsp; Mobile/Scan Color Information
				</th>
			</tr>
		</thead>
		<tbody class="collapse" id="mobcolorsetheader2">

			<tr>
				<th class="common_width">
					<label># Color 1 </label>
				</th>
				<td class="common_width">
					<input name="mobcolorsettings[first][color]" id="mobfirst_color" type="text" value="<?php echo $mob_color_data_value[0]['first']['color']?>" />
				</td>
				<td class="common_width">
					<input  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="mobcolorsettings[first][code]" id="mobfirst_code" type="text" value="<?php echo $mob_color_data_value[0]['first']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="mobfirst_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $mob_color_data_value[0]['first']['code']?>"> 
				</td>
			</tr>
			<tr>
				<th class="common_width">
					<label># Color 2 </label>
				</th>
				<td class="common_width">
					<input name="mobcolorsettings[second][color]" id="mobsecond_color" type="text" value="<?php echo $mob_color_data_value[0]['second']['color']?>" />
				</td>
				<td class="common_width">
					<input  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="mobcolorsettings[second][code]" id="mobsecond_code" type="text" value="<?php echo $mob_color_data_value[0]['second']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="mobsecond_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $mob_color_data_value[0]['second']['code']?>"> 
				</td>
				
			</tr>
			<tr>
				<th class="common_width">
					<label># Color 3 </label>
				</th>
				<td class="common_width">
					<input name="mobcolorsettings[third][color]" id="mobthird_color" type="text" value="<?php echo $mob_color_data_value[0]['third']['color']?>" />
				</td>
				<td class="common_width">
					<input  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="mobcolorsettings[third][code]" id="mobthird_code" type="text" value="<?php echo $mob_color_data_value[0]['third']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="mobthird_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $mob_color_data_value[0]['third']['code']?>"> 
				</td>
			</tr>		
			<tr>
				<th class="common_width">
					<label># Color 4 </label>
				</th>
				<td class="common_width">
					<input name="mobcolorsettings[fourth][color]" id="mobfourth_color" type="text" value="<?php echo $mob_color_data_value[0]['fourth']['color']?>" />
				</td>
				<td class="common_width">
					<input pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="mobcolorsettings[fourth][code]" id="mobfourth_code" type="text" value="<?php echo $mob_color_data_value[0]['fourth']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="mobfourth_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $mob_color_data_value[0]['fourth']['code']?>"> 
				</td>
			</tr>	
			<tr>
				<th class="common_width">
					<label># Color 5 </label>
				</th>
				<td class="common_width">
					<input name="mobcolorsettings[fifth][color]" id="mobfifth_color" type="text" value="<?php echo $mob_color_data_value[0]['fifth']['color']?>" />
				</td>
				<td class="common_width">
					<input pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="mobcolorsettings[fifth][code]" id="mobfifth_code" type="text" value="<?php echo $mob_color_data_value[0]['fifth']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="mobfifth_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $mob_color_data_value[0]['fifth']['code']?>"> 
				</td>
			</tr>	
			<tr>
				<th class="common_width">
					<label># Color 6 </label>
				</th>
				<td class="common_width">
					<input name="mobcolorsettings[sixth][color]" id="mobsixth_color" type="text" value="<?php echo $mob_color_data_value[0]['sixth']['color']?>" />
				</td>
				<td class="common_width">
					<input pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="mobcolorsettings[sixth][code]" id="mobsixth_code" type="text" value="<?php echo $mob_color_data_value[0]['sixth']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="mobsixth_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $mob_color_data_value[0]['sixth']['code']?>"> 
				</td>
			</tr>	
			<tr>
				<th class="common_width">
					<label># Color 7 </label>
				</th>
				<td class="common_width">
					<input name="mobcolorsettings[seventh][color]" id="mobseventh_color" type="text" value="<?php echo $mob_color_data_value[0]['seventh']['color']?>" />
				</td>
				<td class="common_width">
					<input pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="mobcolorsettings[seventh][code]" id="mobseventh_code" type="text" value="<?php echo $mob_color_data_value[0]['seventh']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="mobseventh_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $mob_color_data_value[0]['seventh']['code']?>"> 
				</td>
			</tr>	
			<tr>
				<th class="common_width">
					<label># Color 8 </label>
				</th>
				<td class="common_width">
					<input name="mobcolorsettings[eight][color]" id="mobeight_color" type="text" value="<?php echo $mob_color_data_value[0]['eight']['color']?>" />
				</td>
				<td class="common_width">
					<input pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="mobcolorsettings[eight][code]" id="mobeight_code" type="text" value="<?php echo $mob_color_data_value[0]['eight']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="mobeight_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $mob_color_data_value[0]['eight']['code']?>"> 
				</td>
			</tr>
			<tr>
				<th class="common_width">
					<label># Color 9 </label>
				</th>
				<td class="common_width">
					<input name="mobcolorsettings[nine][color]" id="mobnine_color" type="text" value="<?php echo $mob_color_data_value[0]['nine']['color']?>" />
				</td>
				<td class="common_width">
					<input pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="mobcolorsettings[nine][code]" id="mobnine_code" type="text" value="<?php echo $mob_color_data_value[0]['nine']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="mobnine_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $mob_color_data_value[0]['nine']['code']?>"> 
				</td>
			</tr>
			<tr>
				<th class="common_width">
					<label># Color 10 </label>
				</th>
				<td class="common_width">
					<input name="mobcolorsettings[tenth][color]" id="mobtenth_color" type="text" value="<?php echo $mob_color_data_value[0]['tenth']['color']?>" />
				</td>
				<td class="common_width">
					<input pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="mobcolorsettings[tenth][code]" id="mobtenth_code" type="text" value="<?php echo $mob_color_data_value[0]['tenth']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="mobtenth_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $mob_color_data_value[0]['tenth']['code']?>"> 
				</td>
			</tr>							
			<tr>
				<th class="common_width">
					<label># Color 11 </label>
				</th>
				<td class="common_width">
					<input name="mobcolorsettings[eleventh][color]" id="mobeleventh_color" type="text" value="<?php echo $mob_color_data_value[0]['eleventh']['color']?>" />
				</td>
				<td class="common_width">
					<input pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="mobcolorsettings[eleventh][code]" id="mobeleventh_code" type="text" value="<?php echo $mob_color_data_value[0]['eleventh']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="mobeleventh_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $mob_color_data_value[0]['eleventh']['code']?>"> 
				</td>
			</tr>							
			<tr>
				<th class="common_width">
					<label># Color 12 </label>
				</th>
				<td class="common_width">
					<input name="mobcolorsettings[twelfth][color]" id="mobtwelfth_color" type="text" value="<?php echo $mob_color_data_value[0]['twelfth']['color']?>" />
				</td>
				<td class="common_width">
					<input pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="mobcolorsettings[twelfth][code]" id="mobtwelfth_code" type="text" value="<?php echo $mob_color_data_value[0]['twelfth']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="mobtwelfth_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $mob_color_data_value[0]['twelfth']['code']?>"> 
				</td>
			</tr>							
			<tr>
				<th class="common_width">
					<label># Color 13 </label>
				</th>
				<td class="common_width">
					<input name="mobcolorsettings[thirteen][color]" id="mobthirteen_color" type="text" value="<?php echo $mob_color_data_value[0]['thirteen']['color']?>" />
				</td>
				<td class="common_width">
					<input pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="mobcolorsettings[thirteen][code]" id="mobthirteen_code" type="text" value="<?php echo $mob_color_data_value[0]['thirteen']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="mobthirteen_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $mob_color_data_value[0]['thirteen']['code']?>"> 
				</td>
			</tr>							
			<tr>
				<th class="common_width">
					<label># Color 14 </label>
				</th>
				<td class="common_width">
					<input name="mobcolorsettings[fourteen][color]" id="mobfourteen_color" type="text" value="<?php echo $mob_color_data_value[0]['fourteen']['color']?>" />
				</td>
				<td class="common_width">
					<input pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="mobcolorsettings[fourteen][code]" id="mobfourteen_code" type="text" value="<?php echo $mob_color_data_value[0]['fourteen']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="mobfourteen_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $mob_color_data_value[0]['fourteen']['code']?>"> 
				</td>
			</tr>							
			<tr>
				<th class="common_width">
					<label># Color 15 </label>
				</th>
				<td class="common_width">
					<input name="mobcolorsettings[fifteen][color]" id="mobfifteen_color" type="text" value="<?php echo $mob_color_data_value[0]['fifteen']['color']?>" />
					<input type="hidden" id="mobsetname_value" name="mobcolorsettings[setname]" value="<?php echo $mob_color_data_value[0]['setname']?>" />
				</td>
				<td class="common_width">
					<input pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" name="mobcolorsettings[fifteen][code]" id="mobfifteen_code" type="text" value="<?php echo $mob_color_data_value[0]['fifteen']['code']?>" />
				</td>
				<td class="common_width">
					<input class="colorselectorClass" type="color" id="mobfifteen_color_picker"  pattern="^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$" value="<?php echo $mob_color_data_value[0]['fifteen']['code']?>"> 
				</td>
			</tr>

		</tbody>
	</table>
	
	<div style="height:0px"></div>
	

