#!/usr/bin/env php
<?php
defined('ROOT_PATH') or define('ROOT_PATH',__DIR__);
//引入自动加载类
require __DIR__.'/vendor/autoload.php';
//启动服务器
(new \Core\Start())->run();
