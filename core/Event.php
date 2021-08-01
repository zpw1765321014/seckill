<?php
/**
 * Created by PhpStorm.
 * User: zpw
 * Date: 2021/8/1
 * Time: 16:34
 */

namespace Core;


class Event
{
     use Singleton;
     //注册回调事件
     public  function run(\Swoole\Server $server)
     {
         //设置对应的事件
           $server->on('Request',[(new \Core\event\Request()),'run']);
           $server->on('receive', [(new \Core\event\Receive()), 'run']);
     }
}