<?php
/**
 * Author: Michael Auer
 * Date: 7/10/21
 * File: Brand.php
 * Description: the brand model class
 */

namespace CoffeeAPI\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model {
    // The table associated with this model
    protected $table = 'brands';

    //the primary key of the table
    protected $primaryKey = 'id';

    //The PK is non-numeric
    public $incrementing = false;

    // If the PK is not an integer, set its type
    protected $keyType = 'char';

    // If the created_at and updated_at columns are not used
    public $timestamps = false;

    //Set the one to many relation between Brand and Coffee
    // The first param is coffee name. The second param is the foreign key
    public function coffees() {
        return $this->hasMany('CoffeeAPI\Models\Coffee', 'brand_id');
    }

    // Retrieve all brands
    public static function getBrands() {
        // Retrieves Brands without coffees
//        $brands = self::all();
        $brands = self::with('coffees')->get(); // TODO: returning empty array
        return $brands;
    }

    // Retrieve a specific brand
    public static function getBrandById(string $id) {
        $brand = self::findOrFail($id);
        $brand->load('coffees');
        return $brand;
    }

    // View all coffees by brand
    public static function getCoffeesByBrand(string $id) {
        $coffees = self::findOrFail($id)->coffees;
        return $coffees;
    }
}