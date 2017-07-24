<?php

    /**
     * @file php render init
     * @author kaivean(kaivean@outlook.com)
     */

    date_default_timezone_set('Asia/Shanghai');
    error_reporting(E_ALL & ~E_NOTICE); // error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE );

    $sep = DIRECTORY_SEPARATOR;
    if (!defined('APP_DIR')) {
        define('APP_DIR', dirname(__FILE__));
    }

    define('JET_DIR', APP_DIR . "${sep}..${sep}..${sep}jet-php");

    function __autoload($classname)
    {
        $sep = DIRECTORY_SEPARATOR;
        $smartyDir = APP_DIR . $sep . 'smarty';
        $smartyClassMap = array (
            'Search_AladdinFactory' => 'AladdinFactory.php',
            'FileUtil' => 'utils/utils_file.php',
            'Utils_Common' => 'utils/utils_common.php',
            'Wise_Utils' => 'utils/utils_wise.php',
            'Saf_SmartMain' => 'utils/SmartMain.php',
            'Utils_Tools' => 'utils/utils_edpxwise.php',
            'Smarty' => "$smartyDir/Smarty.class.php",
            "Smarty_CacheResource" => "$smartyDir/sysplugins/smarty_cacheresource.php",
            "Smarty_CacheResource_Custom" => "$smartyDir/sysplugins/smarty_cacheresource_custom.php",
            "Smarty_CacheResource_KeyValueStore" => "$smartyDir/sysplugins/smarty_cacheresource_keyvaluestore.php",
            "Smarty_Config_Source" => "$smartyDir/sysplugins/smarty_config_source.php",
            "Smarty_Internal_CacheResource_File" => "$smartyDir/sysplugins/smarty_internal_cacheresource_file.php",
            "Smarty_Internal_Compile_Assign" => "$smartyDir/sysplugins/smarty_internal_compile_assign.php",
            "Smarty_Internal_Compile_Append" => "$smartyDir/sysplugins/smarty_internal_compile_append.php",
            "Smarty_Internal_Compile_Block" => "$smartyDir/sysplugins/smarty_internal_compile_block.php",
            "Smarty_Internal_Compile_Blockclose" => "$smartyDir/sysplugins/smarty_internal_compile_block.php",
            "Smarty_Internal_Compile_Break" => "$smartyDir/sysplugins/smarty_internal_compile_break.php",
            "Smarty_Internal_Compile_Call" => "$smartyDir/sysplugins/smarty_internal_compile_call.php",
            "Smarty_Internal_Compile_Capture" => "$smartyDir/sysplugins/smarty_internal_compile_capture.php",
            "Smarty_Internal_Compile_CaptureClose" => "$smartyDir/sysplugins/smarty_internal_compile_capture.php",
            "Smarty_Internal_Compile_Config_Load" => "$smartyDir/sysplugins/smarty_internal_compile_config_load.php",
            "Smarty_Internal_Compile_Continue" => "$smartyDir/sysplugins/smarty_internal_compile_continue.php",
            "Smarty_Internal_Compile_Debug" => "$smartyDir/sysplugins/smarty_internal_compile_debug.php",
            "Smarty_Internal_Compile_Eval" => "$smartyDir/sysplugins/smarty_internal_compile_eval.php",
            "Smarty_Internal_Compile_Extends" => "$smartyDir/sysplugins/smarty_internal_compile_extends.php",
            "Smarty_Internal_Compile_For" => "$smartyDir/sysplugins/smarty_internal_compile_for.php",
            "Smarty_Internal_Compile_Forelse" => "$smartyDir/sysplugins/smarty_internal_compile_for.php",
            "Smarty_Internal_Compile_Forclose" => "$smartyDir/sysplugins/smarty_internal_compile_for.php",
            "Smarty_Internal_Compile_Foreach" => "$smartyDir/sysplugins/smarty_internal_compile_foreach.php",
            "Smarty_Internal_Compile_Foreachelse" => "$smartyDir/sysplugins/smarty_internal_compile_foreach.php",
            "Smarty_Internal_Compile_Foreachclose" => "$smartyDir/sysplugins/smarty_internal_compile_foreach.php",
            "Smarty_Internal_Compile_Function" => "$smartyDir/sysplugins/smarty_internal_compile_function.php",
            "Smarty_Internal_Compile_Functionclose" => "$smartyDir/sysplugins/smarty_internal_compile_function.php",
            "Smarty_Internal_Compile_If" => "$smartyDir/sysplugins/smarty_internal_compile_if.php",
            "Smarty_Internal_Compile_Else" => "$smartyDir/sysplugins/smarty_internal_compile_if.php",
            "Smarty_Internal_Compile_Elseif" => "$smartyDir/sysplugins/smarty_internal_compile_if.php",
            "Smarty_Internal_Compile_Ifclose" => "$smartyDir/sysplugins/smarty_internal_compile_if.php",
            "Smarty_Internal_Compile_Include" => "$smartyDir/sysplugins/smarty_internal_compile_include.php",
            "Smarty_Internal_Compile_Include_Php" => "$smartyDir/sysplugins/smarty_internal_compile_include_php.php",
            "Smarty_Internal_Compile_Insert" => "$smartyDir/sysplugins/smarty_internal_compile_insert.php",
            "Smarty_Internal_Compile_Ldelim" => "$smartyDir/sysplugins/smarty_internal_compile_ldelim.php",
            "Smarty_Internal_Compile_Nocache" => "$smartyDir/sysplugins/smarty_internal_compile_nocache.php",
            "Smarty_Internal_Compile_Nocacheclose" => "$smartyDir/sysplugins/smarty_internal_compile_nocache.php",
            "Smarty_Internal_Compile_Private_Block_Plugin" => "$smartyDir/sysplugins/smarty_internal_compile_private_block_plugin.php",
            "Smarty_Internal_Compile_Private_Function_Plugin" => "$smartyDir/sysplugins/smarty_internal_compile_private_function_plugin.php",
            "Smarty_Internal_Compile_Private_Modifier" => "$smartyDir/sysplugins/smarty_internal_compile_private_modifier.php",
            "Smarty_Internal_Compile_Private_Object_Block_Function" => "$smartyDir/sysplugins/smarty_internal_compile_private_object_block_function.php",
            "Smarty_Internal_Compile_Private_Object_Function" => "$smartyDir/sysplugins/smarty_internal_compile_private_object_function.php",
            "Smarty_Internal_Compile_Private_Print_Expression" => "$smartyDir/sysplugins/smarty_internal_compile_private_print_expression.php",
            "Smarty_Internal_Compile_Private_Registered_Block" => "$smartyDir/sysplugins/smarty_internal_compile_private_registered_block.php",
            "Smarty_Internal_Compile_Private_Registered_Function" => "$smartyDir/sysplugins/smarty_internal_compile_private_registered_function.php",
            "Smarty_Internal_Compile_Private_Special_Variable" => "$smartyDir/sysplugins/smarty_internal_compile_private_special_variable.php",
            "Smarty_Internal_Compile_Rdelim" => "$smartyDir/sysplugins/smarty_internal_compile_rdelim.php",
            "Smarty_Internal_Compile_Section" => "$smartyDir/sysplugins/smarty_internal_compile_section.php",
            "Smarty_Internal_Compile_Sectionelse" => "$smartyDir/sysplugins/smarty_internal_compile_section.php",
            "Smarty_Internal_Compile_Sectionclose" => "$smartyDir/sysplugins/smarty_internal_compile_section.php",
            "Smarty_Internal_Compile_Setfilter" => "$smartyDir/sysplugins/smarty_internal_compile_setfilter.php",
            "Smarty_Internal_Compile_Setfilterclose" => "$smartyDir/sysplugins/smarty_internal_compile_setfilter.php",
            "Smarty_Internal_Compile_While" => "$smartyDir/sysplugins/smarty_internal_compile_while.php",
            "Smarty_Internal_Compile_Whileclose" => "$smartyDir/sysplugins/smarty_internal_compile_while.php",
            "Smarty_Internal_CompileBase" => "$smartyDir/sysplugins/smarty_internal_compilebase.php",
            "Smarty_Internal_Config" => "$smartyDir/sysplugins/smarty_internal_config.php",
            "Smarty_Internal_Config_File_Compiler" => "$smartyDir/sysplugins/smarty_internal_config_file_compiler.php",
            "Smarty_Internal_Configfilelexer" => "$smartyDir/sysplugins/smarty_internal_configfilelexer.php",
            "Smarty_Internal_Configfileparser" => "$smartyDir/sysplugins/smarty_internal_configfileparser.php",
            "Smarty_Internal_Data" => "$smartyDir/sysplugins/smarty_internal_data.php",
            "Smarty_Internal_Debug" => "$smartyDir/sysplugins/smarty_internal_debug.php",
            "Smarty_Internal_Filter_Handler" => "$smartyDir/sysplugins/smarty_internal_filter_handler.php",
            "Smarty_Internal_Function_Call_Handler" => "$smartyDir/sysplugins/smarty_internal_function_call_handler.php",
            "Smarty_Internal_Get_Include_Path" => "$smartyDir/sysplugins/smarty_internal_get_include_path.php",
            "Smarty_Internal_Nocache_Insert" => "$smartyDir/sysplugins/smarty_internal_nocache_insert.php",
            "Smarty_Internal_Resource_Eval" => "$smartyDir/sysplugins/smarty_internal_resource_eval.php",
            "Smarty_Internal_Resource_Extends" => "$smartyDir/sysplugins/smarty_internal_resource_extends.php",
            "Smarty_Internal_Resource_File" => "$smartyDir/sysplugins/smarty_internal_resource_file.php",
            "Smarty_Internal_Resource_PHP" => "$smartyDir/sysplugins/smarty_internal_resource_php.php",
            "Smarty_Internal_Resource_Registered" => "$smartyDir/sysplugins/smarty_internal_resource_registered.php",
            "Smarty_Internal_Resource_Stream" => "$smartyDir/sysplugins/smarty_internal_resource_stream.php",
            "Smarty_Internal_Resource_String" => "$smartyDir/sysplugins/smarty_internal_resource_string.php",
            "Smarty_Internal_SmartyTemplateCompiler" => "$smartyDir/sysplugins/smarty_internal_smartytemplatecompiler.php",
            "Smarty_Internal_Template" => "$smartyDir/sysplugins/smarty_internal_template.php",
            "Smarty_Internal_TemplateBase" => "$smartyDir/sysplugins/smarty_internal_templatebase.php",
            "Smarty_Internal_TemplateCompilerBase" => "$smartyDir/sysplugins/smarty_internal_templatecompilerbase.php",
            "Smarty_Internal_Templatelexer" => "$smartyDir/sysplugins/smarty_internal_templatelexer.php",
            "Smarty_Internal_Templateparser" => "$smartyDir/sysplugins/smarty_internal_templateparser.php",
            "Smarty_Internal_Utility" => "$smartyDir/sysplugins/smarty_internal_utility.php",
            "Smarty_Internal_Write_File" => "$smartyDir/sysplugins/smarty_internal_write_file.php",
            "Smarty_Resource" => "$smartyDir/sysplugins/smarty_resource.php",
            "Smarty_Resource_Custom" => "$smartyDir/sysplugins/smarty_resource_custom.php",
            "Smarty_Resource_Recompiled" => "$smartyDir/sysplugins/smarty_resource_recompiled.php",
            "Smarty_Resource_Uncompiled" => "$smartyDir/sysplugins/smarty_resource_uncompiled.php",
            "Smarty_Security" => "$smartyDir/sysplugins/smarty_security.php",
        );

        if (isset($smartyClassMap[$classname]))
        {
            require_once ($smartyClassMap[$classname]);
        }
    }

?>
