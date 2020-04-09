<?php

    include("../object/products.php");
    include("../object/users.php");

    $product_handler = new Product($databaseHandler);
    $user_handler = new User($databaseHandler);

    $productID = (!empty($_GET['id']) ? $_GET['id'] : -1 );

    $token = (!empty($_GET['token']) ? $_GET['token'] : "" );
    if ($user_handler->validateToken($token) === false) {
        echo "<br />";
        echo "invalid token!";
        die;
    }

    // sätter först product id
     $product_handler->setProductId($productID);

     // inuti denna funktion så hämtas även den productid
     $product = $product_handler->fetchSingleProduct();
     // print_r($product);


     echo "<div id='singlepost-container'> ";

     echo "<a href='../index.php'>Back btn</a> ";
    
     echo "<h3> Product name: " . $product['prod_name'] . "</h3>";
     echo "<span> price: " . $product['prod_price'] . "</span>";
     echo "<p> Description: <br />" . $product['prod_desc'] . "</p>";
     echo "<p> Size: <br />" . $product['prod_size'] . "</p>";

     echo "<a href='../pages/addToCartForm.php?id={$product['id']}&token=$token'>Add to cart</a>";
     echo "<hr />";

    // Giving Admins more options for the product, in this case you can update and delete the product as an admin.
     $isAdmin = $user_handler->isAdmin($token);
     if ($isAdmin === true) {
        echo "<a href='../pages/updateProductForm.php?id={$product['id']}&token={$token}'>Update this Product <br />";
        echo "<a href='deleteProduct.php?id={$product['id']}'> Delete product </a>";
     }


     echo "</div>";

?>