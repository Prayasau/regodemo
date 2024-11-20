<!------ ModifyOrgmdl Modal  -------->
<div class="modal fade" id="ModifyOrgmdl" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Organization']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

			</div>
			<div class="modal-footer">
				<button type="button" class="close" data-dismiss="modal" class="btn btn-primary btn-fr"><?=$lng['Close']?></button>  
			</div>
		</div>
	</div>
</div>
<!------ ModifyOrgmdl Modal  -------->				

<!------ modify data Modal  -------->
<div class="modal fade" id="modalmodify" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<div class="tab"> 

					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Select Item']?></th>
							</tr>
						</thead>
					</table>

					<div class="sel-field">
						<label>
							<input type="checkbox" name="position" value="" class="per checkbox style-0">
							<span> <?=$lng['Position']?></span>
						</label>
					</div>

					<div class="sel-field">
						<label>
							<input type="checkbox" name="organization" value="" class="per checkbox style-0">
							<span> <?=$lng['Organization']?></span>
						</label>
					</div>

					<? if($parameters[5]['apply_param'] == 1){ ?>
						<div class="sel-field">
							<label>
								<input type="checkbox" name="group" value="" class="per checkbox style-0">
								<span> <?=$lng['Groups']?></span>
							</label>
						</div>
					<? } ?>

				</div>

				<div class="tab" style="display: none;">
					<form id="mkchoice">
						<input type="hidden" name="empids" id="empallids">
						<table class="basicTable inputs" id="makeSelection" border="0">
							<thead>
								<tr>
									<th colspan="2"><?=$lng['Make choice']?> 
										<!-- <button id="ModifyOrg" type="button" class="btn btn-primary btn-sm btn-fr"><?=$lng['Modify Organization']?></button> -->
									</th>
								</tr>
							</thead>
							<tbody>
								<tr id="positions">
									<th><?=$lng['Position']?></th>
									<td>
										<select name="positionss" style="width: 100%;">
											<option value="" selected disabled="disabled"><?=$lng['Please select']?></option>
											<? foreach($positions as $k=>$v){ ?>
												<option value="<?=$k?>"><?=$v[$lang]?></option>
											<? } ?>
										</select>
									</td>
								</tr>
								<tr id="organizations">
									<th><?=$lng['Organization']?></th>
									<td>
										<select name="organizationss" style="width: 100%;">
											<option value=""><?=$lng['Please select']?></option>
											<? foreach($organization as $k=>$v){ ?>
												<option value="<?=$k?>">
													<? 
														$branVal = $diviVal = $deptVal = $teamVal = '';
														if($parameters[1]['apply_param'] == 1){ 
															$branVal = ' → '.$branches[$v['locations']][$lang];
														}
														if($parameters[2]['apply_param'] == 1){ 
															$diviVal = ' → '.$divisions[$v['divisions']][$lang];
														}
														if($parameters[3]['apply_param'] == 1){ 
															$deptVal = ' → '.$departments[$v['departments']][$lang];
														}
														if($parameters[4]['apply_param'] == 1){ 
															$teamVal = ' → '.$teams[$v['teams']][$lang];
														}
													?>
													<?=$entities[$v['company']][$lang].$branVal.$diviVal.$deptVal.$teamVal?>
														
													</option>
											<? } ?>
										</select>
									</td>
								</tr>
								<tr id="groups">
									<th><?=$lng['Groups']?></th>
									<td>
										<select name="groupss" style="width: 100%;">
											<option value=""><?=$lng['Please select']?></option>
											<? foreach($groups as $k=>$v){ ?>
												<option value="<?=$k?>"><?=$v[$lang]?></option>
											<? } ?>
										</select>
									</td>
								</tr>
							</tbody>
						</table>
					</form>

				</div>

				
			</div>

			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" class="btn btn-primary btn-fl" id="prevBtn" onclick="nextPrev(-1)"><?=$lng['Prev']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="nextBtn" onclick="nextPrev(1)"><?=$lng['Next']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>



<!------ modify data Nationality Modal  -------->
<div class="modal fade" id="modalmodify_nationality" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Nationality Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><?=$lng['Nationality']?></th>
								<td>
									<input placeholder="__" name="modal_nationality_value" id="modal_nationality_value" type="text" value="" />
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModal('nationality');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>


