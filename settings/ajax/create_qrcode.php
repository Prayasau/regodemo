<?

	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");
	include(DIR.'phpqrcode/qrlib.php');

	$QRDir = DIR.$cid.'/QRcode/';
  if(!file_exists($QRDir)){
   	mkdir($QRDir);
	}
	$code = strtotime(date('d-m-Y H:i:s'));
	$QRfile = $QRDir.'qrtimescan'.$_REQUEST['id'].'.png';
	QRcode::png($code, $QRfile, 'H', 20, 1); 
	
	$data['code'] = $code;
	$data['qr'] = ROOT.$cid.'/QRcode/qrtimescan'.$_REQUEST['id'].'.png?'.time();
	ob_clean();
	echo json_encode($data);
	
	
