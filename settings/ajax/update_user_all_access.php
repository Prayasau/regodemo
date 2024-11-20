<?

	if(session_id()==''){session_start();}
	include('../../dbconnect/db_connect.php');
	//var_dump($_REQUEST); //exit;

	$allTeamID = array();
	foreach($entities as $val=>$vals){
		foreach($teams as $k=>$v){

			if($v['entity'] == $val){

				//$data[$val]['branch'][$v['branch']] = $v['branch'];
				$data[$val][$v['branch']]['division'][$v['division']] = $v['division'];
				$data[$val][$v['branch']]['department'][$v['department']] = $v['department'];
				$data[$val][$v['branch']]['team'][$k] = $k;
				

			}
			$allTeamID[] = $k;
		}
	}


	$tableRow = '';
	if($data){
		$count = 0;
		foreach($data as $key=>$datas){
			foreach($datas as $key1=>$val){
			$count++;
			if($count == 1){$entitiesName = $entities[$key][$lang]; }else{$entitiesName = '';}
				$tableRow .= '
							<tr>
								
								<td class="vat">'.$entitiesName.'</td>
								<td class="vat">';
								
								$tableRow .= $branches[$key1][$lang].'<br>';
							
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
			$count = 0;
		}
	}
	
	
	// $tableRow = '<tr>
	// 				<td class="vat">All Entities</td>
	// 				<td class="vat">All Branches</td>
	// 				<td class="vat">All Divisions</td>
	// 				<td class="vat">All Departments</td>
	// 				<td class="vat teamsAct">AllTeams</td>
	// 				<td></td>
	// 			</tr>';
	
	$result['entity'] = '1,2,3,4,5,6,7,8,910,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30';
	$result['branch'] = '1,2,3,4,5,6,7,8,910,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30';
	$result['division'] = '1,2,3,4,5,6,7,8,910,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30';
	$result['department'] = '1,2,3,4,5,6,7,8,910,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30';
	$result['team'] = '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50';
	$result['tableRow'] = $tableRow;
	$result['NewteamIds'] = implode(',', array_unique($allTeamID));
	
	//var_dump($result); exit;
	
	echo json_encode($result);
	
	
	