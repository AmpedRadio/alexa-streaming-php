<?php

namespace AmpedRadio\AlexaStreamingPHP\RequestStrategy;

use Nomisoft\Alexa\Request\AlexaRequest;

/**
 * Class AudioPlayerRequest
 * Requests of the AudioPlayer.* type can be considered event notifications
 * and make us aware of changes to the playback state.
 * Examples: PlaybackStarted, PlaybackStopped, PlaybackFailed.
 */
class AudioPlayerRequest implements RequestStrategyInterface
{
    /**
     * Proceed a request and return response.
     *
     * @param \Nomisoft\Alexa\Request\AlexaRequest $request
     *
     * @return mixed
     */
    public function proceed(AlexaRequest $request)
    {
        /** @todo Log Player Events */
    }
}
