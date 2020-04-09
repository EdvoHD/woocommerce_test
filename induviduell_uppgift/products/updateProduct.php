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
            $return_object->errorCode = 1338;
            echo json_encode($return_object);
            die;
        }

        $product_handler->updateProduct($_POST);

    } else {
        $return_object = new stdClass;
        $return_object->error = "invalid id u cunt";
        $return_object->errorCode = 1111;

        echo json_encode($return_object);
    }

} else {
    $return_object = new stdClass;
    $return_object->error = "no token found!";
    $return_object->errorCode = 1231;

    echo json_encode($return_object);
}
echo "Updated!";
echo "<a href='../index.php'>back btn</a>";


?>