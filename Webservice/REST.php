<?php

require_once "./Consulta.php";
$response = array();
$consulta= new Consulta();
/**
 * Obtiene los almacenes de un usuario.
 */

 $response['message'] = "ok";
 
 //ALMACENES
 
if (isset($_POST['getAlmacenes'])) {
    $response['message'] = "getAlmacenes";
    $response['success'] = 0;
    $response['almacenes'] = array();
    $usuario = $_POST['usuario'];
    $rows = array();
    if ($usuario != '') {
        $query = "SELECT * FROM `almacen`, gestiona WHERE gestiona.CodigoAlmacen = almacen.Codigo and gestiona.NombreUsuario = '$usuario'";
       
        $rows = $consulta->get_results_from_query($query);
        for ($i = 0; $i<count($rows); $i++){
            $almacen=array();
            $almacen['Codigo']=$rows[$i]['Codigo'];
            $almacen['Nombre']=$rows[$i]['Nombre'];
            $almacen['Descripcion']=$rows[$i]['Descripcion'];
             $almacen['Creador']=$rows[$i]['Creador'];
            array_push($response['almacenes'], $almacen);
        }

        $response['success'] = 1;
        echo json_encode($response);
    } else {
        $response['message'] = "Usuario vacío";
        echo json_encode($response);
    }
}
// /Almacenes

//ESTANTERIAS
if (isset($_POST['getEstanterias'])) {
    $response['message'] = "getEstanterias";
    $response['success'] = 0;
    $response['estanterias'] = array();
    $CodigoAlmacen = $_POST['CodigoAlmacen'];
    $rows = array();
    if ($CodigoAlmacen != '') {
        $query = "SELECT * FROM estanteria WHERE CodigoAlmacen = '$CodigoAlmacen'";
       
        $rows = $consulta->get_results_from_query($query);
        for ($i = 0; $i<count($rows); $i++){
            $estanteria=array();
            $estanteria['Codigo']=$rows[$i]['Codigo'];
             $estanteria['CodigoAlmacen']=$rows[$i]['CodigoAlmacen'];
            $estanteria['Nombre']=$rows[$i]['Nombre'];
            $estanteria['Descripcion']=$rows[$i]['Descripcion'];
            array_push($response['estanterias'], $estanteria);
        }

        $response['success'] = 1;
        echo json_encode($response);
    } else {
        $response['message'] = "CodigoAlmacen vacío";
        echo json_encode($response);
    }
}
// /Estatnerias

//ITEMS O ITEM
if (isset($_POST['getItems'])) {
    $response['message'] = "getItems";
    $response['success'] = 0;
    $response['items'] = array();
    $CodigoEstanteria = $_POST['CodigoEstanteria'];
    $rows = array();
    if ($CodigoEstanteria != '') {
        $query = "SELECT * FROM Item WHERE CodigoEstanteria = '$CodigoEstanteria'";
        if(isset($_POST['CodigoItem'])){
            $codigo= $_POST['CodigoItem'];
            $query.=" AND Codigo = '$codigo'";
        }
       
        $rows = $consulta->get_results_from_query($query);
        for ($i = 0; $i<count($rows); $i++){
            $item=array();
            $item['Codigo']=$rows[$i]['Codigo'];
             $item['CodigoEstanteria']=$rows[$i]['CodigoEstanteria'];
              $item['Cantidad']=$rows[$i]['Cantidad'];
            $item['Nombre']=$rows[$i]['Nombre'];
            $item['Descripcion']=$rows[$i]['Descripcion'];
            array_push($response['items'], $item);
        }

        $response['success'] = 1;
        echo json_encode($response);
    } else {
          if(isset($_POST['CodigoItem'])){
              $response['message'] = "Item no encontrado";
          }else{
              $response['message'] = "CodigoEstanteria vacía";
          }
        
        echo json_encode($response);
    }
    
}

 
    if (isset($_POST['updateCantidad'])) {
      $response['message'] = "update";
    $response['success'] = 0;
   
    $CodigoEstanteria = $_POST['CodigoEstanteria'];
    $numero=$_POST['numero'];
 
  if(isset($_POST['CodigoItem'])){
      
            $CodigoItem= $_POST['CodigoItem'];
           
        $query = "UPDATE Item SET Cantidad = '$numero' WHERE Codigo = '$CodigoItem'";
       
        }
       
        if ($consulta->execute_single_query($query)){
           
         $response['success'] = 1;
          
        }else{
            $response['message'] = "El item no se ha actualizado";
            
        }
       
 echo json_encode($response);
       
      
    }
    
    
      if (isset($_POST['updateItem'])) {
      $response['message'] = "update";
    $response['success'] = 0;
   
   
    $cantidad=$_POST['numero'];
    $nombre=$_POST['nombre'];
    $descripcion= $_POST['descripcion'];
    
 
  if(isset($_POST['CodigoItem'])){
      
            $CodigoItem= $_POST['CodigoItem'];
           
        $query = "UPDATE item SET Nombre='$nombre', Cantidad='$cantidad', Descripcion='$descripcion' WHERE Codigo='$CodigoItem'";
       
        }
       
        if ($consulta->execute_single_query($query)){
           
         $response['success'] = 1;
          
        }else{
            $response['message'] = "El item no se ha actualizado";
              
        }
       
 echo json_encode($response);
       
      
    } 
    