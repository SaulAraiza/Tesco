<?php
// includes/env_read.php

//Get the root Path
$root = $_SERVER['DOCUMENT_ROOT'];
//Add the project Path
$envFilepath = "$root/Tesco/hotel_reservas/.env";
//Read all ENV Variables
if (is_file($envFilepath)) {
    $file = new \SplFileObject($envFilepath);
    // Loop until we reach the end of the file.
    while (false === $file->eof()) {
        // Get the current line value, trim it and save by putenv.
        putenv(trim($file->fgets()));
    }
}
?>