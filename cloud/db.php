<?php
class DB {
	private $host = 'localhost', $name = 'cloud_login', $user = 'root', $pass = '';

	public function Connect() {
		return new PDO("mysql:host=$this->host; dbname=$this->name", $this -> user, $this -> pass);
	}

}

class DBAction {

	/* * * * * * * * * * * * * * * * * * * * * * *
	 * TRUNCATE TABLE table_name;				 *
	 * ALTER TABLE table_name AUTO_INCREMENT = 1;*
	 * * * * * * * * * * * * * * * * * * * * * * */

	private $size = 0, $limitSize = 0;
	private $identity = null;
	
	private $extensionArray = array(
		'Document' => array(
			'doc', 'docx', 'txt', 'pages', 'pdf'
		),
		'Data' => array( 
			'csv', 'key', 'pps', 'ppt', 'pptx', 'tar', 'xml', 'json',
			'xlr', 'xls', 'xlsx'
		),
		'Media' => array(
			'm4a', 'mid', 'mp3', 'wav', 'wma',
			'avi', 'flv', 'm4v', 'mov', 'mp4', 'mpg', 'rm', 'srt', 'wmv'
		),
		'Image' => array(
			'bmp', 'gif', 'jpg', 'png', 'psd', 'tif',
			'ai', 'ps', 'svg' 
		),
		'Program' => array(
			'apk', 'app', 'bat', 'cgi', 'exe', 'jar', 'vb', 'dmg', 'zip', 'rar'
		),
		'Script' => array(
			'db', 'sql',
			'asp', 'css', 'htm', 'html', 'js', 'jsp', 'php', 'xhtml',
			'c', 'class', 'cpp', 'cs', 'dtd', 'h', 'java', 'm', 'pl', 'py', 'sh', 'vcxproj', 'xcodeproj'
		)
	);
	 
	public function __construct() {
		$this -> database = new DB();
		$this -> database = $this -> database -> Connect();
	}

	public function getIdentity() {
		return $this -> identity;
	}

	public function setIdentity($identity) {
		$this -> identity = $identity;
	}
	
	public function getSize() {
		return $this -> size;
	}
	
	public function setSize($size) {
		$this -> size = $size;
	}

	public function getTotalSizeLimit() {
		return $this -> limitSize;
	}

	public function setTotalSizeLimit($size) {
		$this -> limitSize = $size;
	}
	
	public function getExtensionArray() {
		return $this -> extensionArray;
	}

	public function createCustomFolder($foldername = null, $currPath = null) {
			$status = null;
			$user = $this -> getIdentity();
			//$pattern = '/' . $foldername . '/';
			$sym = (preg_match("/Darwin/i", php_uname())) ? '/' : '\\';
			$sysDir = getcwd() . $sym . 'upload' . $sym . $user;
			$currPath = ($currPath === '\\') ? null : $currPath;
			foreach (scandir($sysDir) as $key => $value) {
				if(is_dir($value))
					if(strpos($value, $foldername) !== FALSE) {
						$status = 'Folder name exists.';
						break;
					} else {
						/* FORMAT: newfolder3 + \newfolder\newfolder2 */

						$status = (mkdir($currPath . $sym . $foldername)) ? $currPath . $sym . $foldername : "Wrong path at: $sysDir$currPath$sym$foldername";
						break;
					}
			}
			return $status;
		}

	public function findRelatedFileAndPath($currentpos, $fragment) {
		$fragment = ($fragment === DIRECTORY_SEPARATOR) ? null : $fragment;
		$result = array('backLink' => array(), 'desLink' => array());
		$sym = (preg_match("/Darwin/i", php_uname())) ? '/' : '\\';
		$acPath = getcwd() . $sym . 'upload' . $sym . $this -> getIdentity();
		$fronthead = ($currentpos === DIRECTORY_SEPARATOR) ? $acPath : $acPath . $currentpos;
		$targetmatch = $fronthead . $sym . $fragment;
		$dirArray = $this -> getAllDir();
		$fileArray = $this -> pathFinder();
		$total = array_merge($dirArray, $fileArray);
		$fragmentIsFile = (strpos($fragment, '.') === FALSE) ? TRUE : FALSE;
		
		if(!empty($fragment)) {
			foreach ($total as $key => $value) {
				if($value === $targetmatch) {
					$targetOnly = substr($targetmatch, 0, -(strlen($fragment))-1);
					array_push($result['backLink'], $targetOnly);
					array_push($result['desLink'], $value);
					break;
				}
			}
		} else {
			array_push($result['backLink'], $targetmatch);
			array_push($result['desLink'], $targetmatch);
		}
		return $result;
	}

