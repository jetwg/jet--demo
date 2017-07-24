<?php
/**
 * Smarty plugin
 * @package Smarty
 * @smarty_modifier_antiSrc
 */


/**
 * @param string
 * @param string
 * @return string
 */
function smarty_modifier_antiSrc($or_url, $type)
{
    return Wise_String::anti_src($or_url, $type);
}
