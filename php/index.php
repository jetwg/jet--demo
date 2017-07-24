<?php
/**
 * @file php render
 * @author kaivean(kaivean@outlook.com)
 */

require_once('init.php');

$sep = DIRECTORY_SEPARATOR;
// echo JET_DIR . "${sep}lib${sep}JetSingleton.class.php";
require_once(JET_DIR . "/lib/JetSingleton.class.php");


$opt = array(
    "moduleMapDir" => APP_DIR . "${sep}..${sep}conf",
    'moduleMap' => array(
        'a' => 'atom.conf.php'
    )
);
Jet_Singleton::startPage($opt);

$template_dir = APP_DIR . "${sep}..${sep}tpl";
$render_tpl_path = 'index.tpl';

$smarty = new Smarty();
$smarty -> template_dir = $template_dir; //模板存放目录
$smarty -> compile_dir = $template_dir . "${sep}templates_c"; //编译目录
// $smarty -> cache_dir = $currentPath . "cache";
$smarty -> caching = false;
$smarty -> debugging = true;
$smarty -> left_delimiter = "{%"; //左定界符
$smarty -> right_delimiter = "%}"; //右定界符
$smarty -> addPluginsDir(JET_DIR . "${sep}smarty_plugin");

$smarty -> assign('title', 'kaivean');

echo $smarty -> fetch($render_tpl_path);

?>
