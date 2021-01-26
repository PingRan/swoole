<?php


class TCP{

    private $server;

    public function __construct()
    {
        $this->server = new Swoole\Server('127.0.0.1', 9501,SWOOLE_PROCESS);#监听本机9501端口

        $this->server->set(array(
            'worker_num'    => 2,     // worker process num 进程数
            'max_request'   => 50,//最大连接数
        ));

        //监听连接进入事件
        $this->server->on('Connect', [$this,'OnConnect']);
        //监听数据接收事件
        $this->server->on('Receive',[$this,'OnReceive']);
        //关闭连接时候的事件
        $this->server->on('Close',[$this,'OnClose']);
        //开启服务
        $this->server->start();
    }

    public function OnConnect($server,$fd)
    {
        echo "客户端id：{$fd}.\n";
    }

    public function OnReceive($server,$fd,$from_id,$data)
    {
        $this->server->send($fd,"服务端：".$data);
    }

    public function OnClose($server,$fd)
    {
        echo "客户端关闭的id{$fd}.\n";
    }


}

new TCP();