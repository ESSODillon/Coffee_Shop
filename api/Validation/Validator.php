<?php
/**
 * Author: Michael Auer
 * Date: 7/19/21
 * File: Validator.php
 * Description: Handles validation for objects in the api
 */

namespace CoffeeAPI\Validation;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator
{
    private static $errors = [];

    // a generic validation method. It returns true on success or false on failure.
    public static function validate($request, array $rules)
    {
        foreach ($rules as $field => $rule) {
            //Retrieve parameters from url or the request body
            $param = $request->getAttribute($field) ?? $request->getParam($field);
            try {
                $rule->setName(ucfirst($field))->assert($param);
            } catch (NestedValidationException $ex) {
                self::$errors[$field] = $ex->getMessage();
            }
        }

        return empty(self::$errors);
    }

    // validate attributes of a topping object
    public static function validateTopping($request)
    {
        // Define all the validation rules
        $rules = [
            'name' => v::alnum(' '),
            'price' => v::number()
        ];

        return self::validate($request, $rules);
    }

    // Validate attributes of a User model. Do not include fields having default values (id, role, etc.)
    public function validateUser($request) {
        $rules = [
            'name' => v::alnum(' '),
            'email' => v::email(),
            'username' => v::notEmpty(),
            'password' => v::notEmpty()
        ];

        return self::validate($request, $rules);
    }

    // Return the errors in an array
    public static function getErrors()
    {
        return self::$errors;
    }
}