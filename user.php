<?php
//LA CLASE USER SE ENCARGA DE GESTIONAR TODAS LAS OPERACIONES EN LA BASE DE DATOS RELACIONADAS A LOS USUARIOS COMO
//ACTUALIZAR, CREAR, CONSULTAR O ELIMINAR

require 'database.php';

class User{
    private $id;
    private $name;
    private $email;
    private $phone;
    private $password;
    private $avatar;
    private $objDataBase;

    //AQUI CREAMOS A UN NUEVO USUARIO CON SUS RESPECTIVOS VALORES
    public function createUser($name, $email, $phone, $password, $avatar){
        $objDataBase  = new DataBase();
        $conn = $objDataBase->conexion();

        //COMPROBAMOS LA CONEXION A LA BASE DE DATOS
        if(!$conn){
           return false;
        }
        //DAMOS FORMATO AL STRING DE LA CONSULTA Y LUEGO AGREGAMOS LOS VALORES QUE RECIBIMOS
        else{
            $query = "INSERT INTO users (name, email, phone, password, avatar) VALUES (:name, :email, :phone, :password, :avatar)";
            
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':phone', $phone);
            $stmt->bindValue(':password', password_hash($password, PASSWORD_BCRYPT));
            $stmt->bindValue(':avatar', $avatar);

            //EJECUTAMOS LA CONSULTA Y CREAMOS UN MENSAJE NOTIFICANDO DEL ESTADO DE LA OPERACION. LA OPERACION PUEDE FALLAR SI EL STRING DE LA CONSULTA TIENE UN ERROR.
            if( $stmt->execute() ):
                $message = 'Nuevo usuario creado con éxito';
            else:
                $message = 'Disculpe, debe de haber ocurrido un problema al crear la cuenta';
            endif;
            return $message;
        }
    }

    //METODO PARA BUSCAR AL USUARIO
    public function searchUser($email){
        $objDataBase  = new DataBase();
        $conn = $objDataBase->conexion();
        //VALIDAMOS LA CONEXION A LA BASE DE DATOS
        if(!$conn){
            return false;
        }
        //SI TODO ESTA BIEN CREAMOS EL STRING DE LA CONSULTA Y LUEGO AGREGAMOS EL VALOR Y EJECUTAMOS LA CONSULTA. PUEDE DEVOLVER 1 LINEA SI EL EMAIL EXISTE EN LA BASE DE DATOS
        //Y 0 LINEAS SIN EL EMAIL NO EXISTE
        else{
            $query = "SELECT * FROM users WHERE email = :email";
            
            $records = $conn->prepare($query);
            $records->bindValue(':email', $email);
            $records->execute();
            return $records->fetch(PDO::FETCH_ASSOC);
        }
    }
    
    //AQUI ACTUALIZAMOS LOS VALORES DEL USUARIO EN LA BASE DE DATOS
    public function updateUser($id, $name, $email, $phone, $password, $avatar){
        $objDataBase  = new DataBase();
        $conn = $objDataBase->conexion();
        $message="";
        //COMPROBAMOS LA CONEXION A LA BASE DE DATOS
        if(!$conn):
            return false;
        //SI TODO ESTA BIEN CREAMOS EL STRING DE LA CONSULTA Y AGREGAMOS LOS VALORES
        else:
            $query = "UPDATE users SET name = :name, email = :email, phone = :phone, password = :password, avatar = :avatar WHERE id = :id";
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':phone', $phone);
            $stmt->bindValue(':password', $password);
            $stmt->bindValue(':avatar', $avatar);
            $stmt->bindValue(':id', $id);

            //SI TODO VA BIEN SE ACTUALIZA EL USUARIO Y SE CREA UN MENSAJE DE EXITO
            if( $stmt->execute() ):
                $message = 'Actualizaci&oacute;n completada con &eacute;xito';
            else:
                $message = 'Disculpe, debe de haber ocurrido un problema al actualizar la cuenta. Asegurese que el correo suministrado no est&eacute; siendo utilizado en otra cuenta';
            endif;
             
        endif;
        return $message;
    }

    //AQUI ELIMINAMOS A UN USUARIO QUE ESTE REGISTRADO EN LA BASE DE DATOS
    public function deleteUser($id){
        $objDataBase  = new DataBase();
        $conn = $objDataBase->conexion();
        //COMPROBAMOS LA CONEXION
        if(!$conn){
            return false;
        }
        //SI TODO VA BIEN AQUI CREAMOS EL STRING DE LA CONSULTA  Y AGREGAMOS EL VALOR DEL ID DEL USUARIO QUE QUEREMOS BORRAR
        else{
            $query = "DELETE FROM users WHERE id = :id";
            
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
        }

    }
}
?>