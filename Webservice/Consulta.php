<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../core/db_abstract_model.php';

class Consulta extends DBModel {
    /*
      ------------------------------------ ALMACENES ---------------------------
     */

    /**
     * Muestra los almacenes a los que tiene acceso un usuario
     * @param string $usuario
     * @return array
     */
    public function getAlmacenes($usuario) {
        $rows = array();
        if ($usuario != '') {
            $query = "SELECT * FROM `almacen`, gestiona WHERE gestiona.CodigoAlmacen = almacen.Codigo and gestiona.NombreUsuario = '$usuario'";
            $rows = $this->get_results_from_query($query);
        }

        return $rows;
    }

    /**
     * Actualiza el nombre y descripción de un Almacén
     * @param string $CodigoAlmacen
     * @param string $nombre
     * @param string $descripcion
     * @return int
     */
    public function updateAlmacen($CodigoAlmacen, $nombre, $descripcion) {
        $Sql = "UPDATE almacen SET Nombre = '$nombre', Descripcion = '$descripcion'  WHERE Codigo='$CodigoAlmacen'";

        if ($this->execute_single_query($Sql)) {
            return 1;
        }
        return 0;
    }

    /**
     * Crea un almacen y genera la gestión 
     * @param string $nombre
     * @param string $descripcion
     * @param string $Usuario
     * @return int
     */
    public function createAlmacen($nombre, $descripcion, $Usuario) {
        $codigo = $this->generarCodigo();
        $Sql = "INSERT INTO almacen VALUES ('$codigo', '$nombre', '$descripcion', '$Usuario')";
        $creado = $this->execute_single_query($Sql);

        if ($creado) {
            if ($this->createGestion($Usuario, $codigo)) {
                return 1;
            } else {
                //Tratar problema
            }
        }
        return 0;
       
    }

    /**
     * Elimina un Almacén
     * @param string $codigo
     * @param string $usuario
     * @return integer
     */
    private function deleteAlmacen($codigo, $usuario) {
        $Sql = "DELETE FROM almacen WHERE Codigo='$codigo' AND Creador='$usuario'";
        if ($this->execute_single_query($Sql)) {
            return 1;
        }
        return 0;
    }

    /*
      ------------------------------------ / ALMACENES---------------------------
     */

    /*
      ------------------------------------ ESTANTERIAS ---------------------------
     */

    /**
     * Devuelve las estanterías de un Almacén
     * @param string $CodigoAlmacen
     * @return array
     */
    public function getEstanterias($CodigoAlmacen) {
        $rows = array();
        if ($CodigoAlmacen != '') {
            $query = "SELECT * FROM estanteria WHERE CodigoAlmacen = '$CodigoAlmacen'";
            $rows = $this->get_results_from_query($query);
        }

        return $rows;
    }

    /**
     * Actualiza el nombre y descripción de una Estantería
     * @param string $codigo
     * @param string $CodigoAlmacen
     * @param string $nombre
     * @param string $descripcion
     * @return int
     */
    public function updateEstanteria($codigo, $CodigoAlmacen, $nombre, $descripcion) {
        $Sql = "UPDATE estanteria SET Nombre='$nombre', Descripcion='$descripcion'";

        if ($CodigoAlmacen != '') {
            $Sql.=" WHERE CodigoAlmacen='$CodigoAlmacen' AND Codigo='$codigo'";
            if ($this->execute_single_query($Sql)) {
                return 1;
            }
        }
        return 0;
    }

    /**
     * Crea una Estantería.
     * @param string $nombre
     * @param string $descripcion
     * @param string $CodigoAlmacen
     * @return int
     */
    public function createEstanteria($nombre, $descripcion, $CodigoAlmacen) {
        $codigo = $this->generarCodigo();
        $Sql = "INSERT INTO estanteria VALUES ('$codigo', '$CodigoAlmacen', '$nombre', '$descripcion')";
        if ($this->execute_single_query($Sql)) {
            return 1;
        }
        return 0;
    }

    /**
     * Elimina una Estantería
     * @param string $codigo
     * @return integer
     */
    public function deleteEstanteria($codigo) {
        $Sql = "DELETE FROM estanteria WHERE codigo='$codigo'";
        if ($this->execute_single_query($Sql)) {
            return 1;
        }
        return 0;
    }

    /*
      ------------------------------------ / ESTANTERIAS---------------------------
     */

    /*
      ------------------------------------ ITEMS ---------------------------
     */

    /**
     * Obtiene todos los items de una tabla 
     * @param string $CodigoEstanteria
     * @return array
     */
    public function getItems($CodigoEstanteria) {
        $rows = array();
        if ($CodigoEstanteria != '') {
            $query = "SELECT * FROM Item WHERE CodigoEstanteria = '$CodigoEstanteria'";
            $rows = $this->get_results_from_query($query);
        }

        return $rows;
    }

