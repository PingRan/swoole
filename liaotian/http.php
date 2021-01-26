<?php

class HTTP{

    private $http;
    public function __construct()
    {
        $this->http = new Swoole\Http\Server('0.0.0.0', 9501);
        $this->http->set([
            'enable_static_handler' => true,
            'document_root' => '/usr/share/nginx/html/php-swoole/liaotian/static'
        ]);
        $this->http->on('request',[$this,'OnRequest']);
        $this->http->start();
    }

    public function OnRequest($request,$response)
    {
        var_dump($request->server);
        $response->header("Content-Type", "text/html; charset=utf-8");
        $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");
    }
}