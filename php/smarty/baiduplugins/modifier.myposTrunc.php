<?php
/**
 * Smarty plugin
 *
 * @package Smarty
 * @subpackage PluginsModifier
 */

/**
 * @brief :  ���ı������ַ��ָ�
 * @param  $text : utf8������ַ���
 * @return : �ֳ�һ���ַ����ȵ�����
 **/
function mb_str_split($text) {
    return preg_split('/(?<!^)(?!$)/u', $text);  
}

/**
 * @brief : ��ȡ�ַ���ռ�õ�����
 * @param $text : �ַ���
 * @return : �ַ���ռ�õ�����
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
 * ����ʵ����Ļ��С������mypos��Ϣ
 * @param width : �ֻ��������
 * @param height : �ֻ��߶�����
 * @param has_pic : �Ƿ����ͼƬ
 * @return �ضϺ��mypos��Ϣ
 **/
function process_actual_screen($mypos_str, $width, $height, $type,
   	                           $has_pic, $comment_str, $blank_num) {
	$final_result = "";
	//ȥ�����׺��ʵ�ʳ���
	$actual_width = 0;
	if ($width >= 360) {
		$actual_width =  $width - 2 * 16;
		$blank_num = $blank_num * 8;
	} else {
		$actual_width =  $width - 2 * 16 * 0.9;
		$blank_num = $blank_num * 8 * 0.9;
	}

	//ȥ��ͼƬ�ĳ���
	if ($has_pic) {
		$actual_width = $actual_width * 0.7;
	}

	//ȥ������
	$actual_width = $actual_width - get_text_pixel($comment_str);

	//ȥ������
	$actual_width = $actual_width - $blank_num;
	$actual_width = floor($actual_width);

	//��֤
	if ($actual_width <= 0) {
		return "";
	}
    return generate_final_mypos($mypos_str, $actual_width, $type);
}

/**
 * @brief �ض�mypos
 * @param : myposStr mypos�ַ���
 * @param : $pixLeft ʣ�������
 * @param : type ��ͬ����������ͬ�Ľضϲ���
 * @return : �ضϺ���ַ���
 **/
function generate_final_mypos($myposStr, $pixLeft, $type) {
	//����
	if ($myposStr == "gw") {
		return "";
	}

	//...�ض�
	if ($myposStr == "...") {
		if ($pixLeft >= 5 * 8) {
			return ">...";
		}else {
			return "";
		}
	}

	$finalMerge = "";
	//���������ж�mypos����
	if ($type == "mypos") {
	    $finalMerge =  mergeResult(processMyposTruncation($myposStr, $pixLeft));
		$finalMerge= iconv('utf-8', 'gbk', $finalMerge);
	}

    //urlSlice����
	if ($type == "urlslice") {
        $finalMerge = mergeResult(processUrlSliceTruncation($myposStr, $pixLeft));
		$finalMerge= iconv('utf-8', 'gbk', $finalMerge);
	}
	return $finalMerge;
}

/**
 * @brief urlSlice���͵Ľض�
 * @param myposStr : �ַ���
 * @param pixLeft : ʣ���������
 * @return : �ضϺ���ַ�������
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
				//��Ҫ����һ��Ԫ��
				array_pop($finalSplit);
				$finalSplit[] = "...";
				break;
			}
		}
	}
	//������
	$finalSplit = deleteSingleLetter($finalSplit);
	return $finalSplit;
}

/**
 * @brief : ɾ������ĸ��
 * @param finalSplit : url Ƭ������
 * @return ���˵���֮�������
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
		//ɾ������ĸ
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
 * @brief : �������е�Ԫ��ƴ������
 * @param finalSplit : ����
 * @return ƴ�Ӻ���ַ���
 **/
function mergeResult($finalSplit) {
	if (!is_array($finalSplit) || empty($finalSplit)) {
		return "";
	}
	//ƴ����һ��
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
 * @brief : ����mypos�Ľض�
 * @param $myposStr : �ַ���
 * @param $pixLeft : ʣ������
 * @return �������ַ�������
 **/
function processMyposTruncation($myposStr, $pixLeft) {
	//��mypos����ƴ��
	$myposStrSplit = explode('>', $myposStr);
	$reversedMyposArr = array_reverse($myposStrSplit);
	$reversedMyposStr = "";
	foreach($reversedMyposArr as $elem) {
		if (empty($elem)) {
		    continue;
		}
		$reversedMyposStr = $reversedMyposStr . ">" . $elem;
	}

	//����urlSplit
	$finalSplit = processUrlSliceTruncation($reversedMyposStr, $pixLeft);
	//��finalSplit����
	$reversedSlice = array_reverse($finalSplit);
	return $reversedSlice;
}

/**
 * @brief �������ض�mypos��Ϣ���нض�
 * @param width : �ֻ��������
 * @param height : �ֻ��߶�����
 * @param has_pic : �Ƿ����ͼƬ
 * @param comment_str : xxx���ۣ�123�����ۣ��ַ���
 * @param blank_num: ���ص�λ
 * @return �ضϺ��mypos��Ϣ
 */
function smarty_modifier_myposTrunc($mypos_str, $width, $height, $type,
									$has_pic, $comment_str, $blank_num) {
	//���� 14������
	//Ӣ�� 8������
    $arr_elem = mb_str_split($mypos_str);

	if ($width == 0 && $height == 0) {
		//��һ�η���, ����Ϊiphone5 ����
		$width = 320;
		$height = 568;
		$mypos_final = process_actual_screen($mypos_str, $width, $height, $type, 
			                                 $has_pic, $comment_str, $blank_num);
	}else {
		//��cookie�л�ȡʵ�ʳ����ʹ��ʵ�ʳ���
		$mypos_final = process_actual_screen($mypos_str, $width, $height, $type, 
			                                 $has_pic, $comment_str, $blank_num);
	}
	//��>�滻Ϊgoogle��ʽ�ķָ���
	$mypos_final = str_replace(">", "&nbsp;&rsaquo;&nbsp;", $mypos_final);
    return $mypos_final;
}

?>
