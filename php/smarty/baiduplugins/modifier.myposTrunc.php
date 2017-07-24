<?php
/**
 * Smarty plugin
 *
 * @package Smarty
 * @subpackage PluginsModifier
 */

/**
 * @brief :  将文本按照字符分割
 * @param  $text : utf8编码的字符串
 * @return : 分成一个字符粒度的数组
 **/
function mb_str_split($text) {
    return preg_split('/(?<!^)(?!$)/u', $text);  
}

/**
 * @brief : 获取字符串占用的像素
 * @param $text : 字符串
 * @return : 字符串占用的像素
 **/
function get_text_pixel($text) {
	$sum_len = 0;
	$arr_elem = mb_str_split($text);
	$one_ch_len = 14;
	$one_eng_len = 8;
	foreach ($arr_elem as $elem) {
		if (strlen($elem) > 1) {
			$sum_len += $one_ch_len;
		}else {
			$sum_len += $one_eng_len;
		}
	}
	return $sum_len;
}

/**
 * 根据实际屏幕大小，处理mypos信息
 * @param width : 手机宽度像素
 * @param height : 手机高度像素
 * @param has_pic : 是否包含图片
 * @return 截断后的mypos信息
 **/
function process_actual_screen($mypos_str, $width, $height, $type,
   	                           $has_pic, $comment_str, $blank_num) {
	$final_result = "";
	//去除留白后的实际长度
	$actual_width = 0;
	if ($width >= 360) {
		$actual_width =  $width - 2 * 16;
		$blank_num = $blank_num * 8;
	} else {
		$actual_width =  $width - 2 * 16 * 0.9;
		$blank_num = $blank_num * 8 * 0.9;
	}

	//去除图片的长度
	if ($has_pic) {
		$actual_width = $actual_width * 0.7;
	}

	//去除评论
	$actual_width = $actual_width - get_text_pixel($comment_str);

	//去除留白
	$actual_width = $actual_width - $blank_num;
	$actual_width = floor($actual_width);

	//验证
	if ($actual_width <= 0) {
		return "";
	}
    return generate_final_mypos($mypos_str, $actual_width, $type);
}

/**
 * @brief 截断mypos
 * @param : myposStr mypos字符串
 * @param : $pixLeft 剩余的像素
 * @param : type 不同的类型做不同的截断策略
 * @return : 截断后的字符串
 **/
function generate_final_mypos($myposStr, $pixLeft, $type) {
	//官网
	if ($myposStr == "gw") {
		return "";
	}

	//...截断
	if ($myposStr == "...") {
		if ($pixLeft >= 5 * 8) {
			return ">...";
		}else {
			return "";
		}
	}

	$finalMerge = "";
	//根据类型判断mypos类型
	if ($type == "mypos") {
	    $finalMerge =  mergeResult(processMyposTruncation($myposStr, $pixLeft));
		$finalMerge= iconv('utf-8', 'gbk', $finalMerge);
	}

    //urlSlice类型
	if ($type == "urlslice") {
        $finalMerge = mergeResult(processUrlSliceTruncation($myposStr, $pixLeft));
		$finalMerge= iconv('utf-8', 'gbk', $finalMerge);
	}
	return $finalMerge;
}

/**
 * @brief urlSlice类型的截断
 * @param myposStr : 字符串
 * @param pixLeft : 剩余多少像素
 * @return : 截断后的字符串数组
 **/
function processUrlSliceTruncation($myposStr, $pixLeft) {
	$myposStr = $myposStr . ">";
	$myposStrSplit = explode('>', $myposStr);
	$finalSplit = array();
	$sum = 0;
	foreach($myposStrSplit as $myposElem) {
		if (empty($myposElem)) {
			continue;
		}
		$len = get_text_pixel($myposElem) + 8 * 2;
		if ($sum + $len <= $pixLeft) {
			$finalSplit[] =  $myposElem;
			$sum += $len;
		}else {
			if ($sum + 5 * 8 <= $pixLeft) {
				$finalSplit[] = "...";
				break;
			}else {
				//需要回退一个元素
				array_pop($finalSplit);
				$finalSplit[] = "...";
				break;
			}
		}
	}
	//处理单字
	$finalSplit = deleteSingleLetter($finalSplit);
	return $finalSplit;
}

