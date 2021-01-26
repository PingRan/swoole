<?php

go(function(){
    $client = new Swoole\Coroutine\Client(SWOOLE_SOCK_TCP);
    if (!$client->connect('127.0.0.1', 9501, 0.5))
    {
        echo "connect failed. Error: {$client->errCode}\n";
    }
    fwrite(STDOUT,"请输入");
    $res = fgets(STDIN);
    $client->send($res);
    echo $client->recv();
    $client->close();
});
