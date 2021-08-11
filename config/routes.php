<?php
/**
 * Author: Michael Auer
 * Date: 7/10/21
 * File: routes.php
 * Description: Define routes
 */
use CoffeeAPI\Authentication\{
    BasicAuthenticator,
    BearerAuthenticator,
    JWTAuthenticator,
    MyAuthenticator
};
// Define app routes
$app->get('/', function($request, $response, $args){
    return $response->write('Welcome to the Coffee API, proud data provider for Its A Grind!');
});

// User routes
$app->group('/api/v1/users', function(){
    $this->get('', 'User:index');
    $this->get('/{id}', 'User:view');
    $this->post('', 'User:create');
    $this->put('/{id}', 'User:update');
    $this->delete('/{id}', 'User:delete');
    $this->post('/authBearer', 'User:authBearer');
    $this->post('/authJWT', 'User:authJWT');
});

// Route group
$app->group('/api/v1', function () {

    // The brand group
    $this->group('/brands', function() {
        $this->get('', 'Brand:index');
        $this->get('/{id}', 'Brand:view');
        $this->get('/{id}/coffee', 'Brand:viewCoffees');
        $this->get('/{id}/coffee/{coffee_id}', 'Coffee:view');
    });

    //Route group for coffee
    $this->group('/coffee', function(){
        $this->get('', 'Coffee:index');
        $this->get('/{id}', 'Coffee:view');
    });

    //Route group for snacks
    $this->group('/snacks', function(){
        $this->get('', 'Snack:index');
        //View a snack by id
        $this->get('/{id}', 'Snack:view');
    });

    //Route group for toppings
    $this->group('/toppings', function(){
        $this->get('', 'Topping:index');
        //View a Topping by ID
        $this->get('/{id}', 'Topping:view');
        //Create a topping
        $this->post('', 'Topping:create');
        // Update a topping
        $this->put('/{id}', 'Topping:update');
        // Delete a topping
        $this->delete('/{id}', 'Topping:delete');
    });
//})->add(new MyAuthenticator()); //MyAuthenticator
//})->add(new BasicAuthenticator()); //BasicAuthentication
//})->add(new BearerAuthenticator()); //Bearer Authentication
})->add(new JWTAuthenticator()); //JWT Authentication

