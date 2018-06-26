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

  public function send() {
    return $this->client->MakeLogitApiCall(
      $this->endpoint['uri'],
      $this->endpoint['method'],
      $this,
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
  public function setType($type) {
    $this->extra_headers[] = ['LogType' => $type];
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
