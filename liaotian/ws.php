<?php

class  WS{

    private $ws;
    public function __construct()
    {
        $this->ws = new Swoole\WebSocket\Server('0.0.0.0', 9501);

        $this->ws->set([
            'worker_num' => 2,
            'task_worker_num' => 2
        ]);

        //监听WebSocket连接打开事件
        $this->ws->on('open',[$this,'OnOpen']);
        $this->ws->on('message',[$this,'OnMessage']);
        $this->ws->on('task',[$this,'OnTask']);
        $this->ws->on('finish',[$this,'OnFinish']);
        $this->ws->on('close',[$this,'OnClose']);
        $this->ws->start();
    }

    public function OnTask($ws,$task_id,$from_id,$data)
    {
        sleep(10);
        return $data;
    }

    public function OnFinish($ws,$task_id,$data)
    {
        var_dump('task_id'.$task_id);
        var_dump($data);
        
    }

    public function OnOpen($ws,$request)
    {
        var_dump($request->fd,$request->server);
        $this->ws->push($request->fd, "欢迎客户端：{$request->fd}\n");
    }
    public function OnMessage($ws,$frame)
    {
        if($frame->data == '广播'){
            foreach ( $ws->connections as  $fb){
                $ws->push($fb,'这是通知消息');
            }
        }else{
            echo "信息：{$frame->data}\n";
            foreach ($ws->connections as $fd){
                if($fd == $frame->fd){
                    $ws->task($frame->data);

                    $ws->push($fd,"我：".$frame->data);
                }else{
                    $ws->push($fd,"对方：{$frame->data}");
                }
            }
        }
        
    }

    public function OnClose($ws,$fd)
    {
        echo "客户端：{$fd} 关闭\n";
    }
}

new WS();
