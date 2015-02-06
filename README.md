#trait CsvTo.php

trait to read csv file, and to convert into array and json.

php5.4 <=

##usage
``  
<?php   
require_once('CsvTo.php');  
class A{  
	use CsvTo;  
	public function someFiles($dir){  
		$this -> csvFilesToArray($dir,'SJIS','UTF-8');  
	}  
	public function someFile($dir,$fileName){  
		$this -> csvFilesToArray($dir,$csvFileName,'SJIS','UTF-8');  
	}  
}  
``  

##ToDo
toMap
