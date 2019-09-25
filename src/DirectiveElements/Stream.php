<?php

namespace AmpedRadio\AlexaStreamingPHP\DirectiveElements;

use AmpedRadio\AlexaStreamingPHP\AlexaStreamingConfig;

/**
 * Stream
 *
 * The Stream object is found as a child item inside of an AudioItem object. It is used in a
 * limited capacity in this project as we're only supporting a basic streaming setup. More
 * complex properties such as previous token and offset are either not provided or set to
 * default values.
 *
 * Audio Stream Requirements
 * https://developer.amazon.com/docs/custom-skills/audioplayer-interface-reference.html
 *   #audio-stream-requirements
 *
 * Basic Stream Requirements:
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
