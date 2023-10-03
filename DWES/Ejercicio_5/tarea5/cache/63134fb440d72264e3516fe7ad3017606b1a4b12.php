<!--Llamamos a plantilla genérica-->

<?php $__env->startSection('titulo'); ?>
    <?php echo e($titulo); ?>

<?php $__env->stopSection(); ?>
<!--Llamamos a plantilla con encabezado-->
<?php $__env->startSection('encabezado'); ?>
    <?php echo e($encabezado); ?>

<?php $__env->stopSection(); ?>
<!--Creamos plantilla para en contenido de la propia página-->
<?php $__env->startSection('contenido'); ?>
    <form id="crear" name="form" action="<?php echo e($destino); ?>" method="POST">
        <label for='nombre'>Nombre </label>
		<input type ="text" id='nombre' name='nombre' placeholder ='Nombre'><br><br>
        <label for='apellidos'>Apellidos </label>
		<input type ="text" id='apellidos' name='apellidos' placeholder ='Apellido'><br><br>
        <label for='dorsal'>Dorsal </label>
		<input type ="number" id='dorsal' name='dorsal' placeholder ='Dorsal'><br><br>
        <label for='posicion'>Posición </label>
        <!--Recorremos array de posiciones enviado desde controlador y montamos select con las opciones del mismo-->
		<select id='posicion' name='posicion'>
            <?php $__currentLoopData = $posiciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($item); ?>"><?php echo e($item); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select><br><br>
        <label for='codigo'>Código de barras </label>
		<input type ="text" id='codigo' name='barcode' value='<?php echo e($barcode); ?>' placeholder ='Codigo de barras' readonly><br><br>
        <input id="btcrear" type="submit" name="crear" value="Crear"/>
        <input id="btlimpiar" type="reset" name="limpiar" value="Limpiar"/>
        <a href='<?php echo e($volver); ?>'><input id="btvolver" type='button' value='Volver'/></a>
        <a href='<?php echo e($generarBarcode); ?>'><input id="btgenerar" type='button' value='Generar Barcode'/></a>
    </form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantillas.plantilla1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\DWES\tarea5\views/vcrear.blade.php ENDPATH**/ ?>