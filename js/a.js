/**
 * @file 入口js
 * @author kaivean(kaivean@outlook.com)
 */
define('a', function (require) {
    var b = require('b');
    var c = require('c');
    return {
        init: function () {
            console.log('a.init');

            b.init();
            c.init();
        }
    };
});
