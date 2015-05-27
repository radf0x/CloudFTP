<?php
require("db.php");
if(isset($_POST['delFileNames']) === TRUE) {
	function delete_files($filtered) {
		foreach($filtered as $value) {
	   		unlink($value);
	   		echo("Success!");
   		}
	}
	$mydb = new DBAction();
	$mydb->setIdentity('w');
	$alldirname = $mydb->pathFinder('upload');
	$alldirname = array_map("strtolower", $alldirname);

	//echo '<pre>';
	$filename = $_POST['delFileNames'];
	//$filename = $_COOKIE["deletefilename"];
	//$filename_array = explode(',', $filename);

	$filtered = array();
	foreach($filename as $key => $value)
	{
		if(in_array($value, $alldirname))
			array_push($filtered,$value);
	}

	delete_files($filtered);
}
// You should changed the passing key name to other, so can be more easy to identfy
/* Function placed in db.php */
?>