	public function filterRelatedLink($keyLinkArray) {
		$result = array('backLink' => array(), 'visableLink' => array());
		$fullbase = array_merge($this -> getAllDir(), $this -> pathFinder());
		$target = $keyLinkArray['desLink'][0];
		$link = str_replace('/', '\/', $target);
		array_push($result['backLink'], $keyLinkArray['backLink'][0]);
		foreach ($fullbase as $key => $value) {
			if(preg_match('/'. $link .'/', $value)) {
				$replace = substr($target, 0, strlen($value));
				$items = str_replace($replace, '', $value);
				$rmhead = substr($items, 1);
				//echo "Replacement: $replace\nItems: $items\nAfter rm: $rmhead\n";
				if(!empty($rmhead)){
					if(substr_count($rmhead, '/') === 0 ) {
						//echo 'Show: '.$value . "\n";
						array_push($result['visableLink'], $value);
					} else {
						continue;
						//echo 'Not show: '.$value . "\n";
					}
				}
			}
		}
		return $result;
	}

	public function getAllDir($folder = 'upload') {
		$dir = array();
		$identity = $this -> getIdentity();
		$symbol = (preg_match('/Darwin/i', php_uname())) ? '/' : '\\';
		$ignoreType = array('.','..','cgi-bin','.DS_Store');
		foreach (scandir($folder) as $key => $value) {
			if(!in_array($value, $ignoreType)) {
				if(is_dir($folder . $symbol . $value)) {
					$dirPath = $folder . $symbol . $value;
					(strpos($dirPath, "$symbol$identity$symbol")) ? array_push($dir, getcwd() . $symbol . $dirPath) : null ;
					$dir = array_merge($this -> getAllDir($dirPath), $dir);
				}
			}
		}
		return $dir;
	}

	public function calAllFolderOnDiskPercentage() {
		// Get all user total folder size
		$allUserSize = array_sum($this -> getAllAccountSize());
		// Set Storage limited size to 20MBs
		$this -> setTotalSizeLimit(20971520);
		return 'Current storage level: ' . $this -> calSize($allUserSize, $this -> getTotalSizeLimit()) . "%";
	}

	public function getAllAccountSize() {
		$result = array();
		$allUser = array();
		$symbol = (preg_match('/Darwin/i', php_uname())) ? '/' : '\\';
		
		foreach (scandir('upload') as $key => $value) {
			if(preg_match('/[a-zA-Z0-9]/', $value)) {
				$this -> setIdentity($value);
				array_push($allUser, $value);
				array_push($result, $this -> getFolderSize('upload'));
			}
		}
		$result = array_combine($allUser, $result);
		// Return all user folder size, username as array key
		return $result;
	}
 
	public function createUserFolder($username) {
		if(preg_match("/Darwin/i", php_uname()))
			$path = '/Applications/XAMPP/xamppfiles/htdocs/cloud_login/cloud/upload/' . $username;
		else
			$path = 'C:\xampp\htdocs\cloud_login\cloud\upload\\' . $username;
		mkdir($path, 0777);
	}
	
	public function getTypeSizePercentage($folder) {

		function getElementType(&$index) {
			return explode(';', $index)[0];
		}
		function getElementStat($index) {
			return stat($index)[7];
		}
		function getKey($index) {
			$data = new DBAction();
			$extensionArray = $data -> getExtensionArray();
			// Get the extension from the file name
			$extension = explode('.', $index);
			$extension = strtolower($extension[1]);
			foreach ($extensionArray as $key => $value) {
				if(in_array($extension, $value)) {
					// Return the key=category of the extension
					return $key . ';' . $index;
				} else
					continue;
			}
		}

		$result = array();
		$extensionArray = $this -> getExtensionArray();
		// All File path 
		$files = array_map('strtolower', $this -> pathFinder($folder));
		// Get total file size from directory
		$totalFileSize = array_sum(array_map("getElementStat", $files));
		//All file type from extension array
		$fullTypeKeys = array_keys($extensionArray);
		//File name with type as elements
		$compareKeys = array_map("getKey", $files);
		//File types of files
		$uniqueKeys = array_unique(array_map("getElementType", $compareKeys));
		// Empty Assoc array with occured file type as keys
		$result = array_fill_keys($uniqueKeys, array());
		// File types that are occured from result array
		$typeArray = array_fill_keys($uniqueKeys, array());
		// File types that are missing from the result array
		$missingKeys = array_diff($fullTypeKeys, $uniqueKeys);
		// Result array with type as key frame
		$result = array_merge($result, array_fill_keys($missingKeys, array()));

		foreach ($compareKeys as $key => $value) {
			$type = explode(';', $value)[0];
			if(array_key_exists($type, $typeArray))
				array_push($typeArray[$type], explode(';', $value)[1]);
		}

		foreach ($typeArray as $key => $value) {
			$changed = array_map("getElementStat", $value);
			$reducedTypeSize = array_sum(array_replace($value, $changed));
			$formattedSize = $this -> calSize($reducedTypeSize, $totalFileSize);
			array_push($result[$key], $formattedSize . '%');
			array_push($result[$key], $this -> formatBytes($reducedTypeSize));
		}

		foreach ($result as $key => $value) {
			for($i = 0; $i < count($result[array_keys($result)[0]]); $i++) {
				if(empty($value))
					array_push($result[$key], '0%');
			}
		}
		return $result;
	}
	
