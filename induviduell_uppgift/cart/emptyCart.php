<?php

include("../object/cart.php");
include("../object/products.php");
include("../object/users.php");
$user_handler = new User($databaseHandler);
$cart_handler = new Cart($databaseHandler);

$token =(isset($_GET['token']) ? $_GET['token'] : '');
$cartID = (isset($_GET['id']) ? $_GET['id'] : '');


// Checking id&token calls emptyCart

if(!empty($_GET['token'])) {
    if(!empty($_GET['id'])) {

        $token = $_GET['token'];

        if($user_handler->validateToken($token) === false) {
            $return_object = new stdClass;
            $return_object->error = "Token is invalid";

            echo json_encode($return_object);
            die();
        }
        echo $cart_handler->emptyCart($cartID);

    } else {
        $return_object = new stdClass;
        $return_object->error = "Invalid id";

        echo json_encode($return_object);
    }

} else {
    $return_object = new stdClass;
    $return_object->error = "No token was found";

    echo json_encode($return_object);
}
?>