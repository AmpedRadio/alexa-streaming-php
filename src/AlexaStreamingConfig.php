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

    function getAppId()
    {
        return $this->app_id;
    }

    function getTitle()
    {
        return $this->title;
    }

    function getSubtitle()
    {
        return $this->subtitle;
    }

    function getStreamUrl()
    {
        return $this->stream_url;
    }

    function getArt()
    {
        return $this->art;
    }

    function getBackgroundImage()
    {
        return $this->background_image;
    }

    function getStreamToken()
    {
        return $this->stream_token;
    }

}