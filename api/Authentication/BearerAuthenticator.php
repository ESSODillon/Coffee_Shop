<?php
/**
 * Author: Michael Auer
 * Date: 7/25/21
 * File: BearerAuthenticator.php
 * Description: The Bearer Authenticator Class
 */

namespace CoffeeAPI\Authentication;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use CoffeeAPI\Models\Token;

class BearerAuthenticator {
    public function __invoke(Request $request, Response $response, $next) {
        // If the header named "Authorization" does not exist, then return an error
        if(!$request->hasHeader('Authorization')) {
            $results = ['Status' => 'Authorization header not available.'];
            return $response->withJson($results, 404, JSON_PRETTY_PRINT);
        }

        // Retrieve the header and the token
        $auth = $request->getHeader('Authorization');
        $token = substr($auth[0], strpos($auth[0], ' ') + 1);

        // Validate the token
        if (!Token::validateBearer($token)) {
            return $response->withJson(['Status' => 'Authentication failed.'], 401, JSON_PRETTY_PRINT);
        }

        // A user has been authenticated
        $response = $next($request, $response);
        return $response;
    }
}