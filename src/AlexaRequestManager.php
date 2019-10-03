<?php

namespace AmpedRadio\AlexaStreamingPHP;

use AmpedRadio\AlexaStreamingPHP\Exception\IndeterminateRequestException;
use AmpedRadio\AlexaStreamingPHP\Exception\RequestValidationException;
use AmpedRadio\AlexaStreamingPHP\RequestStrategy\AudioPlayerRequest;
use AmpedRadio\AlexaStreamingPHP\RequestStrategy\IntentRequest;
use AmpedRadio\AlexaStreamingPHP\RequestStrategy\LaunchRequest;
use \Nomisoft\Alexa\Request\AlexaRequest;
use \Nomisoft\Alexa\Request\RequestValidator;

/**
 * Class AlexaRequestManager
 * Validate and proceed Alexa request
 *
 * @package AmpedRadio\AlexaStreamingPHP
 */
class AlexaRequestManager
{
    const LAUNCH_REQUEST = 'LaunchRequest';
    const INTENT_REQUEST = 'IntentRequest';
    const AUDIO_PLAYER_REQUEST = 'AudioPlayer.';

    /**
     * @var \AmpedRadio\AlexaStreamingPHP\AlexaStreamingConfig
     */
    private $config;
    /**
     * @var \Nomisoft\Alexa\Request\AlexaRequest
     */
    private $request;

    /**
     * AlexaRequestManager constructor.
     *
     * @param \AmpedRadio\AlexaStreamingPHP\AlexaStreamingConfig $config
     * @param \Nomisoft\Alexa\Request\AlexaRequest $request
     */
    public function __construct(
        AlexaStreamingConfig $config,
        AlexaRequest $request
    ) {
        $this->config = $config;
        $this->request = $request;
    }

    /**
     * Validate and proceed request
     *
     *
     * @throws \AmpedRadio\AlexaStreamingPHP\Exception\RequestValidationException
     * @throws \Exception
     */
    public function proceedRequest()
    {
        $validator = new RequestValidator($this->request);
        if (!$validator->validate($this->config->getAppId())) {
            throw new RequestValidationException('Invalid Request.');
        }

        if ($this->request->getType() === self::LAUNCH_REQUEST) {
            $requestDeterminator = new LaunchRequest($this->config);
        } elseif ($this->request->getType() === self::INTENT_REQUEST) {
            $requestDeterminator = new IntentRequest($this->config);
        } elseif (strpos($this->request->getType(), self::AUDIO_PLAYER_REQUEST) !== false) {
            $requestDeterminator = new AudioPlayerRequest();
        } else {
            throw new IndeterminateRequestException('Sorry, we don\'t understand your request');
        }

        return $requestDeterminator->proceed($this->request);
    }
}
