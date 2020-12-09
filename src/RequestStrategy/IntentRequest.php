<?php

namespace AmpedRadio\AlexaStreamingPHP\RequestStrategy;

use AmpedRadio\AlexaStreamingPHP\AlexaStreamingConfig;
use AmpedRadio\AlexaStreamingPHP\DirectiveElements\AudioItem;
use AmpedRadio\AlexaStreamingPHP\DirectiveElements\Metadata;
use AmpedRadio\AlexaStreamingPHP\DirectiveElements\Stream;
use AmpedRadio\AlexaStreamingPHP\Directives\AudioPlayerPlayDirective;
use AmpedRadio\AlexaStreamingPHP\Directives\AudioPlayerStopDirective;
use AmpedRadio\AlexaStreamingPHP\Exception\WrongIntentRequestException;
use Exception;
use Nomisoft\Alexa\Request\AlexaRequest;
use Nomisoft\Alexa\Response\AlexaResponse;

/**
 * Class IntentRequest
 * IntentRequests are direct requests for actions by the Alexa user.
 * Examples: Play, Pause, Stop, etc.
 */
class IntentRequest implements RequestStrategyInterface
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
     * @throws WrongIntentRequestException
     * @throws Exception
     *
     * @return AlexaResponse
     */
    public function proceed(AlexaRequest $request)
    {
        $response = new AlexaResponse();

        switch ($request->getIntent()) {
            case 'PlayStream':
            case 'AMAZON.ResumeIntent':
                $response->setDirectives([
                    new AudioPlayerPlayDirective(
                        new AudioItem(
                            new Stream($this->config),
                            new Metadata($this->config)
                        )
                    ), ]);
                break;
            case 'AMAZON.PauseIntent':
            case 'AMAZON.StopIntent':
            case 'AMAZON.CancelIntent':
                $response->setDirectives([new AudioPlayerStopDirective()]);
                break;
            case 'AMAZON.LoopOffIntent':
            case 'AMAZON.LoopOnIntent':
            case 'AMAZON.NextIntent':
            case 'AMAZON.PreviousIntent':
            case 'AMAZON.RepeatIntent':
            case 'AMAZON.ShuffleOffIntent':
            case 'AMAZON.ShuffleOnIntent':
            case 'AMAZON.StartOverIntent':
                throw new WrongIntentRequestException('Sorry, our stream doesn\'t support this feature');
            default:
                throw new WrongIntentRequestException('Sorry, we don\'t understand your request');
        }

        return $response;
    }
}
