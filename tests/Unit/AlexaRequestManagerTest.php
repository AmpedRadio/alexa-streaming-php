<?php

namespace AmpedRadio\AlexaStreamingPHP\Test\Unit;

use AmpedRadio\AlexaStreamingPHP\AlexaRequestManager;
use AmpedRadio\AlexaStreamingPHP\AlexaStreamingConfig;
use AmpedRadio\AlexaStreamingPHP\Exception\RequestValidationException;
use Nomisoft\Alexa\Request\AlexaRequest;
use Nomisoft\Alexa\Request\RequestValidator;
use PHPUnit\Framework\TestCase;

class AlexaRequestManagerTest extends TestCase
{
    const APP_ID = 'APP_ID';

    protected $alexaRequestMock;

    protected $validatorMock;

    private $configMock;

    private $requestValidatorMock;

    protected function setUp(): void
    {
        $this->configMock = $this->getMockBuilder(AlexaStreamingConfig::class)
            ->onlyMethods(['getAppId', 'getLaunchMessage'])->disableOriginalConstructor()->getMock();

        $this->requestValidatorMock = $this->getMockBuilder(RequestValidator::class)
            ->onlyMethods(['validate'])->disableOriginalConstructor()->getMock();
    }

    /**
     * Check if Alexa Request Manager instance throw an exception on an invalid JSON request
     */
    public function testShouldThrowExceptionOnInvalidRequest()
    {
        $this->expectException(RequestValidationException::class);
        $this->expectExceptionMessage('Invalid Request.');

        $jsonRequest = json_encode([
            'request' => [
                'timestamp' => '+1day'
            ]
        ]);

        $this->configMock->method('getAppId')
            ->willReturn(self::APP_ID);

        $this->requestValidatorMock->method('validate')
            ->with(self::APP_ID)
            ->willReturn(false);

        $instance = new AlexaRequestManager($this->configMock, new AlexaRequest($jsonRequest));
        $instance->proceedRequest();
    }
}