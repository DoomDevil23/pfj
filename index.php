<?php

session_start();

require 'user.php';
$objUser = new User();

//VALIDAMOS SI EXISTE UN USUARIO CON UNA SESION ACTIVA. DE SER ASI EL IF ES VERDADERO Y SE REDIRIGE AL USUARIO A LA PAGINA DE CONFIGURACION DE SU CUENTA
if(isset($_SESSION['idUser'])) {
    $results = $objUser->searchUser($_SESSION['emailUser']);

    if(count($results) > 0){
        $_SESSION['idUser'] = $results['id'];
        $_SESSION['nameUser'] = $results['name'];
        $_SESSION['emailUser'] = $results['email'];
        $_SESSION['phoneUser'] = $results['phone'];
        $_SESSION['passwordUser'] = $results['password'];
        $_SESSION['avatarUser'] = $results['avatar'];
        header("Location: http://localhost:80/pfj/config.php");
    }
    //EN CASO DE TENER UNA SESION ACTIVA PERO QUE NO PERTENEZCA A UN USUARIO REGISTRADO EN LA BASE DE DATOS, LA SESION ES CERRADA EN ESTE ELSE
    else{
        session_unset();

        session_destroy();

        session_start();
    }

}

?>
<!DOCTYPE html> 
<html>
<head>
<title>NetFaceBloc</title>
<link rel="stylesheet" type="text/css" href="Style/style.css">
<link href='http://fonts.googleapis.com/css?family-Confortas' rel='stylesheet' type='text/css'>
</head>
<body>
<section id=header>
    <header>
        <h1>NetFaceBloc</h1>
    </header>
</section>

<section id=login_form>
    <h2>Iniciar Sesi&oacuten</h2>
    <form action="login.php" method="POST">
        <p>
            <input id=field type="text" placeholder="Email" name="email"> 
        </p>
        <p>
            <input id=field type="password" placeholder="Contrase&ntilde;a" name="password">
        </p>
        <p>
            <input id=button type="submit" value="Ingresar">
        </p>
        <hr>
        <p id=button>
            <a href="register.php">Registrarse</a>
        </p>
    </form>
</section>

<section id=footer>
    <footer>
        <h4>Elaborado por</h4>
        <p>Estudiante1</p>|
        <p>Estudiante2</p>|
        <p>Estudiante3</p>|
        <p>Estudiante4</p>
    </footer>
</section>
</body>
</html>