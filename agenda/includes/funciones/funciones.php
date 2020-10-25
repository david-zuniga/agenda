<?php

function obtenerContactos() {
    include 'db.php';
    try {
        return $conn->query("SELECT Id, Nombre, Empresa, Telefono FROM Contactos");
    } catch (Exception $e){
        echo "Error!!!" . $e->getMessage() . "<br>";
        return false;
    }
}

//Obtiene un contacto
function obtenerContacto($id) {
    include 'db.php';
    try {
        return $conn->query("SELECT Id, Nombre, Empresa, Telefono FROM Contactos WHERE Id = $id");
    } catch (Exception $e){
        echo "Error!!!" . $e->getMessage() . "<br>";
        return false;
    }
}
