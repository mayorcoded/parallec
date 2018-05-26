<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 5/25/18
 * Time: 10:13 PM
 */

namespace mayorcoded\parallec;


class Parallec
{

    /**
     * @var $curlOptions
     *
     * This field stores curl options on instantiation of the class
     */
    private $curlOptions;

    /**
     * @var null $isInstance ensures that only once instance of the class exists
     */
    private static $instance = NULL;

    private $multicurl;


    /**
     * Parallec constructor. make class singleton
     */
    private function __construct()
    {
        $this->multicurl = curl_multi_init();

        $this->curlOptions = array(
            'http_code' => CURLINFO_HTTP_CODE,
            'total_time' => CURLINFO_TOTAL_TIME,
            'content_length' => CURLINFO_CONTENT_LENGTH_DOWNLOAD,
            'content_type' => CURLINFO_CONTENT_TYPE,
            'url' => CURLINFO_EFFECTIVE_URL
        );

    }

    public static function getInstance(){
        if(self::$instance == NULL){
            self::$instance = new Parallec();
        }

        return self::$instance;
    }
}