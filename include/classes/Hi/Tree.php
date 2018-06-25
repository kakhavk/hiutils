<?php
/*
 * Created by Kakhaber Kashmadze
  @version 0.3
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
            'actionType'=>null,
            'fields'=>array(
                'parentid'=>null,
                'active'=>null,
                'id_not_in'=>array()
            ),
            'permission'=>array(
                'edit'=>true,
                'delete'=>false
            )
        );
        if(isset($params['type'])){
            $paramsLocal['type']=$params['type'];
        }
        
        if(isset($params['fields'])){
            foreach ($paramsLocal['fields'] as $k => $v){
                if(isset($params['fields'][$k])){
                    $paramsLocal['fields'][$k]=$params['fields'][$k];
                }
            }
        }
        
        
        if(isset($params['permission'])){
            foreach ($paramsLocal['permission'] as $k => $v){
                if(isset($params['permission'][$k])){
                    $paramsLocal['permission'][$k]=$params['permission'][$k];
                }
            }
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
                
                $tableRowClass='div-table-row';
                $tableColumnClass='div-table-col';
                $editUrl="#";
                
                if($paramsLocal['type']=='table'){
                
					if(isset($paramsLocal['actionType'])){

                        if($paramsLocal['actionType']=='category'){
                            $tableRowClass='div-table-row';
                            $tableColumnClass='div-table-col name-column';
                            if($paramsLocal['permission']['edit']===true){
                                $editUrl='http://....editUrlhere';
                            }
                            
                        }elseif($paramsLocal['actionType']=='menu'){
                            
                            $tableRowClass='div-table-menu-row';
                            $tableColumnClass='div-table-menu-col name-column';
                            
                            if($paramsLocal['permission']['edit']===true){
                                $editUrl='http://....editUrlhere';
                            }
                        }
                    }
                
                    $this->tree['data'][]='<div class="'.$tableRowClass.'">
                                <div class="'.$tableColumnClass.'" style="padding-left:'.$this->tree['items']['padding-left'].'px;">'.$data[$i]['name'].'</div>
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

        if(isset($params['unsetTree'])){
            $unsetTree=$params['unsetTree'];
        }
        
        $this->generateTree($data, $parentid, $params);
        $tree=$this->tree;
        
        if($unsetTree===true){
            $this->resetTree();
        }
        
        return $tree;

    }
}
