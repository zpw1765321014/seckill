<?php
/**
 * Created by PhpStorm.
 * User: zpw
 * Date: 2021/8/1
 * Time: 14:45
 */

namespace Core\command;


use Core\Config;
use Core\Event;
use Swoole\Server;

class Command
{
    //启动框架
    public static function run()
    {
        //检查是否是cli模式
        self::checkCli();
        //检查是否被有swoole扩展
        self::checkExtension();
        //显示提示命令
        self::showUsageUI();
        //展示服务信息
        self::showMessage();
        //解析参数命令
        self::parseCommand();

    }
    //检查启动方式
    protected static function checkCli()
    {
        if(php_sapi_name() !=='cli'){

            echo "只能在 cli 摸下运行".PHP_EOL;
            exit;
        }
    }
    //检查对应的扩展
    protected static function checkExtension()
    {
        if(!extension_loaded('swoole')){
            echo "请安装 swoole 扩展".PHP_EOL;
            exit;
        }
    }
    //命令提示
    protected static function showUsageUI()
    {
        global $argc;
        if($argc <=1 || $argc > 3){
            echo PHP_EOL;
            echo "----------------------------------------".PHP_EOL;
            echo "|               Swoole                 |".PHP_EOL;
            echo "|--------------------------------------|".PHP_EOL;
            echo '|    USAGE: php swostar.php commond      |'.PHP_EOL;
            echo '|--------------------------------------|'.PHP_EOL;
            echo '|    1. start    以debug模式开启服务   |'.PHP_EOL;
            echo '|    2. start -d 以daemon模式开启服务  |'.PHP_EOL;
            echo '|    3. status   查看服务状态          |'.PHP_EOL;
            echo '|    4. reload   热加载                |'.PHP_EOL;
            echo '|    5. stop     关闭服务              |'.PHP_EOL;
            echo "----------------------------------------".PHP_EOL;
            echo PHP_EOL;
            exit;
        }

    }
    //解析命令启动服务
    protected static function parseCommand()
    {
        global $argv;

        $command = $argv[1];
        $option  = isset($argv[3]) ? $argv[3] : '';
        $serverType  = isset($argv[2]) ? $argv[2] : 'http';
        switch ($command)
        {
            case 'start':
                //设置一守护进程的方式启动数据
                if($option == '-d'){

                }
                self::serverStart($serverType);
                break;
            case 'reload':
                self::workerReolad();
                break;
            case 'status':
                self::workerStatus();
                break;
            case 'stop':
                self::workerStop();
                break;

        }
    }
    //启动服务
    protected static function serverStart($ServerType = null)
    {
        //获取配置信息
        $config = (new Config())->get('server.server');
        Config::getInstance()->set('ServerType',$ServerType);
         //设置服务配置信息
        switch ($ServerType)
        {
            case 'tcp':
            case 'rpc':
                $server = new Server($config['host'],$config['port']);
                break;
            case 'http':      // http 服务器
                $server = new \Swoole\Http\Server($config['host'],$config['port']);
                break;
        }

        //设置对应的配置信息
        $server->set([
              'worker_num' => $config['worker_num'],
        ]);
        //注册启动事件
        Event::getInstance()->run($server);
        //启动服务
        $server->start();
    }
    //重启服务
    protected static function workerReolad()
    {

    }
    //服务的状态
    protected static function workerStatus()
    {

    }
    //服务关闭
    protected static function workerStop()
    {

    }
    //显示服务信息
    protected static function showMessage()
    {
         echo "Rpc Server is Startting......".PHP_EOL;
    }
}// class end