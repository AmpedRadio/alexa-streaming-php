<?php

namespace AmpedRadio\AlexaStreamingPHP\Test\Unit;

use AmpedRadio\AlexaStreamingPHP\AlexaStreaming;
use AmpedRadio\AlexaStreamingPHP\AlexaStreamingConfig;
use PHPUnit\Framework\TestCase;

class AlexaStreamingTest extends TestCase
{
    protected $alexaStreamingInstance;

    protected $configMock;

    protected function setUp(): void
    {
        $this->configMock = $this->getMockBuilder(AlexaStreamingConfig::class)
            ->onlyMethods(['getAppId', 'getLaunchMessage'])->disableOriginalConstructor()->getMock();
    }

    /**
     * Check if Alexa streaming instance throw an exception on an invalid JSON request.
     */
    public function testShouldThrowExceptionOnInvalidJsonRequest()
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('Invalid JSON request');

        new AlexaStreaming($this->configMock, true);
    }
}
