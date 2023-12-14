<?php 
    $score = "4500";
    $handle = fopen("templates/S1_score.txt","w");
    fwrite($handle, $score);
    fcloseclose($handle);
?>