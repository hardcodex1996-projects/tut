<?php
class Funcs{
   public function  __construct(){
      //   echo "it works";
   }

   public static function get_data($file_name){
       $data = file_get_contents(STORAGE_PATH . $file_name);
       return $data;
   }
}
