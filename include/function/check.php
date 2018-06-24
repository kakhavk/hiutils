<?php
/*
  Created by Kakhaber Kashmadze
  @version 0.1
  @license MIT
*/

function isMobile(){
    $userAgent=null;
    
    if(isset($_SERVER) && isset($_SERVER['HTTP_USER_AGENT'])){
        $userAgent=trim(strtolower($_SERVER['HTTP_USER_AGENT']));
        
        if(strstr($userAgent, 'android') || strstr($userAgent, 'iphone')){
            return true;
        }
    }
    
    return false;
}

