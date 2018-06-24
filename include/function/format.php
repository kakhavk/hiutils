<?php
/*
  Created by Kakhaber Kashmadze
  @version 0.1
  @license MIT
*/

use Hi\Utils;

function var_dump_pre($variable){
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
}



function showModalHtml($params=array()){
    $status=false;
    
    
    $id="main-modal";
    
    $title="Dialog";
    $titleDescription=null;
    $message=null;
    
    if(!empty($params) && is_array($params)){
        if(isset($params['status']) && is_bool($params['status'])){
            $status=$params['status'];
        }
        
        if(Utils::isEmpty($params['id'])===false){
            $id=trim($params['id']);
        }
        
        if(Utils::isEmpty($params['title'])===false){
            $title=trim($params['title']);
        }
        
        if(Utils::isEmpty($params['message'])===false){
            $message=trim($params['message']);
        }
    }
    
    if($status===true){
        echo "
        <div class=\"modal fade\" id=\"".$id."\" tabindex=\"-1\" role=\"dialog\">
        	<div class=\"modal-dialog\" role=\"document\">
        		<div class=\"modal-content\">
        			<div class=\"modal-header\">
        				<button type=\"button\" class=\"close dialog-close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hdden=\"true\">&times;</span></button>
        				<div id=\"".$id."-title\" class=\"bold\">".$title."</div>
                        <div id=\"".$id."-title-description\">".(isset($titleDescription)?$titleDescription:"")."</div>
                    </div>
        			<div class=\"modal-body\">
        				<p>".(!is_null($message)?$message:"")."</p>
        			</div>
        			<div class=\"modal-footer\">
        				<button type=\"button\" id=\"".$id."-close-button\" class=\"btn btn-default dialog-close\" data-dismiss=\"modal\">დახურე</button>
        			</div>
        		</div>
        	</div>
        </div>";
    }    
}


function fillWithSymbols($symbol, $number, $heystack){
    
    if(strlen($heystack)<$number){
        $number=$number-strlen($heystack);
    }

    return str_repeat($symbol, $number).$heystack;
}
