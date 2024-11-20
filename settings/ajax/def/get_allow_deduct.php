<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../../dbconnect/db_connect.php");
	//var_dump($_REQUEST); exit;
	
	$data = array();
	$res = $dbc->query("SELECT * FROM ".$cid."_allow_deduct WHERE id = '".$_REQUEST['id']."'"); 
	if($row = $res->fetch_assoc()){
		$data = $row;
		$data['Napply'] 		= $row['apply'] ? true : false;
		$data['Nearnings'] 		= $row['earnings'] ? true : false;
		$data['Ndeductions'] 	= $row['deductions'] ? true : false;
		$data['Nhourdailyrate'] = $row['hour_daily_rate'] ? true : false;
		$data['Npnd1'] 			= $row['pnd1'] ? true : false;
		$data['Ntax_income'] 	= $row['tax_income'] ? true : false;
		$data['Nsso'] 			= $row['sso'] ? true : false;
		$data['Npvf'] 			= $row['pvf'] ? true : false;
		$data['Npsf'] 			= $row['psf'] ? true : false;
		$data['Nman_emp'] 		= $row['man_emp'] ? true : false;
		$data['Nman_att'] 		= $row['man_att'] ? true : false;
		$data['Ncomp_reduct'] 	= $row['comp_reduct'] ? true : false;
		$data['Nfixed_calc'] 	= $row['fixed_calc'] ? true : false;
	}else{
		echo 'Error';
	}
	//var_dump($data); exit;
	ob_clean();
	echo json_encode($data);
	exit;
?>