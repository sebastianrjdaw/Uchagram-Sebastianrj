<html>
<form action="prueba.php" method="post">
    <p>Selecciona Fecha<input type="date" name="fecha"></p>
    <p>Selecciona Hora: <input type="time" name="hora"></p>

<input type="submit" value="Enviar datos" name="send">

</form> 
</html>    

<?php
echo $_POST['fecha']."<br>";
echo $_POST['hora']."<br>";
if (isset($_POST['send'])) {
    if (!empty($_POST['fecha']) && !empty($_POST['hora'])) {
        echo 'true';
    } else {
        echo 'false';
    }
}
$fechaProg=$_POST['fecha']." ".$_POST['hora'];
$fechaProg=strtotime($fechaProg);
if($fechaProg>=time()){
    echo 'futuro';
} else {
   echo 'pasado';
}
 

?>