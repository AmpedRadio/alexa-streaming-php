<?php

namespace AmpedRadio\AlexaStreamingPHP;

use AmpedRadio\AlexaStreamingPHP\DirectiveElements\AudioItem;
use AmpedRadio\AlexaStreamingPHP\DirectiveElements\Metadata;
use AmpedRadio\AlexaStreamingPHP\DirectiveElements\Stream;
use AmpedRadio\AlexaStreamingPHP\Directives\AudioPlayerPlayDirective;
use AmpedRadio\AlexaStreamingPHP\Directives\AudioPlayerStopDirective;
use \Nomisoft\Alexa\Request\AlexaRequest;
use \Nomisoft\Alexa\Response\AlexaResponse;
use \Nomisoft\Alexa\Request\RequestValidator;
use Nomisoft\Alexa\Response\OutputSpeech;

/**
 * Class AlexaStreaming
 */
class AlexaStreaming
{
    /** @var AlexaStreamingConfig $config */
    public $config;

    /** @var AlexaRequest $request */
    public $request;

    /** @var AlexaResponse $response */
    public $response;

    /** @var RequestValidator $validator */
    public $validator;

    /** @var bool|null $is_valid_request */
    public $is_valid_request;

    /**
     * AlexaStreaming constructor.
     *
     * @param AlexaStreamingConfig $config
     * @param bool $from_request
     * @param string|null $json
     * @throws \Exception
     */
    public function __construct(AlexaStreamingConfig $config, bool $from_request = true, string $json = null)
    {
        $this->config = $config;
        $this->request = ($from_request) ? AlexaRequest::fromRequest() : new AlexaRequest($json);
        $this->validator = new RequestValidator($this->request);
        $this->response = new AlexaResponse();
    }

    /**
     * Execute processing for Alexa Request and provide a response
     *
     * @return AlexaResponse
     * @throws \Exception
     */
    public function execute()
    {
        if ($this->isValidRequest()) {
            if ($this->request->getType() == 'LaunchRequest') {
                // A LaunchRequest is an object that represents that a user made a
                // request to an Alexa skill, but did not provide a specific intent.
                $this->processLaunch();
            } elseif ($this->request->getType() == 'IntentRequest') {
                // IntentRequests are direct requests for actions by the Alexa user.
                // Examples: Play, Pause, Stop, etc.
                $this->processIntent($this->request);
            } elseif (strpos($this->request->getType(), 'AudioPlayer.') !== false) {
                // Requests of the AudioPlayer.* type can be considered event notifications
                // and make us aware of changes to the playback state.
                // Examples: PlaybackStarted, PlaybackStopped, PlaybackFailed
                $this->processAudioPlayerEvent($this->request);
            } else {
                $this->setOutputSpeech("Sorry, we don't understand your request");
            }
        } else {
            throw new \Exception('Invalid Request.');
        }

        return $this->response;
    }

    /**
     * Is Valid Request
     *
     * @return bool
     */
    public function isValidRequest()
    {
        return $this->validateRequest();
    }

    /**
     * Validates the Alexa request
     *
     * @return bool
     */
    private function validateRequest()
    {
        if (!$this->validator->validate($this->config->getAppId())) {
            $this->is_valid_request = false;
        }
        $this->is_valid_request = true;

        return $this->is_valid_request;
    }

    /**
     * Process LaunchRequest
     */
    private function processLaunch()
    {
        if ($this->config->getLaunchMessage()) {
            $speech = new OutputSpeech();
            $speech->setText($this->config->getLaunchMessage());
            $this->response->setOutputSpeech($speech);
        }

        $this->response->setDirectives([new AudioPlayerPlayDirective(
            new AudioItem(
                new Stream($this->config),
                new Metadata($this->config)
            )
        )]);
    }

    /**
     * Process Intent
     *
     * @throws \Exception
     */
    private function processIntent(AlexaRequest $request)
    {
        $intent = $request->getIntent();
        switch ($intent->name) {
            case 'PlayStream':
            case 'AMAZON.ResumeIntent':
                $this->response->setDirectives([new AudioPlayerPlayDirective(
                    new AudioItem(
                        new Stream($this->config),
                        new Metadata($this->config)
                    )
                )]);
                break;
            case 'AMAZON.PauseIntent':
            case 'AMAZON.StopIntent':
            case 'AMAZON.CancelIntent':
                $this->response->setDirectives([new AudioPlayerStopDirective]);
                break;
            case 'AMAZON.LoopOffIntent':
            case 'AMAZON.LoopOnIntent':
            case 'AMAZON.NextIntent':
            case 'AMAZON.PreviousIntent':
            case 'AMAZON.RepeatIntent':
            case 'AMAZON.ShuffleOffIntent':
            case 'AMAZON.ShuffleOnIntent':
            case 'AMAZON.StartOverIntent':
                $this->setOutputSpeech("Sorry, our stream doesn't support this feature");
                break;
            default:
                $this->setOutputSpeech("Sorry, we don't understand your request");
                break;
        }
    }

    /**
     * Set Output Speech
     *
     * @param string $message
     */
    private function setOutputSpeech(string $message)
    {
        $speech = new OutputSpeech();
        $speech->setText("Sorry, we don't understand your request");
        $this->response->setOutputSpeech($message);
    }

    /**
     * Process Audio Player Events
     *
     * @param AlexaRequest $request
     */
    private function processAudioPlayerEvent(AlexaRequest $request)
    {
        /** @todo Log Player Events */
    }
}
