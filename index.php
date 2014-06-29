<?php
require 'vendor/autoload.php';

$app = new \Slim\Slim();

// Features
require("./include/cors.php");
require("./include/markdown.php");

// Models
require("./models/gitsm.php");
require("./models/soap.php");

// Controllers
require("./controllers/alerts.php");
require("./controllers/capacity.php");
require("./controllers/devices.php");

// Routes
require("./routes/alerts.php");
require("./routes/capacity.php");
require("./routes/devices.php");
require("./routes/default.php");

$app->run();
?>
