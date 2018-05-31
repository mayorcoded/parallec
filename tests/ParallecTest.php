<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 5/26/18
 * Time: 11:26 AM
 */

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

    public function testProcessRequestInvalidCurlHandler(){
        $this->expectException(\mayorcoded\parallec\Exceptions\ParallecInvalidParameterException::class);
        $parallec = \mayorcoded\parallec\Parallec::getInstance();
        //$parallec->processRequest( '');
    }
}