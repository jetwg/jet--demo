/**
 * @file 应用启动器
 * @author wukaifang
 */
'use strict';

// 线上机子是node6 不支持async，需要编译兼容
require('babel-register')({
    presets: ['es2015', 'stage-2']
});
require('babel-polyfill');
require('./bootstrap.js');
