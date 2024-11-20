<?php
	global $months;
	$select_logo_location_array = array('select'=>'Select','adminloginscreen' => 'Admin Login Screen','adminloginscreentitle'=>'Admin Login Screen Title','admindashboardbannerlogo' => 'Admin Dashboard Banner Logo','systemloginscreen' => 'System Login Screen', 'systemloginscreentitle' => 'System Login Screen Title', 'mobilescreenlogo' => 'Mobile Login Screen Logo');	
	$select_banner_location_array = array('select'=>'Select','adminloginscreenbanner' => 'Admin Login Screen Banner','systemloginscreenbanner' => 'System Login Screen Banner','mobloginscreenbanner' => 'Mobile Login Screen Banner');
	$select_yesno_array = array('select'=>'Select','yes' => 'Yes','no'=>'No');	
	$select_position_array = array('select'=>'Select','left' => 'Left','right'=>'Right','center'=>'Center');	
	$login_screen_type = array('select'=>'Select','admin_login' => 'Admin Login','system_user'=>'System User Login','mobile_login'=>'Mobile Login','scan_login'=>'Scan Login');
	$image_select_type = array('select'=>'Select','selectfile' => 'Select a File','noimage'=>'No Image');
	$image_logo_select_type = array('noimage'=>'No Logo Image','selectfile' => 'Select a File',);
	$access = array('m'=>'จำนวนผู้บริหาร	','s'=>'ผู้ใช้งานทั่วไป	','x'=>'จำนวนผู้บริหาร & ผู้ใช้งานทั่วไป');
	$yesno = array('N'=>'ไม่','Y'=>'ใช่');
	$noyes = array('Y'=>'ใช่','N'=>'ไม่');
	$noyes01 = array(0=>'ไม่',1=>'ใช่');
	$payrollopt = array(1=>'บางส่วน',2=>'เต็มเดือน');
	$paiddaycalc = array(1=>'วันปฏิทิน',2=>'ฐาน = 30',3=>'วันทำงาน');
	$fieldopt = array(1=>'Manual model',2=>'Calculated model',3=>'Both models');

	$work_days_per_week = array(4=>'4 วันต่อสัปดาห์',5=>'5 วันต่อสัปดาห์',6=>'6 วันต่อสัปดาห์',7=>'7 วันต่อสัปดาห์');

	$classification = array(0=>'Allowances',1=>'Deductions');
	$sso_paidby = array(0=>'Employee',1=>'Company');

	$activity_level = array(1=>'ได้รับอนุญาตให้แก้ไขและตรวจสอบ',2=>'มีอำนาจแก้ไขและอนุมัติร่วมกัน',3=>'ได้รับอนุญาตให้แก้ไขและอนุมัติคนเดียว');
	$months = array(1=>"มกราคม", 2=>"กุมภาพันธ์", 3=>"มีนาคม", 4=>"เมษายน", 5=>"พฤษภาคม", 6=>"มิถุนายน", 7=>"กรกฏาคม", 8=>"สิงหาคม", 9=>"กันยายน", 10=>"ตุลาคม", 11=>"พฤษจิกายน", 12=>"ธันวาคม");
	$short_months = array(1=>"ม.ค.", 2=>"ก.พ.", 3=>"มี.ค", 4=>"เม.ย.", 5=>"พ.ค.", 6=>"มิ.ย.", 7=>"ก.ค.", 8=>"ส.ค.", 9=>"ก.ย.", 10=>"ต.ค.", 11=>"พ.ย.", 12=>"ธ.ค.");

	
	$weekdays = array(1=>"วันจันทร์", 2=>"วันอังคาร", 3=>"วันพุธ", 4=>"วันพฤหัสบดี", 5=>"วันศุกร์", 6=>"วันเสาร์", 7=>"วันอาทิตย์");

	$user_status = array(1=>'ใช้งานอยู่',2=>'เลื่อนออกไป');
	$permissions = array(1=>'-None',2=>'-Member',3=>'-Author',4=>'-Administrator',5=>'-Developer');
	$language = array('en'=>'ภาษาอังกฤษของ','th'=>'ไทย');
	$title = array(1=>'นาย',2=>'นางสาว',3=>'นาง');
	$titleReverse = array('นาย'=>'1','นางสาว'=>'2','นาง'=>'3');
	$unitopt = array(1=>'Km',2=>'Event',3=>'Shift',4=>'hours');

	$tax_residency_status = array(1=>'Resident of Thailand',2=>'Non-resident of Thailand');
	$income_section = array(1=>'PND1 40(1) salaries, wages as employees',2=>'PND1 40(1)  salaries, wages under 3%',3=>'PND1 40(2) Other compensations', 6=>'PND1 40(1) (2) Single payment by reason of termination', 4=>'PND3 40(8) Income from Business',5=>'None');
	$per_or_thb = array(1=>'%',2=>'THB');
	
	$levels = array(1=>'ระดับ 1 – ตรวจทานและอนุมัติ',2=>'ระดับ 2 – ตรวจทานได้อย่างเดียว',3=>'ระดับ 3 – ดูได้อย่างเดียว',);
	$client_access = array('s'=>'พนักงานเท่านั้น','m'=>'ผู้บริหารและพนักงาน','a'=>'เวลาทำงานเท่านั้น');
	$onsuccess = array(2=>'ไปที่ระเบียนพนักงานใหม่และจบการลงทะเบียน',1=>'ส่งอีเมลไปยังพนักงานใหม่',3=>'ไม่ดำเนินการใดๆ');
	$def_status = array(1=>'*Active',0=>'*Suspended');
	$client_status = array(1=>'*Active', 0=>'*On hold', 2=>'*Processing', 3=>'*Remove');
	$oc_status = array(0=>'*Open',1=>'*Closed');
	$leave_status = array('RQ'=>'*Requested','CA'=>'*Cancelled','AP'=>'*Approved','RJ'=>'*Rejected','PE'=>'*Pending');

	$dtable_lang = 'language: {"decimal":"", "emptyTable":"ไม่มีข้อมูลในตาราง","info":"กำลังแสดง _START_ ถึง_END_ จาก _TOTAL_ รายการ","infoEmpty":"กำลังแสดง 0 ถึง 0 จาก 0 รายการ","infoFiltered":   "(กรองข้อมูลจาก _MAX_ รายการทั้งหมด)","infoPostFix":"","thousands":",","lengthMenu":"แสดง _MENU_ รายการ","loadingRecords": "กำลังโหลด ...","processing":"กำลังประมวลผล ...","search":"ค้นหา:","zeroRecords":"ไม่พบรายการที่ต้องการ","paginate": {"first":"รายการแรก","last":"รายการสุดท้าย","next":"ถัดไป","previous":"ก่อนหน้า"}},';

	$roles = array(1=>'*Director',2=>'*Administrator',3=>'*Senior manager',4=>'*Group leader',5=>'*Manager',6=>'*Team leader',7=>'*Employee');
	$permissions = array(1=>'*No data',2=>'*My data',3=>'*Subordinates data',4=>'*All data');
	$fields = array(1=>'*Setup',2=>'*Personal',3=>'*Contact',4=>'*Financial',5=>'*Benefits',6=>'*Tax',7=>'*Documents');
	//$emp_type = array(1=>'-Permanent', 2=>'-Temporary', 3=>'-Trainee', 4=>'-Contractor', 5=>'-Interim');
	$xhr_emp_group = array('x'=>'-จำนวนผู้บริหาร & ผู้ใช้งานทั่วไป','m'=>'การจัดการเท่านั้น','s'=>'พนักงานเท่านั้น');
	$emp_group = array('s'=>'ผู้ใช้งานทั่วไป','m'=>'จำนวนผู้บริหาร');
	
	$areas = array(1=>'*Branch',2=>'*Group',3=>'*Department',4=>'*Team');
	$leaders = array(1=>'*Director',2=>'*Senior manager',3=>'*Group leader',4=>'*Manager',5=>'*Team leader');
	$blood_types = array(1=>'O +','O -','A +','A -','B +','B -','AB +','AB -',"Don't know");
	$days = array(1=>'วันจันทร์','วันอังคาร','วันพุธ','วันพฤหัสบดี','วันศุกร์','วันเสาร์','วันอาทิตย์');
	$sdays = array(1=>'จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์','อาทิตย์');
	$xsdays = array(1=>'จ.','อ.','พ.','พฤ.','ศ.','ส.','อา.');
	$day = array(0=>'วัน',1=>'วัน',2=>'วัน',3=>'วัน',4=>'วัน',5=>'วัน',6=>'วัน',7=>'วัน',8=>'วัน',9=>'วัน');

	$shift_teams = array(1=>'*Shift team 1', 2=>'*Shift team 2', 3=>'*Shift team 3');
	
	$mod_colors = array('leave'=>'#1aaca3', 'time'=>'#f39c11', 'payroll'=>'#3598dc', 'settings'=>'#e84c3d', 'employee'=>'#2bb962', 'report'=>'#a56cbc', 'approve'=>'#e77e22', 'ccplatform'=>'#2a80b9', '9'=>'#f2c40f', '0'=>'#bec3c7');
	
	$leave_status = array('RQ'=>'รายการที่ร้องขอ','CA'=>'ยกเลิก','AP'=>'อนุมัติแล้ว','RJ'=>'ถูกปฏิเสธ','PE'=>'รอดำเนินการ','TA'=>'*Taken');
	
	$cert = array('H'=>'ไม่','Y'=>'ใช่','N'=>'ไม่','NA'=>'-N/A');

	$payroll_status = array('AP'=>'<b style="color:green"><i class="fa fa-thumbs-up"></i>&nbsp;* Approved</b>','RJ'=>'<b style="color:#a00"><i class="fa fa-thumbs-down"></i>&nbsp; *Rejected</b>','RV'=>'<b style="color:green"><i class="fa fa-thumbs-up"></i>&nbsp; *Reviewed</b>');

	$username_option = array(1=>'อีเมลส่วนตัว', 2=>'อีเมลที่ทำงาน',3=>'ป้อนข้อมูลด้วยตนเอง');
	$username_optionReverse = array('อีเมลส่วนตัว'=>'1', 'อีเมลที่ทำงาน'=>'2','ป้อนข้อมูลด้วยตนเอง'=>'3');

	$emp_group = array('s'=>'*Staff', 'm'=>'*Management', 'all'=>'*Both');
	$emp_groep = array('s'=>'*Staff', 'm'=>'*Management');
	$pay_frequency = array(12=>'เดือนล่ะครั้ง', 24=>'เดือนล่ะสองครั้ง');
	$pay_type = array('cash'=>'เงินสด', 'cheque'=>'เช็คธนาคาร');
	$maritial = array(1=>'โสด', 2=>'สมรส', 3=>'หย่า', 5=>'แยกกันอยู่', 6=>'อยู่ด้วยกัน', 7=>'หม้าย');
	$maritialReverse = array('โสด'=>'1', 'สมรส'=>'2', 'หย่า'=>'3', 'แยกกันอยู่'=>'5', 'อยู่ด้วยกัน'=>'6', 'หม้าย'=>'7');
	$military_status = array(1=>'รับการยกเว้น',2=>'รอดำเนินการ',3=>'การปฏิบัติหน้าที่',4=>'ที่เสร็จสมบูรณ์');
	$military_statusReverse = array('รับการยกเว้น'=>'1','รอดำเนินการ'=>'2','การปฏิบัติหน้าที่'=>'3','ที่เสร็จสมบูรณ์'=>'4');
	$gender = array(1=>'ชาย', 2=>'หญิง');
	$genderReverse = array('ชาย'=>'1', 'หญิง'=>'2');
	$religion = array(1=>'พุทธ', 2=>'มุสลิม', 3=>'ฮินดู', 4=>'คริส', 5=>'อื่นๆ');
	$religionReverse = array('พุทธ'=>'1', 'มุสลิม'=>'2', 'ฮินดู'=>'3', 'คริส'=>'4', 'อื่นๆ'=>'5');
	$emp_type = array(1=>'ถาวร', 2=>'ชั่วคราว', 3=>'ผู้ฝึกงาน', 4=>'ผู้รับเหมา(ไม่รวมอยู่ในบัญชีเงินเดือน)', 5=>'ระหว่างกาล (ไม่รวมอยู่ในบัญชีเงินเดือน)');
	$emp_typeReverse = array('ถาวร'=> '1', 'ชั่วคราว' => '2', 'ผู้ฝึกงาน' => '3', 'ผู้รับเหมา(ไม่รวมอยู่ในบัญชีเงินเดือน)' => '4', 'ระหว่างกาล (ไม่รวมอยู่ในบัญชีเงินเดือน)' => '5');
	//$emp_status = array(1=>'พนักงาน', 2=>'ลาออก', 3=>'ถูกไล่ออก', 4=>'การทดสอบ', 5=>'คล่องแคล่ว WOP');
	$emp_status = array(1=>'พนักงาน', 2=>'ลาออก', 3=>'เลิกจ้าง', 0=>'ยกเลิก', 7=>'*in-Complete');
	$emp_status2 = array( 2=>'Resigned', 3=>'Terminated');
	$emp_status3 = array(1=>'Active', 0=>'Canceled', 7=>'in-Complete');

	//$scan_system = array(0=>"ไม่มีการสแกน", "txt"=>"ยี่ห้อ 01 (20170316 154 01102018 0750) Textfile.txt", "excel"=>"ยี่ห้อ 02 (Excel)", "other"=>"ยี่ห้อ 03");

	$emp_pr_status = array(0=>'สมบูรณ์', 1=>'ไม่สมบูรณ์');
	$scan_status = array(0=>'*non-Appr', 1=>'*Validated');

	$overtime_at = array('any'=>'ที่ทุกเวลา', 'before'=>'ก่อนทำงาน', 'after'=>'หลังเลิกงาน', 'weekend'=>'ช่วงสุดสัปดาห์', 'holiday'=>'วันหยุด');
	$overtime_type = array('paid'=>'จ่ายค่าล่วงเวลา', 'comp'=>'ชดเชยการลา');

	$pr_schedule = array(12=>'*Monthly (12)', 24=>'*Semi-monthly (24)', 26=>'*Bi-weekly (26)', 52=>'*Weekly (52)');

	$sd_prior[0] = array('*Low', 'green');
	$sd_prior[1] = array('*Medium', '#f60');
	$sd_prior[2] = array('*High', '#b00');
	
	$sd_status[0] = array('*Open', 'green');
	$sd_status[1] = array('*Closed', '#b00');
	
	$sd_type = array('gen'=>'*General', 'con'=>'*Confidential', 'bug'=>'*Bug report');

	$version = array(0=>'PKF Free trial', 10=>'PKF 10', 20=>'PKF 20', 50=>'PKF 50', 100=>'PKF 100', 200=>'PKF Standard', 300=>'PKF Professional', 400=>'PKF Elite');
	$user_type = array('sys'=>'*System', 'app'=>'*Approver', 'emp'=>'*Employee', 'sub'=>'*Subscriber','comp'=> '*Company');

	$paid_by = array('credit'=>'บัตรเครดิต', 'transf'=>'โอนเงินผ่านธนาคาร', 'cheque'=>'ตรวจสอบ');
	$inv_status = array(0=>'*Processing', 1=>'*Confirmed', 2=>'*Paid', 3=>'*Completed');

	$sheet_txt = 'This sheet is protected. This file can be used to upload data to the attendance module.'.PHP_EOL.'โปรดทราบว่าคุณสามารถใช้สูตรเพื่อรวบรวมข้อมูลของคุณได้'.PHP_EOL.'แต่คุณจำเป็นต้องแทนที่สูตรด้วยค่าเพื่อให้มีการอัปโหลดข้อมูลอย่างถูกต้อง'.PHP_EOL.'คุณไม่สามารถคัดลอกทั้งแถวได้';
	
	$ptype = array('card'=>'*Credit card', 'internet'=>'*Internet banking', 'transfer'=>'*Bank transfer');

	$scan_system = array(
		0=>"ไม่สแกน", 
		"REGO"=>"PKF ลงทะเบียนตรงเวลา (รหัส Qr, เซลฟี่)", 
		"REGOXLS"=>"PKF นำเข้าระบบระบบบันทึกเวลาด้วย (ไฟล์ Excel)", 
		"AGL"=>"AGL สแกน (แถบไฟล์ที่แยกกัน)", 
		"WELADEE"=>"Weladee สแกน (ไฟล์ Excel)");
	
	$payroll_status = array(
		'AP'=>'<b style="color:green"><i class="fa fa-thumbs-up"></i>&nbsp; *Approved</b>',
		'RJ'=>'<b style="color:#a00"><i class="fa fa-thumbs-down"></i>&nbsp; *Rejected</b>',
		'RV'=>'<b style="color:green"><i class="fa fa-thumbs-up"></i>&nbsp; *Reviewed</b>');

	$leave_status = array('RQ'=>'*Requested','CA'=>'*Cancelled','AP'=>'*Approved','RJ'=>'*Rejected','PE'=>'*Pending','TA'=>'*Taken');

	$access_approve = array('all'=>'*All modules','att'=>'*Leave & Time','non'=>'*None');

	$pensionfund = array('non'=>'*None','pvf'=>'*Provident fund','psf'=>'*Pension fund');

	$pr_status = array(0=>'*Processing', 1=>'*Approved', 2=>'*Rejected', 4=>'*Locked');

	$bab_request = array('before'=>'ก่อน', 'after'=>'หลังจาก', 'both'=>'ทั้งสอง');
	$min_request = array('half'=>'ครึ่งวัน', 'hrs'=>'ชั่วโมง');

	$agent_status = array(0=>'*On hold', 1=>'*Active', 2=>'*Departed', 3=>'*Removed');

	$overtime = array('ot1'=>'OT 1','ot15'=>'OT 1.5','ot2'=>'OT 2','ot3'=>'OT 3');

	$warnings = array(1=>'*Verbal warning', 2=>'*First warning', 3=>'*Second warning', 4=>'*Final warning', 5=>'*Incident registration');
	$violations = array(1=>'*Attendance', 2=>'*Carelessness', 3=>'*Violation of Safety Rules', 4=>'*Disobedience', 5=>'*Tardiness', 6=>'*Work Quality', 7=>'*Rudeness to Customers/Coworkers', 8=>'*Violation of Company Policies', 9=>'*Quality incident', 10=>'*Safety incident', 11=>'*Other');

	$calcTax = array(0=>'*no Tax', 1=>'*PND1', 3=>'*PND3');

	$contract_type = array('month'=>'*Monthly wage', 'day'=>'*Daily wage');

	$calc_base = array('gross'=>'*Gross amount', 'net'=>'*Net amount');
	
	$base_ot_rate = array('cal'=>'*Calculated', 'fix'=>'*Fixed');


	$data_group = array('inc_ot'=>'Overtime', 'inc_fix'=>'Fixed income', 'inc_var'=>'Variable income', 'inc_oth'=>'Other income', 'inc_sal'=>'Salary', 'ded_abs'=>'Absence', 'ded_fix'=>'Fixed deductions', 'ded_var'=>'Variable deductions', 'ded_oth'=>'Other deductions', 'ded_leg'=>'Legal deductions / Loans', 'ded_pay'=>'Advanced payments');
	
	$income_group = array('inc_sal'=>'Salary', 'inc_fix'=>'Fixed income', 'inc_ot'=>'Overtime', 'inc_var'=>'Variable income', 'inc_oth'=>'Other income');
	
	$deduct_group = array('ded_abs'=>'Absence', 'ded_fix'=>'Fixed deductions', 'ded_var'=>'Variable deductions', 'ded_oth'=>'Other deductions', 'ded_leg'=>'Legal deductions / Loans', 'ded_pay'=>'Advanced payments');
	
	$tax_base = array('fixpro'=>'Fixed - Pro rated', 'fix'=>'Fixed', 'var'=>'Variable', 'nontax'=>'Non-taxable', 'ssoby'=>'SSO by company', 'taxby'=>'Tax by Company');

	$Announcementtype 	= array(1=>'Notification',2=>'Announcement',3=>'Event');
	$AnnouncementMode  	= array(1=>'Email',2=>'Notification Box',3=>'Both');
	$AnnouncementCategory   	= array(1=>'Public',2=>'Private');
	$Topersons   	= array(1=>'All employees', 3=>'Staff', 4=>'Management', 2=>'Specific Group');
	$CCStatus   	= array(1=>'Draft', 2=>'Approved', 3=>'Send', 4=>'Rejected');



