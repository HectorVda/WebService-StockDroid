<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'Consulta.php';

$server = new SoapServer("http://localhost/DWES/WebService_StockDroid/Webservice/SoapServer.wsdl");
$server->setClass("Consulta");
$server->handle();
