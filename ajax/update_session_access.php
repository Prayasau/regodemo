<?

	if(session_id()==''){session_start();}
	include('../dbconnect/db_connect.php');
	
	$teamAcc = explode(',', $_SESSION['rego']['mn_teams']); 
		
	$entity = array();
	$branch = array();
	$division = array();
	$department = array();
	$team = array();
	$groups = array();

	if($_REQUEST['access'] == 'entities' && isset($_REQUEST['values'])){
		foreach($_REQUEST['values'] as $key=>$val){
			foreach($organization as $k=>$v){

				$k = $v['teams'];

				if(in_array($k, $teamAcc)){

					if($v['company'] == $val){
						$branch[] = $v['locations'];
						$division[] = $v['divisions'];
						$department[] = $v['departments'];
						$team[$k] = $k;
					}
				}
			}
		}
		$entity = $_REQUEST['values'];
	}
	
	if($_REQUEST['access'] == 'divisions' && isset($_REQUEST['values'])){
		foreach($_REQUEST['values'] as $key=>$val){
			foreach($organization as $k=>$v){
				$k = $v['teams'];
				if(in_array($k, $teamAcc)){
					if($v['divisions'] == $val){
						$entity[] = $v['company'];
						$branch[] = $v['locations'];
						$department[] = $v['departments'];
						$team[$k] = $k;
					}
				}
			}
		}
		$division = $_REQUEST['values'];
	}
	
	if($_REQUEST['access'] == 'departments' && isset($_REQUEST['values'])){
		foreach($_REQUEST['values'] as $key=>$val){
			foreach($organization as $k=>$v){
				$k = $v['teams'];
				if(in_array($k, $teamAcc)){
					if($v['departments'] == $val){
						$entity[] = $v['company'];
						$branch[] = $v['locations'];
						$division[] = $v['divisions'];
						$team[$k] = $k;
					}
				}
			}
		}
		$department = $_REQUEST['values'];
	}

	
	if($_REQUEST['access'] == 'branches' && isset($_REQUEST['values'])){
		foreach($_REQUEST['values'] as $key=>$val){
			foreach($organization as $k=>$v){
				$k = $v['teams'];
				if(in_array($k, $teamAcc)){
					if($v['locations'] == $val){
						$entity[] = $v['company'];
						$division[] = $v['divisions'];
						$department[] = $v['departments'];
						$team[$k] = $k;
					}
				}
			}
		}
		$branch = $_REQUEST['values'];
	}
	
	if($_REQUEST['access'] == 'teams' && isset($_REQUEST['values'])){
		foreach($_REQUEST['values'] as $key=>$val){
			foreach($organization as $k=>$v){
				$k = $v['teams'];
				if($k == $val){
					$entity[] = $v['company'];
					$branch[] = $v['locations'];
					$division[] = $v['divisions'];
					$department[] = $v['departments'];
				
				}
			}
		}
		$team = $_REQUEST['values'];
	}

	unset($_SESSION['rego']['sel_entities']);
	unset($_SESSION['rego']['sel_branches']);
	unset($_SESSION['rego']['sel_divisions']);
	unset($_SESSION['rego']['sel_departments']);
	unset($_SESSION['rego']['sel_teams']);
	
	$_SESSION['rego']['sel_entities'] = implode(',', array_unique($entity));
	$_SESSION['rego']['sel_branches'] = implode(',', array_unique($branch));
	$_SESSION['rego']['sel_divisions'] = implode(',', array_unique($division));
	$_SESSION['rego']['sel_departments'] = implode(',', array_unique($department));
	$_SESSION['rego']['sel_teams'] = implode(',', array_unique($team));
	
	// echo '<pre>';
	// print_r($_SESSION['rego']);
	// echo '</pre>'; 
