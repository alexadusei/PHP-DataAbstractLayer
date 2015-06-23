<?php

/*
 * Following code will delete a product from table
 * A product is identified by product id (pid)
 */

// array for JSON response
$response = array();

// check for required fields
if (isset($_POST['pid'])) {
    $pid = $_POST['pid'];

    // include db connect class
    require_once __DIR__ . '/db_connect.php';

    try{
        // connecting to db
        $con = new DB_CONNECT();
        $db = $con->connect();

        // mysql update row with matched pid
        $result = $db->prepare("DELETE FROM products WHERE pid = :pid");

        $result->bindParam(":pid", $pid);
        $result->execute();
             
        // check if row deleted or not
        if ($result->rowCount() > 0) {
            // successfully updated
            $response["success"] = 1;
            $response["message"] = "Product successfully deleted";

            // echoing JSON response
            echo json_encode($response);
        } else {
            // no product found
            $response["success"] = 0;
            $response["message"] = "No product found";

            // echo no users JSON
            echo json_encode($response);
        }
    } catch (PDOException $e){
        // no product found
        $response["success"] = 0;
        $response["message"] = "An error occurred";

        // echoing JSON response
        echo json_encode($response);

        echo "A database error occurred";
        echo $e->getMessage();
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    // echoing JSON response
    echo json_encode($response);
}
?>