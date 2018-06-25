<?php
/*
 * Created by Kakhaber Kashmadze
  @version 0.2
  @license MIT
*/

use Hi\Request;

class Tree{
   public $tree=array(
        'data'=>array(),
        'items'=>array(
            'padding-left'=>10,
            'padding-increment'=>10,
            'repeat'=>0,
            'increment'=>5
        )
    );
    
    function __construct(){}
    
    public function resetTree(){
        $this->tree=array(
            'data'=>array(),
            'items'=>array(
                'padding-left'=>10,
                'padding-increment'=>10,
                'repeat'=>0,
                'increment'=>5
            )
        );
    }
    
	public function generateTree($data, $parentid, $params=array()){

        $incrementType='padding-left';
        $increment=$this->tree['items']['padding-increment'];
        
        $paramsLocal=array(
            'type'=>'table',
            'fields'=>array(
                'parentid'=>null,
                'active'=>null,
                'id_not_in'=>array()
            )
        );
        if(isset($params['type'])){
            $paramsLocal['type']=$params['type'];
        }
        
        if(isset($params['fields']['parentid'])){
            $paramsLocal['fields']['parentid']=$params['fields']['parentid'];
        }
        
        if(isset($params['fields']['active'])){
            $paramsLocal['fields']['active']=$params['fields']['active'];
        }
        
        if(isset($params['fields']['id_not_in'])){
            $paramsLocal['fields']['id_not_in']=$params['fields']['id_not_in'];
        }
        
        if(isset($params['fields']['disableParent'])){
            $paramsLocal['fields']['disableParent']=$params['fields']['disableParent'];
        }
        
        
        for($i=0; $i<count($data); $i++){
            
            if($data[$i]['parentid']==$parentid){
                
                
                if(isset($paramsLocal['fields']['active']) && $paramsLocal['fields']['active']===true){
                    if($data[$i]['active']===false){
                        continue;
                    }
                }
                
                if(!empty($paramsLocal['fields']['id_not_in'])){
                    if(in_array($data[$i]['id'], $paramsLocal['fields']['id_not_in'])){
                        continue;
                    }
                }
                
                
                if($paramsLocal['type']=='table'){
                    $this->tree['data'][]='<div class="div-table-row">
                                <div class="div-table-col" style="padding-left:'.$this->tree['items']['padding-left'].'px;">'.$data[$i]['name'].'</div>
                            </div>';
                }elseif($paramsLocal['type']=='select'){
                    $increment=$this->tree['items']['increment'];
                    $incrementType='repeat';
                    
                    $this->tree['data'][]='<option value="'.$data[$i]['id'].'"'.((isset($paramsLocal['fields']['parentid']) && $paramsLocal['fields']['parentid']==$data[$i]['id'])?' selected':'').''.((isset($paramsLocal['fields']['disableParent']) && $paramsLocal['fields']['disableParent']===true && $data[$i]['includeitem']===true)?' disabled="disabled"':'').'>'.str_repeat('&nbsp;', $this->tree['items']['repeat']).$data[$i]['name'].'</option>';
                }elseif($paramsLocal['type']=='array'){
                    $this->tree['data'][]=$data[$i];
                }
                
                if($paramsLocal['type']=='array'){
                    $this->generateTree($data, $data[$i]['id'], $paramsLocal);
                }else{
                    $this->tree['items'][$incrementType]+=$increment;
                    $this->generateTree($data, $data[$i]['id'], $paramsLocal);
                    $this->tree['items'][$incrementType]-=$increment;
                }
            }
        }
    }
    
    public function getTree($data, $parentid, $params=array()){
        $tree=array();
        $unsetTree=true;
        $paramsLocal=array(
            'type'=>'array',
            'fields'=>array(
                'parentid'=>null,
                'active'=>null,
                'id_not_in'=>array(),
                'disableParent'=>false
            )
        );
        
        if(isset($params['unsetTree'])){
            $unsetTree=$params['unsetTree'];
        }
        
        if(isset($params['type'])){
            $paramsLocal['type']=$params['type'];
        }
        
        if(isset($params['fields']['parentid'])){
            $paramsLocal['fields']['parentid']=$params['fields']['parentid'];
        }
        
        if(isset($params['fields']['active'])){
            $paramsLocal['fields']['active']=$params['fields']['active'];
        }
        
        if(isset($params['fields']['id_not_in'])){
            $paramsLocal['fields']['id_not_in']=$params['fields']['id_not_in'];
        }
        
        if(isset($params['fields']['disableParent'])){
            $paramsLocal['fields']['disableParent']=$params['fields']['disableParent'];
        }
        
        $this->generateTree($data, $parentid, $paramsLocal);
        $tree=$this->tree;
        
        if($unsetTree===true){
            $this->resetTree();
        }
        
        return $tree;

    }
}
