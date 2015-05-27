<?php
function get_data($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}
$returned_content = get_data('http://localhost/backupscloud/cloud_login/cloud/upload/q/somefolder_in_q/inner_in_q/24_in_q.png');
echo $returned_content;
?>