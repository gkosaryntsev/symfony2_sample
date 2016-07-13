<?php
namespace World\GeoObjectsBundle\Exceptions;
/**
 * @author gkosaryntsev
 */
class IncorrectFormatException extends \Exception
{
    public function __construct()
    {
        $this->message = 'Incorrect data format received from host';
    }
}