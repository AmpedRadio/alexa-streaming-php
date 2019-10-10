<?php

namespace AmpedRadio\AlexaStreamingPHP\RequestStrategy;

use Nomisoft\Alexa\Request\AlexaRequest;

/**
 * Interface RequestStrategyInterface
 * Interface contract for request processing.
 */
interface RequestStrategyInterface
{
    /**
     * Proceed a request and return response.
     *
     * @param \Nomisoft\Alexa\Request\AlexaRequest $request
     *
     * @return mixed
     */
    public function proceed(AlexaRequest $request);
}
