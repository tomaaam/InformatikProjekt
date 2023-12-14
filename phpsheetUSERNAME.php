<?php 
    $name = "Username1";
    $handle = fopen("templates/S1_name.txt","w");
    fwrite($handle, $name);
    fcloseclose($handle); 
?>