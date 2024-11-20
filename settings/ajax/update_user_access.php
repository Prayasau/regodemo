<?

	if(session_id()==''){session_start();}
	include('../../dbconnect/db_connect.php');
	//var_dump($_REQUEST); //exit;

	//unset($_SESSION['rego']['mn_'.$_REQUEST['access']]);
	
	//var_dump($teams);

	
	$data = array();
	$entity = array();
	$branch = array();
	$division = array();
	$department = array();
	
	$team = array();
	$organizationss = array();

	if($_REQUEST['access'] == 'entities' && isset($_REQUEST['values'])){
		foreach($_REQUEST['values'] as $key=>$val){
			foreach($organization as $k=>$v){
				$k = $v['teams'];
				if($v['company'] == $val){

					//$data[$val]['branch'][$v['branch']] = $v['branch'];
					//$data[$val][$v['branch']]['division'][$v['division']] = $v['division'];
					$data[$val][$v['locations']][$v['divisions']]['department'][$v['departments']] = $v['departments'];
					$data[$val][$v['locations']][$v['divisions']]['team'][$k] = $k;
					
					$entity[$v['company']] = $v['company'];
					$branch[$v['locations']] = $v['locations'];
					$division[$v['divisions']] = $v['divisions'];
					$department[$v['departments']] = $v['departments'];
					
					$team[$k] = $k;
				}
			}
		}
	}
	//var_dump($data); exit;
	
	if($_REQUEST['access'] == 'branches' && isset($_REQUEST['values'])){
		foreach($_REQUEST['values'] as $key=>$val){
			foreach($organization as $k=>$v){
				$k = $v['teams'];
				if($v['locations'] == $val){

					//$data[$v['entity']]['branch'][$v['branch']] = $v['branch'];
					//$data[$v['entity']][$v['branch']]['division'][$v['division']] = $v['division'];
					$data[$v['company']][$v['locations']][$v['divisions']]['department'][$v['departments']] = $v['departments'];
					$data[$v['company']][$v['locations']][$v['divisions']]['team'][$k] = $k;
					
					$entity[$v['company']] = $v['company'];
					$branch[$v['locations']] = $v['locations'];
					$division[$v['divisions']] = $v['divisions'];
					$department[$v['departments']] = $v['departments'];
					
					$team[$k] = $k;
				}
			}
		}
		$branch = $_REQUEST['values'];
	}
	
	if($_REQUEST['access'] == 'divisions' && isset($_REQUEST['values'])){
		foreach($_REQUEST['values'] as $key=>$val){
			foreach($organization as $k=>$v){
				$k = $v['teams'];
				if($v['divisions'] == $val){

					//$data[$v['entity']]['branch'][$v['branch']] = $v['branch'];
					//$data[$v['entity']][$v['branch']]['division'][$v['division']] = $v['division'];
					$data[$v['company']][$v['locations']][$v['divisions']]['department'][$v['departments']] = $v['departments'];
					$data[$v['company']][$v['locations']][$v['divisions']]['team'][$k] = $k;
				
					$entity[$v['company']] = $v['company'];
					$branch[$v['locations']] = $v['locations'];
					$division[$v['divisions']] = $v['divisions'];
					$department[$v['departments']] = $v['departments'];
					
					$team[$k] = $k;
				}
			}
		}
		
	}
	
	if($_REQUEST['access'] == 'departments' && isset($_REQUEST['values'])){
		foreach($_REQUEST['values'] as $key=>$val){
			foreach($organization as $k=>$v){
				$k = $v['teams'];
				if($v['departments'] == $val){

					//$data[$v['entity']]['branch'][$v['branch']] = $v['branch'];
					//$data[$v['entity']][$v['branch']]['division'][$v['division']] = $v['division'];
					$data[$v['company']][$v['locations']][$v['divisions']]['department'][$v['departments']] = $v['departments'];
					$data[$v['company']][$v['locations']][$v['divisions']]['team'][$k] = $k;
				
					$entity[$v['company']] = $v['company'];
					$branch[$v['locations']] = $v['locations'];
					$division[$v['divisions']] = $v['divisions'];
					$department[$v['departments']] = $v['departments'];
					
					$team[$k] = $k;
				}
			}
		}
	}

	
	
	if($_REQUEST['access'] == 'teams' && isset($_REQUEST['values'])){
		foreach($_REQUEST['values'] as $key=>$val){
			foreach($organization as $k=>$v){
				$k = $v['teams'];

				if($k == $val){

				
					$data[$v['company']][$v['locations']][$v['divisions']]['department'][$v['departments']] = $v['departments'];
					$data[$v['company']][$v['locations']][$v['divisions']]['team'][$k] = $k;
				
					$entity[$v['company']] = $v['company'];
					$branch[$v['locations']] = $v['locations'];
					$division[$v['divisions']] = $v['divisions'];
					$department[$v['departments']] = $v['departments'];
					
					$team[$k] = $k;
				}
			}
		}
		//$team = $_REQUEST['values'];
	}

	/*if($_REQUEST['access'] == 'teams' && isset($_REQUEST['values'])){
		foreach($_REQUEST['values'] as $key=>$val){
			foreach($teams as $k=>$v){
				if($k == $val){

					//$data[$v['entity']]['branch'][$v['branch']] = $v['branch'];
					//$data[$v['entity']][$v['branch']]['division'][$v['division']] = $v['division'];
					$data[$v['entity']][$v['branch']][$v['division']]['department'][$v['department']] = $v['department'];
					$data[$v['entity']][$v['branch']][$v['division']]['team'][$k] = $k;
				
					$entity[$v['entity']] = $v['entity'];
					$branch[$v['branch']] = $v['branch'];
					$division[$v['division']] = $v['division'];
					$department[$v['department']] = $v['department'];
					
					$team[$k] = $k;
				}
			}
		}
		//$team = $_REQUEST['values'];
	}*/



	/*if($_REQUEST['access'] == 'organization' && isset($_REQUEST['values'])){
		foreach($_REQUEST['values'] as $key=>$val){
			foreach($organization as $k=>$v){
				if($k == $val){

					//$data[$v['entity']]['branch'][$v['branch']] = $v['branch'];
					//$data[$v['entity']][$v['branch']]['division'][$v['division']] = $v['division'];
					$data[$v['company']][$v['locations']][$v['divisions']]['department'][$v['departments']] = $v['departments'];
					$data[$v['company']][$v['locations']][$v['divisions']]['team'][$v['teams']] = $v['teams'];
				
					// $entity[$v['entity']] = $v['company'];
					// $branch[$v['locations']] = $v['locations'];
					// $division[$v['divisions']] = $v['divisions'];
					// $department[$v['departments']] = $v['departments'];
					
					 $organizationss[$k] = $k;
				}
			}
		}
		//$team = $_REQUEST['values'];
	}*/



	// echo '<pre>';
	// print_r($data);
	// echo '</pre>';
	// exit;
	

	$tableRow = '';
	if($data){
		$countE = 0;
		$countB = 0;
		foreach($data as $key=>$datas){

			foreach($datas as $key1=>$val){

				foreach($val as $kdd=>$vdd){

					$countB++;
					if($countB == 1){$BranchName = $branches[$key1][$lang]; }else{$BranchName = '';}
					$countE++;
					if($countE == 1){$entitiesName = $entities[$key][$lang]; }else{$entitiesName = '';}

					$tableRow .= '<tr>';
					
					if(count($entities) > 1){
						$tableRow .= '<td class="vat">'.$entitiesName.'</td>';
					}

					if($parameters[1]['apply_param'] == 1 && count($branches) > 1){
						$tableRow .= '<td class="vat">'.$BranchName.'<br></td>';
					}
						
					if($parameters[2]['apply_param'] == 1 && count($divisions) > 1){		
						$tableRow .= '<td class="vat">';
						$tableRow .= $divisions[$kdd][$lang].'<br></td>';
					}
							
					if($parameters[3]['apply_param'] == 1 && count($departments) > 1){		
						$tableRow .= '<td class="vat">';
										foreach($vdd['department'] as $k=>$v){
											$tableRow .= $departments[$v][$lang].'<br>';
										}
						$tableRow .= '</td>';
					}

					if($parameters[4]['apply_param'] == 1 && count($teams) > 1){

						$tableRow .= '<td class="vat teamsAct">';
										foreach($vdd['team'] as $k=>$v){
											$tableRow .= $teams[$v]['code'].'<br>';
										}
						
						$tableRow .= '</td>';
					}

					$tableRow .= '</tr>';
				}
				$countB=0;
				
			}
			$countE=0;
		}
		
	}
	
	/*$tableRow = '';

	if($data){
		foreach($data as $key=>$val){
			$tableRow .= '
						<tr>
							
							<td class="vat">'.$entities[$key][$lang].'</td>
							<td class="vat">';
							foreach($val['branch'] as $k=>$v){
								$tableRow .= $branches[$v][$lang].'<br>';
							}
			$tableRow .= '				
							</td>
							<td class="vat">';
							foreach($val['division'] as $k=>$v){
								$tableRow .= $divisions[$v][$lang].'<br>';
							}
			$tableRow .= '				
							</td>
							<td class="vat">';
							foreach($val['department'] as $k=>$v){
								$tableRow .= $departments[$v][$lang].'<br>';
							}
			$tableRow .= '				
							</td>
							<td class="vat teamsAct">';
							foreach($val['team'] as $k=>$v){
								$tableRow .= $teams[$v]['code'].'<br>';
							}
			
			$tableRow .= '				
							</td>
						</tr>';
		}
	}*/
	
	$result['entity'] = $entity;
	$result['branch'] = $branch;
	$result['division'] = $division;
	$result['department'] = $department;
	
	$result['team'] = $team;
	$result['organizationss'] = $organizationss;
	$result['tableRow'] = $tableRow;
	//var_dump($result); exit;	

	if(!empty($result))
	{
		$_SESSION['session_store'] = $result;
	}
	else
	{
		$_SESSION['session_store'] = '';
	}


	echo json_encode($result);


