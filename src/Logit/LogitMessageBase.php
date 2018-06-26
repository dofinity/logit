<?php

namespace Logit;

use Logit\Rest\HttpClient;

/**
 * Class LogitMessageBase
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

  public function sendLogMessage() {
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
  public function setLogContent($content) {
    $this->payload = $content;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setLogType($type) {
    $this->extra_headers[] = ['LogType' => $type];
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function jsonSerialize() {
    return $this->getCampaign()->jsonSerialize();
  }

}
