<?php
/**
 * Author: Dillon Polley
 * Date: 7/11/21
 * File: SnackController.php
 * Description: Controller for snacks
 */

namespace CoffeeAPI\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use CoffeeAPI\Models\Snack;

class SnackController {
    //List all snacks
    public function index(Request $request, Response $response, array $args){
        $params = $request->getQueryParams();
        $term = array_key_exists('q', $params) ? $params['q'] : null;

        if(!is_null($term)) {
            $results = Snack::searchSnacks($term);
        } else {
            $results = Snack::getSnacks();
        }
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }

    //View A Snack
    public function view($request, $response, array $args){
        $id = $args['id'];
        $results = Snack::getSnackById($args['id']);
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }
}