<?php
$server  =  new Swoole\Server('0.0.0.0',9501);

$server->set(
    ['daemonize' => true]
);

$server->on('Connect', function ($server,$fd){
    echo "Client:Connect.\n";
});

$server->on('Receive', function ($server,$fd,$from_id,$data){
    $server->send($fd,"Server :".$data);
});

$server->on('Close',function ($server, $fd){
    echo "Close";
});

$server->start();