    /**
     * Actualiza los valores de un Item
     * @param string $codigo
     * @param string $CodigoEstanteria
     * @param float $cantidad
     * @param string $nombre
     * @param string $descripcion
     * @return int
     */
    public function updateItem($codigo, $CodigoEstanteria, $cantidad, $nombre, $descripcion) {
        $Sql = "UPDATE item SET Nombre='$nombre', Cantidad='$cantidad', Descripcion='$descripcion'";

        if ($CodigoEstanteria != '') {
            $Sql.=" WHERE CodigoEstanteria='$CodigoEstanteria' AND Codigo='$codigo'";
            if ($this->execute_single_query($Sql)) {
                return 1;
            }
        }
        return 0;
    }

    /**
     * Actualiza la cantidad de un item
     * @param float $numero
     * @param string $CodigoItem
     * @param string $CodigoEstanteria
     * @return integer
     */
    public function updateCantidad($numero, $CodigoItem, $CodigoEstanteria) {
        $Sql = "UPDATE Item SET Cantidad = '$numero' WHERE Codigo = '$CodigoItem' AND CodigoEstanteria='$CodigoEstanteria'";
        if ($this->execute_single_query($Sql)) {
            return 1;
        }
        return 0;
    }

    /**
     * Crea un nuevo Item
     * @param string $nombre
     * @param float $cantidad
     * @param string $descripcion
     * @param string $CodigoEstanteria
     * @return int
     */
    public function createItem($nombre, $cantidad, $descripcion, $CodigoEstanteria) {
        $codigo = $this->generarCodigo();
        $Sql = "INSERT INTO item VALUES ('$codigo', '$CodigoEstanteria', '$cantidad', '$nombre', '$descripcion')";

        if ($this->execute_single_query($Sql)) {
            return 1;
        }
        return 0;
    }

    /**
     * Elimina un Item de una Estantería
     * @param string $CodigoItem
     * @param string $CodigoEstanteria
     * @return integer
     */
    public function deleteItem($CodigoItem, $CodigoEstanteria) {
        $Sql = "DELETE FROM Item WHERE Codigo = '$CodigoItem'  AND CodigoEstanteria='$CodigoEstanteria'";
        if ($this->execute_single_query($Sql)) {
            return 1;
        }
        return 0;
    }

    /*
      ------------------------------------ / ITEMS ---------------------------
     */


    /*
      ------------------------------------ USUARIOS ---------------------------
     */

    /**
     * Registra un usuario
     * @param string $NombreUsuario
     * @param string $nombre
     * @param string $apellidos
     * @param string $pass
     * @return integer
     */
    public function registrar($NombreUsuario, $nombre, $apellidos, $pass) {
        $hash=hash('md5',"codificacionmaxima".$pass);
        $Sql = "INSERT INTO usuario VALUES ('$NombreUsuario', '$nombre',  '$apellidos', '$hash' )";
        if ($this->execute_single_query($Sql)) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Devuelve si un usuario es correcto o no.
     * @param string $Usuario
     * @param string $Password
     * @return integer
     */
    public function login($Usuario, $Password) {
        $hash=hash('md5',"codificacionmaxima".$Password);
        $sql = "SELECT * FROM usuario WHERE NombreUsuario='$Usuario' AND Password='$hash'";
        $row = $this->get_results_from_query($sql);
        if (count($row) > 0) {
            return 1;
        }
        return 0;
    }

    /*
      ------------------------------------ / USUARIOS ---------------------------
     */

    /*
     * ----------------------------------- GESTION ---------------------------------
     */

    /**
     * Añade una relación entre un usuario y un almacén
     * @param string $Usuario
     * @param string $CodigoAlmacen
     * @return integer
     */
    public function createGestion($Usuario, $CodigoAlmacen) {

        $Sql = "INSERT INTO gestiona VALUES ('$CodigoAlmacen', '$Usuario')";
        if ($this->execute_single_query($Sql)) {
            return 1;
        }
        return 0;
    }

    /**
     * Elimina una relación de gestión de un usuario y un almacén
     * @param string $Usuario
     * @param string $CodigoAlmacen
     * @return integer
     */
    public function deleteGestion($Usuario, $CodigoAlmacen) {
        //Comprobamos si el usuario es el creador del almacen
        $esAdministrador = "SELECT * FROM almacen WHERE Codigo='$CodigoAlmacen' AND Creador = '$Usuario'";
        $relacion = false;
        $result = $this->get_results_from_query($esAdministrador);
        //Si es el creador, eliminamos cualquier relación entre usuarios y este almacen
        if (count($result) > 0) {
            $Sql = "DELETE FROM gestiona WHERE CodigoAlmacen='$CodigoAlmacen'";
            $relacion = $this->execute_single_query($Sql);
            //Si se han conseguido eliminar, se elimina el almacén totalmente
            if ($relacion) {
                if ($this->deleteAlmacen($CodigoAlmacen, $Usuario)) {
                    return 1;
                }
            }
        } else {
            //Si no es el creador eliminamos simplemente la relación entre el y el almacén
            $Sql = "DELETE FROM gestiona WHERE CodigoAlmacen='$CodigoAlmacen' AND NombreUsuario = '$Usuario'";
            if ($this->execute_single_query($Sql)) {
                return 1;
            }
        }
        return 0;
    }

    /*
     * ----------------------------------- Funciones Privadas -----------------------
     */

    /**
     * Genera un código único de 20 caracteres
     * @return string
     */
    private function generarCodigo() {
        return uniqid();
    }


}
