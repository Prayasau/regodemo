<?
	
	if(session_id()==''){session_start();}
	ob_start();
	include("../dbconnect/db_connect.php");
	
	//var_dump($_REQUEST); exit;

	// echo '<pre>';
	// print_r($_REQUEST['upload_type']);
	// echo '</pre>';

	// die();

	$uploadmap = DIR.'/images/admin_uploads/';
	if (!file_exists($uploadmap)) {
		mkdir($uploadmap, 0755, true);
	}

	if(!empty($_FILES['uploadimages']['tmp_name'])){
		$extension = pathinfo($_FILES['uploadimages']['name'], PATHINFO_EXTENSION);		
		$filename = $_FILES['uploadimages']['name'];
		$file = $uploadmap.$filename;
		$baseName = $_FILES['uploadimages']['name'];
		$counter = 1;				
		while(file_exists($file)) {
			 $filename = $baseName.'('.$counter.').'.$extension;
			 $file = $uploadmap.$baseName.'('.$counter.').'.$extension;
			 $counter++;
		};

		$string = preg_replace('/\s+/', '', $filename);
		$string2 = preg_replace('/\s+/', '', $file);

		if(move_uploaded_file($_FILES['uploadimages']['tmp_name'], $string2)){
			$data['filename'] = $string;
			$data['date'] = date('d-m-Y');
			$data['size'] = number_format(($_FILES['uploadimages']['size']/1012),2).' Kb';
			$data['ext'] = $extension;

			$sql = "INSERT INTO rego_images (image_name, image_link,upload_type) VALUES('".$dba->real_escape_string($filename)."' ,  '".$dba->real_escape_string($string)."', '".$dba->real_escape_string($_REQUEST['upload_type'])."') ";
			ob_clean();
			if($dba->query($sql)){
				echo 'success';
			}else{
				echo mysqli_error($dba);
			}
		}
	}


	

