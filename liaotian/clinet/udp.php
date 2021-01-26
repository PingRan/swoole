<?php

go(function(){
    $client = new Swoole\Coroutine\Client(SWOOLE_SOCK_UDP);
    if (!$client->connect('127.0.0.1', 9501,SWOOLE_PROCESS,SWOOLE_SOCK_UDP))
    {
        echo "connect failed. Error: {$client->errCode}\n";
    }
    fwrite(STDOUT,"请输入");
    $res = fgets(STDIN);
    $client->send($res);
    echo $client->recv();
    $client->close();
});
