<?php

namespace AmpedRadio\AlexaStreamingPHP\Directives;

use AmpedRadio\AlexaStreamingPHP\DirectiveElements\AudioItem;
use AmpedRadio\AlexaStreamingPHP\Interfaces\AudioPlayerDirectiveInterface;

/**
 * AudioPlayerPlayDirective.
 *
 * Sends Alexa a command to stream the audio file identified by the specified audioItem. Use the
 * playBehavior parameter to determine whether the stream begins playing immediately, or is added
 * to the queue.
 *
 * Note: You can only send one Play directive in a request.
 *
 * When sending a Play directive, you normally set the shouldEndSession flag in the response object
 * to true to end the session. If you set this flag to false, Alexa sends the stream to the device
 * for playback, then immediately pauses the stream to listen for the user's response.
 */
class AudioPlayerPlayDirective implements AudioPlayerDirectiveInterface
{
    /** @var string Alexa directive string value to play a stream */
    public $type = 'AudioPlayer.Play';

    /** @var AudioItem $audioItem */
    public $audioItem;

    /** @var string $playBehavior */
    public $playBehavior;

    /** @var array $playBehaviors */
    private $playBehaviors = [
        'REPLACE_ALL',      // Immediately Plays
        'REPLACE_ENQUEUED', // Plays after the current track ends
        'ENQUEUE',           // Add to the end of the queue
    ];

    /**
     * AudioPlayerPlayDirective constructor.
     *
     * @param AudioItem $audioItem
     * @param string    $playBehavior
     */
    public function __construct(AudioItem $audioItem, string $playBehavior = 'REPLACE_ALL')
    {
        $this->audioItem = $audioItem;
        $this->playBehavior = (in_array($playBehavior, $this->playBehaviors)) ? $playBehavior : 'REPLACE_ALL';
    }

    /**
     * Get Directive Type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Get Audio Item.
     *
     * @return AudioItem
     */
    public function getAudioItem(): AudioItem
    {
        return $this->audioItem;
    }

    /**
     * Get Play Behavior.
     *
     * @return string
     */
    public function getPlayBehavior(): string
    {
        return $this->playBehavior;
    }
}