	public function fileTypeSelector($folder, $type) {
		$result = array(
			'name' => array(), 'time' => array()
		);
		$timeList = $this -> getFileTime($folder);
		//print_r($timeList);
		$extensionArray = $this -> getExtensionArray();
		//$files = array_map('strtolower', $this -> getAllFiles($folder));
		$files = array_map('strtolower', $this -> pathFinder($folder));
		//print_r($files);
		foreach ($files as $key => $value) {
			$ext = strtolower(substr($value, -3));
			if(in_array($ext, $extensionArray[$type])) {
				array_push($result['name'], $value);
				array_push($result['time'], $timeList[$key]);
			}
		}
		//print_r($result);
		return json_encode($result);
	}
	
	public function typeDistribution($fileArray) {
		$result = array();

		function modifyElement($index) {
			return $index . ': 0%';
		}
		function mapFun($index) {
			$data = new DBAction();
			$extensionArray = $data -> getExtensionArray();
			// Get the extension from the file name
			$extension = explode('.', $index);
			$extension = strtolower($extension[1]);
			foreach ($extensionArray as $key => $value) {
				if(in_array($extension, $value)) {
					// Return the key=category of the extension
					return $key;
				} else
					continue;
			}
		}
		$results = array_map("mapFun", $fileArray);
		$existKeys = array_keys(array_count_values($results));
		$missingKeys = array_diff(array_keys($this -> getExtensionArray()), $existKeys);
		
		foreach (array_count_values($results) as $key => $value)
			array_push($result, $key . ': ' . $this -> calSize($value, count($results)) . '%');
		return array_merge($result,  array_map("modifyElement", $missingKeys));
		
	}
	
	public function round_up($value, $places = 0) {
		$places = ($places < 0) ? 0 : FALSE;
		return ceil($value * pow(10, $places)) / pow(10, $places); 
	}
	
	public function calSize($each, $total) {
		return $size = round(($each / $total) * 100 , 1);
	}

	public function displayStoragePercent($username, $folder) {
		$role = $this -> showStatus($username);
		$currentSize = $this -> getFolderSize($folder);
		//$maxSize = ($role == 'premium') ? $this -> setSize(20971520) : $this -> setSize(5242880);
		$sizePercentage = ($currentSize <= $this -> getSize()) ? $this -> calSize($currentSize, $this -> getSize()) : FALSE;
		return $sizePercentage;
	}

	public function getFolderSize($folder) {
		$total = 0;
    	$files = $this -> pathFinder($folder);
    	if (!file_exists($folder))
			mkdir($folder, 0777, true);
		foreach ($files as $key => $value) {
			$results = stat($value);
			$total += $results[7];
		}
		return $total;
	}
	
	public function getFileAbsolutePath($file) {
		$fileList = $this -> pathFinder('upload');
		foreach ($fileList as $key => $value) {
			if(strstr($value, $file))
				return $value;
		}
	}
	
