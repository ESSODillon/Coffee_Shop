<?php
/**
 * Author: James Hicks
 * Date: 7/31/2021
 * File: MyAuthenticator.php
 * Description: The MyAuthenticator class authenticates user by username and password in a header.
 */
namespace CoffeeAPI\Authentication;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use CoffeeAPI\Models\User;

class MyAuthenticator{
    //Invoke method allows object to be used as callable. The method gets called automatically when the object is treated as a callable.
    public function __invoke(Request $request, Response $response, $next){
        //Username and password are stored in a header called "CoffeeAPI-Authorization".
        //Value of header is formatted as username:password
        if(!$request->hasHeader('CoffeeAPI-Authorization')){
            $results = ['Status' => 'Authorization header not found.'];
            return $response->withJson($results, 404, JSON_PRETTY_PRINT);
        }

        //Retrieve the header and then the username and password
        $auth = $request->getHeader('CoffeeAPI-Authorization');
        list($username, $password) = explode(':', $auth[0]);

        //Validate the username and password
        if(!User::authenticateUser($username, $password)){
            $results = ['Status' => 'Authentication Failed'];
            return $response->withJson($results, 404, JSON_PRETTY_PRINT);
        }

        //A user has been authenticated
        $response = $next($request, $response);
        return $response;
    }
}