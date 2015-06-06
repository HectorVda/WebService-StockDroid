<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$cliente = new SoapClient("http://localhost/DWES/WebService_StockDroid/Webservice/SoapServer.php?wsdl");

/*
echo "Items de la estantería Ironlak <br>";
$rows = $cliente->getItems('Ironlak');
printArray($rows);

echo "<br> Despues de modificar: <br>";
$cliente->updateCantidad('1.5', 'RojoFiebre', 'Ironlak');
$rows = $cliente->getItems('Ironlak');
printArray($rows);

echo "<br> Añado descripción: <br>";
$rows[0]['Descripcion'] = "Atora mucho las boquillas";
$a=$cliente->updateItem($rows, 'Ironlak');
echo "<br>".$a."<br>";
$rows = $cliente->getItems('Ironlak');
printArray($rows);

echo "<br> Todos los almacenes de Usuario: <br>";
$rows=$cliente->getAlmacenes("Usuario");
printArray($rows);
*/

//echo $cliente->login("Usuario","Usuario");
echo $cliente->deleteGestion("hector", "556f17a29efea"); 

function printArray($array){
    foreach ($array as $fila) {
        $i=0;
        foreach ($fila as $columna => $valor){
            if(!($i%2==0)){
                echo $columna." / ".$valor."<br>";
            }
            $i++;
        }
    }
}