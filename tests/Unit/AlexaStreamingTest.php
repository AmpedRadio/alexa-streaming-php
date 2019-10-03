<?php

namespace AmpedRadio\AlexaStreamingPHP\Test\Unit;

use AmpedRadio\AlexaStreamingPHP\AlexaStreaming;
use AmpedRadio\AlexaStreamingPHP\AlexaStreamingConfig;
use Nomisoft\Alexa\Request\RequestValidator;
use PHPUnit\Framework\TestCase;

class AlexaStreamingTest extends TestCase
{
    const APP_ID = 'APP_ID';

    protected $alexaStreamingInstance;

    protected $alexaRequestMock;

    protected $validatorMock;

    protected $configMock;

    protected function setUp(): void
    {
        $this->configMock = $this->getMockBuilder(AlexaStreamingConfig::class)
            ->onlyMethods(['getAppId', 'getLaunchMessage'])->disableOriginalConstructor()->getMock();
    }

    /**
     * Check if Alexa streaming instance throw an exception on an invalid JSON request
     */
    public function testShouldThrowExceptionOnInvalidJsonRequest()
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('Invalid JSON request');

        new AlexaStreaming($this->configMock, true);
    }

    /**
     * Check if Alexa streaming instance throw an exception on an invalid JSON request
     */
    public function testShouldThrowExceptionOnInvalidRequest()
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('Invalid Request.');

        $jsonRequest = (string) json_encode([
            'request' => [
                'timestamp' => '+1day'
            ]
        ]);

        $this->configMock->method('getAppId')
            ->willReturn(self::APP_ID);

        $instance = new AlexaStreaming($this->configMock, false, $jsonRequest);
        $instance->execute();
    }
}