	public function getFileTime($folder) {
		$timeList = array();
		$identity = $this -> getIdentity();
		$symbol = (preg_match('/Darwin/i', php_uname())) ? '/' : '\\';
		$ignoreType = array('.','..','cgi-bin','.DS_Store');
		foreach (scandir($folder) as $key => $value) {
			if (!in_array($value, $ignoreType)) {
				if(is_dir($folder . $symbol . $value)) {
					$timeList = array_merge($this -> getFileTime($folder . $symbol . $value), $timeList);
				} else {
					$acPath = getcwd() . $symbol . $folder . $symbol . $value ;
					(strpos($acPath, "$symbol$identity$symbol")) ? array_push($timeList, date ("F-d-Y H:i:s", filemtime($acPath))) : null ;
				}
			}
		}
		/*
		foreach (scandir($folder) as $key => $value) {
			if(strstr($value, '.') && preg_match('/[a-zA-Z0-9]/', $value) && $value != '.DS_Store') {
				$acPath = getcwd() . $symbol . $folder . $symbol . $value ;
				(strpos($acPath, "$symbol$identity$symbol")) ? array_push($timeList, date ("F-d-Y H:i:s", filemtime($acPath))) : null ;
			} else if(preg_match('/[a-zA-Z0-9]/', $value))
				$timeList = array_merge($this -> getFileTime($folder . $symbol . $value), $timeList);
		}*/
		return $timeList;
	}
	
	public function getAllFiles($folder) {
		$files = array();
		$identity = $this -> getIdentity();
		$symbol = (preg_match('/Darwin/i', php_uname())) ? '/' : '\\';
		$ignoreType = array('.','..','cgi-bin','.DS_Store');
		foreach (scandir($folder) as $key => $value) {
			if (!in_array($value, $ignoreType)) {
				if(is_dir($folder . $symbol . $value)) {
					$files = array_merge($this -> getAllFiles($folder . $symbol . $value), $files);
				} else {
					$acPath = getcwd() . $symbol . $folder . $symbol . $value ;
					(strpos($acPath, "$symbol$identity$symbol")) ? array_push($files, $value) : null ;
				}
			}
		}
		/*
		foreach (scandir($folder) as $key => $value) {
			if(strstr($value, '.') && preg_match('/[a-zA-Z0-9]/', $value) && $value != '.DS_Store') {
				$acPath = getcwd() . $symbol . $folder . $symbol . $value ;
				(strpos($acPath, "$symbol$identity$symbol")) ? array_push($files, $value) : null ;
			} else if(preg_match('/[a-zA-Z0-9]/', $value))
				$files = array_merge($this -> getAllFiles($folder . $symbol . $value), $files);
		}
		*/
		return $files;
	}
	
	public function pathFinder($folder = 'upload') {
		$path = array();
		$identity = $this -> getIdentity();
		$symbol = (preg_match('/Darwin/i', php_uname())) ? '/' : '\\';
		$ignoreType = array('.','..','cgi-bin','.DS_Store');
		foreach (scandir($folder) as $key => $value) {
			if (!in_array($value, $ignoreType)) {
				if(is_dir($folder . $symbol . $value)) {
					$path = array_merge($this -> pathFinder($folder . $symbol . $value), $path);
				} else {
					$acPath = getcwd() . $symbol . $folder . $symbol . $value ;
					(strpos($acPath, "$symbol$identity$symbol")) ? array_push($path, $acPath) : null ;
				}
			}
			/*
			if(strstr($value, '.') && preg_match('/[a-zA-Z0-9]/', $value) && $value != '.DS_Store') {
				$acPath = getcwd() . $symbol . $folder . $symbol . $value ;
				echo 'this is path' . $acPath . "\n";
				//(strpos($acPath, "$symbol$identity$symbol")) ? array_push($path, $acPath) : null ;
			} else if(preg_match('/[a-zA-Z0-9]/', $value)){
				//$path = array_merge($this -> pathFinder($folder . $symbol . $value), $path);
				echo 'this is value'.$value . "\n";
			}*/
		}
		return $path;
	}

	public function formatBytes($size, $precision = 2) {
    	$suffixes = array(' bytes', 'KB', 'MB', 'GB', 'TB');
    	$base = log($size) / log(1024);
    	return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
	}

/*  ----------------------------------------SQL related functions---------------------------------------- */

	public function showStatus($username) {
		$query = 'SELECT ROLE FROM user WHERE USERNAME =\'' . $username . '\'';
		$statement = $this -> database -> prepare($query);
		$statement -> execute();
		$result = $statement -> fetchAll(PDO::FETCH_ASSOC);
		return $result[0]['ROLE'];
	}
	
	public function getAccount($username, $pwd) {
		$query = 'SELECT USERNAME, PWD FROM user WHERE USERNAME =\'' . $username . '\' AND PWD =\'' . $pwd . '\'';
		$statement = $this -> database -> prepare($query);
		if($statement -> execute()) {
			$result = $statement -> fetchAll(PDO::FETCH_ASSOC);
			return $result = (count($result) == 1) ? 'Welcome, ' . $result[0]['USERNAME'] : 'Failed to login';			
		} else
			return FALSE;
	}

