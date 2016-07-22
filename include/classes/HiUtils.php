<?php
/*
 * Created by Kakhaber Kashmadze
 */

class HiUtils{

    function decodeStr($str, $options=array()){
        if(trim($str) !== ""){
            if(isset($options['stripslashes']) && $options['stripslashes']===true)
				$str = stripslashes($str);
			if(isset($options['htmlspecialchars_decode']) && $options['htmlspecialchars_decode']===true)
				$str = htmlspecialchars_decode($str);
            
            return trim($str);
        }
        return null;
    }

    function encodeStr($str, $options=array()) {

        $str=trim($str);
        if($str!=="") {
            
			if(isset($options['addslashes']) && $options['addslashes']===true)
				$str = addslashes($str);
			if(isset($options['htmlspecialchars']) && $options['htmlspecialchars']===true)
				$str = htmlspecialchars($str);
				
            return $str;
        }
        return NULL;
    }
    
   
    function parseValue($value, $options=array()){
    
		$valueType='string';
		$defaultValue=null;
		if(!is_array($options)) $options=(array) $options;
		
		if(!is_null($value)) $value=trim($value);
		
		if(isset($options['type'])) $type=$options['type'];
		if(isset($options['defaultValue'])) $defaultValue=$options['defaultValue'];
		
		if(isset($options['nozero']) && $options['nozero']===true && $value==='0'){
			return $defaultValue;					
		}
		
		if($type=='string'){
			if($value !== ""){				
				if(isset($options['addslashes']) && $options['addslashes']===true) $value=addslashes($value);
				return $value;
			}
		}elseif($type=='int'){			
			if(trim($value) !== "" && $value !=0) return $value;
		}elseif($type=='double'){			
			if(trim($value)!=="" && doubleval($value)!=0.00) return $value;
		}
		
		return $defaultValue;
    }

    
    function requestType($req, $type){
		if($type=='string'){
			if(isset($_REQUEST[$req]) && !is_null($_REQUEST[$req]) && trim($_REQUEST[$req]) !== '') return true;
        }elseif($type=='int'){
			if(isset($_REQUEST[$req]) && !is_null($_REQUEST[$req]) && trim($_REQUEST[$req]) !== '' && intval($_REQUEST[$req]) != 0) return true;
        }elseif($type=='double'){
			if(isset($_REQUEST[$req]) && trim($_REQUEST[$req]) !== '' && doubleval(str_replace(',', '.', $_REQUEST[$req])) != 0) return true;
        }
        return false;
    }

    function randChars($charlength){

        $chars = '123456789abcdfghjkmnpqrstvwxyz';
        $ret = "";
        $randstr = "";
        $i = 0;

        while($i < $charlength){
            $randstr = mt_rand(0, strlen($chars) - 1);
            $ret .= substr($chars, $randstr, 1);
            $i++;
        }

        return $ret;
    }
    
    function lat2GeoUtf8($str, $setMbInternalEncoding=true){
		if($setMbInternalEncoding==true) mb_internal_encoding("UTF-8");
		$latin_to_utf8=array('a'=>'ა','b'=>'ბ','g'=>'გ','d'=>'დ','e'=>'ე','v'=>'ვ','z'=>'ზ','T'=>'თ','i'=>'ი','k'=>'კ','l'=>'ლ','m'=>'მ','n'=>'ნ','o'=>'ო','p'=>'პ','J'=>'ჟ','r'=>'რ','s'=>'ს','t'=>'ტ','u'=>'უ','f'=>'ფ','q'=>'ქ','R'=>'ღ','y'=>'ყ','S'=>'შ','C'=>'ჩ','c'=>'ც','Z'=>'ძ','w'=>'წ','W'=>'ჭ','x'=>'ხ','j'=>'ჯ','h'=>'ჰ');
		
		$strUtf8="";
		$tmpChar=null;
		$strLength=mb_strlen($str);
		for($i=0; $i<$strLength; $i++){
			$tmpChar=$str[$i];
			if(isset($latin_to_utf8[$tmpChar])) $strUtf8.=$latin_to_utf8[$tmpChar]; else $strUtf8.=$tmpChar; 
		}

        return $strUtf8;
    }
    
