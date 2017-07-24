<?php
/**
 * 提供给https项目使用的域名替换模板插件
 * 异常时返回原url
 * @param unknown $strUrl
 * @param string $app
 * @return string
 */
function smarty_modifier_getHttpsHost($strUrl,$tag = ''){
    $strReplacedUrl = $strUrl;
    $ishttps = Wise_Utils::isHttps();
    if($ishttps !== 1){
        return $strReplacedUrl;
    }
    if(empty($strUrl)){
        return $strReplacedUrl;
    }
    // url 里面有中文时会有乱码
    if (preg_match_all("/[\x{4e00}-\x{9fa5}]+/u", $strReplacedUrl, $ary)) {
        foreach($ary[0] as $word) {
            $strUrl = str_replace($word, urlencode($word), $strUrl);
        }
    }
    $arr = parse_url($strUrl);
    //url不符合规范，解析失败
    if(empty($arr) || !is_array($arr)){
        return $strReplacedUrl;
    }
    $strScheme = $arr['scheme'];
    //非http开头的url
    if(empty($strScheme) || $strScheme != 'http'){
        return $strReplacedUrl;
    }
    $strHost = $arr['host'];
    $strDictRst = Wise_Utils::getValueFromDict($strHost,'http_to_https');
    if(empty($strDictRst)){
        return $strReplacedUrl;
    }
    $arr['scheme'] = 'https';
    $arr['host'] = $strDictRst;
    $strBuildUrl = Wise_Utils::antiParerUrl($arr);

    if(!empty($strBuildUrl)){
        $strReplacedUrl = $strBuildUrl;
    }
    return $strReplacedUrl;
}

