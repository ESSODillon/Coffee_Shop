<?php
/**
 * Author: Dillon Polley
 * Date: 7/11/21
 * File: Snack.php
 * Description:
 */

namespace CoffeeAPI\Models;

use Illuminate\Database\Eloquent\Model;

class Snack extends Model {
    //The table associated with this model
    protected $table = 'snacks';

    //The primary key of the table
    protected $primaryKey = 'id';

    //The Primary key is non-numeric
    public $incrementing = false;

    //If the Primary Key is not an integer.
    protected $keyType = 'char';

    //If the created_at and updated_at columns are not used
    public $timestamps = false;

    //Retrieve all snacks
    public static function getSnacks() {
        $snacks = self::all();
        return $snacks;
    }

    //Retrieve a specific snack
    public static function getSnackById(string $id){
        $snack = self::findOrFail($id);
        return $snack;
    }

    public static function searchSnacks($term) {
        if(is_numeric($term)) {
            $query = self::where('price', '>=', $term);
        } else {
            $query = self::where('id', 'like', "%$term%")
                -> orWhere('name', 'like', "%$term%")
                -> orWhere('type', 'like', "%$term%");
        }
        return $query->get();
    }
}