<?php
include('DAO.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='css/menu.css'>
    <header id="main-header">
		
		<a id="logo-header" href="perfil.php">
        <img id="avatar" src=<?php echo compruebaPerfil();?> alt="Avatar">
        </a>
        <a id="logo-mid" href="index.php">
        <img id="logo" src="img/banner.png" alt="Logo">
        </a> 
        
		<nav>
			<ul>
                <?php
                if(!isset($_SESSION['username'])||!isset($_SESSION['rol'])){
                    echo "<li><a href=\"login.php\">Iniciar Sesion</a></li>";
                    echo "<li><a href=\"registro.php\">Registrate</a></li>";
                }else{
                    if($_SESSION['rol'] == "admin"){
                        echo "<li><a href=\"usuarios.php\">Usuarios</a></li>";
                    }
                    if($_SESSION['rol'] == ("admin")||$_SESSION['rol'] == ("user") ){
                            echo "<li><a href=\"logoff.php\">Salir</a></li>";
                    }
                }
                    
                
                    
                ?>
				
			</ul>
		</nav>
	</header>
