<?php
// includes
include("../object/products.php");

$product_handler = new Product($databaseHandler);


$product_id =(isset($_GET['id']) ? $_GET['id'] : '');
// callnig on deletePost if we have post id

 if(!empty($product_id)) {
    

        $product_handler->deleteProduct($product_id);

    } else {
        echo "Error with product_id";
    }

   
   

?>