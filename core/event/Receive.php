<?php
/**
 * Created by PhpStorm.
 * User: zpw
 * Date: 2021/8/1
 * Time: 16:37
 */

namespace Core\event;

use Core\Config;
use Swoole\Server;

/**接受到数据连接触发的函数
 * Class Receive
 * @package Core\event
 */
class Receive
{
    public  function run(Server $server, $fd, $reactor_id, $data)
    {
          //判断事件类型
         $ServerType = Config::getInstance()->get('ServerType');
         //rpc 对应的解析模式
         if ($ServerType == 'rpc')
         {
             $oper = \json_decode($data, true);
             /***********得到对应的控制器 start************/
             $class = $oper['service'];
             $class = "\\App\\rpc\\$class";
             $class = new $class();
             /***********得到对应的控制器 end************/
             // 得到执行的方法
             $method = $oper['action'];
             // 执行
             $result = $class->{$method}($oper['param']);
             $server->send($fd,json_encode($result,true));
         }else{ //处理对应的tcp服务

         }
    }
}