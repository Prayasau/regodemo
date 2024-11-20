<?
	if(session_id()==''){session_start();}
	include('../../../dbconnect/db_connect.php');


	$data = array();
	$positionsArr = array();

	foreach($_REQUEST['values'] as $key=>$val){
		foreach($positions as $k=>$v){

			if($k == $val){

				$data[$k] = $k;
				$positionsArr[$k] = $k;
			}

		}
	}

	$tableRow = '';
	if($data){
		foreach($data as $key=>$val){
			$tableRow .= '<span class="ml-2 font-weight-bold">'.$positions[$key][$lang].'</span><br>';
		}
	}


	$result['Allposition']  = $positionsArr;
	$result['tableRow'] 	= $tableRow;

	echo json_encode($result);
?>


