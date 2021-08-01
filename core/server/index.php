<?php
//引入自动加载类
require __DIR__.'/vendor/autoload.php';

use Swoole\Http\Request;
use Swoole\Http\Response;

$http = new Swoole\Http\Server("0.0.0.0", 9501);
/**
 * 创建路由分发
 */
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    //匹配请求规则和路由
    $r->addRoute('GET', '/test', function (){

        return "my test";
    });

});

$http->on('request', function (Request $request, Response$response) use($dispatcher){

    $myrequest = \App\core\Request::init($request);

    $routeInfo = $dispatcher->dispatch($myrequest->getMethod(),$myrequest->getUri());
    //匹配相应的参数
    switch ($routeInfo[0]) {
        case FastRoute\Dispatcher::NOT_FOUND:

            $response->status(404);
            $response->end();
            break;
        case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
            $response->status(405);
            $response->end();
            break;
        case FastRoute\Dispatcher::FOUND:

            $handler = $routeInfo[1];  //获取方法名称
            //$vars = $routeInfo[2];
            var_dump($request->get);
            $response->status(200);
            $response->end($handler());
            break;
    }

});

$http->start();