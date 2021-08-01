<?php
/**
 * Created by PhpStorm.
 * User: zpw
 * Date: 2021/8/1
 * Time: 14:27
 */

namespace Core;
use Core\command\Command;

/**
 * 启动 整个服务
 * Class Start
 * @package Core
 */
class Start
{
    /**
     * 启动swoole 服务器
     */
      public function run()
      {
          Command::run(); //命令检测以及服务启动
      }

}// class end