<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 5/26/18
 * Time: 11:26 AM
 */
use mayorcoded\parallec\Parallec;

class ParallecTest extends \PHPUnit\Framework\TestCase
{
    public function testParallecInstanceAsObject(){
        $parallec = \mayorcoded\parallec\Parallec::getInstance();
        $this->assertTrue(is_object($parallec));
    }

    public function testInstanceOfParallec(){
        $parallec = \mayorcoded\parallec\Parallec::getInstance();
        $this->assertInstanceOf(\mayorcoded\parallec\Parallec::class,$parallec);
    }

    public function testGetCode(){
        $url = 'http://www.google.com/search?q=hypertext';
        $options = array(CURLOPT_RETURNTRANSFER => 1);

        $parallec = Parallec::getInstance();
        $request = $parallec->ping($url, $options);

        $this->assertInternalType('integer', $request->http_code);
    }

    public function testRequestTime(){
        $url = 'http://www.google.com/search?q=hypertext';
        $options = array(CURLOPT_RETURNTRANSFER => 1);

        $parallec = Parallec::getInstance();
        $request = $parallec->ping($url, $options);

        $this->assertInternalType('float', $request->total_time);
    }

    public function testJsonResponse(){
        $url = 'http://jsonplaceholder.typicode.com/users';

        $parallec = Parallec::getInstance();
        $request = $parallec->ping($url);
        $response = json_decode($request->response);

        $this->assertInternalType('array', $response);
    }

    public function testResponseHeaders(){
        $url = 'http://jsonplaceholder.typicode.com/users';

        $parallec = Parallec::getInstance();
        $request = $parallec->ping($url);

        $this->assertNotEmpty($request->headers);
    }
}