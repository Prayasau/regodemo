<?
	$settings = array();
	if($res = $dba->query("SELECT * FROM rego_default_settings")){
		$settings = $res->fetch_assoc();

		$emp_grp = unserialize($settings['emp_grp']);
		$parameter = unserialize($settings['parameter']);
		$org = unserialize($settings['org']);
	}
?>
<h2><i class="fa fa-cogs"></i>&nbsp;&nbsp;<?=$lng['Company Set Up']?> <span style="float:right; display:none; font-style:italic; color:#b00" id="sAlert"><?=$lng['Data is not updated to last changes made']?></span></h2>

<div class="main">
	<div style="padding:0 0 0 20px" id="dump"></div>

	<form id="companySetupForm" style="height:100%">

		<ul class="nav nav-tabs" id="myTab">
			<li class="nav-item">
				<a class="nav-link active" data-target="#Defaultsetup" data-toggle="tab"><?=$lng['Default setup']?></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-target="#Groupsetup" data-toggle="tab"><?=$lng['Group setup']?></a>
			</li>
		</ul>

		<button class="btn btn-primary" style="margin:0; position:absolute; top:15px; right:16px;" id="submitbtn" type="submit"><i class="fa fa-save"></i>&nbsp;&nbsp;<?=$lng['Update']?></button>


		<div class="tab-content" style="height:calc(100% - 40px)">
			<div class="tab-pane active" id="Defaultsetup">

				<table class="basicTable inputs" border="0">
					<thead>
						<tr>
							<th colspan="2"><?=strtoupper($lng['System settings'])?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th><?=$lng['Date format']?></th>
							<td>
								<input style="color:#999" disabled="disabled" type="text" value="<?=date('d-m-Y')?>&nbsp; (dd-mm-yyyy)">
							</td>
						</tr>
						<tr>
							<th><?=$lng['Log-time']?></th>
							<td>
								<select name="logtime" style="width:100%">
									<option value="900" <?if($settings['logtime'] == '900'){echo 'selected';}?>>15 <?=$lng['min']?></option>
									<option value="1800" <?if($settings['logtime'] == '1800'){echo 'selected';}?>>30 <?=$lng['min']?></option>
									<option value="3600" <?if($settings['logtime'] == '3600'){echo 'selected';}?>>60 <?=$lng['min']?></option>
									<option value="86400" <?if($settings['logtime'] == '86400'){echo 'selected';}?>>1 <?=$lng['day']?></option>
								</select>
							</td>
						</tr>
						<tr>
							<th><?=$lng['Theme color']?></th>
							<td>
								<select name="theme_color" style="width:100%">
									<option value="red" <?if($settings['theme_color'] == 'red'){echo 'selected';}?>><?=$lng['Default']?></option>
									<option value="blue" <?if($settings['theme_color'] == 'blue'){echo 'selected';}?>><?=$lng['Blue']?></option>
								</select>
							</td>
						</tr>
					</tbody>
				</table>
				
				<table class="basicTable inputs" border="0" width="50%">
					<thead>
						<tr>
							<th colspan="2"><?=strtoupper($lng['Revenu Code'])?> & <?=strtoupper($lng['SSO Code'])?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th><?=$lng['Revenu Code']?></th>
							<td>
								<input type="text" name="revenu_code" value="<?= isset($settings['revenu_code']) ? $settings['revenu_code'] : 00000; ?>">
							</td>
						</tr>
						<tr>
							<th><?=$lng['Name'].' '.$lng['Thai']?></th>
							<td>
								<input type="text" name="revenu_name_th" value="<?= isset($settings['revenu_name_th']) ? $settings['revenu_name_th'] : 'สำนักงานใหญ่'; ?>">
							</td>
						</tr>
						<tr>
							<th><?=$lng['Name'].' '.$lng['English']?></th>
							<td>
								<input type="text" name="revenu_name_en" value="<?= isset($settings['revenu_name_en']) ? $settings['revenu_name_en'] : 'Head office'; ?>">
							</td>
						</tr>
						<tr>
							<th><?=$lng['SSO Code']?></th>
							<td>
								<input type="text" name="sso_code" value="<?= isset($settings['sso_code']) ? $settings['sso_code'] : 00000; ?>">
							</td>
						</tr>
						<tr>
							<th><?=$lng['Name'].' '.$lng['Thai']?></th>
							<td>
								<input type="text" name="sso_name_th" value="<?= isset($settings['sso_name_th']) ? $settings['sso_name_th'] : 'สำนักงานใหญ่'; ?>">
							</td>
						</tr>
						<tr>
							<th><?=$lng['Name'].' '.$lng['English']?></th>
							<td>
								<input type="text" name="sso_name_en" value="<?= isset($settings['sso_name_en']) ? $settings['sso_name_en'] : 'Head office'; ?>">
							</td>
						</tr>
					</tbody>
				</table>

			</div>

			<div class="tab-pane" id="Groupsetup">
				<?
				// echo '<pre>';
				// print_r($emp_grp);
				// print_r($parameter);
				// print_r($org);
				// echo '</pre>';
				?>
				<div class="row">
					<div class="col-md-6">
						<table class="basicTable inputs" border="0">
							<thead>
								<tr>
									<th colspan="4"><?=strtoupper($lng['Defaults employee groups'])?></th>
								</tr>
								<tr>
									<th><?=$lng['Group']?></th>
									<th><?=$lng['Code']?></th>
									<th><?=$lng['Thai description']?></th>
									<th><?=$lng['English description']?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td style="padding-left: 5px !important;"><?=$lng['Company']?></td>
									<td>
										<input class="font-italic" type="text" name="emp_grp[company][code]" value="<?=isset($emp_grp['company']['code']) ? $emp_grp['company']['code'] : 'HQ'; ?>" readonly="readonly">
									</td>
									<td>
										<input class="font-italic" type="text" name="emp_grp[company][th]" value="<?=isset($emp_grp['company']['th']) ? $emp_grp['company']['th'] : $row11['compname_th']; ?>">
									</td>
									<td>
										<input class="font-italic" type="text" name="emp_grp[company][en]" value="<?=isset($emp_grp['company']['en']) ? $emp_grp['company']['en'] : $row11['compname_en']; ?>">
									</td>
								</tr>
								<tr>
									<td style="padding-left: 5px !important;"><?=$lng['Location']?></td>
									<td>
										<input type="text" name="emp_grp[location][code]" value="<?=isset($emp_grp['location']['code']) ? $emp_grp['location']['code'] : 'HQ'; ?>" readonly="readonly">
									</td>
									
									<td>
										<input type="text" name="emp_grp[location][th]" value="<?=isset($emp_grp['location']['th']) ? $emp_grp['location']['th'] : 'สำนักงานใหญ่'; ?>">
									</td>
									<td>
										<input type="text" name="emp_grp[location][en]" value="<?=isset($emp_grp['location']['en']) ? $emp_grp['location']['en'] : 'Head office'; ?>">
									</td>
								</tr>
								<tr>
									<td style="padding-left: 5px !important;"><?=$lng['Division']?></td>
									<td>
										<input type="text" name="emp_grp[division][code]" value="<?=isset($emp_grp['division']['code']) ? $emp_grp['division']['code'] : 'NODIV'; ?>" readonly="readonly">
									</td>
									
									<td>
										<input type="text" name="emp_grp[division][th]" value="<?=isset($emp_grp['division']['th']) ? $emp_grp['division']['th'] : 'ไม่มีฝ่าย'; ?>">
									</td>
									<td>
										<input type="text" name="emp_grp[division][en]" value="<?=isset($emp_grp['division']['en']) ? $emp_grp['division']['en'] : 'No Division'; ?>">
									</td>
								</tr>
								<tr>
									<td style="padding-left: 5px !important;"><?=$lng['Department']?></td>
									<td>
										<input type="text" name="emp_grp[department][code]" value="<?=isset($emp_grp['department']['code']) ? $emp_grp['department']['code'] : 'NODEP'; ?>" readonly="readonly">
									</td>
									
									<td>
										<input type="text" name="emp_grp[department][th]" value="<?=isset($emp_grp['department']['th']) ? $emp_grp['department']['th'] : 'ไม่มีแผนก'; ?>">
									</td>
									<td>
										<input type="text" name="emp_grp[department][en]" value="<?=isset($emp_grp['department']['en']) ? $emp_grp['department']['en'] : 'No Department'; ?>">
									</td>
								</tr>
								<tr>
									<td style="padding-left: 5px !important;"><?=$lng['Teams']?></td>
									<td>
										<input type="text" name="emp_grp[team][code]" value="<?=isset($emp_grp['team']['code']) ? $emp_grp['team']['code'] : 'NOTEAM'; ?>" readonly="readonly">
									</td>
									
									<td>
										<input type="text" name="emp_grp[team][th]" value="<?=isset($emp_grp['team']['th']) ? $emp_grp['team']['th'] : 'ไม่มีทีม'; ?>">
									</td>
									<td>
										<input type="text" name="emp_grp[team][en]" value="<?=isset($emp_grp['team']['en']) ? $emp_grp['team']['en'] : 'No Teams'; ?>">
									</td>
								</tr>
								<tr>
									<td style="padding-left: 5px !important;"><?=$lng['Group']?></td>
									<td>
										<input type="text" name="emp_grp[group][code]" value="<?=isset($emp_grp['group']['code']) ? $emp_grp['group']['code'] : 'NOGR'; ?>" readonly="readonly">
									</td>
									
									<td>
										<input type="text" name="emp_grp[group][th]" value="<?=isset($emp_grp['group']['th']) ? $emp_grp['group']['th'] : 'ไม่มีกลุ่ม'; ?>">
									</td>
									<td>
										<input type="text" name="emp_grp[group][en]" value="<?=isset($emp_grp['group']['en']) ? $emp_grp['group']['en'] : 'No Group'; ?>">
									</td>
								</tr>
								<tr>
									<td style="padding-left: 5px !important;"><?=$lng['Position']?></td>
									<td>
										<input type="text" name="emp_grp[position][code]" value="<?=isset($emp_grp['position']['code']) ? $emp_grp['position']['code'] : 'NOPOS'; ?>" readonly="readonly">
									</td>
									
									<td>
										<input type="text" name="emp_grp[position][th]" value="<?=isset($emp_grp['position']['th']) ? $emp_grp['position']['th'] : 'ไม่มีตำแหน่ง'; ?>">
									</td>
									<td>
										<input type="text" name="emp_grp[position][en]" value="<?=isset($emp_grp['position']['en']) ? $emp_grp['position']['en'] : 'No Position'; ?>">
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-md-6">

						<table class="basicTable inputs" border="0">
							<thead>
								<tr>
									<th colspan="3"><?=strtoupper($lng['Defaults Parameter settings'])?></th>
								</tr>
								<tr>
									<th><?=$lng['Apply']?></th>
									<th><?=$lng['Thai description']?></th>
									<th><?=$lng['English description']?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="tac">
										<input type="hidden" name="parameter[location][apply]" value="0">
										<input type="checkbox" name="parameter[location][apply]" <? if($parameter['location']['apply'] == 1){echo 'checked';} ?> value="1">
									</td>
									<td>
										<input type="text" name="parameter[location][th]" value="<?=isset($parameter['location']['th']) ? $parameter['location']['th'] : 'สถานที่'; ?>">
									</td>
									<td>
										<input type="text" name="parameter[location][en]" value="<?=isset($parameter['location']['en']) ? $parameter['location']['en'] : 'Location'; ?>">
									</td>
								</tr>
								
								<tr>
									<td class="tac">
										<input type="hidden" name="parameter[division][apply]" value="0">
										<input type="checkbox" name="parameter[division][apply]" <? if($parameter['division']['apply'] == 1){echo 'checked';} ?> value="1">
									</td>
									<td>
										<input type="text" name="parameter[division][th]" value="<?=isset($parameter['division']['th']) ? $parameter['division']['th'] : 'แผนก'; ?>">
									</td>
									<td>
										<input type="text" name="parameter[division][en]" value="<?=isset($parameter['division']['en']) ? $parameter['division']['en'] : 'Division'; ?>">
									</td>
								</tr>
								<tr>
									<td class="tac">
										<input type="hidden" name="parameter[department][apply]" value="0">
										<input type="checkbox" name="parameter[department][apply]" <? if($parameter['department']['apply'] == 1){echo 'checked';} ?> value="1">
									</td>
									<td>
										<input type="text" name="parameter[department][th]" value="<?=isset($parameter['department']['th']) ? $parameter['department']['th'] : 'สาขา'; ?>">
									</td>
									<td>
										<input type="text" name="parameter[department][en]" value="<?=isset($parameter['department']['en']) ? $parameter['department']['en'] : 'Department'; ?>">
									</td>
								</tr>
								<tr>
									<td class="tac">
										<input type="hidden" name="parameter[team][apply]" value="0">
										<input type="checkbox" name="parameter[team][apply]" <? if($parameter['team']['apply'] == 1){echo 'checked';} ?> value="1">
									</td>
									<td>
										<input type="text" name="parameter[team][th]" value="<?=isset($parameter['team']['th']) ? $parameter['team']['th'] : 'ทีม'; ?>">
									</td>
									<td>
										<input type="text" name="parameter[team][en]" value="<?=isset($parameter['team']['en']) ? $parameter['team']['en'] : 'Teams'; ?>">
									</td>
								</tr>
								<tr>
									<td class="tac">
										<input type="hidden" name="parameter[group][apply]" value="0">
										<input type="checkbox" name="parameter[group][apply]" <? if($parameter['group']['apply'] == 1){echo 'checked';} ?> value="1">
									</td>
									<td>
										<input type="text" name="parameter[group][th]" value="<?=isset($parameter['group']['th']) ? $parameter['group']['th'] : 'กลุ่ม'; ?>">
									</td>
									<td>
										<input type="text" name="parameter[group][en]" value="<?=isset($parameter['group']['en']) ? $parameter['group']['en'] : 'Groups'; ?>">
									</td>
								</tr>
							</tbody>
						</table>

					</div>
				</div>

				<div class="row">
					<div class="col-md-12 mt-4">
						<table class="basicTable" border="0">
							<thead>
								<tr>
									<th colspan="6"><?=strtoupper($lng['Default setting Organization'])?></th>
								</tr>
								<tr>
									<th><?=$lng['Apply']?></th>
									<th><?=$lng['Company']?></th>
									<th><?=$lng['Location']?></th>
									<th><?=$lng['Division']?></th>
									<th><?=$lng['Department']?></th>
									<th><?=$lng['Teams']?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="tal">
										<input type="hidden" name="org[apply]" value="0">
										<input type="checkbox" name="org[apply]" <? if($org['apply'] == 1){echo 'checked';} ?> value="1">
									</td>
									<td>
										<input type="hidden" name="org[company]" value="1" readonly>
										<input type="text" value="<?=isset($emp_grp['company'][$lang]) ? $emp_grp['company'][$lang] : $row11['compname_'.$lang]; ?>" readonly>
									</td>
									<td>
										<input type="hidden" name="org[branch]" value="1" readonly>
										<input type="text" value="<?=isset($emp_grp['location'][$lang]) ? $emp_grp['location'][$lang] : ' Head office'; ?>" readonly>
									</td>
									<td>
										<input type="hidden" name="org[division]" value="1" readonly>
										<input type="text" value="<?=isset($emp_grp['division'][$lang]) ? $emp_grp['division'][$lang] : 'No Division'; ?>" readonly>
									</td>
									<td>
										<input type="hidden" name="org[department]" value="1" readonly>
										<input type="text" value="<?=isset($emp_grp['department'][$lang]) ? $emp_grp['department'][$lang] : 'No Department'; ?>" readonly>
									</td>
									<td>
										<input type="hidden" name="org[team]" value="1" readonly>
										<input type="text" value="<?=isset($emp_grp['team'][$lang]) ? $emp_grp['team'][$lang] : 'No Teams'; ?>" readonly>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

			</div>
		</div>

	</form>
