<?php
require_once 'db.php';
//require_once 'ScalingModel.php';

$myConnection = new DBAction();
//$model = new ScalingModel();

if(isset($_POST['role']) === TRUE ) {
	$myConnection -> createUserFolder($_POST['username']);
	echo $myConnection -> addNewAccount($_POST['role'], $_POST['userName'], $_POST['pwd'], $_POST['name'], $_POST['phone'], $_POST['address']);
}

if(isset($_POST['oldUserName']) === TRUE) {
	echo $myConnection -> getAccount($_POST['oldUserName'], $_POST['oldPwd']);
}
/*
if(isset($_POST['setSize']) === TRUE) {
	echo $myConnection ->setSize(20971520);
}
*/
if(isset($_POST['username']) === TRUE) {
	$tmpStat = array();
	if(array_key_exists('changedMem', $_COOKIE)) {
		$myConnection -> setSize(20971520);
	} else {
		$myConnection -> setSize(10485760);
	}
	$myConnection -> setIdentity($_POST['username']);
	$displaySize = $myConnection -> displayStoragePercent($_POST['username'], 'upload');
	$total = $myConnection -> formatBytes($myConnection -> getSize());
	$typeDis = $myConnection -> typeDistribution($myConnection -> pathFinder('upload'));
	$typeSize = $myConnection -> getTypeSizePercentage('upload');
	array_push($tmpStat, $displaySize);
	array_push($tmpStat, $total);
	array_push($tmpStat, $typeDis);
	array_push($tmpStat, $typeSize);
	echo json_encode($tmpStat);
}

if(isset($_POST['fileType']) === TRUE) {
	$myConnection -> setIdentity($_POST['userRole']);
	print_r($myConnection -> fileTypeSelector('upload', $_POST['fileType']));
}


if(isset($_POST['createFolder']) === TRUE) {
	$myConnection -> setIdentity($_POST['userRole']);
	echo $myConnection -> createCustomFolder($_POST['foldername'], $_POST['currentpath']);
	//echo 'THis is foldername: ' . $_POST['foldername'] . '; This is currPath: ' . $_POST['currentpath'];
}

if(isset($_POST['selectedDelFiles']) === TRUE) {
	$myConnection -> setIdentity($_POST['userRole']);
	print_r($myConnection -> removeMultiFiles($_POST['selectedDelFiles']));
}

if(isset($_POST['selectedFolder']) === TRUE) {
	$myConnection -> setIdentity($_POST['userRole']);
	print_r(json_encode($myConnection -> filterRelatedLink($myConnection -> findRelatedFileAndPath($_POST['currentpath'], $_POST['selectedFolder']))));
}

if(isset($_POST['goinner']) === TRUE) {
	$myConnection -> setIdentity($_POST['userRole']);
	print_r(json_encode($myConnection -> filterRelatedLink($myConnection -> findRelatedFileAndPath($_POST['currentpath'], $_POST['selected']))));
}

if(isset($_POST['selectedDelFiles']) === TRUE) {
	$myConnection -> setIdentity($_POST['userRole']);
	print_r($myConnection -> removeMultiFiles($_POST['selectedDelFiles']));
}

if(isset($_POST['selectedFiles']) === TRUE) {
	$myConnection -> setIdentity($_POST['userRole']);
	print_r($myConnection -> shareFiles($_POST['userRole'], $_POST['selectedFiles'], $_POST['shareToName']));
}

if(isset($_POST['sharedUserRole']) === TRUE) {
	$myConnection -> setIdentity($_POST['sharedUserRole']);
	print_r(json_encode($myConnection -> showSharedFiles($_POST['sharedUserRole'])));
}

if(isset($_POST['unShareFileID']) === TRUE) {
	$myConnection -> setIdentity($_POST['userRole']);
	print_r($myConnection -> unShareFiles($_POST['unShareFileID'], $_POST['userRole']));
}	
/*
echo '<pre>';

$userArray = $myConnection -> setIdentity('w');
$tmpStat = array();
$myConnection -> setIdentity('w');

/*
print_r($myConnection -> showSharedFiles('w'));

//Set request 4 levels of user numbers
$levelArray = $model -> getSequence(4);

print_r($levelArray);
$model -> createLevelVector($userArray, $levelArray);

*/
// 100MB = 104857600; 50MB = 52428800; 25MB = 26214400; 12.5MB = 13107200 
// 20MB = 20971520; 10MB = 10485760; 5MB = 5242880
?>
