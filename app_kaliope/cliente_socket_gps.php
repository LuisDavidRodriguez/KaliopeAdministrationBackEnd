<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$i=0;
$host = 'kaliope.com.mx';
$port = '25001';

while ($i<1){
    $message = "Hola";
    $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket \n");
    $result = socket_connect($socket, $host, $port) or die ("Could not connect to server \n");
    socket_write($socket, $message, strlen($message)) or die("Couldn't send data to server \n");//escribimos la informacion que le llegara al servidor
    
    $result = socket_read($socket, 1024) or die("Couldn't read server response\n"); //recivimos la informacion que nos envia el servidor
    echo $result . "\n";
    socket_close($socket);
    $i++;
}