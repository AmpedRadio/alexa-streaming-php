<?php

namespace AmpedRadio\AlexaStreamingPHP;

class AlexaStreamingConfig
{
    public $app_id;

    public $title;

    public $subtitle;

    public $stream_url;

    public $art;

    public $background_image;

    public $stream_token;

    public function getAppId()
    {
        return $this->app_id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getSubtitle()
    {
        return $this->subtitle;
    }

    public function getStreamUrl()
    {
        return $this->stream_url;
    }

    public function getArt()
    {
        return $this->art;
    }

    public function getBackgroundImage()
    {
        return $this->background_image;
    }

    public function getStreamToken()
    {
        return $this->stream_token;
    }
}
