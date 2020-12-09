<?php

namespace AmpedRadio\AlexaStreamingPHP\DirectiveElements;

/**
 * AudioItem.
 */
class AudioItem
{
    /** @var Stream */
    public $stream;

    /** @var Metadata */
    public $metadata;

    /**
     * AudioItem constructor.
     *
     * @param Stream   $stream
     * @param Metadata $metadata
     */
    public function __construct(Stream $stream, Metadata $metadata)
    {
        $this->stream = $stream;
        $this->metadata = $metadata;
    }
}
