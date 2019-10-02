<?php declare(strict_types=1);

namespace AmpedRadio\AlexaStreamingPHP\Test\DirectiveElements;

use AmpedRadio\AlexaStreamingPHP\AlexaStreamingConfig;
use AmpedRadio\AlexaStreamingPHP\DirectiveElements\AudioItem;
use AmpedRadio\AlexaStreamingPHP\DirectiveElements\Metadata;
use AmpedRadio\AlexaStreamingPHP\DirectiveElements\Stream;
use PHPUnit\Framework\TestCase;

class AudioItemTest extends TestCase
{
    public function testAudioItem()
    {
        $stream = new Stream(new AlexaStreamingConfig());
        $metadata = new Metadata(new AlexaStreamingConfig());

        $audioItem = new AudioItem($stream, $metadata);

        $this->assertSame($stream, $audioItem->stream);
        $this->assertSame($metadata, $audioItem->metadata);
    }
}
