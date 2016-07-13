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

    public function getLocations() {
        $json = $this->receiveData();

        $locations = $this->getList($json);

        return $locations;
    }

    public function getList($json) {
        $response = json_decode($json, true);

        $json_error_code = json_last_error();
        if ($json_error_code != JSON_ERROR_NONE) {
            throw new JsonException($json_error_code);
        }

        if (!is_array($response) || !array_key_exists('data', $response) || !array_key_exists('success', $response)) {
            throw new IncorrectFormatException();
        }

        if (!$response['success']) {
            throw new \ErrorException($response['data']['message'], $response['data']['code']);
        }

        $locations = [];
        if ($response['success'] && array_key_exists('locations', $response['data']) && is_array($response['data']['locations'])) {
            $locations = $response['data']['locations'];
            foreach($locations as $location) {
                if (!is_array($location) || !array_key_exists('name', $location) || !array_key_exists('coordinates', $location)
                    || !is_array($location['coordinates'])
                    || !array_key_exists('lat', $location['coordinates']) || !is_numeric($location['coordinates']['lat'])
                    || !array_key_exists('long', $location['coordinates']) || !is_numeric($location['coordinates']['long'])
                ) {
                    throw new IncorrectFormatException();
                }
            }
        }

        return $locations;
    }
}
