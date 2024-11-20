<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../../dbconnect/db_connect.php");

	//echo '<pre>';
	//print_r($_REQUEST['emparr']);

	$emparr = implode("','", $_REQUEST['emparr']);

	$data = array();
	$res = $dbc->query("SELECT * FROM ".$cid."_employees WHERE emp_id IN ('".$emparr."') "); 
	while($row = $res->fetch_assoc()){
		$data[$row['emp_id']] = $row;
	}

	$trdata = '';
	foreach ($data as $key => $value) {
		
		$trdata .= '<tr id="'.$value['emp_id'].'">';
		$trdata .= '<td>'.$value['emp_id_editable'].'</td>';
		$trdata .= '<td>'.$value['firstname'].' '.$value['lastname'].'</td>';
		//$trdata .= '<td><input type="checkbox" name="select[]" value="'.$value['emp_id'].'" </td>';
		$trdata .= '<td>'.$positions[$value['position']][$lang].'</td>';
		$trdata .= '<td>'.$entities[$value['entity']][$lang].'</td>';
		$trdata .= '<td>'.$branches[$value['branch']][$lang].'</td>';
		$trdata .= '<td>'.$divisions[$value['division']][$lang].'</td>';
		$trdata .= '<td>'.$departments[$value['department']][$lang].'</td>';
		$trdata .= '<td>'.$teams[$value['team']][$lang].'</td>';
		$trdata .= '<td>'.$groups[$value['groups']][$lang].'</td>';
		$trdata .= '</tr>';

	}
	
	ob_clean();
	echo $trdata;
	exit;
?>


















