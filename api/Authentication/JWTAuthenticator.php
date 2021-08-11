<?php
/**
 * Author: Dillon Polley
 * Date: 7/27/21
 * File: JWTAuthenticator.php
 * Description: The JWT Authenticator class
 */

namespace CoffeeAPI\Authentication;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use CoffeeAPI\Models\User;

class JWTAuthenticator {
    public function __invoke(Request $request, Response $response, $next)
    {
        // If the header named "Authorization" does not exist, returns an error
        if(!$request->hasHeader('Authorization')) {
            $results = ['Status' => 'Authorization header not available'];
            return $response->withJson($results, 404, JSON_PRETTY_PRINT);
        }

        // Retrieve the header and the token
        $auth =  $request->getHeader('Authorization');
        $token = substr($auth[0], strpos($auth[0], ' ') + 1);

        // Validate the token
        if(!User::validateJWT($token)) {
            return $response->withJson(['Status' => 'Authentication failed.'], 401, JSON_PRETTY_PRINT);
        }

        // A user has been authenticated
        $response = $next($request, $response);
        return $response;
    }
}