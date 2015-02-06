<?php

/**
 * CsvTo
 * 
 * @version v0.0.1
 * @copyright 2015  fubukiefsf 
 * @author fubukiefsf 
 * @License The MIT License (MIT)
 */
trait CsvTo{
	/**
	 * csvFilesToArray 
	 * 
	 * @param string $dir  
	 * @param string $baseEncoding 
	 * @param string $toEncoding 
	 * @access protected
	 * @return array
	 */
	protected function csvFilesToArray($dir='',$baseEncoding='sjis-win',$toEncoding='UTF-8'){
		if(empty($dir)){return ['false'];}
		if(empty($csvFileName)){
			$fileNames = scandir($dir);
			foreach ($fileNames as $fileName) {
				if(preg_match('/\.csv$/i',$fileName)===false){continue;}
				$csvs[$fileName] = $this->toArray($dir,$fileName,$baseEncoding,$toEncoding);
			}
		}
		return $csvs;
	}
	/**
	 * toArray 
	 * 
	 * @param string $dir 
	 * @param string $fileName 
	 * @param string $baseEncoding 
	 * @param string $toEncoding 
	 * @access protected
	 * @return array
	 */
	protected function toArray($dir='',$fileName='',$baseEncoding='sjis-win',$toEncoding='UTF-8'){
		$fileData = file_get_contents(($dir.'/'.$fileName));
		$fileData = mb_convert_encoding($fileData,$toEncoding,$baseEncoding);
		$tmp = tmpfile();
		$meta = stream_get_meta_data($tmp);
		fwrite($tmp,$fileData);
		rewind($tmp);
		$data = new SplFIleObject($meta['uri']);
		foreach ($data as $line) {
			$csv[] = $line;
		}
		fclose($tmp);
		return $csv;
	}
	/**
	 * toJson 
	 * 
	 * @param string $dir 
	 * @param string $fileName 
	 * @param string $baseEncoding 
	 * @param string $toEncoding 
	 * @access protected
	 * @return json
	 */
	protected function toJson($dir='',$fileName='',$baseEncoding='sjis-win',$toEncoding='UTF-8'){
		return json_encode($this->toMap($dir,$fileName,$baseEncoding,$toEncoding));
	}
}
