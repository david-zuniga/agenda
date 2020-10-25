<div class="campos">
    <div class="campo">
        <label for="nombre">Nombre:</label>
        <input 
            type="text" 
            id="nombre" 
            placeholder="Nombre Contacto" 
            value="<?php echo (isset($contacto['Nombre'])) ? $contacto['Nombre'] : ''; ?>"
        >
    </div>
    <div class="campo">
        <label for="empresa">Empresa:</label>
        <input 
            type="text" 
            id="empresa" 
            placeholder="Nombre Empresa" 
            value="<?php echo (isset($contacto['Empresa'])) ? $contacto['Empresa'] : ''; ?>"
        >
    </div>
    <div class="campo">
        <label for="telefono">Teléfono:</label>
        <input 
            type="tel" 
            id="telefono" 
            placeholder="Teléfono" 
            value="<?php echo (isset($contacto['Telefono'])) ? $contacto['Telefono'] : ''; ?>"
        >
    </div>
</div>
<div class="campo enviar">
    <?php
        $textoBtn = (isset($contacto['Telefono'])) ? 'Guardar' : 'Añadir';
        $accion = (isset($contacto['Telefono'])) ? 'editar' : 'crear';
    ?>
    <input type="hidden" id="accion" value="<?php echo $accion; ?>">
    <?php if (isset($contacto['Id'])) { ?>
        <input Type="hidden" id="id" value="<?php echo $contacto['Id']; ?>">
    <?php } ?>
    <input type="submit" value="<?php echo $textoBtn; ?>">
</div>