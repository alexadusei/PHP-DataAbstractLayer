<?php

/*
 * Following code will list all the products
 */

// array for JSON response
$response = array();

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
try {
    $con = new DB_CONNECT();
    $db = $con->connect();

    $query = "SELECT * FROM products";

    // get all products from products table
    $rows = $db->query($query);

    // check for empty result
    if ($rows->rowCount() > 0) {
        // looping through all results
        // products node
        $response["products"] = array();
        
        foreach ($rows as $row) {
            // temp user array
            $product = array();
            $product["pid"] = $row["pid"];
            $product["name"] = $row["name"];
            $product["price"] = $row["price"];
            $product["description"] = $row["description"];
            $product["created_at"] = $row["created_at"];
            $product["updated_at"] = $row["updated_at"];

            // push single product into final response array
            array_push($response["products"], $product);
        }
        // success
        $response["success"] = 1;

        // echoing JSON response
        echo json_encode($response);
    } else {
        // no products found
        $response["success"] = 0;
        $response["message"] = "No products found";

        // echo no users JSON
        echo json_encode($response);
    }
} catch (PDOException $ex){
    print "Sorry, a database error occurred. Please try again later.";
    print $ex->getMessage();
}
?>
