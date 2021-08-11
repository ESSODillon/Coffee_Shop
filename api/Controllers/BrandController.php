<?php
/**
 * Author: Michael Auer
 * Date: 7/10/21
 * File: BrandController.php
 * Description: The controller for the Brand
 */

namespace CoffeeAPI\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use CoffeeAPI\Models\Brand;

class BrandController {
    // list all brands
    public function index(Request $request, Response $response, array $args) {
        $results = Brand::getBrands();
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }

    // view a brand
    public function view(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $results = Brand::getBrandById($id);
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }

    // view all coffees by brand
    public function viewCoffees(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $results = Brand::getCoffeesByBrand($id);
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }
}