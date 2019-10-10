<?php

namespace AmpedRadio\AlexaStreamingPHP\Test\Directives;

use AmpedRadio\AlexaStreamingPHP\Directives\AudioPlayerClearQueueDirective;
use PHPUnit\Framework\TestCase;

class AudioPlayerClearQueueDirectiveTest extends TestCase
{
    public function testClearQueueDirective()
    {
        $behavior = 'CLEAR_ENQUEUED';
        $clearDirective = new AudioPlayerClearQueueDirective($behavior);

        $this->assertSame('AudioPlayer.ClearQueue', $clearDirective->getType());
        $this->assertSame($behavior, $clearDirective->getClearBehavior());
    }
}