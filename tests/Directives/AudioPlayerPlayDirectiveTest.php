<?php

namespace AmpedRadio\AlexaStreamingPHP\Test\Directives;

use AmpedRadio\AlexaStreamingPHP\AlexaStreamingConfig;
use AmpedRadio\AlexaStreamingPHP\DirectiveElements\AudioItem;
use AmpedRadio\AlexaStreamingPHP\DirectiveElements\Metadata;
use AmpedRadio\AlexaStreamingPHP\DirectiveElements\Stream;
use AmpedRadio\AlexaStreamingPHP\Directives\AudioPlayerPlayDirective;
use PHPUnit\Framework\TestCase;

class AudioPlayerPlayDirectiveTest extends TestCase
{
    public function testPlayDirective()
    {
        $behavior = 'ENQUEUE';
        $config = new AlexaStreamingConfig();
        $stream = new Stream($config);
        $metadata = new Metadata($config);
        $audioItem = new AudioItem($stream, $metadata);
        $playDirective = new AudioPlayerPlayDirective($audioItem, $behavior);

        $this->assertSame('AudioPlayer.Play', $playDirective->getType());
        $this->assertSame($stream, $playDirective->getAudioItem()->stream);
        $this->assertSame($metadata, $playDirective->getAudioItem()->metadata);
        $this->assertSame($behavior, $playDirective->getPlayBehavior());
    }
}
