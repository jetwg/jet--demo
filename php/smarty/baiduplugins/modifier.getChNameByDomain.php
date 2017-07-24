<?php
    /**
     * @param unknown $strUrl
     * @param string $app
     * @return string
     */
     function smarty_modifier_getChNameByDomain($strUrl,$tag = ''){
         $strReplacedUrl = $strUrl;
         if(empty($strUrl)){
             return $strReplacedUrl;
         }
         $strDictRst = Wise_Utils::getValueFromDict($strReplacedUrl,'domain_to_chname.conf');
         if(empty($strDictRst)){
             return $strReplacedUrl;
         }
         return $strDictRst;
     }
