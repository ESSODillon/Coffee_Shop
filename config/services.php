<?php
/**
 * Author: Michael Auer
 * Date: 7/10/21
 * File: services.php
 * Description: Create the services factory by registering all services within the container
 */

use CoffeeAPI\Controllers\BrandController;
use CoffeeAPI\Controllers\CoffeeController;
use CoffeeAPI\Controllers\SnackController;
use CoffeeAPI\Controllers\ToppingController;
use CoffeeAPI\Controllers\UserController;

// Register controller with the DIC
$container['Brand'] = function ($c) {
    return new BrandController();
};

//Register controller with the DIC
$container['Coffee'] = function($c){
    return new CoffeeController();
};

//Register controller with the DIC
$container['Snack'] = function($c){
    return new SnackController();
};

//Register controller with the DIC
$container['Topping'] = function($c){
    return new ToppingController();
};

$container['User'] = function($c) {
    return new UserController();
};