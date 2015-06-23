<?php

/*
 * Following code will update a product information
 * A product is identified by product id (pid)
 */

// array for JSON response
$response = array();

// check for required fields
if (isset($_POST['pid']) && isset($_POST['name']) && isset($_POST['price']) && isset($_POST['description'])) {
    
    $pid = $_POST['pid'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // include db connect class
    require_once __DIR__ . '/db_connect.php';

    try {
        // connecting to db
        $con = new DB_CONNECT();
        $db = $con->connect();

        // mysql update row with matched pid
        $result = $db->prepare("UPDATE products SET name = :name, price = :price, description = :description WHERE pid = :pid");

        $result->bindParam(":name", $name);
        $result->bindParam(":price", $price);
        $result->bindParam(":description", $description);
        $result->bindParam(":pid", $pid);

        $result->execute();

        // check if row inserted or not
        if ($result) {
            // successfully updated
            $response["success"] = 1;
            $response["message"] = "Product successfully updated.";
            
            // echoing JSON response
            echo json_encode($response);
        } else {
            
        }
    } catch(PDOException $e){
        print "Sorry, a database error occurred. Please try again later";
        print $e->getMessage();
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    // echoing JSON response
    echo json_encode($response);
}
?>
