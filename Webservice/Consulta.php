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
     * Actualiza los datos de un Almacen
     * @param array $valores
     * @param string $CodigoAlmacen
     * @return boolean
     */
    public function updateAlmacenes($valores, $CodigoAlmacen) {
        $Sql = "UPDATE almacen SET ";

        if (is_array($valores)) {
            foreach ($valores as $fila) {
                $i = 0;
                foreach ($fila as $columna => $valor) {
                    if (!($i % 2 == 0)) {
                        $Sql .= $columna . "= '" . $valor . "', ";
                    }
                    $i++;
                }
                $Sql = substr($Sql, 0, strlen($Sql) - 2);
                $Sql.=" WHERE Codigo='$CodigoAlmacen'";
                return $this->execute_single_query($Sql);
            }
        }
        return false;
    }

    /**
     * Crea un Almacén
     * @param array $valores
     * @param string $Usuario
     * @return boolean
     */
    public function createAlmacenes($valores, $Usuario) {
        $codigo = $this->generarCodigo();
        $Sql = "INSERT INTO estanteria VALUES ('$codigo'";
        foreach ($valores as $valor) {
            $Sql.=", '$valor'";
        }
        $Sql.=")";
       $creado= $this->execute_single_query($Sql);
       $correcto=false;
       if($creado){
            $correcto=$this->gestionar($Usuario, $codigo);
       }
       return $correcto;
       
    }

    /**
     * Elimina un Almacén
     * @param string $codigo
     * @return boolean
     */
    public function deleteAlmacenes($codigo) {
        $Sql = "DELETE FROM almacenes WHERE codigo='$codigo'";
       return $this->execute_single_query($Sql);
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
     * Actualiza los valores de una Estantería
     * @param array $valores
     * @param string $CodigoAlmacen
     * @return boolean
     */
    public function updateEstanteria($valores, $CodigoAlmacen) {
        $Sql = "UPDATE estanteria SET ";

        if (is_array($valores)) {
            foreach ($valores as $fila) {
                $i = 0;
                $CodigoEstanteria = $fila['Codigo'];
                foreach ($fila as $columna => $valor) {
                    if (!($i % 2 == 0)) {
                        $Sql .= $columna . "= '" . $valor . "', ";
                    }
                    $i++;
                }
                $Sql = substr($Sql, 0, strlen($Sql) - 2);
                if ($CodigoAlmacen != '') {
                    $Sql.=" WHERE CodigoAlmacen='$CodigoAlmacen' AND Codigo='$CodigoEstanteria'";
                    return $this->execute_single_query($Sql);
                }
            }
        }
        return false;
    }

    /**
     * Crea una estantería
     * @param array $valores
     * @param string $CodigoAlmacen
     * @return boolean
     */
    public function createEstanteria($valores, $CodigoAlmacen) {
        $codigo = $this->generarCodigo();
        $Sql = "INSERT INTO estanteria VALUES ('$codigo', '$CodigoAlmacen'";
        foreach ($valores as $valor) {
            $Sql.=", '$valor'";
        }
        $Sql.=")";
        return $this->execute_single_query($Sql);
    }

    /**
     * Elimina una Estantería
     * @param string $codigo
     * @return boolean
     */
    public function deleteEstanteria($codigo) {
        $Sql = "DELETE FROM estanteria WHERE codigo='$codigo'";
        return $this->execute_single_query($Sql);
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
     * @param array $valores
     * @param string $CodigoEstanteria
     * @return boolean
     */
    public function updateItem($valores, $CodigoEstanteria) {
        $Sql = "UPDATE item SET ";

        if (is_array($valores)) {
            foreach ($valores as $fila) {
                $i = 0;
                $CodigoItem = $fila['Codigo'];
                foreach ($fila as $columna => $valor) {
                    if (!($i % 2 == 0)) {
                        $Sql .= $columna . "= '" . $valor . "', ";
                    }
                    $i++;
                }
                $Sql = substr($Sql, 0, strlen($Sql) - 2);
                if ($CodigoEstanteria != '') {
                    $Sql.=" WHERE CodigoEstanteria='$CodigoEstanteria' AND Codigo='$CodigoItem'";
                   return $this->execute_single_query($Sql);
                }
            }
        }
        return false;
    }

    /**
     * Actualiza la cantidad de un item
     * @param float $numero
     * @param string $CodigoItem
     * @param string $CodigoEstanteria
     * @return boolean
     */
    public function updateCantidad($numero, $CodigoItem, $CodigoEstanteria) {
        $Sql = "UPDATE Item SET Cantidad = '$numero' WHERE Codigo = '$CodigoItem' AND CodigoEstanteria='$CodigoEstanteria'";
       return $this->execute_single_query($Sql);
    }

    /**
     * Crea un nuevo item en una estantería
     * @param array $item
     * @param string $CodigoEstanteria
     * @return boolean
     */
    public function createItem($item, $CodigoEstanteria) {
        $Sql = "UPDATE Items SET ";
        if (is_array($item)) {
            foreach ($valores as $id => $valor) {
                $Sql .= $id . "=" . $valor . " ";
            }
            $Sql.=" WHERE CodigoEstanteria='$CodigoEstanteria'";
        }

       return $this->execute_single_query($Sql);
    }

    /**
     * Elimina un Item de una Estantería
     * @param string $CodigoItem
     * @param string $CodigoEstanteria
     * @return boolean
     */
    public function deleteItem($CodigoItem, $CodigoEstanteria) {
        $Sql = "DELETE FROM Item WHERE Codigo = '$CodigoItem'  AND CodigoEstanteria='$CodigoEstanteria'";
        return $this->execute_single_query($Sql);
    }

    /*
      ------------------------------------ / ITEMS ---------------------------
     */


    /*
      ------------------------------------ USUARIOS ---------------------------
     */

    /**
     * Registra un nuevo usuario
     * @param array $valores
     * @return boolean
     */
    public function registrar($valores) {
        $Sql = "INSERT INTO usuario VALUES (";
        foreach ($valores as $valor) {
            $Sql.="'$valor', ";
        }
         $Sql = substr($Sql, 0, strlen($Sql) - 2);
         $Sql.=")";
        return $this->execute_single_query($Sql);
    }

    /**
     * Devuelve si un usuario es correcto o no.
     * @param string $nombre
     * @param string $pass
     * @return boolean
     */
    public function login($nombre, $pass) {
        $sql="SELECT * FROM usuario WHERE NombreUsuario='$nombre' AND Password='$pass'";
        return $this->execute_single_query($sql);
    }

    /*
      ------------------------------------ / USUARIOS ---------------------------
     */

    /*
     * ----------------------------------- Funciones Privadas -----------------------
     */

    /**
     * Genera un código único de 20 caracteres
     * @return string
     */
    private function generarCodigo() {
        return openssl_random_pseudo_bytes(20);
    }
/**
 * Añade una relación entre un usuario y un almacén
 * @param string $Usuario
 * @param string $CodigoAlmacen
 * @return boolean
 */
    private function gestionar($Usuario, $CodigoAlmacen) {
        $Sql = "INSERT INTO gestiona VALUES ('$CodigoAlmacen', '$Usuario')";
       return $this->execute_single_query($Sql);
    }

}
