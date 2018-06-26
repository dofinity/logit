<?php

namespace Logit;

use Logit\Api\LogMessage;

/**
 * Class LogitMessage
 *
 * @package Logit
 */
class LogitMessage extends LogitMessageBase implements LogitMessageInterface {

  protected $messagePayload;

  protected $extra_headers;

  /**
   * LogitMessage constructor.
   *
   * @param $api_token
   */
  public function __construct($api_token) {
    parent::__construct($api_token);

    // Initialize payload structure
    $this->messagePayload = new LogMessage();

  }

  /**
   * @return \JsonSerializable
   */
  protected function getMessage() {
    return $this->messagePayload;
  }

}
