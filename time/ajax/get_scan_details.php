<?
	if(session_id()==''){session_start();}; ob_start();
	//$cid = $_SESSION['xhr']['cid'];
	include('../../dbconnect/db_connect.php');
	//include("../../files/functions.php");
	//$_REQUEST['id'] = 10007;
	//var_dump($_REQUEST);
	
	$body = '';
	$data = array();
	$sql = "SELECT filename,content FROM ".$cid."_scanfiles WHERE id = '".$_REQUEST['id']."'";
	if($res = $dbc->query($sql)){
		if($row = $res->fetch_assoc()){
			$data = unserialize($row['content']);
			$filename = $row['filename'];
		}
	}	


	$sql1 = "SELECT * FROM ".$cid."_scandata WHERE filename = '".$filename."' order by id ASC";
	if($res1 = $dbc->query($sql1)){

		$count =1;
		while($row1 = $res1->fetch_assoc())
		{
			// echo '<pre>';
			// print_r($row1);
			// echo '</pre>';
			

				$cnt = 1;
				$body .= '<tr><input type="hidden" id="hidden_scaniD_'.$count.'" name="hidden_scaniD_'.$count.'" value="'.$row1['id'].'" />';
				// STATUS 


				// CHECK SCAN IN VALID 
				if(!empty($row1['scan_in']))
				{
					if (preg_match('~[0-9]+~', $row1['scan_in'])) 
					{
						$scanIN = $row1['scan_in'];
					}
					else
					{
						$scanIN = '';
					}
				}
				else
				{
					$scanIN = '';
				}					

				// CHECK SCAN OUT VALID 
				if(!empty($row1['scan_out']))
				{
					if (preg_match('~[0-9]+~', $row1['scan_out'])) 
					{
						$scanOUT = $row1['scan_out'];
					}
					else
					{
						$scanOUT = '';
					}
				}
				else
				{
					$scanOUT = '';
				}				




				if($row1['datescan'] == '1970-01-01' || $row1['scan_id'] == '' || $scanIN == '' || $scanOUT == '')
				{
					$body .= '<td><span class="InvalidSpan" style="color:red">INVALID</span></td>';
					$body .= '<td><label><input disabled="disabled" id="'.$row1['id'].'" type="checkbox" class="empty both_'.$count.' dbox checkbox notxt totalVal" onchange="allCheckbox(this,'.$count.')"><span style="z-index:0"></span></label></td>';

				}
				else
				{

						$sql2 = "SELECT * FROM ".$cid."_metascandata WHERE scandata_id = '".$row1['id']."' order by id ASC";
						echo $sql2;
						if($res2 = $dbc->query($sql2))
						{
								
							if($row2 = $res2->fetch_assoc())
							{
								// if($row2['scandata_id'] != '')
								// {
									$body .= '<td><span class="existSpan" style="color:red">EXIST</span></td>';
									$body .= '<td><label><input disabled="disabled" id="'.$row1['id'].'" type="checkbox" class="exist dbox both_'.$count.' checkbox notxt totalVal" onchange="allCheckbox(this,'.$count.')"><span style="z-index:0"></span></label></td>';
								// }
								
						
							}

							else
							{
								$body .= '<td><span class="valid_span" style="color:green"><b>VALID</b></span></td>';
								$body .= '<td><label><input id="'.$row1['id'].'" type="checkbox" class="valid dbox both_'.$count.' checkbox notxt totalVal" onchange="allCheckbox(this,'.$count.')"><span style="z-index:0"></span></label></td>';
							}
						
						}


				}





				// DATESCAN
				if($row1['datescan'] == '1970-01-01')
				{
					$body .= '<td><span style="color:red">INVALID</span></td>';
				}
				else
				{
					$datescan  = date('d-m-Y',strtotime($row1['datescan']));
					$body .= '<td>'.$datescan.'</td>';
				}

				// SCAN ID 
				if($row1['scan_id'] == '')
				{
					$body .= '<td><span style="color:red">INVALID</span></td>';
				}
				else
				{
					$body .= '<td>'.$row1['scan_id'].'</td>';
				}


				if($row1['scan_id'] != '')
				{
					// EMPLOYEE ID 
					$body .= '<td>'.$row1['emp_id'].'</td>';
				}
				else
				{
					// EMPLOYEE ID 
					$body .= '<td></td>';
				}
		

				// EMPLOYEE NAME 
				$body .= '<td>'.$row1['emp_name'].'</td>';


			
				if(!empty($row1['scan_in']))
				{
					if (preg_match('~[0-9]+~', $row1['scan_in'])) {
					// contains number 
						$body .= '<td class="tac">'.$row1['scan_in'].'</td>';
					}
					else
					{
						$body .= '<td><span style="color:red">INVALID</span></td>';
					}
					
					
				}
				else
				{
					$body .= '<td class="tac">-</td>';
				}				

				if(!empty($row1['scan_out']))
				{
					if (preg_match('~[0-9]+~', $row1['scan_out'])) {
					// contains number 
						$body .= '<td class="tac">'.$row1['scan_out'].'</td>';
					}
					else
					{
						$body .= '<td><span style="color:red">INVALID</span></td>';
					}

				}
				else
				{
					$body .= '<td class="tac">-</td>';
				}
				
				while($cnt < 8){
					$body .= '<td class="tac">-</td>';
					$cnt++;
				}



				$body .= '</tr>';

			// }
				$count ++;
		}

	}
	
	// foreach($data as $key=>$val){
	// 	foreach($val['time'] as $k=>$v){
	// 		$time = explode('|', $v);
	// 		$body .= '<tr>';
	// 		$body .= '<td>'.$k.'</td>';
	// 		$body .= '<td><span style="color:red">INVALID</span></td>';
	// 		$body .= '<td>'.$val['id'].'</td>';
	// 		$body .= '<td>'.$val['name'].'</td>';
	// 		$cnt = 1;
	// 		foreach($time as $tk=>$tv){
	// 			if(!empty($tv)){
	// 				$body .= '<td class="tac">'.$tv.'</td>';
	// 			}else{
	// 				$body .= '<td class="tac">-</td>';
	// 			}
	// 			$cnt++;
	// 		}
	// 		while($cnt < 10){
	// 			$body .= '<td class="tac">-</td>';
	// 			$cnt++;
	// 		}
	// 		$body .= '</tr>';
	// 	}
	// }


	// die();
	


	//var_dump($data); exit;
	
	//ob_clean();
	// die();
	echo $body;



?>
