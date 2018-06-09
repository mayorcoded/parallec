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
     * keeps the timing for curl connections
     *
     * @var array
     */
    private static $curlTimers = array();

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

    public static function verifyCurlHandle($curlHandle){
        if(gettype($curlHandle) !== 'resource')
        {
            throw new ParallecInvalidParameterException('Parameter must be a valid curl handle');
        }
    }

    public static function urlIsValid($url){

        if(isset($url)){
            if(filter_var($url, FILTER_VALIDATE_URL)){
                return true;
            }else{
                return false;
            }
        }

        return false;
    }

    public static function getResourceId($curlHandler){
        return (string)$curlHandler;
    }

    public static function startCurlTimer($resourceId){
        self::$curlTimers[$resourceId]['start_request'] = microtime(true);
    }

    public static function stopCurlTimer($resourceId, $curlResponse){
        self::$curlTimers[$resourceId]['end_request'] = microtime(true);
        self::$curlTimers[$resourceId]['api'] = curl_getinfo($curlResponse['handle'], CURLINFO_EFFECTIVE_URL);
        self::$curlTimers[$resourceId]['time'] = curl_getinfo($curlResponse['handle'], CURLINFO_TOTAL_TIME);
        self::$curlTimers[$resourceId]['code'] = curl_getinfo($curlResponse['handle'], CURLINFO_HTTP_CODE);
    }
}
