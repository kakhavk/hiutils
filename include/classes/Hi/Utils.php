<?php
/*
* Created by Kakhaber Kashmadze
@version 0.3
@license MIT
*/

namespace Hi;

class Utils{

    /* Parameters to use in functions */
    private static $params=array(
        'htmlspecialchars_decode'=>true,
        'stripslashes'=>true,
        'addslashes'=>true,
        'htmlspecialchars'=>true
    );
    
    /* Set or change value of one or more parameters */
    public static function setParams($params){
        if(!empty($params) && is_array($params) && count($params)!=0){
            foreach($params as $key => $value){
                self::$params[$key]=$value;
            }
        }
    }
    /* Set or change value of one parameter */
    public static function setParam($key, $value){
        if(!empty($key)) self::$params[$key]=$value;
    }
    
    /* Decode string by which encoded by function encode  */
    public static function decode($str){
        if(!empty($str)){
            if(self::$params['stripslashes']===true) $str=stripslashes($str);
            if(self::$params['htmlspecialchars_decode']===true)	$str = htmlspecialchars_decode($str);
            
            return trim($str);
        }
        return null;
    }
    
    /* Encode string */
    public static function encode($str) {
        
        if(!empty($str)) {
            
            if(self::$params['htmlspecialchars']===true) $str = htmlspecialchars($str);
            if(self::$params['addslashes']===true) $str=addslashes($str);
            
            return trim($str);
        }
        return NULL;
    }
    
    /* Parse value and return custom or default value */
    public static function parseValue($value, $options=array()){
        
        $valueType='string';
        $defaultValue=null;
        
        if(!is_array($options)) $options=(array) $options;
        
        if(isset($value)){
            $value=trim($value);
            if(empty($value)){
                $value=null;
            }
        }
        
        if(isset($options['type'])){
            $valueType=$options['type'];
        }
        
        if(isset($options['defaultValue'])){
            $defaultValue=$options['defaultValue'];
        }
        
        if(isset($options['nozero']) && $options['nozero']===true && ($value==='0' || $value==='0.00')){
            return $defaultValue;
        }
        
        if($valueType=='string'){
            if(isset($value)){
                if(self::$params['htmlspecialchars']===true){
                    $value=htmlspecialchars($value);
                }
                
                if(self::$params['addslashes']===true){
                    $value=addslashes($value);
                }
                
                return $value;
            }
        }elseif($valueType=='int'){            
            if(isset($value) && ctype_digit((string)$value)){
                return (int)$value;
            }            
        }elseif($valueType=='double'){
            if(isset($value) && is_double($value)){
                return $value;
            }
        }
        
        return $defaultValue;
    }
    
    /* Check type of request value and return true if condition is true */
    public static function requestType($req, $type){
        if($type=='string'){
            if(!empty($_REQUEST[$req])) return true;
        }elseif($type=='int'){
            if(!empty($_REQUEST[$req]) && intval($_REQUEST[$req]) != 0) return true;
        }elseif($type=='double'){
            if(!empty($_REQUEST[$req]) && doubleval(str_replace(',', '.', $_REQUEST[$req])) != 0) return true;
        }
        return false;
    }
    /* Return random string value */
    public static function randChars($charlength){
        
        $chars = '123456789abcdfghjkmnpqrstvwxyz';
        $ret = "";
        $randStr = "";
        $i = 0;
        
        while($i < $charlength){
            $randStr = mt_rand(0, strlen($chars) - 1);
            $ret .= substr($chars, $randStr, 1);
            $i++;
        }
        
        return $ret;
    }
    
    /* Check value by key in array  */
    public static function checkInArray($check, $chckVal, $id = "id"){
        $checkCnt = count($check);
        for($i = 0; $i < $checkCnt; $i++){
            if($check[$i][$id] == $chckVal) return 1;
        }
        return 0;
    }
    
    /* Download file instead opening to browser: usefull when file is txt or You dont want change page when download processed */
    public static function downloadFile($file, $fileName, $ctype) {
        if (file_exists($file)) {
            if(ob_get_level()!==0) ob_clean();
            header('Content-Description: File Transfer');
            header('Content-Type: '.$ctype.'');
            header('Content-Length: ' . filesize($file));
            header('Content-Disposition: attachment; filename=' . $fileName);
            readfile($file);
            unlink($file);
            exit;
        }
    }
    
    /* Check what request method is POST, GET ... */
    public static function requestMethod(){
        if(!empty($_SERVER['REQUEST_METHOD'])) return strtoupper($_SERVER['REQUEST_METHOD']);
        return null;
    }
    
    /* Unlike standart empty function isEmpty also assigns true if value contains whitespaces, newlines, tabs */
    public static function isEmpty(&$value){
        if(empty($value) || (!is_array($value) && !is_object($value) && trim($value)=="")) return true;
        return false;
    }
    
    /* alternative of var_dump with pre or json formating */
    function vardump($var, $task=null){
        if(!empty($task)){
            if($task=='pre'){
                echo '<div><pre>';
                var_dump($var);
                echo '</pre></div>';
            }elseif($task=='json'){
                $json = json_encode((array)$var );
                echo($json);
            }
        }else{
            var_dump($var);
        }
    }
}

?>
