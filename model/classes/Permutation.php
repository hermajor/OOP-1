<?php
namespace model\classes;

class Permutation
{
	private $iter = 0;// iterator
	private $tempStr = '';
	private $tempArr = array();
	
	public function getPlacement($str, $len)
	{
		for ($j = 0; $j < strlen($str); $j++) {
			for ($i = 0; $i < strlen($str); $i++) {
				if ($i == $this->iter){
					continue;
				}
				$this->tempArr[] = $str[$this->iter].$str[$i];
			}
			$this->iter++;
		}
		return $this->tempArr;
	}
	
//Считает кол-во возможных размещений
	public function getCountPlacement($str)
	{
		$x = strlen($str);

		function factorial($x) {
			if ($x === 0){
				return 1;
			} else {
				return $x*factorial($x-1);
			}
		}
		return factorial($x);
	}
	
}