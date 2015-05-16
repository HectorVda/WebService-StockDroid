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
 * Muestra los almacenes a los que tiene acceso un usuarioº
 * @param string $usuario
 * @return array
 */
public function getAlmacenes($usuario){
$rows = array();
if ($usuario != '') {
$query = "SELECT * FROM `almacen`, gestiona WHERE gestiona.CodigoAlmacen = almacen.Codigo and gestiona.NombreUsuario = '$usuario'";
$rows = $this->get_results_from_query($query);
}

return $rows;
}
/*
  public function updateAlmacenes(){
  return 124;
  }

  public function createAlmacenes(){
  return 124;
  }

  public function deleteAlmacenes(){
  return 124;
  }
 */
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
public function getEstanterias($CodigoAlmacen){
$rows = array();
if ($CodigoAlmacen != '') {
$query = "SELECT * FROM estanteria WHERE CodigoAlmacen = '$CodigoAlmacen'";
$rows = $this->get_results_from_query($query);
}

return $rows;
}
/*
  public function updateEstanteria(){
  return true;
  }

  public function createEstanteria(){
  return true;
  }

  public function deleteEstanteria(){
  return true;
  }
 */
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
 * 
 * @param array $valores
 * @param string $CodigoEstanteria
 */
public function updateItem($valores, $CodigoEstanteria) {
        $Sql = "UPDATE item SET ";

        if (is_array($valores)) {
            foreach ($valores as $fila) {
                $i = 0;
                foreach ($fila as $columna => $valor) {
                    if (!($i % 2 == 0)) {
                        $Sql .= $columna . "= '" . $valor . "', ";
                    }
                    $i++;
                }
                $Sql=substr($Sql, 0, strlen($Sql)-2);
                if ($CodigoEstanteria != '') {
                    $Sql.=" WHERE CodigoEstanteria='$CodigoEstanteria'";
                    $this->execute_single_query($Sql);
                }
            }
        }
       
    }

    /**
 * Actualiza la cantidad de un item
 * @param float $numero
 * @param string $CodigoItem
 * @param string $CodigoEstanteria
 */
public function updateCantidad($numero, $CodigoItem, $CodigoEstanteria) {
$Sql = "UPDATE Item SET Cantidad = '$numero' WHERE Codigo = '$CodigoItem' AND CodigoEstanteria='$CodigoEstanteria'";
$this->execute_single_query($Sql);
}

/**
 * Crea un nuevo item en una estantería
 * @param array $item
 * @param string $CodigoEstanteria
 */
public function createItem($item, $CodigoEstanteria) {
$Sql = "UPDATE Items SET ";
if (is_array($item)) {
foreach ($valores as $id => $valor) {
$Sql .= $id . "=" . $valor . " ";
}
$Sql.=" WHERE CodigoEstanteria='$CodigoEstanteria'";
}

$this->execute_single_query($Sql);
}

/**
 * Elimina un Item de una Estantería
 * @param string $CodigoItem
 * @param string $CodigoEstanteria
 */
public function deleteItem($CodigoItem, $CodigoEstanteria) {
$Sql = "UPDATE Items SET Cantidad = '$numero' WHERE Codigo = '$CodigoItem' AND CodigoEstanteria='$CodigoEstanteria'";
$this->execute_single_query($Sql);
}

/*
  ------------------------------------ / ITEMS ---------------------------
 */


/*
  ------------------------------------ USUARIOS ---------------------------
 */
/*
  public function registrar(){

  }

  public function login(){

  }
  /*
  ------------------------------------ USUARIOS ---------------------------
 */
}
