<?php 

include("../config/database_handler.php");

class Cart {
    private $database_handler;
    private $cartID;

    public function __construct($database_handler_IN)
    {
        $this->database_handler = $database_handler_IN;
    }

    public function setCardId($cartID) {
        $this->cartID = $cartID;
    }

    public function fetchCustomerCart($token) {
        $query = "SELECT * from cart JOIN products on products.id = cart.productID WHERE token=:token";
        $statementHandler = $this->database_handler->prepare($query);

        if ($statementHandler !== false) {
            $statementHandler->bindParam(":token", $token);
            $statementHandler->execute();

            return $statementHandler->fetchAll();
        } else {
            echo "Failed to recieve database list";
            die;
        }
    } // fetchCustomerCart() closed

    public function addToCart($token, $productID) {
        $query = "INSERT INTO cart (token, productID) VALUES (:token, :productID)";
        $statementHandler = $this->database_handler->prepare($query);

        if ($statementHandler !== false) {
            $statementHandler->bindParam(":token", $token);
            $statementHandler->bindParam(":productID", $productID);

            $worked = $statementHandler->execute();

            if ($worked === true) {
                echo "Product Added to cart! <br />";
                echo "<a href='../index.php'>Back btn</a>";
                // header productAdded.php)
            } else {
                echo "Failed to insert!";
            }

        } else {
            echo "Could not create statement";
            die;
        }
    } // addToCart closed 

    public function emptyCart($cartID) {
        $query = "DELETE FROM cart WHERE productID=:cartID";
        $statementHandler = $this->database_handler->prepare($query);

        if ($statementHandler !== false) {
            $statementHandler->bindParam(":cartID", $cartID);

            $worked = $statementHandler->execute();

            if ($worked === true) {

                echo "<a href='../index.php'>Back btn</a> <br/>";
                echo "item removed from cart!";

            } else {
                echo "Error with deletion!";
            }
        } else {
            echo "Could not create statement! from database";
            die;
        }
    } // emptyCart closed

    public function checkoutOrder($token) {
        $query = "INSERT INTO checkout SELECT * FROM cart WHERE token=:token";
        $statementHandler = $this->database_handler->prepare($query);

        if ($statementHandler !== false) {
            $statementHandler->bindParam(":token", $token);

            $worked = $statementHandler->execute();

            // True = order complete
            if ($worked === true) {
                echo "<a href='../index.php'>Back btn</a> <br />";
                echo "Order complete! <br />";
            } else {
                echo "Error with insert to database";
            }
        } else {
            echo "Database statment not created";
            die;
        }
    } // checkoutOrder() closed

    public function emptyCartAfterCheckout($token) {
        $query = "DELETE FROM cart WHERE token=:token";
        $statementHandler = $this->database_handler->prepare($query);

        if ($statementHandler !== false) {
            $statementHandler->bindParam(":token", $token);

            $worked =$statementHandler->execute();

            // if true, empty the cart else error
            if ($worked === true) {
                //echo "successfully emptied cart after checkout! <br />";
            } else {
                echo "Error with the removal of cart in database";
            }
        } else {
            echo "Database statemnt not created";
        }


    } // emptyCartAfterCheckout closed



} // class Cart closed

?>