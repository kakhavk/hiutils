<?php
/*
* Created by Kakhaber Kashmadze
@version 0.5
@license MIT
*/

namespace Hi;


class Request{

    
    private static $request=array();
    
    public static function setRequest($request){
        if(!empty($request) && is_array($request)){
            self::$request=self::parse($request);
        }else{
            self::$request=array();
        }
    }
    
    public static function getRequest(){
        return self::$request;
    }
    
    public static function query($name, $params=array()){
        $item=null;
        $allowZero=false;
        if(isset($params['allowzero'])){
            $allowZero=$params['allowzero'];
        }
        if(isset(self::$request[$name])){
            $item=trim(self::$request[$name]);
            
            if($allowZero===false){
                if($item=="0"){
                    return null;
                }
            }
            return trim(self::$request[$name]);
        }
        return null;
    }
    
    private static function parse($request){
        $items=array();
        if(!empty($request) && is_array($request)){
            foreach($request as $k => $v){
                if(!is_null($v) && trim($v)!==""){
                    $items[$k]=trim($v);
                }
            }
        }
        return $items;
    }
    
    public static function isInt($name){
        $item=null;
        if(isset(self::$request[$name])){
            $item=self::$request[$name];

            if(isset($item) && is_int((int)$item)===true && ctype_digit((string)str_replace('-','', $item))===true){
                return true;
            }
        }
        return false;
    }
    
    public static function isDouble($name){
        $item=null;
        $itemExplode=array();
        
        if(isset(self::$request[$name])){
            $item=str_replace(',','.',self::$request[$name]);
            $itemExplode=explode('.',$item);
            
            if(count($itemExplode)==1){
                return false;
            }
            
            for($i=0; $i<count($itemExplode); $i++){
                if(ctype_digit((string)$itemExplode[$i])===false){
                    return false;
                }
            }
            
            return true;
        }
        return false;
    }
    
    public static function isString($name){
        $item=null;
        if(isset(self::$request[$name])){
            $item=self::$request[$name];
            
            if(is_numeric($item)){
                return false;
            }elseif(self::isInt($name)===true || self::isDouble($name)===true){
                return false;
            }
            return true;
        }
        return false;
    }
    
    public static function isEmail($name){
        if(isset(self::$request[$name]) && self::isString(isset(self::$request[$name]))){
            if(filter_var($request[$name], FILTER_VALIDATE_EMAIL)===true){
                return true;
            }
        }
        return false;
    }
    public static function exists($name, $type){
        $item=null;
        if(isset(self::$request[$name])){
            if(!is_null($type)){
                switch($type){
                    case 'int':
                        return self::isInt($name);
                    case 'double':
                        return self::isDouble($name);
                    case 'alnum':
                        return ctype_alnum((string)$name);
                    case 'alpha':
                        return ctype_alpha((string)$name);
                    case 'string':
                        return true;
                }
                return false;
            }
            return true;
        }
        return false;
    }
    
    public static function setValue($name, $value){
        if(isset(self::$request[$name])){
            self::$request[$name]=$value;
        }
    }
}
