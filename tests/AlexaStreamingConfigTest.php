<?php

declare(strict_types=1);

namespace AmpedRadio\AlexaStreamingPHP\Test;

use AmpedRadio\AlexaStreamingPHP\AlexaStreamingConfig;
use PHPUnit\Framework\TestCase;

class AlexaStreamingConfigTest extends TestCase
{
    public function testGetAppId()
    {
        $value = 'unit_test_GetAppId';
        $alexaStreamingConfig = new AlexaStreamingConfig();
        $alexaStreamingConfig->app_id = $value;
        $this->assertSame($value, $alexaStreamingConfig->getAppId());
    }

    public function testGetTitle()
    {
        $value = 'unit_test_GetTitle';
        $alexaStreamingConfig = new AlexaStreamingConfig();
        $alexaStreamingConfig->title = $value;
        $this->assertSame($value, $alexaStreamingConfig->getTitle());
    }

    public function testGetSubtitle()
    {
        $value = 'unit_test_GetSubtitle';
        $alexaStreamingConfig = new AlexaStreamingConfig();
        $alexaStreamingConfig->subtitle = $value;
        $this->assertSame($value, $alexaStreamingConfig->getSubtitle());
    }

    public function testGetStreamUrl()
    {
        $value = 'unit_test_GetStreamUrl';
        $alexaStreamingConfig = new AlexaStreamingConfig();
        $alexaStreamingConfig->stream_url = $value;
        $this->assertSame($value, $alexaStreamingConfig->getStreamUrl());
    }

    public function testGetArt()
    {
        $value = 'unit_test_GetArt';
        $alexaStreamingConfig = new AlexaStreamingConfig();
        $alexaStreamingConfig->art = $value;
        $this->assertSame($value, $alexaStreamingConfig->getArt());
    }

    public function testGetBackgroundImage()
    {
        $value = 'unit_test_GetBackgroundImage';
        $alexaStreamingConfig = new AlexaStreamingConfig();
        $alexaStreamingConfig->background_image = $value;
        $this->assertSame($value, $alexaStreamingConfig->getBackgroundImage());
    }

    public function testGetStreamToken()
    {
        $value = 'unit_test_GetStreamToken';
        $alexaStreamingConfig = new AlexaStreamingConfig();
        $alexaStreamingConfig->stream_token = $value;
        $this->assertSame($value, $alexaStreamingConfig->getStreamToken());
    }

    public function testGetLaunchMessage()
    {
        $value = 'unit_test_GetLaunchMessage';
        $alexaStreamingConfig = new AlexaStreamingConfig();
        $alexaStreamingConfig->launch_message = $value;
        $this->assertSame($value, $alexaStreamingConfig->getLaunchMessage());
    }
}
