/**
 * @file action
 * @author kaivean(kaivean@outlook.com)
 */
'use strict';

const path = require('path');
const nodemon = require('nodemon');
// const app = require('./app');

nodemon({
    script: path.resolve(__dirname, 'app.js'),
    restartable: 'rs',
    ext: 'js json',
    verbose: true,
    ignore: [
        '.git',
        'node_modules/**/node_modules'
    ],
    env: {
        'NODE_ENV': 'development',
        'NODE_LOADER': 'nodemon'
    },
    watch: [
        path.resolve(__dirname, '..')
    ]
});

nodemon.on('start', function () {
    console.log('nodemon: App has started');
}).on('quit', function () {
    console.log('nodemon: App has quit');
}).on('restart', function (files) {
    console.log('nodemon: App restarted due to: ', files);
});
