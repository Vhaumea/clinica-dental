<?php
// Generar una clave de cifrado segura de 32 bytes (256 bits)
$encryption_key = bin2hex(random_bytes(32));
echo $encryption_key;
?>