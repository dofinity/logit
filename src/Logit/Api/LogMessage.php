<?php

namespace Logit\Api;

use Logit\JsonSerializableStruct;

/**
 * Class LogMessage
 */
class LogMessage extends JsonSerializableStruct {

  /**
   * @var string;
   */
  public $source;

  /**
   * @var string;
   */
  public $target;

  /**
   * @var string;
   */
  public $created;

  /**
   * @var mixed;
   */
  public $body;

  /**
   * @var string;
   */
  public $code;

}


