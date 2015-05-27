<?php
include 'curl.php';

class GetData {

	public function createCurlObj($link) {
		$this -> link = $link;
		$curlLink = new curl($this -> link);
		$curlData = $curlLink -> initCurl();
		return $curlData;
	}

	public function formatData($obj) {
		$this -> obj = $obj;
		$file = fopen("ngoList_2.txt", 'w');
		$current = file_get_contents("ngoList_2.txt");
		$content = explode("<div id=\"organization\">", $this -> obj);
		$clean = explode("<div class=\"organization-btm\">", $content[1]);
		$clean[0] = preg_replace('/<[^>]*>/', '', $clean[0]);
		$current .= $clean[0];
		file_put_contents("ngoList_2.txt", $current);
		fclose($file);
	}

	public function getLatLng($objArray) {
		$data = $objArray;
		$result = array();
		$hum_url_array = array();
		$env_url_array = array();
		$hum_name = $objArray[0][1];
		$env_name = $objArray[1][1];
		$hum_addr = $objArray[0][3];
		$env_addr = $objArray[1][3];
		$hum_tel = $objArray[0][4];
		$env_tel = $objArray[1][4];
		$frontLink = 'http://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=';
		
		/* Used for create formated link to get Latitude and Longitude from Google Geocodding */
		
		for ($i = 0; $i < count($hum_addr); $i++)
			array_push($hum_url_array, preg_replace('/\s+/', '+', $hum_addr[$i]));
		for ($i = 0; $i < count($env_addr); $i++)
			array_push($env_url_array, preg_replace('/\s+/', '+', $env_addr[$i]));
		for ($i = 0; $i < count($hum_url_array); $i++)
			$hum_url_array[$i] = ($hum_url_array[$i] == 'None') ? $hum_url_array[$i] : $frontLink . $hum_url_array[$i];
		for ($i = 0; $i < count($env_url_array); $i++)
			$env_url_array[$i] = ($env_url_array[$i] == 'None') ? $env_url_array[$i] : $frontLink . $env_url_array[$i];
		
		for ($i = 0; $i < count($hum_url_array); $i++) {
			if ($hum_url_array[$i] != 'None') {
				//$hum_curl_data = $this -> createCurlObj($hum_url_array[$i]);
				//$this -> saveJSON($hum_curl_data, $i);
				$current = file_get_contents('curlJSON/' . $i . '.json', 'r');
				$json_to_array = json_decode($current, TRUE);
				array_push($result, $hum_name[$i]);
				array_push($result, $hum_tel[$i]);
				array_push($result, $hum_addr[$i]);
				array_push($result, $json_to_array['results'][0]['geometry']['location']);
			}
		}
		for ($i = 0; $i < count($env_url_array); $i++) {
			if ($env_url_array[$i] != 'None') {
				//$env_curlData = $this -> createCurlObj($env_url_array[$i]);
				//$this -> saveJSON($env_curlData, $i+34);
				$fileName = $i + 34;
				$current = file_get_contents('curlJSON/' . $fileName . '.json', 'r');
				$json_to_array = json_decode($current, TRUE);
				array_push($result, $env_name[$i]);
				array_push($result, $env_tel[$i]);
				array_push($result, $env_addr[$i]);
				array_push($result, $json_to_array['results'][0]['geometry']['location']);
			}
		}
		return json_encode($result);
	}
	
	public function saveJSON($obj, $id) {
		$this -> obj = $obj;
		$file = fopen("curlJSON/" . $id . ".json", 'w');
		fwrite($file, $this -> obj);
		fclose($file);
	}

	public function placeData() {
		$cluster = array(
			$humanity = array( $total = array(), 
				$hum_name = array(), $hum_desc = array(), 
				$hum_addr = array(), $hum_tel = array(), 
				$hum_email = array(), $hum_web = array()
			), 
			$environment = array( $total = array(), 
				$env_name = array(), $env_desc = array(), 
				$env_addr = array(), $env_tel = array(), 
				$env_email = array(), $env_web = array()
			)
		);
		$current = file_get_contents("ngoList_1.txt");
		$category = explode('Category:', $current);

		/* Index 0 is empty, 1 is humanity, 2 is environment */

		$content = explode('Name:', $category[1]);
		for ($j = 1; $j < count($content); $j++) {
			array_push($cluster[0][0], $content[$j]);
			$name = explode('Desc:', $content[$j]);
			array_push($cluster[0][1], preg_replace('/\n/', '', $name[0]));
			$desc = explode('Contact:', $name[1]);
			array_push($cluster[0][2], preg_replace('/\n/', '', $desc[0]));
			$contact = explode('Tel:', $desc[1]);
			array_push($cluster[0][3], preg_replace('/\n/', '', $contact[0]));
			$tel = explode('Email:', $contact[1]);
			array_push($cluster[0][4], preg_replace('/\s/', '', $tel[0]));
			$email = explode('Web:', $tel[1]);
			array_push($cluster[0][5], preg_replace('/\s+/', '', $email[0]));
			array_push($cluster[0][6], preg_replace('/\s+/', '', $email[1]));
		}
		$content_2 = explode('Name:', $category[2]);
		for ($j = 1; $j < count($content_2); $j++) {
			array_push($cluster[1][0], $content_2[$j]);
			$name = explode('Desc:', $content_2[$j]);
			array_push($cluster[1][1], preg_replace('/\n/', '', $name[0]));
			$desc = explode('Contact:', $name[1]);
			array_push($cluster[1][2], preg_replace('/\n/', '', $desc[0]));
			$contact = explode('Tel:', $desc[1]);
			array_push($cluster[1][3], preg_replace('/\n/', '', $contact[0]));
			$tel = explode('Email:', $contact[1]);
			array_push($cluster[1][4], preg_replace('/\s/', '', $tel[0]));
			$email = explode('Web:', $tel[1]);
			array_push($cluster[1][5], preg_replace('/\s+/', '', $email[0]));
			array_push($cluster[1][6], preg_replace('/\s+/', '', $email[1]));
		}
		return $cluster;
	}

