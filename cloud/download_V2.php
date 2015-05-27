<?php

###############################################################
# File Download 1.31
###############################################################
# Visit http://www.zubrag.com/scripts/ for updates
###############################################################
# Sample call:
#    download.php?f=phptutorial.zip
#
# Sample call (browser will try to save with new file name):
#    download.php?f=phptutorial.zip&fc=php123tutorial.zip
###############################################################

// Allow direct file download (hotlinking)?
// Empty - allow hotlinking
// If set to nonempty value (Example: example.com) will only allow downloads when referrer contains this text
define('ALLOWED_REFERRER', '');

// Download folder, i.e. folder where you keep all files for download.
// MUST end with slash (i.e. "/" )
define('BASE_DIR','/Applications/XAMPP/xamppfiles/htdocs/backupsCloud/cloud_login/cloud/upload/q/someFolder_in_q/inner_in_q/');

// log downloads?  true/false
define('LOG_DOWNLOADS',true);

// log file name
define('LOG_FILE','downloads.log');

// Allowed extensions list in format 'extension' => 'mime type'
// If myme type is set to empty string then script will try to detect mime type 
// itself, which would only work if you have Mimetype or Fileinfo extensions
// installed on server.
$allowed_ext = array (
 	// archives
	'jar' => 'application/java-archive',
	'rar' => 'application/x-rar-compressed',
	'tar' => 'application/x-tar',
	'zip' => 'application/zip',

  	// documents
	'doc' => 'application/msword',
	'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
	'pdf' => 'application/pdf',
	'ppt' => 'application/vnd.ms-powerpoint',
	'pps' => 'application/vnd.ms-powerpoint',
	'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
	'txt' => 'text/plain',
	'xls' => 'application/vnd.ms-excel',
	'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
  
  	// executables
	'apk' => 'application/vnd.android.package-archive',
	'app' => 'application/x-ms-application',
	'exe' => 'application/octet-stream',
	'rm' => 'application/vnd.rn-realmedia',

	// scripts
	'ai' => 'application/postscript',
	'asp' => 'text/asp',
	'csv' => 'text/csv',
	'css' => 'text/css',
	'c' => 'text/x-c',
	'class' => 'application/java-vm',
	'cpp' => 'text/x-c',
	'dtd' => 'application/xml-dtd',
	'htm' => 'text/html',
	'html' => 'text/html',
	'h' => 'text/x-h',
	'java' => 'text/x-java-source,java',
	'json' => 'application/json',
	'js' =>	 'application/javascript',
	'm' => 'text/x-m',
	'ps' => 'application/postscript',
	'py' => 'text/x-script.phyton',
	'sh' => 'application/x-sh',
	'xml' => 'application/xml',
	'xhtml' => 'application/xhtml+xml',
	
	// images
	'bmp' => 'image/bmp',
	'gif' => 'image/gif',
	'jpg' => 'image/jpeg',
	'jpeg' => 'image/jpeg',
	'png' => 'image/png',
	'psd' => 'image/vnd.adobe.photoshop',
	'svg' => 'image/svg+xml',
	'tif' => 'image/tiff',

  	// audio
	'mp3' => 'audio/mpeg',
	'm4a' => 'audio/mp4',
	'mid' => 'audio/midi',
	'wav' => 'audio/x-wav',
	'wma' => 'audio/x-ms-wma',

  	// video
	'avi' => 'video/x-msvideo',
	'flv' => 'video/x-flv',
	'm4v' => 'video/x-m4v',
	'mpeg' => 'video/mpeg',
	'mpg' => 'video/mpeg',
	'mpe' => 'video/mpeg',
	'mov' => 'video/quicktime',
	'mp4' => 'video/mp4',
	'wmv' => 'video/x-ms-wmv'
);



####################################################################
###  DO NOT CHANGE BELOW
####################################################################

// If hotlinking not allowed then make hackers think there are some server problems
if (ALLOWED_REFERRER !== '' && (!isset($_SERVER['HTTP_REFERER']) || strpos(strtoupper($_SERVER['HTTP_REFERER']),strtoupper(ALLOWED_REFERRER)) === false)) {
	die("Internal server error. Please contact system administrator.");
}

// Make sure program execution doesn't time out
// Set maximum script execution time in seconds (0 means no limit)
set_time_limit(0);

if (!isset($_GET['f']) || empty($_GET['f'])) {
	die("Please specify file name for download.");
}

// Nullbyte hack fix
if (strpos($_GET['f'], "\0") !== FALSE) die('');

// Get real file name.
// Remove any path info to avoid hacking by adding relative path, etc.
$encoded_fname = basename($_GET['f']);
$fname = base64_decode($encoded_fname);// Check if the file exists
// Check in subfolders too
function find_file ($dirname, $fname, &$file_path) {
	$dir = opendir($dirname);
	while ($file = readdir($dir)) {
		if (empty($file_path) && $file != '.' && $file != '..') {
			if (is_dir($dirname.'/'.$file)) {
				find_file($dirname.'/'.$file, $fname, $file_path);
			} else {
				if (file_exists($dirname.'/'.$fname)) {
					$file_path = $dirname.'/'.$fname;
					return;
				}
			}
		}
	}
}
// get full file path (including subfolders)																		//must provide true name
$file_path = '/Applications/XAMPP/xamppfiles/htdocs/backupsCloud/cloud_login/cloud/upload/q/someFolder_in_q/inner_in_q/'.$fname;
find_file(BASE_DIR, $fname, $file_path);
if (!is_file($file_path)) {
	die("File does not exist. Make sure you specified correct file name."); 
	
}

// file size in bytes
$fsize = filesize($file_path); 

// file extension
$fext = strtolower(substr(strrchr($fname,"."),1));

// check if allowed extension
if (!array_key_exists($fext, $allowed_ext)) {
	die("Not allowed file type."); 
}

// get mime type
if ($allowed_ext[$fext] == '') {
	$mtype = '';
  // mime type is not set, get from server settings
	if (function_exists('mime_content_type')) {
		$mtype = mime_content_type($file_path);
	} else if (function_exists('finfo_file')) {
		$finfo = finfo_open(FILEINFO_MIME); // return mime type
		$mtype = finfo_file($finfo, $file_path);
		finfo_close($finfo);
	}
	if ($mtype == '') {
		$mtype = "application/force-download";
	}
} else {
  // get mime type defined by admin
  $mtype = $allowed_ext[$fext];
}

// Browser will try to save file with this filename, regardless original filename.
// You can override it if needed.

if (!isset($_GET['fc']) || empty($_GET['fc'])) {
	$asfname = $fname;
} else {
  // remove some bad chars
  $asfname = str_replace(array('"',"'",'\\','/'), '', $_GET['fc']);
  if ($asfname === '') $asfname = 'NoName';
}

// set headers
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Type: $mtype");
header("Content-Disposition: attachment; filename=\"$asfname\"");
header("Content-Transfer-Encoding: binary");
header("Content-Length: " . $fsize);

// download
// @readfile($file_path);
$file = @fopen($file_path,"rb");
if ($file) {
	while(!feof($file)) {
		print(fread($file, 1024*8));
		flush();
		if (connection_status()!=0) {
			@fclose($file);
			die();
		}
	}
	@fclose($file);
}

// log downloads
if (!LOG_DOWNLOADS) die();

$f = @fopen(LOG_FILE, 'a+');
if ($f) {
	@fputs($f, date("m.d.Y g:ia")."  ".$_SERVER['REMOTE_ADDR']."  ".$fname."\n");
	@fclose($f);
}

?>