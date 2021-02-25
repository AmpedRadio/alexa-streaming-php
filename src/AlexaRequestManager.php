<?php

namespace AmpedRadio\AlexaStreamingPHP;

use AmpedRadio\AlexaStreamingPHP\Exception\IndeterminateRequestException;
use AmpedRadio\AlexaStreamingPHP\Exception\RequestValidationException;
use AmpedRadio\AlexaStreamingPHP\RequestStrategy\AudioPlayerRequest;
use AmpedRadio\AlexaStreamingPHP\RequestStrategy\IntentRequest;
use AmpedRadio\AlexaStreamingPHP\RequestStrategy\LaunchRequest;
use Exception;
use Nomisoft\Alexa\Request\AlexaRequest;
use Nomisoft\Alexa\Request\RequestValidator;

/**
 * Class AlexaRequestManager
 * Validate and proceed Alexa request.
 */
class AlexaRequestManager
{
    const LAUNCH_REQUEST = 'LaunchRequest';
    const INTENT_REQUEST = 'IntentRequest';
    const AUDIO_PLAYER_REQUEST = 'AudioPlayer.';

    /**
     * @var AlexaStreamingConfig
     */
    private $config;
    /**
     * @var AlexaRequest
     */
    private $request;
    /**
     * @var RequestValidator
     */
    private $validator;

    /**
     * AlexaRequestManager constructor.
     *
     * @param AlexaStreamingConfig $config
     * @param AlexaRequest         $request
     * @param null                 $validator
     */
    public function __construct(
        AlexaStreamingConfig $config,
        AlexaRequest $request,
        $validator = null //@TODO : use DI
    ) {
        $this->config = $config;
        $this->request = $request;
        $this->validator = $validator ?? new RequestValidator($this->request);
    }

    /**
     * Validate and proceed request.
     *
     * @throws RequestValidationException
     * @throws Exception
     */
    public function proceedRequest()
    {
        if ($this->request->getType() === self::LAUNCH_REQUEST) {
            $requestStrategy = new LaunchRequest($this->config);
        } elseif ($this->request->getType() === self::INTENT_REQUEST) {
            $requestStrategy = new IntentRequest($this->config);
        } elseif (strpos($this->request->getType(), self::AUDIO_PLAYER_REQUEST) !== false) {
            $requestStrategy = new AudioPlayerRequest();
        } else {
            throw new IndeterminateRequestException('Sorry, we don\'t understand your request');
        }

        return $requestStrategy->proceed($this->request);
    }

    /**
     * Get Alexa Request.
     *
     * @return AlexaRequest
     */
    public function getRequest(): AlexaRequest
    {
        return $this->request;
    }
}
