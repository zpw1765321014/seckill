<?php
/**
 * Created by PhpStorm.
 * User: zpw
 * Date: 2021/8/1
 * Time: 16:36
 */

namespace Core\event;


use Core\http\Route;
use Swoole\Http\Response;

/**
 * 用户的请求和响应
 * Class Request
 * @package Core\event
 */
class Request
{
      public  function run(\Swoole\Http\Request $request,Response $response)
      {
             //初始化 resquest
              \Core\http\Request::init($request);
              //路由注册模块
              Route::getInstance()->init($request,$response);
      }
}