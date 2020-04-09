<?php 

// Admin view is to redirect the user and use token to be able to check it.
include("../object/users.php");
$user_handler = new User($databaseHandler);
echo "<a href='../index.php'>back btn</a> <br />";

$token = (isset($_POST['token']) ? $_POST['token'] : '');

$isAdmin = $user_handler->isAdmin($token);
    
if ($isAdmin === true) {
    include("createProductForm.php");
    echo "<br />";

} else {
    echo "You sir are not an admin! Leave!";
}

?>