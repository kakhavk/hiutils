<?php
/*
* Created by Kakhaber Kashmadze
@version 0.1
@license MIT

alternative of php functions
*/


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
