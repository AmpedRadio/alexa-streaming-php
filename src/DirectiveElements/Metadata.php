<?php

namespace AmpedRadio\AlexaStreamingPHP\DirectiveElements;

use AmpedRadio\AlexaStreamingPHP\AlexaStreamingConfig;

/**
 * Metadata.
 *
 * The Metadata object is found as a child item inside of an AudioItem object. The purpose is
 * to transmit the text and images for a given audio item. In the context of a stream, this
 * will be static information as Alexa does not currently (as of Sept 2019) allow for the text
 * nor images to be updated while a stream is playing.
 *
 * Guidelines for images for Alexa-enabled devices with a screen
 * https://developer.amazon.com/docs/custom-skills/audioplayer-interface-reference.html#images
 *
 * Art Image
 *   - Recommended Minimum Size: 480 x 480 pixels
 *   - Echo Show/Fire TV Cube: Scaled to 300 x 300 and displayed as album art.
 *   - Echo Spot: Scaled to 480 x 480, cropped to a circle, and displayed as the background
 *                image with 70% opacity black scrim.
 *
 * Background image
 *   - Recommended Minimum Size: 1024 x 640 pixels
 *   - Echo Show/Fire TV Cube: Scaled to 1024 x 640 and displayed as a background image. Your
 *                             image is displayed as is on the Echo Show or Fire TV Cube, so
 *                             apply any fading effects in your source image if needed. For
 *                             instance, you could apply a 70% opacity black layer over your
 *                             image to give it a faded appearance and make the text stand out.
 *   - Echo Spot: Not used.
 */
class Metadata
{
    /** @var string $title */
    public $title;

    /** @var string $subtitle */
    public $subtitle;

    /** @var object $art */
    public $art;

    /** @var object $backgroundImage */
    public $backgroundImage;

    /**
     * Metadata constructor.
     *
     * @param AlexaStreamingConfig $config
     */
    public function __construct(AlexaStreamingConfig $config)
    {
        $this->title = $config->getTitle();
        $this->subtitle = $config->getSubtitle();
        $this->art = (object) [
            'sources' => [
                (object) [
                    'url' => $config->art,
                ],
            ],
        ];
        $this->backgroundImage = (object) [
            'sources' => [
                (object) [
                    'url' => $config->background_image,
                ],
            ],
        ];
    }
}
