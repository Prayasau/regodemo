<?
	if(session_id()==''){session_start();}
	include('../dbconnect/db_connect.php');
	//var_dump($_REQUEST); //exit;

	//unset($_SESSION['rego']['mn_'.$_REQUEST['access']]);
	
	//var_dump($teams);

	//if(is_array($_SESSION['RGadmin']['access'])){

		$teamAcc = explode(',', $_SESSION['rego']['pr_teams']); 
	/*}else{

		if($_SESSION['rego']['type'] == 'sys'){

			$sql = "SELECT * FROM ".$_SESSION['rego']['cid']."_users WHERE id = '".$_SESSION['rego']['id']."'"; 
			if($res = $dbc->query($sql)){
				if($row = $res->fetch_assoc()){

					$teamAcc = explode(',', $row['teams']);

				}
			}
		}
	}*/


	// echo '<pre>';
	// print_r($teamAcc);
	// echo '</pre>';

	//exit;

		
	$entity = array();
	$branch = array();
	$division = array();
	$department = array();
	$team = array();
	$groups = array();

	if($_REQUEST['access'] == 'entities' && isset($_REQUEST['values'])){
		foreach($_REQUEST['values'] as $key=>$val){
			foreach($teams as $k=>$v){

				if(in_array($k, $teamAcc)){

					if($v['entity'] == $val){
						$branch[] = $v['branch'];
						$division[] = $v['division'];
						$department[] = $v['department'];
						//$groups[] = $v['groups'];
						$team[$k] = $k;
					}
				}
			}
		}
		$entity = $_REQUEST['values'];
	}
	
	if($_REQUEST['access'] == 'divisions' && isset($_REQUEST['values'])){
		foreach($_REQUEST['values'] as $key=>$val){
			foreach($teams as $k=>$v){

				if(in_array($k, $teamAcc)){
					if($v['division'] == $val){
						$entity[] = $v['entity'];
						$branch[] = $v['branch'];
						$department[] = $v['department'];
						//$groups[] = $v['groups'];
						$team[$k] = $k;
					}
				}
			}
		}
		$division = $_REQUEST['values'];
	}
	
	if($_REQUEST['access'] == 'departments' && isset($_REQUEST['values'])){
		foreach($_REQUEST['values'] as $key=>$val){
			foreach($teams as $k=>$v){

				if(in_array($k, $teamAcc)){
					if($v['department'] == $val){
						$entity[] = $v['entity'];
						$branch[] = $v['branch'];
						$division[] = $v['division'];
						//$groups[] = $v['groups'];
						$team[$k] = $k;
					}
				}
			}
		}
		$department = $_REQUEST['values'];
	}

	// if($_REQUEST['access'] == 'groups' && isset($_REQUEST['values'])){
	// 	foreach($_REQUEST['values'] as $key=>$val){
	// 		foreach($groups as $k=>$v){
	// 			if($v['groups'] == $val){
	// 				$entity[] = $v['entity'];
	// 				$branch[] = $v['branch'];
	// 				$division[] = $v['division'];
	// 				$department[] = $v['department'];
	// 				$team[$k] = $k;
	// 			}
	// 		}
	// 	}
	// 	$groups = $_REQUEST['values'];
	// }
	
	if($_REQUEST['access'] == 'branches' && isset($_REQUEST['values'])){
		foreach($_REQUEST['values'] as $key=>$val){
			foreach($teams as $k=>$v){

				if(in_array($k, $teamAcc)){
					if($v['branch'] == $val){
						$entity[] = $v['entity'];
						$division[] = $v['division'];
						$department[] = $v['department'];
						//$groups[] = $v['groups'];
						$team[$k] = $k;
					}
				}
			}
		}
		$branch = $_REQUEST['values'];
	}
	
	if($_REQUEST['access'] == 'teams' && isset($_REQUEST['values'])){
		/*foreach($_REQUEST['values'] as $k=>$v){

			if(in_array($k, $teamAcc)){
				$entity[] = $entities[$teams[$v]['entity']]['id'];
				$branch[] = $branches[$teams[$v]['branch']]['id'];
				$division[] = $divisions[$teams[$v]['division']]['id'];
				$department[] = $departments[$teams[$v]['department']]['id'];
				//$groups[] = $groups[$teams[$v]['groups']]['id'];
			}
		}*/
		foreach($_REQUEST['values'] as $key=>$val){
			foreach($teams as $k=>$v){

				//if(in_array($k, $teamAcc)){ echo '1<br>';
					if($k == $val){
						$entity[] = $v['entity'];
						$branch[] = $v['branch'];
						$division[] = $v['division'];
						$department[] = $v['department'];
						//$groups[] = $v['groups'];
						//$team[$k] = $k;
					}
				//}
			}
		}
		$team = $_REQUEST['values'];
	}
	
	//var_dump($entity);
	//var_dump($branch);
	//var_dump($division);
	//var_dump($department);
	//var_dump($team);

	// echo '<pre>';
	// print_r($entity);
	// print_r($branch);
	// print_r($division);
	// print_r($department);
	// print_r($team);
	// echo '</pre>'; 
	//exit;
	
	$_SESSION['rego']['selpr_entities'] = implode(',', array_unique($entity));
	$_SESSION['rego']['selpr_branches'] = implode(',', array_unique($branch));
	$_SESSION['rego']['selpr_divisions'] = implode(',', array_unique($division));
	$_SESSION['rego']['selpr_departments'] = implode(',', array_unique($department));
	$_SESSION['rego']['selpr_teams'] = implode(',', array_unique($team));
	//$_SESSION['rego']['sel_groups'] = implode(',', $groups);
	

	// echo '<pre>';
	// print_r($_SESSION['rego']['selpr_teams']);
	// echo '</pre>'; 








