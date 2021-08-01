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

             // 执行对象
             $class = explode("::", $oper['method'])[0];
             $class = new $class();
             // 得到执行的方法
             $method = explode("::", $oper['method'])[1];
             // 执行
             $ret = $class->{$method}(...$oper['params']);

         }
    }
}