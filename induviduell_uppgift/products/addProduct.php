<?php

    include("../object/products.php");

    $product_handler = new Product($databaseHandler);

    echo $product_handler->addProduct($_POST['p_name'], $_POST['p_desc'], $_POST['p_price'], $_POST['p_size']);

   header("location:../index.php?page=product_created");


?>