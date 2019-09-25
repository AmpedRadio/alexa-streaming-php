<?php

namespace AmpedRadio\AlexaStreamingPHP\DirectiveElements;

/**
 * AudioItem
 */
class AudioItem
{
    /** @var Stream $stream */
    public $stream;

    /** @var Metadata $metadata */
    public $metadata;

    public function __construct(Stream $stream, Metadata $metadata)
    {
        $this->stream = $stream;
        $this->metadata = $metadata;
    }
}
