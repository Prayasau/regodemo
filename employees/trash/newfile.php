<div style= "display: none;">
							<table id="datatables50" class="dataTable hoverable selectable nowrap" >

								<thead>
									<tr>
										<th class="par30"><?=$lng['Emp. ID']?></th>
										<th class="tal par30"><?=$lng['Employee name']?></th>
										<th class="tal "><?=$lng['Scan ID']?></th>
										<th class="tal "><?=$lng['Title']?></th>
										<th class="tal "><?=$lng['First name']?></th>
										<th class="tal "><?=$lng['Last name']?></th>
										<th class="tal "><?=$lng['Name in English']?></th>
										<th class="tal "><?=$lng['Birthdate']?></th>
										<th class="tal "><?=$lng['Nationality']?></th>
										<th class="tal "><?=$lng['Gender']?></th>
										<th class="tal "><?=$lng['Maritial status']?></th>
										<th class="tal "><?=$lng['Religion']?></th>
										<th class="tal "><?=$lng['Military status']?></th>
										<th class="tal "><?=$lng['Height']?></th>
										<th class="tal "><?=$lng['Weight']?></th>
										<th class="tal "><?=$lng['Blood type']?></th>
										<th class="tal "><?=$lng['Driving license No.']?></th>
										<th class="tal "><?=$lng['License expiry date']?></th>
										<th class="tal "><?=$lng['ID card']?></th>
										<th class="tal "><?=$lng['ID card expiry date']?></th>
										<th class="tal "><?=$lng['Tax ID no.']?></th>
										
										<th class="tal "><?=$lng['Registered address']?></th>
										<th class="tal "><?=$lng['Sub district']?></th>
										<th class="tal "><?=$lng['District']?></th>
										<th class="tal "><?=$lng['Province']?></th>
										<th class="tal "><?=$lng['Postal code']?></th>
										<th class="tal "><?=$lng['Country']?></th>
										<th class="tal "><?=$lng['Latitude']?></th>
										<th class="tal "><?=$lng['Longitude']?></th>
										<th class="tal "><?=$lng['Current address']?></th>
										<th class="tal "><?=$lng['Personal phone']?></th>
										<th class="tal "><?=$lng['Work phone']?></th>
										<th class="tal "><?=$lng['Personal email']?></th>
										<th class="tal "><?=$lng['Work email']?></th>
										<th class="tal "><?=$lng['Username Options']?></th>
										<th class="tal "><?=$lng['Username']?></th>
										
										<th class="tal "><?=$lng['Joining date']?></th>
										<th class="tal "><?=$lng['Probation due date']?></th>
										<th class="tal "><?=$lng['Employee type']?></th>
										<th class="tal "><?=$lng['Accounting code']?></th>
										<th class="tal "><?=$lng['Groups']?></th>
										
										<th class="tal "><?=$lng['Time registration']?></th>
										<th class="tal "><?=$lng['Take selfie']?></th>
										<th class="tal "><?=$lng['Work From Home']?></th>
										
										<th class="tal "><?=$lng['Annual leave (days)']?></th>
										
										<th class="tal "><?=$lng['Company']?></th>
										<th class="tal "><?=$lng['Location']?></th>
										<th class="tal "><?=$lng['Division']?></th>
										<th class="tal "><?=$lng['Department']?></th>
										<th class="tal "><?=$lng['Teams']?></th>
										
										<th class="par30"><?=$lng['Contract type']?></th>
										<th class="tal par30"><?=$lng['Calculation base']?></th>
										<th class="tal "><?=$lng['Bank code']?></th>
										<th class="tal "><?=$lng['Bank name']?></th>
										<th class="tal "><?=$lng['Bank branch']?></th>
										<th class="tal "><?=$lng['Bank account no.']?></th>
										<th class="tal "><?=$lng['Bank account name']?></th>
										<th class='tal'><?=$lng['Payment type']?></th>
										<th class='tal'><?=$lng['Accounting code']?></th>
										<th class='tal'><?=$lng['Groups']?></th>
										<th class='tal'><?=$lng['Tax calculation method']?></th>
										<th class='tal'><?='Calculate tax'?></th>
										<th class='tal'><?=$lng['Tax Residency Status']?></th>
										<th class='tal'><?='Income Section'?></th>
										<th class='tal'><?=$lng['Modify Tax amount']?></th>
										<th class='tal'><?=$lng['Calculate SSO']?></th>
										<th class='tal'><?=$lng['SSO paid by']?></th>
										<th class='tal'><?=$lng['Government house banking']?></th>
										<th class='tal'><?=$lng['Savings']?></th>
										<th class='tal'><?=$lng['Legal execution deduction']?></th>
										<th class='tal'><?=$lng['Kor.Yor.Sor (Student loan)']?></th>
										
									</tr>
								</thead>
								<tbody >

									<? if(isset($alltempdata) && is_array($alltempdata)){ 
										foreach ($alltempdata as $key => $value) { ?>
										 	
											<tr data-id="<?=$value['emp_id']?>">
												<td><span id="rowIdDatatableSpan" style="display: none;"><?=$value['id']?></span><?=$value['emp_id']?></td>
												<td><?=$value['en_name'];?></td>
												<td><?=$value['sid']?></td>
												<td><?=$title[$value['title']];?></td>
												<td><?=$value['firstname']?></td>
												<td><?=$value['lastname']?></td>
												<td><?=$value['en_name']?></td>
												<td><?=$value['birthdate']?></td>
												<td><?=$value['nationality']?></td>
												<td><?=$gender[$value['gender']];?></td>
												<td><?=$maritial[$value['maritial']];?></td>
												<td><?=$religion[$value['religion']];?></td>
												<td><?=$military_status[$value['military_status']];?></td>
												<td><?=$value['height']?></td>
												<td><?=$value['weight']?></td>
												<td><?=$value['bloodtype']?></td>
												<td><?=$value['drvlicense_nr']?></td>
												<td><?=$value['drvlicense_exp']?></td>
												<td><?=$value['idcard_nr']?></td>
												<td><?=$value['idcard_exp']?></td>
												<td><?=$value['tax_id']?></td>
												
												<td><?=$value['reg_address'];?></td>
												<td><?=$value['sub_district'];?></td>
												<td><?=$value['district'];?></td>
												<td><?=$value['province'];?></td>
												<td><?=$value['postnr'];?></td>
												<td><?=$value['country'];?></td>
												<td><?=$value['latitude'];?></td>
												<td><?=$value['longitude'];?></td>
												<td><?=$value['cur_address'];?></td>
												<td><?=$value['personal_phone'];?></td>
												<td><?=$value['work_phone'];?></td>
												<td><?=$value['personal_email'];?></td>
												<td><?=$value['work_email'];?></td>
												<td><?=$username_option[$value['username_option']]?></td>
												<td><?=$value['username'];?></td>
												
												<td><?=$value['joining_date'];?></td>
												<td><?=$value['probation_date'];?></td>
												<td><?=$emp_type[$value['emp_type']];?></td>
												<td><?php

												if($value['account_code'] == '1')
												{
													echo $lng['Indirect'];
												}
												else if($value['account_code'] == '0')
												{
													echo $lng['Direct'];
												}


												?></td>
												<td><?=$getAllGroups[$value['groups']];?></td>
												
												<td>
													<?php 
														if($value['time_reg'] == '0')
														{
															echo  $lng['No'] ;
														}
														else if($value['time_reg'] == '1')
														{
															echo  $lng['Yes'] ;
														}
													?>
												</td>												
												<td>
													<?php 
														if($value['selfie'] == '0')
														{
															echo  $lng['No'] ;
														}
														else if($value['selfie'] == '1')
														{
															echo  $lng['Yes'] ;
														}
													?>
												</td>												
												<td>
													<?php 
														if($value['workFromHome'] == '0')
														{
															echo  $lng['No'] ;
														}
														else if($value['workFromHome'] == '1')
														{
															echo  $lng['Yes'] ;
														}
													?>
												</td>
												
												<td><?=$value['en_name'];?></td>
												<td><?=$value['annual_leave'];?></td>
												
												<td><?=$company_name_data[$value['company']][$_SESSION['rego']['lang']];?></td>
												<td><?=$branch_name_data[$value['location']][$_SESSION['rego']['lang']];?></td>
												<td><?=$division_name_data[$value['division']][$_SESSION['rego']['lang']];?></td>
												<td><?=$department_name_data[$value['department']][$_SESSION['rego']['lang']];?></td>
												<td><?=$teams_name_data[$value['team']][$_SESSION['rego']['lang']];?></td>
												
												<td><?=$contract_type[$value['contract_type']];?></td>
												<td><?=$calc_base[$value['calc_base']]?></th>
            									<td><?=$value['bank_code']?></th>
            									<td><?=$bank_codes[$value['bank_name']]['en']?></th>
            									<td><?=$value['bank_branch']?></th>
            									<td><?=$value['bank_account']?></th>
            									<td><?=$value['bank_account_name']?></th>
            									<td><?=$pay_type[$value['pay_type']]?></th>
            									<td><?=$accountCodeArray[$value['account_code']]?></th>
            									<td><?=$getAllGroups[$value['groups']]?></th>
            									<td><?=$calcmethod[$value['calc_method']]?></th>
            									<td><?=$calctax[$value['calc_tax']]?></th>
            									<td><?=$tax_residency_status[$value['tax_residency_status']]?></th>
            									<td><?=$income_section[$value['income_section']]?></th>
            									<td><?=$value['modify_tax']?></th>
            									<td><?=$noyes01[$value['calc_sso']]?></th>
            									<td><?=$sso_paidby[$value['sso_by']]?></th>
            									<td><?=$value['gov_house_banking']?></th>
            									<td><?=$value['savings']?></th>
            									<td><?=$value['legal_execution']?></th>
            									<td><?=$value['kor_yor_sor']?></th>
											</tr>

									<? } } ?>

								</tbody>
							</table>
						</div>
						<script>
						var selectionSelect = $('#section_select').val();

						if(continue_sel){
							let i1=0;
							$("table#showHideClmss2 div.SumoSelect:nth-child("+selectionSelect+") li").each(function(){
								console.log($(this));
								i1++;
								if($(this).hasClass('selected')){
									if(inArray('#dat'+selectionSelect+i1)==-1)
									new_show_hide_cols_list.push('#dat'+selectionSelect+i1);
								}else{
									while($.inArray('#dat'+selectionSelect+i1)!=-1)
										new_show_hide_cols_list.splice(new_show_hide_cols_list.indexOf('#dat'+selectionSelect+i1),1);
								}
							});
						}
											
						</script>