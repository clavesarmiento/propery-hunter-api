<?php
require_once '../vendor/autoload.php';
require_once '../src/config/db.php';
require_once '../src/config/app.php';
require_once '../src/config/json.php';

// Run the server application through the WebSocket protocol on port 8080
App\App::initialize();

// use Illuminate\Database\Capsule\Manager as Capsule;