	public function createNameIndex($objArray) {
		$tmp_2 = array();
		$result = array();
		$hum_name = $objArray[0][1];
		$env_name = $objArray[1][1];
		$tmp = array_merge($hum_name, $env_name);
		asort($tmp);
		foreach ($tmp as $key => $value)
			array_push($tmp_2, substr($value, 0, 1));
		foreach (array_count_values($tmp_2) as $key => $value)
			array_push($result, $key . ',' . $value);
		return json_encode($result);
	}
	
	public function getNgoNameByIndex($objArray, $index) {
		$result = array();
		$hum_ngo = $objArray[0][1];
		$env_ngo = $objArray[1][1];
		$tmp = array_merge($hum_ngo, $env_ngo);
		foreach($tmp as $key => $value) {
			if(strpos($value, $index) === 0)
				array_push($result, $value);
		}
		return json_encode($result);
	}
	
	public function getNgoByName($objArray, $name) {
		$result = array();
		$hum_ngo = $objArray[0][0];
		$env_ngo = $objArray[1][0];
		$tmp = array_merge($hum_ngo, $env_ngo);
		foreach ($tmp as $key => $value) {
			if(strstr($value, $name))
				array_push($result, $value);
		}
		return json_encode($result);
	}
	
	public function getLatLngByName($objArray, $name) {
		$hum_ngo = $objArray[0][1];
		$env_ngo = $objArray[1][1];
		$hum_addr = $objArray[0][3];
		$env_addr = $objArray[1][3];
		$tmpName = array_merge($hum_ngo, $env_ngo);
		$tmpAddr = array_merge($hum_addr, $env_addr);		
		$targetAddr = $tmpAddr[array_search($name, $tmpName)];	//case sensitive
		$frontLink = 'http://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=';
		$curlData = json_decode($this -> createCurlObj($frontLink . preg_replace('/\s+/', '+', $targetAddr)), TRUE);
		return json_encode($curlData['results'][0]['geometry']['location']);
	}
	
	public function getNgoByLocation($objArray, $location) {
		$result = array();
		$hum_ngo = $objArray[0][0];
		$env_ngo = $objArray[1][0];
		$tmp = array_merge($hum_ngo, $env_ngo);
		foreach ($tmp as $key => $value) {
			if(strstr($value, $location))
				array_push($result, $value);
		}
		return json_encode($result);
	}
}

$data = new GetData();
/*
 * Create 84 curl object
 * $baseLink = "http://www.ctgoodjobs.hk/ngo/ngo_list.asp?cp=";
 * for($i = 10; $i < 84; $i++) {
 $curlData = $data -> createCurlObj($baseLink . $i);
 $data -> formatData($curlData);
 }*/

$dataSet = $data -> placeData();
/*
echo '<pre>';
print_r($data -> getNgoByLocation($dataSet, 'Central'));
print_r($dataSet);
$data -> getLatLngByName($dataSet, 'Adventure-Ship');
*/

if(isset($_POST['event']) === TRUE)
	print_r($data -> getLatLng($dataSet));
if(isset($_POST['infoevent']) === TRUE)
	print_r($data -> get_ngo_name_with_address($dataSet));
if(isset($_POST['showIndexTable']) === TRUE)
	print_r($data -> createNameIndex($dataSet));
if(isset($_POST['index']) === TRUE)
	print_r($data -> getNgoNameByIndex($dataSet, $_POST['index']));
if(isset($_POST['ngo']) === TRUE) {
	$result = array();
	array_push($result, json_decode($data -> getNgoByName($dataSet, $_POST['ngo'])));
	array_push($result, json_decode($data -> getLatLngByName($dataSet, $_POST['ngo'])));
	print_r(json_encode($result));
}
if(isset($_POST['district']) === TRUE)
	print_r($data -> getNgoByLocation($dataSet, $_POST['district']));

?>