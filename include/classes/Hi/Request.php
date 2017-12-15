<?php
/*
* Created by Kakhaber Kashmadze
@version 0.1
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
			if(ctype_digit((string)$item)===true){
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
}
