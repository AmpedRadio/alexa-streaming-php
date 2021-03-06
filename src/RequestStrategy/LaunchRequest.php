<?php

namespace AmpedRadio\AlexaStreamingPHP\RequestStrategy;

use AmpedRadio\AlexaStreamingPHP\AlexaStreamingConfig;
use AmpedRadio\AlexaStreamingPHP\DirectiveElements\AudioItem;
use AmpedRadio\AlexaStreamingPHP\DirectiveElements\Metadata;
use AmpedRadio\AlexaStreamingPHP\DirectiveElements\Stream;
use AmpedRadio\AlexaStreamingPHP\Directives\AudioPlayerPlayDirective;
use Nomisoft\Alexa\Request\AlexaRequest;
use Nomisoft\Alexa\Response\AlexaResponse;
use Nomisoft\Alexa\Response\OutputSpeech;

/**
 * Class LaunchRequest
 * A LaunchRequest is an object that represents that a user made a request
 * to an Alexa skill, but did not provide a specific intent.
 */
class LaunchRequest implements RequestStrategyInterface
{
    /**
     * @var AlexaStreamingConfig
     */
    private $config;

    /**
     * IntentRequest constructor.
     *
     * @param AlexaStreamingConfig $config
     */
    public function __construct(AlexaStreamingConfig $config)
    {
        $this->config = $config;
    }

    /**
     * Proceed a request and return response.
     *
     * @param AlexaRequest $request
     *
     * @return AlexaResponse
     */
    public function proceed(AlexaRequest $request)
    {
        $response = new AlexaResponse();
        if ($this->config->getLaunchMessage()) {
            $speech = new OutputSpeech();
            $speech->setText($this->config->getLaunchMessage());
            $response->setOutputSpeech($speech);
        }

        $response->setDirectives([
            new AudioPlayerPlayDirective(
                new AudioItem(
                    new Stream($this->config),
                    new Metadata($this->config)
                )
            ), ]);

        return $response;
    }
}
