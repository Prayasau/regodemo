<?php

	if(session_id()==''){session_start();}
	ob_start();
	include('../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	include(DIR.'files/payroll_functions.php');
	include(DIR.'files/arrays_'.$_SESSION['rego']['lang'].'.php');

	$empinfo = getEmployeeInfo($cid, $_SESSION['rego']['emp_id']);
	//var_dump($empinfo); exit;
	$field = unserialize($sys_settings['payslip_field']);
	//var_dump($field); 
	$edata = getEntityData($empinfo['entity']);
	//var_dump($edata); 

	$pr_paydate = date('d-m-Y');
	if(!isset($_GET['m'])){$month = $_SESSION['rego']['cur_month'];}else{$month = $_GET['m'];}
	$sql = "SELECT * FROM ".$cid."_payroll_months WHERE month = '".$_SESSION['rego']['mob_year']."_".$month."'";
	if($res = $dbc->query($sql)){
		if($row = $res->fetch_assoc()){
			$pr_paydate = $row['paydate'];
		}
	}
	if($lang == 'th'){
		$paydate = substr($pr_paydate,0,-4).$_SESSION['rego']['year_th'];
		$period = $months[(int)$month].' '.$_SESSION['rego']['year_th'];
	}else{
		$paydate = $pr_paydate;
		$period = $months[(int)$month].' '.$_SESSION['rego']['year_en'];
	}
	
	$sql = "SELECT emp_id FROM ".$_SESSION['rego']['payroll_dbase']." WHERE emp_id = '".$_SESSION['rego']['emp_id']."' AND month = '".$month."' AND entity = '".$empinfo['entity']."' AND emp_group = '".$empinfo['emp_group']."'";

	$res = $dbc->query($sql);
	$rows = $res->num_rows;
	$nr = 0;
	$style = '
		<style>
			.page {
				width: 21cm;
				height: 29.7cm;
				margin: 30mm 45mm 30mm 45mm;
				margin: 0 auto;
				margin-top: 50px;
				background:#fff;
				padding:40px;
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-sizing: border-box;
			}
			body, div, p, table td, table th {
				font-family: "leelawadee", "garuda";
				font-family: "garuda";
				font-size: 13px;
			}
			table.wrap {
				border-collapse:collapse;
				border:0px solid red;
				width:100%;
				margin:6px 0 0px 0;
			}
			table.topslip {
				border-collapse:collapse;
				border:0px #000 solid;
				table-layout:auto;
			}
			table.topslip th {
				padding:3px 0px;
				white-space:nowrap;
				text-align:left;
			}
			table.topslip td {
				padding:3px 5px;
				white-space:nowrap;
				text-align:left;
			}
			table.payslip {
				border-collapse:collapse;
				border:0px #000 solid;
				table-layout:fixed;
				width:100%;
				
			}
			table.payslip th, table.payslip td {
				border:0.1em solid #000;
				padding:5px 10px;
				vertical-align:middle;
				font-size:13px;
				white-space:nowrap;
			}
			table.payslip th {
				background:#eee;
				text-align:center;
			}
			table.payslip td {
				font-weight:normal;
				text-align:right;
				vertical-align:baseline;
				padding:7px 10px;
			}
		</style>';

	$html = '<html><body>';
	//$pslp['rate'] = 'Y';
	$bank_codes = unserialize($rego_settings['bank_codes']);
	//$pattern = '%%%-%-%%%%%-%';//999-9-99999-9
	//var_dump($bank_codes);
	if($row = $res->fetch_object()){
		$data = getPayslipData($row->emp_id, $month, $lang, $sys_settings['payslip_rate']);
		$empinfo = getEmployeeInfo($cid, $row->emp_id);
		//var_dump($empinfo); exit;
		$title[''] = '';
		$bank_account = $empinfo['bank_account'];
		$bank_code = '';
		if(!empty($empinfo['bank_code'])){
			if(isset($bank_codes[$empinfo['bank_code']])){
				$bank_code = $bank_codes[$empinfo['bank_code']][$lang];
			}
		}
	
		$html .= '
			
			<table border="0" style="width:100%">
				<tr>';
					if(!empty($edata['logofile'])){ $html .= '<td style="width:10px;padding:0 20px 0 0; vertical-align:top"><img style="height:50px;max-width:350px" src="../'.$edata['logofile'].'?'.time().'" /></td>';}
		$html .= '<td style="padding:0;white-space:nowrap;height:30mm;vertical-align:top"><span style="font-size:22px"><b>'.$edata[$lang.'_compname'].'</b></span><br />'.nl2br($edata[$lang.'_address']).'</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:left;font-size:18px;padding-top:15px"><b>ใบจ่ายเงินเดือน<br>PAYSLIP</b></td>
				</tr>
			</table>
			
			<div style="top:45mm; left:95mm; width:85mm; height:25mm; position:absolute; border-radius:10px; background:#f9f9f9; padding:20px 0 0 40px; font-size:14px">
				'.$title[$empinfo['title']].' '.$data['name_'.$lang].'<br>
				'.$empinfo['reg_address'].'<br>
				'.$empinfo['sub_district'].' '.$empinfo['district'].'<br>
				'.$empinfo['province'].' '.$empinfo['postnr'].'<br>
			</div>
			<div style="top:88mm; right:10mm; width:3mm; position:absolute; border-bottom:0.1em solid #666"></div>
			
			<table border="0" style="margin-top:35mm;width:100%;border-collapse:collapse;"><tr><td style="text-align:left">
			
				<table class="topslip" border="0">
					<tr>
						<td><b>Employee / พนักงาน : </b>'.$data['emp_id'].' - '.$data['name_'.$lang].'</td>
					</tr>
					<tr>
						<td><b>Position / ตำแหน่ง : </b>'.$data['position'].'</td>
					</tr>
					<tr>
						<td><b>Bank / ธนาคาร : </b>'.$bank_code.'</td>
					</tr>
				</table>
				
			</td><td style="text-align:right">
			
				<table class="topslip" border="0">
					<tr>
						<td><b>Period / งวดเดือน : </b>'.$period.'</td>
					</tr>
					<tr>
						<td><b>Payroll date / วันที่จ่าย : </b>'.$paydate.'</td>
					</tr>
					<tr>
						<td><b>Account no. / เลขที่บัญชี : </b>'.$bank_account.'</td>
					</tr>
				</table>
			
			</td></tr></table>
	
			<table class="payslip" border="1" style=" margin-top:10px">
				<tr>
					<th style="width:25%">รายได้<br>Earnings</th>
					<th style="width:10%">จำนวน<br>Number</th>
					<th style="width:15%">จำนวนเงิน<br>Amount</th>
					<th style="width:25%">รายการหัก<br>Deductions</th>
					<th style="width:10%">จำนวน<br>Number</th>
					<th style="width:15%">จำนวนเงิน<br>Amount</th>
				</tr>
				<tr>
					<td valign="top" style="text-align:left; height:440px;line-height:150%">';
					foreach($data['earnings'] as $k=>$v){
						$html .= $v[0].'<br>';
					}
			$html .= '</td>
					<td valign="top" style="line-height:150%">';
					foreach($data['earnings'] as $k=>$v){
						$html .= $v[1].'<br>';
					}
			$html .= '</td>
					<td valign="top" style="line-height:150%">';
					foreach($data['earnings'] as $k=>$v){
						$html .= $v[2].'<br>';
					}
			$html .= '</td>
					<td valign="top" style="text-align:left;line-height:150%">';
					foreach($data['deduct'] as $k=>$v){
						$html .= $v[0].'<br>';
					}
			$html .= '</td>
					<td valign="top" style="line-height:150%">';
					foreach($data['deduct'] as $k=>$v){
						$html .= $v[1].'<br>';
					}
			$html .= '</td>
					<td valign="top" style="line-height:150%">';
					foreach($data['deduct'] as $k=>$v){
						$html .= $v[2].'<br>';
					}
			$html .= '</td>
				</tr>
				<tr>
					<th>รวมเงินได้<br>Total Earnings</th>
					<td colspan="2" style="vertical-align:bottom"><b>'.$data['gross_income'].'</b></td>
					<th>รวมรายการหัก<br>Total Deductions</th>
					<td colspan="2" style="vertical-align:bottom"><b>'.$data['tot_deductions'].'</b></td>
				</tr>
				<tr>
					<td colspan="4" style="font-size:14px;background:#ddd"><b>เงินรับสุทธิ / Net to Pay</b></td>
					<td colspan="2" style="vertical-align:bottom;font-size:14px;background:#ddd"><b>'.$data['net_income'].'</b></td>
				</tr>
			</table>
	
			<table class="payslip" border="1" style="margin-top:15px">
				<tr>
					<td>';
					if(isset($field['ytd1'])){ $html .= $data['asalary'];}
					$html .= '</td>
					<td>';
					if(isset($field['ytd2'])){ $html .= $data['atax'];}
					$html .= '</td>';
					if(isset($field['ytd3']) && $empinfo['calc_pvf'] && $data['aprovfund'] > 0){ 
						$html .= '<td>'.$data['aprovfund'].'</td>';
					}
					$html .= '<td>';
					if(isset($field['ytd4'])){ $html .= $data['asocial'];}
					$html .= '</td>
					<td>';
					if(isset($field['ytd5'])){ $html .= $data['aother'];}
					$html .= '</td>
				</tr>
				<tr>
					<th>เงินได้สะสมต่อปี<br>YTD. Income</th>
					<th>ภาษีสะสมต่อปี<br>YTD. Tax</th>';
					if(isset($field['ytd3']) && $empinfo['calc_pvf'] && $data['aprovfund'] > 0){ 
						$html .= '<th>เงินสะสมกองทุนต่อปี<br>YTD. Prov. Fund</th>';
					}
					$html .= '
					<th><span>เงินสะสมกองทุนต่อปี</span><br>YTD. Social SF</th>
					<th>ค่าลดหย่อนอื่นๆ<br>Other Allowance</th>
				</tr>
			</table></div>';
	
	}
	$html .= '</body></html>';	
	
	//var_dump($sys_settings); exit;
	//echo $style.$html; exit;
	
	require_once(DIR."mpdf7/vendor/autoload.php");

	//class mPDF ([ string $mode [, mixed $format [, float $default_font_size [, string $default_font [, float $margin_left , float $margin_right , float $margin_top , float $margin_bottom , float $margin_header , float $margin_footer [, string $orientation ]]]]]])
	$mpdf = new mPDF('UTF-8', 'A4-P', 12, 'leelawadee', 10, 10, 10, 10, 0, 0);
	$mpdf->SetTitle($edata[$lang.'_compname'].' ('.strtoupper($_SESSION['rego']['cid']).') - Payslips '.date('F', mktime(0, 0, 0, $month, 1)).' '.$_SESSION['rego']['mob_year']);
	
	$mpdf->WriteHTML($style,1);
	$mpdf->WriteHTML($html);
	//$mpdf->Output();
	//$mpdf->Output($_SESSION['rego']['cid'].'_A4_payslips_'.$month.'_'.$_SESSION['rego']['mob_year'].'.pdf','I');
	
	$dir = DIR.$_SESSION['rego']['cid'].'/archive/';
	$root = ROOT.$_SESSION['rego']['cid'].'/archive/';
	
	$baseName = $_SESSION['rego']['cid'].'_payslips_'.$_SESSION['rego']['curr_month'].'-'.$_SESSION['rego']['year_'.$lang];
	
	$extension = 'pdf';		
	$filename = getFilename($baseName, $extension, $dir);
	
	$doc = $lng['Payslips'].' '.$month.'-'.$_SESSION['rego']['year_'.$lang];

	//$mpdf->Output(iconv("UTF-8", "TIS-620",$dir.$filename),'F');
	$mpdf->Output($filename,'I');





















