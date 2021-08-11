<?php
/**
 * Author: Dillon Polley
 * Date: 7/11/21
 * File: Topping.php
 * Description:
 */

namespace CoffeeAPI\Models;

use Illuminate\Database\Eloquent\Model;

class Topping extends Model {
    //The table associated with this model
    protected $table = 'toppings';

    //The primary key of the table
    protected $primaryKey = 'id';

    //The Primary key is non-numeric
    public $incrementing = false;

    //If the Primary Key is not an integer.
    protected $keyType = 'char';

    //If the created_at and updated_at columns are not used
    public $timestamps = false;

    //Retrieve all toppings
    public static function getToppings($request) {
       $toppings = self::all();
       return $toppings;
    }

    //view a specific topping
    public static function getToppingById(string $id){
        return self::findOrFail($id);
    }

    // Insert a new topping
    public static function createTopping($request) {
        // Retrieve params from request body
        $params = $request->getParsedBody();

        // Create a new Topping instance
        $topping = new Topping();

        // Set the topping's attributes
        foreach($params as $field => $value) {
            $topping->$field = $value;
        }

        // Insert the field into the db
        $topping->save();
        return $topping;
    }

    // update a topping
    public static function updateTopping($request) {
        // Retrieve parameters from request body
        $params = $request->getParsedBody();

        // Retrieve id from the request body
        $id = $request->getAttribute('id');
        $topping = self::find($id);

        if (!$topping) {
            return false;
        }

        // update attributes of the topping
        foreach($params as $field => $value) {
            $topping->$field = $value;
        }

        // Save the topping into the database
        $topping->save();
        return $topping;
    }

    // Delete a topping
    public static function deleteTopping($request) {
        // Retrieve id from the request
        $id = $request->getAttribute('id');
        $topping = self::find($id);
        return($topping ? $topping->delete() : $topping);
    }

}