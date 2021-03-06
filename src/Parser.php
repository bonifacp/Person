<?php

namespace UWDOEM\Person;

/**
 * Static class to encapsulate parsing of the web-service response
 *
 * @package UWDOEM\Person
 */
class Parser
{

    /**
     * @param string $resp
     * @return array
     */
    public static function parse($resp)
    {
        return json_decode($resp, true);
    }
}