<!------ modify data gender Modal  -------->
<div class="modal fade" id="modalmodify_gender" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Gender Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Select Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><?=$lng['Gender']?></th>
								<td>
									<select style="width: 100%;" id="modal_gender_value" name="modal_gender_value">
									<option value="select"  ><?=$lng['Select']?></option>

									<? foreach($gender as $k=>$v){ ?>
										<option <? if($data['gender'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v?></option>
									<? } ?>
									</select>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModal('gender');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>

<!------ modify data maritail status  Modal  -------->
<div class="modal fade" id="modalmodify_maritial" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Maritial Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Select Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><?=$lng['Maritial status']?></th>
								<td>
									<select style="width: 100%;" id="modal_maritial_value" name="modal_maritial_value">
										<option value="select"  ><?=$lng['Select']?></option>
										<? foreach($maritial as $k=>$v){ ?>
										<option <? if($data['maritial'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v?></option>
									<? } ?>
									</select>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModal('maritial')"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>


<!------ modify data Religion status  Modal  -------->
<div class="modal fade" id="modalmodify_religion" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Religion Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Select Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><?=$lng['Religion']?></th>
								<td>
									<select style="width: 100%;" id="modal_religion_value" name="modal_religion_value">
										<option value="select"  ><?=$lng['Select']?></option>
									<? foreach($religion as $k=>$v){ ?>
										<option <? if($data['religion'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v?></option>
									<? } ?>
									</select>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submitreligion" onclick="submitPopupModal('religion');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>


<!------ modify data first name  Modal  -------->
<div class="modal fade" id="modalmodify_firstname" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify First name Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><?=$lng['First name']?></th>
								<td>
									<input placeholder="__" name="modal_firstname_value" id="modal_firstname_value" type="text" value="" />
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModal('firstname');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>

<!------ modify data last name  Modal  -------->
<div class="modal fade" id="modalmodify_lastname" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Lastname Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><?=$lng['Last name']?></th>
								<td>
									<input placeholder="__" name="modal_lastname_value" id="modal_lastname_value" type="text" value="" />
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit"  onclick="submitPopupModal('lastname')"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>

<!------ modify data name in english Modal  -------->
<div class="modal fade" id="modalmodify_englishname" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Name In English Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><?=$lng['Name in English']?></th>
								<td>
									<input placeholder="__" name="modal_englishname_value" id="modal_englishname_value" type="text" value="" />
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModal('en_name')"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>

<!------ modify data scan id  Modal  -------->
<div class="modal fade" id="modalmodify_scanid" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Scan Id Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><?=$lng['Scan ID']?></th>
								<td>
									<input placeholder="__" name="scan_id_modal" id="scan_id_modal" type="text" value="" />
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submitscanid" onclick="submitPopupModal('sid');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>

<!------ modify data title  Modal  -------->
<div class="modal fade" id="modalmodify_title" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Title Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><?=$lng['Title']?></th>
								<td>
									<select style="width: 100%;" id="modal_title_value" name="modal_title_value">
										<option value="select"  ><?=$lng['Select']?></option>
									<? foreach($title as $k=>$v){ ?>
									<option <? if($data['title'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v?></option>
								<? } ?>
									</select>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr " id="submittitle" onclick="submitPopupModal('title');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>


<!------ modify data military status  Modal  -------->
<div class="modal fade" id="modalmodify_military" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Military Status Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><?=$lng['Military status']?></th>
								<td>
									<select style="width: 100%;" id="modal_military_value" name="modal_military_value" >
										<option value="select"  ><?=$lng['Select']?></option>
									<? foreach($military_status as $k=>$v){ ?>
										<option <? if($data['military_status'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v?></option>
									<? } ?>
									</select>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModal('military_status')"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>

<!------ modify data height  Modal  -------->
<div class="modal fade" id="modalmodify_height" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Height Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><?=$lng['Height']?></th>
								<td>
									<input placeholder="__" name="modal_height_value" id="modal_height_value" type="text" value="" />
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModal('height')" ><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>

<!------ modify data weight  Modal  -------->
<div class="modal fade" id="modalmodify_weight" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Weight Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><?=$lng['Weight']?></th>
								<td>
									<input placeholder="__" name="modal_weight_value" id="modal_weight_value" type="text" value="" />
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModal('weight');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>


<!------ modify data blood type  Modal  -------->
<div class="modal fade" id="modalmodify_bloodtype" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Blood Type Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><?=$lng['Blood type']?></th>
								<td>
									<input placeholder="__" name="modal_blood_type_value" id="modal_blood_type_value" type="text" value="" />
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModal('bloodtype')"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>

<!------ modify data driving license  Modal  -------->
<div class="modal fade" id="modalmodify_driving_license" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Driving License Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><?=$lng['Driving license No.']?></th>
								<td>
									<input placeholder="__" name="modal_driving_license_value" id="modal_driving_license_value" type="text" value="" />
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModal('drvlicense_nr')"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>

<!------ modify data license expiry data  Modal  -------->
<div class="modal fade" id="modalmodify_driving_license_date" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify License Expiry Date Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><?=$lng['License expiry date']?></th>
								<td>
									<input class="date_year" placeholder="__" name="modal_driving_license_date_value" id="modal_driving_license_date_value" type="text" value="" />
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModal('drvlicense_exp')"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>
<!------ modify data id card data  Modal  -------->
<div class="modal fade" id="modalmodify_id_card" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify ID Card Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><?=$lng['ID card']?></th>
								<td>
									<input placeholder="__" name="modal_id_card_value" id="modal_id_card_value" type="text" value="" />
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModal('idcard_nr')"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>

<!------ modify data scan id  Modal  -------->
<div class="modal fade" id="modalmodify_id_card_expiry_date" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify ID Card Expiry Date Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><?=$lng['ID card expiry date']?></th>
								<td>
									<input class="date_year" placeholder="__" name="modal_id_card_expiry_value" id="modal_id_card_expiry_value" type="text" value="" />
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModal('idcard_exp')"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>

<!------ modify data scan id  Modal  -------->
<div class="modal fade" id="modalmodify_tax_id" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Tax ID Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><?=$lng['Tax ID no.']?></th>
								<td>
									<input placeholder="__" name="modal_tax_id_value"  id = "modal_tax_id_value"  type="text" value="" />
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModal('tax_id');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>

<!------ modify data scan id  Modal  -------->
<div class="modal fade" id="modalmodify_birthdate" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Birthdate Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><?=$lng['Birthdate']?></th>
								<td>
									<input class="date_year" placeholder="__" name="modal_birthdate_value"  id = "modal_birthdate_value"  type="text" value="" />
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModal('birthdate');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>



<!------ View Teams Modal  -------->
<div class="modal fade" id="modalViewTeams" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; Selected Employees</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="viewTeamsTable" border="0">
						<thead>
							<tr>
								<th class="text-center"><?=$lng['Employee ID']?></th>
								<th class="text-center"><?=$lng['Employee name']?></th>
							<!-- 	<th class="text-center"><?=$lng['Field Changed']?></th>
								<th class="text-center"><?=$lng['Previous value']?></th>
								<th class="text-center"><?=$lng['New value']?></th> -->
							</tr>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>


<!------ View Fields Modal  -------->
<div class="modal fade" id="modalViewFields" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 500px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Employees Updated']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="viewFieldsTable" border="0">
						<thead>
							<tr>
								<th class="text-center"><?=$lng['Employee ID']?></th>
								<th class="text-center"><?=$lng['Employee name']?></th>
							</tr>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>
<!------ View Error Modal  -------->
<div class="modal fade" id="modalViewErrors" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 640px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Errors during import']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="viewFieldsTable" border="0">
						<thead>
							<tr>
								<th class="text-center"><?=$lng['Employee ID']?></th>
								<th class="text-center"><?=$lng['Employee name']?></th>
								<th class="text-center"><?=$lng['Field']?></th>
								<th class="text-center"><?=$lng['Error Type']?></th>
							</tr>
						<tbody>
							<?php 
							if(isset($getAllTempLogErrors))
							{
								foreach ($getAllTempLogErrors as $key => $value) { ?>
						
									<tr>
										<td class="text-center"><?php echo $value['emp_id'];?></td>
										<td class="text-center"><?php echo $value['en_name'];?></td>
										<td class="text-center"><?php echo $value['field'];?></td>
										<td class="text-center">Invalid data entered</td>
									</tr>

						<?php	}
							}

							?>
							
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>




<!------ EDIT data text field Modal  -------->
<div class="modal fade" id="modalEdit_text_field" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="text_field_span"></span></th>
								<td>
									<input placeholder="__" name="modal_edit_text_value" id="modal_edit_text_value" type="text" value="" />
									<input type="hidden" name="hidden_row_id" id="hidden_row_id" value="">
									<input type="hidden" name="hidden_field_to_update" id="hidden_field_to_update" value="">
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalEdit('text');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>


<!------ EDIT data drop down field Modal  -------->
<div class="modal fade" id="modalEdit_drop_down" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Edit Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="dropdown_field_span"></span></th>
								
								<td>
									<select style="width: 100%;" id="modal_edit_dropdown_value" name="modal_edit_dropdown_value">
									<option value="select"  ><?=$lng['Select']?></option>
		
									</select>

									
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalEdit('dropdown');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>

<!------ EDIT data date field Modal  -------->
<div class="modal fade" id="modalEdit_date_field" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="date_field_span"></span></th>

								<td>
									<input class="date_year" placeholder="__" name="modal_edit_date_value" id="modal_edit_date_value" type="text" value="" />
									
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalEdit('date');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>


<!-------------------------------------------- COMMON MODAL FOR CONTACTS SECTION ---------------------------------------------------->

<div class="modal fade" id="modal_contacts_common_text" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="contacts_text_field_span"></span></th>
								<td>
									<input placeholder="__" name="modal_edit_contact_text_value" id="modal_edit_contact_text_value" type="text" value="" />
									<input type="hidden" name="contact_hidden_field_to_update" id="contact_hidden_field_to_update" value="">
									<input type="hidden" name="contact_hidden_which_modal" id="contact_hidden_which_modal" value="">

								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalCommonContact();"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>

<div class="modal fade" id="modal_contacts_common_dropdown" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="contacts_dropdown_field_span"></span></th>
								<td>

									<select style="width: 100%;" id="modal_edit_contact_dropdown_value" name="modal_edit_contact_dropdown_value">
										<option value="select"  ><?=$lng['Select']?></option>
										<? foreach($username_option as $k=>$v){ ?>
											<option value="<?=$k?>"><?=$v?></option>
										<? } ?>
									</select>
									<input type="hidden" name="contact_hidden_dropdown_field_to_update" id="contact_hidden_dropdown_field_to_update" value="">
									<input type="hidden" name="contact_hidden_dropdown_which_modal" id="contact_hidden_dropdown_which_modal" value="">

								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalCommonContactDropdown();"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>



<!-------------------------------------------- COMMON MODAL FOR CONTACTS SECTION ---------------------------------------------------->

<div class="modal fade" id="modal_contacts_common_text_edit" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="contacts_text_field_span_edit"></span></th>
								<td>
									<input placeholder="__" name="modal_edit_contact_text_value_edit" id="modal_edit_contact_text_value_edit" type="text" value="" />
									<input type="hidden" name="contact_hidden_field_to_update_edit" id="contact_hidden_field_to_update_edit" value="">
									<input type="hidden" name="contact_hidden_row_id" id="contact_hidden_row_id" value="">

								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalCommonContactOnclick('text');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>


<!-------------------------------------------- COMMON MODAL FOR CONTACTS SECTION ---------------------------------------------------->

<!-------------------------------------------- COMMON MODAL FOR WORK DATA SECTION ---------------------------------------------------->

<div class="modal fade" id="modalEdit_date_field_work_data" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="date_field_span_work_data"></span></th>

								<td>
									<input class="date_year" placeholder="__" name="modal_edit_date_value_work_data" id="modal_edit_date_value_work_data" type="text" value="" />
									<input type="hidden" name="work_data_hidden_field_to_update" id="work_data_hidden_field_to_update" value="">

									
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalEditWorkdata('date');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>


<!-------------------------------------------- COMMON MODAL FOR WORK DATA SECTION ---------------------------------------------------->

<!-------------------------------------------- COMMON MODAL FOR WORK DATA SECTION ---------------------------------------------------->

<div class="modal fade" id="modalEdit_dropdown_field_work_data" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="dropdown_field_span_work_data"></span></th>

								<td>
									<select style="width: 100%;" id="modal_edit_dropdown_value_work_data" name="modal_edit_dropdown_value_work_data" class="displayNone">
										<option value="select"  ><?=$lng['Select']?></option>
										<? foreach($emp_type as $k=>$v){ ?>
											<option value="<?=$k?>"><?=$v?></option>
										<? } ?>
									</select>				

									<select style="width: 100%;" id="modal_edit_dropdown_value_account_work_data" name="modal_edit_dropdown_value_account_work_data" class="displayNone">
										<option value="select"  ><?=$lng['Select']?></option>
										<option  value="0"><?=$lng['Direct']?></option>
										<option  value="1"><?=$lng['Indirect']?></option>
									</select>		

									<select style="width: 100%;" id="modal_edit_dropdown_value_groups_work_data" name="modal_edit_dropdown_value_groups_work_data" class="displayNone">
										<option value="select"  ><?=$lng['Select']?></option>
										<? foreach($getAllGroups as $k=>$v){ ?>
											<option value="<?=$k?>"><?=$v?></option>
										<? } ?>
									</select>

									<input type="hidden" name="work_data_hidden_field_to_update_dropdown" id="work_data_hidden_field_to_update_dropdown" value="">
									
									
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalEditWorkdata('dropdown');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>


<!-------------------------------------------- COMMON MODAL FOR WORK DATA SECTION ---------------------------------------------------->


<!-------------------------------------------- COMMON MODAL FOR WORK DATA SECTION ---------------------------------------------------->

<div class="modal fade" id="modal_workdata_common_text_edit" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="workdata_text_field_span_edit"></span></th>
								<td>
									<input class="date_year" placeholder="__" name="modal_edit_workdata_text_value_edit" id="modal_edit_workdata_text_value_edit" type="text" value="" />
									<input type="hidden" name="workdata_hidden_field_to_update_edit" id="workdata_hidden_field_to_update_edit" value="">
									<input type="hidden" name="workdata_hidden_row_id" id="workdata_hidden_row_id" value="">

								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalCommonWorkDataOnclick('text');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>




<div class="modal fade" id="modalEdit_workdata_drop_down" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="workdata_dropdown_field_span"></span></th>

								<td>
									<select style="width: 100%;" id="modal_edit_workdata_dropdown_value" name="modal_edit_workdata_dropdown_value" >
										<option value="select"  ><?=$lng['Select']?></option>
									</select>				
							

									<input type="hidden" name="work_data_hidden_field_to_update_dropdown" id="work_data_hidden_field_to_update_dropdown" value="">
									
									
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalCommonWorkDataOnclick('dropdown');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>


<!-------------------------------------------- COMMON MODAL FOR WORK DATA SECTION ---------------------------------------------------->



<div class="modal fade" id="modalEdit_contact_drop_down" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="contact_dropdown_field_span"></span></th>

								<td>
									<select style="width: 100%;" id="modal_contact_edit_dropdown_value" name="modal_contact_edit_dropdown_value" >
										<option value="select"  ><?=$lng['Select']?></option>
									</select>				
							
									
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalCommonContactOnclick('dropdown');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>



<!-------------------------------------------- COMMON MODAL FOR TIME SECTION ---------------------------------------------------->

<div class="modal fade" id="modalEdit_dropdown_field_time_data" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="dropdown_field_span_time_data"></span></th>

								<td>
									<select style="width: 100%;" id="modal_edit_dropdown_time_reg_value" name="modal_edit_dropdown_time_reg_value" class="displayNone">
										<option value="select"  ><?=$lng['Select']?></option>
										<? foreach($time_regArray as $k=>$v){ ?>
											<option value="<?=$k?>"><?=$v?></option>
										<? } ?>
									</select>				

									<select style="width: 100%;" id="modal_edit_dropdown_selfie_time" name="modal_edit_dropdown_selfie_time" class="displayNone">
										<option value="select"  ><?=$lng['Select']?></option>
										<? foreach($selfieArray as $k=>$v){ ?>
											<option value="<?=$k?>"><?=$v?></option>
										<? } ?>
									</select>		

									<select style="width: 100%;" id="modal_edit_dropdown_workFromhome_time" name="modal_edit_dropdown_workFromhome_time" class="displayNone">
										<option value="select"  ><?=$lng['Select']?></option>
										<? foreach($workFromHomeArray as $k=>$v){ ?>
											<option value="<?=$k?>"><?=$v?></option>
										<? } ?>
							
									</select>

									<input type="hidden" name="time_data_hidden_field_to_update_dropdown" id="time_data_hidden_field_to_update_dropdown" value="">
									
									
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalEditTimedata('dropdown');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>


<div class="modal fade" id="modalEdit_timedata_drop_down" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="timedata_dropdown_field_span"></span></th>

								<td>
									<select style="width: 100%;" id="modal_edit_timedata_dropdown_value" name="modal_edit_workdata_dropdown_value" >
										<option value="select"  ><?=$lng['Select']?></option>
									</select>				
							

									<input type="hidden" name="time_data_hidden_field_to_update_dropdown" id="time_data_hidden_field_to_update_dropdown" value="">

									<input type="hidden" name="timedata_hidden_row_id" id="timedata_hidden_row_id" value="">
									
									
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalCommonTimeDataOnclick('dropdown');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>

<!-------------------------------------------- COMMON MODAL FOR TIME SECTION ---------------------------------------------------->


	<!-- Modal organization selection -->
	<div class="modal fade" id="modalorganization" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fa fa-building-o"></i>&nbsp; <?=$lng['Organization Chart']?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h2 class="text-danger text-center font-italic">
						<?=$lng['Reduce the number until 1 remains for each item']?>
					</h2>
					<table id="usersAccess" class="basicTable" style="margin-top:5px; width:100%; table-layout:auto;">
						<thead>
							<tr style="line-height:100%; background:#09c; color:#fff; border-bottom:1px solid #06a">
								
								<?if(count($entities) > 1){ ?>
									<th style="color:#fff"><?=$lng['Company']?></th>
								<? } ?>
								<? if($parameters[1]['apply_param'] == 1){ ?>
									<th style="color:#fff"><?=$parameters[1][$lang]?></th>
								<? } ?>
								<? if($parameters[2]['apply_param'] == 1){ ?>
									<th style="color:#fff"><?=$parameters[2][$lang]?></th>
								<? } ?>
								<? if($parameters[3]['apply_param'] == 1){ ?>
									<th style="color:#fff"><?=$parameters[3][$lang]?></th>
								<? } ?>
								<? if($parameters[4]['apply_param'] == 1){ ?>
									<th style="color:#fff"><?=$parameters[4][$lang]?></th>
								<? } ?>

							
							</tr>
						</thead>
						<tbody>
							<tr style="background:#f9f9f9">
									
								<?if(count($entities) > 1){ ?>
									<td style="padding:0">
										<select class="orgSel" name="entities" id="userEntities">
										<option selected="selected" disabled="disabled" value="">Select one</option>
										<? foreach($entities as $k=>$v){ ?>
											<option value="<?=$k?>"><?=$v[$lang]?></option>
										<? } ?>
										</select>
										
									</td>
								<? } ?>
								
								<? if($parameters[1]['apply_param'] == 1){ ?>
									<td style="padding:0">
										<select class="orgSel" name="branches"  id="userBranches">
										<option selected="selected" disabled="disabled" value="">Select one</option>
										<? foreach($branches as $k=>$v){ ?>
											<option value="<?=$k?>"><?=$v[$lang]?></option>
										<? } ?>
										</select>	
										
									</td>
								<? } ?>
								<? if($parameters[2]['apply_param'] == 1){ ?>
									<td style="padding:0">
										<select class="orgSel" name="divisions" id="userDivisions">
										<option selected="selected" disabled="disabled" value="">Select one</option>
										<? foreach($divisions as $k=>$v){ ?>
											<option value="<?=$k?>"><?=$v[$lang]?></option>
										<? } ?>
										</select>	
										
									</td>
								<? } ?>
								<? if($parameters[3]['apply_param'] == 1){ ?>
									<td style="padding:0">
										<select class="orgSel" name="departments" id="userDepartments">
										<option selected="selected" disabled="disabled" value="">Select one</option>
										<? foreach($departments as $k=>$v){ ?>
											<option value="<?=$k?>"><?=$v[$lang]?></option>
										<? } ?>
										</select>	
										
									</td>
								<? } ?>
								<? if($parameters[4]['apply_param'] == 1){ ?>
									<td style="padding:0">
										<select class="orgSel" name="teams"  id="userTeams">
										<option selected="selected" disabled="disabled" value="">Select one</option>
										<? foreach($teams as $k=>$v){ ?>
											<option value="<?=$k?>"><?=$v['code'].' - '.$v[$lang]?></option>
										<? } ?>
										</select>		
									</td>
								<? } ?>
							</tr>
						</tbody>
						<tbody id="accessBodyorg">

							<tr>
								<?if(count($entities) > 1){ ?>
									<td><?=$entities[$data['entity']][$lang]?></td>
								<? } ?>

								<? if($parameters[1]['apply_param'] == 1){ ?>
									<td><?=$branches[$data['branch']][$lang]?></td>
								<? } ?>

								<? if($parameters[2]['apply_param'] == 1){ ?>
									<td><?=$divisions[$data['division']][$lang]?></td>
								<? } ?>

								<? if($parameters[3]['apply_param'] == 1){ ?>
									<td><?=$departments[$data['department']][$lang]?></td>
								<? } ?>

								<? if($parameters[4]['apply_param'] == 1){ ?>
									<td><?=$teams[$data['team']][$lang]?></td>
								<? } ?>
							</tr>

						</tbody>
					</table>

				</div>
				<div class="modal-footer" style="display: block !important;">
		        	<button type="button" class="btn btn-primary btn-fr" data-dismiss="modal"><?=$lng['Cancel']?></button>
		        	<span id="spnmsg" class="text-danger text-left font-weight-bold p-4"></span>
		        	<button type="button" class="btn btn-primary btn-fl ConfirmSelection" id="confirmbtn" disabled="disabled"><?=$lng['Confirm']?></button>
		      	</div>
			</div>
		</div>
	</div>	

	<!-- Modal organization 2 selection -->
	<div class="modal fade" id="modalorganization2" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fa fa-building-o"></i>&nbsp; <?=$lng['Organization Chart']?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h2 class="text-danger text-center font-italic">
						<?=$lng['Reduce the number until 1 remains for each item']?>
					</h2>
					<input type="hidden" name="hiddenrowidfororg" id="hiddenrowidfororg">
					<table id="usersAccess2" class="basicTable" style="margin-top:5px; width:100%; table-layout:auto;">
						<thead>
							<tr style="line-height:100%; background:#09c; color:#fff; border-bottom:1px solid #06a">
								
								<?if(count($entities) > 1){ ?>
									<th style="color:#fff"><?=$lng['Company']?></th>
								<? } ?>
								<? if($parameters[1]['apply_param'] == 1){ ?>
									<th style="color:#fff"><?=$parameters[1][$lang]?></th>
								<? } ?>
								<? if($parameters[2]['apply_param'] == 1){ ?>
									<th style="color:#fff"><?=$parameters[2][$lang]?></th>
								<? } ?>
								<? if($parameters[3]['apply_param'] == 1){ ?>
									<th style="color:#fff"><?=$parameters[3][$lang]?></th>
								<? } ?>
								<? if($parameters[4]['apply_param'] == 1){ ?>
									<th style="color:#fff"><?=$parameters[4][$lang]?></th>
								<? } ?>

							
							</tr>
						</thead>
						<tbody>
							<tr style="background:#f9f9f9">
									
								<?if(count($entities) > 1){ ?>
									<td style="padding:0">
										<select class="orgSel2" name="entities2" id="userEntities2">
										<option selected="selected" disabled="disabled" value="">Select one</option>
										<? foreach($entities as $k=>$v){ ?>
											<option value="<?=$k?>"><?=$v[$lang]?></option>
										<? } ?>
										</select>
										
									</td>
								<? } ?>
								
								<? if($parameters[1]['apply_param'] == 1){ ?>
									<td style="padding:0">
										<select class="orgSel2" name="branches2"  id="userBranches2">
										<option selected="selected" disabled="disabled" value="">Select one</option>
										<? foreach($branches as $k=>$v){ ?>
											<option value="<?=$k?>"><?=$v[$lang]?></option>
										<? } ?>
										</select>	
										
									</td>
								<? } ?>
								<? if($parameters[2]['apply_param'] == 1){ ?>
									<td style="padding:0">
										<select class="orgSel2" name="divisions2" id="userDivisions2">
										<option selected="selected" disabled="disabled" value="">Select one</option>
										<? foreach($divisions as $k=>$v){ ?>
											<option value="<?=$k?>"><?=$v[$lang]?></option>
										<? } ?>
										</select>	
										
									</td>
								<? } ?>
								<? if($parameters[3]['apply_param'] == 1){ ?>
									<td style="padding:0">
										<select class="orgSel2" name="departments2" id="userDepartments2">
										<option selected="selected" disabled="disabled" value="">Select one</option>
										<? foreach($departments as $k=>$v){ ?>
											<option value="<?=$k?>"><?=$v[$lang]?></option>
										<? } ?>
										</select>	
										
									</td>
								<? } ?>
								<? if($parameters[4]['apply_param'] == 1){ ?>
									<td style="padding:0">
										<select class="orgSel2" name="teams2"  id="userTeams2">
										<option selected="selected" disabled="disabled" value="">Select one</option>
										<? foreach($teams as $k=>$v){ ?>
											<option value="<?=$k?>"><?=$v['code'].' - '.$v[$lang]?></option>
										<? } ?>
										</select>		
									</td>
								<? } ?>
							</tr>
						</tbody>
						<tbody id="accessBodyorg2">

							<tr>
								<?if(count($entities) > 1){ ?>
									<td><?=$entities[$data['entity']][$lang]?></td>
								<? } ?>

								<? if($parameters[1]['apply_param'] == 1){ ?>
									<td><?=$branches[$data['branch']][$lang]?></td>
								<? } ?>

								<? if($parameters[2]['apply_param'] == 1){ ?>
									<td><?=$divisions[$data['division']][$lang]?></td>
								<? } ?>

								<? if($parameters[3]['apply_param'] == 1){ ?>
									<td><?=$departments[$data['department']][$lang]?></td>
								<? } ?>

								<? if($parameters[4]['apply_param'] == 1){ ?>
									<td><?=$teams[$data['team']][$lang]?></td>
								<? } ?>
							</tr>

						</tbody>
					</table>

				</div>
				<div class="modal-footer" style="display: block !important;">
		        	<button type="button" class="btn btn-primary btn-fr" data-dismiss="modal"><?=$lng['Cancel']?></button>
		        	<span id="spnmsg2" class="text-danger text-left font-weight-bold p-4"></span>
		        	<button type="button" class="btn btn-primary btn-fl ConfirmSelection2" id="confirmbtn2" disabled="disabled"><?=$lng['Confirm']?></button>
		      	</div>
			</div>
		</div>
	</div>


<!-------------------------------------------- COMMON MODAL FOR WORK DATA SECTION ---------------------------------------------------->

<div class="modal fade" id="modalEdit_date_field_leave" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="date_field_span_leave"></span></th>

								<td>
									<input  placeholder="__" name="modal_edit_text_value_leave" id="modal_edit_text_value_leave" type="text" value="" />
									<input type="hidden" name="leave_hidden_field_to_update" id="leave_hidden_field_to_update" value="">

									
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalEditLeave('text');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>

<div class="modal fade" id="modalEdit_leavedata_drop_down" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="leavedata_dropdown_field_span"></span></th>

								<td>
									<input  placeholder="__" name="modal_edit_leavedata_text_value" id="modal_edit_leavedata_text_value" type="text" value="" />
									<input type="hidden" name="leave_data_hidden_field_to_update" id="leave_data_hidden_field_to_update" value="">
									<input type="hidden" name="leavedata_hidden_row_id" id="leavedata_hidden_row_id" value="">
									
									
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalCommonLeaveDataOnclick('text');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>
<!-------------------------------------------- COMMON MODAL FOR LEAVE DATA SECTION ---------------------------------------------------->

<!-------------------------------------------- COMMON MODAL FOR FINANCIAL SECTION ---------------------------------------------------->

<div class="modal fade" id="modal_financial_common_text" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="financial_text_field_span"></span></th>
								<td>
									<input placeholder="__" name="modal_edit_financial_text_value" id="modal_edit_financial_text_value" type="text" value="" />
									<input type="hidden" name="financial_hidden_field_to_update" id="financial_hidden_field_to_update" value="">
									<input type="hidden" name="financial_hidden_which_modal" id="financial_hidden_which_modal" value="">

								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalCommonFinancial();"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>


<div class="modal fade" id="modal_financial_common_dropdown" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="financial_dropdown_field_span"></span></th>
								<td>
									<select style="width: 100%;" id="modal_edit_dropdown_value_contract_type_financial" name="modal_edit_dropdown_value_work_data" class="displayNone">
										<option value="select"  ><?=$lng['Select']?></option>
										<option value="month"  ><?='Monthly'?></option>
										<option value="day"  ><?='Daily'?></option>
									</select>				
									
									<select style="width: 100%;" id="modal_edit_dropdown_value_calc_base_financial" name="modal_edit_dropdown_value_work_data" class="displayNone">
										<option value="select"  ><?=$lng['Select']?></option>
										<option value="gross"  ><?='Gross Amount'?></option>
										<option value="net"  ><?='Net Amount'?></option>
									</select>	
									
									<select style="width: 100%;" id="modal_edit_dropdown_value_bank_name_financial" name="modal_edit_dropdown_value_work_data" class="displayNone">
										<option value="select"  ><?=$lng['Select']?></option>
										<?php foreach($bank_codes as $v){
										    if($v['apply']=='1'){?>
										<option value="<?=$v['code']?>"><?=$v['en']?></option>
										<?php }}?></option>							</select>	
									
									<select style="width: 100%;" id="modal_edit_dropdown_value_pay_type_financial" name="modal_edit_dropdown_value_work_data" class="displayNone">
										<option value="select"  ><?=$lng['Select']?></option>
										<option value="cash"  ><?='Cash'?></option>
										<option value="cheque"  ><?='Cheque'?></option>
										<option value="<?=$allOlddata['bank_code']?>"><?='Bank'?></option>					</select>	
									<select style="width: 100%;" id="modal_edit_dropdown_value_account_code_financial" name="modal_edit_dropdown_value_work_data" class="displayNone">
										<option value="select"  ><?=$lng['Select']?></option>
										<option value="0"  ><?='Direct'?></option>
										<option value="1"  ><?='Indirect'?></option>				</select>									
									
									<select style="width: 100%;" id="modal_edit_dropdown_value_groups_financial" name="modal_edit_dropdown_value_groups_work_data" class="displayNone">
										<option value="select"  ><?=$lng['Select']?></option>
										<? foreach($getAllGroups as $k=>$v){ ?>
											<option value="<?=$k?>"><?=$v?></option>
										<? } ?>
									</select>
									<select style="width: 100%;" id="modal_edit_dropdown_value_tax_calc_method_financial" name="modal_edit_dropdown_value_work_data" class="displayNone">
										<option value="select"  ><?=$lng['Select']?></option>
										<option value="cam"  ><?='Calculate in Advance Method(CAM)'?></option>
										<option value="acm"  ><?='Accumulative Calculation Method(ACM)'?></option>
										<option value="ytd"  ><?='Year To Date(YTD)'?></option>				</select>		
									<select style="width: 100%;" id="modal_edit_dropdown_value_calc_tax_financial" name="modal_edit_dropdown_value_work_data" class="displayNone">
										<option value="select"  ><?=$lng['Select']?></option>
										<option value="1"  ><?='PND 1'?></option>
										<option value="3"  ><?='PND 3'?></option>
										<option value="0"  ><?='No Tax'?></option>				</select>		
									<select style="width: 100%;" id="modal_edit_dropdown_value_tax_residency_status_financial" name="modal_edit_dropdown_value_work_data" class="displayNone">
										<option value="select"  ><?=$lng['Select']?></option>
										<option value="0"  ><?='Resident of Thailand'?></option>
										<option value="1"  ><?='Non-Resident of Thailand'?></option>				</select>	
									<select style="width: 100%;" id="modal_edit_dropdown_value_income_section_financial" name="modal_edit_dropdown_value_work_data" class="displayNone">
										<option value="select"  ><?=$lng['Select']?></option>
										<option value="1"  ><?='PND1 40(1) salaries, wages as employees'?></option>
										<option value="3"  ><?='PND1 40(1) salaries, wages under 3%'?></option>
										<option value="0"  ><?='PND1 40(1) Other compansations'?></option>				</select>
									<select style="width: 100%;" id="modal_edit_dropdown_value_calc_sso_financial" name="modal_edit_dropdown_value_work_data" class="displayNone">
										<option value="select"  ><?=$lng['Select']?></option>
										<option value="0"  ><?='Yes'?></option>
										<option value="1"  ><?='No'?></option>			</select>
									<select style="width: 100%;" id="modal_edit_dropdown_value_sso_by_financial" name="modal_edit_dropdown_value_work_data" class="displayNone">
										<option value="select"  ><?=$lng['Select']?></option>
										<option value="0"  ><?='Company'?></option>
										<option value="1"  ><?='Employee'?></option>			</select>
									<input type="hidden" name="financial_hidden_dropdown_field_to_update" id="financial_hidden_dropdown_field_to_update" value="">
									<input type="hidden" name="financial_hidden_dropdown_which_modal" id="financial_hidden_dropdown_which_modal" value="">

								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalCommonFinancialDropdown();"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>



 <div class="modal fade" id="modal_finance_common_text_edit" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="finance_text_field_span_edit"></span></th>
								<td>
									<input placeholder="__" name="modal_edit_finance_text_value_edit" id="modal_edit_finance_text_value_edit" type="text" value="" />
									<input type="hidden" name="finance_hidden_field_to_update_edit" id="finance_hidden_field_to_update_edit" value="">
									<input type="hidden" name="finance_hidden_row_id" id="finance_hidden_row_id" value="">

								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalCommonFinancialOnclick('text');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>


<div class="modal fade" id="modalEdit_finance_drop_down" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="finance_dropdown_field_span"></span></th>
								<td>
									<select id='modal_finance_edit_dropdown_value'></select>
									<input type="hidden" name="finance_hidden_field_to_update_edit" id="finance_hidden_field_to_update_dropdown" value="">
									<input type="hidden" name="finance_hidden_row_id" id="finance_hidden_row_id_dropdown" value="">

								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalDropdownFinancialOnclick('dropdown');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>
<!-------------------------------------------- COMMON MODAL FOR FINANCIAL SECTION ---------------------------------------------------->


<!-- ------------------------------------------COMMON MODAL FOR EMPLOYMENT DATA SECTION ----------------------------------------------->

<div class="modal fade" id="modal_responsibilities_common_text" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="responsibilities_text_field_span"></span></th>
								<td>
									<input placeholder="__" name="modal_edit_responsibilities_text_value" id="modal_edit_responsibilities_text_value" type="text" value="" />
									<input type="hidden" name="responsibilities_hidden_field_to_update" id="responsibilities_hidden_field_to_update" value="">
									<input type="hidden" name="responsibilities_hidden_which_modal" id="responsibilities_hidden_which_modal" value="">

								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalCommonResponsibilities('text');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>


<div class="modal fade" id="modal_responsibilities_common_date" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="responsibilities_date_field_span"></span></th>
								<td>
									<input class="date_year" placeholder="__" name="modal_edit_responsibilities_date_value" id="modal_edit_responsibilities_date_value" type="text" value="" />
									<input type="hidden" name="responsibilities_hidden_date_field_to_update" id="responsibilities_hidden_date_field_to_update" value="">
									<input type="hidden" name="responsibilities_hidden_date_which_modal" id="responsibilities_hidden_date_which_modal" value="">

								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalCommonResponsibilities('date');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>

<div class="modal fade" id="modalEdit_responsibilities_drop_down" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="responsibilities_dropdown_field_span"></span></th>
								<td>
									<select id='modal_responsibilities_edit_dropdown_value'></select>
									<input type="hidden" name="responsibilities_hidden_field_to_update_edit" id="responsibilities_hidden_field_to_update_dropdown" value="">
									<input type="hidden" name="responsibilities_hidden_row_id" id="responsibilities_hidden_row_id_dropdown" value="">

								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalDropdownResponsibilities('dropdown');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>
<div class="modal fade" id="modalOpenResponsibilities" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fa fa-user"></i>&nbsp; <?=ucwords('Edit Responsibilities')?></h5>
					<button type="button" class="close closeEditEmploymentDataPopup" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body modal-tabs">

					<form id="careerForm">

						<input type="hidden" name="emp_id" value="<?=$empID?>">
						<input type="hidden" name="career_id_curr" value="<?=isset($ecdata) ? $ecdata[0]['id'] : '';?>">

						
						<div class="tab3">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
										<th colspan="3"><?=$lng['Select Start Date']?></th>
									</tr>
								</thead>
								<thead>
									<tr style="line-height:100%">
										<th></th>
										<th class="tac"><?=$lng['New']?></th>
										<th class="tac"><?=$lng['Current']?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th><?=$lng['Start Date']?></th>
										<td><input type="text" id="sdates" class="" name="start_date_new" autocomplete="off"></td>
										<td><input type="text" class="datepick1" name="start_date_curr" autocomplete="off" value="<? if(!empty($ecdata[0]['start_date'])){echo date('d-m-Y', strtotime($ecdata[0]['start_date']));}?>"></td>
									</tr>

									<tr>
										<th><?=$lng['End date']?></th>
										<td><input type="text" name="end_date_new" autocomplete="off" readonly></td>
										<td><input type="text" name="end_date_curr" id="end_curr" autocomplete="off" value="<? if(!empty($ecdata[0]['end_date'])){echo date('d-m-Y', strtotime($ecdata[0]['end_date']));}?>" readonly></td>
									</tr>

									<tr>
										<th><?=$lng['Position']?></th>
										<td>
											<select name="position_new">
												<option value="">...</option>
												<? foreach($positions as $k => $v){ ?>
													<option value="<?=$v['id']?>" ><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
										<td>
											<select name="position_curr">
												<option value="">...</option>
												<? foreach($positions as $k => $v){ ?>
													<option value="<?=$v['id']?>" <?if($v['id'] == $ecdata[0]['position']){echo 'selected';}?>><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>


								</tbody>
							</table>
						</div>
						<div class="tab3">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
										<th colspan="3"><?=$lng['RESPONSIBILITIESS']?></th>
									</tr>
								</thead>
								<thead>
									<tr style="line-height:100%">
										<th></th>
										<th class="tac"><?=$lng['New']?></th>
										<th class="tac"><?=$lng['Current']?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th><?=$lng['Head of Location']?></th>
										<td>
											<select name="head_branch_new" >
												<option value="">...</option>
												<? foreach($branches as $k=>$v){ ?>
													<option  value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
										<td>
											<select name="head_branch_cur" >
												<option value="">...</option>
												<? foreach($branches as $k=>$v){ ?>
													<option <? if($ecdata[0]['head_branch'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>									

									<tr>
										<th><?=$lng['Head of division']?></th>
										<td>
											<select name="head_division_new">
												<option value="">...</option>
												<? foreach($divisions as $k=>$v){ ?>
													<option  value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
										<td>
											<select name="head_division_cur">
												<option value="">...</option>
												<? foreach($divisions as $k=>$v){ ?>
													<option <? if($ecdata[0]['head_division'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>									
									<tr>
										<th><?=$lng['Head of department']?></th>
										<td>
											<select name="head_department_new" >
												<option value="">...</option>
												<? foreach($departments as $k=>$v){ ?>
													<option  value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
										<td>
											<select name="head_department_curr" >
												<option value="">...</option>
												<? foreach($departments as $k=>$v){ ?>
													<option <? if($ecdata[0]['head_department'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>									
									<tr>
										<th><?=$lng['Team supervisor']?></th>
										<td>
											<select name="team_supervisor_new" >
												<option value="">...</option>
												<? foreach($teams as $k=>$v){ ?>
													<option  value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
										<td>
											<select name="team_supervisor_curr" >
												<option value="">...</option>
												<? foreach($teams as $k=>$v){ ?>
													<option <? if($ecdata[0]['team_supervisor'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>
									
			
								</tbody>
							</table>
						</div>

						<div class="tab3">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
										<th colspan="3"><?=$lng['Other']?></th>
									</tr>
								</thead>
								<thead>
									<tr style="line-height:100%">
										<th></th>
										<th class="tac"><?=$lng['New']?></th>
										<th class="tac"><?=$lng['Current']?></th>
									</tr>
								</thead>
								<tbody>
									
									<tr>
										<th><?=$lng['Other benefits']?></th>
										<td>
											<textarea data-autoresize style="resize:vertical" rows="2" name="other_benifits_new" placeholder="..."></textarea>
										</td>
										<td>
											<textarea data-autoresize style="resize:vertical" rows="2" name="other_benifits_curr" placeholder="..."><?=isset($ecdata) ? $ecdata[0]['other_benifits'] : '';?></textarea>
										</td>
									</tr>

									<tr>
										<th><?=$lng['Remarks']?></th>
										<td>
											<textarea data-autoresize style="resize:vertical" rows="2" name="remarks_new" placeholder="..."></textarea>
										</td>
										<td>
											<textarea data-autoresize style="resize:vertical" rows="2" name="remarks_curr" placeholder="..."><?=isset($ecdata) ? $ecdata[0]['remarks'] : '';?></textarea>
										</td>
									</tr>
									
									<tr>
										<th><?=$lng['Attachments']?></th>
										<td>
											<input type="file" name="attachment_new[]">
										</td>
										<td>
											<input type="file" name="attachment_curr[]">
										</td>
									</tr>
								</tbody>
							</table>
						</div>

						<div style="overflow:auto;" class="mt-4" id="hideauto">
						    <div>
						      <button type="button" class="btn btn-primary btn-fl" id="prevBtn3" onclick="nextPrev2(-1)"><?=$lng['Prev']?></button>
						      <button type="button" class="btn btn-primary btn-fr" id="nextBtn3" onclick="nextPrev2(1)"><?=$lng['Next']?></button>
						    </div>
						</div>

					</form>

				</div>

			</div>
		</div>
	</div>
<!-- ------------------------------------------COMMON MODAL FOR RESPONSBILITIES SECTION ----------------------------------------------->
<!--------working------->

<!-- ------------------------------------------COMMON MODAL FOR EMPLOYMENT DATA SECTION ----------------------------------------------->

<div class="modal fade" id="modal_employment_data_common_text" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="employment_data_text_field_span"></span></th>
								<td>
									<input placeholder="__" name="modal_edit_employment_data_text_value" id="modal_edit_employment_data_text_value" type="text" value="" />
									<input type="hidden" name="employment_data_hidden_field_to_update" id="employment_data_hidden_field_to_update" value="">
									<input type="hidden" name="employment_data_hidden_which_modal" id="employment_data_hidden_which_modal" value="">

								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalEditEmployment('text');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>


<div class="modal fade" id="modal_employment_data_common_date" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="employment_data_date_field_span"></span></th>
								<td>
									<input class="date_year" placeholder="__" name="modal_edit_employment_data_date_value" id="modal_edit_employment_data_date_value" type="text" value="" />
									<input type="hidden" name="employment_data_hidden_date_field_to_update" id="employment_data_hidden_date_field_to_update" value="">
									<input type="hidden" name="employment_data_hidden_date_which_modal" id="employment_data_hidden_date_which_modal" value="">

								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalEditEmployment('date');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>

<div class="modal fade" id="modalEdit_employment_data_drop_down" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="employment_data_dropdown_field_span">
												
								</span></th>
								<td>
									<select id='modal_employment_data_edit_dropdown_value'><? foreach($emp_status as $k=>$v){ ?>
													<option value="<?=$k?>"><?=$v?></option>
												<? } ?></select>
									<input type="hidden" name="employment_data_hidden_field_to_update_edit" id="employment_data_hidden_field_to_update_dropdown" value="">
									<input type="hidden" name="employment_data_hidden_row_id" id="employment_data_hidden_row_id_dropdown" value="">

								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalEditEmployment('dropdown');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>

	<div class="modal fade" id="modalOpenEmploymentData" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fa fa-user"></i>&nbsp; <?=ucwords($lng['Edit Employment Data'])?></h5>
					<button  type="button" class="close closeEditEmploymentDataPopup" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body modal-tabs">

					<form id="employementDataForm">

						<input type="hidden" name="emp_id" value="<?=$empID?>">

						
						<div class="tab2">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
										<th colspan="3"><?=$lng['Select Joining Date']?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th><?=$lng['Joining date']?></th>
										<td><input  class="datepick" type="text" name="joining_date_2" id="joining_date_2" placeholder="..." value="<? if(!empty($data['joining_date'])){echo date('d-m-Y', strtotime($data['joining_date']));}?>"></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="tab2">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
									</tr>
								</thead>
								<tbody>
		<!-- 							<tr>
										<th>No end of employment</th>
										<td>
											<input type="radio" id="noEndOfEmployment" class="ml-2 mt-2 checkbox-custom-blue-2" name="endofemployment" value="0" >
										</td>
									</tr>	 -->					
									<tr>
										<th>End of employment</th>
										<td>
											<input type="checkbox" id="endOfEmployment" class="ml-2 mt-1 checkbox-custom-blue-2" name="endofemployment" value="1" checked="checked">
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="tab2 dateTab">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
									</tr>
								</thead>
								<tbody>
									<tr>
										<th><?=$lng['Employment End Date']?></th>
										<td>

										<input class="datepick"  type="text" style="width:140px;" id="resign_date2" name="resign_date2" placeholder="..." value="" >

										</td>
									</tr>
								</tbody>
							</table>
						</div>

						<div class="tab2 nextToNextTab">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
									</tr>
								</thead>
								<tbody>
									<tr>
										<th><?=$lng['Employee status']?></th>
										<td>
											<select id="emp_status2val"  name="emp_status2" style="width:140px;display: none;">
												<? foreach($emp_status2 as $k=>$v){ ?>
													<option <? if($data['emp_status'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v?></option>
												<? } ?>
											</select>

											<select id="emp_status3val" name="emp_status3" style="width:140px;display: none;">
												<? foreach($emp_status3 as $k=>$v){ ?>
													<option <? if($data['emp_status'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v?></option>
												<? } ?>
											</select>
										</td>
									</tr>
								</tbody>
							</table>
						</div>

						<div class="tab2 noticeDateDiv">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
									</tr>
								</thead>
								<tbody>
									<tr>
										<th>Notice date</th>
										<td>

										<input class="datepick"  type="text" style="width:140px;" id="notice_day_field" name="notice_day_field" placeholder="..." value="<? if(!empty($data['notice_date'])){echo date('d-m-Y', strtotime($data['notice_date']));}?>" >

										</td>
									</tr>								

									<tr>
										<th>Last working day</th>
										<td>

										<input class="datepick"  type="text" style="width:140px;pointer-events: none;" id="last_working_day" name="last_working_day" placeholder="..." value="<? if(!empty($data['resign_date'])){echo date('d-m-Y', strtotime($data['resign_date']));}?>" >

										</td>
									</tr>									
									<tr>
										<th>End of employment reason</th>
										<td>

										<input type="text" style="width:140px;" id="end_of_employment_reason" name="end_of_employment_reason" placeholder="..." value="<? if(!empty($data['resign_reason'])){echo $data['resign_reason'];}?>" >

										</td>
									</tr>									
									<tr>
										<th>Last month in payroll</th>
										<td>

											<input type="text" style="width:140px;" id="last_month_payroll" name="last_month_payroll" placeholder="..." value="<? if(!empty($data['resign_date'])){echo date('m', strtotime($data['resign_date']));}?>" >

										</td>
									</tr>
									<tr>
										<td colspan="2" style="text-align: center;color: red;font-weight: 600;">Other data on end of contract can be filled in section End contract</td>
									</tr>
								</tbody>
							</table>
						</div>



		

						<div style="overflow:auto;" class="mt-4" id="hideauto">
						    <div>
						      <button type="button" class="btn btn-primary btn-fl prevBtn2" id="prevBtn2" onclick="nextPrev(-1)"><?=$lng['Prev']?></button>
						      <button type="button" class="btn btn-primary btn-fr nextBtn2" id="nextBtn2" onclick="nextPrev(1)"><?=$lng['Next']?></button>
						    </div>
						</div>

					</form>

				</div>

			</div>
		</div>
	</div>
<!-- ------------------------------------------COMMON MODAL FOR EMPLOYMENT DATA SECTION ----------------------------------------------->

<!-------------------------------------------- COMMON MODAL FOR BENEFIT DATA SECTION ---------------------------------------------------->

<div class="modal fade" id="modal_benefit_common_text" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="benefit_text_field_span"></span></th>
								<td>
									<input placeholder="__" name="modal_edit_benefit_text_value" id="modal_edit_benefit_text_value" type="text" value="" />
									<input type="hidden" name="benefit_hidden_field_to_update" id="benefit_hidden_field_to_update" value="">
									<input type="hidden" name="benefit_hidden_which_modal" id="benefit_hidden_which_modal" value="">

								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalCommonBenefit('text');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>


<div class="modal fade" id="modal_benefit_common_date" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="benefit_date_field_span"></span></th>
								<td>
									<input class="date_year" placeholder="__" name="modal_edit_benefit_date_value" id="modal_edit_benefit_date_value" type="text" value="" />
									<input type="hidden" name="benefit_hidden_date_field_to_update" id="benefit_hidden_date_field_to_update" value="">
									<input type="hidden" name="benefit_hidden_date_which_modal" id="benefit_hidden_date_which_modal" value="">

								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalCommonBenefit('date');"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>

<!-------------------------------------------- COMMON MODAL FOR LEAVE DATA SECTION ---------------------------------------------------->


<div class="modal fade" id="modal_benefits_common_text_edit" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 600px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-cog"></i>&nbsp; <?=$lng['Modify Data']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tab"> 
					<table class="basicTable inputs mb-2" id="makeitem" border="0">
						<thead>
							<tr>
								<th colspan="2"><?=$lng['Enter Data']?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="tal"><span id="benefits_text_field_span_edit"></span></th>
								<td>
									<input  style= "display:none;" placeholder="__" name="modal_edit_benefits_text_value_edit" id="modal_edit_benefits_text_value_edit" type="text" value="" />

									<input  class="date_year" style= "display:none;" placeholder="__" name="modal_edit_benefits_date_value_edit" id="modal_edit_benefits_date_value_edit" type="text" value="" />

									<input type="hidden" name="benefits_hidden_field_to_update_edit" id="benefits_hidden_field_to_update_edit" value="">
									<input type="hidden" name="benefits_hidden_row_id" id="benefits_hidden_row_id" value="">

								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="overflow:auto;" id="hideauto">
				    <div>
				      <button type="button" data-dismiss="modal" class=" btn btn-primary btn-fl" id="" ><?=$lng['Cancel']?></button>
				      <button type="button" class="btn btn-primary btn-fr" id="submit" onclick="submitPopupModalCommonBenefitOnclick();"><?=$lng['Submit']?></button>
				    </div>
				</div>
			</div>

		</div>
	</div>
</div>



	<!-- Modal modalAddNew -->
	<div class="modal fade" id="modalAddEmpcareer" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fa fa-user"></i>&nbsp; <?=ucwords($lng['Add Employee Benefits'])?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body modal-tabs">

					<form id="careerForm">

						<input type="hidden" name="emp_id" value="<?=$empID?>">
						<input type="hidden" name="career_id_curr" value="<?=isset($ecdata) ? $ecdata[0]['id'] : '';?>">

					    <div class="tabs">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
										<th colspan="3"><?=$lng['BASIC SALARY']?></th>
									</tr>
								</thead>
								<thead>
									<tr style="line-height:100%">
										<th></th>
										<th class="tac"><?=$lng['New']?></th>
										<th class="tac"><?=$lng['Current']?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th><?=$lng['Start Date']?></th>
										<td><input type="text" id="sdates" class="" name="start_date_new" autocomplete="off"></td>
										<td><input type="text" class="datepick1" name="start_date_curr" autocomplete="off" value="<? if(!empty($ecdata[0]['start_date'])){echo date('d-m-Y', strtotime($ecdata[0]['start_date']));}?>"></td>
									</tr>

									<tr>
										<th><?=$lng['End date']?></th>
										<td><input type="text" name="end_date_new" autocomplete="off" readonly></td>
										<td><input type="text" name="end_date_curr" id="end_curr" autocomplete="off" value="<? if(!empty($ecdata[0]['end_date'])){echo date('d-m-Y', strtotime($ecdata[0]['end_date']));}?>" readonly></td>
									</tr>

									<tr>
										<th><?=$lng['Position']?></th>
										<td>
											<select name="position_new">
												<? foreach($positions as $k => $v){ ?>
													<option value="<?=$v['id']?>" ><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
										<td>
											<select name="position_curr">
												<? foreach($positions as $k => $v){ ?>
													<option value="<?=$v['id']?>" <?if($v['id'] == $ecdata[0]['position']){echo 'selected';}?>><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>
									
									<tr>
										<th><?=$lng['Basic salary']?></th>
										<td><input type="text" name="salary_new" autocomplete="off"></td>
										<td><input type="text" name="salary_curr" autocomplete="off" value="<?=isset($ecdata) ? $ecdata[0]['salary'] : '';?>"></td>
									</tr>
								</tbody>
							</table>
						</div>

						<div class="tabs">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
										<th colspan="3"><?=$lng['FIXED ALLOWANCES']?></th>
									</tr>
								</thead>
								<thead>
									<tr style="line-height:100%">
										<th></th>
										<th class="tac"><?=$lng['New']?></th>
										<th class="tac"><?=$lng['Current']?></th>
									</tr>
								</thead>
								<tbody>
								
								<? 
								if($getNewFixAllowDeduct['inc_fix']){ foreach($getNewFixAllowDeduct['inc_fix'] as $k=>$v){
								 	$fixAllow = unserialize($ecdata[0]['fix_allow']);
								 ?>
									<tr>
										<th><?=$v[$lang]?></th>
										<td>
											
											<input style="width:70px" class="numeric8 sel notnull" type="text" name="emp_fixa_new[<?=$v['id']?>]" placeholder="..." >
										</td>
										<td>
											
											<input style="width:70px" class="numeric8 sel notnull" type="text" name="emp_fixa_curr[<?=$v['id']?>]" placeholder="..." value="<?=$fixAllow[$v['id']]?>">
										</td>
									</tr>
								<? } }else{ ?>
									<tr>
										<td colspan="3" style="padding:4px 10px"><?=$lng['No allowances selected']?></td>
									</tr>
								<? } ?>
									<tr>
										<td colspan="3" style="height:10px"></td>
									</tr>
								</tbody>
							</table>
						</div>

						<div class="tabs">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
										<th colspan="3"><?=$lng['FIXED DEDUCTIONS']?></th>
									</tr>
								</thead>
								<thead>
									<tr style="line-height:100%">
										<th></th>
										<th class="tac"><?=$lng['New']?></th>
										<th class="tac"><?=$lng['Current']?></th>
									</tr>
								</thead>
								<tbody>
									
									<? 
									if($getNewFixAllowDeduct['ded_fix']){ foreach($getNewFixAllowDeduct['ded_fix'] as $k=>$v){ 
										$fixDeduct = unserialize($ecdata[0]['fix_deduct']);
									?>
										<tr>
											<th><?=$v[$lang]?></th>
											<td>
												
												<input style="width:70px" class="numeric8 sel notnull" type="text" name="emp_fixd_new[<?=$v['id']?>]" placeholder="...">
											</td>
											<td>
												
												<input style="width:70px" class="numeric8 sel notnull" type="text" name="emp_fixd_curr[<?=$v['id']?>]" placeholder="..." value="<?=$fixDeduct[$v['id']]?>">
											</td>
										</tr>
									<? } }else{ ?>
										<tr>
											<td colspan="3" style="padding:4px 10px"><?=$lng['No deductions selected']?></td>
										</tr>
									<? } ?>
								</tbody>
							</table>
						</div>						

						<div class="tabs">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
										<th colspan="3"><?=$lng['RESPONSIBILITIESS']?></th>
									</tr>
								</thead>
								<thead>
									<tr style="line-height:100%">
										<th></th>
										<th class="tac"><?=$lng['New']?></th>
										<th class="tac"><?=$lng['Current']?></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th><?=$lng['Head of Location']?></th>
										<td>
											<select name="head_branch_new" >
												<option value="">...</option>
												<? foreach($branches as $k=>$v){ ?>
													<option  value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
										<td>
											<select name="head_branch_cur" >
												<option value="">...</option>
												<? foreach($branches as $k=>$v){ ?>
													<option <? if($ecdata[0]['head_branch'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>									

									<tr>
										<th><?=$lng['Head of division']?></th>
										<td>
											<select name="head_division_new">
												<option value="">...</option>
												<? foreach($divisions as $k=>$v){ ?>
													<option  value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
										<td>
											<select name="head_division_cur">
												<option value="">...</option>
												<? foreach($divisions as $k=>$v){ ?>
													<option <? if($ecdata[0]['head_division'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>									
									<tr>
										<th><?=$lng['Head of department']?></th>
										<td>
											<select name="head_department_new" >
												<option value="">...</option>
												<? foreach($departments as $k=>$v){ ?>
													<option  value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
										<td>
											<select name="head_department_curr" >
												<option value="">...</option>
												<? foreach($departments as $k=>$v){ ?>
													<option <? if($ecdata[0]['head_department'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>									
									<tr>
										<th><?=$lng['Team supervisor']?></th>
										<td>
											<select name="team_supervisor_new" >
												<option value="">...</option>
												<? foreach($teams as $k=>$v){ ?>
													<option  value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
										<td>
											<select name="team_supervisor_curr" >
												<option value="">...</option>
												<? foreach($teams as $k=>$v){ ?>
													<option <? if($ecdata[0]['team_supervisor'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v[$lang]?></option>
												<? } ?>
											</select>
										</td>
									</tr>
									
			
								</tbody>
							</table>
						</div>

						<div class="tabs">  
							<table class="basicTable" border="0" style="width: 100%;">
								<thead>
									<tr style="line-height:100%">
										<th colspan="3"><?=$lng['Other']?></th>
									</tr>
								</thead>
								<thead>
									<tr style="line-height:100%">
										<th></th>
										<th class="tac"><?=$lng['New']?></th>
										<th class="tac"><?=$lng['Current']?></th>
									</tr>
								</thead>
								<tbody>
									
									<tr>
										<th><?=$lng['Other benefits']?></th>
										<td>
											<textarea data-autoresize style="resize:vertical" rows="2" name="other_benifits_new" placeholder="..."></textarea>
										</td>
										<td>
											<textarea data-autoresize style="resize:vertical" rows="2" name="other_benifits_curr" placeholder="..."><?=isset($ecdata) ? $ecdata[0]['other_benifits'] : '';?></textarea>
										</td>
									</tr>

									<tr>
										<th><?=$lng['Remarks']?></th>
										<td>
											<textarea data-autoresize style="resize:vertical" rows="2" name="remarks_new" placeholder="..."></textarea>
										</td>
										<td>
											<textarea data-autoresize style="resize:vertical" rows="2" name="remarks_curr" placeholder="..."><?=isset($ecdata) ? $ecdata[0]['remarks'] : '';?></textarea>
										</td>
									</tr>
									
									<tr>
										<th><?=$lng['Attachments']?></th>
										<td>
											<input type="file" name="attachment_new[]">
										</td>
										<td>
											<input type="file" name="attachment_curr[]">
										</td>
									</tr>
								</tbody>
							</table>
						</div>

						<div style="overflow:auto;" class="mt-4" id="hideauto">
						    <div>
						      <button type="button" class="btn btn-primary btn-fl" id="prevBtn1" onclick="nextPrev1(-1)"><?=$lng['Prev']?></button>
						      <button type="button" class="btn btn-primary btn-fr" id="nextBtn1" onclick="nextPrev1(1)"><?=$lng['Next']?></button>
						    </div>
						</div>

					</form>

				</div>

			</div>
		</div>
	</div>