<?php

function smarty_outputfilter_trimall($source, &$smarty)
{
    //use strip source
	if(strpos($source,'<html') !== false&&strpos($source,'</html>') !== false){
		$tmp = explode('<html',$source,2);
		$tmp2 = explode('</html>',$tmp[1],2);
		$body = preg_replace('![\t ]*[\r\n]+[\t ]*!', '',$tmp2[0]);
		$source = $tmp[0] . '<html' .$body . '</html>' . $tmp2[1];
	}
    elseif(strpos($source,'<html') !== false&&strpos($source,'</html>') == false){
        $tmp = explode('<html',$source,2);
        $source =  $tmp[0] . '<html' .preg_replace('![\t ]*[\r\n]+[\t ]*!', '',$tmp[1]);
    }
    elseif(strpos($source,'<html') == false&&strpos($source,'</html>') !== false){
         $source = preg_replace('![\t ]*[\r\n]+[\t ]*!', '',$source);
    }
    elseif(strpos($source,'<wml>') !== false){
		$tmp = explode('<wml>',$source,2);
		$tmp2 = explode('</wml>',$tmp[1],2);
		$body = preg_replace('![\t ]*[\r\n]+[\t ]*!', '',$tmp2[0]);
		//����ո��&#160;�ַ�����Щ�ַ�����wmlcѹ�����ڵͶ˻���������޷�ʶ��
		$body = preg_replace('/(&#160;)+/','&#160;',$body);
		$source = $tmp[0] . '<wml>' .$body . '</wml>' . $tmp2[1];
	}
	
	return $source;
}
?>
