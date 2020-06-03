<?php
    $db = new mysqli("HOST", "USERNAME", "PASSWORD");
    if ($db->connect_error) {
 printf("Connection failed: %s/n" . $db->connect_error);
 exit();
 }
 ?>
