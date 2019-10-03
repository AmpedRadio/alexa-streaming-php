<?php

namespace AmpedRadio\AlexaStreamingPHP\Test\Unit;

use AmpedRadio\AlexaStreamingPHP\AlexaRequestManager;
use AmpedRadio\AlexaStreamingPHP\AlexaStreamingConfig;
use AmpedRadio\AlexaStreamingPHP\DirectiveElements\AudioItem;
use AmpedRadio\AlexaStreamingPHP\DirectiveElements\Metadata;
use AmpedRadio\AlexaStreamingPHP\DirectiveElements\Stream;
use AmpedRadio\AlexaStreamingPHP\Directives\AudioPlayerPlayDirective;
use AmpedRadio\AlexaStreamingPHP\Exception\RequestValidationException;
use Nomisoft\Alexa\Request\AlexaRequest;
use Nomisoft\Alexa\Request\RequestValidator;
use Nomisoft\Alexa\Response\AlexaResponse;
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

        $instance = new AlexaRequestManager(
            $this->configMock,
            new AlexaRequest($jsonRequest),
            $this->requestValidatorMock
        );
        $instance->proceedRequest();
    }

    /**
     * Check if Alexa Request Manager instance for launch request return expected response
     */
    public function testShouldLaunchRequestReturnExpectedResponse()
    {
        $expectedResponse = new AlexaResponse();
        $expectedResponse->setDirectives([
            new AudioPlayerPlayDirective(
                new AudioItem(
                    new Stream($this->configMock),
                    new Metadata($this->configMock)
                )
            )]);

        $jsonRequest = json_encode([
            'request' => [
                'timestamp' => 'now',
                'type' => AlexaRequestManager::LAUNCH_REQUEST
            ]
        ]);

        $this->configMock->method('getAppId')
            ->willReturn(self::APP_ID);

        $this->requestValidatorMock->method('validate')
            ->with(self::APP_ID)
            ->willReturn(true);

        $instance = new AlexaRequestManager(
            $this->configMock,
            new AlexaRequest($jsonRequest),
            $this->requestValidatorMock
        );

        self::assertEquals($expectedResponse, $instance->proceedRequest());
    }

    /**
     * Check if Alexa Request Manager instance for launch request return expected response
     */
    public function testShouldIntentRequestReturnExpectedResponse()
    {
        $expectedResponse = new AlexaResponse();
        $expectedResponse->setDirectives([
            new AudioPlayerPlayDirective(
                new AudioItem(
                    new Stream($this->configMock),
                    new Metadata($this->configMock)
                )
            )]);

        $jsonRequest = json_encode([
            'request' => [
                'timestamp' => 'now',
                'type' => AlexaRequestManager::INTENT_REQUEST,
                'intent' => 'PlayStream'
            ]
        ]);

        $this->configMock->method('getAppId')
            ->willReturn(self::APP_ID);

        $this->requestValidatorMock->method('validate')
            ->with(self::APP_ID)
            ->willReturn(true);

        $instance = new AlexaRequestManager(
            $this->configMock,
            new AlexaRequest($jsonRequest),
            $this->requestValidatorMock
        );

        self::assertEquals($expectedResponse, $instance->proceedRequest());
    }
}