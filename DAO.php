<?php


//Funciones de login.php

           //Funciones de Validacion 
           function validUser($username)
           {
            if(empty($username)){
                echo "Introduce un nombre de usuario";
            }else{
                return trim($username);
            }
            }

            function validPassword($password)
            {
            if(empty($password)){
                echo "introduce contraseña";
            }
            else{
                $hash = crypt($password,'$1$rasmusle$');
                return trim($hash);
            }
            }
            
            //Funcion de guradar ultima conexion
            function setHora(){
                if(!isset($_COOKIE["Hora_conectado"])){
                  setCookie("Hora_conectado",time());
                }else{
                  $hora=$_COOKIE["Hora_conectado"];
                  $nhora=$hora.",".time();
                  setCookie("Hora_conectado",$nhora);
                }
                echo $_COOKIE["Hora_conectado"];
              }
              function getHora(){
                $hora=$_COOKIE["Hora_conectado"];
                $arrayHora=explode(",",$hora);
                return $arrayHora;
              }
              
            //Funcion para gurdar imagenes
              function compruebaPerfil(){
                if(isset($_SESSION['username'])){
                    $imagen="img_perfil/".$_SESSION['username'].".png";
                if(file_exists($imagen)){
                    return $imagen;
                }
                }
                else{
                    $default="/img_perfil/default.jpeg";
                    return $default;
                } 
            }


//Validacion de Campos
function vNombre($nombre, $valido)
{
    if (preg_match("/^[a-zA-Z]+/", $nombre)) { //Solo se perminten entradas con letras mayusc. y minusc.
        $valido = true;
        global $datosValidos;
        $datosValidos[] = $nombre;
    }
    if (empty($nombre)) {
        global $errores;
        $errores[] = 'Introduce Nombre de Usuario';
    }
    return $valido;
}

function vPassword($pass, $vpass, $valido)
{
    if (empty($pass)) {
        global $errores;
        $errores[] = 'Introduce Contraseña';
    }
    if (empty($vpass)) {
        global $errores;
        $errores[] = 'Introduce verificacion Contraseña';
    }
    if ($pass !== $vpass) {
        global $errores;
        $errores[] = 'Las contraseñas no coinciden';
    } else {
        $hash = crypt($pass, '$1$rasmusle$');
        global $datosValidos;
        $datosValidos[] = $hash;
        $valido = true;
    }
    return $valido;
}

function encriptar($pass){
    $hash = crypt($pass, '$1$rasmusle$');
        return $hash;
}

function vEmail($email, $valido)
{
    global $datosValidos;
    global $errores;

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) { //Solo pemite entradas de tipo (xxxxx@xxxx.xx)
        $datosValidos[] = $email;
        $valido = true;
    }
    if (empty($email)) {
        $errores[] = 'Introduce Email';
    }
    if ($valido == false) {
        $errores[] = 'Formato de email no valido';
    }

    return $valido;
}




//Gestion de usuarios 
function obtenerUsuarios()
{
    $fichero = 'csv/usuarios.csv';
    $arrayDatos = array();
    if ($fp = fopen($fichero, "r")) {
        while ($filaDatos = fgetcsv($fp, 0, ",")) {
            $usuario = new Usuario($filaDatos[0], $filaDatos[1], $filaDatos[2], $filaDatos[3]);
            $arrayDatos[] = $usuario;
        }
    } else {
        echo "Error no se puede acceder al fichero";
        return false;
    }
    fclose($fp);
    return $arrayDatos;
}

function escribirUsuarios( $arrayEscribir)
{
    $fichero='csv/usuarios.csv';
    if ($fp = fopen($fichero, "w")) {
        foreach ($arrayEscribir as $usuario) {
            $filaDatos = [$usuario->getRol(), $usuario->getUsername(), $usuario->getPassword(), $usuario->getCodigo()];
            fputcsv($fp, $filaDatos);
        }
    } else {
        echo "Error no se puede aceder al fichero";
        return false;
    }
    fclose($fp);
    return true;
}
//Gestion de Publicaciones

function obtenerPublicaciones()
{
    $fichero = 'csv/publicaciones.csv';
    $arrayDatos = array();
    if ($fp = fopen($fichero, "r")) {
        while ($filaDatos = fgetcsv($fp, 0, ",")) {
            $publicacion = new publicacion($filaDatos[0], $filaDatos[1], $filaDatos[2], $filaDatos[3], $filaDatos[4],$filaDatos[5],$filaDatos[6]);
            $arrayDatos[] = $publicacion;
        }
    } else {
        echo "Error no se puede acceder al fichero";
        return false;
    }
    fclose($fp);
    return $arrayDatos;
}

function escribirPublicaciones($arrayEscribir)
{
    $fichero = 'csv/publicaciones.csv';
    if ($fp = fopen($fichero, "w")) {
        foreach ($arrayEscribir as $publicacion) {
            $filaDatos = [$publicacion->getCodigo(), $publicacion->getTitulo()  ,$publicacion->getTexto(), $publicacion->getMultimedia(), $publicacion->getDataPublicacion(),$publicacion->getLike(), $publicacion->getCodUsuario()];
            fputcsv($fp, $filaDatos);
        }
    } else {
        echo "Error no se puede aceder al fichero";
        return false;
    }
    fclose($fp);
    return true;
}
   

