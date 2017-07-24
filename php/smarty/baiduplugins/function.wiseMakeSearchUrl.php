<?php 
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage PluginsFunction
 */

/**
 * Smarty {wiseMakeSearchUrl} function plugin
 *
 * Type:     function<br>
 * Name:     wiseMakeSearchUrl<br>
 * Purpose:  make search url
 *
 * @author sunxiaobo <sunxiaobo03@>
 * @param
    [required parameters]:
	string sa 搜索行为_位置，取值参照 http://ws.baidu.com/#非结果搜索点击参数规范
    string word 搜索关键词 

    [optional parameters]:
    string $st 第三位标记搜索类型，取值参照 http://ws.baidu.com/#非结果搜索点击参数规范
	string $usm 后端插入结果偏移量, 仅翻页搜索需要此参数
	string $at AJAX请求标示.  1: 无限翻页请求  2: 唯一答案展开请求

 * @param Smarty_Internal_Template $template template object
 * @return string
 */
//{%wiseMakeSearchUrl  pn='0' rn='10' tn=iphone sa=re_1 st=11108i usm=6 at=1 ms=1%}
function smarty_function_wiseMakeSearchUrl($params, &$smarty){
	$tmp = array();
    $and = '&';
    
    $blacklist = array('pn', 'rn', 'ref', 'uid', 'baiduid', 'prest', 'usm');

    if(isset($params['notTc'])){
        unset($params['notTc']);
        $and = '&amp;';
    }
    
    //兼容处理，在阿拉丁模板中要取reqData字段，主模板中取req
    $reqData = $smarty->getTemplateVars('req');
    
    if(empty($reqData)){
        $reqData = $smarty->getTemplateVars('reqData');
        $pageData = $smarty->getTemplateVars('pageData');
        $extData = $smarty->getTemplateVars('extData');
        $serverData = $extData['serverData'];
    }else{
        $pageData = $smarty->getTemplateVars('page');
        $serverData = $smarty->getTemplateVars('serverData');
    }
    
    $host = strtolower($_SERVER['HTTP_HOST']);

    $common_prefix_array = array();
    
    if(!empty($reqData['from'])){
        $common_prefix_array['from'] = $reqData['from'];
    }

    if(!empty($reqData['ssid'])){
        $common_prefix_array['ssid'] = $reqData['ssid'];
    }
    
    if($reqData['bd_page_type'] == 0){
        $common_prefix_array['bd_page_type'] = 0;
    }
    
    if(!empty($reqData['pu'])){
        $pu = explode(',', $reqData['pu']);
        foreach($pu as $index => $item){
            if(strstr($item, 'usm@') || strstr($item, 'ta@') || strstr($item, 'ofrom@')){
                unset($pu[$index]);
            }elseif(strstr($item, 'sz@')){
                preg_match('/(?:\/|&)pu=.*?(?:\/|&|$)/', $serverData['HTTP_RAW_GET'], $_puMatches);
                
                if(!empty($_puMatches[0])){
                    $_rawGETPu = urldecode($_puMatches[0]);
                }else{
                    $_rawGETPu = '';
                }
                
                if(!strstr($_rawGETPu, 'sz@')){
                    unset($pu[$index]);
                }
            }
        }

        if ($params['sa'] == 'ipl_1') {
            $pu[] = 'ofrom@1010942u';
        }

        if(count($pu)){
            $common_prefix_array['pu'] = implode(',', $pu);
        }
    } elseif ($params['sa'] == 'ipl_1') {
        //电影票url携带pu=ofrom@1010942u,渠道号信息;
        $common_prefix_array['pu'] = 'ofrom@1010942u';
    }

	$common_prefix_str = http_build_query($common_prefix_array, '', '/');
    
    if(strlen($common_prefix_str) == 0){
        $common_prefix_str = 's';
    }else{
        $common_prefix_str .= '/s';
    }

    if(!empty($reqData['tn'])){
        $tmp['tn'] = $reqData['tn'];
    }
    
    if(!empty($params['pn'])){
        $tmp['pn'] = $params['pn'];
    }

    if(!empty($params['rn']) && $params['rm'] != 10){
        $tmp['rn'] = $params['rn'];
    }
    
    if(!empty($params['usm']) && !empty($params['pn'])){
        $tmp['usm'] = $params['usm'];
    }
	
	$notHasSTTpl = in_array($pageData['tpl'], array('iphone', 'utouch'));
	if (!$notHasSTTpl) {
		$tmp['st'] = '111001';
	} else if (isset($params['st'][2]) && (int)$params['st'][2] == 1){
		unset($params['st']);	
	}
	foreach($params as $key => $value) {
        if(!in_array($key, $blacklist) && trim($value) !== ''){
            $tmp[$key] = $value;
        }
	}
    
    //非m站和wap站点，强制转到m站
    if(!empty($reqData['vit']) && $reqData['vit'] == 'fps'){
        $tmp['ms'] = 1;
    }

    // 增加网盟无线透传参数fenlei,请让此参数位于$tmp数组最后 @2015/5/12 xinyu
    // 原因是fenlei参数可能很长导致截断其他参数
    if (!empty($reqData['fenlei'])) {
        $tmp['fenlei'] = $reqData['fenlei'];
    }

    //适配https协议
    return ($_SERVER['HTTP_HTTPS'] ? 'https' : 'http') . '://'.$host."/" . $common_prefix_str . "?" . http_build_query($tmp, '', $and);
}
