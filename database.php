<?php
//LA CLASE DATABASE SE ENCARGA DE GESTIONAR LA CONEXION A LA BASE DE DATOS. MODIFICANDO LAS VARIABLES DE LA CLASE SE PUEDE CONECTAR A BASES DE DATOS CON
//OTROS PARAMETROS DE CONEXION. LOS PARAMETROS ACTUALES SON PARA UN SERVER QUE UTILIZA XAMPP Y MYSQL SIN CONMFIGURAR
class DataBase{
    private $server = 'localhost';
    private $username = 'root'; 
    private $password = '';
    private $database = 'auth';

    public function conexion(){
        try{
                $conn = new PDO("mysql:host=$this->server; dbname=$this->database;", $this->username, $this->password);
                return $conn;
            } catch(PDOException $e){
                return false;
            }
    }
}
?>