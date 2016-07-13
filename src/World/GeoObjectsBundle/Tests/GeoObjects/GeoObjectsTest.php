<?php

namespace World\GeoObjectsBundle\Tests\GeoObjects;

use World\GeoObjectsBundle\GeoObjects\GeoObjects;
use Symfony\Component\DependencyInjection\Container;
use World\GeoObjectsBundle\Exceptions\JsonException;
use World\GeoObjectsBundle\Exceptions\IncorrectFormatException;

class GeoObjectsTest extends \PHPUnit_Framework_TestCase
{
    public function setUp() {
        $this->container = new Container();

        $this->geo = new GeoObjects($this->container);

    }

    public function testCorrectJson()
    {
        $correct_json = <<<END
    {
        "data": {
            "locations": [
                {
                    "name": "Eiffel Tower",
                    "coordinates": {
                        "lat": 21.12,
                        "long": 19.56
                    }
                }
            ]
        },
        "success": true
    }
END;

        $locations = $this->geo->getList($correct_json);

        $expected = [
            [
                "name" => "Eiffel Tower",
                "coordinates" => [
                    "lat" => 21.12,
                    "long" => 19.56
                ]
            ]
        ];

        $this->assertEquals($expected, $locations);
    }

    public function testNotJson()
    {
        $this->expectException(JsonException::class);
        $this->geo->getList('not_json');
    }

    public function testIncorrectFormat()
    {
        $this->expectException(IncorrectFormatException::class);
        $this->geo->getList('[]');
    }

    public function testErrorResponseFormat()
    {
        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage('some error message');
        $this->expectExceptionCode(123);

        $json = <<<END
    {
        "data": {
            "message": "some error message",
            "code": 123
        },
        "success": false
    }
END;

        $this->geo->getList($json);

    }

    public function testIncorrectLocationsArrayKey()
    {
        $this->expectException(IncorrectFormatException::class);
        $json = <<<END
    {
        "data": {
            "locations": [
                {
                    "name": "Eiffel Tower",
                    "coordinates": {
                        "lat_incorrect_name": 21.12,
                        "long": 19.56
                    }
                }
            ]
        },
        "success": true
    }
END;
        $this->geo->getList($json);
    }

    public function testIncorrectLocationsArrayValue()
    {
        $this->expectException(IncorrectFormatException::class);
        $json = <<<END
            {
                "data": {
                    "locations": [
                        {
                            "name": "Eiffel Tower",
                            "coordinates": {
                                "lat": "error_not_numeric_value",
                                "long": 19.56
                            }
                        }
                    ]
                },
                "success": true
            }
END;
                $this->geo->getList($json);
    }



}