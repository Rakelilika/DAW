<?php


 function autoload_b37daa544f4f0dbdfeaa5349f6030f64($class)
{
    $classes = array(
        'Clases\Clases1\ClasesOperacionesServiceCustom6' => __DIR__ .'/ClasesOperacionesServiceCustom6.php'
    );
    if (!empty($classes[$class])) {
        include $classes[$class];
    };
}

spl_autoload_register('autoload_b37daa544f4f0dbdfeaa5349f6030f64');

// Do nothing. The rest is just leftovers from the code generation.
{
}
