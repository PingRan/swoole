<?php

class UDP{

    private $server;
    public function __construct()
    {
        $this->server = new Swoole\Server('127.0.0.1', 9501, SWOOLE_PROCESS, SWOOLE_SOCK_UDP);

        //监听数据接收事件
        $this->server->set([
            'worker_num' =>2,
            'max_request' => 50
        ]);

        $this->server->on('Packet',[$this,'Onpacket']);
        $this->server->start();
    }

    public function OnPacket($server, $data, $clientInfo)
    {
        var_dump($clientInfo);

        $this->server->sendto($clientInfo['address'],$clientInfo['port'],'server:'.$data);
    }
}

new UDP();