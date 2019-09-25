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

class AlexaStreaming
{
    public $config;

    public $request;

    public $response;

    public $validator;

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
     * Process Alexa Request and provide a response
     */
    public function process()
    {
        if ($this->isValidRequest()) {
            if ($this->request->getType() == 'IntentRequest') {
                // IntentRequests are direct requests for actions by the Alexa user.
                // Examples: Play, Pause, Stop, etc.
                $this->_processIntent($this->request);
            } elseif (strpos($this->request->getType(), 'AudioPlayer.') !== false) {
                // Requests of the AudioPlayer.* type can be considered event notifications
                // and make us aware of changes to the playback state.
                // Examples: PlaybackStarted, PlaybackStopped, PlaybackFailed
                $this->_processAudioPlayerEvent($this->request);
            } else {
                $this->_setOutputSpeech("Sorry, we don't understand your request");
            }
        } else {
            $this->_setOutputSpeech("Sorry, something went wrong with your request");
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
        return $this->_validateRequest();
    }

    /**
     * Validates the Alexa request
     *
     * @return bool
     */
    private function _validateRequest()
    {
        if (!$this->validator->validate($this->config->getAppId())) {
            $this->is_valid_request = false;
        }
        $this->is_valid_request = true;

        return $this->is_valid_request;
    }

    /**
     * Process Intent
     *
     * @throws \Exception
     */
    private function _processIntent(AlexaRequest $request)
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
                $this->_setOutputSpeech("Sorry, our stream doesn't support this feature");
                break;
            default:
                $this->_setOutputSpeech("Sorry, we don't understand your request");
                break;
        }
    }

    /**
     * Set Output Speech
     *
     * @param string $message
     */
    private function _setOutputSpeech(string $message)
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
    private function _processAudioPlayerEvent(AlexaRequest $request)
    {
        /** @todo Log Player Events */
    }
}