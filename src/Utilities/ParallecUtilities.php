<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 5/26/18
 * Time: 4:58 PM
 */

namespace mayorcoded\parallec\Exceptions;


class ParallecUtilities
{

    /**
     * @param $url
     * @param $parameters
     * @return resource
     *
     * set up curl handler for a request with a url and  optional parameters
     */
    public static function setUpCurlHandler($url, $parameters = array()){
        $curlHandler = curl_init($url);
        curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER,1);

        foreach ($parameters as $parameter => $value){
            curl_setopt($curlHandler, $parameter, $value);
        }

        return $curlHandler;
    }
}