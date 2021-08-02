<?php
/**
 * Created by PhpStorm.
 * User: zpw
 * Date: 2021/8/1
 * Time: 22:32
 */

namespace Core\http;

use Core\Singleton;
use Swoole\Http\Request;
use Swoole\Http\Response;

/**
 * 路由检测
 * Class Route
 * @package Core\http
 */
class Route
{
    use Singleton;
    //路由初始化
    public function init(Request $request,Response $response)
    {

        // 通过 FastRoute\simpleDispatcher() 方法定义路由，第一个参数必须是 FastRoute\RouteCollector实例
        $dispatcher =  \FastRoute\simpleDispatcher(function (\FastRoute\RouteCollector $r) {
            $r->addRoute('GET', '/', 'index/index');
            //匹配请求规则和路由
            $r->addRoute('GET', '/test', function (){
                return "my test";
            });
            $r->addRoute('GET', '/user', 'user/index');
        });
        //路由匹配和查找
        $myRequest = \Core\http\Request::init($request);
        //检测对应的路由
        $routeInfo = $dispatcher->dispatch($myRequest->getMethod(),$myRequest->getUri());
        //解析路由参数
        $this->parseUrl($routeInfo,$request,$response);
    }
    //路由解析分发数据
    protected function parseUrl($routeInfo,Request $request,Response $response)
    {
        //匹配相应的参数
        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND: //404 错误
                $response->status(404);
                $response->end();
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED: //其他异常错误
                $response->status(405);
                $response->end();
                break;
            case \FastRoute\Dispatcher::FOUND:

                $handler = $routeInfo[1];  //获取方法名称 和对应 匹配参数
                /*print_r($handler);
                $vars = $routeInfo[2];*/
                //返回对应的状态
                $response->status(200);
                //首先判断是否是闭包函数必败函数直接返回
                if($handler instanceof \Closure){

                    return $response->end($handler());
                }
                /*****************匹配对应的控制器******************/
                $handlers = explode('/',$handler);
                //暂时先配置三级目录
                if (count($handlers) < 3)
                {
                     $controller = $handlers[0];
                     $method     = $handlers[1];
                    //首字母大写拼接对应的控制器Controller
                     $controller = ucfirst($controller).'Controller';
                    //命名空间的控制器
                     $controller = '\\App\controllers\\'.$controller;
                     $class = new $controller();
                     // 执行对应的方法
                     $result = $class->$method();
                }else{  //分模块的处理

                }
                $response->end($result);
                break;
        }
    }
}//class end