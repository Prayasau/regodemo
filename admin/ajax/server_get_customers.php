<?
	if(session_id()==''){session_start(); ob_start();}
	include('../dbconnect/db_connect.php');
	include(DIR.'files/arrays_en.php');


	// echo '<pre>';
	// print_r($_SESSION['RGadmin']['access']['customer_registration']['delete']);
	// echo '</pre>';

	// die();
	
	$sql_details = array(
		'user' => $my_username,
		'pass' => $my_password,
		'db'   => $my_dbaname,
		'host' => $my_database
	);
	$where = '';
	if($_REQUEST['status'] != ''){
		$where = "status = ".$_REQUEST['status'];
	}
	// DB table to use
	$table = 'rego_customers';
	
	// Table's primary key
	$primaryKey = 'id';
	
	$nr=0;
	
	$columns[] = array( 'db' => 'clientID', 'dt' => $nr, 'formatter' => function($d, $row ){return '<span class="cid" style="display:none">'.$d.'</span><a class="openCustomer " ><span class="hover-bold">'.strtoupper($d).'</span></a>';}); $nr++;
	
	$columns[] = array( 'db' => $lang.'_compname', 'dt' => $nr , 'formatter' => function($d, $row ){return '<a class="openCustomer hover-bold"><span class="hover-bold">'.$d.'</span></a>';}); $nr++;
	
	// $columns[] = array( 'db' => 'clientID', 'dt' => $nr, 'formatter' => function($d, $row ){return '<a class="selectCustomer" data-id="'.$d.'"><i class="fa fa-external-link fa-lg"></i></a>';}); $nr++;

	$columns[] = array( 'db' => 'version', 'dt' => $nr, 'formatter' => function($d, $row )use($version){return '<a class="openCustomer hover-bold"><span class="hover-bold">'.$version[$d].'</span></a>';}); $nr++;
	
	$columns[] = array( 'db' => 'agent', 'dt' => $nr, 'formatter' => function($d, $row ){return '<a class="openCustomer"><span class="hover-bold">'.$d.'</span></a>';}); $nr++;
	
	$columns[] = array( 'db' => 'period_end', 'dt' => $nr, 'formatter' => function($d, $row ){
		if(strtotime($d) < strtotime(date('Y-m-d'))){
			return '<span class="exp"><a class="openCustomer"><span class="hover-bold">'.$d.'</span></a></span>';
		}else{
			return '<span><a class="openCustomer"><span class="hover-bold">'.$d.'</span></a></span>';
		}
	}); $nr++;
	
	$columns[] = array( 'db' => 'name', 'dt' => $nr, 'formatter' => function($d, $row ){return '<span ><a class="openCustomer"><span class="hover-bold">'.$d.'</span></a></span>';}); $nr++;
	
	$columns[] = array( 'db' => 'phone', 'dt' => $nr , 'formatter' => function($d, $row ){return '<a class="openCustomer"><span class="hover-bold">'.$d.'</span></a>';}); $nr++;
	
	$columns[] = array( 'db' => 'email', 'dt' => $nr, 'formatter' => function($d, $row ){return '<a href="mailto:'.$d.'"><span class="hover-bold">'.$d.'</span></a>';}); $nr++;
	$columns[] = array( 'db' => 'line_id', 'dt' => $nr ); $nr++;
	
	$columns[] = array( 'db' => 'status', 'dt' => $nr, 'formatter' => function($d, $row )use($client_status){
		$str = '<select data-id="'.$d.'" class="clstatus';
		if($d == 3){$str .= ' rem';}
		$str .= '" style="width:auto">';
		foreach($client_status as $k => $v){ 
			$str .= '<option ';
			if($d == $k){$str .= "selected ";}
			$str .= 'value="'.$k.'">'.$v.'</option>';
		}
		$str .= '</select>';
		return $str;
	}); $nr++;
	
	$columns[] = array( 'db' => 'id', 'dt' => $nr, 'formatter' => function($d, $row ){return '<a class="editClient" data-id="'.$d.'"><i class="fa fa-edit fa-lg"></i></a>';}); $nr++;
	
	$columns[] = array( 'db' => 'id', 'dt' => $nr, 'formatter' => function($d, $row ){

		if($_SESSION['RGadmin']['access']['customer_registration']['delete'] == '1')
		{
			return '<a data-id="'.$d.'"><i style="color:#bbb" class="fa fa-trash fa-lg"></i></a>';
		}
		else 
		{
			return '<a><i style="color:#bbb!important" class="fa fa-trash fa-lg"></i></a>';
		}


	}); $nr++;
	
	require(DIR.'ajax/ssp.class.php');
	//var_dump(SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere ));exit;
	echo json_encode(
		SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $where)
	);

?>