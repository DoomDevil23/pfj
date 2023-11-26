<?php

session_start();

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

//INCLUIMOS USER.PHP PARA PODER UTILIZAR LA CLASE USER, LA CUAL SE ENCARGA DE REALIZAR TODAS LAS OPERACIONES EN LA BASE DE DATOS RELACIONADAS A LA
//CREACIÓN, LEER, ACTUALIZACIÓN Y ELIMINACIÓN DE LOS USUARIOS
require 'user.php';
$objUser = new User();

//SE VALÍDA SI ESTAMOS INGRESANDO A ESTA PÁGINA DESDE LA LLAMADA DEL MÉTODO POST DE UN FORMULARIO O SI VENIMOS DESDE UN URL DE OTRA PÁGINA
//EN CASO DE VENIR DE UN FORMULARIO SE PUEDE ENTRAR AL IF DONDE SE EVALUARÁ LOS VALORES ENVIADOS PARA CREAR O NO UNA CUENTA NUEVA
if(!empty($_POST['name']) &&!empty($_POST['email']) && !empty($_POST['phone']) && !empty($_POST['password'])):

    //CON ESTE IF VALIDAMOS QUE EL EMAIL NO SE ENCUNETRE REGISTRADO CON UN USUARIO EXISTENTE. DE EXISTIR UN USUARIO CON ESTE EMAIL REGISTRADO
    //LA NUEVA CUENTA NO SE PODRÁ CREAR Y SERÁ NECESARIO UN EMAIL DISTINTO
    if($objUser->searchUser($_POST['email'])):
        echo '<script>alert("Ya existe una cuenta asociada al correo: '.$_POST['email'].'")</script>';
    else:
        //LLAMAMOS AL METODO PARA CREAR AL NUEVO USUARIO Y ENVIAMOS LOS VALORES QUE RECIBIMOS DEL FORMULARIO
        $resp = $objUser->createUser($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['password'], '');
        if(!$resp):
            echo '<script>alert("Error al conectar con la base de datos")</script>';
        else:
            //DESPUES DE CREAR AL NUEVO USUARIO VALIDAMOS SI ESTE AGREGO O NO UNA IMAGEN DE AVATAR. DE HABER AGREGADO UNA IMAGEN ESTE IF SERA VERDADERO
            if(!empty($_FILES['avatar']['name'])):
                //CUANDO SE CREA EL USUARIO CON EXITO PODEMOS GUARDAR EL AVATAR EN LA CARPETA CORRESPONDIENTE
                $info = pathinfo($_FILES['avatar']['name']);
                $ext = $info['extension'];
                $newName = $_POST['email'].".".$ext;
                $target = "Media/Usuarios_Avatar/".$newName;
                move_uploaded_file($_FILES['avatar']['tmp_name'], $target);

                //AHORA RECUPERAMOS EL USUARIO RECIEN CREADO PARA AGREGARLE LA RUTA DE LA IMAGEN DE SU AVATAR EN EL CAMPO AVATAR DE LA TABLA USERS
                $user = $objUser->searchUser($_POST['email']);
                $objUser->updateUser($user['id'], $user['name'], $user['email'], $user['phone'], $user['password'], $target);
            endif;

            //NOTIFICAMOS QUE EL USUARIO HA SIDO CREADO CON EXITO Y REDIRIGIMOS AL INDEX.PHP PARA QUE PUEDAN INGRESAR
            echo '<script>alert("'.$resp.'")</script>';
            echo '<meta http-equiv="refresh" content="0;url=http://localhost:80/pfj/"> ';
        endif;
    endif;
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
    <h2>Datos</h2>
    <form action="register.php" method="POST" enctype="multipart/form-data">
        <p>
            <input id=field type="text" placeholder="Nombre" name="name"> 
        </p>
        <p>
            <input id=field type="text" placeholder="Email" name="email"> 
        </p>
        <p>
            <input id=field type="text" placeholder="Tel&eacute;fono" name="phone"> 
        </p>
        <p>
            <input id=field type="password" placeholder="Contrase&ntilde;a" name="password">
        </p>
        <p>
            <input id=img_upload type="file" name="avatar" accept=".png, .jpeg, .jpg"> 
        </p>
        <p>
            <input id=button type="submit" value="Guardar">
        </p>
        <hr>
        <p id=button>
            <a href="index.php">Regresar</a>
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