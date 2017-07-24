<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty aladdin modifier plugin
 *
 * Type:     modifier<br>
 * Name:     aladdin<br>
 * Date:
 * Purpose:  truncate a word
 * Input:    string to truncate
 * Example:  {$content|aladdin:$usdata:$page:$srv:$req}
 * @version 1.0
 * @param $usData,$pageData,$wiauiData,$serverData
 * @param string
 * @return string
 */
function smarty_modifier_searchaladdin($content,$usdata,$page,$srv,$req,$serverData,$movedown=false)
{
	//
	// /**
    //  * template name
    //  */
	// if(!empty($content['resoucetpl'])){
	// 	$templateName = $content['resoucetpl'];
	// 	$tmp_tpl_path = $content['tplFile'];
	// }elseif(!empty($content['srcid'])){
	// 	$templateName = $content['srcid'];
	// 	$tpl_path = $content['tplFile'];
	// }
	//
	// /**
    //  * template name 目录是否存在
    //  */
	//
	// if(file_exists($tmp_tpl_path)){
	// 	$tpl_path = $tmp_tpl_path;
	// }
	//
	// //对传给阿拉丁模版的数据处理
	// if(!empty($content['srcid']) && (empty($content['resourceid']) || empty($content['enresourceid']))){
	// 	$content['resourceid'] = $content['srcid'];
	// 	$content['enresourceid'] = $content['srcid'];
	// }
	// /*
	// 1、$alaData:即现在的$content
	// 2、$tplData:$content.result的简短变量名。gss透传的数据
	// 3、$pageData:无线页面参数，主要是无线页面公共参数
	// 4、$reqData:url的主要数据
	// 5、$extData:扩展数据包括$usData、wiauiData、$serverData
	// 其中：
	// 1、$usData:us返回的主要数据，包括resourceid、hilightstr、result(gss透传给aladdin模板数据)
	// 2、$wiauiData:wiaui接受到的参数，主要是适配、联盟和广告等
	// 3、$serverData:服务端一些变量，包括$_SERVER和cookie等
	// */
	// $arrPageInfo = array(
	// 	'alaData' => $content,
	// 	'tplData' => $content['result'],
	// 	'reqData' => $req,
	// 	'pageData' => $page,
	// 	'movedown' => $movedown,
	// 	'extData' => array(	'usData' => $usdata,
	// 						'wiauiData' => $srv,
	// 						'serverData' => $serverData,
	// 				),
	// );
	//
    // $logArr['template_name'] = $templateName;
	// $logArr['resourceid'] = '';
    // $logArr['tpl_path'] = $tpl_path;
	//
	//
    // /**
    //  * template name cannot be empty
    //  */
    // if( empty($templateName) ) {
    //     Bd_Log::warning("template name is empty", -1, $logArr);
    //     return false;
    // }
	//
	// /**
    //  * tpl_path cannot be empty
    //  */
    // if( empty($tpl_path) ) {
    //     Bd_Log::warning("tpl_path is empty", -1, $logArr);
    //     return false;
    // }
	//
	//
    // /**
    //  * page renderer
    //  * @var aladdinTemplate
    //  */
    // $aladdinTemplate = new Search_Template();
    // if( false === $aladdinTemplate ) {
    //     $status = -1;
    //     Bd_Log::warning("fail to get instance of aladdinTemplate, type: $type", $status, $logArr);
    //     return false;
    // }
	//
    // /**
    //  * render aladdin's page ,try catch template error log
    //  */
	// try{
	// 	$page = $aladdinTemplate->renderAladdin($tpl_path, $arrPageInfo);
	// } catch (Exception $ex) {
	// 	Bd_Log::warning(" tplt = $templateName , Smarty warning , Aladdin template error , error log: ".$ex->getMessage(), -1, $ex->getMessage());
	// 	return false;
	// }
    // if( $page === false ) {
    //     $status = -1;
    //     Bd_Log::warning("fail to render aladdin's page", $status, $logArr);
    //     return false;
    // }
    // if( strlen($page) == 0 ) {
    //     $status = -1;
    //     #Bd_Log::warning("aladdin's page is empty", $status, $logArr);
    //     return false;
    // }

    // return $page;

	$alaData = $content['alaData'];

	if ($alaData['glb_type'] == 'cluster') {

		// smarty 初始化
	    $sync_root = SYSTEM_ROOT . PATH_SEP . '.edpx-wise' . PATH_SEP . 'edpx-wise-sync' . PATH_SEP . 'template' . PATH_SEP;
	    $smarty = Utils_Tools::get_smarty($sync_root);

		$tpl_root = $sync_root . 'search' . PATH_SEP . 'cluster' . PATH_SEP;

		$clustername = $alaData['templateName'];
	    $tpl_dir = $tpl_root . $clustername;
	    $render_tpl_path = $tpl_dir . PATH_SEP . 'iphone.edpxwise.tpl';

	    $tpl_path = $tpl_dir . PATH_SEP . 'iphone.tpl';
	    $proj_tpl_path = $content['proj_root'] . PATH_SEP . 'cluster' . PATH_SEP . $clustername . PATH_SEP . 'iphone.tpl';

	    $fu = new FileUtil();

	    if (file_exists($proj_tpl_path)) {
	        $fu -> copyFile($proj_tpl_path, $render_tpl_path, true);
	    }
	    else if (file_exists($tpl_path)) {
	        $fu -> copyFile($tpl_path, $render_tpl_path, true);
	    }
	    else {
	        throw new Exception("The Cluser Template [$tpl_path] not Exist", 1);
	    }

		$sysData = array(
			'alaData' => $alaData,
			'reqData' => $req,
			'tplData' => $content['tplData'],
		);

		foreach ($sysData as $key => $val) {
	        $smarty -> assign($key, $val);
	    }

	    return $smarty -> fetch($render_tpl_path);

	}

	$cardname = $content['cardname'];
	$query = $content['query'];

	return "<!-- edpx-wise-[$cardname]-[$query] -->";
}

/* vim: set expandtab: */

?>
