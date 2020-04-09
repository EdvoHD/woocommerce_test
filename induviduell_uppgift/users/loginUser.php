<?php

    include("../object/users.php");

    $user_handler = new User($databaseHandler);

    print_r($user_handler->loginUser($_POST['username'],($_POST['password'])));

    echo "<h2>Save token with CTRL-C and use it on other pages<h2>";
    echo "<a href='../index.php'>Go back after copied token</a>";
    


?>