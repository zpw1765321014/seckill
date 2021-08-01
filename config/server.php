<?php
/**
 * 服务器的基本配置信息
 */
return [

        'server' => [
            'host' => '0.0.0.0',
            'port' => 9501,
            'worker_num' => swoole_cpu_num() * 2,
        ],


];
