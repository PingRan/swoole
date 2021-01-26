<?php

class  WS{

    private $ws;
    public function __construct()
    {
        $this->ws = new Swoole\WebSocket\Server('0.0.0.0', 9501);

        //监听WebSocket连接打开事件
        $this->ws->on('open',[$this,'OnOpen']);
        $this->ws->on('message',[$this,'OnMessage']);
        $this->ws->on('close',[$this,'OnClose']);
        $this->ws->start();
    }

    public function OnOpen($ws,$request)
    {
        var_dump($request->fd,$request->server);
        $this->ws->push($request->fd, "欢迎客户端：{$request->fd}\n");
    }
    public function OnMessage($ws,$frame)
    {
        echo "信息：{$frame->data}\n";
        foreach ($ws->connections as $fd){
                if($fd == $frame->fd){
                    $ws->push($fd,"我：".$frame->data);
                }else{
                    $ws->push($fd,"对方：{$frame->data}");
                }
        }
    }

    public function OnClose($ws,$fd)
    {
        echo "客户端：{$fd} 关闭\n";
    }
}

new WS();
