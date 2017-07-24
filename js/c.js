/**
 * @file 入口js
 * @author kaivean(kaivean@outlook.com)
 */
define('c', function (require) {
    var d = require('d');
    return {
        init: function (param) {
            console.log('c.init from ' + param);
            d.init('c');
        }
    };
});
