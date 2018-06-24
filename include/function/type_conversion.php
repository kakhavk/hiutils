<?php
function int2bool($value){
    if(isset($value) && ctype_digit((string)$value)===true){
        if($value==1){
            return true;
        }
    }
    return false;
}

function char2bool($value){
    if(isset($value) && (string)$value=='t'){
        return true;
    }
    return false;
}


function value2bool($value){
    if(isset($value)){
        if(is_numeric($value)){
            return int2bool($value);
        }else{
            return char2bool($value);
        }
    }
    return false;
}

function bool2char($value){
    if(isset($value) && is_bool($value)){
        if($value===true){
            return 'f';
        }
    }
    return 'f';
}

function bool2int($value){
    if(isset($value) && is_bool($value)){
        if($value===true){
            return 1;
        }
    }
    return 0;
}