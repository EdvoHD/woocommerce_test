<?php
include("../object/products.php");
include("../object/users.php");
include("../object/cart.php");

$cart_handler = new Cart($databaseHandler);

if(!empty($_POST['token'])) {

 echo $_POST['token'];
 echo "<br>";

    if(!empty($_POST['id'])) { 

       
        echo $cart_handler->addToCart( $_POST['token'], $_POST['id']);

    } else {
        echo "Invalid id!";
    }

} else { 
    echo "No token found!";
}

?>