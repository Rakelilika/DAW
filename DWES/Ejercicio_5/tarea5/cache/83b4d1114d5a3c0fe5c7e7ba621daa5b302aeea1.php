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
    <!--<a href='crearDatos.php'><input type='button' value='Instalar Datos de Ejemplo'/></a>-->
    <!--Hemos optado por realizar la llamada a la página destino usando el action de un formulario,
        en otras vistas hemos realizado dicha redirección usando un botón como enlace-->
    <form id="instalacion" name="form" action="<?php echo e($destino); ?>" method="POST">
        <input class="boton" type="submit" name="cambiar" value="Instalar Datos de Ejemplo"/>
    </form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantillas.plantilla1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\DWES\tarea5\views/vinstalacion.blade.php ENDPATH**/ ?>