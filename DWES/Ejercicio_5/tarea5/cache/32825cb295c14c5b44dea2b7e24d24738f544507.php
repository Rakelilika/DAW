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
<div id="listado">
    <!--Si existe la variable mensaje y tiene contenido, la mostramos en su propio párrafo-->
    <?php if($mensaje): ?>
        <p><?php echo e($mensaje); ?></p>
    <?php endif; ?>
    <a href='<?php echo e($destino); ?>'><input class="boton" type='button' value='Nuevo Jugador'/></a><br><br>
    <table id="table">
        <thead>
            <tr>
                <th scope="col">Nombre Completo</th>
                <th scope="col">Posición</th>
                <th scope="col">Dorsal</th>
                <th scope="col">Codigo de Barras</th>
            </tr>
        </thead>
        <tbody>
        <!--Recorremos colección de jugadores recibida desde el controlador-->
        <?php $__currentLoopData = $jugadores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($item->nombre); ?> <?php echo e($item->apellidos); ?></td>
                <td><?php echo e($item->posicion); ?></td>
                <td>
                    <!--Si el dorsal está vacío mostramos el texto 'Sin asignar', esta lógica no se va a realizar nunca
                        puesto que dicho campo está capado a nivel de bbdd y no puede estar vacío, aunque el ejercicio
                        requería realizar tal comprobación por lo que se ha tenido en cuenta-->
                    <?php if(empty($item->dorsal)): ?>
                        Sin asignar
                    <?php else: ?>
                        <?php echo e($item->dorsal); ?>

                    <?php endif; ?>
                </td>
                <!--Representamos código de barras usando php y el objeto dns recibido desde el controlador-->
                <td id="barras"><?php echo $dns->getBarcodeHTML($item->barcode, 'EAN13', 2, 33, 'white'); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('plantillas.plantilla1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\DWES\tarea5\views/vjugadores.blade.php ENDPATH**/ ?>