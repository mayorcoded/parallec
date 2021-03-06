<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 6/1/18
 * Time: 3:36 AM
 */
namespace mayorcoded\parallec\Model;
use mayorcoded\parallec\Parallec;

/**
 * @property null http_code
 * @property null response
 * @property null headers
 * @property null total_time
 *
 */
class ParallecCurlModel
{

    /**
     * This stores the resource id for a curl request
     *
     * @var integer
     */
    private $resourceId;


    /**
     * An instance of the Parallec class
     *
     * @var Parallec
     */
    private $parallec;


    /**
     * ParallecCurlModel constructor.
     * Initialize the resource id
     * Initialize parallec with single instance of Parallec class
     *
     * @param $resourceId
     */
    public function __construct($resourceId)
    {
        $this->resourceId = $resourceId;
        $this->parallec = Parallec::getInstance();
    }


    /**
     * Get class property using magic method
     *
     * @param $key
     * @return null
     */
    public function __get($key)
    {
        $curlResponses = $this->parallec->getCurlResponses($this->resourceId);
        return isset($curlResponses[$key])? $curlResponses[$key]: null;
    }

}