<?php 

include("../object/cart.php");
include("../object/products.php");
include("../object/users.php");

$cart_handler = new Cart($databaseHandler);
$user_handler = new User($databaseHandler);


$token = (isset($_GET['token']) ? $_GET['token'] : '');

if(!empty($_GET['token'])) {
        $token = $_GET['token'];

        if($user_handler->validateToken($token) === false) {
            $return_object = new stdClass;

            $return_object->error = "Token is invalid";
            echo json_encode($return_object);
            die();
        }
        echo $test = $cart_handler->checkoutOrder($token);

        // Empties the cart afterwards
        echo $cart_handler->emptyCartAfterCheckout($token);
        
        

} else {
    $return_object = new stdClass;
    $return_object->error = "No token found";

    echo json_encode($return_object);
}

  
   

?>