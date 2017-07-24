<?php

function smarty_modifier_hilight_print($str, $hi_str)
{
    // $hi_str = iconv('utf-8', 'gbk', $hi_str);
    return preg_replace('/(' . str_replace('^', '|', $hi_str) . ')/', '<em>$0</em>', $str);
}

/* vim: set expandtab: */

?>
