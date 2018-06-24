<?php
/*
 * Created by Kakhaber Kashmadze
  @version 0.1
  @license MIT
*/

namespace Hi;

use Shared\Request;

class Tree{
   public $tree=array(
        'row'=>array(),
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
            'row'=>array(),
            'items'=>array(
                'padding-left'=>10,
                'padding-increment'=>10,
                'repeat'=>0,
                'increment'=>5
            )
        );
    }
    
	public function generateTree($rows, $parentid, $params=array()){

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
        
        
        for($i=0; $i<count($rows); $i++){
            
            if($rows[$i]['parentid']==$parentid){
                
                
                if(isset($paramsLocal['fields']['active']) && $paramsLocal['fields']['active']===true){
                    if($rows[$i]['active']===false){
                        continue;
                    }
                }
                
                if(!empty($paramsLocal['fields']['id_not_in'])){
                    if(in_array($rows[$i]['id'], $paramsLocal['fields']['id_not_in'])){
                        continue;
                    }
                }
                
                
                if($paramsLocal['type']=='table'){
                    $this->tree['row'][]='<a name="'.$rows[$i]['id'].'"></a><div class="div-table-row'.((Request::exists('id', 'int')===true && Request::query('id')==$rows[$i]['id'])?' bg-active':'').'">
                                <div class="div-table-col name-column'.(($rows[$i]['includeitem']==1)?' bold title-bg':'').'" style="padding-left:'.$this->tree['items']['padding-left'].'px;">
                                    <a href="">'.$rows[$i]['name'].'</a>
                                    '.(($rows[$i]['includeitem']==1)?'<a href="'.HTTP_HOST.'/category/edit/p/'.$rows[$i]['id'].'" class="right"><span class="fa fa-file"></span></a>':'').'
                                </div>
                            </div>';
                }elseif($paramsLocal['type']=='select'){
                    $increment=$this->tree['items']['increment'];
                    $incrementType='repeat';
                    
                    $this->tree['row'][]='<option value="'.$rows[$i]['id'].'"'.((isset($paramsLocal['fields']['parentid']) && $paramsLocal['fields']['parentid']==$rows[$i]['id'])?' selected':'').''.((isset($paramsLocal['fields']['disableParent']) && $paramsLocal['fields']['disableParent']===true && $rows[$i]['includeitem']===true)?' disabled="disabled"':'').'>'.str_repeat('&nbsp;', $this->tree['items']['repeat']).$rows[$i]['name'].'</option>';
                }elseif($paramsLocal['type']=='array'){
                    $this->tree['row'][]=$rows[$i];
                }
                
                if($paramsLocal['type']=='array'){
                    $this->generateTree($rows, $rows[$i]['id'], $paramsLocal);
                }else{
                    $this->tree['items'][$incrementType]+=$increment;
                    $this->generateTree($rows, $rows[$i]['id'], $paramsLocal);
                    $this->tree['items'][$incrementType]-=$increment;
                }
            }
        }
    }
    
    public function getTree($rows, $parentid, $params=array()){
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
        
        $this->generateTree($rows, $parentid, $paramsLocal);
        $tree=$this->tree;
        
        if($unsetTree===true){
            $this->resetTree();
        }
        
        return $tree;

    }
}
