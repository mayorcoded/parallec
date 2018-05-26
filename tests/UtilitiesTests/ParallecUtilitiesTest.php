<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 5/26/18
 * Time: 5:35 PM
 */
use mayorcoded\parallec\Utilities\ParallecUtilities;
use mayorcoded\parallec\Exceptions\ParallecInvalidParameterException;

class ParallecUtilitiesTest extends \PHPUnit\Framework\TestCase
{
    public function testCurlHandlerAsResource(){
        $this->assertInternalType('resource', ParallecUtilities::setUpCurlHandler('https://www.google.com/'));
    }

    public function testCurHandlerWithBadUrl(){
        $this->expectException(ParallecInvalidParameterException::class);
        ParallecUtilities::setUpCurlHandler('');
    }

    public function testUrlValidity(){

        $urls = [
            'https://www.google.com/',
            'http://blog.teamtreehouse.com/5-new-features-php-7'
        ];

        for($i = 0; $i < sizeof($urls); $i++){
            $this->assertTrue(ParallecUtilities::urlIsValid($urls[$i]));
        }
    }

    public function testUrlInvalidity(){

        $invalidUrls = [
            '',
            'adfadfd',
            'https//google'
        ];

        for ($i = 0; $i < sizeof($invalidUrls); $i++){
            $this->assertFalse(ParallecUtilities::urlIsValid($invalidUrls[$i]));
        }
    }
}