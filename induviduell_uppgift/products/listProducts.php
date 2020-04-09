<a href="../index.php">Go back</a>
<br />
<?php

    include("../object/products.php");
    include("../object/users.php");

    $product_object = new Product($databaseHandler);
    $user_handler = new User($databaseHandler);

   //$token = (isset($_POST['token']) ? $_POST(['token']): "");
   $token = $_POST['token'];

   if ($token === null) {
       echo "token doesn't exist";
   } else {

    print_r($_POST['token']);


    if ($user_handler->validateToken($token) === false) {
        echo "<br />";
        echo "Your token sucks!";
        die;
    }

    foreach($product_object->fetchAllProducts() as $products) {
        echo "<div id='product-item' style='border: solid 2px black;padding:8px 4px; width: 50%;margin:16px auto;'>";

        echo "<span><h3>" . " " . $products['prod_name'] . "</h3></span> <br />";
        echo "<span>" . " " . $products['prod_desc'] . "</span> <br />";
        echo "<span>" . " " . $products['prod_price'] . "</span> <br />";
        echo "<a href='getProduct.php?id={$products['id']}&token=$token'>product details</a>";


        echo "</div>";
    }

   } // else closed





?>