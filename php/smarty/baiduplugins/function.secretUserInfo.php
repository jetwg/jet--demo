<?php

function smarty_function_secretUserInfo($params, &$smarty) {

    if (!empty($params['value'])) {
        $value = $params['value']; 
    
        //防止大小写错误
        switch (strtolower($params['type'])) {
            case 'mobile' :  
                //手机号 前3位与后3位除外，中间5位直接用“*****”代替
                $value = preg_replace('/(\d{3})(\d{5})(\d{3})/', '${1}*****$3', $value);
                break;

            case 'email' :
                //邮箱地址 邮箱名字符数大于3的，前两个和最后一个字符除外，其他字符统一用“***”代替；邮箱名字符数为3及以下的，第一位明文展示，其他统一用“***”代替
                $prefixIndex = stripos($value, '@', 0);

                if (false !== $prefixIndex) {
                    if ($prefixIndex > 3) {
                        $value = preg_replace('/([\w.-]{2})([\w.-]+)([\w.-])@([\w.-]+)/', '${1}***${3}@$4', $value);    
                    } else {
                        $value = preg_replace('/([\w.-])([\w.-]+)@([\w.-]+)/', '${1}***@$3', $value); 
                    } 
                }
                break;

            case 'id' :
                //身份证号 前3位和末4位外的数字做马赛克处理（用星号替换）
                $len = strlen($value) - 7;
                $value = substr_replace($value, '_', 3, $len);
                $replacement = '*';

                while (--$len) { 
                    $replacement .= '*';
                }
                
                $value = substr_replace($value, $replacement, 3, 1);
                break;

            case 'bank' :
                //银行卡号 末4位以外的数字做马赛克处理（用星号替换）
                $len = strlen($value) - 4;
                $replacement = '*';

                while (--$len) {
                    $replacement .= '*';
                }

                $value = substr_replace($value, $replacement, 0, -4);
                break;

            case 'ip' : 
                //用户IP地址 要求点分十进制方式输出，并对第二个点后面的部分IP值进行“*”替换，如：123.*.*.*
                $value = preg_replace('/(\d{1,}\.)([\d.]+)/', '${1}.*.*.*', $value);
                break;
                
        }

        $params['value'] = $value;
    }

    return $params['value'];
}
