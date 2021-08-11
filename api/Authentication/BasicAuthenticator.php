<?php
/**
 * Author: Michael Auer
 * Date: 7/25/2021
 * File: BasicAuthenticator.php
 * Description: The Basic Authenticator class
 */
namespace CoffeeAPI\Authentication;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use CoffeeAPI\Models\User;

class BasicAuthenticator{
    public function __invoke(Request $request, Response $response, $next){
        // The username and password are sent in a header called "Authorization" in the format
        // Basic username:password. Username and password are encoded.
        if (!$request->hasHeader('Authorization')) {
            $results = ['Status' => 'Authorization header not found.'];
            return $response->withJson($results, 404, JSON_PRETTY_PRINT);
        }

        $auth = $request->getHeader('Authorization');
        $apikey = substr($auth[0], strpos($auth[0], ' ') + 1);

        // Get the username and password
        list($username, $password) = explode(':', base64_decode($apikey));

        // Authenticate the user
        if (!User::authenticateUser($username, $password)) {
            $results = ['Status' => 'Authentication failed.'];
            return $response->withHeader('WWW-Authenticate', 'Basic realm="CoffeeAPI API"')
                ->withJson($results, 401, JSON_PRETTY_PRINT);
        }

        // User has been authenticated
        $response = $next($request, $response);
        return $response;
    }
}
