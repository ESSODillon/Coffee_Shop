<?php
/**
 * Author: James Hicks
 * Date: 7/11/2021
 * File: CoffeeController.php
 * Description:
 */
namespace CoffeeAPI\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use CoffeeAPI\Models\Coffee;

class CoffeeController {
    //List all coffees
    public function index(Request $request, Response $response, array $args){
        $results = Coffee::getCoffee($request);
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }
    //View A Coffee
    public function view($request, $response, array $args){
        $id = $args['id'];
        $results = Coffee::getCoffeeById($id);
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }

    //View a specific coffee
    public function viewCoffee(Request $request, Response $response, array $args){
        $results = Coffee::getCoffeeByBrand($args['brand_id']);
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }
}