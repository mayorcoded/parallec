<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 5/26/18
 * Time: 4:58 PM
 */

namespace mayorcoded\parallec\Utilities;
use mayorcoded\parallec\Exceptions\ParallecInvalidParameterException;

class ParallecUtilities
{

    /**
     * @param $url
     * @param array $parameters
     * @return resource
     * @throws ParallecInvalidParameterException
     *
     * set up curl handler for a request with a url and  optional parameters
     */
    public static function setUpCurlHandler($url, $parameters = array()){

        if(self::urlIsValid($url)) {
            $curlHandler = curl_init($url);
            curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, 1);

            foreach ($parameters as $parameter => $value) {
                curl_setopt($curlHandler, $parameter, $value);
            }

            return $curlHandler;
        }else{
            throw new ParallecInvalidParameterException('Url must be a valid url');
        }
    }

    private static function urlIsValid($url){

        if(isset($url)){
            if(filter_var($url, FILTER_VALIDATE_URL)){
                return true;
            }else{
                return false;
            }
        }

        return false;
    }
}