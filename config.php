<?php

session_start();

//VALIDAMOS QUE EXISTA UN USUARIO QUE HAYA CREADO UNA SESION. SI SE LLEGA A ESTA PAGINA ESCRIBIENDO EL URL SIN INICIAR SESION SE REDIRIGE AL USUARIO A LA PAGINA DE LOGIN
if(!isset($_SESSION['idUser'])){
    header("Location: index.php");
}

//AGREGAMOS USER.PHP PARA PODER HACER USO DE LA CLASE USER Y SU METODOS
require 'user.php';
$objUser = new User();

//EN ESTE IF VALIDAMOS SI HEMOS CARGADO ESTA PAGINA MEDIANTE EL METODO POST DEL FORMULARIO. SI SE CARGO MEDIANTE UN FORMULARIO EL IF ES VERDADERO Y SE DEBE ACTUALIZAR
//LOS CAMPOS DEL USUARIO. DE VENIR MEDIANTE UN ENLACE URL NO SE ENTRA EN ESTA CONDICION Y NO SE EJECUTA EL CODIGO DENTRO DE ELLA
if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['phone'])){
    
    //BUSCAMOS AL USUARIO MEDIANTE EL EMAIL QUE NOS PROPORCIONA EN EL FORMULARIO. SI EL EMAIL HA SIDO CAMBIADO EL IF VALIDA QUE EL NUEVO EMAIL NO ESTE
    //ASOCIADO A OTRA CUENTA. DE EXISTIR ALGUN PROBLEMA CON EMAIL PROPORCIONADO SE LE NOTIFICA AL USUARIO Y LA ACTUALIZACION NO SE EJECUTA.
    $user = $objUser->searchUser($_POST['email']);
    if($user['id'] != $_SESSION['idUser']){
        echo '<script>alert("Error! El correo nuevo ya est&aacute; asociado a otra cuenta")</script>';
    }
    else{
        //VALIDAMOS SI SE HA RECIBIDO ALGO EN EL CAMPO DE PASSWORD. SI EL CAMPO ESTA VACIO ASIGNAMOS EL PASSWORD A UNA VARIABLE PARA LUEGO ENVIARLA A LA CONSULTA
        if(empty($_POST['password'])){
            $password = $_SESSION['passwordUser'];
        }
        //SI EL PASSWORD NO ESTA VACIO, LE ASIGNAMOS EL VALOR DE LA ACTUALIZACION A UNA VARIABLE PARA LUEGO ENVIARLA A LA CONSULTA
        else{
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        }

        //EN ESTE IF VALIDAMOS SI EL USUARIO ACTUALIZO O NO SU IMAGEN DE PERFIL. SI NO LA ACTUALIZO, ESTE IF ES VERDADERO Y ASIGNAMOS EL VALOR ACTUAL DE LA IMAGEN DE PERFIL
        //A UNA VARIABLE PARA LUEGO ENVIARLA A LA CONSULTA
        if(empty($_FILES['avatar']['name'])){
            $target = $_SESSION['avatarUser'];
        }
        //SI LA IMAGEN DE PERFIL SE ACTUALIZO SE ENTRA EN ESTE ELSE
        else{
            //EL USUARIO PUEDE CREER SU CUENTA SIN UNA IMAGEN DE PERFIL. CON ESTE IF VALIDAMOS SI TIENE O NO UNA IMAGEN DE PERFIL. SI CUENTA CON UNA IMAGEN DE PERFIL
            //BORRAMOS LA ACTUAL PARA PODER AGREGAR LA NUEVA IMAGEN
            if(!empty($_SESSION['avatarUser'])){
                unlink($_SESSION['avatarUser']);
            }
            //AQUI CREAMOS EL NOMBRE DE LA RUTA Y ARCHIVO DONDE GUARDAREMOS LA IMAGEN. SE CAMBIA EL NOMBRE ORIGINAL DEL ARCHIVO POR UNO QUE HACE REFERENCIA AL EMAIL
            //DEL USUARIO PARA UNA GESTION MAS CLARA DE LOS ARCHIVOS
            $info = pathinfo($_FILES['avatar']['name']);
            $ext = $info['extension'];
            $newName = $_POST['email'].".".$ext;
            $target = "Media/Usuarios_Avatar/".$newName;
            move_uploaded_file($_FILES['avatar']['tmp_name'], $target);
        }
        //LUEGO DE DAR FORMATO A LAS VARIABLES PASSWORD Y AVATAR PODEMOS PROCEDER A LLAMAR AL METODO QUE ACTUALIZA AL USUARIO EN CUESTION
        $resp = $objUser->updateUser($_SESSION['idUser'], $_POST['name'], $_POST['email'], $_POST['phone'], $password, $target);
        
        //DESPUES DE ACTUALIZAR VOLVEMOS A BUSCAR AL USUARIO RECIEN ACTUALIZADO PARA ACTUALIZAR ESTOS MISMOS DATOS EN NUESTRA VARIABLE $_SESSION
        $results = $objUser->searchUser($_POST['email']);
        $_SESSION['idUser'] = $results['id'];
        $_SESSION['nameUser'] = $results['name'];
        $_SESSION['emailUser'] = $results['email'];
        $_SESSION['phoneUser'] = $results['phone'];
        $_SESSION['avatarUser'] = $results['avatar'];
    }
    echo '<script>alert("'.$resp.'")</script>';
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

<section id=main_content>
    <section id=user>
        <?php echo '<img src="'.$_SESSION['avatarUser'].'?v='.random_int(1, 10000000).'">' ?>
        <h2><?php echo $_SESSION['nameUser'] ?></h2>
        <p id=button><a href="logout.php">Cerrar Sesi&oacute;n</a></p>
        <p id="button"><a href="delete.php">Eliminar Cuenta</a></p>
    </section>
    <section id=login_form>
        <h2>Datos</h2>
        <form action="config.php" method="POST" enctype="multipart/form-data">
            <p>
                <input id=field type="text" placeholder="Nombre" name="name" value="<?php echo $_SESSION['nameUser'] ?>"> 
            </p>
            <p>
                <input id=field type="text" placeholder="Email" name="email" value="<?php echo $_SESSION['emailUser'] ?>"> 
            </p>
            <p>
                <input id=field type="text" placeholder="Tel&eacute;fono" name="phone" value="<?php echo $_SESSION['phoneUser'] ?>"> 
            </p>
            <p>
                <input id=field type="password" placeholder="Contrase&ntilde;a" name="password">
            </p>
            <p>
                <input id=img_upload type="file" name="avatar" accept=".png, .jpeg, .jpg"> 
            </p>
            <p>
                <input id=button type="submit" value="Actualizar">
            </p>
    </section>
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