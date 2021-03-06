<?php

/**
 * CsvTo
 * 
 * @version v0.0.2
 * @copyright 2015  fubukiefsf 
 * @author fubukiefsf 
 * @License The MIT License (MIT)
 */
trait CsvTo{
	/**
	 * csvFilesTo
	 * 
	 * @param string $dir  
	 * @param string $baseEncoding 
	 * @param string $toEncoding 
	 * @param string $mode (toArray,toJson or toMap)
	 * @access protected
	 * @return array
	 */
	protected function csvFilesTo($dir='',$baseEncoding='auto',$toEncoding='UTF-8',$mode='toArray'){
		if(empty($dir)){return ['false'];}
		if(empty($csvFileName)){
			$fileNames = scandir($dir);
			foreach ($fileNames as $fileName) {
				if((bool)preg_match('/\.csv$/i',$fileName)===false){continue;}
				$csvs[$fileName] = $this->$mode($dir,$fileName,$baseEncoding,$toEncoding);
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
	protected function toArray($dir='',$fileName='',$baseEncoding='auto',$toEncoding='UTF-8'){
		$fileData = mb_convert_encoding(file_get_contents(($dir.'/'.$fileName)),$toEncoding,$baseEncoding);
		$tmp = tmpfile();
		$meta = stream_get_meta_data($tmp);
		fwrite($tmp,$fileData);
		rewind($tmp);
		$data = new SplFIleObject($meta['uri']);
		foreach ($data as $line) {
			$line = explode(",",$line);
			foreach ($line as $ln) {
				preg_match('/"(.*?)"/',$ln,$matches);
				if(empty($matches[1])){
					$lns[] ="";
					continue;
				}
				$lns[] = $matches[1];
			}
			$csv[] = $lns;
			unset($lns);
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
	protected function toJson($dir='',$fileName='',$baseEncoding='auto',$toEncoding='UTF-8'){
		return json_encode($this->toMap($dir,$fileName,$baseEncoding,$toEncoding));
	}
	/**
	 * toHashMap 
	 * 
	 * @param string $dir 
	 * @param string $fileName 
	 * @param string $baseEncoding 
	 * @param string $toEncoding 
	 * @access protected
	 * @return hashmap
	 */
	protected function toMap($dir='',$fileName='',$baseEncoding='auto',$toEncoding='UTF-8'){
		$arrays = $this -> toArray($dir,$fileName,$baseEncoding,$toEncoding);
		foreach ($arrays as $line) {
			$i =0;
			foreach ($line as $ln) {
				$map[$arrays[0][$i]] = $ln;
				$i++;
			}
			unset($i);
			$maps[] = $map;
			unset($map);
		}
		return $maps;
	}

}
