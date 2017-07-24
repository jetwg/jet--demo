/**
 * @file 入口js
 * @author kaivean(kaivean@outlook.com)
 */
define('d', function (require) {
    var e = require('e');

    return {
        init: function (param) {
            console.log('d.init from ' + param);
            e.init('d');

            require(['f'], function (f) {
                f.init('async');
            });
        }
    };
});

define('e', function () {
    return {
        init: function (param) {
            console.log('e.init from ' + param);
        }
    };
});
