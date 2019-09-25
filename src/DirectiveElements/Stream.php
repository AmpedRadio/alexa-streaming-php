<?php

namespace AmpedRadio\AlexaStreamingPHP\DirectiveElements;

use AmpedRadio\AlexaStreamingPHP\AlexaStreamingConfig;

/**
 * Stream
 *
 * https://developer.amazon.com/docs/custom-skills/audioplayer-interface-reference.html#audio-stream-requirements
 *
 * Requirements:
 *  - Audio file must be hosted at an Internet-accessible HTTPS endpoint on port 443.
 *  - The web server must present a valid and trusted SSL certificate.
 *  - The supported formats for the audio file include AAC/MP4, MP3, PLS, M3U/M3U8, and HLS.
 *    Bitrates: 16kbps to 384 kbps.
 */
class Stream
{
    /** @var string $url */
    public $url;

    /** @var string $token */
    public $token;

    /** @var int $offsetInMilliseconds */
    public $offsetInMilliseconds;

    /**
     * Stream constructor.
     *
     * @param AlexaStreamingConfig $config
     */
    public function __construct(AlexaStreamingConfig $config)
    {
        $this->url = $config->getStreamUrl();
        $this->token = $config->getStreamToken();
        $this->offsetInMilliseconds = 0;
    }
}
