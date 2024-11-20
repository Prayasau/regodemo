<div class="modal fade" id="modalOpenEmployment" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fa fa-user"></i>&nbsp; <?=ucwords('Add Employement Details')?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body modal-tabs">
				<form>
				<div class='tabw'>
					<table class="basicTable editTable" border="0" style="width: 100%;>
								<tbody>
									<tr style="line-height:100%">
										<th><?=$lng['Joining date']?></th>
										<td><input readonly style="cursor:pointer" class="datepick" type="text" name="joining_date" id="joining_date" placeholder="..." value="<? if(!empty($data['joining_date'])){echo date('d-m-Y', strtotime($data['joining_date']));}?>"></td>
									</tr>
									<!--<tr>
										<th><?=$lng['Probation due date']?></th>
										<td><input type="text" readonly style="cursor:pointer" class="datepick" name="probation_date" id="probation_date" placeholder="..." value="<? if(!empty($data['probation_date'])){echo date('d-m-Y', strtotime($data['probation_date']));}?>"></td>
									</tr>-->
								</tbody>
					</table>
				</div>
				<div class='tabw' >
					<table class="basicTable editTable" border="0">
						<tbody>
						<tr>
						<th></th>
						<td></td>
						</tr>
						</tbody>
					</table>
				</div>
				
				<div class='tabw' >
									<!--<tr>
										<th><?=$lng['Service years']?></th>
										<td class="pad410" id="serv_years"></td>
									</tr>
									
									
									<tr>
										<th><?=$lng['Employee type']?></th>
										<td>
											<select name="emp_type">
												<? foreach($emp_type as $k=>$v){ ?>
													<option <? if($data['emp_type'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v?></option>
												<? } ?>
											</select>
										</td>
									</tr>-->
									
									<table class="basicTable editTable" border="0">
									<tbody>
									<tr>
										<th><?='Employment End date'?></th>
										<td>
											<input type="text" style="cursor:pointer;width:140px;" name="resign_date" placeholder="..." value="<? if(!empty($data['resign_date'])){echo date('d-m-Y', strtotime($data['resign_date']));}?>" readonly="readonly">
												
										</td>
									</tr>
									</tbody>
									</table>
									<!--<tr>
										<th><?=$lng['Resign reason']?></th>
										<td>
											<input type="text" style="cursor:pointer;width:140px;" name="resign_reason" readonly="readonly" placeholder="..." value="<?=$data['resign_reason']?>">
											<b style="color:#b00"><?=$lng['Please change this from End Contract tab']?></b>
										</td>
									</tr>-->
									</div>
				<div class='tabw' >
					<table class="basicTable editTable" border="0">
									<table class="basicTable editTable" border="0">
									<tbody>
									<tr>
										<th><?=$lng['Employee status']?></th><td>
											<select name="emp_status" style="pointer-events: none;width:140px;">
												<? foreach($emp_status as $k=>$v){ ?>
													<option <? if($data['emp_status'] == $k){echo 'selected';}?> value="<?=$k?>"><?=$v?></option>
												<? } ?>
											</select>
											<b style="color:#b00"><?=$lng['Please change this from End Contract tab']?></b>
										</td>
									</tr>

								</tbody>
								
								
						
							</table>
				</div>
						<input type="button"  name="previous" class="btn btn-primary btn-fl previous action-button-previous" value="Previous"/>
                        <input type="button" name="make_payment" class="btn btn-primary btn-fl next action-button" value="Confirm"/>
						</form>
			</div>
		</div>
</div>
</div>













