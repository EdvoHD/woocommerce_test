<?php 

// Saving token and which product you're on.
$product_id = (!empty($_GET['id']) ? $_GET['id'] : -1);
$token = (!empty($_GET['token']) ? $_GET['token'] : "");

?>
<h1>Update your product with this form!</h1>
<form action="http://192.168.64.2/induviduell_uppgift/products/updateProduct.php?id=<?php echo $product_id; ?>&token=<?php echo $token;?>" method="post">
    <input type="hidden" name="id" value="<?php echo $product_id ?> ">
    <input type="text" name="prod_name" placeholder="name...">
    <textarea type="text" name="prod_desc" placeholder="desc..."></textarea>
    <input type="text" name="prod_price" placeholder="price...">
    <select name="prod_size">
        <option value="S">SMALL</option>
        <option value="M">MEDIUM</option>
        <option value="L">LARGE</option>
        <option value="no-size">NO-SIZE</option>
    </select>
    <input type="submit" value="SUBMIT">
</form>