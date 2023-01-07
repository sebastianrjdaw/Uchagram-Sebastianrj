<!DOCTYPE html>
<?php
/*
Título: Uchagram-login 
Autor: Sebastián Rodŕiguez Jiménez
Data modificación: 28/12/2022
Versión 1.0 #
*/
session_start();
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
    <img src="img/uchagram.png" alt="logo_uchagram">
    <p class="text">Bienvendo a Uchagram</p>
    <form class="login-form" action="login.php" method="POST">
    <input type='text' name='username' placeholder="Introduce nombre de usuario" value="<?php
     if (isset($_POST['username']))echo $_POST['username'] 
     ?>">
    <input type='password' placeholder="Introduce contraseña" name='password'> 
    <button type="Submit" name="Enviar">Iniciar Sesión</button>       
    </form>
   </div> 
</body>
<?php
include('DAO.php');
include('usuario.class.php');
$datos = obtenerUsuarios();
$registrado = false;
$admin = false;
if (isset($_POST['Enviar'])) {
    if (validUser($_POST['username']) && validPassword($_POST['password'])) {

        foreach ($datos as $usuario) { //Lee el csv para verificar que el usuario esta dentro del registro
            if ((validUser($_POST['username']) == $usuario->getUsername()) && hash_equals(validPassword($_POST['password']), $usuario->getPassword())) {
                $registrado = true;
            }
            if (($registrado) && ($usuario->getRol() == "admin")) {
                $admin = true;
            }
        }
    } else {
        echo "<p>Usuario no resgistrado</p>";
    }
    if ($registrado && $admin) {  //Crear session 
        
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['rol'] = "admin";
        if (!isset($_SESSION["username"])) { //Controlar en caso de que no se pudiese crear
            echo "Error de autenticacion";
        } else {
            setHora();
            header('Location: usuarios.php');
        }
    } else if ($registrado && !$admin) {  //Controlar si no es un admin
        
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['rol'] = "user";
        setHora();
        header('Location: perfil.php');
        
    }
}
?>
</html>
