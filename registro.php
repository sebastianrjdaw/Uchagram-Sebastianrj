<!DOCTYPE html>
<?php
/*
Título: Uchagram-login 
Autor: Sebastián Rodŕiguez Jiménez
Data modificación: 17/11/2022
Versión 1.0 #
*/

?>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Login</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='css/login.css'>
</head>
<body>
   <div class="form-body">
    <img src="uchagram.png" alt="logo_uchagram">
    <p class="text">Registro Uchagram</p>
    <form class="login-form" action="registro.php" method="POST">
    <input type='text' name='username' placeholder="Elige nombre de Usuario" value="<?php
     if (isset($_POST['username']))echo $_POST['username'] 
     ?>">
    <input type='password' placeholder="Introduce una Contraseña" name='password'> 
    <input type='password' placeholder="Verifica Contraseña" name='v_password'>
    <button type="Submit" name="Enviar">Registrar</button>       
    </form>
   </div> 
</body>
<?php
include("DAO.php");
include("usuario.class.php");
$datos = obtenerUsuarios();
$registrado = false;
if (isset($_POST['Enviar'])) {
    if (validUser($_POST['username']) && validPassword($_POST['password'])) {
        $datosValidos = ['user',$_POST['username'],validPassword($_POST['password'])];
        $datosValidos[]=count(obtenerUsuarios());
        $datos[] = $usuario = new Usuario($datosValidos[0],$datosValidos[1],$datosValidos[2],$datosValidos[3]);
        escribirUsuarios($datos);
        $registrado=true;
        }
    }
if ($registrado) {
    session_start();
    $_SESSION['username'] = $usuario->getUsername();
    $_SESSION['rol'] = "user";
    setHora();
    header('Location: perfil.php');
}

?>
</html>
