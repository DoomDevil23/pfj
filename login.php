<?php

session_start();
//VALIDAMOS QUE EXISTA UN USUARIO QUE HAYA CREADO UNA SESION. SI SE LLEGA A ESTA PAGINA ESCRIBIENDO EL URL SIN INICIAR SESION SE REDIRIGE AL USUARIO A LA PAGINA DE LOGIN
if(!isset($_SESSION['idUser']) && !isset($_POST['email'])){
    header("Location: index.php");
}

require 'user.php';

//CREAMOS UN OBJETO DE LA CALSE USER PARA PODER BUSCAR AL USUARIO CON LOS DATOS SUMINISTRADOS
$objUser = new User();
$results = $objUser->searchUser($_POST['email']);

//ESTE IF ES VERDADERO SI LA CONSULTA ENCUENTRA AL USUARIO ASOCIADO AL EMAIL SUMINISTRADO Y SI LA CONTRASEÑA SUMINISTRADA CONCUERDA CON LA CONTRASEÑA ALMACENADA EN LA BASE DE DATOS
//CUANDO SE CUMPLEN LAS CONDICIONES SE CARGA $_SESSION CON LOS DATOS DEL USUARIO
if(is_countable($results) > 0 && password_verify($_POST['password'], $results['password'])):
    $_SESSION['idUser'] = $results['id'];
    $_SESSION['nameUser'] = $results['name'];
    $_SESSION['emailUser'] = $results['email'];
    $_SESSION['phoneUser'] = $results['phone'];
    $_SESSION['passwordUser'] = $results['password'];
    $_SESSION['avatarUser'] = $results['avatar'];
endif;

?>

<!DOCTYPE html> 
<html>
<head>
<title>NetFaceBloc</title>
<link rel="stylesheet" type="text/css" href="Style/style.css">
<link href='http://fonts.googleapis.com/css?family-Confortas' rel='stylesheet' type='text/css'>
<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='expires' content='0'>
<meta http-equiv='pragma' content='no-cache'>
</head>
<body>
<section id=header>
    <header>
        <h1>NetFaceBloc</h1>
    </header>
</section>

<section id=login_form>
    <?php
        if(isset($_SESSION['idUser'])):
    ?>
        <h2>Bienvenido</h2>
        <h3><?php echo $_SESSION['nameUser'] ?></h3>
        <p>Espere mientros lo env&iacute;amos a la p&aacute;gina de configuraci&oacute;n de su cuenta!</p>
    <?php
            echo '<meta http-equiv="refresh" content="5;url=http://localhost:80/pfj/config.php"> ';
        else:
    ?>
        <h2>Error al Conectarse</h2>
        <p>El correo o la contrase&ntilde;a ingresada no son correctas. Por favor vuelva a intentarlo.</p>
    <?php
            echo '<meta http-equiv="refresh" content="8;url=http://localhost:80/pfj"> ';
        endif;
    ?>
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