<?php
namespace World\GeoObjectsBundle\Exceptions;
/**
 * @author gkosaryntsev
 */
class JsonException extends \Exception
{
    public function __construct($json_error_code)
    {
        switch ($json_error_code) {
            case JSON_ERROR_NONE:
                $json_error = 'No errors';
                break;
            case JSON_ERROR_DEPTH:
                $json_error = 'Maximum stack depth exceeded';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $json_error = 'Underflow or the modes mismatch';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $json_error = 'Unexpected control character found';
                break;
            case JSON_ERROR_SYNTAX:
                $json_error = 'Syntax error, malformed JSON';
                break;
            case JSON_ERROR_UTF8:
                $json_error = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
            default:
                $json_error = 'Unknown error';
                break;
        }

        $this->message = sprintf('JSON error: %s', $json_error);
        $this->code = $json_error_code;
    }
}