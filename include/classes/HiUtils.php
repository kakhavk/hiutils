<?php
/*
 * Created by Kakhaber Kashmadze
 */

class HiUtils{

    function decodeStr($str){
        if(trim($str) !== ""){
            //if (!get_magic_quotes_gpc()) {
            $str = stripslashes($str);
            $str = htmlspecialchars_decode($str);
            //}
            return trim($str);
        }
        return $str;
    }

    function encodeStr($str, $addsqlquotes=1, $htmlspecialchars=0) {

        $str=trim($str);
        if($str!=="") {
            if (!get_magic_quotes_gpc()) {
                $str=addslashes($str);
            }
            if($htmlspecialchars==1) $str=htmlspecialchars($str);

            return trim($str);
        }
        return "NULL";
    }
    function fcUpper($langid = 1, $str = ""){
        if($langid != 1){
            $str = ucfirst($str);
        }

        return trim($str);
    }

    function parsStrNull($str){
        if($str !== ""){
            if(!get_magic_quotes_gpc()){
                $str = addslashes($str);
            }
            return trim("'" . $str . "'");
        }
        return "NULL";
    }

    function parsValueNull($value, $checkQuotes=true){
		$str=trim($value);
		
		if($str !== "" && $str!==''){
			return $str;
		}
        return "NULL";
    }
    
    function parsStrNoZeroNull($str) {
        if($str!=="" && (int)$str!=0) {
            if (!get_magic_quotes_gpc()) {
                $str=addslashes($str);
            }
            return trim("'".$str."'");
        }
        return "NULL";
    }
    function parsIntNull($str){
        if(trim($str) !== "" && $str != 0) return $str;
        return "NULL";
    }

    function parsIntZero($digit){
        if(trim($digit) !== "" && $digit != 0) return $digit;
        return 0;
    }

    function parsDoubleNull($digit) {
        if(trim($digit)!=="" && doubleval($digit)!=0.00) return $digit;
        return "NULL";
    } 

    function parsDoubleZero($digit){
        if(trim($digit) !== "" && doubleval($digit) != 0.00) return $digit;
        return 0.00;
    }

    function parsNullInt($val){
        if(trim($val) == "" || is_null($val)) return 0;
        return $val;
    }

    function parsBooleanStr($str){
    	if(isset($str) && trim($str)!=="") return "'".$str."'";    	
    	return "'f'";
    }
    
    function reqInt($req){
        if(isset($_REQUEST[$req]) && !is_null($_REQUEST[$req]) && trim($_REQUEST[$req]) !== '' && intval($_REQUEST[$req]) != 0) return true;
        return false;
    }

    function reqTxt($req){
        if(isset($_REQUEST[$req]) && !is_null($_REQUEST[$req]) && trim($_REQUEST[$req]) !== '') return true;
        return false;
    }

    function reqPostTxt($req){
        if(isset($_POST[$req]) && trim($_POST[$req]) !== '') return true;
        return false;
    }

    function reqPostInt($req){
        if(isset($_POST[$req]) && trim($_POST[$req]) !== '' && intval($_POST[$req]) != 0) return true;
        return false;
    }

    function reqPostDbl($req){
        if(isset($_POST[$req]) && trim($_POST[$req]) !== '' && doubleval(str_replace(',', '.', $_POST[$req])) != 0) return true;
        return false;
    }

    function retShrnkedStr($str, $n, $elmntid = "", $showHide = 0){
        $str = str_replace('&nbsp;', ' ', $str = "");
        $expl_description = explode(" ", $this->decodeStr($str));

        $expl_count = count($expl_description);
        $ret = "";
        if($expl_count > $n){
            for($i = 0; $i <= $n; $i++){
                $ret .= " " . $expl_description[$i];
            }
            if($showHide != 0 && trim($elmntid) !== ""){
                $ret .= "<span class=\"cursr\" onclick=\"showHideContnt('" . $elmntid . "')\"> ...</span>";
            }else{
                $ret .= " ...";
            }
        }else{
            $ret = $str;
        }

        return $ret;
    }

    function intToEmpty($digit){
        if(intval($digit) == 0) return "";
        return $digit;
    }

    function dblToEmpty($digit){
        if(doubleval($digit) == 0) return "";
        return $digit;
    }

    function zeroToDbl($digit){
        if(doubleval($digit) == 0) return "0.00";
        return $digit;
    }

    function prserStr($erStr){
        $errorStr = trim($erStr);

        if(substr($errorStr, 0, 6) == "<br />") $errorStr = substr($errorStr, 6);
        elseif(substr($errorStr, 0, 5) == "<br/>") $errorStr = substr($errorStr, 5);
        elseif(substr($errorStr, 0, 4) == "<br>") $errorStr = substr($errorStr, 4);
        return $errorStr;
    }

    function filPcode($str, $rpt, $filarg = 0){
        $ret = "";
        $strln = strlen($str);
        $rpt = $rpt - $strln;
        $ret = str_repeat($filarg, $rpt) . "" . $str;
        return $ret;
    }

    function submtFrmHiSrvside($jsfrmfnct){

        echo "<script type=\"text/javascript\">" . " " . $jsfrmfnct . " " . "</script>";
    }

    function retRndChars($charlength){

        $chars = '123456789abcdfghjkmnpqrstvwxyz';
        $ret = "";
        $rndstr = "";
        $i = 0;

        while($i < $charlength){
            $rndstr = mt_rand(0, strlen($chars) - 1);
            $ret .= substr($chars, $rndstr, 1);
            $i++;
        }

        return $ret;
    }
    
    function latToUtf8($str, $setMbInternalEncoding=true){
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

    function chckInArray($chckArray, $chckVal, $id = "id"){
        $chckArrayCnt = count($chckArray);
        for($i = 0; $i < $chckArrayCnt; $i++){
            if($chckArray[$i][$id] == $chckVal) return 1;
        }
        return 0;
    }

    function retForeachVariables($vrbls){
        $ret = "";
        foreach($vrbls as $k => $v){
            $ret .= "<div style=\"clear:left; background-color:#cccccc; color:#000000;\">" . $k . " => " . $v . "</div>";
        }
        return $ret;
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
    function downFile($file, $fileNm, $ctype) {        
        if (file_exists($file)) {
            if(ob_get_level()!==0) ob_clean();
            header('Content-Description: File Transfer');
            header('Content-Type: '.$ctype.'');
            header('Content-Length: ' . filesize($file));
            header('Content-Disposition: attachment; filename=' . $fileNm);
            readfile($file);
            unlink($file);
            exit;
        }

    }
    
    function retRequestMethod(){
    	if(isset($_SERVER['REQUEST_METHOD'])) return strtoupper(trim($_SERVER['REQUEST_METHOD']));
    	return "";
    }

}

?>
