<?
	if(session_id()==''){session_start();}
	include('../../dbconnect/db_connect.php');

	/*echo '<pre>';
	print_r($_REQUEST);
	echo '</pre>';*/

	$where = "apply = '1'";

	if($_REQUEST['entity'] >= 1){ $where .= " AND company='".$_REQUEST['entity']."'"; }
	if($_REQUEST['branch'] >= 1){ $where .= " AND locations='".$_REQUEST['branch']."'"; }
	if($_REQUEST['division'] >= 1){ $where .= " AND divisions='".$_REQUEST['division']."'"; }
	if($_REQUEST['department'] >= 1){ $where .= " AND departments='".$_REQUEST['department']."'"; }
	if($_REQUEST['team'] >= 1){ $where .= " AND teams='".$_REQUEST['team']."'"; }

	$sql = "SELECT * FROM ".$cid."_organization WHERE ".$where." ";
	$res = $dbc->query($sql);
	if($res->num_rows > 0){
		while ($row = $res->fetch_assoc()) {
			$data[] = $row;
		}
	}

	$tbl = '';

	if($data){
		foreach ($data as $key => $value) {
			
			$tbl .= '<tr data-id="'.$value['id'].'">';

			if(count($entities) > 1){
				$tbl .= '<td>'.$entities[$value['company']][$lang].'</td>';
			}
			if($parameters[1]['apply_param'] == 1){
				$tbl .= '<td>'.$branches[$value['locations']][$lang].'</td>';
			}
			if($parameters[2]['apply_param'] == 1){
				$tbl .= '<td>'.$divisions[$value['divisions']][$lang].'</td>';
			}
			if($parameters[3]['apply_param'] == 1){
				$tbl .= '<td>'.$departments[$value['departments']][$lang].'</td>';
			}
			if($parameters[4]['apply_param'] == 1){
				$tbl .= '<td>'.$teams[$value['teams']][$lang].'</td>';
			}

			$tbl .= '</tr>';

		}
	}

	ob_clean();
	echo $tbl;


?>