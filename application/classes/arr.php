<?php

    class Arr extends Kohana_Arr {
        public static function in_array($value, $array){
            foreach ($array as $val) {
              if(is_array($val)){
                if(self::in_array($value, $val))
                  return true;
              }
              else{
                if($val == $value)
                  return true;
              }
            }
            return false;
          }
    }

?>
