<?php

declare(strict_types=1);

namespace AmpedRadio\AlexaStreamingPHP\Test\DirectiveElements;

use AmpedRadio\AlexaStreamingPHP\AlexaStreamingConfig;
use AmpedRadio\AlexaStreamingPHP\DirectiveElements\Metadata;
use PHPUnit\Framework\TestCase;

class MetadataTest extends TestCase
{
    public function testMetadata()
    {
        $alexaStreamingConfig = new AlexaStreamingConfig();
        $alexaStreamingConfig->title = 'unit_title';
        $alexaStreamingConfig->subtitle = 'unit_subtitle';
        $alexaStreamingConfig->art = 'unit_art';
        $alexaStreamingConfig->background_image = 'unit_background_image';

        $metadata = new Metadata($alexaStreamingConfig);
        $this->assertSame($alexaStreamingConfig->subtitle, $metadata->subtitle);
        $this->assertSame($alexaStreamingConfig->title, $metadata->title);
    }
}
