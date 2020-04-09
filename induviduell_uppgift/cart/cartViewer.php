<?php

include("../object/products.php");
include("../object/users.php");
include("../object/cart.php");
//$token = $_POST['token'];

$token = (isset($_POST['token']) ? $_POST['token'] : '');

$cart_handler = new Cart($databaseHandler);

echo "<a href='../index.php'>back btn</a> <br />";
echo "token: " . $token;

if (!empty($cart_handler->fetchCustomerCart($token))) {
    echo "true";
    foreach($cart_handler->fetchCustomerCart($token) as $cartList) {
        echo "<br />";
        echo "<h3>Product name: " . " " . $cartList['prod_name'] . "</h3> <br />";
        echo "<span>Price: " . " " . $cartList['prod_price'] . "</span> <br />";
        echo "<a href='emptyCart.php?id={$cartList['id']}&token={$token}'> Remove this product from your cart</a>";
        echo "<hr />";
    }

    echo "<a href='checkout.php?id={$cartList['id']}&token={$token}'> Checkout</a> ";
} else {
    echo "<br />";
    echo "Cart is empty!";
}







?>