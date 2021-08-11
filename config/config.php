<?php
/**
 * Author: Michael Auer
 * Date: 7/10/21
 * File: config.php
 * Description: configuration file
 */

return [
    // display error details in the development environment
    'displayErrorDetails' => true,

    // database connection details
    'db' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'database' => 'coffee_shop',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => ''
    ]
];