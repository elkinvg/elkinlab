<?php
$fileLocation = "./hlpme/cnt.txt";
    $file = fopen( $fileLocation, "a+" );
    
    $info = $context['user'] . " " . date("Y-m-d H:i:s")  ."\n";
 
    fwrite( $file, $info );
    fclose( $file );
?>
