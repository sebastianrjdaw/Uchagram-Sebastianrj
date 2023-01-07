

<?php 

/*
Título: UD4 - 1 
Autor: Sebastián Rodŕiguez Jiménez
Data modificación: 17/11/2022
Versión 2.0 #
*/


session_start();
session_unset();
session_destroy();
session_write_close();
setcookie(session_name(),'',0,'/');
session_regenerate_id(true);
header("Location: index.php");
?>