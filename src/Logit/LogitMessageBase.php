<?php

namespace Logit;

use Logit\Rest\HttpClient;

/**
 * Class LogitMessage
 *
 * @package Logit
 */
abstract class LogitMessageBase extends LogitBase implements LogitMessageInterface, \JsonSerializable {

  protected $payload;

  protected $extra_headers;

  /**
   * ActiveTrailApi constructor.
   *
   * @param $api_token
   * @param $campaign_endpoint
   */
  public function __construct($api_token) {
    parent::__construct($api_token);

    $this->extra_headers = [];
  }

  /*
   * @todo Add endpoint and method parameters here...
   */
  public function send() {
    return $this->client->MakeLogitApiCall(
      null,
      null,
      $this->getMessage(),
      null,
      $this->extra_headers
    );
  }

  /**
   * {@inheritdoc}
   */
  public function setBody($body) {
    $this->getMessage()->body = $body;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreated($timestamp) {
    $this->getMessage()->created = $timestamp;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedWithMicroseconds() {
    $dt = new \DateTime();
    $time = microtime(true);
    $micro_time = sprintf("%03d",($time - floor($time)) * 1000);
    $dt->setTimestamp(microtime(true));
    $this->getMessage()->created = $dt->format('F jS Y, h:i:s.' . $micro_time);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setType($type) {
    $this->extra_headers['LogType'] = $type;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setSource($source) {
    $this->getMessage()->source = $source;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setTarget($target) {
    $this->getMessage()->target = $target;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setCode($code) {
    $this->getMessage()->code = $code;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setErrorMessage($errorMessage) {
    $this->getMessage()->errorMessage = $errorMessage;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setContext($context) {
    $this->getMessage()->context = $context;
    return $this;
  }

  /**
   * @return \JsonSerializable
   */
  abstract protected function getMessage();

  /**
   * {@inheritdoc}
   */
  public function jsonSerialize() {
    return $this->getMessage()->jsonSerialize();
  }

}
