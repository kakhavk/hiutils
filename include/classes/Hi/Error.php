<?php
/*
* Created by Kakhaber Kashmadze
@version 0.2
@license MIT
*/
namespace Hi;

use Hi\Utils;

class Error{

    private static $error=false;
    private static $message=array();
    
    public static function setMessage($text, $status){
        if(!empty($text)){
            self::$message=array();
            self::$message[0]=Utils::encode($text);
        }
        if($status!==false){
            self::$error=true;
        }
    }
    
    public static function addMessage($text, $status){
        if(!empty($text)){
            self::$message[]=Utils::encode($text);
        }
        if($status!==false && self::$error!==true){
            self::$error=true;
        }
    }
    
    public static function getMessage(){
        return self::$message;
    }
    
    public static function setError($status){
        self::$error=$status;
    }
    
    public static function getError(){
        return self::$error;
    }
    
    public static function showMessage($formatted){
        $message=null;
        if($formatted===false){
            $message="";                 
            for($i=0; $i<count(self::$message); $i++){
                $message.=Utils::decode(self::$message[$i])."\n";
            }            
        }else{
            $message="<ul class=\"alert alert-danger\">";
            for($i=0; $i<count(self::$message); $i++){
                $message.="<li>".Utils::decode(self::$message[$i])."</li>";
            }
            $message.="</ul>";
        }
        
        return $message;
    }

}
