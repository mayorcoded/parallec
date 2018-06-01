<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 5/25/18
 * Time: 10:13 PM
 */

namespace mayorcoded\parallec;
use mayorcoded\parallec\Model\ParallecCurlModel;
use mayorcoded\parallec\Utilities\ParallecUtilities;

class Parallec
{

    /**
     * This field stores curl options on instantiation of the class
     *
     * @var $curlOptions
     */
    private $curlOptions;

    /**
     * Ensures that only once instance of the class exists
     *
     * @var null
     */
    private static $instance = NULL;

    private $multicurlHandle;
    private $activeCurlExecution = null;
    private $executionStatus;
    private $requests = array();
    private $responses = array();

    /**
     * Make class singleton with private access
     *
     * Parallec constructor.
     */
    private function __construct()
    {
        $this->multicurlHandle = curl_multi_init();
        $this->curlOptions = array(
            'http_code' => CURLINFO_HTTP_CODE,
            'total_time' => CURLINFO_TOTAL_TIME,
            'content_length' => CURLINFO_CONTENT_LENGTH_DOWNLOAD,
            'content_type' => CURLINFO_CONTENT_TYPE,
            'url' => CURLINFO_EFFECTIVE_URL
        );

    }

    /**
     * Provide only one instance of a class
     *
     * @return Parallec|null
     */
    public static function getInstance(){
        if(self::$instance == NULL){
            self::$instance = new Parallec();
        }

        return self::$instance;
    }


    /**
     * Make curl request on a url with optional curl parameters
     *
     * @param $url
     * @param array $parameters
     * @return ParallecCurlModel
     */
    public function ping($url, $parameters = array()){

        $curlHandler = ParallecUtilities::setUpCurlHandler($url, $parameters);

        return $this->processRequest($curlHandler);
    }

    /**
     * Process each curl request
     *
     * @param $curlHandler
     * @return ParallecCurlModel
     */
    private function processRequest($curlHandler){
        ParallecUtilities::verifyCurlHandle($curlHandler);

        $resourceId = ParallecUtilities::getResourceId($curlHandler);
        $this->requests[$resourceId] = $curlHandler;
        curl_setopt($curlHandler, CURLOPT_HEADERFUNCTION, array($this, 'headerCallback'));
        $curlCode = curl_multi_add_handle($this->multicurlHandle, $curlHandler);

        if($curlCode === CURLM_OK || $curlCode === CURLM_CALL_MULTI_PERFORM){

            do{
                $this->executionStatus = curl_multi_exec($this->multicurlHandle, $this->activeCurlExecution);
            }while($this->executionStatus === CURLM_CALL_MULTI_PERFORM);

            return new ParallecCurlModel($resourceId);
        }else{
            return $curlCode;
        }

    }

    /**
     * Process the header returned from each curl request
     *
     * @param $curlHandler
     * @param $header
     * @return int
     */
    private function headerCallback($curlHandler, $header){
        $trimmedHeader = trim($header);
        $colonPosition = strpos($trimmedHeader, ':');
        $resourceId = ParallecUtilities::getResourceId($curlHandler);

        if($colonPosition > 0){
            $headerKey = substr($trimmedHeader,0,$colonPosition);
            $headerValue = preg_replace('/^\W+/', '', substr($trimmedHeader, $colonPosition));

            //set the response header for the curl request
            $this->responses[$resourceId]['headers'][$headerKey] = $headerValue;
        }

        return strlen($header);
    }

    public function getCurlResponses($resourceId){
        return '';
    }
}