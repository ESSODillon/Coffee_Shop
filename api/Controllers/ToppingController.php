<?php
/**
 * Author: Dillon Polley
 * Date: 7/11/21
 * File: ToppingController.php
 * Description:
 */

namespace CoffeeAPI\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use CoffeeAPI\Models\Topping;
use CoffeeAPI\Validation\Validator;

class ToppingController {
    //List all toppings
    public function index(Request $request, Response $response, array $args){
        $results = Topping::getToppings($request);
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }
    //View A Topping
    public function view($request, $response, array $args){
        $id = $args['id'];
        $results = Topping::getToppingById($id);
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }

    // Create a topping
    public function create($request, $response, array $args) {
        // Validate the request
        $validation = Validator::validateTopping($request);

        if (!$validation) {
            $results = [
                'status' => "Validation failed.",
                'errors' => Validator::getErrors()
            ];

            return $response->withJson($results, 500, JSON_PRETTY_PRINT);
        }

        //Insert a new topping
        $topping = Topping::createTopping($request);
        $results = [
            'status' => "Topping created",
            'data' => $topping
        ];

        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }

    // Update a topping
    public function update(Request $request, Response $response, array $args) {
        // Validate the request
        $validation = Validator::validateTopping($request);

        // if validation failed
        if (!$validation) {
            $results['status'] = "Validation failed.";
            $results['error'] = Validator::getErrors();
            return $response->withJson($results, 500, JSON_PRETTY_PRINT);
        }

        $topping = Topping::updateTopping($request);
        $status = $topping ? "Topping has been updated." : "Topping can not be updated";
        $status_code = $topping ? 200 : 500;
        $results['status'] = $status;
        if ($topping) {
            $results['data'] = $topping;
        }
        return $response->withJson($results, $status_code, JSON_PRETTY_PRINT);

    }

    // delete a topping
    public function delete($request, $response, array $args) {
        $topping = Topping::deleteTopping($request);
        $status = $topping ? "Topping has been deleted." : "Topping cannot be deleted.";
        $status_code = $topping ? 200 : 500;
        $results = [
            'status' => $status
        ];

        return $response->withJson($results, $status_code, JSON_PRETTY_PRINT);
    }

}