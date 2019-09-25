<?php

namespace AmpedRadio\AlexaStreamingPHP\Directives;

use AmpedRadio\AlexaStreamingPHP\Interfaces\AudioPlayerDirectiveInterface;

/**
 * AudioPlayerClearQueueDirective
 *
 * Clears the audio playback queue. You can set this directive to clear the queue without stopping
 * the currently playing stream, or clear the queue and stop any currently playing stream.
 *
 * @package AmpedRadio\AlexaStreamingPHP
 */
class AudioPlayerClearQueueDirective implements AudioPlayerDirectiveInterface
{
    /** @var string Alexa directive string value to clear the device queue */
    public $type = 'AudioPlayer.ClearQueue';

    /** @var string $clearBehavior */
    public $clearBehavior;

    /** @var array $_clearBehaviors */
    private $_clearBehaviors = [
        'CLEAR_ENQUEUED',   // clears the queue and continues to play the currently playing stream
        'CLEAR_ALL'         // clears the entire playback queue and stops the currently playing
                            //     stream (if applicable).
    ];

    /**
     * AudioPlayerClearQueueDirective constructor.
     *
     * @param string $clearBehavior
     */
    public function __construct(string $clearBehavior = 'CLEAR_ALL')
    {
        $this->clearBehavior = (in_array($clearBehavior, $this->_clearBehaviors)) ? $clearBehavior : 'CLEAR_ALL';
    }

    /**
     * Get Directive Type
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
