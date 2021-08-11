<?php
/**
 * Author: Michael Auer
 * Date: 7/10/21
 * File: bootstrap.php
 * Description: The bootstrap file
 */

// Load system configuration settings
$config = require __DIR__ . '/config.php';

// Load composer autoload
require __DIR__ . '/../vendor/autoload.php';

// Prepare the app
$app = new \Slim\App(['settings'=>$config]);

// Add dependencies
require __DIR__ . '/dependencies.php';

// Load the service factory
require __DIR__ . '/services.php';

// customer routes
require __DIR__ . '/routes.php';

