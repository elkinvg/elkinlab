<?php
<<<<<<< HEAD
$fileLocation = "./hlpme/cnt.txt";
=======
$fileLocation = getenv("DOCUMENT_ROOT") . ".labs/hlpme/cnt.txt";
>>>>>>> fa367920279e693a64bb2253546f1a3a965dc00a
    $file = fopen( $fileLocation, "a+" );
    
    $info = $context['user'] . " " . date("Y-m-d H:i:s")  ."\n";
 
    fwrite( $file, $info );
    fclose( $file );
?>

