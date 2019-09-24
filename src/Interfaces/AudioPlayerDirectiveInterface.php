<?php

namespace AmpedRadio\AlexaStreamingPHP\Interfaces;

interface AudioPlayerDirectiveInterface
{
    /* Get Directive Type */
    public function getType(): string;
}