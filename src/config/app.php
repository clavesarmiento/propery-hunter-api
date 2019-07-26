<?php

namespace App;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use App\Helper\JSON;
use Ratchet\App as RatchetApp;
use Ratchet\Server\EchoServer;

class App implements MessageComponentInterface {

    protected $clients;
    protected $origin;

    public function __construct() {
        self::requireAllModels();
        self::requireAllControllers();
        $this->clients = new \SplObjectStorage;
    }

    public function initialize() {
        echo 'Server Running...';
        $app = new RatchetApp('localhost', 8080);
        $app->route('/chat', new App, array('*'));
        $app->route('/echo', new EchoServer, array('*'));
        $app->run();
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $this->origin = $from;
        $data = JSON::decode($msg);

        $method = explode('/', $data->method);
        $ctrl = new $method[0]($data, $this);
        $msg = $ctrl->{$method[1]}();
    }

    public function onClose(ConnectionInterface $conn) {
        $this->sendToAll('Server Error', ['ApiServer', 'disconnected']);
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }

    public function sendToClientsExceptOrigin($method, $msg) {
         $data = [
            'method' => $method,
            'response' => $msg,
        ];

        foreach ($this->clients as $client) {
               if ($this->origin != $client) {
                   $client->send(JSON::encode($data));
               }
           }
    }

    public function sendToAll($method, $msg) {
        $data = [
            'method' => $method,
            'response' => $msg,
        ];

        foreach ($this->clients as $client) {
                $client->send(JSON::encode($data));
        }
    }

    public function sendToOrigin($method, $msg) {
         $data = [
            'method' => $method,
            'response' => $msg,
        ];

        foreach ($this->clients as $client) {
               if ($this->origin == $client) {
                   $client->send(JSON::encode($data));
               }
           }
    }

    private static function requireAllControllers() {
        foreach (scandir('../src/controller') as $ctrl){
            if(stripos($ctrl, '.php')) {
                include_once '../src/controller/'.$ctrl;
            }
        }
    }

    private static function requireAllModels() {
        foreach (scandir('../src/model') as $model){
            if(stripos($model, '.php')) {
                include_once '../src/model/'.$model;
            }
        }
    }
}

