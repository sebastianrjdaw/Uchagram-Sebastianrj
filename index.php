<?php
/*
Título: Uchagram-index
Autor: Sebastián Rodŕiguez Jiménez
Data modificación: 25/11/2022
Versión 1.0 #
*/

session_start();

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Uchagram</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php
    if (isset($_COOKIE['Tema'])) {
        if (($_COOKIE['Tema'] == 2)) {
            echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/oscuro_theme.css\" />";
        } elseif (($_COOKIE['Tema'] == 1) || ($_POST["tema"][0]) == 1) {
            echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/index.css\" />";
        }
    } else {
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/index.css\" />";
    }

    ?>
    <style>
        
            <?php
            //Lectura de los temas 
            echo '* {';
            if (isset($_COOKIE['Fontfam'])) {
                echo 'font-family:' . $_COOKIE['Fontfam'];
            }
            if (isset($_COOKIE['fontsize'])) {
                echo 'font-size:' . $_COOKIE['fontsize'];
            }
            echo '}';
            ?>
        
    </style>
</head>

<?php
include("menu.php");
include("publicacion.class.php");
include("usuario.class.php");

//Gestion Publicaciones

$datos = obtenerPublicaciones();


//Llenado de los datos de las publicaciones
if (isset($_POST['publicar'])) {
    $titulo = $_POST['title'];
    $texto = $_POST['textarea'];
    if (isset($_POST['multimedia'])) {
        $multimedia = $_POST['multimedia'];
    } else
        $multimedia = '""';
    if ((!empty($_POST['hora'])) && (!empty($_POST['data']))) {
        $dataHora = $_POST['hora'] . $_POST['data'];
        $dataHora = strtotime($dataHora);
    } else {
        $dataHora = time();
    }

    //Registro de codigo de publicacion
    if (isset($codigoPublicacion)) {
        $codigoPublicacion == intval(0);
    } else {
        foreach ($datos as $publicacion) {
            $codigoPublicacion = intval($publicacion->getCodigo()) + 1;
        }
    }

    //Registro del codigo de Usuario
    $users = obtenerUsuarios();
    foreach ($users as $usuario) {
        if ($usuario->getUsername() == $_SESSION['username']) {
            $codigoUsuario = $usuario->getCodigo();
        }
    }


    $datos[] = $publicacion = new publicacion($codigoPublicacion, $titulo, $texto, $multimedia, $dataHora,$codigoUsuario);
}
escribirPublicaciones($datos);

?>
<div class="main-body">

    <form action="index.php" method="post">
        <div class="form-publicacion">
            <input type="text" name='title' id="title" placeholder="Que pasa por tu mente?" />
            <textarea name="textarea" rows="10" cols="30">Write something here</textarea>
            <input type="text" name='multimedia' id="title" placeholder="Aqui puedes añadir algun video o foto" />
            <div class="fechahora">
                <input type="time" id="hora" name="hora"> <input type="date" id="data" name="data">
            </div>
            <div class="botones">
                <!-- <button type="Submit" id="progPublicacion" name='prog'>Programar Publicacion</button> -->
                <?php if (isset($_SESSION["username"])) {
                    echo '<button type="Submit" id="publicar" name="publicar">Publicar</button>';
                } else {
                    echo 'Debes estar registrado para poder publicar';
                } ?>
            </div>
    </form>
    <?php
    $cLike = 0;
    
    foreach ($datos as $publicacion) {

        
        

        if ($publicacion->publicado($publicacion->getDataPublicacion())) {
            $users = obtenerUsuarios();
            foreach ($users as $usuario) {
                if ($publicacion->getCodUsuario() == $usuario->getCodigo()) {
                    $nombre = $usuario->getUsername();
                }
            }
    ?>

            <div class="publicacion">
                <p id="dataHora"><?php

                                    echo $nombre . " // " . date("d-m-Y (H:i)", $publicacion->getDataPublicacion());
                                    ?></p>
                <h3><?php echo $publicacion->getTitulo() ?></h3>
                <p><?php if (isset($_COOKIE['moderacion'])) {
                        echo $publicacion->moderacion($publicacion->getTexto());
                    } else {
                        echo $publicacion->getTexto();
                    } ?></p>
                <?php if (!empty($publicacion->getMultimedia()))
                    echo $publicacion->getMultimedia() ?>
            </div>

    <?php }
    } ?>
</div>
</div>
</div>
</body>

</html>