<?
	header('Content-Type: text/html; charset=utf-8');
	ini_set('date.timezone', 'Asia/Bangkok');
	date_default_timezone_set("Asia/Bangkok"); 

	$mainError = "";
	$prefix = '';
	if($_SERVER['SERVER_NAME']=='localhost'){
		ini_set('show_errors', 'on');
		error_reporting(E_ALL);
		ini_set('xdebug.var_display_max_depth', -1);
		ini_set('xdebug.var_display_max_children', -1);
		ini_set('xdebug.var_display_max_data', -1);
		$my_database = 'localhost';
		$my_username = 'root';
		$my_password = '';
		$demo = true;
		$prefix = 'xhr_';
		//define('SERVERNAME','//localhost/newXray/');
	}else{
		$my_database = 'localhost';
		$my_username = 'xraycoth_root';
		$my_password = 'tinkerbell';
		$demo = true;
		$prefix = 'xraycoth_';
		//define('SERVERNAME','https://xrayhr.com/');
	}
	
	$my_dbaname = $prefix.'admin';
	$dba = new mysqli($my_database,$my_username,$my_password,$my_dbaname);
	mysqli_set_charset($dba,"utf8");
	if($dba->connect_error) {
		echo'<p style="width:900px; margin:0 auto; margin-top:20px;" class="box_err">Error: ('.$dba->connect_errno.') '.$dba->connect_error.'<br>Please try again later or report this error to <a href="mailto:admin@regohr.com">admin@regohr.com</a></p>';
	}
	
	$compinfo['th_compname'] = ''; 
	$compinfo['en_compname'] = '';
	if(isset($_SESSION['ehr']['cid'])){
		$cid = $_SESSION['ehr']['cid'];
		$my_dbcname = $prefix.$cid;	
		//$clientID = $_SESSION['xhr']['cid'];
		//define('clientID',$_SESSION['xhr']['cid']);
		$dbc = new mysqli($my_database,$my_username,$my_password,$my_dbcname);
		mysqli_set_charset($dbc,"utf8");
		if($dbc->connect_error) {
			echo '<p style="width:900px; margin:0 auto; margin-top:20px;" class="box_err">Error: ('.$dbc->connect_errno.') '.$dbc->connect_error.'<br>Please try again later or report this error to <a href="mailto:admin@regohr.com">admin@regohr.com</a></p>';
		}
		$compinfo = array();
		if($res = $dbc->query("SELECT * FROM ".$cid."_settings")){
			//if($row = $res->fetch_assoc()){
			$compinfo = $res->fetch_assoc();
			$dateformat = $compinfo['date_format'];
			
			$dep = unserialize($compinfo['departments']);
			$departments = $dep[$_SESSION['ehr']['lang']];
			unset($dep);
			//var_dump($departments);	//exit;
			
			$pos = unserialize($compinfo['positions']);
			$positions = $pos[$_SESSION['ehr']['lang']];
			unset($pos);
			//var_dump($positions);	exit;
			
			$bra = unserialize($compinfo['branches']);
			$branches = $bra[$_SESSION['ehr']['lang']];
			unset($bra);
			//var_dump($branches);	exit;
			
			$gro = unserialize($compinfo['groups']);
			$groups = $gro[$_SESSION['ehr']['lang']];
			unset($gro);
			//var_dump($groups);	exit;

			$tmp = unserialize($compinfo['leave_types']);
			$leave_types = $tmp['leave'];
			$leave_period_start = $tmp['startdate'];
			$leave_period_end = $tmp['enddate'];
			$leave_request_before = $tmp['request'];
			unset($tmp);
			
		}
	}
	
	$dateformat = 'd-m-Y';
	$info_email = 'info@xrayhr.com';
	$admin_email = 'info@xrayhr.com';
	//$compname = $compinfo[$_SESSION['xhr']['lang'].'_compname'];
	
	$xray_info = array();
	if($res = $dba->query("SELECT * FROM xhr_settings")){
		if(!mysqli_error($dba)){
			$xray_info = $res->fetch_assoc();
		}
	}
?>





