<?php
/*
 * Created by Kakhaber Kashmadze
  @version 0.1
  @license MIT
*/

namespace Hi;

class Form{
    
    public static function parseRequestFields($fields, $params=array()){
        
        $values=array();
        $errorValue=null;
        
        foreach($fields as $k => $v){
            
            if(isset($params['ignore_fields']) && in_array($k, $params['ignore_fields'])){
                continue;
            }
            
            if(Request::exists($k, 'int')===true && isset($v['request_type']) && $v['request_type']=='double'){
                Request::setValue($k, Request::query($k).'.00');
            }
            
            if(Request::exists($k, $v['request_type'])===true){
                if($v['request_type']=='int' && isset($v['type']) && $v['type']=='boolean'){
                    $values[$k]=int2bool(Request::query($k));                    
                }else{                    
                    $values[$k]=Request::query($k);
                }
            }else{
                if(isset($v['required']) && $v['required']===true){
                    if(isset($v['title'])){
                        $errorValue=$v['title'];
                    }else{
                        $errorValue=$k;
                    }
                    
                    Error::addMessage('<strong>'.$errorValue.'</strong> არ არის მითითებული', true);
                }
            }
            
            if(!isset($values[$k]) && !isset($params['skip_assign'])){                
                if(isset($fields[$k]['default_value'])){
                    $values[$k]=$fields[$k]['default_value'];
                }else{
                    $values[$k]=null;
                }
            }
        }
        
        return $values;
    }
}
