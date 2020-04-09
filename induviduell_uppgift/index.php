<!DOCTYPE html>
<!-- https://server.pingpong.net/courseId/110586/node.do?id=51706397&ts=1585037163869&u=-2140090019 -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ecom page</title>
</head>
<body>
    <style>
        hr {
            border: solid 1px blue;
        }
    </style>
    <div id="app" style="padding: 16px; box-shadow:0px 2px 4px #00000052">
    <h1>Index page</h1>
    <?php

        $page = (isset($_GET['page']) ? $_GET['page'] : '');
        if ($page == "product_created") {
            echo "Product created!";
        }

        include("pages/registerForm.php");
        echo "<br />";

        include("pages/loginForm.php");
        echo "<br />";

        // Demostrating that you can include and also just echo out HTML code

        echo "<h2>Admin View</h2>";
        echo "<form action='http://192.168.64.2/induviduell_uppgift/pages/adminView.php' method='POST'>";
        echo "<input type='text' name='token' placeholder='token..' required>";
        echo "<input type='submit' value='submit and see list'> ";
        echo "</form>  <hr /> ";

        echo "<h2>All Products</h2>";
        echo "<form action='http://192.168.64.2/induviduell_uppgift/products/listProducts.php' method='POST'>";
        echo "<input type='text' name='token' placeholder='token..' required>";
        echo "<input type='submit' value='submit and see list'> ";
        echo "</form>  <hr /> ";

        echo "<h2> View your cart </h2>";
        echo "<form action='http://192.168.64.2/induviduell_uppgift/cart/cartViewer.php' method='POST'>";
        echo "<input type='text' name='token' placeholder='token..' required>";
        echo "<input type='submit' value='submit and see list'> ";
        echo "</form>  <hr /> ";

    ?>
    </div>
</body>
</html>