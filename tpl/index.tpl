<!DOCTYPE html>
<html lang="zh_CN">
<head>
    <meta charset="utf-8">
    <title>Jet-{%$title%}</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <link href="//www.baidu.com/favicon.ico" rel="shortcut icon">
    <script src="/js/esl.js"></script>
    <script src="/jet-loader.js"></script>
    <script>
        require.config({
            baseUrl: '/js',
            paths: {

            },
            packages: [

            ],
            waitSeconds: 5
        });

    </script>

    {%jet_add_dep id="a"%}
    {%jet_add_dep id="e"%}
    {%jet_get_deps configVar="jet_deps"%}

    <script>
    define('c', function (require) {
        var d = require('d');
        return {
            init: function (param) {
                console.log('c.init from ' + param);
                d.init('c');
            }
        };
    });



    var jetOpt = {
        map: {%$jet_deps|@json_encode|escape:none|default: null%} || {}
    };
    new JetLoader(jetOpt);
    </script>
</head>
<body>

    <div id="viewport">
        请打开开发者工具查看效果
    </div>

    <script>
        require(['a'], function (a) {
            a.init();
        });
    </script>
</body>
</html>
