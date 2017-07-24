/**
 * @file 应用启动器
 * @author kaivean(kaivean@outlook.com)
 */
'use strict';
const fs = require('fs');
const path = require('path');
const Koa = require('koa');
const Router = require('koa-router');
const send = require('koa-send');
const util = require('./util');

const app = new Koa();
const router = new Router();

const conf = {
    port: 8099
};

// 提供静态文件服务
app.use(async function (ctx, next) {
    if (ctx.path.indexOf('/js') === 0) {
        return await send(ctx, ctx.path, {
            root: path.resolve(__dirname, '..'),
            gzip: true,
            maxage: 1000 * 60 * 60 * 24 * 30 // 30day， 不再304，直接从from disk
        });
    }
    if (ctx.path.indexOf('/jet-loader') === 0) {
        return await send(ctx, ctx.path, {
            root: path.resolve(__dirname, '..', '..', 'jet-loader', 'src'),
            gzip: true,
            maxage: 1000 * 60 * 60 * 24 * 30 // 30day， 不再304，直接从from disk
        });
    }
    return next();
});


router.get('/', async function (ctx, next) {
    console.log('access', ctx.url);
    let type = 'page';
    if (type === 'page') {
        ctx.type = 'text/html; charset=utf-8';
    }
    else {
        ctx.type = 'application/json; charset=utf-8';
    }

    let res = await util.execCommand('php', [
        path.resolve(__dirname, '..', 'php', 'index.php')
    ]);

    ctx.body = res.output;
    return await next();
});

router.get('/combo', async function (ctx, next) {
    console.log('access', ctx.url);
    let query = ctx.query;
    let jss = query.js || '';
    let ids = jss.split(',');
    let jsDir = path.resolve(__dirname, '..', 'js');

    let jsContent = '';
    for (let id of ids) {
        let abs = path.resolve(jsDir, id);
        if (fs.existsSync(abs)) {
            let cont = fs.readFileSync(abs, {encoding: 'utf-8'});
            jsContent += cont;
        }
    }
    ctx.type = 'application/x-javascript; charset=utf-8';
    ctx.body = jsContent;
    return await next();
});

// 使路由生效
app.use(router.routes()).use(router.allowedMethods());

// 启动后端, 不指定hostname，则通过localhost ,127.0.0.1 机器地址都可以访问
app.listen(conf.port, function (error) {
    if (error) {
        console.error('本地服务器启动失败：', error);
    }
    else {
        console.info(`本地服务器 已启动，地址: http://${util.getLocalRealIp()}:${conf.port}/ `);
    }
});

app.on('error', function (err, ctx) {
    console.error('本地服务器发送错误：', err);
    ctx.status = 404;
});
