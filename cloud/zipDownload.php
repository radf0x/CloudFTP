<?php
require_once 'db.php';

function zipFilesAndDownload($file_names, $archive_file_name, $file_path){
	$zip = new ZipArchive();
	//create the file and throw the error if unsuccessful
	if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE )!==TRUE) {
    	exit("cannot open <$archive_file_name>\n");
	} else {
		echo 'worked one';
	}
	//add each files of $file_name array to archive
	foreach($file_names as $files)	{
  		$zip->addFile($file_path . $files, $files);		
	}
	
	$zip->close();
	$zipped_size = filesize($archive_file_name);

	header("Content-Description: File Transfer");
	header("Content-type: application/zip"); 
	header("Content-Disposition: attachment; filename=$archive_file_name");
	header("Content-Transfer-Encoding: binary");
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header("Content-Length:". " $zipped_size");
	ob_clean();
	flush();
	readfile("$archive_file_name");
	//unlink("$archive_file_name"); FOR FILE DELETE USE ONLY!!
	exit;
}
	$mydb = new DBAction();
	$myusername = $_COOKIE["name"];
	$mydb -> setIdentity($myusername);
	$allFiles = $mydb -> pathFinder();
	//$file_path = getcwd().'/upload/'.$myusername.'/someFolder/inner/superInner/';
	$allFilesLower = array_map("strtolower", $allFiles);
	echo "<pre>";
	$array_target = array();
	/*
	foreach($_COOKIE as $file_names => $Value){
		$file_names = $Value;
		echo $file_names . ',' . $Value . "\n";
		//echo $file_names . "\n";
		$each = explode(',', $file_names);
		print_r($each);
		/*
		foreach ($each as $key => $value) {
			if(strpos($allFiles[0], $value) === FALSE) {
				echo '123';
			} else {
				echo 'found';
			}
		}
	
	}	*/
	$tmpKeyOfReal = array();
	foreach ($_COOKIE as $key => $value) {
		if($key === 'fileList') {
			$each = explode(',', $value);
			foreach ($each as $key_in => $value_in) {
				foreach ($allFilesLower as $key_inin => $value_inin) {
					if ($value_in === $value_inin) {
						array_push($tmpKeyOfReal, $key_inin);
					}
				}
			}
		}
	}
	$tmpPathArr = array();
	foreach ($tmpKeyOfReal as $key => $value) {
		array_push($tmpPathArr, $allFiles[$value]);
		//echo $allFiles[$value] . "\n";
	}
	//print_r($tmpPathArr);
	$tmpNameArr = array();
	foreach ($tmpPathArr as $key => $value) {
		$nameonly = substr($value, strrpos($value,'/')+1);
		array_push($tmpNameArr, $nameonly);
	}
	//print_r($tmpNameArr);
	$tmpHeadArr = array();
	for ($i=0; $i < count($tmpPathArr); $i++) {
		array_push($tmpHeadArr, str_replace($tmpNameArr[$i], '',  $tmpPathArr[$i]));
	}
	//print_r($tmpHeadArr);
	/*
	$sanitized_file_names = explode(",", $file_names);
	foreach ($sanitized_file_names as $key => $value) {
		$sanitized_file_names = substr($value, strrpos($value,'/')+1);
		array_push($array_target, $sanitized_file_names);
	}

	*/
	$archive_file_name = time() . '.zip';
	
	
	zipFilesAndDownload($tmpNameArr, $archive_file_name, $tmpHeadArr[0]);
?>