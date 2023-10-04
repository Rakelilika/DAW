<?php

namespace Clases\Clases1;

class ClasesOperacionesService extends \SoapClient
{

    /**
     * @var array $classmap The defined classes
     */
    private static $classmap = array (
);

    /**
     * @param array $options A array of config values
     * @param string $wsdl The wsdl file to use
     */
    public function __construct(array $options = array(), $wsdl = null)
    {
    
  foreach (self::$classmap as $key => $value) {
    if (!isset($options['classmap'][$key])) {
      $options['classmap'][$key] = $value;
    }
  }
      $options = array_merge(array (
  'features' => 1,
), $options);
      if (!$wsdl) {
        $wsdl = 'http://localhost/DWES/tarea6/servidorSoap/servicio.wsdl';
      }
      parent::__construct($wsdl, $options);
    }

    /**
     * Obtener el precio del producto que tenga el código que le pasemos
     *
     * @param int $cod
     * @return float
     */
    public function getPvp($cod)
    {
      return $this->__soapCall('getPvp', array($cod));
    }

    /**
     * Obtener los codigos de las familias de la base de datos
     *
     * @return Array
     */
    public function getFamilias()
    {
      return $this->__soapCall('getFamilias', array());
    }

    /**
     * Obtener los codigos de los productos a partir del codigo de la familia
     *
     * @param string $codigo
     * @return Array
     */
    public function getProductosFamilia($codigo)
    {
      return $this->__soapCall('getProductosFamilia', array($codigo));
    }

    /**
     * Obtener el stock de un producto y una tienda contretos
     *
     * @param int $codigo
     * @param int $tienda
     * @return int
     */
    public function getStock($codigo, $tienda)
    {
      return $this->__soapCall('getStock', array($codigo, $tienda));
    }

}
