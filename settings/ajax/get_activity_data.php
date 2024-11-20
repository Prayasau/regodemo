<?
	if(session_id()==''){session_start();}
	ob_start();
	include("../../dbconnect/db_connect.php");
	include(DIR.'files/arrays_'.$lang.'.php');
	//var_dump($_REQUEST); exit;

	$res = $dbc->query("SELECT * FROM ".$cid."_users WHERE id = '".$_REQUEST['id']."'"); 
	if($row = $res->fetch_assoc()){

		$activities = unserialize($row['activities']);

		// echo '<pre>';
		// print_r($activities);
		// echo '</pre>';

		$html = '';
		$count = 0;
		$moduleCnt = 0;
		foreach($activities as $key => $val){
		$moduleCnt++; 
			foreach($val['activity_name'] as $val1){ 
			 	$count++; 
			 	if($count == 1){ $module = $key; }else{ $module = ''; }
		
				$html .= '<tr id="'.str_replace(' ', '_', $key).'_'.$count.'">';	
				$html .= '<th>'.str_replace('_', ' ', $module).'</th>';
				$html .= '<th class="tal">
							<input type="text" name="activity['.str_replace(" ", "_", $key).'][activity_name][]" value="'.$val1.'" readonly style="min-width: 100%;border:1px solid #fff;padding:0px;"></th>';
				$html .= '<th>
							<select name="activity['.str_replace(" ", "_", $key).'][activity_level][]" style="min-width:100%; background:transparent;border: 1px solid #fff;padding: 0px !important;">';
								$html .= '<option value="">'.$lng['Please select'].'</option>';
								foreach($activity_level as $ke=>$vl){

									$ddd = $activities[str_replace(" ", "_", $key)]['activity_level'][$count -1]; 
									if($ddd == $ke) { $sel = 'selected'; }else{ $sel = '';}
									$html .= '<option value="'.$ke.'" '.$sel.'>'.$vl.'</option>';
								} 
				$html .= '</select></th>';
				$html .= '<th>
							<select name="activity['.str_replace(" ", "_", $key).'][activity_group][]" style="min-width:100%; background:transparent;border: 1px solid #fff;padding: 0px !important;">';
								$html .= '<option value="">'.$lng['Please select'].'</option>';
								foreach($teamsAct as $kee=>$vll){

									$dddg = $activities[str_replace(" ", "_", $key)]['activity_group'][$count -1]; 
									if($dddg == $vll['id']) { $sel = 'selected'; }else{ $sel = '';}
									$html .= '<option value="'.$vll['id'].'" '.$sel.'>'.$vll[$lang].'</option>';
								} 
				$html .= '</select></th>';
				$html .= '</tr>';
			} 

			$html .= '<tr>';
			$html .= '<th>'.str_replace('_', ' ', $key).'</th>';
			$html .= '<th colspan="3">';
			$html .= '<button class="btn btn-primary btn-fl btn-sm" type="button" onclick="AddmoreActivity('.$moduleCnt.', '.$count.', 001)">'.$lng['Add activity'].'</button>';
			$html .= '</th>';
			$html .= '</tr>';

			$count = 0; 
		} 
		ob_clean();
		echo $html;		
	}else{
		ob_clean();
		echo 'Error';
	}
	exit;
?>


















