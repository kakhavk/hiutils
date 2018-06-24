<?php
/*
  Created by Kakhaber Kashmadze
  @version 0.1
  @license MIT
*/

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