</div>
<script type="text/javascript">
	$(document).ready(function() {

		var activeTab = localStorage.getItem('activeTab10');
		$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
			localStorage.setItem('activeTab10', $(e.target).data('target'));
		});
		if(activeTab){
			$('#myTab a[data-target="' + activeTab + '"]').tab('show');
		}else{
			$('#myTab a[data-target="#Defaultsetup"]').tab('show');
		}


		$("#companySetupForm").submit(function(e){ 
			e.preventDefault();
			$("#submitbtn i").removeClass('fa-save').addClass('fa-refresh fa-spin');
			var data = $(this).serialize();
			$.ajax({
				url: AROOT+"def_settings/ajax/update_default_companySetup.php",
				type: 'POST',
				data: data,
				success: function(result){
					
					if(result == 'success'){
						$("body").overhang({
							type: "success",
							message: '<i class="fa fa-check"></i>&nbsp;&nbsp;Data updated successfuly',
							duration: 2,
						})
					}else{
						$("body").overhang({
							type: "warn",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+result,
							duration: 4,
							closeConfirm: true
						})
					}
					setTimeout(function(){
						$("#submitbtn i").removeClass('fa-refresh fa-spin').addClass('fa-save');
						$("#submitbtn").removeClass('flash');
						$("#sAlert").fadeOut(200);
					},300);
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
</script>
	