<?php

    class conectar{
        public function conexion(){
            $conexion = mysqli_connect('127.0.0.1:3306','root','','juegos');
            return $conexion;
        }
    }
    
    $obj = new conectar();

    /*if($obj -> conexion()){
        echo "conectado";
    }else{
        echo "no se logro conectar";
    }*/




?>