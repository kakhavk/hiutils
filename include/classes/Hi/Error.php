<?php
/*
* Created by Kakhaber Kashmadze
@version 0.1
@license MIT
*/
namespace Hi;

class Error{

    private static $error=false;
    private static $message=array();
    
    public static function setMessage($text, $status){
        if(!empty($text)){
            self::$message=array();
            self::$message[0]=Utils::encode($text);
        }
        if($status!==false && $status!==true){
            self::$error=true;
        }
    }
    
    public static function addMessage($text, $status){
        if(!empty($text)){
            self::$message[]=Utils::encode($text);;
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
    
    public function showMessage($formatted){
        $message=null;
        if($formatted!==true){
            $message="";                 
            for($i=0; $i<count(self::$message); $i++){
                $message.=Utils::decode(self::$message[$i])."\n";
            }            
        }else{
            $message="<ul>";
            for($i=0; $i<count(self::$message); $i++){
                $message.="<li>".Utils::decode(self::$message[$i])."</li>";
            }
            $message.="</ul>";
        }
        
        return $message;
    }

}
