<?
	if(session_id()==''){session_start();}
	ob_start();
	include('../../dbconnect/db_connect.php');
	include(DIR.'files/functions.php');
	$getEmpName = getEmpName();

	$sql_details = array(
		'user' => $my_username,
		'pass' => $my_password,
		'db'   => $my_dbcname,
		'host' => $my_database
	);
	
	// if(isset($_REQUEST['emp_id'])){
	// 	$where = "emp_id = '".$_REQUEST['emp_id']."'";
	// }else{
	// 	$where = "";
	// }


	// echo '<pre>';
	// print_r($_SESSION['rego']['sel_teams']);
	// echo '</pre>';
	// die();

	$sessionTeams = $_SESSION['rego']['sel_teams'];


	$where = "batch_team REGEXP CONCAT('(^|,)(', REPLACE('".$sessionTeams."', ',', '|'), ')(,|$)')";
	
	$table = $cid.'_temp_log_history';
	$primaryKey = 'emp_id';

	$nr=0;
	
	$columns[] = array( 'db' => 'id',  'dt' => $nr ); $nr++;
	$columns[] = array( 'db' => 'employeeCount',  'dt' => $nr , 'formatter' => function( $d, $row ){

		if($d == '1')
		{
			$employeeText = 'Employee';
		}
		else
		{
			$employeeText = 'Employees';
		}

		return '<span style="margin-right:10px;">'.$d.' '.$employeeText.'</span><a  class="viewTeams" ><i class="fa fa-eye fa-lg"></i></a>';
	}); $nr++;

	$columns[] = array( 'db' => 'field',  'dt' => $nr , 'formatter' => function( $d, $row ){
		return $d;
	}); $nr++;	
	$columns[] = array( 'db' => 'batch_no',  'dt' => $nr , 'formatter' => function( $d, $row ){
		return '<a  style="display:none;" class="viewTeamsHidden" data-id="'.$d.'"><i class="fa fa-eye fa-lg"></i></a>';
	}); $nr++;

	$columns[] = array( 'db' => 'date','dt' => $nr, 'formatter' => function( $d, $row ){return date('d-m-Y @ H:i', strtotime($d));}); $nr++;

	$columns[] = array( 'db' => 'user',  'dt' => $nr ); $nr++;



	require(DIR.'ajax/ssp.class.php' );
	
	ob_clean();
	echo json_encode(
		SSP::simpleFetchTempLog( $_POST, $sql_details, $table, $primaryKey, $columns, $where)
	);

?>