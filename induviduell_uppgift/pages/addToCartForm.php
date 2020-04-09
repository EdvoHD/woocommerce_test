<?php

// Could not transfer token without form to keep it "safe". So this was the solution..
$productID = (isset($_GET['id']) ? $_GET['id'] : "");
$token     = (isset($_GET['token']) ? $_GET['token'] : "");
echo "<a href='../index.php'>back btn</a> <br />";
echo "<h2>Token: <i>" . $token . "</i></h2>";
echo "<br>";
echo "<h2>Product ID: <i>" . $productID . "</i></h2>";
?>

<h2> Enter the Token and Product ID </h2>
<form action="../cart/addToCart.php" method="POST">

<p>Token:</p>
<input type="text" name="token" placeholder="token.." required /><br />
<p>Product ID:</p>
<input type="text" name="id" placeholder="Product id.." required /><br />

<p>
<input type="submit" name="Add"/>
</p>

</form>



    