    function utf8ToUnicode($contentsStr){
        $contents = $contentsStr;
        $contents = eregi_replace('ა', '&#4304;', $contents);
        $contents = eregi_replace('ბ', '&#4305;', $contents);
        $contents = eregi_replace('გ', '&#4306;', $contents);
        $contents = eregi_replace('დ', '&#4307;', $contents);
        $contents = eregi_replace('ე', '&#4308;', $contents);
        $contents = eregi_replace('ვ', '&#4309;', $contents);
        $contents = eregi_replace('ზ', '&#4310;', $contents);
        $contents = eregi_replace('თ', '&#4311;', $contents);
        $contents = eregi_replace('ი', '&#4312;', $contents);
        $contents = eregi_replace('კ', '&#4313;', $contents);
        $contents = eregi_replace('ლ', '&#4314;', $contents);
        $contents = eregi_replace('მ', '&#4315;', $contents);
        $contents = eregi_replace('ნ', '&#4316;', $contents);
        $contents = eregi_replace('ო', '&#4317;', $contents);
        $contents = eregi_replace('პ', '&#4318;', $contents);
        $contents = eregi_replace('ჟ', '&#4319;', $contents);
        $contents = eregi_replace('რ', '&#4320;', $contents);
        $contents = eregi_replace('ს', '&#4321;', $contents);
        $contents = eregi_replace('ტ', '&#4322;', $contents);
        $contents = eregi_replace('უ', '&#4323;', $contents);
        $contents = eregi_replace('ფ', '&#4324;', $contents);
        $contents = eregi_replace('ქ', '&#4325;', $contents);
        $contents = eregi_replace('ღ', '&#4326;', $contents);
        $contents = eregi_replace('ყ', '&#4327;', $contents);
        $contents = eregi_replace('შ', '&#4328;', $contents);
        $contents = eregi_replace('ჩ', '&#4329;', $contents);
        $contents = eregi_replace('ც', '&#4330;', $contents);
        $contents = eregi_replace('ძ', '&#4331;', $contents);
        $contents = eregi_replace('წ', '&#4332;', $contents);
        $contents = eregi_replace('ჭ', '&#4333;', $contents);
        $contents = eregi_replace('ხ', '&#4334;', $contents);
        $contents = eregi_replace('ჯ', '&#4335;', $contents);
        $contents = eregi_replace('ჰ', '&#4336;', $contents);
        return $contents;
    }

    function unicodeToUtf8($contentsStr){
        $contents = $contentsStr;
        $contents = eregi_replace('&#4304;', 'ა', $contents);
        $contents = eregi_replace('&#4305;', 'ბ', $contents);
        $contents = eregi_replace('&#4306;', 'გ', $contents);
        $contents = eregi_replace('&#4307;', 'დ', $contents);
        $contents = eregi_replace('&#4308;', 'ე', $contents);
        $contents = eregi_replace('&#4309;', 'ვ', $contents);
        $contents = eregi_replace('&#4310;', 'ზ', $contents);
        $contents = eregi_replace('&#4311;', 'თ', $contents);
        $contents = eregi_replace('&#4312;', 'ი', $contents);
        $contents = eregi_replace('&#4313;', 'კ', $contents);
        $contents = eregi_replace('&#4314;', 'ლ', $contents);
        $contents = eregi_replace('&#4315;', 'მ', $contents);
        $contents = eregi_replace('&#4316;', 'ნ', $contents);
        $contents = eregi_replace('&#4317;', 'ო', $contents);
        $contents = eregi_replace('&#4318;', 'პ', $contents);
        $contents = eregi_replace('&#4319;', 'ჟ', $contents);
        $contents = eregi_replace('&#4320;', 'რ', $contents);
        $contents = eregi_replace('&#4321;', 'ს', $contents);
        $contents = eregi_replace('&#4322;', 'ტ', $contents);
        $contents = eregi_replace('&#4323;', 'უ', $contents);
        $contents = eregi_replace('&#4324;', 'ფ', $contents);
        $contents = eregi_replace('&#4325;', 'ქ', $contents);
        $contents = eregi_replace('&#4326;', 'ღ', $contents);
        $contents = eregi_replace('&#4327;', 'ყ', $contents);
        $contents = eregi_replace('&#4328;', 'შ', $contents);
        $contents = eregi_replace('&#4329;', 'ჩ', $contents);
        $contents = eregi_replace('&#4330;', 'ც', $contents);
        $contents = eregi_replace('&#4331;', 'ძ', $contents);
        $contents = eregi_replace('&#4332;', 'წ', $contents);
        $contents = eregi_replace('&#4333;', 'ჭ', $contents);
        $contents = eregi_replace('&#4334;', 'ხ', $contents);
        $contents = eregi_replace('&#4335;', 'ჯ', $contents);
        $contents = eregi_replace('&#4336;', 'ჰ', $contents);
        return $contents;
    }

    function checkBrowser(){

        $browser=$_SERVER['HTTP_USER_AGENT'];
        $browserVersion=array();
        $browserType="";

        if(preg_match('/Opera/', $browser, $browserVersion)) {
            $browserType = 'opera';
        }elseif(preg_match('/MSIE 6.0/', $browser, $browserVersion)) {
            $browserType = 'ie6';
        }elseif(preg_match('/MSIE/', $browser, $browserVersion)) {
            $browserType = 'ie';
        }elseif(preg_match('/Mozilla/', $browser, $browserVersion)) {
            $browserType = 'mozilla';
        }

        return trim($browserType);
    }

    function checkInArray($check, $chckVal, $id = "id"){
        $checkCnt = count($check);
        for($i = 0; $i < $checkCnt; $i++){
            if($check[$i][$id] == $chckVal) return 1;
        }
        return 0;
    }

    function createZip($file, $fileName, $destination = '',$overwrite = false) {

        if(file_exists($destination) && !$overwrite) { return false; }
        
        if(file_exists($file)) {
            $zip = new ZipArchive();
            if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
                return false;
            }		
            $zip->addFile($file,$fileName);		
            $zip->close();
            return file_exists($destination);
        }
        else
        {
            return false;
        }
        return true;
    }
    
    function downFile($file, $fileName, $ctype) {
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
    
    function requestMethod(){
    	if(isset($_SERVER['REQUEST_METHOD'])) return strtoupper(trim($_SERVER['REQUEST_METHOD']));
    	return null;
    }

}

?>
