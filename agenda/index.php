<?php 
include 'includes/funciones/funciones.php';
include 'includes/layout/header.php';
?>

<div class="contenedor-barra">
    <h1>Agenda de Contactos</h1>
</div>

<div class="bg-amarillo contenedor sombra">
    <form id="contacto" action="#">
        <legend>Añada un contacto <span>Todos los campos son obligatorios</span></legend>

        <?php include 'includes/layout/formulario.php'; ?>
    </form>
</div>

<div class="bg-blanco contenedor sombra contactos">
    <div class="contenedor-contactos">
        <h2>Contactos</h2>
        <input type="text id="buscar" class="buscador sombra" placeholder="Bucar Contactos...">
        <p class="total-contactos"> <span>2 </span>Contactos</p>
        <div class="contenedor-tabla">
            <table class="listado-contactos">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Empresa</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $contactos = obtenerContactos();
                        if($contactos->num_rows) { 
                            foreach($contactos as $contacto) {?>

                                <tr>
                                    <td><?php echo $contacto['Nombre']; ?></td>
                                    <td><?php echo $contacto['Empresa']; ?></td>
                                    <td><?php echo $contacto['Telefono']; ?></td>
                                    <td>
                                        <a class="btn-editar btn" href="editar.php?id=<?php echo $contacto['Id']; ?>">
                                            <i class="fas fa-pen-square"></i>
                                        </a>
                                        <button data-id="<?php echo $contacto['Id']; ?>" type="button" class="btn-borrar btn">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>

                            <?php } ?>
                        <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/layout/footer.php'; ?>