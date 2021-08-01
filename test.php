<?php
//客户端
class client{
    private $service;
    public function __call($name,$param){
        //var_dump($name,$param);
        //远程调用要使用的方法
        if('service'==$name){
            $this->service=$param[0];
            return $this;
        }
        $cli = new swoole_client(SWOOLE_SOCK_TCP);
        $cli->connect('127.0.0.1', 9501);
        $json_data=json_encode(
            [
                'service'=>'UserService',
                'action'=>'index',
                'param'=>'1000',
            ]
        );
        $cli->send($json_data);
        $result=$cli->recv();//接收消息
        $cli->close();
        return json_decode($result,true);
    }
}
$cli = new client();
print_r($cli->service('Cartservice')->cart('1'));