	public function addNewAccount($role, $username, $password, $fullname, $phone, $address) {
		$columnArray = array();
		$valueArray = array();
		$this -> role = $role;
		$this -> username = $username;
		$this -> password = $password;
		$this -> fullname = $fullname;
		$this -> phone = $phone;
		$this -> address = $address;
		array_push($columnArray, "ROLE");
		array_push($columnArray, "USERNAME");
		array_push($columnArray, "PWD");
		array_push($columnArray, "FULLNAME");
		array_push($columnArray, "PHONE");
		array_push($columnArray, "ADDRESS");
		array_push($valueArray, $this -> role);
		array_push($valueArray, $this -> username);
		array_push($valueArray, $this -> password);
		array_push($valueArray, $this -> fullname);
		array_push($valueArray, $this -> phone);
		array_push($valueArray, $this -> address);
		$query = $this -> insertSql("user", $columnArray);
		$statement = $this -> database -> prepare($query);
		$statement -> bindParam(1, $valueArray[0]);
		$statement -> bindParam(2, $valueArray[1]);
		$statement -> bindParam(3, $valueArray[2]);
		$statement -> bindParam(4, $valueArray[3]);
		$statement -> bindParam(5, $valueArray[4]);
		$statement -> bindParam(6, $valueArray[5]);
		$statement -> execute();
		return 'Welcome, ' . $this -> username;
	}

	public function insertSql($tableName, $columnArray) {
		$length = 1;
		$this -> tableName = $tableName;
		$columns = $columnArray;
		$query = 'INSERT INTO ' . $tableName . ' (';
		foreach ($columns as $key => $value) {
			if (count($columns) != $length)
				$query = $query . $value . ",";
			else {
				$query = $query . $value . ") VALUES (";
				for ($i = 1; $i <= $length; $i++)
					$query = ($length != $i) ? $query = $query . "?," : $query = $query . '?)';
			}
			$length++;
		}
		return $query;
	}


	public function removeMultiFiles($targetArray) {
			$filtered = array();
			function delItem($index) {
				return (unlink($index)) ? 'Deleted: ' . $index : 'Problem on deleting: ' . $index;
			}
			$alldirname = array_map("strtolower", $this -> pathFinder('upload'));
			foreach ($targetArray as $key => $value)
				(in_array($value, $alldirname)) ? array_push($filtered,$value) : 'Cannot find file in dir.';
			$filtered = array_map("delItem", $filtered);
		   	return $filtered;
	}

	public function shareFiles($from, $resourceArray, $to) {
		$result = array();
		foreach ($resourceArray as $key => $value) {
			$query = 'INSERT INTO sharing (`from`, `sharedFilePath`, `to`) VALUES (\'' . $from . '\',\''.$value.'\',\'' . $to . '\')';
			$statement = $this -> database -> prepare($query);
			$status = ($statement -> execute()) ? 'Success shared: ' . $value : 'Failed sharing: ' . $value ;
			array_push($result, $status);
		}
		return $result;
	}

	public function showSharedFiles($sharedUserRole) {
		$results = array('path' => array(), 'shareId' => array(), 'shareBy' => array());
		$query = 'SELECT `from`, `sharedFilePath`, `share_id` FROM sharing WHERE `to` = \''. $sharedUserRole .'\'';
		$statement = $this -> database -> prepare($query);
		$result = ($statement -> execute()) ? $statement -> fetchAll(PDO::FETCH_ASSOC) : 'Failed on result.';
		foreach ($result as $key => $value){
			array_push($results['path'], $value['sharedFilePath']);
			array_push($results['shareId'], $value['share_id']);
			array_push($results['shareBy'], $value['from']);
		}
		return $results;
	}

	public function unShareFiles($fileID, $userRole){
		echo "get into unShareFiles";
		$result = array();
		foreach($fileID as $key => $value) {
		$query = 'DELETE FROM sharing where `share_id` =\''.$value.'\' AND `to` = \''.$userRole.'\'';
		$statement = $this -> database -> prepare($query);
		$status = ($statement -> execute()) ? 'Successfully to unshare: ' . $value : 'Failed to unshare: ' . $value;
		array_push($result, $status);
		//DELETE FROM sharing WHERE `from` = from AND `sharedFilePath` = sharedFilePath AND `to` = to
		}
		return $result;
	}
}
	
?>