<?php
	//$year['en'] = date('Y');
	//$year['th'] = date('Y')+543;

	//$branch = sprintf("%06d",$entityBranches[$_SESSION['rego']['gov_branch']]['code']);
	//$data = getSSOattach($_SESSION['rego']['payroll_dbase'], $_SESSION['rego']['gov_month'], $lang, $pr_settings['sso_act_max']);
	//var_dump($data); exit;
	
	
?>	
<style>
	table.blank th {
		padding:0 8px 0 0 !important;
		width:1px !important;
		white-space:nowrap !important;
		font-weight:600;
	}
	table.blank td {
		padding:0 !important;
	}
</style>
<link rel="stylesheet" type="text/css" media="screen" href="../assets/css/formTable.css?<?=time()?>">
	
 <div class="A4form">
 
 	<div style="position:absolute; top:20px; right:30px;">
		<select id="actMax" style="display:inline-block; margin:0 8px 0 0">
			<option <? if($pr_settings['sso_act_max'] == 'max'){echo 'selected';}?> value="max">Max. <?=number_format($rego_settings['sso_max_wage'])?> THB</option>
			<option <? if($pr_settings['sso_act_max'] == 'act'){echo 'selected';}?> value="act">Actual amount</option>
		</select>
		<? //if($data['d']){ ?>
		<button data-type="p" type="button" class="print btn btn-primary" style="margin-top:-3px !important"><i class="fa fa-print"></i>&nbsp; <?=$lng['Print']?></button>
		<button data-type="a" type="button" class="print btn btn-primary" style="margin-top:-3px !important; margin-left:3px"><i class="fa fa-print"></i>&nbsp; <?=$lng['Print & Archive']?></button>
		<? //} ?>
	</div>
 <!--<div style="width:210mm;margin:0 auto;margin-top:10px; background:#fff; padding:30px 30px 100px; height:297mm; box-shadow:0 0 10px rgba(0,0,0,0.5);">-->
			<form id="pnd1_attach">
			<div style="font-size:16px; margin-bottom:5px"><b>Attachment for Social Security form<!-- / รายละเอียดการนําส่งเงินสมทบ--></b></div>
			<table class="formTable toptable" border="0" style="border-bottom:0;">
				<tr>
					<td style="width:65%">
						ชื่อสถานประกอบการ : <span style="font-size:14px"><b><?=$edata['en_compname']?></b></span><br />
						เลขประจำตัวผู้เสียภาษีอากร : <b><?=$edata['sso_account']?></b><br>
					</td>	
					<td>
						สำหรับค่าจ้างเดือน : <b><?=$months[$_SESSION['rego']['gov_month']].'</b> พ.ศ. <b>'.$_SESSION['rego']['year_en']?></b><br>
						ลำดับสาขาที่ : <b><?=$branch?></b>
					</td>
				</tr>
			</table>

			<table class="formTable taxtable" border="1">
				<thead>
				<tr>
					<th style="vertical-align:middle; width:10px">ลำดับที่</th>
					<th>เลขประจำตัวประชาชน</th>
					<th>คำนำหน้านาม-ชื่อ-ชื่อสกุลผู้ประกันตน</th>
					<th style="vertical-align:middle;">ค่าจ้างที่จ่ายจริง</th>
					<th style="vertical-align:middle;">เงินสมทบผู้ประกันตน<br /> (ค่าจ้างที่ใช้ในการคำนวณไม่ต่ำกว่า<br /> 1,650 บาท และไม่เกิน 15,000 บาท )</th>
				</tr>
				</thead>
				<tbody>
				<? if($data['d']){ foreach($data['d'] as $k=>$v){ ?>
				<tr>
					<td style="text-align:right"><?=$k?>&nbsp;</td>
					<td style="text-align:left"><span style="font-weight:600;"><?=$v['tax_id']?></span></td>
					<td style="text-align:left; width:50%"><?=$v['title'].' '.$v['name']?></td>
					<td style="text-align:right"><?=$v['basic_salary']?></td>
					<td style="text-align:right"><?=$v['sso']?></td>
				</tr>
				<? } } ?>
				<tr>
					<th colspan="3" style="text-align:right"><b>รวม</th>
					<th style="text-align:right; vertical-align:bottom; width:100px"><b><?=$data['tot_salary']?></b></th>
					<th style="text-align:right; vertical-align:bottom; width:100px"><b><?=$data['tot_social']?></b></th>
				</tr>
				</tbody>
			</table>
			
			<table class="formTable toptable" border="0" style="border-top:0;border-bottom:0;">
				<tr>
					<td style="line-height:160%; width:55%;font-size:11px; padding-bottom:0">
						<b>คำชี้แจง</b><br>
						<ul style="list-style-type:decimal;padding:0 0 0 25px;margin:0">
							<li>กรณีลูกจ้างเข้าใหม่ ให้ยื่นแบบ สปส.1-03 หรือ สปส.1-03/1 ก่อน โดยยื่นแบบทางไปรษณีย์  หรือ  สำนักงานประกันสังคมในท้องที่ที่สถานประกอบการตั้ง</li>
							<li>สำหรับผู้ประกันตนที่เป็นคนต่างด้าวให้กรอกเลขที่บัตรประกันสังคมลงในช่องเลขประจำตัวประชาชน</li>
							<li>ในช่อง 4 ให้กรอกจำนวนค่าจ้างที่จ่ายจริง ในช่อง 5  การคำนวณเงินสมทบสำหรับผู้ที่ได้รับค่าจ้างต่ำกว่า 1,650 บาท ให้คำนวณจาก 1,650 บาท และผู้ที่ได้รับค่าจ้างเกินกว่า 15,000 บาท ให้คำนวณจาก  15,000 บาท</li>
							<li>เงินสมทบแต่ละคน หากมีเศษตั้งแต่ 50 สตางค์ขึ้นไป ให้ปัดเป็น 1 บาท ถ้าน้อยกว่า 50 สตางค์ ให้ปัดทิ้ง และให้นายจ้างนำส่งเงินสมทบในส่วนนายจ้างเท่ากับจำนวนเงินสมทบของผู้ประกันตน ที่มีการการปัดเศษสตางค์แล้ว</li>
							<li>เพื่อประโยชน์ในการใช้สิทธิขอรับประโยชน์ทดแทนของผู้ประกันตน ทุกครั้งที่นำส่งเงินสมทบ  กรุณากรอกรายการให้ครบถ้วนถูกต้องและชัดเจนด้วยเครื่องพิมพ์หรือลายมือตัวบรรจง</li>
							<li>สำหรับผู้ประกันตนที่ไม่มีค่าจ้างให้กรอกในช่อง 1-5 ด้วย</li>
						</ul>
						<b>คำเตือน</b>
						<ul style="list-style-type:decimal;padding:0 0 0 25px;margin:0">
							<li>การจ่ายค่าจ้างต่ำกว่าค่าจ้างขั้นต่ำรายวันตามที่กฎหมายกำหนด  มีความผิดตาม พ.ร.บ. คุ้มครองแรงงาน</li>
							<li>การกรอกข้อความเป็นเท็จมีความผิดตามประมวลกฎหมายอาญา</li>
						</ul>
					</td>
				</tr>
				
			</table>
			<table class="formTable toptable" border="0" style="border-top:0;">
				<tr>
					<td style="position:relative; padding:15px 0 0 25px">
						<!--<img style="width:200px; position:absolute; top:15px; left:30px" src="../<?php //=$cid?>/dig_signature.png" />
						<img style="width:70px; position:absolute; top:0px; right:15px" src="../<?php //=$cid?>/stamp70.png" />-->
					</td>
					<td style="line-height:190%; padding:0 10px 10px 10px; width:45%">
						<table class="blank" border="0" width="100%"><tr>
                     <th><?=$lng['Name']?> : </th><td><input name="form_name" class="formName" placeholder="__________________________________________________________________" style="width:100%;" type="text" value="<?=$name_position['name']?>"></td></tr></table>
                  <table class="blank" border="0" width="100%"><tr>      
                     <th><?=$lng['Position']?> : </th><td><input name="form_position" class="formPosition" placeholder="__________________________________________________________________" style="width:100%;" type="text" value="<?=$name_position['position']?>"></td></tr></table>
                  <table class="blank" border="0" width="100%">
							<tr>
								<th><?=$lng['Filling date']?> : </th>
								<td>
									<span class="formDay"><?=$_SESSION['rego']['formdate']['d']?> </span>
									<span class="formMonth"><?=$_SESSION['rego']['formdate']['m']?> </span>
									<span class="formYear"><?=$_SESSION['rego']['formdate'][$lang.'y']?></span>
								</td>
							</tr>
						</table>
						<!--<b>Signature </b> :&nbsp;&nbsp; <img style="width:200px" src="../<? //=$cid?>/dig_signature.png" />-->
					</td>
				</tr>
			</table>
			</form>

</div>

	<script type="text/javascript">
		
		$(function() {
			
			$(document).on("click", ".print", function(e) {
				var type = $(this).data('type');
				window.open(ROOT+'payroll/print/print_sso_attach_th.php?'+type, '_blank')
			});
			
			$(document).on("change", "#actMax", function(e) {
				var val = $(this).val();
				$.ajax({
					url: ROOT+"payroll/ajax/update_sso_act_max.php",
					data: {val: val},
					success: function(response) {
						//$('#dump').html(response)
						location.reload();
					},
					error: function (xhr, ajaxOptions, thrownError) {
						//alert(thrownError);
					}
				});
			});
			
		})
	
	</script>













