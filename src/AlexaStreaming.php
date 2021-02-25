<?php

namespace AmpedRadio\AlexaStreamingPHP;

use Exception;
use Humps\AlexaRequest\AlexaRequestValidator;
use Nomisoft\Alexa\Request\AlexaRequest;
use Nomisoft\Alexa\Response\AlexaResponse;
use Nomisoft\Alexa\Response\OutputSpeech;

/**
 * Class AlexaStreaming.
 */
class AlexaStreaming
{
    /**
     * @var AlexaStreamingConfig
     */
    private $config;

    /**
     * @var AlexaRequestManager
     */
    private $requestManager;

    /**
     * AlexaStreaming constructor.
     *
     * @param AlexaStreamingConfig $config
     * @param bool                 $from_request
     * @param string|null          $json
     *
     * @throws Exception
     */
    public function __construct(AlexaStreamingConfig $config, bool $from_request = true, string $json = null)
    {
        $this->config = $config;
        $request = ($from_request) ? AlexaRequest::fromRequest() : new AlexaRequest($json);

        $this->requestManager = new AlexaRequestManager($config, $request);
    }

    /**
     * Is Valid Request.
     *
     * @param string $signatureCertChainUrl
     * @param string $signature
     *
     * @throws \Humps\AlexaRequest\Exceptions\AlexaValidationException
     *
     * @return bool
     */
    public function isValidRequest(string $signatureCertChainUrl, string $signature): bool
    {
        $validator = new AlexaRequestValidator(
            $this->config->app_id,
            $this->requestManager->getRequest()->getJson(),
            $signatureCertChainUrl,
            $signature
        );

        return $validator->validateRequest();
    }

    /**
     * Execute processing for Alexa Request and provide a response.
     *
     * @return AlexaResponse
     */
    public function execute()
    {
        try {
            return $this->requestManager->proceedRequest();
        } catch (Exception $e) {
            return $this->setOutputSpeech($e->getMessage());
        }
    }

    /**
     * Set Output Speech.
     *
     * @param string $message
     *
     * @return AlexaResponse
     */
    private function setOutputSpeech(string $message)
    {
        $speech = new OutputSpeech();
        $speech->setText("Sorry, we don't understand your request");

        $response = new AlexaResponse();
        $response->setOutputSpeech($message);

        return $response;
    }
}
