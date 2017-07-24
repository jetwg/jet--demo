/**
 * @file 入口js
 * @author kaivean(kaivean@outlook.com)
 */
define('b', function (require) {
    var d = require('d');
    return {
        init: function () {
            console.log('b.init');
            d.init('b');


        }
    };
});
