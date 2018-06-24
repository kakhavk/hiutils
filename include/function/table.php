<?php
/*
  Created by Kakhaber Kashmadze
  @version 0.1
  @license MIT
*/

function generateKeys($fields){
    $i=1;
    foreach(array_keys($fields) as $k => $v){
        echo '\''.$v.'\'=>null';
        if($i!=count($fields)){
            echo ',';
        }
        echo '<br>';
        $i++;
    }
}
