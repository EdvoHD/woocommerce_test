<h2>Create Product</h2>
<form action="http://192.168.64.2/induviduell_uppgift/products/addProduct.php" method="POST">
    <input type="text" name="p_name" placeholder="product name..." required> <br />
    <textarea name="p_desc" placeholder="description.." required></textarea> <br />
    <input type="number" name="p_price" placeholder="price.." id="price_div" required> <br />

    <select name="p_size">
        <option value="S">Small</option>
        <option value="M">Medium</option>
        <option value="L">Large</option>
    </select> <br />

    <input type="submit" value="SUBMIT">
</form>