<?php

namespace Logit\Exception;

/**
 * Class NoApiKeyException
 * @package Logit\Exception
 */
class NoApiKeyException extends BaseException {

  const CODE = 50;

  /**
   * NoApiKeyException constructor.
   * @param string $message
   */
  public function __construct($message = 'Api Key not found.') {
    parent::__construct($message, static::CODE);
  }

}