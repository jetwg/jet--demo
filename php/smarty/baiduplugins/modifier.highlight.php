<?php

function smarty_modifier_highlight($str, $hi_str)
{
    $hi_str = iconv('utf-8', 'gbk', $hi_str);
    if (isset($hi_str) && $hi_str != '') {
        return preg_replace('/(' . str_replace('^', '|', $hi_str) . ')/', '<em>$0</em>', $str);
    }
    else {
        return $str;
    }
}

/* vim: set expandtab: */

?>
