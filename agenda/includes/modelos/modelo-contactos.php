<?php

if(isset($_POST['accion']) && $_POST['accion'] == 'crear') {
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

if(isset($_GET['accion']) == 'borrar') {
    require_once('../funciones/db.php');

    $id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);

    try {
        $statement = $conn->prepare("DELETE FROM Contactos WHERE Id = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        if($statement->affected_rows == 1) {
            $respuesta = array (
                'respuesta' => 'correcto'
            );
        }

        $statement->close();
        $conn->close();
    } catch(Exception $e) {
        $respuesta = array (
            'error' => $e->getMessage()
        );
    }

    echo json_encode($respuesta);
}

if(isset($_POST['accion']) == 'editar' && $_POST['accion'] == 'editar') {
    //echo json_encode($_POST);

    require_once('../funciones/db.php');

    //Validar las entradas
    $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
    $empresa = filter_var($_POST['empresa'], FILTER_SANITIZE_STRING);
    $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_STRING);
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);

    try {
        $statement = $conn->prepare("UPDATE Contactos SET Nombre = ?, Empresa = ?, Telefono = ? WHERE Id = ?");
        $statement->bind_param("sssi", $nombre, $empresa, $telefono, $id);
        $statement->execute();

        if ($statement->affected_rows == 1) {
            $respuesta = array (
                'respuesta' => 'correcto'
            );
        } else {
            $respuesta = array (
                'respuesta' => 'error'
            );
        }

        $statement->close();
        $conn->close();
    } catch (Exception $e) {
        $respuesta = array (
            'error' => $e->getMessage()
        );
    }

    echo json_encode($respuesta);
}