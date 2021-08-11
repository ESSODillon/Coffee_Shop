<?php
/**
 * Author: James Hicks
 * Date: 7/11/2021
 * File: Coffee.php
 * Description: The Coffee Model Class
 */
namespace CoffeeAPI\Models;

use Illuminate\Database\Eloquent\Model;

class Coffee extends Model {
    //The table associated with this model
    protected $table = 'coffee';

    //The primary key of the table
    protected $primaryKey = 'id';

    //The Primary key is non-numeric
    public $incrementing = false;

    //If the Primary Key is not an integer.
    protected $keyType = 'char';

    //If the created_at and updated_at columns are not used
    public $timestamps = false;

    // set up the relation between coffee and brand. A coffee belongs to a brand.
    public function brand() {
        return $this->belongsTo('CoffeeAPI\Models\Brand', 'brand_id');
    }

    //Retrieve all coffees
    public static function getCoffee($request) {
//        $coffees = self::all();
//        return $coffees;

        /********************* code for pagination ********************/
        // get the total number of row count
        $count = self::count();

        //get query string variable from URL
        $params = $request->getQueryParams();

        // do limit and offset
        $limit = array_key_exists('limit', $params) ? (int)$params['limit'] : 10;  // items per page
        $offset = array_key_exists('offset', $params) ? (int)$params['offset'] : 0;  // offset of the first item

        // pagination
        $links = self::getLinks($request, $limit, $offset);

        //sorting
        $sort_key_array = self::getSortKeys($request);

        // build query
        $query = self::with('brand')->skip($offset)->take($limit); // limit the rows

        //sort the output by one or more columns
        foreach($sort_key_array as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        $courses = $query->get(); // Finally, run the query and get the results

        // construct the data for response
        $results = [
            'totalCount' => $count,
            'limit' => $limit,
            'offset' => $offset,
            'links' => $links,
            'sort' => $sort_key_array,
            'data' => $courses
        ];

        return $results;


    }

    //Retrieve a specific coffee
    public static function getCoffeeById(string $id){
        $coffee = self::findOrFail($id);
        $coffee->load('brand');
        return $coffee;
    }

    //View coffees by brand
    public static function getCoffeeByBrand(string $brand_id){
        $coffees = self::findOrFail($brand_id)->brands;
        return $coffees;
    }

    // This function returns an array of links for pagination. The array includes links for the current, first, next, and last pages.
    private static function getLinks($request, $limit, $offset) {
        $count = self::count();

        // Get request uri and parts
        $uri = $request->getUri();
        $base_url = $uri->getBaseUrl();
        $path = $uri->getPath();

        // Construct links for pagination
        $links = array();
        $links[] = ['rel' => 'self', 'href' => $base_url . "/" . $path . "?limit=$limit&offset=$offset"];
        $links[] = ['rel' => 'first', 'href' => $base_url . "/" . $path . "?limit=$limit&offset=0"];
        if ($offset - $limit >= 0) {
            $links[] = ['rel' => 'prev', 'href' => $base_url . "/" . $path . "?limit=$limit&offset=" . ($offset - $limit)];
        }
        if ($offset + $limit < $count) {
            $links[] = ['rel' => 'next', 'href' => $base_url . "/" . $path . "?limit=$limit&offset=" . ($offset + $limit)];
        }
        $links[] = ['rel' => 'last', 'href' => $base_url . "/" . $path . "?limit=$limit&offset=" . $limit * (ceil($count / $limit) - 1)];

        return $links;
    }
    /*
         * Sort keys are optionally enclosed in [ ], separated with commas;
         * Sort directions can be optionally appended to each sort key, separated by :.
         * Sort directions can be 'asc' or 'desc' and defaults to 'asc'.
         * Examples: sort=[number:asc,title:desc], sort=[number, title:desc]
         * This function retrieves sorting keys from uri and returns an array.
        */
    private static function getSortKeys($request) {
        $sort_key_array = array();

        // Get querystring variables from url
        $params = $request->getQueryParams();

        if (array_key_exists('sort', $params)) {
            $sort = preg_replace('/^\[|\]$|\s+/', '', $params['sort']);  // remove white spaces, [, and ]
            $sort_keys = explode(',', $sort); //get all the key:direction pairs
            foreach ($sort_keys as $sort_key) {
                $direction = 'asc';
                $column = $sort_key;
                if (strpos($sort_key, ':')) {
                    list($column, $direction) = explode(':', $sort_key);
                }
                $sort_key_array[$column] = $direction;
            }
        }

        return $sort_key_array;
    }

}