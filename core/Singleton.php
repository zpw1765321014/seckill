<?php
/**
 * Created by PhpStorm.
 * User: zpw
 * Date: 2021/8/1
 * Time: 16:41
 */

namespace Core;


trait Singleton
{
    private static $instance;

    static function getInstance(...$args)
    {
        if(!isset(self::$instance)){
            self::$instance = new static(...$args);
        }
        return self::$instance;
    }
}