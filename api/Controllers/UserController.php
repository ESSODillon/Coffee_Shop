<?php
/**
 * Author: Michael Auer
 * Date: 7/25/21
 * File: UserController.php
 * Description: The User Controller Class
 */

namespace CoffeeAPI\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use CoffeeAPI\Models\User;
use CoffeeAPI\Validation\Validator;
use CoffeeAPI\Models\Token;

class UserController {
    // List users. The url may contain querystring parameters for login, authenticate with JWT or Bearer token.
    public function index(Request $request, Response $response, array $args)
    {
        $results = User::getUsers();
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }

    // View a specific user by its id
    public function view(Request $request, Response $response, array $args)
    {
        $id = $request->getAttribute('id');
        $results = User::getUserById($id);

        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }


    // Create a user when the user signs up an account
    public function create(Request $request, Response $response, array $args)
    {
        // Validate the request
        $validation = Validator::validateUser($request);

        // If validation failed
        if (!$validation) {
            $results = [
                'status' => "Validation failed",
                'errors' => Validator::getErrors()
            ];
            return $response->withJson($results, 500, JSON_PRETTY_PRINT);
        }

        // Validation has passed; Proceed to create the user
        $user = User::createUser($request);
        $results = [
            'status' => 'user created',
            'data' => $user
        ];
        return $response->withJson($results, 201, JSON_PRETTY_PRINT);
    }

    // Update a user
    public function update(Request $request, Response $response, array $args)
    {
        // Validate the request
        $validation = Validator::validateUser($request);

        // If validation failed
        if (!$validation) {
            $results['status'] = "Validation failed";
            $results['errors'] = Validator::getErrors();
            return $response->withJson($results, 500, JSON_PRETTY_PRINT);
        }

        $user = User::updateUser($request);
        $results = [
            'status' => 'user updated',
            'data' => $user
        ];
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }

    // Delete a user
    public function delete(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        User::deleteUser($id);
        $results = [
            'status' => 'User deleted',
        ];
        return $response->withJson($results, 200);
    }

    // Validate a user with a username and password. It returns a Bearer token on success or error on failure.
    public function authBearer(Request $request, Response $response) {
        // Retrieve username and password from the request body
        $params = $request->getParsedBody();
        $username = $params['username'];
        $password = $params['password'];

        // Verify username and password
        $user = User::authenticateUser($username, $password);

        if (!$user) {
            return $response->withJson(['Status' => 'Login failed.'], 401, JSON_PRETTY_PRINT);
        }

        // Username and password are valid
        $token = Token::generateBearer($user->id);

        $results = ['Status' => 'Login successful.', 'Token' => $token];
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }

    // Validate a user with username and password. It returns a JWT token on success
    public function authJWT(Request $request, Response $response) {
        // Retrieve username and password from the request body
        $params = $request->getParsedBody();
        $username = $params['username'];
        $password = $params['password'];

        // Verify username and password
        $user = User::authenticateUser($username, $password);

        if(!$user) {
            return $response->withJson(['Status' => 'Login failed'], 401, JSON_PRETTY_PRINT);
        }

        // Username and password are valid
        $jwt = User::generateJWT($user->id);
        $results = [
            'Status' => 'Login successful',
            'jwt' => $jwt,
            'name' => $user->name,
            'role' => $user->role
        ];

        // Return the results
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }
}