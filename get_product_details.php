<?php

/*
 * Following code will get single product details
 * A product is identified by product id (pid)
 */

// array for JSON response
$response = array();


// include db connect class
require_once __DIR__ . '/db_connect.php';

try{
    // connecting to db
    $con = new DB_CONNECT();
    $db = $con->connect();

    // check for post data
    if (isset($_GET["pid"])) {
        $pid = $_GET["pid"];

        // get a product from products table using PDO prepared statement
        $result = $db->prepare("SELECT * FROM products WHERE pid = :pid");
        $result->bindParam(":pid", $pid); // bind the values individually
        //execute will execute db command with binded variables. Becaise we
        // binded first, the parameters for eceute() can be empty
        $result->execute();

        if (!empty($result)) {
            // check for empty result
            if ($result->rowCount() > 0) {

                $result = $result->fetch();

                $product = array();
                $product["pid"] = $result["pid"];
                $product["name"] = $result["name"];
                $product["price"] = $result["price"];
                $product["description"] = $result["description"];
                $product["created_at"] = $result["created_at"];
                $product["updated_at"] = $result["updated_at"];
                // success
                $response["success"] = 1;

                // user node
                $response["product"] = array();

                array_push($response["product"], $product);

                // echoing JSON response
                echo json_encode($response);
            } else {
                // no product found
                $response["success"] = 0;
                $response["message"] = "No product found";

                // echo no users JSON
                echo json_encode($response);
            }
        } else {
            // no product found
            $response["success"] = 0;
            $response["message"] = "Empty result";

            // echo no users JSON
            echo json_encode($response);
        }
    } else {
        // required field is missing
        $response["success"] = 0;
        $response["message"] = "Required field(s) is missing";

        // echoing JSON response
        echo json_encode($response);
    }
} catch(PDOException $e){
    print "Sorry, a database error occurred. Please try again later.\n";
    print $e->getMessage();
}
?>