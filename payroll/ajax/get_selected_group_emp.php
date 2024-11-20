<?
	if(session_id()==''){session_start(); ob_start();}
	include('../../dbconnect/db_connect.php');

	$d = $_SESSION['rego']['cur_year'].'-'.$_SESSION['rego']['curr_month'].'-01';
	$som = date('Y-m-d', strtotime($d));
	$eom = date('Y-m-t', strtotime($d));

	$sbranches = str_replace(',', "','", implode(',', $_REQUEST['locations']));
	$sdivisions = str_replace(',', "','", implode(',', $_REQUEST['divisions']));
	$sdepartments = str_replace(',', "','", implode(',', $_REQUEST['departments']));
	$steams = str_replace(',', "','", implode(',', $_REQUEST['teams']));

	$where = "branch IN ('".$sbranches."')";
	$where .= " AND division IN ('".$sdivisions."')";
	$where .= " AND department IN ('".$sdepartments."')";
	$where .= " AND team IN ('".$steams."')";

	$data = array();
	$res = $dbc->query("SELECT * FROM ".$_SESSION['rego']['cid']."_employees WHERE base_salary > 0 AND joining_date <= '".$eom."' AND (resign_date >= '".$som."' AND resign_date <= '".$eom."' OR emp_status = '1') AND ".$where." ");
	while($row = $res->fetch_assoc()){
		$data[] = $row;
	}

	$trData = '';
	foreach ($data as $key => $row) {
		$trData .= '<tr id="'.$row['emp_id'].'" data-id="'.$row['emp_id'].'">';
		$trData .= '<td>'.$row['emp_id'].'</td>';
		$trData .= '<td>'.$row[$lang.'_name'].'</td>';
		$trData .= '<td><a title="Remove" class="text-danger" id="'.$row['emp_id'].'" onclick="removeRowemp(this)"><i class="fa fa-trash fa-lg"></i></a></td>';
		$trData .= '<td>'.$positions[$row['position']]['code'].'</td>';
		$trData .= '<td>'.$branches[$row['branch']]['code'].'</td>';
		$trData .= '<td>'.$divisions[$row['division']]['code'].'</td>';
		$trData .= '<td>'.$departments[$row['department']]['code'].'</td>';
		$trData .= '<td>'.$teams[$row['team']]['code'].'</td>';
		$trData .= '</tr>';
	}

	ob_clean();
	echo $trData;
	
?>