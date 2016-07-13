<?php

namespace World\GeoObjectsBundle\GeoObjects;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use World\GeoObjectsBundle\Exceptions\JsonException;
use World\GeoObjectsBundle\Exceptions\IncorrectFormatException;

class GeoObjects {
    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function receiveData() {
        $geoObjectsHost = $this->container->getParameter('geo_objects.host');
        $json = $this->container->get('anchovy.curl')->setURL($geoObjectsHost)->execute();

        return $json;
    }

    public function getList() {
        $json = $this->receiveData();
        $response = json_decode($json, true);

        $json_error_code = json_last_error();
        if ($json_error_code != JSON_ERROR_NONE) {
            throw new JsonException($json_error_code);
        }

        if (!is_array($response) || !array_key_exists('data', $response) || !array_key_exists('success', $response)) {
            throw new IncorrectFormatException();
        }

        if (!$response['success']) {
            throw new ErrorException($response['data']['message'], $response['data']['code']);
        }

        $locations = array();
        if ($response['success'] && array_key_exists('locations', $response['data'])) {
            $locations = $response['data']['locations'];
        }

        return $locations;
    }
}
