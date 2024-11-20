<?php
	if(session_id()==''){session_start(); ob_start();}
	include('../../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	include(DIR.'files/arrays_'.$lang.'.php');
	include(DIR.'files/payroll_functions.php');
	
	$name_position = getFormNamePosition($cid);
	$edata = getEntityData($_SESSION['rego']['gov_entity']);
	$address = unserialize($edata[$lang.'_addr_detail']);
	$sso_codes = unserialize($edata['sso_codes']);

	$tin = str_replace('-','',$edata['tax_id']);
	if(strlen($tin)!== 13){$tin = '?????????????';}
	$tin = str_split($tin);
	
	$comma = '';
	if($lang == 'en'){$comma = ',';}
	$comp_address = $address['number'];
	if(!empty($address['moo'])){$comp_address .= $comma.'  ม.'.$address['moo'];}
	if(!empty($address['lane'])){$comp_address .= $comma.' '.$address['lane'];}
	if(!empty($address['road'])){$comp_address .= $comma.' '.$address['road'];}
	if(!empty($address['subdistrict'])){$comp_address .= $comma.' '.$address['subdistrict'];}
	if(!empty($address['district'])){$comp_address .= $comma.' '.$address['district'];}
	if(!empty($address['province'])){$comp_address .= $comma.' '.$address['province'];}
	if(!empty($address['postal'])){$comp_address .= ' '.$address['postal'];}
	
	require_once("../../mpdf7/vendor/autoload.php");

	$style = '
		<style>
			@page {
				margin: 10px 100px 10px 10px;
			}
			body, html {
				font-family: "leelawadee", "garuda";
				font-family: "garuda";
				color:#039;
			}
			body {
				background:url(../../images/pnd1_year_print.png) no-repeat;
				background-image-resize:6;
			}
			div.field13, div.field13n, div.field13c, div.field11, div.field12 {
				position:absolute;
				min-height:12px;
				min-width:20px;
				border:0px solid red;
				font-size:13px;
				font-weight:normal;
				line-height:100%;
				white-space:nowrap;
			}
			div.field13n {
				width:100px;
				text-align:right;
			}
			div.field13c {
				width:100px;
				text-align:center;
				border:0px solid red;
			}
			div.field11 {
				min-width:20px;
				font-size:11px;
				white-space:nowrap;
				overflow:hidden;
			}
			div.field12 {
				min-width:20px;
				font-size:12px;
			}
			div.signature {
				width:200px;
				position:absolute;
				border:0px solid red;
				text-align:center;
			}
			div.stamp {
				position:absolute;
				border:0px solid red;
				text-align:center;
			}
			i.fa {
				font-family: fontawesome;
				font-style:normal;
			}
			
		</style>';
	
	$emps = array($_REQUEST['id']);
	
	foreach($emps as $k=>$v){
	
		$empinfo = getEmployeeInfo($cid, $v);
		//var_dump($empinfo);
		$pid = str_replace('-','',$empinfo['tax_id']);
		if(strlen($pid)!== 13){$pid = '?????????????';}
		$pid = str_split($pid);
		
		$emp_name = $title[$empinfo['title']]. ' '.$empinfo[$_SESSION['rego']['lang'].'_name'];
		$emp_address = '';
		if(!empty($empinfo['reg_address'])){$emp_address .= $empinfo['reg_address'];}
		//if(!empty($empinfo['address2'])){$emp_address .= ' '.$empinfo['address2'];}
		if(!empty($empinfo['sub_district'])){$emp_address .= $comma.' '.$empinfo['sub_district'];}
		if(!empty($empinfo['district'])){$emp_address .= $comma.' '.$empinfo['district'];}
		if(!empty($empinfo['province'])){$emp_address .= $comma.' '.$empinfo['province'];}
		if(!empty($empinfo['postnr'])){$emp_address .= $comma.' '.$empinfo['postnr'];}
		
		$tot_income = 0; 
		$tot_tax = 0; 
		$tot_pvf = 0; 
		$tot_ssf = 0;
		
		if($res = $dbc->query("SELECT SUM(gross_income) as gross, SUM(tax_month) as tax, SUM(pvf_employee + psf_employee) as pvf, SUM(social) as sso FROM ".$_SESSION['rego']['payroll_dbase']." WHERE emp_id = '".$_REQUEST['id']."'")){
			if($row = $res->fetch_assoc()){
				$tot_income = $row['gross'];
				$tot_tax = $row['tax'];
				$tot_pvf = $row['pvf'];
				$tot_ssf = $row['sso'];
			}
		}
		$s = number_format($tot_tax, 2, '.', '');
		$chars = getThaiCharNumber($s);
	
	$html = '<html><body>

				<div class="field13" style="top:30.5mm;left:133mm">'.$tin[0].'</div>
				<div class="field13" style="top:30.5mm;left:139.5mm">'.$tin[1].'</div>
				<div class="field13" style="top:30.5mm;left:143.5mm">'.$tin[2].'</div>
				<div class="field13" style="top:30.5mm;left:148mm">'.$tin[3].'</div>
				<div class="field13" style="top:30.5mm;left:152.5mm">'.$tin[4].'</div>
				<div class="field13" style="top:30.5mm;left:159mm">'.$tin[5].'</div>
				<div class="field13" style="top:30.5mm;left:163.2mm">'.$tin[6].'</div>
				<div class="field13" style="top:30.5mm;left:167.5mm">'.$tin[7].'</div>
				<div class="field13" style="top:30.5mm;left:171.7mm">'.$tin[8].'</div>
				<div class="field13" style="top:30.5mm;left:176mm">'.$tin[9].'</div>
				<div class="field13" style="top:30.5mm;left:182.5mm">'.$tin[10].'</div>
				<div class="field13" style="top:30.5mm;left:186.5mm">'.$tin[11].'</div>
				<div class="field13" style="top:30.5mm;left:193.2mm">'.$tin[12].'</div>
				
				<div class="field13" style="top:36.6mm;left:20mm">'.$edata[$lang.'_compname'].'</div>
	
				<div class="field13" style="top:44.4mm;left:22mm">'.$comp_address.'</div>
	
				<div class="field13" style="top:54.5mm;left:133.2mm">'.$pid[0].'</div>
				<div class="field13" style="top:54.5mm;left:139.5mm">'.$pid[1].'</div>
				<div class="field13" style="top:54.5mm;left:143.5mm">'.$pid[2].'</div>
				<div class="field13" style="top:54.5mm;left:148mm">'.$pid[3].'</div>
				<div class="field13" style="top:54.5mm;left:152.5mm">'.$pid[4].'</div>
				<div class="field13" style="top:54.5mm;left:159mm">'.$pid[5].'</div>
				<div class="field13" style="top:54.5mm;left:163.2mm">'.$pid[6].'</div>
				<div class="field13" style="top:54.5mm;left:167.5mm">'.$pid[7].'</div>
				<div class="field13" style="top:54.5mm;left:171.7mm">'.$pid[8].'</div>
				<div class="field13" style="top:54.5mm;left:176mm">'.$pid[9].'</div>
				<div class="field13" style="top:54.5mm;left:182.5mm">'.$pid[10].'</div>
				<div class="field13" style="top:54.5mm;left:186.5mm">'.$pid[11].'</div>
				<div class="field13" style="top:54.5mm;left:193.2mm">'.$pid[12].'</div>
				
				<div class="field13" style="top:62.0mm;left:20mm">'.$emp_name.'</div>
	
				<div class="field13" style="top:71.2mm;left:22mm">'.$emp_address.'</div>
	
				<div class="field13" style="top:79.8mm;left:74.2mm"><img src="../../images/forms/check.png"></div>
				
				<div class="field13n" style="top:105mm;left:112mm">31/12/'.$_SESSION['rego']['year_th'].'</div>
				<div class="field13n" style="top:105mm;left:145.2mm">'.number_format($tot_income,2).'</div>
				<div class="field13n" style="top:105mm;left:170.3mm">'.number_format($tot_tax,2).'</div>
				
				<div class="field13n" style="top:229.5mm;left:145.2mm">'.number_format($tot_income,2).'</div>
				<div class="field13n" style="top:229.5mm;left:170.3mm">'.number_format($tot_tax,2).'</div>
				
				<div class="field13" style="top:236.7mm;left:67mm">'.$chars.'</div>
				
				<div class="field13n" style="top:242.8mm;left:115mm">'.number_format($tot_ssf).'</div>
				<div class="field13n" style="top:242.8mm;left:163mm">'.number_format($tot_pvf).'</div>
				
				<div class="field13" style="top:249.6mm;left:29.5mm"><img src="../../images/forms/check.png"></div>';
				
				if($edata['digi_stamp'] && !empty($edata['dig_stamp'])){
						$html .= '<div class="stamp" style="top:261mm;right:9mm"><img width="23mm" src="'.ROOT.'/'.$edata['dig_stamp'].'?'.time().'" /></div>';
				}
				
	$html .= '
				<div class="field13" style="top:262.8mm;left:125mm">'.$name_position['name'].'</div>
				<div class="field13c" style="top:266.8mm;left:121mm;width:30px">31</div>
				<div class="field13c" style="top:266.8mm;left:128mm;width:90px">'.$months[12].'</div>
				<div class="field13c" style="top:266.8mm;left:148mm;width:60px">'.($_SESSION['rego']['year_'.$lang]).'</div>
				
				</body></html>';	
	
	//echo $style.$html; exit;			
	
	$mpdf=new mPDF('utf-8', 'A4-P', 9, '', 8, 8, 10, 10, 8, 8);
	//$mpdf->SetTitle($pr_settigs['th_compname'].' ('.strtoupper($_SESSION['rego']['cid']).') - PND1 Form '.$months[(int)$data['month']].' '.$_SESSION['rego']['curr_year']);
	$mpdf->SetTitle($edata[$lang.'_compname'].' ('.strtoupper($_SESSION['rego']['cid']).') - '.$v.' Withholding Tax Certificate '.$_SESSION['rego']['cur_year']);
	$mpdf->SetDisplayMode('fullpage');
	$mpdf->SetFontSize(12);
	//$stylesheet = file_get_contents('mpdf_style2.css');
	$mpdf->WriteHTML($style,1);
	$mpdf->WriteHTML($html);
	$mpdf->Output($v.'_Withholding_Tax_Certificate_'.$_SESSION['rego']['year_'.$lang].'.pdf','I');
	
}

exit;
?>












