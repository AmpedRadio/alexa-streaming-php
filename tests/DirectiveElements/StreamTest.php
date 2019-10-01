<?php declare(strict_types=1);

namespace AmpedRadio\AlexaStreamingPHP\Test\DirectiveElements;

use AmpedRadio\AlexaStreamingPHP\AlexaStreamingConfig;
use AmpedRadio\AlexaStreamingPHP\DirectiveElements\Stream;
use PHPUnit\Framework\TestCase;

class StreamTest extends TestCase
{
    public function testStream()
    {
        $alexaStreamingConfig = new AlexaStreamingConfig();
        $alexaStreamingConfig->stream_url = 'unit_stream_url';
        $alexaStreamingConfig->stream_token = 'unit_stream_token';

        $stream = new Stream($alexaStreamingConfig);
        $this->assertSame($alexaStreamingConfig->getStreamUrl(), $stream->url);
        $this->assertSame($alexaStreamingConfig->getStreamToken(), $stream->token);
        $this->assertSame(0, $stream->offsetInMilliseconds);
    }
}
