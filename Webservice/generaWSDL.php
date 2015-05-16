<?php

require_once("Consulta.php");
// Ruta a WSDLDocument
require_once("WSDLDocument.php");

$uri = "http://localhost/DWES/WebService_StockDroid/Webservice";
$url = "$uri/SoapServer.php";
$wsdl = new WSDLDocument("Consulta",$url,$uri); 
echo $wsdl->saveXml();