/**
 * @brief : 删除单字母的
 * @param finalSplit : url 片段数组
 * @return 过滤单字之后的数组
 **/
function deleteSingleLetter($finalSplit) {
	$splitCount = count($finalSplit);
	if ($splitCount <= 0) {
		return;
	}
	$filterSingleLetter = array();
	$arrayIndex = $splitCount - 1;
	if ($finalSplit[$arrayIndex] == '...') {
		$arrayIndex--;
		while (strlen($finalSplit[$arrayIndex]) == 1) {
			$arrayIndex--;
		}
		for ($i = 0; $i <= $arrayIndex; $i++) {
			$filterSingleLetter[] = $finalSplit[$i];
		}
		$filterSingleLetter[] = '...';
	}else {
		$arrayIndexBefore = $arrayIndex;
		while (strlen($finalSplit[$arrayIndex]) == 1) {
			$arrayIndex--;
		}
		//删除单字母
		if ($arrayIndexBefore != $arrayIndex) {
			for ($i = 0; $i <= $arrayIndex; ++$i) {
			    $filterSingleLetter[] = $finalSplit[$i];
			}
			$filterSingleLetter[] = '...';
		}else {
			$filterSingleLetter = $finalSplit;
		}
	}
	return $filterSingleLetter;
}

/**
 * @brief : 将数组中的元素拼接起来
 * @param finalSplit : 数组
 * @return 拼接后的字符串
 **/
function mergeResult($finalSplit) {
	if (!is_array($finalSplit) || empty($finalSplit)) {
		return "";
	}
	//拼接在一起
	$finalUrlSplice = "";
	foreach($finalSplit as $elem) {
		if (empty($elem)) {
			continue;
		}
	    $finalUrlSplice  = $finalUrlSplice . ">" . $elem;
	}
	return $finalUrlSplice;
}

/**
 * @brief : 处理mypos的截断
 * @param $myposStr : 字符串
 * @param $pixLeft : 剩余像素
 * @return 处理后的字符串数组
 **/
function processMyposTruncation($myposStr, $pixLeft) {
	//将mypos逆序拼接
	$myposStrSplit = explode('>', $myposStr);
	$reversedMyposArr = array_reverse($myposStrSplit);
	$reversedMyposStr = "";
	foreach($reversedMyposArr as $elem) {
		if (empty($elem)) {
		    continue;
		}
		$reversedMyposStr = $reversedMyposStr . ">" . $elem;
	}

	//调用urlSplit
	$finalSplit = processUrlSliceTruncation($reversedMyposStr, $pixLeft);
	//将finalSplit逆序
	$reversedSlice = array_reverse($finalSplit);
	return $reversedSlice;
}

/**
 * @brief 根据像素对mypos信息进行截断
 * @param width : 手机宽度像素
 * @param height : 手机高度像素
 * @param has_pic : 是否包含图片
 * @param comment_str : xxx评论，123条评论，字符串
 * @param blank_num: 像素单位
 * @return 截断后的mypos信息
 */
function smarty_modifier_myposTrunc($mypos_str, $width, $height, $type,
									$has_pic, $comment_str, $blank_num) {
	//中文 14个像素
	//英文 8个像素
    $arr_elem = mb_str_split($mypos_str);

	if ($width == 0 && $height == 0) {
		//第一次访问, 设置为iphone5 机型
		$width = 320;
		$height = 568;
		$mypos_final = process_actual_screen($mypos_str, $width, $height, $type, 
			                                 $has_pic, $comment_str, $blank_num);
	}else {
		//从cookie中获取实际长宽后，使用实际长宽
		$mypos_final = process_actual_screen($mypos_str, $width, $height, $type, 
			                                 $has_pic, $comment_str, $blank_num);
	}
	//将>替换为google样式的分隔符
	$mypos_final = str_replace(">", "&nbsp;&rsaquo;&nbsp;", $mypos_final);
    return $mypos_final;
}

?>
