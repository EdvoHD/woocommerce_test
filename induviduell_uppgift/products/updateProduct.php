<?php 

include("../object/products.php");
include("../object/users.php");

$product_handler = new Product($databaseHandler);
$user_handler = new User($databaseHandler);

$product_id = (!empty($_GET['id']) ? $_GET['id'] : -1);

$token = (!empty($_GET['token']) ? $_GET['token'] : "");

if (!empty($_GET['token'])) {

    if (!empty($_GET['id'])) {

        $token = $_GET['token'];

        if ($user_handler->validateToken($token) === false) {
            $return_object = new stdClass;
            $return_object->error = "Token not valid";
            echo json_encode($return_object);
            die;
        }

        $product_handler->updateProduct($_POST);

    } else {
        $return_object = new stdClass;
        $return_object->error = "invalid id";

        echo json_encode($return_object);
    }

} else {
    $return_object = new stdClass;
    $return_object->error = "no token found!";

    echo json_encode($return_object);
}

echo "<a href='../index.php'>back btn</a> <br />";
echo " Product Updated!";


?>