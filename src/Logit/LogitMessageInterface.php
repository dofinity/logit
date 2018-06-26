<?php

namespace Logit;

interface LogitMessageInterface {

  /**
   * Submits the campaign to active trail.
   */
  public function sendLogMessage();

  /**
   * @param string $type
   * @return static
   */
  public function setLogType($type);

  /**
   * @param mixed $content
   * @return static
   */
  public function setLogContent($content);


}
