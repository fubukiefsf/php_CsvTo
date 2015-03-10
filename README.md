#trait CsvTo.php

trait to read csv file, and to convert into array and json.

php5.4 <=

**usage**
     
    <?php  
    require_once('CsvTo.php');  
    class A{  
        use CsvTo;  
        public function someFiles($dir){  
            $this -> csvFilesTo($dir,'SJIS','UTF-8','toMap');  
        }  
        public function someFile($dir,$fileName){  
            /*toArray*/
            $this -> toArray($dir,$csvFileName,'SJIS','UTF-8');
            
            /*toMap*/
            // $this -> toMap($dir,$csvFileName,'SJIS','UTF-8');
            
            /*toJson*/
            // $this -> toJson($dir,$csvFileName,'SJIS','UTF-8');
        }  
    }  
     

