<?php

namespace AmpedRadio\AlexaStreamingPHP\Test\Directives;

use AmpedRadio\AlexaStreamingPHP\Directives\AudioPlayerStopDirective;
use PHPUnit\Framework\TestCase;

class AudioPlayerStopDirectiveTest extends TestCase
{
    public function testClearQueueDirective()
    {
        $stopDirective = new AudioPlayerStopDirective();

        $this->assertSame('AudioPlayer.Stop', $stopDirective->getType());
    }
}
