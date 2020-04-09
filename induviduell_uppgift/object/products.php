<?php

include("../config/database_handler.php");

class Product {
    private $database_handler;


    public function __construct($database_handler_IN)
    {
        $this->database_handler = $database_handler_IN;
    }

    public function addProduct($p_name, $p_desc, $p_price, $p_size) {
        $return_object = new stdClass();

        if ($this->isProductTaken($p_name) === false) {
            $return = $this->insertProductToDatabase($p_name, $p_desc, $p_price, $p_size);

            if ($return !== false) { // DENNA GER UT FALSE ERROR
                
                $return_object->state = "SUCCESS";
                $return_object->product = $return;

            } else {
                $return_object->state = "ERROR";
                $return_object->message = "Shit's broken... insert and stuff";
            }

        } else {
            $return_object->state = "ERROR";
            $return_object->message = "Product exists already..";
        } // if(isProductTaken) closed


        return json_encode($return_object);

    } // addProduct closed 

    public function insertProductToDatabase($p_name, $p_desc, $p_price, $p_size) {

        $query_string = "INSERT INTO products (prod_name, prod_desc, prod_price, prod_size) VALUES(:prodName, :prodDesc, :prodPrice, :prodSize)";
        $statementHandler = $this->database_handler->prepare($query_string);

        if ($statementHandler !== false) {
            $statementHandler->bindParam(':prodName', $p_name);
            $statementHandler->bindParam(':prodDesc', $p_desc);
            $statementHandler->bindParam(':prodPrice', $p_price);
            $statementHandler->bindParam(':prodSize', $p_size);

            $statementHandler->execute();

            // Fetch list of products 
            $latest_added = $this->database_handler->lastInsertId();
            $query_string = "SELECT id, prod_name, prod_price FROM products WHERE id=:latest_id";
            $statementHandler = $this->database_handler->prepare($query_string);

            $statementHandler->bindParam(':latest_id', $latest_added);
            $statementHandler->execute();

            return $statementHandler->fetch();


        } else {
            return false;
        }
    }

    public function isProductTaken($p_name) {
        $query_string = "SELECT COUNT(id) FROM products WHERE prod_name=:productName";
        $statementHandler = $this->database_handler->prepare($query_string);

        if ($statementHandler !== false) {

            $statementHandler->bindParam(':productName', $p_name);
            $statementHandler->execute();

            $productAmount = $statementHandler->fetch()[0];

            if ($productAmount > 0) {
                return true;
                echo "isProductTaken skickar true";
            } else {
                return false;
                echo "isProductTaken skickar false";
            }

        } else {
            echo "Shit's broken med statementhandler";
            die;
        }
    } // isProductTaken closed


    public function setProductId($product_id) {
        $this->product_id = $product_id;
    }

    public function fetchAllProducts() {
        $query = "SELECT id, prod_name, prod_desc, prod_price, prod_size FROM products";
        $statementHandler = $this->database_handler->prepare($query);

        if ($statementHandler !== false) {

            $statementHandler->bindParam(':product_id', $this->product_id);
            $statementHandler->execute();

            return $statementHandler->fetchAll();

        } else {
            echo "fuck de sket sig";
        }
    }
    public function fetchSingleProduct() {
        $query = "SELECT id, prod_name, prod_desc, prod_price, prod_size FROM products WHERE id=:product_id";
        $statementHandler = $this->database_handler->prepare($query);

        if ($statementHandler !== false) {

            $statementHandler->bindParam(':product_id', $this->product_id);
            $statementHandler->execute();

            return $statementHandler->fetch();

        } else {
            echo "fuck de sket sig";
        }
    }



    public function updateProduct($data_from_POST) {

        //print_r($data_from_POST);

        if (!empty($data_from_POST['prod_name'])) {
           $query = "UPDATE products SET prod_name=:prod_name WHERE id=:product_id";
           $statementHandler = $this->database_handler->prepare($query);

           $statementHandler->bindParam(":prod_name", $data_from_POST['prod_name']);
           $statementHandler->bindParam(":product_id", $data_from_POST['id']);

           $statementHandler->execute();

        }

        if (!empty($data_from_POST['prod_desc'])) {
            $query = "UPDATE products SET prod_desc=:prod_desc WHERE id=:product_id";
            $statementHandler = $this->database_handler->prepare($query);

            $statementHandler->bindParam(":prod_desc", $data_from_POST['prod_desc']);
            $statementHandler->bindParam(":product_id", $data_from_POST['id']);

            $statementHandler->execute();

        }

        if (!empty($data_from_POST['prod_price'])) {
            $query = "UPDATE products SET prod_price=:prod_price WHERE id=:product_id";
            $statementHandler = $this->database_handler->prepare($query);

            $statementHandler->bindParam(":prod_price", $data_from_POST['prod_price']);
            $statementHandler->bindParam(":product_id", $data_from_POST['id']);

            $statementHandler->execute();
        }

        $query = "SELECT id, prod_name, prod_desc FROM products WHERE id=:product_id";
        $statementHandler = $this->database_handler->prepare($query);

        $statementHandler->bindParam(":product_id", $data_from_POST['id']);
        $statementHandler->execute();

        // echo json_encode($statementHandler->fetch());

    } // updateProduct() closed

    public function deleteProduct($product_id) {
        $query = "DELETE FROM products WHERE id=:product_id";
        $statementHandler = $this->database_handler->prepare($query);

        if ($statementHandler !== false) {
            $statementHandler->bindParam(":product_id", $product_id);

            $worked = $statementHandler->execute();

            if ($worked === true) {
                echo "$product_id got deleted! <br />";
                echo "<a href ='../index.php'>Back btn</a>";
            } else {
                echo "Insert went bye bye";
                die;
            }
        }
        
    } // deleteProduct() closed



} // class Product closed 

?>