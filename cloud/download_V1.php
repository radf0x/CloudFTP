<?php

class DownloadModule {

	function download_file($file) {

		if (!is_file($file)) {
			die("<b>404 File not found!</b>");
		}

		$len = filesize($file);
		$filename = basename($file);
		$file_extension = strtolower(substr(strrchr($filename, "."), 1));

		switch( $file_extension ) {
			case "ai" : $ctype = "application/postscript"; break;
			case "apk" : $ctype = "application/vnd.android.package-archive"; break;
			case "app" : $ctype = "application/x-ms-application"; break;
			case "avi" : $ctype = "video/x-msvideo"; break;
			case "bmp" : $ctype = "image/bmp"; break;
			case "csv" : $ctype = "text/csv"; break;
			case "css" : $ctype = "text/css"; break;
			case "c" : $ctype = "text/x-c"; break;
			case "class" : $ctype = "application/java-vm"; break;
			case "doc" : $ctype = "application/msword"; break;
			case "docx" : $ctype = "application/vnd.openxmlformats-officedocument.wordprocessingml.document"; break;
			case "dtd" : $ctype = "application/xml-dtd"; break;
			case "exe" : $ctype = "application/x-msdownload"; break;
			case "flv" : $ctype = "video/x-flv"; break;
			case "gif" : $ctype = "image/gif"; break;
			case "html" : $ctype = "text/html"; break;
			case "json" : $ctype = "application/json"; break;
			case "jpg" : $ctype = "image/jpeg"; break;
			case "jar" : $ctype = "application/java-archive"; break;
			case "js" :	$ctype = "application/javascript"; break;
			case "java" : $ctype = "text/x-java-source,java"; break;
			case "m4a" : $ctype = "audio/mp4"; break;
			case "mid" : $ctype = "audio/midi";
			case "m4v" : $ctype = "video/x-m4v"; break;
			case "mp4" : $ctype = "video/mp4"; break;
			case "mpg" : $ctype = "audio/mpeg"; break;
			case "pdf" : $ctype = "application/pdf"; break;
			case "ppt" : $ctype = "application/vnd.ms-powerpoint"; break;
			case "pptx" : $ctype = "application/vnd.openxmlformats-officedocument.presentationml.presentation"; break;
			case "png" : $ctype = "image/png"; break;
			case "psd" : $ctype = "image/vnd.adobe.photoshop"; break;
			case "rm" : $ctype = "application/vnd.rn-realmedia"; break;
			case "rar" : $ctype = "application/x-rar-compressed"; break;
			case "svg" : $ctype = "image/svg+xml"; break;
			case "sh" : $ctype = "application/x-sh"; break;
			case "tar" : $ctype = "application/x-tar"; break;
			case "tif" : $ctype = "image/tiff"; break;
			case "wav" : $ctype = "audio/x-wav"; break;
			case "wma" : $ctype = "audio/x-ms-wma"; break;
			case "wmv" : $ctype = "video/x-ms-wmv"; break;
			case "xml" : $ctype = "application/xml"; break;
			case "xls" : $ctype = "application/vnd.ms-excel"; break;
			case "xlsx" : $ctype = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
			case "xhtml" : $ctype = "application/xhtml+xml"; break;
			case "zip" : $ctype = "application/zip"; break;
			default : $ctype = "application/force-download";
		}

		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Type: $ctype");

		$header = "Content-Disposition: attachment; filename=" . $filename . ";";
		header($header);
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: " . $len);
		@readfile("$file");
		exit ;
	}
}
$myDownload = new DownloadModule();
if(isset($_POST['name']) === TRUE) {
	$myDownload -> download_file('C:/xampp/htdocs/cloud_login/cloud/upload/' . $_POST['name']);
}

?>