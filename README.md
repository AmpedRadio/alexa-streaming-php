<p align="center">
<a href="https://travis-ci.org/ampedradio/alexa-streaming-php"><img src="https://travis-ci.org/ampedradio/alexa-streaming-php.svg" alt="Build Status"></a>
<a href="https://codecov.io/gh/AmpedRadio/alexa-streaming-php"><img src="https://codecov.io/gh/AmpedRadio/alexa-streaming-php/branch/master/graph/badge.svg" /></a>
<a href="https://packagist.org/packages/ampedradio/alexa-streaming-php"><img src="https://poser.pugx.org/ampedradio/alexa-streaming-php/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/ampedradio/alexa-streaming-php"><img src="https://poser.pugx.org/ampedradio/alexa-streaming-php/v/unstable.svg" alt="Latest Unstable Version"></a>
<a href="https://packagist.org/packages/ampedradio/alexa-streaming-php"><img src="https://poser.pugx.org/ampedradio/alexa-streaming-php/license.svg" alt="License"></a>
</p>

# Alexa Streaming in PHP 

This library provides a simple way to create a streaming audio skill for the [Amazon Alexa](http://developer.amazon.com/alexa) platform. 

## Installation

The preferred method of installation is via [Packagist](https://packagist.org) and [Composer](https://getcomposer.org). Run the following command to install the package and add it as a requirement to your project's `composer.json`:

```bash
composer require ampedradio/alexa-streaming-php
```

## Alexa Skill Setup

Coming soon. Stay tuned.

## Example Usage

```php
use AmpedRadio\AlexaStreamingPHP\AlexaStreaming;
use AmpedRadio\AlexaStreamingPHP\AlexaStreamingConfig;
use Ramsey\Uuid\Uuid;

$config = new AlexaStreamingConfig();
$config->app_id = 'amzn1.ask.skill.xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
$config->stream_url = 'https://<stream-url>';
$config->title = 'Amped Radio';
$config->subtitle = 'Fueling The Original Social Network';
$config->art = 'https://<domain>/art.png';
$config->background_image = 'https://<domain>/background.png';
$config->stream_token = Uuid::uuid4();

$alexa = new AlexaStreaming($config);
$response = $alexa->execute();

header('Content-Type: application/json');
echo json_encode($response);
```
