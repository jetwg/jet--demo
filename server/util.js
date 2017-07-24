/**
 * @file 执行
 * @author kaivean(kaivean@outlook.com)
 */

const fs = require('fs');
const os = require('os');
const fetch = require('node-fetch');
const path = require('path');

exports.execCommand = function (handler, args) {
    args = args || {};
    let child = require('child_process').spawn(
        handler,
        args
    );
    let bodyBuffer = [];
    return new Promise(function (resolve, reject) {
        child.stderr.on('data',
            function () {
                resolve({
                    code: 1,
                    output: [].slice.call(arguments).join('\n'),
                    stdOut: bodyBuffer.join('')
                });
            }
        );

        child.stdout.on('data',
            function (buf) {
                bodyBuffer.push(buf);
            }
        );

        child.on('close',
            function (code) {
                resolve({
                    code: code,
                    output: bodyBuffer.join('')
                });
            }
        );
    });
};

exports.getLocalRealIp = () => {
    let ifaces = require('os').networkInterfaces();
    let defultAddress = '127.0.0.1';
    let ip = defultAddress;

    /* eslint-disable no-loop-func */
    for (let dev of Object.keys(ifaces)) {
        if (ifaces[dev]) {
            ifaces[dev].forEach(
                function (details) {
                    if (ip === defultAddress && details.family === 'IPv4') {
                        ip = details.address;
                    }
                }
            );
        }
    }
    return ip;
};
