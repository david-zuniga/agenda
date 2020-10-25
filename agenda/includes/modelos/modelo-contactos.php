<?php

//if($_POST['accion'] == 'crear') {
if($_POST) {
    //Creare un nuevo registro en la bse de datos
    require_once('../funciones/db.php');

    //Validar las entradas
    $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
    $empresa = filter_var($_POST['empresa'], FILTER_SANITIZE_STRING);
    $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING);

    try {
        $statement = $conn->prepare("INSERT INTO Contactos (Nombre, Empresa, Telefono) 
                                    VALUES (?, ?, ?)");
        $statement->bind_param("sss", $nombre, $empresa, $telefono);
        $statement->execute();

        $respuesta = array(
            'respuesta' => 'correcto',
            'datos' => array(
                'nombre' => $nombre,
                'empresa' => $empresa,
                'telefono' => $telefono,
                'id_insertado' => $statement->insert_id
            )
        );

        $statement->close();
        $conn->close();
    } catch(Exception $e) {
        $respuesta = array (
            'error' => $e->getMessage()
        );
    }

    echo json_encode($respuesta);
}

//if($_GET['accion'] == 'borrar') {
if($_GET) {

    require_once('../funciones/db.php');

    $id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);

    try {
        $smtp = $conn->prepare("DELETE FROM Contactos WHERE Id = ?");
        $smtp->bind_param("i", $id);
        $smtp->execute();
        if($smtp->affected_rows == 1) {
            $respuesta = array (
                'respuesta' => 'correcto'
            );
        }

        $smtp->close();
        $conn->close();
    } catch(Exception $e) {
        $respuesta = array (
            'error' => $e->getMessage()
        );
    }

    echo json_encode($respuesta);
}