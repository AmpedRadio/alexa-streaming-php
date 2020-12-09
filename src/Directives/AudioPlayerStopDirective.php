<?php

namespace AmpedRadio\AlexaStreamingPHP\Directives;

use AmpedRadio\AlexaStreamingPHP\Interfaces\AudioPlayerDirectiveInterface;

/**
 * AudioPlayerStopDirective.
 *
 * Stops the current audio playback.
 */
class AudioPlayerStopDirective implements AudioPlayerDirectiveInterface
{
    /** @var string Alexa directive string value to stop a stream */
    public $type = 'AudioPlayer.Stop';

    /**
     * Get Directive Type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
