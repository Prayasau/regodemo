<?
	if(session_id()==''){session_start(); ob_start();}
	include("../../dbconnect/db_connect.php");
	include(DIR."files/functions.php");
	include(DIR."leave/functions.php");
	//$_REQUEST['emp_id'] = 'DEMO-001';

	$leave_time_settings = getLeaveTimeSettings();
	$leave_types = unserialize($leave_time_settings['leave_types']);
	foreach($leave_types as $k=>$v){
		$balance[$k] = array('th'=>$v['th'], 'en'=>$v['en'], 'maxdays'=>$v['max'][$_SESSION['rego']['emp_group']], 'maxpaid'=>$v['pay'][$_SESSION['rego']['emp_group']], 'pending'=>0, 'used'=>0);
	}
	$ALemp = getALemployee($cid, $_REQUEST['emp_id']);
	$balance['AL']['maxdays'] = $ALemp;
	$balance = getUsedLeaveEmployee($cid, $_REQUEST['emp_id'], $balance);

		
	ob_clean();	
	echo json_encode($balance);		
?>
