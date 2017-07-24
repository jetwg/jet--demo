<?php
    /* 生成timg图片链接
     * timg文档http://wiki.babel.baidu.com/twiki/bin/view/Com/CloudOS/Timgonline
     * quality和size参数可能较为常用，单独提出来传递，其余参数通过kv形式通过$params数组传递
     */
    function smarty_function_makeTimg($params){
		if(!is_string($params['src'])){
            return;
        }
        $sec    = time();
        $key    = "wisetimgkey";
        $di     = md5($key.$sec.$params['src']);
        $scheme = "http://";
        $host   = "cdn01.baidu-img.cn";

        // 判断是否在https协议下
        $ishttps = Wise_Utils::isHttps();
        if($ishttps == 1){
            $strDictRst = Wise_Utils::getValueFromDict($host,'http_to_https');

            if(!empty($strDictRst)){
                $scheme = "https://";
                $host   = $strDictRst;
            }
        }

        $url  = $scheme.$host."/timg?wisealaddin&amp;sec=$sec&amp;di=$di&amp;";
		$url .= http_build_query($params, '', '&amp;');
        return $url;
    }
?>
