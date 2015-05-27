<?php
class ScalingModel {

	private $currentLevel = 1;

	private $levelFormat = array(
			'Level' => null,
			'Max_User' => null,
			'System_Space' => null,
			'Used_Space' => null,
			'Block_Space' => null,
			'Level_Space' => null,

			'Expend_Level' => null,
			'Expend_Max_User' => null,
			'Expend_System_Space' => null,
			'Expend_Level_Space' => null,

	);

	public function getLevelFormat() {
		return $this -> levelFormat;
	}

	public function getCurrentLevel() {
		return $this -> currentLevel;
	}

	public function setCurrentLevel($level) {
		$this -> currentLevel = $level;
	}

	public function levelOne() {
		$level = $this -> getLevelFormat();
		$level['Level'] = 1;
		$level['Max_User'] = 1;
		$level['System_Space'] = 10485760;
		$level['Used_Space'] = 0;
		$level['Block_Space'] = 10485760;
		$level['Level_Space'] = 41943040;

		$level['Expend_Level'] = 2;
		$level['Expend_Max_User'] = 2;
		$level['Expend_System_Space'] = 20971520;
		$level['Expend_Level_Space'] = 94371840;
	}

	public function createLevelVector($userArray, $levelArray) {
		$level = $this -> getLevelFormat();
		//$userNumber = count($userArray);
		$userNumber = 5;
		foreach ($levelArray as $key => $value) {
			if ($userNumber === $value) {
				$level['Level'] = array_search($value, $levelArray);
				$level['Max_User'] = $value;
				break;
			} elseif($userNumber < $value) {
				$level['Level'] = array_search($value, $levelArray);
				$level['Max_User'] = $value;
				break;
			}
		}
		
		$tmpArray = array();
		$starts = 1;
		for ($i = 1; $i <= count($levelArray) ; $i++) {
			$starts += 2;
			$tmpArray[$i] = $starts;
		}

		$level['System_Space'] = ($level['Level'] - 1) * 10485760;
		$level['Used_Space'] = ($userNumber * 10485760) * 2;
		$level['Block_Space'] = 10485760;
		
		echo $tmpArray[array_search($level['Max_User'], $levelArray)] . "\n";
		print_r($level);
	}

	public function getSequence($n) {		//Generate the number of users 
		$seq = array();
		for ($i = 1; $i < $n + 1 ; $i++)
			$seq[$i] = $this -> genSequence($i);
		return $seq;
	}

	public function genSequence($n) {
		if($n === 0) {
			return $n;
		} elseif($n === 1 OR $n === 2){
			return $n;
		} elseif($n > 2) {
			return $n-1 + $this -> genSequence($n-1);
		}
	}

	public function fib($n) {
		static $cache;
		if ($n < 0) {
			return NULL;
		} elseif ($n === 0) {
			return 0;
		} elseif ($n === 1 || $n === 2) {
			return 1;
		} else {
			if (!(!is_null($cache) && array_key_exists($n, $cache)))
				$cache[$n] = $this -> fib($n - 1) + $this -> fib($n - 2);
			return $cache[$n];
		} 	
	}
}
?>